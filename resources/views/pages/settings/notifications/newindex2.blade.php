@extends('layouts.app', ['activePage' => 'notifications', 'titlePage' => __('Notifications')])

@section('content')

    {{-- Flatpickr CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        /* ── Base ── */
        .notifications-wrapper {
            min-height: 100vh;
            font-family: 'Inter', 'Segoe UI', sans-serif;
            font-size: 13.5px;
            color: #1a1a2e;
            padding: 0;
            padding-bottom: 5rem;
        }

        .notifications-container {
            padding: 0 28px;
        }

        /* ── Topbar ── */
        .notif-topbar {
            border-bottom: 1px solid #e8eaed;
            min-height: 56px;
            display: flex;
            align-items: center;
            flex-wrap: nowrap;
            gap: 0;
        }

        .notif-tabs {
            display: flex;
            align-items: stretch;
            gap: 0;
            flex-shrink: 0;
            height: 56px;
        }

        .notif-tab {
            background: none;
            border: none;
            border-bottom: 2.5px solid transparent;
            color: #6b7280;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .6px;
            padding: 0 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 7px;
            transition: color .15s, border-color .15s;
            white-space: nowrap;
        }

        .notif-tab:hover {
            color: #111827;
        }

        .notif-tab.active {
            color: #111827;
            border-bottom-color: #111827;
        }

        .notif-tab .tab-badge {
            background: #e5e7eb;
            color: #374151;
            border-radius: 20px;
            font-size: 10.5px;
            font-weight: 700;
            padding: 1px 7px;
            line-height: 1.6;
        }

        .notif-tab.active .tab-badge {
            background: #111827;
            color: #fff;
        }

        /* Search */
        .notif-search {
            flex: 1;
            max-width: 460px;
            padding: 0 24px;
        }

        .search-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-icon {
            position: absolute;
            left: 13px;
            color: #9ca3af;
            font-size: 13px;
        }

        .search-input {
            width: 100%;
            border: 1px solid #e0e0e0;
            border-radius: 24px;
            padding: 7px 16px 7px 38px;
            font-size: 13px;
            color: #374151;
            background: #f9fafb;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }

        .search-input:focus {
            border-color: #9ca3af;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, .05);
        }

        /* Action Buttons */
        .notif-actions {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: auto;
        }

        .action-btn {
            background: none;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            color: #6b7280;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .5px;
            padding: 6px 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 7px;
            transition: background .12s, border-color .12s, color .12s;
            white-space: nowrap;
        }

        .action-btn:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
            color: #374151;
        }

        /* ── Body ── */
        .notif-body {
            padding: 24px 0;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* ── Card ── */
        .notif-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .08), 0 0 0 1px rgba(0, 0, 0, .05);
            overflow: visible;
        }

        .notif-card-header {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            border-bottom: 1px solid #f3f4f6;
            background: #fff;
            position: relative;
        }

        .section-label {
            font-size: 12.5px;
            font-weight: 700;
            color: #9ca3af;
            letter-spacing: .4px;
            text-transform: uppercase;
        }

        .pagination-info {
            font-size: 12px;
            color: #9ca3af;
        }

        .page-nav-btn {
            background: none;
            border: none;
            color: #6b7280;
            font-size: 12px;
            padding: 4px 7px;
            cursor: pointer;
            border-radius: 4px;
            transition: background .1s, color .1s;
        }

        .page-nav-btn:hover {
            background: #f3f4f6;
        }

        .page-nav-btn:disabled {
            opacity: .35;
            cursor: not-allowed;
        }

        /* ── Filter Dropdown ── */
        .filter-dropdown-wrap {
            position: relative;
            display: inline-block;
        }

        .filter-dropdown-menu {
            display: none;
            position: absolute;
            top: calc(100% + 6px);
            right: 0;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .12);
            min-width: 180px;
            z-index: 999;
            overflow: hidden;
        }

        .filter-dropdown-menu.show {
            display: block;
        }

        .filter-dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 16px;
            font-size: 12.5px;
            font-weight: 600;
            color: #374151;
            cursor: pointer;
            transition: background .1s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .filter-dropdown-item:hover {
            background: #f9fafb;
        }

        .filter-dropdown-item.active {
            color: #0d9488;
            background: #f0fdf9;
        }

        .filter-dropdown-item i {
            width: 16px;
            text-align: center;
            color: #9ca3af;
            font-size: 13px;
        }

        .filter-dropdown-item.active i {
            color: #0d9488;
        }

        /* Active filter badge shown in header */
        .active-filter-badge {
            display: none;
            align-items: center;
            gap: 6px;
            background: #f0fdf9;
            border: 1px solid #d1fae5;
            color: #0d9488;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 10px 2px 8px;
            margin-left: 10px;
        }

        .active-filter-badge.show {
            display: inline-flex;
        }

        .active-filter-badge .clear-filter {
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            font-size: 11px;
            padding: 0;
            line-height: 1;
            margin-left: 2px;
            transition: color .1s;
        }

        .active-filter-badge .clear-filter:hover {
            color: #374151;
        }

        /* Calendar input hidden */
        .calendar-input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
            pointer-events: none;
        }

        /* ── Rows ── */
        .notif-row {
            min-height: 50px;
            border-bottom: 1px solid #f3f4f6;
            background: #fff;
            transition: background .1s;
            display: flex;
            align-items: center;
            padding: 0 20px;
            gap: 0;
            cursor: pointer;
        }

        .notif-row.read {
            background: #fff;
        }

        .notif-row.unread {
            background: #eeeeee;
        }

        .notif-row:last-child {
            border-bottom: none;
        }

        .notif-row:hover {
            background: #f0f0f0;
        }

        /* Checkbox */
        .custom-control {
            padding-left: 24px;
            margin-bottom: 0;
        }

        .custom-control-label {
            display: flex;
            align-items: center;
            min-height: 18px;
        }

        .custom-control-label::before,
        .custom-control-label::after {
            top: 50% !important;
            transform: translateY(-50%);
        }

        .custom-control-input:checked~.custom-control-label::before {
            background-color: #111827;
            border-color: #111827;
        }

        .header-check,
        .row-check {
            margin-right: 12px;
            display: flex;
            align-items: center;
            min-width: 26px;
        }

        /* Star */
        .star-btn {
            background: none;
            border: none;
            padding: 0 2px;
            color: #d1d5db;
            font-size: 15px;
            cursor: pointer;
            transition: color .12s;
            line-height: 1;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .star-btn.starred,
        .star-btn:hover {
            color: #47D6B6;
        }

        /* Icon circle */
        .notif-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 13px;
            margin-right: 14px;
        }

        .icon-gray {
            background: #DEDEDE;
        }

        .icon-red {
            background: #fde4e5;
        }

        .icon-teal {
            background: #14b8a6;
        }

        /* Source */
        .notif-source {
            font-weight: 700;
            font-size: 13px;
            color: #111827;
            white-space: nowrap;
            min-width: 195px;
            max-width: 193px;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-right: 20px;
            flex-shrink: 0;
        }

        /* Content */
        .notif-content {
            flex: 1;
            min-width: 0;
        }

        .notif-text {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .notif-title-row {
            display: flex;
            align-items: center;
            gap: 6px;
            min-width: 0;
        }

        .notif-type {
            font-weight: 700;
            color: #111827;
            font-size: 13px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            min-width: 0;
        }

        .notif-detail {
            margin-top: 2px;
            color: #6b7280;
            font-size: 11.5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Badges */
        .order-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #dcfce7;
            color: #15803d;
            border-radius: 5px;
            font-size: 11.5px;
            font-weight: 700;
            padding: 2px 8px;
            white-space: nowrap;
            margin: 0 6px;
            flex-shrink: 0;
        }

        .order-badge.badge-red {
            background: #fee2e2;
            color: #b91c1c;
        }

        .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #22c55e;
            display: inline-block;
            flex-shrink: 0;
        }

        .dot.dot-red {
            background: #ef4444;
        }

        .project-label {
            font-weight: 700;
            color: #111827;
            white-space: nowrap;
            margin: 0 4px;
            flex-shrink: 0;
        }

        /* Time */
        .notif-time {
            font-size: 12px;
            color: #9ca3af;
            white-space: nowrap;
            flex-shrink: 0;
            min-width: 90px;
            text-align: right;
            margin-left: 12px;
        }

        /* Empty / Loading / Error */
        .notif-state-box {
            padding: 70px 20px;
            text-align: center;
            color: #9ca3af;
        }

        .notif-state-box i {
            font-size: 30px;
            margin-bottom: 12px;
            display: block;
        }

        .notif-state-box p {
            font-size: 13.5px;
            font-weight: 600;
            margin: 0;
        }

        button:focus {
            outline: none;
        }

        @media (max-width: 768px) {
            .header1 {
                /* position: relative; */
                /* display: block !important; */
                top: 110px;
                /* background-color: white; */
                /* padding-top: 5px; */
            }
            
            .notifications-wrapper {
                padding-bottom: 2rem;
            }

            .notifications-container {
                padding: 0 10px;
            }

            /* ── Topbar Mobile Layout ── */
            .notif-topbar {
                flex-direction: column;
                align-items: stretch;
                height: auto;
                border-bottom: none;
                gap: 10px;
                padding-top: 10px;
            }

            /* Tabs horizontally scrollable pills */
            .notif-tabs {
                height: auto;
                overflow-x: auto;
                padding-bottom: 2px;
                gap: 8px;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
            }

            .notif-tabs::-webkit-scrollbar {
                display: none;
            }

            .notif-tab {
                height: 38px;
                border-radius: 20px;
                border: 1px solid #e5e7eb;
                background: #f8fafc;
                padding: 0 16px;
                font-size: 12.5px;
                font-weight: 700;
                color: #475569;
                border-bottom: 1px solid #e5e7eb;
            }

            .notif-tab.active {
                background: #0f172a;
                color: #ffffff;
                border-color: #0f172a;
                border-bottom-color: #0f172a;
            }

            .notif-tab .tab-badge {
                background: #e2e8f0;
                color: #475569;
                font-size: 11px;
            }

            .notif-tab.active .tab-badge {
                background: rgba(255, 255, 255, 0.2);
                color: #ffffff;
            }

            /* Search input full width */
            .notif-search {
                max-width: 100%;
                padding: 0;
            }

            .search-input {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                padding: 10px 16px 10px 38px;
                font-size: 13px;
            }

            /* Action Buttons 2-column or full row */
            .notif-actions {
                margin-left: 0;
                width: 100%;
                display: flex;
                gap: 10px;
            }

            .action-btn {
                flex: 1;
                justify-content: center;
                border-radius: 8px;
                padding: 9px 12px;
                font-size: 11.5px;
                font-weight: 600;
                background: #ffffff;
                border: 1px solid #e2e8f0;
                color: #475569;
            }

            /* Card & Header adjustments */
            .notif-card {
                border-radius: 8px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.05);
                background: #ffffff;
                border: 1px solid #f1f5f9;
                overflow: hidden;
            }

            .notif-card-header {
                padding: 12px 14px;
                background: #ffffff;
                flex-wrap: wrap;
                gap: 8px;
            }

            /* Row mobile design matching image3 */
            .notif-row {
                padding: 10px 14px;
                height: auto;
                min-height: auto;
                display: flex;
                flex-direction: row;
                align-items: flex-start;
                gap: 8px;
                background: #ffffff;
                border-bottom: 1px solid #f1f5f9;
            }

            .notif-row.unread {
                background: #f3f4f6;
            }

            .notif-row.read {
                background: #ffffff;
            }

            .notif-icon {
                display: none !important;
                /* display: flex !important;
                width: 26px;
                height: 26px;
                font-size: 11px;
                margin-right: 8px;
                flex-shrink: 0; */
            }

            .notif-row.unread .notif-type {
                color: #0f172a;
            }

            .header-check, .row-check {
                margin-right: 0;
                padding-top: 3px;
                min-width: 20px;
            }

            .star-btn {
                margin-right: 2px;
                padding-left: 0;
                padding-top: 3px;
                font-size: 14.5px;
                color: #cbd5e1;
            }

            .notif-content {
                flex: 1;
                min-width: 0;
                display: flex;
                flex-direction: row;
                align-items: flex-start;
                justify-content: space-between;
                gap: 8px;
            }

            .notif-source {
                display: none;
            }

            .notif-text {
                display: flex;
                flex-direction: column;
                gap: 2px;
                min-width: 0;
                flex: 1;
            }

            .notif-title-row {
                display: flex;
                align-items: center;
                flex-wrap: nowrap;
                gap: 6px;
                min-width: 0;
            }

            .notif-type {
                font-weight: 700;
                color: #1e293b;
                font-size: 13px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                flex-shrink: 1;
                min-width: 0;
            }

            .order-badge {
                font-size: 10.5px;
                padding: 1px 7px;
                margin: 0;
                flex-shrink: 0;
            }

            .notif-detail {
                margin-top: 1px;
                color: #94a3b8;
                font-size: 12px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .notif-time {
                display: block !important;
                margin-left: 0 !important;
                font-size: 11px;
                color: #94a3b8;
                text-align: right;
                min-width: auto;
                margin-top: 0;
                font-weight: 400;
                flex-shrink: 0;
                white-space: nowrap;
                padding-top: 1px;
            }
        
        }

    .per-page-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background: #fff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='10' height='6'><path d='M0 0l5 6 5-6z' fill='%236b7280'/></svg>") no-repeat right 8px center;
        border: 1px solid #d1d5db;
        border-radius: 5px;
        color: #374151;
        font-size: 11.5px;
        font-weight: 700;
        padding: 4px 22px 3px 10px;
        cursor: pointer;
        outline: none;
        transition: border-color .12s, background-color .12s;
    }

    .per-page-select:hover {
        border-color: #9ca3af;
        background-color: #f9fafb;
    }

    .per-page-select:focus {
        border-color: #9ca3af;
        box-shadow: 0 0 0 3px rgba(0, 0, 0, .05);
    }
    </style>

@section('order-header')
    <span>Notifications</span>
@endsection

<div class="notifications-wrapper">
    <div class="notifications-container">

        {{-- ── Topbar ── --}}
        <div class="notif-topbar">
            <div class="notif-tabs">
                <button class="notif-tab active" data-tab="all">
                    <i class="fa-solid fa-list-check"></i> ALL
                    <span class="tab-badge" id="badge-all">0</span>
                </button>
                <button class="notif-tab" data-tab="unread">
                    <i class="fas fa-bell-slash"></i> UNREAD
                    <span class="tab-badge" id="badge-unread">0</span>
                </button>
                <button class="notif-tab" data-tab="mentions">
                    <i class="fas fa-at"></i> MENTIONS
                    <span class="tab-badge" id="badge-mentions">0</span>
                </button>
                <button class="notif-tab" data-tab="marked">
                    <i class="far fa-star"></i> MARKED
                    <span class="tab-badge" id="badge-marked">0</span>
                </button>
            </div>

            <div class="notif-search">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" id="searchInput" placeholder="Search Notifications">
                </div>
            </div>

            <div class="notif-actions">
                <button class="action-btn" onclick="markSelected('read')">
                    <i class="far fa-check-square"></i> MARK AS READ
                </button>
                <button class="action-btn" onclick="markSelected('unread')">
                    <i class="fas fa-sign-out-alt fa-flip-horizontal"></i> MARK AS UNREAD
                </button>
            </div>
        </div>

        {{-- ── Tab Panels ── --}}
        <div class="notif-body">

            @foreach (['all', 'unread', 'mentions', 'marked'] as $tabId)
                <div id="tab-{{ $tabId }}" class="tab-content {{ $tabId === 'all' ? 'active' : '' }}">
                    <div class="notif-card">

                        <div class="notif-card-header">
                            <div class="custom-control custom-checkbox header-check">
                                <input type="checkbox" class="custom-control-input" id="selectAll_{{ $tabId }}">
                                <label class="custom-control-label" for="selectAll_{{ $tabId }}"></label>
                            </div>
                            <span class="section-label">Notifications</span>

                            {{-- Active filter badge --}}
                            <span class="active-filter-badge" id="filter-badge-{{ $tabId }}">
                                <i class="fas fa-filter" style="font-size:10px;"></i>
                                <span id="filter-badge-text-{{ $tabId }}"></span>
                                <button class="clear-filter" onclick="clearFilter('{{ $tabId }}')"
                                    title="Clear filter">
                                    <i class="fas fa-times"></i>
                                </button>
                            </span>

                            <div class="ml-auto d-flex align-items-center" style="gap:4px;">
                                <div class="filter-dropdown-wrap">
                                    <select class="per-page-select" id="perPage-{{ $tabId }}" data-tab="{{ $tabId }}">
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                                <span class="pagination-info" id="pagination-info-{{ $tabId }}">– – –</span>

                                <button class="page-nav-btn" id="prev-btn-{{ $tabId }}"
                                    data-tab="{{ $tabId }}" data-action="prev" disabled>
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="page-nav-btn" id="next-btn-{{ $tabId }}"
                                    data-tab="{{ $tabId }}" data-action="next" disabled>
                                    <i class="fas fa-chevron-right"></i>
                                </button>

                                {{-- Calendar button --}}
                                <div style="position:relative;">
                                    <button class="page-nav-btn" onclick="openCalendar('{{ $tabId }}')"
                                        title="Filter by date">
                                        <i class="fa-solid fa-calendar-days"></i>
                                    </button>
                                    <input type="text" class="calendar-input" id="cal-{{ $tabId }}">
                                </div>

                                {{-- Dropdown filter --}}
                                <div class="filter-dropdown-wrap">
                                    <button class="page-nav-btn" id="dropdown-btn-{{ $tabId }}"
                                        onclick="toggleDropdown('{{ $tabId }}')" title="Filter by period">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                    <div class="filter-dropdown-menu" id="dropdown-{{ $tabId }}">
                                        <button class="filter-dropdown-item" data-value=""
                                            onclick="applyGroupFilter('{{ $tabId }}', '', 'All Time', this)">
                                            <i class="fas fa-list"></i> All Time
                                        </button>
                                        <button class="filter-dropdown-item" data-value="today"
                                            onclick="applyGroupFilter('{{ $tabId }}', 'today', 'Today', this)">
                                            <i class="fas fa-sun"></i> Today
                                        </button>
                                        <button class="filter-dropdown-item" data-value="yesterday"
                                            onclick="applyGroupFilter('{{ $tabId }}', 'yesterday', 'Yesterday', this)">
                                            <i class="fas fa-moon"></i> Yesterday
                                        </button>
                                        <button class="filter-dropdown-item" data-value="this_month"
                                            onclick="applyGroupFilter('{{ $tabId }}', 'this_month', 'This Month', this)">
                                            <i class="fas fa-calendar-alt"></i> This Month
                                        </button>
                                        <button class="filter-dropdown-item" data-value="this_year"
                                            onclick="applyGroupFilter('{{ $tabId }}', 'this_year', 'This Year', this)">
                                            <i class="fas fa-calendar"></i> This Year
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>{{-- /.notif-card-header --}}

                        {{-- Rows container --}}
                        <div id="rows-{{ $tabId }}">
                            <div class="notif-state-box">
                                <i class="fas fa-spinner fa-spin"></i>
                                <p>Loading...</p>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>{{-- /.notif-body --}}
    </div>
</div>

@include('pages.settings.notifications.components.old-modal')
@include('pages.settings.notifications.components.common-modal')

{{-- Flatpickr JS --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // ── State per tab ───────────────────────────────────────────────────────────
    const tabState = {
        all: {
            page: 1,
            perPage: 20,
            total: 0,
            lastPage: 1,
            from: 0,
            to: 0,
            filterGroup: '',
            filterDate: ''
        },
        unread: {
            page: 1,
            perPage: 20,
            total: 0,
            lastPage: 1,
            from: 0,
            to: 0,
            filterGroup: '',
            filterDate: ''
        },
        mentions: {
            page: 1,
            perPage: 20,
            total: 0,
            lastPage: 1,
            from: 0,
            to: 0,
            filterGroup: '',
            filterDate: ''
        },
        marked: {
            page: 1,
            perPage: 20,
            total: 0,
            lastPage: 1,
            from: 0,
            to: 0,
            filterGroup: '',
            filterDate: ''
        },
    };

    const tabRoutes = {
        all: "{{ route('get.all.notifications2') }}",
        unread: "{{ route('get.all.unread.notifications2') }}",
        mentions: "{{ route('get.all.mention.notifications2') }}",
        marked: "{{ route('get.all.marked.notifications2') }}",
    };

    const initialCountRoute = "{{ route('get.initial.count') }}";

    const tabLoaded = {
        all: false,
        unread: false,
        mentions: false,
        marked: false
    };
    let activeTab = 'all';
    let searchTimer = null;
    const calInstances = {};

    // ── Init ────────────────────────────────────────────────────────────────────
    $(function() {
        loadTab('all');
        loadInitialCounts(); 

        // Tab switch
        $('.notif-tab').on('click', function() {
            const tab = $(this).data('tab');
            if (tab === activeTab) return;

            $('.notif-tab').removeClass('active');
            $(this).addClass('active');
            $('.tab-content').removeClass('active');
            $('#tab-' + tab).addClass('active');
            activeTab = tab;

            loadTab(tab);
        });

        // Pagination
        $(document).on('click', '.page-nav-btn[data-action]', function() {
            const tab = $(this).data('tab');
            const action = $(this).data('action');
            const state = tabState[tab];

            if (action === 'prev' && state.page > 1) {
                state.page--;
                loadTab(tab);
            }
            if (action === 'next' && state.page < state.lastPage) {
                state.page++;
                loadTab(tab);
            }
        });

        // Search
        $('#searchInput').on('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function() {
                tabState[activeTab].page = 1;
                loadTab(activeTab);
            }, 350);
        });

        // Init Flatpickr for each tab
        ['all', 'unread', 'mentions', 'marked'].forEach(function(tab) {
            $('#perPage-' + tab).val(tabState[tab].perPage);
            calInstances[tab] = flatpickr('#cal-' + tab, {
                dateFormat: 'Y-m-d',
                maxDate: 'today',
                onChange: function(selectedDates, dateStr) {
                    if (!dateStr) return;
                    applyDateFilter(tab, dateStr);
                }
            });
        });

        // Close dropdowns on outside click
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.filter-dropdown-wrap').length) {
                $('.filter-dropdown-menu').removeClass('show');
            }
        });

        // Select all checkbox
        $(document).on('change', '[id^="selectAll_"]', function() {
            const tab = this.id.replace('selectAll_', '');
            $('#rows-' + tab + ' .custom-control-input').prop('checked', this.checked);
        });
    });

    

    // ── Calendar ────────────────────────────────────────────────────────────────
    function openCalendar(tab) {
        calInstances[tab].open();
    }

    function applyDateFilter(tab, dateStr) {
        const state = tabState[tab];
        state.filterDate = dateStr;
        state.filterGroup = '';
        state.page = 1;

        // Show badge
        showFilterBadge(tab, dateStr);

        // Clear dropdown active
        $('#dropdown-' + tab + ' .filter-dropdown-item').removeClass('active');
        $('#dropdown-' + tab + ' [data-value=""]').addClass('active');

        loadTab(tab);
    }

    // ── Group Dropdown ───────────────────────────────────────────────────────────
    function toggleDropdown(tab) {
        const menu = $('#dropdown-' + tab);
        // Close others
        $('.filter-dropdown-menu').not(menu).removeClass('show');
        menu.toggleClass('show');
    }

    function applyGroupFilter(tab, value, label, el) {
        const state = tabState[tab];
        state.filterGroup = value;
        state.filterDate = '';
        state.page = 1;

        // Update active item
        $('#dropdown-' + tab + ' .filter-dropdown-item').removeClass('active');
        $(el).addClass('active');
        $('#dropdown-' + tab).removeClass('show');

        // Reset calendar
        calInstances[tab].clear();

        if (value) {
            showFilterBadge(tab, label);
        } else {
            hideFilterBadge(tab);
        }

        loadTab(tab);
    }

    function clearFilter(tab) {
        const state = tabState[tab];
        state.filterGroup = '';
        state.filterDate = '';
        state.page = 1;

        calInstances[tab].clear();
        $('#dropdown-' + tab + ' .filter-dropdown-item').removeClass('active');
        $('#dropdown-' + tab + ' [data-value=""]').addClass('active');
        hideFilterBadge(tab);
        loadTab(tab);
    }

    function showFilterBadge(tab, text) {
        $('#filter-badge-text-' + tab).text(text);
        $('#filter-badge-' + tab).addClass('show');
    }

    function hideFilterBadge(tab) {
        $('#filter-badge-' + tab).removeClass('show');
        $('#filter-badge-text-' + tab).text('');
    }

    // ── Load Tab Data ────────────────────────────────────────────────────────────
    function loadTab(tab) {
        const state = tabState[tab];
        const search = $('#searchInput').val().trim();

        showLoading(tab);

        $.ajax({
            url: tabRoutes[tab],
            type: 'GET',
            dataType: 'json',
            data: {
                page: state.page,
                per_page: state.perPage,
                filter_group: state.filterGroup,
                filter_date: state.filterDate,
                search: search,
            },
            success: function(response) {
                const p = response.pagination;
                state.total = p.total;
                state.lastPage = p.last_page;
                state.from = p.from;
                state.to = p.to;

                $('#badge-' + tab).text(p.total);
                renderRows(tab, response.data, state);
                tabLoaded[tab] = true;
            },
            error: function() {
                showError(tab);
            }
        });
    }

    // ── Render Rows ──────────────────────────────────────────────────────────────
    function renderRows(tab, data, state) {
        const container = $('#rows-' + tab);

        // Pagination controls
        $('#pagination-info-' + tab).text(
            state.total > 0 ?
            state.from + ' – ' + state.to + ' of ' + state.total :
            '0 of 0'
        );
        $('#prev-btn-' + tab).prop('disabled', state.page <= 1);
        $('#next-btn-' + tab).prop('disabled', state.page >= state.lastPage);

        if (!data || data.length === 0) {
            container.html(`
      <div class="notif-state-box">
        <i class="far fa-bell"></i>
        <p>No notifications found</p>
      </div>
    `);
            return;
        }

        let html = '';
        $.each(data, function(i, item) {
            html += buildRow(item, tab);
        });
        container.html(html);

        // Star toggle
        container.find('.star-btn').on('click', function(e) {
            e.stopPropagation();

            const $btn = $(this);
            const $row = $btn.closest('.notif-row');
            const id = $row.data('id');

            // optimistic UI update
            $btn.toggleClass('starred');
            $btn.find('i').toggleClass('far fas');

            $.ajax({
                url: "{{ url('/notifications') }}/" + id + "/toggle-star",
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (!response.status) {
                        // revert on failure
                        $btn.toggleClass('starred');
                        $btn.find('i').toggleClass('far fas');
                        return;
                    }


                    if (activeTab === 'marked' && !response.is_mark) {
                        loadTab('marked');
                    }

                    if (tabLoaded['marked'] && activeTab !== 'marked') {
                        loadTab('marked');
                    }

                    if (!tabLoaded['marked']) {
                        loadInitialCounts();
                    }
                },
                error: function() {
                    // revert on network/server error
                    $btn.toggleClass('starred');
                    $btn.find('i').toggleClass('far fas');
                }
            });
        });

        // Checkbox stop propagation
        container.find('.custom-control-input').on('click', function(e) {
            e.stopPropagation();
        });
    }

    // ── Build a single row ───────────────────────────────────────────────────────
    function buildRow(item, tab) {

        
        const badge = item.badge ?
            `<span class="order-badge ${item.badge_red ? 'badge-red' : ''}">
                <span class="dot ${item.badge_red ? 'dot-red' : ''}"></span>${item.badge}
            </span>` :
            '';

        const chkId = `chk_${tab}_${item.id}`;

        return `
        <div class="notif-row ${item.is_read ? 'read' : 'unread'} openNotification" data-type-notification="${item.new_notification}" data-notification-id="${item.id}" data-id="${item.id}">
            <div class="custom-control custom-checkbox row-check" onclick="event.stopPropagation()">
                <input type="checkbox" class="custom-control-input" id="${chkId}" data-notif-id="${item.id}">
                <label class="custom-control-label" for="${chkId}"></label>
            </div>
            <button class="star-btn ${item.starred ? 'starred' : ''}" onclick="event.stopPropagation()">
                <i class="${item.starred ? 'fas' : 'far'} fa-star"></i>
            </button>
            <div class="notif-icon ${item.icon_class}">
                <i class="${item.icon}" style="font-size:13px;"></i>
            </div>
            <div class="notif-source">${item.source}</div>
            <div class="notif-content">
                <div class="notif-text">
                <div class="notif-title-row">
                    <span class="notif-type">${item.title}</span>
                    ${badge}
                </div>
                <div class="notif-detail">${item.message}</div>
                </div>
            </div>
            <div class="notif-time">${item.display_time}</div>
        </div>
        `;
    }

    // ── Loading / Error states ───────────────────────────────────────────────────
    function showLoading(tab) {
        $('#rows-' + tab).html(`
            <div class="notif-state-box">
            <i class="fas fa-spinner fa-spin"></i>
            <p>Loading...</p>
            </div>
        `);
        $('#pagination-info-' + tab).text('– – –');
        $('#prev-btn-' + tab + ', #next-btn-' + tab).prop('disabled', true);
    }

    function showError(tab) {
        $('#rows-' + tab).html(`
    <div class="notif-state-box">
      <i class="fas fa-exclamation-circle"></i>
      <p>Failed to load notifications</p>
    </div>
  `);
    }



    const markRoutes = {
        read: "{{ route('notifications.mark.read') }}",
        unread: "{{ route('notifications.mark.unread') }}",
    };

    function getSelectedIds() {
        const ids = [];
        $('#rows-' + activeTab + ' .row-check .custom-control-input:checked').each(function() {
            ids.push(parseInt($(this).data('notif-id'), 10));
        });
        return ids;
    }

    function markSelected(state) {
        const ids = getSelectedIds();

        if (ids.length === 0) {
            return;
        }

        $.ajax({
            url: markRoutes[state],
            type: 'POST',
            dataType: 'json',
            data: {
                ids: ids,
                _token: "{{ csrf_token() }}",
            },
            success: function(response) {
                if (response.status) {
                    $('#selectAll_' + activeTab).prop('checked', false);
                    Object.keys(tabLoaded).forEach(function(tab) {
                        if (tabLoaded[tab]) {
                            loadTab(tab);
                        }
                    });
                    loadInitialCounts();
                }
            },
            error: function() {
                console.log(error);

            }
        });
    }

    $(document).on('change', '.per-page-select', function() {
        const tab = $(this).data('tab');
        const value = parseInt($(this).val(), 10);

        tabState[tab].perPage = value;
        tabState[tab].page = 1;

        loadTab(tab);
    });
</script>


<script>
    $(document).on('click', '.openNotification', function (e) {
        const id = $(this).data('notification-id');
        const type = $(this).data('type-notification');
        console.log('type', type);
        
        if (type == 1) {
            openNewNotificationModal(id);
        } else {
            openOldNotificationModal(id);
        }
        
    });


    function openOldNotificationModal(id) {
        console.log('notificationId', id);
        
        var $row = $(this).parent().data();
        var notificationId = id;
        $('#notification_id_factory_suggest_confirm').val(notificationId);
        $('#notification_id_factory_suggest_reject').val(notificationId);
        $.ajax({
            url: "{{ url('notifications/get_details') }}/" + notificationId,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                var notification = data.notification;
                var check_payment = data.check_payment;
                var venmo_payment = data.venmo_payment;
                var other_payment = data.other_payment;
                var order_details = data.order_details;

                console.log('order details :' + data.order_details);

                if (order_details) {
                    var order_team = '<small>' + notification.notification_title + '</small>';
                    var order_description = '<small>Description : ' + order_details
                        .order_description + '</small>';
                    $('#order_team').html(order_team);
                    $('#order_description').html(order_description);
                } else {
                    $('#order_team').html('');
                    $('#order_description').html('');
                }

                var notifi_at = new Date(notification.created_at);
                var notifi_date = notifi_at.getDate();
                var notifi_month = notifi_at.getMonth() + 1;
                var notifi_year = notifi_at.getFullYear();

                if (notifi_month == 1) {
                    var notifi_month_name = 'Jan';
                } else if (notifi_month == 2) {
                    var notifi_month_name = 'Feb';
                } else if (notifi_month == 3) {
                    var notifi_month_name = 'Mar';
                } else if (notifi_month == 4) {
                    var notifi_month_name = 'Apr';
                } else if (notifi_month == 5) {
                    var notifi_month_name = 'May';
                } else if (notifi_month == 6) {
                    var notifi_month_name = 'Jun';
                } else if (notifi_month == 7) {
                    var notifi_month_name = 'Jul';
                } else if (notifi_month == 8) {
                    var notifi_month_name = 'Aug';
                } else if (notifi_month == 9) {
                    var notifi_month_name = 'Sep';
                } else if (notifi_month == 10) {
                    var notifi_month_name = 'Oct';
                } else if (notifi_month == 11) {
                    var notifi_month_name = 'Nov';
                } else {
                    var notifi_month_name = 'Dec';
                }

                if (notification.order_details && notification.order_details.organization_details) {
                    $('#notification_modal_label').html(notification.order_details
                        .organization_details.organization_name);
                } else {
                    $('#notification_modal_label').html('');
                }
                $('#notification_modal_message').html(notification.notification_message);
                if (notification.task_name) {
                    $('#comment_section').show();
                    $('#notification_modal_task').html('Discussion: ' + notification.task_name);
                    $('#notification_modal_comment').html(notification.task_comments);
                } else {
                    $('#comment_section').hide();
                    $('#notification_modal_task').html('');
                    $('#notification_modal_comment').html('');
                }
                $('#modal_title_notification').html(notifi_month_name + '-' + ('0' + notifi_date)
                    .slice(-2) + '-' + notifi_year);

                //If Moved to production
                $('#order_confirmation_message').hide();

                if (notification.notification_message && notification.notification_message.includes(
                        'has been moved to production') && notification.is_urgent != 1) {
                    console.log('Here works !');
                    $('#techpack_download_area').html('');
                    var orderItemId = notification.order_item_id;
                    var redirectUrl = "{{ url('orders/DownloadTestPrint/') }}" + "/" +
                        encodeURIComponent(orderItemId);

                    $('#order_confirmation_message').show();
                    $('#order_in_hand_date p').text('In Hand Due Date : ' + notification
                        .order_in_hand_due_date);
                    $('#order_ex_factory_date p').text('Ex Factory Date : ' + notification
                        .order_ex_fac_date);
                    if (notification.order_reject_or_confirm == 1) {

                        $('#order_confirm_request_message').hide();
                        $('#confirm_order_factory').hide();
                        $('#reject_order_factory').hide();
                        $('#order_confirm_or_reject_message').html(
                            '<p style="margin-bottom: unset; font-weight: 600; color: red; margin-top: 25px;" class="mt-1 mb-1">Order rejected</p>'
                            );
                        $('#order_confirm_or_reject_message').show();

                        $('#techpack_download_area').append('<p>To Check Techpack - <a href="' +
                            redirectUrl + '">Click Here</a></p>');

                    } else if (notification.order_reject_or_confirm == 2) {
                        $('#order_confirm_request_message').hide();
                        $('#confirm_order_factory').hide();
                        $('#reject_order_factory').hide();
                        $('#order_confirm_or_reject_message').html(
                            '<p style="margin-bottom: unset; font-weight: 600; color: green; margin-top: 25px;" class="mt-1 mb-1">Order already confirmed</p>'
                            );
                        $('#order_confirm_or_reject_message').show();

                        $('#techpack_download_area').append('<p>To Check Techpack - <a href="' +
                            redirectUrl + '">Click Here</a></p>');
                    } else {
                        $('#order_confirm_or_reject_message').hide();
                        $('#order_confirm_request_message').show();
                        $('#confirm_order_factory').show();
                        $('#reject_order_factory').show();

                        $('#techpack_download_area').append('<p>To Check Techpack - <a href="' +
                            redirectUrl + '">Click Here</a></p>');
                    }
                    $('#reject_order_factory').on('click', function() {
                        $('#order_rejectModal').modal('show'); // Open the reject modal
                    });

                    $('#confirm_order_factory').on('click', function() {
                        $('#order_confirmModal').modal('show'); // Open the confirm modal
                    });

                    $('#order_rejecting_form').on('submit', function() {
                        var formData = $(this).serialize();
                        var urlParams = new URLSearchParams(formData);

                        var rejectReason = urlParams.get('reject_reason');

                        var suggestedDate = urlParams.get('ex_fac_date');

                        var orderId = notification.order_id;
                        var orderItemId = notification.order_item_id;

                        var redirectUrl =
                            "{{ url('factory_order_reject') }}?reject_reason=" +
                            encodeURIComponent(rejectReason) + "&suggested_date=" +
                            encodeURIComponent(suggestedDate) + "&order_id=" +
                            encodeURIComponent(orderId) + "&notificationId=" +
                            encodeURIComponent(notificationId) + "&order_item_id=" +
                            encodeURIComponent(orderItemId);

                        window.location.href = redirectUrl;

                        return false;

                    });
                    $('#order_confirmation_form').on('submit', function() {
                        var formData = $(this).serialize();
                        var urlParams = new URLSearchParams(formData);

                        var orderId = notification.order_id;
                        var orderItemId = notification.order_item_id;
                        var confirmText = urlParams.get('confirm_text').toLowerCase();

                        if (confirmText === "confirm") {
                            var redirectUrl =
                                "{{ url('factory_order_confirm') }}?order_id=" +
                                encodeURIComponent(orderId) + "&notificationId=" +
                                encodeURIComponent(notificationId) + "&order_item_id=" +
                                encodeURIComponent(orderItemId);
                            window.location.href = redirectUrl;
                        } else {
                            alert("Confirm is different with 'Confirm'.");
                        }

                        return false;
                    });

                }

                // If urgent order
                if (notification.is_urgent == 1) {
                    $('#urgent_message').show();
                    if (notification.order_reject_or_confirm == 2 || notification
                        .order_reject_or_confirm == 1) {
                        if (notification.order_reject_or_confirm == 1) {
                            $('#confirm_message p').text("This urgent order was Rejected");
                        } else {
                            $('#confirm_message p').text("This urgent order was Confirmed");
                            $('#in_hand_date p').text('In Hand Due Date : ' + notification
                                .order_in_hand_due_date);
                            $('#ex_factory_date p').text('Ex Factory Date : ' + notification
                                .order_ex_fac_date);
                        }

                        $('#confirm_urgent').hide();
                        $('#reject_urgent').hide();

                    } else {

                        // $('#confirm_message p').text("This is an urgent order. Therefore please confirm the Ex Factory Date.");
                        $('#in_hand_date p').text('In Hand Due Date : ' + notification
                            .order_in_hand_due_date);
                        $('#ex_factory_date p').text('Ex Factory Date : ' + notification
                            .order_ex_fac_date);

                    }

                } else {
                    $('#urgent_message').hide();
                }

                $('#reject_urgent').on('click', function() {
                    $('#rejectModal').modal('show'); // Open the reject modal
                });

                $('#confirm_urgent').on('click', function() {
                    $('#confirmModal').modal('show'); // Open the reject modal
                });

                // Reject button
                $('#rejectOrderButton').click(function() {
                    var rejectReason = $('.reject_reason').val();

                    var suggestedDate = $('#ex_fac_date').val();

                    var orderId = notification.order_id;
                    var orderItemId = notification.order_item_id;

                    var redirectUrl = "{{ url('urgent_order_reject') }}?reject_reason=" +
                        encodeURIComponent(rejectReason) + "&suggested_date=" +
                        encodeURIComponent(suggestedDate) + "&order_id=" +
                        encodeURIComponent(orderId) + "&notificationId=" +
                        encodeURIComponent(notificationId) + "&order_item_id=" +
                        encodeURIComponent(orderItemId);

                    window.location.href = redirectUrl;

                    return false;
                });

                // Confirm button
                $('#confirmOrderButton').click(function() {
                    var orderId = notification.order_id;
                    var orderItemId = notification.order_item_id;
                    var confirmText = $('.confirm_text').val().toLowerCase();

                    if (confirmText === "confirm") {
                        var redirectUrl = "{{ url('urgent_order_confirm') }}?order_id=" +
                            encodeURIComponent(orderId) + "&notificationId=" +
                            encodeURIComponent(notificationId) + "&order_item_id=" +
                            encodeURIComponent(orderItemId);
                        window.location.href = redirectUrl;
                    } else {
                        // Display a message without refreshing the page
                        alert(
                        "Confirm is different with 'Confirm'."); // You can customize the message as needed
                    }

                    return false;
                });


                if (notification.is_comment == 1) {
                    // $('#view_details_btn').attr('href', '{{ url('order_details/edit') }}/'+notification.order_id+'?active_tab=order_mangement&taskId='+notification.task_id+'&comment_mention_id='+notification.comment_mention_id);
                    $('#view_details_btn').attr('href', '{{ url('order_details/edit') }}/' +
                        notification.order_id +
                        '/order?active_tab=order_mangement_tab&taskId=' + notification.task_id +
                        '&comment_mention_id=' + notification.comment_mention_id);
                } else if (notification.activity_id) {
                    $('#view_details_btn').attr('href',
                        '{{ route('activities') }}?open_modal=true&activity_id=' + notification
                        .activity_id);
                } else if (notification.project_id) {
                    $('#view_details_btn').attr('href', '{{ url('projects/view') }}/' +
                        notification.project_id);
                } else if (notification.task_id) {
                    $('#view_details_btn').attr('href',
                        '{{ route('projects.my_tasks') }}?open_chat=true&type="discussion"&discussion_id=' +
                        notification.task_id);
                } else if (notification.sub_task_id) {
                    $('#view_details_btn').attr('href',
                        '{{ route('projects.my_tasks') }}?open_chat=true&type="sub_discussion"&discussion_id=' +
                        notification.sub_task_id);
                } else {
                    if (notification.is_order_edit == 1) {
                        $('#view_details_btn').attr('href', '{{ url('order_details/edit') }}/' +
                            notification.order_id + '/order?active_tab=' + notification
                            .order_item_id + '&notify_field=' + notification.target_field);
                    } else {
                        $('#view_details_btn').attr('href', '{{ url('order_details/edit') }}/' +
                            notification.order_id + '/order?active_tab=order');
                    }
                }

                // unread notification
                $('#unread_btn').click(function() {
                    var id = $(this).attr("id");

                    $.ajax({
                        url: "{{ url('notifications/unread') }}/" + notificationId,
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            location.reload();

                            // var url = window.location.href;
                            // // url += '?interface=notifications'
                            // window.location.href = url;
                        }

                    });

                    return false;
                });
                // delete notification
                $('#delete_btn').click(function() {
                    var id = $(this).attr("id");

                    $.ajax({
                        url: "{{ url('notifications/delete') }}/" + notificationId,
                        method: 'GET',
                        dataType: 'json',
                        beforeSend: function() {
                            $(".se-pre-con").fadeIn();
                        },
                        success: function(data) {
                            console.log(data);
                            location.reload();
                            // var url = window.location.href;
                            // // url += '?interface=notifications'
                            // window.location.href = url;
                        }

                    });

                    return false;
                });

                $('#notification_modal').modal('show');

                if (notification.is_read == 0) {
                    updateNotifiState(notificationId);
                } else {
                    $('#refresh_required').val(0);
                }

                if (check_payment) {
                    var order_no = ('000000' + check_payment.order_id).slice(-6);

                    var check_images = '<a class="check-image" download="' + order_no +
                        '-check-front.jpg" href="{{ asset('uploads') }}/../' + check_payment
                        .check_front + '" title="Check Front">' +
                        '<img src="{{ asset('uploads') }}/../' + check_payment.check_front +
                        '" />' +
                        '</a>' +
                        '<a class="check-image" download="' + order_no +
                        '-check-back.jpg" href="{{ asset('uploads') }}/../' + check_payment
                        .check_back + '" title="Check Back">' +
                        '<img src="{{ asset('uploads') }}/../' + check_payment.check_back +
                        '" />' +
                        '</a>';

                    if (check_payment.is_approved == 0) {
                        var payment_form =
                            '<form method="post" action="{{ route('activities.check_approve') }}" class="col-md-12 mt-3">@csrf' +
                            '<div class="col-md-12 form-field text-center">' +
                            '<input type="number" step="0.01" class="form-control" id="check_amount" name="check_amount" placeholder="Check Amount ($)" required />' +
                            '<button type="submit" class="btn btn-success btn-sm" name="check_payment_id" value="' +
                            check_payment.id + '">Approve</button>'
                        '</div>' +
                        '</form>';
                    } else {
                        var payment_form =
                            '<div class="col-md-12 mt-3"><button type="button" class="btn btn-success btn-sm">Check Approved</button></div>';
                    }

                    $("#check_payment").removeClass('justify-content-center');
                    $('#check_payment').html(check_images + payment_form);
                } else if (other_payment) {
                    var order_no = ('000000' + other_payment.order_id).slice(-6);

                    var check_images = '<a class="check-image" download="' + order_no +
                        '-other-front.jpg" href="{{ asset('uploads') }}/../' + other_payment
                        .document_url + '" title="Check Front">' +
                        '<img src="{{ asset('uploads') }}/../' + other_payment.document_url +
                        '" />' +
                        '</a>' +
                        '<a class="check-image" download="' + order_no +
                        '-other-back.jpg" href="{{ asset('uploads') }}/../' + other_payment
                        .document_url_back + '" title="Check Back">' +
                        '<img src="{{ asset('uploads') }}/../' + other_payment.document_url_back +
                        '" />' +
                        '</a>';

                    // if (other_payment.is_approved == 0) {
                    //     var payment_form = '<form method="post" action="{{ route('activities.check_approve') }}" class="col-md-12 mt-3">@csrf'+
                    //                         '<div class="col-md-12 form-field text-center">'+
                    //                             '<input type="number" step="0.01" class="form-control" id="check_amount" name="check_amount" placeholder="Check Amount ($)" required />'+
                    //                             '<button type="submit" class="btn btn-success btn-sm" name="other_payment_id" value="'+other_payment.id+'">Approve</button>'
                    //                         '</div>'+
                    //                    '</form>';
                    // } else {
                    //     var payment_form = '<div class="col-md-12 mt-3"><button type="button" class="btn btn-success btn-sm">Payment Approved</button></div>';
                    // }
                    var payment_form =
                        '<div class="col-md-12 mt-3"><button type="button" class="btn btn-success btn-sm">Payment Approved</button></div>';

                    $("#check_payment").removeClass('justify-content-center');
                    $('#check_payment').html(check_images + payment_form);
                } else if (venmo_payment) {
                    var order_no = ('000000' + venmo_payment.order_id).slice(-6);

                    var venmo_images = '<a class="check-image" download="' + order_no +
                        '-venmo.jpg" href="{{ asset('uploads') }}/../' + venmo_payment
                        .venmo_receipt + '" title="Venmo Receipt">' +
                        '<img src="{{ asset('uploads') }}/../' + venmo_payment.venmo_receipt +
                        '" />' +
                        '</a>';

                    if (venmo_payment.is_approved == 0) {
                        var payment_form =
                            '<form method="post" action="{{ route('payment.venmo_approve') }}" class="col-md-12 mt-3">@csrf' +
                            '<div class="col-md-12 form-field text-center">' +
                            '<input type="number" step="0.01" class="form-control" id="venmo_amount" name="approve_amount" placeholder="Venmo Amount ($)" required />' +
                            '<button type="submit" class="btn btn-success btn-sm" name="venmo_payment_id" value="' +
                            venmo_payment.id + '">Approve</button>'
                        '</div>' +
                        '</form>';
                    } else {
                        var payment_form =
                            '<div class="col-md-12 mt-3"><button type="button" class="btn btn-success btn-sm">Venmo Approved</button></div>';
                    }

                    $("#check_payment").addClass('justify-content-center');
                    $('#check_payment').html(venmo_images + payment_form);
                } else {
                    $('#check_payment').html('');
                }
            }
        });
    }

    $(document).on('click', '.btn-reject-factory-ex', function() {
        $('#factory_ex_rejectModal').modal('show');
    });
    $(document).on('click', '.btn-confirm-factory-ex', function() {
        $('#factory_ex_confirmModal').modal('show');
    });

    $('#notification_modal').on('hidden.bs.modal', function() {
        if ($('#refresh_required').val() == 1) {
            // var url = window.location.href;
            // // url += '?interface=notifications'
            // window.location.href = url;
            location.reload();
        }
    })

    function updateNotifiState(notificationId) {
        $.ajax({
            url: "{{ url('activities/read_notification') }}/" + notificationId,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#refresh_required').val(1);
                console.log(data);
            }
        });
    }


    function updateMarkread(notificationId) {
        $.ajax({
            url: "{{ url('activities/read_notification') }}/" + notificationId,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#refresh_required').val(1);
                console.log(data);
            }
        });
    }


    $('#markAsRead').click(function(e) {
        e.preventDefault();
        var allid = [];
        $("input:checkbox[name=ids]:checked").each(function() {
            allid.push($(this).val());
        });

        allid = jQuery.grep(allid, function(value) {
            return value != 'on';
        });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ url('notifications/mark_as_read') }}",
            method: 'POST',
            data: {
                allid: allid,
                _token: $("input[name=_token]").val()

            },
            success: function(data) {
                Swal.fire({
                    title: "Done!",
                    text: "Notifications Mark As Read!",
                    type: "success",
                    allowOutsideClick: false,
                }).then(function(isConfirm) {
                    if (isConfirm.value == true) {
                        location.reload();
                    }
                });
                console.log(data);
            }
        });
    });


    $('#unreadSelectedRecords').click(function(e) {
        e.preventDefault();
        var allid = [];
        $("input:checkbox[name=ids]:checked").each(function() {
            allid.push($(this).val());
        });

        allid = jQuery.grep(allid, function(value) {
            return value != 'on';
        });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ url('notifications/mark_as_unread') }}",
            method: 'POST',
            data: {
                allid: allid,
                _token: $("input[name=_token]").val()

            },
            success: function(data) {
                Swal.fire({
                    title: "Done!",
                    text: "Notifications Mark As Unread!",
                    type: "success",
                    allowOutsideClick: false,
                }).then(function(isConfirm) {
                    if (isConfirm.value == true) {
                        location.reload();
                    }
                });
                console.log(data);
            }
        });
    });


    $('#checkAll').click(function(e) {
        var table = $(e.target).closest('table');
        $('td input:checkbox', table).prop('checked', this.checked);
    });
    $(document).on('click', '.add_to_my_list', function() {
        var templateId = $(this).data('template_id');
        $.ajax({
            url: "{{ url('email/templates/add') }}/" + templateId,
            method: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data) {
                $(".se-pre-con").fadeOut('slow');
                Swal.fire({
                    title: 'Success!',
                    text: 'Successfully added to your list.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },

        });
    })

    function loadInitialCounts() {
        $.ajax({
            url: initialCountRoute,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (!response.status) return;

                if (!tabLoaded.unread) {
                    $('#badge-unread').text(response.data.unread);
                }
                if (!tabLoaded.mentions) {
                    $('#badge-mentions').text(response.data.mention);
                }
                if (!tabLoaded.marked) {
                    $('#badge-marked').text(response.data.marked);
                }
            }
        });
    }
</script>

@endsection
