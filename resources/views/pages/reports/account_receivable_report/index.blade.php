@extends('layouts.app', ['activePage' => 'ar_report', 'titlePage' => __('AR Report')])

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
        min-width: 8rem !important;
        width: auto !important;
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
    .selectbox-div{
        border: 1px solid #B3B3B3;
        border-radius: 1rem;
        padding: 1%;
        padding-left: 6%;
    }
    .searchbox-layout{
        margin-top: 0 !important;
        width: 100% !important;
        height: 29px;
        font-size: .7rem;
        color: #B3B3B3;
        border: unset;
    }
    #admin_clear_btn{
        border-color: #285e45;
        background-color: #f5365c;
        box-shadow: unset;
    }
    #payment_received_btn{
        border-color: #1a3a2c;
        background-color: #0cda51;
        box-shadow: unset;
    }
    #payMultipleModal .table td {
        padding: .2rem 1.5rem;
    }
    .no-top-border{
        border-top: none !important;
    }
    #order_summary_filter label{
        width: 76%;
    }
    div.dataTables_wrapper div.dataTables_filter input{
        width: 95%;
    }

    /* =====================================================================
       AR REPORT — MOBILE LAYOUT
       ===================================================================== */

    /* Mobile-only elements are hidden on desktop */
    .ar-m-only { display: none; }
    /* Wrapper around the date pills: invisible to layout on desktop */
    .ar-pills { display: contents; }

    @media (max-width: 767px) {

        /* ---------- Page shell ---------- */
        .content-position {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }
        #scrollTable {
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-top: 8px !important;
        }
        #scrollTable > .card {
            background: transparent;
            box-shadow: none;
        }

        /* ---------- Top bar: Export button ---------- */
        /* Page header (Figma): "< BACK TO HOME", then title + Export on one row */
        .ar-m-topbar {
            display: block;
            margin-top: 4px;
            margin-bottom: 10px;
        }
        .ar-m-titlerow {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 12px;
        }
        .ar-m-back,
        .ar-m-title { display: none; }
        /* Shown only when the layout's own header was found and hidden (see JS) */
        body.ar-own-header .ar-m-back {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin: 6px 0 14px;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 1.2px;
            color: #4b5563;
            text-decoration: none;
        }
        body.ar-own-header .ar-m-back i { font-size: 11px; }
        body.ar-own-header .ar-m-titlerow { justify-content: space-between; }
        body.ar-own-header .ar-m-title {
            display: block;
            margin: 0;
            min-width: 0;
            font-size: 22px;
            font-weight: 700;
            line-height: 1.25;
            color: #111827;
        }
        /* Hide the layout's centered white title strip on this page (mobile only).
           Higher specificity than the layout's ".header1 { display:block !important }". */
        body.ar-own-header .main-content .header1 {
            display: none !important;
        }
        /* The layout's top navbar (desktop "BACK TO HOME" bar) peeks out under the
           dark mobile bar as a thin white strip; our header replaces it on mobile. */
        body.ar-own-header .main-content > .navbar-top,
        body.ar-own-header .main-content > #navbar-main { display: none !important; }
        .ar-m-export-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            height: 40px;
            padding: 0 16px;
            border: none;
            border-radius: 8px;
            background: #47D6B6;
            color: #fff;
            font-size: 15px;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(71, 214, 182, 0.35);
        }

        /* ---------- Filter form becomes a 2-column grid ---------- */
        #summary_filter_form {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            grid-template-areas:
                "pills  pills"
                "start  end"
                "rep    team"
                "clear  filter"
                "search search"
                "num    total"
                "len    sort";
            column-gap: 10px;
            row-gap: 10px;
        }
        /* White card behind the dates / rep / team / buttons (grid rows 2-4) */
        #summary_filter_form::before {
            content: "";
            grid-column: 1 / -1;
            grid-row: 2 / 5;
            background: #fff;
            border: 1px solid #eef0f2;
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(17, 24, 39, 0.06);
        }
        /* The two original rows stop being boxes; their children join the grid */
        #summary_filter_form .ar-f-row { display: contents; }

        /* ---------- Date range pills (horizontal scroll) ---------- */
        #summary_filter_form .ar-pills {
            grid-area: pills;
            display: flex;
            gap: 8px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            padding: 2px 0;
        }
        #summary_filter_form .ar-pills::-webkit-scrollbar { display: none; }
        #summary_filter_form .ar-pills .row-for-date-options {
            flex: 0 0 auto;
            margin: 0 !important;
            padding: 0 !important;
            background-color: #fff !important;   /* JS sets inline colours */
            border: 1px solid #e5e7eb;
            border-radius: 999px;
        }
        #summary_filter_form .ar-pills .row-for-date-options label {
            padding: 7px 16px;
        }
        #summary_filter_form .ar-pills .row-for-date-options .date_p {
            font-size: 14px;
            font-weight: 500;
            color: #374151 !important;
            white-space: nowrap;
        }
        #summary_filter_form .ar-pills .row-for-date-options:has(input.active-radio) {
            background-color: #111827 !important;
            border-color: #111827;
        }
        #summary_filter_form .ar-pills .row-for-date-options:has(input.active-radio) .date_p {
            color: #fff !important;
        }

        /* ---------- Fields inside the filter card ---------- */
        #summary_filter_form .ar-f-start  { grid-area: start;  margin: 14px 0 0 14px !important; }
        #summary_filter_form .ar-f-end    { grid-area: end;    margin: 14px 14px 0 0 !important; }
        #summary_filter_form .ar-f-rep    { grid-area: rep;    margin: 0 0 0 14px !important; }
        #summary_filter_form .ar-f-team   { grid-area: team;   margin: 0 14px 0 0 !important; }
        #summary_filter_form .ar-f-clear  { grid-area: clear;  margin: 0 0 14px 14px; display: block; }
        #summary_filter_form .ar-f-filter { grid-area: filter; margin: 0 14px 14px 0 !important; }

        #summary_filter_form .ar-f-start,
        #summary_filter_form .ar-f-end,
        #summary_filter_form .ar-f-rep,
        #summary_filter_form .ar-f-team {
            display: block;
            min-width: 0;
            padding: 0 !important;
            background: transparent;
            border: none;
            border-radius: 0;
        }
        /* "Start Date |", "Rep |" ... labels are not in the Figma design */
        #summary_filter_form .ar-f-start > .date_p,
        #summary_filter_form .ar-f-end > .date_p,
        #summary_filter_form .ar-f-rep > .date_p,
        #summary_filter_form .ar-f-team > .date_p {
            display: none !important;
        }
        #summary_filter_form .ar-f-start .paymen_type_div,
        #summary_filter_form .ar-f-end .paymen_type_div,
        #summary_filter_form .ar-f-rep .paymen_type_div,
        #summary_filter_form .ar-f-team .paymen_type_div {
            display: block;
            width: 100%;
            padding: 0 !important;
        }

        /* Date inputs */
        #summary_filter_form .summary-datepicker {
            width: 100% !important;
            height: 44px !important;
            padding: 0 34px 0 12px;
            font-size: 14px;
            color: #111827;
            background: #f5f6f7 url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12'%3E%3Cpath d='M2.5 4.5 6 8l3.5-3.5' fill='none' stroke='%23374151' stroke-width='1.6' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") no-repeat right 12px center / 12px 12px !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 8px;
            outline: none;
            box-sizing: border-box;
        }
        #summary_filter_form .summary-datepicker::placeholder { color: #9ca3af; }

        /* Rep / Team type (select2) */
        #summary_filter_form .ar-f-rep .select2-container,
        #summary_filter_form .ar-f-team .select2-container {
            width: 100% !important;
            min-width: 0 !important;
        }
        #summary_filter_form .ar-f-rep .select2-selection--single,
        #summary_filter_form .ar-f-team .select2-selection--single {
            height: 44px;
            border: 1px solid #e5e7eb !important;
            border-radius: 8px !important;
            background-color: #f5f6f7 !important;
        }
        #summary_filter_form .ar-f-rep .select2-selection__rendered,
        #summary_filter_form .ar-f-team .select2-selection__rendered {
            line-height: 42px !important;
            padding-left: 12px !important;
            padding-right: 30px !important;
            font-size: 14px;
            color: #111827 !important;
        }
        #summary_filter_form .ar-f-rep .select2-selection__arrow,
        #summary_filter_form .ar-f-team .select2-selection__arrow {
            height: 42px !important;
            right: 8px !important;
        }

        /* Clear Filters + Filter buttons */
        #ar-m-clear-filters {
            width: 100%;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #fff;
            color: #6b7280;
            font-size: 14px;
            font-weight: 500;
        }
        #summary_filter_form .ar-f-filter > .row {
            display: block;
            height: auto !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        #summary_filter_form #pin-filter {
            width: 100%;
            height: 44px !important;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            margin: 0;
            border-radius: 8px;
            background-color: #111827;
            font-size: 14px;
            font-weight: 500;
        }

        /* ---------- Search card ---------- */
        #summary_filter_form .ar-m-search {
            grid-area: search;
            display: block;
            margin-top: 4px;
            padding: 12px;
            background: #fff;
            border: 1px solid #eef0f2;
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(17, 24, 39, 0.06);
        }
        .ar-m-search-field { position: relative; }
        .ar-m-search-field i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #111827;
            font-size: 14px;
            pointer-events: none;
        }
        .ar-m-search-field input {
            width: 100%;
            height: 44px;
            padding: 0 12px 0 40px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #f5f6f7;
            font-size: 14px;
            color: #111827;
            outline: none;
        }
        .ar-m-search-field input::placeholder { color: #9ca3af; }

        /* ---------- Stat cards (Number of Sales / Total) ---------- */
        #summary_filter_form .ar-f-num   { grid-area: num; }
        #summary_filter_form .ar-f-total { grid-area: total; }
        #summary_filter_form .ar-f-num,
        #summary_filter_form .ar-f-total {
            display: grid !important;
            grid-template-columns: clamp(30px, 10vw, 40px) minmax(0, 1fr);
            grid-template-rows: auto auto;
            column-gap: clamp(6px, 2.4vw, 10px);
            align-items: center;
            width: auto !important;
            margin: 0 !important;
            padding: 12px !important;
            background: #fff;
            border: 1px solid #eef0f2;
            border-radius: 12px;
        }
        #summary_filter_form .ar-f-num::before,
        #summary_filter_form .ar-f-total::before {
            grid-row: 1 / 3;
            grid-column: 1;
            width: 100%;
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #f3f4f6;
            color: #9ca3af;
            font-family: FontAwesome;
            font-size: 18px;
        }
        #summary_filter_form .ar-f-num::before   { content: "\f1b2"; } /* cube */
        #summary_filter_form .ar-f-total::before { content: "\f201"; } /* line chart */

        /* Replace "Number of sale |" / "Total ($) |" text with Figma labels */
        #summary_filter_form .ar-f-num > .date_p,
        #summary_filter_form .ar-f-total > .date_p {
            grid-column: 2;
            display: block !important;
            align-self: end;
            margin: 0;
            padding: 0 !important;
            font-size: 0 !important;
        }
        #summary_filter_form .ar-f-num > .date_p::after,
        #summary_filter_form .ar-f-total > .date_p::after {
            font-size: 12px;
            font-weight: 500;
            color: #374151;
        }
        #summary_filter_form .ar-f-num > .date_p::after   { content: "Number of Sales"; }
        #summary_filter_form .ar-f-total > .date_p::after { content: "Total"; }

        #summary_filter_form .ar-f-num > .paymen_type_div,
        #summary_filter_form .ar-f-total > .paymen_type_div {
            grid-column: 2;
            display: block !important;
            align-self: start;
            padding: 0 !important;
        }
        #summary_filter_form #number_of_sale,
        #summary_filter_form #total_sale {
            display: block !important;
            height: auto !important;
            background-color: transparent !important;
            color: #111827 !important;
            text-align: left !important;
            font-size: clamp(14px, 4.4vw, 18px);
            font-weight: 700;
            line-height: 1.3;
            white-space: nowrap;
        }
        #summary_filter_form #total_sale::before { content: "$\00a0"; }

        /* Excel / Save live elsewhere on mobile (top Export, bottom Save to Compare) */
        #summary_filter_form .ar-f-excel,
        #summary_filter_form .ar-f-save {
            display: none !important;
        }

        /* ---------- "Show [20] entries" + "Sort by [Order ID]" ---------- */
        #summary_filter_form .ar-f-len {
            grid-area: len;
            display: flex !important;
            flex-wrap: nowrap;
            align-items: center;
            gap: 8px;
            margin: 0 !important;
            padding: 0 !important;
            background: transparent;
            border: none;
            font-size: 14px;
            color: #6b7280;
        }
        #summary_filter_form .ar-f-len::before { content: "Show"; }
        #summary_filter_form .ar-f-len::after  { content: "entries"; }
        #summary_filter_form .ar-f-len .paymen_type_div { padding: 0 !important; }

        #summary_filter_form .ar-m-sort {
            grid-area: sort;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            min-width: 0;
            font-size: 14px;
            color: #6b7280;
            white-space: nowrap;
        }
        #summary_filter_form #page_length,
        #summary_filter_form #ar-m-sort-select {
            -webkit-appearance: none;
            appearance: none;
            height: 34px;
            padding: 0 28px 0 10px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12'%3E%3Cpath d='M2.5 4.5 6 8l3.5-3.5' fill='none' stroke='%23374151' stroke-width='1.6' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") no-repeat right 9px center / 11px 11px;
            font-size: 14px;
            font-weight: 500;
            color: #111827;
            outline: none;
        }

        /* ---------- Bulk actions ---------- */
        .order_sammary_table {
            padding: 0 !important;
            overflow-x: visible;
        }
        .ar-bulk-actions {
            flex-direction: column;
            gap: 6px;
            max-width: 100%;
            flex: 0 0 100%;
            padding: 0 !important;
            margin: 12px 0 4px !important;
        }
        .ar-bulk-actions form { width: 100%; }
        .ar-m-selectall {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            font-size: 13px;
            color: #374151;
        }
        #pay_multiple,
        #make_bulk_invoice {
            width: 100% !important;
            margin: 0 !important;
            padding: 10px !important;
            border-radius: 8px !important;
        }

        /* ---------- DataTables wrapper ---------- */
        #order_summary_wrapper .row { margin-left: 0; margin-right: 0; }
        #order_summary_wrapper .row > [class*="col-"] { padding-left: 0; padding-right: 0; }
        #order_summary_wrapper .dataTables_filter { display: none !important; } /* replaced by the search card */
        #order_summary_wrapper .dataTables_scrollHead { display: none !important; }
        #order_summary_wrapper .dataTables_scroll,
        #order_summary_wrapper .dataTables_scrollBody {
            overflow: visible !important;
            width: 100% !important;
            height: auto !important;
            border: none !important;
        }
        .fixedHeader-floating,
        .fixedHeader-locked { display: none !important; }

        /* ---------- Table -> order cards ---------- */
        #order_summary {
            display: block;
            width: 100% !important;
            min-width: 0 !important;
            margin: 10px 0 0 !important;
            border: none;
            background: transparent;
        }
        #order_summary thead { display: none !important; }
        #order_summary tbody { display: block; width: 100%; }

        /* Card: #000149 + order status / organization / Sales Lead + Qty /
           Total, Paid, Balance / grey band with the three dates (always shown,
           no expand / collapse). */
        #order_summary tbody tr {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            grid-template-areas:
                "order order order"
                "org   org   org"
                "lead  lead  qty"
                "total paid  balance";
            column-gap: 8px;
            row-gap: 0;
            margin-bottom: 14px;
            padding: 18px 16px 18px 20px;
            background: #fff !important;
            border: 1px solid #f0f1f3;
            border-radius: 16px;
            box-shadow: 0 4px 14px rgba(17, 24, 39, 0.06);
            -webkit-tap-highlight-color: transparent;
        }
        /* Grey band behind the dates, full card width, down to the card bottom */
        #order_summary tbody tr::before {
            content: "";
            display: block;
            grid-row: 5;
            grid-column: 1 / -1;
            margin: 16px -16px -18px -20px;
            background: #f4f4f5;
            border-top: 1px solid #ececee;
            border-radius: 0 0 16px 16px;
        }

        #order_summary tbody td {
            display: block;
            min-width: 0;
            padding: 0 !important;
            border: none !important;
            background: transparent !important;
            text-align: left !important;
            overflow-wrap: anywhere;
        }

        /* 1: checkbox (kept for bulk actions) sits before the order number */
        #order_summary tbody td:nth-child(1) {
            grid-area: order;
            position: relative;
            z-index: 2;
            align-self: center;
            justify-self: start;
            line-height: 0;
        }
        #order_summary tbody td:nth-child(1) input {
            width: 16px;
            height: 16px;
            accent-color: #111827;
        }
        /* 2: Order number */
        #order_summary tbody td:nth-child(2) {
            grid-area: order;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-left: 26px !important;
            align-self: center;
            line-height: 1.25;
        }
        #order_summary tbody td:nth-child(2) a {
            color: #111827 !important;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.2px;
            text-decoration: none;
        }
        #order_summary tbody td:nth-child(2) a { flex: 0 0 auto; }
        #order_summary tbody td:nth-child(2) a::before { content: "#"; }
        /* Order status (status_details.status_name, set by JS in data-ar-status) */
        #order_summary tbody td:nth-child(2)[data-ar-status]::after {
            content: attr(data-ar-status);
            min-width: 0;
            max-width: 60%;
            margin-left: auto;
            padding: 5px 10px;
            border-radius: 999px;
            background: #f3f4f6;
            color: #374151;
            font-size: 12.5px;
            font-weight: 600;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        #order_summary tbody td:nth-child(2)[data-ar-status=""]::after { display: none; }
        #order_summary tbody td:nth-child(2)[data-ar-status*="fulfil" i]::after,
        #order_summary tbody td:nth-child(2)[data-ar-status*="complete" i]::after,
        #order_summary tbody td:nth-child(2)[data-ar-status*="deliver" i]::after { background: #e6f7ee; color: #1f8f4e; }
        #order_summary tbody td:nth-child(2)[data-ar-status*="cancel" i]::after,
        #order_summary tbody td:nth-child(2)[data-ar-status*="reject" i]::after { background: #fdeaea; color: #d12c2c; }
        #order_summary tbody td:nth-child(2)[data-ar-status*="hold" i]::after,
        #order_summary tbody td:nth-child(2)[data-ar-status*="pending" i]::after { background: #fff4e0; color: #b7791f; }
        #order_summary tbody td:nth-child(2)[data-ar-status*="production" i]::after,
        #order_summary tbody td:nth-child(2)[data-ar-status*="process" i]::after { background: #e8f0fe; color: #2f5fd0; }
        /* 5: item quantity -> "Qty 624", right side of the Sales Lead line */
        #order_summary tbody td:nth-child(5) {
            grid-area: qty;
            justify-self: end;
            align-self: end;
            margin-top: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #111827;
            white-space: nowrap;
        }
        #order_summary tbody td:nth-child(5)::before {
            content: "Qty";
            margin-right: 6px;
            font-weight: 400;
            color: #9ca3af;
        }
        /* 3: Organization */
        #order_summary tbody td:nth-child(3) {
            grid-area: org;
            margin-top: 2px;
            font-size: 16px;
            font-weight: 400;
            line-height: 1.35;
            color: #111827;
        }
        /* 4: Sales lead */
        #order_summary tbody td:nth-child(4) {
            grid-area: lead;
            margin-top: 6px;
            font-size: 13px;
            font-weight: 500;
            color: #111827;
        }
        #order_summary tbody td:nth-child(4)::before {
            content: "Sales Lead";
            margin-right: 10px;
            font-weight: 400;
            color: #9ca3af;
        }
        /* 6-8: Total / Paid / Balance boxes */
        #order_summary tbody td:nth-child(6),
        #order_summary tbody td:nth-child(7),
        #order_summary tbody td:nth-child(8) {
            display: flex;
            flex-wrap: wrap;
            align-content: flex-start;
            margin-top: 14px;
            padding: 7px 8px 8px !important;
            background: #f3f4f6 !important;
            border-radius: 8px;
            font-size: clamp(12px, 3.5vw, 16px);
            font-weight: 500;
            line-height: 1.35;
        }
        #order_summary tbody td:nth-child(6)::before,
        #order_summary tbody td:nth-child(7)::before,
        #order_summary tbody td:nth-child(8)::before {
            order: -2;
            flex-basis: 100%;
            margin-bottom: 1px;
            font-size: clamp(11px, 3.3vw, 15px);
            font-weight: 400;
            color: #8a8f98;
        }
        /* Fallback: "$" + raw value */
        #order_summary tbody td:nth-child(6)::after,
        #order_summary tbody td:nth-child(7)::after,
        #order_summary tbody td:nth-child(8)::after {
            content: "$";
            order: -1;
        }
        /* Display value with thousands separators ($37,927.92), set by JS in
           data-ar-amt. The cell text itself is unchanged (Excel export uses it). */
        #order_summary tbody td[data-ar-amt] { font-size: 0; }
        #order_summary tbody td[data-ar-amt]::after {
            content: attr(data-ar-amt);
            order: 0;
            font-size: clamp(12px, 3.5vw, 16px);
            white-space: nowrap;
        }
        /* Millions and up: slightly smaller so the amount stays on one line */
        #order_summary tbody td[data-ar-long]::after { font-size: clamp(10.5px, 2.9vw, 14px); }
        #order_summary tbody td:nth-child(6) { grid-area: total;   color: #111827; }
        #order_summary tbody td:nth-child(7) { grid-area: paid;    color: #3a9d23; }
        #order_summary tbody td:nth-child(8) { grid-area: balance; color: #e01e1e; }
        #order_summary tbody td:nth-child(6)::before { content: "Total"; }
        #order_summary tbody td:nth-child(7)::before { content: "Paid"; }
        #order_summary tbody td:nth-child(8)::before { content: "Balance"; }

        /* 9-11: dates, always shown in the grey band at the bottom of the card */
        #order_summary tbody td:nth-child(9),
        #order_summary tbody td:nth-child(10),
        #order_summary tbody td:nth-child(11) {
            display: block;
            grid-row: 5;
            position: relative;
            margin-top: 16px;
            padding: 14px 0 0 !important;
            font-size: 13px;
            font-weight: 400;
            line-height: 1.35;
            color: #111827;
        }
        #order_summary tbody td:nth-child(9)  { grid-column: 1; }
        #order_summary tbody td:nth-child(10) { grid-column: 2; }
        #order_summary tbody td:nth-child(11) { grid-column: 3; }
        #order_summary tbody td:nth-child(9)::before,
        #order_summary tbody td:nth-child(10)::before,
        #order_summary tbody td:nth-child(11)::before {
            display: block;
            margin-bottom: 2px;
            font-size: 12px;
            color: #8a8f98;
            white-space: nowrap;
        }
        #order_summary tbody td:nth-child(9)::before  { content: "Created Date"; }
        #order_summary tbody td:nth-child(10)::before { content: "Production Date"; }
        #order_summary tbody td:nth-child(11)::before { content: "In Hand Due Date"; }
        #order_summary tbody td:nth-child(9):empty::after,
        #order_summary tbody td:nth-child(10):empty::after,
        #order_summary tbody td:nth-child(11):empty::after { content: "-"; }

        /* "No data available" row */
        #order_summary tbody tr:has(td.dataTables_empty) {
            display: block;
            cursor: default;
        }
        #order_summary tbody tr:has(td.dataTables_empty)::after,
        #order_summary tbody tr:has(td.dataTables_empty)::before { display: none; }
        #order_summary tbody td.dataTables_empty {
            padding: 8px 0 !important;
            text-align: center !important;
            color: #6b7280;
        }

        /* ---------- Pagination + "Showing x to y of z entries" ---------- */
        .ar-pager-col {
            display: flex !important;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-top: 4px;
        }
        #ar-m-info {
            display: block;
            font-size: 12px;
            color: #9ca3af;
        }
        #order_summary_wrapper .dataTables_paginate { margin: 0 !important; }
        #order_summary_wrapper .pagination {
            margin: 0;
            gap: 6px;
            flex-wrap: wrap;
            justify-content: flex-end !important;
        }
        #order_summary_wrapper .page-item .page-link {
            min-width: 32px;
            height: 32px;
            margin: 0;
            padding: 0 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e5e7eb;
            border-radius: 6px !important;
            background: #fff;
            color: #111827;
            font-size: 13px;
            box-shadow: none;
        }
        #order_summary_wrapper .page-item.active .page-link {
            background: #111827;
            border-color: #111827;
            color: #fff;
        }
        #order_summary_wrapper .page-item.disabled .page-link { color: #9ca3af; }
        #order_summary_wrapper .page-item.previous .page-link,
        #order_summary_wrapper .page-item.next .page-link {
            font-size: 0;
        }
        #order_summary_wrapper .page-item.previous .page-link::before,
        #order_summary_wrapper .page-item.next .page-link::before {
            font-size: 20px;
            line-height: 1;
        }
        #order_summary_wrapper .page-item.previous .page-link::before { content: "\2039"; }
        #order_summary_wrapper .page-item.next .page-link::before     { content: "\203A"; }

        /* ---------- Save to Compare ---------- */
        .ar-m-save {
            display: block;
            margin-top: 16px;
        }
        .ar-m-save button {
            width: 100%;
            height: 46px;
            border: none;
            border-radius: 8px;
            background: #47D6B6;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
        }

        /* ---------- Modals: keep wide tables scrollable inside the modal ---------- */
        #payMultipleModal .modal-body { overflow-x: auto; }
        #payMultipleModal .modal-body > .table { min-width: 640px; }
    }

    /* Very small phones (320px - 359px) */
    @media (max-width: 359px) {
        body.ar-own-header .ar-m-title { font-size: 18px; }
        .ar-m-export-btn { height: 36px; padding: 0 12px; font-size: 14px; }
        #summary_filter_form .ar-f-len,
        #summary_filter_form .ar-m-sort {
            gap: 4px;
            font-size: 12px;
        }
        #summary_filter_form #page_length,
        #summary_filter_form #ar-m-sort-select {
            font-size: 12px;
            padding: 0 22px 0 8px;
            background-position: right 7px center;
        }
        /* Not enough room for the icon: give the numbers the full card width */
        #summary_filter_form .ar-f-num,
        #summary_filter_form .ar-f-total {
            grid-template-columns: minmax(0, 1fr);
            padding: 10px 12px !important;
        }
        #summary_filter_form .ar-f-num::before,
        #summary_filter_form .ar-f-total::before { display: none; }
        #summary_filter_form .ar-f-num > .date_p,
        #summary_filter_form .ar-f-total > .date_p,
        #summary_filter_form .ar-f-num > .paymen_type_div,
        #summary_filter_form .ar-f-total > .paymen_type_div { grid-column: 1; }
        #summary_filter_form #number_of_sale,
        #summary_filter_form #total_sale {
            font-size: 16px;
            overflow-wrap: normal;
            white-space: nowrap;
        }
        #order_summary tbody tr { padding: 14px 10px 14px 12px; column-gap: 5px; }
        #order_summary tbody tr::before { margin: 14px -10px -14px -12px; }
        #order_summary tbody td:nth-child(2) a { font-size: 17px; }
        #order_summary tbody td:nth-child(2)[data-ar-status]::after { padding: 4px 8px; font-size: 11px; }
        #order_summary tbody td:nth-child(5) { font-size: 12px; }
        #order_summary tbody td:nth-child(3) { font-size: 14px; }
        #order_summary tbody td:nth-child(6),
        #order_summary tbody td:nth-child(7),
        #order_summary tbody td:nth-child(8) { padding: 6px 6px 7px !important; }
        #order_summary tbody td:nth-child(9)::before,
        #order_summary tbody td:nth-child(10)::before,
        #order_summary tbody td:nth-child(11)::before { font-size: 10.5px; white-space: normal; }
        #order_summary tbody td:nth-child(9),
        #order_summary tbody td:nth-child(10),
        #order_summary tbody td:nth-child(11) { font-size: 12px; }
        .ar-pills .row-for-date-options label { padding: 6px 12px !important; }
        .col-md-2.mt-2.ar-bulk-actions { display: none !important; }
    }
</style>


@if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif

<div class=" mb-5 content-position">

    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Accounts receivable</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    {{-- Mobile only: Export button (uses the existing Excel export) --}}
    {{-- Mobile only: page header (back link + title + Export, uses the existing Excel export) --}}
    <div class="ar-m-only ar-m-topbar">
        {{-- <a href="{{ route('home') }}" class="ar-m-back" title="Back to home">
            <i class="fa fa-chevron-left"></i> BACK TO HOME
        </a> --}}
        <div class="ar-m-titlerow">
            <h1 class="ar-m-title">Accounts Receivable</h1>
            <button type="button" class="ar-m-export-btn" id="ar-m-export">
                <i class="fa fa-download"></i> Export
            </button>
        </div>
    </div>


    <div class="col-md-12" style="margin-top: 15px; margin-bottom: 25px; padding-bottom: 20px;" id="scrollTable">
        <div class="card" style="border: unset;">
            <form id="summary_filter_form">
                @csrf
                <div class="row ar-f-row" style="margin: 10px;">
                    <div class="row filter_row ar-f-len"  style="padding-bottom: 2px;margin:5px">
                        <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                            <select id="page_length" class="date_selection">
                                <option value="5">5 per page</option>
                                <option value="10">10 per page</option>
                                <option value="20" selected>20 per page</option>
                                <option value="50">50 per page</option>
                            </select>
                        </div>
                    </div>
                    <div class="row filter_row ar-f-start" style="padding-bottom: 2px;margin:5px">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">Start Date |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                            <input type="text" name="start_date" class="summary-datepicker invoice-inputs" style="height: 2rem;background-color:#F8F8F8;border: 1px solid #DEDEDE;" id="start_date">
                        </div>
                    </div>
                    <div class="row filter_row ar-f-end" style="padding-bottom: 2px;margin:5px">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">End Date |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                            <input type="text" name="end_date" class="summary-datepicker invoice-inputs" style="height: 2rem;background-color:#F8F8F8;border: 1px solid #DEDEDE;" id="end_date">
                        </div>
                    </div>

                    {{-- .ar-pills uses display: contents on desktop, so the pills render exactly as before --}}
                    <div class="ar-pills">
                        <div class="row filter_row row-for-date-options ml-auto" style="padding-bottom: 2px; margin:5px;">
                            <label class="d_flex_and_align_center" style="margin: 0;cursor: pointer;">
                                <input type="radio" name="dateFilter" style="display: none" value="thisMonth">
                                <span class="font_color date_p" >This month</span>
                            </label>
                        </div>

                        <div class="row filter_row row-for-date-options" style="padding-bottom: 2px; margin:5px;">
                            <label class="d_flex_and_align_center" style="margin: 0;cursor: pointer;">
                                <input type="radio" name="dateFilter" style="display: none" value="lastMonth">
                                <span class="font_color date_p">Last month</span>
                            </label>
                        </div>

                        <div class="row filter_row row-for-date-options" style="padding-bottom: 2px; margin:5px;">
                            <label class="d_flex_and_align_center" style="margin: 0;cursor: pointer;">
                                <input type="radio" name="dateFilter" style="display: none" value="thisYear">
                                <span class="font_color date_p">This year</span>
                            </label>
                        </div>

                        <div class="row filter_row row-for-date-options" style="padding-bottom: 2px; margin:5px;">
                            <label class="d_flex_and_align_center" style="margin: 0;cursor: pointer;">
                                <input type="radio" name="dateFilter" style="display: none" value="lastYearToday">
                                <span class="font_color date_p">Last year to date</span>
                            </label>
                        </div>

                        <div class="row filter_row row-for-date-options" style="padding-bottom: 2px; margin:5px;">
                            <label class="d_flex_and_align_center" style="margin: 0;cursor: pointer;">
                                <input type="radio" name="dateFilter" style="display: none" value="thisQuarter">
                                <span class="font_color date_p">This quarter</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row ar-f-row" style="margin-left: 18px; margin-right: 30px; padding-bottom: 7px;">
                    <div class="row filter_row ar-f-rep" style="padding-bottom: 2px;">
                        <p class="font_color date_p d_flex_and_align_center">Rep |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style" style="padding-left: 7px;">
                            <select id="user_filter" name="user_filter" class="date_selection summary-select2">
                                <option value="all">All</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row filter_row ml-4 ar-f-team" style="padding-bottom: 2px;">
                        <p class="font_color date_p d_flex_and_align_center">Team type |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style" style="padding-left: 7px;">
                            <select id="team_type_filter" name="team_type_filter" class="date_selection summary-select2">
                                <option value='0' selected>Without Internal Teams</option>
                                <option value='1'>With Internal Teams</option>
                            </select>
                        </div>
                    </div>
                    {{-- Mobile only: Clear Filters --}}
                    <div class="ar-m-only ar-f-clear">
                        <button type="button" id="ar-m-clear-filters">
                            <i class="fa fa-times"></i> Clear Filters
                        </button>
                    </div>
                    <div class="ar-f-filter" style="margin-left: 45px;">
                        <div class="row d_flex_and_align_center" style="padding-bottom: 2px;height: 100%;">
                            <button class="date_p filter_btn" type="button" id="pin-filter" title="Filter" style="height: 100%;">
                                <i class="fa fa-filter"></i>&nbsp;&nbsp;Filter
                            </button>
                        </div>
                    </div><div class="row filter_row ml-auto ar-f-num" style="padding-bottom: 2px;margin:5px;width: fit-content;">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;color: black;">Number of sale |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                            <span class="d_flex_and_align_center text-right" style="height: 1.5rem;background-color:#F8F8F8;width: 100%;color:black" id="number_of_sale">0</span>
                        </div>
                    </div>
                    <div class="row filter_row ar-f-total" style="padding-bottom: 2px;margin:5px;width: fit-content;">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;color: black;">Total ($) |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                            <span class="d_flex_and_align_center text-right" style="height: 1.5rem;background-color:#F8F8F8;width: 100%;color:black" id="total_sale">0.00</span>
                        </div>
                    </div>
                    <div class="ar-f-excel">
                        <div class="row d_flex_and_align_center " style="padding-bottom: 2px;margin: 5px;">
                            <button class="date_p excel_btn" type="button" id="exportButton" title="Filter" style="height: 100%;">
                                <i class="fa fa-download"></i>&nbsp;&nbsp;Excel
                            </button>
                        </div>
                    </div>
                    <div class="ar-f-save">
                        <div class="row d_flex_and_align_center " style="padding-bottom: 2px;margin: 5px;">
                            <button class="date_p excel_btn" type="button" id="save-report" title="savereport" style="height: 100%;">
                                <i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Mobile only: search card (drives the existing DataTables search). No "name" attribute, so it is not sent with the filter form. --}}
                <div class="ar-m-only ar-m-search">
                    <div class="ar-m-search-field">
                        <i class="fas fa-search"></i>
                        <input type="search" id="ar-m-search-input" placeholder="Search by order id" autocomplete="off">
                    </div>
                </div>

                {{-- Mobile only: sort (client-side, re-orders the rows already loaded). No "name" attribute. --}}
                <div class="ar-m-only ar-m-sort">
                    <span>Sort by</span>
                    <select id="ar-m-sort-select">
                        <option value="order_no" selected>Order ID</option>
                        <option value="organization">Organization</option>
                        <option value="total">Total</option>
                        <option value="balance">Balance</option>
                    </select>
                </div>
            </form>


            <div class="order_sammary_table" style="">
                @if(Gate::check('create bulk invoice'))
                <div class="col-md-2 mt-2 ar-bulk-actions" style="display:flex;">
                    {{-- Mobile only: the table header (with the select-all box) is hidden on mobile --}}
                    <label class="ar-m-only ar-m-selectall">
                        <input type="checkbox" id="ar-m-select-all"> Select all
                    </label>
                    <input type="hidden" id="pay_multiple_invoices" name="pay_multiple_invoices[]" value="" />
                    <button type="submit" class="btn multiple-pay-button btn-secondary btn-sm" title="Mark as paid" style="background-color: rgb(94 145 105);color:white;display:none" id="pay_multiple"><i class="far fa-check-circle"></i><small>Mark as paid (<span id="invoice_checked_count"></span>)</small></button>

                    <form action="{{ route('create_bulk_invoice') }}" method="POST">
                        @csrf
                        <input type="hidden" id="make_bulk_invoices" name="make_bulk_invoices" value="" />
                        <button type="submit" class="btn make-bulk-invoice btn-secondary btn-sm" title="Make bulk invoice" style="background-color: #b3b3b3;color:black;display:none" id="make_bulk_invoice"><i class="far fa-check-circle"></i><small>Make bulk invoice (<span id="make_bulk_invoice_count"></span>)</small></button>
                    </form>

                </div>
                @endif
                <table class="table align-items-center" id="order_summary" style="min-width: 100%;">

                    <thead style="background-color: #717070;">
                        <th scope="col" class="table_header_text">
                            <input type="checkbox" class="checkbox_of_invoice_all" id="checkbox_of_invoice_all" />
                        </th>
                        <th scope="col" class="table_header_text">ORDER NO</th>
                        <th scope="col" class="table_header_text">ORGANIZATION NAME</th>
                        <th scope="col" class="table_header_text">SALES LEAD</th>
                        <th scope="col" class="table_header_text">ITEM QTY</th>
                        <th scope="col" class="table_header_text" style="text-align: right;">TOTAL ($)</th>
                        <th scope="col" class="table_header_text" style="text-align: right;">PAID ($)</th>
                        <th scope="col" class="table_header_text" style="text-align: right;">BALANCE ($)</th>
                        <th scope="col" class="table_header_text">CREATED DATE</th>
                        <th scope="col" class="table_header_text">PRODUCTION DATE</th>
                        <th scope="col" class="table_header_text">IN HAND DUE DATE</th>
                    </thead>

                    <tbody>

                    </tbody>
                </table>

            </div>
            <div  style="padding-top: 10px;">
            <div id="pagination_controls" class="row justify-content-center" style="width: 100%;">
                {{-- pagination bar paste here --}}
                </div>
            </div>

            {{-- Mobile only: "Showing x to y of z entries" (moved next to the pager by JS) --}}
            <div class="ar-m-only" id="ar-m-info"></div>

            {{-- Mobile only: Save to Compare (uses the existing Save report action) --}}
            <div class="ar-m-only ar-m-save">
                <button type="button" id="ar-m-save-btn">Save to Compare</button>
            </div>
        </div>
    </div>
</div>

<!-- Payment Received Modal -->
<div class="modal fade" id="paymentReceivedModal" tabindex="-1" role="dialog" aria-labelledby="paymentReceivedModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form>
          @csrf <!-- Include CSRF token for security -->
          <div class="modal-header">
            <h5 class="modal-title" id="paymentReceivedModalLabel">Payment Received</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Image upload section -->
            <div class="form-group only_for_payment">
              <label for="payment_image">Upload Payment Image</label>
              <input type="file" class="form-control-file" id="payment_image" name="payment_image" accept="image/*">
            </div>

            <!-- Image preview -->
            <div class="form-group only_for_payment">
              <img id="imagePreview" src="#" alt="Payment Image Preview" style="display:none; max-width: 100%; height: auto;" />
            </div>

            <!-- Description textarea -->
            <div class="form-group">
              <label for="description">Payment Description</label>
              <textarea class="form-control" name="description" id="other_payment_description" rows="3" placeholder="Enter a description of the payment" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="submit_payment_received" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>



  <!-- Modal -->
<div class="modal fade" id="comfirm_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header" style="padding-bottom: unset;">
          {{-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> --}}
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="col" style="display: flex;flex-wrap: wrap;justify-content: center;">
            <h2>Payment Options</h2>
            <p>Choose the appropriate action for payment:</p>
          </div>
        </div>
        <div class="modal-footer" style="padding-top: unset;display: flex;flex-wrap: wrap;justify-content: center;">

          <button type="button" class="btn btn-primary" id="admin_clear_btn">Clear by Admin</button>
          <button type="button" class="btn btn-primary" id="payment_received_btn">Payment Received</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Pay multile modal -->
<div class="modal fade" id="payMultipleModal" tabindex="-1" role="dialog" aria-labelledby="payMultipleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="max-width:1125px !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payMultipleModalLabel" style="font-size: 1.2rem;">TRANSACTION </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="multiplePayForm" action="{{ route('do_pay_multiple_orders') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <table class="table align-items-center ml-auto">
                        <thead style="background-color: grey;color: white;">
                            <th scope="col" class="text-center">Order Number</th>
                            <th scope="col" class="text-center">Organization Name</th>
                            <th scope="col" class="text-center">Total amount</th>
                            <th scope="col" class="text-center">Paid amount</th>
                            <th scope="col" class="text-center">Balance to pay</th>
                            <th scope="col" class="text-center">Payment amount</th>
                        </thead>
                        <tbody id="selectedInvoiceTr">

                        </tbody>
                        <tbody class="no-top-border">

                            <tr>
                                <td class="no-top-border" colspan="4" id="debit_acc_summary_line_1" ></td>
                                <td class="text-right no-top-border" style="font-weight:800;font-size: 1rem;">Total Paid Amount:  </td>
                                <td class="no-top-border">
                                    <input type="text" name="total_sum_of_payment" id="total_sum_of_payment" value="0.00" class="form-control text-right" style="font-weight:800;" >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="transaction_id" value="001">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-1 mt-3" style="padding: 0rem 1rem;">
                                    <label for="upload_image">Upload Image for payment reference</label>
                                    <input type="file" id="upload_image" name="other_front" accept="image/png, image/jpeg" class="form-control" style="width: auto;height: auto;" onchange="previewImage(event)">
                                </div>

                                <div class="form-group" id="imagePreview2" style="display:none;padding: 0rem 1rem;">
                                    <img id="uploaded_image" src="" alt="Uploaded Image" style="width: auto; height: 5rem;">
                                    <button type="button" id="removeImage">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-1 mt-3" style="padding: 0rem 1rem;">
                                    <label for="upload_image">Upload Image for payment reference back</label>
                                    <input type="file" id="upload_image2" name="other_back" accept="image/png, image/jpeg" class="form-control" style="width: auto;height: auto;" onchange="previewImage2(event)">
                                </div>

                                <div class="form-group" id="imagePreview22" style="display:none;padding: 0rem 1rem;">
                                    <img id="uploaded_image2" src="" alt="Uploaded Image" style="width: auto; height: 5rem;">
                                    <button type="button" id="removeImage2">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="payment_reference text">Payment reference text</label><br>
                                <textarea name="payment_reference" class="form-control" id="payment_reference" cols="30" rows="3" style="width: 100%;"></textarea>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmGroupPay">Pay</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Reason Type Modal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>


<script>
    $('#confirmGroupPay').click(function(e) {
        e.preventDefault(); // Prevent default button action
        $(".se-pre-con").fadeIn('slow'); // Show loading animation

        // Submit the form
        $('#multiplePayForm').submit();
    });
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('uploaded_image');
            output.src = reader.result;
            document.getElementById('imagePreview2').style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]); // Preview the image
    }
    function previewImage2(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('uploaded_image2');
            output.src = reader.result;
            document.getElementById('imagePreview22').style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]); // Preview the image
    }

    // Remove image functionality
    document.getElementById('removeImage').addEventListener('click', function() {
        document.getElementById('upload_image').value = ''; // Clear file input
        document.getElementById('uploaded_image').src = ''; // Clear image preview
        document.getElementById('imagePreview2').style.display = 'none'; // Hide image preview area
    });
    // Remove image functionality
    document.getElementById('removeImage2').addEventListener('click', function() {
        document.getElementById('upload_image2').value = ''; // Clear file input
        document.getElementById('uploaded_image2').src = ''; // Clear image preview
        document.getElementById('imagePreview22').style.display = 'none'; // Hide image preview area
    });
    $(document).ready(function() {
        // When image is selected, display the image preview
        $('#payment_image').change(function(event) {
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result);
                    $('#imagePreview').show();
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
    });
    document.getElementById('exportButton').addEventListener('click', function() {
        // Get the table body element
        var tableBody = document.querySelector("#order_summary tbody");

        var dataTablesEmptyCell = document.querySelector("#order_summary tbody .dataTables_empty");

        // Check if the table contains the "No data available" message
        if (dataTablesEmptyCell) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "No data available in table",

                });
            return; // Exit the function
        }


        // Get the table element
        var table = document.getElementById("order_summary");

        // Convert the table to a worksheet
        var workbook = XLSX.utils.table_to_book(table, { sheet: "Order Summary" });

        // Export the worksheet to an Excel file
        XLSX.writeFile(workbook, 'order_summary.xlsx');
    });

    // Mobile only: shorter labels/placeholders that match the Figma design.
    // Runs before select2 is created so the dropdowns pick up the new text.
    if (window.matchMedia('(max-width: 767px)').matches) {
        $('#start_date').attr('placeholder', 'Start date');
        $('#end_date').attr('placeholder', 'End date');
        $('#page_length option').each(function () { $(this).text($(this).val()); });
        $('#user_filter option[value="all"]').text('All reps');
    }

    $('.summary-datepicker').datepicker();
    $('.summary-select2').select2();

    $(document).ready(function() {

        let hoverTimeout;

        // The auto-minimize / hover-expand sidebar behaviour is for desktop only.
        var arMobileQuery = window.matchMedia('(max-width: 767px)');

        function minimizeSidebar() {
            if ($('#minimize_icon').length && $('#minimize_icon').css('display') != 'none') {
                $('#minimize_icon')[0].click();
            }
        }

        // Mobile only: if the sidebar is in its minimized state
        function restoreSidebarOnMobile() {
            if (!arMobileQuery.matches || !$('#maximize_icon').length) return;
            var $nav = $('#sidenav-main');
            var maximizeShown = $('#maximize_icon').css('display') != 'none';
            var navTooNarrow = $nav.length && $nav.outerWidth() < $(window).width() * 0.8;
            if (maximizeShown || navTooNarrow) {
                $('#maximize_icon')[0].click(); // works even if the icon is hidden by CSS
            }
        }

        if (arMobileQuery.matches) {
            restoreSidebarOnMobile();
            // in case another script minimizes it after page load
            setTimeout(restoreSidebarOnMobile, 300);
            setTimeout(restoreSidebarOnMobile, 1200);
        } else {
            minimizeSidebar();
        }

        // Resizing across the breakpoint: normal sidebar on mobile, minimized on desktop.
        var onArBreakpointChange = function (e) {
            if (e.matches) {
                restoreSidebarOnMobile();
            } else {
                minimizeSidebar();
            }
        };
        if (arMobileQuery.addEventListener) {
            arMobileQuery.addEventListener('change', onArBreakpointChange);
        } else if (arMobileQuery.addListener) {
            arMobileQuery.addListener(onArBreakpointChange); // older Safari
        }

        $('#sidenav-main').hover(
            function() {
                if (arMobileQuery.matches) return;
                hoverTimeout = setTimeout(function() {
                    if ($('#maximize_icon').css('display') != 'none') {
                        $('#maximize_icon').click();
                    }
                }, 500);
            },
            function() {
                clearTimeout(hoverTimeout);
                if (arMobileQuery.matches) return;
                minimizeSidebar();
            }
        );

        $('input[name="dateFilter"]').on('click', function() {
            $('#start_date').val('');
            $('#end_date').val('');
            if ($(this).is(':checked')) {
                if ($(this).hasClass('active-radio')) {
                    $(this).prop('checked', false).removeClass('active-radio');
                    $(this).closest('.row-for-date-options').css('background-color', '#F8F8F8');
                    $(this).closest('.row-for-date-options').find('label span').css('color', 'black');
                } else {
                    $('input[name="dateFilter"]').removeClass('active-radio');
                    $(this).addClass('active-radio');
                    $('.row-for-date-options').css('background-color', '#F8F8F8');
                    $('.row-for-date-options label span').css('color', 'black');
                    $(this).closest('.row-for-date-options').css('background-color', '#7bd8ed');
                    $(this).closest('.row-for-date-options').find('label span').css('color', 'white');
                }
            }
        });

        $('#start_date, #end_date').focus(function() {
            $('input[name="dateFilter"]').prop('checked', false);
        });

        // Step 1: Add custom date sort
        jQuery.extend(jQuery.fn.dataTable.ext.type.order, {
            "date-custom-pre": function (dateStr) {
                if (!dateStr) return 0;
                var parts = dateStr.split('/');
                return parts.length === 3
                    ? parseInt(parts[2] + parts[0].padStart(2, '0') + parts[1].padStart(2, '0'))
                    : 0;
            },
            "date-custom-asc": function (a, b) {
                return a - b;
            },
            "date-custom-desc": function (a, b) {
                return b - a;
            }
        });

        var table = $('#order_summary').DataTable({
            paging: true,
            scrollX: true,
            pageLength: $('#page_length').val(),
            searching: true,
            ordering: true,
            info: false,
            fixedHeader: true,
            lengthChange: false,
            bSort: false,
            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'Payables Search'
            },
            columnDefs: [
                { targets: [0], orderable: false },
                { targets: [5], className: "text-right" },
                { targets: [2], className: "org-name" },
                { targets: [1, 4, 5, 6, 7, 8], className: "text-center" },
                { targets: [8, 9, 10], type: "date-custom" }
            ]
        });

        // Last orders received from the server (used by the mobile "Sort by")
        var lastOrders = [];

        function make_summary_table() {
            $('.se-pre-con').fadeIn();
            var formData = new FormData($('#summary_filter_form')[0]);

            $.ajax({
                url: "{{ route('get_ar_report_data') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    $('#total_sale').text(parseFloat(response.total_sale).toFixed(2));
                    $('#number_of_sale').text(response.number_of_sale);
                    lastOrders = Object.values(response.orders || {});
                    updateTable(getOrdersForDisplay());
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        function save_summary_report() {
            $('.se-pre-con').fadeIn();
            var formData = new FormData($('#summary_filter_form')[0]);

            $.ajax({
                url: "{{ route('save_ar_report_data') }}",
                type: 'POST',
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    $('.se-pre-con').fadeOut();

                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function updateTable(data) {
            table.clear();
            var data = Object.values(data);
            console.log(data);
            data.forEach(function(order) {

                var rowNode = table.row.add([
                    '<input type="checkbox" class="checkbox_of_invoice" value="'+order.id+'" id="checkbox_of_invoice_'+order.id+'"  />',
                    '<a style="color:black !important" href="#" class="edit-order" data-value="'+order.id+'">'+order.order_no+'</a>',
                    order.organization_details.organization_name,
                    order.user_details.name,
                    calculateTotalQty(order.order_items),
                    '<td style="text-align: right;">' + parseFloat(order.order_total).toFixed(2) + '</td>',
                    '<td style="text-align: right;">' + parseFloat(order.Received_totalPayment).toFixed(2) + '</td>',
                    '<td style="text-align: right;">' + parseFloat(order.balance_to_be_paid).toFixed(2) + '</td>',
                    order.open_date,
                    order.production_date,
                    order.due_date
                ]).node();
                // Mobile card: order status (from status_details) shown next to the order number.
                // Stored as an attribute only, so the desktop table and Excel export are unchanged.
                $(rowNode).children('td').eq(1).attr('data-ar-status',
                    (order.status_details && order.status_details.status_name) ? order.status_details.status_name : '');
            });

            table.draw();
            table.page.len(parseInt($('#page_length').val())).draw();
            $('.se-pre-con').fadeOut();
            function calculateTotalQty(orderItems) {
                return orderItems
                    .filter(item => item && item.deleted_at == null && item.active == 1)
                    .reduce((sum, item) => sum + parseInt(item.qty || 0, 10), 0);
            }
        }

        $('#pin-filter').on('click', function() {
            make_summary_table();
        });
        $('#save-report').on('click', function() {
            save_summary_report();
        });

        $('#page_length').on('change', function() {
            table.page.len(parseInt($(this).val())).draw();
        });
        $('#user_filter').on('change', function() {
            make_summary_table();
        });
        $('#team_type_filter').on('change', function() {
            make_summary_table();
        });
        $("body").on("click", ".edit-order", function(){
            var orderId = $(this).data('value');
            window.open('order_details/edit/'+orderId+'/order?active_tab=order', '_blank');
        });
        $('#checkbox_of_invoice_all').change(function() {
            var checked = $(this).is(':checked');
            $('.checkbox_of_invoice').prop('checked', checked).trigger('change');
        });

        var invoice_array = [];
        function is_same_org_selected() {
            let is_same_organization = true;
            let organization_name = null;

            // Get all selected checkboxes across pages
            let table = $('#order_summary').DataTable();
            let selectedRows = table.$('.checkbox_of_invoice:checked', { page: 'all' });

            selectedRows.each(function() {
                var current_org_name = $(this).closest('tr').find('.org-name').text().trim();

                if (organization_name === null) {
                    organization_name = current_org_name;
                } else if (organization_name !== current_org_name) {
                    is_same_organization = false;
                    return false; // Break loop
                }
            });

            return is_same_organization;
        }
        $('body').on('change', '.checkbox_of_invoice', function() {
            var value = $(this).val();

            if ($(this).is(':checked')) {
                if (!invoice_array.includes(value)) {
                    invoice_array.push(value);
                }
            } else {
                var index = invoice_array.indexOf(value);
                if (index > -1) {
                    invoice_array.splice(index, 1);
                }
            }





            $('#invoice_checked_count').text(invoice_array.length);
            $('#make_bulk_invoice_count').text(invoice_array.length);

            if (invoice_array.length > 0) {
                $('#pay_multiple').show();
                $('#pay_multiple_invoices').val(invoice_array);
                $('#make_bulk_invoices').val(invoice_array);
                if((is_same_org_selected())){
                    $('#make_bulk_invoice').show();
                    $('#payment_received_btn').show();
                }else{
                    $('#make_bulk_invoice').hide();
                    $('#payment_received_btn').hide();
                }
            } else {
                $('#pay_multiple').hide();
                $('#make_bulk_invoice').hide();
                $('#pay_multiple_invoices').val('');
                $('#make_bulk_invoices').val('');
            }
        });



        $('body').on('click', '.multiple-pay-button', function(e) {
            e.preventDefault();

            $('.only_for_payment').hide();
            $('#imagePreview').attr('src', '');
            $('#payment_image').val('');

            $('#comfirm_modal').modal('show');
        });
        $('body').on('click', '#admin_clear_btn', function(e) {
            e.preventDefault();
            $('#comfirm_modal').modal('hide');
            $('#paymentReceivedModalLabel').text('CLEAR BY ADMIN');
            $('.only_for_payment').hide();
            $('#paymentReceivedModal').modal('show');
        });
        $('body').on('click', '#payment_received_btn', function(e) {
            e.preventDefault();
            $('#comfirm_modal').modal('hide');
            $('#paymentReceivedModalLabel').text('RECEIVED PAYMENTS');
            $('.only_for_payment').show();
            $('#imagePreview').hide();

            $(".se-pre-con").fadeIn('slow');

            var arrayData = $('#pay_multiple_invoices').val();

            var invoiceArray = arrayData.split(',');

            invoiceArray = invoiceArray.map(function(item) {
                return item.trim();
            });

            $.ajax({
                    url:"{{ route('get_multiple_order_details') }}",
                    type: "POST",
                    data: {
                        'order_ids': invoiceArray,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (data) {
                        $(".se-pre-con").fadeOut('slow');

                        $('#selectedInvoiceTr').empty();

                        var orders = data.data;
                        orders.sort((a, b) => a.id - b.id);

                        if (orders && orders.length > 0) {
                            var totalAmount = 0.00;
                            orders.forEach(function(invoice) {

                                let organizationName = invoice.organization_details.organization_name;
                                if (organizationName.length > 50) {
                                    organizationName = organizationName.substring(0, 50) + '...';
                                }
                                var row = `
                                            <tr>
                                                <td class="text-center"><a style="color:black !important" href="#" class="edit-order" data-value="${invoice.id}">${invoice.order_no}</a></td>
                                                <td class="text-left">${organizationName}</td>
                                                <td class="text-right total-amount-to-pay">${parseFloat(invoice.order_total).toFixed(2)}</td>
                                                <td class="text-right paid-amount-total">${invoice.payment_status.total_payment}</td>
                                                <td class="text-right paid-amount-total">${parseFloat(invoice.payment_status.balance_to_be_paid).toFixed(2)}</td>
                                                <td>
                                                    <input type="text" max="${invoice.payment_status.balance_to_be_paid}" class="invoice_payment_amount form-control text-right" name="payment_amount[${invoice.id}]" value="${parseFloat(invoice.payment_status.balance_to_be_paid).toFixed(2)}">
                                                    <input type="hidden" max="${invoice.payment_status.balance_to_be_paid}" class="invoice_payment_amount_orginal form-control text-right" value="${parseFloat(invoice.payment_status.balance_to_be_paid).toFixed(2)}">
                                                </td>
                                            </tr>
                                        `;
                                        $('#selectedInvoiceTr').append(row);

                                        totalAmount += invoice.payment_status.balance_to_be_paid;
                            });

                            var totalRow = `
                                            <tr>
                                                <td class="hard-top-border"></td>
                                                <td class="hard-top-border"></td>
                                                <td class="hard-top-border"></td>
                                                <td class="hard-top-border"></td>
                                                <td class="text-right hard-top-border" style="font-weight:800">Invoice Total : </td>
                                                <td class="hard-top-border">
                                                    <input type="hidden" name="total_amount" id="total_paid_amount" value="${parseFloat(totalAmount).toFixed(2)}">
                                                    <input type="text" value="${parseFloat(totalAmount).toFixed(2)}" class="form-control text-right" style="font-weight:800" readonly>
                                                </td>
                                            </tr>
                                        `;
                            $('#selectedInvoiceTr').append(totalRow);

                            $('#transaction_amount_cash,#total_sum_of_payment').val(parseFloat(totalAmount).toFixed(2));

                            $('#payMultipleModal').modal('show');
                        }
                    }
                });

                $(".se-pre-con").fadeOut('slow');

        });
        $(document).on('change', '#total_sum_of_payment', function() {
            handlePaymentValues();
        });
        function handlePaymentValues() {
            $(".se-pre-con").fadeIn('slow');
            var total_paid_amount = parseFloat($('#total_sum_of_payment').val()) || 0;
            var total_invoice_amount = parseFloat($('#total_paid_amount').val()) || 0;


            if (total_paid_amount > total_invoice_amount) {
                $('#debit_acc_summary_line_1').html('');
                var overPayment = (total_paid_amount - total_invoice_amount).toFixed(2);
                var htmlContent1 = '<p style="margin: 0;font-weight: 600;color: grey;">Excess payment for this transaction = $' + overPayment + '</p>';
                $('#debit_acc_summary_line_1').html(htmlContent1);
            }

            if (total_paid_amount < total_invoice_amount) {
                $('#debit_acc_summary_line_1').html('');
                var remaining_payment = (total_invoice_amount - total_paid_amount ).toFixed(2);
                var htmlContent1 = '<p style="margin: 0;font-weight: 600;color: grey;">Remaining payment for this transaction = $' + remaining_payment + '</p>';

                $('#debit_acc_summary_line_1').html(htmlContent1);

            }
            if (total_paid_amount > 0) {

                let total = 0;
                let is_exeed = false;

                $('#selectedInvoiceTr').find('tr').each(function () {
                    let $row = $(this);
                    let $input = $row.find('td .invoice_payment_amount');
                    let $originalInput = $row.find('td .invoice_payment_amount_orginal');

                    let originalBalance = parseFloat($originalInput.val()) || 0;
                    let value = parseFloat($input.val()) || 0;

                    total += originalBalance;

                    if(!is_exeed){
                        if(total >  (total_paid_amount)){
                            $($input).val((originalBalance - total + (total_paid_amount)).toFixed(2)).trigger('change');
                            is_exeed = true;
                        }else{
                            $($input).val((originalBalance).toFixed(2)).trigger('change');
                        }
                    }else{
                        $($input).val((0).toFixed(2)).trigger('change');
                    }
                });

            }

            if (total_paid_amount == total_invoice_amount) {
                console.log('Payment settled');
                // $('#transaction_amount_debit').prop('readonly', true);
                $('#debit_acc_summary_line_1, #debit_acc_summary_line_2').html('');
            }

            $(".se-pre-con").fadeOut('slow');
        }

        $(document).on('input', '.invoice_payment_amount', function() {
            calculateTotalAmount();
        });

        function calculateTotalAmount() {
            var totalAmount = 0;
            $('.invoice_payment_amount').each(function() {
                var amount = parseFloat($(this).val());
                if (!isNaN(amount)) {
                    totalAmount += amount;
                }
            });
            $('#total_sum_of_payment').val(totalAmount.toFixed(2));

        }

        $('body').on('click', '.make-bulk-invoice', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Create Bulk Invoice',
                text: 'Do you want to create bulk invoice?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                reverseButtons: true
            }).then((result) => {
                console.log(result);

                if (result.value) {
                    $(this).closest('form').submit();
                } else {
                    console.log('Form submission canceled.');
                }
            });
        });


    $('#submit_payment_received').click(function(e) {
        e.preventDefault();

        var arrayData = $('#pay_multiple_invoices').val();
        var invoiceArray = arrayData.split(',').map(function(item) {
            return item.trim();
        });

        var paymentImage = $('#payment_image')[0].files[0];
        var paymentDescription = $('#other_payment_description').val();

        if (!paymentDescription) {
            Swal.fire(
                'Incomplete Form',
                'Please enter a description.',
                'warning'
            );
            return;
        }

        var formData = new FormData();
        formData.append('payment_image', paymentImage);
        formData.append('description', paymentDescription);
        formData.append('invoices', invoiceArray);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: "{{ route('order_mark_as_paid') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(response) {
                $(".se-pre-con").fadeOut('slow');
                Swal.fire(
                    'Payment Submitted!',
                    'The payment has been successfully submitted.',
                    'success'
                );
                location.reload();
            },
            error: function(xhr, status, error) {
                $(".se-pre-con").fadeOut('slow');
                Swal.fire(
                    'Error!',
                    'There was an error processing the payment. Please try again.',
                    'error'
                );
            }
        });
    });


    function setDates(dateType) {
        var startDate, endDate;
        var currentDate = new Date();

        switch (dateType) {
            case 'thisMonth':
                startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
                endDate = currentDate; // Use today's date as the end date
                break;
            case 'lastMonth':
                startDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, 1);
                endDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 0);
                break;
            case 'thisYear':
                startDate = new Date(currentDate.getFullYear(), 0, 1);
                endDate = currentDate; // Use today's date as the end date
                break;
            case 'lastYearToday':
                startDate = new Date(currentDate.getFullYear() - 1, 0, 1);
                endDate = new Date(currentDate.getFullYear() - 1, currentDate.getMonth(), currentDate.getDate());
                break;
            case 'thisQuarter':
                var quarter = Math.floor((currentDate.getMonth() + 3) / 3);
                startDate = new Date(currentDate.getFullYear(), (quarter - 1) * 3, 1);
                endDate = currentDate; // Use today's date as the end date
                break;
            default:
                startDate = '';
                endDate = '';
        }

        if (startDate) {
            $('#start_date').val(formatDate(startDate));
        }
        if (endDate) {
            $('#end_date').val(formatDate(endDate));
        }
        make_summary_table();
    }
    function formatDate(date) {
        var day = String(date.getDate()).padStart(2, '0');
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var year = date.getFullYear();
        return month + '/' + day + '/' + year;
    }

    /* =================================================================
       MOBILE-ONLY HELPERS
       ================================================================= */
    function isArMobile() {
        return window.matchMedia('(max-width: 767px)').matches;
    }

    // Orders in the order they should be shown.
    // Desktop: exactly as returned by the server (unchanged behaviour).
    // Mobile: sorted by the "Sort by" dropdown.
    function getOrdersForDisplay() {
        var orders = lastOrders.slice();
        if (!isArMobile()) {
            return orders;
        }
        var num = function (v) { return parseFloat(v) || 0; };
        var orgName = function (o) {
            return (o.organization_details && o.organization_details.organization_name) ? String(o.organization_details.organization_name) : '';
        };
        switch ($('#ar-m-sort-select').val()) {
            case 'organization':
                orders.sort(function (a, b) { return orgName(a).localeCompare(orgName(b)); });
                break;
            case 'total':
                orders.sort(function (a, b) { return num(b.order_total) - num(a.order_total); });
                break;
            case 'balance':
                orders.sort(function (a, b) { return num(b.balance_to_be_paid) - num(a.balance_to_be_paid); });
                break;
            default: // order_no
                orders.sort(function (a, b) {
                    return String(a.order_no).localeCompare(String(b.order_no), undefined, { numeric: true });
                });
        }
        return orders;
    }

    // Export (top) -> existing Excel export
    // Mobile page header: hide the layout's centered title strip (.header1) and
    // show the Figma header instead. Only if that layout header exists, so the
    // title is never shown twice. Then keep the header clear of the fixed top navbar.
    function arFixHeaderOffset() {
        // Place the page header 16px below the layout's fixed mobile bar(s).
        // The space above it comes from the layout (body padding-top, header
        // containers), so it is measured instead of guessed.
        var top = document.querySelector('.ar-m-topbar');
        var nav = document.getElementById('sidenav-main');
        if (!top) return;
        top.style.marginTop = '';
        if (!isArMobile() || !nav || getComputedStyle(nav).position !== 'fixed') return;

        // Bottom of everything fixed at the top of the screen (dark bar + any layout bar still visible)
        var barBottom = nav.getBoundingClientRect().bottom;
        document.querySelectorAll('.main-content nav, .main-content .navbar').forEach(function (el) {
            var cs = getComputedStyle(el), r = el.getBoundingClientRect();
            if (cs.position === 'fixed' && cs.display !== 'none' && cs.visibility !== 'hidden' && r.height > 0 && r.top <= 5) {
                barBottom = Math.max(barBottom, r.bottom);
            }
        });

        var ownHeader = document.body.classList.contains('ar-own-header');
        // Margins can collapse with the layout's margins above, so adjust, re-measure
        // and correct again until the header sits where it should.
        for (var i = 0; i < 5; i++) {
            var topOnPage = top.getBoundingClientRect().top + window.pageYOffset;
            var diff = Math.round(barBottom + 16 - topOnPage);
            // Only pull the header up when the layout's title strip is hidden (nothing is under it)
            if (Math.abs(diff) <= 1 || (diff < 0 && !ownHeader)) break;
            top.style.marginTop = (parseFloat(getComputedStyle(top).marginTop) + diff) + 'px';
        }
    }
    function arSetupMobileHeader() {
        if (isArMobile() && $('.main-content .header1').length) {
            $('body').addClass('ar-own-header');
        }
        arFixHeaderOffset();
    }
    arSetupMobileHeader();
    setTimeout(arFixHeaderOffset, 350);   // after the sidebar restore checks
    setTimeout(arFixHeaderOffset, 1300);
    $(window).on('load', arFixHeaderOffset);   // logo size changes the bar height
    var arResizeTimer;
    $(window).on('resize', function () {
        clearTimeout(arResizeTimer);
        arResizeTimer = setTimeout(arSetupMobileHeader, 150);
    });

    $('#ar-m-export').on('click', function () {
        document.getElementById('exportButton').click();
    });

    // Save to Compare (bottom) -> existing Save report
    $('#ar-m-save-btn').on('click', function () {
        $('#save-report').trigger('click');
    });

    // Search card -> existing DataTables search
    $('#ar-m-search-input')
        .on('input', function () {
            table.search(this.value).draw();
            $('#order_summary_filter input').val(this.value);
        })
        .on('keydown', function (e) {
            if (e.key === 'Enter') { e.preventDefault(); } // don't submit the filter form
        });

    // Sort by -> re-render the rows that are already loaded (no new request)
    $('#ar-m-sort-select').on('change', function () {
        updateTable(getOrdersForDisplay());
    });

    // Clear Filters -> reset the existing filter fields, then reload with the existing request
    $('#ar-m-clear-filters').on('click', function () {
        $('#start_date, #end_date').val('');
        $('input[name="dateFilter"]').prop('checked', false).removeClass('active-radio');
        $('.row-for-date-options').css('background-color', '#F8F8F8');
        $('.row-for-date-options label span').css('color', 'black');
        $('#user_filter').val('all').trigger('change.select2');        // UI only, avoids a double request
        $('#team_type_filter').val('0').trigger('change.select2');
        $('#ar-m-search-input').val('');
        $('#order_summary_filter input').val('');
        table.search('');
        make_summary_table();
    });

    // Select all (mobile) -> existing header "select all" checkbox
    $('#ar-m-select-all').on('change', function () {
        $('#checkbox_of_invoice_all').prop('checked', this.checked).trigger('change');
    });

    // Amounts with thousands separators on the mobile cards ($37,927.92).
    // Stored in a data attribute only; the cell text (used by the Excel export) is untouched.
    function formatArAmounts() {
        $('#order_summary tbody tr').each(function () {
            $(this).children('td').slice(5, 8).each(function () {
                var raw = $(this).text().replace(/[^0-9.\-]/g, '');
                var n = parseFloat(raw);
                if (raw === '' || isNaN(n)) { this.removeAttribute('data-ar-amt'); this.removeAttribute('data-ar-long'); return; }
                var txt = (n < 0 ? '-$' : '$') + Math.abs(n).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                this.setAttribute('data-ar-amt', txt);
                if (txt.length > 11) { this.setAttribute('data-ar-long', ''); } else { this.removeAttribute('data-ar-long'); }
            });
        });
    }
    table.on('draw', formatArAmounts);
    formatArAmounts();

    // "Showing x to y of z entries" next to the pager (mobile only)
    var $arPager = $('#order_summary_wrapper .dataTables_paginate');
    if ($arPager.length) {
        $arPager.parent().addClass('ar-pager-col');
        $('#ar-m-info').insertBefore($arPager);
    }
    function updateArMobileInfo() {
        var info = table.page.info();
        $('#ar-m-info').text(
            info.recordsDisplay > 0
                ? 'Showing ' + (info.start + 1) + ' to ' + info.end + ' of ' + info.recordsDisplay + ' entries'
                : ''
        );
    }
    table.on('draw', updateArMobileInfo);
    updateArMobileInfo();
    /* ================= END MOBILE-ONLY HELPERS ================= */

    setDates($('input[name="dateFilter"]:checked').val());

    $('input[name="dateFilter"]').on('change', function() {
        setDates($(this).val());
    });


        make_summary_table();
    });



</script>

@endsection