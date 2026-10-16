@extends('layouts.app', ['activePage' => 'systemadmin_dashboard', 'titlePage' => __('System Admin Dashboard')])

@section('order-header')
<span>Dashboard</span>
@endsection

@section('back-btn')
<a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
@endsection

@section('content')
<style>
    /* ------------------------------
       GLOBAL VARIABLES & RESETS
    ------------------------------ */
    :root {
        --card: #ffffff;
        --border: #e5e7eb;
        --text: #1f2937;
        --muted: #6b7280;
        --blue: #2563eb;
        --blue-light: #eff6ff;
        --green: #16a34a;
        --red: #dc2626;
        --amber: #d97706;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.08);
        --radius: 16px;
    }

    .db-page {
        background: var(--bg);
    }

    /* Align system config card with grid below */
    .db-page>.db-card {
        width: 100%;
    }

    .db-page>.row.db-main-row {
        margin-left: 0;
        margin-right: 0;
    }

    .db-page.container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .db-page>.db-card:first-child {
        margin-left: 0;
        margin-right: 0;
        margin-bottom: .8rem;
    }

    /* ------------------------------
       BASE CARD COMPONENT
    ------------------------------ */
    .db-card {
        display: flex;
        flex-direction: column;
        background: var(--card);
        border-radius: 1px;
        box-shadow: var(--shadow-sm);
        margin-bottom: 1.5rem;
        min-height: 260px;
    }

    .db-card-header {
        padding: .3rem .5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: .5rem;
    }

    .db-card-title {
        font-size: .95rem;
        font-weight: 700;
        color: var(--text);
        margin: 0 !important;
        margin-bottom: 0 !important;
    }

    .db-card-body {
        padding: .5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    /* Force equal height for columns on large screens */
    @media (min-width: 992px) {
        .row.db-main-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: auto auto auto;
            gap: .8rem;
            align-items: stretch;
        }

        .row.db-main-row>.col-lg-7 {
            grid-column: 1;
            display: contents;
            /* cards placed directly into grid */
        }

        .row.db-main-row>.col-lg-5 {
            grid-column: 2;
            display: contents;
        }

        /* Row 1: Tasks (col1) + Leave Calendar (col2) — same height */
        .row.db-main-row>.col-lg-7>.db-card:nth-child(1) {
            grid-row: 1;
            grid-column: 1;
        }

        .row.db-main-row>.col-lg-5>.db-card:nth-child(1) {
            grid-row: 1;
            grid-column: 2;
        }

        /* Row 2: Enquiries (col1) + Emails (col2) */
        .row.db-main-row>.col-lg-7>.db-card:nth-child(2) {
            grid-row: 2;
            grid-column: 1;
        }

        .row.db-main-row>.col-lg-5>.db-card:nth-child(2) {
            grid-row: 2;
            grid-column: 2;
        }

        /* Row 3: Orders (col1) + Meetings (col2) */
        .row.db-main-row>.col-lg-7>.db-card:nth-child(3) {
            grid-row: 3;
            grid-column: 1;
        }

        .row.db-main-row>.col-lg-5>.db-card:nth-child(3) {
            grid-row: 3;
            grid-column: 2;
        }
    }

    /* ------------------------------
       SYSTEM CONFIGURATION STRIP
    ------------------------------ */
    .config-strip {
        display: flex;
        flex-wrap: nowrap;
        gap: 0.75rem;
    }

    .config-item {
        flex: 1;
        min-width: 0;
        background: #f6f7f7;
        border-radius: 4px;
        padding: .5rem .5rem;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: flex-start;
        gap: .25rem;
    }

    /* Special background for live/dev environments */
    .config-item.state-live {
        background: #f0fdf4;
        border-color: #bbf7d0;
    }

    .config-item.state-dev {
        background: #fefce8;
        border-color: #fde68a;
    }

    .config-label {
        font-size: .67rem;
        letter-spacing: .03em;
        color: var(--muted);
        display: block;
        /* margin-bottom: .15rem; */
        white-space: nowrap;
    }

    .config-value {
        font-size: .7rem !important;
        color: var(--text);
        font-weight: 600;
    }

    .config-value.state-live {
        color: #15803d;
    }

    .config-value.state-dev {
        color: #92400e;
    }

    /* Buttons inside config items */
    .config-item .btn.btn-sm {
        font-size: .72rem;
        font-weight: 600;
        padding: .3rem .5rem;
        border-radius: 999px;
        white-space: nowrap;
        flex-shrink: 0;
        line-height: 1.3;
        min-width: 52px;
        height: auto;
    }

    /* Place the action button on its own row and align to the right */
    .config-item .btn {
        align-self: flex-end;
        margin-top: .1rem;
    }

    /* Responsive config strip */
    @media (max-width: 900px) {
        .config-strip {
            flex-wrap: wrap;
        }

        .config-item {
            flex: 1 1 45%;
        }
    }

    @media (max-width: 576px) {
        .config-item {
            flex: 1 1 100%;
        }
    }

    /* .db-page {
        margin-top: -2rem;
    } */

    /* ------------------------------
       BADGES & PILLS
    ------------------------------ */
    .bp {
        display: inline-flex;
        align-items: center;
        padding: .28rem .65rem;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 700;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .bp-blue {
        background: #2563eb;
    }

    .bp-green {
        background: #16a34a;
    }

    .bp-red {
        background: #dc2626;
    }

    .bp-amber {
        background: #d97706;
    }

    .bp-indigo {
        background: #4338ca;
    }

    .bp-gray {
        background: #6b7280;
    }

    .bp-outline-blue {
        background: #D4E6FD;
        color: #023E8A;
        border: 1px solid #bfdbfe;
    }

    .bp-outline-green {
        background: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
    }

    .bp-outline-red {
        background: #FFEDEE;
        color: #D00000;
        border: 1px solid #fecaca;
    }

    /* ------------------------------
       TASKS (DASHBOARD TASK LIST)
    ------------------------------ */
    .dashboard-task-filter {
        min-width: 0;
        flex-shrink: 0;
    }

    .dashboard-task-filter label {
        margin-bottom: .35rem;
        display: block;
        font-size: .72rem;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: .08em;
    }

    .dashboard-task-list {
        display: flex;
        flex-direction: column;
        padding: .25rem .5rem;
        overflow-y: auto;
        flex: 1;
        min-height: 0;
        gap: 0;
    }

    .dashboard-task-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        background: transparent;
        border: none;
        border-bottom: 1px solid #f3f4f6;
        border-radius: 0;
        padding: .6rem .5rem;
        min-height: 48px;
        text-decoration: none;
        color: inherit;
        transition: background .15s;
    }

    .dashboard-task-item:last-child {
        border-bottom: none;
    }

    a.dashboard-task-item:hover {
        background: #f8fafc;
        border-radius: 8px;
    }

    .dashboard-task-main {
        min-width: 0;
        display: grid;
        gap: .25rem;
    }

    .dashboard-task-name {
        font-size: .85rem;
        font-weight: 600;
        color: #111827;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .dashboard-task-meta {
        font-size: 0.72rem;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .dashboard-task-meta span {
        display: inline-flex;
        align-items: center;
    }

    .dashboard-priority-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 4px;
        border: 1px solid;
    }

    .dashboard-priority-dot.low {
        background-color: #2e7d32;
        border-color: #2e7d32;
    }

    .dashboard-priority-dot.medium {
        background-color: #f57f17;
        border-color: #f57f17;
    }

    .dashboard-priority-dot.high {
        background-color: #e65100;
        border-color: #e65100;
    }

    .dashboard-priority-dot.critical {
        background-color: #c62828;
        border-color: #c62828;
    }

    .dashboard-task-right {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
        white-space: nowrap;
    }

    .dashboard-task-due {
        font-size: .72rem;
        color: #6b7280;
        font-weight: 500;
    }

    .task-status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: .22rem .6rem;
        border-radius: 999px;
        font-size: .68rem;
        font-weight: 700;
        text-transform: capitalize;
        letter-spacing: .02em;
        min-width: 72px;
        text-align: center;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .task-status-badge.complete {
        background: #d1fae5;
        color: #166534;
    }

    .task-status-badge.overdue {
        background: #fee2e2;
        color: #991b1b;
    }

    .task-status-badge.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .dashboard-task-empty {
        color: #6b7280;
        padding: 1.5rem 0;
        font-size: .92rem;
    }

    /* ------------------------------
       ENQUIRIES (TABS & ROWS)
    ------------------------------ */
    .enq-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        /* margin-bottom: 1rem; */
    }

    .enq-tab {
        display: inline-flex;
        align-items: center;
        background: transparent;
        border: none;
        padding: .45rem 0;
        font-size: .88rem;
        font-weight: 500;
        color: #4b5563;
        cursor: pointer;
        transition: all .15s;
    }

    .enq-tab.active {
        color: #111827;
        font-weight: 600;
    }

    .enq-row {
        display: flex;
        align-items: flex-start;
        gap: 0;
        padding: .5rem .5rem;
        border-bottom: 1px solid var(--border);
    }

    .enq-row:last-child {
        border-bottom: none;
    }

    .enq-body {
        flex: 1;
        min-width: 0;
    }

    .enq-top {
        display: flex;
        align-items: center;
        gap: .5rem;
        flex-wrap: wrap;
    }

    .enq-name {
        font-weight: 700;
        font-size: .88rem;
        color: var(--text);
    }

    .enq-time {
        font-size: .8rem;
        color: var(--muted);
        margin-left: auto;
        white-space: nowrap;
    }

    .enq-preview {
        font-size: .82rem;
        color: var(--muted);
        margin: .2rem 0 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }

    .enq-date-chip {
        display: flex;
        align-items: center;
        gap: .35rem;
        font-size: .8rem;
        color: var(--muted);
        font-weight: 600;
    }

    #enqDateInput::-webkit-calendar-picker-indicator {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    /* ------------------------------
       ORDERS TABLE
    ------------------------------ */
    .orders-table {
        width: 100%;
        border-collapse: collapse;
        font-size: .85rem;
    }

    .orders-table th {
        background: #f8fafc;
        font-size: .75rem;
        font-weight: 700;
        color: var(--muted);
        padding: .75rem .85rem;
        border-bottom: 1px solid var(--border);
        text-align: left;
    }

    .orders-table td {
        padding: .75rem .85rem;
        border-bottom: 1px solid var(--border);
        color: var(--text);
    }

    .orders-table tbody tr:hover {
        background: #f9fafb;
    }

    .orders-table th .sort-icon {
        margin-left: .25rem;
        opacity: .5;
        font-size: .7rem;
    }

    /* ------------------------------
       LEAVE CALENDAR
    ------------------------------ */
    .cal-head {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 4px;
        margin-bottom: 4px;
    }

    .cal-head-cell {
        text-align: center;
        font-size: .72rem;
        font-weight: 700;
        color: var(--muted);
        padding: .3rem 0;
    }

    .cal-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 4px;
    }

    .cal-cell {
        text-align: center;
        font-size: .8rem;
        color: var(--text);
        border-radius: 8px;
        padding: .45rem .2rem;
        min-height: 38px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        gap: 2px;
        position: relative;
    }

    .cal-cell.today {
        background: #E0F9D4;
        color: #1a6b00;
        font-weight: 700;
        border: 2px solid #55A630;
        box-shadow: 0 0 0 1px rgba(85, 166, 48, 0.2);
    }

    .cal-cell.weekend {
        background: #FFF6F7;
        color: #D00000;
    }

    .cal-cell.saturday {
        color: #B3B3B3 !important;
    }

    .cal-cell.holiday {
        background: #FFE6E8;
        color: #D00000;
    }

    .cal-cell.holiday div {
        font-size: 0.6rem;
        font-weight: 500;
        color: #000000;
    }

    .cal-cell.other-month {
        background: #F8F8F8;
        color: #c4c4c4;
    }

    .cal-leave-badge.leave {
        background: #47D6B6;
        color: #fff;
    }

    .cal-cell.selected-leave-day {
        /* background: #e7f6ff; */
        border: 2px solid #0284c7;
        border-radius: 6px;
    }

    .cal-leave-badge {
        font-size: .6rem;
        font-weight: 700;
        border-radius: 999px;
        padding: .1rem .4rem;
        width: 100%;
        text-align: center;
        margin-top: 2px;
        background: #DAF7F0;
        color: #47D6B6;
    }

    /* .cal-leave-badge.orange {
        background: #47D6B6;
        color: #fff;
    }

    .cal-leave-badge.teal {
        background: #0d9488;
    } */

    .leave-today-section {
        margin-top: 1.25rem;
        border-top: 1px solid var(--border);
        padding-top: 1rem;
    }

    .leave-today-header {
        font-size: .82rem;
        font-weight: 700;
        color: #6b7280;
        /* color: var(--text); */
        margin-bottom: .8rem;
        letter-spacing: .07em;
    }

    /* Calendar legend */
    .cal-legend {
        display: flex;
        flex-wrap: wrap;
        gap: .5rem .85rem;
        margin-top: .85rem;
        padding-top: .65rem;
        border-top: 1px solid #f3f4f6;
    }

    .cal-legend-item {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        font-size: .7rem;
        color: #6b7280;
        font-weight: 500;
    }

    .cal-legend-dot {
        width: 12px;
        height: 12px;
        border-radius: 3px;
        flex-shrink: 0;
    }

    .today-leave-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .75rem;
        padding: .75rem 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .today-leave-row:last-child {
        border-bottom: none;
    }

    .today-leave-name {
        font-size: .88rem;
        font-weight: 600;
        color: var(--text);
        min-width: 0;
    }

    .today-leave-type {
        font-size: .75rem;
        color: #47D6B6;
        background: #DAF7F0;
        padding: .25rem .65rem;
        border-radius: 999px;
        white-space: nowrap;
    }

    .today-leave-empty {
        font-size: .82rem;
        color: #6b7280;
        padding: .8rem 0;
    }

    .leave-today-footer {
        margin-top: .8rem;
        font-size: .78rem;
        color: #6b7280;
        text-align: right;
    }

    /* ------------------------------
       UNREAD EMAILS
    ------------------------------ */
    .email-row {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .75rem 0;
        border-bottom: 1px solid var(--border);
    }

    .email-row:last-child {
        border-bottom: none;
    }

    a.email-row:hover {
        background: #f8fafc;
        border-radius: 8px;
        padding-left: 8px;
        padding-right: 8px;
        margin-left: -8px;
        margin-right: -8px;
    }

    .email-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #fff;
        font-size: .8rem;
        background: #94a3b8;
    }

    .email-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .email-body {
        flex: 1;
        min-width: 0;
    }

    .email-name {
        font-size: .88rem;
        font-weight: 700;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: .4rem;
    }

    .email-subj {
        font-size: .8rem;
        color: var(--muted);
        margin: .1rem 0 0;
    }

    .email-time {
        font-size: .78rem;
        color: var(--muted);
        white-space: nowrap;
    }

    .badge-new {
        background: #0d9488;
        color: #fff;
        border-radius: 999px;
        padding: .15rem .5rem;
        font-size: .68rem;
        font-weight: 700;
    }

    /* ------------------------------
       MEETINGS & EVENTS
    ------------------------------ */
    .meeting-item {
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: .85rem;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: .75rem;
    }

    .meeting-item:last-child {
        margin-bottom: 0;
    }

    .meeting-title {
        font-size: .88rem;
        font-weight: 700;
        color: var(--text);
        margin: 0 0 .5rem;
    }

    .meeting-meta {
        display: flex;
        flex-wrap: wrap;
        gap: .5rem;
        align-items: center;
        font-size: .78rem;
        color: var(--muted);
    }

    .meeting-tag {
        background: #eff6ff;
        color: var(--blue);
        border-radius: 999px;
        padding: .2rem .65rem;
        /* font-size: .72rem; */
        /* font-weight: 700; */
    }

    .meeting-zoom {
        color: var(--blue);
        font-size: .78rem;
        text-decoration: none;
    }

    .meeting-ext {
        color: var(--muted);
        flex-shrink: 0;
    }

    /* ------------------------------
       CUSTOM SELECT DROPDOWN (TASK FILTER)
    ------------------------------ */
    .custom-select-wrap {
        position: relative;
        display: inline-flex;
        align-items: center;
        background: #fff;
        border: 1.5px solid #d1d5db;
        border-radius: 999px;
        padding: 0 .6rem 0 .5rem;
        height: 30px;
        min-width: 130px;
        max-width: 160px;
        cursor: pointer;
        user-select: none;
        transition: border-color .15s, box-shadow .15s;
    }

    .custom-select-wrap.open {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
        border-radius: 12px 12px 0 0;
    }

    .custom-select-display {
        flex: 1;
        font-size: .75rem;
        font-weight: 600;
        color: #374151;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 85px;
    }

    .custom-select-arrow {
        color: #6b7280;
        flex-shrink: 0;
        pointer-events: none;
        transition: transform .15s;
    }

    .custom-select-wrap.open .custom-select-arrow {
        transform: rotate(180deg);
    }

    .custom-select-dropdown {
        display: none;
        position: absolute;
        top: calc(100% + 1px);
        left: -1.5px;
        right: -1.5px;
        background: #fff;
        border: 1.5px solid #2563eb;
        border-top: none;
        border-radius: 0 0 12px 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, .1);
        z-index: 9999;
        max-height: 220px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #e5e7eb transparent;
    }

    .custom-select-wrap.open .custom-select-dropdown {
        display: block;
    }

    .custom-select-option {
        padding: .55rem .9rem;
        font-size: .82rem;
        font-weight: 500;
        color: #374151;
        cursor: pointer;
        transition: background .1s;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .custom-select-option:hover {
        background: #eff6ff;
        color: #2563eb;
    }

    .custom-select-option.active {
        background: #eff6ff;
        color: #2563eb;
        font-weight: 700;
    }

    .custom-select-option:last-child {
        border-radius: 0 0 10px 10px;
    }

    .custom-select-icon {
        color: #9ca3af;
        flex-shrink: 0;
        margin-right: .4rem;
    }

    /* ------------------------------
       RESPONSIVE TWEAKS
    ------------------------------ */
    @media (max-width: 576px) {
        .db-card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .enq-time {
            margin-left: 0;
        }
    }

    /* Task filter pills */
    .task-filter-pills {
        display: flex;
        flex-wrap: nowrap;
        gap: .2rem;
        margin-top: 0;
        flex-shrink: 1;
        min-width: 0;
    }

    .task-filter-pill {
        display: inline-flex;
        align-items: center;
        gap: .25rem;
        background: #f8fafc;
        border: 1.5px solid #e5e7eb;
        border-radius: 999px;
        padding: .18rem .45rem;
        font-size: .65rem;
        font-weight: 400;
        color: #6b7280;
        cursor: pointer;
        transition: all .15s;
        user-select: none;
        white-space: nowrap;
    }

    .task-filter-pill.active {
        border-color: #2563eb;
        color: #2563eb;
        background: #eff6ff;
    }

    .task-filter-pill .pill-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #e5e7eb;
        color: #374151;
        border-radius: 999px;
        padding: .05rem .45rem;
        font-size: .68rem;
        font-weight: 700;
        min-width: 18px;
        line-height: 1.4;
    }

    .task-filter-pill.active.overdue .pill-count {
        background: #fecaca;
        color: #991b1b;
    }

    .task-filter-pill.active.pending .pill-count {
        background: #fde68a;
        color: #78350f;
    }

    .task-filter-pill.active.complete .pill-count {
        background: #bbf7d0;
        color: #166534;
    }

    .task-filter-pill.active.all .pill-count {
        background: #d1d5db;
        color: #374151;
    }

    .task-filter-pill .pill-count-inner {
        color: #fff;
        mix-blend-mode: normal;
    }

    .row.db-main-row .db-card {
        margin-bottom: 0;
    }

    .config_btn {
        color: #646262;
        background-color: #F8F8F8;
        border-color: #F8F8F8;
        border-radius: 1px !important;
        padding: .2rem;
        box-shadow: 0 4px 6px rgba(50, 50, 93, .11), 0 1px 3px rgba(0, 0, 0, .08) !important;
        transition: all 0.2s ease-in-out;
        white-space: nowrap;
    }

    .config-content {
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    @media (max-width:531px){
        .header-layout {
            height: 25px;
        }
    }

    @media (max-width:428px){
        .dashboard-task-filter {
            margin-left: unset !important;
        }
    }
    @media (max-width:768px){
        .mobile_config_div_1 {
            border-radius: 8px;
            box-shadow: 0px 1px 3px 0px #0000000A;
            border: 1px solid #E5E7EB;
            padding: 10px;
        }
        .config-item {
            border: 1px solid #E5E7EB;
        }
        .config-item .btn.btn-sm {
            border: 1px solid #E5E7EB;
        }
        .config-item.state-live {
            border: 1px solid #BBF7D0;
        }
        .mobile_mb {
            margin-bottom: 15px !important;
        }
        .mobile_padding_unset {
            padding: unset !important;
        }


        .db-card-header {
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: flex-start !important;
            gap: 10px !important;
            flex-direction: unset;
        }

        /* Hide spacer */
        .db-card-header > div[style*="flex:1"] {
            display: none !important;
        }

        /* Title takes full row */
        .db-card-header .db-card-title {
            width: 100%;
            margin-bottom: 0;
        }

        /* Pills + Assignee in same row */
        .task-filter-pills,
        .dashboard-task-filter {
            flex: 0 0 auto;
        }

        .task-filter-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .dashboard-task-filter {
            margin-left: auto; /* pushes dropdown to right side */
        }
        .mobile_orders_header {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            flex-wrap: nowrap !important;
            width: 100%;
        }

        .mobile_orders_header .db-card-title {
            margin-bottom: 0 !important;
            white-space: nowrap;
            width: unset !important;
        }
        .orders-table thead {
            display: none;
        }

        .orders-table,
        .orders-table tbody,
        .orders-table tr,
        .orders-table td {
            display: block;
            width: 100%;
        }

        .orders-table tr {
            border: none !important;
        }

        .mobile-order-card {
            margin-bottom: 12px;
        }

        .mobile-order-card td {
            padding: 0 !important;
            border: none !important;
        }

        .mobile-order-wrapper {
            background: #fff;
            border: 1px solid #E5E7EB;
            border-radius: 10px;
            padding: 14px;
        }

        .mobile-order-header {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 12px;
        }

        .mobile-order-middle {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            gap: 10px;
        }

        .mobile-order-footer {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .mobile-label {
            font-weight: 600;
            color: #000000;
            font-size: 11px;
        }

        .mobile-order-id {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        .mobile-factory {
            text-align: right;
            font-weight: 500;
            color: #374151;
            max-width: 45%;
        }

        .mobile-date {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }
        table a {
            color: #999 !important;
        }
        .mobile_gray_text {
            color: #999 !important;
        }
    }

</style>

<div class="db-page container-fluid pb-5">

    {{-- System Configuration --}}
    <div class="db-card mobile_config_div_1" style="min-height:unset; margin-left:0; margin-right:0;">
        <div class="db-card-header">
            <p class="db-card-title mb-0">System Configuration</p>
        </div>

        <div class="db-card-body">
            <div class="config-strip">

                <!-- Maintenance Mode -->
                <div class="config-item">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div class="d-block">
                            <span class="config-label">Maintenance Mode</span>
                            <span class="config-value">
                                {{ $systemStatus === 'on' ? 'OFF' : 'ON' }}
                            </span>
                        </div>
                        <div class="d-block">
                            <a href="{{ route('configuration.get_dashboard_data') }}"
                                class="btn btn-sm config_btn">
                                Change
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Database Environment -->
                <div class="config-item state-live">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div class="d-block">
                            <span class="config-label d-block">Database Environment</span>
                            <span class="config-value state-live">
                                {{ ucfirst($databaseEnvironment) }}
                            </span>
                        </div>
                        <div class="d-block">
                            <a href="{{ route('configuration.get_database_data') }}"
                                class="btn btn-sm config_btn flex-shrink-0">
                                Change
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Payment Gateway -->
                <div class="config-item state-live">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div class="d-block">
                            <span class="config-label d-block">Payment Gateway</span>
                            <span class="config-value state-live">
                                {{ $currentMode === 'live' ? 'Live' : ucfirst($currentMode) }}
                            </span>
                        </div>
                        <div class="d-block">

                            <a href="{{ route('configuration.get_gateway_data') }}"
                                class="btn btn-sm config_btn flex-shrink-0">
                                Change
                            </a>
                        </div>
                    </div>
                </div>

                <!-- System Notifications -->
                <div class="config-item">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div class="d-block">
                            <span class="config-label d-block">System Notifications</span>
                            <span class="config-value" id="systemNotificationsValue">
                                {{ $systemNotificationsUnread }} / {{ $systemNotificationsTotal }} Active
                            </span>
                        </div>
                        <div class="d-block">
                            <a href="{{ route('Notification.Settings') }}"
                                class="btn btn-sm config_btn flex-shrink-0">
                                View
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Email Notifications -->
                <div class="config-item">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div class="d-block">
                            <span class="config-label d-block">Email Notifications</span>
                            <span class="config-value" id="emailNotificationsValue">
                                {{ $emailNotificationsUnread }} / {{ $emailNotificationsTotal }} Active
                            </span>
                        </div>
                        <div class="d-block">
                            <a href="{{ route('NotificationEmail.Settings') }}"
                                class="btn btn-sm config_btn flex-shrink-0">
                                View
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row db-main-row">
        {{-- LEFT COLUMN --}}
        <div class="col-lg-7 mobile_padding_unset">

            {{-- Everyone's Tasks --}}
            <div class="db-card mobile_config_div_1 mobile_mb">
                <div class="db-card-header" style="align-items:center; flex-wrap:nowrap; gap:.3rem;">
                    <p class="db-card-title mb-0" style="white-space:nowrap;">Everyone's Tasks</p>
                    <div class="task-filter-pills" id="taskFilterPills">
                        <button class="task-filter-pill all active" data-filter="all">All</button>
                        <button class="task-filter-pill overdue" data-filter="overdue">Overdue</button>
                        <button class="task-filter-pill pending" data-filter="pending">Pending</button>
                        <button class="task-filter-pill complete" data-filter="complete">Complete</button>
                    </div>
                    <div style="flex:1;"></div>
                    <div class="dashboard-task-filter" style="flex-shrink:0;">
                        <div class="custom-select-wrap" id="customSelectWrap">
                            <svg class="custom-select-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            <span class="custom-select-display" id="customSelectDisplay">All Asignees</span>
                            <svg class="custom-select-arrow" id="customSelectArrow" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                            <select id="dashboardTaskAssigneeFilter" style="display:none;">
                                <option value="">All Asignees</option>
                                @foreach($activeUsers as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <div class="custom-select-dropdown" id="customSelectDropdown">
                                <div class="custom-select-option active" data-value="">All Asignees</div>
                                @foreach($activeUsers as $user)
                                <div class="custom-select-option" data-value="{{ $user->id }}">{{ $user->name }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="db-card-body p-0">
                    <div class="dashboard-task-list" id="dashboardTasksBody">
                        <div class="dashboard-task-empty text-center py-4">Loading tasks...</div>
                    </div>
                </div>
            </div>

            {{-- 24/7 Customer Enquiries --}}
            <div class="db-card mobile_config_div_1 mobile_mb">
                <div class="db-card-header">
                    <p class="db-card-title mb-0">24/7 Customer Enquiries</p>
                    <div class="d-flex align-items-center gap-2">
                        <div class="enq-date-chip" style="position:relative; cursor:pointer;">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="18" rx="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                            <span id="enqDateLabel" style="text-decoration:underline dotted;" title="Click to change date">
                                Loading...
                            </span>
                            <input type="date" id="enqDateInput" style="position:absolute; top:0; left:0; width:100%; height:100%; opacity:0; cursor:pointer; z-index:10;">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </div>
                        <button type="button" id="enqDateClear" class="btn btn-sm btn-outline-secondary">Clear</button>
                        <button type="button" id="enqDateToday" class="btn btn-sm btn-outline-primary">Today</button>
                    </div>
                </div>
                <div class="db-card-body">
                    <div class="enq-tabs" id="enqTabs"></div>
                    <div id="enquiryContainer">
                        <div class="text-center py-4 text-muted" style="font-size:.88rem;">Loading enquiries...</div>
                    </div>
                </div>
            </div>

            {{-- Orders in Production --}}
            <div class="db-card mobile_config_div_1 mobile_mb">
                <div class="db-card-header mobile_orders_header">
                    <p class="db-card-title mb-0">Orders in Production</p>
                    <a href="{{ url('/orders') }}" class="font-weight-bold text-primary" style="font-size:.85rem;">VIEW ALL</a>
                </div>
                <div class="db-card-body p-0">
                    <div class="table-responsive">
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>ORDER ID <span class="sort-icon">⇅</span></th>
                                    <th>FACTORIES <span class="sort-icon">⇅</span></th>
                                    <th>EX-FACTORY DATE <span class="sort-icon">⇅</span></th>
                                    <th>SALES REP <span class="sort-icon">⇅</span></th>
                                </tr>
                            </thead>
                            <tbody id="ordersBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN --}}
        <div class="col-lg-5 mobile_padding_unset">

            {{-- Leave Calendar --}}
            <div class="db-card mobile_config_div_1 mobile_mb">
                <div class="db-card-header mobile_orders_header">
                    <p class="db-card-title mb-0">Leave Calendar</p>
                    <div class="d-flex align-items-center" style="gap:.5rem;">
                        <button id="calPrev" class="btn btn-sm btn-outline-secondary">&lt;</button>
                        <span id="calTitle" style="font-weight:700; font-size:.9rem;"></span>
                        <button id="calNext" class="btn btn-sm btn-outline-secondary">&gt;</button>
                    </div>
                </div>
                <div class="db-card-body">
                    <div class="cal-head" id="calHead"></div>
                    <div class="cal-grid" id="calGrid"></div>
                    <div class="cal-legend">
                        <span class="cal-legend-item">
                            <span class="cal-legend-dot" style="background:#E0F9D4;border:1.5px solid #55A630;"></span> Today
                        </span>
                        <span class="cal-legend-item">
                            <span class="cal-legend-dot" style="background:#DAF7F0;border:1px solid #47D6B6;"></span> On leave
                        </span>
                        <span class="cal-legend-item">
                            <span class="cal-legend-dot" style="background:#FFE6E8;border:1px solid #f9a8a8;"></span> Holidays
                        </span>
                        <span class="cal-legend-item">
                            <span class="cal-legend-dot" style="background:#FFF6F7;border:1px solid #f9a8a8;"></span> Weekend
                        </span>
                    </div>
                    <div class="leave-today-section">
                        <div class="leave-today-header" id="leaveTodayHeader">On Leave Today</div>
                        <div id="todayLeaveList" class="today-leave-list">
                            <div class="today-leave-empty">Loading leave data...</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Unread Emails --}}
            <div class="db-card mobile_config_div_1 mobile_mb">
                <div class="db-card-header">
                    <p class="db-card-title mb-0">Unread Emails</p>
                </div>
                <div class="db-card-body">
                    @if(session('azure_access_token') && session('azure_refresh_token'))
                    <table class="table align-items-center" id="email_dashboard_table" style="min-width: 50%; cursor: pointer;">
                        <tbody id="email_table_dashboard_salesRep">

                        </tbody>
                    </table>

                    <div id="emailContainer" style="width: 100%; text-align: center;"></div>
                    @else
                    <a href="{{ url('/callbackmail') }}" class="log_email">Please log in first to view your emails.</a>
                    @endif
                </div>
            </div>

            {{-- Upcoming Meetings & Events --}}
            <div class="db-card mobile_config_div_1 mobile_mb">
                <div class="db-card-header">
                    <p class="db-card-title mb-0">Upcoming Meetings &amp; Events</p>
                </div>
                <div class="db-card-body" id="meetingsContainer"></div>
            </div>

        </div>
    </div>

</div>

{{-- ── SysAdmin Leave Modal ── --}}
<div class="modal fade" id="sysAdmin_leave_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width:580px;">
        <div class="modal-content" style="border:none;border-radius:16px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.15);">

            <div class="modal-header" style="background:#1e293b;padding:14px 20px;border:none;position:relative;display:flex;align-items:center;justify-content:space-between;">
                <button type="button" class="close" data-dismiss="modal"
                    style="position:absolute;top:10px;right:14px;color:#fff !important;opacity:0.7;margin:0;padding:0;background:none;border:none;font-size:1.4rem;line-height:1;z-index:10;">
                    <span style="color:#fff !important;">&times;</span>
                </button>
                <div style="display:flex;align-items:center;gap:12px;">
                    <div id="sys_leave_modalAvatar" style="width:40px;height:40px;border-radius:50%;background:#334155;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:600;color:#94a3b8;flex-shrink:0;">??</div>
                    <div style="min-width:0;">
                        <span style="font-size:14px;font-weight:600;color:#f1f5f9;" id="sys_reqname">-</span>
                        <div style="font-size:11px;color:#64748b;margin-top:4px;">Leave Details</div>
                    </div>
                </div>
                <div style="display:flex;flex-direction:column;align-items:flex-end;gap:4px;padding-right:28px;">
                    <div id="sys_leaveBalancePills" style="display:flex;flex-wrap:wrap;gap:5px;align-items:center;justify-content:flex-end;">
                        <span style="font-size:11px;color:#64748b;">Loading...</span>
                    </div>
                </div>
            </div>

            <div class="modal-body" style="padding:22px 24px;background:#fff;">

                <div style="font-size:11px;font-weight:600;color:#94a3b8;letter-spacing:.06em;text-transform:uppercase;margin-bottom:10px;">Employee details</div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:18px;">
                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:10px 14px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;">Employee name</div>
                        <div style="font-size:13px;font-weight:600;color:#1e293b;" id="sys_employee_name">-</div>
                    </div>
                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:10px 14px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;">Employment status</div>
                        <div style="font-size:13px;font-weight:600;" id="sys_employee_status">-</div>
                    </div>
                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:10px 14px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;">Request title</div>
                        <div style="font-size:13px;font-weight:600;color:#1e293b;" id="sys_requestTitle">-</div>
                    </div>
                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:10px 14px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;">Leave category</div>
                        <div style="font-size:13px;font-weight:600;color:#1e293b;" id="sys_leaveCategory">-</div>
                    </div>
                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:10px 14px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;">Leave type</div>
                        <div style="font-size:13px;font-weight:600;color:#1e293b;" id="sys_leaveTypeLabel">-</div>
                    </div>
                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:10px 14px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;">Day type</div>
                        <div style="font-size:13px;font-weight:600;color:#1e293b;" id="sys_dayTypeLabel">-</div>
                    </div>
                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:10px 14px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;">Total leave days</div>
                        <div style="font-size:13px;font-weight:600;color:#1e293b;" id="sys_total_leave_days">-</div>
                    </div>
                </div>

                <div style="font-size:11px;font-weight:600;color:#94a3b8;letter-spacing:.06em;text-transform:uppercase;margin-bottom:10px;">Reason for leave</div>
                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:12px 14px;font-size:13px;color:#475569;line-height:1.6;margin-bottom:18px;" id="sys_leaveReason">-</div>

            </div>

            <div class="modal-footer" style="padding:14px 24px;border-top:1px solid #e2e8f0;background:#fff;display:flex;align-items:center;justify-content:flex-end;">
                <button type="button" class="btn" data-dismiss="modal" style="background:#f1f5f9;color:#475569;border:none;border-radius:8px;padding:8px 18px;font-size:13px;font-weight:500;">Close</button>
            </div>

        </div>
    </div>
</div>

<script>
    var APP_BASE_URL = "{{ url('/') }}";

    function strContains(haystack, needle) {
        return (haystack || '').toLowerCase().indexOf(needle) >= 0;
    }

    function getInitials(name) {
        var words = (name || '').split(' ');
        var result = '';
        for (var i = 0; i < words.length && i < 2; i++) {
            if (words[i].length > 0) {
                result += words[i].charAt(0).toUpperCase();
            }
        }
        return result;
    }

    var AVATAR_COLORS = [{
            bg: '#dbeafe',
            fg: '#1e40af'
        },
        {
            bg: '#d1fae5',
            fg: '#065f46'
        },
        {
            bg: '#fef3c7',
            fg: '#92400e'
        },
        {
            bg: '#f3e8ff',
            fg: '#6b21a8'
        }
    ];

    function avatarColor(name) {
        var code = (name || ' ').charCodeAt(0);
        return AVATAR_COLORS[code % AVATAR_COLORS.length];
    }

    function buildAvatar(u, size) {
        var name = u.name || '-';
        var c = avatarColor(name);
        var ini = getInitials(name);
        var sz = size || 40;
        var fs = Math.round(sz * 0.35) + 'px';

        var raw = u.profile_photo_url || u.profile_photo || u.avatar ||
            u.image || u.profile_pic || u.photo || '';

        if (raw && raw.indexOf('http') < 0 && raw.indexOf('data:') < 0) {
            raw = APP_BASE_URL + '/' + raw.replace(/^\/+/, '');
        }

        if (!raw) {
            return '<div style="' +
                'width:' + sz + 'px;height:' + sz + 'px;border-radius:50%;' +
                'background:' + c.bg + ';color:' + c.fg + ';' +
                'display:flex;align-items:center;justify-content:center;' +
                'font-size:' + fs + ';font-weight:700;flex-shrink:0;line-height:1;">' +
                ini + '</div>';
        }

        var html = '';
        html += '<div style="width:' + sz + 'px;height:' + sz + 'px;border-radius:50%;';
        html += 'flex-shrink:0;position:relative;overflow:hidden;">';

        html += '<div style="position:absolute;top:0;left:0;';
        html += 'width:' + sz + 'px;height:' + sz + 'px;border-radius:50%;';
        html += 'background:' + c.bg + ';color:' + c.fg + ';';
        html += 'display:flex;align-items:center;justify-content:center;';
        html += 'font-size:' + fs + ';font-weight:700;line-height:1;">' + ini + '</div>';

        html += '<img src="' + raw + '" alt="' + name + '"';
        html += ' style="position:absolute;top:0;left:0;';
        html += 'width:' + sz + 'px;height:' + sz + 'px;';
        html += 'border-radius:50%;object-fit:cover;"';
        html += ' onerror="this.style.display=\'none\';">';

        html += '</div>';
        return html;
    }

    window.openSystemAdminLeaveModal = function(leaveId, encodedUser) {
        // Reset modal fields to loading state
        $('#sys_reqname').text('Loading...');
        $('#sys_employee_name').text('Loading...');
        $('#sys_employee_status').text('-');
        $('#sys_requestTitle').text('-');
        $('#sys_leaveCategory').text('-');
        $('#sys_leaveTypeLabel').text('-');
        $('#sys_dayTypeLabel').text('-');
        $('#sys_total_leave_days').text('-');
        $('#sys_leaveReason').text('-');

        let u = {};
        try {
            u = JSON.parse(decodeURIComponent(encodedUser));
        } catch (e) {}

        $('#sys_leave_modalAvatar').html(buildAvatar(u, 44));

        $('#sysAdmin_leave_modal').modal('show');

        $.get("{{ url('/leave-Manage/getLeaveRequestDetails') }}", {
            leave_id: leaveId
        }, function(r) {
            if (!r.success) {
                console.error(r.message);
                return;
            }

            $('#sys_reqname').text(r.leave.employee_name || '-');
            $('#sys_employee_name').text(r.leave.employee_name || '-');

            var empStatus = r.leave.employee_status || '-';
            $('#sys_employee_status').css('color', empStatus == 'Active' ? '#059669' : '#dc2626').text(empStatus);

            $('#sys_requestTitle').text(
                r.leave.request_title ?
                r.leave.request_title.charAt(0).toUpperCase() + r.leave.request_title.slice(1).toLowerCase() :
                '-'
            );
            $('#sys_leaveCategory').text(
                r.leave.leave_category ?
                r.leave.leave_category.charAt(0).toUpperCase() + r.leave.leave_category.slice(1).toLowerCase() :
                '-'
            );
            $('#sys_leaveTypeLabel').text(r.leave.leave_type || '-');
            $('#sys_dayTypeLabel').text(r.leave.day_type_label || '-');
            $('#sys_total_leave_days').text(r.leave.total_leave_days || '-');
            $('#sys_leaveReason').text(r.leave.leave_reason || '-');

            // Fetch leave balance for this employee
            // var DOT_COLORS = ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899', '#06b6d4', '#f97316'];
            $.get("{{ url('/leave-Manage/getLeaveBalance') }}/" + r.leave.user_id, function(bal) {
                if (bal && bal.success && bal.balances && bal.balances.length > 0) {
                    var pillsHtml = '<div style="font-weight:400; font-size:12px; color:#fcfcfc;">Remaining: </div>';
                    for (var i = 0; i < bal.balances.length; i++) {
                        var it = bal.balances[i];
                        // var dotColor = DOT_COLORS[i % DOT_COLORS.length];
                        pillsHtml += '<div style="display:inline-flex; align-items:center; gap:4px; padding:4px 8px; border-radius:50px; border:1px solid #334155; background:#343E4E;">';
                        pillsHtml += '<span style="font-size:12px; font-weight:400; color:#fcfcfc; line-height:1;">' + (it.leave_type_name || 'Leave') + '</span>';
                        pillsHtml += '<span style="font-size:12px; font-weight:400; color:#fcfcfc; line-height:1;">' + it.remaining + '</span>';
                        pillsHtml += '</div>';
                    }
                    $('#sys_leaveBalancePills').html(pillsHtml);
                } else {
                    $('#sys_leaveBalancePills').html('<span style="font-size:12px;color:#94a3b8;padding:6px 0;">No balance data</span>');
                }
            }).fail(function() {
                $('#sys_leaveBalancePills').html('<span style="font-size:12px;color:#94a3b8;padding:6px 0;">Could not load balances</span>');
            });

        }).fail(function() {
            console.error('Error fetching leave request details.');
        });
    };

    document.addEventListener('DOMContentLoaded', function() {

        /* ── ENQUIRIES ── */
        const ENQ_CATEGORY_META = [{
                key: 'new',
                label: 'Latest Enquiries',
                cls: 'bp-outline-red'
            },
            {
                key: 'technical',
                label: 'Technical',
                cls: 'bp-outline-blue'
            },
            {
                key: 'sales',
                label: 'Sales',
                cls: 'bp-outline-blue'
            },
            {
                key: 'account',
                label: 'Account',
                cls: 'bp-outline-blue'
            },
        ];

        let ordersRawData = []; // cache for client-side sorting
        let ordersSortCol = null;
        let ordersSortDir = 1; // 1 = asc, -1 = desc
        let enqActiveCategory = 'new';
        let enqAllRows = []; // full fetched list, cached for tab switching

        function formatEnqDate(dateObj) {
            const months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
            return dateObj.getDate() + ' ' + months[dateObj.getMonth()] + ' ' + dateObj.getFullYear();
        }

        function toYmd(dateObj) {
            const y = dateObj.getFullYear();
            const m = String(dateObj.getMonth() + 1).padStart(2, '0');
            const d = String(dateObj.getDate()).padStart(2, '0');
            return `${y}-${m}-${d}`;
        }

        // Init date input to empty (All Dates)
        const enqDateInput = document.getElementById('enqDateInput');
        const enqDateLabel = document.getElementById('enqDateLabel');
        const enqDateClear = document.getElementById('enqDateClear');
        const enqDateToday = document.getElementById('enqDateToday');
        enqDateInput.value = '';
        enqDateLabel.textContent = 'All';

        function updateEnqDate(dateValue) {
            if (!dateValue) {
                enqDateInput.value = '';
                enqDateLabel.textContent = 'All';
                if (enqAllRowsUnfiltered.length > 0) {
                    applyEnqDateFilter('');
                } else {
                    fetchEnquiries('');
                }
            } else {
                enqDateInput.value = dateValue;
                const picked = new Date(dateValue + 'T00:00:00');
                enqDateLabel.textContent = formatEnqDate(picked);
                if (enqAllRowsUnfiltered.length > 0) {
                    applyEnqDateFilter(dateValue);
                } else {
                    fetchEnquiries(dateValue);
                }
            }
        }

        enqDateInput.addEventListener('change', function() {
            updateEnqDate(this.value);
        });

        enqDateClear.addEventListener('click', function() {
            updateEnqDate('');
        });

        enqDateToday.addEventListener('click', function() {
            const today = new Date();
            const todayYmd = toYmd(today);
            updateEnqDate(todayYmd);
        });

        function renderEnqTabs(counts) {
            const c = document.getElementById('enqTabs');
            c.innerHTML = ENQ_CATEGORY_META.map(tab => {
                const count = counts[tab.key] ?? 0;
                const isActive = tab.key === enqActiveCategory;
                return `
                    <button class="enq-tab ${isActive ? 'active' : ''}" type="button"
                        data-cat="${tab.key}" onclick="switchEnqTab(this)">
                        <span class="enq-tab-text">${tab.label}</span>
                        <span class="bp ${tab.cls}" style="border-radius: 4px; padding: 0.35rem 0.65rem; font-size: 0.85rem; font-weight: 700; margin-right: 0.5rem;  margin-left: 0.2rem;  display: inline-flex; align-items: center; justify-content: center; min-width: 26px; height: 26px;">${count}</span>
                    </button>`;
            }).join('');
        }

        const ENQ_COLORS = ['#818cf8', '#10b981', '#f97316', '#0ea5e9', '#a78bfa', '#ef4444', '#eab308'];

        function renderEnquiryRows(rows) {
            const c = document.getElementById('enquiryContainer');
            let filtered = enqActiveCategory === 'new' ?
                rows :
                rows.filter(r => r.type === enqActiveCategory);

            // Limit to latest 10
            filtered = filtered.slice(0, 10);

            if (!filtered.length) {
                const dateText = enqDateInput.value ? ' for this date' : '';
                c.innerHTML = `<div class="text-center py-4" style="color:#6b7280;font-size:.88rem;">
            No ${enqActiveCategory} enquiries${dateText}.</div>`;
                return;
            }

            c.innerHTML = filtered.map(e => {
                const color = ENQ_COLORS[e.id % ENQ_COLORS.length];
                const isConv = e.source === 'conversation';
                const convUrl = "{{ url('/admin/support') }}";
                const rowClick = isConv ? `style="cursor:pointer;" onclick="window.open('${convUrl}', '_blank')"` : '';
                const convStatus = (e.conv_status || 'Active').toUpperCase();
                const statusStyle = convStatus === 'CLOSED' ? 'background:#F5F5F5;color:#717070;' : 'background:#E0F9D4;color:#55A630;';
                const statusTag = isConv ? `<span class="bp" style="padding:.18rem .5rem;font-size:.7rem;${statusStyle}">${convStatus}</span>` : '';
                return `
                    <div class="enq-row" ${rowClick}>
                        <div class="enq-body">
                            <div class="enq-top">
                                <span class="enq-name">${e.name}</span>
                                <div style="margin-left: auto; display: flex; align-items: center; gap: .5rem;">
                                    ${statusTag}
                                    <span>${e.time}</span>
                                </div>
                            </div>
                            <p class="enq-preview">${isConv ? '💬 ' : ''}${e.preview}</p>
                        </div>
                    </div>`;
            }).join('');
        }

        window.switchEnqTab = function(el) {
            document.querySelectorAll('.enq-tab').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
            enqActiveCategory = el.dataset.cat;
            renderEnquiryRows(enqAllRows);
        };

        let enqAllRowsUnfiltered = []; // full list before date filter

        function fetchEnquiries(dateYmd) {
            const container = document.getElementById('enquiryContainer');
            container.innerHTML = `<div class="text-center py-4 text-muted" style="font-size:.88rem;">Loading...</div>`;

            $.get("{{ route('admin.support.sidebar-list') }}", function(data) {
                if (!data.status) {
                    container.innerHTML = `<div class="text-center py-4" style="color:#dc2626;font-size:.88rem;">Failed to load enquiries.</div>`;
                    return;
                }

                const conversations = data.conversations || [];

                // Map sidebarList response to dashboard enquiry format
                const DEPT_TYPE_MAP = {
                    'Technical Support': 'technical',
                    'Sales Support': 'sales',
                    'Account Support': 'account',
                };

                const MONTH_NAMES = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                let mapped = conversations.map(function(conv, idx) {
                    const customerName = conv.customer_name || 'Customer';
                    const nameWords = customerName.split(' ');
                    let initials = '';
                    for (let i = 0; i < nameWords.length && i < 2; i++) {
                        if (nameWords[i].length > 0) {
                            initials += nameWords[i].charAt(0).toUpperCase();
                        }
                    }
                    if (!initials) initials = 'CU';

                    const deptName = conv.department_name || 'Support';
                    const type = DEPT_TYPE_MAP[deptName] || 'new';

                    // Format date for display (e.g. "Jun 19")
                    let displayDate = '';
                    const rawDate = conv.last_message_date || ''; // YYYY-MM-DD
                    if (rawDate) {
                        const parts = rawDate.split('-');
                        if (parts.length === 3) {
                            const monthIdx = parseInt(parts[1], 10) - 1;
                            const day = parseInt(parts[2], 10);
                            displayDate = MONTH_NAMES[monthIdx] + ' ' + day;
                        }
                    }

                    return {
                        id: 'conv_' + conv.id,
                        initials: initials,
                        name: customerName,
                        count: 1,
                        time: displayDate,
                        date: rawDate, // YYYY-MM-DD for filtering
                        preview: conv.last_message || 'No messages yet',
                        type: type,
                        source: 'conversation',
                        conv_status: conv.status || 'Active',
                        agent: conv.assigned_agent_name || null,
                        department: deptName,
                        conv_id: conv.id,
                        unread_count: conv.unread_count || 0,
                        timestamp: idx,
                    };
                });

                // Store full unfiltered list
                enqAllRowsUnfiltered = mapped;

                // Apply date filter if provided
                applyEnqDateFilter(dateYmd);
            }).fail(function(xhr) {
                container.innerHTML = `<div class="text-center py-4" style="color:#dc2626;font-size:.88rem;">
            Error ${xhr.status}: Unable to load enquiries.</div>`;
                console.error('Enquiries fetch failed:', xhr.status, xhr.responseText);
            });
        }

        function applyEnqDateFilter(dateYmd) {
            let filtered = enqAllRowsUnfiltered;

            // Filter by date if a date is selected
            if (dateYmd) {
                filtered = filtered.filter(function(row) {
                    return row.date === dateYmd;
                });
            }

            enqAllRows = filtered;

            // Build counts from filtered data
            const counts = {
                new: 0,
                technical: 0,
                sales: 0,
                account: 0
            };
            filtered.forEach(function(row) {
                if (counts[row.type] !== undefined) {
                    counts[row.type] += (row.unread_count || 0);
                }
                // 'new' tab shows total unread across all
                counts['new'] += (row.unread_count || 0);
            });

            renderEnqTabs(counts);
            renderEnquiryRows(enqAllRows);
        }

        // Initial load
        fetchEnquiries('');

        /* ── ORDERS IN PRODUCTION ── */
        function fetchOrdersInProduction() {
            const tbody = document.getElementById('ordersBody');
            if (!tbody) return;
            tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4 text-muted" style="font-size:.88rem;">Loading...</td></tr>';

            $.get("{{ route('superadmin.orders-production.data') }}", function(data) {
                if (data.status !== 200) {
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4" style="color:#dc2626;font-size:.88rem;">Failed to load orders.</td></tr>';
                    return;
                }
                renderOrdersInProduction(data.orders || []);
            }).fail(function(xhr) {
                tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4" style="color:#dc2626;font-size:.88rem;">Error ' + xhr.status + ': Unable to load orders.</td></tr>';
                console.error('Orders fetch failed:', xhr.status, xhr.responseText);
            });
        }

        function renderOrdersInProduction(orders) {
            const tbody = document.getElementById('ordersBody');
            if (!tbody) return;

            ordersRawData = orders; // ← cache for sorting

            if (!orders.length) {
                tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4" style="color:#6b7280;font-size:.88rem;">No orders in production.</td></tr>';
                wireOrderSortHeaders(); // still wire up headers even when empty
                return;
            }

            paintOrderRows(orders);
            wireOrderSortHeaders();
        }

        function paintOrderRows(orders) {
            const tbody = document.getElementById('ordersBody');
            if (!tbody) return;

            const isMobile = window.innerWidth <= 768;

            if (isMobile) {

                tbody.innerHTML = orders.map(order => `
                    <tr class="mobile-order-card">
                        <td colspan="4">
                            <div class="mobile-order-wrapper">

                                <div class="mobile-order-header">
                                    <span class="mobile-label">ORDER</span>

                                    <a target="_blank"
                                    href="/order_details/edit/${order.id}/order?active_tab=order"
                                    class="mobile-order-id">
                                        ${order.order_id}
                                    </a>
                                </div>

                                <div class="mobile-order-middle">
                                    <div class="mobile-date">
                                        <span class="mobile-label">
                                            EX-FACTORY DATE:
                                        </span>
                                        <span class="mobile_gray_text">${order.ex_factory_date}</span>
                                    </div>

                                    <div class="mobile-factory">
                                        ${order.factories}
                                    </div>
                                </div>

                                <div class="mobile-order-footer">
                                    <span class="mobile-label">
                                        SALES REP:
                                    </span>

                                    <span class="mobile_gray_text">${order.sales_rep}</span>
                                </div>

                            </div>
                        </td>
                    </tr>
                `).join('');

            } else {

                tbody.innerHTML = orders.map(order => `
                    <tr>
                        <td>
                            <a target="_blank"
                            href="/order_details/edit/${order.id}/order?active_tab=order"
                            style="text-decoration:none;color:#2563eb;font-weight:500;">
                                ${order.order_id}
                            </a>
                        </td>
                        <td>${order.factories}</td>
                        <td>${order.ex_factory_date}</td>
                        <td>${order.sales_rep}</td>
                    </tr>
                `).join('');
            }
        }

        function wireOrderSortHeaders() {
            // cols: 0=order_id, 1=factories, 2=ex_factory_date, 3=sales_rep
            const TABLE_COLS = ['order_id', 'factories', 'ex_factory_date', 'sales_rep'];

            document.querySelectorAll('.orders-table thead th').forEach(function(th, idx) {
                th.style.cursor = 'pointer';
                th.style.userSelect = 'none';

                // Remove old listener by replacing node (safe — no child event listeners)
                const fresh = th.cloneNode(true);
                th.parentNode.replaceChild(fresh, th);

                fresh.addEventListener('click', function() {
                    const col = TABLE_COLS[idx];

                    if (ordersSortCol === col) {
                        ordersSortDir *= -1; // flip direction
                    } else {
                        ordersSortCol = col;
                        ordersSortDir = 1; // reset to asc on new column
                    }

                    // Update ⇅ icon on all headers
                    document.querySelectorAll('.orders-table thead th .sort-icon').forEach(function(icon, i) {
                        if (i === idx) {
                            icon.textContent = ordersSortDir === 1 ? '↑' : '↓';
                            icon.style.opacity = '1';
                        } else {
                            icon.textContent = '⇅';
                            icon.style.opacity = '.5';
                        }
                    });

                    const sorted = ordersRawData.slice().sort(function(a, b) {
                        let va = a[col] || '';
                        let vb = b[col] || '';

                        // Numeric sort for order_id — strip any leading letters (e.g. TSR001705 → 1705)
                        if (col === 'order_id') {
                            const extractNum = s => parseInt((s || '').replace(/^[A-Za-z]+/, ''), 10) || 0;
                            va = extractNum(va);
                            vb = extractNum(vb);
                            return (va - vb) * ordersSortDir;
                        }

                        // Date sort for ex_factory_date
                        if (col === 'ex_factory_date') {
                            const parseDate = function(s) {
                                if (!s) return 0;
                                s = s.trim();
                                // YYYY-MM-DD
                                if (/^\d{4}-\d{2}-\d{2}$/.test(s)) {
                                    return new Date(s + 'T00:00:00').getTime();
                                }
                                // MM/DD/YYYY or DD/MM/YYYY — detect by value range
                                if (/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(s)) {
                                    const p = s.split('/');
                                    const a = parseInt(p[0], 10);
                                    const b = parseInt(p[1], 10);
                                    const y = parseInt(p[2], 10);
                                    // If first segment > 12, it must be DD (so format is DD/MM/YYYY)
                                    // If second segment > 12, it must be DD (so format is MM/DD/YYYY)
                                    // Otherwise default to MM/DD/YYYY (typical on US-locale servers like A2)
                                    if (a > 12) {
                                        return new Date(y, b - 1, a).getTime(); // DD/MM/YYYY
                                    }
                                    return new Date(y, a - 1, b).getTime(); // MM/DD/YYYY
                                }
                                // Fallback for "Feb 23 2025" style strings
                                const t = Date.parse(s);
                                return isNaN(t) ? 0 : t;
                            };
                            return (parseDate(va) - parseDate(vb)) * ordersSortDir;
                        }

                        // Default: case-insensitive string sort
                        return va.toString().toLowerCase().localeCompare(
                            vb.toString().toLowerCase()
                        ) * ordersSortDir;
                    });

                    paintOrderRows(sorted);
                });
            });
        }

        // Initial load for orders
        fetchOrdersInProduction();




        const MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        const DAYS = ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'];
        // Sample leave data: key = "YYYY-M-D", value = {text, cls}
        const LEAVES = {
            '2026-4-3': {
                text: '2 on leave',
                cls: 'orange'
            },
            '2026-4-18': {
                text: '4 on leave',
                cls: 'teal'
            },
            '2026-4-24': {
                text: '4 on leave',
                cls: 'orange'
            },
        };

        const currentDate = new Date();
        currentDate.setHours(0, 0, 0, 0);
        let calYear = currentDate.getFullYear(),
            calMonth = currentDate.getMonth();

        function padTwo(num) {
            return num < 10 ? '0' + num : String(num);
        }

        function safeMdyToIso(str) {
            if (!str || str.trim() === '') return null;
            const parts = str.split('/');
            if (parts.length !== 3) return null;
            return parts[2] + '-' + padTwo(+parts[0]) + '-' + padTwo(+parts[1]);
        }

        function safeParseDate(str) {
            if (!str || str.trim() === '') return null;
            const parts = str.split('/');
            if (parts.length !== 3) return null;
            return new Date(+parts[2], +parts[0] - 1, +parts[1]);
        }

        let leaveData = [];
        let selectedLeaveDate = new Date();
        selectedLeaveDate.setHours(0, 0, 0, 0);

        function formatDateLabel(d) {
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            if (d.toDateString() === today.toDateString()) return 'On Leave Today';
            return 'On Leave ' + months[d.getMonth()] + ' ' + d.getDate();
        }

        function renderTodayLeaveList(data, forDate) {
            const listEl = document.getElementById('todayLeaveList');
            if (!listEl) return;

            const targetDate = forDate || selectedLeaveDate;
            const headerEl = document.getElementById('leaveTodayHeader');
            if (headerEl) headerEl.textContent = formatDateLabel(targetDate);

            const todayLeaves = [];
            if (Array.isArray(data)) {
                data.forEach(function(item) {
                    if (item.status != 1) return;

                    if (item.type == 4) {
                        const coverDate = safeParseDate(item.covering_leave_date);
                        if (coverDate && coverDate.toDateString() === targetDate.toDateString()) {
                            todayLeaves.push(item);
                        }
                        return;
                    }

                    const startDate = safeParseDate(item.start_date);
                    if (!startDate) return;
                    const endDate = item.end_date && item.end_date.trim() !== '' ? safeParseDate(item.end_date) : startDate;
                    if (!endDate) return;

                    const sTime = startDate.setHours(0, 0, 0, 0);
                    const eTime = endDate.setHours(0, 0, 0, 0);
                    const tTime = new Date(targetDate).setHours(0, 0, 0, 0);
                    if (sTime <= tTime && eTime >= tTime) {
                        todayLeaves.push(item);
                    }
                });
            }

            if (todayLeaves.length === 0) {
                const isToday = targetDate.toDateString() === new Date().toDateString();
                listEl.innerHTML =
                    '<div class="text-center py-4">' +
                    '<div style="font-size:36px;">&#127881;</div>' +
                    '<div style="font-size:13px;font-weight:600;color:#111827;margin:6px 0 4px;">' + (isToday ? 'No leaves today' : 'No leaves on this day') + '</div>' +
                    '<div style="font-size:12px;color:#9ca3af;">' + (isToday ? 'Everyone is in today!' : 'No one on leave this day.') + '</div>' +
                    '</div>';
                return;
            }

            let html = '';
            todayLeaves.forEach(function(item) {
                const name = (item.user_details && item.user_details.name) ? item.user_details.name : 'Employee';
                const type = item.type == 4 ? 'Covering Day' : (item.leave_type || 'Leave');
                const u = item.user_details || {};
                const avatarHtml = buildAvatar(u, 26);

                let encodedUser = '';
                try {
                    encodedUser = encodeURIComponent(JSON.stringify(u));
                } catch (e) {}

                html += '<div class="today-leave-row" style="cursor:pointer; border-radius:6px; padding-left:4px; padding-right:4px;" onmouseover="this.style.backgroundColor=\'#f8fafc\'" onmouseout="this.style.backgroundColor=\'\'" onclick="openSystemAdminLeaveModal(' + item.id + ', \'' + encodedUser + '\')" title="Click to view details">';
                html += '<div style="display:flex; align-items:center;">';
                html += avatarHtml;
                html += '<div class="today-leave-name" style="margin-left: 8px;">' + name + '</div>';
                html += '</div>';
                html += '<div class="today-leave-type">' + type + '</div>';
                html += '</div>';
            });
            const label = targetDate === selectedLeaveDate && targetDate.toDateString() === new Date().toDateString() ? 'today' : 'on this day';
            html += '<div class="leave-today-footer">' + todayLeaves.length + ' employee' + (todayLeaves.length === 1 ? '' : 's') + ' on leave</div>';
            listEl.innerHTML = html;
        }

        function setLeaveEntry(date, cls) {
            const key = `${date.getFullYear()}-${date.getMonth()}-${date.getDate()}`;
            if (!LEAVES[key]) {
                LEAVES[key] = {
                    text: '1 on leave',
                    cls: cls
                };
                return;
            }
            const currentCount = parseInt(LEAVES[key].text, 10) || 0;
            LEAVES[key].text = `${currentCount + 1} on leave`;
            LEAVES[key].cls = cls;
        }

        function loadLeaveCalendarData() {
            return $.get("{{ url('/leave-Manage/getrequests') }}", function(data) {
                Object.keys(LEAVES).forEach(k => delete LEAVES[k]);

                if (!Array.isArray(data)) {
                    renderTodayLeaveList([]);
                    return;
                }

                data.forEach(function(item) {
                    if (item.status != 1) return;

                    if (item.type == 4) {
                        const coverIso = safeMdyToIso(item.covering_leave_date);
                        if (coverIso) {
                            const date = new Date(coverIso);
                            if (!isNaN(date)) {
                                setLeaveEntry(date, 'teal');
                            }
                        }
                        return;
                    }

                    const startIso = safeMdyToIso(item.start_date);
                    if (!startIso) return;
                    const endIso = item.end_date && item.end_date.trim() !== '' ? safeMdyToIso(item.end_date) : startIso;
                    if (!endIso) return;

                    let cur = new Date(startIso);
                    const endDate = new Date(endIso);
                    while (cur <= endDate) {
                        setLeaveEntry(cur, 'orange');
                        cur.setDate(cur.getDate() + 1);
                    }
                });

                leaveData = data;
                renderTodayLeaveList(data, selectedLeaveDate);
            }).fail(function() {
                console.warn('Failed to load leave calendar data, using sample values.');
                renderTodayLeaveList([]);
            });
        }

        /* ── TASK LIST ── */
        const TASKS_API = "{{ url('projects/get_my_all_tasks') }}";
        const DASHBOARD_TASKS_FETCH_LIMIT = 50;

        let dashboardTaskItems = [];
        let dashboardTaskStatusFilter = 'all';

        function normalizeDashboardTaskRows(data) {
            const wrapper = document.createElement('tbody');
            wrapper.innerHTML = data;
            const rows = Array.from(wrapper.querySelectorAll('tr'));
            if (!rows.length) return [];

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            return rows.map(function(row) { // ← no .slice() cap here
                /* ── task name ── */
                const taskInput = row.querySelector('input.my-task-title');
                const taskName = taskInput ?
                    taskInput.value.trim() :
                    (row.cells[0]?.textContent.trim() || 'Untitled task');

                /* ── status detection ── */
                const checkbox = row.querySelector('input[type="checkbox"]');
                const dueInput = row.querySelector('input[type="date"]');

                let status = 'pending';

                if (checkbox && checkbox.checked) {
                    // Explicitly completed
                    status = 'complete';
                } else {
                    // Try every plausible status indicator in the row HTML
                    const rowHtml = row.innerHTML.toLowerCase();
                    const rowText = row.textContent.toLowerCase();

                    // 1. data-status attribute on the row or any child
                    const statusEl = row.querySelector('[data-status]');
                    if (statusEl) {
                        const ds = (statusEl.getAttribute('data-status') || '').toLowerCase();
                        if (ds === 'complete' || ds === 'completed' || ds === 'done') {
                            status = 'complete';
                        } else if (ds === 'overdue') {
                            status = 'overdue';
                        } else if (ds === 'pending' || ds === 'in-progress' || ds === 'inprogress') {
                            status = 'pending';
                        }
                    }

                    // 2. CSS classes on row or status badge elements
                    if (status === 'pending') {
                        const badgeEl = row.querySelector('.task-status, .status-badge, .badge, [class*="status"]');
                        if (badgeEl) {
                            const bc = badgeEl.className.toLowerCase() + ' ' + (badgeEl.textContent || '').toLowerCase();
                            if (bc.includes('complete') || bc.includes('done') || bc.includes('finished')) {
                                status = 'complete';
                            } else if (bc.includes('overdue')) {
                                status = 'overdue';
                            }
                        }
                    }

                    // 3. Row-level class (e.g. <tr class="task-overdue">)
                    if (status === 'pending') {
                        const rc = row.className.toLowerCase();
                        if (rc.includes('complete') || rc.includes('done')) {
                            status = 'complete';
                        } else if (rc.includes('overdue')) {
                            status = 'overdue';
                        }
                    }

                    // 4. Fall back to due-date arithmetic (only if status is still undecided)
                    if (status === 'pending' && dueInput && dueInput.value) {
                        const dueDate = new Date(dueInput.value);
                        dueDate.setHours(0, 0, 0, 0);
                        if (!isNaN(dueDate) && dueDate < today) {
                            status = 'overdue';
                        }
                    }
                }

                /* ── project URL ── */
                const linkEl = row.querySelector('a');
                let projectUrl = linkEl ? linkEl.href : '#';

                const chatboxTd = row.querySelector('.open-chatbox');
                if (chatboxTd && projectUrl !== '#') {
                    const taskId = chatboxTd.getAttribute('data-value');
                    // const sectionId = chatboxTd.getAttribute('data-section');
                    const discussionType = chatboxTd.getAttribute('data-discussion-type') || 'discussion';
                    if (taskId) {
                        const sep = projectUrl.includes('?') ? '&' : '?';
                        // projectUrl += sep + 'taskId=' + taskId;
                        // if (sectionId) projectUrl += '&sectionId=' + sectionId;
                        projectUrl += sep + 'open_target=true&type=' + encodeURIComponent(discussionType) + '&discussion_id=' + encodeURIComponent(taskId);
                    }
                }

                /* ── priority ── */
                const priorityEl = row.querySelector('.priority-indicator');
                let priorityClass = '',
                    priorityTitle = '';
                if (priorityEl) {
                    ['low', 'medium', 'high', 'critical'].forEach(function(p) {
                        if (priorityEl.classList.contains(p)) priorityClass = p;
                    });
                    priorityTitle = priorityEl.getAttribute('title') || '';
                }

                /* ── due date display string ── */
                let dueDateStr = '';
                if (dueInput && (dueInput.value || dueInput.getAttribute('value'))) {
                    dueDateStr = dueInput.value || dueInput.getAttribute('value');
                } else {
                    // Fallback: look for a visible date cell (td containing a date pattern)
                    const cells = Array.from(row.querySelectorAll('td'));
                    for (const td of cells) {
                        const txt = td.textContent.trim();
                        // Match YYYY-MM-DD, DD/MM/YYYY, DD Mon YYYY etc.
                        if (/\d{4}-\d{2}-\d{2}/.test(txt) || /\d{1,2}\/\d{1,2}\/\d{4}/.test(txt) || /\d{1,2}\s+\w{3}\s+\d{4}/.test(txt)) {
                            dueDateStr = txt;
                            break;
                        }
                    }
                }

                /* ── project name ── */
                let projectName = '';
                if (linkEl) {
                    const projectDiv = linkEl.querySelector('.d-flex.align-items-center > div');
                    projectName = projectDiv ? projectDiv.textContent.trim() : linkEl.textContent.trim();
                }

                return {
                    name: taskName,
                    status,
                    url: projectUrl,
                    priorityClass,
                    priorityTitle,
                    dueDateStr,
                    projectName
                };
            });
        }

        function renderTaskItems(items, filter) {
            const body = document.getElementById('dashboardTasksBody');
            const filtered = filter === 'all' ? items : items.filter(t => t.status === filter);

            // Count per status for debugging (visible in console)
            const counts = {
                all: items.length,
                overdue: 0,
                pending: 0,
                complete: 0
            };
            items.forEach(function(t) {
                if (counts[t.status] !== undefined) counts[t.status]++;
            });
            // console.log('[Tasks] status counts:', counts, '| active filter:', filter, '| showing:', filtered.length);

            if (!filtered.length) {
                const labels = {
                    all: 'No tasks found.',
                    overdue: 'No overdue tasks.',
                    pending: 'No pending tasks.',
                    complete: 'No completed tasks.'
                };
                body.innerHTML = `<div class="dashboard-task-empty text-center">${labels[filter] || 'No tasks found.'}</div>`;
                return;
            }

            // Show up to 10 in the list but filter across full pool
            const visible = filtered.slice(0, 10);

            body.innerHTML = visible.map(function(t) {
                let metaHtml = '';
                if (t.projectName) {
                    metaHtml = `<div class="dashboard-task-meta">
                <span style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"
                    title="${t.projectName}">${t.projectName}</span>
            </div>`;
                }

                let rightParts = [];
                if (t.priorityClass) {
                    rightParts.push(`<span class="dashboard-priority-dot ${t.priorityClass}" title="${t.priorityTitle}"></span>`);
                }
                rightParts.push(
                    t.dueDateStr ?
                    `<span class="dashboard-task-due">${t.dueDateStr}</span>` :
                    `<span class="dashboard-task-due" style="color:#d1d5db;">No due date</span>`
                );

                const rightHtml = rightParts.length ?
                    `<div class="dashboard-task-right">${rightParts.join('')}</div>` :
                    '';

                return `
        <a href="${t.url}" target="_blank" class="dashboard-task-item">
            <div class="dashboard-task-main" style="flex:1;min-width:0;">
                <div class="dashboard-task-name">${t.name}</div>
                ${metaHtml}
            </div>
            ${rightHtml}
        </a>`;
            }).join('');

            // Append a "showing X of Y" note when there are more
            // if (filtered.length > 10) {
            //     body.innerHTML += `<div class="dashboard-task-empty text-center" style="font-size:.75rem;">
            //     Showing 10 of ${filtered.length} — <a href="/projects" target="_blank">View all</a></div>`;
            // }
        }

        function fetchDashboardTasks() {
            const assignee = document.getElementById('dashboardTaskAssigneeFilter')?.value || '';
            const body = document.getElementById('dashboardTasksBody');
            body.innerHTML = '<div class="dashboard-task-empty text-center">Loading tasks...</div>';

            const serverTaskType = dashboardTaskStatusFilter === 'complete' ? 'completed' :
                (dashboardTaskStatusFilter === 'all' ? '' : dashboardTaskStatusFilter);

            $.get(TASKS_API, {
                per_page: DASHBOARD_TASKS_FETCH_LIMIT,
                assignee_id: assignee,
                task_type: serverTaskType
            }, function(data) {
                dashboardTaskItems = normalizeDashboardTaskRows(data);
                renderTaskItems(dashboardTaskItems, dashboardTaskStatusFilter);
            }).fail(function() {
                body.innerHTML = '<div class="dashboard-task-empty text-center">Unable to load tasks. Please refresh.</div>';
            });
        }

        // Wire up pill clicks
        document.getElementById('taskFilterPills').addEventListener('click', function(e) {
            const pill = e.target.closest('.task-filter-pill');
            if (!pill) return;
            document.querySelectorAll('.task-filter-pill').forEach(p => p.classList.remove('active'));
            pill.classList.add('active');
            dashboardTaskStatusFilter = pill.dataset.filter;
            fetchDashboardTasks();
        });


        /* ── FETCH AND RENDER ORDERS ── */
        function fetchOrders() {
            const container = document.getElementById('ordersBody');
            container.innerHTML = `<div class="text-center py-4 text-muted" style="font-size:.88rem;">Loading orders...</div>`;

            $.get(ORDERS_API, function(data) {
                if (data.status !== 200 || !data.orders) {
                    container.innerHTML = `<div class="text-center py-4" style="color:#dc2626;font-size:.88rem;">Failed to load orders.</div>`;
                    return;
                }

                const orders = data.orders;
                if (!orders.length) {
                    container.innerHTML = `<div class="text-center py-4" style="color:#6b7280;font-size:.88rem;">No orders in production.</div>`;
                    return;
                }

                container.innerHTML = orders.map(o => `
                    <tr>
                        <td>${o.id}</td>
                        <td>${o.factory}</td>
                        <td>${o.ex_factory_date}</td>
                        <td>${o.sales_rep}</td>
                    </tr>
                `).join('');
            }).fail(function(xhr) {
                container.innerHTML = `<div class="text-center py-4" style="color:#dc2626;font-size:.88rem;">
                    Error ${xhr.status}: Unable to load orders.</div>`;
                console.error('Orders fetch failed:', xhr.status, xhr.responseText);
            });
        }

        /* ── FETCH AND RENDER REAL EMAILS ── */
        function fetchDashboardEmails() {
            const c = document.getElementById('emailContainer');
            if (!c) return;
            c.innerHTML = '<div class="text-center py-4 text-muted" style="font-size:.88rem;">Loading emails...</div>';

            $.get("{{ route('superadmin.dashboard.emails') }}", function(data) {
                if (data.status !== 200 || !data.emails) {
                    c.innerHTML = '<div class="text-center py-4" style="color:#dc2626;font-size:.88rem;">' + (data.message || 'Failed to load emails.') + '</div>';
                    return;
                }

                const emails = data.emails;
                if (!emails.length) {
                    c.innerHTML = '<div class="text-center py-4" style="color:#6b7280;font-size:.88rem;">No unread emails found.</div>';
                    return;
                }

                c.innerHTML = emails.map(e => `
                <a href="/callbackmail/${e.id}" target="_blank" class="email-row" style="text-decoration:none; color:inherit; display:flex; width:100%;">
                    <div class="email-avatar" style="background:${e.color};">${e.initials}</div>
                    <div class="email-body" style="text-align:left;">
                        <div class="email-name">
                            ${e.name}
                            ${e.isNew ? '<span class="badge-new">New</span>' : ''}
                        </div>
                        <div class="email-subj" style="text-align:left;">${e.subject}</div>
                    </div>
                    <div class="email-time">${e.time}</div>
                </a>
            `).join('');
            }).fail(function(xhr) {
                c.innerHTML = '<div class="text-center py-4" style="color:#dc2626;font-size:.88rem;">Error ' + xhr.status + ': Unable to load emails.</div>';
                console.error('Dashboard emails fetch failed:', xhr.status, xhr.responseText);
            });
        }
        fetchDashboardEmails();

        /* ── FETCH AND RENDER MEETINGS ── */
        function fetchMeetings() {
            const container = document.getElementById('meetingsContainer');
            if (!container) return;
            container.innerHTML = '<div class="text-center py-4 text-muted" style="font-size:.88rem;">Loading meetings...</div>';

            $.get("{{ route('superadmin.dashboard.meetings') }}", function(data) {
                if (!Array.isArray(data)) {
                    container.innerHTML = '<div class="text-center py-4 text-muted" style="font-size:.88rem;">No upcoming meetings or events.</div>';
                    return;
                }

                const now = new Date();
                const upcoming = data.map(item => {
                        const start = new Date(item.start);
                        const end = new Date(item.end);
                        const p = item.extendedProps || {};

                        const day = start.getDate();
                        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                        const month = months[start.getMonth()];
                        const year = start.getFullYear();
                        const dateStr = `${day} ${month} ${year}`;

                        const pad = (n) => String(n).padStart(2, '0');
                        const timeStr = `${pad(start.getHours())}:${pad(start.getMinutes())} – ${pad(end.getHours())}:${pad(end.getMinutes())}`;
                        const scheduleType = (p.schedule_type || '').toLowerCase();
                        const isMeetingType = scheduleType.includes('meet') || ['sales', 'team', 'one_on_one', 'group'].includes(scheduleType);
                        const tag = isMeetingType ? 'Meeting' : 'Event';
                        // const isMeetingType = ['sales', 'team', 'one_on_one', 'group', 'meeting'].includes(p.schedule_type);
                        // const tag = isMeetingType ? 'Meeting' : 'Event';

                        let zoomText = '';
                        let zoomUrl = (p.zoom_join_url || '').trim();
                        const loc = p.location_value || '';

                        if (!zoomUrl && loc.toLowerCase().includes('http')) {
                            const match = loc.match(/https?:\/\/[^\s<>"']+/);
                            zoomUrl = match ? match[0] : '';
                        }

                        if (zoomUrl) {
                            zoomText = 'Zoom meeting';
                        } else if (loc) {
                            zoomText = loc.startsWith('Zoom Meeting:') ? 'Zoom meeting' : loc;
                        }

                        return {
                            title: p.schedule_name || 'Meeting',
                            slug: p.slug || '',
                            description: p.description || '',
                            date: dateStr,
                            time: timeStr,
                            tag: tag,
                            zoomText: zoomText,
                            zoomUrl: zoomUrl,
                            isRecurring: p.is_recurring || false,
                            startObj: start
                        };
                    })
                    .filter(m => m.startObj >= now)
                    .sort((a, b) => a.startObj - b.startObj);

                renderMeetingsList(upcoming);
            }).fail(function(xhr) {
                container.innerHTML = `<div class="text-center py-4 text-danger" style="font-size:.88rem;">Error loading meetings.</div>`;
                console.error('Meetings fetch failed:', xhr.status, xhr.responseText);
            });
        }

        function renderMeetingsList(meetings) {
            const c = document.getElementById('meetingsContainer');
            if (!c) return;
            if (!meetings || !meetings.length) {
                c.innerHTML = '<div class="text-center py-4 text-muted" style="font-size:.88rem;">No upcoming meetings or events.</div>';
                return;
            }

            c.innerHTML = meetings.map(m => {
                const slug = m.slug || '';
                const baseUrl = "{{ url('/') }}";
                const publicUrl = baseUrl + '/book/' + slug;

                let slugLinkHtml = '';
                if (m.slug) {
                    slugLinkHtml = `<a href="${publicUrl}" target="_blank" class="meeting-ext-link" title="Open booking page" onclick="event.stopPropagation();" style="color:#6b7280;margin-left:.25rem;display:inline-flex;align-items:center;">
                        <i class="fas fa-external-link-alt"></i>
                    </a>`;
                }

                const zoomLinkHtml = (m.zoomUrl && m.zoomUrl !== '#') ?
                    `<a href="${m.zoomUrl}" target="_blank" rel="noopener noreferrer" class="meeting-zoom" onclick="event.stopPropagation();" style="margin-left:0.25rem;display:inline-flex;align-items:center;gap:0.2rem;">
                        <i class="fas fa-video" style="font-size:11px;"></i>Zoom meeting
                    </a>` : '';

                const description = m.description ? `<p class="meeting-description" style="font-size:0.8rem;color:#6b7280;margin-top:0.25rem;">${m.description}</p>` : '';
                const recurrenceBadge = m.isRecurring ?
                    `<span class="meeting-tag" style="background:#eff6ff;color:#2563eb;">Recurring</span>` :
                    `<span class="meeting-tag" style="background:#fef3c7;color:#92400e;">One-time</span>`;

                return `
                    <div class="meeting-item" style="cursor:pointer;padding:0.2rem 0.75rem;" onclick="window.open('{{ url('schedules') }}', '_blank');">
                        <div style="flex:1;min-width:0;">
                            <p class="meeting-title" style="margin-bottom:0.25rem;font-size:0.95rem;">${m.title}</p>
                            <div class="meeting-meta">
                                <span><i class="fas fa-calendar-alt" style="color:#2dd4c0;"></i> ${m.date}</span>
                                <span><i class="fas fa-clock" style="color:#2dd4c0;"></i> ${m.time}</span>
                                <span class="meeting-tag">${m.tag}</span>
                                ${recurrenceBadge}
                                ${zoomLinkHtml}
                                ${slugLinkHtml}
                            </div>
                            ${description}
                        </div>
                    </div>`;
            }).join('');
        }

        /* ── RENDER CALENDAR ── */
        function renderCalendar() {
            document.getElementById('calTitle').textContent = `${MONTHS[calMonth]} ${calYear}`;

            // Day headers
            const head = document.getElementById('calHead');
            head.innerHTML = DAYS.map(d => `<div class="cal-head-cell">${d}</div>`).join('');

            const grid = document.getElementById('calGrid');
            grid.innerHTML = '';

            const firstDay = new Date(calYear, calMonth, 1).getDay(); // 0=Sun
            const daysInMonth = new Date(calYear, calMonth + 1, 0).getDate();
            // Convert Sunday=0 to Mon-indexed offset
            const offset = (firstDay === 0) ? 6 : firstDay - 1;

            // Previous month filler - use createElement to preserve later event listeners
            const prevDays = new Date(calYear, calMonth, 0).getDate();
            for (let i = offset - 1; i >= 0; i--) {
                const filler = document.createElement('div');
                filler.className = 'cal-cell other-month';
                filler.textContent = prevDays - i;
                grid.appendChild(filler);
            }

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            /* Public holidays: month is 0-indexed */
            const PUBLIC_HOLIDAYS = [{
                    month: 1,
                    day: 4,
                    name: "National Day"
                },
                {
                    month: 3,
                    day: 13,
                    name: "Sinhala & Tamil New Year"
                },
                {
                    month: 3,
                    day: 14,
                    name: "Sinhala & Tamil New Year"
                },
                {
                    month: 4,
                    day: 1,
                    name: "Labour Day"
                },
                {
                    month: 5,
                    day: 29,
                    name: "Poson Poya Day"
                },
                {
                    month: 11,
                    day: 25,
                    name: "Christmas Day"
                }
            ];

            for (let day = 1; day <= daysInMonth; day++) {
                const d = new Date(calYear, calMonth, day);
                const dow = d.getDay();
                const isWeekend = (dow === 0 || dow === 6);

                // Find matching holiday
                const holiday = PUBLIC_HOLIDAYS.find(h => h.month === calMonth && h.day === day);
                const isHoliday = !!holiday;

                const isToday = d.toDateString() === today.toDateString();
                const isSelected = selectedLeaveDate && d.toDateString() === selectedLeaveDate.toDateString();
                const leaveKey = `${calYear}-${calMonth}-${day}`;
                const leave = LEAVES[leaveKey];

                let cellClass = 'cal-cell';
                if (isToday) cellClass += ' today';
                else if (isHoliday) cellClass += ' holiday';
                else if (isWeekend) cellClass += ' weekend';
                if (isSelected) cellClass += ' selected-leave-day';

                const cell = document.createElement('div');
                cell.className = cellClass;
                cell.setAttribute('data-day', day);
                cell.style.cursor = 'pointer';

                // Build inner HTML: day number + holiday name (if any) + leave badge (if any)
                let innerHtml = `<span>${day}</span>`;
                if (isHoliday) {
                    innerHtml += `<div style="font-size: 0.6rem; font-weight: 500; line-height: 1.2; margin-top: 2px;">${holiday.name}</div>`;
                }
                if (leave) {
                    innerHtml += `<span class="cal-leave-badge">${leave.text}</span>`;
                }
                cell.innerHTML = innerHtml;

                // Add saturday class for Saturday cells (dow === 6)
                if (dow === 6) {
                    cell.classList.add('saturday');
                }

                cell.addEventListener('click', function() {
                    selectedLeaveDate = new Date(calYear, calMonth, day);
                    selectedLeaveDate.setHours(0, 0, 0, 0);
                    grid.querySelectorAll('.cal-cell').forEach(c => c.classList.remove('selected-leave-day'));
                    cell.classList.add('selected-leave-day');
                    renderTodayLeaveList(leaveData, selectedLeaveDate);
                });
                grid.appendChild(cell);
            }

            // Next month filler - use createElement to avoid destroying event listeners
            const total = offset + daysInMonth;
            const remaining = (7 - (total % 7)) % 7;
            for (let i = 1; i <= remaining; i++) {
                const filler = document.createElement('div');
                filler.className = 'cal-cell other-month';
                filler.textContent = i;
                grid.appendChild(filler);
            }
        }

        document.getElementById('calPrev').addEventListener('click', function() {
            calMonth--;
            if (calMonth < 0) {
                calMonth = 11;
                calYear--;
            }
            renderCalendar();
        });
        document.getElementById('calNext').addEventListener('click', function() {
            calMonth++;
            if (calMonth > 11) {
                calMonth = 0;
                calYear++;
            }
            renderCalendar();
        });

        const dashboardAssigneeFilter = document.getElementById('dashboardTaskAssigneeFilter');
        if (dashboardAssigneeFilter) {
            dashboardAssigneeFilter.addEventListener('change', fetchDashboardTasks);
        }

        /* ── CUSTOM SELECT (TASK FILTER) ── */
        (function() {
            const wrap = document.getElementById('customSelectWrap');
            const dropdown = document.getElementById('customSelectDropdown');
            const display = document.getElementById('customSelectDisplay');
            const realSelect = document.getElementById('dashboardTaskAssigneeFilter');
            if (!wrap) return;

            /* --- Build search input once and prepend to dropdown --- */
            const searchBox = document.createElement('div');
            searchBox.style.cssText = 'padding:.45rem .65rem;position:sticky;top:0;background:#fff;border-bottom:1px solid #e5e7eb;z-index:1;';
            searchBox.innerHTML =
                '<input id="customSelectSearch" type="text" placeholder="Search…" autocomplete="off" ' +
                'style="width:100%;border:1.5px solid #d1d5db;border-radius:999px;padding:.3rem .75rem;' +
                'font-size:.8rem;font-weight:500;color:#374151;outline:none;box-sizing:border-box;">';
            dropdown.prepend(searchBox);

            const searchInput = document.getElementById('customSelectSearch');

            /* Collect all option elements (stamped by Blade, after prepend they are siblings) */
            function allOptions() {
                return Array.from(dropdown.querySelectorAll('.custom-select-option'));
            }

            /* --- Filter options as user types --- */
            searchInput.addEventListener('input', function() {
                const q = this.value.trim().toLowerCase();
                allOptions().forEach(function(opt) {
                    const match = !q || opt.textContent.trim().toLowerCase().indexOf(q) >= 0;
                    opt.style.display = match ? '' : 'none';
                });
            });

            /* Prevent the input's own click from toggling the wrap */
            searchInput.addEventListener('click', function(e) {
                e.stopPropagation();
            });
            searchBox.addEventListener('click', function(e) {
                e.stopPropagation();
            });

            /* --- Toggle open/close --- */
            function isInDropdown(el) {
                return dropdown.contains(el);
            }

            wrap.addEventListener('click', function(e) {
                if (isInDropdown(e.target)) return;
                e.stopPropagation();
                const opening = !wrap.classList.contains('open');
                wrap.classList.toggle('open');
                if (opening) {
                    /* Clear stale search and restore all options */
                    searchInput.value = '';
                    allOptions().forEach(function(opt) {
                        opt.style.display = '';
                    });
                    /* Focus the search box after a tick so the dropdown has rendered */
                    setTimeout(function() {
                        searchInput.focus();
                    }, 0);
                }
            });

            /* --- Option selection --- */
            dropdown.addEventListener('click', function(e) {
                const opt = e.target.closest('.custom-select-option');
                if (!opt) return;
                allOptions().forEach(function(o) {
                    o.classList.remove('active');
                });
                opt.classList.add('active');
                display.textContent = opt.textContent.trim();
                realSelect.value = opt.dataset.value;
                wrap.classList.remove('open');
                realSelect.dispatchEvent(new Event('change'));
            });

            /* --- Close on outside click --- */
            document.addEventListener('click', function(e) {
                if (!wrap.contains(e.target)) {
                    wrap.classList.remove('open');
                }
            });
        })();

        /* ── INIT ── */
        fetchDashboardTasks();
        loadLeaveCalendarData().always(renderCalendar);
        fetchMeetings();
        fetchOrdersInProduction();
        // initConfigurationCounts();
    });
</script>
@endsection
