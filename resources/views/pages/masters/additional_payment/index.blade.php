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
  @media only screen and (min-device-width: 1024px) and (max-device-height: 1366px) and (-webkit-min-device-pixel-ratio: 2)  and (orientation: portrait) {
        .header1{
            display: inline !important;
        }

    }
    @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {
        .header1{
            display: inline !important;
        }
        .headder_size{
            font-size:15px;
        }
    }
    @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) and (orientation : landscape) {

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
        }

        /* Page wrapper */
        .content-position {
            position: relative !important;
            top: 0 !important;
            padding: 12px 16px 30px 16px !important;
        }

        /* Search input bar on mobile (if any header search exists) */
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

        /* ADD ADDITIONAL PAYMENT TYPE button row — full width on mobile */
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

        /* ── Search bar (DataTables filter) ── */
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

        /* ── +Add Additional Payment Type button ── */
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
            margin: 0 0 14px 0 !important;
            order: 2 !important;
        }

        .btn-green-filled:hover,
        .btn-green-filled:active {
            background-color: #0d9488 !important;
            color: #ffffff !important;
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

        #user_groups_table {
            display: block !important;
            width: 100% !important;
            border: none !important;
            background: transparent !important;
        }

        /* Hide table header on mobile */
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

        /* tbody: flex column of cards */
        #user_groups_table tbody {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            width: 100% !important;
        }

        /* Each row = white card */
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

        /* Additional Payment Name cell */
        #user_groups_table tbody tr td.used-model {
            order: 1 !important;
            flex: 1 1 auto !important;
            min-width: 0 !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
        }

        #user_groups_table tbody tr td.used-model a.edit {
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

        /* "Created AT  YYYY-MM-DD" label under the name */
        #user_groups_table tbody tr td.created-at {
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

        /* Insert "Created AT  " label before the date text */
        #user_groups_table tbody tr td.created-at::before {
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
            background-color: #14B8A6 !important;
            border-color: #14B8A6 !important;
            color: #ffffff !important;
            font-weight: 700 !important;
        }

        #create_addition_modal .modal-dialog,
        #edit_addition_modal .modal-dialog {
            margin: 16px auto !important;
            max-width: calc(100% - 32px) !important;
        }

        #create_addition_modal .modal-content,
        #edit_addition_modal .modal-content {
            border-radius: 24px !important;
            border: 1px solid #f1f5f9 !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
            background: #ffffff !important;
            overflow: hidden !important;
        }

        #create_addition_modal .modal-header,
        #edit_addition_modal .modal-header {
            padding: 22px 24px 18px 24px !important;
            border-bottom: 1px solid #eef2f6 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            background: #ffffff !important;
        }

        #create_addition_modal .modal-title,
        #edit_addition_modal .modal-title {
            font-size: 20px !important;
            font-weight: 800 !important;
            color: #111827 !important;
            margin: 0 !important;
            letter-spacing: -0.3px !important;
        }

        #create_addition_modal .modal-header button.close,
        #edit_addition_modal .modal-header button.close {
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

        #create_addition_modal .modal-body,
        #edit_addition_modal .modal-body {
            padding: 20px 24px 10px 24px !important;
            background: #ffffff !important;
        }

        /* Additional Payment Type Name label */
        #create_addition_modal .modal-body .form-lable,
        #edit_addition_modal .modal-body .form-lable,
        #create_addition_modal .modal-body label,
        #edit_addition_modal .modal-body label {
            display: block !important;
            width: 100% !important;
            max-width: 100% !important;
            position: static !important;
            top: auto !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            margin-bottom: 8px !important;
        }

        /* Form field container — block layout so label is above input */
        #create_addition_modal .modal-body .col-md-12,
        #edit_addition_modal .modal-body .col-md-12 {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            margin-top: 0 !important;
            display: block !important;
            float: none !important;
        }

        /* form-field wrapper must stack label on top of input */
        #create_addition_modal .modal-body .form-field,
        #edit_addition_modal .modal-body .form-field {
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
        }

        #edit_additional_payment_name,
        #additional_payment_name {
            min-width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }

        /* Input — full width, BELOW label */
        #create_addition_modal input.form-control,
        #edit_addition_modal input.form-control,
        #additional_payment_name,
        #edit_additional_payment_name {
            width: 100% !important;
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
            float: none !important;
        }

        #additional_payment_name::placeholder {
            color: #94a3b8 !important;
            font-size: 15px !important;
        }

        /* Modal footer */
        #create_addition_modal .modal-footer,
        #edit_addition_modal .modal-footer {
            padding: 16px 24px 24px 24px !important;
            border-top: none !important;
            background: #ffffff !important;
        }

        /* Button row */
        #create_addition_modal .control-btns,
        #edit_addition_modal .control-btns {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 10px !important;
            width: 100% !important;
            padding: 0 !important;
        }

        #create_addition_modal .control-btns .btn,
        #edit_addition_modal .control-btns .btn {
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
        #create_addition_modal .control-btns .btn-secondary,
        #edit_addition_modal .control-btns .btn-secondary {
            background-color: #94a3b8 !important;
            color: #ffffff !important;
        }

        /* Save / Update button — green */
        #create_addition_modal .control-btns .btn-success,
        #edit_addition_modal .control-btns .btn-success {
            background-color: #16a34a !important;
            color: #ffffff !important;
        }

        /* Delete button — red */
        #edit_addition_modal .control-btns .btn-danger {
            background-color: #dc2626 !important;
            color: #ffffff !important;
        }

        /* mt-4 override so table card doesn't have extra gap */
        .col-md-12.mt-4 {
            margin-top: 0 !important;
        }
    }
</style>

<div class="container-fluid content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span class="headder_size">ADDITIONAL PAYMENTS TYPES</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="row col-md-12 mb-3" style="padding: 0rem;">
        <div class="col-md-4 ml-auto text-right mt-3">
            @if (Gate::check('add additional payment'))
                <button class="btn-green-filled" style="outline: unset;" href="#"  data-toggle="modal" data-target="#create_addition_modal" title="Add New Additional Payment Type">
                    <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD ADDITIONAL PAYMENT
                </button>
            @endif
        </div>
    </div>

    {{-- <div class="col-md-12 btn-top">
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3 btns-right-position">
                <div class="row div_align">
                    <div class="col-md-6 btns-padding"></div>
                    <div class="col-md-6 btns-padding btn_set">
                        @if (Gate::check('add additional payment'))
                            <button class="btns-text btns-style btns-card" style="outline: unset;" href="#"  data-toggle="modal" data-target="#create_addition_modal" title="Add New Additional Payment Type">
                                Add Additional Payment
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
                                    <th class="narration" scope="col">Additional Payment Name</th>
                                    <th class="created-at" scope="col">Created At</th>
                                </tr>
                            </thead>

                            <tbody class="list" id="tableBody">
                                @foreach ($additionals as $additional)
                                    <tr  class="edit-row">
                                        <td class="used-model"><a href="#" class="edit" data-value="{{ $additional->id}}">{{ $additional->addition_type_name }}</a></td>
                                        <td class="created-at">{{$additional->created_at->format('m-d-Y')}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>

        </div>
    </div>

</div>
@include('pages.masters.additional_payment.create')
@include('pages.masters.additional_payment.edit')

<script>

$(document).ready(function() {
    // Click event handler for table rows
    $('.edit-row').click(function() {
        // Get the data values from the clicked row
        var typeId = $(this).find('.edit').data('value');
        var typeName = $(this).find('.used-model').text();
console.log(typeId);
        // Set the values in the edit modal
        $('#type_id').val(typeId);
        $('#edit_additional_payment_name').val(typeName);

        // Show the edit modal
        $('#edit_addition_modal').modal('show');
    });
});

</script>

<!-- search bar -->
<script>
$(document).ready(function () {
    $('#user_groups_table').DataTable({
        order: [],
        pageLength: 10,
        language: {
            search: '',
            searchPlaceholder: 'Search Additional Payments...'
        }
    });
});

$("body").on("click", ".edit", function(){
    var sizeTypeId = $(this).data('value');
    $('#sizeType_id').val(sizeTypeId);
    $('#sizeType_edit_modal').modal('show');
});
</script>
@endsection

