@extends('layouts.app', ['activePage' => 'fabrics', 'titlePage' => __('Fabrics')])

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
    .colorpick{
        width: 50px !important;
        height: 38px !important;
        opacity: 1 !important;
    }
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice {
    background-color: #35526d;
    border: none;
    color: white;
    border-radius: 20px;
    padding: 0.3rem 0.75rem;
    font-size: 13px;
    margin-top: 0.3rem;
    margin-right: 0.3rem;
    font-weight: 500;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
}

.select2-container--bootstrap-5 .select2-selection--multiple {
    min-height: 42px;
    border-radius: 10px;
    padding: 0.4rem;
    border: 1px solid #ced4da;
}
.embellishment-pill {
    background-color: #35526d;
    color: #fff;
    border-radius: 999px;
    padding: 6px 12px;
    font-size: 13px;
    font-weight: 500;
    box-shadow: 0 2px 5px rgba(0,0,0,0.15);
    transition: all 0.3s ease-in-out;
}

/* MOBILE RESPONSIVE STYLES */
@media (max-width: 768px) {
    /* Layout adjustments */
    .content-position {
        top: 0 !important;
    }
    .alphabet {
        display: none !important;
    }
    .card {
        background-color: transparent !important;
        box-shadow: none !important;
    }
    
    /* Hide "Show N entries" on mobile */
    .dataTables_length {
        display: none !important;
    }
    /* Hide Table Layout button cell */
    .btn-inside-table td:nth-child(2) {
        display: none !important;
    }
    /* Add Fabric button cell */
    .btn-inside-table td:nth-child(3) {
        flex: 1 1 100% !important;
        width: 100% !important;
        padding: 0 !important;
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

    /* Top Action Buttons (Export / Table Layout / Add Fabric) */
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
        gap: 10px !important;
        align-items: center !important;
    }
    /* Hide the 25% empty spacer td */
    .btn-inside-table td:first-child {
        display: none !important;
    }
    /* Export button cell */
    .btn-inside-table td:nth-child(2) {
        flex: 1 1 50% !important;
        width: 50% !important;
        padding: 0 !important;
    }
    /* Add Fabric button cell */
    .btn-inside-table td:nth-child(3) {
        flex: 1 1 50% !important;
        width: 50% !important;
        padding: 0 !important;
    }
    /* Button styles */
    .btn-inside-table .styled-button {
        width: 100% !important;
        height: 44px !important;
        background-color: #ffffff !important;
        border: 1px solid #d1d5db !important;
        border-radius: 12px !important;
        color: #374151 !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        padding: 0 10px !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04) !important;
    }
    .btn-inside-table .btn-green-filled {
        width: 100% !important;
        height: 44px !important;
        background-color: #14b8a6 !important;
        border: 1px solid #14b8a6 !important;
        border-radius: 12px !important;
        color: #ffffff !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 4px !important;
        padding: 0 10px !important;
        box-shadow: 0 1px 2px rgba(20, 184, 166, 0.2) !important;
    }

    /* Sub-header text (Showing X / Sort Info) */
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
    #fabric_table thead {
        display: none !important;
    }

    /* Table & Tbody card structure */
    #fabric_table {
        display: block !important;
        width: 100% !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;
        border: none !important;
        background: transparent !important;
    }
    #fabric_table tbody {
        display: block !important;
        width: 100% !important;
    }

    /* Reset table cell and link padding for mobile cards */
    .new-style-table .table tbody td,
    .new-style-table .table tbody td a {
        padding: 0 !important;
    }

    /* Each table row becomes a card */
    #fabric_table tbody tr {
        display: flex !important;
        flex-wrap: wrap !important;
        align-items: center !important;
        position: relative !important;
        background: #ffffff !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 16px !important;
        padding: 14px 16px !important;
        margin-bottom: 12px !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
        box-sizing: border-box !important;
    }

    /* Fabric Name Header Cell */
    #fabric_table tbody tr td.fabric-name {
        display: flex !important;
        align-items: center !important;
        order: 1 !important;
        width: 100% !important;
        max-width: 100% !important;
        flex: 1 1 100% !important;
        padding: 0 !important;
        border: none !important;
        background: transparent !important;
        overflow: hidden !important;
        box-sizing: border-box !important;
    }

    /* Fabric Name Link styled as item header with icon preview */
    #fabric_table tbody tr td.fabric-name a {
        display: flex !important;
        align-items: center !important;
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        color: #1F2933 !important;
        text-decoration: none !important;
        cursor: pointer !important;
        position: relative !important;
        padding-right: 80px !important;
        margin: 5px !important;
        box-sizing: border-box !important;
        white-space: normal !important;
        word-break: break-word !important;
        overflow-wrap: anywhere !important;
    }

    /* Square Fabric Thumbnail placeholder before the name */
    /* #fabric_table tbody tr td.fabric-name a::before {
        content: "" !important;
        display: inline-block !important;
        width: 44px !important;
        height: 44px !important;
        min-width: 44px !important;
        flex-shrink: 0 !important;
        margin-right: 14px !important;
        border-radius: 10px !important;
        background: #9ca3af url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23ffffff' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'><path d='M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.47a1 1 0 00.99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 002-2V10h2.15a1 1 0 00.99-.84l.58-3.47a2 2 0 00-1.34-2.23z'/></svg>") center/20px no-repeat !important;
        box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.05) !important;
    } */

    /* Edit pill button after the name - anchored to the right */
    #fabric_table tbody tr td.fabric-name a::after {
        content: "Edit" !important;
        position: absolute !important;
        right: 0 !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        height: 28px !important;
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
    #fabric_table tbody tr td.created-at,
    #fabric_table tbody tr td.updated-at {
        display: block !important;
        position: relative !important;
        flex: 1 1 calc(50% - 6px) !important;
        width: calc(50% - 6px) !important;
        background: #F2F3F4 !important;
        border: 1px solid #F2F3F4 !important;
        border-radius: 12px !important;
        padding: 10px 10px 10px 42px !important;
        font-size: 12px !important;
        font-weight: 500 !important;
        color: #1F2933 !important;
        line-height: 1.35 !important;
        margin-top: 14px !important;
        box-sizing: border-box !important;
        white-space: normal !important;
        word-break: break-word !important;
    }

    #fabric_table tbody tr td.created-at {
        order: 2 !important;
        margin-right: 6px !important;
    }

    #fabric_table tbody tr td.updated-at {
        order: 3 !important;
        margin-left: 6px !important;
    }

    /* Labels inside detail boxes */
    #fabric_table tbody tr td.created-at::before {
        content: "Created\A" !important;
        white-space: pre !important;
        display: block !important;
        font-size: 11px !important;
        font-weight: 500 !important;
        color: #6b7280 !important;
        margin-bottom: 2px !important;
    }

    #fabric_table tbody tr td.updated-at::before {
        content: "Last Updated\A" !important;
        white-space: pre !important;
        display: block !important;
        font-size: 11px !important;
        font-weight: 500 !important;
        color: #6b7280 !important;
        margin-bottom: 2px !important;
    }

    /* Calendar icon inside Created badge */
    #fabric_table tbody tr td.created-at::after {
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
    #fabric_table tbody tr td.updated-at::after {
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
}
</style>

<div class="container-fluid mb-5 content-position">
    {{-- <div class="se-pre-con"></div> --}}

    @section('order-header')
        <span>FABRICS</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection
    <div class="row col-md-12" style="padding: 0rem;">
        <div class="col-md-4 ml-auto text-right">

        </div>
    </div>

    {{-- <div class="col-md-12 btn-top">
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3 btns-right-position btn_set">
                <div class="row div_align">
                    <div class="col-md-6 btns-padding">
                        @if (Gate::check('add fabrics'))
                            <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" data-toggle="modal" data-target="#fabric_create_modal" title="Add New Fabrics">
                                Add Fabric
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


    <div class="col-md-12">
        <div class="card">
            {{-- <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="float-left header-title">Fabrics</h1>
                        </div>
                        <div class="col-md-6 header-icons justify-content-end">
                            @if (Gate::check('add fabrics'))
                            <span>
                                <a class="btn btn-round" href="#" data-toggle="modal" data-target="#fabric_create_modal">
                                    <i class="fas fa-plus"></i>
                                </a>
                                <p>Add Fabrics</p>
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

                <div class="col-md-4 ml-auto mb-2 mt-3">
                    <table class="btn-inside-table" style="width: 100%">
                        <tr>
                            <td style="width:25%"></td>
                            <td>
                                <button class="styled-button" style="outline: unset;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                                    Table Layout
                                </button>
                            </td>
                            <td>
                                @if (Gate::check('add fabrics'))
                                    <button class="btn-green-filled" style="outline: unset;" href="#" data-toggle="modal" data-target="#fabric_create_modal" title="Add New Fabrics">
                                        <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD FABRIC
                                    </button>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-12 new-style-table">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="fabric_table">
                            <thead>
                                <th scope="col" class="fabric-name">Fabric Name</th>
                                <th scope="col" class="created-at">Created At</th>
                                <th scope="col" class="updated-at">Updated At</th>
                            </thead>

                            <tbody>
                                @foreach ($fabrics as $fabric)
                                    <tr>
                                        <td class="fabric-name"><a href="#" class="edit" data-value="{{$fabric->id}}">{{$fabric->fabric_name}}</a></td>
                                        <td class="created-at">{{$fabric->created_at->format('m-d-Y')}}</td>
                                        <td class="updated-at">{{$fabric->updated_at->format('m-d-Y')}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>

@include('pages.masters.fabrics.create')
@include('pages.masters.fabrics.edit')

{{-- Fabrics Fields & Layouts --}}
<div class="modal fade" id="layout_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Fabrics Fields &amp; Layouts</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">

                        <input type="hidden" id="layout_id" name="layout_id" value="{{$fabricLayout['id'] ?? ''}}" />
                        <input type="hidden" id="column_layout_id" name="column_layout_id" value="{{$columnLayout['id'] ?? 0}}" />

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="fabric_name" name="fabric_name" title="Fabric Name" @isset($fabricLayout) @if ($fabricLayout['fabric_name'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="fabric_name">Fabric Name</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="created_at" name="created_at" title="Created At" @isset($fabricLayout) @if ($fabricLayout['created'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="created_at">Created At</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="updated_at" name="updated_at" title="Updated At" @isset($fabricLayout) @if ($fabricLayout['updated'] == 1) checked @endif @endisset />
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

        var fabricTable = $('#fabric_table').DataTable({
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

        alphabet.insertBefore( fabricTable.table().container() );

        alphabet.on('click', 'span', function () {
            alphabet.find( '.active' ).removeClass( 'active' );
            $(this).addClass( 'active' );

            _alphabetSearch = $(this).data('letter');
            fabricTable.draw(_alphabetSearch);
        });

        // save column order when move
        fabricTable.on('column-reorder', function (e, settings, details) {
            var columnStr = localStorage.getItem("DataTables_fabric_table_/fabrics");
            var columnObj = JSON.parse(columnStr);
            var colReorder = new $.fn.dataTable.ColReorder( fabricTable );
            var curr = colReorder.fnOrder();
            var column_order = JSON.stringify(curr);
            var interface_name = 'Fabric';
            var interface_id = 4;
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
            var columnStr = localStorage.getItem("DataTables_fabric_table_/fabrics");
            var columnObj = JSON.parse(columnStr);
            var column_order = JSON.stringify(columnObj.ColReorder);
            var interface_name = 'Fabric';
            var interface_id = 4;
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
            // var interfaceId = 4;
            // $.ajax({
            //     url: '{{ url("datatable/get_column_order") }}/'+interfaceId,
            //     type: "GET",
            //     dataType: 'json',
            //     success: function(data) {
            //         console.log(data.column_order);
            //         var columnStr = localStorage.getItem("DataTables_fabric_table_/fabrics");
            //         var columnObj = JSON.parse(columnStr);
            //         columnObj.ColReorder = JSON.parse(data.column_order);

            //         localStorage.setItem('DataTables_fabric_table_/fabrics', JSON.stringify(columnObj));
            //     },
            //     complete: function() {
            //         $(".se-pre-con").fadeOut('slow');
            //     }
            // });

            var interfaceId = 4;
            $.ajax({
                url: '{{ url("datatable/get_column_order") }}/' + interfaceId,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    console.log(data.column_order);

                    var columnStr = localStorage.getItem("DataTables_fabric_table_/fabrics");
                    var columnObj = columnStr ? JSON.parse(columnStr) : {};  // Initialize to an empty object if null

                    // Make sure column_order from the response is a valid JSON or array-like string
                    try {
                        columnObj.ColReorder = JSON.parse(data.column_order);  // Assuming data.column_order is a JSON string
                    } catch (e) {
                        console.error('Error parsing column_order:', e);
                    }

                    localStorage.setItem('DataTables_fabric_table_/fabrics', JSON.stringify(columnObj));
                },
                complete: function() {
                    $(".se-pre-con").fadeOut('slow');
                }
            });

        }


        $('#fabric_name').on('change', function(){ tableLayout(); });
        $('#created_at').on('change', function(){ tableLayout(); });
        $('#updated_at').on('change', function(){ tableLayout(); });
    });

    // Fabrics Edit
    $(document).on("click", ".edit", function () {
        var fabricId = $(this).data('value');
        console.log(fabricId);
        $('#fabric_id').val(fabricId);
        $('#fabric_edit_modal').modal('show');
    });

    function tableLayout(){
        var layout_id = $('#layout_id').val();
        var fabric_name = $('#fabric_name').val();
        var created_at = $('#created_at').val();
        var updated_at = $('#updated_at').val();

        if($('#fabric_name').is(':checked')) {
            $('.fabric-name').css('display', 'table-cell');
            fabric_name = 1;
        } else {
            $('.fabric-name').css('display', 'none');
            fabric_name = 0;
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
            url: "fabrics/layout",
            type: "POST",
            data: {
                'layout_id':layout_id, 'fabric_name':fabric_name, 'created_at':created_at, 'updated_at':updated_at,
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
        $('#fabric_table thead th').each(function(){
            if($(this).text() == 'Fabric Name') {
                searchIdx = $('#fabric_table thead th').index(this);
                console.log(searchIdx);
            }
        });
    }

    $('#layout_modal').on('hidden.bs.modal', function () {
        $(".se-pre-con").fadeIn('slow');
        window.location.reload(true);
    });
</script>
@if (!Gate::check('edit fabrics'))
    <script>
        disableFormElements();
        function disableFormElements() {
            $('#fabric_edit_form')
                .find('input, select, textarea')
                .prop('disabled', true);
        }
    </script>
@endif
@if (Gate::check('edit fabric description'))
    <script>
        $('input[name="_token"]').prop('disabled', false);
        $('#fabric_id').prop('disabled', false);
        $('#edit_description').prop('disabled', false);
    </script>
@endif
@endsection
