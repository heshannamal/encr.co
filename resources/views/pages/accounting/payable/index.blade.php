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

    /* =====================================================================
       PAYABLE INVOICE — MOBILE LAYOUT
       ===================================================================== */
    .pi-m-only { display: none; }

    @media (max-width: 767px) {

        /* ---------- Page shell ---------- */
        .content-position {
            top: 0;                                  /* desktop: top -25px */
            padding-left: 16px !important;
            padding-right: 16px !important;
        }
        .content-position > .col-md-12 { padding-left: 0; padding-right: 0; }
        .content-position > .col-md-12.btn-top { display: none; }   /* empty desktop button row */
        /* Layout's generic title strip / desktop top bar: replaced by the page header */
        .main-content #header,
        .main-content .header1,
        .main-content > .navbar-top,
        .main-content > #navbar-main { display: none !important; }

        /* One shared outer card: drop its box so the inner cards sit on the grey page */
        .content-position > .col-md-12 > .card {
            background: transparent;
            box-shadow: none;
            padding: 0;
            border-radius: 0;
        }
        .content-position > .col-md-12 > .card > .col-md-12 {
            margin: 0 !important;
            padding-left: 0;
            padding-right: 0;
        }
        .content-position .new-style-table .table-responsive { overflow: visible; }

        /* ---------- Page header ---------- */
        .pi-m-header {
            display: block;
            margin: 4px 0 18px;
        }
        .pi-m-back {
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
        .pi-m-back i { font-size: 11px; }
        .pi-m-title {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            line-height: 1.25;
            color: #111827;
        }

        /* ---------- DataTables wrapper ---------- */
        #generated_invoice_wrapper > .row { margin-left: 0; margin-right: 0; }
        #generated_invoice_wrapper > .row > [class*="col-"] { padding-left: 0; padding-right: 0; }
        #generated_invoice_wrapper .dataTables_length { display: none !important; }
        /* scrollX: hide the cloned header, let the body flow as cards */
        #generated_invoice_wrapper .dataTables_scrollHead { display: none !important; }
        #generated_invoice_wrapper .dataTables_scroll,
        #generated_invoice_wrapper .dataTables_scrollBody {
            overflow: visible !important;
            width: 100% !important;
            height: auto !important;
            border: none !important;
        }

        /* ---------- Search card ---------- */
        #generated_invoice_wrapper .dataTables_filter {
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
        #generated_invoice_wrapper .dataTables_filter label {
            position: relative;
            display: block;
            width: 100%;
            margin: 0;
            font-size: 0;                            /* only the icon + input are shown */
        }
        #generated_invoice_wrapper .dataTables_filter label i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: #111827;
            pointer-events: none;
        }
        #generated_invoice_wrapper .dataTables_filter input {
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
        #generated_invoice_wrapper .dataTables_filter input::placeholder { color: #9ca3af; }

        /* ---------- "Select All" / "Show [20] entries" ---------- */
        .pi-m-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin: 0 0 4px;
            padding: 0 4px 0 16px;
        }
        .pi-m-selectall {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin: 0;
            font-size: 14px;
            color: #6b7280;
            cursor: pointer;
        }
        .pi-m-show {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #6b7280;
            white-space: nowrap;
        }
        .pi-m-show select {
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
        #pi-m-select-all,
        #generated_invoice > tbody > tr .checkbox_of_invoice {
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
        #pi-m-select-all:checked,
        #generated_invoice > tbody > tr .checkbox_of_invoice:checked {
            border-color: #47D6B6;
            background-color: #47D6B6;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath d='M3.5 8.5l3 3 6-7' fill='none' stroke='%23fff' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        }

        /* ---------- Table -> invoice cards ---------- */
        #generated_invoice {
            display: block;
            width: 100% !important;
            min-width: 0 !important;
            margin: 10px 0 0 !important;
            border: none;
        }
        #generated_invoice > thead { display: none; }
        #generated_invoice > tbody { display: block; width: 100%; }

        #generated_invoice > tbody > tr {
            position: relative;
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
            cursor: pointer;
            -webkit-tap-highlight-color: transparent;
        }
        #generated_invoice > tbody > tr:hover { background: #fff !important; }
        /* Selected card */
        #generated_invoice > tbody > tr.pi-selected {
            background: #f2fbf8 !important;
            border: 1.5px solid #47D6B6 !important;
        }
        #generated_invoice > tbody > tr > td {
            display: block;
            box-sizing: border-box;                  /* DataTables sets content-box */
            min-width: 0;
            padding: 0 !important;
            border: none !important;
            text-align: left !important;
            font-size: 13px !important;              /* page rule: .9rem !important */
            color: #111827 !important;
            white-space: normal;                     /* theme tables use nowrap */
            overflow-wrap: anywhere;
        }
        #generated_invoice > tbody > tr > td a { padding: 0 !important; }       /* page rule: .4rem 1rem !important */

        /* Checkbox: first item of line 1, before the invoice number.
           Everything below starts at the card's left edge. */
        #generated_invoice > tbody > tr > td:nth-child(1) {
            order: 0;
            flex: 0 0 auto;
            align-self: center;
            margin-right: 2px;
            line-height: 0;
        }
        /* Line 1: invoice number + amount */
        #generated_invoice > tbody > tr > td:nth-child(2) { order: 1; flex: 1 1 auto; }
        #generated_invoice > tbody > tr > td:nth-child(2),
        #generated_invoice > tbody > tr > td:nth-child(2) a {
            font-size: 18px !important;
            font-weight: 700;
            line-height: 1.3;
            color: #111827 !important;
            text-decoration: none;
        }
        #generated_invoice > tbody > tr > td:nth-child(5) {
            order: 2;
            flex: 0 0 auto;
            font-size: 17px !important;
            font-weight: 700;
        }
        #generated_invoice > tbody > tr > td:nth-child(5)::before { content: "$"; }
        /* Line 2: "Order ID - #002580" */
        #generated_invoice > tbody > tr > td:nth-child(3) { order: 3; flex: 0 0 100%; margin-top: 2px; }
        #generated_invoice > tbody > tr > td:nth-child(3),
        #generated_invoice > tbody > tr > td:nth-child(3) a {
            font-size: 15px !important;
            font-weight: 400;
            color: #111827 !important;
            text-decoration: none;
        }
        #generated_invoice > tbody > tr > td:nth-child(3)::before { content: "Order ID - #"; }
        /* Line 3: Organization (left) / Paid Amount (right) */
        #generated_invoice > tbody > tr > td:nth-child(4) { order: 4; flex: 1 1 0; align-self: flex-start; margin-top: 10px; }
        #generated_invoice > tbody > tr > td:nth-child(6) {
            order: 5;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            flex: 0 1 auto;
            align-self: flex-start;
            margin-top: 10px;
            text-align: right !important;
        }
        #generated_invoice > tbody > tr > td:nth-child(4)::before,
        #generated_invoice > tbody > tr > td:nth-child(6)::before {
            display: block;
            margin-bottom: 1px;
            font-size: 12px;
            color: #8a8f98;
        }
        #generated_invoice > tbody > tr > td:nth-child(4)::before { content: "Organization"; }
        #generated_invoice > tbody > tr > td:nth-child(6)::before {
            content: "Paid Amount";
            order: -2;
            flex: 0 0 100%;
        }
        #generated_invoice > tbody > tr > td:nth-child(6)::after { content: "$"; order: -1; }
        /* Dashed divider, then Created At / Updated At */
        #generated_invoice > tbody > tr::after {
            content: "";
            order: 6;
            flex: 0 0 100%;
            height: 0;
            margin-top: 12px;
            border-top: 1px dashed #e5e7eb;
        }
        #generated_invoice > tbody > tr > td:nth-child(7) { order: 7; flex: 1 1 auto; margin-right: -10px; }
        #generated_invoice > tbody > tr > td:nth-child(8) { order: 8; flex: 0 0 auto; margin-left: auto; }
        #generated_invoice > tbody > tr > td:nth-child(7),
        #generated_invoice > tbody > tr > td:nth-child(8) {
            margin-top: 10px;
            font-size: clamp(11px, 3vw, 12.5px) !important;
            font-weight: 600;
            white-space: nowrap;
        }
        #generated_invoice > tbody > tr > td:nth-child(7)::before,
        #generated_invoice > tbody > tr > td:nth-child(8)::before {
            margin-right: 5px;
            font-weight: 400;
            color: #8a8f98;
        }
        #generated_invoice > tbody > tr > td:nth-child(7)::before { content: "Created At"; }
        #generated_invoice > tbody > tr > td:nth-child(8)::before { content: "Updated At"; }

        /* "No data available" row */
        #generated_invoice > tbody > tr > td.dataTables_empty {
            position: static;
            display: block;
            flex: 1 1 100%;
            padding: 6px 0 !important;
            font-size: 14px !important;
            text-align: center !important;
            color: #6b7280 !important;
        }
        #generated_invoice > tbody > tr:has(> td.dataTables_empty) { padding-left: 16px; cursor: default; }
        #generated_invoice > tbody > tr:has(> td.dataTables_empty)::after { display: none; }

        /* ---------- Pager ---------- */
        #generated_invoice_wrapper > .row:last-child {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-top: 6px;
        }
        #generated_invoice_wrapper > .row:last-child > [class*="col-"] {
            flex: 0 1 auto;
            width: auto;
            max-width: none;
        }
        #generated_invoice_wrapper .dataTables_info {
            padding: 0 !important;
            font-size: 13px;
            color: #9ca3af;
            white-space: normal;
        }
        #generated_invoice_wrapper .dataTables_paginate { margin: 0 !important; }
        #generated_invoice_wrapper .pagination {
            flex-wrap: wrap;
            justify-content: flex-end !important;
            gap: 6px;
            margin: 0 !important;
        }
        #generated_invoice_wrapper .page-item .page-link {
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
        #generated_invoice_wrapper .page-item.active .page-link {
            background: #111827;
            border-color: #111827;
            color: #fff;
        }
        #generated_invoice_wrapper .page-item.disabled .page-link { color: #9ca3af; }
        #generated_invoice_wrapper .page-item.previous .page-link,
        #generated_invoice_wrapper .page-item.next .page-link { font-size: 0; }
        #generated_invoice_wrapper .page-item.previous .page-link::before,
        #generated_invoice_wrapper .page-item.next .page-link::before {
            font-size: 20px;
            line-height: 1;
        }
        #generated_invoice_wrapper .page-item.previous .page-link::before { content: "\2039"; }
        #generated_invoice_wrapper .page-item.next .page-link::before     { content: "\203A"; }


        /* ---------- Bottom selection bar: "1 Selected" + Pay Selected ----------
           This IS the existing "Pay selected (n)" button (#pay_multiple), restyled.
           The existing code shows / hides it, writes the count and opens the
           Transaction popup on click, exactly as on desktop. */
        #pay_multiple:not([style*="display:none"]):not([style*="display: none"]) {
            display: flex !important;
        }
        #pay_multiple {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9990;                           /* above any layout footer / floating button */
            align-items: center;
            width: 100%;
            min-height: 72px;
            margin: 0 !important;
            padding: 14px 20px calc(14px + env(safe-area-inset-bottom, 0px)) !important;
            background: #1f2328 !important;          /* inline: green */
            color: #fff !important;
            border: none !important;
            border-radius: 0 !important;
            box-shadow: 0 -4px 16px rgba(17, 24, 39, 0.18) !important;
            text-transform: none;
            letter-spacing: 0;
            transform: none !important;
        }
        body.modal-open #pay_multiple { z-index: 1039; }   /* under a popup's dark backdrop */
        #pay_multiple > i { display: none; }
        #pay_multiple > small {                      /* "Pay selected (1)" */
            display: flex;
            align-items: center;
            width: 100%;
            font-size: 0;                            /* hides the desktop wording */
            line-height: 1;
        }
        #pay_multiple #invoice_checked_count {       /* -> "1 Selected" */
            font-size: 16px;
            font-weight: 400;
            color: #fff;
        }
        #pay_multiple #invoice_checked_count::after { content: "\00a0Selected"; }
        #pay_multiple > small::after {               /* -> teal "Pay Selected" */
            content: "Pay Selected";
            margin-left: auto;
            padding: 12px 16px;
            border-radius: 8px;
            background: #47D6B6;
            color: #fff;
            font-size: 15px;
            font-weight: 500;
            line-height: 16px;
            white-space: nowrap;
        }
        .content-position { padding-bottom: 80px; }   /* room so the bar never covers the last card */
        body:has(#pay_multiple:not([style*="display:none"]):not([style*="display: none"])) #mobileScrollDownBtn { display: none !important; }

        /* =================================================================
           "Transaction - ENCR..." pay popup (#payMultipleModal)
           ================================================================= */
        #payMultipleModal .modal-dialog {
            display: flex;
            align-items: center;
            max-width: none !important;              /* inline max-width: 1125px */
            min-height: calc(100% - 24px);
            margin: 12px;
        }
        #payMultipleModal .modal-content {
            width: 100%;
            border: none;
            border-radius: 16px;
            overflow: hidden;
        }
        #payMultipleModal .modal-header {
            align-items: center;
            margin: 0 18px;
            padding: 18px 0 14px;
            border-bottom: 1px solid #e5e7eb;
        }
        #payMultipleModal .modal-title {
            font-size: 19px !important;              /* inline 1.2rem */
            font-weight: 700;
            line-height: 1.3;
            color: #111827;
        }
        /* "TRANSACTION - ENCR000013" -> "Transaction - ENCR000013" (set by JS) */
        #payMultipleModal .modal-title[data-m-title] { font-size: 0 !important; }
        #payMultipleModal .modal-title[data-m-title]::after { content: attr(data-m-title); font-size: 19px; }
        #payMultipleModal .modal-header .close { margin: 0 0 0 12px; padding: 0 2px; opacity: 1; }
        #payMultipleModal .modal-header .close span { font-size: 26px; font-weight: 300; color: #111827; }
        #payMultipleModal .modal-body {
            max-height: calc(100vh - 190px);
            overflow-y: auto;
            padding: 14px 18px 6px !important;
        }

        /* Whole table becomes one flowing list: invoice cards, then the
           debit balance line, then "label ... [input]" rows. */
        #payMultipleModal .modal-body > .table {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            column-gap: 12px;
            row-gap: 12px;
            width: 100%;
            margin: 0;
        }
        #payMultipleModal .modal-body > .table > thead { display: none; }
        #payMultipleModal .modal-body > .table > tbody,
        #payMultipleModal .modal-body > .table > tbody.no-top-border > tr,
        #selectedInvoiceTr > tr:last-child { display: contents; }
        #payMultipleModal .modal-body > .table td {
            display: block;
            min-width: 0;
            padding: 0 !important;
            border: none !important;
            text-align: left !important;
            font-size: 14px;
            color: #111827;
            white-space: normal;
            overflow-wrap: anywhere;
        }

        /* Invoice card: number / Order ID / Organization / Total, Paid, Payment Amount */
        #selectedInvoiceTr > tr:not(:last-child) {
            order: 1;
            display: flex;
            flex-wrap: wrap;
            column-gap: 8px;
            flex: 0 0 100%;
            padding: 12px 14px 14px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(17, 24, 39, 0.05);
        }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(1) { flex: 0 0 100%; font-size: 17px; font-weight: 700; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(2) { flex: 0 0 100%; margin-top: 2px; font-size: 15px; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(2)::before { content: "Order ID - #"; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(3) { flex: 0 0 100%; margin-top: 4px; font-size: 13px; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(3)::before { content: "Organization"; margin-right: 10px; color: #8a8f98; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(4),
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(5),
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(6) {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            align-content: flex-start;
            flex: 1 1 0;
            margin-top: 10px;
            padding: 6px 8px 7px !important;
            background: #f3f4f6;
            border-radius: 8px;
            font-size: 14px;
            line-height: 1.35;
        }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(4)::before,
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(5)::before,
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(6)::before {
            order: -2;
            flex: 0 0 100%;
            margin-bottom: 1px;
            font-size: 11.5px;
            color: #8a8f98;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(4)::before { content: "Total"; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(5)::before { content: "Paid"; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(6)::before { content: "Payment Amount"; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(4)::after,
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(5)::after,
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(6)::after { content: "$"; order: -1; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(5) { color: #3a9d23; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(6) { flex-grow: 1.4; }   /* room for "Payment Amount" */
        /* Payment Amount stays editable: the input sits inside the grey box */
        #payMultipleModal #selectedInvoiceTr .invoice_payment_amount {
            flex: 1 1 0;
            width: 0;
            min-width: 0;
            height: 20px;
            padding: 0 !important;
            border: none !important;
            border-bottom: 1px dashed #c7cbd1 !important;
            border-radius: 0;
            background: transparent !important;
            box-shadow: none !important;
            color: #111827;
            font-size: 14px;
            font-weight: 400 !important;
            text-align: left !important;
        }
        #payMultipleModal #selectedInvoiceTr .invoice_payment_amount:focus { border-bottom-color: #47D6B6 !important; outline: none; }

        /* "Current debit account balance" (red), right under the cards */
        #payMultipleModal .no-top-border > tr:nth-child(1) > td:nth-child(1) { order: 2; flex: 0 0 100%; margin-top: 2px; }
        #payMultipleModal .no-top-border > tr:nth-child(1) > td:nth-child(1) p {
            font-size: 13px !important;              /* inline 1.3rem */
            font-weight: 500 !important;
            color: #d0021b !important;
        }

        /* Label ... [input] rows: Amount to Pay / Payment Amount / Settle from Debit / Total Payment */
        #selectedInvoiceTr > tr:last-child > td:nth-child(-n+4) { display: none; }
        #selectedInvoiceTr > tr:last-child > td:nth-child(5)               { order: 3; }
        #selectedInvoiceTr > tr:last-child > td:nth-child(6)               { order: 4; }
        #payMultipleModal .no-top-border > tr:nth-child(1) > td:nth-child(2) { order: 5; }
        #payMultipleModal .no-top-border > tr:nth-child(1) > td:nth-child(3) { order: 6; }
        #payMultipleModal .no-top-border > tr:nth-child(2) > td:nth-child(2) { order: 7; }
        #payMultipleModal .no-top-border > tr:nth-child(2) > td:nth-child(3) { order: 8; }
        #payMultipleModal .no-top-border > tr:nth-child(3) > td:nth-child(2) { order: 9; }
        #payMultipleModal .no-top-border > tr:nth-child(3) > td:nth-child(3) { order: 10; }
        /* Excess-payment notes (filled by the existing code when needed) */
        #payMultipleModal .no-top-border > tr:nth-child(2) > td:nth-child(1) { order: 11; flex: 0 0 100%; }
        #payMultipleModal .no-top-border > tr:nth-child(3) > td:nth-child(1) { order: 12; flex: 0 0 100%; }
        #payMultipleModal .no-top-border > tr > td:nth-child(1):empty { display: none; }
        #payMultipleModal .no-top-border > tr > td:nth-child(1) p { font-size: 12px !important; }

        #selectedInvoiceTr > tr:last-child > td:nth-child(5),
        #payMultipleModal .no-top-border > tr > td:nth-child(2) {
            flex: 0 0 calc(100% - 144px);            /* label + 132px input = one line each */
            font-size: 14px !important;
            font-weight: 400 !important;             /* inline 800 */
            color: #374151;
        }
        #selectedInvoiceTr > tr:last-child > td:nth-child(6),
        #payMultipleModal .no-top-border > tr > td:nth-child(3) { flex: 0 0 132px; }
        /* Design wording */
        #selectedInvoiceTr > tr:last-child > td:nth-child(5),
        #payMultipleModal .no-top-border > tr > td:nth-child(2) { font-size: 0 !important; }
        #selectedInvoiceTr > tr:last-child > td:nth-child(5)::after               { content: "Amount to Pay"; font-size: 14px; }
        #payMultipleModal .no-top-border > tr:nth-child(1) > td:nth-child(2)::after { content: "Payment Amount"; font-size: 14px; }
        #payMultipleModal .no-top-border > tr:nth-child(2) > td:nth-child(2)::after { content: "Settle from Debit"; font-size: 14px; }
        #payMultipleModal .no-top-border > tr:nth-child(3) > td:nth-child(2)::after { content: "Total Payment"; font-size: 14px; }
        #payMultipleModal .modal-body > .table .form-control {
            width: 100%;
            height: 38px;
            padding: 0 10px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            background: #fff;
            box-shadow: none;
            color: #6b7280;
            font-size: 14px;
            font-weight: 400 !important;             /* inline 800 */
            text-align: right;
        }
        #payMultipleModal .modal-body > .table .form-control:focus { border-color: #47D6B6; color: #111827; }
        #payMultipleModal .modal-body > .table .form-control[readonly] { background: #fff; }

        /* Payment reference text + upload area */
        #payMultipleModal .modal-body > .col-md-12 { margin-top: 16px; padding: 0; }
        #payMultipleModal .modal-body > .col-md-12 > .row { margin: 0; }
        #payMultipleModal .modal-body > .col-md-12 > .row > [class*="col-"] { flex: 0 0 100%; max-width: 100%; padding: 0; }
        #payMultipleModal .modal-body label {
            margin-bottom: 6px;
            font-size: 0;
            color: #374151;
        }
        #payMultipleModal .modal-body label[for="payment_reference text"]::after { content: "Payment Reference Text"; font-size: 14px; }
        #payMultipleModal .modal-body label[for="upload_image"]::after { content: "Upload Image for Payment Reference"; font-size: 14px; }
        #payMultipleModal .modal-body label + br { display: none; }
        #payment_reference {
            min-height: 72px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            box-shadow: none;
            font-size: 14px;
        }
        #payMultipleModal .modal-body .form-group.mb-1 {
            position: relative;
            margin: 14px 0 0 !important;
            padding: 0 !important;                   /* inline 0 1rem */
        }
        /* The file input becomes the dashed drop area (still the real input) */
        #upload_image {
            display: block;
            width: 100% !important;                  /* inline width: auto */
            height: 74px !important;
            padding: 0 !important;
            border: 1px dashed #c7cbd1;
            border-radius: 8px;
            background: #f9fafb;
            color: transparent;
            font-size: 0;
            cursor: pointer;
        }
        #upload_image::-webkit-file-upload-button { display: none; }
        #upload_image::file-selector-button { display: none; }
        #payMultipleModal .modal-body .form-group.mb-1::after {
            content: "Click here to upload";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 14px;
            padding-top: 28px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z'/%3E%3Cpath d='M14 2v6h6M12 18v-6M9 15l3-3 3 3'/%3E%3C/svg%3E") no-repeat center top / 20px 20px;
            color: #6b7280;
            font-size: 13px;
            text-align: center;
            text-decoration: underline;
            pointer-events: none;
        }
        #imagePreview { padding: 8px 0 0 !important; }

        /* Footer: Close / Pay */
        #payMultipleModal .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            padding: 12px 18px 18px;
            border-top: none;
        }
        #payMultipleModal .modal-footer .btn {
            flex: 0 0 auto;
            min-width: 100px;
            height: 44px;
            margin: 0 !important;
            padding: 0 18px;
            border: none;
            border-radius: 8px;
            font-size: 0;                            /* mobile labels below */
            font-weight: 500;
            text-transform: none;
            letter-spacing: 0;
            box-shadow: 0 4px 12px rgba(17, 24, 39, 0.08);
        }
        #payMultipleModal .modal-footer .btn-secondary { background: #b3b3b3; color: #fff; }
        #payMultipleModal .modal-footer .btn-primary   { background: #47D6B6; color: #fff; }
        #payMultipleModal .modal-footer .btn-secondary::after { content: "Close"; font-size: 16px; }
        #payMultipleModal .modal-footer .btn-primary::after   { content: "Pay"; font-size: 16px; }
    }

    /* Very small phones (320px - 359px) */
    @media (max-width: 359px) {
        .content-position {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }
        .pi-m-selectall, .pi-m-show { font-size: 13px; }
        #generated_invoice > tbody > tr { padding: 14px 12px 12px; column-gap: 8px; }
        #generated_invoice > tbody > tr > td:nth-child(2), #generated_invoice > tbody > tr > td:nth-child(2) a { font-size: 16px !important; }
        #generated_invoice > tbody > tr > td:nth-child(5) { font-size: 15px !important; }
        #generated_invoice > tbody > tr > td:nth-child(7), #generated_invoice > tbody > tr > td:nth-child(8) { font-size: 11px !important; }
        #payMultipleModal .modal-dialog { margin: 8px; min-height: calc(100% - 16px); }
        #payMultipleModal .modal-header { margin: 0 14px; }
        #payMultipleModal .modal-body { padding-left: 14px !important; padding-right: 14px !important; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(4),
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(5),
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(6) { padding: 5px 6px 6px !important; font-size: 13px; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(6)::before { font-size: 11px; }
        #selectedInvoiceTr > tr:last-child > td:nth-child(6),
        #payMultipleModal .no-top-border > tr > td:nth-child(3) { flex-basis: 112px; }
        #selectedInvoiceTr > tr:last-child > td:nth-child(5),
        #payMultipleModal .no-top-border > tr > td:nth-child(2) { flex-basis: calc(100% - 124px); }
    }
</style>


<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con" style="display: none;"></div>

    @section('order-header')
        <span>PAYABLE INVOICE</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    {{-- Mobile only: page header --}}
    <div class="pi-m-only pi-m-header">
        {{-- <a href="{{ route('home') }}" class="pi-m-back"><i class="fa fa-chevron-left"></i> BACK TO HOME</a> --}}
        <h1 class="pi-m-title">Payable Invoice</h1>
    </div>

    {{-- Mobile only: "Select All" + "Show [n] entries" (moved under the search box by JS) --}}
    <div class="pi-m-only pi-m-toolbar" id="pi-m-toolbar">
        <label class="pi-m-selectall"><input type="checkbox" id="pi-m-select-all"> Select All</label>
        <div class="pi-m-show">
            <span>Show</span>
            <select id="pi-m-entries">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="500">500</option>
            </select>
            <span>entries</span>
        </div>
    </div>

    <div class="col-md-12 btn-top">
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3 btns-right-position btn_set">
                <div class="row div_align">
                    <div class="col-md-6 btns-padding">
                        {{-- @if (Gate::check('add fabrics'))
                            <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" data-toggle="modal" data-target="#fabric_create_modal" title="Add New Fabrics">
                                Add Fabric
                            </button>
                        @endif --}}
                    </div>
                    <div class="col-md-6 btns-padding">
                            {{-- <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                                Table Layout
                            </button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 new-style-table">
        <div class="card">
            @if (isset($buttonVisibility) && $buttonVisibility == true )
                <div class="col-md-12 mt-2">
                    <input type="hidden" id="pay_multiple_invoices" name="pay_multiple_invoices[]" value="" />
                    <button type="submit" class="btn multiple-pay-button btn-secondary btn-sm" title="Pay" style="background-color: rgba(7, 213, 51, 1);color:white;display:none" id="pay_multiple"><i class="far fa-check-circle"></i><small>Pay selected (<span id="invoice_checked_count"></span>)</small></button>
                </div>
            @endif
                <div class="col-md-12 mt-3 mb-3">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="generated_invoice">
                            <thead>
                                <th>
                                    <input type="checkbox" class="checkbox_of_invoice_all" id="checkbox_of_invoice_all" />
                                </th>
                                <th scope="col" class="invoice-number">Invoice Number</th>
                                {{-- <th scope="col" class="company-invoice">Company Invoice</th>
                                <th scope="col" class="group-invoice">Group Invoice</th> --}}
                                <th scope="col" class="order-number">Order Number</th>
                                <th scope="col" class="order-organization">Organization</th>
                                <th scope="col" class="total-amount">Total amount</th>
                                <th scope="col" class="paid-amount">Paid amount</th>
                                {{-- <th scope="col" class="status">Status</th> --}}
                                <th scope="col" class="created-at">Created At</th>
                                <th scope="col" class="updated-at">Updated At</th>
                            </thead>

                            <tbody>
                                    @foreach ($factoryinvoices as $factoryinvoice)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="checkbox_of_invoice" value="{{$factoryinvoice->id}}" id="checkbox_of_invoice_{{$factoryinvoice->id}}" />
                                                </td>
                                                <td class="invoice-number"><a href="#" class="edit" data-value="{{ $factoryinvoice->id }}">{{ $factoryinvoice->invoice_number }}</a></td>
                                                {{-- <td class="company-invoice"><a href="#" class="edit" data-value="{{$factoryinvoice->id}}">{{$factoryinvoice->company_invoice}}</a></td>
                                                @if (isset($factoryinvoice->group_invoice_id))
                                                    <td class="company-invoice"><a href="#" class="group" data-value="{{$factoryinvoice->group_invoice_id}}">GROUP - {{$factoryinvoice->group_invoice_id}}</a></td>
                                                @else
                                                    <td></td>
                                                @endif --}}
                                                <td class="order-number">
                                                    <a href="{{ route('orders.info', ['id' => $factoryinvoice->order_id, 'type' => 'order']) }}?active_tab=order" target="_blank">
                                                        {{  str_pad($factoryinvoice->order_id, 6, '0', STR_PAD_LEFT)  }}
                                                    </a>
                                                </td>
                                                <td class="order-organization">{{$factoryinvoice->orderDetails ? $factoryinvoice->orderDetails->organizationDetails->organization_name : ''}}</td>
                                                <td class="total-amount text-right">{{$factoryinvoice->total_amount}}</td>
                                                <td class="paid-amount text-right">{{$factoryinvoice->paid_amount}}</td>
                                                {{-- <td class="status text-center">
                                                    @if($factoryinvoice->status == 0 )
                                                        <span class="badge badge-pill" style="color:#d381ff;background-color:#f9dfff;width:100%">Not Approved</span>
                                                    @elseif($factoryinvoice->status == 2)
                                                        <span class="badge badge-pill" style="color:#717070;background-color:#f8f8f8;width:100%">Pending Approval</span>

                                                    @elseif($factoryinvoice->status == 1)
                                                        <span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:100%">Approved</span>
                                                    @elseif($factoryinvoice->status == 4)
                                                        <span class="badge badge-pill" style="color:#d65a47;background-color:#ffcccc;width:100%">Rejected</span>
                                                    @else
                                                        <span class="badge badge-pill" style="color:#FFB916;background-color:#ffffcc;width:100%">Paid</span>

                                                    @endif
                                                </td> --}}
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
<!-- Pay multile modal -->
<div class="modal fade" id="payMultipleModal" tabindex="-1" role="dialog" aria-labelledby="payMultipleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="max-width:1125px !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payMultipleModalLabel" style="font-size: 1.2rem;">TRANSACTION - {{$transactionID}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="multiplePayForm" action="{{ route('do_pay_multiple_invoice') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <table class="table align-items-center ml-auto">
                        <thead style="background-color: grey;color: white;">
                            <th scope="col" class="text-center">Invoice Number</th>
                            <th scope="col" class="text-center">Order Number</th>
                            <th scope="col" class="text-center">Organization Name</th>
                            <th scope="col" class="text-center">Total amount</th>
                            <th scope="col" class="text-center">Paid amount</th>
                            <th scope="col" class="text-center">Payment amount</th>
                        </thead>
                        <tbody id="selectedInvoiceTr">

                        </tbody>
                        <tbody class="no-top-border">
                            <tr>
                                <td class="no-top-border" colspan="4"><p style="margin: 0;font-weight: 600;color: #cf4b4b;font-size: 1.3rem;">Current debit account balace = ${{$currentDebitValue}}</p></td>
                                <td class="text-right no-top-border" style="font-weight:800">Payment Amount:  </td>
                                <td class="no-top-border">
                                    <input type="text" name="transaction_amount_cash" id="transaction_amount_cash" value="" class="form-control text-right" style="font-weight:800">
                                </td>
                            </tr>
                            <tr>
                                <td class="no-top-border" colspan="4" id="debit_acc_summary_line_1"></td>
                                <td class="text-right no-top-border" style="font-weight:800">Settle from Debit:  </td>
                                <td class="no-top-border">
                                    <input type="text" name="transaction_amount_debit" id="transaction_amount_debit" value="0.00" class="form-control text-right" style="font-weight:800">
                                    <input type="text" name="plus_amount_to_debit" id="plus_amount_to_debit" value="0.00" style="display:none">
                                    <input type="text" name="current_value" id="current_value" value="{{$currentDebitValue}}" style="display:none">
                                </td>
                            </tr>
                            <tr>
                                <td class="no-top-border" colspan="4" id="debit_acc_summary_line_2"></td>
                                <td class="text-right no-top-border" style="font-weight:800;font-size: 1rem;">Total payment:  </td>
                                <td class="no-top-border">
                                    <input type="text" name="total_sum_of_payment" id="total_sum_of_payment" value="0.00" class="form-control text-right" style="font-weight:800;" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="transaction_id" value="{{$transactionID}}">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="payment_reference text">Payment reference text</label><br>
                                <textarea name="payment_reference" class="form-control" id="payment_reference" cols="30" rows="3" style="width: 100%;"></textarea>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group mb-1 mt-3" style="padding: 0rem 1rem;">
                                    <label for="upload_image">Upload Image for payment reference</label>
                                    <input type="file" id="upload_image" name="upload_image" accept="image/png, image/jpeg" class="form-control" style="width: auto;height: auto;" onchange="previewImage(event)">
                                </div>

                                <div class="form-group" id="imagePreview" style="display:none;padding: 0rem 1rem;">
                                    <img id="uploaded_image" src="" alt="Uploaded Image" style="width: auto; height: 5rem;">
                                    <button type="button" id="removeImage">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
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



@include('pages.accounting.generate_invoice.create')
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('uploaded_image');
            output.src = reader.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]); // Preview the image
    }

    // Remove image functionality
    document.getElementById('removeImage').addEventListener('click', function() {
        document.getElementById('upload_image').value = ''; // Clear file input
        document.getElementById('uploaded_image').src = ''; // Clear image preview
        document.getElementById('imagePreview').style.display = 'none'; // Hide image preview area
    });
</script>

<script>

$('body').on('click', '.close', function () {
        // reset();
    })

    $(document).ready(function () {

        var generated_invoice = $('#generated_invoice').DataTable({
            colReorder: false,
            scrollX: true,
            stateSave: true,
            "autoWidth": false,
            "pageLength": 500,
            "bSort": false,
            "lengthMenu": [ [25, 50, 100, 500], [25, 50, 100, 500] ],
            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'Payables Search'
            }
        });

        $('#checkbox_of_invoice_all').change(function() {
            var checked = $(this).is(':checked');
            $('.checkbox_of_invoice').prop('checked', checked).trigger('change');
        });

        $('body').on('change', '.checkbox_of_invoice', function() {
                console.log('works !');
                var invoice_array = [];
                $('.checkbox_of_invoice:checked').each(function() {
                    invoice_array.push($(this).val());
                });

                $('#invoice_checked_count').text(invoice_array.length);

                if (invoice_array.length > 0) {
                    $('#pay_multiple').show();
                    $('#pay_multiple_invoices').val(invoice_array);
                } else {
                    $('#pay_multiple').hide();
                    $('#pay_multiple_invoices').val('');
                }
            });

        var orderNumberHasBeenSet = false;

        $('body').on('click', '.multiple-pay-button', function(e){
            e.preventDefault();

            $(".se-pre-con").fadeIn('slow');

            var arrayData = $('#pay_multiple_invoices').val();

            var invoiceArray = arrayData.split(',');

            invoiceArray = invoiceArray.map(function(item) {
                return item.trim();
            });

            $.ajax({
                    url:"{{ route('get_multiple_invoice_details') }}",
                    type: "POST",
                    data: {
                        'invoices': invoiceArray,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (data) {
                        $(".se-pre-con").fadeOut('slow');

                        $('#selectedInvoiceTr').empty();

                        var invoices = data.data;
                        invoices.sort((a, b) => a.id - b.id);

                        if (invoices && invoices.length > 0) {
                            var totalAmount = 0.00;
                            invoices.forEach(function(invoice) {
                                let organizationName = invoice.order_details.organization_details.organization_name;
                                if (organizationName.length > 50) {
                                    organizationName = organizationName.substring(0, 50) + '...';
                                }
                                var row = `
                                            <tr>
                                                <td class="text-center">${invoice.invoice_number}</td>
                                                <td class="text-center">${invoice.order_id}</td>
                                                <td class="text-left">${organizationName}</td>
                                                <td class="text-right total-amount-to-pay">${parseFloat(invoice.total_amount).toFixed(2)}</td>
                                                <td class="text-right paid-amount-total">${invoice.paid_amount}</td>
                                                <td>
                                                    <input type="text" max="${invoice.total_amount - invoice.paid_amount}" class="invoice_payment_amount form-control text-right" name="payment_amount[${invoice.id}]" value="${parseFloat(invoice.total_amount - invoice.paid_amount).toFixed(2)}">
                                                </td>
                                            </tr>
                                        `;
                                        $('#selectedInvoiceTr').append(row);

                                        totalAmount += invoice.total_amount - invoice.paid_amount;
                            });

                            var totalRow = `
                                            <tr>
                                                <td class="hard-top-border"></td>
                                                <td class="hard-top-border"></td>
                                                <td class="hard-top-border"></td>
                                                <td class="hard-top-border"></td>
                                                <td class="text-right hard-top-border" style="font-weight:800">Amount to pay : </td>
                                                <td class="hard-top-border">
                                                    <input type="text" name="total_amount" id="total_paid_amount" value="${parseFloat(totalAmount).toFixed(2)}" class="form-control text-right" style="font-weight:800" readonly>
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

        $("body").on("click", ".payed", function(e){
            e.preventDefault();

            var invoiceId = $(this).data('value');
            $('#pay_multiple_invoices').val(invoiceId);
            $(".se-pre-con").fadeIn('slow');

            var arrayData = $('#pay_multiple_invoices').val();
            var invoiceArray = [arrayData.trim()];

            $.ajax({
                    url:"{{ route('get_multiple_invoice_details') }}",
                    type: "POST",
                    data: {
                        'invoices': invoiceArray,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (data) {
                        $(".se-pre-con").fadeOut('slow');

                        $('#selectedInvoiceTr').empty();

                        var invoices = data.data;
                        invoices.sort((a, b) => a.id - b.id);

                        if (invoices && invoices.length > 0) {
                            var totalAmount = 0.00;
                            invoices.forEach(function(invoice) {
                                let organizationName = invoice.order_details.organization_details.organization_name;
                                if (organizationName.length > 50) {
                                    organizationName = organizationName.substring(0, 50) + '...';
                                }
                                var row = `
                                            <tr>
                                                <td class="text-center">${invoice.invoice_number}</td>
                                                <td class="text-center">${invoice.order_id}</td>
                                                <td class="text-left">${organizationName}</td>
                                                <td class="text-right total-amount-to-pay">${parseFloat(invoice.total_amount).toFixed(2)}</td>
                                                <td class="text-right paid-amount-total">${invoice.paid_amount}</td>
                                                <td>
                                                    <input type="text" max="${invoice.total_amount - invoice.paid_amount}" class="invoice_payment_amount form-control text-right" name="payment_amount[${invoice.id}]" value="${parseFloat(invoice.total_amount - invoice.paid_amount).toFixed(2)}">
                                                </td>
                                            </tr>
                                        `;
                                        $('#selectedInvoiceTr').append(row);

                                        totalAmount += invoice.total_amount - invoice.paid_amount;
                            });

                            var totalRow = `
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-right" style="font-weight:800">Amount to pay : </td>
                                                <td>
                                                    <input type="text" name="total_amount" id="total_paid_amount" value="${parseFloat(totalAmount).toFixed(2)}" class="form-control text-right" style="font-weight:800" readonly>
                                                </td>
                                            </tr>
                                        `;
                            $('#selectedInvoiceTr').append(totalRow);

                            $('#transaction_amount_cash, #total_sum_of_payment').val(parseFloat(totalAmount).toFixed(2));

                            $('#generate_invoice').modal('hide');
                            $('#payMultipleModal').modal('show');
                        }
                    }
                });

                $(".se-pre-con").fadeOut('slow');

        });

        $(document).on('change', '#transaction_amount_cash', function() {
            handlePaymentValues();
        });

        $(document).on('change', '#transaction_amount_debit', function() {
            handlePaymentValues();
        });

        function handlePaymentValues() {
            $(".se-pre-con").fadeIn('slow');
            var sum = 0;

            $('#selectedInvoiceTr tr').each(function() {
                var $row = $(this);

                var totalAmountToPay = parseFloat($row.find('.total-amount-to-pay').text()) || 0;
                var paidAmountTotal = parseFloat($row.find('.paid-amount-total').text()) || 0;

                sum += totalAmountToPay;

                var remainingAmount = totalAmountToPay - paidAmountTotal;

                $row.find('.invoice_payment_amount').val(remainingAmount.toFixed(2));
            });

            $('#total_paid_amount').val(sum.toFixed(2));
            var total_paid_amount = parseFloat($('#total_paid_amount').val()) || 0;
            var transaction_amount_cash = parseFloat($('#transaction_amount_cash').val()) || 0;
            var transaction_amount_debit = parseFloat($('#transaction_amount_debit').val()) || 0;
            var current_value = parseFloat($('#current_value').val()) || 0;

            $('#transaction_amount_debit').prop('readonly', false);
            $('#plus_amount_to_debit').val(0.00);

            $('#total_sum_of_payment').val(parseFloat(transaction_amount_cash + transaction_amount_debit).toFixed(2));

            if (transaction_amount_cash > total_paid_amount) {
                var overPayment = (transaction_amount_cash - total_paid_amount).toFixed(2);
                var htmlContent1 = '<p style="margin: 0;font-weight: 600;color: grey;">Excess payment for this transaction = $' + overPayment + '</p>';
                var htmlContent2 = '<p style="margin: 0;font-weight: 600;color: grey;">Current debit balance (' + parseFloat(current_value).toFixed(2) + ' + ' + overPayment + ') = $' + (current_value + parseFloat(overPayment)).toFixed(2) + '</p>';

                $('#plus_amount_to_debit').val(overPayment);
                $('#debit_acc_summary_line_1').html(htmlContent1);
                $('#debit_acc_summary_line_2').html(htmlContent2);

                // $('#transaction_amount_debit').prop('readonly', true);
            }

            if (transaction_amount_cash < total_paid_amount) {

                $('#transaction_amount_debit').prop('readonly', false);

                if (transaction_amount_debit > 0) {
                    if (transaction_amount_debit == total_paid_amount - transaction_amount_cash) {
                        console.log('Payment settled');
                        $('#debit_acc_summary_line_1, #debit_acc_summary_line_2').html('');
                        $('#transaction_amount_debit').prop('readonly', true);
                    } else {
                        var remaining_payment = (total_paid_amount - transaction_amount_cash - transaction_amount_debit).toFixed(2);
                        var htmlContent1 = '<p style="margin: 0;font-weight: 600;color: grey;">Excess payment for this transaction = $' + remaining_payment + '</p>';
                        var htmlContent2 = '<p style="margin: 0;font-weight: 600;color: grey;">Current debit balance (' + parseFloat(current_value).toFixed(2) + ' + ' + remaining_payment + ') = $' + (current_value + parseFloat(remaining_payment)).toFixed(2) + '</p>';

                        $('#plus_amount_to_debit').val(remaining_payment);
                        $('#debit_acc_summary_line_1').html(htmlContent1);
                        $('#debit_acc_summary_line_2').html(htmlContent2);
                    }

                    let total = 0;
                    let is_exeed = false;

                    $('#selectedInvoiceTr').find('tr td .invoice_payment_amount').each(function () {
                        let value = parseFloat($(this).val()) || 0;
                        total += value;

                        if(!is_exeed){
                            if(total >  (transaction_amount_cash + transaction_amount_debit)){
                            $(this).val((value - total + (transaction_amount_cash + transaction_amount_debit)).toFixed(2)).trigger('change');
                            is_exeed = true;
                        }
                        }else{
                            $(this).val((0).toFixed(2)).trigger('change');
                        }
                    });
                    calculateTotalAmount();
                } else {
                    $('#debit_acc_summary_line_1, #debit_acc_summary_line_2').html('');

                    let total = 0;
                    let is_exeed = false;

                    $('#selectedInvoiceTr').find('tr td .invoice_payment_amount').each(function () {
                        let value = parseFloat($(this).val()) || 0;
                        total += value;

                        if(!is_exeed){
                            if(total >  (transaction_amount_cash + transaction_amount_debit)){
                            $(this).val((value - total + (transaction_amount_cash + transaction_amount_debit)).toFixed(2)).trigger('change');
                            is_exeed = true;
                        }
                        }else{
                            $(this).val((0).toFixed(2)).trigger('change');
                        }
                    });
                    calculateTotalAmount();

                }
            }

            if (transaction_amount_cash == total_paid_amount) {
                console.log('Payment settled');
                // $('#transaction_amount_debit').prop('readonly', true);
                $('#debit_acc_summary_line_1, #debit_acc_summary_line_2').html('');
            }

            $(".se-pre-con").fadeOut('slow');
        }



        function calculateTotalAmount() {
            var totalAmount = 0;
            $('.invoice_payment_amount').each(function() {
                var amount = parseFloat($(this).val());
                if (!isNaN(amount)) {
                    totalAmount += amount;
                }
            });
            // $('#total_paid_amount').val(totalAmount.toFixed(2));
            if ($('#transaction_amount_cash').val() > totalAmount) {
                $('#transaction_amount_cash').val(totalAmount.toFixed(2));
            }
        }

        $(document).on('input', '.invoice_payment_amount', function() {
            calculateTotalAmount();
        });

        $('#confirmGroupPay').click(function(e) {
            $(".se-pre-con").fadeIn('slow');
            e.preventDefault();

            var formData = new FormData($('#multiplePayForm')[0]);

            $.ajax({
                url: "{{ route('do_pay_multiple_invoice') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    $('#payMultipleModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });

            $(".se-pre-con").fadeOut('slow');
        });


        calculateTotalAmount();

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
                $('#invoice_form').attr('action', `invoice/approve/${invoice.id}`);
                $('#generate_invoice').modal('show');
            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
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

        if (status === 1 || status === 3 || status === 5) {
            $('#frm_submit_btn').hide();
            $('#frm_submit_btn_save').hide();
        } else {
            $('#frm_submit_btn').show();
            $('#frm_submit_btn_save').show();
        }

        if (status === 0|| status === 4) {
            createActionButton('Delete', 'delete btn-danger', 'delete', invoice.id);
        }else{
            if($('button.delete').length> 0){
                $('button.delete').remove();
            }
        }

        if (status === 1 || status === 2 || status === 5) {
            createActionButton('Pay', 'payed btn-warning', 'payed', invoice.id);
        }else{
            if($('button.payed').length> 0){
                $('button.payed').remove();
            }
        }
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

    $('#generate_invoice_btn').on('click', function(){

        updateCurrentDate();
    });

    $(document).on('click', '.edit', function (event) {
        event.preventDefault();

        var invoiceId = $(this).data('value'); // Retrieve invoice ID from the data attribute

        $(".se-pre-con").fadeIn('slow'); // Show loading animation
        $('.frm_submit_btn').text('Request Payment'); // Change button text

        $('#new_invoice_no').val(invoiceId); // Set the invoice ID in the input
        $('#generate_invoice').attr('data-selected-invoice-id', invoiceId); // Set the invoice ID as a custom data attribute

        get_invoice_data(invoiceId); // Call the function to get invoice data
    });

    $('#payMultipleModal').on('hidden.bs.modal', function (e) {
        location.reload();
    });

    /* ---------------- MOBILE-ONLY HELPERS  ----------------*/
    try {
        var piMobileQuery = window.matchMedia('(max-width: 767px)');
        var isPiMobile = function () { return piMobileQuery.matches; };

        // stateSave is on: the page length is remembered in the browser. Desktop must
        // only ever use its own menu values (25 / 50 / 100 / 500), otherwise its
        // "Show [ ] entries" box is empty. Repair a length saved by an older mobile
        // version, and never let the mobile 20 be saved.
        var piDesktopLengths = [25, 50, 100, 500];
        var piSaved = generated_invoice.state.loaded();
        var piDesktopLen = (piSaved && piDesktopLengths.indexOf(piSaved.length) !== -1) ? piSaved.length : 500;
        generated_invoice.on('stateSaveParams.dt', function (e, settings, data) {
            if (isPiMobile() || piDesktopLengths.indexOf(data.length) === -1) { data.length = piDesktopLen; }
            else { piDesktopLen = data.length; }
        });
        if (!isPiMobile() && piDesktopLengths.indexOf(generated_invoice.page.len()) === -1) {
            generated_invoice.page.len(piDesktopLen).draw();
        }

        if (isPiMobile()) {
            // Toolbar under the search card; design placeholder; 20 rows like the design
            $('#pi-m-toolbar').insertAfter($('#generated_invoice_wrapper .dataTables_filter'));
            $('#generated_invoice_filter input').attr('placeholder', 'Search by invoice number');
            generated_invoice.page.len(20).draw();
        }
        (function () {
            var len = String(generated_invoice.page.len());
            if (!$('#pi-m-entries option[value="' + len + '"]').length) {
                $('#pi-m-entries').append($('<option>', { value: len, text: len }));
            }
            $('#pi-m-entries').val(len);
        })();
        $('#pi-m-entries').on('change', function () {
            generated_invoice.page.len(parseInt(this.value, 10)).draw();
        });

        // Select All (mobile) -> the existing header "select all" checkbox + its handler
        $('#pi-m-select-all').on('change', function () {
            $('#checkbox_of_invoice_all').prop('checked', this.checked).trigger('change');
        });

        // Card highlight + "Select All" state
        var updatePiSelectionUi = function () {
            var $boxes = $('#generated_invoice .checkbox_of_invoice');
            $boxes.each(function () {
                $(this).closest('tr').toggleClass('pi-selected', this.checked);
            });
            $('#pi-m-select-all').prop('checked', $boxes.length > 0 && $boxes.filter(':checked').length === $boxes.length);
        };
        $('body').on('change', '.checkbox_of_invoice, #checkbox_of_invoice_all', updatePiSelectionUi);
        generated_invoice.on('draw', updatePiSelectionUi);
        updatePiSelectionUi();

        // Tapping a card (not its links / checkbox) selects it
        $('#generated_invoice tbody').on('click', 'tr', function (e) {
            if (!isPiMobile()) return;
            if ($(e.target).closest('a, input, label, .dataTables_empty').length) return;
            var $box = $(this).find('.checkbox_of_invoice');
            if ($box.length) {
                $box.prop('checked', !$box.prop('checked')).trigger('change');
            }
        });

        // Popup title "TRANSACTION - ENCR000013" -> "Transaction - ENCR000013" (display only)
        var $piTitle = $('#payMultipleModalLabel');
        var piTitleText = $.trim($piTitle.text());
        if (/^TRANSACTION\s*-/i.test(piTitleText)) {
            $piTitle.attr('data-m-title', piTitleText.replace(/^TRANSACTION/i, 'Transaction'));
        }

        // Place the page header 16px below the layout's fixed mobile bar(s).
        var fixPiHeaderOffset = function () {
            var top = document.querySelector('.pi-m-header');
            var nav = document.getElementById('sidenav-main');
            if (!top) return;
            top.style.marginTop = '';
            if (!isPiMobile() || !nav || getComputedStyle(nav).position !== 'fixed') return;
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
        fixPiHeaderOffset();
        setTimeout(fixPiHeaderOffset, 350);
        setTimeout(fixPiHeaderOffset, 1300);
        $(window).on('load', fixPiHeaderOffset);
        var piResizeTimer;
        $(window).on('resize', function () {
            clearTimeout(piResizeTimer);
            piResizeTimer = setTimeout(fixPiHeaderOffset, 150);
        });
    } catch (piErr) {
        if (window.console) console.error('Payable invoice mobile view:', piErr);
    }
    /* -------------------------------------------------------------------- */
});
</script>
@endsection