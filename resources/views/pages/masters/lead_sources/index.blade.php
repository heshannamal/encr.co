@extends('layouts.app', ['activePage' => 'lead_sources', 'titlePage' => __('Lead Sources')])

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

    /* MOBILE RESPONSIVE STYLES */
    @media (max-width: 768px) {
        /* Layout adjustments */
        .content-position {
            top: 0 !important;
        }
        .card {
            background-color: transparent !important;
            box-shadow: none !important;
        }
        .card > .col-md-12,
        .card .new-style-table,
        .card .table-responsive,
        .new-style-table,
        .table-responsive {
            padding-left: 0 !important;
            padding-right: 0 !important;
            overflow: visible !important;
        }
        .dataTables_wrapper {
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .dataTables_wrapper .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        .dataTables_wrapper .row > [class*="col-"] {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /* Hide "Show N entries" on mobile */
        .dataTables_length {
            display: none !important;
        }
        
        /* Search input (DataTables) */
        .dataTables_filter {
            width: 100% !important;
            float: none !important;
            text-align: left !important;
            margin-bottom: 12px !important;
            padding: 0 !important;
        }
        .dataTables_filter label {
            width: 100% !important;
            position: relative !important;
            margin: 0 !important;
            display: block !important;
        }
        .dataTables_filter label .fas.fa-search {
            position: absolute !important;
            left: 14px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            color: #9ca3af !important;
            font-size: 14px !important;
            pointer-events: none !important;
            z-index: 2 !important;
        }
        .dataTables_filter input[type="search"],
        .dataTables_filter .form-control {
            display: block !important;
            width: 100% !important;
            max-width: 100% !important;
            height: 44px !important;
            padding: 8px 14px 8px 38px !important;
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 12px !important;
            font-size: 14px !important;
            color: #374151 !important;
            box-sizing: border-box !important;
            margin: 0 !important;
            outline: none !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03) !important;
        }
        .dataTables_filter input[type="search"]::placeholder,
        .dataTables_filter .form-control::placeholder {
            color: #9ca3af !important;
        }

        /* Top Action Buttons (Add Lead Source) */
        .col-md-4.ml-auto.mb-2.mt-3 {
            width: 100% !important;
            margin: 0 0 12px 0 !important;
            padding: 0 !important;
        }
        .btn-inside-table {
            width: 100% !important;
            display: block !important;
        }
        .btn-inside-table tbody,
        .btn-inside-table tr {
            display: flex !important;
            width: 100% !important;
            align-items: center !important;
        }
        /* Hide the 50% empty spacer td */
        .btn-inside-table td:first-child {
            display: none !important;
        }
        .btn-inside-table td:last-child {
            flex: 1 1 100% !important;
            width: 100% !important;
            padding: 0 !important;
        }
        /* Add Lead Source button */
        .btn-inside-table .btn-green-filled {
            width: 100% !important;
            height: 44px !important;
            background-color: #14B8A6 !important;
            border: 1px solid #14B8A6 !important;
            border-radius: 12px !important;
            color: #ffffff !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            padding: 0 14px !important;
            box-shadow: 0 1px 2px rgba(20, 184, 166, 0.2) !important;
        }

        /* DataTables info text */
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

        /* Hide table header */
        #lead_source_table thead {
            display: none !important;
        }

        /* Table & Tbody card structure */
        #lead_source_table {
            display: block !important;
            width: 100% !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            border: none !important;
            background: transparent !important;
        }
        #lead_source_table tbody {
            display: block !important;
            width: 100% !important;
        }

        /* Reset table cell and link padding for mobile cards */
        .new-style-table .table tbody td,
        .new-style-table .table tbody td a {
            padding: 0 !important;
        }

        /* Each table row becomes a card */
        #lead_source_table tbody tr {
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            position: relative !important;
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 16px !important;
            padding: 16px !important;
            margin-bottom: 14px !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
            box-sizing: border-box !important;
        }

        /* Lead Source Name Cell */
        #lead_source_table tbody tr td.lead_source-name {
            display: flex !important;
            align-items: center !important;
            order: 1 !important;
            width: 100% !important;
            max-width: 100% !important;
            flex: 1 1 100% !important;
            padding: 0 !important;
            border: none !important;
            background: transparent !important;
            box-sizing: border-box !important;
        }

        /* Lead Source Link with name and Edit button */
        #lead_source_table tbody tr td.lead_source-name a {
            display: flex !important;
            align-items: center !important;
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            font-size: 15px !important;
            font-weight: 600 !important;
            color: #1f2937 !important;
            text-decoration: none !important;
            cursor: pointer !important;
            position: relative !important;
            padding-right: 75px !important;
            box-sizing: border-box !important;
            white-space: normal !important;
            word-break: break-word !important;
            overflow-wrap: anywhere !important;
        }

        /* Edit pill button aligned to the right */
        #lead_source_table tbody tr td.lead_source-name a::after {
            content: "Edit" !important;
            position: absolute !important;
            right: 0 !important;
            top: 50% !important;
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
            line-height: 1 !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03) !important;
            white-space: nowrap !important;
            flex-shrink: 0 !important;
        }

        /* Created At & Updated At Detail Badges / Cards */
        #lead_source_table tbody tr td.created-at,
        #lead_source_table tbody tr td.updated-at {
            display: block !important;
            position: relative !important;
            flex: 1 1 calc(50% - 6px) !important;
            width: calc(50% - 6px) !important;
            background: #F2F3F4 !important;
            border: 1px solid #F2F3F4 !important;
            border-radius: 12px !important;
            padding: 10px 10px 10px 42px !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            color: #374151 !important;
            line-height: 1.35 !important;
            margin-top: 14px !important;
            box-sizing: border-box !important;
            white-space: normal !important;
            word-break: break-word !important;
        }

        #lead_source_table tbody tr td.created-at {
            order: 2 !important;
            margin-right: 6px !important;
        }

        #lead_source_table tbody tr td.updated-at {
            order: 3 !important;
            margin-left: 6px !important;
        }

        /* Labels inside detail boxes */
        #lead_source_table tbody tr td.created-at::before {
            content: "Created\A" !important;
            white-space: pre !important;
            display: block !important;
            font-size: 11px !important;
            font-weight: 400 !important;
            color: #6B7280 !important;
            margin-bottom: 2px !important;
        }

        #lead_source_table tbody tr td.updated-at::before {
            content: "Last Updated\A" !important;
            white-space: pre !important;
            display: block !important;
            font-size: 11px !important;
            font-weight: 400 !important;
            color: #6B7280 !important;
            margin-bottom: 2px !important;
        }

        /* Calendar icon inside Created badge */
        #lead_source_table tbody tr td.created-at::after {
            content: "" !important;
            position: absolute !important;
            left: 10px !important;
            top: 12px !important;
            width: 24px !important;
            height: 24px !important;
            background-color: #ffffff !important;
            border-radius: 8px !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
            background-size: 13px 13px !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08) !important;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23374151' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><rect x='3' y='4' width='18' height='18' rx='2' ry='2'></rect><line x1='16' y1='2' x2='16' y2='6'></line><line x1='8' y1='2' x2='8' y2='6'></line><line x1='3' y1='10' x2='21' y2='10'></line></svg>") !important;
        }

        /* Clock icon inside Last Updated badge */
        #lead_source_table tbody tr td.updated-at::after {
            content: "" !important;
            position: absolute !important;
            left: 10px !important;
            top: 12px !important;
            width: 24px !important;
            height: 24px !important;
            background-color: #ffffff !important;
            border-radius: 8px !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
            background-size: 13px 13px !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08) !important;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23374151' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><circle cx='12' cy='12' r='10'></circle><polyline points='12 6 12 12 16 14'></polyline></svg>") !important;
        }

        /* DataTables Pagination in mobile view */
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
            background-color: #14B8A6 !important;
            border-color: #14B8A6 !important;
            color: #ffffff !important;
            font-weight: 700 !important;
        }

        /* MODALS (Add New Lead Source & Edit Lead Source) MOBILE STYLES */
        #lead_source_create_modal .modal-dialog,
        #lead_source_edit_modal .modal-dialog {
            margin: 1.5rem auto !important;
            max-width: 92% !important;
            width: 92% !important;
        }

        #lead_source_create_modal .modal-content,
        #lead_source_edit_modal .modal-content {
            border-radius: 20px !important;
            border: none !important;
            box-shadow: 0 12px 36px rgba(0, 0, 0, 0.12) !important;
            padding: 10px 14px 18px !important;
            background: #ffffff !important;
        }

        #lead_source_create_modal .modal-header,
        #lead_source_edit_modal .modal-header {
            border-bottom: 1px solid #f1f3f5 !important;
            padding: 14px 10px 12px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
        }

        #lead_source_create_modal .modal-title,
        #lead_source_edit_modal .modal-title {
            font-size: 20px !important;
            font-weight: 700 !important;
            color: #111827 !important;
            margin: 0 !important;
            line-height: 1.2 !important;
        }

        #lead_source_create_modal .modal-header .close,
        #lead_source_edit_modal .modal-header .close {
            font-size: 22px !important;
            font-weight: 400 !important;
            color: #9ca3af !important;
            opacity: 1 !important;
            padding: 0 !important;
            margin: 0 !important;
            line-height: 1 !important;
            outline: none !important;
        }

        #lead_source_create_modal .modal-body,
        #lead_source_edit_modal .modal-body {
            padding: 16px 10px 10px !important;
        }

        #lead_source_create_modal .form-field,
        #lead_source_edit_modal .form-field {
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-start !important;
            margin-bottom: 1rem !important;
            padding: 0 !important;
        }

        #lead_source_create_modal .form-lable,
        #lead_source_edit_modal .form-lable {
            width: 100% !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #111827 !important;
            margin-bottom: 8px !important;
        }

        #lead_source_create_modal .form-lable .text-danger,
        #lead_source_edit_modal .form-lable .text-danger {
            color: #ef4444 !important;
            margin-left: 2px !important;
        }

        #lead_source_create_modal .form-input,
        #lead_source_edit_modal .form-input {
            width: 100% !important;
            height: 48px !important;
            border-radius: 12px !important;
            border: 1px solid #e5e7eb !important;
            padding: 10px 14px !important;
            font-size: 15px !important;
            font-weight: 500 !important;
            color: #111827 !important;
            background-color: #ffffff !important;
            box-shadow: none !important;
            outline: none !important;
            box-sizing: border-box !important;
        }

        #lead_source_create_modal .form-input::placeholder,
        #lead_source_edit_modal .form-input::placeholder {
            color: #9ca3af !important;
            font-weight: 400 !important;
        }

        #lead_source_create_modal .form-input:focus,
        #lead_source_edit_modal .form-input:focus {
            border-color: #10b981 !important;
        }

        #lead_source_create_modal .modal-footer,
        #lead_source_edit_modal .modal-footer {
            border-top: none !important;
            padding: 10px 10px 6px !important;
        }

        #lead_source_create_modal .control-btns,
        #lead_source_edit_modal .control-btns {
            display: flex !important;
            flex-direction: row !important;
            gap: 12px !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        #lead_source_create_modal .control-btns .btn-custom,
        #lead_source_edit_modal .control-btns .btn-custom {
            flex: 1 1 0 !important;
            height: 48px !important;
            border-radius: 12px !important;
            font-size: 15px !important;
            font-weight: 600 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: 0 !important;
            border: none !important;
            box-shadow: none !important;
            cursor: pointer !important;
        }

        /* Cancel button: soft neutral/slate-gray #94a3b8 */
        #lead_source_create_modal .control-btns .btn-secondary,
        #lead_source_edit_modal .control-btns .btn-secondary {
            background-color: #94a3b8 !important;
            color: #ffffff !important;
        }

        /* Save / Update button: green #10b981 */
        #lead_source_create_modal .control-btns .btn-success,
        #lead_source_edit_modal .control-btns .btn-success {
            background-color: #10b981 !important;
            color: #ffffff !important;
        }

        /* Delete button (Edit modal): red #dc2626 */
        #lead_source_edit_modal .control-btns .btn-danger,
        #lead_source_edit_modal .control-btns .delete {
            background-color: #dc2626 !important;
            color: #ffffff !important;
            order: 1 !important;
        }

        #lead_source_edit_modal .control-btns .btn-secondary {
            order: 2 !important;
        }

        #lead_source_edit_modal .control-btns .btn-success {
            order: 3 !important;
        }
    }
</style>

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>LEAD SOURCES</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection
    <div class="row col-md-12" style="padding: 0rem;">
        <div class="col-md-4 ml-auto text-right">

        </div>
    </div>


    <div class="col-md-12">
        <div class="card">

                <div class="col-md-4 ml-auto mb-2 mt-3">
                    <table class="btn-inside-table" style="width: 100%">
                        <tr>
                            <td style="width:50%"></td>
                            <td>
                                <button class="btn-green-filled" style="outline: unset;" href="#" data-toggle="modal" data-target="#lead_source_create_modal" title="Add New Lead Sources">
                                    <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD LEAD SOURCE
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-12 new-style-table">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="lead_source_table">
                            <thead>
                                <th scope="col" class="lead_source-name">Lead Source Name</th>
                                <th scope="col" class="created-at">Created At</th>
                                <th scope="col" class="updated-at">Updated At</th>
                            </thead>

                            <tbody>
                                @foreach ($lead_sources as $lead_source)
                                    <tr>
                                        <td class="lead_source-name"><a href="#" class="edit" data-value="{{$lead_source->id}}">{{$lead_source->lead_source_name}}</a></td>
                                        <td class="created-at">{{$lead_source->created_at->format('m-d-Y')}}</td>
                                        <td class="updated-at">{{$lead_source->updated_at->format('m-d-Y')}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>

@include('pages.masters.lead_sources.create')
@include('pages.masters.lead_sources.edit')

<script>

    $(document).ready( function () {

        var lead_sourceTable = $('#lead_source_table').DataTable({
            colReorder: true,
            stateSave: true,
            "autoWidth": false,
            "pageLength": 50,
            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'Search Lead Source'
            }
        });
    });

        // lead_sources Edit
        $("body").on("click", ".edit", function(){
            var lead_sourceId = $(this).data('value');
            $('#lead_source_id').val(lead_sourceId);
            $('#lead_source_edit_modal').modal('show');
        });
</script>
@endsection
