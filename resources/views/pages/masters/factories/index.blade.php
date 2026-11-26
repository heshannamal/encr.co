@extends('layouts.app', ['activePage' => 'factories', 'titlePage' => __('Factories')])

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
        width: 94px;
        position: relative;
        right: -22px;
    }
    .btn-text-position {
        position: relative;
        right: -6%;
        font-size: 15px;
    }
    .content-position {
        position: relative;
        top: -47px;
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

   .pagina001{
        flex-wrap: wrap;
     }
     .flex_set{
        flex-direction: column;
     }
     .max_width01{
        max-width: none;
     }
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
        border-top: 1px solid #e9ecef !important;
    }
    .new-style-table table tbody tr:hover{
        background-color: #f6f6ff;
    }
    .new-style-table th, .new-style-table td {
        padding: 10px;
        vertical-align: middle !important;
    }
    .new-style-table .dataTables_info {
        color:#b3b3b3;
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
    .btn-green-filled{
        outline: unset !important;
        color: white;
        background-color: #47D6B6;
        border: 2px solid #47D6B6;
        font-weight: 700;
        font-size: .7rem;
        cursor: pointer;
        padding: .4rem;
        padding-left: 1rem;
        padding-right: 1rem;
    }
    .new-style-table table thead tr{
        background-color: rgba(50, 50, 50, 1) !important;
    }
    .new-style-table .table tbody td , .new-style-table .table tbody td a {
        padding: 0.4rem 1rem !important;
        font-size: .9rem !important;
        color: rgba(22, 22, 23, 1) !important;
    }
    .btn-inside-table button{
        width: 100% !important;
        font-size: .7rem !important;
        height: 2.1rem;
        font-size: .7rem !important;
    }
    body {
        font-family: 'Open Sans', 'sans-serif' !important;
    }
    /* ================= MOBILE VIEW ONLY ================= */
    @media (max-width: 767.98px) {

        /* ---------- 1. PAGE LAYOUT ---------- */
        .content-position {
            top: 0;
            margin-top: 0;
            padding: 0;
        }

        .content-position>.col-md-12 {
            padding: 0 17px;
        }

        .content-position>.col-md-12>.card {
            display: flex;
            flex-direction: column;
            background: transparent;
            box-shadow: none;
        }

        /* flatten wrappers so add button / search / list can be re-ordered */
        .new-style-table,
        .new-style-table .table-responsive,
        #factories_table_wrapper,
        #factories_table_wrapper>.row,
        #factories_table_wrapper>.row>[class*="col-"] {
            display: contents;
        }

        /* hidden on mobile */
        .new-style-table .dataTables_length,
        div.alphabet {
            display: none !important;
        }

        /* ---------- 2. ADD BUTTON (1st) ---------- */
        .content-position .card>.col-md-4 {
            order: 1;
            flex: none;
            width: 100%;
            max-width: 100%;
            padding: 0;
            margin: 0 0 10px !important;
        }

        .btn-inside-table,
        .btn-inside-table tbody,
        .btn-inside-table tr,
        .btn-inside-table td {
            display: block;
            width: 100% !important;
        }

        .btn-inside-table td:nth-child(1),
        .btn-inside-table td:nth-child(2) {
            display: none;
        }

        .btn-inside-table button.btn-green-filled {
            width: 100% !important;
            height: 42px;
            padding: 0;
            font-size: 14px !important;
            background: #14b8a6;
            border: 0;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        /* .btn-inside-table button.btn-green-filled::after {
            content: "+Add Factory";
            font-size: 15px;
            font-weight: 600;
            color: #fff;
        } */

        /* ---------- 3. SEARCH (2nd) ---------- */
        .dataTables_filter {
            order: 2;
            width: 100%;
            margin: 0 0 14px !important;
            text-align: left;
        }

        .dataTables_filter label {
            display: block;
            position: relative;
            width: 100%;
            margin: 0;
        }

        .dataTables_filter input {
            display: block;
            width: 100% !important;
            height: 42px;
            margin: 0 !important;
            padding: 0 14px 0 44px;
            font-size: 14px;
            color: #111827;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: none;
        }

        .dataTables_filter input::placeholder {
            color: #9ca3af;
        }

        .dataTables_filter label .fas {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            color: #9ca3af;
            z-index: 0;
        }

        /* empty state ("No matching records found") */
        .new-style-table table tbody tr:has(td.dataTables_empty)::after {
            display: none;
        }

        .new-style-table .table tbody tr td.dataTables_empty {
            display: block !important;
            flex: 0 0 100%;
            padding: 24px 16px !important;
            font-size: 13px !important;
            font-weight: 500;
            text-align: center;
            color: #6b7280 !important;
        }

        /* ---------- 4. LIST -> CARDS (3rd) ---------- */
        #factories_table {
            order: 3;
            display: block;
            width: 100% !important;
            margin: 0 !important;
            border: 0;
            background: transparent;
        }

        #factories_table thead {
            display: none;
        }

        #factories_table tbody {
            display: block;
        }

        .new-style-table table tbody tr {
            display: flex;
            flex-wrap: wrap;
            position: relative;
            height: auto;
            min-height: 0;
            margin: 0 0 9px;
            background: #fff;
            border: 1px solid #e5e7eb !important;
            border-radius: 18px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .08);
        }

        .new-style-table table tbody tr:hover {
            background: #fff;
        }

        .new-style-table .table tbody tr td {
            border: 0 !important;
            background: transparent;
            vertical-align: top !important;
        }

        .new-style-table .table tbody tr td.factory-name,
        .new-style-table .table tbody tr td.factory-code {
            display: block !important;
        }

        /* chevron */
        .new-style-table table tbody tr::after {
            content: "";
            position: absolute;
            right: 10px;
            top: 22px;
            width: 16px;
            height: 16px;
            cursor: pointer;
            transition: transform .2s;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23111' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") center / 16px no-repeat;
        }

        .new-style-table table tbody tr.open::after {
            transform: rotate(180deg);
        }

        /* name */
        .new-style-table .table tbody tr td.factory-name {
            order: 1;
            flex: 0 0 100%;
            max-width: 100%;
            min-width: 0;
            box-sizing: border-box;
            padding: 16px 118px 0 16px !important;
            white-space: normal !important;
        }

        .new-style-table .table tbody tr td.factory-name a.edit {
            display: block;
            max-width: 100%;
            padding: 0 !important;
            font-size: 14px !important;
            font-weight: 600;
            line-height: 20px;
            color: #1F2933 !important;
            text-decoration: none;
            white-space: normal !important;
            word-break: break-word;
            overflow-wrap: anywhere;
        }

        /* Edit pill (part of the link, still opens the edit modal) */
        .new-style-table .table tbody tr td.factory-name a.edit::after {
            content: "Edit";
            position: absolute;
            right: 42px;
            top: 17px;
            box-sizing: border-box;
            width: 64px;
            height: 28px;
            padding-left: 26px;
            font-size: 12px;
            font-weight: 500;
            line-height: 24px;
            color: #6b7280;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23111' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7'/%3E%3Cpath d='M18.5 2.5a2.1 2.1 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z'/%3E%3C/svg%3E") 10px center / 12px 12px no-repeat, #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 999px;
        }

        /* code */
        .new-style-table .table tbody tr td.factory-code {
            order: 2;
            flex: 0 0 100%;
            padding: 2px 16px 16px !important;
            font-size: 12px !important;
            line-height: 16px;
            color: #1F2933 !important;
            border-bottom: 1px solid #e5e7eb !important;
        }

        .new-style-table .table tbody tr:not(.open) td.factory-code {
            border-bottom: 0 !important;
        }

        /* created / last updated boxes */
        .new-style-table .table tbody tr td.created-at,
        .new-style-table .table tbody tr td.updated-at {
            display: none !important;
            /* closed by default */
            position: relative;
            flex: 1 1 0;
            min-width: 0;
            padding: 10px 8px 10px 48px !important;
            font-size: 12px !important;
            font-weight: 500;
            line-height: 18px;
            color: #1F2933 !important;
            background: #F2F3F4;
            border-radius: 12px;
        }

        .new-style-table .table tbody tr.open td.created-at,
        .new-style-table .table tbody tr.open td.updated-at {
            display: block !important;
        }

        .new-style-table .table tbody tr td.created-at {
            order: 3;
            margin: 14px 5px 16px 16px;
        }

        .new-style-table .table tbody tr td.updated-at {
            order: 4;
            margin: 14px 16px 16px 5px;
        }

        .new-style-table .table tbody tr td.created-at::before,
        .new-style-table .table tbody tr td.updated-at::before {
            display: block;
            font-size: 11px;
            font-weight: 500;
            line-height: 16px;
            color: #6B7280;
        }

        .new-style-table .table tbody tr td.created-at::before {
            content: "Created";
        }

        .new-style-table .table tbody tr td.updated-at::before {
            content: "Last Updated";
        }

        .new-style-table .table tbody tr td.created-at::after,
        .new-style-table .table tbody tr td.updated-at::after {
            content: "";
            position: absolute;
            left: 10px;
            top: 50%;
            width: 28px;
            height: 28px;
            margin-top: -14px;
            background-color: #fff;
            background-position: center;
            background-repeat: no-repeat;
            background-size: 15px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .12);
        }

        .new-style-table .table tbody tr td.created-at::after {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23111' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='2'/%3E%3Cpath d='M16 2v4M8 2v4M3 10h18'/%3E%3C/svg%3E");
        }

        .new-style-table .table tbody tr td.updated-at::after {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23111' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='12' cy='12' r='10'/%3E%3Cpath d='M12 6v6l4 2'/%3E%3C/svg%3E");
        }

        /* ---------- 5. INFO + PAGINATION ---------- */
        .dataTables_info,
        .new-style-table .dataTables_info {
            order: 4 !important;
            font-size: 13.5px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            padding: 0 4px 12px 4px !important;
            margin: 0 !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            text-align: left !important;
        }

        .dataTables_paginate {
            order: 5 !important;
            display: flex !important;
            justify-content: center !important;
            margin-top: 16px !important;
            margin-bottom: 12px !important;
            width: 100% !important;
        }

        .dataTables_paginate ul.pagination,
        .dataTables_paginate .pagination {
            display: flex !important;
            flex-wrap: wrap !important;
            justify-content: center !important;
            gap: 4px !important;
            margin: 0 !important;
        }

        .dataTables_paginate .page-item .page-link,
        .dataTables_paginate .page-item span {
            border-radius: 8px !important;
            border: 1px solid #e2e8f0 !important;
            color: #475569 !important;
            font-size: 13px !important;
            padding: 6px 12px !important;
            background: #ffffff !important;
        }

        .dataTables_paginate .page-item.active .page-link {
            background-color: #14B8A6 !important;
            border-color: #14B8A6 !important;
            color: #ffffff !important;
            font-weight: 700 !important;
        }

        /* ---------- 6. ADD / EDIT MODALS ---------- */
        #factory_create_modal .modal-dialog,
        #factory_edit_modal .modal-dialog {
            margin: 16px auto;
            width: calc(100% - 32px);
            max-width: 350px;
        }

        #factory_create_modal .modal-content,
        #factory_edit_modal .modal-content {
            border: 0;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 28px rgba(0, 0, 0, .12);
        }

        /* header */
        #factory_create_modal .modal-header,
        #factory_edit_modal .modal-header {
            align-items: center;
            height: 52px;
            padding: 0 18px;
            border-bottom: 1px solid #e5e7eb;
        }

        #factory_create_modal .modal-title,
        #factory_edit_modal .modal-title {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            line-height: 1.2;
            color: #111827;
        }

        #factory_create_modal .modal-header .close,
        #factory_edit_modal .modal-header .close {
            margin: 0;
            padding: 0;
            opacity: 1;
            font-size: 26px;
            font-weight: 300;
            line-height: 1;
            color: #9ca3af;
        }

        /* body */
        #factory_create_modal .modal-body,
        #factory_edit_modal .modal-body {
            padding: 20px 20px 0 !important;
        }

        #factory_create_modal .modal-body .col-md-12,
        #factory_edit_modal .modal-body .col-md-12,
        #factory_create_modal .modal-body [class*="col-"],
        #factory_edit_modal .modal-body [class*="col-"] {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        #factory_create_modal .modal-body .row,
        #factory_edit_modal .modal-body .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        #factory_create_modal .form-field,
        #factory_edit_modal .form-field {
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        #factory_create_modal .form-input,
        #factory_edit_modal .form-input {
            box-sizing: border-box;
        }

        #factory_create_modal .modal-body,
        #factory_edit_modal .modal-body {
            padding: 20px 18px 0;
        }

        #factory_create_modal .modal-body .col-md-12,
        #factory_edit_modal .modal-body .col-md-12 {
            padding: 0;
        }

        #factory_create_modal .modal-body .row,
        #factory_edit_modal .modal-body .row {
            margin: 0;
        }

        #factory_create_modal .form-field,
        #factory_edit_modal .form-field {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            flex: 0 0 100%;
            max-width: 100%;
            padding: 0;
            margin-bottom: 14px;
        }

        /* labels (original text hidden, re-drawn without the colon) */
        #factory_create_modal .form-lable,
        #factory_edit_modal .form-lable {
            width: 100%;
            margin: 0 0 8px;
            font-size: 0;
            font-weight: 700;
            color: #111827;
        }

        #factory_create_modal .form-lable::before,
        #factory_edit_modal .form-lable::before {
            font-size: 13px;
        }

        #factory_create_modal .form-lable .text-danger,
        #factory_edit_modal .form-lable .text-danger {
            font-size: 13px;
            color: #e11d1d !important;
        }

        #factory_create_modal .form-field:nth-of-type(1) .form-lable::before,
        #factory_edit_modal .form-field:nth-of-type(1) .form-lable::before {
            content: "Factory Name ";
        }

        #factory_create_modal .form-field:nth-of-type(2) .form-lable::before,
        #factory_edit_modal .form-field:nth-of-type(2) .form-lable::before {
            content: "Factory Code";
        }

        #factory_create_modal .form-field:nth-of-type(3) .form-lable::before,
        #factory_edit_modal .form-field:nth-of-type(3) .form-lable::before {
            content: "Group";
        }

        /* inputs */
        #factory_create_modal .form-input,
        #factory_edit_modal .form-input,
        #factory_create_modal select.select2,
        #factory_edit_modal select.select2 {
            width: 100%;
            height: 45px;
            padding: 0 15px;
            font-size: 13px;
            font-weight: 600;
            color: #111827;
            background-color: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            box-shadow: none;
        }

        #factory_create_modal .form-input::placeholder,
        #factory_edit_modal .form-input::placeholder {
            color: #9ca3af;
            font-weight: 400;
        }

        /* select2 */
        #factory_create_modal .select2-container,
        #factory_edit_modal .select2-container {
            width: 100% !important;
        }

        #factory_create_modal .select2-container--default .select2-selection--single,
        #factory_edit_modal .select2-container--default .select2-selection--single {
            height: 45px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
        }

        #factory_create_modal .select2-container--default .select2-selection--single .select2-selection__rendered,
        #factory_edit_modal .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding: 0 40px 0 15px;
            line-height: 43px;
            font-size: 13px;
            font-weight: 600;
            color: #111827;
        }

        #factory_create_modal .select2-container--default .select2-selection--single .select2-selection__arrow,
        #factory_edit_modal .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 0;
            right: 14px;
            width: 16px;
            height: 43px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23111' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") center / 14px no-repeat;
        }

        #factory_create_modal .select2-container--default .select2-selection--single .select2-selection__arrow b,
        #factory_edit_modal .select2-container--default .select2-selection--single .select2-selection__arrow b {
            display: none;
        }

        /* footer buttons */
        #factory_create_modal .modal-footer,
        #factory_edit_modal .modal-footer {
            display: block;
            padding: 2px 18px 18px;
            border-top: 0;
        }

        #factory_create_modal .control-btns,
        #factory_edit_modal .control-btns {
            display: flex;
            flex-wrap: nowrap;
            gap: 10px;
            padding: 0;
            margin-top: 14px;
        }

        #factory_create_modal .control-btns .btn,
        #factory_edit_modal .control-btns .btn {
            flex: 1 1 0;
            height: 50px;
            margin: 0;
            padding: 0;
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            border: 0;
            border-radius: 8px;
            box-shadow: none;
        }

        #factory_create_modal .control-btns .btn-secondary,
        #factory_edit_modal .control-btns .btn-secondary {
            background: #9ca3af;
        }

        #factory_create_modal .control-btns .btn-success,
        #factory_edit_modal .control-btns .btn-success {
            background: #1ba35e;
        }

        #factory_edit_modal .control-btns .btn-danger {
            background: #e02020;
            order: -1;
        }
        
        /* Group select (select2): clearly visible border */
        #factory_create_modal .select2-container .select2-selection,
        #factory_edit_modal .select2-container .select2-selection,
        #factory_create_modal .select2-container--default .select2-selection--single,
        #factory_edit_modal .select2-container--default .select2-selection--single {
            border: 1px solid #d1d5db !important;
            box-shadow: inset 0 0 0 1px #d1d5db !important;
            border-radius: 10px !important;
            background-color: #fff !important;
            height: 45px !important;
            box-sizing: border-box !important;
        }

        #factory_create_modal .select2-container.select2-container--open .select2-selection,
        #factory_edit_modal .select2-container.select2-container--open .select2-selection,
        #factory_create_modal .select2-container.select2-container--focus .select2-selection,
        #factory_edit_modal .select2-container.select2-container--focus .select2-selection {
            border-color: #10b981 !important;
            box-shadow: inset 0 0 0 1px #10b981 !important;
        }

        /* In case the border comes from the original select's classes */
        #factory_create_modal select.item-table-border,
        #factory_edit_modal select.item-table-border {
            border: 1px solid #d1d5db !important;
            border-radius: 10px !important;
        }
    }
</style>

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>FACTORIES</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="row col-md-12" style="padding: 0rem;">
        <div class="col-md-4 ml-auto text-right mt-3">
            
        </div>
    </div>

    {{-- <div class="col-md-12 btn-top">
        <div class="row div_align">
            <div class="col-md-9"></div>
            <div class="col-md-3 btns-right-position btn_set">
                <div class="row">
                    <div class="col-md-6 btns-padding">
                        @if (Gate::check('add factories'))
                            <button class="btns-text btns-style btns-card" style="outline: unset;"  href="#" data-toggle="modal" data-target="#factory_create_modal" title="Add New Factories">
                                Add Factories
                            </button>
                        @endif
                    </div>
                    <div class="col-md-6 btns-padding">
                            <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                                Table Layout
                            </button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div class="col-md-12 mt-2">
        <div class="row">
            <div  class="col-md-8"></div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        @if (Gate::check('add factories'))
                            <div class="card add-btn-position">
                                    <span>
                                        <a class=" btn-text-position" style="color: #787878" href="#" data-toggle="modal" data-target="#factory_create_modal">
                                            <i class="fas fa-solid fa-plus fa-fade" style="color: #787878;">   Factories</i>
                                        </a>
                                    </span>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <div class="card btn-add-order">
                            <span>
                                <a class=" btn-text-position" style="color: #787878" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                                    <i class="fas " style="color: #808080;">Table Layout</i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="col-md-12">
        <div class="card">
            {{-- <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="float-left header-title">Factories</h1>
                        </div>
                        <div class="col-md-6 header-icons justify-content-end">
                            @if (Gate::check('add factories'))
                            <span>
                                <a class="btn btn-round" href="#" data-toggle="modal" data-target="#factory_create_modal">
                                    <i class="fas fa-plus"></i>
                                </a>
                                <p>Add Factories</p>
                            </span>
                            @endif
                            <span>
                                <a class="btn btn-round" href="#" data-toggle="modal" data-target="#layout_modal">
                                    <i class="fas fa-wrench"></i>
                                </a>
                                <p>Table Layout</p>
                            </span>
                        </div>
                    </div>
                </div>
            </div> --}}


                <div class="col-md-4 ml-auto mb-2 mt-2">
                    <table class="btn-inside-table" style="width: 100%">
                        <tr>
                            <td style="width: 20%"></td>
                            <td>
                                <button class="styled-button" style="outline: unset;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                                    Table Layout
                                </button>
                            </td>
                            <td>
                                @if (Gate::check('add factories'))
                                    <button class="btn-green-filled" style="outline: unset;"  href="#" data-toggle="modal" data-target="#factory_create_modal" title="Add New Factories">
                                        <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD FACTORY
                                    </button>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-12 new-style-table">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="factories_table">
                            <thead>
                                <th scope="col" class="factory-name">Factory Name</th>
                                <th scope="col" class="factory-code">Factory Code</th>
                                <th scope="col" class="created-at">Created At</th>
                                <th scope="col" class="updated-at">Updated At</th>
                            </thead>

                            <tbody class="list">
                                @foreach ($factories as $factories)
                                    <tr>
                                        <td class="factory-name"><a href="#" class="edit" data-value="{{$factories->id}}">{{$factories->factory_name}}</a></td>
                                        <td class="factory-code">{{$factories->factory_code}}</td>
                                        <td class="created-at">{{$factories->created_at->format('m-d-Y')}}</td>
                                        <td class="updated-at">{{$factories->updated_at->format('m-d-Y')}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>

@include('pages.masters.factories.create')
@include('pages.masters.factories.edit')

{{-- Factories Fields & Layouts --}}
<div class="modal fade" id="layout_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Factory Fields &amp; Layouts</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">

                        <input type="hidden" id="layout_id" name="layout_id" value="{{$factoryLayout['id'] ?? ''}}" />
                        <input type="hidden" id="column_layout_id" name="column_layout_id" value="{{$columnLayout['id'] ?? 0}}" />

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="factory_name" name="factory_name" title="Factory Name" @isset($factoryLayout) @if ($factoryLayout['factory_name'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="factory_name">Factory Name</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="factory_code" name="factory_code" title="Factory Code" @isset($factoryLayout) @if ($factoryLayout['factory_code'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="factory_code">Factory Code</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="created_at" name="created_at" title="Created At" @isset($factoryLayout) @if ($factoryLayout['created'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="created_at">Created At</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="updated_at" name="updated_at" title="Updated At" @isset($factoryLayout) @if ($factoryLayout['updated'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="updated_at">Updated At</label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<script>
    var searchIdx = '';

    $(document).ready( function () {
        // Fabric Table Layout
        tableLayout();

        var factoryTable = $('#factories_table').DataTable({
            colReorder: true,
            stateSave: true,
            "autoWidth": false,
            "pageLength": 50,
            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'Search'
            }
        });

        searchIndex();

        // Alphabet Search
        var _alphabetSearch = '';

        $.fn.dataTable.ext.search.push( function (settings, searchData) {

            if ( ! _alphabetSearch ) {
                return true;
            }

            if ( searchData[searchIdx].charAt(0) === _alphabetSearch ) {
                return true;
            }

            return false;
        });

        var alphabet = $('<div class="alphabet"/>').append( '' );

        $('<span class="clear active"/>').data( 'letter', '' ).html( 'All' ).appendTo( alphabet );

        for ( var i=0 ; i<26 ; i++ ) {
            var letter = String.fromCharCode( 65 + i );

            $('<span/>').data( 'letter', letter ).html( letter ).appendTo( alphabet );
        }

        alphabet.insertBefore( factoryTable.table().container() );

        alphabet.on('click', 'span', function () {
            alphabet.find( '.active' ).removeClass( 'active' );
            $(this).addClass( 'active' );

            _alphabetSearch = $(this).data('letter');
            factoryTable.draw(_alphabetSearch);
        });

        // save column order when move
        factoryTable.on('column-reorder', function (e, settings, details) {
            var columnStr = localStorage.getItem("DataTables_factories_table_/factories");
            var columnObj = JSON.parse(columnStr);
            var colReorder = new $.fn.dataTable.ColReorder( factoryTable );
            var curr = colReorder.fnOrder();
            var column_order = JSON.stringify(curr);
            var interface_name = 'Factory';
            var interface_id = 9;
            console.log(column_order);

            $.ajax({
                url: '{{ route("datatable.column_order") }}',
                type: "POST",
                data: {
                    'interface_name': interface_name, 'interface_id': interface_id, 'column_order':column_order, '_token':'{{csrf_token()}}'
                },
                success: function(data) {
                    console.log(data);
                    searchIndex();
                }
            });
        });

        var columnId = $('#column_layout_id').val();
        if(columnId == 0){
            // save column order
            var columnStr = localStorage.getItem("DataTables_factories_table_/factories");
            var columnObj = JSON.parse(columnStr);
            var column_order = JSON.stringify(columnObj.ColReorder);
            var interface_name = 'Factory';
            var interface_id = 9;
            console.log(column_order);

            $.ajax({
                url: '{{ route("datatable.column_order") }}',
                type: "POST",
                data: {
                    'interface_name': interface_name, 'interface_id': interface_id, 'column_order':column_order, '_token':'{{csrf_token()}}'
                },
                success: function(data) {
                    console.log(data);
                    if (window.location.href.indexOf('reload')==-1) {
                        window.location.replace(window.location.href+'?reload');
                    }
                },
                complete: function() {
                    $(".se-pre-con").fadeOut('slow');
                }
            });

        } else {
            // refresh column order according to user
            var interfaceId = 9;
            $.ajax({
                url: '{{ url("datatable/get_column_order") }}/'+interfaceId,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    console.log(data.column_order);
                    var columnStr = localStorage.getItem("DataTables_factories_table_/factories");
                    var columnObj = JSON.parse(columnStr);
                    columnObj.ColReorder = JSON.parse(data.column_order);

                    localStorage.setItem('DataTables_factories_table_/factories', JSON.stringify(columnObj));
                },
                complete: function() {
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        }

        $("body").on("click", ".edit", function(){
            var factoryId = $(this).data('value');
            $('#factory_id').val(factoryId);
            $('#factory_edit_modal').modal('show');
        });

        $('#factory_name').on('change', function(){ tableLayout(); });
        $('#factory_code').on('change', function(){ tableLayout(); });
        $('#created_at').on('change', function(){ tableLayout(); });
        $('#updated_at').on('change', function(){ tableLayout(); });
        
        $('#factories_table tbody').on('click', 'tr', function (e) {
            if (window.innerWidth > 767) return;
            if ($(e.target).closest('a.edit').length) return;   // name / Edit pill still opens the modal
            $(this).toggleClass('open');
        });
        
    });

    function tableLayout(){
        var layout_id = $('#layout_id').val();
        var factory_name = $('#factory_name').val();
        var factory_code = $('#factory_code').val();
        var created_at = $('#created_at').val();
        var updated_at = $('#updated_at').val();

        if($('#factory_name').is(':checked')) {
            $('.factory-name').css('display', 'table-cell');
            factory_name = 1;
        } else {
            $('.factory-name').css('display', 'none');
            factory_name = 0;
        }

        if($('#factory_code').is(':checked')) {
            $('.factory-code').css('display', 'table-cell');
            factory_code = 1;
        } else {
            $('.factory-code').css('display', 'none');
            factory_code = 0;
        }

        if($('#created_at').is(':checked')) {
            $('.created-at').css('display', 'table-cell');
            created_at = 1;
        } else {
            $('.created-at').css('display', 'none');
            created_at = 0;
        }

        if($('#updated_at').is(':checked')) {
            $('.updated-at').css('display', 'table-cell');
            updated_at = 1;
        } else {
            $('.updated-at').css('display', 'none');
            updated_at = 0;
        }

        $.ajax({
            url: "factories/layout",
            type: "POST",
            data: {
                'layout_id':layout_id, 'factory_name':factory_name, 'factory_code':factory_code, 'created_at':created_at, 'updated_at':updated_at,
                '_token':'{{csrf_token()}}'
            },
            success: function (data) {
                console.log(data);
                if(data == '"Saved"') {
                    window.location.reload(true);
                }
            }
        });
    }

    function searchIndex(){
        $('#factories_table thead th').each(function(){
            if($(this).text() == 'Factory Name') {
                searchIdx = $('#factories_table thead th').index(this);
                console.log(searchIdx);
            }
        });
    }

    $('#layout_modal').on('hidden.bs.modal', function () {
        $(".se-pre-con").fadeIn('slow');
        window.location.reload(true);
    });
</script>
@endsection
