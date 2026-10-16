@extends('layouts.app', ['class' => 'bg-default', 'activePage' => 'home', 'titlePage' => __('Roster')])

@section('content')
<head>
    <link type="text/css" rel="stylesheet" href="{{ asset('argon') }}/file_inputs/css/fileinput.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css" rel="stylesheet" type="text/css" />
</head>
<style>
    .bg-default {
        background-color: #ffffff !important;
        background: none;
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
    footer.py-5 {
        display: none;
    }
    @media (max-width: 1366px) {
        .roster-container {
            overflow: scroll;
        }
        .roster-table {
            width: 200%;
        }
    }
    .wi-2{
        vertical-align: middle !important;
    }

    .cusTab .tab {
        float: left;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
        width: 30%;
        height: 300px;
    }

        /* Style the buttons inside the tab */
    .cusTab .tab button {
        display: block;
        background-color: inherit;
        color: black;
        padding: 22px 16px;
        width: 100%;
        border: none;
        outline: none;
        text-align: left;
        cursor: pointer;
        transition: 0.3s;
        font-size: 17px;
    }

        /* Change background color of buttons on hover */
    .cusTab .tab button:hover {
        background-color: #ddd;
    }

        /* Create an active/current "tab button" class */
    .cusTab .tab button.active {
        background-color: #ccc;
    }

        /* Style the tab content */
    .cusTab .tabcontent {
        float: left;
        padding: 0px 12px;
        border: 1px solid #ccc;
        width: 70%;
        border-left: none;
        height: 300px;
    }

    .tab-container {
        border-radius: 6px;
        box-shadow: 0px 2px 6px #0000002e
    }
    .tab {
        overflow: hidden;
        background-color: #ffffff;
    }
    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 8px 18px;
        transition: 0.3s;
        font-size: 12px;
        color: #989898;
        border-bottom: 2px solid transparent;
        width: 100%;
        text-align: left;
        padding-left: 8px;
        padding-right: unset;
    }
    .tab button.task-tab {
        padding: 0.4rem 0.95rem;
    }
    .tab button:hover {
        border-right: 2px solid #e4e4e4;
        background-color: rgb(250, 250, 250);
    }
    .tab button.active {
        border-right: 1px solid gray;
        background-color: rgb(246, 246, 246);
    }
    .tabcontent {
        display: none;
        /* border-top: 1px solid #ccc; */
    }
    .kv-file-remove {
        display: none;
    }
    #btn_cus_add_save {
        padding: 3px 15px !important
    }
    /* Chrome, Safari, Edge, Opera */
    .hide-arrows::-webkit-outer-spin-button,
    .hide-arrows::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    .hide-arrows[type=number] {
        -moz-appearance: textfield;
    }
    .imagesize {
            max-width: 70%;
        }
    .form-control-bc {
        background-color: transparent !important;
    }

    .sub-header-style{
        font-size: .8rem;
    }
    .pdf-content .pdf-size {
        max-width: 100% !important;
        width: 98% !important;
        max-height: 60px !important;
        height: 60px !important;
    }
    .pdf-content .file-size-info {
        position: relative;
        top: -29px;
    }
    .pdf-content .file-caption-info {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
    }
    .pdf-content .progress {
        position: relative;
        left: -6px;
        top: -1px !important;
    }
    .img-content .file-caption-info {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
        height: 16px;
    }
    .select2-container--default .select2-results__option--disabled{
        color: red !important;
    }
    .file-preview-frame {
        width: 190px !important;
        height: 284px !important;
        border: unset !important;
        box-shadow: unset !important;
    }
    .upload_button {
        cursor: pointer;
        height: 26px;
        border: 1px solid rgb(209, 209, 209);
        background-color: rgb(242, 242, 242);
        font-size: 8px;
    }
    .file-drop-zone {
        border: unset;
    }
    .file-drop-zone.clickable:hover {
        border: unset !important;
    }
    .file-thumbnail-footer {
        position: relative;
        top: -37px !important;
        padding-left: 9px;
        padding-right: 9px;
    }
    .kv-file-content {
        height: 293px !important;
        width: 105% !important;
        margin: unset;
        width: 100%;
        text-align: center;
    }
    .file-footer-buttons {
        text-align: right !important;
        position: relative !important;
        top: -40px !important;
    }
    .file-actions {
        position: relative !important;
        top: -50px !important;
    }
    .file-drop-zone .file-preview-thumbnails {
        max-height: 381px !important;
        height: 350px !important;
    }
    .pdf-content .kv-preview-data {
        display: table-cell !important;
    }
    .pdf-content .file-actions {
        position: relative !important;
        top: -24px !important;
    }
    .pdf-content .file-other-icon {
        font-size: 2.5rem !important;
    }
    .pdf-content .file-thumbnail-footer {
        position: relative !important;
        top: -38px !important;
    }
    .pdf-content .krajee-default .file-size-info {
        width: 80px !important;
    }
    .pdf-content .kv-file-content {
        height: 50px !important;
    }
    .file-drop-zone-title {
        padding: 5px 10px;
        position: relative;
        top: 60px;
    }
    .file-preview-image {
        width: 88% !important;
    }
    .btn-kv {
        background-color: #ffffff6e;
        color: #4d4d4d;
    }
    .kv-file-zoom {
        display: none;
    }

</style>

<div class="container-fluid mt-5" style="background-color: #ffffff">
    <div class="se-pre-con"></div>

    @if(session('error_msg'))
        <div class="alert alert-danger fade in alert-dismissible show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true" style="font-size:20px">×</span>
            </button>
            {{ session('error_msg') }}
        </div>
    @endif

    @if($emptyInvoice != 0)
        <section id="tabs">
            <div class="container col-md-12">
                <div class="row mt-4">
                    <div class="col-md-12 ">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                @if (request()->has('active_tab')) <input type="hidden" value="{{ request()->get('active_tab') }}" id="active_tab_id" /> @endif

                                <a style="max-width: 250px;" class="nav-item nav-link active nav-tab-item" id="invoice-tab" data-toggle="tab" href="#invoice_tab" role="tab" aria-controls="invoice" aria-selected="true">Order</a>

                                <a style="max-width: 250px;" class="nav-item nav-link nav-tab-item" id="shipping-tab" data-toggle="tab" href="#shipping_tab" role="tab" aria-controls="shipping" aria-selected="true">Shipping</a>
                            </div>

                        </nav>
                        <br>


                        <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                        {{-- Invoice Tab --}}
                            <div class="tab-pane fade show active" id="invoice_tab" role="tabpanel" aria-labelledby="invoice-tab">
                                <nav>
                                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                        @if (request()->has('active_tab')) <input type="hidden" value="{{ request()->get('active_tab') }}" id="active_tab_id" /> @endif

                                        <a class="nav-item nav-link active nav-tab-item" id="invoice-tab2" data-toggle="tab" href="#invoice_tab2" role="tab" aria-controls="invoice" aria-selected="true">Order Details</a>

                                        @foreach ($orderDetails as $orderDetail)
                                            @foreach ($orderDetail->orderItems as $orderItem)
                                            @php
                                                $sub_product = $sub_products->where('sub_product_no' , $orderItem->sub_product_no)->first();
                                            @endphp
                                                <a class="nav-item nav-link nav-tab-item" formID="{{ $orderItem->id }}" id="tab_{{$orderItem->id}}_link" data-toggle="tab" href="#tab_{{$orderItem->id}}" role="tab" aria-controls="tab_{{$orderItem->id}}" aria-selected="false" data-RosterForm="orderRoster_{{ $orderItem->id }}">@if(empty($orderItem->display_name)) {{$sub_product->product_name}} @else {{$orderItem->display_name}} @endif</a>
                                            @endforeach
                                        @endforeach

                                    </div>
                                </nav>
                                <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent2">
                                    <div class="tab-pane fade show active" id="invoice_tab2" role="tabpanel" aria-labelledby="invoice-tab2">
                                        <div class="card mb-3">
                                            <div class="card-head">
                                                <div class="col-lg-12 control-btns">
                                                    @foreach ($orderDetails as $orderDetail)
                                                        {{-- <a href="{{route('customer_payment', ['orderId'=>$orderDetail->id])}}" class="btn btn-success btn-custom">Payment</a> --}}
                                                        <a id="paymentLink" href="{{ route('customer_payment', [
                                                            'orderId' => $orderDetail->id,
                                                            'sub_total' => number_format($orderDetail->sub_total, 2),
                                                            'salesTax' => number_format($orderDetail->sales_tax, 2),
                                                            'shipping' => number_format($orderDetail->shipping, 2),
                                                            'artwork' => number_format($orderDetail->artwork, 2),
                                                            'processingFee' => number_format($orderDetail->processing_fee, 2),
                                                            'orderTotal' => number_format($orderDetail->order_total, 2),
                                                            'balancePayment' => number_format($balnceToBePaid, 2),
                                                            'qtySum' => ''
                                                        ]) }}" class="btn btn-success btn-custom"> Payment</a>
                                                    @endforeach
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <img src="{{ asset('argon') }}/img/encore/logo1.png" style="width: 30%;">
                                                        </div>

                                                        <div class="col-md-6">
                                                            @foreach ($orderDetails as $orderDetail)
                                                                <h1 class="text-danger text-right" style="font-size: 16px; margin-bottom: 0rem;">ORDER #{{$orderDetail->order_no}}</h1>
                                                            @endforeach
                                                            <h5 class="text-right" style="margin-bottom: 0rem;">Encore Custom</h5>
                                                            <h5 class="text-right" style="margin-bottom: 0rem;">891 4th st.</h5>
                                                            <h5 class="text-right" style="margin-bottom: 0rem;">San Rafael, CA 94901</h5>
                                                            <h5 class="text-right" style="margin-bottom: 0rem;">info@encorebrand.com</h5>
                                                            <h5 class="text-right" style="margin-bottom: 0rem;">1 (888) 501-4999</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <table class="table invoice_details">
                                                            <tr>
                                                                <th>Organization :</th>
                                                                <td>
                                                                    @foreach ($orderDetails as $orderDetail)
                                                                        <input class="invoice-inputs" type='text' value='{{$orderDetail->organizationDetails['organization_name']}}' readonly />
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Order # :</th>
                                                                <td>
                                                                    @foreach ($orderDetails as $orderDetail)
                                                                        <input class="invoice-inputs" type='text' value='{{$orderDetail->order_no}}' readonly />
                                                                        <input type='hidden' id="order_id" value='{{$orderDetail->id}}' />
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Status :</th>
                                                                <td>
                                                                    @foreach ($orderDetails as $orderDetail)
                                                                        <input class="invoice-inputs" type='text' value='{{$orderDetail->statusDetails['status_name']}}' readonly />
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <table class="table invoice_details">
                                                            <tr>
                                                                <th>Sales Rep :</th>
                                                                <td>
                                                                    @foreach ($orderDetails as $orderDetail)
                                                                        <input class="invoice-inputs" type='text' value='{{$orderDetail->userDetails['name']}}' readonly />
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Ex Factory Date :</th>
                                                                <td>
                                                                    @foreach ($orderDetails as $orderDetail)
                                                                        <input class="invoice-inputs" type='text' value='{{$orderDetail->ex_factory_date}}' readonly />
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                            <tr @foreach ($orderDetails as $orderDetail) @if($orderDetail->order_type == 0 || ($orderDetail->order_type == 1 && $orderDetail->address_type == 2)) style="display: none" @endif @endforeach>
                                                                <th>Encore Packing Date :</th>
                                                                <td>
                                                                    @foreach ($orderDetails as $orderDetail)
                                                                        <input class="invoice-inputs" type='text' value='{{$orderDetail->encore_packing_date}}' readonly />
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Customer In-Hand Date :</th>
                                                                <td>
                                                                    @foreach ($orderDetails as $orderDetail)
                                                                        <input class="invoice-inputs" type='text' value='{{$orderDetail->due_date}}' readonly />
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <table class="table shipping_details">
                                                            <tr>
                                                                <th colspan="4">Customer Shipping Address:</th>
                                                            </tr>
                                                            @foreach ($orderDetails as $orderDetail)
                                                            @if ($orderDetail->order_type == 1)
                                                                <tr>
                                                                    <td colspan="4">
                                                                        <div class="row pl-2 pt-1">
                                                                            <div class="custom-control custom-checkbox shipping-checkbox">
                                                                                <input
                                                                                    type="checkbox"
                                                                                    class="custom-control-input"
                                                                                    name="shipping_direct_ship_to_customers"
                                                                                    id="shipping_direct_ship_to_customers"
                                                                                    disabled
                                                                                    @if ($orderDetail->address_type == 1) checked @endif
                                                                                />
                                                                                <label class="custom-control-label" for="shipping_direct_ship_to_customers">Direct Ship to Customers&nbsp;</label>
                                                                            </div>

                                                                            <div class="custom-control custom-checkbox shipping-checkbox">
                                                                                <input
                                                                                    type="checkbox"
                                                                                    class="custom-control-input"
                                                                                    name="shipping_bulk_ship_to_coach"
                                                                                    id="shipping_bulk_ship_to_coach"
                                                                                    disabled
                                                                                    @if ($orderDetail->address_type == 2) checked @endif
                                                                                />
                                                                                <label class="custom-control-label" for="shipping_bulk_ship_to_coach">Bulk Ship to Coach&nbsp;</label>
                                                                            </div>

                                                                            <div class="custom-control custom-checkbox shipping-checkbox">
                                                                                <input
                                                                                    type="checkbox"
                                                                                    class="custom-control-input"
                                                                                    name="shipping_pick_up"
                                                                                    id="shipping_pick_up"
                                                                                    disabled
                                                                                    @if ($orderDetail->address_type == 3) checked @endif
                                                                                />
                                                                                <label class="custom-control-label" for="shipping_pick_up">Pick Up&nbsp;</label>
                                                                            </div>

                                                                            <div class="custom-control custom-checkbox shipping-checkbox">
                                                                                <input
                                                                                    type="checkbox"
                                                                                    class="custom-control-input"
                                                                                    name="shipping_direct_pick_up"
                                                                                    id="shipping_direct_pick_up"
                                                                                    disabled
                                                                                    @if ($orderDetail->address_type == 4) checked @endif
                                                                                />
                                                                                <label class="custom-control-label" for="shipping_direct_pick_up">Direct & Pick Up&nbsp;</label>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                <tr>
                                                            @endif
                                                            @endforeach
                                                            <tr>
                                                                <td class="text-center" width="25px"><i class="fas fa-user-circle"></i></td>
                                                                <td>
                                                                    @foreach ($orderDetails as $orderDetail)
                                                                        <input class="invoice-inputs" type='text' value='{{$orderDetail->contactDetails['first_name']}} {{$orderDetail->contactDetails['last_name']}}' readonly />
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                            @foreach ($orderDetails as $orderDetail)
                                                            @if ($orderDetail->address_type == 2)
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <div class="row pl-2 pt-1">
                                                                            <div class="custom-control custom-checkbox shipping-checkbox pb-1">
                                                                                <input type="checkbox" class="custom-control-input" id="new_shipping_address" name="new_shipping_address" @if ($orderDetail->is_new_shipping_address == 1) value="1" checked @else value="0" @endif>
                                                                                <label class="custom-control-label" for="new_shipping_address">New Shipping Address</label>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endif

                                                            <tr class="default-address">
                                                                <td class="text-center" width="25px"><i class="fas fa-align-left"></i></td>
                                                                <td>
                                                                    <input class="invoice-inputs" id="shipping_address2" type='text' value='{{ $orderDetail->contactDetails['shipping_street'] ?? '--' }}' readonly />
                                                                </td>
                                                            </tr>
                                                            <tr class="default-address">
                                                                <td style="border-top: 1px solid transparent"></td>
                                                                <td>
                                                                    <input class="invoice-inputs" id="shipping_address3" type='text' value='{{ $orderDetail->contactDetails['shipping_city'] ?? '' }} {{ $orderDetail->contactDetails['shipping_state'] ?? '' }} {{ $orderDetail->contactDetails['shipping_zip'] ?? '' }}' readonly />
                                                                </td>
                                                            </tr>
                                                            <tr class="default-address">
                                                                <td style="border-top: 1px solid transparent"></td>
                                                                <td>
                                                                    <input class="invoice-inputs" id="shipping_address4" type='text' value='{{ $orderDetail->contactDetails['shipping_country'] ?? '--' }}' readonly />
                                                                </td>
                                                            </tr>
                                                            <tr class="default-address">
                                                                <td class="text-center"><i class="fas fa-phone-alt"></i></td>
                                                                <td>
                                                                    <input class="invoice-inputs" id="shipping_address5" type='text' value='{{ $orderDetail->contactDetails['phone_no'] ?? '--' }}' readonly />
                                                                </td>
                                                            </tr>
                                                            <tr class="default-address">
                                                                <td class="text-center"><i class="fas fa-envelope"></i></td>
                                                                <td>
                                                                    <input class="invoice-inputs" id="shipping_address6" type='text' value='{{ $orderDetail->contactDetails['email'] ?? '--' }}' readonly />
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                            {{-- New Shipping Address --}}
                                                            <form action="{{ route('roster.new_address') }}" method="post">
                                                                @csrf
                                                                @foreach ($orderDetails as $orderDetail)
                                                                <tr class="new-address">
                                                                    <td width="25px">Street: </td>
                                                                    <td><input class="invoice-inputs new-address-input" id="new_street" name="new_street" type='text' value="{{ $orderDetail->street ?? '--' }}" /></td>
                                                                </tr>
                                                                <tr class="new-address">
                                                                    <td>City: </td>
                                                                    <td><input class="invoice-inputs new-address-input" id="new_city" name="new_city" type='text' value="{{ $orderDetail->city ?? '--' }}" /></td>
                                                                </tr>
                                                                <tr class="new-address">
                                                                    <td>State: </td>
                                                                    <td><input class="invoice-inputs new-address-input" id="new_state" name="new_state" type='text' value="{{ $orderDetail->state ?? '--' }}" /></td>
                                                                </tr>
                                                                <tr class="new-address">
                                                                    <td>Postal Code: </td>
                                                                    <td><input class="invoice-inputs new-address-input" id="new_postal_code" name="new_postal_code" type='text' value="{{ $orderDetail->postal_code ?? '--' }}" /></td>
                                                                </tr>
                                                                <tr class="new-address">
                                                                    <td>Country: </td>
                                                                    <td><input class="invoice-inputs new-address-input" id="new_country" name="new_country" type='text' value="{{ $orderDetail->country ?? '--' }}" /></td>
                                                                </tr>
                                                                <tr class="new-address">
                                                                    <td class="text-center"><i class="fas fa-phone-alt"></i></td>
                                                                    <td><input class="invoice-inputs new-address-input" id="new_phone_no" name="new_phone_no" type='text' value='{{ $orderDetail->phone_no ?? '--' }}' /></td>
                                                                </tr>
                                                                <tr class="new-address">
                                                                    <td class="text-center"><i class="fas fa-envelope"></i></td>
                                                                    <td><input class="invoice-inputs new-address-input" id="new_email" name="new_email" type='text'  value='{{ $orderDetail->email ?? '--' }}' /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2" class="text-right">
                                                                        <input type="hidden" name="new_address_order_id" value="{{$orderDetail->id}}" />
                                                                        <button type="submit" id="btn_cus_add_save" class="btn btn-sm btn-success btn-custom" value="{{$orderDetail->id}}" style="display: none;">Update Address</button>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </form>
                                                        </table>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <table class="table shipping_details">
                                                            <tr>
                                                                <th colspan="4">Order Description:</th>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-center" width="25px"><i class="fas fa-file-signature"></i></td>
                                                                <td>
                                                                    @foreach ($orderDetails as $orderDetail)
                                                                        <textarea class="invoice-inputs" id="order_description" name="order_description" type='text' rows="10" value='' style="margin-top: 5px; margin-bottom: 7px;" readonly >{{$orderDetail->order_description}}</textarea>
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-md-12">
                                                        <table class="table Product_details" id="order_item_table">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-left" style="width: 40%;padding-left: .5rem !important;">ITEM</th>
                                                                    <th class="text-left">STATUS</th>
                                                                    <th class="text-left">EST DELIVERY</th>
                                                                    <th class="text-left">TRACKING</th>
                                                                    <th class="text-right">QTY</th>
                                                                    <th class="text-right">UNIT PRICE($)</th>
                                                                    <th class="text-right" style="padding-right: 0.5rem !important">TOTAL($)</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="product_table_body">
                                                                @foreach ($orderDetails as $orderDetail)
                                                                    @foreach ($orderDetail->orderItems as $orderItem)

                                                                        @php
                                                                            $sub_product = $sub_products->where('sub_product_no' , $orderItem->sub_product_no)->first();
                                                                        @endphp

                                                                        <tr>
                                                                            <input type="hidden" name="product[{{$orderItem->id}}][item_id]" value="{{$orderItem->id}}" />
                                                                            <td><input type="text" class="invoice-inputs" name="product[{{$orderItem->id}}][item_name]" value="@if(empty($orderItem->display_name)) {{$sub_product->product_name}} @else {{$orderItem->display_name}} @endif @if (isset($orderItem->item_description) && ($orderItem->item_description != null || $orderItem->item_description != '')) {{ '- ' . $orderItem->item_description }} @endif" readonly /></td>
                                                                            <td><input type="text" class="invoice-inputs text-left" style="padding-left: 0rem !important;" name="product[{{$orderItem->id}}][status]" value="{{$orderItem->statusDetails['status_name']}}" readonly /></td>
                                                                            <td><input type="text" class="invoice-inputs" style="padding-left: 0rem !important;" name="product[{{$orderItem->id}}][est_delivery_date]" value="{{$orderItem->est_delivery_date}}" readonly /></td>
                                                                            <td><input type="text" class="invoice-inputs" style="padding-left: 0rem !important;" name="product[{{$orderItem->id}}][tracking]" value="{{$orderItem->tracking_no}}" readonly /></td>
                                                                            <td><input type="text" class="invoice-inputs text-right item-qty item_qty" style="padding-right: 0rem !important;" name="product[{{$orderItem->id}}][qty]" value="{{$orderItem->qty}}" readonly /></td>
                                                                            <td><input type="text" class="invoice-inputs text-right item-price" style="padding-right: 0rem !important;" name="product[{{$orderItem->id}}][unit_price]" value="{{$orderItem->unit_price}}" readonly /></td>
                                                                            <td><input type="text" class="invoice-inputs text-right item-total" style="padding-right: .5rem !important;" name="product[{{$orderItem->id}}][total]" value="{{$orderItem->total}}" readonly /></td>
                                                                            <input type="hidden" name="product[{{$orderItem->id}}][organization_id]" value="{{$orderItem->organization_id}}" />
                                                                            <input type="hidden" name="product[{{$orderItem->id}}][support_agent_id]" value="{{$orderItem->support_agent_id}}" />
                                                                            <input type="hidden" name="product[{{$orderItem->id}}][designer_id]" value="{{$orderItem->designer_id}}" />
                                                                            <input type="hidden" name="product[{{$orderItem->id}}][shipping_method]" value="{{$orderItem->shipping_method}}" />
                                                                            <input type="hidden" name="product[{{$orderItem->id}}][ex_factory_id]" value="{{$orderItem->ex_factory_id}}" />
                                                                            <input type="hidden" name="product[{{$orderItem->id}}][item_no]" value="{{$orderItem->item_no}}" />
                                                                            <input type="hidden" name="product[{{$orderItem->id}}][order_id]" value="{{$orderItem->order_id}}" />
                                                                            <input type="hidden" name="product[{{$orderItem->id}}][in_hand_due_date]" value="{{$orderItem->in_hand_due_date}}" />
                                                                            <input type="hidden" name="product[{{$orderItem->id}}][status_id]" value="{{$orderItem->order_status_id}}" />
                                                                            <input type="hidden" name="product[{{$orderItem->id}}][product_id]" value="{{$orderItem->product_id}}" />
                                                                            <input type="hidden" name="product[{{$orderItem->id}}][fabric_id]" value="{{$orderItem->fabric_id}}" />
                                                                            <input type="hidden" name="product[{{$orderItem->id}}][embellishment_id]" value="{{$orderItem->embellishment_type_id}}" />
                                                                            <input type="hidden" name="product[{{$orderItem->id}}][sport]" value="{{$orderItem->sport}}" />
                                                                            <input type="hidden" name="product[{{$orderItem->id}}][gender]" value="{{$orderItem->gender}}" />
                                                                            <input type="hidden" name="product[{{$orderItem->id}}][factory_id]" value="{{$orderItem->factory_id}}" />
                                                                        </tr>
                                                                    @endforeach
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card mb-5">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-7">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h1 class="main-htag mt-4">Thank you for your business!</h1>
                                                            </div>
                                                            <div class="col-md-12 mt-4 text-center">
                                                                <img src="{{ asset('argon') }}/img/encore/logo_dark.png" class="navbar-brand-img imagesize" id="logo_large" alt="..." width="300px">
                                                            </div>
                                                        </div>

                                                        {{-- <div class="mt-4">
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
                                                        </div> --}}
                                                    </div>

                                                    <div class="col-lg-5">
                                                        <table id="invoice_summery_table" class="table invoice_summery">
                                                            <tr>
                                                                <th>SUBTOTAL ($) :</th>
                                                                <td>
                                                                    @foreach ($orderDetails as $orderDetail)
                                                                        <input class="invoice-inputs text-right" type='text' value='{{number_format($orderDetail->sub_total, 2)}}' readonly />
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                @foreach ($orderDetails as $orderDetail)
                                                                    <th>SALES TAX ($) <span id="sales_tax_display">{{$orderDetail->organizationDetails['sales_tax']}}</span>% RATE :</th>
                                                                    <td>
                                                                        <input type="hidden" value="{{$orderDetail->organizationDetails['sales_tax']}}" />
                                                                        <input class="invoice-inputs text-right" type='text' value='{{number_format($orderDetail->sales_tax, 2)}}' readonly/>
                                                                    </td>
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <th>SHIPPING ($) :</th>
                                                                <td>
                                                                    @foreach ($orderDetails as $orderDetail)
                                                                        <input class="invoice-inputs text-right" type='text' value='{{number_format($orderDetail->shipping, 2)}}' readonly />
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>ARTWORK ($) :</th>
                                                                <td>
                                                                    @foreach ($orderDetails as $orderDetail)
                                                                        <input class="invoice-inputs text-right" type='text' value='{{number_format($orderDetail->artwork, 2)}}' readonly />
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>PROCESSING FEE ($) :</th>
                                                                <td>
                                                                    @foreach ($orderDetails as $orderDetail)
                                                                        <input class="invoice-inputs text-right" type='text' value='{{number_format($orderDetail->processing_fee, 2)}}' readonly />
                                                                    @endforeach
                                                                </td>
                                                            </tr><br>

                                                            @php
                                                                foreach ($orderDetails as $orderDetail) {
                                                                    if ($orderDetail->discountType == 2) {
                                                                        $discountValue = $orderDetail->discount;
                                                                    } else {
                                                                        $totalWithoutdisc = $orderDetail->sub_total + $orderDetail->sales_tax + $orderDetail->shipping + $orderDetail->artwork;
                                                                        $discountPercentage = $orderDetail->discount;
                                                                        $discountValue = ($totalWithoutdisc / 100) * $discountPercentage;
                                                                    }
                                                                }
                                                            @endphp

                                                            @foreach ($orderDetails as $orderDetail)
                                                                @if ($orderDetail->discount_hidation == 1)
                                                                    <tr>

                                                                        @if ($orderDetail->discountType == 2)
                                                                            <th>Discount value ($)</th>
                                                                            <td class="text-right">
                                                                                <input class="invoice-inputs text-right" type='text' value='{{number_format($discountValue, 2)}}' readonly />
                                                                            </td>
                                                                        @elseif ($orderDetail->discountType == 1)
                                                                            <th>Discount value {{ $orderDetail->discount }}% ($)</th>
                                                                            <td class="text-right">
                                                                                <input class="invoice-inputs text-right" type='text' value='{{number_format($discountValue, 2)}}' readonly />
                                                                            </td>
                                                                        @endif
                                                                    </tr><br>
                                                                @endif
                                                            @endforeach
                                                            <tr>
                                                                <th class="total">ORDER TOTAL ($) :</th>
                                                                <td>
                                                                    @foreach ($orderDetails as $orderDetail)
                                                                        <input class="invoice-inputs text-right" type='text' value='{{number_format($orderDetail->order_total, 2)}}' readonly style="font-weight: bold; font-size: large;" />
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>PAYMENT STATUS :</th>
                                                                @if ($paymentStatus == 0)
                                                                    <td style="background-color: #adb5bd; color: #ffffff; text-align: center;  height: 30px; text-transform: uppercase;">Pending</td>
                                                                @elseif ($paymentStatus == 1)
                                                                    <td style="background-color: #fb6340; color: #ffffff; text-align: center;  height: 30px; text-transform: uppercase;">Partial</td>
                                                                @else
                                                                    <td style="background-color: #2dce89; color: #ffffff; text-align: center;  height: 30px; text-transform: uppercase;">Paid</td>
                                                                @endif
                                                            </tr>
                                                            @if ($paymentStatus == 1)
                                                                <tr>
                                                                    <th>BALANCE PAYMENT :</th>
                                                                    <td><input class="invoice-inputs text-right" type='text' name="balance_payment"
                                                                        id="balance_payment" value='{{ number_format($balnceToBePaid, 2) }}'
                                                                        readonly style="font-weight: bold; font-size: large;" /></td>
                                                                </tr>
                                                            @endif
                                                        </table>
                                                    </div>
                                                </div>

                                                <input type="hidden" id="qtySumInput" name="qtySum" value="0" readonly>


                                                <div class="col-lg-12 control-btns">
                                                    @foreach ($orderDetails as $orderDetail)
                                                        {{-- <a href="{{route('customer_payment', ['orderId'=>$orderDetail->id])}}" class="btn btn-success btn-custom">Payment</a> --}}
                                                        <a id="paymentLink" href="{{ route('customer_payment', [
                                                            'orderId' => $orderDetail->id,
                                                            'sub_total' => number_format($orderDetail->sub_total, 2),
                                                            'salesTax' => number_format($orderDetail->sales_tax, 2),
                                                            'shipping' => number_format($orderDetail->shipping, 2),
                                                            'artwork' => number_format($orderDetail->artwork, 2),
                                                            'processingFee' => number_format($orderDetail->processing_fee, 2),
                                                            'orderTotal' => number_format($orderDetail->order_total, 2),
                                                            'balancePayment' => number_format($balnceToBePaid, 2),
                                                            'qtySum' => ''
                                                        ]) }}" class="btn btn-success btn-custom"> Payment</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>


                                    </div>


                                    @foreach ($orderDetails as $orderDetail)
                                        @foreach ($orderDetail->orderItems as $orderItem)
                                            <div class="tab-pane fade" id="tab_{{$orderItem->id}}" role="tabpanel" aria-labelledby="tab_{{$orderItem->id}}_link">
                                                <form id="formItem{{$orderItem->id}}" onsubmit="{{--return orderItemUpdate();--}}" method="POST" action="{{ route('roster.update') }}">
                                                    @csrf
                                                    <div class="col-lg-12">
                                                        <div class="col-lg-12 control-btns">
                                                            <a href="{{url('roster/print_order_item')}}/{{$orderItem->id}}" class="btn btn-light btn-custom">Print</a>
                                                            @if ($orderItem->order_status_id == 1)
                                                                <button type="submit" class="btn btn-success btn-custom">Save</button>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <input type="hidden" id="product_id_{{$orderItem->product_id}}" name="product_id" value="{{$orderItem->product_id}}" />
                                                    <input type="hidden" name="item_id" value="{{$orderDetail->id}}" />
                                                    <input type="hidden" name="orderItem[{{$orderItem->id}}][orderItemId]" value="{{$orderItem->id}}" />
                                                    <input type="hidden" name="order_id" value="{{$orderDetail->id}}" >
                                                    <input type="hidden" name="order_item_id" value="{{$orderItem->id}}" >
                                                    <input type="hidden" name="contact_id" value="{{$orderDetail->contactDetails->id}}" >
                                                    <input type="hidden" name="organization_id" value="{{$orderDetail->organizationDetails->id}}" >

                                                    @php
                                                        $sub_product_unique = $sub_products->where('sub_product_no' , $orderItem->sub_product_no)->first();
                                                    @endphp

                                                    <div class="row mt-4">
                                                        <div class="col-md-6">
                                                            <table class="table shipping_details">
                                                                <tr>
                                                                    <th style="width: 150px;">Style Name :</th>
                                                                    <td><input class="invoice-inputs" type='text' value='@if(empty($orderItem->display_name)) {{$sub_product_unique->product_name}} @else {{$orderItem->display_name}} @endif' readonly/></td>
                                                                </tr>

                                                                <tr>
                                                                    <th>Open Date :</th>
                                                                    <td><input class="invoice-inputs" type='text' value='{{$orderItem->open_date}}' readonly/></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Close Date :</th>
                                                                    <td><input class="invoice-inputs" type='text' value='{{$orderItem->close_date}}' readonly /></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Ex Factory Date :</th>
                                                                    <td><input class="invoice-inputs" type='text' value='{{$orderItem->ex_factory_date}}' readonly /></td>
                                                                </tr>
                                                                <tr @if($orderDetail->order_type == 0 || ($orderDetail->order_type == 1 && $orderDetail->address_type == 2)) style="display: none" @endif>
                                                                    <th>Encore Packing Date :</th>
                                                                    <td><input class="invoice-inputs" type='text' value='{{$orderItem->encore_packing_date}}' readonly /></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>In Hand Due Date :</th>
                                                                    <td><input class="invoice-inputs" type='text' value='{{$orderItem->in_hand_due_date}}' readonly /></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Unique Item # :</th>
                                                                    <td><input class="invoice-inputs" type='text' value='{{$orderItem->item_no}}' readonly/></td>
                                                                </tr>

                                                                <tr>
                                                                    <th>Item Description :</th>
                                                                    <td><input class="invoice-inputs" type='text' value='{{$orderItem->item_description}}' readonly/></td>
                                                                </tr>

                                                                <tr>
                                                                    <th>Item Status :</th>
                                                                    <td><input class="invoice-inputs" type='text' value='{{$orderItem->statusDetails['status_name']}}' readonly/></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Factory:</th>
                                                                    @if ($orderItem->factory_id)
                                                                        <td><input class="invoice-inputs" type='text' value='{{$orderItem->factoryDetails['factory_code']}}' readonly/></td>
                                                                    @else
                                                                        <td><input class="invoice-inputs" type='text' value='' readonly/></td>
                                                                    @endif
                                                                <tr>
                                                            </table>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <table class="table shipping_details">
                                                                <tr>
                                                                    <th style="width: 150px;">Team Name :</th>
                                                                    <td><input class="invoice-inputs" type='text' value='{{$orderDetail->organizationDetails['organization_name']}}' readonly/></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Shipping Recipient :</th>
                                                                    <td><input class="invoice-inputs" type='text' value='{{$orderDetail->contactDetails['title_name']}} {{$orderDetail->contactDetails['first_name']}} {{$orderDetail->contactDetails['last_name']}}' readonly/></td>
                                                                </tr>

                                                                @if ($orderItem->ex_factory_id == 0)
                                                                    <tr>
                                                                        <th rowspan="4" style="vertical-align: top !important; padding-top: 0.5rem !important;">Ex-Factory Address :</th>
                                                                        <td><input class="invoice-inputs" type='text' value='Same as Customer Address' readonly/></td>
                                                                        </tr>
                                                                    <tr>
                                                                        <td><input class="invoice-inputs" type='text' value='{{$orderDetail->street}}' readonly/></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><input class="invoice-inputs" type='text' value='{{$orderDetail->city}} {{$orderDetail->state}} {{$orderDetail->postal_code}}' readonly/></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><input class="invoice-inputs" type='text' value='{{$orderDetail->country}}' readonly/></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Phone Number :</th>
                                                                        <td><input class="invoice-inputs" type='text' value='{{$orderDetail->phone_no}}' readonly/></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Email Address :</th>
                                                                        <td><input class="invoice-inputs" type='text' value='{{$orderDetail->email}}' readonly/></td>
                                                                    </tr>
                                                                @endif
                                                            </table>
                                                        </div>

                                                        <div class="col-md-6 mt-1">
                                                            <table class="table shipping_details">
                                                                <tr>
                                                                    <th>Primary Fabric :</th>
                                                                    @if (isset($orderItem->fabric_id) && $orderItem->fabric_id != 0)
                                                                        <td><input class="invoice-inputs" type='text' value='{{$orderItem->fabricDetails['fabric_name']}}' readonly/></td>
                                                                    @else
                                                                        <td><input class="invoice-inputs" type='text' value='' readonly/></td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <th>Secondary Fabric :</th>
                                                                    @if (isset($orderItem->secondary_fabric_id) && $orderItem->secondary_fabric_id != 0)
                                                                        <td><input class="invoice-inputs" type='text' value='{{$orderItem->secFabricDetails['fabric_name']}}' readonly/></td>
                                                                    @else
                                                                        <td><input class="invoice-inputs" type='text' value='' readonly/></td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <th>Embellishment :</th>
                                                                    @if (isset($orderItem->embellishment_type_id) && $orderItem->embellishment_type_id != 0)
                                                                        <td><input class="invoice-inputs" type='text' value='{{$orderItem->embellishmentDetails['embellishment_name']}}' readonly/></td>
                                                                    @else
                                                                        <td><input class="invoice-inputs" type='text' value='' readonly/></td>
                                                                    @endif
                                                                </tr>
                                                                    <td>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" id="doubleSided{{$orderItem->id}}" value="1" {{ $orderItem->double_sided ? 'checked' : '' }} disabled />
                                                                            <label class="custom-control-label" for="doubleSided{{$orderItem->id}}">&nbsp; Double Sided</label>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" id="individualno{{$orderItem->id}}" value="1" {{ $orderItem->individual_no ? 'checked' : '' }} disabled />
                                                                            <label class="custom-control-label" for="individualno{{$orderItem->id}}">&nbsp;Individual Number</label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" id="pockets{{$orderItem->id}}" value="1" {{ $orderItem->pockets ? 'checked' : '' }} disabled />
                                                                            <label class="custom-control-label" for="pockets{{$orderItem->id}}">&nbsp; Pockets</label>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" id="individualname{{$orderItem->id}}" value="1" {{ $orderItem->individual_name ? 'checked' : '' }} disabled />
                                                                            <label class="custom-control-label" for="individualname{{$orderItem->id}}">&nbsp;Individual Name</label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" id="zipperedpockets{{$orderItem->id}}" value="1" {{ $orderItem->zipper_pockets ? 'checked' : '' }} disabled />
                                                                            <label class="custom-control-label" for="zipperedpockets{{$orderItem->id}}">&nbsp; Zippered Pockets</label>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" id="dynamicDetails{{$orderItem->id}}" value="1" {{ $orderItem->dynamic_details ? 'checked' : '' }} disabled />
                                                                            <label class="custom-control-label" for="dynamicDetails{{$orderItem->id}}">&nbsp;Dynamic Details</label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" id="contrastSteching{{$orderItem->id}}" value="1" {{ $orderItem->contrast_stratching ? 'checked' : '' }} disabled />
                                                                            <label class="custom-control-label" for="contrastSteching{{$orderItem->id}}">&nbsp; Contrast Stitching </label>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" id="pringOverSeams{{$orderItem->id}}" value="1" {{ $orderItem->printing_over_sems ? 'checked' : '' }} disabled />
                                                                            <label class="custom-control-label" for="pringOverSeams{{$orderItem->id}}">&nbsp;Printing over Seams</label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>

                                                        <div class="col-md-6 mt-1">
                                                            {{-- Unit Price --}}
                                                            <table class="table shipping_details">
                                                                <tr>
                                                                    <th style="width: 150px;">Unit Price ($):</th>
                                                                    <td><input class="invoice-inputs text-right text-bold text-danger text-large unit-price" name="orderItem[{{$orderItem->id}}][unitprice]" type='text' value="{{$orderItem->unit_price}}" readonly /></td>
                                                                </tr>
                                                            </table>

                                                            <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 0px 15px;">
                                                                <table class="table shipping_details">
                                                                    <tr>
                                                                        <th>Tracking No:</th>
                                                                        <td><input class="invoice-inputs" type='text' value="{{$orderItem->tracking_no}}" readonly /></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Tracking Link:</th>
                                                                        <td style="display: flex;">
                                                                            <input class="invoice-inputs" id="tracking_link_{{$orderItem->id}}" type='text' value="{{$orderItem->tracking_link}}" readonly/>
                                                                            @if ($orderItem->tracking_link != null)
                                                                                <a target="_blank" href="{{$orderItem->tracking_link}}" class="btn btn-custom btn-info">
                                                                                    <i class="fas fa-external-link-alt"></i>
                                                                                </a>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-3 mb-3" style="margin-right: 0; margin-left: 0;">
                                                        <div class="col-md-12 tab-container row">
                                                            <div class="tab col-md-2" style="margin-top: 15px; margin-bottom: 15px; border-right: 1px solid #e4e4e4; padding-right: unset; padding-left: unset;">
                                                                {{-- <button type="button" class="tablinks active" onclick="openTab(event, 'mock_up_tab_{{ $orderItem->id }}')"><i class="fab fa-unsplash"></i>&nbsp; Mock Up</button> --}}
                                                                <button type="button" class="tablinks active" onclick="openTab(event, 'teck_pack_tab_{{ $orderItem->id }}')"><i class="fab fa-servicestack"></i>&nbsp; TECH PACK</button>
                                                                <button type="button" class="tablinks" onclick="openTab(event, 'production_layout_tab_{{ $orderItem->id }}')"><i class="fas fa-hamsa"></i>&nbsp; PRODUCTION LAYOUT</button>
                                                                {{-- <button type="button" class="tablinks" onclick="openTab(event, 'product_picture_tab_{{ $orderItem->id }}')"><i class="fab fa-product-hunt"></i>&nbsp; Product Picture</button> --}}
                                                                {{-- <button type="button" class="tablinks" onclick="openTab(event, 'factory_photos_tab_{{ $orderItem->id }}')"><i class="fas fa-industry"></i>&nbsp; Factory Photos</button> --}}
                                                                {{-- <button type="button" class="tablinks" onclick="openTab(event, 'cropped_photos_tab_{{ $orderItem->id }}')"><i class="fas fa-crop"></i>&nbsp; Cropped Photos</button> --}}
                                                            </div>

                                                            {{-- <div id="mock_up_tab_{{ $orderItem->id }}" class="tabcontent" style="display: block;">
                                                                <div class="card-body" style="padding: .4rem; padding-top: 1rem; padding-bottom: 1rem;">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label class="form-lable" style="display: contents;">Mock Up Files [ <i class="fas fa-upload"></i> PDF <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" width="20px" />]</label>
                                                                            <input id="mock_up_files_{{ $orderItem->id }}" name="mock_up_files[{{ $orderItem->id }}][]" data-browse-on-zone-click="true" type="file" multiple disabled>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="form-lable" style="display: contents;">Mock Up Images [ <i class="fas fa-upload"></i> JPG <img src="{{ asset('argon') }}/img/icons/image_icon.png" width="20px" />]</label>
                                                                            <input id="mock_up_images_{{ $orderItem->id }}" name="mock_up_images[{{ $orderItem->id }}][]" data-browse-on-zone-click="true" type="file" multiple disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> --}}

                                                            <div id="teck_pack_tab_{{ $orderItem->id }}" class="tabcontent col-md-10" style="display: block;">
                                                                <div class="card-body" style="padding: .4rem; padding-top: 1rem; padding-bottom: 1rem;">
                                                                    <div class="row">
                                                                        {{-- <div class="col-md-6">
                                                                            <label class="form-lable" style="display: contents;">Tech Pack Files [
                                                                                <i class="fas fa-upload"></i> PDF <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" width="20px" />]</label>
                                                                                <input id="teck_pack_files_{{ $orderItem->id }}" name="teck_pack_files[{{ $orderItem->id }}][]" data-browse-on-zone-click="true" type="file" multiple disabled>
                                                                        </div> --}}
                                                                        <div class="col-md-12">
                                                                            <label class="form-lable" style="display: contents;">Tech Pack Images [ <i class="fas fa-upload"></i> JPG <img src="{{ asset('argon') }}/img/icons/image_icon.png" width="15px" />]</label>
                                                                            <input id="teck_pack_images_{{ $orderItem->id }}" name="teck_pack_images[{{ $orderItem->id }}][]" data-browse-on-zone-click="true" type="file" multiple disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div id="production_layout_tab_{{ $orderItem->id }}" class="tabcontent col-md-10">
                                                                <div class="card-body" style="padding: .4rem; padding-top: 1rem; padding-bottom: 1rem;">
                                                                    <div class="row">
                                                                        {{-- <div class="col-md-6">
                                                                            <label class="form-lable" style="display: contents;">Production Layout Files [ <i class="fas fa-upload"></i> PDF <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" width="20px" />]</label>
                                                                            <input id="production_layout_files_{{ $orderItem->id }}" name="production_layout_files[{{ $orderItem->id }}][]" data-browse-on-zone-click="true" type="file" multiple disabled>
                                                                        </div> --}}
                                                                        <div class="col-md-12">
                                                                            <label class="form-lable" style="display: contents;">Production Layout Images [ <i class="fas fa-upload"></i> JPG <img src="{{ asset('argon') }}/img/icons/image_icon.png" width="15px" />]</label>
                                                                            <input id="production_layout_images_{{ $orderItem->id }}" name="production_layout_images[{{ $orderItem->id }}][]" data-browse-on-zone-click="true" type="file" multiple disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            {{-- <div id="product_picture_tab_{{ $orderItem->id }}" class="tabcontent">
                                                                <div class="card-body" style="padding: .4rem; padding-top: 1rem; padding-bottom: 1rem;">
                                                                    <div class="row">
                                                                        <div class="col-md-6" style="display: none;">
                                                                            <label class="form-lable" style="display: contents;">Product Picture Files [ <i class="fas fa-upload"></i> PDF <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" width="20px" />]</label>
                                                                            <input id="product_picture_files_{{ $orderItem->id }}" name="product_picture_files[{{ $orderItem->id }}][]" data-browse-on-zone-click="true" type="file" multiple disabled>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <label class="form-lable" style="display: contents;">Product Picture Images [ <i class="fas fa-upload"></i> JPG <img src="{{ asset('argon') }}/img/icons/image_icon.png" width="20px" />]</label>
                                                                            <input id="product_picture_images_{{ $orderItem->id }}" name="product_picture_images[{{ $orderItem->id }}][]" data-browse-on-zone-click="true" type="file" multiple disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> --}}

                                                            {{-- <div id="factory_photos_tab_{{ $orderItem->id }}" class="tabcontent">
                                                                <div class="card-body" style="padding: .4rem; padding-top: 1rem; padding-bottom: 1rem;">
                                                                    <div class="row">
                                                                        <div class="col-md-6" style="display: none;">
                                                                            <label class="form-lable" style="display: contents;">Factory Photos Files [ <i class="fas fa-upload"></i> PDF <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" width="20px" />]</label>
                                                                            <input id="factory_photos_files_{{ $orderItem->id }}" name="factory_photos_files[{{ $orderItem->id }}][]" data-browse-on-zone-click="true" type="file" multiple disabled>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <label class="form-lable" style="display: contents;">Factory Photos Images [ <i class="fas fa-upload"></i> JPG <img src="{{ asset('argon') }}/img/icons/image_icon.png" width="20px" />]</label>
                                                                            <input id="factory_photos_images_{{ $orderItem->id }}" name="factory_photos_images[{{ $orderItem->id }}][]" data-browse-on-zone-click="true" type="file" multiple disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> --}}

                                                            {{-- <div id="cropped_photos_tab_{{ $orderItem->id }}" class="tabcontent">
                                                                <div class="card-body" style="padding: .4rem; padding-top: 1rem; padding-bottom: 1rem;">
                                                                    <div class="row">
                                                                        <div class="col-md-6" style="display: none;">
                                                                            <label class="form-lable" style="display: contents;">Cropped Photos Files [ <i class="fas fa-upload"></i> PDF <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" width="20px" />]</label>
                                                                            <input id="cropped_photos_files_{{ $orderItem->id }}" name="cropped_photos_files[{{ $orderItem->id }}][]" data-browse-on-zone-click="true" type="file" multiple disabled>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <label class="form-lable" style="display: contents;">Cropped Photos Images [ <i class="fas fa-upload"></i> JPG <img src="{{ asset('argon') }}/img/icons/image_icon.png" width="20px" />]</label>
                                                                            <input id="cropped_photos_images_{{ $orderItem->id }}" name="cropped_photos_images[{{ $orderItem->id }}][]" data-browse-on-zone-click="true" type="file" multiple disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> --}}
                                                        </div>
                                                    </div>

                                                    <nav>
                                                        <div class="nav nav-tabs nav-fill" id="nav-tab4" role="tablist">

                                                            <a style="max-width: 217px;" class="nav-item nav-link active" id="orderRoster_{{ $orderItem->id }}" data-toggle="tab" href="#orderRoster_tab_{{ $orderItem->id }}" role="tab"
                                                                aria-controls="invoice" aria-selected="true">Order Roster</a>

                                                            <a @if ($orderItem->individual_name == 0) style="max-width: 217px; display: none;" @else style="max-width: 217px;" @endif
                                                                class="nav-item nav-link rosterPlayerNameSection"
                                                                id="orderRosterName_{{ $orderItem->id }}"
                                                                data-sectionLinks="formRosterPlayerNames{{$orderItem->id}}"
                                                                data-toggle="tab"
                                                                href="#orderRosterName_tab_{{ $orderItem->id }}"
                                                                role="tab"
                                                                aria-controls="invoice"
                                                                data-section="rosterPlayerNames"
                                                                aria-selected="true">Roster Player Names</a>

                                                        </div>
                                                    </nav>

                                                    <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                                        <div class="tab-pane fade show active" id="orderRoster_tab_{{ $orderItem->id }}" role="tabpanel" aria-labelledby="orderRoster_{{ $orderItem->id }}">
                                                            <div class="row">
                                                                <div class="col-md-12 text-right">
                                                                    <button type="button" class="btn btn-info btn-sm btn-secondary-custom roster-copy" value="{{ $orderItem->id }}">Copy</button>
                                                                    <button type="button" class="btn btn-info btn-sm btn-secondary-custom roster-paste" value="{{ $orderItem->id }}" style="display: none;">Paste</button>
                                                                </div>

                                                                <div class="col-md-12 mt-1 roster-container">
                                                                    <table class="table Product_details product_details_table roster-table" id="product_details_table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="text-center">BLANK<br>QTY</th>
                                                                                <th class="text-center">NUM<br>QTY</th>
                                                                                <th>Sizes</th>
                                                                                <th colspan="25">Number Sequence</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                            @foreach ($orderItem->orderItemDetails as $orderItemDetail)
                                                                            <div>
                                                                                <tr class="{{"order-".$orderItemDetail->order_item_id.'-'.$orderItemDetail->size_id}} {{"size-".$orderItemDetail->size_id}}"
                                                                                    @if($orderItemDetail->size_id == 18 && ($orderItemDetail->qty == "" || $orderItemDetail->qty == null) && ($orderItemDetail->blanks == "" || $orderItemDetail->blanks == null))
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 19 && ($orderItemDetail->qty == "" || $orderItemDetail->qty == null) && ($orderItemDetail->blanks == "" || $orderItemDetail->blanks == null))
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 21 && ($orderItemDetail->qty == "" || $orderItemDetail->qty == null) && ($orderItemDetail->blanks == "" || $orderItemDetail->blanks == null))
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 22 && ($orderItemDetail->qty == "" || $orderItemDetail->qty == null) && ($orderItemDetail->blanks == "" || $orderItemDetail->blanks == null))
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 24 && ($orderItemDetail->qty == "" || $orderItemDetail->qty == null) && ($orderItemDetail->blanks == "" || $orderItemDetail->blanks == null))
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 25 && ($orderItemDetail->qty == "" || $orderItemDetail->qty == null) && ($orderItemDetail->blanks == "" || $orderItemDetail->blanks == null))
                                                                                        style='display:none'
                                                                                    @else
                                                                                @endif >

                                                                                @php $rowsShowingNumbersequence = 2; @endphp
                                                                                @if(( $orderItemDetail->numseq_fifty_one == "" || $orderItemDetail->numseq_fifty_one == NULL ) && ( $orderItemDetail->numseq_fifty_two == "" || $orderItemDetail->numseq_fifty_two == NULL ) && ( $orderItemDetail->numseq_fifty_three == "" || $orderItemDetail->numseq_fifty_three == NULL ) && ( $orderItemDetail->numseq_fifty_four == "" || $orderItemDetail->numseq_fifty_four == NULL ) && ( $orderItemDetail->numseq_fifty_five == "" || $orderItemDetail->numseq_fifty_five == NULL ) && ( $orderItemDetail->numseq_fifty_six == "" || $orderItemDetail->numseq_fifty_six == NULL ) && ( $orderItemDetail->numseq_fifty_seven == "" || $orderItemDetail->numseq_fifty_seven == NULL ) && ( $orderItemDetail->numseq_fifty_eight == "" || $orderItemDetail->numseq_fifty_eight == NULL ) && ( $orderItemDetail->numseq_fifty_nine == "" || $orderItemDetail->numseq_fifty_nine == NULL ) && ( $orderItemDetail->numseq_sixty == "" || $orderItemDetail->numseq_sixty == NULL ) && ( $orderItemDetail->numseq_sixty_one == "" || $orderItemDetail->numseq_sixty_one == NULL ) && ( $orderItemDetail->numseq_sixty_two == "" || $orderItemDetail->numseq_sixty_two == NULL ) && ( $orderItemDetail->numseq_sixty_three == "" || $orderItemDetail->numseq_sixty_three == NULL ) && ( $orderItemDetail->numseq_sixty_four == "" || $orderItemDetail->numseq_sixty_four == NULL ) && ( $orderItemDetail->numseq_sixty_five == "" || $orderItemDetail->numseq_sixty_five == NULL ) && ( $orderItemDetail->numseq_sixty_six == "" || $orderItemDetail->numseq_sixty_six == NULL ) && ( $orderItemDetail->numseq_sixty_seven == "" || $orderItemDetail->numseq_sixty_seven == NULL ) && ( $orderItemDetail->numseq_sixty_eight == "" || $orderItemDetail->numseq_sixty_eight == NULL ) && ( $orderItemDetail->numseq_sixty_nine == "" || $orderItemDetail->numseq_sixty_nine == NULL ) && ( $orderItemDetail->numseq_seventy == "" || $orderItemDetail->numseq_seventy == NULL ) && ( $orderItemDetail->numseq_seventy_one == "" || $orderItemDetail->numseq_seventy_one == NULL ) && ( $orderItemDetail->numseq_seventy_two == "" || $orderItemDetail->numseq_seventy_two == NULL ) && ( $orderItemDetail->numseq_seventy_three == "" || $orderItemDetail->numseq_seventy_three == NULL ) && ( $orderItemDetail->numseq_seventy_four == "" || $orderItemDetail->numseq_seventy_four == NULL ) && ( $orderItemDetail->numseq_seventy_five == "" || $orderItemDetail->numseq_seventy_five == NULL ))
                                                                                    @php $hiddenTrueFalseRow3 = "hidden";  @endphp
                                                                                @else
                                                                                    @php $hiddenTrueFalseRow3 = ""; $rowsShowingNumbersequence++; @endphp
                                                                                @endif

                                                                                @if(( $orderItemDetail->numseq_seventy_six == "" || $orderItemDetail->numseq_seventy_six == NULL ) && ( $orderItemDetail->numseq_seventy_seven == "" || $orderItemDetail->numseq_seventy_seven == NULL ) && ( $orderItemDetail->numseq_seventy_eight == "" || $orderItemDetail->numseq_seventy_eight == NULL ) && ( $orderItemDetail->numseq_seventy_nine == "" || $orderItemDetail->numseq_seventy_nine == NULL ) && ( $orderItemDetail->numseq_eighty == "" || $orderItemDetail->numseq_eighty == NULL ) && ( $orderItemDetail->numseq_eighty_one == "" || $orderItemDetail->numseq_eighty_one == NULL ) && ( $orderItemDetail->numseq_eighty_two == "" || $orderItemDetail->numseq_eighty_two == NULL ) && ( $orderItemDetail->numseq_eighty_three == "" || $orderItemDetail->numseq_eighty_three == NULL ) && ( $orderItemDetail->numseq_eighty_four == "" || $orderItemDetail->numseq_eighty_four == NULL ) && ( $orderItemDetail->numseq_eighty_five == "" || $orderItemDetail->numseq_eighty_five == NULL ) && ( $orderItemDetail->numseq_eighty_six == "" || $orderItemDetail->numseq_eighty_six == NULL ) && ( $orderItemDetail->numseq_eighty_seven == "" || $orderItemDetail->numseq_eighty_seven == NULL ) && ( $orderItemDetail->numseq_eighty_eight == "" || $orderItemDetail->numseq_eighty_eight == NULL ) && ( $orderItemDetail->numseq_eighty_nine == "" || $orderItemDetail->numseq_eighty_nine == NULL ) && ( $orderItemDetail->numseq_ninety == "" || $orderItemDetail->numseq_ninety == NULL ) && ( $orderItemDetail->numseq_ninety_one == "" || $orderItemDetail->numseq_ninety_one == NULL ) && ( $orderItemDetail->numseq_ninety_two == "" || $orderItemDetail->numseq_ninety_two == NULL ) && ( $orderItemDetail->numseq_ninety_three == "" || $orderItemDetail->numseq_ninety_three == NULL ) && ( $orderItemDetail->numseq_ninety_four == "" || $orderItemDetail->numseq_ninety_four == NULL ) && ( $orderItemDetail->numseq_ninety_five == "" || $orderItemDetail->numseq_ninety_five == NULL ) && ( $orderItemDetail->numseq_ninety_six == "" || $orderItemDetail->numseq_ninety_six == NULL ) && ( $orderItemDetail->numseq_ninety_seven == "" || $orderItemDetail->numseq_ninety_seven == NULL ) && ( $orderItemDetail->numseq_ninety_eight == "" || $orderItemDetail->numseq_ninety_eight == NULL ) && ( $orderItemDetail->numseq_ninety_nine == "" || $orderItemDetail->numseq_ninety_nine == NULL ) && ( $orderItemDetail->numseq_hundred == "" || $orderItemDetail->numseq_hundred == NULL ))
                                                                                    @php $hiddenTrueFalseRow4 = "hidden";  @endphp
                                                                                @else
                                                                                    @php $hiddenTrueFalseRow4 = ""; $rowsShowingNumbersequence++; @endphp
                                                                                @endif

                                                                                @if(( $orderItemDetail->numseq_hundred_one == "" || $orderItemDetail->numseq_hundred_one == NULL ) && ( $orderItemDetail->numseq_hundred_two == "" || $orderItemDetail->numseq_hundred_two == NULL ) && ( $orderItemDetail->numseq_hundred_three == "" || $orderItemDetail->numseq_hundred_three == NULL ) && ( $orderItemDetail->numseq_hundred_four == "" || $orderItemDetail->numseq_hundred_four == NULL ) && ( $orderItemDetail->numseq_hundred_five == "" || $orderItemDetail->numseq_hundred_five == NULL ) && ( $orderItemDetail->numseq_hundred_six == "" || $orderItemDetail->numseq_hundred_six == NULL ) && ( $orderItemDetail->numseq_hundred_seven == "" || $orderItemDetail->numseq_hundred_seven == NULL ) && ( $orderItemDetail->numseq_hundred_eight == "" || $orderItemDetail->numseq_hundred_eight == NULL ) && ( $orderItemDetail->numseq_hundred_nine == "" || $orderItemDetail->numseq_hundred_nine == NULL ) && ( $orderItemDetail->numseq_hundred_ten == "" || $orderItemDetail->numseq_hundred_ten == NULL ) && ( $orderItemDetail->numseq_hundred_eleven == "" || $orderItemDetail->numseq_hundred_eleven == NULL ) && ( $orderItemDetail->numseq_hundred_twelve == "" || $orderItemDetail->numseq_hundred_twelve == NULL ) && ( $orderItemDetail->numseq_hundred_thirteen == "" || $orderItemDetail->numseq_hundred_thirteen == NULL ) && ( $orderItemDetail->numseq_hundred_fourteen == "" || $orderItemDetail->numseq_hundred_fourteen == NULL ) && ( $orderItemDetail->numseq_hundred_fifteen == "" || $orderItemDetail->numseq_hundred_fifteen == NULL ) && ( $orderItemDetail->numseq_hundred_sixteen == "" || $orderItemDetail->numseq_hundred_sixteen == NULL ) && ( $orderItemDetail->numseq_hundred_seventeen == "" || $orderItemDetail->numseq_hundred_seventeen == NULL ) && ( $orderItemDetail->numseq_hundred_eighteen == "" || $orderItemDetail->numseq_hundred_eighteen == NULL ) && ( $orderItemDetail->numseq_hundred_nineteen == "" || $orderItemDetail->numseq_hundred_nineteen == NULL ) && ( $orderItemDetail->numseq_hundred_twenty == "" || $orderItemDetail->numseq_hundred_twenty == NULL ) && ( $orderItemDetail->numseq_hundred_twenty_one == "" || $orderItemDetail->numseq_hundred_twenty_one == NULL ) && ( $orderItemDetail->numseq_hundred_twenty_two == "" || $orderItemDetail->numseq_hundred_twenty_two == NULL ) && ( $orderItemDetail->numseq_hundred_twenty_three == "" || $orderItemDetail->numseq_hundred_twenty_three == NULL ) && ( $orderItemDetail->twenty_four == "" || $orderItemDetail->twenty_four == NULL ) && ( $orderItemDetail->numseq_hundred_twenty_five == "" || $orderItemDetail->numseq_hundred_twenty_five == NULL ))
                                                                                    @php $hiddenTrueFalseRow5 = "hidden";  @endphp
                                                                                @else
                                                                                    @php $hiddenTrueFalseRow5 = ""; $rowsShowingNumbersequence++; @endphp
                                                                                @endif

                                                                                @if(( $orderItemDetail->numseq_hundred_twenty_six == "" || $orderItemDetail->numseq_seventy_six == NULL ) && ( $orderItemDetail->numseq_hundred_twenty_seven == "" || $orderItemDetail->numseq_hundred_twenty_seven == NULL ) && ( $orderItemDetail->numseq_hundred_twenty_eight == "" || $orderItemDetail->numseq_hundred_twenty_eight == NULL ) && ( $orderItemDetail->numseq_hundred_twenty_nine == "" || $orderItemDetail->numseq_hundred_twenty_nine == NULL ) && ( $orderItemDetail->numseq_hundred_thirty == "" || $orderItemDetail->numseq_hundred_thirty == NULL ) && ( $orderItemDetail->numseq_hundred_thirty_one == "" || $orderItemDetail->numseq_hundred_thirty_one == NULL ) && ( $orderItemDetail->numseq_hundred_thirty_two == "" || $orderItemDetail->numseq_hundred_thirty_two == NULL ) && ( $orderItemDetail->numseq_hundred_thirty_three == "" || $orderItemDetail->numseq_hundred_thirty_three == NULL ) && ( $orderItemDetail->numseq_hundred_thirty_four == "" || $orderItemDetail->numseq_hundred_thirty_four == NULL ) && ( $orderItemDetail->numseq_hundred_thirty_five == "" || $orderItemDetail->numseq_hundred_thirty_five == NULL ) && ( $orderItemDetail->numseq_hundred_thirty_six == "" || $orderItemDetail->numseq_hundred_thirty_six == NULL ) && ( $orderItemDetail->numseq_hundred_thirty_seven == "" || $orderItemDetail->numseq_hundred_thirty_seven == NULL ) && ( $orderItemDetail->numseq_hundred_thirty_eight == "" || $orderItemDetail->numseq_hundred_thirty_eight == NULL ) && ( $orderItemDetail->numseq_hundred_thirty_nine == "" || $orderItemDetail->numseq_hundred_thirty_nine == NULL ) && ( $orderItemDetail->numseq_hundred_fourty == "" || $orderItemDetail->numseq_hundred_fourty == NULL ) && ( $orderItemDetail->numseq_hundred_fourty_one == "" || $orderItemDetail->numseq_hundred_fourty_one == NULL ) && ( $orderItemDetail->numseq_hundred_fourty_two == "" || $orderItemDetail->numseq_hundred_fourty_two == NULL ) && ( $orderItemDetail->numseq_hundred_fourty_three == "" || $orderItemDetail->numseq_hundred_fourty_three == NULL ) && ( $orderItemDetail->numseq_hundred_fourty_four == "" || $orderItemDetail->numseq_hundred_fourty_four == NULL ) && ( $orderItemDetail->numseq_hundred_fourty_five == "" || $orderItemDetail->numseq_hundred_fourty_five == NULL ) && ( $orderItemDetail->numseq_hundred_fourty_six == "" || $orderItemDetail->numseq_hundred_fourty_six == NULL ) && ( $orderItemDetail->numseq_hundred_fourty_seven == "" || $orderItemDetail->numseq_hundred_fourty_seven == NULL ) && ( $orderItemDetail->numseq_hundred_fourty_eight == "" || $orderItemDetail->numseq_hundred_fourty_eight == NULL ) && ( $orderItemDetail->numseq_hundred_fourty_nine == "" || $orderItemDetail->numseq_hundred_fourty_nine == NULL ) && ( $orderItemDetail->numseq_hundred_fifty == "" || $orderItemDetail->numseq_hundred_fifty == NULL ))
                                                                                    @php $hiddenTrueFalseRow6 = "hidden";  @endphp
                                                                                @else
                                                                                    @php $hiddenTrueFalseRow6 = ""; $rowsShowingNumbersequence = 6; @endphp
                                                                                @endif

                                                                                    <td class="wi-2 {{ $orderItemDetail->id."rowspans" }}" rowspan="{{ $rowsShowingNumbersequence }}">
                                                                                        <input class="form-control form-control-bc hi-69 text-center blankseq hide-arrows" name="product[{{$orderItemDetail->id}}][blanks]" type='number' value="{{$orderItemDetail->blanks}}" data-AlradySaved="{{$orderItemDetail->blanks}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif />
                                                                                        <input class="form-control form-control-bc hi-69 text-center" name="product[{{$orderItemDetail->id}}][orderNo]"  value="{{$orderItemDetail->id}}" type='hidden'/>
                                                                                    </td>
                                                                                    <td class="wi-2 {{ $orderItemDetail->id."rowspans" }}" rowspan="{{ $rowsShowingNumbersequence }}"><input class="form-control form-control-bc hi-69 text-center qtyseq qtyseq{{ $orderItemDetail->id}}" name="product[{{$orderItemDetail->id}}][qty]" type='text' value='{{$orderItemDetail->qty}}' data-AlradySaved="{{$orderItemDetail->qty}}" readonly/></td>

                                                                                    @if ($orderItemDetail->sizeDetails['size_name'] == "Extra Size One")
                                                                                        <th class="wi-10 {{ $orderItemDetail->id."rowspans" }}" rowspan="{{ $rowsShowingNumbersequence }}"><input type="text" class="invoice-inputs hi-69 txtSizeName" name="orderItem[{{$orderItem->id}}][extra_size]" value="@if($orderItem->extra_size=="1") {{ 'Extra Size One' }} @else {{$orderItem->extra_size}} @endif" data-AlradySaved="@if($orderItem->extra_size=="1") {{ 'Extra Size One' }} @else {{$orderItem->extra_size}} @endif" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif  /></th>

                                                                                    @elseif ( $orderItemDetail->sizeDetails['size_name'] == "Extra Size Two")
                                                                                        <th class="wi-10 {{ $orderItemDetail->id."rowspans" }}" rowspan="{{ $rowsShowingNumbersequence }}"><input type="text" class="invoice-inputs hi-69 txtSizeName" name="orderItem[{{$orderItem->id}}][extra_size_two]" value="@if($orderItem->extra_size_two=="1") {{ 'Extra Size Two' }} @else {{$orderItem->extra_size_two}} @endif" data-AlradySaved="@if($orderItem->extra_size_two=="1") {{ 'Extra Size Two' }} @else {{$orderItem->extra_size_two}} @endif" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif  /></th>

                                                                                    @elseif ($orderItemDetail->sizeDetails['size_name'] == "Extra Size Three")
                                                                                        <th class="wi-10 {{ $orderItemDetail->id."rowspans" }}" rowspan="{{ $rowsShowingNumbersequence }}"><input type="text" class="invoice-inputs hi-69 txtSizeName" name="orderItem[{{$orderItem->id}}][extra_size_three]" value="@if($orderItem->extra_size_three=="1") {{ 'Extra Size Three' }} @else {{$orderItem->extra_size_three}} @endif" data-AlradySaved="@if($orderItem->extra_size_three=="1") {{ 'Extra Size Three' }} @else {{$orderItem->extra_size_three}} @endif" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif  /></th>

                                                                                    @else
                                                                                        <th class="wi-10 {{ $orderItemDetail->id."rowspans" }}" rowspan="{{ $rowsShowingNumbersequence }}">{{$orderItemDetail->sizeDetails['size_name']}}</th>
                                                                                    @endif
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_one]" value="{{$orderItemDetail->numseq_one}}" data-AlradySaved="{{$orderItemDetail->numseq_one}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_two]" value="{{$orderItemDetail->numseq_two}}" data-AlradySaved="{{$orderItemDetail->numseq_two}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_three]" value="{{$orderItemDetail->numseq_three}}" data-AlradySaved="{{$orderItemDetail->numseq_three}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_four]" value="{{$orderItemDetail->numseq_four}}" data-AlradySaved="{{$orderItemDetail->numseq_four}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_five]" value="{{$orderItemDetail->numseq_five}}" data-AlradySaved="{{$orderItemDetail->numseq_five}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_six]" value="{{$orderItemDetail->numseq_six}}" data-AlradySaved="{{$orderItemDetail->numseq_six}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_seven]" value="{{$orderItemDetail->numseq_seven}}" data-AlradySaved="{{$orderItemDetail->numseq_seven}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_eight]" value="{{$orderItemDetail->numseq_eight}}" data-AlradySaved="{{$orderItemDetail->numseq_eight}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_nine]" value="{{$orderItemDetail->numseq_nine}}" data-AlradySaved="{{$orderItemDetail->numseq_nine}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_ten]" value="{{$orderItemDetail->numseq_ten}}" data-AlradySaved="{{$orderItemDetail->numseq_ten}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_eleven]" value="{{$orderItemDetail->numseq_eleven}}" data-AlradySaved="{{$orderItemDetail->numseq_eleven}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_twelve]" value="{{$orderItemDetail->numseq_twelve}}" data-AlradySaved="{{$orderItemDetail->numseq_twelve}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_thirteen]" value="{{$orderItemDetail->numseq_thirteen}}" data-AlradySaved="{{$orderItemDetail->numseq_thirteen}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_fourteen]" value="{{$orderItemDetail->numseq_fourteen}}" data-AlradySaved="{{$orderItemDetail->numseq_fourteen}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_fifteen]" value="{{$orderItemDetail->numseq_fifteen}}" data-AlradySaved="{{$orderItemDetail->numseq_fifteen}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_sixteen]" value="{{$orderItemDetail->numseq_sixteen}}" data-AlradySaved="{{$orderItemDetail->numseq_sixteen}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_seventeen]" value="{{$orderItemDetail->numseq_seventeen}}" data-AlradySaved="{{$orderItemDetail->numseq_seventeen}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_eighteen]" value="{{$orderItemDetail->numseq_eighteen}}" data-AlradySaved="{{$orderItemDetail->numseq_eighteen}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_nineteen]" value="{{$orderItemDetail->numseq_nineteen}}" data-AlradySaved="{{$orderItemDetail->numseq_nineteen}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_twenty]" value="{{$orderItemDetail->numseq_twenty}}" data-AlradySaved="{{$orderItemDetail->numseq_twenty}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_twenty_one]" value="{{$orderItemDetail->numseq_twenty_one}}" data-AlradySaved="{{$orderItemDetail->numseq_twenty_one}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_twenty_two]" value="{{$orderItemDetail->numseq_twenty_two}}" data-AlradySaved="{{$orderItemDetail->numseq_twenty_two}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_twenty_three]" value="{{$orderItemDetail->numseq_twenty_three}}" data-AlradySaved="{{$orderItemDetail->numseq_twenty_three}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_twenty_four]" value="{{$orderItemDetail->numseq_twenty_four}}" data-AlradySaved="{{$orderItemDetail->numseq_twenty_four}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_twenty_five]"value="{{$orderItemDetail->numseq_twenty_five}}" data-AlradySaved="{{$orderItemDetail->numseq_twenty_five}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                </tr>
                                                                                <tr class="{{"order-".$orderItemDetail->order_item_id.'-'.$orderItemDetail->size_id}} {{"size-".$orderItemDetail->size_id}}"
                                                                                    @if($orderItemDetail->size_id == 18 && $orderItemDetail->qty == "" && $orderItemDetail->blanks == "")
                                                                                    style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 19 && $orderItemDetail->qty == "" && $orderItemDetail->blanks == "")
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 21 && $orderItemDetail->qty == "" && $orderItemDetail->blanks == "")
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 22 && $orderItemDetail->qty == "" && $orderItemDetail->blanks == "")
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 24 && $orderItemDetail->qty == "" && $orderItemDetail->blanks == "")
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 25 && $orderItemDetail->qty == "" && $orderItemDetail->blanks == "")
                                                                                        style='display:none'
                                                                                    @else @endif >
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_twenty_six]"  value="{{$orderItemDetail->numseq_twenty_six}}" data-AlradySaved="{{$orderItemDetail->numseq_twenty_six}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_twenty_seven]"  value="{{$orderItemDetail->numseq_twenty_seven}}" data-AlradySaved="{{$orderItemDetail->numseq_twenty_seven}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_twenty_eight]" value="{{$orderItemDetail->numseq_twenty_eight}}" data-AlradySaved="{{$orderItemDetail->numseq_twenty_eight}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_twenty_nine]"  value="{{$orderItemDetail->numseq_twenty_nine}}" data-AlradySaved="{{$orderItemDetail->numseq_twenty_nine}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_thirty]"  value="{{$orderItemDetail->numseq_thirty}}" data-AlradySaved="{{$orderItemDetail->numseq_thirty}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_thirty_one]"  value="{{$orderItemDetail->numseq_thirty_one}}" data-AlradySaved="{{$orderItemDetail->numseq_thirty_one}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_thirty_two]"  value="{{$orderItemDetail->numseq_thirty_two}}" data-AlradySaved="{{$orderItemDetail->numseq_thirty_two}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_thirty_three]"  value="{{$orderItemDetail->numseq_thirty_three}}" data-AlradySaved="{{$orderItemDetail->numseq_thirty_three}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_thirty_four]"  value="{{$orderItemDetail->numseq_thirty_four}}" data-AlradySaved="{{$orderItemDetail->numseq_thirty_four}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_thirty_five]"  value="{{$orderItemDetail->numseq_thirty_five}}" data-AlradySaved="{{$orderItemDetail->numseq_thirty_five}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_thirty_six]" value="{{$orderItemDetail->numseq_thirty_six}}" data-AlradySaved="{{$orderItemDetail->numseq_thirty_six}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_thirty_seven]"  value="{{$orderItemDetail->numseq_thirty_seven}}" data-AlradySaved="{{$orderItemDetail->numseq_thirty_seven}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_thirty_eight]"  value="{{$orderItemDetail->numseq_thirty_eight}}" data-AlradySaved="{{$orderItemDetail->numseq_thirty_eight}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_thirty_nine]"  value="{{$orderItemDetail->numseq_thirty_nine}}" data-AlradySaved="{{$orderItemDetail->numseq_thirty_nine}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_forty]"  value="{{$orderItemDetail->numseq_forty}}" data-AlradySaved="{{$orderItemDetail->numseq_forty}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_forty_one]"  value="{{$orderItemDetail->numseq_forty_one}}" data-AlradySaved="{{$orderItemDetail->numseq_forty_one}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_forty_two]"  value="{{$orderItemDetail->numseq_forty_two}}" data-AlradySaved="{{$orderItemDetail->numseq_forty_two}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_forty_three]"  value="{{$orderItemDetail->numseq_forty_three}}" data-AlradySaved="{{$orderItemDetail->numseq_forty_three}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_forty_four]"  value="{{$orderItemDetail->numseq_forty_four}}" data-AlradySaved="{{$orderItemDetail->numseq_forty_four}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_forty_five]"  value="{{$orderItemDetail->numseq_forty_five}}" data-AlradySaved="{{$orderItemDetail->numseq_forty_five}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_forty_six]"  value="{{$orderItemDetail->numseq_forty_six}}" data-AlradySaved="{{$orderItemDetail->numseq_forty_six}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_forty_seven]"  value="{{$orderItemDetail->numseq_forty_seven}}" data-AlradySaved="{{$orderItemDetail->numseq_forty_seven}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_forty_eight]"  value="{{$orderItemDetail->numseq_forty_eight}}" data-AlradySaved="{{$orderItemDetail->numseq_forty_eight}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_forty_nine]"  value="{{$orderItemDetail->numseq_forty_nine}}" data-AlradySaved="{{$orderItemDetail->numseq_forty_nine}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below  numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_fifty]"  value="{{$orderItemDetail->numseq_fifty}}" data-AlradySaved="{{$orderItemDetail->numseq_fifty}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                </tr>

                                                                                <tr class="{{"order-".$orderItemDetail->order_item_id.'-'.$orderItemDetail->size_id}} {{"size-".$orderItemDetail->size_id}} {{ " " }} {{ $orderItemDetail->id."row1Hidden" }}"  @php echo $hiddenTrueFalseRow3; @endphp
                                                                                    @if($orderItemDetail->size_id == 18 && $orderItemDetail->qty == "")
                                                                                    style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 19 && $orderItemDetail->qty == "")
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 21 && $orderItemDetail->qty == "")
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 22 && $orderItemDetail->qty == "")
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 24 && $orderItemDetail->qty == "")
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 25 && $orderItemDetail->qty == "")
                                                                                        style='display:none'
                                                                                    @else @endif >
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_fifty_one]"  value="{{$orderItemDetail->numseq_fifty_one}}" data-AlradySaved="{{$orderItemDetail->numseq_fifty_one}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_fifty_two]"  value="{{$orderItemDetail->numseq_fifty_two}}" data-AlradySaved="{{$orderItemDetail->numseq_fifty_two}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_fifty_three]" value="{{$orderItemDetail->numseq_fifty_three}}" data-AlradySaved="{{$orderItemDetail->numseq_fifty_three}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_fifty_four]"  value="{{$orderItemDetail->numseq_fifty_four}}" data-AlradySaved="{{$orderItemDetail->numseq_fifty_four}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_fifty_five]"  value="{{$orderItemDetail->numseq_fifty_five}}" data-AlradySaved="{{$orderItemDetail->numseq_fifty_five}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_fifty_six]"  value="{{$orderItemDetail->numseq_fifty_six}}" data-AlradySaved="{{$orderItemDetail->numseq_fifty_six}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_fifty_seven]"  value="{{$orderItemDetail->numseq_fifty_seven}}" data-AlradySaved="{{$orderItemDetail->numseq_fifty_seven}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_fifty_eight]"  value="{{$orderItemDetail->numseq_fifty_eight}}" data-AlradySaved="{{$orderItemDetail->numseq_fifty_eight}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_fifty_nine]"  value="{{$orderItemDetail->numseq_fifty_nine}}" data-AlradySaved="{{$orderItemDetail->numseq_fifty_nine}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_sixty]"  value="{{$orderItemDetail->numseq_sixty}}" data-AlradySaved="{{$orderItemDetail->numseq_sixty}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_sixty_one]" value="{{$orderItemDetail->numseq_sixty_one}}" data-AlradySaved="{{$orderItemDetail->numseq_sixty_one}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_sixty_two]"  value="{{$orderItemDetail->numseq_sixty_two}}" data-AlradySaved="{{$orderItemDetail->numseq_sixty_two}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_sixty_three]"  value="{{$orderItemDetail->numseq_sixty_three}}" data-AlradySaved="{{$orderItemDetail->numseq_sixty_three}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_sixty_four]"  value="{{$orderItemDetail->numseq_sixty_four}}" data-AlradySaved="{{$orderItemDetail->numseq_sixty_four}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_sixty_five]"  value="{{$orderItemDetail->numseq_sixty_five}}" data-AlradySaved="{{$orderItemDetail->numseq_sixty_five}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_sixty_six]"  value="{{$orderItemDetail->numseq_sixty_six}}" data-AlradySaved="{{$orderItemDetail->numseq_sixty_six}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_sixty_seven]"  value="{{$orderItemDetail->numseq_sixty_seven}}" data-AlradySaved="{{$orderItemDetail->numseq_sixty_seven}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_sixty_eight]"  value="{{$orderItemDetail->numseq_sixty_eight}}" data-AlradySaved="{{$orderItemDetail->numseq_sixty_eight}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_sixty_nine]"  value="{{$orderItemDetail->numseq_sixty_nine}}" data-AlradySaved="{{$orderItemDetail->numseq_sixty_nine}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_seventy]"  value="{{$orderItemDetail->numseq_seventy}}" data-AlradySaved="{{$orderItemDetail->numseq_seventy}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_seventy_one]"  value="{{$orderItemDetail->numseq_seventy_one}}" data-AlradySaved="{{$orderItemDetail->numseq_seventy_one}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_seventy_two]"  value="{{$orderItemDetail->numseq_seventy_two}}" data-AlradySaved="{{$orderItemDetail->numseq_seventy_two}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_seventy_three]"  value="{{$orderItemDetail->numseq_seventy_three}}" data-AlradySaved="{{$orderItemDetail->numseq_seventy_three}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_seventy_four]"  value="{{$orderItemDetail->numseq_seventy_four}}" data-AlradySaved="{{$orderItemDetail->numseq_seventy_four}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below1 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_seventy_five]"  value="{{$orderItemDetail->numseq_seventy_five}}" data-AlradySaved="{{$orderItemDetail->numseq_seventy_five}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                </tr>


                                                                                <tr class="{{"order-".$orderItemDetail->order_item_id.'-'.$orderItemDetail->size_id}} {{"size-".$orderItemDetail->size_id}} {{ " " }} {{ $orderItemDetail->id."row2Hidden" }}"  @php echo $hiddenTrueFalseRow4; @endphp
                                                                                    @if($orderItemDetail->size_id == 18 && $orderItemDetail->qty == "")
                                                                                    style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 19 && $orderItemDetail->qty == "")
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 21 && $orderItemDetail->qty == "")
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 22 && $orderItemDetail->qty == "")
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 24 && $orderItemDetail->qty == "")
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 25 && $orderItemDetail->qty == "")
                                                                                        style='display:none'
                                                                                    @else @endif >
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_seventy_six]"  value="{{$orderItemDetail->numseq_seventy_six}}" data-AlradySaved="{{$orderItemDetail->numseq_seventy_six}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_seventy_seven]"  value="{{$orderItemDetail->numseq_seventy_seven}}" data-AlradySaved="{{$orderItemDetail->numseq_seventy_seven}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_seventy_eight]" value="{{$orderItemDetail->numseq_seventy_eight}}" data-AlradySaved="{{$orderItemDetail->numseq_seventy_eight}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_seventy_nine]"  value="{{$orderItemDetail->numseq_seventy_nine}}" data-AlradySaved="{{$orderItemDetail->numseq_seventy_nine}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_eighty]"  value="{{$orderItemDetail->numseq_eighty}}" data-AlradySaved="{{$orderItemDetail->numseq_eighty}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_eighty_one]"  value="{{$orderItemDetail->numseq_eighty_one}}" data-AlradySaved="{{$orderItemDetail->numseq_eighty_one}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_eighty_two]"  value="{{$orderItemDetail->numseq_eighty_two}}" data-AlradySaved="{{$orderItemDetail->numseq_eighty_two}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][umseq_eighty_three]"  value="{{$orderItemDetail->numseq_eighty_three}}" data-AlradySaved="{{$orderItemDetail->numseq_eighty_three}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_eighty_four]"  value="{{$orderItemDetail->numseq_eighty_four}}" data-AlradySaved="{{$orderItemDetail->numseq_eighty_four}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_eighty_five]"  value="{{$orderItemDetail->numseq_eighty_five}}" data-AlradySaved="{{$orderItemDetail->numseq_eighty_five}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_eighty_six]" value="{{$orderItemDetail->numseq_eighty_six}}" data-AlradySaved="{{$orderItemDetail->numseq_eighty_six}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_eighty_seven]"  value="{{$orderItemDetail->numseq_eighty_seven}}" data-AlradySaved="{{$orderItemDetail->numseq_eighty_seven}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_eighty_eight]"  value="{{$orderItemDetail->numseq_eighty_eight}}" data-AlradySaved="{{$orderItemDetail->numseq_eighty_eight}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_eighty_nine]"  value="{{$orderItemDetail->numseq_eighty_nine}}" data-AlradySaved="{{$orderItemDetail->numseq_eighty_nine}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_ninety]"  value="{{$orderItemDetail->numseq_ninety}}" data-AlradySaved="{{$orderItemDetail->numseq_ninety}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_ninety_one]"  value="{{$orderItemDetail->numseq_ninety_one}}" data-AlradySaved="{{$orderItemDetail->numseq_ninety_one}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_ninety_two]"  value="{{$orderItemDetail->numseq_ninety_two}}" data-AlradySaved="{{$orderItemDetail->numseq_ninety_two}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_ninety_three]"  value="{{$orderItemDetail->numseq_ninety_three}}" data-AlradySaved="{{$orderItemDetail->numseq_ninety_three}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_ninety_four]"  value="{{$orderItemDetail->numseq_ninety_four}}" data-AlradySaved="{{$orderItemDetail->numseq_ninety_four}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_ninety_five]"  value="{{$orderItemDetail->numseq_ninety_five}}" data-AlradySaved="{{$orderItemDetail->numseq_ninety_five}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_ninety_six]"  value="{{$orderItemDetail->numseq_ninety_six}}" data-AlradySaved="{{$orderItemDetail->numseq_ninety_six}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_ninety_seven]"  value="{{$orderItemDetail->numseq_ninety_seven}}" data-AlradySaved="{{$orderItemDetail->numseq_ninety_seven}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_ninety_eight]"  value="{{$orderItemDetail->numseq_ninety_eight}}" data-AlradySaved="{{$orderItemDetail->numseq_ninety_eight}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_ninety_nine]"  value="{{$orderItemDetail->numseq_ninety_nine}}" data-AlradySaved="{{$orderItemDetail->numseq_ninety_nine}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below2 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred]"  value="{{$orderItemDetail->numseq_hundred}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                </tr>

                                                                                <tr class="{{"order-".$orderItemDetail->order_item_id.'-'.$orderItemDetail->size_id}} {{"size-".$orderItemDetail->size_id}} {{ " " }} {{ $orderItemDetail->id."row3Hidden" }}"  @php echo $hiddenTrueFalseRow5; @endphp
                                                                                    @if($orderItemDetail->size_id == 18 && $orderItemDetail->qty == "")
                                                                                    style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 19 && $orderItemDetail->qty == "")
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 21 && $orderItemDetail->qty == "")
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 22 && $orderItemDetail->qty == "")
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 24 && $orderItemDetail->qty == "")
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 25 && $orderItemDetail->qty == "")
                                                                                        style='display:none'
                                                                                    @else @endif >
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_one]" value="{{$orderItemDetail->numseq_hundred_one}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_one}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_two]" value="{{$orderItemDetail->numseq_hundred_two}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_two}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_three]" value="{{$orderItemDetail->numseq_hundred_three}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_three}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_four]" value="{{$orderItemDetail->numseq_hundred_four}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_four}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_five]" value="{{$orderItemDetail->numseq_hundred_five}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_five}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_six]" value="{{$orderItemDetail->numseq_hundred_six}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_six}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_seven]" value="{{$orderItemDetail->numseq_hundred_seven}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_seven}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_eight]" value="{{$orderItemDetail->numseq_hundred_eight}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_eight}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_nine]" value="{{$orderItemDetail->numseq_hundred_nine}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_nine}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_ten]" value="{{$orderItemDetail->numseq_hundred_ten}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_ten}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_eleven]" value="{{$orderItemDetail->numseq_hundred_eleven}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_eleven}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_twelve]" value="{{$orderItemDetail->numseq_hundred_twelve}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_twelve}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_thirteen]" value="{{$orderItemDetail->numseq_hundred_thirteen}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_thirteen}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_fourteen]" value="{{$orderItemDetail->numseq_hundred_fourteen}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_fourteen}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_fifteen]" value="{{$orderItemDetail->numseq_hundred_fifteen}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_fifteen}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_sixteen]" value="{{$orderItemDetail->numseq_hundred_sixteen}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_sixteen}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_seventeen]" value="{{$orderItemDetail->numseq_hundred_seventeen}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_seventeen}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_eighteen]" value="{{$orderItemDetail->numseq_hundred_eighteen}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_eighteen}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_nineteen]" value="{{$orderItemDetail->numseq_hundred_nineteen}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_nineteen}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_twenty]" value="{{$orderItemDetail->numseq_hundred_twenty}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_twenty}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_twenty_one]" value="{{$orderItemDetail->numseq_hundred_twenty_one}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_twenty_one}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_twenty_two]" value="{{$orderItemDetail->numseq_hundred_twenty_two}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_twenty_two}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_twenty_three]" value="{{$orderItemDetail->numseq_hundred_twenty_three}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_twenty_three}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_twenty_four]" value="{{$orderItemDetail->numseq_hundred_twenty_four}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_twenty_four}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below3 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_twenty_five]"value="{{$orderItemDetail->numseq_hundred_twenty_five}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_twenty_five}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                </tr>

                                                                                <tr class="{{"order-".$orderItemDetail->order_item_id.'-'.$orderItemDetail->size_id}} {{"size-".$orderItemDetail->size_id}} {{ " " }} {{ $orderItemDetail->id."row4Hidden" }}"  @php echo $hiddenTrueFalseRow6; @endphp
                                                                                    @if($orderItemDetail->size_id == 18 && $orderItemDetail->qty == "")
                                                                                    style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 19 && $orderItemDetail->qty == "")
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 21 && $orderItemDetail->qty == "")
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 22 && $orderItemDetail->qty == "")
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 24 && $orderItemDetail->qty == "")
                                                                                        style='display:none'
                                                                                    @elseif($orderItemDetail->size_id == 25 && $orderItemDetail->qty == "")
                                                                                        style='display:none'
                                                                                    @else @endif >
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_twenty_six]"  value="{{$orderItemDetail->numseq_hundred_twenty_six}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_twenty_six}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_twenty_seven]"  value="{{$orderItemDetail->numseq_hundred_twenty_seven}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_twenty_seven}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_twenty_eight]" value="{{$orderItemDetail->numseq_hundred_twenty_eight}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_twenty_eight}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_twenty_nine]"  value="{{$orderItemDetail->numseq_hundred_twenty_nine}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_twenty_nine}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_thirty]"  value="{{$orderItemDetail->numseq_hundred_thirty}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_thirty}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_thirty_one]"  value="{{$orderItemDetail->numseq_hundred_thirty_one}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_thirty_one}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_thirty_two]"  value="{{$orderItemDetail->numseq_hundred_thirty_two}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_thirty_two}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_thirty_three]"  value="{{$orderItemDetail->numseq_hundred_thirty_three}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_thirty_three}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_thirty_four]"  value="{{$orderItemDetail->numseq_hundred_thirty_four}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_thirty_four}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_thirty_five]"  value="{{$orderItemDetail->numseq_hundred_thirty_five}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_thirty_five}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_thirty_six]" value="{{$orderItemDetail->numseq_hundred_thirty_six}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_thirty_six}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_thirty_seven]"  value="{{$orderItemDetail->numseq_hundred_thirty_seven}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_thirty_seven}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_thirty_eight]"  value="{{$orderItemDetail->numseq_hundred_thirty_eight}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_thirty_eight}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_thirty_nine]"  value="{{$orderItemDetail->numseq_hundred_thirty_nine}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_thirty_nine}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_forty]"  value="{{$orderItemDetail->numseq_hundred_forty}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_forty}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_forty_one]"  value="{{$orderItemDetail->numseq_hundred_forty_one}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_forty_one}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_forty_two]"  value="{{$orderItemDetail->numseq_hundred_forty_two}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_forty_two}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_forty_three]"  value="{{$orderItemDetail->numseq_hundred_forty_three}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_forty_three}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_forty_four]"  value="{{$orderItemDetail->numseq_hundred_forty_four}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_forty_four}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_forty_five]"  value="{{$orderItemDetail->numseq_hundred_forty_five}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_forty_five}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_forty_six]"  value="{{$orderItemDetail->numseq_hundred_forty_six}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_forty_six}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_forty_seven]"  value="{{$orderItemDetail->numseq_hundred_forty_seven}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_forty_seven}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_forty_eight]"  value="{{$orderItemDetail->numseq_hundred_forty_eight}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_forty_eight}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_forty_nine]"  value="{{$orderItemDetail->numseq_hundred_forty_nine}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_forty_nine}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                    <td class="wi-2"><input type='number' class="form-control form-control-bc numseq below4 numseqVal{{ $orderItemDetail->id }}" data-orderItemDetailId="{{ $orderItemDetail->id }}" name="product[{{$orderItemDetail->id}}][numseq_hundred_fifty]"  value="{{$orderItemDetail->numseq_hundred_fifty}}" data-AlradySaved="{{$orderItemDetail->numseq_hundred_fifty}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) readonly @endif /></td>
                                                                                </tr>

                                                                            </div>
                                                                            @endforeach
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <td colspan="28"><hr style="margin-top: 1px; margin-bottom: 1px;"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="wi-2" style="font-size: 11px; text-align: center;">TOTAL<br>BLANK</th>
                                                                                <th class="wi-2" style="font-size: 11px; text-align: center;">TOTAL<br>NUM</th>
                                                                                <th></th>
                                                                                <th colspan="25" style="font-size: 11px;">TOTAL QTY <button type="button" class="btn btn-success btn-custom add-size" value="{{$orderItem->id}}" @if ($orderItem->order_status_id == 3 || $orderItem->order_status_id == 4 ||  $orderItem->order_status_id == 7) disabled @endif >Add Size</button></th>

                                                                            </tr>
                                                                            <tr>
                                                                                <td class="wi-2">
                                                                                    <input class="form-control form-control-bc hi-69 text-center TOTALblanks" name="orderItem[{{$orderItem->id}}][TOTALblanks]" id="TOTALblanks_{{$orderItem->id}}" type='text' value="" data-AlradySaved="" readonly />
                                                                                </td>
                                                                                <td class="wi-2">
                                                                                    <input class="form-control form-control-bc hi-69 text-center TOTALnums" name="orderItem[{{$orderItem->id}}][TOTALnums]" id="TOTALnums_{{$orderItem->id}}" type='text' value='' data-AlradySaved="" readonly />
                                                                                </td>
                                                                                <td class="wi-10"></td>
                                                                                <td colspan="25">
                                                                                    <input type='text' class="form-control form-control-bc hi-69 text-left TOTALqty" name="orderItem[{{$orderItem->id}}][TOTALqty]" id="TOTALqty_{{$orderItem->id}}" value="" data-AlradySaved="" readonly />
                                                                                </td>
                                                                            </tr>

                                                                        </tfoot>
                                                                    </table>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div style="border: solid grey 1px; padding: 3px; height: 607px;" class="cusTab tab-pane fade" id="orderRosterName_tab_{{ $orderItem->id }}" role="tabpanel" aria-labelledby="orderRosterName_{{ $orderItem->id }}">

                                                            <div class="tab formRosterPlayerNames{{$orderItem->id}}" style="height: 600px; max-width: 200px; background-color: white;">
                                                                @php $activeStatus = "active"; @endphp
                                                                @foreach ($orderItem->orderItemDetails as $orderItemDetail)
                                                                    @if($orderItemDetail->qty > 0 || $orderItemDetail->blanks > 0)
                                                                        <button type="button" class="tablinksCustom {{ $activeStatus }}  btn btn-secondary btn-custom" style="width: 100% !important;" onclick="openSize(event, 'tab_sizes_{{ $orderItemDetail->id }}')" ><small><b>{{ $orderItemDetail->sizeDetails['size_name'] }}</b></small></button>
                                                                        @php $activeStatus = ""; @endphp
                                                                    @endif
                                                                @endforeach

                                                              </div>
                                                                @foreach ($orderItem->orderItemDetails as $orderItemDetail)
                                                                    @php
                                                                    $playerNameArrayPosition = "";
                                                                    if (array_search("$orderItemDetail->id", $arrayPlayerNamesPattern) !== false) {
                                                                        $playerNameArrayPosition = array_search("$orderItemDetail->id", $arrayPlayerNamesPattern);
                                                                    } else {
                                                                        $playerNameArrayPosition = "";
                                                                    }
                                                                    @endphp

                                                                    @if($orderItemDetail->qty > 0 || $orderItemDetail->blanks > 0)
                                                                        <div id="tab_sizes_{{ $orderItemDetail->id }}" class="tabcontentCustom mt-4" style="display: block; height: 550px;overflow: hidden;overflow-y: scroll;">
                                                                            <h3 class="ml-1">{{ $orderItemDetail->sizeDetails['size_name'] }}</h3>
                                                                            <input type="hidden" name="playerName[{{ $orderItemDetail->id }}][itemId]" value="{{ $orderItemDetail->id }}" />

                                                                            <table class="table ml-1">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th scope='col'>Size Name</th>
                                                                                        <th scope='col'>Number</th>
                                                                                        <th scope='col'>Player Name</th>
                                                                                    </tr>
                                                                                </thead>

                                                                                <tbody>
                                                                                    @if(isset($orderItemDetail->numseq_one) && $orderItemDetail->numseq_one != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_one }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_one]" value="{{ $orderItemDetail->playerDetails['player_one'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_two) && $orderItemDetail->numseq_two != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_two }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_two]" value="{{ $orderItemDetail->playerDetails['player_two'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_three) && $orderItemDetail->numseq_three != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_three }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_three]" value="{{ $orderItemDetail->playerDetails['player_three'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_four) && $orderItemDetail->numseq_four != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_four }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_four]" value="{{ $orderItemDetail->playerDetails['player_four'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_five) && $orderItemDetail->numseq_five != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_five }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_five]" value="{{ $orderItemDetail->playerDetails['player_five'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_six) && $orderItemDetail->numseq_six != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_six }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_six]" value="{{ $orderItemDetail->playerDetails['player_six'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_seven) && $orderItemDetail->numseq_seven != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_seven }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_seven]" value="{{ $orderItemDetail->playerDetails['player_seven'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_eight) && $orderItemDetail->numseq_eight != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_eight }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_eight]" value="{{ $orderItemDetail->playerDetails['player_eight'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_nine) && $orderItemDetail->numseq_nine != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_nine }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_nine]" value="{{ $orderItemDetail->playerDetails['player_nine'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_ten) && $orderItemDetail->numseq_ten != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_ten }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_ten]" value="{{ $orderItemDetail->playerDetails['player_ten'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_eleven) && $orderItemDetail->numseq_eleven != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_eleven }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_eleven]" value="{{ $orderItemDetail->playerDetails['player_eleven'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_twelve) && $orderItemDetail->numseq_twelve != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_twelve }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_twelve]" value="{{ $orderItemDetail->playerDetails['player_twelve'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_thirteen) && $orderItemDetail->numseq_thirteen != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_thirteen }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_thirteen]" value="{{ $orderItemDetail->playerDetails['player_thirteen'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_fourteen) && $orderItemDetail->numseq_fourteen != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_fourteen }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_fourteen]" value="{{ $orderItemDetail->playerDetails['player_fourteen'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_fifteen) && $orderItemDetail->numseq_fifteen != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_fifteen }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_fifteen]" value="{{ $orderItemDetail->playerDetails['player_fifteen'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_sixteen) && $orderItemDetail->numseq_sixteen != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_sixteen }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_sixteen]" value="{{ $orderItemDetail->playerDetails['player_sixteen'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_seventeen) && $orderItemDetail->numseq_seventeen != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_seventeen }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_seventeen]" value="{{ $orderItemDetail->playerDetails['player_seventeen'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_eighteen) && $orderItemDetail->numseq_eighteen != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_eighteen }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_eighteen]" value="{{ $orderItemDetail->playerDetails['player_eighteen'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_nineteen) && $orderItemDetail->numseq_nineteen != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_nineteen }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_nineteen]" value="{{ $orderItemDetail->playerDetails['player_nineteen'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_twenty) && $orderItemDetail->numseq_twenty != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_twenty }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_twenty]" value="{{ $orderItemDetail->playerDetails['player_twenty'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_twenty_one) && $orderItemDetail->numseq_twenty_one != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_twenty_one }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_twenty_one]" value="{{ $orderItemDetail->playerDetails['player_twenty_one'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_twenty_two) && $orderItemDetail->numseq_twenty_two != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_twenty_two }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_twenty_two]" value="{{ $orderItemDetail->playerDetails['player_twenty_two'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_twenty_three) && $orderItemDetail->numseq_twenty_three != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_twenty_three }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_twenty_three]" value="{{ $orderItemDetail->playerDetails['player_twenty_three'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_twenty_four) && $orderItemDetail->numseq_twenty_four != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_twenty_four }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_twenty_four]" value="{{ $orderItemDetail->playerDetails['player_twenty_four'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_twenty_five) && $orderItemDetail->numseq_twenty_five != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_twenty_four }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_twenty_five]" value="{{ $orderItemDetail->playerDetails['player_twenty_five'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_twenty_six) && $orderItemDetail->numseq_twenty_six != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_twenty_six }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_twenty_six]" value="{{ $orderItemDetail->playerDetails['player_twenty_six'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_twenty_seven) && $orderItemDetail->numseq_twenty_seven != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_twenty_seven }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_twenty_seven]" value="{{ $orderItemDetail->playerDetails['player_twenty_seven'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_twenty_eight) && $orderItemDetail->numseq_twenty_eight != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_twenty_eight }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_twenty_eight]" value="{{ $orderItemDetail->playerDetails['player_twenty_eight'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_twenty_nine) && $orderItemDetail->numseq_twenty_nine != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_twenty_nine }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_twenty_nine]" value="{{ $orderItemDetail->playerDetails['player_twenty_nine'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_thirty) && $orderItemDetail->numseq_thirty != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_thirty }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_thirty]" value="{{ $orderItemDetail->playerDetails['player_thirty'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_thirty_one) && $orderItemDetail->numseq_thirty_one != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_thirty_one }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_thirty_one]" value="{{ $orderItemDetail->playerDetails['player_thirty_one'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_thirty_two) && $orderItemDetail->numseq_thirty_two != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_thirty_two }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_thirty_two]" value="{{ $orderItemDetail->playerDetails['player_thirty_two'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_thirty_three) && $orderItemDetail->numseq_thirty_three != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_thirty_three }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_thirty_three]" value="{{ $orderItemDetail->playerDetails['player_thirty_three'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_thirty_four) && $orderItemDetail->numseq_thirty_four != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_thirty_four }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_thirty_four]" value="{{ $orderItemDetail->playerDetails['player_thirty_four'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_thirty_five) && $orderItemDetail->numseq_thirty_five != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_thirty_five }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_thirty_five]" value="{{ $orderItemDetail->playerDetails['player_thirty_five'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_thirty_six) && $orderItemDetail->numseq_thirty_six != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_thirty_six }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_thirty_six]" value="{{ $orderItemDetail->playerDetails['player_thirty_six'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_thirty_seven) && $orderItemDetail->numseq_thirty_seven != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_thirty_seven }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_thirty_seven]" value="{{ $orderItemDetail->playerDetails['player_thirty_seven'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_thirty_eight) && $orderItemDetail->numseq_thirty_eight != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_thirty_eight }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_thirty_eight]" value="{{ $orderItemDetail->playerDetails['player_thirty_eight'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_thirty_nine) && $orderItemDetail->numseq_thirty_nine != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_thirty_nine }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_thirty_nine]" value="{{ $orderItemDetail->playerDetails['player_thirty_nine'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_forty) && $orderItemDetail->numseq_forty != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_forty }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_forty]" value="{{ $orderItemDetail->playerDetails['player_forty'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_forty_one) && $orderItemDetail->numseq_forty_one != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_forty_one }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_forty_one]" value="{{ $orderItemDetail->playerDetails['player_forty_one'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_forty_two) && $orderItemDetail->numseq_forty_two != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_forty_two }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_forty_two]" value="{{ $orderItemDetail->playerDetails['player_forty_two'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_forty_three) && $orderItemDetail->numseq_forty_three != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_forty_three }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_forty_three]" value="{{ $orderItemDetail->playerDetails['player_forty_three'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_forty_four) && $orderItemDetail->numseq_forty_four != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_forty_four }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_forty_four]" value="{{ $orderItemDetail->playerDetails['player_forty_four'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_forty_five) && $orderItemDetail->numseq_forty_five != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_forty_five }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_forty_five]" value="{{ $orderItemDetail->playerDetails['player_forty_five'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_forty_six) && $orderItemDetail->numseq_forty_six != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_forty_six }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_forty_six]" value="{{ $orderItemDetail->playerDetails['player_forty_six'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_forty_seven) && $orderItemDetail->numseq_forty_seven != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_forty_seven }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_forty_seven]" value="{{ $orderItemDetail->playerDetails['player_forty_seven'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_forty_eight) && $orderItemDetail->numseq_forty_eight != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_forty_eight }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_forty_eight]" value="{{ $orderItemDetail->playerDetails['player_forty_eight'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_forty_nine) && $orderItemDetail->numseq_forty_nine != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_forty_nine }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_forty_nine]" value="{{ $orderItemDetail->playerDetails['player_forty_nine'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_fifty) && $orderItemDetail->numseq_fifty != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_fifty }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_fifty]" value="{{ $orderItemDetail->playerDetails['player_fifty'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    {{-- Player Name 51 to 60 --}}
                                                                                    @if(isset($orderItemDetail->numseq_fifty_one) && $orderItemDetail->numseq_fifty_one != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_fifty_one }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_fifty_one]" value="{{ $orderItemDetail->playerDetails['player_fifty_one'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_fifty_two) && $orderItemDetail->numseq_fifty_two != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_fifty_two }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_fifty_two]" value="{{ $orderItemDetail->playerDetails['player_fifty_two'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_fifty_three) && $orderItemDetail->numseq_fifty_three != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_fifty_three }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_fifty_three]" value="{{ $orderItemDetail->playerDetails['player_fifty_three'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_fifty_four) && $orderItemDetail->numseq_fifty_four != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_fifty_four }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_fifty_four]" value="{{ $orderItemDetail->playerDetails['player_fifty_four'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_fifty_five) && $orderItemDetail->numseq_fifty_five != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_fifty_five }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_fifty_five]" value="{{ $orderItemDetail->playerDetails['player_fifty_five'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_fifty_six) && $orderItemDetail->numseq_fifty_six != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_fifty_six }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_fifty_six]" value="{{ $orderItemDetail->playerDetails['player_fifty_six'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_fifty_seven) && $orderItemDetail->numseq_fifty_seven != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_fifty_seven }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_fifty_seven]" value="{{ $orderItemDetail->playerDetails['player_fifty_seven'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_fifty_eight) && $orderItemDetail->numseq_fifty_eight != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_fifty_eight }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_fifty_eight]" value="{{ $orderItemDetail->playerDetails['player_fifty_eight'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_fifty_nine) && $orderItemDetail->numseq_fifty_nine != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_fifty_nine }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_fifty_nine]" value="{{ $orderItemDetail->playerDetails['player_fifty_nine'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_sixty) && $orderItemDetail->numseq_sixty != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_sixty }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_sixty]" value="{{ $orderItemDetail->playerDetails['player_sixty'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    {{-- Player Name 61 to 70 --}}
                                                                                    @if(isset($orderItemDetail->numseq_sixty_one) && $orderItemDetail->numseq_sixty_one != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_sixty_one }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_sixty_one]" value="{{ $orderItemDetail->playerDetails['player_sixty_one'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_sixty_two) && $orderItemDetail->numseq_sixty_two != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_sixty_two }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_sixty_two]" value="{{ $orderItemDetail->playerDetails['player_sixty_two'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_sixty_three) && $orderItemDetail->numseq_sixty_three != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_sixty_three }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_sixty_three]" value="{{ $orderItemDetail->playerDetails['player_sixty_three'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_sixty_four) && $orderItemDetail->numseq_sixty_four != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_sixty_four }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_sixty_four]" value="{{ $orderItemDetail->playerDetails['player_sixty_four'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_sixty_five) && $orderItemDetail->numseq_sixty_five != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_sixty_five }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_sixty_five]" value="{{ $orderItemDetail->playerDetails['player_sixty_five'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_sixty_six) && $orderItemDetail->numseq_sixty_six != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_sixty_six }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_sixty_six]" value="{{ $orderItemDetail->playerDetails['player_sixty_six'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_sixty_seven) && $orderItemDetail->numseq_sixty_seven != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_sixty_seven }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_sixty_seven]" value="{{ $orderItemDetail->playerDetails['player_sixty_seven'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_sixty_eight) && $orderItemDetail->numseq_sixty_eight != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_sixty_eight }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_sixty_eight]" value="{{ $orderItemDetail->playerDetails['player_sixty_eight'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_sixty_nine) && $orderItemDetail->numseq_sixty_nine != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_sixty_nine }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_sixty_nine]" value="{{ $orderItemDetail->playerDetails['player_sixty_nine'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_seventy) && $orderItemDetail->numseq_seventy != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_seventy }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_seventy]" value="{{ $orderItemDetail->playerDetails['player_seventy'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    {{-- Player Name 71 to 80 --}}
                                                                                    @if(isset($orderItemDetail->numseq_seventy_one) && $orderItemDetail->numseq_seventy_one != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_seventy_one }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_seventy_one]" value="{{ $orderItemDetail->playerDetails['player_seventy_one'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_seventy_two) && $orderItemDetail->numseq_seventy_two != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_seventy_two }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_seventy_two]" value="{{ $orderItemDetail->playerDetails['player_seventy_two'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_seventy_three) && $orderItemDetail->numseq_seventy_three != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_seventy_three }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_seventy_three]" value="{{ $orderItemDetail->playerDetails['player_seventy_three'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_seventy_four) && $orderItemDetail->numseq_seventy_four != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_seventy_four }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_seventy_four]" value="{{ $orderItemDetail->playerDetails['player_seventy_four'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_seventy_five) && $orderItemDetail->numseq_seventy_five != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_seventy_five }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_seventy_five]" value="{{ $orderItemDetail->playerDetails['player_seventy_five'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_seventy_six) && $orderItemDetail->numseq_seventy_six != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_seventy_six }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_seventy_six]" value="{{ $orderItemDetail->playerDetails['player_seventy_six'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_seventy_seven) && $orderItemDetail->numseq_seventy_seven != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_seventy_seven }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_seventy_seven]" value="{{ $orderItemDetail->playerDetails['player_seventy_seven'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_seventy_eight) && $orderItemDetail->numseq_seventy_eight != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_seventy_eight }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_seventy_eight]" value="{{ $orderItemDetail->playerDetails['player_seventy_eight'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_seventy_nine) && $orderItemDetail->numseq_seventy_nine != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_seventy_nine }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_seventy_nine]" value="{{ $orderItemDetail->playerDetails['player_seventy_nine'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_eighty) && $orderItemDetail->numseq_eighty != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_eighty }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_eighty]" value="{{ $orderItemDetail->playerDetails['player_eighty'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    {{-- Player Name 81 to 90 --}}
                                                                                    @if(isset($orderItemDetail->numseq_eighty_one) && $orderItemDetail->numseq_eighty_one != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_eighty_one }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_eighty_one]" value="{{ $orderItemDetail->playerDetails['player_eighty_one'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_eighty_two) && $orderItemDetail->numseq_eighty_two != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_eighty_two }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_eighty_two]" value="{{ $orderItemDetail->playerDetails['player_eighty_two'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_eighty_three) && $orderItemDetail->numseq_eighty_three != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_eighty_three }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_eighty_three]" value="{{ $orderItemDetail->playerDetails['player_eighty_three'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_eighty_four) && $orderItemDetail->numseq_eighty_four != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_eighty_four }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_eighty_four]" value="{{ $orderItemDetail->playerDetails['player_eighty_four'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_eighty_five) && $orderItemDetail->numseq_eighty_five != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_eighty_five }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_eighty_five]" value="{{ $orderItemDetail->playerDetails['player_eighty_five'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_eighty_six) && $orderItemDetail->numseq_eighty_six != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_eighty_six }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_eighty_six]" value="{{ $orderItemDetail->playerDetails['player_eighty_six'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_eighty_seven) && $orderItemDetail->numseq_eighty_seven != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_eighty_seven }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_eighty_seven]" value="{{ $orderItemDetail->playerDetails['player_eighty_seven'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_eighty_eight) && $orderItemDetail->numseq_eighty_eight != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_eighty_eight }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_eighty_eight]" value="{{ $orderItemDetail->playerDetails['player_eighty_eight'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_eighty_nine) && $orderItemDetail->numseq_eighty_nine != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_eighty_nine }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_eighty_nine]" value="{{ $orderItemDetail->playerDetails['player_eighty_nine'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_ninety) && $orderItemDetail->numseq_ninety != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_ninety }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_ninety]" value="{{ $orderItemDetail->playerDetails['player_ninety'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    {{-- Player Name 91 to 100 --}}
                                                                                    @if(isset($orderItemDetail->numseq_ninety_one) && $orderItemDetail->numseq_ninety_one != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_ninety_one }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_ninety_one]" value="{{ $orderItemDetail->playerDetails['player_ninety_one'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_ninety_two) && $orderItemDetail->numseq_ninety_two != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_ninety_two }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_ninety_two]" value="{{ $orderItemDetail->playerDetails['player_ninety_two'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_ninety_three) && $orderItemDetail->numseq_ninety_three != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_ninety_three }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_ninety_three]" value="{{ $orderItemDetail->playerDetails['player_ninety_three'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_ninety_four) && $orderItemDetail->numseq_ninety_four != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_ninety_four }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_ninety_four]" value="{{ $orderItemDetail->playerDetails['player_ninety_four'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_ninety_five) && $orderItemDetail->numseq_ninety_five != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_ninety_five }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_ninety_five]" value="{{ $orderItemDetail->playerDetails['player_ninety_five'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_ninety_six) && $orderItemDetail->numseq_ninety_six != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_ninety_six }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_ninety_six]" value="{{ $orderItemDetail->playerDetails['player_ninety_six'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_ninety_seven) && $orderItemDetail->numseq_ninety_seven != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_ninety_seven }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_ninety_seven]" value="{{ $orderItemDetail->playerDetails['player_ninety_seven'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_ninety_eight) && $orderItemDetail->numseq_ninety_eight != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_ninety_eight }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_ninety_eight]" value="{{ $orderItemDetail->playerDetails['player_ninety_eight'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_ninety_nine) && $orderItemDetail->numseq_ninety_nine != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_ninety_nine }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_ninety_nine]" value="{{ $orderItemDetail->playerDetails['player_ninety_nine'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred) && $orderItemDetail->numseq_hundred != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_hundred]" value="{{ $orderItemDetail->playerDetails['player_hundred'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif
                                                                                    @if(isset($orderItemDetail->numseq_hundred_one) && $orderItemDetail->numseq_hundred_one != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_one }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_one]" value="{{ $orderItemDetail->playerDetails['player_one'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_two) && $orderItemDetail->numseq_hundred_two != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_two }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_two]" value="{{ $orderItemDetail->playerDetails['player_two'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_three) && $orderItemDetail->numseq_hundred_three != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_three }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_three]" value="{{ $orderItemDetail->playerDetails['player_three'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_four) && $orderItemDetail->numseq_hundred_four != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_four }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_four]" value="{{ $orderItemDetail->playerDetails['player_four'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_five) && $orderItemDetail->numseq_hundred_five != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_five }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_five]" value="{{ $orderItemDetail->playerDetails['player_five'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_six) && $orderItemDetail->numseq_hundred_six != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_six }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_six]" value="{{ $orderItemDetail->playerDetails['player_six'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_seven) && $orderItemDetail->numseq_hundred_seven != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_seven }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_seven]" value="{{ $orderItemDetail->playerDetails['player_seven'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_eight) && $orderItemDetail->numseq_hundred_eight != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_eight }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_eight]" value="{{ $orderItemDetail->playerDetails['player_eight'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_nine) && $orderItemDetail->numseq_hundred_nine != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_nine }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_nine]" value="{{ $orderItemDetail->playerDetails['player_nine'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_ten) && $orderItemDetail->numseq_hundred_ten != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_ten }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_ten]" value="{{ $orderItemDetail->playerDetails['player_ten'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_eleven) && $orderItemDetail->numseq_hundred_eleven != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_eleven }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_eleven]" value="{{ $orderItemDetail->playerDetails['player_eleven'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_twelve) && $orderItemDetail->numseq_hundred_twelve != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_twelve }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_twelve]" value="{{ $orderItemDetail->playerDetails['player_twelve'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_thirteen) && $orderItemDetail->numseq_hundred_thirteen != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_thirteen }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_thirteen]" value="{{ $orderItemDetail->playerDetails['player_thirteen'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_fourteen) && $orderItemDetail->numseq_hundred_fourteen != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_fourteen }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_fourteen]" value="{{ $orderItemDetail->playerDetails['player_fourteen'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_fifteen) && $orderItemDetail->numseq_hundred_fifteen != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_fifteen }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_fifteen]" value="{{ $orderItemDetail->playerDetails['player_fifteen'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_sixteen) && $orderItemDetail->numseq_hundred_sixteen != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_sixteen }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_sixteen]" value="{{ $orderItemDetail->playerDetails['player_sixteen'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_seventeen) && $orderItemDetail->numseq_hundred_seventeen != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_seventeen }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_seventeen]" value="{{ $orderItemDetail->playerDetails['player_seventeen'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_eighteen) && $orderItemDetail->numseq_hundred_eighteen != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_eighteen }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_eighteen]" value="{{ $orderItemDetail->playerDetails['player_eighteen'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_nineteen) && $orderItemDetail->numseq_hundred_nineteen != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_nineteen }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_nineteen]" value="{{ $orderItemDetail->playerDetails['player_nineteen'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_twenty) && $orderItemDetail->numseq_hundred_twenty != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_twenty }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_twenty]" value="{{ $orderItemDetail->playerDetails['player_twenty'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_twenty_one) && $orderItemDetail->numseq_hundred_twenty_one != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_twenty_one }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_twenty_one]" value="{{ $orderItemDetail->playerDetails['player_twenty_one'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_twenty_two) && $orderItemDetail->numseq_hundred_twenty_two != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_twenty_two }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_twenty_two]" value="{{ $orderItemDetail->playerDetails['player_twenty_two'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_twenty_three) && $orderItemDetail->numseq_hundred_twenty_three != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_twenty_three }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_twenty_three]" value="{{ $orderItemDetail->playerDetails['player_twenty_three'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_twenty_four) && $orderItemDetail->numseq_hundred_twenty_four != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_twenty_four }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_twenty_four]" value="{{ $orderItemDetail->playerDetails['player_twenty_four'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_twenty_five) && $orderItemDetail->numseq_hundred_twenty_five != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_twenty_four }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_twenty_five]" value="{{ $orderItemDetail->playerDetails['player_twenty_five'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_twenty_six) && $orderItemDetail->numseq_hundred_twenty_six != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_twenty_six }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_twenty_six]" value="{{ $orderItemDetail->playerDetails['player_twenty_six'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_twenty_seven) && $orderItemDetail->numseq_hundred_twenty_seven != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_twenty_seven }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_twenty_seven]" value="{{ $orderItemDetail->playerDetails['player_twenty_seven'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_twenty_eight) && $orderItemDetail->numseq_hundred_twenty_eight != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_twenty_eight }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_twenty_eight]" value="{{ $orderItemDetail->playerDetails['player_twenty_eight'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_twenty_nine) && $orderItemDetail->numseq_hundred_twenty_nine != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_twenty_nine }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_twenty_nine]" value="{{ $orderItemDetail->playerDetails['player_twenty_nine'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_thirty) && $orderItemDetail->numseq_hundred_thirty != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_thirty }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_thirty]" value="{{ $orderItemDetail->playerDetails['player_thirty'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_thirty_one) && $orderItemDetail->numseq_hundred_thirty_one != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_thirty_one }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_thirty_one]" value="{{ $orderItemDetail->playerDetails['player_thirty_one'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_thirty_two) && $orderItemDetail->numseq_hundred_thirty_two != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_thirty_two }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_thirty_two]" value="{{ $orderItemDetail->playerDetails['player_thirty_two'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_thirty_three) && $orderItemDetail->numseq_hundred_thirty_three != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_thirty_three }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_thirty_three]" value="{{ $orderItemDetail->playerDetails['player_thirty_three'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_thirty_four) && $orderItemDetail->numseq_hundred_thirty_four != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_thirty_four }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_thirty_four]" value="{{ $orderItemDetail->playerDetails['player_thirty_four'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_thirty_five) && $orderItemDetail->numseq_hundred_thirty_five != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_thirty_five }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_thirty_five]" value="{{ $orderItemDetail->playerDetails['player_thirty_five'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_thirty_six) && $orderItemDetail->numseq_hundred_thirty_six != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_thirty_six }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_thirty_six]" value="{{ $orderItemDetail->playerDetails['player_thirty_six'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_thirty_seven) && $orderItemDetail->numseq_hundred_thirty_seven != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_thirty_seven }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_thirty_seven]" value="{{ $orderItemDetail->playerDetails['player_thirty_seven'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_thirty_eight) && $orderItemDetail->numseq_hundred_thirty_eight != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_thirty_eight }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_thirty_eight]" value="{{ $orderItemDetail->playerDetails['player_thirty_eight'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_thirty_nine) && $orderItemDetail->numseq_hundred_thirty_nine != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_thirty_nine }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_thirty_nine]" value="{{ $orderItemDetail->playerDetails['player_thirty_nine'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_forty) && $orderItemDetail->numseq_hundred_forty != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_forty }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_forty]" value="{{ $orderItemDetail->playerDetails['player_forty'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_forty_one) && $orderItemDetail->numseq_hundred_forty_one != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_forty_one }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_forty_one]" value="{{ $orderItemDetail->playerDetails['player_forty_one'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_forty_two) && $orderItemDetail->numseq_hundred_forty_two != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_forty_two }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_forty_two]" value="{{ $orderItemDetail->playerDetails['player_forty_two'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_forty_three) && $orderItemDetail->numseq_hundred_forty_three != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_forty_three }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_forty_three]" value="{{ $orderItemDetail->playerDetails['player_forty_three'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_forty_four) && $orderItemDetail->numseq_hundred_forty_four != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_forty_four }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_forty_four]" value="{{ $orderItemDetail->playerDetails['player_forty_four'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_forty_five) && $orderItemDetail->numseq_hundred_forty_five != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_forty_five }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_forty_five]" value="{{ $orderItemDetail->playerDetails['player_forty_five'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_forty_six) && $orderItemDetail->numseq_hundred_forty_six != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_forty_six }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_forty_six]" value="{{ $orderItemDetail->playerDetails['player_forty_six'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_forty_seven) && $orderItemDetail->numseq_hundred_forty_seven != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_forty_seven }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_forty_seven]" value="{{ $orderItemDetail->playerDetails['player_forty_seven'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_forty_eight) && $orderItemDetail->numseq_hundred_forty_eight != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_forty_eight }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_forty_eight]" value="{{ $orderItemDetail->playerDetails['player_forty_eight'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_forty_nine) && $orderItemDetail->numseq_hundred_forty_nine != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_forty_nine }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_forty_nine]" value="{{ $orderItemDetail->playerDetails['player_forty_nine'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if(isset($orderItemDetail->numseq_hundred_fifty) && $orderItemDetail->numseq_hundred_fifty != "")
                                                                                        <tr>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                            <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->numseq_hundred_fifty }}" readonly /></td>
                                                                                            <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][player_fifty]" value="{{ $orderItemDetail->playerDetails['player_fifty'] ?? '' }}" /></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    @if($orderItemDetail->blanks > 0)
                                                                                        @if(!isset($orderItemDetail->playerDetails))
                                                                                            @for ($i = 0; $i < $orderItemDetail->blanks; $i++)
                                                                                                <tr>
                                                                                                    <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                                    <td></td>
                                                                                                    <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][blank_players][{{ $i }}]"/></td>
                                                                                                </tr>
                                                                                            @endfor
                                                                                        @elseif(isset($orderItemDetail->playerDetails) && $orderItemDetail->playerDetails->blank_player_names == "")
                                                                                            @for ($i = 0; $i < $orderItemDetail->blanks; $i++)
                                                                                                <tr>
                                                                                                    <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                                    <td></td>
                                                                                                    <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][blank_players][{{ $i }}]"/></td>
                                                                                                </tr>
                                                                                            @endfor
                                                                                        @elseif(isset($orderItemDetail->playerDetails) && $orderItemDetail->playerDetails->blank_player_names != "")
                                                                                            @foreach (json_decode($orderItemDetail->playerDetails->blank_player_names) as $blankPlayerKey => $blankPlayer)
                                                                                                <tr>
                                                                                                    <td><input type="text" class="invoice-inputs" value="{{ $orderItemDetail->sizeDetails['size_name'] }}" readonly/></td>
                                                                                                    <td></td>
                                                                                                    <td><input type="text" class="form-control" name="playerName[{{ $orderItemDetail->id }}][blank_players][{{ $blankPlayerKey }}]" value="{{ $blankPlayer ?? '' }}" /></td>
                                                                                                </tr>
                                                                                            @endforeach
                                                                                        @endif
                                                                                    @endif
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                        @php $DisplayStatus = "display: none;"; @endphp
                                                                    @else
                                                                     <input type="hidden" name="playerName[{{ $orderItemDetail->id }}][itemId]" value="{{ $orderItemDetail->id }}" />
                                                                    @endif
                                                                @endforeach


                                                            <br><br>
                                                        </div>






                                                    </div>



                                                    <div class="col-lg-12 mb-5">
                                                        <div class="col-lg-12 control-btns">
                                                            <a href="{{url('order_details/print_order_item')}}/{{$orderItem->id}}" class="btn btn-light btn-custom">Print</a>
                                                            {{-- <button type="submit" class="btn btn-success btn-custom save_button">Save</button> --}}
                                                            @if($orderItem->statusDetails['status_name'] === 'Quote')
                                                                <button type="submit" class="btn btn-success btn-custom save_button">Save</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>

                            </div>
                            <div class="tab-pane fade" id="shipping_tab" role="tabpanel" aria-labelledby="shipping-tab">
                                <div class="card mb-3">
                                    <div class="card-body">


                                        <div class="row mt-4">

                                            <div class="col-md-12">
                                                <table class="table Product_details" id="order_item_table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" style="padding-left: .5rem !important;">SELECT</th>
                                                            <th class="text-left" style="width: 40%;padding-left: .5rem !important;">ITEM</th>
                                                            {{-- <th class="text-center">TRACKING</th> --}}
                                                            <th class="text-right">ORDER QTY</th>
                                                            <th class="text-right">SHIPPED QTY</th>
                                                            <th class="text-right">BACKORDED QTY</th>
                                                            <th class="text-left" style="padding-left: .5rem !important;">EST DELIVERY DATE</th>
                                                            <th class="text-left" style="padding-right: .5rem !important;">TRACKING</th>
                                                        </tr>
                                                    </thead>
                                                        <tbody id="product_table_body">
                                                            <tr><input type="hidden" id="row_no" /></tr>


                                                            @foreach ($orderDetails as $orderDetail)
                                                            @foreach ($orderDetail->orderItems as $orderItem)

                                                            @php
                                                                $sub_product = $sub_products->where('sub_product_no' , $orderItem->sub_product_no)->first();
                                                            @endphp


                                                                <tr>
                                                                    <input type="hidden" name="itemID[]" value="{{ $orderItem->id }}" />

                                                                    <td style="text-align: center; vertical-align: middle;"><input data-itemNumber="{{ $orderItem->id }}" class="chkItem" type="checkbox" id=""></td>
                                                                    <td><input type="text" class="invoice-inputs"
                                                                            name="itemName[]"
                                                                            value="@if(empty($orderItem->display_name)) {{ $sub_product->product_name }} @else {{ $orderItem->display_name }} @endif"
                                                                            readonly /></td>

                                                                    <td><input type="text" class="invoice-inputs text-right item-qty" style="padding-right: 0rem !important;"
                                                                                name="itemOrderQty[]"
                                                                                value="{{ $orderItem->qty }}" readonly /></td>



                                                                    <td><input type="number" class="invoice-inputs text-right" style="padding-right: 0rem !important;"
                                                                            name="itemShippedQty[]"
                                                                            value="@if(isset($orderItem->shipped_qty)){{ $orderItem->shipped_qty }}@endif" readonly/></td>

                                                                    <td><input type="number" class="invoice-inputs text-right" style="padding-right: 0rem !important;"
                                                                                name="itemBackOrderedQty[]"
                                                                                value="@if(isset($orderItem->backordered_qty)){{ $orderItem->backordered_qty }}@endif" readonly/></td>

                                                                    <td><input type="text" class="invoice-inputs text-left" style="padding-left: .5rem !important;"
                                                                                    name="itemEstDiliveryDate[]"
                                                                                    value="@if(isset($orderItem->est_shipping_delivery_date)){{ $orderItem->est_shipping_delivery_date }}@endif" readonly/></td>

                                                                    <td><input type="text" class="txtTrackingNo invoice-inputs text-left" style="padding-left: 0rem !important;padding-right: .5rem !important;" data-itemNumber="{{ $orderItem->id }}"
                                                                                        name="itemtrackingNo[]" id="txtTrackNo{{ $orderItem->id  }}"
                                                                                        value="@if(isset($orderItem->tracking_no)){{ $orderItem->tracking_no }}@endif" readonly/></td>



                                                                </tr>
                                                            @endforeach
                                                            @endforeach
                                                        </tbody>





                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

{{-- Product Category Tab --}}



                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
    @else

    @endif
</div>

@include('pages.order_management.roster.edit_request_modal')
@include('pages.order_management.roster.modal_copy')

<script src="{{ asset('argon') }}/file_inputs/js/fileinput2.js"></script>
<script src="{{ asset('argon') }}/file_inputs/themes/fas/theme.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Set a timer to check for the images every 100 milliseconds
        var interval = setInterval(function() {
            // Get all elements with the class '.file-preview-image'
            var imageElements = document.querySelectorAll(".file-preview-image");

            // Check if any image element exists
            if (imageElements.length > 0) {
                // Iterate over each image element
                imageElements.forEach(function(imageElement) {
                    // Get the current source of the image
                    var currentSrc = imageElement.src;

                    // Apply your modifications here
                    var correctedSrc = modifyImageSource(currentSrc);

                    // Update the image source with the corrected link
                    imageElement.src = correctedSrc;
                });

                // Clear the interval to stop checking
                clearInterval(interval);
            }
        }, 100);
    });

    function modifyImageSource(originalSrc) {
        // Check if the original source contains 'uc?id=' or '/file/d/'
        if (originalSrc.includes('uc?id=')) {
            // Replace 'uc?id=' with 'thumbnail?id='
            return originalSrc.replace('uc?id=', 'thumbnail?id=');
        } else if (originalSrc.includes('/file/d/')) {
            // Extract the file ID from the original source
            var fileId = extractFileId(originalSrc);

            // Construct the converted image source
            return "https://drive.google.com/thumbnail?id=" + fileId + "&export=media";
        }

        // If the source doesn't match either type, return the original source
        return originalSrc;
    }

    function extractFileId(originalSrc) {
        // Extract the file ID from the original source using a regular expression
        var match = originalSrc.match(/\/file\/d\/(.*?)\/view/);

        // Check if a match is found
        if (match && match[1]) {
            return match[1];
        }

        // If no match is found, return an empty string
        return "";
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Function to replace all icons with the 'far fa-eye' class
        function replaceIcons() {
            var downloadIcons = document.querySelectorAll('.kv-file-download i');

            // Check if there are icons to replace
            if (downloadIcons.length > 0) {
                // Iterate over each matching icon
                downloadIcons.forEach(function(downloadIcon) {
                    // Create a new <i> element with the 'far fa-eye' class
                    var newIcon = document.createElement('i');
                    newIcon.setAttribute('class', 'far fa-eye');

                    // Replace the existing <i> element with the new one
                    downloadIcon.parentNode.replaceChild(newIcon, downloadIcon);
                });
            } else {
                // Retry after a short delay if icons are not yet available
                setTimeout(replaceIcons, 100);
            }
        }

        // Start replacing icons
        replaceIcons();
    });
</script>


<script>

    function calculateSum() {
        var sum = 0;
        var qtyInputs = document.querySelectorAll('.invoice-inputs.text-right.item-qty.item_qty');

        qtyInputs.forEach(function(input) {
            sum += parseFloat(input.value) || 0;
        });

        var roundedSum = Math.round(sum);

        var qtySumInput = document.getElementById('qtySumInput');
        if (qtySumInput) {
            qtySumInput.value = roundedSum.toString();
        }

        var paymentLink = document.getElementById('paymentLink');
        if (paymentLink) {
            var href = paymentLink.getAttribute('href');
            var updatedHref = href.replace('qtySum=', 'qtySum=' + roundedSum);
            paymentLink.setAttribute('href', updatedHref);
        }
    }

    window.addEventListener('load', calculateSum);


    var order_details = <?php echo json_encode($orderDetails) ?>;

    $('body').on('keydown', '.numseq', function(e) {
        if (e.key == "e") {
            return false;
        }


    });

    var ItemForm = null;

    $(".nav-tab-item").click(function(){
        $("#"+$(this).attr("data-RosterForm")).click();

        if(numberSequencesFilled.length >= 1){
            var elementID = $(this).attr("id");

            if($(this).attr("data-section") == "rosterPlayerNames") {
                var buttons = $('<div>').append("There are unsaved changes. Are you sure that you want to leave this form?<br><br><button data-clickedItem='"+elementID+"' type='button' class='btn btn-secondary LeaveNotSave'>Leave & Don't Save</button>").append("<button data-clickedItem='"+elementID+"' type='button' class='btn btn-success onlySave'>Save</button>").append("<button type='button' class='btn btn-danger btnCancelSwal'>Cancel</button>");
            } else{
                var buttons = $('<div>').append("There are unsaved changes. Are you sure that you want to leave this form?<br><br><button data-clickedItem='"+elementID+"' type='button' class='btn btn-secondary LeaveNotSave'>Leave & Don't Save</button>").append("<button data-clickedItem='"+elementID+"' type='button' class='btn btn-success saveAndLeave'>Save & Leave</button>").append("<button type='button' class='btn btn-danger btnCancelSwal'>Cancel</button>");
            }

            swal({
                title: "Are you sure?",
                text: "Do You Want to Delete This OrderItem?",
                html: buttons,
                type: "warning",
                showConfirmButton: false,
                showCancelButton: false
            });

            return false;

        } else {
            if($(this).attr("formid")) {
                ItemForm = $(this).attr("formid");
            } else {
                ItemForm = null;
            }
        }
    });

    $(document).on('click', '.LeaveNotSave', function() {
        //Some code 1
        var elementID = $(this).attr("data-clickedItem");

        numberSequencesFilled.forEach(clearTextBoxes);
        $(".TOTALblanks").each(function() {
            $(this).val($( this ).attr("data-alradysaved"));
        });
        $(".TOTALnums").each(function() {
            $(this).val($( this ).attr("data-alradysaved"));
        });
        $(".TOTALqty").each(function() {
            $(this).val($( this ).attr("data-alradysaved"));
        });

        numberSequencesFilled.length = 0;

        $("#"+elementID).click();

        console.log(numberSequencesFilled);
        swal.clickConfirm();

    });

    $(document).on('click', '.btnCancelSwal', function() {
        //Some code 1

        swal.clickConfirm();

    });

    $(document).on('click', '.onlySave', function() {
        if(ItemForm == null)
        {
            let searchParams = new URLSearchParams(window.location.search)
            if(searchParams.has('active_tab'))
            {
                ItemForm= searchParams.get('active_tab');
            }
        }
        $("#formItem"+ItemForm).submit();

    });

    $(document).on('click', '.saveAndLeave', function() {
        var elementID = $(this).attr("data-clickedItem");

        //Some code 1
        if(ItemForm == null)
        {
            let searchParams = new URLSearchParams(window.location.search)
            if(searchParams.has('active_tab'))
            {
                ItemForm= searchParams.get('active_tab');
            }
        }
        var dataString = $("#formItem"+ItemForm).serialize();
        dataString = "saveLeave=yes&"+dataString;
        $.ajax({
            type: "POST",
            url: "{{ route('roster.update') }}",
            data: dataString,
            success: function(data) {
                if(data == "DoneAjaxPost")
                {
                    numberSequencesFilled.length = 0;
                    swal.clickConfirm();
                    swal({
                        title: "Saved Details",
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false,
                        showCancelButton: false
                    });
                    $("#"+elementID).click();
                }

            }

        });
        //alert(dataString);


    });

    function clearTextBoxes(item) {
        //console.log(item);

        $("input[name='"+item+"']").val($("input[name='"+item+"']").attr("data-alradysaved"));
        var orderItemDetailId = $("input[name='"+item+"']").attr("data-orderitemdetailid");
        $("input[name='product["+orderItemDetailId+"][qty]']").val($("input[name='product["+orderItemDetailId+"][qty]']").attr("data-alradysaved"));//qtyseq

    }

    const numberSequencesFilled = [];

    $(".numseq").on( "input", function() {

        numberSequencesFilled.push($(this).attr("name"));
        //console.log(numberSequencesFilled);
    });
    $(".blankseq").on( "input", function() {

       numberSequencesFilled.push($(this).attr("name"));
       //console.log(numberSequencesFilled);
   });
   $(".txtSizeName").on( "input", function() {

       numberSequencesFilled.push($(this).attr("name"));
       //console.log(numberSequencesFilled);
   });

   $('body').on('keyup', '.numseq', function(e) {

        if (!isNaN(e.key)) {
            var orderItemDetailId = $(this).attr("data-orderItemDetailId");
            var numQty = $(".qtyseq"+orderItemDetailId+"").val();

            if(numQty == 125){
                if($(this).val().length == 1)
                {

                    $("."+orderItemDetailId+"rowspans").prop("rowspan", "6");

                    $("."+orderItemDetailId+"row4Hidden").removeAttr('hidden');

                }
            }

            if(numQty >= 100 && numQty < 125){
                if($(this).val().length == 1)
                {

                    $("."+orderItemDetailId+"rowspans").prop("rowspan", "5");

                    $("."+orderItemDetailId+"row3Hidden").removeAttr('hidden');

                }
            }

            if(numQty >= 75 && numQty < 100){
                if($(this).val().length == 1)
                {

                    $("."+orderItemDetailId+"rowspans").prop("rowspan", "4");

                    $("."+orderItemDetailId+"row2Hidden").removeAttr('hidden');

                }
            }
            if(numQty >= 50 && numQty < 75)
            {
                if($(this).val().length == 1)
                {

                    $("."+orderItemDetailId+"rowspans").prop("rowspan", "3");

                    $("."+orderItemDetailId+"row1Hidden").removeAttr('hidden');

                }

                var below2Lenght = 0;
                if($(this).closest('td').find('.below').length == 0 && $(this).closest('td').find('.below1').length == 0 && $(this).closest('td').find('.below2').length == 0){
                    below2Lenght = $(this).closest('tr').next().next().next().find('.counted').length;
                }else if($(this).closest('td').find('.below').length == 1){
                    below2Lenght = $(this).closest('tr').next().next().find('.counted').length;
                }else if($(this).closest('td').find('.below1').length == 1){
                    below2Lenght = $(this).closest('tr').next().find('.counted').length;
                }else if($(this).closest('td').find('.below2').length == 1){
                    below2Lenght = $(this).closest('tr').find('.counted').length;
                }

                if(below2Lenght == 0)
                {
                    $("."+orderItemDetailId+"rowspans").prop("rowspan", "3");
                    $("."+orderItemDetailId+"row2Hidden").prop("hidden", true);
                }

            }
            if(numQty < 50){
                console.log('print6');
                var below1Lenght = 0;
                if($(this).closest('td').find('.below').length == 0 && $(this).closest('td').find('.below1').length == 0 && $(this).closest('td').find('.below2').length == 0){
                    below1Lenght = $(this).closest('tr').next().next().find('.counted').length;
                }else if($(this).closest('td').find('.below').length == 1){
                    below1Lenght = $(this).closest('tr').next().find('.counted').length;
                }else if($(this).closest('td').find('.below1').length == 1){
                    below1Lenght = $(this).closest('tr').find('.counted').length;
                }else if($(this).closest('td').find('.below2').length == 1){
                    below1Lenght = $(this).closest('tr').prev().find('.counted').length;
                }

                var below2Lenght = 0;
                if($(this).closest('td').find('.below').length == 0 && $(this).closest('td').find('.below1').length == 0 && $(this).closest('td').find('.below2').length == 0){
                    below2Lenght = $(this).closest('tr').next().next().next().find('.counted').length;
                }else if($(this).closest('td').find('.below').length == 1){
                    below2Lenght = $(this).closest('tr').next().next().find('.counted').length;
                }else if($(this).closest('td').find('.below1').length == 1){
                    below2Lenght = $(this).closest('tr').next().find('.counted').length;
                }else if($(this).closest('td').find('.below2').length == 1){
                    below2Lenght = $(this).closest('tr').find('.counted').length;
                }

                if(below1Lenght == 0 && below2Lenght == 0)
                {
                    $("."+orderItemDetailId+"rowspans").prop("rowspan", "2");
                    $("."+orderItemDetailId+"row1Hidden").prop("hidden", true);
                    $("."+orderItemDetailId+"row2Hidden").prop("hidden", true);
                }
            }
        }
        else{
            var below1Lenght = 0;
            if($(this).closest('td').find('.below').length == 0 && $(this).closest('td').find('.below1').length == 0 && $(this).closest('td').find('.below2').length == 0){
                below1Lenght = $(this).closest('tr').next().next().find('.counted').length;
            }else if($(this).closest('td').find('.below').length == 1){
                below1Lenght = $(this).closest('tr').next().find('.counted').length;
            }else if($(this).closest('td').find('.below1').length == 1){
                below1Lenght = $(this).closest('tr').find('.counted').length;
            }else if($(this).closest('td').find('.below2').length == 1){
                below1Lenght = $(this).closest('tr').prev().find('.counted').length;
            }

            var below2Lenght = 0;
            if($(this).closest('td').find('.below').length == 0 && $(this).closest('td').find('.below1').length == 0 && $(this).closest('td').find('.below2').length == 0){
                below2Lenght = $(this).closest('tr').next().next().next().find('.counted').length;
            }else if($(this).closest('td').find('.below').length == 1){
                below2Lenght = $(this).closest('tr').next().next().find('.counted').length;
            }else if($(this).closest('td').find('.below1').length == 1){
                below2Lenght = $(this).closest('tr').next().find('.counted').length;
            }else if($(this).closest('td').find('.below2').length == 1){
                below2Lenght = $(this).closest('tr').find('.counted').length;
            }



            var orderItemDetailId = $(this).attr("data-orderItemDetailId");
            var numQty = $(".qtyseq"+orderItemDetailId+"").val();
            if(numQty < 50)
            {
                if(below1Lenght == 0 && below2Lenght == 0)
                {
                    $("."+orderItemDetailId+"rowspans").prop("rowspan", "2");
                    $("."+orderItemDetailId+"row1Hidden").prop("hidden", true);
                    $("."+orderItemDetailId+"row2Hidden").prop("hidden", true);
                    $("."+orderItemDetailId+"row3Hidden").prop("hidden", true);
                    $("."+orderItemDetailId+"row4Hidden").prop("hidden", true);
                }
            }
            else if(numQty >= 50 && numQty < 75)
            {
                if(below2Lenght == 0)
                {
                    $("."+orderItemDetailId+"rowspans").prop("rowspan", "3");
                    $("."+orderItemDetailId+"row2Hidden").prop("hidden", true);
                    $("."+orderItemDetailId+"row3Hidden").prop("hidden", true);
                    $("."+orderItemDetailId+"row4Hidden").prop("hidden", true);
                }

            }
        }
        });

    $(document).ready(function(){
        $(".se-pre-con").hide();
        $("#customer_portal_nav").show();

        if ($('#new_shipping_address').val() == 1) {
            $('.default-address').hide();
            $('.new-address').show();
        } else {
            $('.default-address').show();
            $('.new-address').hide();
        }

        $('#order_no').select2();

        var activeTabId = $('#active_tab_id').val();
        if(activeTabId == 'order'){
            $('#invoice-tab').tab('show');
        } else {
            $('#tab_'+activeTabId+'_link').tab('show');
        }

        // Cancel Option
        $('.cancel_btn').on('click', function(){
            location.reload();
        });

        // Add Extra Sizes
        var action = 1;
        $("body").on("click", ".add-size", function(){
            var order_id = $(this).val();
            if ( action == 1 ) {
                $(".order-"+order_id+"-18").show();
                $(".order-"+order_id+"-21").show();
                $(".order-"+order_id+"-24").show();
                action = 2;

            } else {
                $(".order-"+order_id+"-19").show();
                $(".order-"+order_id+"-22").show();
                $(".order-"+order_id+"-25").show();
                action = 1;
            }
        });

        // adding classes to inserted no sequence
        $('body .numseq').filter(function() {
            return $(this).val() != "" && $(this);
        }).addClass("counted");


        calculateTOTALalQtys();
        calculateTOTALalQtysDefault();

        //calculate TOTALal qty When Adding No sequence
        $("body").on('input', '.numseq', function (){
            // console.log($(this).val());
            if($(this).val() != ''){
                $(this).addClass("counted");
            }else if($(this).val() == ''){
                $(this).removeClass("counted");
            }

            /*if($(this).closest('td').find('.below').length == 0){
                var countedThis = $(this).closest('tr').find('.counted').length;
                var countedBelow = $(this).closest('tr').next().find('.counted').length;
                var TOTALal_count = countedThis + countedBelow;
                $(this).closest('tr').find('.qtyseq').val(TOTALal_count);

            }else if($(this).closest('td').find('.below').length == 1){
                var countedThis = $(this).closest('tr').find('.counted').length;
                var countedUpper = $(this).closest('tr').prev().find('.counted').length;
                var TOTALal_count = countedThis + countedUpper;
                $(this).closest('tr').prev().find('.qtyseq').val(TOTALal_count);
            }*/

            if($(this).closest('td').find('.below').length == 0 && $(this).closest('td').find('.below1').length == 0 && $(this).closest('td').find('.below2').length == 0 && $(this).closest('td').find('.below3').length == 0 && $(this).closest('td').find('.below4').length == 0) {
                    var countedThis = $(this).closest('tr').find('.counted').length; // row 1
                    var countedBelow = $(this).closest('tr').next().find('.counted').length; // row 2
                    var countedBelow1 = $(this).closest('tr').next().next().find('.counted').length; // row 3
                    var countedBelow2 = $(this).closest('tr').next().next().next().find('.counted').length; // row 4
                    var countedBelow3 = $(this).closest('tr').next().next().next().next().find('.counted').length; // row 5
                    var countedBelow4 = $(this).closest('tr').next().next().next().next().next().find('.counted').length; // row 6
                    var TOTALal_count = countedThis + countedBelow + countedBelow1 + countedBelow2 + countedBelow3 + countedBelow4;
                    $(this).closest('tr').find('.qtyseq').val(TOTALal_count);
                } else if($(this).closest('td').find('.below').length == 1) {
                    var countedUpper = $(this).closest('tr').prev().find('.counted').length; // row 1
                    var countedThis = $(this).closest('tr').find('.counted').length; // row 2
                    var countedBelow1 = $(this).closest('tr').next().find('.counted').length; // row 3
                    var countedBelow2 = $(this).closest('tr').next().next().find('.counted').length; // row 4
                    var countedBelow3 = $(this).closest('tr').next().next().next().find('.counted').length; // row 5
                    var countedBelow4 = $(this).closest('tr').next().next().next().next().find('.counted').length; // row 6
                    var TOTALal_count = countedThis + countedUpper + countedBelow1 + countedBelow2 + countedBelow3 + countedBelow4;
                    $(this).closest('tr').prev().find('.qtyseq').val(TOTALal_count);
                } else if($(this).closest('td').find('.below1').length == 1) {
                    var countedbelow2 = $(this).closest('tr').next().next().next().find('.counted').length; // row 6
                    var countedbelow1 = $(this).closest('tr').next().next().find('.counted').length; // row 5
                    var countedbelow = $(this).closest('tr').next().find('.counted').length; // row 4
                    var countedThis = $(this).closest('tr').find('.counted').length; // row 3
                    var countedUpper1 = $(this).closest('tr').prev().find('.counted').length; // row 2
                    var countedUpper2 = $(this).closest('tr').prev().prev().find('.counted').length; // row 1
                    var TOTALal_count = countedThis + countedUpper1 + countedUpper2 + countedbelow + countedbelow1 + countedbelow2;
                    $(this).closest('tr').prev().prev().find('.qtyseq').val(TOTALal_count);
                } else if($(this).closest('td').find('.below2').length == 1) {
                    var countedbelow1 = $(this).closest('tr').next().next().find('.counted').length; // row 6
                    var countedbelow = $(this).closest('tr').next().find('.counted').length; // row 5
                    var countedThis = $(this).closest('tr').find('.counted').length; // row 4
                    var countedUpper1 = $(this).closest('tr').prev().find('.counted').length; // row 3
                    var countedUpper2 = $(this).closest('tr').prev().prev().find('.counted').length; // row 2
                    var countedUpper3 = $(this).closest('tr').prev().prev().prev().find('.counted').length; // row 1
                    var TOTALal_count = countedbelow + countedbelow1 + countedThis + countedUpper1 + countedUpper2 + countedUpper3;
                    $(this).closest('tr').prev().prev().prev().find('.qtyseq').val(TOTALal_count);
                }
                else if ($(this).closest('td').find('.below3').length == 1) {
                    var countedbelow = $(this).closest('tr').next().find('.counted').length; // row 6
                    var countedThis = $(this).closest('tr').find('.counted').length; // row 5
                    var countedUpper1 = $(this).closest('tr').prev().find('.counted').length; // row 4
                    var countedUpper2 = $(this).closest('tr').prev().prev().find('.counted').length; // row 3
                    var countedUpper3 = $(this).closest('tr').prev().prev().prev().find('.counted').length; // row 2
                    var countedUpper4 = $(this).closest('tr').prev().prev().prev().prev().find('.counted').length; // row 1
                    console.log('here');
                    console.log(countedbelow,countedThis,countedUpper1,countedUpper2,countedUpper3,countedUpper4);
                    var TOTALal_count = countedbelow + countedThis + countedUpper1 + countedUpper2 + countedUpper3 + countedUpper4;
                    $(this).closest('tr').prev().prev().prev().prev().find('.qtyseq').val(TOTALal_count);
                } else if ($(this).closest('td').find('.below4').length == 1) {
                    var countedThis = $(this).closest('tr').find('.counted').length; // row 6
                    var countedUpper1 = $(this).closest('tr').prev().find('.counted').length; // row 5
                    var countedUpper2 = $(this).closest('tr').prev().prev().find('.counted').length; // row 4
                    var countedUpper3 = $(this).closest('tr').prev().prev().prev().find('.counted').length; // row 3
                    var countedUpper4 = $(this).closest('tr').prev().prev().prev().prev().find('.counted').length; // row 2
                    var countedUpper5 = $(this).closest('tr').prev().prev().prev().prev().prev().find('.counted').length; // row 1
                    var TOTALal_count = countedThis + countedUpper1 + countedUpper2 + countedUpper3 + countedUpper4 + countedUpper5;
                    $(this).closest('tr').prev().prev().prev().prev().prev().find('.qtyseq').val(TOTALal_count);
                }


            calculateTOTALalQtys();
        });

        //calculate TOTALal qty When Adding Blanks
        $("body").on('input', '.blankseq', function () {
            calculateTOTALalQtys();
        });

        order_details[0].order_items.forEach(order_items => {
            // var mockupPreloadFiles = [];
            // var mockupPreloadFiledetails = [];
            // var mockupPreloadImages = [];
            // var mockupPreloadImagedetails = [];

            var techPackPreloadFiles = [];
            var techPackPreloadFilesDetails = [];
            var techPackPreloadImages = [];
            var techPackPreloadImagesDetails = [];

            var productionLayoutPreloadFiles = [];
            var productionLayoutPreloadFilesDetails = [];
            var productionLayoutPreloadImages = [];
            var productionLayoutPreloadImagesDetails = [];

            // var productPicturePreloadFiles = [];
            // var productPicturePreloadFilesDetails = [];
            // var productPicturePreloadImages = [];
            // var productPicturePreloadImagesDetails = [];

            // var factoryPhotosPreloadFiles = [];
            // var factoryPhotosPreloadFilesDetails = [];
            // var factoryPhotosPreloadImages = [];
            // var factoryPhotosPreloadImagesDetails = [];

            // var croppedPhotosPreloadFiles = [];
            // var croppedPhotosPreloadFilesDetails = [];
            // var croppedPhotosPreloadImages = [];
            // var croppedPhotosPreloadImagesDetails = [];

            order_items.order_item_files.forEach( function(item_files, index) {

                // mock up images and files
                // if(item_files.mockup_files != null){
                //     mockupPreloadFiles.push(item_files.mockup_files);
                //     let mockupFileArray = {caption: item_files.mockup_file_name, downloadUrl:  item_files.mockup_files, width: "120px", key: index, extra: {id: item_files.id}};
                //     mockupPreloadFiledetails.push(mockupFileArray);
                // }

                // if(item_files.mockup_images != null){
                //     mockupPreloadImages.push(item_files.mockup_images);
                //     let mockupImageArray = {caption: item_files.mockup_image_name, downloadUrl:  item_files.mockup_images, width: "120px", key: index, extra: {id: item_files.id}};
                //     mockupPreloadImagedetails.push(mockupImageArray);
                // }

                // tech pack images and files
                if(item_files.tech_pack_files != null){
                    techPackPreloadFiles.push(item_files.tech_pack_files);
                    let techPackFileArray = {caption: item_files.tech_pack_file_name, downloadUrl:  item_files.tech_pack_files, width: "120px", key: index, extra: {id: item_files.id}};
                    techPackPreloadFilesDetails.push(techPackFileArray);
                }

                if(item_files.tech_pack_images != null){
                    techPackPreloadImages.push(item_files.tech_pack_images);
                    let techPackImageArray = {caption: item_files.tech_pack_image_name, downloadUrl:  item_files.tech_pack_images, width: "120px", key: index, extra: {id: item_files.id}};
                    techPackPreloadImagesDetails.push(techPackImageArray);
                }

                // production layout images and files
                if(item_files.production_layout_files != null){
                    productionLayoutPreloadFiles.push(item_files.production_layout_files);
                    let productionLayoutFileArray = {caption: item_files.production_layout_file_name, downloadUrl:  item_files.production_layout_files, width: "120px", key: index, extra: {id: item_files.id}};
                    productionLayoutPreloadFilesDetails.push(productionLayoutFileArray);
                }

                if(item_files.production_layout_images != null){
                    productionLayoutPreloadImages.push(item_files.production_layout_images);
                    let productionLayoutImageArray = {caption: item_files.production_layout_image_name, downloadUrl:  item_files.production_layout_images, width: "120px", key: index, extra: {id: item_files.id}};
                    productionLayoutPreloadImagesDetails.push(productionLayoutImageArray);
                }

                // product picture images and files
                // if(item_files.product_picture_files != null){
                //     productPicturePreloadFiles.push(item_files.product_picture_files);
                //     let productPictureFileArray = {caption: item_files.product_picture_file_name, downloadUrl:  item_files.product_picture_files, width: "120px", key: index, extra: {id: item_files.id}};
                //     productPicturePreloadFilesDetails.push(productPictureFileArray);
                // }

                // if(item_files.product_picture_images != null){
                //     productPicturePreloadImages.push(item_files.product_picture_images);
                //     let productPictureImageArray = {caption: item_files.product_picture_image_name, downloadUrl:  item_files.product_picture_images, width: "120px", key: index, extra: {id: item_files.id}};
                //     productPicturePreloadImagesDetails.push(productPictureImageArray);
                // }

                // factory photos images and files
                // if(item_files.factory_photos_files != null){
                //     factoryPhotosPreloadFiles.push(item_files.factory_photos_files);
                //     let productPictureFileArray = {caption: item_files.factory_photos_file_name, downloadUrl:  item_files.factory_photos_files, width: "120px", key: index, extra: {id: item_files.id}};
                //     factoryPhotosPreloadFilesDetails.push(productPictureFileArray);
                // }

                // if(item_files.factory_photos_images != null){
                //     factoryPhotosPreloadImages.push(item_files.factory_photos_images);
                //     let productPictureImageArray = {caption: item_files.factory_photos_image_name, downloadUrl:  item_files.factory_photos_images, width: "120px", key: index, extra: {id: item_files.id}};
                //     factoryPhotosPreloadImagesDetails.push(productPictureImageArray);
                // }

                // cropped photos images and files
                // if(item_files.cropped_photos_files != null){
                //     croppedPhotosPreloadFiles.push(item_files.cropped_photos_files);
                //     let productPictureFileArray = {caption: item_files.cropped_photos_file_name, downloadUrl:  item_files.cropped_photos_files, width: "120px", key: index, extra: {id: item_files.id}};
                //     croppedPhotosPreloadFilesDetails.push(productPictureFileArray);
                // }

                // if(item_files.cropped_photos_images != null){
                //     croppedPhotosPreloadImages.push(item_files.cropped_photos_images);
                //     let productPictureImageArray = {caption: item_files.cropped_photos_image_name, downloadUrl:  item_files.cropped_photos_images, width: "120px", key: index, extra: {id: item_files.id}};
                //     croppedPhotosPreloadImagesDetails.push(productPictureImageArray);
                // }
            });

            // $("#mock_up_files_"+ order_items.id).fileinput({
            //     uploadUrl: "#",
            //     enableResumableUpload: true,
            //     initialPreview: mockupPreloadFiles,
            //     initialPreviewAsData: true,
            //     initialPreviewConfig: mockupPreloadFiledetails,
            //     theme: 'fas',
            //     deleteUrl: "{{ url('order_details/file_delete') }}",
            //     overwriteInitial: false,
            //     fileActionSettings: {
            //         showUpload: false,
            //         showZoom: false,
            //     },
            //     preferIconicPreview: true,
            //     previewFileIconSettings: { // configure your icon file extensions
            //         'doc': '<i class="fas fa-file-word text-primary"></i>',
            //         'xls': '<i class="fas fa-file-excel text-success"></i>',
            //         'ppt': '<i class="fas fa-file-powerpoint text-danger"></i>',
            //         'pdf': '<i class="fas fa-file-pdf text-danger"></i>',
            //         'zip': '<i class="fas fa-file-archive text-muted"></i>',
            //         'htm': '<i class="fas fa-file-code text-info"></i>',
            //         'txt': '<i class="fas fa-file-alt text-info"></i>',
            //         'mov': '<i class="fas fa-file-video text-warning"></i>',
            //         'mp3': '<i class="fas fa-file-audio text-warning"></i>',
            //         'jpg': '<i class="fas fa-file-image text-danger"></i>',
            //         'gif': '<i class="fas fa-file-image text-muted"></i>',
            //         'png': '<i class="fas fa-file-image text-primary"></i>'
            //     },
            //     previewFileExtSettings: { // configure the logic for determining icon file extensions
            //         'doc': function(ext) {
            //             return ext.match(/(doc|docx)$/i);
            //         },
            //         'xls': function(ext) {
            //             return ext.match(/(xls|xlsx)$/i);
            //         },
            //         'ppt': function(ext) {
            //             return ext.match(/(ppt|pptx)$/i);
            //         },
            //         'zip': function(ext) {
            //             return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
            //         },
            //         'htm': function(ext) {
            //             return ext.match(/(htm|html)$/i);
            //         },
            //         'txt': function(ext) {
            //             return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
            //         },
            //         'mov': function(ext) {
            //             return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
            //         },
            //         'mp3': function(ext) {
            //             return ext.match(/(mp3|wav)$/i);
            //         },
            //         'jpg': function(ext) {
            //             return ext.match(/(jpg|jpeg)$/i);
            //         }
            //     }
            // }).on('filebeforedelete', function() {
            //     return new Promise(function(resolve, reject) {
            //         $.confirm({
            //             title: 'Confirmation!',
            //             content: 'Are you sure you want to delete this file?',
            //             type: 'red',
            //             buttons: {
            //                 ok: {
            //                     btnClass: 'btn-primary text-white',
            //                     keys: ['enter'],
            //                     action: function(){
            //                         resolve();
            //                     }
            //                 },
            //                 cancel: function(){
            //                     $.alert('File deletion was aborted! ');
            //                 }
            //             }
            //         });
            //     });
            // });

            // $("#mock_up_images_"+ order_items.id).fileinput({
            //     uploadUrl: "#",
            //     // enableResumableUpload: true,
            //     initialPreview: mockupPreloadImages,
            //     initialPreviewAsData: true,
            //     initialPreviewConfig: mockupPreloadImagedetails,
            //     theme: 'fas',
            //     deleteUrl: "{{ url('order_details/file_delete') }}",
            //     overwriteInitial: true,
            //     maxFileSize: 5120000,
            //     allowedFileExtensions: ["jpeg", "jpg", "png", "gif"],
            //     fileActionSettings: {
            //         showZoom: function(config) {
            //             if (config.type === 'pdf' || config.type === 'image') {
            //                 return true;
            //             }
            //             return false;
            //         },
            //         showUpload: false,
            //     }
            // }).on('filebeforedelete', function() {
            //     return new Promise(function(resolve, reject) {
            //         $.confirm({
            //             title: 'Confirmation!',
            //             content: 'Are you sure you want to delete this file?',
            //             type: 'red',
            //             buttons: {
            //                 ok: {
            //                     btnClass: 'btn-primary text-white',
            //                     keys: ['enter'],
            //                     action: function(){
            //                         resolve();
            //                     }
            //                 },
            //                 cancel: function(){
            //                     $.alert('File deletion was aborted! ');
            //                 }
            //             }
            //         });
            //     });
            // })

            $("#teck_pack_files_"+ order_items.id).fileinput({
                uploadUrl: "#",
                enableResumableUpload: true,
                initialPreview: techPackPreloadFiles,
                initialPreviewAsData: true,
                initialPreviewConfig: techPackPreloadFilesDetails,
                theme: 'fas',
                deleteUrl: "{{ url('order_details/file_delete') }}",
                overwriteInitial: false,
                allowedFileExtensions: ["pdf"],
                fileActionSettings: {
                    showUpload: false,
                    showZoom: false,
                },
                preferIconicPreview: true,
                previewFileIconSettings: {
                    'doc': '<i class="fas fa-file-word text-primary"></i>',
                    'xls': '<i class="fas fa-file-excel text-success"></i>',
                    'ppt': '<i class="fas fa-file-powerpoint text-danger"></i>',
                    'pdf': '<i class="fas fa-file-pdf text-danger"></i>',
                    'zip': '<i class="fas fa-file-archive text-muted"></i>',
                    'htm': '<i class="fas fa-file-code text-info"></i>',
                    'txt': '<i class="fas fa-file-alt text-info"></i>',
                    'mov': '<i class="fas fa-file-video text-warning"></i>',
                    'mp3': '<i class="fas fa-file-audio text-warning"></i>',
                    'jpg': '<i class="fas fa-file-image text-danger"></i>',
                    'gif': '<i class="fas fa-file-image text-muted"></i>',
                    'png': '<i class="fas fa-file-image text-primary"></i>'
                },
                previewFileExtSettings: {
                    'doc': function(ext) {
                        return ext.match(/(doc|docx)$/i);
                    },
                    'xls': function(ext) {
                        return ext.match(/(xls|xlsx)$/i);
                    },
                    'ppt': function(ext) {
                        return ext.match(/(ppt|pptx)$/i);
                    },
                    'zip': function(ext) {
                        return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
                    },
                    'htm': function(ext) {
                        return ext.match(/(htm|html)$/i);
                    },
                    'txt': function(ext) {
                        return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
                    },
                    'mov': function(ext) {
                        return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
                    },
                    'mp3': function(ext) {
                        return ext.match(/(mp3|wav)$/i);
                    },
                    'jpg': function(ext) {
                        return ext.match(/(jpg|jpeg)$/i);
                    }
                }
            }).on('filebeforedelete', function() {
                return new Promise(function(resolve, reject) {
                    $.confirm({
                        title: 'Confirmation!',
                        content: 'Are you sure you want to delete this file?',
                        type: 'red',
                        buttons: {
                            ok: {
                                btnClass: 'btn-primary text-white',
                                keys: ['enter'],
                                action: function(){
                                    resolve();
                                }
                            },
                            cancel: function(){
                                $.alert('File deletion was aborted! ');
                            }
                        }
                    });
                });
            });

            $("#teck_pack_images_"+ order_items.id).fileinput({
                uploadUrl: "#",
                enableResumableUpload: true,
                initialPreview: techPackPreloadImages,
                initialPreviewAsData: true,
                initialPreviewConfig: techPackPreloadImagesDetails,
                theme: 'fas',
                deleteUrl: "{{ url('order_details/file_delete') }}",
                overwriteInitial: false,
                maxFileSize: 5120000,
                allowedFileExtensions: ["jpeg", "jpg", "png", "gif"],
                fileActionSettings: {
                    showZoom: function(config) {
                        if (config.type === 'pdf' || config.type === 'image') {
                            return true;
                        }
                        return false;
                    },
                    showUpload: false,
                }
            }).on('filebeforedelete', function() {
                return new Promise(function(resolve, reject) {
                    $.confirm({
                        title: 'Confirmation!',
                        content: 'Are you sure you want to delete this file?',
                        type: 'red',
                        buttons: {
                            ok: {
                                btnClass: 'btn-primary text-white',
                                keys: ['enter'],
                                action: function(){
                                    resolve();
                                }
                            },
                            cancel: function(){
                                $.alert('File deletion was aborted! ');
                            }
                        }
                    });
                });
            });

            $("#production_layout_files_"+ order_items.id).fileinput({
                uploadUrl: "#",
                enableResumableUpload: true,
                initialPreview: productionLayoutPreloadFiles,
                initialPreviewAsData: true,
                initialPreviewConfig: productionLayoutPreloadFilesDetails,
                theme: 'fas',
                deleteUrl: "{{ url('order_details/file_delete') }}",
                overwriteInitial: false,
                fileActionSettings: {
                    showUpload: false,
                    showZoom: false,
                },
                preferIconicPreview: true,
                previewFileIconSettings: {
                    'doc': '<i class="fas fa-file-word text-primary"></i>',
                    'xls': '<i class="fas fa-file-excel text-success"></i>',
                    'ppt': '<i class="fas fa-file-powerpoint text-danger"></i>',
                    'pdf': '<i class="fas fa-file-pdf text-danger"></i>',
                    'zip': '<i class="fas fa-file-archive text-muted"></i>',
                    'htm': '<i class="fas fa-file-code text-info"></i>',
                    'txt': '<i class="fas fa-file-alt text-info"></i>',
                    'mov': '<i class="fas fa-file-video text-warning"></i>',
                    'mp3': '<i class="fas fa-file-audio text-warning"></i>',
                    'jpg': '<i class="fas fa-file-image text-danger"></i>',
                    'gif': '<i class="fas fa-file-image text-muted"></i>',
                    'png': '<i class="fas fa-file-image text-primary"></i>'
                },
                previewFileExtSettings: {
                    'doc': function(ext) {
                        return ext.match(/(doc|docx)$/i);
                    },
                    'xls': function(ext) {
                        return ext.match(/(xls|xlsx)$/i);
                    },
                    'ppt': function(ext) {
                        return ext.match(/(ppt|pptx)$/i);
                    },
                    'zip': function(ext) {
                        return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
                    },
                    'htm': function(ext) {
                        return ext.match(/(htm|html)$/i);
                    },
                    'txt': function(ext) {
                        return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
                    },
                    'mov': function(ext) {
                        return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
                    },
                    'mp3': function(ext) {
                        return ext.match(/(mp3|wav)$/i);
                    },
                    'jpg': function(ext) {
                        return ext.match(/(jpg|jpeg)$/i);
                    }
                }
            }).on('filebeforedelete', function() {
                return new Promise(function(resolve, reject) {
                    $.confirm({
                        title: 'Confirmation!',
                        content: 'Are you sure you want to delete this file?',
                        type: 'red',
                        buttons: {
                            ok: {
                                btnClass: 'btn-primary text-white',
                                keys: ['enter'],
                                action: function(){
                                    resolve();
                                }
                            },
                            cancel: function(){
                                $.alert('File deletion was aborted! ');
                            }
                        }
                    });
                });
            });

            $("#production_layout_images_"+ order_items.id).fileinput({
                uploadUrl: "#",
                enableResumableUpload: true,
                initialPreview: productionLayoutPreloadImages,
                initialPreviewAsData: true,
                initialPreviewConfig: productionLayoutPreloadImagesDetails,
                theme: 'fas',
                deleteUrl: "{{ url('order_details/file_delete') }}",
                overwriteInitial: false,
                maxFileSize: 5120000,
                allowedFileExtensions: ["jpeg", "jpg", "png", "gif"],
                fileActionSettings: {
                    showZoom: function(config) {
                        if (config.type === 'pdf' || config.type === 'image') {
                            return true;
                        }
                        return false;
                    },
                    showUpload: false,
                }
            }).on('filebeforedelete', function() {
                return new Promise(function(resolve, reject) {
                    $.confirm({
                        title: 'Confirmation!',
                        content: 'Are you sure you want to delete this file?',
                        type: 'red',
                        buttons: {
                            ok: {
                                btnClass: 'btn-primary text-white',
                                keys: ['enter'],
                                action: function(){
                                    resolve();
                                }
                            },
                            cancel: function(){
                                $.alert('File deletion was aborted! ');
                            }
                        }
                    });
                });
            });

            // $("#product_picture_files_"+ order_items.id).fileinput({
            //     uploadUrl: "#",
            //     enableResumableUpload: true,
            //     initialPreview: productPicturePreloadFiles,
            //     initialPreviewAsData: true,
            //     initialPreviewConfig: productPicturePreloadFilesDetails,
            //     theme: 'fas',
            //     deleteUrl: "{{ url('order_details/file_delete') }}",
            //     overwriteInitial: false,
            //     fileActionSettings: {
            //         showUpload: false,
            //         showZoom: false,
            //     },
            //     preferIconicPreview: true,
            //     previewFileIconSettings: {
            //         'doc': '<i class="fas fa-file-word text-primary"></i>',
            //         'xls': '<i class="fas fa-file-excel text-success"></i>',
            //         'ppt': '<i class="fas fa-file-powerpoint text-danger"></i>',
            //         'pdf': '<i class="fas fa-file-pdf text-danger"></i>',
            //         'zip': '<i class="fas fa-file-archive text-muted"></i>',
            //         'htm': '<i class="fas fa-file-code text-info"></i>',
            //         'txt': '<i class="fas fa-file-alt text-info"></i>',
            //         'mov': '<i class="fas fa-file-video text-warning"></i>',
            //         'mp3': '<i class="fas fa-file-audio text-warning"></i>',
            //         'jpg': '<i class="fas fa-file-image text-danger"></i>',
            //         'gif': '<i class="fas fa-file-image text-muted"></i>',
            //         'png': '<i class="fas fa-file-image text-primary"></i>'
            //     },
            //     previewFileExtSettings: {
            //         'doc': function(ext) {
            //             return ext.match(/(doc|docx)$/i);
            //         },
            //         'xls': function(ext) {
            //             return ext.match(/(xls|xlsx)$/i);
            //         },
            //         'ppt': function(ext) {
            //             return ext.match(/(ppt|pptx)$/i);
            //         },
            //         'zip': function(ext) {
            //             return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
            //         },
            //         'htm': function(ext) {
            //             return ext.match(/(htm|html)$/i);
            //         },
            //         'txt': function(ext) {
            //             return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
            //         },
            //         'mov': function(ext) {
            //             return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
            //         },
            //         'mp3': function(ext) {
            //             return ext.match(/(mp3|wav)$/i);
            //         },
            //         'jpg': function(ext) {
            //             return ext.match(/(jpg|jpeg)$/i);
            //         }
            //     }
            // }).on('filebeforedelete', function() {
            //     return new Promise(function(resolve, reject) {
            //         $.confirm({
            //             title: 'Confirmation!',
            //             content: 'Are you sure you want to delete this file?',
            //             type: 'red',
            //             buttons: {
            //                 ok: {
            //                     btnClass: 'btn-primary text-white',
            //                     keys: ['enter'],
            //                     action: function(){
            //                         resolve();
            //                     }
            //                 },
            //                 cancel: function(){
            //                     $.alert('File deletion was aborted! ');
            //                 }
            //             }
            //         });
            //     });
            // });

            // $("#product_picture_images_"+ order_items.id).fileinput({
            //     uploadUrl: "#",
            //     enableResumableUpload: true,
            //     initialPreview: productPicturePreloadImages,
            //     initialPreviewAsData: true,
            //     initialPreviewConfig: productPicturePreloadImagesDetails,
            //     theme: 'fas',
            //     deleteUrl: "{{ url('order_details/file_delete') }}",
            //     overwriteInitial: false,
            //     maxFileSize: 5120000,
            //     allowedFileExtensions: ["jpeg", "jpg", "png", "gif"],
            //     fileActionSettings: {
            //         showZoom: function(config) {
            //             if (config.type === 'pdf' || config.type === 'image') {
            //                 return true;
            //             }
            //             return false;
            //         },
            //         showUpload: false,
            //     }
            // }).on('filebeforedelete', function() {
            //     return new Promise(function(resolve, reject) {
            //         $.confirm({
            //             title: 'Confirmation!',
            //             content: 'Are you sure you want to delete this file?',
            //             type: 'red',
            //             buttons: {
            //                 ok: {
            //                     btnClass: 'btn-primary text-white',
            //                     keys: ['enter'],
            //                     action: function(){
            //                         resolve();
            //                     }
            //                 },
            //                 cancel: function(){
            //                     $.alert('File deletion was aborted! ');
            //                 }
            //             }
            //         });
            //     });
            // });

            // Factory Photos
            // $("#factory_photos_files_"+ order_items.id).fileinput({
            //     uploadUrl: "#",
            //     enableResumableUpload: true,
            //     initialPreview: factoryPhotosPreloadFiles,
            //     initialPreviewAsData: true,
            //     initialPreviewConfig: factoryPhotosPreloadFilesDetails,
            //     theme: 'fas',
            //     deleteUrl: "{{ url('order_details/file_delete') }}",
            //     overwriteInitial: false,
            //     fileActionSettings: {
            //         showUpload: false,
            //         showZoom: false,
            //     },
            //     preferIconicPreview: true,
            //     previewFileIconSettings: {
            //         'doc': '<i class="fas fa-file-word text-primary"></i>',
            //         'xls': '<i class="fas fa-file-excel text-success"></i>',
            //         'ppt': '<i class="fas fa-file-powerpoint text-danger"></i>',
            //         'pdf': '<i class="fas fa-file-pdf text-danger"></i>',
            //         'zip': '<i class="fas fa-file-archive text-muted"></i>',
            //         'htm': '<i class="fas fa-file-code text-info"></i>',
            //         'txt': '<i class="fas fa-file-alt text-info"></i>',
            //         'mov': '<i class="fas fa-file-video text-warning"></i>',
            //         'mp3': '<i class="fas fa-file-audio text-warning"></i>',
            //         'jpg': '<i class="fas fa-file-image text-danger"></i>',
            //         'gif': '<i class="fas fa-file-image text-muted"></i>',
            //         'png': '<i class="fas fa-file-image text-primary"></i>'
            //     },
            //     previewFileExtSettings: {
            //         'doc': function(ext) {
            //             return ext.match(/(doc|docx)$/i);
            //         },
            //         'xls': function(ext) {
            //             return ext.match(/(xls|xlsx)$/i);
            //         },
            //         'ppt': function(ext) {
            //             return ext.match(/(ppt|pptx)$/i);
            //         },
            //         'zip': function(ext) {
            //             return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
            //         },
            //         'htm': function(ext) {
            //             return ext.match(/(htm|html)$/i);
            //         },
            //         'txt': function(ext) {
            //             return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
            //         },
            //         'mov': function(ext) {
            //             return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
            //         },
            //         'mp3': function(ext) {
            //             return ext.match(/(mp3|wav)$/i);
            //         },
            //         'jpg': function(ext) {
            //             return ext.match(/(jpg|jpeg)$/i);
            //         }
            //     }
            // }).on('filebeforedelete', function() {
            //     return new Promise(function(resolve, reject) {
            //         $.confirm({
            //             title: 'Confirmation!',
            //             content: 'Are you sure you want to delete this file?',
            //             type: 'red',
            //             buttons: {
            //                 ok: {
            //                     btnClass: 'btn-primary text-white',
            //                     keys: ['enter'],
            //                     action: function(){
            //                         resolve();
            //                     }
            //                 },
            //                 cancel: function(){
            //                     $.alert('File deletion was aborted! ');
            //                 }
            //             }
            //         });
            //     });
            // });

            // $("#factory_photos_images_"+ order_items.id).fileinput({
            //     uploadUrl: "#",
            //     enableResumableUpload: true,
            //     initialPreview: factoryPhotosPreloadImages,
            //     initialPreviewAsData: true,
            //     initialPreviewConfig: factoryPhotosPreloadImagesDetails,
            //     theme: 'fas',
            //     deleteUrl: "{{ url('order_details/file_delete') }}",
            //     overwriteInitial: false,
            //     maxFileSize: 5120000,
            //     allowedFileExtensions: ["jpeg", "jpg", "png", "gif"],
            //     fileActionSettings: {
            //         showZoom: function(config) {
            //             if (config.type === 'pdf' || config.type === 'image') {
            //                 return true;
            //             }
            //             return false;
            //         },
            //         showUpload: false,
            //     }
            // }).on('filebeforedelete', function() {
            //     return new Promise(function(resolve, reject) {
            //         $.confirm({
            //             title: 'Confirmation!',
            //             content: 'Are you sure you want to delete this file?',
            //             type: 'red',
            //             buttons: {
            //                 ok: {
            //                     btnClass: 'btn-primary text-white',
            //                     keys: ['enter'],
            //                     action: function(){
            //                         resolve();
            //                     }
            //                 },
            //                 cancel: function(){
            //                     $.alert('File deletion was aborted! ');
            //                 }
            //             }
            //         });
            //     });
            // });

            // Cropped Photos
            // $("#cropped_photos_files_"+ order_items.id).fileinput({
            //     uploadUrl: "#",
            //     enableResumableUpload: true,
            //     initialPreview: croppedPhotosPreloadFiles,
            //     initialPreviewAsData: true,
            //     initialPreviewConfig: croppedPhotosPreloadFilesDetails,
            //     theme: 'fas',
            //     deleteUrl: "{{ url('order_details/file_delete') }}",
            //     overwriteInitial: false,
            //     fileActionSettings: {
            //         showUpload: false,
            //         showZoom: false,
            //     },
            //     preferIconicPreview: true,
            //     previewFileIconSettings: {
            //         'doc': '<i class="fas fa-file-word text-primary"></i>',
            //         'xls': '<i class="fas fa-file-excel text-success"></i>',
            //         'ppt': '<i class="fas fa-file-powerpoint text-danger"></i>',
            //         'pdf': '<i class="fas fa-file-pdf text-danger"></i>',
            //         'zip': '<i class="fas fa-file-archive text-muted"></i>',
            //         'htm': '<i class="fas fa-file-code text-info"></i>',
            //         'txt': '<i class="fas fa-file-alt text-info"></i>',
            //         'mov': '<i class="fas fa-file-video text-warning"></i>',
            //         'mp3': '<i class="fas fa-file-audio text-warning"></i>',
            //         'jpg': '<i class="fas fa-file-image text-danger"></i>',
            //         'gif': '<i class="fas fa-file-image text-muted"></i>',
            //         'png': '<i class="fas fa-file-image text-primary"></i>'
            //     },
            //     previewFileExtSettings: {
            //         'doc': function(ext) {
            //             return ext.match(/(doc|docx)$/i);
            //         },
            //         'xls': function(ext) {
            //             return ext.match(/(xls|xlsx)$/i);
            //         },
            //         'ppt': function(ext) {
            //             return ext.match(/(ppt|pptx)$/i);
            //         },
            //         'zip': function(ext) {
            //             return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
            //         },
            //         'htm': function(ext) {
            //             return ext.match(/(htm|html)$/i);
            //         },
            //         'txt': function(ext) {
            //             return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
            //         },
            //         'mov': function(ext) {
            //             return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
            //         },
            //         'mp3': function(ext) {
            //             return ext.match(/(mp3|wav)$/i);
            //         },
            //         'jpg': function(ext) {
            //             return ext.match(/(jpg|jpeg)$/i);
            //         }
            //     }
            // }).on('filebeforedelete', function() {
            //     return new Promise(function(resolve, reject) {
            //         $.confirm({
            //             title: 'Confirmation!',
            //             content: 'Are you sure you want to delete this file?',
            //             type: 'red',
            //             buttons: {
            //                 ok: {
            //                     btnClass: 'btn-primary text-white',
            //                     keys: ['enter'],
            //                     action: function(){
            //                         resolve();
            //                     }
            //                 },
            //                 cancel: function(){
            //                     $.alert('File deletion was aborted! ');
            //                 }
            //             }
            //         });
            //     });
            // });

            // $("#cropped_photos_images_"+ order_items.id).fileinput({
            //     uploadUrl: "#",
            //     enableResumableUpload: true,
            //     initialPreview: croppedPhotosPreloadImages,
            //     initialPreviewAsData: true,
            //     initialPreviewConfig: croppedPhotosPreloadImagesDetails,
            //     theme: 'fas',
            //     deleteUrl: "{{ url('order_details/file_delete') }}",
            //     overwriteInitial: false,
            //     maxFileSize: 5120000,
            //     allowedFileExtensions: ["jpeg", "jpg", "png", "gif"],
            //     fileActionSettings: {
            //         showZoom: function(config) {
            //             if (config.type === 'pdf' || config.type === 'image') {
            //                 return true;
            //             }
            //             return false;
            //         },
            //         showUpload: false,
            //     }
            // }).on('filebeforedelete', function() {
            //     return new Promise(function(resolve, reject) {
            //         $.confirm({
            //             title: 'Confirmation!',
            //             content: 'Are you sure you want to delete this file?',
            //             type: 'red',
            //             buttons: {
            //                 ok: {
            //                     btnClass: 'btn-primary text-white',
            //                     keys: ['enter'],
            //                     action: function(){
            //                         resolve();
            //                     }
            //                 },
            //                 cancel: function(){
            //                     $.alert('File deletion was aborted! ');
            //                 }
            //             }
            //         });
            //     });
            // });
        });

        $('.kv-file-zoom').removeAttr('disabled');
    });

    function calculateTOTALalQtys() {
        if(order_details != ''){
            var order_items = order_details[0].order_items;

            for(var i = 0; i < order_items.length; i++){
                // console.log(order_items[i].id);
                // getting TOTALal number sequense count
                var TOTALnums =$('#tab_'+order_items[i].id+' .numseq').filter(function() {
                    return $(this).val() != "" && $(this);
                }).length;
                $('#TOTALnums_'+order_items[i].id).val(TOTALnums);
                console.log(TOTALnums);

                // getting TOTALal blanks count
                var TOTALblanks =$('#tab_'+order_items[i].id+' .blankseq').filter(function() {
                    return $(this).val() != "" && $(this);
                });
                var blankVals = 0;
                for(var j = 0; j < TOTALblanks.length; j++){
                    blankVals += parseFloat(TOTALblanks[j].value);
                }
                $('#TOTALblanks_'+order_items[i].id).val(blankVals);

                // getting TOTALal qty count
                var TOTALqty = TOTALnums + blankVals;
                $('#TOTALqty_'+order_items[i].id).val(TOTALqty);
            }
        }
    }

    function calculateTOTALalQtysDefault() {
        if(order_details != ''){
            var order_items = order_details[0].order_items;

            for(var i = 0; i < order_items.length; i++){
                // console.log(order_items[i].id);
                // getting TOTALal number sequense count
                var TOTALnums =$('#tab_'+order_items[i].id+' .numseq').filter(function() {
                    return $(this).val() != "" && $(this);
                }).length;
                //$('#TOTALnums_'+order_items[i].id).val(TOTALnums);
                $('#TOTALnums_'+order_items[i].id).attr("data-AlradySaved",TOTALnums);
                console.log(TOTALnums);

                // getting TOTALal blanks count
                var TOTALblanks =$('#tab_'+order_items[i].id+' .blankseq').filter(function() {
                    return $(this).val() != "" && $(this);
                });
                var blankVals = 0;
                for(var j = 0; j < TOTALblanks.length; j++){
                    blankVals += parseFloat(TOTALblanks[j].value);
                }
                //$('#TOTALblanks_'+order_items[i].id).val(blankVals);
                $('#TOTALblanks_'+order_items[i].id).attr("data-AlradySaved",blankVals);

                // getting TOTALal qty count
                var TOTALqty = TOTALnums + blankVals;
                //$('#TOTALqty_'+order_items[i].id).val(TOTALqty);
                $('#TOTALqty_'+order_items[i].id).attr("data-AlradySaved",TOTALqty);
            }
        }
    }

    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    function openSize(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontentCustom");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinksCustom");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    $(".rosterPlayerNameSection").click(function(){
        var sectionLinks =  $(this).attr("data-sectionLinks");
        var section = $(this).attr("href");
        $(""+section+" .tabcontentCustom"+":not(:first)").css( "display", "none" );
        $("."+sectionLinks+" .tablinksCustom"+":not(:first)").removeClass("active");
        $("."+sectionLinks+" .tablinksCustom").first().addClass("active");
        $(""+section+" .tabcontentCustom").first().css( "display", "block" );


    });

    $('body').on('click', '#new_shipping_address', function() {
        if ($(this).is(':checked')) {
            $(this).val(1);
            $('.default-address').hide();
            $('.new-address').show();
        } else {
            $(this).val(0);
            $('.default-address').show();
            $('.new-address').hide();
        }
    });

    $('body').on('keyup', '.new-address-input', function(){
        $('#btn_cus_add_save').show(700);
    });

    $('body').on('click', '#btn_cus_add_save', function(){
        console.log($(this).val());
    });

    // $(document).on('click', '.close-btn', function() {
    //     // Perform the desired action when the close button is clicked
    //     console.log("Close button clicked");
    //     // Add your code here to close or hide the element, etc.

    //     // Programmatically close the modal
    //     $('#preview-modal').modal('hide');
    // });

</script>
@endsection
