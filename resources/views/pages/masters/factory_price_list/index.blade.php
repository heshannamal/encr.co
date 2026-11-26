@extends('layouts.app', ['activePage' => 'fabrics', 'titlePage' => __('Fabrics')])

@section('content')

<style>
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
    .filter_div {
        margin-top: 15px;
        margin-bottom: 15px;
        border-radius: 2px;
        border: unset;
        padding: 10px;
        width: 100%;
    }
    .table_header_text {
        color: white;
        height: 40px;
    }
    .row_padding {
        padding-top: 10px !important;
        padding-bottom: 10px !important;
    }
    .date_selection {
        background-color: transparent;
        padding: unset;
        border: unset;
        color: #47D6B6;
        font-size: 11px;
    }
    .date_p {
        margin: unset;
        font-size: 11px;
        color: #B3B3B3;
        font-weight: 500;
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
    .submit-changes-icon {
        text-align: right;
    }
    .save_filter {
        border-radius: 16px;
        padding-top: unset;
        padding-bottom: unset;
        margin-top: 3px;
        height: 24px;
    }
    .product-search-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        width: 320px;
        max-width: 100%;
    }

    .product-search-input {
        width: 100%;
        height: 38px;
        padding: 8px 38px 8px 38px;
        border: 1px solid #dcdfe4;
        border-radius: 8px;
        background-color: #fff;
        color: #333;
        font-size: 13px;
        outline: none;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    .product-search-input::placeholder {
        color: #a0a4aa;
    }

    .product-search-input:focus {
        border-color: #47D6B6;
        box-shadow: 0 0 0 3px rgba(71, 214, 182, 0.12);
    }

    .product-search-icon {
        position: absolute;
        left: 13px;
        color: #8d9298;
        font-size: 13px;
        pointer-events: none;
    }

    .product-search-clear {
        position: absolute;
        right: 8px;
        border: none;
        background: transparent;
        color: #9ca3af;
        width: 26px;
        height: 26px;
        padding: 0;
        border-radius: 50%;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .product-search-clear:hover {
        background-color: #f1f3f5;
        color: #555;
    }

    @media (max-width: 768px) {
        .product-search-wrapper {
            width: 100%;
            margin-top: 8px;
        }

        .print_btn {
            width: 100%;
        }
    }
    .items-per-page-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 5px 0;
        font-size: 13px;
        color: #6b7280;
    }

    .items-per-page-label {
        white-space: nowrap;
    }

    .items-per-page-select-wrap {
        position: relative;
        display: inline-flex;
        align-items: center;
    }

    .items-per-page-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;

        height: 38px;
        min-width: 74px;

        padding: 7px 30px 7px 12px;

        border: 1px solid #dcdfe4;
        border-radius: 8px;

        background-color: #fff;
        color: #333;

        font-size: 13px;
        font-weight: 500;

        outline: none;
        cursor: pointer;

        transition: all 0.2s ease;

        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    .items-per-page-select:hover {
        border-color: #bfc5cb;
    }

    .items-per-page-select:focus {
        border-color: #47D6B6;
        box-shadow: 0 0 0 3px rgba(71, 214, 182, 0.12);
    }

    .items-per-page-icon {
        position: absolute;
        right: 11px;

        font-size: 10px;
        color: #8d9298;

        pointer-events: none;
    }

    @media (max-width: 768px) {
        .items-per-page-wrapper {
            width: 100%;
            justify-content: flex-start;
        }
    }
    
    .filter_toggle { display: none; }

    .card-save-btn { display: none !important; }
    
   /* MOBILE VIEW (max-width: 768px) */
    @media only screen and (max-width: 768px) {

        /* Main page spacing */
        .container-fluid.content-position {
            padding-left: 15px !important;
            padding-right: 15px !important;
            padding-top: 10px !important;
        }

        .row.col-md-12 {
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Mobile page heading */
        .order-header,
        .content-position .table_header_text {
            font-size: 17px !important;
        }

        /* Search bar - moved visually to the top */
        .orders_summary {
            position: relative !important;
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            border: none !important;
            background: transparent !important;
        }

        .orders_summary > .row {
            display: block !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .orders_summary > .row > div:first-child {
            display: none !important;
        }

        /* Pricing filter - full width */
        .filter_div > .row > div:nth-child(3) {
            grid-column: 1 / -1 !important;
        }
         
        .row.col-md-12 {
            position: relative !important;
        }

        .row.col-md-12 .filter_div {
            position: relative !important;
            margin-top: 62px !important;
        }

        /* Export - left half, above the card */
        .row.col-md-12 .filter_div > .row > .buttonDiv {
            position: absolute !important;
            top: -62px !important;
            left: 0 !important;
            right: auto !important;
            width: calc(50% - 6px) !important;
            margin: 0 !important;
            padding: 0 !important;
            grid-column: auto !important;
        }

        #display_csv::before {
            content: "\f019";
            font-family: 'Font Awesome 5 Free', 'FontAwesome';
            font-weight: 900;
            margin-right: 8px;
        }

        /* Filters toggle - right half, above the card */
        .row.col-md-12 > .filter_toggle {
            display: flex !important;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: absolute !important;
            top: 0 !important;
            right: 0 !important;
            left: auto !important;
            width: calc(50% - 6px) !important;
            height: 48px;
            border: 1px solid #dfe5ed;
            border-radius: 12px;
            background: #fff;
            color: #526176;
            font-size: 15px;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            outline: none;
            /* z-index: 2; */
        }

        .filter_toggle_arrow {
            /* font-size: 11px; */
            transition: transform 0.2s ease;
        }

        /* .filter_div.filters-collapsed ~ .filter_toggle .filter_toggle_arrow {
            transform: rotate(180deg);
        } */

        /* Collapsed: hide filters card, keep the two buttons */
        /* .row.col-md-12 .filter_div.filters-collapsed {
            padding: 0 !important;
            background: transparent !important;
            box-shadow: none !important;
            margin-bottom: 15px !important;
        } */

        /* .filter_div.filters-collapsed > .row > div:not(.buttonDiv) {
            display: none !important;
        } */

        /* Export box no longer the positioning parent for the Save button */
        .row.col-md-12 .filter_div > .row > .buttonDiv {
            position: static !important;
        }

        /* Export button itself is pinned above the card instead */
        .row.col-md-12 .filter_div #display_csv {
            position: absolute !important;
            top: -62px !important;
            left: 0 !important;
            width: calc(50% - 6px) !important;
            margin: 0 !important;
        }

        /* Save button: hidden on mobile (mobile uses individual per-card Save buttons) */
        .row.col-md-12 .filter_div .submit-changes-icon,
        .submit-changes-icon {
            display: none !important;
        }

        /* Default = collapsed (page load). Class "filters-collapsed" now means OPEN after a tap. */
        .row.col-md-12 .filter_div:not(.filters-collapsed) {
            padding: 0 !important;
            background: transparent !important;
            box-shadow: none !important;
        }

        .row.col-md-12 .filter_div:not(.filters-collapsed) > .row > div:not(.buttonDiv) {
            display: none !important;
        }

        /* Arrow: down when closed, up when open */
        .filter_toggle .filter_toggle_arrow {
            transform: rotate(180deg);
        }

        .filter_div.filters-collapsed ~ .filter_toggle .filter_toggle_arrow {
            transform: none;
        }
        .print_btn {
            display: block !important;
            width: 100% !important;
            margin: 0 0 15px 0 !important;
            padding: 0 !important;
        }

        #searchOrder {
            width: 100% !important;
            height: 52px !important;
            padding: 0 18px 0 45px !important;
            border: 1px solid #e1e5eb !important;
            border-radius: 17px !important;
            background-color: #fff !important;
            font-size: 16px !important;
            color: #343a40 !important;
            box-shadow: 0 2px 5px rgba(0,0,0,0.04) !important;
        }

        #searchOrder::placeholder {
            color: #a6acb4 !important;
            opacity: 1;
        }

        /* Filters card */
        .filter_div {
            width: 100% !important;
            /* margin: 0 0 20px 0 !important; */
            padding: 18px 14px !important;
            border: none !important;
            border-radius: 13px !important;
            background: #fff !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07) !important;
        }

        .filter_div > .row {
            display: grid !important;
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 18px 12px !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Individual filter columns */
        .filter_div > .row > div {
            width: 100% !important;
            min-width: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .filter_row {
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
            width: 100% !important;
            min-height: auto !important;
            margin: 0 !important;
            padding: 0 !important;
            gap: 8px !important;
            border: none !important;
            border-radius: 0 !important;
            background: transparent !important;
        }

        .filter_row p {
            margin: 0 !important;
            padding: 0 !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            color: #343a40 !important;
        }

        .paymen_type_div {
            width: 100% !important;
            min-width: 0 !important;
        }

        .filter_row select,
        .date_selection {
            width: 100% !important;
            height: 48px !important;
            padding: 0 8px !important;
            /* border: 1px solid #e0e3e8 !important; */
            border-radius: 12px !important;
            background-color: #f3f4f6 !important;
            color: #10bd91 !important;
            font-size: 15px !important;
            outline: none !important;
        }

        /* Save & Filter button */
        .filter_div > .row > div:nth-child(4) {
            grid-column: 1 / -1 !important;
            width: 100% !important;
            margin-top: 0 !important;
        }

        .save_filter {
            width: 100% !important;
            height: 48px !important;
            margin: 0 !important;
            padding: 0 12px !important;
            border: 1px solid #dfe5ed !important;
            border-radius: 12px !important;
            background: #fff !important;
            color: #526176 !important;
            font-size: 15px !important;
            font-weight: 600 !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.07) !important;
        }

        /* Export button */
        .filter_div > .row > .buttonDiv {
            grid-column: 1 / -1 !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .buttonDiv {
            display: flex !important;
            justify-content: center !important;
        }

        #display_csv {
            width: 100% !important;
            height: 48px !important;
            margin: 0 !important;
            padding: 0 15px !important;
            border: 1px solid #dfe5ed !important;
            border-radius: 12px !important;
            background: #fff !important;
            color: #526176 !important;
            font-size: 15px !important;
            font-weight: 600 !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05) !important;
        }

        /* Save changes button */
        .submit-changes-icon {
            display: none !important;
            width: 100% !important;
            margin: 0 0 10px 0 !important;
            text-align: center !important;
        }

        .save_btn {
            width: 100% !important;
            height: 45px !important;
            border-radius: 12px !important;
            font-size: 15px !important;
        }

        /* Product summary section */
        .order_sammary_table {
            width: 100% !important;
            overflow: visible !important;
            padding: 0 !important;
        }

        #order_sammary_table {
            display: block !important;
            width: 100% !important;
            min-width: 0 !important;
            margin: 0 !important;
            border: none !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            background: transparent !important;
        }

        /* Hide desktop table heading */
        #order_sammary_table thead {
            display: none !important;
        }

        #order_sammary_table tbody {
            display: flex !important;
            flex-direction: column !important;
            gap: 16px !important;
            width: 100% !important;
        }

        /* Individual product card */
        #order_sammary_table tbody tr {
            display: grid !important;
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 13px 12px !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 16px 14px !important;
            /* padding-left: 78px !important; */
            border: 1px solid #e5e8ed !important;
            border-radius: 20px !important;
            background: #fff !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06) !important;
            position: relative !important;
            cursor: pointer !important;
        }

        /* Shirt icon thumbnail on top-left */
        /* #order_sammary_table tbody tr::before {
            content: "" !important;
            position: absolute !important;
            left: 14px !important;
            top: 16px !important;
            width: 52px !important;
            height: 52px !important;
            border: 1px solid #e5e8ed !important;
            border-radius: 12px !important;
            background-color: #ffffff !important;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='30' height='30' fill='%23b8c0cc'><path d='M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.57a1 1 0 00.99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 002-2V10h2.15a1 1 0 00.99-.84l.58-3.57a2 2 0 00-1.34-2.23z'/></svg>") !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
            background-size: 30px 30px !important;
            pointer-events: none !important;
            z-index: 1 !important;
        } */

        /* Dropdown chevron on top-right */
        #order_sammary_table tbody tr::after {
            content: "\f077" !important; /* chevron-up (expanded) */
            font-family: 'Font Awesome 5 Free', 'FontAwesome' !important;
            font-weight: 900 !important;
            position: absolute !important;
            right: 18px !important;
            top: 17px !important;
            font-size: 13px !important;
            color: #4b5563 !important;
            pointer-events: none !important;
        }

        #order_sammary_table tbody tr.is-collapsed::after {
            content: "\f078" !important; /* chevron-down (collapsed) */
        }

        #order_sammary_table tbody td {
            display: block !important;
            width: 100% !important;
            min-width: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
            border: none !important;
            background: transparent !important;
            white-space: normal !important;
            overflow-wrap: anywhere !important;
            color: #343a40 !important;
            font-size: 14px !important;
            text-align: left !important;
        }

        /* ── HEADER ORDER: 1) Product Name, 2) PRO Code, 3) Pattern Code ── */

        /* 1. Product Name: top line, bold dark */
        #order_sammary_table tbody td:nth-child(2) {
            order: 1 !important;
            grid-column: 1 / -1 !important;
            font-size: 14.5px !important;
            font-weight: 700 !important;
            line-height: 1.3 !important;
            color: #292e35 !important;
            padding-right: 30px !important;
        }

        /* 2. Product Number (PRO-x): green, under Name */
        #order_sammary_table tbody td:nth-child(1) {
            order: 2 !important;
            grid-column: 1 / -1 !important;
            color: #10bd91 !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            line-height: 1.4 !important;
            margin-top: -6px !important;
        }

        /* 3. Pattern Code (DWC0120): grey, under PRO */
        #order_sammary_table tbody td:nth-child(3) {
            order: 3 !important;
            grid-column: 1 / -1 !important;
            padding-bottom: 12px !important;
            border-bottom: 1px solid #e0e3e8 !important;
            color: #737d8c !important;
            font-size: 13px !important;
            line-height: 1.4 !important;
            margin-top: -6px !important;
        }

        /* Price labels and Weight label */
        #order_sammary_table tbody td:has(input[type="number"]) {
            order: 4 !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 8px !important;
            min-width: 0 !important;
        }

        #order_sammary_table tbody td:has(input.weight)::before {
            content: "Weight(lbs)";
        }

        #order_sammary_table tbody td:has(input.Manufacturer_price)::before {
            content: "Manufacturer price";
        }

        #order_sammary_table tbody td:has(input.General_price)::before {
            content: "General price";
        }

        #order_sammary_table tbody td:has(input.Platinum_price)::before {
            content: "Platinum price";
        }

        #order_sammary_table tbody td:has(input.Gold_price)::before {
            content: "Gold price";
        }

        #order_sammary_table tbody td:has(input.Silver_price)::before {
            content: "Silver price";
        }

        #order_sammary_table tbody td:has(input[type="number"])::before {
            display: block;
            color: #657080;
            font-size: 13px;
            font-weight: 600;
            line-height: 1.3;
        }

        /* Editable price inputs */
        #order_sammary_table tbody input[type="number"] {
            display: block !important;
            width: 100% !important;
            height: 48px !important;
            padding: 10px 12px !important;
            border: 1px solid #e0e4e9 !important;
            border-radius: 12px !important;
            background: #f7f8fa !important;
            color: #343a40 !important;
            font-size: 14px !important;
            text-align: left !important;
            box-shadow: none !important;
        }

        #order_sammary_table tbody input[type="number"]:focus {
            border-color: #20bd91 !important;
            background: #fff !important;
            outline: none !important;
        }

        /* Save confirmation icon and card save button on bottom line */
        #order_sammary_table tbody td.check-icon {
            order: 5 !important;
            grid-column: 1 / -1 !important;
            position: relative !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            min-height: 48px !important;
            padding-top: 10px !important;
            border-top: none !important;
            background-color: transparent !important;
        }

        /* Icon pinned to the right, doesn't affect button position */
        #order_sammary_table tbody td.check-icon i.fa-circle-check,
        #order_sammary_table tbody td.check-icon i.fa-check-circle {
            position: absolute !important;
            right: 4px !important;
            top: 50% !important;
            transform: translateY(-30%) !important;
            font-size: 20px !important;
            color: #05d34e !important;
            margin: 0 !important;
        }

        /* Save button - default disabled state */
        .card-save-btn {
            background-color: #e5e7eb !important;
            color: #9ca3af !important;
            border: 1px solid #d1d5db !important;
            border-radius: 12px !important;
            padding: 9px 24px !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            cursor: not-allowed !important;
            box-shadow: none !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            height: 44px !important;
            /* min-width: 80% !important; */
            min-width: 0 !important;
            width: calc(100% - 60px) !important;
            opacity: 1 !important;
        }

        /* Active Save button after editing */
        .card-save-btn.active {
            background-color: #1AA05A !important;
            color: #ffffff !important;
            border: none !important;
            cursor: pointer !important;
            box-shadow: 0 2px 6px rgba(5, 211, 78, 0.25) !important;
        }

        .card-save-btn.active:hover {
            background-color: #148c4e !important;
        }

        .card-save-btn.active:active {
            transform: scale(0.97) !important;
        }

        /* Saving state */
        .card-save-btn:disabled {
            cursor: not-allowed !important;
        }

        .card-save-btn:hover {
            background-color: #04b844 !important;
            color: #ffffff !important;
        }

        .card-save-btn:active {
            transform: scale(0.97) !important;
        }

        #order_sammary_table tbody td.check-icon i.fa-circle-check,
        #order_sammary_table tbody td.check-icon i.fa-check-circle {
            font-size: 20px !important;
            color: #05d34e !important;
            margin: 0 !important;
        }

        /* ── Collapsible State (is-collapsed) ── */
        #order_sammary_table tbody tr.is-collapsed td:has(input[type="number"]),
        #order_sammary_table tbody tr.is-collapsed td.check-icon {
            display: none !important;
        }

        #order_sammary_table tbody tr.is-collapsed td:nth-child(3) {
            border-bottom: none !important;
            padding-bottom: 0 !important;
        }

        /* Pagination */
        #paginationbar {
            width: 100% !important;
            margin: 16px 0 !important;
            padding: 0 !important;
            overflow-x: auto !important;
            display: flex !important;
            justify-content: center !important;
        }

        #paginationbar .pagination {
            display: flex !important;
            justify-content: center !important;
            flex-wrap: wrap !important;
            gap: 4px !important;
            margin: 0 !important;
        }

        #paginationbar .page-item .page-link,
        #paginationbar .page-item span,
        #paginationbar .page-link {
            border-radius: 8px !important;
            border: 1px solid #e2e8f0 !important;
            color: #475569 !important;
            font-size: 13px !important;
            padding: 6px 12px !important;
            background: #ffffff !important;
        }

        #paginationbar .page-item.active .page-link {
            background-color: #14B8A6 !important;
            border-color: #14B8A6 !important;
            color: #ffffff !important;
            font-weight: 700 !important;
        }

        /* Remove unnecessary desktop spacing */
        .orders_summary > div {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
    }

    /* Smaller phones */
    @media only screen and (max-width: 380px) {

        .filter_div {
            padding: 14px 10px !important;
        }

        .filter_div > .row {
            gap: 15px 8px !important;
        }

        #order_sammary_table tbody tr {
            /* padding: 15px 11px !important; */
            /* padding-left: 72px !important; */
            gap: 11px 9px !important;
        }

        #order_sammary_table tbody tr::before {
            left: 11px !important;
            width: 48px !important;
            height: 48px !important;
            background-size: 26px 26px !important;
        }

        #order_sammary_table tbody input[type="number"] {
            height: 44px !important;
        }

        #order_sammary_table tbody td:has(input[type="number"])::before {
            font-size: 12px !important;
        }
    }

</style>

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>PRODUCTS PRICE LIST & WEIGHT</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="row col-md-12" style="padding: 0rem;">

        <div class="card filter_div">
            <div class="row" style="padding-left: 15px; margin: unset;">

                <div style="margin-right: 20px; margin-top: 3px;">
                    <div class="row filter_row" style="padding-bottom: 2px;">
                        <p class="font_color date_p">Product Status |  </p>
                        <div class="paymen_type_div date_selection">
                            <select id="activeInactive" class="date_selection">
                                <option value="">All</option>
                                <option value="1" {{ (isset($activeStatus) && $activeStatus == 1) ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ (isset($activeStatus) && $activeStatus == 0) ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div style="margin-right: 20px; margin-top: 3px;">
                    <div class="row filter_row" style="padding-bottom: 2px;">
                        <p class="font_color date_p">Price Types |  </p>
                        <div class="paymen_type_div date_selection">
                            <select id="pricetypes" class="date_selection">
                                <option value="">All</option>
                                <option value="1" {{ (isset($pricetype) && $pricetype == 1) ? 'selected' : '' }}>General</option>
                                <option value="2" {{ (isset($pricetype) && $pricetype == 2) ? 'selected' : '' }}>Silver</option>
                                <option value="3" {{ (isset($pricetype) && $pricetype == 3) ? 'selected' : '' }}>Gold</option>
                                <option value="4" {{ (isset($pricetype) && $pricetype == 4) ? 'selected' : '' }}>Platinum</option>
                                <option value="5" {{ (isset($pricetype) && $pricetype == 5) ? 'selected' : '' }}>Manufacturer</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div style="margin-right: 20px; margin-top: 3px;">
                    <div class="row filter_row" style="padding-bottom: 2px;">
                        <p class="font_color date_p">Pricing |  </p>
                        <div class="paymen_type_div date_selection">
                            <select id="pricingOrNot" class="date_selection">
                                <option value="">All</option>
                                <option value="1" {{ (isset($pricingStatus) && $pricingStatus == 1) ? 'selected' : '' }}>Available</option>
                                <option value="2" {{ (isset($pricingStatus) && $pricingStatus == 2) ? 'selected' : '' }}>Not Available</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="">
                    <button class="styled-button save_filter" style="outline: unset;" href="#" id="save_filter" title="Save Filter">
                        Save & Filter
                    </button>
                </div>

                <div class="ml-auto row buttonDiv">
                    <button class="styled-button download_btn" style="outline: unset; margin-left: 14px;" href="#" id="display_csv" title="Display CSV">
                        Export
                    </button>
                </div>

            </div>
        </div>

        <button type="button" class="filter_toggle">
            <i class="fas fa-sliders-h"></i> Filters <i class="fas fa-chevron-up filter_toggle_arrow"></i>
        </button>

        <div class="card orders_summary print_content" style="border: unset; padding: 10px; width: 100%;">

            <div class="row" style="margin: unset;">
                <div class="items-per-page-wrapper">
                    <span class="items-per-page-label">Show</span>

                    <div class="items-per-page-select-wrap">
                        <select
                            id="itemsPerPage"
                            class="items-per-page-select"
                            onchange="changeItemsPerPage(this.value)"
                        >
                            <option value="30" selected>30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="500">500</option>
                        </select>

                        <i class="fas fa-chevron-down items-per-page-icon"></i>
                    </div>

                    <span class="items-per-page-label">per page</span>
                </div>

                <div class="ml-auto print_btn">
                    <div class="product-search-wrapper">
                        <i class="fas fa-search product-search-icon"></i>

                        <input
                            class="search_class product-search-input"
                            id="searchOrder"
                            type="text"
                            placeholder="Search by product no or name..."
                            value="{{ isset($searchValue) ? $searchValue : '' }}"
                            autocomplete="off"
                        >

                        <button type="button" class="product-search-clear" id="clearSearch" title="Clear search">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>


            </div>



            <div class="order_sammary_table" style="overflow-x: auto;">

                <div id="global_check_icon" style="text-align: right; padding-right: 10px;"></div>

                <table class="table align-items-center" id="order_sammary_table" style="min-width: 100%;">

                    <thead style="background-color: #717070;">
                        <th scope="col" class="table_header_text">PRODUCT NO</th>
                        <th scope="col" class="table_header_text">PRODUCT NAME</th>
                        <th scope="col" class="table_header_text">PATTERN CODE</th>

                            <th scope="col" class="table_header_text" style="text-align: right;">WEIGHT(lbs)</th>

                            <th scope="col" class="table_header_text Manufacturer_price" style="text-align: right;">MANUFACTURER PRICE</th>

                            <th scope="col" class="table_header_text General_price" style="text-align: right;">GENERAL PRICE</th>

                            <th scope="col" class="table_header_text Platinum_price" style="text-align: right;">PLATINUM PRICE</th>

                            <th scope="col" class="table_header_text Gold_price" style="text-align: right;">GOLD PRICE</th>

                            <th scope="col" class="table_header_text Silver_price" style="text-align: right;">SILVER PRICE</th>



                        <th scope="col" class="table_header_text"></th>
                    </thead>

                    <tbody id="table_body">

                    </tbody>
                </table>

            </div>
            <div style="padding-top: 10px;">
                <div id="paginationbar" class="row justify-content-center" style="width: 100%;">
                  {{-- pagination bar paste here --}}
                </div>
            </div>
        </div>

    </div>

</div>

<script>
$(function () {
    $(".se-pre-con").fadeOut('slow');

    let changedPrices = [];
    let tableBody = document.getElementById('table_body');
    let paginationBar = document.getElementById('paginationbar');
    let ordersPerPage = 30;
    let currentPage = 1;
    let orderArray = @json($subProduct);
    let pricetype = @json($pricetype);

    // ----------- Render Table -----------
    function showOrders(page, data, pricetype) {
        updateColumnsVisibility(pricetype);
        tableBody.innerHTML = '';

        let startIndex = (page - 1) * ordersPerPage;
        let endIndex = Math.min(startIndex + ordersPerPage, data.length);
        let totalPages = Math.ceil(data.length / ordersPerPage);

        for (let i = startIndex; i < endIndex; i++) {
            let transaction = data[i];
            let patternCode = transaction.pattern_code || '';
            let weight = transaction.weight || '';
            let row = tableBody.insertRow();

            if (transaction.active == 0) {
                row.style.color = 'red';
            }

            // Build price columns dynamically
            let priceColumns = '';

            if (pricetype == null || pricetype == 5) {
                priceColumns += createPriceColumn('Manufacturer_price', transaction.price);
            }
            if (pricetype == null || pricetype == 1) {
                priceColumns += createPriceColumn('General_price', transaction.General_price);
            }
            if (pricetype == null || pricetype == 4) {
                priceColumns += createPriceColumn('Platinum_price', transaction.Platinum_price);
            }
            if (pricetype == null || pricetype == 3) {
                priceColumns += createPriceColumn('Gold_price', transaction.Gold_price);
            }
            if (pricetype == null || pricetype == 2) {
                priceColumns += createPriceColumn('Silver_price', transaction.Silver_price);
            }

            row.innerHTML = `
                <td class="font_color row_padding">${transaction.sub_product_no}</td>
                <td class="font_color row_padding">${transaction.product_name}</td>
                <td class="font_color row_padding">${patternCode}</td>
                <td class="font_color row_padding" style="text-align: right;">
                    <input type="number"
                        class="form-control form-input weight"
                        value="${transaction.weight ? parseFloat(transaction.weight) : ''}"
                        step="0.001"
                        min="0"
                        style="text-align: right; width: 100px; display: inline-block; height: 25px;"
                        data-type="weight" />
                </td>
                ${priceColumns}
                <td style="background-color: rgb(240 255 234);" class="font_color row_padding check-icon"></td>
            `;

            attachInputListeners(row, transaction.sub_product_no);
        }

        updatePagination(totalPages, currentPage);
    }

    function createPriceColumn(className, value) {
        return `
            <td class="font_color row_padding" style="text-align: right;background-color: rgb(240 255 234);">
                <input type="number" class="form-control form-input ${className}"
                       value="${value || ''}"
                       step="0.01"
                       style="text-align: right; width: 100px; display: inline-block; height: 25px;background-color: transparent;"
                       data-type="${className}" />
            </td>`;
    }

    function attachInputListeners(row, subProductNo) {
        let checkIconCell = row.querySelector('.check-icon');

        // Initially show a disabled Save button
        checkIconCell.innerHTML = `
            <button type="button" class="styled-button card-save-btn"title="No changes to save"disabled>Save</button>`;

        row.querySelectorAll('input[type="number"]').forEach(input => {
            let priceType = input.dataset.type;

            input.addEventListener('input', function () {
                // checkIconCell.innerHTML = `<i class="fa fas fa-circle-check"
                //                              style="color: lime; font-size: 18px; cursor: pointer;"></i>`;
                // checkIconCell.innerHTML = `
                //     <button type="button" class="styled-button card-save-btn" title="Save this item">Save</button>
                //     <i class="fa fa-check-circle" style="color: #05d34e; font-size: 20px; cursor: pointer;"></i>`;

                checkIconCell.innerHTML = `
                    <button type="button" class="styled-button card-save-btn active" title="Save this item">Save</button>
                    <i class="fa fa-check-circle" style="color: #05d34e; font-size: 20px;"></i>`;

                let newPrice = this.value.trim();
                let existingIndex = changedPrices.findIndex(change => change.sub_product_no === subProductNo);

                if (existingIndex !== -1) {
                    changedPrices[existingIndex][priceType] = newPrice;
                } else {
                    let change = { sub_product_no: subProductNo };
                    change[priceType] = newPrice;
                    changedPrices.push(change);
                }

                ensureSaveButton();
            });
        });

        // Click handler for this card's Save button
        checkIconCell.addEventListener('click', function (e) {
            let saveBtn = e.target.closest('.card-save-btn');
            if (!saveBtn) return;
            e.stopPropagation();

            let itemChange = changedPrices.find(change => change.sub_product_no === subProductNo);
            if (!itemChange) {
                // If not in changedPrices yet, read from inputs on this row
                let collected = { sub_product_no: subProductNo };
                let hasValue = false;
                row.querySelectorAll('input[type="number"]').forEach(input => {
                    let val = input.value.trim();
                    if (val !== '') {
                        collected[input.dataset.type] = val;
                        hasValue = true;
                    }
                });
                if (hasValue) {
                    itemChange = collected;
                }
            }

            if (!itemChange) {
                alert('No changes have been made for this item.');
                return;
            }

            saveBtn.disabled = true;
            saveBtn.innerText = 'Saving...';

            $.ajax({
                url: 'manufacturerPrice',
                method: 'POST',
                data: {
                    changes: [itemChange],
                    _token: '{{ csrf_token() }}'
                },
                success: function () {
                    // Remove saved item from global changedPrices
                    changedPrices = changedPrices.filter(c => c.sub_product_no !== subProductNo);
                    if (changedPrices.length === 0) {
                        let topSubmit = document.querySelector('.submit-changes-icon');
                        if (topSubmit) topSubmit.remove();
                    }
                    location.reload();
                },
                error: function (xhr, status, error) {
                    saveBtn.disabled = false;
                    saveBtn.innerText = 'Save';
                    console.error('Error sending data:', error);
                    alert('Error saving prices. Please try again.');
                }
            });
        });
    }

    // ----------- Save Button -----------
    function ensureSaveButton() {
        if (window.innerWidth <= 768) {
            return; // Do not show top save-all button on mobile
        }
        let existingSubmitIcon = document.querySelector('.submit-changes-icon');
        if (!existingSubmitIcon) {
            let submitIcon = document.createElement('div');
            submitIcon.className = 'submit-changes-icon';
            submitIcon.innerHTML = `
                <button class="styled-button save_btn"
                        style="outline: unset; background-color: rgb(23, 217, 23); color: white; height: 30px;"
                        id="save_prices" title="Save Prices">Save</button>`;

            let exportButtonContainer = document.querySelector('.buttonDiv');
            let exportButton = exportButtonContainer.querySelector('#display_csv');

            exportButtonContainer.insertBefore(submitIcon, exportButton);

            submitIcon.addEventListener('click', function () {
                if (changedPrices.length > 0) {
                    $.ajax({
                        url: 'manufacturerPrice',
                        method: 'POST',
                        data: {
                            changes: changedPrices,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function () {
                            console.log('Prices updated successfully');
                            changedPrices = []; // reset after save
                            location.reload();
                        },
                        error: function (xhr, status, error) {
                            console.error('Error sending data:', error);
                        }
                    });
                } else {
                    alert('No changes have been made.');
                }
            });
        }
    }

    // ----------- Pagination -----------
    function updatePagination(totalPages, currentPage) {
        paginationBar.innerHTML = '';
        if (totalPages <= 1) return;

        let pagination = '<nav aria-label="Page navigation"><ul class="pagination">';

        pagination += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">&laquo;</a></li>`;

        let startPage = Math.max(1, currentPage - 3);
        let endPage = Math.min(totalPages, currentPage + 3);

        for (let i = startPage; i <= endPage; i++) {
            pagination += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" onclick="changePage(${i})">${i}</a></li>`;
        }

        pagination += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">&raquo;</a></li>`;

        pagination += '</ul></nav>';
        paginationBar.innerHTML = pagination;
    }

    window.changePage = function (page) {
        let totalPages = Math.ceil(orderArray.length / ordersPerPage);
        if (page < 1) page = 1;
        if (page > totalPages) page = totalPages;
        currentPage = page;
        showOrders(currentPage, orderArray, pricetype);
    };

    window.changeItemsPerPage = function (itemsPerPage) {
        ordersPerPage = parseInt(itemsPerPage);
        currentPage = 1;
        showOrders(currentPage, orderArray, pricetype);
    };

    // ----------- Search / Filter -----------
    let searchValue = null, prevActive = '', prevPricing = '', prevPricetype = '';

    function performSearch() {
        let inputValue = $('#searchOrder').val().trim();
        let activeStatus = $('#activeInactive').val();
        let pricingStatus = $('#pricingOrNot').val();
        let pricetype = $('#pricetypes').val();

        if (inputValue !== searchValue || activeStatus !== prevActive ||
            pricingStatus !== prevPricing || pricetype !== prevPricetype) {

            searchValue = inputValue;
            prevActive = activeStatus;
            prevPricing = pricingStatus;
            prevPricetype = pricetype;

            $.ajax({
                url: "{{ route('subProductSearch') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    searchValue,
                    activeStatus,
                    pricingStatus,
                    pricetype
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (response) {
                    orderArray = response.subProducts;
                    pricetype = response.pricetype;
                    currentPage = 1;
                    showOrders(currentPage, orderArray, pricetype);
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        }
    }

    $('#searchOrder').on('keyup blur', function (e) {
        if (e.type === 'blur' || e.key === 'Enter') performSearch();
    });

    $('#activeInactive, #pricingOrNot, #pricetypes').on('change', performSearch);

    // ----------- Save Filters -----------
    $('#save_filter').click(function () {
        let inputValue = $('#searchOrder').val().trim() || '';
        let activeStatus = $('#activeInactive').val() || '';
        let pricingStatus = $('#pricingOrNot').val() || '';
        let pricetype = $('#pricetypes').val() || '';

        $.ajax({
            url: "{{ route('saveFactoryPriceFilter') }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                searchValue: inputValue,
                activeStatus,
                pricingStatus,
                pricetype
            },
            success: function (response) {
                console.log('Filter saved successfully:', response);
                window.location.reload();
            },
            error: function (xhr, status, error) {
                console.error('Error saving filter:', error);
            }
        });
    });

    // ----------- Download CSV -----------
    $('.download_btn').click(function () {
        let activeInactive = $('#activeInactive').val() || 'all';
        let pricingOrNot = $('#pricingOrNot').val() || 'all';
        let inputValue = $('#searchOrder').val().trim() || 'all';
        let pricetype = $('#pricetypes').val().trim() || 'all';

        let routeUrl = "{{ url('/factoryPriceList_CSV_download') }}" +
            '/' + activeInactive + '/' + pricingOrNot + '/' + inputValue + '/' + pricetype;

        window.location.href = routeUrl;
    });

    // ----------- Column Visibility -----------
    function updateColumnsVisibility(pricetype) {
        const columnClasses = {
            5: 'Manufacturer_price',
            4: 'Platinum_price',
            3: 'Gold_price',
            2: 'Silver_price',
            1: 'General_price'
        };

        Object.values(columnClasses).forEach(className => {
            document.querySelectorAll(`.${className}`).forEach(column => {
                column.style.display = 'none';
            });
        });

        if (pricetype === null) {
            Object.values(columnClasses).forEach(className => {
                document.querySelectorAll(`.${className}`).forEach(column => {
                    column.style.display = '';
                });
            });
        } else {
            let className = columnClasses[pricetype];
            if (className) {
                document.querySelectorAll(`.${className}`).forEach(column => {
                    column.style.display = '';
                });
            }
        }
    }

    // Initial render
    showOrders(currentPage, orderArray, pricetype);
});
</script>

<!-- Mobile collapse/expand for factory price list cards -->
<script>
$(function () {
    var isMobile = function () {
        return window.innerWidth <= 768;
    };

    // Collapse newly rendered rows on mobile
    function setupMobileCards() {
        if (!isMobile()) return;
        $('#order_sammary_table tbody tr:not(.toggle-init)').each(function () {
            $(this).addClass('is-collapsed toggle-init');
        });
    }

    // Observe dynamic rows added to table body
    var tableBody = document.getElementById('table_body');
    if (tableBody) {
        var observer = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                if (mutation.addedNodes.length > 0) {
                    setupMobileCards();
                }
            });
        });
        observer.observe(tableBody, { childList: true });
    }

    setupMobileCards();

    // Toggle expand / collapse on card click, ignoring input and button interactions
    $(document).on('click', '#order_sammary_table tbody tr', function (e) {
        if (!isMobile()) return;
        if ($(e.target).is('input, button, a') || $(e.target).closest('input, button, a, .card-save-btn, .check-icon').length) return;
        $(this).toggleClass('is-collapsed');
    });

    $(window).on('resize', function () {
        if (isMobile()) {
            setupMobileCards();
        } else {
            $('#order_sammary_table tbody tr').removeClass('is-collapsed');
        }
    });
});

$('.filter_toggle').on('click', function () {
    $('.filter_div').toggleClass('filters-collapsed');
});

</script>



@endsection
