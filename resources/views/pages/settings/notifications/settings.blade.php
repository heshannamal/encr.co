@extends('layouts.app', ['activePage' => 'Notification_settings', 'titlePage' => __('Notification Settings')])

@section('content')
<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>

    .se-pre-con {
        position: fixed;
        display: none;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }
    .btn-green-filled{
        outline: unset !important;
        padding: 8px;
        color: white;
        background-color: #47D6B6;
        border: 2px solid #47D6B6;
        font-weight: 700;
        font-size: .7rem;
        cursor: pointer;
    }
    .card{
        border: none;
        border-radius: 0rem;
    }
    .header-style{
        background-color: rgba(50, 50, 50, 1) !important;
        height: 40px;
    }

    .togelcheck {
        position: relative;
        width: 20px;
        height: 10px;
        -webkit-appearance: none;
        background: #c6c6c6;
        outline: none;
        border-radius: 20px;
        box-shadow: inset 0 0 5px rgba(255, 0, 0, 0.2);
        transition: 0.7s;
    }

    .togelcheck:checked[type="checkbox"] {
    background: #03a9f4;
    }

    .togelcheck:before {
        content: '';
        position: absolute;
        width: 10px;
        height: 10px;
        border-radius: 20px;
        top: 0;
        left: 0;
        background: #ffffff;
        transform: scale(1.1);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        transition: .5s;
    }

    .togelcheck:checked[type="checkbox"]:before {
        left: 10px;
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
    .new-style-table .alphabet {
        padding-right: 1rem;
        padding-left: 1rem;
    }
    .new-style-table table thead tr{
        background-color: rgba(50, 50, 50, 1) !important;
        height: 40px;
    }
    .new-style-table .table tbody td , .new-style-table .table tbody td a {
        padding: 0.4rem 1rem !important;
        font-size: .9rem !important;
        color: rgba(22, 22, 23, 1) !important;
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


    /* Notification users modal - reference layout */
    #EditTemplateusersModal {
        padding-right: 0 !important;
    }

    #EditTemplateusersModal .modal-dialog {
        width: calc(100% - 54px);
        margin: 34px auto;
    }

    #EditTemplateusersModal .modal-content {
        max-height: calc(100vh - 100px);
        overflow: hidden;
        border: 0;
        border-radius: 6px;
        box-shadow: 0 7px 28px rgba(0, 0, 0, 0.18);
    }

    #EditTemplateusersModal .modal-header {
        min-height: 58px;
        padding: 17px 20px 12px;
        border-bottom: 0;
    }

    #EditTemplateusersModal .modal-title {
        color: #263457;
        font-size: 14px;
        font-weight: 600;
    }

    #EditTemplateusersModal .modal-header .close {
        margin: -6px -4px -6px auto;
        padding: 8px;
        color: #8b8b8b;
        font-size: 22px;
        line-height: 1;
        opacity: .7;
    }

    #EditTemplateusersModal .modal-header .close:hover {
        opacity: 1;
    }

    #EditTemplateusersModal .modal-body {
        max-height: calc(100vh - 175px);
        padding: 10px 22px 20px;
        overflow-x: hidden;
        overflow-y: auto;
    }

    #EditTemplateusersModal #notificationUsersContainer > .col-md-12 {
        padding-right: 0;
        padding-left: 0;
    }

    .notification-user-card {
        margin-bottom: 16px !important;
        overflow: hidden;
        border: 1px solid #e4e7eb !important;
        border-radius: 5px !important;
        background: #fff;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.025);
    }

    .notification-user-card .card-header {
        min-height: 35px;
        padding: 6px 5px 6px 2px;
        background: #fff;
        border-bottom: 0;
    }

    .notification-user-card .card-header strong {
        color: #111;
        font-size: 14px;
        font-weight: 600;
        line-height: 1.2;
    }

    .notification-user-card .card-header label {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        color: #111;
        font-size: 13px;
        font-weight: 400;
        white-space: nowrap;
    }

    .notification-user-card .card-header input[type="checkbox"] {
        width: 13px;
        height: 13px;
        margin: 0;
    }

    .notification-user-card .card-body {
        padding: 12px 14px;
        border-top: 1px solid #edf0f2;
        background: #fff;
    }

    .toggle-notification-card {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        min-width: 20px;
        height: 20px;
        margin-left: 8px;
        padding: 0 !important;
        border: 0 !important;
        color: #111 !important;
        text-decoration: none !important;
        box-shadow: none !important;
        font-size: 12px;
        font-weight: 700;
        line-height: 1;
    }

    .toggle-notification-card:hover,
    .toggle-notification-card:focus {
        color: #111 !important;
        text-decoration: none !important;
        background: transparent !important;
        box-shadow: none !important;
    }

    .collapse-symbol {
        display: block;
        transform: translateY(-1px);
    }

    .all-selected-users-card {
        margin-bottom: 17px !important;
        border-color: #d8e2f5 !important;
        border-radius: 7px !important;
        box-shadow: none;
    }

    .all-selected-users-card .card-header {
        min-height: 53px;
        padding: 13px 16px;
        background: #edf3ff;
    }

    .all-selected-users-card .card-header strong {
        display: inline-flex;
        align-items: center;
        gap: 11px;
    }

    .selected-recipient-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 28px;
        height: 25px;
        padding: 0 8px;
        border-radius: 999px;
        background: #304b82;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        line-height: 1;
    }

    .all-selected-users-card .card-body {
        padding: 13px 16px;
        border-top-color: #d8e2f5;
    }

    .selected-user-row {
        display: flex;
        align-items: center;
        gap: 10px;
        min-height: 32px;
        margin-bottom: 3px;
    }

    .selected-user-row:last-child {
        margin-bottom: 0;
    }

    .selected-user-row input[type="checkbox"] {
        width: 14px;
        height: 14px;
        margin: 0;
    }

    .selected-user-name {
        margin: 0;
        color: #111;
        font-size: 14px;
        font-weight: 400;
    }

    .selected-users-empty {
        padding: 4px 0;
        color: #6c757d;
        font-size: 14px;
    }


    /* Two selected entries per row in the summary card */
    #allSelectedUsersContainer {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 7px 10px;
    }

    #allSelectedUsersContainer .selected-user-row {
        min-height: 38px;
        margin-bottom: 0;
        padding: 6px 9px;
        border: 1px solid #e6ebf2;
        border-radius: 5px;
        background: #fff;
    }

    #allSelectedUsersContainer .selected-users-empty {
        grid-column: 1 / -1;
    }

    #EditTemplateusersModal .modal-footer {
        margin: 18px -22px -20px;
        padding: 12px 22px;
        border-top: 1px solid #eceff2;
        background: #fff;
    }

    /* =====================================================================
       Notification Settings - mobile additions 
       ===================================================================== */

    /* Desktop: same values as the old inline styles */
    .ns-page .ns-table-col { padding-right: 19px; }
    .ns-link-blue  { color: #3a82ad; cursor: pointer; }
    .ns-link-green { color: #3bad3a; cursor: pointer; }

    /* Mobile-only pieces are hidden on desktop */
    .ns-mobile-only,
    .ns-more-info,
    .ns-page .ns-full { display: none; }

    @media (max-width: 767.98px) {
        /* Toggle desktop-only / mobile-only pieces */
        .ns-desktop-only { display: none !important; }
        .ns-mobile-only  { display: inline; }

        /* ---------- Page spacing ----------
           mb-5 (3rem, !important) leaves a big gap above the footer. */
        .ns-page {
            margin-bottom: 0 !important;
            padding-bottom: 20px;
        }

        /* ---------- Header: Add Template button (right side) ----------
           The page title is already shown by the layout, so it is not repeated. */
        .ns-page .ns-mobile-header {
            display: block;
            padding-top: 4px;
        }
        .ns-page .ns-title-row {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-top: 10px;
        }
        .ns-page .ns-add-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
            padding: 9px 14px;
            font-size: 13px;
            font-weight: 600;
            line-height: 1.2;
            white-space: nowrap;
            color: #fff;
            background-color: #45d4b8;
            border: 0;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(69, 212, 184, .35);
            cursor: pointer;
        }
        .ns-page .ns-add-btn:active {
            background-color: #3cc4a9;
        }
        .ns-page .ns-add-btn svg {
            width: 12px;
            height: 12px;
        }

        /* ---------- Outer wrappers ----------
           The column sits directly in .container-fluid (no .row);
           mt-4 uses !important. */
        .ns-page .ns-outer-col {
            margin-top: 14px !important;
            padding-left: 0;
            padding-right: 0;
        }
        .ns-page .ns-main-card {
            background-color: transparent;
            border: 0;
            box-shadow: none;
        }
        .ns-page .ns-table-col {
            margin-top: 0 !important;
            padding-left: 0;
            padding-right: 0;
        }

        /* ---------- Search card ---------- */
        .ns-page .ns-mobile-toolbar {
            display: block;
        }
        .ns-page .ns-search-card {
            padding: 12px;
            background-color: #fff;
            border: 1px solid #ececec;
            border-radius: 12px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .06);
        }
        .ns-page .ns-search-box {
            display: flex;
            align-items: center;
            gap: 10px;
            height: 40px;
            padding: 0 12px;
            background-color: #f5f6f7;
            border: 1px solid #e3e3e3;
            border-radius: 8px;
        }
        .ns-page .ns-search-box svg {
            width: 15px;
            height: 15px;
            flex-shrink: 0;
            color: #333;
        }
        .ns-page .ns-search-input {
            flex: 1 1 auto;
            min-width: 0;
            height: 100%;
            padding: 0;
            font-size: 14px;
            color: #1d1d1f;
            background: transparent;
            border: 0;
            outline: none;
            box-shadow: none;
        }
        .ns-page .ns-search-input::placeholder {
            color: #a3a3a3;
        }

        /* ---------- Show entries / Sort by row ---------- */
        .ns-page .ns-filter-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 8px 12px;
            margin: 14px 0 10px;
        }
        .ns-page .ns-filter-group {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            font-size: 13px;
            font-weight: 400;
            color: #8c8c8c;
            white-space: nowrap;
        }
        .ns-page .ns-select {
            height: 30px;
            padding: 0 26px 0 10px;
            font-size: 13px;
            color: #1d1d1f;
            background-color: #fff;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' fill='none' stroke='%23333' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 9px center;
            background-size: 9px 6px;
            border: 1px solid #dedede;
            border-radius: 6px;
            outline: none;
            -webkit-appearance: none;
            appearance: none;
        }

        /* The custom search / length / sort controls above replace these */
        .ns-page .dataTables_length,
        .ns-page .dataTables_filter {
            display: none;
        }

        /* ---------- Table -> cards ----------
           Several existing table rules use !important (padding, font-size,
           colour, borders), so !important is needed here to override them. */
        .ns-page .new-style-table table.dataTable,
        .ns-page .new-style-table table.table-responsive {
            display: block;
            overflow: visible;
            margin: 0 !important;
            border: 0 !important;
        }
        .ns-page .new-style-table table thead {
            display: none;
        }
        .ns-page .new-style-table table tbody {
            display: block;
        }
        .ns-page .new-style-table .table tbody tr {
            display: grid;
            grid-template-columns: auto 1fr auto;
            grid-template-areas:
                "name   name   toggle"
                "key    key    key"
                "func   func   func"
                "ctrl   ctrl   ctrl"
                "users  edit   more"
                "title  title  title"
                "mtitle mtitle mtitle"
                "body   body   body"
                "desc   desc   desc";
            align-items: start;
            min-height: 0;
            margin: 0 0 10px;
            padding: 14px;
            color: #1d1d1f;
            background-color: #fff;
            border: 1px solid #ececec !important;
            border-radius: 10px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .06);
            overflow: hidden;
        }
        .ns-page .new-style-table .table tbody tr:hover {
            background-color: #fff;
        }
        .ns-page .new-style-table .table tbody td {
            display: block;
            min-width: 0;
            padding: 0 !important;
            font-size: 12px !important;
            line-height: 1.45;
            color: #1d1d1f !important;
            text-align: left !important;
            white-space: normal;
            overflow-wrap: anywhere;
            background: transparent;
            border: 0 !important;
        }

        /* 1: status toggle */
        .ns-page .new-style-table .table tbody tr > td:nth-child(1) {
            grid-area: toggle;
            justify-self: end;
            margin-left: 10px;
            line-height: 1;
        }
        /* 2: name */
        .ns-page .new-style-table .table tbody tr > td:nth-child(2) {
            grid-area: name;
            align-self: center;
            font-size: 14.5px !important;
            font-weight: 700;
            line-height: 1.35;
        }
        /* 3: key */
        .ns-page .new-style-table .table tbody tr > td:nth-child(3) {
            grid-area: key;
            margin-top: 4px;
            font-size: 13px !important;
            word-break: break-all;
        }
        /* 4: function name, 5: controller */
        .ns-page .new-style-table .table tbody tr > td:nth-child(4) {
            grid-area: func;
            margin-top: 8px;
            word-break: break-word;
        }
        .ns-page .new-style-table .table tbody tr > td:nth-child(5) {
            grid-area: ctrl;
            margin-top: 3px;
            word-break: break-word;
        }
        .ns-page .new-style-table .table tbody tr > td:nth-child(4)::before,
        .ns-page .new-style-table .table tbody tr > td:nth-child(5)::before {
            display: inline-block;
            margin-right: 8px;
            font-size: 11px;
            color: #8c8c8c;
        }
        .ns-page .new-style-table .table tbody tr > td:nth-child(4)::before { content: 'Function Name'; }
        .ns-page .new-style-table .table tbody tr > td:nth-child(5)::before { content: 'Controller'; }

        /* 6: View Users, 11: actions (Edit + More Info become grid items) */
        .ns-page .new-style-table .table tbody tr > td:nth-child(6) {
            grid-area: users;
        }
        .ns-page .new-style-table .table tbody tr > td:nth-child(11) {
            display: contents !important;
        }
        .ns-page .new-style-table .table tbody tr > td:nth-child(6),
        .ns-page .new-style-table .table tbody tr > td:nth-child(11) > .edit_template,
        .ns-page .new-style-table .table tbody tr > td:nth-child(11) > .ns-more-info {
            display: flex;
            align-items: center;
            margin-top: 12px;
            padding-top: 10px !important;
            border-top: 1px dashed #dcdcdc !important;
            font-size: 12px;
            white-space: nowrap;
            color: #1d1d1f;
        }
        .ns-page .new-style-table .table tbody tr > td:nth-child(11) > .edit_template {
            grid-area: edit;
            justify-content: center;
        }
        .ns-page .new-style-table .table tbody tr > td:nth-child(11) > .ns-more-info {
            grid-area: more;
            justify-content: flex-end;
            cursor: pointer;
            -webkit-tap-highlight-color: transparent;
        }
        .ns-page .new-style-table .view_users,
        .ns-page .new-style-table .edit_template {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }
        .ns-page .new-style-table .view_users i,
        .ns-page .new-style-table .edit_template i {
            font-size: 14px;
            color: #1d1d1f;
        }
        .ns-page .new-style-table .ns-action-text {
            display: none;
        }
        /* Labels are added with CSS so they don't change the table's search text */
        .ns-page .new-style-table .view_users::after,
        .ns-page .new-style-table .edit_template::after,
        .ns-page .new-style-table .ns-more-info::before {
            text-decoration: underline;
            text-underline-offset: 2px;
        }
        .ns-page .new-style-table .view_users::after    { content: 'View Users'; }
        .ns-page .new-style-table .edit_template::after { content: 'Edit Notification'; }
        .ns-page .new-style-table .ns-more-info::before { content: 'More Info'; }
        .ns-page .new-style-table .ns-more-info::after {
            content: '';
            width: 7px;
            height: 7px;
            margin-left: 10px;
            border-right: 1.6px solid #1d1d1f;
            border-bottom: 1.6px solid #1d1d1f;
            transform: rotate(-45deg);
            transition: transform .15s ease;
        }
        .ns-page .new-style-table tr.ns-expanded .ns-more-info::after {
            transform: translateY(-3px) rotate(45deg);
        }

        /* 7-10: details, shown when "More Info" is opened */
        .ns-page .new-style-table .table tbody tr > td:nth-child(7),
        .ns-page .new-style-table .table tbody tr > td:nth-child(8),
        .ns-page .new-style-table .table tbody tr > td:nth-child(9),
        .ns-page .new-style-table .table tbody tr > td:nth-child(10) {
            display: none !important;
            margin: 0 -14px;
            padding: 0 14px 10px !important;
            font-size: 12.5px !important;
            word-break: break-word;
            background-color: #f5f6f7;
        }
        .ns-page .new-style-table .table tbody tr.ns-expanded > td:nth-child(7),
        .ns-page .new-style-table .table tbody tr.ns-expanded > td:nth-child(8),
        .ns-page .new-style-table .table tbody tr.ns-expanded > td:nth-child(9),
        .ns-page .new-style-table .table tbody tr.ns-expanded > td:nth-child(10) {
            display: block !important;
        }
        .ns-page .new-style-table .table tbody tr > td:nth-child(7) {
            grid-area: title;
            margin-top: 12px;
            padding-top: 12px !important;
        }
        .ns-page .new-style-table .table tbody tr > td:nth-child(8)  { grid-area: mtitle; }
        .ns-page .new-style-table .table tbody tr > td:nth-child(9)  { grid-area: body; }
        .ns-page .new-style-table .table tbody tr > td:nth-child(10) {
            grid-area: desc;
            margin-bottom: -14px;
            padding-bottom: 14px !important;
        }
        .ns-page .new-style-table .table tbody tr > td:nth-child(7)::before,
        .ns-page .new-style-table .table tbody tr > td:nth-child(8)::before,
        .ns-page .new-style-table .table tbody tr > td:nth-child(9)::before,
        .ns-page .new-style-table .table tbody tr > td:nth-child(10)::before {
            display: block;
            margin-bottom: 2px;
            font-size: 11px;
            color: #8c8c8c;
        }
        .ns-page .new-style-table .table tbody tr > td:nth-child(7)::before  { content: 'Title'; }
        .ns-page .new-style-table .table tbody tr > td:nth-child(8)::before  { content: 'Modal Title'; }
        .ns-page .new-style-table .table tbody tr > td:nth-child(9)::before  { content: 'Notification Body'; }
        .ns-page .new-style-table .table tbody tr > td:nth-child(10)::before { content: 'Description'; }

        /* Full text in the details (desktop keeps the short "..." text) */
        .ns-page .ns-short { display: none; }
        .ns-page .ns-full  { display: block; }
        .ns-page .ns-full p { margin: 0; }

        /* "No data available" row */
        .ns-page .new-style-table .table tbody tr > td.dataTables_empty {
            grid-area: auto;
            grid-column: 1 / -1;
            display: block !important;
            padding: 16px 0 !important;
            text-align: center !important;
            color: #8c8c8c !important;
        }
        .ns-page .new-style-table .table tbody tr > td.dataTables_empty::before {
            content: none;
        }

        /* Status toggle switch (bigger, teal) */
        .ns-page .togelcheck {
            width: 36px;
            height: 20px;
            margin: 0;
            background: #d0d0d0;
            box-shadow: none;
            cursor: pointer;
            appearance: none;
            vertical-align: middle;
        }
        .ns-page .togelcheck:checked[type="checkbox"] {
            background: #45d4b8;
        }
        .ns-page .togelcheck:before {
            top: 2px;
            left: 2px;
            width: 16px;
            height: 16px;
            transform: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .2);
        }
        .ns-page .togelcheck:checked[type="checkbox"]:before {
            left: 18px;
        }

        /* ---------- "Showing x to y" + pagination on one row ---------- */
        .ns-page .dataTables_wrapper > .row {
            margin-left: 0;
            margin-right: 0;
        }
        .ns-page .dataTables_wrapper > .row > [class*="col-"] {
            padding-left: 0;
            padding-right: 0;
        }
        .ns-page .dataTables_wrapper > .row:last-child {
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-top: 6px;
        }
        .ns-page .dataTables_wrapper > .row:last-child > [class*="col-"] {
            flex: 0 1 auto;
            width: auto;
            max-width: none;
        }
        .ns-page .dataTables_wrapper .dataTables_info {
            float: left;
            margin: 0;
            padding: 0 !important;
            font-size: 12px;
            color: #8c8c8c;
            text-align: left;
            white-space: normal;
        }
        .ns-page .dataTables_wrapper .dataTables_paginate {
            float: right;
            margin: 0 !important;
            padding: 0 !important;
            text-align: right;
        }
        .ns-page .dataTables_wrapper .dataTables_paginate .pagination {
            justify-content: flex-end !important;
            margin: 0;
        }
        /* Bootstrap-style pagination */
        .ns-page .dataTables_paginate .page-item .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: auto;
            min-width: 32px;
            height: 32px;
            margin: 0 0 0 6px;
            padding: 0 8px;
            font-size: 13px;
            color: #333;
            background-color: #fff;
            border: 1px solid #e3e3e3;
            border-radius: 6px !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
        }
        .ns-page .dataTables_paginate .page-item.active .page-link {
            color: #fff;
            background-color: #1d1d1f;
            border-color: #1d1d1f;
        }
        .ns-page .dataTables_paginate .page-item.disabled .page-link {
            color: #c0c0c0;
            background-color: #fff;
        }
        /* Default DataTables pagination (if Bootstrap styling is not used) */
        .ns-page .dataTables_wrapper .dataTables_paginate a.paginate_button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            margin: 0 0 0 6px !important;
            padding: 0 8px !important;
            font-size: 13px;
            color: #333 !important;
            background: #fff !important;
            border: 1px solid #e3e3e3 !important;
            border-radius: 6px;
            box-shadow: none;
        }
        .ns-page .dataTables_wrapper .dataTables_paginate a.paginate_button.current {
            color: #fff !important;
            background: #1d1d1f !important;
            border-color: #1d1d1f !important;
        }
        .ns-page .dataTables_wrapper .dataTables_paginate a.paginate_button.disabled {
            color: #c0c0c0 !important;
        }

        /* ---------- Add / Edit Notification modals ----------
           Header and footer stay visible, only the fields scroll. */
        .ns-form-modal .modal-dialog {
            display: flex;
            align-items: center;
            width: calc(100% - 40px);
            max-width: 420px;
            height: calc(100% - 40px);
            min-height: 0;
            margin: 20px auto;
        }
        .ns-form-modal .modal-dialog-centered::before {
            display: none;
        }
        .ns-form-modal .modal-content {
            display: flex;
            flex-direction: column;
            width: 100%;
            max-height: 100%;
            overflow: hidden;
            border: 0;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .2);
        }
        .ns-form-modal .modal-header {
            flex-shrink: 0;
            align-items: center;
            margin: 0 16px;
            padding: 16px 0 12px;
            border-bottom: 1px solid #e6e6e6;
        }
        .ns-form-modal .modal-title {
            font-size: 16px;
            font-weight: 700;
            color: #1d1d1f;
        }
        .ns-form-modal .modal-header .close {
            margin: -4px -4px -4px auto;
            padding: 4px;
            font-size: 22px;
            line-height: 1;
            color: #333;
            opacity: 1;
            text-shadow: none;
        }
        .ns-form-modal .modal-body {
            flex: 1 1 auto;
            min-height: 0;
            padding: 14px 16px 4px;
            overflow-x: hidden;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
        /* Label first, then the helper text, then the field (Figma order) */
        .ns-form-modal .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 14px;
        }
        .ns-form-modal .form-group > * {
            order: 2;
        }
        .ns-form-modal .form-group > label {
            order: 0;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 500;
            color: #1d1d1f;
        }
        .ns-form-modal .form-group > small.form-text {
            order: 1;
            margin: -3px 0 6px;
            font-size: 11px;
            color: #8c8c8c !important; /* text-muted uses !important */
        }
        .ns-form-modal .form-control {
            height: 38px;
            padding: 6px 12px;
            font-size: 14px;
            color: #1d1d1f;
            border: 1px solid #d9d9d9;
            border-radius: 6px;
            box-shadow: none;
        }
        .ns-form-modal textarea.form-control {
            height: auto;
        }
        .ns-form-modal .form-control:focus {
            border-color: #45d4b8;
        }
        .ns-form-modal .ql-toolbar.ql-snow {
            padding: 6px;
            border-color: #d9d9d9;
            border-radius: 6px 6px 0 0;
        }
        .ns-form-modal .ql-container.ql-snow {
            border-color: #d9d9d9;
            border-radius: 0 0 6px 6px;
        }
        .ns-form-modal .modal-footer {
            flex-shrink: 0;
            justify-content: flex-end;
            gap: 10px;
            padding: 12px 16px 16px;
            border-top: 0;
        }

        /* Footer buttons in all three modals */
        .modal .modal-footer > .btn.ns-btn-cancel,
        .modal .modal-footer > .btn.ns-btn-save {
            min-width: 88px;
            margin: 0;
            padding: 9px 18px;
            font-size: 13.5px;
            font-weight: 600;
            line-height: 1.3;
            text-transform: none;
            color: #fff;
            border: 0;
            border-radius: 6px;
            box-shadow: none;
            transform: none;
        }
        .modal .modal-footer > .btn.ns-btn-cancel,
        .modal .modal-footer > .btn.ns-btn-cancel:hover,
        .modal .modal-footer > .btn.ns-btn-cancel:focus,
        .modal .modal-footer > .btn.ns-btn-cancel:active {
            background-color: #b5b5b5;
            box-shadow: none;
        }
        .modal .modal-footer > .btn.ns-btn-save,
        .modal .modal-footer > .btn.ns-btn-save:hover,
        .modal .modal-footer > .btn.ns-btn-save:focus,
        .modal .modal-footer > .btn.ns-btn-save:active {
            background-color: #45d4b8;
            box-shadow: 0 4px 10px rgba(69, 212, 184, .3);
        }

        /* ---------- Notification Users modal ---------- */
        #EditTemplateusersModal .modal-dialog {
            width: calc(100% - 40px);
            max-width: 420px;
            margin: 20px auto;
        }

        #EditTemplateusersModal .modal-content {
            max-height: calc(100vh - 40px);
            max-height: calc(100dvh - 40px);
            border-radius: 12px;
        }

        #EditTemplateusersModal .modal-header {
            min-height: 0;
            align-items: center;
            margin: 0 16px;
            padding: 16px 0 12px;
            border-bottom: 1px solid #e6e6e6;
        }

        #EditTemplateusersModal .modal-title {
            font-size: 16px;
            font-weight: 700;
            color: #1d1d1f;
        }

        #EditTemplateusersModal .modal-header .close {
            margin: -4px -4px -4px auto;
            padding: 4px;
            color: #333;
            opacity: 1;
        }

        #EditTemplateusersModal .modal-body {
            max-height: calc(100vh - 95px);
            max-height: calc(100dvh - 95px);
            padding: 14px 16px 0;
        }

        /* Footer stays at the bottom of the scrolling area */
        #EditTemplateusersModal .modal-footer {
            position: sticky;
            bottom: 0;
            z-index: 2;
            justify-content: flex-end;
            gap: 10px;
            margin: 6px -16px 0;
            padding: 12px 16px 16px;
            border-top: 0;
            background: #fff;
        }

        #allSelectedUsersContainer {
            grid-template-columns: 1fr;
        }

        /* Existing card rules use !important, so !important is needed here */
        #EditTemplateusersModal .notification-user-card {
            margin-bottom: 10px !important;
            border: 1px solid #e3e3e3 !important;
            border-radius: 8px !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
        }

        #EditTemplateusersModal .notification-user-card .card-header {
            min-height: 46px;
            padding: 11px 12px;
            background: #fff;
        }

        #EditTemplateusersModal .notification-user-card .card-header strong {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 700;
            color: #1d1d1f;
        }

        #EditTemplateusersModal .notification-user-card .card-header label {
            gap: 6px;
            margin-right: 10px !important; /* mr-3 uses !important */
            font-size: 12px;
            color: #4a4a4a;
        }

        #EditTemplateusersModal .notification-user-card .card-header input[type="checkbox"] {
            width: 14px;
            height: 14px;
        }

        #EditTemplateusersModal .notification-user-card .card-body {
            padding: 10px 12px;
            border-top-color: #eef0f2;
        }

        #EditTemplateusersModal .notification-user-card .form-check-label {
            font-size: 13px;
            color: #1d1d1f;
        }

        /* "All selected" card: teal border, white header */
        #EditTemplateusersModal .all-selected-users-card {
            border-color: #45d4b8 !important;
        }

        #EditTemplateusersModal .all-selected-users-card .card-header {
            background: #fff;
        }

        /* Count badges: small grey circles */
        #EditTemplateusersModal .selected-recipient-count,
        #EditTemplateusersModal .ns-role-count {
            align-items: center;
            justify-content: center;
            min-width: 20px;
            height: 20px;
            padding: 0 6px;
            font-size: 11px;
            font-weight: 600;
            line-height: 1;
            color: #333;
            background: #e9e9e9;
            border-radius: 999px;
        }

        #EditTemplateusersModal .ns-role-count {
            display: none;
        }

        #EditTemplateusersModal .ns-role-count.ns-has-count {
            display: inline-flex;
        }

        /* "+" / "−" becomes a chevron: > when closed, v when open */
        #EditTemplateusersModal .toggle-notification-card .collapse-symbol {
            display: none;
        }

        #EditTemplateusersModal .toggle-notification-card::before {
            content: '';
            width: 7px;
            height: 7px;
            border-right: 1.6px solid #333;
            border-bottom: 1.6px solid #333;
            transform: rotate(-45deg);
            transition: transform .15s ease;
        }

        #EditTemplateusersModal .toggle-notification-card[aria-expanded="true"]::before {
            transform: translateY(-2px) rotate(45deg);
        }
    }

    /* Very small phones (320px): slightly smaller card action labels */
    @media (max-width: 359.98px) {
        .ns-page .new-style-table .table tbody tr > td:nth-child(6),
        .ns-page .new-style-table .table tbody tr > td:nth-child(11) > .edit_template,
        .ns-page .new-style-table .table tbody tr > td:nth-child(11) > .ns-more-info {
            font-size: 11px;
        }
        .ns-page .new-style-table .view_users i,
        .ns-page .new-style-table .edit_template i {
            font-size: 13px;
        }
    }

</style>

<div class="container-fluid mb-5 content-position ns-page" >
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Notification Settings</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    {{-- Mobile-only header (hidden on desktop) --}}
    <div class="ns-mobile-only ns-mobile-header">
        <div class="ns-title-row">
            <button type="button" class="ns-add-btn" data-toggle="modal" data-target="#AddTemplateModal">
                <svg viewBox="0 0 12 12" aria-hidden="true"><path d="M6 1v10M1 6h10" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                Add Template
            </button>
        </div>
    </div>

    <div class="col-md-12 mt-4 ns-outer-col">
        <div class="card ns-main-card">
            <div class="row m-1 ns-desktop-only">
                <div class="col">
                        {{-- <div class="m-1">
                            <input type="checkbox" class="togelcheck" />
                          </div> --}}
                </div>
                <div class="col d-flex justify-content-end">
                    <button type="button" class="btn-green-filled mt-2" data-toggle="modal" data-target="#AddTemplateModal">
                        <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD TEMPLATE
                    </button>
                </div>

            </div>

            {{-- Mobile-only search, show entries and sort controls (linked to the table) --}}
            <div class="ns-mobile-only ns-mobile-toolbar">
                <div class="ns-search-card">
                    <label class="ns-search-box mb-0" for="nsMobileSearch">
                        <svg viewBox="0 0 16 16" aria-hidden="true"><circle cx="7" cy="7" r="5.2" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M11 11l3.5 3.5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                        <input type="search" id="nsMobileSearch" class="ns-search-input" placeholder="Search by notification name" autocomplete="off">
                    </label>
                </div>
                <div class="ns-filter-row">
                    <label class="ns-filter-group" for="nsMobileLength">
                        Show
                        <select id="nsMobileLength" class="ns-select"></select>
                        entries
                    </label>
                    <label class="ns-filter-group" for="nsMobileSort">
                        Sort by
                        <select id="nsMobileSort" class="ns-select">
                            <option value="0">Default</option>
                            <option value="1">Name</option>
                            <option value="2">Key</option>
                            <option value="4">Controller</option>
                        </select>
                    </label>
                </div>
            </div>

            <div class="col-md-12 mt-2 ns-table-col">
                <div class=" new-style-table">
                    <table class="table align-items-center cell-border table-responsive" id="notification_groups_table" style="width:100%;">
                        <thead class="header-style">
                            <th  style="color: white"></th>
                            <th  style="color: white">Name</th>
                            <th  style="color: white">Key</th>
                            <th  style="color: white">function Name</th>
                            <th  style="color: white">Controller</th>
                            <th  style="color: white">Users</th>
                            <th  style="color: white">Title</th>
                            <th  style="color: white">Modal Title</th>
                            <th  style="color: white">Notification Body</th>
                            <th  style="color: white">Description</th>
                            <th  style="color: white">Actions</th>
                        </thead>

                        <tbody id="notification_groups_table_tbody"></tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade ns-form-modal" id="AddTemplateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Notification</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('notification_templates.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="function_name">Notification Key</label>
                    <input type="text" class="form-control" name="notification_key" id="notification_key" required>
                </div>
                <div class="form-group">
                    <label for="function_name">Notification Name</label>
                    <input type="text" class="form-control" name="notification_name" id="notification_name" required>
                </div>
                <div class="form-group">
                    <label for="function_name">Function Name</label>
                    <input type="text" class="form-control" name="function_name" id="function_name" required>
                </div>
                <div class="form-group">
                    <label for="controller">Controller</label>
                    <input type="text" class="form-control" name="controller" id="controller" required>
                </div>
                <div class="form-group">
                  <label for="title">Title</label>
                  <input type="text" class="form-control" name="title" id="title" required>
                </div>
                <div class="form-group">
                    <small class="form-text text-muted">
                        Common modal header title to use this field
                    </small>
                  <label for="title">Modal Title</label>
                  <input type="text" class="form-control" name="modal_title" id="modal_title" required>
                </div>
                <div class="form-group">
                    <label for="notification_body">Notification Body</label>
                    <div id="quill_editor" style="height: 150px;"></div>
                    <input type="hidden" name="notification_body" id="notification_body">
                </div>
                <div class="form-group">
                    <small class="form-text text-muted">
                        Common modal footer to use this field
                    </small>
                    <label for="modal_footer">Modal Footer</label>
                    <textarea class="form-control" id="modal_footer" name="modal_footer" rows="8"></textarea>
                </div>
                <div class="form-group">
                    <label for="modal_route">Confirm Route</label>
                    <small class="form-text text-muted">
                        Confirm route to use this field
                    </small>
                    <input type="text" class="form-control" name="confirm_route" id="confirm_route">
                </div>
                <div class="form-group">
                    <label for="modal_route">Reject Route</label>
                    <small class="form-text text-muted">
                        Reject route to use this field
                    </small>
                    <input type="text" class="form-control" name="reject_route" id="reject_route">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" name="description" id="description">
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary ns-btn-cancel" data-dismiss="modal"><span class="ns-desktop-only">Close</span><span class="ns-mobile-only">Cancel</span></button>
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
          <button type="submit" class="btn btn-primary ns-btn-save">Create Template</button>
            </form>
        </div>
      </div>
    </div>
  </div>


  <!-- Edit Template Modal -->
<div class="modal fade ns-form-modal" id="EditTemplateModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Notification</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="editTemplateForm" method="POST">
              @csrf
              <input type="hidden" name="id" id="edit_template_id">
              <div class="form-group">
                  <label for="edit_notification_keylbl">Notification Key</label>
                  <input type="text" class="form-control" name="notification_key" id="edit_notification_key" required>
              </div>
              <div class="form-group">
                   <label for="function_name">Notification Name</label>
                   <input type="text" class="form-control" name="notification_name" id="edit_notification_name" required>
              </div>
              <div class="form-group">
                  <label for="edit_function_name">Function Name</label>
                  <input type="text" class="form-control" name="function_name" id="edit_function_name" required>
              </div>
              <div class="form-group">
                  <label for="edit_controller">Controller</label>
                  <input type="text" class="form-control" name="controller" id="edit_controller" required>
              </div>
              <div class="form-group">
                  <label for="edit_title">Title</label>
                  <input type="text" class="form-control" name="title" id="edit_title" required>
              </div>
                <div class="form-group">
                    <small class="form-text text-muted">
                        Common modal header title to use this field
                    </small>
                    <label for="title">Modal Title</label>
                    <input type="text" class="form-control" name="modal_title" id="edit_modal_title" required>
                </div>
              <div class="form-group">
                  <label for="edit_notification_body_lbl">Notification Body</label>
                  <div id="quill_editor_edit" style="height: 150px;"></div>
                    <input type="hidden" name="notification_body" id="edit_notification_body">
              </div>
              <div class="form-group">
                    <small class="form-text text-muted">
                        Common modal footer to use this field
                    </small>
                    <label for="modal_footer">Modal Footer</label>
                    <textarea class="form-control" id="edit_modal_footer" name="modal_footer" rows="8" required></textarea>
                </div>
                <div class="form-group">
                    <label for="modal_route">Confirm Route</label>
                    <small class="form-text text-muted">
                        Confirm route to use this field
                    </small>
                    <input type="text" class="form-control" name="confirm_route" id="edit_confirm_route">
                </div>
                <div class="form-group">
                    <label for="modal_route">Reject Route</label>
                    <small class="form-text text-muted">
                        Reject route to use this field
                    </small>
                    <input type="text" class="form-control" name="reject_route" id="edit_reject_route">
                </div>
              <div class="form-group">
                  <label for="edit_description">Description</label>
                  <input type="text" class="form-control" name="description" id="edit_description">
              </div>
              <div class="form-group">
                  <label for="edit_status">Status</label>
                  <select name="status" id="edit_status" class="form-control">
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                  </select>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary ns-btn-cancel" data-dismiss="modal"><span class="ns-desktop-only">Close</span><span class="ns-mobile-only">Cancel</span></button>
          <button type="submit" class="btn btn-success ns-btn-save">Update Template</button>
        </div>
        </form>
      </div>
    </div>
  </div>


   <!-- Edit Template users Modal -->
<div class="modal fade" id="EditTemplateusersModal" tabindex="-1" role="dialog" aria-labelledby="editNotificationUsersModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editNotificationUsersModalLabel">Edit Notification Users</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('notification_template.toggleUser') }}" method="POST">
                @csrf
            <div id="notificationUsersContainer"></div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary ns-btn-cancel" data-dismiss="modal"><span class="ns-desktop-only">Close</span><span class="ns-mobile-only">Cancel</span></button>
            <button type="submit" class="btn btn-success ns-btn-save">Update </button>
            </div>
            </form>
        </div>
    </div>
</div>


<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    $(document).ready(function() {
        var quill = new Quill('#quill_editor', {
        theme: 'snow'
        });
        var quill_edit = new Quill('#quill_editor_edit', {
        theme: 'snow'
        });

        // On form submit, copy HTML from Quill to the hidden input
        document.querySelector('#AddTemplateModal form').addEventListener('submit', function(e) {
            document.querySelector('#notification_body').value = quill.root.innerHTML;
        });
        document.querySelector('#editTemplateForm').addEventListener('submit', function(e) {
            document.querySelector('#edit_notification_body').value = quill_edit.root.innerHTML;
        });

        // Is the screen mobile size?
        var nsIsMobile = !!(window.matchMedia && window.matchMedia('(max-width: 767.98px)').matches);

        // Same table options as before (desktop stays exactly the same)
        var nsTableOptions = {
            paging: true,
            searching: true,
            ordering: true,
            responsive: true,
            autoWidth: true,
            columnDefs: [
                { targets: 0, className: 'text-center' },
                { targets: 2, className: 'text-left' },
                { targets: 3, className: 'text-center', orderable: false },
                {targets: 7, className: 'notification-body-cell'},
                {
                    targets: [6,7,8], // 6th column (0-based index)
                    render: function (data, type, row) {
                        if (typeof data === 'string' && data.length > 20) {
                            var shortText = data.substring(0, 20) + '...';
                            if (type === 'display') {
                                // Desktop shows only the short text (same as before).
                                // The full text is used in the mobile "More Info" section.
                                return '<div class="ns-full">' + data + '</div><span class="ns-short">' + shortText + '</span>';
                            }
                            return shortText;
                        }
                        return data;
                    }
                }
            ],
            pageLength: 10,
            lengthChange: true
        };

        // Mobile only: rows are shown as cards, so the Responsive extension
        // (which hides columns) is turned off, and prev/next become arrows.
        if (nsIsMobile) {
            nsTableOptions.responsive = false;
            nsTableOptions.language = {
                paginate: {
                    previous: '&lsaquo;',
                    next: '&rsaquo;'
                }
            };
        }

        $('#notification_groups_table').DataTable(nsTableOptions);

        /*
         * Mobile toolbar: the search box, "Show entries" and "Sort by" controls
         * use the same DataTable, so they work exactly like the desktop ones.
         */
        (function initNsMobileToolbar() {
            var nsTable = $('#notification_groups_table').DataTable();
            var $search = $('#nsMobileSearch');
            var $length = $('#nsMobileLength');
            var $sort = $('#nsMobileSort');

            if (!$search.length) {
                return;
            }

            // "Show entries" options come from the table's own length menu
            var menu = nsTable.settings()[0].aLengthMenu || [10, 25, 50, 100];
            var values = Array.isArray(menu[0]) ? menu[0] : menu;
            var labels = Array.isArray(menu[0]) ? (menu[1] || menu[0]) : menu;

            $length.empty();
            values.forEach(function (item, i) {
                var value = (item && typeof item === 'object') ? item.value : item;
                var label = (item && typeof item === 'object') ? item.label : labels[i];
                $length.append(
                    $('<option>').val(String(value)).text(String(label === undefined ? value : label))
                );
            });
            $length.val(String(nsTable.page.len()));

            $length.on('change', function () {
                nsTable.page.len(parseInt(this.value, 10)).draw();
            });

            $search.val(nsTable.search());
            $search.on('input', function () {
                if (nsTable.search() !== this.value) {
                    nsTable.search(this.value).draw();
                }
            });

            function syncSort() {
                var order = nsTable.order();
                if (order && order.length) {
                    var column = String(order[0][0]);
                    if ($sort.find('option[value="' + column + '"]').length) {
                        $sort.val(column);
                    }
                }
            }
            syncSort();

            $sort.on('change', function () {
                nsTable.order([[parseInt(this.value, 10), 'asc']]).draw();
            });

            // Keep the mobile controls in sync if the table changes another way
            $('#notification_groups_table')
                .on('length.dt', function (e, settings, len) {
                    $length.val(String(len));
                })
                .on('search.dt', function () {
                    if (document.activeElement !== $search[0]) {
                        $search.val(nsTable.search());
                    }
                })
                .on('order.dt', syncSort);
        })();

        // Mobile only: "More Info" opens / closes the details of a card
        $('#notification_groups_table').on('click keydown', '.ns-more-info', function (e) {
            if (e.type === 'keydown' && e.key !== 'Enter' && e.key !== ' ') {
                return;
            }
            e.preventDefault();

            var $row = $(this).closest('tr');
            var isOpen = !$row.hasClass('ns-expanded');

            $row.toggleClass('ns-expanded', isOpen);
            $(this).attr('aria-expanded', isOpen ? 'true' : 'false');
        });

        get_template_data();
        function get_template_data(){

            $.ajax({
                url: "{{ route('notification.get_table_data') }}",
                type: 'get',
                dataType: 'json',
                beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                success: function(response) {
                    console.log(response);
                    update_notification_groups_table(response.templates);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        function update_notification_groups_table(templates){
             var table = $('#notification_groups_table').DataTable(); // Get DataTable instance
            table.clear().draw(); // Clear existing data while keeping DataTable active

            if (!templates || templates.length == 0) {
                // Instead of adding a custom row, let DataTables handle the "No data available" message
                table.draw();
                $(".se-pre-con").fadeOut('slow');
                return;
            }



            $.each(templates, function(index, template) {
                var checked = template.status == 1 ? 'checked' : '';

                var row = [
                    `<input type="checkbox" class="togelcheck changeStatus" data-id="${template.id}" ${checked} />`,
                    template.name,
                    template.template_key,
                    template.function_name,
                    template.controller,
                    `<span class="view_users" data-id="${template.id}"><i class="fa-solid fa-users ns-link-blue"></i><span class="mx-1 ns-link-blue ns-action-text">view</span></span>`,
                    template.title,
                    template.modal_title,
                    template.notification_body,
                    template.description,
                    `<span class="edit_template" data-id="${template.id}"><i class="fa-solid fa-pen-to-square ns-link-green"></i><span class="mx-1 ns-link-green ns-action-text">edit</span></span><span class="ns-more-info" role="button" tabindex="0" aria-expanded="false" aria-label="More info"></span>`,
                ];

                table.row.add(row);
            });

            table.draw(); // Redraw table with new data
            $(".se-pre-con").fadeOut('slow');
            // Attach change event to checkboxes after table draw
            $('#notification_groups_table').off('change', '.changeStatus').on('change', '.changeStatus', function () {
                var templateId = $(this).data('id');
                var isChecked = $(this).is(':checked') ? 1 : 0;

                // Send AJAX to update template status
                $.ajax({
                    url: "{{ route('notification_templates.change_status') }}", // Adjust route accordingly
                    method: 'POST',
                    data: {
                        id: templateId,
                        status: isChecked,
                        _token: $('meta[name="csrf-token"]').attr('content') // if CSRF is needed
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (response) {
                        console.log('Status updated successfully');
                        $(".se-pre-con").fadeOut('slow');
                    },
                    error: function () {
                        alert('Failed to update status');
                    }
                });
            });
            /*
             * Role select-all.
             */
            $('#notificationUsersContainer')
                .off('change.notificationSelectGroup', '.select-group')
                .on('change.notificationSelectGroup', '.select-group', function () {
                    const roleId = String($(this).data('role-id'));
                    const isChecked = $(this).is(':checked');

                    $(
                        `.role-user-checkbox[data-role-id="${roleId}"]`
                    ).each(function () {
                        $(this)
                            .prop('checked', isChecked)
                            .trigger('change.notificationUser');
                    });
                });

            /*
             * Open the user-selection modal.
             */
            $('#notification_groups_table')
                .off('click', '.view_users')
                .on('click', '.view_users', function () {
                    const templateId = $(this).data('id');

                    $.ajax({
                        url: `{{ url('notification_template/users') }}/${templateId}`,
                        method: 'GET',

                        beforeSend: function () {
                            $(".se-pre-con").fadeIn('slow');
                        },

                        success: function (data) {
                            renderUsersModal(
                                data.groups || [],
                                data.selectedUsers || [],
                                data.template_id,
                                data.template || {}
                            );

                            $('#EditTemplateusersModal').modal('show');
                            $(".se-pre-con").fadeOut('slow');
                        },

                        error: function () {
                            alert('Failed to load template data');
                            $(".se-pre-con").fadeOut('slow');
                        }
                    });
                });

            function escapeNotificationHtml(value) {
                return $('<div>')
                    .text(value == null ? '' : String(value))
                    .html();
            }

            function renderUsersModal(groups, selectedUsers, templateID, template) {
                const container = $('#notificationUsersContainer');
                const selectedUserIds = (selectedUsers || []).map(String);
                const notificationName = String(
                    template.name || template.notification_name || ''
                ).trim();

                $('#editNotificationUsersModalLabel').text(
                    notificationName
                        ? `Edit Notification Users for ${notificationName}`
                        : 'Edit Notification Users'
                );

                container.empty();
                container.append(`
                    <input
                        type="hidden"
                        value="${escapeNotificationHtml(templateID)}"
                        name="Template_id"
                    >
                `);

                /*
                 * This card is updated from every checked role-user checkbox.
                 */
                container.append(`
                    <div class="col-md-12">
                        <div class="card mb-3 notification-user-card all-selected-users-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <strong>
                                    <span>All Selected Users and Options</span>
                                    <span
                                        id="selectedUsersCount"
                                        class="selected-recipient-count"
                                    >0</span>
                                </strong>

                                <button
                                    type="button"
                                    class="btn btn-sm btn-link text-dark p-1 toggle-notification-card"
                                    aria-expanded="true"
                                    title="Collapse selected users"
                                >
                                    <span class="collapse-symbol">−</span>
                                </button>
                            </div>

                            <div
                                class="card-body collapsible-card-body"
                                id="allSelectedUsersContainer"
                            ></div>
                        </div>
                    </div>
                `);

                groups.forEach(function (group) {
                    const roleId = String(group.id);
                    const roleName = escapeNotificationHtml(group.name || 'Users');
                    const users = Array.isArray(group.users) ? group.users : [];

                    let cardHtml = `
                        <div class="col-md-12">
                            <div class="card mb-3 notification-user-card role-users-card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <strong>${roleName}<span class="ns-mobile-only ns-role-count" data-role-count="${escapeNotificationHtml(roleId)}"></span></strong>

                                    <div class="d-flex align-items-center">
                                        <label class="mb-0 mr-3">
                                            <input
                                                type="checkbox"
                                                class="select-group"
                                                data-role-id="${escapeNotificationHtml(roleId)}"
                                            >
                                            Select All
                                        </label>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-link text-dark p-1 toggle-notification-card"
                                            aria-expanded="false"
                                        >
                                            <span class="collapse-symbol">+</span>
                                        </button>
                                    </div>
                                </div>

                                <div
                                    class="card-body collapsible-card-body"
                                    style="display:none;"
                                >
                    `;

                    users.forEach(function (user) {
                        const userId = String(user.id);
                        const userName = user.name || `User #${userId}`;
                        const isChecked = selectedUserIds.includes(userId)
                            ? 'checked'
                            : '';

                        cardHtml += `
                            <div class="form-check mb-2">
                                <input
                                    class="form-check-input select-user role-user-checkbox"
                                    type="checkbox"
                                    value="${escapeNotificationHtml(userId)}"
                                    data-role-id="${escapeNotificationHtml(roleId)}"
                                    data-user-id="${escapeNotificationHtml(userId)}"
                                    data-user-name="${escapeNotificationHtml(userName)}"
                                    data-template_id="${escapeNotificationHtml(templateID)}"
                                    name="user_ids[]"
                                    id="user_${escapeNotificationHtml(roleId)}_${escapeNotificationHtml(userId)}"
                                    ${isChecked}
                                >

                                <label
                                    class="form-check-label"
                                    for="user_${escapeNotificationHtml(roleId)}_${escapeNotificationHtml(userId)}"
                                >
                                    ${escapeNotificationHtml(userName)}
                                </label>
                            </div>
                        `;
                    });

                    cardHtml += `
                                </div>
                            </div>
                        </div>
                    `;

                    container.append(cardHtml);
                });

                const orderProcessingRepChecked =
                    parseInt(template.proccessing_rep || 0) === 1
                        ? 'checked'
                        : '';

                const salesRepChecked =
                    parseInt(template.sales_rep || 0) === 1
                        ? 'checked'
                        : '';

                const relatedFactoriesChecked =
                    parseInt(template.related_fac || 0) === 1
                        ? 'checked'
                        : '';

                container.append(`
                    <div class="col-md-12">
                        <div class="card mb-3 notification-user-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <strong>Other Options</strong>

                                <button
                                    type="button"
                                    class="btn btn-sm btn-link text-dark p-1 toggle-notification-card"
                                    aria-expanded="false"
                                >
                                    <span class="collapse-symbol">+</span>
                                </button>
                            </div>

                            <div
                                class="card-body collapsible-card-body"
                                style="display:none;"
                            >
                                <div class="form-check mb-2">
                                    <input
                                        class="form-check-input notification-summary-option"
                                        type="checkbox"
                                        name="OrderProssingRep"
                                        data-summary-key="option-order-processing-rep"
                                        data-summary-name="Order Processing Rep"
                                        id="notificationOrderProcessingRep"
                                        ${orderProcessingRepChecked}
                                    >
                                    <label
                                        class="form-check-label"
                                        for="notificationOrderProcessingRep"
                                    >
                                        Order Processing Rep
                                    </label>
                                </div>

                                <div class="form-check mb-2">
                                    <input
                                        class="form-check-input notification-summary-option"
                                        type="checkbox"
                                        name="salesRep"
                                        data-summary-key="option-sales-rep"
                                        data-summary-name="Sales Rep"
                                        id="notificationSalesRep"
                                        ${salesRepChecked}
                                    >
                                    <label
                                        class="form-check-label"
                                        for="notificationSalesRep"
                                    >
                                        Sales Rep
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input
                                        class="form-check-input notification-summary-option"
                                        type="checkbox"
                                        name="Related_Factories"
                                        data-summary-key="option-related-factories"
                                        data-summary-name="Send Order Related Factories' Users"
                                        id="notificationRelatedFactories"
                                        ${relatedFactoriesChecked}
                                    >
                                    <label
                                        class="form-check-label"
                                        for="notificationRelatedFactories"
                                    >
                                        Send Order Related Factories' Users
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                `);

                updateAllRoleSelectCheckboxes();
                renderAllSelectedUsers();
            }

            function updateRoleSelectCheckbox(roleId) {
                if (!roleId) {
                    return;
                }

                const users = $(
                    `.role-user-checkbox[data-role-id="${roleId}"]`
                );

                const checkedUsers = users.filter(':checked').length;
                const allChecked =
                    users.length > 0 && checkedUsers === users.length;

                $(`.select-group[data-role-id="${roleId}"]`)
                    .prop('checked', allChecked)
                    .prop('indeterminate', checkedUsers > 0 && !allChecked);

                // Mobile only: selected-user count badge next to the role name
                $(`.ns-role-count[data-role-count="${roleId}"]`)
                    .text(checkedUsers)
                    .toggleClass('ns-has-count', checkedUsers > 0);
            }

            function updateAllRoleSelectCheckboxes() {
                $('.select-group').each(function () {
                    updateRoleSelectCheckbox(
                        String($(this).data('role-id'))
                    );
                });
            }

            function renderAllSelectedUsers() {
                const summaryContainer = $('#allSelectedUsersContainer');

                if (!summaryContainer.length) {
                    return;
                }

                const selectedItems = {};

                /* Selected role users. */
                $('.role-user-checkbox:checked').each(function () {
                    const userId = String($(this).data('user-id'));
                    const key = `user-${userId}`;

                    if (!selectedItems[key]) {
                        selectedItems[key] = {
                            key: key,
                            type: 'user',
                            id: userId,
                            name: $(this).data('user-name') || `User #${userId}`
                        };
                    }
                });

                /* Other Options. */
                $('.notification-summary-option:checked').each(function () {
                    const optionKey = String($(this).data('summary-key') || $(this).attr('name'));
                    const optionName = String($(this).data('summary-name') || optionKey);

                    selectedItems[optionKey] = {
                        key: optionKey,
                        type: 'option',
                        id: optionKey,
                        name: optionName
                    };
                });

                const rows = Object.values(selectedItems).sort(function (a, b) {
                    return String(a.name).localeCompare(String(b.name));
                });

                $('#selectedUsersCount').text(rows.length);

                if (!rows.length) {
                    summaryContainer.html(`
                        <div class="selected-users-empty">
                            No users or options selected.
                        </div>
                    `);
                    return;
                }

                let html = '';

                rows.forEach(function (item) {
                    html += `
                        <div class="selected-user-row">
                            <input
                                type="checkbox"
                                class="selected-user-summary-checkbox"
                                data-summary-type="${escapeNotificationHtml(item.type)}"
                                data-summary-key="${escapeNotificationHtml(item.key)}"
                                data-user-id="${item.type === 'user' ? escapeNotificationHtml(item.id) : ''}"
                                checked
                            >

                            <label class="selected-user-name">
                                ${escapeNotificationHtml(item.name)}
                            </label>
                        </div>
                    `;
                });

                summaryContainer.html(html);
            }

            /* Refresh summary when an Other Option changes. */
            $('#notificationUsersContainer')
                .off('change.notificationSummaryOption', '.notification-summary-option')
                .on(
                    'change.notificationSummaryOption',
                    '.notification-summary-option',
                    function () {
                        renderAllSelectedUsers();
                    }
                );

            /*
             * Sync duplicate instances of the same user, update role
             * select-all states, and refresh the selected-users card.
             */
            $('#notificationUsersContainer')
                .off('change.notificationUser', '.role-user-checkbox')
                .on(
                    'change.notificationUser',
                    '.role-user-checkbox',
                    function () {
                        const userId = String($(this).data('user-id'));
                        const isChecked = $(this).is(':checked');

                        $(
                            `.role-user-checkbox[data-user-id="${userId}"]`
                        ).prop('checked', isChecked);

                        updateAllRoleSelectCheckboxes();
                        renderAllSelectedUsers();
                    }
                );

            /* Changing a summary item updates its original source. */
            $('#notificationUsersContainer')
                .off(
                    'change.notificationSummaryUser',
                    '.selected-user-summary-checkbox'
                )
                .on(
                    'change.notificationSummaryUser',
                    '.selected-user-summary-checkbox',
                    function () {
                        const summaryType = String($(this).data('summary-type') || 'user');
                        const summaryKey = String($(this).data('summary-key') || '');
                        const isChecked = $(this).is(':checked');

                        if (summaryType === 'option') {
                            $(`.notification-summary-option[data-summary-key="${summaryKey}"]`)
                                .prop('checked', isChecked)
                                .trigger('change.notificationSummaryOption');
                            return;
                        }

                        const userId = String($(this).data('user-id'));

                        $(`.role-user-checkbox[data-user-id="${userId}"]`)
                            .prop('checked', isChecked)
                            .first()
                            .trigger('change.notificationUser');
                    }
                );

            /*
             * Collapse or expand every user card.
             */
            $('#notificationUsersContainer')
                .off(
                    'click.notificationCardCollapse',
                    '.toggle-notification-card'
                )
                .on(
                    'click.notificationCardCollapse',
                    '.toggle-notification-card',
                    function (event) {
                        event.preventDefault();
                        event.stopPropagation();

                        const button = $(this);
                        const card = button.closest('.notification-user-card');
                        const cardBody = card.children(
                            '.collapsible-card-body'
                        );
                        const isExpanded =
                            button.attr('aria-expanded') === 'true';

                        cardBody.stop(true, true).slideToggle(180);
                        button.attr(
                            'aria-expanded',
                            isExpanded ? 'false' : 'true'
                        );
                        button
                            .find('.collapse-symbol')
                            .text(isExpanded ? '+' : '−');
                    }
                );

            $('#notification_groups_table').off('click', '.edit_template').on('click', '.edit_template', function () {
                var templateId = $(this).data('id');

                $.ajax({
                    url:`{{ url('notification_templates/edit')}}/${templateId}`,
                    method: 'GET',
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (data) {
                        $('#edit_template_id').val(data.id);
                        $('#edit_function_name').val(data.function_name);
                        $('#edit_notification_key').val(data.template_key);
                        $('#edit_notification_name').val(data.name);
                        $('#edit_title').val(data.title);
                        $('#edit_modal_title').val(data.modal_title);
                        $('#edit_controller').val(data.controller);
                        quill_edit.root.innerHTML = data.notification_body; // Be cautious with unescaped HTML

                        // $('#edit_notification_body').val(data.notification_body);
                        $('#edit_modal_footer').val(data.modal_footer);
                        $('#edit_confirm_route').val(data.confirm_route);
                        $('#edit_reject_route').val(data.reject_route);
                        $('#edit_description').val(data.description);
                        $('#edit_status').val(data.status);

                        // Set form action for update
                        $('#editTemplateForm').attr('action', `{{ url('notification_templates/update')}}/${data.id}`);

                        // Show the modal
                        $('#EditTemplateModal').modal('show');
                        $(".se-pre-con").fadeOut('slow');
                    },
                    error: function () {
                        alert('Failed to load template data');
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            });

        }
    });


</script>
@endsection