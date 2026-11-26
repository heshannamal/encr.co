@extends('layouts.app', ['activePage' => 'products', 'titlePage' => __('Products')])

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
        width: 45%;
    }
    .form-input,
    .select2.select2-container {
        width: 100% !important;
    }
    #new_fabric_id,
    #new_embellishment_type_id,
    #new_product_attribute_id,
    #new_product_category_id,
    #new_main_category_id,
    #new_product_factory_id,
    #edit_fabric_id,
    #edit_embellishment_type_id,
    #edit_product_attribute_id,
    #edit_product_factory_id,
    #edit_product_category_id,
    #edit_main_category_id {
        height: 68px !important;
    }
    #new_fabric_id + .select2.select2-container,
    #new_embellishment_type_id + .select2.select2-container,
    #new_product_attribute_id + .select2.select2-container,
    #new_product_category_id + .select2.select2-container,
    #new_main_category_id + .select2.select2-container,
    #new_product_factory_id + .select2.select2-container,
    #edit_fabric_id + .select2.select2-container,
    #edit_embellishment_type_id + .select2.select2-container,
    #edit_product_attribute_id + .select2.select2-container,
    #edit_product_factory_id + .select2.select2-container,
    #edit_product_category_id + .select2.select2-container,
    #edit_main_category_id + .select2.select2-container{
        min-height: 60px !important;
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
        width: 90px;
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
    .new-style-table .alphabet {
        padding-right: 1rem;
        padding-left: 1rem;
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
    .swal2-styled{
        padding: .4rem 1rem !important;
        border-radius:0rem !important;
        font-size: .8rem !important;
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
    .btn-inside-table button{
        width: 100% !important;
        padding: 5% 3% !important;
        font-size: .7rem !important;
        height: 2.1rem;
        font-size: .7rem !important;
    }
    body {
        font-family: 'Open Sans', 'sans-serif' !important;
    }
    table a {
        font-weight: unset !important;
    }

    /* MOBILE RESPONSIVE STYLES (≤ 768px) */
    @media (max-width: 768px) {

        /* ── Page Layout ── */
        .content-position {
            position: relative !important;
            top: 0 !important;
            padding: 12px 14px 40px 14px !important;
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
            margin: 0 !important;
        }

        .col-md-12 {
            padding: 0 !important;
        }

        /* ── Action Buttons Container: Export & +Add Product ── */
        .col-md-9.row.mt-3.mb-3.ml-auto {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 0 14px 0 !important;
        }

        .col-md-10.ml-auto {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
        }

        .btn-inside-table {
            width: 100% !important;
            table-layout: fixed !important;
            margin: 0 !important;
            display: block !important;
        }

        .btn-inside-table tbody,
        .btn-inside-table tr {
            display: flex !important;
            width: 100% !important;
            gap: 12px !important;
            align-items: center !important;
        }

        /* Hide "Show inactive products" checkbox and "Table Layout" button on mobile */
        .btn-inside-table tr td:first-child,
        .btn-inside-table tr td:nth-child(3) {
            display: none !important;
        }

        /* Export button cell */
        .btn-inside-table tr td:nth-child(2) {
            flex: 0 0 calc(50% - 6px) !important;
            width: calc(50% - 6px) !important;
            padding: 0 !important;
        }

        /* +Add Product button cell */
        .btn-inside-table tr td:last-child {
            flex: 0 0 calc(50% - 6px) !important;
            width: calc(50% - 6px) !important;
            padding: 0 !important;
        }

        /* Export button matching */
        #display_csv.styled-button {
            width: 100% !important;
            height: 44px !important;
            background-color: #ffffff !important;
            color: #475569 !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            margin: 0 !important;
            cursor: pointer !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02) !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            padding: 0 10px !important;
        }

        #display_csv.styled-button::before {
            content: "" !important;
            display: inline-block !important;
            width: 16px !important;
            height: 16px !important;
            background: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23475569' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'><path d='M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4'></path><polyline points='7 10 12 15 17 10'></polyline><line x1='12' y1='15' x2='12' y2='3'></line></svg>") no-repeat center !important;
            background-size: contain !important;
        }

        /* +Add Product button matching  */
        #add_product_btn.btn-green-filled {
            width: 100% !important;
            height: 44px !important;
            background-color: #14b8a6 !important; /* Emerald / Teal */
            border: none !important;
            border-radius: 12px !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: 0 2px 8px rgba(20, 184, 166, 0.28) !important;
            cursor: pointer !important;
            text-transform: none !important;
            margin: 0 !important;
            padding: 0 10px !important;
        }

        /* ── DataTables Top Controls (Search Bar) ── */
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

        /* Search input styled as "Search this product" */
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
            color: transparent !important;
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
            outline: none !important;
        }

        .dataTables_filter input::placeholder {
            color: #94a3b8 !important;
            font-size: 14px !important;
        }

        /* ── Showing count & Sort info row ("Showing 4 of 128 | Sorted: Product No.") ── */
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
            width: 100% !important;
        }

        /* .dataTables_info::after {
            content: "Sorted: Product No." !important;
            font-size: 13px !important;
            color: #64748b !important;
            font-weight: 500 !important;
            margin-left: auto !important;
        } */

        /* ── Table Container & Reset ── */
        .col-md-12.new-style-table {
            padding: 0 !important;
        }

        .new-style-table > div {
            overflow: visible !important;
        }

        #product_table.table-responsive {
            overflow-x: visible !important;
            overflow-y: visible !important;
            border: none !important;
            margin: 0 !important;
            display: block !important;
            width: 100% !important;
            min-width: unset !important;
            background: transparent !important;
        }

        /* Hide table thead on mobile */
        #product_table thead {
            display: none !important;
        }

        /* tbody: vertical list of cards */
        #product_table tbody.list {
            display: flex !important;
            flex-direction: column !important;
            gap: 0 !important;
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

        .new-style-table .table tbody td,
        .new-style-table .table tbody td a {
            padding: 0 !important;
            font-size: inherit !important;
        }

        /* ── Main Product Card (Parent TR) ── */
        #product_table tbody.list tr:not([class*="trOfProduct"]) {
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            position: relative !important;
            background-color: #ffffff !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 18px !important;
            padding: 16px 16px 14px 16px !important;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04) !important;
            box-sizing: border-box !important;
            width: 100% !important;
            min-height: 0 !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            margin-bottom: 12px !important;
        }

        /* When expanded: parent card top border & rounded top corners, seamless bottom to subproducts */
        #product_table tbody.list tr.is-expanded:not([class*="trOfProduct"]) {
            background-color: #ffffff !important;
            background: #ffffff !important;
            border-top: 1px solid #e2e8f0 !important;
            border-left: 1px solid #e2e8f0 !important;
            border-right: 1px solid #e2e8f0 !important;
            border-bottom: 1px solid #f1f5f9 !important;
            border-top-left-radius: 18px !important;
            border-top-right-radius: 18px !important;
            border-bottom-left-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
            margin-bottom: 0 !important;
            box-shadow: none !important;
        }

        /* Cloned sub-product rows inserted after parent */
        #product_table tbody.list tr[class*="trOfProduct"] {
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            position: relative !important;
            background-color: #ffffff !important;
            background: #ffffff !important;
            border-left: 1px solid #e2e8f0 !important;
            border-right: 1px solid #e2e8f0 !important;
            border-top: none !important;
            border-bottom: none !important;
            border-radius: 0 !important;
            padding: 7px 14px !important;
            box-sizing: border-box !important;
            width: 100% !important;
            margin: 0 !important;
            box-shadow: none !important;
        }

        /* The last sub-product row gets bottom border and rounded bottom corners */
        #product_table tbody.list tr.is-last-subproduct[class*="trOfProduct"] {
            border-bottom: 1px solid #e2e8f0 !important;
            border-bottom-left-radius: 18px !important;
            border-bottom-right-radius: 18px !important;
            padding-bottom: 14px !important;
            margin-bottom: 12px !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03) !important;
        }

        /* Inner card inside each sub-product row */
        .subproduct-card-inner {
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            width: 100% !important;
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 14px !important;
            padding: 14px 16px !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02) !important;
            box-sizing: border-box !important;
            position: relative !important;
        }

        /* Strip default td borders/padding */
        #product_table tbody.list tr td {
            border: none !important;
            padding: 0 !important;
            background: transparent !important;
            min-height: 0 !important;
        }

        /* collapseButton td positioned over the top-right corner on mobile */
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.collapseButton {
            position: absolute !important;
            right: 0 !important;
            top: 0 !important;
            width: 60px !important;
            height: 60px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
            /* z-index: 10 !important; */
            padding: 0 !important;
            margin: 0 !important;
        }

        /* The actual FontAwesome chevron inside td.collapseButton */
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.collapseButton i#charvonIconStyle,
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.collapseButton i {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 40px !important;
            height: 40px !important;
            font-size: 14px !important;
            color: #1F2933 !important;
            cursor: pointer !important;
            margin-top: -8px;
            margin-right: -8px;
        }

        /* When chevron is right (collapsed) */
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.collapseButton i.fa-chevron-right::before {
            content: "\f078" !important; /* fa-chevron-down icon */
        }

        /* When chevron is down (expanded) */
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.collapseButton i.fa-chevron-down::before {
            content: "\f077" !important; /* fa-chevron-up icon */
        }

        /* ── 1. Product Name (Line 1) ── */
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.product-name {
            order: 1 !important;
            flex: 0 0 calc(100% - 32px) !important;
            max-width: calc(100% - 32px) !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #1F2933 !important;
            line-height: 1.3 !important;
            margin-bottom: 4px !important;
            padding-right: 20px !important;
        }

        #product_table tbody.list tr:not([class*="trOfProduct"]) td.product-name a {
            color: #1F2933 !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            text-decoration: none !important;
            white-space: break-spaces !important;
        }

        /* ── Line 2: Meta Sub-header: No.X • DWC0120 • $30.00 ── */
        /* We arrange product-no, pattern-code, default-price on line 2 */
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.product-no {
            order: 2 !important;
            flex: 0 0 auto !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            color: #6B7280 !important;
            margin-right: 4px !important;
            text-align: left !important;
        }

        #product_table tbody.list tr:not([class*="trOfProduct"]) td.product-no a {
            color: #6B7280 !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            text-decoration: none !important;
        }

        #product_table tbody.list tr:not([class*="trOfProduct"]) td.product-no::before {
            content: "No." !important;
        }

        #product_table tbody.list tr:not([class*="trOfProduct"]) td.product-no::after {
            content: " • " !important;
            color: #94a3b8 !important;
            margin: 0 3px !important;
        }

        #product_table tbody.list tr:not([class*="trOfProduct"]) td.pattern-code {
            order: 3 !important;
            flex: 0 0 auto !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            color: #6B7280 !important;
            margin-right: 4px !important;
        }

        #product_table tbody.list tr:not([class*="trOfProduct"]) td.pattern-code a {
            color: #6B7280 !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            text-decoration: none !important;
        }

        #product_table tbody.list tr:not([class*="trOfProduct"]) td.pattern-code::after {
            content: " • " !important;
            color: #94a3b8 !important;
            margin: 0 3px !important;
        }

        #product_table tbody.list tr:not([class*="trOfProduct"]) td.default-price {
            order: 4 !important;
            flex: 0 0 calc(100% - 180px) !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            color: #6B7280 !important;
            text-align: left !important;
        }

        /* ── Line 3: Product Status Badge (Active / Draft / Inactive) ── */
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.product-status {
            order: 5 !important;
            flex: 0 0 100% !important;
            width: 100% !important;
            margin-top: 6px !important;
            margin-bottom: 12px !important;
        }

        #product_table tbody.list tr:not([class*="trOfProduct"]) td.product-status span {
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            padding: 4px 10px !important;
            border-radius: 999px !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            line-height: 1.4 !important;
        }

        #product_table tbody.list tr:not([class*="trOfProduct"]) td.product-status span.text-success{
        /* #product_table tbody.list tr:not([class*="trOfProduct"]) td.product-status span:contains("Active") { */
            background-color: #e6f7f2 !important;
            color: #10b981 !important;
        }

        #product_table tbody.list tr:not([class*="trOfProduct"]) td.product-status span.text-success::before {
            content: "●" !important;
            font-size: 10px !important;
            color: #10b981 !important;
        }

        #product_table tbody.list tr:not([class*="trOfProduct"]) td.product-status span.text-danger {
            background-color: #fef3c7 !important;
            color: #d97706 !important;
        }

        #product_table tbody.list tr:not([class*="trOfProduct"]) td.product-status span.text-danger::before {
            content: "●" !important;
            font-size: 10px !important;
            color: #d97706 !important;
        }

        /* ── Line 4: Bottom Meta Row (SPORT, SUB PRODUCT, View Button) ── */
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.sport {
            order: 6 !important;
            flex: 0 0 auto !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            color: #6B7280 !important;
            text-transform: uppercase !important;
        }

        #product_table tbody.list tr:not([class*="trOfProduct"]) td.sport::before {
            content: "SPORT" !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            color: #6B7280 !important;
        }

        /* Sport pill (All, Lacrosse, etc.) */
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.sport {
            padding-right: 14px !important;
        }

        /* Styled pill for Sport */
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.sport {
            font-size: 0 !important; /* Hide unstyled text */
        }

        #product_table tbody.list tr:not([class*="trOfProduct"]) td.sport::before {
            content: "SPORT" !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            color: #6B7280 !important;
            margin-right: 8px !important;
        }

        #product_table tbody.list tr:not([class*="trOfProduct"]) td.sport::after {
            content: attr(data-sport-name) !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            color: #1F2933 !important;
            background-color: #f1f5f9 !important;
            border-radius: 8px !important;
            padding: 4px 10px !important;
            display: inline-block !important;
        }

        /* Row 1: SPORT takes the full line, long sport names wrap */
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.sport {
            flex: 0 0 100% !important;
            max-width: 100% !important;
            display: flex !important;
            align-items: flex-start !important;
            padding-right: 0 !important;
            margin-bottom: 5px !important;
        }

        /* "SPORT" label stays fixed, pill takes the rest and wraps */
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.sport::before {
            flex: 0 0 auto !important;
            margin-top: 4px !important;
        }

        #product_table tbody.list tr:not([class*="trOfProduct"]) td.sport::after {
            flex: 0 1 auto !important;
            min-width: 0 !important;
            max-width: 100% !important;
            white-space: normal !important;
            line-height: 1.4 !important;
        }

        /* Row 2: SUB PRODUCT (left) + View (right) */
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.gender {
            flex: 1 1 0 !important;
            min-width: 0 !important;
        }
        
        /* SUB PRODUCT count & View Button placed using gender / category cells */
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.gender {
            order: 7 !important;
            flex: 1 1 auto !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            font-size: 0 !important; /* Hide male/female */
        }

        #product_table tbody.list tr:not([class*="trOfProduct"]) td.gender::before {
            content: "SUB PRODUCT" !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            color: #6B7280 !important;
            margin-right: 4px !important;
        }

        #product_table tbody.list tr:not([class*="trOfProduct"]) td.gender::after {
            content: attr(data-sub-count) !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            color: #1F2933 !important;
        }

        /* View Button Pill on right */
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.product-category-id {
            order: 8 !important;
            flex: 0 0 auto !important;
            margin-left: auto !important;
            font-size: 0 !important;
            display: inline-flex !important;
            align-items: center !important;
        }

        #product_table tbody.list tr:not([class*="trOfProduct"]) td.product-category-id::after {
            content: "View" !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            color: #6B7280 !important;
            background: #ffffff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23475569' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z'></path><circle cx='12' cy='12' r='3'></circle></svg>") 10px center no-repeat !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 999px !important;
            padding: 5px 14px 5px 32px !important;
            display: inline-flex !important;
            align-items: center !important;
            cursor: pointer !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02) !important;
        }

        /* Hide other non-mobile columns on parent card */
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.main-category-id,
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.product-size,
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.standard-fabric,
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.fabric-options,
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.embellishment-options,
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.attributes,
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.weight,
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.factories,
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.description,
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.notes,
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.created-at,
        #product_table tbody.list tr:not([class*="trOfProduct"]) td.updated-at {
            display: none !important;
        }

        /* ── Sub-Product Cards (Cloned TRs: trOfProductX) ── */
        /* Hide collapseButton on sub-product card */
        #product_table tbody.list tr[class*="trOfProduct"] td.collapseButton {
            display: none !important;
        }

        /* 1. Sub-product Name */
        #product_table tbody.list tr[class*="trOfProduct"] .subproduct-card-inner td.product-name,
        #product_table tbody.list tr[class*="trOfProduct"] td.product-name {
            order: 1 !important;
            flex: 0 0 100% !important;
            max-width: 100% !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            line-height: 1.3 !important;
            margin-bottom: 4px !important;
        }

        #product_table tbody.list tr[class*="trOfProduct"] .subproduct-card-inner td.product-name a,
        #product_table tbody.list tr[class*="trOfProduct"] td.product-name a {
            color: #0f172a !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            text-decoration: none !important;
            white-space: break-spaces !important;
        }

        /* 2. Sub-product No, pattern code & price */
        #product_table tbody.list tr[class*="trOfProduct"] .subproduct-card-inner td.product-no,
        #product_table tbody.list tr[class*="trOfProduct"] td.product-no {
            order: 2 !important;
            flex: 0 0 auto !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            color: #6B7280 !important;
            margin-right: 3px !important;
            text-align: left !important;
        }

        #product_table tbody.list tr[class*="trOfProduct"] td.product-no::before {
            content: "No." !important;
        }

        #product_table tbody.list tr[class*="trOfProduct"] td.product-no::after {
            content: " • " !important;
            color: #94a3b8 !important;
            margin: 0 3px !important;
        }

        #product_table tbody.list tr[class*="trOfProduct"] .subproduct-card-inner td.pattern-code,
        #product_table tbody.list tr[class*="trOfProduct"] td.pattern-code {
            order: 3 !important;
            flex: 0 0 auto !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            color: #6B7280 !important;
            margin-right: 3px !important;
        }

        #product_table tbody.list tr[class*="trOfProduct"] td.pattern-code::after {
            content: " • " !important;
            color: #94a3b8 !important;
            margin: 0 3px !important;
        }

        #product_table tbody.list tr[class*="trOfProduct"] .subproduct-card-inner td.default-price,
        #product_table tbody.list tr[class*="trOfProduct"] td.default-price {
            order: 4 !important;
            flex: 0 0 auto !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            color: #6B7280 !important;
            text-align: left !important;
        }
        
        /* force line break after meta row */
        .subproduct-card-inner::after {
            content: "" !important;
            order: 5 !important;
            flex: 0 0 100% !important;
            height: 0 !important;
        }
        /* 3. Sub-product Status */
        #product_table tbody.list tr[class*="trOfProduct"] .subproduct-card-inner td.product-status,
        #product_table tbody.list tr[class*="trOfProduct"] td.product-status {
            order: 6 !important;
            flex: 0 0 auto !important;
            margin-top: 10px !important;
            margin-right: auto !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            padding: 4px 12px !important;
            border-radius: 999px !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            background-color: #e6f7f2 !important;
            color: #10b981 !important;
        }

        #product_table tbody.list tr[class*="trOfProduct"] td.product-status::before {
            content: "●" !important;
            font-size: 9px !important;
            color: #10b981 !important;
        }

        /* 4. Sub-product View button on the right */
        #product_table tbody.list tr[class*="trOfProduct"] .subproduct-card-inner td.product-category-id,
        #product_table tbody.list tr[class*="trOfProduct"] td.product-category-id {
            order: 7 !important;
            flex: 0 0 auto !important;
            margin-left: auto !important;
            margin-top: 8px !important;
            font-size: 0 !important;
            display: inline-flex !important;
            align-items: center !important;
        }

        #product_table tbody.list tr[class*="trOfProduct"] td.product-category-id::after {
            content: "View" !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            color: #6B7280 !important;
            background: #ffffff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%23475569' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z'></path><circle cx='12' cy='12' r='3'></circle></svg>") 8px center no-repeat !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 999px !important;
            padding: 4px 12px 4px 28px !important;
            display: inline-flex !important;
            align-items: center !important;
            cursor: pointer !important;
        }

        /* Hide unused columns in subproduct card */
        #product_table tbody.list tr[class*="trOfProduct"] td.sport,
        #product_table tbody.list tr[class*="trOfProduct"] td.gender,
        #product_table tbody.list tr[class*="trOfProduct"] td.main-category-id,
        #product_table tbody.list tr[class*="trOfProduct"] td.product-size,
        #product_table tbody.list tr[class*="trOfProduct"] td.standard-fabric,
        #product_table tbody.list tr[class*="trOfProduct"] td.fabric-options,
        #product_table tbody.list tr[class*="trOfProduct"] td.embellishment-options,
        #product_table tbody.list tr[class*="trOfProduct"] td.attributes,
        #product_table tbody.list tr[class*="trOfProduct"] td.weight,
        #product_table tbody.list tr[class*="trOfProduct"] td.factories,
        #product_table tbody.list tr[class*="trOfProduct"] td.description,
        #product_table tbody.list tr[class*="trOfProduct"] td.notes,
        #product_table tbody.list tr[class*="trOfProduct"] td.created-at,
        #product_table tbody.list tr[class*="trOfProduct"] td.updated-at {
            display: none !important;
        }

        /* ── Pagination ── */
        .dataTables_paginate {
            display: flex !important;
            justify-content: center !important;
            margin-top: 18px !important;
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
        /* Inactive / under construction sub-product status */
        #product_table tbody.list tr.is-inactive-sub td.product-status {
            background-color: #fef3c7 !important;
            color: #d97706 !important;
        }
        #product_table tbody.list tr.is-inactive-sub td.product-status::before {
            color: #d97706 !important;
        }
        /* Inactive / under construction sub-product status (light red) */
        #product_table tbody.list tr.is-inactive-sub td.product-status,
        #product_table tbody.list tr.is-inactive-sub .subproduct-card-inner td.product-status {
            background-color: #fee2e2 !important;
            color: #dc2626 !important;
        }
        #product_table tbody.list tr[class*="trOfProduct"].is-inactive-sub td.product-status::before,
        #product_table tbody.list tr[class*="trOfProduct"].is-inactive-sub .subproduct-card-inner td.product-status::before {
            color: #dc2626 !important;
        }
    }

</style>

{{-- {{dd($subProducts)}} --}}

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>PRODUCTS</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="row col-md-12 mb-2" style="padding: 0rem;">
        {{-- <div class="col-md-4 ml-auto text-right mt-3" style="padding-right: 2rem;">
            @if (Gate::check('add products'))
                <button class="btn-green-filled" id="add_product_btn" style="outline: unset;" onclick="creatingProducts()" title="Add New Product">
                    <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD PRODUCT
                </button>
             @endif
        </div> --}}
    </div>

    {{-- <div class="col-md-12 btn-top">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6 btns-right-position btn_set">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-3 btns-padding">
                        @if (Gate::check('add products'))
                            <button class="btns-text btns-style btns-card" id="add_product_btn" style="outline: unset;" href="#" data-toggle="modal" data-target="#product_create_modal" title="Add New Product">
                                Add Product
                            </button>
                        @endif
                    </div>
                    <div class="col-md-3 btns-padding">
                        @can('download product csv')

                        <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" id="display_csv" data-href="{{ route('products.export_csv') }}" onclick="exportTasks(this);" title="Display CSV">
                            Export
                        </button>
                    </div>
                    <div class="col-md-3 btns-padding">
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
                            <h1 class="float-left header-title">Products</h1>
                        </div>
                        <div class="col-md-6 header-icons justify-content-end">
                            @if (Gate::check('add products'))
                             <span>
                                 <a class="btn btn-round" href="#" data-toggle="modal" data-target="#product_create_modal">
                                     <i class="fas fa-plus"></i>
                                 </a>
                                 <p>Add Products</p>
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
                {{-- Product Table  --}}
                <div class="col-md-9 row mt-3 mb-3 ml-auto">
                    <div class="col-md-10 ml-auto" style="padding-right: 0px;">
                        <table class="btn-inside-table" style="width: 100%">
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox" style="width: 12rem;">
                                        <input class="custom-control-input" id="inactive_show" type="checkbox">
                                        <label class="custom-control-label" for="inactive_show">Show inactive products</label>
                                    </div>
                                </td>
                                <td>
                                    @can('download product csv')
                                    <button class="styled-button" style="outline: unset;" href="#" id="display_csv" data-href="{{ route('products.export_csv') }}" onclick="exportTasks(this);" title="Display CSV">
                                        Export
                                    </button>
                                    @endcan
                                </td>
                                <td>
                                    <button class="styled-button" style="outline: unset;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                                        Table Layout
                                    </button>
                                </td>
                                <td style="width: 20%;">
                                    @if (Gate::check('add products'))
                                        <button class="btn-green-filled" id="add_product_btn" style="outline: unset;" onclick="creatingProducts()" title="Add New Product">
                                            <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD PRODUCT
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    {{-- <div class="col-md-3 text-right" style="padding-right: 0rem;">
                        @can('download product csv')

                        <button class="styled-button" style="outline: unset;" href="#" id="display_csv" data-href="{{ route('products.export_csv') }}" onclick="exportTasks(this);" title="Display CSV">
                            Export
                        </button>
                        @endcan
                    </div>
                    <div class="col-md-2 text-right" style="padding-right: 0rem;padding-left: 0rem;">
                        <button class="styled-button" style="outline: unset;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                            Table Layout
                        </button>
                    </div> --}}
                </div>
                <div class="col-md-12 new-style-table mb-3" style="padding: 0rem;">
                    <div>
                        <table class="table align-items-center table-responsive" id="product_table">
                            <thead>
                                <th style="color: grey"></th>
                                <th scope="col" class="product-no">Product No</th>
                                <th scope="col" class="product-name">Product Name</th>
                                <th scope="col" class="pattern-code">Pattern Code</th>
                                <th scope="col" class="sport">Sport</th>
                                <th scope="col" class="gender">Gender</th>
                                <th scope="col" class="default-price">Default Price ($)</th>
                                <th scope="col" class="product-category-id">Product Style</th>
                                <th scope="col" class="main-category-id">Product Category</th>
                                <th scope="col" class="product-status">Product Status</th>

                                <th scope="col" class="product-size">Product Size</th>
                                <th scope="col" class="standard-fabric">Standard Fabric</th>
                                <th scope="col" class="fabric-options">Fabric Options</th>
                                <th scope="col" class="embellishment-options">Embellishment Options</th>
                                <th scope="col" class="attributes">Attributes</th>
                                <th scope="col" class="weight">Weight</th>
                                <th scope="col" class="factories">Factories</th>

                                <th scope="col" class="description">Description</th>
                                <th scope="col" class="notes">Notes</th>
                                <th scope="col" class="created-at">Created At</th>
                                <th scope="col" class="updated-at">Updated At</th>
                            </thead>

                            <tbody class="list">
                                @foreach ($products as $product)
                                    @php
                                        $subProductsUnique = [];
                                    @endphp
                                    @foreach ($subProducts as $subProduct)
                                        @if ($subProduct->parent_product_id == $product->id)
                                            @php
                                                $subProductsUnique[] = $subProduct;
                                            @endphp
                                        @endif
                                    @endforeach
                                    @php
                                        $subProductsUniqueJSON = json_encode($subProductsUnique);
                                    @endphp
                                    <tr>
                                        <td class="collapseButton">@if(count($subProductsUnique) > 0)<i class="fa fa-chevron-right" id="charvonIconStyle" onclick="toggleIcon(this); CollapseButtonClicks(this, {{$product->id}}, {{$subProductsUniqueJSON}})" aria-hidden="true" title="Show sub products"></i>@endif</td>
                                        <td class="product-no text-center" style="cursor: pointer;">
                                             <a href="{{ route('edit_product', ['id' => $product->id]) }}" style="font-weight: 600 !important" >
                                                {{$product->id}}
                                            </a>
                                        </td>
                                        <td class="product-name"><a href="{{ route('edit_product', ['id' => $product->id]) }}">{{$product->product_name}}</a></td>
                                        <td class="pattern-code"><a href="{{ route('edit_product', ['id' => $product->id]) }}">{{$product->pattern_code}}</a></td>
                                        <td class="sport">
                                            @php
                                                $sportNames = [];
                                            @endphp

                                            @foreach ($productSports as $productSport)
                                                @if ($product->id == $productSport->product_id)
                                                    @foreach ($sports as $sport)
                                                        @if ($productSport->sport_id == $sport->id)
                                                            @php
                                                                $sportNames[] = $sport->sport_name;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach

                                            @if (count($sportNames) > 0)
                                                {{ implode(", ", $sportNames) }}
                                            @else
                                                {{ $product->sport }}
                                            @endif

                                        </td>
                                        <!-- <td class="gender">{{$product->gender}}</td> -->
                                        <td class="gender" data-sub-count="{{ count($subProductsUnique) }}">{{$product->gender}}</td>
                                        <td class="default-price text-right">$ {{$product->default_price}}</td>
                                        <td class="product-category-id">
                                            @php
                                                $itemNames = [];
                                            @endphp
                                            @foreach($product->productCategories as $productCategorielist)
                                                @foreach($productCategorielist->categories as $categorie)
                                                    @php
                                                        $itemNames[] = $categorie->product_category_name;
                                                    @endphp
                                                @endforeach
                                            @endforeach
                                            {{ implode(", ", $itemNames) }}
                                        </td>
                                        <td class="main-category-id">
                                            @php
                                                $multipleMainCategory = [];
                                            @endphp
                                            @foreach ($multipleProductCategories as $multipleProductCategory)
                                                @if ($multipleProductCategory->product_id == $product->id)
                                                    @foreach ($mainCategories as $mainCategory)
                                                    @if ($multipleProductCategory->main_category_id == $mainCategory->id)
                                                        @php
                                                            $multipleMainCategory[] = $mainCategory->category_name;
                                                        @endphp
                                                    @endif
                                                    @endforeach
                                                @endif
                                            @endforeach

                                            @if (empty($multipleMainCategory))
                                                @foreach ($mainCategories as $mainCategorie)
                                                    @if ($product->main_category_id == $mainCategorie->id)
                                                        {{ $mainCategorie->category_name }}
                                                    @endif
                                                @endforeach
                                            @else
                                                {{ implode(", ", $multipleMainCategory) }}
                                            @endif

                                        </td>
                                        <td class="product-status">
                                            @if($product->active==1)
                                                <span class="text-success">Active</span>
                                            @elseif($product->active==3)
                                                <span class="text-danger">Under Construction</span>
                                            @elseif ($product->active==4)
                                                <span class="text-danger">Inactive</span>
                                            @endif
                                        </td>

                                        <td class="product-size">
                                            @foreach ($sizeTypes as $sizeType)
                                                @if ($product->size_id == $sizeType->id)
                                                    {{ $sizeType->type_name }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="standard-fabric">{{($product->productFabric != null)? $product->productFabric->fabric_name:''}}</td>
                                        <td class="fabric-options">
                                            @php
                                                $fabricNames = [];
                                            @endphp
                                            @foreach($product->productFabrics as $productFabric)
                                                @foreach($productFabric->fabrics as $fabric)
                                                    @php
                                                        $fabricNames[] = $fabric->fabric_name;
                                                    @endphp
                                                @endforeach
                                            @endforeach
                                            {{ implode(", ", $fabricNames) }}
                                        </td>
                                        <td class="embellishment-options">
                                            @php
                                                $embellishmentNames = [];
                                            @endphp
                                            @foreach($product->productEmbellishmentTypes as $productEmbellishmentType)
                                                @foreach($productEmbellishmentType->embellishmentTypes as $embellishmentType)
                                                    @php
                                                        $embellishmentNames[] = $embellishmentType->embellishment_name;
                                                    @endphp
                                                @endforeach
                                            @endforeach
                                            {{ implode(", ", $embellishmentNames) }}
                                        </td>
                                        <td class="attributes">
                                            @php
                                                $attributeNames = [];
                                            @endphp
                                            @foreach($product->productAttributes as $productAttribute)
                                                @foreach($productAttribute->attributes as $attribute)
                                                    @php
                                                        $attributeNames[] = $attribute->attribute_name;
                                                    @endphp

                                                @endforeach
                                            @endforeach
                                            {{ implode(", ", $attributeNames) }}
                                        </td>
                                        <td class="weight">{{$product->weight}}</td>
                                        <td class="factories">
                                            @php
                                                $factoryCode = [];
                                            @endphp
                                            @foreach($product->productFactories as $productFactory)
                                                @foreach($productFactory->factories as $factory)
                                                    @php
                                                        $factoryCode[] = $factory->factory_code;
                                                    @endphp
                                                @endforeach
                                            @endforeach
                                            {{ implode(", ", $factoryCode) }}
                                        </td>

                                        <td class="description">{{$product->description}}</td>
                                        <td class="notes">{{$product->notes}}</td>
                                        <td class="created-at">{{$product->created_at->format('m-d-Y')}}</td>
                                        <td class="updated-at">{{$product->updated_at->format('m-d-Y')}}</td>
                                    </tr>
                                    {{-- @foreach ($subProductsUnique as $subProductUnique)
                                            <tr id="collapsingTR{{$product->id}}">
                                                <td style="color: grey"></td>
                                                <td class="product-no text-center">{{$subProductUnique->sub_product_no}}</td>
                                                <td class="product-name">{{$subProductUnique->product_name}}</td>
                                                <td class="pattern-code">{{$subProductUnique->pattern_code}}</td>
                                                <td class="sport"></td>
                                                <td class="gender"></td>
                                                <td class="default-price">{{$subProductUnique->default_price}}</td>
                                                <td class="product-category-id"></td>
                                                <td class="main-category-id">/td>
                                                <td class="product-status">Active</td>

                                                <td class="product-size"></td>
                                                <td class="standard-fabric">{{$subProductUnique->standard_fabric}}</td>
                                                <td class="fabric-options">{{$subProductUnique->fabric_options}}</td>
                                                <td class="embellishment-options">{{$subProductUnique->type_of_embellishment}}</td>
                                                <td class="attributes"></td>
                                                <td class="weight">{{$subProductUnique->weight}}</td>
                                                <td class="factories"></td>

                                                <td class="description">{{$subProductUnique->description}}</td>
                                                <td class="notes">{{$subProductUnique->notes}}</td>
                                                <td class="created-at">{{$subProductUnique->created_at}}</td>
                                                <td class="updated-at">{{$subProductUnique->updated_at}}</td>
                                            </tr>
                                    @endforeach --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>

@include('pages.masters.products.create')
{{-- @include('pages.masters.products.edit') --}}

{{-- Products Fields & Layouts --}}
<div class="modal fade" id="layout_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Products Fields &amp; Layouts</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">

                        <input type="hidden" id="layout_id" name="layout_id" value="{{$productLayout['id'] ?? ''}}" />
                        <input type="hidden" id="column_layout_id" name="column_layout_id" value="{{$columnLayout['id'] ?? 0}}" />

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="product_no" name="product_no" title="Product No"
                                    @if ($productLayout != null && $productLayout['product_no'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="product_no">Product No</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="product_name" name="product_name" title="Product Name"
                                    @if ($productLayout != null && $productLayout['product_name'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="product_name">Product Name</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="product_category_id" name="product_category_id" title="Product Style"
                                    @if ($productLayout != null && $productLayout['product_category_id'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="product_category_id">Product Style</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="main_category_id" name="main_category_id" title="Product Category"
                                    @if ($productLayout != null && $productLayout['main_category_id'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="main_category_id">Product Category</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="sport" name="sport" title="Sport"
                                    @if ($productLayout != null && $productLayout['sport'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="sport">Sport</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="gender" name="gender" title="Gender"
                                    @if ($productLayout != null && $productLayout['gender'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="gender">Gender</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="default_price" name="default_price" title="Default Price"
                                    @if ($productLayout != null && $productLayout['default_price'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="default_price">Default Price</label>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="pattern_code" name="pattern_code" title="Pattern Code"
                                    @if ($productLayout != null && $productLayout['pattern_code'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="pattern_code">Pattern Code</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="product_size" name="product_size" title="Product Size"
                                    @if ($productLayout != null && $productLayout['product_size'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="product_size">Product Size</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="standard_fabric" name="standard_fabric" title="Standard Fabric"
                                    @if ($productLayout != null && $productLayout['standard_fabric'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="standard_fabric">Standard Fabric</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="fabric_options" name="fabric_options" title="Fabric Options"
                                    @if ($productLayout != null && $productLayout['fabric_options'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="fabric_options">Fabric Options</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="embellishment_options" name="embellishment_options" title="Embellishment Options"
                                    @if ($productLayout != null && $productLayout['embellishment_options'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="embellishment_options">Embellishment Options</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="attributes" name="attributes" title="Attributes"
                                    @if ($productLayout != null && $productLayout['attributes'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="attributes">Attributes</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="weight" name="weight" title="Weight"
                                    @if ($productLayout != null && $productLayout['weight'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="weight">Weight</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="factories" name="factories" title="Factories"
                                    @if ($productLayout != null && $productLayout['factories'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="factories">Factories</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="status" name="status" title="Status"
                                    @if ($productLayout != null && $productLayout['status'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="status">Status</label>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="description" name="description" title="Description"
                                    @if ($productLayout != null && $productLayout['description'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="description">Description</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="notes" name="notes" title="Notes"
                                    @if ($productLayout != null && $productLayout['notes'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="notes">Notes</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="created_at" name="created_at" title="Created At"
                                    @if ($productLayout != null && $productLayout['created'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="created_at">Created At</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="updated_at" name="updated_at" title="Updated At"
                                    @if ($productLayout != null && $productLayout['updated'] == 1) checked @endif
                                />
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function CollapseButtonClicks(button, productID, subProductsUnique) {
        var $row = $(event.target).closest('tr');
        $row.css('background-color', 'rgb(238 238 238)');

        // subProductsUnique.sort(function(a, b) {
        //     return b.id - a.id;
        // });
        if (window.innerWidth <= 768) {
            // Mobile: active first, then inactive. Inside each group, newest first.
            subProductsUnique.sort(function(a, b) {
                var aActive = (a.active == 1) ? 0 : 1;
                var bActive = (b.active == 1) ? 0 : 1;

                if (aActive !== bActive) {
                    return aActive - bActive;
                }
                return b.id - a.id;
            });
        } else {
            // Desktop: original order
            subProductsUnique.sort(function(a, b) {
                return b.id - a.id;
            });
        }

        var active_checkbox = document.getElementById("inactive_show");
        var isMobileView = window.innerWidth <= 768;

        // Mobile: always show inactive sub products. Desktop: follow the checkbox.
        if (!isMobileView && !active_checkbox.checked) {
            subProductsUnique = subProductsUnique.filter(function(subProduct) {
                return subProduct.active == 1;
            });
        }

        // if (active_checkbox.checked) {
        // } else {
        //     subProductsUnique = subProductsUnique.filter(function(subProduct) {
        //         return subProduct.active == 1;
        //     });
        // }


        if($('.trOfProduct' + productID).length > 0){
            $('.trOfProduct' + productID).each(function() {
                $(this).remove();
            });
            $row.css('background-color', 'rgb(255 255 255)');
        }else{
            var isMobileList = window.innerWidth <= 768;

            for (var n = 0; n < subProductsUnique.length; n++) {
                // Mobile: walk backwards so the first item in the sorted list ends up on top
                var i = isMobileList ? (subProductsUnique.length - 1 - n) : n;
            // for (var i = 0; i < subProductsUnique.length; i++) {
                var $clone = $row.clone();
                $clone.removeAttr('id').css('display', 'table-row');

                $clone.removeClass();
                $clone.addClass('trOfProduct'+productID);
                if (subProductsUnique[i].active != 1) {
                    $clone.addClass('is-inactive-sub');
                }
                $clone.css('color', (subProductsUnique[i].active == 1 ? '#b3b3b3' : '#ff9292') + ' !important');
                $clone.css('background-color', 'rgb(255 255 255)');

                var editedUrl = "{{ route('sub_products.edit', ':subProductNo') }}".replace(':subProductNo', subProductsUnique[i].sub_product_no);

                $clone.find('.collapseButton').text('');
                $clone.find('.product-no').removeClass('text-center').text(subProductsUnique[i].sub_product_no.substring(4)).css('text-align', 'right');
                $clone.find('.product-name').html('<a href="' + editedUrl + '" style="color:' + (subProductsUnique[i].active == 1 ? '#b3b3b3 !important' : '#ff9292 !important') + '">' + subProductsUnique[i].product_name + '</a>');
                $clone.find('.pattern-code').text(subProductsUnique[i].pattern_code);
                $clone.find('.default-price').text('$ '+subProductsUnique[i].default_price);
                $clone.find('.product-status').text(function() {
                    var status = subProductsUnique[i].active;

                    if (status == 1) {
                        return "Active";
                    } else if (status == 3) {
                        return "Under Construction";
                    } else if (status == 0) {
                        return "Inactive";
                    } else if (status == 0 || status == 4) {
                        return "Inactive";
                    } else {
                        return "Unknown Status";
                    }
                });

                var embText = '';

                if (subProductsUnique[i].embellishment_types && subProductsUnique[i].embellishment_types.length > 0) {
                    for (var j = 0; j < subProductsUnique[i].embellishment_types.length; j++) {
                        embText += subProductsUnique[i].embellishment_types[j].embellishment_details.embellishment_name;
                        if (j !== subProductsUnique[i].embellishment_types.length - 1) {
                            embText += ", ";
                        }
                    }
                } else {
                    embText = '';
                }

                $clone.find('.standard-fabric').text(subProductsUnique[i].standard_fabric);
                $clone.find('.fabric-options').text(subProductsUnique[i].fabric_options);
                $clone.find('.embellishment-options').text(embText);
                $clone.find('.weight').text(subProductsUnique[i].weight);
                $clone.find('.description').text(subProductsUnique[i].description);
                $clone.find('.notes').text(subProductsUnique[i].notes);
                $clone.find('.created-at').text(new Date(subProductsUnique[i].created_at).toLocaleDateString('en-US'));
                $clone.find('.updated-at').text(new Date(subProductsUnique[i].updated_at).toLocaleDateString('en-US'));


                $row.after($clone);
            }
        }
    }
    function toggleIcon(iconElement) {
        if (iconElement.classList.contains('fa-chevron-right')) {
            iconElement.classList.remove('fa-chevron-right');
            iconElement.classList.add('fa-chevron-down');
        } else {
            iconElement.classList.remove('fa-chevron-down');
            iconElement.classList.add('fa-chevron-right');
        }
    }

    function creatingProducts(){
        Swal.fire({
            title: 'What product to create ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'MAIN PRODUCT',
            cancelButtonText: 'SUB PRODUCT',
            confirmButtonColor: 'rgb(107 205 242)',
            cancelButtonColor: 'rgb(51 221 208)',
        }).then((result) => {

            if (result.value) {

                window.location = "{{ route('edit_product',':id') }}".replace(':id', null)

            } else {
                window.location = "{{ route('sub_products.index',':id') }}".replace(':id', null)
            }
        });
    }

</script>

<script>

$(".se-pre-con").fadeOut('slow');

    function exportTasks(_this) {
        let _url = $(_this).data('href');

        $.get(_url, function(response) {
            // Display the CSV content in a div
            $('#csvData').html(response);

            // Create a temporary link and trigger a download
            let link = document.createElement('a');
            link.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(response);
            link.download = 'products.csv';
            link.style.display = 'none';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    }

    $(document).ready(function() {
    $(".edit").click(function() {
        var productId = $(this).data("value");
        var newProductNo = "PRO - " + productId;

        $(".visible-input").val(newProductNo);
    });
    });

    $(document).ready(function() {
    // Store the original value when the page loads
    var originalValue = $("#product_number_input").val();

    $("#add_product_btn").click(function() {
        // Assign the original value back to the input field
        $("#product_number_input").val(originalValue);
    });
    });


    var searchIdx = '';
    var productNo = '{{$productNo}}';

    $(document).ready(function () {

        $('select').select2();
        $('.select2-create').select2({
            dropdownParent: $('#product_create_modal')
        });
        $('.select2-edit').select2({
            dropdownParent: $('#product_edit_modal')
        });

        // Products Table Layout
        tableLayout();

        let exactMatchFound = false;

        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            let input = $('#product_table_filter input').val().toLowerCase().trim();

            if (!input) return true;

            let row = $('#product_table').DataTable().row(dataIndex).node();
            let $row = $(row);

            let productNo = $row.find('td.product-no').text().toLowerCase().trim();
            let productName = $row.find('td.product-name').text().toLowerCase().trim();
            let patternCode = $row.find('td.pattern-code').text().toLowerCase().trim();

            if (exactMatchFound) {
                return productNo === input;
            }

            return productName.includes(input) || patternCode === input;
        });

        var productTable = $('#product_table').DataTable({
        colReorder: true,
        stateSave: true,
        autoWidth: false,
        pageLength: 50,
        language: {
            search: '<i class="fas fa-search"></i>',
            searchPlaceholder: 'Search'
        },
        columnDefs: [
            {
                searchable: false,
                targets: [
                    "product-no",
                    "sport",
                    "gender",
                    "default-price",
                    "product-category-id",
                    "main-category-id",
                    "product-status",
                    "description",
                    "notes",
                    "created-at",
                    "updated-at"
                ]
            }
        ],
        initComplete: function () {
            let table = this.api();

            $('#product_table_filter input')
                .off()
                .on('keyup change', function () {
                    let input = this.value.toLowerCase().trim();
                    exactMatchFound = false;

                    table.rows().every(function () {
                        let row = $(this.node());
                        let productNo = row.find('td.product-no').text().toLowerCase().trim();
                        if (productNo === input) {
                            exactMatchFound = true;
                            return false;
                        }
                    });

                    table.draw();
                });
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

        alphabet.insertBefore( productTable.table().container() );

        alphabet.on('click', 'span', function () {
            alphabet.find( '.active' ).removeClass( 'active' );
            $(this).addClass( 'active' );

            _alphabetSearch = $(this).data('letter');
            productTable.draw(_alphabetSearch);
        });

        // save column order when move
        productTable.on('column-reorder', function (e, settings, details) {
            var columnStr = localStorage.getItem("DataTables_product_table_/products");
            var columnObj = JSON.parse(columnStr);
            var colReorder = new $.fn.dataTable.ColReorder( productTable );
            var curr = colReorder.fnOrder();
            var column_order = JSON.stringify(curr);
            var interface_name = 'Product';
            var interface_id = 5;
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
            var columnStr = localStorage.getItem("DataTables_product_table_/products");
            var columnObj = JSON.parse(columnStr);
            var column_order = JSON.stringify(columnObj.ColReorder);
            var interface_name = 'Product';
            var interface_id = 5;
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
            var interfaceId = 5;
            $.ajax({
                url: '{{ url("datatable/get_column_order") }}/'+interfaceId,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    console.log(data.column_order);
                    var columnStr = localStorage.getItem("DataTables_product_table_/products");
                    var columnObj = JSON.parse(columnStr);
                    columnObj.ColReorder = JSON.parse(data.column_order);

                    localStorage.setItem('DataTables_product_table_/products', JSON.stringify(columnObj));
                },
                complete: function() {
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        }

        // Products Edit
        // $("body").on("click", ".edit", function(){
        //     var productId = $(this).data('value');
        //     $('#product_id').val(productId);
        //     $('#product_edit_modal').modal('show');
        // });

        $('#add_product_btn').on('click', function () {
            reset();
            $('#new_product_no').val(productNo);
        });

        $('body').on('click', 'close', function () {
            reset();
        });

        $("body").on("click", ".edit", function(){
            reset();

            $('#modal-title-create').text('EDIT PRODUCT');
            $('.frm_submit_btn').text('Update');

            var productId = $(this).data('value');
            $('#new_product_id').val(productId);

            $.ajax({
                url: '{{url("products/edit")}}/'+productId,
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function(data){
                    var product = data[0];
                    var productFabric = data[1];
                    var productEmbellishmentType = data[2];
                    var productCategory =  data[3];
                    var productAttributes =  data[4];
                    var productFactories =  data[5];
                    var productSports =  data[6];
                    var productImages =  data[7];
                    var productSport  = product.sport;
                    var productImagesList  = data[8];
                    var prices  = data[9];
                    var mainCategories  = data[10];
                    console.log('category data :'+mainCategories);


                    for(var j = 0; j<prices.length; j++){
                        var productPrice = prices[j];

                        var priceType = productPrice.price_type;
                        var priceAmount = productPrice.price;

                        if (priceType == 2) {
                            $('#price_type_2').val(priceType).change();
                            $('#new_default_price2').val(priceAmount);
                        } else if (priceType == 3) {
                            $('#price_type_3').val(priceType).change();
                            $('#new_default_price3').val(priceAmount);
                        } else if (priceType == 4) {
                            $('#price_type_4').val(priceType).change();
                            $('#new_default_price4').val(priceAmount);
                        } else if (priceType == 5){
                            $('#price_type_5').val(priceType).change();
                            $('#new_default_price5').val(priceAmount);
                        }

                    }

                    var img3D ="";
                    var imgLifestyle ="";
                    for (var i = 0; i < productImagesList.length; i++) {
                        var productImage = productImagesList[i];

                        // Access and display specific values
                        var imageName = productImage.image_name;
                        var imageType = productImage.image_type;
                        var imageLink = productImage.image_link;

                        // Display the values
                        console.log("Image Name: " + imageName);
                        console.log("Image Path: " + imageType);

                        if (imageType == 1) {
                            var img3D = img3D +'<a href="'+imageLink+'" target="_blank"><i class="fas fa-eye"></i></a>  ' + imageName+ "<br/>";
                            $('#uploaded-3d-images').html(img3D);
                            $('#thumbnail_3d_img').attr('src', imageLink);
                        } else {
                            var imgLifestyle = imgLifestyle +'<a href="'+imageLink+'" target="_blank"><i class="fas fa-eye"></i></a>  ' + imageName+ "<br/>";
                            $('#uploaded-lifeStyle-images').html(imgLifestyle);
                            $('#thumbnail_lifeStyle').attr('src', imageLink);
                        }

                    }

                    var combinedData = "";

                    if (product.sport) {
                        $('#new_sport option').prop('selected', false);

                        $('#new_sport option').each(function() {
                            var optionText = $(this).text();

                            if (optionText === productSport) {
                                $(this).prop('selected', true);
                            }
                        });

                        $('#new_sport').trigger('change');
                    }

                    if (productSports && productSports.length > 0) {
                        combinedData = productSports;

                        $('#new_sport option').each(function() {
                            var optionValue = $(this).val();

                            if (combinedData.includes(optionValue)) {
                                $(this).prop('selected', true);
                            }
                        });

                        $('#new_sport').trigger('change');
                    }

                    // var productCategory = JSON.parse(product.product_category_id);
                    // var quill = new Quill('#editor-container', {
                    //     theme: 'snow'
                    // });
                    quill.root.innerHTML = product.description;
                    $('#new_product_name').val(product.product_name);
                    $('#new_product_no').val(product.product_no);
                    if(product.fits_true_to_size !== null){$('#fitsSizes'+product.fits_true_to_size).prop('checked', true)};
                    $('#productNumberHead').text(" | " + product.product_no);
                    $('#new_pattern_code').val(product.pattern_code);
                    // $('#new_sport').val(combinedData).trigger('change');
                    $('#new_gender').val(product.gender).change();
                    $('#new_default_price').val(product.default_price);
                    $('#new_product_category_id').val(productCategory).trigger('change');
                    $('#new_size_id').val(product.size_id).change();
                    $('#new_standard_fabric_id').val(product.fabric_id).change();
                    $('#new_fabric_id').val(productFabric).trigger('change');
                    $('#new_embellishment_type_id').val(productEmbellishmentType).trigger('change');
                    $('#new_product_attribute_id').val(productAttributes).trigger('change');
                    $('#new_main_category_id').val(mainCategories).trigger('change');
                    $('#new_weight').val(product.weight);
                    $('#new_product_factory_id').val(productFactories).trigger('change');
                    $('#new_description').val(product.description);
                    $('#new_notes').val(product.notes);
                    $('#new_product_reference_link').val(product.product_reference_link);
                    $('#active').val(product.active).trigger('change');

                    // $('#new_main_category_id').val(product.main_category_id).trigger('change');

                    if(productImages.mockup_front_name){
                        $("#mockup-front").text(productImages.mockup_front_name.name);
                        slideshowImages.push(product.mockup_img_1);
                        $('#thumbnail_front').attr('data-image', product.mockup_img_1);
                        document.getElementById("thumbnail_front_img").src = product.mockup_img_1;
                        document.getElementById("slide_image").src = product.mockup_img_1;
                    }
                    if(productImages.mockup_side_name){
                        $("#mockup-side").text(productImages.mockup_side_name.name);
                        slideshowImages.push(product.mockup_img_2);
                        $('#thumbnail_side').attr('data-image', product.mockup_img_2);
                        document.getElementById("thumbnail_side_img").src = product.mockup_img_2;
                    }
                    if(productImages.mockup_back_name){
                        $("#mockup-back").text(productImages.mockup_back_name.name);
                        slideshowImages.push(product.mockup_img_3);
                        $('#thumbnail_back').attr('data-image', product.mockup_img_3);
                        document.getElementById("thumbnail_back_img").src = product.mockup_img_3;
                    }

                    if(productImages['2D_mockup']){
                        $("#2D-mockup").text(productImages['2D_mockup'].name);
                    }
                    if(productImages['3D_mockup']){
                        $("#3D-mockup").text(productImages['3D_mockup'].name);
                    }
                    if(productImages['tech_pack']){
                        $("#tech-pack").text(productImages.tech_pack.name);
                    }
                    if(productImages['measurement']){
                        $("#measurement").text(productImages.measurement.name);
                    }
                    if(productImages['product_layout']){
                        $("#product-layout").text(productImages.product_layout.name);
                    }
                    if(productImages['pattern']){
                        $("#pattern").text(productImages.pattern.name);
                    }
                    if(productImages['technical_tech_pack']){
                        $("#technical-techPack").text(productImages.technical_tech_pack.name);
                    }

console.log(productImages);
                    $("#downloadLink2D").attr('href', product['2D_mockup']);
                    $("#downloadLink3D").attr('href', product['3D_mockup']);
                    $("#downloadLinkTech").attr('href', product.tech_pack);
                    $("#downloadLinkchart").attr('href', product.measurement);
                    $("#downloadLinklayout").attr('href', product.product_layout);
                    $("#downloadLinkPattern").attr('href', product.pattern);
                    $("#downloadLinkTechnicalTechPack").attr('href', product.technical_tech_pack);
                    @can('delete products')
                    if ($('.delete').length === 0) {
                    // Create delete button using JavaScript
                    var deleteButton = document.createElement('button');
                    deleteButton.className = 'delete btn-danger btn-custom frm_delete_btn btn';
                    deleteButton.setAttribute('data-value', productId);
                    deleteButton.textContent = 'Delete';

                    // Get the update button and insert the delete button after it
                    var updateButton = document.querySelector('.frm_submit_btn');
                    updateButton.parentNode.insertBefore(deleteButton, updateButton.nextSibling);
                    }
                    @endcan
                    $('#product_create_modal').modal('show');
                },
                complete: function() {
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        });

        $("body").on("click", ".delete", function(e){
    e.preventDefault(); // Prevent the default click behavior

    var productId = $(this).data('value');

    // Show a confirmation popup using SweetAlert2
    if (confirm("Are you sure you want to delete this product?")) {
            // User confirmed, send an AJAX request to delete the product
            $.ajax({
                url: '{{url("products/delete")}}/'+productId,
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function(data){
                    if (data.success) {
                        // Product deletion successful, display success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.success,
                            showConfirmButton: false,
                            timer: 3000
                        }).then(function() {
                            // Reload the current page
                            location.reload();
                        });
                    } else {
                        // Product deletion failed, display the error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.error
                        });
                    }
                },

                complete: function() {
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        }

});



//         // Delete button functionality
//         $("body").on("click", ".delete", function(){
//     var productId = $(this).data('value');

//     // Show a confirmation dialog before deleting the product
//     if (confirm("Are you sure you want to delete this product?")) {
//         // Send an AJAX request to update the active column
//         $.ajax({
//             url: '{{url("products/delete")}}/'+productId,
//             type: 'GET',
//             dataType: 'json',
//             beforeSend: function () {
//                 $(".se-pre-con").fadeIn('slow');
//             },
//             success: function(data){
//                 if (data.delete) {
//                     // Product deletion successful, display success message
//                     Swal.fire({
//                         icon: 'delete',
//                         title: 'Success',
//                         text: data.delete,
//                         showConfirmButton: false,
//                         timer: 3000
//                     }).then(function() {
//                         // Reload the current page
//                         location.reload();
//                     });
//                 } else {
//                     // Product deletion failed, display the error message
//                     Swal.fire({
//                         icon: 'error',
//                         title: 'Error',
//                         text: data.error
//                     });
//                 }
//             },
//             complete: function() {
//                 $(".se-pre-con").fadeOut('slow');
//             }
//         });
//     }
// });



        $('#product_no').on('change', function(){ tableLayout(); });
        $('#product_name').on('change', function(){ tableLayout(); });
        $('#product_category_id').on('change', function(){ tableLayout(); });
        $('#main_category_id').on('change', function(){ tableLayout(); });
        $('#sport').on('change', function(){ tableLayout(); });
        $('#gender').on('change', function(){ tableLayout(); });
        $('#default_price').on('change', function(){ tableLayout(); });

        $('#pattern_code').on('change', function(){ tableLayout(); });
        $('#product_size').on('change', function(){ tableLayout(); });
        $('#standard_fabric').on('change', function(){ tableLayout(); });
        $('#fabric_options').on('change', function(){ tableLayout(); });
        $('#embellishment_options').on('change', function(){ tableLayout(); });
        $('#attributes').on('change', function(){ tableLayout(); });
        $('#weight').on('change', function(){ tableLayout(); });
        $('#factories').on('change', function(){ tableLayout(); });
        $('#status').on('change', function(){ tableLayout(); });

        $('#description').on('change', function(){ tableLayout(); });
        $('#notes').on('change', function(){ tableLayout(); });
        $('#created_at').on('change', function(){ tableLayout(); });
        $('#updated_at').on('change', function(){ tableLayout(); });
    });

    function reset(){
        $('#modal-title-create').text('ADD NEW PRODUCT');
        $('.frm_submit_btn').text('Save');

        $('#new_product_id').val('');
        $('#new_product_name').val('');
        $('#new_pattern_code').val('');
        $('#new_sport').val('').change();
        $('#new_gender').val('').change();
        $('#new_default_price').val('');
        $('#new_product_category_id').val('').trigger('change');
        $('#new_main_category_id').val('').trigger('change');
        $('#new_size_id').val('').change();
        $('#new_standard_fabric_id').val('').change();
        $('#new_fabric_id').val('').trigger('change');
        $('#new_embellishment_type_id').val('').trigger('change');
        $('#new_product_attribute_id').val('').trigger('change');
        $('#new_weight').val('');
        $('#new_product_factory_id').val('').trigger('change');
        $('#new_description').val('');
        $('#new_notes').val('');
        $('#new_product_reference_link').val('');
        $('#active').val('').trigger('change');

        $("#mockup-front").text('');
        $("#mockup-side").text('');
        $("#mockup-back").text('');
        $("#2D-mockup").text('');
        $("#3D-mockup").text('');
        $("#tech-pack").text('');
        $("#measurement").text('');
        $("#product-layout").text('');
        $("#pattern").text('');
        $("#technical-techPack").text('');
        $("#uploaded-images-container").text('');

        // upload buttons
        $('#2D-mockup-upload').hide();
        $('#3D-mockup-upload').hide();
        $('#tech-pack-upload').hide();
        $('#measurement-upload').hide();
        $('#product-layout-upload').hide();
        $('#pattern-upload').hide();
        $('#technical-techPack-upload').hide();

        $('#2D-mockup-upload-progress').hide();
        $('#3D-mockup-upload-progress').hide();
        $('#tech-pack-upload-progress').hide();
        $('#measurement-upload-progress').hide();
        $('#product-layout-upload-progress').hide();
        $('#pattern-upload-progress').hide();
        $('#technical-techPack-upload-progress').hide();

        $('#mockup-front-upload').hide();
        $('#mockup-side-upload').hide();
        $('#mockup-back-upload').hide();

        $('#mockup-front-upload-progress').hide();
        $('#mockup-side-upload-progress').hide();
        $('#mockup-back-upload-progress').hide();

        $('.slider-img-reset').attr('src', 'uploads/default_img.jpg');
        $('.slider-img-data-reset').attr('data-image', 'uploads/default_img.jpg');

        slideshowImages = [];
        currentSlideIndex = 0;
    }

    function tableLayout(){
        var layout_id = $('#layout_id').val();
        var product_no = $('#product_no').val();
        var product_name = $('#product_name').val();
        var product_category_id = $('#product_category_id').val();
        var main_category_id = $('#main_category_id').val();
        var sport = $('#sport').val();
        var gender = $('#gender').val();
        var default_price = $('#default_price').val();

        var pattern_code = $('#pattern_code').val();
        var product_size = $('#product_size').val();
        var standard_fabric = $('#standard_fabric').val();
        var fabric_options = $('#fabric_options').val();
        var embellishment_options = $('#embellishment_options').val();
        var attributes = $('#attributes').val();
        var weight = $('#weight').val();
        var factories = $('#factories').val();
        var status = $('#status').val();

        var description = $('#description').val();
        var notes = $('#notes').val();
        var created_at = $('#created_at').val();
        var updated_at = $('#updated_at').val();

        if($('#product_no').is(':checked')) {
            $('.product-no').css('display', 'table-cell');
            product_no = 1;
        } else {
            $('.product-no').css('display', 'none');
            product_no = 0;
        }

        if($('#product_name').is(':checked')) {
            $('.product-name').css('display', 'table-cell');
            product_name = 1;
        } else {
            $('.product-name').css('display', 'none');
            product_name = 0;
        }

        if($('#product_category_id').is(':checked')) {
            $('.product-category-id').css('display', 'table-cell');
            product_category_id = 1;
        } else {
            $('.product-category-id').css('display', 'none');
            product_category_id = 0;
        }

        if($('#main_category_id').is(':checked')) {
            $('.main-category-id').css('display', 'table-cell');
            main_category_id = 1;
        } else {
            $('.main-category-id').css('display', 'none');
            main_category_id = 0;
        }

        if($('#sport').is(':checked')) {
            $('.sport').css('display', 'table-cell');
            sport = 1;
        } else {
            $('.sport').css('display', 'none');
            sport = 0;
        }

        if($('#gender').is(':checked')) {
            $('.gender').css('display', 'table-cell');
            gender = 1;
        } else {
            $('.gender').css('display', 'none');
            gender = 0;
        }

        if($('#default_price').is(':checked')) {
            $('.default-price').css('display', 'table-cell');
            default_price = 1;
        } else {
            $('.default-price').css('display', 'none');
            default_price = 0;
        }


        if($('#pattern_code').is(':checked')) {
            $('.pattern-code').css('display', 'table-cell');
            pattern_code = 1;
        } else {
            $('.pattern-code').css('display', 'none');
            pattern_code = 0;
        }

        if($('#product_size').is(':checked')) {
            $('.product-size').css('display', 'table-cell');
            product_size = 1;
        } else {
            $('.product-size').css('display', 'none');
            product_size = 0;
        }

        if($('#standard_fabric').is(':checked')) {
            $('.standard-fabric').css('display', 'table-cell');
            standard_fabric = 1;
        } else {
            $('.standard-fabric').css('display', 'none');
            standard_fabric = 0;
        }

        if($('#fabric_options').is(':checked')) {
            $('.fabric-options').css('display', 'table-cell');
            fabric_options = 1;
        } else {
            $('.fabric-options').css('display', 'none');
            fabric_options = 0;
        }

        if($('#embellishment_options').is(':checked')) {
            $('.embellishment-options').css('display', 'table-cell');
            embellishment_options = 1;
        } else {
            $('.embellishment-options').css('display', 'none');
            embellishment_options = 0;
        }

        if($('#attributes').is(':checked')) {
            $('.attributes').css('display', 'table-cell');
            attributes = 1;
        } else {
            $('.attributes').css('display', 'none');
            attributes = 0;
        }

        if($('#weight').is(':checked')) {
            $('.weight').css('display', 'table-cell');
            weight = 1;
        } else {
            $('.weight').css('display', 'none');
            weight = 0;
        }

        if($('#factories').is(':checked')) {
            $('.factories').css('display', 'table-cell');
            factories = 1;
        } else {
            $('.factories').css('display', 'none');
            factories = 0;
        }

        if($('#status').is(':checked')) {
            $('.product-status').css('display', 'table-cell');
            status = 1;
        } else {
            $('.product-status').css('display', 'none');
            status = 0;
        }


        if($('#description').is(':checked')) {
            $('.description').css('display', 'table-cell');
            description = 1;
        } else {
            $('.description').css('display', 'none');
            description = 0;
        }

        if($('#notes').is(':checked')) {
            $('.notes').css('display', 'table-cell');
            notes = 1;
        } else {
            $('.notes').css('display', 'none');
            notes = 0;
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
            url: "products/layout",
            type: "POST",
            data: {
                'layout_id':layout_id, 'product_no':product_no, 'product_name':product_name, 'product_category_id':product_category_id, 'sport':sport,
                'gender':gender, 'default_price':default_price, 'pattern_code':pattern_code, 'main_category_id':main_category_id,
                'product_size': product_size, 'standard_fabric': standard_fabric, 'fabric_options': fabric_options, 'embellishment_options': embellishment_options, 'pro_attributes': attributes, 'weight': weight, 'factories': factories, 'status': status,
                'description':description, 'notes':notes, 'created_at':created_at, 'updated_at':updated_at,
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
        $('#product_table thead th').each(function(){
            if($(this).text() == 'Product Name') {
                searchIdx = $('#product_table thead th').index(this);
                console.log(searchIdx);
            }
        });
    }

    $('#layout_modal').on('hidden.bs.modal', function () {
        $(".se-pre-con").fadeIn('slow');
        window.location.reload(true);
    });

    $('#product_create_modal').on('hidden.bs.modal', function () {
        $(".se-pre-con").fadeIn('slow');
        window.location.reload(true);
    });

    function uploadFile(imgID) {
        var image_preview = document.getElementById("preview_mockup_img_"+imgID);
        var file = document.getElementById("mockup_img_"+imgID).files[0];

        var reader = new FileReader();
        reader.onloadend = function () {
            image_preview.src = reader.result;
            document.getElementById("base64").value = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            image_preview.src = "";
        }
    }

    function edit_uploadFile(imgID) {
        var image_preview = document.getElementById("edit_preview_mockup_img_"+imgID);
        var file = document.getElementById("edit_mockup_img_"+imgID).files[0];

        var reader = new FileReader();
        reader.onloadend = function () {
            image_preview.src = reader.result;
            document.getElementById("base64").value = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            image_preview.src = "";
        }
    }

    $('.multy-selection').change(function(){
        var ulHeight = $(this).parent().find('ul').height();
        $(this).parent().height(parseInt(ulHeight)+51);
        $(this).parent().find('.select2-selection.select2-selection--multiple').height(parseInt(ulHeight)+51);
    });

    // Mobile View Setup: data attributes & collapse trigger
    const isMobileDevice = () => window.innerWidth <= 768;

    const setupMobileProductCards = () => {
        if (!isMobileDevice()) return;

        $('#product_table tbody.list tr:not([class*="trOfProduct"])').each(function () {
            const $row = $(this);
            const $sportTd = $row.find('td.sport');
            const $genderTd = $row.find('td.gender');

            if (!$sportTd.attr('data-sport-name')) {
                const sportText = $sportTd.text().trim() || 'All';
                $sportTd.attr('data-sport-name', sportText);
            }

            if ($genderTd.attr('data-sub-count') === undefined) {
                $genderTd.attr('data-sub-count', 0);
            }
            
            // if (!$genderTd.attr('data-sub-count')) {
            //     const chevron = $row.find('td.collapseButton i');
            //     let count = 0;
            //     if (chevron.attr('onclick')) {
            //         const match = chevron.attr('onclick').match(/\[(.*?)\]/);
            //         if (match && match[0]) {
            //             try {
            //                 const subList = JSON.parse(match[0]);
            //                 count = subList.length;
            //             } catch (e) {
            //                 count = 0;
            //             }
            //         }
            //     }
            //     $genderTd.attr('data-sub-count', count);
            // }
        });
    };

    $(document).ready(function () {
        setupMobileProductCards();
        $('#product_table').on('draw.dt', setupMobileProductCards);
        $(window).on('resize', setupMobileProductCards);

        // View button click on card navigates to edit_product
        $(document).on('click', '#product_table tbody.list tr td.product-category-id', function (e) {
            if (!isMobileDevice()) return;
            const $row = $(this).closest('tr');
            const editUrl = $row.find('td.product-name a').attr('href');
            if (editUrl) {
                window.location.href = editUrl;
            }
        });

        // Mobile: style expanded parent + sub-product rows as connected white card group
        $(document).on('click', '#product_table tbody.list tr td.collapseButton', function () {
            if (!isMobileDevice()) return;
            const $parentRow = $(this).closest('tr');
            setTimeout(function () {
                const chevronIcon = $parentRow.find('td.collapseButton i');
                const isExpanded = chevronIcon.hasClass('fa-chevron-down');

                if (isExpanded) {
                    // Add expanded class to parent
                    $parentRow.addClass('is-expanded');
                    // Find all cloned sub-product rows immediately after parent
                    const $clones = $parentRow.nextAll('[class*="trOfProduct"]').filter(function () {
                        // Only get clones belonging to this parent (stop at next non-subproduct row)
                        return true;
                    });
                    // Get the specific product ID clones
                    const parentClasses = $parentRow.attr('class') || '';
                    const allClones = [];
                    let $next = $parentRow.next();
                    while ($next.length && $next.attr('class') && $next.attr('class').indexOf('trOfProduct') !== -1) {
                        allClones.push($next);
                        $next = $next.next();
                    }
                    // Mark the last clone
                    if (allClones.length > 0) {
                        // Remove old marks
                        for (let i = 0; i < allClones.length; i++) {
                            allClones[i].removeClass('is-last-subproduct');
                            // Wrap TDs in inner card div if not already wrapped
                            if (allClones[i].find('.subproduct-card-inner').length === 0) {
                                allClones[i].children('td').wrapAll('<div class="subproduct-card-inner"></div>');
                            }
                        }
                        allClones[allClones.length - 1].addClass('is-last-subproduct');
                    }
                } else {
                    // Collapsed: remove expanded class
                    $parentRow.removeClass('is-expanded');
                }
            }, 80);
        });
    });
</script>
@endsection
