@extends('pages.customer_portal.layouts.app')

@section('content')
<style>
.btn-white-text {
    outline: unset !important;
    width: 100px;
    height: 40px;
    padding: 6%;
    color: #ffffff;
    border: none;
    font-weight: 700;
    font-size: .7rem;
    cursor: pointer;
    background-color: transparent;
    border: 1px solid #ffffff;
}
.btn-gray-text {
    outline: unset !important;
    width: 100px;
    height: 40px;
    color: rgb(110, 110, 110);
    border:rgb(110, 110, 110);
    font-weight: 700;
    font-size: .7rem;
    cursor: pointer;
    background-color: transparent;
    border: 1px solid rgb(110, 110, 110);
}
.btns-style {
    width: 81px;
    height: 30px;
    background-color: #909090;
    border: unset;
    border-radius: 5px;
}
</style>


<div class="row" style="margin: 0rem;">
    <div class="col-md-12 sub-navbar-content" style="background-color: black;">
        <div class="row">
            <div class="col-md-12" style="height: 5rem;">
                <table style="width:100%; height: 100%;">
                    <tbody>
                        <td style="color: white; font-weight: 600; font-size: 1.5rem; text-align: center;">
                            Order #001226 - Shipment Summary
                        </td>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin: 0rem;">
    @php
        $orderItems = $shippingDetails{'orderItems'};
        $sub_products = $shippingDetails{'sub_products'};
    @endphp

    <div class="col-md-12 mt-2 " id="Shipiment_summery_body">

        @if ($orderItems)
        <div class="row mt-2 mb-3" style="width:100%;justify-content: flex-end;"></div>
            @foreach ($orderItems as $orderItem)
                <div class="row" style="margin: .4%;">
                    <i class="fa fa-ship" aria-hidden="true" style="background-color: lightseagreen; border-radius: 50%; padding: 1%; color: white;"></i>
                    <span style="color: black; font-size: 20px; font-weight: 600;">&nbsp;Shipment {{$loop->index +1}}</span>
                </div>
                <div class="row mt-4" style="margin: .4%;">
                    <table>
                        <tbody>
                            <tr style="height: 35px;">
                                <td style="color: grey; font-size: 15px;">Tracking ID</td>
                                <td style="color: black; font-size: 15px;">{{$orderItem->tracking_no}}</td>
                            </tr>
                            <tr style="height: 35px;">
                                <td style="color: grey; font-size: 15px;"> Tracking Link</td>
                                <td><a href="{{$orderItem->tracking_link}}" style="font-size: 15px; color: lightseagreen !important; cursor: pointer;" target="_blank">CLICK HERE</a></td>
                            </tr>
                            <tr style="height: 35px;"><td style="color: grey; font-size: 15px;">EST. Shipping Date&nbsp;&nbsp;</td>
                                <td style="color: black; font-size: 15px;">{{$orderItem->display_est_delivery_date}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row" style="margin: .4%;">
                    <span style="margin-top: 3%;color: black;font-size: 15px;font-weight: 700;">ITEM LIST</span>
                </div>
                @if ($orderItem->products)

                @php
                    $products = $orderItem->products;
                    $totalCountTotal = 0;
                    $totalCountShipped = 0;
                @endphp
                    <div class="row" style="margin: .4%;">
                        <table style="width: 100%;margin-top: 2%;">
                            <thead class="table-bordered" style="background-color: grey; color: white; font-size: 14px; height: 45px;">
                                <tr>
                                    <th>&nbsp;&nbsp;ITEM</th>
                                    <th>&nbsp;&nbsp;SIZE</th>
                                    <th class="text-right">ORDERED QTY&nbsp;&nbsp;</th>
                                    <th class="text-right">SHIPPED QTY&nbsp;&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $productNameReminder = null;
                                @endphp
                                @foreach ($products as $product)
                                @php
                                    $fullOrderQty = 0;
                                    if ($product->orderItemDetailQtys) {
                                        if ($product->orderItemDetailQtys->blanks) {
                                            $fullOrderQty += $product->orderItemDetailQtys->blanks;
                                        }
                                        if ($product->orderItemDetailQtys->qty) {
                                            $fullOrderQty += $product->orderItemDetailQtys->qty;
                                        }
                                    }
                                    $totalCountTotal += $fullOrderQty;
                                    $totalCountShipped += $product->shipped_qty;
                                @endphp
                                @if($productNameReminder !== $product->orderitems->productDetails->product_name)
                                    @php
                                        $foundSubProduct = $sub_products->first(function ($subProduct) use ($product) {
                                            return $subProduct->sub_product_no == $product->orderItems->sub_product_no;
                                        });

                                        $name_for_display = $product->orderItems->display_name ? $product->orderItems->display_name : $foundSubProduct->product_name;
                                    @endphp
                                    <tr style="height: 45px; background-color: #c7c7c7; color: black; font-size: 14px; border-bottom: 1px solid #e4e4e4;">
                                        <td>&nbsp;&nbsp;{{$name_for_display}} </td>
                                        <td class="text-center">{{$product->size_name}} </td>
                                        <td class="text-right"> {{$fullOrderQty}} &nbsp;&nbsp;</td>
                                        <td class="text-right"> {{$product->shipped_qty}} &nbsp;&nbsp;</td>
                                    </tr>
                                    @php
                                         $productNameReminder = $product->orderitems->productDetails->product_name;
                                    @endphp
                                @else
                                    <tr style="color: black; font-size: 14px; height: 45px; background-color: #fcfcfc; border-bottom: 1px solid #e4e4e4;">
                                        <td>&nbsp;</td>
                                        <td class="text-center">{{$product->size_name}} </td>
                                        <td class="text-right"> {{$fullOrderQty}} &nbsp;&nbsp;</td>
                                        <td class="text-right"> {{$product->shipped_qty}} &nbsp;&nbsp;</td>
                                    </tr>
                                @endif


                                @endforeach
                                <tr style="height: 45px; color: black; font-size: 14px; font-weight: 700; background-color: #e2e2e2;">
                                    <td class="text-right">TOTAL</td>
                                    <td></td>
                                    <td class="text-right"> {{$totalCountTotal}} &nbsp;&nbsp;</td>
                                    <td class="text-right"> {{$totalCountShipped}} &nbsp;&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
                <div class="row mt-5 mb-3" style="width:100%; border-bottom:1px solid #dbdbdb"></div>
            @endforeach
        @else
        <div class="row mt-5 mb-3" style="width:100%; border-bottom:1px solid #dbdbdb"></div>
        <p class="text-center" style="font-size: 20px;color:#b2b2b2;">No any shipment summery updates yet!</p>
        <div class="row mt-5 mb-3" style="width:100%; border-bottom:1px solid #dbdbdb"></div>
        @endif

    </div>
</div>



@endsection
