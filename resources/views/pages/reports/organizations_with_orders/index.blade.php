@extends('layouts.app', ['activePage' => 'organizations_with_orders', 'titlePage' => __('Organizations with orders')])

@section('content')
<style>
    .content-position {
        padding-left: 15px !important;
        padding-right: 15px !important;
    }
    .print_btn {
        padding-right: 3%;
        padding-left: 2%;
    }
    .table_header_text {
        color: white;
        height: 40px;
    }
    .order_sammary_table {
        padding-top: 5px;
        overflow-x: auto;
        padding-left: 15PX;
        padding-right: 15PX;
        padding-bottom: 15px;
    }
    .production_text {
        padding-left: 10px;
        color: rgb(94, 94, 94);
    }
    .filter_row {
        margin-left: unset;
        padding-left: 8px;
        padding-right: 9px;
        background-color: #F8F8F8;
        border: 1px solid#DEDEDE;
        border-radius: 5px;
        padding-top: 2px;
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
        color: black;
        font-weight: 500;
    }
    .filter_btn {
        padding: 5px;
        text-align: center;
        width: 70px;
        background-color: #2dce89;
        border: none;
        cursor: pointer;
        color: white !important;
    }
    .excel_btn {
        padding: 5px;
        text-align: center;
        width: 70px;
        border: 1px solid#DEDEDE;
        /* background-color: #c9cecc; */
        cursor: pointer;
        color: rgb(0, 0, 0) !important;
    }

    .table-bottom-details2 {
        color: #020202
    }
    .header-layout {
        margin-bottom: 2rem !important;
    }
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        display: none;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }
    .select-border-style{
        border: 1px solid #b3b3b3 !important;
        border-radius: 0rem !important;
    }
    .select2-selection--single{
        background-color: #F8F8F8 !important;
    }
    .d_flex_and_align_center{
        display: flex;
        align-items: center;
    }
    .select-width-style .select2.select2-container.select2-container--default{
        width: 8rem !important;
    }
    .select-width-style-item .select2.select2-container.select2-container--default{
        width: 10rem !important;
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
    .table thead th, .table tbody td {
        padding-top: 0;
        padding-bottom: 0;
    }
    .table tbody td {
        padding-top: 7.5px;
        padding-bottom: 7.5px;
    }
    table.dataTable thead .sorting:before, table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:before, table.dataTable thead .sorting_desc_disabled:after {
        bottom: 0.6rem !important;
    }
    table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
        right: .7rem !important;
    }
    table.dataTable thead .sorting:before, table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:before, table.dataTable thead .sorting_desc_disabled:after {
    bottom: .65em;
    }
    table.dataTable thead .sorting:before,table.dataTable thead .sorting_asc:before,table.dataTable thead .sorting_desc:before,table.dataTable thead .sorting_asc_disabled:before,table.dataTable thead .sorting_desc_disabled:before {
        content: "\f0de";
        font-family: FontAwesome;
    }
    table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:after,table.dataTable thead .sorting_asc_disabled:after,table.dataTable thead .sorting_desc_disabled:after {
        content: "\f0dd";
        font-family: FontAwesome;
        right: .65rem !important;
    }

    /* Mobile View Styles */
    @media (max-width: 767.98px) {
        
        /* --- 1. Layout & Container Adjustments --- */
        /* Adjusts horizontal padding and sets a light background for the main content container on mobile */
        .content-position {
            padding-left: 12px !important;
            padding-right: 12px !important;
            background-color: #f8f9fa !important;
        }
        
        /* Adds top margin and removes horizontal padding for the scrollable table wrapper to maximize screen width usage */
        #scrollTable {
            margin-top: 10px !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        
        /* Makes the card background transparent and removes borders/shadows so it blends with the page background */
        #scrollTable .card {
            background-color: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        /* --- 2. Filter Form Container --- */
        /* Adds a white background, rounded corners, subtle shadow, and padding to the filter form to create a card-like container */
        #sales_tax_filter_form {
            background: #ffffff !important;
            border-radius: 16px !important;
            padding: 16px !important;
            box-shadow: 0 2px 6px rgba(0,0,0,0.03) !important;
            border: 1px solid #eef0f2 !important;
            margin-bottom: 16px !important;
        }
        
        /* Converts the Bootstrap row inside the filter form into a 2-column CSS Grid for better mobile alignment */
        #sales_tax_filter_form .row {
            margin: 0 !important;
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 10px !important;
        }
        
        /* Resets margins for columns that previously had auto margins (like ml-auto) to prevent grid layout breaking */
        #sales_tax_filter_form .row > div.ml-auto {
            margin-left: 0 !important;
            flex: 0 0 auto !important;
        }

        /* --- 3. Filter Form Elements: Date Inputs --- */
        /* Styles the wrapper around the date labels and inputs with a light border and rounded corners */
        .filter_row {
            margin: 0 !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 10px !important;
            padding: 8px 12px !important;
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            height: 44px !important;
        }
        
        /* Styles the "Start Date |" and "End Date |" text labels with a muted gray color */
        .date_p {
            font-size: 13px !important;
            color: #94a3b8 !important;
            font-weight: 400 !important;
            margin-bottom: 0 !important;
            white-space: nowrap !important;
        }
        
        /* Adjusts the container holding the actual date picker input */
        .date_selection {
            width: 100% !important;
            padding-left: 4px !important;
        }
        
        /* Styles the actual datepicker input field to blend seamlessly into the .filter_row wrapper */
        .summary-datepicker {
            width: 100% !important;
            border: none !important;
            background: transparent !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            outline: none !important;
            padding: 0 !important;
            height: auto !important;
        }

        /* --- 4. Filter Form Elements: Action Buttons --- */
        /* Styles the primary export buttons with a vibrant green background and rounded corners */
        #export-report, 
        #export-report-yearly {
            background-color: #4cd9ac !important;
            border: none !important;
            color: #ffffff !important;
            border-radius: 10px !important;
            height: 38px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            padding: 0 10px !important;
        }
        
        /* Styles the "Clear" button with a white background, gray border, and muted text color */
        #clear-filter {
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            color: #64748b !important;
            border-radius: 10px !important;
            height: 42px !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
        }
        
        /* Styles the "Filter" button with a dark background and white text to make it stand out as the primary action */
        #pin-filter {
            background-color: #111827 !important;
            border: none !important;
            color: #ffffff !important;
            border-radius: 10px !important;
            height: 42px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
        }

        /* Forces the first export button into the first column of the first row in the CSS Grid */
        #sales_tax_filter_form .row > div:has(#export-report) {
            grid-column: 1 / 2 !important;
            grid-row: 1 !important;
            width: 100% !important;
            margin: 0 !important;
        }
        
        /* Forces the second export (yearly) button into the second column of the first row in the CSS Grid */
        #sales_tax_filter_form .row > div:has(#export-report-yearly) {
            grid-column: 2 / 3 !important;
            grid-row: 1 !important;
            width: 100% !important;
            margin: 0 !important;
        }
        
        /* Ensures the start date input container takes full width of its grid cell */
        #sales_tax_filter_form .row > div:has(#start_date) {
            width: 100% !important;
            margin: 0 !important;
        }
        
        /* Ensures the end date input container takes full width of its grid cell */
        #sales_tax_filter_form .row > div:has(#end_date) {
            width: 100% !important;
            margin: 0 !important;
        }
        
        /* Places the "Clear" button in the first column of the third row and ensures it fills the space */
        #sales_tax_filter_form .row > div:has(#clear-filter) {
            grid-column: 1 / 2 !important;
            grid-row: 3 !important;
            width: 100% !important;
            margin: 0 !important;
            display: block !important;
        }
        
        /* Places the "Filter" button in the second column of the third row and ensures it fills the space */
        #sales_tax_filter_form .row > div:has(#pin-filter) {
            grid-column: 2 / 3 !important;
            grid-row: 3 !important;
            width: 100% !important;
            margin: 0 !important;
            display: block !important;
        }
        
        /* Resets flex alignment on the inner button wrappers so the CSS Grid can properly control their width */
        #sales_tax_filter_form .row > div:has(#pin-filter) .d_flex_and_align_center,
        #sales_tax_filter_form .row > div:has(#clear-filter) .d_flex_and_align_center {
            width: 100% !important;
            display: block !important;
        }

        /* --- 5. DataTables Wrapper & Search Input --- */
        /* Removes padding and margins from the main table container to utilize full mobile screen width */
        .order_sammary_table {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            overflow: visible !important; /* Changed to visible since we are using cards now, not horizontal scroll */
        }
        
        /* Resets default DataTables wrapper spacing */
        .dataTables_wrapper {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        /* Resets margins and padding on Bootstrap rows inside the DataTables wrapper */
        .dataTables_wrapper .row {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }
        
        /* Forces all columns inside the DataTables rows to take 100% width and stack vertically */
        .dataTables_wrapper .row > [class*="col-"],
        .dataTables_wrapper .row > div {
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }
        
        /* Styles the DataTables search box container with a white background, rounded corners, and subtle border */
        .dataTables_wrapper .dataTables_filter {
            float: none !important;
            text-align: left !important;
            margin-bottom: 16px !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            width: 100% !important;
            box-sizing: border-box !important;
            background: #ffffff !important;
            border-radius: 14px !important;
            padding: 12px 16px !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02) !important;
        }
        
        /* Styles the label wrapper for the search input to align the icon and input field horizontally */
        .dataTables_wrapper .dataTables_filter label {
            width: 100% !important;
            margin: 0 !important;
            display: flex !important;
            align-items: center !important;
            color: #94a3b8 !important;
            font-size: 14px !important;
        }
        
        /* Adds a FontAwesome magnifying glass icon before the search input field */
        .dataTables_wrapper .dataTables_filter label::before {
            content: "\f002";
            font-family: "FontAwesome";
            margin-right: 10px;
            font-size: 15px;
            color: #94a3b8;
        }
        
        /* Removes default borders and styling from the actual search input field so it blends into the container */
        .dataTables_wrapper .dataTables_filter input {
            border: none !important;
            box-shadow: none !important;
            outline: none !important;
            width: 100% !important;
            margin-left: 0 !important;
            background: transparent !important;
            font-size: 14px !important;
            color: #334155 !important;
        }
        
        /* Styles the "Show X entries" and table info text with a smaller, muted font */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_info {
            font-size: 13px !important;
            color: #64748b !important;
            margin-bottom: 12px !important;
        }

        /* --- 6. Table to Card Transformation (Mobile View) --- */
        /* Hides the standard table header (thead) because we are converting rows into individual cards */
        #organizations_with_orders thead {
            display: none !important;
        }
        
        /* Converts the table, tbody, and tr elements into block-level elements to break the standard table grid layout */
        #organizations_with_orders,
        #organizations_with_orders tbody,
        #organizations_with_orders tr {
            display: block !important;
            width: 100% !important;
            border: none !important;
            background: transparent !important;
        }
        
        /* Transforms each table row (tr) into a stylized card with a 2-column CSS Grid layout for its cells */
        #organizations_with_orders tbody tr {
            background: #ffffff !important;
            border-radius: 16px !important;
            padding: 16px !important;
            margin-bottom: 14px !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03) !important;
            border: 1px solid #e2e8f0 !important;
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            grid-template-areas:
                "title title"
                "lead_source lead_head"
                "num_orders sum_orders" !important;
            gap: 10px 12px !important;
        }
        
        /* Resets default table cell (td) styling to behave like standard block elements inside the grid */
        #organizations_with_orders tbody tr td {
            display: block !important;
            padding: 0 !important;
            border: none !important;
            text-align: left !important;
            float: none !important;
            width: auto !important;
        }
        
        /* Completely hides the first column ("NO" / Index number) as it's unnecessary on mobile cards */
        #organizations_with_orders tbody tr td:nth-child(1) {
            display: none !important;
        }

        /* Styles the Organization Name (2nd column) to span across both grid columns as the main card title */
        #organizations_with_orders tbody tr td:nth-child(2) {
            grid-area: title !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            margin-bottom: 2px !important;
            word-wrap: break-word !important;
            word-break: break-word !important;
            overflow-wrap: break-word !important;
            white-space: normal !important;
        }
        
        /* Ensures links inside the Organization Name cell inherit the bold styling and wrap correctly */
        #organizations_with_orders tbody tr td:nth-child(2) a {
            color: #0f172a !important;
            text-decoration: none !important;
            font-weight: 700 !important;
            word-wrap: break-word !important;
            word-break: break-word !important;
            overflow-wrap: break-word !important;
            white-space: normal !important;
            display: inline-block !important;
            max-width: 100% !important;
        }
        
        /* Adds a FontAwesome external link icon next to the Organization Name link */
        #organizations_with_orders tbody tr td:nth-child(2) a::after {
            content: "\f08e";
            font-family: "FontAwesome";
            font-size: 13px;
            margin-left: 10px;
            color: #006affff;
            font-weight: normal;
            display: inline-block;
            vertical-align: middle;
        }

        /* Styles the Lead Source cell (3rd column) to appear in the left column of the second grid row */
        #organizations_with_orders tbody tr td:nth-child(3) {
            grid-area: lead_source !important;
            display: block !important;
            font-size: 12px !important;
            color: #0f172a !important;
            font-weight: 600 !important;
            padding-bottom: 6px !important;
            margin-left: 8px !important;
            margin-bottom: 4px !important;
        }
        
        /* Adds a "Lead Source" label above the actual data using the CSS ::before pseudo-element */
        #organizations_with_orders tbody tr td:nth-child(3)::before {
            display: block !important;
            content: "Lead Source " !important;
            color: #94a3b8 !important;
            font-weight: 400 !important;
            font-size: 11px !important;
            margin-bottom: 2px !important;
        }

        /* Styles the Lead Head / Sales Lead cell (5th column) to appear in the right column of the second grid row */
        #organizations_with_orders tbody tr td:nth-child(5) {
            grid-area: lead_head !important;
            display: block !important;
            font-size: 12px !important;
            color: #0f172a !important;
            font-weight: 600 !important;
            padding-bottom: 6px !important;
            margin-left: 8px !important;
            margin-bottom: 4px !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important; /* Truncates long names with an ellipsis (...) */
        }
        
        /* Adds a "Lead Head" label above the actual data using the CSS ::before pseudo-element */
        #organizations_with_orders tbody tr td:nth-child(5)::before {
            display: block !important;
            content: "Lead Head " !important;
            color: #94a3b8 !important;
            font-weight: 400 !important;
            font-size: 11px !important;
            margin-bottom: 2px !important;
        }

        /* Styles the Number of Orders cell (4th column) as a highlighted gray box in the bottom left of the card */
        #organizations_with_orders tbody tr td:nth-child(4) {
            grid-area: num_orders !important;
            background: #f8fafc !important;
            border-radius: 12px !important;
            padding: 10px 12px !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            border: 1px solid #f1f5f9 !important;
            box-sizing: border-box !important;
        }
        
        /* Adds a "Number of Orders" label above the count using the CSS ::before pseudo-element */
        #organizations_with_orders tbody tr td:nth-child(4)::before {
            content: "Number of Orders" !important;
            display: block !important;
            font-size: 12px !important;
            font-weight: 400 !important;
            color: #94a3b8 !important;
            margin-bottom: 2px !important;
        }

        /* Styles the Sum of Orders cell (6th column) as a highlighted gray box in the bottom right of the card */
        #organizations_with_orders tbody tr td:nth-child(6) {
            grid-area: sum_orders !important;
            background: #f8fafc !important;
            border-radius: 12px !important;
            padding: 10px 12px !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            border: 1px solid #f1f5f9 !important;
            box-sizing: border-box !important;
        }
        
        /* Adds a "Sum of Orders ($)" label above the total using the CSS ::before pseudo-element */
        #organizations_with_orders tbody tr td:nth-child(6)::before {
            content: "Sum of Orders ($)" !important;
            display: block !important;
            font-size: 12px !important;
            font-weight: 400 !important;
            color: #94a3b8 !important;
            margin-bottom: 2px !important;
        }

        /* --- 7. DataTables Info & Pagination Styling --- */
        /* Centers the table information text (e.g., "Showing 1 to 10 of 50 entries") */
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
        
        /* Centers the pagination controls container */
        .dataTables_wrapper .dataTables_paginate {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            float: none !important;
            margin-top: 8px !important;
            margin-bottom: 20px !important;
            width: 100% !important;
        }
        
        /* Uses flexbox on the pagination list to allow wrapping of page numbers on smaller screens */
        .dataTables_wrapper .dataTables_paginate ul.pagination {
            display: flex !important;
            flex-wrap: wrap !important;
            justify-content: center !important;
            align-items: center !important;
            gap: 6px !important;
            margin: 0 !important;
            padding: 0 !important;
            list-style: none !important;
        }
        
        /* Removes default margins, padding, and borders from individual pagination list items */
        .dataTables_wrapper .dataTables_paginate .page-item,
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
        }
        
        /* Styles the pagination links/buttons with rounded corners, borders, and a subtle shadow for a modern mobile look */
        .dataTables_wrapper .dataTables_paginate .page-link,
        .dataTables_wrapper .dataTables_paginate .paginate_button a,
        .dataTables_wrapper .dataTables_paginate a.paginate_button {
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
        
        /* Highlights the currently active page number with a dark background and white text */
        .dataTables_wrapper .dataTables_paginate .page-item.active .page-link,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current a {
            background: #0f172a !important;
            color: #ffffff !important;
            border-color: #0f172a !important;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.25) !important;
        }
        
        /* Fades out and disables pointer events for disabled pagination buttons (like 'Previous' on page 1) */
        .dataTables_wrapper .dataTables_paginate .page-item.disabled .page-link,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.4 !important;
            background: #f8fafc !important;
            border-color: #f1f5f9 !important;
            cursor: not-allowed !important;
        }
    }
</style>
<div class=" mb-5 content-position">

    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Lead Source Report</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12" style="margin-top: 15px; margin-bottom: 25px; padding-bottom: 20px;" id="scrollTable">
        <div class="card" style="border: unset;">
            <form id="sales_tax_filter_form">
                @csrf
                <div class="row" style="margin: 10px;">
                    <div class="row filter_row" style="padding-bottom: 2px;margin:5px">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">Start Date |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                            <input type="text" name="start_date" class="summary-datepicker invoice-inputs" style="height: 2rem;background-color:#F8F8F8;border: 1px solid #DEDEDE;" value="{{ request()->get('start_date') }}" id="start_date">
                        </div>
                    </div>
                    <div class="row filter_row" style="padding-bottom: 2px;margin:5px">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">End Date |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                            <input type="text" name="end_date" class="summary-datepicker invoice-inputs" style="height: 2rem;background-color:#F8F8F8;border: 1px solid #DEDEDE;" value="{{ request()->get('end_date') }}" id="end_date">
                        </div>
                    </div>
                    <div class="row " style="padding-bottom: 2px;margin:5px">
                        <div class="d_flex_and_align_center" style="padding-bottom: 2px;height: 100%;">
                            <button class="date_p filter_btn" type="button" id="pin-filter" title="Filter" style="height: 2.3rem;">
                                <i class="fa fa-filter"></i>&nbsp;&nbsp;Filter
                            </button>
                        </div>
                    </div>
                    <div cclass="row " style="padding-bottom: 2px;margin:5px">
                        <div class="d_flex_and_align_center" style="padding-bottom: 2px;height: 100%;">
                            <button class="date_p excel_btn" type="button" id="clear-filter" title="Clear filter" style="height: 100%;border-radius: 5px">
                                <i class="fa fa-times"></i>&nbsp;&nbsp;Clear
                            </button>
                        </div>
                    </div>
                    <div cclass="row ml-auto" style="padding-bottom: 2px;margin:5px">
                        <div class="d_flex_and_align_center" style="padding-bottom: 2px;height: 100%;">
                            <button class="date_p excel_btn" type="button" id="export-report" title="export report" style="height: 100%;border-radius: 5px">
                                <i class="fa fa-download"></i>&nbsp;&nbsp;Export
                            </button>
                        </div>
                    </div>
                    <div cclass="row ml-auto" style="padding-bottom: 2px;margin:5px">
                        <div class="d_flex_and_align_center" style="padding-bottom: 2px;height: 100%;">
                            <button class="date_p excel_btn" type="button" id="export-report-yearly" title="export report yearly" style="height: 100%;border-radius: 5px;width: 7rem;">
                                <i class="fa fa-download"></i>&nbsp;&nbsp;Export Yearly
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="col-md-12 table-responsive order_sammary_table" style="padding-top: 0px;">
                <table class="table align-items-center" id="organizations_with_orders">

                    <thead style="background-color: rgba(50, 50, 50, 1) !important;">
                        <tr>
                            <th scope="col" class="table_header_text">NO</th>
                            <th scope="col" class="table_header_text">ORGANIZATION NAME</th>
                            <th scope="col" class="table_header_text">Lead Source</th>
                            <th scope="col" class="table_header_text"># ORDERS</th>
                            <th scope="col" class="table_header_text">Sales Lead</th>
                            <th scope="col" class="table_header_text" style="text-align: right;">Sum Of Orders ($)</th>
                        </tr>
                    </thead>
                        @foreach($organizationsWithOrders as $key => $organization)
                            @php
                                $orderInDateRange = $organization->orders();

                                $orderInDateRange = $orderInDateRange->where('active', 1)->where('organization_id', '!=', 1377)->where('order_status_id', '!=', 7)->where('order_status_id', '!=', 1)->whereNotNull('production_date')->where('production_date', '!=', '');

                                if(request()->get('start_date')){
                                    $start = \Carbon\Carbon::createFromFormat('m/d/Y', request()->get('start_date'))->format('Y-m-d');
                                    $orderInDateRange = $orderInDateRange->whereRaw(
                                        "STR_TO_DATE(production_date, '%m/%d/%Y') >= ?",
                                        [$start]
                                    );
                                }

                                if(request()->get('end_date')){
                                    $end = \Carbon\Carbon::createFromFormat('m/d/Y', request()->get('end_date'))->format('Y-m-d');
                                    $orderInDateRange = $orderInDateRange->whereRaw(
                                        "STR_TO_DATE(production_date, '%m/%d/%Y') <= ?",
                                        [$end]
                                    );
                                }
                            @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td><a target="_blank" style="color:black !important" href="{{ route('organizations.info', $organization->id) }}">{{ $organization->organization_name }}</a></td>
                                <td>{{ $organization->leadSourceDetails ? $organization->leadSourceDetails->lead_source_name : 'N/A' }}</td>
                                <td>{{ $orderInDateRange->count() }}</td>
                                <td>{{ $organization->userDetails ? $organization->userDetails->name : 'N/A' }}</td>
                                <td style="text-align: right;">{{ number_format($orderInDateRange->sum('order_total'), 2) }}</td>
                            </tr>
                        @endforeach

                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>
<script>
    $(document).ready(function() {
        $('.summary-datepicker').datepicker({
            dateFormat: 'mm/dd/yy'
        });
        $('#organizations_with_orders').DataTable({
            "paging": true,
            "pageLength": 50,
            "searching": true,
            "ordering": true
        });
        $('#pin-filter').on('click', function() {
            $('.se-pre-con').show();
            const rootURL = '{{ route('reports.organizations_with_orders') }}';
            const startDate = $('#start_date').val();
            const endDate =  $('#end_date').val();
            let queryParams = [];
            if (startDate) {
                queryParams.push('start_date=' + encodeURIComponent(startDate));
            }
            if (endDate) {
                queryParams.push('end_date=' + encodeURIComponent(endDate));
            }
            const queryString = queryParams.length ? '?' + queryParams.join('&') : '';
            const newURL = rootURL + queryString;
            window.location.href = newURL;
        });
        $('#clear-filter').on('click', function() {
            $('.se-pre-con').show();
            window.location.href = '{{ route('reports.organizations_with_orders') }}';
        });
        $('#export-report').on('click', function() {
            $('.se-pre-con').show();

            $.ajax({
                url: '{{ route('reports.organizations_with_orders_export') }}',
                method: 'GET',
                data:{
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val(),
                    _token: '{{ csrf_token() }}'
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    const url = window.URL.createObjectURL(new Blob([response]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'organizations_with_orders_report.xlsx');
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    $('.se-pre-con').hide();
                },
                error: function() {
                    $('.se-pre-con').hide();
                    alert('Failed to export report. Please try again.');
                }
            });
        });
        $('#export-report-yearly').on('click', function() {
            $('.se-pre-con').show();

            $.ajax({
                url: '{{ route('reports.organizations_with_orders_export_yearly') }}',
                method: 'GET',
                data:{
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val(),
                    _token: '{{ csrf_token() }}'
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    const url = window.URL.createObjectURL(new Blob([response]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'organizations_with_orders_report_yearly.xlsx');
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    $('.se-pre-con').hide();
                },
                error: function() {
                    $('.se-pre-con').hide();
                    alert('Failed to export report. Please try again.');
                }
            });
        });
    });
</script>

@endsection
