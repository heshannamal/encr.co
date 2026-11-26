@extends('layouts.app', ['activePage' => 'system_api', 'titlePage' => __('API Settings')])

@section('content')
<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>

    .se-pre-con {
        position: fixed;
        display: none;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }
    .btn-green-filled{
        outline: unset !important;
        padding: 8px;
        color: white;
        background-color: #47D6B6;
        border: 2px solid #47D6B6;
        font-weight: 700;
        font-size: .7rem;
        cursor: pointer;
    }
    .card{
        border: none;
        border-radius: 0rem;
    }
    .header-style{
        background-color: rgba(50, 50, 50, 1) !important;
        height: 40px;
    }

    .togelcheck {
        position: relative;
        width: 20px;
        height: 10px;
        -webkit-appearance: none;
        background: #c6c6c6;
        outline: none;
        border-radius: 20px;
        box-shadow: inset 0 0 5px rgba(255, 0, 0, 0.2);
        transition: 0.7s;
    }

    .togelcheck:checked[type="checkbox"] {
    background: #03a9f4;
    }

    .togelcheck:before {
        content: '';
        position: absolute;
        width: 10px;
        height: 10px;
        border-radius: 20px;
        top: 0;
        left: 0;
        background: #ffffff;
        transform: scale(1.1);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        transition: .5s;
    }

    .togelcheck:checked[type="checkbox"]:before {
        left: 10px;
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
    .new-style-table .alphabet {
        padding-right: 1rem;
        padding-left: 1rem;
    }
    .new-style-table table thead tr{
        background-color: rgba(50, 50, 50, 1) !important;
        height: 40px;
    }
    .new-style-table .table tbody td , .new-style-table .table tbody td a {
        padding: 0.4rem 1rem !important;
        font-size: .9rem !important;
        color: rgba(22, 22, 23, 1) !important;
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
    .btn-green-generate {
        outline: unset !important;
        padding: 7px;
        color: white;
        background-color: #47d670;
        border: 2px solid #47d670;
        font-weight: 700;
        font-size: .7rem;
        cursor: pointer;
        border-radius: 6px;
    }
    .btn-info-copy {
        outline: unset !important;
        padding: 6px 20px;
        color: white;
        background-color: #47caea;
        border: 2px solid #47caea;
        font-weight: 700;
        cursor: pointer;
        border-radius: 6px;
    }

    /* =====================================================================
       System API Settings - mobile additions
       ===================================================================== */

    /* Desktop: same values as the old inline styles */
    .api-page .api-table-col { padding-right: 19px; }
    .api-link-blue  { color: #3a82ad; cursor: pointer; }
    .api-link-green { color: #3bad3a; cursor: pointer; }
    .api-link-red   { color: #d74e4e; cursor: pointer; }

    /* Mobile-only pieces are hidden on desktop */
    .api-mobile-only,
    .api-mobile-icon { display: none; }

    @media (max-width: 767.98px) {
        /* Toggle desktop-only / mobile-only pieces */
        .api-desktop-only { display: none !important; }
        .api-mobile-only  { display: inline; }

        /* ---------- Page spacing ----------
           mb-5 (3rem, !important) leaves a big gap above the footer. */
        .api-page {
            margin-bottom: 0 !important;
            padding-bottom: 20px;
        }

        /* ---------- Header: Add New API button (right side) ----------
           The page title is already shown by the layout, so it is not repeated. */
        .api-page .api-mobile-header {
            display: block;
            padding-top: 4px;
        }
        .api-page .api-title-row {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-top: 10px;
        }
        .api-page .api-add-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
            padding: 9px 14px;
            font-size: 13px;
            font-weight: 600;
            line-height: 1.2;
            white-space: nowrap;
            color: #fff;
            background-color: #45d4b8;
            border: 0;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(69, 212, 184, .35);
            cursor: pointer;
        }
        .api-page .api-add-btn:active {
            background-color: #3cc4a9;
        }
        .api-page .api-add-btn svg {
            width: 12px;
            height: 12px;
        }

        /* ---------- Outer wrappers ----------
           The column sits directly in .container-fluid (no .row);
           mt-4 / mt-2 use !important. */
        .api-page .api-outer-col {
            margin-top: 14px !important;
            padding-left: 0;
            padding-right: 0;
        }
        .api-page .api-main-card {
            background-color: transparent;
            border: 0;
            box-shadow: none;
        }
        .api-page .api-table-col {
            margin-top: 0 !important;
            padding-left: 0;
            padding-right: 0;
        }

        /* ---------- Search card ---------- */
        .api-page .api-mobile-toolbar {
            display: block;
        }
        .api-page .api-search-card {
            padding: 12px;
            background-color: #fff;
            border: 1px solid #ececec;
            border-radius: 12px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .06);
        }
        .api-page .api-search-box {
            display: flex;
            align-items: center;
            gap: 10px;
            height: 40px;
            padding: 0 12px;
            background-color: #f5f6f7;
            border: 1px solid #e3e3e3;
            border-radius: 8px;
        }
        .api-page .api-search-box svg {
            width: 15px;
            height: 15px;
            flex-shrink: 0;
            color: #333;
        }
        .api-page .api-search-input {
            flex: 1 1 auto;
            min-width: 0;
            height: 100%;
            padding: 0;
            font-size: 14px;
            color: #1d1d1f;
            background: transparent;
            border: 0;
            outline: none;
            box-shadow: none;
        }
        .api-page .api-search-input::placeholder {
            color: #a3a3a3;
        }

        /* ---------- Show entries / Sort by row ---------- */
        .api-page .api-filter-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 8px 12px;
            margin: 14px 0 10px;
        }
        .api-page .api-filter-group {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            font-size: 13px;
            font-weight: 400;
            color: #8c8c8c;
            white-space: nowrap;
        }
        .api-page .api-select {
            height: 30px;
            padding: 0 26px 0 10px;
            font-size: 13px;
            color: #1d1d1f;
            background-color: #fff;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' fill='none' stroke='%23333' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 9px center;
            background-size: 9px 6px;
            border: 1px solid #dedede;
            border-radius: 6px;
            outline: none;
            -webkit-appearance: none;
            appearance: none;
        }

        /* The custom search / length / sort controls above replace these */
        .api-page .dataTables_length,
        .api-page .dataTables_filter {
            display: none;
        }

        /* ---------- Table -> cards ----------
           Several existing table rules use !important (padding, font-size,
           colour, borders), so !important is needed here to override them. */
        .api-page .new-style-table table.dataTable {
            display: block;
            overflow: visible;
            margin: 0 !important;
            border: 0 !important;
        }
        .api-page .new-style-table table thead {
            display: none;
        }
        .api-page .new-style-table table tbody {
            display: block;
        }
        .api-page .new-style-table .table tbody tr {
            display: grid;
            grid-template-columns: auto 1fr auto;
            grid-template-areas:
                "name  name  toggle"
                "key   key   key"
                "desc  desc  desc"
                "token edit  delete";
            align-items: start;
            min-height: 0;
            margin: 0 0 10px;
            padding: 14px;
            color: #1d1d1f;
            background-color: #fff;
            border: 1px solid #ececec !important;
            border-radius: 10px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .06);
            overflow: hidden;
        }
        .api-page .new-style-table .table tbody tr:hover {
            background-color: #fff;
        }
        .api-page .new-style-table .table tbody td {
            display: block;
            min-width: 0;
            padding: 0 !important;
            font-size: 12px !important;
            line-height: 1.45;
            color: #1d1d1f !important;
            text-align: left !important;
            /* The theme sets "white-space: nowrap" on table cells, which cut
               the text off at the card edge. Let the text wrap inside the card. */
            white-space: normal;
            overflow-wrap: anywhere;
            background: transparent;
            border: 0 !important;
        }

        /* 1: status toggle */
        .api-page .new-style-table .table tbody tr > td:nth-child(1) {
            grid-area: toggle;
            justify-self: end;
            margin-left: 10px;
            line-height: 1;
        }
        /* 2: name */
        .api-page .new-style-table .table tbody tr > td:nth-child(2) {
            grid-area: name;
            align-self: center;
            font-size: 14.5px !important;
            font-weight: 700;
            line-height: 1.35;
            word-break: break-word;
        }
        /* 3: key */
        .api-page .new-style-table .table tbody tr > td:nth-child(3) {
            grid-area: key;
            margin-top: 4px;
            font-size: 13px !important;
            word-break: break-all;
        }
        .api-page .new-style-table .table tbody tr > td:nth-child(3)::before {
            content: 'Key - ';
        }
        /* 5: description */
        .api-page .new-style-table .table tbody tr > td:nth-child(5) {
            grid-area: desc;
            margin-top: 8px;
            word-break: break-word;
        }
        .api-page .new-style-table .table tbody tr > td:nth-child(5)::before {
            content: 'Description';
            display: block;
            margin-bottom: 2px;
            font-size: 11px;
            color: #8c8c8c;
        }

        /* 4: View Tokens, 6: actions (Edit + Delete become grid items) */
        .api-page .new-style-table .table tbody tr > td:nth-child(4) {
            grid-area: token;
        }
        .api-page .new-style-table .table tbody tr > td:nth-child(6) {
            display: contents !important;
        }
        .api-page .new-style-table .table tbody tr > td:nth-child(4),
        .api-page .new-style-table .table tbody tr > td:nth-child(6) > .edit_api,
        .api-page .new-style-table .table tbody tr > td:nth-child(6) > .delete_api {
            display: flex;
            align-items: center;
            margin-top: 12px;
            padding-top: 10px !important;
            border-top: 1px dashed #dcdcdc !important;
            font-size: 12px;
            line-height: 1.45;
            white-space: nowrap;
            color: #1d1d1f;
        }
        .api-page .new-style-table .table tbody tr > td:nth-child(6) > .edit_api {
            grid-area: edit;
            justify-content: center;
        }
        /* Delete button: remove Bootstrap button look, keep it a button */
        .api-page .new-style-table .table tbody tr > td:nth-child(6) > .delete_api {
            grid-area: delete;
            justify-content: flex-end;
            gap: 6px;
            width: auto;
            margin-left: 0 !important; /* ml-2 uses !important */
            padding-right: 0;
            padding-left: 0;
            padding-bottom: 0;
            font-weight: 400;
            text-transform: none;
            color: #d40000;
            background: transparent;
            border-left: 0;
            border-right: 0;
            border-bottom: 0;
            border-radius: 0;
            box-shadow: none;
            transform: none;
        }
        .api-page .new-style-table .view_token,
        .api-page .new-style-table .edit_api {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }
        .api-page .new-style-table .view_token i,
        .api-page .new-style-table .edit_api i {
            font-size: 14px;
            color: #1d1d1f;
        }
        .api-page .new-style-table .delete_api i {
            font-size: 14px;
            color: #d40000;
        }
        .api-page .new-style-table .api-desktop-icon,
        .api-page .new-style-table .api-action-text {
            display: none;
        }
        .api-page .new-style-table .api-mobile-icon {
            display: inline-block;
        }
        /* Labels are added with CSS so they don't change the table's search text */
        .api-page .new-style-table .view_token::after,
        .api-page .new-style-table .edit_api::after,
        .api-page .new-style-table .delete_api::after {
            text-decoration: underline;
            text-underline-offset: 2px;
        }
        .api-page .new-style-table .view_token::after { content: 'View Tokens'; }
        .api-page .new-style-table .edit_api::after   { content: 'Edit API'; }
        .api-page .new-style-table .delete_api::after { content: 'Delete'; }

        /* "No data available" row */
        .api-page .new-style-table .table tbody tr > td.dataTables_empty {
            grid-area: auto;
            grid-column: 1 / -1;
            display: block !important;
            padding: 16px 0 !important;
            text-align: center !important;
            color: #8c8c8c !important;
        }

        /* Status toggle switch (bigger, teal) */
        .api-page .togelcheck {
            width: 36px;
            height: 20px;
            margin: 0;
            background: #d0d0d0;
            box-shadow: none;
            cursor: pointer;
            appearance: none;
            vertical-align: middle;
        }
        .api-page .togelcheck:checked[type="checkbox"] {
            background: #45d4b8;
        }
        .api-page .togelcheck:before {
            top: 2px;
            left: 2px;
            width: 16px;
            height: 16px;
            transform: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .2);
        }
        .api-page .togelcheck:checked[type="checkbox"]:before {
            left: 18px;
        }

        /* ---------- "Showing x to y" + pagination on one row ---------- */
        .api-page .dataTables_wrapper > .row {
            margin-left: 0;
            margin-right: 0;
        }
        .api-page .dataTables_wrapper > .row > [class*="col-"] {
            padding-left: 0;
            padding-right: 0;
        }
        .api-page .dataTables_wrapper > .row:last-child {
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-top: 6px;
        }
        .api-page .dataTables_wrapper > .row:last-child > [class*="col-"] {
            flex: 0 1 auto;
            width: auto;
            max-width: none;
        }
        .api-page .dataTables_wrapper .dataTables_info {
            float: left;
            margin: 0;
            padding: 0 !important;
            font-size: 12px;
            color: #8c8c8c;
            text-align: left;
            white-space: normal;
        }
        .api-page .dataTables_wrapper .dataTables_paginate {
            float: right;
            margin: 0 !important;
            padding: 0 !important;
            text-align: right;
        }
        .api-page .dataTables_wrapper .dataTables_paginate .pagination {
            justify-content: flex-end !important;
            margin: 0;
        }
        /* Bootstrap-style pagination */
        .api-page .dataTables_paginate .page-item .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: auto;
            min-width: 32px;
            height: 32px;
            margin: 0 0 0 6px;
            padding: 0 8px;
            font-size: 13px;
            color: #333;
            background-color: #fff;
            border: 1px solid #e3e3e3;
            border-radius: 6px !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
        }
        .api-page .dataTables_paginate .page-item.active .page-link {
            color: #fff;
            background-color: #1d1d1f;
            border-color: #1d1d1f;
        }
        .api-page .dataTables_paginate .page-item.disabled .page-link {
            color: #c0c0c0;
            background-color: #fff;
        }
        /* Default DataTables pagination (if Bootstrap styling is not used) */
        .api-page .dataTables_wrapper .dataTables_paginate a.paginate_button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            margin: 0 0 0 6px !important;
            padding: 0 8px !important;
            font-size: 13px;
            color: #333 !important;
            background: #fff !important;
            border: 1px solid #e3e3e3 !important;
            border-radius: 6px;
            box-shadow: none;
        }
        .api-page .dataTables_wrapper .dataTables_paginate a.paginate_button.current {
            color: #fff !important;
            background: #1d1d1f !important;
            border-color: #1d1d1f !important;
        }
        .api-page .dataTables_wrapper .dataTables_paginate a.paginate_button.disabled {
            color: #c0c0c0 !important;
        }

        /* ---------- Shared modal look (Add, Edit, View Token) ---------- */
        .api-modal .modal-dialog {
            display: flex;
            align-items: center;
            width: calc(100% - 40px);
            max-width: 420px;
            height: calc(100% - 40px);
            min-height: 0;
            margin: 20px auto;
        }
        .api-modal .modal-dialog-centered::before {
            display: none;
        }
        .api-modal .modal-content {
            display: flex;
            flex-direction: column;
            width: 100%;
            max-height: 100%;
            overflow: hidden;
            border: 0;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .2);
        }
        .api-modal .modal-header {
            flex-shrink: 0;
            align-items: center;
            margin: 0 16px;
            padding: 16px 0 12px;
            border-bottom: 1px solid #e6e6e6;
        }
        .api-modal .modal-title {
            font-size: 16px;
            font-weight: 700;
            color: #1d1d1f;
        }
        .api-modal .modal-header .close {
            margin: -4px -4px -4px auto;
            padding: 4px;
            font-size: 22px;
            line-height: 1;
            color: #333;
            opacity: 1;
            text-shadow: none;
        }
        /* In Add / Edit the form wraps body + footer, so it must pass the
           height on: header and footer stay visible, only the fields scroll */
        .api-modal .modal-content > form {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
        }
        .api-modal .modal-body {
            flex: 1 1 auto;
            min-height: 0;
            padding: 14px 16px 4px;
            overflow-x: hidden;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
        .api-modal .modal-body > [class*="col-"] {
            padding-left: 0;
            padding-right: 0;
        }
        .api-modal .form-group {
            margin-bottom: 14px;
        }
        .api-modal .form-group > label {
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 500;
            color: #1d1d1f;
        }
        .api-modal .form-control {
            height: 38px;
            padding: 6px 12px;
            font-size: 14px;
            color: #1d1d1f;
            border: 1px solid #d9d9d9;
            border-radius: 6px;
            box-shadow: none;
        }
        .api-modal .form-control:focus {
            border-color: #45d4b8;
        }
        .api-modal .form-control[readonly] {
            color: #555;
            background-color: #fff;
        }
        .api-modal select.form-control {
            padding-right: 34px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' fill='none' stroke='%23555' stroke-width='1.4' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 11px 7px;
            -webkit-appearance: none;
            appearance: none;
        }
        /* Token field: input full width, Generate button under it.
           Bootstrap's input-group rules use !important for the radius. */
        .api-modal .input-group {
            flex-wrap: wrap;
        }
        .api-modal .input-group > .form-control {
            flex: 1 1 100%;
            width: 100%;
            border-radius: 6px !important;
        }
        .api-modal .input-group-append {
            margin-top: 8px;
            margin-left: 0;
        }
        .api-modal .btn-green-generate {
            padding: 6px 12px;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            background-color: #1d2433;
            border: 1px solid #1d2433;
            border-radius: 6px;
        }
        .api-modal .modal-footer {
            flex-shrink: 0;
            justify-content: flex-end;
            gap: 10px;
            padding: 12px 16px 16px;
            border-top: 0;
        }

        /* Footer buttons */
        .api-modal .btn.api-btn-cancel,
        .api-modal .btn.api-btn-save,
        .api-modal .btn-info-copy.api-btn-save {
            min-width: 88px;
            margin: 0;
            padding: 9px 18px;
            font-size: 13.5px;
            font-weight: 600;
            line-height: 1.3;
            text-transform: none;
            color: #fff;
            border: 0;
            border-radius: 6px;
            box-shadow: none;
            transform: none;
        }
        .api-modal .btn.api-btn-cancel,
        .api-modal .btn.api-btn-cancel:hover,
        .api-modal .btn.api-btn-cancel:focus,
        .api-modal .btn.api-btn-cancel:active {
            background-color: #b5b5b5;
            box-shadow: none;
        }
        .api-modal .btn.api-btn-save,
        .api-modal .btn.api-btn-save:hover,
        .api-modal .btn.api-btn-save:focus,
        .api-modal .btn.api-btn-save:active,
        .api-modal .btn-info-copy.api-btn-save {
            background-color: #45d4b8;
            box-shadow: 0 4px 10px rgba(69, 212, 184, .3);
        }

        /* ---------- View API Token modal ----------
           The wrappers "step aside" (display: contents) so the token field,
           Cancel and Copy Token can be laid out like the Figma design. */
        #viewAPITokenModal .modal-dialog {
            height: auto;
            min-height: calc(100% - 40px);
        }
        #viewAPITokenModal .modal-body {
            display: grid;
            grid-template-columns: 1fr auto auto;
            grid-template-areas:
                "token token token"
                ".     cancel copy";
            column-gap: 10px;
            padding: 14px 16px 16px;
            overflow: visible;
        }
        #viewAPITokenModal .modal-body > [class*="col-"],
        #viewAPITokenModal .modal-body .form-group,
        #viewAPITokenModal .modal-body .input-group,
        #viewAPITokenModal .modal-body .input-group-append {
            display: contents;
        }
        #viewAPITokenModal #view_api_token {
            grid-area: token;
            width: 100%;
            font-size: 13px;
        }
        #viewAPITokenModal .api-btn-cancel {
            grid-area: cancel;
            margin-top: 18px;
        }
        #viewAPITokenModal #copy_api_token {
            grid-area: copy;
            margin-top: 18px;
        }

        /* ---------- Delete confirm popup (SweetAlert2) ----------
           The script adds "api-swal-popup" to the popup on mobile only. */
        .swal2-popup.api-swal-popup {
            width: calc(100% - 40px);
            max-width: 380px;
            padding: 0 0 18px;
            border-radius: 12px;
        }
        .swal2-popup.api-swal-popup .swal2-title {
            display: block;
            align-self: stretch;
            margin: 0 16px;
            padding: 16px 28px 12px 0;
            text-align: left;
            font-size: 16px;
            font-weight: 700;
            color: #1d1d1f;
            border-bottom: 1px solid #e6e6e6;
        }
        .swal2-popup.api-swal-popup .swal2-close {
            font-size: 24px;
            color: #333;
            box-shadow: none;
        }
        .swal2-popup.api-swal-popup .swal2-html-container,
        .swal2-popup.api-swal-popup .swal2-content {
            margin: 16px 16px 0;
            padding: 0;
            text-align: center;
            font-size: 13.5px;
            line-height: 1.5;
            color: #8c8c8c;
        }
        .swal2-popup.api-swal-popup .api-swal-question {
            margin-bottom: 2px;
            font-size: 15px;
            font-weight: 700;
            color: #1d1d1f;
        }
        .swal2-popup.api-swal-popup .swal2-actions {
            box-sizing: border-box;
            justify-content: center;
            width: calc(100% - 32px);
            margin: 18px 16px 0;
            padding: 0;
            gap: 10px;
        }
        .swal2-popup.api-swal-popup .swal2-styled.swal2-confirm,
        .swal2-popup.api-swal-popup .swal2-styled.swal2-cancel {
            margin: 0;
            min-width: 88px;
            padding: 9px 18px;
            font-size: 13.5px;
            font-weight: 600;
            color: #fff;
            border-radius: 6px;
            box-shadow: none;
        }
        .swal2-popup.api-swal-popup .swal2-styled.swal2-confirm { background-color: #d40000; }
        .swal2-popup.api-swal-popup .swal2-styled.swal2-cancel  { background-color: #b5b5b5; }
        .swal2-popup.api-swal-popup .swal2-styled.swal2-confirm:focus,
        .swal2-popup.api-swal-popup .swal2-styled.swal2-cancel:focus {
            box-shadow: none;
        }
    }

    /* Very small phones (320px): slightly smaller card action labels */
    @media (max-width: 359.98px) {
        .api-page .new-style-table .table tbody tr > td:nth-child(4),
        .api-page .new-style-table .table tbody tr > td:nth-child(6) > .edit_api,
        .api-page .new-style-table .table tbody tr > td:nth-child(6) > .delete_api {
            font-size: 11px;
        }
    }
</style>

<div class="container-fluid mb-5 content-position api-page" >
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>API Settings</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    {{-- Mobile-only Add button (hidden on desktop). Users without permission see nothing here. --}}
    @can('manage system api')
        <div class="api-mobile-only api-mobile-header">
            <div class="api-title-row">
                <button type="button" class="api-add-btn" data-toggle="modal" data-target="#AddAPIModal">
                    <svg viewBox="0 0 12 12" aria-hidden="true"><path d="M6 1v10M1 6h10" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                    Add New API
                </button>
            </div>
        </div>
    @endcan

    <div class="col-md-12 mt-4 api-outer-col">
        <div class="card api-main-card">
            <div class="row m-1 api-desktop-only">
                <div class="col">
                        {{-- <div class="m-1">
                            <input type="checkbox" class="togelcheck" />
                          </div> --}}
                </div>
                <div class="col d-flex justify-content-end">
                    @can('manage system api')
                        <button type="button" class="btn-green-filled mt-2" data-toggle="modal" data-target="#AddAPIModal">
                            <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD NEW API
                        </button>
                    @endcan
                </div>

            </div>

            {{-- Mobile-only search, show entries and sort controls (linked to the table) --}}
            <div class="api-mobile-only api-mobile-toolbar">
                <div class="api-search-card">
                    <label class="api-search-box mb-0" for="apiMobileSearch">
                        <svg viewBox="0 0 16 16" aria-hidden="true"><circle cx="7" cy="7" r="5.2" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M11 11l3.5 3.5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                        <input type="search" id="apiMobileSearch" class="api-search-input" placeholder="Search by API name" autocomplete="off">
                    </label>
                </div>
                <div class="api-filter-row">
                    <label class="api-filter-group" for="apiMobileLength">
                        Show
                        <select id="apiMobileLength" class="api-select"></select>
                        entries
                    </label>
                    <label class="api-filter-group" for="apiMobileSort">
                        Sort by
                        <select id="apiMobileSort" class="api-select">
                            <option value="0">Default</option>
                            <option value="1">Name</option>
                            <option value="2">Key</option>
                            <option value="4">Description</option>
                        </select>
                    </label>
                </div>
            </div>

            <div class="col-md-12 mt-2 api-table-col">
                <div class="new-style-table">
                    <table class="table align-items-center cell-border" id="system_api_table" style="width:100%;">
                        <thead class="header-style">
                            <th style="color: white"></th>
                            <th style="color: white">Name</th>
                            <th class="text-center" style="color: white">Key</th>
                            <th class="text-center" style="color: white">Token</th>
                            <th style="color: white">Description</th>
                            <th class="text-center" style="color: white">Actions</th>
                        </thead>

                        <tbody id="system_api_table_tbody"></tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
</div>

@can('create system api')
    @include('pages.settings.system_api.create')
@endcan
@can('edit system api')
    @include('pages.settings.system_api.edit')
@endcan
@include('pages.settings.system_api.view_api_token')

<!-- Quill JS -->
{{-- <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script> --}}
<script>
    $(document).ready(function() {
        // Is the screen mobile size?
        var apiIsMobile = !!(window.matchMedia && window.matchMedia('(max-width: 767.98px)').matches);

        // Same table options as before (desktop stays exactly the same)
        var apiTableOptions = {
            paging: true,
            searching: true,
            ordering: true,
            responsive: true,
            autoWidth: true,
            columnDefs: [
                { targets: 0, className: 'text-center', orderable: false },
                { targets: 2, className: 'text-center' },
                { targets: 3, className: 'text-center', orderable: false },
                { targets: 5, className: 'text-center', orderable: false },
                {
                    targets: 4,
                    render: function (data, type, row) {
                        if (typeof data === 'string' && data.length > 130) {
                            return data.substring(0, 30) + '...';
                        }
                        return data;
                    }
                }
            ],
            pageLength: 10,
            lengthChange: true
        };

        // Mobile only: rows are shown as cards, so the Responsive extension
        // (which hides columns) is turned off, and prev/next become arrows.
        if (apiIsMobile) {
            apiTableOptions.responsive = false;
            apiTableOptions.language = {
                paginate: {
                    previous: '&lsaquo;',
                    next: '&rsaquo;'
                }
            };
        }

        $('#system_api_table').DataTable(apiTableOptions);

        /*
         * Mobile toolbar: the search box, "Show entries" and "Sort by" controls
         * use the same DataTable, so they work exactly like the desktop ones.
         */
        (function initApiMobileToolbar() {
            var apiTable = $('#system_api_table').DataTable();
            var $search = $('#apiMobileSearch');
            var $length = $('#apiMobileLength');
            var $sort = $('#apiMobileSort');

            if (!$search.length) {
                return;
            }

            // "Show entries" options come from the table's own length menu
            var menu = apiTable.settings()[0].aLengthMenu || [10, 25, 50, 100];
            var values = Array.isArray(menu[0]) ? menu[0] : menu;
            var labels = Array.isArray(menu[0]) ? (menu[1] || menu[0]) : menu;

            $length.empty();
            values.forEach(function (item, i) {
                var value = (item && typeof item === 'object') ? item.value : item;
                var label = (item && typeof item === 'object') ? item.label : labels[i];
                $length.append(
                    $('<option>').val(String(value)).text(String(label === undefined ? value : label))
                );
            });
            $length.val(String(apiTable.page.len()));

            $length.on('change', function () {
                apiTable.page.len(parseInt(this.value, 10)).draw();
            });

            $search.val(apiTable.search());
            $search.on('input', function () {
                if (apiTable.search() !== this.value) {
                    apiTable.search(this.value).draw();
                }
            });

            function syncSort() {
                var order = apiTable.order();
                if (order && order.length) {
                    var column = String(order[0][0]);
                    if ($sort.find('option[value="' + column + '"]').length) {
                        $sort.val(column);
                    }
                }
            }
            syncSort();

            $sort.on('change', function () {
                apiTable.order([[parseInt(this.value, 10), 'asc']]).draw();
            });

            // Keep the mobile controls in sync if the table changes another way
            $('#system_api_table')
                .on('length.dt', function (e, settings, len) {
                    $length.val(String(len));
                })
                .on('search.dt', function () {
                    if (document.activeElement !== $search[0]) {
                        $search.val(apiTable.search());
                    }
                })
                .on('order.dt', syncSort);
        })();

        get_template_data();
        function get_template_data(){

            $.ajax({
                url: "{{ route('system_api.get_table_data') }}",
                type: 'get',
                dataType: 'json',
                beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                success: function(response) {
                    update_system_api_table(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        function update_system_api_table(templates){
             var table = $('#system_api_table').DataTable(); // Get DataTable instance
            table.clear().draw(); // Clear existing data while keeping DataTable active

            if (!templates || templates.length == 0) {
                // Instead of adding a custom row, let DataTables handle the "No data available" message
                table.draw();
                $(".se-pre-con").fadeOut('slow');
                return;
            }



            $.each(templates, function(index, template) {
                var checked = template.is_active == 1 ? 'checked' : '';

                var row = [
                    `<input type="checkbox" class="togelcheck changeStatus" data-id="${template.id}" ${checked} />`,
                    template.name,
                    template.api_type_key,
                    `<span class="view_token" data-token="${template.api_token}"><i class="fa fa-file-code-o api-link-blue api-desktop-icon"></i><i class="fa-solid fa-tags api-mobile-icon"></i><span  class="mx-1 api-link-blue api-action-text">view</span></span>`,
                    template.description,
                    `<span class="edit_api" data-id="${template.id}"><i class="fa-solid fa-pen-to-square api-link-green"></i><span class="mx-1 api-link-green api-action-text">edit</span></span>
                    <button type="button" class="btn btn-sm delete_api ml-2" value="${template.id}"><i class="fa-solid fa-trash api-link-red"></i></button>`,
                ];

                table.row.add(row);
            });

            table.draw(); // Redraw table with new data
            $(".se-pre-con").fadeOut('slow');
            // Attach change event to checkboxes after table draw
            $('#system_api_table').off('change', '.changeStatus').on('change', '.changeStatus', function () {
                var templateId = $(this).data('id');
                var isChecked = $(this).is(':checked') ? 1 : 0;

                // Send AJAX to update template status
                $.ajax({
                    url: "{{ url('system_api/update') }}/"+templateId, // Adjust route accordingly
                    method: 'POST',
                    data: {
                        is_active: isChecked,
                        is_json: true,
                        _token: $('meta[name="csrf-token"]').attr('content') // if CSRF is needed
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (response) {
                        console.log(response.message);
                        $(".se-pre-con").fadeOut('slow');
                    },
                    error: function (xhr) {
                        alert('Failed to update status');
                        let errorMsg = "Failed to update status";
                        if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        console.log(errorMsg);
                    }
                });
            });

            $('#system_api_table').off('click', '.edit_api').on('click', '.edit_api', function () {
                var templateId = $(this).data('id');

                $.ajax({
                    url:`{{ url('system_api/edit')}}/${templateId}`,
                    method: 'GET',
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (data) {
                        $('#edit_name').val(data.name);
                        $('#edit_api_type_key').val(data.api_type_key);
                        $('#edit_api_token').val(data.api_token);
                        $('#edit_description').val(data.description);
                        $('#edit_status').val(data.title);
                        $('#edit_description').val(data.description);
                        $('#edit_status').val(data.is_active);

                        // Set form action for update
                        $('#editAPIForm').attr('action', `{{ url('system_api/update')}}/${data.id}`);

                        // Show the modal
                        $('#EditAPIModal').modal('show');
                        $(".se-pre-con").fadeOut('slow');
                    },
                    error: function () {
                        alert('Failed to load template data');
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            });

            $('#system_api_table').off('click', '.view_token').on('click', '.view_token', function () {
                var apiToken = $(this).data('token');
                $('#view_api_token').val(apiToken);
                $('#viewAPITokenModal').modal('show');
            });

            $('#system_api_table').off('click', '.delete_api').on('click', '.delete_api', function () {
                var apirow = $(this);
                var apiId = apirow.val();

                // Same options as before (desktop stays exactly the same)
                var deleteOptions = {
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                };

                // Mobile only: Figma popup layout. The button colours are removed
                // because SweetAlert2 sets them as inline styles, which would
                // override the mobile grey / red buttons.
                if (apiIsMobile) {
                    delete deleteOptions.confirmButtonColor;
                    delete deleteOptions.cancelButtonColor;
                    delete deleteOptions.text;
                    deleteOptions.title = 'Delete API';
                    deleteOptions.html = '<div class="api-swal-question">Are you sure?</div><div>You won\'t be able to revert this!</div>';
                    deleteOptions.confirmButtonText = 'Yes, Delete It!';
                    deleteOptions.showCloseButton = true;
                    deleteOptions.reverseButtons = true;
                }

                var deletePopup = Swal.fire(deleteOptions);

                // Mobile only: add the styling class to the opened popup.
                // Wrapped in try/catch so styling can never stop the popup from working.
                if (apiIsMobile) {
                    try {
                        var popup = Swal.getPopup();
                        if (popup) {
                            popup.classList.add('api-swal-popup');
                        }
                    } catch (err) {
                        console.warn('Mobile popup styling skipped:', err);
                    }
                }

                deletePopup.then((result) => {
                    if (result.value) {
                        $.ajax({
                            url:`{{ url('system_api/delete')}}/${apiId}`,
                            method: 'GET',
                            beforeSend: function () {
                                $(".se-pre-con").fadeIn('slow');
                            },
                            success: function (data) {
                                if(data.response == 'success'){
                                    apirow.closest('tr').fadeOut(function(){ $(this).remove(); });
                                }
                                $(".se-pre-con").fadeOut();
                                Swal.fire({
                                    type: data.response,
                                    title: data.title,
                                    text: data.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            },
                            error: function (xhr) {
                                let errorMsg = "Failed to delete API";
                                if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMsg = xhr.responseJSON.message;
                                }
                                console.log(errorMsg);
                                $(".se-pre-con").fadeOut();
                                Swal.fire({
                                    type: 'error',
                                    title: 'Error!',
                                    text: 'Failed to delete API',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        });
                    }
                });
            });
        }

        $('.generate-api-token').click(function(){
            var targetInput = $(this).data('for');
            $('#'+targetInput).val(generateApiToken());
        });

        $('#copy_api_token').click(function(){
            var targetApiToken = $('#view_api_token').val();
            navigator.clipboard.writeText(targetApiToken).then(function() {
                Swal.fire({
                    type: 'success',
                    title: 'Copied!',
                    text: 'API token has been copied to clipboard.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }, function(err) {
                Swal.fire({
                    type: 'error',
                    title: 'Error!',
                    text: 'API token has not been copied to clipboard.',
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        });
    });

    function generateApiToken(length = 40) {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let token = '';
        for (let i = 0; i < length; i++) {
            token += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return token;
    }

</script>
@endsection