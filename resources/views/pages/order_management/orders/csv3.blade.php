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
    <input type="hidden" id="organization_name" value="{{ $order->organizationDetails->organization_name }}" />
    <input type="hidden" id="order_no" value="{{ $order->order_no }}" />
    <div class="content_regular" data-divName="Product Report">
        <table>
            <tr>
                <td><b>Product Code</b></td>
                <td><b>Product Name</b></td>
                <td><b>Fabric</b></td>
                <td><b>Embellishment</b></td>
                <td><b>Quantity</b></td>
                <td><b>Size</b></td>
                <td><b>Factory</b></td>
                <td><b></b></td>
            </tr>
            @foreach ($order->orderItems as $orderItem)
                @foreach ($orderItem->orderItemDetails as $orderItemDetail)
                    @php
                        $itemQty = $orderItemDetail->qty + $orderItemDetail->blanks;
                    @endphp
                    @if($itemQty != '' && $itemQty > 0)
                        <tr>
                            <td>{{ $orderItem->productDetails->product_no ?? '' }}</td>
                            <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                            <td>{{ $orderItem->fabricDetails->fabric_name ?? '' }}</td>
                            <td>{{ $orderItem->embellishmentDetails->embellishment_name ?? '' }}</td>
                            <td>{{ $itemQty ?? '' }}</td>
                            <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            <td>{{ $orderItem->factoryDetails->factory_code ?? '' }}</td>
                            <td></td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
        </table>
    </div>

    <div class="content_regular" data-divName="Player Report">
        <table>
            <tr>
                <td><b>Player Name</b></td>
                {{-- <td><b>Billing Name</b></td> --}}
                {{-- <td><b>Order Number</b></td> --}}
                {{-- <td><b>Order Quantity</b></td> --}}
                <td><b>Product</b></td>
                <td><b>Player Numbers</b></td>
                <td><b>Quantity</b></td>
                <td><b>Size</b></td>
            </tr>

            @foreach ($order->orderItems as $orderItem)
                @foreach ($orderItem->orderItemDetails as $orderItemDetail)
                    @php
                        $itemQty = $orderItemDetail->qty + $orderItemDetail->blanks;
                    @endphp
                    @if($itemQty != '' && $itemQty > 0)

                        @if ($orderItemDetail->numseq_one != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_one ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_one ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_two != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_two ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_two ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_three != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_three ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_three ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_four != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_four ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_four ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_five != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_five ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_five ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_six != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_six ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_six ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_seven != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_seven ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_seven ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_eight != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_eight ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_eight ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_nine != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_nine ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_nine ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif

                        {{-- Ten --}}
                        @if ($orderItemDetail->numseq_ten != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_ten ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_ten ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_eleven != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_eleven ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_eleven ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_twelve != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_twelve ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_twelve ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_thirteen != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_thirteen ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_thirteen ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_fourteen != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_fourteen ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_fourteen ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_fifteen != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_fifteen ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_fifteen ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_sixteen != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_sixteen ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_sixteen ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_seventeen != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_seventeen ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_seventeen ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_eighteen != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_eighteen ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_eighteen ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_nineteen != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_nineteen ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_nineteen ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif

                        {{-- Twenty --}}
                        @if ($orderItemDetail->numseq_twenty != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_twenty ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_twenty ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_twenty_one != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_twenty_one ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_twenty_one ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_twenty_two != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_twenty_two ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_twenty_two ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_twenty_three != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_twenty_three ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_twenty_three ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_twenty_four != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_twenty_four ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_twenty_four ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_twenty_five != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_twenty_five ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_twenty_five ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_twenty_six != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_twenty_six ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_twenty_six ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_twenty_seven != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_twenty_seven ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_twenty_seven ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_twenty_eight != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_twenty_eight ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_twenty_eight ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_twenty_nine != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_twenty_nine ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_twenty_nine ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif

                        {{-- Thirty --}}
                        @if ($orderItemDetail->numseq_thirty != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_thirty ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_thirty ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_thirty_one != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_thirty_one ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_thirty_one ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_thirty_two != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_thirty_two ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_thirty_two ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_thirty_three != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_thirty_three ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_thirty_three ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_thirty_four != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_thirty_four ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_thirty_four ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_thirty_five != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_thirty_five ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_thirty_five ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_thirty_six != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_thirty_six ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_thirty_six ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_thirty_seven != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_thirty_seven ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_thirty_seven ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_thirty_eight != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_thirty_eight ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_thirty_eight ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_thirty_nine != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_thirty_nine ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_thirty_nine ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif

                        {{-- Forty --}}
                        @if ($orderItemDetail->numseq_forty != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_forty ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_forty ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_forty_one != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_forty_one ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_forty_one ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_forty_two != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_forty_two ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_forty_two ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_forty_three != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_forty_three ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_forty_three ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_forty_four != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_forty_four ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_forty_four ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_forty_five != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_forty_five ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_forty_five ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_forty_six != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_forty_six ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_forty_six ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_forty_seven != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_forty_seven ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_forty_seven ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_forty_eight != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_forty_eight ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_forty_eight ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_forty_nine != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_forty_nine ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_forty_nine ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif

                        {{-- Fifty --}}
                        @if ($orderItemDetail->numseq_fifty != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_fifty ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_fifty ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_fifty_one != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_fifty_one ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_fifty_one ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_fifty_two != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_fifty_two ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_fifty_two ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_fifty_three != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_fifty_three ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_fifty_three ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_fifty_four != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_fifty_four ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_fifty_four ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_fifty_five != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_fifty_five ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_fifty_five ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_fifty_six != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_fifty_six ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_fifty_six ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_fifty_seven != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_fifty_seven ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_fifty_seven ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_fifty_eight != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_fifty_eight ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_fifty_eight ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_fifty_nine != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_fifty_nine ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_fifty_nine ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif

                        {{-- Sixty --}}
                        @if ($orderItemDetail->numseq_sixty != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_sixty ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_sixty ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_sixty_one != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_sixty_one ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_sixty_one ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_sixty_two != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_sixty_two ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_sixty_two ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_sixty_three != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_sixty_three ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_sixty_three ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_sixty_four != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_sixty_four ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_sixty_four ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_sixty_five != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_sixty_five ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_sixty_five ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_sixty_six != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_sixty_six ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_sixty_six ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_sixty_seven != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_sixty_seven ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_sixty_seven ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_sixty_eight != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_sixty_eight ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_sixty_eight ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_sixty_nine != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_sixty_nine ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_sixty_nine ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif

                        {{-- Seventy --}}
                        @if ($orderItemDetail->numseq_seventy != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_seventy ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_seventy ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_seventy_one != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_seventy_one ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_seventy_one ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_seventy_two != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_seventy_two ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_seventy_two ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_seventy_three != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_seventy_three ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_seventy_three ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_seventy_four != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_seventy_four ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_seventy_four ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_seventy_five != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_seventy_five ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_seventy_five ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_seventy_six != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_seventy_six ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_seventy_six ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_seventy_seven != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_seventy_seven ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_seventy_seven ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_seventy_eight != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_seventy_eight ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_seventy_eight ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_seventy_nine != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_seventy_nine ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_seventy_nine ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif

                        {{-- Eighty --}}
                        @if ($orderItemDetail->numseq_eighty != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_eighty ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_eighty ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_eighty_one != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_eighty_one ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_eighty_one ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_eighty_two != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_eighty_two ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_eighty_two ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_eighty_three != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_eighty_three ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_eighty_three ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_eighty_four != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_eighty_four ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_eighty_four ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_eighty_five != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_eighty_five ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_eighty_five ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_eighty_six != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_eighty_six ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_eighty_six ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_eighty_seven != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_eighty_seven ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_eighty_seven ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_eighty_eight != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_eighty_eight ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_eighty_eight ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_eighty_nine != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_eighty_nine ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_eighty_nine ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif

                        {{-- Ninety --}}
                        @if ($orderItemDetail->numseq_ninety != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_ninety ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_ninety ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_ninety_one != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_ninety_one ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_ninety_one ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_ninety_two != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_ninety_two ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_ninety_two ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_ninety_three != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_ninety_three ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_ninety_three ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_ninety_four != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_ninety_four ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_ninety_four ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_ninety_five != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_ninety_five ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_ninety_five ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_ninety_six != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_ninety_six ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_ninety_six ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_ninety_seven != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_ninety_seven ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_ninety_seven ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_ninety_eight != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_ninety_eight ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_ninety_eight ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($orderItemDetail->numseq_ninety_nine != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_ninety_nine ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_ninety_nine ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif

                        @if ($orderItemDetail->numseq_hundred != "" )
                            <tr>
                                <td>{{ $orderItemDetail->playerDetails->player_hundred ?? 'N' }}</td>
                                <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                <td>{{ $orderItemDetail->numseq_hundred ?? 'N' }}</td>
                                <td>1</td>
                                <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                            </tr>
                        @endif
                        @if (isset($orderItemDetail->playerDetails) && $orderItemDetail->playerDetails->blank_player_names != "")
                            @foreach ( json_decode($orderItemDetail->playerDetails->blank_player_names) as $blankPlayer )
                                <tr>
                                    <td>{{ $blankPlayer ?? '' }}</td>
                                    <td>{{ $orderItem->productDetails->product_name ?? '' }}</td>
                                    <td></td>
                                    <td>1</td>
                                    <td>{{ $orderItemDetail->sizeDetails->size_name ?? '' }}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endif
                @endforeach
            @endforeach
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

        // var no = 0;

        $(".content_regular").each(function () {
            var table = "<html>" + $(this).html() + "</html>";
            var divname = $(this).attr("data-divName");

            // if(no != 0 ) {
            //     divname = no + " - " + divname;
            // }

            console.log(divname);
            var ws1 = XLSX.read(table, { type: "binary" },).Sheets.Sheet1;

            wb.SheetNames.push(divname);
            wb.Sheets[divname] = ws1;

            // no = no + 1;
        });

        blob = new Blob([s2ab(XLSX.write(wb, { bookType: "xlsx", type: "binary" }))], { type: "application/octet-stream", });
        saveAs(blob, $("#organization_name").val() +" - "+ $("#order_no").val()+".xlsx");
    }

    $(document).ready(function () {
        converttoExcel();
        setTimeout(function(){
            $('#redirect_link')[0].click();
        },100);
    });
</script>
@endsection
