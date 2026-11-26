@extends('layouts.app', ['activePage' => 'sizes', 'titlePage' => __('Sizes')])

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
        right: -7px;
        font-size: 15px;
    }
    .content-position {
        position: relative;
        top: -45px;
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

    /* MOBILE RESPONSIVE STYLES (≤ 768px) */
    @media (max-width: 768px) {

        body {
            background-color: #f8fafc !important;
        }

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

        /* ── Action Buttons Row (Table Layout + Add Size) ── */
        .col-md-4.ml-auto.mb-2.mt-2 {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 0 14px 0 !important;
        }

        .btn-inside-table {
            width: calc(100% + 10px) !important;
            margin-left: -5px !important;
            margin-right: -5px !important;
            table-layout: fixed !important;
            border-collapse: separate !important;
            border-spacing: 10px 0 !important;
        }

        .btn-inside-table tr td:first-child {
            display: none !important;
        }

        .btn-inside-table tr td {
            padding: 0 !important;
        }

        .styled-button {
            width: 100% !important;
            height: 42px !important;
            background-color: #ffffff !important;
            color: #475569 !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            padding: 0 5px !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important;
            transition: all 0.2s ease !important;
            cursor: pointer !important;
        }

        .styled-button:hover,
        .styled-button:active {
            background-color: #f1f5f9 !important;
            color: #1e293b !important;
            border-color: #cbd5e1 !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08) !important;
            transform: translateY(-1px) !important;
        }

        .btn-green-filled,
        .btn-inside-table button.btn-green-filled,
        .btn-inside-table .btn-green-filled {
            width: 100% !important;
            height: 44px !important;
            background-color: #14b8a6 !important;
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
            padding: 0 5px !important;
        }

        .btn-green-filled:hover,
        .btn-green-filled:active,
        .btn-inside-table button.btn-green-filled:hover,
        .btn-inside-table button.btn-green-filled:active {
            background-color: #0d9488 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(20, 184, 166, 0.35) !important;
            transform: translateY(-1px) !important;
        }

        /* ── Alphabet A-Z Filter (Hidden on mobile) ── */
        div.alphabet {
            display: none !important;
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

        /* Hide show entries */
        .dataTables_length {
            display: none !important;
        }

        /* Always show all details on mobile, ignoring Table Layout settings */
        #size_table tbody tr td.size-name {
            display: flex !important;
        }
        #size_table tbody tr td.size-type {
            display: flex !important;
        }
        #size_table tbody tr td.created-at,
        #size_table tbody tr td.updated-at {
            display: block !important;
        }

        /* Keep collapsed cards collapsed (must come AFTER the rules above) */
        #size_table tbody tr.is-collapsed td.size-type,
        #size_table tbody tr.is-collapsed td.created-at,
        #size_table tbody tr.is-collapsed td.updated-at {
            display: none !important;
        }

        /* Hide Table Layout button on mobile */
        .btn-inside-table tr td:nth-child(2),
        .btn-inside-table tr td:nth-child(2) button {
            display: none !important;
        }

        /* Hide Size Name & Size Type detail blocks in expanded card (already shown in header) */
        #size_table tbody tr:not(.is-collapsed) span.mobile-size-name-block,
        #size_table tbody tr td.size-type,
        #size_table tbody tr:not(.is-collapsed) td.size-type {
            display: none !important;
        }

        /* Created / Last Updated take over the row */
        #size_table tbody tr td.created-at,
        #size_table tbody tr td.updated-at {
            margin-top: 0 !important;
        }

        /* ── Show entries dropdown ── */
        /* .dataTables_length {
            width: 100% !important;
            text-align: center !important;
            margin: 0 0 12px 0 !important;
            display: block !important;
        }

        .dataTables_length label {
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            margin: 0 !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            color: #64748b !important;
        }

        .dataTables_length select {
            width: auto !important;
            min-width: 72px !important;
            height: 36px !important;
            padding: 4px 28px 4px 12px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            line-height: 1.2 !important;
            color: #334155 !important;
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 10px !important;
            box-shadow: none !important;
            overflow: visible !important;
        } */

        /* ── Search Input ("Search") ── */
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

        /* .dataTables_info::after {
            content: "Sort: Product Style Name" !important;
            font-size: 13px !important;
            color: #64748b !important;
            font-weight: 500 !important;
        } */

        /* ── Hide table header ── */
        #size_table thead {
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

        #size_table {
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
        #size_table tbody {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            width: 100% !important;
        }

        /* ── Each row = Modern White Card with 18px radius ── */
        #size_table tbody tr {
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
        #size_table tbody tr td {
            border: none !important;
            padding: 0 !important;
            background: transparent !important;
            min-height: 0 !important;
        }

        /* ── 1. Size Name (td.size-name) in Card Header ── */
        #size_table tbody tr td.size-name {
            order: 1 !important;
            flex: 1 1 calc(100% - 32px) !important;
            max-width: calc(100% - 32px) !important;
            min-width: 0 !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-start !important;
            justify-content: center !important;
            min-height: 42px !important;
        }

        #size_table tbody tr td.size-name a.edit {
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #1F2933 !important;
            text-decoration: none !important;
            word-break: break-word !important;
            overflow-wrap: anywhere !important;
            white-space: normal !important;
            line-height: 1.3 !important;
            display: block !important;
            padding-right: 84px !important;
        }

        /* Edit pill button inside name row */
        #size_table tbody tr td.size-name a.edit::after {
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
        #size_table tbody tr::after {
            content: "\f078" !important; /* chevron-down */
            font-family: 'Font Awesome 5 Free', 'FontAwesome' !important;
            font-weight: 900 !important;
            position: absolute !important;
            right: 18px !important;
            top: 22px !important;
            font-size: 13px !important;
            color: #1F2933 !important;
            pointer-events: none !important;
        }

        /* ── Subtitle (Size Type) under Size Name in header ── */
        #size_table tbody tr td.size-name::after {
            content: attr(data-size-type) !important;
            display: block !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            color: #1F2933 !important;
            margin-top: 2px !important;
            line-height: 1.3 !important;
        }

        /* ── Divider between card header and expanded details ── */
        #size_table tbody tr:not(.is-collapsed)::before {
            content: "" !important;
            order: 2 !important;
            width: 100% !important;
            height: 1px !important;
            background: #f1f5f9 !important;
            margin: 14px 0 14px 0 !important;
            display: block !important;
        }

        /* ── Expanded Section Details (Items inside card) ── */
        /* Hide redundant Size Name detail inside expanded card (already displayed in header) */
        span.mobile-size-name-block,
        #size_table tbody tr span.mobile-size-name-block,
        #size_table tbody tr:not(.is-collapsed) span.mobile-size-name-block,
        #size_table tbody tr.is-collapsed span.mobile-size-name-block {
            display: none !important;
        }

        /* 2) Size Type (td.size-type) Detail Block (Inside expanded card) */
        #size_table tbody tr td.size-type {
            order: 4 !important;
            width: calc(50% - 6px) !important;
            margin-left: 6px !important;
            margin-bottom: 2px !important;
            display: flex !important;
            flex-direction: column !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            box-sizing: border-box !important;
            line-height: 1.3 !important;
        }

        #size_table tbody tr td.size-type::before {
            content: "Size Type" !important;
            display: block !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            margin-bottom: 4px !important;
        }

        /* 3) Created At (td.created-at) */
        #size_table tbody tr td.created-at {
            order: 5 !important;
            width: calc(50% - 6px) !important;
            /* margin-top: 14px !important; */
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

        #size_table tbody tr td.created-at::before {
            content: "Created" !important;
            display: block !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            color: #6B7280 !important;
            margin-bottom: 2px !important;
        }

        /* 4) Last Updated (td.updated-at) */
        #size_table tbody tr td.updated-at {
            order: 6 !important;
            width: calc(50% - 6px) !important;
            /* margin-top: 14px !important; */
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

        #size_table tbody tr td.updated-at::before {
            content: "Last Updated" !important;
            display: block !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            color: #6B7280 !important;
            margin-bottom: 2px !important;
        }

        /* ── COLLAPSIBLE STATE (is-collapsed) ── */
        /* Collapsed (default): hide all 4 expanded details */
        #size_table tbody tr.is-collapsed td.size-type,
        #size_table tbody tr.is-collapsed td.created-at,
        #size_table tbody tr.is-collapsed td.updated-at {
            display: none !important;
        }

        #size_table tbody tr.is-collapsed::after {
            content: "\f078" !important; /* chevron-down */
        }

        #size_table tbody tr:not(.is-collapsed)::after {
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
            background-color: #14B8A6 !important;
            border-color: #14B8A6 !important;
            color: #ffffff !important;
            font-weight: 700 !important;
        }

        /* ── Modal styling on mobile (Add & Edit Size Modals) ── */
        #size_create_modal .modal-dialog,
        #size_edit_modal .modal-dialog {
            margin: 16px auto !important;
            max-width: calc(100% - 32px) !important;
        }

        #size_create_modal .modal-content,
        #size_edit_modal .modal-content {
            border-radius: 24px !important;
            border: 1px solid #f1f5f9 !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
            background: #ffffff !important;
            overflow: hidden !important;
        }

        #size_create_modal .modal-header,
        #size_edit_modal .modal-header {
            padding: 22px 24px 18px 24px !important;
            border-bottom: 1px solid #eef2f6 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            background: #ffffff !important;
        }

        #size_create_modal .modal-title,
        #size_edit_modal .modal-title {
            font-size: 20px !important;
            font-weight: 800 !important;
            color: #111827 !important;
            margin: 0 !important;
            letter-spacing: -0.3px !important;
        }

        #size_create_modal .modal-header button.close,
        #size_edit_modal .modal-header button.close {
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

        /* #size_create_modal .modal-body,
        #size_edit_modal .modal-body {
            padding: 16px 24px !important;
            background: #ffffff !important;
        } */

        #size_create_modal .modal-body .row,
        #size_edit_modal .modal-body .row {
            display: flex !important;
            flex-direction: column !important;
            margin: 0 !important;
        }

        #size_create_modal .modal-body .form-field,
        #size_edit_modal .modal-body .form-field {
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-start !important;
            padding: 0 !important;
            margin-bottom: 16px !important;
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }

        #size_create_modal .modal-body label,
        #size_create_modal .modal-body .form-lable,
        #size_edit_modal .modal-body label,
        #size_edit_modal .modal-body .form-lable {
            display: block !important;
            width: 100% !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            margin-bottom: 8px !important;
            text-align: left !important;
        }

        #size_create_modal .modal-body label .text-danger,
        #size_edit_modal .modal-body label .text-danger {
            color: #ef4444 !important;
            margin-left: 2px !important;
        }

        #size_create_modal input[type="text"],
        #size_create_modal select,
        #size_edit_modal input[type="text"],
        #size_edit_modal select {
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

        #size_create_modal .modal-footer,
        #size_edit_modal .modal-footer {
            padding: 16px 24px 24px 24px !important;
            border-top: none !important;
            background: #ffffff !important;
        }

        #size_create_modal .control-btns,
        #size_edit_modal .control-btns {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 12px !important;
            width: 100% !important;
            padding: 0 !important;
        }

        #size_create_modal .control-btns .btn,
        #size_edit_modal .control-btns .btn {
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

        #size_create_modal .control-btns .btn-secondary,
        #size_edit_modal .control-btns .btn-secondary {
            background-color: #94a3b8 !important;
            color: #ffffff !important;
        }

        #size_create_modal .control-btns .btn-success,
        #size_edit_modal .control-btns .btn-success {
            background-color: #10b981 !important;
            color: #ffffff !important;
        }

        #size_edit_modal .control-btns .btn-danger {
            background-color: #dc2626 !important;
            color: #ffffff !important;
        }
    }
</style>

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>SIZES</span>
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
                        @if (Gate::check('add sizes'))
                            <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" data-toggle="modal" data-target="#size_create_modal" title="Add New Size">
                                Add Size
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
                            <h1 class="float-left header-title">Sizes</h1>
                        </div>
                        <div class="col-md-6 header-icons justify-content-end">
                            @if (Gate::check('add sizes'))
                             <span>
                                 <a class="btn btn-round" href="#" data-toggle="modal" data-target="#size_create_modal">
                                     <i class="fas fa-plus"></i>
                                 </a>
                                 <p>Add Sizes</p>
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
                            <td style="width: 25%"></td>
                            <td>
                                <button class="styled-button" style="outline: unset;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                                    Table Layout
                                </button>
                            </td>
                            <td>
                                @if (Gate::check('add sizes'))
                                    <button class="btn-green-filled" style="outline: unset;" href="#" data-toggle="modal" data-target="#size_create_modal" title="Add New Size">
                                        <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD SIZE
                                    </button>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-12 new-style-table">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="size_table">
                            <thead>
                                <th class="size-name" scope="col">Size Name</th>
                                <th class="size-type" scope="col">Size Type</th>
                                <th class="created-at" scope="col">Created At</th>
                                <th class="updated-at" scope="col">Updated At</th>
                            </thead>

                            <tbody class="list">
                                @foreach ($sizes as $size)
                                <tr>
                                    <td class="size-name"><a href="#" class="edit" data-value="{{$size->id}}">{{$size->size_name}}</a></td>
                                    <td class="size-type">
                                        @foreach ($sizeTypes as $sizeType)
                                            @if ($size->size_type == $sizeType->id)
                                                {{ $sizeType->type_name }}
                                            @endif
                                        @endforeach

                                    </td>
                                    <td class="created-at">{{$size->created_at->format('m-d-Y')}}</td>
                                    <td class="updated-at">{{$size->updated_at->format('m-d-Y')}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>

    </div>
</div>

@include('pages.masters.sizes.create')
@include('pages.masters.sizes.edit')

{{-- Sizes Fields & Layouts --}}
<div class="modal fade" id="layout_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Sizes Fields &amp; Layouts</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">

                        <input type="hidden" id="layout_id" name="layout_id" value="{{$sizeLayout['id']  ?? ''}}" />
                        <input type="hidden" id="column_layout_id" name="column_layout_id" value="{{$columnLayout['id'] ?? 0}}" />

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="size_name" name="size_name" title="Size Name" @isset($sizeLayout) @if ($sizeLayout['size_name'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="size_name">Size Name</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="size_type" name="size_type" title="Size Type" @isset($sizeLayout) @if ($sizeLayout['size_type'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="size_type">Size Type</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="created_at" name="created_at" title="Created At" @isset($sizeLayout) @if ($sizeLayout['created'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="created_at">Created At</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="updated_at" name="updated_at" title="Updated At" @isset($sizeLayout) @if ($sizeLayout['updated'] == 1) checked @endif @endisset />
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

    $(document).ready(function () {
        // Sizes Table Layout
        tableLayout();

        var sizeTable = $('#size_table').DataTable({
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

        alphabet.insertBefore( sizeTable.table().container() );

        alphabet.on('click', 'span', function () {
            alphabet.find( '.active' ).removeClass( 'active' );
            $(this).addClass( 'active' );

            _alphabetSearch = $(this).data('letter');
            sizeTable.draw(_alphabetSearch);
        });

        // save column order when move
        sizeTable.on('column-reorder', function (e, settings, details) {
            var columnStr = localStorage.getItem("DataTables_size_table_/sizes");
            var columnObj = JSON.parse(columnStr);
            var colReorder = new $.fn.dataTable.ColReorder( sizeTable );
            var curr = colReorder.fnOrder();
            var column_order = JSON.stringify(curr);
            var interface_name = 'Size';
            var interface_id = 7;
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
            var columnStr = localStorage.getItem("DataTables_size_table_/sizes");
            var columnObj = JSON.parse(columnStr);
            var column_order = JSON.stringify(columnObj.ColReorder);
            var interface_name = 'Size';
            var interface_id = 7;
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
            var interfaceId = 7;
            $.ajax({
                url: '{{ url("datatable/get_column_order") }}/'+interfaceId,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    console.log(data.column_order);
                    var columnStr = localStorage.getItem("DataTables_size_table_/sizes");
                    var columnObj = JSON.parse(columnStr);
                    columnObj.ColReorder = JSON.parse(data.column_order);

                    localStorage.setItem('DataTables_size_table_/sizes', JSON.stringify(columnObj));
                },
                complete: function() {
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        }

        // Size Edit
        $("body").on("click", ".edit", function(e){
            if (e && e.preventDefault) e.preventDefault();
            var sizeId = $(this).data('value');
            $('#size_id').val(sizeId);
            $('#size_edit_modal').modal('show');
        });

        // Mobile View Collapse / Expand Logic
        const isMobile = () => window.innerWidth <= 768;

        const setupMobileCards = () => {
            if (!isMobile()) return;
            $('#size_table tbody tr:not(.toggle-init)').each(function () {
                const $row = $(this);
                $row.addClass('is-collapsed toggle-init');

                // Copy Size Type text to data-size-type attribute on td.size-name for subtitle display
                const sizeType = $row.find('td.size-type').text().trim();
                if (sizeType) {
                    $row.find('td.size-name').attr('data-size-type', sizeType);
                }

                // Add the expanded Size Name detail block inside card (Size Name + value) if not already added
                if (!$row.find('.mobile-size-name-block').length) {
                    const sizeName = $row.find('td.size-name a.edit').text().trim();
                    $row.append(`
                        <span class="mobile-size-name-block" style="order: 3;">
                            <span style="font-size: 12px; font-weight: 500; color: #64748b; margin-bottom: 4px;">Size Name</span>
                            <span style="font-size: 15px; font-weight: 700; color: #1e293b; line-height: 1.3;">${sizeName}</span>
                        </span>
                    `);
                }
            });
        };

        setupMobileCards();
        $(window).on('resize', setupMobileCards);
        $('#size_table').on('draw.dt', setupMobileCards);

        // Toggle card collapse / expand on card click
        $('#size_table').on('click', 'tbody tr', function (e) {
            if (isMobile() && !$(e.target).closest('.edit').length) {
                $(this).toggleClass('is-collapsed');
            }
        });

        $('#size_name').on('change', function(){ tableLayout(); });
        $('#size_type').on('change', function(){ tableLayout(); });
        $('#created_at').on('change', function(){ tableLayout(); });
        $('#updated_at').on('change', function(){ tableLayout(); });
    });

    function tableLayout(){
        var layout_id = $('#layout_id').val();
        var size_name = $('#size_name').val();
        var size_type = $('#size_type').val();
        var created_at = $('#created_at').val();
        var updated_at = $('#updated_at').val();

        if($('#size_name').is(':checked')) {
            $('.size-name').css('display', 'table-cell');
            size_name = 1;
        } else {
            $('.size-name').css('display', 'none');
            size_name = 0;
        }

        if($('#size_type').is(':checked')) {
            $('.size-type').css('display', 'table-cell');
            size_type = 1;
        } else {
            $('.size-type').css('display', 'none');
            size_type = 0;
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
            url:'sizes/layout',
            type:'POST',
            data: {
                'layout_id':layout_id, 'size_name':size_name, 'size_type':size_type, 'created_at':created_at, 'updated_at':updated_at, '_token':'{{csrf_token()}}'
            },
            success: function (data, textStatus, jqXHR) {
                console.log(data);
                if(data == '"Saved"') {
                    window.location.reload(true);
                }
            }
        });
    }

    function searchIndex(){
        $('#size_table thead th').each(function(){
            if($(this).text() == 'Size Name') {
                searchIdx = $('#size_table thead th').index(this);
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
