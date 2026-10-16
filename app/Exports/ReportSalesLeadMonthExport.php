<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ReportSalesLeadMonthExport implements FromView, WithColumnWidths
{
    use Exportable;

    protected $year;
    protected $category;
    protected $month;

    public function __construct($selectedYear, $selectedCategory, $selectedMonth)
    {
        $this->year = $selectedYear;
        $this->category = $selectedCategory;
        $this->month = $selectedMonth;
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

    public function view(): View
    {
        $selectedYear = $this->year;
        $selectedCategory = $this->category;
        $selectedMonth = $this->month;

        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')
            ->where('active', 1);

        if ($oderSearch == 'factory') {
            $orderQuery->with(['orderItems' => function ($qry) use ($factoryIds) {
                $qry->with('factoryDetails')
                    ->whereIn('factory_id', $factoryIds)
                    ->where('order_status_id', 3);
            }]);
            $orderQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
                $qr->whereIn('factory_id', $factoryIds)
                    ->where('order_status_id', 3);
            });
        } else {
            $orderQuery->with('orderItems.factoryDetails');
        }

        $orders = $orderQuery->where('active', 1)->get();

        // Calculate the number of order items in each order
        $ordersWithItemsCount = $orders->map(function ($order) {
            $order->order_items_count = $order->orderItems->count();
            return $order;
        });

        $viewOrders = $ordersWithItemsCount->filter(function ($order) use ($selectedYear, $selectedCategory, $selectedMonth) {
            return $order->created_at->year == $selectedYear  && $order->created_at->month == $selectedMonth && $order->organizationDetails->lead_source == $selectedCategory;
        });

        return view('pages.reports.sales_lead.export_csv1', [
            'viewOrders' => $viewOrders, 'selectedCategory' => $selectedCategory, 'selectedYear' => $selectedYear
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,
            'C' => 20,
            'D' => 60,
            'E' => 15,
            'F' => 15,
        ];
    }

}
