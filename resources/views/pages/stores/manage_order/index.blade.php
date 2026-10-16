@extends('layouts.app', ['activePage' => 'Team Stores', 'titlePage' => __('Team Stores')])

@section('sub-sidebar-content')

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
    .export_csv, .create_shipment, .add_order {
        width: 125px;
        height: 34px;
        background-color: #F8F8F8;
        border: 1px solid #DEDEDE;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        color: #B3B3B3;
    }
    .export_shippo_csv {
        width: 125px;
        height: 34px;
        background-color: #F8F8F8;
        border: 1px solid #a6cbf5;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        color: #a6cbf5;
    }
    .export_csv_div {
        margin-right: 15px;
        padding: 15px;
        padding-bottom: unset;
    }
    .manage_order_topic {
        font-size: 18px;
    }
    .card_div {
        padding: 15px;
        padding-bottom: 5px;
    }
    .per_page {
        font-size: 11px;
        color: #717070;
        font-weight: 500;
        margin-bottom: unset;
    }
    .search_icon {
        padding-top: 3px;
        padding-right: 6px;
    }
    .search_input {
        height: 25px;
        border: unset;
        width: 160px;
    }
    .table_header_text {
        color: white;
        height: 25px;
    }
    .table td{
        padding: .5rem !important;
    }
    .select2-container{
        border: 0.5px solid #eaeaea !important;
    }
    .product_report {
        font-size: 18px;
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
    .header-style{
        font-size: 1rem;
        font-weight: 600;
    }
    .shipping-filter-box {
        background-color: #f1f4f8;
        padding: 15px 20px;
        border-radius: 4px;
    }

    .filter-title {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 8px;
        color: #333;
    }

    /* Single row container */
    .filter-options-row {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .filter-option {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #333;
        cursor: pointer;
    }

    /* Dark green button */
    .filter-btn {
        background-color: #1f7a3a;
        color: #ffffff;
        border: none;
        padding: 5px 18px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 3px;
        white-space: nowrap;
    }

    .filter-btn:hover {
        background-color: #176230;
    }
    .search-box {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        border: 1px solid #ced4da;
    }

    .search-box {
        background: #fff;
        border: 1px solid #e9ecef;
        transition: all 0.2s ease;
    }

    .search-box:focus-within {
        border-color: #5e72e4; /* Argon primary */
        box-shadow: 0 0 0 0.15rem rgba(94, 114, 228, 0.15);
    }

    .search-dropdown {
        position: absolute;
        top: calc(100% + 10px);
        left: 0;
        width: 100%;
        min-width: 700px;
        z-index: 1050;
        border-radius: 0.75rem;
        overflow: hidden;
        background: #fff;
    }

    .search-dropdown-body {
        min-height: 380px;
        max-height: 500px;
    }

    .search-sidebar {
        width: 180px;
        background: #f8f9fe;
        padding: 0.75rem 0;
        display: flex;
        flex-direction: column;
    }

    .search-sidebar .custom-tab {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 0.9rem 1rem;
        color: #525f7f;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
        border-left: 3px solid transparent;
        transition: all 0.2s ease;
    }

    .search-sidebar .custom-tab:hover {
        background: rgba(94, 114, 228, 0.08);
        color: #5e72e4;
    }

    .search-sidebar .custom-tab.active {
        background: #fff;
        color: #5e72e4;
        border-left-color: #5e72e4;
        font-weight: 600;
    }

    .search-content {
        background: #fff;
        min-width: 0;
    }

    .search-pane-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #edf2f7;
        background: #fff;
    }

    .results-list {
        max-height: 420px;
        overflow-y: auto;
    }

    .results-list .list-group-item {
        border: 0;
        border-bottom: 1px solid #f1f3f5;
        padding: 0.9rem 1.25rem;
    }

    .results-list .list-group-item:last-child {
        border-bottom: 0;
    }

    .result-item {
        display: flex;
        justify-content: space-between;
        align-items: start;
        gap: 12px;
    }

    .result-main {
        min-width: 0;
    }

    .result-title {
        font-weight: 600;
        color: #32325d;
        margin-bottom: 2px;
        font-size: 0.95rem;
    }

    .result-subtitle {
        font-size: 0.85rem;
        color: #8898aa;
        margin-bottom: 0;
    }

    /* ===== Responsive utilities ===== */
    @media (min-width: 768px) {
        .mobile-only { display: none !important; }
    }
    @media (max-width: 767px) {
        .bg-box.container-fluid.fix-nav.header-layout{
            margin-bottom: 0 !important;
        }
        .desktop-only { display: none !important; }
        .main_card {
            background-color: transparent !important;
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            margin-top: 10px !important;
        }
        /* Mobile summary stats */
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
            box-shadow: 0 1px 3px rgba(0,0,0,.05);
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
        /* Mobile top action buttons */
        .mobile-top-actions {
            /* display: grid; */
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 12px;
        }
        .mobile-top-btn,
        .mobile-created-badge {
            flex: 1 1 30%;
            min-width: 0;
            height: 40px;
            border-radius: 8px;
            font-size: 11.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            background: #fff;
            cursor: pointer;
            border: 1px solid #e5e5e5;
            color: #495057;
            text-decoration: none !important;
            padding: 0 6px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .mobile-top-btn.green  { background: #17a589; color: #fff; border-color: #17a589; }
        .mobile-top-btn.blue   { background: #3b82f6; color: #fff; border-color: #3b82f6; }
        .mobile-top-btn.grey   { background: #717070; color: #fff; border-color: #717070; }
        .mobile-top-btn.yellow { background: #d6a347; color: #fff; border-color: #d6a347; }
        .mobile-top-btn.olive  { background: #a3a721; color: #fff; border-color: #a3a721; }
    
        .mobile-created-badge {
            background: #e6f9f3;
            color: #17a589;
            border: 1.5px solid #17a589;
        }
        
        /* Row 2 — shipment action buttons, hidden by default */
        .mobile-shipment-actions {
            display: none;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 12px;
        }
        .mobile-shipment-actions.visible { display: grid; }
        .mobile-shipment-btn {
            width: 100%;
            box-sizing: border-box;
            height: 38px;
            min-width: 0;
            border-radius: 8px;
            font-size: 11.5px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            border: none;
            cursor: pointer;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding: 0 6px;
        }
        .mobile-shipment-btn.green-solid { background: #1f9d55; color: #fff; }
        .mobile-shipment-btn.teal-solid  { background: #17a589; color: #fff; }
        
        .container-fluid.mb-5 { padding-top: 6px !important; }
        
        /* Shipping filter (mobile) */
        .mobile-filter-box {
            background: #fff;
            /* background: #f1f4f8; */
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 12px;
        }
        .mobile-filter-title {
            font-size: 12px;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }
        .mobile-filter-options {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 10px;
        }
        .mobile-filter-opt {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: #333;
            cursor: pointer;
        }
        .mobile-filter-btn {
            width: 100%;
            height: 36px;
            background: #1f7a3a;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
        }
        /* Mobile search */
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
            box-shadow: 0 1px 3px rgba(0,0,0,.05);
        }
        .mobile-search-icon {
            position: absolute;
            left: 12px;
            top: 13px;
            color: #999;
        }
        /* Select All row */
        .mobile-select-all-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 6px 2px 10px;
            font-size: 13px;
            color: #6c757d;
            font-weight: 600;
        }
        /* Order cards */
        .mobile-order-card {
            background: #fff;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 12px;
            border: 1px solid #edf1f5;
            box-shadow: 0 2px 6px rgba(0,0,0,.05);
        }
        .mobile-order-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .mobile-order-card-left {
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }
        .mobile-order-card-left input[type='checkbox'] {
            width: 16px;
            height: 16px;
            margin-top: 3px;
        }
        .mobile-order-title {
            font-size: 14px;
            font-weight: 700;
            color: #212529;
        }
        .mobile-order-title a {
            color: #212529 !important;
            text-decoration: none !important;
        }
        .mobile-order-date {
            font-size: 12px;
            color: #8a94a6;
            margin-top: 2px;
        }
        .mobile-shipment-badge {
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }
        .mobile-shipment-badge.created { color: #1f9d55; }
        .mobile-shipment-badge.not-created { color: #e34848; }
        /* Info grid */
        .mobile-order-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px 14px;
            margin-bottom: 12px;
        }
        .mobile-field-label {
            font-size: 10px;
            color: #8a94a6;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .03em;
            display: block;
            margin-bottom: 2px;
        }
        .mobile-field-val {
            font-size: 13px;
            font-weight: 600;
            color: #212529;
        }
        .mobile-field-val.green { color: #1f9d55; }
        /* Footer row */
        .mobile-order-footer {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 4px;
        }
        .mobile-order-footer select.status-change {
            flex: 1;
            font-size: 12px;
            padding: 7px 8px;
            border-radius: 8px;
            border: none;
        }
        .mobile-view-btn {
            flex: 1;
            text-align: center;
            background: #eef1f5;
            color: #495057;
            border: none;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            padding: 8px 10px;
            text-decoration: none !important;
            display: inline-block;
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


<div class="container-fluid mb-5" style="background-color: transparent;padding: 0 !important;">
    <div class="se-pre-con"></div>

    @include('pages.stores.layouts.top_header')

    @yield('stores_header')

    <div class="card col-lg-12 main_card" style="margin-top: 20px;">
        <!-- ===== DESKTOP ONLY ===== -->
        <div class="desktop-only">
            <div class="row align-items-center mt-2">

                <!-- 🧾 Manage Orders -->
                <div class="col-md-4">
                    <div class="card_div">
                        <strong class="manage_order_topic d-block">
                            Manage Orders
                            @if(!empty($tsr_order_no))
                                -
                                <a style="color: black;" href="{{ route('orders.info', [
                                        'id' => $TSRorderID,
                                        'type' => 'order'
                                    ]) . '?active_tab=order' }}" target="_blank">
                                    {{ $tsr_order_no }}
                                </a>
                            @endif
                        </strong>
                    </div>
                </div>

                <!-- ⚙️ Actions -->
                <div class="col-md-8 text-right">

                    @if (empty($tsr_order_no) && $orders->count() > 0)
                        @php
                            $statusClass = $store->store_status == 2 ? 'make_tsr_order' : ($store->store_status == 1 ? 'store_open_alert' : 'store_archived_alert');
                        @endphp
                        <button type="button" class="{{ $statusClass }} view_store_btn">
                            <i class="fa fa-download mr-1"></i>MAKE ORDER ({{$orders->count()}})
                        </button>

                    @elseif(!empty($tsr_order_no) && $pendingOrdersCount > 0)

                        <button type="button" class="make_tsr_order view_store_btn" style="background-color: #d6a347;">
                            <i class="fa fa-spinner mr-1"></i>PENDING ITEMS ({{$pendingOrdersCount}})
                        </button>

                    @elseif(!empty($tsr_order_no) && $updatedCount > 0 && $TSRorderCanUpdate)

                        <form action="{{ route('store.updateTSR') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="tsr_order_no" value="{{ $tsr_order_no }}">
                            <input type="hidden" name="store_id" value="{{ $store->id }}">

                            <button type="submit" class="view_store_btn updateTSRBtn"
                                    style="background-color: #a3a721; color:#fff;">
                                UPDATE ({{ $updatedCount }})
                            </button>
                        </form>

                    @else

                        <span class="status-label">
                            <i class="fa fa-check mr-1"></i> CREATED
                        </span>

                    @endif

                    <button class="create_shipment" style="width: auto;display:none"><i class="fa fa-plus mr-1"></i>CREATE SHIPMENT <span id="checked_order_count">(0)</span></button>
                    <button class="export_shippo_csv" style="width: auto;display:none"><i class="fa fa-plus mr-1"></i>EXPORT SHIPPO <span id="checked_order_count_csv">(0)</span></button>

                    <button class="add_order view_store_btn ms-2" style="background-color: #90cbe7;">
                        <i class="fa fa-plus mr-1"></i> ADD ORDER
                    </button>

                    <button class="export_csv view_store_btn ms-2" style="background-color: #b9b9b9;">
                        <i class="fa fa-file-excel mr-1"></i> EXPORT CSV
                    </button>

                </div>

            </div>

            <div class="row">
                <div class="" style="padding-left: 15px;">
                    <div class="row" style="padding: 15px;">
                        <div class="qty_div">
                            <p class="total_qty_text">Total quantity of products</p>
                        </div>
                        <div class="qty_div2">
                            <p class="total_qty_text" style="color: #717070;">
                                {{ optional($store->StoreOrders->map->OrderItems->flatten())->sum('qty') ?: 'N/A' }}
                            </p>
                        </div>
                        <div class="qty_div">
                            <p class="total_qty_text">Total number of orders</p>
                        </div>
                        <div class="qty_div2">
                            <p class="total_qty_text" style="color: #717070;">
                                {{ optional($store->StoreOrders)->count() ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shipping-filter-box">
                <div class="filter-title">Filter By Shipping Method</div>

                <div class="filter-options-row">
                    <label class="filter-option">
                        <input type="radio"
                            class="shipping_method_filter"
                            data-value="all"
                            name="shipping_method_filter"
                            {{  request()->get('shipping_method') == null ? 'checked' : '' }}>
                        <span>All</span>
                    </label>

                    @foreach ($store->StoreAddedShippingMethods as $shipping_method)
                        <label class="filter-option">
                            <input type="radio"
                                class="shipping_method_filter"
                                data-value="{{ $shipping_method->shippingMethod->id }}"
                                name="shipping_method_filter" {{  request()->get('shipping_method') == $shipping_method->shippingMethod->id ? 'checked' : '' }}>
                            <span>{{ $shipping_method->shippingMethod->shipping_method_name }}</span>
                        </label>
                    @endforeach

                    <button class="btn filter-btn" id="filter_shipping_methods">
                        Filter
                    </button>
                </div>
            </div>

            <hr style="margin: unset; margin-bottom: 10px;">

        </div>

        <!-- ===== MOBILE ONLY ===== -->
        <div class="mobile-only">

            <!-- Summary Stats -->
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

            <!-- Action Buttons Row 1 -->
            <div class="mobile-top-actions">
                @if (empty($tsr_order_no) && $orders->count() > 0)
                    @php
                        $mobileStatusClass = $store->store_status == 2 ? 'make_tsr_order' : ($store->store_status == 1 ? 'store_open_alert' : 'store_archived_alert');
                    @endphp
                    <button type="button" class="mobile-top-btn green {{ $mobileStatusClass }}">
                        <i class="fa fa-download"></i> Make Order
                    </button>
                @elseif(!empty($tsr_order_no) && $pendingOrdersCount > 0)
                    <button type="button" class="mobile-top-btn yellow make_tsr_order">
                        <i class="fa fa-spinner"></i> Pending ({{ $pendingOrdersCount }})
                    </button>
                @elseif(!empty($tsr_order_no) && $updatedCount > 0 && $TSRorderCanUpdate)
                    <form action="{{ route('store.updateTSR') }}" method="POST" class="d-inline" style="flex:1.2;">
                        @csrf
                        <input type="hidden" name="tsr_order_no" value="{{ $tsr_order_no }}">
                        <input type="hidden" name="store_id" value="{{ $store->id }}">
                        <button type="submit" class="mobile-top-btn olive w-100">
                            <i class="fa fa-refresh"></i> Update ({{ $updatedCount }})
                        </button>
                    </form>
                @else
                    <span class="mobile-created-badge">
                        <i class="fa fa-check"></i> Created
                    </span>
                @endif
                <button class="mobile-top-btn blue add_order"><i class="fa fa-plus"></i> Add Orders</button>
                <button class="mobile-top-btn grey export_csv"><i class="fa fa-file-excel-o"></i> Export CSV</button>
            </div>

            <!-- Action Buttons Row 2 (shown when items selected) -->
            <div class="mobile-shipment-actions" id="mobile_shipment_row">
                <button class="mobile-shipment-btn green-solid create_shipment" id="mobile_create_shipment_btn">
                    <i class="fa fa-plus"></i> Create Shipment <span id="checked_order_count_m">(0)</span>
                </button>
                <button class="mobile-shipment-btn teal-solid export_shippo_csv" id="mobile_export_shippo_btn">
                    <i class="fa fa-download"></i> Export Shippo <span id="checked_order_count_csv_m">(0)</span>
                </button>
            </div>

            <!-- Shipping Filter -->
            <div class="mobile-filter-box">
                <div class="mobile-filter-title">Filter By Shipping Method</div>
                <div class="mobile-filter-options">
                    <label class="mobile-filter-opt">
                        <input type="radio" class="shipping_method_filter_m" data-value="all" name="shipping_method_filter_m" {{ request()->get('shipping_method') == null ? 'checked' : '' }}>
                        <span>All</span>
                    </label>
                    @foreach ($store->StoreAddedShippingMethods as $sm)
                        <label class="mobile-filter-opt">
                            <input type="radio" class="shipping_method_filter_m" data-value="{{ $sm->shippingMethod->id }}" name="shipping_method_filter_m" {{ request()->get('shipping_method') == $sm->shippingMethod->id ? 'checked' : '' }}>
                            <span>{{ $sm->shippingMethod->shipping_method_name }}</span>
                        </label>
                    @endforeach
                </div>
                <button class="mobile-filter-btn" id="mobile_filter_shipping">Filter</button>
            </div>

            <!-- Search -->
            <div class="mobile-search-wrapper">
                <i class="fa fa-search mobile-search-icon"></i>
                <input type="text" id="mobile_order_search" class="mobile-search-input" placeholder="Search orders...">
            </div>

            <!-- Select All Row -->
            <div class="mobile-select-all-row">
                <label style="display:flex;align-items:center;margin:0;gap:8px;font-weight:600;font-size:13px;color:#4b5563;">
                    <input type="checkbox" id="select_all_orders_mobile" style="width:17px;height:17px;">
                    Select All
                </label>
                <span style="font-size:12px;color:#6c757d;">{{ $orders->count() }} order{{ $orders->count() == 1 ? '' : 's' }}</span>
            </div>

            <!-- Order Cards -->
            @if($orders->count() > 0)
                @foreach ($orders as $order)
                @php
                    $hasShipment = !empty($order->ShipmentDetails) && $order->ShipmentDetails->count() > 0;
                @endphp
                <div class="mobile-order-card" data-search-text="{{ strtolower($order->order_no . ' ' . $order->CustomerDetails->first_name . ' ' . $order->CustomerDetails->last_name) }}">
                    <div class="mobile-order-card-top">
                        <div class="mobile-order-card-left">
                            <input type="checkbox"
                                   data-order-no="{{ $order->order_no }}"
                                   class="order-select-checkbox-mobile mobile-card-checkbox"
                                   style="width:17px;height:17px;margin-top:3px;accent-color:#17a589;"
                                   {{ $hasShipment ? 'disabled' : '' }}>
                            <div>
                                <div class="mobile-order-title">
                                    <a href="{{ route('store.individual_player', $order->order_no) }}" target="_blank">Order #{{ $order->order_no }}</a>
                                </div>
                                <div class="mobile-order-date">{{ $order->created_at->format('m/d/Y') }}</div>
                            </div>
                        </div>
                        @if($hasShipment)
                            <span class="mobile-shipment-badge created"><i class="fa fa-check-circle"></i> Created</span>
                        @else
                            <span class="mobile-shipment-badge not-created"><i class="fa fa-times-circle"></i> Not Created</span>
                        @endif
                    </div>

                    <div class="mobile-order-grid">
                        <div>
                            <span class="mobile-field-label">Billing Name</span>
                            <span class="mobile-field-val">{{ $order->CustomerDetails->first_name }} {{ $order->CustomerDetails->last_name }}</span>
                        </div>
                        <div>
                            <span class="mobile-field-label">Payment Method</span>
                            <span class="mobile-field-val">{{ $order->payment_method }}</span>
                        </div>
                        <div>
                            <span class="mobile-field-label">Subtotal</span>
                            <span class="mobile-field-val">${{ $order->sub_total }}</span>
                        </div>
                        <div>
                            <span class="mobile-field-label">Shipping</span>
                            <span class="mobile-field-val">${{ $order->shipping }}</span>
                        </div>
                        <div>
                            <span class="mobile-field-label">Sales Tax</span>
                            <span class="mobile-field-val">${{ $order->sales_tax }}</span>
                        </div>
                        <div>
                            <span class="mobile-field-label">Other</span>
                            <span class="mobile-field-val">${{ $order->handling_fee }}</span>
                        </div>
                        <div>
                            <span class="mobile-field-label">Total</span>
                            <span class="mobile-field-val green">${{ $order->total }}</span>
                        </div>
                        <div>
                            <span class="mobile-field-label">Paid</span>
                            <span class="mobile-field-val">${{ $order->paid_invoice_amount }}</span>
                        </div>
                    </div>

                    <div class="mobile-order-footer">
                        <select class="status-change" disabled>
                            @foreach ($store_order_statuses as $store_order_status)
                                <option value="{{ $store_order_status->id }}" @if($order->order_status == $store_order_status->id) selected @endif data-color="{{ $store_order_status->color }}">{{ $store_order_status->status_name }}</option>
                            @endforeach
                        </select>
                        <a href="{{ route('store.individual_player', $order->order_no) }}" target="_blank" class="mobile-view-btn">View Details</a>
                    </div>
                </div>
                @endforeach
            @else
                <div style="text-align:center;padding:40px 10px;color:#8a94a6;font-size:13px;">No orders found.</div>
            @endif

        </div>

        <!-- Desktop table -->
        <div class="desktop-only" style="height: 75vh;overflow: scroll;">

            <table class="table align-items-center" id="manage_order">
                <thead style="background-color: #717070;">
                    <th scope="col" class="table_header_text text-center">
                        <input type="checkbox" id="select_all_orders">
                    </th>
                    <th scope="col" class="table_header_text text-center">ORDER ID</th>
                    <th scope="col" class="table_header_text text-center">DATE</th>
                    <th scope="col" class="table_header_text text-center">BILLING NAME</th>
                    <th scope="col" class="table_header_text text-center">STATUS</th>
                    <th scope="col" class="table_header_text text-right">SUBTOTAL ($)</th>
                    <th scope="col" class="table_header_text text-right">SHIPPING ($)</th>
                    <th scope="col" class="table_header_text text-right">SALES TAX ($)</th>
                    <th scope="col" class="table_header_text text-right">OTHER ($)</th>
                    <th scope="col" class="table_header_text text-right">TOTAL ($)</th>
                    <th scope="col" class="table_header_text text-right">PAID AMOUNT ($)</th>
                    <th scope="col" class="table_header_text text-center">PAYMENT METHOD</th>
                    <th scope="col" class="table_header_text text-center">SHIPMENT</th>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        @php
                            $hasShipment = !empty($order->ShipmentDetails) && $order->ShipmentDetails->count() > 0;
                        @endphp
                        <tr>
                            <td class="text-center">
                                <input type="checkbox"
                                       data-order-no="{{ $order->order_no }}"
                                       class="order-select-checkbox"
                                       {{ $hasShipment ? 'disabled' : '' }}>
                            </td>
                            <td class="text-center order-no">
                                <a href="{{ route('store.individual_player', $order->order_no) }}" target="_blank" class="text-decoration-none" style="color: black !important">{{ $order->order_no }}</a>
                            </td>
                            <td class="text-center">{{ $order->created_at->format('m/d/Y') }}</td>
                            <td class="text-center">{{$order->CustomerDetails->first_name}} {{$order->CustomerDetails->last_name}}</td>
                            <td class="text-center">
                                <select class="status-change" style="border: none;background-color: #e1e1e1;padding: .3rem;border-radius: .5rem;" disabled>
                                    @foreach ($store_order_statuses as $store_order_status)
                                        <option value="{{$store_order_status->id}}" @if ($order->order_status == $store_order_status->id) selected @endif data-color="{{$store_order_status->color}}">{{$store_order_status->status_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="text-right">{{$order->sub_total}}</td>
                            <td class="text-right">{{$order->shipping}}</td>
                            <td class="text-right">{{$order->sales_tax}}</td>
                            <td class="text-right">{{$order->handling_fee}}</td>
                            <td class="text-right">{{$order->total}}</td>
                            <td class="text-right">{{$order->paid_invoice_amount}}</td>
                            <td class="text-center">{{$order->payment_method}}</td>
                            <td class="text-center">
                                @if($hasShipment)
                                    <span style="color: green;">
                                        <i class="fa fa-check-circle"></i> Created
                                    </span>
                                @else
                                    <span style="color: red;">
                                        <i class="fa fa-times-circle"></i> Not Created
                                    </span>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</div>

<!-- Transaction Details Modal -->
<div class="modal fade" id="transactionDetailsModal" tabindex="-1" aria-labelledby="transactionDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transactionDetailsModalLabel">Transaction Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <div id="transactionDetailsContent" style="padding: 0rem 1rem;">
                    <p>Loading...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="create_team_store" tabindex="-1" role="dialog" aria-labelledby="modal-title-default" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <!-- Header -->
            <div class="modal-header bg-gradient-primary text-white py-3 px-4 d-flex justify-content-between align-items-center">
                <h5 class="modal-title font-weight-semibold mb-0" id="modal-title-default">
                    <i class="fas fa-store mr-2"></i> Create Team Store Order
                </h5>
                <button type="button" class="close text-white opacity-75" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Form -->
            <form action="{{ route('store.createTSR') }}" method="post" id="create_team_store_form" class="needs-validation" novalidate>
                @csrf
                <input type="hidden" name="store_id" value="{{ $store->id }}">
                <input type="hidden" name="tsr_order_no" value="{{ $tsr_order_no }}">

                <div class="modal-body py-4 px-5">
                    @if (!empty($tsr_order_no))
                        <div class="alert-info rounded-lg shadow-sm py-3" style="padding: 1rem;background-color: #e1fdc1;color: black;">
                            <strong>Note:</strong> You are creating a TSR order with the order number:
                            <strong class="text-primary">#{{ $tsr_order_no }}</strong>.
                        </div>

                        <div class="form-row mt-3">
                            <div class="form-group col-md-12">
                                <label class="font-weight-medium text-muted" for="due_date">In-Hand Due Date<span class="text-danger">*</span></label>
                                <input type="text" class="form-control shadow-sm datepicker" name="due_date" id="due_date" style="width: 10rem;" required>
                            </div>
                        </div>
                    @else
                        <div class="form-group">
                            <label class="font-weight-medium text-muted" for="organization_id">Organization <span class="text-danger">*</span></label>
                            <select class="form-control shadow-sm" id="organization_id" name="organization_id" disabled>
                                <option value="{{ $store->organizationDetails->id }}" selected>
                                    {{ $store->organizationDetails->organization_name }}
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-medium text-muted" for="customer_id">Contact Person <span class="text-danger">*</span></label>
                            <select class="form-control shadow-sm select-2-modal" id="customer_id" name="customer_id" required>
                                @foreach ($contacts as $contact)
                                    <option value="{{ $contact->id }}" {{ $contact->id == $store->contact_coach_id ? 'selected' : '' }}>
                                        {{ $contact->first_name }} {{ $contact->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="font-weight-medium text-muted" for="due_date">In-Hand Due Date<span class="text-danger">*</span></label>
                                <input type="text" class="form-control shadow-sm datepicker" name="due_date" id="due_date" style="width: 10rem;" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-medium text-muted" for="sales_rep_id">Sales Rep <span class="text-danger">*</span></label>
                            <select class="form-control shadow-sm select-2-modal" id="sales_rep_id" name="sales_rep_id" required>
                                <option value="">Select a Sales Rep</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $user->id == $store->salese_person ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>

                <!-- Footer -->
                <div class="modal-footer d-flex justify-content-between px-4 py-3 border-top">
                    <button type="button" class="btn btn-light border rounded-pill px-4 py-2" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </button>
                    <button type="submit" id="submit_order_creating" class="btn btn-success rounded-pill px-4 py-2 shadow-sm">
                        <i class="fas fa-plus-circle mr-1"></i> Add Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" style="font-size: large;">CREATE NEW ORDER #{{ $nextOrderNo }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <form id="add_order_form" method="POST" action="{{ route('store.save_new_order') }}">

                        @csrf

                    <input type="hidden" name="store_id" value="{{ $store->id }}">

                    <!-- BEGIN CONTENT YOU PROVIDED -->
                    <div class="row" style="padding-left: 15px;">

                        <!-- BILLING DETAILS -->
                        <div class="col-md-12 header-style mb-2">
                            Billing Details
                        </div>

                        <div class="col-md-12 customer-shipping-section mb-2 section_0">
                            <div class="row">
                                <input type="hidden" name="store_id" value="{{ $store->id }}">

                                <div class="col-md-6">
                                    <label>First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="first_name" required>
                                </div>

                                <div class="col-md-6">
                                    <label>Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="last_name" required>
                                </div>

                                <div class="col-md-4">
                                    <label>Street Address <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="street" required>
                                </div>

                                <div class="col-md-4">
                                    <label>City <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="city" required>
                                </div>

                                <div class="col-md-4">
                                    <label>State <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="state" required>
                                </div>

                                <div class="col-md-4">
                                    <label>Country <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="country" required>
                                </div>

                                <div class="col-md-4">
                                    <label>Postal Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="zip_code" required>
                                </div>

                                <div class="col-md-4">
                                    <label>Phone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="phone" required>
                                </div>

                                <div class="col-md-4">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>

                            </div>
                        </div>

                        <!-- SHIPPING SECTION -->
                        <div class="col-md-12 header-style mb-2 mt-3">
                            Shipping Details
                        </div>

                        <div class="col-md-12 mt-2">
                            <label><strong>Select Shipping Method:</strong></label><br>
                            @foreach ($store->StoreAddedShippingMethods as $key => $addedMethod)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input shipping-method-radio"
                                        type="radio"
                                        name="selected_shipping_method"
                                        id="shipping_method_{{ $addedMethod->shippingMethod->id }}"
                                        value="{{ $addedMethod->shippingMethod->id }}" {{ $key == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="shipping_method_{{ $addedMethod->shippingMethod->id }}">
                                        {{ $addedMethod->shippingMethod->shipping_method_name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-12 mt-3 same_as_billing_address">
                            <input type="checkbox" name="use_same_as_billing_address" id="use_same_as_billing_address" checked>
                            <label><strong>&nbsp;Use billing address as Shipping address</strong></label>
                        </div>

                        <!-- SHIPPING ADDRESS (HIDDEN) -->
                        <div class="col-md-12 header-style mb-2 mt-2 shipping-details-area" style="display:none;">
                            Shipping Address
                        </div>

                        <div class="col-md-12 customer-shipping-section mb-2 shipping-details-area" style="display:none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>First Name</label>
                                    <input type="text" name="shipping_first_name" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label>Last Name</label>
                                    <input type="text" name="shipping_last_name" class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <label>Street Address</label>
                                    <input type="text" name="shipping_street" class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <label>City</label>
                                    <input type="text" name="shipping_city" class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <label>State</label>
                                    <input type="text" name="shipping_state" class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <label>Country</label>
                                    <input type="text" name="shipping_country" class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <label>Postal Code</label>
                                    <input type="text" name="shipping_zip_code" class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <label>Phone</label>
                                    <input type="text" name="shipping_phone" class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <label>Email</label>
                                    <input type="email" name="shipping_email" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END CONTENT -->
                </form>

            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-success save-form-data btn-custom mt-2">Save & Continue</button>
                <button type="button" class="btn btn-dark btn-custom mt-2" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>




<script>
    $(document).ready(function(){
        $(".a_tag_onclick").on("click", function(){
            $(".se-pre-con").fadeIn('slow');
        });
        $("#submit_order_creating").on("click", function() {
            $(".se-pre-con").fadeIn('slow');
        });
        $('.datepicker').datepicker({ minDate: 0});
        $('#create_team_store').on('shown.bs.modal', function () {
            $(this).find('.select-2-modal').select2({
                dropdownParent: $('#create_team_store')
            });
        });
        $(document).on('click', '.add_order', function () {
            $('#addOrderModal').modal('show');
        });
        $(document).on('click', '#filter_shipping_methods', function () {

            let selectedMethod = $('.shipping_method_filter:checked').data('value');
            let baseUrl = window.location.pathname;

            let query = selectedMethod !== 'all'
                ? '?shipping_method=' + selectedMethod
                : '';

            window.location.href = baseUrl + query;
        });

        // Mobile filter button
        $(document).on('click', '#mobile_filter_shipping', function () {
            let selectedMethod = $('.shipping_method_filter_m:checked').data('value');
            let baseUrl = window.location.pathname;
            let query = selectedMethod !== 'all'
                ? '?shipping_method=' + selectedMethod
                : '';
            window.location.href = baseUrl + query;
        });

        // Mobile order search
        $(document).on('keyup', '#mobile_order_search', function () {
            var query = $(this).val().trim().toLowerCase();
            $('.mobile-order-card').each(function () {
                var text = ($(this).attr('data-search-text') || '').toLowerCase();
                $(this).toggle(text.indexOf(query) !== -1);
            });
        });
        function toggleShippingArea() {
            var shippingMethod = $('input[name="selected_shipping_method"]:checked').val();
            var isSameAsBilling = $('#use_same_as_billing_address').is(':checked');

            if (shippingMethod == '1') {

                $('.same_as_billing_address').show();

                if (isSameAsBilling) {
                    $('.shipping-details-area').hide();
                    $('.shipping-details-area input').attr('required', false);
                } else {
                    $('.shipping-details-area').show();
                    $('.shipping-details-area input').attr('required', true);
                }

            } else {

                $('.same_as_billing_address').hide();
                $('.shipping-details-area').hide();
                $('.shipping-details-area input').attr('required', false);
            }
        }

        $('#use_same_as_billing_address').on('change', function () {
            toggleShippingArea();
        });

        $('.shipping-method-radio').on('change', function () {
            var shippingMethod = $('input[name="selected_shipping_method"]:checked').val();

            if (shippingMethod == '1') {
                $('#use_same_as_billing_address').prop('checked', true);
            }

            toggleShippingArea();
        });

        // initial load
        toggleShippingArea();

        $('.status-change').each(function () {
            var selectedColor = $(this).find('option:selected').data('color');
            $(this).css('background-color', selectedColor);
        });

        $(document).on('change', '.status-change', function () {
            var selectedColor = $(this).find('option:selected').data('color');
            $(this).css('background-color', selectedColor);
        });
    });
    $(document).ready(function () {
        $('#manage_order').DataTable({
            paging: true,
            lengthMenu: [10, 25, 50, 100, 200],
            pageLength: 50,
            searching: true,
            ordering: false,
        });
            var $tableRows = $('#manage_order tbody tr');

        // $('.search_input').on('input', function () {
        //     var filterValue = $(this).val().trim().toLowerCase();

        //     if (filterValue === "") {
        //         $tableRows.show();
        //     } else {
        //         $tableRows.each(function () {
        //             var orderNo = $(this).find('td.order-no').text().trim().toLowerCase();
        //             if (orderNo.includes(filterValue)) {
        //                 $(this).show();
        //             } else {
        //                 $(this).hide();
        //             }
        //         });
        //     }
        // });

        $('.make_tsr_order').on('click', function () {
            $('#create_team_store').modal('show');
        });
        $('body').on('click', '.updateTSRBtn', function () {
            let formId = $(this).closest('form').attr('id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'This will update the TSR order details.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.value) {
                    $('.se-pre-con').fadeIn('slow');
                    document.getElementById(formId).submit();
                }
            });
        });
        $('.save-form-data').on('click', function () {
            var form = $('#add_order_form')[0]; // get native form element
            var isValid = true;

            // Validate all inputs and selects inside the form
            $(form).find('input, select').each(function () {
                if (!this.checkValidity()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            if (!isValid) {
                return; // Stop submission if invalid
            }

            // Show loading overlay
            $('.se-pre-con').fadeIn('slow');

            // Submit the form using native submit to avoid re-triggering handlers
            form.submit();
        });
    });


    document.querySelector('.export_csv').addEventListener('click', function () {
        const table = document.querySelector('#manage_order');

        let csvContent = "";

        const headers = table.querySelectorAll('thead th');
        let headerRow = [];
        headers.forEach(header => headerRow.push(header.innerText.trim()));
        csvContent += headerRow.join(",") + "\n";

        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            let rowData = [];
            const cells = row.querySelectorAll('td');
            cells.forEach(cell => {
                if (cell.querySelector('select')) {
                    rowData.push(cell.querySelector('select').selectedOptions[0].text.trim());
                } else {
                    rowData.push(cell.innerText.trim().replace(/,/g, ""));
                }
            });
            csvContent += rowData.join(",") + "\n";
        });

        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = URL.createObjectURL(blob);

        const a = document.createElement('a');
        a.href = url;
        a.download = 'manage_orders.csv';
        document.body.appendChild(a);
        a.click();

        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    });

    $(document).ready(function () {
        $(document).on('click', '.store_open_alert', function (e) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Action Not Allowed',
                text: 'Close the store before creating an order.',
                confirmButtonText: 'OK'
            });
        });

        $(document).on('click', '.store_archived_alert', function (e) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Archived Store',
                text: 'This cannot be processed for archived stores.',
                confirmButtonText: 'Understood'
            });
        });
        function syncOrderSelection(orderNo, isChecked) {
            var $desktop = $('.order-select-checkbox[data-order-no="' + orderNo + '"]:not(:disabled)');
            var $mobile = $('.order-select-checkbox-mobile[data-order-no="' + orderNo + '"]:not(:disabled)');

            $desktop.prop('checked', isChecked);
            $mobile
                .prop('checked', isChecked)
                .closest('.mobile-order-card')
                .toggleClass('mobile-card-selected', isChecked);
        }

        function updateSelectionUI() {
            // Desktop and mobile represent the same orders. Count only the desktop
            // checkboxes so the same order is never counted twice.
            var selectedCount = $('.order-select-checkbox:checked:not(:disabled)').length;
            var totalCheckboxes = $('.order-select-checkbox:not(:disabled)').length;

            $('#checked_order_count').text('(' + selectedCount + ')');
            $('#checked_order_count_csv').text('(' + selectedCount + ')');
            $('#checked_order_count_m').text('(' + selectedCount + ')');
            $('#checked_order_count_csv_m').text('(' + selectedCount + ')');

            var allSelected = totalCheckboxes > 0 && selectedCount === totalCheckboxes;
            $('#select_all_orders').prop('checked', allSelected);
            $('#select_all_orders_mobile').prop('checked', allSelected);

            if (selectedCount > 0) {
                $('.create_shipment').show();
                $('.export_shippo_csv').show();
                $('#mobile_shipment_row').addClass('visible');
            } else {
                $('.create_shipment').hide();
                $('.export_shippo_csv').hide();
                $('#mobile_shipment_row').removeClass('visible');
            }
        }

        $(document).on('change', '.order-select-checkbox:not(:disabled), .order-select-checkbox-mobile:not(:disabled)', function () {
            syncOrderSelection($(this).data('order-no'), $(this).is(':checked'));
            updateSelectionUI();
        });

        $('#select_all_orders').on('change', function () {
            var isChecked = $(this).is(':checked');
            $('.order-select-checkbox:not(:disabled)').each(function () {
                syncOrderSelection($(this).data('order-no'), isChecked);
            });
            updateSelectionUI();
        });

        $('#select_all_orders_mobile').on('change', function () {
            var isChecked = $(this).is(':checked');
            $('.order-select-checkbox-mobile:not(:disabled)').each(function () {
                syncOrderSelection($(this).data('order-no'), isChecked);
            });
            updateSelectionUI();
        });

        $('.create_shipment').on('click', function(e) {
            e.preventDefault();

            var selectedOrders = [...new Set(
                $('.order-select-checkbox:checked:not(:disabled), .order-select-checkbox-mobile:checked:not(:disabled)')
                    .map(function() { return $(this).data('order-no'); })
                    .get()
            )];

            if (selectedOrders.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Orders Selected',
                    text: 'Please select at least one order without an existing shipment.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            Swal.fire({
                icon: 'question',
                title: 'Create USPS Shipments?',
                text: 'Create shipment records for ' + selectedOrders.length + ' selected order(s)?',
                showCancelButton: true,
                confirmButtonText: 'Yes, create',
                cancelButtonText: 'Cancel'
            }).then(function(result) {
                if (!result.value) {
                    return;
                }

                $.ajax({
                    url: '{{ route("usps.create_shipments_bulk") }}',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                        order_nos: selectedOrders
                    },
                    beforeSend: function() {
                        $('.create_shipment').prop('disabled', true);
                        $('.se-pre-con').fadeIn('slow');
                    },
                    complete: function() {
                        $('.create_shipment').prop('disabled', false);
                        $('.se-pre-con').fadeOut('slow');
                    },
                    success: function(response) {
                        var hasErrors = Array.isArray(response.errors) && response.errors.length > 0;
                        var details = hasErrors ? '<br><small>' + response.errors.join('<br>') + '</small>' : '';

                        Swal.fire({
                            icon: hasErrors ? 'warning' : 'success',
                            title: hasErrors ? 'Shipments Partially Created' : 'Shipments Created',
                            html: (response.message || 'Shipment creation completed.') + details,
                            confirmButtonText: 'OK'
                        }).then(function() {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        var payload = xhr.responseJSON || {};
                        var message = payload.message || 'An error occurred while creating shipments.';
                        var errors = Array.isArray(payload.errors) ? payload.errors : [];
                        var details = errors.length ? '<br><small>' + errors.join('<br>') + '</small>' : '';

                        Swal.fire({
                            icon: 'error',
                            title: 'Shipment Creation Failed',
                            html: message + details,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
        $('.export_shippo_csv').on('click', function() {
            var selectedOrders = [...new Set(
                $('.order-select-checkbox:checked, .order-select-checkbox-mobile:checked')
                    .map(function() { return $(this).data('order-no'); })
                    .get()
            )];

            if (selectedOrders.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Orders Selected',
                    text: 'Please select at least one order to export.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            $.ajax({
                url: '{{ route("store.export_shippo_csv") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    order_nos: selectedOrders
                },
                beforeSend: function() {
                    $('.se-pre-con').fadeIn('slow');
                },
                success: function(response) {
                    $('.se-pre-con').fadeOut('slow');
                    const blob = new Blob([response.csv_content], { type: 'text/csv' });
                    const url = URL.createObjectURL(blob);

                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'shippo_orders.csv';
                    document.body.appendChild(a);
                    a.click();

                    document.body.removeChild(a);
                    URL.revokeObjectURL(url);
                },
                error: function(xhr) {
                    $('.se-pre-con').fadeOut('slow');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while exporting CSV. Please try again.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
    $(document).on("click", ".custom-tab", function (e) {
        e.preventDefault();

        let tab = $(this).data("tab");

        $(".custom-tab").removeClass("active");
        $(this).addClass("active");

        $(".custom-tab-pane").addClass("d-none");
        $("#" + tab).removeClass("d-none");
    });

    $(document).ready(function () {
        $('#orderSearch').on('keyup', function () {
            let query = $(this).val().trim();

            if (query.length < 2) {
                $('#searchResults').addClass('d-none');
                return;
            }

            $('#searchResults').removeClass('d-none');

            // loading state
            $('#all-results').html(`
                <li class="list-group-item text-center py-4 text-muted">
                    <i class="fa fa-search fa-spin me-1"></i> Searching...
                </li>
            `);

            $('#orders-results').html(`
                <li class="list-group-item text-center py-4 text-muted">
                    <i class="fa fa-search fa-spin me-1"></i> Searching orders...
                </li>
            `);

            $('#customers-results').html(`
                <li class="list-group-item text-center py-4 text-muted">
                    <i class="fa fa-search fa-spin me-1"></i> Searching customers...
                </li>
            `);

            $.ajax({
                url: "{{ route('store_orders.global.search') }}",
                method: "GET",
                data: { search: query },
                success: function (res) {
                    // Example response handling
                    // res = { all: [], orders: [], customers: [] }

                    renderResults('#all-results', res.all || [], 'all');
                    renderResults('#orders-results', res.orders || [], 'orders');
                    renderResults('#customers-results', res.customers || [], 'customers');
                },
                error: function () {
                    $('#all-results').html(`
                        <li class="list-group-item text-center py-4 text-danger">
                            Failed to load results
                        </li>
                    `);
                    $('#orders-results').empty();
                    $('#customers-results').empty();
                }
            });
        });

        $(document).on('click', function (e) {
            if (!$(e.target).closest('.position-relative').length) {
                $('#searchResults').addClass('d-none');
            }
        });

        function renderResults(target, items, type) {
            if (!items.length) {
                $(target).html(`
                    <li class="list-group-item text-center py-4 text-muted">
                        No results found
                    </li>
                `);
                return;
            }

            let html = '';

            items.forEach(item => {
                html += `
                    <li class="list-group-item">
                        <a href="${item.url ?? '#'}" class="text-decoration-none">
                            <div class="result-item">
                                <div class="result-main">
                                    <div class="result-title">${item.title ?? '-'}</div>
                                    <p class="result-subtitle mb-0">${item.subtitle ?? ''}</p>
                                </div>
                                <span class="badge bg-primary result-badge text-uppercase">
                                    ${type}
                                </span>
                            </div>
                        </a>
                    </li>
                `;
            });

            $(target).html(html);
        }
    });
</script>



@endsection
@section('content')
    @include('pages.stores.layouts.sidebar', ['sub_content' => 'overview'])
@endsection
