<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SubProduct;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductReportSheet implements WithTitle, WithColumnWidths, FromView
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

        $itemData = [];
        $totalQty = 0;
        $itemWithData = 0;
        foreach ($order->orderItems as $key => $orderItem) {
            $productData = [];
            foreach ($orderItem->orderItemDetails as $orderItemDetail) {
                $itemQty = $orderItemDetail->qty + $orderItemDetail->blanks;

                if ($itemQty != '' && $itemQty > 0) {
                    $sub_product_found = SubProduct::where('sub_product_no', $orderItem->sub_product_no)->first();
                    $row1 = [
                        $sub_product_found->sub_product_no ?? '',
                        $sub_product_found->product_name ?? '',
                        $orderItem->fabricDetails->fabric_name ?? '',
                        $orderItem->embellishmentDetails->embellishment_name ?? '',
                        $itemQty ?? '',
                        $orderItemDetail->sizeDetails->size_name ?? '',
                        $orderItem->factoryDetails->factory_code ?? ''
                    ];

                    array_push($productData, $row1);
                }
            }

            $totalQty += $orderItem->qty;
            array_push($itemData, $productData);

            if (count($productData) > 0) {
                $itemWithData += 1;
            }
        }

        return view('pages.order_management.exports.ts_product_report', ['itemData'=>$itemData, 'totalQty'=>$totalQty, 'itemWithData'=>$itemWithData]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 30,
            'C' => 18,
            'D' => 18,
            'E' => 10,
            'F' => 20,
            'G' => 10,
        ];
    }

    public function title(): string
    {
        return 'Product Report';
    }
}
