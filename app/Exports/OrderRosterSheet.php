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
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class OrderRosterSheet implements WithTitle, WithColumnWidths, WithStyles, FromView
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
        $itemWithData = 0;
        $totalQty = 0;
        foreach ($order->orderItems as $orderItem) {
            $csvData = [];

            foreach ($orderItem->orderItemDetails as $orderItemDetail) {
                $itemQty = $orderItemDetail->qty + $orderItemDetail->blanks;

                if (in_array($orderItemDetail->size_id, array(17, 20, 23))) {
                    $sizeName = $orderItem->extra_size ?? '';
                } else if (in_array($orderItemDetail->size_id, array(18, 21, 24))) {
                    $sizeName = $orderItem->extra_size_two ?? '';
                } else if (in_array($orderItemDetail->size_id, array(19, 22, 25))) {
                    $sizeName = $orderItem->extra_size_three ?? '';
                } else {
                    $sizeName = $orderItemDetail->sizeDetails->size_name ?? '';
                }

                if ($itemQty != '' && $itemQty > 0) {
                    $order_item = OrderItem::find($orderItemDetail->order_item_id);
                    // one - ten
                    if ($orderItemDetail->numseq_one != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_one ?? 'N',
                            $orderItemDetail->playerDetails->player_one ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_two != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_two ?? 'N',
                            $orderItemDetail->playerDetails->player_two ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_three != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_three ?? 'N',
                            $orderItemDetail->playerDetails->player_three ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_four != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_four ?? 'N',
                            $orderItemDetail->playerDetails->player_four ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_five != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_five ?? 'N',
                            $orderItemDetail->playerDetails->player_five ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_six != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_six ?? 'N',
                            $orderItemDetail->playerDetails->player_six ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_seven != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_seven ?? 'N',
                            $orderItemDetail->playerDetails->player_seven ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_eight != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_eight ?? 'N',
                            $orderItemDetail->playerDetails->player_eight ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_nine != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_nine ?? 'N',
                            $orderItemDetail->playerDetails->player_nine ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_ten != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_ten ?? 'N',
                            $orderItemDetail->playerDetails->player_ten ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }
                    // eleven - twenty
                    if ($orderItemDetail->numseq_eleven != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_eleven ?? 'N',
                            $orderItemDetail->playerDetails->player_eleven ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_twelve != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_twelve ?? 'N',
                            $orderItemDetail->playerDetails->player_twelve ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_thirteen != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_thirteen ?? 'N',
                            $orderItemDetail->playerDetails->player_thirteen ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_fourteen != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_fourteen ?? 'N',
                            $orderItemDetail->playerDetails->player_fourteen ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_fifteen != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_fifteen ?? 'N',
                            $orderItemDetail->playerDetails->player_fifteen ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_sixteen != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_sixteen ?? 'N',
                            $orderItemDetail->playerDetails->player_sixteen ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_seventeen != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_seventeen ?? 'N',
                            $orderItemDetail->playerDetails->player_seventeen ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_eighteen != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_eighteen ?? 'N',
                            $orderItemDetail->playerDetails->player_eighteen ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_nineteen != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_nineteen ?? 'N',
                            $orderItemDetail->playerDetails->player_nineteen ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_twenty != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_twenty ?? 'N',
                            $orderItemDetail->playerDetails->player_twenty ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }
                    // twenty_one - thirty
                    if ($orderItemDetail->numseq_twenty_one != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_twenty_one ?? 'N',
                            $orderItemDetail->playerDetails->player_twenty_one ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_twenty_two != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_twenty_two ?? 'N',
                            $orderItemDetail->playerDetails->player_twenty_two ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_twenty_three != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_twenty_three ?? 'N',
                            $orderItemDetail->playerDetails->player_twenty_three ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_twenty_four != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_twenty_four ?? 'N',
                            $orderItemDetail->playerDetails->player_twenty_four ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_twenty_five != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_twenty_five ?? 'N',
                            $orderItemDetail->playerDetails->player_twenty_five ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_twenty_six != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_twenty_six ?? 'N',
                            $orderItemDetail->playerDetails->player_twenty_six ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_twenty_seven != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_twenty_seven ?? 'N',
                            $orderItemDetail->playerDetails->player_twenty_seven ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_twenty_eight != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_twenty_eight ?? 'N',
                            $orderItemDetail->playerDetails->player_twenty_eight ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_twenty_nine != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_twenty_nine ?? 'N',
                            $orderItemDetail->playerDetails->player_twenty_nine ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_thirty != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_thirty ?? 'N',
                            $orderItemDetail->playerDetails->player_thirty ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }
                    // thirty_one - forty
                    if ($orderItemDetail->numseq_thirty_one != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_thirty_one ?? 'N',
                            $orderItemDetail->playerDetails->player_thirty_one ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_thirty_two != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_thirty_two ?? 'N',
                            $orderItemDetail->playerDetails->player_thirty_two ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_thirty_three != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_thirty_three ?? 'N',
                            $orderItemDetail->playerDetails->player_thirty_three ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_thirty_four != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_thirty_four ?? 'N',
                            $orderItemDetail->playerDetails->player_thirty_four ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_thirty_five != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_thirty_five ?? 'N',
                            $orderItemDetail->playerDetails->player_thirty_five ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_thirty_six != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_thirty_six ?? 'N',
                            $orderItemDetail->playerDetails->player_thirty_six ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_thirty_seven != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_thirty_seven ?? 'N',
                            $orderItemDetail->playerDetails->player_thirty_seven ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_thirty_eight != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_thirty_eight ?? 'N',
                            $orderItemDetail->playerDetails->player_thirty_eight ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_thirty_nine != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_thirty_nine ?? 'N',
                            $orderItemDetail->playerDetails->player_thirty_nine ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_forty != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_forty ?? 'N',
                            $orderItemDetail->playerDetails->player_forty ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }
                    // forty_one - fifty
                    if ($orderItemDetail->numseq_forty_one != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_forty_one ?? 'N',
                            $orderItemDetail->playerDetails->player_forty_one ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_forty_two != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_forty_two ?? 'N',
                            $orderItemDetail->playerDetails->player_forty_two ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_forty_three != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_forty_three ?? 'N',
                            $orderItemDetail->playerDetails->player_forty_three ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_forty_four != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_forty_four ?? 'N',
                            $orderItemDetail->playerDetails->player_forty_four ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_forty_five != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_forty_five ?? 'N',
                            $orderItemDetail->playerDetails->player_forty_five ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_forty_six != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_forty_six ?? 'N',
                            $orderItemDetail->playerDetails->player_forty_six ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_forty_seven != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_forty_seven ?? 'N',
                            $orderItemDetail->playerDetails->player_forty_seven ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_forty_eight != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_forty_eight ?? 'N',
                            $orderItemDetail->playerDetails->player_forty_eight ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_forty_nine != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_forty_nine ?? 'N',
                            $orderItemDetail->playerDetails->player_forty_nine ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_fifty != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_fifty ?? 'N',
                            $orderItemDetail->playerDetails->player_fifty ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }
                    // fifty_one - sixty
                    if ($orderItemDetail->numseq_fifty_one != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_fifty_one ?? 'N',
                            $orderItemDetail->playerDetails->player_fifty_one ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_fifty_two != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_fifty_two ?? 'N',
                            $orderItemDetail->playerDetails->player_fifty_two ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_fifty_three != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_fifty_three ?? 'N',
                            $orderItemDetail->playerDetails->player_fifty_three ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_fifty_four != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_fifty_four ?? 'N',
                            $orderItemDetail->playerDetails->player_fifty_four ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_fifty_five != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_fifty_five ?? 'N',
                            $orderItemDetail->playerDetails->player_fifty_five ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_fifty_six != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_fifty_six ?? 'N',
                            $orderItemDetail->playerDetails->player_fifty_six ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_fifty_seven != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_fifty_seven ?? 'N',
                            $orderItemDetail->playerDetails->player_fifty_seven ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_fifty_eight != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_fifty_eight ?? 'N',
                            $orderItemDetail->playerDetails->player_fifty_eight ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_fifty_nine != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_fifty_nine ?? 'N',
                            $orderItemDetail->playerDetails->player_fifty_nine ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_sixty != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_sixty ?? 'N',
                            $orderItemDetail->playerDetails->player_sixty ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }
                    // sixty_one - seventy
                    if ($orderItemDetail->numseq_sixty_one != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_sixty_one ?? 'N',
                            $orderItemDetail->playerDetails->player_sixty_one ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_sixty_two != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_sixty_two ?? 'N',
                            $orderItemDetail->playerDetails->player_sixty_two ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_sixty_three != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_sixty_three ?? 'N',
                            $orderItemDetail->playerDetails->player_sixty_three ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_sixty_four != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_sixty_four ?? 'N',
                            $orderItemDetail->playerDetails->player_sixty_four ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_sixty_five != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_sixty_five ?? 'N',
                            $orderItemDetail->playerDetails->player_sixty_five ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_sixty_six != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_sixty_six ?? 'N',
                            $orderItemDetail->playerDetails->player_sixty_six ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_sixty_seven != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_sixty_seven ?? 'N',
                            $orderItemDetail->playerDetails->player_sixty_seven ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_sixty_eight != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_sixty_eight ?? 'N',
                            $orderItemDetail->playerDetails->player_sixty_eight ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_sixty_nine != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_sixty_nine ?? 'N',
                            $orderItemDetail->playerDetails->player_sixty_nine ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_seventy != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_seventy ?? 'N',
                            $orderItemDetail->playerDetails->player_seventy ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }
                    // seventy_one - eighty
                    if ($orderItemDetail->numseq_seventy_one != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_seventy_one ?? 'N',
                            $orderItemDetail->playerDetails->player_seventy_one ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_seventy_two != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_seventy_two ?? 'N',
                            $orderItemDetail->playerDetails->player_seventy_two ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_seventy_three != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_seventy_three ?? 'N',
                            $orderItemDetail->playerDetails->player_seventy_three ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_seventy_four != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_seventy_four ?? 'N',
                            $orderItemDetail->playerDetails->player_seventy_four ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_seventy_five != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_seventy_five ?? 'N',
                            $orderItemDetail->playerDetails->player_seventy_five ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_seventy_six != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_seventy_six ?? 'N',
                            $orderItemDetail->playerDetails->player_seventy_six ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_seventy_seven != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_seventy_seven ?? 'N',
                            $orderItemDetail->playerDetails->player_seventy_seven ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_seventy_eight != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_seventy_eight ?? 'N',
                            $orderItemDetail->playerDetails->player_seventy_eight ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_seventy_nine != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_seventy_nine ?? 'N',
                            $orderItemDetail->playerDetails->player_seventy_nine ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_eighty != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_eighty ?? 'N',
                            $orderItemDetail->playerDetails->player_eighty ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }
                    // eighty_one - ninety
                    if ($orderItemDetail->numseq_eighty_one != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_eighty_one ?? 'N',
                            $orderItemDetail->playerDetails->player_eighty_one ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_eighty_two != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_eighty_two ?? 'N',
                            $orderItemDetail->playerDetails->player_eighty_two ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_eighty_three != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_eighty_three ?? 'N',
                            $orderItemDetail->playerDetails->player_eighty_three ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_eighty_four != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_eighty_four ?? 'N',
                            $orderItemDetail->playerDetails->player_eighty_four ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_eighty_five != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_eighty_five ?? 'N',
                            $orderItemDetail->playerDetails->player_eighty_five ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_eighty_six != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_eighty_six ?? 'N',
                            $orderItemDetail->playerDetails->player_eighty_six ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_eighty_seven != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_eighty_seven ?? 'N',
                            $orderItemDetail->playerDetails->player_eighty_seven ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_eighty_eight != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_eighty_eight ?? 'N',
                            $orderItemDetail->playerDetails->player_eighty_eight ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_eighty_nine != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_eighty_nine ?? 'N',
                            $orderItemDetail->playerDetails->player_eighty_nine ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_ninety != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_ninety ?? 'N',
                            $orderItemDetail->playerDetails->player_ninety ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }
                    // ninety_one - hundred
                    if ($orderItemDetail->numseq_ninety_one != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_ninety_one ?? 'N',
                            $orderItemDetail->playerDetails->player_ninety_one ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_ninety_two != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_ninety_two ?? 'N',
                            $orderItemDetail->playerDetails->player_ninety_two ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_ninety_three != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_ninety_three ?? 'N',
                            $orderItemDetail->playerDetails->player_ninety_three ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_ninety_four != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_ninety_four ?? 'N',
                            $orderItemDetail->playerDetails->player_ninety_four ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_ninety_five != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_ninety_five ?? 'N',
                            $orderItemDetail->playerDetails->player_ninety_five ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_ninety_six != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_ninety_six ?? 'N',
                            $orderItemDetail->playerDetails->player_ninety_six ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_ninety_seven != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_ninety_seven ?? 'N',
                            $orderItemDetail->playerDetails->player_ninety_seven ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_ninety_eight != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_ninety_eight ?? 'N',
                            $orderItemDetail->playerDetails->player_ninety_eight ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_ninety_nine != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_ninety_nine ?? 'N',
                            $orderItemDetail->playerDetails->player_ninety_nine ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_one != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_one ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_one ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_two != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_two ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_two ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_three != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_three ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_three ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_four != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_four ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_four ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_five != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_five ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_five ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_six != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_six ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_six ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_seven != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_seven ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_seven ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_eight != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_eight ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_eight ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_nine != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_nine ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_nine ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_ten != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_ten ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_ten ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }
                    // eleven - twenty
                    if ($orderItemDetail->numseq_hundred_eleven != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_eleven ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_eleven ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_twelve != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_twelve ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_twelve ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_thirteen != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_thirteen ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_thirteen ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_fourteen != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_fourteen ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_fourteen ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_fifteen != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_fifteen ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_fifteen ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_sixteen != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_sixteen ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_sixteen ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_seventeen != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_seventeen ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_seventeen ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_eighteen != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_eighteen ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_eighteen ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_nineteen != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_nineteen ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_nineteen ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_twenty != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_twenty ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_twenty ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }
                    // twenty_one - thirty
                    if ($orderItemDetail->numseq_hundred_twenty_one != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_twenty_one ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_twenty_one ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_twenty_two != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_twenty_two ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_twenty_two ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_twenty_three != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_twenty_three ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_twenty_three ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_twenty_four != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_twenty_four ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_twenty_four ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_twenty_five != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_twenty_five ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_twenty_five ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_twenty_six != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_twenty_six ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_twenty_six ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_twenty_seven != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_twenty_seven ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_twenty_seven ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_twenty_eight != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_twenty_eight ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_twenty_eight ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_twenty_nine != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_twenty_nine ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_twenty_nine ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_thirty != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_thirty ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_thirty ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }
                    // thirty_one - forty
                    if ($orderItemDetail->numseq_hundred_thirty_one != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_thirty_one ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_thirty_one ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_thirty_two != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_thirty_two ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_thirty_two ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_thirty_three != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_thirty_three ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_thirty_three ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_thirty_four != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_thirty_four ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_thirty_four ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_thirty_five != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_thirty_five ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_thirty_five ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_thirty_six != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_thirty_six ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_thirty_six ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_thirty_seven != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_thirty_seven ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_thirty_seven ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_thirty_eight != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_thirty_eight ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_thirty_eight ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_thirty_nine != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_thirty_nine ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_thirty_nine ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_forty != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_forty ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_forty ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }
                    // forty_one - fifty
                    if ($orderItemDetail->numseq_hundred_forty_one != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_forty_one ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_forty_one ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_forty_two != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_forty_two ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_forty_two ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_forty_three != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_forty_three ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_forty_three ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_forty_four != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_forty_four ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_forty_four ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_forty_five != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_forty_five ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_forty_five ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_forty_six != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_forty_six ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_forty_six ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_forty_seven != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_forty_seven ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_forty_seven ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_forty_eight != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_forty_eight ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_forty_eight ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_forty_nine != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_forty_nine ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_forty_nine ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->numseq_hundred_fifty != "") {
                        $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                        $row = [
                            $orderItem->productDetails->product_name ?? '',
                            $orderItemDetail->numseq_hundred_fifty ?? 'N',
                            $orderItemDetail->playerDetails->player_hundred_fifty ?? 'N',
                            1,
                            $sizeName,
                            $subProduct ? $subProduct->product_name : ''
                        ];
                        array_push($csvData, $row);
                    }

                    if ($orderItemDetail->blanks > 0) {
                        $blanks = $orderItemDetail->blanks;
                        for ($i = 0; $i < $blanks; $i++) {
                            if (isset($orderItemDetail->playerDetails) && $orderItemDetail->playerDetails->blank_player_names != "") {
                                $nameCount = count(json_decode($orderItemDetail->playerDetails->blank_player_names));

                                if ($i > ($nameCount - 1)) {
                                    $blankPlayer = 'N';
                                } else {
                                    $blankPlayer = json_decode($orderItemDetail->playerDetails->blank_player_names)[$i];
                                }

                                $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                                $row = [
                                    $orderItem->productDetails->product_name ?? '',
                                    'N',
                                    $blankPlayer ?? 'N',
                                    1,
                                    $sizeName,
                                    $subProduct ? $subProduct->product_name : ''
                                ];
                                array_push($csvData, $row);

                            } else {
                                $subProduct = SubProduct::where('sub_product_no', $order_item->sub_product_no)->first();
                                $row = [
                                    $orderItem->productDetails->product_name ?? '',
                                    'N',
                                    'N',
                                    1,
                                    $sizeName,
                                    $subProduct ? $subProduct->product_name : ''
                                ];
                                array_push($csvData, $row);
                            }
                        }

                    }
                }
            }

            $totalQty += $orderItem->qty;

            array_push($itemData, $csvData);

            if (count($csvData) > 0) {
                $itemWithData += 1;
            }
        }

        return view('pages.order_management.exports.bulk_order_roster', ['order'=>$order, 'itemData'=>$itemData, 'itemWithData'=>$itemWithData, 'totalQty'=>$totalQty]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'F' => [
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
            'A' => 30,
            'B' => 15,
            'C' => 20,
            'D' => 10,
            'E' => 20,
            'F' => 20,
        ];
    }

    public function title(): string
    {
        return 'Order Roster';
    }
}
