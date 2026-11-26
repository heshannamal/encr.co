@extends('layouts.app', ['activePage' => 'attributes', 'titlePage' => __('Attributes')])

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

        /* ── Action Buttons Container (+Add Attributes) ── */
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

        /* +Add Attributes Button */
        .btn-green-filled,
        .btn-inside-table button.btn-green-filled {
            width: 100% !important;
            height: 44px !important;
            background-color: #14B8A6 !important; /* Emerald / Teal */
            border: none !important;
            border-radius: 12px !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: 0 2px 8px rgba(20, 184, 166, 0.28) !important;
            cursor: pointer !important;
            text-transform: none !important;
        }

        /* ── DataTables Top Controls (Search Bar & Show entries) ── */
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

        
        /* Hide show entries */
        .dataTables_length {
            display: none !important;
        }

        /* Show 50 entries dropdown styled neatly */
        /* .dataTables_length {
            display: block !important;
            width: 100% !important;
            margin: 0 0 14px 0 !important;
            padding: 0 !important;
            order: -2 !important;
        }

        .dataTables_length label {
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            font-size: 13.5px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .dataTables_length select {
            width: auto !important;
            min-width: 72px !important;
            height: 38px !important;
            padding: 4px 28px 4px 12px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            color: #334155 !important;
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 10px !important;
            outline: none !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02) !important;
        } */

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

        /* ── Showing info & Sort row ("Showing 4 of 29 entries") ── */
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

        /* ── Table Transformed to Cards ── */
        .table-responsive {
            overflow: visible !important;
            border: none !important;
            margin: 0 !important;
        }

        #attribute_table {
            display: block !important;
            width: 100% !important;
            border: none !important;
        }

        #attribute_table thead {
            display: none !important;
        }

        #attribute_table tbody {
            display: block !important;
            width: 100% !important;
            border: none !important;
        }

        /* Individual Attribute Card */
        #attribute_table tbody tr {
            display: flex !important;
            flex-wrap: wrap !important;
            background: #ffffff !important;
            border-radius: 16px !important;
            padding: 16px !important;
            margin-bottom: 12px !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
            border: 1px solid #f1f5f9 !important;
            position: relative !important;
            box-sizing: border-box !important;
            cursor: pointer !important;
        }

        /* Chevron indicator on the top-right */
        #attribute_table tbody tr::after {
            content: "" !important;
            position: absolute !important;
            top: 24px !important;
            right: 18px !important;
            width: 9px !important;
            height: 9px !important;
            border-right: 2px solid #64748b !important;
            border-bottom: 2px solid #64748b !important;
            transform: rotate(-135deg) !important; /* up chevron (expanded) */
            pointer-events: none !important;
            transition: transform 0.2s ease !important;
        }

        /* Down chevron when collapsed */
        #attribute_table tbody tr.is-collapsed::after {
            transform: rotate(45deg) !important; /* down chevron (collapsed) */
            top: 22px !important;
        }

        /* Attribute Name (td.attribute-name) */
        #attribute_table tbody tr td.attribute-name {
            order: 1 !important;
            display: block !important;
            padding: 0 !important;
            border: none !important;
            flex: 1 1 calc(100% - 110px) !important;
            max-width: calc(100% - 110px) !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #1F2933 !important;
            line-height: 1.4 !important;
            text-align: left !important;
            position: relative !important;
        }

        #attribute_table tbody tr td.attribute-name a.edit_attribute {
            color: #1F2933 !important;
            font-weight: 700 !important;
            font-size: 14px !important;
            text-decoration: none !important;
            display: inline-block !important;
            pointer-events: auto !important;
            cursor: pointer !important;
        }

        #attribute_table tbody tr td.attribute-name a.edit_attribute,
        #attribute_table tbody tr td.attribute-name a.edit_attribute[style] {
            color: #1F2933 !important;
        }

        /* Clickable Edit Pill Button positioned on top right */
        #attribute_table tbody tr td.attribute-name a.edit_attribute::after {
            content: "Edit" !important;
            position: absolute !important;
            top: 4px !important;
            right: -85px !important;
            padding: 4px 10px 4px 26px !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 20px !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            color: #6B7280 !important;
            background: #ffffff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='13' height='13' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7'/><path d='M18.5 2.5a2.1 2.1 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z'/></svg>") 8px center no-repeat !important;
            line-height: 1.4 !important;
            pointer-events: auto !important;
            cursor: pointer !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02) !important;
            z-index: 5 !important;
        }

        /* Price box (shown only when expanded) */
        #attribute_table tbody tr td.attribute-price {
            order: 2 !important;
            display: flex !important;
            flex-direction: column !important;
            flex: 1 1 100% !important;
            max-width: 100% !important;
            background-color: #F2F3F4 !important;
            border-radius: 12px !important;
            padding: 12px 14px 12px 42px !important;
            margin-top: 14px !important;
            border: 1px solid #f1f5f9 !important;
            position: relative !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            color: #1F2933 !important;
            box-sizing: border-box !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%23334155' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z'%3E%3C/path%3E%3Ccircle cx='7' cy='7' r='1.5'%3E%3C/circle%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: 14px center !important;
        }

        #attribute_table tbody tr td.attribute-price::before {
            content: "Price" !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            color: #6B7280 !important;
            margin-bottom: 2px !important;
        }

        #attribute_table tbody tr.is-collapsed td.attribute-price {
            display: none !important;
        }

        /* Collapsed state hides date boxes */
        #attribute_table tbody tr.is-collapsed td.created-at,
        #attribute_table tbody tr.is-collapsed td.updated-at {
            display: none !important;
        }

        /* Created At Box */
        #attribute_table tbody tr td.created-at {
            order: 3 !important;
            display: flex !important;
            flex-direction: column !important;
            flex: 1 1 calc(50% - 6px) !important;
            max-width: calc(50% - 6px) !important;
            background-color: #F2F3F4 !important;
            border-radius: 12px !important;
            padding: 12px 14px 12px 42px !important;
            margin-top: 14px !important;
            margin-right: 6px !important;
            border: 1px solid #f1f5f9 !important;
            position: relative !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            color: #1F2933 !important;
            box-sizing: border-box !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%23334155' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: 14px center !important;
        }

        #attribute_table tbody tr td.created-at::before {
            content: "Created" !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            color: #6B7280 !important;
            margin-bottom: 2px !important;
        }

        /* Last Updated Box */
        #attribute_table tbody tr td.updated-at {
            order: 4 !important;
            display: flex !important;
            flex-direction: column !important;
            flex: 1 1 calc(50% - 6px) !important;
            max-width: calc(50% - 6px) !important;
            background-color: #F2F3F4 !important;
            border-radius: 12px !important;
            padding: 12px 14px 12px 42px !important;
            margin-top: 14px !important;
            border: 1px solid #f1f5f9 !important;
            position: relative !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            color: #1F2933 !important;
            box-sizing: border-box !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%23334155' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='12' cy='12' r='10'%3E%3C/circle%3E%3Cpolyline points='12 6 12 12 16 14'%3E%3C/polyline%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: 14px center !important;
        }

        #attribute_table tbody tr td.updated-at::before {
            content: "Last Updated" !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            color: #6B7280 !important;
            margin-bottom: 2px !important;
        }

        /* ── MODALS (Add New & Edit) - image 2 & image 3 ── */
        .modal-dialog {
            margin: 16px auto !important;
            max-width: calc(100% - 24px) !important;
        }

        .modal-content {
            border-radius: 20px !important;
            border: none !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
            overflow: hidden !important;
            background: #ffffff !important;
        }

        .modal-header {
            padding: 18px 20px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            align-items: center !important;
        }

        .modal-header .modal-title {
            font-size: 18px !important;
            font-weight: 700 !important;
            color: #1F2933 !important;
        }

        .modal-header .close {
            font-size: 22px !important;
            color: #94a3b8 !important;
            opacity: 1 !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .modal-body {
            padding: 18px 20px !important;
        }

        .flex_set {
            display: flex !important;
            flex-direction: column !important;
            margin: 0 !important;
        }

        .max_width01 {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            margin-bottom: 14px !important;
        }

        .form-label {
            font-size: 12px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            margin-bottom: 6px !important;
            display: block !important;
        }

        .form-control.form-input {
            width: 100% !important;
            height: 46px !important;
            border-radius: 10px !important;
            border: 1px solid #e2e8f0 !important;
            padding: 0 14px !important;
            font-size: 14px !important;
            color: #1e293b !important;
            box-sizing: border-box !important;
            outline: none !important;
        }

        .form-control.form-input:focus {
            border-color: #10b981 !important;
        }

        /* Available Colors Multi-select */
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #e2e8f0 !important;
            border-radius: 10px !important;
            min-height: 46px !important;
            padding: 4px 8px !important;
            display: flex !important;
            align-items: center !important;
            flex-wrap: wrap !important;
        }

        /* Sub Attribute Checkbox */
        .toggle-checkbox {
            display: flex !important;
            align-items: center !important;
            margin: 6px 0 16px 0 !important;
        }

        .toggle-checkbox .custom-control-label {
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
        }

        /* Description Area */
        textarea.form-control.form-input {
            height: 110px !important;
            border-radius: 10px !important;
            padding: 10px 14px !important;
            resize: none !important;
        }

        /* Upload Area */
        .upload-area {
            height: 150px !important;
            border: 1.5px dashed #cbd5e1 !important;
            border-radius: 12px !important;
            background: #f8fafc !important;
            padding: 16px !important;
            box-sizing: border-box !important;
        }

        .upload-area i.fa-cloud-upload {
            display: none !important;
        }

        .upload-area .upload-icon {
            display: none !important;
        }

        .upload-area::before {
            content: "" !important;
            display: block !important;
            width: 38px !important;
            height: 38px !important;
            margin: 0 auto 8px auto !important;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23334155' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='3' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Ccircle cx='8.5' cy='8.5' r='1.5'%3E%3C/circle%3E%3Cpolyline points='21 15 16 10 5 21'%3E%3C/polyline%3E%3C/svg%3E") no-repeat center !important;
            background-size: 28px !important;
        }

        .upload-area p {
            font-size: 12px !important;
            color: #475569 !important;
            margin: 0 0 8px 0 !important;
            line-height: 1.3 !important;
        }

        .upload-area::after {
            content: "Upload" !important;
            display: inline-block !important;
            border: 1px solid #3b82f6 !important;
            color: #3b82f6 !important;
            border-radius: 8px !important;
            padding: 4px 16px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            background: #ffffff !important;
        }

        /* Uploaded Images Table inside Modal */
        #uploaded_attribute_images_table,
        #uploaded_attribute_images_table_edit {
            margin-top: 14px !important;
        }

        .sub-header-style {
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            padding: 0 0 6px 0 !important;
        }

        .subProductTable {
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            overflow: hidden !important;
        }

        .subProductTable thead {
            display: none !important;
        }

        .subProductTable tbody tr {
            border-bottom: 1px solid #f1f5f9 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 8px 12px !important;
        }

        /* Modal Footer Buttons */
        .modal-footer,
        .card-footer {
            padding: 16px 20px !important;
            border-top: none !important;
            background: transparent !important;
        }

        .control-btns {
            display: flex !important;
            gap: 10px !important;
            padding: 0 !important;
            width: 100% !important;
        }

        .control-btns .btn-custom {
            flex: 1 1 50% !important;
            height: 46px !important;
            border-radius: 10px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: 0 !important;
        }

        .control-btns .btn-secondary {
            background-color: #94a3b8 !important;
            border: none !important;
            color: #ffffff !important;
        }

        .control-btns .btn-success {
            background-color: #10b981 !important;
            border: none !important;
            color: #ffffff !important;
        }

        .control-btns .btn-danger {
            background-color: #ef4444 !important;
            border: none !important;
            color: #ffffff !important;
            flex: 1 1 33% !important;
        }

        .mobile-footer {
            margin-left: 15px !important;
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
    }
</style>

<div class="container-fluid mb-5 content-position">
    {{-- <div class="se-pre-con"></div> --}}

    @section('order-header')
        <span>ATTRIBUTES</span>
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
                        <table class="table align-items-center" id="attribute_table">
                            <thead>
                                <th class="attribute-name" scope="col">Attribute</th>
                                <th class="attribute-price" scope="col">Price</th>
                                <th class="created-at" scope="col">Created At</th>
                                <th class="updated-at" scope="col">Updated At</th>
                            </thead>

                            <tbody class="list">
                                @foreach ($attributes as $attribute)
                                <tr>
                                    <td class="attribute-name"><a href="#" class="edit edit_attribute" data-value="{{$attribute->id}}">{{$attribute->attribute_name}}</a></td>
                                    <!-- <td class="attribute-name"><a href="#" style="color: grey !important" class="edit edit_attribute" data-value="{{$attribute->id}}">{{$attribute->attribute_name}}</a></td> -->
                                    <td class="attribute-price">{{$attribute->price}}</td>
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
                <h3 class="modal-title" id="modal-title-default">Attributes Fields &amp; Layouts</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">
                        <input type="hidden" id="layout_id" name="layout_id" value="{{$attributeLayout['id'] ?? ''}}" />
                        <input type="hidden" id="column_layout_id" name="column_layout_id" value="{{$columnLayout['id'] ?? 0}}" />

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="attribute_name" name="attribute_name" title="Attribute" @isset($attributeLayout) @if ($attributeLayout['attribute_name'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="attribute_name">Attribute</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="created_at" name="created_at" title="Created At" @isset($attributeLayout) @if ($attributeLayout['created'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="created_at">Created At</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="updated_at" name="updated_at" title="Updated At" @isset($attributeLayout) @if ($attributeLayout['updated'] == 1) checked @endif @endisset />
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

@include('pages.masters.attributes.create')
@include('pages.masters.attributes.edit')

<script>
    var searchIdx = '';

    $(document).ready( function () {
        // Attributes Table Layout
        tableLayout();

        var attributeTable = $('#attribute_table').DataTable({
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
            var columnStr = localStorage.getItem("DataTables_attribute_table_/attributes");
            var columnObj = JSON.parse(columnStr);
            var colReorder = new $.fn.dataTable.ColReorder( attributeTable );
            var curr = colReorder.fnOrder();
            var column_order = JSON.stringify(curr);
            var interface_name = 'Attribute';
            var interface_id = 13;
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
            var columnStr = localStorage.getItem("DataTables_attribute_table_/attributes");
            var columnObj = JSON.parse(columnStr);
            var column_order = JSON.stringify(columnObj.ColReorder);
            var interface_name = 'Attribute';
            var interface_id = 13;
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
            var interfaceId = 13;
            $.ajax({
                url: '{{ url("datatable/get_column_order") }}/'+interfaceId,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    console.log(data.column_order);
                    var columnStr = localStorage.getItem("DataTables_attribute_table_/attributes");
                    var columnObj = JSON.parse(columnStr);
                    columnObj.ColReorder = JSON.parse(data.column_order);

                    localStorage.setItem('DataTables_attribute_table_/attributes', JSON.stringify(columnObj));
                },
                complete: function() {
                    $(".se-pre-con").fadeOut('slow');
                }
            });

        }

        // Embellishment Type Edit
        // $(document).on("click", ".edit_attribute", function(){
        //     var attributeId = $(this).data('value');
        //     $('#attribute_id').val(attributeId);
        //     $('#attribute_edit_modal').modal('show');
        //     console.log('error');
        // });


        $('#attribute_name').on('change', function(){ tableLayout(); });
        $('#created_at').on('change', function(){ tableLayout(); });
        $('#updated_at').on('change', function(){ tableLayout(); });
    });


    $(document).ready( function () {
        $(document).on("click", ".edit_attribute", function(){
            var attributeId = $(this).data('value');
            $('#attribute_id').val(attributeId);
            $('#attribute_edit_modal').modal('show');
        });
    });
    function tableLayout(){
        var layout_id = $('#layout_id').val();
        var attribute_name = $('#attribute_name').val();
        var created_at = $('#created_at').val();
        var updated_at = $('#updated_at').val();

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
            url: "attributes/layout",
            type: "POST",
            data: {
                'layout_id':layout_id, 'attribute_name':attribute_name, 'created_at':created_at, 'updated_at':updated_at, '_token':'{{csrf_token()}}'
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
        $('#attribute_table thead th').each(function(){
            if($(this).text() == 'Attribute') {
                searchIdx = $('#attribute_table thead th').index(this);
                console.log(searchIdx);
            }
        });
    }

    $('#layout_modal').on('hidden.bs.modal', function () {
        $(".se-pre-con").fadeIn('slow');
        window.location.reload(true);
    });

    // Mobile View Collapse / Expand Logic
    $(document).ready(function() {
        const isMobile = () => window.innerWidth <= 768;

        const setupMobileCards = () => {
            if (!isMobile()) return;
            $('#attribute_table tbody tr:not(.toggle-init)').each(function (index) {
                // Keep the first item expanded if needed, or collapse all
                $(this).addClass('is-collapsed toggle-init');
            });
        };

        setupMobileCards();
        $(window).on('resize', setupMobileCards);
        $('#attribute_table').on('draw.dt', setupMobileCards);

        // Toggle card collapse / expand when clicking anywhere on the card except the Edit link
        $('#attribute_table').on('click', 'tbody tr', function (e) {
            if (isMobile() && !$(e.target).closest('.edit_attribute').length) {
                $(this).toggleClass('is-collapsed');
            }
        });
    });
</script>
@endsection
