@extends('layouts.app', ['activePage' => 'Employee_Managment', 'titlePage' => __('Employee Permissions')])

@section('content')

@if ($errors->any())
<div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<div class="se-pre-con"></div>

@section('order-header')
<span>EMPLOYEE PERMISSIONS</span>
@endsection

@section('back-btn')
<a href="{{ route('HR.Employee_Managment') }}" class="home-btn-color" title="Back">Back to Employee Management</a>
@endsection

<div class="emp-page-wrapper">
    <style>
        .emp-page-wrapper* {
            box-sizing: border-box
        }

        .emp-page-wrapper {
            font-family: 'Segoe UI', sans-serif;
            background: #f5f6fa;
            min-height: 100vh;
            padding: 0
        }

        .perm-tabs-wrapper {
            background: #fff;
            border-bottom: 1px solid #e8eaf0;
            padding: 0 24px
        }

        .perm-tabs {
            display: flex;
            gap: 0;
            margin: 0;
            padding: 0;
            list-style: none
        }

        .perm-tabs li a {
            display: block;
            padding: 14px 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .7px;
            color: #999;
            text-decoration: none;
            border-bottom: 3px solid transparent;
            transition: all .2s
        }

        .perm-tabs li a:hover {
            color: #444;
            text-decoration: none
        }

        .perm-tabs li.active a {
            color: #1a1a2e;
            border-bottom-color: #1a1a2e
        }

        .perm-content {
            padding: 28px 24px;
            overflow-y: auto;
            max-height: calc(100vh - 220px);
        }

        .tab-panel {
            display: none
        }

        .tab-panel.active {
            display: block
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #707070;
            margin-bottom: 20px
        }

        .perm-search {
            position: relative;
            width: 240px
        }

        .perm-search input {
            width: 100%;
            padding: 7px 12px 7px 34px;
            border: 1px solid #e0e4ef;
            border-radius: 6px;
            font-size: 13px;
            color: #444;
            outline: none;
            background: #fff
        }

        .perm-search input:focus {
            border-color: #aab4d4
        }

        .perm-search svg {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #bbb;
            width: 15px;
            height: 15px
        }

        .perms-grid {
            background: #fff;
            border: 1px solid #e8eaf0;
            border-radius: 8px;
            overflow: hidden
        }

        .perms-grid-inner {
            display: grid;
            grid-template-columns: repeat(5, 1fr)
        }

        .perm-cell {
            padding: 10px 14px;
            font-size: 13px;
            color: #444;
            border-right: 1px solid #f0f2f8;
            border-bottom: 1px solid #f0f2f8;
            line-height: 1.4
        }

        .perm-cell:nth-child(5n) {
            border-right: none
        }

        .perm-cell .num {
            color: #bbb;
            margin-right: 4px;
            font-size: 12px
        }

        .perm-pagination {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 4px;
            margin-top: 16px
        }

        .perm-pagination button {
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
            transition: all .15s
        }

        .perm-pagination button:hover {
            background: #f0f2f8
        }

        .perm-pagination button.active {
            background: #1a1a2e;
            color: #fff;
            border-color: #1a1a2e
        }

        .all-layout {
            display: flex;
            gap: 0;
            background: #fff;
            border: 1px solid #e8eaf0;
            border-radius: 8px;
            overflow: hidden;
            min-height: 480px
        }

        .all-sidebar {
            width: 200px;
            flex-shrink: 0;
            border-right: 1px solid #e8eaf0
        }

        .all-sidebar-header {
            padding: 10px 16px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: #fff;
            background: #707070;
            border-bottom: 1px solid #2e2e4a
        }

        .all-sidebar ul {
            list-style: none;
            margin: 0;
            padding: 0
        }

        .all-sidebar ul li a {
            display: block;
            padding: 11px 18px;
            font-size: 13px;
            color: #555;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all .15s;
            cursor: pointer
        }

        .all-sidebar ul li a:hover {
            background: #f5f6fb;
            color: #1a1a2e;
            text-decoration: none
        }

        .all-sidebar ul li.active a {
            background: #eef0f8;
            color: #1a1a2e;
            border-left-color: #1a1a2e;
            font-weight: 600
        }

        .all-perms-area {
            flex: 1;
            overflow: hidden
        }

        .all-perms-header-label {
            padding: 10px 14px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: #fff;
            background: #707070;
            border-bottom: 1px solid #2e2e4a
        }

        .all-perms-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr)
        }

        .all-perm-cell {
            padding: 10px 14px;
            font-size: 13px;
            color: #444;
            border-right: 1px solid #f0f2f8;
            border-bottom: 1px solid #f0f2f8;
            line-height: 1.4
        }

        .all-perm-cell:nth-child(4n) {
            border-right: none
        }

        .all-perm-cell .num {
            color: #bbb;
            margin-right: 4px;
            font-size: 12px
        }

        .ug-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px 16px;
            background: #fff;
            border: 1px solid #e8eaf0;
            border-radius: 8px;
            padding: 20px
        }

        .ug-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #444;
            cursor: pointer
        }

        .ug-item input[type=checkbox] {
            width: 15px;
            height: 15px;
            accent-color: #26d4a8;
            cursor: pointer;
            flex-shrink: 0
        }

        .ug-item:hover {
            color: #1a1a2e
        }

        .save-row {
            display: flex;
            justify-content: flex-end;
            margin-top: 24px
        }

        .btn-save-updates {
            background: #26d4a8;
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: background .2s
        }

        .btn-save-updates:hover {
            background: #1fba94
        }

        .perm-loading {
            padding: 40px;
            text-align: center;
            color: #aaa;
            font-size: 13px
        }

        .perm-empty {
            padding: 30px;
            text-align: center;
            color: #bbb;
            font-size: 13px;
            font-style: italic
        }

        @media (max-width: 767.98px) {

            .perm-content {
                padding: 16px 12px;
                max-height: none;
            }
            .section-title { font-size: 15px; margin-bottom: 14px; }

            /* ---- Tabs: equal-width segmented bar ---- */
            .perm-tabs-wrapper { padding: 0 8px; }
            .perm-tabs { width: 100%; }
            .perm-tabs li { flex: 1; text-align: center; }
            .perm-tabs li a {
                padding: 12px 4px;
                font-size: 10px;
                letter-spacing: .3px;
            }

            /* ---- TAB: All ---- */
            .all-layout {
                display: block;
                min-height: 0;
            }
            .all-sidebar {
                width: 100%;
                border-right: none;
                border-bottom: none;
            }
            .all-sidebar-header { display: none; }
            .all-sidebar ul {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                padding: 14px;
                border: 1px solid #e8eaf0;
                border-radius: 8px;
            }
            .all-sidebar ul li { flex: 0 0 auto; }
            .all-sidebar ul li a {
                border: 1px solid #e0e4ef;
                border-left: 1px solid #e0e4ef;
                border-radius: 8px;
                padding: 9px 14px;
                font-size: 12.5px;
                color: #555;
            }
            .all-sidebar ul li.active a {
                background: #1a1a2e;
                color: #fff;
                border-color: #1a1a2e;
            }
            .all-perms-area {
                margin-top: 14px;
                border: 1px solid #e8eaf0;
                border-radius: 8px;
                overflow: hidden;
            }
            .all-perms-grid { grid-template-columns: repeat(2, 1fr); }
            .all-perm-cell { font-size: 12.5px; padding: 10px 10px; }

            /* ---- TAB: User Groups Assigned ---- */
            .ug-search-wrap { width: 100%; margin-bottom: 14px; }
            .ug-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
                padding: 14px;
            }
            .ug-item {
                border: 1px solid #e0e4ef;
                border-radius: 8px;
                padding: 10px 12px;
                font-size: 12.5px;
            }
            .ug-item:has(input:checked) {
                background: #eef3ff;
                border-color: #2a6df5;
                color: #2a6df5;
                font-weight: 600;
            }
            .save-row {
                position: sticky;
                bottom: 0;
                background: #f5f6fa;
                padding: 12px 0 4px;
                margin-top: 16px;
            }
            .btn-save-updates {
                width: 100%;
                padding: 13px;
                font-size: 14px;
                border-radius: 8px;
            }

            /* ---- TAB: Permissions Granted ---- */
            #tab-perms-granted .d-flex.align-items-center.justify-content-between {
                flex-direction: row;
                flex-wrap: wrap;
                align-items: center !important;
                gap: 10px;
            }
            #tab-perms-granted .section-title.mb-0 {
                margin-bottom: 0 !important;
            }

            /* Hide the "Show rows per page" label, keep just the dropdown */
            #tab-perms-granted .d-flex.align-items-center.mt-2.mb-2 label {
                display: none;
            }
            #tab-perms-granted .d-flex.align-items-center.mt-2.mb-2 {
                margin: 0 0 0 auto !important;  /* pushes the dropdown to the right */
            }
            #pageSizeSelect {
                width: 64px;
                padding: 5px 6px !important;
            }

            /* Search box drops to its own full-width line below */
            .perm-search {
                width: 100%;
                order: 3;
                margin-top: 4px;
            }

            /* ---- TAB: Permissions Granted grid -> 2 columns ---- */
            .perms-grid-inner {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            .perm-cell {
                font-size: 12.5px;
                padding: 10px 10px;
            }
            .perm-cell:nth-child(5n) {
                border-right: 1px solid #f0f2f8; /* undo the desktop 5-column rule */
            }
            .perm-cell:nth-child(2n) {
                border-right: none; /* last column in each 2-column row */
            }
        }

        
    </style>

    <input type="hidden" id="permUserId" value="{{ $user->id }}">

    <!-- TABS NAV -->
    <div class="perm-tabs-wrapper">
        <ul class="perm-tabs" id="permTabs">
            <li class="active"><a href="#" data-tab="tab-all">All</a></li>
            <li><a href="#" data-tab="tab-user-groups">User Groups Assigned</a></li>
            <li><a href="#" data-tab="tab-perms-granted">Permissions Granted</a></li>
        </ul>
    </div>

    <div class="perm-content">

        <!-- TAB: ALL -->
        <div class="tab-panel active" id="tab-all">
            <div class="section-title">User Groups &amp; Permissions</div>
            <div class="all-layout">
                <div class="all-sidebar">
                    <div class="all-sidebar-header">User Groups Assigned</div>
                    <ul id="groupList">
                        <li><span class="perm-loading">Loading...</span></li>
                    </ul>
                </div>
                <div class="all-perms-area">
                    <div class="all-perms-header-label" style="text-align:left;padding-left:14px;">Permissions Granted</div>
                    <div class="all-perms-grid" id="allPermsGrid">
                        <div class="perm-loading" style="grid-column:1/-1;">Select a group to view permissions</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB: USER GROUPS ASSIGNED -->
       <div class="tab-panel" id="tab-user-groups">
            <div class="section-title">User Groups Assigned</div>
            <div class="perm-search ug-search-wrap">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <path stroke-linecap="round" d="M21 21l-4.35-4.35" />
                </svg>
                <input type="text" id="ugSearch" placeholder="Search by User Groups Assigned" oninput="filterUG()">
            </div>
            <div class="ug-grid" id="ugGrid">
                <div class="perm-loading" style="grid-column:1/-1;">Loading groups...</div>
            </div>
            <div class="save-row">
                <button class="btn-save-updates" id="btnSaveGroups">Save Updates</button>
            </div>
        </div>

        <!-- TAB: PERMISSIONS GRANTED -->
        <div class="tab-panel" id="tab-perms-granted">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="section-title mb-0">Permissions Granted</div>

                <div class="d-flex align-items-center mt-2 mb-2" style="gap: 8px;">
                    <label for="pageSizeSelect" style="font-size:13px; color:#555;">Show rows per page</label>
                    <select id="pageSizeSelect" style="padding:4px 8px; border:1px solid #e0e4ef; border-radius:4px; font-size:13px;">
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="65" selected>65</option>
                        <option value="100">100</option>
                        <option value="200">200</option>
                    </select>
                </div>

                <div class="perm-search">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8" />
                        <path stroke-linecap="round" d="M21 21l-4.35-4.35" />
                    </svg>
                    <input type="text" id="permSearch" placeholder="Search by permission" oninput="filterPerms()">
                </div>
            </div>
            <div class="perms-grid">
                <div class="perms-grid-inner" id="permsGrantedGrid">
                    <div class="perm-loading" style="grid-column:1/-1;">Loading permissions...</div>
                </div>
            </div>
            <div class="perm-pagination" id="permPagination"></div>
        </div>

    </div><!-- /perm-content -->
</div><!-- /emp-page-wrapper -->

<script>
    (function() {
        var USER_ID = document.getElementById('permUserId').value;
        var CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        var userGroupIds = [];
        var userGroupObjs = [];
        var allGroups = [];
        var allPerms = [];
        var groupPermsMap = {};

        var pageSize = 65;
        var currentPage = 1;
        var filteredPerms = [];

        /* ── BOOT ── */
        $.ajax({
            url: "{{ url('employee/get/groups') }}",
            type: 'POST',
            data: {
                userId: USER_ID,
                _token: CSRF
            },
            success: function(res) {
                if (!res.success) {
                    showError('Server error.');
                    return;
                }

                userGroupObjs = res.userGroups || [];
                userGroupIds = userGroupObjs.map(function(g) {
                    return g.id;
                });
                allPerms = (res.permissions || []).slice().sort();

                allGroups = userGroupObjs.concat(res.groups || []);
                allGroups.sort(function(a, b) {
                    return a.name.localeCompare(b.name);
                });

                renderSidebar();
                renderUGGrid();
                renderPermsGranted();
            },
            error: function(xhr) {
                showError('Load failed. Status: ' + xhr.status);
            }
        });

        /* ── TABS ── */
        document.querySelectorAll('#permTabs li a').forEach(function(a) {
            a.addEventListener('click', function(e) {
                e.preventDefault();
                var t = this.getAttribute('data-tab');
                document.querySelectorAll('#permTabs li').forEach(function(li) {
                    li.classList.remove('active');
                });
                this.parentElement.classList.add('active');
                document.querySelectorAll('.tab-panel').forEach(function(p) {
                    p.classList.remove('active');
                });
                document.getElementById(t).classList.add('active');
            });
        });

        /* ── TAB ALL: sidebar ── */
        function renderSidebar() {
            var ul = document.getElementById('groupList');
            ul.innerHTML = '';

            if (!userGroupObjs.length) {
                ul.innerHTML = '<li><span style="padding:12px 18px;display:block;font-size:13px;color:#aaa;">No groups assigned</span></li>';
                return;
            }

            userGroupObjs.forEach(function(group, idx) {
                var li = document.createElement('li');
                if (idx === 0) li.classList.add('active');
                li.innerHTML = '<a href="#" data-gid="' + group.id + '">' + (idx + 1) + '. ' + group.name + '</a>';
                ul.appendChild(li);

                li.querySelector('a').addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelectorAll('#groupList li').forEach(function(l) {
                        l.classList.remove('active');
                    });
                    li.classList.add('active');
                    loadGroupPerms(group.id);
                });
            });

            // Auto-load first group on page load
            loadGroupPerms(userGroupObjs[0].id);
        }

        /* Lazy-load with GET first, POST fallback */
        function loadGroupPerms(groupId) {
            var grid = document.getElementById('allPermsGrid');

            if (groupPermsMap.hasOwnProperty(groupId)) {
                renderAllPerms(groupId);
                return;
            }

            grid.innerHTML = '<div class="perm-loading" style="grid-column:1/-1;">Loading...</div>';

            function tryPost() {
                $.ajax({
                    url: "{{ url('user_groups/userGroupPermissionList') }}",
                    type: 'POST',
                    data: {
                        groupId: groupId,
                        _token: CSRF
                    },
                    success: function(res) {
                        groupPermsMap[groupId] = (res.permission || []).map(function(p) {
                            return p.name;
                        });
                        renderAllPerms(groupId);
                    },
                    error: function(xhr2) {
                        groupPermsMap[groupId] = [];
                        grid.innerHTML = '<div class="perm-empty" style="grid-column:1/-1;color:#e53935;">Failed to load permissions (HTTP ' + xhr2.status + ').<br>Check that the route <code>user_groups/userGroupPermissionList</code> exists in web.php.</div>';
                    }
                });
            }

            $.ajax({
                url: "{{ url('user_groups/userGroupPermissionList') }}",
                type: 'GET',
                data: {
                    groupId: groupId
                },
                success: function(res) {
                    groupPermsMap[groupId] = (res.permission || []).map(function(p) {
                        return p.name;
                    });
                    renderAllPerms(groupId);
                },
                error: function() {
                    tryPost();
                }
            });
        }

        function renderAllPerms(groupId) {
            var grid = document.getElementById('allPermsGrid');
            var perms = groupPermsMap[groupId] || [];
            grid.innerHTML = '';

            if (!perms.length) {
                grid.innerHTML = '<div class="perm-empty" style="grid-column:1/-1;">No permissions for this group.</div>';
                return;
            }
            perms.forEach(function(p, i) {
                var cell = document.createElement('div');
                cell.className = 'all-perm-cell';
                cell.innerHTML = '<span class="num">' + (i + 1) + '.</span>' + p;
                grid.appendChild(cell);
            });
        }

        /* ── TAB USER GROUPS ── */
        function renderUGGrid() {
            var grid = document.getElementById('ugGrid');
            grid.innerHTML = '';
            if (!allGroups.length) {
                grid.innerHTML = '<div class="perm-empty" style="grid-column:1/-1;">No groups found.</div>';
                return;
            }
            allGroups.forEach(function(group) {
                var isChecked = userGroupIds.indexOf(group.id) !== -1;
                var label = document.createElement('label');
                label.className = 'ug-item';
                label.innerHTML = '<input type="checkbox" name="user_groups[]" value="' + group.id + '"' + (isChecked ? ' checked' : '') + '>' + group.name;
                grid.appendChild(label);
            });
        }

        document.getElementById('btnSaveGroups').addEventListener('click', function() {
            var checked = [];
            document.querySelectorAll('#ugGrid input[type="checkbox"]:checked').forEach(function(cb) {
                checked.push(parseInt(cb.value));
            });
            var toAdd = checked.filter(function(id) {
                return userGroupIds.indexOf(id) === -1;
            });
            var toRemove = userGroupIds.filter(function(id) {
                return checked.indexOf(id) === -1;
            });
            var ops = [];
            toAdd.forEach(function(gid) {
                ops.push($.ajax({
                    url: "{{ url('user_groups/update_members/add') }}",
                    type: 'POST',
                    data: {
                        user: USER_ID,
                        user_group_members_group_id: gid,
                        _token: CSRF
                    }
                }));
            });
            toRemove.forEach(function(gid) {
                ops.push($.ajax({
                    url: "{{ url('user_groups/update_members/delete') }}",
                    type: 'POST',
                    data: {
                        user: USER_ID,
                        user_group_members_group_id: gid,
                        _token: CSRF
                    }
                }));
            });
            if (!ops.length) {
                Swal.fire('No changes', 'Nothing to update.', 'info');
                return;
            }
            $.when.apply($, ops)
                .done(function() {
                    Swal.fire('Saved!', 'User groups updated.', 'success').then(function() {
                        location.reload();
                    });
                })
                .fail(function() {
                    Swal.fire('Error!', 'Something went wrong.', 'error');
                });
        });

        /* ── TAB PERMISSIONS GRANTED ── */
        function renderPermsGranted() {
            filteredPerms = allPerms.slice();
            currentPage = 1;
            renderPermsPage();
        }

        function renderPermsPage() {
            var grid = document.getElementById('permsGrantedGrid');
            grid.innerHTML = '';
            if (!filteredPerms.length) {
                grid.innerHTML = '<div class="perm-empty" style="grid-column:1/-1;">No permissions found.</div>';
                renderPagination();
                return;
            }
            var start = (currentPage - 1) * pageSize;
            filteredPerms.slice(start, start + pageSize).forEach(function(p, i) {
                var cell = document.createElement('div');
                cell.className = 'perm-cell';
                cell.innerHTML = '<span class="num">' + (start + i + 1) + '.</span>' + p;
                grid.appendChild(cell);
            });
            renderPagination();
        }

        function renderPagination() {
            var total = Math.ceil(filteredPerms.length / pageSize);
            var wrap = document.getElementById('permPagination');
            wrap.innerHTML = '';
            if (total <= 1) return;
            var prev = document.createElement('button');
            prev.innerHTML = '&#8249;';
            prev.disabled = currentPage === 1;
            prev.addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderPermsPage();
                }
            });
            wrap.appendChild(prev);
            for (var i = 1; i <= total; i++) {
                (function(pg) {
                    var btn = document.createElement('button');
                    btn.textContent = pg;
                    if (pg === currentPage) btn.classList.add('active');
                    btn.addEventListener('click', function() {
                        currentPage = pg;
                        renderPermsPage();
                    });
                    wrap.appendChild(btn);
                })(i);
            }
            var next = document.createElement('button');
            next.innerHTML = '&#8250;';
            next.disabled = currentPage === total;
            next.addEventListener('click', function() {
                if (currentPage < total) {
                    currentPage++;
                    renderPermsPage();
                }
            });
            wrap.appendChild(next);
        }

        window.filterPerms = function() {
            var q = document.getElementById('permSearch').value.toLowerCase();
            filteredPerms = allPerms.filter(function(p) {
                return p.toLowerCase().indexOf(q) !== -1;
            });
            currentPage = 1;
            renderPermsPage();
        };

        // ── PAGE SIZE DROPDOWN ──
        document.getElementById('pageSizeSelect').addEventListener('change', function() {
            pageSize = parseInt(this.value, 10);
            currentPage = 1;
            renderPermsPage();
        });

        function showError(msg) {
            document.getElementById('groupList').innerHTML = '<li><span style="padding:12px 18px;display:block;font-size:13px;color:red;">' + msg + '</span></li>';
            document.getElementById('ugGrid').innerHTML = '<div style="grid-column:1/-1;color:red;padding:20px;">' + msg + '</div>';
            document.getElementById('permsGrantedGrid').innerHTML = '<div style="grid-column:1/-1;color:red;padding:20px;">' + msg + '</div>';
        }

    })();

    window.filterUG = function() {
        var q = document.getElementById('ugSearch').value.toLowerCase();
        document.querySelectorAll('#ugGrid .ug-item').forEach(function(item) {
            var text = item.textContent.toLowerCase();
            item.style.display = text.indexOf(q) !== -1 ? '' : 'none';
        });
    };
</script>

@endsection