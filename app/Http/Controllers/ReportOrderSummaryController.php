<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\CheckPayment;
use App\Models\PaymentLog;
use App\Models\VenmoPayment;
use App\Models\PaypalPayment;
use App\Models\OrderStatus;
use App\Models\OrderLayout;
use App\Models\ColumnLayout;
use App\Models\Organization;
use App\Models\Factory;
use domainencore\Facades\OrdersCommenFacade\OrdersCommenFacade;
use Carbon\Carbon;
use App\Exports\ReportOrderSummaryExport;



class ReportOrderSummaryController extends Controller
{

    protected $inventoryOrgIds;

    public function __construct()
    {
        $this->inventoryOrgIds = OrdersCommenFacade::getEncoreOrgIds()->toArray();
    }

    public function index(Request $request)
    {
        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')->where('organization_id', '!=', 1377)->where('order_no', 'NOT LIKE', 'TSR%');

        $factoriesQuery = Factory::select('id', 'factory_code');

        // Orgnnization name serach
        //     if($request->org){
        //         $orderQuery->whereHas('organizationDetails', function($query) use($request) {
        //             $query->where('organization_name', 'LIKE', '%'.$request->org.'%');
        //             $query->whereNotIn('id', $this->inventoryOrgIds);
        //         });
        //         $orderQuery->orWhere('order_no', 'LIKE', '%'.$request->org.'%');
        //     }
        // // factory filter
        //     if($request->fct){
        //         $orderQuery->whereHas('orderItems.factoryDetails', function($query) use($request) {
        //             $query->where('id', $request->fct);
        //         });
        //     }
        // // status filter
        //     if($request->sts){
        //         $orderQuery->where('order_status_id', $request->sts);
        //     }

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

        $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->orderBy('id', 'DESC')->paginate(10);

        $factories = $factoriesQuery->where('active', 1)->orderBy('id')->get();

        $orderStatus = OrderStatus::select('id', 'status_name')->where('active', 1)->orderBy('id')->get();

        return view('pages.reports.order_summary.index', ['firstTenItems' => $orders, 'factories'=>$factories, 'orderStatus'=>$orderStatus]);
    }

    public function filterOrderSummary(Request $request){

        $startDate = Carbon::createFromFormat('Y-m-d', $request->input('startDate'))->format('m/d/Y');
        $endDate = Carbon::createFromFormat('Y-m-d', $request->input('endDate'))->format('m/d/Y');
        $filterDate = $request->input('filterDate');
        $filterFactory = $request->input('filterFactory');
        $orderStatus = $request->input('orderStatus');
        $testPrint = $request->input('testPrint');
        $paymentStatus1 = $request->input('paymentStatus');

        $startDate1 = $request->input('startDate');
        $endDate1 = $request->input('endDate');

        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');

        $factoriesQuery = Factory::select('id', 'factory_code');

        // Orgnnization name serach
            if($request->org){
                $orderQuery->whereHas('organizationDetails', function($query) use($request) {
                    $query->where('organization_name', 'LIKE', '%'.$request->org.'%');
                    $query->whereNotIn('id', $this->inventoryOrgIds);
                });
                $orderQuery->orWhere('order_no', 'LIKE', '%'.$request->org.'%');
            }

        // factory filter
            if($filterFactory == 'all'){
                if($request->fct){
                    $orderQuery->whereHas('orderItems.factoryDetails', function($query) use($request) {
                    $query->where('id', $request->fct);
                    });
                }
            } else {

                if ($filterFactory) {
                    $orderQuery->whereHas('orderItems.factoryDetails', function($query) use($filterFactory) {
                        $query->where('id', $filterFactory);
                    });
                }

            }

        // status filter
        if($orderStatus == 'all'){
            if($request->sts){
                $orderQuery->where('order_status_id', $request->sts);
            }
        } else {
            if ($orderStatus) {
                $orderQuery->where('order_status_id', $orderStatus);
            }
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


        // Test print needed
        if ($testPrint != 'all') {
            $orderQuery->whereHas('orderItems', function($query) use($testPrint) {
                $query->where('test_print_needed', $testPrint);
            });
        }


        if ($filterDate == 'created_at') {
            $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->whereBetween('created_at', [$startDate1, $endDate1])->orderBy('id', 'DESC')->get();
        } else if ($filterDate == 'due_date'){
            $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->whereBetween('due_date', [$startDate, $endDate])->orderBy('id', 'DESC')->get();
        } else if ($filterDate == 'ex_factory'){
            $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->whereBetween('ex_factory_date', [$startDate, $endDate])->orderBy('id', 'DESC')->get();
        }

        foreach ($orders as $order) {
            $cardPaymenttot = PaymentLog::where('order_id', $order->id)->sum('amount');
            $checkPaymenttot = CheckPayment::where('order_id', $order->id)->sum('amount');
            $venmoPaymenttot = VenmoPayment::where('order_id', $order->id)->sum('amount');
            $paypalPaymenttot = PaypalPayment::where('order_id', $order->id)->sum('amount');

            $payment = number_format($cardPaymenttot + $checkPaymenttot + $venmoPaymenttot + $paypalPaymenttot, 2);
            $orderTotal = number_format($order->order_total, 2);

            // Determine payment status
            $paymentStatus = 'Pending';
            if ($payment == 0) {
                $paymentStatus = "Pending";
            } else if ($payment < $orderTotal && $payment > 0) {
                $paymentStatus = "Partial";
            } else {
                $paymentStatus = "Paid";
            }

            // Add payment status to each order
            $order->paymentStatus = $paymentStatus;
        }

        // Filter orders based on paymentStatus if provided in the request
        if ($paymentStatus1 && $paymentStatus1 != 'all') {
            $paymentStatusFilter = $paymentStatus1;
            $filteredOrders = $orders->filter(function ($order) use ($paymentStatusFilter) {
                return $order->paymentStatus == $paymentStatusFilter;
            });
            $orders = $filteredOrders->values()->all(); // Convert filtered orders collection to array
        }


        return response()->json(['startDate'=>$startDate, 'filterDate'=>$filterDate, 'orders'=>$orders]);
    }

    public function orderSummarySearchOrder(Request $request){

        $searchValue = $request->input('searchValue');

        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')->where('organization_id', '!=', 1377)->where('order_no', 'NOT LIKE', 'TSR%');

        $factoriesQuery = Factory::select('id', 'factory_code');

        // Orgnnization name serach
        $orderQuery->where(function ($query) use ($searchValue) {
            $query->whereHas('organizationDetails', function ($query) use ($searchValue) {
                $query->where('organization_name', 'LIKE', '%' . $searchValue . '%');
            });
            $query->orWhere('order_no', 'LIKE', '%' . $searchValue . '%');
        });

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

        $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->orderBy('id', 'DESC')->get();


        return response()->json(['searchValue'=>$searchValue, 'orders'=>$orders]);
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

    public function orderSummary_CSV_download($dateType, $startDate1, $endDate1, $filterFactory, $orderStatus, $testPrint, $paymentStatus1)
    {
        return (new ReportOrderSummaryExport($dateType, $startDate1, $endDate1, $filterFactory, $orderStatus, $testPrint, $paymentStatus1))->download('Order_Summary.xlsx');
    }


}
