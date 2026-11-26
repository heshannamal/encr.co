@extends('layouts.app', ['activePage' => 'attribute_groups', 'titlePage' => __('Attribute Groups')])

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
        width: 93px;
        position: relative;
        right: -25px;
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
   .search_orga{
    width:200% !important;
   }
   .pagina001{
        flex-wrap: wrap;
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

    /* MOBILE RESPONSIVE STYLES (Max Width: 768px) */
    @media (max-width: 768px) {
        body {
            background-color: #f8fafc !important;
        }

        .content-position {
            position: relative !important;
            top: 0 !important;
            padding: 12px 16px 30px 16px !important;
        }

        /* Hide desktop action bar row and alphabet search */
        .content-position > .row.col-md-12:first-of-type,
        div.alphabet {
            display: none !important;
        }

        .card {
            background-color: transparent !important;
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
        }

        .col-md-12 {
            padding: 0 !important;
        }

        /* ── Action Buttons Container (+Add Attribute Groups) ── */
        .col-md-4.ml-auto.mb-2.mt-3 {
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
            display: none !important; /* Hide empty td and Table Layout button on mobile */
        }

        .btn-inside-table tr td:last-child {
            width: 100% !important;
            padding: 0 !important;
        }

        /* +Add Attribute Groups Button */
        .btn-green-filled,
        .btn-inside-table button.btn-green-filled {
            width: 100% !important;
            height: 44px !important;
            background-color: #14b8a6 !important; /* Emerald / Teal */
            border: none !important;
            border-radius: 12px !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: 0 2px 8px rgba(20, 184, 166, 0.28) !important;
            cursor: pointer !important;
            text-transform: none !important;
        }

        .btn-green-filled:hover,
        .btn-green-filled:active,
        .btn-inside-table button.btn-green-filled:hover,
        .btn-inside-table button.btn-green-filled:active {
            background-color: #0d9488 !important;
            color: #ffffff !important;
        }

        /* ── DataTables Top Controls (Search Bar & Length) ── */
        .dataTables_wrapper {
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .dataTables_wrapper .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            width: 100% !important;
        }

        .dataTables_wrapper .row > [class*="col-"] {
            padding-left: 0 !important;
            padding-right: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }

        /* Hide default page length on mobile */
        .dataTables_length {
            display: none !important;
        }

        /* Search input styled */
        .dataTables_filter {
            order: -1 !important;
            width: 100% !important;
            margin: 0 0 14px 0 !important;
            padding: 0 !important;
            text-align: left !important;
            float: none !important;
        }

        .dataTables_filter label {
            width: 100% !important;
            position: relative !important;
            margin: 0 !important;
            padding: 0 !important;
            display: block !important;
            color: transparent !important; /* Hide text label */
            font-size: 0 !important;
            text-align: left !important;
        }

        .dataTables_filter label i {
            display: none !important;
        }

        .dataTables_filter input[type="search"],
        .dataTables_filter input.form-control {
            display: block !important;
            width: 100% !important;
            height: 48px !important;
            border-radius: 12px !important;
            border: 1px solid #e2e8f0 !important;
            background-color: #ffffff !important;
            padding: 0 16px 0 46px !important;
            font-size: 15px !important;
            color: #334155 !important;
            box-sizing: border-box !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02) !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'%3E%3C/circle%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'%3E%3C/line%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: 16px center !important;
            margin: 0 !important;
        }

        .dataTables_filter input::placeholder {
            color: #94a3b8 !important;
            font-size: 14px !important;
        }

        /* ── Showing info & Sort row ("Showing 4 | Sort: Product Style Name") ── */
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

        /* .dataTables_info::after {
            content: "Sort: Product Style Name" !important;
            font-size: 13px !important;
            color: #64748b !important;
            font-weight: 500 !important;
        } */

        /* ── Table Transformed to Cards ── */
        .col-md-12.new-style-table {
            padding: 0 !important;
        }

        .table-responsive {
            overflow: visible !important;
            border: none !important;
            margin: 0 !important;
        }

        #attribute_group_table {
            display: block !important;
            width: 100% !important;
            border: none !important;
            background: transparent !important;
        }

        #attribute_group_table thead {
            display: none !important;
        }

        #attribute_group_table tbody {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            width: 100% !important;
            border: none !important;
        }

        .new-style-table table tr {
            border-bottom: none !important;
            border-top: none !important;
            background-color: transparent !important;
        }

        .new-style-table table tbody tr:hover {
            background-color: transparent !important;
        }

        /* Individual Attribute Group Card */
        #attribute_group_table tbody tr {
            display: flex !important;
            flex-wrap: wrap !important;
            background: #ffffff !important;
            border-radius: 18px !important;
            padding: 16px 16px !important;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03) !important;
            border: 1px solid #e2e8f0 !important;
            position: relative !important;
            box-sizing: border-box !important;
            cursor: pointer !important;
            width: 100% !important;
            min-height: 0 !important;
            transition: all 0.2s ease !important;
        }

        #attribute_group_table tbody tr td {
            border: none !important;
            padding: 0 !important;
            background: transparent !important;
            min-height: 0 !important;
        }

        .new-style-table .table tbody td,
        .new-style-table .table tbody td a {
            padding: 0 !important;
            font-size: inherit !important;
        }

        /* Chevron indicator on the top-right */
        #attribute_group_table tbody tr::after {
            content: "\f077" !important; /* chevron-up (expanded) */
            font-family: 'Font Awesome 5 Free', 'FontAwesome' !important;
            font-weight: 900 !important;
            position: absolute !important;
            right: 18px !important;
            top: 22px !important;
            font-size: 13px !important;
            color: #1e293b !important;
            pointer-events: none !important;
        }

        /* Down chevron when collapsed */
        #attribute_group_table tbody tr.is-collapsed::after {
            content: "\f078" !important; /* chevron-down (collapsed) */
        }

        /* ── 1. Attribute Group Name (td.attribute-group-name) ── */
        #attribute_group_table tbody tr td.attribute-group-name {
            order: 1 !important;
            flex: 1 1 calc(100% - 32px) !important;
            /* max-width: calc(100% - 32px) !important; */
            min-width: 0 !important;
            display: flex !important;
            align-items: center !important;
            min-height: 36px !important;
            position: relative !important;
        }

        #attribute_group_table tbody tr td.attribute-group-name a.edit_attribute_group {
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

        /* Clickable Edit Pill Button positioned on top right */
        #attribute_group_table tbody tr td.attribute-group-name a.edit_attribute_group::after {
            content: "Edit" !important;
            position: absolute !important;
            top: 2px !important;
            right: 40px !important;
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

        /* ── 2. Created At Box (td.created-at) ── */
        #attribute_group_table tbody tr td.created-at {
            order: 2 !important;
            display: flex !important;
            flex-direction: column !important;
            width: calc(50% - 6px) !important;
            margin-top: 14px !important;
            margin-right: 6px !important;
            padding: 12px 14px 12px 48px !important;
            background: #F2F3F4 url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%231e293b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><rect x='3' y='4' width='18' height='18' rx='2' ry='2'></rect><line x1='16' y1='2' x2='16' y2='6'></line><line x1='8' y1='2' x2='8' y2='6'></line><line x1='3' y1='10' x2='21' y2='10'></line></svg>") 14px 14px no-repeat !important;
            border-radius: 14px !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            color: #1F2933 !important;
            box-sizing: border-box !important;
            line-height: 1.4 !important;
        }

        #attribute_group_table tbody tr td.created-at::before {
            content: "Created" !important;
            display: block !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            color: #6B7280 !important;
            margin-bottom: 2px !important;
        }

        /* ── 3. Last Updated Box (td.updated-at) ── */
        #attribute_group_table tbody tr td.updated-at {
            order: 3 !important;
            display: flex !important;
            flex-direction: column !important;
            width: calc(50% - 6px) !important;
            margin-top: 14px !important;
            margin-left: 6px !important;
            padding: 12px 14px 12px 48px !important;
            background: #F2F3F4 url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%231e293b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><circle cx='12' cy='12' r='10'></circle><polyline points='12 6 12 12 16 14'></polyline></svg>") 14px 14px no-repeat !important;
            border-radius: 14px !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            color: #1F2933 !important;
            box-sizing: border-box !important;
            line-height: 1.4 !important;
        }

        #attribute_group_table tbody tr td.updated-at::before {
            content: "Last Updated" !important;
            display: block !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            color: #6B7280 !important;
            margin-bottom: 2px !important;
        }

        /* ── 4. Attributes List Box (td.attribute-name) ── */
        #attribute_group_table tbody tr td.attribute-name {
            order: 4 !important;
            display: flex !important;
            flex-direction: column !important;
            width: calc(50% - 6px) !important;
            margin-top: 10px !important;
            margin-right: 6px !important;
            padding: 12px 14px !important;
            background: #F2F3F4 !important;
            border-radius: 14px !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            color: #1F2933 !important;
            box-sizing: border-box !important;
            line-height: 1.4 !important;
            min-height: 54px !important;
        }

        #attribute_group_table tbody tr td.attribute-name::before {
            content: "Attributes" !important;
            display: block !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            color: #6B7280 !important;
            margin-bottom: 4px !important;
        }

        #attribute_group_table tbody tr td.attribute-name ul {
            list-style: none !important;
            padding-left: 0 !important;
            margin-bottom: 0 !important;
        }

        #attribute_group_table tbody tr td.attribute-name ul li {
            position: relative !important;
            padding-left: 12px !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            color: #1F2933 !important;
            line-height: 1.4 !important;
        }

        #attribute_group_table tbody tr td.attribute-name ul li::before {
            content: "-" !important;
            position: absolute !important;
            left: 0 !important;
            color: #1F2933 !important;
        }

        /* ── 5. Product Style List Box (td.product-style) ── */
        #attribute_group_table tbody tr td.product-style {
            order: 5 !important;
            display: flex !important;
            flex-direction: column !important;
            width: calc(50% - 6px) !important;
            margin-top: 10px !important;
            margin-left: 6px !important;
            padding: 12px 14px !important;
            background: #F2F3F4 !important;
            border-radius: 14px !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            color: #1F2933 !important;
            box-sizing: border-box !important;
            line-height: 1.4 !important;
            min-height: 54px !important;
        }

        #attribute_group_table tbody tr td.product-style::before {
            content: "Product Style" !important;
            display: block !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            color: #6B7280 !important;
            margin-bottom: 4px !important;
        }

        #attribute_group_table tbody tr td.product-style ul {
            list-style: none !important;
            padding-left: 0 !important;
            margin-bottom: 0 !important;
        }

        #attribute_group_table tbody tr td.product-style ul li {
            font-size: 12px !important;
            font-weight: 600 !important;
            color: #1F2933 !important;
            line-height: 1.4 !important;
        }

        /* ── COLLAPSIBLE STATE (is-collapsed) ── */
        #attribute_group_table tbody tr.is-collapsed td.created-at,
        #attribute_group_table tbody tr.is-collapsed td.updated-at,
        #attribute_group_table tbody tr.is-collapsed td.attribute-name,
        #attribute_group_table tbody tr.is-collapsed td.product-style {
            display: none !important;
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
            background-color: #14B8A6 !important;
            border-color: #14B8A6 !important;
            color: #ffffff !important;
            font-weight: 700 !important;
        }

        /* ── MODAL (Add New Attribute Groups) ── */
        #attribute_create_modal .modal-dialog {
            margin: 16px auto !important;
            max-width: calc(100% - 24px) !important;
        }

        #attribute_create_modal .modal-content {
            border-radius: 20px !important;
            border: none !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
            overflow: hidden !important;
            background: #ffffff !important;
            padding: 8px 4px !important;
        }

        #attribute_create_modal .modal-header {
            padding: 16px 20px 14px 20px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            align-items: center !important;
            display: flex !important;
            justify-content: space-between !important;
        }

        #attribute_create_modal .modal-header .modal-title {
            font-size: 20px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            letter-spacing: -0.3px !important;
        }

        #attribute_create_modal .modal-header .close {
            font-size: 22px !important;
            color: #94a3b8 !important;
            opacity: 1 !important;
            padding: 0 !important;
            margin: 0 !important;
            font-weight: 300 !important;
            outline: none !important;
        }

        #attribute_create_modal .modal-body {
            padding: 18px 20px 10px 20px !important;
        }

        #attribute_create_modal .flex_set {
            display: flex !important;
            flex-direction: column !important;
            margin: 0 !important;
        }

        #attribute_create_modal .max_width01 {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            margin-bottom: 0 !important;
        }

        #attribute_create_modal .modal-body .col-md-12.mt-3 {
            padding: 0 !important;
            margin-top: 16px !important;
        }

        #attribute_create_modal .form-label {
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            margin-bottom: 8px !important;
            display: block !important;
        }

        #attribute_create_modal .form-label .text-danger {
            color: #ef4444 !important;
        }

        #attribute_create_modal input.form-control.form-input {
            width: 100% !important;
            height: 48px !important;
            border-radius: 12px !important;
            border: 1px solid #e2e8f0 !important;
            padding: 0 16px !important;
            font-size: 14.5px !important;
            color: #1e293b !important;
            box-sizing: border-box !important;
            outline: none !important;
            box-shadow: none !important;
        }

        #attribute_create_modal input.form-control.form-input::placeholder {
            color: #94a3b8 !important;
            font-size: 14px !important;
        }

        #attribute_create_modal input.form-control.form-input:focus {
            border-color: #10b981 !important;
        }

        /* Select2 Style matching */
        #attribute_create_modal .select2-container {
            width: 100% !important;
            border: none !important;
            height: auto !important;
        }

        #attribute_create_modal .select2-container--default .select2-selection--multiple {
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            height: auto !important;
            min-height: 48px !important;
            padding: 6px 36px 6px 12px !important; /* right space for arrow */
            display: block !important;
            position: relative !important;
            background-color: #ffffff !important;
            box-sizing: border-box !important;
            overflow: visible !important;
        }

        #attribute_create_modal .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            gap: 4px !important;
            width: 100% !important;
            height: auto !important;
            padding: 0 !important;
            margin: 0 !important;
            white-space: normal !important;
            overflow: visible !important;
        }

        #attribute_create_modal .select2-container--default .select2-selection--multiple .select2-selection__choice {
            margin: 0 !important;
            max-width: 100% !important;
            white-space: normal !important;
        }

        #attribute_create_modal .select2-container--default .select2-search--inline {
            flex: 1 1 80px !important;
            min-width: 80px !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        #attribute_create_modal .select2-container--default .select2-search--inline .select2-search__field {
            margin: 0 !important;
            height: 32px !important;
            width: 100% !important;
            font-size: 14.5px !important;
            color: #334155 !important;
        }

        /* Dropdown arrow on Select2 in modal */
        #attribute_create_modal .select2-container--default .select2-selection--multiple::after {
            content: "" !important;
            position: absolute !important;
            top: 20px !important;
            right: 16px !important;
            width: 8px !important;
            height: 8px !important;
            border-right: 2px solid #1e293b !important;
            border-bottom: 2px solid #1e293b !important;
            transform: rotate(45deg) !important;
            pointer-events: none !important;
        }

        /* Modal Footer Buttons */
        #attribute_create_modal .modal-footer {
            padding: 16px 20px 20px 20px !important;
            border-top: none !important;
            background: transparent !important;
        }

        #attribute_create_modal .control-btns {
            display: flex !important;
            gap: 12px !important;
            padding: 0 !important;
            width: 100% !important;
        }

        #attribute_create_modal .control-btns .btn-custom {
            flex: 1 1 50% !important;
            height: 48px !important;
            border-radius: 12px !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: 0 !important;
            box-shadow: none !important;
            outline: none !important;
            border: none !important;
        }

        #attribute_create_modal .control-btns .btn-secondary {
            background-color: #94a3b8 !important;
            color: #ffffff !important;
        }

        #attribute_create_modal .control-btns .btn-success {
            background-color: #10b981 !important;
            color: #ffffff !important;
        }
    }
</style>

<div class="container-fluid mb-5 content-position">
    {{-- <div class="se-pre-con"></div> --}}

    @section('order-header')
        <span>ATTRIBUTE GROUPS</span>
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
                        @if (Gate::check('add attributes'))
                            <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" data-toggle="modal" data-target="#attribute_create_modal" title="Add New Attribute">
                                Add Attribute
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

    {{--  --}}

    <div class="col-md-12">
        <div class="card">
            {{-- <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="float-left header-title">Attributes</h1>
                        </div>
                        <div class="col-md-6 header-icons justify-content-end">
                            @if (Gate::check('add attributes'))
                            <span>
                                <a class="btn btn-round" href="#" data-toggle="modal" data-target="#attribute_create_modal">
                                    <i class="fas fa-plus"></i>
                                </a>
                                <p>Add Attribute</p>
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
                        <td style="width: 25%"></td>
                        <td>
                            <button class="styled-button" style="outline: unset;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                                Table Layout
                            </button>
                        </td>
                        <td>
                            @if (Gate::check('add attributes'))
                                <button class="btn-green-filled" style="outline: unset;" href="#" data-toggle="modal" data-target="#attribute_create_modal" title="Add New Attribute">
                                    <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD ATTRIBUTE
                                </button>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
                <div class="col-md-12 new-style-table">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="attribute_group_table">
                            <thead>
                                <th class="attribute-group-name" scope="col">Attribute Group</th>
                                <th class="product-style" scope="col">Product Style</th>
                                <th class="attribute-name" scope="col">Attributes</th>
                                <th class="created-at" scope="col">Created At</th>
                                <th class="updated-at" scope="col">Updated At</th>
                            </thead>

                            <tbody class="list">
                                @foreach ($attributeGroups as $attribute)
                                <tr>
                                    <td class="attribute-group-name"><a href="{{ route('attribute_groups.edit', $attribute->id) }}" class="edit edit_attribute_group" data-value="{{$attribute->id}}">{{$attribute->name}}</a></td>
                                    <!-- <td class="attribute-group-name"><a href="{{ route('attribute_groups.edit', $attribute->id) }}" style="color: grey !important" class="edit edit_attribute_group" data-value="{{$attribute->id}}">{{$attribute->name}}</a></td> -->
                                    <td class="product-style">
                                        <ul>
                                            @foreach ($commenHelper->getProductCategoryNameInArray($attribute->product_category_id) as $categoryName)
                                                <li>{{ $categoryName }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="attribute-name">
                                        <ul>
                                            @foreach ($attribute->groupAttributes as $groupedAttribute)
                                                <li>{{ $groupedAttribute->attribute->attribute_name ?? '' }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="created-at">{{$attribute->created_at->format('m-d-Y')}}</td>
                                    <td class="updated-at">{{$attribute->updated_at->format('m-d-Y')}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{-- Attributes Fields & Layouts --}}
<div class="modal fade" id="layout_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Attribute Groups Fields &amp; Layouts</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">
                        <input type="hidden" id="layout_id" name="layout_id" value="{{$attributeGroupLayout['id'] ?? ''}}" />
                        <input type="hidden" id="column_layout_id" name="column_layout_id" value="{{$columnLayout['id'] ?? 0}}" />

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="attribute_group_name" name="attribute_group_name" title="Attribute Group" @isset($attributeGroupLayout) @if ($attributeGroupLayout['attribute_group_name'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="attribute_group_name">Attribute Group</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="product_style" name="product_style" title="Product Style" @isset($attributeGroupLayout) @if ($attributeGroupLayout['product_style'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="product_style">Product Style</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="attribute_name" name="attribute_name" title="Attribute" @isset($attributeGroupLayout) @if ($attributeGroupLayout['attribute_name'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="attribute_name">Attribute</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="created_at" name="created_at" title="Created At" @isset($attributeGroupLayout) @if ($attributeGroupLayout['created'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="created_at">Created At</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="updated_at" name="updated_at" title="Updated At" @isset($attributeGroupLayout) @if ($attributeGroupLayout['updated'] == 1) checked @endif @endisset />
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

@include('pages.masters.attribute_groups.create')
{{-- @include('pages.masters.attributes.edit') --}}

<script>
    var searchIdx = '';

    $(document).ready( function () {
        // Attributes Table Layout
        tableLayout();

        var attributeTable = $('#attribute_group_table').DataTable({
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

        alphabet.insertBefore( attributeTable.table().container() );

        alphabet.on('click', 'span', function () {
            alphabet.find( '.active' ).removeClass( 'active' );
            $(this).addClass( 'active' );

            _alphabetSearch = $(this).data('letter');
            attributeTable.draw(_alphabetSearch);
        });

        // save column order when move
        attributeTable.on('column-reorder', function (e, settings, details) {
            var columnStr = localStorage.getItem("DataTables_attribute_group_table_/attribute_groups");
            var columnObj = JSON.parse(columnStr);
            var colReorder = new $.fn.dataTable.ColReorder( attributeTable );
            var curr = colReorder.fnOrder();
            var column_order = JSON.stringify(curr);
            var interface_name = 'Attribute Group';
            var interface_id = 15;
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
            var columnStr = localStorage.getItem("DataTables_attribute_group_table_/attribute_groups");
            var columnObj = JSON.parse(columnStr);
            var column_order = JSON.stringify(columnObj.ColReorder);
            var interface_name = 'Attribute Group';
            var interface_id = 15;
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
            var interfaceId = 15;
            $.ajax({
                url: '{{ url("datatable/get_column_order") }}/'+interfaceId,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    console.log(data.column_order);
                    var columnStr = localStorage.getItem("DataTables_attribute_group_table_/attribute_groups");
                    var columnObj = JSON.parse(columnStr);
                    columnObj.ColReorder = JSON.parse(data.column_order);

                    localStorage.setItem('DataTables_attribute_group_table_/attribute_groups', JSON.stringify(columnObj));
                },
                complete: function() {
                    $(".se-pre-con").fadeOut('slow');
                }
            });

        }

        // Embellishment Type Edit
        // $(document).on("click", ".edit_attribute_group", function(){
        //     var attributeId = $(this).data('value');
        //     $('#attribute_id').val(attributeId);
        //     $('#attribute_edit_modal').modal('show');
        //     console.log('error');
        // });


        $('#attribute_group_name').on('change', function(){ tableLayout(); });
        $('#product_style').on('change', function(){ tableLayout(); });
        $('#attribute_name').on('change', function(){ tableLayout(); });
        $('#created_at').on('change', function(){ tableLayout(); });
        $('#updated_at').on('change', function(){ tableLayout(); });
    });


    $(document).ready( function () {
        // $(document).on("click", ".edit_attribute_group", function(){
        //     var attributeId = $(this).data('value');
        //     $('#attribute_id').val(attributeId);
        //     $('#attribute_edit_modal').modal('show');
        // });
    });
    function tableLayout(){
        var layout_id = $('#layout_id').val();
        var attribute_group_name = $('#attribute_group_name').val();
        var product_style = $('#product_style').val();
        var attribute_name = $('#attribute_name').val();
        var created_at = $('#created_at').val();
        var updated_at = $('#updated_at').val();

        if($('#attribute_group_name').is(':checked')) {
            $('.attribute-group-name').css('display', 'table-cell');
            attribute_group_name = 1;
        } else {
            $('.attribute-group-name').css('display', 'none');
            attribute_group_name = 0;
        }

        if($('#product_style').is(':checked')) {
            $('.product-style').css('display', 'table-cell');
            product_style = 1;
        } else {
            $('.product-style').css('display', 'none');
            product_style = 0;
        }

        if($('#attribute_name').is(':checked')) {
            $('.attribute-name').css('display', 'table-cell');
            attribute_name = 1;
        } else {
            $('.attribute-name').css('display', 'none');
            attribute_name = 0;
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
            url: "attribute_groups/layout",
            type: "POST",
            data: {
                'layout_id':layout_id, 'attribute_group_name':attribute_group_name, 'product_style':product_style, 'attribute_name':attribute_name, 'created_at':created_at, 'updated_at':updated_at, '_token':'{{csrf_token()}}'
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
        $('#attribute_group_table thead th').each(function(){
            if($(this).text() == 'Attribute Group') {
                searchIdx = $('#attribute_group_table thead th').index(this);
                console.log(searchIdx);
            }
        });
    }

    $('#layout_modal').on('hidden.bs.modal', function () {
        $(".se-pre-con").fadeIn('slow');
        window.location.reload(true);
    });

    $(document).ready(function() {
        // Mobile View Collapse / Expand Logic
        const isMobile = () => window.innerWidth <= 768;

        const setupMobileCards = () => {
            if (!isMobile()) return;
            $('#attribute_group_table tbody tr:not(.toggle-init)').each(function () {
                $(this).addClass('is-collapsed toggle-init');
            });
        };

        setupMobileCards();
        $(window).on('resize', setupMobileCards);
        $('#attribute_group_table').on('draw.dt', setupMobileCards);

        // Toggle card collapse / expand on click
        $('#attribute_group_table').on('click', 'tbody tr', function (e) {
            if (isMobile() && !$(e.target).closest('.edit_attribute_group').length) {
                $(this).toggleClass('is-collapsed');
            }
        });
    });
</script>
@endsection
