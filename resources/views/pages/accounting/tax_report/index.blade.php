@extends('layouts.app', ['activePage' => 'tax_report', 'titlePage' => __('Tax Report')])

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
    .form-input,
    .select2.select2-container {
        width: 100% !important;
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
    .user_dp {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }
    .check-image {
        width: 50%;
        height: 200px;
        padding: 5px;
        overflow: hidden;
    }
    .check-image img {
        width: 70%;
        transition: all 1s;
    }
    .check-image img:hover  {
        opacity: 0.5;
    }
    .venmo-image {
        width: auto;
        height: 200px;
        padding: 5px;
        overflow: hidden;
    }
    .venmo-image img {
        width: auto;
        height: 200px;
        transition: all 1s;
    }
    .venmo-image img:hover  {
        opacity: 0.5;
    }
    .export-btn {
        padding: 0.2rem;
        background-color: #787878;
        color: white;
        width: 85px;
        position: relative;
        right: -73px;
    }
    .btn-position {
        position: relative;
        top: -12px;
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
    .content-position {
        position: relative;
        top: -45px;
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
    .table-responsive .table tbody td , .table-responsive .table tbody td a {
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
    .new-style-table table thead tr {
        background-color: rgba(50, 50, 50, 1) !important;
        height: 40px;
    }
    .color_div {
        width: 12px;
        height: 7px;
        margin-top: 5px;
        margin-right: 10px;
        border-radius: 3px;
    }
    .filter_div {
        margin-top: 15px;
        margin-bottom: 15px;
        border-radius: 2px;
        border: unset;
        padding: 10px;
    }
    .filter_row {
        margin-left: unset;
        padding-left: 8px;
        padding-right: 9px;
        background-color: #F8F8F8;
        border: 1px solid#DEDEDE;
        border-radius: 16px;
        padding-top: 2px;
    }
    .date_p {
        margin: unset;
        font-size: 11px;
        color: #B3B3B3;
        font-weight: 500;
    }
    .date_selection {
        background-color: transparent;
        padding: unset;
        border: unset;
        color: #47D6B6;
        font-size: 11px;
    }
    .date_p:hover {
        color: #B3B3B3 !important;
    }
    .row_padding {
        padding-top: 10px !important;
        padding-bottom: 10px !important;
    }
    .filter_btn {
        padding: 4px;
        text-align: center;
        width: 5rem;
        padding-right: 6px;
        background-color: rgb(0, 254, 0);
        border-radius: 5px;
        cursor: pointer;
        color: white !important;
        margin: 0rem .5rem;
    }
    .content-position {
        padding-left: 15px !important;
        padding-right: 15px !important;
        color: white;
    }
    .top_button {
        font-size: 12px;
        font-weight: 600;
        color: #B3B3B3;
    }
    .print_btn {
        padding-right: 1%;
        padding-left: 1%;
    }
    .order_list_topic {
        color: black;
        font-size: 19px;
    }

    /* =====================================================================
       TAX REPORT — MOBILE LAYOUT
       ===================================================================== */
    .mobile-page-header { display: none; }
    .tr-m-ph { display: none; }                      /* mobile-only date placeholders */

    @media (min-width: 768px) {
        .mobile-page-header { display: none !important; }
        div#mobile-entries-sort-row { display: none; }   /* mobile-only control */
    }

    @media (max-width: 767px) {

        /* ---------- Page shell ---------- */
        .content-position {
            top: 0;                                  /* desktop: top -45px */
            padding-left: 16px !important;
            padding-right: 16px !important;
            background-color: transparent;
            color: initial;
        }
        /* Layout's generic title strip / desktop top bar: replaced by the page header */
        .main-content #header,
        .main-content .header1,
        .main-content > .navbar-top,
        .main-content > #navbar-main { display: none !important; }

        /* ---------- Filter card (same controls as desktop, mobile layout) ----------
           Start / End date side by side, Order Type full width,
           then Clear Filters + Filter. The CSV Export button is the header's Export. */
        .content-position .filter_div {
            margin: 0 0 14px;
            padding: 14px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(17, 24, 39, 0.06);
        }
        .content-position .filter_div > .row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 12px;
            margin: 0;
            padding: 0 !important;                   /* inline padding-left: 25px */
        }
        .content-position .filter_div > .row > * {
            min-width: 0;
            margin: 0 !important;                    /* inline margin-left / right: 20px */
        }
        .filter_div .tr-f-dates,
        .filter_div .tr-f-type { grid-column: 1 / -1; }
        .filter_div .tr-f-clear  { grid-column: 1; grid-row: 3; }
        .filter_div .tr-f-filter { grid-column: 2; grid-row: 3; }
        .filter_div .tr-f-export { display: none !important; }

        .filter_div .filter_row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 12px;
            margin: 0;
            padding: 0 !important;
            background: transparent;
            border: none;
            border-radius: 0;
        }
        .filter_div .tr-f-type .filter_row { grid-template-columns: minmax(0, 1fr); }
        .filter_div .filter_row > .date_p { display: none; }   /* "Date Range |", "Order Type |" */
        .filter_div .paymen_type_div { display: block; min-width: 0; padding: 0; }
        .filter_div .filter_row input,
        .filter_div .filter_row select {
            display: block;
            width: 100%;
            height: 44px;
            margin: 0;
            padding: 0 32px 0 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #f5f6f7 url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12'%3E%3Cpath d='M2.5 4.5 6 8l3.5-3.5' fill='none' stroke='%23374151' stroke-width='1.6' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") no-repeat right 12px center / 12px 12px;
            color: #111827;
            font-size: 15px;
            -webkit-appearance: none;
            appearance: none;
            outline: none;
        }
        .filter_div .filter_row input:focus,
        .filter_div .filter_row select:focus { border-color: #47D6B6; }
        /* Dates: input and its placeholder share one grid cell */
        .filter_div #start-date,
        .filter_div .tr-m-ph-start { grid-column: 1; grid-row: 1; }
        .filter_div #end-date,
        .filter_div .tr-m-ph-end   { grid-column: 2; grid-row: 1; }
        .filter_div .filter_row input[type="date"] { position: relative; }
        /* Native date icon: invisible but still tappable, over the chevron */
        .filter_div .filter_row input[type="date"]::-webkit-calendar-picker-indicator {
            position: absolute;
            right: 0;
            width: 40px;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        /* "Start Date" / "End Date" while a date is empty */
        .filter_div .tr-m-ph {
            display: flex;
            align-items: center;
            z-index: 2;
            min-width: 0;
            padding: 0 32px 0 13px;
            color: #9ca3af;
            font-size: 15px;
            white-space: nowrap;
            overflow: hidden;
            pointer-events: none;
        }
        .filter_div input.tr-has-value + .tr-m-ph,
        .filter_div input:focus + .tr-m-ph { display: none; }
        .filter_div input[type="date"]:not(.tr-has-value):not(:focus) { color: transparent; }

        /* Clear Filters (outline) / Filter (dark) */
        .filter_div .tr-f-clear > .row,
        .filter_div .tr-f-filter > .row { display: block; margin: 0; padding: 0 !important; }
        .filter_div #reset-filter,
        .filter_div #pin-filter {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            height: 44px;
            margin: 0;
            padding: 0;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
        }
        .filter_div #reset-filter {
            background: #fff !important;             /* inline: grey */
            border: 1px solid #e5e7eb;
            color: #6b7280 !important;
        }
        .filter_div #pin-filter {
            background: #111827;
            border: 1px solid #111827;
            color: #fff !important;
        }
        .filter_div #reset-filter i,
        .filter_div #pin-filter i { padding: 0 !important; font-size: 15px; }
        .filter_div #reset-filter:hover,
        .filter_div #pin-filter:hover { opacity: .92; }
        /* Wording from the design */
        .filter_div #reset-filter { font-size: 0; }
        .filter_div #reset-filter::after { content: "Clear Filters"; font-size: 15px; }

        .content-position > .col-md-12.mt-4 {
            margin-top: 0 !important;
            padding-left: 0;
            padding-right: 0;
        }
        /* One shared outer card: drop its box so the inner cards sit on the grey page */
        .content-position > .col-md-12 > .card {
            background: transparent;
            box-shadow: none;
            padding: 0;
            border-radius: 0;
        }
        .content-position > .col-md-12 > .card > .row {
            margin: 0;
            padding-left: 0 !important;              /* inline 1rem */
            padding-right: 0 !important;
        }
        .content-position > .col-md-12 > .card > .row > [class*="col-"] {
            padding-left: 0;
            padding-right: 0;
        }
        .content-position .new-style-table > .table-responsive { overflow: visible; }

        /* ---------- Page header: "< BACK TO HOME", title + Export ---------- */
        .mobile-page-header {
            display: block;
            margin: 4px 0 18px;
        }
        .mobile-back-link {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin: 6px 0 14px;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 1.2px;
            color: #4b5563;
            text-decoration: none;
        }
        .mobile-back-link i { font-size: 11px; }
        .mobile-page-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .mobile-page-title {
            margin: 0;
            min-width: 0;
            font-size: 20px;
            font-weight: 700;
            line-height: 1.25;
            color: #111827;
        }
        .mobile-export-btn {
            display: inline-flex;
            flex: 0 0 auto;
            align-items: center;
            gap: 8px;
            height: 42px;
            padding: 0 16px;
            border: none;
            border-radius: 8px;
            background: #47D6B6;
            color: #fff;
            font-size: 15px;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(71, 214, 182, 0.35);
        }
        /* Outline download icon (design) instead of the solid glyph */
        .export-icon-mobile { display: inline-flex; width: 17px; height: 17px; }
        .export-icon-desktop { display: none; }

        /* ---------- DataTables wrapper ---------- */
        #tax_report_table_wrapper > .row { margin-left: 0; margin-right: 0; }
        #tax_report_table_wrapper > .row > [class*="col-"] { padding-left: 0; padding-right: 0; }
        /* The page's own "Show / Sort by" row replaces DataTables' length menu */
        #tax_report_table_wrapper .dataTables_length { display: none !important; }

        /* ---------- Search card ---------- */
        #tax_report_table_wrapper .dataTables_filter {
            float: none;
            width: 100%;
            margin: 0 0 14px;
            padding: 14px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(17, 24, 39, 0.06);
            text-align: left;
        }
        #tax_report_table_wrapper .dataTables_filter label {
            position: relative;
            display: block;
            width: 100%;
            margin: 0;
            font-size: 0;                            /* only the icon + input are shown */
        }
        #tax_report_table_wrapper .dataTables_filter label i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: #111827;
            pointer-events: none;
        }
        #tax_report_table_wrapper .dataTables_filter input {
            display: block;
            width: 100% !important;
            height: 44px;
            margin: 0 !important;
            padding: 0 12px 0 40px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #f5f6f7;
            color: #111827;
            font-size: 15px;
            box-shadow: none;
            outline: none;
        }
        #tax_report_table_wrapper .dataTables_filter input::placeholder { color: #9ca3af; }

        /* ---------- "Show [20] entries" / "Sort by [Order ID]" ---------- */
        #mobile-entries-sort-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin: 0 0 4px;
            padding: 0;
        }
        #mobile-entries-sort-row .mobile-entries-group,
        #mobile-entries-sort-row .mobile-sort-group {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 0;
            white-space: nowrap;
        }
        #mobile-entries-sort-row .mobile-entries-group { flex: 0 0 auto; }
        #mobile-entries-sort-row .date_p {
            font-size: 14px;
            color: #6b7280;
        }
        #mobile-entries-sort-row select {
            min-width: 0;
            height: 34px;
            padding: 0 28px 0 10px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12'%3E%3Cpath d='M2.5 4.5 6 8l3.5-3.5' fill='none' stroke='%23374151' stroke-width='1.6' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") no-repeat right 9px center / 11px 11px;
            color: #111827;
            font-size: 14px;
            font-weight: 500;
            text-overflow: ellipsis;
            -webkit-appearance: none;
            appearance: none;
        }
        #entries-select-m { flex: 0 0 auto; }

        /* ---------- Table -> order cards ---------- */
        #tax_report_table {
            display: block;
            width: 100% !important;
            margin: 10px 0 0 !important;
            border: none;
        }
        #tax_report_table > thead { display: none; }
        #tax_report_table > tbody { display: block; width: 100%; }

        #tax_report_table > tbody > tr {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            column-gap: 10px;
            min-height: 0;
            margin-bottom: 14px;
            padding: 16px 16px 14px;
            background: #fff !important;
            border: 1px solid #f0f1f3 !important;
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(17, 24, 39, 0.06);
        }
        #tax_report_table > tbody > tr:hover { background: #fff !important; }
        #tax_report_table > tbody > tr > td {
            display: block;
            box-sizing: border-box;                  /* DataTables sets content-box */
            min-width: 0;
            padding: 0 !important;
            border: none !important;
            text-align: left !important;
            text-align-last: auto !important;        /* inline text-align-last */
            font-size: 13px !important;              /* page rule: .9rem !important */
            color: #111827 !important;
            white-space: normal;                     /* theme tables use nowrap */
            overflow-wrap: anywhere;
        }
        #tax_report_table > tbody > tr > td a { padding: 0 !important; }       /* page rule: .4rem 1rem !important */

        /* Line 1: "#002905" + status pill */
        #tax_report_table > tbody > tr > td.order-no { order: 1; flex: 1 1 auto; }
        #tax_report_table > tbody > tr > td.order-no,
        #tax_report_table > tbody > tr > td.order-no a {
            font-size: 18px !important;
            font-weight: 700;
            line-height: 1.3;
            color: #111827 !important;
            text-decoration: none;
        }
        #tax_report_table > tbody > tr > td.order-no a::before { content: "#"; }
        #tax_report_table > tbody > tr > td.order-status {
            order: 2;
            flex: 0 0 auto;
            padding: 3px 10px !important;
            border-radius: 999px;
            background: #e5e7eb;                     /* JS sets the status colour inline */
            font-size: 12px !important;
            font-weight: 500;
            line-height: 1.4;
            white-space: nowrap;
        }

        /* Line 2-3: organization, "State  Southern" */
        #tax_report_table > tbody > tr > td.org-name {
            order: 3;
            flex: 0 0 100%;
            margin-top: 2px;
            font-size: 15px !important;
        }
        #tax_report_table > tbody > tr > td.state {
            order: 4;
            flex: 0 0 100%;
            margin-top: 4px;
        }
        #tax_report_table > tbody > tr > td.state::before {
            content: "State";
            margin-right: 10px;
            color: #8a8f98;
        }

        /* Line 4: Order Total ($) / Sales Tax(%) / Sales Tax($) boxes */
        #tax_report_table > tbody > tr > td.order-total    { order: 5; }
        #tax_report_table > tbody > tr > td.sales-tax-rate { order: 6; }
        #tax_report_table > tbody > tr > td.sales-tax      { order: 7; }
        #tax_report_table > tbody > tr > td.order-total,
        #tax_report_table > tbody > tr > td.sales-tax-rate,
        #tax_report_table > tbody > tr > td.sales-tax {
            flex: 0 0 calc((100% - 20px) / 3 - 0.5px);
            align-self: stretch;
            margin-top: 12px;
            padding: 7px 8px 8px !important;
            background: #f3f4f6;
            border-radius: 8px;
            font-size: clamp(13px, 3.9vw, 16px) !important;
            font-weight: 400;
            line-height: 1.35;
        }
        #tax_report_table > tbody > tr > td.order-total::before,
        #tax_report_table > tbody > tr > td.sales-tax-rate::before,
        #tax_report_table > tbody > tr > td.sales-tax::before {
            display: block;
            margin-bottom: 1px;
            font-size: clamp(10.5px, 3.15vw, 15px);
            color: #8a8f98;
            white-space: nowrap;
        }
        #tax_report_table > tbody > tr > td.order-total::before    { content: "Order Total ($)"; }
        #tax_report_table > tbody > tr > td.sales-tax-rate::before { content: "Sales Tax(%)"; }
        #tax_report_table > tbody > tr > td.sales-tax::before      { content: "Sales Tax($)"; }
        /* The unit is in the label (design): show the value without "$" / "%".
           Set by JS in data-m-val; the cell text itself is unchanged. */
        #tax_report_table > tbody > tr > td[data-m-val] { font-size: 0 !important; }
        #tax_report_table > tbody > tr > td[data-m-val]::after {
            content: attr(data-m-val);
            font-size: clamp(13px, 3.9vw, 16px);
        }
        #tax_report_table > tbody > tr > td[data-m-val]::before { font-size: clamp(10.5px, 3.15vw, 15px); }

        /* Dashed divider, then Sales Rep (left) / Production Date (right) */
        #tax_report_table > tbody > tr::after {
            content: "";
            order: 8;
            flex: 0 0 100%;
            height: 0;
            margin-top: 14px;
            border-top: 1px dashed #e5e7eb;
        }
        #tax_report_table > tbody > tr > td.sales-person,
        #tax_report_table > tbody > tr > td.production-date {
            display: flex;
            align-items: baseline;
            margin-top: 10px;
            font-size: 11.5px !important;
            white-space: nowrap;
        }
        #tax_report_table > tbody > tr > td.sales-person {
            order: 9;
            flex: 1 1 60px;                          /* not 0: it must wrap under the divider */
            margin-right: -10px;                     /* cancel the gap: the date is pushed right */
            overflow: hidden;
        }
        #tax_report_table > tbody > tr > td.production-date {
            order: 10;
            flex: 0 0 auto;
            margin-left: auto;
        }
        #tax_report_table > tbody > tr > td.sales-person::before,
        #tax_report_table > tbody > tr > td.production-date::before {
            flex: 0 0 auto;
            margin-right: 5px;
            color: #8a8f98;
        }
        #tax_report_table > tbody > tr > td.sales-person::before    { content: "Sales Rep"; }
        #tax_report_table > tbody > tr > td.production-date::before { content: "Production Date"; }
        /* Long names shrink with "…" so the date always stays on the same line */
        #tax_report_table > tbody > tr > td.sales-person span,
        #tax_report_table > tbody > tr > td.production-date span {
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            font-weight: 600;
        }
        #tax_report_table > tbody > tr > td.sales-person span { padding-right: 6px; }

        /* "No data available" row */
        #tax_report_table > tbody > tr > td.dataTables_empty {
            display: block;
            flex: 1 1 100%;
            padding: 6px 0 !important;
            font-size: 14px !important;
            text-align: center !important;
            color: #6b7280 !important;
        }
        #tax_report_table > tbody > tr:has(> td.dataTables_empty)::after { display: none; }

        /* Totals (desktop footer row): kept as a small summary card */
        #tax_report_table > tfoot {
            display: block;
            margin-bottom: 14px;
            padding: 8px 16px;
            background: #fff;
            border: 1px solid #f0f1f3;
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(17, 24, 39, 0.06);
        }
        #tax_report_table > tfoot > tr {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 0;
            background: transparent !important;
            border: none !important;
        }
        #tax_report_table > tfoot th {
            padding: 0 !important;
            border: none !important;
            background: transparent !important;
            font-size: 14px !important;              /* inline 1.2rem / 1rem */
            text-transform: none;
            letter-spacing: 0;
        }
        #tax_report_table > tfoot th:first-child { font-weight: 400; color: #6b7280 !important; }
        #tax_report_table > tfoot th:last-child  { font-weight: 700; color: #111827 !important; }

        /* ---------- Pager: "Showing x to y of z entries" + buttons ---------- */
        #tax_report_table_wrapper > .row:last-child {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-top: 6px;
        }
        #tax_report_table_wrapper > .row:last-child > [class*="col-"] {
            flex: 0 1 auto;
            width: auto;
            max-width: none;
        }
        #tax_report_table_wrapper .dataTables_info {
            padding: 0 !important;
            font-size: 13px;
            color: #9ca3af;
            white-space: normal;
        }
        #tax_report_table_wrapper .dataTables_paginate { margin: 0 !important; }
        #tax_report_table_wrapper .pagination {
            flex-wrap: wrap;
            justify-content: flex-end !important;
            gap: 6px;
            margin: 0 !important;
        }
        #tax_report_table_wrapper .page-item .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            margin: 0;
            padding: 0 8px;
            border: 1px solid #e5e7eb;
            border-radius: 6px !important;
            background: #fff;
            color: #111827;
            font-size: 14px;
            box-shadow: none;
        }
        #tax_report_table_wrapper .page-item.active .page-link {
            background: #111827;
            border-color: #111827;
            color: #fff;
        }
        #tax_report_table_wrapper .page-item.disabled .page-link { color: #9ca3af; }
        /* "Previous" / "Next" -> ‹ › */
        #tax_report_table_wrapper .page-item.previous .page-link,
        #tax_report_table_wrapper .page-item.next .page-link { font-size: 0; }
        #tax_report_table_wrapper .page-item.previous .page-link::before,
        #tax_report_table_wrapper .page-item.next .page-link::before {
            font-size: 20px;
            line-height: 1;
        }
        #tax_report_table_wrapper .page-item.previous .page-link::before { content: "\2039"; }
        #tax_report_table_wrapper .page-item.next .page-link::before     { content: "\203A"; }
    }

    /* Phones up to 400px: a little smaller so typical rep names fit in full */
    @media (max-width: 400px) {
        #tax_report_table > tbody > tr > td.sales-person,
        #tax_report_table > tbody > tr > td.production-date { font-size: 11px !important; letter-spacing: -0.15px; }
        #tax_report_table > tbody > tr > td.sales-person { margin-right: -6px; letter-spacing: -0.15px; }   /* 4px gap before the date */
        #tax_report_table > tbody > tr > td.sales-person span { padding-right: 0; }
        #tax_report_table > tbody > tr > td.sales-person::before,
        #tax_report_table > tbody > tr > td.production-date::before { margin-right: 3px; }
    }

    /* Very small phones (320px - 359px) */
    @media (max-width: 359px) {
        .content-position {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }
        .mobile-page-title { font-size: 18px; }
        .mobile-export-btn { height: 38px; padding: 0 12px; font-size: 14px; }
        .content-position .filter_div { padding: 12px; }
        .content-position .filter_div > .row,
        .filter_div .filter_row { gap: 10px; }
        .filter_div .filter_row input,
        .filter_div .filter_row select,
        .filter_div .tr-m-ph { font-size: 14px; padding-right: 26px; background-position: right 9px center; }
        .filter_div .tr-m-ph { padding-left: 11px; }
        .filter_div #reset-filter::after,
        .filter_div #pin-filter { font-size: 14px; }
        #mobile-entries-sort-row .date_p { font-size: 12px; }
        #mobile-entries-sort-row select { font-size: 12px; padding: 0 22px 0 8px; background-position: right 7px center; }
        #tax_report_table > tbody > tr { padding: 14px 12px 12px; column-gap: 8px; }
        #tax_report_table > tbody > tr > td.order-total,
        #tax_report_table > tbody > tr > td.sales-tax-rate,
        #tax_report_table > tbody > tr > td.sales-tax {
            flex-basis: calc((100% - 16px) / 3 - 0.5px);
            padding: 6px 6px 7px !important;
        }
        #tax_report_table > tbody > tr > td.sales-person { margin-right: -8px; }
    }
</style>

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="mobile-page-header">
        {{-- <a href="{{ route('home') }}" class="mobile-back-link"><i class="fa fa-chevron-left"></i> BACK TO HOME</a> --}}
        <div class="mobile-page-header-row">
            <h5 class="mobile-page-title">Tax Report</h5>
            <button type="button" class="mobile-export-btn" onclick="exportReport()">
                <i class="fa fa-download export-icon-desktop"></i>
                <svg class="export-icon-mobile" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                Export
            </button>
        </div>
    </div>

    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="row" style="padding-left: 1rem;padding-right: 1rem;">
                <div class="col-md-12">
                    <div class="card filter_div">
                        @php
                            $startDate = request()->get('start_date') ?? '';
                            $endDate = request()->get('end_date') ?? '';
                            $orderType = request()->get('order_type') ?? 'all';
                            $salesTaxSum = 0;
                            $numberOfOrders = count($orders);
                        @endphp
                        <div class="row" style="padding-left: 25px;">
                            <div class="tr-f-dates" style="margin-right: 20px;">
                                <div class="row filter_row">
                                    <p class="font_color date_p">Date Range | </p>
                                    <input class="date_selection" type="date" id="start-date" name="start-date" max="" value="{{ $startDate }}">
                                    <span class="tr-m-ph tr-m-ph-start">Start Date</span>
                                    <p class="font_color date_p">&nbsp; &nbsp; &nbsp;</p>
                                    <input class="date_selection" type="date" id="end-date" name="end-date" max="" value="{{ $endDate }}">
                                    <span class="tr-m-ph tr-m-ph-end">End Date</span>
                                </div>
                            </div>
                            <div class="tr-f-type" style="margin-right: 20px;">
                                <div class="row filter_row" style="padding-bottom: 2px;">
                                    <p class="font_color date_p">Order Type |  </p>
                                    <div class="paymen_type_div date_selection">
                                        <select id="orderType" class="date_selection">
                                            <option value="all" {{ $orderType == 'all' ? 'selected' : '' }}>All Orders</option>
                                            <option value="tsr" {{ $orderType == 'tsr' ? 'selected' : '' }}>Team Store Orders</option>
                                            <option value="bulk" {{ $orderType == 'bulk' ? 'selected' : '' }}>Bulk Orders</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="tr-f-filter" style="margin-left: 20px;">
                                <div class="row" style="padding-bottom: 2px;">
                                    <a href="#" class="date_p filter_btn" id="pin-filter" title="Filter">
                                        <i class="fa fa-filter" style="padding-left: 5px; padding-top: 4px; padding-right: 5px;"></i>
                                        Filter
                                    </a>
                                </div>
                            </div>
                            <div class="tr-f-clear" style="margin-left: 20px;">
                                <div class="row" style="padding-bottom: 2px;">
                                    <a href="#" class="date_p filter_btn" id="reset-filter" title="Filter" style="background-color:#b3b3b3">
                                        <i class="fa fa-times" style="padding-left: 5px; padding-top: 4px; padding-right: 5px;"></i>
                                        Clear
                                    </a>
                                </div>
                            </div>
                            @can('create people')
                                <button class="styled-button ml-auto tr-f-export" style="outline: unset;" href="#" onclick="exportReport()" title="Export CSV">
                                    CSV Export
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="col-md-12 new-style-table">
                    <div class="table-responsive">
                        <table class="table align-items-center table-responsive" id="tax_report_table">
                            <thead class="header-style">
                                <th style="text-align: center;" class="order-no" scope="col">Order #</th>
                                <th style="text-align: center;" class="org-name" scope="col">Organization Name</th>
                                <th style="text-align: center;" class="state" scope="col">State</th>
                                <th style="text-align: center;" class="sales-person" scope="col">Sales Person</th>
                                <th style="text-align: center;" class="production-date" scope="col">Production Date</th>
                                <th style="text-align: center;" class="order-status" scope="col">Order Status</th>
                                <th style="text-align: center;" class="order-total" scope="col">Order Total</th>
                                <th style="text-align: center;" class="sales-tax-rate" scope="col">Sales Tax Rate(%)</th>
                                <th style="text-align: center;" class="sales-tax" scope="col">Sales Tax ($)</th>
                            </thead>

                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td style="text-align-last: left;" class="order-no">
                                            <a href="#" class="edit-order" data-value="{{$order->order_no}}">{{$order->order_no}}</a>
                                        </td>
                                        <td style="text-align-last: left;" class="org-name">{{ $order->organizationDetails->organization_name ?? 'N/A' }}</td>
                                        <td style="text-align-last: left;" class="state">{{ $order->organizationDetails->shipping_state ?? 'N/A' }}</td>
                                        <td style="text-align-last: left;" class="sales-person"><span title="{{ $order->userDetails->name ?? 'N/A' }}">{{ $order->userDetails->name ?? 'N/A' }}</span></td>
                                        @php $productionDateText = $order->production_date ? \Carbon\Carbon::parse($order->production_date)->format('m/d/Y') : 'N/A'; @endphp
                                        <td style="text-align-last: center;" class="production-date"><span title="{{ $productionDateText }}">{{ $productionDateText }}</span></td>
                                        <td style="text-align-last: right;" class="order-status">{{ $order->statusDetails->status_name }}</td>
                                        <td style="text-align-last: right;" class="order-total">$ {{ number_format($order->sub_total, 2) }}</td>
                                        <td style="text-align-last: right;" class="sales-tax-rate">{{ $order->sales_tax_rate ?? '0' }}%</td>
                                        <td style="text-align-last: right;" class="sales-tax">$ {{ number_format($order->sales_tax ?? 0, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="8" style="text-align: right;font-size: 1.2rem;color:black">Total Sales Tax:</th>
                                    <th style="text-align: right;font-size: 1.2rem;color:black">$ {{ number_format($orders->sum('sales_tax'), 2) }}</th>
                                </tr>
                                <tr>
                                    <th colspan="8" style="text-align: right;font-size: 1rem;color:black">Number of Orders:</th>
                                    <th style="text-align: right;font-size: 1rem;color:black">{{ $numberOfOrders }}</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="mobile-entries-sort-row" id="mobile-entries-sort-row">
        <div class="mobile-entries-group">
            <span class="date_p">Show</span>
            <select id="entries-select-m">
                <option value="10">10</option>
                <option value="20" selected>20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span class="date_p">entries</span>
        </div>
        <div class="mobile-sort-group">
            <span class="date_p">Sort by</span>
            <select id="sort-select-m">
                <option value="order_no">Order ID</option>
                <option value="production_date">Production Date</option>
            </select>
        </div>
    </div>
</div>

<script>
    // Mobile-only status pill coloring for the Order Status cell
    var taxReportStatusColors = {
        'production':    { bg: '#dbeafe', color: '#1e40af' },
        'in production': { bg: '#dbeafe', color: '#1e40af' },
        'fulfilled':     { bg: '#e5e7eb', color: '#111827' },
        'fullfiled':     { bg: '#e5e7eb', color: '#111827' },
        'fullfilled':    { bg: '#e5e7eb', color: '#111827' },
        'completed':     { bg: '#d7ffcc', color: '#1a7a4c' },
        'shipped':       { bg: '#d7ffcc', color: '#1a7a4c' },
        'approved':      { bg: '#d7ffcc', color: '#1a7a4c' },
        'pending':       { bg: '#fef3c7', color: '#92400e' },
        'cancelled':     { bg: '#fee2e2', color: '#b91c1c' }
    };

    function colorizeTaxReportStatus() {
        if (window.innerWidth > 767) { return; }
        $('#tax_report_table tbody td.order-status').each(function () {
            var $cell = $(this);
            if ($cell.data('colorized')) { return; }
            var text = $.trim($cell.text());
            var style = taxReportStatusColors[text.toLowerCase()] || { bg: '#e5e7eb', color: '#111827' };
            $cell.css({ background: style.bg, color: style.color }).data('colorized', true);
        });
    }

    // Mobile: the box labels already carry the unit ("Order Total ($)",
    // "Sales Tax(%)"), so show the values without "$" / "%" like the design.
    // Stored in data-m-val only; the cell text is unchanged.
    function setTaxReportMobileValues() {
        if (window.innerWidth > 767) { return; }
        $('#tax_report_table > tbody > tr > td').filter('.order-total, .sales-tax-rate, .sales-tax').each(function () {
            var value = $.trim($(this).text()).replace(/[$%\s]/g, '');
            if (value !== '') { this.setAttribute('data-m-val', value); }
        });
    }

    $(document).ready(function () {
        var tax_report_table = $('#tax_report_table').DataTable({
            lengthMenu: [100, 300, 500],
            pageLength: 100,
            order: [[4, 'asc']],
            columnDefs: [
                {
                    targets: ['production-date', 'created-at'],
                    type: 'date',
                }
            ],
            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'Search by order id'
            },
            initComplete: function () {
                if (window.innerWidth <= 767) {
                    $('#mobile-entries-sort-row')
                        .insertAfter($(this).closest('.dataTables_wrapper').find('.dataTables_filter'));
                    // Figma shows "Show 20 entries" by default on mobile;
                    // desktop keeps its own pageLength: 100 default.
                    this.api().page.len(20).draw();
                }
            },
            drawCallback: function () {
                colorizeTaxReportStatus();
                setTaxReportMobileValues();
            }
        });

        $('#entries-select-m').on('change', function () {
            tax_report_table.page.len(parseInt(this.value, 10)).draw();
        });

        $('#sort-select-m').on('change', function () {
            if (this.value === 'order_no') {
                tax_report_table.order([0, 'asc']).draw();
            } else if (this.value === 'production_date') {
                tax_report_table.order([4, 'asc']).draw();
            }
        });
    });

    /* Mobile: place the page header 16px below the layout's fixed mobile bar(s).
       The space above comes from the layout, so it is measured, not guessed. */
    (function () {
        var trMobileQuery = window.matchMedia('(max-width: 767px)');
        function fixTrHeaderOffset() {
            var top = document.querySelector('.mobile-page-header');
            var nav = document.getElementById('sidenav-main');
            if (!top) return;
            top.style.marginTop = '';
            if (!trMobileQuery.matches || !nav || getComputedStyle(nav).position !== 'fixed') return;

            var barBottom = nav.getBoundingClientRect().bottom;
            document.querySelectorAll('.main-content nav, .main-content .navbar').forEach(function (el) {
                var cs = getComputedStyle(el), r = el.getBoundingClientRect();
                if (cs.position === 'fixed' && cs.display !== 'none' && cs.visibility !== 'hidden' && r.height > 0 && r.top <= 5) {
                    barBottom = Math.max(barBottom, r.bottom);
                }
            });
            // Margins can collapse with the layout's margins: adjust, re-measure, correct
            for (var i = 0; i < 5; i++) {
                var diff = Math.round(barBottom + 16 - (top.getBoundingClientRect().top + window.pageYOffset));
                if (Math.abs(diff) <= 1) break;
                top.style.marginTop = (parseFloat(getComputedStyle(top).marginTop) + diff) + 'px';
            }
        }
        $(function () {
            fixTrHeaderOffset();
            setTimeout(fixTrHeaderOffset, 350);
            setTimeout(fixTrHeaderOffset, 1300);
        });
        window.addEventListener('load', fixTrHeaderOffset);   // logo size changes the bar height
        var trResizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(trResizeTimer);
            trResizeTimer = setTimeout(fixTrHeaderOffset, 150);
        });
    })();

    function exportReport() {
        $('.se-pre-con').fadeIn();

        let startDate = $('#start-date').val();
        let endDate = $('#end-date').val();
        let orderType = $('#orderType').val();

        $.ajax({
            url: "{{ route('tax_report.export') }}",
            method: "POST",
            data: {
                start_date: startDate,
                end_date: endDate,
                order_type: orderType,
                _token: "{{ csrf_token() }}"
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response, status, xhr) {
                let filename = "tax_report.xlsx";
                let disposition = xhr.getResponseHeader('Content-Disposition');
                if (disposition && disposition.indexOf('filename=') !== -1) {
                    filename = disposition.split('filename=')[1].replace(/"/g, '');
                }

                let link = document.createElement('a');
                link.href = window.URL.createObjectURL(response);
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            },
            complete: function() {
                $('.se-pre-con').fadeOut();
            },
            error: function(err) {
                alert("Error exporting report. Please try again.");
            }
        });
    }

    $("body").on("click", ".edit-order", function(){
        var orderId = $(this).data('value');
        window.open('order_details/edit/'+orderId+'/order?active_tab=order', '_blank');
    });
    $('#pin-filter').on('click', function() {
        var startDate = $('#start-date').val();
        var endDate = $('#end-date').val();
        var orderType = $('#orderType').val();
        var url = "{{ url('tax_report') }}";
        var queryParams = [];

        if (startDate) {
            queryParams.push('start_date=' + encodeURIComponent(startDate));
        }
        if (endDate) {
            queryParams.push('end_date=' + encodeURIComponent(endDate));
        }
        if (orderType) {
            queryParams.push('order_type=' + encodeURIComponent(orderType));
        }

        if (queryParams.length > 0) {
            url += '?' + queryParams.join('&');
        }

        window.location.href = url;
    });
    // Mobile: hide the "Start Date" / "End Date" placeholder once a date is set
    function trSyncDatePlaceholders() {
        $('#start-date, #end-date').each(function () {
            $(this).toggleClass('tr-has-value', !!this.value);
        });
    }
    $('#start-date, #end-date').on('input change', trSyncDatePlaceholders);
    trSyncDatePlaceholders();

    $('#reset-filter').on('click', function() {
        window.location.href = "{{ url('tax_report') }}";
    });
</script>
@endsection