<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use App\Models\OrderSheduleColor;
use App\Models\OrderSheduleComment;
use App\Models\Factory;

class ReportOrderSheduleExport implements FromView, WithColumnWidths
{
    use Exportable;

    protected $selectedYear1;
    protected $selectedMonth1;

    public function __construct($selectedYear, $selectedMonth)
    {
        $this->selectedYear1 = $selectedYear;
        $this->selectedMonth1 = $selectedMonth;
    }
    public function view(): View
    {
        $selectedYear = $this->selectedYear1;
        $selectedMonth = $this->selectedMonth1;


        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');

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


            $orderQuery->whereRaw('MONTH(STR_TO_DATE(ex_factory_date, "%m/%d/%Y")) = ?', [$selectedMonth])
                       ->whereRaw('YEAR(STR_TO_DATE(ex_factory_date, "%m/%d/%Y")) = ?', [$selectedYear]);

        $orderQuery->addSelect(['shedule_color' => OrderSheduleColor::select('color_code')->whereColumn('order_id', 'orders.id')->limit(1)]);

        $orderQuery->addSelect(['shedule_comment' => OrderSheduleComment::select('special_comment')->whereColumn('order_id', 'orders.id')->limit(1)]);

        $orders = $orderQuery->where('active', 1)->orderBy('ex_factory_date', 'ASC')->get();

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

        return view('pages.reports.order_shedule.export_csv', [ 'orders'=>$orders]);

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
            'C' => 40,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 20,
            'I' => 20,
            'J' => 20,
            'K' => 20,
            'L' => 50,
        ];
    }

}
