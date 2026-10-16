<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\CheckPayment;
use App\Models\PaymentLog;
use App\Models\VenmoPayment;
use App\Models\PaypalPayment;
use App\Models\Factory;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use domainencore\Facades\OrdersCommenFacade\OrdersCommenFacade;

class ReportOrderSummaryExport implements FromView, WithColumnWidths
{
    use Exportable;

    protected $dateType1;
    protected $startDate1;
    protected $endDate1;
    protected $factory1;
    protected $orderStatus1;
    protected $testPrint1;
    protected $paymentStatus1;
    protected $inventoryOrgIds;

    public function __construct($dateType, $startDate1, $endDate1, $filterFactory, $orderStatus, $testPrint, $paymentStatus1)
    {
        $this->dateType1 = $dateType;
        $this->startDate1 = $startDate1;
        $this->endDate1 = $endDate1;
        $this->factory1 = $filterFactory;
        $this->orderStatus1 = $orderStatus;
        $this->testPrint1 = $testPrint;
        $this->paymentStatus1 = $paymentStatus1;
        $this->inventoryOrgIds = OrdersCommenFacade::getEncoreOrgIds()->toArray();
    }
    public function view(): View
    {


        $dateType = $this->dateType1;
        $startDate1 = $this->startDate1;
        $endDate1 = $this->endDate1;
        $filterFactory = $this->factory1;
        $orderStatus = $this->orderStatus1;
        $testPrint = $this->testPrint1;
        $paymentStatus1 = $this->paymentStatus1;

        $startDate = Carbon::createFromFormat('Y-m-d', $startDate1)->format('m/d/Y');
        $endDate = Carbon::createFromFormat('Y-m-d', $endDate1)->format('m/d/Y');

        if($startDate1 == $endDate1){
            $this->userGroupFactories();
            $oderSearch = $this->oderSearch;
            $factoryIds = $this->factoryIds;

            $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');

            $factoriesQuery = Factory::select('id', 'factory_code');

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

            foreach ($orders as $order) {
                $factoryNames = $order->orderItems->pluck('factoryDetails.factory_code')->unique()->implode(', ');
                $order->factory_code = $factoryNames;
            }

            foreach ($orders as $order) {
                $testPrintNeeded = $order->orderItems->where('test_print_needed', 1)->count() > 0 ? 'Yes' : 'No';
                $order->test_print_needed = $testPrintNeeded;

                $orderItemCount = $order->orderItems->count();
                $order->order_item_count = $orderItemCount;
            }
            return view('pages.reports.order_summary.export_csv', [
                    'firstTenItems' => $orders
            ]);
        } else {
            $this->userGroupFactories();
            $oderSearch = $this->oderSearch;
            $factoryIds = $this->factoryIds;

            $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');

            $factoriesQuery = Factory::select('id', 'factory_code');

            // factory filter

                    if ($filterFactory != 'all') {
                        $orderQuery->whereHas('orderItems.factoryDetails', function($query) use($filterFactory) {
                            $query->where('id', $filterFactory);
                        });
                    }


            // status filter

                if ($orderStatus != 'all') {
                    $orderQuery->where('order_status_id', $orderStatus);
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


            if ($dateType == 'created_at') {
                $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->whereBetween('created_at', [$startDate1, $endDate1])->orderBy('id', 'DESC')->get();
            } else if ($dateType == 'due_date'){
                $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->whereBetween('due_date', [$startDate, $endDate])->orderBy('id', 'DESC')->get();
            } else if ($dateType == 'ex_factory'){
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

            foreach ($orders as $order) {
                $factoryNames = $order->orderItems->pluck('factoryDetails.factory_code')->unique()->implode(', ');
                $order->factory_code = $factoryNames;
            }

            foreach ($orders as $order) {
                $testPrintNeeded = $order->orderItems->where('test_print_needed', 1)->count() > 0 ? 'Yes' : 'No';
                $order->test_print_needed = $testPrintNeeded;

                $orderItemCount = $order->orderItems->count();
                $order->order_item_count = $orderItemCount;
            }

            return view('pages.reports.order_summary.export_csv', [
                'firstTenItems' => $orders
        ]);

        }

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

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 30,
            'C' => 20,
            'D' => 30,
            'E' => 30,
            'F' => 30,
            'G' => 35,
            'H' => 30,
            'I' => 30,
            'J' => 20,
            'K' => 20,
            'L' => 20,
        ];
    }

}
