<?php

namespace App\Http\Controllers;

use App\Exports\BulkOrderExport;
use App\Exports\TSOrderExport;
use App\Models\Contact;
use App\Models\EmbellishmentType;
use App\Models\Fabric;
use App\Models\Factory;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemsDetail;
use App\Models\OrderLayout;
use App\Models\InventoryOrderLayout;
use App\Models\OrderStatus;
use App\Models\Organization;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\User;
use App\Models\ColumnLayout;
use App\Models\InventoryAddedOrder;
use App\Models\Notification;
use App\Models\ShippedOrders;
use App\Models\ProductFabric;
use App\Models\ProductEmbellishmentType;
use App\Models\ProductAttribute;
use App\Models\OrderItemAttribute;
use Carbon\Carbon;
use domainencore\Facades\OrdersCommenFacade\OrdersCommenFacade;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\Services\NotificationBuilderService;

class InventoryOrderController extends Controller
{
    // private $smptEncryption = 'TLS';
    // private $smptPort = '587';
    // private $smptHost = 'smtp-mail.outlook.com';
    // private $mailUsername = 'info@encorebrand.com';
    // private $mailPassword = 'EncoreCus!0077';

    private $smptEncryption = 'SSL';
    private $smptPort = '465';
    private $smptHost = 'server.encr.co';
    private $mailUsername = 'info@encr.co';
    private $mailPassword = 'Encr.co@ec123';

    protected $inventoryOrgIds;

    public function __construct()
    {
        $this->inventoryOrgIds = OrdersCommenFacade::getEncoreOrgIds()->toArray();
    }

    public function index(Request $request){
        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');

        $factoriesQuery = Factory::select('id', 'factory_code');

        // Orgnnization name serach
            if($request->org){
                $orderQuery->whereHas('organizationDetails', function($query) use($request) {
                    $query->where('organization_name', 'LIKE', '%'.$request->org.'%');
                    $query->whereIn('id', $this->inventoryOrgIds);
                });
                $orderQuery->orWhere('order_no', 'LIKE', '%'.$request->org.'%');
            }
        // factory filter
            if($request->fct){
                $orderQuery->whereHas('orderItems.factoryDetails', function($query) use($request) {
                    $query->where('id', $request->fct);
                });
            }
        // status filter
            if($request->sts){
                $orderQuery->where('order_status_id', $request->sts);
            }

            if($oderSearch == 'factory'){
                $orderQuery->with(['orderItems'=>function($qry) use($factoryIds){
                    $qry->with('factoryDetails')
                        ->whereIn('factory_id', $factoryIds)
                        ->where('order_status_id', 3);
                }]);
                $orderQuery->whereHas('orderItems', function($qr) use($factoryIds){
                                $qr->whereIn('factory_id', $factoryIds)
                                   ->where('order_status_id', 3);
                            });
                $factoriesQuery->whereIn('id', $factoryIds);
            } else {
                $orderQuery->with('orderItems.factoryDetails');
            }

        $orderForCount = $orderQuery->whereIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->orderBy('id', 'DESC')->get();

        $orders = $orderQuery->whereIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->orderBy('id', 'DESC')->paginate(50);

        $factories = $factoriesQuery->where('active', 1)->orderBy('id')->get();

        $orderStatus = OrderStatus::select('id', 'status_name')->where('active', 1)->orderBy('id')->get();

        $orderLayout = InventoryOrderLayout::where('user_id', Auth::user()->id)->first();

        $columnLayout = ColumnLayout::where('interface_id', 17)->where('user_id', Auth::user()->id)->first();

        $organizations = Organization::select('id', 'organization_name')->whereIn('id', $this->inventoryOrgIds)->where('active', 1)->orderBy('organization_name')->get();

        $sales_rep_users = User::where('active', 1)->where('role_id', 'like', '%"3"%')->get();

        $statusCounts = (clone $orderQuery)
        ->whereNotIn('organization_id', $this->inventoryOrgIds)
        ->where('active', 1)
        ->selectRaw("
            SUM(CASE WHEN order_status_id = 3 THEN 1 ELSE 0 END) as production,
            SUM(CASE WHEN order_status_id = 1 THEN 1 ELSE 0 END) as quote,
            SUM(CASE WHEN order_status_id = 4 THEN 1 ELSE 0 END) as fulfilled,
            SUM(CASE WHEN order_status_id = 7 THEN 1 ELSE 0 END) as cancelled
        ")
            ->first();

        return view('pages.order_management.orders_inventory.index', [
            'factories'=>$factories,'orderStatus'=>$orderStatus, 'orderLayout'=>$orderLayout, 'columnLayout'=>$columnLayout, 'orders'=>$orders, 'organizations'=>$organizations , 'orderForCount'=>$orderForCount,
            'sales_rep_users'=>$sales_rep_users, 'statusCounts'=>$statusCounts
        ]);
    }

    public function getOrders() {
        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')
                            ->where('active', 1)
                            ->whereIn('organization_id', $this->inventoryOrgIds);

            if($oderSearch == 'factory'){
                $orderQuery->with(['orderItems'=>function($qry) use($factoryIds){
                                $qry->with('factoryDetails')
                                    ->whereIn('factory_id', $factoryIds)
                                    ->where('order_status_id', 3);
                            }]);
                $orderQuery->whereHas('orderItems', function($qr) use($factoryIds){
                                $qr->whereIn('factory_id', $factoryIds)
                                   ->where('order_status_id', 3);
                            });
            } else {
                $orderQuery->with('orderItems.factoryDetails');
            }

        $orders = $orderQuery->where('active', 1)->get();

        return json_encode($orders);
    }

    public function delete($id){
        $order = OrderItem::find($id);

        $itemTotalAmount = $order->total;

        $itemOrderID =  $order->order_id;

        $orderDetails = Order::find($itemOrderID);


        $subtotal = $orderDetails->sub_total - $itemTotalAmount;

        $organization = Organization::find($orderDetails->organization_id);
        if ($organization->sales_tax_active == 1) {
            $salesTax = $organization->sales_tax;
        } else {
            $salesTax = 0;
        }
        $orderSalesTax = ($subtotal / 100) * $salesTax;
        $TotalAmountwithoutSaleTax = (($orderDetails->order_total - $itemTotalAmount) - $orderDetails->sales_tax ) - $subtotal;



        $orderDetails->sub_total = $subtotal;
        $orderDetails->sales_tax = $orderSalesTax;
        $orderDetails->order_total = $subtotal + $TotalAmountwithoutSaleTax + $orderSalesTax;
        /*
        $ShippedOrders = ShippedOrders::select('id')->where('order_id', $itemOrderID)->where('order_item_id', $id)->get();
        foreach($ShippedOrders as $ShippedOrder){
           $shippedItem = ShippedOrders::find($ShippedOrder->id);
           $shippedItem->delete();
        }*/

        $orderDetails->update();

        $order->delete();

        $this->setShippingFee($itemOrderID);

        return redirect()->to('order_details/edit/'.$itemOrderID.'/order?active_tab=order')->withSuccess('OrderItem Delete Successfully!');
    }

    public function deleteMainOrder($id){
        $order = Order::find($id);
        $order->active = 0;
        $order->update();

        return redirect()->route('orders')->withSuccess('OrderItem Delete Successfully!');
    }

    public function changeFlag($orderId, $flagColor){
        try {
            $order = Order::find($orderId);
            $order->flag = '#'.$flagColor;
            $order->update();
            return json_encode('success');
        } catch (\Exception $ex) {
            return json_encode($ex);
        }
        // return redirect()->route('orders')->withSuccess('Order Flag Changed  Successfully!');
    }

    public function changeFlagByOrder($orderStatus, $exFactoryDate){
        $date = Carbon::now();
        $nowDate = $date->format('Y-m-d');
        $betweenDate = Carbon::now()->addDays(5)->format('Y-m-d');

        if(isset($exFactoryDate)){
            $exFactoryCarbonDate = Carbon::parse($exFactoryDate)->format('Y-m-d');
            if($orderStatus == 3){
                if($exFactoryCarbonDate < $nowDate){
                    $color = '#fb5779';
                } else if($exFactoryCarbonDate == $nowDate){
                    $color = '#19db7d';
                } else if($exFactoryCarbonDate <= $betweenDate && $exFactoryCarbonDate > $nowDate){
                    $color = '#ff7510';
                } else if($exFactoryCarbonDate > $betweenDate){
                    $color = '#f6f8f9';
                }
            } else {
                $color = '#f6f8f9';
            }
        } else {
            $color = '#f6f8f9';
        }
        return $color;
    }

    public function changeFlagByCroneJob(){
        $date = Carbon::now();
        $nowDate = $date->format('Y-m-d');
        $betweenDate = Carbon::now()->addDays(5)->format('Y-m-d');

        $orders = Order::where('order_status_id', 3)->where('active', 1)->get();

        foreach($orders as $order){
            if(isset($order->ex_factory_date)){
                $exFactoryCarbonDate = Carbon::parse($order->ex_factory_date)->format('Y-m-d');
                if($exFactoryCarbonDate < $nowDate){
                    $color = '#fb5779';
                } else if($exFactoryCarbonDate == $nowDate){
                    $color = '#19db7d';
                } else if($exFactoryCarbonDate <= $betweenDate && $exFactoryCarbonDate > $nowDate){
                    $color = '#ff7510';
                } else if($exFactoryCarbonDate > $betweenDate){
                    $color = '#f6f8f9';
                }
            } else {
                $color = '#f6f8f9';
            }
            $order->flag = $color;
            $order->update();
        }
    }

    public function invoice($id){
        $orders = Order::with('organizationDetails', 'userDetails', 'statusDetails', 'contactDetails', 'orderItems',
                              'orderItems.productDetails', 'orderItems.statusDetails')
                       ->where('id', $id)
                       ->get();

        return view('pages.order_management.orders.invoice', ['orders'=>$orders]);
    }

    public function quote($id){
        $orders = Order::with('organizationDetails', 'userDetails', 'statusDetails', 'contactDetails', 'orderItems',
                              'orderItems.productDetails', 'orderItems.statusDetails')
                       ->where('id', $id)
                       ->get();

        return view('pages.order_management.orders.quote', ['orders'=>$orders]);
    }

    public function edit($id){
        $organizations = Organization::select('id', 'organization_name')->whereIn('id', $this->inventoryOrgIds)->where('active', 1)->orderBy('organization_name')->get();

        $orderStatuses = OrderStatus::select('id', 'status_name')->orderBy('id')->get();

        $users = User::select('id', 'name')->orderBy('name')->get();

        $products = Product::select('id','product_name')->where('active',1)->get();

        $fabrics = Fabric::select('id','fabric_name')->where('active',1)->get();

        $embellishments = EmbellishmentType::select('id','embellishment_name')->where('active',1)->get();

        $factories = Factory::select('id', 'factory_name')->where('active', 1)->orderBy('factory_name')->get();


        $orders = Order::with('organizationDetails', 'userDetails', 'statusDetails', 'contactDetails', 'orderItems',
                              'orderItems.productDetails', 'orderItems.statusDetails')
                       ->where('id', $id)
                       ->get();

        // return view('pages.order_management.orders.edit', [
        //     'organizations'=>$organizations, 'orderStatuses'=>$orderStatuses, 'users'=>$users, 'products'=>$products, 'fabrics'=>$fabrics,
        //     'embellishments'=>$embellishments, 'factories'=>$factories, 'orders'=>$orders, 'exFactories'=>$exFactories
        // ]);
        return view('pages.order_management.orders.edit', [
            'organizations'=>$organizations, 'orderStatuses'=>$orderStatuses, 'users'=>$users, 'products'=>$products, 'fabrics'=>$fabrics,
            'embellishments'=>$embellishments, 'factories'=>$factories, 'orders'=>$orders
        ]);
    }

    public function update(Request $request){

        $contact = Contact::with('organizationDetails')->find($request->customer_id);

        $orders = Order::find($request->id);

        //return $orders;
        $orders->organization_id = $request->organization_id;
        $orders->order_description = $request->order_description;

        $orders->flag = $this->changeFlagByOrder($request->order_status_id, $request->ex_factory_date);

        $orders->user_id = $request->user_id;

        $orders->due_date = $request->due_date;

        $orders->is_urgent = $request->is_urgent;

        $originalDueDate = Carbon::parse($request->due_date);
        $ex_factory_date = $originalDueDate->subDays(7)->format('m/d/Y');
        $orders->ex_factory_date = $ex_factory_date;

        $originalDueDate1 = Carbon::parse($request->due_date);
        $est_delivery_date = $originalDueDate1->subDays(2)->format('m/d/Y');
        $orders->est_delivery_date = $est_delivery_date;

        $orderSubTotal = $orders->sub_total;
        $orderSalesTax = $orders->sales_tax;
        if($request->shipping == null){
            $orderShipping = 0;
            $orders->shipping = 0;
        } else {
            $orderShipping = $request->shipping;
            $orders->shipping = $request->shipping;
        }
        if($request->artwork == null){
            $orderArtwork = 0;
            $orders->artwork = 0;
        } else {
            $orderArtwork = $request->artwork;
            $orders->artwork = $request->artwork;
        }
        if($request->processing_fee == null){
            $orderProcessingFee = 0;
            $orders->processing_fee = 0;
        } else {
            $orderProcessingFee = $request->processing_fee;
            $orders->processing_fee = $request->processing_fee;
        }
        $orderFeesTotal = $orderSalesTax + $orderShipping + $orderArtwork + $orderProcessingFee;

        $orders->order_total = $orderSubTotal + $orderFeesTotal;

        $orders->contact_id = $request->customer_id;

        if ($orders->order_type == 1) {
            if ($request->has('shipping_direct_ship_to_customers')) {
                $addressType = 1;
            } else if ($request->has('shipping_bulk_ship_to_coach')) {
                $addressType = 2;
            } else if ($request->has('shipping_pick_up')) {
                $addressType = 3;
            } else if ($request->has('shipping_direct_pick_up')) {
                $addressType = 4;
            }

            $orders->address_type = $addressType;
        }

        if($request->new_shipping_address == 1){
            $orders->is_new_shipping_address = 1;
            $orders->street = $request->new_street;
            $orders->city = $request->new_city;
            $orders->state = $request->new_state;
            $orders->postal_code = $request->new_postal_code;
            $orders->country = $request->new_country;
            $orders->phone_no = $request->new_phone_no;
            $orders->email = $request->new_email;
        } else {
            $orders->is_new_shipping_address = 0;
            $orders->street = $contact->shipping_street;
            $orders->city = $contact->shipping_city;
            $orders->state = $contact->shipping_state;
            $orders->postal_code = $contact->shipping_zip;
            $orders->country = $contact->shipping_country;
            $orders->phone_no = $contact->phone_no;
            $orders->email = $contact->email;
        }

        $allOrderItems = OrderItem::where('order_id', $request->id)->get();

        foreach($allOrderItems as $allOrderItem){
            $item = OrderItem::find($allOrderItem->id);
            $item->order_status_id = $request->order_status_id;
            $item->update();
        }

        if($request->has('orderItems')){
            foreach($request->orderItems as $productDetails){
                $orderItem = OrderItem::find($productDetails['item_id']);
                $orderItem->factory_id = $productDetails['factory_id'];
                $orderItem->update();
            }
        }

        $newOrderItems = [];

        if($request->has('item')){
            foreach($request->item as $itemsDetails){
                $orderItem = new OrderItem();
                $orderItem->item_no = $itemsDetails['item_no'];
                $orderItem->order_id = $request->id;
                $orderItem->is_urgent = $request->is_urgent;
                $orderItem->product_id = $itemsDetails['product_id'];
                $orderItem->organization_id = $itemsDetails['organization_id'];
                $orderItem->factory_id = $itemsDetails['factory_id'];
                $orderItem->support_agent_id = $itemsDetails['support_agent_id'];
                $orderItem->designer_id = $itemsDetails['designer_id'];
                $orderItem->shipping_method = $itemsDetails['shipping_method'];
                $orderItem->ex_factory_id = $itemsDetails['ex_factory_id'];
                $orderItem->in_hand_due_date = $itemsDetails['in_hand_due_date'];
                $orderItem->open_date = Carbon::now()->format('m/d/Y');

                $ex_factory_date = Carbon::parse($orders['due_date'])->subDays(7)->format('m/d/Y');
                $orderItem->est_delivery_date = $ex_factory_date;
                $orderItem->ex_factory_date = $itemsDetails['ex_factory_date'];
                $orderItem->encore_packing_date = $itemsDetails['encore_packing_date'];

                $orderItem->order_status_id = $itemsDetails['status_id'];
                $orderItem->fabric_id = $itemsDetails['fabric_id'];
                $orderItem->secondary_fabric_id = $itemsDetails['secondary_fabric_id'];
                $orderItem->embellishment_type_id = $itemsDetails['embellishment_id'];
                $orderItem->sport = $itemsDetails['sport'];
                $orderItem->gender = $itemsDetails['gender'];
                $orderItem->qty = $itemsDetails['qty'];
                $orderItem->unit_price = $itemsDetails['unit_price'];
                $orderItem->total = $itemsDetails['total'];

                $orderItem->double_sided = isset($itemsDetails['double_sided']) ? 1 : 0;
                $orderItem->individual_no = isset($itemsDetails['individual_no']) ? 1 : 0;
                $orderItem->individual_name = isset($itemsDetails['individual_name']) ? 1 : 0;
                $orderItem->pockets = isset($itemsDetails['pockets']) ? 1 : 0;
                $orderItem->zipper_pockets = isset($itemsDetails['zipper_pockets']) ? 1 : 0;
                $orderItem->dynamic_details = isset($itemsDetails['dynamic_details']) ? 1 : 0;
                $orderItem->contrast_stratching = isset($itemsDetails['contrast_stratching']) ? 1 : 0;
                $orderItem->printing_over_sems = isset($itemsDetails['printing_over_sems']) ? 1 : 0;

                $orderItem->save();

                // if(isset($itemsDetails['itemAttribute_ids'])){
                //     $attribute_ids = explode(',', $itemsDetails['itemAttribute_ids']);
                //     foreach($attribute_ids as $attribute_id){
                //         $orderItemAttribute = new OrderItemAttribute();
                //         $orderItemAttribute->order_item_id = $orderItem->id;
                //         $orderItemAttribute->attribute_id = $attribute_id;
                //         $orderItemAttribute->save();
                //     }
                // }


                $newOrderItems[]=$orderItem;

                $productSizes = ProductSize::select('size_id')->where('product_id', $itemsDetails['product_id'])->get();

                foreach($productSizes as $sizes){
                    $orderItemsDetails = new OrderItemsDetail();
                    $orderItemsDetails->order_item_id = $orderItem->id;
                    $orderItemsDetails->size_id = $sizes['size_id'];
                    $orderItemsDetails->save();
                }
            }
        }

        if(($orders->order_status_id == 3) && (count($newOrderItems) > 0)){
            $this->emailFactoryUsersToInformAddNewItems($orders->id, $newOrderItems);
        }

        if($orders->order_status_id == 1 && $request->order_status_id == 3){
            $orders->production_date = Carbon::now()->format('m/d/Y');
            $this->emailFactoryUsers($orders->id);
            $this->notifyFactoryUsers($orders->id, $request->is_urgent);
        }

        $orders->order_status_id = $request->order_status_id;

        $orders->update();

        return redirect()->to('order_details/edit/'.$request->id.'/order?active_tab=order')->withSuccess('Order Updated Successfully!');
    }

    public function sortByAlphabet($id){
        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $sortedOrderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')
                            ->whereHas('organizationDetails', function($query) use($id) {
                                $query->where('organization_name', 'LIKE', $id.'%');
                                $query->whereIn('id', $this->inventoryOrgIds);
                            });

            if($oderSearch == 'factory'){
                $sortedOrderQuery->with(['orderItems'=>function($qry) use($factoryIds){
                                    $qry->with('factoryDetails')
                                        ->whereIn('factory_id', $factoryIds)
                                        ->where('order_status_id', 3);
                                }]);
                $sortedOrderQuery->whereHas('orderItems', function($qr) use($factoryIds){
                                    $qr->whereIn('factory_id', $factoryIds)
                                       ->where('order_status_id', 3);
                                });
            } else {
                $sortedOrderQuery->with('orderItems.factoryDetails');
            }
        $sortedOrder = $sortedOrderQuery->whereIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->get();

        return json_encode($sortedOrder);
    }

    public function pdf($id){
        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'statusDetails', 'contactDetails');


        $orderItemQuery = OrderItem::with('productDetails', 'factoryDetails', 'exFactoryDetails', 'fabricDetails', 'secFabricDetails',
                                    'embellishmentDetails', 'orderItemDetails.sizeDetails', 'orderItemDetails.sizeDetails','orderItemAttributes.attribute');

        if($oderSearch == 'factory'){
            $orderQuery->with(['orderItems'=>function($qry) use($factoryIds){
                                $qry->with('productDetails', 'statusDetails')
                                    ->whereIn('factory_id', $factoryIds)
                                    ->where('order_status_id', 3);
                            }]);
            $orderItemQuery->whereIn('factory_id', $factoryIds);
        } else {
            $orderQuery->with('orderItems', 'orderItems.productDetails', 'orderItems.statusDetails');
        }

        $orders = $orderQuery->where('id', $id)->get();
        $orderItem = $orderItemQuery->find($id);
        //$blackQty = orderItemsDetail::where('order_item_id', $orderItem->id)->sum('blanks');

        //$numQty = orderItemsDetail::where('order_item_id', $orderItem->id)->sum('qty');

        //return view('pages.order_management.orders.pdf', ['orders'=>$orders, 'orderItem'=>$orderItem, 'blackQty'=>$blackQty, 'numQty'=>$numQty]);
        return view('pages.order_management.orders.pdf', ['orders'=>$orders, 'orderItem'=>$orderItem]);
    }



    public function csv($id){
        $order = Order::with('organizationDetails')->where('id', $id)->first();

        if ($order->order_type == 0) {
            return (new BulkOrderExport($id))->download($order->organizationDetails->organization_name.' - '.$order->order_no.'.xlsx');
        } else {
            return (new TSOrderExport($id))->download($order->organizationDetails->organization_name.' - '.$order->order_no.'.xlsx');
        }
    }

    // public function filterTable($factoryId, $statusId, $paginateNo){
    public function filterTable(Request $request)
{
    $factoryId   = $request->factory_id;
    $statusId    = $request->status_id;
    $orgTxt      = $request->org_txt;
    $paginateNo  = $request->paginate_no;

    $this->userGroupFactories();

    $oderSearch  = $this->oderSearch;
    $factoryIds  = $this->factoryIds;

    // Base Query
    $sortedOrderQuery = Order::with(
        'organizationDetails',
        'userDetails',
        'contactDetails',
        'statusDetails',
        'inventoryDetails',
        'teamStoreDetails'
    );

    /*
    |--------------------------------------------------------------------------
    | Factory + Status Filters
    |--------------------------------------------------------------------------
    */
    if ($factoryId != 0) {
        $sortedOrderQuery->whereHas('orderItems.factoryDetails', function ($query) use ($factoryId) {
            $query->where('id', $factoryId);
        });
    }

    if ($statusId != 0) {
        $sortedOrderQuery->where('order_status_id', $statusId);
    }

    /*
    |--------------------------------------------------------------------------
    | Organization / Order No Search (FIXED OR CONDITION)
    |--------------------------------------------------------------------------
    */
    if (!empty($orgTxt)) {

        $sortedOrderQuery->where(function ($query) use ($orgTxt) {

            $query->whereHas('organizationDetails', function ($q) use ($orgTxt) {
                $q->where('organization_name', 'LIKE', "%{$orgTxt}%")
                  ->whereIn('id', $this->inventoryOrgIds);
            })
            ->orWhere('order_no', 'LIKE', "%{$orgTxt}%");

        });
    }

    /*
    |--------------------------------------------------------------------------
    | Factory mode restriction
    |--------------------------------------------------------------------------
    */
    if ($oderSearch == 'factory') {

        $sortedOrderQuery->with([
            'orderItems' => function ($qry) use ($factoryIds) {
                $qry->with('factoryDetails')
                    ->whereIn('factory_id', $factoryIds)
                    ->where('order_status_id', 3);
            }
        ]);

        $sortedOrderQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
            $qr->whereIn('factory_id', $factoryIds)
               ->where('order_status_id', 3);
        });

    } else {

        $sortedOrderQuery->with('orderItems.factoryDetails');
    }

    /*
    |--------------------------------------------------------------------------
    | Clone base query (IMPORTANT)
    |--------------------------------------------------------------------------
    */
    $baseQuery = clone $sortedOrderQuery;

    /*
    |--------------------------------------------------------------------------
    | Orders (Pagination)
    |--------------------------------------------------------------------------
    */
    $sortedOrder = (clone $baseQuery)
        ->whereIn('organization_id', $this->inventoryOrgIds)
        ->where('active', 1)
        ->orderByDesc('id')
        ->skip(($paginateNo - 1) * 50)
        ->take(50)
        ->get();

    /*
    |--------------------------------------------------------------------------
    | Status Counts (FIXED - NO plorder)
    |--------------------------------------------------------------------------
    */
    $statusCounts = (clone $baseQuery)
        ->whereIn('organization_id', $this->inventoryOrgIds)
        ->where('active', 1)
        ->selectRaw("
            SUM(CASE WHEN order_status_id = 3 THEN 1 ELSE 0 END) as production,
            SUM(CASE WHEN order_status_id = 1 THEN 1 ELSE 0 END) as quote,
            SUM(CASE WHEN order_status_id = 4 THEN 1 ELSE 0 END) as fulfilled,
            SUM(CASE WHEN order_status_id = 7 THEN 1 ELSE 0 END) as cancelled
        ")
        ->first();

    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */
    // Payment Status
    $paymentService = app(\App\Services\PaymentService::class);

    $sortedOrder = $sortedOrder->transform(function ($order) use ($paymentService) {

        $order->payment_status = $paymentService->getPaymentStatus($order->id);

        // Calculate Order Items Qty
        $order->total_order_qty = $order->orderItems->sum('order_qty');

        return $order;
    });
    
    return response()->json([
        $sortedOrder,
        $oderSearch,
        $factoryIds,
        $statusCounts
    ]);
}

    public function exportCsv(){
        $fileName = 'inventory_orders.csv';
        $orders = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails')->whereIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->get();

        $headers = array(
            "Content-type"=>"text/csv",
            "Content-Disposition"=>"attachment; filename=$fileName",
            "Pragma"=>"no-cache",
            "Cache-Control"=>"must-revalidate, post-check=0, pre-check=0",
            "Expires"=>"0"
        );

        $columns = array('Order No', 'Organization', 'Order Status', 'Support Agent', 'Contact Person', 'Order Description',
                            // 'Sub Total', 'Tax Rate', 'Tax Amount', 'Shipping', 'Artwork', 'Processing Fee', 'Order Total',
                            'Shipping Address', 'Billing Address');

        $callback = function() use($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($orders as $order) {
                $shippingAddress = $order->organizationDetails['shipping_po_box'] . ', ' .
                                   $order->organizationDetails['shipping_city'] . ', ' . $order->organizationDetails['shipping_state'] . ', ' .
                                   $order->organizationDetails['shipping_postal_code'] . ', ' . $order->organizationDetails['shipping_country'];

                $billingAddress = $order->organizationDetails['billing_address'] . ', ' . $order->organizationDetails['billing_po_box'] . ', ' .
                                  $order->organizationDetails['billing_city'] . ', ' . $order->organizationDetails['billing_state'] . ', ' .
                                  $order->organizationDetails['billing_postal_code'] . ', ' . $order->organizationDetails['billing_country'];

                $row['Order No'] = $order->order_no;
                $row['Organization'] = $order->organizationDetails['organization_name'];
                $row['Order Status'] = $order->statusDetails['status_name'];
                $row['Support Agent'] = $order->userDetails['name'];
                $row['Contact Person'] = $order->contactDetails['first_name'].' '.$order->contactDetails['last_name'];
                $row['Order Description'] = $order->order_description;
                // $row['Sub Total'] = $order->sub_total;
                // $row['Tax Rate'] = $order->organizationDetails['sales_tax'] . '%';
                // $row['Tax Amount'] = $order->sales_tax;
                // $row['Shipping'] = $order->shipping;
                // $row['Artwork'] = $order->artwork;
                // $row['Processing Fee'] = $order->processing_fee;
                // $row['Order Total'] = $order->order_total;
                $row['Shipping Address'] = $shippingAddress;
                $row['Billing Address'] = $billingAddress;

                fputcsv($file, array(
                    $row['Order No'], $row['Organization'], $row['Order Status'], $row['Support Agent'], $row['Contact Person'], $row['Order Description'],
                    // $row['Sub Total'], $row['Tax Rate'], $row['Tax Amount'], $row['Shipping'], $row['Artwork'], $row['Processing Fee'], $row['Order Total'],
                    $row['Shipping Address'], $row['Billing Address']
                ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function product($productId){
        $product = Product::select('products.product_no', 'products.product_name', 'products.default_price', 'products.pattern_code')
                          ->where('products.id', $productId)->get();

        $product_fabric = ProductFabric::where('product_id', $productId)
                          ->with('fabrics')->get();

        $product_embellishment_type = ProductEmbellishmentType::where('product_id', $productId)
                                      ->with('embellishmentTypes')->get();

        $product_attribute = ProductAttribute::where('product_id', $productId)
                            ->with('attributes')->get();

        echo json_encode([$product,$product_fabric,$product_embellishment_type,$product_attribute]);
    }

    public function productFilter($sport, $gender, $category){
        if($sport != 'all' && $gender != 'all' && $category != 'all'){
            $products = Product::where('sport', 'LIKE', '%'.$sport.'%')
                               ->where('gender', 'LIKE', '%'.$gender.'%')
                               ->where('product_category_id', 'LIKE', '%'.$category.'%')
                               ->where('active', 1)
                               ->orderBy('product_name')
                               ->get();

        } else if($sport != 'all' && $gender != 'all' && $category == 'all'){
            $products = Product::where('sport', 'LIKE', '%'.$sport.'%')
                               ->where('gender', 'LIKE', '%'.$gender.'%')
                               ->where('active', 1)
                               ->orderBy('product_name')
                               ->get();

        } else if($sport != 'all' && $gender == 'all' && $category != 'all'){
            $products = Product::where('sport', 'LIKE', '%'.$sport.'%')
                               ->where('product_category_id', 'LIKE', '%'.$category.'%')
                               ->where('active', 1)
                               ->orderBy('product_name')
                               ->get();

        } else if($sport != 'all' && $gender == 'all' && $category == 'all'){
            $products = Product::where('sport', 'LIKE', '%'.$sport.'%')
                               ->where('active', 1)
                               ->orderBy('product_name')
                               ->get();

        } else if($sport == 'all' && $gender != 'all' && $category != 'all'){
            $products = Product::where('gender', 'LIKE', '%'.$gender.'%')
                               ->where('product_category_id', 'LIKE', '%'.$category.'%')
                               ->where('active', 1)
                               ->orderBy('product_name')
                               ->get();

        } else if($sport == 'all' && $gender != 'all' && $category == 'all'){
            $products = Product::where('gender', 'LIKE', '%'.$gender.'%')
                               ->where('active', 1)
                               ->orderBy('product_name')
                               ->get();

        } else if($sport == 'all' && $gender == 'all' && $category != 'all'){
            $products = Product::where('product_category_id', 'LIKE', '%'.$category.'%')
                               ->where('active', 1)
                               ->orderBy('product_name')
                               ->get();

        } else {
            $products = Product::orderBy('product_name')->get();

        }

        echo json_encode($products);
    }

    public function layout(Request $request){
        if(InventoryOrderLayout::where('user_id', Auth::user()->id)->first()){
            $organizationLayout = InventoryOrderLayout::find($request->layout_id);
            $organizationLayout->order_flag = $request->order_flag;
            $organizationLayout->order_no = $request->order_no;
            $organizationLayout->order_organization = $request->order_organization;
            $organizationLayout->order_factories = $request->order_factories;
            $organizationLayout->order_due_date = $request->order_due_date;
            $organizationLayout->order_open_date = $request->order_open_date;
            $organizationLayout->est_sippping_date = $request->order_est_sippping_date;
            $organizationLayout->order_sales_rep = $request->order_sales_rep;
            // $organizationLayout->order_total = $request->order_total;
            $organizationLayout->order_status = $request->order_status;
            $organizationLayout->inventory_status = $request->inventory_status;
            $organizationLayout->contact_person = $request->contact_person;
            $organizationLayout->order_description = $request->order_description;
            // $organizationLayout->sub_total = $request->sub_total;
            // $organizationLayout->sales_tax = $request->sales_tax;
            // $organizationLayout->shipping = $request->shipping;
            // $organizationLayout->artwork = $request->artwork;
            // $organizationLayout->processing_fee = $request->processing_fee;
            // $organizationLayout->team_store_file = $request->team_store_file;
            $organizationLayout->created = $request->created_at;
            $organizationLayout->updated = $request->updated_at;
            $organizationLayout->update();

            $successMsg = "Updated";

        } else {
            $organizationLayout = new InventoryOrderLayout();
            $organizationLayout->user_id = Auth::user()->id;
            $organizationLayout->order_flag = $request->order_flag;
            $organizationLayout->order_no = $request->order_no;
            $organizationLayout->order_organization = $request->order_organization;
            $organizationLayout->order_factories = $request->order_factories;
            $organizationLayout->order_due_date = $request->order_due_date;
            $organizationLayout->order_open_date = $request->order_open_date;
            $organizationLayout->est_sippping_date = $request->order_est_sippping_date;
            $organizationLayout->order_sales_rep = $request->order_sales_rep;
            // $organizationLayout->order_total = $request->order_total;
            $organizationLayout->order_status = $request->order_status;
            $organizationLayout->inventory_status = $request->inventory_status;
            $organizationLayout->contact_person = $request->contact_person;
            $organizationLayout->order_description = $request->order_description;
            // $organizationLayout->sub_total = $request->sub_total;
            // $organizationLayout->sales_tax = $request->sales_tax;
            // $organizationLayout->shipping = $request->shipping;
            // $organizationLayout->artwork = $request->artwork;
            // $organizationLayout->processing_fee = $request->processing_fee;
            // $organizationLayout->team_store_file = $request->team_store_file;
            $organizationLayout->created = $request->created_at;
            $organizationLayout->updated = $request->updated_at;
            $organizationLayout->save();

            $successMsg = "Saved";
        }

        return json_encode($successMsg);
    }

    public function userGroupFactories(){
        $user = Auth::user();
        $factoryIds = [];
        if($user->hasRole([1, 2, 3, 4, 10])){
            $oderSearch = 'all';
        } else {
            $oderSearch = 'factory';
            foreach($user->roles as $userRole){
                if($userRole->id == 5){     // PBS Factory
                    $factoryIds[] = 2;  // PBS
                }
                if($userRole->id == 6){     // WDC Factory
                    $factoryIds[] = 1;  // WDC
                }
                if($userRole->id == 7){     // BII Factory
                    $factoryIds[] = 3;  // BII
                }
                if($userRole->id == 8){     // UET Factory
                    $factoryIds[] = 7;  // UET
                }
                if($userRole->id == 11){     // ZYS Factory
                    $factoryIds[] = 10;  // ZYS
                }
                if($userRole->id == 12){     // Test Factory
                    $factoryIds[] = 16;  // Test
                }
            }
        }

        $this->oderSearch = $oderSearch;
        $this->factoryIds = $factoryIds;

        return $this;
    }

    public function setShippingFee($orderId){
        $order = Order::find($orderId);
        $orderQty = OrderItem::where('order_id', $orderId)->get()->sum('qty');
        if($orderQty > 70){
            $shippingFee = 0.5 * $orderQty;
        } else if($orderQty == 0){
            $shippingFee = 0;
        } else {
            $shippingFee = 35;
        }
        $order->shipping = $shippingFee;
        $order->update();
    }

    public function notifyFactoryUsers($orderId, $isUrgent){
        $allOrderItems = OrderItem::where('order_id', $orderId)->get();

        $factoryArray = [];
        foreach($allOrderItems as $allOrderItem){
            $item = OrderItem::find($allOrderItem->id);
            if(isset($item->factory_id)){
                $factoryArray[] = $item->factory_id;
            }
        }

        if($factoryArray){
            foreach (array_unique($factoryArray) as $factory_id) {
                if($factory_id == 2){     // PBS Factory
                    $userRoleId = 5;  // PBS
                }
                if($factory_id == 1){     // WDC Factory
                    $userRoleId = 6;  // WDC
                }
                if($factory_id == 3){     // BII Factory
                    $userRoleId = 7;  // BII
                }
                if($factory_id == 7){     // UET Factory
                    $userRoleId = 8;  // UET
                }
                if($factory_id == 10){     // ZYS Factory
                    $userRoleId = 11;  // ZYS
                }
                if($factory_id == 16){     // Test Factory
                    $userRoleId = 12;  // Test
                }

                $orderDetails = Order::find($item->order_id);

                $orderItems = OrderItem::where('order_id', $item->order_id)->where('factory_id', $factory_id)->get();

                $userIds =  User::whereHas("roles", function($q) use($userRoleId) {
                                                $q->where("id", $userRoleId);
                                            })->where('active', 1)->get()->pluck('id');

                // foreach($userIds as $user){
                    // $notification = new Notification();
                    // $notification->notification_title = 'Moved To Production | Order - #'.$orderDetails->order_no.' | Item - '.$item->productDetails->product_name;

                    // $message = 'Order #'.$orderDetails->order_no.' has been moved to production.<ul><li style="text-align: left; list-style-type: none;"><u>Items in this order:</u></li>';
                    $itemlist = '';

                    foreach($orderItems as $orderItem){
                        $itemlist = $itemlist."<li style='text-align: left;'>".$orderItem->productDetails->product_name."</li>";
                    }

                    // $message = $message."</ul>";
                    $orderItemIds = OrderItem::where('order_id', $item->order_id)->where('factory_id', $factory_id)->where('support_agent_id', $user)->get();

                    $ids = [];

                    foreach($orderItemIds as $ordersItem) {
                        $ids[] = $ordersItem->id;
                    }

                    $commaSeparatedIds = implode(',', $ids);

                    // $notification->order_item_id = $commaSeparatedIds;


                    // $notification->notification_message = $message;
                    // $notification->user_id = $user;
                    // $notification->order_id = $item->order_id;
                    // $notification->is_urgent = $isUrgent;
                    // $notification->order_ex_fac_date = $orderDetails->ex_factory_date;
                    // $notification->order_in_hand_due_date = $orderDetails->due_date;
                    // $notification->save();
                // }
                $builder = new NotificationBuilderService();

                $builder->sendNotification('key_order_Moved_To_Production', [
                    '{order_no}' => $orderDetails->order_no,
                    '{product_name}' => $item->productDetails->product_name,
                    '{item_list}' => $itemlist,
                ], [

                    'order_id' => $item->order_id,
                    'is_urgent' => $isUrgent,
                    'order_ex_fac_date' => $orderDetails->ex_factory_date,
                    'order_in_hand_due_date' => $orderDetails->due_date,
                    'order_item_id' => $commaSeparatedIds,
                ]);
            }
        }
    }

    public function emailFactoryUsers($orderId){
        $allOrderItems = OrderItem::where('order_id', $orderId)->get();

        $factoryArray = [];
        foreach($allOrderItems as $allOrderItem){
            $item = OrderItem::find($allOrderItem->id);
            if(isset($item->factory_id)){
                $factoryArray[] = $item->factory_id;
            }
        }

        if($factoryArray){
            foreach (array_unique($factoryArray) as $factory_id) {
                $data["cc"] = [];
                array_push($data["cc"], 'alissha@encorebrand.com');

                if($factory_id == 2){     // PBS Factory
                    $userRoleId = 5;  // PBS
                }
                if($factory_id == 1){     // WDC Factory
                    $userRoleId = 6;  // WDC
                }
                if($factory_id == 3){     // BII Factory
                    $userRoleId = 7;  // BII
                }
                if($factory_id == 7){     // UET Factory
                    $userRoleId = 8;  // UET
                }
                if($factory_id == 10){     // ZYS Factory
                    $userRoleId = 11;  // ZYS
                }
                if($factory_id == 16){     // Test Factory
                    $userRoleId = 12;  // Test
                }

                $orderDetails = Order::find($orderId);

                $users =  User::select('id', 'email')->whereHas("roles", function($q) use($userRoleId) {
                                                $q->where("id", $userRoleId);
                                            })->where('active', 1)->get();

                foreach($users as $user){
                    config(['mail.host' => $this->smptHost]);
                    config(['mail.port' => $this->smptPort]);
                    config(['mail.encryption' => $this->smptEncryption]);
                    config(['mail.username' => $this->mailUsername]); //logged user email
                    config(['mail.password' => $this->mailPassword]); //logged user email pass

                    $fromSettings = [
                        'address' => $this->mailUsername,
                        'name' => 'Encore Custom',
                    ];
                    config(['mail.from' => $fromSettings]);

                    $orderItems = OrderItem::where('order_id', $orderId)->where('factory_id', $factory_id)->get();
                    $orderItemArray = '';
                    foreach ($orderItems as $orderItem) {
                        $orderItemArray .= '<li>'.$orderItem->productDetails->product_name.'</li>';
                    }

                    $teamName = '<p style="margin-top: 0.1rem;">Team Name: '.$orderDetails->organizationDetails->organization_name.'</p>';
                    $exFactDate = '<p style="margin-top: 0.1rem;">Ex Factory Date: '.$orderDetails->ex_factory_date.'</p>';
                    $inHandDate = '<p style="margin-top: 0.1rem;">In Hand Due Date: '.$orderDetails->due_date.'</p>';

                    $data["to"] = $user->email;
                    $data["subject"] = 'New Order Encore Production | Order - #'.$orderDetails->order_no.' | Team - '.$orderDetails->organizationDetails->organization_name;
                    $data["body"] = '<table>'. $teamName . $exFactDate . $inHandDate .'</table><p>Following items has been moved to production regarding order <a target="_blank" href="https://encr.co/order_details/edit/'.$orderId.'/order?active_tab=order">#'.$orderDetails->order_no.'</a></p><ul>'.$orderItemArray.'</ul>';

                    // Mail::send('emailNotification.factory_notification', $data, function ($message) use ($data) {
                    //     $message->to($data["to"]);
                    //     $message->cc($data["cc"]);
                    //     $message->subject($data["subject"]);
                    // });
                }
            }
            email_Notify()->sendEmailFromTemplate('key_email_moveToProduction', [
                'orderId' => $orderId,
                'orderNo' => $orderDetails->order_no,
                'organizationname' => $orderDetails->organizationDetails->organization_name,
                'exFactory_date' => $orderDetails->ex_factory_date,
                'inHandDueDate' => $orderDetails->due_date,
                'send_relevent_factory' => true,
            ]);
        }
    }

    public function emailFactoryUsersToInformAddNewItems($orderId, $newOrderItems){
        $factoryArray = [];
        foreach($newOrderItems as $newOrderItem){
            $item = OrderItem::find($newOrderItem->id);
            if(isset($item->factory_id)){
                $factoryArray[] = $item->factory_id;
            }
        }

        if($factoryArray){
            foreach (array_unique($factoryArray) as $factory_id) {
                $data["cc"] = [];

                if($factory_id == 2){     // PBS Factory
                    $userRoleId = 5;  // PBS
                }
                if($factory_id == 1){     // WDC Factory
                    $userRoleId = 6;  // WDC
                }
                if($factory_id == 3){     // BII Factory
                    $userRoleId = 7;  // BII
                }
                if($factory_id == 7){     // UET Factory
                    $userRoleId = 8;  // UET
                }
                if($factory_id == 10){     // ZYS Factory
                    $userRoleId = 11;  // ZYS
                }
                if($factory_id == 16){     // Test Factory
                    $userRoleId = 12;  // Test
                }

                $orderDetails = Order::find($orderId);

                $users =  User::select('id', 'email')->whereHas("roles", function($q) use($userRoleId) {
                                                $q->where("id", $userRoleId);
                                            })->where('active', 1)->get();

                foreach($users as $user){
                    config(['mail.host' => $this->smptHost]);
                    config(['mail.port' => $this->smptPort]);
                    config(['mail.encryption' => $this->smptEncryption]);
                    config(['mail.username' => $this->mailUsername]); //logged user email
                    config(['mail.password' => $this->mailPassword]); //logged user email pass

                    $fromSettings = [
                        'address' => $this->mailUsername,
                        'name' => 'Encore Custom',
                    ];
                    config(['mail.from' => $fromSettings]);

                    $orderItemArray = '';
                    foreach ($newOrderItems as $orderItem) {
                        $orderItemArray .= '<li>'.$orderItem->productDetails->product_name.'</li>';
                    }

                    $data["to"] = $user->email;
                    $data["subject"] = 'New Order Encore Production | Order - #'.$orderDetails->order_no.' | Team - '.$orderDetails->organizationDetails->organization_name;
                    $data["body"] = '<p>Following items has been added to order <a target="_blank" href="https://encr.co/order_details/edit/'.$orderId.'/order?active_tab=order">#'.$orderDetails->order_no.'</a></p><ul>'.$orderItemArray.'</ul>';

                    // Mail::send('emailNotification.factory_notification', $data, function ($message) use ($data) {
                    //     $message->to($data["to"]);
                    //     $message->cc($data["cc"]);
                    //     $message->subject($data["subject"]);
                    // });

                    //////////////////////////////////////////////////////////////////////
                    // $notification = new Notification();
                    // $notification->notification_title = 'Added New Item | Order - #'.$orderDetails->order_no.' | Item - '.$item->productDetails->product_name;

                    // $message = 'Order #'.$orderDetails->order_no.' has been added a new item.<ul><li style="text-align: left; list-style-type: none;"><u>Items in this order:</u></li>';


                    // $message = $message."</ul>";

                    // $notification->notification_message = $message;
                    // $notification->user_id = $user;
                    // $notification->order_id = $item->order_id;
                    // $notification->save();
                }
                $itemlist = '';
                foreach($newOrderItems as $orderItem){
                    $itemlist = $itemlist."<li style='text-align: left;'>".$orderItem->productDetails->product_name."</li>";
                }
            }
            $builder = new NotificationBuilderService();

            $builder->sendNotification('key_order_add_new_item', [
                '{order_no}' => $orderDetails->order_no,
                '{product_name}' => $item->productDetails->product_name,
                '{item_list}' => $itemlist,
            ], [

                'order_id' => $item->order_id,
            ]);
            email_Notify()->sendEmailFromTemplate('key_email_moveToProduction', [
                'orderId' => $orderId,
                'orderNo' => $orderDetails->order_no,
                'organizationname' => $orderDetails->organizationDetails->organization_name,
                'send_relevent_factory' => true,
                'factorys_array' => $factoryArray,
                'new_order_items' => $newOrderItems,
            ]);
        }
    }

    public function columnLayout(Request $request){
        $orderLayout = new InventoryOrderLayout();
        $orderLayout->user_id = Auth::user()->id;
        $orderLayout->save();

        return json_encode('Orders Column Layout Created!');
    }

    public function showColumn(Request $request){
        $orderLayout = InventoryOrderLayout::where('user_id', Auth::user()->id)->first();

        if ($request->attribute_name == 'order_flag') {
            $orderLayout->order_flag = 1;

        } else if ($request->attribute_name == 'order_no') {
            $orderLayout->order_no = 1;

        } else if ($request->attribute_name == 'order_organization') {
            $orderLayout->order_organization = 1;

        } else if ($request->attribute_name == 'order_factories') {
            $orderLayout->order_factories = 1;

        } else if ($request->attribute_name == 'order_due_date') {
            $orderLayout->order_due_date = 1;

        } else if ($request->attribute_name == 'order_open_date') {
            $orderLayout->order_open_date = 1;

        } else if ($request->attribute_name == 'order_est_sippping_date') {
            $orderLayout->est_sippping_date = 1;

        } else if ($request->attribute_name == 'order_sales_rep') {
            $orderLayout->order_sales_rep = 1;

        } else if ($request->attribute_name == 'order_status') {
            $orderLayout->order_status = 1;

        } else if ($request->attribute_name == 'inventory_status') {
            $orderLayout->inventory_status = 1;

        } else if ($request->attribute_name == 'contact_person') {
            $orderLayout->contact_person = 1;

        } else if ($request->attribute_name == 'order_description') {
            $orderLayout->order_description = 1;

        } else if ($request->attribute_name == 'created_at') {
            $orderLayout->created = 1;

        } else if ($request->attribute_name == 'updated_at') {
            $orderLayout->updated = 1;

        }
        $orderLayout->update();

        return json_encode('Orders Column Show!');
    }

    public function hideColumn(Request $request){
        $orderLayout = InventoryOrderLayout::where('user_id', Auth::user()->id)->first();

        if ($request->attribute_name == 'order_flag') {
            $orderLayout->order_flag = 0;

        } else if ($request->attribute_name == 'order_no') {
            $orderLayout->order_no = 0;

        } else if ($request->attribute_name == 'order_organization') {
            $orderLayout->order_organization = 0;

        } else if ($request->attribute_name == 'order_factories') {
            $orderLayout->order_factories = 0;

        } else if ($request->attribute_name == 'order_due_date') {
            $orderLayout->order_due_date = 0;

        } else if ($request->attribute_name == 'order_open_date') {
            $orderLayout->order_open_date = 0;

        } else if ($request->attribute_name == 'order_est_sippping_date') {
            $orderLayout->est_sippping_date = 0;

        } else if ($request->attribute_name == 'order_sales_rep') {
            $orderLayout->order_sales_rep = 0;

        } else if ($request->attribute_name == 'order_status') {
            $orderLayout->order_status = 0;

        } else if ($request->attribute_name == 'inventory_status') {
            $orderLayout->inventory_status = 0;

        } else if ($request->attribute_name == 'contact_person') {
            $orderLayout->contact_person = 0;

        } else if ($request->attribute_name == 'order_description') {
            $orderLayout->order_description = 0;

        } else if ($request->attribute_name == 'created_at') {
            $orderLayout->created = 0;

        } else if ($request->attribute_name == 'updated_at') {
            $orderLayout->updated = 0;

        }
        $orderLayout->update();

        return json_encode('Orders Column Hide!');
    }
    public function fullfill_order(Request $request){
        $orderId = $request->input('orderId');
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        $order->order_status_id = 4;
        $order->save();

        return response()->json(['message' => 'Order status updated successfully'], 200);

    }

    public function getOrderWithInventoryDetail($id)
    {
        $order = Order::with('orderItems', 'inventoryDetails')->find($id);
        $inventory = InventoryAddedOrder::where('order_id', $id)->first();
        return view('pages.order_management.orders_inventory.partials.inventory_details_modal_form', compact('order', 'inventory'));
    }

    public function addToInventory(Request $request)
    {
        try {
            $data = $request->all();
            $data['sent_by'] = auth()->user()->id;
            $inventory = InventoryAddedOrder::where('order_id', $request->order_id)->first();
            if($inventory){
                $data['status'] = 1;
                // dd($data);
                $inventory->update($data);
            } else {
                InventoryAddedOrder::create($data);
            }
            return redirect()->back()->withSuccess('Order has successfuly sent to inventory.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function cancelAddingOrderToInventory($id)
    {
        try {
            $inventory = InventoryAddedOrder::find($id);
            $inventory->status = 0;
            $inventory->update();
            return redirect()->back()->withSuccess('Order has canceled sending to inventory.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
