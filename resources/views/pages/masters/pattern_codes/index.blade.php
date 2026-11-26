@extends('layouts.app', ['activePage' => 'pattern_codes', 'titlePage' => __('Pattern Codes')])

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

   /* MOBILE RESPONSIVE STYLES (max-width: 768px) */
    @media (max-width: 768px) {

        /* ── Global mobile page background ── */
        body {
            background-color: #f8fafc !important;
        }

        /* ── Page wrapper: remove desktop offset & add mobile padding ── */
        .content-position {
            position: relative !important;
            top: 0 !important;
            padding: 10px 16px 30px 16px !important;
        }

        /* ── Hide desktop-only header bar and A–Z alphabet filter ── */
        .content-position > .row.col-md-12:first-of-type,
        div.alphabet {
            display: none !important;
        }

        /* ── Card container: strip desktop card styling (flat/transparent) ── */
        .card {
            background-color: transparent !important;
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
            display: flex !important;
            flex-direction: column !important;
        }

        /* ── Remove default column padding inside the card ── */
        .col-md-12 {
            padding: 0 !important;
        }

        /* ── Add button area: full width, ordered first, spaced below ── */
        .card > .col-md-4.ml-auto.mb-2.mt-3 {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 0 12px 0 !important;
            order: 1 !important;
        }

        /* ── Button table wrapper: block layout on mobile ── */
        table.btn-inside-table {
            display: block !important;
            width: 100% !important;
        }

        /* ── Button table body/rows: block layout on mobile ── */
        table.btn-inside-table tbody,
        table.btn-inside-table tr {
            display: block !important;
            width: 100% !important;
        }

        /* ── Hide the first two cells (Table Layout + spacer) on mobile ── */
        table.btn-inside-table tr td:first-child,
        table.btn-inside-table tr td:nth-child(2) {
            display: none !important;
        }

        /* ── Last cell (Add Pattern Code) takes full width, no padding ── */
        table.btn-inside-table tr td:last-child {
            display: block !important;
            width: 100% !important;
            padding: 0 !important;
        }

        /* ── Restyle the Add Pattern Code button as a full-width teal CTA ── */
        .btn-green-filled,
        .btn-inside-table button.btn-green-filled,
        .btn-inside-table .btn-green-filled {
            display: flex !important;
            width: 100% !important;
            height: 44px !important;
            background-color: #14b8a6 !important;
            border: none !important;
            border-radius: 12px !important;
            font-size: 13px !important;                 /* hide original text */
            font-weight: 700 !important;
            color: #ffffff !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: 0 2px 8px rgba(20, 184, 166, 0.25) !important;
            cursor: pointer !important;
            margin: 0 !important;
            text-transform: none !important;
        }

        /* ── Hide the plus icon inside the Add button on mobile ── */
        /* .btn-green-filled i {
            display: none !important;
        } */

        /* ── Replace button text via ::after pseudo-element ── */
        /* .btn-green-filled::after {
            content: "+Add Pattern Codes" !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            color: #ffffff !important;
        } */

        /* ── DataTables wrapper: stack controls vertically ── */
        .dataTables_wrapper {
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* ── DataTables internal rows: full width, no side margins ── */
        .dataTables_wrapper .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
            width: 100% !important;
        }

        /* ── DataTables columns: full width, no padding ── */
        .dataTables_wrapper .row > [class*="col-"] {
            padding-left: 0 !important;
            padding-right: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }

        /* ── Search bar: full width, ordered 2nd ── */
        .dataTables_filter {
            order: 2 !important;
            width: 100% !important;
            margin: 0 0 12px 0 !important;
            text-align: left !important;
            float: none !important;
        }

        /* ── Search label: full width, hide text, relative for icon positioning ── */
        .dataTables_filter label {
            width: 100% !important;
            display: block !important;
            color: transparent !important;
            font-size: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            position: relative !important;
        }

        /* ── Search input: rounded pill with magnifier icon background ── */
        .dataTables_filter input,
        .dataTables_filter input[type="search"],
        .dataTables_filter input.form-control {
            display: block !important;
            width: 100% !important;
            height: 48px !important;
            border-radius: 14px !important;
            border: 1px solid #e2e8f0 !important;
            background-color: #ffffff !important;
            padding: 10px 16px 10px 44px !important;   /* room for icon */
            font-size: 15px !important;
            color: #334155 !important;
            box-sizing: border-box !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03) !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'%3E%3C/circle%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'%3E%3C/line%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: 14px center !important;
            margin: 0 !important;
            outline: none !important;
        }

        /* ── Search input placeholder styling ── */
        .dataTables_filter input::placeholder {
            color: #94a3b8 !important;
            font-size: 15px !important;
        }

        /* ── Hide the "Show N entries" length selector on mobile ── */
        .dataTables_length {
            display: none !important;
        }

        /* ── Table container: full width, ordered after search ── */
        .col-md-12.new-style-table {
            padding: 0 !important;
            order: 4 !important;
            display: block !important;
            width: 100% !important;
        }

        /* ── Table responsive wrapper: allow overflow visible, no borders ── */
        .table-responsive {
            overflow: visible !important;
            border: none !important;
            margin: 0 !important;
        }

        /* ── Main table: block layout, no border/background ── */
        #pattern_codes_table {
            display: block !important;
            width: 100% !important;
            border: none !important;
            background: transparent !important;
        }

        /* ── Hide desktop table header ── */
        #pattern_codes_table thead {
            display: none !important;
        }

        /* ── Table body: flex column with gap between cards ── */
        #pattern_codes_table tbody {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            width: 100% !important;
        }

        /* ── Remove row striping/borders (mobile cards instead) ── */
        .new-style-table table tr {
            border-bottom: none !important;
            border-top: none !important;
            background-color: transparent !important;
        }

        /* ── Disable hover background on mobile ── */
        .new-style-table table tbody tr:hover {
            background-color: transparent !important;
        }

        /* ── Each table row becomes a white rounded card ── */
        #pattern_codes_table tbody tr {
            z-index: 0 !important;
            isolation: isolate !important;
            display: flex !important;
            flex-wrap: wrap !important;
            align-content: flex-start !important;
            column-gap: 12px !important;
            position: relative !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 18px !important;
            padding: 16px !important;
            box-shadow: 0 1px 4px rgba(0,0,0,0.03) !important;
            box-sizing: border-box !important;
            width: 100% !important;
            min-height: 0 !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
        }

        /* ── Reset cell styling inside mobile cards ── */
        #pattern_codes_table tbody tr td {
            border: none !important;
            padding: 0 !important;
            background: transparent !important;
            min-height: 0 !important;
        }

        /* ── Card header: Product Name (row 1, full width) ── */
        #pattern_codes_table tbody tr td.product-name {
            order: 1 !important;
            flex: 0 0 100% !important;
            width: 100% !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #1F2933 !important;
            line-height: 1.4 !important;
            padding-right: 125px !important;          /* room for Edit + chevron */
            margin-bottom: 2px !important;
            display: block !important;
            word-break: break-word !important;
            white-space: normal !important;
            box-sizing: border-box !important;
        }

        /* ── Expanded card: header spans full width with divider below ── */
        #pattern_codes_table tbody tr:not(.is-collapsed) td.product-name {
            flex: 0 0 calc(100% + 32px) !important;
            width: calc(100% + 32px) !important;
            margin: 0 -16px !important;
            padding: 0 125px 14px 16px !important;
            border-bottom: 1px solid #eef2f6 !important;
        }

        /* ── Pattern Code cell: collapsed state shows as subtitle ── */
        #pattern_codes_table tbody tr td.pattern-code {
            order: 2 !important;
            flex: 0 0 100% !important;
            width: 100% !important;
            padding-right: 125px !important;
            display: block !important;
            box-sizing: border-box !important;
        }

        /* ── Edit pill: absolutely positioned button on card top-right ── */
        #pattern_codes_table tbody tr td.pattern-code a.edit::after {
            content: "Edit" !important;
            position: absolute !important;
            top: 19px !important;
            right: 42px !important;
            height: 28px !important;
            display: inline-flex !important;
            align-items: center !important;
            padding: 0 10px 0 26px !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 10px !important;
            background: #ffffff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%23334155' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7'/><path d='M18.5 2.5a2.1 2.1 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z'/></svg>") 8px center no-repeat !important;
            color: #334155 !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03) !important;
            z-index: 2 !important;
            white-space: nowrap !important;
        }

        /* ── Chevron icon indicator on top-right of card ── */
        #pattern_codes_table tbody tr::after {
            content: "\f078" !important;              /* fa-chevron-down */
            font-family: 'Font Awesome 5 Free', 'FontAwesome' !important;
            font-weight: 900 !important;
            position: absolute !important;
            right: 16px !important;
            top: 24px !important;
            font-size: 13px !important;
            color: #1e293b !important;
            pointer-events: none !important;
            line-height: 1 !important;
        }

        /* ── Chevron flips up when card is expanded ── */
        #pattern_codes_table tbody tr:not(.is-collapsed)::after {
            content: "\f077" !important;              /* fa-chevron-up */
        }

        /* ── Ensure no ::before content is rendered on rows ── */
        #pattern_codes_table tbody tr::before {
            content: none !important;
        }

        /* ── Expanded: Pattern Code takes left half, with label ── */
        #pattern_codes_table tbody tr:not(.is-collapsed) td.pattern-code {
            order: 3 !important;
            flex: 0 0 calc(50% - 6px) !important;
            width: calc(50% - 6px) !important;
            margin-top: 16px !important;
            padding-right: 0 !important;
        }

        /* ── Expanded: "Pattern Code" label above the value ── */
        #pattern_codes_table tbody tr:not(.is-collapsed) td.pattern-code::before {
            content: "Pattern Code" !important;
            display: block !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            color: #6B7280 !important;
            margin-bottom: 1px !important;
        }

        /* ── Attributes cell: hidden by default, right half when expanded ── */
        #pattern_codes_table tbody tr td.attribute-name {
            order: 4 !important;
            flex: 0 0 calc(50% - 6px) !important;
            width: calc(50% - 6px) !important;
            margin-top: 16px !important;
            display: none !important;
            box-sizing: border-box !important;
        }

        /* ── Expanded: "Attributes" label above the list ── */
        #pattern_codes_table tbody tr td.attribute-name::before {
            content: "Attributes" !important;
            display: block !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            color: #6B7280 !important;
            margin-bottom: 1px !important;
        }

        /* ── Attributes list: remove default list styling ── */
        #pattern_codes_table tbody tr td.attribute-name ul {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* ── Attribute items: dark text, compact line height ── */
        #pattern_codes_table tbody tr td.attribute-name ul li {
            font-size: 12px !important;
            font-weight: 500 !important;
            color: #1F2933 !important;
            line-height: 1.3 !important;
        }

        /* ── Bullet marker (asterisk) before each attribute ── */
        #pattern_codes_table tbody tr td.attribute-name ul li::before {
            content: "*" !important;
            margin-right: 2px !important;
        }

        /* ── Created/Updated date cells: hidden by default, styled as info tiles ── */
        #pattern_codes_table tbody tr td.created-at,
        #pattern_codes_table tbody tr td.updated-at {
            position: relative !important;
            flex: 0 0 calc(50% - 6px) !important;
            width: calc(50% - 6px) !important;
            margin-top: 14px !important;
            padding: 12px 10px 12px 56px !important;   /* room for icon */
            background: #F2F3F4 !important;
            border-radius: 14px !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            color: #1F2933 !important;
            line-height: 1.3 !important;
            box-sizing: border-box !important;
            display: none !important;
        }

        /* ── Order the date tiles in the card ── */
        #pattern_codes_table tbody tr td.created-at { order: 5 !important; }
        #pattern_codes_table tbody tr td.updated-at { order: 6 !important; }

        /* ── Date tile labels ("Created" / "Last Updated") ── */
        #pattern_codes_table tbody tr td.created-at::before,
        #pattern_codes_table tbody tr td.updated-at::before {
            display: block !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            color: #6B7280 !important;
            margin-bottom: 2px !important;
        }

        /* ── Set the date tile label text ── */
        #pattern_codes_table tbody tr td.created-at::before { content: "Created" !important; }
        #pattern_codes_table tbody tr td.updated-at::before { content: "Last Updated" !important; }

        /* ── White icon square inside each date tile ── */
        #pattern_codes_table tbody tr td.created-at::after,
        #pattern_codes_table tbody tr td.updated-at::after {
            content: "" !important;
            position: absolute !important;
            left: 12px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            width: 34px !important;
            height: 34px !important;
            border-radius: 10px !important;
            background-color: #ffffff !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
            background-size: 18px 18px !important;
        }

        /* ── Show attributes + date tiles only when card is expanded ── */
        #pattern_codes_table tbody tr:not(.is-collapsed) td.attribute-name,
        #pattern_codes_table tbody tr:not(.is-collapsed) td.created-at,
        #pattern_codes_table tbody tr:not(.is-collapsed) td.updated-at {
            display: block !important;
        }

        /* ── Empty state: remove card styling, center message ── */
        #pattern_codes_table tbody tr:has(td.dataTables_empty) {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            padding: 24px 16px !important;
            cursor: default !important;
            justify-content: center !important;
        }

        /* ── Empty state: hide chevron ── */
        #pattern_codes_table tbody tr:has(td.dataTables_empty)::after {
            display: none !important;
            content: none !important;
        }

        /* ── Empty state message text ── */
        #pattern_codes_table tbody tr td.dataTables_empty {
            width: 100% !important;
            text-align: center !important;
            font-size: 14px !important;
            color: #94a3b8 !important;
        }
        
        /* ── Created date tile icon: calendar glyph ── */
        #pattern_codes_table tbody tr td.created-at::after {
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%231e293b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><rect x='3' y='4' width='18' height='18' rx='2' ry='2'></rect><line x1='16' y1='2' x2='16' y2='6'></line><line x1='8' y1='2' x2='8' y2='6'></line><line x1='3' y1='10' x2='21' y2='10'></line></svg>") !important;
        }
        
        /* ── Updated date tile icon: clock glyph ── */
        #pattern_codes_table tbody tr td.updated-at::after {
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%231e293b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><circle cx='12' cy='12' r='10'></circle><polyline points='12 6 12 12 16 14'></polyline></svg>") !important;
        }

        /* ── Hide pagination when table is empty ── */
        .dataTables_wrapper:has(td.dataTables_empty) .dataTables_paginate {
            display: none !important;
        }

        /* ── Pagination: centered, full width, ordered last ── */
        .dataTables_paginate {
            display: flex !important;
            justify-content: center !important;
            margin-top: 16px !important;
            width: 100% !important;
            order: 5 !important;
        }

        /* ── Pagination list: wrap with spacing between page buttons ── */
        .dataTables_paginate ul.pagination {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 4px !important;
        }

        /* ── Pagination buttons: rounded, subtle border ── */
        .dataTables_paginate .page-item .page-link,
        .dataTables_paginate .page-item span {
            border-radius: 8px !important;
            border: 1px solid #e2e8f0 !important;
            color: #475569 !important;
            font-size: 13px !important;
            padding: 6px 12px !important;
            background: #ffffff !important;
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
            order: 4 !important;
        }

        /* ── Active page button: teal filled ── */
        .dataTables_paginate .page-item.active .page-link {
            background-color: #14B8A6 !important;
            border-color: #14B8A6 !important;
            color: #ffffff !important;
            font-weight: 700 !important;
        }

        /* MODALS (Add / Edit Pattern Codes) — mobile overrides */

        /* ── Modal dialog: constrained width with side margins ── */
        #pattern_code_create_modal .modal-dialog,
        #pattern_code_edit_modal .modal-dialog {
            margin: 16px auto !important;
            max-width: calc(100% - 32px) !important;
            margin-top: 109px !important;
        }

        /* ── Modal content: rounded card look with shadow ── */
        #pattern_code_create_modal .modal-content,
        #pattern_code_edit_modal .modal-content {
            border-radius: 24px !important;
            border: 1px solid #f1f5f9 !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
            background: #ffffff !important;
            overflow: hidden !important;
        }

        /* ── Modal header: spaced, flexed with divider ── */
        #pattern_code_create_modal .modal-header,
        #pattern_code_edit_modal .modal-header {
            padding: 22px 24px 18px 24px !important;
            border-bottom: 1px solid #eef2f6 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            background: #ffffff !important;
        }

        /* ── Modal title: bold, dark, tight letter-spacing ── */
        #pattern_code_create_modal .modal-title,
        #pattern_code_edit_modal .modal-title {
            font-size: 20px !important;
            font-weight: 800 !important;
            color: #111827 !important;
            margin: 0 !important;
            letter-spacing: -0.3px !important;
        }

        /* ── Modal close (×) button: plain, muted ── */
        #pattern_code_create_modal .modal-header button.close,
        #pattern_code_edit_modal .modal-header button.close {
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

        /* ── Modal body: white background with inner padding ── */
        #pattern_code_create_modal .modal-body,
        #pattern_code_edit_modal .modal-body {
            padding: 16px 20px !important;
            background: #ffffff !important;
        }

        /* ── Remove desktop side margins inside modal body ── */
        #pattern_code_create_modal .modal-body .row.ml-3.mr-3,
        #pattern_code_edit_modal .modal-body .row.ml-3.mr-3 {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        /* ── Modal form columns: stack full-width ── */
        #pattern_code_create_modal .modal-body .col-md-6,
        #pattern_code_edit_modal .modal-body .col-md-6 {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            padding: 0 !important;
            margin-top: 14px !important;
        }

        /* ── Flex wrapper inside modal body: full width ── */
        #pattern_code_create_modal .modal-body .flex_set,
        #pattern_code_edit_modal .modal-body .flex_set {
            margin: 0 !important;
            width: 100% !important;
        }

        /* ── Inner max-width wrapper: full width ── */
        #pattern_code_create_modal .modal-body .max_width01,
        #pattern_code_edit_modal .modal-body .max_width01 {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
        }

        /* ── Form labels: bold, full width, spaced below ── */
        #pattern_code_create_modal label.form-label,
        #pattern_code_edit_modal label.form-label {
            display: block !important;
            width: 100% !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            margin-bottom: 8px !important;
        }

        /* ── Required asterisk: red accent ── */
        #pattern_code_create_modal label.form-label .text-danger,
        #pattern_code_edit_modal label.form-label .text-danger {
            color: #ef4444 !important;
            margin-left: 2px !important;
        }

        /* ── Select2 container: full width, no border ── */
        #pattern_code_create_modal .select2-container,
        #pattern_code_edit_modal .select2-container {
            width: 100% !important;
            border: none !important;
        }

        /* ── Select2 selection box: pill-shaped input look ── */
        #pattern_code_create_modal .select2-container--default .select2-selection--single,
        #pattern_code_edit_modal .select2-container--default .select2-selection--single {
            height: 48px !important;
            background: #ffffff !important;
            border: 1.5px solid #d1d5db !important;
            border-radius: 12px !important;
            padding: 0 14px !important;
            display: flex !important;
            align-items: center !important;
            outline: none !important;
            box-sizing: border-box !important;
        }

        /* ── Select2 rendered text: dark, vertically centered ── */
        #pattern_code_create_modal .select2-container--default .select2-selection--single .select2-selection__rendered,
        #pattern_code_edit_modal .select2-container--default .select2-selection--single .select2-selection__rendered {
            font-size: 14px !important;
            font-weight: 500 !important;
            color: #111827 !important;
            padding: 0 !important;
            line-height: 46px !important;
        }

        /* ── Select2 placeholder: muted gray ── */
        #pattern_code_create_modal .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #94a3b8 !important;
        }

        /* ── Select2 dropdown arrow: vertically centered on right ── */
        #pattern_code_create_modal .select2-container--default .select2-selection--single .select2-selection__arrow,
        #pattern_code_edit_modal .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 50% !important;
            transform: translateY(-50%) !important;
            right: 14px !important;
            height: 20px !important;
            width: 20px !important;
        }

        /* ── Pattern Code text inputs: pill-shaped, full width ── */
        #pattern_code_create_modal input.form-control,
        #pattern_code_edit_modal input.form-control,
        #new_pattern_code,
        #edit_pattern_code {
            display: block !important;
            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
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

        /* ── Text input placeholders: muted gray ── */
        #pattern_code_create_modal input.form-control::placeholder,
        #new_pattern_code::placeholder {
            color: #94a3b8 !important;
            font-size: 14px !important;
        }

        /* ── Attributes section wrapper: full width, spaced above ── */
        #edit_attributes,
        #new_attributes {
            padding: 0 !important;
            margin-top: 16px !important;
            width: 100% !important;
        }

        /* ── Attributes section label ── */
        #edit_attributes > label.form-label,
        #new_attributes > label.form-label {
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            margin-bottom: 12px !important;
        }

        /* ── Attributes row: flex-wrap with no margins ── */
        #edit_attributes .row,
        #new_attributes .row {
            display: flex !important;
            flex-wrap: wrap !important;
            margin: 0 !important;
        }

        /* ── Attribute items: 2-column grid (50% each) ── */
        #edit_attributes .col-md-4,
        #new_attributes .col-md-4 {
            width: 50% !important;
            max-width: 50% !important;
            flex: 0 0 50% !important;
            padding: 0 6px 12px 0 !important;
            box-sizing: border-box !important;
        }

        /* ── Checkbox wrapper: flex-aligned with reserved space for custom box ── */
        #edit_attributes .custom-control.custom-checkbox,
        #new_attributes .custom-control.custom-checkbox {
            display: flex !important;
            align-items: center !important;
            padding-left: 28px !important;
            min-height: 24px !important;
            position: relative !important;
        }

        /* ── Native checkbox: invisible but tappable overlay ── */
        #edit_attributes .custom-control-input,
        #new_attributes .custom-control-input {
            position: absolute !important;
            z-index: 2 !important;
            opacity: 0 !important;
            width: 20px !important;
            height: 20px !important;
            top: 2px !important;
            left: 0 !important;
            cursor: pointer !important;
        }

        /* ── Checkbox label: bold, dark, clickable ── */
        #edit_attributes .custom-control-label,
        #new_attributes .custom-control-label {
            font-size: 13.5px !important;
            font-weight: 600 !important;
            color: #1e293b !important;
            cursor: pointer !important;
            line-height: 22px !important;
        }

        /* ── Custom checkbox box (unchecked): rounded square ── */
        /* #edit_attributes .custom-control-label::before,
        #new_attributes .custom-control-label::before {
            content: "" !important;
            position: absolute !important;
            left: 0 !important;
            top: 1px !important;
            width: 20px !important;
            height: 20px !important;
            border: 1.5px solid #cbd5e1 !important;
            border-radius: 6px !important;
            background-color: #ffffff !important;
            box-sizing: border-box !important;
        } */

        /* ── Custom checkbox box (checked): green filled ── */
        /* #edit_attributes .custom-control-input:checked ~ .custom-control-label::before,
        #new_attributes .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #10b981 !important;
            border-color: #10b981 !important;
        } */

        /* ── Custom checkmark: white tick drawn with borders ── */
        /* #edit_attributes .custom-control-input:checked ~ .custom-control-label::after,
        #new_attributes .custom-control-input:checked ~ .custom-control-label::after {
            content: "" !important;
            position: absolute !important;
            left: 7px !important;
            top: 4px !important;
            width: 6px !important;
            height: 11px !important;
            border: solid #ffffff !important;
            border-width: 0 2px 2px 0 !important;
            transform: rotate(45deg) !important;
            background: none !important;
        } */

        /* Pattern code: remove left gap */
        #pattern_codes_table tbody tr td.pattern-code a.edit {
            padding: 0 !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            color: #1F2933 !important;
        }

        /* ── Modal footer / last form row: no top border, spaced ── */
        #pattern_code_create_modal .modal-footer,
        #pattern_code_edit_modal .modal-footer,
        #pattern_code_edit_modal .modal-body form > .row:last-child {
            padding: 16px 20px 24px 20px !important;
            border-top: none !important;
            background: #ffffff !important;
            margin: 0 !important;
        }

        /* ── Footer button container: horizontal flex with gap ── */
        #pattern_code_create_modal .control-btns,
        #pattern_code_edit_modal .control-btns {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 10px !important;
            width: 100% !important;
            padding: 0 !important;
            margin-top: 10px !important;
        }

        /* ── Footer buttons: equal flex, 48px tall pill style ── */
        #pattern_code_create_modal .control-btns .btn,
        #pattern_code_edit_modal .control-btns .btn {
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

        /* ── Secondary (cancel) button: gray filled ── */
        #pattern_code_create_modal .control-btns .btn-secondary,
        #pattern_code_edit_modal .control-btns .btn-secondary {
            background-color: #94a3b8 !important;
            color: #ffffff !important;
        }

        /* ── Success (save/submit) button: green filled ── */
        #pattern_code_create_modal .control-btns .btn-success,
        #pattern_code_edit_modal .control-btns .btn-success {
            background-color: #10b981 !important;
            color: #ffffff !important;
        }

        /* ── Danger (delete) button: red filled, ordered first (left) ── */
        #pattern_code_edit_modal .control-btns .btn-danger {
            background-color: #dc2626 !important;
            color: #ffffff !important;
            order: -1 !important;
        }
    }
</style>

<div class="container-fluid mb-5 content-position">
    {{-- <div class="se-pre-con"></div> --}}

    @section('order-header')
        <span>PATTERN CODES</span>
    @endsection

    @section('back-btn')
    <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="row col-md-12" style="padding: 0rem;">
        <div class="col-md-4 ml-auto text-right mt-3">

        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
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
                            @if (Gate::check('add pattern code'))
                                <button class="btn-green-filled" style="outline: unset;" href="#" data-toggle="modal" data-target="#pattern_code_create_modal" title="Add New Pattern Code">
                                    <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD PATTERN CODE
                                </button>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
                <div class="col-md-12 new-style-table">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="pattern_codes_table">
                            <thead>
                                <th class="pattern-code" scope="col">Pattern Code</th>
                                <th class="product-name" scope="col">Product Name</th>
                                <th class="attribute-name" scope="col">Attributes</th>
                                <th class="created-at" scope="col">Created At</th>
                                <th class="updated-at" scope="col">Updated At</th>
                            </thead>

                            <tbody class="list">
                                @foreach ($patternCodes as $patternCode)
                                <tr>
                                    <td class="pattern-code"><a href="#" style="color: grey !important" class="edit edit_pattern_codes" data-value="{{$patternCode->id}}">{{$patternCode->pattern_code}}</a></td>
                                    <td class="product-name">{{ $patternCode->subProduct->product_name ?? '' }}</td>
                                    <td class="attribute-name">
                                        @php
                                            $patternAttributeArr = [];
                                            $patternAttributeArr = json_decode($patternCode->pattern_attribute);
                                        @endphp
                                        <ul>
                                            @foreach ($patternAttributeArr as $patternAttribute)
                                                <li>{{ $helper->getAttributeNameById($patternAttribute) }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="created-at">{{$patternCode->created_at->format('m-d-Y')}}</td>
                                    <td class="updated-at">{{$patternCode->updated_at->format('m-d-Y')}}</td>
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
                <h3 class="modal-title" id="modal-title-default">Patter Codes Fields &amp; Layouts</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">
                        <input type="hidden" id="layout_id" name="layout_id" value="{{$patternCodeLayout['id'] ?? ''}}" />
                        <input type="hidden" id="column_layout_id" name="column_layout_id" value="{{$columnLayout['id'] ?? 0}}" />

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="pattern_code" name="pattern_code" title="Attribute Group" @isset($patternCodeLayout) @if ($patternCodeLayout['pattern_code'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="pattern_code">Patter Code</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="product_name" name="product_name" title="Product Style" @isset($patternCodeLayout) @if ($patternCodeLayout['product_name'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="product_name">Product Name</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="attribute_name" name="attribute_name" title="Attribute" @isset($patternCodeLayout) @if ($patternCodeLayout['attribute_name'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="attribute_name">Attribute</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="created_at" name="created_at" title="Created At" @isset($patternCodeLayout) @if ($patternCodeLayout['created'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="created_at">Created At</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="updated_at" name="updated_at" title="Updated At" @isset($patternCodeLayout) @if ($patternCodeLayout['updated'] == 1) checked @endif @endisset />
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

@include('pages.masters.pattern_codes.create')
@include('pages.masters.pattern_codes.edit')

<script>
    var searchIdx = '';

    $(document).ready( function () {
        // Attributes Table Layout
        tableLayout();

        var attributeTable = $('#pattern_codes_table').DataTable({
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
            var columnStr = localStorage.getItem("DataTables_pattern_codes_table_/pattern_codes");
            var columnObj = JSON.parse(columnStr);
            var colReorder = new $.fn.dataTable.ColReorder( attributeTable );
            var curr = colReorder.fnOrder();
            var column_order = JSON.stringify(curr);
            var interface_name = 'Patter Codes';
            var interface_id = 16;
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
            var columnStr = localStorage.getItem("DataTables_pattern_codes_table_/pattern_codes");
            var columnObj = JSON.parse(columnStr);
            var column_order = JSON.stringify(columnObj.ColReorder);
            var interface_name = 'Patter Codes';
            var interface_id = 16;
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
            var interfaceId = 16;
            $.ajax({
                url: '{{ url("datatable/get_column_order") }}/'+interfaceId,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    console.log(data.column_order);
                    var columnStr = localStorage.getItem("DataTables_pattern_codes_table_/pattern_codes");
                    var columnObj = JSON.parse(columnStr);
                    columnObj.ColReorder = JSON.parse(data.column_order);

                    localStorage.setItem('DataTables_pattern_codes_table_/pattern_codes', JSON.stringify(columnObj));
                },
                complete: function() {
                    $(".se-pre-con").fadeOut('slow');
                }
            });

        }

        // Embellishment Type Edit
        // $(document).on("click", ".edit_pattern_codes", function(){
        //     var attributeId = $(this).data('value');
        //     $('#attribute_id').val(attributeId);
        //     $('#attribute_edit_modal').modal('show');
        //     console.log('error');
        // });


        $('#pattern_code').on('change', function(){ tableLayout(); });
        $('#product_name').on('change', function(){ tableLayout(); });
        $('#attribute_name').on('change', function(){ tableLayout(); });
        $('#created_at').on('change', function(){ tableLayout(); });
        $('#updated_at').on('change', function(){ tableLayout(); });
    });


    $(document).ready( function () {
        $(document).on("click", ".edit_pattern_codes", function(){
            var patternCodeIdId = $(this).data('value');
            $('#pattern_code_id').val(patternCodeIdId);
            $('#pattern_code_edit_modal_body').html('');
            $('#new_attributes').html('');
            $('#pattern_code_edit_modal').modal('show');
        });
    });
    function tableLayout(){
        var layout_id = $('#layout_id').val();
        var pattern_code = $('#pattern_code').val();
        var product_name = $('#product_name').val();
        var attribute_name = $('#attribute_name').val();
        var created_at = $('#created_at').val();
        var updated_at = $('#updated_at').val();

        if($('#pattern_code').is(':checked')) {
            $('.pattern-code').css('display', 'table-cell');
            pattern_code = 1;
        } else {
            $('.pattern-code').css('display', 'none');
            pattern_code = 0;
        }

        if($('#product_name').is(':checked')) {
            $('.product-name').css('display', 'table-cell');
            product_name = 1;
        } else {
            $('.product-name').css('display', 'none');
            product_name = 0;
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
            url: "pattern_codes/layout",
            type: "POST",
            data: {
                'layout_id':layout_id, 'pattern_code':pattern_code, 'product_name':product_name, 'attribute_name':attribute_name, 'created_at':created_at, 'updated_at':updated_at, '_token':'{{csrf_token()}}'
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
        $('#pattern_codes_table thead th').each(function(){
            if($(this).text() == 'Attribute Group') {
                searchIdx = $('#pattern_codes_table thead th').index(this);
                console.log(searchIdx);
            }
        });
    }

    $('#layout_modal').on('hidden.bs.modal', function () {
        $(".se-pre-con").fadeIn('slow');
        window.location.reload(true);
    });

    // Mobile View Card Setup & Collapse/Expand Toggle
    $(document).ready(function() {
        const isMobile = () => window.innerWidth <= 768;

        const setupMobileCards = () => {
            var $filter = $('.dataTables_filter');
            var $card = $('.content-position .card');

            if (!isMobile()) {
                $('#pattern_codes_table tbody tr').removeClass('is-collapsed');

                // Put search back to its original desktop position
                if ($('#filter-home').length) {
                    $('#filter-home').replaceWith($filter);
                }
                return;
            }

            // Move search above Add button on mobile (remember original spot)
            if ($filter.length && $card.length && !$filter.parent().is($card)) {
                if (!$('#filter-home').length) {
                    $('<span id="filter-home"></span>').insertBefore($filter);
                }
                $card.prepend($filter);
            }

            $('#pattern_codes_table tbody tr:not(.toggle-init)').each(function () {
                var codeText = $(this).find('td.pattern-code a').text().trim();
                $(this).find('td.pattern-code').attr('data-code', codeText);
                $(this).addClass('is-collapsed toggle-init');
            });
        };

        setupMobileCards();
        $(window).on('resize', setupMobileCards);
        if (typeof attributeTable !== 'undefined') {
            attributeTable.on('draw.dt', setupMobileCards);
        }

        // Toggle card collapse / expand on card tap (except when clicking Edit pill)
        $('#pattern_codes_table').on('click', 'tbody tr', function (e) {
            if (isMobile() && !$(e.target).closest('.edit_pattern_codes').length) {
                $(this).toggleClass('is-collapsed');
            }
        });
    });
</script>
@endsection
