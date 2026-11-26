@extends('layouts.app', ['activePage' => 'order', 'titlePage' => __('Pdf')])

@section('content')

<style>
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
    .table_header_text {
        color: white;
        height: 40px;
    }
    .table-bottom-details2 {
        color: #020202;
        padding-bottom: 12px !important;
        padding-top: 12px !important;
    }
    .header-layout {
        margin-bottom: 2rem !important;
    }
    .font_color {
        color: #020202
    }
    .total_summary_card {
        border: unset;
        border-radius: 2px;
        padding: 10px;
    }
    .sub_card {
        background-color: #FCFCFC;
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
    .bargraph_header {
        color: black;
        font-size: 17px;
    }
    .page-item.active .page-link {
        color: #4e4e4e;
    }
    .page-item.active .page-link {
        color: #fff;
        border-color: #cccccc;
        background-color: #cccccc;
        box-shadow: 0 3px 10px rgba(50, 50, 93, .1), 0 3px 10px rgba(0, 0, 0, .08);
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
    .filter_btn {
        padding: 4px;
        text-align: center;
        width: 70px;
        padding-right: 6px;
        background-color: rgb(0, 254, 0);
        border-radius: 5px;
        cursor: pointer;
        color: white !important;
    }

    /* =====================================================================
       SALES INVOICE SUMMARY — MOBILE LAYOUT
       ===================================================================== */
    .sis-m-only { display: none; }

    @media (max-width: 767px) {

        /* ---------- Page shell ---------- */
        .content-position {
            padding-left: 16px !important;
            padding-right: 16px !important;
        }
        .content-position > .col-md-12 {
            padding-left: 0;
            padding-right: 0;
        }

        /* ---------- Page header: "< BACK TO HOME", title + Export ---------- */
        .sis-m-header {
            display: block;
            margin: 4px 0 18px;
        }
        .sis-m-titlerow {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 12px;
        }
        .sis-m-back,
        .sis-m-title { display: none; }
        /* Shown only when the layout's own title strip was found and hidden (see JS) */
        body.sis-own-header .sis-m-back {
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
        body.sis-own-header .sis-m-back i { font-size: 11px; }
        body.sis-own-header .sis-m-titlerow { justify-content: space-between; }
        body.sis-own-header .sis-m-title {
            display: block;
            margin: 0;
            min-width: 0;
            font-size: clamp(16px, 4.4vw, 20px);
            font-weight: 700;
            line-height: 1.25;
            color: #111827;
        }
        /* Hide the layout's centered white title strip on this page only */
        body.sis-own-header .main-content .header1 { display: none !important; }
        /* The layout's top navbar (desktop "BACK TO HOME" bar) peeks out under the
           dark mobile bar as a thin white strip; our header replaces it on mobile. */
        body.sis-own-header .main-content > .navbar-top,
        body.sis-own-header .main-content > #navbar-main { display: none !important; }

        .sis-m-export {
            display: inline-flex;
            flex: 0 0 auto;
            align-items: center;
            gap: 8px;
            height: 42px;
            padding: 0 14px;
            border: none;
            border-radius: 8px;
            background: #47D6B6;
            color: #fff;
            font-size: 15px;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(71, 214, 182, 0.35);
        }

        /* ---------- Summary cards: 2 x 2 ---------- */
        .total_summary_card {
            background: transparent !important;
            box-shadow: none;
            padding: 0 !important;
            margin-bottom: 18px;
        }
        .total_summary_card > .row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 12px;
            margin: 0;
        }
        .total_summary_card .sub_card {
            max-width: none;
            margin: 0;
            padding: 10px 10px 12px 12px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(17, 24, 39, 0.04);
        }
        .total_summary_card .sub_card > .row {
            flex-wrap: nowrap;
            align-items: center;
            margin: 0;
            padding-left: 0 !important;          /* inline padding-left: 20px */
        }
        /* No colour dots on mobile */
        .total_summary_card .color_div { display: none; }
        /* Card layout: label (left) + count (top right) / amount underneath */
        .total_summary_card .sub_card {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            column-gap: 8px;
            align-items: start;
        }
        .total_summary_card .sub_card > .row:nth-child(1) { grid-column: 1; grid-row: 1; }
        .total_summary_card .sub_card > .row:nth-child(2) { grid-column: 2; grid-row: 1; justify-content: flex-end; }
        .total_summary_card .sub_card > .row:nth-child(3) { grid-column: 1 / -1; grid-row: 2; }

        .total_summary_card b {
            font-size: 13px;
            font-weight: 500 !important;
            line-height: 1.3;
            color: #111827;
        }
        /* Shorter mobile labels from the design (data-m-label) */
        .total_summary_card b[data-m-label] { font-size: 0; }
        .total_summary_card b[data-m-label]::after {
            content: attr(data-m-label);
            font-size: 13px;
        }
        .total_summary_card strong {
            margin-top: -2px;
            font-size: 20px !important;          /* inline font-size: 17px */
            font-weight: 700;
            line-height: 1.25;
            color: #111827;
        }
        .total_summary_card .sub_card:nth-child(2) strong { color: #55A630; }
        .total_summary_card .sub_card:nth-child(3) strong { color: #023E8A; }
        .total_summary_card .sub_card:nth-child(4) strong { color: #FFB916; }
        .total_summary_card .sub_card p {
            margin-top: 6px !important;
            font-size: clamp(10px, 2.95vw, 12.5px) !important;   /* inline font-size: 11px */
            line-height: 1.35;
            color: #6b7280 !important;
            overflow-wrap: anywhere;
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
        #filter_div_mobile .filter-col { min-width: 0; }
        #filter_div_mobile .filter_row {
            display: block;
            margin: 0;
            padding: 0;
            background: transparent;
            border: none;
            border-radius: 0;
        }
        /* The design uses the field text instead of separate labels */
        #filter_div_mobile .filter_row .date_p { display: none; }
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
        #filter_div_mobile .filter-col-full {
            grid-column: 1 / -1;
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 12px;
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
        #filter_div_mobile .filter_btn:hover,
        #filter_div_mobile .clear_filter_btn:hover { opacity: .92; }

        /* ---------- "Show [20] entries" / "Sort by [Order ID]" ---------- */
        #entries_sort_mobile {
            margin: 0 0 4px;
            padding: 0 !important;
            background: transparent;
            border: none;
            gap: 10px;
        }
        #entries_sort_mobile .date_p {
            font-size: 14px;
            color: #6b7280 !important;
        }
        #entries_sort_mobile select {
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
        select#itemsPerPageSelect { display: none; }
        .orders_summary > div:first-child { padding: 0 !important; }

        /* ---------- Table -> invoice cards ---------- */
        .orders_summary {
            padding: 0 !important;
            background: transparent;
            box-shadow: none;
        }
        .orders_summary .order_sammary_table { overflow: visible !important; }
        #order_sammary_table {
            display: block;
            width: 100% !important;
            min-width: 0 !important;
            margin: 10px 0 0;
            background: transparent;
        }
        #order_sammary_table thead { display: none; }
        #order_sammary_table tbody { display: block; width: 100%; }

        #order_sammary_table tbody tr {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            column-gap: 10px;
            margin-bottom: 14px;
            padding: 16px 16px 14px;
            background: #fff;
            border: 1px solid #f0f1f3;
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(17, 24, 39, 0.06);
        }
        #order_sammary_table tbody td,
        #order_sammary_table tbody td.row_padding {
            display: block;
            min-width: 0;
            padding: 0 !important;
            border: none !important;
            background: transparent;
            text-align: left !important;
            overflow-wrap: anywhere;
        }
        /* Card order: number, badges / organization / 3 boxes / dashed line / dates */
        #order_sammary_table tbody td:nth-child(1) { order: 1; flex: 1 1 auto; }
        #order_sammary_table tbody td:nth-child(5) { order: 2; flex: 0 0 auto; }
        #order_sammary_table tbody td:nth-child(6) { order: 3; flex: 0 0 auto; }
        #order_sammary_table tbody td:nth-child(2) { order: 4; flex: 0 0 100%; }
        #order_sammary_table tbody td:nth-child(3) { order: 5; }
        #order_sammary_table tbody td:nth-child(4) { order: 6; }
        #order_sammary_table tbody td:nth-child(7) { order: 7; }
        #order_sammary_table tbody tr::after {          /* dashed divider */
            content: "";
            order: 8;
            flex: 0 0 100%;
            height: 0;
            margin-top: 14px;
            border-top: 1px dashed #e5e7eb;
        }
        #order_sammary_table tbody td:nth-child(8) { order: 9; flex: 1 1 auto; }
        #order_sammary_table tbody td:nth-child(9) { order: 10; flex: 1 1 auto; text-align: right !important; }

        /* Order number: "#000004" */
        #order_sammary_table tbody td:nth-child(1) a {
            color: #111827 !important;
            font-size: 20px;
            font-weight: 700;
            text-decoration: none;
        }
        #order_sammary_table tbody td:nth-child(1) a::before { content: "#"; }

        /* Status / approval badges */
        #order_sammary_table tbody td:nth-child(5) .badge,
        #order_sammary_table tbody td:nth-child(6) .badge {
            display: inline-block;
            width: auto !important;               /* inline width: 100% */
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 500;
            line-height: 1.4;
            letter-spacing: 0;
            text-transform: none;
            white-space: nowrap;
        }
        /* Order status (statusDetails.status_name, in data-order-status) replaces
           the payment-status badge on mobile. The desktop column is unchanged. */
        #order_sammary_table tbody td:nth-child(5)[data-order-status] .badge { display: none; }
        #order_sammary_table tbody td:nth-child(5)[data-order-status]::after {
            content: attr(data-order-status);
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            background: #f3f4f6;
            color: #374151;
            font-size: 12px;
            font-weight: 500;
            line-height: 1.4;
            white-space: nowrap;
        }
        #order_sammary_table tbody td:nth-child(5)[data-order-status=""] { display: none; }
        #order_sammary_table tbody td:nth-child(5)[data-order-status="Quote" i]::after      { background: #f1ecfe; color: #7048e8; }
        #order_sammary_table tbody td:nth-child(5)[data-order-status="Invoice" i]::after    { background: #e7f0fd; color: #1d63d6; }
        #order_sammary_table tbody td:nth-child(5)[data-order-status="Production" i]::after { background: #fff3e0; color: #d9730d; }
        #order_sammary_table tbody td:nth-child(5)[data-order-status="Fulfilled" i]::after  { background: #e0f7f1; color: #12a17f; }
        #order_sammary_table tbody td:nth-child(5)[data-order-status="Shipped" i]::after    { background: #e3f6fc; color: #0b8bb5; }
        #order_sammary_table tbody td:nth-child(5)[data-order-status="Delivered" i]::after  { background: #e5f6dc; color: #3a9d23; }
        #order_sammary_table tbody td:nth-child(5)[data-order-status*="cancel" i]::after    { background: #fde4e4; color: #e01e1e; }
        #order_sammary_table tbody td:nth-child(5)[data-order-status="Partial" i]::after    { background: #fff3c4; color: #b98200; }

        /* Design colours (the badges set their colours inline) */
        #order_sammary_table tbody .badge[style*="#d7ffcc" i] { color: #3a9d23 !important; background-color: #e5f6dc !important; }
        #order_sammary_table tbody .badge[style*="#FFF6CC" i] { color: #f0a800 !important; background-color: #fff3c4 !important; }
        #order_sammary_table tbody .badge[style*="#D4E6FD" i] { color: #023E8A !important; background-color: #dbe8fb !important; }
        #order_sammary_table tbody .badge[style*="#ffcccc" i],
        #order_sammary_table tbody .badge[style*="#f9dfff" i] { color: #e01e1e !important; background-color: #fde4e4 !important; }
        /* "Approved" -> "Approved Payment" (design wording) */
        #order_sammary_table tbody td:nth-child(6) .badge[style*="#d7ffcc" i] { font-size: 0; }
        #order_sammary_table tbody td:nth-child(6) .badge[style*="#d7ffcc" i]::after {
            content: "Approved Payment";
            font-size: 12px;
        }

        /* Organization */
        #order_sammary_table tbody td:nth-child(2) {
            margin-top: 4px;
            font-size: 16px;
            line-height: 1.35;
            color: #111827;
        }

        /* Total / Paid / Payment Type boxes */
        #order_sammary_table tbody td:nth-child(3),
        #order_sammary_table tbody td:nth-child(4),
        #order_sammary_table tbody td:nth-child(7) {
            display: flex;
            flex-wrap: wrap;
            align-content: flex-start;
            flex: 0 0 calc((100% - 20px) / 3);
            align-self: stretch;                  /* equal box heights */
            margin-top: 12px;
            padding: 7px 8px 8px !important;
            background: #f3f4f6;
            border-radius: 8px;
            font-size: clamp(13px, 3.9vw, 16px);
            font-weight: 500;
            line-height: 1.35;
            color: #111827;
        }
        #order_sammary_table tbody td:nth-child(3)::before,
        #order_sammary_table tbody td:nth-child(4)::before,
        #order_sammary_table tbody td:nth-child(7)::before {
            order: -2;
            flex-basis: 100%;
            margin-bottom: 1px;
            font-size: clamp(11px, 3.25vw, 15px);
            font-weight: 400;
            color: #8a8f98;
        }
        #order_sammary_table tbody td:nth-child(3)::before { content: "Total"; }
        #order_sammary_table tbody td:nth-child(4)::before { content: "Paid"; }
        #order_sammary_table tbody td:nth-child(7)::before {
            content: "Payment Type";
            font-size: clamp(10.5px, 3.05vw, 15px);
            white-space: nowrap;
        }
        #order_sammary_table tbody td:nth-child(3)::after,
        #order_sammary_table tbody td:nth-child(4)::after {
            content: "$";
            order: -1;
        }
        #order_sammary_table tbody td:nth-child(4) { color: #3a9d23; }
        /* Payment type badges -> plain text */
        #order_sammary_table tbody td:nth-child(7) .badge {
            display: inline;
            padding: 0;
            margin-right: 4px;
            background: transparent;
            color: #111827;
            font-size: inherit;
            font-weight: 500;
            text-transform: none;
            letter-spacing: 0;
        }

        /* Dates under the dashed line */
        #order_sammary_table tbody td:nth-child(8),
        #order_sammary_table tbody td:nth-child(9) {
            margin-top: 10px;
            font-size: 13px;
            font-weight: 500;
            color: #111827;
            white-space: nowrap;
        }
        #order_sammary_table tbody td:nth-child(8)::before,
        #order_sammary_table tbody td:nth-child(9)::before {
            margin-right: 6px;
            font-weight: 400;
            color: #8a8f98;
        }
        #order_sammary_table tbody td:nth-child(8)::before { content: "Created Date"; }
        /* Mobile shows the production date here (data-production-date); the
           cell text (created date) stays for the desktop table. */
        #order_sammary_table tbody td:nth-child(8)[data-production-date] { font-size: 0; }
        #order_sammary_table tbody td:nth-child(8)[data-production-date]::before {
            content: "Production Date";
            font-size: 13px;
        }
        #order_sammary_table tbody td:nth-child(8)[data-production-date]::after {
            content: attr(data-production-date);
            font-size: 13px;
        }
        #order_sammary_table tbody td:nth-child(8)[data-production-date=""]::after { content: "-"; }
        /* This column holds the in-hand due date (desktop header: IN HAND DUE DATE) */
        #order_sammary_table tbody td:nth-child(9)::before { content: "Due Date"; }

        /* Last row = "Total Amount" summary row -> compact bar */
        #order_sammary_table tbody tr:last-child {
            align-items: center;
            justify-content: space-between;
            padding: 14px 16px;
        }
        #order_sammary_table tbody tr:last-child::after { display: none; }
        #order_sammary_table tbody tr:last-child td { display: none; background: transparent !important; }
        #order_sammary_table tbody tr:last-child td:nth-child(2),
        #order_sammary_table tbody tr:last-child td:nth-child(3) {
            display: block;
            flex: 0 1 auto;
            order: 0;
            margin: 0;
            padding: 0 !important;
            background: transparent !important;
            font-size: 16px;
            color: #111827;
        }
        #order_sammary_table tbody tr:last-child td:nth-child(2) { font-weight: 500; color: #6b7280; }
        #order_sammary_table tbody tr:last-child td:nth-child(3) { font-weight: 700; }
        #order_sammary_table tbody tr:last-child td:nth-child(3)::before {
            content: "$";
            display: inline;
            margin: 0;
            font-size: inherit;
            font-weight: inherit;
            color: inherit;
        }
        #order_sammary_table tbody tr:last-child td:nth-child(3)::after { content: none; }

        /* ---------- Pager: "Showing x to y of z entries" + buttons ---------- */
        .sis-pager-wrap {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding-top: 6px !important;
        }
        #sis-m-info {
            display: block;
            font-size: 13px;
            color: #9ca3af;
        }
        #paginationbarUrgent {
            width: auto !important;
            margin: 0 0 0 auto;
            justify-content: flex-end !important;
        }
        #paginationbarUrgent .pagination {
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 6px;
            margin: 0;
        }
        #paginationbarUrgent .page-item .page-link {
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
        #paginationbarUrgent .page-item.active .page-link {
            background: #111827;
            border-color: #111827;
            color: #fff;
        }
        #paginationbarUrgent .page-item.disabled .page-link { color: #9ca3af; }
        /* « » -> ‹ › */
        #paginationbarUrgent .page-link[data-page="prev"],
        #paginationbarUrgent .page-link[data-page="next"] { font-size: 0; }
        #paginationbarUrgent .page-link[data-page="prev"]::before,
        #paginationbarUrgent .page-link[data-page="next"]::before {
            font-size: 20px;
            line-height: 1;
        }
        #paginationbarUrgent .page-link[data-page="prev"]::before { content: "\2039"; }
        #paginationbarUrgent .page-link[data-page="next"]::before { content: "\203A"; }
    }

    /* Very small phones (320px - 359px) */
    @media (max-width: 359px) {
        .content-position {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }
        body.sis-own-header .sis-m-title { font-size: 17px; }
        .sis-m-export { height: 38px; padding: 0 12px; font-size: 14px; }
        .total_summary_card > .row { gap: 10px; }
        .total_summary_card .sub_card { padding: 9px 10px 10px; }
        .total_summary_card b,
        .total_summary_card b[data-m-label]::after { font-size: 12px; }
        .total_summary_card strong { font-size: 18px !important; }
        #filter_div_mobile { padding: 12px; }
        #filter_div_mobile .filter-grid-mobile,
        #filter_div_mobile .filter-col-full { gap: 10px; }
        #filter_div_mobile .filter_row input,
        #filter_div_mobile .filter_row select { padding: 0 26px 0 10px; background-position: right 9px center; }
        #order_sammary_table tbody tr { padding: 14px 12px 12px; column-gap: 8px; }
        #order_sammary_table tbody td:nth-child(3),
        #order_sammary_table tbody td:nth-child(4),
        #order_sammary_table tbody td:nth-child(7) {
            flex-basis: calc((100% - 16px) / 3);
            padding: 6px 7px 7px !important;
        }
        #order_sammary_table tbody td:nth-child(8),
        #order_sammary_table tbody td:nth-child(9) { font-size: 12px; white-space: normal; }
        #order_sammary_table tbody td:nth-child(8)[data-production-date] { font-size: 0; }
        #order_sammary_table tbody td:nth-child(8)[data-production-date]::before,
        #order_sammary_table tbody td:nth-child(8)[data-production-date]::after { font-size: 12px; }
        #order_sammary_table tbody td:nth-child(5) .badge,
        #order_sammary_table tbody td:nth-child(6) .badge,
        #order_sammary_table tbody td:nth-child(5)[data-order-status]::after { padding: 3px 8px; }
    }


    @media (min-width: 768px) {
        .filter_div_mobile { display: none; }
        div#entries_sort_mobile {
            display: none !important;
        }
    }

    
</style>

@if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif
<div id="buffering_icon1" style="display: none;">
    <img src="{{ asset('argon') }}/img/icons/buffering_icon.gif" />
</div>

<div class=" mb-5 content-position ">

    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Sales Invoice Summary Report</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    {{-- Mobile only: page header (back link + title + Export, uses the existing CSV download) --}}
    <div class="sis-m-only sis-m-header">
        {{-- <a href="{{ route('home') }}" class="sis-m-back" title="Back to home">
            <i class="fa fa-chevron-left"></i> BACK TO HOME
        </a> --}}
        <div class="sis-m-titlerow">
            <h1 class="sis-m-title">Sales Summary</h1>
            <button type="button" class="sis-m-export" id="sis-m-export">
                <i class="fa fa-download"></i> Export
            </button>
        </div>
    </div>


    <div class="col-md-12 "  style="padding-bottom: 25px !important;">

        <div class="card total_summary_card">
            <div class="row">
                <div class="col-md-3 sub_card">
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style="background-color: #068267;"></div>
                        <b style="font-weight: 500;"class="font_color">Total Invoices</b>
                    </div>
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style=""></div>
                        <strong style="font-size: 17px;" class="font_color">{{ $totalOrderCount }}</strong>
                    </div>
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style=""></div>
                        <p style="color: #818181; font-size: 11px; margin: unset;" class="font_color">Amount : $ {{ $totalOrderAmount }}</p>
                    </div>
                </div>

                <div class="col-md-3 sub_card">
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style="background-color: #55A630;"></div>
                        <b style="font-weight: 500;"class="font_color">Paid Invoices</b>
                    </div>
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style=""></div>
                        <strong style="font-size: 17px;" class="font_color">{{ $paidOrderCount }}</strong>
                    </div>
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style=""></div>
                        <p style="color: #818181; font-size: 11px; margin: unset;" class="font_color">Amount : $ {{ $paidOrderTotal }}</p>
                    </div>
                </div>

                <div class="col-md-3 sub_card">
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style="background-color: #023E8A;"></div>
                        <b style="font-weight: 500;"class="font_color" data-m-label="Partial Paid Invoices">Partial Payment Invoices</b>
                    </div>
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style=""></div>
                        <strong style="font-size: 17px;" class="font_color">{{ $partialOrderCount }}</strong>
                    </div>
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style=""></div>
                        <p style="color: #818181; font-size: 11px; margin: unset;" class="font_color">Amount : $ {{ $partialOrderTotal }}</p>
                    </div>
                </div>

                <div class="col-md-3 sub_card">
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style="background-color: #FFB916;"></div>
                        <b style="font-weight: 500;"class="font_color">Pending Payment Invoices</b>
                    </div>
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style=""></div>
                        <strong style="font-size: 17px;" class="font_color">{{ $pendingOrderCount }}</strong>
                    </div>
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style=""></div>
                        <p style="color: #818181; font-size: 11px; margin: unset;" class="font_color">Amount : $ {{ $pendingOrderTotal }}</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="card filter_div" id="filter_div_desktop">
            <div class="row" style="padding-left: 25px;">
                <div style="margin-right: 20px;">
                    <div class="row filter_row">
                        <p class="font_color date_p">Date Range | </p>
                        <input class="date_selection" type="date" id="start-date" name="start-date" max="" value="">
                        <i class="fa fa-arrow-right date_p" style="padding-left: 5px; padding-top: 4px; padding-right: 5px;"></i>
                        <input class="date_selection" type="date" id="end-date" name="end-date" max="" value="">
                    </div>
                </div>

                <div style="margin-right: 20px;">
                    <div class="row filter_row" style="padding-bottom: 2px;">
                        <p class="font_color date_p">Payment Type |  </p>
                        <div class="paymen_type_div date_selection">
                            <select id="paymentType" class="date_selection">
                                <option value="all">All</option>
                                <option value="Online">Card</option>
                                <option value="Check">Check</option>
                                <option value="Venmo">Venmo</option>
                                <option value="Paypal">Paypal</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div style="margin-right: 20px;">
                    <div class="row filter_row" style="padding-bottom: 2px;">
                        <p class="font_color date_p">Payment Status |  </p>
                        <div class="paymen_type_div date_selection">
                            <select id="paymentStatus" class="date_selection">
                                <option value="all">All</option>
                                <option value="Paid">Paid</option>
                                <option value="Partial">Partial</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div style="margin-right: 20px;">

                </div>

                <div style="margin-left: 20px; ">
                    <div class="row" style="padding-bottom: 2px;">
                        <a href="#" class="date_p filter_btn" id="pin-filter" title="Filter">
                            <i class="fa fa-filter " style="padding-left: 5px; padding-top: 4px; padding-right: 5px;"></i>
                            Filter
                        </a>
                    </div>
                </div>

                <div class="ml-auto print_btn">
                    <a class="top_button download_btn export_btn" href="#"><i class="fa fa-download" style="margin-right: 8px;"></i></a>
                </div>
                <div class="ml-auto print_btn" style="margin-left: unset !important; margin-right: 1%;">
                    <a class="top_button print_button" href="#"><i class="fa fa-print" style="margin-right: 8px;"></i></a>
                </div>
            </div>
        </div>

        <div class="card filter_div filter_div_mobile" id="filter_div_mobile">
            <div class="filter-grid-mobile">
                <div class="filter-col">
                    <div class="row filter_row">
                        <p class="font_color date_p">Start Date</p>
                        <input class="date_selection" type="date" id="start-date-m">
                    </div>
                </div>
                <div class="filter-col">
                    <div class="row filter_row">
                        <p class="font_color date_p">End Date</p>
                        <input class="date_selection" type="date" id="end-date-m">
                    </div>
                </div>
                <div class="filter-col">
                    <div class="row filter_row">
                        <p class="font_color date_p">Payment Type</p>
                        <select id="paymentType-m" class="date_selection">
                            <option value="all">Payment Types</option>
                            <option value="Online">Card</option>
                            <option value="Check">Check</option>
                            <option value="Venmo">Venmo</option>
                            <option value="Paypal">Paypal</option>
                        </select>
                    </div>
                </div>
                <div class="filter-col">
                    <div class="row filter_row">
                        <p class="font_color date_p">Payment Status</p>
                        <select id="paymentStatus-m" class="date_selection">
                            <option value="all">Payment Status</option>
                            <option value="Paid">Paid</option>
                            <option value="Partial">Partial</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                </div>
                <div class="filter-col filter-col-full">
                    <button type="button" class="date_p clear_filter_btn" id="clear-filter-m">
                        <i class="fa fa-times"></i> Clear Filters
                    </button>
                    <a href="#" class="date_p filter_btn" id="pin-filter-m">
                        <i class="fa fa-filter"></i> Filter
                    </a>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between flex-wrap filter_div_mobile" id="entries_sort_mobile" style="padding: 5px; gap: 10px;">
            <div class="d-flex align-items-center" style="gap:6px;">
                <span class="date_p" style="color:#555;">Show</span>
                <select id="itemsPerPageSelect-m" onchange="changeItemsPerPage(this.value)">
                    <option value="10">10</option>
                    <option value="20" selected>20</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                </select>
                <span class="date_p" style="color:#555;">entries</span>
            </div>
            <div class="d-flex align-items-center" style="gap:6px;">
                <span class="date_p" style="color:#555;">Sort by</span>
                <select id="sortBySelect-m" onchange="changeSortBy(this.value)">
                    <option value="order_id">Order ID</option>
                </select>
            </div>
        </div>


        <div class="card orders_summary print_content" style="border: unset; padding: 10px;">


            <div style="padding: 5px;">
                {{-- <b class="bargraph_header font_color">Sales Invoice Summary</b> --}}
                <select id="itemsPerPageSelect" onchange="changeItemsPerPage(this.value)">
                    <option value="10">10 per page</option>
                    <option value="20" selected>20 per page</option>
                    <option value="30">30 per page</option>
                    <option value="50">50 per page</option>
                </select>
            </div>


            <div class="order_sammary_table" style="overflow-x: auto; height: 100%;">
                <table class="table align-items-center" id="order_sammary_table" style="min-width: 100%;">

                    <thead style="background-color: #717070;">
                        <th scope="col" class="table_header_text">ORDER ID</th>
                        <th scope="col" class="table_header_text">ORGANIZATION </th>
                        <th scope="col" class="table_header_text">TOTAL ($)  </th>
                        <th scope="col" class="table_header_text">PAID ($)</th>
                        <th scope="col" class="table_header_text">PAYMENT STATUS </th>
                        <th scope="col" class="table_header_text">PAYMENT APPROVAL </th>
                        <th scope="col" class="table_header_text">PAYMENT TYPE </th>
                        <th scope="col" class="table_header_text">CREATED DATE </th>
                        <th scope="col" class="table_header_text">IN HAND DUE DATE </th>
                    </thead>

                    <tbody id="table_body">

                    </tbody>
                </table>



            </div>
            <div class="sis-pager-wrap" style="padding-top: 10px;">
                {{-- Mobile only: "Showing x to y of z entries" --}}
                <div class="sis-m-only" id="sis-m-info"></div>
                <div id="paginationbarUrgent" class="row justify-content-center" style="width: 100%;">
                  {{-- pagination bar paste here --}}
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){
        $(".se-pre-con").fadeOut('slow');
    });

    const startDateInput = document.getElementById('start-date');

    const today = new Date().toISOString().split('T')[0];
    startDateInput.max = today;
    startDateInput.value = today;

    startDateInput.addEventListener('input', () => {
        startDateInput.blur();
    });

    const endDateInput = document.getElementById('end-date');

    endDateInput.max = today;
    endDateInput.value = today;

    endDateInput.addEventListener('input', () => {
        endDateInput.blur();
    });

    var ordersPerPage = 20; // Default number of orders per page
    var maxPaginationLinks = 10; // Maximum number of pagination links to display
    var currentPage = 1; // Initialize the current page
    var transactionsArray = @json($firstTenItems); // Assuming this contains your initial data

    function setupPaginationInvoice(data) {
        var totalPages = Math.ceil(data.length / ordersPerPage);

        if (totalPages >= 1) {
            var pagination = '<nav aria-label="Page navigation"><ul class="pagination">';
            pagination += '<li class="page-item"><a class="page-link" href="#" data-page="prev" style="">&laquo;</a></li>';

            var startPagination = 1;
            var endPagination = Math.min(maxPaginationLinks, totalPages);

            if (currentPage > Math.floor(maxPaginationLinks / 2)) {
                startPagination = currentPage - Math.floor(maxPaginationLinks / 2);
                endPagination = currentPage + Math.ceil(maxPaginationLinks / 2) - 1;

                if (endPagination > totalPages) {
                    endPagination = totalPages;
                    startPagination = endPagination - maxPaginationLinks + 1;
                }
            }

            if (startPagination < 1) {
                startPagination = 1;
            }

            // Add the first page link
            if (startPagination > 1) {
                pagination += '<li class="page-item"><a class="page-link" href="#" data-page="1" style="">1</a></li>';
                if (startPagination > 2) {
                    pagination += '<li class="page-item disabled"><a class="page-link" href="#" style="">...</a></li>';
                }
            }

            // Add the page numbers
            for (var i = startPagination; i <= endPagination; i++) {
                if (i === currentPage) {
                    pagination += '<li class="page-item active"><a class="page-link" href="#" data-page="' + i + '" style="">' + i + '</a></li>';
                } else {
                    pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + i + '" style="">' + i + '</a></li>';
                }
            }

            // Add the last page link
            if (endPagination < totalPages) {
                if (endPagination < totalPages - 1) {
                    pagination += '<li class="page-item disabled"><a class="page-link" href="#" style="">...</a></li>';
                }
                pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + totalPages + '" style="">' + totalPages + '</a></li>';
            }

            pagination += '<li class="page-item"><a class="page-link" href="#" data-page="next" style="">&raquo;</a></li>';
            pagination += '</ul></nav>';

            $('#paginationbarUrgent').empty().append(pagination);

            // Show the initial page
            showPageInvoice(currentPage, data);

            // Pagination click event
            $('#paginationbarUrgent').off('click').on('click', '.page-link', function(e) {
                e.preventDefault();

                var page = $(this).data('page');

                if (page === 'prev') {
                    currentPage = Math.max(1, currentPage - 1);
                } else if (page === 'next') {
                    currentPage = Math.min(totalPages, currentPage + 1);
                } else {
                    currentPage = parseInt(page);
                }

                // Update pagination visibility
                startPagination = 1;
                endPagination = Math.min(maxPaginationLinks, totalPages);

                if (currentPage > Math.floor(maxPaginationLinks / 2)) {
                    startPagination = currentPage - Math.floor(maxPaginationLinks / 2);
                    endPagination = currentPage + Math.ceil(maxPaginationLinks / 2) - 1;

                    if (endPagination > totalPages) {
                        endPagination = totalPages;
                        startPagination = endPagination - maxPaginationLinks + 1;
                    }
                }

                if (startPagination < 1) {
                    startPagination = 1;
                }

                pagination = '<nav aria-label="Page navigation"><ul class="pagination">';
                pagination += '<li class="page-item"><a class="page-link" href="#" data-page="prev" style="">&laquo;</a></li>';

                // Add the first page link
                if (startPagination > 1) {
                    pagination += '<li class="page-item"><a class="page-link" href="#" data-page="1" style="">1</a></li>';
                    if (startPagination > 2) {
                        pagination += '<li class="page-item disabled"><a class="page-link" href="#" style="">...</a></li>';
                    }
                }

                // Add the page numbers
                for (var i = startPagination; i <= endPagination; i++) {
                    if (i === currentPage) {
                        pagination += '<li class="page-item active"><a class="page-link" href="#" data-page="' + i + '" style="">' + i + '</a></li>';
                    } else {
                        pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + i + '" style="">' + i + '</a></li>';
                    }
                }

                // Add the last page link
                if (endPagination < totalPages) {
                    if (endPagination < totalPages - 1) {
                        pagination += '<li class="page-item disabled"><a class="page-link" href="#" style="">...</a></li>';
                    }
                    pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + totalPages + '" style="">' + totalPages + '</a></li>';
                }

                pagination += '<li class="page-item"><a class="page-link" href="#" data-page="next" style="">&raquo;</a></li>';
                pagination += '</ul></nav>';

                $('#paginationbarUrgent').empty().append(pagination);

                showPageInvoice(currentPage, data);
            });

            // Always show the previous and next link buttons
            $('#paginationbarUrgent .page-item:first-child').removeClass('d-none');
            $('#paginationbarUrgent .page-item:last-child').removeClass('d-none');
        }
    }



    function showPageInvoice(pageNum, data) {
        var startIndex = (pageNum - 1) * ordersPerPage;
        var endIndex = startIndex + ordersPerPage;

        // Get the table body element
        var tableBody = document.getElementById('table_body');

        // Clear existing rows in the table body
        tableBody.innerHTML = '';

        var totalAmount = 0;
        var orderTotalAmount = 0;

        // Show only the relevant rows
        data.slice(startIndex, endIndex).forEach(transaction => {
            var row = tableBody.insertRow();

            var paymentTypesHtml = transaction.details.paymentTypes.map(type => `<span class="badge badge-pill">${type}</span>`).join(' ');

            var orderStatusBadge;
            if (transaction.details.paymentStatus === 'Paid') {
                orderStatusBadge = '<span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:100%">Paid</span>';
            } else if (transaction.details.paymentStatus === 'Partial') {
                orderStatusBadge = '<span class="badge badge-pill" style="color:#023E8A;background-color:#D4E6FD; width:100%">Partial</span>';
            } else {
                orderStatusBadge = '<span class="badge badge-pill" style="color:#FFB916;background-color:#FFF6CC;width:100%">Pending</span>';
            }

            var checkStatusBadge;

            if (transaction.details.paymentApproval === 'Approved') {
                checkStatusBadge = '<span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:100%">Approved</span>';
            } else if (transaction.details.paymentApproval === 'Rejected') {
                checkStatusBadge = '<span class="badge badge-pill" style="color:#d65a47;background-color:#ffcccc;width:100%">Rejected</span>';
            } else {
                checkStatusBadge = '<span class="badge badge-pill" style="color:#d381ff;background-color:#f9dfff;width:100%">Not Approved</span>';
            }

            // Mobile cards only: order status and production date (data attributes,
            // so the desktop columns and the CSV export are unchanged).
            var sisOrder = transaction.details.order || {};
            var orderStatusObj = transaction.details.status || sisOrder.status_details || null;
            var orderStatusName = (orderStatusObj && orderStatusObj.status_name) ? String(orderStatusObj.status_name) : '';
            var productionDate = sisOrder.production_date ? String(sisOrder.production_date) : '';
            var escAttr = function (v) { return v.replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;'); };

            row.innerHTML = `
                <td class="font_color row_padding"><a href="#" class="edit-order" data-value="${transaction.details.order.id}">${transaction.details.order.order_no}</a></td>
                <td class="font_color row_padding">${transaction.details.organization.organization_name}</td>
                <td class="font_color row_padding" style="text-align: right;">${transaction.details.order.order_total.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                <td class="font_color row_padding" style="text-align: right;">${transaction.details.payedAmount}</td>
                <td class="font_color row_padding" data-order-status="${escAttr(orderStatusName)}">${orderStatusBadge}</td>
                <td class="font_color row_padding">${checkStatusBadge}</td>
                <td class="font_color row_padding">${paymentTypesHtml}</td>
                <td class="font_color row_padding" data-production-date="${escAttr(productionDate)}">${transaction.details.order.open_date}</td>
                <td class="font_color row_padding">${transaction.details.order.due_date}</td>
            `;

            totalAmount += parseFloat(transaction.details.paymentCal);
            orderTotalAmount += parseFloat(transaction.details.order.order_total);
        });

        // Add row for total amount
        var totalRow = tableBody.insertRow();
        totalRow.innerHTML = `
            <td style="background-color: #F5F5F5;"></td>
            <td class="font_color row_padding" style="text-align:right;background-color: #F5F5F5;">Total Amount</td>
            <td class="font_color row_padding" style="text-align:right;background-color: #F5F5F5;">${orderTotalAmount.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
            <td style="background-color: #F5F5F5;"></td>
            <td style="background-color: #F5F5F5;"></td>
            <td style="background-color: #F5F5F5;"></td>
            <td style="background-color: #F5F5F5;"></td>
            <td style="background-color: #F5F5F5;"></td>
            <td style="background-color: #F5F5F5;"></td>
        `;

        $('#urgenttotalamount').text(totalAmount.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
    }

    function changeItemsPerPage(items) {
        ordersPerPage = parseInt(items);
        currentPage = 1; // Reset to the first page when items per page changes
        setupPaginationInvoice(transactionsArray); // Re-setup the pagination with new items per page
    }

    // Initial setup with the first set of data
    setupPaginationInvoice(transactionsArray);


    // Event listener for filter button
    document.getElementById('pin-filter').addEventListener('click', function(event) {
        event.preventDefault();

        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;
        const paymentType = document.getElementById('paymentType').value;
        const paymentStatus = document.getElementById('paymentStatus').value;

        $.ajax({
            url: '{{ route('filterSalesInvoice') }}',
            method: 'GET',
            data: {
                startDate: startDate,
                endDate: endDate,
                paymentType: paymentType,
                paymentStatus: paymentStatus
            },
            beforeSend: function () {
                // Show loader if needed
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (data) {
                console.log(data);
                updateTable(data);
            },
            error: function (error) {
                console.log('Error fetching data:', error);
            },
            complete: function () {
                // Hide loader if needed
                $(".se-pre-con").fadeOut('slow');
            }
        });
    });

    // Function to update table with new data
    function updateTable(data) {
        transactionsArray = data.combinedDetails; // Update global array with new data

        // Setup pagination with the new data
        setupPaginationInvoice(transactionsArray);

        // Reset pagination to page 1
        currentPage = 1;

        // Show the first page content
        showPageInvoice(currentPage, transactionsArray);
    }



    function printContent() {
        var content = document.querySelector('.print_content');
        var originalBody = document.body.innerHTML;
        document.body.innerHTML = content.innerHTML;
        window.print();
        document.body.innerHTML = originalBody;
    }

    document.addEventListener('DOMContentLoaded', function () {
        var printBtn = document.querySelector('.print_button');
        printBtn.addEventListener('click', function () {
            printContent();
        });
    });

    //Download CSV
    document.addEventListener('DOMContentLoaded', function () {


    var downloadBtn = document.querySelector('.download_btn');
        downloadBtn.addEventListener('click', function () {

            const startDate = document.getElementById('start-date').value;
            const endDate = document.getElementById('end-date').value;
            const paymentType = document.getElementById('paymentType').value;
            const paymentStatus = document.getElementById('paymentStatus').value;
        // console.log(startDate);
            var routeUrl = "{{ url('/salesInvoice_CSV_download/') }}" + '/' + startDate  + '/' + endDate + '/' + paymentType + '/' + paymentStatus;

            window.location.href = routeUrl;
        });
    });

    $("body").on("click", ".edit-order", function(){
        // $(".se-pre-con").fadeIn('slow');
        var orderId = $(this).data('value');
        // window.location.replace('order_details/edit/'+orderId+'/order?active_tab=order');
        window.open('order_details/edit/'+orderId+'/order?active_tab=order', '_blank');
    });

</script>

<script>
    // ── Mobile filter: completely separate from the desktop one ──
document.getElementById('start-date-m').max = today;
document.getElementById('start-date-m').value = today;
document.getElementById('end-date-m').max = today;
document.getElementById('end-date-m').value = today;
let mobileFilterInProgress = false;

function runMobileFilter() {
    if (mobileFilterInProgress) return; // stop double requests
    mobileFilterInProgress = true;

    const startDate = document.getElementById('start-date-m').value;
    const endDate = document.getElementById('end-date-m').value;
    const paymentType = document.getElementById('paymentType-m').value;
    const paymentStatus = document.getElementById('paymentStatus-m').value;

    $.ajax({
        url: '{{ route('filterSalesInvoice') }}',
        method: 'GET',
        cache: false,                 // <-- stops the browser from reusing an old response
        data: { startDate, endDate, paymentType, paymentStatus },
        beforeSend: function () { $(".se-pre-con").fadeIn('slow'); },
        success: function (data) { updateTable(data); },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('Error fetching data:', textStatus, errorThrown);
            alert('Filter failed, please try again.'); // temporary, so failures are visible instead of silent
        },
        complete: function () {
            $(".se-pre-con").fadeOut('slow');
            mobileFilterInProgress = false;
        }
    });
}

document.getElementById('pin-filter-m').addEventListener('click', function(e) {
    e.preventDefault();
    runMobileFilter();
});

document.getElementById('clear-filter-m').addEventListener('click', function(e) {
    e.preventDefault();
    window.location.reload();
});

function changeSortBy(field) {
    if (field === 'order_id') {
        transactionsArray.sort((a, b) => a.details.order.id - b.details.order.id);
    }
    currentPage = 1;
    setupPaginationInvoice(transactionsArray);
}
</script>

<script>
/* =================================================================
   MOBILE-ONLY HELPERS. Desktop behaviour is unchanged.
   ================================================================= */
(function () {
    var sisMobileQuery = window.matchMedia('(max-width: 767px)');
    function isSisMobile() { return sisMobileQuery.matches; }

    // Export (mobile header) -> existing CSV download, using the mobile filter values.
    // The download reads the desktop filter fields, so copy the mobile values in first.
    document.getElementById('sis-m-export').addEventListener('click', function () {
        document.getElementById('start-date').value = document.getElementById('start-date-m').value;
        document.getElementById('end-date').value = document.getElementById('end-date-m').value;
        document.getElementById('paymentType').value = document.getElementById('paymentType-m').value;
        document.getElementById('paymentStatus').value = document.getElementById('paymentStatus-m').value;
        document.querySelector('.download_btn').click();
    });

    // "Showing x to y of z entries" next to the pager
    function updateSisInfo() {
        var el = document.getElementById('sis-m-info');
        if (!el) return;
        var total = (window.transactionsArray || []).length;
        if (!total) { el.textContent = ''; return; }
        var per = parseInt(window.ordersPerPage, 10) || 20;
        var page = parseInt(window.currentPage, 10) || 1;
        var start = (page - 1) * per + 1;
        var end = Math.min(page * per, total);
        el.textContent = 'Showing ' + start + ' to ' + end + ' of ' + total + ' entries';
    }
    var tableBody = document.getElementById('table_body');
    if (tableBody && window.MutationObserver) {
        new MutationObserver(updateSisInfo).observe(tableBody, { childList: true });
    }
    updateSisInfo();

    // Page header: hide the layout's centered title strip (.header1) and show the
    // design header instead -- only if that strip exists, so the title never shows twice.
    // Then keep the header clear of the layout's fixed mobile top navbar.
    function fixSisHeaderOffset() {
        // Place the page header 16px below the layout's fixed mobile bar(s).
        // The space above it comes from the layout (body padding-top, header
        // containers), so it is measured instead of guessed.
        var top = document.querySelector('.sis-m-header');
        var nav = document.getElementById('sidenav-main');
        if (!top) return;
        top.style.marginTop = '';
        if (!isSisMobile() || !nav || getComputedStyle(nav).position !== 'fixed') return;

        // Bottom of everything fixed at the top of the screen (dark bar + any layout bar still visible)
        var barBottom = nav.getBoundingClientRect().bottom;
        document.querySelectorAll('.main-content nav, .main-content .navbar').forEach(function (el) {
            var cs = getComputedStyle(el), r = el.getBoundingClientRect();
            if (cs.position === 'fixed' && cs.display !== 'none' && cs.visibility !== 'hidden' && r.height > 0 && r.top <= 5) {
                barBottom = Math.max(barBottom, r.bottom);
            }
        });

        var ownHeader = document.body.classList.contains('sis-own-header');
        // Margins can collapse with the layout's margins above, so adjust, re-measure
        // and correct again until the header sits where it should.
        for (var i = 0; i < 5; i++) {
            var topOnPage = top.getBoundingClientRect().top + window.pageYOffset;
            var diff = Math.round(barBottom + 16 - topOnPage);
            // Only pull the header up when the layout's title strip is hidden (nothing is under it)
            if (Math.abs(diff) <= 1 || (diff < 0 && !ownHeader)) break;
            top.style.marginTop = (parseFloat(getComputedStyle(top).marginTop) + diff) + 'px';
        }
    }
    function setupSisHeader() {
        if (isSisMobile() && document.querySelector('.main-content .header1')) {
            document.body.classList.add('sis-own-header');
        }
        fixSisHeaderOffset();
    }
    $(function () {
        setupSisHeader();
        setTimeout(fixSisHeaderOffset, 350);
        setTimeout(fixSisHeaderOffset, 1300);
    });
    window.addEventListener('load', fixSisHeaderOffset);   // logo size changes the bar height
    var sisResizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(sisResizeTimer);
        sisResizeTimer = setTimeout(setupSisHeader, 150);
    });
})();
</script>

@endsection