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
            background: #f8f8f8;
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

        @media (max-width:768px) {
            .notifications-container {
                padding: 0 12px;
            }

            .notif-source {
                min-width: 120px;
                max-width: 140px;
            }

            .action-btn {
                font-size: 10px;
                padding: 5px 8px;
            }
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
        all: "{{ route('get.all.notifications') }}",
        unread: "{{ route('get.all.unread.notifications') }}",
        mentions: "{{ route('get.all.mention.notifications') }}",
        marked: "{{ route('get.all.marked.notifications') }}",
    };

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
        let onclick = '';
        console.log(item.modal_type);
        

        const badge = item.badge ?
            `<span class="order-badge ${item.badge_red ? 'badge-red' : ''}">
                <span class="dot ${item.badge_red ? 'dot-red' : ''}"></span>${item.badge}
            </span>` :
            '';

        const chkId = `chk_${tab}_${item.id}`;

        return `
        <div class="notif-row ${item.is_read ? 'read' : 'unread'} openNotification" data-notification-id="${item.id}" data-id="${item.id}">
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
                }
            },
            error: function() {
                console.log(error);

            }
        });
    }
</script>


<script>
    $(document).on('click', '.openNotification', function (e) {
        const id = $(this).data('notification-id');
        openNotificationModal(id);
    });
</script>

@endsection
