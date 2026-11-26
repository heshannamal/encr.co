@extends('layouts.app', ['activePage' => 'Sales_Tax_Report', 'titlePage' => __('Sales Tax Report')])

@section('order-header')
    <span>Sales Tax Report</span>
@endsection

@section('back-btn')
    <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
@endsection

@section('content')

<style>
    .sales-tax-page {
        padding: 18px 16px 30px;
        background: #f7f7f8;
        min-height: calc(100vh - 80px);
    }

    .sales-tax-page,
    .sales-tax-page * {
        box-sizing: border-box;
    }

    .sales-tax-panel {
        background: #fff;
        border: 1px solid #eceef1;
        box-shadow: 0 1px 2px rgba(16,24,40,.03);
    }

    .sales-tax-filter-bar {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: nowrap;
        padding: 13px 14px;
        margin-bottom: 14px;
        min-height: 60px;
        overflow-x: auto;
    }

    .sales-tax-filter-control {
        display: inline-flex;
        align-items: center;
        height: 35px;
        min-height: 35px;
        border: 1px solid #e2e5e9;
        border-radius: 16px;
        background: #fff;
        overflow: hidden;
        color: #555;
        flex: 0 0 auto;
    }

    .sales-tax-filter-control:first-child {
        width: 245px;
    }

    .sales-tax-filter-control:nth-child(2) {
        width: 105px;
    }

    .sales-tax-filter-control:nth-child(3) {
        width: 92px;
    }

    .sales-tax-filter-control .label {
        color: #8e949c;
        padding-left: 10px;
        padding-right: 7px;
        white-space: nowrap;
        font-size: 11px;
        line-height: 33px;
    }

    .sales-tax-filter-control input,
    .sales-tax-filter-control select {
        height: 33px;
        border: 0 !important;
        box-shadow: none !important;
        outline: 0 !important;
        background: transparent;
        font-size: 11px;
        color: #111;
        padding: 0 6px;
        min-width: 0;
    }

    .sales-tax-filter-control input.summary-datepicker {
        width: 76px !important;
        flex: 0 0 76px;
    }

    .sales-tax-filter-control select {
        width: 100%;
        cursor: pointer;
        padding-right: 18px;
    }

    .sales-tax-date-separator {
        color: #a6abb2;
        font-size: 11px;
        flex: 0 0 auto;
    }

    .sales-tax-filter-link {
        height: 35px;
        border: 0;
        background: transparent;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 0 4px;
        cursor: pointer;
        white-space: nowrap;
        flex: 0 0 auto;
    }

    .sales-tax-filter-link.filter {
        color: #43cdb2;
    }

    .sales-tax-filter-link.reset {
        color: #aaaeb4;
    }

    .sales-tax-filter-link:hover {
        opacity: .78;
    }

    .sales-tax-filter-bar > span[style*="border-left"] {
        height: 18px !important;
        margin: 0 2px;
    }

    .sales-tax-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: nowrap;
        padding: 12px 14px;
        min-height: 58px;
        border-bottom: 1px solid #eceef1;
    }

    .sales-tax-toolbar-left {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: nowrap;
        min-width: 0;
        flex: 1 1 auto;
    }

    .sales-tax-rows-label {
        color: #888f98;
        font-size: 11px;
        white-space: nowrap;
    }

    .sales-tax-page-size {
        height: 34px;
        min-width: 62px;
        border: 1px solid #e4e6e9;
        border-radius: 15px;
        background: #fff;
        padding: 0 10px;
        font-size: 11px;
        color: #43cdb2;
        flex: 0 0 auto;
    }

    .sales-tax-summary-chips {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: nowrap;
        min-width: 0;
        flex: 1 1 auto;
    }

    .sales-tax-summary-chip {
        display: inline-flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        height: 34px;
        min-width: 0;
        padding: 0 11px;
        border-radius: 15px;
        background: #fafafa;
        color: #444;
        font-size: 11px;
        white-space: nowrap;
        flex: 0 1 auto;
    }

    .sales-tax-summary-chip span {
        white-space: nowrap;
    }

    .sales-tax-summary-chip strong {
        font-size: 13px;
        color: #111;
        white-space: nowrap;
        font-weight: 700;
    }

    .sales-tax-summary-chips .sales-tax-summary-chip {
        flex: 0 1 auto;
    }

    .sales-tax-summary-chips .sales-tax-summary-chip span,
    .sales-tax-summary-chips .sales-tax-summary-chip strong {
        white-space: nowrap;
    }

    .sales-tax-export-btn {
        min-width: 94px;
        height: 35px;
        border: 0;
        border-radius: 5px;
        background: #43cfb7;
        color: #fff !important;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(67,207,183,.22);
        flex: 0 0 auto;
    }

    .sales-tax-export-btn:hover {
        background: #35bca5;
    }

    .sales-tax-table-wrap {
        overflow-x: auto;
        width: 100%;
    }

    .sales-tax-table {
        width: 100%;
        min-width: 980px;
        border-collapse: collapse;
        margin: 0;
    }

    .sales-tax-table > thead > tr > th {
        background: #777779;
        color: #fff;
        text-transform: uppercase;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .02em;
        padding: 12px 14px;
        border: 0;
        white-space: nowrap;
    }

    .sales-tax-table > tbody > tr > td {
        border-bottom: 1px solid #e8eaed;
        padding: 10px 14px;
        font-size: 11px;
        vertical-align: middle;
        color: #171717;
    }

    .sales-tax-group-row {
        cursor: pointer;
        user-select: none;
    }

    .sales-tax-group-row.county-row td {
        background: #fff;
    }

    .sales-tax-group-row.city-row td {
        background: #d0d0d0;
        border-color: #c2c2c2;
    }

    .sales-tax-group-row:hover td {
        filter: brightness(.985);
    }

    .sales-tax-group-name {
        display: flex;
        align-items: center;
        gap: 9px;
        font-weight: 500;
        white-space: nowrap;
    }

    .sales-tax-group-name.city {
        padding-left: 35px;
    }

    .sales-tax-chevron {
        width: 14px;
        color: #222;
        text-align: center;
        transition: transform .18s ease;
        flex: 0 0 14px;
    }

    .sales-tax-group-row.expanded .sales-tax-chevron {
        transform: rotate(90deg);
    }

    .sales-tax-money,
    .sales-tax-count,
    .sales-tax-rate {
        text-align: right;
        white-space: nowrap;
        font-variant-numeric: tabular-nums;
    }

    .sales-tax-total-tax {
        font-weight: 700;
    }

    .sales-tax-order-container td {
        padding: 0 0 0 55px !important;
        background: #fff;
        border-bottom: 1px solid #e8eaed;
    }

    .sales-tax-order-box {
        border: 0;
        background: transparent;
        overflow-x: auto;
        margin: 0;
        padding: 0;
        box-shadow: none;
    }

    .sales-tax-order-table {
        width: 100%;
        min-width: 820px;
        border-collapse: collapse;
        margin: 0;
        border: 0;
    }

    .sales-tax-order-table th {
        background: #f7f7f8;
        color: #222;
        font-size: 9px;
        text-transform: uppercase;
        padding: 10px 11px;
        border-top: 0;
        border-left: 0;
        border-right: 0;
        border-bottom: 1px solid #dfe2e6;
        white-space: nowrap;
    }

    .sales-tax-order-table td {
        font-size: 10px !important;
        padding: 9px 11px !important;
        border-top: 0 !important;
        border-left: 0 !important;
        border-right: 0 !important;
        border-bottom: 1px solid #eceef1 !important;
        background: #fff !important;
    }

    .sales-tax-order-table tr:last-child td {
        border-bottom: 0 !important;
    }

    .sales-tax-link {
        color: #111;
        text-decoration: none !important;
    }

    .sales-tax-link:hover {
        color: #43bfa9;
    }

    .sales-tax-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 72px;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 10px;
        white-space: nowrap;
    }

    .sales-tax-status.production,
    .sales-tax-status.in-production {
        background: #d9ebff;
        color: #1768b5;
    }

    .sales-tax-status.fulfilled,
    .sales-tax-status.completed {
        background: #dff6d6;
        color: #52a33d;
    }

    .sales-tax-status.default {
        background: #eef0f2;
        color: #6f7781;
    }

    .sales-tax-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        padding: 12px 14px;
        color: #b0b4ba;
        font-size: 10px;
    }

    .sales-tax-pagination {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .sales-tax-page-btn,
    .sales-tax-page-current,
    .sales-tax-page-disabled {
        min-width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
        background: #fff;
        color: #999fa7;
        font-size: 11px;
        text-decoration: none !important;
        cursor: pointer;
    }

    .sales-tax-page-current {
        border-color: #d7dade;
        color: #222;
        cursor: default;
    }

    .sales-tax-page-disabled {
        color: #d2d5d9;
        cursor: default;
    }

    .sales-tax-loading,
    .sales-tax-empty {
        text-align: center;
        color: #8e96a0;
        padding: 38px !important;
        font-size: 11px;
    }

    .se-pre-con {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: none;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }

    .bg-box.container-fluid.fix-nav.header-layout {
        margin-bottom: 0 !important;
    }

    @media (max-width: 1150px) {
        .sales-tax-filter-bar {
            gap: 8px;
        }

        .sales-tax-filter-control:first-child {
            width: 230px;
        }

        .sales-tax-filter-control input.summary-datepicker {
            width: 70px !important;
            flex-basis: 70px;
        }

        .sales-tax-summary-chip {
            padding: 0 9px;
            gap: 7px;
        }
    }

    @media (max-width: 980px) {
        .sales-tax-filter-bar {
            flex-wrap: wrap;
            overflow-x: visible;
        }

        .sales-tax-filter-control:first-child {
            width: 245px;
        }

        .sales-tax-toolbar {
            flex-wrap: wrap;
        }

        .sales-tax-toolbar-left {
            width: 100%;
            flex-wrap: wrap;
        }

        .sales-tax-summary-chips {
            flex-wrap: wrap;
        }
    }

    @media (max-width: 650px) {
        .sales-tax-page {
            padding: 12px 8px 24px;
        }

        .sales-tax-filter-control:first-child,
        .sales-tax-filter-control:nth-child(2),
        .sales-tax-filter-control:nth-child(3) {
            width: 100%;
        }

        .sales-tax-filter-control input.summary-datepicker {
            width: 34% !important;
            flex: 1 1 34%;
        }

        .sales-tax-filter-link {
            flex: 1 1 auto;
        }

        .sales-tax-summary-chips {
            width: 100%;
        }

        .sales-tax-summary-chip {
            width: 100%;
        }

        .sales-tax-export-btn {
            width: 100%;
        }
    }

    /* Mobile View Styles */
    @media (max-width: 767.98px) {
        .content-position {
            padding-left: 12px !important;
            padding-right: 12px !important;
            background-color: transparent !important;
        }

        #scrollTable {
            margin-top: 0 !important;
            padding-top: 0 !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            position: relative !important;
        }

        #scrollTable .card {
            background-color: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        /* Filter Form Container */
        #sales_tax_filter_form {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin-top: 0 !important;
            margin-bottom: 16px !important;
            position: relative !important;
        }

        #sales_tax_filter_form > .row {
            margin: 45px 0 0 0 !important;
            background: #ffffff !important;
            border-radius: 16px !important;
            padding: 16px !important;
            box-shadow: 0 2px 6px rgba(0,0,0,0.03) !important;
            border: 1px solid #e2e8f0 !important;
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 10px !important;
            position: relative !important;
        }

        /* Date Input Card Rows */
        #sales_tax_filter_form .filter_row {
            flex-wrap: nowrap !important;
            margin: 0 !important;
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 10px !important;
            padding: 6px 10px !important;
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            height: 42px !important;
            position: relative !important;
            box-sizing: border-box !important;
        }

        #sales_tax_filter_form .filter_row::after {
            content: "\f107";
            font-family: FontAwesome;
            font-size: 13px;
            color: #64748b;
            position: absolute;
            right: 10px;
            pointer-events: none;
        }

        .date_p {
            font-size: 12px !important;
            color: #94a3b8 !important;
            font-weight: 400 !important;
            margin-bottom: 0 !important;
            white-space: nowrap !important;
        }

        .date_selection {
            width: 100% !important;
            padding-left: 4px !important;
        }

        .summary-datepicker {
            width: 100% !important;
            border: none !important;
            background: transparent !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            color: #334155 !important;
            outline: none !important;
            padding: 0 !important;
            height: auto !important;
        }

        /* Export Report Button (positioned in top-right area directly above white filter box) */
        #sales_tax_filter_form > .row > div:has(#export-report) {
            position: absolute !important;
            top: -55px !important;
            right: 0 !important;
            width: auto !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        #export-report {
            background-color: #36D7B7 !important;
            border: none !important;
            color: #ffffff !important;
            border-radius: 10px !important;
            height: 40px !important;
            width: 100% !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 0 14px !important;
            box-shadow: 0 2px 4px rgba(54, 215, 183, 0.25) !important;
        }

        /* Filter & Clear Action Buttons */
        #sales_tax_filter_form .row > div:has(#clear-filter) {
            grid-column: 1 / 2 !important;
            width: 100% !important;
            margin: 0 !important;
        }

        #sales_tax_filter_form .row > div:has(#pin-filter) {
            grid-column: 2 / 3 !important;
            width: 100% !important;
            margin: 0 !important;
        }

        #clear-filter {
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            color: #475569 !important;
            border-radius: 10px !important;
            height: 42px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
        }

        #pin-filter {
            background-color: #111827 !important;
            border: none !important;
            color: #ffffff !important;
            border-radius: 10px !important;
            height: 42px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
        }

        .total-sales-tax-col {
            grid-column: 1 / 3 !important;
            justify-content: center !important;
            margin-top: 5px !important;
        }

        /* DataTables Wrapper & Table Card Transformation */
        .sales_tax_table {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            overflow: visible !important;
        }

        .dataTables_wrapper {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .dataTables_wrapper .row {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        .dataTables_wrapper .row > [class*="col-"] {
            padding-left: 0 !important;
            padding-right: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        .dataTables_wrapper .dataTables_length {
            float: left !important;
            font-size: 13px !important;
            color: #64748b !important;
            margin-bottom: 12px !important;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            padding: 2px 8px !important;
            background: #fff !important;
            font-size: 13px !important;
        }

        /* Completely hide standard table headers & DataTables scrollHead */
        .dataTables_scrollHead,
        .dataTables_scrollHeadInner,
        #sales_tax_summary thead,
        .dataTables_wrapper table thead {
            display: none !important;
            height: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
            border: none !important;
        }

        .dataTables_scrollBody {
            overflow: visible !important;
            width: 100% !important;
            border: none !important;
        }

        #sales_tax_summary,
        #sales_tax_summary tbody,
        #sales_tax_summary tr {
            display: block !important;
            width: 100% !important;
            border: none !important;
            background: transparent !important;
        }

        #sales_tax_summary tbody tr {
            background: #ffffff !important;
            border-radius: 16px !important;
            padding: 16px !important;
            margin-bottom: 14px !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03) !important;
            border: 1px solid #e2e8f0 !important;
            display: grid !important;
            grid-template-columns: 1fr 1fr 1fr !important;
            grid-template-areas:
                "orderno orderno status"
                "org org org"
                "state state state"
                "tot_box rate_box tax_box"
                "rep_box rep_box date_box" !important;
            gap: 6px 8px !important;
            box-sizing: border-box !important;
        }

        #sales_tax_summary tbody tr td {
            display: block !important;
            padding: 0 !important;
            border: none !important;
            text-align: left !important;
            float: none !important;
            width: auto !important;
            white-space: normal !important;
        }

        /* 1. Order No (#002905) */
        #sales_tax_summary tbody tr td:nth-child(1) {
            grid-area: orderno !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            align-self: center !important;
        }

        /* 6. Order Status Badge */
        #sales_tax_summary tbody tr td:nth-child(6) {
            grid-area: status !important;
            justify-self: end !important;
            align-self: center !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            background: #dbeafe !important;
            color: #1d4ed8 !important;
            border-radius: 12px !important;
            font-size: 11px !important;
            font-weight: 600 !important;
            padding: 3px 10px !important;
            line-height: 1.2 !important;
        }

        /* 2. Organization Name */
        #sales_tax_summary tbody tr td:nth-child(2) {
            grid-area: org !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            margin-top: 2px !important;
            margin-bottom: 2px !important;
            word-break: break-word !important;
            white-space: normal !important;
            overflow-wrap: break-word !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
            line-height: 1.3 !important;
        }

        /* 3. State */
        #sales_tax_summary tbody tr td:nth-child(3) {
            grid-area: state !important;
            font-size: 12px !important;
            color: #334155 !important;
            font-weight: 600 !important;
            margin-bottom: 8px !important;
        }
        #sales_tax_summary tbody tr td:nth-child(3)::before {
            content: "State  " !important;
            color: #94a3b8 !important;
            font-weight: 400 !important;
            font-size: 12px !important;
        }

        /* 7. Order Total ($) Box */
        #sales_tax_summary tbody tr td:nth-child(7) {
            grid-area: tot_box !important;
            background: #f8fafc !important;
            border-radius: 10px !important;
            padding: 8px 10px !important;
            border: 1px solid #f1f5f9 !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            box-sizing: border-box !important;
        }
        #sales_tax_summary tbody tr td:nth-child(7)::before {
            content: "Order Total ($)\A" !important;
            white-space: pre-wrap !important;
            display: block !important;
            font-size: 10px !important;
            font-weight: 400 !important;
            color: #94a3b8 !important;
            margin-bottom: 3px !important;
        }

        /* 8. Sales Tax (%) Box */
        #sales_tax_summary tbody tr td:nth-child(8) {
            grid-area: rate_box !important;
            background: #f8fafc !important;
            border-radius: 10px !important;
            padding: 8px 10px !important;
            border: 1px solid #f1f5f9 !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            box-sizing: border-box !important;
        }
        #sales_tax_summary tbody tr td:nth-child(8)::before {
            content: "Sales Tax (%)\A" !important;
            white-space: pre-wrap !important;
            display: block !important;
            font-size: 10px !important;
            font-weight: 400 !important;
            color: #94a3b8 !important;
            margin-bottom: 3px !important;
        }

        /* 9. Sales Tax ($) Box */
        #sales_tax_summary tbody tr td:nth-child(9) {
            grid-area: tax_box !important;
            background: #f8fafc !important;
            border-radius: 10px!important;
            padding: 8px 10px !important;
            border: 1px solid #f1f5f9 !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            box-sizing: border-box !important;
        }
        #sales_tax_summary tbody tr td:nth-child(9)::before {
            content: "Sales Tax ($)\A" !important;
            white-space: pre-wrap !important;
            display: block !important;
            font-size: 10px !important;
            font-weight: 400 !important;
            color: #94a3b8 !important;
            margin-bottom: 3px !important;
        }

        /* 4. Sales Rep (Footer Left) */
        #sales_tax_summary tbody tr td:nth-child(4) {
            grid-area: rep_box !important;
            border-top: 1px dotted #cbd5e1 !important;
            margin-top: 8px !important;
            padding-top: 8px !important;
            font-size: 11px !important;
            color: #334155 !important;
            font-weight: 600 !important;
        }
        #sales_tax_summary tbody tr td:nth-child(4)::before {
            content: "Sales Rep: " !important;
            color: #94a3b8 !important;
            font-weight: 400 !important;
            margin-right: 2px !important;
        }

        /* 5. Production Date (Footer Right) */
        #sales_tax_summary tbody tr td:nth-child(5) {
            grid-area: date_box !important;
            border-top: 1px dotted #cbd5e1 !important;
            margin-top: 8px !important;
            padding-top: 8px !important;
            font-size: 11px !important;
            color: #334155 !important;
            font-weight: 600 !important;
            text-align: right !important;
        }
        #sales_tax_summary tbody tr td:nth-child(5)::before {
            content: "Production Date: " !important;
            color: #94a3b8 !important;
            font-weight: 400 !important;
            margin-right: 2px !important;
        }

        /* --- DataTables Info & Pagination Styling (Mobile View) --- */
        .dataTables_wrapper .dataTables_info {
            text-align: center !important;
            font-size: 13px !important;
            color: #64748b !important;
            font-weight: 500 !important;
            margin-top: 16px !important;
            margin-bottom: 12px !important;
            float: none !important;
            width: 100% !important;
        }

        .dataTables_wrapper .dataTables_paginate {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            float: none !important;
            margin-top: 8px !important;
            margin-bottom: 20px !important;
            width: 100% !important;
        }

        .dataTables_wrapper .dataTables_paginate ul.pagination,
        .dataTables_wrapper .dataTables_paginate span {
            display: flex !important;
            flex-wrap: wrap !important;
            justify-content: center !important;
            align-items: center !important;
            gap: 6px !important;
            margin: 0 !important;
            padding: 0 !important;
            list-style: none !important;
        }

        .dataTables_wrapper .dataTables_paginate .page-item,
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
        }

        .dataTables_wrapper .dataTables_paginate .page-link,
        .dataTables_wrapper .dataTables_paginate .paginate_button a,
        .dataTables_wrapper .dataTables_paginate a.paginate_button,
        .dataTables_wrapper .dataTables_paginate span .paginate_button {
            border-radius: 10px !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            color: #475569 !important;
            min-width: 36px !important;
            height: 36px !important;
            padding: 0 10px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03) !important;
            text-decoration: none !important;
            transition: all 0.2s ease !important;
        }

        .dataTables_wrapper .dataTables_paginate .page-item.active .page-link,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate span .paginate_button.current {
            background: #0f172a !important;
            color: #ffffff !important;
            border-color: #0f172a !important;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.25) !important;
        }

        .dataTables_wrapper .dataTables_paginate .page-item.disabled .page-link,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.4 !important;
            background: #f8fafc !important;
            border-color: #f1f5f9 !important;
            cursor: not-allowed !important;
        }

        div.dataTables_wrapper div.dataTables_length select {
            width: 40% !important;
        }
    }
</style>


<div class="sales-tax-page">
    <div class="se-pre-con"></div>

    <div class="sales-tax-panel sales-tax-filter-bar">
        <div class="sales-tax-filter-control">
            <span class="label">Date Range |</span>
            <input type="text"
                   id="start_date"
                   class="summary-datepicker"
                   placeholder="Start date"
                   autocomplete="off"
>
            <span class="sales-tax-date-separator">–</span>
            <input type="text"
                   id="end_date"
                   class="summary-datepicker"
                   placeholder="End date"
                   autocomplete="off"
>
        </div>

        <div class="sales-tax-filter-control">
            <span class="label">County |</span>
            <select id="county_filter">
                <option value="">All</option>
            </select>
        </div>

        <div class="sales-tax-filter-control">
            <span class="label">City |</span>
            <select id="city_filter">
                <option value="">All</option>
            </select>
        </div>

        <button type="button" class="sales-tax-filter-link filter" id="filter-report">
            <i class="fa fa-filter"></i>&nbsp; Filter
        </button>

        <span style="height:20px;border-left:1px solid #eceef1;"></span>

        <button type="button" class="sales-tax-filter-link reset" id="reset-report">
            <i class="fa fa-undo"></i>&nbsp; Reset
        </button>
    </div>

    <div class="sales-tax-panel">
        <div class="sales-tax-toolbar">
            <div class="sales-tax-toolbar-left">
                <span class="sales-tax-rows-label">Show rows per page</span>

                <select id="rows_per_page" class="sales-tax-page-size">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50" selected>50</option>
                    <option value="100">100</option>
                </select>

                <span style="height:22px;border-left:1px solid #eceef1;"></span>

                <div class="sales-tax-summary-chips">
                    <div class="sales-tax-summary-chip">
                        <span>Taxable Total Sales</span>
                        <strong>$<span id="taxable-total-sales">0.00</span></strong>
                    </div>

                    <div class="sales-tax-summary-chip">
                        <span>Tax Total</span>
                        <strong>$<span id="tax-total">0.00</span></strong>
                    </div>

                    <div class="sales-tax-summary-chip">
                        <span>Sales Tax Total</span>
                        <strong>$<span id="sales-tax-total">0.00</span></strong>
                    </div>

                    <div class="sales-tax-summary-chip">
                        <span>Use Tax Total</span>
                        <strong>$<span id="use-tax-total">0.00</span></strong>
                    </div>
                </div>
            </div>

            <button type="button" class="sales-tax-export-btn" id="export-report">
                <i class="fa fa-download"></i>&nbsp;&nbsp; Export
            </button>
        </div>

        <div class="sales-tax-table-wrap">
            <table class="sales-tax-table">
                <thead>
                    <tr>
                        <th>County</th>
                        <th class="text-right">Order Count</th>
                        <th class="text-right">Order Total ($)</th>
                        <th class="text-right">Sales Tax Rate (%)</th>
                        <th class="text-right">Sales Tax ($)</th>
                        <th class="text-right">Use Tax ($)</th>
                        <th class="text-right">Total Tax ($)</th>
                    </tr>
                </thead>
                <tbody id="sales-tax-body">
                    <tr>
                        <td colspan="7" class="sales-tax-loading">Loading report...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="sales-tax-footer">
            <div id="sales-tax-showing">Showing 0 - 0 of 0 results</div>
            <div class="sales-tax-pagination" id="sales-tax-pagination"></div>
        </div>
    </div>
</div>

<form id="sales-tax-export-form"
      method="POST"
      action="{{ route('sales.tax.export') }}"
      style="display:none;">
    @csrf
    <input type="hidden" name="start_date" id="export_start_date">
    <input type="hidden" name="end_date" id="export_end_date">
    <input type="hidden" name="county" id="export_county">
    <input type="hidden" name="city" id="export_city">
</form>

<script>
$(function () {
    const dataUrl = @json(route('sales.tax.report.data'));
    const csrfToken = @json(csrf_token());

    let allGroups = [];
    let filterOptions = {
        counties: [],
        cities: [],
        cities_by_county: {}
    };
    let currentPage = 1;

    $('.summary-datepicker').datepicker({
        dateFormat: 'mm/dd/yy'
    });

    function esc(value) {
        return $('<div>').text(value == null ? '' : value).html();
    }

    function slug(value) {
        return String(value || '')
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-|-$/g, '');
    }

    function formatCount(value) {
        const number = parseInt(value, 10) || 0;
        return number.toLocaleString('en-US');
    }

    function formatRate(value) {
        if (value === null || value === undefined || value === '') {
            return '-';
        }
        return esc(value);
    }

    function statusClass(status) {
        const key = slug(status);
        if (key === 'production' || key === 'in-production') return key;
        if (key === 'fulfilled' || key === 'completed') return key;
        return 'default';
    }

    function updateSummary(summary) {
        $('#taxable-total-sales').text(summary.taxable_total_sales || '0.00');
        $('#tax-total').text(summary.total_sales_tax || '0.00');
        $('#sales-tax-total').text(summary.sales_tax_total || '0.00');
        $('#use-tax-total').text(summary.use_tax_total || '0.00');
    }

    function updateFilterOptions(filters) {
        filterOptions = filters || filterOptions;

        const currentCounty = $('#county_filter').val() || '';
        const currentCity = $('#city_filter').val() || '';

        const $county = $('#county_filter');
        $county.html('<option value="">All</option>');

        (filterOptions.counties || []).forEach(function (name) {
            $('<option>', { value: name, text: name }).appendTo($county);
        });

        if ((filterOptions.counties || []).includes(currentCounty)) {
            $county.val(currentCounty);
        }

        rebuildCityOptions(currentCity);
    }

    function rebuildCityOptions(preferredCity) {
        const county = $('#county_filter').val() || '';
        let cities = filterOptions.cities || [];

        if (county && filterOptions.cities_by_county && filterOptions.cities_by_county[county]) {
            cities = filterOptions.cities_by_county[county];
        }

        const $city = $('#city_filter');
        $city.html('<option value="">All</option>');

        (cities || []).forEach(function (name) {
            $('<option>', { value: name, text: name }).appendTo($city);
        });

        if (preferredCity && (cities || []).includes(preferredCity)) {
            $city.val(preferredCity);
        }
    }

    $('#county_filter').on('change', function () {
        rebuildCityOptions('');
    });

    function loadReport() {
        $('.se-pre-con').show();

        $.ajax({
            url: dataUrl,
            method: 'POST',
            data: {
                _token: csrfToken,
                start_date: $('#start_date').val(),
                end_date: $('#end_date').val(),
                county: $('#county_filter').val(),
                city: $('#city_filter').val()
            }
        }).done(function (res) {
            if (!res.success) {
                throw new Error(res.message || 'Failed to load report.');
            }

            allGroups = res.groups || [];
            currentPage = 1;
            updateSummary(res.summary || {});
            updateFilterOptions(res.filters || {});
            renderCurrentPage();
        }).fail(function (xhr) {
            const message = xhr.responseJSON && xhr.responseJSON.message
                ? xhr.responseJSON.message
                : 'Failed to load Sales Tax Report.';

            $('#sales-tax-body').html(
                '<tr><td colspan="7" class="sales-tax-empty">' + esc(message) + '</td></tr>'
            );

            updateSummary({});
            renderPagination(0, 0, 0);
        }).always(function () {
            $('.se-pre-con').fadeOut(120);
        });
    }

    function renderCurrentPage() {
        const pageSize = parseInt($('#rows_per_page').val(), 10) || 50;
        const total = allGroups.length;
        const totalPages = Math.max(1, Math.ceil(total / pageSize));

        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        const startIndex = (currentPage - 1) * pageSize;
        const pageGroups = allGroups.slice(startIndex, startIndex + pageSize);

        renderGroups(pageGroups, startIndex);

        const first = total === 0 ? 0 : startIndex + 1;
        const last = Math.min(startIndex + pageSize, total);

        renderPagination(totalPages, first, last);
    }

    function renderGroups(groups, offset) {
        const $body = $('#sales-tax-body');
        $body.empty();

        if (!groups.length) {
            $body.html(
                '<tr><td colspan="7" class="sales-tax-empty">No sales tax records found.</td></tr>'
            );
            return;
        }

        groups.forEach(function (county, localIndex) {
            const countyIndex = offset + localIndex;
            const countyId = 'county-' + countyIndex;

            $body.append(
                '<tr class="sales-tax-group-row county-row" data-node="' + countyId + '" data-expanded="0">' +
                    '<td><div class="sales-tax-group-name">' +
                        '<span class="sales-tax-chevron"><i class="fa fa-chevron-right"></i></span>' +
                        '<span>' + esc(county.name) + '</span>' +
                    '</div></td>' +
                    '<td class="sales-tax-count">' + formatCount(county.order_count) + '</td>' +
                    '<td class="sales-tax-money">' + esc(county.order_total) + '</td>' +
                    '<td class="sales-tax-rate">' + formatRate(county.tax_rate) + '</td>' +
                    '<td class="sales-tax-money">' + esc(county.sales_tax) + '</td>' +
                    '<td class="sales-tax-money">' + esc(county.use_tax) + '</td>' +
                    '<td class="sales-tax-money sales-tax-total-tax">' + esc(county.total_sales_tax) + '</td>' +
                '</tr>'
            );

            (county.cities || []).forEach(function (city, cityIndex) {
                const cityId = countyId + '-city-' + cityIndex;

                $body.append(
                    '<tr class="sales-tax-group-row city-row" data-node="' + cityId + '" data-parent="' + countyId + '" data-expanded="0" style="display:none;">' +
                        '<td><div class="sales-tax-group-name city">' +
                            '<span class="sales-tax-chevron"><i class="fa fa-chevron-right"></i></span>' +
                            '<span>' + esc(city.name) + '</span>' +
                        '</div></td>' +
                        '<td class="sales-tax-count">' + formatCount(city.order_count) + '</td>' +
                        '<td class="sales-tax-money">' + esc(city.order_total) + '</td>' +
                        '<td class="sales-tax-rate">' + formatRate(city.tax_rate) + '</td>' +
                        '<td class="sales-tax-money">' + esc(city.sales_tax) + '</td>' +
                        '<td class="sales-tax-money">' + esc(city.use_tax) + '</td>' +
                        '<td class="sales-tax-money">' + esc(city.total_sales_tax) + '</td>' +
                    '</tr>'
                );

                $body.append(
                    '<tr class="sales-tax-order-container" data-parent="' + cityId + '" style="display:none;">' +
                        '<td colspan="7">' + orderTable(city.orders || []) + '</td>' +
                    '</tr>'
                );
            });
        });
    }

    function orderTable(orders) {
        let html = '' +
            '<table class="sales-tax-order-table">' +
                '<thead><tr>' +
                    '<th>Order No.</th>' +
                    '<th>Organization</th>' +
                    '<th>Sales Person</th>' +
                    '<th>Production Date</th>' +
                    '<th>Order Status</th>' +
                    '<th class="text-right">Order Total ($)</th>' +
                    '<th class="text-right">Sales Tax ($)</th>' +
                    '<th class="text-right">Use Tax ($)</th>' +
                '</tr></thead><tbody>';

        if (!orders.length) {
            html += '<tr><td colspan="8" class="sales-tax-empty">No orders found.</td></tr>';
        } else {
            orders.forEach(function (order) {
                const orderLink = order.order_url
                    ? '<a class="sales-tax-link" target="_blank" href="' + esc(order.order_url) + '">' + esc(order.order_no) + '</a>'
                    : esc(order.order_no);

                const orgLink = order.organization_url
                    ? '<a class="sales-tax-link" target="_blank" href="' + esc(order.organization_url) + '">' + esc(order.organization_name) + '</a>'
                    : esc(order.organization_name);

                html += '<tr>' +
                    '<td>' + orderLink + '</td>' +
                    '<td>' + orgLink + '</td>' +
                    '<td>' + esc(order.sales_person) + '</td>' +
                    '<td>' + esc(order.production_date) + '</td>' +
                    '<td><span class="sales-tax-status ' + statusClass(order.order_status) + '">' + esc(order.order_status) + '</span></td>' +
                    '<td class="text-right">' + esc(order.order_total) + '</td>' +
                    '<td class="text-right">' + esc(order.sales_tax) + '</td>' +
                    '<td class="text-right">' + esc(order.use_tax) + '</td>' +
                '</tr>';
            });
        }

        html += '</tbody></table>';
        return html;
    }

    $(document).on('click', '.county-row', function () {
        const $row = $(this);
        const node = $row.data('node');
        const expanded = String($row.attr('data-expanded')) === '1';

        $row.attr('data-expanded', expanded ? '0' : '1')
            .toggleClass('expanded', !expanded);

        if (expanded) {
            $('[data-parent="' + node + '"]').hide();
            $('[data-parent^="' + node + '-city-"]').hide();
            $('[data-parent^="' + node + '-city-"]').prev('.city-row')
                .attr('data-expanded', '0')
                .removeClass('expanded');
        } else {
            $('.city-row[data-parent="' + node + '"]').show();
        }
    });

    $(document).on('click', '.city-row', function (e) {
        e.stopPropagation();

        const $row = $(this);
        const node = $row.data('node');
        const expanded = String($row.attr('data-expanded')) === '1';

        $row.attr('data-expanded', expanded ? '0' : '1')
            .toggleClass('expanded', !expanded);

        $('.sales-tax-order-container[data-parent="' + node + '"]')
            .toggle(!expanded);
    });

    function renderPagination(totalPages, first, last) {
        const total = allGroups.length;
        $('#sales-tax-showing').text(
            'Showing ' + first + ' - ' + last + ' of ' + total + ' results'
        );

        const $pager = $('#sales-tax-pagination');
        $pager.empty();

        if (totalPages <= 1) return;

        if (currentPage > 1) {
            $pager.append(pageButton('‹', currentPage - 1));
        } else {
            $pager.append('<span class="sales-tax-page-disabled">‹</span>');
        }

        const pages = pageNumbers(currentPage, totalPages);

        pages.forEach(function (page) {
            if (page === '...') {
                $pager.append('<span class="sales-tax-page-disabled">…</span>');
            } else if (page === currentPage) {
                $pager.append('<span class="sales-tax-page-current">' + page + '</span>');
            } else {
                $pager.append(pageButton(page, page));
            }
        });

        if (currentPage < totalPages) {
            $pager.append(pageButton('›', currentPage + 1));
        } else {
            $pager.append('<span class="sales-tax-page-disabled">›</span>');
        }
    }

    function pageButton(label, page) {
        return '<button type="button" class="sales-tax-page-btn" data-page="' + page + '">' + label + '</button>';
    }

    function pageNumbers(current, last) {
        if (last <= 7) {
            return Array.from({ length: last }, function (_, i) { return i + 1; });
        }

        const pages = [1];
        const start = Math.max(2, current - 2);
        const end = Math.min(last - 1, current + 2);

        if (start > 2) pages.push('...');
        for (let i = start; i <= end; i++) pages.push(i);
        if (end < last - 1) pages.push('...');
        pages.push(last);

        return pages;
    }

    $(document).on('click', '.sales-tax-page-btn', function () {
        currentPage = parseInt($(this).data('page'), 10) || 1;
        renderCurrentPage();
        window.scrollTo({ top: $('#sales-tax-body').offset().top - 140, behavior: 'smooth' });
    });

    $('#rows_per_page').on('change', function () {
        currentPage = 1;
        renderCurrentPage();
    });

    $('#filter-report').on('click', loadReport);

    $('#reset-report').on('click', function () {
        $('#start_date,#end_date').val('');
        $('#county_filter,#city_filter').val('');
        currentPage = 1;
        loadReport();
    });

    $('#export-report').on('click', function () {
        $('#export_start_date').val($('#start_date').val());
        $('#export_end_date').val($('#end_date').val());
        $('#export_county').val($('#county_filter').val());
        $('#export_city').val($('#city_filter').val());
        $('#sales-tax-export-form').trigger('submit');
    });

    loadReport();
});
</script>
@endsection
