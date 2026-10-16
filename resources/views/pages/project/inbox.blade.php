@extends('layouts.app', ['activePage' => 'project_inbox', 'titlePage' => __('Inbox')])

@section('content')
<style>
    /* Minimal My Tasks-like header styles for inbox */
    .task-tabs-row {
        display: grid;
        grid-template-columns: 1fr minmax(320px, 520px) 1fr;
        align-items: center;
        gap: 1rem;
        padding: 0.6rem 0;
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 0.5rem;
    }
    .task-search-wrapper {
        display: flex;
        justify-self: center;
        width: 100%;
        justify-content: center;
        min-width: 250px;
    }
    .task-search-wrapper .advance-search { width: 100%; max-width: 420px; }
    .task-filter-group { display:flex; align-items:center; gap: .5rem; flex-wrap: nowrap; }
    .form-select-sm {
        padding: 0.45rem 0.85rem;
        border-radius: 0.75rem;
        border: 1px solid #d1d5db;
        background: #ffffff;
        color: #111827;
        min-height: 35px;
        min-width: 50px;
        box-shadow: inset 0 1px 2px rgba(15, 23, 42, 0.08);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .form-select-sm:focus { border-color: #2563eb; box-shadow: 0 0 0 4px rgba(37,99,235,0.12); outline: none; }

    .inbox-tabs {
        display: flex;
        border-bottom: 1.5px solid #e0e0e0;
        background: rgba(50, 50, 50, 1) !important;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 0;
    }
    .inbox-tab {
        color: #fff;
        background: none;
        border: none;
        padding: 0.7rem 1.5rem 0.7rem 1.5rem;
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 500;
        border-bottom: 3px solid transparent;
        transition: border-color 0.2s, color 0.2s;
    }
    .inbox-tab.active {
        border-bottom: 3px solid #fff;
        color: #fff;
        background: transparent;
    }
    .inbox-searchbar {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.2rem 0 0.5rem 0;
        background: #fff;
        border-bottom: 1.5px solid #e0e0e0;
    }
    .inbox-searchbar input {
        border-radius: 20px;
        border: 1px solid #bbb;
        padding: 0.4rem 1.2rem;
        font-size: 0.8rem;
        width: 220px;
        background: #fafafa;
        max-width: 100%;
    }
    .inbox-searchbar .btn {
        font-size: 0.8rem;
        border-radius: 8px;
        padding: 0.3rem 1.1rem;
    }
    .inbox-list {
        background: #fafafa;
        min-height: 60vh;
        padding: 0;
        margin: 0;
    }
    .inbox-item {
        background: #fff;
        border-bottom: 1px solid #e0e0e0;
        padding: 0.7rem 1.5rem !important;
        display: flex;
        flex-direction: column;
        cursor: pointer;
        transition: background 0.1s;
        font-size: 0.8rem;
    }
    .inbox-item:hover {
        background: #f5f5f5;
    }
    .inbox-item-header {
        display: flex;
        align-items: center;
        gap: 1.2rem;
    }
    .inbox-item-date {
        color: #888;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
         margin-left: auto;
    white-space: nowrap;
    }
    .inbox-item-title {
        /* font-weight: 600; */
        color: #222;
        font-size: 0.8rem;
        flex: 1;
        font-weight: unset !important;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 400px;
        display: inline-block;
    }
    .inbox-item-details {
        /* margin-top: 0.5rem; */
        /* color: #444; */
        font-size: 0.8rem;
        /* margin-left: 2.3rem; */
        /* display: none; */
    }
    /* .inbox-item.expanded .inbox-item-details {
        display: block;
    } */

    .border_radius_left_top {
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }
    .make_complete_div {
        padding: 0.7rem 2rem;
        /* border-bottom: 1px solid rgb(236, 236, 236); */
    }
    .inbox-item.expanded {
        box-shadow: 0 4px 4px 0 #00000026;
        background: #F5F5F5;
    }
    .make_complete_btn {
        padding: 2px 10px;
        border-radius: 4px;
        border: 1px solid rgb(205, 205, 205);
        background-color: transparent;
        color: gray;
    }
    .project_name {
        font-size: 16px;
        font-weight: 600;
    }
    .project_details_gray {
        color: gray;
    }
    .text_area {
        width: 100%;
        border-radius: 5px;
        padding: 5px 10px;
    }
    .text_area_comment {
        width: 100%;
        border-radius: 5px;
        padding: 5px 10px;
        border: unset;
        background-color: transparent;
    }
    .add_section_btn {
        padding: 5px 12px;
        border-radius: 5px;
        border: 1px solid rgb(191, 191, 191);
        background-color: transparent;
    }
    .user_icon_pink {
        font-size: 30px;
        color: rgb(255, 158, 175);
    }
    .user_icon_blue {
        font-size: 30px;
        color: #5E79FF;
    }
    .user-task-info {
        display: flex;
        align-items: center; /* Vertically centers the items */
        gap: 6px;
        width: 100%;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgb(222, 222, 222);
    }
    .comment_textarea_div {
        width: 90%;
        padding: 5px;
        border: 1px solid rgb(162, 162, 162);
        border-radius: 5px;
        text-align: right;
    }
    #discussion_assignee_name {
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        border: none;
        color: #727272;
        background: transparent;
        font-size: 14px;
    }
    #discussion_due_date {
        border-top: 0;
        border-left: 0;
        border-right: 0;
        border-bottom: 1px solid #d2d2d2;
        color: #727272;
        font-size: 14px;
    }
    .chat-input .collaborators img {
        widows: 25px;
        height: 25px;
        border-radius: 50%;
        overflow: hidden;
    }
    .chat-textbox td:first-child img,
    .chat-user-icon {
        widows: 30px;
        height: 30px;
        border-radius: 50%;
        overflow: hidden;
    }
    .Editor-editor img {
        width: 60%;
    }
    .previous-chats-tbody td:nth-child(2) img {
        width: 80%;
        cursor: pointer;
    }
    .mention-dropdown-content {
        display: none;
        position: absolute;
        bottom: 30px;
        background-color: #f1f1f1;
        min-width: 160px;
        min-height: 200px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        height: 100px;
        overflow-y: scroll;
    }
    .mention-dropdown-content a {
        color: black;
        font-size: 14px;
        padding: 2px 5px;
        text-decoration: none;
        display: block;
    }
    .mention-dropdown-content a:hover {
        background-color: #ddd;
        display: block;
    }
    .user-dropdown:hover .mention-dropdown-content {display: block;}
    .user-dropdown .mention-dropdown-content:hover {display: block;}

    .mention-dropdown-content2 {
        display: none;
        position: absolute;
        /* bottom: 30px; */
        background-color: #f1f1f1;
        /* min-width: 160px;
        min-height: 200px; */
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        /* height: 100px; */
        overflow-y: scroll;
    }
    .mention-dropdown-content2 a {
        color: black;
        font-size: 14px;
        padding: 2px 5px;
        text-decoration: none;
        display: block;
    }
    .mention-dropdown-content2 a:hover {
        background-color: #ddd;
        display: block;
    }
    .user-dropdown:hover .mention-dropdown-content2 {display: block;}
    .user-dropdown .mention-dropdown-content2:hover {display: block;}
    .comment-dropdown {
        position: relative;
        display: inline-block;
    }

    .comment-dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: #f9f9f9;
        min-width: 100px;
        box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    .comment-dropdown-content button {
       width: 100%;
       font-size: 12px;
       padding: 5px;
    }
    .comment-dropdown-content a:hover {background-color: #f1f1f1;}
    .comment-dropdown:hover .comment-dropdown-content {display: block;}
    .comment-dropdown:hover .comment-dropbtn {background-color: #ffffff;}

    /* #inbox-right {
        position: fixed;
        top: 109px;
        right: 3px;
        height: 70vh;
        overflow-y: auto;
        z-index: 1000;
        background-color: #fff;
        width: 42%;
        border-left: 1px solid #ececec;
        padding: 1.5rem;
    } */

    /* Floating right panel modal */
    #inbox-right.modal {
        position: fixed;
        top: 9%;
        left: 50%;
        width: 50%;
        height: 100%;
        margin: 0;
        padding: 1rem;
        border-radius: 0;
        background-color: #fff;
        box-shadow: -4px 0 10px rgba(0,0,0,0.2);
        overflow-y: auto;
    }

    #inbox-right .modal-dialog {
        margin: 0;
        max-width: 100%;
        height: 100%;
    }

    #inbox-right .modal-content {
        min-height: 100%;
        border: none;
        border-radius: 0;
    }
    .modal-content {
        box-shadow: unset !important;
    }
    .modal.right {
        transform: translateX(100%);
        transition: transform 1s ease-out; /* <- 2 second animation */
    }

    .modal.right.show {
        transform: translateX(0);
    }
    .modal.right.hide-animation{
        transform: translateX(100%);
    }
    .header-layout {
        margin-bottom: 1.5rem !important;
    }
    .content-position {
        padding-left: 20px !important;
        padding-right: 20px !important;
    }
    .input-group.input-group-alternative {
        background-color: white;
    }
    @media ((min-width: 768px)) {
        .content-position {
            padding-left: 20px !important;
            padding-right: 20px !important;
        }
    }
    .user-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #fff;
        margin-right: -8px;
        box-shadow: 0 0 0 1px #bbb;
    }
    .circle_checkbox {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        width: 20px;
        height: 20px;
        border: 1px solid gray;
        border-radius: 50%;
        position: relative;
        cursor: pointer;
        vertical-align: middle;
        /* margin-right: 8px; */
        display: inline-block;
    }
    .circle_checkbox:checked {
        border: unset;
        background-color: #27ae60
    }

    /* Checked state with right mark (✓) */
    .circle_checkbox:checked::before {
        content: "\2713"; /* Unicode for check mark */
        position: absolute;
        top: 0px;
        left: 5px;
        font-size: 14px;
        color: #ffffff;
        font-weight: bold;
    }
    .table-responsive .table tbody td {
        padding : 0.3rem 0.7rem !important;
    }
    .project-index-projecticon {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: #fff;
        margin-right: 12px;
    }

    .table-custom-dark {
        color: #f8f9fe;
        background-color: #323232;
    }
    .table-custom-dark th {
        border-color: #3c3c3c;
    }
    .trash_btn {
        color: rgb(255, 136, 136);
        cursor: pointer;
    }
    #discussion_tbody .select2-container {
        max-width: 150px !important;
    }
    #discussion_tbody .select2-container--open .select2-dropdown--below {
        max-width: 150px !important;
    }
    .inbox-item-title {
        font-weight: unset !important;
    }
    td.align-content-center.border_left_unset.open-chatbox {
        border-left-style: none;
    }
    td.align-content-center.open-chatbox {
        border-right-style: none;
    }
    .bg-box.container-fluid.fix-nav.header-layout{
        margin-bottom: .5rem !important;
    }
    .rows-per-page-label {
        font-size: 0.8rem;
        color: #333;
        margin-bottom: 0;
    }
    .rows-per-page-select {
        min-width: 62px;
        width: 62px;
        padding: 0.45rem 0.85rem;
        border-radius: 0.75rem;
        border: 1px solid #d1d5db;
        background: #ffffff;
        color: #111827;
        min-height: 35px;
        box-shadow: inset 0 1px 2px rgba(15, 23, 42, 0.08);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .rows-per-page-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37,99,235,0.12);
        outline: none;
    }
    .sortable-header {
        cursor: pointer;
        white-space: nowrap;
        user-select: none;
    }
    .sortable-header .sort-arrow {
        font-size: 0.75rem;
        margin-left: 0.25rem;
        opacity: 0.75;
    }
    .sortable-header.sorted .sort-arrow {
        opacity: 1;
    }
    /* Compact dot-style priority indicator (matches other views) */
    .priority-indicator {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-left: 0;
    }
    .priority-indicator .priority-dot {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        display: inline-block;
        flex: 0 0 14px;
    }
    .priority-indicator .priority-text {
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
        padding: 2px 8px;
        border-radius: 12px;
        display: none; /* hide label, keep dot only */
    }
    /* Dot and pill colors */
    .priority-indicator.low .priority-dot { background: #2e7d32; }
    .priority-indicator.low .priority-text { background: #e8f5e9; color: #2e7d32; }
    .priority-indicator.medium .priority-dot { background: #f57f17; }
    .priority-indicator.medium .priority-text { background: #fff9c4; color: #f57f17; }
    .priority-indicator.high .priority-dot { background: #e65100; }
    .priority-indicator.high .priority-text { background: #fff3e0; color: #e65100; }
    .priority-indicator.critical .priority-dot { background: #c62828; }
    .priority-indicator.critical .priority-text { background: #ffebee; color: #c62828; }
    .inbox-item-meta { display: inline-flex; align-items: center; gap: 8px; margin-left: auto; }

    /* Mobile Responsive View Styling */
    @media (max-width: 767.98px) {
        .table-responsive {
            overflow-x: hidden;
        }
        .content-position {
            padding-left: 4px !important;
            padding-right: 4px !important;
            /* margin-top: 8% !important; */
        }

        .card {
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
        }

        #inbox-left,
        #inbox-left.col-lg-12,
        .card-body,
        .card > .card-body {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /* --- Top Filter / Search Card Container --- */
        .task-tabs-row {
            display: flex !important;
            flex-direction: column !important;
            gap: 0.65rem !important;
            background: #ffffff !important;
            border: 1px solid #eaedf0 !important;
            border-radius: 16px !important;
            padding: 14px !important;
            margin-bottom: 16px !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04) !important;
        }

        .task-search-wrapper {
            order: 1 !important;
            width: 100% !important;
            min-width: 0 !important;
            justify-content: stretch !important;
        }

        .task-search-wrapper .advance-search {
            width: 100% !important;
            max-width: 100% !important;
        }

        .task-search-wrapper .input-group-alternative {
            border-radius: 12px !important;
            background-color: #f8f9fa !important;
            border: 1px solid #e2e8f0 !important;
            height: 42px !important;
            display: flex !important;
            align-items: center !important;
        }

        .task-filter-group {
            order: 2 !important;
            width: 100% !important;
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 0.6rem !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        #inboxTaskStatusFilter {
            order: 1 !important;
            flex: 1 1 auto !important;
            min-width: 0 !important;
            width: auto !important;
            background-color: #f8f9fa !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            height: 40px !important;
            font-size: 0.85rem !important;
            color: #374151 !important;
            padding: 0.4rem 0.8rem !important;
        }

        .rows-per-page-wrapper {
            order: 2 !important;
            flex: 0 0 75px !important;
            width: 75px !important;
        }

        .rows-per-page-select {
            width: 100% !important;
            min-width: 0 !important;
            background-color: #f8f9fa !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            height: 40px !important;
            font-size: 0.85rem !important;
            color: #374151 !important;
            padding: 0.4rem 0.6rem !important;
            text-align: center !important;
        }

        /* --- Transform Table to Mobile Cards --- */
        #inboxTable thead {
            display: none !important;
        }

        #inboxTable,
        #inboxTable tbody {
            display: block !important;
            width: 100% !important;
            border: none !important;
            background: transparent !important;
        }

        #inboxTable tbody tr {
            display: flex !important;
            flex-wrap: wrap !important;
            position: relative !important;
            background: #ffffff !important;
            border: 1px solid #eaedf0 !important;
            border-radius: 16px !important;
            margin-bottom: 12px !important;
            padding: 14px 16px !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04) !important;
            width: 100% !important;
        }

        #inboxTable tbody tr td {
            display: none !important;
            border: none !important;
            padding: 0 !important;
            background: transparent !important;
        }

        /* Row 1: Checkbox + Task Title (td:nth-child(1)) */
        #inboxTable tbody tr td:nth-child(1) {
            display: flex !important;
            align-items: flex-start !important;
            flex: 0 0 100% !important;
            width: 100% !important;
            max-width: 100% !important;
            order: 1 !important;
            padding-right: 24px !important;
            margin-bottom: 8px !important;
        }

        #inboxTable tbody tr td:nth-child(1) .w-100.d-flex {
            align-items: flex-start !important;
        }

        #inboxTable tbody tr td:nth-child(1) .circle_checkbox {
            margin-top: 2px !important;
            margin-right: 6px !important;
            flex-shrink: 0 !important;
            width: 18px !important;
            height: 18px !important;
        }

        #inboxTable tbody tr td:nth-child(1) .inbox-item-title {
            white-space: normal !important;
            word-break: break-word !important;
            overflow: visible !important;
            text-overflow: clip !important;
            max-width: 100% !important;
            /* font-size: 0.85rem !important;
            font-weight: 600 !important; */
            color: #1f2937 !important;
            line-height: 1.35 !important;
            display: block !important;
            padding-left: 0 !important;
            margin-left: 0 !important;
        }

        /* Priority Dot on Top Right (td:nth-child(2)) */
        #inboxTable tbody tr td:nth-child(2) {
            display: flex !important;
            position: absolute !important;
            top: 14px !important;
            right: 14px !important;
            width: auto !important;
            order: 6 !important;
            align-items: center !important;
        }

        /* Row 2 Left: Due Date (td:nth-child(4)) */
        #inboxTable tbody tr td:nth-child(4) {
            display: flex !important;
            align-items: center !important;
            flex: 0 0 50% !important;
            width: 50% !important;
            max-width: 50% !important;
            order: 2 !important;
            font-size: 0.78rem !important;
            font-weight: 600 !important;
            color: #374151 !important;
            padding-bottom: 10px !important;
            text-align: left !important;
        }

        #inboxTable tbody tr td:nth-child(4)::before {
            content: "\f073\a0 Due\a0";
            font-family: "Font Awesome 5 Free", "FontAwesome", sans-serif;
            font-weight: 400;
            color: #6b7280;
            font-size: 0.75rem;
            margin-right: 2px;
        }

        /* Row 2 Right: Created Date (td:nth-child(3)) */
        #inboxTable tbody tr td:nth-child(3) {
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            flex: 0 0 50% !important;
            width: 50% !important;
            max-width: 50% !important;
            order: 3 !important;
            font-size: 0.75rem !important;
            color: #9ca3af !important;
            padding-bottom: 10px !important;
            text-align: right !important;
            margin-left: auto !important;
        }

        #inboxTable tbody tr td:nth-child(3) .inbox-item-date {
            color: #9ca3af !important;
            font-size: 0.75rem !important;
        }

        #inboxTable tbody tr td:nth-child(3) .inbox-item-date::before {
            content: "Created ";
            color: #9ca3af;
            font-weight: 400;
        }

        /* Row 3 Left: Assigned By (td:nth-child(6)) */
        #inboxTable tbody tr td:nth-child(6) {
            display: flex !important;
            align-items: center !important;
            flex: 0 1 auto !important;
            max-width: 50% !important;
            min-width: 0 !important;
            order: 4 !important;
            border-top: 1px solid #f0f0f0 !important;
            padding-top: 10px !important;
            margin-top: 2px !important;
            overflow: hidden !important;
        }

        #inboxTable tbody tr td:nth-child(6) .user-avatar {
            width: 22px !important;
            height: 22px !important;
            margin-right: 0 !important;
            flex-shrink: 0 !important;
        }

        #inboxTable tbody tr td:nth-child(6) .text-gray {
            padding-left: 8px !important;
            font-size: 0.78rem !important;
            color: #6b7280 !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            min-width: 0 !important;
        }

        /* Row 3 Right: Projects (td:nth-child(5)) */
        #inboxTable tbody tr td:nth-child(5) {
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            flex: 1 1 auto !important;
            max-width: 50% !important;
            min-width: 0 !important;
            order: 5 !important;
            border-top: 1px solid #f0f0f0 !important;
            padding-top: 10px !important;
            margin-top: 2px !important;
            text-align: right !important;
            margin-left: auto !important;
            overflow: hidden !important;
        }

        #inboxTable tbody tr td:nth-child(5) a {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            max-width: 100% !important;
            min-width: 0 !important;
            overflow: hidden !important;
        }

        #inboxTable tbody tr td:nth-child(5) a > .d-flex {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            max-width: 100% !important;
            min-width: 0 !important;
            overflow: hidden !important;
        }

        #inboxTable tbody tr td:nth-child(5) .project-index-projecticon {
            width: 18px !important;
            height: 18px !important;
            font-size: 0.65rem !important;
            margin-right: 6px !important;
            flex-shrink: 0 !important;
            border-radius: 4px !important;
        }

        #inboxTable tbody tr td:nth-child(5) div[style*="font-weight:600"] {
            font-size: 0.78rem !important;
            font-weight: 600 !important;
            color: #374151 !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            min-width: 0 !important;
            text-align: right !important;
        }

        /* --- Pagination Row on Mobile --- */
        .content-position .row.align-items-center.mt-3.pt-2 {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: space-between !important;
            border-top: none !important;
            margin-top: 10px !important;
            padding-top: 0 !important;
        }

        .content-position .row.align-items-center.mt-3.pt-2 .col-md-6 {
            width: auto !important;
            flex: 0 0 auto !important;
            max-width: 100% !important;
            padding: 0 !important;
        }

        #inboxSummaryText {
            font-size: 0.78rem !important;
            color: #9ca3af !important;
            margin-bottom: 0 !important;
        }

        #inboxServerPagination {
            float: none !important;
            display: flex !important;
        }

        .pagina001 {
            margin: 0 !important;
            gap: 4px !important;
        }

        .pagina001 .page-item .page-link {
            border-radius: 8px !important;
            border: 1px solid #e5e7eb !important;
            background: #ffffff !important;
            color: #374151 !important;
            padding: 0.35rem 0.65rem !important;
            font-size: 0.78rem !important;
            min-width: 32px !important;
            text-align: center !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
        }

        .pagina001 .page-item.active .page-link {
            background: #111827 !important;
            border-color: #111827 !important;
            color: #ffffff !important;
        }

        /* Right Panel Modal Full Width on Mobile */
        #inbox-right.modal {
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            z-index: 1050 !important;
        }
    }
</style>
<div class="container-fluid mb-5 content-position" style="padding-left: 20px !important; padding-right: 20px !important;">
<!-- <div class="container-fluid mb-5 content-position"> -->
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>INBOX</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color">BACK TO HOME</a>
    @endsection
    <div class="card shadow-sm mb-4" style="font-family: Arial, sans-serif;">
        <div class="card-body py-3 px-4">

            <!-- Left Side -->
            <div id="inbox-left" class="col-lg-12 transition-all">
                <div class="card-body" style="padding: unset;">
                    <div class="task-tabs-row">
                        <div class="task-filter-group">
                            <div class="rows-per-page-wrapper d-flex align-items-center">
                                <select class="rows-per-page-select" id="inboxRowsPerPageSelect" name="per_page">
                                    @foreach([20,40,60,100] as $rows)
                                        <option value="{{ $rows }}" {{ request()->get('per_page', 20) == $rows ? 'selected' : '' }}>{{ $rows }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <select class="form-select form-select-sm" id="inboxTaskStatusFilter" style="min-width: 140px;">
                                <option value="" {{ request()->get('task_type') == '' ? 'selected' : '' }}>All Status</option>
                                <option value="upcoming" {{ request()->get('task_type') == 'upcoming' ? 'selected' : '' }}>Pending</option>
                                <option value="overdue" {{ request()->get('task_type') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                <option value="completed" {{ request()->get('task_type') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <!-- <option value="incomplete">Incomplete</option> -->
                            </select>
                        </div>
                        <div class="task-search-wrapper">
                            @include('pages.project.partials.project_master_search')
                        </div>
                        <div></div>
                    </div>
                    

                    <div class="table-responsive mt-2">
                        <table class="table table-bordered align-middle" id="inboxTable">
                            <thead class="table-custom-dark">
                                <tr>
                                    <th>Activity</th>
                                    <th style="width: 0;"></th>
                                    <th style="width: 64px;"></th>
                                    <th class="text-center" style="width: 85px;">Due Date</th>
                                    <th>Projects</th>
                                    <th style="width: 160px;">Assigned By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($myInboxTasks as $myInboxTask)
                                    @php
                                        $discussion = $myInboxTask->is_sub_discussion
                                            ? $myInboxTask->subDiscussion
                                            : $myInboxTask->discussion;

                                        $discussionType = $myInboxTask->is_sub_discussion
                                            ? 'sub_discussion'
                                            : 'discussion';
                                    @endphp

                                    @if(!$discussion) @continue @endif

                                    @php
                                        $priorityRaw = $discussion->priority ?? null;
                                        $priorityLabel = '';
                                        $priorityClass = '';
                                        if (is_numeric($priorityRaw)) {
                                            $map = [1=>['LOW','low'], 2=>['MEDIUM','medium'], 3=>['HIGH','high'], 4=>['CRITICAL','critical']];
                                            [$priorityLabel, $priorityClass] = $map[(int)$priorityRaw] ?? ['',''];
                                        } elseif (is_string($priorityRaw)) {
                                            $p = strtolower($priorityRaw);
                                            if (str_contains($p,'critical'))   { $priorityLabel='CRITICAL'; $priorityClass='critical'; }
                                            elseif (str_contains($p,'high'))   { $priorityLabel='HIGH';     $priorityClass='high'; }
                                            elseif (str_contains($p,'medium')) { $priorityLabel='MEDIUM';   $priorityClass='medium'; }
                                            elseif (str_contains($p,'low'))    { $priorityLabel='LOW';      $priorityClass='low'; }
                                        }

                                        $assignedUser = $myInboxTask->is_comment
                                            ? $discussion->assigneeUser
                                            : $myInboxTask->assignedByUser;

                                        $project = $myInboxTask->projectDetail;
                                    @endphp

                                    <tr id="{{ $discussionType }}_{{ $discussion->id }}">

                                        {{-- Activity --}}
                                        <td class="align-content-center border_left_unset open-chatbox"
                                            data-discussion-type="{{ $discussionType }}"
                                            data-value="{{ $discussion->id }}">
                                            <div class="w-100 d-flex align-items-center">
                                                <input type="checkbox"
                                                    class="main-check-list circle_checkbox discussion-check mr-3 discussion-check-id-{{ $discussion->id }}"
                                                    data-discussion-type="{{ $discussionType }}"
                                                    value="{{ $discussion->id }}"
                                                    {{ $discussion->is_completed == 1 ? 'checked' : '' }}>
                                                <div class="d-flex align-items-center w-100">
                                                    <span class="inbox-item-title">{{ $discussion->discussion_name }}</span>
                                                    
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-content-center text-center">
                                            @if($priorityLabel)
                                                <span class="priority-indicator {{ $priorityClass }} discussion-priority-id-{{ $discussion->id }}"
                                                    title="{{ $priorityLabel }}">
                                                    <span class="priority-dot"></span>
                                                    <span class="priority-text">{{ $priorityLabel }}</span>
                                                </span>
                                            @endif
                                        </td>
                                        <td class="align-content-center">
                                            <span class="inbox-item-date">
                                                {{ str_replace([' minutes',' minute'], [' min',' min'], $helper->getReadableDate($myInboxTask->created_at)) }}
                                            </span>
                                        </td>

                                        {{-- Due Date --}}
                                        <td class="align-content-center text-center"
                                            data-discussion-type="{{ $discussionType }}"
                                            data-value="{{ $discussion->id }}"
                                            data-order="{{ $discussion->due_date ?? '9999-12-31' }}">
                                            {{ $helper->getFormatedDate($discussion->due_date, 'M d, Y') }}
                                        </td>

                                        {{-- Project --}}
                                        <td class="align-content-center">
                                            <a href="{{ route('projects.view.temp', $myInboxTask->project_id) }}" style="text-decoration:none;">
                                                <div class="d-flex align-items-center">
                                                    <span class="project-index-projecticon me-2"
                                                        style="background-color:{{ optional($project)->project_color ?? '#b5b5b5' }}">
                                                        @if(optional($project)->project_icon_url)
                                                            <img src="{{ optional($project)->project_icon_url }}"
                                                                style="width:100%;height:100%;object-fit:contain;">
                                                        @else
                                                            <i class="fa fa-server" style="color:#fff;font-size:smaller;"></i>
                                                        @endif
                                                    </span>
                                                    <div style="font-weight:600;">
                                                        {{ optional($project)->new_display_name }}
                                                    </div>
                                                </div>
                                            </a>
                                        </td>

                                        {{-- Assigned By --}}
                                        <td class="align-content-center open-chatbox"
                                            data-discussion-type="{{ $discussionType }}"
                                            data-value="{{ $discussion->id }}">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset(optional($assignedUser)->profile_pic ?? 'default.png') }}"
                                                    class="user-avatar">
                                                <span class="text-gray" style="padding-left:15px;">
                                                    {{ optional($assignedUser)->name ?? 'Unknown User' }}
                                                </span>
                                            </div>
                                        </td>

                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <div class="row align-items-center mt-3 pt-2" style="border-top: 1px solid #e5e7eb;">
                        <div class="col-md-6">
                            <p class="text-muted mb-0" id="inboxSummaryText">
                                @if($myInboxTasks->total() > 0)
                                    Showing {{ $myInboxTasks->firstItem() }}–{{ $myInboxTasks->lastItem() }}
                                    of {{ $myInboxTasks->total() }} entries
                                @else
                                    No entries found
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                           
                            <div id="inboxServerPagination" style="display: inline-block; float: right;">
                                {{ $myInboxTasks->onEachSide(5)->withQueryString()->links('layouts.paginationlinks') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>

@include('pages.project.task_comment')


<script>
$(document).ready(function () {

    $.fn.dataTable.ext.order['dom-data-order'] = function (settings, col) {
    return this.api().column(col, { order: 'index' }).nodes().map(function (td) {
        return $(td).data('order') || '9999-12-31';
    });
};

if ($.fn.DataTable.isDataTable('#inboxTable')) {
    $('#inboxTable').DataTable().destroy();
}

$('#inboxTable').DataTable({
    paging:      false,
    searching:   false,
    info:        false,
    lengthChange:false,
    ordering:    true,
    order:       [[3, 'asc']], // default sort by Due Date (col index 3)

    columnDefs: [
        {
            // col 0 — Activity: sort by .inbox-item-title text
            targets:   0,
            orderable: true,
            render: function (data, type) {
                if (type === 'sort') {
                    var tmp = document.createElement('div');
                    tmp.innerHTML = data;
                    var el = tmp.querySelector('.inbox-item-title');
                    return el ? el.textContent.trim() : tmp.textContent.trim();
                }
                return data;
            }
        },
        {
            // col 1 — Priority: sort by dot color order
            targets:   1,
            orderable: true,
            render: function (data, type) {
                if (type === 'sort') {
                    var tmp = document.createElement('div');
                    tmp.innerHTML = data;
                    var el = tmp.querySelector('.priority-indicator');
                    if (!el) return '0';
                    if (el.classList.contains('critical')) return '4';
                    if (el.classList.contains('high'))     return '3';
                    if (el.classList.contains('medium'))   return '2';
                    if (el.classList.contains('low'))      return '1';
                    return '0';
                }
                return data;
            }
        },
        {
            // col 2 — Time: sort by text
            targets:   2,
            orderable: true,
            render: function (data, type) {
                if (type === 'sort') {
                    var tmp = document.createElement('div');
                    tmp.innerHTML = data;
                    return tmp.textContent.trim();
                }
                return data;
            }
        },
        {
            targets: 3,
            orderable: true,
            render: function(data, type, row, meta) {

                if (type === 'sort' || type === 'type') {

                    var td = $('#inboxTable tbody tr')
                        .eq(meta.row)
                        .find('td')
                        .eq(3);

                    return td.attr('data-order') || '9999-12-31';
                }

                return data;
            }
        },
        {
            // col 4 — Projects: sort by text
            targets:   4,
            orderable: true,
            render: function (data, type) {
                if (type === 'sort') {
                    var tmp = document.createElement('div');
                    tmp.innerHTML = data;
                    return tmp.textContent.trim();
                }
                return data;
            }
        },
        {
            // col 5 — Assigned By: sort by name text
            targets:   5,
            orderable: true,
            render: function (data, type) {
                if (type === 'sort') {
                    var tmp = document.createElement('div');
                    tmp.innerHTML = data;
                    var el = tmp.querySelector('.text-gray');
                    return el ? el.textContent.trim() : tmp.textContent.trim();
                }
                return data;
            }
        }
    ]
});

    console.log('DataTable init done, instance:', $.fn.DataTable.isDataTable('#inboxTable'));

    $('#inboxTaskStatusFilter').on('change', function () {
        var params = new URLSearchParams(window.location.search);
        var val = $(this).val();
        if (val) { params.set('task_type', val); } else { params.delete('task_type'); }
        params.set('per_page', $('#inboxRowsPerPageSelect').val());
        params.delete('page');
        window.location.href = window.location.pathname + '?' + params.toString();
    });

    $('#inboxRowsPerPageSelect').on('change', function () {
        var params = new URLSearchParams(window.location.search);
        params.set('per_page', $(this).val());
        params.delete('page');
        window.location.href = window.location.pathname + '?' + params.toString();
    });
    

});

$('body').on('change', '.discussion-check', function () {

    var checkbox = $(this);
    var discussion_id = checkbox.val();
    var discussion_type = checkbox.data('discussion-type');
    var is_completed = checkbox.prop('checked') ? 1 : 0;

    $.ajax({
        url: discussionUpdateUrl[discussion_type] + discussion_id,
        method: 'POST',
        data: {
            is_completed: is_completed,
            '_token': '{{ csrf_token() }}'
        },
        success: function (data) {

            if (discussion_type == 'discussion') {

                $('.discussion-check-id-' + discussion_id).prop('checked', is_completed == 1);

                // If exists in My Tasks page
                $('#my_task_check_' + discussion_id).prop('checked', is_completed == 1);

            } else {

                $('.sub-discussion-check-id-' + discussion_id).prop('checked', is_completed == 1);

            }

        },
        error: function (xhr, status, error) {
            swal({
                title: "Error!",
                text: error,
                type: "warning",
                buttons: true,
                dangerMode: true,
                confirmButtonColor: '#5fb644',
            });
        }
    });

});
</script>


@endsection
