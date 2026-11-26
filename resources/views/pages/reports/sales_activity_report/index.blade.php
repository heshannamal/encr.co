@extends('layouts.app', ['activePage' => 'sales_activity_report', 'titlePage' => __('Sales Activity Report')])

@section('content')
<style>
    body, p {
        font-weight: 400; /* Regular weight */
    }

    .bg-box{
        margin-bottom: unset !important;
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
    .btn-outline-danger {
        color: #ffffffc2;
    }
    .btn-group-toggle .btn-sm,
    .btn-group-toggle .btn-sm {
        font-size: 12px;
    }
    .count-text-color {
        color: #787878;
    }
    .header-height {
        height: 50px;
    }
    .filter-text {
        color: #787878;
    }
    .add-btn-padding {
        padding-right: unset;
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
        right: 52px;
    }
    .btn-top {
        position: relative;
        top: 11px;
    }
    .bottom-content {
        position: relative;
        top: 16px;
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
        background-color: rgba(50, 50, 50, 1);
        color: white;
        height: 40px;
        font-size: .7rem;
    }
    .new-style-table table tr{
        background-color: white;
        color: rgba(22, 22, 23, 1) ;
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
        padding: .399rem;
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
    #activity_table_filter {
        display: none;
    }
    .dropdown-menu-custom {
        left: 45% !important;
        transform: translateX(-50%);
        width: 230% !important;
        max-height: 60vh;
        border-radius: 0rem;
    }
    .custom-tabs {
    display: flex;
    }

    .custom-tab-bar {
        flex: 0 0 auto;
        min-height: 60vh;
        border: none;
        background-color: rgb(247, 247, 247);
    }

    .custom-tab {
        display: block;
        padding: 0.8rem 3rem 0.8rem 0.8rem;
        text-decoration: none;
        color: #333;
        border: none;
        font-size: .8rem;
    }

    .custom-tab:hover {
        background-color: #0f101029;
        color: black;
    }
    .custom-tab.active{
        background-color: #d7eddd;
        color: #4c91e9;
    }

    .custom-tab-content {
        flex: 1 1 auto;
    }

    .custom-tab-pane {
        display: none;
    }

    .custom-tab-pane.active {
        display: block;
    }
    .heading-link:hover {
        text-decoration: underline;
    }
    .highlight {
        background-color: yellow !important;
    }
    .list-group-item{
        min-height: 3.5rem;
    }
    .bulk_table .select2-container{
        width: 100%;
    }
    .bulk_table .select2-container{
        width: 100% !important;
        border: 1px solid #b3b3b3 !important;
        border-radius: 0rem !important;
    }
    .btn-grey-text{
        outline: unset !important;
        /* width: 100%; */
        padding: 8px;
        color: #B3B3B3;
        border: none;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        background-color: transparent;
        border: 1px solid #b3b3b3;
    }
    .multiselect {
        background-color: unset !important;
        color: #8898aa !important;
        font-size: 13px;
        font-weight: unset !important;
        /* border: unset !important; */
        box-shadow: unset !important;
        padding: .425rem 0.5rem !important;
        border: none !important;
        /* min-width: 200px; */
        /* border-radius: 0px; */
    }
    /* .filter_row {
        margin-left: unset;
        padding-left: 8px;
        padding-right: 9px;
        background-color: #F8F8F8;
        border: 1px solid #DEDEDE;
        background-color: transparent;
    border: 1px solid #b3b3b3;
        padding-top: 2px;
    } */
     .dropdown-menu {
        min-width: 16rem;
    }
    .multiselect-container>li>a>label {
        width: 100%;
        color: #797979 !important;
        padding: 3px 20px 3px 20px !important;
    }
    .dropdown-menu>li>a:hover{
        background-color: #ececec;
        background-image: unset;
    }
    .filter_row {
        margin-left: unset;
        padding-left: 8px;
        padding-right: 9px;
        background-color: #F8F8F8;
        border: 1px solid #DEDEDE;
        border-radius: 0px;
        padding-top: 2px;
    }
    .select2-container--default .select2-selection--single {
        background-color: transparent;
    }

/* Mobile View CSS */
@media (max-width: 767.98px) {

    /* Remove default margin/padding from outer scroll container */
    #scrollTable {
        margin-top: 0 !important;
        margin-bottom: 0 !important;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        position: relative !important;
    }

    /* Cancel Bootstrap's mb-5 (3rem bottom margin) on this page */
    .content-position.mb-5 {
        margin-bottom: 0 !important;
    }

    /* Make inner card wrapper invisible so only our custom cards show */
    #scrollTable .card {
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }

    /* Reset row spacing inside the card */
    .card > .row {
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        margin-top: 10px !important;
        position: relative !important;
    }

    /* Pin Export button to top-right corner, floating over the title area */
    .ml-auto.col-md-4.mt-3.mb-3.text-right {
        display: block !important;
        position: absolute !important;
        top: 10px !important;
        right: 10px !important;
        width: auto !important;
        margin: 0 !important;
        padding: 0 !important;
        z-index: 20 !important;
    }

    /* Let the Export button's inner row/col shrink to fit content */
    .ml-auto.col-md-4.mt-3.mb-3.text-right .row,
    .ml-auto.col-md-4.mt-3.mb-3.text-right .col-4 {
        width: auto !important;
        padding: 0 !important;
        margin: 0 !important;
        max-width: none !important;
        flex: none !important;
    }

    /* Style the Export button as a green rounded pill */
    #export_csv {
        background-color: #36D7B7 !important;
        border: none !important;
        color: #ffffff !important;
        border-radius: 10px !important;
        height: 40px !important;
        padding: 0 14px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        box-shadow: 0 2px 4px rgba(54, 215, 183, 0.25) !important;
        white-space: nowrap !important;
        text-transform: none !important;
    }

    /* Add a download icon before the Export button text */
    #export_csv::before {
        content: "\f019";
        font-family: FontAwesome;
        font-size: 13px;
        color: #ffffff;
        margin-right: 6px;
    }

    /* Turn the filter row into a rounded white card with a 2-col grid */
    .col-md-8.mt-3.d-flex.flex-wrap {
        width: 100% !important;
        margin-top: 58px !important;
        margin-left: 10px !important;
        margin-bottom: 16px !important;
        margin-right: 10px !important;
        padding: 16px !important;
        background: #ffffff !important;
        border-radius: 16px !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04) !important;
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        gap: 12px !important;
        box-sizing: border-box !important;
    }

    /* Each filter item fills its grid cell */
    .col-md-8.mt-3.d-flex.flex-wrap .filter_row {
        margin: 0 !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }

    /* Filter button spans full width as a solid black rounded button */
    .col-md-8.mt-3.d-flex.flex-wrap .filter_row:has(#filterButton) {
        grid-column: 1 / -1 !important;
        background: #18181b !important;
        border: none !important;
        border-radius: 10px !important;
        height: 44px !important;
        padding: 0 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    /* Center the Filter button's icon and text */
    #filterButton {
        width: 100% !important;
        height: 100% !important;
        background: transparent !important;
        border: none !important;
        color: #ffffff !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
    }

    /* Add a filter icon before the Filter button text */
    #filterButton::before {
        content: "\f0b0";
        font-family: FontAwesome;
        font-size: 14px;
        color: #ffffff;
    }

    /* Style the Users and Task select boxes as light grey rounded pills */
    .col-md-8.mt-3.d-flex.flex-wrap .filter_row:has(#users_array),
    .col-md-8.mt-3.d-flex.flex-wrap .filter_row:has(#task) {
        background: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 10px !important;
        height: 44px !important;
        padding: 0 8px !important;
        display: flex !important;
        align-items: center !important;
    }

    /* Make the Users multiselect fill its container */
    .multiselect-native-select,
    .multiselect-native-select .btn-group,
    .multiselect-native-select .btn-group > button.multiselect,
    .filter_row .select2-container {
        width: 100% !important;
    }

    /* Select2 dropdown wrapper is appended to body - don't stretch it */
    body > .select2-container {
        width: auto !important;
    }
    /* Users multiselect dropdown: open downward, fit the screen, scroll inside */
    .multiselect-native-select .btn-group {
        position: relative !important;
    }

    .multiselect-native-select .multiselect-container.dropdown-menu {
        position: absolute !important;
        top: 100% !important;
        bottom: auto !important;
        left: 0 !important;
        right: auto !important;
        transform: none !important;
        width: max-content !important;
        min-width: 100% !important;
        max-width: calc(100vw - 60px) !important;
        max-height: 45vh !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        margin-top: 4px !important;
        /* z-index: 1050 !important; */
    }

    .multiselect-container > li > a > label {
        font-size: 13px !important;
        padding: 6px 12px !important;
        white-space: nowrap !important;
    }

    /* Style the Users multiselect button text */
    .multiselect-native-select .btn-group > button.multiselect {
        text-align: left !important;
        color: #334155 !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 0 4px !important;
    }

    /* Strip Select2 (Task dropdown) default styling to blend into its pill */
    .select2-container--default .select2-selection--single {
        border: none !important;
        background: transparent !important;
        height: auto !important;
        display: flex !important;
        align-items: center !important;
    }

    /* Style the Select2 selected value text */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #334155 !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        padding-left: 4px !important;
        line-height: normal !important;
    }

    /* Position the Select2 dropdown arrow */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100% !important;
        right: 4px !important;
    }

    /* Container for the date-range pill row (Today, Tomorrow, etc.) */
    .col-md-12.mt-2:has(.activity-filter) {
        margin-top: 4px !important;
        margin-bottom: 16px !important;
        padding: 0 !important;
    }

    /* Make the pills scroll horizontally and hide the scrollbar */
    .col-md-12.mt-2:has(.activity-filter) .row.btn-group-toggle {
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        gap: 8px !important;
        margin: 0 !important;
        padding-bottom: 4px !important;
        -webkit-overflow-scrolling: touch;
    }

    /* Hide the scrollbar on WebKit browsers */
    .col-md-12.mt-2:has(.activity-filter) .row.btn-group-toggle::-webkit-scrollbar {
        display: none;
    }

    /* Style each unselected filter pill */
    .col-md-12.mt-2:has(.activity-filter) label.btn {
        flex: 0 0 auto !important;
        border-radius: 20px !important;
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        padding: 8px 18px !important;
        margin: 0 !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03) !important;
    }

    /* Style the selected/active filter pill */
    .col-md-12.mt-2:has(.activity-filter) label.btn.active {
        background: #18181b !important;
        border-color: #18181b !important;
    }

    /* Style the text inside an unselected pill */
    .col-md-12.mt-2:has(.activity-filter) label.btn .filter-text {
        color: #475569 !important;
        font-size: 13px !important;
        font-weight: 500 !important;
    }

    /* Style the text inside the selected/active pill */
    .col-md-12.mt-2:has(.activity-filter) label.btn.active .filter-text {
        color: #ffffff !important;
        font-weight: 600 !important;
    }

    /* Add left/right breathing room around Show entries, table, pagination.
       NOTE: only ONE rule for .new-style-table exists — do not duplicate it. */
    .new-style-table {
        margin-top: 10px !important;
        padding-left: 10px !important;
        padding-right: 10px !important;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }

    /* Allow table content to overflow visually instead of being clipped */
    .new-style-table .table-responsive {
        overflow: visible !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    /* Prevent the DataTables wrapper from exceeding the viewport width */
    #activity_table_wrapper {
        display: flex !important;
        flex-direction: column !important;
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: hidden !important;
    }

    /* Remove default row margins inside the wrapper */
    #activity_table_wrapper .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }

    /* Equal left/right padding on every child row-div so everything lines up */
    #activity_table_wrapper .row > div {
        padding-left: 10px !important;
        padding-right: 10px !important;
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
    }

    /* Style the "Show entries" dropdown control */
    #activity_table_wrapper .dataTables_length {
        display: flex !important;
        align-items: center !important;
        font-size: 13px !important;
        color: #64748b !important;
        margin-bottom: 14px !important;
    }

    /* Align the label and select inside "Show entries" */
    #activity_table_wrapper .dataTables_length label {
        display: flex !important;
        align-items: center !important;
        gap: 6px !important;
        margin-bottom: 0 !important;
        margin-left: 10px !important;
    }

    /* Style the entries-per-page select box */
    #activity_table_wrapper .dataTables_length select {
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        padding: 2px 8px !important;
        background: #ffffff !important;
        height: 34px !important;
        font-size: 13px !important;
    }

    /* Hide the desktop table header entirely on mobile */
    #activity_table thead {
        display: none !important;
    }

    /* Force table/tbody/tr to behave like block elements for card layout */
    #activity_table,
    #activity_table tbody,
    #activity_table tr {
        display: block !important;
        width: 100% !important;
        border: none !important;
        background: transparent !important;
    }

    /* Turn each data row into a white rounded card using grid areas */
    #activity_table tbody tr {
        background: #ffffff !important;
        border: 1px solid #f1f5f9 !important;
        border-radius: 16px !important;
        margin-bottom: 14px !important;
        padding: 16px !important;
        box-shadow: 0 2px 6px rgba(0,0,0,0.03) !important;
        box-sizing: border-box !important;
        display: grid !important;
        grid-template-columns: 1fr auto !important;
        grid-template-areas:
            "org date"
            "subj subj"
            "creator notes" !important;
        gap: 6px 12px !important;
    }

    /* Reset all table cells to plain block elements before grid-area assignment */
    #activity_table tbody tr td {
        display: block !important;
        padding: 0 !important;
        border: none !important;
        text-align: left !important;
        white-space: normal !important;
        width: auto !important;
    }

    /* Column 4 = Organization Name → big bold title, top-left */
    #activity_table tbody tr td:nth-child(4) {
        grid-area: org !important;
        font-size: 15px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        line-height: 1.3 !important;
    }

    /* Column 1 = Start Date → small badge pill, top-right */
    #activity_table tbody tr td:nth-child(1) {
        grid-area: date !important;
        justify-self: end !important;
        align-self: start !important;
        background: #f1f5f9 !important;
        color: #475569 !important;
        font-size: 11px !important;
        font-weight: 600 !important;
        padding: 3px 8px !important;
        border-radius: 6px !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 4px !important;
        white-space: nowrap !important;
    }

    /* Add a calendar icon before the date badge */
    #activity_table tbody tr td:nth-child(1)::before {
        content: "\f073";
        font-family: FontAwesome;
        font-size: 10px;
        color: #64748b;
    }

    /* Column 3 = Subject/Description → full-width line under org/date */
    #activity_table tbody tr td:nth-child(3) {
        grid-area: subj !important;
        font-size: 13px !important;
        color: #475569 !important;
        font-weight: 400 !important;
        margin-top: 2px !important;
        margin-bottom: 6px !important;
        line-height: 1.4 !important;
    }

    /* Column 8 = Created By / User → bottom-left */
    #activity_table tbody tr td:nth-child(8) {
        grid-area: creator !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #334155 !important;
        display: flex !important;
        align-items: center !important;
    }

    /* Column 5 = Notes → bottom-right, truncated with expand affordance */
    #activity_table tbody tr td:nth-child(5) {
        grid-area: notes !important;
        justify-self: end !important;
        align-self: center !important;
        font-size: 13px !important;
        color: #64748b !important;
        font-weight: 500 !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 4px !important;
        cursor: pointer !important;
    }

    /* Add a chevron-down icon after the Notes text */
    /* #activity_table tbody tr td:nth-child(5)::after {
        content: "\f107";
        font-family: FontAwesome;
        font-size: 12px;
        color: #64748b;
    } */

    /* Columns 2, 6, 7, 9 (Assign To, Order No, Contact Person, Priority) are hidden on mobile */
    #activity_table tbody tr td:nth-child(2),
    #activity_table tbody tr td:nth-child(6),
    #activity_table tbody tr td:nth-child(7),
    #activity_table tbody tr td:nth-child(9) {
        display: none !important;
    }

    /* Empty-state row skips the grid card layout — just a plain block */
    #activity_table tbody tr:has(td.dataTables_empty) {
        display: block !important;
        grid-template-columns: unset !important;
        grid-template-areas: unset !important;
        padding: 0 !important;
        box-shadow: none !important;
        border: none !important;
        background: transparent !important;
    }

    /* White rounded "No data available" box, matches spacing whether data exists or not */
    #activity_table tbody tr td.dataTables_empty {
        display: block !important;
        box-sizing: border-box !important;
        width: 100% !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        text-align: center !important;
        color: #94a3b8 !important;
        padding: 30px 15px !important;
        font-size: 14px !important;
        background: #ffffff !important;
        border-radius: 14px !important;
        border: 1px solid #e2e8f0 !important;
    }

    /* Style the "Showing X to Y of Z entries" text */
    #activity_table_wrapper .dataTables_info {
        font-size: 13px !important;
        color: #94a3b8 !important;
        padding: 12px 0 6px 0 !important;
        float: none !important;
        text-align: left !important;
    }

    /* Align pagination controls to the right */
    #activity_table_wrapper .dataTables_paginate {
        float: none !important;
        display: flex !important;
        justify-content: flex-end !important;
        margin-top: 8px !important;
    }

    /* Lay out pagination buttons in a row with spacing */
    #activity_table_wrapper .dataTables_paginate .pagination {
        display: flex !important;
        gap: 6px !important;
        margin: 0 !important;
    }

    /* Style each pagination button */
    #activity_table_wrapper .dataTables_paginate .page-item .page-link {
        border-radius: 8px !important;
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        color: #334155 !important;
        min-width: 32px !important;
        height: 32px !important;
        padding: 0 8px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    /* Style the active/current page button */
    #activity_table_wrapper .dataTables_paginate .page-item.active .page-link {
        background: #18181b !important;
        color: #ffffff !important;
        border-color: #18181b !important;
    }

    /* Remove positioning that lifts content above the title bar */
    #scrollTable,
    .card > .row {
        position: static !important;
    }

    /* Pills: cancel Bootstrap's relative + z-index on .btn / .btn.active */
    .col-md-12.mt-2:has(.activity-filter) label.btn,
    .col-md-12.mt-2:has(.activity-filter) label.btn.active,
    .col-md-12.mt-2:has(.activity-filter) .btn-group > .btn {
        position: static !important;
        z-index: auto !important;
    }

    /* Export: put it in normal flow (top-right), no absolute/z-index */
    .ml-auto.col-md-4.mt-3.mb-3.text-right {
        position: static !important;
        z-index: auto !important;
        order: -1 !important;
        width: 100% !important;
        display: flex !important;
        justify-content: flex-end !important;
        margin: 10px 10px 0 0 !important;
    }

    /* Filter card no longer needs the 58px gap reserved for the floating Export */
    .col-md-8.mt-3.d-flex.flex-wrap {
        margin-top: 10px !important;
    }
}
</style>
<script src="https://unpkg.com/feather-icons"></script>
<div class=" mb-5 content-position">

    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Sales Activity Report</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12" style="margin-top: 15px; margin-bottom: 25px; padding-bottom: 20px;" id="scrollTable">
        <div class="card" style="border: unset;">
            <div class="card">
            <div class="row" style="padding-left: 1rem;padding-right: 1rem;">
                <div class="col-md-8 mt-3 d-flex flex-wrap">


                            {{-- <select class="form-control ml-2" id="loggedin_user_id">
                                @foreach ($users as $user)
                                <option value="{{$user->id}}" @if ($user->id == auth()->user()->id) selected @endif>{{$user->name}}</option>
                                @endforeach
                            </select> --}}
                            <div class="row filter_row" style="padding-bottom: 2px;margin:5px">

                                <select  class="form-control ml-2" name="users[]" multiple id="users_array" >
                                        @foreach ($users as $user)
                                            <option class="Bulk ml-3" value="{{$user->id}}" >{{$user->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="row filter_row" style="padding-bottom: 2px;margin:5px">

                                <select  class="form-control ml-2" name="task"  id="task">

                                            <option class="Bulk ml-3" value="0" >All Activity</option>
                                            <option class="Bulk ml-3" value="1" >Overdue</option>
                                            <option class="Bulk ml-3" value="2" >Pending</option>
                                            <option class="Bulk ml-3" value="3" >Completed</option>

                                </select>
                            </div>
                            <div class="row filter_row" style="padding-bottom: 2px;margin:5px">

                                <button class="btn-grey-text" href="#" id="filterButton" style="border: unset"   title="Filter">
                                    Filter
                                </button>
                            </div>
                            {{-- <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;cursor: pointer;margin-bottom:unset;color:#8898aa" id="filterButton"><i class="fa fa-filter " style="padding-right: 5px;"></i> Filter </p> --}}
                            {{-- <div class="col filter_row" style="border: 1px solid #b3b3b3">
                            </div> --}}


                </div>

                {{-- <div class="col-sm-2 ml-auto mt-3 mb-3 text-right">
                    <button class="styled-button" style="outline: unset;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                        Table Layout
                    </button>
                </div> --}}
                <div class="ml-auto col-md-4 mt-3 mb-3 text-right">
                    <div class="row">
                        <div class="ml-auto col-4" style="padding-right: 15px;">
                            <button class="btn-grey-text" href="#" id="export_csv"   title="Export CSV">
                                Export
                            </button>

                        </div>


                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <div class="row" style="margin: 0px">

                        <div class="col-md-12 text-right ml-auto">
                            <div class="row btn-group btn-group-toggle ml-2" data-toggle="buttons" >
                                {{-- <label class="btn btn-sm btn-outline-danger ">
                                    <input type="radio" class="activity-filter"value="1" autocomplete="off"    /><span class="filter-text"> Overdue Completed</span>
                                </label>
                                <label class="btn btn-sm btn-outline-danger ">
                                    <input type="radio" class="activity-filter"value="7" autocomplete="off"    /><span class="filter-text"> Overdue Pending</span>
                                </label> --}}
                                <label class="btn btn-sm btn-outline-danger active">
                                    <input type="radio" class="activity-filter"value="2" checked autocomplete="off"/><span class="filter-text"> Today</span>
                                </label>
                                <label class="btn btn-sm btn-outline-danger">
                                    <input type="radio" class="activity-filter"value="4" autocomplete="off" /><span class="filter-text"> Tommorow </span>
                                </label>
                                <label class="btn btn-sm btn-outline-danger">
                                    <input type="radio" class="activity-filter"value="5" autocomplete="off" /><span class="filter-text"> This Week</span>
                                </label>
                                <label class="btn btn-sm btn-outline-danger">
                                    <input type="radio" class="activity-filter"value="6" autocomplete="off" /><span class="filter-text"> Next Week</span>
                                </label>
                                <label class="btn btn-sm btn-outline-danger">
                                    <input type="radio" class="activity-filter"value="3" autocomplete="off" id="activity_select_period" /><span class="filter-text"> Selected Period</span>
                                </label>
                                <label class="btn btn-sm btn-outline-danger ">
                                    <input type="radio" class="activity-filter" value="0"  autocomplete="off"/><span class="filter-text">All</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-2 new-style-table">
                    <div class="table-responsive">
                        @if(session('success'))
                            <div  id="success-message" style="display: none">
                                {{ session('success') }}
                            </div>
                        @endif
                        <table class="table align-items-center table-responsive " id="activity_table" style="display: inline-table;">
                            <thead class="header-style">
                                <th scope="col" class="activity-start-date">Start Date</th>
                                <th scope="col" class="activity-assign-to">Assign To</th>
                                <th scope="col" class="activity-description">Subject</th>
                                <th scope="col" class="activity-organization">Organization</th>
                                <th scope="col" class="activity-notes">Notes</th>
                                {{-- <th scope="col" class="activity-start-time">Start Time</th> --}}
                                {{-- <th scope="col" class="activity-due-date">Due Date</th> --}}
                                <th scope="col" class="activity-order-no">Order No</th>
                                <th scope="col" class="activity-contact-person">Contact Person</th>
                                <th scope="col" class="activity-created-by">Created By</th>
                                <th scope="col" class="activity-priority">Priority</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="select_date_range" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title-default">Select Date Range</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form id="add_modal_form">
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="activity-date-group">
                                <input type="text" class="form-control mr-2 date-picker" id="from_date" data-theme="dark" />
                                <span class="mr-2"><i class="fas fa-minus"></i></span>
                                <input type="text" class="form-control mr-2 date-picker" id="to_date" data-theme="dark" />
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn brn-sm btn-success btn-activity-form" id="filter_data"><small>Filter</small></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js"></script>
<script>
    let currentFilter = 2; // default All
    let fromDate = null;
    let toDate = null;

    $('input:radio.activity-filter').on('change', function () {
        currentFilter = $(this).val();
        console.log("Selected Filter:", currentFilter);

        if (currentFilter == 3) {
            // Open modal if "Custom Date Range" selected
            $('#select_date_range').modal('show');
        }
    });
     $('.date-picker').datepicker({
            dateFormat: 'mm/dd/yy', // Date picker format
            showAnim: 'slideDown',
            changeMonth: true,
            changeYear: true,
            onSelect: function(dateText) {
                $(this).trigger('change');
            }
        });

    $('#users_array').multiselect({
        includeSelectAllOption: true,
        nonSelectedText: 'All Users',
        allSelectedText: 'All Users',
        enableFiltering: false,
        buttonText: function(options, select) {
            if (options.length === 0) {
                return 'All Users';
            }
            else if (options.length === 1) {
                return $(options[0]).text(); // show single user name
            }
            else {
                return options.length + ' users'; // show count
            }
        }
    });
    $('#task').select2({
        placeholder: "Select status",
        allowClear: false,
        width: '100%' // makes it fit Bootstrap form-control
    });

    function exportTableToExcel(tableID, filename = '') {
    let table = document.getElementById(tableID);
    let rows = table.querySelectorAll('tr');
    let csv = [];

    rows.forEach(row => {
        let cols = row.querySelectorAll('th, td');
        let rowData = [];
        cols.forEach(col => {
            // Remove HTML tags (like badge spans)
            let text = col.innerText || col.textContent;
            rowData.push('"' + text.replace(/"/g, '""') + '"');
        });
        csv.push(rowData.join(','));
    });

    // Download CSV
    let csvFile = new Blob([csv.join('\n')], { type: "text/csv" });
    let downloadLink = document.createElement("a");
    downloadLink.download = filename ? filename + ".csv" : "table_export.csv";
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}
document.getElementById('export_csv').addEventListener('click', function () {
    exportTableToExcel('activity_table', 'sales_activity_report');
});

function exportTableToExcel(tableID, filename = '') {
    let table = document.getElementById(tableID);
    let rows = table.querySelectorAll("tr");

    let csv = [];

    rows.forEach(function (row) {
        let cols = row.querySelectorAll("td, th");
        let rowData = [];
        cols.forEach(function (col) {
            // Clean text, handle multiline + commas + quotes
            let data = col.innerText.replace(/\r?\n|\r/g, " ").replace(/"/g, '""');
            rowData.push('"' + data + '"');
        });
        csv.push(rowData.join(","));
    });

    // Download
    let csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
    let downloadLink = document.createElement("a");
    downloadLink.download = filename ? filename + ".csv" : "export.csv";
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
}



    $(document).ready(function() {
        let table = $('#activity_table').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ route('sales.activity.filter') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                    d.users = $('#users_array').val();
                    d.task = $('#task').val();
                    d.activity_filter = currentFilter;

                    if (currentFilter == 3) {
                        d.from_date = fromDate;
                        d.to_date = toDate;
                    }
                }
            },
            columns: [
                { data: 'start_date', render: function(data, type, row) {

                            return  moment(data).format("MM/DD/YYYY");

                        }
                     },
                { data: 'assignee_details.name' },
                { data: 'activity_subject' },
                { data: 'organization_details',
                        render: function(data) {
                            return data?.organization_name ?? '';
                        }
                },
                { data: 'activity_note',
                    render: function(data) {
                        if (!data) return '';
                        let text = data.toString();
                        return text.length > 20 ? text.substring(0, 20) + '...' : text;
                    }
                },
                { data: 'order_details',
                        render: function(data) {
                            return data?.order_no ?? '';
                        }
                },
                { data: 'contact_details',
                        render: function(data) {
                            return data?.first_name ?? '';
                        }
                },
                { data: 'user_details',
                        render: function(data) {
                            return data?.name ?? '';
                        }
                },
                {
                    data: 'priority',
                    render: function(data, type, row) {
                        if (data == 1) {
                            return '<span class="badge badge-pill" style="color:#FFB916;background-color:#FFF6CC;width:100%">LOW</span>';
                        } else if (data == 2) {
                            return '<span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:100%">MEDIUM</span>';
                        } else if (data == 3) {
                            return '<span class="badge badge-pill" style="color:#d381ff;background-color:#f9dfff;width:100%">HIGH</span>';
                        } else {
                            return '';
                        }
                    }
                }
            ]
        });


        // Global filter button
        $('#filterButton').on('click', function() {
            table.ajax.reload();
        });

        // Date modal "Filter" button
        $('#filter_data').on('click', function() {
            fromDate = $('#from_date').val();
            toDate = $('#to_date').val();

            console.log("Date Range:", fromDate, toDate);

            $('#select_date_range').modal('hide'); // close modal
            table.ajax.reload(); // reload with dates
        });
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

@endsection
