@extends('layouts.app', ['activePage' => 'order_embellishments_report', 'titlePage' => __('Order Embellishments Report')])

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
    .order_sammary_table {
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
        padding: 5px;
        text-align: center;
        width: 70px;
        background-color: #2dce89;
        border: none;
        cursor: pointer;
        color: white !important;
    }
    .excel_btn {
        padding: 5px;
        text-align: center;
        width: 70px;
        border: 1px solid#DEDEDE;
        /* background-color: #c9cecc; */
        cursor: pointer;
        color: rgb(0, 0, 0) !important;
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
    .select-border-style{
        border: 1px solid #b3b3b3 !important;
        border-radius: 0rem !important;
    }
    .select2-selection--single{
        background-color: #F8F8F8 !important;
    }
    .d_flex_and_align_center{
        display: flex;
        align-items: center;
    }
    .select-width-style .select2.select2-container.select2-container--default{
        width: 8rem !important;
    }
    .select-width-style-item .select2.select2-container.select2-container--default{
        width: 10rem !important;
    }
    .page-item .page-link, .page-item span {
        border-radius: 0 !important;
        font-size: 0.7rem;
    }
    .page-item.active .page-link {
        z-index: 1;
        color: grey;
        border-color: #cccccc;
        background-color: #e9e9e9;
        box-shadow:none;
    }
    .table thead th, .table tbody td {
        padding-top: 0;
        padding-bottom: 0;
    }
    .table tbody td {
        padding-top: 7.5px;
        padding-bottom: 7.5px;
    }
    table.dataTable thead .sorting:before, table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:before, table.dataTable thead .sorting_desc_disabled:after {
        bottom: 0.6rem !important;
    }
    table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
        right: .7rem !important;
    }
    table.dataTable thead .sorting:before, table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:before, table.dataTable thead .sorting_desc_disabled:after {
    bottom: .65em;
    }
    table.dataTable thead .sorting:before,table.dataTable thead .sorting_asc:before,table.dataTable thead .sorting_desc:before,table.dataTable thead .sorting_asc_disabled:before,table.dataTable thead .sorting_desc_disabled:before {
        content: "\f0de";
        font-family: FontAwesome;
    }
    table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:after,table.dataTable thead .sorting_asc_disabled:after,table.dataTable thead .sorting_desc_disabled:after {
        content: "\f0dd";
        font-family: FontAwesome;
        right: .65rem !important;
    }

    /* Mobile Sort dropdown — hidden on desktop, visible only on mobile */
    .mobile-sort-wrapper {
        display: none;
    }

    @media (max-width: 767px) {
        .content-position {
            padding-left: 12px !important;
            padding-right: 12px !important;
            background-color: transparent !important;
        }
        .content-position .card {
            background-color: transparent !important;
            box-shadow: none !important;
            border: none !important;
        }
        .order_sammary_table {
            padding-left: 0 !important;
            padding-right: 0 !important;
            padding-top: 0 !important;
            overflow-x: visible !important;
        }
        #order_embellishments_report_wrapper {
            padding: 0 !important;
            display: flex !important;
            flex-direction: column !important;
        }
        #order_embellishments_report_wrapper .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
            display: flex !important;
            flex-direction: column !important;
        }
        #order_embellishments_report_wrapper .row > div {
            padding-left: 0 !important;
            padding-right: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            flex: none !important;
        }

        #order_embellishments_report_wrapper .row:first-child {
            display: flex !important;
            flex-direction: column !important;
        }
        /* Search bar container div (usually 2nd col in standard BS Datatables layout) */
        #order_embellishments_report_wrapper .row:first-child > div:has(.dataTables_filter),
        #order_embellishments_report_wrapper .row:first-child > div:nth-child(2) {
            order: -1 !important;
            width: 100% !important;
        }
        /* Length container div (usually 1st col in standard BS Datatables layout) */
        #order_embellishments_report_wrapper .row:first-child > div:has(.dataTables_length),
        #order_embellishments_report_wrapper .row:first-child > div:nth-child(1) {
            order: 2 !important;
            width: 100% !important;
        }

        /* 1. TOP: Search Bar */
        #order_embellishments_report_wrapper .dataTables_filter {
            width: 100% !important;
            text-align: left !important;
            float: none !important;
            margin-bottom: 15px !important;
            background-color: #f8f9fa !important;
            border: 1px solid #e9ecef !important;
            border-radius: 14px !important;
            padding: 4px 12px !important;
            box-sizing: border-box !important;
        }
        #order_embellishments_report_wrapper .dataTables_filter label {
            width: 100% !important;
            display: flex !important;
            align-items: center !important;
            font-size: 0 !important; /* Hide 'Search:' text */
            position: relative !important;
            margin-bottom: 0 !important;
        }
        #order_embellishments_report_wrapper .dataTables_filter label::before {
            content: "\f002";
            font-family: FontAwesome;
            color: #495057;
            font-size: 14px;
            margin-right: 10px;
        }
        #order_embellishments_report_wrapper .dataTables_filter input {
            width: 100% !important;
            margin-left: 0 !important;
            height: 38px !important;
            background: transparent !important;
            border: none !important;
            font-size: 13px !important;
            color: #6c757d !important;
            box-shadow: none !important;
            outline: none !important;
            padding-left: 0 !important;
        }

        /* Parent div wrapping dataTables_length + mobile-sort-wrapper */
        #order_embellishments_report_wrapper .row:first-child > div:nth-child(1) {
            display: flex !important;
            align-items: center !important;
            width: 100% !important;
            margin-bottom: 15px !important;
        }

        /* 2. SECOND: Controls row (Show entries on left, Sort by on right) */
        #order_embellishments_report_wrapper .dataTables_length {
            float: none !important;
            display: inline-flex !important;
            align-items: center !important;
            font-size: 13px !important;
            color: #6c757d !important;
            margin-bottom: 0 !important;
            width: auto !important;
        }
        #order_embellishments_report_wrapper .dataTables_length label {
            display: inline-flex !important;
            align-items: center !important;
            margin-bottom: 0 !important;
            gap: 2px !important;
            color: #6c757d !important;
            font-size: 13px !important;
        }
        #order_embellishments_report_wrapper .dataTables_length select {
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            padding: 4px 24px 4px 10px !important;
            background-color: #fff !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            color: #1a202c !important;
            height: 32px !important;
        }
        /* Real Sort by dropdown - visible on mobile only */
        .mobile-sort-wrapper {
            display: inline-flex !important;
            align-items: center !important;
            margin-left: auto !important;
            gap: 2px !important;
            font-size: 13px !important;
            color: #6c757d !important;
        }
        .mobile-sort-wrapper select {
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            /* padding: 4px 10px !important; */
            background-color: #fff !important;
            font-size: 13px !important;
            /* font-weight: 600 !important; */
            color: #1a202c !important;
            height: 32px !important;
            /* width: 80px !important; */
            cursor: pointer !important;
        }

        /* 3. THIRD: Cards List Table */
        .order_sammary_table {
            order: 3 !important;
        }
        #order_embellishments_report,
        #order_embellishments_report tbody,
        #order_embellishments_report tr,
        #order_embellishments_report td {
            display: block !important;
            width: 100% !important;
        }

        #order_embellishments_report thead {
            display: none !important;
        }

        #order_embellishments_report tbody tr {
            background: #ffffff !important;
            border: 1px solid #f1f3f5 !important;
            border-radius: 14px !important;
            margin-bottom: 12px !important;
            padding: 14px 16px !important;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04) !important;
            box-sizing: border-box !important;
            display: flex !important;
            flex-wrap: wrap !important;
        }

        /* Card Content Order: 1. Order No (#002694) */
        #order_embellishments_report tbody tr td:nth-child(1) {
            order: 1 !important;
            width: 100% !important;
            padding: 0 !important;
            border: none !important;
        }
        #order_embellishments_report tbody tr td:nth-child(1) a {
            font-size: 15px !important;
            font-weight: 700 !important;
            color: #212529 !important;
            text-decoration: none !important;
        }
        /* Add icon to Order No link */
        #order_embellishments_report tbody tr td:nth-child(1) a {
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
        }
        #order_embellishments_report tbody tr td:nth-child(1) a::after {
            content: "\f35d";
            font-family: "FontAwesome";
            font-size: 12px;
            color: #006affff;
            font-weight: 400;
            margin-left: 10px !important;
        }

        /* Add icon to Organization link */
        #order_embellishments_report tbody tr td:nth-child(2) a {
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
        }
        #order_embellishments_report tbody tr td:nth-child(2) a::after {
            content: "\f35d";
            font-family: "FontAwesome";
            font-size: 11px;
            color: #006affff;
            font-weight: 400;
            margin-left: 10px !important;
        }
        /* Card Content Order: 2. Organization (Test Organization) */
        #order_embellishments_report tbody tr td:nth-child(2) {
            order: 2 !important;
            width: 100% !important;
            padding: 2px 0 12px 0 !important;
            border: none !important;
        }
        #order_embellishments_report tbody tr td:nth-child(2) a {
            font-size: 13.5px !important;
            font-weight: 600 !important;
            color: #343a40 !important;
            text-decoration: none !important;
        }

        /* Card Content Order: 3, 4, 5. Sales Rep | Ex-Factory Date | Factory */
        #order_embellishments_report tbody tr td:nth-child(3) {
            order: 3 !important;
            width: 45% !important;
            padding-right: 100px !important;
        }
        #order_embellishments_report tbody tr td:nth-child(4) {
            width: 30% !important;
            order: 4 !important;
        }
        #order_embellishments_report tbody tr td:nth-child(5) {
            width: 25% !important;
            order: 5 !important;
        }
        #order_embellishments_report tbody tr td:nth-child(3),
        #order_embellishments_report tbody tr td:nth-child(4),
        #order_embellishments_report tbody tr td:nth-child(5) {
            /* width: 33.333% !important; */
            padding: 0 !important;
            border: none !important;
            text-align: left !important;
            font-size: 11.5px !important;
            font-weight: 600 !important;
            color: #212529 !important;
            line-height: 1.3 !important;
        }

        #order_embellishments_report tbody tr td:nth-child(3)::before {
            content: "Sales Rep\A";
            white-space: pre-wrap;
            display: block;
            font-size: 10px;
            font-weight: 400;
            color: #a0aec0;
            margin-bottom: 2px;
        }

        #order_embellishments_report tbody tr td:nth-child(4)::before {
            content: "Ex-Factory Date\A";
            white-space: pre-wrap;
            display: block;
            font-size: 10px;
            font-weight: 400;
            color: #a0aec0;
            margin-bottom: 2px;
        }

        #order_embellishments_report tbody tr td:nth-child(5)::before {
            content: "Factory\A";
            white-space: pre-wrap;
            display: block;
            font-size: 10px;
            font-weight: 400;
            color: #a0aec0;
            margin-bottom: 2px;
        }

        /* Footer: Info & Pagination */
        #order_embellishments_report_wrapper .dataTables_info {
            float: left !important;
            padding-top: 8px !important;
            font-size: 12px !important;
            color: #adb5bd !important;
        }

        #order_embellishments_report_wrapper .dataTables_paginate {
            float: right !important;
            margin-top: 0 !important;
        }

        #order_embellishments_report_wrapper .pagination {
            margin: 0 !important;
        }

        #order_embellishments_report_wrapper .page-item .page-link {
            border-radius: 6px !important;
            margin: 0 2px !important;
            border: 1px solid #e9ecef !important;
            color: #495057 !important;
            padding: 4px 8px !important;
            font-size: 12px !important;
        }

        #order_embellishments_report_wrapper .page-item.active .page-link {
            background-color: #212529 !important;
            border-color: #212529 !important;
            color: #ffffff !important;
        }
    }
</style>
<div class=" mb-5 content-position">

    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Order Embellishments Report</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12" style="margin-top: 15px; margin-bottom: 25px; padding-bottom: 20px;">
        <div class="card" style="border: unset;">
            <div class="col-md-12 table-responsive order_sammary_table" style="padding-top: 0px;">
                <table class="table align-items-center" id="order_embellishments_report">

                    <thead style="background-color: rgba(50, 50, 50, 1) !important;">
                        <tr>
                            <th scope="col" class="table_header_text text-left">Order No</th>
                            <th scope="col" class="table_header_text text-left">Organization</th>
                            <th scope="col" class="table_header_text text-center">Sales Rep</th>
                            <th scope="col" class="table_header_text text-center">Ex-Factory Date</th>
                            <th scope="col" class="table_header_text text-left">Factory</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)

                            @php
                                $factoryNames = $order->orderItems
                                    ->pluck('factoryDetails.factory_code')
                                    ->filter()
                                    ->unique()
                                    ->implode(', ');
                            @endphp

                            <tr>
                                <td class="text-left" data-order="{{ $order->id }}">
                                    <a href="{{ url('/order_details/edit/' . $order->id . '/order?active_tab=order') }}" target="_blank" style="text-decoration: underline;color: #2dce89;">{{ $order->order_no ?? $order->id }}</a>
                                </td>

                                <td class="text-left">
                                    <a href="{{ route('organizations.info', ['id' => ($order->organizationDetails)->id]) }}" target="_blank" style="color: rgba(50, 50, 50, 1) !important" class="info" >{{ optional($order->organizationDetails)->organization_name ?? '-' }}</a>
                                </td>

                                <td class="text-center">
                                    @if($order->userDetails)
                                        {{ $order->userDetails->name
                                            ?? trim(
                                                ($order->userDetails->first_name ?? '') . ' ' .
                                                ($order->userDetails->last_name ?? '')
                                            )
                                        }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td class="text-center"
                                    data-order="{{ $order->ex_factory_date ?? '' }}">

                                    @if(!empty($order->ex_factory_date))
                                        {{ \Carbon\Carbon::parse($order->ex_factory_date)->format('m/d/Y') }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td class="text-left">
                                    {{ $factoryNames ?: '-' }}
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    No embellished orders found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function () {
    // $('#order_embellishments_report').DataTable({
    var table = $('#order_embellishments_report').DataTable({
        paging: true,
        pageLength: 50,
        searching: true,
        ordering: true,

        // First column, descending
        order: [[0, 'desc']],

        info: true,
        lengthChange: true,
        language: {
            search: 'Search:',
            paginate: {
                previous: '<',
                next: '>'
            }
        }
    });

    // Inject a real working "Sort by" dropdown on mobile next to the Show entries
    var sortOptions = [
        { label: 'Order ID',       col: 0 },
        { label: 'Organization',   col: 1 },
        { label: 'Sales Rep',      col: 2 },
        { label: 'Ex-Factory Date',col: 3 },
        { label: 'Factory',        col: 4 }
    ];

    var sortSelect = $('<select id="mobile_sort_select"></select>');
    $.each(sortOptions, function(i, o) {
        sortSelect.append($('<option>', { value: o.col, text: o.label }));
    });
    // Default to first column (Order ID)
    sortSelect.val(0);

    var sortWrapper = $('<div class="mobile-sort-wrapper"><span>Sort by</span></div>');
    sortWrapper.append(sortSelect);

    // Insert after the dataTables_length div inside the first row
    $('#order_embellishments_report_wrapper .dataTables_length').after(sortWrapper);

    // Listen for change and apply sort to the DataTable
    sortSelect.on('change', function() {
        var col = parseInt($(this).val());
        table.order([col, 'asc']).draw();
    });
});
</script>
@endsection
