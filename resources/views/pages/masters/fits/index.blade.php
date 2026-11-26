@extends('layouts.app', ['activePage' => 'fits', 'titlePage' => __('Fits')])

@section('content')

<style>
    .content-position {
        position: relative;
        top: -47px;
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
    .btn-inside-table button{
        width: 100% !important;
        font-size: .7rem !important;
        height: 2.1rem;
        font-size: .7rem !important;
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
        border-bottom: 1px solid #d7d7d7;
        border-top: 1px solid #d7d7d7 !important;
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
    .new-style-table table thead tr{
        background-color: rgba(50, 50, 50, 1) !important;
    }
    .new-style-table .table tbody td , .new-style-table .table tbody td a {
        padding: 0.4rem 1rem !important;
        font-size: .9rem !important;
        color: rgba(22, 22, 23, 1) !important;
    }
    .form-input {
        width: 100%;
    }

    /* MOBILE RESPONSIVE STYLES */
    @media (max-width: 768px) {

        /* body {
            background-color: #f8fafc !important;
            font-family: 'Open Sans', sans-serif !important;
        } */

        /* ── Page Layout ── */
        .content-position {
            position: relative !important;
            top: 0 !important;
            padding-left: 14px !important;
            padding-right: 14px !important;
        }

        .card {
            background-color: transparent !important;
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            margin-top: 8px !important;
        }

        /* ── Action Buttons Row (+Add Fits) ── */
        .col-md-4.ml-auto.mb-2.mt-2 {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 0 14px 0 !important;
        }

        .btn-inside-table {
            width: 100% !important;
            table-layout: fixed !important;
            margin: 0 !important;
        }

        .btn-inside-table tr td:first-child,
        .btn-inside-table tr td:nth-child(2) {
            display: none !important;
        }

        .btn-inside-table tr td:last-child {
            width: 100% !important;
            padding: 0 !important;
        }

        /* +Add Fits button matching image 1 */
        .btn-green-filled,
        .btn-inside-table button,
        .btn-inside-table .btn-green-filled {
            width: 100% !important;
            height: 44px !important;
            background-color: #14B8A6 !important;
            border: none !important;
            border-radius: 12px !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: 0 2px 8px rgba(20, 184, 166, 0.28) !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            text-transform: none !important;
        }

        .btn-green-filled:hover,
        .btn-green-filled:active,
        .btn-inside-table button:hover,
        .btn-inside-table button:active {
            background-color: #0d9488 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(20, 184, 166, 0.35) !important;
            transform: translateY(-1px) !important;
        }

        /* ── DataTables wrapper ── */
        .dataTables_wrapper {
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .dataTables_wrapper .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .dataTables_wrapper .row > [class*="col-"] {
            padding-left: 0 !important;
            padding-right: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }

        /* Search input styled as "Search this product" */
        .dataTables_filter {
            width: 100% !important;
            float: none !important;
            text-align: left !important;
            margin: 0 0 14px 0 !important;
        }

        .dataTables_filter label {
            width: 100% !important;
            display: block !important;
            margin: 0 !important;
            font-size: 0 !important; /* hide default 'Search:' text */
            color: transparent !important;
        }

        .dataTables_filter label i.fas.fa-search {
            display: none !important;
        }

        .dataTables_filter input,
        .dataTables_filter input[type="search"] {
            display: block !important;
            width: 100% !important;
            height: 48px !important;
            padding: 10px 16px 10px 44px !important;
            background: #ffffff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'><circle cx='11' cy='11' r='8'></circle><line x1='21' y1='21' x2='16.65' y2='16.65'></line></svg>") 14px center no-repeat !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 14px !important;
            font-size: 14px !important;
            color: #334155 !important;
            box-sizing: border-box !important;
            margin: 0 !important;
            outline: none !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03) !important;
        }

        .dataTables_filter input::placeholder {
            color: #94a3b8 !important;
            font-size: 14px !important;
            font-weight: 400 !important;
        }

        /* ── Entries count & Sort meta row ("Showing 4 | Sort: Product Style Name") ── */
        .dataTables_info,
        .new-style-table .dataTables_info {
            font-size: 13.5px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            padding: 0 4px 12px 4px !important;
            margin: 0 !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
        }

        .dataTables_info::after {
            content: "Sort: Product Style Name" !important;
            font-size: 13px !important;
            color: #64748b !important;
            font-weight: 500 !important;
        }

        /* Hide entries length dropdown on mobile */
        .dataTables_length {
            display: none !important;
        }

        /* ── Hide table header ── */
        #emblishment_table thead {
            display: none !important;
        }

        /* ── Table container ── */
        .col-md-12.new-style-table {
            padding: 0 !important;
        }

        .table-responsive {
            overflow: visible !important;
            border: none !important;
        }

        #emblishment_table {
            display: block !important;
            width: 100% !important;
            border: none !important;
            background: transparent !important;
        }

        .new-style-table table tr {
            border-bottom: none !important;
            border-top: none !important;
            background-color: transparent !important;
        }

        .new-style-table table tbody tr:hover {
            background-color: transparent !important;
        }

        .new-style-table th,
        .new-style-table td {
            padding: 0 !important;
            vertical-align: top !important;
        }

        .new-style-table .table tbody td,
        .new-style-table .table tbody td a {
            padding: 0 !important;
            font-size: inherit !important;
        }

        /* ── tbody: flex column of cards ── */
        #emblishment_table tbody {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            width: 100% !important;
        }

        /* ── Each row = Modern White Card with 16px radius ── */
        #emblishment_table tbody tr {
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: flex-start !important;
            position: relative !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 18px !important;
            padding: 16px 16px !important;
            box-shadow: 0 1px 4px rgba(0,0,0,0.03) !important;
            box-sizing: border-box !important;
            width: 100% !important;
            min-height: 0 !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
        }

        /* Strip default table cell borders/padding */
        #emblishment_table tbody tr td {
            border: none !important;
            padding: 0 !important;
            background: transparent !important;
            min-height: 0 !important;
        }

        /* ── 1. Fit Name (td.tagline-name) ── */
        #emblishment_table tbody tr td.tagline-name {
            order: 1 !important;
            flex: 1 1 calc(100% - 32px) !important;
            max-width: calc(100% - 32px) !important;
            min-width: 0 !important;
            display: flex !important;
            align-items: center !important;
            min-height: 36px !important;
        }

        #emblishment_table tbody tr td.tagline-name a.edit {
            font-size: 14px !important;
            font-weight: 600 !important;
            color: #1F2933 !important;
            text-decoration: none !important;
            word-break: break-word !important;
            overflow-wrap: anywhere !important;
            white-space: normal !important;
            line-height: 1.3 !important;
            display: block !important;
            padding-right: 84px !important;
        }

        /* Edit pill button inside name row matching image 1 */
        #emblishment_table tbody tr td.tagline-name a.edit::after {
            content: "Edit" !important;
            position: absolute !important;
            top: 19px !important;
            right: 44px !important;
            height: 28px !important;
            display: inline-flex !important;
            align-items: center !important;
            padding: 0 12px 0 28px !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 10px !important;
            background: #ffffff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%23334155' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7'/><path d='M18.5 2.5a2.1 2.1 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z'/></svg>") 9px center no-repeat !important;
            color: #334155 !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03) !important;
        }

        /* Chevron on top-right (collapse/expand indicator) */
        #emblishment_table tbody tr::after {
            content: "\f078" !important; /* chevron-down */
            font-family: 'Font Awesome 5 Free', 'FontAwesome' !important;
            font-weight: 900 !important;
            position: absolute !important;
            right: 18px !important;
            top: 22px !important;
            font-size: 13px !important;
            color: #1e293b !important;
            pointer-events: none !important;
        }

        /* ── 2. Created At (td.created-at) ── */
        #emblishment_table tbody tr td.created-at {
            order: 2 !important;
            width: calc(50% - 6px) !important;
            margin-top: 14px !important;
            margin-right: 6px !important;
            padding: 12px 14px 12px 48px !important;
            background: #F2F3F4 url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%231e293b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><rect x='3' y='4' width='18' height='18' rx='2' ry='2'></rect><line x1='16' y1='2' x2='16' y2='6'></line><line x1='8' y1='2' x2='8' y2='6'></line><line x1='3' y1='10' x2='21' y2='10'></line></svg>") 14px 14px no-repeat !important;
            border-radius: 14px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #1F2933 !important;
            box-sizing: border-box !important;
            line-height: 1.4 !important;
        }

        #emblishment_table tbody tr td.created-at::before {
            content: "Created" !important;
            display: block !important;
            font-size: 11.5px !important;
            font-weight: 500 !important;
            color: #6B7280 !important;
            margin-bottom: 2px !important;
        }

        /* ── 3. Last Updated (td.updated-at) ── */
        #emblishment_table tbody tr td.updated-at {
            order: 3 !important;
            width: calc(50% - 6px) !important;
            margin-top: 14px !important;
            margin-left: 6px !important;
            padding: 12px 14px 12px 48px !important;
            background: #F2F3F4 url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%231e293b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><circle cx='12' cy='12' r='10'></circle><polyline points='12 6 12 12 16 14'></polyline></svg>") 14px 14px no-repeat !important;
            border-radius: 14px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #1F2933 !important;
            box-sizing: border-box !important;
            line-height: 1.4 !important;
        }

        #emblishment_table tbody tr td.updated-at::before {
            content: "Last Updated" !important;
            display: block !important;
            font-size: 11.5px !important;
            font-weight: 500 !important;
            color: #6B7280 !important;
            margin-bottom: 2px !important;
        }

        /* ── 4. Fit Description (td.tagline-description) ── */
        #emblishment_table tbody tr td.tagline-description {
            order: 4 !important;
            width: 100% !important;
            margin-top: 10px !important;
            padding: 12px 14px !important;
            background: #F2F3F4 !important;
            border-radius: 14px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #1e293b !important;
            box-sizing: border-box !important;
            line-height: 1.4 !important;
            min-height: 54px !important;
        }

        #emblishment_table tbody tr td.tagline-description::before {
            content: "Fit description" !important;
            display: block !important;
            font-size: 11.5px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            margin-bottom: 2px !important;
        }

        /* ── COLLAPSIBLE STATE (is-collapsed) ── */
        /* Collapsed (default): hide created-at, updated-at, and tagline-description */
        #emblishment_table tbody tr.is-collapsed td.created-at,
        #emblishment_table tbody tr.is-collapsed td.updated-at,
        #emblishment_table tbody tr.is-collapsed td.tagline-description {
            display: none !important;
        }

        #emblishment_table tbody tr.is-collapsed::after {
            content: "\f078" !important; /* chevron-down */
        }

        #emblishment_table tbody tr:not(.is-collapsed)::after {
            content: "\f077" !important; /* chevron-up */
        }

        /* ── Pagination ── */
        .dataTables_paginate {
            display: flex !important;
            justify-content: center !important;
            margin-top: 16px !important;
            width: 100% !important;
        }

        .dataTables_paginate ul.pagination {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 4px !important;
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
            background-color: #14b8a6 !important;
            border-color: #14b8a6 !important;
            color: #ffffff !important;
            font-weight: 700 !important;
        }

        /* ── Modal styling on mobile (Add & Edit Fit Modals) ── */
        #fit_create_modal .modal-dialog,
        #master_fit_edit_modal .modal-dialog {
            margin: 16px auto !important;
            max-width: calc(100% - 32px) !important;
        }

        #fit_create_modal .modal-content,
        #master_fit_edit_modal .modal-content {
            border-radius: 24px !important;
            border: 1px solid #f1f5f9 !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
            background: #ffffff !important;
            overflow: hidden !important;
        }

        #fit_create_modal .modal-header,
        #master_fit_edit_modal .modal-header {
            padding: 22px 24px 18px 24px !important;
            border-bottom: 1px solid #eef2f6 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            background: #ffffff !important;
        }

        #fit_create_modal .modal-title,
        #master_fit_edit_modal .modal-title {
            font-size: 20px !important;
            font-weight: 800 !important;
            color: #111827 !important;
            margin: 0 !important;
            letter-spacing: -0.3px !important;
        }

        #fit_create_modal .modal-header button.close,
        #master_fit_edit_modal .modal-header button.close {
            font-size: 24px !important;
            color: #94a3b8 !important;
            opacity: 1 !important;
            padding: 0 !important;
            margin: 0 !important;
            background: transparent !important;
            border: none !important;
            line-height: 1 !important;
            outline: none !important;
            font-weight: 300 !important;
        }

        /* #fit_create_modal .modal-body,
        #master_fit_edit_modal .modal-body {
            padding: 16px 24px !important;
            background: #ffffff !important;
        } */

        #fit_create_modal .modal-body label,
        #master_fit_edit_modal .modal-body label {
            display: block !important;
            width: 100% !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            margin-bottom: 8px !important;
        }

        #fit_create_modal .modal-body label .text-danger,
        #master_fit_edit_modal .modal-body label .text-danger {
            color: #ef4444 !important;
            margin-left: 2px !important;
        }

        #fit_create_modal input[type="text"],
        #master_fit_edit_modal input[type="text"] {
            width: 100% !important;
            height: 48px !important;
            border-radius: 12px !important;
            border: 1.5px solid #d1d5db !important;
            padding: 10px 16px !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            color: #111827 !important;
            background: #ffffff !important;
            box-shadow: none !important;
            outline: none !important;
            box-sizing: border-box !important;
        }

        #fit_create_modal textarea,
        #master_fit_edit_modal textarea {
            width: 100% !important;
            border-radius: 12px !important;
            border: 1.5px solid #d1d5db !important;
            padding: 12px 16px !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            color: #111827 !important;
            background: #ffffff !important;
            box-shadow: none !important;
            outline: none !important;
            box-sizing: border-box !important;
        }

        #fit_create_modal .modal-footer,
        #master_fit_edit_modal .card-footer {
            padding: 16px 24px 24px 24px !important;
            border-top: none !important;
            background: #ffffff !important;
        }

        #fit_create_modal .control-btns,
        #master_fit_edit_modal .control-btns {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 12px !important;
            width: 100% !important;
            padding: 0 !important;
        }

        #fit_create_modal .control-btns .btn,
        #master_fit_edit_modal .control-btns .btn {
            flex: 1 1 0 !important;
            height: 48px !important;
            border-radius: 12px !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            border: none !important;
            box-shadow: none !important;
            margin: 0 !important;
            cursor: pointer !important;
        }

        #fit_create_modal .control-btns .btn-secondary,
        #master_fit_edit_modal .control-btns .btn-secondary {
            background-color: #94a3b8 !important;
            color: #ffffff !important;
        }

        #fit_create_modal .control-btns .btn-success,
        #master_fit_edit_modal .control-btns .btn-success {
            background-color: #10b981 !important;
            color: #ffffff !important;
        }

        #master_fit_edit_modal .control-btns .btn-danger {
            background-color: #dc2626 !important;
            color: #ffffff !important;
        }
    }
</style>

<div class="container-fluid mb-5 content-position">
    {{-- <div class="se-pre-con"></div> --}}

    @section('order-header')
        <span>FITS</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="row col-md-12" style="padding: 0rem;">
        <div class="col-md-4 ml-auto text-right mt-3">

        </div>
    </div>

    <div class="col-md-12">
        <div class="card" style="border: unset;">

                <div class="col-md-4 ml-auto mb-2 mt-2">
                    <table class="btn-inside-table" style="width: 100%">
                        <tr>
                            <td style="width: 10%"></td>
                            <td>
                                {{-- <button class="styled-button" style="outline: unset;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                                    Table Layout
                                </button> --}}
                            </td>
                            <td>
                                <button class="btn-green-filled" style="outline: unset;" href="#" data-toggle="modal" data-target="#fit_create_modal" title="Add New Product Fit">
                                    <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD PRODUCT FIT
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-12 new-style-table">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="emblishment_table">
                            <thead>
                                <th class="tagline-name" scope="col">Fit name</th>
                                <th class="tagline-name" scope="col">Fit Description</th>
                                <th class="created-at" scope="col">Created At</th>
                                <th class="updated-at" scope="col">Updated At</th>
                            </thead>

                            <tbody class="list">
                                @foreach ($masterFits as $masterFit)
                                <tr>
                                    <td class="tagline-name"><a href="#" class="edit" data-value="{{$masterFit->id}}">{{$masterFit->fit_name}}</a></td>
                                    <td class="tagline-description">{{$masterFit->description}}</td>
                                    <td class="created-at">{{$masterFit->created_at->format('m-d-Y')}}</td>
                                    <td class="updated-at">{{$masterFit->updated_at->format('m-d-Y')}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>

</div>

@include('pages.masters.fits.create')
@include('pages.masters.fits.edit')

<script>

    $(document).ready(function() {
        // Attach the click event for edit buttons
        setupEditButtonClick();

        // Mobile View Collapse / Expand Logic
        const isMobile = () => window.innerWidth <= 768;

        const setupMobileCards = () => {
            if (!isMobile()) return;
            $('#emblishment_table tbody tr:not(.toggle-init)').each(function () {
                $(this).addClass('is-collapsed toggle-init');
            });
        };

        setupMobileCards();
        $(window).on('resize', setupMobileCards);
        $('#emblishment_table').on('draw.dt', setupMobileCards);

        // Toggle card collapse / expand on click
        $('#emblishment_table').on('click', 'tbody tr', function (e) {
            if (isMobile() && !$(e.target).closest('.edit').length) {
                $(this).toggleClass('is-collapsed');
            }
        });
    });

    function setupEditButtonClick() {
        $("body").on("click", ".edit", handleEditClick);
    }

    function handleEditClick(e) {
        if (e && e.preventDefault) e.preventDefault();
        var productTaglineId = $(this).data('value');
        console.log(productTaglineId);

        // Set the value in the hidden input field and show the modal
        $('#master_fit_id').val(productTaglineId);
        $('#master_fit_edit_modal').modal('show');
    }

</script>
@endsection
