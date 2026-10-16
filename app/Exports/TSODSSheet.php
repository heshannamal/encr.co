<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\OrderItem;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TSODSSheet implements WithTitle, WithColumnWidths, WithStyles, FromView
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
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
        $order = Order::query()->where('id', $this->id);

        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $id = $this->id;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'statusDetails', 'contactDetails');


        $orderItemQuery = OrderItem::with('productDetails', 'factoryDetails', 'exFactoryDetails', 'fabricDetails', 'secFabricDetails',
                                    'embellishmentDetails', 'orderItemDetails.sizeDetails');

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

        $order = $orderQuery->where('id', $id)->first();

        return view('pages.order_management.exports.ts_ods', ['order'=>$order]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A1:D2' => [
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ]
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 25,
            'C' => 20,
            'D' => 15,
        ];
    }

    public function title(): string
    {
        return 'ODS';
    }
}
