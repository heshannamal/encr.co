<?php

namespace App\Http\Controllers;

use Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Fabric;
use App\Models\Contact;
use App\Models\Factory;
use App\Models\Product;
use App\Models\SubProduct;
use App\Models\OrderItem;
use App\Models\OrderLayout;
use App\Models\OrderStatus;
use App\Models\ProductSize;
use App\Models\ColumnLayout;
use App\Models\Notification;
use App\Models\Organization;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Models\ProductFabric;
use App\Models\ShippedOrders;
use App\Exports\TSOrderExport;
use App\Exports\BulkOrderExport;
use App\Exports\OrderItemExport;
use App\Models\OrderItemsDetail;
use App\Models\ProductAttribute;
use App\Models\Attribute;
use App\Models\EmbellishmentType;
use App\Models\OrderItemAttribute;
use domainencore\Facades\OrdersCommenFacade\OrdersCommenFacade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\ProductEmbellishmentType;
use App\Models\ProductFactory;
use App\Models\PaymentLog;
use App\Models\CheckPayment;
use App\Models\PaypalPayment;
use App\Models\OrderItemsDetailPlayerName;
use App\Models\VenmoPayment;
use App\Services\PaymentService;
use App\Models\StoreOrder;
use App\Models\StoreOrderItem;
use App\Models\StoreOrderPlayerDetail;
use App\Models\PmSection;
use App\Models\PmSectionDiscussion;
use App\Models\PmSectionSubDiscussion;
use DateTime;
use \ZipArchive;
use App\Models\AccountsLog;
use App\Services\EmailNotificationBuilderService;
use App\Services\NotificationBuilderService;

class OrderController extends Controller
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
    protected $PaymentService;
    protected $notification_builder;

    public function __construct(PaymentService $PaymentService)
    {
        $this->inventoryOrgIds = OrdersCommenFacade::getEncoreOrgIds()->toArray();
        $this->PaymentService = $PaymentService;
        $this->notification_builder = new NotificationBuilderService();
    }

    public function index(Request $request){
        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;
        $sales_rep_users = User::where('role_id', 'like', '%"3"%')->get();
        // dd($request->type , $request->date);
        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')->where('plorder', 0);

        $factoriesQuery = Factory::select('id', 'factory_code');

        // Orgnnization name serach
            if ($request->org) {

                $search = trim($request->org);

                $orderQuery->where(function ($q) use ($search) {

                    $q->whereHas('organizationDetails', function ($query) use ($search) {

                        $query->where('organization_name', 'LIKE', '%' . $search . '%')
                            ->whereNotIn('id', $this->inventoryOrgIds);

                    })
                    ->orWhere('order_no', 'LIKE', '%' . $search . '%');

                });
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
                        ->whereIn('order_status_id', [3, 4, 8]);
                }]);
                $orderQuery->whereHas('orderItems', function($qr) use($factoryIds){
                                $qr->whereIn('factory_id', $factoryIds)
                                   ->whereIn('order_status_id', [3, 4, 8]);
                            });
                $factoriesQuery->whereIn('id', $factoryIds);
            } else {
                $orderQuery->with('orderItems.factoryDetails');
            }
        // Date filter directly on orders table
            if ($request->type && $request->date) {
                $searchDate = $request->date; // Directly use it
            // dd($searchDate);
                if ($request->type == 0) {
                    $orderQuery->where('ex_factory_date', $searchDate);
                } elseif ($request->type == 1) {
                    $orderQuery->where('due_date', $searchDate);
                    // dd($searchDate);
                }
            }
            // rep filter directly on orders table
            if ($request->rep) {
                    $orderQuery->where('user_id', $request->rep);
            }

        // $orderForCount = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->orderBy('id', 'DESC')->get();

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

        // dd($orderForCount);
        $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->orderBy('id', 'DESC')->paginate(50);
        // Process each order and add payment status
        $orders->getCollection()->transform(function ($order) {
            $order->payment_status = $this->PaymentService->getPaymentStatus($order->id);
            return $order;
        });

        $factories = $factoriesQuery->where('active', 1)->orderBy('id')->get();

        $orderStatus = OrderStatus::select('id', 'status_name')->where('active', 1)->orderBy('id')->get();

        $orderLayout = OrderLayout::where('user_id', Auth::user()->id)->first();

        $columnLayout = ColumnLayout::where('interface_id', 3)->where('user_id', Auth::user()->id)->first();

        $organizations = Organization::select('id', 'organization_name')->where('active', 1)->orderBy('organization_name')->get();

        $attributes = Attribute::where('active', 1)->get();

        return view('pages.order_management.orders.index', [
            'factories'=>$factories,'orderStatus'=>$orderStatus, 'orderLayout'=>$orderLayout, 'columnLayout'=>$columnLayout, 'orders'=>$orders, 'organizations'=>$organizations , 'statusCounts'=>$statusCounts, 'attributes'=>$attributes, 'sales_rep_users'=> $sales_rep_users
        ]);
    }
    public function pl_index(Request $request)
{
    $this->userGroupFactories();
    $oderSearch = $this->oderSearch;
    $factoryIds = $this->factoryIds;
    $sales_rep_users = User::where('active', 1)->where('role_id', 'like', '%"3"%')->get();
    // Base Query
    $orderQuery = Order::with([
        'organizationDetails',
        'userDetails',
        'contactDetails',
        'statusDetails',
        'teamStoreDetails'
    ]);

    $factoriesQuery = Factory::select('id', 'factory_code');

    // Organization Search
    if ($request->org) {
        $orderQuery->where(function ($query) use ($request) {
            $query->whereHas('organizationDetails', function ($subQuery) use ($request) {
                $subQuery->where('organization_name', 'LIKE', '%' . $request->org . '%')
                    ->whereNotIn('id', $this->inventoryOrgIds);
            })
            ->orWhere('order_no', 'LIKE', '%' . $request->org . '%'); // Fix: Ensuring this doesn't override other conditions
        });
    }

    // Factory Filter
    if ($request->fct) {
        $orderQuery->whereHas('orderItems.factoryDetails', function ($query) use ($request) {
            $query->where('id', $request->fct);
        });
    }

    // Status Filter
    if ($request->sts) {
        $orderQuery->where('order_status_id', $request->sts);
    }

    // Factory-Specific Query Modifications
    if ($oderSearch == 'factory') {
        $orderQuery->with(['orderItems' => function ($qry) use ($factoryIds) {
            $qry->with('factoryDetails')
                ->whereIn('factory_id', $factoryIds)
                ->whereIn('order_status_id', [3, 4, 8]);
        }]);

        $orderQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
            $qr->whereIn('factory_id', $factoryIds)
                ->whereIn('order_status_id', [3, 4, 8]);
        });

        $factoriesQuery->whereIn('id', $factoryIds);
    } else {
        $orderQuery->with('orderItems.factoryDetails');
    }

    // Clone query before modifying for `plorder = 1`
    $orderQueryForPl = clone $orderQuery;


    // Fetch paginated orders with `plorder = 1`
    $orderForCount = $orderQueryForPl
        ->whereNotIn('organization_id', $this->inventoryOrgIds)
        ->where('plorder', 1)
        ->where('active', 1)
        ->orderBy('id', 'DESC')
        ->paginate(50);

    // Fetch paginated orders with `plorder = 1`
    $orders = $orderQueryForPl
        ->whereNotIn('organization_id', $this->inventoryOrgIds)
        ->where('plorder', 1)
        ->where('active', 1)
        ->orderBy('id', 'DESC')
        ->paginate(50);

    // Process each order and add payment status
    $orders->getCollection()->transform(function ($order) {
        $order->payment_status = $this->PaymentService->getPaymentStatus($order->id);
        return $order;
    });

    // Fetch factories
    $factories = $factoriesQuery
        ->where('active', 1)
        ->orderBy('id')
        ->get();

    $orderStatus = OrderStatus::select('id', 'status_name')
        ->where('active', 1)
        ->orderBy('id')
        ->get();

    $orderLayout = OrderLayout::where('user_id', Auth::user()->id)->first();

    $columnLayout = ColumnLayout::where('interface_id', 3)
        ->where('user_id', Auth::user()->id)
        ->first();

    $organizations = Organization::select('id', 'organization_name')
        ->where('active', 1)
        ->orderBy('organization_name')
        ->get();

    $attributes = Attribute::where('active', 1)->get();

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

    return view('pages.order_management.orders.pl_index', [
        'factories' => $factories,
        'orderStatus' => $orderStatus,
        'orderLayout' => $orderLayout,
        'columnLayout' => $columnLayout,
        'orders' => $orders,
        'organizations' => $organizations,
        'orderForCount' => $orderForCount,
        'attributes' => $attributes,
        'sales_rep_users'=> $sales_rep_users,
        'statusCounts' => $statusCounts
    ]);
}

    public function organization_without_activities()
    {
        $organizations = Organization::whereDoesntHave('activities', function ($query) {
                    $query->where('active', 1);
                })
                ->where('active', 1)->get();

            return view(
                'pages.order_management.orders.organization_without_activities',
                compact('organizations')
            );
    }

    public function organization_without_activities_export()
    {
        $fileName = 'organizations_without_activities_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () {

            $handle = fopen('php://output', 'w');

            // CSV headings
            fputcsv($handle, [
                'Organization Name',
                'Sport',
                'Website',
                'Country',
                'Sales Tax',
                'Sales Tax Status',
                'Created At',
            ]);

            // Data
            Organization::whereDoesntHave('activities', function ($query) {
                    $query->where('active', 1);
                })
                ->where('active', 1)
                ->chunk(500, function ($organizations) use ($handle) {

                    foreach ($organizations as $organization) {
                        fputcsv($handle, [
                            $organization->organization_name,
                            $organization->sport ?? 'N/A',
                            $organization->website ?? 'N/A',
                            $organization->shipping_country ?? 'N/A',
                            number_format($organization->sales_tax, 2),
                            $organization->sales_tax_active ? 'Active' : 'Inactive',
                            $organization->created_at->format('Y-m-d'),
                        ]);
                    }
                });

            fclose($handle);

        }, $fileName, [
            'Content-Type' => 'text/csv',
            'Cache-Control' => 'no-store, no-cache',
        ]);
    }


    public function getOrders() {
        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')
                            ->where('active', 1);

            if($oderSearch == 'factory'){
                $orderQuery->with(['orderItems'=>function($qry) use($factoryIds){
                                $qry->with('factoryDetails')
                                    ->whereIn('factory_id', $factoryIds)
                                    ->whereIn('order_status_id', [3, 4, 8]);
                            }]);
                $orderQuery->whereHas('orderItems', function($qr) use($factoryIds){
                                $qr->whereIn('factory_id', $factoryIds)
                                   ->whereIn('order_status_id', [3, 4, 8]);
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

        $order->delete();

        $this->setShippingFee($itemOrderID);

        $orderDetails = Order::find($itemOrderID);

        $subtotal = $orderDetails->sub_total - $itemTotalAmount;
        $orderSalesTax = $orderDetails->sales_tax ?? 0.00;

        $organization = Organization::find($orderDetails->organization_id);
        if ($organization->sales_tax_active == 1) {
            $salesTax = $organization->sales_tax;
        } else {
            $salesTax = 0;
        }

        $orderShipping = $orderDetails->shipping ?? 0.00;
        $orderArtwork = $orderDetails->artwork ?? 0.00;

        $order_total_amount = $subtotal + $orderArtwork;

        if($orderDetails->discount_hidation == 1 ){

            if($orderDetails->discountType == 1){

                $discountAmount = ($order_total_amount / 100) * $orderDetails->discount;

            } elseif($orderDetails->discountType == 2) {

                $discountAmount = $orderDetails->discount;
            }

        }else{
            $discountAmount = 0.00;
        }

        $orderSalesTax = (($order_total_amount - $discountAmount) / 100) * $salesTax;

        $orderDetails->sub_total = $subtotal;
        $orderDetails->order_total = $order_total_amount + $orderSalesTax - $discountAmount + $orderShipping;
        $orderDetails->sales_tax = $orderSalesTax;
        $orderDetails->save();

        AccountsLog::where('order_id', $orderDetails->id)->where('type', 0)->where('status', 1)->where('note', 'Outstanding Invoice')->update(
            [
                'amount' => $orderDetails->order_total,
                'debit_balance' => $orderDetails->order_total,
            ]
        );

        return redirect()->to('order_details/edit/'.$itemOrderID.'/order?active_tab=order')->withSuccess('OrderItem Delete Successfully!');
    }

    public function deleteMainOrder($id){
        $order = Order::find($id);
        $order->active = 0;
        $order->update();

        AccountsLog::where('order_id', $order->id)->where('type', 0)->where('status', 1)->where('note', 'Outstanding Invoice')->where('active', 1)->update(
            [
                'active' => 0
            ]
        );

        if(str_starts_with($order->order_no, 'TSR')){
            $storeOrders = StoreOrder::where('system_order_no', $order->order_no)->where('active', 1)->get() ?? [];
            if($storeOrders->count() > 0){
                foreach($storeOrders as $storeOrder){
                    $storeOrder->system_order_no = NULL;
                    $storeOrderItems = StoreOrderItem::where('store_order_id', $storeOrder->id)->get() ?? [];
                    foreach($storeOrderItems as $storeOrderItem){
                        $storeOrderItem->system_order_reference = NULL;
                        $storeOrderItem->update();
                    }
                    $storeOrder->update();
                }
            }
        }

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
        $orders = Order::with('organizationDetails', 'userDetails', 'statusDetails', 'contactDetails', 'billingDetails', 'orderItems',
                              'orderItems.productDetails', 'orderItems.statusDetails')
                       ->where('id', $id)
                       ->get();

        $order = Order::find($id);

        $cardPayment = PaymentLog::where('order_id', $id)->sum('amount');
        $checkPayment = CheckPayment::where('order_id', $id)->where('is_approved' , 1)->sum('amount');
        $paypalPayement = PaypalPayment::where('order_id', $id)->where('is_approved' , 1)->sum('amount');
        $venmoPayment = VenmoPayment::where('order_id', $id)->where('is_approved' , 1)->sum('amount');

        $payment = 0;

        if($cardPayment > 0 && $paypalPayement > 0){
            $payment = round(((($cardPayment + $paypalPayement) * 100)/103),2) + $checkPayment + $venmoPayment;

        } else if ($cardPayment > 0 && $paypalPayement == 0) {
            $payment = round(($cardPayment * 100)/103,2) + $checkPayment + $venmoPayment;

        } else if ($cardPayment == 0 && $paypalPayement > 0) {
            $payment = $checkPayment + round((($paypalPayement * 100)/103),2) + $venmoPayment;

        } else {
            $payment = round(($cardPayment + $checkPayment + $paypalPayement + $venmoPayment),2);
        }

        $balnceToBePaid = 0;
        $processingFee = 0;
        $orderTotal = $orders->sum('order_total');
        $totalPayment = round($cardPayment, 2) + round($paypalPayement, 2);

        if ($payment == 0) {
            $paymentStatus = 0; // Pending

        } else if ($payment < round($order->order_total, 2) && $payment > 0) {
            $paymentStatus = 1; // Partial
            $balnceToBePaid = $order->order_total - $payment;

        } else {
            $paymentStatus = 2; // Paid
            if($totalPayment > 0 && $totalPayment > $orderTotal){
                $processingFee = $totalPayment - $orderTotal;
            }
        }

        return view('pages.order_management.orders.invoice', ['orders'=>$orders , 'processingFee'=>$processingFee]);
    }

    public function quote($id){
        $orders = Order::with('organizationDetails', 'userDetails', 'statusDetails', 'contactDetails', 'orderItems',
                              'orderItems.productDetails', 'orderItems.statusDetails')
                       ->where('id', $id)
                       ->get();
        $order = Order::find($id);

        $cardPayment = PaymentLog::where('order_id', $id)->sum('amount');
        $checkPayment = CheckPayment::where('order_id', $id)->where('is_approved' , 1)->sum('amount');
        $paypalPayement = PaypalPayment::where('order_id', $id)->where('is_approved' , 1)->sum('amount');
        $venmoPayment = VenmoPayment::where('order_id', $id)->where('is_approved' , 1)->sum('amount');

        $payment = 0;

        if($cardPayment > 0 && $paypalPayement > 0){
            $payment = round(((($cardPayment + $paypalPayement) * 100)/103),2) + $checkPayment + $venmoPayment;

        } else if ($cardPayment > 0 && $paypalPayement == 0) {
            $payment = round(($cardPayment * 100)/103,2) + $checkPayment + $venmoPayment;

        } else if ($cardPayment == 0 && $paypalPayement > 0) {
            $payment = $checkPayment + round((($paypalPayement * 100)/103),2) + $venmoPayment;

        } else {
            $payment = round(($cardPayment + $checkPayment + $paypalPayement + $venmoPayment),2);
        }

        $balnceToBePaid = 0;
        $processingFee = 0;
        $orderTotal = $orders->sum('order_total');
        $totalPayment = round($cardPayment, 2) + round($paypalPayement, 2);

        if ($payment == 0) {
            $paymentStatus = 0; // Pending

        } else if ($payment < round($order->order_total, 2) && $payment > 0) {
            $paymentStatus = 1; // Partial
            $balnceToBePaid = $order->order_total - $payment;

        } else {
            $paymentStatus = 2; // Paid
            if($totalPayment > 0 && $totalPayment > $orderTotal){
                $processingFee = $totalPayment - $orderTotal;
            }
        }

        return view('pages.order_management.orders.quote', ['orders'=>$orders , 'processingFee'=>$processingFee]);
    }

    public function edit($id){
        $organizations = Organization::select('id', 'organization_name','pl_status')->where('active', 1)->orderBy('organization_name')->get();

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
        $orders->write_off_order = $request->write_off_order;
        $orders->actual_delivery_date = $request->actual_delivery_date;

        $orders->flag = $this->changeFlagByOrder($request->order_status_id, $request->ex_factory_date);

        $orders->user_id = $request->user_id;

        $orders->order_procesing_user_id = $request->order_procesing_user_id;
        $orders->collect_payment_via_ec = $request->has('collect_payment_via_ec') ? 1 : 0;

        if(isset($request->add_plorder)){

            if( $orders->plorder != $request->add_plorder){
                if($request->add_plorder == 1){
                    $orders->order_no = "WL" . str_pad(($orders->id), 6, "0", STR_PAD_LEFT);
                }elseif($request->add_plorder == 0){
                    $orders->order_no = str_pad(($orders->id), 6, "0", STR_PAD_LEFT);
                }
            }
            $orders->plorder = $request->add_plorder;
        }

        $orders->due_date = $request->due_date;

        $orders->is_urgent = $request->is_urgent;

        if(empty($request->ex_factory_date)){
            $originalDueDate = Carbon::parse($request->due_date);
            $ex_factory_date = $originalDueDate->subDays(7)->format('m/d/Y');
            $orders->ex_factory_date = $ex_factory_date;
            $ex_factory_date_cal = $ex_factory_date;
        }else{
            $orders->ex_factory_date = $request->ex_factory_date;
            $ex_factory_date_cal = $request->ex_factory_date;
        }
        $ex_factory_date_cal = new DateTime($ex_factory_date_cal);
        $originalDueDate1 = Carbon::parse($request->due_date);
        $est_delivery_date = $ex_factory_date_cal->modify('+5 days')->format('m/d/Y');
        $orders->est_delivery_date = $est_delivery_date;

        if($orders->organization_id != 1377){
            $orderSubTotal = $orders->sub_total;
            $orderSalesTax = round($orders->sales_tax , 2);
            if($request->shipping == null){
                $orderShipping = 0;
                $orders->shipping = 0;
            } else {
                $orderShipping = (double) str_replace(",", "", $request->input('shipping'));
                $orders->shipping = (double) str_replace(",", "", $request->input('shipping'));
            }
            if($request->sales_tax == null){
                $ordersales_tax = 0;
                $orders->sales_tax = 0;
            } else {
                $ordersales_tax = (double) str_replace(",", "", $request->input('sales_tax'));
                $orders->sales_tax = (double) str_replace(",", "", $request->input('sales_tax'));
            }
            if($request->artwork == null){
                $orderArtwork = 0;
                $orders->artwork = 0;
            } else {
                $orderArtwork = (double) str_replace(',', '', $request->artwork);
                $orders->artwork = (double) str_replace(',', '', $request->artwork);
            }
            if($request->processing_fee == null){
                $orderProcessingFee = 0;
                $orders->processing_fee = 0;
            } else {
                $orderProcessingFee = (double) str_replace(',', '', $request->processing_fee);
                $orders->processing_fee = (double) str_replace(',', '', $request->processing_fee);
            }
            // round($cardPayment, 2)
            if (isset($request->add_discount)){
                $orders->discount_hidation = $request->add_discount;
            } else {
                $orders->discount_hidation = 0;
            }

            if($request->discountType != null && $orders->discount_hidation == 1){
                if($request->discountType == 'percentage' || $request->discountType == 1){
                    $order_discountType = 1;
                }elseif($request->discountType == 'value' || $request->discountType == 2){
                    $order_discountType = 2;
                }
                $orders->discount = $request->discount;
                $orders->discountType = $order_discountType;
                $orders->order_total = (double) str_replace(',', '', $request->order_total);
            }else{
                $orders->discount = 0;
                $orders->order_total = (double) str_replace(',', '', $request->order_total);
            }

            // dd($orders);
        }

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
            // if ($request->has('wl_receiver_name')) {
            if ($request->has('receiver_name')) {
                // $orders->wl_receiver_name = $request->wl_receiver_name;
                $orders->receiver_name = $request->receiver_name;
            }
            $orders->apartment = $request->new_Apartment;
            $orders->street = $request->new_street;
            $orders->city = $request->new_city;
            $orders->state = $request->new_state;
            $orders->postal_code = $request->new_postal_code;
            $orders->country = $request->new_country;
            $orders->phone_no = $request->new_phone_no;
            $orders->email = $request->new_email;
        } else {
            $orders->is_new_shipping_address = $request->customer_address_type;
            if(isset($contact->shipping_street)){
                $orders->street = $contact->shipping_street;
            }
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
            if(isset($request->order_status_id)){
                if($request->order_status_id == 8){
                    $item->order_status_id = 3;
                }else{
                    $item->order_status_id = $request->order_status_id;
                }
            }
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

                $orderItem->display_name = $itemsDetails['item_name'];

                $sub_product = SubProduct::where('id', $itemsDetails['product_id'])->first();

                // dd($sub_product->fabric_id);

                $orderItem->product_id = $sub_product->parent_product_id;
                $orderItem->sub_product_no = $sub_product->sub_product_no;
                if(empty($sub_product->fabric_id)){
                    $orderItem->fabric_id = $itemsDetails['fabric_id'];
                }else{
                    $orderItem->fabric_id = $sub_product->fabric_id;
                }
                if(empty($sub_product->default_price)){
                    $orderItem->unit_price = 0;
                }else{
                    $orderItem->unit_price = $sub_product->default_price;
                }
                // $orderItem->unit_price = $itemsDetails['unit_price'];

                $orderItem->organization_id = $itemsDetails['organization_id'];
                $orderItem->factory_id = $itemsDetails['factory_id'];
                $orderItem->support_agent_id = $itemsDetails['support_agent_id'];
                $orderItem->designer_id = $itemsDetails['designer_id'] ?? null;
                $orderItem->shipping_method = $itemsDetails['shipping_method'];
                $orderItem->ex_factory_id = $itemsDetails['ex_factory_id'];
                $orderItem->in_hand_due_date = $itemsDetails['in_hand_due_date'];
                $orderItem->open_date = Carbon::now()->format('m/d/Y');

                $ex_factory_date = Carbon::parse($orders['due_date'])->subDays(7)->format('m/d/Y');
                $orderItem->est_delivery_date = $ex_factory_date;
                $orderItem->ex_factory_date = $itemsDetails['ex_factory_date'];
                $orderItem->encore_packing_date = $itemsDetails['encore_packing_date'];

                $orderItem->clouser_type = $itemsDetails['clouser_type'];
                $orderItem->order_status_id = $itemsDetails['status_id'];
                $orderItem->secondary_fabric_id = $itemsDetails['secondary_fabric_id'];
                $orderItem->embellishment_type_id = $itemsDetails['embellishment_id'];
                $orderItem->sport = $itemsDetails['sport'];
                $orderItem->gender = $itemsDetails['gender'];
                $orderItem->qty = $itemsDetails['qty'];
                if(isset($itemsDetails['unit_price'])) {
                    $orderItem->unit_price = $itemsDetails['unit_price'];
                    $orderItem->total = $itemsDetails['qty'] * $itemsDetails['unit_price'];
                }

                // $orderItem->double_sided = isset($itemsDetails['double_sided']) ? 1 : 0;
                // $orderItem->individual_no = isset($itemsDetails['individual_no']) ? 1 : 0;
                // $orderItem->individual_name = isset($itemsDetails['individual_name']) ? 1 : 0;
                // $orderItem->pockets = isset($itemsDetails['pockets']) ? 1 : 0;
                // $orderItem->zipper_pockets = isset($itemsDetails['zipper_pockets']) ? 1 : 0;
                // $orderItem->dynamic_details = isset($itemsDetails['dynamic_details']) ? 1 : 0;
                // $orderItem->contrast_stratching = isset($itemsDetails['contrast_stratching']) ? 1 : 0;
                // $orderItem->printing_over_sems = isset($itemsDetails['printing_over_sems']) ? 1 : 0;

                $orderItem->save();
                if(isset($itemsDetails['itemAttribute_ids'])){
                    $attribute_ids = explode(',', $itemsDetails['itemAttribute_ids']);
                    foreach($attribute_ids as $attribute_id){
                        $orderItemAttribute = new OrderItemAttribute();
                        $orderItemAttribute->order_item_id = $orderItem->id;
                        $orderItemAttribute->attribute_id = $attribute_id;
                        $orderItemAttribute->save();
                    }
                }

                if(isset($itemsDetails['itemAttribute_ids'])){
                    $attribute_ids = explode(',', $itemsDetails['itemAttribute_ids']);
                    $orderItem1 = OrderItem::find($orderItem->id);
                    foreach($attribute_ids as $attribute_id){
                        if($attribute_id == 1){
                            $orderItem1->individual_no = 1;
                        }
                        if($attribute_id == 2){
                            $orderItem1->individual_name = 1;
                        }
                        if($attribute_id == 3){
                            $orderItem1->double_sided = 1;
                        }
                        if($attribute_id == 4){
                            $orderItem1->pockets = 1;
                        }
                        if($attribute_id == 5){
                            $orderItem1->zipper_pockets = 1;
                        }
                        if($attribute_id == 6){
                            $orderItem1->dynamic_details = 1;
                        }
                        if($attribute_id == 7){
                            $orderItem1->contrast_stratching = 1;
                        }
                        if($attribute_id == 8){
                            $orderItem1->printing_over_sems = 1;
                        }
                    }
                    $orderItem1->save();
                }



                $newOrderItems[]=$orderItem;

                $productSizes = [1, 2, 3, 4, 5, 6, 7, 8, 9,26,17,18,19,11,12,13,14,15,20,21,22,23,24,25,16,28,29];

                $productSizes = ProductSize::select('size_id')->where('product_id', $sub_product->parent_product_id)->get()
                ->sortBy(function ($size) use ($productSizes) {
                    return array_search($size->size_id, $productSizes);
                });
                foreach($productSizes as $sizes){
                    $orderItemsDetails = new OrderItemsDetail();
                    $orderItemsDetails->order_item_id = $orderItem->id;
                    $orderItemsDetails->size_id = $sizes['size_id'];
                    $orderItemsDetails->save();

                    $orderItemsDetailsPlayerName = new OrderItemsDetailPlayerName();
                    $orderItemsDetailsPlayerName->order_items_detail_id = $orderItemsDetails->id;
                    $orderItemsDetailsPlayerName->save();

                }



            }
        }

        if(($orders->order_status_id == 3) && (count($newOrderItems) > 0)){
            $this->emailFactoryUsersToInformAddNewItems($orders->id, $newOrderItems);
        }

        if($orders->order_status_id == 1 && $request->order_status_id == 3){
            $orders->production_date = Carbon::now()->format('m/d/Y');
            $orders->factory_confirmation_date = 'Waiting for factory Confirmation';
            $this->emailFactoryUsers($orders->id, $request->is_urgent);
            $this->notifyFactoryUsers($orders->id, $request->is_urgent);
            $this->generateOrderProjectSections($orders->id);
        }
        if($orders->order_status_id == 3 && $request->order_status_id == 1){
            $this->emailFactoryUsersOnQuotes($orders->id);
            $this->notifyFactoryUsersOnQuotes($orders->id);
        }

        if(isset($request->order_status_id)){

            $orders->order_status_id = $request->order_status_id;
        }


        $orders->update();

        if(str_starts_with($orders->order_no, 'TSR')){
            $storeOrders = StoreOrder::where('system_order_no', $orders->order_no)->where('active', 1)->get() ?? [];
            if($storeOrders->count() > 0){
                foreach($storeOrders as $storeOrder){
                    if($orders->order_status_id == 1){
                        $storeOrder->order_status = 2;
                        $storeOrder->update();
                    }
                    if($orders->order_status_id == 3){
                        $storeOrder->order_status = 3;
                        $storeOrder->update();
                    }
                    if($orders->order_status_id == 4){
                        $storeOrder->order_status = 5;
                        $storeOrder->update();
                    }
                    // update store order item details status
                    $storeOrderItems = StoreOrderItem::where('store_order_id', $storeOrder->id)->get() ?? [];
                    foreach($storeOrderItems as $storeOrderItem){
                        $itemDetails = StoreOrderPlayerDetail::where('store_order_item_id', $storeOrderItem->id)->get() ?? [];
                        foreach($itemDetails as $itemDetail){
                            if($orders->order_status_id == 1){
                                $itemDetail->item_status = 2;
                                $itemDetail->update();
                            }
                            if($orders->order_status_id == 3){
                                $itemDetail->item_status = 3;
                                $itemDetail->update();
                            }
                            if($orders->order_status_id == 4){
                                $itemDetail->item_status = 5;
                                $itemDetail->update();
                            }
                        }
                    }
                }
            }
        }

        // salse tax calculation

        $order_update = Order::find($request->id);

        // $subtotal = $order_update->sub_total;
        // $orderSalesTax = $order_update->sales_tax ?? 0.00;

        // $organization = Organization::find($order_update->organization_id);
        // if ($organization->sales_tax_active == 1) {
        //     $salesTax = $organization->sales_tax;
        // } else {
        //     $salesTax = 0;
        // }

        // $orderShipping = $order_update->shipping ?? 0.00;
        // $orderArtwork = $order_update->artwork ?? 0.00;

        // $order_total_amount = $subtotal + $orderArtwork;

        // if($order_update->discount_hidation == 1 ){

        //     if($order_update->discountType == 1){

        //         $discountAmount = ($order_total_amount / 100) * $order_update->discount;

        //     } elseif($order_update->discountType == 2) {

        //         $discountAmount = $order_update->discount;
        //     }

        // }else{
        //     $discountAmount = 0.00;
        // }

        // $orderSalesTax = (($order_total_amount - $discountAmount) / 100) * $salesTax;

        // $order_update->sub_total = $subtotal;
        // $order_update->order_total = $order_total_amount + $orderSalesTax - $discountAmount + $orderShipping;
        // $order_update->sales_tax = $orderSalesTax;
        // $order_update->save();

        if(isset($request->order_status_id)){

            if($request->order_status_id == 3){
                if(!AccountsLog::where('order_id', $request->id)->where('type', 0)->where('status', 1)->where('note', 'Outstanding Invoice')->exists()){

                    $payment_of_order = $this->PaymentService->getPaymentStatus($request->id);

                    $CreditAccountOutstanding = new AccountsLog();
                    $CreditAccountOutstanding->organization_id = $order_update->organization_id;
                    $CreditAccountOutstanding->amount = $payment_of_order['order_total'];
                    $CreditAccountOutstanding->order_id = $order_update->id;
                    $CreditAccountOutstanding->paid = 0;
                    $CreditAccountOutstanding->balance = 0;
                    $CreditAccountOutstanding->debit_balance =$payment_of_order['order_total'];
                    $CreditAccountOutstanding->type = 0;
                    $CreditAccountOutstanding->user_id = Auth::user()->id;
                    $CreditAccountOutstanding->status = 1;
                    $CreditAccountOutstanding->note = 'Outstanding Invoice';
                    $CreditAccountOutstanding->save();

                    // if (strpos($order_update->order_no, 'TSR') === 0) {

                    //     $CreditAccount = new AccountsLog();
                    //     $CreditAccount->organization_id = $order_update->organization_id;
                    //     $CreditAccount->amount = 0;
                    //     $CreditAccount->order_id = $order_update->id;
                    //     $CreditAccount->paid = $payment_of_order['order_total'];
                    //     $CreditAccount->balance = 0;
                    //     $CreditAccount->debit_balance = 0;
                    //     $CreditAccount->type = 0;
                    //     $CreditAccount->user_id = Auth::user()->id;
                    //     $CreditAccount->status = 1;
                    //     $CreditAccount->note = 'Paid through OMG';
                    //     $CreditAccount->created_at = $CreditAccountOutstanding->created_at->copy()->addMinutes(1);
                    //     $CreditAccount->save();

                    // }

                }

            }
        }

        AccountsLog::where('order_id', $order_update->id)->where('type', 0)->where('status', 1)->where('note', 'Outstanding Invoice')->update(
            [
                'amount' => $order_update->order_total,
                'debit_balance' => $order_update->order_total,
            ]
        );

        return redirect()->to('order_details/edit/'.$request->id.'/order?active_tab=order')->withSuccess('Order Updated Successfully!');
    }
    public function generateOrderProjectSections($id)
    {
        $defaultProjectId = 19;

        $projectSections = PmSection::where('project_id', $defaultProjectId)
            ->where('order_id', $id)
            ->get();

        $order = Order::with('organizationDetails', 'userDetails')->find($id);

        if (!$order) {
            return false;
        }

        $sectionCount = PmSection::where('project_id', $defaultProjectId)->count();

        $dueDate = null;

        try {
            if (!empty($order->ex_factory_date)) {
                $dueDate = Carbon::createFromFormat('m/d/Y', $order->ex_factory_date)
                    ->format('Y-m-d');
            }
        } catch (\Exception $e) {
            $dueDate = null;
        }

        if ($projectSections->isEmpty()) {

            $newDiscussion = new PmSection();
            $newDiscussion->project_id = $defaultProjectId;
            $newDiscussion->section_name = '#' . $order->order_no . ' - ' . ($order->organizationDetails->organization_name ?? '');
            $newDiscussion->sort_index = $sectionCount + 1;
            $newDiscussion->order_id = $id;
            $newDiscussion->user_id = $order->userDetails->id ?? null;
            $newDiscussion->save();

            $discussionList = [
                'Shipping Details' => [
                    'assignee_id' => 75,
                    'sub_task' => 'For Packing Team'
                ],
                'Discussion' => [
                    'assignee_id' => 98,
                    'sub_task' => 'Additional Notes'
                ],
                'Production Layouts' => [
                    'assignee_id' => 98,
                    'sub_task' => 'Customer Approval'
                ],
                'Estimated Shipping Date' => [
                    'assignee_id' => 98,
                    'sub_task' => 'Factory Confirmation'
                ]
            ];

            $sortIndex = 1;

            foreach ($discussionList as $key => $discussion) {

                $newSubDiscussion = new PmSectionDiscussion();
                $newSubDiscussion->section_id = $newDiscussion->id;
                $newSubDiscussion->project_id = $defaultProjectId;
                $newSubDiscussion->assignee_id = null;
                $newSubDiscussion->assigned_by = $order->userDetails->id ?? null;
                $newSubDiscussion->discussion_name = $key;
                $newSubDiscussion->due_date = $dueDate;
                $newSubDiscussion->user_id = $order->userDetails->id ?? null;
                $newSubDiscussion->sort_index = $sortIndex;
                $newSubDiscussion->save();

                $PmSectionSubDiscussion = new PmSectionSubDiscussion();
                $PmSectionSubDiscussion->section_id = $newDiscussion->id;
                $PmSectionSubDiscussion->project_id = $defaultProjectId;
                $PmSectionSubDiscussion->assignee_id = $discussion['assignee_id'];
                $PmSectionSubDiscussion->assigned_by = $order->userDetails->id ?? null;
                $PmSectionSubDiscussion->discussion_id = $newSubDiscussion->id;
                $PmSectionSubDiscussion->discussion_name = $discussion['sub_task'];
                $PmSectionSubDiscussion->due_date = $dueDate;
                $PmSectionSubDiscussion->user_id = $order->userDetails->id ?? null;
                $PmSectionSubDiscussion->sort_index = 1;
                $PmSectionSubDiscussion->save();

                $sortIndex++;
            }
        }

        return true;
    }

    public function sortByAlphabet($id){
        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $sortedOrderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')
                            ->whereHas('organizationDetails', function($query) use($id) {
                                $query->where('organization_name', 'LIKE', $id.'%');
                                $query->whereNotIn('id', $this->inventoryOrgIds);
                            });

            if($oderSearch == 'factory'){
                $sortedOrderQuery->with(['orderItems'=>function($qry) use($factoryIds){
                                    $qry->with('factoryDetails')
                                        ->whereIn('factory_id', $factoryIds)
                                        ->whereIn('order_status_id', [3, 4, 8]);
                                }]);
                $sortedOrderQuery->whereHas('orderItems', function($qr) use($factoryIds){
                                    $qr->whereIn('factory_id', $factoryIds)
                                       ->whereIn('order_status_id', [3, 4, 8]);
                                });
            } else {
                $sortedOrderQuery->with('orderItems.factoryDetails');
            }
        $sortedOrder = $sortedOrderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->get();

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
                                    ->whereIn('order_status_id', [3, 4, 8]);
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

    public function downloadExcel($id)
    {
        $orderItem = OrderItem::find($id);

            return (new OrderItemExport($id))->download('Order_Item_'.$orderItem->item_no.'.xlsx');

    }

    public function csv($id){
        $order = Order::with('organizationDetails')->where('id', $id)->first();

        if ($order->order_type == 0) {
            $filename = str_replace(['/', '\\'], ' ', $order->organizationDetails->organization_name) . ' - ' . $order->order_no . '.xlsx';
            return (new BulkOrderExport($id))->download($filename);
        } else {
            $filename = str_replace(['/', '\\'], ' ', $order->organizationDetails->organization_name) . ' - ' . $order->order_no . '.xlsx';
            return (new TSOrderExport($id))->download($filename);
        }
    }

    // public function filterTable($factoryId, $statusId, $paginateNo){
    public function filterTable(Request $request)
{
    $factoryId  = $request->factory_id;
    $statusId   = $request->status_id;
    $orgTxt     = trim($request->org_txt);
    $sales_rep  = $request->sales_rep;
    $paginateNo = $request->paginate_no ?? 1;

    $this->userGroupFactories();

    $oderSearch = $this->oderSearch;
    $factoryIds = $this->factoryIds;

    $baseQuery = Order::with([
            'organizationDetails',
            'userDetails',
            'contactDetails',
            'statusDetails',
            'teamStoreDetails'
        ])
        ->whereNotIn('organization_id', $this->inventoryOrgIds)
        ->where('active', 1)
        ->where('plorder', 0);

    // Factory Filter
    if ($factoryId != 0) {
        $baseQuery->whereHas('orderItems', function ($q) use ($factoryId) {
            $q->where('factory_id', $factoryId);
        });
    }

    // Status Filter
    if ($statusId != 0) {
        $baseQuery->where('order_status_id', $statusId);
    }

    // Search Filter
    if (!empty($orgTxt)) {

        $baseQuery->where(function ($q) use ($orgTxt) {

            $q->whereHas('organizationDetails', function ($query) use ($orgTxt) {
                $query->where('organization_name', 'LIKE', '%' . $orgTxt . '%');
            })
            ->orWhere('order_no', 'LIKE', '%' . $orgTxt . '%');

        });
    }

    // Sales Rep Filter
    if ($sales_rep && $sales_rep != 'all') {
        $baseQuery->where('user_id', $sales_rep);
    }

    // Date Filter
    if ($request->filled('type') && $request->filled('date')) {

        if ($request->type == 0) {
            $baseQuery->whereDate('ex_factory_date', $request->date);
        } elseif ($request->type == 1) {
            $baseQuery->whereDate('due_date', $request->date);
        }
    }

    // Factory User Restriction
    if ($oderSearch == 'factory') {

        $baseQuery->with([
            'orderItems' => function ($qry) use ($factoryIds) {
                $qry->with('factoryDetails')
                    ->whereIn('factory_id', $factoryIds)
                    ->whereIn('order_status_id', [3, 4, 8]);
            }
        ]);

        $baseQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
            $qr->whereIn('factory_id', $factoryIds)
               ->whereIn('order_status_id', [3, 4, 8]);
        });

    } else {

        $baseQuery->with('orderItems.factoryDetails');
    }

    // Status Counts
    $statusCounts = (clone $baseQuery)
        ->selectRaw("
            SUM(CASE WHEN order_status_id = 3 THEN 1 ELSE 0 END) as production,
            SUM(CASE WHEN order_status_id = 1 THEN 1 ELSE 0 END) as quote,
            SUM(CASE WHEN order_status_id = 4 THEN 1 ELSE 0 END) as fulfilled,
            SUM(CASE WHEN order_status_id = 7 THEN 1 ELSE 0 END) as cancelled
        ")
        ->first();

    // Pagination
    $sortedOrder = (clone $baseQuery)
        ->orderBy('id', 'DESC')
        ->paginate(50, ['*'], 'page', $paginateNo);

    // Payment Status
    $paymentService = app(\App\Services\PaymentService::class);

    $sortedOrder->getCollection()->transform(function ($order) use ($paymentService) {
        $order->payment_status = $paymentService->getPaymentStatus($order->id);
        return $order;
    });

    // SAME RESPONSE FORMAT AS YOUR OLD CODE
    return response()->json([
        $sortedOrder->items(),
        $oderSearch,
        $factoryIds,
        $statusCounts,
        [
            'current_page' => $sortedOrder->currentPage(),
            'last_page'    => $sortedOrder->lastPage(),
            'total'        => $sortedOrder->total(),
        ]
    ]);
}

    public function pl_filterTable(Request $request)
    {
        $factoryId = $request->factory_id;
        $statusId = $request->status_id;
        $orgTxt = $request->org_txt;
        $paginateNo = $request->paginate_no;
        $sales_rep = $request->sales_rep;

        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        // Initialize base query
        $sortedOrderQuery = Order::with([
            'organizationDetails',
            'userDetails',
            'contactDetails',
            'statusDetails',
            'teamStoreDetails'
        ]);

        // Apply Filters
        if ($factoryId != 0) {
            $sortedOrderQuery->whereHas('orderItems.factoryDetails', function ($query) use ($factoryId) {
                $query->where('id', $factoryId);
            });
        }

        if ($statusId != 0) {
            $sortedOrderQuery->where('order_status_id', $statusId);
        }

        // Search by Organization Name or Order No
        if (!empty($orgTxt)) {
            $sortedOrderQuery->where(function ($query) use ($orgTxt) {
                $query->whereHas('organizationDetails', function ($subQuery) use ($orgTxt) {
                    $subQuery->where('organization_name', 'LIKE', "%$orgTxt%")
                             ->whereNotIn('id', $this->inventoryOrgIds);
                })
                ->orWhere('order_no', 'LIKE', "%$orgTxt%");
            });
        }

        // Factory-specific filtering
        if ($oderSearch == 'factory') {
            $sortedOrderQuery->with(['orderItems' => function ($qry) use ($factoryIds) {
                $qry->with('factoryDetails')
                    ->whereIn('factory_id', $factoryIds)
                    ->whereIn('order_status_id', [3, 4, 8]);
            }]);

            $sortedOrderQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
                $qr->whereIn('factory_id', $factoryIds)
                   ->whereIn('order_status_id', [3, 4, 8]);
            });
        } else {
            $sortedOrderQuery->with('orderItems.factoryDetails');
        }
        if($sales_rep != 'all' && $sales_rep){

                $sortedOrderQuery->where('user_id', $sales_rep);
            }
        // Date filter directly on orders table
        if (isset($request->type) && $request->date) {
            $searchDate = $request->date; // Directly use it
            if ($request->type == 0) {
                $sortedOrderQuery->where('ex_factory_date', $searchDate);
            } elseif ($request->type == 1) {
                $sortedOrderQuery->where('due_date', $searchDate);
                // dd($searchDate);
            }
        }

        $statusCounts = (clone $sortedOrderQuery)
            ->whereNotIn('organization_id', $this->inventoryOrgIds)
            ->where('active', 1)
            ->where('plorder', 1)
            ->selectRaw("
                SUM(CASE WHEN order_status_id = 3 THEN 1 ELSE 0 END) as production,
                SUM(CASE WHEN order_status_id = 1 THEN 1 ELSE 0 END) as quote,
                SUM(CASE WHEN order_status_id = 4 THEN 1 ELSE 0 END) as fulfilled,
                SUM(CASE WHEN order_status_id = 7 THEN 1 ELSE 0 END) as cancelled
            ")
            ->first();

        // Apply final filters before execution
        $sortedOrder = $sortedOrderQuery
            ->whereNotIn('organization_id', $this->inventoryOrgIds)
            ->where('active', 1)
            ->where('plorder', 1) // ✅ Ensuring only `plorder = 1`
            ->orderBy('id', 'DESC')
            ->offset(($paginateNo - 1) * 50) // ✅ Proper pagination
            ->limit(50)
            ->get();

        // Process each order and add payment status
        $sortedOrder = $sortedOrder->map(function ($order) {
            $order->payment_status = app(\App\Services\PaymentService::class)->getPaymentStatus($order->id);
            return $order;
        });

        return response()->json([$sortedOrder, $oderSearch, $factoryIds, $statusCounts]);
    }


    public function exportCsv(){
        $fileName = 'orders.csv';
        $orders = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails')->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->get();

        $headers = array(
            "Content-type"=>"text/csv",
            "Content-Disposition"=>"attachment; filename=$fileName",
            "Pragma"=>"no-cache",
            "Cache-Control"=>"must-revalidate, post-check=0, pre-check=0",
            "Expires"=>"0"
        );

        $columns = array('Order No', 'Organization', 'Order Status', 'Support Agent', 'Contact Person', 'Order Description', 'Sub Total', 'Tax Rate',
                         'Tax Amount', 'Shipping', 'Artwork', 'Processing Fee', 'Order Total', 'Shipping Address',
                         'Billing Address');

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
                $row['Sub Total'] = $order->sub_total;
                $row['Tax Rate'] = $order->organizationDetails['sales_tax'] . '%';
                $row['Tax Amount'] = $order->sales_tax;
                $row['Shipping'] = $order->shipping;
                $row['Artwork'] = $order->artwork;
                $row['Processing Fee'] = $order->processing_fee;
                $row['Order Total'] = $order->order_total;
                $row['Shipping Address'] = $shippingAddress;
                $row['Billing Address'] = $billingAddress;

                fputcsv($file, array(
                    $row['Order No'], $row['Organization'], $row['Order Status'], $row['Support Agent'], $row['Contact Person'], $row['Order Description'],
                    $row['Sub Total'], $row['Tax Rate'], $row['Tax Amount'], $row['Shipping'], $row['Artwork'],
                    $row['Processing Fee'], $row['Order Total'], $row['Shipping Address'], $row['Billing Address']
                ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function product($productId){
        $product = SubProduct::select('products.product_no', 'products.product_name', 'products.default_price', 'products.pattern_code')
                          ->where('id', $productId)->get();

        $product_fabric = ProductFabric::where('product_id', $productId)
                          ->with('fabrics')->get();

        $product_embellishment_type = ProductEmbellishmentType::where('product_id', $productId)
                                      ->with('embellishmentTypes')->get();

        $product_attribute = ProductAttribute::where('product_id', $productId)
                            ->with('attributes')->get();

        echo json_encode([$product,$product_fabric,$product_embellishment_type,$product_attribute]);
    }

    public function sub_product_creating(){
        $order_items = OrderItem::get();
        $fabrics = Fabric::get();
        $num = 1;

        foreach ($order_items as $order_item) {
            if(!empty($order_item->fabric_id)){
                $sub_product = SubProduct::where('fabric_id' , $order_item->fabric_id)->where('parent_product_id' , $order_item->product_id)->first();
                $product = Product::where('id' , $order_item->product_id)->first();
                $fabric = $fabrics->where('id' , $order_item->fabric_id)->first();
                $fabric_name = $fabric->fabric_name;
                $fabric_id = $fabric->id;

                if($sub_product){
                    $sub_product->product_name = $product->product_name." - ".$fabric_name;
                    $sub_product->save();
                    echo($sub_product->sub_product_no." updated !<br>");

                    $order_item->sub_product_no = $sub_product->sub_product_no;
                    $order_item->save();
                }else{

                    $pro_no = SubProduct::where('parent_product_id' , $product->id)->count() + 1;

                    $new_sub_product = new SubProduct();
                    $new_sub_product->product_name = $product->product_name." - ".$fabric_name;
                    $new_sub_product->parent_product_id = $product->id;
                    $new_sub_product->sub_product_no = "PRO-".$product->id.".".$pro_no;
                    $new_sub_product->standard_fabric = $fabric_name;
                    $new_sub_product->fabric_id = $fabric_id;
                    $new_sub_product->active = 0;
                    $new_sub_product->save();
                    echo($new_sub_product->sub_product_no." created !<br>");

                    $order_item->sub_product_no = $new_sub_product->sub_product_no;
                    $order_item->save();
                }
            }else{

                $product = Product::where('id' , $order_item->product_id)->first();
                $sub_product = SubProduct::where('parent_product_id' , $order_item->product_id)->first();

                if($sub_product){

                $order_item->sub_product_no = $sub_product->sub_product_no;
                $order_item->save();

                }else{

                $new_sub_product = new SubProduct();
                $new_sub_product->product_name = $product->product_name;
                $new_sub_product->parent_product_id = $product->id;
                $new_sub_product->sub_product_no = "PRO-".$product->id.".1";
                $new_sub_product->active = 0;
                $new_sub_product->save();
                echo($new_sub_product->sub_product_no." created !<br>");

                $order_item->sub_product_no = $new_sub_product->sub_product_no;
                $order_item->save();
                }

                echo($num." New product created for #".$order_item->item_no."<br>");
                $num = $num + 1;
            }
        }

    }

    // public function order_item_table_option(){
    //     $sub_products = SubProduct::where('fabric_id' , 0)->get();
    //     $products = Product::get();
    //     $fabrics = Fabric::get();
    //     foreach ($sub_products as $sub_product) {
    //         $fabric = $fabrics->where('fabric_name' , $sub_product->standard_fabric)->first();
    //         if($fabric){

    //             $sub_product->product_name = $product->product_name." - ".$fabric->fabric_name;
    //             $sub_product->standard_fabric = $fabric->fabric_name;
    //             $sub_product->fabric_id = $fabric->id;
    //             $sub_product->save();

    //             echo($sub_product->sub_product_no." updated !");

    //         }
    //     }

    // }

    public function filter_sub_products(Request $request){
        if($request->subProductId){
        $sub_product = SubProduct::where('id', $request->subProductId)->first();


        if($sub_product->parent_product_id == 228){
            $is_hat = true;
        }else{
            $is_hat = false;
        }
        $product_fabric = $sub_product->standard_fabric;

        $sub_product_embellishment_type = $sub_product->embellishmentTypes()->with('embellishmentDetails')->get();
        $all_embellishment_details = $sub_product_embellishment_type->pluck('embellishmentDetails')->filter()->flatten();

        $product_embellishment_type = $all_embellishment_details->toArray();

        $trimmed_attributes = ProductAttribute::where('product_id' , $sub_product->parent_product_id)->pluck('attribute_id');
        $product_attributes = Attribute::whereIn('id', $trimmed_attributes)->get();

        $trimmed_factories = ProductFactory::where('product_id' , $sub_product->parent_product_id)->pluck('product_factory_id');
        $product_factories = Factory::whereIn('id', $trimmed_factories)->get();

        return response()->json(['message' => 'This is test one', 'sub_product'=>$sub_product , 'product_fabric'=>$product_fabric, 'is_hat'=>$is_hat,
        'product_embellishment_type' => $product_embellishment_type , 'product_attributes' => $product_attributes , 'product_factories'=>$product_factories]);
        }
    }

    public function saved_order_item_update(Request $request){

        $orderItem = OrderItem::where('item_no' , $request->saved_item_itemNo)->first();

        if (!empty($request->status_id)) {
            $orderItem->order_status_id = $request->status_id;
        }

        if (!empty($request->factory_id)) {
            $orderItem->factory_id = $request->factory_id;
        }
        if ($request->has('item_embellishment') && !empty($request->item_embellishment)) {
            $orderItem->embellishment_type_id = $request->item_embellishment;
        }
        if (!empty($request->item_shipping_method)) {
            $orderItem->shipping_method = $request->item_shipping_method;
        }

        if (!empty($request->item_secondary_fabric)) {
            $orderItem->secondary_fabric_id = $request->item_secondary_fabric;
        }

        if (!empty($request->item_fabric)) {
            $orderItem->fabric_id = $request->item_fabric;
        }

        $orderItem->ex_factory_id = $request->item_ex_factory_id;

        if (!empty($request->item_ex_factory_date)) {
            $orderItem->ex_factory_date = $request->item_ex_factory_date;
        }
        if (!empty($request->product_price)) {
            $orderItem->unit_price = $request->product_price;
            $orderItem->total = $request->product_price * $orderItem->qty;
        }

        if (!empty($request->item_encore_packing_date)) {
            $orderItem->encore_packing_date = $request->item_encore_packing_date;
        }

        if (!empty($request->item_in_hand_date)) {
            $orderItem->in_hand_due_date = $request->item_in_hand_date;
        }

        if (!empty($request->clouser_type)) {
            $orderItem->clouser_type = $request->clouser_type;
        }

        $orderItem->save();

        // $saved_attributes = $request->item_attribute;

        // if(count($saved_attributes) > 0){
        //     foreach($saved_attributes as $saved_attributes){

        //     }
        // }
        $order = Order::find($orderItem->order_id);
        $organization = Organization::find($order->organization_id);
        $orderSubTotal = OrderItem::where('order_id', $orderItem->order_id)->sum('total');
        if ($organization->sales_tax_active == 1) {
            $salesTax = $organization->sales_tax;
        } else {
            $salesTax = 0;
        }
        $orderSalesTax = ($orderSubTotal / 100) * $salesTax;
        $orderShipping = $order->shipping ?? 0;
        $orderArtwork = $order->artwork ?? 0;
        $orderFeesTotal = $orderSalesTax + $orderShipping + $orderArtwork;


        if($order->discountType == null){
            $orderDiscount = 0;
        } else {
            if($order->discountType == 1){
                $totalWithoutdisc = $orderSubTotal + $orderFeesTotal;
                $discountPercentage = $order->discount;
                $orderDiscount = ($totalWithoutdisc / 100) * $discountPercentage;
            } else {
                $orderDiscount = $order->discount;
            }

        }
        $order->sub_total = $orderSubTotal;
        $order->order_total = round($orderSubTotal + $orderFeesTotal - $orderDiscount , 2);

        $order->sales_tax = round($orderSalesTax , 2);
        $order->update();




        return response()->json(['data'=>'success', 'status'=>201]);
    }
    public function delete_saved_item(Request $request){

        OrderItem::where('item_no' , $request->order_item_no)->delete();
        return response()->json(['data'=>'success', 'status'=>201]);
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
        if(OrderLayout::where('user_id', Auth::user()->id)->first()){
            $organizationLayout = OrderLayout::find($request->layout_id);
            $organizationLayout->order_flag = $request->order_flag;
            $organizationLayout->order_no = $request->order_no;
            $organizationLayout->order_organization = $request->order_organization;
            $organizationLayout->order_factories = $request->order_factories;
            $organizationLayout->order_due_date = $request->order_due_date;
            $organizationLayout->order_open_date = $request->order_open_date;
            $organizationLayout->est_sippping_date = $request->order_est_sippping_date;
            $organizationLayout->order_sales_rep = $request->order_sales_rep;
            $organizationLayout->order_total = $request->order_total;
            $organizationLayout->order_status = $request->order_status;
            $organizationLayout->contact_person = $request->contact_person;
            $organizationLayout->order_description = $request->order_description;
            $organizationLayout->sub_total = $request->sub_total;
            $organizationLayout->sales_tax = $request->sales_tax;
            $organizationLayout->shipping = $request->shipping;
            $organizationLayout->artwork = $request->artwork;
            $organizationLayout->processing_fee = $request->processing_fee;
            $organizationLayout->team_store_file = $request->team_store_file;
            $organizationLayout->created = $request->created_at;
            $organizationLayout->updated = $request->updated_at;
            $organizationLayout->update();

            $successMsg = "Updated";

        } else {
            $organizationLayout = new OrderLayout();
            $organizationLayout->user_id = Auth::user()->id;
            $organizationLayout->order_flag = $request->order_flag;
            $organizationLayout->order_no = $request->order_no;
            $organizationLayout->order_organization = $request->order_organization;
            $organizationLayout->order_factories = $request->order_factories;
            $organizationLayout->order_due_date = $request->order_due_date;
            $organizationLayout->order_open_date = $request->order_open_date;
            $organizationLayout->est_sippping_date = $request->order_est_sippping_date;
            $organizationLayout->order_sales_rep = $request->order_sales_rep;
            $organizationLayout->order_total = $request->order_total;
            $organizationLayout->order_status = $request->order_status;
            $organizationLayout->contact_person = $request->contact_person;
            $organizationLayout->order_description = $request->order_description;
            $organizationLayout->sub_total = $request->sub_total;
            $organizationLayout->sales_tax = $request->sales_tax;
            $organizationLayout->shipping = $request->shipping;
            $organizationLayout->artwork = $request->artwork;
            $organizationLayout->processing_fee = $request->processing_fee;
            $organizationLayout->team_store_file = $request->team_store_file;
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
        if($user->hasRole([1, 2, 3, 4, 10,30])){
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
                if($userRole->id == 17){     // HBM Factory
                    $factoryIds[] = 17;  // HBM Bags
                }
                if($userRole->id == 27){     // BT Factory
                    $factoryIds[] = 18;  // BT
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
    public function ChangeUpcomingStatus($order_id, $status)
    {
        $order = Order::with('organizationDetails')->findOrFail($order_id);
        $order->upcoming_status = $status;
        $order->save();

        if ($status == 1) {

            //send notification
            $orderDetails = OrderItem::with(['subProduct', 'orderItemAttributes.attribute'])
                ->where('order_id', $order->id)
                ->get();

            $itemRowsHtml = '';
            foreach ($orderDetails as $index => $orderItem) {
                $itemName = optional($orderItem->subProduct)->product_name ?? $orderItem->item_no;
                $rowBg = ($index % 2 === 0) ? '#f9fafb' : '#ffffff';

                $itemRowsHtml .= '<div style="display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid #f3f4f6;font-size:13px;background:' . $rowBg . '">
                    <span style="display:flex;align-items:center;gap:9px;color:#111827">
                        <span style="width:7px;height:7px;border-radius:50%;background:#0d9488;flex-shrink:0"></span>
                        ' . e($itemName) . '
                    </span>
                    <span style="background:#eef2f7;color:#4b5563;font-size:11px;font-weight:700;padding:3px 10px;border-radius:5px;white-space:nowrap">Qty - ' . $orderItem->qty . '</span>
                </div>';
            }

            $itemIds = $orderDetails->pluck('id')->implode(',');
            $orderLink = url('order_details/edit/' . $order->id . '/order') . '?active_tab=order';

            $builder = new NotificationBuilderService();

            $builder->sendNotification(
                'key_new_upcoming_order',
                [
                    '{order_no}'          => $order->order_no,
                    '{order_link}'        => $orderLink,
                    '{organization_name}' => optional($order->organizationDetails)->organization_name ?? '',
                    '{item_rows}'         => $itemRowsHtml,
                ],
                [
                    'order_id'                   => $order->id,
                    'order_item_id'              => $itemIds,
                    'target_notification_field'  => 'key_new_upcoming_order',
                    'new_notification'           => 1,
                ]
            );
        }

        return response()->json(['success' => true]);
    }
    
    protected function createOrderDetailsMessage($orderDetails,$order_id)
    {
        $message = "<h3>New Upcoming Order# - ".$order_id."</h3>";
        // $message = "<h4>Order Details</h4>";
        $message .= "<table border='1' cellpadding='5' cellspacing='0'>";
        $message .= "<thead>
                        <tr>
                            <th>#</th>
                            <th style='width:40%'>Display Name</th>
                            <th style='width:30%'>Attributes</th>
                            <th style='width:25%'>Quantity</th>
                        </tr>
                    </thead>";
        $message .= "<tbody>";
        $total_items = 0;
        foreach ($orderDetails as $index => $orderDetail) {
            $displayName = $orderDetail->display_name ?? ($orderDetail->subProduct ? $orderDetail->subProduct->product_name : '');
            $attributes = $orderDetail->orderItemAttributes->map(function ($attribute) {
                return $attribute->attribute->attribute_name;
            })->implode(', ');

            $message .= "<tr>
                            <td>" . ($index + 1) . "</td>
                            <td>" . $displayName . "</td>
                            <td>" . $attributes . "</td>
                            <td>" . $orderDetail->qty . "</td>
                        </tr>";
            $total_items += $orderDetail->qty;
        }
        $message .= "<tr>
                        <td>*</td>
                        <td colspan = '2'>Total Qty</td>
                        <td>" . $total_items . "</td>
                    </tr>";

        $message .= "</tbody>";
        $message .= "</table>";

        return $message;
    }


   public function notifyFactoryUsers($orderId, $isUrgent)
    {
        $allOrderItems = OrderItem::where('order_id', $orderId)->get();

        $factoryArray = $allOrderItems->pluck('factory_id')->filter()->unique();

        if ($factoryArray->isEmpty()) {
            return false;
        }

        $orderDetails = Order::find($orderId);

        if (!$orderDetails) {
            return false;
        }

        foreach ($factoryArray as $factory_id) {

            $orderItems = OrderItem::where('order_id', $orderId)
                ->where('factory_id', $factory_id)
                ->get();

            if ($orderItems->isEmpty()) {
                continue;
            }

            // Build styled item rows (alternating background, qty badge) to match the design
            $itemListHtml = '';
            foreach ($orderItems as $index => $orderItem) {
                $optional_text = $orderItem->item_description ? ' - ' . $orderItem->item_description : '';
                $sub_product_name = SubProduct::where('sub_product_no', $orderItem->sub_product_no)->first()->product_name ?? '';
                $remake = $orderItem->remake_status == 1
                ? '<span style="background:#FFB916;color:#ffffff;font-size:11px;font-weight:700;padding:3px 10px;border-radius:5px;white-space:nowrap;">Remake</span>'
                : '';
                $bg = ($index % 2 === 0) ? 'background:#f9fafb;' : '';
                $borderTop = ($index === 0) ? '' : 'border-top:1px solid #f0f0f0;';

                $itemListHtml .= '<div style="display:flex;align-items:center;justify-content:space-between;gap:10px;padding:12px 16px;font-size:13px;color:#1f2937;' . $bg . $borderTop . '">'
                    . '<span style="display:flex;align-items:center;gap:9px;">'
                    . '<span style="width:7px;height:7px;border-radius:50%;background:#0d9488;flex-shrink:0;display:inline-block;"></span>'
                    . $sub_product_name . $optional_text
                    . '</span>'
                    . '<span style="display:flex;align-items:center;gap:6px;">'
                    . $remake
                    . '<span style="background:#eef2f7;color:#4b5563;font-size:11px;font-weight:700;padding:3px 10px;border-radius:5px;white-space:nowrap;">Qty - ' . $orderItem->qty . '</span>'
                    . '</span>'
                    . '</div>';
            }

            $ids = $orderItems->pluck('id')->toArray();
            $commaSeparatedIds = implode(',', $ids);

            $discussionLink = route('orders.info', ['id' => $orderDetails->id, 'type' => 'management']);
            $rosterLink     = url('orders/csv/' . $orderDetails->id);
            $techpackLink   = url('orders/DownloadTestPrint/' . $commaSeparatedIds);
            $playerReport = route('store.generatePlayerCSV', ['id' => $orderDetails->id]);

            $templateKey = $isUrgent == 1
                ? 'key_urgent_order_moved_to_production'
                : 'key_order_production';

            $this->notification_builder->sendNotification(
                $templateKey,
                [
                    '{order_number}'      => $orderDetails->order_no,
                    '{order_link}' => url("order_details/edit/{$orderId}/order") . '?active_tab=order',
                    '{ex_factory_date}'   => $orderDetails->ex_factory_date,
                    '{in_hand_due_date}'  => $orderDetails->due_date,
                    '{organization_name}' => optional($orderDetails->organizationDetails)->organization_name ?? '',
                    '{order_description}' => $orderDetails->order_description ?? '',
                    '{order_items_list}'  => $itemListHtml,
                    '{techpack_link}'     => $techpackLink,
                    '{roster_link}'       => $rosterLink,
                    '{discussion_link}'   => $discussionLink,
                    '{playerReport}'      => $playerReport,
                ],
                [
                    'order_id'                   => $orderDetails->id,
                    'order_item_id'              => $commaSeparatedIds,
                    'is_urgent'                  => $isUrgent,
                    'order_ex_fac_date'          => $orderDetails->ex_factory_date,
                    'order_in_hand_due_date'     => $orderDetails->due_date,
                    'target_notification_field' => $templateKey,
                    'new_notification'           => 1,
                ]
            );
        }

        return true;
    }

    public function emailFactoryUsers($orderId, $isUrgent)
    {
        $allOrderItems = OrderItem::where('order_id', $orderId)->get();

        $factoryArray = $allOrderItems->pluck('factory_id')->filter()->unique();

        if ($factoryArray->isEmpty()) {
            return false;
        }

        $orderDetails = Order::with('contactDetails')->find($orderId);

        if (!$orderDetails) {
            return false;
        }

        foreach ($factoryArray as $factory_id) {

            $orderItems = OrderItem::where('order_id', $orderId)
                ->where('factory_id', $factory_id)
                ->get();

            if ($orderItems->isEmpty()) {
                continue;
            }

            // Build styled item rows to match the email template
            $itemListHtml = '';
            foreach ($orderItems as $index => $orderItem) {
                $optional_text = $orderItem->item_description ? ' - ' . $orderItem->item_description : '';
                $sub_product_name = SubProduct::where('sub_product_no', $orderItem->sub_product_no)->first()->product_name ?? '';
                $remake = $orderItem->remake_status == 1
                ? '<span style="background:#FFB916;color:#ffffff;font-size:11px;font-weight:700;padding:3px 10px;border-radius:5px;white-space:nowrap;">Remake</span>'
                : '';
                $bg = ($index % 2 === 0) ? 'background:#f9fafb;' : '';

                $itemListHtml .= '<tr><td style="padding:12px 16px;font-size:13px;color:#1f2937;' . $bg . '">'
                    . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0"><tr>'
                    . '<td>' . e($sub_product_name . $optional_text) . '</td>'
                    . '<td align="right">' . $remake . ' <span style="background:#eef2f7;color:#4b5563;font-size:11px;font-weight:700;padding:3px 10px;border-radius:5px;white-space:nowrap;">Qty - ' . (int) $orderItem->qty . '</span></td>'
                    . '</tr></table>'
                    . '</td></tr>';
            }

            $ids = $orderItems->pluck('id')->toArray();
            $commaSeparatedIds = implode(',', $ids);

            $techpackLink   = url('orders/DownloadTestPrint/' . $commaSeparatedIds);
            $rosterLink     = url('orders/csv/' . $orderDetails->id);
            $discussionLink = route('orders.info', ['id' => $orderDetails->id, 'type' => 'management']);
            $orderLink      = url("order_details/edit/{$orderId}/order") . '?active_tab=order';

            $playerReport = null;
            if (str_starts_with($orderDetails->order_no, 'TSR')) {
                $playerReport = route('store.generatePlayerCSV', ['id' => $orderDetails->id]);
            }

            if ($isUrgent == 1) {
                app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_new_urgent_order_production', [
                    'orderId'                => $orderId,
                    'send_relevent_factory'  => true,
                    'order_number'           => $orderDetails->order_no,
                    'order_link'             => $orderLink,
                    'ex_factory_date'        => $orderDetails->ex_factory_date,
                    'in_hand_due_date'       => $orderDetails->due_date,
                    'customer_details'       => trim(optional($orderDetails->contactDetails)->first_name . ' ' . optional($orderDetails->contactDetails)->last_name), 
                    'organization_name'      => optional($orderDetails->organizationDetails)->organization_name ?? '',
                    'order_description'      => $orderDetails->order_description ?? '',
                    'order_items_list'       => $itemListHtml,
                    'techpack_link'          => $techpackLink,
                    'roster_link'            => $rosterLink,
                    'discussion_link'        => $discussionLink,
                    'playerReport'           => $playerReport,
                ]);
            } else {
                app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_new_order_production', [
                    'orderId'                => $orderId,
                    'send_relevent_factory'  => true,
                    'order_number'           => $orderDetails->order_no,
                    'order_link'             => $orderLink,
                    'ex_factory_date'        => $orderDetails->ex_factory_date,
                    'in_hand_due_date'       => $orderDetails->due_date,
                    'customer_details'       => trim(optional($orderDetails->contactDetails)->first_name . ' ' . optional($orderDetails->contactDetails)->last_name),
                    'organization_name'      => optional($orderDetails->organizationDetails)->organization_name ?? '',
                    'order_description'      => $orderDetails->order_description ?? '',
                    'order_items_list'       => $itemListHtml,
                    'techpack_link'          => $techpackLink,
                    'roster_link'            => $rosterLink,
                    'discussion_link'        => $discussionLink,
                    'playerReport'           => $playerReport,
                ]);
            }
        }

        return true;
    }

    public function notifyFactoryUsersOnQuotes($orderId)
    {
        $allOrderItems = OrderItem::where('order_id', $orderId)->get();

        $factoryArray = $allOrderItems->pluck('factory_id')->filter()->unique();

        if ($factoryArray->isEmpty()) {
            return false;
        }

        $orderDetails = Order::find($orderId);

        if (!$orderDetails) {
            return false;
        }

        foreach ($factoryArray as $factory_id) {

            $orderItems = OrderItem::where('order_id', $orderId)
                ->where('factory_id', $factory_id)
                ->get();

            if ($orderItems->isEmpty()) {
                continue;
            }

            // Build styled item rows (alternating background, qty badge) to match the design
            $itemListHtml = '';
            foreach ($orderItems as $index => $orderItem) {
                $optional_text = $orderItem->item_description ? ' - ' . $orderItem->item_description : '';
                $sub_product_name = SubProduct::where('sub_product_no', $orderItem->sub_product_no)->first()->product_name ?? '';
                $remake = $orderItem->remake_status == 1
                ? '<span style="background:#FFB916;color:#ffffff;font-size:11px;font-weight:700;padding:3px 10px;border-radius:5px;white-space:nowrap;">Remake</span>'
                : '';
                $bg = ($index % 2 === 0) ? 'background:#f9fafb;' : '';
                $borderTop = ($index === 0) ? '' : 'border-top:1px solid #f0f0f0;';

                $itemListHtml .= '<div style="display:flex;align-items:center;justify-content:space-between;gap:10px;padding:12px 16px;font-size:13px;color:#1f2937;' . $bg . $borderTop . '">'
                    . '<span style="display:flex;align-items:center;gap:9px;">'
                    . '<span style="width:7px;height:7px;border-radius:50%;background:#0d9488;flex-shrink:0;display:inline-block;"></span>'
                    . $sub_product_name . $optional_text
                    . '</span>'
                    . '<span style="display:flex;align-items:center;gap:6px;">'
                    . $remake
                    . '<span style="background:#eef2f7;color:#4b5563;font-size:11px;font-weight:700;padding:3px 10px;border-radius:5px;white-space:nowrap;">Qty - ' . $orderItem->qty . '</span>'
                    . '</span>'
                    . '</div>';
            }

            $ids = $orderItems->pluck('id')->toArray();
            $commaSeparatedIds = implode(',', $ids);

            $discussionLink = route('orders.info', ['id' => $orderDetails->id, 'type' => 'management']);
            $rosterLink     = url('orders/csv/' . $orderDetails->id);
            $techpackLink   = url('orders/DownloadTestPrint/' . $commaSeparatedIds);
            $playerReport = route('store.generatePlayerCSV', ['id' => $orderDetails->id]);

            $templateKey = 'key_production_order_to_quotes_system_user';

            $this->notification_builder->sendNotification(
                $templateKey,
                [
                    '{order_number}'      => $orderDetails->order_no,
                    '{order_link}' => url("order_details/edit/{$orderId}/order") . '?active_tab=order',
                    '{ex_factory_date}'   => $orderDetails->ex_factory_date,
                    '{in_hand_due_date}'  => $orderDetails->due_date,
                    '{organization_name}' => optional($orderDetails->organizationDetails)->organization_name ?? '',
                    '{order_description}' => $orderDetails->order_description ?? '',
                    '{order_items_list}'  => $itemListHtml,
                    '{techpack_link}'     => $techpackLink,
                    '{roster_link}'       => $rosterLink,
                    '{discussion_link}'   => $discussionLink,
                    '{playerReport}'      => $playerReport,
                ],
                [
                    'order_id'                   => $orderDetails->id,
                    'order_item_id'              => $commaSeparatedIds,
                    'order_ex_fac_date'          => $orderDetails->ex_factory_date,
                    'order_in_hand_due_date'     => $orderDetails->due_date,
                    'target_notification_field' => $templateKey,
                    'new_notification'           => 1,
                ]
            );

            $templateKey2 = 'key_production_order_to_quotes_factory_user';

            $this->notification_builder->sendNotification(
                $templateKey2,
                [
                    '{order_number}'      => $orderDetails->order_no,
                    '{order_link}' => url("order_details/edit/{$orderId}/order") . '?active_tab=order',
                    '{ex_factory_date}'   => $orderDetails->ex_factory_date,
                    '{in_hand_due_date}'  => $orderDetails->due_date,
                    '{organization_name}' => optional($orderDetails->organizationDetails)->organization_name ?? '',
                    '{order_description}' => $orderDetails->order_description ?? '',
                    '{order_items_list}'  => $itemListHtml,
                    '{techpack_link}'     => $techpackLink,
                    '{roster_link}'       => $rosterLink,
                    '{discussion_link}'   => $discussionLink,
                    '{playerReport}'      => $playerReport,
                ],
                [
                    'order_id'                   => $orderDetails->id,
                    'order_item_id'              => $commaSeparatedIds,
                    'order_ex_fac_date'          => $orderDetails->ex_factory_date,
                    'order_in_hand_due_date'     => $orderDetails->due_date,
                    'target_notification_field' => $templateKey,
                    'new_notification'           => 1,
                ]
            );
        }

        return true;
    }

    public function emailFactoryUsersOnQuotes($orderId)
    {
        $allOrderItems = OrderItem::where('order_id', $orderId)->get();

        $factoryArray = $allOrderItems->pluck('factory_id')->filter()->unique();

        if ($factoryArray->isEmpty()) {
            return false;
        }

        $orderDetails = Order::with('contactDetails')->find($orderId);

        if (!$orderDetails) {
            return false;
        }

        foreach ($factoryArray as $factory_id) {

            $orderItems = OrderItem::where('order_id', $orderId)
                ->where('factory_id', $factory_id)
                ->get();

            if ($orderItems->isEmpty()) {
                continue;
            }

            // Build styled item rows to match the email template
            $itemListHtml = '';
            foreach ($orderItems as $index => $orderItem) {
                $optional_text = $orderItem->item_description ? ' - ' . $orderItem->item_description : '';
                $sub_product_name = SubProduct::where('sub_product_no', $orderItem->sub_product_no)->first()->product_name ?? '';
                $remake = $orderItem->remake_status == 1
                ? '<span style="background:#FFB916;color:#ffffff;font-size:11px;font-weight:700;padding:3px 10px;border-radius:5px;white-space:nowrap;">Remake</span>'
                : '';
                $bg = ($index % 2 === 0) ? 'background:#f9fafb;' : '';

                $itemListHtml .= '<tr><td style="padding:12px 16px;font-size:13px;color:#1f2937;' . $bg . '">'
                    . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0"><tr>'
                    . '<td>' . e($sub_product_name . $optional_text) . '</td>'
                    . '<td align="right">' . $remake . ' <span style="background:#eef2f7;color:#4b5563;font-size:11px;font-weight:700;padding:3px 10px;border-radius:5px;white-space:nowrap;">Qty - ' . (int) $orderItem->qty . '</span></td>'
                    . '</tr></table>'
                    . '</td></tr>';
            }

            $ids = $orderItems->pluck('id')->toArray();
            $commaSeparatedIds = implode(',', $ids);

            $techpackLink   = url('orders/DownloadTestPrint/' . $commaSeparatedIds);
            $rosterLink     = url('orders/csv/' . $orderDetails->id);
            $discussionLink = route('orders.info', ['id' => $orderDetails->id, 'type' => 'management']);
            $orderLink      = url("order_details/edit/{$orderId}/order") . '?active_tab=order';

            $playerReport = null;
            if (str_starts_with($orderDetails->order_no, 'TSR')) {
                $playerReport = route('store.generatePlayerCSV', ['id' => $orderDetails->id]);
            }
            
            app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_production_order_to_quotes_system_user', [
                'orderId'                => $orderId,
                'send_relevent_factory'  => true,
                'order_number'           => $orderDetails->order_no,
                'order_link'             => $orderLink,
                'ex_factory_date'        => $orderDetails->ex_factory_date,
                'in_hand_due_date'       => $orderDetails->due_date,
                'customer_details'       => trim(optional($orderDetails->contactDetails)->first_name . ' ' . optional($orderDetails->contactDetails)->last_name),
                'organization_name'      => optional($orderDetails->organizationDetails)->organization_name ?? '',
                'order_description'      => $orderDetails->order_description ?? '',
                'order_items_list'       => $itemListHtml,
                'techpack_link'          => $techpackLink,
                'roster_link'            => $rosterLink,
                'discussion_link'        => $discussionLink,
                'playerReport'           => $playerReport,
            ]);

            app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_production_order_to_quotes_factory_user', [
                'orderId'                => $orderId,
                'send_relevent_factory'  => true,
                'order_number'           => $orderDetails->order_no,
                'order_link'             => $orderLink,
                'ex_factory_date'        => $orderDetails->ex_factory_date,
                'in_hand_due_date'       => $orderDetails->due_date,
                'customer_details'       => trim(optional($orderDetails->contactDetails)->first_name . ' ' . optional($orderDetails->contactDetails)->last_name),
                'organization_name'      => optional($orderDetails->organizationDetails)->organization_name ?? '',
                'order_description'      => $orderDetails->order_description ?? '',
                'order_items_list'       => $itemListHtml,
                'techpack_link'          => $techpackLink,
                'roster_link'            => $rosterLink,
                'discussion_link'        => $discussionLink,
                'playerReport'           => $playerReport,
            ]);
        }

        return true;
    }

    public function emailFactoryUsersToInformAddNewItems($orderId, $newOrderItems)
    {
       

        $orderDetails = Order::with(['organizationDetails', 'contactDetails'])->find($orderId);

        if (!$orderDetails) {
            return false;
        }

        $itemListHtml = '';
        foreach ($newOrderItems as $orderItem) {
            $item = OrderItem::find($orderItem->id);
            if (!$item) {
                continue;
            }

            $productName = $item->display_name ?? optional($item->productDetails)->product_name ?? '-';
            $orderItemDetail = OrderItemsDetail::where('order_item_id', $item->id)->first();
            $sizeName = $orderItemDetail->size_name ?? null;
            $colorName = $item->color_name ?? null;

           $itemListHtml .= '<tr><td style="padding:14px 16px;">'
                . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;"><tr>'
                . '<td valign="middle" style="font-size:14px;font-weight:700;color:#111827;padding-right:10px;">' . e($productName) . '</td>'
                . (!empty($sizeName) ? '<td valign="middle" style="padding-right:8px;"><span style="display:inline-block;background:#eef2f7;color:#4b5563;font-size:11px;font-weight:700;padding:3px 10px;border-radius:5px;white-space:nowrap;">Size - ' . e($sizeName) . '</span></td>' : '')
                . (!empty($colorName) ? '<td valign="middle" style="padding-right:8px;"><span style="display:inline-block;background:#eef2f7;color:#4b5563;font-size:11px;font-weight:700;padding:3px 10px;border-radius:5px;white-space:nowrap;">Color - ' . e($colorName) . '</span></td>' : '')
                . '<td valign="middle"><span style="display:inline-block;background:#eef2f7;color:#4b5563;font-size:11px;font-weight:700;padding:3px 10px;border-radius:5px;white-space:nowrap;">Qty - ' . (int) $item->qty . '</span></td>'
                . '</tr></table>'
                . '</td></tr>';
        }

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_order_added_new_items', [
            'orderId'            => $orderId,
            'order_number'       => $orderDetails->order_no,
            'organization_name'  => optional($orderDetails->organizationDetails)->organization_name ?? '',
            'customer_details'   => trim(optional($orderDetails->contactDetails)->first_name . ' ' . optional($orderDetails->contactDetails)->last_name),
            'send_relevent_factory' => true,
            'new_order_items'    => $newOrderItems,
            'order_items_list'   => $itemListHtml,
            'order_link'         => url("order_details/edit/{$orderId}/order") . '?active_tab=order',
        ]);

        return true;
    }

    public function columnLayout(Request $request){
        $orderLayout = new OrderLayout();
        $orderLayout->user_id = Auth::user()->id;
        $orderLayout->save();

        return json_encode('Orders Column Layout Created!');
    }

    public function showColumn(Request $request){
        $orderLayout = OrderLayout::where('user_id', Auth::user()->id)->first();

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

        } else if ($request->attribute_name == 'order_total') {
            $orderLayout->order_total = 1;

        } else if ($request->attribute_name == 'order_status') {
            $orderLayout->order_status = 1;

        } else if ($request->attribute_name == 'contact_person') {
            $orderLayout->contact_person = 1;

        } else if ($request->attribute_name == 'order_description') {
            $orderLayout->order_description = 1;

        } else if ($request->attribute_name == 'sub_total') {
            $orderLayout->sub_total = 1;

        } else if ($request->attribute_name == 'sales_tax') {
            $orderLayout->sales_tax = 1;

        } else if ($request->attribute_name == 'shipping') {
            $orderLayout->shipping = 1;

        } else if ($request->attribute_name == 'artwork') {
            $orderLayout->artwork = 1;

        } else if ($request->attribute_name == 'processing_fee') {
            $orderLayout->processing_fee = 1;

        } else if ($request->attribute_name == 'team_store_file') {
            $orderLayout->team_store_file = 1;

        } else if ($request->attribute_name == 'created_at') {
            $orderLayout->created = 1;

        } else if ($request->attribute_name == 'updated_at') {
            $orderLayout->updated = 1;

        }else if ($request->attribute_name == 'payment_status') {
            $orderLayout->updated = 1;

        }
        $orderLayout->update();

        return json_encode('Orders Column Show!');
    }

    public function hideColumn(Request $request){
        $orderLayout = OrderLayout::where('user_id', Auth::user()->id)->first();

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

        } else if ($request->attribute_name == 'order_total') {
            $orderLayout->order_total = 0;

        } else if ($request->attribute_name == 'order_status') {
            $orderLayout->order_status = 0;

        } else if ($request->attribute_name == 'contact_person') {
            $orderLayout->contact_person = 0;

        } else if ($request->attribute_name == 'order_description') {
            $orderLayout->order_description = 0;

        } else if ($request->attribute_name == 'sub_total') {
            $orderLayout->sub_total = 0;

        } else if ($request->attribute_name == 'sales_tax') {
            $orderLayout->sales_tax = 0;

        } else if ($request->attribute_name == 'shipping') {
            $orderLayout->shipping = 0;

        } else if ($request->attribute_name == 'artwork') {
            $orderLayout->artwork = 0;

        } else if ($request->attribute_name == 'processing_fee') {
            $orderLayout->processing_fee = 0;

        } else if ($request->attribute_name == 'team_store_file') {
            $orderLayout->team_store_file = 0;

        } else if ($request->attribute_name == 'created_at') {
            $orderLayout->created = 0;

        } else if ($request->attribute_name == 'updated_at') {
            $orderLayout->updated = 0;

        }else if ($request->attribute_name == 'payment_status') {
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
    // Order items design download at once +++ Heshan Namal +++

    // public function DownloadOrderItemDesign($orderId) {
    //     // Retrieve the order and its related order items
    //     $order = Order::with('orderItems.orderItemFiles')->find($orderId);
    //     $user = Auth::user();
    //     $roles = $user->role_id;

    //     // Convert the string to an array if needed
    //     $rolesArray = json_decode($roles, true);

    //     // // Check if the user has any role with factory_id equal to 2
    //     // $hasFactory2 = in_array(2, $rolesArray);
    //     $factory = Factory::whereIn('permission_id', $rolesArray)->first();

    //     // Check if the order exists
    //     if (!$order) {
    //         return response()->json(['error' => 'Order not found'], 404);
    //     }

    //     // Check if the roles array contains '1'
    //     if (in_array(1, $rolesArray)) {
    //         // If '1' is present in the roles array, get all order items
    //         $orderItems = $order->orderItems;
    //     } else {
    //         if (!$factory) {
    //             return response()->json(['error' => 'User not in any related factory'], 445)->header('Content-Type', 'application/json');
    //         } else {
    //             $factoryId = $factory->id;
    //         }

    //         // Otherwise, filter order items based on the factory ID
    //         $orderItems = $order->orderItems->filter(function ($item) use ($factoryId) {
    //             return $item->factory_id == $factoryId;
    //         });
    //     }

    //     // Check if there are order items
    //     if ($orderItems->isEmpty()) {
    //         return response()->json(['error' => 'No order items found'], 404);
    //     }

    //     // Get the organization name if organization details exist
    //     $organizationName = optional($order->organizationDetails)->organization_name;
    //     $organizationName =  str_replace('/', '_', $organizationName);

    //     // Specify the path to the public folder
    //     $publicPath = public_path();

    //     // Specify the path to the zip file within the public folder
    //     $zipFilePath = $publicPath . '/' . $orderId . '-' . $organizationName . '.zip';

    //     // Create a new ZipArchive instance
    //     $zip = new \ZipArchive();

    //     // Open the zip file in the public folder
    //     if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
    //         foreach ($orderItems as $orderItem) {
    //             // Create a directory for the item within the zip
    //             $itemDirectoryName = $orderId . '-' . $organizationName . '/' . $orderItem->id . '-' . str_replace('/', '_', $orderItem->display_name) . '/';
    //             $itemDirectoryPath = $publicPath . '/' . $itemDirectoryName;

    //             // Ensure the directory exists before adding files to it
    //             if (!is_dir($itemDirectoryPath)) {
    //                 mkdir($itemDirectoryPath, 0777, true);
    //             }

    //             // Generate Excel file for the order item and add it to the zip within the item directory
    //             // $excelFileName = $orderItem->item_no . '.xlsx';
    //             // $excelFileContents = (new OrderItemExport($orderItem->id))->download('Order_Item_'.$orderItem->item_no.'.xlsx');
    //             // $zip->addFromString($itemDirectoryName . 'Order_Item_'.$orderItem->item_no.'.xlsx', $excelFileContents);
    //             $excelFileName = 'Order_Item_' . $orderItem->item_no . '.xlsx';
    //             $excelExport = new OrderItemExport($orderItem->id);
    //             $excelFilePath = storage_path('app/' . $excelFileName); // Store the Excel file temporarily
    //             $excelExport->store($excelFileName, 'local'); // Store the Excel file
    //             $excelFileContents = file_get_contents($excelFilePath); // Get the file contents

    //             $zip->addFromString($itemDirectoryName . $excelFileName, $excelFileContents); // Add the Excel file to the zip archive

    //             // After adding to the zip archive, you can delete the temporary Excel file
    //             unlink($excelFilePath);

    //             // Copy tech pack files to the zip within the item directory
    //             foreach ($orderItem->orderItemFiles as $orderItemFile) {
    //                 if (!is_null($orderItemFile->tech_pack_files)) {
    //                     $techPackFileLink = $orderItemFile->tech_pack_files;
    //                     $fileName = $orderItemFile->tech_pack_file_name;
    //                     $techPackFileLink = str_replace('/view?usp=sharing', '/uc?export=download', $techPackFileLink);

    //                     // Download the file from the link and add it to the zip within the item directory if successful
    //                     $fileContents = @file_get_contents($techPackFileLink);
    //                     if ($fileContents !== false) {
    //                         $zip->addFromString($itemDirectoryName . $fileName, $fileContents);
    //                     }
    //                 }
    //                 if (!is_null($orderItemFile->tech_pack_images)) {
    //                     $techPackImageLink = $orderItemFile->tech_pack_images;
    //                     $fileName = $orderItemFile->tech_pack_image_name;
    //                     $techPackImageLink = str_replace('/view?usp=sharing', '/uc?export=download', $techPackImageLink);

    //                     // Download the file from the link and add it to the zip within the item directory if successful
    //                     $fileContents = @file_get_contents($techPackImageLink);
    //                     if ($fileContents !== false) {
    //                         $zip->addFromString($itemDirectoryName . $fileName, $fileContents);
    //                     }
    //                 }
    //             }
    //         }
    //         $zip->close();
    //     } else {
    //         return response()->json(['error' => 'Failed to create zip archive'], 457);
    //     }

    //     // Stream the zip file to the client
    //     $response = response()->download($zipFilePath)->deleteFileAfterSend(true);
    //     $response->setContentDisposition('attachment', $orderId . '-' . $organizationName . '.zip');

    //     return $response;
    // }


    public function initiateFolderCreation($orderId)
    {
        $order = Order::with(['orderItems' => function ($query) {
                            $query->where('active', 1);
                        }])->find($orderId);

        $user = Auth::user();
        $rolesArray = json_decode($user->role_id, true);
        $factory = Factory::whereIn('permission_id', $rolesArray)->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        if (!empty(array_intersect([1, 3], $rolesArray))) {
            $orderItems = $order->orderItems;
        } else {
            if (!$factory) {
                return response()->json(['error' => 'User not in any related factory'], 445);
            }
            $factoryId = $factory->id;
            $orderItems = $order->orderItems->filter(function ($item) use ($factoryId) {
                return $item->factory_id == $factoryId;
            });
        }

        if ($orderItems->isEmpty()) {
            return response()->json(['error' => 'No order items found'], 404);
        }

        $organizationName = optional($order->organizationDetails)->organization_name;
        $organizationName = str_replace('/', '_', $organizationName);
        $folderPath = public_path() . '/' . $orderId . '-' . $organizationName.'-'.$user->id;

        // Check if the folder exists, if so, delete it and recreate
        if (file_exists($folderPath)) {
            $this->deleteFolder($folderPath);
        }

        // Create the new folder
        mkdir($folderPath, 0777, true);

        // Retrieve the order item IDs
        $orderItemIds = $orderItems->pluck('id')->toArray();

        return response()->json([
            'message' => 'Folder created',
            'folderPath' => $folderPath,
            'organizationName' => $organizationName,
            'orderItemIds' => $orderItemIds
        ], 200);
    }

    public function addFilesToFolder(Request $request)
    {
        $orderId = $request->orderId;
        $orderItemId = $request->orderItemId;
        $folderPath = $request->folderPath;
        $organizationName = $request->organizationName;
        $user = Auth::user();

        $orderItem = OrderItem::with('orderItemFiles','subProduct')->find($orderItemId);
        if (!$orderItem) {
            return response()->json(['error' => 'Order item not found'], 404);
        }


        $itemDirectoryName = $folderPath . '/' . $orderItem->id . '-' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $orderItem->display_name ?? $orderItem->subProduct->product_name);
        if (!file_exists($itemDirectoryName)) {
            mkdir($itemDirectoryName, 0777, true);
        }

        // Add Excel file
        $excelFileName = 'Order_Item_' .  preg_replace('/[^A-Za-z0-9_\-]/', '_', $orderItem->id) . '.xlsx';
        $excelFileName2 = 'Order_Item_' .  preg_replace('/[^A-Za-z0-9_\-]/', '_', $orderItem->item_no) . '.xlsx';
        $excelExport = new OrderItemExport($orderItem->id);
        $excelFilePath = storage_path('app/' .$user->id.'-'.$excelFileName);
        $excelExport->store($user->id.'-'.$excelFileName, 'local');
        copy($excelFilePath, $itemDirectoryName . '/' . $excelFileName2);
        if (file_exists($excelFilePath)) {
            unlink($excelFilePath);
        }

        // Add other files
        foreach ($orderItem->orderItemFiles as $orderItemFile) {
            if (!is_null($orderItemFile->tech_pack_files)) {
                $techPackFileLink = $orderItemFile->tech_pack_files;
                if (strpos($techPackFileLink, 'drive.google.com') !== false) {
                    $techPackFileLink = str_replace('/view?usp=sharing', '/uc?export=download', $techPackFileLink);
                    $fileContents = @file_get_contents($techPackFileLink);
                    if ($fileContents !== false) {
                        file_put_contents($itemDirectoryName . '/' . $orderItemFile->tech_pack_file_name, $fileContents);
                    }
                } else{
                    $fileContents = $techPackFileLink;
                    $parsedUrl = parse_url($techPackFileLink);
                    if (isset($parsedUrl['path'])) {
                        $fullPath = $parsedUrl['path'];

                        $pathSegments = explode('/', $fullPath);

                        $orderFilesIndex = array_search('order_files', $pathSegments);

                        if ($orderFilesIndex !== false) {
                            $relativePathSegments = array_slice($pathSegments, $orderFilesIndex);
                            $relativePath = implode('/', $relativePathSegments);

                            $relativePath = ltrim($relativePath, '/');

                            $storagePath = public_path($relativePath);

                            copy($storagePath , $itemDirectoryName . '/' . $orderItemFile->tech_pack_file_name);
                        }
                    }
                }
            }
            if (!is_null($orderItemFile->tech_pack_images)) {
                $techPackImageLink = $orderItemFile->tech_pack_images;
                if (strpos($techPackImageLink, 'drive.google.com') !== false) {
                    $techPackImageLink = str_replace('/view?usp=sharing', '/uc?export=download', $techPackImageLink);
                    $fileContents = @file_get_contents($techPackImageLink);

                    if ($fileContents !== false) {
                        file_put_contents($itemDirectoryName . '/' . $orderItemFile->tech_pack_image_name, $fileContents);
                    }
                } else {
                    $parsedUrl = parse_url($techPackImageLink);
                    if (isset($parsedUrl['path'])) {
                        $fullPath = $parsedUrl['path'];

                        $pathSegments = explode('/', $fullPath);

                        $orderFilesIndex = array_search('order_files', $pathSegments);

                        if ($orderFilesIndex !== false) {
                            $relativePathSegments = array_slice($pathSegments, $orderFilesIndex);
                            $relativePath = implode('/', $relativePathSegments);

                            $relativePath = ltrim($relativePath, '/');

                            $storagePath = public_path($relativePath);

                            copy($storagePath , $itemDirectoryName . '/' . $orderItemFile->tech_pack_image_name);
                        }
                    }
                }


            }
        }

        return response()->json(['message' => 'Files added to folder'], 200);
    }


    public function downloadFolder(Request $request)
    {
        // dd($request);
        $folderPath = $request->folderPath;

        if (!file_exists($folderPath)) {
            return response()->json(['error' => 'Folder not found'], 404);
        }

        // Zip the folder content
        $zipFileName = basename($folderPath) . '.zip';
        $zipFilePath = storage_path($zipFileName);

        $zip = new \ZipArchive();
        if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($folderPath),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $name => $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($folderPath) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }

            $zip->close();
            $this->deleteFolder($folderPath);
            return response()->download($zipFilePath, $zipFileName)->deleteFileAfterSend(true);
        } else {
            return response()->json(['error' => 'Failed to create zip archive'], 500);
        }
    }
    private function deleteFolder($folderPath)
    {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($folderPath, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $fileinfo) {
            $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
            $todo($fileinfo->getRealPath());
        }

        rmdir($folderPath);
    }

    public function cancel_order(Request $request){
        // Find the order by ID
        $order = Order::find($request->order_id);

        // Update the order status and cancellation reason
        $order->order_status_id = 7;
        $order->cancel_reason = $request->reason;
        $order->save();

        // Update the status of the associated order items
        $order->orderItems()->update(['order_status_id' => 7]);
        // dd($order);
        return response()->json(['message' => 'Order canceled'], 200);
    }
    public function get_multiple_order_details(Request $request){
        $orders = Order::with('organizationDetails')
                            ->where('active', 1)
                            ->whereIn('id', $request->order_ids)
                            ->get();
        // Process each order and add payment status
         $orders->transform(function ($order) {
            $order->payment_status = $this->PaymentService->getPaymentStatus($order->id);
            return $order;
        });
        $debit_balance = Organization::where('id', $request->org_id)->value('debit_balance')?? 0;
        // dd($orders[0]->payment_status);
        return response()->json([
            'data' => $orders,
            'debit_balance'=>$debit_balance,

        ], 200);
    }





}
