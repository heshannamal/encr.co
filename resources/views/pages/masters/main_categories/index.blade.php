@extends('layouts.app', ['activePage' => 'catalog_categories', 'titlePage' => __('Catalog Categories')])

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

    /* MOBILE RESPONSIVE STYLES (max-width: 768px) */
    @media (max-width: 768px) {

        body {
            background-color: #f8fafc !important;
        }

        /* Page wrapper */
        .content-position {
            position: relative !important;
            top: 0 !important;
            padding: 12px 16px 30px 16px !important;
        }

        /* Top search input on mobile */
        #searchbox {
            display: block !important;
            width: 100% !important;
            height: 48px !important;
            border-radius: 14px !important;
            border: 1px solid #e2e8f0 !important;
            background-color: #ffffff !important;
            padding: 10px 16px 10px 44px !important;
            font-size: 14px !important;
            color: #334155 !important;
            box-sizing: border-box !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03) !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'%3E%3C/circle%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'%3E%3C/line%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: 14px center !important;
            margin: 0 0 14px 0 !important;
            outline: none !important;
        }

        #searchbox::placeholder {
            color: #94a3b8 !important;
            font-size: 14px !important;
        }

        /* Card and inner wrapper */
        .card {
            background-color: transparent !important;
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            margin-top: 0 !important;
        }

        .col-md-12 {
            padding: 0 !important;
        }

        /* Container of Add button */
        .card > .col-md-4.ml-auto {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 0 14px 0 !important;
        }

        table.btn-inside-table {
            display: block !important;
            width: 100% !important;
        }

        table.btn-inside-table tbody,
        table.btn-inside-table tr {
            display: block !important;
            width: 100% !important;
        }

        table.btn-inside-table tr td:first-child,
        table.btn-inside-table tr td:nth-child(2) {
            display: none !important;
        }

        table.btn-inside-table tr td:last-child {
            display: block !important;
            width: 100% !important;
            padding: 0 !important;
        }

        /* ── +Add Catalog Category button — full-width teal pill ── */
        .btn-green-filled {
            display: flex !important;
            width: 100% !important;
            height: 44px !important;
            background-color: #14B8A6 !important;
            border: none !important;
            border-radius: 12px !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: 0 2px 8px rgba(20,184,166,0.25) !important;
            cursor: pointer !important;
            margin: 0 !important;
        }

        .btn-green-filled:hover,
        .btn-green-filled:active {
            background-color: #0d9488 !important;
            color: #ffffff !important;
        }

        /* ── DataTables wrapper ── */
        .dataTables_wrapper {
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
            padding: 0 !important;
        }

        .dataTables_wrapper .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
            width: 100% !important;
        }

        .dataTables_wrapper .row > [class*="col-"] {
            padding-left: 0 !important;
            padding-right: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }

        /* ── Search bar (DataTables filter) —  ── */
        .dataTables_filter {
            order: 1 !important;
            width: 100% !important;
            margin: 0 0 14px 0 !important;
            text-align: left !important;
            float: none !important;
        }

        .dataTables_filter label {
            width: 100% !important;
            display: block !important;
            color: transparent !important;
            font-size: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            position: relative !important;
        }

        .dataTables_filter input,
        .dataTables_filter input[type="search"],
        .dataTables_filter input.form-control {
            display: block !important;
            width: 100% !important;
            height: 48px !important;
            border-radius: 14px !important;
            border: 1px solid #e2e8f0 !important;
            background-color: #ffffff !important;
            padding: 10px 16px 10px 44px !important;
            font-size: 14px !important;
            color: #334155 !important;
            box-sizing: border-box !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03) !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'%3E%3C/circle%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'%3E%3C/line%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: 14px center !important;
            margin: 0 !important;
            outline: none !important;
        }

        .dataTables_filter input::placeholder {
            color: #94a3b8 !important;
            font-size: 14px !important;
        }

        /* Show entries: hide */
        .dataTables_length {
            display: none !important;
        }

        /* Showing N entries info */
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
            order: 3 !important;
        }

        /* ── Table → Card list ── */
        .col-md-12.new-style-table {
            padding: 0 !important;
            order: 4 !important;
        }

        .table-responsive {
            overflow: visible !important;
            border: none !important;
            margin: 0 !important;
        }

        #emblishment_table {
            display: block !important;
            width: 100% !important;
            border: none !important;
            background: transparent !important;
        }

        /* Hide table header on mobile */
        #emblishment_table thead {
            display: none !important;
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

        /* tbody: flex column of cards */
        #emblishment_table tbody {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            width: 100% !important;
        }

        /* Each row = white card matching  */
        #emblishment_table tbody tr {
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
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
            transition: box-shadow 0.2s ease !important;
        }

        #emblishment_table tbody tr td {
            border: none !important;
            padding: 0 !important;
            background: transparent !important;
        }

        /* Catalog Category Name cell */
        #emblishment_table tbody tr td.tagline-name {
            order: 1 !important;
            flex: 1 1 auto !important;
            min-width: 0 !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
            position: relative !important;
        }

        #emblishment_table tbody tr td.tagline-name a.edit {
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #1F2933 !important;
            text-decoration: none !important;
            word-break: break-word !important;
            white-space: normal !important;
            line-height: 1.3 !important;
            display: block !important;
            padding-right: 80px !important;
            min-height: 24px !important;
        }

        /* Invisible overlay covering the Edit pill area on top-right of card */
        #emblishment_table tbody tr td.tagline-name a.edit::after {
            content: "" !important;
            position: absolute !important;
            top: -16px !important;
            right: -16px !important;
            width: 120px !important;
            height: 60px !important;
            z-index: 5 !important;
            cursor: pointer !important;
        }

        /* "Created AT  YYYY-MM-DD" label under the name */
        #emblishment_table tbody tr td.created-at {
            order: 2 !important;
            display: block !important;
            width: 100% !important;
            margin-top: 4px !important;
            font-size: 12px !important;
            font-weight: 400 !important;
            color: #1F2933 !important;
            padding: 0 !important;
            box-sizing: border-box !important;
        }

        /* Insert "Created AT  " label before the date text */
        #emblishment_table tbody tr td.created-at::before {
            content: "Created " !important;
            font-size: 12px !important;
            font-weight: 400 !important;
            color: #1F2933 !important;
        }

        /* ── Edit pill button — absolute right of card ── */
        #emblishment_table tbody tr::after {
            content: "Edit" !important;
            position: absolute !important;
            top: 50% !important;
            right: 16px !important;
            transform: translateY(-50%) !important;
            height: 32px !important;
            display: inline-flex !important;
            align-items: center !important;
            padding: 0 12px 0 28px !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 10px !important;
            background: #ffffff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%23334155' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7'/><path d='M18.5 2.5a2.1 2.1 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z'/></svg>") 9px center no-repeat !important;
            color: #334155 !important;
            font-family: 'Open Sans', sans-serif !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03) !important;
            pointer-events: none !important;
        }

        /* ── Pagination ── */
        .dataTables_paginate {
            display: flex !important;
            justify-content: center !important;
            margin-top: 16px !important;
            width: 100% !important;
            order: 5 !important;
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
            background-color: #14B8A6 !important;
            border-color: #14B8A6 !important;
            color: #ffffff !important;
            font-weight: 700 !important;
        }

        #catalog_category_create_modal .modal-dialog,
        #catalog_category_edit_modal .modal-dialog {
            margin: 16px auto !important;
            max-width: calc(100% - 32px) !important;
        }

        #catalog_category_create_modal .modal-content,
        #catalog_category_edit_modal .modal-content {
            border-radius: 24px !important;
            border: 1px solid #f1f5f9 !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
            background: #ffffff !important;
            overflow: hidden !important;
        }

        #catalog_category_create_modal .modal-header,
        #catalog_category_edit_modal .modal-header {
            padding: 22px 24px 18px 24px !important;
            border-bottom: 1px solid #eef2f6 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            background: #ffffff !important;
        }

        #catalog_category_create_modal .modal-title,
        #catalog_category_edit_modal .modal-title {
            font-size: 20px !important;
            font-weight: 800 !important;
            color: #111827 !important;
            margin: 0 !important;
            letter-spacing: -0.3px !important;
        }

        #catalog_category_create_modal .modal-header button.close,
        #catalog_category_edit_modal .modal-header button.close {
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

        #catalog_category_create_modal .modal-body,
        #catalog_category_edit_modal .modal-body {
            padding: 20px 24px 10px 24px !important;
            background: #ffffff !important;
            position: relative !important;
        }

        /* ── FIELD 1: Catalog Category Name ── */
        #catalog_category_create_modal .modal-body .col-md-12:first-child,
        #catalog_category_edit_modal .modal-body .col-md-12:first-child {
            width: 100% !important;
            padding: 0 !important;
            margin: 0 0 18px 0 !important;
        }

        #catalog_category_create_modal .modal-body label.form-label,
        #catalog_category_edit_modal .modal-body label.form-label {
            display: block !important;
            width: 100% !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            margin-bottom: 8px !important;
        }

        #new_catalog_category_name,
        #edit_catalog_category_name {
            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
            height: 52px !important;
            border-radius: 14px !important;
            border: 1.5px solid #d1d5db !important;
            padding: 10px 16px !important;
            font-size: 15px !important;
            font-weight: 500 !important;
            color: #111827 !important;
            background: #ffffff !important;
            box-shadow: none !important;
            outline: none !important;
            box-sizing: border-box !important;
            display: block !important;
        }

        #new_catalog_category_name::placeholder {
            color: #94a3b8 !important;
            font-size: 15px !important;
        }

        /* ── FIELD 2: Catalog Category Picture Card Container ── */
        #catalog_category_create_modal .modal-body .col-md-12.form-field.mt-5,
        #catalog_category_edit_modal .modal-body .col-md-12.form-field.mt-5 {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            display: block !important;
            margin-top: 0 !important;
            margin-bottom: 20px !important;
            position: relative !important;
            padding: 0 !important;
        }

        /* Label + Red Resolution Note */
        #catalog_category_create_modal .modal-body .col-md-12.form-field.mt-5 > div:first-child,
        #catalog_category_edit_modal .modal-body .col-md-12.form-field.mt-5 > div:first-child {
            width: 100% !important;
            max-width: 100% !important;
            display: block !important;
        }

        #catalog_category_create_modal .modal-body .col-md-12.form-field.mt-5 label.form-lable,
        #catalog_category_edit_modal .modal-body .col-md-12.form-field.mt-5 label.form-lable {
            display: block !important;
            width: 100% !important;
            max-width: 100% !important;
            min-width: 100% !important;
            white-space: nowrap !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            margin-top: 10px !important;
            margin-bottom: 4px !important;
            line-height: 1.3 !important;
            float: none !important;
        }

        #catalog_category_create_modal .modal-body .col-md-12.form-field.mt-5 p,
        #catalog_category_edit_modal .modal-body .col-md-12.form-field.mt-5 p {
            color: #ef4444 !important;
            font-size: 11.5px !important;
            font-weight: 400 !important;
            margin: 0 0 10px 0 !important;
            line-height: 1.3 !important;
        }

        /* Outer Rounded Box for Upload card */
        #catalog_category_create_modal .modal-body .col-md-12.form-field.mt-5::after,
        #catalog_category_edit_modal .modal-body .col-md-12.form-field.mt-5::after {
            content: "" !important;
            display: block !important;
            width: 100% !important;
            height: 140px !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 16px !important;
            box-sizing: border-box !important;
        }

        /* Upload button pill on the left inside the box */
        #catalog_category_create_modal .modal-body .col-md-12.form-field.mt-5::before,
        #catalog_category_edit_modal .modal-body .col-md-12.form-field.mt-5::before {
            content: "Upload" !important;
            position: absolute !important;
            left: 36px !important;
            bottom: 48px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 82px !important;
            height: 40px !important;
            border: 1.5px solid #2563eb !important;
            border-radius: 12px !important;
            color: #2563eb !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            background: #ffffff !important;
            pointer-events: none !important;
            z-index: 2 !important;
        }

        /* Transparent file input overlay over the Upload pill */
        #catalog_category_create_modal input#new_profile_pic,
        #catalog_category_edit_modal input#edit_profile_pic {
            position: absolute !important;
            left: 36px !important;
            bottom: 48px !important;
            width: 82px !important;
            height: 40px !important;
            opacity: 0 !important;
            cursor: pointer !important;
            z-index: 5 !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Preview container on the right inside the card */
        #catalog_category_create_modal .modal-body .col-md-6.form-field.mt-4,
        #catalog_category_edit_modal .modal-body .col-md-6.form-field.mt-4 {
            position: absolute !important;
            right: 36px !important;
            bottom: 46px !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 110px !important;
            height: 110px !important;
            z-index: 4 !important;
            display: block !important;
        }

        #new_image_container,
        #edit_image_container {
            width: 110px !important;
            height: 110px !important;
            margin: 0 !important;
            border: 1.5px dashed #cbd5e1 !important;
            border-radius: 16px !important;
            background-color: #f8fafc !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            overflow: hidden !important;
            box-sizing: border-box !important;
        }

        #new_image_preview,
        #edit_image_preview {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            display: block !important;
        }

        /* Placeholder icon inside dashed box */
        #new_image_preview[src*="placeholder"],
        #edit_image_preview[src*="placeholder"],
        #edit_image_preview:not([src]) {
            content: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 24 24' fill='none' stroke='%23334155' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='3' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Ccircle cx='8.5' cy='8.5' r='1.5'%3E%3C/circle%3E%3Cpolyline points='21 15 16 10 5 21'%3E%3C/polyline%3E%3C/svg%3E") !important;
            width: 32px !important;
            height: 32px !important;
            object-fit: contain !important;
        }

        /* Modal footer */
        #catalog_category_create_modal .modal-footer,
        #catalog_category_edit_modal .card-footer {
            padding: 16px 24px 24px 24px !important;
            border-top: none !important;
            background: #ffffff !important;
        }

        /* Button row */
        #catalog_category_create_modal .control-btns,
        #catalog_category_edit_modal .control-btns {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 10px !important;
            width: 100% !important;
            padding: 0 !important;
        }

        #catalog_category_create_modal .control-btns .btn,
        #catalog_category_edit_modal .control-btns .btn {
            flex: 1 1 0 !important;
            height: 50px !important;
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

        /* Cancel button — grey */
        #catalog_category_create_modal .control-btns .btn-secondary,
        #catalog_category_edit_modal .control-btns .btn-secondary {
            background-color: #94a3b8 !important;
            color: #ffffff !important;
        }

        /* Save / Update button — green */
        #catalog_category_create_modal .control-btns .btn-success,
        #catalog_category_edit_modal .control-btns .btn-success {
            background-color: #16a34a !important;
            color: #ffffff !important;
        }

        /* Delete button — red */
        #catalog_category_edit_modal .control-btns .btn-danger {
            background-color: #dc2626 !important;
            color: #ffffff !important;
            order: -1 !important;
        }
        
        /* ── Empty state (no matching records) ── */
        #emblishment_table tbody tr:has(td.dataTables_empty) {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            padding: 24px 16px !important;
            cursor: default !important;
            justify-content: center !important;
        }

        #emblishment_table tbody tr:has(td.dataTables_empty)::after {
            display: none !important;
            content: none !important;
        }

        #emblishment_table tbody tr td.dataTables_empty {
            width: 100% !important;
            text-align: center !important;
            font-size: 14px !important;
            color: #94a3b8 !important;
        }

        /* Hide pagination when there are no results */
        .dataTables_wrapper:has(td.dataTables_empty) .dataTables_paginate {
            display: none !important;
        }
    }
</style>


<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span class="headder_size2">CATALOG CATEGORY</span>
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
                            </td>
                            <td>
                                <button class="btn-green-filled" style="outline: unset;" href="#" data-toggle="modal" data-target="#catalog_category_create_modal" title="Add New Catalog Category">
                                    <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD CATALOG CATEGORY
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-12 new-style-table">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="emblishment_table">
                            <thead>
                                <th class="tagline-name" scope="col">Catalog Category</th>
                                <th class="created-at" scope="col">Created At</th>
                            </thead>

                            <tbody class="list">
                                @foreach ($mainCategories as $mainCategory)
                                <tr>
                                    <td class="tagline-name"><a href="#" class="edit" data-value="{{$mainCategory->id}}">{{$mainCategory->category_name}}</a></td>
                                    <td class="created-at">{{$mainCategory->created_at->format('m-d-Y')}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>

</div>


@include('pages.masters.main_categories.create')
@include('pages.masters.main_categories.edit')

<script>

    $(document).ready(function() {
        // Attach the click event for edit buttons
        setupEditButtonClick();
    });

    function setupEditButtonClick() {
        $("body").on("click", ".edit", handleEditClick);
    }

    function handleEditClick() {
        var catalogCategoryId = $(this).data('value');
        console.log(catalogCategoryId);

        // Set the value in the hidden input field and show the modal
        $('#catalog_category_id').val(catalogCategoryId);
        $('#catalog_category_edit_modal').modal('show');
    }

</script>

<!-- search -->
<script>
$(document).ready(function () {
    $('#emblishment_table').DataTable({
        order: [],
        pageLength: 10,
        language: {
            search: '',
            searchPlaceholder: 'Search catalog categories...'
        }
    });

    $('body').on('click', '.edit', function (e) {
        e.preventDefault();
        $('#catalog_category_id').val($(this).data('value'));
        $('#catalog_category_edit_modal').modal('show');
    });
});
</script>
@endsection
