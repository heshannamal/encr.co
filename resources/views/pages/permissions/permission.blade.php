@extends('layouts.app', ['activePage' => 'user_permissions', 'titlePage' => __('User Permissions')])

@section('content')

<style>
    /* RESET – isolate from parent layout styles */
    .up-wrap * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    /* PAGE WRAPPER */
    .up-wrap {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        font-size: 13px;
        color: #1a1a1a;
        background: #f4f4f4;
        min-height: 100vh;
    }

    /* Bell icon */
    .up-bell {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #444;
    }

    .up-bell i {
        font-size: 17px;
    }

    .up-bell__badge {
        position: absolute;
        top: -5px;
        right: -6px;
        background: #e53935;
        color: #fff;
        font-size: 9px;
        font-weight: 700;
        line-height: 1;
        border-radius: 9px;
        min-width: 17px;
        height: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 3px;
    }

    /* Avatar */
    .up-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #c9c9c9;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        overflow: hidden;
    }

    .up-avatar i {
        font-size: 16px;
        color: #fff;
    }

    .up-chevron {
        font-size: 10px;
        color: #888;
        cursor: pointer;
        margin-left: -4px;
    }

    /* SECONDARY TOOLBAR (EXPORT + ADD BUTTON ROW) */
    .up-toolbar {
        background: #f4f4f4;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding: 10px 20px;
        gap: 12px;
        border-bottom: 1px solid #e2e2e2;
    }

    .up-btn-export {
        background: none;
        border: none;
        color: #777777;
        background-color: #dfdcdc;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        cursor: pointer;
        padding: 6px 10px;
        border-radius: 4px;
        transition: color 0.15s, background 0.15s;
    }

    .up-btn-export:hover {
        color: #333;
        background: #ebebeb;
    }

    .up-btn-add {
        background: #3ecf6e;
        color: #ffffff;
        border: none;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.4px;
        text-transform: uppercase;
        padding: 8px 16px;
        border-radius: 5px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: background 0.15s;
        white-space: nowrap;
    }

    .up-btn-add:hover {
        background: #2db85b;
    }

    .up-btn-add__plus {
        font-size: 16px;
        font-weight: 700;
        line-height: 1;
    }

    /* TABLE CONTROLS ROW (rows-per-page + search) */
    .up-controls {
        background: #f4f4f4;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 20px 8px;
        gap: 12px;
    }

    /* Rows per page */
    .up-rpp {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 13px;
        color: #555;
        white-space: nowrap;
    }

    .up-rpp__select {
        border: 1px solid #cccccc;
        border-radius: 4px;
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='9' height='5'%3E%3Cpath d='M0 0l4.5 5L9 0z' fill='%23666'/%3E%3C/svg%3E") no-repeat right 7px center;
        padding: 4px 24px 4px 8px;
        font-size: 13px;
        color: #333;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        cursor: pointer;
        outline: none;
    }

    .up-rpp__select:focus {
        border-color: #3ecf6e;
    }

    /* Search */
    .up-search {
        position: relative;
        width: 240px;
    }

    .up-search__icon {
        position: absolute;
        left: 9px;
        top: 50%;
        transform: translateY(-50%);
        color: #aaaaaa;
        font-size: 13px;
        pointer-events: none;
    }

    .up-search__input {
        width: 100%;
        border: 1px solid #cccccc;
        border-radius: 4px;
        padding: 6px 10px 6px 30px;
        font-size: 13px;
        color: #333;
        background: #fff;
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .up-search__input:focus {
        border-color: #3ecf6e;
        box-shadow: 0 0 0 3px rgba(62, 207, 110, 0.15);
    }

    .up-search__input::placeholder {
        color: #bbbbbb;
    }

    /* TABLE CONTAINER */
    .up-table-wrap {
        margin: 0 20px 0;
        background: #ffffff;
        border: 1px solid #e2e2e2;
        border-radius: 4px;
        overflow: hidden;
    }

    .up-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    /* ── THEAD ── */
    .up-table thead tr {
        background: #616161;
    }

    .up-table thead th {
        color: #ffffff;
        font-weight: 600;
        font-size: 11.5px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        padding: 11px 14px;
        border: none;
        white-space: nowrap;
        cursor: pointer;
        user-select: none;
        -webkit-user-select: none;
    }

    .up-table thead th:first-child {
        padding-left: 16px;
    }

    .up-th-inner {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    /* Sort arrows */
    .up-sort {
        display: inline-flex;
        flex-direction: column;
        gap: 1px;
        vertical-align: middle;
        opacity: 0.55;
        flex-shrink: 0;
    }

    .up-sort .a-up,
    .up-sort .a-dn {
        display: block;
        width: 0;
        height: 0;
    }

    .up-sort .a-up {
        border-left: 3.5px solid transparent;
        border-right: 3.5px solid transparent;
        border-bottom: 4px solid #fff;
    }

    .up-sort .a-dn {
        border-left: 3.5px solid transparent;
        border-right: 3.5px solid transparent;
        border-top: 4px solid #fff;
    }

    .up-table thead th:hover .up-sort {
        opacity: 1;
    }

    .up-table thead th.sort-asc .up-sort .a-up,
    .up-table thead th.sort-desc .up-sort .a-dn {
        opacity: 1;
    }

    /* ── Column widths ── */
    .up-table .col-perm {
        width: 30%;
    }

    .up-table .col-groups {
        width: 22%;
        text-align: center;
    }

    .up-table .col-created {
        width: 18%;
    }

    .up-table .col-updated {
        width: 18%;
    }

    .up-table .col-actions {
        width: 12%;
        text-align: center;
    }

    /* ── TBODY ── */
    .up-table tbody tr {
        border-bottom: 1px solid #eeeeee;
        transition: background 0.1s;
    }

    .up-table tbody tr:last-child {
        border-bottom: none;
    }

    .up-table tbody tr:hover {
        background: #f9f9f9;
    }

    .up-table tbody td {
        padding: 10px 14px;
        color: #2a2a2a;
        vertical-align: middle;
    }

    .up-table tbody td:first-child {
        padding-left: 16px;
    }

    /* Permission name link */
    .up-perm-link {
        color: #1a1a1a;
        text-decoration: none;
        font-weight: 500;
        font-size: 13px;
    }

    .up-perm-link:hover {
        color: #2db85b;
        text-decoration: none;
    }

    /* Groups count centered */
    .up-table tbody td.col-groups {
        text-align: center;
        color: #444;
        font-size: 13px;
    }

    /* Date cells */
    .up-table tbody td.col-created,
    .up-table tbody td.col-updated {
        color: #555;
        font-size: 13px;
    }

    /* ── Action buttons ── */
    .up-table tbody td.col-actions {
        text-align: center;
    }

    .up-act-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px 5px;
        border-radius: 3px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: background 0.15s;
    }

    .up-act-btn.up-act-edit {
        color: #666666;
    }

    .up-act-btn.up-act-edit:hover {
        background: #eef6f0;
        color: #2db85b;
    }

    .up-act-btn.up-act-del {
        color: #e53935;
    }

    .up-act-btn.up-act-del:hover {
        background: #fdecea;
    }

    .up-act-btn svg {
        width: 15px;
        height: 15px;
        pointer-events: none;
    }

    /* FOOTER (showing info + pagination) */
    .up-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 20px;
        font-size: 12.5px;
        color: #777777;
        background: #f4f4f4;
        /* stick above the layout's fixed/sticky footer */
        position: relative;
        z-index: 10;
        margin-bottom: 60px;
        /* clearance for the layout footer bar */
    }

    .up-showing {
        white-space: nowrap;
    }

    /* Pagination */
    .up-pager {
        display: flex;
        align-items: center;
        gap: 3px;
    }

    .up-pager__btn {
        border: 1px solid #d8d8d8;
        background: #ffffff;
        color: #555555;
        min-width: 28px;
        height: 28px;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12.5px;
        cursor: pointer;
        transition: background 0.12s, color 0.12s, border-color 0.12s;
        padding: 0 4px;
    }

    .up-pager__btn:hover:not(:disabled):not(.active) {
        background: #f0f0f0;
        border-color: #bbbbbb;
    }

    .up-pager__btn.active {
        background: #4a4a4a;
        color: #ffffff;
        border-color: #4a4a4a;
        font-weight: 600;
    }

    .up-pager__btn:disabled {
        opacity: 0.35;
        cursor: default;
    }

    .up-pager__btn.arrow {
        font-size: 14px;
    }

    /* EMPTY STATE */
    .up-empty-row td {
        text-align: center;
        padding: 40px 20px !important;
        color: #aaaaaa;
        font-size: 13px;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .up-table-wrap {
            margin: 0 10px;
        }

        .up-controls,
        .up-toolbar,
        .up-footer {
            padding-left: 10px;
            padding-right: 10px;
        }

        .up-table thead th,
        .up-table tbody td {
            padding: 9px 8px;
            font-size: 12px;
        }

        .up-table .col-created,
        .up-table thead th:nth-child(3) {
            display: none;
        }

        .up-search {
            width: 160px;
        }
    }

        .up-toggle-trigger {
        display: none;
    }

    @media (max-width: 767px) {

        .up-wrap {
            display: flex;
            flex-direction: column;
        }

        .up-controls {
            order: 1; /* search box now comes first */
        }

        .up-toolbar {
            order: 2; /* Export CSV / Add Permission buttons come second */
        }

        .up-table-wrap {
            order: 3;
        }

        .up-footer {
            order: 4; /* showing-count + pagination stay at the bottom, as usual */
        }

        /* ---------- Search + rows-per-page row ---------- */
        .up-controls {
            flex-direction: column;
            align-items: stretch;
            gap: 8px;
            padding: 10px 10px 4px;
        }

        .up-rpp {
            display: none !important;
        }

        .up-search {
            width: 100% !important;
        }

        .up-search__input {
            width: 100%;
            box-sizing: border-box;
            border-radius: 10px;
            padding: 10px 14px 10px 32px;
            font-size: 14px;
        }

        /* ---------- Export CSV / Add Permission button row ---------- */
        .up-toolbar {
            justify-content: stretch;
            gap: 10px;
            padding: 4px 10px 10px;
            border-bottom: none;
        }

        .up-btn-export,
        .up-btn-add {
            flex: 1 1 0;
            min-width: 0;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            padding: 10px 6px;
            font-size: 12px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* ---------- Table container: becomes a stack of cards ---------- */
        .up-table-wrap {
            margin: 4px 10px 0;
            background: transparent;
            border: none;
            border-radius: 0;
            overflow: visible;
        }

        .up-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .up-table thead {
            display: none;
        }

        .up-table,
        .up-table tbody {
            display: block;
            width: 100%;
        }

        /* ---------- Each row becomes one card ---------- */
        .up-table tbody tr {
            position: relative;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 14px;
            padding-right: 44px;
            margin-bottom: 10px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        }

        .up-table tbody td {
            display: block;
            border: none !important;
            padding: 0 !important;
            box-sizing: border-box;
        }

        .up-table tbody td.col-perm {
            order: 1;
            flex: 1 1 100%;
            width: 100%;
        }

        .up-perm-link {
            font-size: 14px;
            font-weight: 600;
        }

        .up-toggle-trigger {
            position: absolute;
            top: 12px;
            right: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            border: none;
            border-radius: 50%;
            background: #f0f1f4;
            cursor: pointer;
            padding: 0;
        }

        .up-toggle-trigger .up-chevron-icon {
            width: 14px;
            height: 14px;
            stroke: #555;
            transition: transform 0.15s ease;
        }

        .up-table tbody tr.up-row-expanded {
            border: 1px solid #3ecf6e;
            box-shadow: 0 2px 8px rgba(62, 207, 110, 0.15) !important;
        }

        .up-table tbody td.col-groups {
            order: 2;
            flex: 1 1 auto;
            width: auto;
            text-align: left !important;
            font-size: 11px;
            color: #020202;
            margin-top: 6px;
        }

        .up-table tbody td.col-groups::before {
            content: "Number of assigned groups: ";
        }

        .up-table tbody td.col-actions {
            order: 3;
            flex: 0 0 auto;
            width: auto;
            margin-top: 6px;
            display: flex !important;
            align-items: center;
            justify-content: flex-end;
            gap: 4px;
        }

        /* ---------- Created / Last Updated boxes ---------- */
        .up-table tbody td.col-created,
        .up-table tbody td.col-updated {
            display: none !important;
            position: relative;
            flex: 1 1 calc(50% - 5px);
            background: #F2F3F4 !important;
            border-radius: 8px;
            padding: 8px 10px 8px 38px !important;
            font-size: 12px;
            color: #444;
            margin-top: 10px;
            box-sizing: border-box;
        }

        .up-table tbody tr.up-row-expanded td.col-created,
        .up-table tbody tr.up-row-expanded td.col-updated {
            display: block !important;
        }

        .up-table tbody td.col-created {
            order: 4;
            margin-right: 10px;
        }

        .up-table tbody td.col-updated {
            order: 5;
        }

        /* Small uppercase labels above each date */
        .up-table tbody td.col-created::before,
        .up-table tbody td.col-updated::before {
            display: block;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: #999;
            margin-bottom: 2px;
        }

        .up-table tbody td.col-created::before {
            content: "Created";
        }

        .up-table tbody td.col-updated::before {
            content: "Last Updated";
        }

        /* Icon badge — white rounded square with calendar/clock icon inside it */
        .up-table tbody td.col-created::after,
        .up-table tbody td.col-updated::after {
            content: "";
            position: absolute;
            left: 8px;
            top: 8px;
            width: 20px;
            height: 20px;
            background-color: #FFFFFF;
            border-radius: 6px;
            background-repeat: no-repeat;
            background-position: center;
            background-size: 12px 12px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
        }

        .up-table tbody td.col-created::after {
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23999999' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><rect x='3' y='4' width='18' height='18' rx='2' ry='2'></rect><line x1='16' y1='2' x2='16' y2='6'></line><line x1='8' y1='2' x2='8' y2='6'></line><line x1='3' y1='10' x2='21' y2='10'></line></svg>");
        }

        .up-table tbody td.col-updated::after {
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23999999' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><circle cx='12' cy='12' r='10'></circle><polyline points='12 6 12 12 16 14'></polyline></svg>");
        }

        /* Edit/Delete icons get a white rounded background */
        .up-table tbody td.col-actions .up-act-btn.up-act-edit,
        .up-table tbody td.col-actions .up-act-btn.up-act-del {
            background-color: #FFFFFF !important;
            border-radius: 6px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
        }

        /* ---------- Footer: showing text + pagination ---------- */
        .up-footer {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
            padding: 10px;
        }

        .up-pager {
            justify-content: center;
            flex-wrap: wrap;
        }

        .back_home_mobile {
            padding-left: 12px;
            padding-bottom: 12px;
        }

        .up-btn-add {
            background: #14B8A6
        }

        #permission_delete_modal .modal-content {
            margin-left: 7px;
            margin-right: 7px;
        }
        .up-table tbody td.col-actions {
            margin-right: -30px;
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
<span>EMPLOYEE PERMISSION</span>
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

<div class="up-wrap">

    {{-- ── EXPORT / ADD BUTTON TOOLBAR ── --}}
    <div class="up-toolbar">
        <button class="up-btn-export" onclick="exportCSV()">EXPORT CSV</button>
        <button class="up-btn-add" data-toggle="modal" data-target="#permission_create_modal">
            <span class="up-btn-add__plus">+</span> ADD PERMISSION
        </button>
    </div>

    {{-- ── CONTROLS ROW ── --}}
    <div class="up-controls">
        <div class="up-rpp">
            Show rows per page
            <select class="up-rpp__select" id="up-page-len" onchange="onPageLenChange(this.value)">
                <option value="10">10</option>
                <option value="25" selected>25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="up-search">
            <i class="fas fa-search up-search__icon"></i>
            <input
                type="text"
                class="up-search__input"
                id="up-search"
                placeholder="Search by permission name"
                oninput="onSearch(this.value)" />
        </div>
    </div>

    {{-- ── TABLE ── --}}
    <div class="up-table-wrap">
        <table class="up-table" id="up-table">
            <thead>
                <tr>
                    <th class="col-perm" onclick="onSort(0)" id="th-0">
                        <span class="up-th-inner">USER PERMISSIONS <span class="up-sort"><span class="a-up"></span><span class="a-dn"></span></span></span>
                    </th>
                    <th class="col-groups" onclick="onSort(1)" id="th-1">
                        <span class="up-th-inner">NUMBER OF ASSIGNED GROUPS <span class="up-sort"><span class="a-up"></span><span class="a-dn"></span></span></span>
                    </th>
                    <th class="col-created" onclick="onSort(2)" id="th-2">
                        <span class="up-th-inner">CREATED AT <span class="up-sort"><span class="a-up"></span><span class="a-dn"></span></span></span>
                    </th>
                    <th class="col-updated" onclick="onSort(3)" id="th-3">
                        <span class="up-th-inner">UPDATED AT <span class="up-sort"><span class="a-up"></span><span class="a-dn"></span></span></span>
                    </th>
                    <th class="col-actions" onclick="onSort(4)" id="th-4">
                        <span class="up-th-inner">ACTIONS <span class="up-sort"><span class="a-up"></span><span class="a-dn"></span></span></span>
                    </th>
                </tr>
            </thead>
            <tbody id="up-tbody">
                @forelse ($userPermissions as $userPermission)
                <tr
                    data-id="{{ $userPermission->id }}"
                    data-name="{{ strtolower($userPermission->name) }}"
                    data-groups="{{ $userPermission->groups_count ?? 0 }}"
                    data-created="{{ $userPermission->created_at ? $userPermission->created_at->timestamp : 0 }}"
                    data-updated="{{ $userPermission->updated_at ? $userPermission->updated_at->timestamp : 0 }}">
                    <td class="col-perm">
                        <a href="#" class="up-perm-link up-view-trigger" data-id="{{ $userPermission->id }}">
                            {{ $userPermission->name }}
                        </a>
                    </td>
                    <td class="col-groups">{{ $userPermission->roles->count() }}</td>
                    <td class="col-created">{{ $userPermission->created_at ? $userPermission->created_at->format('d M Y') : '-' }}</td>
                    <td class="col-updated">{{ $userPermission->updated_at ? $userPermission->updated_at->format('d M Y') : '-' }}</td>
                    <td class="col-actions">
                        @php
                        $affectedUserIds = collect();
                        foreach ($userPermission->roles as $role) {
                        $affectedUserIds = $affectedUserIds->merge(
                        $role->users()->pluck('id')
                        );
                        }
                        $totalAffectedUsers = $affectedUserIds->unique()->count();
                        @endphp
                    
                        <button type="button" class="up-act-btn up-toggle-trigger" title="Expand">
                            <svg class="up-chevron-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                    
                        <button class="up-act-btn up-act-edit up-edit-trigger"
                            data-id="{{ $userPermission->id }}"
                            title="Edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                        </button>
                        {{-- Delete — NOTE: NO 'delete' class to avoid jQuery .delete selector conflict --}}
                        <button class="up-act-btn up-act-del up-delete-trigger"
                            data-id="{{ $userPermission->id }}"
                            data-name="{{ addslashes($userPermission->name) }}"
                            data-groups="{{ $userPermission->roles->count() }}"
                            data-users="{{ $totalAffectedUsers }}"
                            title="Delete">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6" />
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                <path d="M10 11v6M14 11v6" />
                                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                            </svg>
                        </button>
                    </td>
                </tr>
                @empty
                <tr class="up-empty-row">
                    <td colspan="5">No permissions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ── FOOTER: showing info + pagination ── --}}
    <div class="up-footer">
        <span class="up-showing" id="up-showing">Showing 1 - 50 of 212 results</span>
        <div class="up-pager" id="up-pager"></div>
    </div>

</div>

{{-- Existing modals --}}
@include('pages.permissions.permission_create')
@include('pages.permissions.permission_edit')
@include('pages.permissions.permission_user_edit')
@include('pages.permissions.permission_delete')
@include('pages.permissions.permission_view')


<script>
    (function() {
        /* ─── State ─── */
        var allRows = [];
        var filteredRows = [];
        var pageLen = 50;
        var currentPage = 1;
        var sortColIdx = -1;
        var sortAsc = true;

        /* ─── Boot ─── */
        document.addEventListener('DOMContentLoaded', function() {
            // Collect all data rows
            allRows = Array.from(document.querySelectorAll('#up-tbody tr[data-id]'));
            filteredRows = allRows.slice();
            renderPage();

            // Edit trigger delegation (link + pencil button)
            document.getElementById('up-tbody').addEventListener('click', function(e) {
                // ── View (permission name link) ──
                var viewTrigger = e.target.closest('.up-view-trigger');
                if (viewTrigger) {
                    e.preventDefault();
                    var id = viewTrigger.getAttribute('data-id');
                    openPermissionView(id);
                    return;
                }
                // ── Edit (pencil icon) ──
                var editTrigger = e.target.closest('.up-edit-trigger');
                if (editTrigger) {
                    e.preventDefault();
                    var id = editTrigger.getAttribute('data-id');
                    openEdit(id);
                    return;
                }
                // ── Delete ──
                var delTrigger = e.target.closest('.up-delete-trigger');
                if (delTrigger) {
                    e.preventDefault();
                    var id = delTrigger.getAttribute('data-id');
                    var name = delTrigger.getAttribute('data-name');
                    var groups = delTrigger.getAttribute('data-groups');
                    var users = delTrigger.getAttribute('data-users');
                    confirmDelete(id, name, groups, users);
                }
            });
        });

        /* ─── Public helpers (called inline from HTML) ─── */
        window.onPageLenChange = function(val) {
            pageLen = parseInt(val, 10);
            currentPage = 1;
            renderPage();
        };

        window.onSearch = function(val) {
            var q = val.toLowerCase().trim();
            filteredRows = allRows.filter(function(r) {
                return r.getAttribute('data-name').indexOf(q) !== -1;
            });
            currentPage = 1;
            renderPage();
        };

        window.onSort = function(colIdx) {
            // Update header classes
            var ths = document.querySelectorAll('#up-table thead th');
            ths.forEach(function(th, i) {
                th.classList.remove('sort-asc', 'sort-desc');
            });

            if (sortColIdx === colIdx) {
                sortAsc = !sortAsc;
            } else {
                sortColIdx = colIdx;
                sortAsc = true;
            }

            ths[colIdx].classList.add(sortAsc ? 'sort-asc' : 'sort-desc');

            filteredRows.sort(function(a, b) {
                var aVal, bVal;
                switch (colIdx) {
                    case 0:
                        aVal = a.getAttribute('data-name');
                        bVal = b.getAttribute('data-name');
                        break;
                    case 1:
                        aVal = parseInt(a.getAttribute('data-groups'), 10) || 0;
                        bVal = parseInt(b.getAttribute('data-groups'), 10) || 0;
                        break;
                    case 2:
                        aVal = parseInt(a.getAttribute('data-created'), 10) || 0;
                        bVal = parseInt(b.getAttribute('data-created'), 10) || 0;
                        break;
                    case 3:
                        aVal = parseInt(a.getAttribute('data-updated'), 10) || 0;
                        bVal = parseInt(b.getAttribute('data-updated'), 10) || 0;
                        break;
                    default:
                        return 0;
                }
                if (aVal < bVal) return sortAsc ? -1 : 1;
                if (aVal > bVal) return sortAsc ? 1 : -1;
                return 0;
            });

            currentPage = 1;
            renderPage();
        };

        /* ─── Internal ─── */
        function openEdit(id) {
            var permIdEl = document.getElementById('permission_id');
            if (permIdEl) permIdEl.value = id;
            if (typeof $ !== 'undefined') {
                $('#permission_edit_modal').modal('show');
            }
        }

        function renderPage() {
            var tbody = document.getElementById('up-tbody');
            var total = filteredRows.length;
            var start = (currentPage - 1) * pageLen;
            var end = Math.min(start + pageLen, total);
            var slice = filteredRows.slice(start, end);

            // Remove all rows
            while (tbody.firstChild) tbody.removeChild(tbody.firstChild);

            if (slice.length === 0) {
                var emptyTr = document.createElement('tr');
                emptyTr.className = 'up-empty-row';
                emptyTr.innerHTML = '<td colspan="5">No permissions found.</td>';
                tbody.appendChild(emptyTr);
            } else {
                slice.forEach(function(r) {
                    tbody.appendChild(r);
                });
            }

            renderShowing(start + 1, end, total);
            renderPager(total);
        }

        function renderShowing(from, to, total) {
            var el = document.getElementById('up-showing');
            if (!el) return;
            if (total === 0) {
                el.textContent = 'Showing 0 results';
            } else {
                el.textContent = 'Showing ' + from + ' - ' + to + ' of ' + total + ' results';
            }
        }

        function renderPager(total) {
            var pager = document.getElementById('up-pager');
            if (!pager) return;
            var totalPages = Math.max(1, Math.ceil(total / pageLen));
            var html = '';

            // Prev arrow
            html += '<button class="up-pager__btn arrow" onclick="goPage(' + (currentPage - 1) + ')"' +
                (currentPage === 1 ? ' disabled' : '') + '>&#8249;</button>';

            // Page numbers — show up to 5 around current
            var range = pageRange(currentPage, totalPages);
            range.forEach(function(p) {
                if (p === '…') {
                    html += '<button class="up-pager__btn" disabled style="border:none;background:none;color:#999;">…</button>';
                } else {
                    html += '<button class="up-pager__btn' + (p === currentPage ? ' active' : '') +
                        '" onclick="goPage(' + p + ')">' + p + '</button>';
                }
            });

            // Next arrow
            html += '<button class="up-pager__btn arrow" onclick="goPage(' + (currentPage + 1) + ')"' +
                (currentPage === totalPages ? ' disabled' : '') + '>&#8250;</button>';

            pager.innerHTML = html;
        }

        function pageRange(current, total) {
            if (total <= 7) {
                var r = [];
                for (var i = 1; i <= total; i++) r.push(i);
                return r;
            }
            var pages = [];
            if (current <= 4) {
                pages = [1, 2, 3, 4, 5, '…', total];
            } else if (current >= total - 3) {
                pages = [1, '…', total - 4, total - 3, total - 2, total - 1, total];
            } else {
                pages = [1, '…', current - 1, current, current + 1, '…', total];
            }
            return pages;
        }

        window.goPage = function(p) {
            var total = filteredRows.length;
            var totalPages = Math.max(1, Math.ceil(total / pageLen));
            if (p < 1 || p > totalPages) return;
            currentPage = p;
            renderPage();
        };

        window.exportCSV = function() {
            var rows = [
                ['User Permissions', 'Number of Assigned Groups', 'Created At', 'Updated At']
            ];
            allRows.forEach(function(r) {
                var cells = r.querySelectorAll('td');
                rows.push([
                    '"' + (cells[0] ? cells[0].textContent.trim() : '') + '"',
                    '"' + (cells[1] ? cells[1].textContent.trim() : '') + '"',
                    '"' + (cells[2] ? cells[2].textContent.trim() : '') + '"',
                    '"' + (cells[3] ? cells[3].textContent.trim() : '') + '"'
                ]);
            });
            var csv = rows.map(function(r) {
                return r.join(',');
            }).join('\n');
            var blob = new Blob([csv], {
                type: 'text/csv;charset=utf-8;'
            });
            var url = URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = 'user_permissions.csv';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        };

        // Update page title in legacy layout
        if (document.getElementById('header')) {
            document.getElementById('header').innerHTML = 'EMPLOYEE PERMISSIONS';
        }
    }());
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tbody = document.getElementById('up-tbody');
        if (!tbody) return;
 
        tbody.addEventListener('click', function (e) {
            var toggleBtn = e.target.closest('.up-toggle-trigger');
            if (!toggleBtn) return;
 
            e.preventDefault();
            e.stopPropagation();
 
            var row = toggleBtn.closest('tr');
            if (!row) return;
 
            row.classList.toggle('up-row-expanded');
        });
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