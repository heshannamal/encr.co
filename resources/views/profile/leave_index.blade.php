@extends('layouts.app', ['activePage' => 'profile.edit', 'titlePage' => __('User Profile')])

@section('content')
<style>
    .lm-toolbar {
        background: #fff;
        border-bottom: 1px solid #e9ecef;
        padding: 10px 16px;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .lm-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 1px 6px rgba(0, 0, 0, .07);
    }

    .filter-pill {
        display: flex;
        align-items: center;
        gap: 6px;
        border: 1px solid #dee2e6;
        border-radius: 50rem;
        padding: 4px 14px;
        background: #f8f9fa;
        font-size: 13px;
    }

    .filter-pill .select2-container {
        min-width: 160px;
    }

    .filter-pill .select2-container--default .select2-selection--single {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        padding: 0;
        height: auto;
    }

    .filter-pill .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #2dce89;
        font-weight: 600;
        font-size: 13px;
        line-height: 1.4;
        padding: 0;
    }

    .filter-pill .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 20px;
        top: 0;
    }

    #adminRemainingText {
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .3px;
    }

    #employee_leave_table tbody tr:hover {
        background: #f0faf6;
    }

    #employee_leave_table td {
        font-size: 13px;
        vertical-align: middle;
    }

    #employee_leave_request_Modal .modal-content {
        border: none;
        border-radius: 14px;
        box-shadow: 0 8px 40px rgba(0, 0, 0, .14);
        overflow: hidden;
    }

    #employee_leave_request_Modal .modal-header {
        background: linear-gradient(135deg, #2dce89 0%, #20b07a 100%);
        padding: 18px 24px;
        border: none;
    }

    #employee_leave_request_Modal .modal-title {
        color: #fff;
        font-weight: 700;
        font-size: 16px;
        margin: 0;
    }

    #employee_leave_request_Modal .modal-header .close {
        color: #fff;
        opacity: .85;
        font-size: 22px;
        padding: 0;
        margin: 0;
    }

    #employee_leave_request_Modal .modal-header .close:hover {
        opacity: 1;
    }

    #employee_leave_request_Modal .modal-body {
        padding: 0;
    }

    #employee_leave_request_Modal .modal-footer {
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
        padding: 12px 20px;
    }

    #lbm_modal_strip {
        background: #f0faf6;
        border-bottom: 1px solid #d4f0e5;
        padding: 10px 20px;
        font-size: 12px;
    }

    #lbm_modal_strip .strip-label {
        color: #20b07a;
        font-weight: 700;
        letter-spacing: .3px;
        margin-right: 6px;
    }

    #lbm_modal_strip .strip-balance {
        color: #343a40;
        font-weight: 600;
    }

    #lbm_modal_strip .strip-group {
        color: #6c757d;
        font-size: 11px;
        margin-top: 2px;
    }

    .lm-form-body {
        padding: 20px 24px;
    }

    .lm-form-body .form-control {
        border-radius: 8px;
        border: 1px solid #ced4da;
        font-size: 13px;
    }

    .lm-form-body .form-control:focus {
        box-shadow: 0 0 0 3px rgba(45, 206, 137, .2);
        border-color: #2dce89;
    }

    .lm-form-body label {
        font-size: 12px;
        font-weight: 600;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: .4px;
        margin-bottom: 4px;
    }

    .lm-form-body textarea.form-control {
        min-height: 90px;
        resize: vertical;
    }

    .lm-form-body .select2-container--default .select2-selection--single {
        border-radius: 8px !important;
        border: 1px solid #ced4da !important;
        height: calc(1.5em + .75rem + 2px) !important;
    }

    .lm-form-body .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: calc(1.5em + .75rem) !important;
        font-size: 13px;
    }

    .lm-form-body .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: calc(1.5em + .75rem) !important;
    }

    .leave-div {
        display: none;
    }

    .leave-div.show {
        display: flex;
    }

    #leaveConflictMessage {
        font-size: 12px;
        border-radius: 6px;
        padding: 6px 10px;
    }

    #leaveConflictMessage:not(:empty) {
        border: 1px solid currentColor;
    }

    .select2.select2-container {
        width: 100% !important;
    }

    /* Withdraw confirm modal */
    #withdrawConfirmModal .modal-content {
        border: none;
        border-radius: 12px;
        box-shadow: 0 8px 40px rgba(0, 0, 0, .18);
    }

    #withdrawConfirmModal .modal-header {
        background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
        padding: 16px 22px;
        border: none;
    }

    #withdrawConfirmModal .modal-title {
        color: #fff;
        font-weight: 700;
        font-size: 15px;
        margin: 0;
    }

    #withdrawConfirmModal .modal-header .close {
        color: #fff;
        opacity: .85;
        font-size: 20px;
        padding: 0;
        margin: 0;
    }

    /* Today cell — bold yellow highlight */
    .fc-day-today {
        background: #fef08a !important;
        border: 2px solid #f59e0b !important;
    }

    .fc-day-today .fc-daygrid-day-number {
        background: #f59e0b;
        color: #fff !important;
        border-radius: 50%;
        width: 26px;
        height: 26px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin: 4px;
    }

    /* ── Leave Calendar Modal — narrow weekend columns ── */
    #leaveCalendarModalView .fc-day-sat,
    #leaveCalendarModalView .fc-day-sun {
        max-width: 80px !important;
        width: 10% !important;
    }
</style>

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
    <span>Leave Management</span>
    @endsection

    @section('back-btn')
    <a href="{{ route('profile.edit') }}" class="home-btn-color" title="Back to profile">BACK TO PROFILE</a>
    @endsection

    {{-- Toolbar --}}
    <div class="lm-toolbar rounded-top mb-0">
        <div class="filter-pill">
            <span class="text-muted" style="font-size:12px;white-space:nowrap;">Request Type</span>
            <select id="leavetypes_select2" class="select2">
                <option value="0">Pending Requests</option>
                <option value="1">Approved Requests</option>
                <option value="2">Rejected Requests</option>
                <option value="3">All Requests</option>
            </select>
        </div>

        <span class="badge badge-success ml-auto d-flex align-items-center" style="font-size:12px;padding:8px 14px;border-radius:50rem;">
            <i class="fa fa-calendar-check-o mr-2"></i>
            <strong class="mr-1">REMAINING:</strong>
            <span id="adminRemainingText"><i class="fa fa-spinner fa-spin" style="font-size:11px;"></i></span>
        </span>

        <button type="button" class="btn btn-success profile_request_leave" style="border-radius:8px;font-size:13px;padding:7px 18px;">
            <i class="fa fa-plus mr-1"></i> Request a Leave
        </button>

        <button type="button" id="showLeaveCalendarBtn" class="btn btn-outline-secondary" style="border-radius:8px;font-size:13px;padding:7px 18px;">
            <i class="fa fa-calendar mr-1"></i> Leave Calendar
        </button>
    </div>

    {{-- Main card --}}
    <div class="card lm-card rounded-top-0">
        @include('pages.hr_module.Leave_Managment.leave_balance_modal')

        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="employee_leave_table" style="width:100%;">
                    <thead style="background-color:#76bb90;">
                        <tr>
                            <th>No</th>
                            <th>Leave ID</th>
                            <th>Title</th>
                            <th>From Date</th>
                            <th>To Date</th>
                            <th>Leave Type</th>
                            <th>Request Note</th>
                            <th>Response Note</th>
                            <th class="text-center">Status</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- LEAVE REQUEST MODAL --}}
<div class="modal fade" id="employee_leave_request_Modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-paper-plane mr-2"></i>New Request</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <div id="lbm_modal_strip">
                <div>
                    <span class="strip-label"><i class="fa fa-users mr-1"></i>My Leave Group:</span>
                    <span class="strip-group" id="lbm_modal_group">Loading…</span>
                </div>
                <div class="mt-1">
                    <span class="strip-label">Remaining:</span>
                    <span class="strip-balance" id="lbm_modal_balance"><i class="fa fa-spinner fa-spin" style="font-size:11px;"></i></span>
                </div>
            </div>

            {{-- ── STEP 1: Choose type ── --}}
            <div id="lm_choiceStep" style="padding:28px 28px 24px;">
                <p style="font-size:13px;font-weight:600;color:#495057;margin-bottom:16px;text-transform:uppercase;letter-spacing:.4px;">
                    WHAT WOULD YOU LIKE TO REQUEST?
                </p>
                <div style="display:flex;gap:16px;flex-wrap:wrap;">
                    <button type="button" id="lm_chooseTakeLeave"
                        style="flex:1;min-width:200px;border:2px solid #e9ecef;border-radius:12px;padding:22px 18px;background:#fff;text-align:left;cursor:pointer;transition:border-color .15s,box-shadow .15s;">
                        <div style="font-size:24px;color:#2dce89;margin-bottom:10px;"><i class="fa fa-plane"></i></div>
                        <div style="font-size:14px;font-weight:700;color:#343a40;margin-bottom:4px;">Take a Leave</div>
                        <div style="font-size:12px;color:#6c757d;line-height:1.5;">Request time off — deducted from your annual balance on approval.</div>
                    </button>
                    <button type="button" id="lm_chooseCovering"
                        style="flex:1;min-width:200px;border:2px solid #e9ecef;border-radius:12px;padding:22px 18px;background:#fff;text-align:left;cursor:pointer;transition:border-color .15s,box-shadow .15s;">
                        <div style="font-size:24px;color:#6366f1;margin-bottom:10px;"><i class="fa fa-refresh"></i></div>
                        <div style="font-size:14px;font-weight:700;color:#343a40;margin-bottom:4px;">Covering Day</div>
                        <div style="font-size:12px;color:#6c757d;line-height:1.5;">Register a day you'll work instead — no balance deducted.</div>
                    </button>
                </div>
            </div>

            {{-- ── STEP 2a: Take a Leave form ── --}}
            <form id="leaveRequestForm" action="{{ route('leave.create') }}" method="post" enctype="multipart/form-data" style="display:none;">
                @csrf
                <input type="hidden" name="_method" id="leaveFormMethod" value="POST">
                <input type="hidden" name="leave_id" id="leaveFormId" value="">

                <div class="lm-form-body">
                    <button type="button" class="lm-back-btn btn btn-link btn-sm px-0 mb-3" data-target="choice"
                        style="font-size:12px;color:#6c757d;"><i class="fa fa-arrow-left mr-1"></i> Back</button>

                    <div class="form-group mb-3">
                        <label>Title</label>
                        <input class="form-control" name="employee_leave_title" id="employee_leave_title" type="text" placeholder="e.g. Doctor appointment">
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-6">
                            <label>Leave Type</label>
                            <select class="select2 form-control" name="leave_type" id="leave_type" required></select>
                        </div>
                        <div class="col-md-6">
                            <label>Leave Day Type</label>
                            <select class="select2 form-control" name="employee_leave_type" id="employee_leave_type" required>
                                <option value="half_day" selected>Half Day</option>
                                <option value="one_day">One Day</option>
                                <option value="multiple_days">Multiple Days</option>
                                <option value="short_leave">Short Leave</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row mb-3 leave-div show" id="half_day_div">
                        <div class="col-md-6">
                            <label>Date</label>
                            <input class="form-control" name="half_day_leave" id="half_day_leave" type="text" placeholder="mm/dd/yyyy">
                        </div>
                        <div class="col-md-6">
                            <label>Time</label>
                            <select class="select2 form-control" name="employee_leave_half_day_time" id="half_day_time" required>
                                <option value="0" selected>Morning</option>
                                <option value="1">Evening</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row mb-3 leave-div" id="one_day_div">
                        <div class="col-md-6">
                            <label>Date</label>
                            <input class="form-control" name="one_day_leave" id="one_day_leave" type="text" placeholder="mm/dd/yyyy">
                        </div>
                    </div>

                    <div class="form-row mb-3 leave-div" id="multiple_days_div">
                        <div class="col-12">
                            <label>Select Dates</label>
                            <input type="hidden" name="multiple_days_leave_from" id="multiple_days_leave_from">
                            <input type="hidden" name="multiple_days_leave_to" id="multiple_days_leave_to">

                            <div id="emp_calWrapper" style="border:1px solid #ced4da;border-radius:8px;padding:12px;background:#fff;user-select:none;">
                                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                                    <button type="button" id="emp_calPrev" class="btn btn-sm btn-outline-secondary" style="padding:2px 10px;">&lsaquo;</button>
                                    <strong id="emp_calLabel" style="font-size:13px;color:#343a40;"></strong>
                                    <button type="button" id="emp_calNext" class="btn btn-sm btn-outline-secondary" style="padding:2px 10px;">&rsaquo;</button>
                                </div>
                                <div id="emp_calGrid" style="display:grid;grid-template-columns:repeat(7,1fr);gap:4px;text-align:center;font-size:12px;"></div>
                            </div>
                            <div id="emp_calSummary" style="font-size:11px;color:#555;margin-top:6px;min-height:16px;"></div>
                            <div id="emp_calPreview" style="font-size:11px;margin-top:4px;"></div>
                            <div id="emp_calError" class="text-danger mt-1" style="font-size:11px;display:none;"></div>
                        </div>
                    </div>

                    <div class="form-row mb-3 leave-div" id="short_leave_div">
                        <div class="col-md-4">
                            <label>Date</label>
                            <input class="form-control" name="short_leave_date" id="short_leave_date" type="text" placeholder="mm/dd/yyyy">
                        </div>
                        <div class="col-md-4">
                            <label>From Time</label>
                            <input class="form-control" name="short_leave_from" id="short_leave_from" type="time">
                        </div>
                        <div class="col-md-4">
                            <label>To Time</label>
                            <input class="form-control" name="short_leave_to" id="short_leave_to" type="time">
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label>Request Note</label>
                        <textarea class="form-control" name="employee_leave_note" id="employee_leave_note" placeholder="Optional reason…"></textarea>
                    </div>

                    <div id="leaveConflictMessage"></div>
                </div>

                <div class="modal-footer">
                    <small class="text-muted mr-auto" style="font-size:11px;">
                        <i class="fa fa-info-circle"></i> Short leaves do not deduct days.
                    </small>
                    <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" id="emp_submitLeaveBtn" class="btn btn-success btn-sm px-4">
                        <i class="fa fa-paper-plane mr-1"></i> Submit Request
                    </button>
                </div>
            </form>

            {{-- ── STEP 2b: Covering Day form ── --}}
            <form id="coveringDayForm" action="{{ route('leave.create') }}" method="post" style="display:none;">
                @csrf
                <input type="hidden" name="is_covering" value="1">

                <div class="lm-form-body">
                    <button type="button" class="lm-back-btn btn btn-link btn-sm px-0 mb-3" data-target="choice"
                        style="font-size:12px;color:#6c757d;"><i class="fa fa-arrow-left mr-1"></i> Back</button>

                    <div style="background:#f0f0ff;border:1px solid #c7d2fe;border-radius:8px;padding:10px 14px;margin-bottom:18px;font-size:12px;color:#4338ca;">
                        <i class="fa fa-info-circle mr-1"></i>
                        A covering day lets you record that you'll work on a different date to cover the day you need off. <strong>No leave balance is deducted.</strong>
                    </div>

                    <div class="form-group mb-3">
                        <label>Title</label>
                        <input class="form-control" name="covering_title" id="covering_title" type="text" placeholder="e.g. Covering for Monday holiday">
                    </div>

                    <div class="form-group mb-3">
                        <label>Reason</label>
                        <textarea class="form-control" name="covering_reason" id="covering_reason" placeholder="Why do you need this day off?" style="min-height:80px;resize:vertical;"></textarea>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-6">
                            <label>Leave Date <small class="text-muted font-weight-normal">(day you want off)</small></label>
                            <div id="cov_leaveCalWrapper" style="border:1px solid #ced4da;border-radius:8px;padding:10px;background:#fff;user-select:none;">
                                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                                    <button type="button" id="cov_leavePrev" class="btn btn-sm btn-outline-secondary" style="padding:1px 8px;">&lsaquo;</button>
                                    <strong id="cov_leaveLabel" style="font-size:12px;color:#343a40;"></strong>
                                    <button type="button" id="cov_leaveNext" class="btn btn-sm btn-outline-secondary" style="padding:1px 8px;">&rsaquo;</button>
                                </div>
                                <div id="cov_leaveGrid" style="display:grid;grid-template-columns:repeat(7,1fr);gap:3px;text-align:center;font-size:11px;"></div>
                            </div>
                            <input type="hidden" name="covering_leave_date" id="covering_leave_date">
                            <div id="cov_leaveSelected" style="font-size:11px;color:#2dce89;margin-top:5px;font-weight:600;min-height:14px;"></div>
                        </div>

                        <div class="col-md-6">
                            <label>Covering Date <small class="text-muted font-weight-normal">(day you'll work instead)</small></label>
                            <div id="cov_coverCalWrapper" style="border:1px solid #ced4da;border-radius:8px;padding:10px;background:#fff;user-select:none;">
                                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                                    <button type="button" id="cov_coverPrev" class="btn btn-sm btn-outline-secondary" style="padding:1px 8px;">&lsaquo;</button>
                                    <strong id="cov_coverLabel" style="font-size:12px;color:#343a40;"></strong>
                                    <button type="button" id="cov_coverNext" class="btn btn-sm btn-outline-secondary" style="padding:1px 8px;">&rsaquo;</button>
                                </div>
                                <div id="cov_coverGrid" style="display:grid;grid-template-columns:repeat(7,1fr);gap:3px;text-align:center;font-size:11px;"></div>
                            </div>
                            <input type="hidden" name="covering_cover_date" id="covering_cover_date">
                            <div id="cov_coverSelected" style="font-size:11px;color:#6366f1;margin-top:5px;font-weight:600;min-height:14px;"></div>
                        </div>
                    </div>

                    <div id="cov_validationError"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" id="cov_submitBtn" class="btn btn-sm px-4"
                        style="background:#6366f1;color:#fff;border:none;border-radius:6px;">
                        <i class="fa fa-check mr-1"></i> Submit Covering Day
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

{{-- WITHDRAW CONFIRM MODAL --}}
<div class="modal fade" id="withdrawConfirmModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-ban mr-2"></i>Withdraw Leave</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body" style="padding:20px 22px;text-align:center;">
                <div style="font-size:42px;color:#ef4444;margin-bottom:12px;">
                    <i class="fa fa-exclamation-circle"></i>
                </div>
                <p style="font-size:14px;color:#374151;margin-bottom:6px;font-weight:600;">
                    Withdraw this leave request?
                </p>
                <p style="font-size:12px;color:#6b7280;margin:0;">
                    This action cannot be undone.
                </p>
            </div>
            <div class="modal-footer" style="justify-content:center;gap:10px;padding:12px 20px;border-top:1px solid #e9ecef;">
                <button type="button" class="btn btn-light btn-sm px-4" data-dismiss="modal">Cancel</button>
                <button type="button" id="confirmWithdrawBtn" class="btn btn-danger btn-sm px-4">
                    <i class="fa fa-ban mr-1"></i> Withdraw
                </button>
            </div>
        </div>
    </div>
</div>

{{-- LEAVE CALENDAR MODAL --}}
<div class="modal fade" id="leaveCalendarModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width:900px;">
        <div class="modal-content" style="border:none;border-radius:16px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.18);">
            <div class="modal-header" style="background:#1e293b;padding:18px 28px;border:none;display:flex;align-items:center;justify-content:space-between;">
                <div style="display:flex;align-items:center;gap:14px;">
                    <div style="width:38px;height:38px;border-radius:10px;background:#334155;display:flex;align-items:center;justify-content:center;">
                        <i class="fa fa-calendar" style="color:#94a3b8;font-size:16px;"></i>
                    </div>
                    <div>
                        <div style="font-size:15px;font-weight:600;color:#f1f5f9;">Leave Calendar</div>
                        <div style="font-size:12px;color:#64748b;margin-top:2px;">All approved leaves — view only</div>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" style="background:none;border:none;color:#64748b;font-size:24px;line-height:1;padding:2px 8px;"><span>&times;</span></button>
            </div>

            <div style="background:#f8fafc;border-bottom:1px solid #e2e8f0;padding:10px 28px;display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
                <span style="font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.04em;">Legend:</span>
                <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#374151;">
                    <span style="display:inline-block;width:12px;height:12px;border-radius:3px;background:#ef4444;"></span>Upcoming Leave
                </div>
                <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#374151;">
                    <span style="display:inline-block;width:12px;height:12px;border-radius:3px;background:#22c55e;"></span>Covering Day (Off)
                </div>
                <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#374151;">
                    <span style="display:inline-block;width:12px;height:12px;border-radius:3px;background:#9ca3af;"></span>Past Leave
                </div>
                <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#374151;">
                    <span style="display:inline-block;width:12px;height:12px;border-radius:3px;background:#f97316;"></span>Public Holiday
                </div>
                <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#374151;">
                    <span style="display:inline-block;width:12px;height:12px;border-radius:3px;background:#fef08a;border:1px solid #f59e0b;"></span>Today
                </div>
                <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#374151;">
                    <span style="display:inline-block;width:12px;height:12px;border-radius:3px;background:#ffcdcd;"></span>Saturday
                </div>
                <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#374151;">
                    <span style="display:inline-block;width:12px;height:12px;border-radius:3px;background:#c75f53;"></span>Sunday
                </div>
                <div id="leaveCalModal_loadingBadge" style="margin-left:auto;font-size:12px;color:#64748b;">
                    <i class="fa fa-spinner fa-spin"></i> Loading…
                </div>
            </div>

            <div class="modal-body" style="padding:24px 28px;background:#fff;">
                <div id="leaveCalendarModalView" style="width:100%;"></div>
            </div>

            <div class="modal-footer" style="padding:14px 24px;border-top:1px solid #e2e8f0;background:#f8fafc;justify-content:flex-end;">
                <button type="button" class="btn" data-dismiss="modal" style="background:#1e293b;color:#f1f5f9;border:none;border-radius:8px;padding:9px 24px;font-size:13px;font-weight:500;">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('select').select2();

        /* Day-type toggle — only clear calendar in CREATE mode */
        $('#employee_leave_type').on('change', function() {
            $('.leave-div').removeClass('show');
            $('#' + $(this).val() + '_div').addClass('show');
            if ($(this).val() === 'multiple_days' && !empCal.editMode) {
                empCal.selected = new Set();
                empCalRender();
            }
        });

        /* Open modal in CREATE mode */
        $(document).on('click', '.profile_request_leave', function() {
            empCal.editMode = false;
            resetLeaveModal();
            $('#employee_leave_request_Modal').modal('show');
        });

        var userId = @json(auth()->user()->id);

        /* Balance strip — FIXED: removed stray "z" that broke all JS below */
        $('#employee_leave_request_Modal').on('show.bs.modal', function() {
            $('#lbm_modal_group').html('<i class="fa fa-spinner fa-spin" style="font-size:11px;"></i>');
            $('#lbm_modal_balance').html('<i class="fa fa-spinner fa-spin" style="font-size:11px;"></i>');

            $.ajax({
                url: '{{ url("/leave-Manage/getLeaveBalance") }}/' + userId,
                method: 'GET',
                success: function(res) {
                    if (!res.success) {
                        $('#lbm_modal_group').text('No group assigned');
                        $('#lbm_modal_balance').text('—');
                        return;
                    }
                    $('#lbm_modal_group').text(res.group_name || '—');
                    var $lt = $('#leave_type');
                    var editVal = $lt.val();
                    $lt.empty();

                    res.balances.forEach(function(item) {
                        var remaining = parseInt(item.remaining) || 0;
                        var isZero = remaining <= 0;
                        var label = item.leave_type_name + (isZero ? ' (0 remaining — unavailable)' : ' (' + remaining + ' remaining)');
                        var $opt = $('<option></option>')
                            .val(item.leave_type_key || item.leave_type_name.toLowerCase().replace(/\s+/g, '_'))
                            .text(label).attr('data-remaining', remaining);
                        if (isZero) {
                            $opt.prop('disabled', true).css('color', '#adb5bd');
                        }
                        $lt.append($opt);
                    });

                    if (empCal.editMode && editVal) {
                        $lt.find('option[value="' + editVal + '"]').prop('disabled', false);
                        $lt.val(editVal);
                    } else {
                        var $first = $lt.find('option:not(:disabled)').first();
                        if ($first.length) {
                            $lt.val($first.val());
                        }
                    }
                    $lt.trigger('change');

                    var parts = res.balances.map(function(item) {
                        var r = parseInt(item.remaining) || 0;
                        return '<span class="badge ' + (r <= 0 ? 'badge-danger' : 'badge-light border') + ' mr-1">' +
                            item.leave_type_name + ' <strong>' + r + '</strong></span>';
                    });
                    $('#lbm_modal_balance').html(parts.join(''));
                },
                error: function() {
                    $('#lbm_modal_group').text('Error loading');
                    $('#lbm_modal_balance').text('—');
                }
            });
        }); /* <-- correct closing, no stray characters */

        /* Full modal reset */
        function resetLeaveModal() {
            $('#employee_leave_title, #employee_leave_note, #half_day_leave, #one_day_leave, #short_leave_date, #short_leave_from, #short_leave_to').val('');
            $('#multiple_days_leave_from, #multiple_days_leave_to').val('');
            $('#employee_leave_type').val('half_day').trigger('change');
            $('.leave-div').removeClass('show');
            $('#half_day_div').addClass('show');
            $('#leaveConflictMessage').html('').removeClass('text-danger text-success');
            $('#emp_validationError').remove();
            $('#emp_calError').hide().text('');
            empCal.selected = new Set();
            empCal.year = new Date().getFullYear();
            empCal.month = new Date().getMonth();
            empCal.editMode = false;
            $('#emp_calSummary').text('');
            $('#emp_calPreview').html('');
            $('#emp_submitLeaveBtn').prop('disabled', false).html('<i class="fa fa-paper-plane mr-1"></i> Submit Request');
        }

        /* Reset to CREATE mode on close */
        $('#employee_leave_request_Modal').on('hidden.bs.modal', function() {
            $('#leaveFormMethod').val('POST');
            $('#leaveFormId').val('');
            $('#leaveRequestForm').attr('action', '{{ route("leave.create") }}');
            $('#employee_leave_request_Modal .modal-title').html('<i class="fa fa-paper-plane mr-2"></i>Leave Request');
            resetLeaveModal();
        });

        loadLeaveBalanceBadge(userId, '#adminRemainingText');

        /* DataTable */
        $('#employee_leave_table').DataTable({
            scrollX: true,
            autoWidth: false,
            columns: [{
                    data: 'no'
                }, {
                    data: 'leave_id'
                }, {
                    data: 'title'
                },
                {
                    data: 'from_date'
                }, {
                    data: 'to_date'
                }, {
                    data: 'leave_type'
                },
                {
                    data: 'request_note'
                }, {
                    data: 'response_note'
                },
                {
                    data: 'status',
                    className: 'text-center'
                },
                {
                    data: 'created_at'
                }, {
                    data: 'updated_at'
                },
                {
                    data: 'actions',
                    className: 'text-center',
                    orderable: false
                }
            ]
        });

        /* Datepickers */
        var dpOpts = {
            dateFormat: 'mm/dd/yy',
            changeMonth: true,
            changeYear: true,
            minDate: 0,
            yearRange: '1900:2030'
        };
        ['#half_day_leave', '#one_day_leave', '#short_leave_date'].forEach(function(id) {
            $(id).datepicker(dpOpts);
        });

        /* Multi-date calendar */
        var empCal = {
            year: new Date().getFullYear(),
            month: new Date().getMonth(),
            selected: new Set(),
            editMode: false
        };
        var empMonthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        function empCalRender() {
            $('#emp_calLabel').text(empMonthNames[empCal.month] + ' ' + empCal.year);
            var $grid = $('#emp_calGrid').empty();
            ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'].forEach(function(d) {
                $grid.append('<div style="font-weight:600;color:#888;padding:3px 0;font-size:11px;">' + d + '</div>');
            });
            var firstDay = new Date(empCal.year, empCal.month, 1).getDay();
            var daysInMonth = new Date(empCal.year, empCal.month + 1, 0).getDate();
            var today = new Date();
            today.setHours(0, 0, 0, 0);
            for (var i = 0; i < firstDay; i++) {
                $grid.append('<div></div>');
            }
            for (var d = 1; d <= daysInMonth; d++) {
                var key = empCal.year + '-' + String(empCal.month + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0');
                var dayDate = new Date(empCal.year, empCal.month, d);
                var isWeekend = (dayDate.getDay() === 0 || dayDate.getDay() === 6);
                var isPast = dayDate < today;
                var isSelected = empCal.selected.has(key);
                var blockPast = isPast && !empCal.editMode;
                var bg, color, cursor;
                if (isSelected) {
                    bg = '#2dce89';
                    color = '#fff';
                    cursor = 'pointer';
                } else if (blockPast) {
                    bg = '#f1f3f5';
                    color = '#adb5bd';
                    cursor = 'not-allowed';
                } else if (isWeekend) {
                    bg = '#fde8e8';
                    color = '#c0392b';
                    cursor = 'pointer';
                } else {
                    bg = '#f8f9fa';
                    color = '#343a40';
                    cursor = 'pointer';
                }
                $grid.append('<div data-key="' + key + '" data-past="' + (blockPast ? 1 : 0) + '" style="background:' + bg + ';color:' + color + ';cursor:' + cursor + ';border-radius:5px;padding:6px 2px;font-size:12px;transition:background .1s;">' + d + '</div>');
            }
            empCalUpdateSummary();
        }

        function empCalUpdateSummary() {
            var sorted = Array.from(empCal.selected).sort();
            if (!sorted.length) {
                $('#emp_calSummary').text('No dates selected.');
                $('#emp_calPreview').html('');
                return;
            }
            $('#emp_calSummary').text('Selected (' + sorted.length + '): ' + sorted.map(function(k) {
                var p = k.split('-');
                return p[2] + '/' + p[1];
            }).join(', '));
            var groups = empCalBuildGroups(sorted);
            var html = '<strong style="color:#343a40;">Will submit ' + groups.length + ' leave record(s):</strong><ul style="margin:4px 0 0 16px;padding:0;">';
            groups.forEach(function(g, i) {
                html += '<li>Record ' + (i + 1) + ': ' + (g.length === 1 ? '1 day — ' + fmtDisplay(g[0]) : g.length + ' days — ' + fmtDisplay(g[0]) + ' → ' + fmtDisplay(g[g.length - 1])) + '</li>';
            });
            $('#emp_calPreview').html(html + '</ul>');
        }

        function empCalBuildGroups(sorted) {
            if (!sorted.length) return [];
            var groups = [],
                current = [sorted[0]];
            for (var i = 1; i < sorted.length; i++) {
                if ((new Date(sorted[i]) - new Date(sorted[i - 1])) / 86400000 === 1) {
                    current.push(sorted[i]);
                } else {
                    groups.push(current);
                    current = [sorted[i]];
                }
            }
            groups.push(current);
            return groups;
        }

        function empFmtSlash(k) {
            var p = k.split('-');
            return p[1] + '/' + p[2] + '/' + p[0];
        }

        function fmtDisplay(k) {
            var p = k.split('-');
            return p[2] + '/' + p[1];
        }

        $(document).on('click', '#emp_calGrid [data-key]', function() {
            if ($(this).data('past') == 1) return;
            var key = $(this).data('key');
            if (empCal.selected.has(key)) {
                empCal.selected.delete(key);
            } else {
                empCal.selected.add(key);
            }
            empCalRender();
        });
        $('#emp_calPrev').on('click', function() {
            empCal.month--;
            if (empCal.month < 0) {
                empCal.month = 11;
                empCal.year--;
            }
            empCalRender();
        });
        $('#emp_calNext').on('click', function() {
            empCal.month++;
            if (empCal.month > 11) {
                empCal.month = 0;
                empCal.year++;
            }
            empCalRender();
        });

        /* Validation helpers */
        function showValidationError(msg) {
            $('#emp_validationError').remove();
            $('.lm-form-body').prepend($('<div id="emp_validationError" class="alert alert-danger py-2 mt-2" style="font-size:12px;border-radius:6px;"><i class="fa fa-exclamation-circle mr-1"></i>' + msg + '</div>'));
            $('#employee_leave_request_Modal .modal-body').scrollTop(0);
        }

        function clearValidationError() {
            $('#emp_validationError').remove();
        }

        /* Submit handler */
        $('#emp_submitLeaveBtn').on('click', function() {
            var isEditMode = ($('#leaveFormMethod').val() === 'PUT');
            var $form = $(this).closest('form');
            var dayType = $('#employee_leave_type').val();
            var $err = $('#emp_calError');
            $err.hide();
            clearValidationError();

            var title = $.trim($('#employee_leave_title').val());
            var leaveType = $('#leave_type').val();
            if (!title) {
                showValidationError('Title is required.');
                return;
            }
            if (!leaveType) {
                showValidationError('Please select a Leave Type.');
                return;
            }

            if (!isEditMode) {
                var remaining = parseInt($('#leave_type').find(':selected').attr('data-remaining')) || 0;
                if (remaining <= 0) {
                    showValidationError('The selected leave type has 0 days remaining.');
                    return;
                }
            }

            if (dayType === 'half_day') {
                if (!$.trim($('#half_day_leave').val())) {
                    showValidationError('Please select a date for the half day leave.');
                    return;
                }
                $form[0].submit();
                return;
            }
            if (dayType === 'one_day') {
                if (!$.trim($('#one_day_leave').val())) {
                    showValidationError('Please select a date for the one day leave.');
                    return;
                }
                $form[0].submit();
                return;
            }
            if (dayType === 'short_leave') {
                var sd = $.trim($('#short_leave_date').val()),
                    sf = $.trim($('#short_leave_from').val()),
                    st = $.trim($('#short_leave_to').val());
                if (!sd) {
                    showValidationError('Please select a date for the short leave.');
                    return;
                }
                if (!sf) {
                    showValidationError('Please enter a From Time.');
                    return;
                }
                if (!st) {
                    showValidationError('Please enter a To Time.');
                    return;
                }
                if (sf >= st) {
                    showValidationError('From Time must be before To Time.');
                    return;
                }
                $form[0].submit();
                return;
            }

            /* Multiple days */
            var sorted = Array.from(empCal.selected).sort();
            if (!sorted.length) {
                $err.text('Please select at least one date on the calendar.').show();
                return;
            }
            var groups = empCalBuildGroups(sorted);

            if (isEditMode) {
                if (groups.length > 1) {
                    showValidationError('Please select consecutive dates when editing a leave.');
                    return;
                }
                var g = groups[0];
                if (g.length === 1) {
                    $('#employee_leave_type').val('one_day');
                    $('#one_day_leave').val(empFmtSlash(g[0]));
                } else {
                    $('#multiple_days_leave_from').val(empFmtSlash(g[0]));
                    $('#multiple_days_leave_to').val(empFmtSlash(g[g.length - 1]));
                }
                $form[0].submit();
                return;
            }

            var note = $.trim($('#employee_leave_note').val()),
                csrfToken = $form.find('input[name="_token"]').val(),
                submitUrl = $form.attr('action');
            if (groups.length === 1) {
                var g0 = groups[0];
                if (g0.length === 1) {
                    $('#employee_leave_type').val('one_day');
                    $('#one_day_leave').val(empFmtSlash(g0[0]));
                } else {
                    $('#multiple_days_leave_from').val(empFmtSlash(g0[0]));
                    $('#multiple_days_leave_to').val(empFmtSlash(g0[g0.length - 1]));
                }
                $form[0].submit();
                return;
            }

            var $btn = $('#emp_submitLeaveBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Submitting…');
            var payloads = groups.map(function(g) {
                var s = g.length === 1;
                return {
                    _token: csrfToken,
                    employee_leave_title: title,
                    leave_type: leaveType,
                    employee_leave_type: s ? 'one_day' : 'multiple_days',
                    one_day_leave: s ? empFmtSlash(g[0]) : '',
                    multiple_days_leave_from: s ? '' : empFmtSlash(g[0]),
                    multiple_days_leave_to: s ? '' : empFmtSlash(g[g.length - 1]),
                    employee_leave_note: note
                };
            });
            payloads.reduce(function(p, payload) {
                    return p.then(function() {
                        return $.ajax({
                            url: submitUrl,
                            method: 'POST',
                            data: payload
                        });
                    });
                }, Promise.resolve())
                .then(function() {
                    $btn.prop('disabled', false).html('<i class="fa fa-paper-plane mr-1"></i> Submit Request');
                    $('#employee_leave_request_Modal').modal('hide');
                    showToast(groups.length + ' leave record(s) submitted!', sorted.length + ' day(s) total — pending approval.', '#2dce89');
                    setTimeout(function() {
                        $('#emp_successToast').fadeOut(400, function() {
                            $(this).remove();
                            make_employee_leave_table($('#leavetypes_select2').val(), userId);
                        });
                    }, 4000);
                    empCal.selected = new Set();
                    $('#emp_calSummary').text('');
                    $('#emp_calPreview').html('');
                })
                .catch(function(xhr) {
                    $btn.prop('disabled', false).html('<i class="fa fa-paper-plane mr-1"></i> Submit Request');
                    $err.text(xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Submission failed.').show();
                });
        });

        /* Toast helper */
        function showToast(line1, line2, color) {
            $('#emp_successToast').remove();
            $('body').append('<div id="emp_successToast" style="position:fixed;top:24px;right:24px;z-index:9999;background:' + color + ';color:#fff;border-radius:10px;padding:16px 22px;font-size:14px;font-weight:600;box-shadow:0 4px 20px rgba(0,0,0,.18);display:flex;align-items:center;gap:10px;animation:slideInRight .3s ease;"><i class="fa fa-check-circle" style="font-size:20px;"></i><div><div>' + line1 + '</div><div style="font-weight:400;font-size:12px;margin-top:2px;opacity:.9;">' + line2 + '</div></div></div>');
            if (!document.getElementById('emp_toastStyle')) {
                $('<style id="emp_toastStyle">@keyframes slideInRight{from{opacity:0;transform:translateX(60px)}to{opacity:1;transform:translateX(0)}}</style>').appendTo('head');
            }
        }

        /* Load table */
        make_employee_leave_table(0, userId);
        $(document).on('change', '#leavetypes_select2', function() {
            make_employee_leave_table($(this).val(), userId);
        });

        /* Conflict check */
        function checkConflict(from, to, typeval, fromTime, toTime) {
            if (!from) return;
            $.ajax({
                url: '{{ route("checkLeaveConflict") }}',
                method: 'GET',
                data: {
                    from: from,
                    to: to,
                    type: typeval,
                    from_time: fromTime,
                    to_time: toTime
                },
                success: function(r) {
                    $('#leaveConflictMessage').removeClass('text-danger text-success alert-danger alert-success').addClass(r.success ? 'text-success' : 'text-danger').html(r.success ? '<i class="fa fa-check mr-1"></i>No conflicts found.' : r.message);
                }
            });
        }
        $('#half_day_leave').on('change', function() {
            checkConflict($(this).val(), null, 0);
        });
        $('#one_day_leave').on('change', function() {
            checkConflict($(this).val(), null, 1);
        });
        $('#short_leave_date, #short_leave_from, #short_leave_to').on('change', function() {
            var d = $('#short_leave_date').val(),
                f = $('#short_leave_from').val(),
                t = $('#short_leave_to').val();
            if (d && f && t) checkConflict(d, d, 3, f, t);
        });

        /* Table helpers */
        function make_employee_leave_table(status_id, u_id) {
            $('.se-pre-con').fadeIn();
            $.ajax({
                url: '{{ url("/leave-Manage/get") }}/' + status_id + '/' + u_id,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    update_employee_leave_table(res);
                    $('.se-pre-con').fadeOut();
                },
                error: function() {
                    $('.se-pre-con').fadeOut();
                }
            });
        }

        function update_employee_leave_table(data) {
            var table = $('#employee_leave_table').DataTable();
            table.clear();
            var rows = data.map(function(r, i) {
                var dd = getDateDisplay(r);
                /* Actions: pending gets Edit + Withdraw; all others get a dash */
                var actions = r.status === 0 ?
                    '<div class="d-flex justify-content-center" style="gap:5px;">' +
                    '<button class="btn btn-sm btn-outline-primary edit-leave-btn" title="Edit" ' +
                    'style="border-radius:6px;font-size:12px;padding:3px 10px;" ' +
                    'data-leave=\'' + JSON.stringify(r).replace(/'/g, "&#39;") + '\'>' +
                    '<i class="fa fa-pencil"></i></button>' +
                    '<button class="btn btn-sm btn-outline-danger withdraw-leave-btn" title="Withdraw" ' +
                    'style="border-radius:6px;font-size:12px;padding:3px 10px;" ' +
                    'data-id="' + r.id + '">' +
                    '<i class="fa fa-ban"></i></button>' +
                    '</div>' :
                    '<span class="text-muted" style="font-size:12px;">—</span>';
                return {
                    no: i + 1,
                    leave_id: r.id,
                    title: r.title,
                    from_date: dd.from,
                    to_date: dd.to,
                    leave_type: r.leave_type,
                    request_note: r.request_note || '—',
                    response_note: r.response_note || '—',
                    status: getStatusText(r.status),
                    created_at: formatDate(r.created_at),
                    updated_at: formatDate(r.updated_at),
                    actions: actions
                };
            });
            table.rows.add(rows).draw();
        }

        function formatDate(ts) {
            return ts ? ts.split('T')[0] : '—';
        }

        function getStatusText(s) {
            var map = {
                0: ['warning', 'Pending'],
                1: ['success', 'Approved'],
                2: ['danger', 'Rejected']
            };
            var v = map[s] || ['secondary', 'Unknown'];
            return '<span class="badge badge-' + v[0] + '">' + v[1] + '</span>';
        }

        function getDateDisplay(r) {
            if (r.type == 0) return {
                from: r.start_date + ' <span class="badge badge-light">' + (r.day_type == 0 ? 'Morning' : 'Evening') + '</span>',
                to: ''
            };
            if (r.type == 1) return {
                from: r.start_date,
                to: ''
            };
            if (r.type == 2) return {
                from: r.start_date,
                to: r.end_date
            };
            if (r.type == 3) return {
                from: r.start_date + ' (' + r.short_from_time + '–' + r.short_to_time + ')',
                to: ''
            };
            if (r.type == 4) return {
                from: r.covering_leave_date + ' <span class="badge badge-light" style="background:#e0e7ff;color:#4338ca;">Off</span>',
                to: r.covering_cover_date + ' <span class="badge badge-light" style="background:#e0e7ff;color:#4338ca;">Covering</span>'
            };
            return {
                from: '',
                to: ''
            };
        }

        /* Edit button */
        $(document).on('click', '.edit-leave-btn', function() {
            var r = $(this).data('leave');
            $('#leaveFormMethod').val('PUT');
            $('#leaveFormId').val(r.id);
            $('#leaveRequestForm').attr('action', '{{ url("/leave-Manage/update") }}/' + r.id);
            $('#employee_leave_request_Modal .modal-title').html('<i class="fa fa-pencil mr-2"></i>Edit Leave Request');
            $('#emp_submitLeaveBtn').prop('disabled', false).html('<i class="fa fa-save mr-1"></i> Save Changes');
            $('#employee_leave_title').val(r.title || '');
            $('#employee_leave_note').val(r.request_note || '');
            var typeMap = {
                0: 'half_day',
                1: 'one_day',
                2: 'multiple_days',
                3: 'short_leave'
            };
            var dayType = typeMap[r.type] || 'one_day';
            empCal.editMode = true; // set BEFORE trigger to prevent calendar clear
            $('#employee_leave_type').val(dayType).trigger('change');
            $('.leave-div').removeClass('show');
            $('#' + dayType + '_div').addClass('show');
            if (r.type === 0) {
                $('#half_day_leave').val(r.start_date || '');
                $('#half_day_time').val(r.day_type != null ? String(r.day_type) : '0').trigger('change');
            } else if (r.type === 1) {
                $('#one_day_leave').val(r.start_date || '');
            } else if (r.type === 2) {
                var fromStr = r.start_date || '',
                    toStr = r.end_date || '';
                $('#multiple_days_leave_from').val(fromStr);
                $('#multiple_days_leave_to').val(toStr);

                function parseMMDDYYYY(str) {
                    if (!str) return null;
                    var p = str.split('/');
                    if (p.length !== 3) return null;
                    return new Date(parseInt(p[2]), parseInt(p[0]) - 1, parseInt(p[1]));
                }
                var startDate = parseMMDDYYYY(fromStr),
                    endDate = parseMMDDYYYY(toStr);
                empCal.selected = new Set();
                if (startDate && endDate) {
                    var iter = new Date(startDate);
                    while (iter <= endDate) {
                        empCal.selected.add(iter.getFullYear() + '-' + String(iter.getMonth() + 1).padStart(2, '0') + '-' + String(iter.getDate()).padStart(2, '0'));
                        iter.setDate(iter.getDate() + 1);
                    }
                    empCal.year = startDate.getFullYear();
                    empCal.month = startDate.getMonth();
                }
                empCalRender();
            } else if (r.type === 3) {
                $('#short_leave_date').val(r.start_date || '');
                $('#short_leave_from').val(r.short_from_time || '');
                $('#short_leave_to').val(r.short_to_time || '');
            }
            $('#employee_leave_request_Modal').modal('show'); // open ONCE
        });

        /* ══════════════════════════════════════════
           WITHDRAW BUTTON + CONFIRM MODAL
        ══════════════════════════════════════════ */
        var withdrawLeaveId = null;

        $(document).on('click', '.withdraw-leave-btn', function() {
            withdrawLeaveId = $(this).data('id');
            $('#withdrawConfirmModal').modal('show');
        });

        $('#confirmWithdrawBtn').on('click', function() {
            if (!withdrawLeaveId) return;
            var $btn = $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Withdrawing…');

            $.ajax({
                url: '{{ url("/leave-Manage/withdraw") }}/' + withdrawLeaveId,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'PATCH'
                },
                success: function() {
                    $btn.prop('disabled', false).html('<i class="fa fa-ban mr-1"></i> Withdraw');
                    $('#withdrawConfirmModal').modal('hide');
                    withdrawLeaveId = null;
                    showToast('Leave request withdrawn.', 'The request has been removed.', '#ef4444');
                    setTimeout(function() {
                        $('#emp_successToast').fadeOut(400, function() {
                            $(this).remove();
                            make_employee_leave_table($('#leavetypes_select2').val(), userId);
                        });
                    }, 3000);
                },
                error: function() {
                    $btn.prop('disabled', false).html('<i class="fa fa-ban mr-1"></i> Withdraw');
                    alert('Failed to withdraw. Please try again.');
                }
            });
        });

        $('#withdrawConfirmModal').on('hidden.bs.modal', function() {
            withdrawLeaveId = null;
            $('#confirmWithdrawBtn').prop('disabled', false).html('<i class="fa fa-ban mr-1"></i> Withdraw');
        });

        /* Leave calendar modal */
        if (typeof FullCalendar === 'undefined') {
            $('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">').appendTo('head');
            $.getScript('https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js');
        }
        var leaveModalCalInstance = null;

        function padTwo_lmc(n) {
            return n < 10 ? '0' + n : '' + n;
        }

        function mdyToIso_lmc(str) {
            if (!str) return '';
            var p = str.split('/');
            if (p.length !== 3) return str;
            return p[2] + '-' + padTwo_lmc(+p[0]) + '-' + padTwo_lmc(+p[1]);
        }

        function buildLeaveModalCalendar(events) {
            var calEl = document.getElementById('leaveCalendarModalView');
            if (!calEl) return;
            if (leaveModalCalInstance) {
                leaveModalCalInstance.removeAllEvents();
                events.forEach(function(e) {
                    leaveModalCalInstance.addEvent(e);
                });
                leaveModalCalInstance.gotoDate(new Date());
                return;
            }
            leaveModalCalInstance = new FullCalendar.Calendar(calEl, {
                initialView: 'dayGridMonth',
                initialDate: new Date(),
                headerToolbar: {
                    left: 'title',
                    center: '',
                    right: 'prev,next today'
                },
                height: 'auto',
                firstDay: 1,
                fixedWeekCount: false,
                events: events,
                dayCellDidMount: function(info) {
                    var day = info.date.getDay();
                    var isToday = info.el.classList.contains('fc-day-today');
                    if (!isToday) {
                        if (day === 6) {
                            info.el.style.backgroundColor = '#ffcdcd';
                        } else if (day === 0) {
                            info.el.style.backgroundColor = '#c75f53';
                        }
                    }
                },
                eventDidMount: function(info) {
                    info.el.setAttribute('title', info.event.title);
                }
            });
            leaveModalCalInstance.render();
            leaveModalCalInstance.gotoDate(new Date());
        }

        function loadAndRenderLeaveCalModal() {
            $('#leaveCalModal_loadingBadge').show();
            $.get('{{ url("/leave-Manage/getrequests") }}', function(data) {
                var today = new Date();
                today.setHours(0, 0, 0, 0);

                // mm/dd/yyyy → yyyy-mm-dd (safe, handles empty)
                function fmtISO(str) {
                    if (!str || str.trim() === '') return null;
                    var p = str.split('/');
                    if (p.length !== 3) return null;
                    return p[2] + '-' + p[0].padStart(2, '0') + '-' + p[1].padStart(2, '0');
                }

                var calEvents = [];
                var yr = new Date().getFullYear();

                // ── Public Holidays ───────────────────────────────────────────
                [{
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
                ].forEach(function(h) {
                    calEvents.push({
                        title: '🏖 ' + h.title,
                        start: h.date,
                        color: '#f97316',
                        textColor: '#fff',
                        display: 'block',
                        editable: false
                    });
                });

                // ── Leave events ──────────────────────────────────────────────
                for (var i = 0; i < data.length; i++) {
                    var l = data[i];
                    if (l.status != 1) continue;

                    var name = l.user_details ? l.user_details.name : 'Employee';

                    // ── Covering Day (type 4) ─────────────────────────────────
                    if (l.type == 4) {
                        var offISO = fmtISO(l.covering_leave_date);
                        if (offISO) {
                            var isPastCov = new Date(offISO) < today;
                            calEvents.push({
                                title: name + ' (Off)',
                                start: offISO,
                                color: isPastCov ? '#9ca3af' : '#22c55e',
                                textColor: '#fff'
                            });
                        }
                        continue; // skip start_date processing for covering
                    }

                    // ── Normal leave ──────────────────────────────────────────
                    var startISO = fmtISO(l.start_date);
                    if (!startISO) continue;

                    var endISO = (l.end_date && l.end_date.trim() !== '') ?
                        fmtISO(l.end_date) :
                        startISO;
                    if (!endISO) endISO = startISO;

                    var cur = new Date(startISO);
                    var endDate = new Date(endISO);

                    while (cur <= endDate) {
                        var iso = cur.getFullYear() + '-' +
                            String(cur.getMonth() + 1).padStart(2, '0') + '-' +
                            String(cur.getDate()).padStart(2, '0');
                        var isPast = cur < today;
                        calEvents.push({
                            title: name,
                            start: iso,
                            // Red for upcoming/today, grey for past
                            color: isPast ? '#9ca3af' : '#ef4444',
                            textColor: '#fff'
                        });
                        cur.setDate(cur.getDate() + 1);
                    }
                }

                function tryRender(attempt) {
                    if (typeof FullCalendar !== 'undefined') {
                        buildLeaveModalCalendar(calEvents);
                        $('#leaveCalModal_loadingBadge').hide();
                    } else if (attempt < 20) {
                        setTimeout(function() {
                            tryRender(attempt + 1);
                        }, 300);
                    } else {
                        $('#leaveCalModal_loadingBadge').text('Could not load calendar.');
                    }
                }
                tryRender(0);

            }).fail(function() {
                $('#leaveCalModal_loadingBadge').text('Failed to load leave data.');
            });
        }
        $(document).on('click', '#showLeaveCalendarBtn', function() {
            $('#leaveCalendarModal').modal('show');
        });
        $('#leaveCalendarModal').on('show.bs.modal', function() {
            loadAndRenderLeaveCalModal();
        });
        $('#leaveCalendarModal').on('shown.bs.modal', function() {
            if (leaveModalCalInstance) {
                leaveModalCalInstance.updateSize();
            }
        });

        /* ══════════════════════════════════════════
        CHOICE STEP + COVERING DAY LOGIC
        ══════════════════════════════════════════ */
        function lmShowStep(step) {
            $('#lm_choiceStep').hide();
            $('#leaveRequestForm').hide();
            $('#coveringDayForm').hide();

            if (step === 'choice') {
                $('#lm_choiceStep').show();
                $('#employee_leave_request_Modal .modal-title').html('<i class="fa fa-paper-plane mr-2"></i>New Request');
            } else if (step === 'leave') {
                $('#leaveRequestForm').show();
                $('#employee_leave_request_Modal .modal-title').html('<i class="fa fa-plane mr-2"></i>Take a Leave');
            } else if (step === 'covering') {
                $('#coveringDayForm').show();
                $('#employee_leave_request_Modal .modal-title').html('<i class="fa fa-refresh mr-2"></i>Covering Day');
                covCalRender('leave');
                covCalRender('cover');
            }
        }

        /* Card hover effect */
        $('#lm_chooseTakeLeave, #lm_chooseCovering').on('mouseenter', function() {
            $(this).css({
                'border-color': $(this).attr('id') === 'lm_chooseTakeLeave' ? '#2dce89' : '#6366f1',
                'box-shadow': '0 4px 16px rgba(0,0,0,.08)'
            });
        }).on('mouseleave', function() {
            $(this).css({
                'border-color': '#e9ecef',
                'box-shadow': 'none'
            });
        });

        $('#lm_chooseTakeLeave').on('click', function() {
            lmShowStep('leave');
        });
        $('#lm_chooseCovering').on('click', function() {
            lmShowStep('covering');
        });

        $(document).on('click', '.lm-back-btn', function() {
            lmShowStep($(this).data('target'));
        });

        /* Override: open modal shows choice step */
        $(document).on('click', '.profile_request_leave', function() {
            empCal.editMode = false;
            resetLeaveModal();
            lmShowStep('choice');
            $('#employee_leave_request_Modal').modal('show');
        });

        /* Reset covering form on modal close */
        $('#employee_leave_request_Modal').on('hidden.bs.modal', function() {
            lmShowStep('choice');
            resetCoveringForm();
        });

        /* ── Covering Day mini-calendars ── */
        var covLeafCal = {
            year: new Date().getFullYear(),
            month: new Date().getMonth(),
            selected: null
        };
        var covCoverCal = {
            year: new Date().getFullYear(),
            month: new Date().getMonth(),
            selected: null
        };
        var covMonthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        function covCalRender(which) {
            var cal = which === 'leave' ? covLeafCal : covCoverCal;
            var gridId = which === 'leave' ? '#cov_leaveGrid' : '#cov_coverGrid';
            var labelId = which === 'leave' ? '#cov_leaveLabel' : '#cov_coverLabel';
            var selColor = which === 'leave' ? '#2dce89' : '#6366f1';

            $(labelId).text(covMonthNames[cal.month] + ' ' + cal.year);
            var $grid = $(gridId).empty();

            ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'].forEach(function(d) {
                $grid.append('<div style="font-weight:600;color:#adb5bd;padding:2px 0;font-size:10px;">' + d + '</div>');
            });

            var firstDay = new Date(cal.year, cal.month, 1).getDay();
            var daysInMonth = new Date(cal.year, cal.month + 1, 0).getDate();
            var today = new Date();
            today.setHours(0, 0, 0, 0);

            for (var i = 0; i < firstDay; i++) $grid.append('<div></div>');

            for (var d = 1; d <= daysInMonth; d++) {
                var key = cal.year + '-' + String(cal.month + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0');
                var dayDate = new Date(cal.year, cal.month, d);
                var isWeekend = dayDate.getDay() === 0 || dayDate.getDay() === 6;
                var isSelected = cal.selected === key;

                var bg, color, cursor;
                if (isSelected) {
                    bg = selColor;
                    color = '#fff';
                    cursor = 'pointer';
                } else if (isWeekend) {
                    bg = '#fde8e8';
                    color = '#c0392b';
                    cursor = 'pointer';
                } else {
                    bg = '#f8f9fa';
                    color = '#343a40';
                    cursor = 'pointer';
                }

                $grid.append(
                    '<div data-covkey="' + key + '" data-covwhich="' + which + '" ' +
                    'style="background:' + bg + ';color:' + color + ';cursor:' + cursor + ';border-radius:4px;padding:5px 1px;font-size:11px;transition:background .1s;">' +
                    d + '</div>'
                );
            }
        }

        $(document).on('click', '[data-covkey]', function() {
            var key = $(this).data('covkey');
            var which = $(this).data('covwhich');
            if (which === 'leave') {
                covLeafCal.selected = key;
                $('#covering_leave_date').val(covFmtSlash(key));
                $('#cov_leaveSelected').text('Selected: ' + covFmtDisplay(key));
                covCalRender('leave');
            } else {
                covCoverCal.selected = key;
                $('#covering_cover_date').val(covFmtSlash(key));
                $('#cov_coverSelected').text('Selected: ' + covFmtDisplay(key));
                covCalRender('cover');
            }
        });

        $('#cov_leavePrev').on('click', function() {
            covNavMonth(covLeafCal, -1, 'leave');
        });
        $('#cov_leaveNext').on('click', function() {
            covNavMonth(covLeafCal, 1, 'leave');
        });
        $('#cov_coverPrev').on('click', function() {
            covNavMonth(covCoverCal, -1, 'cover');
        });
        $('#cov_coverNext').on('click', function() {
            covNavMonth(covCoverCal, 1, 'cover');
        });

        function covNavMonth(cal, dir, which) {
            cal.month += dir;
            if (cal.month < 0) {
                cal.month = 11;
                cal.year--;
            }
            if (cal.month > 11) {
                cal.month = 0;
                cal.year++;
            }
            covCalRender(which);
        }

        function covFmtSlash(k) {
            var p = k.split('-');
            return p[1] + '/' + p[2] + '/' + p[0]; // mm/dd/yyyy
        }

        function covFmtDisplay(k) {
            var p = k.split('-');
            return p[2] + ' ' + covMonthNames[parseInt(p[1]) - 1] + ' ' + p[0];
        }

        function resetCoveringForm() {
            $('#covering_title, #covering_reason').val('');
            $('#covering_leave_date, #covering_cover_date').val('');
            covLeafCal.selected = null;
            covCoverCal.selected = null;
            covLeafCal.year = new Date().getFullYear();
            covLeafCal.month = new Date().getMonth();
            covCoverCal.year = new Date().getFullYear();
            covCoverCal.month = new Date().getMonth();
            $('#cov_leaveSelected, #cov_coverSelected').text('');
            $('#cov_validationError').html('');
        }

        /* Covering submit */
        $('#cov_submitBtn').on('click', function() {
            var title = $.trim($('#covering_title').val());
            var reason = $.trim($('#covering_reason').val());
            var leaveDate = $('#covering_leave_date').val();
            var coverDate = $('#covering_cover_date').val();
            var $err = $('#cov_validationError');
            $err.html('');

            if (!title) {
                $err.html('<div class="alert alert-danger py-2 mt-1" style="font-size:12px;border-radius:6px;"><i class="fa fa-exclamation-circle mr-1"></i>Title is required.</div>');
                return;
            }
            if (!leaveDate) {
                $err.html('<div class="alert alert-danger py-2 mt-1" style="font-size:12px;border-radius:6px;"><i class="fa fa-exclamation-circle mr-1"></i>Please select the leave date.</div>');
                return;
            }
            if (!coverDate) {
                $err.html('<div class="alert alert-danger py-2 mt-1" style="font-size:12px;border-radius:6px;"><i class="fa fa-exclamation-circle mr-1"></i>Please select the covering date.</div>');
                return;
            }
            if (leaveDate === coverDate) {
                $err.html('<div class="alert alert-danger py-2 mt-1" style="font-size:12px;border-radius:6px;"><i class="fa fa-exclamation-circle mr-1"></i>Leave date and covering date cannot be the same day.</div>');
                return;
            }

            var $btn = $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Submitting…');

            $.ajax({
                url: '{{ route("leave.create") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    is_covering: 1,
                    covering_title: title,
                    covering_reason: reason,
                    covering_leave_date: leaveDate,
                    covering_cover_date: coverDate
                },
                success: function() {
                    $btn.prop('disabled', false).html('<i class="fa fa-check mr-1"></i> Submit Covering Day');
                    $('#employee_leave_request_Modal').modal('hide');
                    showToast('Covering day submitted!', leaveDate + ' off → ' + coverDate + ' working instead.', '#6366f1');
                    setTimeout(function() {
                        $('#emp_successToast').fadeOut(400, function() {
                            $(this).remove();
                            make_employee_leave_table($('#leavetypes_select2').val(), userId);
                        });
                    }, 4000);
                    resetCoveringForm();
                },
                error: function(xhr) {
                    $btn.prop('disabled', false).html('<i class="fa fa-check mr-1"></i> Submit Covering Day');
                    var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Submission failed.';
                    $err.html('<div class="alert alert-danger py-2 mt-1" style="font-size:12px;border-radius:6px;"><i class="fa fa-exclamation-circle mr-1"></i>' + msg + '</div>');
                }
            });
        });
    });
</script>
@endsection