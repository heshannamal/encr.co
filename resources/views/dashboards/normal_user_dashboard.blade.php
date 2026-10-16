@extends('layouts.app', ['activePage' => 'user_dashboard', 'titlePage' => __('Normal User Dashboard')])



@section('content')

    @section('order-header')
        <span>Dashboard</span>
    @endsection


        <!-- DataTables JS (load after jQuery) -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <style>
        /* @import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;500;600;700&display=swap'); */

        /* * {
                            font-family: 'Roboto Condensed', sans-serif;
                        }

                        body {
                            background-color: #f5f6fa;
                            font-family: 'Roboto Condensed', sans-serif;
                        } */

        .bg-box.container-fluid.mb-5.fix-nav.header-layout {
            margin-bottom: 6px !important;
        }

        /* ── TOP HEADER ── */
        .dashboard-header {
            background: #fff;
            padding: 14px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e8eaf0;
            top: 0;
            z-index: 100;
            margin-left: 31px;
            margin-right: 31px;
            border-radius: 10px;
        }

        .dashboard-header .greeting h2 {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a2e;
            margin: 0;
            line-height: 1.2;
        }

        .dashboard-header .greeting p {
            font-size: 13px;
            color: #6b7280;
            margin: 0;
        }

        .header-search {
            flex: 1;
            max-width: 420px;
            margin: 0 30px;
            position: relative;
        }

        /* .header-search input {
                    width: 100%;
                    border: 1px solid #e2e5ef;
                    border-radius: 6px;
                    padding: 8px 14px 8px 36px;
                    font-size: 13px;
                    color: #6b7280;
                    background: #f9fafb;
                    outline: none;
                    font-family: 'Roboto Condensed', sans-serif;
                }

                .header-search .search-icon {
                    position: absolute;
                    left: 11px;
                    top: 50%;
                    transform: translateY(-50%);
                    color: #9ca3af;
                    font-size: 13px;
                } */

        .btn-my-profile {
            background: #2dd4c0;
            color: #fff;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.5px;
            border: none;
            border-radius: 6px;
            padding: 9px 22px;
            white-space: nowrap;
            text-transform: uppercase;
            font-family: 'Roboto Condensed', sans-serif;
            cursor: pointer;
        }

        .btn-my-profile:hover {
            background: #26bfac;
            color: #fff;
        }

        /* ── MAIN CONTENT ── */
        .dashboard-main {
            padding: 6px 30px;
        }

        /* ── CARD ── */
        .dash-card {
            background: #fff;
            border-radius: 10px;
            padding: 22px 24px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
            height: 100%;
        }

        .dash-card-title {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 16px;
        }



        .project-icon {
            width: 24px;
            height: 24px;
            border-radius: 5px;
            background: linear-gradient(135deg, #2dd4c0, #3b82f6);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 7px;
            vertical-align: middle;
            flex-shrink: 0;
        }

        .project-icon img {
            width: 16px;
            height: 16px;
            object-fit: contain;
        }

        .project-icon-wrap {
            display: flex;
            align-items: center;
        }

        .assignee-avatar {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* ── PROJECTS ── */
        .projects-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-top: 4px;
        }

        .project-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border: 1px solid #e8eaf0;
            border-radius: 8px;
            cursor: pointer;
            transition: box-shadow 0.15s;
        }

        .project-item:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .project-item-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .project-item-icon.teal {
            background: linear-gradient(135deg, #2dd4c0, #0891b2);
        }

        .project-item-icon.purple {
            background: linear-gradient(135deg, #a855f7, #6366f1);
        }

        .project-item-icon.pink {
            background: linear-gradient(135deg, #ec4899, #8b5cf6);
        }

        .project-item-icon i {
            color: #fff;
            font-size: 18px;
        }

        .project-item-name {
            font-size: 13px;
            font-weight: 600;
            color: #1a1a2e;
            line-height: 1.3;
        }

        /* ── MEETINGS ── */
        .meeting-item {
            border: 1px solid #e8eaf0;
            border-radius: 8px;
            padding: 14px 16px;
            margin-bottom: 12px;
        }

        .meeting-item:last-child {
            margin-bottom: 0;
        }

        .meeting-title {
            font-size: 13px;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .meeting-title-text {
            flex: 1;
        }

        .badge-meeting {
            font-size: 10px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 4px;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .badge-meeting.meeting {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-meeting.event {
            background: #dcfce7;
            color: #15803d;
        }

        .meeting-meta {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 12px;
            color: #6b7280;
            flex-wrap: wrap;
        }

        .meeting-meta span {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .meeting-meta a {
            color: #2563eb;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .meeting-ext-link {
            color: #9ca3af;
            font-size: 13px;
            cursor: pointer;
            flex-shrink: 0;
        }


        /* ── SECTION ROW SPACING ── */
        .section-row {
            margin-bottom: 6px;
        }

        /* ── PROJECT ICON COLORS ── */
        .proj-icon-wrap {
            width: 24px;
            height: 24px;
            border-radius: 5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 6px;
            vertical-align: middle;
            flex-shrink: 0;
        }


        .project-link-cell {
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .proj-icon-wrap {
            width: 24px;
            height: 24px;
            border-radius: 5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }


        #leaveTable_wrapper {
            font-family: 'Roboto Condensed', sans-serif;
        }

        #leaveTable_wrapper .dataTables_filter,
        #leaveTable_wrapper .dataTables_length,
        #leaveTable_wrapper .dataTables_info,
        #leaveTable_wrapper .dataTables_paginate {
            display: none !important;
        }

        /* Remove ALL scroll-related DT wrappers styling */
        #leaveTable_wrapper .dataTables_scrollHead,
        #leaveTable_wrapper .dataTables_scrollBody,
        #leaveTable_wrapper .dataTables_scrollHeadInner {
            overflow: visible !important;
            height: auto !important;
        }

        /* Header */
        #leaveTable thead tr {
            background: #3d4a5c;
        }

        #leaveTable thead th {
            color: #fff !important;
            font-size: 11px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.4px !important;
            padding: 9px 12px !important;
            white-space: nowrap !important;
            border-bottom: none !important;
            border-top: none !important;
            background: #3d4a5c !important;
            outline: none !important;
        }

        /* Sort icons */
        #leaveTable thead th.sorting::after,
        #leaveTable thead th.sorting_asc::after,
        #leaveTable thead th.sorting_desc::after,
        #leaveTable thead th.sorting::before,
        #leaveTable thead th.sorting_asc::before,
        #leaveTable thead th.sorting_desc::before {
            color: rgba(255, 255, 255, 0.6) !important;
        }

        #leaveTable thead th.sorting_asc::after,
        #leaveTable thead th.sorting_desc::after {
            color: #2dd4c0 !important;
        }

        /* Body rows */
        #leaveTable tbody tr {
            border-bottom: 1px solid #f0f2f7;
        }

        #leaveTable tbody tr:last-child {
            border-bottom: none;
        }

        #leaveTable tbody td {
            padding: 10px 12px !important;
            color: #374151;
            font-size: 13px;
            vertical-align: middle;
            border-top: none !important;
            white-space: nowrap;
        }

        /* Status badges */
        .leave-status-pending {
            color: #f59e0b;
            font-weight: 600;
            font-size: 12px;
        }

        .leave-status-approved {
            color: #10b981;
            font-weight: 600;
            font-size: 12px;
        }

        .leave-status-rejected {
            color: #ef4444;
            font-weight: 600;
            font-size: 12px;
        }

        /* Note cell truncation */
        .note-cell {
            max-width: 140px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: default;
        }

        /* Scroll wrapper — on the DIV, not on DataTables */
        .leave-table-scroll-wrap {
            overflow-x: auto;
            overflow-y: auto;
            max-height: 260px;
        }

        .leave-table-scroll-wrap::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .leave-table-scroll-wrap::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        /* My Tasks and Activities */

        .tl-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .tl-title {
            font-size: 15px;
            font-weight: 700;
            color: #1a1a2e;
        }

        .tl-filter-wrap {
            display: flex;
            border: 1px solid #e2e5ef;
            border-radius: 7px;
            overflow: hidden;
        }

        .tl-filter-btn {
            background: transparent;
            border: none;
            font-size: 11px;
            font-weight: 600;
            color: #6b7280;
            padding: 5px 12px;
            cursor: pointer;
            letter-spacing: 0.4px;
            text-transform: uppercase;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 5px;
            font-family: 'Roboto Condensed', sans-serif;
            transition: background 0.12s, color 0.12s;
        }

        .tl-filter-btn+.tl-filter-btn {
            border-left: 1px solid #e2e5ef;
        }

        .tl-filter-btn.active {
            background: #2dd4c0;
            color: #fff;
        }

        .tl-badge {
            font-size: 10px;
            font-weight: 700;
            border-radius: 10px;
            padding: 1px 6px;
            line-height: 1.5;
            background: rgba(255, 255, 255, 0.25);
        }

        .tl-filter-btn:not(.active) .tl-badge {
            background: #f3f4f6;
            color: #6b7280;
        }

        .tl-list {
            overflow-y: auto;
            max-height: 230px;
            margin-top: 4px;
        }

        .tl-list::-webkit-scrollbar {
            width: 4px;
        }

        .tl-list::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        .tl-item {
            padding: 10px 0;
            border-bottom: 1px solid #f0f2f7;
            cursor: pointer;
        }

        .tl-item:last-child {
            border-bottom: none;
        }

        .tl-item:hover {
            background: #fafafa;
        }

        .tl-task-name {
            font-size: 13px;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .tl-meta {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 11px;
            color: #6b7280;
            flex-wrap: wrap;
        }

        .tl-meta-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .tl-proj-dot {
            width: 8px;
            height: 8px;
            border-radius: 2px;
            flex-shrink: 0;
        }

        .tl-empty {
            text-align: center;
            padding: 28px 0;
            font-size: 12px;
            color: #9ca3af;
        }

        /* My Tasks and Activities end */

        /* Leave Calendar */


        /* Wrap everything in .lc-wrap to avoid leaking into page */
        .lc-wrap {
            font-family: 'Roboto Condensed', sans-serif;
        }

        .lc-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .lc-ttl {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a2e;
        }

        .lc-topright {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 6px;
        }

        .lc-req-btn {
            font-size: 11px;
            font-weight: 600;
            color: #9ca3af;
            background: none;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
            letter-spacing: .4px;
            font-family: inherit;
            padding: 5px 12px;
        }

        .lc-req-btn:hover {
            color: #374151;
            background: #f9fafb;
        }

        .lc-nav {
            display: flex;
            gap: 4px;
        }

        .lc-nav button {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            width: 26px;
            height: 26px;
            cursor: pointer;
            color: #9ca3af;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            line-height: 1;
        }

        .lc-nav button:hover {
            background: #f9fafb;
            color: #374151;
        }

        .lc-month {
            font-size: 13px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 12px;
            letter-spacing: .2px;
        }

        /* Table — fixed layout so all cells are equal width & height */
        .lc-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .lc-table thead th {
            text-align: center;
            font-size: 11px;
            font-weight: 600;
            color: #9ca3af;
            padding: 0 0 8px;
            letter-spacing: .5px;
            width: calc(100% / 7);
        }

        .lc-table thead th.lc-sun-hdr {
            color: #ef4444;
        }

        .lc-table tbody td {
            width: calc(100% / 7);
            height: 58px;
            text-align: center;
            vertical-align: top;
            padding: 7px 3px 5px;
            font-size: 12px;
            font-weight: 400;
            color: #374151;
            border: none;
            overflow: hidden;
        }

        /* Cell states */
        .lc-table tbody td.lc-other {
            background: #f9fafb;
            color: #d1d5db;
        }

        /* SAT — ash grey */
        .lc-table tbody td.lc-sat {
            color: #6b7280;
            background: #f3f4f6;
        }

        .lc-table tbody td.lc-sat.lc-other {
            background: #efefef;
            color: #c4c4c4;
        }

        /* SUN — light red */
        .lc-table tbody td.lc-sun {
            color: #ef4444;
            background: #fff5f5;
        }

        .lc-table tbody td.lc-sun.lc-other {
            background: #fff5f5;
            color: #fca5a5;
        }

        .lc-dnum {
            display: block;
            font-size: 12px;
            line-height: 1.4;
            margin-bottom: 2px;
        }

        /* Today */
        .lc-today {
            outline: 2px solid #16a34a;
            outline-offset: -2px;
            border-radius: 6px;
        }

        .lc-today .lc-dnum {
            color: #16a34a;
            font-weight: 700;
        }

        /* Leave chip */
        .lc-chip {
            display: block;
            background: #ccfbf1;
            color: #0d9488;
            font-size: 9px;
            font-weight: 600;
            border-radius: 20px;
            padding: 2px 0;
            margin: 0 auto;
            white-space: nowrap;
            width: 92%;
            text-align: center;
        }

        /* Holiday */
        .lc-holiday {
            background: #fce7f3 !important;
        }

        .lc-holiday .lc-dnum {
            color: #e11d48;
            font-weight: 600;
        }

        .lc-hname {
            display: block;
            font-size: 8px;
            color: #be185d;
            font-weight: 500;
            line-height: 1.3;
            margin-top: 1px;
            word-break: break-word;
        }

        /* Footer */
        .lc-footer {
            margin-top: 12px;
            border-top: 1px solid #f3f4f6;
            padding: 12px 0 14px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .lc-ol-lbl {
            font-size: 12px;
            color: #374151;
            font-weight: 600;
            margin-bottom: 7px;
        }

        .lc-avatars {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .lc-av-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .lc-av {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            color: #fff;
        }

        .lc-av-a {
            background: linear-gradient(135deg, #f97316, #fb923c);
        }

        .lc-av-b {
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
        }

        .lc-av-c {
            background: linear-gradient(135deg, #8b5cf6, #a78bfa);
        }

        .lc-av-d {
            background: linear-gradient(135deg, #10b981, #34d399);
        }

        .lc-av-name {
            font-size: 11px;
            color: #374151;
            white-space: nowrap;
        }

        /* Legend */
        .lc-legend {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .lc-leg-item {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 10px;
            color: #6b7280;
            white-space: nowrap;
        }

        .lc-leg-box {
            width: 12px;
            height: 12px;
            border-radius: 3px;
            display: inline-block;
            flex-shrink: 0;
        }

        .lc-leg-today {
            border: 2px solid #16a34a;
            background: #fff;
        }

        .lc-leg-leave {
            background: #ccfbf1;
        }

        .lc-leg-holiday {
            background: #fce7f3;
        }

        .lc-leg-weekend {
            background: #fff5f5;
        }

        /* Leave Calendar End*/

        /* My Tasks and Activities */
        .tl-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .tl-title {
            font-size: 15px;
            font-weight: 700;
            color: #1a1a2e;
        }

        .tl-filter-wrap {
            display: flex;
            border: 1px solid #e2e5ef;
            border-radius: 7px;
            overflow: hidden;
        }

        .tl-filter-btn {
            background: transparent;
            border: none;
            font-size: 11px;
            font-weight: 600;
            color: #6b7280;
            padding: 5px 12px;
            cursor: pointer;
            letter-spacing: 0.4px;
            text-transform: uppercase;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 5px;
            font-family: 'Roboto Condensed', sans-serif;
            transition: background 0.12s, color 0.12s;
        }

        .tl-filter-btn+.tl-filter-btn {
            border-left: 1px solid #e2e5ef;
        }

        .tl-filter-btn.active {
            background: #2dd4c0;
            color: #fff;
        }

        .tl-badge {
            font-size: 10px;
            font-weight: 700;
            border-radius: 10px;
            padding: 1px 6px;
            line-height: 1.5;
            background: rgba(255, 255, 255, 0.25);
        }

        .tl-filter-btn:not(.active) .tl-badge {
            background: #f3f4f6;
            color: #6b7280;
        }

        .tl-list {
            overflow-y: auto;
            max-height: 230px;
            margin-top: 4px;
        }

        .tl-list::-webkit-scrollbar {
            width: 4px;
        }

        .tl-list::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        .tl-item {
            padding: 10px 0;
            border-bottom: 1px solid #f0f2f7;
            cursor: pointer;
        }

        .tl-item:last-child {
            border-bottom: none;
        }

        .tl-item:hover {
            background: #fafafa;
        }

        /* ── Task name row ── */
        .tl-task-name {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 5px;
            overflow: hidden;
        }

        .tl-task-label {
            font-size: 13px;
            font-weight: 600;
            color: #1a1a2e;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.3;
        }

        /* ── Circular Checkbox ── */
        .tl-check-wrap {
            position: relative;
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            flex-shrink: 0;
            margin: 0;
        }

        .tl-check-wrap input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
            pointer-events: none;
        }

        .tl-check-circle {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid #d1d5db;
            background: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: border-color 0.15s, background 0.15s;
            flex-shrink: 0;
        }

        .tl-check-wrap:hover .tl-check-circle {
            border-color: #2dd4c0;
        }

        .tl-check-wrap input[type="checkbox"]:checked + .tl-check-circle {
            background: #2dd4c0;
            border-color: #2dd4c0;
        }

        .tl-check-wrap input[type="checkbox"]:checked + .tl-check-circle::after {
            content: '';
            width: 5px;
            height: 9px;
            border: 2px solid #fff;
            border-top: none;
            border-left: none;
            transform: rotate(45deg) translateY(-1px);
            display: block;
        }

        /* ── Task meta row ── */
        .tl-meta {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 11px;
            color: #6b7280;
            flex-wrap: wrap;
            padding-left: 26px;
        }

        .tl-meta-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .tl-proj-dot {
            width: 8px;
            height: 8px;
            border-radius: 2px;
            flex-shrink: 0;
        }

        .tl-empty {
            text-align: center;
            padding: 28px 0;
            font-size: 12px;
            color: #9ca3af;
        }
        
    </style>

    <!-- ── HEADER ── -->
    <div class="dashboard-header">
        <div class="greeting">
            <h2>Good&nbsp;&nbsp;{{ $helper->getGreetingTime() }}, {{ auth()->user()->name }}</h2>
            <p> {{ $helper->getFormatedDate(date('Y-m-d'), 'l, F d') }}</p>
        </div>
        <div class="header-search">
            @include('pages.project.partials.project_master_search')
        </div>
        <a href="{{ route('profile.edit') }}"><button class="btn-my-profile">MY PROFILE</button></a>
    </div>

    <!-- ── MAIN ── -->
    <div class="dashboard-main">

        <!-- ROW 1: Tasks + Projects -->
        <div class="row section-row">
            <!-- My Tasks and Activities -->
            <div class="col-md-6">
                <div class="dash-card">


                    <div class="tl-top">
                        <span class="tl-title">My Tasks and Activities</span>
                        <div class="tl-filter-wrap">
                            <button class="tl-filter-btn active" data-tab="upcoming">
                                Upcoming <span class="tl-badge" id="badge-upcoming">0</span>
                            </button>
                            <button class="tl-filter-btn" data-tab="overdue">
                                Overdue <span class="tl-badge" id="badge-overdue">0</span>
                            </button>
                            <button class="tl-filter-btn" data-tab="completed">
                                Completed <span class="tl-badge" id="badge-completed">0</span>
                            </button>
                        </div>
                    </div>

                    <div class="tl-list" id="tlList">
                        <div class="tl-empty">
                            <img src="{{ asset('argon/img/loader/Spinner-1s-200px.gif') }}" alt="Loading..."
                                style="width:32px;">
                        </div>
                    </div>

                    <div id="tlEmptyState"
                        style="display:none; text-align:center; padding:24px 0; color:#9ca3af; font-size:13px;">
                        No tasks found.
                    </div>
                </div>
            </div>

            <!-- Projects -->
            <div class="col-md-6" style="padding-left: 0px;">
                <div class="dash-card">
                    <div class="dash-card-title">Projects</div>
                    <div class="projects-grid" id="projectsGrid">
                        <div class="text-center w-100 py-4">
                            <img src="{{ asset('argon/img/loader/Spinner-1s-200px.gif') }}" alt="Loading..."
                               style="width:32px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- ROW 2: Upcoming Meetings + Leave Calendar -->
        <div class="row section-row">
            <!-- Upcoming Meetings & Events -->
            <div class="col-md-6">
                <div class="dash-card">
                    <div class="dash-card-title">Upcoming Meetings & Events</div>
                    <div id="meetingsList">
                        <div style="text-align:center;padding:20px 0;">
                            <img src="{{ asset('argon/img/loader/Spinner-1s-200px.gif') }}" alt="Loading..."
                                style="width:32px;">
                        </div>
                    </div>
                    <div id="meetingsEmpty"
                        style="display:none;text-align:center;padding:24px 0;color:#9ca3af;font-size:13px;">
                        No upcoming meetings or events.
                    </div>
                </div>
            </div>
            <!-- Leave Calendar -->
 
            <div class="col-md-6" style="padding-left: 0px;">
                <div class="dash-card" style="padding:20px 22px 0;">
                    <div class="lc-wrap">

                        {{-- Header --}}
                        <div class="lc-top">
                            <div class="lc-ttl">Leave Calendar</div>
                            <div class="lc-topright">
                                <button class="lc-req-btn" id="lcReqBtn"
                                    onclick="window.location.href='{{ route('leave.manage') }}'">
                                    <i class="fas fa-plus"></i> REQUEST A LEAVE
                                </button>
                                <div class="lc-nav">
                                    <button id="lcPrev" aria-label="Previous month"><i
                                            class="fas fa-chevron-left"></i></button>
                                    <button id="lcNext" aria-label="Next month"><i
                                            class="fas fa-chevron-right"></i></button>
                                </div>
                            </div>
                        </div>

                        {{-- Month Label --}}
                        <div class="lc-month" id="lcMonthLbl"></div>

                        {{-- Calendar Table --}}
                        <table class="lc-table">
                            <thead>
                                <tr>
                                    <th>MON</th>
                                    <th>TUE</th>
                                    <th>WED</th>
                                    <th>THU</th>
                                    <th>FRI</th>
                                    <th class="lc-sat-hdr">SAT</th>
                                    <th class="lc-sun-hdr">SUN</th>
                                </tr>
                            </thead>
                            <tbody id="lcBody"></tbody>
                        </table>

                        {{-- Footer --}}
                        <div class="lc-footer">
                            <div>
                                <div class="lc-ol-lbl">On Leave Today</div>
                                <div class="lc-avatars" id="lcAvatars"></div>
                            </div>
                            <div class="lc-legend">
                                <div class="lc-leg-item"><span class="lc-leg-box lc-leg-today"></span> Today</div>
                                <div class="lc-leg-item"><span class="lc-leg-box lc-leg-leave"></span> On leave</div>
                                <div class="lc-leg-item"><span class="lc-leg-box lc-leg-holiday"></span> Holidays</div>
                                <div class="lc-leg-item"><span class="lc-leg-box lc-leg-weekend"></span> Weekend</div>
                            </div>
                        </div>

                    </div>{{-- /lc-wrap --}}
                </div>{{-- /dash-card --}}
            </div>{{-- /col-md-6 --}}




        </div>

        <!-- ROW 3: Pending Leave Requests -->
        <div class="row section-row" style="padding-bottom: 5rem;">
            <div class="col-12">
                <div class="dash-card">
                    <div class="dash-card-title">Pending Leave Requests</div>

                    <div class="leave-table-scroll-wrap">
                        <table id="leaveTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>LEAVE ID</th>
                                    <th>TITLE</th>
                                    <th>FROM DATE</th>
                                    <th>TO DATE</th>
                                    <th>LEAVE TYPE</th>
                                    <th>REQUEST NOTE</th>
                                    {{-- <th>RESPONSE NOTE</th> --}}
                                    <th>STATUS</th>
                                    <th>CREATED AT</th>
                                    <th>UPDATED AT</th>
                                </tr>
                            </thead>
                            <tbody id="leaveTableBody">
                                <tr>
                                    <td colspan="10" class="text-center py-3">
                                        <img src="{{ asset('argon/img/loader/Spinner-1s-200px.gif') }}" alt="Loading..."
                                            style="width:36px;">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="leaveEmptyState"
                        style="display:none; text-align:center; padding:24px 0; color:#9ca3af; font-size:13px;">
                        No pending leave requests found.
                    </div>
                </div>
            </div>
        </div>

        @include('pages.project.task_comment')

    </div><!-- /dashboard-main -->


    <script>
        var baseUrl = "{{ url('/') }}";
        $(document).ready(function () {

            loadProjects();


            function loadProjects() {

                $.ajax({
                    url: "{{ route('user.projects') }}",
                    type: "GET",

                    beforeSend: function () {
                        $('#projectsGrid').html(`
                        <div class="text-center w-100 py-4">
                            <img src="{{ asset('argon/img/loader/Spinner-1s-200px.gif') }}"
                                 alt="Loading..."
                                 style="width:32px;">
                        </div>
                    `);
                    },

                    success: function (response) {
                        let html = '';

                        if (response.data.length === 0) {
                            html = `
                            <div class="text-center w-100">
                                No projects found
                            </div>
                        `;
                        } else {
                            response.data.forEach(function (project) {

                                let projectUrl = baseUrl + `/projects/view-temp/${project.id}`;

                                let icon = project.project_icon_url ?
                                    `<img src="${project.project_icon_url}" alt="${project.project_name}" style="width:34px;height:34px;">` :
                                    `<i class="fa fa-server"></i>`;
                                html += `
                                            <a href="${projectUrl}" class="project-link">
                                                <div class="project-item">
                                                    <div class="project-item-icon" style="background:${project.project_color || '#4f46e5'}">
                                                        ${icon}
                                                    </div>

                                                    <div class="project-item-name">
                                                        ${project.new_display_name || project.project_name}
                                                    </div>
                                                </div>
                                            </a>
                                        `;
                            });
                        }

                        $('#projectsGrid').html(html);
                    },

                    error: function () {
                        $('#projectsGrid').html(`
                        <div class="text-danger text-center w-100">
                            Failed to load projects
                        </div>
                    `);
                    }
                });
            }

        });
    </script>

    <script>
        $(document).ready(function () {

            let currentTab = 'upcoming';

            function projectColor(p) {
                return (p && p.project_color) ? p.project_color : '#2dd4c0';
            }

            function projectName(p) {
                return p ? (p.new_display_name || p.project_name || 'N/A') : 'N/A';
            }

            function formatDate(str) {
                if (!str) return '-';
                const d = new Date(str);
                return isNaN(d) ? str : d.toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
            }

            function assigneeName(user) {
                return (user && user.name) ? user.name : '-';
            }

            function buildItems(data) {
                const items = [];
                [...(data.discussions || []), ...(data.sub_discussions || [])].forEach(item => {
                    const p = item.project_detail || null;
                    const projectId = p ? p.id : null;
                    const projectUrl = projectId ? `{{ url('projects/view-temp') }}/${projectId}` : '#';
                    items.push({
                        taskName: item.discussion_name || '-',
                        taskId: item.id || null,
                        taskType: item.discussion_type || null,
                        projName: projectName(p),
                        projColor: projectColor(p),
                        projectUrl: projectUrl,
                        dueDate: formatDate(item.due_date),
                        assignee: assigneeName(item.assigned_user),
                        isCompleted: item.is_completed == 1, 
                    });
                });
                return items;
            }

            function renderList(items) {
                const list = document.getElementById('tlList');
                const empty = document.getElementById('tlEmptyState');

                if (items.length === 0) {
                    list.innerHTML = '';
                    empty.style.display = 'block';
                    return;
                }
                empty.style.display = 'none';

                list.innerHTML = items.map(item => `
                    <div class="tl-item open-chatbox"
                         data-discussion-type="${item.taskType}"
                         data-value="${item.taskId}">
                        <div class="tl-task-name">
                            <label class="tl-check-wrap" onclick="event.stopPropagation()">
                                <input type="checkbox"
                                    class="my-task-check ${item.taskType === 'sub_discussion' ? 'sub-discussion-check sub-discussion-check-id-' + item.taskId : 'discussion-check discussion-check-id-' + item.taskId}"
                                    value="${item.taskId}"
                                    ${item.isCompleted ? 'checked' : ''}>
                                <span class="tl-check-circle"></span>
                            </label>
                            <span class="tl-task-label">${item.taskName}</span>
                        </div>
                        <div class="tl-meta">
                            <span class="tl-meta-item">
                                <span class="tl-proj-dot" style="background:${item.projColor};"></span>
                                <a href="${item.projectUrl}" style="color:#6b7280; text-decoration:none;"
                                   onclick="event.stopPropagation();">${item.projName}</a>
                            </span>
                            <span class="tl-meta-item">
                                <i class="fas fa-calendar-alt" style="color:#2dd4c0; font-size:11px;"></i>
                                ${item.dueDate}
                            </span>
                            <span class="tl-meta-item">
                                <i class="fas fa-user" style="color:#9ca3af; font-size:11px;"></i>
                                ${item.assignee}
                            </span>
                        </div>
                    </div>
                `).join('');
            }

            function updateBadge(tab, count) {
                const el = document.getElementById('badge-' + tab);
                if (el) el.textContent = count;
            }

            function loadTasks(tab) {
                document.getElementById('tlList').innerHTML =
                    '<div class="tl-empty"><img src="{{ asset('argon/img/loader/Spinner-1s-200px.gif') }}" style="width:32px;"></div>';
                document.getElementById('tlEmptyState').style.display = 'none';

                $.ajax({
                    url: '{{ route('task.list') }}',
                    type: 'GET',
                    data: {
                        status: tab
                    },
                    success: function (res) {
                        if (!res.success) {
                            renderList([]);
                            return;
                        }
                        const items = buildItems(res.data);
                        updateBadge(tab, items.length);
                        renderList(items);
                    },
                    error: function () {
                        document.getElementById('tlList').innerHTML =
                            '<div class="tl-empty" style="color:#ef4444;">Failed to load. Please try again.</div>';
                    }
                });
            }

            function loadAllBadges() {
                ['upcoming', 'overdue', 'completed'].forEach(function (tab) {
                    if (tab === currentTab) return;
                    $.ajax({
                        url: '{{ route('task.list') }}',
                        type: 'GET',
                        data: {
                            status: tab
                        },
                        success: function (res) {
                            if (!res.success) return;
                            const total = (res.data.discussions || []).length +
                                (res.data.sub_discussions || []).length;
                            updateBadge(tab, total);
                        }
                    });
                });
            }

            document.querySelectorAll('.tl-filter-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    currentTab = btn.dataset.tab;
                    document.querySelectorAll('.tl-filter-btn').forEach(b =>
                        b.classList.toggle('active', b === btn));
                    loadTasks(currentTab);
                });
            });

            loadTasks('upcoming');
            loadAllBadges();
        });

        $('body').on('change', '.my-task-check', function () {
            var $checkbox = $(this);
            var discussion_id = $checkbox.val();
            var is_completed = $checkbox.prop('checked') ? 1 : 0;

            // Determine URL based on task type
            var isSub = $checkbox.hasClass('sub-discussion-check');
            var url = isSub
                ? '{{ url('project_management_section_sub_discussion/update') }}/' + discussion_id
                : '{{ url('project_management_section_discussion/update') }}/' + discussion_id;

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    is_completed: is_completed,
                    '_token': '{{ csrf_token() }}'
                },
                success: function (data) {
                    // Sync any other checkboxes with the same id on the page
                    if (isSub) {
                        $('.sub-discussion-check-id-' + discussion_id).not($checkbox).prop('checked', is_completed == 1);
                    } else {
                        $('.discussion-check-id-' + discussion_id).not($checkbox).prop('checked', is_completed == 1);
                    }

                    // Visual feedback — strike through task name if completed
                    var $label = $checkbox.closest('.tl-task-name').find('.tl-task-label');
                    if (is_completed == 1) {
                        $label.css({ 'text-decoration': 'line-through', 'color': '#9ca3af' });
                    } else {
                        $label.css({ 'text-decoration': 'none', 'color': '#1a1a2e' });
                    }
                },
                error: function (xhr, status, error) {
                    // Revert checkbox on failure
                    $checkbox.prop('checked', !$checkbox.prop('checked'));
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

    <script>
        $(document).ready(function () {

            let leaveDtInstance = null;

            /* ── Helpers ── */
            function formatLeaveDate(str) {
                if (!str) return '-';
                /* API returns MM/DD/YYYY — parse correctly */
                const parts = str.split('/');
                if (parts.length === 3) {
                    const d = new Date(`${parts[2]}-${parts[0]}-${parts[1]}`);
                    if (!isNaN(d)) {
                        return d.toLocaleDateString('en-GB', {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric'
                        });
                    }
                }
                return str;
            }

            function isoLeaveDate(str) {
                if (!str) return '';
                const parts = str.split('/');
                if (parts.length === 3) {
                    return `${parts[2]}-${parts[0]}-${parts[1]}`;
                }
                return str;
            }

            function formatDateTime(str) {
                if (!str) return '-';
                const d = new Date(str);
                if (isNaN(d)) return str;
                return d.toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
            }

            function isoDateTime(str) {
                if (!str) return '';
                const d = new Date(str);
                return isNaN(d) ? '' : d.toISOString().split('T')[0];
            }

            function leaveTypeLabel(type) {
                if (!type) return '-';
                return type.replace(/_/g, ' ')
                    .replace(/\b\w/g, c => c.toUpperCase());
            }

            function statusBadge(status) {
                switch (parseInt(status)) {
                    case 0:
                        return `<span class="leave-status-pending">Pending</span>`;
                    case 1:
                        return `<span class="leave-status-approved">Approved</span>`;
                    case 2:
                        return `<span class="leave-status-rejected">Rejected</span>`;
                    default:
                        return `<span class="leave-status-pending">Pending</span>`;
                }
            }

            /* ── Build rows from API ── */
            function buildLeaveRows(items) {
                return items.map(item => ({
                    id: item.id || '-',
                    title: item.title || '-',
                    startDisplay: formatLeaveDate(item.start_date),
                    startSort: isoLeaveDate(item.start_date),
                    endDisplay: formatLeaveDate(item.end_date),
                    endSort: isoLeaveDate(item.end_date),
                    leaveType: leaveTypeLabel(item.leave_type),
                    requestNote: item.request_note || '-',
                    // responseNote: item.note || '-',
                    statusHtml: statusBadge(item.status),
                    createdDisplay: formatDateTime(item.created_at),
                    createdSort: isoDateTime(item.created_at),
                    updatedDisplay: formatDateTime(item.updated_at),
                    updatedSort: isoDateTime(item.updated_at)
                }));
            }

            /* ── Render DataTable ── */
            function renderLeaveTable(rows) {
                if (leaveDtInstance) {
                    leaveDtInstance.destroy();
                    leaveDtInstance = null;
                }
                $('#leaveTableBody').html('');

                const empty = $('#leaveEmptyState');

                if (rows.length === 0) {
                    empty.show();
                    return;
                }
                empty.hide();

                leaveDtInstance = $('#leaveTable').DataTable({
                    destroy: true,
                    data: rows.map(r => [
                        r.id,
                        `<div class="note-cell" title="${r.title}">${r.title}</div>`,
                        r.startDisplay,
                        r.endDisplay,
                        r.leaveType,
                        `<div class="note-cell" title="${r.requestNote}">${r.requestNote}</div>`,
                        // `<div class="note-cell" title="${r.responseNote}">${r.responseNote}</div>`,
                        r.statusHtml,
                        r.createdDisplay,
                        r.updatedDisplay
                    ]),
                    columns: [{
                        title: 'LEAVE ID'
                    },
                    {
                        title: 'TITLE'
                    },
                    {
                        title: 'FROM DATE'
                    },
                    {
                        title: 'TO DATE'
                    },
                    {
                        title: 'LEAVE TYPE'
                    },
                    {
                        title: 'REQUEST NOTE',
                        orderable: false
                    },
                    // {
                    //     title: 'RESPONSE NOTE',
                    //     orderable: false
                    // },
                    {
                        title: 'STATUS'
                    },
                    {
                        title: 'CREATED AT'
                    },
                    {
                        title: 'UPDATED AT'
                    }
                    ],
                    createdRow: function (row, data, idx) {
                        $('td:eq(2)', row).attr('data-order', rows[idx].startSort);
                        $('td:eq(3)', row).attr('data-order', rows[idx].endSort);
                        $('td:eq(8)', row).attr('data-order', rows[idx].createdSort);
                        $('td:eq(9)', row).attr('data-order', rows[idx].updatedSort);
                    },
                    columnDefs: [{
                        targets: [5, 6],
                        orderable: false
                    }],
                    order: [
                        [0, 'desc']
                    ],
                    ordering: true,
                    paging: false,
                    searching: false,
                    info: false,
                    /* NO scrollY — scroll is handled by .leave-table-scroll-wrap div */
                    autoWidth: false,
                    dom: 't',
                    language: {
                        emptyTable: '<span style="color:#9ca3af;font-size:13px;">No pending leave requests found.</span>'
                    },
                    initComplete: function () {
                        /* No scroll body manipulation needed */
                        leaveDtInstance.columns.adjust();
                    }
                });
            }

            /* ── AJAX ── */
            function loadLeaves() {
                $('#leaveTableBody').html(`
                    <tr>
                        <td colspan="10" class="text-center py-3">
                            <img src="{{ asset('argon/img/loader/Spinner-1s-200px.gif') }}"
                                 alt="Loading..." style="width:36px;">
                        </td>
                    </tr>
                `);
                $('#leaveEmptyState').hide();

                $.ajax({
                    url: '{{ route('my-leaves-pending') }}',
                    type: 'GET',
                    success: function (res) {
                        if (!res.success || !res.data) {
                            renderLeaveTable([]);
                            return;
                        }
                        const rows = buildLeaveRows(res.data);
                        renderLeaveTable(rows);
                    },
                    error: function () {
                        if (leaveDtInstance) {
                            leaveDtInstance.destroy();
                            leaveDtInstance = null;
                        }
                        $('#leaveTableBody').html(`
                            <tr>
                                <td colspan="10" class="text-center py-3" style="color:#ef4444;font-size:13px;">
                                    Failed to load leave requests. Please try again.
                                </td>
                            </tr>
                        `);
                    }
                });
            }

            /* ── Init ── */
            loadLeaves();

        });
    </script>

    <script>
        // Leave Calendar
        (function () {

            const MONTHS = [
                'JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE',
                'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'
            ];

            const HOLIDAYS = {
                '1-4': 'Independence Day',      // February 04
                '3-13': 'Sinhala & Tamil New Year',  // April 13
                '3-14': 'Sinhala & Tamil New Year',  // April 14
                '4-1': 'May Day',               // May 01
                '5-29': 'Poson Poya Day',             // June 29
                '11-25': 'Christmas Day'            // December 25
            };

            const today = new Date();
            let curYear = today.getFullYear();
            let curMonth = today.getMonth();

            /*
             * leaveData structure:
             * {
             *   "2026-5": {
             *      18: [{ title, status, id }],
             *      24: [{ title, status, id }]
             *   }
             * }
             */
            let leaveData = {};

            /* ── Parse MM/DD/YYYY from API ── */
            function parseApiDate(str) {
                if (!str) return null;
                const p = str.split('/');
                if (p.length !== 3) return null;
                const d = new Date(`${p[2]}-${p[0]}-${p[1]}`);
                return isNaN(d) ? null : d;
            }

            function mkey(y, m) {
                return y + '-' + m;
            }

            /* ── Status label & color ── */
            function statusColor(status) {
                switch (parseInt(status)) {
                    case 0:
                        return {
                            bg: '#fef3c7', text: '#d97706', label: 'Pending'
                        };
                    case 1:
                        return {
                            bg: '#ccfbf1', text: '#0d9488', label: 'Approved'
                        };
                    case 2:
                        return {
                            bg: '#fee2e2', text: '#dc2626', label: 'Rejected'
                        };
                    default:
                        return {
                            bg: '#ccfbf1', text: '#0d9488', label: 'Leave'
                        };
                }
            }

            /* ── Load leaves from API and index by date ── */
            function loadLeaves(callback) {
                $.ajax({
                    url: '{{ route('my-leaves') }}',
                    type: 'GET',
                    success: function (res) {
                        leaveData = {};

                        if (res.success && res.data) {
                            res.data.forEach(function (item) {
                                const start = parseApiDate(item.start_date);
                                const end = parseApiDate(item.end_date) || start;

                                if (!start) return;

                                /* Loop every day from start to end */
                                const cur = new Date(start);
                                while (cur <= end) {
                                    const y = cur.getFullYear();
                                    const m = cur.getMonth(); /* 0-based */
                                    const d = cur.getDate();
                                    const k = mkey(y, m);

                                    if (!leaveData[k]) leaveData[k] = {};
                                    if (!leaveData[k][d]) leaveData[k][d] = [];

                                    leaveData[k][d].push({
                                        id: item.id,
                                        title: item.title,
                                        status: item.status
                                    });

                                    cur.setDate(cur.getDate() + 1);
                                }
                            });
                        }

                        if (callback) callback();
                    },
                    error: function () {
                        /* Render calendar even if leave load fails */
                        if (callback) callback();
                    }
                });
            }

            /* ── Render calendar grid ── */
            function render() {
                const k = mkey(curYear, curMonth);
                const leaves = leaveData[k] || {};

                document.getElementById('lcMonthLbl').textContent = MONTHS[curMonth] + ' ' + curYear;

                const firstDay = new Date(curYear, curMonth, 1).getDay();
                const startOffset = (firstDay === 0) ? 6 : firstDay - 1;
                const daysInMonth = new Date(curYear, curMonth + 1, 0).getDate();
                const prevDays = new Date(curYear, curMonth, 0).getDate();
                const totalCells = Math.ceil((startOffset + daysInMonth) / 7) * 7;

                const body = document.getElementById('lcBody');
                body.innerHTML = '';

                let day = 1,
                    nextDay = 1;

                for (let i = 0; i < totalCells; i += 7) {
                    const tr = document.createElement('tr');

                    for (let j = 0; j < 7; j++) {
                        const td = document.createElement('td');
                        const cellIdx = i + j;
                        let cellDay, isOther = false;

                        if (cellIdx < startOffset) {
                            cellDay = prevDays - startOffset + cellIdx + 1;
                            isOther = true;
                        } else if (day > daysInMonth) {
                            cellDay = nextDay++;
                            isOther = true;
                        } else {
                            cellDay = day++;
                        }

                        if (j === 5) td.classList.add('lc-sat');
                        if (j === 6) td.classList.add('lc-sun');
                        if (isOther) td.classList.add('lc-other');

                        /* Today */
                        const isToday = !isOther &&
                            cellDay === today.getDate() &&
                            curMonth === today.getMonth() &&
                            curYear === today.getFullYear();
                        if (isToday) td.classList.add('lc-today');

                        /* Holiday */
                        const hkey = curMonth + '-' + cellDay;
                        const holiday = (!isOther && HOLIDAYS[hkey]) ? HOLIDAYS[hkey] : null;
                        if (holiday) td.classList.add('lc-holiday');

                        /* Day number */
                        const numSpan = document.createElement('span');
                        numSpan.className = 'lc-dnum';
                        numSpan.textContent = cellDay;
                        td.appendChild(numSpan);

                        /* Leave chips — one per leave entry on this day */
                        if (!isOther && leaves[cellDay] && !holiday) {
                            leaves[cellDay].forEach(function (lv) {
                                const sc = statusColor(lv.status);
                                const chip = document.createElement('span');
                                chip.className = 'lc-chip';
                                chip.style.cssText = `background:${sc.bg}; color:${sc.text};`;
                                chip.title = lv.title + ' (' + sc.label + ')';

                                /* Truncate long titles */
                                const maxLen = 8;
                                chip.textContent = lv.title.length > maxLen ?
                                    lv.title.substring(0, maxLen) + '…' :
                                    lv.title;
                                td.appendChild(chip);
                            });
                        }

                        /* Holiday name */
                        if (holiday) {
                            const hn = document.createElement('span');
                            hn.className = 'lc-hname';
                            hn.textContent = holiday;
                            td.appendChild(hn);
                        }

                        tr.appendChild(td);
                    }
                    body.appendChild(tr);
                }

                renderFooter(leaves);
            }

            /* ── Footer: leaves on today ── */
            function renderFooter(leaves) {
                const div = document.getElementById('lcAvatars');
                div.innerHTML = '';

                const isCur = curMonth === today.getMonth() && curYear === today.getFullYear();

                if (!isCur) {
                    div.innerHTML = '<span style="font-size:11px;color:#9ca3af">No leaves today</span>';
                    return;
                }

                if (othersLeaveToday.length === 0) {
                    div.innerHTML = '<span style="font-size:11px;color:#9ca3af">No leaves today</span>';
                    return;
                }

                othersLeaveToday.forEach(function (person) {
                    const sc = statusColor(person.status);
                    const item = document.createElement('div');
                    item.className = 'lc-av-item';
                    item.style.cssText = 'display:flex;align-items:center;gap:6px;margin-bottom:4px;';

                    const avatarHtml = person.avatar ?
                        `<img src="${person.avatar}"
                            alt="${person.name}"
                            style="width:28px;height:28px;border-radius:50%;object-fit:cover;border:1.5px solid ${sc.text};flex-shrink:0;"
                            onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                       <div style="display:none;width:28px;height:28px;border-radius:50%;background:${sc.bg};color:${sc.text};border:1.5px solid ${sc.text};align-items:center;justify-content:center;font-size:10px;font-weight:700;flex-shrink:0;">
                           ${person.name.split(' ').slice(0, 2).map(w => w[0] || '').join('').toUpperCase()}
                       </div>` :
                        `<div style="display:flex;width:28px;height:28px;border-radius:50%;background:${sc.bg};color:${sc.text};border:1.5px solid ${sc.text};align-items:center;justify-content:center;font-size:10px;font-weight:700;flex-shrink:0;">
                           ${person.name.split(' ').slice(0, 2).map(w => w[0] || '').join('').toUpperCase()}
                       </div>`;

                    item.innerHTML = avatarHtml +
                        `<span style="font-size:11px;color:#374151;">
                        ${person.name}
                        
                     </span>`;

                    div.appendChild(item);
                });
            }

            let othersLeaveToday = [];

            function loadOthersLeaves(callback) {
                $.ajax({
                    url: '{{ route('others-leaves') }}',
                    type: 'GET',
                    success: function (res) {
                        othersLeaveToday = [];
                        if (res.success && res.data) {
                            /* Deduplicate by user_id — one avatar per person */
                            const seen = {};
                            res.data.forEach(function (item) {
                                const u = item.user_details;
                                if (!u || seen[u.id]) return;
                                seen[u.id] = true;
                                othersLeaveToday.push({
                                    name: u.name || 'Unknown',
                                    avatar: u.profile_pic_url || null,
                                    status: item.status,
                                    title: item.title
                                });
                            });
                        }
                        if (callback) callback();
                    },
                    error: function () {
                        if (callback) callback();
                    }
                });
            }

            /* ── Navigation ── */
            document.getElementById('lcPrev').onclick = function () {
                curMonth--;
                if (curMonth < 0) {
                    curMonth = 11;
                    curYear--;
                }
                render();
            };
            document.getElementById('lcNext').onclick = function () {
                curMonth++;
                if (curMonth > 11) {
                    curMonth = 0;
                    curYear++;
                }
                render();
            };

            /* ── Init: load leaves first, then render ── */
            loadOthersLeaves(function () {
                loadLeaves(function () {
                    render();
                });
            });

        })();



        // Upcoming Meetings & Events

        $(document).ready(function () {

            var baseUrl = "{{ url('/') }}";

            /* ── Helpers ── */
            function meetingTypeLabel(type) {
                if (!type) return 'Meeting';
                switch (type) {
                    case 'event':
                        return 'Event';
                    case 'sales_meeting':
                        return 'Meeting';
                    case 'customer_meeting':
                        return 'Meeting';
                    default:
                        return type.replace(/_/g, ' ')
                            .replace(/\b\w/g, c => c.toUpperCase());
                }
            }

            function meetingTypeBadgeClass(type) {
                return (type === 'event') ? 'event' : 'meeting';
            }

            function formatMeetingTime(isoStr) {
                if (!isoStr) return '-';
                const d = new Date(isoStr);
                if (isNaN(d)) return isoStr;
                return d.toLocaleTimeString('en-GB', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }

            function formatMeetingDate(isoStr) {
                if (!isoStr) return '-';
                const d = new Date(isoStr);
                if (isNaN(d)) return isoStr;
                return d.toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
            }

            function buildLocationMeta(item) {
                if (item.platform === 'zoom' && item.zoom_join_url) {
                    return `<a href="${item.zoom_join_url}" target="_blank">
                                <i class="fas fa-link" style="color:#6b7280;"></i> Zoom meeting
                            </a>`;
                }
                if (item.platform === 'phone' && item.phone) {
                    return `<span><i class="fas fa-phone" style="color:#6b7280;"></i> ${item.phone}</span>`;
                }
                if (item.location) {
                    return `<span><i class="fas fa-map-marker-alt" style="color:#6b7280;"></i> ${item.location}</span>`;
                }
                return '';
            }

            /* ── Render ── */
            function renderMeetings(items) {
                const list = document.getElementById('meetingsList');
                const empty = document.getElementById('meetingsEmpty');

                if (!items || items.length === 0) {
                    list.innerHTML = '';
                    empty.style.display = 'block';
                    return;
                }
                empty.style.display = 'none';

                list.innerHTML = items.map(function (item) {
                    const label = meetingTypeLabel(item.type);
                    const badgeCls = meetingTypeBadgeClass(item.type);
                    const date = formatMeetingDate(item.start_at);
                    const timeStart = formatMeetingTime(item.start_at);
                    const timeEnd = formatMeetingTime(item.end_at);
                    const locationMeta = buildLocationMeta(item);
                    const publicUrl = baseUrl + '/book/' + item.slug;

                    return `
                        <div class="meeting-item">
                            <div class="meeting-title">
                                <span class="meeting-title-text">${item.schedule_name}</span>
                                <span class="badge-meeting ${badgeCls}">${label}</span>
                                <a href="${publicUrl}" target="_blank" class="meeting-ext-link" title="Open">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                            <div class="meeting-meta">
                                <span><i class="fas fa-calendar-alt" style="color:#2dd4c0;"></i> ${date}</span>
                                <span><i class="fas fa-clock" style="color:#2dd4c0;"></i> ${timeStart} - ${timeEnd}</span>
                                ${locationMeta}
                            </div>
                        </div>
                    `;
                }).join('');
            }

            /* ── AJAX ── */
            $.ajax({
                url: '{{ route('my-meetings') }}',
                type: 'GET',
                success: function (res) {
                    if (!res.success || !res.data) {
                        renderMeetings([]);
                        return;
                    }
                    renderMeetings(res.data);
                },
                error: function () {
                    document.getElementById('meetingsList').innerHTML =
                        '<div style="text-align:center;padding:20px 0;color:#ef4444;font-size:13px;">Failed to load meetings.</div>';
                }
            });

        });
    </script>
@endsection