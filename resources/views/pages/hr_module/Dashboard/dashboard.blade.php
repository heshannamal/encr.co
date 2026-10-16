@extends('layouts.app', ['activePage' => 'HR_Dashboard', 'titlePage' => __('HR Dashboard')])

@section('content')

@if ($errors->any())
<div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<div class="container-fluid" style="background-color:#f4f7f6;padding:20px;">

    <div class="se-pre-con"></div>

    @section('order-header')
    <span>HR Dashboard</span>
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

    {{-- ── Stat Cards ── --}}
    <div class="row employee-stats-row">

        {{-- Total Employees: click goes to Employee Management page --}}
        <a href="{{ url('/Employee/Managment') }}" class="stat-card total" style="text-decoration:none;" title="Go to Employee Management">
            <div class="stat-icon"><i class="fa fa-users"></i></div>
            <div class="stat-content">
                <p class="stat-label">Total Employees</p>
                <h3 class="stat-number" id="totalEmployees"><i class="fa fa-spinner fa-spin"></i></h3>
            </div>
        </a>

        {{-- Department cards: click opens team modal --}}
        <div class="stat-card design dept-card" data-dept="design" style="cursor:pointer;" title="View Design Team">
            <div class="stat-icon"><i class="fa fa-paint-brush"></i></div>
            <div class="stat-content">
                <p class="stat-label">Design Team</p>
                <h3 class="stat-number" id="designCount"><i class="fa fa-spinner fa-spin"></i></h3>
            </div>
        </div>
        <div class="stat-card development dept-card" data-dept="development" style="cursor:pointer;" title="View Development Team">
            <div class="stat-icon"><i class="fa fa-code"></i></div>
            <div class="stat-content">
                <p class="stat-label">Development Team</p>
                <h3 class="stat-number" id="devCount"><i class="fa fa-spinner fa-spin"></i></h3>
            </div>
        </div>
        <div class="stat-card marketing dept-card" data-dept="marketing" style="cursor:pointer;" title="View Marketing Team">
            <div class="stat-icon"><i class="fa fa-bullhorn"></i></div>
            <div class="stat-content">
                <p class="stat-label">Marketing Team</p>
                <h3 class="stat-number" id="marketingCount"><i class="fa fa-spinner fa-spin"></i></h3>
            </div>
        </div>
        <div class="stat-card executives dept-card" data-dept="admin" style="cursor:pointer;" title="View Executives">
            <div class="stat-icon"><i class="fa fa-users"></i></div>
            <div class="stat-content">
                <p class="stat-label">Executives</p>
                <h3 class="stat-number" id="executivesCount"><i class="fa fa-spinner fa-spin"></i></h3>
            </div>
        </div>
    </div>

    {{-- ── Calendar + Today On Leave ── --}}
    <div class="row mt-4" style="align-items:stretch;">
        <div class="col-md-8" style="position:relative;z-index:0;">
            <div class="card p-4">
                <div class="cal-legend">
                    <div class="cal-legend-item">
                        <div class="cal-legend-dot" style="background:#ef4444;"></div>
                        <span>Upcoming Leave</span>
                    </div>
                    <div class="cal-legend-item">
                        <div class="cal-legend-dot" style="background:#22c55e;"></div>
                        <span>Covering Day (Off)</span>
                    </div>
                    <div class="cal-legend-item">
                        <div class="cal-legend-dot" style="background:#9ca3af;"></div>
                        <span>Past Leave</span>
                    </div>
                    <div class="cal-legend-item">
                        <div class="cal-legend-dot" style="background:#f97316;"></div>
                        <span>Public Holiday</span>
                    </div>
                    <div class="cal-legend-item">
                        <div class="cal-legend-dot" style="background:#fef08a;border:1.5px solid #f59e0b;"></div>
                        <span>Today</span>
                    </div>
                    <div class="cal-legend-item">
                        <div class="cal-legend-dot" style="background:#ffe4e4;border:1px solid #fca5a5;"></div>
                        <span style="color:#000;">Saturday</span>
                    </div>
                    <div class="cal-legend-item">
                        <div class="cal-legend-dot" style="background:#c75f53;"></div>
                        <span>Sunday</span>
                    </div>
                </div>
                <div id="leaveCalendarDashboard"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 shadow-sm border-0 rounded-2 h-100">
                <h4 class="card-title mb-3 fw-semibold">
                    On Leave Today
                    <small id="todayDateLabel" style="font-size:14px;font-weight:400;color:#9ca3af;margin-left:10px;"></small>
                </h4>
                <div id="todayLeaveList" style="overflow-y:auto;">
                    <div class="text-center text-muted py-4" style="font-size:13px;">
                        <i class="fa fa-spinner fa-spin"></i> Loading...
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Pending Leave Approvals ── --}}
    <div class="row mt-4" style="margin-bottom:50px;">
        <div class="col-md-12">
            <div class="card p-4 shadow-sm border-0 rounded-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <h5 class="card-title mb-0 fw-semibold">Pending Leave Approvals</h5>
                        <span id="pendingBadge" class="badge" style="background:#fef3c7;color:#92400e;font-size:11px;padding:4px 10px;border-radius:20px;font-weight:500;">0 pending</span>
                    </div>
                    <a href="{{ url('/Recruitment/Onboard') }}" style="font-size:12px;color:#3b82f6;text-decoration:none;">View all &rarr;</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center mb-0" style="width:100%;">
                        <thead style="background:#f9fafb;">
                            <tr>
                                <th style="font-size:11px;color:#6b7280;font-weight:500;padding:10px 16px;border-bottom:1px solid #e5e7eb;">EMPLOYEE</th>
                                <th style="font-size:11px;color:#6b7280;font-weight:500;padding:10px 16px;border-bottom:1px solid #e5e7eb;">LEAVE TYPE</th>
                                <th style="font-size:11px;color:#6b7280;font-weight:500;padding:10px 16px;border-bottom:1px solid #e5e7eb;">DURATION</th>
                                <th style="font-size:11px;color:#6b7280;font-weight:500;padding:10px 16px;border-bottom:1px solid #e5e7eb;">DAYS</th>
                                <th style="font-size:11px;color:#6b7280;font-weight:500;padding:10px 16px;border-bottom:1px solid #e5e7eb;">STATUS</th>
                                <th style="font-size:11px;color:#6b7280;font-weight:500;padding:10px 16px;border-bottom:1px solid #e5e7eb;">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody id="pendingLeaveBody">
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted" style="font-size:13px;">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@include('pages.hr_module.Leave_Managment.leave_balance_modal')

{{-- ── Team Members Modal ── --}}
<div class="modal fade" id="teamMembersModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:480px;">
        <div class="modal-content" style="border:none;border-radius:16px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.15);">
            <div class="modal-header" style="background:#1e293b;padding:18px 24px;border:none;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div id="teamModalIcon" style="width:38px;height:38px;border-radius:10px;background:#334155;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#94a3b8;"></div>
                    <div>
                        <div style="font-size:15px;font-weight:600;color:#f1f5f9;" id="teamModalTitle">Team</div>
                        <div style="font-size:12px;color:#64748b;" id="teamModalCount">0 members</div>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" style="background:none;border:none;color:#64748b;font-size:22px;line-height:1;padding:2px 8px;margin-left:auto;">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding:0;background:#fff;max-height:420px;overflow-y:auto;">
                <div id="teamMembersList" style="padding:8px 0;">
                    <div class="text-center py-4 text-muted" style="font-size:13px;">
                        <i class="fa fa-spinner fa-spin"></i> Loading...
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="padding:12px 20px;border-top:1px solid #e2e8f0;background:#f8fafc;">
                <button type="button" class="btn" data-dismiss="modal" style="background:#e2e8f0;color:#475569;border:none;border-radius:8px;padding:8px 18px;font-size:13px;font-weight:500;">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- ── Approve Modal ── --}}
<div class="modal fade" id="leave_Approve_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width:580px;">
        <div class="modal-content" style="border:none;border-radius:16px;overflow:hidden;">

            <div class="modal-header" style="background:#1e293b;padding:18px 24px;border:none;display:flex;align-items:center;justify-content:space-between;">
                <div style="display:flex;align-items:center;gap:14px;">
                    <div id="modalAvatar" style="width:44px;height:44px;border-radius:50%;background:#334155;display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:600;color:#94a3b8;flex-shrink:0;">??</div>
                    <div>
                        <div style="font-size:15px;font-weight:600;color:#f1f5f9;" id="reqname">-</div>
                        <div style="font-size:12px;color:#64748b;margin-top:2px;" id="modalSubtitle">Leave Request</div>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" style="background:none;border:none;color:#64748b;font-size:22px;line-height:1;padding:2px 8px;">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body" style="padding:22px 24px;background:#fff;">

                {{-- Dynamic leave balance pills — rendered by JS from the API --}}
                <div id="leaveBalancePills" style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:18px;">
                    <span style="font-size:12px;color:#94a3b8;padding:6px 0;">
                        <i class="fa fa-spinner fa-spin"></i> Loading...
                    </span>
                </div>

                <div style="font-size:11px;font-weight:600;color:#94a3b8;letter-spacing:.06em;text-transform:uppercase;margin-bottom:10px;">Employee details</div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:18px;">
                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:10px 14px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;">Employee name</div>
                        <div style="font-size:13px;font-weight:600;color:#1e293b;" id="employee_name">-</div>
                    </div>
                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:10px 14px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;">Employment status</div>
                        <div style="font-size:13px;font-weight:600;" id="employee_status">-</div>
                    </div>
                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:10px 14px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;">Request title</div>
                        <div style="font-size:13px;font-weight:600;color:#1e293b;" id="requestTitle">-</div>
                    </div>
                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:10px 14px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;">Leave category</div>
                        <div style="font-size:13px;font-weight:600;color:#1e293b;" id="leaveCategory">-</div>
                    </div>
                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:10px 14px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;">Leave type</div>
                        <div style="font-size:13px;font-weight:600;color:#1e293b;" id="leaveTypeLabel">-</div>
                    </div>
                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:10px 14px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;">Day type</div>
                        <div style="font-size:13px;font-weight:600;color:#1e293b;" id="dayTypeLabel">-</div>
                    </div>
                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:10px 14px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;">Total leave days</div>
                        <div style="font-size:13px;font-weight:600;color:#1e293b;" id="total_leave_days">-</div>
                    </div>
                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:10px 14px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;">Request status</div>
                        <div id="requestStatusDisplay" style="font-size:13px;font-weight:600;">-</div>
                    </div>
                </div>

                <div style="font-size:11px;font-weight:600;color:#94a3b8;letter-spacing:.06em;text-transform:uppercase;margin-bottom:10px;">Leave schedule</div>
                <table class="table" style="font-size:13px;margin-bottom:18px;border-collapse:collapse;width:100%;">
                    <thead>
                        <tr style="background:#f1f5f9;">
                            <th style="font-size:11px;color:#64748b;font-weight:600;text-transform:uppercase;padding:8px 12px;border-bottom:1px solid #e2e8f0;">Date</th>
                            <th style="font-size:11px;color:#64748b;font-weight:600;text-transform:uppercase;padding:8px 12px;border-bottom:1px solid #e2e8f0;">Day type</th>
                        </tr>
                    </thead>
                    <tbody id="leaveScheduleBody"></tbody>
                </table>

                <div style="font-size:11px;font-weight:600;color:#94a3b8;letter-spacing:.06em;text-transform:uppercase;margin-bottom:10px;">Reason for leave</div>
                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:12px 14px;font-size:13px;color:#475569;line-height:1.6;margin-bottom:18px;" id="leaveReason">-</div>

                <div id="conflictMessageSection" style="display:none;">
                    <div id="adminLeaveConflictMessage"></div>
                </div>
            </div>

            <div class="modal-footer" style="padding:14px 24px;border-top:1px solid #e2e8f0;background:#fff;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:12px;color:#94a3b8;" id="modalTimestamp"></span>
                <div style="display:flex;gap:8px;">
                    <button type="button" class="btn" data-dismiss="modal" style="background:#f1f5f9;color:#475569;border:none;border-radius:8px;padding:8px 18px;font-size:13px;font-weight:500;">Close</button>
                    <button type="button" class="btn reject-btn d-none" id="rejectBtn" style="background:#fee2e2;color:#b91c1c;border:none;border-radius:8px;padding:8px 18px;font-size:13px;font-weight:500;">Reject</button>
                    <button type="button" class="btn approve-btn d-none" id="approveBtn" style="background:#22c55e;color:#fff;border:none;border-radius:8px;padding:8px 18px;font-size:13px;font-weight:500;">Approve</button>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .header-layout {
        margin-bottom: 0 !important;
    }

    .employee-stats-row {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        margin: 0;
        width: 100%;
    }

    .stat-card {
        flex: 1 1 0;
        min-width: 140px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .06);
        padding: 16px 20px;
        display: flex;
        align-items: center;
        transition: transform .2s, box-shadow .2s;
        cursor: pointer;
        color: inherit;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, .12);
    }

    @media(max-width:991px) {
        .stat-card {
            flex: 1 1 calc(50% - 8px);
        }
    }

    @media(max-width:575px) {
        .stat-card {
            flex: 1 1 100%;
        }
    }

    .stat-icon {
        width: 10px;
        height: 10px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        margin-right: 20px;
        flex-shrink: 0;
    }

    .stat-content {
        flex: 1;
    }

    .stat-label {
        margin: 0;
        font-size: 13px;
        font-weight: 500;
        color: #6b7280;
        line-height: 1.2;
    }

    .stat-number {
        margin: 4px 0 0;
        font-size: 20px;
        font-weight: 700;
        line-height: 1;
        color: #1f2937;
    }

    .stat-card.total .stat-icon {
        background: #ecfdf5;
        color: #10b981;
    }

    .stat-card.design .stat-icon {
        background: #ecfdf5;
        color: #059669;
    }

    .stat-card.development .stat-icon {
        background: #eff6ff;
        color: #3b82f6;
    }

    .stat-card.marketing .stat-icon {
        background: #fef2f2;
        color: #ec4899;
    }

    .stat-card.executives .stat-icon {
        background: #f3e8ff;
        color: #8b5cf6;
    }

    #leaveCalendarDashboard {
        width: 100%;
        /* height: 300px; */
    }

    .fc .fc-toolbar-title {
        font-size: 14px;
        font-weight: 600;
    }

    .fc-daygrid-day-number {
        font-size: 11px;
    }

    .fc-event {
        font-size: 10px;
        padding: 2px;
    }

    .team-member-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
        border-bottom: 1px solid #f1f5f9;
        text-decoration: none;
        color: inherit;
        transition: background .15s;
    }

    .team-member-row:hover {
        background: #f8fafc;
        text-decoration: none;
        color: inherit;
    }

    .team-member-row:last-child {
        border-bottom: none;
    }

    .fc .fc-leaveLabel-button {
        background: none !important;
        border: none !important;
        box-shadow: none !important;
        color: #2b4885 !important;
        font-size: 16px !important;
        font-weight: 600 !important;
        padding: 0 !important;
        cursor: default !important;
        pointer-events: none;
    }

    /* Today cell — yellow highlight */
    .fc .fc-day-today {
        background-color: #fef08a !important;
        box-shadow: inset 0 0 0 2px #f59e0b;
    }

    .fc .fc-day-today .fc-daygrid-day-number {
        background: #f59e0b;
        color: #fff;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 11px;
        margin: 3px;
    }

    .fc .fc-day-today.fc-day-sat,
    .fc .fc-day-today.fc-day-sun {
        background-color: #fef08a !important;
    }

    /* ── Calendar Legend ─────────────────────────────── */
    .cal-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        align-items: center;
        margin-bottom: 10px;
        font-size: 12px;
        color: #374151;
    }

    .cal-legend-item {
        display: flex;
        align-items: center;
        gap: 5px;
        font-weight: 500;
    }

    .cal-legend-dot {
        width: 13px;
        height: 13px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .cal-legend {
        flex-wrap: nowrap !important;
        overflow-x: auto;
        white-space: nowrap;
        gap: 12px;
        font-size: 11px;
    }

    .cal-legend-item span {
        white-space: nowrap;
    }

    /* ── Sat / Sun column widths & colors ───────────── */
    /* Narrow weekend columns */
    .fc .fc-col-header-cell.fc-day-sat,
    .fc .fc-col-header-cell.fc-day-sun,
    .fc .fc-daygrid-day.fc-day-sat,
    .fc .fc-daygrid-day.fc-day-sun {
        width: 10% !important;
        min-width: 36px !important;
        max-width: 54px !important;
    }

    /* Weekend styling for non-today cells */
    .fc .fc-daygrid-day.weekend-sat:not(.fc-day-today),
    .fc .fc-daygrid-day.weekend-sun:not(.fc-day-today) {
        background-color: #fde8e8 !important;
    }

    .fc .fc-daygrid-day.weekend-sat:not(.fc-day-today) .fc-daygrid-day-number {
        color: #000000 !important;
    }

    .fc .fc-daygrid-day.weekend-sun:not(.fc-day-today) .fc-daygrid-day-number {
        color: #c0392b !important;
    }
</style>

<style>
    @media (max-width: 767px) {

    /* ===== Page padding ===== */
    div[style*="f4f7f6"] {
        padding: 10px !important;
    }

    /* ===== Stat cards: force 2 columns, last card full width ===== */
    .employee-stats-row {
        gap: 10px !important;
    }
    .stat-card {
        flex: 1 1 calc(50% - 5px) !important;
        min-width: 0 !important;
        padding: 12px 14px !important;
    }
    .stat-card:last-child,
    .stat-card.executives,
    .employee-stats-row .stat-card:nth-child(5) {
        flex: 1 1 100% !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }
    .stat-icon {
        width: 34px !important;
        height: 34px !important;
        margin-right: 10px !important;
        font-size: 15px !important;
    }
    .stat-number {
        font-size: 18px !important;
    }
    .stat-label {
        font-size: 11px !important;
    }

    /* ===== Calendar + On Leave Today cards: tighter spacing ===== */
    .card.p-4 {
        padding: 14px !important;
    }
    .cal-legend {
        gap: 8px !important;
        font-size: 10px !important;
    }
    .fc .fc-toolbar-title {
        font-size: 13px !important;
    }
    .fc-daygrid-day-number {
        font-size: 10px !important;
    }

    /* ===== Pending Leave Approvals: table -> stacked cards ===== */
    .table-responsive thead {
        display: none !important;
    }
    #pendingLeaveBody tr {
        display: grid;
        grid-template-columns: auto 1fr;
        grid-template-areas:
            "emp action"
            "type days"
            "dur status";
        row-gap: 8px;
        column-gap: 10px;
        align-items: center;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 14px !important;
        margin-bottom: 12px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }
    /* Loading / empty / error rows (single <td colspan="6">) — show as plain centered text, not a broken card */
    #pendingLeaveBody tr:has(td[colspan]) {
        display: block !important;
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        margin-bottom: 0 !important;
    }
    #pendingLeaveBody td {
        border: none !important;
        padding: 0 !important;
        white-space: normal !important;
    }
    #pendingLeaveBody td:nth-child(1) { grid-area: emp; }
    #pendingLeaveBody td:nth-child(2) { grid-area: type; }
    #pendingLeaveBody td:nth-child(3) { grid-area: dur; font-size: 12px !important; }
    #pendingLeaveBody td:nth-child(4) { grid-area: days; justify-self: start; }
    #pendingLeaveBody td:nth-child(5) { grid-area: status; justify-self: end; }
    #pendingLeaveBody td:nth-child(6) { grid-area: action; justify-self: end; }

    .back_home_mobile {
        padding-left: 5px;
        padding-top: 20px;
    }

    .card.p-4.shadow-sm.border-0.rounded-2.h-100 {
        margin-top: 16px;
    }

    h5.card-title.mb-0.fw-semibold {
        padding-right: 23px;
        font-size: .9375rem;
    }

    #pendingLeaveBody,
    #pendingLeaveBody table,
    table:has(#pendingLeaveBody) {
        display: block !important;
        width: 100% !important;
    }

    .cal-legend {
        flex-wrap: nowrap !important;
        overflow-x: auto;
        white-space: nowrap;
        gap: 12px;
        font-size: 11px;
    }

    .cal-legend {
        scrollbar-width: none;      /* Firefox */
        -ms-overflow-style: none;   /* old Edge/IE */
    }
    .cal-legend::-webkit-scrollbar {
        display: none;              /* Chrome, Safari, most mobile browsers */
    }

    .cal-legend-item span {
        white-space: nowrap;
    }
    .close>span:not(.sr-only) {
        color: rgb(205 205 205 / 60%) !important;
    }

    
}

.row.employee-stats-row {
    padding-top: 25px;
}

@media (min-width: 768px) {
    .back_home_mobile {
        display: none;
    }
}
</style>


<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

<script>
    var EMPLOYEE_VIEW_BASE = "{{ url('/view/employee') }}";
    var APP_BASE_URL = "{{ url('/') }}";
</script>

<script>
    $(document).ready(function() {

        var _now = new Date();
        var _months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $('#todayDateLabel').text(_months[_now.getMonth()] + ' ' + _now.getDate() + ', ' + _now.getFullYear());

        /* ── Helpers ─────────────────────────────────────────────────────────── */

        function parseDate(str) {
            if (!str) {
                return null;
            }
            var p = str.split('/');
            return new Date(+p[2], +p[0] - 1, +p[1]);
        }

        function fmtDate(str) {
            if (!str) {
                return '';
            }
            var p = str.split('/');
            var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            return months[+p[0] - 1] + ' ' + (+p[1]) + ', ' + p[2];
        }

        function strContains(haystack, needle) {
            return (haystack || '').toLowerCase().indexOf(needle) >= 0;
        }

        function pillStyle(type) {
            var t = (type || '').toLowerCase();
            if (strContains(t, 'annual')) {
                return 'background:#dbeafe;color:#1e40af;';
            }
            if (strContains(t, 'casual')) {
                return 'background:#d1fae5;color:#065f46;';
            }
            if (strContains(t, 'sick') || strContains(t, 'medical')) {
                return 'background:#fef3c7;color:#92400e;';
            }
            return 'background:#f3f4f6;color:#374151;';
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

        function padTwo(n) {
            return n < 10 ? '0' + n : '' + n;
        }

        function mdyToIso(str) {
            var p = str.split('/');
            return p[2] + '-' + padTwo(+p[0]) + '-' + padTwo(+p[1]);
        }

        /*
         * Build avatar HTML for a user object.
         * Shows profile photo if one exists; falls back to coloured initials.
         * Checks common Laravel field names: profile_photo_url, profile_photo,
         * avatar, image, profile_pic, photo.
         * Uses onerror so a broken image URL also falls back gracefully.
         */
        function buildAvatar(u, size) {
            var name = u.name || '-';
            var c = avatarColor(name);
            var ini = getInitials(name);
            var sz = size || 40;
            var fs = Math.round(sz * 0.35) + 'px';

            // Pick whichever image field exists and has a value
            var raw = u.profile_photo_url || u.profile_photo || u.avatar ||
                u.image || u.profile_pic || u.photo || '';

            // Normalise relative paths to absolute
            if (raw && raw.indexOf('http') < 0 && raw.indexOf('data:') < 0) {
                raw = APP_BASE_URL + '/' + raw.replace(/^\/+/, '');
            }

            if (!raw) {
                // No photo — show initials circle only
                return '<div style="' +
                    'width:' + sz + 'px;height:' + sz + 'px;border-radius:50%;' +
                    'background:' + c.bg + ';color:' + c.fg + ';' +
                    'display:flex;align-items:center;justify-content:center;' +
                    'font-size:' + fs + ';font-weight:700;flex-shrink:0;line-height:1;">' +
                    ini + '</div>';
            }

            // Has a photo URL.
            // Initials layer sits at the bottom (always visible).
            // Photo layer sits on top — if it fails to load, it hides itself, revealing initials.
            var html = '';
            html += '<div style="width:' + sz + 'px;height:' + sz + 'px;border-radius:50%;';
            html += 'flex-shrink:0;position:relative;overflow:hidden;">';

            // Initials always rendered underneath
            html += '<div style="position:absolute;top:0;left:0;';
            html += 'width:' + sz + 'px;height:' + sz + 'px;border-radius:50%;';
            html += 'background:' + c.bg + ';color:' + c.fg + ';';
            html += 'display:flex;align-items:center;justify-content:center;';
            html += 'font-size:' + fs + ';font-weight:700;line-height:1;">' + ini + '</div>';

            // Photo on top — hides on error, initials show through
            html += '<img src="' + raw + '" alt="' + name + '"';
            html += ' style="position:absolute;top:0;left:0;';
            html += 'width:' + sz + 'px;height:' + sz + 'px;';
            html += 'border-radius:50%;object-fit:cover;"';
            html += ' onerror="this.style.display=\'none\';">';

            html += '</div>';
            return html;
        }

        /* ── Step 1: Employee counts ─────────────────────────────────────────── */
        var allActiveUsers = [];

        $.get("{{ route('HR.employee_summary_table_data') }}", function(users) {
            if (!$.isArray(users)) {
                $('.stat-number').text('-');
                return;
            }

            var active = [];
            for (var i = 0; i < users.length; i++) {
                if (users[i].active == 1) {
                    active.push(users[i]);
                }
            }
            allActiveUsers = active;

            var design = 0,
                dev = 0,
                marketing = 0,
                exec = 0;
            for (var j = 0; j < active.length; j++) {
                var dept = '';
                if (active[j].user_details && active[j].user_details.Department) {
                    dept = active[j].user_details.Department.toLowerCase();
                }
                if (dept == 'design') {
                    design++;
                } else if (dept == 'development') {
                    dev++;
                } else if (dept == 'marketing') {
                    marketing++;
                } else if (dept == 'admin') {
                    exec++;
                }
            }

            $('#totalEmployees').text(active.length);
            $('#designCount').text(design);
            $('#devCount').text(dev);
            $('#marketingCount').text(marketing);
            $('#executivesCount').text(exec);

        }).fail(function() {
            $('.stat-number').text('-');
        });

        /* ── Step 2: Department card click → team modal ──────────────────────── */
        var DEPT_META = {
            'design': {
                label: 'Design Team',
                icon: 'DSN'
            },
            'development': {
                label: 'Development Team',
                icon: 'DEV'
            },
            'marketing': {
                label: 'Marketing Team',
                icon: 'MKT'
            },
            'admin': {
                label: 'Executives',
                icon: 'EXC'
            }
        };

        $(document).on('click', '.dept-card', function() {
            var dept = $(this).data('dept');
            var meta = DEPT_META[dept];
            if (!meta) {
                meta = {
                    label: dept,
                    icon: '?'
                };
            }

            var members = [];
            for (var i = 0; i < allActiveUsers.length; i++) {
                var u = allActiveUsers[i];
                var uDept = '';
                if (u.user_details && u.user_details.Department) {
                    uDept = u.user_details.Department.toLowerCase();
                }
                if (uDept == dept) {
                    members.push(u);
                }
            }

            $('#teamModalIcon').text(meta.icon);
            $('#teamModalTitle').text(meta.label);
            $('#teamModalCount').text(members.length + (members.length == 1 ? ' member' : ' members'));

            if (members.length == 0) {
                $('#teamMembersList').html(
                    '<div class="text-center py-5" style="color:#9ca3af;font-size:13px;">No members in this team</div>'
                );
            } else {
                var html = '';
                for (var k = 0; k < members.length; k++) {
                    var u = members[k];
                    var name = u.name || '-';
                    var position = '-';
                    if (u.user_details) {
                        position = u.user_details.Position || u.user_details.Designation || '-';
                    }
                    var link = EMPLOYEE_VIEW_BASE + '/' + u.id;

                    html += '<a href="' + link + '" class="team-member-row">';
                    html += buildAvatar(u, 40); // ← photo or initials
                    html += '<div style="flex:1;min-width:0;">';
                    html += '<div style="font-size:13px;font-weight:600;color:#111827;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + name + '</div>';
                    html += '<div style="font-size:11px;color:#9ca3af;margin-top:2px;">' + position + '</div>';
                    html += '</div>';
                    html += '<div style="color:#9ca3af;font-size:16px;">&rsaquo;</div>';
                    html += '</a>';
                }
                $('#teamMembersList').html(html);
            }

            $('#teamMembersModal').modal('show');
        });

        /* ── Step 3: Leave data ──────────────────────────────────────────────── */
        var calendarInstance = null;

        function loadLeaveData() {
            $.get("{{ url('/leave-Manage/getrequests') }}", function(data) {

                var today = new Date();
                today.setHours(0, 0, 0, 0);
                var t = today.getTime();

                // ── Safe date helpers ─────────────────────────────────────────
                function safeMdyToIso(str) {
                    if (!str || str.trim() === '') return null;
                    var p = str.split('/');
                    if (p.length !== 3) return null;
                    return p[2] + '-' + padTwo(+p[0]) + '-' + padTwo(+p[1]);
                }

                function safeParseDate(str) {
                    if (!str || str.trim() === '') return null;
                    var p = str.split('/');
                    if (p.length !== 3) return null;
                    return new Date(+p[2], +p[0] - 1, +p[1]);
                }

                /* 3a. Calendar events ──────────────────────────────────────── */
                var calEvents = [];

                // Public Holidays
                var yr = new Date().getFullYear();
                var companyHolidays = [{
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
                ];
                for (var h = 0; h < companyHolidays.length; h++) {
                    calEvents.push({
                        title: '🏖 ' + companyHolidays[h].title,
                        start: companyHolidays[h].date,
                        color: '#f97316',
                        textColor: '#fff',
                        display: 'block',
                        editable: false
                    });
                }

                for (var i = 0; i < data.length; i++) {
                    var l = data[i];
                    if (l.status != 1) continue;

                    var name = (l.user_details && l.user_details.name) ? l.user_details.name : 'Employee';

                    // ── Covering Day (type 4) ─────────────────────────────────
                    if (l.type == 4) {
                        var offISO = safeMdyToIso(l.covering_leave_date);
                        if (offISO) {
                            var isPastCov = new Date(offISO).getTime() < t;
                            calEvents.push({
                                title: name + ' (Off)',
                                start: offISO,
                                color: isPastCov ? '#9ca3af' : '#22c55e',
                                textColor: '#fff'
                            });
                        }
                        continue; // skip start_date for covering
                    }

                    // ── Normal leave ──────────────────────────────────────────
                    var startISO = safeMdyToIso(l.start_date);
                    if (!startISO) continue;

                    var endISO = (l.end_date && l.end_date.trim() !== '') ?
                        safeMdyToIso(l.end_date) :
                        startISO;
                    if (!endISO) endISO = startISO;

                    var cur = new Date(startISO);
                    var endD = new Date(endISO);

                    while (cur <= endD) {
                        var iso = cur.getFullYear() + '-' + padTwo(cur.getMonth() + 1) + '-' + padTwo(cur.getDate());
                        var isPast = cur.getTime() < t;
                        calEvents.push({
                            title: name,
                            start: iso,
                            color: isPast ? '#9ca3af' : '#ef4444',
                            textColor: '#fff'
                        });
                        cur.setDate(cur.getDate() + 1);
                    }
                }

                var calEl = document.getElementById('leaveCalendarDashboard');
                if (!calendarInstance) {
                    calendarInstance = new FullCalendar.Calendar(calEl, {
                        initialView: 'dayGridMonth',
                        initialDate: new Date(),
                        customButtons: {
                            leaveLabel: {
                                text: 'Leave Calendar',
                                click: function() {}
                            }
                        },
                        headerToolbar: {
                            left: 'leaveLabel',
                            center: 'title',
                            right: 'prev,next'
                        },
                        height: 'auto',
                        firstDay: 1,
                        fixedWeekCount: false,
                        events: calEvents,
                        dayCellClassNames: function(arg) {
                            const day = arg.date.getDay();
                            if (arg.isToday) return [];
                            if (day === 6) return ['weekend-sat'];
                            if (day === 0) return ['weekend-sun'];
                            return [];
                        },
                    });
                    calendarInstance.render();
                } else {
                    calendarInstance.removeAllEvents();
                    for (var e = 0; e < calEvents.length; e++) {
                        calendarInstance.addEvent(calEvents[e]);
                    }
                }

                /* 3b. On Leave Today ────────────────────────────────────────── */
                var todayLeaves = [];
                for (var j = 0; j < data.length; j++) {
                    var l = data[j];
                    if (l.status != 1) continue;

                    // Covering day: check covering_leave_date
                    if (l.type == 4) {
                        var covDate = safeParseDate(l.covering_leave_date);
                        if (covDate && covDate.getTime() === t) {
                            todayLeaves.push(l);
                        }
                        continue;
                    }

                    // Normal leave
                    var s = safeParseDate(l.start_date);
                    if (!s) continue;
                    var ev = l.end_date && l.end_date.trim() !== '' ?
                        safeParseDate(l.end_date) :
                        s;
                    if (!ev) ev = s;
                    if (s.getTime() <= t && ev.getTime() >= t) {
                        todayLeaves.push(l);
                    }
                }

                var listEl = $('#todayLeaveList');
                if (todayLeaves.length == 0) {
                    listEl.html(
                        '<div class="text-center py-4">' +
                        '<div style="font-size:36px;">&#127881;</div>' +
                        '<div style="font-size:13px;font-weight:600;color:#111827;margin:6px 0 4px;">No leaves today</div>' +
                        '<div style="font-size:12px;color:#9ca3af;">Everyone is in today!</div>' +
                        '</div>'
                    );
                } else {
                    var html = '';
                    for (var k = 0; k < todayLeaves.length; k++) {
                        var l = todayLeaves[k];
                        var name = (l.user_details && l.user_details.name) ? l.user_details.name : '-';
                        var dept = '-';
                        if (l.user_details && l.user_details.user_details && l.user_details.user_details.Department) {
                            dept = l.user_details.user_details.Department;
                        }
                        var type = l.type == 4 ? 'Covering Day' : (l.leave_type || '-');
                        html += '<div class="today-leave-row" data-leaveid="' + l.id + '" style="display:flex;align-items:center;gap:10px;padding:9px 0;border-bottom:1px solid #f3f4f6;cursor:pointer;transition:background .15s;border-radius:6px;padding-left:4px;">';
                        html += buildAvatar(l.user_details, 36);
                        html += '<div style="flex:1;min-width:0;">';
                        html += '<div style="font-size:13px;font-weight:500;color:#111827;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + name + '</div>';
                        html += '<div style="font-size:11px;color:#9ca3af;">' + dept + '</div>';
                        html += '</div>';
                        html += '<span style="font-size:11px;font-weight:500;padding:3px 10px;border-radius:20px;flex-shrink:0;' + pillStyle(type) + '">' + type + '</span>';
                        html += '</div>';
                    }
                    html += '<div style="margin-top:10px;font-size:12px;color:#6b7280;text-align:right;">' +
                        todayLeaves.length + ' employee' + (todayLeaves.length == 1 ? '' : 's') + ' on leave today' +
                        '</div>';
                    listEl.html(html);
                }

                /* 3c. Pending table ─────────────────────────────────────────── */
                var pending = [];
                for (var p = 0; p < data.length; p++) {
                    if (data[p].status == 0) pending.push(data[p]);
                }
                pending.sort(function(a, b) {
                    return b.id - a.id;
                });
                $('#pendingBadge').text(pending.length + ' pending');

                if (pending.length == 0) {
                    $('#pendingLeaveBody').html('<tr><td colspan="6" class="text-center py-4 text-muted" style="font-size:13px;">No pending leave requests</td></tr>');
                    return;
                }

                var rows = '';
                var limit = Math.min(pending.length, 5);
                for (var r = 0; r < limit; r++) {
                    var item = pending[r];
                    var name = (item.user_details && item.user_details.name) ? item.user_details.name : '-';
                    var dept = (item.user_details && item.user_details.user_details && item.user_details.user_details.Department) ?
                        item.user_details.user_details.Department : '-';
                    var type = item.leave_type ?
                        item.leave_type.charAt(0).toUpperCase() + item.leave_type.slice(1).toLowerCase() : '-';

                    var duration = fmtDate(item.start_date);
                    if (item.type == 4) {
                        duration = (item.covering_leave_date || '—') + ' → ' + (item.covering_cover_date || '—');
                    } else if (item.end_date && item.end_date !== item.start_date) {
                        duration = fmtDate(item.start_date) + ' - ' + fmtDate(item.end_date);
                    }

                    var leaveTypeNum = parseInt(item.type, 10);
                    var days = '-';
                    if (leaveTypeNum === 0) days = 'Half Day (' + (parseInt(item.day_type, 10) === 0 ? 'Morning' : 'Evening') + ')';
                    else if (leaveTypeNum === 1) days = 'One Day';
                    else if (leaveTypeNum === 2) days = 'Multiple Days';
                    else if (leaveTypeNum === 3) days = 'Short Leave';
                    else if (leaveTypeNum === 4) days = 'Covering Day';

                    rows += '<tr style="border-bottom:1px solid #f3f4f6;">';
                    rows += '<td style="padding:12px 16px;"><div style="display:flex;align-items:center;gap:10px;">';
                    rows += buildAvatar(item.user_details, 30);
                    rows += '<div><div style="font-size:13px;font-weight:500;color:#111827;">' + name + '</div>';
                    rows += '<div style="font-size:11px;color:#6b7280;">' + dept + '</div></div></div></td>';
                    rows += '<td style="padding:12px 16px;" class="type"><span style="font-size:11px;padding:3px 9px;border-radius:20px;font-weight:500;' + pillStyle(type) + '">' + type + '</span></td>';
                    rows += '<td style="padding:12px 16px;font-size:12px;color:#6b7280;">' + duration + '</td>';
                    rows += '<td style="padding:12px 16px;font-size:13px;font-weight:500;color:#111827;" class="days">' + days + '</td>';
                    rows += '<td style="padding:12px 16px;"><span style="font-size:11px;font-weight:500;color:#d97706;"><span style="display:inline-block;width:7px;height:7px;border-radius:50%;background:#f59e0b;margin-right:4px;vertical-align:middle;"></span>Pending</span></td>';
                    rows += '<td style="padding:12px 16px;"><button class="viewrequest btn btn-success btn-sm" data-leaveid="' + item.id + '" data-type="' + item.type + '" data-daytype="' + (item.day_type != null ? item.day_type : 0) + '" style="font-size:12px;padding:4px 12px;border-radius:6px;">Approve</button></td>';
                    rows += '</tr>';
                }
                $('#pendingLeaveBody').html(rows);

            }).fail(function() {
                $('#todayLeaveList').html('<div class="text-center text-muted py-4">Failed to load data.</div>');
                $('#pendingLeaveBody').html('<tr><td colspan="6" class="text-center py-4 text-danger">Failed to load.</td></tr>');
            });
        }
        loadLeaveData();

        /* ── Step 4: Open leave modal (shared by pending table + today list) ─── */
        function openLeaveModal(leaveId, rowType, rowDayType, viewOnly) {
            $('#leaveScheduleBody').empty();
            $('#adminLeaveConflictMessage').html('');
            $('#conflictMessageSection').hide();
            $('#reqname').text('-');
            $('#modalAvatar').text('??');
            $('#leaveBalancePills').html('<span style="font-size:12px;color:#94a3b8;padding:6px 0;"><i class="fa fa-spinner fa-spin"></i> Loading...</span>');

            $.get("{{ url('/leave-Manage/getLeaveRequestDetails') }}", {
                leave_id: leaveId
            }, function(r) {

                if (!r.success) {
                    alert(r.message);
                    return;
                }

                $('#modalAvatar').text(getInitials(r.leave.employee_name || '-'));
                $('#reqname').text(r.leave.employee_name || '-');
                $('#modalSubtitle').text('Leave Request #' + (r.leave.id || ''));
                $('#employee_name').text(r.leave.employee_name || '-');
                $('#requestTitle').text(
                    r.leave.request_title ?
                    r.leave.request_title.charAt(0).toUpperCase() + r.leave.request_title.slice(1).toLowerCase() :
                    '-'
                );
                $('#leaveCategory').text(
                    r.leave.leave_category ?
                    r.leave.leave_category.charAt(0).toUpperCase() + r.leave.leave_category.slice(1).toLowerCase() :
                    '-'
                );
                $('#leaveTypeLabel').text(r.leave.leave_type || '-');
                $('#dayTypeLabel').text(r.leave.day_type_label || '-');
                $('#total_leave_days').text(r.leave.total_leave_days || '-');

                var empStatus = r.leave.employee_status || '-';
                $('#employee_status').css('color', empStatus == 'Active' ? '#059669' : '#dc2626').text(empStatus);

                // Status mapping
                var statusMap = {
                    0: {
                        text: 'Pending review',
                        color: '#d97706'
                    },
                    1: {
                        text: 'Approved',
                        color: '#059669'
                    },
                    2: {
                        text: 'Rejected',
                        color: '#dc2626'
                    }
                };
                var leaveStatus = r.leave.status;
                var statusInfo = statusMap[leaveStatus] || statusMap[0];
                $('#requestStatusDisplay')
                    .css('color', statusInfo.color)
                    .text(statusInfo.text);

                var DOT_COLORS = ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899', '#06b6d4', '#f97316'];
                $.get("{{ url('/leave-Manage/getLeaveBalance') }}/" + r.leave.user_id, function(bal) {
                    if (bal && bal.success && bal.balances && bal.balances.length > 0) {
                        var pillsHtml = '';
                        for (var i = 0; i < bal.balances.length; i++) {
                            var it = bal.balances[i];
                            var dotColor = DOT_COLORS[i % DOT_COLORS.length];
                            pillsHtml += '<div style="display:flex;align-items:center;gap:6px;padding:6px 12px;border-radius:8px;border:1px solid #e2e8f0;background:#f8fafc;">';
                            pillsHtml += '<div style="width:8px;height:8px;border-radius:50%;background:' + dotColor + ';flex-shrink:0;"></div>';
                            pillsHtml += '<span style="font-size:11px;color:#64748b;">' + (it.leave_type_name || 'Leave') + '</span>';
                            pillsHtml += '<span style="font-size:12px;font-weight:600;color:#1e293b;">' + it.remaining + ' / ' + it.allocated + '</span>';
                            pillsHtml += '</div>';
                        }
                        $('#leaveBalancePills').html(pillsHtml);
                    } else {
                        $('#leaveBalancePills').html('<span style="font-size:12px;color:#94a3b8;padding:6px 0;">No balance data</span>');
                    }
                }).fail(function() {
                    $('#leaveBalancePills').html('<span style="font-size:12px;color:#94a3b8;padding:6px 0;">Could not load balances</span>');
                });

                var DAY_TYPE_MAP = {
                    0: {
                        label: 'Half Day',
                        style: 'background:#f3f4f6;color:#374151;'
                    },
                    1: {
                        label: 'One Day',
                        style: 'background:#d1fae5;color:#065f46;'
                    },
                    2: {
                        label: 'Multiple Days',
                        style: 'background:#dbeafe;color:#1e40af;'
                    },
                    3: {
                        label: 'Short Leave',
                        style: 'background:#f3e8ff;color:#6b21a8;'
                    },
                    4: {
                        label: 'Covering Day',
                        style: 'background:#fde68a;color:#92400e;'
                    }
                };

                var days = r.leave.leave_days || [];
                var modalLeaveType = parseInt(r.leave.type != null ? r.leave.type : rowType, 10);
                var modalDayType = parseInt(r.leave.day_type != null ? r.leave.day_type : rowDayType, 10);

                // ── Build dayTypeMeta ──────────────────────────────────────────────────
                var dayTypeMeta = DAY_TYPE_MAP[modalLeaveType] || {
                    label: '-',
                    style: 'background:#f3f4f6;color:#374151;'
                };
                if (modalLeaveType === 0) {
                    dayTypeMeta = {
                        label: 'Half Day (' + (modalDayType === 0 ? 'Morning' : 'Evening') + ')',
                        style: 'background:#f3f4f6;color:#374151;'
                    };
                }

                if (days.length > 0) {
                    var schedHtml = '';

                    if (modalLeaveType === 2 && days.length >= 2) {
                        // ── Multiple Days: show as a single range row ──
                        schedHtml += '<tr style="border-bottom:1px solid #f1f5f9;">';
                        schedHtml += '<td style="padding:9px 12px;color:#1e293b;">' +
                            days[0] + ' &mdash; ' + days[days.length - 1] +
                            '</td>';
                        schedHtml += '<td style="padding:9px 12px;"><span style="font-size:11px;font-weight:600;padding:2px 9px;border-radius:20px;' +
                            dayTypeMeta.style + '">' + dayTypeMeta.label + '</span></td>';
                        schedHtml += '</tr>';
                    } else {
                        // ── Half Day / One Day / Short Leave: one row per date ──
                        for (var d = 0; d < days.length; d++) {
                            schedHtml += '<tr style="border-bottom:1px solid #f1f5f9;">';
                            schedHtml += '<td style="padding:9px 12px;color:#1e293b;">' + (days[d] || '-') + '</td>';
                            schedHtml += '<td style="padding:9px 12px;"><span style="font-size:11px;font-weight:600;padding:2px 9px;border-radius:20px;' +
                                dayTypeMeta.style + '">' + dayTypeMeta.label + '</span></td>';
                            schedHtml += '</tr>';
                        }
                    }

                    $('#leaveScheduleBody').html(schedHtml);
                } else {
                    $('#leaveScheduleBody').html('<tr><td colspan="2" style="padding:9px 12px;color:#94a3b8;">No schedule data</td></tr>');
                }

                $('#leaveReason').text(r.leave.leave_reason || '-');

                // Conflict check — only for pending (not view-only)
                if (!viewOnly) {
                    function toMDY(s) {
                        if (!s) return null;
                        var p;
                        if (/^\d{4}-\d{2}-\d{2}$/.test(s)) {
                            p = s.split('-');
                            return p[1] + '/' + p[2] + '/' + p[0];
                        }
                        if (/^\d{2}\/\d{2}\/\d{4}$/.test(s)) {
                            p = s.split('/');
                            return p[1] + '/' + p[0] + '/' + p[2];
                        }
                        return s;
                    }
                    var typeMap = {
                        'Half Day': 0,
                        'One Day': 1,
                        'Multiple Days': 2,
                        'Short Leave': 3
                    };
                    var fromDate = toMDY(days[0]);
                    var toDate = toMDY(days[days.length - 1]);
                    var leaveTypeNum = (typeMap[r.leave.leave_type] != null) ? typeMap[r.leave.leave_type] : (r.leave.type != null ? parseInt(r.leave.type, 10) : 1);
                    if (fromDate) {
                        $.get("{{ url('/check-leave-conflict') }}", {
                            from: fromDate,
                            to: toDate,
                            type: leaveTypeNum
                        }, function(cr) {
                            var ok = cr.success;
                            var bgStyle = ok ? 'background:#f0fdf4;border:1px solid #bbf7d0;' : 'background:#fff7ed;border:1px solid #fed7aa;';
                            var icon = ok ? '&#10003;' : '&#9888;';
                            var titClr = ok ? '#15803d' : '#c2410c';
                            var titTxt = ok ? 'No conflicts found' : 'Leave conflict detected';
                            var bodyClr = ok ? '#166534' : '#9a3412';
                            var bodyTxt = ok ? 'No other approved leaves overlap with this period.' : cr.message;
                            $('#adminLeaveConflictMessage').html(
                                '<div style="border-radius:10px;padding:12px 14px;display:flex;gap:10px;align-items:flex-start;' + bgStyle + '">' +
                                '<div style="font-size:16px;">' + icon + '</div>' +
                                '<div style="font-size:12px;line-height:1.5;">' +
                                '<div style="font-weight:600;color:' + titClr + ';">' + titTxt + '</div>' +
                                '<span style="color:' + bodyClr + ';">' + bodyTxt + '</span>' +
                                '</div></div>'
                            );
                            $('#conflictMessageSection').show();
                        });
                    }
                }

                // Approve/Reject buttons — hide entirely in view-only mode
                if (viewOnly || r.leave.status != 0) {
                    $('#approveBtn, #rejectBtn').addClass('d-none');
                } else {
                    // $('#approveBtn, #rejectBtn').removeClass('d-none').attr('data-leave-id', r.leave.id);
                    $('#approveBtn, #rejectBtn').removeClass('d-none').attr('data-leave-id', r.leave.id).removeData('leave-id');
                }

                $('#leave_Approve_modal').modal('show');

            }).fail(function() {
                alert('Error fetching leave request details.');
            });
        }

        // Pending table row → full modal with conflict + approve/reject
        $(document).on('click', '.viewrequest', function() {
            openLeaveModal(
                $(this).data('leaveid'),
                $(this).data('type'),
                $(this).data('daytype'),
                false // not view-only
            );
        });

        // Today leave row → view-only modal (no conflict check, no action buttons)
        $(document).on('click', '.today-leave-row', function() {
            openLeaveModal(
                $(this).data('leaveid'),
                null,
                null,
                true // view-only
            );
        });
        /* ── Step 5: Approve / Reject ────────────────────────────────────────── */
        function updateLeaveStatus(leaveId, status) {
            $.post("{{ url('/leave-Manage/updateLeaveStatus') }}", {
                leave_id: leaveId,
                status: status,
                _token: $('meta[name="csrf-token"]').attr('content')
            }, function() {
                $('#leave_Approve_modal').modal('hide');
                loadLeaveData();
            }).fail(function() {
                alert('An error occurred while updating the leave status.');
            });
        }

        $(document).on('click', '#approveBtn', function() {
            var id = $(this).attr('data-leave-id');
            if (id) updateLeaveStatus(id, 'approved');
        });
        $(document).on('click', '#rejectBtn', function() {
            var id = $(this).attr('data-leave-id');
            if (id) updateLeaveStatus(id, 'rejected');
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