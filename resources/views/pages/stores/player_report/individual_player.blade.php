@extends('layouts.app', ['activePage' => 'Team Stores', 'titlePage' => __('Team Stores')])

@section('content')

<style>
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
        display: none;
    }

    .main_card {
        margin-top: 20px;
        border: unset;
        padding-bottom: 15px;
        border-radius: unset;
    }

    .share_btn {
        border: unset;
        background-color: transparent;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        color: #B3B3B3;
    }

    .btn_section {
        margin-right: 15px;
        padding: 15px;
        padding-bottom: unset;
    }

    .product_report {
        font-size: 18px;
    }

    .card_div {
        padding: 15px;
        padding-bottom: 5px;
    }

    .manage_group_p {
        font-size: 11px;
        color: #717070;
        font-weight: 500;
        margin-bottom: unset;
    }

    .share_btn_div {
        border-right: 1px solid #DEDEDE;
        margin: 5px;
    }

    .total_qty_text {
        font-size: 10px;
        color: #B3B3B3;
        font-weight: 500;
        margin-bottom: unset;
    }

    .total_qty_text2 {
        font-size: 11px;
        color: #B3B3B3;
        font-weight: 500;
        margin-bottom: unset;
    }

    .includes {
        font-size: 11px;
        color: #717070;
        font-weight: 700;
        margin-bottom: unset;
    }

    .qty_div {
        margin-right: 5px;
    }

    .qty_div2 {
        margin-right: 10px;
        margin-left: 5px;
        border-right: 1px solid #DEDEDE;
        padding-right: 10px;
    }

    .date_div {
        margin-right: 5px;
        margin-left: 5px;
        padding-left: 5px;
        padding-right: 5px;
        border-radius: 8px;
    }

    .manufacturer_div {
        margin-right: 5px;
        margin-left: 5px;
        padding-left: 5px;
        padding-right: 5px;
        border-radius: 8px;
    }

    .symbol1 {
        font-size: 16px;
        font-weight: 100;
        line-height: 1.3;
        color: #B3B3B3;
        margin-bottom: unset;
    }

    .table_header_text {
        color: white;
        height: 40px;
    }

    .table_body {
        color: #4E4C4C;
        height: 40px;
    }

    .bg-box.container-fluid.mb-5.fix-nav.header-layout {
        margin-bottom: .5rem !important;
    }

    .edit_store_btn {
        background-color: transparent;
        color: #B3B3B3;
        border: 1px solid #B3B3B3;
        width: fit-content;
        height: 33px;
        font-size: 10px;
        font-weight: 600;
        cursor: pointer;
        min-width: 8rem;
    }

    .edit_store_btn:disabled,
    .edit_store_btn[disabled] {
        background-color: #e1e1e1;
        color: #717070;
        border: unset;
        cursor: not-allowed;
    }

    .view_store_btn {
        background-color: #47D6B6;
        color: white;
        border: unset;
        width: auto;
        height: 33px;
        font-size: 10px;
        font-weight: 600;
        cursor: pointer;
    }

    .blinking-tr {
        animation: blinkingBg 2s ease-in-out infinite;
    }

    @keyframes blinkingBg {
        0% {
            background-color: #ffffff;
        }

        50% {
            background-color: #e6e6e6;
        }

        100% {
            background-color: #ffffff;
        }
    }

    /* ===== Mobile-only styles ===== */
    @media (max-width: 767px) {
        .desktop-only-ip {
            display: none !important;
        }

        .mobile-only-ip {
            display: block !important;
        }

        /* Accordion card */
        .ip-section {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #f0f0f0;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 10px;
            overflow: hidden;
        }

        .ip-section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 13px 16px;
            cursor: pointer;
            background: #fff;
        }

        .ip-section-header:active {
            background: #f9f9f9;
        }

        .ip-section-title {
            font-size: 13px;
            font-weight: 700;
            color: #333;
        }

        .ip-chevron {
            font-size: 13px;
            color: #bbb;
            transition: transform 0.2s ease;
        }

        .ip-chevron.open {
            transform: rotate(180deg);
        }

        .ip-section-body {
            border-top: 1px solid #f0f0f0;
            padding: 14px;
            background: #fafafa;
        }

        /* Detail rows */
        .ip-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 12px;
        }

        .ip-row:last-child {
            border-bottom: none;
        }

        .ip-label {
            color: #9ca3af;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            flex-shrink: 0;
            margin-right: 8px;
        }

        .ip-val {
            font-weight: 600;
            color: #333;
            font-size: 12px;
            text-align: right;
            word-break: break-word;
        }

        /* Product card */
        .ip-product-card {
            background: #fff;
            border: 1px solid #ebebeb;
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 10px;
        }

        .ip-product-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .ip-product-img {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            object-fit: contain;
            background: #f4f4f4;
            flex-shrink: 0;
        }

        .ip-product-name {
            font-size: 13px;
            font-weight: 700;
            color: #333;
        }

        .ip-product-sub {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 2px;
        }

        .ip-product-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .ip-product-field-label {
            font-size: 10px;
            color: #9ca3af;
            font-weight: 600;
            text-transform: uppercase;
        }

        .ip-product-field-val {
            font-size: 12px;
            font-weight: 700;
            color: #333;
        }

        /* Total rows */
        .ip-total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 13px;
        }

        .ip-total-row:last-child {
            border-bottom: none;
        }

        .ip-total-label {
            color: #717070;
            font-size: 12px;
        }

        .ip-total-val {
            font-weight: 700;
            color: #333;
            font-size: 13px;
        }

        .ip-total-val.grand {
            font-size: 16px;
            color: #222;
        }

        /* info form field */
        .ip-field-wrap {
            margin-bottom: 10px;
        }

        .ip-field-label {
            font-size: 10px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .ip-field-input {
            width: 100%;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            padding: 8px 10px;
            font-size: 13px;
            background: #fff;
        }

        .ip-field-input[disabled],
        .ip-field-input:disabled {
            background: #f5f5f5;
            color: #717070;
        }

        /* Payment badge */
        .ip-pay-badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        /* Payment card */
        .ip-payment-card {
            border: 1px solid #f0f0f0;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 10px;
            font-size: 12px;
        }

        .ip-payment-card-date {
            color: #9ca3af;
            font-size: 11px;
            margin-bottom: 6px;
        }

        .ip-payment-card-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
        }

        .ip-payment-card-label {
            color: #9ca3af;
            font-size: 10px;
            text-transform: uppercase;
        }

        .ip-payment-card-val {
            font-weight: 700;
            color: #333;
            font-size: 12px;
        }

        /* Mobile top bar */
        .ip-topbar {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #f0f0f0;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
            padding: 14px 16px;
            margin-bottom: 10px;
        }

        .ip-topbar-order {
            font-size: 16px;
            font-weight: 700;
            color: #333;
        }

        .ip-topbar-btns {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }

        .ip-topbar-btn {
            flex: 1;
            height: 38px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            cursor: pointer;
            border: 1px solid #e5e5e5;
            background: #fff;
            color: #555;
            text-decoration: none;
        }

        .ip-topbar-btn.primary {
            background: #47D6B6;
            color: #fff;
            border: none;
        }

        .ip-save-btn {
            width: 100%;
            height: 44px;
            background: #39a0b1;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            margin-top: 10px;
        }

        .header-layout {
            margin-bottom: 0 !important;
            height: auto !important;
            min-height: 0 !important;
        }

        /* Prevent iOS Safari from auto-zooming on focus */
        input[type="text"],
        input[type="number"],
        input[type="search"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        input[type="url"],
        select,
        textarea,
        .form-control,
        .select2-selection,
        .select2-search__field,
        .select2-search input {
            font-size: 16px !important;
        }
    }

    @media (min-width: 768px) {
        .mobile-only-ip {
            display: none !important;
        }

        .desktop-only-ip {
            display: block !important;
        }
    }
</style>

<div class="container-fluid mb-5" style="padding: 1rem !important;padding-top: 0rem !important;">
    <div class="se-pre-con"></div>

    {{-- ===== DESKTOP header ===== --}}
    <div class="desktop-only-ip">
        <div class="row" style="margin: 0;">
            <div class="card col-lg-12" style="border: none;border-radius: 0rem;">
                <div class="row">
                    <div class="col-md-4 p-3">
                        <strong class="product_report mr-3">Order #{{$order->order_no}}</strong>
                        <select class="status-change" style="border: none;background-color: #e1e1e1;color:black;padding: .3rem;border-radius: .5rem;" disabled>
                            @foreach ($store_order_statuses as $store_order_status)
                            <option value="{{$store_order_status->id}}" @if ($order->order_status == $store_order_status->id) selected @endif data-color="{{$store_order_status->color}}">{{$store_order_status->status_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-8 text-right p-3">
                        @if (empty($order->ShipmentDetails))
                        <a href="{{ route('usps.create_shipment', ['order_no' => $order->order_no]) }}" class="create-shipment">
                            <button class="edit_store_btn" style="width: fit-content" {{ !empty($TSRorder) && $TSRorder->order_status_id == 1 ? 'disabled' : '' }}>
                                <i class="fa fa-times" aria-hidden="true"></i> CREATE SHIPMENT
                            </button>
                        </a>
                        @endif
                        <button class="edit_store_btn" id="compose_email_button"><i class="fa fa-clone" aria-hidden="true"></i> EMAIL</button>
                    </div>
                </div>
            </div>
        </div>
    </div>{{-- end desktop-only-ip header --}}

    <select class="order-item-product-copy  d-none">
        @foreach ($storeProducts as $product)
        <option value="{{$product->id}}" data-image-url="{{$product->images->first() ? asset($product->images->first()->url) : asset('public/images/default.png')}}" data-product-price="{{$product->default_price}}" data-is-name-available="{{$product->set_individual_name}}" data-is-number-available="{{$product->set_individual_number}}" data-weight="{{$product->shipping_weight}}" data-size-type-id="{{$product->size_type_id}}">{{$product->product_name}}</option>
        @endforeach
    </select>
    <table>
        <tr class="d-none" style="border-bottom: 1px solid #DEDEDE;" id="sample_row">
            <td scope="col" class="table_body">
                <div style="display: table; width: auto; height: 100%;">
                    <div style="display: table-cell; vertical-align: middle; padding-right: 1rem;">
                        <img
                            src=""
                            alt="Product Image"
                            class="item-product-image"
                            style="width: 5rem; height: auto;">
                    </div>
                    <div style="display: table-cell; vertical-align: middle;">
                        <div style="font-weight: bold; font-size: 1rem; margin-bottom: 0.2rem;">
                            <select name="players[1][product_id]" class="order-item-product" style="border: none;">
                                @foreach ($storeProducts as $product)
                                <option value="{{$product->id}}" data-image-url="{{$product->images->first() ? asset($product->images->first()->url) : asset('public/images/default.png')}}" data-product-price="{{$product->default_price}}" data-is-name-available="{{$product->set_individual_name}}" data-is-number-available="{{$product->set_individual_number}}" data-weight="{{$product->shipping_weight}}" data-size-type-id="{{$product->size_type_id}}">{{$product->product_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="font-size: 0.8rem; color: gray;" class="mb-1">
                            Size :
                            <select name="players[1][size]" style="height: 1rem;border: none;">
                            </select>
                        </div>
                        <div style="font-size: 0.8rem; color: gray;" class="is-name-available mb-1">
                            Name : <input type="text" name="players[1][name]" value="" style="height: 1rem;border: 1px solid #c9c9c9;padding: .7rem .1rem;">
                        </div>
                        <div style="font-size: 0.8rem; color: gray;" class="is-number-available mb-1">
                            Number : <input type="number" step="1" min="0" name="players[1][number]" value="" style="height: 1rem;border: 1px solid #c9c9c9;padding: .7rem .1rem;">
                        </div>
                    </div>
                </div>
            </td>
            <td scope="col" class="table_body text-center"><input type="number" class="form-control text-center item-quantity" name="players[1][qty]" value="1" style="height: 1.5rem;"></td>
            <td scope="col" class="table_body text-right">
                <input type="number" name="players[1][unit_price]" class="text-right form-control unit-price" value="0" readonly style="height: 1.5rem;">
                <input type="hidden" class="product-weight" value="0" readonly>
            </td>
            <td scope="col" class="table_body text-right"><input type="number" name="players[1][total]" class="text-right form-control item-total" value="0" readonly style="height: 1.5rem;"></td>
            <td scope="col" class="table_body text-center">
                <input type="hidden" name="players[1][status]" value="1">
                <select class="status-change" name="players[1][status]" style="border: none;background-color: #e1e1e1;color:black;padding: .3rem;border-radius: .5rem;">
                    @foreach ($store_order_statuses as $store_order_status)
                    <option value="{{$store_order_status->id}}" data-color="{{$store_order_status->color}}" {{ $store_order_status->id == 1 ? 'selected' : '' }}>{{$store_order_status->status_name}}</option>
                    @endforeach
                </select>
            </td>
            <td class="text-center table_body">
                <i class="fa fa-trash remove-item" style="cursor: pointer;"></i>
                <i class="fa fa-clone duplicate-product" style="margin-left: 10px;cursor: pointer;"></i>
            </td>
        </tr>
    </table>

    <form action="{{route('store.save_shipping_details')}}" id="shipping-details-form" method="POST">

        @csrf

        <input type="hidden" name="order_no" value="{{$order->order_no}}">
        <input type="hidden" name="is_shipping_removed" id="is_shipping_removed" value="{{ $order->is_shipping_removed }}">
        <div id="deleted_items_container">
            <!-- new hidden inputs will be appended here -->
        </div>

        {{-- ===== DESKTOP main card ===== --}}
        <div class="desktop-only-ip">
            <div class="card col-lg-12 main_card">
                <div class="">
                    <div class="row">
                        <div class="card_div col-md-12" style="display: flex; justify-content: space-between; align-items: center;">
                            <strong class="product_report">Order Products</strong>
                            <button type="button" class="view_store_btn add-new-item mr-2"><i class="fa fa-plus mr-1"></i>ADD ITEM</button>
                        </div>
                    </div>

                </div>

                <div style="padding-left: 10px; padding-right: 10px;overflow-x: scroll;" class="mb-3">
                    <table class="table align-items-center" id="product_report_table">
                        <thead style="background-color: #717070;">
                            <th scope="col" class="table_header_text text-left">PRODUCT</th>
                            <th scope="col" class="table_header_text text-center">QTY</th>
                            <th scope="col" class="table_header_text text-right">UNIT PRICE ($)</th>
                            <th scope="col" class="table_header_text text-right">TOTAL ($)</th>
                            <th scope="col" class="table_header_text text-center">STATUS</th>
                            <th scope="col" class="table_header_text text-center">ACTION</th>
                        </thead>
                        <tbody>
                            @foreach ($order->OrderItems as $orderItem)
                            @foreach ($orderItem->OrderItemDetails as $itemDetail)
                            <tr class="{{ request()->has('item_detail_id') && request()->item_detail_id == $itemDetail->id ? 'blinking-tr' : '' }}" style="border-bottom: 1px solid #DEDEDE;" data-item-id="{{ $itemDetail->id }}">
                                <td scope="col" class="table_body">
                                    <div style="display: table; width: auto; height: 100%;">
                                        <div style="display: table-cell; vertical-align: middle; padding-right: 1rem;">
                                            <img
                                                src="{{$orderItem->ProductDetails->images->first() ? asset($orderItem->ProductDetails->images->first()->url) : asset('public/images/default.png')}}"
                                                alt="Product Image"
                                                class="item-product-image"
                                                style="width: 5rem; height: auto;">
                                        </div>
                                        <div style="display: table-cell; vertical-align: middle;">
                                            <div style="font-weight: bold; font-size: 1rem; margin-bottom: 0.2rem;">
                                                <select name="players[{{$itemDetail->id}}][product_id]" class="order-item-product" style="border: none;">
                                                    @foreach ($storeProducts as $product)
                                                    <option value="{{$product->id}}" @if ($orderItem->ProductDetails->id == $product->id) selected @endif data-image-url="{{$product->images->first() ? asset($product->images->first()->url) : asset('public/images/default.png')}}" data-product-price="{{$product->default_price}}" data-is-name-available="{{$product->set_individual_name}}" data-is-number-available="{{$product->set_individual_number}}" data-weight="{{$product->shipping_weight}}" data-size-type-id="{{$product->size_type_id}}">{{$product->product_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div style="font-size: 0.8rem; color: gray;" class="mb-1">
                                                Size :
                                                <select name="players[{{$itemDetail->id}}][size]" style="height: 1rem;border: none;">
                                                    @foreach ($orderItem->ProductDetails->sizes as $addedSize)
                                                    <option value="{{$addedSize->size->id}}" @if ($itemDetail->size == $addedSize->size->id) selected @endif>{{$addedSize->size->size_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if ($orderItem->ProductDetails->set_individual_name == 1)
                                            <div style="font-size: 0.8rem; color: gray;" class="is-name-available mb-1">
                                                Name : <input type="text" name="players[{{$itemDetail->id}}][name]" value="{{$itemDetail->player_name}}" style="height: 1rem;border: 1px solid #c9c9c9;padding: .7rem .1rem;">
                                            </div>
                                            @endif
                                            @if ($orderItem->ProductDetails->set_individual_number == 1)
                                            <div style="font-size: 0.8rem; color: gray;" class="is-number-available mb-1">
                                                Number : <input type="number" step="1" min="0" name="players[{{$itemDetail->id}}][number]" value="{{$itemDetail->player_number}}" style="height: 1rem;border: 1px solid #c9c9c9;padding: .7rem .1rem;">
                                            </div>
                                            @endif
                                            @if($is_sub_team_added && count($subTeamArray) > 0)
                                            <div style="font-size: 0.8rem; color: gray;" class="mb-1">
                                                Sub Team :
                                                <select name="players[{{$itemDetail->id}}][sub_team]" style="height: 1rem;border: none;">
                                                    <option value="">Not Selected</option>
                                                    @foreach ($subTeamArray as $subTeam)
                                                    <option value="{{ $subTeam }}" {{ $itemDetail->sub_team == $subTeam ? 'selected' : '' }}> {{ $subTeam }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td scope="col" class="table_body text-center"><input type="number" class="form-control text-center item-quantity" name="players[{{$itemDetail->id}}][qty]" value="{{$itemDetail->qty}}" style="height: 1.5rem;"></td>
                                <td scope="col" class="table_body text-right">
                                    <input type="number" name="players[{{$itemDetail->id}}][unit_price]" class="text-right form-control unit-price" value="{{$itemDetail->unit_price}}" style="height: 1.5rem;" @cannot('update store order unit price') disabled @endcannot>
                                    <input type="hidden" class="product-weight" value="{{$orderItem->ProductDetails->shipping_weight}}" readonly>
                                </td>
                                <td scope="col" class="table_body text-right"><input type="number" name="players[{{$itemDetail->id}}][total]" class="text-right form-control item-total" value="{{$itemDetail->total_amount}}" readonly style="height: 1.5rem;"></td>
                                <td scope="col" class="table_body text-center">
                                    @if ($itemDetail->item_status !== 1)
                                    <input type="hidden" name="players[{{$itemDetail->id}}][status]" value="{{$itemDetail->item_status}}">
                                    @endif
                                    <select class="status-change" name="players[{{$itemDetail->id}}][status]" style="border: none;background-color: #e1e1e1;color:black;padding: .3rem;border-radius: .5rem;" {{ $itemDetail->item_status !== 1 ? 'disabled' : '' }}>
                                        @foreach ($store_order_statuses as $store_order_status)
                                        <option value="{{$store_order_status->id}}" @if ($itemDetail->item_status == $store_order_status->id) selected @endif data-color="{{$store_order_status->color}}">{{$store_order_status->status_name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="text-center table_body">
                                    <i class="fa fa-trash remove-item" style="cursor: pointer;"></i>
                                    <i class="fa fa-clone duplicate-product" style="margin-left: 10px;cursor: pointer;"></i>
                                </td>
                            </tr>
                            @endforeach
                            @endforeach
                            @if (!empty($order->coupon_code) && !empty($order->couponDetails))

                            <tr style="border-bottom: 1px solid #DEDEDE;">
                                <td scope="col" colspan="7" class="table_body text-left" style="font-size: large;">
                                    You have applied coupon code "<strong>{{ $order->coupon_code }}</strong>" with
                                    @if($order->couponDetails->type == 'free_shipping')
                                    Free Shipping.
                                    @elseif($order->couponDetails->type == 'flat_from_sub')
                                    ${{ number_format($order->couponDetails->amount, 2) }} Off from Sub Total.
                                    @elseif($order->couponDetails->type == 'percentage_from_sub')
                                    {{ rtrim(rtrim(number_format($order->couponDetails->amount, 2), '0'), '.') }}% Off from Sub Total.
                                    @elseif($order->couponDetails->type == 'flat_from_grand')
                                    ${{ number_format($order->couponDetails->amount, 2) }} Off from Grand Total.
                                    @elseif($order->couponDetails->type == 'percentage_from_grand')
                                    {{ rtrim(rtrim(number_format($order->couponDetails->amount, 2), '0'), '.') }}% Off from Grand Total.
                                    @else
                                    Discount Applied
                                    @endif
                                </td>
                            </tr>
                            @endif
                            <tr style="border-bottom: 1px solid #DEDEDE;">
                                <td scope="col" colspan="4" class="table_body">Sub Total ($)</td>
                                <td scope="col" colspan="2" class="table_body text-right"><input type="number" name="order[sub_total]" id="order_sub_total" class="text-right form-control" value="{{$order->sub_total}}" readonly style="height: 1.5rem;"></td>
                            </tr>
                            <tr style="border-bottom: 1px solid #DEDEDE;">
                                <td scope="col" colspan="4" class="table_body">Handling Fee ($)</td>
                                <td scope="col" colspan="2" class="table_body text-right"><input type="number" name="order[handling_fee]" id="order_handling_fee" class="text-right form-control" value="{{$order->handling_fee}}" readonly style="height: 1.5rem;"></td>
                            </tr>
                            <tr style="border-bottom: 1px solid #DEDEDE;">
                                <td scope="col" colspan="4" class="table_body">Sales Tax {{$store->sales_tax ?? 0}}% ($)</td>
                                <td scope="col" colspan="2" class="table_body text-right">
                                    <input type="hidden" id="order_sales_tax_rate" value="{{$store->sales_tax}}">
                                    <input type="number" name="order[sales_tax]" id="order_sales_tax" class="text-right form-control" value="{{$order->sales_tax}}" readonly style="height: 1.5rem;">
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid #DEDEDE;">
                                <td scope="col" colspan="4" class="table_body">Shipping ($)</td>
                                <td scope="col" colspan="2" class="table_body text-right">
                                    <div class="d-flex justify-content-end align-items-center">
                                        <input type="number" name="order[shipping]" id="order_shipping" class="text-right form-control" value="{{ $order->shipping }}" readonly style="height: 1.5rem; width: auto;">
                                        <button type="button" class="btn btn-sm btn-danger ml-2" id="remove_shipping" title="Remove Shipping" style="padding: 0.1rem 0.5rem; font-size: 0.8rem;{{ $order->is_shipping_removed == 0 ? '' : 'display:none'}}">×</button>
                                        <button type="button" class="btn btn-sm btn-success ml-2" id="add_shipping" title="Add Shipping" style="padding: 0.1rem 0.5rem; font-size: 0.8rem;{{ $order->is_shipping_removed == 1 ? '' : 'display:none'}}">+</button>
                                    </div>
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid #DEDEDE;">
                                <td scope="col" colspan="4" class="table_body" style="font-size: 1rem;font-weight: 600;color:black">Grand Total ($)</td>
                                <td scope="col" colspan="2" class="table_body text-right"><input type="number" name="order[grand_total]" id="order_grand_total" class="text-right form-control" value="{{$order->total}}" readonly style="font-size: 1rem;font-weight: 600;color:black;height: 2.5rem;"></td>
                            </tr>

                            @php
                            $totalPaid = ($order->paymentDetails->count() > 0) ? $order->paymentDetails->where('is_success', 1)->where('is_refund', 0)->sum('payment_amount') : 0.00;
                            $totalProcessingFee = ($order->paymentDetails->count() > 0) ? $order->paymentDetails->where('is_success', 1)->sum('processing_fee') : 0.00;
                            $totalRefund = ($order->paymentDetails->count() > 0) ? $order->paymentDetails->where('is_success', 1)->where('is_refund', 1)->sum('payment_amount') : 0.00;

                            $totalPaidAmount = $totalPaid - $totalRefund;

                            $bgColor = '#f8d7da';
                            $textColor = '#721c24';
                            $paymentText = 'Pending';

                            if (bccomp($totalPaidAmount, $order->total, 2) === 0) {
                            // Equal
                            $bgColor = '#d4edda';
                            $textColor = '#155724';
                            $paymentText = 'Paid';
                            } elseif (bccomp($totalPaidAmount, $order->total, 2) === 1) {
                            // Over Paid
                            $bgColor = '#d4edda';
                            $textColor = '#155724';
                            $paymentText = 'Over Paid';
                            } elseif ($totalPaidAmount > 0) {
                            // Partial
                            $bgColor = '#fff3cd';
                            $textColor = '#856404';
                            $paymentText = 'Partial';
                            }
                            @endphp

                            <!-- Payment Status -->
                            <tr>
                                <td colspan="4" class="table_body">Payment Status</td>
                                <td colspan="2" class="table_body text-right">
                                    <span id="payment-status-span"
                                        style="padding: .5rem 2rem; font-size: .9rem; border-radius:1rem;
                                        background-color: {{ $bgColor }};
                                        color: {{ $textColor }};">
                                        {{ $paymentText }}
                                    </span>
                                </td>
                            </tr>

                            <!-- Paid Amounts -->
                            <tr>
                                <td colspan="4" class="table_body">Paid Invoice Amount ($)</td>
                                <td colspan="2" class="table_body text-right"><input type="number" id="order_paid_amount" class="form-control text-right" value="{{ $order->paid_invoice_amount }}" readonly></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="table_body">Paid Processing Fee ($)</td>
                                <td colspan="2" class="table_body text-right"><input type="number" id="order_paid_processing_fee" class="form-control text-right" value="{{ $order->paid_processing_fee }}" readonly></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="table_body">Total Paid Amount ($)</td>
                                <td colspan="2" class="table_body text-right"><input type="number" id="order_total_paid_amount" class="form-control text-right" value="{{ $order->paid_amount }}" readonly></td>
                            </tr>

                            <!-- Amount to Pay -->
                            <tr id="amount-to-pay-row" style="border-bottom: 1px solid #DEDEDE; {{ round($order->total - $totalPaidAmount, 2) <= 0 ? 'display: none;' : '' }}">
                                <td colspan="4" class="table_body font-weight-bold">Amount to Pay ($)</td>
                                <td colspan="2" class="table_body text-right">
                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                        <button type="button" class="btn btn-sm btn-success get-payments-btn"
                                            data-order-id="{{ $order->id }}"
                                            data-amount="{{ round($order->total - $totalPaidAmount, 2)}}">
                                            <i class="fa fa-credit-card"></i> Get Payments
                                        </button>
                                        <input type="text" id="order_amount_to_pay" class="form-control text-right" readonly
                                            value="{{ number_format(round($order->total - $totalPaidAmount, 2), 2)}}" style="width: 8rem;">
                                    </div>
                                </td>
                            </tr>

                            @if ($order->paymentDetails->count() > 0)
                            <!-- Excess Payment -->
                            <tr id="excess-payment-row" style="border-bottom: 1px solid #DEDEDE; {{ (round($totalPaidAmount - $order->total, 2) <= 0) ? 'display: none;' : '' }}">
                                <td colspan="4" class="table_body font-weight-bold">Excess Payment ($)</td>
                                <td colspan="2" class="table_body text-right">
                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                        <button type="button" id="refund-btn" class="btn btn-sm btn-success refund-btn" @cannot('TS refund') disabled @endcannot
                                            data-order-id="{{ $order->id }}"
                                            data-payment-record="{{ $order->paymentDetails->where('is_success', 1)->first()->id}}"
                                            data-transaction-id="{{ $order->paymentDetails->where('is_success', 1)->first()->transaction_id }}"
                                            data-amount="{{ round(($totalPaidAmount - $order->total), 2) }}">
                                            <i class="fa fa-undo"></i> Refund
                                        </button>
                                        <input type="text" min="0" max="{{ $order->paymentDetails->where('is_success', 1)->first()->payment_amount}}" id="exess_amount" class="form-control text-right" @cannot('update store order unit price') readonly @endcannot
                                            value="{{ round(($totalPaidAmount - $order->total), 2)}}" style="width: 8rem;">
                                    </div>
                                </td>
                            </tr>
                            @endif

                        </tbody>
                    </table>
                </div>

                <hr style="margin: unset; margin-bottom: 10px;">

                @can('update_store_order_shipping_method')
                @if($shippingMethods->count() > 0)
                <div class="mb-2" style="padding-left: 5px; padding-right: 10px;">
                    <div class="card" style="border-radius: 0rem;">
                        <div class="col-md-12" style="padding: .5rem 1rem; background-color: #dddddd;">
                            Shipping Method
                        </div>

                        <div class="col-md-12" style="padding: 1rem;">
                            <select name="shipping_method" id="shipping_method" class="form-control" style="width: auto; border: 1px solid rgba(239, 239, 239, 0.3);">
                                @foreach ($shippingMethods as $shippingMethod)
                                <option value="{{ $shippingMethod->id }}" {{ $order->shipping_method == $shippingMethod->id ? 'selected' : '' }}>
                                    {{ $shippingMethod->shipping_method_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <hr style="margin: unset; margin-bottom: 10px;">
                @endif
                @endcan



                <div style="padding-left: 5px; padding-right: 10px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card" style="border-radius: 0rem;">
                                <div class="col-md-12" style="padding: .5rem 1rem;background-color: #dddddd;">
                                    Billing Information
                                </div>
                                <div class="col-md-12" style="padding: 1rem;">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td style="width: 20%;">Email Address</td>
                                            <td><input type="text" class="form-control" style="width: 100%; border: 1px solid rgba(239, 239, 239, 0.3);" value="{{$order->CustomerDetails->email}}" disabled></td>
                                        </tr>
                                        <tr>
                                            <td>Phone</td>
                                            <td><input type="text" class="form-control" style="width: 100%; border: 1px solid rgba(239, 239, 239, 0.3);" value="{{$order->CustomerDetails->phone_number}}" disabled></td>
                                        </tr>
                                        <tr>
                                            <td>First Name</td>
                                            <td><input type="text" class="form-control" style="width: 100%; border: 1px solid rgba(239, 239, 239, 0.3);" value="{{$order->CustomerDetails->first_name}}" disabled></td>
                                        </tr>
                                        <tr>
                                            <td>Last Name</td>
                                            <td><input type="text" class="form-control" style="width: 100%; border: 1px solid rgba(239, 239, 239, 0.3);" value="{{$order->CustomerDetails->last_name}}" disabled></td>
                                        </tr>
                                        <tr>
                                            <td>Street</td>
                                            <td><input type="text" class="form-control" style="width: 100%; border: 1px solid rgba(239, 239, 239, 0.3);" value="{{$order->CustomerDetails->street}}" disabled></td>
                                        </tr>
                                        <tr>
                                            <td>City</td>
                                            <td><input type="text" class="form-control" style="width: 100%; border: 1px solid rgba(239, 239, 239, 0.3);" value="{{$order->CustomerDetails->city}}" disabled></td>
                                        </tr>
                                        <tr>
                                            <td>State</td>
                                            <td><input type="text" class="form-control" style="width: 100%; border: 1px solid rgba(239, 239, 239, 0.3);" value="{{$order->CustomerDetails->state}}" disabled></td>
                                        </tr>
                                        <tr>
                                            <td>Postal Code</td>
                                            <td><input type="text" class="form-control" style="width: 100%; border: 1px solid rgba(239, 239, 239, 0.3);" value="{{$order->CustomerDetails->postal_code}}" disabled></td>
                                        </tr>
                                        <tr>
                                            <td>Country</td>
                                            <td><input type="text" class="form-control" style="width: 100%; border: 1px solid rgba(239, 239, 239, 0.3);" value="{{$order->CustomerDetails->country}}" disabled></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card" style="border-radius: 0rem;">
                                <div class="col-md-12" style="padding: .5rem 1rem;background-color: #dddddd;">
                                    Shipping Information
                                </div>
                                <div class="col-md-12" style="padding: 1rem;">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td style="width: 20%;">Email Address</td>
                                            <td><input type="text" name="email" style="width: 100%" class="form-control" value="{{$order->email}}"></td>
                                        </tr>
                                        <tr>
                                            <td>Phone</td>
                                            <td><input type="text" name="phone" style="width: 100%" class="form-control" value="{{$order->phone}}"></td>
                                        </tr>
                                        <tr>
                                            <td>First Name</td>
                                            <td><input type="text" name="first_name" style="width: 100%" class="form-control" value="{{$order->first_name}}"></td>
                                        </tr>
                                        <tr>
                                            <td>Last Name</td>
                                            <td><input type="text" name="last_name" style="width: 100%" class="form-control" value="{{$order->last_name}}"></td>
                                        </tr>
                                        <tr>
                                            <td>Street</td>
                                            <td><input type="text" name="street" style="width: 100%" class="form-control" value="{{$order->street}}"></td>
                                        </tr>
                                        <tr>
                                            <td>City</td>
                                            <td><input type="text" name="city" style="width: 100%" class="form-control" value="{{$order->city}}"></td>
                                        </tr>
                                        <tr>
                                            <td>State</td>
                                            <td><input type="text" name="state" style="width: 100%" class="form-control" value="{{$order->state}}"></td>
                                        </tr>
                                        <tr>
                                            <td>Postal Code</td>
                                            <td><input type="text" name="postal_code" style="width: 100%" class="form-control" value="{{$order->postal_code}}"></td>
                                        </tr>
                                        <tr>
                                            <td>Country</td>
                                            <td><input type="text" name="country" style="width: 100%" class="form-control" value="{{$order->country}}"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="card" style="border-radius: 0rem;">
                                <div class="col-md-12" style="padding: .5rem 1rem;background-color: #dddddd;">
                                    Tracking Information
                                </div>
                                <div class="col-md-12" style="padding: 1rem;">
                                    <table style="width: 100%">
                                        <tr>
                                            <td style="width: 8%">Traking Link</td>
                                            <td style="width: 40%"><input type="text" name="tracking_link" style="width: 100%" class="form-control" value="{{isset($order->ShipmentDetails) ? $order->ShipmentDetails->tracking_url : ''}}"></td>
                                            <td style="width: 2%"></td>
                                            <td style="width: 8%">Tracking #</td>
                                            <td><input type="text" name="tracking_no" style="width: 100%" class="form-control" value="{{isset($order->ShipmentDetails) ? $order->ShipmentDetails->tracking_number : ''}}"></td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="card" style="border-radius: 0rem;">
                                <div class="col-md-12" style="padding: .5rem 1rem;background-color: #dddddd;">
                                    Notes
                                </div>
                                <div class="col-md-12" style="padding: 1rem;">
                                    <textarea name="note" id="player_note" class="form-control" style="width: 100%">
                                    {{$order->notes}}
                                    </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="card" style="border-radius: 0rem;">
                                <div class="col-md-12" style="padding: .5rem 1rem;background-color: #dddddd;">
                                    Receipts
                                </div>

                                @if (!empty($order->OrderReceipts) && $order->OrderReceipts->count())
                                <div class="col-md-12" style="padding: 1rem;">
                                    @foreach ($order->OrderReceipts as $item)
                                    <div class="receipt-item d-flex align-items-center mb-2">
                                        <div class="receipt-info d-flex align-items-center">
                                            @if ($item->is_sent == 1)
                                            <i class="fa fa-check-circle text-success mr-2" style="cursor: pointer" title="Mail send"></i>
                                            @else
                                            <i class="fa fa-times-circle text-danger mr-2" style="cursor: pointer" title="Mail not send"></i>
                                            @endif
                                            @php
                                            $pstTime = \Carbon\Carbon::parse($item->created_at)
                                            ->timezone('America/Los_Angeles');
                                            @endphp

                                            <span>
                                                {{ $pstTime->format('F jS, Y (g:i A)') }} PST
                                            </span>
                                        </div>
                                        <div class="ml-2">
                                            <button type="button" class="btn btn-info btn-sm download-receipt-btn"
                                                data-receipt-no="{{ $item->id }}">
                                                Download
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <div class="col-md-12" style="padding: 1rem;">
                                    No available
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="card" style="border-radius: 0rem;">
                                <div class="col-md-12" style="padding: .5rem 1rem;background-color: #dddddd;">
                                    Payments
                                </div>

                                @if (!empty($order->paymentDetails) && $order->paymentDetails->count() > 0)
                                <div class="col-md-12" style="padding: 1rem; overflow-x:auto;">
                                    <table class="table table-bordered" style="font-size: 12px; min-width: 900px;">
                                        <thead style="background:#f2f2f2;">
                                            <tr>
                                                <th>Date</th>
                                                <th>Transaction ID</th>
                                                <th>Card Owner</th>
                                                <th>Payment Amount ($)</th>
                                                <th>Processing Fee ($)</th>
                                                <th>Total Amount ($)</th>
                                                <th>Payment/Refund</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->paymentDetails as $item)
                                            <tr>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($item->created_at)
                                                        ->timezone('America/Los_Angeles')
                                                        ->format('F jS, Y (g:i A)') }} PST
                                                </td>

                                                <td>{{ $item->transaction_id ?? '-' }}</td>

                                                <td>{{ $item->card_owner ?? '-' }}</td>

                                                <td>${{ number_format($item->payment_amount, 2) }}</td>

                                                <td>${{ number_format($item->processing_fee, 2) }}</td>

                                                <td>${{ number_format($item->total_amount, 2) }}</td>

                                                <td>
                                                    @if ($item->is_refund)
                                                    <span style="color: green; font-weight: 600;">REFUND</span>
                                                    @else
                                                    <span style="color: green; font-weight: 600;">PAYMENT</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->is_success)
                                                    <span style="color: green; font-weight: 600;">SUCCESS</span>
                                                    @else
                                                    <span style="color: red; font-weight: 600;">FAILD</span>
                                                    @endif
                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <div class="col-md-12" style="padding: 1rem;">
                                    No available
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 mt-3 text-right">
                            <button class="btn btn-primaty save-order-details" type="button" style="background-color: #39a0b1;color:white">SAVE</button>
                        </div>
                    </div>
                </div>
            </div>{{-- end desktop-only-ip main card --}}
        </div>{{-- end desktop-only-ip --}}

        {{-- ====================================================================
         MOBILE LAYOUT
    ===================================================================== --}}
        <div class="mobile-only-ip" style="padding-top: 6px;">

            {{-- Top bar: order no + status + actions --}}
            <div class="ip-topbar">
                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <span class="ip-topbar-order">Order #{{ $order->order_no }}</span>
                    <select class="status-change" style="border:none; background-color:#e1e1e1; color:black; padding:.3rem; border-radius:.5rem; font-size:12px;" disabled>
                        @foreach ($store_order_statuses as $store_order_status)
                        <option value="{{ $store_order_status->id }}" @if ($order->order_status == $store_order_status->id) selected @endif data-color="{{ $store_order_status->color }}">{{ $store_order_status->status_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="ip-topbar-btns">
                    @if (empty($order->ShipmentDetails))
                    <a href="{{ route('usps.create_shipment', ['order_no' => $order->order_no]) }}" class="create-shipment ip-topbar-btn" style="text-decoration:none;">
                        <i class="fa fa-truck"></i> Shipment
                    </a>
                    @endif
                    <button type="button" class="ip-topbar-btn" id="compose_email_button_mobile">
                        <i class="fa fa-envelope"></i> Email
                    </button>
                    <button type="button" class="ip-topbar-btn primary save-order-details">
                        <i class="fa fa-save"></i> Save
                    </button>
                </div>
            </div>

            {{-- ===== Order Products ===== --}}
            <div class="ip-section">
                <div class="ip-section-header" onclick="toggleIpSection(this)">
                    <span class="ip-section-title"><i class="fa fa-shopping-bag mr-2" style="color:#47D6B6;"></i>Order Products</span>
                    <i class="fa fa-chevron-down ip-chevron open"></i>
                </div>
                <div class="ip-section-body">
                    <button type="button" class="add-new-item" style="width:100%;height:38px;border-radius:8px;border:1px dashed #47D6B6;background:transparent;color:#47D6B6;font-size:12px;font-weight:700;margin-bottom:12px;">
                        <i class="fa fa-plus mr-1"></i>ADD ITEM
                    </button>

                    @foreach ($order->OrderItems as $orderItem)
                    @foreach ($orderItem->OrderItemDetails as $itemDetail)
                    @php
                    $imgSrc = $orderItem->ProductDetails->images->first()
                    ? asset($orderItem->ProductDetails->images->first()->url)
                    : asset('public/images/default.png');
                    $statusOpts = $store_order_statuses;
                    @endphp
                    <div class="ip-product-card" data-item-id="{{ $itemDetail->id }}">
                        <div class="ip-product-header">
                            <img src="{{ $imgSrc }}" class="ip-product-img item-product-image" alt="Product">
                            <div style="flex:1; min-width:0;">
                                <div class="ip-product-name">
                                    <select name="players[{{ $itemDetail->id }}][product_id]" class="order-item-product" style="border:none;font-size:13px;font-weight:700;color:#333;width:100%;">
                                        @foreach ($storeProducts as $product)
                                        <option value="{{ $product->id }}"
                                            @if ($orderItem->ProductDetails->id == $product->id) selected @endif
                                            data-image-url="{{ $product->images->first() ? asset($product->images->first()->url) : asset('public/images/default.png') }}"
                                            data-product-price="{{ $product->default_price }}"
                                            data-is-name-available="{{ $product->set_individual_name }}"
                                            data-is-number-available="{{ $product->set_individual_number }}"
                                            data-weight="{{ $product->shipping_weight }}"
                                            data-size-type-id="{{ $product->size_type_id }}">{{ $product->product_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="ip-product-sub">
                                    Size:
                                    <select name="players[{{ $itemDetail->id }}][size]" style="border:none;font-size:11px;color:#9ca3af;background:transparent;">
                                        @foreach ($orderItem->ProductDetails->sizes as $addedSize)
                                        <option value="{{ $addedSize->size->id }}" @if ($itemDetail->size == $addedSize->size->id) selected @endif>{{ $addedSize->size->size_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="ip-product-grid">
                            @if ($orderItem->ProductDetails->set_individual_name == 1)
                            <div class="is-name-available">
                                <div class="ip-product-field-label">Player Name</div>
                                <input type="text" name="players[{{ $itemDetail->id }}][name]" value="{{ $itemDetail->player_name }}" class="ip-field-input" style="padding:6px 8px;font-size:12px;">
                            </div>
                            @else
                            <div class="is-name-available" style="display:none;">
                                <div class="ip-product-field-label">Player Name</div>
                                <input type="text" name="players[{{ $itemDetail->id }}][name]" value="{{ $itemDetail->player_name }}" class="ip-field-input" style="padding:6px 8px;font-size:12px;">
                            </div>
                            @endif
                            @if ($orderItem->ProductDetails->set_individual_number == 1)
                            <div class="is-number-available">
                                <div class="ip-product-field-label">Player Number</div>
                                <input type="number" step="1" min="0" name="players[{{ $itemDetail->id }}][number]" value="{{ $itemDetail->player_number }}" class="ip-field-input" style="padding:6px 8px;font-size:12px;">
                            </div>
                            @else
                            <div class="is-number-available" style="display:none;">
                                <div class="ip-product-field-label">Player Number</div>
                                <input type="number" step="1" min="0" name="players[{{ $itemDetail->id }}][number]" value="{{ $itemDetail->player_number }}" class="ip-field-input" style="padding:6px 8px;font-size:12px;">
                            </div>
                            @endif
                            <div>
                                <div class="ip-product-field-label">Qty</div>
                                <input type="number" class="item-quantity ip-field-input" name="players[{{ $itemDetail->id }}][qty]" value="{{ $itemDetail->qty }}" style="padding:6px 8px;font-size:12px;">
                            </div>
                            <div>
                                <div class="ip-product-field-label">Unit Price ($)</div>
                                <input type="number" name="players[{{ $itemDetail->id }}][unit_price]" class="unit-price ip-field-input" value="{{ $itemDetail->unit_price }}" style="padding:6px 8px;font-size:12px;" @cannot('update store order unit price') disabled @endcannot>
                                <input type="hidden" class="product-weight" value="{{ $orderItem->ProductDetails->shipping_weight }}" readonly>
                            </div>
                            <div>
                                <div class="ip-product-field-label">Total ($)</div>
                                <input type="number" name="players[{{ $itemDetail->id }}][total]" class="item-total ip-field-input" value="{{ $itemDetail->total_amount }}" readonly style="padding:6px 8px;font-size:12px;background:#f5f5f5;">
                            </div>
                            <div>
                                <div class="ip-product-field-label">Status</div>
                                @if ($itemDetail->item_status !== 1)
                                <input type="hidden" name="players[{{ $itemDetail->id }}][status]" value="{{ $itemDetail->item_status }}">
                                @endif
                                <select class="status-change" name="players[{{ $itemDetail->id }}][status]" style="border:none;background-color:#e1e1e1;color:black;padding:.3rem;border-radius:.5rem;font-size:11px;" {{ $itemDetail->item_status !== 1 ? 'disabled' : '' }}>
                                    @foreach ($store_order_statuses as $store_order_status)
                                    <option value="{{ $store_order_status->id }}" @if ($itemDetail->item_status == $store_order_status->id) selected @endif data-color="{{ $store_order_status->color }}">{{ $store_order_status->status_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div style="display:flex;gap:16px;margin-top:10px;padding-top:10px;border-top:1px dashed #f0f0f0;">
                            <button type="button" class="remove-item" style="background:none;border:none;color:#ef4444;font-size:12px;font-weight:600;cursor:pointer;"><i class="fa fa-trash mr-1"></i>Remove</button>
                            <button type="button" class="duplicate-product" style="background:none;border:none;color:#3b82f6;font-size:12px;font-weight:600;cursor:pointer;"><i class="fa fa-clone mr-1"></i>Duplicate</button>
                        </div>
                    </div>
                    @endforeach
                    @endforeach
                </div>
            </div>

            {{-- ===== Order Summary ===== --}}
            <div class="ip-section">
                <div class="ip-section-header" onclick="toggleIpSection(this)">
                    <span class="ip-section-title"><i class="fa fa-calculator mr-2" style="color:#47D6B6;"></i>Order Summary</span>
                    <i class="fa fa-chevron-down ip-chevron open"></i>
                </div>
                <div class="ip-section-body">
                    @if (!empty($order->coupon_code) && !empty($order->couponDetails))
                    <div style="background:#fff3cd;border-radius:8px;padding:10px 12px;margin-bottom:10px;font-size:12px;color:#856404;">
                        Coupon <strong>{{ $order->coupon_code }}</strong> applied —
                        @if($order->couponDetails->type == 'free_shipping') Free Shipping
                        @elseif($order->couponDetails->type == 'flat_from_sub') ${{ number_format($order->couponDetails->amount, 2) }} off subtotal
                        @elseif($order->couponDetails->type == 'percentage_from_sub') {{ rtrim(rtrim(number_format($order->couponDetails->amount,2),'0'),'.') }}% off subtotal
                        @elseif($order->couponDetails->type == 'flat_from_grand') ${{ number_format($order->couponDetails->amount, 2) }} off grand total
                        @elseif($order->couponDetails->type == 'percentage_from_grand') {{ rtrim(rtrim(number_format($order->couponDetails->amount,2),'0'),'.') }}% off grand total
                        @endif
                    </div>
                    @endif
                    <div class="ip-total-row"><span class="ip-total-label">Sub Total</span><span class="ip-total-val">${{ number_format($order->sub_total, 2) }}</span></div>
                    <div class="ip-total-row"><span class="ip-total-label">Handling Fee</span><span class="ip-total-val">${{ number_format($order->handling_fee, 2) }}</span></div>
                    <div class="ip-total-row"><span class="ip-total-label">Sales Tax {{ $store->sales_tax ?? 0 }}%</span><span class="ip-total-val">${{ number_format($order->sales_tax, 2) }}</span></div>
                    <div class="ip-total-row"><span class="ip-total-label">Shipping</span><span class="ip-total-val">${{ number_format($order->shipping, 2) }}</span></div>
                    <div class="ip-total-row"><span class="ip-total-label" style="font-weight:700;color:#333;">Grand Total</span><span class="ip-total-val grand">${{ number_format($order->total, 2) }}</span></div>
                    <div class="ip-total-row" style="align-items:center;">
                        <span class="ip-total-label">Payment Status</span>
                        <span class="ip-pay-badge" id="mobile-payment-status-span"
                            style="background-color:{{ $bgColor }};color:{{ $textColor }};">{{ $paymentText }}</span>
                    </div>
                    <div class="ip-total-row"><span class="ip-total-label">Paid Invoice</span><span class="ip-total-val">${{ number_format($order->paid_invoice_amount, 2) }}</span></div>
                    <div class="ip-total-row"><span class="ip-total-label">Processing Fee</span><span class="ip-total-val">${{ number_format($order->paid_processing_fee, 2) }}</span></div>
                    <div class="ip-total-row"><span class="ip-total-label">Total Paid</span><span class="ip-total-val">${{ number_format($order->paid_amount, 2) }}</span></div>

                    {{-- Amount to Pay (mobile) --}}
                    <div class="ip-total-row" id="mobile-amount-to-pay-row" style="align-items:center; {{ round($order->total - $totalPaidAmount, 2) <= 0 ? 'display:none;' : '' }}">
                        <span class="ip-total-label" style="font-weight:700;color:#333;">Amount to Pay</span>
                        <div style="display:flex;align-items:center;gap:6px;">
                            <button type="button" class="btn btn-sm btn-success get-payments-btn"
                                data-order-id="{{ $order->id }}"
                                data-amount="{{ round($order->total - $totalPaidAmount, 2) }}"
                                style="font-size:11px;padding:4px 8px;">
                                <i class="fa fa-credit-card"></i> Get Payments
                            </button>
                            <span class="ip-total-val" id="mobile-order-amount-to-pay">${{ number_format(round($order->total - $totalPaidAmount, 2), 2) }}</span>
                        </div>
                    </div>

                    @if ($order->paymentDetails->count() > 0)
                    {{-- Excess Payment / Refund (mobile) --}}
                    <div class="ip-total-row" id="mobile-excess-payment-row" style="align-items:center; {{ (round($totalPaidAmount - $order->total, 2) <= 0) ? 'display:none;' : '' }}">
                        <span class="ip-total-label" style="font-weight:700;color:#333;">Excess Payment</span>
                        <div style="display:flex;align-items:center;gap:6px;">
                            <button type="button" id="refund-btn-mobile" class="btn btn-sm btn-success refund-btn" @cannot('TS refund') disabled @endcannot
                                data-order-id="{{ $order->id }}"
                                data-payment-record="{{ $order->paymentDetails->where('is_success', 1)->first()->id }}"
                                data-transaction-id="{{ $order->paymentDetails->where('is_success', 1)->first()->transaction_id }}"
                                data-amount="{{ round(($totalPaidAmount - $order->total), 2) }}"
                                style="font-size:11px;padding:4px 8px;">
                                <i class="fa fa-undo"></i> Refund
                            </button>
                            <input type="text" min="0" max="{{ $order->paymentDetails->where('is_success', 1)->first()->payment_amount }}"
                                id="exess_amount_mobile" class="form-control text-right" @cannot('update store order unit price') readonly @endcannot
                                value="{{ round(($totalPaidAmount - $order->total), 2) }}"
                                style="width:5.5rem;height:1.8rem;font-size:11px;padding:2px 6px;">
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- ===== Customer Information ===== --}}
            <div class="ip-section">
                <div class="ip-section-header" onclick="toggleIpSection(this)">
                    <span class="ip-section-title"><i class="fa fa-user mr-2" style="color:#47D6B6;"></i>Customer Information</span>
                    <i class="fa fa-chevron-down ip-chevron"></i>
                </div>
                <div class="ip-section-body" style="display:none;">
                    <div style="font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;margin-bottom:8px;">Billing</div>
                    @foreach([
                    ['Email', $order->CustomerDetails->email ?? ''],
                    ['Phone', $order->CustomerDetails->phone_number ?? ''],
                    ['First Name', $order->CustomerDetails->first_name ?? ''],
                    ['Last Name', $order->CustomerDetails->last_name ?? ''],
                    ['Street', $order->CustomerDetails->street ?? ''],
                    ['City', $order->CustomerDetails->city ?? ''],
                    ['State', $order->CustomerDetails->state ?? ''],
                    ['Postal Code', $order->CustomerDetails->postal_code ?? ''],
                    ['Country', $order->CustomerDetails->country ?? ''],
                    ] as $field)
                    <div class="ip-row">
                        <span class="ip-label">{{ $field[0] }}</span>
                        <span class="ip-val">{{ $field[1] ?: '—' }}</span>
                    </div>
                    @endforeach

                    <div style="font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;margin:14px 0 8px;">Shipping</div>
                    <div class="ip-field-wrap">
                        <div class="ip-field-label">Email</div><input type="text" name="email" class="ip-field-input" value="{{ $order->email }}">
                    </div>
                    <div class="ip-field-wrap">
                        <div class="ip-field-label">Phone</div><input type="text" name="phone" class="ip-field-input" value="{{ $order->phone }}">
                    </div>
                    <div class="ip-field-wrap">
                        <div class="ip-field-label">First Name</div><input type="text" name="first_name" class="ip-field-input" value="{{ $order->first_name }}">
                    </div>
                    <div class="ip-field-wrap">
                        <div class="ip-field-label">Last Name</div><input type="text" name="last_name" class="ip-field-input" value="{{ $order->last_name }}">
                    </div>
                    <div class="ip-field-wrap">
                        <div class="ip-field-label">Street</div><input type="text" name="street" class="ip-field-input" value="{{ $order->street }}">
                    </div>
                    <div class="ip-field-wrap">
                        <div class="ip-field-label">City</div><input type="text" name="city" class="ip-field-input" value="{{ $order->city }}">
                    </div>
                    <div class="ip-field-wrap">
                        <div class="ip-field-label">State</div><input type="text" name="state" class="ip-field-input" value="{{ $order->state }}">
                    </div>
                    <div class="ip-field-wrap">
                        <div class="ip-field-label">Postal Code</div><input type="text" name="postal_code" class="ip-field-input" value="{{ $order->postal_code }}">
                    </div>
                    <div class="ip-field-wrap">
                        <div class="ip-field-label">Country</div><input type="text" name="country" class="ip-field-input" value="{{ $order->country }}">
                    </div>
                </div>
            </div>

            {{-- ===== Tracking ===== --}}
            <div class="ip-section">
                <div class="ip-section-header" onclick="toggleIpSection(this)">
                    <span class="ip-section-title"><i class="fa fa-truck mr-2" style="color:#47D6B6;"></i>Tracking</span>
                    <i class="fa fa-chevron-down ip-chevron"></i>
                </div>
                <div class="ip-section-body" style="display:none;">
                    <div class="ip-field-wrap">
                        <div class="ip-field-label">Tracking Link</div><input type="text" name="tracking_link" class="ip-field-input" value="{{ isset($order->ShipmentDetails) ? $order->ShipmentDetails->tracking_url : '' }}">
                    </div>
                    <div class="ip-field-wrap">
                        <div class="ip-field-label">Tracking #</div><input type="text" name="tracking_no" class="ip-field-input" value="{{ isset($order->ShipmentDetails) ? $order->ShipmentDetails->tracking_number : '' }}">
                    </div>
                </div>
            </div>

            {{-- ===== Notes ===== --}}
            <div class="ip-section">
                <div class="ip-section-header" onclick="toggleIpSection(this)">
                    <span class="ip-section-title"><i class="fa fa-sticky-note mr-2" style="color:#47D6B6;"></i>Notes</span>
                    <i class="fa fa-chevron-down ip-chevron"></i>
                </div>
                <div class="ip-section-body" style="display:none;">
                    <textarea name="note" class="ip-field-input" style="min-height:90px;resize:vertical;">{{ $order->notes }}</textarea>
                </div>
            </div>

            {{-- ===== Receipts ===== --}}
            <div class="ip-section">
                <div class="ip-section-header" onclick="toggleIpSection(this)">
                    <span class="ip-section-title"><i class="fa fa-file-text mr-2" style="color:#47D6B6;"></i>Receipts</span>
                    <i class="fa fa-chevron-down ip-chevron"></i>
                </div>
                <div class="ip-section-body" style="display:none;">
                    @if (!empty($order->OrderReceipts) && $order->OrderReceipts->count())
                    @foreach ($order->OrderReceipts as $item)
                    @php $pstTime = \Carbon\Carbon::parse($item->created_at)->timezone('America/Los_Angeles'); @endphp
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f0f0f0;">
                        <div style="display:flex;align-items:center;gap:8px;">
                            @if ($item->is_sent == 1)
                            <i class="fa fa-check-circle text-success" title="Mail sent"></i>
                            @else
                            <i class="fa fa-times-circle text-danger" title="Mail not sent"></i>
                            @endif
                            <span style="font-size:12px;color:#555;">{{ $pstTime->format('M jS, Y g:i A') }} PST</span>
                        </div>
                        <button type="button" class="btn btn-info btn-sm download-receipt-btn" data-receipt-no="{{ $item->id }}">Download</button>
                    </div>
                    @endforeach
                    @else
                    <p style="color:#aaa;font-size:13px;margin:0;">No receipts available.</p>
                    @endif
                </div>
            </div>

            {{-- ===== Payments ===== --}}
            <div class="ip-section">
                <div class="ip-section-header" onclick="toggleIpSection(this)">
                    <span class="ip-section-title"><i class="fa fa-credit-card mr-2" style="color:#47D6B6;"></i>Payments</span>
                    <i class="fa fa-chevron-down ip-chevron open"></i>
                </div>
                <div class="ip-section-body">
                    @if (!empty($order->paymentDetails) && $order->paymentDetails->count() > 0)
                    @foreach ($order->paymentDetails as $item)
                    @php
                    $pstPay = \Carbon\Carbon::parse($item->created_at)->timezone('America/Los_Angeles');
                    @endphp
                    <div class="ip-payment-card">
                        <div class="ip-payment-card-date">{{ $pstPay->format('M jS, Y g:i A') }} PST</div>
                        <div class="ip-payment-card-grid">
                            <div>
                                <div class="ip-payment-card-label">Transaction ID</div>
                                <div class="ip-payment-card-val" style="word-break:break-all;font-size:11px;">{{ $item->transaction_id ?? '—' }}</div>
                            </div>
                            <div>
                                <div class="ip-payment-card-label">Card Owner</div>
                                <div class="ip-payment-card-val">{{ $item->card_owner ?? '—' }}</div>
                            </div>
                            <div>
                                <div class="ip-payment-card-label">Payment Amount</div>
                                <div class="ip-payment-card-val">${{ number_format($item->payment_amount, 2) }}</div>
                            </div>
                            <div>
                                <div class="ip-payment-card-label">Processing Fee</div>
                                <div class="ip-payment-card-val">${{ number_format($item->processing_fee, 2) }}</div>
                            </div>
                            <div>
                                <div class="ip-payment-card-label">Total</div>
                                <div class="ip-payment-card-val">${{ number_format($item->total_amount, 2) }}</div>
                            </div>
                            <div>
                                <div class="ip-payment-card-label">Type / Status</div>
                                <div>
                                    <span style="color:green;font-weight:700;font-size:11px;">{{ $item->is_refund ? 'REFUND' : 'PAYMENT' }}</span>
                                    &nbsp;&bull;&nbsp;
                                    <span style="color:{{ $item->is_success ? 'green' : 'red' }};font-weight:700;font-size:11px;">{{ $item->is_success ? 'SUCCESS' : 'FAILED' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <p style="color:#aaa;font-size:13px;margin:0;">No payments recorded.</p>
                    @endif
                </div>
            </div>

            {{-- Bottom Save button --}}
            <button type="button" class="ip-save-btn save-order-details">
                <i class="fa fa-save"></i> Save Changes
            </button>

        </div>{{-- end mobile-only-ip --}}

    </form>

</div>
</div>

<!-- Product Selection Modal -->
<div class="modal fade" id="productSelectModal" tabindex="-1" role="dialog" aria-labelledby="productSelectLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Select Product</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 1rem !important">
                <div class="form-group">
                    <label>Product</label>
                    <div id="modalProductSelectWrapper" style="width: 80%;border: 1px solid #ebebeb;"></div>
                </div>

                <div id="productImagePreview" class="mb-3" style="display: none;">
                    <img src="" id="previewImage" style="width: 100px;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="confirmAddProduct" class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>
</div>

@include('pages.stores.player_report.email')


<script>
    $(document).ready(function() {
        let refundInProgress = false;

        $('.status-change').each(function() {
            var selectedColor = $(this).find('option:selected').data('color');
            $(this).css('background-color', selectedColor);
        });

        $(document).on('change', '.status-change', function() {
            var selectedColor = $(this).find('option:selected').data('color');
            $(this).css('background-color', selectedColor);
        });

        $('#remove_shipping').on('click', function() {
            $('#is_shipping_removed').val(1);
            $('#add_shipping').show();
            $(this).hide();
            calculateGrandTotal();
        });
        $('#add_shipping').on('click', function() {
            $('#is_shipping_removed').val(0);
            $('#remove_shipping').show();
            $(this).hide();
            calculateGrandTotal();
        });

        let previousValidAmount = $('#exess_amount').val();

        $(document).on('input', '#exess_amount, #exess_amount_mobile', function() {
            // $('#exess_amount').on('input', function () {
            var value = parseFloat($(this).val());
            let $input = $(this);
            let min = parseFloat($input.attr('min')) || 0;
            let max = parseFloat($input.attr('max'));

            if (value == min) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Amount',
                    text: 'Refund amount cannot be 0.',
                    confirmButtonColor: '#d33'
                });
                $input.val(previousValidAmount);
                return;
            }

            // Exceeds max
            if (!isNaN(max) && value > max) {
                Swal.fire({
                    icon: 'error',
                    title: 'Amount Exceeded',
                    text: 'Refund amount cannot exceed the paid amount.',
                    confirmButtonColor: '#d33'
                });
                $input.val(previousValidAmount);
                return;
            }

            if (isNaN(value) || value < 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Amount',
                    text: 'Please enter a valid refund amount greater than or equal to zero.',
                    confirmButtonColor: '#d33'
                });
                $(this).val('0.00');
                return;
            }

            previousValidAmount = value.toFixed(2);
            $('#exess_amount').val(value.toFixed(2));
            $('#exess_amount_mobile').val(value.toFixed(2));
            $('.refund-btn').attr('data-amount', value.toFixed(2));
            // $('#refund-btn').attr('data-amount', value.toFixed(2));
        });

        $('.save-order-details').click(function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Send Receipt?',
                text: "Do you want to notify the user by sending the receipt via email?",
                icon: 'question',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Yes, send it!',
                cancelButtonText: 'No, do not send',
                confirmButtonColor: '#39a0b1',
                cancelButtonColor: '#d33'
            }).then((result) => {
                console.log(result);
                if (result.value) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'send_email_notification',
                        value: '1'
                    }).appendTo('#shipping-details-form');

                    // IMPORTANT: desktop and mobile layouts contain fields with
                    // the same names. Disable the hidden layout before posting so the
                    // visible layout's edited values are the ones sent to Laravel.
                    disableHiddenLayoutFields();

                    $(".se-pre-con").fadeIn('slow');
                    $('#shipping-details-form').submit();

                } else if (result.dismiss == 'cancel') {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'send_email_notification',
                        value: '0'
                    }).appendTo('#shipping-details-form');

                    // Apply the same protection when saving without email.
                    disableHiddenLayoutFields();

                    $(".se-pre-con").fadeIn('slow');
                    $('#shipping-details-form').submit();

                }
            });
        });

        $(document).on('click', '.create-shipment', function(e) {
            e.preventDefault();

            const url = $(this).attr('href');

            Swal.fire({
                title: 'Create Shipment?',
                text: "Are you sure you want to create a shipment for this order?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, create it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value) {
                    $(".se-pre-con").fadeIn('slow');
                    window.location.href = url;
                }
            });
        });

        $(document).on('click', '.refund-btn', function() {

            if (refundInProgress) return;
            refundInProgress = true;

            const $btn = $(this);
            const orderId = $btn.data('order-id');
            const transactionId = $btn.data('transaction-id');
            const paymentRecord = $btn.data('payment-record');

            $btn.prop('disabled', true).text('Saving changes...');

            // Step 1: silently save the current form state (no email sent from this endpoint)
            $.ajax({
                url: "{{ route('store.save_shipping_details_ajax') }}",
                type: 'POST',
                data: $('#shipping-details-form').serialize(),
                success: function(saveResponse) {

                    if (saveResponse.status !== 'success') {
                        Swal.fire({ icon: 'error', title: 'Save Failed', text: saveResponse.message || 'Could not save order changes.' });
                        $btn.prop('disabled', false).text('Refund');
                        refundInProgress = false;
                        return;
                    }

                    const overpaidAmount = saveResponse.overpaid_amount;

                    if (overpaidAmount <= 0) {
                        Swal.fire({ icon: 'info', title: 'Nothing to Refund', text: 'There is no overpaid amount on this order.' });
                        $btn.prop('disabled', false).text('Refund');
                        refundInProgress = false;
                        return;
                    }

                    $btn.text('Processing refund...');

                    // Step 2: run the refund using the amount just recalculated by the save above
                    $.ajax({
                        url: "{{ route('store.refund_exess') }}",
                        type: 'POST',
                        data: {
                            order_id: orderId,
                            transaction_id: transactionId,
                            amount: overpaidAmount,
                            payment_record: paymentRecord,
                            _token: $('#shipping-details-form input[name="_token"]').val()
                        },
                        success: function(refundResponse) {

                            if (refundResponse.status !== 'success') {
                                Swal.fire({ icon: 'error', title: 'Refund Failed', text: refundResponse.message || 'The refund could not be processed.' });
                                $btn.prop('disabled', false).text('Refund');
                                refundInProgress = false;
                                return;
                            }

                            Swal.fire({
                                icon: 'success',
                                title: 'Refund Successful',
                                text: refundResponse.message,
                                confirmButtonText: 'OK'
                            }).then(function() {
                                location.reload();
                            });

                        },
                        error: function(xhr) {
                            Swal.fire({ icon: 'error', title: 'Refund Failed', text: 'The order changes were saved, but the refund could not be processed. You can click Refund again to retry.' });
                            $btn.prop('disabled', false).text('Refund');
                            refundInProgress = false;
                        }
                    });

                },
                error: function(xhr) {
                    Swal.fire({ icon: 'error', title: 'Save Failed', text: 'Could not save order changes before processing the refund.' });
                    $btn.prop('disabled', false).text('Refund');
                    refundInProgress = false;
                }
            });

        });
        $(document).on('click', '.get-payments-btn', function() {
            const orderId = $(this).data('order-id');
            const amount = $(this).data('amount');

            const paymentUrl = `{{ makeStoreDomainRoute('store/get_customer_payments') }}?order_id=${orderId}&amount=${amount}`;

            Swal.fire({
                title: 'Customer Payment Link',
                html: `
                    <input type="text" id="payment-link" class="swal2-input" value="${paymentUrl}" readonly>
                `,
                confirmButtonText: 'Copy Link',
                showCancelButton: true,
                preConfirm: () => {
                    const input = document.getElementById('payment-link');
                    input.select();
                    input.setSelectionRange(0, 99999); // For mobile
                    document.execCommand('copy');
                    Swal.fire({
                        icon: 'success',
                        title: 'Copied!',
                        text: 'Payment link copied to clipboard.'
                    });
                }
            });
        });

    });
    $(document).on('input', '.item-quantity', function() {

        // var $row = $(this).closest('tr');
        var $row = $(this).closest('[data-item-id]');

        var unitPrice = parseFloat($row.find('.unit-price').val()) || 0;

        var quantity = parseFloat($(this).val()) || 0;

        var total = (quantity * unitPrice).toFixed(2);

        $row.find('.item-total').val(total);

        syncItemAcrossLayouts($row, { qty: quantity, total: total });

        calculateGrandTotal();
    });

    $(document).on('input', '.unit-price', function() {

        // var $row = $(this).closest('tr');
        var $row = $(this).closest('[data-item-id]');

        var unitPrice = parseFloat($(this).val()) || 0;

        var quantity = parseFloat($row.find('.item-quantity').val()) || 0;

        var total = (quantity * unitPrice).toFixed(2);

        $row.find('.item-total').val(total);

        syncItemAcrossLayouts($row, { unitPrice: unitPrice, total: total });

        calculateGrandTotal();
    });

    // Finds the sibling container (desktop <tr> or mobile card) for the same item-id
    // and copies values across, so whichever layout you're NOT looking at stays current.
    function syncItemAcrossLayouts($sourceItem, values) {
        var itemId = $sourceItem.data('item-id');
        if (itemId === undefined) return;

        $('[data-item-id="' + itemId + '"]').not($sourceItem).each(function() {
            var $target = $(this);
            if (values.qty !== undefined) $target.find('.item-quantity').val(values.qty);
            if (values.unitPrice !== undefined) $target.find('.unit-price').val(values.unitPrice);
            if (values.total !== undefined) $target.find('.item-total').val(values.total);
            if (values.name !== undefined) $target.find('[name*="[name]"]').val(values.name);
            if (values.number !== undefined) $target.find('[name*="[number]"]').val(values.number);
        });
    }

    function calculateGrandTotal() {
        let orderSubTotal = 0;

        // Only sum from the currently visible layout to avoid double-counting
        var $visibleScope = $('.desktop-only-ip').is(':visible') ? $('.desktop-only-ip') : $('.mobile-only-ip');

        $visibleScope.find('.item-total').each(function() {
            orderSubTotal += parseFloat($(this).val()) || 0;
        });

        // $('.item-total').each(function() {
        //     orderSubTotal += parseFloat($(this).val()) || 0;
        // });

        var feeSum = parseFloat('{{$store->handling_fee}}') + parseFloat('{{$store->service_charge}}') + parseFloat('{{$store->other}}');

        var order_handling_fee = feeSum * orderSubTotal / 100;

        $('.se-pre-con').fadeIn('slow');

        // Calculate total weight
        let totalWeight = 0;
        $visibleScope.find('.product-weight').each(function() {
            var itemWeight = parseFloat($(this).val()) || 5;
            var itemQty = parseFloat($(this).closest('[data-item-id]').find('.item-quantity').val()) || 0;
            totalWeight += itemWeight * itemQty;
        });

        // $('#shipping-details-form .product-weight').each(function() {
        //     var itemWeight = parseFloat($(this).val()) || 5;
        //     var itemQty = parseFloat($(this).closest('tr').find('.item-quantity').val()) || 0;
        //     totalWeight += itemWeight * itemQty;
        // });

        // var order_handling_fee = parseFloat($('#order_handling_fee').val()) || 0;
        var salesTaxRate = parseFloat($('#order_sales_tax_rate').val()) || 0;
        var order_sales_tax = parseFloat((orderSubTotal * salesTaxRate / 100).toFixed(2)) || 0;

        // Determine if shipping should be 0
        let isShippingRemoved = $('#is_shipping_removed').val() == '1';

        let shippingFee = 0;

        var couponDetails = @json($order->CouponDetails) || null;

        function updateTotals(shipping) {

            let order_grand_total = 0;
            let invoiceAmount = orderSubTotal + shipping + order_handling_fee + order_sales_tax;

            if (couponDetails) {
                if (couponDetails.type == 'free_shipping') {
                    shipping = 0;
                    order_grand_total = orderSubTotal + shipping + order_handling_fee + order_sales_tax;
                } else if (couponDetails.type == 'flat_from_sub') {
                    orderSubTotal = Math.max(0, orderSubTotal - parseFloat(couponDetails.amount));
                    order_sales_tax = (orderSubTotal * salesTaxRate) / 100;
                    order_grand_total = orderSubTotal + shipping + order_handling_fee + order_sales_tax;
                } else if (couponDetails.type == 'percentage_from_sub') {
                    orderSubTotal = orderSubTotal - (orderSubTotal * parseFloat(couponDetails.amount) / 100);
                    order_sales_tax = (orderSubTotal * salesTaxRate) / 100;
                    order_grand_total = orderSubTotal + shipping + order_handling_fee + order_sales_tax;
                } else if (couponDetails.type == 'flat_from_grand') {
                    order_grand_total = Math.max(0, invoiceAmount - parseFloat(couponDetails.amount));
                } else if (couponDetails.type == 'percentage_from_grand') {
                    order_grand_total = invoiceAmount - (invoiceAmount * parseFloat(couponDetails.amount) / 100);
                }
            } else {
                order_grand_total = invoiceAmount;
            }

            $('#order_sub_total').val(orderSubTotal.toFixed(2));
            $('#order_shipping').val(shipping.toFixed(2));
            $('#order_handling_fee').val(order_handling_fee.toFixed(2));
            $('#order_sales_tax').val(order_sales_tax.toFixed(2));
            $('#order_grand_total').val(order_grand_total.toFixed(2));

            // Paid details
            const paidInvoiceAmount = parseFloat($('#order_paid_amount').val()) || 0;
            const paidProcessingFee = parseFloat($('#order_paid_processing_fee').val()) || 0;
            const totalPaid = paidInvoiceAmount + paidProcessingFee;

            $('#order_total_paid_amount').val(totalPaid.toFixed(2));

            // Payment status
            const $statusSpan = $('#payment-status-span');
            let paymentStatus = 'Pending',
                bgColor = '#f8d7da',
                textColor = '#721c24';

            if (paidInvoiceAmount === order_grand_total) {
                paymentStatus = 'Paid';
                bgColor = '#d4edda';
                textColor = '#155724';
            } else if (paidInvoiceAmount > order_grand_total) {
                paymentStatus = 'Over Paid';
                bgColor = '#d4edda';
                textColor = '#155724';
            } else if (paidInvoiceAmount > 0) {
                paymentStatus = 'Partial';
                bgColor = '#fff3cd';
                textColor = '#856404';
            }

            $statusSpan.text(paymentStatus)
                .css('background-color', bgColor)
                .css('color', textColor);

            // Amount to pay / excess
            const amountToPay = order_grand_total - paidInvoiceAmount;
            const excessAmount = (paidInvoiceAmount - order_grand_total);

            // $('#order_amount_to_pay').val(amountToPay > 0 ? amountToPay.toFixed(2) : '0.00');
            // $('#exess_amount').val(excessAmount > 0 ? excessAmount.toFixed(2) : '0.00');

            // $('#amount-to-pay-row').toggle(amountToPay > 0);
            // $('#excess-payment-row').toggle(excessAmount > 0);

            // $('.se-pre-con').fadeOut('slow');

            $('#order_amount_to_pay').val(amountToPay > 0 ? amountToPay.toFixed(2) : '0.00');
            $('#exess_amount').val(excessAmount > 0 ? excessAmount.toFixed(2) : '0.00');
            $('#exess_amount_mobile').val(excessAmount > 0 ? excessAmount.toFixed(2) : '0.00');
            $('#mobile-order-amount-to-pay').text('$' + (amountToPay > 0 ? amountToPay.toFixed(2) : '0.00'));

            $('#amount-to-pay-row').toggle(amountToPay > 0);
            $('#excess-payment-row').toggle(excessAmount > 0);
            $('#mobile-amount-to-pay-row').toggle(amountToPay > 0);
            $('#mobile-excess-payment-row').toggle(excessAmount > 0);

            $('.get-payments-btn').attr('data-amount', amountToPay > 0 ? amountToPay.toFixed(2) : '0.00');
            $('.refund-btn').attr('data-amount', excessAmount > 0 ? excessAmount.toFixed(2) : '0.00');

            $('.se-pre-con').fadeOut('slow');
        }

        if (isShippingRemoved) {
            shippingFee = 0;
            updateTotals(shippingFee);
        } else {
            $.ajax({
                url: "{{ route('usps.get_order_shipping_fee') }}",
                method: 'GET',
                dataType: 'json',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    order_no: '{{ $order->order_no }}',
                    total_weight: totalWeight,
                    total_price: orderSubTotal + order_handling_fee + order_sales_tax,
                },
                success: function(response) {
                    if (response && response.success) {
                        shippingFee = parseFloat(response.rate.amount) || 0;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Failed to fetch shipping fee.',
                            confirmButtonColor: '#d33'
                        });
                        shippingFee = 0;
                    }
                    updateTotals(shippingFee);
                },
                error: function() {
                    updateTotals(0);
                    $('.se-pre-con').fadeOut('slow');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while fetching shipping fee.',
                        confirmButtonColor: '#d33'
                    });
                }
            });
        }
    }



    $(document).on('input', '#order_shipping, #order_handling_fee, #order_sales_tax', function() {
        calculateGrandTotal();
    });
    $(document).on('click', '.remove-item', function() {
        // const row = $(this).closest('tr');
        const row = $(this).closest('[data-item-id]');
        var itemId = row.data('item-id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This item will be removed.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.value) {

                $('<input>').attr({
                    type: 'hidden',
                    name: 'deleted_items[]',
                    value: itemId
                }).appendTo('#deleted_items_container');


                // row.remove();
                $('[data-item-id="' + itemId + '"]').remove();

                calculateGrandTotal();

                Swal.fire(
                    'Deleted!',
                    'The item has been removed.',
                    'success'
                );
            }
        });
    });

    $(document).on('change', '.order-item-product', function() {
        const $row = $(this).closest('tr');

        const selectedImageUrl = $(this).find(':selected').data('image-url');
        const selectedPrice = $(this).find(':selected').data('product-price');
        const isNameAvailable = $(this).find(':selected').data('is-name-available');
        const isNumberAvailable = $(this).find(':selected').data('is-number-available');
        const productWeight = $(this).find(':selected').data('product-weight');
        const sizeType = $(this).find(':selected').data('size-type-id');
        const productId = $(this).find(':selected').val();

        $row.find('.unit-price').val(selectedPrice);
        $row.find('.product-weight').val(productWeight);

        if (isNameAvailable) {
            $row.find('.is-name-available').show();
        } else {
            $row.find('.is-name-available').hide();
        }

        if (isNumberAvailable) {
            $row.find('.is-number-available').show();
        } else {
            $row.find('.is-number-available').hide();
        }

        // Show product image
        $row.find('.item-product-image').attr('src', selectedImageUrl);

        // Get the size select element
        const $sizeSelect = $row.find('select[name*="[size]"]');

        // Save the previously selected size value
        const previouslySelectedSize = $sizeSelect.val();

        $.ajax({
            url: '{{ route('store.get_sizes') }}',
            method: 'GET',
            dataType: 'json',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                size_type_id: sizeType,
                store_product_id: productId
            },
            success: function(response) {
                const storeSizes = response.store_sizes;
                const allSizes = response.store_sizes_all;

                const filteredSizes = allSizes.filter(size =>
                    storeSizes.map(String).includes(String(size.id))
                );

                // Clear old options
                $sizeSelect.empty();

                // Append new options
                filteredSizes.forEach(size => {
                    const isSelected = size.id == previouslySelectedSize ? 'selected' : '';
                    $sizeSelect.append(`<option value="${size.id}" ${isSelected}>${size.size_name}</option>`);
                });
            },
            error: function() {
                console.error('Failed to fetch sizes.');
            }
        });

        calculateGrandTotal();
    });

    let duplicateIndex = 0;

    // $(document).on('click', '.add-new-item', function () {
    //     let lastDuplicateBtn = $('.duplicate-product').last();

    //     if (lastDuplicateBtn.length) {
    //         Swal.fire({
    //             title: 'Add New Item?',
    //             text: "Do you want to duplicate the last product row?",
    //             icon: 'question',
    //             showCancelButton: true,
    //             confirmButtonText: 'Yes, add it',
    //             cancelButtonText: 'Cancel'
    //         }).then((result) => {
    //             if (result.value) {
    //                 duplicateRow(lastDuplicateBtn);
    //             }
    //         });
    //     } else {
    //         Swal.fire({
    //             icon: 'error',
    //             title: 'No Row Found',
    //             text: 'There is no item to duplicate.',
    //         });
    //     }
    // });

    $(document).on('click', '.duplicate-product', function() {
        let button = $(this);

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to duplicate this product?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, duplicate it!',
            cancelButtonText: 'No, cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                duplicateRow(button);
            }
        });
    });

    function duplicateRow(row) {
        // let $originalRow = row.closest('tr');
        let $originalRow = button.closest('[data-item-id]');
        let $clone = $originalRow.clone();

        let unitPrice = $originalRow.find('.unit-price').val();

        $clone.removeAttr('data-item-id');
        $clone.find('input, select, textarea').each(function() {
            let $this = $(this);
            let name = $this.attr('name');

            if (name) {
                const updatedName = name.replace(/players\[\d+\]/, `new_players[${duplicateIndex}]`);
                $this.attr('name', updatedName);
            }

            if ($this.hasClass('unit-price')) {
                $this.val(unitPrice);
            } else if ($this.hasClass('item-paid')) {
                $this.val('0.00');
            } else if ($this.hasClass('item-quantity')) {
                $this.val('1');
            } else if ($this.hasClass('item-total')) {
                $this.val(unitPrice);
            } else if ($this.is('input[type="text"], input[type="number"], textarea')) {
                $this.val('');
            }
        });

        $originalRow.after($clone);
        duplicateIndex++;
        calculateGrandTotal();
    }


    let currentProductRow = null;

    $(document).on('click', '.add-new-item', function() {
        const productSelect = $('select.order-item-product-copy').first();
        currentProductRow = $('#sample_row');

        const productSelectClone = productSelect.clone().attr('id', 'modal-product-select').removeClass('order-item-product-copy d-none').addClass('form-control').show();

        $('#modalProductSelectWrapper').empty().append(productSelectClone);

        const selectedOption = productSelect.find('option:selected');
        const imageUrl = selectedOption.data('image-url') || '';

        if (imageUrl) {
            $('#previewImage').attr('src', imageUrl).show();
            $('#productImagePreview').show();
        } else {
            $('#productImagePreview').hide();
        }

        $('#productSelectModal').modal('show');
    });

    // When Confirm button is clicked in modal, add new row based on currentProductRow
    $(document).on('click', '#confirmAddProduct', function() {
        $('.se-pre-con').fadeIn('slow');

        const $productSelect = $('#modal-product-select');
        const selectedOption = $productSelect.find('option:selected');
        const productId = selectedOption.val();
        const imageUrl = selectedOption.data('image-url') || '';
        const price = selectedOption.data('product-price') || 0;
        const weight = selectedOption.data('product-weight') || 5;
        const isNameAvailable = selectedOption.data('is-name-available');
        const isNumberAvailable = selectedOption.data('is-number-available');
        const sizeTypeId = selectedOption.data('size-type-id');

        if (!productId) {
            alert("Please select a product");
            return;
        }

        $.ajax({
            url: '{{ route('store.get_sizes') }}',
            method: 'GET',
            dataType: 'json',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                size_type_id: sizeTypeId,
                store_product_id: productId
            },
            success: function(response) {
                const storeSizes = response.store_sizes;
                const allSizes = response.store_sizes_all;
                const filteredSizes = allSizes.filter(size =>
                    storeSizes.map(String).includes(String(size.id))
                );

                const $newRow = currentProductRow.clone();
                $newRow.removeClass('d-none');

                $newRow.css('background-color', '#f2f2f2');
                $newRow.find('select.order-item-product').val(productId);
                $newRow.find('.item-product-image').attr('src', imageUrl);
                $newRow.find('.unit-price').val(price);
                $newRow.find('.product-weight').val(weight);
                $newRow.find('.item-total').val(price);
                $newRow.find('.item-quantity').val(1);

                // Replace size options
                const sizeSelect = $newRow.find('select[name*="[size]"]');
                sizeSelect.empty();
                filteredSizes.forEach(size => {
                    sizeSelect.append(`<option value="${size.id}">${size.size_name}</option>`);
                });

                // Handle name/number input visibility
                if (isNameAvailable) {
                    $newRow.find('.is-name-available').show();
                } else {
                    $newRow.find('.is-name-available').hide();
                }
                if (isNumberAvailable) {
                    $newRow.find('.is-number-available').show();
                } else {
                    $newRow.find('.is-number-available').hide();
                }

                // Update input names with new index
                $newRow.find('input, select, textarea').each(function() {
                    let name = $(this).attr('name');
                    if (name) {
                        name = name.replace(/players\[\d+\]/, `new_players[${duplicateIndex}]`);
                        $(this).attr('name', name);
                    }
                });

                $('#product_report_table tbody').prepend($newRow);
                $('#productSelectModal').modal('hide');
                duplicateIndex++;
                calculateGrandTotal();
                $('.se-pre-con').fadeOut('slow');
            },
            error: function() {
                $('.se-pre-con').fadeOut('slow');
                console.error('Failed to load sizes.');
            }
        });
    });
    $(document).on('change', '#modal-product-select', function() {
        const imageUrl = $(this).find(':selected').data('image-url');
        $('#previewImage').attr('src', imageUrl);
    });
    $(document).on('click', '#confirmAddProduct', function() {


    });
    $(document).on('click', '.download-receipt-btn', function(e) {
        e.preventDefault();

        const receiptNo = $(this).data('receipt-no');
        if (!receiptNo) return;

        const storeId = "{{ $store->id }}";

        $(".se-pre-con").fadeIn("slow");

        $.ajax({
            url: "{{ route('store.download_order_receipt') }}",
            type: 'GET',
            data: {
                store_id: storeId,
                receipt_id: receiptNo
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(blob, status, xhr) {
                $(".se-pre-con").fadeOut("slow");

                const disposition = xhr.getResponseHeader('Content-Disposition');
                let filename = 'receipt.pdf';
                if (disposition && disposition.indexOf('filename=') !== -1) {
                    filename = disposition.split('filename=')[1].replace(/"/g, '');
                }

                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            },
            error: function(xhr) {
                $(".se-pre-con").fadeOut("slow");
                console.error('Failed to download PDF.');
            }
        });
    });
    // ===== Mobile accordion toggle =====
    function toggleIpSection(headerEl) {
        var $header = $(headerEl);
        var $section = $header.closest('.ip-section');
        var $body = $section.find('.ip-section-body').first();
        var $chevron = $header.find('.ip-chevron');

        if ($body.is(':visible')) {
            $body.slideUp(180);
            $chevron.removeClass('open');
        } else {
            $body.slideDown(180);
            $chevron.addClass('open');
        }
    }

    // Disable every named field in the hidden responsive layout before submit.
    // CSS display:none does not stop form controls from being submitted, so without
    // this the hidden mobile/desktop copy can overwrite the visible layout's values.
    function disableHiddenLayoutFields() {
        var $form = $('#shipping-details-form');

        var $hiddenLayout = $form.find('.desktop-only-ip').is(':visible')
            ? $form.find('.mobile-only-ip')
            : $form.find('.desktop-only-ip');

        $hiddenLayout.find(':input[name]').prop('disabled', true);
    }

    // Wire mobile email button to the same compose-email modal as desktop
    $(document).on('click', '#compose_email_button_mobile', function() {
        $('#compose_email_button').trigger('click');
    });
</script>

@endsection
