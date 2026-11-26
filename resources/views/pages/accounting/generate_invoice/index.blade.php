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
        display: none;
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
    .hide {
  display: none;
}

.filter {
        padding-bottom: 0rem;
        position: relative;
        width: 98%;
        left: 1%;
        top: -0.25rem;
        border-radius: 6px !important;
    }
    .search1 {
        position: relative;
        margin-top: -0.6rem;
        margin-bottom: 1rem;
    }
    .card{
        background-color: white;
        border: none;
        border-radius: 0rem;
    }
    .styled-button{
        outline: unset;
        color: #d3d3d3;
        background-color: #fafafa;;
        border: 1px solid #d3d3d3;
        padding: .3rem;
        padding-left: .7rem;
        padding-right: .7rem;
        margin: 0rem;
        cursor: pointer;
    }
    .searchbox-layout{
        margin-top: 0 !important;
        width: 100% !important;
        height: 29px;
        font-size: .9rem;
        color: #B3B3B3;
        border: unset;
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
    .new-style-table table tbody tr:hover{
        background-color: #f6f6ff;
    }
    .new-style-table th, .new-style-table td {
        padding: 10px;
    }
    .table-responsive .table tbody td , .table-responsive .table tbody td a {
        padding: 0.4rem 1rem !important;
        font-size: .9rem !important;
        color: rgba(22, 22, 23, 1) !important;
    }
    .new-style-table table thead tr{
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
    .dataTables_scrollHeadInner{
        min-width: 100%;
    }

    /* =====================================================================
       GENERATED INVOICE — MOBILE LAYOUT
       ===================================================================== */
    .gi-m-only { display: none; }

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
        .gi-m-header {
            display: block;
            margin: 4px 0 18px;
        }
        .gi-m-back {
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
        .gi-m-back i { font-size: 11px; }
        .gi-m-title {
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
        .gi-m-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin: 0 0 4px;
            padding: 0 4px 0 16px;
        }
        .gi-m-selectall {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin: 0;
            font-size: 14px;
            color: #6b7280;
            cursor: pointer;
        }
        .gi-m-show {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #6b7280;
            white-space: nowrap;
        }
        .gi-m-show select {
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
        #gi-m-select-all,
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
        #gi-m-select-all:checked,
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
        #generated_invoice > tbody > tr.gi-selected {
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
        #generated_invoice > tbody > tr > td:nth-child(6) {
            order: 2;
            flex: 0 0 auto;
            font-size: 17px !important;
            font-weight: 700;
        }
        #generated_invoice > tbody > tr > td:nth-child(6)::before { content: "$"; }
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
        /* Line 3: Organization (left) / Embellishment (right) */
        #generated_invoice > tbody > tr > td:nth-child(4) { order: 4; flex: 1 1 0; align-self: flex-start; margin-top: 10px; }
        #generated_invoice > tbody > tr > td:nth-child(5) {
            order: 5;
            flex: 0 1 auto;
            align-self: flex-start;
            margin-top: 10px;
            text-align: right !important;
        }
        #generated_invoice > tbody > tr > td:nth-child(4)::before,
        #generated_invoice > tbody > tr > td:nth-child(5)::before {
            display: block;
            margin-bottom: 1px;
            font-size: 12px;
            color: #8a8f98;
        }
        #generated_invoice > tbody > tr > td:nth-child(4)::before { content: "Organization"; }
        #generated_invoice > tbody > tr > td:nth-child(5)::before { content: "Embellishment"; }
        #generated_invoice > tbody > tr > td:nth-child(5) .badge {        /* Yes / No as plain text (design) */
            padding: 0;
            background: transparent !important;
            color: #111827 !important;
            font-size: 13px;
            font-weight: 400;
            text-transform: none;
            letter-spacing: 0;
        }
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

        /* ---------- Bottom selection bar: "7 Selected" + Request Payment ----------
           This IS the existing desktop button #request_multiple, restyled.
           The existing code already shows it when invoices are ticked, hides it
           when none are, writes the count into #invoice_checked_count, and opens
           the "Request payment for Multiple Invoices" popup on click. So the
           mobile bar works exactly like desktop, with no extra JavaScript. */
        #request_multiple:not([style*="display:none"]):not([style*="display: none"]) {
            display: flex !important;
        }
        #request_multiple {
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
        /* While a popup is open, go under its dark backdrop (1040) like the design */
        body.modal-open #request_multiple { z-index: 1039; }
        #request_multiple > i { display: none; }
        #request_multiple > small {                  /* "Request payment selected (7)" */
            display: flex;
            align-items: center;
            width: 100%;
            font-size: 0;                            /* hides the desktop wording */
            line-height: 1;
        }
        #invoice_checked_count {                     /* -> "7 Selected" */
            font-size: 16px;
            font-weight: 400;
            color: #fff;
        }
        #invoice_checked_count::after { content: "\00a0Selected"; }
        #request_multiple > small::after {           /* -> teal "Request Payment" */
            content: "Request Payment";
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
        /* Room under the last card so the bar never covers it */
        .content-position { padding-bottom: 80px; }
        /* The layout's floating "scroll down" button would sit on top of the bar */
        body:has(#request_multiple:not([style*="display:none"]):not([style*="display: none"])) #mobileScrollDownBtn,
        body.gi-has-selbar #mobileScrollDownBtn { display: none !important; }
        /* Darker page behind the request popup (design) */
        body.gi-req-open .modal-backdrop.show { opacity: .5; }

        /* =================================================================
           "Request payment for multiple Invoices" popup
           ================================================================= */
        #requestMultipleModal .modal-dialog {
            display: flex;
            align-items: center;
            max-width: none;
            min-height: calc(100% - 32px);
            margin: 16px;
        }
        #requestMultipleModal .modal-content {
            width: 100%;
            border: none;
            border-radius: 16px;
            overflow: hidden;
        }
        #requestMultipleModal .modal-header {
            align-items: flex-start;
            margin: 0 18px;
            padding: 18px 0 14px;
            border-bottom: 1px solid #e5e7eb;
        }
        #requestMultipleModal .modal-title {
            font-size: 19px;
            font-weight: 700;
            line-height: 1.3;
            color: #111827;
        }
        #requestMultipleModal .modal-header .close { margin: 0 0 0 12px; padding: 0 2px; opacity: 1; }
        #requestMultipleModal .modal-header .close span { font-size: 26px; font-weight: 300; color: #111827; }
        #requestMultipleModal .modal-body {
            max-height: calc(100vh - 230px);
            overflow-y: auto;
            padding: 14px 18px 4px !important;
        }
        #requestMultipleModal .modal-body > .table { display: block; margin: 0; }
        #requestMultipleModal .modal-body > .table > thead { display: none; }
        #requestMultipleModal #selectedInvoiceTr { display: block; }
        #selectedInvoiceTr > tr {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            column-gap: 10px;
            margin-bottom: 12px;
            padding: 12px 14px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(17, 24, 39, 0.05);
        }
        #selectedInvoiceTr > tr > td {
            display: block;
            min-width: 0;
            padding: 0 !important;
            border: none !important;
            text-align: left !important;
            font-size: 14px;
            color: #111827;
            white-space: normal;                     /* theme tables use nowrap */
            overflow-wrap: anywhere;
        }
        #selectedInvoiceTr > tr > td:nth-child(1) { order: 1; flex: 1 1 auto; font-size: 17px; font-weight: 700; }
        #selectedInvoiceTr > tr > td:nth-child(4) { order: 2; flex: 0 0 auto; display: flex; font-size: 16px; font-weight: 700; }  /* flex: no space after "$" */
        #selectedInvoiceTr > tr > td:nth-child(4)::before { content: "$"; }
        #selectedInvoiceTr > tr > td:nth-child(2) { order: 3; flex: 0 0 100%; margin-top: 2px; font-size: 15px; }
        #selectedInvoiceTr > tr > td:nth-child(2)::before { content: "Order ID - #"; }
        #selectedInvoiceTr > tr > td:nth-child(3) { order: 4; flex: 0 0 100%; margin-top: 4px; font-size: 13px; }
        #selectedInvoiceTr > tr > td:nth-child(3)::before { content: "Organization"; margin-right: 10px; color: #8a8f98; }
        /* Last row = Total */
        #selectedInvoiceTr > tr:last-child {
            justify-content: space-between;
            margin-bottom: 4px;
            padding: 6px 4px;
            background: transparent;
            border: none;
            box-shadow: none;
        }
        #selectedInvoiceTr > tr:last-child > td:nth-child(1),
        #selectedInvoiceTr > tr:last-child > td:nth-child(2) { display: none; }
        #selectedInvoiceTr > tr:last-child > td:nth-child(3) {
            order: 1;
            flex: 1 1 auto;
            margin: 0;
            font-size: 14px;
            font-weight: 400 !important;
            color: #6b7280;
        }
        #selectedInvoiceTr > tr:last-child > td:nth-child(3)::before { content: none; }
        #selectedInvoiceTr > tr:last-child > td:nth-child(4) { order: 2; }
        #requestMultipleModal .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            padding: 12px 18px 18px;
            border-top: none;
        }
        #requestMultipleModal .modal-footer .btn {
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
        #requestMultipleModal .modal-footer .btn-secondary { background: #b3b3b3; color: #fff; }
        #requestMultipleModal .modal-footer .btn-primary   { background: #47D6B6; color: #fff; }
        #requestMultipleModal .modal-footer .btn-secondary::after { content: "Close"; font-size: 16px; }
        #requestMultipleModal .modal-footer .btn-primary::after   { content: "Request Payment"; font-size: 16px; }
    }

    /* Very small phones (320px - 359px) */
    @media (max-width: 359px) {
        .content-position {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }
        .gi-m-selectall, .gi-m-show { font-size: 13px; }
        #generated_invoice > tbody > tr { padding: 14px 12px 12px; column-gap: 8px; }
        #generated_invoice > tbody > tr > td:nth-child(2), #generated_invoice > tbody > tr > td:nth-child(2) a { font-size: 16px !important; }
        #generated_invoice > tbody > tr > td:nth-child(6) { font-size: 15px !important; }
        #generated_invoice > tbody > tr > td:nth-child(7), #generated_invoice > tbody > tr > td:nth-child(8) { font-size: 11px !important; }
        #requestMultipleModal .modal-dialog { margin: 10px; min-height: calc(100% - 20px); }
        #requestMultipleModal .modal-header { margin: 0 14px; }
        #requestMultipleModal .modal-body { padding-left: 14px !important; padding-right: 14px !important; }
    }
</style>

@if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>GENERATED INVOICE</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    {{-- Mobile only: page header --}}
    <div class="gi-m-only gi-m-header">
        {{-- <a href="{{ route('home') }}" class="gi-m-back"><i class="fa fa-chevron-left"></i> BACK TO HOME</a> --}}
        <h1 class="gi-m-title">Generated Invoice</h1>
    </div>

    {{-- Mobile only: "Select All" + "Show [n] entries" (moved under the search box by JS) --}}
    <div class="gi-m-only gi-m-toolbar" id="gi-m-toolbar">
        <label class="gi-m-selectall"><input type="checkbox" id="gi-m-select-all"> Select All</label>
        <div class="gi-m-show">
            <span>Show</span>
            <select id="gi-m-entries">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
                <option value="300">300</option>
                <option value="500">500</option>
            </select>
            <span>entries</span>
        </div>
    </div>



    <div class="col-md-12">
        <div class="card">
                <div class="col-md-12 mt-2">
                    <input type="hidden" id="request_multiple_invoices" name="request_multiple_invoices[]" value="" />
                    <button type="submit" class="btn multiple-request-button btn-secondary btn-sm" title="Request payment" style="background-color: rgba(7, 213, 51, 1);color:white;display:none" id="request_multiple"><i class="far fa-check-circle"></i><small>Request payment selected (<span id="invoice_checked_count"></span>)</small></button>
                </div>
                {{-- <div class="row mt-3" style="padding-left: 1rem;padding-right: 1rem;">
                    <div class=" text-left" style="margin-left: 10px; margin-right: 10px;">
                        @if (Gate::check('generate invoice'))
                            <button class="styled-button" id="generate_invoice_btn" style="outline: unset;" href="#" data-toggle="modal" data-target="#generate_invoice" title="Generate New Invoice">
                                GENARATE INVOICE
                            </button>
                        @endif
                    </div>
                </div> --}}
                <div class="col-md-12 mt-3 mb-3 new-style-table">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="generated_invoice" style="min-width: 100%;">
                            <thead>
                                <th>
                                    <input type="checkbox" class="checkbox_of_invoice_all" id="checkbox_of_invoice_all" />
                                </th>
                                <th scope="col" class="invoice-number-topic">Invoice Number</th>
                                <th scope="col" class="order-number">Order Number</th>
                                <th scope="col" class="inv-org">Organization</th>
                                <th scope="col" class="Embellishments">Embellishments</th>
                                <th scope="col" class="total-amount">Total amount</th>
                                {{-- <th scope="col" class="status text-center">Status</th> --}}
                                <th scope="col" class="created-at">Created At</th>
                                <th scope="col" class="updated-at">Updated At</th>
                            </thead>

                            <tbody>
                                @foreach ($invoices as $invoice)
                                    @php
                                        $matchingOrder = $orders->firstWhere('id', $invoice->order_id);
                                    @endphp

                                    @if ($matchingOrder)
                                    @php
                                        $matchingOrganization = $organizations->firstWhere('id', $matchingOrder->organization_id);
                                    @endphp
                                        <tr>
                                            <td class="invoice-number">
                                                <input type="checkbox" class="checkbox_of_invoice" value="{{$invoice->id}}" id="checkbox_of_invoice_{{$invoice->id}}"  />
                                            </td>
                                            <td class="invoice-number">
                                                <a href="#" class="edit" data-value="{{ $invoice->id }}">{{ $invoice->invoice_number }}</a>
                                            </td>
                                            <td class="order-number">
                                                <a href="{{ route('orders.info', ['id' => $matchingOrder->id, 'type' => 'order']) }}?active_tab=order" target="_blank">
                                                    {{ $matchingOrder->order_no }}
                                                </a>
                                            </td>
                                            <td class="inv-org">{{ $matchingOrganization ? $matchingOrganization->organization_name : '' }}</td>
                                            <td class="Embellishments" style="text-align: center;">
                                                @if($matchingOrder->embellishment == 'yes')
                                                    <span class="badge badge-success">Yes</span>
                                                @else
                                                    <span class="badge badge-secondary">No</span>
                                                @endif
                                            </td>
                                            <td class="total-amount">{{ $invoice->total_amount }}</td>
                                            {{-- <td class="status text-center">
                                                @switch($invoice->status)
                                                    @case(0)
                                                        <span class="badge badge-pill" style="color:#d381ff;background-color:#f9dfff;width:100%">Not Approved</span>
                                                        @break
                                                    @case(1)
                                                        <span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:100%">Approved</span>
                                                        @break
                                                    @case(2)
                                                        <span class="badge badge-pill" style="color:#717070;background-color:#f8f8f8;width:100%">Pending Approval</span>
                                                        @break
                                                    @case(4)
                                                        <span class="badge badge-pill" style="color:#d65a47;background-color:#ffcccc;width:100%">Rejected</span>
                                                        @break
                                                    @default
                                                        <span class="badge badge-pill" style="color:#FFB916;background-color:#ffffcc;width:100%">Paid</span>
                                                @endswitch
                                            </td> --}}
                                            <td class="created-at">{{ $invoice->created_at->format('m/d/Y') }}</td>
                                            <td class="updated-at">{{ $invoice->updated_at->format('m/d/Y') }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>
<!-- Pay multile modal -->
<div class="modal fade" id="requestMultipleModal" tabindex="-1" role="dialog" aria-labelledby="requestMultipleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestMultipleModalLabel">Request payment for Multiple Invoices</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="multipleRequestForm" action="{{ route('do_pay_multiple_invoice') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <table class="table align-items-center">
                        <thead style="background-color: grey;color: white;">
                            <th scope="col" class="text-center">Invoice Number</th>
                            <th scope="col" class="text-center">Order Number</th>
                            <th scope="col" class="text-center">Organization Name</th>
                            <th scope="col" class="text-center">Invoice amount</th>
                        </thead>
                        <tbody id="selectedInvoiceTr">
                            <!-- Dynamic rows will be appended here -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmGroupRequest">Request payments</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('pages.accounting.generate_invoice.create')

<script>

$(document).ready(function () {

    var generated_invoice = $('#generated_invoice').DataTable({
        colReorder: false,
        scrollX: true,
        stateSave: false,
        autoWidth: true,

        pageLength: 300, // Default page length

        lengthMenu: [
            [100, 200, 300, 500], // Values used internally
            [100, 200, 300, 500]  // Labels shown in dropdown
        ],

        bSort: false,

        language: {
            search: '<i class="fas fa-search"></i>',
            searchPlaceholder: 'Invoice Search'
        }
    });



    var orderNumberHasBeenSet = false;
    function reset(){
        $('#invoice_no').val('');
    }

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
                    $('#request_multiple').show();
                    $('#request_multiple_invoices').val(invoice_array);
                } else {
                    $('#request_multiple').hide();
                    $('#request_multiple_invoices').val('');
                }
        });

        $('body').on('click', '.multiple-request-button', function(e){
            e.preventDefault();

            $(".se-pre-con").fadeIn('slow');

            var arrayData = $('#request_multiple_invoices').val();

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

                        if (data.data && data.data.length > 0) {
                            var totalAmount = 0.00;

                            data.data.forEach(function(invoice) {
                                var invoiceTotalAmount = parseFloat(invoice.total_amount); // Parse the total amount as a float
                                var row = `
                                            <tr>
                                                <td class="text-center">${invoice.invoice_number}</td>
                                                <td class="text-center">${invoice.order_id}</td>
                                                <td>${invoice.order_details.organization_details.organization_name}</td>
                                                <td class="text-right">
                                                    ${invoiceTotalAmount.toFixed(2)}<input type="number" style="display:none" max="${invoiceTotalAmount}" class="invoice_request_amount text-right form-control" name="payment_amount[${invoice.id}]" value="${invoiceTotalAmount}">
                                                </td>
                                            </tr>
                                        `;
                                $('#selectedInvoiceTr').append(row);

                                totalAmount += invoiceTotalAmount;
                            });

                            var totalRow = `
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td class="text-right" style="font-weight:800">Total : </td>
                                                <td class="text-right">
                                                    ${totalAmount.toFixed(2)} <!-- Ensure total has two decimal places -->
                                                </td>
                                            </tr>
                                        `;
                            $('#selectedInvoiceTr').append(totalRow);

                            $('#requestMultipleModal').modal('show');
                        }

                    }
                });

                $(".se-pre-con").fadeOut('slow');
        });

        $('#confirmGroupRequest').click(function(e) {
            $(".se-pre-con").fadeIn('slow');
            e.preventDefault();

            var formData = $('#multipleRequestForm').serialize();

            $.ajax({
                url: "{{ route('request_multiple_invoice') }}",
                method: "POST",
                data: formData,
                success: function(response) {
                    console.log(response);
                    $('#requestMultipleModal').modal('hide');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });

    /* ---------------- MOBILE-ONLY HELPERS ----------------*/
    try {
        var giMobileQuery = window.matchMedia('(max-width: 767px)');
        var isGiMobile = function () { return giMobileQuery.matches; };

        if (isGiMobile()) {
            // Toolbar right under the search card; design placeholder; 20 rows like the design
            $('#gi-m-toolbar').insertAfter($('#generated_invoice_wrapper .dataTables_filter'));
            $('#generated_invoice_filter input').attr('placeholder', 'Search by invoice number');
            generated_invoice.page.len(20).draw();
        }
        (function () {
            var len = String(generated_invoice.page.len());
            if (!$('#gi-m-entries option[value="' + len + '"]').length) {
                $('#gi-m-entries').append($('<option>', { value: len, text: len }));
            }
            $('#gi-m-entries').val(len);
        })();
        $('#gi-m-entries').on('change', function () {
            generated_invoice.page.len(parseInt(this.value, 10)).draw();
        });

        // Select All (mobile) -> the existing header "select all" checkbox + its handler
        $('#gi-m-select-all').on('change', function () {
            $('#checkbox_of_invoice_all').prop('checked', this.checked).trigger('change');
        });

        // Card highlight + "Select All" state. (The bottom bar itself is the
        // existing #request_multiple button, shown/hidden by the code above.)
        var updateGiSelectionUi = function () {
            var $boxes = $('#generated_invoice .checkbox_of_invoice');
            $boxes.each(function () {
                $(this).closest('tr').toggleClass('gi-selected', this.checked);
            });
            $('#gi-m-select-all').prop('checked', $boxes.length > 0 && $boxes.filter(':checked').length === $boxes.length);
            $('body').toggleClass('gi-has-selbar', isGiMobile() && $('#request_multiple').is(':visible'));
        };
        $('body').on('change', '.checkbox_of_invoice, #checkbox_of_invoice_all', updateGiSelectionUi);
        generated_invoice.on('draw', updateGiSelectionUi);
        if (giMobileQuery.addEventListener) { giMobileQuery.addEventListener('change', updateGiSelectionUi); }
        else if (giMobileQuery.addListener) { giMobileQuery.addListener(updateGiSelectionUi); }
        updateGiSelectionUi();

        // Tapping a card (not its links / checkbox) selects it
        $('#generated_invoice tbody').on('click', 'tr', function (e) {
            if (!isGiMobile()) return;
            if ($(e.target).closest('a, input, label, .dataTables_empty').length) return;
            var $box = $(this).find('.checkbox_of_invoice');
            if ($box.length) {
                $box.prop('checked', !$box.prop('checked')).trigger('change');
            }
        });

        $('#requestMultipleModal')
            .on('show.bs.modal', function () { $('body').addClass('gi-req-open'); })
            .on('hidden.bs.modal', function () { $('body').removeClass('gi-req-open'); });

        // Place the page header 16px below the layout's fixed mobile bar(s).
        // The space above comes from the layout, so it is measured, not guessed.
        var fixGiHeaderOffset = function () {
            var top = document.querySelector('.gi-m-header');
            var nav = document.getElementById('sidenav-main');
            if (!top) return;
            top.style.marginTop = '';
            if (!isGiMobile() || !nav || getComputedStyle(nav).position !== 'fixed') return;
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
        fixGiHeaderOffset();
        setTimeout(fixGiHeaderOffset, 350);
        setTimeout(fixGiHeaderOffset, 1300);
        $(window).on('load', fixGiHeaderOffset);
        var giResizeTimer;
        $(window).on('resize', function () {
            clearTimeout(giResizeTimer);
            giResizeTimer = setTimeout(fixGiHeaderOffset, 150);
        });
    } catch (giErr) {
        if (window.console) console.error('Generated invoice mobile view:', giErr);
    }
    /* -------------------------------------------------------------------- */
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

                console.log(data);

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
        $('.additional').val(''); // Clear all additional fields first
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

        if (status === 1 || status === 3) {
            $('#frm_submit_btn').hide();
        } else {
            $('#frm_submit_btn').show();
        }

        if (status === 0|| status === 4) {
            createActionButton('Delete', 'delete btn-danger', 'delete', invoice.id);
        }else{
            if($('button.delete').length> 0){
                $('button.delete').remove();
            }
        }

        if (status === 1 || status === 2) {
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

        get_invoice_data(invoiceId);
    });

    $("body").on("click", ".delete", function(e) {
        e.preventDefault();

        var invoiceId = $(this).data('value');

        Swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            text: 'Do you really want to delete this invoice?',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then(function(result) {
            if (result.value == true) {
                $.ajax({
                    url: '{{url("invoice/delete")}}/' + invoiceId,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function() {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function(data) {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: data.success,
                                showConfirmButton: false,
                                timer: 3000
                            }).then(function() {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.error
                            });
                        }
                    },
                    complete: function() {
                        $(".se-pre-con").fadeOut('slow');
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please try again.'
                        });
                    }
                });
            }
        });
    });


    $("body").on("click", ".payed", function(e){
        e.preventDefault(); // Prevent the default click behavior

        var invoiceId = $(this).data('value');

        // Show a confirmation popup using SweetAlert2
        if (confirm("Are you sure you want to payed this invoice?")) {
                // User confirmed, send an AJAX request to payed the product
                $.ajax({
                    url: '{{url("invoice/payed")}}/'+invoiceId,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function(data){
                        if (data.success) {
                            // Product pay successful, display success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: data.success,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function() {
                                // Reload the current page
                                location.reload();
                            });
                        } else {
                            // Product pay failed, display the error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.error
                            });
                        }
                    },

                    complete: function() {
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            }

        });
    });


    $(document).ready(function() {
        $('.select2-invoice').select2({
            dropdownParent: $('#generate_invoice')
        });
    });
    $(document).ready(function() {
        // Store the original values when the page loads
        $('#order-items-table tbody tr').each(function() {
            var $row = $(this);
            $row.data('original-product-no', $row.find('.inv-product-no').text());
            $row.data('original-qty', $row.find('.inv-product-qty').text());
        });

        // On form submission
        $('#invoice_form').on('submit', function(e) {
            $('#order-items-table tbody tr').each(function() {
                var $row = $(this);

                // Reset values if they have been edited
                if ($row.find('.inv-product-no').text() !== $row.data('original-product-no')) {
                    $row.find('.inv-product-no').text($row.data('original-product-no'));
                }
                if ($row.find('.inv-product-qty').text() !== $row.data('original-qty')) {
                    $row.find('.inv-product-qty').text($row.data('original-qty'));
                }
            });
        });
    });


</script>



@endsection