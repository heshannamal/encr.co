@extends('layouts.app', ['activePage' => 'debit_account', 'titlePage' => __('Debit Account')])

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
    .btn-green-filled {
        outline: unset !important;
        width: fit-content;
        padding: .5rem 1rem;
        color: white;
        background-color: #47D6B6;
        border: 2px solid #47D6B6;
        font-weight: 700;
        font-size: .7rem;
        cursor: pointer;
    }

    /* =====================================================================
       DEBIT ACCOUNT — MOBILE LAYOUT 
       ===================================================================== */
    .da-m-only { display: none; }

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
        .da-m-header {
            display: block;
            margin: 4px 0 18px;
        }
        .da-m-back {
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
        .da-m-back i { font-size: 11px; }
        .da-m-title-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .da-m-add {
            display: inline-flex;
            flex: 0 0 auto;
            align-items: center;
            gap: 8px;
            height: 40px;
            padding: 0 16px;
            border: none;
            border-radius: 8px;
            background: #47D6B6;
            box-shadow: 0 4px 12px rgba(71, 214, 182, 0.35);
            color: #fff;
            font-size: 15px;
            font-weight: 500;
        }
        .da-m-add i { font-size: 13px; }
        .da-m-title {
            margin: 0;
            min-width: 0;
            font-size: 20px;
            font-weight: 700;
            line-height: 1.25;
            color: #111827;
        }

        /* ---------- DataTables wrapper ---------- */
        #debit_account_table_wrapper > .row { margin-left: 0; margin-right: 0; }
        #debit_account_table_wrapper > .row > [class*="col-"] { padding-left: 0; padding-right: 0; }
        #debit_account_table_wrapper .dataTables_length { display: none !important; }
        /* scrollX: hide the cloned header, let the body flow as cards */
        #debit_account_table_wrapper .dataTables_scrollHead { display: none !important; }
        #debit_account_table_wrapper .dataTables_scroll,
        #debit_account_table_wrapper .dataTables_scrollBody {
            overflow: visible !important;
            width: 100% !important;
            height: auto !important;
            border: none !important;
        }

        /* ---------- Search card ---------- */
        #debit_account_table_wrapper .dataTables_filter {
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
        #debit_account_table_wrapper .dataTables_filter label {
            position: relative;
            display: block;
            width: 100%;
            margin: 0;
            font-size: 0;                            /* only the icon + input are shown */
        }
        #debit_account_table_wrapper .dataTables_filter label i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: #111827;
            pointer-events: none;
        }
        #debit_account_table_wrapper .dataTables_filter input {
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
        #debit_account_table_wrapper .dataTables_filter input::placeholder { color: #9ca3af; }


        .content-position > .col-md-12 > .card > .col-md-12 > .row { margin: 0; }
        .content-position .da-add-col { display: none; }   /* "Add Debit" sits in the page header on mobile */

        /* ---------- Financial year card ---------- */
        .content-position .da-year-col {
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
        .da-m-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin: 0 0 4px;
        }
        .da-m-show {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 0;
            font-size: 14px;
            color: #6b7280;
            white-space: nowrap;
        }
        .da-m-show select {
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


        /* ---------- Table -> debit cards ---------- */
        #debit_account_table {
            display: block;
            width: 100% !important;
            min-width: 0 !important;
            margin: 10px 0 0 !important;
            border: none;
        }
        #debit_account_table > thead { display: none; }
        #debit_account_table > tbody { display: block; width: 100%; }

        /* ENCR000013 ..................... +200
           [Current Value] [Pay For] [Created At]
           - - - - - - - - - - - - - - - - - - -
           Description / text */
        #debit_account_table > tbody > tr {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            grid-template-areas:
                "id   id   task"
                "cur  pay  date"
                "line line line"
                "desc desc desc";
            column-gap: 8px;
            margin-bottom: 14px;
            padding: 14px 16px 14px;
            background: #fff !important;
            border: 1px solid #f0f1f3 !important;
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(17, 24, 39, 0.06);
        }
        #debit_account_table > tbody > tr:hover { background: #fff !important; }
        #debit_account_table > tbody > tr > td {
            display: block;
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
        #debit_account_table > tbody > tr > td a { padding: 0 !important; }

        #debit_account_table > tbody > tr > td.transaction-id { grid-area: id; align-self: center; }
        #debit_account_table > tbody > tr > td.transaction-id a {
            font-size: 17px !important;
            font-weight: 700;
            line-height: 1.3;
            color: #111827 !important;
            text-decoration: none;
        }
        /* "+200" (green) / "-200" (red, set by JS in data-m-sign) */
        #debit_account_table > tbody > tr > td.debit-task {
            grid-area: task;
            justify-self: end;
            align-self: center;
            font-size: 15px !important;
            font-weight: 600;
            color: #3a9d23 !important;
            white-space: nowrap;
        }
        #debit_account_table > tbody > tr > td.debit-task * { color: inherit !important; font-size: inherit !important; }
        #debit_account_table > tbody > tr > td.debit-task[data-m-sign="minus"] { color: #e01e1e !important; }

        /* Boxes */
        #debit_account_table > tbody > tr > td.current-value { grid-area: cur; }
        #debit_account_table > tbody > tr > td.pay-for       { grid-area: pay; }
        #debit_account_table > tbody > tr > td.created-at    { grid-area: date; }
        #debit_account_table > tbody > tr > td.current-value,
        #debit_account_table > tbody > tr > td.pay-for,
        #debit_account_table > tbody > tr > td.created-at {
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
        #debit_account_table > tbody > tr > td.current-value::before,
        #debit_account_table > tbody > tr > td.pay-for::before,
        #debit_account_table > tbody > tr > td.created-at::before {
            order: -2;
            flex: 0 0 100%;
            margin-bottom: 1px;
            font-size: clamp(11.5px, 3.4vw, 13.5px);
            color: #8a8f98;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        #debit_account_table > tbody > tr > td.current-value::before { content: "Current Value"; }
        #debit_account_table > tbody > tr > td.pay-for::before       { content: "Pay For"; }
        #debit_account_table > tbody > tr > td.created-at::before    { content: "Created At"; }
        #debit_account_table > tbody > tr > td.current-value::after  { content: "$"; order: -1; }

        /* Dashed divider, then the description */
        #debit_account_table > tbody > tr::after {
            content: "";
            grid-area: line;
            height: 0;
            margin-top: 12px;
            border-top: 1px dashed #e5e7eb;
        }
        #debit_account_table > tbody > tr > td.debit-description {
            grid-area: desc;
            margin-top: 8px;
            font-size: 12.5px !important;
            line-height: 1.45;
        }
        #debit_account_table > tbody > tr > td.debit-description::before {
            content: "Description";
            display: block;
            margin-bottom: 1px;
            font-size: 11.5px;
            color: #8a8f98;
        }
        #debit_account_table > tbody > tr > td.debit-description:empty::after { content: "-"; }

        /* "No data available" row */
        #debit_account_table > tbody > tr:has(> td.dataTables_empty) { display: block; }
        #debit_account_table > tbody > tr:has(> td.dataTables_empty)::after { display: none; }
        #debit_account_table > tbody > tr > td.dataTables_empty {
            padding: 6px 0 !important;
            font-size: 14px !important;
            text-align: center !important;
            color: #6b7280 !important;
        }

        /* ---------- Pager ---------- */
        #debit_account_table_wrapper > .row:last-child {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-top: 6px;
        }
        #debit_account_table_wrapper > .row:last-child > [class*="col-"] {
            flex: 0 1 auto;
            width: auto;
            max-width: none;
        }
        #debit_account_table_wrapper .dataTables_info {
            padding: 0 !important;
            font-size: 13px;
            color: #9ca3af;
            white-space: normal;
        }
        #debit_account_table_wrapper .dataTables_paginate { margin: 0 !important; }
        #debit_account_table_wrapper .pagination {
            flex-wrap: wrap;
            justify-content: flex-end !important;
            gap: 6px;
            margin: 0 !important;
        }
        #debit_account_table_wrapper .page-item .page-link {
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
        #debit_account_table_wrapper .page-item.active .page-link {
            background: #111827;
            border-color: #111827;
            color: #fff;
        }
        #debit_account_table_wrapper .page-item.disabled .page-link { color: #9ca3af; }
        #debit_account_table_wrapper .page-item.previous .page-link,
        #debit_account_table_wrapper .page-item.next .page-link { font-size: 0; }
        #debit_account_table_wrapper .page-item.previous .page-link::before,
        #debit_account_table_wrapper .page-item.next .page-link::before {
            font-size: 20px;
            line-height: 1;
        }
        #debit_account_table_wrapper .page-item.previous .page-link::before { content: "\2039"; }
        #debit_account_table_wrapper .page-item.next .page-link::before     { content: "\203A"; }




        /* =================================================================
           "Add Debit" popup and "Transaction Image" popup
           ================================================================= */
        #debit_create_modal .modal-dialog,
        #imageModal .modal-dialog {
            display: flex;
            align-items: center;
            max-width: none;
            min-height: calc(100% - 24px);
            margin: 12px;
        }
        #debit_create_modal .modal-content,
        #imageModal .modal-content {
            width: 100%;
            border: none;
            border-radius: 16px;
            overflow: hidden;
        }
        #debit_create_modal .modal-header,
        #imageModal .modal-header {
            align-items: center;
            margin: 0 18px;
            padding: 18px 0 14px;
            border-bottom: 1px solid #e5e7eb;
        }
        #debit_create_modal .modal-header .modal-title,
        #imageModal .modal-title {
            font-size: 19px !important;              /* inline 1.2rem */
            font-weight: 700;
            line-height: 1.3;
            color: #111827;
            overflow-wrap: anywhere;
        }
        #debit_create_modal .modal-header .close,
        #imageModal .modal-header .close { margin: 0 0 0 12px; padding: 0 2px; opacity: 1; }
        #debit_create_modal .modal-header .close span,
        #imageModal .modal-header .close span { font-size: 26px; font-weight: 300; color: #111827; }

        /* Add Debit form */
        #debit_create_modal .modal-body {
            max-height: calc(100vh - 170px);
            overflow-y: auto;
            padding: 14px 18px 4px !important;
        }
        #debit_create_form > .modal-title {          /* "Current debit account balance = $..." */
            margin: 0;
            font-size: 14px;
            font-weight: 500;
            line-height: 1.4;
            color: #111827;
        }
        #debit_create_form .form-group { margin: 12px 0 0 !important; }
        #debit_create_form label {
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: 400;
            color: #374151;
        }
        #debit_create_form .form-control {
            height: 40px;
            padding: 0 12px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            background: #fff;
            box-shadow: none;
            color: #111827;
            font-size: 14px;
        }
        #debit_create_form textarea.form-control { height: 96px; padding: 10px 12px; resize: vertical; }
        #debit_create_form .form-control:focus { border-color: #47D6B6; }
        #debit_create_form .form-control[readonly],
        #debit_create_form .form-control:disabled { background: #fff; color: #6b7280; }
        /* "New debit account balance - $177645.31" on one line */
        #debit_create_form label[for="new_current_value"] { display: inline; margin: 0; font-weight: 500; color: #111827; }
        #debit_create_form label[for="new_current_value"]::after { content: " - $"; }
        #new_current_value_text { display: inline; margin: 0; font-size: 14px; font-weight: 500; color: #111827; }
        #debit_create_form .form-group:has(> #new_current_value_text) { font-size: 0; }   /* no gap between "$" and the number */
        /* Upload: the file input becomes the dashed drop area (still the real input) */
        #debit_create_form .form-group.mb-1 { position: relative; }
        #debit_create_form label[for="upload_image"] { font-size: 0; }
        #debit_create_form label[for="upload_image"]::after { content: "Upload Image for Payment Reference"; font-size: 14px; }
        #debit_create_form #upload_image {
            display: block;
            width: 100% !important;                  /* inline width: auto */
            height: 100px !important;
            padding: 0 !important;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #f5f6f7;
            color: transparent;
            font-size: 0;
            cursor: pointer;
        }
        #debit_create_form #upload_image::-webkit-file-upload-button { display: none; }
        #debit_create_form #upload_image::file-selector-button { display: none; }
        #debit_create_form .form-group.mb-1::after {
            content: "Click here to upload";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 26px;
            padding-top: 30px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z'/%3E%3Cpath d='M14 2v6h6M12 18v-6M9 15l3-3 3 3'/%3E%3C/svg%3E") no-repeat center top / 22px 22px;
            color: #374151;
            font-size: 13px;
            text-align: center;
            text-decoration: underline;
            pointer-events: none;
        }
        #debit_create_form #imagePreview { margin-top: 8px !important; }
        /* Footer: Close / Save Debit */
        #debit_create_modal .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            padding: 14px 18px 18px;
            border-top: none;
        }
        #debit_create_modal .modal-footer .btn {
            flex: 0 0 auto;
            min-width: 112px;
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
        #debit_create_modal .modal-footer .btn-secondary { background: #b3b3b3; color: #fff; }
        #debit_create_modal .modal-footer .btn-primary   { background: #47D6B6; color: #fff; }

        /* Transaction image */
        #imageModal .modal-footer { display: none; }   /* the design closes with the "x" */
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
        .da-m-title { font-size: 18px; }
        .da-m-add { height: 38px; padding: 0 12px; font-size: 14px; }
        #debit_account_table > tbody > tr { padding: 12px; column-gap: 6px; }
        #debit_account_table > tbody > tr > td.current-value,
        #debit_account_table > tbody > tr > td.pay-for,
        #debit_account_table > tbody > tr > td.created-at { padding: 5px 6px 6px !important; }
        #debit_create_modal .modal-dialog, #imageModal .modal-dialog { margin: 8px; min-height: calc(100% - 16px); }
        #debit_create_modal .modal-header, #imageModal .modal-header { margin: 0 14px; }
        #debit_create_modal .modal-body { padding-left: 14px !important; padding-right: 14px !important; }
        #debit_create_modal .modal-footer { padding-left: 14px; padding-right: 14px; }
    }
</style>

@if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    {{-- Mobile only: page header ("Add Debit" opens the same popup as the desktop button) --}}
    <div class="da-m-only da-m-header">
        {{-- <a href="{{ route('home') }}" class="da-m-back"><i class="fa fa-chevron-left"></i> BACK TO HOME</a> --}}
        <div class="da-m-title-row">
            <h1 class="da-m-title">Debit Account</h1>
            @can('add debit record')
                <button type="button" class="da-m-add" data-toggle="modal" data-target="#debit_create_modal" title="Add Debit"><i class="fa fa-plus"></i> Add Debit</button>
            @endcan
        </div>
    </div>

    <div class="da-m-only da-m-toolbar" id="da-m-toolbar">
        <div class="da-m-show">
            <span>Show</span>
            <select id="da-m-entries">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span>entries</span>
        </div>
    </div>


    <div class="col-md-12">
        <div class="card">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-9 mt-3 da-year-col">
                            <span>Select Financial Year &nbsp;<span>
                            <select id="financial_year" name="financial_year">
                                @foreach($yearList as $year)
                                    <option value="{{ $year }}" {{ isset($financial_year) && $financial_year == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        @can('add debit record')
                        <div class="col-md-3 mt-3 text-right da-add-col">
                            <button class="btn-green-filled ml-auto" style="outline: unset;" href="#" data-toggle="modal" data-target="#debit_create_modal" title="Add Debit">
                                Add Debit
                            </button>
                        </div>
                        @endcan
                    </div>
                </div>
                <div class="col-md-12 mt-3 mb-3 new-style-table">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="debit_account_table">
                            <thead>

                                <th scope="col" class="transaction-id">Transaction ID</th>
                                <th scope="col" class="debit-task">+ / -</th>
                                <th scope="col" class="current-value">Current Value</th>
                                <th scope="col" class="debit-description">Description</th>
                                <th scope="col" class="pay-for">Pay for</th>
                                <th scope="col" class="created-at">Created At</th>
                            </thead>

                            <tbody>
                                @foreach ($DebitAccountRecords as $DebitAccountRecord)
                                        <tr>
                                            <td class="transaction-id">
                                                <a href="javascript:void(0);" class="show-image"
                                                   data-image-url="{{ $DebitAccountRecord->image_url ? url('public/' . $DebitAccountRecord->image_url) : asset('assets/img/products/product defaul image.jpg') }}"
                                                   data-transaction-id="{{ $DebitAccountRecord->transaction_id }}">
                                                    {{ $DebitAccountRecord->transaction_id }}
                                                </a>
                                            </td>
                                            <td class="debit-task text-right">{!! $DebitAccountRecord->task !!}</td>
                                            <td class="current-value text-right">{{$DebitAccountRecord->current_value}}</td>
                                            <td class="debit-description">{{$DebitAccountRecord->description}}</td>
                                            <td class="pay-for">{{$DebitAccountRecord->pay_for ?? 'DWC'}}</td>
                                            <td class="created-at">{{ $DebitAccountRecord->created_at->format('m/d/Y') }}</td>
                                        </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>
<!-- Modal Structure -->
<div class="modal fade" id="debit_create_modal" tabindex="-1" role="dialog" aria-labelledby="debitCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="debitCreateModalLabel">Add Debit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="debit_create_form">
                    <h5 class="modal-title">Current debit account balance = ${{$currentDebitValue}}</h5>
                    <!-- Transaction ID -->
                    <div class="form-group mt-3">
                        <label for="transaction_id">Transaction ID</label>
                        <input type="text" class="form-control" id="transaction_id" value="{{$transactionID}}" name="transaction_id" readonly>
                    </div>

                    <!-- Amount -->
                    <div class="form-group">
                        <label for="payment_amount">Amount</label>
                        <input type="number" step="0.01" class="form-control" id="payment_amount" name="amount" required>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="3" required></textarea>
                    </div>

                    <!-- Pay for -->
                    <div class="form-group">
                        <label for="pay_for">Pay for</label>
                        <select class="form-control" name="pay_for" id="pay_for" disabled>
                            <option value="DWC" selected>DWC</option>
                        </select>
                    </div>

                    <!-- Current Value -->
                    <div class="form-group" style="display: none">
                        <label for="current_value">Current debit account</label>
                        <input type="number" step="0.01" class="form-control" id="current_value" value="{{$currentDebitValue}}" name="current_value" readonly>
                    </div>

                    <!-- New Current Value -->
                    <div class="form-group">
                        <label for="new_current_value">New debit account balance</label>
                        <p id="new_current_value_text">{{$currentDebitValue}}</p>
                        <input type="number" step="0.01" class="form-control" id="new_current_value" name="new_current_value" value="{{$currentDebitValue}}" style="display: none">
                    </div>

                    <div class="form-group mb-1 mt-3">
                        <label for="upload_image">Upload Image for payment reference</label>
                        <input type="file" id="upload_image" name="upload_image" accept="image/png, image/jpeg" class="form-control" style="width: auto;height: auto;" onchange="previewImage(event)">
                    </div>

                    <div class="form-group" id="imagePreview" style="display:none;">
                        <img id="uploaded_image" src="" alt="Uploaded Image" style="width: auto; height: 5rem;">
                        <button type="button" id="removeImage">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save_debit">Save Debit</button>
            </div>
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

@section('order-header')
    <span>DEBIT ACCOUNT - ${{$currentDebitValue}}</span>
@endsection

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('uploaded_image');
            output.src = reader.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    document.getElementById('removeImage').addEventListener('click', function() {
        document.getElementById('upload_image').value = '';
        document.getElementById('uploaded_image').src = '';
        document.getElementById('imagePreview').style.display = 'none';
    });
</script>

<script>

    $(document).ready(function () {

        var debit_account_table = $('#debit_account_table').DataTable({
                colReorder: false,
                stateSave: true,
                "autoWidth": false,
                "pageLength": 50,
                "bSort" : false,
                language: {
                    search: '<i class="fas fa-search"></i>',
                    searchPlaceholder: 'Debit Search'
                }
            });

        /* ---------------- MOBILE-ONLY HELPERS ----------------
           Display only. Wrapped in try/catch so a mobile problem can never stop the page. */
        try {
            var daMobileQuery = window.matchMedia('(max-width: 767px)');
            var isDaMobile = function () { return daMobileQuery.matches; };

            if (isDaMobile()) {
                // stateSave is on: keep the saved (desktop) page length out of the mobile view
                var daSaved = debit_account_table.state.loaded();
                var daDesktopLen = daSaved && daSaved.length ? daSaved.length : 50;
                debit_account_table.on('stateSaveParams.dt', function (e, settings, data) {
                    if (isDaMobile()) { data.length = daDesktopLen; }
                });

                $('#da-m-toolbar').insertAfter($('#debit_account_table_wrapper .dataTables_filter'));
                $('#debit_account_table_filter input').attr('placeholder', 'Search by transaction id');
                debit_account_table.page.len(20).draw();
            }
            (function () {
                var len = String(debit_account_table.page.len());
                if (!$('#da-m-entries option[value="' + len + '"]').length) {
                    $('#da-m-entries').append($('<option>', { value: len, text: len }));
                }
                $('#da-m-entries').val(len);
            })();
            $('#da-m-entries').on('change', function () {
                debit_account_table.page.len(parseInt(this.value, 10)).draw();
            });

            // "+ / -" column: red when the amount is a minus (display only)
            var markDaSigns = function () {
                $('#debit_account_table tbody td.debit-task').each(function () {
                    this.setAttribute('data-m-sign', /^\s*-/.test($(this).text()) ? 'minus' : 'plus');
                });
            };
            debit_account_table.on('draw', markDaSigns);
            markDaSigns();

            // Place the page header 16px below the layout's fixed mobile bar(s).
            var fixDaHeaderOffset = function () {
                var top = document.querySelector('.da-m-header');
                var nav = document.getElementById('sidenav-main');
                if (!top) return;
                top.style.marginTop = '';
                if (!isDaMobile() || !nav || getComputedStyle(nav).position !== 'fixed') return;
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
            fixDaHeaderOffset();
            setTimeout(fixDaHeaderOffset, 350);
            setTimeout(fixDaHeaderOffset, 1300);
            $(window).on('load', fixDaHeaderOffset);
            var daResizeTimer;
            $(window).on('resize', function () {
                clearTimeout(daResizeTimer);
                daResizeTimer = setTimeout(fixDaHeaderOffset, 150);
            });
        } catch (daErr) {
            if (window.console) console.error('Debit account mobile view:', daErr);
        }
        /* -------------------------------------------------------------------- */
    });

    $(document).ready(function() {
        $("#financial_year").change(function() {
            $(".se-pre-con").fadeIn('slow');
            var selectedYear = $(this).val();
            var baseUrl = "{{ url('/') }}";
            window.location.href = baseUrl + "/chart_of_accounts/debit_account?financial_year=" + selectedYear;
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

    $('#save_debit').on('click', function () {
        var form = $('#debit_create_form')[0];

        var formData = new FormData(form);

        var amount = parseFloat($('#payment_amount').val());
        var current_value = parseFloat($('#current_value').val());
        var new_value = current_value - amount;

        formData.append('new_current_value', new_value);

        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: "{{ route('chart_of_accounts.save_debit_record') }}",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#debit_create_modal').modal('hide');
                // location.reload();
            },
            error: function (error) {
                console.log('Failed to save debit record.');
                // location.reload();
            }
        });
    });

    $(document).on('change', '#current_value, #payment_amount', function() {

        var current_value = parseFloat($('#current_value').val()) || 0;
        var payment_amount = parseFloat($('#payment_amount').val()) || 0;

        $('#new_current_value').val((current_value + payment_amount).toFixed(2));
        $('#new_current_value_text').text((current_value + payment_amount).toFixed(2));
    });


</script>



@endsection