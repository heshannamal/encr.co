@extends('layouts.app', ['activePage' => 'Team Stores', 'titlePage' => __('Team Stores')])

@section('sub-sidebar-content')

<style>
    .main_card {
        margin-top: 20px;
        border: unset;
        padding-bottom: 15px;
        border-radius: unset;
    }
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
    .player_details1 {
        color: #4E4C4C;
        font-size: 12px;
        margin-bottom: unset;
        font-weight: 400;
    }
    .player_details2 {
        color: #717070;
        font-size: 12px;
        margin-bottom: unset;
        font-weight: 400;
    }
    .player_details_div {
        margin-left: 33px;
    }
    .player_details_row {
        padding-bottom: 5px;
    }
    .table_header_text {
        color: white;
        height: 40px;
    }
    .table_body {
        color: #4E4C4C;
    }
    .player_details_topic {
        width: 8rem;
    }
    .hover-func {
        text-decoration: none;
        cursor: pointer;
    }

    .hover-func:hover {
        text-decoration: underline;
    }
    .qty_div, .qty_div2 {
        display: flex;
        align-items: center;
    }

    /* Responsive utilities */
    @media (min-width: 768px) {
        .mobile-only {
            display: none !important;
        }
    }
    @media (max-width: 767px) {
        .bg-box.container-fluid.fix-nav.header-layout{
            margin-bottom: 0 !important;
        }
        .desktop-only {
            display: none !important;
        }
        .main_card {
            background-color: transparent !important;
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            margin-top: 10px !important;
        }
        /* Mobile layout styling */
        .mobile-summary-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 12px;
        }
        .mobile-summary-box {
            background: #fff;
            border-radius: 10px;
            padding: 12px;
            text-align: center;
            border: 1px solid #f0f0f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .mobile-summary-label {
            font-size: 11px;
            color: #717070;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .mobile-summary-val {
            font-size: 20px;
            font-weight: 700;
            color: #333;
        }
        .mobile-actions-row {
            display: grid;
            grid-template-columns: 1.2fr 1fr 1fr;
            gap: 8px;
            margin-bottom: 12px;
        }
        .mobile-btn {
            height: 38px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: #fff;
            cursor: pointer;
            text-decoration: none !important;
        }
        .mobile-btn-roster {
            border: 1px solid #17a589;
            color: #17a589;
        }
        .mobile-btn-csv {
            border: 1px solid #3b82f6;
            color: #3b82f6;
        }
        .mobile-btn-pdf {
            border: 1px solid #ef4444;
            color: #ef4444;
        }
        .mobile-search-wrapper {
            position: relative;
            margin-bottom: 15px;
        }
        .mobile-search-input {
            width: 100%;
            height: 40px;
            padding-left: 36px;
            border-radius: 10px;
            border: 1px solid #f0f0f0;
            background: #fff;
            font-size: 13px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        .mobile-search-icon {
            position: absolute;
            left: 12px;
            top: 13px;
            color: #999;
        }

        /* Player cards */
        .mobile-player-card {
            background: #fff;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
            border: 1px solid #f0f0f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .mobile-player-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
        }
        .mobile-player-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .mobile-avatar {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: #e6f9f3;
            color: #17a589;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
        }
        .mobile-player-title {
            font-size: 14px;
            font-weight: 700;
            color: #333;
        }
        .mobile-player-subtitle {
            font-size: 12px;
            color: #17a589;
            font-weight: 700;
            margin-top: 2px;
        }
        .mobile-badges-row {
            display: flex;
            gap: 6px;
            margin-top: 6px;
            flex-wrap: wrap;
        }
        .mobile-badge {
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 600;
            border: 1px solid #e5e5e5;
            color: #717070;
        }
        .mobile-badge.green {
            background: #e6f9f3;
            color: #17a589;
            border-color: transparent;
        }

        /* Expandable Area */
        .mobile-player-content {
            margin-top: 15px;
            border-top: 1px solid #f3f4f6;
            padding-top: 15px;
        }
        .mobile-section-title {
            font-size: 11px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 10px;
        }
        .mobile-info-table {
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            margin-bottom: 15px;
            overflow: hidden;
        }
        .mobile-info-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            padding: 10px 12px;
            font-size: 12px;
            border-bottom: 1px solid #f0f0f0;
        }
        .mobile-info-row:last-child {
            border-bottom: none;
        }
        .mobile-info-label {
            color: #717070;
            font-weight: 500;
        }
        .mobile-info-val {
            font-weight: 600;
            color: #333;
            text-align: right;
        }
        .mobile-info-val.blue {
            color: #3b82f6;
        }

        /* Purchased Products List */
        .mobile-product-card {
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 10px;
        }
        .mobile-product-name {
            font-size: 13px;
            font-weight: 700;
            color: #333;
        }
        .mobile-product-code {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 2px;
            margin-bottom: 8px;
        }
        .mobile-product-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 8px;
        }
        .mobile-product-field {
            font-size: 11px;
        }
        .mobile-field-label {
            color: #999;
            margin-bottom: 1px;
        }
        .mobile-field-val {
            font-weight: 600;
            color: #333;
        }
        .mobile-product-price-label {
            font-size: 10px;
            color: #999;
        }
        .mobile-product-price-val {
            font-size: 15px;
            font-weight: 700;
            color: #333;
        }

        /* Actions */
        .mobile-actions-footer {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 8px;
            margin-top: 15px;
            border-top: 1px solid #f3f4f6;
            padding-top: 12px;
        }
        .mobile-footer-btn {
            height: 38px;
            border-radius: 8px;
            border: 1px solid #e5e5e5;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 600;
            color: #4b5563;
            cursor: pointer;
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
</style>


<div class="container-fluid mb-5" style="padding: 0 !important;">
    <div class="se-pre-con"></div>

    @include('pages.stores.layouts.top_header')

    @yield('stores_header')


    <div class="card col-lg-12 main_card" style="margin-top: 20px;">

        <!-- Desktop Only Layout -->
        <div class="desktop-only">
            <div class="row">
                <div class="w-100">
                    <div class="row d-flex align-items-center" style="padding: 15px;">

                        <!-- LEFT SIDE -->
                        <div class="d-flex flex-wrap">
                            <div class="qty_div ml-3 d-flex align-items-center">
                                <p class="total_qty_text mb-0">Total quantity of products</p>
                            </div>
                            <div class="qty_div2 d-flex align-items-center">
                                <p class="total_qty_text mb-0" style="color:#717070;">
                                    {{ optional($store->StoreOrders->map->OrderItems->flatten())->sum('qty') ?: 'N/A' }}
                                </p>
                            </div>

                            <div class="qty_div d-flex align-items-center ml-4">
                                <p class="total_qty_text mb-0">Total number of orders</p>
                            </div>
                            <div class="qty_div2 d-flex align-items-center">
                                <p class="total_qty_text mb-0" style="color:#717070;">
                                    {{ optional($store->StoreOrders)->count() ?? 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <!-- RIGHT SIDE -->
                        <div class="ml-auto d-flex align-items-center" style="padding-right:20px;">

                            <div class="position-relative mr-2" style="max-width: 260px; width: 100%;">
                                <i class="fa fa-search"
                                style="
                                        position: absolute;
                                        top: 50%;
                                        left: 10px;
                                        transform: translateY(-50%);
                                        color: #888;
                                        font-size: 14px;
                                ">
                                </i>

                                <input type="text" id="player-search" class="form-control"
                                    placeholder="Search Name or Order No"
                                    style="
                                            padding-left: 2.2rem;
                                            border-radius: 6px;
                                            height: 38px;
                                    ">
                            </div>

                            <button class="share_btn ml-2" data-toggle="modal" data-target="#updateRosterModal"
                                    style="
                                        color: grey;
                                        min-width: 9rem;
                                        border: 1px solid grey;
                                        padding: .4rem .2rem;
                                        border-radius: 6px;
                                        background:white;
                                    ">
                                <i class="fa fa-users" style="padding:5px;color:grey"></i>
                                UPDATE ROSTER
                            </button>

                            <button class="share_btn download-csv-all ml-2"
                                    style="
                                        color: grey;
                                        min-width: 9rem;
                                        border: 1px solid grey;
                                        padding: .4rem .2rem;
                                        border-radius: 6px;
                                        background:white;
                                    ">
                                <i class="fa fa-download" style="padding:5px;color:grey"></i>
                                DOWNLOAD CSV
                            </button>
                            <button class="share_btn download-pdf-all ml-2"
                                    style="
                                        color: grey;
                                        min-width: 9rem;
                                        border: 1px solid grey;
                                        padding: .4rem .2rem;
                                        border-radius: 6px;
                                        background:white;
                                    ">
                                <i class="fa fa-download" style="padding:5px;color:grey"></i>
                                DOWNLOAD PDF
                            </button>

                        </div>

                    </div>
                </div>
            </div>

            <div style="height: 75vh;overflow-x: scroll;">
                @foreach ($store->StoreOrders as $key => $order)
                <div class="player-report-div" data-order-id="{{ strtolower($order->order_no ?? '') }}">
                    <div class="row" style="padding: 8px;background-color: #878585;margin: 0;">
                            <div style="margin:5px"><img src="{{ asset('assets/img/team_stores/report.png') }}" style="width: 22px;" /></div>
                            <div style="padding: 1px; padding-left: 11px;margin:5px">
                                <b class="player-name">{{ $order->storeCustomer->first_name ." ". $order->storeCustomer->last_name }}</b>
                            </div>
                            <div style="padding-left: 10px;margin:5px"><p class="symbol1">|</p></div>
                            <div style="padding: 1px; padding-left: 11px;margin:5px">
                                <a class="hover-func  order-number" href="{{ route('store.individual_player', ['id' => $order->order_no]) }}" style="color: white;font-weight: 600;font-size: 1rem;">Order #{{$order->order_no ?? 'N/A'}}</a>
                            </div>
                            <div class="share_btn_div ml-auto">
                                <button class="share_btn send-email" style="color:white"><i class="fa fa-share" style="padding: 5px;color:white"></i> SHARE</button>
                            </div>
                            <div class="share_btn_div">
                                <button class="share_btn download-pdf" style="color:white"><i class="fa fa-download" style="padding: 5px;color:white"></i> DOWNLOAD</button>
                            </div>
                            <div class="share_btn_div" style="border: unset;">
                                <button class="share_btn print-pdf" style="color:white"><i class="fa fa-print" style="padding: 5px;color:white"></i> PRINT</button>
                            </div>
                    </div>

                    <div class="col-lg-8 player_details_div mt-2">
                        <div class="row player_details_row">
                            <div class="player_details_topic">
                                <p class="player_details1">Billing Name:</p>
                            </div>
                            <div class="player_details">
                                <p class="player_details2">{{ $order->storeCustomer->first_name ." ". $order->storeCustomer->last_name }}</p>
                            </div>
                        </div>
                        <div class="row player_details_row">
                            <div class="player_details_topic">
                                <p class="player_details1">Payment Method:</p>
                            </div>
                            <div class="player_details">
                                <p class="player_details2">{{$order->payment_method ?? 'N/A'}}</p>
                            </div>
                        </div>
                        <div class="row player_details_row">
                            <div class="player_details_topic">
                                <p class="player_details1">Order Date:</p>
                            </div>
                            <div class="player_details">
                                <p class="player_details2">{{ $order->created_at ? $order->created_at->copy()->setTimezone('America/Los_Angeles')->format('d M Y (g:i a T)') : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="row player_details_row">
                            <div class="player_details_topic">
                                <p class="player_details1">Shipping Method:</p>
                            </div>
                            <div class="player_details">
                                <p class="player_details2">
                                    {{ $order->shippingMethodDetails->shipping_method_name ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                        <div class="row player_details_row">
                            <div class="player_details_topic">
                                <p class="player_details1">Shipping Address:</p>
                            </div>
                            <div class="player_details">
                                <p class="player_details2">{{ $order->storeCustomer->street }}, {{ $order->storeCustomer->city }}, {{ $order->storeCustomer->state }}, {{ $order->storeCustomer->postal_code }}, {{ $order->storeCustomer->country }}, </p>
                            </div>
                        </div>
                    </div>

                    <div style="padding-left: 35px; padding-right: 10px; padding-top: 5px; overflow-x: auto;">
                        <table class="table align-items-center" id="product_report_table" style="min-width: 100%;">
                            <thead style="background-color: #d7d7d7;">
                                <tr>
                                    <th scope="col" class="table_header_text" style="width: 44%;color:black">Product</th>
                                    <th scope="col" class="table_header_text" style="color:black">Size</th>
                                    <th scope="col" class="table_header_text" style="color:black">Name</th>
                                    <th scope="col" class="table_header_text" style="color:black">Number</th>
                                    <th scope="col" class="table_header_text" style="color:black">QTY</th>
                                    <th scope="col" class="table_header_text" style="color:black">PAID ($)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->OrderItems as $OrderItem)
                                    @php
                                        $visibility = true;
                                    @endphp
                                    @foreach ($OrderItem->OrderItemDetails as $OrderItemDetail)
                                        <tr style="border-bottom: 1px solid #DEDEDE;">
                                            <td scope="col" class="table_body">
                                                
                                                    {{ $OrderItem->ProductDetails->product_name }} (PRO - {{ $OrderItem->ProductDetails->product_id }})

                                            </td>
                                            <td scope="col" class="table_body">{{ $OrderItemDetail->SizeDetails ? ($OrderItemDetail->SizeDetails->size_name ?? '-') : '-' }}</td>
                                            <td scope="col" class="table_body">{{ $OrderItem->ProductDetails->set_individual_name == 1 ? $OrderItemDetail->player_name ?? '-' : '' }}</td>
                                            <td scope="col" class="table_body">{{ $OrderItem->ProductDetails->set_individual_number == 1 ? $OrderItemDetail->player_number ?? '-' : '' }}</td>
                                            <td scope="col" class="table_body">{{ $OrderItemDetail->qty }}</td>
                                            <td scope="col" class="table_body text-right">{{ $OrderItemDetail->paid_amount }}</td>
                                        </tr>
                                        @php
                                            $visibility = false;
                                        @endphp
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Mobile Only Layout -->
        <div class="mobile-only">
            <!-- 1. Summary Stats -->
            <div class="mobile-summary-row">
                <div class="mobile-summary-box">
                    <div class="mobile-summary-label">Products</div>
                    <div class="mobile-summary-val">
                        {{ optional($store->StoreOrders->map->OrderItems->flatten())->sum('qty') ?: '0' }}
                    </div>
                </div>
                <div class="mobile-summary-box">
                    <div class="mobile-summary-label">Orders</div>
                    <div class="mobile-summary-val">
                        {{ optional($store->StoreOrders)->count() ?: '0' }}
                    </div>
                </div>
            </div>

            <!-- 2. Buttons Row -->
            <div class="mobile-actions-row">
                <button type="button" class="mobile-btn mobile-btn-roster" data-toggle="modal" data-target="#updateRosterModal">
                    Update Roster
                </button>
                <button type="button" class="mobile-btn mobile-btn-csv download-csv-all">
                    <i class="fa fa-file-excel-o"></i> CSV
                </button>
                <button type="button" class="mobile-btn mobile-btn-pdf download-pdf-all">
                    <i class="fa fa-file-pdf-o"></i> PDF
                </button>
            </div>

            <!-- 3. Search Bar -->
            <div class="mobile-search-wrapper">
                <i class="fa fa-search mobile-search-icon"></i>
                <input type="text" id="mobile-player-search" class="mobile-search-input" placeholder="Search player name or order number...">
            </div>

            <!-- 4. Player cards list -->
            <div id="mobile_players_list">
                @foreach ($store->StoreOrders as $key => $order)
                    @php
                        $firstName = $order->storeCustomer->first_name ?? '';
                        $lastName = $order->storeCustomer->last_name ?? '';
                        $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));

                        $totalQty = $order->OrderItems->sum('qty');
                    @endphp
                    <div class="mobile-player-card player-report-div"
                         data-name="{{ strtolower($order->storeCustomer->first_name ." ". $order->storeCustomer->last_name) }}"
                         data-order-id="{{ strtolower($order->order_no ?? '') }}">

                        <!-- Card Header -->
                        <div class="mobile-player-header" onclick="togglePlayerCard(this)">
                            <div class="mobile-player-profile">
                                <div class="mobile-avatar">{{ $initials }}</div>
                                <div>
                                    <div class="mobile-player-title player-name">{{ $order->storeCustomer->first_name ." ". $order->storeCustomer->last_name }}</div>
                                    <div class="mobile-player-subtitle order-number">Order #{{ $order->order_no ?? 'N/A' }}</div>
                                    <div class="mobile-badges-row">
                                        <span class="mobile-badge">{{ $order->payment_method ?? 'CARD' }}</span>
                                        <span class="mobile-badge">{{ $order->shippingMethodDetails->shipping_method_name ?? 'Pick Up' }}</span>
                                        <span class="mobile-badge green">Qty {{ $totalQty }}</span>
                                    </div>
                                </div>
                            </div>
                            <i class="fa fa-chevron-down text-muted mobile-card-chevron"></i>
                        </div>

                        <!-- Card Content (collapsible) -->
                        <div class="mobile-player-content" style="display: none;">
                            <div class="mobile-section-title">Order Information</div>
                            <div class="mobile-info-table">
                                <div class="mobile-info-row">
                                    <span class="mobile-info-label">Billing Name</span>
                                    <span class="mobile-info-val blue">{{ $order->storeCustomer->first_name ." ". $order->storeCustomer->last_name }}</span>
                                </div>
                                <div class="mobile-info-row">
                                    <span class="mobile-info-label">Payment Method</span>
                                    <span class="mobile-info-val">{{ $order->payment_method ?? 'N/A' }}</span>
                                </div>
                                <div class="mobile-info-row">
                                    <span class="mobile-info-label">Order Date</span>
                                    <span class="mobile-info-val">{{ $order->created_at ? $order->created_at->copy()->setTimezone('America/Los_Angeles')->format('d M Y g:i a T') : 'N/A' }}</span>
                                </div>
                                <div class="mobile-info-row">
                                    <span class="mobile-info-label">Shipping Method</span>
                                    <span class="mobile-info-val">{{ $order->shippingMethodDetails->shipping_method_name ?? 'N/A' }}</span>
                                </div>
                                <div class="mobile-info-row" style="grid-template-columns: 80px 1fr;">
                                    <span class="mobile-info-label">Shipping Address</span>
                                    <span class="mobile-info-val" style="text-align: right; line-height: 1.4;">
                                        {{ $order->storeCustomer->street }}, {{ $order->storeCustomer->city }}, {{ $order->storeCustomer->state }}, {{ $order->storeCustomer->postal_code }}, {{ $order->storeCustomer->country }}
                                    </span>
                                </div>
                            </div>

                            <div class="mobile-section-title">Purchased Products</div>
                            @foreach ($order->OrderItems as $OrderItem)
                                @foreach ($OrderItem->OrderItemDetails as $OrderItemDetail)
                                    <div class="mobile-product-card">
                                        <div class="mobile-product-name">{{ $OrderItem->ProductDetails->product_name }}</div>
                                        <div class="mobile-product-code">(PRO-{{ $OrderItem->ProductDetails->product_id }})</div>

                                        <div class="mobile-product-grid">
                                            <div class="mobile-product-field">
                                                <div class="mobile-field-label">Size</div>
                                                <div class="mobile-field-val">{{ $OrderItemDetail->SizeDetails ? ($OrderItemDetail->SizeDetails->size_name ?? '-') : '-' }}</div>
                                            </div>
                                            <div class="mobile-product-field">
                                                <div class="mobile-field-label">Quantity</div>
                                                <div class="mobile-field-val">{{ $OrderItemDetail->qty }}</div>
                                            </div>
                                            <div class="mobile-product-field">
                                                <div class="mobile-field-label">Player Name</div>
                                                <div class="mobile-field-val">
                                                    {{ $OrderItem->ProductDetails->set_individual_name == 1 ? $OrderItemDetail->player_name ?? '-' : '-' }}
                                                </div>
                                            </div>
                                            <div class="mobile-product-field">
                                                <div class="mobile-field-label">Player Number</div>
                                                <div class="mobile-field-val">
                                                    {{ $OrderItem->ProductDetails->set_individual_number == 1 ? $OrderItemDetail->player_number ?? '-' : '-' }}
                                                </div>
                                            </div>
                                        </div>

                                        <div style="border-top: 1px dashed #f0f0f0; padding-top: 8px; margin-top: 8px; display: flex; justify-content: space-between; align-items: center;">
                                            <span class="mobile-product-price-label">Paid</span>
                                            <span class="mobile-product-price-val">${{ number_format($OrderItemDetail->paid_amount, 2) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach

                            <!-- Actions Row -->
                            <div class="mobile-actions-footer">
                                <button type="button" class="mobile-footer-btn send-email">
                                    <i class="fa fa-share-alt"></i> Share
                                </button>
                                <button type="button" class="mobile-footer-btn download-pdf">
                                    <i class="fa fa-download"></i> Download
                                </button>
                                <button type="button" class="mobile-footer-btn print-pdf">
                                    <i class="fa fa-print"></i> Print
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel">Share with Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <input type="email" class="form-control" id="email_input" placeholder="Enter email">
                <button class="btn btn-primary mt-2" id="send_email_button">Send</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="updateRosterModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Update Player Roster</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <!-- DOWNLOAD CSV -->
                <a href="{{ route('store.player_report.download_csv', $store->id) }}"
                   class="btn btn-primary w-100 mb-3">
                    <i class="fa fa-download mr-2"></i> Download CSV
                </a>

                <!-- UPLOAD CSV -->
                <form action="{{ route('store.player_report.upload_csv', $store->id) }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf

                    <label><b>Upload Updated CSV</b></label>
                    <input type="file" name="csv_file" class="form-control mb-3" required>

                    <button type="submit" class="btn btn-success w-100">
                        <i class="fa fa-upload mr-2"></i> Upload & Update
                    </button>
                </form>

            </div>

        </div>
    </div>
</div>


<!-- Include jsPDF and html2canvas -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
    $(document).ready(function () {
        $(document).on("keyup", "#player-search, #mobile-player-search", function () {
            let value = $(this).val().toLowerCase().trim();

            // Filter desktop divs
            $(".desktop-only .player-report-div").each(function () {
                let name = $(this).find(".player-name").text().toLowerCase();
                let orderNo = $(this).find(".order-number").text().toLowerCase();

                $(this).toggle(
                    name.includes(value) || orderNo.includes(value)
                );
            });

            // Filter mobile cards
            $(".mobile-player-card").each(function () {
                let name = ($(this).attr("data-name") || "").toLowerCase();
                let orderNo = ($(this).attr("data-order-id") || "").toLowerCase();

                $(this).toggle(
                    name.includes(value) || orderNo.includes(value)
                );
            });
        });

        async function getReportCanvas(element) {
            // Clone and prepare offscreen desktop layout
            let $clone = $(element).clone();

            // Clean up action buttons
            $clone.find(".share_btn_div, .mobile-actions-footer").remove();

            // Position offscreen, with standard desktop-like width
            $clone.css({
                position: 'absolute',
                left: '-9999px',
                top: '0',
                width: '1100px',
                background: '#ffffff',
                display: 'block'
            });

            // Add to DOM temporarily
            $("body").append($clone);

            try {
                let canvas = await html2canvas($clone[0], {
                    scale: 3,
                    useCORS: true,
                    logging: false
                });
                return canvas;
            } finally {
                $clone.remove();
            }
        }

        function drawCanvasToPDF(doc, canvas, isFirstPage) {
            let imgData = canvas.toDataURL('image/jpeg', 1.0);
            let pageWidth = 210;
            let pageHeight = 297;
            let margin = 10;
            let imgWidth = pageWidth - (margin * 2);
            let imgHeight = (canvas.height * imgWidth) / canvas.width;

            let heightLeft = imgHeight;
            let position = margin;

            if (!isFirstPage) {
                doc.addPage();
            }

            doc.addImage(imgData, 'JPEG', margin, position, imgWidth, imgHeight, '', 'FAST');
            heightLeft -= (pageHeight - margin * 2);

            while (heightLeft > 0) {
                position = heightLeft - imgHeight + margin;
                doc.addPage();
                doc.addImage(imgData, 'JPEG', margin, position, imgWidth, imgHeight, '', 'FAST');
                heightLeft -= (pageHeight - margin * 2);
            }
        }

        $(".download-pdf").click(async function () {
            $(".se-pre-con").fadeIn('slow'); // Show loading spinner

            try {
                var currentDiv = $(this).closest(".player-report-div");
                if (currentDiv.length === 0) {
                    alert("No player report found!");
                    $(".se-pre-con").fadeOut('slow');
                    return;
                }

                var orderId = currentDiv.attr("data-order-id") || currentDiv.find(".order-number").text().replace("Order #", "").trim().toLowerCase();
                var targetDiv = $(".desktop-only .player-report-div[data-order-id='" + orderId + "']");
                if (targetDiv.length === 0) {
                    targetDiv = currentDiv;
                }

                let canvas = await getReportCanvas(targetDiv[0]);
                let { jsPDF } = window.jspdf;
                let doc = new jsPDF('p', 'mm', 'a4');

                drawCanvasToPDF(doc, canvas, true);

                doc.save("player_report_" + orderId + ".pdf");

            } catch (error) {
                console.error("Error generating PDF:", error);
            }

            $(".se-pre-con").fadeOut('slow'); // Hide loading spinner after processing
        });

        $(".download-pdf-all").click(async function () {
            $(".se-pre-con").fadeIn('slow'); // Show loading spinner

            try {
                let playerReports = $(".desktop-only .player-report-div");

                if (playerReports.length === 0) {
                    alert("No reports found!");
                    $(".se-pre-con").fadeOut('slow');
                    return;
                }

                let { jsPDF } = window.jspdf;
                let doc = new jsPDF('p', 'mm', 'a4');
                let pagesAdded = 0;

                for (let i = 0; i < playerReports.length; i++) {
                    if ($(playerReports[i]).css('display') === 'none') {
                        continue;
                    }
                    let canvas = await getReportCanvas(playerReports[i]);
                    drawCanvasToPDF(doc, canvas, pagesAdded === 0);
                    pagesAdded++;
                }

                if (pagesAdded === 0) {
                    alert("No reports visible to download!");
                    $(".se-pre-con").fadeOut('slow');
                    return;
                }

                doc.save("all_player_reports.pdf");

            } catch (error) {
                console.error("Error generating PDF:", error);
            }

            $(".se-pre-con").fadeOut('slow'); // Hide loading spinner after processing
        });
        $('.download-csv-all').on('click', function (e) {
            e.preventDefault();
            $(".se-pre-con").fadeIn('slow');

            let storeId = '{{$store->id}}';

            if (!storeId) {
                $(".se-pre-con").fadeOut('slow');
                Swal.fire("Error", "Store ID not found!", "error");
                return;
            }

            $.ajax({
                url: "{{ route('store.generateStorePlayerReportCSV') }}",
                type: "GET",
                data: { store_id: storeId },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function (data, status, xhr) {

                    $(".se-pre-con").fadeOut('slow');

                    let filename = xhr.getResponseHeader('Content-Disposition')
                        ?.split('filename=')[1]
                        ?.replace(/"/g, '') || "Player_Report.csv";

                    let blob = new Blob([data], { type: 'text/csv' });
                    let link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = filename;
                    link.click();
                },
                error: function () {
                    $(".se-pre-con").fadeOut('slow');
                    Swal.fire("Error", "Unable to download CSV!", "error");
                }
            });
        });

        // Toggle mobile card expansion
        window.togglePlayerCard = function(element) {
            let card = $(element).closest('.mobile-player-card');
            let content = card.find('.mobile-player-content');
            let chevron = card.find('.mobile-card-chevron');

            if (content.is(':visible')) {
                content.slideUp(200);
                chevron.removeClass('fa-chevron-up').addClass('fa-chevron-down');
            } else {
                content.slideDown(200);
                chevron.removeClass('fa-chevron-down').addClass('fa-chevron-up');
            }
        };

        // Hook up print & share actions
        $(document).on('click', '.print-pdf', function (e) {
            e.preventDefault();
            // var playerReportDiv = $(this).closest(".player-report-div");
            // if (playerReportDiv.length === 0) return;

            // var printContents = playerReportDiv.clone();
            var currentDiv = $(this).closest(".player-report-div");
            if (currentDiv.length === 0) return;

            var orderId = currentDiv.attr("data-order-id") || currentDiv.find(".order-number").text().replace("Order #", "").trim().toLowerCase();
            var targetDiv = $(".desktop-only .player-report-div[data-order-id='" + orderId + "']");
            if (targetDiv.length === 0) {
                targetDiv = currentDiv;
            }

            var printContents = targetDiv.clone();
            printContents.find(".mobile-actions-footer, .share_btn_div").remove();

            var printWindow = window.open('', '_blank');
            printWindow.document.write('<html><head><title>Print Player Report</title>');
            $('style, link[rel="stylesheet"]').each(function() {
                printWindow.document.write($(this).clone().get(0).outerHTML);
            });
            printWindow.document.write('<style>.desktop-only { display: block !important; } .player_details_div { display: block !important; } table { width: 100% !important; border-collapse: collapse; } th, td { padding: 6px 10px; font-size: 13px; }</style>');
            printWindow.document.write('</head><body>');
            // printWindow.document.write(printContents.html());
            printWindow.document.write('<div style="width: 100%; background: #ffffff;">' + printContents.html() + '</div>');
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();
            setTimeout(function() {
                printWindow.print();
                printWindow.close();
            }, 600);
        });

        $(document).on('click', '.send-email', function (e) {
            e.preventDefault();
            $('#shareModal').modal('show');
        });
    });

</script>

@endsection
@section('content')
    @include('pages.stores.layouts.sidebar', ['sub_content' => 'overview'])
@endsection
