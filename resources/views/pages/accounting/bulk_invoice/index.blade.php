@extends('layouts.app', ['activePage' => 'generate-invoice', 'titlePage' => __('Generate Invoice')])

@section('content')
<style>
    .form-field {
        display: flex;
        margin-bottom: 1rem;
        flex-direction: row;
        flex-wrap: nowrap;
        align-items: center;
    }
    .form-lable {
        width: 33%;
    }
    .form-input {
        width: 100%;
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
    div.alphabet {
        display: table;
        width: 100%;
        margin-bottom: 1em;
    }
    div.alphabet span {
        display: table-cell;
        color: #b3b3b3;
        cursor: pointer;
        text-align: center;
        width: 3.5%;
        border: 1px solid #e8e8e8;
    }
    div.alphabet span:hover {
        box-shadow: 2px 2px 5px #e8e8e8;
    }
    div.alphabet span.active {
        color: black;
    }
    .add-btn-position {
        width: 84px;
        position: relative;
        right: -29px;
    }
    .btn-text-position {
        position: relative;
        right: -6%;
        font-size: 15px;
    }
    .content-position {
        position: relative;
        top: -25px;
    }
    .add-btn-text {
        position: relative;
        right: -13px;
    }
    .btns-text {
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
    }
    .btns-text:hover {
        color: #909090 ;
    }
    .btns-style {
        width: 100%;
        height: 100%;
        background-color: #909090;
        border: unset;
        border-radius: 5px;
    }
    .btns-card:hover {
        background-color: #ffffff
    }
    .btns-padding {
        padding-left: 0.2rem;
        padding-right: 0.2rem;
    }
    .btns-right-position {
        position: relative;
        right: 14px;
    }
    .btn-top {
        position: relative;
        top: 11px;
    }
    @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {
   .btn_set{
    max-width: none;
    flex:none;
    right:0px;

   }
   .div_display{
    display:none;
   }
   .div_align{
    justify-content: center;
   }
   .search_orga{
    width:200% !important;
   }
   .pagina001{
        flex-wrap: wrap;
     }
  }@media only screen and (min-device-width : 834px) and (max-device-width : 1024px) and (orientation : portrait) {

    }
    .card{
        background-color: white;
        border: none;
        border-radius: 0rem;
    }
    .new-style-table table.dataTable thead .sorting:before,table.dataTable thead .sorting_asc:before,table.dataTable thead .sorting_desc:before,table.dataTable thead .sorting_asc_disabled:before,table.dataTable thead .sorting_desc_disabled:before {
        content: "\f0de";
        font-family: FontAwesome;
    }
    .new-style-table table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:after,table.dataTable thead .sorting_asc_disabled:after,table.dataTable thead .sorting_desc_disabled:after {
        content: "\f0dd";
        font-family: FontAwesome;
        right: .65rem !important;
    }
    .new-style-table table thead tr{
        background-color: grey;
        color: white;
        height: 40px;
        font-size: .7rem;
    }
    .new-style-table table tr{
        background-color: white;
        color: grey;
        min-height: 40px;
        font-size: .7rem;
        border-bottom: 1px solid #b3b3b3;
    }
    .new-style-table th, .new-style-table td {
        padding: 10px;
    }
    .new-style-table table tbody tr:hover{
        background-color: #f6f6ff;
    }
    .table-responsive .table tbody td , .table-responsive .table tbody td a {
        padding: 0.4rem 1rem !important;
        font-size: .9rem !important;
        color: rgba(22, 22, 23, 1) !important;
    }
    .new-style-table table thead tr {
        background-color: rgba(50, 50, 50, 1) !important;
        height: 40px;
    }
    .btn-inside-table button{
        width: 100% !important;
        padding: 5% 3% !important;
        font-size: .7rem !important;
        height: 2.1rem;
        font-size: .7rem !important;
    }
    body {
        font-family: 'Open Sans', 'sans-serif' !important;
    }
    .hide {
        display: none;
    }
    .custom-control-label::before{
        position: relative;
        left: 0.25rem;
    }
    #payMultipleModal .table td {
        padding: .2rem 1.5rem;
    }
    .hard-top-border{
        border-top: double #e9ecef !important;
    }
    .no-top-border{
        border-top: none !important;
    }
    #bulkInvoiceModal .table th, .table td {
        padding: .2rem;
        vertical-align: top;
        border-top: none;
    }
    .modal-2xl {
        max-width: 90%;
        width: auto;
    }

    /* =====================================================================
       BULK INVOICE — MOBILE LAYOUT
       ===================================================================== */
    .mobile-page-header { display: none; }
    .pm-m-field-label { display: none; }

    @media (min-width: 768px) {
        .mobile-page-header { display: none !important; }
        div#mobile-entries-sort-row { display: none; }
    }

    @media (max-width: 767px) {

        /* ---------- Page shell ---------- */
        .content-position {
            top: 0;                                  /* desktop: top -25px */
            padding-left: 16px !important;
            padding-right: 16px !important;
            background-color: transparent;
        }
        /* Layout's generic title strip / desktop top bar: replaced by the page header */
        .main-content #header,
        .main-content .header1,
        .main-content > .navbar-top,
        .main-content > #navbar-main { display: none !important; }

        .content-position > .col-md-12.new-style-table { padding-left: 0; padding-right: 0; }
        /* One shared outer card: drop its box so the inner cards sit on the grey page */
        .col-md-12.new-style-table > .card {
            background: transparent;
            box-shadow: none;
            padding: 0;
            border-radius: 0;
        }
        .col-md-12.new-style-table > .card > .col-md-12 {
            margin: 0 !important;
            padding-left: 0;
            padding-right: 0;
        }
        .col-md-12.new-style-table .table-responsive { overflow: visible; }

        /* ---------- Page header: "< BACK TO HOME", title + Export ---------- */
        .mobile-page-header {
            display: block;
            margin: 4px 0 18px;
        }
        .mobile-back-link {
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
        .mobile-back-link i { font-size: 11px; }
        .mobile-page-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .mobile-page-title {
            margin: 0;
            min-width: 0;
            font-size: 20px;
            font-weight: 700;
            line-height: 1.25;
            color: #111827;
        }
        .mobile-export-btn {
            display: inline-flex;
            flex: 0 0 auto;
            align-items: center;
            gap: 8px;
            height: 42px;
            padding: 0 16px;
            border: none;
            border-radius: 8px;
            background: #47D6B6;
            color: #fff;
            font-size: 15px;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(71, 214, 182, 0.35);
        }
        /* Outline download icon (design) instead of the solid glyph */
        .export-icon-mobile { display: inline-flex; width: 17px; height: 17px; }
        .export-icon-desktop { display: none; }

        /* ---------- DataTables wrapper ---------- */
        #bulk_invoice_wrapper > .row { margin-left: 0; margin-right: 0; }
        #bulk_invoice_wrapper > .row > [class*="col-"] { padding-left: 0; padding-right: 0; }
        /* The page's own "Show / Sort by" row replaces DataTables' length menu */
        #bulk_invoice_wrapper .dataTables_length { display: none !important; }
        /* scrollX: hide the cloned header, let the body flow as cards */
        #bulk_invoice_wrapper .dataTables_scrollHead { display: none !important; }
        #bulk_invoice_wrapper .dataTables_scroll,
        #bulk_invoice_wrapper .dataTables_scrollBody {
            overflow: visible !important;
            width: 100% !important;
            height: auto !important;
            border: none !important;
        }

        /* ---------- Search card ---------- */
        #bulk_invoice_wrapper .dataTables_filter {
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
        #bulk_invoice_wrapper .dataTables_filter label {
            position: relative;
            display: block;
            width: 100%;
            margin: 0;
            font-size: 0;                            /* only the icon + input are shown */
        }
        #bulk_invoice_wrapper .dataTables_filter label i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: #111827;
            pointer-events: none;
        }
        #bulk_invoice_wrapper .dataTables_filter input {
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
        #bulk_invoice_wrapper .dataTables_filter input::placeholder { color: #9ca3af; }

        /* ---------- "Show [20] entries" / "Sort by [...]" ---------- */
        #mobile-entries-sort-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin: 0 0 4px;
            padding: 0;
        }
        #mobile-entries-sort-row .mobile-entries-group,
        #mobile-entries-sort-row .mobile-sort-group {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 0;
            white-space: nowrap;
        }
        #mobile-entries-sort-row .date_p {
            font-size: 14px;
            color: #6b7280;
        }
        #mobile-entries-sort-row .mobile-entries-group { flex: 0 0 auto; }
        #entries-select-m { flex: 0 0 auto; }
        #mobile-entries-sort-row select {
            min-width: 0;
            height: 34px;
            padding: 0 28px 0 10px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12'%3E%3Cpath d='M2.5 4.5 6 8l3.5-3.5' fill='none' stroke='%23374151' stroke-width='1.6' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") no-repeat right 9px center / 11px 11px;
            color: #111827;
            font-size: 14px;
            font-weight: 500;
            text-overflow: ellipsis;
            -webkit-appearance: none;
            appearance: none;
        }

        /* ---------- Table -> invoice cards ---------- */
        #bulk_invoice {
            display: block;
            width: 100% !important;
            margin: 10px 0 0 !important;
            border: none;
        }
        #bulk_invoice > thead { display: none; }
        #bulk_invoice > tbody { display: block; width: 100%; }

        #bulk_invoice > tbody > tr {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            column-gap: 10px;
            min-height: 0;
            margin-bottom: 14px;
            padding: 16px 16px 14px;
            background: #fff !important;
            border: 1px solid #f0f1f3 !important;
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(17, 24, 39, 0.06);
        }
        #bulk_invoice > tbody > tr:hover { background: #fff !important; }
        #bulk_invoice > tbody > tr > td {
            display: block;
            box-sizing: border-box;                  /* DataTables sets content-box */
            min-width: 0;
            padding: 0 !important;
            border: none !important;
            text-align: left !important;
            font-size: 13px !important;              /* page rule: .9rem !important */
            color: #111827 !important;
            overflow-wrap: anywhere;
        }
        #bulk_invoice > tbody > tr > td a { padding: 0 !important; }       /* page rule: .4rem 1rem !important */

        /* Line 1: invoice number + status pill */
        #bulk_invoice > tbody > tr > td:nth-child(1) { order: 1; flex: 1 1 auto; }
        #bulk_invoice > tbody > tr > td:nth-child(1),
        #bulk_invoice > tbody > tr > td:nth-child(1) a {
            font-size: 17px !important;
            font-weight: 700;
            line-height: 1.3;
            color: #111827 !important;
            text-decoration: none;
        }
        #bulk_invoice > tbody > tr > td:nth-child(6) { order: 2; flex: 0 0 auto; }
        #bulk_invoice > tbody > tr > td:nth-child(6) .badge {
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
        /* Design colours (badge colours are set inline) */
        #bulk_invoice > tbody > tr > td:nth-child(6) .badge[style*="#fef3c7" i] { color: #f0a800 !important; background-color: #fff3c4 !important; }
        #bulk_invoice > tbody > tr > td:nth-child(6) .badge[style*="#d7ffcc" i] { color: #3a9d23 !important; background-color: #e5f6dc !important; }
        #bulk_invoice > tbody > tr > td:nth-child(6) .badge[style*="#dbeafe" i] { color: #1d4ed8 !important; background-color: #dbeafe !important; }

        /* Line 2: organization */
        #bulk_invoice > tbody > tr > td:nth-child(2) {
            order: 3;
            flex: 0 0 100%;
            margin-top: 2px;
            font-size: 15px !important;
        }

        /* Line 3: Total / Paid / Balance boxes */
        #bulk_invoice > tbody > tr > td:nth-child(3) { order: 4; }
        #bulk_invoice > tbody > tr > td:nth-child(4) { order: 5; }
        #bulk_invoice > tbody > tr > td:nth-child(5) { order: 6; }
        #bulk_invoice > tbody > tr > td:nth-child(3),
        #bulk_invoice > tbody > tr > td:nth-child(4),
        #bulk_invoice > tbody > tr > td:nth-child(5) {
            flex: 0 0 calc((100% - 20px) / 3 - 0.5px);
            align-self: stretch;
            margin-top: 12px;
            padding: 7px 8px 8px !important;
            background: #f3f4f6;
            border-radius: 8px;
            font-size: clamp(12px, 3.45vw, 16px) !important;
            font-weight: 500;
            line-height: 1.35;
        }
        #bulk_invoice > tbody > tr > td:nth-child(4) { color: #3a9d23 !important; }
        #bulk_invoice > tbody > tr > td:nth-child(5) { color: #e01e1e !important; }
        #bulk_invoice > tbody > tr > td:nth-child(3)::before,
        #bulk_invoice > tbody > tr > td:nth-child(4)::before,
        #bulk_invoice > tbody > tr > td:nth-child(5)::before {
            display: block;
            margin-bottom: 1px;
            font-size: clamp(11px, 3.4vw, 15px);
            font-weight: 400;
            color: #8a8f98;
        }
        #bulk_invoice > tbody > tr > td:nth-child(3)::before { content: "Total"; }
        #bulk_invoice > tbody > tr > td:nth-child(4)::before { content: "Paid"; }
        #bulk_invoice > tbody > tr > td:nth-child(5)::before { content: "Balance"; }
        /* Amounts are plain numbers ("37,927.92"): add the $ on the card */
        #bulk_invoice > tbody > tr > td .cell-amount::before { content: "$"; }

        /* Dashed divider, then "Created Date 06/30/2026" */
        #bulk_invoice > tbody > tr::after {
            content: "";
            order: 7;
            flex: 0 0 100%;
            height: 0;
            margin-top: 14px;
            border-top: 1px dashed #e5e7eb;
        }
        #bulk_invoice > tbody > tr > td:nth-child(7) {
            order: 8;
            flex: 1 1 auto;
            margin-top: 10px;
            font-size: 13px !important;
            font-weight: 600;
        }
        #bulk_invoice > tbody > tr > td:nth-child(7)::before {
            content: "Created Date";
            margin-right: 6px;
            font-weight: 400;
            color: #8a8f98;
        }

        /* "No data available" row */
        #bulk_invoice > tbody > tr > td.dataTables_empty {
            display: block;
            flex: 1 1 100%;
            padding: 6px 0 !important;
            font-size: 14px !important;
            font-weight: 400;
            text-align: center !important;
            color: #6b7280 !important;
        }
        #bulk_invoice > tbody > tr:has(> td.dataTables_empty)::after { display: none; }

        /* ---------- Pager: "Showing x to y of z entries" + buttons ---------- */
        #bulk_invoice_wrapper > .row:last-child {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-top: 6px;
        }
        #bulk_invoice_wrapper > .row:last-child > [class*="col-"] {
            flex: 0 1 auto;
            width: auto;
            max-width: none;
        }
        #bulk_invoice_wrapper .dataTables_info {
            padding: 0 !important;
            font-size: 13px;
            color: #9ca3af;
            white-space: normal;
        }
        #bulk_invoice_wrapper .dataTables_paginate { margin: 0 !important; }
        #bulk_invoice_wrapper .pagination {
            flex-wrap: wrap;
            justify-content: flex-end !important;
            gap: 6px;
            margin: 0 !important;
        }
        #bulk_invoice_wrapper .page-item .page-link {
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
        #bulk_invoice_wrapper .page-item.active .page-link {
            background: #111827;
            border-color: #111827;
            color: #fff;
        }
        #bulk_invoice_wrapper .page-item.disabled .page-link { color: #9ca3af; }
        /* "Previous" / "Next" -> ‹ › */
        #bulk_invoice_wrapper .page-item.previous .page-link,
        #bulk_invoice_wrapper .page-item.next .page-link { font-size: 0; }
        #bulk_invoice_wrapper .page-item.previous .page-link::before,
        #bulk_invoice_wrapper .page-item.next .page-link::before {
            font-size: 20px;
            line-height: 1;
        }
        #bulk_invoice_wrapper .page-item.previous .page-link::before { content: "\2039"; }
        #bulk_invoice_wrapper .page-item.next .page-link::before     { content: "\203A"; }

        /* =================================================================
           Popups (shared look)
           ================================================================= */
        #bulkInvoiceModal .modal-dialog,
        #paymentReceivedModal .modal-dialog {
            display: flex;
            align-items: center;
            width: auto;
            max-width: none;
            min-height: calc(100% - 32px);
            margin: 16px;
        }
        #bulkInvoiceModal .modal-content,
        #paymentReceivedModal .modal-content {
            width: 100%;
            border: none;
            border-radius: 16px;
            overflow: hidden;
        }
        #bulkInvoiceModal .modal-header,
        #paymentReceivedModal .modal-header {
            align-items: center;
            margin: 0 18px;
            padding: 18px 0 14px;
            border-bottom: 1px solid #e5e7eb;
        }
        #bulkInvoiceModal .modal-title,
        #paymentReceivedModal .modal-title {
            font-size: 19px;
            font-weight: 700;
            color: #111827;
        }
        #bulkInvoiceModal .modal-header .close,
        #paymentReceivedModal .modal-header .close { margin: 0; padding: 0 2px; opacity: 1; }
        #bulkInvoiceModal .modal-header .close span,
        #paymentReceivedModal .modal-header .close span { font-size: 26px; font-weight: 300; color: #111827; }
        #bulkInvoiceModal .modal-footer,
        #paymentReceivedModal .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            padding: 12px 18px 18px;
            border-top: none;
        }
        #bulkInvoiceModal .modal-footer .btn,
        #paymentReceivedModal .modal-footer .btn {
            flex: 0 0 auto;
            min-width: 96px;
            height: 44px;
            margin: 0 !important;
            padding: 0 18px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            text-transform: none;
            letter-spacing: 0;
            box-shadow: 0 4px 12px rgba(17, 24, 39, 0.08);
        }
        #bulkInvoiceModal .modal-footer .btn-secondary,
        #paymentReceivedModal .modal-footer .btn-secondary {
            background: #b3b3b3;
            color: #fff;
        }
        #bulkInvoiceModal .modal-footer .btn-primary,
        #paymentReceivedModal .modal-footer .btn-primary {
            background: #47D6B6;
            color: #fff;
        }
        /* Design wording: "Cancel" / "Mark as Paid" (same buttons, mobile labels) */
        #bulkInvoiceModal .modal-footer .btn-secondary,
        #bulkInvoiceModal .modal-footer #bulkMarkAspaid { font-size: 0; }
        #bulkInvoiceModal .modal-footer .btn-secondary::after { content: "Cancel"; font-size: 16px; }
        #bulkInvoiceModal .modal-footer #bulkMarkAspaid::after { content: "Mark as Paid"; font-size: 16px; }

        /* ---------- Bulk Invoice Details ---------- */
        /* !important: a shared layout rule was overriding the side padding, so the
           content touched the popup edges. Same 18px inset as the title row. */
        #bulkInvoiceModal .modal-body {
            max-height: calc(100vh - 190px);
            overflow-y: auto;
            padding: 14px 18px 10px !important;
        }
        .bm-brand {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 2px 0 14px;
            border-bottom: 1px solid #e5e7eb;
        }
        /* logo1.png has wide empty margins around the diamond: show it in a
           crop box so the diamond itself is ~70px, like the design */
        .bm-brand-logo-wrap {
            flex: 0 0 auto;
            width: 84px;
            height: 84px;
            overflow: hidden;
        }
        .bm-brand-logo {
            display: block;
            width: 150%;
            max-width: none;
            height: auto;
            margin: -25% 0 0 -25%;
        }
        .bm-brand-address { text-align: right; }
        .bm-brand-title {
            margin: 0 0 6px;
            font-size: 26px;
            font-weight: 500;
            line-height: 1.2;
            color: #d0021b;
        }
        .bm-brand-address span {
            display: block;
            font-size: 13.5px;
            line-height: 1.6;
            color: #111827;
        }
        .bm-meta {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 10px 0 12px;
            margin-bottom: 14px;
            border-bottom: 1px solid #e5e7eb;
        }
        .bm-meta > div:last-child { text-align: right; }
        .bm-meta-label { display: block; font-size: 12px; color: #8a8f98; }
        .bm-meta-value { display: block; font-size: 14px; color: #111827; }

        .bm-section {
            margin-bottom: 12px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(17, 24, 39, 0.05);
            overflow: hidden;
        }
        .bm-section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 13px 14px;
            background: #fff;
            cursor: pointer;
        }
        .bm-section-title { font-size: 15px; font-weight: 600; color: #111827; }
        .bm-section-header i { font-size: 13px; color: #111827; }
        .bm-section-body {
            display: none;
            padding: 2px 14px 12px;
        }
        .bm-org-line { font-size: 13px; line-height: 1.5; color: #374151; }

        .bm-order-card {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #eef0f2;
            border-radius: 10px;
        }
        .bm-order-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 2px;
        }
        .bm-order-no { font-size: 14px; font-weight: 700; color: #111827; }
        .bm-order-top .badge { text-transform: none; font-weight: 500; }
        .bm-order-name { margin-bottom: 8px; font-size: 12px; color: #6b7280; }
        .bm-order-amounts { display: flex; gap: 6px; }
        .bm-order-amounts > div {
            flex: 1 1 0;
            min-width: 0;
            padding: 5px 7px;
            background: #f3f4f6;
            border-radius: 6px;
        }
        .bm-order-amounts .bm-amt-label { display: block; font-size: 11px; color: #8a8f98; }
        .bm-order-amounts .bm-amt-value { display: block; font-size: 12.5px; font-weight: 500; color: #111827; overflow-wrap: anywhere; }

        /* Totals: shown at the end of the Order List */
        .bm-summary-card {
            margin-top: 4px;
            padding: 8px 0 0;
            border-top: 1px dashed #e5e7eb;
        }
        .bm-summary-row {
            display: flex;
            justify-content: space-between;
            padding: 3px 0;
            font-size: 13px;
            color: #6b7280;
        }
        .bm-summary-row span:last-child { color: #111827; }
        .bm-summary-row.bm-total { font-weight: 700; }
        .bm-summary-row.bm-total span { color: #111827; }

        .bm-footer { padding: 8px 0 4px; text-align: center; }
        .bm-footer-thanks { margin: 0 0 10px; font-size: 16px; font-weight: 700; color: #111827; }
        .bm-footer-logo { width: 100%; max-width: 190px; height: auto; }

        /* ---------- Payment Received ---------- */
        #paymentReceivedModal .modal-body { padding: 14px 18px 4px !important; }
        #paymentReceivedModal .form-group { margin-bottom: 14px; }
        .pm-m-field-label,
        #paymentReceivedModal label[for="description"] {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: 400;
            color: #111827;
        }
        .pm-label-desktop-text { display: none; }
        .pm-upload-label {
            display: block;
            margin: 0;
            padding: 18px 12px;
            background: #f5f6f7;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
        }
        .pm-upload-mobile {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }
        .pm-upload-icon { font-size: 22px; color: #8a8f98; }
        .pm-upload-icon::before { content: "\f574"; }   /* file-arrow-up, as in the design */
        .pm-upload-text { font-size: 14px; font-weight: 400; color: #8a8f98; }
        .pm-upload-text u { color: #111827; }
        .pm-upload-sub { display: none; }
        #payment_image {
            position: absolute;
            width: 1px;
            height: 1px;
            opacity: 0;
            overflow: hidden;
            z-index: -1;
        }
        #paymentReceivedModal textarea.form-control {
            min-height: 96px;
            background: #f5f6f7;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: none;
            font-size: 15px;
        }
        #paymentReceivedModal #imagePreview { border-radius: 8px; }
    }

    /* Very small phones (320px - 359px) */
    @media (max-width: 359px) {
        .content-position {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }
        .mobile-page-title { font-size: 18px; }
        .mobile-export-btn { height: 38px; padding: 0 12px; font-size: 14px; }
        #mobile-entries-sort-row .date_p { font-size: 12px; }
        #mobile-entries-sort-row select { font-size: 12px; padding: 0 22px 0 8px; background-position: right 7px center; }
        #bulk_invoice > tbody > tr { padding: 14px 12px 12px; column-gap: 8px; }
        #bulk_invoice > tbody > tr > td:nth-child(3),
        #bulk_invoice > tbody > tr > td:nth-child(4),
        #bulk_invoice > tbody > tr > td:nth-child(5) {
            flex-basis: calc((100% - 16px) / 3 - 0.5px);
            padding: 6px 6px 7px !important;
        }
        #bulkInvoiceModal .modal-dialog,
        #paymentReceivedModal .modal-dialog { margin: 10px; min-height: calc(100% - 20px); }
        #bulkInvoiceModal .modal-header,
        #paymentReceivedModal .modal-header { margin: 0 14px; }
        #bulkInvoiceModal .modal-body,
        #paymentReceivedModal .modal-body { padding-left: 14px !important; padding-right: 14px !important; }
        .bm-brand-logo-wrap { width: 70px; height: 70px; }
        .bm-brand-title { font-size: 21px; }
        .bm-brand-address span { font-size: 12px; }
    }
</style>


<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con" style="display: none;"></div>

    @section('order-header')
        <span>BULK INVOICE</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="mobile-page-header">
        {{-- <a href="{{ route('home') }}" class="mobile-back-link"><i class="fa fa-chevron-left"></i> BACK TO HOME</a> --}}
        <div class="mobile-page-header-row">
            <h5 class="mobile-page-title">Bulk Invoice</h5>
            <button type="button" class="mobile-export-btn" onclick="exportBulkInvoiceReport()">
                <i class="fa fa-download export-icon-desktop"></i>
                <svg class="export-icon-mobile" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                Export
            </button>
        </div>
    </div>

    <div class="col-md-12 new-style-table">
        <div class="card">
                <div class="col-md-12 mt-2">
                    <input type="hidden" id="pay_multiple_invoices" value="" />
                </div>
                <div class="col-md-12 mt-3 mb-3">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="bulk_invoice">
                            <thead>
                                <th scope="col" class="invoice-number text-center text-center">Bulk Invoice Number</th>
                                <th scope="col" class="order-organization text-center">Organization</th>
                                <th scope="col" class="total-amount text-center">Total amount</th>
                                <th scope="col" class="paid-amount text-center">Paid amount</th>
                                <th scope="col" class="amount-to-paid text-center">Amount to paid</th>
                                <th scope="col" class="status text-center">Status</th>
                                <th scope="col" class="created-at text-center">Created At</th>
                            </thead>

                            <tbody>
                                @foreach ($bulk_invoices as $bulk_invoice)
                                    <tr>
                                        <td class="text-center">
                                            <a class="edit-bulk-inv" href="" data-inv-id="{{$bulk_invoice['invoice']->id}}" style="color:black">
                                                BULK-INV-{{ str_pad($bulk_invoice['invoice']->id, 6, '0', STR_PAD_LEFT) }}
                                            </a>
                                        </td>
                                        <td class="text-left">
                                            <input type="hidden" id="hidden_invoices_{{$bulk_invoice['invoice']->id}}" value="{{$bulk_invoice['invoice']->order_ids}}">
                                            {{$bulk_invoice['invoice']->organizationDetails->organization_name}}
                                        </td>

                                        @php
                                            $totalOrderAmount = 0;
                                            $totalPaidAmount = 0;

                                            foreach($bulk_invoice['order'] as $orderData) {
                                                $totalOrderAmount += $orderData['order']->order_total ?? 0;
                                                $totalPaidAmount += $orderData['paid_amount'] ?? 0;
                                            }

                                            $remainingAmount = $totalOrderAmount - $totalPaidAmount;
                                        @endphp

                                        <td class="text-right"><span class="cell-amount">{{ number_format($totalOrderAmount, 2) }}</span></td>
                                        <td class="text-right"><span class="cell-amount">{{ number_format($totalPaidAmount, 2) }}</span></td>
                                        <td class="text-right"><span class="cell-amount">{{ number_format($remainingAmount, 2) }}</span></td>
                                        <td>
                                            @if ($bulk_invoice['invoice']->payment_status == 0)
                                                <span class="badge badge-pill" style="color:#92400e;background-color:#fef3c7;width:100%">Pending</span>
                                            @elseif ($bulk_invoice['invoice']->payment_status == 1)
                                                <span class="badge badge-pill" style="color:#1a7a4c;background-color:#d7ffcc;width:100%">Paid</span>
                                            @else
                                                <span class="badge badge-pill" style="color:#1d4ed8;background-color:#dbeafe;width:100%">Partial</span>
                                            @endif
                                        </td>
                                        <td data-order="{{ $bulk_invoice['invoice']->created_at->format('Y-m-d H:i:s') }}">
                                            {{$bulk_invoice['invoice']->created_at->format('m/d/Y')}}
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
    <div class="mobile-entries-sort-row" id="mobile-entries-sort-row">
        <div class="mobile-entries-group">
            <span class="date_p">Show</span>
            <select id="entries-select-m">
                <option value="10">10</option>
                <option value="20" selected>20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span class="date_p">entries</span>
        </div>
        <div class="mobile-sort-group">
            <span class="date_p">Sort by</span>
            <select id="sort-select-m">
                <option value="invoice_number">Invoice No</option>
                <option value="created_at">Created Date</option>
            </select>
        </div>
    </div>
</div>
</div>
<!-- Modal Structure -->
<div class="modal fade" id="bulkInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="bulkInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-2xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bulkInvoiceModalLabel">Bulk Invoice Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <input type="hidden" id="bulk_invoice_id">
        <div class="modal-body" id="bulkInvoiceContent"> </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="bulkMarkAspaid">Mark as paid</button>
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
            <input type="hidden" id="pay_multiple_invoices_bulk" value="">
            <!-- Image upload section -->
            <div class="form-group">
              <span class="pm-m-field-label">Upload Payment Image</span>
              <label for="payment_image" class="pm-upload-label">
                <span class="pm-label-desktop-text">Upload Payment Image</span>
                <span class="pm-upload-mobile">
                  <i class="fas fa-cloud-upload-alt pm-upload-icon"></i>
                  <span class="pm-upload-text">Click here to upload</span>
                  <span class="pm-upload-sub">Payment screenshot or receipt</span>
                </span>
              </label>
              <input type="file" class="form-control-file" id="payment_image" name="payment_image" accept="image/*">
            </div>

            <!-- Image preview -->
            <div class="form-group">
              <img id="imagePreview" src="#" alt="Payment Image Preview" style="max-width: 100%;display:none; height: auto;" />
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

<script>
    // Used only by the mobile "Bulk Invoice Details" modal to open/close its
    // collapsible Organization Details / Order List sections.
    function toggleBulkSection(bodyId, toggleHeader) {
        var $body = $('#' + bodyId);
        var isOpening = $body.css('display') === 'none';
        $body.css('display', isOpening ? 'block' : 'none');
        $(toggleHeader).find('i')
            .toggleClass('fa-chevron-right', !isOpening)
            .toggleClass('fa-chevron-down', isOpening);
    }

    $(document).ready(function() {
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
    $(document).ready(function () {

        var generated_invoice = $('#bulk_invoice').DataTable({
            colReorder: false,
            scrollX: true,
            stateSave: true,
            "autoWidth": false,
            "pageLength": 50,
            "bSort" : false,
            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'Search by bulk invoice id'
            },
            initComplete: function () {
                // Move our pre-built row to right after the Search box — the ONLY
                if (window.innerWidth <= 767) {
                    $('#mobile-entries-sort-row')
                        .insertAfter($(this).closest('.dataTables_wrapper').find('.dataTables_filter'));
                }
            }
        });

        $('#entries-select-m').on('change', function () {
            generated_invoice.page.len(parseInt(this.value, 10)).draw();
        });

        // Mobile: show the table's real page length (default 50, or the saved state)
        (function () {
            var len = String(generated_invoice.page.len());
            var $entries = $('#entries-select-m');
            if (!$entries.find('option[value="' + len + '"]').length) {
                $entries.append($('<option>', { value: len, text: len }));
            }
            $entries.val(len);
        })();

        $('#sort-select-m').on('change', function () {
            // The table is created with bSort:false, which also blocks the
            // order() API. Turn sorting on for this table only when the mobile
            // "Sort by" is used (its header is hidden on mobile, so nothing
            // else changes). Created date sorts by its data-order value.
            generated_invoice.settings()[0].oFeatures.bSort = true;
            if (this.value === 'invoice_number') {
                generated_invoice.order([0, 'asc']).draw();
            } else if (this.value === 'created_at') {
                generated_invoice.order([6, 'desc']).draw();
            }
        });

        $('.edit-bulk-inv').on('click', function(event) {
            event.preventDefault();
            var invId = $(this).data('inv-id');
            console.log(invId);

            $.ajax({
                url: "{{ route('get_bulk_invoice_details') }}",
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    inv_id: invId,
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function(response) {

                    if(response){
                        $('#bulk_invoice_id').val(response.bulk_invoice.id);
                    }else{
                        $('#bulk_invoice_id').val('');
                        return;
                    }

                    console.log(response);

                    var bulk_invoice_id = response.bulk_invoice.id;
                    var order_ids_string = response.bulk_invoice.order_ids;
                    var organization = response.bulk_invoice.organization_details;
                    var orders_details = Object.values(response.orders);
                    const createdAt = new Date(response.bulk_invoice.created_at);

                    if(response.bulk_invoice.payment_status == 1){
                        $('#bulkMarkAspaid').hide();
                    }else{
                        $('#bulkMarkAspaid').show();
                    }

                    let modalBody = `
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <img src="{{ asset('argon') }}/img/encore/logo1.png" height="150px">
                                </div>
                                <div class="col-lg-6">
                                    <h3 class="page-title text-danger text-right">INVOICE</h3>
                                    <h5 class="text-right encore-address" style="margin-bottom: 0rem;">Encore Custom</h5>
                                    <h5 class="text-right encore-address" style="margin-bottom: 0rem;">891 4th st.</h5>
                                    <h5 class="text-right encore-address" style="margin-bottom: 0rem;">San Rafael, CA 94901</h5>
                                </div>

                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <th>Bulk Invoice No :</th>
                                            <td><h5>BULK-INV-${bulk_invoice_id.toString().padStart(6, '0')}</h5></td>
                                        </tr>
                                        <tr>
                                            <th>Date # :</th>
                                            <td><h5>${String(createdAt.getMonth() + 1).padStart(2, '0')}/${String(createdAt.getDate()).padStart(2, '0')}/${createdAt.getFullYear()}</h5></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <hr class="page-divider">

                        <input type="hidden" id="organization_name" value="${organization.organization_name}">

                        <div class="col-lg-12 mb-1">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr><th>Organization Details:</th></tr>
                                        <tr><td><h5>${organization.organization_name}</h5></td></tr>
                                        <tr><td><h5>${organization.shipping_street}</h5></td></tr>
                                        <tr><td><h5>${organization.shipping_city} ${organization.shipping_state} ${organization.shipping_postal_code}</h5></td></tr>
                                        <tr><td><h5>${organization.shipping_country}</h5></td></tr>
                                        <tr><td><h5>${organization.website}</h5></td></tr>
                                        <tr><td><h5>${organization.email}</h5></td></tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-md-12">
                                    <table class="table" id="invoice_items">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 10%;">ORDER NO</th>
                                                <th class="text-center">CONTACT PERSON</th>
                                                <th class="text-center">EST DELIVERY</th>
                                                <th class="text-center">SUB TOTAL($)</th>
                                                <th class="text-center">PAID AMOUNT($)</th>
                                                <th class="text-center">AMOUNT TO PAY($)</th>
                                                <th class="text-center">PAYMENT STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody>`;
                    var orders_sub_total = 0;
                    var orders_paid_amount = 0;

                    orders_details.forEach(order => {
                        var payment_status = '';
                        if(Number(order.order.order_total) > Number(order.paid_amount)){
                            if(Number(order.paid_amount) > 0){
                                payment_status = `<span class="badge badge-pill" style="color:black;background-color:#bce05e;width: fit-content;">Partial</span>`;
                            }else{
                                payment_status = `<span class="badge badge-pill" style="color:black;background-color:#d1c8d6;width: fit-content;">Pending</span>`;
                            }

                        }else if(Number(order.order.order_total) == Number(order.paid_amount)){
                                payment_status = `<span class="badge badge-pill" style="color:black;background-color:#4be5c4;width: fit-content;">Paid</span>`;
                        }

                        modalBody += `
                            <tr>
                                <td><h5 class="text-center"><a style="color:black !important" href="#" class="edit-order" data-value="${order.order.id}">${order.order.order_no}</a></h5></td>
                                <td><h5 class="text-center">${order.order.contact_details.first_name} ${order.order.contact_details.last_name}</h5></td>
                                <td><h5 class="text-center">${order.order.est_delivery_date ?? ''}</h5></td>
                                <td><h5 class="text-right">${Number(order.order.order_total).toFixed(2)}</h5></td>
                                <td><h5 class="text-right">${Number(order.paid_amount).toFixed(2)}</h5></td>
                                <td><h5 class="text-right">${(order.order.order_total - order.paid_amount).toFixed(2)}</h5></td>
                                <td class="text-center">${payment_status}</td>
                            </tr>`;

                            orders_sub_total += Number(order.order.order_total);
                            orders_paid_amount += Number(order.paid_amount);
                    });

                    modalBody += `
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>`;
                    modalBody += `
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h1 class="main-htag mt-4">Thank you for your business!</h1>
                                        </div>
                                        <div class="col-md-12 mt-4 text-center">
                                            <img src="{{ asset('argon') }}/img/encore/logo_dark.png" class="navbar-brand-img imagesize" id="logo_large" alt="..." width="350px">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <table class="table" id="invoice_summary">
                                        <tr>
                                            <th class="text-left">SUBTOTAL ($) :</th>
                                            <td><h5 class="text-right">${Number(orders_sub_total).toFixed(2)}</h5></td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">PAID AMOUNT ($) :</th>
                                            <td><h5 class="text-right">${Number(orders_paid_amount).toFixed(2)}</h5></td>
                                        </tr>
                                        <tr>
                                            <th class="total text-left">AMOUNT TO PAY ($) :</th>
                                            <td><h5 class="text-right" style="font-weight: bold; font-size: large;">${Number((orders_sub_total - orders_paid_amount)).toFixed(2)}</h5></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>`;

                    // ---- Mobile-only rebuild of the same modal content ----
                    if (window.innerWidth <= 767) {
                        var mobileOrdersHTML = '';
                        orders_details.forEach(order => {
                            var mStatus = { bg: '#fff3c4', color: '#f0a800', label: 'Pending' };
                            if (Number(order.order.order_total) > Number(order.paid_amount)) {
                                if (Number(order.paid_amount) > 0) {
                                    mStatus = { bg: '#dbeafe', color: '#1d4ed8', label: 'Partial' };
                                }
                            } else if (Number(order.order.order_total) == Number(order.paid_amount)) {
                                mStatus = { bg: '#e5f6dc', color: '#3a9d23', label: 'Paid' };
                            }

                            mobileOrdersHTML += `
                                <div class="bm-order-card">
                                    <div class="bm-order-top">
                                        <span class="bm-order-no">#${order.order.order_no}</span>
                                        <span class="badge badge-pill" style="background:${mStatus.bg};color:${mStatus.color};font-size:10px;padding:3px 10px;">${mStatus.label}</span>
                                    </div>
                                    <div class="bm-order-name">${order.order.contact_details.first_name} ${order.order.contact_details.last_name} &middot; Est. Delivery: ${order.order.est_delivery_date ?? 'N/A'}</div>
                                    <div class="bm-order-amounts">
                                        <div><span class="bm-amt-label">Total</span><span class="bm-amt-value">$${Number(order.order.order_total).toFixed(2)}</span></div>
                                        <div><span class="bm-amt-label">Paid</span><span class="bm-amt-value" style="color:#3a9d23;">$${Number(order.paid_amount).toFixed(2)}</span></div>
                                        <div><span class="bm-amt-label">Balance</span><span class="bm-amt-value" style="color:#e01e1e;">$${(order.order.order_total - order.paid_amount).toFixed(2)}</span></div>
                                    </div>
                                </div>`;
                        });

                        var mobileModalBody = `
                            <div class="bm-brand">
                                <div class="bm-brand-logo-wrap">
                                    <img src="{{ asset('argon') }}/img/encore/logo1.png" class="bm-brand-logo" alt="Encore Custom">
                                </div>
                                <div class="bm-brand-address">
                                    <h3 class="bm-brand-title">Invoice</h3>
                                    <span>Encore Custom</span>
                                    <span>891 4th st.</span>
                                    <span>San Rafael, CA 94901</span>
                                </div>
                            </div>

                            <div class="bm-meta">
                                <div>
                                    <span class="bm-meta-label">Bulk Invoice No</span>
                                    <span class="bm-meta-value">BULK-INV-${bulk_invoice_id.toString().padStart(6, '0')}</span>
                                </div>
                                <div>
                                    <span class="bm-meta-label">Date</span>
                                    <span class="bm-meta-value">${String(createdAt.getMonth() + 1).padStart(2, '0')}/${String(createdAt.getDate()).padStart(2, '0')}/${createdAt.getFullYear()}</span>
                                </div>
                            </div>

                            <div class="bm-section">
                                <div class="bm-section-header" onclick="toggleBulkSection('bmOrgBody', this)">
                                    <span class="bm-section-title">Organization Details</span>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                                <div class="bm-section-body" id="bmOrgBody">
                                    <div class="bm-org-line"><strong>${organization.organization_name}</strong></div>
                                    <div class="bm-org-line">${organization.shipping_street ?? ''}</div>
                                    <div class="bm-org-line">${organization.shipping_city ?? ''} ${organization.shipping_state ?? ''} ${organization.shipping_postal_code ?? ''}</div>
                                    <div class="bm-org-line">${organization.shipping_country ?? ''}</div>
                                    <div class="bm-org-line">${organization.website ?? ''}</div>
                                    <div class="bm-org-line">${organization.email ?? ''}</div>
                                </div>
                            </div>

                            <div class="bm-section">
                                <div class="bm-section-header" onclick="toggleBulkSection('bmOrderListBody', this)">
                                    <span class="bm-section-title">Order List</span>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                                <div class="bm-section-body" id="bmOrderListBody">
                                    ${mobileOrdersHTML}
                                    <div class="bm-summary-card">
                                        <div class="bm-summary-row"><span>Subtotal</span><span>$${Number(orders_sub_total).toFixed(2)}</span></div>
                                        <div class="bm-summary-row"><span>Paid Amount</span><span>$${Number(orders_paid_amount).toFixed(2)}</span></div>
                                        <div class="bm-summary-row bm-total"><span>Amount to Pay</span><span>$${Number(orders_sub_total - orders_paid_amount).toFixed(2)}</span></div>
                                    </div>
                                </div>
                            </div>

                            <div class="bm-footer">
                                <p class="bm-footer-thanks">Thank you for your business!</p>
                                <img src="{{ asset('argon') }}/img/encore/logo_dark.png" class="bm-footer-logo" alt="Encore Custom">
                            </div>`;

                        $('#bulkInvoiceContent').html(mobileModalBody);
                    } else {
                        $('#bulkInvoiceContent').html(modalBody);
                    }
                    $('#bulkInvoiceModal').modal('show');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });

        });

        $("body").on("click", ".edit-order", function(){
            var orderId = $(this).data('value');
            window.open('order_details/edit/'+orderId+'/order?active_tab=order', '_blank');
        });

        $('#bulkMarkAspaid').on('click', function() {
            console.log($('#bulk_invoice_id').val());
            var bulk_invoice_id = $('#bulk_invoice_id').val();

            $('#imagePreview').attr('src', '');
            $('#payment_image').val('');

            var invoices = $('#hidden_invoices_'+bulk_invoice_id).val();

            $('#pay_multiple_invoices_bulk').val(invoices);

            $('#imagePreview').hide();
            $('#paymentReceivedModal').modal('show');
        });

        $('#submit_payment_received').click(function(e) {
            e.preventDefault();

            var arrayData = $('#pay_multiple_invoices_bulk').val();
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
                    $.ajax({
                        url: "{{ route('pay_bulk_invoice') }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            bulk_invoice_id: $('#bulk_invoice_id').val(),
                        },
                        beforeSend: function () {
                            $(".se-pre-con").fadeIn('slow');
                        },
                        success: function(response) {
                            console.log(response);
                            $('#bulkInvoiceModal').modal('hide');
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
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
    });

    /* =================================================================
       MOBILE-ONLY HELPERS , Desktop behaviour is unchanged.
       ================================================================= */
    (function () {
        var biMobileQuery = window.matchMedia('(max-width: 767px)');
        function isBiMobile() { return biMobileQuery.matches; }

        // Upload box text: "Click here" underlined (design)
        $(function () {
            if (isBiMobile()) {
                $('#paymentReceivedModal .pm-upload-text').html('<u>Click here</u> to upload');
            }
        });

        // Payment Received opens on top of Bulk Invoice Details: dim the first
        // popup behind it (design) and keep the page scroll-locked afterwards.
        $(document).on('shown.bs.modal', '#paymentReceivedModal', function () {
            if (!isBiMobile()) return;
            $(this).css('z-index', 1060);
            $('.modal-backdrop').last().css('z-index', 1055);
        });
        $(document).on('hidden.bs.modal', '#paymentReceivedModal', function () {
            $(this).css('z-index', '');
            if (isBiMobile() && $('.modal.show').length) {
                $('body').addClass('modal-open');
            }
        });

        // Place the page header 16px below the layout's fixed mobile bar(s).
        // The space above comes from the layout, so it is measured, not guessed.
        function fixBiHeaderOffset() {
            var top = document.querySelector('.mobile-page-header');
            var nav = document.getElementById('sidenav-main');
            if (!top) return;
            top.style.marginTop = '';
            if (!isBiMobile() || !nav || getComputedStyle(nav).position !== 'fixed') return;

            var barBottom = nav.getBoundingClientRect().bottom;
            document.querySelectorAll('.main-content nav, .main-content .navbar').forEach(function (el) {
                var cs = getComputedStyle(el), r = el.getBoundingClientRect();
                if (cs.position === 'fixed' && cs.display !== 'none' && cs.visibility !== 'hidden' && r.height > 0 && r.top <= 5) {
                    barBottom = Math.max(barBottom, r.bottom);
                }
            });
            // Margins can collapse with the layout's margins: adjust, re-measure, correct
            for (var i = 0; i < 5; i++) {
                var diff = Math.round(barBottom + 16 - (top.getBoundingClientRect().top + window.pageYOffset));
                if (Math.abs(diff) <= 1) break;
                top.style.marginTop = (parseFloat(getComputedStyle(top).marginTop) + diff) + 'px';
            }
        }
        $(function () {
            fixBiHeaderOffset();
            setTimeout(fixBiHeaderOffset, 350);
            setTimeout(fixBiHeaderOffset, 1300);
        });
        window.addEventListener('load', fixBiHeaderOffset);   // logo size changes the bar height
        var biResizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(biResizeTimer);
            biResizeTimer = setTimeout(fixBiHeaderOffset, 150);
        });
    })();

    function exportBulkInvoiceReport() {
        $("#bulk_invoice").tableExport({
            type: 'csv',
            escape: false,
            ignoreCols: [],
            exportHiddenCells: true,
            htmlContent: false,
            fileName: 'bulk_invoices_report',
        });
    }
</script>
@endsection