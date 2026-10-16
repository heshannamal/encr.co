@extends('layouts.app', ['activePage' => 'Shipping', 'titlePage' => __('Shipping')])



@section('sub-sidebar-content')



<style>

    .main_card {

        margin-top: 20px;

        border: unset;

        padding-bottom: 15px;

        border-radius: unset;

    }

    .export_csv {

        width: 125px;

        height: 35px;

        background-color: #F8F8F8;

        border: 1px solid #DEDEDE;

        cursor: pointer;

        font-size: 11px;

        font-weight: 600;

        color: #B3B3B3;

    }

    .export_csv_div {

        margin-right: 15px;

        padding: 15px;

        padding-bottom: unset;

    }

    .shipping_header {

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

        height: 40px;

    }

    .page_qty {

        margin-top: 4px;

        margin-left: 10px;

        border: 1px solid #DEDEDE;

        border-radius: 11px;

        width: 40px;

        text-align: center;

        color: #47D6B6;

    }

    .order_id_select_div {

        margin-right: 5px;

        margin-left: 15px;

        padding-left: 5px;

        padding-right: 5px;

        border-radius: 8px;

        height: 20px;

        margin-top: 4px;

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

    .pin_filter_div {

        margin-right: 5px;

        margin-left: 5px;

        padding-left: 5px;

        padding-right: 5px;

        border-radius: 8px;

        margin-top: 4px;

    }



    /* Responsive utilities */

    @media (min-width: 768px) {

        .mobile-only {

            display: none !important;

        }

    }

    @media (max-width: 767px) {

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



        /* Mobile specific styles */

        .mobile-search-wrapper {

            position: relative;

            margin-bottom: 12px;

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

        .mobile-filter-header {

            display: flex;

            justify-content: space-between;

            align-items: center;

            padding: 12px 16px;

            background: #fff;

            border-radius: 10px;

            border: 1px solid #f0f0f0;

            cursor: pointer;

            margin-bottom: 12px;

            font-weight: 600;

            font-size: 14px;

            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);

        }

        .mobile-filter-body {

            background: #fff;

            border-radius: 10px;

            border: 1px solid #f0f0f0;

            padding: 16px;

            margin-bottom: 12px;

            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);

        }

        .mobile-filter-group {

            margin-bottom: 12px;

        }

        .mobile-filter-label {

            font-size: 12px;

            font-weight: 600;

            color: #717070;

            margin-bottom: 4px;

        }

        .mobile-filter-select {

            width: 100%;

            height: 40px;

            border-radius: 8px;

            border: 1px solid #e5e5e5;

            padding: 0 10px;

            font-size: 13px;

            background-color: #fafafa;

        }

        .mobile-filter-row {

            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 10px;

            margin-bottom: 12px;

        }

        .mobile-filter-input {

            width: 100%;

            height: 40px;

            border-radius: 8px;

            border: 1px solid #e5e5e5;

            padding: 0 10px;

            font-size: 13px;

            background-color: #fafafa;

        }

        .mobile-filter-actions {

            display: flex;

            gap: 10px;

            margin-top: 15px;

        }

        .mobile-btn-reset {

            flex: 1;

            height: 38px;

            border: 1px solid #e5e5e5;

            background: #fff;

            border-radius: 8px;

            font-size: 13px;

            font-weight: 600;

        }

        .mobile-btn-apply {

            flex: 1;

            height: 38px;

            background: #17a589;

            color: #fff;

            border: none;

            border-radius: 8px;

            font-size: 13px;

            font-weight: 600;

        }



        /* Shipment Cards */

        .mobile-shipment-card {

            background: #fff;

            border-radius: 12px;

            padding: 16px;

            margin-bottom: 12px;

            border: 1px solid #f0f0f0;

            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);

        }

        .mobile-card-header {

            display: flex;

            justify-content: space-between;

            align-items: flex-start;

            margin-bottom: 8px;

        }

        .mobile-order-no {

            font-size: 14px;

            font-weight: 700;

            color: #333;

        }

        .mobile-carrier-sub {

            font-size: 11px;

            color: #999;

            margin-top: 2px;

        }

        .mobile-status-badge {

            font-size: 11px;

            padding: 3px 8px;

            border-radius: 12px;

            font-weight: 600;

        }

        .mobile-status-badge.success {

            background: rgba(23, 165, 137, 0.12);

            color: #17a589;

        }

        .mobile-status-badge.pending {

            background: #f3f4f6;

            color: #6b7280;

        }

        .mobile-shipping-name {

            font-size: 15px;

            font-weight: 700;

            color: #333;

            margin-bottom: 12px;

        }

        .mobile-carrier-info-row {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 4px;

        }

        .mobile-carrier-pill {

            display: inline-flex;

            align-items: center;

            background: #eef2ff;

            color: #4f46e5;

            padding: 3px 8px;

            border-radius: 14px;

            font-weight: 700;

            font-size: 11px;

            gap: 5px;

        }

        .mobile-carrier-dot {

            width: 14px;

            height: 14px;

            border-radius: 50%;

            background: #4f46e5;

            color: #fff;

            font-size: 8px;

            display: flex;

            align-items: center;

            justify-content: center;

            font-weight: bold;

        }

        .mobile-est-days {

            font-size: 12px;

            font-weight: 700;

            color: #333;

        }

        .mobile-service-name {

            font-size: 12px;

            color: #717070;

            margin-bottom: 12px;

        }

        .mobile-tracking-box {

            background: #f9fafb;

            border-radius: 8px;

            padding: 10px 12px;

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 12px;

            border: 1px solid #f3f4f6;

        }

        .mobile-tracking-label {

            font-size: 11px;

            color: #999;

            margin-bottom: 2px;

        }

        .mobile-tracking-value {

            font-size: 13px;

            font-weight: 600;

            color: #333;

        }

        .mobile-copy-btn {

            background: transparent;

            border: none;

            color: #999;

            cursor: pointer;

            font-size: 14px;

            padding: 4px;

        }

        .mobile-copy-btn:hover {

            color: #333;

        }

        .mobile-card-actions {

            display: grid;

            grid-template-columns: 1fr 1fr auto;

            gap: 8px;

            border-top: 1px solid #f3f4f6;

            padding-top: 12px;

        }

        .mobile-action-btn {

            height: 36px;

            border-radius: 8px;

            border: 1px solid #e5e5e5;

            background: #fff;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 6px;

            font-size: 12px;

            font-weight: 600;

            color: #4b5563;

            text-decoration: none !important;

        }

        .mobile-action-btn:hover {

            background: #f9fafb;

            color: #111827;

        }

        .mobile-share-btn {

            width: 36px;

            height: 36px;

            border-radius: 8px;

            border: 1px solid #e5e5e5;

            background: #fff;

            display: flex;

            align-items: center;

            justify-content: center;

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

<style>
    .usps-label-toolbar { display:flex; align-items:center; justify-content:space-between; gap:10px; padding:0 15px 12px; flex-wrap:wrap; }
    .usps-label-bulk-actions { display:flex; gap:8px; flex-wrap:wrap; }
    .usps-label-btn { border:1px solid #dedede; background:#fff; color:#555; border-radius:7px; padding:7px 11px; font-size:11px; font-weight:600; cursor:pointer; text-decoration:none !important; display:inline-flex; align-items:center; justify-content:center; gap:5px; }
    .usps-label-btn:hover { color:#17a589; border-color:#17a589; }
    .usps-label-btn-primary { background:#17a589; border-color:#17a589; color:#fff !important; }
    .usps-label-btn-primary:hover { background:#12836e; color:#fff !important; }
    .usps-label-btn-danger { border-color:#f2c4c4; color:#b42318 !important; }
    .usps-label-status { display:inline-flex; align-items:center; padding:4px 8px; border-radius:12px; font-size:10px; font-weight:700; white-space:nowrap; }
    .usps-label-status.draft { background:#f3f4f6; color:#6b7280; }
    .usps-label-status.created { background:rgba(23,165,137,.12); color:#17a589; }
    .usps-label-status.canceled { background:#fee2e2; color:#991b1b; }
    .usps-label-status.refund_requested { background:#fff7d6; color:#92400e; }
    .usps-label-status.review_required,.usps-label-status.edit_review,.usps-label-status.legacy { background:#fff1e6; color:#9a3412; }
    .usps-label-actions { display:flex; align-items:center; justify-content:center; white-space:nowrap; }
    .usps-label-actions .usps-label-btn { white-space:nowrap; flex:0 0 auto; }

    /* Desktop table alignment */
    .usps-shipping-table-wrap { padding-top:5px; width:100%; overflow:visible; }
    #product_report_table {
        width:100% !important;
        min-width:1480px !important;
        margin-bottom:0 !important;
    }
    #product_report_table thead th {
        vertical-align:middle !important;
        text-align:center;
        white-space:nowrap;
        padding:12px 10px !important;
    }
    #product_report_table tbody td {
        vertical-align:middle !important;
        padding:12px 10px !important;
        height:60px;
    }
    #product_report_table tbody tr {
        height:60px;
    }
    #product_report_table .usps-select-cell { width:42px; min-width:42px; text-align:center; }
    #product_report_table .usps-order-cell { min-width:115px; white-space:nowrap; }
    #product_report_table .usps-name-cell { min-width:165px; }
    #product_report_table .usps-date-cell { min-width:110px; white-space:nowrap; text-align:center; }
    #product_report_table .usps-carrier-cell { min-width:80px; white-space:nowrap; text-align:center; }
    #product_report_table .usps-rate-cell { min-width:75px; white-space:nowrap; text-align:center; }
    #product_report_table .usps-tracking-number-cell { min-width:190px; white-space:nowrap; text-align:center; }
    #product_report_table .usps-tracking-link-cell { min-width:145px; white-space:nowrap; text-align:center; }
    #product_report_table .usps-service-cell {
        min-width:285px;
        max-width:320px;
        white-space:normal;
        line-height:1.35;
        text-align:center;
    }
    #product_report_table .usps-estimate-cell { min-width:115px; white-space:nowrap; text-align:center; }
    #product_report_table .usps-label-status-cell {
        min-width:100px;
        white-space:nowrap;
        text-align:center;
    }
    #product_report_table .usps-label-action-cell {
        min-width:145px;
        white-space:nowrap;
        text-align:center;
    }

    /*
     * app.blade.php already loads DataTables + Bootstrap 4 integration.
     * Do NOT use DataTables scrollX here because it creates a cloned header.
     * Instead, only the Bootstrap table row scrolls horizontally while the
     * length control, info and pagination remain outside the scroll area.
     */
    #product_report_table_wrapper {
        width:100%;
    }

    #product_report_table_wrapper > .row:nth-child(2) > [class*="col-"] {
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
        padding-bottom:4px;
    }

    #product_report_table_wrapper > .row:first-child {
        align-items:center;
        margin-bottom:8px;
    }

    #product_report_table_wrapper > .row:last-child {
        align-items:center;
        margin-top:10px;
    }

    #product_report_table_wrapper .dataTables_length {
        text-align:left;
        font-size:11px;
        color:#717070;
    }

    #product_report_table_wrapper .dataTables_length label {
        margin-bottom:0;
        display:flex;
        align-items:center;
        gap:5px;
        white-space:nowrap;
    }

    #product_report_table_wrapper .dataTables_length select {
        width:auto;
        min-width:58px;
        margin:0 4px;
    }

    #product_report_table_wrapper .dataTables_info {
        padding-top:0 !important;
        font-size:11px;
        color:#777;
        text-align:left;
        white-space:nowrap;
    }

    #product_report_table_wrapper .dataTables_paginate {
        padding-top:0 !important;
        margin:0 !important;
        text-align:right !important;
        white-space:nowrap;
    }

    #product_report_table_wrapper .dataTables_paginate .pagination {
        justify-content:flex-end;
        margin:0;
        gap:4px;
    }

    #product_report_table_wrapper .page-item .page-link {
        min-width:34px;
        height:34px;
        padding:6px 10px;
        display:flex;
        align-items:center;
        justify-content:center;
        border-radius:50% !important;
        border:1px solid #dfe3e8;
        color:#6b7280;
        background:#fff;
        box-shadow:none;
    }

    #product_report_table_wrapper .page-item.active .page-link {
        background:#d1d1d1;
        border-color:#d1d1d1;
        color:#fff;
    }

    #product_report_table_wrapper .page-item.disabled .page-link {
        opacity:.55;
        color:#9ca3af;
        background:#fff;
    }

    .usps-tracking-link-btn {
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:5px;
        font-size:.8rem;
        padding:.45rem .7rem;
        background:#ecfdb5;
        color:#111 !important;
        border-radius:5px;
        text-decoration:none !important;
        white-space:nowrap;
    }
    .usps-tracking-na {
        display:inline-block;
        font-size:.8rem;
        padding:.45rem .7rem;
        background:#b3b3b3;
        color:#fff !important;
        border-radius:4px;
        white-space:nowrap;
    }
    .usps-label-checkbox { width:16px; height:16px; }
    @media(max-width:767px) {
        .usps-label-toolbar { padding:0 0 12px; }
        .usps-label-bulk-actions { width:100%; display:grid; grid-template-columns:1fr 1fr; }
        .usps-label-bulk-actions .usps-label-btn:first-child { grid-column:1 / -1; }
    }
</style>

@php
    $uspsLabelProfiles = collect();
    if (\Illuminate\Support\Facades\Schema::hasTable('usps_shipment_profiles')) {
        $uspsLabelProfiles = \App\Models\UspsShipmentProfile::query()
            ->whereIn('store_shipment_id', $shipments->pluck('id')->all())
            ->get()
            ->keyBy('store_shipment_id');
    }
@endphp






<div class="container-fluid mb-5" style="background-color: transparent;padding: 0 !important;">

    <div class="se-pre-con"></div>



    @include('pages.stores.layouts.top_header')



    @yield('stores_header')



    <div class="card col-lg-12 main_card" style="margin-top: 20px;">



        <!-- Desktop Only Layout -->

        <div class="desktop-only">

            <div class="">

                <div class="row">

                    <div class="card_div" style="width: 80%;">

                        <strong class="shipping_header">Shipping</strong>

                    </div>

                </div>

                <hr style="margin: unset; margin-bottom: 10px;">

            </div>



            @can('usps_manage_lables')
                <div class="usps-label-toolbar">
                    <div style="font-size:11px;color:#717070;"><span id="usps_selected_count">0</span> selected</div>
                    <div class="usps-label-bulk-actions">
                        <button type="button" class="usps-label-btn usps-label-btn-primary" onclick="openSelectedUspsLabelsPage()"><i class="fa fa-tags"></i> Manage Selected Labels</button>
                    </div>
                </div>
            @endcan

            <div class="usps-shipping-table-wrap">

                <table class="table align-items-center" id="product_report_table">

                    <thead style="background-color: #717070;">
                        <tr>
                            @can('usps_manage_lables')
                                <th scope="col" class="table_header_text usps-select-cell">
                                    <input type="checkbox" id="usps_select_all" class="usps-label-checkbox">
                                </th>
                            @endcan

                            <th scope="col" class="table_header_text usps-order-cell">ORDER ID</th>
                            <th scope="col" class="table_header_text usps-name-cell">SHIPPING NAME</th>
                            <th scope="col" class="table_header_text usps-date-cell">CREATED DATE</th>
                            <th scope="col" class="table_header_text usps-carrier-cell">CARRIER</th>
                            <th scope="col" class="table_header_text usps-rate-cell">RATE</th>
                            <th scope="col" class="table_header_text usps-tracking-number-cell">TRACKING NO</th>
                            <th scope="col" class="table_header_text usps-tracking-link-cell">TRACKING LINK</th>
                            <th scope="col" class="table_header_text usps-service-cell">SERVICE</th>
                            <th scope="col" class="table_header_text usps-estimate-cell">ESTIMATE DAYS</th>
                            <th scope="col" class="table_header_text usps-label-status-cell">STATUS</th>
                            <th scope="col" class="table_header_text usps-label-action-cell">LABEL</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($shipments as $shipment)
                            @php
                                $profile = $uspsLabelProfiles->get($shipment->id);
                                $isLegacy = !empty($shipment->tracking_number) && !empty($shipment->label_url) &&
                                    ($shipment->label_url === $shipment->tracking_url || strpos((string) $shipment->label_url, 'tools.usps.com') !== false);
                                $labelStatus = $profile->status ?? ($isLegacy ? 'legacy' : (!empty($shipment->label_url) ? 'created' : 'draft'));
                                $labelStatusText = ucwords(str_replace('_', ' ', $labelStatus));

                                // Some label creation flows save the USPS tracking number
                                // but not tracking_url. Build the normal USPS tracking URL
                                // as a display fallback so a created label never shows N/A.
                                $trackingUrl = $shipment->tracking_url;
                                if (empty($trackingUrl) && !empty($shipment->tracking_number)) {
                                    $trackingUrl = 'https://tools.usps.com/go/TrackConfirmAction?tLabels=' . urlencode($shipment->tracking_number);
                                }
                            @endphp
                            <tr>

                                @can('usps_manage_lables')
                                    <td class="usps-select-cell">
                                        <input type="checkbox" class="usps-label-checkbox usps-label-select" value="{{ $shipment->id }}">
                                    </td>
                                @endcan

                                <td class="usps-order-cell">
                                    <a target="_blank"
                                       href="{{ route('store.individual_player', ['id' => $shipment->store_order_no]) }}"
                                       style="font-weight:600;font-size:.8rem;">
                                        #{{$shipment->store_order_no ?? 'N/A'}}
                                    </a>
                                </td>

                                <td class="usps-name-cell">{{$shipment->shipping_name}}</td>

                                <td class="usps-date-cell">{{$shipment->created_at->format('m/d/Y')}}</td>

                                <td class="usps-carrier-cell">{{$shipment->carrier}}</td>

                                <td class="usps-rate-cell">{{$shipment->rate}}</td>

                                <td class="usps-tracking-number-cell">{{$shipment->tracking_number ?: 'N/A'}}</td>

                                <td class="usps-tracking-link-cell">

                                    @if(!empty($trackingUrl))

                                        <a target="_blank" href="{{ $trackingUrl }}" class="usps-tracking-link-btn">
                                            <i class="fa fa-external-link"></i> View Tracking
                                        </a>

                                    @else

                                        <span class="usps-tracking-na">N/A</span>

                                    @endif

                                </td>

                                <td class="usps-service-cell">{{$shipment->service}}</td>

                                <td class="usps-estimate-cell">{{$shipment->estimated_days}}</td>

                                <td class="usps-label-status-cell">
                                    <span class="usps-label-status {{ $labelStatus }}">{{ $labelStatusText }}</span>
                                </td>

                                <td class="usps-label-action-cell">
                                    <div class="usps-label-actions">
                                        @can('usps_manage_lables')
                                            <a href="{{ route('usps.label.manage', ['id' => $shipment->id]) }}"
                                               class="usps-label-btn usps-label-btn-primary">
                                                <i class="fa fa-tag"></i>
                                                {{ $labelStatus === 'draft' ? 'Create / Edit' : 'Manage Label' }}
                                            </a>
                                        @else
                                            @if($shipment->label_url)
                                                <a target="_blank"
                                                   href="{{ $shipment->label_url }}"
                                                   class="usps-label-btn">
                                                    <i class="fa fa-file-pdf-o"></i> View Label
                                                </a>
                                            @else
                                                <span class="text-muted" style="font-size:11px;">N/A</span>
                                            @endif
                                        @endcan
                                    </div>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>



        <!-- Mobile Only Layout -->

        <div class="mobile-only">

            <!-- 1. Search Bar -->

            <div class="mobile-search-wrapper">

                <i class="fa fa-search mobile-search-icon"></i>

                <input type="text" id="mobile_search_input" class="mobile-search-input" placeholder="Search order ID, name, or tracking #">

            </div>



            <!-- 2. Filters Toggle -->

            <div class="mobile-filter-header" onclick="toggleMobileFilters()">

                <span><i class="fa fa-filter" style="margin-right: 5px;"></i> Filters <span class="badge badge-success" id="mobile_filter_badge" style="display:none; background-color: #17a589; margin-left: 5px;">0</span></span>

                <i class="fa fa-chevron-down" id="mobile_filter_chevron"></i>

            </div>



            <!-- Filters Container -->

            <div class="mobile-filter-body" id="mobile_filter_container" style="display: none;">

                <div class="mobile-filter-group">

                    <label class="mobile-filter-label">Carrier</label>

                    <select id="mobile_carrier_filter" class="mobile-filter-select">

                        <option value="all">All</option>

                        @foreach($shipments->pluck('carrier')->unique()->filter() as $c)

                            <option value="{{ strtolower($c) }}">{{ $c }}</option>

                        @endforeach

                    </select>

                </div>

                <div class="mobile-filter-group">

                    <label class="mobile-filter-label">Shipping Service</label>

                    <select id="mobile_service_filter" class="mobile-filter-select">

                        <option value="all">All</option>

                        @foreach($shipments->pluck('service')->unique()->filter() as $s)

                            <option value="{{ strtolower($s) }}">{{ $s }}</option>

                        @endforeach

                    </select>

                </div>

                <div class="mobile-filter-group">

                    <label class="mobile-filter-label">Label Status</label>

                    <select id="mobile_status_filter" class="mobile-filter-select">

                        <option value="all">All</option>

                        <option value="draft">Pending Label</option>
                        <option value="created">Label Created</option>
                        <option value="refund_requested">Refund Requested</option>
                        <option value="canceled">Canceled</option>
                        <option value="review_required">Needs Review</option>
                        <option value="legacy">Legacy / Imported</option>

                    </select>

                </div>

                <div class="mobile-filter-row">

                    <div>

                        <label class="mobile-filter-label">Start Date</label>

                        <input type="date" id="mobile_start_date" class="mobile-filter-input">

                    </div>

                    <div>

                        <label class="mobile-filter-label">End Date</label>

                        <input type="date" id="mobile_end_date" class="mobile-filter-input">

                    </div>

                </div>

                <div class="mobile-filter-group">

                    <label class="mobile-filter-label">Sort by</label>

                    <select id="mobile_sort_filter" class="mobile-filter-select">

                        <option value="order_id">Order ID</option>

                        <option value="name">Name</option>

                        <option value="date_newest">Date (newest)</option>

                        <option value="date_oldest">Date (oldest)</option>

                    </select>

                </div>

                <div class="mobile-filter-actions">

                    <button type="button" class="mobile-btn-reset" onclick="resetMobileFilters()">Reset</button>

                    <button type="button" class="mobile-btn-apply" onclick="applyMobileFilters()">Apply Filters</button>

                </div>

            </div>



            @can('usps_manage_lables')
                <div class="usps-label-toolbar">
                    <label style="font-size:12px;margin:0;"><input type="checkbox" id="usps_select_mobile_all" class="usps-label-checkbox"> Select visible</label>
                    <div class="usps-label-bulk-actions">
                        <button type="button" class="usps-label-btn usps-label-btn-primary" onclick="openSelectedUspsLabelsPage()">Manage Selected</button>
                    </div>
                </div>
            @endcan

            <!-- 3. Cards List Container -->

            <div id="mobile_shipments_list">

                @foreach ($shipments as $shipment)

                    @php
                        $profile = $uspsLabelProfiles->get($shipment->id);
                        $isLegacy = !empty($shipment->tracking_number) && !empty($shipment->label_url) &&
                            ($shipment->label_url === $shipment->tracking_url || strpos((string) $shipment->label_url, 'tools.usps.com') !== false);
                        $labelStatus = $profile->status ?? ($isLegacy ? 'legacy' : (!empty($shipment->label_url) ? 'created' : 'draft'));
                        $hasLabel = $labelStatus !== 'draft';
                        $statusClass = $labelStatus === 'created' ? 'success' : 'pending';
                        $statusText = ucwords(str_replace('_', ' ', $labelStatus));

                        $trackingUrl = $shipment->tracking_url;
                        if (empty($trackingUrl) && !empty($shipment->tracking_number)) {
                            $trackingUrl = 'https://tools.usps.com/go/TrackConfirmAction?tLabels=' . urlencode($shipment->tracking_number);
                        }
                    @endphp

                    <div class="mobile-shipment-card"

                         data-order-id="{{ $shipment->store_order_no ?? '' }}"

                         data-name="{{ strtolower($shipment->shipping_name ?? '') }}"

                         data-carrier="{{ strtolower($shipment->carrier ?? '') }}"

                         data-service="{{ strtolower($shipment->service ?? '') }}"

                         data-status="{{ $labelStatus }}"

                         data-date="{{ $shipment->created_at->format('Y-m-d') }}"

                         data-tracking="{{ strtolower($shipment->tracking_number ?? '') }}">



                        <div class="mobile-card-header">

                            <div>

                                <div class="mobile-order-no">#{{ $shipment->store_order_no ?? 'N/A' }}</div>

                                <div class="mobile-carrier-sub">Carrier: {{ $shipment->carrier ?? 'N/A' }}</div>

                            </div>

                            <span class="mobile-status-badge {{ $statusClass }}">{{ $statusText }}</span>

                        </div>



                        <div class="mobile-shipping-name">{{ $shipment->shipping_name }}</div>



                        <div class="mobile-carrier-info-row">

                            <span class="mobile-carrier-pill">

                                <span class="mobile-carrier-dot">{{ substr($shipment->carrier ?? 'U', 0, 1) }}</span>

                                {{ $shipment->carrier ?? 'USPS' }}

                            </span>

                            <span class="mobile-est-days">Est. {{ $shipment->estimated_days ?? '1-5 Days' }}</span>

                        </div>



                        <div class="mobile-service-name">{{ $shipment->service ?? 'N/A' }}</div>



                        <div class="mobile-tracking-box">

                            <div>

                                <div class="mobile-tracking-label">Tracking No.</div>

                                <div class="mobile-tracking-value">

                                    {{ !empty($shipment->tracking_number) ? '...' . substr($shipment->tracking_number, -10) : 'N/A' }}

                                </div>

                            </div>

                            @if(!empty($shipment->tracking_number))

                                <button type="button" class="mobile-copy-btn" onclick="copyTracking('{{ $shipment->tracking_number }}', this)" title="Copy Tracking Number">

                                    <i class="fa fa-clone"></i>

                                </button>

                            @endif

                        </div>



                        <div class="mobile-card-actions">

                            @if(!empty($trackingUrl))

                                <a target="_blank" href="{{ $trackingUrl }}" class="mobile-action-btn">

                                    <i class="fa fa-clock-o"></i> View Tracking

                                </a>

                            @else

                                <span class="mobile-action-btn" style="opacity: 0.5; cursor: not-allowed;">

                                    <i class="fa fa-clock-o"></i> View Tracking

                                </span>

                            @endif



                            @can('usps_manage_lables')
                                <a href="{{ route('usps.label.manage', ['id' => $shipment->id]) }}"
                                   class="mobile-action-btn">
                                    <i class="fa fa-tag"></i> {{ $labelStatus === 'draft' ? 'Create / Edit' : 'Manage Label' }}
                                </a>
                                <label class="mobile-share-btn" style="margin:0;cursor:pointer;" title="Select for bulk label action">
                                    <input type="checkbox" class="usps-label-checkbox usps-label-select" value="{{ $shipment->id }}">
                                </label>
                            @else
                                @if($shipment->label_url)
                                    <a target="_blank" href="{{ $shipment->label_url }}" class="mobile-action-btn"><i class="fa fa-file-text-o"></i> View Label</a>
                                @endif
                            @endcan



                        </div>

                    </div>

                @endforeach

            </div>

        </div>



    </div>



</div>



@endsection

@push('js')
<script>

    $(document).ready(function(){

        $(".a_tag_onclick").on("click", function(){

            $(".se-pre-con").fadeIn('slow');

        });



        if ($.fn.DataTable) {

            if ($.fn.DataTable.isDataTable('#product_report_table')) {
                $('#product_report_table').DataTable().destroy();
            }

            $('#product_report_table').DataTable({

                paging: true,

                lengthMenu: [10, 25, 50, 100],

                pageLength: 10,

                searching: false,

                ordering: false,

                autoWidth: false,

                responsive: false,

                language: {

                    search: "",

                    searchPlaceholder: "Order search...",

                    paginate: {
                        previous: "‹",
                        next: "›"
                    }

                }

            });

        }



        // Search trigger for mobile view

        $('#mobile_search_input').on('keyup', function () {

            applyMobileFilters();

        });

        @can('usps_manage_lables')
        $(document).on('change', '.usps-label-select', function(){
            const id=String(this.value);
            if(this.checked) uspsSelectedIds[id]=true;
            else delete uspsSelectedIds[id];
            syncUspsSelections();
        });
        $('#usps_select_all').on('change', function(){
            const checked=this.checked;
            $('.desktop-only .usps-label-select').each(function(){
                const id=String(this.value);
                if(checked) uspsSelectedIds[id]=true;
                else delete uspsSelectedIds[id];
            });
            syncUspsSelections();
        });
        $('#usps_select_mobile_all').on('change', function(){
            const checked=this.checked;
            $('#mobile_shipments_list .mobile-shipment-card:visible .usps-label-select').each(function(){
                const id=String(this.value);
                if(checked) uspsSelectedIds[id]=true;
                else delete uspsSelectedIds[id];
            });
            syncUspsSelections();
        });

        $('#product_report_table').on('draw.dt', function(){
            syncUspsSelections();
        });
        @endcan

    });



    // =======================

    // MOBILE VIEW FUNCTIONS

    // =======================



    function toggleMobileFilters() {

        let container = $('#mobile_filter_container');

        let chevron = $('#mobile_filter_chevron');

        if (container.is(':visible')) {

            container.slideUp(200);

            chevron.removeClass('fa-chevron-up').addClass('fa-chevron-down');

        } else {

            container.slideDown(200);

            chevron.removeClass('fa-chevron-down').addClass('fa-chevron-up');

        }

    }



    function applyMobileFilters() {

        let searchQuery = $('#mobile_search_input').val().toLowerCase();

        let carrier = $('#mobile_carrier_filter').val();

        let service = $('#mobile_service_filter').val();

        let status = $('#mobile_status_filter').val();

        let startDate = $('#mobile_start_date').val();

        let endDate = $('#mobile_end_date').val();

        let sortBy = $('#mobile_sort_filter').val();



        let activeFiltersCount = 0;

        if (carrier !== 'all') activeFiltersCount++;

        if (service !== 'all') activeFiltersCount++;

        if (status !== 'all') activeFiltersCount++;

        if (startDate) activeFiltersCount++;

        if (endDate) activeFiltersCount++;



        if (activeFiltersCount > 0) {

            $('#mobile_filter_badge').text(activeFiltersCount).show();

        } else {

            $('#mobile_filter_badge').hide();

        }



        let cards = $('.mobile-shipment-card');



        cards.each(function() {

            let card = $(this);

            let cardOrderId = (card.attr('data-order-id') || '').toLowerCase();

            let cardName = (card.attr('data-name') || '').toLowerCase();

            let cardCarrier = card.attr('data-carrier') || '';

            let cardService = card.attr('data-service') || '';

            let cardStatus = card.attr('data-status') || '';

            let cardDate = card.attr('data-date') || '';

            let cardTracking = (card.attr('data-tracking') || '').toLowerCase();



            let matchesSearch = !searchQuery ||

                                cardOrderId.indexOf(searchQuery) > -1 ||

                                cardName.indexOf(searchQuery) > -1 ||

                                cardTracking.indexOf(searchQuery) > -1;



            let matchesCarrier = carrier === 'all' || cardCarrier === carrier;

            let matchesService = service === 'all' || cardService === service;

            let matchesStatus = status === 'all' || cardStatus === status;



            let matchesStartDate = !startDate || cardDate >= startDate;

            let matchesEndDate = !endDate || cardDate <= endDate;



            if (matchesSearch && matchesCarrier && matchesService && matchesStatus && matchesStartDate && matchesEndDate) {

                card.show();

            } else {

                card.hide();

            }

        });



        // Sorting

        let parent = $('#mobile_shipments_list');

        let visibleCards = cards.get();

        visibleCards.sort(function(a, b) {

            let valA, valB;

            if (sortBy === 'order_id') {

                valA = parseInt($(a).attr('data-order-id')) || 0;

                valB = parseInt($(b).attr('data-order-id')) || 0;

                return valA - valB;

            } else if (sortBy === 'name') {

                valA = $(a).attr('data-name') || '';

                valB = $(b).attr('data-name') || '';

                return valA.localeCompare(valB);

            } else if (sortBy === 'date_newest') {

                valA = $(a).attr('data-date') || '';

                valB = $(b).attr('data-date') || '';

                return valB.localeCompare(valA);

            } else if (sortBy === 'date_oldest') {

                valA = $(a).attr('data-date') || '';

                valB = $(b).attr('data-date') || '';

                return valA.localeCompare(valB);

            }

            return 0;

        });



        $.each(visibleCards, function(idx, item) {

            parent.append(item);

        });

    }



    function resetMobileFilters() {

        $('#mobile_search_input').val('');

        $('#mobile_carrier_filter').val('all');

        $('#mobile_service_filter').val('all');

        $('#mobile_status_filter').val('all');

        $('#mobile_start_date').val('');

        $('#mobile_end_date').val('');

        $('#mobile_sort_filter').val('order_id');

        applyMobileFilters();

        toggleMobileFilters();

    }



    function copyTracking(text, btnElement) {

        navigator.clipboard.writeText(text).then(function() {

            let icon = $(btnElement).find('i');

            icon.removeClass('fa-clone').addClass('fa-check text-success');

            setTimeout(function() {

                icon.removeClass('fa-check text-success').addClass('fa-clone');

            }, 1500);

        }).catch(function(err) {

            console.error('Failed to copy text: ', err);

        });

    }



    function shareTracking(url) {

        if (navigator.share) {

            navigator.share({

                title: 'Tracking Link',

                url: url

            }).catch(console.error);

        } else {

            // Fallback: Copy url to clipboard

            navigator.clipboard.writeText(url).then(function() {

                Swal.fire('Link Copied!', 'Tracking link copied to clipboard.', 'success');

            });

        }

    }



    @can('usps_manage_lables')
    const uspsBulkManageUrl = @json(route('usps.label.bulk-manage'));
    const uspsSelectedIds = {};

    function syncUspsSelections(){
        const selected = getUspsSelectedIds();

        $('#usps_selected_count').text(selected.length);

        // Desktop and mobile both render the same shipment id.
        // Apply the central state to every visible/detached copy.
        $('.usps-label-select').each(function(){
            this.checked = !!uspsSelectedIds[String(this.value)];
        });

        const desktopBoxes = $('.desktop-only .usps-label-select');
        const desktopChecked = desktopBoxes.filter(':checked').length;

        $('#usps_select_all')
            .prop('checked', desktopBoxes.length > 0 && desktopChecked === desktopBoxes.length)
            .prop('indeterminate', desktopChecked > 0 && desktopChecked < desktopBoxes.length);

        const visibleMobileBoxes =
            $('#mobile_shipments_list .mobile-shipment-card:visible .usps-label-select');
        const mobileChecked = visibleMobileBoxes.filter(':checked').length;

        $('#usps_select_mobile_all')
            .prop('checked', visibleMobileBoxes.length > 0 && mobileChecked === visibleMobileBoxes.length)
            .prop('indeterminate', mobileChecked > 0 && mobileChecked < visibleMobileBoxes.length);
    }

    function getUspsSelectedIds(){
        return Object.keys(uspsSelectedIds);
    }

    function openSelectedUspsLabelsPage(){
        const ids = getUspsSelectedIds();

        if(!ids.length){
            if(window.Swal){
                Swal.fire('USPS Labels', 'Select at least one shipment first.', 'info');
            }else{
                alert('Select at least one shipment first.');
            }
            return;
        }

        const query = ids
            .map(function(id){
                return 'shipment_ids[]=' + encodeURIComponent(id);
            })
            .join('&');

        window.location.href = uspsBulkManageUrl + '?' + query;
    }
    @endcan

</script>
@endpush


@section('content')

    @include('pages.stores.layouts.sidebar', ['sub_content' => 'overview'])

@endsection
