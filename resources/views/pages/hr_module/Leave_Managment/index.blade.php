@extends('layouts.app', ['activePage' => 'Leave_Managment', 'titlePage' => __('Leave Managment')])

@section('content')
<style>
    .nav-link {
        border: none;
    }

    .nav-link.active {
        border-color: transparent !important;
        background-color: transparent !important;
        border-bottom: 2px solid#000000 !important;
        color: #000000 !important;
    }

    .nav-tabs {
        border-bottom: 1px solid #dee2e6 !important;
    }

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
        border-radius: 20px;
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

    .select-border-style {
        border: 1px solid #b3b3b3 !important;
        border-radius: 0rem !important;
    }

    .select2-selection--single {
        background-color: #F8F8F8 !important;
    }

    .d_flex_and_align_center {
        display: flex;
        align-items: center;
    }

    .select-width-style .select2.select2-container.select2-container--default {
        width: 8rem !important;
    }

    .select-width-style-item .select2.select2-container.select2-container--default {
        width: 10rem !important;
    }

    .page-item .page-link,
    .page-item span {
        border-radius: 0 !important;
        font-size: 0.7rem;
    }

    .page-item.active .page-link {
        z-index: 1;
        color: grey;
        border-color: #cccccc;
        background-color: #e9e9e9;
        box-shadow: none;
    }

    .table thead th,
    .table tbody td {
        padding-top: 0;
        padding-bottom: 0;
    }

    .table tbody td {
        padding-top: 7.5px;
        padding-bottom: 7.5px;
    }

    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_asc_disabled:before,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:before,
    table.dataTable thead .sorting_desc_disabled:after {
        bottom: 0.6rem !important;
    }

    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:after {
        right: .7rem !important;
    }

    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_asc_disabled:before,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:before,
    table.dataTable thead .sorting_desc_disabled:after {
        bottom: .65em;
    }

    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_asc_disabled:before,
    table.dataTable thead .sorting_desc_disabled:before {
        content: "\f0de";
        font-family: FontAwesome;
    }

    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:after {
        content: "\f0dd";
        font-family: FontAwesome;
        right: .65rem !important;
    }

    .font_color {
        color: #818181;
    }

    .select2-selection__rendered {
        color: #47D6B6 !important;
        font-size: 11px !important;
    }

    .feather {
        width: 25px;
        height: 25px;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: none;
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

    #leaveCalendar {
        width: 100%;
        height: 600px;
        position: relative;
        z-index: 0;
    }

    /* Today cell — bold yellow highlight */
    .fc-day-today {
        background: #fef08a !important;
        border: 2px solid #f59e0b !important;
    }

    .fc-day-today .fc-daygrid-day-number {
        background: #f59e0b;
        color: #fff !important;
        border-radius: 50%;
        width: 26px;
        height: 26px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin: 4px;
    }

    /* ── Admin calendar — narrow weekend columns ── */
    #leaveCalendar .fc-day-sat,
    #leaveCalendar .fc-day-sun {
        width: 10% !important;
    }

    #leaveCalendar .fc-col-header-cell.fc-day-sat,
    #leaveCalendar .fc-col-header-cell.fc-day-sun {
        width: 10% !important;
    }

    .filter-panel-header { display: none; }
    .filter-btn-row { display: contents; }

    @media (min-width: 768px) {
        #adminAddLeaveBtn.mobile {
            display: none;
        }
    }

    

    @media (max-width: 767px) {

        /* ===== Page padding ===== */
        .container-fluid.mb-5.content-position {
            padding-left: 0px !important;
            padding-right: 0px !important;
        }

        /* ===== Tabs ===== */
        #leaveTabs { font-size: 13px; }
        #leaveTabs .nav-link { padding: 8px 10px; }

        /* ===== Add Past Leave button ===== */
        #adminAddLeaveBtn {
            width: 100% !important;
            margin-left: 0 !important;
            margin-top: 8px;
            padding: 10px !important;
            font-size: 13px !important;
            border-radius: 8px !important;
            background-color: #2dce89 !important;
            border-color: #2dce89 !important;
        }

        /* ===== Filter panel -> stacked, full-width controls ===== */
        #leave-types #scrollTable .card {
            background: #fff;
            border-radius: 12px !important;
            padding: 10px;
        }
        #leave-types #scrollTable .d-flex.flex-wrap.align-items-center {
            flex-direction: column;
            align-items: stretch !important;
            gap: 8px !important;
        }
        #leave-types #scrollTable .d-flex.flex-wrap.align-items-center .input-group {
            width: 100% !important;
        }
        #leave-types #scrollTable .d-flex.flex-wrap.align-items-center .input-group select {
            width: 100% !important;
            min-width: 0 !important;
        }
        #leave-types #scrollTable .d-flex.flex-wrap.align-items-center .input-group-prepend .input-group-text {
            min-width: 115px;
        }
        #filterButton, #resetButton {
            width: 100% !important;
            margin: 0 !important;
            padding: 10px !important;
            font-size: 13px !important;
            border-radius: 8px !important;
        }

        /* ===== DataTables search box / info / pagination ===== */
        #employee_leave_req_table_wrapper .dataTables_length { display: none; }
        #employee_leave_req_table_wrapper .dataTables_filter {
            width: 100%;
            text-align: left;
            margin-bottom: 10px;
        }
        #employee_leave_req_table_wrapper .dataTables_filter label {
            width: 100%;
            display: block;
            font-size: 0;
        }
        #employee_leave_req_table_wrapper .dataTables_filter input {
            width: 100% !important;
            margin-left: 0 !important;
            border-radius: 10px;
            padding: 8px 12px;
            font-size: 14px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }
        #employee_leave_req_table_wrapper .dataTables_info,
        #employee_leave_req_table_wrapper .dataTables_paginate {
            width: 100%;
            text-align: center;
            font-size: 12px;
            padding: 6px 0;
        }

        /* ===== Table -> card list ===== */
        #employee_leave_req_table thead { display: none; }
        #employee_leave_req_table,
        #employee_leave_req_table tbody {
            display: block;
            width: 100%;
        }
        #employee_leave_req_table tbody tr {
            display: grid;
            grid-template-columns: 1fr auto;
            grid-template-areas:
                "name  badge"
                "id    badge"
                "type  type"
                "total total"
                "date1 date2"
                "action action";
            row-gap: 6px;
            column-gap: 8px;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 10px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        }
        #employee_leave_req_table tbody td {
            display: block;
            border: none !important;
            padding: 0 !important;
            text-align: left !important;
        }

        /* Employee Name (column 2) */
        #employee_leave_req_table tbody td:nth-child(2) {
            grid-area: name;
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
        }

        /* ID (column 1) */
        #employee_leave_req_table tbody td:nth-child(1) {
            grid-area: id;
            font-size: 11px;
            color: #999999;
        }
        #employee_leave_req_table tbody td:nth-child(1)::before {
            content: "ID #";
        }

        /* Employee Status pill, e.g. "Full Time" (column 6) */
        #employee_leave_req_table tbody td:nth-child(6) {
            grid-area: badge;
            justify-self: end;
            align-self: center;
            background: #f2f3f4;
            color: #555555 !important;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px !important;
            border-radius: 20px;
            white-space: nowrap;
        }

        /* Leave Type pill (column 3) */
        #employee_leave_req_table tbody td:nth-child(3) {
            grid-area: type;
            display: inline-block !important;
            background: #eaf1ff;
            color: #2f6fed !important;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px !important;
            border-radius: 20px;
            width: fit-content;
        }

        /* Total Leave Days (column 7) */
        #employee_leave_req_table tbody td:nth-child(7) {
            grid-area: total;
            font-size: 12px;
            color: #555555;
        }
        #employee_leave_req_table tbody td:nth-child(7)::before {
            content: "Total Leave Days: ";
            color: #888888;
        }

        /* Start Date (column 4) / End Date (column 5) */
        #employee_leave_req_table tbody td:nth-child(4) {
            grid-area: date1;
            font-size: 12px;
            color: #444444;
        }
        #employee_leave_req_table tbody td:nth-child(5) {
            grid-area: date2;
            justify-self: end;
            font-size: 12px;
            color: #444444;
        }
        #employee_leave_req_table tbody td:nth-child(5)::before {
            content: "\2192  "; /* → arrow between start/end date */
            color: #999999;
        }

        /* Action: Approve button / Approved / Rejected text (column 8) */
        #employee_leave_req_table tbody td:nth-child(8) {
            grid-area: action;
            justify-self: end;
            margin-top: 4px !important;
        }
        #employee_leave_req_table tbody td:nth-child(8) .btn {
            width: auto !important;
            padding: 6px 16px !important;
            font-size: 12px !important;
            border-radius: 20px !important;
        }
        #employee_leave_req_table tbody td:nth-child(8) .text-success,
        #employee_leave_req_table tbody td:nth-child(8) .text-danger {
            font-size: 12px;
            font-weight: 600;
            padding: 5px 14px;
            border-radius: 20px;
            display: inline-block;
        }
        #employee_leave_req_table tbody td:nth-child(8) .text-success {
            background: #eafaf1;
            color: #2dce89 !important;
        }
        #employee_leave_req_table tbody td:nth-child(8) .text-danger {
            background: #fdecea;
            color: #e53935 !important;
        }

        #adminAddLeaveBtn.desktop {
            display: none;
        }

                /* ===== Filter panel header ===== */
        .filter-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 16px;
            font-size: 14px;
            font-weight: 700;
            color: #1a1a1a;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
        }
        .filter-panel-header i { color: #777; font-size: 13px; }

        /* ===== Filter panel card ===== */
        #leave-types #scrollTable .card {
            background: #fff;
            border: 1px solid #eee !important;
            border-radius: 12px !important;
            padding: 0;
        }
        #leave-types #scrollTable .d-flex.flex-wrap.align-items-center {
            flex-direction: column;
            align-items: stretch !important;
            gap: 14px !important;
            padding: 6px 16px 18px !important;
        }

        /* Each select becomes: label on its own line, box below it */
        #leave-types #scrollTable .d-flex.flex-wrap.align-items-center .input-group {
            display: block !important;
            width: 100% !important;
        }
        #leave-types #scrollTable .input-group-prepend {
            display: block;
            width: 100%;
            margin-bottom: 5px;
        }
        #leave-types #scrollTable .input-group-prepend .input-group-text {
            background: transparent !important;
            border: none !important;
            padding: 0 !important;
            font-size: 12px !important;
            color: #666 !important;
            font-weight: 600;
        }
        #leave-types #scrollTable .d-flex.flex-wrap.align-items-center .input-group select {
            display: block;
            width: 100% !important;
            min-width: 0 !important;
            height: 44px !important;
            box-sizing: border-box !important;
            line-height: normal !important;
            border: 1px solid #e2e2e2 !important;
            border-radius: 8px !important;
            background-color: #fff !important;
            padding: 0 32px 0 12px !important;
            font-size: 14px !important;
            color: #333 !important;
            font-style: normal !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23555' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 14px 14px;
        }

        /* Reset + Filter buttons, side by side, pill-shaped */
        .filter-btn-row {
            display: flex !important;
            gap: 10px;
            width: 100%;
        }
        .filter-btn-row #resetButton,
        .filter-btn-row #filterButton {
            flex: 1;
            margin: 0 !important;
            padding: 12px !important;
            font-size: 13px !important;
            border-radius: 24px !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #resetButton {
            background: #f0f1f3 !important;
            border: none !important;
            color: #555 !important;
        }
        #filterButton {
            background: #2dce89 !important;
            border: none !important;
            color: #fff !important;
        }

         #adminAddLeaveBtn {
            width: 100% !important;
            margin-left: 0 !important;
            margin-top: 8px;
            padding: 12px !important;
            font-size: 13px !important;
            border-radius: 24px !important;
            background-color: #14B8A6 !important;
            border-color: #14B8A6 !important;
        }

         #employee_leave_req_table_wrapper .dataTables_filter input {
            width: 100% !important;
            margin-left: 0 !important;
            border-radius: 24px;
            padding: 10px 16px 10px 38px;
            font-size: 14px;
            border: 1px solid #ddd;
            box-sizing: border-box;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23999' stroke-width='2'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='M21 21l-4.35-4.35'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: 12px center;
            background-size: 16px 16px;
        }

                /* Select2 renders its own box next to the real <select> — style that too */
        #leave-types #scrollTable .input-group .select2-container {
            width: 100% !important;
        }
        #leave-types #scrollTable .input-group .select2-selection--single {
            height: 42px !important;
            border: 1px solid #e2e2e2 !important;
            border-radius: 8px !important;
            background: #fff !important;
            display: flex;
            align-items: center;
        }
        #leave-types #scrollTable .input-group .select2-selection__rendered {
            font-size: 13px !important;
            color: #333 !important;
            line-height: 40px !important;
            padding-left: 12px !important;
        }
        #leave-types #scrollTable .input-group .select2-selection__arrow {
            height: 40px !important;
            right: 8px;
        }

         #leave-types #scrollTable #adminAddLeaveBtn.mobile {
            margin-top: 14px !important;
        }
        #leave-types > .col-md-12 {
            margin-bottom: 14px !important;
        }
        #employee_leave_req_table_wrapper .dataTables_filter {
            margin-top: 4px !important;
            margin-bottom: 14px !important;
        }

        /* ===== Add Past Leave modal — mobile ===== */
        #adminAddLeaveModal .modal-dialog {
            margin: 12px auto;
            max-width: calc(100% - 24px);
            min-height: calc(100% - 24px);
            display: flex;
            align-items: center;
        }
        #adminAddLeaveModal .modal-content {
            border-radius: 16px !important;
            border: none !important;
            overflow: hidden;
        }

        /* Plain white header, bold black title, simple close icon */
        #adminAddLeaveModal .modal-header {
            background: #fff !important;
            border-bottom: 1px solid #f0f0f0;
            padding: 16px 18px;
        }
        #adminAddLeaveModal .modal-title {
            color: #1a1a1a !important;
            font-size: 15px;
            font-weight: 700;
        }
        #adminAddLeaveModal .modal-title i {
            display: none; /* hides the calendar icon so it matches the plain Figma title */
        }
        #adminAddLeaveModal .close {
            color: #888 !important;
            opacity: 1;
            font-size: 22px;
            text-shadow: none;
        }

        /* Body spacing */
        #adminAddLeaveModal .modal-body {
            padding: 16px 18px !important;
        }
        #adminAddLeaveModal .form-group.row {
            margin-bottom: 16px !important;
        }
        #adminAddLeaveModal .col-form-label {
            padding-bottom: 6px;
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #1a1a1a !important;
        }

        /* Rounded, roomy fields matching the Figma boxes */
        #adminAddLeaveModal .form-control {
            height: 46px !important;
            border: 1px solid #e2e2e2 !important;
            border-radius: 10px !important;
            font-size: 14px !important;
            padding: 0 14px !important;
            box-sizing: border-box !important;
        }
        #adminAddLeaveModal select.form-control {
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23555' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 14px 14px;
        }
        #adminAddLeaveModal textarea.form-control {
            height: auto !important;
            padding: 12px 14px !important;
            border-radius: 10px !important;
        }

        /* Footer: two equal-width pill buttons */
        #adminAddLeaveModal .modal-footer {
            border-top: none;
            padding: 12px 18px 18px;
            display: flex;
            gap: 10px;
        }
        #adminAddLeaveModal .modal-footer .btn {
            flex: 1;
            margin: 0 !important;
            padding: 12px !important;
            font-size: 14px !important;
            font-weight: 600;
            border-radius: 24px !important;
        }
        #adminAddLeaveModal .modal-footer .btn-secondary {
            background: #d6d9dc !important;
            border: none !important;
            color: #333 !important;
        }
        #adminAddLeaveModal .modal-footer .btn-success {
            background: #1AA05A !important;
            border: none !important;
            color: #fff !important;
        }
        #adminAddLeaveModal .modal-footer .btn i {
            display: none; /* hides the save icon so it reads "Save as Approved" like the Figma */
        }

            /* ===== Leave Approve modal — mobile ===== */
        #leave_Approve_modal .modal-dialog {
            position: fixed !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            margin: 0 !important;
            width: calc(100% - 24px) !important;
            max-width: calc(100% - 24px) !important;
           
        }
        #leave_Approve_modal .modal-content {
            border-radius: 16px !important;
            border: none !important;
            max-height: calc(100vh - 48px) !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden !important;
        }
        #leave_Approve_modal .modal-header,
        #leave_Approve_modal .modal-footer {
            flex-shrink: 0 !important;
        }
        #leave_Approve_modal .modal-body {
            padding: 14px 18px !important;
            flex: 1 1 auto !important;
            min-height: 0 !important;
            overflow-y: auto !important;
            -webkit-overflow-scrolling: touch;
        }
        #leave_Approve_modal .modal-body .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        /* REMAINING banner box */
        #leave_Approve_modal .badge-info {
            display: block;
            width: 100%;
            background: #e0f7f5 !important;
            color: #0e7c72 !important;
            border-radius: 12px;
            padding: 14px;
            text-align: center;
            font-size: 12px;
            white-space: normal;
        }
        #leave_Approve_modal .badge-info strong {
            display: block;
            letter-spacing: .04em;
            margin-bottom: 4px;
            font-size: 12px;
        }

        /* Employee Name / Status / etc rows -> label left, value right, no table lines */
        #leave_Approve_modal table.table:not(#leaveInfoTable) tr {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f2f2f2;
        }
        #leave_Approve_modal table.table:not(#leaveInfoTable) td {
            border: none !important;
            padding: 8px 0 !important;
            font-size: 13px;
        }
        #leave_Approve_modal table.table:not(#leaveInfoTable) td:first-child {
            color: #888;
        }
        #leave_Approve_modal table.table:not(#leaveInfoTable) td:last-child {
            color: #1a1a1a;
            font-weight: 600;
            text-align: right;
        }

        /* Section headings: LEAVE INFO / REASON FOR LEAVE / etc */
        #leave_Approve_modal h3 {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: #1a1a1a;
            margin-top: 18px;
            margin-bottom: 8px;
        }

        /* LEAVE INFO box */
        #leave_Approve_modal #leaveInfoTable {
            background: #f7f7f8;
            border-radius: 10px;
            overflow: hidden;
            border: none !important;
        }
        #leave_Approve_modal #leaveInfoTable thead {
            display: none;
        }
        #leave_Approve_modal #leaveInfoTable tbody tr {
            display: flex;
            justify-content: space-between;
            padding: 12px 14px;
        }
        #leave_Approve_modal #leaveInfoTable td {
            border: none !important;
            padding: 0 !important;
            font-size: 13px;
            background: transparent !important;
        }
        #leave_Approve_modal #leaveInfoTable td:first-child::before {
            content: "LEAVE DATES";
            display: block;
            font-size: 10px;
            color: #999;
            letter-spacing: .04em;
            margin-bottom: 3px;
        }
        #leave_Approve_modal #leaveInfoTable td:last-child {
            text-align: right;
            font-weight: 700;
        }
        #leave_Approve_modal #leaveInfoTable td:last-child::before {
            content: "LEAVE TYPE";
            display: block;
            font-size: 10px;
            color: #999;
            letter-spacing: .04em;
            margin-bottom: 3px;
            text-align: right;
        }

        /* Reason for leave box */
        #leave_Approve_modal #leaveReason {
            background: #f7f7f8;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 13px;
            color: #333;
            margin: 0;
        }

        /* Leave conflicts box */
        #leave_Approve_modal #adminLeaveConflictMessage {
            background: #eafaf1;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 12px;
            color: #1f9d55;
        }

        /* Footer: Close / Approve / Reject, equal width pills */
        #leave_Approve_modal .modal-footer {
            border-top: none;
            padding: 12px 18px 18px;
            display: flex;
            gap: 8px;
        }
        #leave_Approve_modal .modal-footer .btn {
            flex: 1;
            margin: 0 !important;
            padding: 12px 8px !important;
            font-size: 13px !important;
            font-weight: 600;
            border-radius: 24px !important;
        }
        #leave_Approve_modal .btn-secondary {
            background: #d6d9dc !important;
            border: none !important;
            color: #333 !important;
        }
        #leave_Approve_modal .btn-primary.approve-btn {
            background: #14B8A6 !important;
            border: none !important;
            color: #fff !important;
        }
        #leave_Approve_modal .btn-danger.reject-btn {
            background: #e53935 !important;
            border: none !important;
            color: #fff !important;
        }

        #leave_Approve_modal .col-12.px-5 {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /* ===== Leave Requests (calendar day-click) modal — mobile ===== */
        #leaveModal .modal-dialog {
            position: fixed !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            margin: 0 !important;
            width: calc(100% - 24px) !important;
            max-width: calc(100% - 24px) !important;
        }
        #leaveModal .modal-content {
            border-radius: 16px !important;
            border: none !important;
            max-height: calc(100vh - 48px) !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden !important;
        }
        #leaveModal .modal-header {
            flex-shrink: 0 !important;
            padding: 16px 18px;
            border-bottom: 1px solid #f0f0f0;
        }
        #leaveModal .modal-title {
            font-size: 15px;
            font-weight: 700;
            color: #1a1a1a;
        }
        #leaveModal .close {
            color: #888 !important;
            opacity: 1;
            font-size: 22px;
            text-shadow: none;
        }
        #leaveModal .modal-body {
            padding: 14px 18px !important;
            flex: 1 1 auto !important;
            min-height: 0 !important;
            overflow-y: auto !important;
        }
        #leaveModal .modal-footer {
            flex-shrink: 0 !important;
            border-top: none;
            padding: 10px 18px 18px;
        }
        #leaveModal .modal-footer .btn {
            width: 100% !important;
            border-radius: 24px !important;
            padding: 12px !important;
            background: #d6d9dc !important;
            border: none !important;
            color: #333 !important;
            font-weight: 600;
        }

        /* Turn the plain table rows into cards, same trick used on your main leave table */
        #leaveRequestsTable {
            border: none !important;
        }
        #leaveRequestsTable thead {
            display: none;
        }
        #leaveRequestsTable,
        #leaveRequestsTable tbody {
            display: block;
            width: 100%;
        }
        #leaveRequestsTable tbody tr {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            grid-template-areas:
                "name name action"
                "status start end";
            row-gap: 10px;
            column-gap: 6px;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 10px;
        }
        #leaveRequestsTable tbody td {
            display: block;
            border: none !important;
            padding: 0 !important;
        }

        /* User (column 1) */
        #leaveRequestsTable tbody td:nth-child(1) {
            grid-area: name;
            font-size: 14px;
            font-weight: 700;
            color: #1a1a1a;
        }

        /* Start Date (column 2) */
        #leaveRequestsTable tbody td:nth-child(2) {
            grid-area: start;
            font-size: 12px;
            color: #333;
        }
        #leaveRequestsTable tbody td:nth-child(2)::before {
            content: "START DATE";
            display: block;
            font-size: 9px;
            color: #999;
            letter-spacing: .03em;
            margin-bottom: 3px;
        }

        /* End Date (column 3) */
        #leaveRequestsTable tbody td:nth-child(3) {
            grid-area: end;
            font-size: 12px;
            color: #333;
            text-align: right;
        }
        #leaveRequestsTable tbody td:nth-child(3)::before {
            content: "END DATE";
            display: block;
            font-size: 9px;
            color: #999;
            letter-spacing: .03em;
            margin-bottom: 3px;
            text-align: right;
        }

        /* Status (column 4) — with a small colored dot */
        #leaveRequestsTable tbody td:nth-child(4) {
            grid-area: status;
            font-size: 12px;
            font-weight: 700;
            color: #333;
            position: relative;
            padding-left: 14px !important;
        }
        #leaveRequestsTable tbody td:nth-child(4)::before {
            content: "STATUS";
            display: block;
            font-size: 9px;
            color: #999;
            font-weight: 400;
            letter-spacing: .03em;
            margin-bottom: 3px;
        }
        #leaveRequestsTable tbody td:nth-child(4)::after {
            content: "";
            position: absolute;
            left: 0;
            top: 17px;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #2dce89; /* green dot, matches your current "Approved" status */
        }

        /* Action (column 5) — the Approve button */
        #leaveRequestsTable tbody td:nth-child(5) {
            grid-area: action;
            justify-self: end;
            align-self: start;
        }
        #leaveRequestsTable tbody td:nth-child(5) .btn {
            padding: 6px 16px !important;
            font-size: 12px !important;
            border-radius: 20px !important;
            background: #14B8A6 !important;
            border: none !important;
            color: #fff !important;
        }

        .back_home_mobile {
            padding-left: 15px;
            padding-bottom: 10px;
        }
                
    }

    @media (min-width: 768px) {
        .back_home_mobile {
            display: none;
        }
    }
   


</style>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">


@if ($errors->any())
<div class="alert alert-danger">
    {{ $errors->first() }}
</div>
@endif

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
    <span>LEAVE MANAGEMENT</span>
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

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">

                <ul class="nav nav-tabs" id="leaveTabs">
                    <li class="">
                        <a class="nav-link active" id="leave-types-tab" data-toggle="tab" href="#leave-types">Employee Leave List</a>
                    </li>
                    <li class="">
                        <a class="nav-link" id="employee-leave-tab" data-toggle="tab" href="#employee-leave">Employee Leave Calendar</a>
                    </li>
                </ul>
            </div>
            <button id="adminAddLeaveBtn" class="btn btn-sm btn-info desktop" style="font-size:11px; margin-left:auto;">
                <i class="fa fa-plus mr-1"></i> Add Past Leave
            </button>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class=" mt-2">
                    <div class="">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="leave-types">
                                <div class="col-md-12" style="margin-top: 15px;  padding-bottom: 20px;" id="scrollTable">
                                    <div class="card" style="border: unset;">
                                    <div class="filter-panel-header d-md-none" id="filterPanelToggle">
                                        <span>Filter leave management</span>
                                        <i class="fa fa-chevron-up" id="filterPanelChevron"></i>
                                    </div>
                                    <div class="d-flex flex-wrap align-items-center" id="filterPanelBody" style="gap: 8px; padding: 10px 5px;">

                                        <div class="input-group input-group-sm" style="width: auto;">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white text-muted" style="font-size:11px; border-right:0;">Employee</span>
                                            </div>
                                            <select id="filterEmployee" class="form-control form-control-sm" style="font-size:11px; border-left:0; min-width:130px;">
                                                <option value="">All</option>
                                            </select>
                                        </div>

                                        <div class="input-group input-group-sm" style="width: auto;">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white text-muted" style="font-size:11px; border-right:0;">Leave Type</span>
                                            </div>
                                            <select id="filterLeaveType" class="form-control form-control-sm" style="font-size:11px; border-left:0; min-width:130px;">
                                                <option value="">All</option>
                                            </select>
                                        </div>

                                        <div class="input-group input-group-sm" style="width: auto;">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white text-muted" style="font-size:11px; border-right:0;">Employee Status</span>
                                            </div>
                                            <select id="filterStatus" class="form-control form-control-sm" style="font-size:11px; border-left:0; min-width:120px;">
                                                <option value="">All</option>
                                            </select>
                                        </div>

                                        <div class="input-group input-group-sm" style="width: auto;">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white text-muted" style="font-size:11px; border-right:0;">Status</span>
                                            </div>
                                            <select id="filterLeaveStatus" class="form-control form-control-sm" style="font-size:11px; border-left:0; min-width:110px;">
                                                <option value="">All</option>
                                                <option value="0">Pending</option>
                                                <option value="1">Approved</option>
                                                <option value="2">Rejected</option>
                                            </select>
                                        </div>

                                        <div class="filter-btn-row">
                                            <button id="resetButton" class="btn btn-sm btn-outline-secondary" style="font-size:11px;">
                                                <i class="fa fa-undo mr-1"></i> Reset filters
                                            </button>

                                            <button id="filterButton" class="btn btn-sm btn-dark" style="font-size:11px;">
                                                <i class="fa fa-filter mr-1"></i> Filter activity
                                            </button>
                                        </div>

                                        {{-- <div class="row " style="padding-bottom: 2px;margin:5px;margin-left:auto">
                                            <h4 id="export_button" class="charIco d_flex_and_align_center" style="padding-left: 5px;margin-bottom: unset;color:#B3B3B3;font-size:11px;cursor: pointer;"><i class="fa fa-download mx-2" aria-hidden="true"></i> EXPORT REPORT </h4>
                                        </div> --}}
                                    </div>
                                </div>
                                <button id="adminAddLeaveBtn" class="btn btn-sm btn-info mobile" style="font-size:11px; margin-left:auto;">
                                    <i class="fa fa-plus mr-1"></i> Add Past Leave
                                </button>
                                
                                </div>
                                
                                <div class="col-md-12" style=" margin-bottom: 25px; padding-bottom: 20px;">
                                    <div class="card" style="border: unset;">
                                        <div class="row" style="margin: 10px;">
                                            <div class="col">

                                                <table class="table align-items-center " id="employee_leave_req_table" style="width:100%;">

                                                    <thead style="background-color: #717070;">
                                                        <th class="table_header_text">ID</th>
                                                        <th class="table_header_text">EMPLOYEE NAME</th>
                                                        <th class="table_header_text">LEAVE TYPE</th>
                                                        <th class="table_header_text" style="text-align: center;">START DATE</th>
                                                        <th class="table_header_text" style="text-align: center;">END DATE</th>
                                                        <th class="table_header_text" style="text-align: center;">EMPLOYEE STATUS</th>
                                                        <th class="table_header_text" style="text-align: center;">TOTAL LEAVE DAYS</th>
                                                        <th class="table_header_text" style="text-align: center;">ACTION</th>
                                                        <th class="table_header_text" style="text-align: center;">STATUS_RAW</th>
                                                        <th class="table_header_text" style="display:none;">SORT_DATE</th>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="employee-leave">
                                <div class="col-md-12" style="margin-top: 15px;  padding-bottom: 20px;" id="scrollTable">
                                    <div class="card" style="border: unset;">
                                        <div class="row" style="margin: 10px;">
                                            <div class="col">

                                                <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;padding:10px 4px 12px;font-size:12px;color:#374151;">
                                                    <span style="font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.04em;font-size:11px;">Legend:</span>
                                                    <span style="display:flex;align-items:center;gap:5px;">
                                                        <span style="display:inline-block;width:12px;height:12px;border-radius:3px;background:#ef4444;"></span> Upcoming Leave
                                                    </span>
                                                    <span style="display:flex;align-items:center;gap:5px;">
                                                        <span style="display:inline-block;width:12px;height:12px;border-radius:3px;background:#22c55e;"></span> Covering Day (Off)
                                                    </span>
                                                    <span style="display:flex;align-items:center;gap:5px;">
                                                        <span style="display:inline-block;width:12px;height:12px;border-radius:3px;background:#9ca3af;"></span> Past Leave
                                                    </span>
                                                    <span style="display:flex;align-items:center;gap:5px;">
                                                        <span style="display:inline-block;width:12px;height:12px;border-radius:3px;background:#f97316;"></span> Public Holiday
                                                    </span>
                                                    <span style="display:flex;align-items:center;gap:5px;">
                                                        <span style="display:inline-block;width:12px;height:12px;border-radius:3px;background:#ffcdcd;border:1px solid #f5c6c6;"></span> Saturday
                                                    </span>
                                                    <span style="display:flex;align-items:center;gap:5px;">
                                                        <span style="display:inline-block;width:12px;height:12px;border-radius:3px;background:#c75f53;"></span> Sunday
                                                    </span>
                                                    <span style="display:flex;align-items:center;gap:5px;">
                                                        <span style="display:inline-block;width:12px;height:12px;border-radius:3px;background:#fef08a;border:1px solid #f59e0b;"></span> Today
                                                    </span>
                                                </div>
                                                <div id="leaveCalendar"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Structure -->
<div class="modal fade" id="leaveModal" tabindex="-1" role="dialog" aria-labelledby="leaveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="leaveModalLabel">Leave Requests of <span id="modalDate"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Table to display leave requests -->
                <table class="table table-bordered" id="leaveRequestsTable">
                    <thead style="background-color: #717070;">
                        <tr>
                            <th class="table_header_text">User</th>
                            <th class="table_header_text">Start Date</th>
                            <th class="table_header_text">End Date</th>
                            <th class="table_header_text">Status</th>
                            <th class="table_header_text">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be dynamically added here -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Approve/reject buttons appear only for pending leaves; clicking updates status via AJAX and refreshes the table -->
<div class="modal fade" id="leave_Approve_modal" tabindex="-1" role="dialog" aria-labelledby="leave_Approve_modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="leave_Approve_modalLabel">Leave Request of <span id="reqname"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-12 px-5">
                        <div class="row" style="padding-bottom: 2px; margin:5px;">
                            <table style="width: 100%;">
                                <tr>
                                    <td>
                                        <span class="badge badge-info" style="font-size:14px;">
                                            <strong>REMAINING:</strong>
                                            <span id="adminRemainingText">
                                                <i class="fa fa-spinner fa-spin" style="font-size:11px;"></i>
                                            </span>
                                        </span>
                                        <!-- <span class="badge badge-info" style="font-size:14px;">
                                            <strong>Remaining: </strong>
                                            Annual - 0 <span id="remainingAnnualLeaves"></span>,
                                            Medical - 0 <span id="remainingMedicalLeaves"></span>,
                                            Casual - 0 <span id="remainingCasualLeaves"></span>
                                        </span> -->
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="col-12 px-5">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Employee Name</td>
                                    <td id="employee_name">Heshan Namal</td>
                                </tr>
                                <tr>
                                    <td>Employee Status</td>
                                    <td id="employee_status">Active</td>
                                </tr>
                                <tr>
                                    <td>Request Title</td>
                                    <td id="requestTitle">—</td>
                                </tr>
                                <tr>
                                    <td>Leave Category</td>
                                    <td id="leaveCategory">—</td>
                                </tr>
                                <tr>
                                    <td>Leave Type</td>
                                    <td id="leaveTypeLabel">—</td>
                                </tr>
                                <tr>
                                    <td>Day Type</td>
                                    <td id="dayTypeLabel">—</td>
                                </tr>
                                <tr>
                                    <td>Total Leave Days</td>
                                    <td id="total_leave_days">5</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-12 px-5">
                        <h3>Leave Info</h3>
                        <table class="table table-bordered" id="leaveInfoTable">
                            <thead style="background-color: #717070;">
                                <tr>
                                    <th class="table_header_text">Leave Dates</th>
                                    <th class="table_header_text">Leave Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>20/12/2024</td>
                                    <td>Annual Leave</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-12 px-5">
                        <h3>Reason For Leave</h3>
                        <p id="leaveReason">
                            zsdf sdfs dfsdf sdfsdf sdfgsad
                        </p>
                    </div>
                </div>

                <!-- Conflict Message Section -->
                <div class="col-12 px-5" id="conflictMessageSection" style="display:none;">
                    <h3>⚠️ Leave Conflicts</h3>
                    <div id="adminLeaveConflictMessage"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary approve-btn"
                    id="approveBtn" style="display:none;">Approve</button>
                <button type="button" class="btn btn-danger reject-btn"
                    id="rejectBtn" style="display:none;">Reject</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL - Admin Add Past Leave -->
<div class="modal fade" id="adminAddLeaveModal" tabindex="-1" role="dialog" aria-labelledby="adminAddLeaveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius:8px; border:none;">

            <div class="modal-header" style="background:#717070; border-radius:8px 8px 0 0;">
                <h5 class="modal-title text-white" id="adminAddLeaveModalLabel">
                    <i class="fa fa-calendar-check-o mr-2"></i> Add Past Leave (Admin)
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body px-4 py-3">

                <!-- Employee -->
                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label font-weight-bold" style="font-size:13px;">Employee <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <select id="adminLeave_userId" class="form-control form-control-sm adminLeave-field">
                            <option value="">— Select Employee —</option>
                        </select>
                        <!-- Remaining balance badge shown after employee selected -->
                        <div id="adminLeave_balanceBadge" class="mt-1" style="display:none;">
                            <span class="badge badge-info" style="font-size:11px; white-space:normal; line-height:1.6;">
                                <strong>Remaining:</strong> <span id="adminLeave_balanceText"><i class="fa fa-spinner fa-spin"></i></span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Title -->
                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label font-weight-bold" style="font-size:13px;">Title <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" id="adminLeave_title" class="form-control form-control-sm adminLeave-field" placeholder="e.g. Annual Leave Jan 2025">
                    </div>
                </div>

                <!-- Leave Type (populated from user's leave group with REMAINING days) -->
                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label font-weight-bold" style="font-size:13px;">Leave Type <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <select id="adminLeave_leaveType" class="form-control form-control-sm adminLeave-field" disabled>
                            <option value="">— Select Employee first —</option>
                        </select>
                    </div>
                </div>

                <!-- Leave Day Type -->
                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label font-weight-bold" style="font-size:13px;">Leave Day Type <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <select id="adminLeave_dayType" class="form-control form-control-sm adminLeave-field">
                            <option value="">— Select Day Type —</option>
                            <option value="half_day">Half Day</option>
                            <option value="one_day">One Day</option>
                            <option value="multiple_days">Multiple Days</option>
                            <option value="short_leave">Short Leave</option>
                        </select>
                    </div>
                </div>

                <!-- Single date (Half Day / One Day) -->
                <div id="adminLeave_singleDateRow" class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label font-weight-bold" style="font-size:13px;">Date <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="date" id="adminLeave_singleDate" class="form-control form-control-sm">
                    </div>
                </div>

                <!-- Half Day: Morning / Evening -->
                <div id="adminLeave_halfDayRow" class="form-group row mb-3" style="display:none;">
                    <label class="col-sm-3 col-form-label font-weight-bold" style="font-size:13px;">Time <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <select id="adminLeave_halfDayTime" class="form-control form-control-sm adminLeave-field">
                            <option value="">— Select Time —</option>
                            <option value="0">Morning</option>
                            <option value="1">Evening</option>
                        </select>
                    </div>
                </div>

                <!-- Multiple Days: Calendar Picker -->
                <div id="adminLeave_multiRow" class="form-group row mb-3" style="display:none;">
                    <label class="col-sm-3 col-form-label font-weight-bold" style="font-size:13px;">
                        Select Dates <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <div id="adminLeave_calendarPicker" style="border:1px solid #dee2e6; border-radius:6px; padding:10px; background:#fff; user-select:none;">
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
                                <button type="button" id="adminLeave_calPrev" class="btn btn-sm btn-outline-secondary" style="padding:2px 8px;">&lsaquo;</button>
                                <strong id="adminLeave_calMonthLabel" style="font-size:13px;"></strong>
                                <button type="button" id="adminLeave_calNext" class="btn btn-sm btn-outline-secondary" style="padding:2px 8px;">&rsaquo;</button>
                            </div>
                            <div id="adminLeave_calGrid" style="display:grid; grid-template-columns:repeat(7,1fr); gap:3px; text-align:center; font-size:12px;"></div>
                        </div>
                        <div id="adminLeave_selectedDatesDisplay" class="mt-2" style="font-size:11px; color:#555; min-height:18px;"></div>
                        <div id="adminLeave_splitPreview" class="mt-1" style="font-size:11px;"></div>
                    </div>
                </div>

                <!-- Short Leave: Date -->
                <div id="adminLeave_shortRow" class="form-group row mb-3" style="display:none;">
                    <label class="col-sm-3 col-form-label font-weight-bold" style="font-size:13px;">Date <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="date" id="adminLeave_shortDate" class="form-control form-control-sm adminLeave-field">
                    </div>
                </div>
                <!-- Short Leave: From/To time -->
                <div id="adminLeave_shortTimeRow" class="form-group row mb-3" style="display:none;">
                    <label class="col-sm-3 col-form-label font-weight-bold" style="font-size:13px;">From Time <span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="time" id="adminLeave_shortFrom" class="form-control form-control-sm adminLeave-field">
                    </div>
                    <label class="col-sm-1 col-form-label font-weight-bold text-center" style="font-size:13px;">To</label>
                    <div class="col-sm-4">
                        <input type="time" id="adminLeave_shortTo" class="form-control form-control-sm">
                    </div>
                </div>

                <!-- Calculated days (Multiple Days only) -->
                <div id="adminLeave_calcRow" class="form-group row mb-3" style="display:none;">
                    <div class="col-sm-9 offset-sm-3">
                        <span class="badge badge-secondary" style="font-size:12px;" id="adminLeave_calcText"></span>
                    </div>
                </div>

                <!-- Request Note -->
                <div class="form-group row mb-2">
                    <label class="col-sm-3 col-form-label font-weight-bold" style="font-size:13px;">Request Note</label>
                    <div class="col-sm-9">
                        <textarea id="adminLeave_note" class="form-control form-control-sm" rows="3" placeholder="Optional reason / notes…"></textarea>
                    </div>
                </div>

                <div id="adminLeave_error" class="alert alert-danger mt-2 py-2" style="display:none; font-size:12px;"></div>
                <div id="adminLeave_success" class="alert alert-success mt-2 py-2" style="display:none; font-size:12px;"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm" id="adminLeave_saveBtn">
                    <i class="fa fa-save mr-1"></i> Save as Approved
                </button>
            </div>
        </div>
    </div>
</div>

@include('pages.hr_module.Leave_Managment.leave_balance_modal')

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
    $(document).ready(function() {
        function toTitleCase(str) {
            if (!str) return '';
            return str.replace(/\b\w/g, function(c) {
                return c.toUpperCase();
            });
        }

        // Use document-level delegation so the handler always reads the CURRENT attribute
        $(document).on('click', '#approveBtn', function() {
            var leaveId = $(this).attr('data-leave-id'); // attr() reads live DOM value, not cached .data()
            if (!leaveId) {
                alert('No leave ID found.');
                return;
            }
            var $btn = $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Approving…');
            updateLeaveStatus(leaveId, 'approved', $btn, 'Approve');
        });

        $(document).on('click', '#rejectBtn', function() {
            var leaveId = $(this).attr('data-leave-id'); // attr() reads live DOM value, not cached .data()
            if (!leaveId) {
                alert('No leave ID found.');
                return;
            }
            var $btn = $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Rejecting…');
            updateLeaveStatus(leaveId, 'rejected', $btn, 'Reject');
        });

        // Function to update leave status
        function updateLeaveStatus(leaveId, status, $btn, btnLabel) {
            $.ajax({
                url: "{{ route('leave.updateLeaveStatus') }}",
                method: 'POST',
                data: {
                    leave_id: leaveId,
                    status: status,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if ($btn) $btn.prop('disabled', false).html(btnLabel);
                    $('#leave_Approve_modal').modal('hide');
                    make_employee_leave_table();

                    // ── Instantly refetch calendar events ──────────────────
                    if (leaveCalendarInstance) {
                        leaveCalendarInstance.refetchEvents();
                    }
                },
                error: function() {
                    if ($btn) $btn.prop('disabled', false).html(btnLabel);
                    alert('An error occurred while updating the leave status.');
                }
            });
        }

        $(document).on('click', '.viewrequest', function() {
            var leaveId = $(this).data('leaveid');
            $('#reqname').text('');
            $('#leaveInfoTable tbody').empty();
            $('#adminLeaveConflictMessage').html('');
            $('#conflictMessageSection').hide();
            $('#approveBtn').hide();
            $('#rejectBtn').hide();

            $.ajax({
                url: "{{ route('leave.getLeaveRequestDetails') }}",
                method: 'GET',
                data: {
                    leave_id: leaveId
                },
                success: function(response) {
                    if (!response.success) {
                        alert(response.message);
                        return;
                    }

                    var r = response.leave;
                    console.log('Leave response:', JSON.stringify(r));

                    $('#reqname').text(r.employee_name);
                    $('#employee_name').text(r.employee_name);
                    $('#employee_status').text(r.employee_status);
                    $('#requestTitle').text(r.request_title ? toTitleCase(r.request_title) : '—');
                    $('#leaveCategory').text(r.leave_category ? toTitleCase(r.leave_category) : '—');
                    $('#leaveTypeLabel').text(r.leave_type || '—');
                    $('#dayTypeLabel').text(r.day_type_label || '—');
                    $('#total_leave_days').text(r.total_leave_days);
                    $('#leaveReason').text(r.leave_reason || '—');

                    loadLeaveBalanceBadge(r.user_id, '#adminRemainingText');

                    // ── Approve / Reject buttons ──────────────────────────────
                    if (r.status == 0) {
                        $('#approveBtn').show()
                            .attr('data-leave-id', r.id)
                            .removeData('leave-id'); // clear jQuery's internal cache so .attr() is always fresh
                        $('#rejectBtn').show()
                            .attr('data-leave-id', r.id)
                            .removeData('leave-id');
                    }

                    // ── Leave Info table ──────────────────────────────────────
                    var $tbody = $('#leaveInfoTable tbody').empty();

                    if (r.type == 4) {
                        // ── Covering Day ──────────────────────────────────────
                        $tbody.append(
                            '<tr>' +
                            '<td>' +
                            '<div style="margin-bottom:4px;">' +
                            '<span style="color:#6366f1;font-weight:700;font-size:11px;">DAY OFF</span><br>' +
                            '<span style="font-size:13px;">' + (r.covering_leave_date || '—') + '</span>' +
                            '</div>' +
                            '<div>' +
                            '<span style="color:#6366f1;font-weight:700;font-size:11px;">COVERING (WORKING)</span><br>' +
                            '<span style="font-size:13px;">' + (r.covering_cover_date || '—') + '</span>' +
                            '</div>' +
                            '</td>' +
                            '<td><span class="badge" style="background:#e0e7ff;color:#4338ca;padding:5px 10px;border-radius:4px;font-size:12px;">' +
                            '<i class="fa fa-refresh mr-1"></i>Covering Day</span></td>' +
                            '</tr>'
                        );

                        // Show covering info in conflict section instead of running conflict check
                        $('#adminLeaveConflictMessage').html(
                            '<div style="background:#f0f0ff;border:1px solid #c7d2fe;border-radius:6px;padding:10px 14px;font-size:12px;color:#4338ca;">' +
                            '<i class="fa fa-info-circle mr-1"></i>' +
                            '<strong>Covering Day</strong> — No leave balance is deducted when approved.<br>' +
                            '<span style="color:#374151;">Employee will be off on <strong>' + (r.covering_leave_date || '—') + '</strong> ' +
                            'and work instead on <strong>' + (r.covering_cover_date || '—') + '</strong>.</span>' +
                            '</div>'
                        );
                        $('#conflictMessageSection').show();

                    } else {
                        // ── Normal leave types ────────────────────────────────
                        var leaveDays = r.leave_days || [];
                        var leaveType = r.leave_type || 'N/A';

                        if (r.leave_type === 'Multiple Days' && leaveDays.length >= 2) {
                            $tbody.append(
                                '<tr>' +
                                '<td>' + leaveDays[0] + ' &mdash; ' + leaveDays[leaveDays.length - 1] + '</td>' +
                                '<td>' + leaveType + ' (' + (r.day_type_label || 'Multiple Days') + ')</td>' +
                                '</tr>'
                            );
                        } else {
                            var singleDay = (leaveDays.length > 0 ? leaveDays[0] : null) || r.start_date || 'N/A';
                            $tbody.append(
                                '<tr>' +
                                '<td>' + singleDay + '</td>' +
                                '<td>' + leaveType + ' (' + (r.day_type_label || '—') + ')</td>' +
                                '</tr>'
                            );
                        }

                        // ── Conflict check for normal leaves ──────────────────
                        if (leaveDays.length > 0) {
                            function convertToMMDDYYYY(dateStr) {
                                if (!dateStr) return null;
                                if (/^\d{4}-\d{2}-\d{2}$/.test(dateStr)) {
                                    var p = dateStr.split('-');
                                    return p[1] + '/' + p[2] + '/' + p[0];
                                }
                                if (/^\d{2}\/\d{2}\/\d{4}$/.test(dateStr)) {
                                    var p = dateStr.split('/');
                                    return parseInt(p[0]) > 12 ?
                                        p[1] + '/' + p[0] + '/' + p[2] :
                                        p[1] + '/' + p[0] + '/' + p[2];
                                }
                                return null;
                            }

                            var typeMap = {
                                'Half Day': 0,
                                'One Day': 1,
                                'Multiple Days': 2,
                                'Short Leave': 3
                            };
                            var fromDate = convertToMMDDYYYY(leaveDays[0]);
                            var toDate = convertToMMDDYYYY(leaveDays[leaveDays.length - 1]);
                            var typeVal = typeMap[r.leave_type] !== undefined ? typeMap[r.leave_type] : 1;

                            $.ajax({
                                url: "{{ url('/check-leave-conflict') }}",
                                method: 'GET',
                                data: {
                                    from: fromDate,
                                    to: toDate,
                                    type: typeVal
                                },
                                success: function(cr) {
                                    $('#adminLeaveConflictMessage').html(
                                        cr.success ?
                                        '<p style="color:green;font-size:12px;margin-bottom:0;">✓ No conflicts found for this leave period.</p>' :
                                        cr.message
                                    );
                                    $('#conflictMessageSection').show();
                                },
                                error: function(xhr) {
                                    console.error('Conflict check error:', xhr.responseText);
                                }
                            });
                        }
                    }

                    $('#leaveModal').modal('hide');
                    $('#leave_Approve_modal').modal('show');
                },
                error: function() {
                    alert('Error fetching leave request details.');
                }
            });
        });

        $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(function(fn) {
            return fn._leaveFilter !== true;
        });

        var leaveFilter = function(settings, data) {
            if (settings.nTable.id !== 'employee_leave_req_table') return true;
            var emp = $('#filterEmployee').val();
            var type = $('#filterLeaveType').val();
            var status = $('#filterStatus').val();
            var leaveStatus = $('#filterLeaveStatus').val();
            if (emp && $.trim(data[1]) !== emp) return false;
            if (type && $.trim(data[2]) !== type) return false;
            if (status && $.trim(data[5]) !== status) return false;
            if (leaveStatus && $.trim(data[8]) !== leaveStatus) return false;
            return true;
        };
        leaveFilter._leaveFilter = true;
        $.fn.dataTable.ext.search.push(leaveFilter);

        var request_table = $('#employee_leave_req_table').DataTable({
            "paging": true,
            "scrollX": false,
            "pageLength": 40,
            "searching": true,
            "ordering": true,
            "order": [
                [8, 'asc'],
                [9, 'desc']
            ], // sort pending (0) first on load, then newest start date first
            "info": true, // Show "Showing X of Y entries"
            "lengthChange": true, // Enable "Show X entries" dropdown
            "responsive": true, // Enable responsive behavior
            "columnDefs": [{
                    "targets": [6, 7], // TOTAL LEAVE DAYS & ACTION
                    "className": "text-right"
                },
                {
                    "targets": [0, 2, 3, 4, 5], // EMPLOYEE ID, LEAVE TYPE, LEAVE START/END DATE, EMPLOYEE STATUS
                    "className": "text-center"
                },
                {
                    "targets": 7, // ACTION Column
                    "className": "text-center",
                    "orderable": false
                },
                {
                    "targets": 8,
                    "className": "text-center",
                    "orderable": false,
                    "visible": false
                },
                {
                    "targets": 9,
                    "className": "text-center",
                    "orderable": false,
                    "visible": false
                }
            ]
        });
        make_employee_leave_table();

        function make_employee_leave_table() {
            $('.se-pre-con').fadeIn(); // Show loader

            $.ajax({
                url: "{{ route('leave.GetTableDataAll') }}",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // console.log(response); // Debugging
                    update_employee_leave_table(response); // Function to update the table
                    $('.se-pre-con').fadeOut(); // Hide loader after data loads
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $('.se-pre-con').fadeOut(); // Hide loader even if there's an error
                }
            });
        }

        // function update_employee_leave_table(data) {
        //     var tableBody = $('#employee_leave_req_table tbody');
        //     tableBody.empty(); // Clear existing rows

        //     if (data.length === 0) {
        //         tableBody.append('<tr><td colspan="8" class="text-center">No leave requests found</td></tr>');
        //         return;
        //     }

        //     data.forEach(function(item) {
        //         var actionButtons = '';
        //         if (item.status == 0) {
        //             actionButtons = '<button class="btn btn-success btn-sm viewrequest" data-leaveid="' + item.id + '">Approve</button> ';
        //         } else if (item.status == 1) {
        //             actionButtons = '<span class="text-success viewrequest" data-leaveid="' + item.id + '">Approved</span>';
        //         } else if (item.status == 2) {
        //             actionButtons = '<span class="text-danger viewrequest" data-leaveid="' + item.id + '">Rejected</span>';
        //         }

        //         var totalDays = 0;
        //         if (item.type == 0) {
        //             totalDays = 'Half Day';
        //         } else if (item.type == 1) {
        //             totalDays = 1;
        //         } else if (item.type == 2) {
        //             var startDate = new Date(item.start_date);
        //             var endDate = new Date(item.end_date);
        //             totalDays = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
        //         }

        //         var row = '<tr>' +
        //             '<td>' + item.user_details.id + '</td>' +
        //             '<td>' + item.user_details.name + '</td>' +
        //             '<td>' + item.leave_type + '</td>' +
        //             '<td class="text-center">' + item.start_date + '</td>' +
        //             '<td class="text-center">' + item.end_date + '</td>' +
        //             '<td class="text-center">' + item.user_details.user_details.Employment_Status + '</td>' +
        //             '<td class="text-right">' + totalDays + '</td>' +
        //             '<td class="text-center">' + actionButtons + '</td>' +
        //             '</tr>';

        //         tableBody.append(row);
        //     });
        // }

        function update_employee_leave_table(data) {
            let table = $('#employee_leave_req_table').DataTable();
            table.clear();

            let employeesSet = new Set();
            let leaveTypesSet = new Set();
            let statusesSet = new Set();

            if (data && data.length) {
                function toIsoDate(dateStr) {
                    if (!dateStr) return '';
                    var parts = dateStr.split('/');
                    if (parts.length !== 3) return dateStr;
                    return parts[2] + '-' + parts[0].padStart(2, '0') + '-' + parts[1].padStart(2, '0');
                }

                data.sort(function(a, b) {
                    var statusDiff = a.status - b.status;
                    if (statusDiff !== 0) return statusDiff;
                    var aDate = toIsoDate(a.start_date || '');
                    var bDate = toIsoDate(b.start_date || '');
                    if (aDate > bDate) return -1;
                    if (aDate < bDate) return 1;
                    return 0;
                });

                data.forEach(function(item) {
                    let empName = item.user_details?.name || '';
                    let leaveType = toTitleCase(item.leave_type || '');
                    let empStatus = item.user_details?.user_details?.Employment_Status || '';
                    employeesSet.add(empName);
                    leaveTypesSet.add(leaveType);
                    statusesSet.add(empStatus);

                    let actionButtons = '';
                    if (item.status == 0) {
                        actionButtons = '<button class="btn btn-success btn-sm viewrequest" data-leaveid="' + item.id + '">Approve</button>';
                    } else if (item.status == 1) {
                        actionButtons = '<span class="text-success viewrequest" style="cursor:pointer;" data-leaveid="' + item.id + '">Approved</span>';
                    } else if (item.status == 2) {
                        actionButtons = '<span class="text-danger viewrequest" style="cursor:pointer;" data-leaveid="' + item.id + '">Rejected</span>';
                    }

                    let totalDays = 0;
                    if (item.type == 0) totalDays = 'Half Day';
                    else if (item.type == 1) totalDays = 1;
                    else if (item.type == 2) {
                        let start = new Date(item.start_date);
                        let end = new Date(item.end_date);
                        totalDays = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
                    } else if (item.type == 3) totalDays = 'Short Leave';
                    else if (item.type == 4) totalDays = '<span style="color:#6366f1;font-size:11px;font-weight:600;">Covering</span>';

                    table.row.add([
                        item.user_details?.id || '',
                        empName,
                        leaveType,
                        item.type == 4 ? (item.covering_leave_date || '—') + ' <small style="color:#6366f1;font-size:10px;">[Off]</small>' : (item.start_date || '—'),
                        item.type == 4 ? (item.covering_cover_date || '—') + ' <small style="color:#6366f1;font-size:10px;">[Cover]</small>' : (item.end_date || '—'),
                        empStatus,
                        totalDays,
                        actionButtons,
                        item.status,
                        toIsoDate(item.start_date || '')
                    ]);
                });
            }
            table.draw();

            // Populate filters using the helper from Step 1
            populateDropdown('#filterEmployee', Array.from(employeesSet));
            populateDropdown('#filterLeaveType', Array.from(leaveTypesSet));
            populateDropdown('#filterStatus', Array.from(statusesSet));
        }

        // ─── filter / reset buttons ───────────────────────────────────────
        $('#filterButton').on('click', function() {
            $('#employee_leave_req_table').DataTable().draw();
        });

        $('#resetButton').on('click', function() {
            $('#filterEmployee').val('');
            $('#filterLeaveType').val('');
            $('#filterStatus').val('');
            $('#filterLeaveStatus').val('');
            $('#employee_leave_req_table').DataTable().draw();
        });

        function populateDropdown(selector, valuesArray) {
            let $dropdown = $(selector);
            let currentVal = $dropdown.val();
            $dropdown.empty().append('<option value="">All</option>');
            valuesArray.forEach(function(val) {
                if (val && val.trim() !== '') {
                    $dropdown.append('<option value="' + val + '">' + val + '</option>');
                }
            });
            if (currentVal) $dropdown.val(currentVal);
        }

        /* ── Open modal ─────────────────────────────────────────────────── */
        $('[id="adminAddLeaveBtn"]').on('click', function() {
            resetAdminLeaveModal();
            loadEmployeeList();
            $('#adminAddLeaveModal').modal('show');
        });

        /* ── Auto-close — use Bootstrap's hidden.bs.modal event. ───────────────────── */
        $('#adminAddLeaveModal').on('hidden.bs.modal', function() {
            var shouldRefresh = $(this).data('refreshTable');
            resetAdminLeaveModal(); // Always reset

            if (shouldRefresh) {
                $(this).data('refreshTable', false); // Clear the flag
                if (typeof make_employee_leave_table === "function") {
                    make_employee_leave_table();
                } else {
                    console.error("Function make_employee_leave_table not found!");
                }
            }
        });

        /* ── Leave Day Type toggle ───────────────────────────────────────── */
        $('#adminLeave_dayType').on('change', function() {
            applyDayTypeUI($(this).val());
        });

        /* ── Employee change — use getLeaveBalance endpoint ─────────────────────────── */
        $('#adminLeave_userId').on('change', function() {
            var userId = $(this).val();

            $('#adminLeave_leaveType')
                .html('<option value="">— Select Leave Type —</option>')
                .prop('disabled', true);
            $('#adminLeave_balanceBadge').hide();

            // Clear validation on this field
            $(this).removeClass('is-invalid');
            $(this).siblings('.adminLeave-invalid-feedback').remove();

            if (!userId) return;

            $('#adminLeave_balanceBadge').show();
            $('#adminLeave_balanceText').html('<i class="fa fa-spinner fa-spin"></i>');

            $.ajax({
                url: '{{ url("/leave-Manage/getLeaveBalance") }}/' + userId,
                method: 'GET',
                success: function(res) {
                    var $sel = $('#adminLeave_leaveType');
                    $sel.empty().append('<option value="">— Select Leave Type —</option>');

                    if (!res.success || !res.balances || res.balances.length === 0) {
                        $sel.append('<option value="" disabled>No leave types found</option>');
                        $('#adminLeave_balanceText').text(res.message || 'No group assigned');
                        return;
                    }

                    res.balances.forEach(function(item) {
                        var remaining = parseInt(item.remaining) || 0;
                        var isZero = remaining <= 0;
                        var label = item.leave_type_name +
                            (isZero ? ' (0 remaining — unavailable)' : ' (' + remaining + ' remaining)');

                        var $opt = $('<option></option>')
                            .val(item.leave_type_name)
                            .text(label)
                            .attr('data-remaining', remaining);

                        if (isZero) {
                            $opt.prop('disabled', true)
                                .css('color', '#adb5bd');
                        }
                        $sel.append($opt);
                    });

                    $sel.prop('disabled', false);

                    // Badge summary
                    var parts = res.balances.map(function(item) {
                        var r = parseInt(item.remaining) || 0;
                        return item.leave_type_name + ' - ' + r;
                    });
                    $('#adminLeave_balanceText').text(parts.join(', '));
                },
                error: function() {
                    $('#adminLeave_leaveType').html('<option value="">Error loading</option>');
                    $('#adminLeave_balanceText').text('Error');
                }
            });
        });

        /* ── Multiple days: calculate total ─────────────────────────────── */
        $('#adminLeave_fromDate, #adminLeave_toDate').on('change', function() {
            var from = $('#adminLeave_fromDate').val();
            var to = $('#adminLeave_toDate').val();
            if (from && to) {
                var diff = Math.ceil((new Date(to) - new Date(from)) / 86400000) + 1;
                $('#adminLeave_calcText').text(
                    diff > 0 ? 'Total: ' + diff + ' day(s)' : '⚠ End date must be after start date'
                );
                $('#adminLeave_calcRow').show();
            }
        });

        /* ── Multi-Date Calendar Picker ─────────────────────────────────── */
        var adminCal = {
            year: new Date().getFullYear(),
            month: new Date().getMonth(), // 0-based
            selected: new Set() // keys: "YYYY-MM-DD"
        };

        function adminCalRender() {
            var DAYS = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];
            var monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            $('#adminLeave_calMonthLabel').text(monthNames[adminCal.month] + ' ' + adminCal.year);

            var $grid = $('#adminLeave_calGrid').empty();

            // Day-of-week headers
            DAYS.forEach(function(d) {
                $grid.append('<div style="font-weight:600;color:#888;padding:3px 0;">' + d + '</div>');
            });

            var firstDay = new Date(adminCal.year, adminCal.month, 1).getDay(); // 0=Sun
            var daysInMonth = new Date(adminCal.year, adminCal.month + 1, 0).getDate();

            // Blank cells before day 1
            for (var i = 0; i < firstDay; i++) {
                $grid.append('<div></div>');
            }

            for (var d = 1; d <= daysInMonth; d++) {
                var key = adminCal.year + '-' +
                    String(adminCal.month + 1).padStart(2, '0') + '-' +
                    String(d).padStart(2, '0');
                var dow = new Date(adminCal.year, adminCal.month, d).getDay();
                var isWeekend = (dow === 0 || dow === 6);
                var isSelected = adminCal.selected.has(key);

                var style = 'cursor:pointer; border-radius:4px; padding:5px 2px; font-size:12px; transition:background 0.1s;';
                if (isSelected) {
                    style += 'background:#2dce89; color:#fff; font-weight:600;';
                } else if (isWeekend) {
                    style += 'background:#fde8e8; color:#c0392b;';
                } else {
                    style += 'background:#f8f9fa; color:#333;';
                }

                $grid.append(
                    '<div data-key="' + key + '" style="' + style + '">' + d + '</div>'
                );
            }

            adminCalUpdateSummary();
        }

        function adminCalUpdateSummary() {
            var sorted = Array.from(adminCal.selected).sort();
            var $disp = $('#adminLeave_selectedDatesDisplay');
            var $prev = $('#adminLeave_splitPreview');
            var $calc = $('#adminLeave_calcRow');
            var $calcTxt = $('#adminLeave_calcText');

            if (sorted.length === 0) {
                $disp.text('No dates selected.');
                $prev.html('');
                $calc.hide();
                return;
            }

            // Pretty-print dates
            $disp.text('Selected (' + sorted.length + '): ' +
                sorted.map(function(k) {
                    var p = k.split('-');
                    return p[2] + '/' + p[1];
                }).join(', ')
            );

            // Build split groups (consecutive = same record)
            var groups = adminCalBuildGroups(sorted);
            var html = '<strong>Will create ' + groups.length + ' leave record(s):</strong><ul style="margin:4px 0 0 16px; padding:0;">';
            groups.forEach(function(g, i) {
                if (g.length === 1) {
                    html += '<li>Record ' + (i + 1) + ': 1 day — ' + g[0] + '</li>';
                } else {
                    html += '<li>Record ' + (i + 1) + ': ' + g.length + ' days — ' + g[0] + ' → ' + g[g.length - 1] + '</li>';
                }
            });
            html += '</ul>';
            $prev.html(html);

            $calcTxt.text('Total: ' + sorted.length + ' day(s) across ' + groups.length + ' record(s)');
            $calc.show();
        }

        /**
         * Given sorted "YYYY-MM-DD" strings, group consecutive calendar days.
         * Returns array of arrays, each sub-array is one consecutive run.
         */
        function adminCalBuildGroups(sorted) {
            if (!sorted.length) return [];
            var groups = [];
            var current = [sorted[0]];

            for (var i = 1; i < sorted.length; i++) {
                var prev = new Date(sorted[i - 1]);
                var curr = new Date(sorted[i]);
                var diff = (curr - prev) / 86400000; // days
                if (diff === 1) {
                    current.push(sorted[i]);
                } else {
                    groups.push(current);
                    current = [sorted[i]];
                }
            }
            groups.push(current);
            return groups;
        }

        // Date cell click — toggle
        $(document).on('click', '#adminLeave_calGrid [data-key]', function() {
            var key = $(this).data('key');
            if (adminCal.selected.has(key)) {
                adminCal.selected.delete(key);
            } else {
                adminCal.selected.add(key);
            }
            adminCalRender();
        });

        // Prev/Next month
        $('#adminLeave_calPrev').on('click', function() {
            adminCal.month--;
            if (adminCal.month < 0) {
                adminCal.month = 11;
                adminCal.year--;
            }
            adminCalRender();
        });
        $('#adminLeave_calNext').on('click', function() {
            adminCal.month++;
            if (adminCal.month > 11) {
                adminCal.month = 0;
                adminCal.year++;
            }
            adminCalRender();
        });

        /* ── Day type toggle — extend existing applyDayTypeUI ────────────────────── */
        // Override your existing applyDayTypeUI to init calendar when multiple_days shown
        var _origApplyDayTypeUI = applyDayTypeUI; // save original if needed
        applyDayTypeUI = function(val) {
            var map = {
                half_day: ['#adminLeave_singleDateRow', '#adminLeave_halfDayRow'],
                one_day: ['#adminLeave_singleDateRow'],
                multiple_days: ['#adminLeave_multiRow'],
                short_leave: ['#adminLeave_shortRow', '#adminLeave_shortTimeRow']
            };
            $('#adminLeave_singleDateRow,#adminLeave_halfDayRow,#adminLeave_multiRow,' +
                '#adminLeave_multiRowTo,#adminLeave_shortRow,#adminLeave_shortTimeRow,#adminLeave_calcRow').hide();
            if (map[val]) $(map[val].join(',')).show();

            if (val === 'multiple_days') {
                adminCalRender(); // Draw calendar
            }
        };

        /* ── Reset — clear calendar selection too ───────────────────────────────── */
        var _origReset = resetAdminLeaveModal;
        resetAdminLeaveModal = function() {
            _origReset();
            adminCal.selected = new Set();
            adminCal.year = new Date().getFullYear();
            adminCal.month = new Date().getMonth();
            $('#adminLeave_selectedDatesDisplay').text('');
            $('#adminLeave_splitPreview').html('');
        };

        /* ── Save ────────────────────────────────────────────────────────── */
        $('#adminLeave_saveBtn').on('click', function() {
            $('#adminLeave_error').hide().html('');
            $('#adminLeave_success').hide();

            // Clear previous validation
            $('.adminLeave-field').removeClass('is-invalid');
            $('.adminLeave-invalid-feedback').remove();

            var hasError = false;

            function markInvalid(selector, msg) {
                var $el = $(selector);
                $el.addClass('is-invalid');
                if (!$el.siblings('.adminLeave-invalid-feedback').length) {
                    $el.after('<div class="adminLeave-invalid-feedback" ' +
                        'style="color:#dc3545;font-size:11px;margin-top:3px;">' +
                        '<i class="fa fa-exclamation-circle mr-1"></i>' + msg + '</div>');
                }
                hasError = true;
            }

            var userId = $('#adminLeave_userId').val();
            var title = $.trim($('#adminLeave_title').val());
            var leaveType = $('#adminLeave_leaveType').val().toLowerCase();
            var dayType = $('#adminLeave_dayType').val();
            var note = $.trim($('#adminLeave_note').val());

            // ── Required field checks ───────────────────────────────────
            if (!userId) markInvalid('#adminLeave_userId', 'Please select an employee.');
            if (!title) markInvalid('#adminLeave_title', 'Title is required.');
            if (!leaveType) markInvalid('#adminLeave_leaveType', 'Please select a leave type.');
            if (!dayType) markInvalid('#adminLeave_dayType', 'Please select a leave day type.');

            // ── Check zero remaining ────────────────────────────────────
            if (leaveType) {
                var remaining = parseInt($('#adminLeave_leaveType').find(':selected').attr('data-remaining')) || 0;
                if (remaining <= 0) {
                    markInvalid('#adminLeave_leaveType',
                        'This leave type has 0 days remaining. Choose a different type.');
                }
            }

            // ── Per day-type field checks ───────────────────────────────
            if (dayType === 'half_day') {
                if (!$('#adminLeave_singleDate').val())
                    markInvalid('#adminLeave_singleDate', 'Please select a date.');
                if (!$('#adminLeave_halfDayTime').val())
                    markInvalid('#adminLeave_halfDayTime', 'Please select Morning or Evening.');
            }

            if (dayType === 'one_day') {
                if (!$('#adminLeave_singleDate').val())
                    markInvalid('#adminLeave_singleDate', 'Please select a date.');
            }

            if (dayType === 'multiple_days') {
                if (adminCal.selected.size === 0) {
                    $('#adminLeave_splitPreview').html(
                        '<div style="color:#dc3545;font-size:11px;">' +
                        '<i class="fa fa-exclamation-circle mr-1"></i>' +
                        'Please select at least one date on the calendar.</div>'
                    );
                    hasError = true;
                }
            }

            if (dayType === 'short_leave') {
                if (!$('#adminLeave_shortDate').val())
                    markInvalid('#adminLeave_shortDate', 'Please select a date.');
                var sf = $('#adminLeave_shortFrom').val();
                var st = $('#adminLeave_shortTo').val();
                if (!sf) markInvalid('#adminLeave_shortFrom', 'Please enter from time.');
                if (!st) markInvalid('#adminLeave_shortTo', 'Please enter to time.');
                if (sf && st && sf >= st)
                    markInvalid('#adminLeave_shortTo', 'To time must be after from time.');
            }

            if (hasError) return; // Stop — show red fields

            // ── Build payload and submit ────────────────────────────────
            var payload = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                user_id: userId,
                title: title,
                leave_type: leaveType,
                day_type: dayType,
                note: note,
                status: 1
            };

            if (dayType === 'half_day') {
                payload.date = formatToSlash($('#adminLeave_singleDate').val());
                payload.half_time = $('#adminLeave_halfDayTime').val();

            } else if (dayType === 'one_day') {
                payload.date = formatToSlash($('#adminLeave_singleDate').val());

            } else if (dayType === 'multiple_days') {
                // ── Multiple groups: sequential AJAX ───────────────────
                var sorted = Array.from(adminCal.selected).sort();
                var groups = adminCalBuildGroups(sorted);

                var $btn = $('#adminLeave_saveBtn')
                    .prop('disabled', true)
                    .html('<i class="fa fa-spinner fa-spin mr-1"></i> Saving…');

                var basePayload = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    user_id: userId,
                    title: title,
                    leave_type: leaveType,
                    note: note,
                    status: 1
                };

                var promises = groups.map(function(g) {
                    var p = $.extend({}, basePayload);
                    if (g.length === 1) {
                        p.day_type = 'one_day';
                        p.date = formatToSlash(g[0]);
                    } else {
                        p.day_type = 'multiple_days';
                        p.from_date = formatToSlash(g[0]);
                        p.to_date = formatToSlash(g[g.length - 1]);
                    }
                    return $.ajax({
                        url: "{{ url('/admin-leave/store') }}",
                        method: 'POST',
                        data: p
                    });
                });

                $.when.apply($, promises)
                    .done(function() {
                        $btn.prop('disabled', false)
                            .html('<i class="fa fa-save mr-1"></i> Save as Approved');
                        $('#adminLeave_success')
                            .text('Saved ' + groups.length + ' leave record(s) successfully.')
                            .show();
                        $('#adminAddLeaveModal').data('refreshTable', true);
                        setTimeout(function() {
                            $('#adminAddLeaveModal').modal('hide');
                        }, 1600);
                    })
                    .fail(function(xhr) {
                        $btn.prop('disabled', false)
                            .html('<i class="fa fa-save mr-1"></i> Save as Approved');
                        showAdminError((xhr.responseJSON && xhr.responseJSON.message) || 'An error occurred.');
                    });
                return; // async — stop here

            } else if (dayType === 'short_leave') {
                payload.date = formatToSlash($('#adminLeave_shortDate').val());
                payload.short_from = $('#adminLeave_shortFrom').val();
                payload.short_to = $('#adminLeave_shortTo').val();
            }

            // ── Single record submit (half_day / one_day / short_leave) ─
            var $btn = $('#adminLeave_saveBtn')
                .prop('disabled', true)
                .html('<i class="fa fa-spinner fa-spin mr-1"></i> Saving…');

            $.ajax({
                url: "{{ url('/admin-leave/store') }}",
                method: 'POST',
                data: payload,
                success: function(res) {
                    $btn.prop('disabled', false)
                        .html('<i class="fa fa-save mr-1"></i> Save as Approved');
                    if (res.success) {
                        $('#adminLeave_success').text('Leave record saved successfully as Approved.').show();
                        $('#adminAddLeaveModal').data('refreshTable', true);
                        setTimeout(function() {
                            $('#adminAddLeaveModal').modal('hide');
                        }, 1500);
                    } else {
                        showAdminError(res.message || 'Failed to save leave.');
                    }
                },
                error: function(xhr) {
                    $btn.prop('disabled', false)
                        .html('<i class="fa fa-save mr-1"></i> Save as Approved');
                    var msg = 'An error occurred.';
                    if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        msg = Object.values(xhr.responseJSON.errors)
                            .map(function(e) {
                                return e.join(', ');
                            }).join('<br>');
                    }
                    showAdminError(msg);
                }
            });
        });

        function loadEmployeeList() {
            $.ajax({
                url: "{{ url('/admin-leave/get-employees') }}",
                method: 'GET',
                success: function(res) {
                    var $sel = $('#adminLeave_userId');
                    $sel.empty().append('<option value="">— Select Employee —</option>');
                    if (res.employees) {
                        res.employees.forEach(function(emp) {
                            $sel.append(
                                '<option value="' + emp.id + '">' +
                                emp.name + ' (#' + emp.id + ')' +
                                '</option>'
                            );
                        });
                    }
                }
            });
        }

        function applyDayTypeUI(val) {
            // Hide ALL rows first
            $('#adminLeave_singleDateRow,#adminLeave_halfDayRow,#adminLeave_multiRow,' +
                '#adminLeave_shortRow,#adminLeave_shortTimeRow,#adminLeave_calcRow').hide();

            // Remove validation highlights when switching type
            $('.adminLeave-field').removeClass('is-invalid');
            $('.adminLeave-invalid-feedback').remove();

            var map = {
                half_day: ['#adminLeave_singleDateRow', '#adminLeave_halfDayRow'],
                one_day: ['#adminLeave_singleDateRow'],
                multiple_days: ['#adminLeave_multiRow'],
                short_leave: ['#adminLeave_shortRow', '#adminLeave_shortTimeRow']
            };
            if (val && map[val]) {
                $(map[val].join(',')).show();
                if (val === 'multiple_days') adminCalRender();
            }
        }

        function resetAdminLeaveModal() {
            $('#adminLeave_userId').val('');
            $('#adminLeave_title').val('');
            $('#adminLeave_singleDate').val('');
            $('#adminLeave_shortDate').val('');
            $('#adminLeave_shortFrom').val('');
            $('#adminLeave_shortTo').val('');
            $('#adminLeave_note').val('');

            // Reset dropdowns to blank (no auto-select)
            $('#adminLeave_dayType').val('').trigger('change');
            $('#adminLeave_halfDayTime').val('');
            $('#adminLeave_leaveType')
                .html('<option value="">— Select Employee first —</option>')
                .prop('disabled', true);

            // Hide all dynamic rows
            $('#adminLeave_singleDateRow,#adminLeave_halfDayRow,#adminLeave_multiRow,' +
                '#adminLeave_shortRow,#adminLeave_shortTimeRow,#adminLeave_calcRow').hide();

            // Hide balance badge
            $('#adminLeave_balanceBadge').hide();

            // Clear errors/success
            $('#adminLeave_error,#adminLeave_success').hide().html('');

            // Remove all red validation highlights
            $('.adminLeave-field').removeClass('is-invalid');
            $('.adminLeave-invalid-feedback').remove();

            // Reset calendar
            adminCal.selected = new Set();
            adminCal.year = new Date().getFullYear();
            adminCal.month = new Date().getMonth();
            $('#adminLeave_selectedDatesDisplay').text('');
            $('#adminLeave_splitPreview').html('');

            // Reset save button
            $('#adminLeave_saveBtn')
                .prop('disabled', false)
                .html('<i class="fa fa-save mr-1"></i> Save as Approved');
        }

        function showAdminError(msg) {
            $('#adminLeave_error').html(msg).show();
        }

        // yyyy-mm-dd (HTML date input) → mm/dd/yyyy (your DB format)
        function formatToSlash(ymd) {
            var p = ymd.split('-');
            return p[1] + '/' + p[2] + '/' + p[0];
        }

    });
    var leaveCalendarInstance = null; // shared between both scopes
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the DataTable for the leave requests table
        var leaveRequestTable = $('#leaveRequestsTable').DataTable({
            "paging": true,
            "scrollX": false,
            "pageLength": 10,
            "searching": false,
            "ordering": false,
            "info": true, // Show "Showing X of Y entries"
            "lengthChange": false, // Enable "Show X entries" dropdown
            "responsive": false, // Enable responsive behavior
            "columnDefs": [{
                    "targets": [3, 4], // LEAVE STATUS & ACTION
                    "className": "text-center"
                },
                {
                    "targets": [0, 1, 2], // EMPLOYEE NAME, LEAVE START/END DATE
                    "className": "text-center"
                },
                {
                    "targets": -1, // ACTION Column (Last Column)
                    "className": "text-center",
                    "orderable": false // Disable sorting for the last column
                }
            ]
        });

        var calendarEl = document.getElementById('leaveCalendar');
        leaveCalendarInstance = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 'auto',
            eventDisplay: 'block', // Ensures text is visible inside the calendar
            firstDay: 1,
            eventDisplay: 'block',
            dayCellDidMount: function(info) {
                var day = info.date.getDay();
                var isToday = info.el.classList.contains('fc-day-today');
                if (!isToday) {
                    if (day === 6) {
                        info.el.style.backgroundColor = '#ffcdcd'; // Saturday — light red
                    } else if (day === 0) {
                        info.el.style.backgroundColor = '#c75f53'; // Sunday — dark red
                    }
                }
            },

            events: function(fetchInfo, successCallback, failureCallback) {
                $.ajax({
                    url: "{{ route('leave.GetTableDataAll') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var events = [];
                        var today = new Date();
                        today.setHours(0, 0, 0, 0);

                        // mm/dd/yyyy → yyyy-mm-dd
                        function fmtISO(dateStr) {
                            if (!dateStr || dateStr.trim() === '') return null;
                            var parts = dateStr.split('/');
                            if (parts.length !== 3) return null;
                            return parts[2] + '-' + parts[0].padStart(2, '0') + '-' + parts[1].padStart(2, '0');
                        }

                        // Push a single day event
                        function pushEvent(isoDate, name, leaveId, isPast, isCovering) {
                            var color;
                            if (isCovering) {
                                color = isPast ? '#9ca3af' : '#22c55e'; // grey past, green future
                            } else {
                                // Normal leave: red for today/future, grey for past
                                color = isPast ? '#9ca3af' : '#ef4444';
                            }
                            events.push({
                                title: name,
                                start: isoDate,
                                color: color,
                                textColor: '#fff',
                                extendedProps: {
                                    user: name,
                                    startDate: isoDate,
                                    endDate: isoDate,
                                    status: 'Approved',
                                    leaveId: leaveId
                                }
                            });
                        }

                        response.forEach(function(leave) {
                            // Only show approved
                            if (leave.status != 1) return;

                            var name = leave.user_details ? leave.user_details.name : 'Employee';

                            // ── Covering Day (type 4) ──────────────────────────────
                            if (leave.type == 4) {
                                var offISO = fmtISO(leave.covering_leave_date);
                                if (offISO) {
                                    var isPast = new Date(offISO) < today;
                                    events.push({
                                        title: name + ' (Off)',
                                        start: offISO,
                                        color: isPast ? '#9ca3af' : '#22c55e',
                                        textColor: '#fff',
                                        extendedProps: {
                                            user: name,
                                            startDate: leave.covering_leave_date,
                                            endDate: leave.covering_cover_date,
                                            status: 'Approved',
                                            leaveId: leave.id
                                        }
                                    });
                                }
                                return; // don't process start_date for covering
                            }

                            // ── Normal leave ──────────────────────────────────────
                            var startISO = fmtISO(leave.start_date);
                            if (!startISO) return;

                            var endISO = leave.end_date && leave.end_date.trim() !== '' ?
                                fmtISO(leave.end_date) :
                                startISO;
                            if (!endISO) endISO = startISO;

                            var cur = new Date(startISO);
                            var endDate = new Date(endISO);

                            while (cur <= endDate) {
                                var iso = cur.getFullYear() + '-' +
                                    String(cur.getMonth() + 1).padStart(2, '0') + '-' +
                                    String(cur.getDate()).padStart(2, '0');
                                var isPast = cur < today;
                                pushEvent(iso, name, leave.id, isPast, false);
                                cur.setDate(cur.getDate() + 1);
                            }
                        });

                        // ── Public Holidays ───────────────────────────────────────
                        var yr = new Date().getFullYear();
                        [{
                                date: yr + '-02-04',
                                title: 'National Day'
                            },
                            {
                                date: yr + '-04-13',
                                title: 'Sinhala New Year'
                            },
                            {
                                date: yr + '-04-14',
                                title: 'Sinhala New Year'
                            },
                            {
                                date: yr + '-05-01',
                                title: 'May Day / Vesak Poya'
                            },
                            {
                                date: yr + '-06-29',
                                title: 'Poson Poya Day'
                            },
                            {
                                date: yr + '-12-25',
                                title: 'Christmas Day'
                            }
                        ].forEach(function(h) {
                            events.push({
                                title: '🏖 ' + h.title,
                                start: h.date,
                                color: '#f97316',
                                textColor: '#fff',
                                display: 'block',
                                editable: false
                            });
                        });

                        successCallback(events);
                    },
                    error: function() {
                        console.error('Error fetching calendar events');
                        failureCallback();
                    }
                });
            },

            dateClick: function(info) {
                // When a date is clicked, open the modal with all leave requests for that day
                // console.log('Clicked date: ' + info.dateStr);

                // Update modal title to show the selected date
                document.getElementById('modalDate').textContent = info.dateStr;

                // Get events for that specific date
                var clickedDate = info.dateStr; // Date in yyyy-mm-dd format
                var clickedEvents = leaveCalendarInstance.getEvents().filter(event => event.startStr == clickedDate);

                // Clear the DataTable before adding new rows
                leaveRequestTable.clear();

                // Add rows to the table for each leave request on the clicked date
                clickedEvents.forEach(function(event) {
                    var statusText = event.extendedProps.status;
                    var approveButton = statusText == 'Pending' ?
                        `<button class="btn btn-success viewrequest btn-sm" data-leaveid="${event.extendedProps.leaveId}">Approve</button>` :
                        '';

                    leaveRequestTable.row.add([
                        event.extendedProps.user,
                        event.extendedProps.startDate,
                        event.extendedProps.endDate || 'N/A',
                        statusText,
                        approveButton
                    ]);
                });

                // Draw the updated table
                leaveRequestTable.draw();

                // Show the modal
                $('#leaveModal').modal('show');
            }
        });

        // Render calendar
        leaveCalendarInstance.render();

        // First-time load issue when switching to the tab
        $('a[href="#employee-leave"]').on('shown.bs.tab', function() {
            setTimeout(function() {
                leaveCalendarInstance.updateSize();
            }, 200);
        });


    });

    $('#filterPanelToggle').on('click', function() {
        $('#filterPanelBody').slideToggle(200);
        $('#filterPanelChevron').toggleClass('fa-chevron-up fa-chevron-down');
    });

    function goBackOnePage() {
        if (document.referrer && document.referrer.indexOf(window.location.host) !== -1) {
            window.history.back();
        } else {
            window.location.href = "{{ route('home') }}";
        }
    }
</script>
@endsection