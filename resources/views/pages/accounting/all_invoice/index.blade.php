@extends('layouts.app', ['activePage' => 'all_invoice', 'titlePage' => __('All Invoices')])

@section('content')
<style>
     .table-responsive .table tbody td , .table-responsive .table tbody td a {
        padding: 0.4rem 1rem !important;
        font-size: .9rem !important;
        color: rgba(22, 22, 23, 1) !important;
    }
    .date_p {
        margin: unset;
        font-size: 11px;
        color: black;
        font-weight: 500;
    }
    .date_selection {
        background-color: transparent;
        padding: unset;
        border: unset;
        color: #47D6B6;
        font-size: 11px;
    }
    .select2-selection--single{
        background-color: #F8F8F8 !important;
    }
    .select-width-style .select2.select2-container.select2-container--default{
        width: 8rem !important;
    }
    .select-width-style-item .select2.select2-container.select2-container--default{
        width: 10rem !important;
    }
    .filter_row {
        margin-left: unset;
        padding: 2px 9px 2px 8px;
        background-color: #F8F8F8;
        border: 1px solid #DEDEDE;
        border-radius: 5px;
    }

    .d_flex_and_align_center {
        display: flex;
        align-items: center;
    }

    .date_selection {
        background-color: transparent;
        padding: 0;
        border: none;
        color: #47D6B6;
        font-size: 11px;
    }

    .date_p {
        margin: 0;
        font-size: 11px;
        color: black;
        font-weight: 500;
    }

    .filter_btn {
        padding: 5px;
        width: 70px;
        background-color: #2dce89;
        border: none;
        color: white !important;
        cursor: pointer;
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
    .table tbody td {
        padding-top: 7.5px;
        padding-bottom: 7.5px;
    }
    .table thead th {
        color: white;
        height: 40px;
        padding-top: 0;
        padding-bottom: 0;
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

    /* =====================================================================
       ALL INVOICE — MOBILE LAYOUT
       ===================================================================== */
    .ai-m-only { display: none; }

    @media (max-width: 767px) {

        /* ---------- Page shell ---------- */
        .content-position {
            top: 0;                                  /* desktop: top -25px */
            padding-left: 16px !important;
            padding-right: 16px !important;
        }
        .content-position > .col-md-12 { padding-left: 0; padding-right: 0; }
        /* Layout's generic title strip / desktop top bar: replaced by the page header */
        .main-content #header,
        .main-content .header1,
        .main-content > .navbar-top,
        .main-content > #navbar-main { display: none !important; }

        /* One shared outer card: drop its box so the inner cards sit on the grey page */
        .content-position > .col-md-12 > .card {
            background: transparent !important;
            box-shadow: none !important;
            padding: 0;
            border: none !important;                 /* theme draws a thin border around the outer card */
            border-radius: 0;
            outline: none;
        }
        .content-position > .col-md-12.new-style-table { border: none !important; box-shadow: none !important; }
        .content-position > .col-md-12 > .card > .col-md-12 {
            margin: 0 !important;
            padding-left: 0;
            padding-right: 0;
        }
        .content-position .new-style-table .table-responsive { overflow: visible; }
        .content-position > .col-md-12 > .card > .col-md-12 > div { padding: 0; }

        /* ---------- Page header ---------- */
        .ai-m-header {
            display: block;
            margin: 4px 0 18px;
        }
        .ai-m-back {
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
        .ai-m-back i { font-size: 11px; }
        .ai-m-title {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            line-height: 1.25;
            color: #111827;
        }

        /* ---------- DataTables wrapper ---------- */
        #all_invoice_wrapper > .row { margin-left: 0; margin-right: 0; }
        #all_invoice_wrapper > .row > [class*="col-"] { padding-left: 0; padding-right: 0; }
        #all_invoice_wrapper .dataTables_length { display: none !important; }
        /* scrollX: hide the cloned header, let the body flow as cards */
        #all_invoice_wrapper .dataTables_scrollHead { display: none !important; }
        #all_invoice_wrapper .dataTables_scroll,
        #all_invoice_wrapper .dataTables_scrollBody {
            overflow: visible !important;
            width: 100% !important;
            height: auto !important;
            border: none !important;
        }

        /* ---------- Search card ---------- */
        #all_invoice_wrapper .dataTables_filter {
            float: none;
            width: 100%;
            margin: 0 0 14px;
            padding: 14px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(17, 24, 39, 0.06);
            text-align: left;
        }
        #all_invoice_wrapper .dataTables_filter label {
            position: relative;
            display: block;
            width: 100%;
            margin: 0;
            font-size: 0;                            /* only the icon + input are shown */
        }
        #all_invoice_wrapper .dataTables_filter label i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: #111827;
            pointer-events: none;
        }
        #all_invoice_wrapper .dataTables_filter input {
            display: block;
            width: 100% !important;
            height: 44px;
            margin: 0 !important;
            padding: 0 12px 0 40px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #f5f6f7;
            color: #111827;
            font-size: 15px;
            box-shadow: none;
            outline: none;
        }
        #all_invoice_wrapper .dataTables_filter input::placeholder { color: #9ca3af; }


        /* ---------- Filter card: Factory | Status / Start | End / Clear | Filter ---------- */
        #AllInvoice_filter_form {
            margin: 0 0 14px;
            padding: 14px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(17, 24, 39, 0.06);
        }
        #AllInvoice_filter_form > .row { margin: 0 !important; }
        #AllInvoice_filter_form > .row > .row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 12px;
            width: 100%;
            margin: 0 !important;                    /* mx-4 */
            padding: 0 !important;                   /* pb-2 */
        }
        #AllInvoice_filter_form .filter_row {
            display: block;
            min-width: 0;
            margin: 0 !important;                    /* mr-2 */
            padding: 0;
            background: transparent;
            border: none;
            border-radius: 0;
        }
        #AllInvoice_filter_form .filter_row > .date_p { display: none; }   /* "FACTORY |", "Start Date |" */
        #AllInvoice_filter_form .filter_row > .date_selection { display: block; padding: 0 !important; }
        #AllInvoice_filter_form .select-width-style .select2.select2-container.select2-container--default { width: 100% !important; }
        #AllInvoice_filter_form .select2-container .select2-selection--single {
            height: 44px;
            padding: 0 !important;                   /* theme padding */
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #f5f6f7 url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12'%3E%3Cpath d='M2.5 4.5 6 8l3.5-3.5' fill='none' stroke='%23374151' stroke-width='1.6' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") no-repeat right 12px center / 12px 12px !important;
            outline: none;
        }
        #AllInvoice_filter_form .select2-container .select2-selection__rendered {
            padding: 0 32px 0 12px;
            line-height: 42px;
            color: #111827;
            font-size: 15px;
        }
        /* Field name inside the box ("Factory: DWC"), so the value is never ambiguous */
        #AllInvoice_filter_form .ai-f-factory .select2-selection__rendered::before { content: "Factory: "; color: #9ca3af; }
        #AllInvoice_filter_form .ai-f-status  .select2-selection__rendered::before { content: "Status: ";  color: #9ca3af; }
        #AllInvoice_filter_form .select2-container .select2-selection__arrow { display: none; }   /* chevron drawn above */
        #AllInvoice_filter_form .summary-datepicker {
            display: block;
            width: 100%;
            height: 44px !important;                 /* inline 2rem */
            margin: 0;
            padding: 0 32px 0 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #f5f6f7 url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12'%3E%3Cpath d='M2.5 4.5 6 8l3.5-3.5' fill='none' stroke='%23374151' stroke-width='1.6' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") no-repeat right 12px center / 12px 12px !important;
            color: #111827;
            font-size: 15px;
            outline: none;
        }
        #AllInvoice_filter_form .summary-datepicker::placeholder { color: #9ca3af; }
        #AllInvoice_filter_form .summary-datepicker:focus { border-color: #47D6B6; }
        /* Clear Filters (mobile only) / Filter (existing button) */
        #AllInvoice_filter_form .ai-m-clear,
        #AllInvoice_filter_form #pin-filter {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            height: 44px !important;                 /* inline height: 100% */
            margin: 0;
            padding: 0;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
        }
        #AllInvoice_filter_form .ai-m-clear {
            background: #fff;
            border: 1px solid #e5e7eb;
            color: #6b7280;
        }
        #AllInvoice_filter_form #pin-filter {
            background: #111827;
            border: 1px solid #111827;
            color: #fff !important;
        }
        #AllInvoice_filter_form .ai-f-btn { display: block; margin: 0 !important; }   /* ml-2 */

        /* ---------- "Sort by" / "Select All" + "Show [20] entries" ---------- */
        .ai-m-toolbar { display: block; margin: 0 0 4px; }
        .ai-m-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }
        .ai-m-row + .ai-m-row { margin-top: 10px; }
        .ai-m-row.is-sort { justify-content: flex-end; }
        .ai-m-selectall {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin: 0;
            padding-left: 14px;
            font-size: 14px;
            color: #6b7280;
            cursor: pointer;
        }
        .ai-m-show {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 0;
            font-size: 14px;
            color: #6b7280;
            white-space: nowrap;
        }
        .ai-m-show select {
            min-width: 0;
            height: 34px;
            padding: 0 28px 0 10px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12'%3E%3Cpath d='M2.5 4.5 6 8l3.5-3.5' fill='none' stroke='%23374151' stroke-width='1.6' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") no-repeat right 9px center / 11px 11px;
            color: #111827;
            font-size: 14px;
            font-weight: 500;
            -webkit-appearance: none;
            appearance: none;
        }

        /* Checkboxes (design): square, teal when checked */
        
        #ai-m-select-all,
        #all_invoice > tbody > tr .checkbox_of_invoice {
            -webkit-appearance: none;
            appearance: none;
            flex: 0 0 auto;
            width: 20px;
            height: 20px;
            margin: 0;
            border: 1.5px solid #d1d5db;
            border-radius: 4px;
            background: #fff no-repeat center / 14px 14px;
            cursor: pointer;
        }
        #ai-m-select-all:checked,
        #all_invoice > tbody > tr .checkbox_of_invoice:checked {
            border-color: #47D6B6;
            background-color: #47D6B6;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath d='M3.5 8.5l3 3 6-7' fill='none' stroke='%23fff' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        }

        /* ---------- Table -> invoice cards ---------- */
        #all_invoice {
            display: block;
            width: 100% !important;
            margin: 10px 0 0 !important;
            overflow: visible;                       /* .table-responsive on the table */
            border: none;
        }
        #all_invoice > thead { display: none; }
        #all_invoice > tbody { display: block; width: 100%; }
        /* DataTables Responsive (if loaded) must not hide columns or add child rows */
        #all_invoice > tbody > tr.child { display: none !important; }
        #all_invoice > tbody > tr > td.dtr-control::before { display: none !important; }

        /* [x] INV1246 ............ [Generated Invoice]
           Order ID - #002580
           Organization  Test Organization
           [Total]            [Paid]
           - - - - - - - - - - - - - - - - - -
           Created At ............. Updated At */
        #all_invoice > tbody > tr {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            column-gap: 10px;
            margin-bottom: 14px;
            padding: 16px 16px 14px;
            background: #fff !important;
            border: 1px solid #f0f1f3 !important;
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(17, 24, 39, 0.06);
            cursor: pointer;
            -webkit-tap-highlight-color: transparent;
        }
        #all_invoice > tbody > tr.ai-selected {
            background: #f2fbf8 !important;
            border: 1.5px solid #47D6B6 !important;
        }
        #all_invoice > tbody > tr > td {
            display: block !important;               /* also beats Responsive's display: none */
            box-sizing: border-box;
            min-width: 0;
            padding: 0 !important;
            border: none !important;
            text-align: left !important;
            font-size: 13px !important;              /* page rule: .9rem !important */
            color: #111827 !important;
            white-space: normal;
            overflow-wrap: anywhere;
        }
        #all_invoice > tbody > tr > td a { padding: 0 !important; }       /* page rule: .4rem 1rem !important */

        /* Line 1: checkbox + invoice number, status on the right */
        #all_invoice > tbody > tr > td:nth-child(1) { order: 1; flex: 0 0 auto; line-height: 0; margin-right: 2px; }
        #all_invoice > tbody > tr > td:nth-child(2) { order: 2; flex: 1 1 auto; }
        #all_invoice > tbody > tr > td:nth-child(2),
        #all_invoice > tbody > tr > td:nth-child(2) a {
            font-size: 18px !important;
            font-weight: 700;
            line-height: 1.3;
            color: #111827 !important;
            text-decoration: none;
        }
        #all_invoice > tbody > tr > td:nth-child(5) { order: 3; flex: 0 0 auto; }
        #all_invoice > tbody > tr > td:nth-child(5) .badge {
            display: inline-block;
            width: auto !important;                  /* inline width: 100% */
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 500;
            line-height: 1.4;
            letter-spacing: 0;
            text-transform: none;
            white-space: nowrap;
        }
        /* Design colours + wording (the server text has "Genarated" / "Payble") */
        #all_invoice > tbody > tr > td:nth-child(5) .badge[style*="#b2d0f8" i] { color: #1d63d6 !important; background-color: #dbe8fb !important; }
        #all_invoice > tbody > tr > td:nth-child(5) .badge[style*="#fffecc" i] { color: #b98200 !important; background-color: #fff3c4 !important; }
        #all_invoice > tbody > tr > td:nth-child(5) .badge[style*="#ffcccc" i] { color: #e01e1e !important; background-color: #fde4e4 !important; }
        #all_invoice > tbody > tr > td:nth-child(5) .badge[style*="#d7ffcc" i] { color: #3a9d23 !important; background-color: #e5f6dc !important; }
        #all_invoice > tbody > tr > td:nth-child(5) .badge[style*="#b2d0f8" i],
        #all_invoice > tbody > tr > td:nth-child(5) .badge[style*="#fffecc" i] { font-size: 0; }
        #all_invoice > tbody > tr > td:nth-child(5) .badge[style*="#b2d0f8" i]::after { content: "Generated Invoice"; font-size: 12px; }
        #all_invoice > tbody > tr > td:nth-child(5) .badge[style*="#fffecc" i]::after { content: "Payable Invoice"; font-size: 12px; }

        /* Line 2-3: "Order ID - #002580", "Organization  Test Organization" */
        #all_invoice > tbody > tr > td:nth-child(3) { order: 4; flex: 0 0 100%; margin-top: 4px; }
        #all_invoice > tbody > tr > td:nth-child(3),
        #all_invoice > tbody > tr > td:nth-child(3) a {
            font-size: 15px !important;
            color: #111827 !important;
            text-decoration: none;
        }
        #all_invoice > tbody > tr > td:nth-child(3)::before { content: "Order ID - #"; }
        #all_invoice > tbody > tr > td:nth-child(4) { order: 5; flex: 0 0 100%; margin-top: 4px; }
        #all_invoice > tbody > tr > td:nth-child(4)::before { content: "Organization"; margin-right: 10px; color: #8a8f98; }

        /* Line 4: Total / Paid boxes */
        #all_invoice > tbody > tr > td:nth-child(6) { order: 6; }
        #all_invoice > tbody > tr > td:nth-child(7) { order: 7; color: #3a9d23 !important; }
        #all_invoice > tbody > tr > td:nth-child(6),
        #all_invoice > tbody > tr > td:nth-child(7) {
            display: flex !important;
            flex-wrap: wrap;
            align-content: flex-start;
            flex: 1 1 0;
            align-self: stretch;
            margin-top: 12px;
            padding: 7px 10px 8px !important;
            background: #f3f4f6;
            border-radius: 8px;
            font-size: 15px !important;
            line-height: 1.35;
        }
        #all_invoice > tbody > tr > td:nth-child(6)::before,
        #all_invoice > tbody > tr > td:nth-child(7)::before {
            order: -2;
            flex: 0 0 100%;
            margin-bottom: 1px;
            font-size: 13.5px;
            color: #8a8f98;
        }
        #all_invoice > tbody > tr > td:nth-child(6)::before { content: "Total"; }
        #all_invoice > tbody > tr > td:nth-child(7)::before { content: "Paid"; }
        #all_invoice > tbody > tr > td:nth-child(6)::after,
        #all_invoice > tbody > tr > td:nth-child(7)::after { content: "$"; order: -1; }

        /* Dashed divider, then Created At / Updated At */
        #all_invoice > tbody > tr::after {
            content: "";
            order: 8;
            flex: 0 0 100%;
            height: 0;
            margin-top: 12px;
            border-top: 1px dashed #e5e7eb;
        }
        #all_invoice > tbody > tr > td:nth-child(8) { order: 9; flex: 1 1 auto; margin-right: -10px; }
        #all_invoice > tbody > tr > td:nth-child(9) { order: 10; flex: 0 0 auto; margin-left: auto; }
        #all_invoice > tbody > tr > td:nth-child(8),
        #all_invoice > tbody > tr > td:nth-child(9) {
            margin-top: 10px;
            font-size: clamp(11px, 3vw, 12.5px) !important;
            font-weight: 600;
            white-space: nowrap;
        }
        #all_invoice > tbody > tr > td:nth-child(8)::before,
        #all_invoice > tbody > tr > td:nth-child(9)::before {
            margin-right: 5px;
            font-weight: 400;
            color: #8a8f98;
        }
        #all_invoice > tbody > tr > td:nth-child(8)::before { content: "Created At"; }
        #all_invoice > tbody > tr > td:nth-child(9)::before { content: "Updated At"; }

        /* "No data available" row */
        #all_invoice > tbody > tr:has(> td.dataTables_empty) { cursor: default; }
        #all_invoice > tbody > tr:has(> td.dataTables_empty)::after { display: none; }
        #all_invoice > tbody > tr > td.dataTables_empty {
            flex: 1 1 100%;
            padding: 6px 0 !important;
            font-size: 14px !important;
            text-align: center !important;
            color: #6b7280 !important;
        }

        /* ---------- Pager ---------- */
        #all_invoice_wrapper > .row:last-child {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-top: 6px;
        }
        #all_invoice_wrapper > .row:last-child > [class*="col-"] {
            flex: 0 1 auto;
            width: auto;
            max-width: none;
        }
        #all_invoice_wrapper .dataTables_info {
            padding: 0 !important;
            font-size: 13px;
            color: #9ca3af;
            white-space: normal;
        }
        #all_invoice_wrapper .dataTables_paginate { margin: 0 !important; }
        #all_invoice_wrapper .pagination {
            flex-wrap: wrap;
            justify-content: flex-end !important;
            gap: 6px;
            margin: 0 !important;
        }
        #all_invoice_wrapper .page-item .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            margin: 0;
            padding: 0 8px;
            border: 1px solid #e5e7eb;
            border-radius: 6px !important;
            background: #fff;
            color: #111827;
            font-size: 14px;
            box-shadow: none;
        }
        #all_invoice_wrapper .page-item.active .page-link {
            background: #111827;
            border-color: #111827;
            color: #fff;
        }
        #all_invoice_wrapper .page-item.disabled .page-link { color: #9ca3af; }
        #all_invoice_wrapper .page-item.previous .page-link,
        #all_invoice_wrapper .page-item.next .page-link { font-size: 0; }
        #all_invoice_wrapper .page-item.previous .page-link::before,
        #all_invoice_wrapper .page-item.next .page-link::before {
            font-size: 20px;
            line-height: 1;
        }
        #all_invoice_wrapper .page-item.previous .page-link::before { content: "\2039"; }
        #all_invoice_wrapper .page-item.next .page-link::before     { content: "\203A"; }



        /* ---------- Bottom bar: "1 Selected" + Download Invoice ----------
           This IS the existing "Download Invoices" section, restyled. The
           existing code shows / hides it; its button downloads as before. */
        .sec-download-multiple-invoices:not([style*="display: none"]):not([style*="display:none"]) {
            display: flex !important;
        }
        .content-position .sec-download-multiple-invoices {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9990;                           /* above any layout footer / floating button */
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            width: 100%;
            min-height: 72px;
            margin: 0 !important;
            padding: 14px 20px calc(14px + env(safe-area-inset-bottom, 0px)) !important;
            background: #1f2328;
            box-shadow: 0 -4px 16px rgba(17, 24, 39, 0.18);
        }
        body.modal-open .sec-download-multiple-invoices { z-index: 1039; }   /* under a popup's backdrop */
        .sec-download-multiple-invoices > .ai-m-selcount { display: block; font-size: 16px; color: #fff; }
        .sec-download-multiple-invoices > .row { flex: 0 0 auto; margin: 0; }
        .sec-download-multiple-invoices > .row > [class*="col-"] { flex: 0 0 auto; width: auto; max-width: none; padding: 0; }
        .sec-download-multiple-invoices .download_multiple_invoices {
            height: 40px;
            margin: 0 !important;                    /* ml-2 */
            padding: 0 16px !important;
            border-radius: 8px !important;
            background-color: #47D6B6 !important;    /* inline: blue */
            font-size: 0;
            font-weight: 500;
        }
        .sec-download-multiple-invoices .download_multiple_invoices::after { content: "Download Invoice"; font-size: 15px; }
        .content-position { padding-bottom: 80px; }   /* room so the bar never covers the last card */
        body:has(.sec-download-multiple-invoices:not([style*="display: none"]):not([style*="display:none"])) #mobileScrollDownBtn { display: none !important; }
    }

    /* Very small phones (320px - 359px) */
    @media (max-width: 359px) {
        .content-position {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }
        #AllInvoice_filter_form { padding: 12px; }
        #AllInvoice_filter_form > .row > .row { gap: 10px; }
        #AllInvoice_filter_form .select2-container .select2-selection__rendered,
        #AllInvoice_filter_form .summary-datepicker,
        #AllInvoice_filter_form .ai-m-clear,
        #AllInvoice_filter_form #pin-filter { font-size: 14px; }
        #AllInvoice_filter_form .select2-container .select2-selection__rendered { padding-left: 10px; padding-right: 24px; }
        .ai-m-selectall, .ai-m-show { font-size: 13px; }
        .ai-m-selectall { padding-left: 12px; }
        #all_invoice > tbody > tr { padding: 14px 12px 12px; column-gap: 8px; }
        #all_invoice > tbody > tr > td:nth-child(2), #all_invoice > tbody > tr > td:nth-child(2) a { font-size: 16px !important; }
        #all_invoice > tbody > tr > td:nth-child(5) .badge { padding: 3px 8px; }
        #all_invoice > tbody > tr > td:nth-child(8), #all_invoice > tbody > tr > td:nth-child(9) { font-size: 11px !important; }
        #all_invoice > tbody > tr > td:nth-child(8) { margin-right: -8px; }
    }

</style>
<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con" style="display: none;"></div>

        @section('order-header')
            <span>ALL INVOICES</span>
        @endsection

        @section('back-btn')
            <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
        @endsection

        {{-- Mobile only: page header --}}
        <div class="ai-m-only ai-m-header">
            {{-- <a href="{{ route('home') }}" class="ai-m-back"><i class="fa fa-chevron-left"></i> BACK TO HOME</a> --}}
            <h1 class="ai-m-title">All Invoice</h1>
        </div>

        {{-- Mobile only: "Sort by", then "Select All" + "Show [n] entries" (moved under the search box by JS) --}}
        <div class="ai-m-only ai-m-toolbar" id="ai-m-toolbar">
            <div class="ai-m-row is-sort">
                <div class="ai-m-show">
                    <span>Sort by</span>
                    <select id="ai-m-sort">
                        <option value="invoice">Invoice Number</option>
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="total">Total Amount</option>
                    </select>
                </div>
            </div>
            <div class="ai-m-row">
                <label class="ai-m-selectall"><input type="checkbox" id="ai-m-select-all"> Select All</label>
                <div class="ai-m-show">
                    <span>Show</span>
                    <select id="ai-m-entries">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>entries</span>
                </div>
            </div>
        </div>

        <div class="col-md-12 new-style-table">
            <div class="card">
                <div class="col-md-12 mt-2">
                    <form id="AllInvoice_filter_form">
                        @csrf
                        <div class="row mt-2">
                            <div class="row mx-4 pb-2">
                                {{-- Factory Filter --}}
                                <div class="filter_row d_flex_and_align_center mr-2 ai-f-factory">
                                    <p class="date_p">FACTORY |</p>
                                    <div class="date_selection select-width-style ps-2">
                                        <select id="Factory_filter" name="Factory_filter" class="summary-select2">
                                            <option value="1">DWC</option>
                                            {{-- @foreach ($factories as $factory)
                                                <option value="{{ $factory->id }}">{{ $factory->factory_code }}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>

                                {{-- Invoice Status Filter --}}
                                <div class="filter_row d_flex_and_align_center mr-2 ai-f-status">
                                    <p class="date_p">STATUS |</p>
                                    <div class="date_selection select-width-style ps-2">
                                        <select id="invoice_filter" name="invoice_filter" class="summary-select2">
                                            <option value="all">All</option>
                                            <option value="Payble">Payble Invoice</option>
                                            <option value="Generated">Generated Invoice</option>
                                            <option value="Paid">Paid Invoice</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Start Date --}}
                                <div class="filter_row d_flex_and_align_center mr-2">
                                    <p class="date_p ps-1">Start Date |</p>
                                    <div class="date_selection ps-2">
                                        <input type="text" name="start_date" id="start_date" class="summary-datepicker invoice-inputs" style="height: 2rem;background-color: #F8F8F8;">
                                    </div>
                                </div>

                                {{-- End Date --}}
                                <div class="filter_row d_flex_and_align_center mr-2">
                                    <p class="date_p ps-1">End Date |</p>
                                    <div class="date_selection ps-2">
                                        <input type="text" name="end_date" id="end_date" class="summary-datepicker invoice-inputs" style="height: 2rem;background-color: #F8F8F8;">
                                    </div>
                                </div>

                                {{-- Mobile only: Clear Filters (resets the fields and reloads the list) --}}
                                <button type="button" class="ai-m-only ai-m-clear" id="ai-m-clear-filters"><i class="fa fa-times"></i> Clear Filters</button>

                                {{-- Filter Button --}}
                                <div class="d_flex_and_align_center ml-2 ai-f-btn">
                                    <button class="filter_btn date_p" type="button" id="pin-filter" title="Filter" style="height: 100%;">
                                        <i class="fa fa-filter"></i>&nbsp;&nbsp;Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-12 mt-2 sec-download-multiple-invoices" style="display: none;">
                    <span class="ai-m-only ai-m-selcount"><span id="ai-m-selected-count">0</span> Selected</span>
                    <div class="row">
                        <div class="col-md-6 text-left">
                            <button class="download_multiple_invoices ml-2" style="    background-color: #27cde8;color: white;border: none;padding: .2rem .5rem;border-radius: .5rem;">Download Invoices</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-3 mb-3">
                    <div class="">
                        <table class="table align-items-center table-responsive" id="all_invoice" style="width: 100%">
                            <thead style="background-color: #717070;">
                                <th scope="col">
                                    <input type="checkbox" class="checkbox_of_all_invoice"/>
                                </th>
                                <th scope="col" class="invoice-number text-center text-center">Invoice No</th>
                                <th scope="col" class="order-number text-center">Order #</th>
                                <th scope="col" class="organization text-center">Organization</th>
                                <th scope="col" class="status text-center">Status</th>
                                <th scope="col" class="Total_amount-to-paid text-center">Total Amount</th>
                                <th scope="col" class="paid_amount text-center">Paid Amount</th>
                                <th scope="col" class="created-at text-center">Created At</th>
                                <th scope="col" class="updated-at text-center">Updated At</th>
                            </thead>

                            <tbody>
                                @foreach ($factoryinvoices as $factoryinvoice)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkbox_of_invoice" data-value="{{ $factoryinvoice->order_id }}" />
                                    </td>
                                    <td class="invoice-number"><a href="#" class="edit" data-value="{{ $factoryinvoice->id }}">{{ $factoryinvoice->invoice_number }}</a></td>
                                    <td class="order-number">
                                        <a href="{{ route('orders.info', ['id' => $factoryinvoice->order_id, 'type' => 'order']) }}?active_tab=order" target="_blank">
                                            {{  str_pad($factoryinvoice->order_id, 6, '0', STR_PAD_LEFT)  }}
                                        </a>
                                    </td>
                                    <td class="order-organization">{{$factoryinvoice->orderDetails ? $factoryinvoice->orderDetails->organizationDetails->organization_name : ''}}</td>
                                    <td class="status text-center">
                                        @if($factoryinvoice->status == 0 || $factoryinvoice->status == 2)
                                            <span class="badge badge-pill" style="color:#073180;background-color:#b2d0f8;width:100%">Genarated Invoice</span>
                                        @elseif($factoryinvoice->status == 1)
                                            <span class="badge badge-pill" style="color:#c8d647;background-color:#fffecc;width:100%">Payble Invoice</span>
                                        @elseif($factoryinvoice->status == 4)
                                            <span class="badge badge-pill" style="color:#d65a47;background-color:#ffcccc;width:100%">Rejected</span>
                                        @else
                                            <span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:100%">Paid Invoice</span>

                                        @endif
                                    </td>
                                    <td class="total-amount text-right">{{$factoryinvoice->total_amount}}</td>
                                    <td class="paid-amount text-right">{{$factoryinvoice->paid_amount}}</td>
                                    <td class="created-at">{{$factoryinvoice->created_at->format('m/d/Y')}}</td>
                                    <td class="updated-at">{{$factoryinvoice->updated_at->format('m/d/Y')}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('pages.accounting.generate_invoice.create')
<script>
    $(document).ready(function () {
        $('#pin-filter').on('click', function() {
            make_invoice_table();
        });

        $('.summary-select2').select2();
        $('.summary-datepicker').datepicker();

        var generated_invoice = $('#all_invoice').DataTable({
            pageLength: 50,
            responsive: true,
            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'All invoice search'
            },
            columnDefs: [
                {
                    targets: [7, 8],
                    type: 'date'
                }
            ]
        });

        $(document).on('click', '.edit', function (event) {
            event.preventDefault();

            var invoiceId = $(this).data('value'); // Retrieve invoice ID from the data attribute

            $(".se-pre-con").fadeIn('slow'); // Show loading animation
            $('.frm_submit_btn').text('Request Payment'); // Change button text

            $('#new_invoice_no').val(invoiceId); // Set the invoice ID in the input
            $('#generate_invoice').attr('data-selected-invoice-id', invoiceId); // Set the invoice ID as a custom data attribute

            get_invoice_data(invoiceId);
        });
        function get_invoice_data(invoiceId) {
            $.ajax({
                url: `{{ url('invoice/edit') }}/${invoiceId}`,
                method: 'GET',
                cache: false,
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data) {
                    var invoice = data.invoice && Array.isArray(data.invoice) && data.invoice.length > 0 ? data.invoice[0] : null;
                    var additionalData = data.additional || [];

                    if (!invoice) {
                        console.log('Invoice data is missing or invalid.');
                        return;
                    }

                    updateInvoiceFields(invoice);
                    updateAdditionalFields(additionalData);
                    handleInvoiceStatus(invoice);

                    // Set form action and display modal
                    $('#invoice_form').attr('action', `create_factory_invoice`);
                    // $('#generate_invoice').modal('show');
                },
                complete: function () {
                    // $(".se-pre-con").fadeOut('slow');
                },
                error: function (error) {
                    console.log('Error fetching invoice data:', error);
                }
            });
        }

        function updateInvoiceFields(invoice) {
            $('#new_invoice_no').val(invoice.id);
            $('#invoice_no').val(invoice.invoice_number);
            $('#total_value').val(invoice.total_amount);
            $('#reduce_value_input').val(invoice.reduce_value);
            $('#order_number').val(invoice.order_id).trigger('change');
            updateCurrentDate(invoice.created_at);
        }

        function updateAdditionalFields(additionalData) {
            additionalData.forEach(function (item) {
                var additionalInput = document.getElementById(`addition_value_${item.addition_payment_id}`);
                if (additionalInput) {
                    additionalInput.value = item.amount;
                }

                var additionalIdSpan = document.querySelector(`.addition_id[data-value="${item.addition_payment_id}"]`);
                if (additionalIdSpan) {
                    additionalIdSpan.setAttribute('data-value', item.addition_payment_id);
                }

                var otherReasonInput = document.querySelector(`.other-reson[name="other_reson[${item.addition_payment_id}]"]`);
                if (otherReasonInput) {
                    otherReasonInput.value = item.if_other_reson || '';
                }
            });
        }

        function handleInvoiceStatus(invoice) {
            var status = parseInt(invoice.status, 10);

            // if (status === 1 || status === 3) {
                $('#frm_submit_btn').hide();
                $('#frm_submit_btn_save').hide();
            // } else {
                // $('#frm_submit_btn').show();
            // }

            if (status === 0|| status === 4) {
                createActionButton('Delete', 'delete btn-danger', 'delete', invoice.id);
            }else{
                if($('button.delete').length> 0){
                    $('button.delete').remove();
                }
            }

            // if (status === 1 || status === 2) {
            //     createActionButton('Pay', 'payed btn-warning', 'payed', invoice.id);
            // }else{
                // if($('button.payed').length> 0){
                    $('button.payed').remove();
                // }
            // }
        }

        function createActionButton(text, classes, action, invoiceId) {
            if ($(`.${action}`).length === 0) {
                var button = document.createElement('button');
                button.className = `${classes} btn-custom frm_${action}_btn btn`;
                button.setAttribute('data-value', invoiceId);
                button.textContent = text;

                var updateButton = document.querySelector('.frm_submit_btn');
                updateButton.parentNode.insertBefore(button, updateButton.nextSibling);
            }
        }

        function make_invoice_table() {
            $('.se-pre-con').fadeIn();
            var formData = new FormData($('#AllInvoice_filter_form')[0]);

            $.ajax({
                url: "{{ route('get_all_invoice_data') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    updateTable(response.factoryinvoices);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function getOrderInfoUrl(orderId, type = 'order') {
            const baseRoute = @json(route('orders.info', ['id' => '__ORDER_ID__', 'type' => '__TYPE__']));
            return baseRoute.replace('__ORDER_ID__', orderId).replace('__TYPE__', type);
        }

        function updateTable(invoices) {
            var table = $('#all_invoice').DataTable();
            table.clear(); // Clear current table

            invoices.forEach(function(invoice) {
                let statusBadge = '';
                if (invoice.status == 0 || invoice.status == 2) {
                    statusBadge = `<span class="badge badge-pill" style="color:#073180;background-color:#b2d0f8;width:100%">Generated Invoice</span>`;
                } else if (invoice.status == 1) {
                    statusBadge = `<span class="badge badge-pill" style="color:#c8d647;background-color:#fffecc;width:100%">Payable Invoice</span>`;
                } else if (invoice.status == 4) {
                    statusBadge = `<span class="badge badge-pill" style="color:#d65a47;background-color:#ffcccc;width:100%">Rejected</span>`;
                } else {
                    statusBadge = `<span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:100%">Paid Invoice</span>`;
                }

                table.row.add([
                    `<a href="#" class="edit" data-value="${invoice.id}">${invoice.invoice_number}</a>`,
                    `<a href="${getOrderInfoUrl(invoice.order_id)}?active_tab=order" target="_blank">${String(invoice.order_id).padStart(6, '0')}</a>`,
                    invoice.order_details?.organization_details?.organization_name ?? '',
                    `<div class="text-center">${statusBadge}</div>`,
                    `<div class="text-right">${invoice.total_amount}</div>`,
                    `<div class="text-right">${invoice.paid_amount}</div>`,
                    invoice.created_at ? moment(invoice.created_at).format('MM/DD/YYYY') : '',
                    invoice.updated_at ? moment(invoice.updated_at).format('MM/DD/YYYY') : ''
                ]);
            });

            table.draw(); // Redraw table
            $('.se-pre-con').fadeOut();
        }

        $(document).on('change', '.checkbox_of_all_invoice', function() {
            $('.checkbox_of_invoice').prop('checked', $(this).prop('checked'));
            toggleDownloadSection();
        });

        $(document).on('change', '.checkbox_of_invoice', function() {
            if ($('.checkbox_of_invoice:checked').length === $('.checkbox_of_invoice').length) {
                $('.checkbox_of_all_invoice').prop('checked', true);
            } else {
                $('.checkbox_of_all_invoice').prop('checked', false);
            }
            toggleDownloadSection();
        });
        function toggleDownloadSection() {
            let checkedCount = $('.checkbox_of_invoice:checked').length;
            if (checkedCount > 0) {
                $('.sec-download-multiple-invoices').show();
            } else {
                $('.sec-download-multiple-invoices').hide();
            }
        }
        $(document).on('click', '.download_multiple_invoices', function(e) {
            e.preventDefault();

            let selectedInvoices = [];
            $('.checkbox_of_invoice:checked').each(function() {
                selectedInvoices.push($(this).data('value'));
            });

            if (selectedInvoices.length === 0) {
                Swal.fire({
                    icon: "warning",
                    title: "No invoices selected",
                    text: "Please select at least one invoice to download."
                });
                return;
            }

            // Construct URL with invoice IDs and CSRF token
            const params = new URLSearchParams();
            params.append('_token', "{{ csrf_token() }}");
            selectedInvoices.forEach(id => params.append('invoice_ids[]', id));

            const url = "{{ route('download_multiple_invoices') }}" + '?' + params.toString();

            // Open download in a new tab
            window.open(url, '_blank');
        });

        /* ---------------- MOBILE-ONLY HELPERS ----------------*/
        try {
            var aiMobileQuery = window.matchMedia('(max-width: 767px)');
            var isAiMobile = function () { return aiMobileQuery.matches; };

            var aiSortMap = { invoice: [[1, 'asc']], newest: [[7, 'desc']], oldest: [[7, 'asc']], total: [[5, 'desc']] };
            if (isAiMobile()) {
                $('#ai-m-toolbar').insertAfter($('#all_invoice_wrapper .dataTables_filter'));
                $('#all_invoice_filter input').attr('placeholder', 'Search by invoice number');
                $('#start_date').attr('placeholder', 'Start Date');
                $('#end_date').attr('placeholder', 'End Date');
                generated_invoice.order(aiSortMap.invoice).page.len(20).draw();
            }
            (function () {
                var len = String(generated_invoice.page.len());
                if (!$('#ai-m-entries option[value="' + len + '"]').length) {
                    $('#ai-m-entries').append($('<option>', { value: len, text: len }));
                }
                $('#ai-m-entries').val(len);
            })();
            $('#ai-m-entries').on('change', function () {
                generated_invoice.page.len(parseInt(this.value, 10)).draw();
            });
            $('#ai-m-sort').on('change', function () {
                generated_invoice.order(aiSortMap[this.value] || aiSortMap.invoice).draw();
            });

            // Clear Filters (mobile): reset the fields, then load the page again (unfiltered list)
            $('#ai-m-clear-filters').on('click', function () {
                $('#AllInvoice_filter_form select').each(function () {
                    $(this).val($(this).find('option:first').val()).trigger('change');
                });
                $('#start_date, #end_date').val('');
                window.location.reload();
            });

            // Select All (mobile) -> the existing header "select all" checkbox + its handler
            $('#ai-m-select-all').on('change', function () {
                $('.checkbox_of_all_invoice').prop('checked', this.checked).trigger('change');
            });

            // Card highlight, "N Selected" and the Select All state
            var updateAiSelectionUi = function () {
                var $boxes = $('#all_invoice .checkbox_of_invoice');
                $boxes.each(function () {
                    $(this).closest('tr').toggleClass('ai-selected', this.checked);
                });
                $('#ai-m-selected-count').text($('.checkbox_of_invoice:checked').length);
                $('#ai-m-select-all').prop('checked', $boxes.length > 0 && $boxes.filter(':checked').length === $boxes.length);
            };
            $(document).on('change', '.checkbox_of_invoice, .checkbox_of_all_invoice', updateAiSelectionUi);
            generated_invoice.on('draw', updateAiSelectionUi);
            updateAiSelectionUi();

            // Tapping a card (not its links / checkbox) selects it
            $('#all_invoice tbody').on('click', 'tr', function (e) {
                if (!isAiMobile()) return;
                if ($(e.target).closest('a, input, label, .dataTables_empty').length) return;
                var $box = $(this).find('.checkbox_of_invoice');
                if ($box.length) {
                    $box.prop('checked', !$box.prop('checked')).trigger('change');
                }
            });

            // Place the page header 16px below the layout's fixed mobile bar(s).
            var fixAiHeaderOffset = function () {
                var top = document.querySelector('.ai-m-header');
                var nav = document.getElementById('sidenav-main');
                if (!top) return;
                top.style.marginTop = '';
                if (!isAiMobile() || !nav || getComputedStyle(nav).position !== 'fixed') return;
                var barBottom = nav.getBoundingClientRect().bottom;
                $('.main-content nav, .main-content .navbar').each(function () {
                    var cs = getComputedStyle(this), r = this.getBoundingClientRect();
                    if (cs.position === 'fixed' && cs.display !== 'none' && cs.visibility !== 'hidden' && r.height > 0 && r.top <= 5) {
                        barBottom = Math.max(barBottom, r.bottom);
                    }
                });
                for (var i = 0; i < 5; i++) {     // margins can collapse: adjust, re-measure, correct
                    var diff = Math.round(barBottom + 16 - (top.getBoundingClientRect().top + window.pageYOffset));
                    if (Math.abs(diff) <= 1) break;
                    top.style.marginTop = (parseFloat(getComputedStyle(top).marginTop) + diff) + 'px';
                }
            };
            fixAiHeaderOffset();
            setTimeout(fixAiHeaderOffset, 350);
            setTimeout(fixAiHeaderOffset, 1300);
            $(window).on('load', fixAiHeaderOffset);
            var aiResizeTimer;
            $(window).on('resize', function () {
                clearTimeout(aiResizeTimer);
                aiResizeTimer = setTimeout(fixAiHeaderOffset, 150);
            });
        } catch (aiErr) {
            if (window.console) console.error('All invoice mobile view:', aiErr);
        }
        /* -------------------------------------------------------------------- */
    });
</script>

@endsection