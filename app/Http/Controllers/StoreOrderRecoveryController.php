<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\StoreCardPayment;
use App\Models\StoreCart;
use App\Models\StoreCustomer;
use App\Models\StoreOrder;
use App\Models\StoreOrderItem;
use App\Models\StoreOrderPlayerDetail;
use App\Models\StoreProduct;
use App\Models\StoreProductVariant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class StoreOrderRecoveryController extends Controller
{
    public function index(Request $request)
    {
        $orders = collect();
        $store = null;
        $searched = $request->filled('store_id') || $request->filled('email');

        if ($searched) {
            $validated = $request->validate([
                'store_id' => ['required', 'integer', 'exists:stores,id'],
                'email' => ['required', 'email'],
            ]);

            $storeId = (int) $validated['store_id'];
            $email = trim($validated['email']);
            $store = Store::find($storeId);

            $customerIds = StoreCustomer::where('store_id', $storeId)
                ->whereRaw('LOWER(email) = ?', [mb_strtolower($email)])
                ->pluck('id');

            if ($customerIds->isNotEmpty()) {
                $orders = StoreOrder::with([
                    'CustomerDetails',
                    'OrderItems',
                    'paymentDetails',
                ])
                    ->where('store_id', $storeId)
                    ->whereIn('store_customer_id', $customerIds)
                    ->orderByDesc('id')
                    ->get()
                    ->map(function (StoreOrder $order) {
                        $customer = $order->CustomerDetails;
                        $cartCount = 0;
                        $cartDetailCount = 0;

                        if ($customer && $customer->session_id) {
                            $carts = StoreCart::with('StoreCartItems')
                                ->where('store_id', $order->store_id)
                                ->where('session_id', $customer->session_id)
                                ->get();

                            $cartCount = $carts->count();
                            $cartDetailCount = $carts->sum(function ($cart) {
                                return $cart->StoreCartItems->count();
                            });
                        }

                        $payment = $this->paymentSummary($order);
                        $itemCount = $order->OrderItems->count();

                        $order->setAttribute('recovery_meta', [
                            'payment_verified' => $payment['verified'],
                            'net_paid' => $payment['net_paid'],
                            'transaction_id' => $payment['transaction_id'],
                            'item_count' => $itemCount,
                            'cart_count' => $cartCount,
                            'cart_detail_count' => $cartDetailCount,
                            'eligible' => $payment['verified'] && $itemCount === 0 && $cartCount > 0 && $cartDetailCount > 0,
                        ]);

                        return $order;
                    });
            }
        }

        return view('pages.store_order_recovery.index', [
            'orders' => $orders,
            'store' => $store,
            'searched' => $searched,
            'storeId' => $request->input('store_id'),
            'email' => $request->input('email'),
        ]);
    }

    public function restore(Request $request, int $orderId)
    {
        $validated = $request->validate([
            'store_id' => ['required', 'integer'],
            'email' => ['required', 'email'],
        ]);

        $storeId = (int) $validated['store_id'];
        $email = trim($validated['email']);

        try {
            $result = DB::transaction(function () use ($orderId, $storeId, $email) {
                $order = StoreOrder::whereKey($orderId)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ((int) $order->store_id !== $storeId) {
                    throw new \RuntimeException('The selected order does not belong to this store.');
                }

                $customer = StoreCustomer::whereKey($order->store_customer_id)
                    ->lockForUpdate()
                    ->first();

                if (!$customer) {
                    throw new \RuntimeException('The order customer could not be found.');
                }

                if (mb_strtolower(trim((string) $customer->email)) !== mb_strtolower($email)) {
                    throw new \RuntimeException('The selected order does not belong to this customer email.');
                }

                $payment = $this->paymentSummary($order);

                if (!$payment['verified']) {
                    throw new \RuntimeException('Restore blocked because a successful, non-refunded payment could not be verified.');
                }

                $existingItems = StoreOrderItem::where('store_order_id', $order->id)
                    ->lockForUpdate()
                    ->get();

                if ($existingItems->isNotEmpty()) {
                    throw new \RuntimeException('Restore blocked because this order already has order items.');
                }

                if (!$customer->session_id) {
                    throw new \RuntimeException('The customer session ID is missing, so the original cart cannot be located.');
                }

                $carts = StoreCart::with('StoreCartItems')
                    ->where('store_id', $order->store_id)
                    ->where('session_id', $customer->session_id)
                    ->lockForUpdate()
                    ->get();

                if ($carts->isEmpty()) {
                    throw new \RuntimeException('No remaining cart items were found for this customer and store.');
                }

                $products = StoreProduct::with('priceAdditions')
                    ->whereIn('id', $carts->pluck('store_product_id')->filter()->unique())
                    ->get()
                    ->keyBy('id');

                $createdOrderItems = 0;
                $createdPlayerDetails = 0;

                foreach ($carts as $cart) {
                    $product = $products->get($cart->store_product_id);

                    if (!$product) {
                        throw new \RuntimeException('Store product #' . $cart->store_product_id . ' could not be found. Nothing was changed.');
                    }

                    if ($cart->StoreCartItems->isEmpty()) {
                        throw new \RuntimeException('Cart #' . $cart->id . ' has no item details. Nothing was changed.');
                    }

                    $orderItem = new StoreOrderItem();
                    $orderItem->store_order_id = $order->id;
                    $orderItem->store_product_id = $cart->store_product_id;
                    $orderItem->store_id = $cart->store_id;
                    $orderItem->qty = $cart->qty;
                    $orderItem->save();
                    $createdOrderItems++;

                    $subTeam = !empty($cart->sub_team) ? $cart->sub_team : null;
                    $unitPrice = (float) $product->default_price
                        + (float) $product->priceAdditions->sum('addition_amount');

                    foreach ($cart->StoreCartItems as $cartItem) {
                        $detail = new StoreOrderPlayerDetail();
                        $detail->store_id = $cartItem->store_id;
                        $detail->sub_team = $subTeam;
                        $detail->store_order_item_id = $orderItem->id;
                        $detail->store_product_id = $orderItem->store_product_id;

                        $variant = null;
                        if (!empty($cartItem->product_variant)) {
                            $variant = StoreProductVariant::where('variant_value', $cartItem->product_variant)->first();
                        }

                        if ($variant) {
                            $detail->color = $variant->id;
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
                        $createdPlayerDetails++;
                    }
                }

                if ($createdOrderItems === 0 || $createdPlayerDetails === 0) {
                    throw new \RuntimeException('No order item data was created. Nothing was changed.');
                }

                // IMPORTANT: recovery is copy-only for cart data.
                // Never delete or modify store_carts / store_cart_items here.
                // The original customer cart must remain exactly as it was.

                $order->active = 1;
                $order->is_payment_success = 1;
                $order->save();

                $customer->is_ordered = 1;
                $customer->save();

                return [
                    'order_no' => $order->order_no,
                    'order_items' => $createdOrderItems,
                    'player_details' => $createdPlayerDetails,
                ];
            }, 3);

            return redirect()
                ->route('store-order-recovery.index', [
                    'store_id' => $storeId,
                    'email' => $email,
                ])
                ->with('success', sprintf(
                    'Order %s restored successfully: %d order item(s) and %d item detail(s) created. The cart was not changed.',
                    $result['order_no'],
                    $result['order_items'],
                    $result['player_details']
                ));
        } catch (Throwable $e) {
            Log::error('Store order item recovery failed', [
                'order_id' => $orderId,
                'store_id' => $storeId,
                'email' => $email,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('store-order-recovery.index', [
                    'store_id' => $storeId,
                    'email' => $email,
                ])
                ->with('error', $e->getMessage());
        }
    }

    private function paymentSummary(StoreOrder $order): array
    {
        $payments = StoreCardPayment::where('store_order_no', $order->order_no)
            ->where('is_success', 1)
            ->orderByDesc('id')
            ->get();

        $charges = $payments->where('is_refund', 0);
        $refunds = $payments->where('is_refund', 1);

        $paid = (float) $charges->sum('payment_amount');
        $refunded = (float) $refunds->sum('payment_amount');
        $netPaid = $paid - $refunded;

        $zeroPayment = $charges->contains(function ($payment) {
            return $payment->transaction_id === 'ZERO_PAYMENT';
        });

        $verified = (int) $order->is_payment_success === 1
            && $charges->isNotEmpty()
            && ($netPaid > 0 || $zeroPayment);

        return [
            'verified' => $verified,
            'net_paid' => $netPaid,
            'transaction_id' => optional($charges->first())->transaction_id,
        ];
    }
}
