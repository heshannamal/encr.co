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

@foreach ($orders as $order)
    <input type="hidden" id="pdf_id" value="{{ $order->id }}" />
    <div class="content_regular" data-divName="Order">
        <table>
            <tr>
                <td>Organization :</td>
                <td>{{$order->organizationDetails['organization_name']}}</td>
                <td></td>
                <td>Order # :</td>
                <td>{{$order->order_no}}</td>
            </tr>
            <tr>
                <td>Status :</td>
                <td>{{$order->statusDetails['status_name']}}</td>
                <td></td>
                <td>Sales Rep :</td>
                <td>{{$order->userDetails['name']}}</td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Shipping Address:</td>
                <td></td>
                <td></td>
                <td></td>
                <td>Billing Address:</td>
            </tr>
            <tr>
                <td>{{$order->contactDetails['first_name']}} {{$order->contactDetails['last_name']}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{$order->contactDetails['first_name']}} {{$order->contactDetails['last_name']}}</td>
            </tr>
            <tr>
                <td>{{$order->street}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{$order->street}}</td>
            </tr>
            <tr>
                <td>{{$order->city}} {{$order->state}} {{$order->postal_code}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{$order->city}} {{$order->state}} {{$order->postal_code}}</td>
            </tr>
            <tr>
                <td>{{$order->country}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{$order->country}}</td>
            </tr>
            <tr>
                <td>{{$order->phone_no}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{$order->phone_no}}</td>
            </tr>
            <tr>
                <td>{{$order->email}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{$order->email}}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
@endforeach

@foreach ($order->orderItems as $orderItem)
    <div class="content_regular" data-divName="ITEM {{ $orderItem->item_no }}">
        <table>
            <tr>
                <td>Order Item #:</td>
                <td>{{ $orderItem->item_no }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @if(isset($orderItem->productDetails['product_name']))
            <tr>
                <td>Style Name:</td>
                <td>{{ $orderItem->productDetails['product_name'] }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endif
            @if(isset($orderItem->statusDetails['status_name']))
            <tr>
                <td>Item Status:</td>
                <td>{{ $orderItem->statusDetails['status_name'] }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endif
            @if(isset($orderItem->item_description))
            <tr>
                <td>Item Description:</td>
                <td>{{ $orderItem->item_description }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endif
            @if(isset($orderItem->open_date))
            <tr>
                <td>Open Date:</td>
                <td>{{ $orderItem->open_date }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endif
            @if ($orderItem->close_date)
                <tr>
                    <td>Close Date:</td>
                    <td>{{ $orderItem->close_date }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
            @if(isset($orderItem->ex_factory_date))
            <tr>
                <td>Ex Factory Date:</td>
                <td>{{ $orderItem->ex_factory_date }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endif
            @if(isset($orderItem->in_hand_due_date))
            <tr>
                <td>In Hand Due Date:</td>
                <td>{{ $orderItem->in_hand_due_date }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endif
            @if(isset($orderItem->factoryDetails['factory_code']))
            <tr>
                <td>Factory:</td>
                <td>@if(isset($orderItem->factoryDetails['factory_code'])){{ $orderItem->factoryDetails['factory_code'] }}@endif</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endif
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @if(isset($orderItem->fabricDetails['fabric_name']))
            <tr>
                <td>Primary Fabric:</td>
                <td>@if(isset($orderItem->fabricDetails['fabric_name'])){{ $orderItem->fabricDetails['fabric_name'] }}@endif</td>
                <td></td>
                <td>Tracking No:</td>
                <td>{{ $orderItem->tracking_no ?: '--' }}</td>
            </tr>
            @endif
            @if(isset($orderItem->secFabricDetails['fabric_name']))
            <tr>
                <td>Secondary Fabric:</td>
                <td>@if(isset($orderItem->secFabricDetails['fabric_name'])){{ $orderItem->secFabricDetails['fabric_name'] }}@endif</td>
                <td></td>
                <td>Tracking Link:</td>
                <td>{{ $orderItem->tracking_link ?: '--' }}</td>
            </tr>
            @endif
            @if(isset($orderItem->embellishmentDetails['embellishment_name']))
            <tr>
                <td>Embellishment:</td>
                <td>@if(isset($orderItem->embellishmentDetails['embellishment_name'])){{ $orderItem->embellishmentDetails['embellishment_name'] }}@endif</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endif
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            @if ($orderItem->double_sided == 1)
                <tr>
                    <td>Reversible</td>
                    <td>@if ($orderItem->double_sided == 1) {{ 'True' }} @else <i class="far fa-square"></i> @endif</td>

                </tr>
            @endif
            @if ($orderItem->individual_no == 1)
                <tr>

                    <td>Individual Number</td>
                    <td>@if ($orderItem->individual_no == 1) {{ 'True' }} @else <i class="far fa-square"></i> @endif</td>
                </tr>
            @endif

            @if ($orderItem->pockets == 1)
                <tr>
                    <td>Pockets</td>
                    <td>@if ($orderItem->pockets == 1) {{ 'True' }} @else <i class="far fa-square"></i> @endif</td>

                </tr>
            @endif

            @if ($orderItem->individual_name == 1)
                <tr>
                    <td>Individual Name</td>
                    <td>@if ($orderItem->individual_name == 1) {{ 'True' }} @else <i class="far fa-square"></i> @endif</td>
                </tr>
            @endif

            @if ($orderItem->zipper_pockets == 1)
                <tr>
                    <td>Zippered Pockets</td>
                    <td>@if ($orderItem->zipper_pockets == 1) {{ 'True' }} @else <i class="far fa-square"></i> @endif</td>

                </tr>
            @endif

            @if ($orderItem->dynamic_details == 1)
                <tr>
                    <td>Dynamic Details</td>
                    <td>@if ($orderItem->dynamic_details == 1) {{ 'True' }} @else <i class="far fa-square"></i> @endif</td>
                </tr>
            @endif

            @if ($orderItem->contrast_stratching == 1)
                <tr>
                    <td>Contrast Stitching</td>
                    <td>@if ($orderItem->contrast_stratching == 1) {{ 'True' }} @else <i class="far fa-square"></i> @endif</td>

                </tr>
            @endif
            @if ($orderItem->printing_over_sems == 1)
                <tr>
                    <td>Printing over Seams</td>
                    <td>@if ($orderItem->printing_over_sems == 1) {{ 'True' }} @else <i class="far fa-square"></i> @endif</td>
                </tr>
            @endif

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Blank Qty</td>
                <td>Num Qty</td>
                <td>Sizes</td>
                <td colspan="100">Sequences</td>
            </tr>

            @foreach ($orderItem->orderItemDetails as $orderItemDetail)
                @if ($orderItemDetail->qty || $orderItemDetail->blanks)
                    <tr>
                        <td>{{ $orderItemDetail->blanks }}</td>
                        <td>{{ $orderItemDetail->qty }}</td>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>

                        @if (($orderItemDetail->numseq_one || $orderItemDetail->numseq_one == 0) && $orderItemDetail->numseq_one != '') <td>"{{ $orderItemDetail->numseq_one }}"</td> @endif
                        @if (($orderItemDetail->numseq_two || $orderItemDetail->numseq_two == 0) && $orderItemDetail->numseq_two != '') <td>"{{ $orderItemDetail->numseq_two }}"</td> @endif
                        @if (($orderItemDetail->numseq_three || $orderItemDetail->numseq_three == 0) && $orderItemDetail->numseq_three != '') <td>"{{ $orderItemDetail->numseq_three }}"</td> @endif
                        @if (($orderItemDetail->numseq_four || $orderItemDetail->numseq_four == 0) && $orderItemDetail->numseq_four != '') <td>"{{ $orderItemDetail->numseq_four }}"</td> @endif
                        @if (($orderItemDetail->numseq_five || $orderItemDetail->numseq_five == 0) && $orderItemDetail->numseq_five != '') <td>"{{ $orderItemDetail->numseq_five }}"</td> @endif
                        @if (($orderItemDetail->numseq_six || $orderItemDetail->numseq_six == 0) && $orderItemDetail->numseq_six != '') <td>"{{ $orderItemDetail->numseq_six }}"</td> @endif
                        @if (($orderItemDetail->numseq_seven || $orderItemDetail->numseq_seven == 0) && $orderItemDetail->numseq_seven != '') <td>"{{ $orderItemDetail->numseq_seven }}"</td> @endif
                        @if (($orderItemDetail->numseq_eight || $orderItemDetail->numseq_eight == 0) && $orderItemDetail->numseq_eight != '') <td>"{{ $orderItemDetail->numseq_eight }}"</td> @endif
                        @if (($orderItemDetail->numseq_nine || $orderItemDetail->numseq_nine == 0) && $orderItemDetail->numseq_nine != '') <td>"{{ $orderItemDetail->numseq_nine }}"</td> @endif
                        @if (($orderItemDetail->numseq_ten || $orderItemDetail->numseq_ten == 0) && $orderItemDetail->numseq_ten != '') <td>"{{ $orderItemDetail->numseq_ten }}"</td> @endif

                        @if (($orderItemDetail->numseq_eleven || $orderItemDetail->numseq_eleven == 0) && $orderItemDetail->numseq_eleven != '') <td>"{{ $orderItemDetail->numseq_eleven }}"</td> @endif
                        @if (($orderItemDetail->numseq_twelve || $orderItemDetail->numseq_twelve == 0) && $orderItemDetail->numseq_twelve != '') <td>"{{ $orderItemDetail->numseq_twelve }}"</td> @endif
                        @if (($orderItemDetail->numseq_thirteen || $orderItemDetail->numseq_thirteen == 0) && $orderItemDetail->numseq_thirteen != '') <td>"{{ $orderItemDetail->numseq_thirteen }}"</td> @endif
                        @if (($orderItemDetail->numseq_fourteen || $orderItemDetail->numseq_fourteen == 0) && $orderItemDetail->numseq_fourteen != '') <td>"{{ $orderItemDetail->numseq_fourteen }}"</td> @endif
                        @if (($orderItemDetail->numseq_fifteen || $orderItemDetail->numseq_fifteen == 0) && $orderItemDetail->numseq_fifteen != '') <td>"{{ $orderItemDetail->numseq_fifteen }}"</td> @endif
                        @if (($orderItemDetail->numseq_sixteen || $orderItemDetail->numseq_sixteen == 0) && $orderItemDetail->numseq_sixteen != '') <td>"{{ $orderItemDetail->numseq_sixteen }}"</td> @endif
                        @if (($orderItemDetail->numseq_seventeen || $orderItemDetail->numseq_seventeen == 0) && $orderItemDetail->numseq_seventeen != '') <td>"{{ $orderItemDetail->numseq_seventeen }}"</td> @endif
                        @if (($orderItemDetail->numseq_eighteen || $orderItemDetail->numseq_eighteen == 0) && $orderItemDetail->numseq_eighteen != '') <td>"{{ $orderItemDetail->numseq_eighteen }}"</td> @endif
                        @if (($orderItemDetail->numseq_nineteen || $orderItemDetail->numseq_nineteen == 0) && $orderItemDetail->numseq_nineteen != '') <td>"{{ $orderItemDetail->numseq_nineteen }}"</td> @endif
                        @if (($orderItemDetail->numseq_twenty || $orderItemDetail->numseq_twenty == 0) && $orderItemDetail->numseq_twenty != '') <td>"{{ $orderItemDetail->numseq_twenty }}"</td> @endif

                        @if (($orderItemDetail->numseq_twenty_one || $orderItemDetail->numseq_twenty_one == 0) && $orderItemDetail->numseq_twenty_one != '') <td>"{{ $orderItemDetail->numseq_twenty_one }}"</td> @endif
                        @if (($orderItemDetail->numseq_twenty_two || $orderItemDetail->numseq_twenty_two == 0) && $orderItemDetail->numseq_twenty_two != '') <td>"{{ $orderItemDetail->numseq_twenty_two }}"</td> @endif
                        @if (($orderItemDetail->numseq_twenty_three || $orderItemDetail->numseq_twenty_three == 0) && $orderItemDetail->numseq_twenty_three != '') <td>"{{ $orderItemDetail->numseq_twenty_three }}"</td> @endif
                        @if (($orderItemDetail->numseq_twenty_four || $orderItemDetail->numseq_twenty_four == 0) && $orderItemDetail->numseq_twenty_four != '') <td>"{{ $orderItemDetail->numseq_twenty_four }}"</td> @endif
                        @if (($orderItemDetail->numseq_twenty_five || $orderItemDetail->numseq_twenty_five == 0) && $orderItemDetail->numseq_twenty_five != '') <td>"{{ $orderItemDetail->numseq_twenty_five }}"</td> @endif
                        @if (($orderItemDetail->numseq_twenty_six || $orderItemDetail->numseq_twenty_six == 0) && $orderItemDetail->numseq_twenty_six != '') <td>"{{ $orderItemDetail->numseq_twenty_six }}"</td> @endif
                        @if (($orderItemDetail->numseq_twenty_seven || $orderItemDetail->numseq_twenty_seven == 0) && $orderItemDetail->numseq_twenty_seven != '') <td>"{{ $orderItemDetail->numseq_twenty_seven }}"</td> @endif
                        @if (($orderItemDetail->numseq_twenty_eight || $orderItemDetail->numseq_twenty_eight == 0) && $orderItemDetail->numseq_twenty_eight != '') <td>"{{ $orderItemDetail->numseq_twenty_eight }}"</td> @endif
                        @if (($orderItemDetail->numseq_twenty_nine || $orderItemDetail->numseq_twenty_nine == 0) && $orderItemDetail->numseq_twenty_nine != '') <td>"{{ $orderItemDetail->numseq_twenty_nine }}"</td> @endif
                        @if (($orderItemDetail->numseq_thirty || $orderItemDetail->numseq_thirty == 0) && $orderItemDetail->numseq_thirty != '') <td>"{{ $orderItemDetail->numseq_thirty }}"</td> @endif

                        @if (($orderItemDetail->numseq_thirty_one || $orderItemDetail->numseq_thirty_one == 0) && $orderItemDetail->numseq_thirty_one != '') <td>"{{ $orderItemDetail->numseq_thirty_one }}"</td> @endif
                        @if (($orderItemDetail->numseq_thirty_two || $orderItemDetail->numseq_thirty_two == 0) && $orderItemDetail->numseq_thirty_two != '') <td>"{{ $orderItemDetail->numseq_thirty_two }}"</td> @endif
                        @if (($orderItemDetail->numseq_thirty_three || $orderItemDetail->numseq_thirty_three == 0) && $orderItemDetail->numseq_thirty_three != '') <td>"{{ $orderItemDetail->numseq_thirty_three }}"</td> @endif
                        @if (($orderItemDetail->numseq_thirty_four || $orderItemDetail->numseq_thirty_four == 0) && $orderItemDetail->numseq_thirty_four != '') <td>"{{ $orderItemDetail->numseq_thirty_four }}"</td> @endif
                        @if (($orderItemDetail->numseq_thirty_five || $orderItemDetail->numseq_thirty_five == 0) && $orderItemDetail->numseq_thirty_five != '') <td>"{{ $orderItemDetail->numseq_thirty_five }}"</td> @endif
                        @if (($orderItemDetail->numseq_thirty_six || $orderItemDetail->numseq_thirty_six == 0) && $orderItemDetail->numseq_thirty_six != '') <td>"{{ $orderItemDetail->numseq_thirty_six }}"</td> @endif
                        @if (($orderItemDetail->numseq_thirty_seven || $orderItemDetail->numseq_thirty_seven == 0) && $orderItemDetail->numseq_thirty_seven != '') <td>"{{ $orderItemDetail->numseq_thirty_seven }}"</td> @endif
                        @if (($orderItemDetail->numseq_thirty_eight || $orderItemDetail->numseq_thirty_eight == 0) && $orderItemDetail->numseq_thirty_eight != '') <td>"{{ $orderItemDetail->numseq_thirty_eight }}"</td> @endif
                        @if (($orderItemDetail->numseq_thirty_nine || $orderItemDetail->numseq_thirty_nine == 0) && $orderItemDetail->numseq_thirty_nine != '') <td>"{{ $orderItemDetail->numseq_thirty_nine }}"</td> @endif
                        @if (($orderItemDetail->numseq_forty || $orderItemDetail->numseq_forty == 0) && $orderItemDetail->numseq_forty != '') <td>"{{ $orderItemDetail->numseq_forty }}"</td> @endif

                        @if (($orderItemDetail->numseq_forty_one || $orderItemDetail->numseq_forty_one == 0) && $orderItemDetail->numseq_forty_one != '') <td>"{{ $orderItemDetail->numseq_forty_one }}"</td> @endif
                        @if (($orderItemDetail->numseq_forty_two || $orderItemDetail->numseq_forty_two == 0) && $orderItemDetail->numseq_forty_two != '') <td>"{{ $orderItemDetail->numseq_forty_two }}"</td> @endif
                        @if (($orderItemDetail->numseq_forty_three || $orderItemDetail->numseq_forty_three == 0) && $orderItemDetail->numseq_forty_three != '') <td>"{{ $orderItemDetail->numseq_forty_three }}"</td> @endif
                        @if (($orderItemDetail->numseq_forty_four || $orderItemDetail->numseq_forty_four == 0) && $orderItemDetail->numseq_forty_four != '') <td>"{{ $orderItemDetail->numseq_forty_four }}"</td> @endif
                        @if (($orderItemDetail->numseq_forty_five || $orderItemDetail->numseq_forty_five == 0) && $orderItemDetail->numseq_forty_five != '') <td>"{{ $orderItemDetail->numseq_forty_five }}"</td> @endif
                        @if (($orderItemDetail->numseq_forty_six || $orderItemDetail->numseq_forty_six == 0) && $orderItemDetail->numseq_forty_six != '') <td>"{{ $orderItemDetail->numseq_forty_six }}"</td> @endif
                        @if (($orderItemDetail->numseq_forty_seven || $orderItemDetail->numseq_forty_seven == 0) && $orderItemDetail->numseq_forty_seven != '') <td>"{{ $orderItemDetail->numseq_forty_seven }}"</td> @endif
                        @if (($orderItemDetail->numseq_forty_eight || $orderItemDetail->numseq_forty_eight == 0) && $orderItemDetail->numseq_forty_eight != '') <td>"{{ $orderItemDetail->numseq_forty_eight }}"</td> @endif
                        @if (($orderItemDetail->numseq_forty_nine || $orderItemDetail->numseq_forty_nine == 0) && $orderItemDetail->numseq_forty_nine != '') <td>"{{ $orderItemDetail->numseq_forty_nine }}"</td> @endif
                        @if (($orderItemDetail->numseq_fifty || $orderItemDetail->numseq_fifty == 0) && $orderItemDetail->numseq_fifty != '') <td>"{{ $orderItemDetail->numseq_fifty }}"</td> @endif

                        @if (($orderItemDetail->numseq_fifty_one || $orderItemDetail->numseq_fifty_one == 0) && $orderItemDetail->numseq_fifty_one != '') <td>"{{ $orderItemDetail->numseq_fifty_one }}"</td> @endif
                        @if (($orderItemDetail->numseq_fifty_two || $orderItemDetail->numseq_fifty_two == 0) && $orderItemDetail->numseq_fifty_two != '') <td>"{{ $orderItemDetail->numseq_fifty_two }}"</td> @endif
                        @if (($orderItemDetail->numseq_fifty_three || $orderItemDetail->numseq_fifty_three == 0) && $orderItemDetail->numseq_fifty_three != '') <td>"{{ $orderItemDetail->numseq_fifty_three }}"</td> @endif
                        @if (($orderItemDetail->numseq_fifty_four || $orderItemDetail->numseq_fifty_four == 0) && $orderItemDetail->numseq_fifty_four != '') <td>"{{ $orderItemDetail->numseq_fifty_four }}"</td> @endif
                        @if (($orderItemDetail->numseq_fifty_five || $orderItemDetail->numseq_fifty_five == 0) && $orderItemDetail->numseq_fifty_five != '') <td>"{{ $orderItemDetail->numseq_fifty_five }}"</td> @endif
                        @if (($orderItemDetail->numseq_fifty_six || $orderItemDetail->numseq_fifty_six == 0) && $orderItemDetail->numseq_fifty_six != '') <td>"{{ $orderItemDetail->numseq_fifty_six }}"</td> @endif
                        @if (($orderItemDetail->numseq_fifty_seven || $orderItemDetail->numseq_fifty_seven == 0) && $orderItemDetail->numseq_fifty_seven != '') <td>"{{ $orderItemDetail->numseq_fifty_seven }}"</td> @endif
                        @if (($orderItemDetail->numseq_fifty_eight || $orderItemDetail->numseq_fifty_eight == 0) && $orderItemDetail->numseq_fifty_eight != '') <td>"{{ $orderItemDetail->numseq_fifty_eight }}"</td> @endif
                        @if (($orderItemDetail->numseq_fifty_nine || $orderItemDetail->numseq_fifty_nine == 0) && $orderItemDetail->numseq_fifty_nine != '') <td>"{{ $orderItemDetail->numseq_fifty_nine }}"</td> @endif
                        @if (($orderItemDetail->numseq_sixty || $orderItemDetail->numseq_sixty == 0) && $orderItemDetail->numseq_sixty != '') <td>"{{ $orderItemDetail->numseq_sixty }}"</td> @endif

                        @if (($orderItemDetail->numseq_sixty_one || $orderItemDetail->numseq_sixty_one == 0) && $orderItemDetail->numseq_sixty_one != '') <td>"{{ $orderItemDetail->numseq_sixty_one }}"</td> @endif
                        @if (($orderItemDetail->numseq_sixty_two || $orderItemDetail->numseq_sixty_two == 0) && $orderItemDetail->numseq_sixty_two != '') <td>"{{ $orderItemDetail->numseq_sixty_two }}"</td> @endif
                        @if (($orderItemDetail->numseq_sixty_three || $orderItemDetail->numseq_sixty_three == 0) && $orderItemDetail->numseq_sixty_three != '') <td>"{{ $orderItemDetail->numseq_sixty_three }}"</td> @endif
                        @if (($orderItemDetail->numseq_sixty_four || $orderItemDetail->numseq_sixty_four == 0) && $orderItemDetail->numseq_sixty_four != '') <td>"{{ $orderItemDetail->numseq_sixty_four }}"</td> @endif
                        @if (($orderItemDetail->numseq_sixty_five || $orderItemDetail->numseq_sixty_five == 0) && $orderItemDetail->numseq_sixty_five != '') <td>"{{ $orderItemDetail->numseq_sixty_five }}"</td> @endif
                        @if (($orderItemDetail->numseq_sixty_six || $orderItemDetail->numseq_sixty_six == 0) && $orderItemDetail->numseq_sixty_six != '') <td>"{{ $orderItemDetail->numseq_sixty_six }}"</td> @endif
                        @if (($orderItemDetail->numseq_sixty_seven || $orderItemDetail->numseq_sixty_seven == 0) && $orderItemDetail->numseq_sixty_seven != '') <td>"{{ $orderItemDetail->numseq_sixty_seven }}"</td> @endif
                        @if (($orderItemDetail->numseq_sixty_eight || $orderItemDetail->numseq_sixty_eight == 0) && $orderItemDetail->numseq_sixty_eight != '') <td>"{{ $orderItemDetail->numseq_sixty_eight }}"</td> @endif
                        @if (($orderItemDetail->numseq_sixty_nine || $orderItemDetail->numseq_sixty_nine == 0) && $orderItemDetail->numseq_sixty_nine != '') <td>"{{ $orderItemDetail->numseq_sixty_nine }}"</td> @endif
                        @if (($orderItemDetail->numseq_seventy || $orderItemDetail->numseq_seventy == 0) && $orderItemDetail->numseq_seventy != '') <td>"{{ $orderItemDetail->numseq_seventy }}"</td> @endif

                        @if (($orderItemDetail->numseq_seventy_one || $orderItemDetail->numseq_seventy_one == 0) && $orderItemDetail->numseq_seventy_one != '') <td>"{{ $orderItemDetail->numseq_seventy_one }}"</td> @endif
                        @if (($orderItemDetail->numseq_seventy_two || $orderItemDetail->numseq_seventy_two == 0) && $orderItemDetail->numseq_seventy_two != '') <td>"{{ $orderItemDetail->numseq_seventy_two }}"</td> @endif
                        @if (($orderItemDetail->numseq_seventy_three || $orderItemDetail->numseq_seventy_three == 0) && $orderItemDetail->numseq_seventy_three != '') <td>"{{ $orderItemDetail->numseq_seventy_three }}"</td> @endif
                        @if (($orderItemDetail->numseq_seventy_four || $orderItemDetail->numseq_seventy_four == 0) && $orderItemDetail->numseq_seventy_four != '') <td>"{{ $orderItemDetail->numseq_seventy_four }}"</td> @endif
                        @if (($orderItemDetail->numseq_seventy_five || $orderItemDetail->numseq_seventy_five == 0) && $orderItemDetail->numseq_seventy_five != '') <td>"{{ $orderItemDetail->numseq_seventy_five }}"</td> @endif
                        @if (($orderItemDetail->numseq_seventy_six || $orderItemDetail->numseq_seventy_six == 0) && $orderItemDetail->numseq_seventy_six != '') <td>"{{ $orderItemDetail->numseq_seventy_six }}"</td> @endif
                        @if (($orderItemDetail->numseq_seventy_seven || $orderItemDetail->numseq_seventy_seven == 0) && $orderItemDetail->numseq_seventy_seven != '') <td>"{{ $orderItemDetail->numseq_seventy_seven }}"</td> @endif
                        @if (($orderItemDetail->numseq_seventy_eight || $orderItemDetail->numseq_seventy_eight == 0) && $orderItemDetail->numseq_seventy_eight != '') <td>"{{ $orderItemDetail->numseq_seventy_eight }}"</td> @endif
                        @if (($orderItemDetail->numseq_seventy_nine || $orderItemDetail->numseq_seventy_nine == 0) && $orderItemDetail->numseq_seventy_nine != '') <td>"{{ $orderItemDetail->numseq_seventy_nine }}"</td> @endif
                        @if (($orderItemDetail->numseq_eighty || $orderItemDetail->numseq_eighty == 0) && $orderItemDetail->numseq_eighty != '') <td>"{{ $orderItemDetail->numseq_eighty }}"</td> @endif

                        @if (($orderItemDetail->numseq_eighty_one || $orderItemDetail->numseq_eighty_one == 0) && $orderItemDetail->numseq_eighty_one != '') <td>"{{ $orderItemDetail->numseq_eighty_one }}"</td> @endif
                        @if (($orderItemDetail->numseq_eighty_two || $orderItemDetail->numseq_eighty_two == 0) && $orderItemDetail->numseq_eighty_two != '') <td>"{{ $orderItemDetail->numseq_eighty_two }}"</td> @endif
                        @if (($orderItemDetail->numseq_eighty_three || $orderItemDetail->numseq_eighty_three == 0) && $orderItemDetail->numseq_eighty_three != '') <td>"{{ $orderItemDetail->numseq_eighty_three }}"</td> @endif
                        @if (($orderItemDetail->numseq_eighty_four || $orderItemDetail->numseq_eighty_four == 0) && $orderItemDetail->numseq_eighty_four != '') <td>"{{ $orderItemDetail->numseq_eighty_four }}"</td> @endif
                        @if (($orderItemDetail->numseq_eighty_five || $orderItemDetail->numseq_eighty_five == 0) && $orderItemDetail->numseq_eighty_five != '') <td>"{{ $orderItemDetail->numseq_eighty_five }}"</td> @endif
                        @if (($orderItemDetail->numseq_eighty_six || $orderItemDetail->numseq_eighty_six == 0) && $orderItemDetail->numseq_eighty_six != '') <td>"{{ $orderItemDetail->numseq_eighty_six }}"</td> @endif
                        @if (($orderItemDetail->numseq_eighty_seven || $orderItemDetail->numseq_eighty_seven == 0) && $orderItemDetail->numseq_eighty_seven != '') <td>"{{ $orderItemDetail->numseq_eighty_seven }}"</td> @endif
                        @if (($orderItemDetail->numseq_eighty_eight || $orderItemDetail->numseq_eighty_eight == 0) && $orderItemDetail->numseq_eighty_eight != '') <td>"{{ $orderItemDetail->numseq_eighty_eight }}"</td> @endif
                        @if (($orderItemDetail->numseq_eighty_nine || $orderItemDetail->numseq_eighty_nine == 0) && $orderItemDetail->numseq_eighty_nine != '') <td>"{{ $orderItemDetail->numseq_eighty_nine }}"</td> @endif
                        @if (($orderItemDetail->numseq_ninety || $orderItemDetail->numseq_ninety == 0) && $orderItemDetail->numseq_ninety != '') <td>"{{ $orderItemDetail->numseq_ninety }}"</td> @endif

                        @if (($orderItemDetail->numseq_ninety_one || $orderItemDetail->numseq_ninety_one == 0) && $orderItemDetail->numseq_ninety_one != '') <td>"{{ $orderItemDetail->numseq_ninety_one }}"</td> @endif
                        @if (($orderItemDetail->numseq_ninety_two || $orderItemDetail->numseq_ninety_two == 0) && $orderItemDetail->numseq_ninety_two != '') <td>"{{ $orderItemDetail->numseq_ninety_two }}"</td> @endif
                        @if (($orderItemDetail->numseq_ninety_three || $orderItemDetail->numseq_ninety_three == 0) && $orderItemDetail->numseq_ninety_three != '') <td>"{{ $orderItemDetail->numseq_ninety_three }}"</td> @endif
                        @if (($orderItemDetail->numseq_ninety_four || $orderItemDetail->numseq_ninety_four == 0) && $orderItemDetail->numseq_ninety_four != '') <td>"{{ $orderItemDetail->numseq_ninety_four }}"</td> @endif
                        @if (($orderItemDetail->numseq_ninety_five || $orderItemDetail->numseq_ninety_five == 0) && $orderItemDetail->numseq_ninety_five != '') <td>"{{ $orderItemDetail->numseq_ninety_five }}"</td> @endif
                        @if (($orderItemDetail->numseq_ninety_six || $orderItemDetail->numseq_ninety_six == 0) && $orderItemDetail->numseq_ninety_six != '') <td>"{{ $orderItemDetail->numseq_ninety_six }}"</td> @endif
                        @if (($orderItemDetail->numseq_ninety_seven || $orderItemDetail->numseq_ninety_seven == 0) && $orderItemDetail->numseq_ninety_seven != '') <td>"{{ $orderItemDetail->numseq_ninety_seven }}"</td> @endif
                        @if (($orderItemDetail->numseq_ninety_eight || $orderItemDetail->numseq_ninety_eight == 0) && $orderItemDetail->numseq_ninety_eight != '') <td>"{{ $orderItemDetail->numseq_ninety_eight }}"</td> @endif
                        @if (($orderItemDetail->numseq_ninety_nine || $orderItemDetail->numseq_ninety_nine == 0) && $orderItemDetail->numseq_ninety_nine != '') <td>"{{ $orderItemDetail->numseq_ninety_nine }}"</td> @endif
                        @if (($orderItemDetail->numseq_hundred || $orderItemDetail->numseq_hundred == 0) && $orderItemDetail->numseq_hundred != '') <td>"{{ $orderItemDetail->numseq_hundred }}"</td> @endif
                    </tr>
                @endif
            @endforeach

            <tr>
                <td>Total Blank Qty</td>
                <td>Total Num Qty</td>
                <td>Total Qty</td>
                <td></td>
            </tr>
            <tr>
                <td>@php
                    $totalBlank = 0;
                    foreach ($orderItem->orderItemDetails as $orderItemDetail) {
                        $totalBlank += $orderItemDetail->blanks;
                    }
                @endphp {{ $totalBlank }} </td>
                <td>@php
                    $totalNum = 0;
                    foreach ($orderItem->orderItemDetails as $orderItemDetail) {
                        $totalNum += $orderItemDetail->qty;
                    }
                @endphp {{ $totalNum }} </td>
                <td>{{ $orderItem->qty ?? 0 }}</td>
                <td colspan="50"></td>
            </tr>

            <tr></tr>

            <tr>
                <td>Sizes</td>
                <td>Player Numbers</td>
                <td>Player Names</td>
            </tr>

            @foreach ($orderItem->orderItemDetails as $orderItemDetail)
                {{-- Player Name 1 to 10 --}}
                @if (($orderItemDetail->numseq_one || $orderItemDetail->numseq_one == 0) && !empty($orderItemDetail->playerDetails->player_one))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_one }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_one ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_two || $orderItemDetail->numseq_two == 0) && !empty($orderItemDetail->playerDetails->player_two))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_two }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_two ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_three || $orderItemDetail->numseq_three == 0) && !empty($orderItemDetail->playerDetails->player_three))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_three }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_three ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_four || $orderItemDetail->numseq_four == 0) && !empty($orderItemDetail->playerDetails->player_four))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_four }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_four ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_five || $orderItemDetail->numseq_five == 0) && !empty($orderItemDetail->playerDetails->player_five))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_five }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_five ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_six || $orderItemDetail->numseq_six == 0) && !empty($orderItemDetail->playerDetails->player_six))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_six }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_six ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_seven || $orderItemDetail->numseq_seven == 0) && !empty($orderItemDetail->playerDetails->player_seven))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_seven }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_seven ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_eight || $orderItemDetail->numseq_eight == 0) && !empty($orderItemDetail->playerDetails->player_eight))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_eight }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_eight ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_nine || $orderItemDetail->numseq_nine == 0) && !empty($orderItemDetail->playerDetails->player_nine))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_nine }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_nine ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_ten || $orderItemDetail->numseq_ten == 0) && !empty($orderItemDetail->playerDetails->player_ten))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_ten }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_ten ?? '' }} </td>
                    </tr>
                @endif

                {{-- Player Name 11 to 20 --}}
                @if (($orderItemDetail->numseq_eleven || $orderItemDetail->numseq_eleven == 0) && !empty($orderItemDetail->playerDetails->numseq_eleven))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_eleven }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->numseq_eleven ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_twelve || $orderItemDetail->numseq_twelve == 0) && !empty($orderItemDetail->playerDetails->player_twelve))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_twelve }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_twelve ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_thirteen || $orderItemDetail->numseq_thirteen == 0) && !empty($orderItemDetail->playerDetails->player_thirteen))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_thirteen }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_thirteen ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_fourteen || $orderItemDetail->numseq_fourteen == 0) && !empty($orderItemDetail->playerDetails->player_fourteen))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_fourteen }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_fourteen ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_fifteen || $orderItemDetail->numseq_fifteen == 0) && !empty($orderItemDetail->playerDetails->player_fifteen))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_fifteen }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_fifteen ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_sixteen || $orderItemDetail->numseq_sixteen == 0) && !empty($orderItemDetail->playerDetails->player_sixteen))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_sixteen }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_sixteen ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_seventeen || $orderItemDetail->numseq_seventeen == 0) && !empty($orderItemDetail->playerDetails->player_seventeen))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_seventeen }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_seventeen ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_eighteen || $orderItemDetail->numseq_eighteen == 0) && !empty($orderItemDetail->playerDetails->player_eighteen))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_eighteen }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_eighteen ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_nineteen || $orderItemDetail->numseq_nineteen == 0) && !empty($orderItemDetail->playerDetails->player_nineteen))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_nineteen }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_nineteen ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_twenty || $orderItemDetail->numseq_twenty == 0) && !empty($orderItemDetail->playerDetails->player_twenty))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_twenty }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_twenty ?? '' }} </td>
                    </tr>
                @endif

                {{-- Player Name 21 to 30 --}}
                @if (($orderItemDetail->numseq_twenty_one || $orderItemDetail->numseq_twenty_one == 0) && !empty($orderItemDetail->playerDetails->player_twenty_one))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_twenty_one }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_twenty_one ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_twenty_two || $orderItemDetail->numseq_twenty_two == 0) && !empty($orderItemDetail->playerDetails->player_twenty_two))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_twenty_two }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_twenty_two ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_twenty_three || $orderItemDetail->numseq_twenty_three == 0) && !empty($orderItemDetail->playerDetails->player_twenty_three))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_twenty_three }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_twenty_three ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_twenty_four || $orderItemDetail->numseq_twenty_four == 0) && !empty($orderItemDetail->playerDetails->player_twenty_four))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_twenty_four }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_twenty_four ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_twenty_five || $orderItemDetail->numseq_twenty_five == 0) && !empty($orderItemDetail->playerDetails->player_twenty_five))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_twenty_five }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_twenty_five ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_twenty_six || $orderItemDetail->numseq_twenty_six == 0) && !empty($orderItemDetail->playerDetails->player_twenty_six))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_twenty_six }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_twenty_six ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_twenty_seven || $orderItemDetail->numseq_twenty_seven == 0) && !empty($orderItemDetail->playerDetails->player_twenty_seven))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_twenty_seven }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_twenty_seven ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_twenty_eight || $orderItemDetail->numseq_twenty_eight == 0) && !empty($orderItemDetail->playerDetails->player_twenty_eight))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_twenty_eight }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_twenty_eight ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_twenty_nine || $orderItemDetail->numseq_twenty_nine == 0) && !empty($orderItemDetail->playerDetails->player_twenty_nine))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_twenty_nine }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_twenty_nine ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_thirty || $orderItemDetail->numseq_thirty == 0) && !empty($orderItemDetail->playerDetails->player_thirty))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_thirty }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_thirty ?? '' }} </td>
                    </tr>
                @endif

                {{-- Player Name 31 to 40 --}}
                @if (($orderItemDetail->numseq_thirty_one || $orderItemDetail->numseq_thirty_one == 0) && !empty($orderItemDetail->playerDetails->player_thirty_one))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_thirty_one }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_thirty_one ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_thirty_two || $orderItemDetail->numseq_thirty_two == 0) && !empty($orderItemDetail->playerDetails->player_thirty_two))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_thirty_two }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_thirty_two ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_thirty_three || $orderItemDetail->numseq_thirty_three == 0) && !empty($orderItemDetail->playerDetails->player_thirty_three))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_thirty_three }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_thirty_three ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_thirty_four || $orderItemDetail->numseq_thirty_four == 0) && !empty($orderItemDetail->playerDetails->player_thirty_four))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_thirty_four }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_thirty_four ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_thirty_five || $orderItemDetail->numseq_thirty_five == 0) && !empty($orderItemDetail->playerDetails->player_thirty_five))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_thirty_five }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_thirty_five ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_thirty_six || $orderItemDetail->numseq_thirty_six == 0) && !empty($orderItemDetail->playerDetails->player_thirty_six))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_thirty_six }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_thirty_six ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_thirty_seven || $orderItemDetail->numseq_thirty_seven == 0) && !empty($orderItemDetail->playerDetails->player_thirty_seven))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_thirty_seven }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_thirty_seven ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_thirty_eight || $orderItemDetail->numseq_thirty_eight == 0) && !empty($orderItemDetail->playerDetails->player_thirty_eight))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_thirty_eight }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_thirty_eight ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_thirty_nine || $orderItemDetail->numseq_thirty_nine == 0) && !empty($orderItemDetail->playerDetails->player_thirty_nine))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_thirty_nine }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_thirty_nine ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_forty || $orderItemDetail->numseq_forty == 0) && !empty($orderItemDetail->playerDetails->player_forty))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_forty }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_forty ?? '' }} </td>
                    </tr>
                @endif

                {{-- Player Name 41 to 50 --}}
                @if (($orderItemDetail->numseq_forty_one || $orderItemDetail->numseq_forty_one == 0) && !empty($orderItemDetail->playerDetails->player_forty_one))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_forty_one }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_forty_one ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_forty_two || $orderItemDetail->numseq_forty_two == 0) && !empty($orderItemDetail->playerDetails->player_forty_two))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_forty_two }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_forty_two ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_forty_three || $orderItemDetail->numseq_forty_three == 0) && !empty($orderItemDetail->playerDetails->player_forty_three))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_forty_three }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_forty_three ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_forty_four || $orderItemDetail->numseq_forty_four == 0) && !empty($orderItemDetail->playerDetails->player_forty_four))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_forty_four }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_forty_four ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_forty_five || $orderItemDetail->numseq_forty_five == 0) && !empty($orderItemDetail->playerDetails->player_forty_five))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_forty_five }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_forty_five ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_forty_six || $orderItemDetail->numseq_forty_six == 0) && !empty($orderItemDetail->playerDetails->player_forty_six))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_forty_six }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_forty_six ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_forty_seven || $orderItemDetail->numseq_forty_seven == 0) && !empty($orderItemDetail->playerDetails->player_forty_seven))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_forty_seven }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_forty_seven ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_forty_eight || $orderItemDetail->numseq_forty_eight == 0) && !empty($orderItemDetail->playerDetails->player_forty_eight))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_forty_eight }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_forty_eight ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_forty_nine || $orderItemDetail->numseq_forty_nine == 0) && !empty($orderItemDetail->playerDetails->player_forty_nine))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_forty_nine }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_forty_nine ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_fifty || $orderItemDetail->numseq_fifty == 0) && !empty($orderItemDetail->playerDetails->player_fifty))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_fifty }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_fifty ?? '' }} </td>
                    </tr>
                @endif

                {{-- Player Name 51 to 60 --}}
                @if (($orderItemDetail->numseq_fifty_one || $orderItemDetail->numseq_fifty == 0) && !empty($orderItemDetail->playerDetails->player_fifty_one))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_fifty_one }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_fifty_one ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_fifty_two || $orderItemDetail->numseq_fifty_two == 0) && !empty($orderItemDetail->playerDetails->player_fifty_two))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_fifty_two }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_fifty_two ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_fifty_three || $orderItemDetail->numseq_fifty_three == 0) && !empty($orderItemDetail->playerDetails->player_fifty_three))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_fifty_three }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_fifty_three ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_fifty_four || $orderItemDetail->numseq_fifty_four == 0) && !empty($orderItemDetail->playerDetails->player_fifty_four))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_fifty_four }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_fifty_four ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_fifty_five || $orderItemDetail->numseq_fifty_five == 0) && !empty($orderItemDetail->playerDetails->player_fifty_five))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_fifty_five }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_fifty_five ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_fifty_six || $orderItemDetail->numseq_fifty_six == 0) && !empty($orderItemDetail->playerDetails->player_fifty_six))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_fifty_six }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_fifty_six ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_fifty_seven || $orderItemDetail->numseq_fifty_seven == 0) && !empty($orderItemDetail->playerDetails->player_fifty_seven))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_fifty_seven }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_fifty_seven ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_fifty_eight || $orderItemDetail->numseq_fifty_eight == 0) && !empty($orderItemDetail->playerDetails->player_fifty_eight))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_fifty_eight }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_fifty_eight ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_fifty_nine || $orderItemDetail->numseq_fifty_nine == 0) && !empty($orderItemDetail->playerDetails->player_fifty_nine))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_fifty_nine }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_fifty_nine ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_sixty || $orderItemDetail->numseq_sixty == 0) && !empty($orderItemDetail->playerDetails->player_sixty))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_sixty }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_sixty ?? '' }} </td>
                    </tr>
                @endif

                {{-- Player Name 61 to 70 --}}
                @if (($orderItemDetail->numseq_sixty_one || $orderItemDetail->numseq_sixty_one == 0) && !empty($orderItemDetail->playerDetails->player_sixty_one))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_sixty_one }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_sixty_one ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_sixty_two || $orderItemDetail->numseq_sixty_two == 0) && !empty($orderItemDetail->playerDetails->player_sixty_two))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_sixty_two }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_sixty_two ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_sixty_three || $orderItemDetail->numseq_sixty_three == 0) && !empty($orderItemDetail->playerDetails->player_sixty_three))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_sixty_three }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_sixty_three ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_sixty_four || $orderItemDetail->numseq_sixty_four == 0) && !empty($orderItemDetail->playerDetails->player_sixty_four))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_sixty_four }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_sixty_four ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_sixty_five || $orderItemDetail->numseq_sixty_five == 0) && !empty($orderItemDetail->playerDetails->player_sixty_five))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_sixty_five }}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_sixty_five ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_sixty_six || $orderItemDetail->numseq_sixty_six == 0) && !empty($orderItemDetail->playerDetails->player_sixty_six))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_sixty_six}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_sixty_six ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_sixty_seven || $orderItemDetail->numseq_sixty_seven == 0) && !empty($orderItemDetail->playerDetails->player_sixty_seven))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_sixty_seven}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_sixty_seven ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_sixty_eight || $orderItemDetail->numseq_sixty_eight == 0) && !empty($orderItemDetail->playerDetails->player_sixty_eight))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_sixty_eight}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_sixty_eight ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_sixty_nine || $orderItemDetail->numseq_sixty_nine == 0) && !empty($orderItemDetail->playerDetails->player_sixty_nine))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_sixty_nine}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_sixty_nine ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_seventy || $orderItemDetail->numseq_seventy == 0) && !empty($orderItemDetail->playerDetails->player_seventy))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_seventy}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_seventy ?? '' }} </td>
                    </tr>
                @endif


                {{-- Player Name 71 to 80 --}}
                @if (($orderItemDetail->numseq_seventy_one || $orderItemDetail->numseq_seventy_one == 0) && !empty($orderItemDetail->playerDetails->player_seventy_one))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_seventy_one}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_seventy_one ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_seventy_two || $orderItemDetail->numseq_seventy_two == 0) && !empty($orderItemDetail->playerDetails->player_seventy_two))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_seventy_two}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_seventy_two ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_seventy_three || $orderItemDetail->numseq_seventy_three == 0) && !empty($orderItemDetail->playerDetails->player_seventy_three))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_seventy_three}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_seventy_three ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_seventy_four || $orderItemDetail->numseq_seventy_four == 0) && !empty($orderItemDetail->playerDetails->player_seventy_four))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_seventy_four}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_seventy_four ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_seventy_five || $orderItemDetail->numseq_seventy_five == 0) && !empty($orderItemDetail->playerDetails->player_seventy_five))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_seventy_five}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_seventy_five ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_seventy_six || $orderItemDetail->numseq_seventy_six == 0) && !empty($orderItemDetail->playerDetails->player_seventy_six))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_seventy_six}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_seventy_six ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_seventy_seven || $orderItemDetail->numseq_seventy_seven == 0) && !empty($orderItemDetail->playerDetails->player_seventy_seven))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_seventy_seven}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_seventy_seven ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_seventy_eight || $orderItemDetail->numseq_seventy_eight == 0) && !empty($orderItemDetail->playerDetails->player_seventy_eight))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_seventy_eight}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_seventy_eight ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_seventy_nine || $orderItemDetail->numseq_seventy_nine == 0) && !empty($orderItemDetail->playerDetails->player_seventy_nine))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_seventy_nine}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_seventy_nine ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_eighty || $orderItemDetail->numseq_eighty == 0) && !empty($orderItemDetail->playerDetails->player_eighty))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_eighty}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_eighty ?? '' }} </td>
                    </tr>
                @endif


                {{-- Player Name 81 to 90 --}}
                @if (($orderItemDetail->numseq_eighty_one || $orderItemDetail->numseq_eighty_one == 0) && !empty($orderItemDetail->playerDetails->player_eighty_one))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_eighty_one}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_eighty_one ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_eighty_two || $orderItemDetail->numseq_eighty_two == 0) && !empty($orderItemDetail->playerDetails->player_eighty_two))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_eighty_two}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_eighty_two ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_eighty_three || $orderItemDetail->numseq_eighty_three == 0) && !empty($orderItemDetail->playerDetails->player_eighty_three))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_eighty_three}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_eighty_three ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_eighty_four || $orderItemDetail->numseq_eighty_four == 0) && !empty($orderItemDetail->playerDetails->player_eighty_four))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_eighty_four}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_eighty_four ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_eighty_five || $orderItemDetail->numseq_eighty_five == 0) && !empty($orderItemDetail->playerDetails->player_eighty_five))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_eighty_five}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_eighty_five ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_eighty_six || $orderItemDetail->numseq_eighty_six == 0) && !empty($orderItemDetail->playerDetails->player_eighty_six))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_eighty_six}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_eighty_six ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_eighty_seven || $orderItemDetail->numseq_eighty_seven == 0) && !empty($orderItemDetail->playerDetails->player_eighty_seven))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_eighty_seven}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_eighty_seven ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_eighty_eight || $orderItemDetail->numseq_eighty_eight == 0) && !empty($orderItemDetail->playerDetails->player_eighty_eight))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_eighty_eight}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_eighty_eight ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_eighty_nine || $orderItemDetail->numseq_eighty_nine == 0) && !empty($orderItemDetail->playerDetails->player_eighty_nine))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_eighty_nine}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_eighty_nine ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_ninety || $orderItemDetail->numseq_ninety == 0) && !empty($orderItemDetail->playerDetails->player_ninety))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_ninety}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_ninety ?? '' }} </td>
                    </tr>
                @endif

                {{-- Player Name 91 to 100 --}}
                @if (($orderItemDetail->numseq_ninety_one || $orderItemDetail->numseq_ninety_one == 0) && !empty($orderItemDetail->playerDetails->player_ninety_one))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_ninety_one}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_ninety_one ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_ninety_two || $orderItemDetail->numseq_ninety_two == 0) && !empty($orderItemDetail->playerDetails->player_ninety_two))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_ninety_two}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_ninety_two ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_ninety_three || $orderItemDetail->numseq_ninety_three == 0) && !empty($orderItemDetail->playerDetails->player_ninety_three))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_ninety_three}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_ninety_three ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_ninety_four || $orderItemDetail->numseq_ninety_four == 0) && !empty($orderItemDetail->playerDetails->player_ninety_four))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_ninety_four}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_ninety_four ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_ninety_five || $orderItemDetail->numseq_ninety_five == 0) && !empty($orderItemDetail->playerDetails->player_ninety_five))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_ninety_five}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_ninety_five ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_ninety_six || $orderItemDetail->numseq_ninety_six == 0) && !empty($orderItemDetail->playerDetails->player_ninety_six))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_ninety_six}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_ninety_six ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_ninety_seven || $orderItemDetail->numseq_ninety_seven == 0) && !empty($orderItemDetail->playerDetails->player_ninety_seven))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_ninety_seven}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_ninety_seven ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_ninety_eight || $orderItemDetail->numseq_ninety_eight == 0) && !empty($orderItemDetail->playerDetails->player_ninety_eight))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_ninety_eight}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_ninety_eight ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_ninety_nine || $orderItemDetail->numseq_ninety_nine == 0) && !empty($orderItemDetail->playerDetails->player_ninety_nine))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_ninety_nine}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_ninety_nine ?? '' }} </td>
                    </tr>
                @endif

                @if (($orderItemDetail->numseq_hundred || $orderItemDetail->numseq_hundred == 0) && !empty($orderItemDetail->playerDetails->player_hundred))
                    <tr>
                        <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                        <td>"{{ $orderItemDetail->numseq_hundred}}"</td>
                        <td>{{ $orderItemDetail->playerDetails->player_hundred ?? '' }} </td>
                    </tr>
                @endif

                @if (!empty($orderItemDetail->playerDetails->blank_qty) && !empty($orderItemDetail->playerDetails->blank_player_names))
                    @foreach (json_decode($orderItemDetail->playerDetails->blank_player_names) as $playerName)
                        @if ($playerName)
                            <tr>
                                <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>
                                <td></td>
                                <td>{{ $playerName }} </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            @endforeach

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
@endforeach

<a href="javascript:" class="btn_style1 excel" onclick="doExcel1()">
    <a href="{{url('order_details/edit')}}/{{$order->id}}/?active_tab=order" id="redirect_link" style="display: none;">redirect link</a>
    <span>Excel</span>
</a>

<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.10.3/xlsx.full.min.js"></script>
<script>
    function s2ab(s) {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for (var i = 0; i != s.length; ++i) view[i] = s.charCodeAt(i) & 0xff;
        return buf;
    }

    function converttoExcel() {
        var blob,
        wb = { SheetNames: [], Sheets: {} };

        var no = 0;

        $(".content_regular").each(function () {
            var table = "<html>" + $(this).html() + "</html>";
            var divname = $(this).attr("data-divName");

            if(no != 0 ) {
                divname = no + " - " + divname;
            }

            console.log(divname);
            var ws1 = XLSX.read(table, { type: "binary" },).Sheets.Sheet1;

            wb.SheetNames.push(divname);
            wb.Sheets[divname] = ws1;

            no = no + 1;
        });

        blob = new Blob([s2ab(XLSX.write(wb, { bookType: "xlsx", type: "binary" }))], { type: "application/octet-stream", });
        saveAs(blob, "roster_" +$("#pdf_id").val()+".xlsx");
    }

    $(document).ready(function () {
        converttoExcel();
        setTimeout(function(){
            $('#redirect_link')[0].click();
        },100);
    });
</script>
@endsection
