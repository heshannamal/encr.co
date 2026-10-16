@extends('layouts.app', ['activePage' => 'Employee_Managment', 'titlePage' => __('Employee Managment')])

@section('content')
<style>
    /* Custom pagination - matches permissions page style */
    .emp-pagination {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 4px;
        padding: 12px 16px;
    }

    .emp-pagination button {
        width: 30px;
        height: 30px;
        border: 1px solid #e0e4ef;
        border-radius: 5px;
        background: #fff;
        font-size: 12px;
        color: #555;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        transition: all .15s;
    }

    .emp-pagination button:hover {
        background: #f0f2f8;
    }

    .emp-pagination button.active {
        background: #1a1a2e;
        color: #fff;
        border-color: #1a1a2e;
    }

    .emp-pagination button:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    /* Hide default DataTables pagination */
    .dataTables_wrapper .dataTables_paginate {
        display: none !important;
    }

    .emp-page-wrapper {
        padding: 0 20px 40px 20px;
    }

    .emp-page-title {
        text-align: center;
        font-size: 26px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 24px;
        letter-spacing: 0.5px;
    }

    /* Top toolbar */
    .emp-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .emp-toolbar-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .emp-toolbar-right {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .emp-rows-label {
        font-size: 13px;
        color: #555;
        white-space: nowrap;
    }

    .emp-rows-select {
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 5px 8px;
        font-size: 13px;
        color: #333;
        background: #fff;
    }

    .emp-search-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .emp-search-wrapper i {
        position: absolute;
        left: 10px;
        color: #aaa;
        font-size: 13px;
    }

    .emp-search-input {
        border: 1px solid #ddd;
        border-radius: 20px;
        padding: 7px 14px 7px 32px;
        font-size: 13px;
        width: 240px;
        outline: none;
        color: #333;
    }

    .emp-search-input:focus {
        border-color: #aaa;
    }

    /* Action buttons */
    .emp-btn {
        border: 1px solid #ccc;
        background: #fff;
        border-radius: 4px;
        padding: 7px 16px;
        font-size: 13px;
        font-weight: 500;
        color: #444;
        cursor: pointer;
        transition: background 0.15s;
    }

    .emp-btn:hover {
        background: #f5f5f5;
    }

    .emp-btn-primary {
        background: #00bfa5;
        color: #fff;
        border-color: #00bfa5;
        font-weight: 600;
    }

    .emp-btn-primary:hover {
        background: #00a896;
        border-color: #00a896;
        color: #fff;
    }

    .emp-btn-primary i {
        margin-right: 5px;
    }

    /* Card / table container */
    .emp-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .emp-card .dataTables_wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Remove the extra scroll container height that scrollX adds */
    .dataTables_scrollBody {
        overflow-x: hidden !important;
    }

    /* DataTable core */
    #employee_summary_table {
        width: 100% !important;
        border-collapse: collapse;
    }

    /* header height: change padding to adjust */
    #employee_summary_table thead tr th {
        background-color: #717070 !important;
        color: #fff !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        letter-spacing: 0.5px !important;
        padding: 11px 14px !important;
        border: none !important;
        white-space: nowrap !important;
    }

    #employee_summary_table thead th.sorting:after,
    #employee_summary_table thead th.sorting_asc:after,
    #employee_summary_table thead th.sorting_desc:after,
    #employee_summary_table thead th.sorting:before,
    #employee_summary_table thead th.sorting_asc:before,
    #employee_summary_table thead th.sorting_desc:before {
        color: #bbb !important;
    }

    /* ROWS */
    #employee_summary_table tbody tr {
        border-bottom: 1px solid #e8e8e8;
        transition: background 0.1s;
    }

    #employee_summary_table tbody tr:hover {
        background-color: #fafafa;
    }

    #employee_summary_table tbody td {
        padding: 10px 14px !important;
        vertical-align: middle;
        font-size: 13px;
        color: #333;
        border-top: none !important;
        border-bottom: 1px solid #e8e8e8 !important;
    }

    .emp-id-cell {
        font-weight: 500;
        color: #444;
    }

    .emp-employee-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user_dp {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }

    .emp-name-text {
        font-weight: 500;
        color: #222;
    }

    /* Hide DataTables default search/length controls */
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_length {
        display: none !important;
    }

    .dataTables_wrapper .dataTables_info {
        font-size: 12px;
        color: #888;
        padding: 10px 16px;
    }

    .dataTables_wrapper .dataTables_paginate {
        padding: 10px 16px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 4px;
        font-size: 13px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #3d3d3d !important;
        border-color: #3d3d3d !important;
        color: #fff !important;
    }

    /* Loader */
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

    /* Status badges */
    .badge-active {
        background: #e6f9f5;
        color: #00a896;
        border: 1px solid #b2eae3;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        cursor: pointer;
        display: inline-block;
    }

    .badge-blocked {
        background: #fff0ee;
        color: #e53935;
        border: 1px solid #f5c6c4;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        cursor: pointer;
        display: inline-block;
    }

    /* Action icons */
    .action-icons {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .action-icons i {
        font-size: 15px;
        color: #666;
        cursor: pointer;
        transition: color 0.15s;
    }

    .action-icons i:hover {
        color: #222;
    }

    /* Groups view link */
    .view-groups-link {
        display: flex;
        align-items: center;
        gap: 5px;
        color: #444;
        cursor: pointer;
        font-size: 13px;
    }

    .view-groups-link i {
        font-size: 14px;
    }

    /* Permissions list */
    .permissions-list {
        column-count: 3;
        column-gap: 20px;
        list-style-position: inside;
    }

    /* Select2 */
    .select2.select2-container {
        width: 100% !important;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        border: 1px solid #c8c8c8 !important;
    }

    /* Form fields in modals */
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

    @media (max-width: 768px) {
        .emp-toolbar {
            flex-direction: column;
            align-items: flex-start;
        }

        .emp-search-input {
            width: 180px;
        }

        .emp-toolbar-right {
            flex-wrap: wrap;
        }
    }
.mobile-view-badge {
    display: none;
}
 

.email-copy-icon {
    display: none;
}
 
@media (max-width: 767px) {
 
    /* ---------- Page wrapper ---------- */
    .emp-page-wrapper {
        padding: 0 10px 30px 10px;
    }
 
    .emp-toolbar {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
        margin-bottom: 14px;
        background: #f7f8fb;
        border-radius: 14px;

        padding: 14px;
        box-sizing: border-box;
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.05);
    }
 
    .emp-toolbar-left {
        flex-direction: column;
        align-items: stretch;
        width: 100%;
        gap: 8px;
    }
 
    .emp-rows-label,
    .emp-rows-select,
    .emp-toolbar-left .select2-container,
    #pageLengthSelect + .select2-container {
        display: none !important;
    }
 
    .emp-search-wrapper {
        width: 100%;
    }
 
    .emp-search-input {
        width: 100%;
        box-sizing: border-box;
        border-radius: 10px;
        padding: 10px 14px 10px 34px;
        font-size: 14px;
    }
 
    /* Buttons + toggle row: wrap into a clean 2-column layout */
    .emp-toolbar-right {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        width: 100%;
    }
 
    .emp-toolbar-right .emp-btn,
    .emp-toolbar-right .emp-btn-primary {
        flex: 1 1 0;
        min-width: 0;
        box-sizing: border-box;
        text-align: center;
        border-radius: 8px;
        padding: 10px 6px;
        font-size: 12px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
 
    .emp-toolbar-right .hide-task-toggle {
        display: flex !important;
        order: 2; /* moved below Export CSV / Add Employee (both default to order: 0) */
        flex: 1 1 100% !important;
        width: 100% !important;
        height: auto !important;
        min-height: 0 !important;
        border-radius: 12px !important;
        background: #fff !important;
        border: none !important;
        box-shadow: none !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 14px 16px !important;
        box-sizing: border-box;
        margin-right: 0px !important;
    }
 
    /* Hide the real eye icons — we no longer show them, we only
       read their "d-none" class (see above) to drive the text
       and switch below. */
    .hide-task-toggle .fa-eye,
    .hide-task-toggle .fa-eye-slash {
        display: none !important;
    }
 
    /* Text label (left side). Default = "visible" wording;
       overridden below when the hidden-icon is the active one. */
    .hide-task-toggle::before {
        content: "Inactive users are visible";
        font-size: 14px;
        font-weight: 600;
        color: #333;
    }
 
    .hide-task-toggle:has(.hide-eye-close:not(.d-none))::before {
        content: "Inactive users are hidden";
    }
 
    /* Real switch (right side), drawn as one element: a pill
       track with a circular "knob" baked into its background via
       a radial-gradient, positioned left (OFF) or right (ON). */
    .hide-task-toggle::after {
        content: "";
        display: inline-block;
        width: 44px;
        height: 24px;
        border-radius: 12px;
        flex-shrink: 0;
        background:
            radial-gradient(circle 9px at 12px 12px, #fff 100%, transparent 0) no-repeat,
            #ccc;
        transition: background 0.2s ease;
    }
 
    .hide-task-toggle:has(.hide-eye-close:not(.d-none))::after {
        background:
            radial-gradient(circle 9px at 32px 12px, #fff 100%, transparent 0) no-repeat,
            #2b2b3d;
    }

    .emp-toolbar-right button[data-target="#layout_modal"] {
        display: none !important;
    }
 
    /* ---------- Table info bar ---------- */
    #empTableInfo {
        font-size: 12px;
    }
 
    /* ---------- Turn the table into a list of cards ---------- */
    .emp-card {
        background: transparent;
        box-shadow: none;
        border-radius: 0;
        overflow: visible;
    }
 
    #employee_summary_table_div {
        overflow: visible;
    }
 
    #employee_summary_table {
        border-collapse: separate;
        border-spacing: 0;
    }
 
    /* Hide the column headings — the design has no header row on mobile */
    #employee_summary_table thead {
        display: none;
    }
 
    #employee_summary_table,
    #employee_summary_table tbody {
        display: block;
        width: 100%;
    }
 
    /* Each row becomes one card */
    #employee_summary_table tbody tr {
        display: flex;
        flex-wrap: wrap;
        background: #fff;
        border: none;
        border-radius: 12px;
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.08);
        padding: 14px;
        margin-bottom: 12px;
    }
 
    #employee_summary_table tbody td {
        display: block;
        border: none !important;
        padding: 8px 10px !important;
        width: 100%;
        box-sizing: border-box; /* keeps padding from pushing columns wider than the card */
    }
 
    /* Hide the columns that aren't in the mobile design */
    #employee_summary_table tbody td.employee-mobile,
    #employee_summary_table tbody td.employee-job_title,
    #employee_summary_table tbody td.employee-department,
    #employee_summary_table tbody td.employment_status,
    #employee_summary_table tbody td.Created-At,
    #employee_summary_table tbody td.Updated-At,
    #employee_summary_table tbody td:nth-child(n+13) {
        display: none;
    }
 
    /* Order the visible cells: Name -> ID -> Email -> Status/Permissions/Login */
    #employee_summary_table tbody td.employee-name {
        order: 1;
        flex: 1 1 100%;
        position: relative; /* needed so the new "View" badge below can sit top-right */
        padding-right: 70px !important; /* keeps the name text from running under the View button */
    }
 

    .mobile-view-badge {
        display: flex;
        position: absolute;
        top: 0;
        right: 0;
        align-items: center;
        gap: 4px;
        background: #f2f3f6;
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 600;
        color: #444;
        cursor: pointer;
        z-index: 2;
    }
 
    .mobile-view-badge i {
        font-size: 11px;
        color: #444;
    }

    .mobile-view-badge:active {
        background: #444;
        color: #fff;
    }
 
    .mobile-view-badge:active i {
        color: #fff;
    }
 
    #employee_summary_table tbody td.emp-id-cell {
        order: 2;
        flex: 1 1 100%;
        text-align: left !important;
        font-size: 11px;
        color: #999;
        font-weight: 500;
        margin-top: -33px;
        padding-left: 27px !important;
    }
 
    /* Your own manually-added rule — kept exactly as you set it */
    td.text-center.emp-id-cell {
        margin-left: 34px;
    }
 
    #employee_summary_table tbody td.employee-email {
        order: 3;
        flex: 1 1 100%;
        text-align: left !important;
        margin-top: 10px;
    }
 

    #employee_summary_table tbody td.employee-status,
    #employee_summary_table tbody td.employee-groups,
    #employee_summary_table tbody td.employee-actions {
        flex: 1 1 33.33%;
        max-width: 33.33%;
        margin-top: 12px;
    }
 
    #employee_summary_table tbody td.employee-status { order: 4; padding-right: 6px !important; padding-top: 6px !important; }
    #employee_summary_table tbody td.employee-groups { order: 5; padding: 0 3px !important; }
    #employee_summary_table tbody td.employee-actions { order: 6; padding-left: 6px !important; }
 
    /* Small gray labels above Status / Permissions / Login As, like the design */
    #employee_summary_table tbody td.employee-status::before,
    #employee_summary_table tbody td.employee-groups::before,
    #employee_summary_table tbody td.employee-actions::before {
        display: block;
        font-size: 10px;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-bottom: 4px;
        font-weight: 600;
    }
 
    #employee_summary_table tbody td.employee-status::before { content: "Status"; }
    #employee_summary_table tbody td.employee-groups::before { content: "Permissions"; }
    #employee_summary_table tbody td.employee-actions::before { content: "Login As"; }
 
    #employee_summary_table tbody td.employee-groups {
        order: 5;
        padding: 0 3px !important;
        padding-top: 9px !important;
    }
 

    #employee_summary_table tbody td.employee-name {
        padding-top: 0 !important;
    }
 
    .emp-employee-cell {
        align-items: flex-start;
        gap: 6px; /* was 8px — tightens the space between avatar and text */
    }
 
    .emp-name-text {
        display: block;
        line-height: 1.15;
        margin-top: 1px; /* tiny nudge so it lines up with the top of the avatar */
    }
 
    .emp-employee-cell .user_dp {
        width: 36px;
        height: 36px;
    }
 
    /* Your own manually-added rule — kept exactly as you set it */
    .emp-name-text {
        font-size: 14px;
        padding-left: 8px;
    }
 
    /* Email pill, styled like the light box in the screenshot — now
       laid out as a row so the email text sits on the left and the
       new copy icon sits on the right, matching the screenshot. */
    .employee-email {
        display: flex !important;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        background: #f4faf4;
        border: 1px solid #e1efe1;
        border-radius: 10px;
        padding: 12px 14px !important;
        font-size: 13px;
       
       
    }
 
    .employee-email .email-text {
        word-break: break-all;
        font-size: 15px;
        color: #1a6b3f;
    }
    

 
    /* The small white "copy" button on the right of the email box —
       hidden by default (see the rule near the top of this file),
       shown here only on mobile. */
    .email-copy-icon {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        flex-shrink: 0;
        background: #fff;
        border: 1px solid #d7e6d7;
        border-radius: 7px;
        color: #6b7280;
        font-size: 12px;
        cursor: pointer;
    }
 
    .badge-active,
    .badge-blocked {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 100% !important;
        height: 34px !important;
        box-sizing: border-box !important;
        margin: 0 !important;
        line-height: normal !important;
        font-size: 10px;
        padding: 0 10px !important;
        border-radius: 8px;
        background: #10B981;
        color: #fff;
    }
 
    /* Permissions "View" — dark pill button */
    .employee-groups .view-groups-link {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        height: 34px !important;
        margin: 0 !important;
        background: #6B7280;
        color: #fff;
        border-radius: 8px;
        padding: 0 4px !important;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        width: 100%;
        box-sizing: border-box !important;
    }
 
    /* The plain <div> that wraps the "View" pill — no set height of
       its own, so it must be forced to hug the pill's 28px exactly,
       otherwise extra breathing room here throws the row off again. */
    .employee-groups > div {
        display: flex !important;
        align-items: center !important;
        height: 28px !important;
        margin: 0 !important;
        padding: 0 !important;
    }
 
    /* Login As — blue pill button */
    .employee-actions .action-icons {
        justify-content: center !important;
        align-items: center !important;
        height: 28px !important;
        margin: 0 !important;
        padding: 0 !important;
    }
 
    .employee-actions .view_account {
        display: flex !important;
        align-items: center !important;
        gap: 4px;
        justify-content: center !important;
        height: 34px !important;
        margin: 0 !important;
        background: #3B82F6;
        color: #fff;
        border-radius: 8px;
        padding: 0 4px !important;
        font-size: 10px;
        font-weight: 600;
        width: 100%;
        box-sizing: border-box;
        text-transform: uppercase;
    }
 
    .employee-actions .view_account i {
        color: #fff;
        font-size: 12px;
    }
 
    /* ---------- Pagination bar ---------- */
    .emp-pagination {
        justify-content: center;
        flex-wrap: wrap;
        padding: 10px 0;
    }
 
    .emp-pagination button {
        width: 26px;
        height: 26px;
        font-size: 11px;
    }
 
    /* ---------- Modals (group/permissions + table layout) ---------- */
    .modal-dialog {
        margin: 10px;
        max-width: calc(100% - 20px);
    }
 
    .form-field {
        flex-direction: column;
        align-items: flex-start;
    }
 
    .form-lable {
        width: 100%;
        margin-bottom: 6px;
    }
 
    .permissions-list {
        column-count: 1;
    }

    .back_home_mobile {
        padding-left: 12px;
        padding-bottom: 12px;
    }

    #employee_summary_table tbody td.employee-status,
    #employee_summary_table tbody td.employee-groups,
    #employee_summary_table tbody td.employee-actions {
        background: #E7E9EB;
        border-top: 1px solid #d1d5db;
        border-bottom: 1px solid #d1d5db;
    }

    #employee_summary_table tbody td.employee-status {
        border-left: 1px solid #d1d5db;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    #employee_summary_table tbody td.employee-actions {
        border-right: 1px solid #d1d5db;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    #employee_summary_table tbody td.employee-status, #employee_summary_table tbody td.employee-groups, #employee_summary_table tbody td.employee-actions {
        background: #FAFBFC;
        border-top: 1px solid #E7E9EB !important;
        border-bottom: 1px solid #E7E9EB !important;
        border-left: 1px solid #E7E9EB !important;
        border-right: 1px solid #E7E9EB !important;
    }


    
}




    @media (max-width: 768px) {
        .email-text::before {
            content: "\2709";
            margin-right: 6px;
            font-size: 19px;
            vertical-align: middle;
            color: #6b7280;
        }

    
    }

    @media (min-width: 768px) {
        .back_home_mobile {
            display: none;
        }
    }
   

</style>

@if ($errors->any())
<div class="alert alert-danger">
    {{ $errors->first() }}
</div>
@endif

<div class="se-pre-con"></div>

@section('order-header')
<span>EMPLOYEE MANAGEMENT</span>
@endsection

@section('back-btn')
<a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
@endsection

@section('back-btn-Mobile')
    <a href="javascript:void(0);" onclick="goBackOnePage()" class="home-btn-color-mobile" title="Back">
        < BACK
    </a>
@endsection

<div class="back_home_mobile">
    <strong>
        @yield('back-btn-Mobile')
    </strong>
</div>

<div class="emp-page-wrapper">

    <!-- <h1 class="emp-page-title">Employee Management</h1> -->

    <!-- Toolbar -->
    <div class="emp-toolbar">
        <div class="emp-toolbar-left">
            <span class="emp-rows-label">Show rows per page</span>
            <select class="emp-rows-select" id="pageLengthSelect">
                <option value="20">20</option>
                <option value="40">40</option>
                <option value="60">60</option>
                <option value="100">100</option>
            </select>
            <div class="emp-search-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" class="emp-search-input" id="empSearchInput" placeholder="Search by employee name">
            </div>
        </div>
        <div class="emp-toolbar-right">
            <label class="d-flex align-items-center justify-content-center mr-3 mb-0 hide-task-toggle"
                style="
                        width:38px;
                        height:38px;
                        cursor:pointer;
                        background:#dce9dc;
                        border-radius:50%;
                        transition:all .2s ease;
                        box-shadow:0 1px 4px rgba(0,0,0,0.08);
                "
                title="Hide inactive users">

                <input type="checkbox"
                    id="hide_inactive_users"
                    class="hide-completed-tasks-checkbox d-none" checked>

                {{-- Eye Open --}}
                <i class="fa fa-eye hide-eye-open d-none" title="Inactive users is visible" style="font-size:16px; color:#198754;"></i>

                {{-- Eye Closed --}}
                <i class="fa fa-eye-slash hide-eye-close" title="Inactive users is hidden" style="font-size:16px; color:#dc3545;"></i>

            </label>
            @can('export users')
            <button class="emp-btn" onclick="exportReport()" title="Export CSV">
                EXPORT CSV
            </button>
            @endcan
            <button class="emp-btn" data-toggle="modal" data-target="#layout_modal" title="Table Layout">
                TABLE LAYOUT
            </button>
            <!-- @can('add users')
            <button class="emp-btn emp-btn-primary" data-toggle="modal" data-target="#user_create_modal" title="Add New Employee">
                <i class="fas fa-plus"></i> ADD EMPLOYEE old
            </button> -->
            @endcan
            @can('add users')
            <a href="{{ route('newemployee') }}" class="emp-btn emp-btn-primary" title="Add New Employee">
                <i class="fas fa-plus"></i> ADD EMPLOYEE
            </a>
            @endcan
        </div>
    </div>

    <!-- Table Card -->
    <div class="emp-card">
        <div class="table-responsive" id="employee_summary_table_div">
            <table class="table" id="employee_summary_table" style="width:100%;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>EMPLOYEE</th>
                        <th>ORGANIZATION EMAIL</th>
                        <th>MOBILE</th>
                        <th>JOB TITLE</th>
                        <th>DEPARTMENT</th>
                        <th>EMPLOYMENT STATUS</th>
                        <th>STATUS</th>
                        <th>PERMISSIONS</th>
                        <th>LOGIN AS</th>
                        <th>CREATE AT</th>
                        <th>UPDATED AT</th>
                        {{-- NEW COLUMNS --}}
                        <th>WORK NUMBER</th>
                        <th>ADDRESS</th>
                        <th>CITY</th>
                        <th>COUNTRY</th>
                        <th>POSTAL CODE</th>
                        <th>TIMEZONE</th>
                        <th>JOINED DATE</th>
                        <th>MARITAL STATUS</th>
                        <th>GENDER</th>
                        <th>NATIONALITY</th>
                        <th>LANGUAGES</th>
                        <th>PRIVATE EMAIL</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- Custom pagination bar -->
    <div style="display:flex; align-items:center; justify-content:space-between; padding: 6px 4px;">
        <div class="dataTables_info" id="empTableInfo" style="font-size:12px; color:#888;"></div>
        <div class="emp-pagination" id="empPagination"></div>
    </div>

</div>

<!-- Modal: User Groups & Permissions -->
<div class="modal fade" id="view_group_Modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Employee Groups & Permissions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row px-3 pb-2">
                    <div class="col-8 form-field">
                        <label for="employee_groups_select" style="width: 40%;" class="form-label">Add User Group</label>
                        <select class="" style="border: 1px solid #DEDEDE;border-radius:0rem"
                            name="employee_groups_select"
                            id="employee_groups_select"
                            data-AlradySaved="" required data-uid="">
                            <option value="">Select User Group</option>
                        </select>
                    </div>
                </div>
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Group Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider"></tbody>
                </table>
                <div class="col-12">
                    <h3>Permissions</h3>
                </div>
                <div class="row">
                    <ol class="permissions-list"></ol>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Table Layout -->
<div class="modal fade" id="layout_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">User Fields &amp; Layouts</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">
                        <input type="hidden" id="layout_id" name="layout_id" value="{{$userLayout['id'] ?? '' }}" />
                        <input type="hidden" id="column_layout_id" name="column_layout_id" value="{{ 'EMP' . str_pad($columnLayout['id'] ?? 0, 3, '0', STR_PAD_LEFT) }}" />

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="name" name="name" title="User Name"
                                    @if ($userLayout !=null && $userLayout['name']==1) checked @endif />
                                <label class="custom-control-label" for="name">User Name</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="email" name="email" title="Email"
                                    @if ($userLayout !=null && $userLayout['email']==1) checked @endif />
                                <label class="custom-control-label" for="email">Email</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="mobile" name="mobile" title="Mobile"
                                    @if ($userLayout !=null && $userLayout['m_number']==1) checked @endif />
                                <label class="custom-control-label" for="mobile">Mobile</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="user_status" name="user_status" title="Status"
                                    @if ($userLayout !=null && $userLayout['user_role_name']==1) checked @endif />
                                <label class="custom-control-label" for="user_status">Status</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="user_group_name" name="user_group_name" title="Permissions"
                                    @if ($userLayout !=null && $userLayout['user_group_name']==1) checked @endif />
                                <label class="custom-control-label" for="user_group_name">Permissions</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="user_action" name="user_action" title="Actions"
                                    @if ($userLayout !=null && $userLayout['action']==1) checked @endif />
                                <label class="custom-control-label" for="user_action">Login As</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="created_at" name="created_at" title="CREATE AT"
                                    @if ($userLayout !=null && $userLayout['created']==1) checked @endif />
                                <label class="custom-control-label" for="created_at">CREATE AT</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="updated_at" name="updated_at" title="Updated At"
                                    @if ($userLayout !=null && $userLayout['updated']==1) checked @endif />
                                <label class="custom-control-label" for="updated_at">Updated At</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="department" name="department" title="Department"
                                    @if ($userLayout !=null && $userLayout['department']==1) checked @endif />
                                <label class="custom-control-label" for="department">Department</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="employment_status" name="employment_status" title="Employment Status"
                                    @if ($userLayout !=null && $userLayout['employment_status']==1) checked @endif />
                                <label class="custom-control-label" for="employment_status">Employment Status</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="job_title" name="job_title" title="Job Title"
                                    @if ($userLayout !=null && $userLayout['job_title']==1) checked @endif />
                                <label class="custom-control-label" for="job_title">Job Title</label>
                            </div>
                        </div>
                        <!-- More Fields -->
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="w_number"
                                    @if ($userLayout && $userLayout['w_number']==1) checked @endif>
                                <label class="custom-control-label" for="w_number">Work Number</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="address"
                                    @if ($userLayout && $userLayout['address']==1) checked @endif>
                                <label class="custom-control-label" for="address">Address</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="city"
                                    @if ($userLayout && $userLayout['city']==1) checked @endif>
                                <label class="custom-control-label" for="city">City</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="country"
                                    @if ($userLayout && $userLayout['country']==1) checked @endif>
                                <label class="custom-control-label" for="country">Country</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="postal_code"
                                    @if ($userLayout && $userLayout['postal_code']==1) checked @endif>
                                <label class="custom-control-label" for="postal_code">Postal Code</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="timezone"
                                    @if ($userLayout && $userLayout['timezone']==1) checked @endif>
                                <label class="custom-control-label" for="timezone">Timezone</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="joined_date"
                                    @if ($userLayout && $userLayout['joined_date']==1) checked @endif>
                                <label class="custom-control-label" for="joined_date">Joined Date</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="marital_status"
                                    @if ($userLayout && $userLayout['marital_status']==1) checked @endif>
                                <label class="custom-control-label" for="marital_status">Marital Status</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="gender"
                                    @if ($userLayout && $userLayout['gender']==1) checked @endif>
                                <label class="custom-control-label" for="gender">Gender</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="nationality"
                                    @if ($userLayout && $userLayout['nationality']==1) checked @endif>
                                <label class="custom-control-label" for="nationality">Nationality</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="languages"
                                    @if ($userLayout && $userLayout['languages']==1) checked @endif>
                                <label class="custom-control-label" for="languages">Languages</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="private_email"
                                    @if ($userLayout && $userLayout['private_email']==1) checked @endif>
                                <label class="custom-control-label" for="private_email">Private Email</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
<div style="padding-bottom: 5%;"></div>

@include('pages.users.users.create')

<script src="https://unpkg.com/feather-icons"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.10/dayjs.min.js"></script>

<script>
    $('select').select2();

    $(document).ready(function() {
        $('#employee_groups_select').select2({
            placeholder: "Select User Group",
            dropdownParent: $("#view_group_Modal"),
            allowClear: true
        });
    });

    $(document).ready(function() {

        // Column index map (matches thead order):
        // 0=ID, 1=EMPLOYEE, 2=EMAIL, 3=MOBILE, 4=JOB_TITLE, 5=DEPARTMENT, 6=EMP_STATUS, 7=STATUS, 8=GROUPS, 9=ACTIONS, 10=CREATE AT, 11=UPDATED_AT

        function enforceHeaderStyle() {
            // Only target the VISIBLE cloned header (scrollHead), not the hidden original
            $('#employee_summary_table thead tr th').css({
                'background-color': '#3d3d3d',
                'color': '#ffffff',
                'border': 'none',
                'padding': '11px 14px'
            });
        }

        var employeetable = $('#employee_summary_table').DataTable({
            "paging": true,
            colReorder: true,
            stateSave: false,
            "autoWidth": false,
            "dom": 'tip',
            "scrollX": false,
            "pageLength": 20,
            "ordering": true,
            "info": true,
            "lengthChange": false,
            "initComplete": function() {
                enforceHeaderStyle();
            },
            "drawCallback": function() {
                enforceHeaderStyle();
                renderEmpPagination(this.api());
            },
            "columnDefs": [{
                    "targets": 0,
                    "className": "text-center emp-id-cell"
                },
                {
                    "targets": 1,
                    "className": "employee-name"
                },
                {
                    "targets": 2,
                    "className": "text-center employee-email"
                },
                {
                    "targets": 3,
                    "className": "text-center employee-mobile"
                },
                {
                    "targets": 4,
                    "className": "text-center employee-job_title"
                },
                {
                    "targets": 5,
                    "className": "text-center employee-department"
                },
                {
                    "targets": 6,
                    "className": "text-center employment_status"
                },
                {
                    "targets": 7,
                    "className": "text-center employee-status"
                },
                {
                    "targets": 8,
                    "className": "text-center employee-groups"
                },
                {
                    "targets": 9,
                    "className": "text-center employee-actions",
                    "orderable": false
                },
                {
                    "targets": 10,
                    "className": "text-center Created-At",
                    "render": function(data) {
                        return data ? dayjs(data).format("D MMM YYYY") : "";
                    }
                },
                {
                    "targets": 11,
                    "className": "text-center Updated-At",
                    "render": function(data) {
                        return data ? dayjs(data).format("D MMM YYYY") : "";
                    }
                },
                {
                    "targets": 12,
                    "className": "text-center"
                },
                {
                    "targets": 13,
                    "className": "text-center"
                },
                {
                    "targets": 14,
                    "className": "text-center"
                },
                {
                    "targets": 15,
                    "className": "text-center"
                },
                {
                    "targets": 16,
                    "className": "text-center"
                },
                {
                    "targets": 17,
                    "className": "text-center"
                },
                {
                    "targets": 18,
                    "className": "text-center",
                    "render": function(data) {
                        return data && data !== 'N/A' ? dayjs(data).format("D MMM YYYY") : data;
                    }
                },
                {
                    "targets": 19,
                    "className": "text-center"
                },
                {
                    "targets": 20,
                    "className": "text-center"
                },
                {
                    "targets": 21,
                    "className": "text-center"
                },
                {
                    "targets": 22,
                    "className": "text-center"
                },
                {
                    "targets": 23,
                    "className": "text-center"
                },
            ],
        });

        // Custom search input wired to DataTable
        $('#empSearchInput').on('keyup', function() {
            employeetable.search(this.value).draw();
        });

        // Custom page length selector
        $('#pageLengthSelect').on('change', function() {
            employeetable.page.len(parseInt(this.value)).draw();
        });
        let allEmployees = [];
        make_employee_summary_table();

        function filterEmployeeByActiveStatus() {
            var hideInactiveUsers = $('#hide_inactive_users').is(':checked');

            var filteredEmployees = hideInactiveUsers
                ? allEmployees.filter(function(employee) {
                    return Number(employee.active) == 1;
                })
                : allEmployees;

            update_employee_summary_Table(filteredEmployees);
            updateActiveToggleUI(hideInactiveUsers);
        }

        function updateActiveToggleUI(hideInactiveUsers) {
            if (hideInactiveUsers) {
                $('.hide-eye-open').addClass('d-none');
                $('.hide-eye-close').removeClass('d-none');

                $('.hide-task-toggle')
                    .attr('title', 'Inactive users are hidden')
                    .css('background', '#dce9dc');
            } else {
                $('.hide-eye-close').addClass('d-none');
                $('.hide-eye-open').removeClass('d-none');

                $('.hide-task-toggle')
                    .attr('title', 'Inactive users are visible')
                    .css('background', '#e8f5e9');
            }
        }
        $('#hide_inactive_users').on('change', function() {
            filterEmployeeByActiveStatus();
        });
        function make_employee_summary_table() {
            $('.se-pre-con').fadeIn();
            $.ajax({
                url: "{{ route('HR.employee_summary_table_data') }}",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    allEmployees = response;
                    // update_employee_summary_Table(response);
                    filterEmployeeByActiveStatus();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    $('.se-pre-con').fadeOut();
                }
            });
        }

        function update_employee_summary_Table(data) {
            var defaultProfilePic = "{{ asset('assets/img/user/default.png') }}";
            var assetPath = "{{ asset('') }}";

            employeetable.clear();

            data.forEach(function(employee) {
                var profile_path = defaultProfilePic;
                if (employee.profile_pic) {
                    profile_path = assetPath + employee.profile_pic;
                }

                // existing fields
                var mobile = employee.user_details?.m_number || 'N/A';
                var department = employee.user_details?.Department || 'N/A';
                var employment_status = employee.user_details?.Employment_Status || 'N/A';
                var job_title = employee.user_details?.job_title || 'N/A';

                // new fields — adjust the key names to match your API response
                var w_number = employee.user_details?.w_number || 'N/A';
                var address = employee.user_details?.address || 'N/A';
                var city = employee.user_details?.city || 'N/A';
                var country = employee.user_details?.country || 'N/A';
                var postal_code = employee.user_details?.postal_code || 'N/A';
                var timezone = employee.user_details?.timezone || 'N/A';
                var joined_date = employee.user_details?.joined_date || 'N/A';
                var marital_status = employee.user_details?.Marital_Status || 'N/A';
                var gender = employee.user_details?.Gender || 'N/A';
                var nationality = employee.user_details?.Nationality || 'N/A';
                var languages = employee.user_details?.Languages || 'N/A';
                var private_email = employee.user_details?.Private_Email || 'N/A';

                var isAdmin = @json(auth()->user()->isAdmin());
                var empId = 'EMP' + String(employee.id).padStart(3, '0');
                var authUser = @json(auth()->user()->id);

                var employeeColumn = '<div class="emp-employee-cell edit_account" ' +
                    'data-uid="' + employee.id + '" style="cursor:pointer;">' +
                    '<img src="' + profile_path + '" class="user_dp" alt="">' +
                    '<span class="emp-name-text">' + employee.name + '</span>' +
                    '<span class="mobile-view-badge"><i class="fas fa-eye"></i> View</span>' +
                    '</div>';
 
                var emailColumn = '<span class="email-text">' + employee.email + '</span>' +
                    '<span class="email-copy-icon" data-email="' + employee.email + '" title="Copy email">' +
                    '<i class="fas fa-copy"></i></span>';

                var groupbtn = '<div style="display:flex;gap:8px;justify-content:center;">' +
                    '<div class="view-groups-link permission_view" data-uid="' + employee.id + '">' +
                    '<i class="fa fa-shield-alt"></i><span>View</span>' +
                    '</div></div>';

                var eyeIcon = '';
                if (isAdmin && authUser !== employee.id) {
                    if((employee.id == 5 && authUser == 1) || employee.id !== 5 || employee.id !== 1){
                        eyeIcon = '<div class="view_account" data-uid="' + employee.id + '" style="cursor:pointer;">' +
                            '<i class="fa fa-sign-in"></i><span class="login-text"> Login</span>' +
                            '</div>';
                    }
                }

                var action_btns = '<div class="action-icons">' + eyeIcon + '</div>';

                var active = employee.active == 1 ?
                    '<span class="badge-active changeStatus" data-active="' + employee.active + '" data-uid="' + employee.id + '">Active</span>' :
                    '<span class="badge-blocked changeStatus" data-active="' + employee.active + '" data-uid="' + employee.id + '">Blocked</span>';

                employeetable.row.add([
                    empId,
                    employeeColumn,
                    emailColumn,
                    mobile,
                    job_title,
                    department,
                    employment_status,
                    active,
                    groupbtn,
                    action_btns,
                    employee.created_at,
                    employee.updated_at,
                    // new columns must be in the SAME ORDER as thead
                    w_number,
                    address,
                    city,
                    country,
                    postal_code,
                    timezone,
                    joined_date,
                    marital_status,
                    gender,
                    nationality,
                    languages,
                    private_email,
                ]).draw(false);
            });

            $('.se-pre-con').fadeOut();
        }
        // Row actions
        $(document).on('click', '.view_account', function() {
            var userId = $(this).data('uid');
            window.location.href = "{{ route('user_loggin.view', ':id') }}".replace(':id', userId);
        });

        $(document).on('click', '.edit_account', function() {
            if ($(window).width() <= 767) {
                return;
            }
            var userId = $(this).data('uid');
            window.location.href = "{{ route('HR.employee_view', ':id') }}".replace(':id', userId);
        });

        $(document).on('click', '.mobile-view-badge', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var userId = $(this).closest('.edit_account').data('uid');
            window.location.href = "{{ route('HR.employee_view', ':id') }}".replace(':id', userId);
        });

        $(document).on('click', '.email-copy-icon', function(e) {
            e.preventDefault();
            e.stopPropagation();
 
            var icon = $(this);
            var email = icon.data('email');
 
            function showCopied() {
                var original = icon.html();
                icon.html('<i class="fas fa-check"></i>');
                setTimeout(function() {
                    icon.html(original);
                }, 1200);
            }
 
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(email).then(showCopied);
            } else {
                var temp = $('<input>');
                $('body').append(temp);
                temp.val(email).select();
                document.execCommand('copy');
                temp.remove();
                showCopied();
            }
        });

        // Permissions view - opens in new tab
        $(document).on('click', '.permission_view', function() {
            var userId = $(this).data('uid');
            var url = "{{ route('HR.employee_permission', ':id') }}".replace(':id', userId);
            window.open(url, '_blank');
        });

        $(document).on('click', '.changeStatus', function() {
            var status = $(this).data('active');
            var userId = $(this).data('uid');
            var action = status ? 'deactivate' : 'activate';
            var newStatus = status ? 0 : 1;

            Swal.fire({
                title: `Are you sure you want to ${action} this user?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: status ? '#d33' : '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: `Yes, ${action}!`
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('HR.updateUserStatus') }}",
                        type: 'POST',
                        data: {
                            user_id: userId,
                            status: newStatus,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function() {
                            Swal.fire('Updated!', `User has been ${action}d successfully.`, 'success');
                            location.reload();
                        },
                        error: function() {
                            Swal.fire('Error!', 'Something went wrong. Please try again.', 'error');
                        }
                    });
                }
            });
        });

        // Groups modal
        function loadUserGroups(userId) {
            $.ajax({
                url: "{{ url('employee/get/groups') }}",
                type: "POST",
                data: {
                    userId: userId,
                    _token: $('meta[name="csrf-token"]').attr("content")
                },
                success: function(response) {
                    if (response.success) {
                        var select = $('#employee_groups_select');
                        select.empty().append('<option value="">Select User Group</option>');
                        response.groups.forEach(function(group) {
                            select.append('<option value="' + group.id + '">' + group.name + '</option>');
                        });
                        select.attr('data-uid', userId);

                        var tableBody = $('.table-group-divider');
                        tableBody.empty();
                        response.userGroups.forEach(function(groupName, index) {
                            tableBody.append('<tr><th scope="row">' + (index + 1) + '</th><td>' + groupName.name + '</td><td><i class="fas fa-trash-alt removeGroup" style="color:#dd4b28;cursor:pointer" data-group-id="' + groupName.id + '" data-uid="' + userId + '"></i></td></tr>');
                        });

                        var permissionsList = $('.permissions-list');
                        permissionsList.empty();
                        response.permissions.forEach(function(permission) {
                            permissionsList.append('<li>' + permission + '</li>');
                        });
                    }
                },
                error: function() {
                    alert("Error occurred while fetching data.");
                }
            });
        }

        $(document).on('click', '.view_Group_account', function() {
            var userId = $(this).data('uid');
            $('#view_group_Modal').modal('show');
            loadUserGroups(userId);
        });

        $('#employee_groups_select').on('change', function() {
            var selectedValue = $(this).val();
            var userId = $(this).attr('data-uid');
            $.ajax({
                url: "{{ url('user_groups/update_members/add') }}",
                type: "POST",
                data: {
                    user: userId,
                    user_group_members_group_id: selectedValue,
                    _token: $('meta[name="csrf-token"]').attr("content")
                },
                success: function() {
                    loadUserGroups(userId);
                },
                error: function() {
                    alert("Error occurred while fetching data.");
                }
            });
        });

        $(document).on('click', '.removeGroup', function() {
            var groupId = $(this).data('group-id');
            var userId = $(this).data('uid');
            $.ajax({
                url: "{{ url('user_groups/update_members/delete') }}",
                type: "POST",
                data: {
                    user: userId,
                    user_group_members_group_id: groupId,
                    _token: $('meta[name="csrf-token"]').attr("content")
                },
                success: function() {
                    loadUserGroups(userId);
                },
                error: function() {
                    alert("Error occurred while fetching data.");
                }
            });
        });

        // Table layout toggle
        tableLayout();

        function tableLayout() {
            var layout_id = $('#layout_id').val();
            var name = $('#name').is(':checked') ? 1 : 0;
            var email = $('#email').is(':checked') ? 1 : 0;
            var mobile = $('#mobile').is(':checked') ? 1 : 0;
            var user_status = $('#user_status').is(':checked') ? 1 : 0;
            var user_group_name = $('#user_group_name').is(':checked') ? 1 : 0;
            var user_action = $('#user_action').is(':checked') ? 1 : 0;
            var created_at = $('#created_at').is(':checked') ? 1 : 0;
            var updated_at = $('#updated_at').is(':checked') ? 1 : 0;
            var department = $('#department').is(':checked') ? 1 : 0;
            var employment_status = $('#employment_status').is(':checked') ? 1 : 0;
            var job_title = $('#job_title').is(':checked') ? 1 : 0;
            var w_number = $('#w_number').is(':checked') ? 1 : 0;
            var address = $('#address').is(':checked') ? 1 : 0;
            var city = $('#city').is(':checked') ? 1 : 0;
            var country = $('#country').is(':checked') ? 1 : 0;
            var postal_code = $('#postal_code').is(':checked') ? 1 : 0;
            var timezone = $('#timezone').is(':checked') ? 1 : 0;
            var joined_date = $('#joined_date').is(':checked') ? 1 : 0;
            var marital_status = $('#marital_status').is(':checked') ? 1 : 0;
            var gender = $('#gender').is(':checked') ? 1 : 0;
            var nationality = $('#nationality').is(':checked') ? 1 : 0;
            var languages = $('#languages').is(':checked') ? 1 : 0;
            var private_email = $('#private_email').is(':checked') ? 1 : 0;
            // Column index map:
            // 0=ID(always), 1=EMPLOYEE(always), 2=EMAIL, 3=MOBILE, 4=JOB_TITLE, 5=DEPARTMENT, 6=EMP_STATUS, 7=STATUS, 8=GROUPS, 9=ACTIONS, 10=CREATE AT, 11=UPDATED_AT
            employeetable.column(2).visible(!!email);
            employeetable.column(3).visible(!!mobile);
            employeetable.column(4).visible(!!job_title);
            employeetable.column(5).visible(!!department);
            employeetable.column(6).visible(!!employment_status);
            employeetable.column(7).visible(!!user_status);
            employeetable.column(8).visible(!!user_group_name);
            employeetable.column(9).visible(!!user_action);
            employeetable.column(10).visible(!!created_at);
            employeetable.column(11).visible(!!updated_at);
            employeetable.column(12).visible(!!w_number);
            employeetable.column(13).visible(!!address);
            employeetable.column(14).visible(!!city);
            employeetable.column(15).visible(!!country);
            employeetable.column(16).visible(!!postal_code);
            employeetable.column(17).visible(!!timezone);
            employeetable.column(18).visible(!!joined_date);
            employeetable.column(19).visible(!!marital_status);
            employeetable.column(20).visible(!!gender);
            employeetable.column(21).visible(!!nationality);
            employeetable.column(22).visible(!!languages);
            employeetable.column(23).visible(!!private_email);

            $.ajax({
                url: "users/layout",
                type: "POST",
                data: {
                    'layout_id': layout_id,
                    'profile_pic': 0,
                    'name': name,
                    'email': email,
                    'mobile': mobile,
                    'user_role_name': user_status,
                    'user_group_name': user_group_name,
                    'action': user_action,
                    'created_at': created_at,
                    'updated_at': updated_at,
                    'department': department,
                    'employment_status': employment_status,
                    'job_title': job_title,
                    'w_number': w_number,
                    'address': address,
                    'city': city,
                    'country': country,
                    'postal_code': postal_code,
                    'timezone': timezone,
                    'joined_date': joined_date,
                    'marital_status': marital_status,
                    'gender': gender,
                    'nationality': nationality,
                    'languages': languages,
                    'private_email': private_email,
                    '_token': '{{csrf_token()}}'
                },
                success: function(data) {
                    if (data == '"Saved"') {
                        console.log("Layout saved successfully.");
                        window.location.reload(true);
                    } else if (data == '"Updated"') {
                        console.log("Layout updated successfully.");
                    } else {
                        console.error("Unexpected response:", data);
                    }
                }
            });
        }

        // $('#name, #email, #mobile, #user_status, #user_group_name, #user_action, #created_at, #updated_at, #department, #employment_status, #job_title').on('change', function() {
        //     tableLayout();
        // });
        $('#name, #email, #mobile, #user_status, #user_group_name, #user_action, #created_at, #updated_at, #department, #employment_status, #job_title, #joined_date, #w_number, #private_email, #gender, #marital_status, #nationality, #languages, #dob, #address, #city, #country, #postal_code, #timezone, #about').on('change', function() {
            tableLayout();
        });

    });

    function renderEmpPagination(api) {
        var info = api.page.info();
        var total = info.pages;
        var current = info.page; // 0-based
        var wrap = document.getElementById('empPagination');
        var infoEl = document.getElementById('empTableInfo');

        // Info text
        var start = info.start + 1;
        var end = Math.min(info.end, info.recordsDisplay);
        var total_records = info.recordsDisplay;
        infoEl.textContent = 'Showing ' + start + ' to ' + end + ' of ' + total_records + ' entries';

        wrap.innerHTML = '';
        if (total <= 1) return;

        // Prev button
        var prev = document.createElement('button');
        prev.innerHTML = '&#8249;';
        prev.disabled = current === 0;
        prev.addEventListener('click', function() {
            api.page('previous').draw('page');
        });
        wrap.appendChild(prev);

        // Page number buttons
        // Show max 5 page buttons with ellipsis logic
        var pages = [];
        if (total <= 7) {
            for (var i = 0; i < total; i++) pages.push(i);
        } else {
            pages.push(0);
            if (current > 3) pages.push('...');
            var start_p = Math.max(1, current - 2);
            var end_p = Math.min(total - 2, current + 2);
            for (var i = start_p; i <= end_p; i++) pages.push(i);
            if (current < total - 4) pages.push('...');
            pages.push(total - 1);
        }

        pages.forEach(function(pg) {
            if (pg === '...') {
                var dots = document.createElement('button');
                dots.textContent = '…';
                dots.disabled = true;
                dots.style.border = 'none';
                dots.style.background = 'transparent';
                dots.style.cursor = 'default';
                wrap.appendChild(dots);
                return;
            }
            (function(pageNum) {
                var btn = document.createElement('button');
                btn.textContent = pageNum + 1;
                if (pageNum === current) btn.classList.add('active');
                btn.addEventListener('click', function() {
                    api.page(pageNum).draw('page');
                });
                wrap.appendChild(btn);
            })(pg);
        });

        // Next button
        var next = document.createElement('button');
        next.innerHTML = '&#8250;';
        next.disabled = current === total - 1;
        next.addEventListener('click', function() {
            api.page('next').draw('page');
        });
        wrap.appendChild(next);
    }

    function exportReport() {
        var table = $('#employee_summary_table').DataTable();

        // Get visible data (after search/filter)
        var data = table.rows({
            search: 'applied'
        }).data();

        if (data.length === 0) {
            alert("No data to export");
            return;
        }

        var csv = [];

        // Get headers
        var headers = [];
        $('#employee_summary_table thead th').each(function() {
            headers.push($(this).text().trim());
        });
        csv.push(headers.join(','));

        // Get rows
        data.each(function(row) {
            var rowData = row.map(function(cell) {
                // Remove HTML tags (important for your employee column)
                return '"' + String(cell).replace(/<[^>]*>/g, '').replace(/"/g, '""') + '"';
            });
            csv.push(rowData.join(','));
        });

        // Convert to CSV file
        var csvString = csv.join("\n");
        var blob = new Blob([csvString], {
            type: 'text/csv;charset=utf-8;'
        });

        var link = document.createElement("a");
        var url = URL.createObjectURL(blob);
        link.setAttribute("href", url);
        link.setAttribute("download", "employee_report.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function goBackOnePage() {
        if (document.referrer && document.referrer.indexOf(window.location.host) !== -1) {
            window.history.back();
        } else {
            window.location.href = "{{ route('home') }}";
        }
    }
</script>

@endsection
