@extends('layouts.app', ['activePage' => 'Team Stores', 'titlePage' => __('Team Stores')])

@section('sub-sidebar-content')

<style>
    .main_card {
        margin-top: 20px;
        border: unset;
        padding-bottom: 15px;
        border-radius: unset;
    }

    .accounting_header {
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
        height: 20px;
    }

    .accounting_sub_header {
        font-size: 19px;
    }

    .timeline_topic {
        font-size: 13px;
        color: #4E4C4C;
        font-weight: 600;
        margin-bottom: unset;
    }

    .timeline_details {
        font-size: 13px;
        color: #717070;
        font-weight: 400;
        margin-bottom: unset;
    }

    .account_topic {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: unset;
    }

    .account_details {
        font-size: 13px;
        font-weight: 400;
        margin-bottom: unset;
    }

    .account_details1 {
        font-size: 17px;
        font-weight: 600;
        margin-bottom: unset;
    }

    .timeline_row {
        margin: unset;
    }

    .timeline_topic_div {
        padding-bottom: 5px;
        width: 7rem;
    }

    .account_summary_div {
        padding-bottom: 5px;
        width: 9rem;
    }

    .account_summary_details_div {
        width: 5rem;
        text-align: right;
    }

    .table-borderless td {
        padding: .1rem;
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

    #deposit_table .table th,
    #deposit_table .table td {
        padding: .75rem;
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

        .bg-box.container-fluid.fix-nav.header-layout {
            margin-bottom: 0 !important;
        }

        .main_card {
            background-color: transparent !important;
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            margin-top: 10px !important;
        }

        /* Mobile specific styles */
        .mobile-card {
            background: #fff;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #f0f0f0;
        }

        .mobile-card-title {
            font-size: 14px;
            font-weight: 700;
            color: #333;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .mobile-card-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            font-size: 13px;
        }

        .mobile-card-label {
            color: #717070;
            font-weight: 500;
        }

        .mobile-card-value {
            font-weight: 600;
            text-align: right;
            color: #333;
        }

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

        .mobile-payment-card {
            background: #fff;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
            border: 1px solid #f0f0f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            cursor: pointer;
        }

        .mobile-payment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .mobile-payment-date-order {
            font-size: 12px;
            color: #717070;
            line-height: 1.4;
        }

        .mobile-payment-order-no {
            font-size: 13px;
            font-weight: 700;
            color: #333;
        }

        .mobile-payment-badge-row {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .mobile-status-badge {
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .mobile-status-badge.success {
            background: rgba(23, 165, 137, 0.12);
            color: #17a589;
        }

        .mobile-status-badge.failed {
            background: rgba(223, 22, 22, 0.12);
            color: #df1616;
        }

        .mobile-payment-body {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 12px;
            padding-top: 8px;
            border-top: 1px solid #f7f7f7;
        }

        .mobile-net-label {
            font-size: 11px;
            color: #999;
            margin-bottom: 2px;
        }

        .mobile-net-value {
            font-size: 18px;
            font-weight: 700;
            color: #333;
        }

        .mobile-type-badge {
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 6px;
            font-weight: 600;
            background: #eef2ff;
            color: #4f46e5;
        }

        .mobile-type-badge.refund {
            background: #fffbeb;
            color: #d97706;
        }

        /* .bg-box.container-fluid.fix-nav.header-layout{
            margin-bottom: 0 !important;
        } */
        
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
        <!-- Desktop Only Layout -->
        <div class="desktop-only">
            <div class="">
                <div class="row">
                    <div class="card_div" style="width: 80%;">
                        <strong class="accounting_header">Accounting Report</strong>
                    </div>
                </div>

                <hr style="margin: unset; margin-bottom: 15px; margin-top: 10px;">
            </div>

            <div style="padding-bottom: 20px;">
                <div class="" style="padding-bottom: 10px;">
                    <strong class="accounting_sub_header">{{ $store->store_name }}</strong>
                </div>
                <div class="row">
                    <!-- Store Timeline -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <b>Store Timeline</b>
                        </div>
                        <table class="table table-sm table-borderless" style="margin-bottom: 0;width: 80%;">
                            <tbody>
                                <tr>
                                    <td style="width: 60%; font-weight: 500;">Open Date</td>
                                    <td style="text-align: right;">
                                        {{ $store->open_date ? \Carbon\Carbon::parse($store->open_date)->format('j M Y (g:ia)') : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 500;">Close Date</td>
                                    <td style="text-align: right;">
                                        {{ $store->close_date ? \Carbon\Carbon::parse($store->close_date)->format('j M Y (g:ia)') : '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Accounting Summary -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <b>Accounting Summary</b>
                        </div>
                        <table class="table table-sm table-borderless" style="margin-bottom: 0;width: 80%;">
                            <tbody>
                                <tr>
                                    <td style="width: 65%; font-weight: 500;">Total Collected ($)</td>
                                    <td style="text-align: right;">
                                        {{ number_format($store->StoreOrders->sum('paid_amount'), 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 500;">Credit Card Fees ($)</td>
                                    <td style="text-align: right;">
                                        {{ number_format($store->StoreOrders->sum('paid_processing_fee'), 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 500;">Invoice Fees ($)</td>
                                    <td style="text-align: right;">
                                        {{ number_format($store->StoreOrders->sum('paid_invoice_amount'), 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Fundraising Summary -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <b>Fundraising Summary</b>
                        </div>
                        <table class="table table-sm table-borderless" style="margin-bottom: 0;width: 80%;">
                            <tbody>
                                <tr>
                                    <td style="width: 65%; font-weight: 500;">Fundraising Collected ($)</td>
                                    <td style="text-align: right;">
                                        {{ number_format($totalFundraising, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 500;">Card Processing Fees ($)</td>
                                    <td style="text-align: right;">
                                        {{ number_format($totalFundraising * 3/100, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 500;">Net Fundraising ($)</td>
                                    <td style="text-align: right;">
                                        {{ number_format($totalFundraising * 97/100, 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div style="background-color: #FCFCFC; padding: 15px; margin-bottom: 10px;">
                <div class="row" style="padding: 1rem .5rem;background-color: #efefef;" style="margin-left: unset;">
                    <div><img src="{{asset('assets')}}/img/team_stores/report.png" style="width: 17px;" /></div>
                    <div style="padding: 1px; padding-left: 11px;">
                        <b>Payments</b>
                    </div>
                    <div style="margin-left: auto; display: flex; align-items: center;">
                        Payment Type
                        <select id="payment_type_filter" style="height: 25px; border: unset; width: 120px; margin-left: 10px;">
                            <option value="all">All</option>
                            <option value="payment">Payment</option>
                            <option value="refund">Refund</option>
                        </select>
                        <button class="btn btn-sm btn-primary filter_payments" style="margin-left: 15px; height: 25px; padding-top: 3px;">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                        <button class="btn btn-sm btn-secondary ml-2" id="reset_deposit_filters" style="height: 25px; padding-top: 3px;">
                            <i class="fa fa-sync"></i> Reset
                        </button>
                    </div>
                </div>


                <div style=" padding-top: 15px; overflow-x: auto; padding-left: 27px;">
                    <table class="table align-items-center data-tables" id="deposit_table" style="min-width: 100%;">
                        <thead style="background-color: #717070;">
                            <th scope="col" class="table_header_text text-center">DATE</th>
                            <th scope="col" class="table_header_text text-center">ORDER NO </th>
                            <th scope="col" class="table_header_text text-center">DEPOSIT ID </th>
                            <th scope="col" class="table_header_text text-center">COLLECTED / REFUND ($) </th>
                            <th scope="col" class="table_header_text text-center">CREDIT CARD FEE ($)</th>
                            <th scope="col" class="table_header_text text-center">NET DEPOSIT ($)</th>
                            <th scope="col" class="table_header_text text-center">TYPE</th>
                            <th scope="col" class="table_header_text text-center">STATUS </th>
                        </thead>

                        <tbody id="deposit_report_body">
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

        <!-- Mobile Only Layout -->
        <div class="mobile-only">
            <!-- 1. Accounting Report Title Card -->
            <div class="mobile-card">
                <strong style="font-size: 18px; color: #333; display: block; margin-bottom: 4px;">Accounting Report</strong>
                <span style="font-size: 13px; color: #717070;">{{ $store->store_name }}</span>
            </div>

            <!-- 2. Store Timeline Card -->
            <div class="mobile-card">
                <div class="mobile-card-title">
                    <i class="fa fa-clock-o" style="color: #17a589;"></i> Store Timeline
                </div>
                <div class="mobile-card-row">
                    <span class="mobile-card-label">Open Date</span>
                    <span class="mobile-card-value">{{ $store->open_date ? \Carbon\Carbon::parse($store->open_date)->format('j M Y, g:ia') : '' }}</span>
                </div>
                <div class="mobile-card-row" style="border-top: 1px solid #f7f7f7;">
                    <span class="mobile-card-label">Close Date</span>
                    <span class="mobile-card-value">{{ $store->close_date ? \Carbon\Carbon::parse($store->close_date)->format('j M Y, g:ia') : '' }}</span>
                </div>
            </div>

            <!-- 3. Accounting Summary Card -->
            <div class="mobile-card">
                <div class="mobile-card-title">
                    <i class="fa fa-usd" style="color: #17a589;"></i> Accounting Summary
                </div>
                <div class="mobile-card-row">
                    <span class="mobile-card-label">Total Collected</span>
                    <span class="mobile-card-value" style="color: #17a589;">${{ number_format($store->StoreOrders->sum('paid_amount'), 2) }}</span>
                </div>
                <div class="mobile-card-row" style="border-top: 1px solid #f7f7f7;">
                    <span class="mobile-card-label">Credit Card Fees</span>
                    <span class="mobile-card-value" style="color: #df1616;">${{ number_format($store->StoreOrders->sum('paid_processing_fee'), 2) }}</span>
                </div>
                <div class="mobile-card-row" style="border-top: 1px solid #f7f7f7;">
                    <span class="mobile-card-label">Invoice Fees</span>
                    <span class="mobile-card-value" style="color: #333;">${{ number_format($store->StoreOrders->sum('paid_invoice_amount'), 2) }}</span>
                </div>
            </div>

            <!-- 4. Fundraising Summary Card -->
            <div class="mobile-card">
                <div class="mobile-card-title">
                    <i class="fa fa-gift" style="color: #17a589;"></i> Fundraising Summary
                </div>
                <div class="mobile-card-row">
                    <span class="mobile-card-label">Fundraising Collected</span>
                    <span class="mobile-card-value" style="color: #17a589;">${{ number_format($totalFundraising, 2) }}</span>
                </div>
                <div class="mobile-card-row" style="border-top: 1px solid #f7f7f7;">
                    <span class="mobile-card-label">Card Processing Fees</span>
                    <span class="mobile-card-value" style="color: #df1616;">${{ number_format($totalFundraising * 3/100, 2) }}</span>
                </div>
                <div class="mobile-card-row" style="border-top: 1px solid #f7f7f7;">
                    <span class="mobile-card-label">Net Fundraising</span>
                    <span class="mobile-card-value" style="color: #17a589;">${{ number_format($totalFundraising * 97/100, 2) }}</span>
                </div>
            </div>

            <!-- 5. Search Bar -->
            <div class="mobile-search-wrapper">
                <i class="fa fa-search mobile-search-icon"></i>
                <input type="text" id="mobile_search_input" class="mobile-search-input" placeholder="Search order ID, or deposit id">
            </div>

            <!-- 6. Filter Panel Toggle -->
            <div class="mobile-filter-header" onclick="toggleMobileFilters()">
                <span>
                    <i class="fa fa-filter" style="margin-right: 5px;"></i> Filter Payments
                    <span class="badge badge-success" id="mobile_filter_badge" style="display:none; background-color: #17a589; color: #fff; font-size: 11px; font-weight: 700; margin-left: 5px; padding: 2px 7px; border-radius: 10px; line-height: 1.4; vertical-align: middle;">0</span>
                    <!-- <span class="badge badge-success" id="mobile_filter_badge" style="display:none; background-color: #17a589; margin-left: 5px;">0</span> -->
                </span>
                <i class="fa fa-chevron-down" id="mobile_filter_chevron"></i>
            </div>

            <!-- Filter Panel Body -->
            <div class="mobile-filter-body" id="mobile_filter_container" style="display: none;">
                <div class="mobile-filter-group">
                    <label class="mobile-filter-label">Payment Type</label>
                    <select id="mobile_payment_type_filter" class="mobile-filter-select">
                        <option value="all">All</option>
                        <option value="payment">Payment</option>
                        <option value="refund">Refund</option>
                    </select>
                </div>
                <div class="mobile-filter-group">
                    <label class="mobile-filter-label">Status</label>
                    <select id="mobile_status_filter" class="mobile-filter-select">
                        <option value="all">All</option>
                        <option value="success">Success</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>
                <div class="mobile-filter-group">
                    <label class="mobile-filter-label">Sort by</label>
                    <select id="mobile_sort_filter" class="mobile-filter-select">
                        <option value="date_newest">Date (newest)</option>
                        <option value="date_oldest">Date (oldest)</option>
                        <option value="amount_highest">Net Deposit (highest)</option>
                        <option value="amount_lowest">Net Deposit (lowest)</option>
                    </select>
                </div>
                <div class="mobile-filter-actions">
                    <button type="button" class="mobile-btn-reset" onclick="resetMobileFilters()">Reset</button>
                    <button type="button" class="mobile-btn-apply" onclick="applyMobileFilters()">Apply Filters</button>
                </div>
            </div>

            <!-- 7. Payments list -->
            <div id="mobile_payments_list">
                <!-- Dynamic cards populated by JS -->
            </div>
        </div>

    </div>

</div>

<script>
    let depositDT;

    $(document).ready(function() {
        $('.se-pre-con').fadeOut('slow');

        depositDT = $('#deposit_table').DataTable({
            pageLength: 10,
            responsive: true,
            ordering: true,
            searching: true,
            language: {
                emptyTable: "No deposits found."
            }
        });

        fetchDepositReportData();

        $('#reset_deposit_filters').on('click', function() {
            window.location.href = '{{ route("store.accounting_report", $store->id) }}';
        });

        $('.filter_payments').on('click', function() {
            fetchDepositReportData();
        });

        // Search trigger for mobile view
        $('#mobile_search_input').on('keyup', function() {
            renderMobilePayments();
        });
    });

    // =======================
    // FETCH DEPOSIT REPORT
    // =======================

    function fetchDepositReportData() {
        $('.se-pre-con').fadeIn('slow');
        $.ajax({
            url: '{{ route("store.get_store_payments") }}',
            data: {
                store_id: '{{ $store->id }}',
                payment_type: $('#payment_type_filter').val()
            },
            type: 'GET',
            success: function(data) {

                depositDT.clear();
                window.allPaymentsData = data; // Save globally for mobile use

                if (data.length > 0) {
                    data.forEach(function(deposit) {
                        let payment_status = deposit.is_success == 1 ?
                            '<span class="text-success"><i class="fa fa-check-circle"></i> success</span>' :
                            '<span class="text-danger"><i class="fa fa-times-circle"></i> failed</span>';

                        depositDT.row.add([
                            new Date(deposit.created_at).toLocaleDateString('en-US'),
                            deposit.store_order_no,
                            deposit.transaction_id ?? 'N/A',
                            deposit.payment_amount,
                            deposit.processing_fee,
                            deposit.total_amount,
                            deposit.is_refund == 1 ?
                            '<span class="text-warning">Refund</span>' :
                            '<span class="text-success">Payment</span>',
                            payment_status
                        ]);
                    });
                }

                depositDT.draw();
                renderMobilePayments(); // Also populate mobile view
                $('.se-pre-con').fadeOut('slow');
            },
            error: function(error) {
                console.error('Error fetching deposit report data:', error);
                $('.se-pre-con').fadeOut('slow');
            }
        });
    }

    // =======================
    // MOBILE VIEW FUNCTIONS
    // =======================

    function renderMobilePayments() {
        let data = window.allPaymentsData ? [...window.allPaymentsData] : [];
        let searchQuery = $('#mobile_search_input').val().toLowerCase();
        let paymentType = $('#mobile_payment_type_filter').val();
        let statusFilter = $('#mobile_status_filter').val();
        let sortBy = $('#mobile_sort_filter').val();

        // 1. Search Query Filter
        if (searchQuery) {
            data = data.filter(function(item) {
                let orderNo = (item.store_order_no || '').toLowerCase();
                let transId = (item.transaction_id || '').toLowerCase();
                return orderNo.indexOf(searchQuery) > -1 || transId.indexOf(searchQuery) > -1;
            });
        }

        // 2. Status Filter
        if (statusFilter !== 'all') {
            data = data.filter(function(item) {
                let isSuccess = item.is_success == 1;
                return statusFilter === 'success' ? isSuccess : !isSuccess;
            });
        }

        // 3. Sort logic
        data.sort(function(a, b) {
            if (sortBy === 'date_newest') {
                return new Date(b.created_at) - new Date(a.created_at);
            } else if (sortBy === 'date_oldest') {
                return new Date(a.created_at) - new Date(b.created_at);
            } else if (sortBy === 'amount_highest') {
                return parseFloat(b.total_amount || 0) - parseFloat(a.total_amount || 0);
            } else if (sortBy === 'amount_lowest') {
                return parseFloat(a.total_amount || 0) - parseFloat(b.total_amount || 0);
            }
            return 0;
        });

        // 4. Update Filter Active Badge count
        let activeFiltersCount = 0;
        if (paymentType !== 'all') activeFiltersCount++;
        if (statusFilter !== 'all') activeFiltersCount++;
        if (activeFiltersCount > 0) {
            $('#mobile_filter_badge').text(activeFiltersCount).css('display', 'inline-block');
            // $('#mobile_filter_badge').text(activeFiltersCount).show();
        } else {
            $('#mobile_filter_badge').hide();
        }

        // 5. Generate and render HTML
        let html = '';
        if (data.length === 0) {
            html = '<div class="text-center py-4 text-muted">No deposits found.</div>';
        } else {
            data.forEach(function(deposit) {
                let formattedDate = new Date(deposit.created_at).toLocaleDateString('en-US');
                let isSuccess = deposit.is_success == 1;
                let statusText = isSuccess ? 'Success' : 'Failed';
                let statusClass = isSuccess ? 'success' : 'failed';
                let statusIcon = isSuccess ? 'fa-check-circle' : 'fa-times-circle';

                let isRefund = deposit.is_refund == 1;
                let typeText = isRefund ? 'Refund' : 'Payment';
                let typeClass = isRefund ? 'refund' : '';

                html += `
                <div class="mobile-payment-card" onclick="toggleCardDetails(this)">
                    <div class="mobile-payment-header">
                        <div class="mobile-payment-date-order">
                            <div>${formattedDate}</div>
                            <div class="mobile-payment-order-no">#${deposit.store_order_no}</div>
                        </div>
                        <div class="mobile-payment-badge-row">
                            <span class="mobile-status-badge ${statusClass}">
                                <i class="fa ${statusIcon}"></i> ${statusText}
                            </span>
                            <i class="fa fa-chevron-down text-muted ml-1" style="font-size: 11px;"></i>
                        </div>
                    </div>
                    <div class="mobile-payment-body">
                        <div>
                            <div class="mobile-net-label">Net Deposit</div>
                            <div class="mobile-net-value">$${parseFloat(deposit.total_amount).toFixed(2)}</div>
                        </div>
                        <div>
                            <span class="mobile-type-badge ${typeClass}">${typeText}</span>
                        </div>
                    </div>
                    <div class="mobile-payment-details" style="display: none; margin-top: 12px; padding-top: 12px; border-top: 1px dashed #f0f0f0;">
                        <div class="mobile-card-row">
                            <span class="mobile-card-label">Deposit ID</span>
                            <span class="mobile-card-value">${deposit.transaction_id ?? 'N/A'}</span>
                        </div>
                        <div class="mobile-card-row">
                            <span class="mobile-card-label">Collected / Refund</span>
                            <span class="mobile-card-value">$${parseFloat(deposit.payment_amount).toFixed(2)}</span>
                        </div>
                        <div class="mobile-card-row">
                            <span class="mobile-card-label">Credit Card Fee</span>
                            <span class="mobile-card-value">$${parseFloat(deposit.processing_fee).toFixed(2)}</span>
                        </div>
                    </div>
                </div>
                `;
            });
        }

        $('#mobile_payments_list').html(html);
    }

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

    function toggleCardDetails(cardElement) {
        let details = $(cardElement).find('.mobile-payment-details');
        let chevron = $(cardElement).find('.mobile-payment-header .fa-chevron-down, .mobile-payment-header .fa-chevron-up');
        if (details.is(':visible')) {
            details.slideUp(200);
            chevron.removeClass('fa-chevron-up').addClass('fa-chevron-down');
        } else {
            details.slideDown(200);
            chevron.removeClass('fa-chevron-down').addClass('fa-chevron-up');
        }
    }

    function applyMobileFilters() {
        let currentMobileType = $('#mobile_payment_type_filter').val();
        let currentDesktopType = $('#payment_type_filter').val();

        if (currentMobileType !== currentDesktopType) {
            $('#payment_type_filter').val(currentMobileType);
            fetchDepositReportData();
        } else {
            renderMobilePayments();
        }
        toggleMobileFilters();
    }

    function resetMobileFilters() {
        $('#mobile_search_input').val('');
        $('#mobile_payment_type_filter').val('all');
        $('#mobile_status_filter').val('all');
        $('#mobile_sort_filter').val('date_newest');
        $('#payment_type_filter').val('all');
        fetchDepositReportData();
        toggleMobileFilters();
    }
</script>

@endsection
@section('content')
@include('pages.stores.layouts.sidebar', ['sub_content' => 'overview'])
@endsection