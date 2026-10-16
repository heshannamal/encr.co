@extends('layouts.app', ['activePage' => 'order', 'titlePage' => __('Order Item Print')])

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
        .page-title {
            font-size: 24px;
        }
        /* .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
        } */
    </style>

    <div class="se-pre-con"></div>

    <div class="container-fluid mt-5" id="order_item_print">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6">
                    <img src="{{ asset('argon') }}/img/encore/logo1.png" height="150px">
                </div>

                <div class="col-lg-6">
                    <input type="hidden" value="{{$orderItem->item_no}}" id="item_no" />
                    <h3 class="page-title text-danger text-right">Order Item #: {{$orderItem->item_no}}</h3>
                </div>

                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th>Style Name:</th>
                            <td><h5>{{$orderItem->productDetails['product_name']}}</h5></td>
                        </tr>
                        <tr>
                            <th>Item Status:</th>
                            <td><h5>{{$orderItem->statusDetails['status_name']}}</h5></td>
                        </tr>
                        <tr>
                            <th>Open Date:</th>
                            <td><h5>{{$orderItem->open_date}}</h5></td>
                        </tr>
                        @if ($orderItem->close_date)
                            <tr>
                                <th>Close Date:</th>
                                <td><h5>{{$orderItem->close_date}}</h5></td>
                            </tr>
                        @endif
                        <tr>
                            <th>Ex Factory Date:</th>
                            <td><h5>{{$orderItem->ex_factory_date}}</h5></td>
                        </tr>
                        <tr>
                            <th>In Hand Due Date:</th>
                            <td><h5>{{$orderItem->in_hand_due_date}}</h5></td>
                        </tr>
                        <tr>
                            <th>Factory:</th>
                            <td><h5>@if(isset($orderItem->factoryDetails['factory_code'])) {{ $orderItem->factoryDetails['factory_code'] }} @endif</h5></td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th>Team Name:</th>
                            <td><h5>{{$order->organizationDetails['organization_name'] ?? ''}}</h5></td>
                        </tr>
                        <tr>
                            <th>Shipping Recipient:</th>
                            <td><h5>{{$order->contactDetails['first_name'] ?? ''.' '.$order->contactDetails['last_name'] ?? ''}}</h5></td>
                        </tr>
                        @if ($orderItem->ex_factory_id == 0)
                            <tr>
                                <th rowspan="3">Ex-Factory Address:</th>
                                <td><h5>{{$order->street ?? ''}}</h5></td>
                            </tr>
                            <tr><td><h5>{{$order->city ?? ''}} {{$order->state ?? ''}} {{$order->postal_code ?? ''}}</h5></td></tr>
                            <tr><td><h5>{{$order->country}}</h5></td></tr>
                        @else
                            <tr>
                                <th rowspan="3">Ex-Factory Address:</th>
                                <td><h5>{{$orderItem->exFactoryDetails['po_box'] ?? ''}}</h5></td>
                            </tr>
                            <tr><td><h5>{{$orderItem->exFactoryDetails['city'] ?? ''}} {{$order->exFactoryDetails['state'] ?? ''}} {{$order->exFactoryDetails['postal_code'] ?? ''}}</h5></td></tr>
                            <tr><td><h5>{{$orderItem->exFactoryDetails['country'] ?? ''}}</h5></td></tr>
                        @endif

                        <tr>
                            <th>Phone No:</th>
                            <td><h5>{{$order->phone_no ?? ''}}</h5></td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td><h5>{{$order->email ?? ''}}</h5></td>
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
                            <th>Primary Fabric:</th>
                            <td><h5>{{$orderItem->fabricDetails['fabric_name'] ?? 'N/A'}}
                            </h5></td>
                        </tr>
                        <tr>
                            <th>Secondary Fabric:</th>
                            <td><h5>@if(isset($orderItem->secFabricDetails['fabric_name'])) {{$orderItem->secFabricDetails['fabric_name']}} @endif</h5></td>
                        </tr>
                        <tr>
                            <th>Embellishment:</th>
                            <td><h5>@if(isset($orderItem->embellishmentDetails['embellishment_name'])) {{$orderItem->embellishmentDetails['embellishment_name']}} @endif</h5></td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th>Tracking No:</th>
                            <td><h5>{{$orderItem->tracking_no ? : '--'}}</h5></td>
                        </tr>
                        <tr>
                            <th>Tracking Link:</th>
                            <td><h5>{{$orderItem->tracking_link ? : '--'}}</h5></td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <td>@if ($orderItem->double_sided == 1) <i class="fas fa-check-square"></i> @else <i class="far fa-square"></i> @endif Double Sided</td>
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

        <div class="col-lg-12 mb-1 pb-5">
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

                                @php
                                    if($orderItemDetail->qty >= 125){
                                        $rowspanValue = 6;
                                    }elseif($orderItemDetail->qty >= 100){
                                        $rowspanValue = 5;
                                    }elseif($orderItemDetail->qty >= 75){
                                        $rowspanValue = 4;
                                    }elseif($orderItemDetail->qty >= 50){
                                        $rowspanValue = 3;
                                    }else{
                                        $rowspanValue = 2;
                                    }
                                @endphp
                                    <tr>
                                        <td rowspan="{{$rowspanValue}}" class="text-center"><h5 class="mt-3">{{$orderItemDetail->blanks}}</h5></td>
                                        <td rowspan="{{$rowspanValue}}" class="text-center"><h5 class="mt-3">{{$orderItemDetail->qty}}</h5></td>
                                        <td rowspan="{{$rowspanValue}}"><h5 class="mt-3">{{$orderItemDetail->sizeDetails['size_name']}}</h5></td>
                                        <td class="num-seq">
                                            @if ($orderItemDetail->numseq_one != null || $orderItemDetail->numseq_one != '') <h5>{{$orderItemDetail->numseq_one}}</h5> @endif
                                            @if ($orderItemDetail->numseq_two != null || $orderItemDetail->numseq_two != '') <h5>{{$orderItemDetail->numseq_two}}</h5> @endif
                                            @if ($orderItemDetail->numseq_three != null || $orderItemDetail->numseq_three != '') <h5>{{$orderItemDetail->numseq_three}}</h5> @endif
                                            @if ($orderItemDetail->numseq_four != null || $orderItemDetail->numseq_four != '') <h5>{{$orderItemDetail->numseq_four}}</h5> @endif
                                            @if ($orderItemDetail->numseq_five != null || $orderItemDetail->numseq_five != '') <h5>{{$orderItemDetail->numseq_five}}</h5> @endif
                                            @if ($orderItemDetail->numseq_six != null || $orderItemDetail->numseq_six != '') <h5>{{$orderItemDetail->numseq_six}}</h5> @endif
                                            @if ($orderItemDetail->numseq_seven != null || $orderItemDetail->numseq_seven != '') <h5>{{$orderItemDetail->numseq_seven}}</h5> @endif
                                            @if ($orderItemDetail->numseq_eight != null ||$orderItemDetail->numseq_eight != '') <h5>{{$orderItemDetail->numseq_eight}}</h5> @endif
                                            @if ($orderItemDetail->numseq_nine != null || $orderItemDetail->numseq_nine != '') <h5>{{$orderItemDetail->numseq_nine}}</h5> @endif
                                            @if ($orderItemDetail->numseq_ten != null || $orderItemDetail->numseq_ten != '') <h5>{{$orderItemDetail->numseq_ten}}</h5> @endif

                                            @if ($orderItemDetail->numseq_eleven != null || $orderItemDetail->numseq_eleven != '') <h5>{{$orderItemDetail->numseq_eleven}}</h5> @endif
                                            @if ($orderItemDetail->numseq_twelve != null || $orderItemDetail->numseq_twelve != '') <h5>{{$orderItemDetail->numseq_twelve}}</h5> @endif
                                            @if ($orderItemDetail->numseq_thirteen != null || $orderItemDetail->numseq_thirteen != '') <h5>{{$orderItemDetail->numseq_thirteen}}</h5> @endif
                                            @if ($orderItemDetail->numseq_fourteen != null || $orderItemDetail->numseq_fourteen != '') <h5>{{$orderItemDetail->numseq_fourteen}}</h5> @endif
                                            @if ($orderItemDetail->numseq_fifteen != null || $orderItemDetail->numseq_fifteen != '') <h5>{{$orderItemDetail->numseq_fifteen}}</h5> @endif
                                            @if ($orderItemDetail->numseq_sixteen != null || $orderItemDetail->numseq_sixteen != '') <h5>{{$orderItemDetail->numseq_sixteen}}</h5> @endif
                                            @if ($orderItemDetail->numseq_seventeen != null || $orderItemDetail->numseq_seventeen != '') <h5>{{$orderItemDetail->numseq_seventeen}}</h5> @endif
                                            @if ($orderItemDetail->numseq_eighteen != null || $orderItemDetail->numseq_eighteen != '') <h5>{{$orderItemDetail->numseq_eighteen}}</h5> @endif
                                            @if ($orderItemDetail->numseq_nineteen != null || $orderItemDetail->numseq_nineteen != '') <h5>{{$orderItemDetail->numseq_nineteen}}</h5> @endif
                                            @if ($orderItemDetail->numseq_twenty != null || $orderItemDetail->numseq_twenty != '') <h5>{{$orderItemDetail->numseq_twenty}}</h5> @endif

                                            @if ($orderItemDetail->numseq_twenty_one != null || $orderItemDetail->numseq_twenty_one != '') <h5>{{$orderItemDetail->numseq_twenty_one}}</h5> @endif
                                            @if ($orderItemDetail->numseq_twenty_two != null || $orderItemDetail->numseq_twenty_two != '') <h5>{{$orderItemDetail->numseq_twenty_two}}</h5> @endif
                                            @if ($orderItemDetail->numseq_twenty_three != null || $orderItemDetail->numseq_twenty_three != '') <h5>{{$orderItemDetail->numseq_twenty_three}}</h5> @endif
                                            @if ($orderItemDetail->numseq_twenty_four != null || $orderItemDetail->numseq_twenty_four != '') <h5>{{$orderItemDetail->numseq_twenty_four}}</h5> @endif
                                            @if ($orderItemDetail->numseq_twenty_five != null || $orderItemDetail->numseq_twenty_five != '') <h5>{{$orderItemDetail->numseq_twenty_five}}</h5> @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="num-seq">
                                            @if ($orderItemDetail->numseq_twenty_six != null || $orderItemDetail->numseq_twenty_six != '') <h5>{{$orderItemDetail->numseq_twenty_six}}</h5> @endif
                                            @if ($orderItemDetail->numseq_twenty_seven != null || $orderItemDetail->numseq_twenty_seven != '') <h5>{{$orderItemDetail->numseq_twenty_seven}}</h5> @endif
                                            @if ($orderItemDetail->numseq_twenty_eight != null || $orderItemDetail->numseq_twenty_eight != '') <h5>{{$orderItemDetail->numseq_twenty_eight}}</h5> @endif
                                            @if ($orderItemDetail->numseq_twenty_nine != null || $orderItemDetail->numseq_twenty_nine != '') <h5>{{$orderItemDetail->numseq_twenty_nine}}</h5> @endif
                                            @if ($orderItemDetail->numseq_thirty != null || $orderItemDetail->numseq_thirty != '') <h5>{{$orderItemDetail->numseq_thirty}}</h5> @endif

                                            @if ($orderItemDetail->numseq_thirty_one != null || $orderItemDetail->numseq_thirty_one != '') <h5>{{$orderItemDetail->numseq_thirty_one}}</h5> @endif
                                            @if ($orderItemDetail->numseq_thirty_two != null || $orderItemDetail->numseq_thirty_two != '') <h5>{{$orderItemDetail->numseq_thirty_two}}</h5> @endif
                                            @if ($orderItemDetail->numseq_thirty_three != null || $orderItemDetail->numseq_thirty_three != '') <h5>{{$orderItemDetail->numseq_thirty_three}}</h5> @endif
                                            @if ($orderItemDetail->numseq_thirty_four != null || $orderItemDetail->numseq_thirty_four != '') <h5>{{$orderItemDetail->numseq_thirty_four}}</h5> @endif
                                            @if ($orderItemDetail->numseq_thirty_five != null || $orderItemDetail->numseq_thirty_five != '') <h5>{{$orderItemDetail->numseq_thirty_five}}</h5> @endif
                                            @if ($orderItemDetail->numseq_thirty_six != null || $orderItemDetail->numseq_thirty_six != '') <h5>{{$orderItemDetail->numseq_thirty_six}}</h5> @endif
                                            @if ($orderItemDetail->numseq_thirty_seven != null || $orderItemDetail->numseq_thirty_seven != '') <h5>{{$orderItemDetail->numseq_thirty_seven}}</h5> @endif
                                            @if ($orderItemDetail->numseq_thirty_eight != null || $orderItemDetail->numseq_thirty_eight != '') <h5>{{$orderItemDetail->numseq_thirty_eight}}</h5> @endif
                                            @if ($orderItemDetail->numseq_thirty_nine != null || $orderItemDetail->numseq_thirty_nine != '') <h5>{{$orderItemDetail->numseq_thirty_nine}}</h5> @endif
                                            @if ($orderItemDetail->numseq_forty != null || $orderItemDetail->numseq_forty != '') <h5>{{$orderItemDetail->numseq_forty}}</h5> @endif

                                            @if ($orderItemDetail->numseq_forty_one != null || $orderItemDetail->numseq_forty_one != '') <h5>{{$orderItemDetail->numseq_forty_one}}</h5> @endif
                                            @if ($orderItemDetail->numseq_forty_two != null || $orderItemDetail->numseq_forty_two != '') <h5>{{$orderItemDetail->numseq_forty_two}}</h5> @endif
                                            @if ($orderItemDetail->numseq_forty_three != null || $orderItemDetail->numseq_forty_three != '') <h5>{{$orderItemDetail->numseq_forty_three}}</h5> @endif
                                            @if ($orderItemDetail->numseq_forty_four != null || $orderItemDetail->numseq_forty_four != '') <h5>{{$orderItemDetail->numseq_forty_four}}</h5> @endif
                                            @if ($orderItemDetail->numseq_forty_five != null || $orderItemDetail->numseq_forty_five != '') <h5>{{$orderItemDetail->numseq_forty_five}}</h5> @endif
                                            @if ($orderItemDetail->numseq_forty_six != null || $orderItemDetail->numseq_forty_six != '') <h5>{{$orderItemDetail->numseq_forty_six}}</h5> @endif
                                            @if ($orderItemDetail->numseq_forty_seven != null || $orderItemDetail->numseq_forty_seven != '') <h5>{{$orderItemDetail->numseq_forty_seven}}</h5> @endif
                                            @if ($orderItemDetail->numseq_forty_eight != null || $orderItemDetail->numseq_forty_eight != '') <h5>{{$orderItemDetail->numseq_forty_eight}}</h5> @endif
                                            @if ($orderItemDetail->numseq_forty_nine != null || $orderItemDetail->numseq_forty_nine != '') <h5>{{$orderItemDetail->numseq_forty_nine}}</h5> @endif
                                            @if ($orderItemDetail->numseq_fifty != null || $orderItemDetail->numseq_fifty != '') <h5>{{$orderItemDetail->numseq_fifty}}</h5> @endif
                                        </td>
                                    </tr>
                                    @if($orderItemDetail->qty > 50)
                                    <tr>
                                        <td class="num-seq">
                                            @if ($orderItemDetail->numseq_fifty_one != null || $orderItemDetail->numseq_fifty_one != '') <h5>{{$orderItemDetail->numseq_fifty_one}}</h5> @endif
                                            @if ($orderItemDetail->numseq_fifty_two != null || $orderItemDetail->numseq_fifty_two != '') <h5>{{$orderItemDetail->numseq_fifty_two}}</h5> @endif
                                            @if ($orderItemDetail->numseq_fifty_three != null || $orderItemDetail->numseq_fifty_three != '') <h5>{{$orderItemDetail->numseq_fifty_three}}</h5> @endif
                                            @if ($orderItemDetail->numseq_fifty_four != null || $orderItemDetail->numseq_fifty_four != '') <h5>{{$orderItemDetail->numseq_fifty_four}}</h5> @endif
                                            @if ($orderItemDetail->numseq_fifty_five != null || $orderItemDetail->numseq_fifty_five != '') <h5>{{$orderItemDetail->numseq_fifty_five}}</h5> @endif
                                            @if ($orderItemDetail->numseq_fifty_six != null || $orderItemDetail->numseq_fifty_six != '') <h5>{{$orderItemDetail->numseq_fifty_six}}</h5> @endif
                                            @if ($orderItemDetail->numseq_fifty_seven != null || $orderItemDetail->numseq_fifty_seven != '') <h5>{{$orderItemDetail->numseq_fifty_seven}}</h5> @endif
                                            @if ($orderItemDetail->numseq_fifty_eight != null ||$orderItemDetail->numseq_fifty_eight != '') <h5>{{$orderItemDetail->numseq_fifty_eight}}</h5> @endif
                                            @if ($orderItemDetail->numseq_fifty_nine != null || $orderItemDetail->numseq_fifty_nine != '') <h5>{{$orderItemDetail->numseq_fifty_nine}}</h5> @endif
                                            @if ($orderItemDetail->numseq_sixty != null || $orderItemDetail->numseq_sixty != '') <h5>{{$orderItemDetail->numseq_sixty}}</h5> @endif

                                            @if ($orderItemDetail->numseq_sixty_one != null || $orderItemDetail->numseq_sixty_one != '') <h5>{{$orderItemDetail->numseq_sixty_one}}</h5> @endif
                                            @if ($orderItemDetail->numseq_sixty_two != null || $orderItemDetail->numseq_sixty_two != '') <h5>{{$orderItemDetail->numseq_sixty_two}}</h5> @endif
                                            @if ($orderItemDetail->numseq_sixty_three != null || $orderItemDetail->numseq_sixty_three != '') <h5>{{$orderItemDetail->numseq_sixty_three}}</h5> @endif
                                            @if ($orderItemDetail->numseq_sixty_four != null || $orderItemDetail->numseq_sixty_four != '') <h5>{{$orderItemDetail->numseq_sixty_four}}</h5> @endif
                                            @if ($orderItemDetail->numseq_sixty_five != null || $orderItemDetail->numseq_sixty_five != '') <h5>{{$orderItemDetail->numseq_sixty_five}}</h5> @endif
                                            @if ($orderItemDetail->numseq_sixty_six != null || $orderItemDetail->numseq_sixty_six != '') <h5>{{$orderItemDetail->numseq_sixty_six}}</h5> @endif
                                            @if ($orderItemDetail->numseq_sixty_seven != null || $orderItemDetail->numseq_sixty_seven != '') <h5>{{$orderItemDetail->numseq_sixty_seven}}</h5> @endif
                                            @if ($orderItemDetail->numseq_sixty_eight != null ||$orderItemDetail->numseq_sixty_eight != '') <h5>{{$orderItemDetail->numseq_sixty_eight}}</h5> @endif
                                            @if ($orderItemDetail->numseq_sixty_nine != null || $orderItemDetail->numseq_sixty_nine != '') <h5>{{$orderItemDetail->numseq_sixty_nine}}</h5> @endif
                                            @if ($orderItemDetail->numseq_seventy != null || $orderItemDetail->numseq_seventy != '') <h5>{{$orderItemDetail->numseq_seventy}}</h5> @endif

                                            @if ($orderItemDetail->numseq_seventy_one != null || $orderItemDetail->numseq_seventy_one != '') <h5>{{$orderItemDetail->numseq_seventy_one}}</h5> @endif
                                            @if ($orderItemDetail->numseq_seventy_two != null || $orderItemDetail->numseq_seventy_two != '') <h5>{{$orderItemDetail->numseq_seventy_two}}</h5> @endif
                                            @if ($orderItemDetail->numseq_seventy_three != null || $orderItemDetail->numseq_seventy_three != '') <h5>{{$orderItemDetail->numseq_seventy_three}}</h5> @endif
                                            @if ($orderItemDetail->numseq_seventy_four != null || $orderItemDetail->numseq_seventy_four != '') <h5>{{$orderItemDetail->numseq_seventy_four}}</h5> @endif
                                            @if ($orderItemDetail->numseq_seventy_five != null || $orderItemDetail->numseq_seventy_five != '') <h5>{{$orderItemDetail->numseq_seventy_five}}</h5> @endif
                                        </td>
                                    </tr>
                                    @endif

                                    @if($orderItemDetail->qty > 75)
                                    <tr>
                                        <td class="num-seq">
                                            @if ($orderItemDetail->numseq_seventy_six != null || $orderItemDetail->numseq_seventy_six != '') <h5>{{$orderItemDetail->numseq_seventy_six}}</h5> @endif
                                            @if ($orderItemDetail->numseq_seventy_seven != null || $orderItemDetail->numseq_seventy_seven != '') <h5>{{$orderItemDetail->numseq_seventy_seven}}</h5> @endif
                                            @if ($orderItemDetail->numseq_seventy_eight != null || $orderItemDetail->numseq_seventy_eight != '') <h5>{{$orderItemDetail->numseq_seventy_eight}}</h5> @endif
                                            @if ($orderItemDetail->numseq_seventy_nine != null || $orderItemDetail->numseq_seventy_nine != '') <h5>{{$orderItemDetail->numseq_seventy_nine}}</h5> @endif
                                            @if ($orderItemDetail->numseq_ninety != null || $orderItemDetail->numseq_ninety != '') <h5>{{$orderItemDetail->numseq_ninety}}</h5> @endif

                                            @if ($orderItemDetail->numseq_eighty_one != null || $orderItemDetail->numseq_eighty_one != '') <h5>{{$orderItemDetail->numseq_eighty_one}}</h5> @endif
                                            @if ($orderItemDetail->numseq_eighty_two != null || $orderItemDetail->numseq_eighty_two != '') <h5>{{$orderItemDetail->numseq_eighty_two}}</h5> @endif
                                            @if ($orderItemDetail->numseq_eighty_three != null || $orderItemDetail->numseq_eighty_three != '') <h5>{{$orderItemDetail->numseq_eighty_three}}</h5> @endif
                                            @if ($orderItemDetail->numseq_eighty_four != null || $orderItemDetail->numseq_eighty_four != '') <h5>{{$orderItemDetail->numseq_eighty_four}}</h5> @endif
                                            @if ($orderItemDetail->numseq_eighty_five != null || $orderItemDetail->numseq_eighty_five != '') <h5>{{$orderItemDetail->numseq_eighty_five}}</h5> @endif
                                            @if ($orderItemDetail->numseq_eighty_six != null || $orderItemDetail->numseq_eighty_six != '') <h5>{{$orderItemDetail->numseq_eighty_six}}</h5> @endif
                                            @if ($orderItemDetail->numseq_eighty_seven != null || $orderItemDetail->numseq_eighty_seven != '') <h5>{{$orderItemDetail->numseq_eighty_seven}}</h5> @endif
                                            @if ($orderItemDetail->numseq_eighty_eight != null || $orderItemDetail->numseq_eighty_eight != '') <h5>{{$orderItemDetail->numseq_eighty_eight}}</h5> @endif
                                            @if ($orderItemDetail->numseq_eighty_nine != null || $orderItemDetail->numseq_eighty_nine != '') <h5>{{$orderItemDetail->numseq_eighty_nine}}</h5> @endif
                                            @if ($orderItemDetail->numseq_ninety != null || $orderItemDetail->numseq_ninety != '') <h5>{{$orderItemDetail->numseq_ninety}}</h5> @endif

                                            @if ($orderItemDetail->numseq_ninety_one != null || $orderItemDetail->numseq_ninety_one != '') <h5>{{$orderItemDetail->numseq_ninety_one}}</h5> @endif
                                            @if ($orderItemDetail->numseq_ninety_two != null || $orderItemDetail->numseq_ninety_two != '') <h5>{{$orderItemDetail->numseq_ninety_two}}</h5> @endif
                                            @if ($orderItemDetail->numseq_ninety_three != null || $orderItemDetail->numseq_ninety_three != '') <h5>{{$orderItemDetail->numseq_ninety_three}}</h5> @endif
                                            @if ($orderItemDetail->numseq_ninety_four != null || $orderItemDetail->numseq_ninety_four != '') <h5>{{$orderItemDetail->numseq_ninety_four}}</h5> @endif
                                            @if ($orderItemDetail->numseq_ninety_five != null || $orderItemDetail->numseq_ninety_five != '') <h5>{{$orderItemDetail->numseq_ninety_five}}</h5> @endif
                                            @if ($orderItemDetail->numseq_ninety_six != null || $orderItemDetail->numseq_ninety_six != '') <h5>{{$orderItemDetail->numseq_ninety_six}}</h5> @endif
                                            @if ($orderItemDetail->numseq_ninety_seven != null || $orderItemDetail->numseq_ninety_seven != '') <h5>{{$orderItemDetail->numseq_ninety_seven}}</h5> @endif
                                            @if ($orderItemDetail->numseq_ninety_eight != null || $orderItemDetail->numseq_ninety_eight != '') <h5>{{$orderItemDetail->numseq_ninety_eight}}</h5> @endif
                                            @if ($orderItemDetail->numseq_ninety_nine != null || $orderItemDetail->numseq_ninety_nine != '') <h5>{{$orderItemDetail->numseq_ninety_nine}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred != null || $orderItemDetail->numseq_hundred != '') <h5>{{$orderItemDetail->numseq_hundred}}</h5> @endif
                                        </td>
                                    </tr>
                                    @endif
                                    @if($orderItemDetail->qty > 100)
                                    <tr>
                                        <td class="num-seq">
                                            @if ($orderItemDetail->numseq_hundred_one != null || $orderItemDetail->numseq_hundred_one != '') <h5>{{$orderItemDetail->numseq_hundred_one}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_two != null || $orderItemDetail->numseq_hundred_two != '') <h5>{{$orderItemDetail->numseq_hundred_two}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_three != null || $orderItemDetail->numseq_hundred_three != '') <h5>{{$orderItemDetail->numseq_hundred_three}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_four != null || $orderItemDetail->numseq_hundred_four != '') <h5>{{$orderItemDetail->numseq_hundred_four}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_five != null || $orderItemDetail->numseq_hundred_five != '') <h5>{{$orderItemDetail->numseq_hundred_five}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_six != null || $orderItemDetail->numseq_hundred_six != '') <h5>{{$orderItemDetail->numseq_hundred_six}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_seven != null || $orderItemDetail->numseq_hundred_seven != '') <h5>{{$orderItemDetail->numseq_hundred_seven}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_eight != null ||$orderItemDetail->numseq_hundred_eight != '') <h5>{{$orderItemDetail->numseq_hundred_eight}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_nine != null || $orderItemDetail->numseq_hundred_nine != '') <h5>{{$orderItemDetail->numseq_hundred_nine}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_ten != null || $orderItemDetail->numseq_hundred_ten != '') <h5>{{$orderItemDetail->numseq_hundred_ten}}</h5> @endif

                                            @if ($orderItemDetail->numseq_hundred_eleven != null || $orderItemDetail->numseq_hundred_eleven != '') <h5>{{$orderItemDetail->numseq_hundred_eleven}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_twelve != null || $orderItemDetail->numseq_hundred_twelve != '') <h5>{{$orderItemDetail->numseq_hundred_twelve}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_thirteen != null || $orderItemDetail->numseq_hundred_thirteen != '') <h5>{{$orderItemDetail->numseq_hundred_thirteen}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_fourteen != null || $orderItemDetail->numseq_hundred_fourteen != '') <h5>{{$orderItemDetail->numseq_hundred_fourteen}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_fifteen != null || $orderItemDetail->numseq_hundred_fifteen != '') <h5>{{$orderItemDetail->numseq_hundred_fifteen}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_sixteen != null || $orderItemDetail->numseq_hundred_sixteen != '') <h5>{{$orderItemDetail->numseq_hundred_sixteen}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_seventeen != null || $orderItemDetail->numseq_hundred_seventeen != '') <h5>{{$orderItemDetail->numseq_hundred_seventeen}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_eighteen != null || $orderItemDetail->numseq_hundred_eighteen != '') <h5>{{$orderItemDetail->numseq_hundred_eighteen}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_nineteen != null || $orderItemDetail->numseq_hundred_nineteen != '') <h5>{{$orderItemDetail->numseq_hundred_nineteen}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_twenty != null || $orderItemDetail->numseq_hundred_twenty != '') <h5>{{$orderItemDetail->numseq_hundred_twenty}}</h5> @endif

                                            @if ($orderItemDetail->numseq_hundred_twenty_one != null || $orderItemDetail->numseq_hundred_twenty_one != '') <h5>{{$orderItemDetail->numseq_hundred_twenty_one}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_twenty_two != null || $orderItemDetail->numseq_hundred_twenty_two != '') <h5>{{$orderItemDetail->numseq_hundred_twenty_two}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_twenty_three != null || $orderItemDetail->numseq_hundred_twenty_three != '') <h5>{{$orderItemDetail->numseq_hundred_twenty_three}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_twenty_four != null || $orderItemDetail->numseq_hundred_twenty_four != '') <h5>{{$orderItemDetail->numseq_hundred_twenty_four}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_twenty_five != null || $orderItemDetail->numseq_hundred_twenty_five != '') <h5>{{$orderItemDetail->numseq_hundred_twenty_five}}</h5> @endif
                                        </td>
                                    </tr>
                                    @endif
                                    @if($orderItemDetail->qty > 125)
                                    <tr>
                                        <td class="num-seq">
                                            @if ($orderItemDetail->numseq_hundred_twenty_six != null || $orderItemDetail->numseq_hundred_twenty_six != '') <h5>{{$orderItemDetail->numseq_hundred_twenty_six}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_twenty_seven != null || $orderItemDetail->numseq_hundred_twenty_seven != '') <h5>{{$orderItemDetail->numseq_hundred_twenty_seven}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_twenty_eight != null || $orderItemDetail->numseq_hundred_twenty_eight != '') <h5>{{$orderItemDetail->numseq_hundred_twenty_eight}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_twenty_nine != null || $orderItemDetail->numseq_hundred_twenty_nine != '') <h5>{{$orderItemDetail->numseq_hundred_twenty_nine}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_thirty != null || $orderItemDetail->numseq_hundred_thirty != '') <h5>{{$orderItemDetail->numseq_hundred_thirty}}</h5> @endif

                                            @if ($orderItemDetail->numseq_hundred_thirty_one != null || $orderItemDetail->numseq_hundred_thirty_one != '') <h5>{{$orderItemDetail->numseq_hundred_thirty_one}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_thirty_two != null || $orderItemDetail->numseq_hundred_thirty_two != '') <h5>{{$orderItemDetail->numseq_hundred_thirty_two}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_thirty_three != null || $orderItemDetail->numseq_hundred_thirty_three != '') <h5>{{$orderItemDetail->numseq_hundred_thirty_three}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_thirty_four != null || $orderItemDetail->numseq_hundred_thirty_four != '') <h5>{{$orderItemDetail->numseq_hundred_thirty_four}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_thirty_five != null || $orderItemDetail->numseq_hundred_thirty_five != '') <h5>{{$orderItemDetail->numseq_hundred_thirty_five}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_thirty_six != null || $orderItemDetail->numseq_hundred_thirty_six != '') <h5>{{$orderItemDetail->numseq_hundred_thirty_six}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_thirty_seven != null || $orderItemDetail->numseq_hundred_thirty_seven != '') <h5>{{$orderItemDetail->numseq_hundred_thirty_seven}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_thirty_eight != null || $orderItemDetail->numseq_hundred_thirty_eight != '') <h5>{{$orderItemDetail->numseq_hundred_thirty_eight}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_thirty_nine != null || $orderItemDetail->numseq_hundred_thirty_nine != '') <h5>{{$orderItemDetail->numseq_hundred_thirty_nine}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_forty != null || $orderItemDetail->numseq_hundred_forty != '') <h5>{{$orderItemDetail->numseq_hundred_forty}}</h5> @endif

                                            @if ($orderItemDetail->numseq_hundred_forty_one != null || $orderItemDetail->numseq_hundred_forty_one != '') <h5>{{$orderItemDetail->numseq_hundred_forty_one}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_forty_two != null || $orderItemDetail->numseq_hundred_forty_two != '') <h5>{{$orderItemDetail->numseq_hundred_forty_two}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_forty_three != null || $orderItemDetail->numseq_hundred_forty_three != '') <h5>{{$orderItemDetail->numseq_hundred_forty_three}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_forty_four != null || $orderItemDetail->numseq_hundred_forty_four != '') <h5>{{$orderItemDetail->numseq_hundred_forty_four}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_forty_five != null || $orderItemDetail->numseq_hundred_forty_five != '') <h5>{{$orderItemDetail->numseq_hundred_forty_five}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_forty_six != null || $orderItemDetail->numseq_hundred_forty_six != '') <h5>{{$orderItemDetail->numseq_hundred_forty_six}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_forty_seven != null || $orderItemDetail->numseq_hundred_forty_seven != '') <h5>{{$orderItemDetail->numseq_hundred_forty_seven}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_forty_eight != null || $orderItemDetail->numseq_hundred_forty_eight != '') <h5>{{$orderItemDetail->numseq_hundred_forty_eight}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_forty_nine != null || $orderItemDetail->numseq_hundred_forty_nine != '') <h5>{{$orderItemDetail->numseq_hundred_forty_nine}}</h5> @endif
                                            @if ($orderItemDetail->numseq_hundred_fifty != null || $orderItemDetail->numseq_hundred_fifty != '') <h5>{{$orderItemDetail->numseq_hundred_fifty}}</h5> @endif
                                        </td>
                                    </tr>
                                    @endif
                                @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="thead-light">
                                <th>Total<br>Blank<br>Qty</th>
                                <th>Total<br>Num<br>Qty</th>
                                <th>Item<br>Price</th>
                                <th>Total Qty</th>
                            </tr>
                            <tr>
                                <th class="text-center" id="blank_qty"><h5>{{$blackQty}}</h5></th>
                                <th class="text-center" id="num_qty"><h5>{{$numQty}}</h5></th>
                                <th class="text-right pr-2"></th>
                                <th class="pl-2" id="total_qty"><h5></h5></th>
                            </tr>
                            @can('show order price')
                                <tr class="thead-light">
                                    <th colspan="3">Item Price ($)</th>
                                    <th class="pl-2" id="price"><h5>{{$orderItem->productDetails['default_price']}}</h5></th>
                                </tr>
                            @can('show order price')
                            @endcan
                                <tr class="thead-light">
                                    <th colspan="3">Total Price ($)</th>
                                    <th class="pl-2" id="total_price"><h5></h5></th>
                                </tr>
                            @endcan
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <a href="{{url('order_details/edit')}}/{{$order->id}}/order?active_tab=order" id="redirect_link" style="display: none;">redirect link</a>

    <script>
        $(document).ready(function(){
            var blank_qty = parseFloat($('#blank_qty').text());
            var num_qty = parseFloat($('#num_qty').text());
            var total_qty = blank_qty + num_qty;
            $('#total_qty h5').html(total_qty);

            var total_qty = parseFloat($('#total_qty').text());
            var price = parseFloat($('#price').text());
            var total_price = (total_qty * price).toFixed(2);
            $('#total_price h5').html(total_price);

            var itemId = $('#item_no').val();

            pdfDownload(itemId);
        });

        function pdfDownload(itemId){
            var element = document.getElementById('order_item_print');
            var opt = {
                filename: 'Order_Item_'+itemId+'.pdf',
                jsPDF: { format: 'a4', orientation: 'portrait' },
            };
            html2pdf().set(opt).from(element).save();

            setTimeout(function(){
                $('#redirect_link')[0].click();
            },5000);
        }
    </script>
@endsection
