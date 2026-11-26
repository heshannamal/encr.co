@extends('layouts.app', ['activePage' => 'user_log', 'titlePage' => __('User Logs')])

@section('content')
<style>

#searchbox{
        border: 2px solid #ffffff;
        height: 35px;
        /* width: 250px; */
        width: 100%;
        border-radius: 30px;
        padding: 0px 5px;
        background-color: #ffffff1a;
        margin-top: 10px;
        color: #ffffff;
    }
    #searchbox::placeholder {
        color: #aaaaaa;
        opacity: 1; /* Firefox */
        font-size: 14px;
    }
    #searchbox:focus {
        outline: 0px;
    }
    #searchbox:-ms-input-placeholder { /* Internet Explorer 10-11 */
        color: #aaaaaa;
    }
    #searchbox::-ms-input-placeholder { /* Microsoft Edge */
        color: #aaaaaa;
    }
    .searchbox-position {
        position: relative;
        top: -5px;
    }
    .content-position {
        position: relative;
        top: -25px;
    }
    .right-align {
        text-align: right;
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
    .select2-container--default .select2-selection--single {
        background-color: #fff !important;
        border: 0.5px solid #eaeaea !important;
        border-radius: 5px !important;
    }
    img {
        max-width: 150px;
        max-height: 150px;
    }

    @media (min-width: 769px){
        .back_home_mobile {
            display:none !important;
        }
    }
/* MOBILE ONLY */
@media (max-width: 768px) {
    .org-mobile-cards {
        display: block;
        padding: unset;
    }
    .table-responsive {
        /* display: none; */
    }
    .back_home_mobile {
        /* padding-bottom: 20px; */
        display: block !important;
    }
}
@media (max-width: 768px) {

    /* Default font size - 12px */
    input,
    textarea,
    select,
    .form-control,
    .invoice-inputs,
    .select2-selection__rendered,
    .select2-selection,
    .select2-container .select2-search__field,
    .select2-search__field {
        font-size: 12px !important;
    }

    /* Focused input - 16px */
    input:focus,
    textarea:focus,
    select:focus,
    .form-control:focus,
    .invoice-inputs:focus,
    .select2-container--focus .select2-selection,
    .select2-container--open .select2-selection,
    .select2-container .select2-search__field:focus,
    .select2-search__field:focus {
        font-size: 16px !important;
    }

    /* Select2 selected text */
    .select2-container--focus .select2-selection__rendered,
    .select2-container--open .select2-selection__rendered {
        font-size: 16px !important;
    }
}


/* =========================================
   ACTIVITY LOG FILTER - DESKTOP DEFAULT
========================================= */

.mobile-activity-filter-toggle {
    display: none;
}

.activity-filter-content {
    display: block;
}

.filter_card {
    min-width: 0;
}


/* =========================================
   MOBILE RESPONSIVE DESIGN
========================================= */

@media (max-width: 768px) {

    /* Mobile filter toggle */
    .mobile-activity-filter-toggle {
        display: block;
        position: relative;
        margin-bottom: 12px;
    }

    .mobile-activity-filter-toggle label {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 14px 15px;
        margin: 0;
        background: linear-gradient(135deg, #eef5ff, #f8faff);
        border: 1px solid #d5e3f7;
        border-radius: 10px;
        color: #234b7a;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        box-sizing: border-box;
    }

    .mobile-activity-filter-toggle label .fa-filter {
        color: #3478c7;
        font-size: 17px;
    }

    .mobile-activity-filter-toggle .filter-toggle-icon {
        margin-left: auto;
        transition: transform 0.25s ease;
    }

    /* Hide checkbox visually but keep it functional */
    #activityFilterToggle {
        position: absolute;
        width: 1px;
        height: 1px;
        opacity: 0;
        pointer-events: none;
    }

    /* Expandable filter container */
    .activity-filter-content {
        display: none;
        padding: 16px 12px 4px;
        margin-bottom: 14px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 14px rgba(30, 50, 80, 0.06);
    }

    /* Open filter when toggle is checked */
    .mobile-activity-filter-toggle:has(#activityFilterToggle:checked)
    + .activity-filter-content {
        display: block !important;
    }

    /* Rotate toggle arrow */
    .mobile-activity-filter-toggle:has(#activityFilterToggle:checked)
    .filter-toggle-icon {
        transform: rotate(180deg);
    }

    /* Filter fields: 2 columns */
    .activity-filter-content > .row:first-child {
        display: flex;
        flex-wrap: wrap;
        margin-left: -6px;
        margin-right: -6px;
    }

    .activity-filter-content > .row:first-child > [class*="col-"] {
        flex: 0 0 50% !important;
        width: 50% !important;
        max-width: 50% !important;
        min-width: 0;
        padding-left: 6px;
        padding-right: 6px;
    }

    /* Filter labels */
    .activity-filter-content .form-group {
        margin-bottom: 14px;
    }

    .activity-filter-content .form-group label {
        display: block;
        margin-bottom: 6px;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        line-height: 1.4;
    }

    /* Filter inputs */
    .activity-filter-content .form-control {
        width: 100%;
        min-width: 0;
        height: 42px;
        padding: 7px 8px;
        font-size: 13px;
        border: 1px solid #d7dee8;
        border-radius: 8px;
        box-sizing: border-box;
        box-shadow: none;
    }

    .activity-filter-content .form-control:focus {
        border-color: #6da5e8;
        box-shadow: 0 0 0 3px rgba(52, 120, 199, 0.10);
        outline: none;
    }


    /* =====================================
       SEARCH BUTTON - FULL WIDTH
    ===================================== */

    .activity-filter-content > .row.justify-content-end {
        display: flex;
        margin: 4px 0 8px;
    }

    .activity-filter-content > .row.justify-content-end > .search_button_div {
        flex: 0 0 100% !important;
        width: 100% !important;
        max-width: 100% !important;
        padding: 0;
        margin-top: 0 !important;
    }

    .activity-filter-content .search_button_div .form-group {
        margin-bottom: 8px;
    }

    .activity-filter-content .search_button_button {
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 100% !important;
        min-height: 46px;
        padding: 10px 12px;
        background-color: #41C98B;
        border-color: #41C98B;
        color: #ffffff;
        font-size: 14px;
        font-weight: 600;
        border-radius: 8px;
    }


    /* =====================================
       ACTION BUTTONS
       Row 1: Delete Selected | Delete Filtered
       Row 2: Export (full width)
    ===================================== */

    .filter_card > form > .row:last-child {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
        margin: 12px 0 0;
    }

    .filter_card > form > .row:last-child > [class*="col-"] {
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0;
        padding: 0 !important;
        margin: 0;
    }

    .filter_card > form > .row:last-child .form-group {
        height: 100%;
        margin-bottom: 0;
    }

    .filter_card > form > .row:last-child button {
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 100% !important;
        min-height: 46px;
        height: 100%;
        padding: 8px 5px;
        font-size: 12px;
        font-weight: 600;
        line-height: 1.35;
        text-align: center;
        white-space: normal;
        overflow-wrap: anywhere;
        border-radius: 8px;
        box-sizing: border-box;
    }

    /* Export button spans both columns */
    .filter_card > form > .row:last-child > div:has(#export) {
        grid-column: 1 / -1;
    }

    .filter_card > form > .row:last-child #export {
        width: 100% !important;
        min-height: 46px;
    }
}


/* =========================================
   USER ACTIVITY LOG - MOBILE CARD VIEW
   Desktop table remains unchanged
========================================= */

@media screen and (max-width: 768px) {

    /* =====================================
       CONTAINER
    ===================================== */

    .mobile_card_body {
        padding: 10px !important;
    }

    .mobile_table_responsive {
        overflow-x: visible !important;
        border: none !important;
    }

    /* =====================================
       SELECT ALL
    ===================================== */

    #user_log_table thead {
        display: block !important;
        width: 100% !important;
        margin-bottom: 12px !important;
        background: transparent !important;
    }

    #user_log_table thead tr {
        display: block !important;
        background: transparent !important;
        border: none !important;
    }

    #user_log_table thead th {
        display: none !important;
    }

    #user_log_table thead th:first-child {
        display: inline-flex !important;
        align-items: center;
        gap: 8px;
        width: fit-content !important;
        padding: 8px 12px !important;
        border: none !important;
        border-radius: 8px;
        color: #000 !important;
        font-size: 13px;
        font-weight: 600;
    }

    #user_log_table thead th:first-child::after {
        content: "Select All";
    }

    #user_log_table thead th:first-child input[type="checkbox"] {
        width: 17px;
        height: 17px;
        margin: 0 !important;
        cursor: pointer;
        accent-color: #3478f6;
    }

    /* =====================================
       TABLE
    ===================================== */

    #user_log_table,
    #user_log_table tbody {
        display: block !important;
        width: 100% !important;
        min-width: 0 !important;
        border: none !important;
        background: transparent !important;
    }

    /* =====================================
       AUDIT CARD - FLEXBOX
    ===================================== */

    #user_log_table tbody tr {
        display: flex !important;
        flex-wrap: wrap !important;
        align-items: flex-start;
        width: 100% !important;
        margin: 0 0 14px !important;
        padding: 14px !important;
        background: #fff !important;
        border: 1px solid #e1e7ef !important;
        border-radius: 12px !important;
        box-shadow: 0 3px 10px rgba(30, 50, 80, 0.06);
        box-sizing: border-box;
    }

    #user_log_table tbody td {
        display: block !important;
        flex: 0 0 100%;
        width: 100% !important;
        min-width: 0 !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 10px 0 !important;
        border: none !important;
        /* border-bottom: 1px solid #edf0f5 !important; */
        background: transparent !important;
        color: #64748b !important;
        font-size: 13px !important;
        line-height: 1.5;
        overflow-wrap: anywhere;
        white-space: normal !important;
        box-sizing: border-box;
    }

    /* =====================================
       HEADER: CHECKBOX + USER + DATE
       Flexbox, no grid
    ===================================== */

    /* Checkbox */
    #user_log_table tbody td:nth-child(1) {
        flex: 0 0 24px !important;
        width: 24px !important;
        padding: 2px 0 0 !important;
        border: none !important;
    }

    #user_log_table tbody td:nth-child(1) input[type="checkbox"] {
        width: 17px;
        height: 17px;
        margin: 2px 0 0 !important;
        cursor: pointer;
        accent-color: #3478f6;
    }

    /* User name */
    #user_log_table tbody td:nth-child(3) {
        flex: 1 1 calc(100% - 24px) !important;
        width: calc(100% - 24px) !important;
        padding: 0 0 3px !important;
        border: none !important;
        color: #000 !important;
        font-size: 14px !important;
        font-weight: 700 !important;
        line-height: 1.4;
    }

    /* Date and time */
    #user_log_table tbody td:nth-child(2) {
        flex: 0 0 100% !important;
        width: 100% !important;
        padding: 0 0 10px 26px !important;
        border-bottom: 1px solid #edf0f5 !important;
        color: #64748b !important;
        font-size: 11px !important;
    }

    #user_log_table tbody td:nth-child(2)::before {
        content: "\f017";
        font-family: "Font Awesome 5 Free";
        font-weight: 400;
        margin-right: 5px;
        color: #94a3b8;
    }

    /* =====================================
       EVENT
    ===================================== */

    #user_log_table tbody td:nth-child(4) {
        flex: 0 0 100% !important;
        width: 100% !important;
        font-weight: 600 !important;
    }

    #user_log_table tbody td:nth-child(4)::before {
        content: "EVENT";
        display: block;
        margin-bottom: 4px;
        color: #000 !important;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.7px;
    }

    /* =====================================
       MODULE + ID
    ===================================== */

    #user_log_table tbody td:nth-child(5),
    #user_log_table tbody td:nth-child(6) {
        flex: 1 1 50% !important;
        width: 50% !important;
        min-width: 0 !important;
        overflow-wrap: anywhere;
    }

    #user_log_table tbody td:nth-child(5) {
        padding-right: 8px !important;
    }

    #user_log_table tbody td:nth-child(6) {
        padding-left: 8px !important;
    }

    #user_log_table tbody td:nth-child(5)::before {
        content: "MODULE";
    }

    #user_log_table tbody td:nth-child(6)::before {
        content: "ID";
    }

    /* =====================================
       SOURCE + UPDATES
    ===================================== */

    #user_log_table tbody td:nth-child(7),
    #user_log_table tbody td:nth-child(8) {
        flex: 1 1 50% !important;
        width: 50% !important;
        min-width: 0 !important;
        overflow-wrap: anywhere;
    }

    #user_log_table tbody td:nth-child(7) {
        padding-right: 8px !important;
    }

    #user_log_table tbody td:nth-child(8) {
        padding-left: 8px !important;
    }

    #user_log_table tbody td:nth-child(7)::before {
        content: "SOURCE";
    }

    #user_log_table tbody td:nth-child(8)::before {
        content: "UPDATES";
    }

    /* Field labels */
    #user_log_table tbody td:nth-child(5)::before,
    #user_log_table tbody td:nth-child(6)::before,
    #user_log_table tbody td:nth-child(7)::before,
    #user_log_table tbody td:nth-child(8)::before {
        display: block;
        margin-bottom: 5px;
        color: #000 !important;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.7px;
    }

    /* Lists */
    #user_log_table tbody td ul {
        max-width: 100%;
        margin: 0 !important;
        padding-left: 16px !important;
    }

    #user_log_table tbody td li {
        max-width: 100%;
        margin-bottom: 4px;
        color: #64748b !important;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    /* =====================================
       VIEW DETAILS
    ===================================== */

    #user_log_table tbody td:nth-child(9) {
        flex: 0 0 100% !important;
        width: 100% !important;
        display: flex !important;
        align-items: center;
        justify-content: flex-end;
        min-height: 45px;
        padding: 8px 0 0 !important;
        border-bottom: none !important;
    }

    #user_log_table tbody td:nth-child(9)::before {
        content: "VIEW DETAILS";
        margin-right: auto;
        color: #000 !important;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.7px;
    }

    #user_log_table tbody td:nth-child(9) button {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        padding: 0 !important;
        margin: 0 0 0 6px !important;
        border: 1px solid #d7e6fb !important;
        border-radius: 9px !important;
        background: #eef5ff !important;
        color: #3478c7 !important;
        font-size: 15px;
        box-shadow: none !important;
    }

    #user_log_table tbody td:nth-child(9) button:disabled {
        background: #f1f5f9 !important;
        border-color: #e2e8f0 !important;
        color: #94a3b8 !important;
        opacity: 0.8;
    }

    /* =====================================
       PAGINATION
    ===================================== */

    .mobile_card_body > .col-md-12.mt-2 {
        width: 100%;
        padding: 0 !important;
        margin-top: 12px !important;
    }

    .mobile_card_body > .col-md-12.mt-2 > div {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        float: none !important;
        width: 100%;
    }
}

@media screen and (max-width: 768px) {

    /* Checkbox - left side */
    #user_log_table tbody td:nth-child(1) {
        order: 1 !important;
        flex: 0 0 24px !important;
        width: 24px !important;
        padding: 2px 0 0 !important;
        border: none !important;
    }

    #user_log_table tbody td:nth-child(1) input[type="checkbox"] {
        width: 17px;
        height: 17px;
        margin: 2px 0 0 !important;
        cursor: pointer;
        accent-color: #3478f6;
    }

    /* Username - right next to checkbox */
    #user_log_table tbody td:nth-child(3) {
        order: 2 !important;
        flex: 1 1 calc(100% - 24px) !important;
        width: calc(100% - 24px) !important;
        padding: 0 0 3px !important;
        margin: 0 !important;
        border: none !important;
        color: #000 !important;
        font-size: 14px !important;
        font-weight: 700 !important;
        line-height: 1.4;
        align-self: flex-start;
    }

    /* Date/time - below username, aligned with username */
    #user_log_table tbody td:nth-child(2) {
        order: 3 !important;
        flex: 0 0 100% !important;
        width: 100% !important;
        padding: 0 0 10px 32px !important;
        margin: 0 !important;
        border-bottom: 1px solid #edf0f5 !important;
        color: #64748b !important;
        font-size: 11px !important;
    }

    /* Keep remaining fields in their correct order */
    #user_log_table tbody td:nth-child(4) {
        order: 4 !important;
    }

    #user_log_table tbody td:nth-child(5) {
        order: 5 !important;
    }

    #user_log_table tbody td:nth-child(6) {
        order: 6 !important;
    }

    #user_log_table tbody td:nth-child(7) {
        order: 7 !important;
    }

    #user_log_table tbody td:nth-child(8) {
        order: 8 !important;
    }

    #user_log_table tbody td:nth-child(9) {
        order: 9 !important;
    }
}


/* =========================================
   USER LOG DETAIL MODAL
========================================= */

#viewUserLogModal .user-log-modal-dialog {
    max-width: 850px;
    width: calc(100% - 30px);
}

#viewUserLogModal .modal-content {
    overflow: hidden;
    border-radius: 16px !important;
    box-shadow: 0 15px 50px rgba(15, 23, 42, 0.18);
    background: #ffffff;
}

#viewUserLogModal .user-log-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 20px 24px;
    background: linear-gradient(135deg, #f4f7ff, #ffffff);
    border-bottom: 1px solid #e8edf5;
}

#viewUserLogModal .user-log-title-wrap {
    display: flex;
    align-items: center;
    gap: 13px;
    min-width: 0;
}

#viewUserLogModal .user-log-icon {
    width: 44px;
    height: 44px;
    flex: 0 0 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: #e5edff;
    color: #315bd6;
    font-size: 19px;
}

#viewUserLogModal .modal-title {
    font-size: 18px;
    font-weight: 700;
    color: #172033;
    line-height: 1.4;
}

#viewUserLogModal .user-log-title-wrap small {
    display: block;
    margin-top: 3px;
    color: #718096;
    font-size: 12px;
}

#viewUserLogModal .user-log-header-close {
    float: none;
    padding: 0;
    border: 0;
    background: transparent;
    color: #64748b;
    font-size: 28px;
    line-height: 1;
    opacity: 1;
}

#viewUserLogModal .user-log-header-close:hover {
    color: #1d4ed8;
}

#viewUserLogModal .modal-body {
    padding: 24px;
    max-height: 65vh;
    overflow-y: auto;
    overflow-x: hidden;
    color: #475569;
}

/* AJAX-loaded content */
#viewUserLogModal #user_log_detail_modal_body > * {
    max-width: 100%;
}

#viewUserLogModal #user_log_detail_modal_body .row {
    margin-left: 0;
    margin-right: 0;
}

#viewUserLogModal #user_log_detail_modal_body h5,
#viewUserLogModal #user_log_detail_modal_body h6 {
    color: #1e293b;
    font-weight: 700;
    overflow-wrap: anywhere;
}

#viewUserLogModal #user_log_detail_modal_body hr {
    border: 0;
    border-top: 1px solid #e8edf5;
    margin-top: 10px;
    margin-bottom: 14px;
}

#viewUserLogModal #user_log_detail_modal_body .row.mb-5 {
    margin-bottom: 24px !important;
}

#viewUserLogModal #user_log_detail_modal_body [class*="col"] {
    min-width: 0;
    overflow-wrap: anywhere;
    word-break: break-word;
}

#viewUserLogModal .user-log-modal-footer {
    padding: 14px 24px;
    background: #f8fafc;
    border-top: 1px solid #e8edf5;
}

#viewUserLogModal .user-log-close-btn {
    min-width: 100px;
    padding: 9px 18px;
    border: 1px solid #dbe3ef;
    border-radius: 9px;
    background: #ffffff;
    color: #334155;
    font-weight: 600;
}

#viewUserLogModal .user-log-close-btn:hover {
    background: #edf2ff;
    border-color: #c7d5ff;
    color: #244dc5;
}


/* =========================================
   MOBILE RESPONSIVE
========================================= */

@media (max-width: 767.98px) {

    #viewUserLogModal {
        padding: 0 !important;
    }

    #viewUserLogModal .user-log-modal-dialog {
        width: auto;
        max-width: none;
        margin: 10px;
        min-height: calc(100% - 20px);
        display: flex;
        align-items: center;
    }

    #viewUserLogModal .modal-content {
        width: 100%;
        max-height: calc(100dvh - 20px);
        border-radius: 14px !important;
    }

    #viewUserLogModal .user-log-modal-header {
        padding: 15px 16px;
        gap: 8px;
    }

    #viewUserLogModal .user-log-title-wrap {
        gap: 10px;
    }

    #viewUserLogModal .user-log-icon {
        width: 38px;
        height: 38px;
        flex-basis: 38px;
        border-radius: 10px;
        font-size: 16px;
    }

    #viewUserLogModal .modal-title {
        font-size: 15px;
    }

    #viewUserLogModal .user-log-title-wrap small {
        font-size: 11px;
        line-height: 1.4;
    }

    #viewUserLogModal .user-log-header-close {
        font-size: 26px;
        flex: 0 0 auto;
        margin: -1.25rem -0.25rem -1.25rem 4px;
    }

    #viewUserLogModal .modal-body {
        padding: 16px 14px;
        max-height: calc(100dvh - 155px);
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Stack old/new values vertically on mobile */
    #viewUserLogModal #user_log_detail_modal_body .row {
        display: flex;
        flex-wrap: unset;
    }

    #viewUserLogModal #user_log_detail_modal_body [class*="col-"] {
        max-width: 100%;
    }

    #viewUserLogModal #user_log_detail_modal_body h5,
    #viewUserLogModal #user_log_detail_modal_body h6 {
        font-size: 14px;
        line-height: 1.5;
    }

    #viewUserLogModal #user_log_detail_modal_body hr {
        margin-top: 7px;
        margin-bottom: 12px;
    }

    #viewUserLogModal #user_log_detail_modal_body .row.mb-5 {
        margin-bottom: 22px !important;
    }

    #viewUserLogModal .user-log-modal-footer {
        padding: 12px 14px;
    }

    #viewUserLogModal .user-log-close-btn {
        width: 100%;
        min-height: 42px;
    }
        .mobile_padding_unset {
        padding: unset !important;
    }
}

/* Very small phones */
@media (max-width: 380px) {

    #viewUserLogModal .user-log-modal-dialog {
        margin: 6px;
    }

    #viewUserLogModal .user-log-modal-header {
        padding: 12px;
    }

    #viewUserLogModal .modal-body {
        padding: 13px 11px;
    }

    #viewUserLogModal .modal-title {
        font-size: 14px;
    }
    .mobile_padding_unset {
        padding: unset !important;
    }
}


</style>

<div class="container-fluid content-position">
    <div class="se-pre-con"></div>

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    @section('order-header')
        <span>User Activity Logs</span>
    @endsection

    @section('back-btn-Mobile')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">< BACK</a>
    @endsection

    <div class="col-md-12 back_home_mobile">
        <strong>
            {{-- @yield('back-btn-Mobile') --}}
        </strong>
    </div>

    {{-- <div class="col-md-12 mt-4">
        <div class="card">
            <div class="row searchbox-position">
                <div class="col-md-6"></div>
                <div class="col-md-6 right-align" >
                    <input type="text" id="searchbox" placeholder="Causer Name Search" style="width: 68%;margin-right: 20px; border-radius: 5px; border: 0.125rem solid #787878; color: #787878; position: relative; right: 20px;">
                </div>
            </div>
        </div>
    </div> --}}
    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-body filter_card">
                <form action="{{ route('user_log.index') }}" method="GET">
                    <!-- Mobile filter toggle -->
                    <div class="mobile-activity-filter-toggle">
                        <input type="checkbox" id="activityFilterToggle">

                        <label for="activityFilterToggle">
                            <i class="fa fa-filter"></i>
                            Filter activity logs
                            <i class="fa fa-chevron-down filter-toggle-icon"></i>
                        </label>
                    </div>

                    <div class="activity-filter-content">

                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start_date">Select Start Date</label>
                                    {{-- <input type="date" class="form-control" name="std" id="std"
                                        value="{{ $std }}" max="<?= date('Y-m-d') ?>" required> --}}
                                        <input type="text" class="form-control datepicker" name="std" id="std" value="{{ Carbon\Carbon::parse($std)->format('m/d/Y') }}"
                                        max="<?= date('m/d/Y') ?>" required/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="end_date">Select End Date</label>
                                    {{-- <input type="date" class="form-control" name="end" id="end"
                                        value="{{ $end }}" max="<?= date('Y-m-d') ?>" required> --}}
                                        <input type="text" class="form-control datepicker" name="end" id="end" value="{{ Carbon\Carbon::parse($end)->format('m/d/Y') }}"
                                        max="<?= date('m/d/Y') ?>" required/>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="user_id">Select a User</label>
                                    <select name="user_id" id="user_id" class="form-control">
                                        <option value="">All User logs</option>
                                        <option value="customer" @if ($userId == 'customer') selected @endif>Customer</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($userId == $user->id) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sr_event">Search by Event</label>
                                    <select name="sr_event" id="sr_event" class="form-control">
                                        <option value="">All</option>
                                        <option @if ($sr_event == "created") selected @endif value="created">Created</option>
                                        <option @if ($sr_event == "updated") selected @endif value="updated">Updated</option>
                                        <option @if ($sr_event == "deleted") selected @endif value="deleted">Deleted</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sr_module">Search by Module</label>
                                    <select name="sr_module" id="sr_module" class="form-control">
                                        <option value="">All Modules</option>
                                        @foreach ($auditableModels as $auditableModel)
                                            <option value="{{ $auditableModel }}"
                                                @if ($sr_module == $auditableModel) selected @endif>
                                                {{ last(explode('\\', $auditableModel)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sr_id">Search by ID</label>
                                    <input type="number" class="form-control" name="sr_id" id="sr_id" step="0"
                                        value="{{ $sr_id }}" placeholder="Enter text for serach">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sr_text">Search by Source</label>
                                    <input type="text" class="form-control" name="sr_text" id="sr_text"
                                        value="{{ $sr_text }}" placeholder="Enter text for serach">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sr_update">Search by Updates</label>
                                    <input type="text" class="form-control" name="sr_update" id="sr_update"
                                        value="{{ $sr_update }}" placeholder="Enter text for serach">
                                </div>
                            </div>

                        </div>


                        <div class="row justify-content-end">
                            <div class="col-md-2 mt-4 search_button_div">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary form-control d-flex d-md-block search_button_button"><i
                                            class="bi bi-search pe-2 px-1"></i> Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        @can('delete user logs')
                            <div class="col-md-2 col-sm-6 ">
                                <div class="form-group mb-0">
                                    <button type="button" class="btn btn-warning form-control d-flex d-md-block" id="delete_selected"> Delete Selected</button>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-6 ">
                                <div class="form-group mb-0">
                                    <button type="button" class="btn btn-google-plus form-control d-flex d-md-block" id="delete_filtered"> Delete Filtered</button>
                                </div>
                            </div>
                        @endcan
                        <div class="col-md-2 col-sm-6 ">
                            <div class="form-group mb-0">
                                <button type="button" class="btn btn-success form-control d-flex d-md-block" id="export">
                                    <i class="fa fa-download pe-2 px-1" ></i> Export</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form action="{{ route('user_log.export') }}" method="POST" id="export_form">
        @csrf
        <input type="hidden" name="user_id" id="export_user_id">
        <input type="hidden" name="std" id="export_std">
        <input type="hidden" name="end" id="export_end">
        <input type="hidden" name="sr_event" id="export_sr_event">
        <input type="hidden" name="sr_module" id="export_sr_module">
        <input type="hidden" name="sr_id" id="export_sr_id">
        <input type="hidden" name="sr_text" id="export_sr_text">
        <input type="hidden" name="sr_update" id="export_sr_update">
    </form>

    <div class="col-md-12 mt-4">
        <div class="card">
            {{-- <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="float-left header-title">Activity Logs</h1>
                        </div>
                        <div class="col-md-6 header-icons justify-content-end">
                            <div style="width: 100%;justify-content: flex-end;display: flex">
                                <input type="text" id="searchbox" placeholder="Causer Name Search" style="width: 50%;margin-right: 20px">
                                <span>
                                    <a class="btn btn-round" href="#" data-toggle="modal" data-target="#layout_modal">
                                        <i class="fas fa-wrench"></i>
                                    </a>
                                    <p>Table Layout</p>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="card-body mobile_card_body">
                <div class="col-md-12 mobile_padding_unset">
                    <div class="table-responsive mobile_table_responsive">
                        <table class="table align-items-center table-bordered" id="user_log_table">
                            <thead class="bg-theme">
                                <tr>
                                    <th scope="col" class="">
                                        <input type="checkbox" id='chk_all' class="chkAll">
                                    </th>
                                    <th scope="col" class="">Date & Time</th>
                                    <th scope="col" class="">User</th>
                                    <th scope="col" class="">Event</th>
                                    <th scope="col" class="">Module</th>
                                    <th scope="col" class="">ID</th>
                                    <th scope="col" class="">Source</th>
                                    <th scope="col" class="">Updates</th>
                                    <th scope="col" class="">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="tableBody">
                                @foreach ($audits as $audit)
                                    @if (!empty($audit->new_values))
                                        <tr>
                                            <td>
                                                <input type="checkbox" id='chk_item_{{ $audit->id }}' class="chkItemChild" value="{{ $audit->id }}">
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($audit->created_at)->format('m/d/Y - H:i') }}
                                            </td>
                                            <td>{{ $audit->user_id && $audit->user ? $audit->user->name : 'Customer' }}</td>
                                            <td>{{ ucfirst($audit->event) }}</td>
                                            <td>
                                                @php
                                                    $str = $audit->auditable_type;
                                                    $newstr = explode('\\', $str);
                                                @endphp
                                                {{ end($newstr) }}
                                            </td>
                                            <td>{{ $audit->auditable_id ?? '' }}</td>
                                            <td>
                                                @php
                                                    $sourceArr = [];
                                                    $sources = $audit->source;
                                                    if($sources){
                                                        $sourceArr = json_decode($sources);
                                                    }
                                                @endphp
                                                <ul>
                                                    @foreach ($sourceArr as $key=>$sr)
                                                        @if ($sr == 'Customer Changes')
                                                            <li>{{ $sr }}</li>
                                                        @else
                                                            <li>{{ $key.' - '.$sr }}</li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                @if ($audit->event == 'updated')
                                                    <ul>
                                                        @foreach ($audit->getModified() as $key => $auditUpdate)
                                                            <li>{{ ucfirst(str_replace('_', ' ', $key)) }}</li>
                                                        @endforeach
                                                    </ul>
                                                {{-- @elseif ($audit->event == 'created')
                                                    @foreach ($audit->getModified() as $key => $auditUpdate)
                                                        @if ($key == 'name' || $key == 'title' || $key == 'task_name')
                                                            {{ $auditUpdate['new'] }}
                                                        @endif
                                                    @endforeach
                                                @elseif ($audit->event == 'deleted')
                                                    @foreach ($audit->getModified() as $key => $auditUpdate)
                                                        @if ($key == 'name' || $key == 'title' || $key == 'task_name')
                                                            {{ $auditUpdate['old'] }}
                                                        @endif
                                                    @endforeach --}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($audit->event == 'updated')
                                                    @if (array_key_exists('password', $audit->getModified()) || array_key_exists('remember_token', $audit->getModified()))
                                                        <button type="button"
                                                            class="btn  btn-sm" disabled><i
                                                                class="fas fa-eye-slash"></i></button>
                                                    @else
                                                        <button type="button"
                                                            class="btn  btn-sm view"
                                                            value="{{ $audit->id }}"><i
                                                                class="fas fa-eye"></i></button>
                                                    @endif
                                                @elseif ($audit->event == 'created')
                                                <button type="button"
                                                            class="btn  btn-sm view_creted"
                                                            value="{{ $audit->id }}"><i
                                                                class="fas fa-eye"></i></button>
                                                    {{-- @php
                                                        $str = $audit->auditable_type;
                                                        $newstr = explode('\\', $str);
                                                    @endphp
                                                    @if (end($newstr) == 'DivisionPost')
                                                        <a href="{{ url('division-inner', $audit->auditable_id) }}"
                                                            target="_blank"
                                                            class="btn  btn-sm view"><i
                                                                class="fas fa-eye"></i></a>
                                                    @else
                                                        <a href="{{ $audit->url }}" target="_blank"
                                                            class="btn btn-sm view"><i
                                                                class="fas fa-eye"></i></a>
                                                    @endif --}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="col-md-12 mt-2">
                    <div style="float: right">
                        {{ $audits->onEachSide(5)->withQueryString()->links('layouts.paginationlinks') }}
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@include('pages.user_log.modals.view')

<script>
    function showEmptyFieldsOnMobile() {
    $('#user_log_table tbody tr').each(function () {
        $(this).find('td').each(function () {
            let cell = $(this);

            // Checkbox / button / link fields skip කරන්න
            if (cell.find('input, button, a, select, textarea').length > 0) {
                return;
            }

            // Original value එක save කරගන්න
            if (cell.data('original-content') === undefined) {
                cell.data('original-content', cell.html());
            }

            if (window.innerWidth <= 768) {
                if (cell.text().trim() === '') {
                    cell.text('_');
                }
            } else {
                cell.html(cell.data('original-content'));
            }
        });
    });
}

$(document).ready(function () {
    showEmptyFieldsOnMobile();

    $(window).on('resize', function () {
        showEmptyFieldsOnMobile();
    });
});

</script>
        <script>
            var userTable;

            function dismissModal() {
                $('.modal').modal('hide');
            }

            $(document).ready(function() {

                $(".se-pre-con").fadeOut();

                userTable = $('#user_log_table').DataTable({
                    "order": [1, 'desc'],
                    'columnDefs': [{
                        'targets': [5],
                        'orderable': false,
                    },{
                        'targets': [0],
                        'orderable': false,
                    }],
                    "searching": false,
                    "paging": false,
                    "info": false,
                    "lengthChange": false,
                    "pageLength": 50,
                });
                $('.datepicker').datepicker({ minDate: 0});

                $('#user_id').select2({
                    allowClear: true,
                    placeholder: 'All User logs'
                });

                $('#sr_module').select2({
                    allowClear: true,
                    placeholder: 'All Modules'
                });

                $('select').each(function() {
                    if ($(this).val()) {
                        $(this).trigger('change');
                    }
                });
            });

            // $('body').on('click', '.view', function(){
            //     $('#viewUserLogModal').modal('show');
            // });

            $('body').on('click', '.view', function() {
                var auditId = $(this).val();
                viewAuditDetail(auditId, 'view');
            });

            $('body').on('click', '.view_creted', function() {
                var auditId = $(this).val();
                viewAuditDetail(auditId, 'view_creted');
            });

            function viewAuditDetail(auditId, type){
                $.ajax({
                    url: "{{ url('user_log/get_detail') }}/" + auditId + "/" + type,
                    method: "GET",
                    // dataType: "json",
                    success: function(data) {
                        console.log(data);

                        $('#user_log_detail_modal_body').html('');
                        if (data) {
                            // $.each(data, function(field, value) {
                            //     field = field.replace(/_/g, " ");
                            //     var col = '';
                            //     if (type == 'view') {
                            //         col += '<div class="row">';
                            //         col += '<div class="col">';
                            //         col += '<h5 class="text-capitalize">' + field + '</h5>';
                            //         col += '<hr style="margin-top: inherit; margin-bottom: 0.5rem;"> ';
                            //         col += '<div class="row">';
                            //         col += '<div class="col-md-2 text-right" style="padding-right: 2rem; font-weight: bold;"> New : </div>';
                            //         col += '<div class="col-md-10" style="font-weight: bold;"> ' + value.new + ' </div>';
                            //         col += '</div>';
                            //         col += '<div class="row mb-5">';
                            //         col += '<div class="col-md-2 text-right" style="padding-right: 2rem;"> Previous : </div>';
                            //         col += '<div class="col-md-10"> ' + value.old + ' </div>';
                            //         col += '</div>';
                            //         col += '</div>';
                            //         col += '</div>';
                            //     } else {
                            //         // col += '<div class="row">';
                            //         // col += '<div class="col">';
                            //         // col += '<h5 class="text-capitalize">' + field + '</h5>';
                            //         // col += '<hr style="margin-top: inherit; margin-bottom: 0.5rem;"> ';
                            //         if(field != 'id'){
                            //             col += '<div class="row mb-1">';
                            //             col += '<div class="col-md-2 d-flex justify-content-end text-right" style="font-weight: bold;"><h5 class="text-capitalize">' + field + '</h5></div>';
                            //             col += '<div class="" style="font-weight: bold;">:</div>';
                            //             col += '<div class="col-md-9" style="font-weight: bold;"> ' + value.new + ' </div>';
                            //             col += '</div>';
                            //         }
                            //         // col += '</div>';
                            //         // col += '</div>';
                            //     }


                            //     $(col).appendTo('#user_log_detail_modal_body');
                            // });
                            $(data).appendTo('#user_log_detail_modal_body');
                            $('#viewUserLogModal').modal('show');
                        }
                    },
                });
            }

            $('#export').click(function(){
                console.log('export click');

                $('#export_user_id').val($('#user_id').val());
                $('#export_std').val($('#std').val());
                $('#export_end').val($('#end').val());
                $('#export_sr_event').val($('#sr_event').val());
                $('#export_sr_module').val($('#sr_module').val());
                $('#export_sr_id').val($('#sr_id').val());
                $('#export_sr_text').val($('#sr_text').val());
                $('#export_sr_update').val($('#sr_update').val());
                $('#export_form').submit();
            });

            $('#chk_all').click(function() {
                if($(this).prop('checked') == true){
                    $('.chkItemChild').prop('checked', true);
                } else {
                    $('.chkItemChild').prop('checked', false);
                }
            });

            $('.chkItemChild').click(function() {
                var checkedItemCount = $(".chkItemChild:checked").length;
                var itemCount = $(".chkItemChild").length;

                if(checkedItemCount > 0) {
                    if(checkedItemCount == itemCount){
                        $('#chk_all').prop('indeterminate', false);
                        $('#chk_all').prop('checked', true);
                    } else {
                        $('#chk_all').prop('indeterminate', true);
                    }
                } else {
                    $('#chk_all').prop('indeterminate', false);
                    $('#chk_all').prop('checked', false);
                }
            });

            $('#delete_selected').click(function() {
                console.log('slected');

                var checkedItem = $(".chkItemChild:checked");
                var auditIdArr = [];
                console.log(checkedItem);

                if(checkedItem.length > 0) {
                    checkedItem.each(function() {
                        auditIdArr.push($(this).val());
                    });
                    console.log(auditIdArr);

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to delete? This can't be reverted!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Delete!'
                    }).then((result) => {
                        if (result.value) {
                            deleteAudits(auditIdArr, null, null, null, null, 'selected');
                        }
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        'Please select at least one item!',
                        'error'
                    )
                }
            });

            $('#delete_filtered').click(function() {
                var fltUserId = $('#user_id').val();
                var fltStd = $('#std').val();
                var fltEnd = $('#end').val();
                var fltSrText = $('#sr_text').val();

                if(fltStd == ''){
                    Swal.fire(
                        'Error!',
                        'Please Select Start Date!',
                        'error'
                    );
                    return false;
                }

                if(fltEnd == ''){
                    Swal.fire(
                        'Error!',
                        'Please Select End Date!',
                        'error'
                    );
                    return false;
                }

                Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to delete? This can't be reverted!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Delete!'
                    }).then((result) => {
                        if (result.value) {
                            deleteAudits([], fltUserId, fltStd, fltEnd, fltSrText, 'filtered');
                        }
                    });

            });

            function deleteAudits(auditIdArr, fltUserId, fltStd, fltEnd, fltSrText, actionType)
            {
                console.log(auditIdArr);
                console.log(fltUserId);
                console.log(fltStd);
                console.log(fltEnd);
                console.log(fltSrText);
                console.log(actionType);

                $.ajax({
                    url:"{{ url('user_log/delete') }}",
                    method:"POST",
                    dataType:"json",
                    data:{
                        'audit_ids':auditIdArr,
                        'action_type':actionType,
                        'user_id':fltUserId,
                        'start_date':fltStd,
                        'end_date':fltEnd,
                        'search_text':fltSrText,
                        '_token':'{{csrf_token()}}'
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn();
                    },
                    success: function (response) {
                        console.log(response);
                        if(response.response == 'success'){
                            location.reload();
                        } else {
                            $(".se-pre-con").fadeOut();
                            Swal.fire(
                                response.title,
                                response.message,
                                response.response
                            )
                        }
                    }
                })
            }

            //form validation
            function validateForm(form) {
                var isValid = new Boolean();
                isValid = true;

                var elems = $(form).find(':input');
                $.each(elems, function() {
                    var elem = $(this);

                    if (typeof $(elem).attr('required') != typeof undefined && $(elem).attr('required') != "false" && $(
                            elem).val().trim() == "") {
                        Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: $(elem).attr('data-empty-message'),
                            })
                            .then((value) => {
                                $("#" + $(elem).attr('data-focus')).focus();
                            });
                        isValid = false;

                        return false;
                    }
                });

                return isValid;
            }
        </script>

@endsection
