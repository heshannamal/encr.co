@extends('layouts.app', ['activePage' => 'allTransactions', 'titlePage' => __('Payments')])

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
    @media (min-width: 768px) {
        #transactions_table_wrapper .dataTables_filter input {
            width: clamp(13rem, 24vw, 20rem);
            max-width: 100%;
        }
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
    .payment-check-preview {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(min(100%, 270px), 1fr));
        gap: 16px;
    }
    .payment-check-preview img {
        display: block;
        width: 100%;
        max-height: 55vh;
        object-fit: contain;
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
        border: 1px solid #DEDEDE;
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
       RECEIVED PAYMENTS — MOBILE LAYOUT
       ===================================================================== */
    .mobile-page-header { display: none; }
    .mobile-action-label { display: none; }

    @media (min-width: 768px) {
        #filter_div_mobile { display: none; }
        div#mobile-entries-sort-row { display: none; }
    }

    @media (max-width: 767px) {

        /* ---------- Page shell ---------- */
        .content-position {
            padding-left: 16px !important;
            padding-right: 16px !important;
            background-color: transparent;
        }
        .content-position > .col-md-12 {
            padding-left: 0;
            padding-right: 0;
        }
        /* Layout's generic title strip / desktop top bar: replaced by the page header below */
        .main-content #header,
        .main-content .header1,
        .main-content > .navbar-top,
        .main-content > #navbar-main { display: none !important; }

        /* One shared outer card wraps everything; drop its box so the inner
           cards sit on the grey page background like the design */
        .content-position > .col-md-12 > .card {
            background: transparent;
            box-shadow: none;
            padding: 0;
            border-radius: 0;
        }
        .content-position > .col-md-12 > .card > .row {
            margin: 0;
            padding-left: 0 !important;                /* inline 1rem */
            padding-right: 0 !important;
        }
        .content-position > .col-md-12 > .card > .row > .col-md-12 {
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
            font-size: clamp(18px, 5.2vw, 20px);
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

        /* ---------- Filter card ---------- */
        #filter_div_desktop { display: none !important; }
        #filter_div_mobile {
            display: block;
            margin: 0 0 14px;
            padding: 14px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(17, 24, 39, 0.06);
        }
        #filter_div_mobile .filter-grid-mobile {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 12px;
            padding: 0;
        }
        #filter_div_mobile .filter-col { width: auto; min-width: 0; }
        #filter_div_mobile .filter-col-full { grid-column: 1 / -1; }
        #filter_div_mobile .filter-buttons-row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 12px;
        }
        #filter_div_mobile .filter_row {
            position: relative;
            display: block;
            margin: 0;
            padding: 0;
            background: transparent;
            border: none;
            border-radius: 0;
            box-shadow: none;
        }
        /* The labels are used as placeholders (design): shown inside an empty date field */
        #filter_div_mobile .filter_row .date_p { display: none; }
        #filter_div_mobile .filter_row.is-empty .date_p {
            display: block;
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 2;                              /* above the (positioned) date input */
            margin: 0 !important;
            font-size: 15px;
            color: #9ca3af !important;
            white-space: nowrap;
            pointer-events: none;                    /* taps still open the date picker */
        }
        #filter_div_mobile .filter_row.is-empty:focus-within .date_p { display: none; }
        #filter_div_mobile .filter_row.is-empty input:not(:focus),
        #filter_div_mobile .filter_row.is-empty input:not(:focus)::-webkit-datetime-edit { color: transparent; }

        #filter_div_mobile .filter_row input,
        #filter_div_mobile .filter_row select {
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
        #filter_div_mobile .filter_row select.is-all { color: #9ca3af; }
        #filter_div_mobile .filter_row select option { color: #111827; }
        /* Native date icon: invisible but still tappable, over the chevron */
        #filter_div_mobile .filter_row input[type="date"] { position: relative; }
        #filter_div_mobile .filter_row input[type="date"]::-webkit-calendar-picker-indicator {
            position: absolute;
            right: 0;
            width: 40px;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        #filter_div_mobile .clear_filter_btn,
        #filter_div_mobile .filter_btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            height: 44px;
            margin: 0;
            padding: 0;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
        }
        #filter_div_mobile .clear_filter_btn {
            background: #fff;
            border: 1px solid #e5e7eb;
            color: #6b7280 !important;
        }
        #filter_div_mobile .filter_btn {
            background: #111827;
            border: 1px solid #111827;
            color: #fff !important;
        }

        /* ---------- DataTables wrapper ---------- */
        #transactions_table_wrapper > .row { margin-left: 0; margin-right: 0; }
        #transactions_table_wrapper > .row > [class*="col-"] { padding-left: 0; padding-right: 0; }
        /* The page's own "Show / Sort by" row replaces DataTables' length menu */
        #transactions_table_wrapper .dataTables_length { display: none !important; }

        /* ---------- Search card ---------- */
        #transactions_table_wrapper .dataTables_filter {
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
        #transactions_table_wrapper .dataTables_filter label {
            position: relative;
            display: block;
            width: 100%;
            margin: 0;
            font-size: 0;                            /* only the icon + input are shown */
        }
        #transactions_table_wrapper .dataTables_filter label i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: #111827;
            pointer-events: none;
        }
        #transactions_table_wrapper .dataTables_filter input {
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
        #transactions_table_wrapper .dataTables_filter input::placeholder { color: #9ca3af; }

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
            white-space: nowrap;
        }
        #mobile-entries-sort-row .date_p {
            font-size: 14px;
            font-weight: 400;
            color: #6b7280 !important;
        }
        /* "Select all" - its own line under Show / Sort by, checkbox lined up
           with the checkboxes in the cards */
        #mobile-entries-sort-row { flex-wrap: wrap; row-gap: 12px; }
        #mobile-entries-sort-row .rp-m-select-all {
            display: flex;
            flex: 0 0 100%;
            order: 3;
            align-items: center;
            gap: 10px;
            margin: 2px 0 -4px;
            padding: 0 17px;
            color: #111827;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            -webkit-user-select: none;
            user-select: none;
        }
        #mobile-entries-sort-row .rp-m-select-all input {
            flex: 0 0 auto;
            width: 18px;
            height: 18px;
            margin: 0;
            accent-color: #47D6B6;
            cursor: pointer;
        }
        #mobile-entries-sort-row .rp-m-select-all input:disabled { opacity: .45; cursor: default; }
        #mobile-entries-sort-row .rp-m-select-all input:disabled + span { color: #9ca3af; }
        #mobile-entries-sort-row .rp-m-selected-count { margin-left: auto; color: #6b7280; font-size: 13px; font-weight: 400; }
        #mobile-entries-sort-row select {
            height: 34px;
            padding: 0 28px 0 10px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12'%3E%3Cpath d='M2.5 4.5 6 8l3.5-3.5' fill='none' stroke='%23374151' stroke-width='1.6' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") no-repeat right 9px center / 11px 11px;
            color: #111827;
            font-size: 14px;
            font-weight: 500;
            -webkit-appearance: none;
            appearance: none;
        }

        /* ---------- Table -> payment cards ----------
           Only the main payment rows (#transactions_table > tbody > tr:not(.payment-log-detail-row)) are turned into cards. The expanded
           Store payment rows (.payment-log-detail-row) and their nested table
           are styled separately further down. */
        #transactions_table {
            display: block;
            width: 100% !important;
            margin: 10px 0 0 !important;
            border: none;
        }
        #transactions_table > thead { display: none; }
        #transactions_table > tbody { display: block; width: 100%; }

        #transactions_table > tbody > tr:not(.payment-log-detail-row) {
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
        #transactions_table > tbody > tr:not(.payment-log-detail-row):hover { background: #fff !important; }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td {
            display: block;
            box-sizing: border-box;                  /* DataTables sets content-box */
            min-width: 0;
            padding: 0 !important;
            border: none !important;
            text-align: left !important;
            text-align-last: auto !important;        /* inline text-align-last */
            font-size: 13px !important;              /* page rule: .9rem !important */
            color: #111827 !important;
            overflow-wrap: anywhere;
        }
        /* Links inside the card: drop the page's table-link padding (.4rem 1rem !important) */
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td a { padding: 0 !important; }

        /* Not in the design: customer name; order payment status (Paid / Pending) */
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(7),
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(10) { display: none; }

        /* Line 1: [checkbox] payment id ...... [check status] [Sync]
           The first cell (QuickBooks icon + checkbox) is "unwrapped" with
           display: contents so its checkbox can sit before the id. The Sync
           status is drawn after the check status (td 8), green when the row
           has the "synced" icon, red otherwise. */
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(1),
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(1) > div { display: contents !important; }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(1) .transaction-checkbox {
            order: 0;
            flex: 0 0 auto;
            width: 18px;
            height: 18px;
            margin: 0 2px 0 0;
            accent-color: #47D6B6;
            cursor: pointer;
        }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(1) .transaction-checkbox:disabled { cursor: default; opacity: .45; }
        /* The small desktop icons are replaced by the "Sync" status below */
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(1) > div > i,
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(1) > div > .parent-qb-status-icon { display: none !important; }
        /* "Sync" status: green when synced to QuickBooks, red when not (yet) */
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(8)::after {
            content: "Sync";
            flex: 0 0 auto;
            display: inline-flex;
            align-items: center;
            padding: 3px 9px 3px 25px;
            border-radius: 999px;
            background: #fde4e4 url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23e01e1e' stroke-width='2.4' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M20 12a8 8 0 0 0-14.3-4.9'/%3E%3Cpath d='M4 4v4h4'/%3E%3Cpath d='M4 12a8 8 0 0 0 14.3 4.9'/%3E%3Cpath d='M20 20v-4h-4'/%3E%3C/svg%3E") no-repeat 8px center / 13px 13px;
            color: #e01e1e;
            font-size: 12px;
            font-weight: 600;
            line-height: 1.4;
            white-space: nowrap;
        }
        #transactions_table > tbody > tr:not(.payment-log-detail-row):has(> td:nth-child(1) .fa-check-circle) > td:nth-child(8)::after {
            background-color: #e3f6ea;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%231f9d55' stroke-width='2.4' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M20 12a8 8 0 0 0-14.3-4.9'/%3E%3Cpath d='M4 4v4h4'/%3E%3Cpath d='M4 12a8 8 0 0 0 14.3 4.9'/%3E%3Cpath d='M20 20v-4h-4'/%3E%3C/svg%3E");
            color: #1f9d55;
        }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(2)  { order: 1; flex: 1 0 auto; width: auto !important; min-width: max-content; white-space: nowrap; }
        /* Status + Sync are one group, so they always stay side by side on the right */
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(8)  {
            order: 2;
            flex: 0 0 auto;
            display: flex !important;
            align-items: center;
            gap: 6px;
            margin-left: auto;
            white-space: nowrap;
        }

        /* "Import to Quickbooks" (moved by JS on phones to just below the search
           box, above "Show / Sort by"): a full-width button while payments are
           selected. The existing code shows / hides it. */
        #transactions_table_wrapper .import-to-quickbooks.rp-m-import { display: none; }
        #transactions_table_wrapper .import-to-quickbooks.rp-m-import:not([style*="display:none"]):not([style*="display: none"]) {
            display: flex !important;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            height: 46px;
            margin: 0 0 14px;
            padding: 0 16px;
            border: none;
            border-radius: 10px;
            background-color: #47D6B6 !important;
            box-shadow: 0 4px 12px rgba(71, 214, 182, 0.35);
            color: #fff !important;
            font-size: 15px;
            font-weight: 600;
        }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(2),
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(2) a {
            font-size: 17px !important;
            font-weight: 700;
            line-height: 1.3;
            color: #111827 !important;
            text-decoration: none;
        }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(2) .show_store_payments {
            margin-right: 6px !important;
            font-size: 12px !important;
            color: #111827 !important;
        }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(8) .badge,
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(10) .badge {
            display: inline-block;
            width: auto !important;                  /* inline width: 100% */
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 500;
            line-height: 1.4;
            letter-spacing: 0;
            text-transform: none;
            white-space: nowrap;
        }
        /* Design colours (badge colours are set inline) */
        #transactions_table .badge[style*="#d7ffcc" i] { color: #3a9d23 !important; background-color: #e5f6dc !important; }
        #transactions_table .badge[style*="#ffffcc" i] { color: #f0a800 !important; background-color: #fff3c4 !important; }
        #transactions_table .badge[style*="#ffcccc" i],
        #transactions_table .badge[style*="#f9dfff" i] { color: #e01e1e !important; background-color: #fde4e4 !important; }
        #transactions_table .badge[style*="#f8f8f8" i] { color: #6b7280 !important; background-color: #f1f2f4 !important; }
        /* Check status "Approved" -> "Approved Payment" (design wording) */
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(8) .badge[style*="#d7ffcc" i] { font-size: 0; }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(8) .badge[style*="#d7ffcc" i]::after {
            content: "Approved Payment";
            font-size: 12px;
        }

        /* Narrower phones: slightly smaller line 1 so id, status and Sync fit together */
        @media (max-width: 429px) {
            #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(2),
            #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(2) a { font-size: 15px !important; }
            #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(8) .badge:not([style*="#d7ffcc" i]),
            #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(8) .badge[style*="#d7ffcc" i]::after,
            #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(8)::after { font-size: 11px !important; }
            #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(8) .badge { padding: 2px 8px; }
            #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(8)::after { padding: 2px 8px 2px 22px; background-position: 7px center; background-size: 12px 12px; }
            #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(1) .transaction-checkbox { margin-right: -2px; }
            /* Shorter status words so they fit beside the id: "Approved", "Pending" */
            #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(8) .badge[style*="#d7ffcc" i]::after { content: "Approved"; }
            #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(8) .badge[style*="#f8f8f8" i] { font-size: 0 !important; }
            #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(8) .badge[style*="#f8f8f8" i]::after { content: "Pending"; font-size: 11px; }
        }
        @media (max-width: 359px) {
            #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(8) { gap: 4px; }
        }

        /* Line 2: "Order ID - #002580" */
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(3) {
            order: 4;
            flex: 0 0 100%;
            margin-top: 2px;
        }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(3),
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(3) a {
            font-size: 15px !important;
            font-weight: 400;
            color: #111827 !important;
            text-decoration: none;
        }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(3)::before { content: "Order ID - #"; }

        /* Line 3: Team Name (left) / Name on Card (right) */
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(5) { order: 5; flex: 1 1 0; margin-top: 10px; }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(6) {
            order: 6;
            flex: 0 1 auto;
            max-width: 50%;
            margin-top: 10px;
            text-align: right !important;
        }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(5)::before,
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(6)::before {
            display: block;
            margin-bottom: 1px;
            font-size: 12px;
            color: #8a8f98;
        }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(5)::before { content: "Team Name"; }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(6)::before { content: "Name on Card"; }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) .cell-value-truncate {
            display: block;
            max-width: 100%;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        /* Line 4: Payment Type / Total / Transaction ID boxes (after a forced line break) */
        #transactions_table > tbody > tr:not(.payment-log-detail-row)::before {
            content: "";
            order: 7;
            flex: 0 0 100%;
            height: 0;
        }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(4)  { order: 8; }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(9)  { order: 9; }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(11) { order: 10; }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(4),
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(9),
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(11) {
            flex: 0 0 calc((100% - 20px) / 3 - 0.5px);
            align-self: stretch;
            margin-top: 12px;
            padding: 7px 8px 8px !important;
            background: #f3f4f6;
            border-radius: 8px;
            font-size: clamp(13px, 3.9vw, 16px) !important;
            font-weight: 500;
            line-height: 1.35;
        }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(4)::before,
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(9)::before,
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(11)::before {
            display: block;
            margin-bottom: 1px;
            font-size: clamp(10.5px, 3.05vw, 15px);
            font-weight: 400;
            color: #8a8f98;
            white-space: nowrap;
        }
        /* Transaction IDs are long numbers: slightly smaller so they stay on one line */
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(11) {
            padding-left: 6px !important;
            padding-right: 6px !important;
            font-size: clamp(10.5px, 3.05vw, 16px) !important;
        }
        /* Very large totals (e.g. $ 12,345,626.12) wrap inside the box instead of being cut off */
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(9) { white-space: normal !important; overflow-wrap: anywhere; }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(4)::before  { content: "Payment Type"; }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(9)::before  { content: "Total"; }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(11)::before { content: "Transaction ID"; }

        /* Dashed divider, then Payment Date (left) / Payment Time (right) */
        #transactions_table > tbody > tr:not(.payment-log-detail-row)::after {
            content: "";
            order: 11;
            flex: 0 0 100%;
            height: 0;
            margin-top: 14px;
            border-top: 1px dashed #e5e7eb;
        }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(12) { order: 12; flex: 1 1 auto; margin-right: -10px; }   /* cancel the column gap; time is pushed right */
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(13) { order: 13; flex: 0 0 auto; margin-left: auto; text-align: right !important; }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(12),
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(13) {
            margin-top: 10px;
            font-size: 12.5px !important;
            font-weight: 600;
            white-space: nowrap;
        }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(12)::before,
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(13)::before {
            margin-right: 5px;
            font-weight: 400;
            color: #8a8f98;
        }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(12)::before { content: "Payment Date"; }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(13)::before { content: "Payment Time"; }

        /* "No data available" row */
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td.dataTables_empty {
            display: block;
            flex: 1 1 100%;
            padding: 6px 0 !important;
            text-align: center !important;
            color: #6b7280 !important;
        }
        #transactions_table > tbody > tr:not(.payment-log-detail-row):has(> td.dataTables_empty)::after,
        #transactions_table > tbody > tr:not(.payment-log-detail-row):has(> td.dataTables_empty)::before { display: none; }

        /* Expanded Store payments (chevron on auto-generated payments):
           keep their table, scrollable inside a grey panel under the card */
        #transactions_table > tbody > tr.payment-log-detail-row {
            display: block;
            margin: -6px 0 14px;
            background: transparent !important;
            border: none !important;
        }
        #transactions_table > tbody > tr.payment-log-detail-row > td {
            display: block;
            box-sizing: border-box;
            width: 100%;
            padding: 10px !important;
            border: none !important;
            border-radius: 12px;
            background: #f3f4f6 !important;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        #transactions_table > tbody > tr.payment-log-detail-row table {
            min-width: 900px;
            background: #fff;
        }

        /* ---------- Pager: "Showing x to y of z entries" + buttons ---------- */
        #transactions_table_wrapper > .row:last-child {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-top: 6px;
        }
        #transactions_table_wrapper > .row:last-child > [class*="col-"] {
            flex: 0 1 auto;
            width: auto;
            max-width: none;
        }
        #transactions_table_wrapper .dataTables_info {
            padding: 0 !important;
            font-size: 13px;
            color: #9ca3af;
            white-space: normal;
        }
        #transactions_table_wrapper .dataTables_paginate { margin: 0 !important; }
        #transactions_table_wrapper .pagination {
            flex-wrap: wrap;
            justify-content: flex-end !important;
            gap: 6px;
            margin: 0 !important;
        }
        #transactions_table_wrapper .page-item .page-link {
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
        #transactions_table_wrapper .page-item.active .page-link {
            background: #111827;
            border-color: #111827;
            color: #fff;
        }
        #transactions_table_wrapper .page-item.disabled .page-link { color: #9ca3af; }
        /* "Previous" / "Next" -> ‹ › */
        #transactions_table_wrapper .page-item.previous .page-link,
        #transactions_table_wrapper .page-item.next .page-link { font-size: 0; }
        #transactions_table_wrapper .page-item.previous .page-link::before,
        #transactions_table_wrapper .page-item.next .page-link::before {
            font-size: 20px;
            line-height: 1;
        }
        #transactions_table_wrapper .page-item.previous .page-link::before { content: "\2039"; }
        #transactions_table_wrapper .page-item.next .page-link::before     { content: "\203A"; }
    }

    @media (max-width: 380px) {
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(12),
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(13) { font-size: 12px !important; }
    }

    /* Very small phones (320px - 359px) */
    @media (max-width: 359px) {
        .content-position {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }
        .mobile-export-btn { height: 38px; padding: 0 12px; font-size: 14px; }
        #filter_div_mobile { padding: 12px; }
        #filter_div_mobile .filter-grid-mobile,
        #filter_div_mobile .filter-buttons-row { gap: 10px; }
        #filter_div_mobile .filter_row input,
        #filter_div_mobile .filter_row select { padding: 0 26px 0 10px; background-position: right 9px center; }
        #filter_div_mobile .filter_row.is-empty .date_p { left: 11px; font-size: 14px; }
        #mobile-entries-sort-row .date_p { font-size: 12px; }
        #mobile-entries-sort-row .rp-m-select-all { padding: 0 13px; }
        #mobile-entries-sort-row select { font-size: 12px; padding: 0 22px 0 8px; background-position: right 7px center; }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) { padding: 14px 12px 12px; column-gap: 8px; }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(4),
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(9),
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(11) {
            flex-basis: calc((100% - 16px) / 3);
            padding: 6px 6px 7px !important;
        }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(12),
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(13) { font-size: 12px !important; }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(8) .badge,
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(10) .badge { padding: 2px 6px !important; }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(8)::after { padding: 2px 6px 2px 19px; background-position: 5px center; background-size: 12px 12px; }
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(2),
        #transactions_table > tbody > tr:not(.payment-log-detail-row) > td:nth-child(2) a { font-size: 14px !important; }
    }

    /* =====================================================================
       "Payment ID - …" popup (#notification_modal) — mobile only.
       Desktop keeps the plain table; everything is scoped below.
       ===================================================================== */
    @media (max-width: 767px) {
        #notification_modal .modal-dialog {
            max-width: none;
            margin: 12px;
            min-height: calc(100% - 24px);
        }
        #notification_modal .modal-content {
            border-radius: 16px !important;          /* inline 0rem */
            overflow: hidden;
        }
        #notification_modal .modal-header {
            align-items: center;
            margin: 0 16px;
            padding: 18px 0 14px;
            border-bottom: 1px solid #e5e7eb;
        }
        #notification_modal .modal-title {
            font-size: 19px !important;              /* inline 13px */
            font-weight: 700;
            color: #111827 !important;
        }
        #notification_modal .modal-header .close {
            margin: 0;
            padding: 0 2px;
            opacity: 1;
        }
        #notification_modal .modal-header .close span { font-size: 26px; font-weight: 300; color: #111827 !important; }
        #notification_modal .modal-body { padding: 14px 14px 0; background: #fff; }
        #notification_modal .modal-body .py-3 { padding: 0 !important; text-align: left !important; }
        #notification_modal .modal-body .table-responsive { padding: 0; overflow: visible; }
        #notification_modal #check_payment { display: block; margin: 0; }
        #notification_modal .check-image,
        #notification_modal .venmo-image {
            display: inline-block;
            width: 48%;
            height: auto;
            margin-bottom: 10px;
            padding: 0;
        }
        #notification_modal .check-image img,
        #notification_modal .venmo-image img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        #mobile_payments_table {
            display: block;
            width: 100% !important;
            margin: 0 !important;                    /* inline 0 2rem */
        }
        #mobile_payments_table > thead { display: none; }
        #mobile_payments_table > tbody { display: block; }
        #mobile_payments_table > tbody > tr {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            column-gap: 10px;
            min-height: 0;
            margin-bottom: 14px;
            padding: 14px 12px 12px;
            background: #fff !important;             /* inline highlight colour */
            border: 1px solid #e5e7eb !important;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(17, 24, 39, 0.04);
            font-size: 13px;
        }
        /* The payment that was clicked */
        #mobile_payments_table > tbody > tr[style*="9cc775"] {
            border-color: #47D6B6 !important;
            box-shadow: 0 0 0 1px #47D6B6;
        }
        #mobile_payments_table > tbody > tr > td {
            display: block;
            box-sizing: border-box;                  /* DataTables sets content-box */
            min-width: 0;
            padding: 0 !important;
            border: none !important;
            text-align: left !important;
            font-size: 13px !important;
            color: #111827;
            overflow-wrap: anywhere;
        }

        /* Line 1: "#1" + View | Export */
        #mobile_payments_table > tbody > tr > td:nth-child(1) {
            order: 1;
            flex: 1 1 auto;
            font-size: 18px !important;
            font-weight: 700;
        }
        #mobile_payments_table > tbody > tr > td:nth-child(1)::before { content: "#"; }
        #mobile_payments_table > tbody > tr > td:nth-child(9) {
            order: 2;
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            font-size: 0 !important;                 /* hides the &nbsp; spacing */
            white-space: nowrap;
        }
        #mobile_payments_table > tbody > tr > td:nth-child(9) i {
            font-size: 15px;
            color: #111827;
            cursor: pointer;
        }
        /* Design uses the download glyph for both actions */
        #mobile_payments_table > tbody > tr > td:nth-child(9) .fa-eye::before { content: "\f019"; }
        #mobile_payments_table > tbody > tr > td:nth-child(9) .mobile-action-label {
            display: inline;
            margin-left: 5px;
            font-size: 13px;
            color: #111827;
            text-decoration: underline;
            cursor: pointer;
        }
        #mobile_payments_table > tbody > tr > td:nth-child(9) i.download-payment-receipt {
            margin-left: 10px;
            padding-left: 10px;
            border-left: 1px solid #d1d5db;
        }
        /* Forced line break, so the approval pill gets its own line */
        #mobile_payments_table > tbody > tr::before {
            content: "";
            order: 3;
            flex: 0 0 100%;
            height: 0;
        }
        /* Line 2: approval pill ("Approved Payment" / "Not Approved") */
        #mobile_payments_table > tbody > tr > td:nth-child(6) {
            order: 4;
            flex: 0 0 auto;
            margin-top: 6px;
            padding: 3px 10px !important;
            border-radius: 999px;
            background: #fde4e4;
            font-size: 12px !important;
            font-weight: 500;
            line-height: 1.4;
        }
        #mobile_payments_table > tbody > tr > td:nth-child(6)[style*="green"] {
            background: #e5f6dc;
            font-size: 0 !important;
        }
        #mobile_payments_table > tbody > tr > td:nth-child(6)[style*="green"]::after {
            content: "Approved Payment";
            font-size: 12px;
            color: #3a9d23;
        }
        /* Line 3: Name on Card */
        #mobile_payments_table > tbody > tr > td:nth-child(3) {
            order: 5;
            flex: 0 0 100%;
            margin-top: 8px;
            font-weight: 500;
        }
        #mobile_payments_table > tbody > tr > td:nth-child(3)::before {
            content: "Name on Card";
            margin-right: 8px;
            font-weight: 400;
            color: #8a8f98;
        }
        /* Line 4: Payment Type / Total / Transaction ID boxes */
        #mobile_payments_table > tbody > tr > td:nth-child(2) { order: 6; }
        #mobile_payments_table > tbody > tr > td:nth-child(5) { order: 7; }
        #mobile_payments_table > tbody > tr > td:nth-child(4) { order: 8; }
        #mobile_payments_table > tbody > tr > td:nth-child(2),
        #mobile_payments_table > tbody > tr > td:nth-child(5),
        #mobile_payments_table > tbody > tr > td:nth-child(4) {
            flex: 0 0 calc((100% - 20px) / 3 - 0.5px);
            align-self: stretch;
            margin-top: 10px;
            padding: 6px 7px 7px !important;
            background: #f3f4f6;
            border-radius: 8px;
            font-size: clamp(11px, 3.1vw, 14px) !important;
            line-height: 1.35;
        }
        #mobile_payments_table > tbody > tr > td:nth-child(2)::before,
        #mobile_payments_table > tbody > tr > td:nth-child(5)::before,
        #mobile_payments_table > tbody > tr > td:nth-child(4)::before {
            display: block;
            margin-bottom: 1px;
            font-size: clamp(10px, 2.9vw, 12.5px);
            color: #8a8f98;
            white-space: nowrap;
        }
        #mobile_payments_table > tbody > tr > td:nth-child(4) { font-size: clamp(10px, 2.85vw, 14px) !important; }   /* long ids */
        #mobile_payments_table > tbody > tr > td:nth-child(2)::before { content: "Payment Type"; }
        #mobile_payments_table > tbody > tr > td:nth-child(5)::before { content: "Total"; }
        #mobile_payments_table > tbody > tr > td:nth-child(4)::before { content: "Transaction ID"; }
        /* Dashed divider, then Payment Date / Payment Time */
        #mobile_payments_table > tbody > tr::after {
            content: "";
            order: 9;
            flex: 0 0 100%;
            height: 0;
            margin-top: 12px;
            border-top: 1px dashed #e5e7eb;
        }
        #mobile_payments_table > tbody > tr > td:nth-child(7) { order: 10; flex: 1 1 auto; margin-right: -10px; }   /* cancel the gap */
        #mobile_payments_table > tbody > tr > td:nth-child(8) { order: 11; flex: 0 0 auto; margin-left: auto; }
        #mobile_payments_table > tbody > tr > td:nth-child(7),
        #mobile_payments_table > tbody > tr > td:nth-child(8) {
            margin-top: 9px;
            font-size: clamp(11px, 3.1vw, 12.5px) !important;
            font-weight: 600;
            white-space: nowrap;
        }
        #mobile_payments_table > tbody > tr > td:nth-child(7)::before,
        #mobile_payments_table > tbody > tr > td:nth-child(8)::before {
            margin-right: 4px;
            font-weight: 400;
            color: #8a8f98;
        }
        #mobile_payments_table > tbody > tr > td:nth-child(7)::before { content: "Payment Date"; }
        #mobile_payments_table > tbody > tr > td:nth-child(8)::before { content: "Payment Time"; }

        /* Total Amount line */
        #mobile_payments_table > tfoot { display: block; }
        #mobile_payments_table > tfoot > tr {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 4px 12px 6px;
            background: transparent !important;
            border: none !important;
        }
        #mobile_payments_table > tfoot th {
            padding: 0 !important;
            border: none !important;
            background: transparent !important;
        }
        #mobile_payments_table > tfoot th:first-child {
            font-size: 14px !important;
            font-weight: 400 !important;
            color: #6b7280 !important;
            text-align: left !important;
        }
        #mobile_payments_table > tfoot th:last-child {
            font-size: 16px !important;
            font-weight: 700 !important;
            color: #111827 !important;
            padding-right: 0 !important;
        }

        /* Close (left) + Download Invoice (right) */
        #notification_modal .modal-footer {
            display: flex;
            flex-wrap: nowrap;
            gap: 12px;
            padding: 14px 16px 18px;
            border-top: none;
            background: #fff;
        }
        #notification_modal .modal-footer .styled-button {
            display: flex;
            flex: 1 1 0;
            align-items: center;
            justify-content: center;
            height: 48px;
            margin: 0 !important;
            padding: 0 !important;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(17, 24, 39, 0.08);
        }
        #notification_modal .modal-footer a.styled-button { order: 2; }
        #notification_modal .modal-footer button.styled-button {
            order: 1;
            background-color: #b3b3b3 !important;    /* inline red */
        }
    }

    /* =====================================================================
       "Payment Receipt" popup (#receiptModal) — mobile only.
       Desktop viewing and the PDF download still use the original receipt.
       ===================================================================== */
    @media (max-width: 767px) {
        #receiptModal .modal-dialog {
            display: flex;
            align-items: center;
            max-width: none;
            min-height: calc(100% - 32px);
            margin: 16px;
        }
        #receiptModal .modal-content {
            width: 100%;
            border-radius: 16px !important;
        }
        #receiptModal .modal-header {
            align-items: center;
            margin: 0 18px;
            padding: 18px 0 14px;
            border-bottom: 1px solid #e5e7eb;
        }
        #receiptModal .modal-title {
            font-size: 19px;
            font-weight: 700;
            color: #111827;
        }
        #receiptModal .modal-header .close { margin: 0; padding: 0 2px; opacity: 1; }
        #receiptModal .modal-header .close span { font-size: 26px; font-weight: 300; color: #111827; }
        #receiptModal #receiptModalBody {
            padding: 16px 18px 22px !important;
            background: #fff;
            max-height: calc(100vh - 120px) !important;
        }

        /* "Transaction Details" (collapsed by default) */
        .receipt-m-section { margin-bottom: 14px; }
        .receipt-m-toggle {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 14px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(17, 24, 39, 0.05);
            font-size: 16px;
            font-weight: 600;
            color: #111827;
        }
        .receipt-m-toggle.is-open { border-radius: 12px 12px 0 0; box-shadow: none; }
        .receipt-m-toggle i,
        .receipt-m-card-header i { font-size: 14px; color: #111827; }
        .receipt-m-toggle-body {
            margin-top: -1px;
            padding: 4px 14px 10px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-top: none;
            border-radius: 0 0 12px 12px;
        }

        /* "Order Summary" card (expanded by default) */
        .receipt-m-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }
        .receipt-m-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 14px 14px 8px;
            background: #fff;
            border: none;
            font-size: 16px;
            font-weight: 600;
            color: #111827;
        }
        .receipt-m-card-body { padding: 0 14px 10px; }

        .receipt-m-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            padding: 5px 0;
            font-size: 14px;
            color: #111827;
        }
        .receipt-m-row span:last-child { text-align: right; overflow-wrap: anywhere; }
        .receipt-m-row.muted span { color: #8a8f98; }
        .receipt-m-row.bold { font-weight: 700; }

        /* Totals under the card */
        .receipt-m-totals { padding: 12px 14px 0; }
        .receipt-m-totals .receipt-m-row.bold { padding-bottom: 9px; }

        .receipt-m-status {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 500;
        }
        .receipt-m-footer {
            margin-top: 16px;
            text-align: center;
        }
        .receipt-m-footer p {
            margin-bottom: 12px;
            font-size: 16px;
            font-weight: 700;
            color: #111827;
        }
        .receipt-m-footer img {
            width: 100%;
            max-width: 220px;
            height: auto;
        }
    }
</style>

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12 mt-4">
    <div class="mobile-page-header">
        {{-- <a href="{{ route('home') }}" class="mobile-back-link"><i class="fa fa-chevron-left"></i> BACK TO HOME</a> --}}
        <div class="mobile-page-header-row">
        <h5 class="mobile-page-title">Received Payments</h5>
        @can('create people')
            <button type="button" class="mobile-export-btn" onclick="exportReport()">
                <i class="fa fa-download" aria-hidden="true"></i> Export
            </button>
        @endcan
    </div>
    </div>
        <div class="card">
            <div class="row" style="padding-left: 1rem;padding-right: 1rem;">
                <div class="col-md-12">
                    <div class="card filter_div" id="filter_div_desktop">
                        <div class="row align-items-center" style="padding-left: 25px; row-gap: 8px;">
                            <div style="margin-right: 20px;">
                                <div class="row filter_row">
                                    <p class="font_color date_p">Date Range | </p>

                                    <input class="date_selection"
                                        type="date"
                                        id="start-date"
                                        name="start-date"
                                        value="{{ request('start_date') ?? '' }}">

                                    <p class="font_color date_p">&nbsp; &nbsp; &nbsp;</p>

                                    <input class="date_selection"
                                        type="date"
                                        id="end-date"
                                        name="end-date"
                                        value="{{ request('end_date') ?? '' }}">
                                </div>
                            </div>

                            <div style="margin-right: 20px;">
                                <div class="row filter_row" style="padding-bottom: 2px;">
                                    <p class="font_color date_p">Payment Type |</p>
                                    <div class="paymen_type_div date_selection">
                                        <select id="paymentType" class="date_selection" name="payment_type">
                                            <option value="all"     {{ request('payment_type') == 'all' ? 'selected' : '' }}>All</option>
                                            <option value="Card"    {{ request('payment_type') == 'Card' ? 'selected' : '' }}>Card</option>
                                            <option value="Check"   {{ request('payment_type') == 'Check' ? 'selected' : '' }}>Check</option>
                                            <option value="Venmo"   {{ request('payment_type') == 'Venmo' ? 'selected' : '' }}>Venmo</option>
                                            <option value="Paypal"  {{ request('payment_type') == 'Paypal' ? 'selected' : '' }}>Paypal</option>
                                            <option value="Other"   {{ request('payment_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div style="margin-right: 20px;">
                                <div class="row filter_row" style="padding-bottom: 2px;">
                                    <p class="font_color date_p">Payment Status |</p>
                                    <div class="paymen_type_div date_selection">
                                        <select id="paymentStatus" class="date_selection" name="payment_status">
                                            <option value="all"     {{ request('payment_status') == 'all' ? 'selected' : '' }}>All</option>
                                            <option value="2"    {{ request('payment_status') == '2' ? 'selected' : '' }}>Paid</option>
                                            <option value="1" {{ request('payment_status') == '1' ? 'selected' : '' }}>Partial</option>
                                            <option value="3" {{ request('payment_status') == '3' ? 'selected' : '' }}>Pending</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-right: 20px;">
                                <div class="row filter_row" style="padding-bottom: 2px;">
                                    <p class="font_color date_p">Order Type |</p>
                                    <div class="paymen_type_div date_selection">
                                        <select id="order_type" class="date_selection" name="order_type">
                                            <option value="all" {{ request('order_type') == 'ALL' ? 'selected' : '' }}>All</option>
                                            <option value="WL" {{ request('order_type') == 'WL' ? 'selected' : '' }}>WL Orders</option>
                                            <option value="TSR" {{ request('order_type') == 'TSR' ? 'selected' : '' }}>TSR Orders</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap align-items-center flex-grow-1" style="gap: 6px;">
                                <button type="button" class="btn btn-sm btn-primary m-0" id="pin-filter">
                                    <i class="fa fa-filter" style="padding-left: 5px; padding-top: 4px; padding-right: 5px;"></i>
                                    Filter
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-default m-0" id="reset-filter">
                                    <i class="fa fa-times" style="padding-left: 5px; padding-top: 4px; padding-right: 5px;"></i>
                                    Clear
                                </button>
                                @can('create people')
                                    <button type="button" class="btn btn-sm btn-outline-default ml-auto mr-0" onclick="exportReport()" title="Export CSV">
                                        CSV Export
                                    </button>
                                @endcan
                            </div>
                        </div>
                        <div class="row" style="padding-left: 25px; padding-top: 10px;">
                            <button class="import-to-quickbooks styled-button" style="outline: unset; background-color: #47D6B6; color: white;display:none" href="#" title="Import to Quickbooks">
                                Import to Quickbooks <i class="fa fa-upload" style="padding-left: 5px; padding-top: 4px; padding-right: 5px;"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card filter_div" id="filter_div_mobile">
                        <div class="filter-grid-mobile">
                            <div class="filter-col">
                                <div class="row filter_row">
                                    <p class="font_color date_p">Start Date</p>
                                    <input class="date_selection" type="date" id="start-date-m" value="{{ request('start_date') ?? '' }}">
                                </div>
                            </div>
                            <div class="filter-col">
                                <div class="row filter_row">
                                    <p class="font_color date_p">End Date</p>
                                    <input class="date_selection" type="date" id="end-date-m" value="{{ request('end_date') ?? '' }}">
                                </div>
                            </div>
                            <div class="filter-col">
                                <div class="row filter_row">
                                    <p class="font_color date_p">Payment Type</p>
                                    <select id="paymentType-m" class="date_selection">
                                        <option value="all"    {{ request('payment_type') == 'all' ? 'selected' : '' }}>Payment Types</option>
                                        <option value="Card"   {{ request('payment_type') == 'Card' ? 'selected' : '' }}>Card</option>
                                        <option value="Check"  {{ request('payment_type') == 'Check' ? 'selected' : '' }}>Check</option>
                                        <option value="Venmo"  {{ request('payment_type') == 'Venmo' ? 'selected' : '' }}>Venmo</option>
                                        <option value="Paypal" {{ request('payment_type') == 'Paypal' ? 'selected' : '' }}>Paypal</option>
                                        <option value="Other"  {{ request('payment_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="filter-col">
                                <div class="row filter_row">
                                    <p class="font_color date_p">Payment Status</p>
                                    <select id="paymentStatus-m" class="date_selection">
                                        <option value="all" {{ request('payment_status') == 'all' ? 'selected' : '' }}>Payment Status</option>
                                        <option value="2"   {{ request('payment_status') == '2' ? 'selected' : '' }}>Paid</option>
                                        <option value="1"   {{ request('payment_status') == '1' ? 'selected' : '' }}>Partial</option>
                                        <option value="3"   {{ request('payment_status') == '3' ? 'selected' : '' }}>Pending</option>
                                    </select>
                                </div>
                            </div>
                            <div class="filter-col filter-col-full">
                                <div class="row filter_row">
                                    <p class="font_color date_p">Order Type</p>
                                    <select id="order_type-m" class="date_selection">
                                        <option value="all" {{ request('order_type') == 'all' ? 'selected' : '' }}>Order Type</option>
                                        <option value="WL"  {{ request('order_type') == 'WL' ? 'selected' : '' }}>WL Orders</option>
                                        <option value="TSR" {{ request('order_type') == 'TSR' ? 'selected' : '' }}>TSR Orders</option>
                                    </select>
                                </div>
                            </div>
                            <div class="filter-col filter-col-full filter-buttons-row">
                                <button type="button" class="date_p clear_filter_btn" id="reset-filter-m">
                                    <i class="fa fa-times"></i> Clear Filters
                                </button>
                                <a href="#" class="date_p filter_btn" id="pin-filter-m">
                                    <i class="fa fa-filter"></i> Filter
                                </a>
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
                            <option value="order_id">Order ID</option>
                        </select>
                    </div>
                    {{-- Mobile only: tick / untick every payment card in the list --}}
                    <label class="rp-m-select-all" for="rp-select-all-m">
                        <input type="checkbox" id="rp-select-all-m">
                        <span>Select all</span>
                        <span class="rp-m-selected-count"></span>
                    </label>
                </div>
                <div class="col-md-12 new-style-table">
                    <div class="table-responsive">

                        <table class="table align-items-center table-responsive" id="transactions_table">
                            <thead class="header-style">
                            <tr>
                                <th style="text-align: center;" scope="col"></th>
                                <th style="text-align: center;" class="payment-id" scope="col">Transaction id</th>
                                <th style="text-align: center;" class="order-no" scope="col">Order #</th>
                                <th style="text-align: center;" class="payment-type" scope="col">Payment Type</th>
                                <th style="text-align: center;" class="team-name" scope="col">Team Name</th>
                                <th style="text-align: center;" class="name-on-card" scope="col">Name on Card</th>
                                <th style="text-align: center;" class="customer-name" scope="col">Customer Name</th>
                                <th style="text-align: center;" class="check-status" scope="col">check Status</th>
                                <th style="text-align: center;" class="amount" scope="col">Amount</th>
                                <th style="text-align: center;" class="order-status" scope="col">Order Payment Status</th>
                                <th style="text-align: center;" class="transaction-id" scope="col">Transaction ID</th>
                                <th style="text-align: center;" class="payment-date" scope="col">Payment Date</th>
                                <th style="text-align: center;" class="payment-type" scope="col">Time</th>
                                <th style="text-align: center;" class="payment-refund" scope="col">Refund</th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach ($TrasnsactionsArray as $key => $Trasnsaction)
                                @php
                                    $qbStatus = $Trasnsaction['QBStatus'] ?? null;

                                    /*
                                     * QBStatus = synced can now belong to:
                                     * 1. a normal/direct payment, or
                                     * 2. an auto-generated StorePayment parent when
                                     *    every eligible collapsed child is synced.
                                     */
                                    $isQuickBooksSynced =
                                        $qbStatus === 'synced';
                                @endphp

                                <tr data-payment-log-id="{{ $Trasnsaction['ID'] }}"
                                    data-auto-generated="{{ $Trasnsaction['auto_generated'] ? 1 : 0 }}"
                                    data-quickbooks-synced="{{ $isQuickBooksSynced ? 'Yes' : 'No' }}">
                                    <td style="text-align: center;">
                                        <div style="display:flex;align-items:center;justify-content:center;gap:8px;white-space:nowrap;">
                                            {{-- QuickBooks state appears before the checkbox.
                                                 Keep this in the FIRST column; your current
                                                 Transaction/Order/etc. column order is unchanged. --}}
                                            @if($Trasnsaction['auto_generated'])

                                                {{-- Empty span is intentional. AJAX updates it
                                                     when the collapsed children are loaded. --}}
                                                <span
                                                    class="parent-qb-status-icon"
                                                    data-parent-qb-status="{{ $Trasnsaction['ID'] }}"
                                                >
                                                    @if($qbStatus === 'synced')
                                                        <i
                                                            class="fa fa-check-circle"
                                                            title="All StoreOrder payments synced to QuickBooks"
                                                            aria-label="All StoreOrder payments synced to QuickBooks"
                                                            style="color:#28a745;font-size:17px;"
                                                        ></i>
                                                    @endif
                                                </span>

                                            @else

                                                @if($qbStatus === 'synced')
                                                    <i
                                                        class="fa fa-check-circle"
                                                        title="Synced to QuickBooks"
                                                        aria-label="Synced to QuickBooks"
                                                        style="color:#28a745;font-size:17px;"
                                                    ></i>
                                                @elseif($qbStatus === 'saved')
                                                    <i
                                                        class="fa fa-save"
                                                        title="Saved for QuickBooks"
                                                        aria-label="Saved for QuickBooks"
                                                        style="color:#6c757d;font-size:15px;"
                                                    ></i>
                                                @elseif($qbStatus === 'failed')
                                                    <i
                                                        class="fa fa-exclamation-circle"
                                                        title="QuickBooks sync failed"
                                                        aria-label="QuickBooks sync failed"
                                                        style="color:#dc3545;font-size:17px;"
                                                    ></i>
                                                @endif

                                            @endif

                                            <input
                                                type="checkbox"
                                                class="transaction-checkbox"
                                                data-value="{{ $Trasnsaction['ID'] }}"
                                                data-type="{{ $Trasnsaction['PaymentType'] }}"
                                                data-auto-generated="{{ $Trasnsaction['auto_generated'] ? 1 : 0 }}"
                                                {{ $isQuickBooksSynced ? 'disabled' : '' }}
                                                title="{{ $isQuickBooksSynced
                                                    ? ($Trasnsaction['auto_generated']
                                                        ? 'All StoreOrder payments are already synced to QuickBooks'
                                                        : 'Already synced to QuickBooks')
                                                    : 'Select for QuickBooks import'
                                                }}"
                                            />
                                        </div>
                                    </td>
                                    <td style="text-align-last: left;" class="payment-id">
                                        {{-- Keep the existing TSR / auto-generated collapse exactly as-is. --}}
                                        @if($Trasnsaction['auto_generated'] == true)
                                            <i class="fa fa-chevron-right show_store_payments"
                                               data-payment-log-id="{{ $Trasnsaction['ID'] }}"
                                               style="font-size: 10px;color: black;margin-right: 5px;cursor:pointer"
                                               title="Show TSR card payments"></i>

                                        {{-- Normal Order Card payment: show refund history only when records exist. --}}
                                        @elseif(
                                            strcasecmp((string) ($Trasnsaction['PaymentType'] ?? ''), 'Card') === 0
                                            && !empty($cardRefundRecordsMap[(string) $Trasnsaction['ID']])
                                        )
                                            <i class="fa fa-chevron-right show_card_refunds"
                                               data-payment-log-id="{{ $Trasnsaction['ID'] }}"
                                               style="font-size: 10px;color: #d65a47;margin-right: 5px;cursor:pointer"
                                               title="Show card refund records"></i>
                                        @endif

                                        <a
                                            style="rgba(22, 22, 23, 1) !important"
                                            data-orderNo="{{ $Trasnsaction['Order'] }}"
                                            @isset($Trasnsaction['checkFImage']) data-checkFImage="{{ $Trasnsaction['checkFImage'] }}" @endisset
                                            @isset($Trasnsaction['checkBImage']) data-checkBImage="{{ $Trasnsaction['checkBImage'] }}" @endisset
                                            href="javascript:void(0)"
                                            class="edit payID"
                                            data-value="{{$Trasnsaction['TransactionID']}}">
                                            {{ $Trasnsaction['TransactionID'] }}
                                        </a>
                                    </td>
                                    <td style="text-align-last: left;" class="order-no">
                                        <a href="#" class="edit-order" data-value="{{$Trasnsaction['Order']}}">{{ str_pad($Trasnsaction['Order'], 6, '0', STR_PAD_LEFT) }}</a>
                                    </td>
                                    <td style="text-align-last: left;" class="payment-type">
                                        @if ($Trasnsaction['PaymentType'] === 'Check')
                                            <button type="button" class="btn btn-link p-0 check-preview-open" style="color: #161617;"
                                                data-front="{{ !empty($Trasnsaction['checkFImage']) ? url($Trasnsaction['checkFImage']) : '' }}"
                                                data-back="{{ !empty($Trasnsaction['checkBImage']) ? url($Trasnsaction['checkBImage']) : '' }}">
                                                Check
                                            </button>
                                        @else
                                            {{ $Trasnsaction['PaymentType'] }}
                                        @endif
                                    </td>
                                    <td style="text-align-last: left;" class="team-name"><span class="cell-value-truncate" title="{{ $Trasnsaction['TeamName'] }}">{{ $Trasnsaction['TeamName'] }}</span></td>
                                    <td style="text-align-last: left;" class="name-on-card"><span class="cell-value-truncate" title="{{ $Trasnsaction['NameonCard'] }}">{{ $Trasnsaction['NameonCard'] }}</span></td>
                                    <td style="text-align-last: left;" class="customer-name">
                                        {{ $Trasnsaction['CustomerName'] ?? '' }}
                                    </td>
                                    <td style="text-align-last: center;" class="check-status">
                                        @if($Trasnsaction['checkStatus'] == 'Not Approved' )
                                            <span class="badge badge-pill" style="color:#d381ff;background-color:#f9dfff;width:100%">Not Approved</span>
                                        @elseif($Trasnsaction['checkStatus'] == 'Pending Approval')
                                            <span class="badge badge-pill" style="color:#717070;background-color:#f8f8f8;width:100%">Pending Approval</span>

                                        @elseif($Trasnsaction['checkStatus'] == 'Approved')
                                            <span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:100%">Approved</span>
                                        @elseif($Trasnsaction['checkStatus'] == 'Rejected')
                                            <span class="badge badge-pill" style="color:#d65a47;background-color:#ffcccc;width:100%">Rejected</span>
                                        @else
                                            <span class="badge badge-pill" style="color:#FFB916;background-color:#ffffcc;width:100%">Payed</span>
                                        @endif
                                    </td>
                                    <td style="text-align-last: right;" class="amount" data-export-amount="{{ $Trasnsaction['Amount'] }}">$ {{ number_format($Trasnsaction['Amount'], 2) }}</td>
                                    <td style="text-align-last: center;" class="order-status">
                                        @if($Trasnsaction['OrderStatus'] == 2)
                                            <span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:100%">Paid</span>
                                        @elseif($Trasnsaction['OrderStatus'] == 1)
                                            <span class="badge badge-pill" style="color:#d65a47;background-color:#ffcccc;width:100%">Partial</span>
                                        @else
                                            <span class="badge badge-pill" style="color:#FFB916;background-color:#ffffcc;width:100%">Pending</span>
                                        @endif
                                    </td>
                                    <td style="text-align-last: center;" class="transaction-id">{{ $Trasnsaction['TransactionID'] }}</td>
                                    <td style="text-align-last: center;" class="payment-date">{{ $Trasnsaction['PaymentDate']->format('m/d/Y') }}</td>
                                    <td style="text-align-last: center;" class="payment-type">{{ $Trasnsaction['PaymentDate']->format('H:i:s') }}</td>

                                    <td style="text-align: center;" class="payment-refund">
                                        @if(
                                            strcasecmp((string) ($Trasnsaction['PaymentType'] ?? ''), 'Card') === 0
                                            && empty($Trasnsaction['auto_generated'])
                                        )
                                            <button type="button"
                                                    class="btn btn-sm btn-success {{ Auth::user()->can('refund card payment') ? 'payment-refund-open' : 'payment-refund-closed' }}"
                                                    data-payment-log-id="{{ $Trasnsaction['ID'] }}"
                                                    data-order-id="{{ $Trasnsaction['Order'] }}"
                                                    data-gateway-transaction-id="{{ $Trasnsaction['TransactionID'] }}"
                                                    title="Refund card payment">
                                                <i class="fa fa-undo"></i>
                                            </button>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="paymentCheckPreview" tabindex="-1" role="dialog" aria-labelledby="paymentCheckPreviewTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentCheckPreviewTitle">Check images</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body payment-check-preview"></div>
        </div>
    </div>
</div>

{{-- Notification Modal --}}
<div class="modal fade" id="notification_modal" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
    <div class="modal-dialog modal-danger modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" style="background-color: white;border-radius:0rem">
            <div class="modal-header">
                <h6 class="modal-title" id="modal_title_notification" style="color: black;font-size: 13px;">2</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: black;">×</span>
                </button>
                <input type="hidden" id="refresh_required" value="0" />
            </div>

            <div class="modal-body">
                <div class="py-3 text-center new-style-table">
                    <div class="col-md-12 table-responsive">
                        <div class="row" id="check_payment">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer" id="modal-footer">

            </div>
        </div>
    </div>
</div>

<div id="receiptModal" class="modal" tabindex="-1" role="dialog" style="display:none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
        <div class="modal-header" style="padding-bottom: 0px;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border:none; background:none;">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="receiptModalBody" style="padding: 20px; max-height: 80vh; overflow-y: auto;">
        </div>
        </div>
    </div>
</div>
<div id="redundModal" class="modal" tabindex="-1" role="dialog" style="display:none;">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
        <div class="modal-header" style="padding-bottom: 0px;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border:none; background:none;">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="redundModalBody" style="padding: 20px; max-height: 80vh; overflow-y: auto;">
        </div>
        </div>
    </div>
</div>


{{-- Card Refund Modal --}}
<div class="modal fade" id="cardRefundModal" tabindex="-1" role="dialog" aria-labelledby="cardRefundModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius:10px;overflow:hidden;">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="cardRefundModalLabel" style="margin-bottom:3px;">
                        Card Payment Refund
                    </h5>
                    <div id="cardRefundModalSubtitle" style="font-size:12px;color:#8898aa;"></div>
                </div>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div id="cardRefundContent" class="p-3" style="display:none;">
                    <div class="row mb-3">
                        <div class="col-md-4 mb-2">
                            <div style="font-size:11px;color:#8898aa;text-transform:uppercase;font-weight:700;">
                                Transaction ID
                            </div>
                            <div id="refundGatewayTransaction" style="font-size:13px;font-weight:600;color:#32325d;"></div>
                        </div>

                        <div class="col-md-4 mb-2">
                            <div style="font-size:11px;color:#8898aa;text-transform:uppercase;font-weight:700;">
                                Total Amount
                            </div>
                            <div id="refundOriginalGross" style="font-size:13px;font-weight:600;color:#32325d;"></div>
                        </div>

                        <div class="col-md-4 mb-2">
                            <div style="font-size:11px;color:#8898aa;text-transform:uppercase;font-weight:700;">
                                Refundable Amount
                            </div>
                            <div id="refundRemainingBase" style="font-size:13px;font-weight:700;color:#2dce89;"></div>
                        </div>
                    </div>

                    <div class="card mb-3" style="box-shadow:none;border:1px solid #e9ecef;">
                        <div class="card-body" style="padding:16px;">
                            <form id="cardRefundForm">
                                @csrf

                                <input type="hidden" id="refundPaymentLogId" name="payment_log_id">
                                <input type="hidden" id="refundOrderId" name="order_id">
                                <input type="hidden" name="transaction_method" value="Card">

                                <div class="form-group mb-2">
                                    <label for="refundAmount" style="font-size:12px;font-weight:600;">
                                        Refund Amount ($)
                                    </label>

                                    <input type="number"
                                           class="form-control"
                                           id="refundAmount"
                                           name="amount"
                                           min="0.01"
                                           step="0.01"
                                           required>
                                </div>

                                <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap:8px;">
                                    <div style="font-size:12px;color:#525f7f;">
                                        Total Cost:
                                        <strong id="refundGatewayAmount">$0.00</strong>
                                    </div>

                                    <button type="submit"
                                            class="btn btn-success btn-sm"
                                            id="submitCardRefundBtn">
                                        <i class="fa fa-undo"></i>
                                        Refund
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <strong style="font-size:13px;">Refund History</strong>
                            <span id="refundHistoryCount" class="badge badge-secondary">0</span>
                        </div>

                        <div class="table-responsive" style="max-height:260px;overflow:auto;">
                            <table class="table table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>User</th>
                                        <th class="text-right">Refund</th>
                                        <th class="text-right">Full Amount</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="refundHistoryBody">
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No refund records.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    /*
     * Search nested StoreCardPayment rows whenever this page actually contains
     * expandable auto-generated payment parents.
     *
     * The previous code checked order_type == 'TSRM', but this page/filter uses
     * 'TSR'. That meant the custom nested-row search never ran.
     */
    const hasStorePaymentParents = @json($hasStorePaymentParents ?? false);
    const storeQuickBooksStatusMap = @json($storeQuickBooksStatusMap ?? []);
    const storeCustomerNameMap = @json($storeCustomerNameMap ?? []);
    const storeCustomerSearchIndex = @json($storeCustomerSearchIndex ?? []);

    // Normal Order Card refunds supplied by allTransactionPayments().
    const cardRefundRecordsMap = @json($cardRefundRecordsMap ?? []);

    function getStoreCustomerName(payment) {
        return storeCustomerNameMap[String(payment.id)] || '';
    }

    function getStoreQuickBooksStatus(payment) {
        const recordId = String(payment.id);
        const refundKey = String(parseInt(payment.is_refund || 0, 10));
        const recordMap = storeQuickBooksStatusMap[recordId] || {};

        return recordMap[refundKey] || null;
    }

    function getQuickBooksStatusIcon(status) {
        if (status === 'synced') {
            return '<i class="fa fa-check-circle" title="Synced to QuickBooks" aria-label="Synced to QuickBooks" style="color:#28a745;font-size:17px;"></i>';
        }

        if (status === 'saved') {
            return '<i class="fa fa-save" title="Saved for QuickBooks" aria-label="Saved for QuickBooks" style="color:#6c757d;font-size:15px;"></i>';
        }

        if (status === 'failed') {
            return '<i class="fa fa-exclamation-circle" title="QuickBooks sync failed" aria-label="QuickBooks sync failed" style="color:#dc3545;font-size:17px;"></i>';
        }

        return '';
    }

    let storeSearchMatches = [];
    let activeStoreSearch = '';
    let storeSearchTimer = null;
    let storeSearchRequest = null;

    /*
     * When a collapsed PaymentLog parent is expanded because one of its
     * StoreCardPayment children matched the DataTables search, render ONLY the
     * matching child payment(s), not every child under that parent.
     */
    function storePaymentMatchesActiveSearch(payment) {
        const search = String(activeStoreSearch || '')
            .toLowerCase()
            .replace(/\s+/g, ' ')
            .trim();

        if (!search) {
            return true;
        }

        const createdAt = payment.created_at
            ? new Date(payment.created_at)
            : null;

        const dateText = (
            createdAt
            && !Number.isNaN(createdAt.getTime())
        )
            ? createdAt.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            })
            : '';

        const timeText = (
            createdAt
            && !Number.isNaN(createdAt.getTime())
        )
            ? createdAt.toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            })
            : '';

        const paymentTypeText =
            parseInt(payment.is_refund || 0, 10) === 1
                ? 'refund'
                : 'payment';

        let statusText = 'failed';

        if (
            parseInt(payment.is_success || 0, 10) === 1
            && parseInt(payment.is_refund || 0, 10) === 0
        ) {
            statusText = 'successful';
        }

        if (
            parseInt(payment.is_success || 0, 10) === 1
            && parseInt(payment.is_refund || 0, 10) === 1
        ) {
            statusText = 'refunded';
        }

        const qbStatus =
            getStoreQuickBooksStatus(payment) || '';

        const searchableText = [
            payment.id,
            payment.store_order_no,
            payment.card_owner,
            getStoreCustomerName(payment),
            payment.transaction_id,
            payment.payment_amount,
            payment.processing_fee,
            payment.total_amount,
            paymentTypeText,
            statusText,
            qbStatus,
            dateText,
            timeText,
            payment.created_at
        ]
        .map(function(value) {
            return String(value ?? '').toLowerCase();
        })
        .join(' ')
        .replace(/\s+/g, ' ')
        .trim();

        // Match every word entered in the DataTables search box.
        return search
            .split(' ')
            .filter(Boolean)
            .every(function(term) {
                return searchableText.indexOf(term) !== -1;
            });
    }

    let header = "PAYMENTS";
    const headerElement = document.getElementById("header");

    if (headerElement) {
        headerElement.innerHTML = header;
    }

    var searchIdx = '';

    $(document).ready(function() {
        const today = new Date().toISOString().split('T')[0];

        // Set the maximum value for both date inputs to today
        $('#start-date').attr('max', today);
        $('#end-date').attr('max', today);

        /*
        |--------------------------------------------------------------------------
        | DataTables search + collapsed StoreCardPayment rows
        |--------------------------------------------------------------------------
        |
        | DataTables cannot search rows that do not exist in its internal data.
        | The nested StoreCardPayment <tr> elements are loaded only after clicking
        | the chevron, so we search those child records on the server and map any
        | match back to its visible PaymentLog parent row.
        */

        function normalizeTransactionSearch(value) {
            return String(value || '')
                .toLowerCase()
                .replace(/\s+/g, ' ')
                .trim();
        }

        function transactionTextMatches(text, search) {
            const normalizedText = normalizeTransactionSearch(text);
            const normalizedSearch = normalizeTransactionSearch(search);

            if (!normalizedSearch) {
                return true;
            }

            // Match all entered words, similar to DataTables smart-search behavior.
            const terms = normalizedSearch
                .split(' ')
                .filter(Boolean);

            return terms.every(function(term) {
                return normalizedText.indexOf(term) !== -1;
            });
        }

        if (hasStorePaymentParents) {
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                if (
                    !settings.nTable
                    || settings.nTable.id !== 'transactions_table'
                ) {
                    return true;
                }

                if (!activeStoreSearch) {
                    return true;
                }

                /*
                 * First search the normal parent-row DataTables data.
                 */
                const rowText = data.join(' ');

                if (
                    transactionTextMatches(
                        rowText,
                        activeStoreSearch
                    )
                ) {
                    return true;
                }

                /*
                 * If the visible parent itself does not match, keep it when one
                 * of its collapsed StoreCardPayment children matched the AJAX
                 * search endpoint.
                 */
                const rowData = settings.aoData[dataIndex];
                const rowNode = rowData
                    ? rowData.nTr
                    : null;

                if (!rowNode) {
                    return false;
                }

                const paymentLogId = parseInt(
                    $(rowNode).attr('data-payment-log-id'),
                    10
                );

                return (
                    !Number.isNaN(paymentLogId)
                    && storeSearchMatches.includes(paymentLogId)
                );
            });
        }

        const isMobilePaymentsTable =
            window.matchMedia('(max-width: 767px)').matches;

        /*
         * Keep the previously working desktop DataTables behaviour.
         * The newer mobile layout needs its own options, but those options
         * must not change the desktop table.
         */
        if (
            isMobilePaymentsTable
            && $.fn.DataTable.isDataTable('#transactions_table')
        ) {
            $('#transactions_table').DataTable().destroy();
        }

        const dataTableOptions = {
            colReorder: false,
            stateSave: !isMobilePaymentsTable,
            autoWidth: false,
            pageLength: 50,
            bSort: false,
            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'Search'
            }
        };

        if (isMobilePaymentsTable) {
            /*
             * Mobile-only options introduced by the new responsive UI.
             * Do not let these alter desktop row/collapse behaviour.
             */
            dataTableOptions.stateSave = false;
            dataTableOptions.bSort = true;
            dataTableOptions.ordering = true;
            dataTableOptions.columnDefs = [
                {
                    orderable: false,
                    targets: '_all'
                }
            ];

            dataTableOptions.initComplete = function () {
                $('#mobile-entries-sort-row')
                    .insertAfter(
                        $(this)
                            .closest('.dataTables_wrapper')
                            .find('.dataTables_filter')
                    );
            };
        }

        var usersTable =
            $('#transactions_table').DataTable(
                dataTableOptions
            );

        /*
         * These controls belong to the mobile redesign only.
         */
        if (isMobilePaymentsTable) {
            $('#entries-select-m')
                .off('change.receivedPayments')
                .on(
                    'change.receivedPayments',
                    function () {
                        usersTable
                            .page
                            .len(
                                parseInt(
                                    this.value,
                                    10
                                )
                            )
                            .draw();
                    }
                );

            (function () {
                var len =
                    String(
                        usersTable.page.len()
                    );

                var $entries =
                    $('#entries-select-m');

                if (
                    !$entries
                        .find(
                            'option[value="' +
                            len +
                            '"]'
                        )
                        .length
                ) {
                    $entries.append(
                        $('<option>', {
                            value: len,
                            text: len
                        })
                    );
                }

                $entries.val(len);
            })();

            $('#transactions_table_filter input')
                .attr(
                    'placeholder',
                    'Search by payment id'
                );

            $('#sort-select-m')
                .off('change.receivedPayments')
                .on(
                    'change.receivedPayments',
                    function () {
                        if (
                            this.value ===
                            'order_id'
                        ) {
                            usersTable
                                .order([
                                    2,
                                    'asc'
                                ])
                                .draw();
                        }
                    }
                );
        }

        if (hasStorePaymentParents) {

            function collapseStorePaymentRows() {
                $('#transactions_table tbody tr.payment-log-detail-row')
                    .remove();

                $('#transactions_table .show_store_payments')
                    .removeClass('expanded fa-chevron-down')
                    .addClass('fa-chevron-right');
            }

            /*
             * Detail rows are inserted manually and are not DataTables rows.
             * Remove them before a DataTables redraw so pagination/search never
             * leaves an orphaned expanded row on desktop.
             */
            usersTable.on(
                'preDraw.storePaymentDetails',
                function () {
                    collapseStorePaymentRows();

                    if (
                        typeof collapseNormalCardRefundRows
                        === 'function'
                    ) {
                        collapseNormalCardRefundRows();
                    }
                }
            );

            function expandMatchedStorePaymentRows() {
                if (
                    !activeStoreSearch
                    || !storeSearchMatches.length
                ) {
                    return;
                }

                /*
                 * Only auto-expand parents whose CHILD records matched.
                 * A normal match in the visible parent row can remain collapsed.
                 */
                $('#transactions_table tbody > tr').each(function() {
                    const $row = $(this);

                    if (
                        $row.hasClass('payment-log-detail-row')
                    ) {
                        return;
                    }

                    const paymentLogId = parseInt(
                        $row.attr('data-payment-log-id'),
                        10
                    );

                    if (
                        Number.isNaN(paymentLogId)
                        || !storeSearchMatches.includes(paymentLogId)
                    ) {
                        return;
                    }

                    const $icon =
                        $row.find('.show_store_payments');

                    if (
                        $icon.length
                        && !$icon.hasClass('expanded')
                    ) {
                        $icon.trigger('click');
                    }
                });
            }

            usersTable.on(
                'draw.collapsedStoreSearch',
                function() {
                    expandMatchedStorePaymentRows();
                }
            );

            const $searchInput =
                $('#transactions_table_filter input');

            /*
             * Remove only DataTables' built-in global-search events.
             * Our handler searches BOTH the visible parent rows and the
             * collapsed AJAX child records.
             */
            $searchInput.off(
                'keyup.DT input.DT search.DT'
            );

            $searchInput.off(
                '.collapsedStoreSearch'
            );

            $searchInput.on(
                'keyup.collapsedStoreSearch input.collapsedStoreSearch search.collapsedStoreSearch',
                function() {
                    const rawSearch =
                        $(this).val().trim();

                    activeStoreSearch =
                        normalizeTransactionSearch(rawSearch);

                    clearTimeout(storeSearchTimer);

                    if (storeSearchRequest) {
                        storeSearchRequest.abort();
                        storeSearchRequest = null;
                    }

                    /*
                     * Child rows inserted manually are not DataTables rows and can
                     * become stale after a search/draw. Remove them first.
                     */
                    collapseStorePaymentRows();

                    if (!activeStoreSearch) {
                        storeSearchMatches = [];

                        /*
                         * Keep DataTables' own global search empty. Filtering is
                         * handled by the ext.search callback above.
                         */
                        usersTable.search('').draw();

                        return;
                    }

                    storeSearchTimer = setTimeout(
                        function() {
                            storeSearchRequest = $.ajax({
                                url: "{{ route('transaction.search_store_payment_logs') }}",
                                method: 'GET',
                                dataType: 'json',
                                data: {
                                    search: rawSearch
                                },

                                success: function(response) {
                                    const serverMatches = (
                                        response.payment_log_ids
                                        || []
                                    )
                                    .map(function(id) {
                                        return parseInt(
                                            id,
                                            10
                                        );
                                    })
                                    .filter(function(id) {
                                        return !Number.isNaN(
                                            id
                                        );
                                    });

                                    /*
                                     * StoreCardPayment Customer Name lives in the
                                     * StoreOrder map supplied by the controller.
                                     * Include matching parent PaymentLog IDs here
                                     * so searching by customer name works even
                                     * before the collapsed child rows are opened.
                                     */
                                    const customerSearchTerms =
                                        normalizeTransactionSearch(
                                            rawSearch
                                        )
                                        .split(' ')
                                        .filter(Boolean);

                                    const customerMatches =
                                        storeCustomerSearchIndex
                                            .filter(function(item) {
                                                const customerName =
                                                    normalizeTransactionSearch(
                                                        item.customer_name
                                                    );

                                                return customerSearchTerms
                                                    .every(function(term) {
                                                        return customerName
                                                            .indexOf(term)
                                                            !== -1;
                                                    });
                                            })
                                            .map(function(item) {
                                                return parseInt(
                                                    item.parent_id,
                                                    10
                                                );
                                            })
                                            .filter(function(id) {
                                                return !Number.isNaN(
                                                    id
                                                );
                                            });

                                    storeSearchMatches = [
                                        ...new Set([
                                            ...serverMatches,
                                            ...customerMatches
                                        ])
                                    ];

                                    /*
                                     * DataTables' own text search stays empty.
                                     * ext.search decides whether each parent is
                                     * visible based on:
                                     *   1. parent-row text, OR
                                     *   2. collapsed-child server match.
                                     */
                                    usersTable
                                        .search('')
                                        .draw();
                                },

                                error: function(xhr, status) {
                                    if (status === 'abort') {
                                        return;
                                    }

                                    console.error(
                                        'Store payment search failed.',
                                        xhr.responseText
                                    );

                                    /*
                                     * Parent-row searching must still work even
                                     * if the nested search endpoint fails.
                                     */
                                    storeSearchMatches = [];

                                    usersTable
                                        .search('')
                                        .draw();
                                },

                                complete: function() {
                                    storeSearchRequest = null;
                                }
                            });
                        },
                        250
                    );
                }
            );
        }

        $('#pin-filter').click(function(e) {
            e.preventDefault();

            $(".se-pre-con").fadeIn('slow');

            // Get filter values
            var startDate = $('#start-date').val();
            var endDate = $('#end-date').val();
            var paymentType = $('#paymentType').val();
            var paymentStatus = $('#paymentStatus').val();
            var order_type = $('#order_type').val();

            // Build URL with query params
            let url = "{{ route('allTransactions') }}" +
                    "?start_date=" + encodeURIComponent(startDate) +
                    "&end_date=" + encodeURIComponent(endDate) +
                    "&payment_type=" + encodeURIComponent(paymentType) +
                    "&payment_status=" + encodeURIComponent(paymentStatus)+
                    "&order_type=" + encodeURIComponent(order_type);

            // Redirect page to filtered URL
            window.location.href = url;
        });
        $('#reset-filter').click(function(e) {
            e.preventDefault();

            $(".se-pre-con").fadeIn('slow');

            // Redirect to base route to show all transactions
            window.location.href = "{{ route('allTransactions') }}";
        });

        $(".se-pre-con").fadeOut('slow');
    });



    function exportReport() {
        const table = $('#transactions_table').DataTable();
        const headers = [
            'Transaction ID', 'Order #', 'Payment Type', 'Team Name', 'Name on Card',
            'Customer Name', 'Check Status', 'Amount', 'Order Payment Status',
            'Payment Date', 'Time', 'QuickBooks Sync'
        ];
        const rows = table.rows({ search: 'applied', order: 'applied', page: 'all' })
            .nodes().toArray().map(function (row) {
                const cells = row.cells;
                return [
                    ...[1, 2, 3, 4, 5, 6, 7].map(index => cells[index].textContent.trim()),
                    Number(cells[8].dataset.exportAmount),
                    cells[9].textContent.trim(),
                    cells[11].textContent.trim(),
                    cells[12].textContent.trim(),
                    row.dataset.quickbooksSynced
                ];
            });

        const csv = [headers, ...rows].map(row => row.map(function (value) {
            const safeValue = typeof value === 'string' && /^[=+@\-\t\r\n]/.test(value)
                ? "'" + value
                : (typeof value === 'number' ? value.toFixed(2) : String(value));
            return '"' + safeValue.replace(/"/g, '""') + '"';
        }).join(',')).join('\r\n');
        const url = URL.createObjectURL(new Blob(['\uFEFF', csv], { type: 'text/csv;charset=utf-8' }));
        const link = $('<a>').attr({ href: url, download: 'transactions_report.csv' }).appendTo('body');
        link[0].click();
        link.remove();
        setTimeout(() => URL.revokeObjectURL(url), 1000);
    }

    $(document).on('click', '.check-preview-open', function () {
        const modal = $('#paymentCheckPreview');
        const body = modal.find('.payment-check-preview').empty();
        [['Front', this.dataset.front], ['Back', this.dataset.back]].forEach(function ([side, url]) {
            const panel = $('<section>').appendTo(body);
            $('<h6>').text(side).appendTo(panel);
            const missing = () => $('<p>').addClass('text-muted').text('Image unavailable').appendTo(panel);
            if (!url) {
                missing();
                return;
            }
            const link = $('<a>').attr({ href: url, target: '_blank', rel: 'noopener' }).appendTo(panel);
            $('<img>').attr('alt', 'Check ' + side.toLowerCase()).one('error', function () {
                link.remove();
                missing();
            }).appendTo(link).attr('src', url);
        });
        modal.modal('show');
    });

    $(".payID").click(function() {
        $(".se-pre-con").fadeIn('slow');

        var paymentType = $(this).attr('data-transactionType');
        var orderNo = $(this).attr('data-orderNo');
        var display_order_no = ('000000' + orderNo).slice(-6);

        var imageContent = "";
        var paymentUrl = "payment?orderId=" + orderNo;

        // Title and images based on payment type
        if (paymentType === "Card") {
            $("#modal_title_notification").html("All Card Payments | Order #" + display_order_no);
        }
        if (paymentType === "Check") {
            $("#modal_title_notification").html("All Check Payments | Order #" + display_order_no);
            var frontImage = $(this).attr('data-checkfimage');
            var backImage = $(this).attr('data-checkbimage');
            imageContent = `
                <a class='check-image' download='${display_order_no}-check-front.jpg' href='{{asset('uploads')}}/../${frontImage}' title='Check Front'>
                    <img src='{{asset('uploads')}}/../${frontImage}'>
                </a>
                <a class='check-image' download='${display_order_no}-check-back.jpg' href='{{asset('uploads')}}/../${backImage}' title='Check Back'>
                    <img src='{{asset('uploads')}}/../${backImage}'>
                </a>
            `;
        }
        if (paymentType === "Venmo") {
            $("#modal_title_notification").html("All Venmo Payments | Order #" + display_order_no);
            var frontImage = $(this).attr('data-checkfimage');
            imageContent = `
                <a class='venmo-image' download='${display_order_no}-venmo.jpg' href='{{asset('uploads')}}/../${frontImage}' title='Venmo'>
                    <img src='{{asset('uploads')}}/../${frontImage}'>
                </a>
            `;
        }
        if (paymentType === "PO") {
            $("#modal_title_notification").html("All PO Payments | Order #" + display_order_no);
            var frontImage = $(this).attr('data-checkfimage');
            imageContent = `
                <a class='venmo-image' download='${display_order_no}-purchase_order.jpg' href='{{asset('uploads')}}/../${frontImage}' title='PO'>
                    <img src='{{asset('uploads')}}/../${frontImage}'>
                </a>
            `;
        }
        if (paymentType === "Other") {
            $("#modal_title_notification").html("All Other Payments | Order #" + display_order_no);
            var frontImage = $(this).attr('data-checkfimage');
            imageContent = `
                <a class='venmo-image' download='${display_order_no}-other_order.jpg' href='{{asset('uploads')}}/../${frontImage}' title='Other'>
                    <img src='{{asset('uploads')}}/../${frontImage}'>
                </a>
            `;
        }

        tableBodyPayments = "";
        rowNo = 1;
        totalPayments = 0;
        var clickedElement = $(this);

        $.ajax({
            url: "{{ url('transaction/get_order_payments') }}/",
            data : {
                orderID: orderNo,
                _token : "{{ csrf_token() }}"
            },
            method: 'GET',
            dataType: 'json',
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(response) {

                if (response.order_payments.length > 0) {

                    response.order_payments.forEach(function(item) {

                        totalPayments += parseFloat(item['Amount']) || 0;

                        var isClickedTransaction = '';

                        if (item['TransactionId'] == clickedElement.attr('data-value')) {
                            isClickedTransaction = 'style="background-color: #9cc775;"';
                        }

                        var datetimeString = item['PaymentDate'] || "";
                        var paidDate = datetimeString ? new Date(datetimeString) : null;

                        var date = "-";
                        var time = "-";

                        if (paidDate && !isNaN(paidDate)) {
                            var year = paidDate.getFullYear();
                            var month = String(paidDate.getMonth() + 1).padStart(2, '0');
                            var day = String(paidDate.getDate()).padStart(2, '0');
                            var hour = String(paidDate.getHours()).padStart(2, '0');
                            var minute = String(paidDate.getMinutes()).padStart(2, '0');
                            var second = String(paidDate.getSeconds()).padStart(2, '0');

                            date = `${month}-${day}-${year}`;
                            time = `${hour}:${minute}:${second}`;
                        }

                        tableBodyPayments += `
                            <tr ${isClickedTransaction}>
                                <td>${rowNo}</td>
                                <td>${item['Method'] || '-'}</td>
                                <td>${item['NameonCard'] || '-'}</td>
                                <td>${item['TransactionId'] || '-'}</td>
                                <td style="text-align:right;">$ ${parseFloat(item['Amount'] || 0).toFixed(2)}</td>
                                <td style="text-align:right;${item['is_approve'] == 1 ? 'color:green !important' : 'color:red !important'}">${item['is_approve'] == 1 ? 'Approved' : 'Not Approved'}</td>
                                <td>${date}</td>
                                <td style="border-bottom: 1px solid #e9ecef;">${time}</td>
                                <td style="border-bottom: 1px solid #e9ecef;" class="invoice_data_td" data-transaction-id='${item['id']}' data-transaction-method='${item['Method']}' data-order-id='${orderNo}'><i class="fa fa-eye view-payment-receipt" title="View Receipt" style="cursor:pointer !important" aria-hidden="true"></i><span class="mobile-action-label view-payment-receipt">View</span>&nbsp;&nbsp;<i class="fa fa-download download-payment-receipt" title="Download Receipt" style="cursor:pointer !important" aria-hidden="true"></i><span class="mobile-action-label download-payment-receipt">Export</span></td>
                            </tr>
                        `;
                        rowNo++;
                    });

                    var table = `
                        <table id="mobile_payments_table" style="margin: 0rem 2rem;" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Method</th>
                                    <th>Name on Card</th>
                                    <th>Transaction Id</th>
                                    <th class="text-right">Amount</th>
                                    <th>Approval</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Receipt</th>
                                </tr>
                            </thead>
                            <tbody>${tableBodyPayments}</tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="7" style="font-size: 15px; text-align: right;">Total Amount</th>
                                    <th class="text-right" style="font-size: 15px; padding-right: 36px;">$ ${totalPayments.toFixed(2)}</th>
                                </tr>
                            </tfoot>
                        </table>
                    `;

                    $("#check_payment").html(imageContent + table);

                    var modalFooter = `
                        <a style="background-color:#47D6B6;color:white" type="button" class="styled-button" target="_blank" href='{{ url("transaction/payments/invoice/") }}/${orderNo}'>Download Invoice</a>
                        <button style="color:white;background-color:#d65a47" type="button" class="styled-button ml-auto" data-dismiss="modal">Close</button>
                    `;
                    $("#modal-footer").html(modalFooter);

                    $('#notification_modal').modal('show');
                    $(".se-pre-con").fadeOut('slow');

                }
            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    });

    $(document).on('click', '.show_store_payments', function () {

        let $icon = $(this);
        let paymentLogId = $icon.data('payment-log-id');
        let $closestTr = $icon.closest('tr');

        if ($icon.hasClass('expanded')) {
            $closestTr.nextAll('.payment-log-row-' + paymentLogId).remove();
            $icon.removeClass('expanded');
            $icon.removeClass('fa-chevron-down').addClass('fa-chevron-right');
            return;
        }

        /*
         * Defensive cleanup: there must be only one detail row for this parent.
         */
        $('#transactions_table tbody .payment-log-row-' + paymentLogId)
            .remove();

        $.ajax({
            url: "{{ route('transaction.store_payment_log_details') }}",
            method: "GET",
            data: {
                paymentLogId: paymentLogId
            },
            dataType: "json",
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (response) {

                let contentHtml = '';

                const indPlayerBaseUrl = "{{ url('store/individual_player') }}";

                const allPayments = Array.isArray(response)
                    ? response
                    : [];

                /*
                 * During DataTables search, the AJAX endpoint tells us which
                 * PaymentLog parent contains a match. The detail endpoint still
                 * returns ALL children for that parent, so filter them here.
                 *
                 * When there is no search, keep the original behavior and show
                 * every child payment.
                 */
                const paymentsToRender = activeStoreSearch
                    ? allPayments.filter(function(payment) {
                        return storePaymentMatchesActiveSearch(payment);
                    })
                    : allPayments;

                if (paymentsToRender.length > 0) {

                    let rows = '';

                    /*
                     * Parent sync state must be based on all ELIGIBLE child
                     * payments, not only the currently searched/visible rows.
                     *
                     * Only successful StoreCardPayment rows are eligible for QBO
                     * import. Failed card attempts must not keep a parent from
                     * becoming fully synced.
                     */
                    const eligiblePayments = allPayments.filter(function(payment) {
                        return parseInt(payment.is_success || 0, 10) === 1;
                    });

                    const allChildrenSynced = (
                        eligiblePayments.length > 0
                        && eligiblePayments.every(function(payment) {
                            return getStoreQuickBooksStatus(payment) === 'synced';
                        })
                    );

                    paymentsToRender.forEach(function(payment) {

                        let statusBadge = '<span class="badge bg-danger">Failed</span>';

                        if (payment.is_success == 1 && payment.is_refund == 0) {
                            statusBadge = '<span class="badge bg-success">Successful</span>';
                        }

                        if (payment.is_success == 1 && payment.is_refund == 1) {
                            statusBadge = '<span class="badge bg-warning text-dark">Refunded</span>';
                        }

                        let createdAt = payment.created_at
                            ? new Date(payment.created_at)
                            : null;

                        let formattedDate = (
                            createdAt
                            && !Number.isNaN(createdAt.getTime())
                        )
                            ? createdAt.toLocaleDateString('en-US', {
                                month: 'short',
                                day: 'numeric',
                                year: 'numeric'
                            })
                            : '';

                        let formattedTime = (
                            createdAt
                            && !Number.isNaN(createdAt.getTime())
                        )
                            ? createdAt.toLocaleTimeString('en-US', {
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit',
                                hour12: false
                            })
                            : '';

                        const qbStatus = getStoreQuickBooksStatus(payment);
                        const isQuickBooksSynced = qbStatus === 'synced';

                        let checkStatus = '';
                        let disabledStatus = '';
                        let qbStatusIcon = getQuickBooksStatusIcon(qbStatus);

                        let parentCheckbox = $('.transaction-checkbox[data-value="' + paymentLogId + '"]');

                        // A successfully synced payment must never be selected again.
                        if (isQuickBooksSynced) {
                            disabledStatus = 'disabled';
                        } else if (
                            parentCheckbox.length
                            && parentCheckbox.is(':checked')
                        ) {
                            checkStatus = 'checked';
                        }

                        rows += `
                            <tr data-store-payment-id="${payment.id}">
                                <td style="text-align: center;">
                                    <div style="display:flex;align-items:center;justify-content:center;gap:8px;white-space:nowrap;">
                                        ${qbStatusIcon}
                                        <input
                                            type="checkbox"
                                            class="store-transaction-checkbox-${paymentLogId} store_transaction_record"
                                            data-parent-record="${paymentLogId}"
                                            data-value="${payment.id}"
                                            ${checkStatus}
                                            ${disabledStatus}
                                            title="${isQuickBooksSynced ? 'Already synced to QuickBooks' : 'Select for QuickBooks import'}"
                                        />
                                    </div>
                                </td>

                                <td>${payment.transaction_id ?? ''}</td>

                                <td>${payment.store_order_no
                                    ? `<a href="${indPlayerBaseUrl}/${payment.store_order_no}"
                                        target="_blank"
                                        class="text-decoration-none fw-semibold">
                                        ${payment.store_order_no}
                                    </a>`
                                    : ''
                                }</td>

                                <td>${payment.card_owner ?? ''}</td>

                                <td>${getStoreCustomerName(payment)}</td>

                                <td class="text-end">
                                    $${parseFloat(payment.payment_amount || 0).toFixed(2)}
                                </td>

                                <td class="text-end">
                                    $${parseFloat(payment.processing_fee || 0).toFixed(2)}
                                </td>

                                <td class="text-end">
                                    $${parseFloat(payment.total_amount || 0).toFixed(2)}
                                </td>

                                <td class="text-center">
                                    ${payment.is_refund == 1
                                        ? '<span class="badge bg-warning text-dark">Refund</span>'
                                        : '<span class="badge bg-info">Payment</span>'
                                    }
                                </td>

                                <td class="text-center">
                                    ${statusBadge}
                                </td>

                                <td>${formattedDate}</td>

                                <td class="text-center">
                                    ${formattedTime}
                                </td>
                            </tr>
                        `;
                    });

                    /*
                     * Keep the collapsed parent QuickBooks status correct.
                     *
                     * This updates the same FIRST-column icon regardless of your
                     * current Transaction ID / Order # / Payment Type column order.
                     */
                    const $parentQbStatusIcon = $(
                        '[data-parent-qb-status="' + paymentLogId + '"]'
                    );

                    const $parentCheckbox = $(
                        '.transaction-checkbox[data-value="' + paymentLogId + '"]'
                    );

                    if (allChildrenSynced) {

                        $parentQbStatusIcon.html(
                            '<i '
                            + 'class="fa fa-check-circle" '
                            + 'title="All StoreOrder payments synced to QuickBooks" '
                            + 'aria-label="All StoreOrder payments synced to QuickBooks" '
                            + 'style="color:#28a745;font-size:17px;"'
                            + '></i>'
                        );

                        $parentCheckbox
                            .prop('checked', false)
                            .prop('disabled', true)
                            .attr(
                                'title',
                                'All StoreOrder payments are already synced to QuickBooks'
                            );

                        /*
                         * If the parent had been selected before the child state
                         * was loaded, remove it from the QBO selection now.
                         */
                        removeSelectedTransaction(paymentLogId);

                    } else {

                        $parentQbStatusIcon.empty();

                        /*
                         * Only undo the disabled state if it was caused by the
                         * "all children synced" condition. Do not override another
                         * business rule that may have disabled the checkbox.
                         */
                        if (
                            $parentCheckbox.attr('title')
                            === 'All StoreOrder payments are already synced to QuickBooks'
                        ) {
                            $parentCheckbox
                                .prop('disabled', false)
                                .attr(
                                    'title',
                                    'Select for QuickBooks import'
                                );
                        }
                    }

                    contentHtml = `
                        <div class="p-1">
                            ${activeStoreSearch
                                ? `<div class="small text-muted mb-1">
                                    Showing ${paymentsToRender.length} matching payment record${paymentsToRender.length === 1 ? '' : 's'}
                                   </div>`
                                : ''
                            }

                            <table class="table table-sm table-bordered align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="min-width:135px;">QuickBooks / Select</th>
                                        <th>Transaction ID</th>
                                        <th>Store Order #</th>
                                        <th>Card Owner</th>
                                        <th>Customer Name</th>
                                        <th class="text-end">Payment</th>
                                        <th class="text-end">Fee</th>
                                        <th class="text-end">Total</th>
                                        <th class="text-center">Payment Type</th>
                                        <th class="text-center">Status</th>
                                        <th>Date</th>
                                        <th class="text-center">Time</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    ${rows}
                                </tbody>
                            </table>
                        </div>
                    `;

                } else {

                    contentHtml = `
                        <div class="p-4 text-center text-muted">
                            ${activeStoreSearch
                                ? 'No matching payment records found under this log.'
                                : 'No payment records found for this log.'
                            }
                        </div>
                    `;
                }

                let newRow = `
                    <tr class="payment-log-detail-row payment-log-row-${paymentLogId}">
                        <td colspan="14" style="background:#f8f9fa;">
                            ${contentHtml}
                        </td>
                    </tr>
                `;

                $closestTr.after(newRow);

                $icon.addClass('expanded');
                $icon.removeClass('fa-chevron-right').addClass('fa-chevron-down');

                updateStoreTransaction();
            },

            complete: function () {
                $(".se-pre-con").fadeOut('slow');
            }
        });

    });

    /*
     * Normal Order Card refund collapse.
     *
     * IMPORTANT:
     * This is separate from show_store_payments.
     * The working TSR AJAX collapse above is not replaced or wrapped.
     */
    function escapeCardRefundValue(value) {
        return $('<div>')
            .text(
                value === null || value === undefined
                    ? ''
                    : String(value)
            )
            .html();
    }

    function isNormalRefundSelected(refundId) {
        return selectedTransactions.some(function(item) {
            return String(item.id) === String(refundId)
                && String(item.type) === 'Card'
                && parseInt(item.auto_generated || 0, 10) === 0
                && parseInt(item.is_refund || 0, 10) === 1;
        });
    }

    function addNormalRefundSelection(refundId) {
        if (isNormalRefundSelected(refundId)) {
            return;
        }

        selectedTransactions.push({
            id: refundId,
            type: 'Card',
            auto_generated: 0,
            is_refund: 1
        });
    }

    function removeNormalRefundSelection(refundId) {
        selectedTransactions = selectedTransactions.filter(function(item) {
            return !(
                String(item.id) === String(refundId)
                && String(item.type) === 'Card'
                && parseInt(item.auto_generated || 0, 10) === 0
                && parseInt(item.is_refund || 0, 10) === 1
            );
        });
    }

    function collapseNormalCardRefundRows(paymentLogId) {
        if (paymentLogId !== undefined && paymentLogId !== null) {
            $('#transactions_table tbody .card-refund-row-' + paymentLogId)
                .remove();

            $('.show_card_refunds[data-payment-log-id="' + paymentLogId + '"]')
                .removeClass('expanded fa-chevron-down')
                .addClass('fa-chevron-right');

            return;
        }

        $('#transactions_table tbody .card-refund-detail-row')
            .remove();

        $('#transactions_table .show_card_refunds')
            .removeClass('expanded fa-chevron-down')
            .addClass('fa-chevron-right');
    }

    $(document).on('click', '.show_card_refunds', function (event) {
        event.preventDefault();
        event.stopPropagation();

        const $icon = $(this);
        const paymentLogId = String(
            $icon.data('payment-log-id')
        );
        const $closestTr = $icon.closest('tr');

        if ($icon.hasClass('expanded')) {
            collapseNormalCardRefundRows(paymentLogId);
            return;
        }

        const refunds = Array.isArray(
            cardRefundRecordsMap[paymentLogId]
        )
            ? cardRefundRecordsMap[paymentLogId]
            : [];

        let contentHtml = '';

        if (refunds.length > 0) {
            let rows = '';

            refunds.forEach(function(refund) {
                const isSuccessful =
                    parseInt(refund.is_success || 0, 10) === 1;

                const qbStatus =
                    refund.qb_status || null;

                const isQuickBooksSynced =
                    qbStatus === 'synced';

                const isSelected =
                    isNormalRefundSelected(
                        refund.id
                    );

                const disabled =
                    !isSuccessful
                    || isQuickBooksSynced;

                const createdAt =
                    refund.created_at
                        ? new Date(refund.created_at)
                        : null;

                const hasValidDate =
                    createdAt
                    && !Number.isNaN(
                        createdAt.getTime()
                    );

                const formattedDate =
                    hasValidDate
                        ? createdAt.toLocaleDateString(
                            'en-US',
                            {
                                month: 'short',
                                day: 'numeric',
                                year: 'numeric'
                            }
                        )
                        : '';

                const formattedTime =
                    hasValidDate
                        ? createdAt.toLocaleTimeString(
                            'en-US',
                            {
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit',
                                hour12: false
                            }
                        )
                        : '';

                const statusBadge =
                    isSuccessful
                        ? '<span class="badge badge-success">Successful</span>'
                        : '<span class="badge badge-danger">Failed</span>';

                const qbStatusIcon =
                    getQuickBooksStatusIcon(
                        qbStatus
                    );

                let checkboxTitle =
                    'Select refund for QuickBooks import';

                if (!isSuccessful) {
                    checkboxTitle =
                        'Failed refund attempts cannot be synced';
                } else if (isQuickBooksSynced) {
                    checkboxTitle =
                        'Already synced to QuickBooks';
                }

                const userText =
                    refund.user_name
                    || (
                        refund.user_id
                            ? 'User #' + refund.user_id
                            : 'System'
                    );

                rows += `
                    <tr data-card-refund-id="${refund.id}">
                        <td style="text-align:center;">
                            <div style="display:flex;align-items:center;justify-content:center;gap:8px;white-space:nowrap;">
                                ${qbStatusIcon}

                                <input
                                    type="checkbox"
                                    class="normal-refund-transaction-record"
                                    data-value="${refund.id}"
                                    ${isSelected && !disabled ? 'checked' : ''}
                                    ${disabled ? 'disabled' : ''}
                                    title="${checkboxTitle}"
                                />
                            </div>
                        </td>

                        <td>
                            REF${String(refund.id).padStart(6, '0')}
                        </td>

                        <td>
                            ${escapeCardRefundValue(
                                refund.transaction_id || ''
                            )}
                        </td>

                        <td class="text-right">
                            $${parseFloat(
                                refund.refund_amount || 0
                            ).toFixed(2)}
                        </td>

                        <td class="text-right">
                            $${parseFloat(
                                refund.processing_fee || 0
                            ).toFixed(2)}
                        </td>

                        <td class="text-right">
                            $${parseFloat(
                                refund.amount || 0
                            ).toFixed(2)}
                        </td>

                        <td class="text-center">
                            ${statusBadge}
                        </td>

                        <td>
                            ${escapeCardRefundValue(
                                userText
                            )}
                        </td>

                        <td>
                            ${formattedDate}
                        </td>

                        <td class="text-center">
                            ${formattedTime}
                        </td>
                    </tr>
                `;
            });

            contentHtml = `
                <div class="p-1">
                    <div
                        class="small mb-2"
                        style="color:#d65a47;font-weight:600;"
                    >
                        Card Refund History
                    </div>

                    <table
                        class="table table-sm table-bordered align-middle mb-0"
                    >
                        <thead class="table-light">
                            <tr>
                                <th style="min-width:135px;">
                                    QuickBooks / Select
                                </th>
                                <th>Refund ID</th>
                                <th>Original Transaction ID</th>
                                <th class="text-right">Refund</th>
                                <th class="text-right">Fee</th>
                                <th class="text-right">Full Amount</th>
                                <th class="text-center">Status</th>
                                <th>User</th>
                                <th>Date</th>
                                <th class="text-center">Time</th>
                            </tr>
                        </thead>

                        <tbody>
                            ${rows}
                        </tbody>
                    </table>
                </div>
            `;
        } else {
            contentHtml = `
                <div class="p-4 text-center text-muted">
                    No refund records found for this card payment.
                </div>
            `;
        }

        const newRow = `
            <tr
                class="card-refund-detail-row card-refund-row-${paymentLogId}"
            >
                <td
                    colspan="14"
                    style="background:#fff8f8;"
                >
                    ${contentHtml}
                </td>
            </tr>
        `;

        $closestTr.after(newRow);

        $icon
            .addClass('expanded')
            .removeClass('fa-chevron-right')
            .addClass('fa-chevron-down');
    });

    $(document).on(
        'change',
        '.normal-refund-transaction-record',
        function() {
            if ($(this).is(':disabled')) {
                return;
            }

            const refundId =
                $(this).data('value');

            if ($(this).is(':checked')) {
                addNormalRefundSelection(
                    refundId
                );
            } else {
                removeNormalRefundSelection(
                    refundId
                );
            }

            ShowImportButton();
        }
    );

    var selectedTransactions = [];
    var selectedStoreTransactions = [];

    function addSelectedTransaction(transactionId, paymentType, isAutoGenerated) {
        if (!selectedTransactions.some(function(item) {
            return String(item.id) === String(transactionId)
                && String(item.type) === String(paymentType)
                && parseInt(item.auto_generated, 10) === parseInt(isAutoGenerated, 10);
        })) {
            selectedTransactions.push({
                id: transactionId,
                type: paymentType,
                auto_generated: isAutoGenerated
            });
        }
    }

    function removeSelectedTransaction(transactionId) {
        selectedTransactions = selectedTransactions.filter(function(item) {
            return String(item.id) !== String(transactionId);
        });
    }

    $(document).on('click', '.transaction-checkbox', function() {
        if ($(this).is(':disabled')) {
            return;
        }

        var transactionId = $(this).data('value');
        var paymentType = $(this).data('type');
        var isAutoGenerated = parseInt($(this).data('auto-generated'), 10);

        let $childCheckboxes = $('.store-transaction-checkbox-' + transactionId + ':not(:disabled)');

        if ($(this).is(':checked')) {
            if (isAutoGenerated === 1 && !$childCheckboxes.length) {
                // Do not make the parent importable until its actual StoreCardPayment
                // children have loaded. This prevents a parent-only request with an
                // empty store_transactions payload.
                removeSelectedTransaction(transactionId);

                const $icon = $('.show_store_payments[data-payment-log-id="' + transactionId + '"]');
                if ($icon.length && !$icon.hasClass('expanded')) {
                    $icon.trigger('click');
                }
            } else {
                addSelectedTransaction(transactionId, paymentType, isAutoGenerated);

                if (isAutoGenerated === 1) {
                    $childCheckboxes.prop('checked', true);
                }
            }
        } else {
            removeSelectedTransaction(transactionId);

            if (isAutoGenerated === 1 && $childCheckboxes.length) {
                $childCheckboxes.prop('checked', false);
            }
        }

        updateStoreTransaction();
    });

    function ShowImportButton() {
        if(selectedTransactions.length > 0 || selectedStoreTransactions.length > 0){
            $('.import-to-quickbooks').show();
        }else{
            $('.import-to-quickbooks').hide();
        }
    }

    $(document).on('click', '.store_transaction_record', function(){
        updateStoreTransaction();
    });

    function updateStoreTransaction() {
        // Rebuild the child selection list every time.  The old code only added
        // items and did not remove them when a child checkbox was unchecked.
        selectedStoreTransactions = [];

        $('.store_transaction_record:checked:not(:disabled)').each(function () {
            selectedStoreTransactions.push({
                id: $(this).data('value'),
                parentId: $(this).data('parent-record')
            });
        });

        // Synchronize each loaded StoreOrder parent checkbox/selection with its
        // currently selected, unsynced child records.
        $('.transaction-checkbox[data-auto-generated="1"]').each(function () {
            const $parent = $(this);
            const parentId = $parent.data('value');
            const paymentType = $parent.data('type');
            const $loadedChildren = $('.store-transaction-checkbox-' + parentId);

            // Do not alter a parent before its nested records have loaded.
            if (!$loadedChildren.length) {
                return;
            }

            const selectedChildCount = $loadedChildren.filter(':checked:not(:disabled)').length;
            const selectableChildCount = $loadedChildren.filter(':not(:disabled)').length;

            if (selectedChildCount > 0) {
                $parent.prop('checked', true);
                addSelectedTransaction(parentId, paymentType, 1);
            } else {
                $parent.prop('checked', false);
                removeSelectedTransaction(parentId);
            }

            if (selectableChildCount === 0) {
                $parent.prop('disabled', true);
                removeSelectedTransaction(parentId);
            }
        });

        ShowImportButton();
    }

    $(document).on('click', '.import-to-quickbooks', function () {

        if (selectedTransactions.length === 0 && selectedStoreTransactions.length === 0) {
            swal("No transactions selected",
                "Please select at least one transaction to import.",
                "warning");
            return;
        }

        var exportURL = '{{ route("quickbooks.import_to_quickbooks") }}'
            + '?transactions=' + encodeURIComponent(JSON.stringify(selectedTransactions))
            + '&store_transactions=' + encodeURIComponent(JSON.stringify(selectedStoreTransactions));

        window.location.href = exportURL;
    });

    $("body").on("click", ".edit-order", function(){
        var orderId = $(this).data('value');
        window.open('order_details/edit/'+orderId+'/order?active_tab=order', '_blank');
    });

    $("body").on("click", ".download-payment-receipt", function() {
        var transactionID = $(this).closest('.invoice_data_td').data('transaction-id');
        var transactionMethod = $(this).closest('.invoice_data_td').data('transaction-method');
        var orderID = $(this).closest('.invoice_data_td').data('order-id');
        downloadPaymentReceipt(transactionID, transactionMethod, orderID, true);

    });
    $("body").on("click", ".view-payment-receipt", function() {
        var transactionID = $(this).closest('.invoice_data_td').data('transaction-id');
        var transactionMethod = $(this).closest('.invoice_data_td').data('transaction-method');
        var orderID = $(this).closest('.invoice_data_td').data('order-id');

        downloadPaymentReceipt(transactionID, transactionMethod, orderID, false);

    });

    function downloadPaymentReceipt(transactionID, transactionMethod, orderID, is_download) {

        $.ajax({
            url: "{{ url('transaction/get_payment_receipt_data') }}/",
            data : {
                orderID: orderID,
                transactionID: transactionID,
                transactionMethod: transactionMethod,
                _token : "{{ csrf_token() }}"
            },
            method: 'GET',
            dataType: 'json',
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(response) {

                var paymentDetails = response.payment_receipt[0];
                var orderDetails = response.orderDetails;

                let paymentDate = paymentDetails['PaymentDate'];
                let formattedDate = '';

                if (paymentDate) {
                    let dateObj = new Date(paymentDate);
                    let month = ('0' + (dateObj.getMonth() + 1)).slice(-2);
                    let day = ('0' + dateObj.getDate()).slice(-2);
                    let year = dateObj.getFullYear();
                    let hours = ('0' + dateObj.getHours()).slice(-2);
                    let minutes = ('0' + dateObj.getMinutes()).slice(-2);
                    let seconds = ('0' + dateObj.getSeconds()).slice(-2);

                    formattedDate = `${month}-${day}-${year} ${hours}:${minutes}:${seconds}`;
                }

                var discountAmount = 0.00;
                var order_total_amount = parseFloat(orderDetails.sub_total) + parseFloat(orderDetails.artwork);

                if (orderDetails.discount_hidation == 1) {
                    if (orderDetails.discountType == 1) {
                        discountAmount = (order_total_amount / 100) * parseFloat(orderDetails.discount);
                    } else if (orderDetails.discountType == 2) {
                        discountAmount = parseFloat(orderDetails.discount);
                    }
                }

                var receiptHTML = `
                        <!DOCTYPE html>
                        <html lang="en">
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>Payment Receipt</title>
                        </head>
                        <body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9;">
                            <div style="width: 700px; margin: 20px auto; background: #fff; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                                <div style="text-align: center; margin-bottom: 20px;">
                                    <h1 style="font-size: 22px; margin: 0; color: #333;">Payment Receipt</h1>
                                </div>

                                <div style="margin: 20px 0;">
                                    <div style="font-size: 16px; font-weight: bold; border-bottom: 2px solid #ddd; padding-bottom: 5px; margin-bottom: 15px;">Transaction Details</div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Date:</div>
                                        <div style="color: #333;">${formattedDate}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Order ID:</div>
                                        <div style="color: #333;">#${orderDetails.order_no}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Transaction ID:</div>
                                        <div style="color: #333;">${paymentDetails['TransactionId']}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Customer Name:</div>
                                        <div style="color: #333;">${paymentDetails['NameonCard']}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Payment Method:</div>
                                        <div style="color: #333;">${paymentDetails['Method']}</div>
                                    </div>

                                    ${(paymentDetails['Method'] == 'Card' || paymentDetails['Method'] == 'Paypal') ? `
                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Amount Paid ($):</div>
                                        <div style="color: #333;">${(paymentDetails['Method'] == 'Card' || paymentDetails['Method'] == 'Paypal' ? (parseFloat(paymentDetails['Amount']) * 100 / 103) : parseFloat(paymentDetails['Amount'])).toFixed(2)}</div>
                                    </div>
                                    ` : ``}

                                    ${(paymentDetails['Method'] == 'Card' || paymentDetails['Method'] == 'Paypal') ? `
                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Processing Fee Paid (3%) ($):</div>
                                        <div style="color: #333;">${(parseFloat(paymentDetails['Amount']) * 3 / 103 || 0).toFixed(2)}</div>
                                    </div>
                                    ` : ``}

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Total amount Paid ($):</div>
                                        <div style="color: #333;">${(parseFloat(paymentDetails['Amount']) || 0).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Status:</div>
                                        <div style="${paymentDetails['is_approve'] == 1 ? 'color:green' : 'color:red'};">${paymentDetails['is_approve'] == 1 ? 'Approved' : 'Not Approved'}</div>
                                    </div>
                                </div>

                                <div style="margin: 20px 0;">
                                    <div style="font-size: 16px; font-weight: bold; border-bottom: 2px solid #ddd; padding-bottom: 5px; margin-bottom: 15px;">Order Summary</div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: black;">Invoice Amount ($):</div>
                                        <div style="color: black;">${(parseFloat(orderDetails.sub_total) || 0).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Artwork & Other Fees ($):</div>
                                        <div style="color: #333;">${(parseFloat(orderDetails.artwork) || 0).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Discount ($):</div>
                                        <div style="color: #333;">${discountAmount.toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: black;">Total invoice amount ($):</div>
                                        <div style="color: black;">${(parseFloat(orderDetails.artwork) + parseFloat(orderDetails.sub_total) - discountAmount).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Sales Tax (${(orderDetails.sales_tax_rate ?? 0)}%) ($):</div>
                                        <div style="color: #333;">${(orderDetails.sales_tax || 0).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Shipping ($):</div>
                                        <div style="color: #333;">${(orderDetails.shipping || 0).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 10px 0; font-size: .9rem;">
                                        <div style="font-weight: bold; color: black;">Grand total ($):
                                            <p style="color: grey; font-weight: 100; font-size: .7rem; margin: 0;">(Invoice amount + Sales Tax + shipping)</p>
                                        </div>
                                        <div style="color: black; font-weight: bold;">${orderDetails.order_total.toFixed(2)}</div>
                                    </div>

                                    ${parseFloat(paymentDetails['total_payment']) > 0 ? `
                                        <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div style="font-weight: bold; color: #555;">Paid Amount ($):</div>
                                            <div style="color: #333;">${(parseFloat(paymentDetails['total_payment']) || 0).toFixed(2)}</div>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div style="font-weight: bold; color: #555;">Paid Processing Fee ($):</div>
                                            <div style="color: #333;">${(parseFloat(paymentDetails['ProcessingFee']) || 0).toFixed(2)}</div>
                                        </div>
                                    ` : ``}

                                    ${parseFloat(paymentDetails['balance_to_be_paid']) > 0 ? `
                                        <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div style="font-weight: bold; color: black;">Balance to Pay ($):</div>
                                            <div style="color: black;">${parseFloat(paymentDetails['balance_to_be_paid']).toFixed(2)}</div>
                                        </div>
                                    ` : ``}

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Order Status:</div>
                                        <div style="color: ${paymentDetails['paymentStatus'] == 'Pending' ? 'grey' : paymentDetails['paymentStatus'] == 'Partial' ? 'red' : paymentDetails['paymentStatus'] == 'Paid' ? 'green' : 'grey'};">${paymentDetails['paymentStatus']}</div>
                                    </div>
                                </div>

                                <div style="text-align: center; margin: 20px 0;">
                                    <h2 style="color: #333;">Thank you for your business!</h2>
                                    <img src="{{ asset('argon/img/encore/logo_dark.png') }}" alt="Logo" style="width: 350px;">
                                </div>
                            </div>
                        </body>
                        </html>
                        `;

                        /*
                         * Mobile gets its own "Payment Receipt" markup
                         */
                        if (!is_download && window.innerWidth <= 767) {

                            var receiptStatusColors = {
                                'Paid':    { bg: '#e5f6dc', color: '#3a9d23' },
                                'Partial': { bg: '#dbeafe', color: '#1d4ed8' },
                                'Pending': { bg: '#f1f1f1', color: '#6b7280' }
                            };
                            var receiptStatusStyle =
                                receiptStatusColors[paymentDetails['paymentStatus']]
                                || receiptStatusColors['Pending'];

                            var mobileReceiptHTML = `
                                <div class="receipt-m">
                                    <div class="receipt-m-section">
                                        <button type="button" class="receipt-m-toggle" onclick="toggleReceiptSection('receiptTxnDetailsBody', this)">
                                            <span>Transaction Details</span>
                                            <i class="fa fa-chevron-right"></i>
                                        </button>
                                        <div class="receipt-m-toggle-body" id="receiptTxnDetailsBody" style="display:none;">
                                            <div class="receipt-m-row"><span>Date</span><span>${formattedDate}</span></div>
                                            <div class="receipt-m-row"><span>Order ID</span><span>#${orderDetails.order_no}</span></div>
                                            <div class="receipt-m-row"><span>Transaction ID</span><span>${paymentDetails['TransactionId']}</span></div>
                                            <div class="receipt-m-row"><span>Customer Name</span><span>${paymentDetails['NameonCard']}</span></div>
                                            <div class="receipt-m-row"><span>Payment Method</span><span>${paymentDetails['Method']}</span></div>
                                            ${(paymentDetails['Method'] == 'Card' || paymentDetails['Method'] == 'Paypal') ? `
                                            <div class="receipt-m-row"><span>Amount Paid ($)</span><span>${(parseFloat(paymentDetails['Amount']) * 100 / 103 || 0).toFixed(2)}</span></div>
                                            <div class="receipt-m-row"><span>Processing Fee Paid (3%) ($)</span><span>${(parseFloat(paymentDetails['Amount']) * 3 / 103 || 0).toFixed(2)}</span></div>
                                            ` : ``}
                                            <div class="receipt-m-row"><span>Total amount Paid ($)</span><span>${(parseFloat(paymentDetails['Amount']) || 0).toFixed(2)}</span></div>
                                            <div class="receipt-m-row"><span>Status</span><span style="${paymentDetails['is_approve'] == 1 ? 'color:#1a7a4c' : 'color:#d65a47'};font-weight:600;">${paymentDetails['is_approve'] == 1 ? 'Approved' : 'Not Approved'}</span></div>
                                        </div>
                                    </div>

                                    <div class="receipt-m-card">
                                        <button type="button" class="receipt-m-card-header" onclick="toggleReceiptSection('receiptOrderSummaryBody', this)">
                                            <span>Order Summary</span>
                                            <i class="fa fa-chevron-down"></i>
                                        </button>
                                        <div class="receipt-m-card-body" id="receiptOrderSummaryBody">
                                            <div class="receipt-m-row"><span>Invoice Amount ($)</span><span>${(parseFloat(orderDetails.sub_total) || 0).toFixed(2)}</span></div>
                                            <div class="receipt-m-row muted"><span>Artwork & Other Fees ($)</span><span>${(parseFloat(orderDetails.artwork) || 0).toFixed(2)}</span></div>
                                            <div class="receipt-m-row muted"><span>Discount ($)</span><span>${discountAmount.toFixed(2)}</span></div>
                                            <div class="receipt-m-row"><span>Total invoice amount ($)</span><span>${(parseFloat(orderDetails.artwork) + parseFloat(orderDetails.sub_total) - discountAmount).toFixed(2)}</span></div>
                                            <div class="receipt-m-row muted"><span>Sales Tax (${(orderDetails.sales_tax_rate ?? 0)}%) ($)</span><span>${(orderDetails.sales_tax || 0).toFixed(2)}</span></div>
                                            <div class="receipt-m-row muted"><span>Shipping ($)</span><span>${(orderDetails.shipping || 0).toFixed(2)}</span></div>
                                        </div>
                                    </div>

                                    <div class="receipt-m-totals">
                                            <div class="receipt-m-row bold"><span>Grand Total</span><span>${orderDetails.order_total.toFixed(2)}</span></div>
                                            ${parseFloat(paymentDetails['total_payment']) > 0 ? `
                                            <div class="receipt-m-row muted"><span>Paid Amount ($)</span><span style="color:#3a9d23;">${(parseFloat(paymentDetails['total_payment']) || 0).toFixed(2)}</span></div>
                                            <div class="receipt-m-row muted"><span>Paid Processing Fee ($)</span><span>${(parseFloat(paymentDetails['ProcessingFee']) || 0).toFixed(2)}</span></div>
                                            ` : ``}
                                            ${parseFloat(paymentDetails['balance_to_be_paid']) > 0 ? `
                                            <div class="receipt-m-row"><span>Balance to Pay ($)</span><span style="color:#e01e1e;">${parseFloat(paymentDetails['balance_to_be_paid']).toFixed(2)}</span></div>
                                            ` : ``}
                                            <div class="receipt-m-row muted">
                                                <span>Order Status</span>
                                                <span class="receipt-m-status" style="background:${receiptStatusStyle.bg};color:${receiptStatusStyle.color};">${paymentDetails['paymentStatus']}</span>
                                            </div>
                                    </div>

                                    <div class="receipt-m-footer">
                                        <p>Thank you for your business!</p>
                                        <img src="{{ asset('argon/img/encore/logo_dark.png') }}" alt="Encore Custom">
                                    </div>
                                </div>
                            `;

                            $('#receiptModalBody').html(mobileReceiptHTML);
                            $('#receiptModal').modal('show');

                        } else if (is_download) {

                        var opt = {
                            margin: 0.5,
                            filename: 'payment-receipt-' + orderDetails.order_no + '.pdf',
                            image: { type: 'jpeg', quality: 0.98 },
                            html2canvas: { scale: 2 },
                            jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
                        };

                        // Create a temporary element
                        var element = document.createElement('div');
                        element.innerHTML = receiptHTML;
                        document.body.appendChild(element);

                        // Use html2pdf to generate PDF
                        html2pdf().from(element).set(opt).save().then(() => {
                            document.body.removeChild(element); // Clean up
                        });

                        } else {

                            // Insert the receiptHTML inside modal body
                            $('#receiptModalBody').html(receiptHTML);

                            // Show the modal
                            $('#receiptModal').modal('show');
                        }
                $(".se-pre-con").fadeOut('slow');
            },
            complete: function () {
            }
        });



    }
    $("body").on("click", ".payment-refund", function() {
        var transactionID = $(this).data('transaction-id');
        var transactionMethod = $(this).data('transaction-method');
        var orderID = $(this).data('order-id');


        $.ajax({
            url: "{{ url('transaction/get_payment_receipt_data') }}/",
            data : {
                orderID: orderID,
                transactionID: transactionID,
                transactionMethod: transactionMethod,
                _token : "{{ csrf_token() }}"
            },
            method: 'GET',
            dataType: 'json',
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(response) {

                var paymentDetails = response.payment_receipt[0];
                var orderDetails = response.orderDetails;

                let paymentDate = paymentDetails['PaymentDate'];
                let formattedDate = '';

                if (paymentDate) {
                    let dateObj = new Date(paymentDate);
                    let month = ('0' + (dateObj.getMonth() + 1)).slice(-2);
                    let day = ('0' + dateObj.getDate()).slice(-2);
                    let year = dateObj.getFullYear();
                    let hours = ('0' + dateObj.getHours()).slice(-2);
                    let minutes = ('0' + dateObj.getMinutes()).slice(-2);
                    let seconds = ('0' + dateObj.getSeconds()).slice(-2);

                    formattedDate = `${month}-${day}-${year} ${hours}:${minutes}:${seconds}`;
                }

                var discountAmount = 0.00;
                var order_total_amount = orderDetails.sub_total + orderDetails.artwork;

                if (orderDetails.discount_hidation == 1) {
                    if (orderDetails.discountType == 1) {
                        discountAmount = (order_total_amount / 100) * orderDetails.discount;
                    } else if (orderDetails.discountType == 2) {
                        discountAmount = orderDetails.discount;
                    }
                }

                var receiptHTML = `
                            <div style="width: auto; background: #fff; padding: 0px 20px;">
                                <div style="text-align: center; margin-bottom: 20px;">
                                    <h1 style="font-size: 22px; margin: 0; color: #333;">Payment Details</h1>
                                </div>

                                <div style="margin: 20px 0;">
                                    <div style="font-size: 16px; font-weight: bold; border-bottom: 2px solid #ddd; padding-bottom: 5px; margin-bottom: 15px;">Transaction Details</div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Date:</div>
                                        <div style="color: #333;">${formattedDate}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Order ID:</div>
                                        <div style="color: #333;">#${orderDetails.order_no}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Transaction ID:</div>
                                        <div style="color: #333;">${paymentDetails['TransactionId']}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Customer Name:</div>
                                        <div style="color: #333;">${paymentDetails['NameonCard']}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Payment Method:</div>
                                        <div style="color: #333;">${paymentDetails['Method']}</div>
                                    </div>

                                    ${(paymentDetails['Method'] == 'Card' || paymentDetails['Method'] == 'Paypal') ? `
                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Amount Paid ($):</div>
                                        <div style="color: #333;">${(paymentDetails['Method'] == 'Card' || paymentDetails['Method'] == 'Paypal' ? (paymentDetails['Amount'] * 100 / 103) : paymentDetails['Amount']).toFixed(2)}</div>
                                    </div>
                                    ` : ``}

                                    ${(paymentDetails['Method'] == 'Card' || paymentDetails['Method'] == 'Paypal') ? `
                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Processing Fee Paid (3%) ($):</div>
                                        <div style="color: #333;">${(paymentDetails['Amount'] * 3 / 103 || 0).toFixed(2)}</div>
                                    </div>
                                    ` : ``}

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Total amount Paid ($):</div>
                                        <div style="color: #333;">${(paymentDetails['Amount'] || 0).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Status:</div>
                                        <div style="${paymentDetails['is_approve'] == 1 ? 'color:green' : 'color:red'};">${paymentDetails['is_approve'] == 1 ? 'Approved' : 'Not Approved'}</div>
                                    </div>
                                </div>

                                <div style="margin: 20px 0;">
                                    <div style="font-size: 16px; font-weight: bold; border-bottom: 2px solid #ddd; padding-bottom: 5px; margin-bottom: 15px;">Order Summary</div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: black;">Invoice Amount ($):</div>
                                        <div style="color: black;">${(orderDetails.sub_total || 0).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Artwork & Other Fees ($):</div>
                                        <div style="color: #333;">${(orderDetails.artwork || 0).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Discount ($):</div>
                                        <div style="color: #333;">${discountAmount.toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: black;">Total invoice amount ($):</div>
                                        <div style="color: black;">${(orderDetails.artwork + orderDetails.sub_total - discountAmount).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Sales Tax (${(orderDetails.sales_tax_rate ?? 0)}%) ($):</div>
                                        <div style="color: #333;">${(orderDetails.sales_tax || 0).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Shipping ($):</div>
                                        <div style="color: #333;">${(orderDetails.shipping || 0).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 10px 0; font-size: .9rem;">
                                        <div style="font-weight: bold; color: black;">Grand total ($):
                                            <p style="color: grey; font-weight: 100; font-size: .7rem; margin: 0;">(Invoice amount + Sales Tax + shipping)</p>
                                        </div>
                                        <div style="color: black; font-weight: bold;">${orderDetails.order_total.toFixed(2)}</div>
                                    </div>

                                    ${paymentDetails['total_payment'] > 0 ? `
                                        <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div style="font-weight: bold; color: #555;">Paid Amount ($):</div>
                                            <div style="color: #333;">${(paymentDetails['total_payment'] || 0).toFixed(2)}</div>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div style="font-weight: bold; color: #555;">Paid Processing Fee ($):</div>
                                            <div style="color: #333;">${(paymentDetails['ProcessingFee'] || 0).toFixed(2)}</div>
                                        </div>
                                    ` : ``}

                                    ${paymentDetails['balance_to_be_paid'] > 0 ? `
                                        <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div style="font-weight: bold; color: black;">Balance to Pay ($):</div>
                                            <div style="color: black;">${paymentDetails['balance_to_be_paid'].toFixed(2)}</div>
                                        </div>
                                    ` : ``}

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Order Status:</div>
                                        <div style="color: ${paymentDetails['paymentStatus'] == 'Pending' ? 'grey' : paymentDetails['paymentStatus'] == 'Partial' ? 'red' : paymentDetails['paymentStatus'] == 'Paid' ? 'green' : 'grey'};">${paymentDetails['paymentStatus']}</div>
                                    </div>

                                    ${(paymentDetails['total_payment'] - orderDetails.order_total)  > 0 ? `
                                        <div style="display: flex; justify-content: space-between; padding: 5px 0;border-top: 1px solid #707070;border-bottom: 1px solid #707070;">
                                            <div style="font-weight: bold; color: black;">For Refund ($):</div>
                                            <div style="color: black;">
                                                <button type="button" class="btn btn-success btn-sm payment-refund-btn" data-transaction-id="${transactionID}"
                                                data-transaction-method="${transactionMethod}"
                                                data-order-id="${orderID}">
                                                    <i class="fa fa-undo" aria-hidden="true"></i>
                                                </button>
                                                ${(paymentDetails['total_payment'] - orderDetails.order_total).toFixed(2)}
                                            </div>
                                        </div>
                                    ` : ``}

                                </div>

                                <div style="text-align: center; margin: 20px 0;">

                                </div>
                            </div>
                        `;

                        $('#redundModalBody').html(receiptHTML);

                        $('#redundModal').modal('show');
                        $(".se-pre-con").fadeOut('slow');
            },
            complete: function () {
            }
        });


        const cardRefundDetailsUrl = '{{ route("transaction.refund_details") }}';
        const cardRefundSubmitUrl = '{{ route("transaction.refund_excess") }}';

        function formatRefundMoney(value) {
            const amount = parseFloat(value || 0);

            if (Number.isNaN(amount)) {
                return '$0.00';
            }

            return '$' + amount.toFixed(2);
        }

        function escapeRefundHtml(value) {
            return $('<div>')
                .text(value === null || value === undefined ? '' : String(value))
                .html();
        }

        function renderRefundHistory(refunds) {
            const $body = $('#refundHistoryBody');

            if (!Array.isArray(refunds) || !refunds.length) {
                $('#refundHistoryCount').text('0');

                $body.html(
                    '<tr>' +
                        '<td colspan="5" class="text-center text-muted">' +
                            'No refund records.' +
                        '</td>' +
                    '</tr>'
                );

                return;
            }

            $('#refundHistoryCount').text(refunds.length);

            let html = '';

            refunds.forEach(function (refund) {
                const badge =
                    parseInt(refund.is_success || 0, 10) === 1
                        ? '<span class="badge badge-success">Successful</span>'
                        : '<span class="badge badge-danger">Failed</span>';

                html +=
                    '<tr>' +
                        '<td>' + escapeRefundHtml(refund.created_at || '') + '</td>' +
                        '<td>' + escapeRefundHtml(refund.user_name || '') + '</td>' +
                        '<td class="text-right">' + formatRefundMoney(refund.refund_amount) + '</td>' +
                        '<td class="text-right">' + formatRefundMoney(refund.gateway_amount) + '</td>' +
                        '<td class="text-center">' + badge + '</td>' +
                    '</tr>';
            });

            $body.html(html);
        }

        function applyRefundDetails(response) {
            const details = response.payment || {};

            $('#refundPaymentLogId').val(details.payment_log_id || '');
            $('#refundOrderId').val(details.order_id || '');

            $('#cardRefundModalSubtitle').text(
                'Order #' + (details.order_number || details.order_id || '')
            );

            $('#refundGatewayTransaction').text(
                details.gateway_transaction_id || 'N/A'
            );

            $('#refundOriginalGross').text(
                formatRefundMoney(details.original_gross_amount)
            );

            $('#refundRemainingBase').text(
                formatRefundMoney(details.max_refund_amount)
            );

            $('#refundAmount').attr('placeholder', 'Max: ' + formatRefundMoney(details.max_refund_amount));
            $('#refundAmount').attr('max', details.max_refund_amount || 0);

            $('#refundAmount')
                .val('')
                .attr('max', details.max_refund_amount || 0);

            $('#refundGatewayAmount').text('$0.00');

            const maxRefund = parseFloat(details.max_refund_amount || 0);
            const disabled = !maxRefund || maxRefund <= 0;

            $('#refundAmount').prop('disabled', disabled);
            $('#submitCardRefundBtn').prop('disabled', disabled);

            renderRefundHistory(response.refunds || []);

            $('#cardRefundContent').show();
        }

        function loadCardRefundDetails(paymentLogId, orderId) {
            $('#cardRefundContent').hide();
            $(".se-pre-con").fadeIn('slow');

            return $.ajax({
                url: cardRefundDetailsUrl,
                type: 'GET',
                dataType: 'json',
                data: {
                    payment_log_id: paymentLogId,
                    order_id: orderId
                }
            }).done(function (response) {
                if (!response.success) {
                    $('#cardRefundModal').modal('hide');

                    Swal.fire({
                        icon: 'error',
                        title: 'Refund Details',
                        text: response.message || 'Unable to load refund details.'
                    });

                    return;
                }

                applyRefundDetails(response);
            }).fail(function (xhr) {
                const message =
                    xhr.responseJSON && xhr.responseJSON.message
                        ? xhr.responseJSON.message
                        : 'Unable to load refund details.';

                $('#cardRefundModal').modal('hide');

                Swal.fire({
                    icon: 'error',
                    title: 'Refund Details',
                    text: message
                });
            }).always(function () {
                $(".se-pre-con").fadeOut('slow');
            });
        }

        $(document).on('click', '.payment-refund-open', function () {
            const paymentLogId = $(this).data('payment-log-id');
            const orderId = $(this).data('order-id');

            if (!paymentLogId || !orderId) {
                Swal.fire({
                    icon: 'error',
                    title: 'Refund',
                    text: 'Payment or order information is missing.'
                });

                return;
            }

            $('#cardRefundModal').modal('show');

            loadCardRefundDetails(
                paymentLogId,
                orderId
            );
        });

        $(document).on('click', '.payment-refund-closed', function () {
            Swal.fire({
                icon: 'warning',
                title: 'Refund',
                text: 'You do not have permission to refund card payments.'
            });
        });

        $(document).on('input', '#refundAmount', function () {
            const baseAmount = parseFloat($(this).val() || 0);

            const grossAmount = Number.isNaN(baseAmount)
                ? 0
                : Math.round((baseAmount * 103 / 100) * 100) / 100;

            $('#refundGatewayAmount').text(
                formatRefundMoney(grossAmount)
            );
        });

        $(document).on('submit', '#cardRefundForm', function (e) {
            e.preventDefault();

            const amount = parseFloat($('#refundAmount').val() || 0);
            const maxAmount = parseFloat($('#refundAmount').attr('max') || 0);

            if (!amount || amount <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Refund Amount',
                    text: 'Enter a refund amount greater than $0.00.'
                });

                return false;
            }

            if (maxAmount > 0 && amount > maxAmount + 0.001) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Refund Amount',
                    text:
                        'Refund amount cannot exceed ' +
                        formatRefundMoney(maxAmount) +
                        '.'
                });

                return false;
            }

            const grossAmount =
                Math.round((amount * 103 / 100) * 100) / 100;

            Swal.fire({
                title: 'Confirm Card Refund',
                html:
                    '<div style="text-align:left;">' +
                        'Refund amount: <strong>' +
                            formatRefundMoney(amount) +
                        '</strong><br>' +
                        'Card refund including 3% fee: <strong>' +
                            formatRefundMoney(grossAmount) +
                        '</strong>' +
                    '</div>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Refund'
            }).then(function (result) {
                if (!(result.isConfirmed || result.value)) {
                    return;
                }

                const $button = $('#submitCardRefundBtn');

                $button.prop('disabled', true);
                $(".se-pre-con").fadeIn('slow');

                $.ajax({
                    url: cardRefundSubmitUrl,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                        payment_log_id: $('#refundPaymentLogId').val(),
                        order_id: $('#refundOrderId').val(),
                        transaction_method: 'Card',
                        amount: amount
                    }
                }).done(function (response) {
                    if (!response.success) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Refund Failed',
                            text:
                                response.message ||
                                'Unable to process the refund.'
                        });

                        return;
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Refund Successful',
                        text:
                            response.message ||
                            'The card refund was processed successfully.'
                    });

                    if (response.remaining_gross_amount !== undefined) {
                        const paymentLogId =
                            String($('#refundPaymentLogId').val());

                        const $row =
                            $('#transactions_table tbody tr[data-payment-log-id="' +
                                paymentLogId +
                            '"]');

                        if ($row.length) {
                            $row
                                .find('td.amount')
                                .first()
                                .text(
                                    formatRefundMoney(
                                        response.remaining_gross_amount
                                    )
                                );
                        }
                    }

                    loadCardRefundDetails(
                        $('#refundPaymentLogId').val(),
                        $('#refundOrderId').val()
                    );
                }).fail(function (xhr) {
                    const message =
                        xhr.responseJSON && xhr.responseJSON.message
                            ? xhr.responseJSON.message
                            : 'An unexpected error occurred while processing the refund.';

                    Swal.fire({
                        icon: 'error',
                        title: 'Refund Failed',
                        text: message
                    });
                }).always(function () {
                    $(".se-pre-con").fadeOut('slow');

                    $button
                        .prop('disabled', false)
                        .html('<i class="fa fa-undo"></i> Refund');
                });
            });

            return false;
        });

    });

    /*
     * Remove manually inserted normal-refund child rows before a DataTables
     * redraw. Uses the table event directly; it does not reference the
     * document-ready-local `usersTable` variable.
     */
    $('#transactions_table').on('preDraw.dt', function () {
        collapseNormalCardRefundRows();
    });


    // Expand/collapse a section of the mobile Payment Receipt and flip its
    // chevron icon. Used by the "Transaction Details" toggle and the
    // "Order Summary" card header in the mobile-only receipt markup above.
    function toggleReceiptSection(bodyId, toggleButton) {
        var $body = $('#' + bodyId);
        var isOpening = $body.css('display') === 'none';

        $body.css('display', isOpening ? 'block' : 'none');
        $(toggleButton).toggleClass('is-open', isOpening);

        $(toggleButton).find('i')
            .toggleClass('fa-chevron-right', !isOpening)
            .toggleClass('fa-chevron-down', isOpening);
    }

</script>

<script>
    document.getElementById('pin-filter-m').addEventListener('click', function(e) {
        e.preventDefault();
        var startDate = document.getElementById('start-date-m').value;
        var endDate = document.getElementById('end-date-m').value;
        var paymentType = document.getElementById('paymentType-m').value;
        var paymentStatus = document.getElementById('paymentStatus-m').value;
        var orderType = document.getElementById('order_type-m').value;

        var url = "{{ route('allTransactions') }}" +
            "?start_date=" + encodeURIComponent(startDate) +
            "&end_date=" + encodeURIComponent(endDate) +
            "&payment_type=" + encodeURIComponent(paymentType) +
            "&payment_status=" + encodeURIComponent(paymentStatus) +
            "&order_type=" + encodeURIComponent(orderType);

        window.location.href = url;
    });

    document.getElementById('reset-filter-m').addEventListener('click', function(e) {
        e.preventDefault();
        window.location.href = "{{ route('allTransactions') }}";
    });
</script>

<script>
/* =================================================================
   MOBILE-ONLY HELPERS. Desktop behaviour is unchanged.
   ================================================================= */
(function () {
    var rpMobileQuery = window.matchMedia('(max-width: 767px)');
    function isRpMobile() { return rpMobileQuery.matches; }

    // "Import to Quickbooks" lives in the desktop filter, which is hidden on
    // phones. On phones move the same button to just below the search box
    // (above "Show / Sort by"); put it back exactly where it was when the
    // screen gets wider. Its click handler is delegated, so it keeps working
    // in both places.
    (function () {
        var $btn = $('.import-to-quickbooks').first();
        if (!$btn.length) return;
        var $home = $('<span class="rp-import-home" style="display:none"></span>').insertBefore($btn);
        function placeImportButton() {
            var $search = $('#transactions_table_wrapper .dataTables_filter').first();
            if (isRpMobile() && $search.length) { $btn.addClass('rp-m-import').insertAfter($search); }
            else if (!isRpMobile()) { $btn.removeClass('rp-m-import').insertAfter($home); }
        }
        placeImportButton();
        // The search box is created by DataTables, and the "Show / Sort by" row
        // is moved in right after it when the table is ready - place again then.
        $(document).on('init.dt', function () { setTimeout(placeImportButton, 0); });
        if (rpMobileQuery.addEventListener) { rpMobileQuery.addEventListener('change', placeImportButton); }
        else if (rpMobileQuery.addListener) { rpMobileQuery.addListener(placeImportButton); }
    })();

    // "Select all" (mobile only). It clicks each card checkbox that is not
    // ticked yet (or each ticked one, to untick), so the page's existing
    // checkbox code runs exactly as if the user tapped them one by one.
    // Synced payments have disabled checkboxes and are skipped.
    (function () {
        var $all = $('#rp-select-all-m');
        if (!$all.length) return;

        function pageCheckboxes() {
            return $('#transactions_table > tbody > tr:not(.payment-log-detail-row) .transaction-checkbox:not(:disabled)');
        }

        function refreshSelectAll() {
            var $boxes = pageCheckboxes();
            var checked = $boxes.filter(':checked').length;
            $all.prop('disabled', $boxes.length === 0);
            $all.prop('checked', $boxes.length > 0 && checked === $boxes.length);
            $all.prop('indeterminate', checked > 0 && checked < $boxes.length);
            $('.rp-m-selected-count').text(checked > 0 ? checked + ' selected' : '');
        }

        $all.on('change', function () {
            var tick = $all.is(':checked');
            pageCheckboxes().each(function () {
                if (this.checked !== tick) { this.click(); }
            });
            refreshSelectAll();
        });

        $(document).on('click', '.transaction-checkbox, .store_transaction_record', function () {
            setTimeout(refreshSelectAll, 0);
        });
        $(document).on('draw.dt init.dt', '#transactions_table', refreshSelectAll);
        $(document).ajaxComplete(function () { setTimeout(refreshSelectAll, 0); });
        refreshSelectAll();
    })();

    // Filter fields: the label shows as a placeholder while a date is empty,
    // and the "all" option of a select is shown in grey like a placeholder.
    function updateRpFilterPlaceholders() {
        $('#filter_div_mobile input[type="date"]').each(function () {
            $(this).closest('.filter_row').toggleClass('is-empty', !this.value);
        });
        $('#filter_div_mobile select').each(function () {
            $(this).toggleClass('is-all', this.value === 'all');
        });
    }
    $(document).on('change input', '#filter_div_mobile input, #filter_div_mobile select', updateRpFilterPlaceholders);
    updateRpFilterPlaceholders();

    // "Payment ID - …" popup title (design). The existing handler only sets a
    // title for known payment types, so on mobile set it from the clicked id.
    $(document).on('click', '.payID', function () {
        if (isRpMobile()) {
            $('#modal_title_notification').text('Payment ID - ' + $.trim($(this).attr('data-value') || ''));
        }
    });

    // Place the page header 16px below the layout's fixed mobile bar(s).
    // The space above comes from the layout, so it is measured, not guessed.
    function fixRpHeaderOffset() {
        var top = document.querySelector('.mobile-page-header');
        var nav = document.getElementById('sidenav-main');
        if (!top) return;
        top.style.marginTop = '';
        if (!isRpMobile() || !nav || getComputedStyle(nav).position !== 'fixed') return;

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
        fixRpHeaderOffset();
        setTimeout(fixRpHeaderOffset, 350);
        setTimeout(fixRpHeaderOffset, 1300);
    });
    window.addEventListener('load', fixRpHeaderOffset);   // logo size changes the bar height
    var rpResizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(rpResizeTimer);
        rpResizeTimer = setTimeout(fixRpHeaderOffset, 150);
    });
})();
</script>
@endsection
