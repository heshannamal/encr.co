<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\StoreCardPayment;
use App\Models\StoreCart;
use App\Models\StoreCustomer;
use App\Models\StoreOrder;
use App\Models\StoreOrderItem;
use App\Models\StoreOrderPlayerDetail;
use App\Models\StoreOrderReceipt;
use App\Models\StoreProductVariant;
use App\Models\StoreProductPriceAddition;
use App\Models\StoreCoupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class StoreOrderRecoveryController extends Controller
{
    /**
     * Show every store order that does not yet have a StoreOrderReceipt.
     * Each order is expanded on demand and shows the current cart rows that
     * belong to the order owner's customer email.
     */
    public function index(Request $request)
    {
        $storeId = $request->filled('store_id') ? (int) $request->input('store_id') : null;
        $email = trim((string) $request->input('email', ''));

        $receiptTable = (new StoreOrderReceipt())->getTable();
        $orderTable = (new StoreOrder())->getTable();

        $query = StoreOrder::with([
            'CustomerDetails',
            'OrderItems',
            'paymentDetails',
        ])
            ->whereNotNull('store_customer_id')
            ->whereNotExists(function ($q) use ($receiptTable, $orderTable) {
                $q->select(DB::raw(1))
                    ->from($receiptTable)
                    ->whereColumn($receiptTable . '.store_order_no', $orderTable . '.order_no')
                    ->whereColumn($receiptTable . '.store_id', $orderTable . '.store_id');
            });

        if ($storeId) {
            $query->where($orderTable . '.store_id', $storeId);
        }

        $orders = $query
            ->orderByDesc($orderTable . '.id')
            ->get();

        if ($email !== '') {
            $emailLower = mb_strtolower($email);

            $orders = $orders->filter(function (StoreOrder $order) use ($emailLower) {
                $customerEmail = mb_strtolower(
                    trim((string) optional($order->CustomerDetails)->email)
                );

                return $customerEmail === $emailLower;
            })->values();
        }

        $rows = collect();
        $storeCache = [];

        foreach ($orders as $order) {
            $customer = $order->CustomerDetails;

            if (!$customer || empty($customer->email)) {
                continue;
            }

            /*
             * A customer can have more than one StoreCustomer row/session for the
             * same email. Search all sessions so older carts can also be recovered.
             */
            $sessionIds = StoreCustomer::where('store_id', $order->store_id)
                ->whereRaw('LOWER(email) = ?', [mb_strtolower(trim((string) $customer->email))])
                ->whereNotNull('session_id')
                ->where('session_id', '<>', '')
                ->pluck('session_id')
                ->unique()
                ->values();

            $carts = collect();

            if ($sessionIds->isNotEmpty()) {
                $carts = StoreCart::with([
                    'StoreCartItems',
                    'storeProduct.priceAdditions',
                ])
                    ->where('store_id', $order->store_id)
                    ->whereIn('session_id', $sessionIds)
                    ->orderBy('id')
                    ->get();
            }

            /*
             * For every cart product determine whether that product is already
             * represented by a StoreOrderItem in this order.
             */
            $cartRows = $carts->map(function ($cart) use ($order) {
                $existingOrderItem = $this->findMatchingOrderItem($order, $cart);

                return [
                    'cart' => $cart,
                    'existing_order_item' => $existingOrderItem,
                    'action' => $existingOrderItem ? 'update' : 'add',
                ];
            })->values();

            // Recovery page should show only receipt-less orders whose customer
            // still has cart products available for this store.
            if ($cartRows->isEmpty()) {
                continue;
            }

            if (!isset($storeCache[$order->store_id])) {
                $storeCache[$order->store_id] = Store::find($order->store_id);
            }

            $payment = $this->paymentSummary($order);

            $rows->push([
                'order' => $order,
                'customer' => $customer,
                'store' => $storeCache[$order->store_id],
                'payment' => $payment,
                'cart_rows' => $cartRows,
                'cart_count' => $cartRows->count(),
                'missing_count' => $cartRows->where('action', 'add')->count(),
                'existing_count' => $cartRows->where('action', 'update')->count(),
                'eligible' => $payment['verified'],
                'can_create_receipt' => $order->OrderItems->isNotEmpty()
                    && $cartRows->where('action', 'add')->count() === 0,
            ]);
        }

        return view('pages.store_order_recovery.index', [
            'rows' => $rows,
            'storeId' => $storeId,
            'email' => $email,
        ]);
    }

    /**
     * Add one cart product to an order, or update the already-existing order
     * item for that cart product. Cart records are intentionally never deleted.
     */
    public function syncCartItem(Request $request, int $orderId, int $cartId)
    {
        try {
            $result = DB::transaction(function () use ($orderId, $cartId) {
                $order = StoreOrder::with('CustomerDetails')
                    ->whereKey($orderId)
                    ->lockForUpdate()
                    ->firstOrFail();

                $customer = $order->CustomerDetails;

                if (!$customer || empty($customer->email)) {
                    throw new \RuntimeException('The order customer could not be found.');
                }

                $receiptExists = StoreOrderReceipt::where('store_id', $order->store_id)
                    ->where('store_order_no', $order->order_no)
                    ->exists();

                if ($receiptExists) {
                    throw new \RuntimeException('This order already has a receipt and is no longer available for recovery.');
                }

                $payment = $this->paymentSummary($order);

                if (!$payment['verified']) {
                    throw new \RuntimeException('Item recovery is blocked because a successful, non-refunded payment could not be verified.');
                }

                $sessionIds = StoreCustomer::where('store_id', $order->store_id)
                    ->whereRaw('LOWER(email) = ?', [mb_strtolower(trim((string) $customer->email))])
                    ->whereNotNull('session_id')
                    ->where('session_id', '<>', '')
                    ->pluck('session_id')
                    ->unique()
                    ->values();

                if ($sessionIds->isEmpty()) {
                    throw new \RuntimeException('No cart session was found for this customer.');
                }

                $cart = StoreCart::with([
                    'StoreCartItems',
                    'storeProduct.priceAdditions',
                ])
                    ->whereKey($cartId)
                    ->where('store_id', $order->store_id)
                    ->whereIn('session_id', $sessionIds)
                    ->lockForUpdate()
                    ->first();

                if (!$cart) {
                    throw new \RuntimeException('The selected cart product does not belong to this order customer.');
                }

                $product = $cart->storeProduct;

                if (!$product) {
                    throw new \RuntimeException('Store product #' . $cart->store_product_id . ' could not be found.');
                }

                $orderItem = $this->findMatchingOrderItem($order, $cart, true);
                $mode = $orderItem ? 'updated' : 'added';

                if (!$orderItem) {
                    $orderItem = new StoreOrderItem();
                    $orderItem->store_order_id = $order->id;
                }

                $orderItem->store_product_id = $cart->store_product_id;
                $orderItem->store_id = $cart->store_id;
                $orderItem->qty = $cart->qty;
                $orderItem->save();

                /*
                 * Keep the same StoreOrderItem record when updating. Its detail rows
                 * are rebuilt from the current cart so the order mirrors the cart.
                 */
                StoreOrderPlayerDetail::where('store_order_item_id', $orderItem->id)->delete();

                $subTeam = !empty($cart->sub_team) ? $cart->sub_team : null;
                $unitPrice = (float) ($product->default_price ?? 0)
                    + (float) $product->priceAdditions->sum('addition_amount');

                $detailCount = 0;

                foreach ($cart->StoreCartItems as $cartItem) {
                    $detail = new StoreOrderPlayerDetail();
                    $detail->store_id = $cartItem->store_id;
                    $detail->sub_team = $subTeam;
                    $detail->store_order_item_id = $orderItem->id;
                    $detail->store_product_id = $orderItem->store_product_id;

                    if (!empty($cartItem->product_variant)) {
                        $variant = StoreProductVariant::where('variant_value', $cartItem->product_variant)->first();

                        if ($variant) {
                            $detail->color = $variant->id;
                        }
                    }

                    $detail->size = $cartItem->size_id;
                    $detail->player_number = $cartItem->custom_number ?? null;
                    $detail->player_name = $cartItem->custom_name ?? null;
                    $detail->qty = $cartItem->qty;
                    $detail->unit_price = $unitPrice;
                    $detail->total_amount = $unitPrice * (int) $cartItem->qty;
                    $detail->paid_amount = $unitPrice * (int) $cartItem->qty;
                    $detail->is_number_available = $product->set_individual_number;
                    $detail->is_name_available = $product->set_individual_name;
                    $detail->order_date = Carbon::now()->format('d/m/Y');
                    $detail->save();
                    $detailCount++;
                }

                /*
                 * Recovery is ITEM-ONLY.
                 * Do NOT update StoreOrder totals, paid fields, payment flags,
                 * shipping fields, active status, or StoreCustomer status.
                 * Do NOT delete StoreCart / StoreCartItems.
                 * Do NOT create StoreOrderReceipt here.
                 */

                return [
                    'mode' => $mode,
                    'order_no' => $order->order_no,
                    'product_name' => $product->product_name ?? ('Product #' . $cart->store_product_id),
                    'detail_count' => $detailCount,
                ];
            }, 3);

            $message = $result['mode'] === 'updated'
                ? 'Order item updated successfully.'
                : 'Cart item added to order successfully.';

            return redirect()
                ->route('store-order-recovery.index', $this->returnFilters($request))
                ->with('success', sprintf(
                    '%s Order %s — %s (%d detail row%s). Cart records were not deleted.',
                    $message,
                    $result['order_no'],
                    $result['product_name'],
                    $result['detail_count'],
                    $result['detail_count'] === 1 ? '' : 's'
                ));
        } catch (Throwable $e) {
            Log::error('Store order cart-item recovery failed', [
                'order_id' => $orderId,
                'cart_id' => $cartId,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('store-order-recovery.index', $this->returnFilters($request))
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Create the first receipt for a recovered order.
     * This is intentionally one-time only. Once created, the order no longer
     * appears on the recovery page because index() lists receipt-less orders.
     */
    public function createFirstReceipt(Request $request, int $orderId)
    {
        try {
            $result = DB::transaction(function () use ($orderId) {
                $order = StoreOrder::with([
                    'CustomerDetails',
                    'OrderItems.productDetails.images',
                ])
                    ->whereKey($orderId)
                    ->lockForUpdate()
                    ->firstOrFail();

                $receiptExists = StoreOrderReceipt::where('store_id', $order->store_id)
                    ->where('store_order_no', $order->order_no)
                    ->lockForUpdate()
                    ->exists();

                if ($receiptExists) {
                    throw new \RuntimeException('A receipt already exists for this order. The first receipt can only be created once.');
                }

                if ($order->OrderItems->isEmpty()) {
                    throw new \RuntimeException('Receipt creation is blocked because this order does not have any order items yet.');
                }

                $customer = $order->CustomerDetails;

                if (!$customer || empty($customer->email)) {
                    throw new \RuntimeException('The order customer could not be found.');
                }

                /*
                 * Before sealing the recovery with its first receipt, make sure
                 * every current cart product for this customer is represented by
                 * an order item. Otherwise remaining cart rows would become hidden
                 * from this recovery page after the receipt is created.
                 */
                $sessionIds = StoreCustomer::where('store_id', $order->store_id)
                    ->whereRaw('LOWER(email) = ?', [mb_strtolower(trim((string) $customer->email))])
                    ->whereNotNull('session_id')
                    ->where('session_id', '<>', '')
                    ->pluck('session_id')
                    ->unique()
                    ->values();

                if ($sessionIds->isNotEmpty()) {
                    $carts = StoreCart::with('StoreCartItems')
                        ->where('store_id', $order->store_id)
                        ->whereIn('session_id', $sessionIds)
                        ->orderBy('id')
                        ->get();

                    foreach ($carts as $cart) {
                        if (!$this->findMatchingOrderItem($order, $cart)) {
                            throw new \RuntimeException(
                                'Receipt creation is blocked because cart #' . $cart->id . ' has not been added to the order yet.'
                            );
                        }
                    }
                }

                $orderData = [
                    'order_items' => [],
                ];

                foreach ($order->OrderItems as $orderItem) {
                    $product = $orderItem->productDetails;

                    $priceAddition = 0.00;
                    $defaultPrice = 0.00;
                    $productName = 'Unknown Product';
                    $imageUrl = asset('public/images/default.png');

                    if ($product) {
                        $productName = $product->product_name ?? 'Unknown Product';
                        $defaultPrice = (float) ($product->default_price ?? 0);
                        $priceAddition = (float) StoreProductPriceAddition::where(
                            'store_product_id',
                            $product->id
                        )->sum('addition_amount');

                        if ($product->images && $product->images->isNotEmpty()) {
                            $imageUrl = asset($product->images->first()->url);
                        }
                    }

                    $unitPrice = $defaultPrice + $priceAddition;
                    $qty = (float) ($orderItem->qty ?? 0);
                    $itemSizes = [];

                    /*
                     * Do not load SizeDetails here. Some legacy rows can trigger
                     * the Eloquent Builder ->id exception in that relationship.
                     * The receipt safely stores the raw size value instead.
                     */
                    $details = StoreOrderPlayerDetail::where(
                        'store_order_item_id',
                        $orderItem->id
                    )->get();

                    foreach ($details as $detail) {
                        $itemSizes[$detail->id] = [
                            'size' => $detail->size ?? '',
                            'qty' => $detail->qty ?? 0,
                            'player_name' => $detail->player_name ?? '',
                            'player_number' => $detail->player_number ?? '',
                            'sub_team' => $detail->sub_team ?? '',
                        ];
                    }

                    $orderData['order_items'][] = [
                        'qty' => $qty,
                        'product_name' => $productName,
                        'image_url' => $imageUrl,
                        'price' => $unitPrice,
                        'total_price' => $qty * $unitPrice,
                        'item_sizes' => $itemSizes,
                    ];
                }

                $orderData['order_details'] = [
                    'sub_total' => $order->sub_total,
                    'shipping' => $order->shipping,
                    'handling_fee' => $order->handling_fee,
                    'sales_tax' => $order->sales_tax,
                    'total' => $order->total,
                    'paid_invoice_amount' => $order->paid_invoice_amount,
                    'paid_processing_fee' => $order->paid_processing_fee,
                    'paid_amount' => $order->paid_amount,
                    'is_shipping_removed' => (bool) ($order->is_shipping_removed ?? false),
                    'removed_items' => [],
                    'order_change_notes' => [],
                    'item_change_log' => [],
                    'notes' => $order->notes,
                    'tracking_no' => $order->tracking_no,
                    'tracking_link' => $order->tracking_link,
                    'order_discount' => $order->discount,
                    'coupon_code' => $order->coupon_code,
                    'coupon_details' => $order->coupon_code
                        ? StoreCoupon::where('store_id', $order->store_id)
                            ->where('coupon_code', $order->coupon_code)
                            ->first()
                        : null,
                ];

                $shippingMethodName = 'Direct Ship to Customers';
                if ($order->shippingMethodDetails) {
                    $shippingMethodName = $order->shippingMethodDetails->shipping_method_name
                        ?? $shippingMethodName;
                }

                $orderData['shipping_details'] = [
                    'first_name' => $order->first_name,
                    'last_name' => $order->last_name,
                    'street' => $order->street,
                    'city' => $order->city,
                    'state' => $order->state,
                    'postal_code' => $order->postal_code,
                    'country' => $order->country,
                    'phone' => $order->phone,
                    'email' => $order->email,
                    'shipping_method' => $shippingMethodName,
                ];

                $orderData['customer_details'] = $customer ? [
                    'first_name' => $customer->first_name,
                    'last_name' => $customer->last_name,
                    'street' => $customer->street,
                    'city' => $customer->city,
                    'state' => $customer->state,
                    'postal_code' => $customer->postal_code,
                    'country' => $customer->country,
                    'phone' => $customer->phone_number,
                    'email' => $customer->email,
                ] : null;

                $receipt = new StoreOrderReceipt();
                $receipt->store_id = $order->store_id;
                $receipt->store_order_no = $order->order_no;
                $receipt->order_items = json_encode($orderData['order_items']);
                $receipt->order_details = json_encode($orderData['order_details']);
                $receipt->shipping_details = json_encode($orderData['shipping_details']);
                $receipt->customer_details = $orderData['customer_details']
                    ? json_encode($orderData['customer_details'])
                    : null;
                $receipt->save();

                return [
                    'order_no' => $order->order_no,
                    'receipt_id' => $receipt->id,
                ];
            }, 3);

            return redirect()
                ->route('store-order-recovery.index', $this->returnFilters($request))
                ->with('success', sprintf(
                    'First receipt #%d created successfully for order %s. This order is now removed from the recovery list.',
                    $result['receipt_id'],
                    $result['order_no']
                ));
        } catch (Throwable $e) {
            Log::error('Store order first receipt creation failed', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('store-order-recovery.index', $this->returnFilters($request))
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Find the StoreOrderItem that represents a StoreCart row.
     * Usually store_product_id is enough. If duplicate product rows exist in
     * the same order, prefer the row whose player details use the same sub_team.
     */
    private function findMatchingOrderItem(StoreOrder $order, StoreCart $cart, bool $lock = false)
    {
        $query = StoreOrderItem::where('store_order_id', $order->id)
            ->where('store_product_id', $cart->store_product_id)
            ->orderBy('id');

        if ($lock) {
            $query->lockForUpdate();
        }

        $candidates = $query->get();

        if ($candidates->isEmpty()) {
            return null;
        }

        if ($candidates->count() === 1) {
            return $candidates->first();
        }

        $subTeam = trim((string) ($cart->sub_team ?? ''));

        if ($subTeam !== '') {
            foreach ($candidates as $candidate) {
                $matchesSubTeam = StoreOrderPlayerDetail::where('store_order_item_id', $candidate->id)
                    ->where('sub_team', $subTeam)
                    ->exists();

                if ($matchesSubTeam) {
                    return $candidate;
                }
            }
        }

        return $candidates->first();
    }

    private function returnFilters(Request $request): array
    {
        $filters = [];

        if ($request->filled('return_store_id')) {
            $filters['store_id'] = (int) $request->input('return_store_id');
        }

        if ($request->filled('return_email')) {
            $filters['email'] = trim((string) $request->input('return_email'));
        }

        return $filters;
    }

    private function paymentSummary(StoreOrder $order): array
    {
        // Keep every payment row for display. Verification still uses only
        // successful rows and subtracts successful refunds from charges.
        $records = StoreCardPayment::where('store_order_no', $order->order_no)
            ->orderByDesc('id')
            ->get();

        $successful = $records->where('is_success', 1);
        $charges = $successful->where('is_refund', 0);
        $refunds = $successful->where('is_refund', 1);

        $paid = (float) $charges->sum('payment_amount');
        $refunded = (float) $refunds->sum('payment_amount');
        $netPaid = $paid - $refunded;
        $processingFees = (float) $charges->sum('processing_fee');
        $totalCharged = (float) $charges->sum('total_amount');

        /* CustomerOnlinePayment() stores zero payments as ZERO_<order_no>. */
        $zeroPayment = $charges->contains(function ($payment) {
            return strpos((string) $payment->transaction_id, 'ZERO_') === 0;
        });

        $verified = (int) $order->is_payment_success === 1
            && $charges->isNotEmpty()
            && ($netPaid > 0 || $zeroPayment);

        return [
            'verified' => $verified,
            'net_paid' => $netPaid,
            'paid' => $paid,
            'refunded' => $refunded,
            'processing_fees' => $processingFees,
            'total_charged' => $totalCharged,
            'transaction_id' => optional($charges->first())->transaction_id,
            'records' => $records,
        ];
    }
}

