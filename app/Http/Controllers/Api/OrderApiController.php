<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Order;
use App\Models\StoreOrder;
use App\Models\User;
use Carbon\Carbon;
use domainencore\Facades\OrdersCommenFacade\OrdersCommenFacade;

class OrderApiController extends Controller
{
    protected $inventoryOrgIds;

    public function __construct()
    {
        $this->inventoryOrgIds = OrdersCommenFacade::getEncoreOrgIds()->toArray();
    }
    /**
     * Get order details by order ID
     *
     * @param Request $request
     * @param int $orderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrderDetails(Request $request, $orderId)
    {
        try {
            // Validate order ID
            if (!is_numeric($orderId) || $orderId <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid order ID provided',
                    'error_code' => 'INVALID_ORDER_ID'
                ], Response::HTTP_BAD_REQUEST);
            }

            // Try to find the order
            $order = Order::with([
                'organizationDetails',
                'contactDetails',
                'userDetails',
                'statusDetails',
                'orderItems.productDetails',
                'orderItems.orderItemsDetails',
                'billingDetails',
                'teamStoreDetails'
            ])->where('id', $orderId)
              ->where('active', 1)
              ->first();

            // If order not found, try store orders
            if (!$order) {
                $storeOrder = StoreOrder::with([
                    'CustomerDetails',
                    'StatusDetails',
                    'OrderItems.productDetails',
                    'OrderItems.OrderItemDetails',
                    'ShipmentDetails',
                    'paymentDetails',
                    'shippingMethodDetails',
                    'couponDetails'
                ])->where('id', $orderId)
                  ->where('active', 1)
                  ->first();

                if (!$storeOrder) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Order not found',
                        'error_code' => 'ORDER_NOT_FOUND'
                    ], Response::HTTP_NOT_FOUND);
                }

                // Return store order details
                return response()->json([
                    'success' => true,
                    'message' => 'Order details retrieved successfully',
                    'data' => [
                        'order' => $this->formatStoreOrderData($storeOrder),
                        'order_type' => 'store_order'
                    ],
                    'timestamp' => Carbon::now()->toISOString()
                ], Response::HTTP_OK);
            }

            // Return order details (no user permission check needed)
            return response()->json([
                'success' => true,
                'message' => 'Order details retrieved successfully',
                'data' => [
                    'order' => $this->formatOrderData($order),
                    'order_type' => 'main_order'
                ],
                'timestamp' => Carbon::now()->toISOString()
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving order details',
                'error_code' => 'INTERNAL_ERROR',
                'error_details' => config('app.debug') ? $e->getMessage() : null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get all orders
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllOrders(Request $request)
    {
        try {
            // Get pagination parameters
            $page = $request->get('page', 1);
            $perPage = min($request->get('per_page', 20), 100); // Max 100 per page
            $orderStatus = $request->get('status');
            $dateFrom = $request->get('date_from');
            $dateTo = $request->get('date_to');
            $orderType = $request->get('type', 'all'); // 'main', 'store', or 'all'

            $responseData = [];

            // Get main orders if requested
            if ($orderType === 'all' || $orderType === 'main') {
                $orderQuery = Order::with([
                    'organizationDetails',
                    'contactDetails',
                    'statusDetails'
                ])->where('active', 1);

                // Apply filters
                if ($orderStatus) {
                    $orderQuery->where('order_status_id', $orderStatus);
                }

                if ($dateFrom) {
                    $orderQuery->where('created_at', '>=', Carbon::parse($dateFrom));
                }

                if ($dateTo) {
                    $orderQuery->where('created_at', '<=', Carbon::parse($dateTo));
                }

                $mainOrders = $orderQuery->orderBy('created_at', 'desc')
                                        ->paginate($perPage, ['*'], 'main_page', $page);

                $responseData['main_orders'] = [
                    'orders' => $mainOrders->items(),
                    'pagination' => [
                        'current_page' => $mainOrders->currentPage(),
                        'last_page' => $mainOrders->lastPage(),
                        'per_page' => $mainOrders->perPage(),
                        'total' => $mainOrders->total(),
                        'from' => $mainOrders->firstItem(),
                        'to' => $mainOrders->lastItem()
                    ]
                ];
            }

            // Get store orders if requested
            if ($orderType === 'all' || $orderType === 'store') {
                $storeOrderQuery = StoreOrder::with([
                    'CustomerDetails',
                    'StatusDetails'
                ]);

                // Apply filters
                if ($orderStatus) {
                    $storeOrderQuery->where('order_status', $orderStatus);
                }

                if ($dateFrom) {
                    $storeOrderQuery->where('created_at', '>=', Carbon::parse($dateFrom));
                }

                if ($dateTo) {
                    $storeOrderQuery->where('created_at', '<=', Carbon::parse($dateTo));
                }

                $storeOrders = $storeOrderQuery->orderBy('created_at', 'desc')
                                              ->paginate($perPage, ['*'], 'store_page', $page);

                $responseData['store_orders'] = [
                    'orders' => $storeOrders->items(),
                    'pagination' => [
                        'current_page' => $storeOrders->currentPage(),
                        'last_page' => $storeOrders->lastPage(),
                        'per_page' => $storeOrders->perPage(),
                        'total' => $storeOrders->total(),
                        'from' => $storeOrders->firstItem(),
                        'to' => $storeOrders->lastItem()
                    ]
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Orders retrieved successfully',
                'data' => $responseData,
                'timestamp' => Carbon::now()->toISOString()
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving orders',
                'error_code' => 'INTERNAL_ERROR',
                'error_details' => config('app.debug') ? $e->getMessage() : null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAllDWCOrders(Request $request)
    {
        try {
            $dateFrom = $request->get('date_from');
            $dateTo = $request->get('date_to');

            $orderQuery = Order::select(
                'id','organization_id','contact_id','order_no','order_status_id','user_id','order_procesing_user_id','discountType','discount','discount_hidation',
                'collect_payment_via_ec','is_requested','request_reasons','flag','open_date','due_date','production_date','ex_factory_date','encore_packing_date',
                'est_delivery_date','order_description','address_type','is_new_shipping_address','apartment','street','city','state','postal_code','country',
                'phone_no','email','is_reordered','order_id','order_ref_no','is_urgent','factory_confirmation_date','reject_or_confirm','reject_reason',
                'suggested_ex_fac_date','upcoming_status','plorder','cancel_reason','created_at','updated_at'
            )->with([
                'organizationDetails:id,organization_name,website,email,sport,user_id,assigned_to,size_of_club,colors,organization_logo,shipping_po_box,shipping_street,shipping_city,shipping_state,shipping_postal_code,shipping_country,lead_source,received_sample,ordering_timeline,pl_status,active',
                'userDetails:id,name,email',
                'orderProcessingUserDetails:id,name,email',
                'contactDetails:id,first_name,last_name,organization_id,lead_source,phone_no,personal_phone_no,email,email_two,title,user_id,shipping_po_box,shipping_street,shipping_city,shipping_state,shipping_zip,shipping_country,apartment2,shipping_street_2,shipping_city_2,shipping_state_2,shipping_zip_2,shipping_country_2,active,apartment',
                'teamStoreDetails:id,order_no,order_id,organization_id'
            ])->where('active', 1)
            ->whereIn('order_status_id', [3,4,8]);

            if ($dateFrom) {
                $orderQuery->where('created_at', '>=', Carbon::parse($dateFrom));
            }

            if ($dateTo) {
                $orderQuery->where('created_at', '<=', Carbon::parse($dateTo));
            }
            $orderQuery->whereHas('orderItems.factoryDetails', function($query) use($request) {
                $query->where('id', 1);
            });
            $orderQuery->with(['orderItems'=>function($qry){
                $qry->select(
                    'id','item_no','order_id','product_id','sub_product_no','display_name','organization_id','factory_id','support_agent_id','designer_id',
                    'shipping_method','ex_factory_id','open_date','close_date','ex_factory_date','encore_packing_date','in_hand_due_date','production_date',
                    'est_delivery_date','order_status_id','fabric_id','clouser_type','secondary_fabric_id','embellishment_type_id','sport','gender','qty',
                    'extra_size','extra_size_two','extra_size_three','double_sided','dynamic_details','contrast_stratching','printing_over_sems','test_print_needed',
                    'test_print_due_date','tracking_no','tracking_link','notify_status','notified_user_id','item_description','shipped_qty','backordered_qty',
                    'est_shipping_delivery_date','product_year','is_urgent','reject_or_confirm','reject_reason','suggested_ex_fac_date','remake_status','has_remake_item',
                    'active','created_at','updated_at',
                )
                ->with(['orderItemDetails.sizeDetails:id,size_name',
                                'orderItemDetails.playerDetails',
                                'orderItemProductDetails:id,parent_product_id,product_name,sub_product_no,pattern_code,standard_fabric,type_of_embellishment,attribute_on_price,description,who_we_made_this_for,product_features,notes,fabric_id,weight',
                                'embellishmentDetails:id,embellishment_name',
                                'fabricDetails:id,fabric_name,available_for_hats',
                                'secFabricDetails',
                                'exFactoryDetails',
                                'orderItemFiles',
                                'orderItemAttributes',
                                'productAttributes' => function ($query) {
                                    $query->select('id', 'product_id', 'attribute_id')
                                          ->with(['attributes:id,attribute_name']);
                                }])
                    ->whereIn('factory_id', [1])
                    ->whereIn('order_status_id', [3,4,8]);
            }]);
            $orderQuery->whereHas('orderItems', function($qr){
                            $qr->whereIn('factory_id', [1])
                               ->whereIn('order_status_id', [3,4,8]);
                        });
            $responseData = $orderQuery->orderBy('created_at')->get()->toArray();

            return response()->json([
                'success' => true,
                'message' => 'Orders retrieved successfully',
                'data' => $responseData,
                'timestamp' => Carbon::now()->toISOString()
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving orders',
                'error_code' => 'INTERNAL_ERROR',
                'error_details' => config('app.debug') ? $e->getMessage() : null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Format main order data for API response
     *
     * @param Order $order
     * @return array
     */
    private function formatOrderData(Order $order)
    {
        return [
            'id' => $order->id,
            'order_no' => $order->order_no,
            'order_type' => $order->order_type,
            'status' => $order->statusDetails ? [
                'id' => $order->statusDetails->id,
                'name' => $order->statusDetails->status_name
            ] : null,
            'organization' => $order->organizationDetails ? [
                'id' => $order->organizationDetails->id,
                'name' => $order->organizationDetails->organization_name,
                'sport' => $order->organizationDetails->sport
            ] : null,
            'contact' => $order->contactDetails ? [
                'id' => $order->contactDetails->id,
                'name' => $order->contactDetails->contact_name,
                'email' => $order->contactDetails->email,
                'phone' => $order->contactDetails->phone
            ] : null,
            'user' => $order->userDetails ? [
                'id' => $order->userDetails->id,
                'name' => $order->userDetails->name,
                'email' => $order->userDetails->email
            ] : null,
            'financial' => [
                'sub_total' => $order->sub_total,
                'sales_tax' => $order->sales_tax,
                'shipping' => $order->shipping,
                'artwork' => $order->artwork,
                'processing_fee' => $order->processing_fee,
                'discount' => $order->discount,
                'discount_type' => $order->discountType,
                'order_total' => $order->order_total
            ],
            'dates' => [
                'open_date' => $order->open_date,
                'due_date' => $order->due_date,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at
            ],
            'flags' => [
                'is_editable' => $order->is_editable,
                'is_requested' => $order->is_requested,
                'request_reasons' => $order->request_reasons,
                'flag' => $order->flag
            ],
            'order_items' => $order->orderItems ? $order->orderItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product' => $item->productDetails ? [
                        'id' => $item->productDetails->id,
                        'product_name' => $item->productDetails->product_name,
                        'product_code' => $item->productDetails->product_code
                    ] : null,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->total_price,
                    'details' => $item->orderItemsDetails ? $item->orderItemsDetails->map(function ($detail) {
                        return [
                            'id' => $detail->id,
                            'player_name' => $detail->player_name,
                            'player_number' => $detail->player_number,
                            'size' => $detail->size,
                            'color' => $detail->color
                        ];
                    }) : []
                ];
            }) : []
        ];
    }

    /**
     * Format store order data for API response
     *
     * @param StoreOrder $storeOrder
     * @return array
     */
    private function formatStoreOrderData(StoreOrder $storeOrder)
    {
        return [
            'id' => $storeOrder->id,
            'order_no' => $storeOrder->order_no,
            'status' => $storeOrder->StatusDetails ? [
                'id' => $storeOrder->StatusDetails->id,
                'name' => $storeOrder->StatusDetails->status_name
            ] : null,
            'customer' => $storeOrder->CustomerDetails ? [
                'id' => $storeOrder->CustomerDetails->id,
                'name' => $storeOrder->CustomerDetails->customer_name,
                'email' => $storeOrder->CustomerDetails->email,
                'phone' => $storeOrder->CustomerDetails->phone
            ] : null,
            'financial' => [
                'sub_total' => $storeOrder->sub_total,
                'total' => $storeOrder->total,
                'processing_fee' => $storeOrder->processing_fee,
                'paid_amount' => $storeOrder->paid_amount
            ],
            'shipping' => [
                'method' => $storeOrder->shipping_method,
                'carrier' => $storeOrder->carrier,
                'method_details' => $storeOrder->shippingMethodDetails ? [
                    'id' => $storeOrder->shippingMethodDetails->id,
                    'name' => $storeOrder->shippingMethodDetails->method_name
                ] : null
            ],
            'payment' => [
                'method' => $storeOrder->payment_method,
                'details' => $storeOrder->paymentDetails ? $storeOrder->paymentDetails->map(function ($payment) {
                    return [
                        'id' => $payment->id,
                        'amount' => $payment->amount,
                        'transaction_id' => $payment->transaction_id,
                        'status' => $payment->status,
                        'created_at' => $payment->created_at
                    ];
                }) : []
            ],
            'coupon' => $storeOrder->couponDetails ? [
                'code' => $storeOrder->couponDetails->coupon_code,
                'discount_type' => $storeOrder->couponDetails->discount_type,
                'discount_value' => $storeOrder->couponDetails->discount_value
            ] : null,
            'shipment' => $storeOrder->ShipmentDetails ? [
                'tracking_number' => $storeOrder->ShipmentDetails->tracking_number,
                'carrier' => $storeOrder->ShipmentDetails->carrier,
                'status' => $storeOrder->ShipmentDetails->status,
                'shipped_date' => $storeOrder->ShipmentDetails->shipped_date
            ] : null,
            'dates' => [
                'created_at' => $storeOrder->created_at,
                'updated_at' => $storeOrder->updated_at
            ],
            'order_items' => $storeOrder->OrderItems ? $storeOrder->OrderItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product' => $item->productDetails ? [
                        'id' => $item->productDetails->id,
                        'product_name' => $item->productDetails->product_name,
                        'product_code' => $item->productDetails->product_code,
                        'price' => $item->productDetails->price
                    ] : null,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->total_price,
                    'player_details' => $item->OrderItemDetails ? $item->OrderItemDetails->map(function ($detail) {
                        return [
                            'id' => $detail->id,
                            'player_name' => $detail->player_name,
                            'player_number' => $detail->player_number,
                            'size' => $detail->SizeDetails ? $detail->SizeDetails->size_name : null,
                            'color' => $detail->ColorDetails ? $detail->ColorDetails->color_name : null
                        ];
                    }) : []
                ];
            }) : []
        ];
    }
}
