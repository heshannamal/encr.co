@extends('layouts.app', ['activePage' => 'org_wise_product_report', 'titlePage' => __('Organization Wise Product Report')])

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

    /* Mobile Sort dropdown — hidden on desktop, visible only on mobile */
    .mobile-sort-wrapper {
        display: none;
    }

@media (max-width: 767px) {

    /* -----------------------------------------------------
       1. PAGE / CARD LAYOUT
       ----------------------------------------------------- */

    /* Reduce page side padding on small screens */
    .content-position {
        padding-left: 12px !important;
        padding-right: 12px !important;
        background-color: transparent !important;
    }

    /* Remove desktop card styling on mobile */
    .content-position .card {
        background-color: transparent !important;
        box-shadow: none !important;
        border: none !important;
    }

    /* Remove table wrapper horizontal padding on mobile */
    .order_sammary_table {
        padding: 0 !important;
        overflow-x: visible !important;
        order: 3 !important;
    }

    /* Stack the DataTable wrapper vertically */
    #organization_wise_product_report_wrapper {
        padding: 0 !important;
        display: flex !important;
        flex-direction: column !important;
    }

    /* Stack DataTable Bootstrap rows vertically */
    #organization_wise_product_report_wrapper .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
        display: flex !important;
        flex-direction: column !important;
    }

    /* Make DataTable columns full width */
    #organization_wise_product_report_wrapper .row > div {
        padding-left: 0 !important;
        padding-right: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
        flex: none !important;
    }

    /* Keep the first DataTable controls row vertical */
    #organization_wise_product_report_wrapper .row:first-child {
        display: flex !important;
        flex-direction: column !important;
    }

    /* Put Search above the entries control */
    #organization_wise_product_report_wrapper .row:first-child > div:has(.dataTables_filter) {
        order: 1 !important;
        width: 100% !important;
        /* margin-bottom: 10px !important; */
    }

    /* Put Show Entries below Search */
    #organization_wise_product_report_wrapper .row:first-child > div:has(.dataTables_length) {
        order: 2 !important;
        width: 100% !important;
    }

    /* Fallback ordering for DataTables markup when :has()
       is not available or the generated columns differ */
    #organization_wise_product_report_wrapper .row:first-child > div:nth-child(2):has(.dataTables_filter) {
        order: 1 !important;
    }

    #organization_wise_product_report_wrapper .row:first-child > div:nth-child(1):has(.dataTables_length) {
        order: 2 !important;
    }

    /* -----------------------------------------------------
       2. FILTER CARD
       ----------------------------------------------------- */

    /* Mobile filter card container */
    #sales_tax_filter_form > .row {
        background: #ffffff !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 16px !important;
        padding: 16px !important;
        margin: 0 0 10px 0 !important;
        display: flex !important;
        flex-wrap: wrap !important;
        flex-direction: row !important;
        gap: 10px 10px !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important;
    }

    /* Date/filter labels */
    #sales_tax_filter_form .filter_row .date_p {
        display: inline-block !important;
        font-size: 13px !important;
        color: #9ca3af !important;
        font-weight: 400 !important;
        margin: 0 !important;
        padding: 0 !important;
        white-space: nowrap !important;
    }

    /* Start Date and End Date: two equal columns */
    #sales_tax_filter_form .filter_row:nth-of-type(1),
    #sales_tax_filter_form .filter_row:nth-of-type(2) {
        flex: 1 1 calc(50% - 5px) !important;
        width: calc(50% - 5px) !important;
        max-width: calc(50% - 5px) !important;
        margin: 0 !important;
        padding: 0 10px 0 12px !important;
        background: #f9fafb !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 10px !important;
        height: 42px !important;
        display: flex !important;
        align-items: center !important;
        position: relative !important;
        box-sizing: border-box !important;
    }

    /* Keep date labels from shrinking */
    #sales_tax_filter_form .filter_row:nth-of-type(1) .date_p,
    #sales_tax_filter_form .filter_row:nth-of-type(2) .date_p {
        position: relative !important;
        font-size: 13px !important;
        color: #9ca3af !important;
        flex-shrink: 0 !important;
    }

    /* Date input wrapper fills remaining horizontal space */
    #sales_tax_filter_form .filter_row:nth-of-type(1) .paymen_type_div,
    #sales_tax_filter_form .filter_row:nth-of-type(2) .paymen_type_div {
        flex: 1 !important;
        padding: 0 !important;
        margin: 0 !important;
        height: 100% !important;
        display: flex !important;
        align-items: center !important;
    }

    /* Date input fills its mobile date card */
    #sales_tax_filter_form .filter_row:nth-of-type(1) input.summary-datepicker,
    #sales_tax_filter_form .filter_row:nth-of-type(2) input.summary-datepicker {
        width: 100% !important;
        height: 100% !important;
        background: transparent !important;
        border: none !important;
        padding: 0 18px 0 4px !important;
        font-size: 13px !important;
        color: #374151 !important;
        outline: none !important;
        box-shadow: none !important;
    }

    /* Chevron displayed inside each date field */
    #sales_tax_filter_form .filter_row:nth-of-type(1)::after,
    #sales_tax_filter_form .filter_row:nth-of-type(2)::after {
        content: "\f107";
        font-family: FontAwesome;
        font-size: 13px;
        color: #6b7280;
        position: absolute;
        right: 10px;
        pointer-events: none;
    }

    /* Organization filter: full width below dates */
    #sales_tax_filter_form .filter_row:nth-of-type(3) {
        flex: 1 1 100% !important;
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 12px !important;
        background: #f9fafb !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 10px !important;
        height: 42px !important;
        display: flex !important;
        align-items: center !important;
        position: relative !important;
        box-sizing: border-box !important;
    }

    /* Organization label */
    #sales_tax_filter_form .filter_row:nth-of-type(3) .date_p {
        color: #9ca3af !important;
        font-size: 13px !important;
        margin-right: 8px !important;
        flex-shrink: 0 !important;
    }

    /* Organization Select2 wrapper fills remaining space */
    #sales_tax_filter_form .filter_row:nth-of-type(3) .select-width {
        flex: 1 !important;
        width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Organization Select2 container fills the row */
    #sales_tax_filter_form .filter_row:nth-of-type(3) .select2-container {
        width: 100% !important;
    }

    /* Remove Select2 border inside the custom organization card */
    #sales_tax_filter_form .filter_row:nth-of-type(3) .select2-selection--single {
        background: transparent !important;
        border: none !important;
        height: 40px !important;
        display: flex !important;
        align-items: center !important;
    }

    /* Organization selected value */
    #sales_tax_filter_form .filter_row:nth-of-type(3) .select2-selection__rendered {
        color: #374151 !important;
        font-size: 13px !important;
        padding-left: 0 !important;
        line-height: 40px !important;
    }

    /* Organization Select2 arrow alignment */
    #sales_tax_filter_form .filter_row:nth-of-type(3) .select2-selection__arrow {
        height: 40px !important;
        right: 4px !important;
    }

    /* Clear and Filter parent containers - each 50% width */
    #sales_tax_filter_form > .row > div:has(#clear-filter),
    #sales_tax_filter_form > .row > div:has(#pin-filter) {
        flex: 1 1 calc(50% - 5px) !important;
        width: calc(50% - 5px) !important;
        max-width: calc(50% - 5px) !important;
        margin: 4px 0 0 0 !important;
        padding: 0 !important;
    }

    /* Order: Clear first (left), Filter second (right) */
    #sales_tax_filter_form > .row > div:has(#clear-filter) {
        order: 1 !important;
    }
    #sales_tax_filter_form > .row > div:has(#pin-filter) {
        order: 2 !important;
    }

    /* Export button - full width on its own row */
    #sales_tax_filter_form > .row > div:has(#export-report) {
        flex: 1 1 100% !important;
        width: 100% !important;
        max-width: 100% !important;
        margin: 8px 0 0 0 !important;
        padding: 0 !important;
        order: 3 !important;
    }

    /* FORCE wrapper divs to be full width of their 50% column */
    #sales_tax_filter_form > .row > div:has(#clear-filter) > div,
    #sales_tax_filter_form > .row > div:has(#pin-filter) > div {
        width: 100% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    /* Clear Button - White with border, full width of its half */
    #clear-filter {
        width: 100% !important;
        height: 44px !important;
        background: #ffffff !important;
        border: 1px solid #d1d5db !important;
        border-radius: 10px !important;
        color: #374151 !important;
        /* font-size: 14px !important; */
        font-weight: 500 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        box-shadow: none !important;
        cursor: pointer !important;
        padding: 0 16px !important;
        flex: 1 !important;
    }

    #clear-filter:hover {
        background: #f9fafb !important;
    }

    /* #clear-filter i {
        font-size: 14px !important;
    } */

    /* Filter Button - Black, full width of its half */
    #pin-filter {
        width: 100% !important;
        height: 44px !important;
        background: #1a1a1a !important;
        border: none !important;
        border-radius: 10px !important;
        color: #ffffff !important;
        /* font-size: 14px !important; */
        font-weight: 600 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        box-shadow: none !important;
        cursor: pointer !important;
        padding: 0 16px !important;
        flex: 1 !important;
    }

    #pin-filter:hover {
        background: #2d2d2d !important;
    }

    /* #pin-filter i {
        font-size: 14px !important;
    } */

    /* Export Button - Green, full width */
    #export-report {
        width: 100% !important;
        height: 44px !important;
        background: #2dce89 !important;
        border: none !important;
        border-radius: 10px !important;
        color: #ffffff !important;
        /* font-size: 14px !important; */
        font-weight: 600 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        box-shadow: none !important;
        cursor: pointer !important;
        padding: 0 16px !important;
        flex: 1 !important;
    }

    #export-report:hover {
        background: #26b77a !important;
    }

    /* #export-report i {
        font-size: 14px !important;
    } */

    /* -----------------------------------------------------
       3. DATATABLE SEARCH - MODERN SEARCH BAR CARD
       ----------------------------------------------------- */

    /* Mobile search box - separate white card */
    #organization_wise_product_report_wrapper .dataTables_filter {
        width: 100% !important;
        text-align: left !important;
        float: none !important;
        margin: 0 0 10px 0 !important;
        background-color: #ffffff !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 12px !important;
        padding: 12px 16px !important;
        box-sizing: border-box !important;
        display: block !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04) !important;
    }

    /* Search label fills the search box */
    #organization_wise_product_report_wrapper .dataTables_filter label {
        width: 100% !important;
        display: flex !important;
        align-items: center !important;
        font-size: 0 !important;
        position: relative !important;
        margin-bottom: 0 !important;
        padding: 0 !important;
    }

    /* Search icon inside input */
    #organization_wise_product_report_wrapper .dataTables_filter label::before {
        content: "\f002";
        font-family: FontAwesome;
        color: #6b7280;
        font-size: 16px;
        position: absolute;
        left: 8px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        z-index: 1;
    }

    /* Search input field */
    #organization_wise_product_report_wrapper .dataTables_filter input {
        width: 100% !important;
        margin-left: 0 !important;
        height: 44px !important;
        background: #f8f9fa !important;
        border: 1px solid #e9ecef !important;
        border-radius: 10px !important;
        /* font-size: 16px !important; */
        color: #374151 !important;
        box-shadow: none !important;
        outline: none !important;
        padding: 0 16px 0 40px !important;
        box-sizing: border-box !important;
    }

    /* Search input placeholder styling */
    #organization_wise_product_report_wrapper .dataTables_filter input::placeholder {
        color: #9ca3af !important;
        /* font-size: 14px !important; */
        font-weight: 400 !important;
    }

    /* Fake placeholder text for mobile search */
    #organization_wise_product_report_wrapper .dataTables_filter label::after {
        content: "Search by product name or product id" !important;
        position: absolute !important;
        left: 40px !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        color: #9ca3af !important;
        font-size: 14px !important;
        font-weight: 400 !important;
        pointer-events: none !important;
        z-index: 1 !important;
    }

    /* Hide fake placeholder when input is clicked/focused */
    #organization_wise_product_report_wrapper .dataTables_filter:focus-within label::after {
        display: none !important;
    }

    /* Remove default search input clear button */
    #organization_wise_product_report_wrapper .dataTables_filter input::-webkit-search-cancel-button {
        -webkit-appearance: none;
        appearance: none;
    }

    /* -----------------------------------------------------
       4. DATATABLE CONTROLS / SORTING
       ----------------------------------------------------- */

    /* Show Entries control row */
    #organization_wise_product_report_wrapper .row:first-child > div:has(.dataTables_length) {
        display: flex !important;
        align-items: center !important;
        width: 100% !important;
        margin-bottom: 15px !important;
    }

    /* DataTable length wrapper */
    #organization_wise_product_report_wrapper .dataTables_length {
        float: none !important;
        display: inline-flex !important;
        align-items: center !important;
        font-size: 13px !important;
        color: #6c757d !important;
        margin-bottom: 0 !important;
        width: auto !important;
    }

    /* DataTable length label */
    #organization_wise_product_report_wrapper .dataTables_length label {
        display: inline-flex !important;
        align-items: center !important;
        margin-bottom: 0 !important;
        gap: 2px !important;
        color: #6c757d !important;
        font-size: 13px !important;
    }

    /* Entries dropdown */
    #organization_wise_product_report_wrapper .dataTables_length select {
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        padding: 4px 24px 4px 10px !important;
        background-color: #fff !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        color: #1a202c !important;
        height: 32px !important;
    }

    /* Mobile Sort dropdown container */
    .mobile-sort-wrapper {
        display: inline-flex !important;
        align-items: center !important;
        margin-left: auto !important;
        gap: 4px !important;
        font-size: 13px !important;
        color: #6c757d !important;
    }

    /* Mobile Sort dropdown */
    .mobile-sort-wrapper select {
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        background-color: #fff !important;
        font-size: 13px !important;
        color: #1a202c !important;
        height: 32px !important;
        cursor: pointer !important;
    }

    /* -----------------------------------------------------
       5. PRODUCT TABLE -> MOBILE CARDS
       ----------------------------------------------------- */

    /* Convert the table into a vertical card list */
    #organization_wise_product_report,
    #organization_wise_product_report tbody,
    #organization_wise_product_report tr,
    #organization_wise_product_report td {
        display: block !important;
        width: 100% !important;
    }

    /* Hide the desktop table header */
    #organization_wise_product_report thead {
        display: none !important;
    }

    /* Each product row becomes a mobile card */
    #organization_wise_product_report tbody tr {
        background: #ffffff !important;
        border: 1px solid #f1f3f5 !important;
        border-radius: 14px !important;
        margin-bottom: 12px !important;
        padding: 14px 16px !important;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04) !important;
        box-sizing: border-box !important;
        display: flex !important;
        flex-wrap: wrap !important;
    }

    /* Product number: top-left small label */
    #organization_wise_product_report tbody tr td:nth-child(1) {
        order: 1 !important;
        width: 100% !important;
        padding: 0 0 2px 0 !important;
        border: none !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        color: #6c757d !important;
    }

    /* Product name: bold full-width title */
    #organization_wise_product_report tbody tr td:nth-child(2) {
        order: 2 !important;
        width: 100% !important;
        padding: 0 0 10px 0 !important;
        border: none !important;
        font-size: 14.5px !important;
        font-weight: 700 !important;
        color: #212529 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }

    /* Quantity: right half of the summary row */
    #organization_wise_product_report tbody tr td:nth-child(3) {
        order: 4 !important;
        width: 50% !important;
        padding: 0 !important;
        border: none !important;
        text-align: right !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        color: #212529 !important;
        line-height: 1.4 !important;
    }

    /* Quantity label */
    #organization_wise_product_report tbody tr td:nth-child(3)::before {
        content: "Ordered Qty\A";
        white-space: pre-wrap;
        display: block;
        font-size: 10px;
        font-weight: 400;
        color: #a0aec0;
        margin-bottom: 2px;
    }

    /* Default price: left half of the summary row */
    #organization_wise_product_report tbody tr td:nth-child(4) {
        order: 3 !important;
        width: 50% !important;
        padding: 0 !important;
        border: none !important;
        text-align: left !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        color: #212529 !important;
        line-height: 1.4 !important;
    }

    /* Default price label */
    #organization_wise_product_report tbody tr td:nth-child(4)::before {
        content: "Default Price\A";
        white-space: pre-wrap;
        display: block;
        font-size: 10px;
        font-weight: 400;
        color: #a0aec0;
        margin-bottom: 2px;
    }

    /* Keep the old dollar pseudo-element disabled */
    #organization_wise_product_report tbody tr td:nth-child(4)::after {
        content: "$";
        position: absolute;
        left: 0;
        display: none;
    }

    /* Order Numbers are intentionally hidden in the mobile card */
    #organization_wise_product_report tbody tr td:nth-child(5) {
        /* order: 5 !important;
        width: 100% !important;
        padding: 10px 0 0 0 !important;
        border: none !important;
        font-size: 11.5px !important;
        color: #212529 !important;
        display: flex !important;
        flex-wrap: wrap !important;
        gap: 6px !important;
        align-items: center !important; */
        display: none !important;
    }

    /* Keep order-number styles available if the column is shown */
    /* #organization_wise_product_report tbody tr td:nth-child(5)::before {
        content: "Order Numbers";
        display: block;
        width: 100%;
        font-size: 10px;
        font-weight: 400;
        color: #a0aec0;
        margin-bottom: 4px;
    } */

    /* Order number link/chip styling */
    /* #organization_wise_product_report tbody tr td:nth-child(5) a {
        display: inline-block !important;
        background-color: #f1f3f5 !important;
        color: #495057 !important;
        border-radius: 6px !important;
        padding: 3px 8px !important;
        font-size: 11.5px !important;
        font-weight: 500 !important;
        text-decoration: none !important;
    } */

    /* -----------------------------------------------------
       6. DATATABLE FOOTER / PAGINATION
       ----------------------------------------------------- */

    /* Table result count */
    #organization_wise_product_report_wrapper .dataTables_info {
        float: left !important;
        padding-top: 8px !important;
        font-size: 12px !important;
        color: #adb5bd !important;
    }

    /* Pagination container */
    #organization_wise_product_report_wrapper .dataTables_paginate {
        float: right !important;
        margin-top: 0 !important;
    }

    /* Remove default pagination margin */
    #organization_wise_product_report_wrapper .pagination {
        margin: 0 !important;
    }

    /* Mobile pagination buttons */
    #organization_wise_product_report_wrapper .page-item .page-link {
        border-radius: 6px !important;
        margin: 0 2px !important;
        border: 1px solid #e9ecef !important;
        color: #495057 !important;
        padding: 4px 8px !important;
        font-size: 12px !important;
    }

    /* Active mobile pagination button */
    #organization_wise_product_report_wrapper .page-item.active .page-link {
        background-color: #212529 !important;
        border-color: #212529 !important;
        color: #ffffff !important;
    }
}
</style>
<div class=" mb-5 content-position">

    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Organization Wise Product Report</span>
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
                    <div class="row filter_row" style="padding-bottom: 2px;margin:5px">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">Organization |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center select-width" style="padding-left: 7px;">
                            <select name="organization_id" id="organization_id" class="select2">
                                <option value="all">All Organizations</option>
                                @foreach($organizations as $organization)
                                    <option value="{{ $organization->id }}" {{ request()->get('organization_id') == $organization->id ? 'selected' : '' }}>{{ $organization->organization_name }}</option>
                                @endforeach
                            </select>
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
                </div>
            </form>

            <div class="col-md-12 table-responsive order_sammary_table" style="padding-top: 0px;">
                <table class="table align-items-center" id="organization_wise_product_report">

                    <thead style="background-color: rgba(50, 50, 50, 1) !important;">
                        <tr>
                            <th scope="col" class="table_header_text text-center">Product No</th>
                            <th scope="col" class="table_header_text text-center">Product Name</th>
                            <th scope="col" class="table_header_text text-center">Quantity Ordered</th>
                            <th scope="col" class="table_header_text text-center">Default Price</th>
                            <th scope="col" class="table_header_text text-left">Order Numbers
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productList as $productNo => $productData)
                            <tr>
                                <td>{{ $productData['product']->sub_product_no ?? 'N/A' }}</td>
                                <td>{{ $productData['product']->product_name ?? 'N/A' }}</td>
                                <td class="text-center">{{ $productData['qty'] }}</td>
                                <td class="text-right">{{ number_format($productData['product']->default_price ?? 0, 2) }}</td>
                                <td class="text-left">
                                    @foreach ($productData['orders'] as $orderId)
                                        <a href="{{ url('/order_details/edit/' . $orderId . '/order?active_tab=order') }}" target="_blank" style="text-decoration: underline;color: #2dce89;">#{{ $orderId }}</a>{{ !$loop->last ? ',' : '' }}
                                    @endforeach
                                </td>
                            </tr>

                        @endforeach
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
        $('#organization_wise_product_report').DataTable({
            "paging": true,
            "pageLength": 50,
            "searching": true,
            "ordering": true,
            "info": true,
             "lengthChange": false,
             "language": {
                "search": "Search:",
                "paginate": {
                    "previous": "<",
                    "next": ">"
                }
            },
             "columnDefs": [
                { "orderable": false, "targets": [4] }
            ]
        });
        $('#organization_id').select2();
        $('#pin-filter').on('click', function() {
            $('.se-pre-con').show();
            const rootURL = '{{ route('reports.org_wise_product_report') }}';
            const startDate = $('#start_date').val();
            const endDate =  $('#end_date').val();
            const organizationId = $('#organization_id').val();
            let queryParams = [];
            if (startDate) {
                queryParams.push('start_date=' + encodeURIComponent(startDate));
            }
            if (endDate) {
                queryParams.push('end_date=' + encodeURIComponent(endDate));
            }
            if (organizationId && organizationId !== 'all') {
                queryParams.push('organization_id=' + encodeURIComponent(organizationId));
            }
            const queryString = queryParams.length ? '?' + queryParams.join('&') : '';
            const newURL = rootURL + queryString;
            window.location.href = newURL;
        });
        $('#clear-filter').on('click', function() {
            $('.se-pre-con').show();
            window.location.href = '{{ route('reports.org_wise_product_report') }}';
        });
        $('#export-report').on('click', function() {
            $('.se-pre-con').show();

            $.ajax({
                url: '{{ route('reports.org_wise_product_report_export') }}',
                method: 'GET',
                data:{
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val(),
                    organization_id: $('#organization_id').val(),
                    _token: '{{ csrf_token() }}'
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    const url = window.URL.createObjectURL(new Blob([response]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'org_wise_product_report.xlsx');
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
