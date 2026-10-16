@extends('layouts.app', ['activePage' => 'my_tasks', 'titlePage' => __($pageTitle ?? 'My Tasks')])

@section('content')
<style>
    .project-inner-title {
        display: flex;
        align-items: center;
        font-size: 1.5rem;
        font-weight: 700;
        gap: 12px;
    }

    .project-inner-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #fff;
        margin-right: -8px;
        box-shadow: 0 0 0 1px #bbb;
    }

    .project-inner-user-group {
        display: flex;
        align-items: center;
        gap: 0.2rem;
    }

    .project-inner-user-group .project-inner-avatar {
        border: 2px solid #fff;
        margin-left: -8px;
    }

    .project-inner-back-btn {
        border: 1px solid #313131;
        border-radius: 20px;
        padding: 4px 18px;
        background: #fff;
        color: #313131;
        font-size: 13px;
        margin-left: 18px;
        transition: background 0.2s;
    }

    .project-inner-back-btn:hover {
        background: #f5f5f5;
    }

    .project-inner-add-task,
    .project-inner-add-section {
        color: #888;
        font-size: 1rem;
        cursor: pointer;
        padding: 6px 0 6px 32px;
        display: block;
    }

    .project-inner-add-section {
        font-size: 1.1rem;
        font-weight: 500;
        color: #bbb;
        padding-left: 0;
    }

    .project-inner-tabs {
        background-color: transparent;
    }

    .inner_tab {
        border-color: transparent !important;
        background-color: transparent !important;
        color: #333;
    }

    .nav-item .nav-link.active {
        color: #ffffff !important;
        font-weight: 600;
        background-color: rgb(79, 79, 79) !important;
        border-radius: unset;
    }

    .nav-tabs {
        border-bottom: unset;
        padding: 2px;
    }

    .nav-tabs .nav-item {
        margin-bottom: unset;
    }

    .task-tabs-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        padding: 0.8rem 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .task-nav-left {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .task-filter-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: nowrap;
        min-width: 200px;
    }

    .task-search-wrapper {
        flex: 1;
        display: flex;
        justify-content: center;
        min-width: 250px;
    }

    .task-search-wrapper .advance-search {
        width: 100%;
        max-width: 420px;
    }

    .form-select-sm {
        padding: 0.35rem 0.85rem 0.35rem 0.65rem;
        border-radius: 0.5rem;
        border: 1px solid #d1d5db;
        background: #ffffff;
        color: #111827;
        min-height: 35px;
        font-size: 0.85rem;
        box-shadow: inset 0 1px 2px rgba(15, 23, 42, 0.08);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-select-sm:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        outline: none;
    }

    .task-tab-icon {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0;
        border: none;
        background: transparent !important;
        color: #111827;
        box-shadow: none;
        padding: 4px;
        border-bottom: 2px solid transparent;
        transition: color 0.15s ease, transform 0.15s ease, border-color 0.15s ease;
    }

    .task-tab-icon:hover {
        background: transparent !important;
        color: #2563eb;
        transform: none;
    }

    .task-tab-icon.active,
    .task-tab-icon.nav-link.active {
        background: transparent !important;
        color: #2563eb !important;
        transform: none !important;
        border-bottom-color: #2563eb !important;
    }

    .task-tab-icon i {
        font-size: 1.05rem;
    }

    .task-tab-icon[title] {
        position: relative;
    }

    .task-tab-icon[title]:hover::after {
        content: attr(title);
        position: absolute;
        bottom: calc(100% + 10px);
        left: 50%;
        transform: translateX(-50%);
        white-space: nowrap;
        background: rgba(15, 23, 42, 0.92);
        color: #ffffff;
        padding: 0.45rem 0.65rem;
        font-size: 0.78rem;
        border-radius: 12px;
        z-index: 10;
        pointer-events: none;
        opacity: 0.98;
    }

    @media (max-width: 991.98px) {
        .task-search-wrapper {
            justify-content: center;
            width: 100%;
        }

        .task-filter-group {
            justify-content: center;
            width: 100%;
        }

        .task-nav-left {
            width: 100%;
            justify-content: center;
        }
    }

    .filter_btn {
        border: 1px solid gray;
        color: gray;
        font-weight: 600;
        padding: 5px 12px;
    }

    .table-responsive .table tbody td {
        padding: 0.4rem 1rem !important;
    }

    .border_left_unset {
        border-left: unset !important;
    }

    .border_right_unset {
        border-right: unset !important;
    }

    .dark_card {
        /* background: #323232; */
        color: #4E4C4C;
        box-shadow: 0px 2px 4px 0px #00000026;
    }

    .margin_right {
        margin-right: 5px;
    }

    .add_task_btn {
        border: unset;
        text-align: left;
        color: gray;
        font-weight: 100;
    }

    .add_task_btn:hover {
        border: unset;
        text-align: left;
        color: gray;
        font-weight: 100;
        background-color: transparent;
    }

    .add_task_btn_div {
        padding: unset;
        background-color: transparent !important;
        border: unset !important;
    }

    .add_task_btn_div:hover {
        padding: unset;
        background-color: transparent !important;
        border: unset !important;
    }

    .project-inner-tabs .nav-link:focus,
    .project-inner-tabs .nav-link:focus-visible {
        outline: none;
        box-shadow: none;
    }

    .padding_bottom_5px {
        padding-bottom: 5px;
    }

    .font_15px {
        font-size: 15px !important;
    }

    .margin_left_15px {
        margin-left: 15px;
    }

    /* Base circle style */
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
        margin-right: 8px;
        display: inline-block;
    }

    .circle_checkbox:checked {
        border: unset;
        background-color: #27ae60
    }

    /* Checked state with right mark (✓) */
    .circle_checkbox:checked::before {
        content: "\2713";
        /* Unicode for check mark */
        position: absolute;
        top: 0px;
        left: 5px;
        font-size: 14px;
        color: #ffffff;
        font-weight: bold;
    }

    /* Hide all section rows by default */
    .section-customer-portal {
        display: none;
    }

    .cursor_pointer {
        cursor: pointer;
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

    .project-index-projecticon {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: #fff;
        margin-right: 12px;
    }

    .task-name-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        width: calc(100% - 40px);
    }

    .my-task-title {
        flex: 1 1 auto;
        min-width: 0;
        font-size: 0.9rem;
        font-weight: 400;
        text-align: left;
        color: #111827;
        background: transparent;
        outline: none;
        padding: 0;
        border: none;
    }

    .my-task-title:focus {
        outline: none;
        box-shadow: none;
    }

    .inbox-item-meta {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 0.25rem;
        color: #6b7280;
    }

    .inbox-item-date {
        font-size: 0.8rem;
        color: #6b7280;
        white-space: nowrap;
    }

    .priority-indicator {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 0;
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
        display: none;
        /* hide label, show status via tooltip on hover */
    }

    .priority-indicator.low .priority-dot {
        background: #2e7d32;
    }

    .priority-indicator.low .priority-text {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .priority-indicator.medium .priority-dot {
        background: #f57f17;
    }

    .priority-indicator.medium .priority-text {
        background: #fff9c4;
        color: #f57f17;
    }

    .priority-indicator.high .priority-dot {
        background: #e65100;
    }

    .priority-indicator.high .priority-text {
        background: #fff3e0;
        color: #e65100;
    }

    .priority-indicator.critical .priority-dot {
        background: #c62828;
    }

    .priority-indicator.critical .priority-text {
        background: #ffebee;
        color: #c62828;
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

    @media (max-width: 767.98px) {
        .project-index-projecticon {
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
        }
        .content-position {
            padding-left: 10px !important;
            padding-right: 10px !important;
            margin-top: 8% !important;
        }
        .card-body {
            padding-left: 4px !important;
            padding-right: 4px !important;
        }
        /* --- Filter / Search row rearrangement --- */
        .task-tabs-row {
            flex-direction: row;
            flex-wrap: wrap;
            gap: 0.5rem;
            padding: 0.6rem 0;
            align-items: center;
        }

        /* Search bar full width, on top (order -1 + 100% width forces its own row) */
        .task-search-wrapper {
            order: -1;
            width: 100%;
            min-width: unset;
            justify-content: stretch;
            flex: 0 0 100%;
        }

        .task-search-wrapper .advance-search {
            max-width: 100%;
            width: 100%;
        }

        /* Status + Per-page selects – shrink to share row with icons */
        .task-filter-group {
            order: 0;
            flex: 1 1 100%;
            flex-wrap: wrap;
            gap: 0.4rem;
            justify-content: flex-start;
            min-width: 0;
            margin-right: 0 !important;
            padding-right: 0 !important;
            width: 100% !important;
        }

        /* Shrink the selects to fit */
        .task-filter-group .form-select-sm {
            flex: 1 1 auto;
            min-width: 0 !important;
            font-size: 0.8rem;
            width: auto !important;
        }

        /* View-mode icons – stay on same row as selects, pushed to right */
        .task-nav-left {
            order: 0;
            width: auto;
            flex-shrink: 0;
            justify-content: flex-end;
            margin-left: auto;
            gap: 0;
        }
        
        .task-filter-group .form-select-sm:last-child,
        .task-filter-group #taskAssigneeFilter,
        .task-filter-group #taskAssigneeFilter + .select2-container {
            flex: 1 1 100% !important;
            width: 100% !important;
            min-width: 0 !important;
        }
        /* --- Transform table into cards --- */

        /* Hide table header completely */
        #my_tasks_table thead {
            display: none !important;
        }

        /* Make table & tbody behave like a block list */
        #my_tasks_table,
        #my_tasks_table tbody {
            display: block !important;
            width: 100% !important;
            border: none !important;
            background: transparent !important;
        }

        /* Each <tr> becomes a card with flex layout */
        #my_tasks_table tbody tr {
            display: flex !important;
            flex-flow: row wrap !important;
            position: relative !important;
            background: #fff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 10px !important;
            margin-bottom: 10px !important;
            padding: 12px 12px !important;
            /* box-shadow: 0 1px 4px rgba(0,0,0,0.06) !important; */
            box-shadow: 0 2px 6px rgba(0,0,0,0.2) !important;
            width: 100% !important;
        }

        /* Hide all <td>s by default, show only what we need */
        #my_tasks_table tbody tr td {
            display: none !important;
            border: none !important;
            padding: 0 !important;
        }

        /* ── Row 1: checkbox + task title + priority dot ── */
        /* td[0] = name col */
        #my_tasks_table tbody tr td:nth-child(1) {
            display: flex !important;
            align-items: flex-start !important;
            justify-content: space-between !important;
            flex: 0 0 100% !important;
            max-width: 100% !important;
            order: 1 !important;
            padding-bottom: 4px !important;
        }

        /* td[1] = priority dot col – absolutely position it to the right */
        #my_tasks_table tbody tr td:nth-child(2) {
            position: absolute !important;
            top: 12px !important;
            right: 12px !important;
            width: auto !important;
            display: flex !important;
            align-items: center !important;
            order: 5 !important;
        }

        /* ── Row 2: due date ── */
        /* td[2] = due date col */
        #my_tasks_table tbody tr td:nth-child(3) {
            display: flex !important;
            align-items: center !important;
            flex: 0 0 100% !important;
            max-width: 100% !important;
            order: 2 !important;
            padding-top: 4px !important;
            padding-bottom: 8px !important;
            margin-bottom: 8px !important;
            font-size: 0.78rem !important;
            color: #6b7280 !important;
        }

        /* ── Row 3: assignee (left) + project (right) separated by top border line ── */
        /* td[4] = assigned by (Assignee goes to the left) */
        #my_tasks_table tbody tr td:nth-child(5) {
            display: inline-flex !important;
            align-items: center !important;
            flex: 0 0 50% !important;
            width: 50% !important;
            max-width: 50% !important;
            min-height: 28px !important;
            order: 3 !important;
            font-size: 0.78rem !important;
            border-top: 1px solid #e5e7eb !important;
            padding-top: 8px !important;
        }

        /* td[3] = project (Project ALWAYS stays on the right) */
        #my_tasks_table tbody tr td:nth-child(4) {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            text-align: right !important;
            flex: 0 0 50% !important;
            width: 50% !important;
            max-width: 50% !important;
            min-height: 28px !important;
            margin-left: auto !important; /* ensures it pushes to right even if assignee td is empty */
            order: 4 !important;
            font-size: 0.78rem !important;
            border-top: 1px solid #e5e7eb !important;
            padding-top: 8px !important;
        }

        /* Hide the action (delete) column on mobile */
        #my_tasks_table tbody tr td:nth-child(6) {
            display: none !important;
        }

        /* Make the task title wrap properly across multiple lines (2 or 3 lines) on mobile */
        #my_tasks_table tbody tr td:nth-child(1) .d-flex {
            width: 100% !important;
            display: flex !important;
            align-items: flex-start !important;
        }

        /* The task-name wrapper should fill the row minus checkbox */
        #my_tasks_table .task-name-group {
            flex: 1 1 auto !important;
            min-width: 0 !important;
            width: calc(100% - 32px) !important;
            padding-right: 20px !important; /* reserve space so text doesn't touch priority dot */
            display: block !important;
        }

        #my_tasks_table .my-task {
            position: relative !important;
            display: block !important;
            width: 100% !important;
            min-width: 0 !important;
            min-height: 1.35rem !important;
        }

        /* In standard HTML, input[type="text"] cannot wrap text across lines. 
           We hide the single-line input text when disabled on mobile, and render the full multi-line title via data attribute or value */
        #my_tasks_table .my-task-title:disabled {
            color: transparent !important;
            -webkit-text-fill-color: transparent !important;
            text-shadow: none !important;
            caret-color: transparent !important;
            pointer-events: none !important;
            user-select: none !important;
            height: 0 !important;
            min-height: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
            border: 0 !important;
            position: absolute !important;
            opacity: 0 !important;
        }

        /* When editing, restore the input box */
        #my_tasks_table .my-task-title.editing {
            position: relative !important;
            opacity: 1 !important;
            color: #111827 !important;
            -webkit-text-fill-color: #111827 !important;
            height: auto !important;
            width: 100% !important;
            white-space: normal !important;
            z-index: 10 !important;
        }

        /* Overlay displays the full wrapped text across multiple lines naturally */
        #my_tasks_table .task-input-overlay {
            position: relative !important;
            inset: auto !important;
            display: block !important;
            width: 100% !important;
            font-size: 0.88rem !important;
            font-weight: 500 !important;
            color: #111827 !important;
            line-height: 1.35 !important;
            white-space: normal !important;
            word-break: break-word !important;
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
            cursor: pointer !important;
        }

        /* Due date: add a calendar icon via content */
        #my_tasks_table tbody tr td:nth-child(3)::before {
            content: "\f073"; /* fa-calendar */
            font-family: "Font Awesome 5 Free", "FontAwesome";
            font-weight: 400;
            margin-right: 5px;
            font-size: 0.75rem;
            color: #9ca3af;
        }

        /* Date input on mobile: look like plain text */
        #my_tasks_table tbody tr td:nth-child(3) input[type="date"] {
            border: none !important;
            background: transparent !important;
            font-size: 0.78rem !important;
            color: #6b7280 !important;
            padding: 0 !important;
            width: auto !important;
        }

        /* Project container and link - align everything strictly to the right edge */
        #my_tasks_table tbody tr td:nth-child(4) a {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            text-align: right !important;
            text-decoration: none !important;
            margin-left: auto !important;
            max-width: 100% !important;
        }

        #my_tasks_table tbody tr td:nth-child(4) a > .d-flex {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            text-align: right !important;
            flex-wrap: nowrap !important;
            margin-left: auto !important;
            max-width: 100% !important;
            gap: 2px !important;
        }

        #my_tasks_table tbody tr td:nth-child(4) .project-index-projecticon {
            flex-shrink: 0 !important;
            margin-right: 0 !important;
        }

        /* Project name text */
        #my_tasks_table tbody tr td:nth-child(4) a div div {
            white-space: normal !important;
            overflow: visible !important;
            text-overflow: unset !important;
            max-width: unset !important;
            font-size: 0.75rem !important;
            line-height: 1.2 !important;
            word-break: break-word !important;
            text-align: right !important;
        }

        /* Avatar sizing on mobile */
        #my_tasks_table .user-avatar {
            width: 22px !important;
            height: 22px !important;
            border-radius: 50% !important;
            flex-shrink: 0 !important;
            margin-right: 6px !important;
            box-shadow: none !important;
            border: 1px solid #ccc !important;
        }

        /* Username text next to avatar - show full name */
        #my_tasks_table tbody tr td:nth-child(5) .text-gray {
            padding-left: 0px !important;
            font-size: 0.75rem !important;
            white-space: normal !important;
            overflow: visible !important;
            text-overflow: unset !important;
            max-width: unset !important;
            line-height: 1.2 !important;
            word-break: break-word !important;
        }

        /* Table-responsive wrapper: remove horizontal scroll on mobile */
        .table-responsive {
            overflow-x: unset !important;
        }

        /* DataTable info text */
        #my_tasks_table_wrapper .dataTables_info {
            font-size: 0.72rem !important;
        }
    }

    .bg-box.container-fluid.fix-nav.header-layout {
        margin-bottom: .5rem !important;
    }

    /* Make Select2 match native form-select-sm exactly */
    #taskAssigneeFilter+.select2-container {
        min-width: 140px !important;
        width: auto !important;
    }

    #taskAssigneeFilter+.select2-container--default .select2-selection--single {
        height: calc(1.5em + 0.575rem + 2px) !important;
        padding: 0.35rem 2rem 0.35rem 0.65rem !important;
        border: 1px solid #d1d5db !important;
        border-radius: 0.5rem !important;
        background-color: #ffffff !important;
        box-shadow: inset 0 1px 2px rgba(15, 23, 42, 0.08) !important;
        /* Match the native select arrow */
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right 0.65rem center !important;
        background-size: 12px !important;
    }

    #taskAssigneeFilter+.select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 1.5 !important;
        padding: 0 !important;
        color: #111827 !important;
        font-size: 0.85rem !important;
    }

    #taskAssigneeFilter+.select2-container--default .select2-selection--single .select2-selection__arrow {
        display: none !important;
        /* hide Select2's arrow, we use CSS background arrow above */
    }

    #taskAssigneeFilter+.select2-container--default.select2-container--focus .select2-selection--single,
    #taskAssigneeFilter+.select2-container--default.select2-container--open .select2-selection--single {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12) !important;
    }

    #taskAssigneeFilter+.select2-container--default .select2-dropdown {
        border: 1px solid #d1d5db !important;
        border-radius: 0.5rem !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
        font-size: 0.85rem !important;
    }

    #taskAssigneeFilter+.select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid #d1d5db !important;
        border-radius: 0.375rem !important;
        padding: 0.35rem 0.65rem !important;
        font-size: 0.85rem !important;
        outline: none !important;
    }

    #taskAssigneeFilter+.select2-container--default .select2-search--dropdown .select2-search__field:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12) !important;
    }

    #taskAssigneeFilter+.select2-container--default .select2-results__option {
        padding: 0.45rem 0.85rem !important;
        font-size: 0.85rem !important;
        color: #111827 !important;
    }

    #taskAssigneeFilter+.select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #eff6ff !important;
        color: #1d4ed8 !important;
    }

    #taskAssigneeFilter+.select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #dbeafe !important;
        color: #1e40af !important;
    }
</style>
<div class="container-fluid mb-5 content-position" style="padding-left: 20px !important; padding-right: 20px !important;">
    <div class="se-pre-con"></div>

    @section('order-header')
    <span>{{ strtoupper($pageTitle ?? 'My Tasks') }}</span>
    @endsection

    @section('back-btn')
    <a href="{{ route('home') }}" class="home-btn-color">BACK TO HOME</a>
    @endsection
    <div class="card shadow-sm mb-4" style="font-family: Arial, sans-serif;">

        <div class="card-body py-3 px-4">
            {{-- <div class="d-flex flex-wrap justify-content-between align-items-center mb-3"> --}}
            {{-- <div class="project-inner-title">
                    <span style="border-radius:50%; padding: 6px; width:36px; height:36px; display:flex; align-items:center; justify-content:center; background: #202aba;">
                        <i class="fa fa-user" style="color:#fff; font-size: smaller;"></i>
                    </span>
                    <span id="project_name">MY TASKS</span>
                </div> --}}
            {{-- <div class="project-inner-user-group">
                    <a href="{{ route('projects.list') }}" class="project-inner-back-btn">BACK</a>
        </div> --}}
        {{-- </div> --}}
        <!-- Bootstrap Nav Tabs -->
        <div class="task-tabs-row mb-3 project-inner-tabs">
            <div class="task-filter-group d-flex align-items-center gap-2 flex-wrap">
                <select class="form-select form-select-sm" id="taskPerPageFilter" style="min-width: 65px; width: 65px;">
                    <option value="20" selected>20</option>
                    <option value="40">40</option>
                    <option value="60">60</option>
                    <option value="100">100</option>
                </select>
                <select class="form-select form-select-sm" id="taskStatusFilter" style="min-width: 120px;">
                    <option value="">All Status</option>
                    <option value="upcoming">Pending</option>
                    <option value="overdue">Overdue</option>
                    <option value="completed">Completed</option>
                    <!-- <option value="incomplete">Incomplete</option> -->
                </select>
                @if($isAdminViewingAll ?? false)
                <select class="form-select form-select-sm" id="taskAssigneeFilter" style="min-width: 140px;">
                    <option value="">All Assignees</option>
                    @foreach($activeUsers as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @endif
            </div>
            <div class="task-search-wrapper">
                @include('pages.project.partials.project_master_search')
            </div>
            <div class="task-nav-left nav nav-tabs" role="tablist">
                <button class="task-tab-icon nav-link active" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab" aria-controls="list" aria-selected="true" title="List">
                    <i class="fas fa-list"></i>
                </button>
                <button class="task-tab-icon nav-link" id="board-tab" data-bs-toggle="tab" data-bs-target="#board" type="button" role="tab" aria-controls="board" aria-selected="false" title="Board">
                    <i class="fas fa-th-large"></i>
                </button>
                <button class="task-tab-icon nav-link" id="calendar-tab" data-bs-toggle="tab" data-bs-target="#calendar" type="button" role="tab" aria-controls="calendar" aria-selected="false" title="Calendar">
                    <i class="fas fa-calendar-alt"></i>
                </button>
            </div>
        </div>
        <div class="tab-content" id="projectTabContent">
            <!-- List Tab -->
            <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
                @include('pages.project.partials.my_tasks_inner_list')
            </div>
            <!-- Board Tab -->
            <div class="tab-pane fade" id="board" role="tabpanel" aria-labelledby="board-tab" style="overflow: auto; padding-bottom: 30px;">
                @include('pages.project.partials.my_tasks_inner_board')
            </div>
            <!-- Calendar Tab -->
            <div class="tab-pane fade" id="calendar" role="tabpanel" aria-labelledby="calendar-tab">
                @include('pages.project.partials.my_tasks_inner_calendar')
            </div>
            <!-- Timeline Tab -->
            {{-- <div class="tab-pane fade" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
                    <div class="text-center py-5 text-muted">Timeline coming soon...</div>
                </div> --}}
        </div>
    </div>
</div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function buildTaskFilterQuery(extraParams = {}) {
        var query = [];
        var status = $('#taskStatusFilter').val();
        var assignee = $('#taskAssigneeFilter').length ? $('#taskAssigneeFilter').val() : '';
        var perPage = $('#taskPerPageFilter').length ? $('#taskPerPageFilter').val() : '20';

        if (status) {
            query.push('task_type=' + encodeURIComponent(status));
        }
        if (assignee) {
            query.push('assignee_id=' + encodeURIComponent(assignee));
        }
        if (perPage) {
            query.push('per_page=' + encodeURIComponent(perPage));
        }

        for (var key in extraParams) {
            if (extraParams.hasOwnProperty(key) && extraParams[key] !== undefined && extraParams[key] !== null) {
                query.push(encodeURIComponent(key) + '=' + encodeURIComponent(extraParams[key]));
            }
        }

        return query.length ? '?' + query.join('&') : '';
    }

    function refreshCalendar() {
        if (typeof calendar !== 'undefined' && calendar) {
            calendar.refetchEvents();
        }
    }

    $(document).ready(function() {
        // Ensure Select2 styling matches the native selects
        const style = document.createElement('style');

        document.head.appendChild(style);

        // Initialize Select2 WITHOUT placeholder so the empty option is treated as a normal item
        if ($('#taskAssigneeFilter').length) {
            if ($('#taskAssigneeFilter').hasClass('select2-hidden-accessible')) {
                $('#taskAssigneeFilter').select2('destroy');
            }

            // Make sure the native select has the "All Assignees" option with value=""
            if ($('#taskAssigneeFilter option[value=""]').length === 0) {
                $('#taskAssigneeFilter').prepend('<option value="">All Assignees</option>');
            }

            $('#taskAssigneeFilter').select2({
                width: 'auto',
                minimumResultsForSearch: 0,
                dropdownParent: $('.task-filter-group')
            });

            // If nothing is selected, default to empty (All Assignees)
            if (!$('#taskAssigneeFilter').val()) {
                $('#taskAssigneeFilter').val('').trigger('change');
            }
        }

        // Lazy loading state flags
        let isBoardLoaded = false;

        // Event listeners
        $('#taskPerPageFilter').on('change', function() {
            displayAllTasks(1);
            refreshCalendar();
        });

        $('#taskStatusFilter').on('change', function() {
            displayAllTasks(1);
            if ($('#board-tab').hasClass('active')) {
                if (typeof displayAllBoardSections === 'function') {
                    displayAllBoardSections();
                }
            } else {
                isBoardLoaded = false;
            }
            refreshCalendar();
        });

        $('#taskAssigneeFilter').on('change', function() {
            displayAllTasks(1);
            if ($('#board-tab').hasClass('active')) {
                if (typeof displayAllBoardSections === 'function') {
                    displayAllBoardSections();
                }
            } else {
                isBoardLoaded = false;
            }
            refreshCalendar();
        });

        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            const tabId = $(e.target).attr('data-bs-target');
            if (tabId === '#board') {
                if (!isBoardLoaded) {
                    if (typeof displayAllBoardSections === 'function') {
                        displayAllBoardSections();
                    }
                    isBoardLoaded = true;
                }
            } else if (tabId === '#calendar') {
                if (typeof window.initializeMyTasksCalendar === 'function') {
                    window.initializeMyTasksCalendar();
                }
                refreshCalendar();
            }
        });
    });
</script>

@include('pages.project.task_comment')

@include('pages.project.partials.share_project_modal')

@endsection