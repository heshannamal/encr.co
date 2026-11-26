@extends('layouts.app', ['activePage' => 'payment_ledger', 'titlePage' => __('Payment Ledger')])

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
.table-container {
    max-width: 100%;
    overflow-x: hidden; /* Prevent horizontal scrolling in the outer container */
}

.dataTables-search,
.dataTables-pagination {
    background-color: #f9f9f9;
    padding: 10px;
}

.table-scrollable {
    max-height: 300px; /* Adjust vertical height as needed */
    overflow-y: auto;  /* Enable vertical scrolling */
    overflow-x: auto;  /* Enable horizontal scrolling */
    width: 100%;       /* Ensure full width for horizontal scroll */
    white-space: nowrap; /* Prevent text wrapping for horizontal scrolling */
}

.table-scrollable table {
    width: 100%;       /* Make table full width */
    table-layout: fixed; /* Ensures columns resize within scrollable area */
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
    #payMultipleModal .table td {
        padding: .5rem 1.5rem;
        height: 2rem;
    }
    .hard-top-border{
        border-top: double #e9ecef !important;
    }
    .no-top-border{
        border-top: none !important;
    }

    /* =====================================================================
       PAYMENT LEDGER — MOBILE LAYOUT
       ===================================================================== */
    .pl-m-only { display: none; }

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
        .pl-m-header {
            display: block;
            margin: 4px 0 18px;
        }
        .pl-m-back {
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
        .pl-m-back i { font-size: 11px; }
        .pl-m-title {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            line-height: 1.25;
            color: #111827;
        }

        /* ---------- DataTables wrapper ---------- */
        #payment_ledger_wrapper > .row { margin-left: 0; margin-right: 0; }
        #payment_ledger_wrapper > .row > [class*="col-"] { padding-left: 0; padding-right: 0; }
        #payment_ledger_wrapper .dataTables_length { display: none !important; }
        /* scrollX: hide the cloned header, let the body flow as cards */
        #payment_ledger_wrapper .dataTables_scrollHead { display: none !important; }
        #payment_ledger_wrapper .dataTables_scroll,
        #payment_ledger_wrapper .dataTables_scrollBody {
            overflow: visible !important;
            width: 100% !important;
            height: auto !important;
            border: none !important;
        }

        /* ---------- Search card ---------- */
        #payment_ledger_wrapper .dataTables_filter {
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
        #payment_ledger_wrapper .dataTables_filter label {
            position: relative;
            display: block;
            width: 100%;
            margin: 0;
            font-size: 0;                            /* only the icon + input are shown */
        }
        #payment_ledger_wrapper .dataTables_filter label i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: #111827;
            pointer-events: none;
        }
        #payment_ledger_wrapper .dataTables_filter input {
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
        #payment_ledger_wrapper .dataTables_filter input::placeholder { color: #9ca3af; }


        /* ---------- Financial year card ---------- */
        .content-position > .col-md-12 > .card > .pl-year-col {
            margin: 0 0 14px !important;             /* inline mt-3 */
            padding: 14px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(17, 24, 39, 0.06);
            font-size: 0;                            /* "Select Financial Year" label: the select shows the year */
        }
        #financial_year {
            display: block;
            width: 100%;
            height: 44px;
            padding: 0 32px 0 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #f5f6f7 url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12'%3E%3Cpath d='M2.5 4.5 6 8l3.5-3.5' fill='none' stroke='%23374151' stroke-width='1.6' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") no-repeat right 12px center / 12px 12px;
            color: #111827;
            font-size: 15px;
            -webkit-appearance: none;
            appearance: none;
            outline: none;
        }
        #financial_year:focus { border-color: #47D6B6; }

        /* ---------- "Show [20] entries" / "Sort by [...]" ---------- */
        .pl-m-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin: 0 0 4px;
        }
        .pl-m-show {
            display: flex;
            align-items: center;
            gap: 6px;
            min-width: 0;
            font-size: 14px;
            color: #6b7280;
            white-space: nowrap;
        }
        .pl-m-show select {
            min-width: 0;
            height: 34px;
            padding: 0 24px 0 8px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12'%3E%3Cpath d='M2.5 4.5 6 8l3.5-3.5' fill='none' stroke='%23374151' stroke-width='1.6' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") no-repeat right 8px center / 11px 11px;
            color: #111827;
            font-size: 14px;
            font-weight: 500;
            text-overflow: ellipsis;
            -webkit-appearance: none;
            appearance: none;
        }
        #pl-m-entries { flex: 0 0 auto; }

        /* ---------- Table -> transaction cards ---------- */
        #payment_ledger {
            display: block;
            width: 100% !important;
            min-width: 0 !important;
            margin: 10px 0 0 !important;
            border: none;
        }
        #payment_ledger > thead { display: none; }
        #payment_ledger > tbody { display: block; width: 100%; }

        /* ENCR000003 ............ Show Invoices
           description
           [Invoice Total] [Overpaid] [Total Paid]
           [Pay by Cash]   [Settle from Debit]
           - - - - - - - - - - - - - - - - - -
           Transaction Date .. Transaction Time */
        #payment_ledger > tbody > tr {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            grid-template-areas:
                "id   id   id   id   inv  inv"
                "desc desc desc desc desc desc"
                "tot  tot  ovr  ovr  paid paid"
                "cash cash cash dbt  dbt  dbt"
                "line line line line line line"
                "date date date time time time";
            column-gap: 10px;
            margin-bottom: 14px;
            padding: 16px 16px 14px;
            background: #fff !important;
            border: 1px solid #f0f1f3 !important;
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(17, 24, 39, 0.06);
        }
        #payment_ledger > tbody > tr:hover { background: #fff !important; }
        #payment_ledger > tbody > tr > td {
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
        #payment_ledger > tbody > tr > td a { padding: 0 !important; }       /* page rule: .4rem 1rem !important */

        /* Transaction id (still opens the transaction image) */
        #payment_ledger > tbody > tr > td.transaction-id { grid-area: id; align-self: center; }
        #payment_ledger > tbody > tr > td.transaction-id a {
            font-size: 18px !important;
            font-weight: 700;
            line-height: 1.3;
            color: #111827 !important;
            text-decoration: none;
        }
        /* "Show invoices" button -> document icon + underlined "Show Invoices" */
        #payment_ledger > tbody > tr > td.included-invoiced { grid-area: inv; justify-self: end; align-self: center; }
        #payment_ledger > tbody > tr > td.included-invoiced button {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin: 0;
            padding: 2px 0;
            border: none;
            background: transparent url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23111827' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z'/%3E%3Cpath d='M14 2v6h6M8 13h8M8 17h8'/%3E%3C/svg%3E") no-repeat left center / 17px 17px;
            padding-left: 23px;
            color: #111827;
            font-size: 0;                            /* desktop wording replaced below */
            white-space: nowrap;
            cursor: pointer;
        }
        #payment_ledger > tbody > tr > td.included-invoiced button::after {
            content: "Show Invoices";
            font-size: 12.5px;
            text-decoration: underline;
        }
        /* Description line */
        #payment_ledger > tbody > tr > td.transaction-description {
            grid-area: desc;
            margin-top: 4px;
            font-size: 11.5px !important;
            line-height: 1.45;
            color: #6b7280 !important;
        }
        #payment_ledger > tbody > tr > td.transaction-description:empty { display: none; }

        /* Amount boxes */
        #payment_ledger > tbody > tr > td.invoice-total     { grid-area: tot; }
        #payment_ledger > tbody > tr > td.overpaid          { grid-area: ovr; }
        #payment_ledger > tbody > tr > td.total-paid-amount { grid-area: paid; }
        #payment_ledger > tbody > tr > td.pay-by-cash       { grid-area: cash; }
        #payment_ledger > tbody > tr > td.setle-from-debit  { grid-area: dbt; }
        #payment_ledger > tbody > tr > td.invoice-total,
        #payment_ledger > tbody > tr > td.overpaid,
        #payment_ledger > tbody > tr > td.total-paid-amount,
        #payment_ledger > tbody > tr > td.pay-by-cash,
        #payment_ledger > tbody > tr > td.setle-from-debit {
            display: flex;
            flex-wrap: wrap;
            align-content: flex-start;
            margin-top: 10px;
            padding: 6px 8px 7px !important;
            background: #f3f4f6;
            border-radius: 8px;
            font-size: clamp(13px, 3.9vw, 15px) !important;
            line-height: 1.35;
        }
        #payment_ledger > tbody > tr > td.invoice-total::before,
        #payment_ledger > tbody > tr > td.overpaid::before,
        #payment_ledger > tbody > tr > td.total-paid-amount::before,
        #payment_ledger > tbody > tr > td.pay-by-cash::before,
        #payment_ledger > tbody > tr > td.setle-from-debit::before {
            order: -2;
            flex: 0 0 100%;
            margin-bottom: 1px;
            font-size: clamp(11.5px, 3.4vw, 13.5px);
            color: #8a8f98;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        #payment_ledger > tbody > tr > td.invoice-total::before     { content: "Invoice Total"; }
        #payment_ledger > tbody > tr > td.overpaid::before          { content: "Overpaid"; }
        #payment_ledger > tbody > tr > td.total-paid-amount::before { content: "Total Paid"; }
        #payment_ledger > tbody > tr > td.pay-by-cash::before       { content: "Pay by Cash"; }
        #payment_ledger > tbody > tr > td.setle-from-debit::before  { content: "Settle from Debit"; }
        #payment_ledger > tbody > tr > td.invoice-total::after,
        #payment_ledger > tbody > tr > td.overpaid::after,
        #payment_ledger > tbody > tr > td.total-paid-amount::after,
        #payment_ledger > tbody > tr > td.pay-by-cash::after,
        #payment_ledger > tbody > tr > td.setle-from-debit::after { content: "$"; order: -1; }

        /* Dashed divider, then Transaction Date / Transaction Time */
        #payment_ledger > tbody > tr::after {
            content: "";
            grid-area: line;
            height: 0;
            margin-top: 12px;
            border-top: 1px dashed #e5e7eb;
        }
        #payment_ledger > tbody > tr > td.transaction-date { grid-area: date; }
        #payment_ledger > tbody > tr > td.transaction-time { grid-area: time; justify-self: end; }
        #payment_ledger > tbody > tr > td.transaction-date,
        #payment_ledger > tbody > tr > td.transaction-time {
            margin-top: 10px;
            font-size: 12px !important;
            font-weight: 600;
            white-space: nowrap;
        }
        #payment_ledger > tbody > tr > td.transaction-date::before,
        #payment_ledger > tbody > tr > td.transaction-time::before {
            margin-right: 6px;
            font-weight: 400;
            color: #8a8f98;
        }
        #payment_ledger > tbody > tr > td.transaction-date::before { content: "Transaction Date"; }
        #payment_ledger > tbody > tr > td.transaction-time::before { content: "Transaction Time"; }

        /* "No data available" row */
        #payment_ledger > tbody > tr:has(> td.dataTables_empty) { display: block; }
        #payment_ledger > tbody > tr:has(> td.dataTables_empty)::after { display: none; }
        #payment_ledger > tbody > tr > td.dataTables_empty {
            padding: 6px 0 !important;
            font-size: 14px !important;
            text-align: center !important;
            color: #6b7280 !important;
        }

        /* ---------- Pager ---------- */
        #payment_ledger_wrapper > .row:last-child {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-top: 6px;
        }
        #payment_ledger_wrapper > .row:last-child > [class*="col-"] {
            flex: 0 1 auto;
            width: auto;
            max-width: none;
        }
        #payment_ledger_wrapper .dataTables_info {
            padding: 0 !important;
            font-size: 13px;
            color: #9ca3af;
            white-space: normal;
        }
        #payment_ledger_wrapper .dataTables_paginate { margin: 0 !important; }
        #payment_ledger_wrapper .pagination {
            flex-wrap: wrap;
            justify-content: flex-end !important;
            gap: 6px;
            margin: 0 !important;
        }
        #payment_ledger_wrapper .page-item .page-link {
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
        #payment_ledger_wrapper .page-item.active .page-link {
            background: #111827;
            border-color: #111827;
            color: #fff;
        }
        #payment_ledger_wrapper .page-item.disabled .page-link { color: #9ca3af; }
        #payment_ledger_wrapper .page-item.previous .page-link,
        #payment_ledger_wrapper .page-item.next .page-link { font-size: 0; }
        #payment_ledger_wrapper .page-item.previous .page-link::before,
        #payment_ledger_wrapper .page-item.next .page-link::before {
            font-size: 20px;
            line-height: 1;
        }
        #payment_ledger_wrapper .page-item.previous .page-link::before { content: "\2039"; }
        #payment_ledger_wrapper .page-item.next .page-link::before     { content: "\203A"; }



        /* =================================================================
           "Transaction - ENCR000003" popup (included invoices)
           ================================================================= */
        #payMultipleModal .modal-dialog,
        #imageModal .modal-dialog {
            display: flex;
            align-items: center;
            max-width: none !important;              /* inline max-width: 1200px */
            min-height: calc(100% - 24px);
            margin: 12px;
        }
        #payMultipleModal .modal-content,
        #imageModal .modal-content {
            width: 100%;
            border: none;
            border-radius: 16px;
            overflow: hidden;
        }
        #payMultipleModal .modal-header,
        #imageModal .modal-header {
            align-items: center;
            margin: 0 18px;
            padding: 18px 0 14px;
            border-bottom: 1px solid #e5e7eb;
        }
        #payMultipleModal .modal-title,
        #imageModal .modal-title {
            font-size: 19px !important;              /* inline 1.2rem */
            font-weight: 700;
            line-height: 1.3;
            color: #111827;
            overflow-wrap: anywhere;
        }
        /* "TRANSACTION - " -> "Transaction - " (the id itself is the span) */
        #payMultipleModal #payMultipleModalLabel { font-size: 0 !important; }
        #payMultipleModal #payMultipleModalLabel::before { content: "Transaction - "; font-size: 19px; }
        #payMultipleModal #payMultipleModalLabel #transaction_id_span { font-size: 19px; }
        #payMultipleModal .modal-header .close,
        #imageModal .modal-header .close { margin: 0 0 0 12px; padding: 0 2px; opacity: 1; }
        #payMultipleModal .modal-header .close span,
        #imageModal .modal-header .close span { font-size: 26px; font-weight: 300; color: #111827; }
        /* The design closes with the "x" only */
        #payMultipleModal .modal-footer,
        #imageModal .modal-footer { display: none; }

        #payMultipleModal .modal-body {
            max-height: calc(100vh - 110px);
            overflow-y: auto;
            padding: 14px 18px 16px !important;
        }
        #payMultipleModal .modal-body > .table { display: block; width: 100%; margin: 0; }
        #payMultipleModal .modal-body > .table > thead { display: none; }
        #payMultipleModal #selectedInvoiceTr { display: block; }
        #payMultipleModal .table td {
            display: block;
            height: auto;                            /* page rule: 2rem */
            min-width: 0;
            padding: 0 !important;
            border: none !important;
            text-align: left !important;
            font-size: 13px;
            color: #111827;
            white-space: normal;
            overflow-wrap: anywhere;
        }
        /* Invoice card */
        #selectedInvoiceTr > tr:not(:last-child) {
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
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(1) { order: 1; flex: 1 1 auto; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(1) a {
            color: #111827;
            font-size: 17px;
            font-weight: 700;
            text-decoration: none;
        }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(6) { order: 2; flex: 0 0 auto; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(2) { order: 3; flex: 0 0 100%; margin-top: 2px; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(2) a {
            color: #111827;
            font-size: 15px;
            text-decoration: none;
        }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(2) a::before { content: "Order ID - "; }
        /* Order number with leading zeros (#002574), set by JS in data-m-order */
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(2) a[data-m-order] { font-size: 0; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(2) a[data-m-order]::before { font-size: 15px; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(2) a[data-m-order]::after { content: attr(data-m-order); font-size: 15px; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(3) { order: 4; flex: 0 0 100%; margin-top: 3px; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(3)::before { content: "Organization"; margin-right: 10px; color: #8a8f98; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(4) { order: 5; flex: 1 1 auto; margin-top: 6px; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(5) { order: 6; flex: 0 0 auto; margin-top: 6px; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(4)::before { content: "Total Amount"; margin-right: 10px; color: #8a8f98; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(5)::before { content: "Paid Amount"; margin-right: 10px; color: #8a8f98; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(4),
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(5) { display: flex; }
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(4)::before,
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(5)::before { order: -2; }
        /* "$" before the amounts (the cell holds the plain number) */
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(4)::after,
        #selectedInvoiceTr > tr:not(:last-child) > td:nth-child(5)::after { content: "$"; order: -1; }
        /* Download button -> icon + underlined "Export" (still downloads the PDF) */
        #selectedInvoiceTr .download_invoice_pdf {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin: 0;
            padding: 0 !important;                   /* inline .2rem .5rem */
            border: none;
            background: transparent;
            box-shadow: none;
            color: #111827;
            font-size: 16px;
            line-height: 1;
        }
        #selectedInvoiceTr .download_invoice_pdf::after {
            content: "Export";
            font-size: 12.5px;
            text-decoration: underline;
        }
        /* Last row = "Paid Invoice Amount ...... $27732.00" */
        #selectedInvoiceTr > tr:last-child {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 6px 14px 0;
        }
        #selectedInvoiceTr > tr:last-child > td:nth-child(-n+3) { display: none; }
        #selectedInvoiceTr > tr:last-child > td:nth-child(4) {
            font-size: 0;
            font-weight: 400 !important;             /* inline 800 */
        }
        #selectedInvoiceTr > tr:last-child > td:nth-child(4)::after { content: "Paid Invoice Amount"; font-size: 14px; color: #6b7280; }
        #selectedInvoiceTr > tr:last-child > td:nth-child(5) { display: flex; font-size: 15px; font-weight: 700; }
        #selectedInvoiceTr > tr:last-child > td:nth-child(5)::before { content: "$"; }

        /* =================================================================
           "Transaction Image #ENCR000003" popup
           ================================================================= */
        #imageModal .modal-body {
            margin: 14px 18px 18px;
            padding: 16px !important;
            background: #f3f4f6;
            border-radius: 12px;
        }
        #imageModal #transactionImage {
            display: block;
            max-width: 100%;
            max-height: calc(100vh - 220px);
            margin: 0 auto;
            border-radius: 6px;
            object-fit: contain;
        }
    }

    /* Very small phones (320px - 359px) */
    @media (max-width: 359px) {
        .content-position {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }
        .pl-m-show, .pl-m-show select { font-size: 12.5px; }
        .pl-m-show { gap: 6px; }
        .pl-m-show select { padding: 0 22px 0 8px; background-position: right 7px center; }
        #payment_ledger > tbody > tr { padding: 14px 12px 12px; column-gap: 8px; }
        #payment_ledger > tbody > tr > td.invoice-total,
        #payment_ledger > tbody > tr > td.overpaid,
        #payment_ledger > tbody > tr > td.total-paid-amount,
        #payment_ledger > tbody > tr > td.pay-by-cash,
        #payment_ledger > tbody > tr > td.setle-from-debit { padding: 5px 6px 6px !important; }
        #payment_ledger > tbody > tr > td.transaction-date,
        #payment_ledger > tbody > tr > td.transaction-time { font-size: 11px !important; }
        /* Date / time: label above the value so both fit side by side */
        #payment_ledger > tbody > tr > td.transaction-date::before,
        #payment_ledger > tbody > tr > td.transaction-time::before { display: block; margin: 0 0 1px; }
        #payment_ledger > tbody > tr > td.transaction-time { text-align: right !important; }
        #pl-m-toolbar .pl-m-show:first-child > span:last-child { display: none; }   /* "entries": no room */
        #payMultipleModal .modal-dialog, #imageModal .modal-dialog { margin: 8px; min-height: calc(100% - 16px); }
        #payMultipleModal .modal-header, #imageModal .modal-header { margin: 0 14px; }
        #payMultipleModal .modal-body { padding-left: 14px !important; padding-right: 14px !important; }
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
        <span>PAYMENT LEDGER</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    {{-- Mobile only: page header --}}
    <div class="pl-m-only pl-m-header">
        {{-- <a href="{{ route('home') }}" class="pl-m-back"><i class="fa fa-chevron-left"></i> BACK TO HOME</a> --}}
        <h1 class="pl-m-title">Payment Ledger</h1>
    </div>

    {{-- Mobile only: "Show [n] entries" + "Sort by" (moved under the search box by JS) --}}
    <div class="pl-m-only pl-m-toolbar" id="pl-m-toolbar">
        <div class="pl-m-show">
            <span>Show</span>
            <select id="pl-m-entries">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span>entries</span>
        </div>
        <div class="pl-m-show">
            <span>Sort by</span>
            <select id="pl-m-sort">
                <option value="default">Transaction ID</option>
                <option value="date_desc">Newest First</option>
                <option value="date_asc">Oldest First</option>
                <option value="paid_desc">Total Paid</option>
            </select>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
                <div class="col-md-12 mt-3 pl-year-col">
                    <span>Select Financial Year &nbsp;<span>
                        <select id="financial_year" name="financial_year">
                            @foreach($yearList as $year)
                                <option value="{{ $year }}" {{ isset($financial_year) && $financial_year == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="col-md-12 mt-3 mb-3 new-style-table">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="payment_ledger">
                            <thead>
                                <tr>
                                    <th scope="col" class="transaction-id">Transaction id</th>
                                    <th scope="col" class="invoice-total">Invoice total</th>
                                    <th scope="col" class="pay-by-cash">Pay by cash</th>
                                    <th scope="col" class="setle-from-debit">Settle from debit</th>
                                    <th scope="col" class="overpaid">Overpaid</th>
                                    <th scope="col" class="total-paid-amount">Total paid amount</th>
                                    <th scope="col" class="included-invoiced">Included invoices</th>
                                    <th scope="col" class="transaction-description">Description</th>
                                    <th scope="col" class="transaction-date">Transaction date</th>
                                    <th scope="col" class="transaction-time">Transaction time</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($Transactions as $Transaction)
                                    <tr>
                                        <td class="transaction-id">
                                            <a href="javascript:void(0);" class="show-image"
                                               data-image-url="{{ $Transaction->image_url ? url('public/' . $Transaction->image_url) : asset('assets/img/products/product defaul image.jpg') }}"
                                               data-transaction-id="{{ $Transaction->transaction_id }}">
                                                {{ $Transaction->transaction_id }}
                                            </a>
                                        </td>
                                        <td class="invoice-total text-right">{{$Transaction->invoice_total}}</td>
                                        <td class="pay-by-cash text-right">{{$Transaction->cash_amount}}</td>
                                        <td class="setle-from-debit text-right">{{$Transaction->debit_amount}}</td>
                                        <td class="overpaid text-right">{{ $Transaction->paid_amount - $Transaction->invoice_total > 0 ? number_format($Transaction->paid_amount - $Transaction->invoice_total, 2) : '0.00' }}</td>
                                        <td class="total-paid-amount text-right">{{$Transaction->paid_amount}}</td>
                                        <td class="included-invoiced text-center"><button type="button" onclick="showIncludedInvoices([{{$Transaction->invoice_ids}}], '{{ $Transaction->transaction_id }}')">Show invoices</button></td>
                                        <td class="transaction-description">{{ $Transaction->payment_description }}</td>
                                        <td class="transaction-date text-center" data-order="{{ $Transaction->created_at->format('Y-m-d H:i:s') }}">{{ $Transaction->created_at->format('m/d/Y') }}</td>
                                        <td class="transaction-time text-center">{{ $Transaction->created_at->format('H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>

@include('pages.accounting.generate_invoice.create')

<!-- Pay multile modal -->
<div class="modal fade" id="payMultipleModal" tabindex="-1" role="dialog" aria-labelledby="payMultipleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="max-width: 1200px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payMultipleModalLabel" style="font-size: 1.2rem;">TRANSACTION - <span id="transaction_id_span"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                @csrf
                <div class="modal-body">
                    <table class="table align-items-center ml-auto">
                        <thead style="background-color: grey;color: white;">
                            <th scope="col" class="text-center">Invoice Number</th>
                            <th scope="col" class="text-center">Order Number</th>
                            <th scope="col" class="text-center">Organization Name</th>
                            <th scope="col" class="text-center">Total amount</th>
                            <th scope="col" class="text-center">Paid amount</th>
                            <th scope="col" class="text-center">Action</th>
                        </thead>
                        <tbody id="selectedInvoiceTr">

                        </tbody>
                        {{-- <tbody class="no-top-border">
                            <tr>
                                <td class="no-top-border" colspan="3">
                                </td>
                                <td class="text-right no-top-border" style="font-weight:800">Cash:  </td>
                                <td class="no-top-border">
                                    <input type="text" name="transaction_amount_cash" id="transaction_amount_cash" value="" class="form-control text-right" style="font-weight:800" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td class="no-top-border" colspan="3" id="debit_acc_summary_line_1"></td>
                                <td class="text-right no-top-border" style="font-weight:800">Settle from Debit:  </td>
                                <td class="no-top-border">
                                    <input type="text" id="transaction_amount_debit" value="" class="form-control text-right" style="font-weight:800" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td class="no-top-border" colspan="3" id="debit_acc_summary_line_2"></td>
                                <td class="text-right no-top-border" style="font-weight:800;font-size: 1rem;">Total payment:  </td>
                                <td class="no-top-border">
                                    <input type="text" id="total_sum_of_payment" value="" class="form-control text-right" style="font-weight:800;" readonly>
                                </td>
                            </tr>
                        </tbody> --}}
                    </table>
                    {{-- <div class="col-md-12">
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
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="imageModalLabel" style="font-size: 1.2rem;">Transaction Image</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          <img id="transactionImage" src="" alt="Transaction Image" style="max-width: 100%; height: auto;">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


<script>

$(document).ready(function () {

    var payment_ledger = $('#payment_ledger').DataTable({
            colReorder: false,
            scrollX: true,
            stateSave: true,
            "autoWidth": true,
            "pageLength": 50,
            "bSort" : false,
            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'Transaction Search'
            }
        });

    /* ---------------- MOBILE-ONLY HELPERS ----------------*/
    try {
        var plMobileQuery = window.matchMedia('(max-width: 767px)');
        var isPlMobile = function () { return plMobileQuery.matches; };

        if (isPlMobile()) {
            // stateSave is on: keep the saved (desktop) page length out of the mobile view
            var plSaved = payment_ledger.state.loaded();
            var plDesktopLen = plSaved && plSaved.length ? plSaved.length : 50;
            payment_ledger.on('stateSaveParams.dt', function (e, settings, data) {
                if (isPlMobile()) { data.length = plDesktopLen; }
            });

            $('#pl-m-toolbar').insertAfter($('#payment_ledger_wrapper .dataTables_filter'));
            $('#payment_ledger_filter input').attr('placeholder', 'Search by transaction ID');
            payment_ledger.page.len(20).draw();
        }
        (function () {
            var len = String(payment_ledger.page.len());
            if (!$('#pl-m-entries option[value="' + len + '"]').length) {
                $('#pl-m-entries').append($('<option>', { value: len, text: len }));
            }
            $('#pl-m-entries').val(len);
        })();
        $('#pl-m-entries').on('change', function () {
            payment_ledger.page.len(parseInt(this.value, 10)).draw();
        });

        // Sort by: the table is created with sorting off (bSort: false); switch it on
        // only for this call. "Transaction ID" = the order the server sent.
        var plOriginalOrder = payment_ledger.settings()[0].aiDisplayMaster.slice();
        $('#pl-m-sort').on('change', function () {
            var settings = payment_ledger.settings()[0];
            var map = { date_desc: [[8, 'desc']], date_asc: [[8, 'asc']], paid_desc: [[5, 'desc']] };
            if (map[this.value]) {
                settings.oFeatures.bSort = true;
                payment_ledger.order(map[this.value]).draw();
                settings.oFeatures.bSort = false;
            } else {
                // back to the order the server sent
                settings.aaSorting = [];
                settings.aiDisplayMaster = plOriginalOrder.slice();
                payment_ledger.draw();
            }
        });

        // Popup: order number with leading zeros like the list (#2574 -> #002574)
        $('#payMultipleModal').on('show.bs.modal', function () {
            $('#selectedInvoiceTr > tr > td:nth-child(2) a').each(function () {
                var n = $.trim($(this).text()).replace(/^#/, '');
                if (/^\d+$/.test(n)) { this.setAttribute('data-m-order', '#' + ('000000' + n).slice(-Math.max(6, n.length))); }
            });
        });

        // Place the page header 16px below the layout's fixed mobile bar(s).
        var fixPlHeaderOffset = function () {
            var top = document.querySelector('.pl-m-header');
            var nav = document.getElementById('sidenav-main');
            if (!top) return;
            top.style.marginTop = '';
            if (!isPlMobile() || !nav || getComputedStyle(nav).position !== 'fixed') return;
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
        fixPlHeaderOffset();
        setTimeout(fixPlHeaderOffset, 350);
        setTimeout(fixPlHeaderOffset, 1300);
        $(window).on('load', fixPlHeaderOffset);
        var plResizeTimer;
        $(window).on('resize', function () {
            clearTimeout(plResizeTimer);
            plResizeTimer = setTimeout(fixPlHeaderOffset, 150);
        });
    } catch (plErr) {
        if (window.console) console.error('Payment ledger mobile view:', plErr);
    }
    /* -------------------------------------------------------------------- */
});

$(document).ready(function() {
    $("#financial_year").change(function() {
        $(".se-pre-con").fadeIn('slow');
        var selectedYear = $(this).val();
        var baseUrl = "{{ url('/') }}";
        window.location.href = baseUrl + "/payment_ledger?financial_year=" + selectedYear;
    });
});

$(document).ready(function() {
    $('.show-image').click(function() {
        var imageUrl = $(this).data('image-url');
        var transactionId = $(this).data('transaction-id');

        $('#transactionImage').attr('src', imageUrl);

        $('#imageModalLabel').text('Transaction Image #' + transactionId);

        $('#imageModal').modal('show');
    });
});

function showIncludedInvoices(arrayData, transaction_id){
    $(".se-pre-con").fadeIn('slow');

    var invoiceArray = arrayData;

    $.ajax({
        url:"{{ route('get_multiple_invoice_details') }}",
        type: "POST",
        data: {
            'invoices': invoiceArray,
            'transaction_id': transaction_id,
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

            console.log(data.transaction);

            if (invoices && invoices.length > 0) {
                var totalAmount = 0.00;
                invoices.forEach(function(invoice) {

                    var transactionPaidAmount = data.transaction.paid_details.find(
                        (detail) => detail.invoice_id === invoice.id
                    );

                    var paidAmount = transactionPaidAmount ? transactionPaidAmount.paid_amount : invoice.paid_amount;

                    var totalAmountFormatted = parseFloat(invoice.total_amount).toFixed(2);
                    var paidAmountFormatted = parseFloat(paidAmount).toFixed(2);

                    let organizationName = invoice.order_details.organization_details.organization_name;
                    if (organizationName.length > 50) {
                        organizationName = organizationName.substring(0, 40) + '...';
                    }

                    var baseOrderUrl = "{{ route('orders.info', ['id' => 'ORDER_ID', 'type' => 'order']) }}";

                    var row = `
                        <tr>
                            <td class="text-center"><a href="#" class="edit" data-value="${invoice.id}">${invoice.invoice_number}</a></td>
                            <td class="text-center">
                                <a href="${baseOrderUrl.replace('ORDER_ID', invoice.order_id)}?active_tab=order" target="_blank">
                                    #${invoice.order_id}
                                </a>
                            </td>
                            <td class="text-left">${organizationName}</td>
                            <td class="text-right">${totalAmountFormatted}</td>
                            <td class="text-right">${paidAmountFormatted}</td>
                            <td class="text-center"><button class="btn download_invoice_pdf" style="padding: 0.2rem .5rem" data-value="${invoice.id}"><i class="fa fa-download" aria-hidden="true"></i></button></td>
                        </tr>
                    `;
                    $('#selectedInvoiceTr').append(row);

                    totalAmount += parseFloat(paidAmount);
                });

                    var totalRow = `
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right" style="font-weight:800">Paid invoice total : </td>
                                        <td class="text-right">
                                            ${parseFloat(totalAmount).toFixed(2)}
                                        </td>
                                    </tr>
                                `;
                    $('#selectedInvoiceTr').append(totalRow);

                    $('#payMultipleModal').modal('show');
            }
            if (data.transaction){
                $('#transaction_id_span').text(data.transaction.transaction_id);
                // $('#transaction_amount_cash').val(data.transaction.cash_amount);
                // $('#transaction_amount_debit').val(data.transaction.debit_amount);
                // $('#total_sum_of_payment').val(data.transaction.paid_amount);
            }
        }
    });

    $(".se-pre-con").fadeOut('slow');
}
    $(document).on('click', '.edit', function (event) {
        event.preventDefault();

        var invoiceId = $(this).data('value');

        $(".se-pre-con").fadeIn('slow');
        $('.frm_submit_btn').text('Request Payment');

        $('#new_invoice_no').val(invoiceId);
        $('#generate_invoice').attr('data-selected-invoice-id', invoiceId);

        get_invoice_data(invoiceId, true);
    });
    $(document).on('click', '.download_invoice_pdf', function (event) {
        event.preventDefault();

        var invoiceId = $(this).data('value');

        get_invoice_data(invoiceId, false);

        $(".se-pre-con").fadeIn('slow');
    });
    function get_invoice_data(invoiceId, displayModal) {
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

                // Set form action and display modal
                $('#invoice_form').attr('action', `create_factory_invoice`);
                // $('#generate_invoice').modal('show');
            },
            complete: function () {
                // $(".se-pre-con").fadeOut('slow');
                $('#frm_submit_btn_save').hide();
                $('#frm_submit_btn').hide();
                $('#order_number').attr('disabled', true);
                if (!displayModal) {
                    setTimeout(function() {
                        $('#download-pdf-btn').click();
                        $('#generate_invoice').modal('hide');
                    }, 1000);
                }
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


</script>



@endsection