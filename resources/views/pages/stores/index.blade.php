@extends('layouts.app', ['activePage' => 'Team Stores', 'titlePage' => __('Team Stores')])

@section('content')

<style>
    .content-position {
        padding-left: 15px !important;
        padding-right: 15px !important;
    }

    .print_btn {
        padding-right: 3%;
        padding-left: 2%;
    }

    .table_header_text {
        color: white;
        height: 40px;
    }

    .all_store_summary {
        padding-top: 5px;
        overflow-x: auto;
        padding-left: 15PX;
        padding-right: 15PX;
        padding-bottom: 15px;
    }

    .production_text {
        padding-left: 10px;
        color: rgb(94, 94, 94);
    }

    .filter_row {
        margin-left: unset;
        padding-left: 8px;
        padding-right: 9px;
        background-color: #F8F8F8;
        border: 1px solid#DEDEDE;
        border-radius: 5px;
        padding-top: 2px;
    }

    .date_selection {
        background-color: transparent;
        padding: unset;
        border: unset;
        color: #47D6B6;
        font-size: 11px;
    }

    .date_p {
        margin: unset;
        font-size: 11px;
        color: black;
        font-weight: 500;
    }

    .filter_btn {
        padding: 10px;
        text-align: center;
        background-color: #2dce89;
        border: none;
        cursor: pointer;
        color: white !important;
    }

    .table-bottom-details2 {
        color: #020202
    }

    .header-layout {
        margin-bottom: 2rem !important;
    }

    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        display: none;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }

    .select-border-style {
        border: 1px solid #b3b3b3 !important;
        border-radius: 0rem !important;
    }

    .select2-selection--single {
        background-color: #F8F8F8 !important;
    }

    .d_flex_and_align_center {
        display: flex;
        align-items: center;
    }

    .select-width-style .select2.select2-container.select2-container--default {
        width: 8rem !important;
    }

    .select-width-style-item .select2.select2-container.select2-container--default {
        width: 10rem !important;
    }

    .page-item .page-link,
    .page-item span {
        border-radius: 0 !important;
        font-size: 0.7rem;
    }

    .page-item.active .page-link {
        z-index: 1;
        color: grey;
        border-color: #cccccc;
        background-color: #e9e9e9;
        box-shadow: none;
    }

    .table thead th,
    .table tbody td {
        padding-top: 0;
        padding-bottom: 0;
    }

    .table tbody td {
        padding-top: 7.5px;
        padding-bottom: 7.5px;
    }

    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_asc_disabled:before,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:before,
    table.dataTable thead .sorting_desc_disabled:after {
        bottom: 0.6rem !important;
    }

    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:after {
        right: .7rem !important;
    }

    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_asc_disabled:before,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:before,
    table.dataTable thead .sorting_desc_disabled:after {
        bottom: .65em;
    }

    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_asc_disabled:before,
    table.dataTable thead .sorting_desc_disabled:before {
        content: "\f0de";
        font-family: FontAwesome;
    }

    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:after {
        content: "\f0dd";
        font-family: FontAwesome;
        right: .65rem !important;
    }

    .searchbox-layout {
        margin-top: 0 !important;
        width: 100% !important;
        height: 29px;
        font-size: .7rem;
        color: grey !important;
        border: unset;
        outline: unset;
    }

    .styled-nav-item .nav-link.active,
    .styled-nav-item .nav-link:hover {
        color: black !important;
        border: none;
        background-color: transparent !important;
        border-bottom: 2px solid black !important;
        font-size: .8rem;
    }

    .status {
        font-size: 12px;
        text-align: center;
        border-radius: 16px;
        margin: 0;
    }

    .status.open {
        background-color: rgba(199, 249, 123, 0.7);
        color: rgb(0, 101, 0);
    }

    .status.archived {
        color: white;
        background-color: #b3b3b3
    }

    .status.closed {
        color: white;
        background-color: rgb(223 22 22 / 70%)
    }

    .font_color {
        color: #9f9f9f;
    }

    .view_store_btn {
        border: unset;
        width: auto;
        height: 33px;
        font-size: 10px;
        font-weight: 600;
        cursor: pointer;
    }

    .navbar-left-search {
        position: relative;
        width: 380px;
        min-width: 320px;
    }

    .search-box .form-control {
        height: 44px;
        box-shadow: none;
        border-radius: 0 10px 10px 0;
    }

    .search-box .input-group-text {
        border-radius: 10px 0 0 10px;
    }

    .dropdown-menu-custom {
        position: absolute;
        top: calc(100% + 10px);
        /* left: 0; */
        right: 1rem;
        width: 700px;
        max-width: 90vw;
        min-height: 340px;
        max-height: 500px;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.14);
        z-index: 9999;
        overflow: hidden;
    }

    .custom-tabs-bar {
        background: #f8f9fa;
        min-height: 100%;
    }

    .custom-tab {
        display: flex;
        align-items: center;
        padding: 14px 16px;
        text-decoration: none;
        color: #555;
        font-weight: 600;
        border-bottom: 1px solid #e9ecef;
        transition: all 0.2s ease;
    }

    .custom-tab:hover {
        background: #eef3ff;
        color: #111;
    }

    .custom-tab.active {
        color: #0d6efd;
        background: #fff;
        border-left: 3px solid #0d6efd;
    }

    .custom-tab-content {
        max-height: 500px;
        overflow-y: auto;
        background: #fff;
    }

    .custom-tab-pane.d-none {
        display: none !important;
    }

    .results-list li {
        padding: 12px 16px;
        font-size: 14px;
    }

    .search-result-item {
        padding: 12px 16px;
        border-bottom: 1px solid #f1f1f1;
        transition: background 0.2s ease;
    }

    .search-result-item:hover {
        background: #f8f9fa;
    }

    .search-result-title {
        font-weight: 600;
        color: #222;
        margin-bottom: 2px;
    }

    .search-result-meta {
        font-size: 12px;
        color: #777;
    }

    .mobile-store-list {
        display: none;
    }

    @media (max-width: 767px) {
        .bg-box.container-fluid.fix-nav.header-layout {
            margin-bottom: 0 !important;
        }

        .header-layout {
            margin-bottom: 0 !important;
            height: auto !important;
            min-height: 0 !important;
        }

        .navbar-left-search {
            position: relative;
            width: 100%;
            min-width: auto;
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

        .dropdown-menu-custom {
            overflow: hidden !important;
            position: absolute !important;
            top: calc(100% + 8px) !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            max-height: 60vh !important;
            overflow-y: auto !important;
            z-index: 1 !important;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
            border-radius: 14px;
            background: #fff;
        }

        body.search-open {
            overflow: hidden !important;
            position: fixed;
            width: 100%;
        }

        .content-position {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        #scrollTable {
            margin-top: 44px !important;
            margin-bottom: 10px !important;
            padding-bottom: 10px !important;
        }

        .card.p-3 {
            padding: 0.75rem !important;
            border: unset !important;
        }

        /* ---- Filter row: stack Sales Person & Store Status ---- */
        .row.align-items-center.mt-3.mb-3 {
            margin-top: 0 !important;
            margin-bottom: 0 !important;
        }

        .row.align-items-center.mt-3.mb-3>.col-md-7.d-flex {
            flex-wrap: wrap !important;
            gap: 10px !important;
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }

        .row.align-items-center.mt-3.mb-3>.col-md-7.d-flex>div.d-flex.align-items-center.p-2.border {
            flex: 1 1 calc(50% - 5px) !important;
            width: calc(50% - 5px) !important;
            margin-left: 0 !important;
            box-sizing: border-box !important;
            background-color: #F8F8F8 !important;
        }

        .row.align-items-center.mt-3.mb-3>.col-md-7.d-flex>div.d-flex.align-items-center.p-2.border .summary-select2,
        .row.align-items-center.mt-3.mb-3>.col-md-7.d-flex>div.d-flex.align-items-center.p-2.border select {
            width: 100% !important;
            max-width: 100% !important;
        }

        .row.align-items-center.mt-3.mb-3>.col-md-7.d-flex>.select2.select2-container {
            width: auto !important;
            flex: 1 1 auto !important;
        }

        /* Filter / Clear buttons full width, stacked below the boxes */
        #pin-filter.filter_btn,
        #clear-filter {
            flex: 1 1 calc(50% - 5px) !important;
            width: calc(50% - 5px) !important;
            margin-left: 0 !important;
            border-radius: 4px !important;
        }

        /* Search bar — full width below filters */
        .col-md-3.navbar-left-search {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            margin-top: 12px !important;
            order: 3;
        }

        /* Create Store button — full width */
        .col-md-1.ml-auto {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            margin-top: 12px !important;
            order: 4;
        }

        .col-md-1.ml-auto #create-store-button {
            width: 100% !important;
            border-radius: 4px !important;
        }

        /* ---- Tabs (Stores / Archived Stores) ---- */
        #storeTabs {
            margin-top: 14px !important;
        }

        #storeTabs .nav-link {
            font-size: 0.85rem !important;
            padding: 0.5rem 0.75rem !important;
        }

        /* ---- Hide desktop table on mobile, show card list ---- */
        .all_store_summary {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        .all_store_summary table.table {
            display: none !important;
        }

        .mobile-store-list {
            display: block !important;
            padding-top: 10px;
        }

        .mobile-store-list .store-card {
            background: #fff;
            border: 1px solid #ececec;
            border-radius: 10px;
            padding: 14px;
            margin-bottom: 14px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .mobile-store-list .store-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
        }

        .mobile-store-list .store-card-title {
            font-size: 15px;
            font-weight: 700;
            color: #222;
            margin: 0;
            line-height: 1.3;
        }

        .mobile-store-list .store-card-org {
            font-size: 12.5px;
            color: #8a8a8a;
            margin: 2px 0 0 0;
        }

        .mobile-store-list .status {
            padding: 4px 12px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .mobile-store-list .store-card-rep {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 12px;
        }

        .mobile-store-list .rep-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background-color: #2dce89;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            text-transform: uppercase;
        }

        .mobile-store-list .rep-name {
            font-size: 13.5px;
            color: #333;
            font-weight: 500;
        }

        .mobile-store-list .store-card-stats {
            display: flex;
            justify-content: space-between;
            margin-top: 14px;
        }

        .mobile-store-list .store-card-stats .stat-label {
            font-size: 11.5px;
            color: #9f9f9f;
            margin-bottom: 2px;
        }

        .mobile-store-list .store-card-stats .stat-value {
            font-size: 14px;
            font-weight: 700;
            color: #333;
        }

        .mobile-store-list .store-card-stats .stat-value.collected {
            color: #2dce89;
        }

        .mobile-store-list .store-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px solid #f1f1f1;
        }

        .mobile-store-list .store-card-dates {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .mobile-store-list .store-card-dates .date-line {
            font-size: 11.5px;
            color: #9f9f9f;
        }

        .mobile-store-list .store-card-dates .date-line strong {
            color: #555;
            font-weight: 600;
        }

        .mobile-store-list .store-card-title a {
            color: #222 !important;
            text-decoration: none !important;
        }

        .mobile-store-list .store-card-title a:hover {
            color: #2451c9 !important;
        }

        .mobile-store-list .store-card-details-btn {
            font-size: 12px;
            font-weight: 600;
            color: #2451c9;
            background: #eaf0ff;
            border: none;
            border-radius: 6px;
            padding: 7px 14px;
            text-decoration: none !important;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .mobile-store-list .empty-state {
            text-align: center;
            color: #9f9f9f;
            padding: 30px 10px;
            font-size: 13px;
        }

        .mobile-results-count {
            display: block;
            font-size: 12.5px;
            color: #8a8a8a;
            margin: 10px 2px 0 2px;
        }

        /* DataTables paging/length controls not needed for the mobile card list */
        .mobile-hide-dt-controls .dataTables_length,
        .mobile-hide-dt-controls .dataTables_info,
        .mobile-hide-dt-controls .dataTables_paginate {
            display: none !important;
        }

        /* Make dropdown appear above on mobile to avoid keyboard overlap */
        #user_filter+.select2-container {
            width: 100% !important;
            min-width: 0 !important;
        }
        .header1 {
            top: 110px;
        }
    }

    /* Select2 search on Sales Person — inherit the borderless inline look */
    #user_filter+.select2-container .select2-selection--single {
        border: none !important;
        background: transparent !important;
        box-shadow: none !important;
        height: auto;
        padding: 0;
    }

    #user_filter+.select2-container .select2-selection__rendered {
        padding-left: 0;
        color: #333;
        font-size: .85rem;
        line-height: 1.4;
    }

    #user_filter+.select2-container .select2-selection__arrow {
        height: 100%;
    }

    /* Prevent iOS auto-zoom on the search input */
    .select2-search--dropdown .select2-search__field {
        font-size: 16px !important;
    }
</style>


@section('order-header')
<span>Team Stores</span>
@endsection

<div class="mb-5 content-position">
    <div class="se-pre-con"></div>
    
    <div class="col-md-12" style="margin-top: 15px; margin-bottom: 25px; padding-bottom: 20px;" id="scrollTable">
        <div class="card p-3" style="border: unset;">
            <div class="row align-items-center mt-3 mb-3">

                <!-- Left side group -->
                <div class="col-md-7 d-flex align-items-center gap-3">

                    <!-- Rep Filter Box -->
                    <div class="d-flex align-items-center p-2 border bg-white">
                        <span class="font_color">Sales Person&nbsp;|&nbsp;</span>
                        <select id="user_filter" name="user_filter" class="form-select border-0 p-0 summary-select2" style="width: 140px;">
                            <option value="all">All</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Team Type Box -->
                    <div class="d-flex align-items-center p-2 border bg-white ml-2">
                        <span class="font_color">Store Status&nbsp;|&nbsp;</span>
                        <select id="store_status_filter" name="store_status_filter" class="form-select border-0 p-0 summary-select2" style="width: 180px;">
                            <option value="all" selected>All</option>
                            <option value="1">Open</option>
                            <option value="2">Close</option>
                        </select>
                    </div>

                    <!-- Filter Button -->
                    <button type="button" id="pin-filter" class="btn btn-primary filter_btn ml-2 view_store_btn" style="border-radius: 0">
                        <i class="fa fa-filter"></i> Filter
                    </button>
                    <button type="button" id="clear-filter" class="btn btn-secondary ml-2 view_store_btn" style="border-radius: 0">
                        <i class="fa fa-undo"></i> Clear
                    </button>

                </div>

                <!-- Left navbar search -->
                <div class="col-md-3 navbar-left-search position-relative">
                    <div class="input-group search-box">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fa fa-search text-muted"></i>
                        </span>

                        <input
                            type="text"
                            id="orderSearch"
                            class="form-control border-start-0"
                            placeholder="&nbsp;Search by order #, name, email, team..."
                            autocomplete="off">
                    </div>

                    <div id="searchResults" class="dropdown-menu-custom d-none p-2">
                        <div class="row g-0 h-100">

                            <!-- Left tabs -->
                            <div class="col-md-3 border-end">
                                <div class="custom-tabs-bar d-flex flex-column h-100">
                                    <a href="javascript:void(0)" class="custom-tab active" data-tab="all-tab">
                                        <i class="fa fa-list mr-2"></i> All
                                    </a>
                                    <a href="javascript:void(0)" class="custom-tab" data-tab="stores-tab">
                                        <i class="fa fa-list mr-2"></i> Stores
                                    </a>

                                    <a href="javascript:void(0)" class="custom-tab" data-tab="orders-tab">
                                        <i class="fa fa-shopping-cart mr-2"></i> Orders
                                    </a>

                                    <a href="javascript:void(0)" class="custom-tab" data-tab="customers-tab">
                                        <i class="fa fa-users mr-2"></i> Customers
                                    </a>
                                </div>
                            </div>

                            <!-- Right content -->
                            <div class="col-md-9">
                                <div class="custom-tab-content">
                                    <div class="custom-tab-pane" id="all-tab">
                                        <ul class="list-group list-group-flush results-list" id="all-results">
                                            <li class="text-center p-3 text-muted">
                                                <i class="fa fa-search fa-spin"></i> Searching...
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="custom-tab-pane d-none" id="stores-tab">
                                        <ul class="list-group list-group-flush results-list" id="stores-results">
                                            <li class="text-center p-3 text-muted">
                                                <i class="fa fa-search fa-spin"></i> Searching stores...
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="custom-tab-pane d-none" id="orders-tab">
                                        <ul class="list-group list-group-flush results-list" id="orders-results">
                                            <li class="text-center p-3 text-muted">
                                                <i class="fa fa-search fa-spin"></i> Searching orders...
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="custom-tab-pane d-none" id="customers-tab">
                                        <ul class="list-group list-group-flush results-list" id="customers-results">
                                            <li class="text-center p-3 text-muted">
                                                <i class="fa fa-search fa-spin"></i> Searching customers...
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Right aligned Create Store Button -->
                <div class="col-md-1 ml-auto">
                    <button type="button" id="create-store-button" class="btn btn-success filter_btn view_store_btn" style="border-radius: 0">
                        <i class="fa fa-plus"></i> Create Store
                    </button>
                </div>

            </div>


            <ul class="nav nav-tabs" id="storeTabs" role="tablist">
                <li class="styled-nav-item nav-item">
                    <a class="nav-link active" id="stores-tab" data-toggle="tab" href="#stores" role="tab">Stores</a>
                </li>
                <li class="styled-nav-item nav-item">
                    <a class="nav-link" id="archived-tab" data-toggle="tab" href="#archivedStores" role="tab">Archived Stores</a>
                </li>
            </ul>


            <div class="tab-content" id="storeTabContent">
                <!-- Active Stores -->
                <div class="tab-pane fade show active" id="stores" role="tabpanel">

                    {{-- Mobile results count (Figma: "25 people found") --}}
                    <span class="mobile-results-count d-none d-md-none">
                        {{ $stores->where('store_status', '!=', 3)->count() }} stores found
                    </span>

                    <div class="all_store_summary mt-3 mobile-hide-dt-controls">
                        <table class="table align-items-center" id="stores_table" style="min-width: 100%;">
                            <thead style="background-color: #717070;">
                                <tr>
                                    <th class="table_header_text store-name">STORE NAME</th>
                                    <th class="table_header_text organization">ORGANIZATION</th>
                                    <th class="table_header_text sales-rep">SALES REP</th>
                                    <th class="table_header_text store-status">STATUS</th>
                                    <th class="table_header_text total-orders">TOTAL ORDERS</th>
                                    <th class="table_header_text collected-amount text-right">COLLECTED AMOUNT</th>
                                    <th class="table_header_text created-at">CREATED AT</th>
                                    <th class="table_header_text closed-at">CLOSING DATE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stores as $store)
                                @if ($store->store_status != 3)
                                <tr>
                                    <td class="store-name text-left"><a href="{{ route('store.overview', ['id' => $store->id]) }}" target="_blank" style="color:black !important">{{ $store->store_name }}</a></td>
                                    <td class="organization text-left">{{ $store->organizationDetails->organization_name ?? '' }}</td>
                                    <td class="sales-rep text-left">{{ $store->userDetails->name ?? '' }}</td>
                                    <td class="store-status text-center">
                                        @if ($store->store_status == 1)
                                        <p class="status open">Open</p>
                                        @elseif ($store->store_status == 3)
                                        <p class="status archived">Archived</p>
                                        @else
                                        <p class="status closed">Closed</p>
                                        @endif
                                    </td>
                                    <td class="total-orders text-center">{{ $store->StoreOrders->count() ?? 0 }}</td>
                                    <td class="collected-amount text-right">{{ $store->StoreOrders->sum('paid_amount') ?? 0.00 }}</td>
                                    <td class="created-at text-center">{{ \Carbon\Carbon::parse($store->created_at)->format('m/d/Y') }}</td>
                                    <td class="closed-at text-center">{{ $store->close_date ? \Carbon\Carbon::parse($store->close_date)->format('m/d/Y') : '-' }}</td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- ===== MOBILE CARD VIEW (Active Stores) ===== --}}
                    <div class="mobile-store-list">
                        @php $hasActiveStore = false; @endphp
                        @foreach ($stores as $store)
                        @if ($store->store_status != 3)
                        @php $hasActiveStore = true; @endphp
                        @php
                        $repName = $store->userDetails->name ?? '';
                        $repInitials = '';
                        if ($repName) {
                        $parts = preg_split('/\s+/', trim($repName));
                        $repInitials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
                        }
                        $collected = $store->StoreOrders->sum('paid_amount') ?? 0.00;
                        @endphp
                        <div class="store-card">
                            <div class="store-card-header">
                                <div>
                                    <!-- <p class="store-card-title">{{ $store->store_name }}</p> -->
                                    <p class="store-card-title"><a href="{{ route('store.overview', ['id' => $store->id]) }}" target="_blank">{{ $store->store_name }}</a></p>
                                    <p class="store-card-org">{{ $store->organizationDetails->organization_name ?? '' }}</p>
                                </div>
                                @if ($store->store_status == 1)
                                <p class="status open">Open</p>
                                @elseif ($store->store_status == 3)
                                <p class="status archived">Archived</p>
                                @else
                                <p class="status closed">Closed</p>
                                @endif
                            </div>

                            @if ($repName)
                            <div class="store-card-rep">
                                <div class="rep-avatar">{{ $repInitials }}</div>
                                <span class="rep-name">{{ $repName }}</span>
                            </div>
                            @endif

                            <div class="store-card-stats">
                                <div>
                                    <div class="stat-label">Total Orders</div>
                                    <div class="stat-value">{{ $store->StoreOrders->count() ?? 0 }}</div>
                                </div>
                                <div>
                                    <div class="stat-label">Collected</div>
                                    <div class="stat-value collected">${{ number_format($collected, 2) }}</div>
                                </div>
                            </div>

                            <div class="store-card-footer">
                                <div class="store-card-dates">
                                    <span class="date-line">Created: <strong>{{ \Carbon\Carbon::parse($store->created_at)->format('m-d-Y') }}</strong></span>
                                    <span class="date-line">Closing: <strong>{{ $store->close_date ? \Carbon\Carbon::parse($store->close_date)->format('m-d-Y') : '—' }}</strong></span>
                                </div>
                                <a href="{{ route('store.overview', ['id' => $store->id]) }}" target="_blank" class="store-card-details-btn"><i class="fa fa-info-circle"></i> Details</a>
                            </div>
                        </div>
                        @endif
                        @endforeach

                        @if (!$hasActiveStore)
                        <div class="empty-state">No stores found</div>
                        @endif
                    </div>
                </div>

                <!-- Archived Stores -->
                <div class="tab-pane fade" id="archivedStores" role="tabpanel">
                    <div class="all_store_summary mt-3 mobile-hide-dt-controls">
                        <table class="table align-items-center" id="archived_stores_table" style="min-width: 100%;">
                            <thead style="background-color: #717070;">
                                <tr>
                                    <th class="table_header_text store-name">STORE NAME</th>
                                    <th class="table_header_text organization">ORGANIZATION</th>
                                    <th class="table_header_text sales-rep">SALES REP</th>
                                    <th class="table_header_text store-status">STATUS</th>
                                    <th class="table_header_text total-orders">TOTAL ORDERS</th>
                                    <th class="table_header_text collected-amount text-right">COLLECTED AMOUNT</th>
                                    <th class="table_header_text created-at">CREATED AT</th>
                                    <th class="table_header_text closed-at">CLOSING DATE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stores as $store)
                                @if ($store->store_status == 3)
                                <tr>
                                    <td class="store-name text-left"><a href="{{ route('store.overview', ['id' => $store->id]) }}" target="_blank" style="color:black !important">{{ $store->store_name }}</a></td>
                                    <td class="organization text-left">{{ $store->organizationDetails->organization_name ?? '' }}</td>
                                    <td class="sales-rep text-left">{{ $store->userDetails->name ?? '' }}</td>
                                    <td class="store-status text-center">
                                        @if ($store->store_status == 1)
                                        <p class="status open">Open</p>
                                        @elseif ($store->store_status == 3)
                                        <p class="status archived">Archived</p>
                                        @else
                                        <p class="status closed">Closed</p>
                                        @endif
                                    </td>
                                    <td class="total-orders text-center">{{ $store->StoreOrders->count() ?? 0 }}</td>
                                    <td class="collected-amount text-right">{{ $store->StoreOrders->sum('paid_amount') ?? 0.00 }}</td>
                                    <td class="created-at text-center">{{ \Carbon\Carbon::parse($store->created_at)->format('m/d/Y') }}</td>
                                    <td class="closed-at text-center">{{ $store->close_date ? \Carbon\Carbon::parse($store->close_date)->format('m/d/Y') : '-' }}</td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- ===== MOBILE CARD VIEW (Archived Stores) ===== --}}
                    <div class="mobile-store-list">
                        @php $hasArchivedStore = false; @endphp
                        @foreach ($stores as $store)
                        @if ($store->store_status == 3)
                        @php $hasArchivedStore = true; @endphp
                        @php
                        $repName = $store->userDetails->name ?? '';
                        $repInitials = '';
                        if ($repName) {
                        $parts = preg_split('/\s+/', trim($repName));
                        $repInitials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
                        }
                        $collected = $store->StoreOrders->sum('paid_amount') ?? 0.00;
                        @endphp
                        <div class="store-card">
                            <div class="store-card-header">
                                <div>
                                    <!-- <p class="store-card-title">{{ $store->store_name }}</p> -->
                                    <p class="store-card-title"><a href="{{ route('store.overview', ['id' => $store->id]) }}" target="_blank">{{ $store->store_name }}</a></p>
                                    <p class="store-card-org">{{ $store->organizationDetails->organization_name ?? '' }}</p>
                                </div>
                                <p class="status archived">Archived</p>
                            </div>

                            @if ($repName)
                            <div class="store-card-rep">
                                <div class="rep-avatar">{{ $repInitials }}</div>
                                <span class="rep-name">{{ $repName }}</span>
                            </div>
                            @endif

                            <div class="store-card-stats">
                                <div>
                                    <div class="stat-label">Total Orders</div>
                                    <div class="stat-value">{{ $store->StoreOrders->count() ?? 0 }}</div>
                                </div>
                                <div>
                                    <div class="stat-label">Collected</div>
                                    <div class="stat-value collected">${{ number_format($collected, 2) }}</div>
                                </div>
                            </div>

                            <div class="store-card-footer">
                                <div class="store-card-dates">
                                    <span class="date-line">Created: <strong>{{ \Carbon\Carbon::parse($store->created_at)->format('m-d-Y') }}</strong></span>
                                    <span class="date-line">Closing: <strong>{{ $store->close_date ? \Carbon\Carbon::parse($store->close_date)->format('m-d-Y') : '—' }}</strong></span>
                                </div>
                                <a href="{{ route('store.overview', ['id' => $store->id]) }}" target="_blank" class="store-card-details-btn"><i class="fa fa-info-circle"></i> Details</a>
                            </div>
                        </div>
                        @endif
                        @endforeach

                        @if (!$hasArchivedStore)
                        <div class="empty-state">No archived stores found</div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        // Initialise Select2 with search on the Sales Person dropdown.
        // minimumResultsForSearch:0 shows the search box always (even with few options).
        $('#user_filter').select2({
            minimumResultsForSearch: 0,
            placeholder: 'All',
            allowClear: false,
            width: 'resolve', // respects the element's existing width
            dropdownAutoWidth: true, // expand dropdown to fit longest name
        });

        // Get query params
        const urlParams = new URLSearchParams(window.location.search);

        const userFilter = urlParams.get('user_filter');
        const storeStatusFilter = urlParams.get('store_status_filter');

        // Set user filter if exists (must happen after select2 init)
        if (userFilter !== null) {
            $('#user_filter').val(userFilter).trigger('change');
        }

        // Set store status filter if exists
        if (storeStatusFilter !== null) {
            $('#store_status_filter').val(storeStatusFilter).trigger('change');
        }

        $('#stores_table').DataTable({
            pageLength: 25,
            ordering: false,
            lengthChange: true,
            searching: false,
        });

        $('#archived_stores_table').DataTable({
            pageLength: 25,
            ordering: false,
            lengthChange: true,
            searching: false,
        });

        $(document).on('click', '.edit-store', function(e) {
            e.preventDefault();

            const storeId = $(this).data('value');
            const url = "{{ route('store.overview', ['id' => '__ID__']) }}".replace('__ID__', storeId);

            window.open(url, '_blank');
        });

        $(document).on('click', '#create-store-button', function() {
            const url = "{{ route('create_store') }}";
            window.open(url, '_blank');
        });

        $('#pin-filter').on('click', function() {

            $(".se-pre-con").fadeIn('slow');

            let salesPerson = $('#user_filter').val();
            let storeStatus = $('#store_status_filter').val();

            let url = "{{ route('stores') }}" +
                "?user_filter=" + encodeURIComponent(salesPerson) +
                "&store_status_filter=" + encodeURIComponent(storeStatus);

            window.location.href = url;
        });
        $('#clear-filter').on('click', function() {

            $(".se-pre-con").fadeIn('slow');

            window.location.href = "{{ route('stores') }}";
        });

    });
    $(document).ready(function() {
        // Tab switch
        $(document).on("click", ".custom-tab", function(e) {
            e.preventDefault();

            let tabId = $(this).data("tab");

            $(".custom-tab").removeClass("active");
            $(this).addClass("active");

            $(".custom-tab-pane").addClass("d-none");
            $("#" + tabId).removeClass("d-none");
        });

        // tab switch
        $(document).on("click", ".custom-tab", function(e) {
            e.preventDefault();

            let tabId = $(this).data("tab");

            $(".custom-tab").removeClass("active");
            $(this).addClass("active");

            $(".custom-tab-pane").addClass("d-none");
            $("#" + tabId).removeClass("d-none");
        });

        // helper: render results
        function renderResults(items, targetId, emptyText = "No results found") {
            let $target = $("#" + targetId);
            $target.empty();

            if (!items || items.length === 0) {
                $target.html(`
                    <li class="text-center p-3 text-muted">${emptyText}</li>
                `);
                return;
            }

            $.each(items, function(index, item) {
                $target.append(`
                    <li class="list-group-item p-0 border-0">
                        <a href="${item.url}" target="_blank" class="search-result-item d-block text-decoration-none text-dark">
                            <div class="search-result-title">${item.title}</div>
                            <div class="search-result-meta">${item.subtitle}</div>
                        </a>
                    </li>
                `);
            });
        }

        // helper: loading state
        function showLoading() {
            $("#all-results").html(`
                <li class="text-center p-3 text-muted">
                    <i class="fa fa-search fa-spin"></i> Searching...
                </li>
            `);

            $("#stores-results").html(`
                <li class="text-center p-3 text-muted">
                    <i class="fa fa-search fa-spin"></i> Searching stores...
                </li>
            `);

            $("#orders-results").html(`
                <li class="text-center p-3 text-muted">
                    <i class="fa fa-search fa-spin"></i> Searching orders...
                </li>
            `);

            $("#customers-results").html(`
                <li class="text-center p-3 text-muted">
                    <i class="fa fa-search fa-spin"></i> Searching customers...
                </li>
            `);
        }

        // search
        let searchAjax = null;

        $("#orderSearch").on("keyup focus", function() {
            let query = $(this).val().trim();

            if (query.length < 2) {
                $("#searchResults").addClass("d-none");
                return;
            }

            $("#searchResults").removeClass("d-none");
            showLoading();

            // abort old request
            if (searchAjax) {
                searchAjax.abort();
            }

            searchAjax = $.ajax({
                url: "{{ route('store_orders.global.search') }}",
                method: "GET",
                data: {
                    keyword: query
                },
                dataType: "json",
                success: function(res) {
                    renderResults(res.all, "all-results", "No results found");
                    renderResults(res.stores, "stores-results", "No stores found");
                    renderResults(res.orders, "orders-results", "No orders found");
                    renderResults(res.customers, "customers-results", "No customers found");
                },
                error: function(xhr, status) {
                    if (status !== "abort") {
                        $("#all-results").html(`
                            <li class="text-center p-3 text-danger">Something went wrong</li>
                        `);
                        $("#stores-results").html(`
                            <li class="text-center p-3 text-danger">Something went wrong</li>
                        `);
                        $("#orders-results").html(`
                            <li class="text-center p-3 text-danger">Something went wrong</li>
                        `);
                        $("#customers-results").html(`
                            <li class="text-center p-3 text-danger">Something went wrong</li>
                        `);
                    }
                }
            });
        });

        // hide dropdown outside click
        $(document).on("click", function(e) {
            if (!$(e.target).closest(".navbar-left-search").length) {
                $("#searchResults").addClass("d-none");
            }
        });

        // keep dropdown open when clicking inside
        $(document).on("click", "#searchResults", function(e) {
            e.stopPropagation();
        });
    });
</script>

@endsection