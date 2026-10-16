<?php

namespace App\Http\Controllers;

use ZipArchive;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Services\ShippoService;
use Illuminate\Http\Request;
use App\Models\StoreShipment;
use App\Models\StoreOrder;
use App\Models\StoreCart;
use App\Models\Store;
use App\Models\StoreCustomer;
use App\Http\Controllers\StoreController;


class ShippoController extends Controller
{
    protected $shippoService;

    public function __construct(ShippoService $shippoService)
    {
        $this->shippoService = $shippoService;
    }

    public function createOrder($order_no){

        $order = StoreOrder::with('OrderItems')->where('order_no', $order_no)->firstOrFail();

        if ($order->shippo_order_id) {
            return redirect()->back()->with('error', 'Order created already.');
        }

            $lineItems = [];
            $totalPrice = 0;
            $weight = 0;

            foreach ($order->OrderItems as $item) {
                $product = $item->productDetails;
                $itemDetails = $item->OrderItemDetails[0];

                $itemWeight = $product->shipping_weight ?? 0.1;
                $itemQty = $itemDetails->qty ?? 1;
                $itemPrice = ($product->default_price + $product->priceAdditions->sum('addition_amount')) * $itemQty;

                $lineItems[] = [
                    'title' => $product->product_name ?? 'No name',
                    'quantity' => $itemQty,
                    'weight' => $itemWeight,
                    'weight_unit' => 'oz',
                    'sku' => 'TS-123',
                    'value' => $product->default_price + $product->priceAdditions->sum('addition_amount'),
                    'currency' => 'USD',
                    'description' => substr(
                        preg_replace('/\s+/', ' ', strip_tags($item['description'] ?? 'Product')),
                        0,
                        150
                    ),
                    'length' => 10,
                    'width' => 10,
                    'height' => 5,
                    'distance_unit' => 'in',
                    'mass_unit' => 'oz',
                ];

                $totalPrice += $itemPrice;
                $weight += ($itemWeight * $itemQty);
            }

            $orderData = [
                'to_address' => [
                    'name' => $order->first_name . ' ' . $order->last_name,
                    'street1' => $order->street,
                    'city' => $order->city,
                    'state' => $order->state,
                    'zip' => $order->postal_code,
                    'country' => $order->country,
                    'email' => $order->email,
                    'phone' => $order->phone
                ],
                'from_address' => [
                    'name' => 'Encore Custom',
                    'company' => 'Encore Custom',
                    'street1' => '891 4th St.',
                    'city' => 'San Rafael',
                    'state' => 'CA',
                    'zip' => '94901',
                    'country' => 'USA',
                    'phone' => '+1 888-501-4999',
                    'email' => 'info@encorecustom.com',
                ],
                'line_items' => $lineItems,
                'weight' => $weight,
                'weight_unit' => 'oz',
                'placed_at' => $order->created_at->toIso8601String(),
                'order_number' => $order->order_no,
                'subtotal_price' => $totalPrice,
                'total_price' => $totalPrice,
                'currency' => 'USD',
                'order_status' => 'PAID',
                'test' => env('SHIPPO_IS_TEST'),
            ];

            $shippoResponse = $this->shippoService->createOrder($orderData);

            if (isset($shippoResponse['shippo_order']['object_id'])) {
                $order->shippo_order_id = $shippoResponse['shippo_order']['object_id'];
                $order->shippo_order_status = $shippoResponse['status'] == "success" ? 1 : 0;
                $order->save();

                return redirect()->back()->with('success', 'Order created successfully.');

            } else {
                return redirect()->back()->with('error', 'Shippo order ID is missing for this order.');
            }
    }

    public function createShipment($order_no)
    {
        $order = StoreOrder::with('OrderItems', 'ShipmentDetails')->where('order_no', $order_no)->first();

        $store = Store::with('contactCoachesDetails')->find($order->store_id);

        if (!$store) {
            return redirect()->back()->with('error', 'Store not found.');
        }

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        if (optional($order->ShipmentDetails)->isNotEmpty()) {
            return redirect()->back()->with('error', 'Shipment already created for this order.');
        }

        $lineItems = [];
        $totalPrice = 0;
        $weight = 0;

        foreach ($order->OrderItems as $item) {

            $product = $item->productDetails;

            if (!$product) {
                return redirect()->back()->with('error', 'Incomplete product or item details found.');
            }

            $itemQty = (int) $item->qty ?: 1;
            $itemWeight = (float) $product->shipping_weight ?: 5;
            $itemTotalPrice  = ($product->default_price + $product->priceAdditions->sum('addition_amount')) * $itemQty;

            $weight += ($itemWeight * $itemQty);

            $lineItems[] = [
                'title'         => $product->product_name ?? 'No name',
                'quantity'      => $itemQty,
                'weight'        => $itemWeight,
                'weight_unit'   => 'oz',
                'sku'           => $product->sku ?? 'TS-123',
                'value'         => $product->default_price + $product->priceAdditions->sum('addition_amount'),
                'total_price'   => $itemTotalPrice,
                'currency'      => 'USD',
                'description'   => substr(preg_replace('/\s+/', ' ', strip_tags($item['description'] ?? 'Product')), 0, 150),
                'length'        => 10,
                'width'         => 10,
                'height'        => 5,
                'distance_unit' => 'in',
            ];

            $totalPrice += $itemTotalPrice;
        }

        if($order->shipping_method == 1){
            $address_to = [
                'name' => $order->first_name . ' ' . $order->last_name,
                'street1' => $order->street,
                'city' => $order->city,
                'state' => $order->state,
                'zip' => $order->postal_code,
                'country' => $order->country,
                'email' => $order->email,
                'phone' => $order->phone
            ];

        }else{
            $address_to = [
                'name'    => 'Encore Custom',
                'street1' => '891 4th St.',
                'city'    => 'San Rafael',
                'state'   => 'CA',
                'zip'     => '94901',
                'country' => 'USA',
                'phone'   => '+1 888-501-4999',
                'email'   => 'info@encorecustom.com'
            ];
        }

        $orderData = [
            'to_address'    => $address_to,
            'from_address'  => [
                'name'    => 'Encore Custom',
                'company' => 'Encore Custom',
                'street1' => '891 4th St.',
                'city'    => 'San Rafael',
                'state'   => 'CA',
                'zip'     => '94901',
                'country' => 'USA',
                'phone'   => '+1 888-501-4999',
                'email'   => 'info@encorecustom.com',
            ],
            'line_items'    => $lineItems,
            'weight'        => $weight,
            'weight_unit'   => 'oz',
            'placed_at'     => $order->created_at->toIso8601String(),
            'order_number'  => $order->order_no,
            'subtotal_price'=> $totalPrice,
            'total_price'   => $order->total,
            'currency'      => 'USD',
            'async'         => true,
            'test'          => env('SHIPPO_IS_TEST'),
        ];

        $shippoResponse = $this->shippoService->createOrder($orderData);

        if (($shippoResponse['status'] ?? null) === 'error') {
            return redirect()->back()->with('error', $shippoResponse['message'] ?? 'Shippo returned an error.');
        }

        if (!isset($shippoResponse['shippo_order']['object_id'])) {
            return redirect()->back()->with('error', 'Failed to create Shippo order.');
        }

        $order->shippo_order_id = $shippoResponse['shippo_order']['object_id'];
        $order->shippo_order_status = $shippoResponse['status'] === "success" ? 1 : 0;
        $order->save();

        if (StoreShipment::where('store_order_no', $order_no)->exists()) {
            return redirect()->back()->with('error', 'Shipment already exists for this order.');
        }

        $orderDetails = $this->shippoService->orderDetail($order->shippo_order_id);

        if (!isset($orderDetails['id'])) {
            return redirect()->back()->with('error', 'Failed to fetch order details from Shippo.');
        }

        $shipmentData = [
            'address_from' => $orderDetails['from_address'],
            'address_to'   => $orderDetails['to_address'],
            'parcels' => [
                [
                    'weight' => $weight > 0 ? $weight : 1.0,
                    'mass_unit' => 'oz',
                    'length' => 10,
                    'width' => 10,
                    'height' => 10,
                    'distance_unit' => 'in',
                ]
            ],
            'async' => true,
            'carrier_accounts' => [env('CAREER_ACC_ID')],
            'test' => env('SHIPPO_IS_TEST'),
        ];

        $shipment = $this->shippoService->createShipment($shipmentData, $lineItems);

        dd($shipment);

        if (!isset($shipment['object_id'])) {
            return redirect()->back()->with('error', 'Failed to create shipment.');
        }

        $shipmentRates = $shipment['rates'] ?? [];

        if (empty($shipmentRates) || !isset($shipmentRates[0]['object_id'])) {
            return redirect()->back()->with('error', 'No available shipping rates for this shipment.');
        }

        $rates = collect($shipmentRates)->sortBy('amount')->values();
        $cheapestRate = $rates->get(1) ?? $rates->first();

        $selectedRate = $cheapestRate['object_id'];

        $store_shipment = new StoreShipment();
        $store_shipment->store_order_no = $order_no;
        $store_shipment->store_id = $order->store_id;
        $store_shipment->shipping_name = $order->first_name . ' ' . $order->last_name;
        $store_shipment->carrier = $cheapestRate['provider'] ?? 'USPS';;
        $store_shipment->shipment_id = $shipment['object_id'];
        $store_shipment->selected_rate = $selectedRate;
        $store_shipment->rate = $cheapestRate['amount'] ?? 0;
        $store_shipment->service = $cheapestRate['servicelevel']['name'] ?? 'Standard';
        $store_shipment->estimated_days = $cheapestRate['estimated_days'] ?? 'N/A';
        $store_shipment->is_shipping_removed = $order->is_shipping_removed ?? 0;
        $store_shipment->save();

        return redirect()->back()->with('success', 'Shipment created successfully.');
    }

    public function createShipmentsBulk(Request $request)
    {
        $order_nos = $request->order_nos;

        if (empty($order_nos)) {
            return redirect()->back()->with('error', 'No orders selected for shipment creation.');
        }

        $successCount = 0;
        $errors = [];

        foreach ($order_nos as $order_no) {

            try {

                $order = StoreOrder::with('OrderItems', 'ShipmentDetails')
                    ->where('order_no', $order_no)
                    ->first();

                if (!$order) {
                    $errors[] = "Order {$order_no}: Order not found.";
                    continue;
                }

                $store = Store::with('contactCoachesDetails')->find($order->store_id);

                if (!$store) {
                    $errors[] = "Order {$order_no}: Store not found.";
                    continue;
                }

                if (optional($order->ShipmentDetails)->isNotEmpty()) {
                    $errors[] = "Order {$order_no}: Shipment already created.";
                    continue;
                }

                $lineItems = [];
                $totalPrice = 0;
                $weight = 0;

                foreach ($order->OrderItems as $item) {

                    $product = $item->productDetails;

                    if (!$product) {
                        throw new \Exception('Incomplete product or item details found.');
                    }

                    $itemQty = (int) $item->qty ?: 1;
                    $itemWeight = (float) $product->shipping_weight ?: 5;
                    $itemTotalPrice = (
                        $product->default_price +
                        $product->priceAdditions->sum('addition_amount')) * $itemQty;

                    $weight += ($itemWeight * $itemQty);

                    $lineItems[] = [
                        'title'       => $product->product_name ?? 'No name',
                        'quantity'    => $itemQty,
                        'weight'      => $itemWeight,
                        'weight_unit' => 'oz',
                        'sku'         => $product->sku ?? 'TS-123',
                        'value'       => $product->default_price + $product->priceAdditions->sum('addition_amount'),
                        'total_price' => $itemTotalPrice,
                        'currency'    => 'USD',
                        'description' => substr(preg_replace('/\s+/', ' ', strip_tags($item['description'] ?? 'Product')), 0, 150),
                        'length'        => 10,
                        'width'         => 10,
                        'height'        => 5,
                        'distance_unit' => 'in',
                    ];

                    $totalPrice += $itemTotalPrice;
                }

                if($order->shipping_method == 1){
                    $address_to = [
                        'name' => $order->first_name . ' ' . $order->last_name,
                        'street1' => $order->street,
                        'city' => $order->city,
                        'state' => $order->state,
                        'zip' => $order->postal_code,
                        'country' => $order->country,
                        'email' => $order->email,
                        'phone' => $order->phone
                    ];

                }else{
                    $address_to = [
                        'name'    => 'Encore Custom',
                        'street1' => '891 4th St.',
                        'city'    => 'San Rafael',
                        'state'   => 'CA',
                        'zip'     => '94901',
                        'country' => 'USA',
                        'phone'   => '+1 888-501-4999',
                        'email'   => 'info@encorecustom.com'
                    ];
                }

                $orderData = [
                    'to_address'     => $address_to,
                    'from_address'   => [
                        'name'    => 'Encore Custom',
                        'company' => 'Encore Custom',
                        'street1'=> '891 4th St.',
                        'city'   => 'San Rafael',
                        'state'  => 'CA',
                        'zip'    => '94901',
                        'country'=> 'USA',
                        'phone'  => '+1 888-501-4999',
                        'email'  => 'info@encorecustom.com',
                    ],
                    'line_items'     => $lineItems,
                    'weight'         => $weight,
                    'weight_unit'    => 'oz',
                    'placed_at'      => $order->created_at->toIso8601String(),
                    'order_number'   => $order->order_no,
                    'subtotal_price' => $totalPrice,
                    'total_price'    => $order->total,
                    'currency'       => 'USD',
                    'async'          => true,
                    'test'           => env('SHIPPO_IS_TEST'),
                ];

                $shippoResponse = $this->shippoService->createOrder($orderData);

                if (!isset($shippoResponse['shippo_order']['object_id'])) {
                    throw new \Exception('Failed to create Shippo order.');
                }

                $order->shippo_order_id = $shippoResponse['shippo_order']['object_id'];
                $order->shippo_order_status = 1;
                $order->save();

                $orderDetails = $this->shippoService->orderDetail($order->shippo_order_id);

                if (!isset($orderDetails['id'])) {
                    throw new \Exception('Failed to fetch order details from Shippo.');
                }

                $shipmentData = [
                    'address_from' => $orderDetails['from_address'],
                    'address_to'   => $orderDetails['to_address'],
                    'parcels'      => [[
                        'weight'        => $weight > 0 ? $weight : 1,
                        'weight_unit'   => 'oz',
                        'length'        => 10,
                        'width'         => 10,
                        'height'        => 10,
                        'distance_unit' => 'in',
                    ]],
                    'async'            => true,
                    'carrier_accounts' => [env('CAREER_ACC_ID')],
                    'test'             => env('SHIPPO_IS_TEST'),
                ];

                $shipment = $this->shippoService->createShipment($shipmentData, $lineItems);

                if (!isset($shipment['object_id'])) {
                    throw new \Exception('Failed to create shipment.');
                }

                $rates = collect($shipment['rates'] ?? [])->sortBy('amount')->values();

                if ($rates->isEmpty()) {
                    throw new \Exception('No available shipping rates.');
                }

                $cheapestRate = $rates->get(1) ?? $rates->first();
                $selectedRate = $cheapestRate['object_id'];

                $store_shipment = new StoreShipment();
                $store_shipment->store_order_no = $order_no;
                $store_shipment->store_id = $order->store_id;
                $store_shipment->shipping_name = $order->first_name . ' ' . $order->last_name;
                $store_shipment->carrier = $cheapestRate['provider'] ?? 'USPS';;
                $store_shipment->shipment_id = $shipment['object_id'];
                $store_shipment->selected_rate = $selectedRate;
                $store_shipment->rate = $cheapestRate['amount'] ?? 0;
                $store_shipment->service = $cheapestRate['servicelevel']['name'] ?? 'Standard';
                $store_shipment->estimated_days = $cheapestRate['estimated_days'] ?? 'N/A';
                $store_shipment->is_shipping_removed = $order->is_shipping_removed ?? 0;
                $store_shipment->save();

                $successCount++;

            } catch (\Throwable $e) {
                $errors[] = "Order {$order_no}: {$e->getMessage()}";
            }
        }

        if (!empty($errors)) {
            return redirect()->back()->with(
                'error',
                "{$successCount} shipments created successfully. Errors: " . implode(' | ', $errors)
            );
        }

        return redirect()->back()->with(
            'success',
            "{$successCount} shipments created successfully."
        );
    }



    public function create_lable(Request $request)
    {
            $shipment_id = $request->shipment_id;
            $selectedRate = $request->selected_rate;

            if(empty($shipment_id) || empty($selectedRate)){
                return redirect()->back()->with('error', 'Shipment ID or Selected Rate is missing.');
            }

            $store_shipment = StoreShipment::where('shipment_id', $shipment_id)->first();

            if (!$store_shipment) {
                return redirect()->back()->with('error', 'Store shipment record not found.');
            }

            // $transaction = $this->shippoService->purchaseLabel([
            //     'rate' => $selectedRate,
            //     'label_file_type' => 'PDF',
            //     'async' => true,
            //     'carrier_accounts' => [env('CAREER_ACC_ID')],
            //     'test' => env('SHIPPO_IS_TEST', true),
            // ]);
            $transaction = $this->shippoService->purchaseLabel([
                'rate' => $selectedRate,
                'label_file_type' => 'PDF',
                'async' => true,
                'test' => env('SHIPPO_IS_TEST', true),
            ]);

            if (!isset($transaction['object_id'])) {
                return redirect()->back()->with('error', 'Failed to create shipping label.');
            }
            if(!isset($transaction['label_url'])){
                return redirect()->back()->with('error', 'Label URL not found in transaction.');
            }
            if(!isset($transaction['tracking_number'])){
                return redirect()->back()->with('error', 'Tracking number not found in transaction.');
            }

            $store_shipment->tracking_object_id = $transaction['object_id'];
            $store_shipment->tracking_number = $transaction['tracking_number'];
            $store_shipment->tracking_url = $transaction['tracking_url_provider'];
            $store_shipment->label_url = $transaction['label_url'];
            $store_shipment->save();

            $controller = new StoreController();
            $controller->send_store_tracking_email($store_shipment->store_order_no);

            return redirect()->back()->with('success', 'Shipping label created successfully.');
    }


    public function get_shipping_fee(Request $request)
    {
            $uniqueSessionId = session()->get('unique_session_id');
            $storeCartItems = StoreCart::where('store_id', $request->store_id)
                ->where('session_id', $uniqueSessionId)
                ->with('StoreCartItems', 'storeProduct')
                ->get();

            $store = Store::with('contactCoachesDetails')->find($request->store_id);
            if (!$store) {
                return response()->json([
                    'success' => false,
                    'message' => 'Store not found.'
                ]);
            }

            $shippingMethod = $request->shipping_method ?? 1;

            $storeCustomer = StoreCustomer::where('store_id', $request->store_id)
                ->where('session_id', $uniqueSessionId)
                ->first();

            if (!$storeCustomer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please fill your details for shipping.'
                ]);
            }
            if ($storeCartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart is empty.'
                ]);
            }

            if ($shippingMethod == 1) {
                // Calculate total weight and amount from cart items
                $totalWeight = 0;
                $totalAmount = 0;
                $totalQty = 0;
                foreach ($storeCartItems as $cart) {
                    if (!$cart->storeProduct) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Product not found in cart.'
                        ]);
                    }
                    $product = $cart->storeProduct;
                    $productWeight = (float)($product->shipping_weight) ?? 5;
                    $productPrice = (float)($product->default_price + $product->priceAdditions->sum('addition_amount')) ?? 0;
                    $totalWeight += $productWeight * $cart->qty;
                    $totalAmount += $productPrice * $cart->qty;
                    $totalQty += $cart->qty;
                }

                $store = Store::find($request->store_id);
                if (!$store) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Store not found.'
                    ]);
                }

                $totalAmount += $totalAmount * $store->sales_tax / 100;

                $totalAmount = round($totalAmount, 2);

                $parcel = [
                    'length' => 10,
                    'width' => 10,
                    'height' => 10,
                    'distance_unit' => 'in',
                    'weight' => $totalWeight > 0 ? round($totalWeight, 2) : 1,
                    'mass_unit' => 'oz',
                ];

                $address_to = [
                    'name' => $storeCustomer->first_name.' ' . $storeCustomer->last_name,
                    'street1' => $storeCustomer->street,
                    'city' => $storeCustomer->city,
                    'state' => $storeCustomer->state,
                    'zip' => $storeCustomer->postal_code,
                    'country' => $storeCustomer->country ?? 'US',
                    'phone' => $storeCustomer->phone,
                    'email' => $storeCustomer->email,
                ];

                if (
                    empty($address_to['street1']) ||
                    empty($address_to['city']) ||
                    empty($address_to['state']) ||
                    empty($address_to['zip']) ||
                    empty($address_to['country'])
                ) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Incomplete shipping address — please provide full address details.'
                    ]);
                }

                $address_from = [
                    'name' => 'Encore Custom',
                    'company' => 'Encore Custom',
                    'street1' => '891 4th St.',
                    'city' => 'San Rafael',
                    'state' => 'CA',
                    'zip' => '94901',
                    'country' => 'US',
                    'phone' => '+1 888-501-4999',
                    'email' => 'info@encorecustom.com',
                ];

                $customsItem = [
                    'description' => 'For shipping fee calculation',
                    'quantity' => $totalQty > 0 ? $totalQty : 1,
                    'net_weight' => $totalWeight > 0 ? round($totalWeight, 2) : 1,
                    'mass_unit' => 'oz',
                    'value_amount' => $totalAmount > 0 ? round($totalAmount, 2) : 1,
                    'value_currency' => 'USD',
                    'origin_country' => 'US',
                ];

                $customsDeclaration = $this->shippoService->createCustomsDeclaration([
                    'contents_type' => 'MERCHANDISE',
                    'contents_explanation' => 'Clothing',
                    'non_delivery_option' => 'RETURN',
                    'certify' => true,
                    'certify_signer' => 'Encore Custom',
                    'items' => [$customsItem],
                ]);

                $shipment = $this->shippoService->getShippingFee([
                    'address_from' => $address_from,
                    'address_to' => $address_to,
                    'parcels' => [$parcel],
                    'async' => false,
                    'carrier_accounts' => [env('CAREER_ACC_ID')],
                    'customs_declaration' => $customsDeclaration->object_id,
                ]);

                if (empty($shipment['rates'])) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No shipping rates available.',
                        'details' => $shipment['messages'] ?? []
                    ]);
                }

                $rates = collect($shipment['rates'])->sortBy('amount')->values();
                $cheapestRate = $rates->get(1) ?? $rates->first();

                return response()->json([
                    'success' => true,
                    'rate' => [
                        'amount' => $cheapestRate['amount'],
                        'currency' => $cheapestRate['currency'],
                        'provider' => $cheapestRate['provider'],
                        'service' => $cheapestRate['servicelevel']['name'],
                        'estimated_days' => $cheapestRate['estimated_days'],
                    ],
                    'customsItem' => $customsItem,
                    'weight' => $totalWeight,
                    'rates' => collect($shipment['rates'])
                        ->map(function ($r) {
                            return [
                                'amount' => $r['amount'] ?? $r->amount ?? null,
                                'currency' => $r['currency'] ?? $r->currency ?? null,
                                'provider' => $r['provider'] ?? $r->provider ?? null,
                                'service' => $r['servicelevel']['name'] ?? $r->servicelevel->name ?? null,
                                'estimated_days' => $r['estimated_days'] ?? $r->estimated_days ?? null,
                            ];
                        })
                        ->sortBy('amount')
                        ->values(),
                ]);

            }else{
                return response()->json([
                    'success' => true,
                    'rate' => [
                        'amount' => 0.00,
                        'currency' => "USD",
                        'provider' => "N/A",
                        'service' => "N/A",
                        'estimated_days' => "N/A",
                    ]
                ]);
            }

    }

    public function get_order_shipping_fee(Request $request)
    {
            $storeOrder = StoreOrder::with('ShipmentDetails', 'OrderItems')->where('order_no', $request->order_no)->first();
            if (!$storeOrder) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found.'
                ], 404);
            }

            if($storeOrder->shipping_method == 3 || $storeOrder->shipping_method == 2) {
                return response()->json([
                    'success' => true,
                    'rate' => [
                        'amount' => 0.00,
                        'currency' => "USD",
                        'provider' => "N/A",
                        'service' => "N/A",
                        'estimated_days' => "N/A",
                    ]
                ]);

            }

            $storeCustomer = StoreCustomer::where('id', $storeOrder->store_customer_id)->first();

            if (!$storeCustomer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer not found.'
                ], 404);
            }

            $totalWeight = (float) ($request->total_weight ?? 0);
            $totalAmount = (float) ($request->total_price ?? 0);

            if ($totalWeight <= 0 || $totalAmount <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid weight or amount for shipping fee calculation.'
                ], 400);
            }

            $parcel = [
                'length' => 10,
                'width' => 10,
                'height' => 10,
                'distance_unit' => 'in',
                'weight' => $totalWeight > 0 ? $totalWeight : 1,
                'mass_unit' => 'oz',
            ];

            $address_to = [
                'name' => $storeOrder->first_name.' ' . $storeOrder->last_name,
                'street1' => $storeOrder->street,
                'city' => $storeOrder->city,
                'state' => $storeOrder->state,
                'zip' => $storeOrder->postal_code,
                'country' => $storeOrder->country,
                'phone' => $storeOrder->phone,
                'email' => $storeOrder->email,
            ];

            $address_from = [
                'name' => 'Encore Custom',
                'company' => 'Encore Custom',
                'street1' => '891 4th St.',
                'city' => 'San Rafael',
                'state' => 'CA',
                'zip' => '94901',
                'country' => 'USA',
                'phone' => '+1 888-501-4999',
                'email' => 'info@encorecustom.com',
            ];

            $customsItem = [
                'description' => 'For shipping fee calculation',
                'quantity' => 1,
                'net_weight' => $totalWeight > 0 ? $totalWeight : 1,
                'mass_unit' => 'oz',
                'value_amount' => $totalAmount > 0 ? $totalAmount : 1,
                'value_currency' => 'USD',
                'origin_country' => 'US',
            ];

            $customsDeclaration = $this->shippoService->createCustomsDeclaration([
                'contents_type' => 'MERCHANDISE',
                'contents_explanation' => 'Clothing',
                'non_delivery_option' => 'RETURN',
                'certify' => true,
                'certify_signer' => 'Encore Custom',
                'items' => [$customsItem],
            ]);

            $shipment = $this->shippoService->getShippingFee([
                'address_from' => $address_from,
                'address_to' => $address_to,
                'parcels' => [$parcel],
                'async' => false,
                'carrier_accounts' => [env('CAREER_ACC_ID')],
                'customs_declaration' => $customsDeclaration->object_id,
            ]);

            if (empty($shipment['rates'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'No shipping rates available.',
                    'details' => $shipment['messages'] ?? []
                ], 400);
            }

            $rates = collect($shipment['rates'])->sortBy('amount')->values();
            $cheapestRate = $rates->get(1) ?? $rates->first();

            return response()->json([
                'success' => true,
                'rate' => [
                    'amount' => $cheapestRate['amount'],
                    'currency' => $cheapestRate['currency'],
                    'provider' => $cheapestRate['provider'],
                    'service' => $cheapestRate['servicelevel']['name'],
                    'estimated_days' => $cheapestRate['estimated_days'],
                ]
            ]);
    }

    public function download_packing_slips(Request $request)
    {
        @set_time_limit(300);

        $orderIds = array_values(array_unique(array_filter(
            array_map('intval', (array) $request->input('order_ids', []))
        )));

        $customSort = (int) $request->input('custom_sort', 1);
        $downloadMode = $request->input('download_mode', 'merged');

        if (empty($orderIds)) {
            return redirect()->back()->with(
                'error',
                'No orders selected.'
            );
        }

        /*
        * Retrieve IDs first, in the requested order.
        */
        $orderIdsQuery = StoreOrder::query()
            ->whereIn('id', $orderIds);

        $this->applyPackingSlipSort(
            $orderIdsQuery,
            $customSort
        );

        $sortedOrderIds = $orderIdsQuery
            ->pluck('id')
            ->toArray();

        if (empty($sortedOrderIds)) {
            return redirect()->back()->with(
                'error',
                'No valid orders found.'
            );
        }

        /*
        * MERGED PDF
        */
        if ($downloadMode === 'merged') {
            $storeOrdersQuery = $this->getPackingSlipOrdersQuery()
                ->whereIn('id', $sortedOrderIds);

            $this->applyPackingSlipSort(
                $storeOrdersQuery,
                $customSort
            );

            $orders = $storeOrdersQuery->get();

            if ($orders->isEmpty()) {
                return redirect()->back()->with(
                    'error',
                    'No valid orders found.'
                );
            }

            foreach ($orders as $order) {
                $this->encodeOrderImages($order);
            }

            $pdf = \PDF::loadView(
                'pages.stores.packing_slip.merged',
                [
                    'orders' => $orders,
                ]
            )->setPaper('a4');

            $fileName = 'packing_slips_' .
                now()->format('Ymd_His') .
                '.pdf';

            return $pdf->download($fileName);
        }

        /*
        * ZIP DOWNLOAD
        *
        * Load one order at a time instead of keeping every order and
        * every generated PDF in PHP memory.
        */
        $zipFileName = 'packing_slips_' .
            now()->format('Ymd_His') .
            '.zip';

        $zipFilePath = storage_path(
            'app/packing_slips_' .
            uniqid('', true) .
            '.zip'
        );

        $zip = new \ZipArchive();

        $zipResult = $zip->open(
            $zipFilePath,
            \ZipArchive::CREATE | \ZipArchive::OVERWRITE
        );

        if ($zipResult !== true) {
            return redirect()->back()->with(
                'error',
                'Unable to create ZIP file.'
            );
        }

        $generatedCount = 0;

        try {
            foreach ($sortedOrderIds as $orderId) {
                $order = $this->getPackingSlipOrdersQuery()
                    ->where('id', $orderId)
                    ->first();

                if (!$order) {
                    continue;
                }

                $this->encodeOrderImages($order);

                $pdf = \PDF::loadView(
                    'pages.stores.packing_slip.single',
                    [
                        'order' => $order,
                    ]
                )->setPaper('a4');

                $pdfContent = $pdf->output();

                $safeOrderNumber = preg_replace(
                    '/[^A-Za-z0-9_-]/',
                    '_',
                    (string) $order->order_no
                );

                $pdfFileName =
                    'packing_slip_' .
                    $safeOrderNumber .
                    '.pdf';

                $zip->addFromString(
                    $pdfFileName,
                    $pdfContent
                );

                $generatedCount++;

                unset($pdfContent);
                unset($pdf);
                unset($order);

                gc_collect_cycles();
            }

            $zip->close();

            if ($generatedCount === 0) {
                if (file_exists($zipFilePath)) {
                    @unlink($zipFilePath);
                }

                return redirect()->back()->with(
                    'error',
                    'No packing slips were generated.'
                );
            }

            return response()
                ->download($zipFilePath, $zipFileName)
                ->deleteFileAfterSend(true);
        } catch (\Throwable $e) {
            $zip->close();

            if (file_exists($zipFilePath)) {
                @unlink($zipFilePath);
            }

            \Log::error('Packing slip generation failed', [
                'message' => $e->getMessage(),
                'order_count' => count($sortedOrderIds),
            ]);

            return redirect()->back()->with(
                'error',
                'Packing slip generation failed: ' .
                $e->getMessage()
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Packing-slip order query
    |--------------------------------------------------------------------------
    |
    | The OrderItems relationship in StoreOrder automatically loads
    | orderDetails. That creates an unnecessary Order -> Items -> Order
    | relationship and increases memory usage.
    |
    */
    private function getPackingSlipOrdersQuery()
    {
        return StoreOrder::with([
            'OrderItems' => function ($query) {
                $query->setEagerLoads([]);

                $query->with([
                    'OrderItemDetails.SizeDetails',
                    'productDetails.images',
                ]);
            },

            'CustomerDetails',
            'shippingMethodDetails',
            'storeDetails',
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Sorting
    |--------------------------------------------------------------------------
    */
    private function applyPackingSlipSort(
        $query,
        $customSort
    ) {
        switch ((int) $customSort) {
            case 0:
                break;

            case 1:
                $query->orderBy('id', 'asc');
                break;

            case 2:
                $query->orderBy('id', 'desc');
                break;

            case 3:
                $query->orderBy('created_at', 'asc');
                break;

            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        return $query;
    }


    /*
    |--------------------------------------------------------------------------
    | Select and encode product images
    |--------------------------------------------------------------------------
    */
    public function encodeOrderImages($order)
    {
        static $defaultImage = null;

        if ($defaultImage === null) {
            $defaultImage = $this->encodeToBase64(
                'assets/img/products/default-loading.gif',
                220,
                220,
                35
            );
        }

        foreach ($order->OrderItems as $item) {
            $item->base64_image = null;

            $product = $item->productDetails;

            if (!$product) {
                $item->base64_image = $defaultImage;
                continue;
            }

            $images = $product->images;

            $selectedThumbnail = null;
            $selectedImage = null;

            /*
            * Try every image until a real and readable product image
            * is found. Do not select the database placeholder image.
            */
            if ($images && $images->isNotEmpty()) {
                foreach ($images as $image) {
                    if (
                        !$image ||
                        empty($image->url)
                    ) {
                        continue;
                    }

                    /*
                    * Do not reuse a previously replaced Base64 image.
                    */
                    if (
                        is_string($image->url) &&
                        strpos($image->url, 'data:image/') === 0
                    ) {
                        continue;
                    }

                    if ($this->isDefaultProductImage($image->url)) {
                        continue;
                    }

                    $thumbnail = $this->encodeToBase64(
                        $image->url,
                        220,
                        220,
                        35
                    );

                    if ($thumbnail) {
                        $selectedThumbnail = $thumbnail;
                        $selectedImage = clone $image;
                        break;
                    }
                }
            }

            /*
            * Use the default image only when no real physical image
            * could be found.
            */
            if (!$selectedThumbnail) {
                $item->base64_image = $defaultImage;

                /*
                * Keep compatibility with Blade code using:
                *
                * $item->productDetails->images->first()->url
                */
                if ($defaultImage) {
                    $productClone = clone $product;

                    $productClone->setRelation(
                        'images',
                        collect([
                            (object) [
                                'url' => $defaultImage,
                            ],
                        ])
                    );

                    $item->setRelation(
                        'productDetails',
                        $productClone
                    );
                }

                \Log::warning(
                    'No valid product image found for packing slip',
                    [
                        'order_id' => isset($order->id)
                            ? $order->id
                            : null,

                        'order_item_id' => isset($item->id)
                            ? $item->id
                            : null,

                        'product_id' => isset($product->id)
                            ? $product->id
                            : null,

                        'image_urls' => $images
                            ? $images->pluck('url')->toArray()
                            : [],
                    ]
                );

                continue;
            }

            $item->base64_image = $selectedThumbnail;

            /*
            * Clone the product and image before changing the URL.
            * This prevents one order item from changing another
            * order item's product image.
            */
            $productClone = clone $product;

            $selectedImage->url = $selectedThumbnail;

            $productClone->setRelation(
                'images',
                collect([$selectedImage])
            );

            $item->setRelation(
                'productDetails',
                $productClone
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Create a low-quality thumbnail
    |--------------------------------------------------------------------------
    */
    public function encodeToBase64(
        $url,
        $maxWidth = 220,
        $maxHeight = 220,
        $jpegQuality = 35
    ) {
        static $thumbnailCache = [];

        if (empty($url)) {
            return null;
        }

        /*
        * Already encoded image.
        */
        if (
            is_string($url) &&
            strpos($url, 'data:image/') === 0
        ) {
            return $url;
        }

        $cacheKey = md5(
            (string) $url .
            '|' . $maxWidth .
            '|' . $maxHeight .
            '|' . $jpegQuality
        );

        if (array_key_exists($cacheKey, $thumbnailCache)) {
            return $thumbnailCache[$cacheKey];
        }

        $imagePath = $this->resolvePackingSlipImagePath($url);

        if (!$imagePath) {
            $thumbnailCache[$cacheKey] = null;
            return null;
        }

        $extension = strtolower(
            pathinfo($imagePath, PATHINFO_EXTENSION)
        );

        /*
        * SVG is normally already small and cannot be resized
        * through standard GD functions.
        */
        if ($extension === 'svg') {
            $svgContent = @file_get_contents($imagePath);

            if (!$svgContent) {
                $thumbnailCache[$cacheKey] = null;
                return null;
            }

            $result = 'data:image/svg+xml;base64,' .
                base64_encode($svgContent);

            $thumbnailCache[$cacheKey] = $result;

            return $result;
        }

        if (!extension_loaded('gd')) {
            \Log::error(
                'GD extension is not enabled. Packing-slip images cannot be resized.'
            );

            $thumbnailCache[$cacheKey] = null;
            return null;
        }

        $imageData = @file_get_contents($imagePath);

        if (!$imageData) {
            $thumbnailCache[$cacheKey] = null;
            return null;
        }

        /*
        * imagecreatefromstring supports JPEG, PNG, GIF and WebP
        * when the corresponding GD support is enabled.
        */
        $sourceImage = @imagecreatefromstring($imageData);

        unset($imageData);

        if (!$sourceImage) {
            \Log::warning(
                'Unable to decode product image with GD',
                [
                    'image_path' => $imagePath,
                    'extension' => $extension,
                ]
            );

            $thumbnailCache[$cacheKey] = null;
            return null;
        }

        $sourceWidth = imagesx($sourceImage);
        $sourceHeight = imagesy($sourceImage);

        if (
            $sourceWidth <= 0 ||
            $sourceHeight <= 0
        ) {
            imagedestroy($sourceImage);

            $thumbnailCache[$cacheKey] = null;
            return null;
        }

        /*
        * Keep the original aspect ratio and do not enlarge
        * images smaller than the thumbnail canvas.
        */
        $scale = min(
            $maxWidth / $sourceWidth,
            $maxHeight / $sourceHeight,
            1
        );

        $resizedWidth = max(
            1,
            (int) round($sourceWidth * $scale)
        );

        $resizedHeight = max(
            1,
            (int) round($sourceHeight * $scale)
        );

        /*
        * Create a fixed white canvas.
        */
        $thumbnailImage = imagecreatetruecolor(
            $maxWidth,
            $maxHeight
        );

        if (!$thumbnailImage) {
            imagedestroy($sourceImage);

            $thumbnailCache[$cacheKey] = null;
            return null;
        }

        $white = imagecolorallocate(
            $thumbnailImage,
            255,
            255,
            255
        );

        imagefill(
            $thumbnailImage,
            0,
            0,
            $white
        );

        $destinationX = (int) floor(
            ($maxWidth - $resizedWidth) / 2
        );

        $destinationY = (int) floor(
            ($maxHeight - $resizedHeight) / 2
        );

        imagecopyresampled(
            $thumbnailImage,
            $sourceImage,
            $destinationX,
            $destinationY,
            0,
            0,
            $resizedWidth,
            $resizedHeight,
            $sourceWidth,
            $sourceHeight
        );

        ob_start();

        imagejpeg(
            $thumbnailImage,
            null,
            max(
                10,
                min(100, (int) $jpegQuality)
            )
        );

        $thumbnailBinary = ob_get_clean();

        imagedestroy($thumbnailImage);
        imagedestroy($sourceImage);

        if (!$thumbnailBinary) {
            $thumbnailCache[$cacheKey] = null;
            return null;
        }

        $result = 'data:image/jpeg;base64,' .
            base64_encode($thumbnailBinary);

        $thumbnailCache[$cacheKey] = $result;

        return $result;
    }


    /*
    |--------------------------------------------------------------------------
    | Resolve database image URL to a physical server path
    |--------------------------------------------------------------------------
    */
    private function resolvePackingSlipImagePath($url)
    {
        if (
            empty($url) ||
            !is_string($url)
        ) {
            return null;
        }

        /*
        * Database already contains an absolute physical path.
        */
        if (
            is_file($url) &&
            is_readable($url)
        ) {
            return realpath($url);
        }

        /*
        * Remove domain, query string and URL fragment.
        *
        * Example:
        * https://encr.co/assets/product.jpg?v=1
        *
        * becomes:
        * assets/product.jpg
        */
        $parsedPath = parse_url(
            $url,
            PHP_URL_PATH
        );

        if (!$parsedPath) {
            $parsedPath = $url;
        }

        $parsedPath = rawurldecode($parsedPath);

        $relativePath = ltrim(
            str_replace('\\', '/', $parsedPath),
            '/'
        );

        $withoutPublic = preg_replace(
            '#^public/#i',
            '',
            $relativePath
        );

        $withoutStorage = preg_replace(
            '#^storage/#i',
            '',
            $relativePath
        );

        $candidates = [
            /*
            * Laravel installed directly in public_html.
            */
            base_path($relativePath),

            /*
            * Standard Laravel public directory.
            */
            public_path($relativePath),

            /*
            * Database URL begins with public/.
            */
            base_path('public/' . $withoutPublic),
            public_path($withoutPublic),

            /*
            * Laravel storage path and public storage link.
            */
            storage_path(
                'app/public/' . $withoutStorage
            ),

            public_path(
                'storage/' . $withoutStorage
            ),
        ];

        foreach (array_unique($candidates) as $candidate) {
            $candidate = str_replace(
                ['/', '\\'],
                DIRECTORY_SEPARATOR,
                $candidate
            );

            if (
                is_file($candidate) &&
                is_readable($candidate)
            ) {
                return realpath($candidate);
            }
        }

        return null;
    }


    /*
    |--------------------------------------------------------------------------
    | Identify default/placeholder database images
    |--------------------------------------------------------------------------
    */
    private function isDefaultProductImage($url)
    {
        if (empty($url)) {
            return true;
        }

        $path = parse_url(
            (string) $url,
            PHP_URL_PATH
        );

        if (!$path) {
            $path = (string) $url;
        }

        $path = strtolower(
            rawurldecode(
                str_replace('\\', '/', $path)
            )
        );

        $fileName = basename($path);

        $defaultFileNames = [
            'default-loading.gif',
            'default-loading.jpg',
            'default-loading.png',
            'default-image.jpg',
            'default-image.jpeg',
            'default-image.png',
            'default.jpg',
            'default.jpeg',
            'default.png',
            'no-image.jpg',
            'no-image.jpeg',
            'no-image.png',
            'no_image.jpg',
            'no_image.jpeg',
            'no_image.png',
            'placeholder.jpg',
            'placeholder.jpeg',
            'placeholder.png',
            'product-placeholder.jpg',
            'product-placeholder.png',
        ];

        if (
            in_array(
                $fileName,
                $defaultFileNames,
                true
            )
        ) {
            return true;
        }

        $defaultPathParts = [
            'default-loading',
            'default-image',
            'no-image',
            'no_image',
            'placeholder',
        ];

        foreach ($defaultPathParts as $part) {
            if (strpos($path, $part) !== false) {
                return true;
            }
        }

        return false;
    }






}


