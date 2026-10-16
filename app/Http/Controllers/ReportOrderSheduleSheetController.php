<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use domainencore\Facades\OrdersCommenFacade\OrdersCommenFacade;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderStatus;
use App\Models\Factory;
use App\Models\User;
use App\Models\OrderSheduleColor;
use App\Models\OrderSheduleComment;
use App\Exports\ReportOrderSheduleExport;

class ReportOrderSheduleSheetController extends Controller
{

    protected $inventoryOrgIds;

    public function __construct()
    {
        $this->inventoryOrgIds = OrdersCommenFacade::getEncoreOrgIds()->toArray();
    }

    public function index(){

        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')->where('organization_id', '!=', 1377)->where('order_no', 'NOT LIKE', 'TSR%');

        $factoriesQuery = Factory::select('id', 'factory_code');

        $sheduleColor = OrderSheduleColor::get();

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

            $currentMonth = date('m');
            $currentYear = date('Y');
            $orderQuery->whereRaw('MONTH(STR_TO_DATE(ex_factory_date, "%m/%d/%Y")) = ?', [$currentMonth])
                       ->whereRaw('YEAR(STR_TO_DATE(ex_factory_date, "%m/%d/%Y")) = ?', [$currentYear]);

        $orderQuery->addSelect(['shedule_color' => OrderSheduleColor::select('color_code')->whereColumn('order_id', 'orders.id')->limit(1)]);

        $orderQuery->addSelect(['shedule_comment' => OrderSheduleComment::select('special_comment')->whereColumn('order_id', 'orders.id')->limit(1)]);

        $orders = $orderQuery->where('active', 1)->whereNotIn('order_status_id', [1])->orderBy('ex_factory_date', 'ASC')->paginate(1000);

        $factories = $factoriesQuery->where('active', 1)->orderBy('id')->get();

        $orderStatus = OrderStatus::select('id', 'status_name')->where('id', '!=', 1)->where('active', 1)->orderBy('id')->get();

        $users = User::select('id', 'name')->where('user_role_id', 3)->where('active', 1)->orderBy('name')->get();

        return view('pages.reports.order_shedule.index', ['orders'=>$orders, 'factories'=>$factories, 'orderStatus'=>$orderStatus, 'users'=>$users]);
    }

    public function orderSheduleColor(Request $request)
    {
        $request->validate([
            'selectedOrders' => 'required|array',
            'selectedColor' => 'required|string|max:255',
        ]);

        // Extract data from the request
        $selectedOrders = $request->input('selectedOrders');
        $selectedColor = $request->input('selectedColor');

        foreach ($selectedOrders as $orderId) {
            $sheduleColor = OrderSheduleColor::where('order_id', $orderId)->first();

            if ($sheduleColor) {
                $sheduleColor->color_code = $selectedColor;
                $sheduleColor->active = 1;
                $sheduleColor->update();
            } else {
                $newSheduleColor = new OrderSheduleColor();
                $newSheduleColor->order_id = $orderId;
                $newSheduleColor->color_code = $selectedColor;
                $newSheduleColor->active = 1;
                $newSheduleColor->save();
            }
        }

        return response()->json(['message' => 'Colors updated successfully']);
    }


    public function saveSpecialComment(Request $request){

        $orderId = $request->order_id;

        $sheduleComment = OrderSheduleComment::where('order_id', $orderId)->first();
        // dd($sheduleComment);
        if($sheduleComment){
            $sheduleComment->special_comment = $request->special_comment;
            $sheduleComment->active = 1;
            $sheduleComment->update();

            return redirect()->back()->with('success', 'Special comment Update successfully.');

        } else {
            $sheduleCommentNew = new OrderSheduleComment();

            $sheduleCommentNew->order_id = $orderId;
            $sheduleCommentNew->special_comment = $request->special_comment;
            $sheduleCommentNew->active = 1;
            $sheduleCommentNew->save();

            return redirect()->back()->with('success', 'Special comment saved successfully.');
        }

    }

    public function filterOrdershedule(Request $request){

        $searchValue = $request->input('searchValue');
        $month = $request->input('month');
        $year = $request->input('year');
        $filterFactory = $request->input('factory');
        $orderStatus = $request->input('orderStatus');
        $testPrint = $request->input('testPrint');
        $usersSales = $request->input('usersSales');

        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')->where('organization_id', '!=', 1377)->where('order_no', 'NOT LIKE', 'TSR%');

        $factoriesQuery = Factory::select('id', 'factory_code');

        $sheduleColor = OrderSheduleColor::get();

            $orderQuery->where(function ($query) use ($searchValue) {
                $query->whereHas('organizationDetails', function ($query) use ($searchValue) {
                    $query->where('organization_name', 'LIKE', '%' . $searchValue . '%');
                });
                $query->orWhere('order_no', 'LIKE', '%' . $searchValue . '%');
                $query->orWhereHas('userDetails', function ($query) use ($searchValue) {
                    $query->where('name', 'LIKE', '%' . $searchValue . '%');
                });
                $query->orWhereHas('orderItems.factoryDetails', function ($query) use ($searchValue) {
                    $query->where('factory_name', 'LIKE', '%' . $searchValue . '%')
                        ->orWhere('factory_code', 'LIKE', '%' . $searchValue . '%');
                });
            });

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

            // Test print needed
            if ($testPrint != 'all') {
                $orderQuery->whereHas('orderItems', function($query) use($testPrint) {
                    $query->where('test_print_needed', $testPrint);
                });
            }

            if ($usersSales != 'all') {
                $orderQuery->where(function ($query) use ($usersSales) {
                    $query->where('user_id', $usersSales)
                          ->orWhere('order_procesing_user_id', $usersSales);
                });
            }

            $orderQuery->whereRaw('MONTH(STR_TO_DATE(ex_factory_date, "%m/%d/%Y")) = ?', [$month])
                       ->whereRaw('YEAR(STR_TO_DATE(ex_factory_date, "%m/%d/%Y")) = ?', [$year]);

        $orderQuery->addSelect(['shedule_color' => OrderSheduleColor::select('color_code')->whereColumn('order_id', 'orders.id')->limit(1)]);

        $orderQuery->addSelect(['shedule_comment' => OrderSheduleComment::select('special_comment')->whereColumn('order_id', 'orders.id')->limit(1)]);

        $orders = $orderQuery->where('active', 1)->whereNotIn('order_status_id', [1])->orderBy('ex_factory_date', 'ASC')->get();

        return response()->json(['month'=>$month, 'year'=>$testPrint, 'orders'=>$orders]);
    }

    public function sheduleSearchOrder(Request $request){
        $searchValue = $request->input('searchValue');
        $selectedYear = $request->input('selectedYear');
        $selectedMonth = $request->input('selectedMonth');

        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')->where('organization_id', '!=', 1377)->where('order_no', 'NOT LIKE', 'TSR%');

        $factoriesQuery = Factory::select('id', 'factory_code');


        $orderQuery->whereRaw('MONTH(STR_TO_DATE(ex_factory_date, "%m/%d/%Y")) = ?', [$selectedMonth])
                       ->whereRaw('YEAR(STR_TO_DATE(ex_factory_date, "%m/%d/%Y")) = ?', [$selectedYear]);

        // Organization name search, order number search, user name search, factory name and code search
        $orderQuery->where(function ($query) use ($searchValue) {
            $query->whereHas('organizationDetails', function ($query) use ($searchValue) {
                $query->where('organization_name', 'LIKE', '%' . $searchValue . '%');
            });
            $query->orWhere('order_no', 'LIKE', '%' . $searchValue . '%');
            $query->orWhereHas('userDetails', function ($query) use ($searchValue) {
                $query->where('name', 'LIKE', '%' . $searchValue . '%');
            });
            $query->orWhereHas('orderItems.factoryDetails', function ($query) use ($searchValue) {
                $query->where('factory_name', 'LIKE', '%' . $searchValue . '%')
                    ->orWhere('factory_code', 'LIKE', '%' . $searchValue . '%');
            });
        });

        // Factory filter
        if ($request->fct) {
            $orderQuery->whereHas('orderItems.factoryDetails', function($query) use($request) {
                $query->where('id', $request->fct);
            });
        }

        // Status filter
        if ($request->sts) {
            $orderQuery->where('order_status_id', $request->sts);
        }

        if ($oderSearch == 'factory') {
            $orderQuery->with(['orderItems' => function($qry) use($factoryIds) {
                $qry->with('factoryDetails')
                    ->whereIn('factory_id', $factoryIds)
                    ->where('order_status_id', 3);
            }]);
            $orderQuery->whereHas('orderItems', function($qr) use($factoryIds) {
                $qr->whereIn('factory_id', $factoryIds)
                ->where('order_status_id', 3);
            });
            $factoriesQuery->whereIn('id', $factoryIds);
        } else {
            $orderQuery->with('orderItems.factoryDetails');
        }


        $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->whereNotIn('order_status_id', [1])->orderBy('id', 'DESC')->get();

        return response()->json(['selectedYear'=>$selectedYear, 'orders'=>$orders]);
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

    public function orderShedule_CSV_download($selectedYear, $selectedMonth){

        return (new ReportOrderSheduleExport($selectedYear, $selectedMonth))->download('Order_Shedule.xlsx');

    }
}
