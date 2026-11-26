{{-- {{ dd($projectType) }} --}}
@extends('layouts.app', ['activePage' => 'project_types', 'titlePage' => __('Project Types')])

@section('content')
<style>

#searchbox{
        border: 2px solid #ffffff;
        height: 35px;
        /* width: 250px; */
        width: 100%;
        border-radius: 30px;
        padding: 0px 5px;
        background-color: #ffffff1a;
        margin-top: 10px;
        color: #ffffff;
    }
    #searchbox::placeholder {
        color: #aaaaaa;
        opacity: 1; /* Firefox */
        font-size: 14px;
    }
    #searchbox:focus {
        outline: 0px;
    }
    #searchbox:-ms-input-placeholder { /* Internet Explorer 10-11 */
        color: #aaaaaa;
    }
    #searchbox::-ms-input-placeholder { /* Microsoft Edge */
        color: #aaaaaa;
    }
    .btn-text {
        font-size: small;
        position: relative;
        top: -2px;
        right: -8px;
    }
    .content-position {
        position: relative;
        top: -47px;
    }
    .add-project-btn {
        position: relative;
        right: -66px;
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
    .edit-item-label {
        width: 50% !important;
        position: relative;
        top: 6px;
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
    body {
        font-family: 'Open Sans', 'sans-serif' !important;
    }

    /* MOBILE RESPONSIVE STYLES (max-width: 768px) */
    @media (max-width: 768px) {
        body {
            background-color: #f8fafc !important;
            font-family: 'Open Sans', 'sans-serif' !important;
        }

        .content-position {
            position: relative !important;
            top: 0 !important;
            padding: 12px 16px 30px 16px !important;
        }

        /* Top Add Sport row */
        .content-position > .row.col-md-12 {
            display: block !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 0 12px 0 !important;
        }

        .content-position > .row.col-md-12 .col-md-4 {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            text-align: left !important;
        }

        /* +Add Embellishment Types / +Add Sport button */
        .btn-green-filled {
            display: flex !important;
            width: 100% !important;
            height: 48px !important;
            background-color: #14b8a6 !important;
            border: none !important;
            border-radius: 12px !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: 0 2px 8px rgba(20,184,166,0.25) !important;
            cursor: pointer !important;
            margin: 0 0 14px 0 !important;
            text-transform: none !important;
            order: 2 !important;
        }

        .btn-green-filled:hover,
        .btn-green-filled:active {
            background-color: #0d9488 !important;
            color: #ffffff !important;
        }

        /* Card container */
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

        .col-md-12.mt-4 {
            margin-top: 0 !important;
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

        /* Search input styled as "Search this product" */
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

        /* Hide show entries */
        .dataTables_length {
            display: none !important;
        }

        /* "Showing 4" and "Sort: Product Style Name" header bar */
        .dataTables_info,
        .new-style-table .dataTables_info {
            font-size: 13.5px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            padding: 0 4px 10px 4px !important;
            margin: 0 !important;
            order: 3 !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            width: 100% !important;
        }

        .dataTables_info::after,
        .new-style-table .dataTables_info::after {
            content: "Sort: Product Style Name" !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            margin-left: auto !important;
        }

        /* ── Table -> Card transformation ── */
        .col-md-12.new-style-table {
            padding: 0 !important;
            order: 4 !important;
        }

        .table-responsive {
            overflow: visible !important;
            border: none !important;
            margin: 0 !important;
        }

        #user_groups_table {
            display: block !important;
            width: 100% !important;
            border: none !important;
            background: transparent !important;
        }

        #user_groups_table thead {
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

        /* tbody flex cards container */
        #user_groups_table tbody {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            width: 100% !important;
        }

        /* Each Row = White Card with rounded corners and subtle border */
        #user_groups_table tbody tr {
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

        #user_groups_table tbody tr td {
            border: none !important;
            padding: 0 !important;
            background: transparent !important;
        }

        /* Sport Name cell (e.g. All, Baseball, Basketball, etc.) */
        #user_groups_table tbody tr td.type,
        #user_groups_table tbody tr td.sport-name {
            order: 1 !important;
            flex: 1 1 auto !important;
            min-width: 0 !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
        }

        #user_groups_table tbody tr td.sport-name a.edit {
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #1F2933 !important;
            text-decoration: none !important;
            word-break: break-word !important;
            white-space: normal !important;
            line-height: 1.3 !important;
            display: block !important;
            padding-right: 80px !important;
        }

        /* Created At Date cell (under sport name) */
        #user_groups_table tbody tr td:nth-child(2) {
            order: 2 !important;
            display: block !important;
            width: 100% !important;
            margin-top: 4px !important;
            font-size: 12px !important;
            font-weight: 400 !important;
            color: #6B7280 !important;
            padding: 0 !important;
            box-sizing: border-box !important;
        }

        #user_groups_table tbody tr td:nth-child(2)::before {
            content: "Created " !important;
            font-size: 12px !important;
            font-weight: 400 !important;
            color: #6B7280 !important;
        }

        /* ── Edit pill button — absolute right of card ── */
        #user_groups_table tbody tr::after {
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
            font-size: 12px !important;
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
            background-color: #14b8a6 !important;
            border-color: #14b8a6 !important;
            color: #ffffff !important;
            font-weight: 700 !important;
        }

        /* MODAL DIALOG STYLES (Add & Edit Sport) */
        #sport_create_modal .modal-dialog,
        #sport_edit_modal .modal-dialog {
            margin: 16px auto !important;
            max-width: calc(100% - 24px) !important;
            width: calc(100% - 24px) !important;
        }

        #sport_create_modal .modal-content,
        #sport_edit_modal .modal-content {
            border-radius: 24px !important;
            border: 1px solid #f1f5f9 !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
            background: #ffffff !important;
            overflow: hidden !important;
        }

        #sport_create_modal .modal-header,
        #sport_edit_modal .modal-header {
            padding: 22px 24px 18px 24px !important;
            border-bottom: 1px solid #eef2f6 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            background: #ffffff !important;
        }

        #sport_create_modal .modal-title,
        #sport_edit_modal .modal-title {
            font-size: 20px !important;
            font-weight: 800 !important;
            color: #111827 !important;
            margin: 0 !important;
            letter-spacing: -0.3px !important;
        }

        #sport_create_modal .modal-header button.close,
        #sport_edit_modal .modal-header button.close {
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

        #sport_create_modal .modal-body,
        #sport_edit_modal .modal-body {
            padding: 20px 22px 12px 22px !important;
            background: #ffffff !important;
        }

        /* Reset all Bootstrap row and col containers inside modal */
        #sport_create_modal .modal-body .row,
        #sport_edit_modal .modal-body .row {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            display: block !important;
            position: relative !important;
        }

        #sport_create_modal .modal-body .col-md-12,
        #sport_edit_modal .modal-body .col-md-12,
        #sport_create_modal .modal-body .col-md-8,
        #sport_edit_modal .modal-body .col-md-8,
        #sport_create_modal .modal-body .col-md-6,
        #sport_edit_modal .modal-body .col-md-6,
        #sport_create_modal .modal-body .col-md-4,
        #sport_edit_modal .modal-body .col-md-4 {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /* ── FIELD 1: SPORT NAME (Stacked: Label on top, Input below) ── */
        #sport_create_modal .modal-body .form-field,
        #sport_edit_modal .modal-body .form-field {
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
            width: 100% !important;
            max-width: 100% !important;
            margin-bottom: 0 !important;
        }

        #sport_create_modal .modal-body .col-md-12.form-field:first-child,
        #sport_edit_modal .modal-body .col-md-12.form-field:first-child {
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
            margin-bottom: 22px !important;
            padding: 0 !important;
        }

        #sport_create_modal .modal-body label.form-lable,
        #sport_edit_modal .modal-body label.form-lable,
        #sport_create_modal .modal-body label,
        #sport_edit_modal .modal-body label {
            display: block !important;
            width: 100% !important;
            max-width: 100% !important;
            font-size: 14.5px !important;
            font-weight: 700 !important;
            color: #111827 !important;
            margin: 0 0 8px 0 !important;
            padding: 0 !important;
            line-height: 1.3 !important;
            position: static !important;
            top: auto !important;
            left: auto !important;
            float: none !important;
        }

        #sport_create_modal input#sport_name,
        #sport_edit_modal input#sport_edit_name {
            display: block !important;
            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 auto !important;
            height: 48px !important;
            border-radius: 12px !important;
            border: 1.5px solid #d1d5db !important;
            padding: 10px 16px !important;
            font-size: 14px !important;
            font-weight: 400 !important;
            color: #111827 !important;
            background: #ffffff !important;
            box-shadow: none !important;
            outline: none !important;
            box-sizing: border-box !important;
            margin: 0 !important;
        }

        #sport_create_modal input#sport_name::placeholder,
        #sport_edit_modal input#sport_edit_name::placeholder {
            color: #94a3b8 !important;
            font-weight: 400 !important;
        }

        /* ── FIELD 2: SPORT PICTURE CARD ── */
        #sport_create_modal .modal-body .col-md-8.form-field.mt-5,
        #sport_edit_modal .modal-body .col-md-8.form-field.mt-5 {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            display: block !important;
            margin-top: 0 !important;
            margin-bottom: 22px !important;
            position: relative !important;
            padding: 0 !important;
        }

        /* Label + Red Resolution Note */
        #sport_create_modal .modal-body .col-md-8.form-field.mt-5 label.form-lable,
        #sport_edit_modal .modal-body .col-md-8.form-field.mt-5 label.form-lable {
            display: block !important;
            font-size: 14.5px !important;
            font-weight: 700 !important;
            color: #111827 !important;
            margin-top: 10px !important;
            margin-bottom: 8px !important;
            line-height: 1.2 !important;
        }

        #sport_create_modal .modal-body .col-md-8.form-field.mt-5 label.form-lable::after,
        #sport_edit_modal .modal-body .col-md-8.form-field.mt-5 label.form-lable::after {
            content: "\Aresolution of 96×96" !important;
            white-space: pre !important;
            display: block !important;
            color: #ef4444 !important;
            font-size: 11.5px !important;
            font-weight: 400 !important;
            margin-top: 3px !important;
        }

        /* Sport Picture Inner Rounded Card Box */
        #sport_create_modal .modal-body .col-md-8.form-field.mt-5::after,
        #sport_edit_modal .modal-body .col-md-8.form-field.mt-5::after {
            content: "" !important;
            display: block !important;
            width: 100% !important;
            height: 110px !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 14px !important;
            box-sizing: border-box !important;
        }

        /* Upload button pill on the left inside the card box */
        #sport_create_modal .modal-body .col-md-8.form-field.mt-5::before,
        #sport_edit_modal .modal-body .col-md-8.form-field.mt-5::before {
            content: "Upload" !important;
            position: absolute !important;
            left: 36px !important;
            bottom: 36px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 76px !important;
            height: 38px !important;
            border: 1.5px solid #2563eb !important;
            border-radius: 10px !important;
            color: #2563eb !important;
            font-size: 13.5px !important;
            font-weight: 600 !important;
            background: #ffffff !important;
            pointer-events: none !important;
            z-index: 2 !important;
        }

        /* Transparent file input overlay */
        #sport_create_modal input#new_profile_pic,
        #sport_edit_modal input#edit_profile_pic {
            position: absolute !important;
            left: 36px !important;
            bottom: 36px !important;
            width: 76px !important;
            height: 38px !important;
            opacity: 0 !important;
            cursor: pointer !important;
            z-index: 5 !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Sport Picture Preview Container — positioned inside the card box on the right */
        /* col-md-8 label is ~50px tall, card (::after) is 110px => center 80px preview at top: 65px */
        #sport_create_modal .modal-body .col-md-4.form-field.mt-5,
        #sport_edit_modal .modal-body .col-md-4.form-field.mt-5 {
            position: absolute !important;
            right: 18px !important;
            bottom: 15px !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 80px !important;
            height: 80px !important;
            z-index: 4 !important;
            display: block !important;
        }

        #sport_create_modal #new_image_container,
        #sport_edit_modal #edit_image_container {
            width: 80px !important;
            height: 80px !important;
            margin: 0 !important;
            border: 1.5px dashed #cbd5e1 !important;
            border-radius: 14px !important;
            background-color: #f1f5f9 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            overflow: hidden !important;
            box-sizing: border-box !important;
        }

        #sport_create_modal #new_image_preview,
        #sport_edit_modal #edit_image_preview {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            display: block !important;
        }

        #sport_create_modal #new_image_preview[src*="placeholder"],
        #sport_edit_modal #edit_image_preview[src*="placeholder"],
        #sport_edit_modal #edit_image_preview:not([src]) {
            content: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='26' height='26' viewBox='0 0 24 24' fill='none' stroke='%23334155' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='3' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Ccircle cx='8.5' cy='8.5' r='1.5'%3E%3C/circle%3E%3Cpolyline points='21 15 16 10 5 21'%3E%3C/polyline%3E%3C/svg%3E") !important;
            width: 26px !important;
            height: 26px !important;
            object-fit: contain !important;
        }

        /* ── FIELD 3: CATALOG PICTURE DROPZONE ── */
        #sport_create_modal .modal-body > .col-md-12 > .col-md-12.form-field.mt-5,
        #sport_edit_modal .modal-body > .col-md-12 > .col-md-12.form-field.mt-5 {
            width: 100% !important;
            max-width: 100% !important;
            margin-top: 0 !important;
            margin-bottom: 16px !important;
            padding: 0 !important;
            display: block !important;
            clear: both !important;
        }

        #sport_create_modal .modal-body > .col-md-12 > .col-md-12.form-field.mt-5 > div:first-child,
        #sport_edit_modal .modal-body > .col-md-12 > .col-md-12.form-field.mt-5 > div:first-child {
            width: 100% !important;
            margin-bottom: 8px !important;
        }

        #sport_create_modal .modal-body > .col-md-12 > .col-md-12.form-field.mt-5 label.form-lable,
        #sport_edit_modal .modal-body > .col-md-12 > .col-md-12.form-field.mt-5 label.form-lable {
            font-size: 14.5px !important;
            font-weight: 700 !important;
            color: #111827 !important;
            margin: 0 !important;
        }

        #sport_create_modal .modal-body > .col-md-12 > .col-md-12.form-field.mt-5 p,
        #sport_edit_modal .modal-body > .col-md-12 > .col-md-12.form-field.mt-5 p {
            font-size: 11.5px !important;
            color: #ef4444 !important;
            margin: 3px 0 0 0 !important;
            line-height: 1.3 !important;
        }

        /* Dashed dropzone upload card for Catalog Picture */
        #sport_create_modal .modal-body > .col-md-12 > .col-md-12.form-field.mt-5 > div:last-child,
        #sport_edit_modal .modal-body > .col-md-12 > .col-md-12.form-field.mt-5 > div:last-child {
            width: 100% !important;
            max-width: 100% !important;
            border: 1.5px dashed #cbd5e1 !important;
            border-radius: 14px !important;
            background-color: #ffffff !important;
            padding: 26px 16px 22px 16px !important;
            position: relative !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            box-sizing: border-box !important;
            text-align: center !important;
        }

        /* Media icon in circle for catalog upload box */
        #sport_create_modal .modal-body > .col-md-12 > .col-md-12.form-field.mt-5 > div:last-child::before,
        #sport_edit_modal .modal-body > .col-md-12 > .col-md-12.form-field.mt-5 > div:last-child::before {
            content: "" !important;
            width: 44px !important;
            height: 44px !important;
            border-radius: 50% !important;
            background-color: #f1f5f9 !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 24 24' fill='none' stroke='%23334155' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='3' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Ccircle cx='8.5' cy='8.5' r='1.5'%3E%3C/circle%3E%3Cpolyline points='21 15 16 10 5 21'%3E%3C/polyline%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
            margin-bottom: 12px !important;
            display: block !important;
        }

        /* Drag & drop helper text */
        #sport_create_modal .modal-body > .col-md-12 > .col-md-12.form-field.mt-5 > div:last-child::after,
        #sport_edit_modal .modal-body > .col-md-12 > .col-md-12.form-field.mt-5 > div:last-child::after {
            content: "Drag & drop Product Tagline video here\Aor CLICK HERE to upload Product Tagline video" !important;
            white-space: pre-wrap !important;
            font-size: 13.5px !important;
            font-weight: 500 !important;
            color: #1e293b !important;
            line-height: 1.4 !important;
            margin-bottom: 12px !important;
            max-width: 270px !important;
            display: block !important;
        }

        /* Upload button pill inside catalog dropzone */
        #sport_create_modal input#new_catalog_pic,
        #sport_edit_modal input#edit_catalog_pic {
            position: relative !important;
            left: auto !important;
            width: 76px !important;
            height: 38px !important;
            border: 1.5px solid #2563eb !important;
            border-radius: 10px !important;
            color: #2563eb !important;
            background: #ffffff !important;
            font-size: 0 !important;
            cursor: pointer !important;
            margin: 0 auto !important;
            display: block !important;
            z-index: 2 !important;
            box-sizing: border-box !important;
            padding: 0 !important;
        }

        #sport_create_modal input#new_catalog_pic::after,
        #sport_edit_modal input#edit_catalog_pic::after {
            content: "Upload" !important;
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 13.5px !important;
            font-weight: 600 !important;
            color: #2563eb !important;
            background: #ffffff !important;
            border-radius: 8px !important;
            pointer-events: none !important;
        }

        /* Hide the default empty placeholder image for create modal */
        #sport_create_modal .modal-body .col-md-6.form-field.mt-4 {
            display: none !important;
        }

        /* Edit modal preview box (shows existing image with dashed rounded border) */
        #sport_edit_modal .modal-body .col-md-6.form-field.mt-4 {
            width: 100% !important;
            max-width: 100% !important;
            margin-top: 14px !important;
            margin-bottom: 10px !important;
            padding: 0 !important;
            display: block !important;
        }

        #sport_edit_modal #edit_catalog_preview {
            width: 100% !important;
            max-height: 220px !important;
            object-fit: contain !important;
            border-radius: 14px !important;
            border: 1.5px dashed #cbd5e1 !important;
            display: block !important;
            box-sizing: border-box !important;
            padding: 10px !important;
            background: #ffffff !important;
        }

        #sport_edit_modal #edit_catalog_preview[src*="placeholder"],
        #sport_edit_modal #edit_catalog_preview[src=""] {
            display: none !important;
        }

        /* ── MODAL FOOTER BUTTONS ── */
        #sport_create_modal .modal-footer,
        #sport_edit_modal .modal-footer {
            padding: 14px 22px 22px 22px !important;
            border-top: none !important;
            background: #ffffff !important;
        }

        #sport_create_modal .control-btns,
        #sport_edit_modal .control-btns {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 12px !important;
            width: 100% !important;
            padding: 0 !important;
        }

        #sport_create_modal .control-btns .btn,
        #sport_edit_modal .control-btns .btn {
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
            text-transform: capitalize !important;
        }

        /* Cancel button - Grey (#94a3b8) */
        #sport_create_modal .control-btns .btn-secondary,
        #sport_edit_modal .control-btns .btn-secondary {
            background-color: #94a3b8 !important;
            color: #ffffff !important;
        }

        /* Save / Update button - Green (#16a34a) */
        #sport_create_modal .control-btns .btn-success,
        #sport_edit_modal .control-btns .btn-success {
            background-color: #16a34a !important;
            color: #ffffff !important;
        }

        /* Delete button - Red (#dc2626) */
        #sport_edit_modal .control-btns .btn-danger {
            background-color: #dc2626 !important;
            color: #ffffff !important;
        }
    }
</style>

<div class="container-fluid content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>SPORTS</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="row col-md-12 mb-3" style="padding: 0rem;">
        <div class="col-md-4 ml-auto text-right mt-3">
            @if (Gate::check('add sport'))
                <button class="btn-green-filled" style="outline: unset;" href="#"  data-toggle="modal" data-target="#sport_create_modal" title="Add New Sport">
                    <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD SPORT
                </button>
            @endif
        </div>
    </div>

    {{-- <div class="col-md-12 btn-top">
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3 btns-right-position">
                <div class="row">
                    <div class="col-md-6 btns-padding"></div>
                    <div class="col-md-6 btns-padding btn_set1">
                        @if (Gate::check('add sport'))
                            <button class="btns-text btns-style btns-card" style="outline: unset;" href="#"  data-toggle="modal" data-target="#sport_create_modal" title="Add New Sport">
                                Add Sport
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div> --}}


    <div class="col-md-12 mt-4">
        <div class="card">
                <div class="col-md-12 new-style-table">
                    <div class="table-responsive mt-3 mb-3">
                        <table class="table align-items-center" id="user_groups_table">
                            <thead>
                                <tr>
                                    <th class="user-group-name" scope="col">Sport Name</th>
                                    <th class="narration" scope="col">Created by</th>
                                </tr>
                            </thead>

                            <tbody class="list" id="tableBody">
                                @foreach ($sports as $sport)
                                    <tr class="edit-row">
                                        <td class="type sport-name"><a href="#" class="edit" data-value="{{ $sport->id}}">{{ $sport->sport_name }}</a></td>
                                        <td class="">{{ $sport->created_at->format('m-d-Y') }}</td>
                                        <input type="hidden" class="sport_image" id="sport_image" name="sport_image" value="{{ 'assets/'.$sport->sport_image }}"/>
                                        <input type="hidden" class="sport_image" value="{{ 'assets/'.$sport->sport_image }}"/>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>

                </div>
        </div>
    </div>

</div>
@include('pages.masters.sports.create')
@include('pages.masters.sports.edit')

<script>

$("body").on("click", ".edit", function(){
            var sportId = $(this).data('value');
            $('#sport_id').val(sportId);
            $('#sport_edit_modal').modal('show');
        });

// $(document).ready(function() {
//   // Click event handler for table rows
//   $('.edit-row').click(function() {
//     // Get the data values from the clicked row
//     var sportId = $(this).find('.edit').data('value');
//     var sportName = $(this).find('.sport-name').text();
//     var sportImg = $(this).find('.sport_image').val();

//     // Set the values in the edit modal
//     $('#sport_id').val(sportId);
//     $('#sport_edit_name').val(sportName);

//     // Display the image in the modal
//     $('#new_image_preview').attr('src', sportImg);
//     $('#new_image_preview').attr('alt', 'Sport Image');

//     // Show the edit modal
//     $('#sport_edit_modal').modal('show');
//   });
// });

</script>

@endsection
