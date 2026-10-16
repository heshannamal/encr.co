@extends('layouts.app', ['activePage' => 'order', 'titlePage' => __('Pdf')])

@section('content')
    <style>
        .table thead th {
            text-transform: capitalize !important;
            font-size: .8125rem
        }

        .num-seq {
            display: flex;
            height: 30px;
        }

        .num-seq h5 {
            border: 1px solid #d2d2d2;
            padding: 5px;
            margin-bottom: 0rem;
            width: 23px;
            text-align: center;
        }

        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
        }
    </style>

    <div class="se-pre-con"></div>

    <div class="container-fluid" id="pdf_print">
        @foreach ($orders as $order)
            <input type="hidden" id="pdf_id" value="{{ $order->id }}" />

            {{-- <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <img src="{{ asset('argon') }}/img/encore/logo1.png" height="150px">
                    </div>

                    <div class="col-lg-6">
                        <h3 class="page-title text-danger text-right"></h3>
                    </div>

                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th>Organization :</th>
                                <td><h5>{{$order->organizationDetails['organization_name']}}</h5></td>
                            </tr>
                            <tr>
                                <th>Order # :</th>
                                <td><h5>{{$order->order_no}}</h5></td>
                            </tr>
                            <tr>
                                <th>Status :</th>
                                <td><h5>{{$order->statusDetails['status_name']}}</h5></td>
                            </tr>
                            <tr>
                                <th>Sales Rep :</th>
                                <td><h5>{{$order->userDetails['name']}}</h5></td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>

            <hr class="page-divider"> --}}

            {{-- Address Details --}}
            {{-- <div class="col-lg-12 mb-1">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th>Shipping Address:</th>
                            </tr>
                            <tr><td><h5>{{$order->contactDetails['first_name']}} {{$order->contactDetails['last_name']}}</h5></td></tr>
                            <tr><td><h5>{{$order->street}}</h5></td></tr>
                            <tr><td><h5>{{$order->city}} {{$order->state}} {{$order->postal_code}}</h5></td></tr>
                            <tr><td><h5>{{$order->country}}</h5></td></tr>
                            <tr><td><h5>{{$order->phone_no}}</h5></td></tr>
                            <tr><td><h5>{{$order->email}}</h5></td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th>Billing Address:</th>
                            </tr>
                            <tr><td><h5>{{$order->contactDetails['first_name']}} {{$order->contactDetails['last_name']}}</h5></td></tr>
                            <tr><td><h5>{{$order->street}}</h5></td></tr>
                            <tr><td><h5>{{$order->city}} {{$order->state}} {{$order->postal_code}}</h5></td></tr>
                            <tr><td><h5>{{$order->country}}</h5></td></tr>
                            <tr><td><h5>{{$order->phone_no}}</h5></td></tr>
                            <tr><td><h5>{{$order->email}}</h5></td></tr>
                        </table>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-md-12">
                        <table class="table" id="pdf_items">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50%;">ITEM</th>
                                    <th class="text-center">STATUS</th>
                                    <th class="text-center">EST DELIVERY</th>
                                    <th class="text-center">QTY</th>
                                    <th class="text-right">UNIT PRICE($)</th>
                                    <th class="text-right">TOTAL($)</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($order->orderItems as $orderItem)
                                <tr>
                                    <td><h5>{{$orderItem->productDetails['product_name']}}</h5></td>
                                    <td><h5 class="text-center">{{$orderItem->statusDetails['status_name']}}</h5></td>
                                    <td><h5 class="text-center">{{$orderItem->est_delivery_date}}</h5></td>
                                    <td><h5 class="text-center">{{$orderItem->qty}}</h5></td>
                                    <td><h5 class="text-right">{{number_format($orderItem->unit_price, 2)}}</h5></td>
                                    <td><h5 class="text-right">{{number_format($orderItem->total, 2)}}</h5></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 mb-5">
                <div class="row">
                    <div class="col-lg-7">
                        <h1 class="main-htag">Thank you for your business!</h1>
                        <div class="mt-4">
                            <h4>Payment can be submitted via PayPal, Venmo, Debit/Credit Card or Check. If submitting via PayPal or
                                Venmo, please include the invoice #, as well as your team and contact information.</h4>
                        </div>
                        <div class="mt-4">
                            <table>
                                <tr>
                                    <td><h4 class="text-small">PayPal :</h4></td>
                                    <td><h4 class="text-small"><span class="text-muted">info@encorelacrosse.com</span></h4></td>
                                </tr>
                                <tr>
                                    <td><h4 class="text-small">Venmo :</h4></td>
                                    <td><h4 class="text-small"><span class="text-muted">@encore-lacrosse</span></h4></td>
                                </tr>
                                <tr>
                                    <td><h4 class="text-small">Credit Card/Check :</h4></td>
                                    <td><h4 class="text-small"><span class="text-muted">Please make payment through sales rep or accounting dept.</span></h4></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <table class="table" id="pdf_summery">
                            <tr>
                                <th class="text-left">SUBTOTAL ($) :</th>
                                <td><h5 class="text-right">{{number_format($order->sub_total, 2)}}</h5></td>
                            </tr>
                            <tr>
                                <th class="text-left">SALES TAX ($) {{$order->organizationDetails['sales_tax']}}% RATE :</th>
                                <td><h5 class="text-right">{{number_format($order->sales_tax, 2)}}</h5></td>
                            </tr>
                            <tr>
                                <th class="text-left">SHIPPING ($) :</th>
                                <td><h5 class="text-right">{{number_format($order->shipping, 2)}}</h5></td>
                            </tr>
                            <tr>
                                <th class="text-left">ARTWORK ($) :</th>
                                <td><h5 class="text-right">{{number_format($order->artwork, 2)}}</h5></td>
                            </tr>
                            <tr>
                                <th class="text-left">PROCESSING FEE ($) :</th>
                                <td><h5 class="text-right">{{number_format($order->processing_fee, 2)}}</h5></td>
                            </tr><br>
                            <tr>
                                <th class="total text-left">ORDER TOTAL ($) :</th>
                                <td><h5 class="text-right" style="font-weight: bold; font-size: large;">{{number_format($order->order_total, 2)}}</h5></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div style="page-break-after:always; clear:both"></div> --}}

            {{-- <div class="mt-5"></div> --}}
            {{-- item Details --}}
            @foreach ($order->orderItems as $orderItem)
                <div class="container-fluid itemDetails"
                    style="padding-left: 1px !important; padding-right: 1px !important; padding-top: 50px !important;">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <h2 class="text-danger mt-5">Order Item #: {{ $orderItem->item_no }}</h2>
                            </div>

                            <div class="col-lg-6 text-right" style="display: flex; flex-direction: row; justify-content: flex-end; align-items: center;">
                                <div>
                                    <h5 class="text-right encore-address" style="margin-bottom: 0rem;">Encore Custom</h5>
                                    <h5 class="text-right encore-address" style="margin-bottom: 0rem;">891 4th st.</h5>
                                    <h5 class="text-right encore-address" style="margin-bottom: 0rem;">San Rafael, CA 94901</h5>
                                </div>

                                <div>
                                    <img src="{{ asset('argon') }}/img/encore/logo1.png" height="100px">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <th class="item_th">Style Name:</th>
                                        <td>
                                            <h5>{{ $orderItem->productDetails['product_name'] }}</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="item_th">Item Status:</th>
                                        <td>
                                            <h5>{{ $orderItem->statusDetails['status_name'] }}</h5>
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <th class="item_th">Open Date:</th>
                                        <td>
                                            <h5>{{ $orderItem->open_date }}</h5>
                                        </td>
                                    </tr> --}}
                                    @if ($orderItem->close_date)
                                        <tr>
                                            <th class="item_th">Close Date:</th>
                                            <td>
                                                <h5>{{ $orderItem->close_date }}</h5>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th class="item_th">Ex Factory Date:</th>
                                        <td>
                                            <h5>{{ $orderItem->ex_factory_date }}</h5>
                                        </td>
                                    </tr>
                                    <tr @if($order->order_type == 0 || ($order->order_type == 1 && $order->address_type == 2)) style="display: none" @endif>
                                        <th class="item_th">Encore Packing Date:</th>
                                        <td>
                                            <h5>{{ $orderItem->encore_packing_date }}</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="item_th">Customer In-Hand Date:</th>
                                        <td>
                                            <h5>{{ $orderItem->in_hand_due_date }}</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="item_th">Factory:</th>
                                        <td>
                                            <h5>@if (isset($orderItem->factoryDetails['factory_code'])){{ $orderItem->factoryDetails['factory_code'] }}@endif</h5>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div>

                    <hr class="page-divider">

                    <div class="col-lg-12 mb-1">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <th class="item_th">Primary Fabric:</th>
                                        <td>
                                            <h5>@if (isset($orderItem->fabricDetails['fabric_name'])){{ $orderItem->fabricDetails['fabric_name'] }}@endif</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="item_th">Secondary Fabric:</th>
                                        <td>
                                            <h5>@if (isset($orderItem->secFabricDetails['fabric_name'])){{ $orderItem->secFabricDetails['fabric_name'] }}@endif</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="item_th">Embellishment:</th>
                                        <td>
                                            <h5>@if (isset($orderItem->embellishmentDetails['embellishment_name'])){{ $orderItem->embellishmentDetails['embellishment_name'] }}@endif</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="item_th">Attributes:</th>
                                        <td>
                                            <h5>
                                                @if (isset($orderItem->orderItemAttributes))
                                                    @foreach ($orderItem->orderItemAttributes as $orderItemAttribute)
                                                        {{ $orderItemAttribute->attribute->attribute_name }},
                                                    @endforeach
                                                @endif
                                            </h5>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <th class="item_th">Tracking No:</th>
                                        <td>
                                            <h5>{{ $orderItem->tracking_no ?: '--' }}</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="item_th">Tracking Link:</th>
                                        <td>
                                            <h5>{{ $orderItem->tracking_link ?: '--' }}</h5>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <td>@if ($orderItem->double_sided == 1) <i class="fas fa-check-square"></i> @else <i class="far fa-square"></i> @endif Reversible</td>
                                        <td>@if ($orderItem->individual_no == 1) <i class="fas fa-check-square"></i> @else <i class="far fa-square"></i> @endif Individual Number</td>
                                    </tr>
                                    <tr>
                                        <td>@if ($orderItem->pockets == 1) <i class="fas fa-check-square"></i> @else <i class="far fa-square"></i> @endif Pockets</td>
                                        <td>@if ($orderItem->individual_name == 1) <i class="fas fa-check-square"></i> @else <i class="far fa-square"></i> @endif Individual Name</td>
                                    </tr>
                                    <tr>
                                        <td>@if ($orderItem->zipper_pockets == 1) <i class="fas fa-check-square"></i> @else <i class="far fa-square"></i> @endif Zippered Pockets</td>
                                        <td>@if ($orderItem->dynamic_details == 1) <i class="fas fa-check-square"></i> @else <i class="far fa-square"></i> @endif Dynamic Details</td>
                                    </tr>
                                    <tr>
                                        <td>@if ($orderItem->contrast_stratching == 1) <i class="fas fa-check-square"></i> @else <i class="far fa-square"></i> @endif Contrast Stitching</td>
                                        <td>@if ($orderItem->printing_over_sems == 1) <i class="fas fa-check-square"></i> @else <i class="far fa-square"></i> @endif Printing over Seams</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <hr class="page-divider">

                    <div class="col-lg-12" style="margin-bottom: 20px !important">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <th>Blank<br>Qty</th>
                                        <th>Num<br>Qty</th>
                                        <th>Sizes</th>
                                        <th>Number Sequence</th>
                                    </thead>

                                    <tbody>
                                        @foreach ($orderItem->orderItemDetails as $orderItemDetail)
                                            @if ($orderItemDetail->qty || $orderItemDetail->blanks)
                                                <tr>
                                                    <td rowspan="2" class="text-center">
                                                        <h5 class="mt-3">{{ $orderItemDetail->blanks }}</h5>
                                                    </td>
                                                    <td rowspan="2" class="text-center">
                                                        <h5 class="mt-3">{{ $orderItemDetail->qty }}</h5>
                                                    </td>
                                                    <td rowspan="2">
                                                        <h5 class="mt-3">
                                                            {{ $orderItemDetail->sizeDetails['size_name'] }}</h5>
                                                    </td>
                                                    <td class="num-seq">
                                                        @if ($orderItemDetail->numseq_one !== null && $orderItemDetail->numseq_one !== '') <h5>{{ $orderItemDetail->numseq_one }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_two !== null && $orderItemDetail->numseq_two !== '') <h5>{{ $orderItemDetail->numseq_two }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_three !== null && $orderItemDetail->numseq_three !== '') <h5>{{ $orderItemDetail->numseq_three }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_four !== null && $orderItemDetail->numseq_four !== '') <h5>{{ $orderItemDetail->numseq_four }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_five !== null && $orderItemDetail->numseq_five !== '') <h5>{{ $orderItemDetail->numseq_five }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_six !== null && $orderItemDetail->numseq_six !== '') <h5>{{ $orderItemDetail->numseq_six }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_seven !== null && $orderItemDetail->numseq_seven !== '') <h5>{{ $orderItemDetail->numseq_seven }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_eight !== null && $orderItemDetail->numseq_eight !== '') <h5>{{ $orderItemDetail->numseq_eight }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_nine !== null && $orderItemDetail->numseq_nine !== '') <h5>{{ $orderItemDetail->numseq_nine }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_ten !== null && $orderItemDetail->numseq_ten !== '') <h5>{{ $orderItemDetail->numseq_ten }}</h5> @endif

                                                        @if ($orderItemDetail->numseq_eleven !== null && $orderItemDetail->numseq_eleven !== '') <h5>{{ $orderItemDetail->numseq_eleven }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_twelve !== null && $orderItemDetail->numseq_twelve !== '') <h5>{{ $orderItemDetail->numseq_twelve }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_thirteen !== null && $orderItemDetail->numseq_thirteen !== '') <h5>{{ $orderItemDetail->numseq_thirteen }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_fourteen !== null && $orderItemDetail->numseq_fourteen !== '') <h5>{{ $orderItemDetail->numseq_fourteen }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_fifteen !== null && $orderItemDetail->numseq_fifteen !== '') <h5>{{ $orderItemDetail->numseq_fifteen }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_sixteen !== null && $orderItemDetail->numseq_sixteen !== '') <h5>{{ $orderItemDetail->numseq_sixteen }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_seventeen !== null && $orderItemDetail->numseq_seventeen !== '') <h5>{{ $orderItemDetail->numseq_seventeen }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_eighteen !== null && $orderItemDetail->numseq_eighteen !== '') <h5>{{ $orderItemDetail->numseq_eighteen }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_nineteen !== null && $orderItemDetail->numseq_nineteen !== '') <h5>{{ $orderItemDetail->numseq_nineteen }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_twenty !== null && $orderItemDetail->numseq_twenty !== '') <h5>{{ $orderItemDetail->numseq_twenty }}</h5> @endif

                                                        @if ($orderItemDetail->numseq_twenty_one !== null && $orderItemDetail->numseq_twenty_one !== '') <h5>{{ $orderItemDetail->numseq_twenty_one }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_twenty_two !== null && $orderItemDetail->numseq_twenty_two !== '') <h5>{{ $orderItemDetail->numseq_twenty_two }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_twenty_three !== null && $orderItemDetail->numseq_twenty_three !== '') <h5>{{ $orderItemDetail->numseq_twenty_three }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_twenty_four !== null && $orderItemDetail->numseq_twenty_four !== '') <h5>{{ $orderItemDetail->numseq_twenty_four }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_twenty_five !== null && $orderItemDetail->numseq_twenty_five !== '') <h5>{{ $orderItemDetail->numseq_twenty_five }}</h5> @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="num-seq">
                                                        @if ($orderItemDetail->numseq_twenty_six !== null && $orderItemDetail->numseq_twenty_six !== '') <h5>{{ $orderItemDetail->numseq_twenty_six }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_twenty_seven !== null && $orderItemDetail->numseq_twenty_seven !== '') <h5>{{ $orderItemDetail->numseq_twenty_seven }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_twenty_eight !== null && $orderItemDetail->numseq_twenty_eight !== '') <h5>{{ $orderItemDetail->numseq_twenty_eight }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_twenty_nine !== null && $orderItemDetail->numseq_twenty_nine !== '') <h5>{{ $orderItemDetail->numseq_twenty_nine }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_thirty !== null && $orderItemDetail->numseq_thirty !== '') <h5>{{ $orderItemDetail->numseq_thirty }}</h5> @endif

                                                        @if ($orderItemDetail->numseq_thirty_one !== null && $orderItemDetail->numseq_thirty_one !== '') <h5>{{ $orderItemDetail->numseq_thirty_one }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_thirty_two !== null && $orderItemDetail->numseq_thirty_two !== '') <h5>{{ $orderItemDetail->numseq_thirty_two }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_thirty_three !== null && $orderItemDetail->numseq_thirty_three !== '') <h5>{{ $orderItemDetail->numseq_thirty_three }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_thirty_four !== null && $orderItemDetail->numseq_thirty_four !== '') <h5>{{ $orderItemDetail->numseq_thirty_four }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_thirty_five !== null && $orderItemDetail->numseq_thirty_five !== '') <h5>{{ $orderItemDetail->numseq_thirty_five }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_thirty_six !== null && $orderItemDetail->numseq_thirty_six !== '') <h5>{{ $orderItemDetail->numseq_thirty_six }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_thirty_seven !== null && $orderItemDetail->numseq_thirty_seven !== '') <h5>{{ $orderItemDetail->numseq_thirty_seven }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_thirty_eight !== null && $orderItemDetail->numseq_thirty_eight !== '') <h5>{{ $orderItemDetail->numseq_thirty_eight }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_thirty_nine !== null && $orderItemDetail->numseq_thirty_nine !== '') <h5>{{ $orderItemDetail->numseq_thirty_nine }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_forty !== null && $orderItemDetail->numseq_forty !== '') <h5>{{ $orderItemDetail->numseq_forty }}</h5> @endif

                                                        @if ($orderItemDetail->numseq_forty_one !== null && $orderItemDetail->numseq_forty_one !== '') <h5>{{ $orderItemDetail->numseq_forty_one }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_forty_two !== null && $orderItemDetail->numseq_forty_two !== '') <h5>{{ $orderItemDetail->numseq_forty_two }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_forty_three !== null && $orderItemDetail->numseq_forty_three !== '') <h5>{{ $orderItemDetail->numseq_forty_three }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_forty_four !== null && $orderItemDetail->numseq_forty_four !== '') <h5>{{ $orderItemDetail->numseq_forty_four }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_forty_five !== null && $orderItemDetail->numseq_forty_five !== '') <h5>{{ $orderItemDetail->numseq_forty_five }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_forty_six !== null && $orderItemDetail->numseq_forty_six !== '') <h5>{{ $orderItemDetail->numseq_forty_six }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_forty_seven !== null && $orderItemDetail->numseq_forty_seven !== '') <h5>{{ $orderItemDetail->numseq_forty_seven }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_forty_eight !== null && $orderItemDetail->numseq_forty_eight !== '') <h5>{{ $orderItemDetail->numseq_forty_eight }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_forty_nine !== null && $orderItemDetail->numseq_forty_nine !== '') <h5>{{ $orderItemDetail->numseq_forty_nine }}</h5> @endif
                                                        @if ($orderItemDetail->numseq_fifty !== null && $orderItemDetail->numseq_fifty !== '') <h5>{{ $orderItemDetail->numseq_fifty }}</h5> @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="thead-light">
                                            <th>Total<br>Blank<br>Qty</th>
                                            <th>Total<br>Num<br>Qty</th>
                                            {{-- <th>Item<br>Price</th> --}}
                                            <th colspan="2">Total Qty</th>
                                        </tr>

                                        <tr>
                                            {{-- @foreach ($orderItem->orderItemDetails as $orderItemDetail) --}}
                                            <th class="text-center" id="blank_qty">
                                                <h5>
                                                    @php
                                                        $totalBlank = 0;
                                                        foreach ($orderItem->orderItemDetails as $orderItemDetail) {
                                                            $totalBlank += $orderItemDetail->blanks;
                                                        }
                                                        echo $totalBlank;
                                                    @endphp
                                                </h5>
                                            </th>
                                            <th class="text-center" id="num_qty">
                                                <h5>
                                                    @php
                                                        $totalNum = 0;
                                                        foreach ($orderItem->orderItemDetails as $orderItemDetail) {
                                                            $totalNum += $orderItemDetail->qty;
                                                        }
                                                        echo $totalNum;
                                                    @endphp
                                                </h5>
                                            </th>
                                            {{-- <th class="text-right pr-2"></th> --}}
                                            <th class="pl-2" id="total_qty" colspan="2">
                                                <h5>{{ $orderItem->qty ?? 0 }}</h5>
                                            </th>
                                            {{-- @endforeach --}}
                                        </tr>

                                        {{-- <tr class="thead-light">
                                            <th colspan="3">Item Price ($)</th>
                                            <th class="pl-2" id="price"><h5>{{$orderItem->productDetails['default_price']}}</h5></th>
                                        </tr>
                                        <tr class="thead-light">
                                            <th colspan="3">Total Price ($)</th>
                                            <th class="pl-2" id="total_price"><h5>{{$orderItem->total}}</h5></th>
                                        </tr> --}}
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- <hr class="page-divider"> --}}

                </div>
                @if (!$loop->last)
                    <div style="page-break-after:always; clear:both"></div>
                @endif

            @endforeach

            <a href="{{ url('order_details/edit') }}/{{ $order->id }}/order?active_tab=order" id="redirect_link"
                style="display: none;">redirect link</a>
        @endforeach
    </div>

    <script>
        $(document).ready(function() {
            var orderId = $('#pdf_id').val();

            pdfDownload(orderId);
        });

        function pdfDownload(orderId) {
            var element = document.getElementById('pdf_print');
            var opt = {
                filename: 'Roster_' + orderId + '.pdf',
                jsPDF: {
                    format: 'a4',
                    orientation: 'portrait'
                },
            };
            html2pdf().set(opt).from(element).save();

            setTimeout(function() {
                $('#redirect_link')[0].click();
            }, 5000);
        }
    </script>
@endsection
