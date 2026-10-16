@extends('layouts.app', ['activePage' => 'Employee_Managment', 'titlePage' => __('Employee Managment')])

@section('content')

@can('edit employee')
<!-- edit -->
<style>
    .se-pre-con {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        display: none;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }

    p {
        font-size: 0.9rem !important;
    }

    /* ── Nav Tabs ── */
    .nav-tabs {
        border-bottom: 2px solid #e0e0e0;
    }

   .nav-tabs .nav-link {
        border-radius: 8px;
        background: #FFFFFF;
        border: 1px solid #D1D5DB !important;
        padding: 8px 16px;
        white-space: nowrap;
        color: #374151;
        text-transform: none;
        letter-spacing: normal;
        font-weight: 600;
    }

    .nav-tabs .nav-link.active {
        background: #000000;
        color: #fff !important;
        border: 1px solid #D1D5DB !important;
    }

    .nav-tabs .nav-link:hover {
        color: #333;
    }

    /* ── Profile Header ── */
    .profile-header-card {
        background: #fff;
        border: 1px solid #ebebeb;
        border-radius: 6px;
        padding: 20px 24px;
        margin-bottom: 20px;
    }

    .user_dp {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #f0f0f0;
    }

    .dp-wrapper {
        position: relative;
        display: inline-block;
    }

    .dp-edit-icon {
        position: absolute;
        bottom: 4px;
        right: 4px;
        background: #fff;
        border-radius: 50%;
        width: 26px;
        height: 26px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.18);
        cursor: pointer;
        font-size: 0.7rem;
        color: #444;
    }

    /* ── Field Label + Input box style ── */
    .field-group {
        display: flex;
        flex-direction: column;
    }

    .field-group label {
        font-size: 0.75rem;
        color: #888;
        margin-bottom: 4px;
        font-weight: 500;
    }

    .field-input {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 7px 10px;
        font-size: 0.85rem;
        color: #222;
        background: #fff;
        width: 100%;
        transition: border-color 0.15s;
        height: 36px;
    }

    .field-input:focus {
        outline: none;
        border-color: #3da087;
        box-shadow: 0 0 0 2px rgba(61, 160, 135, 0.1);
    }

    .field-input:disabled {
        background: #f7f7f7;
        color: #aaa;
        cursor: not-allowed;
    }

    .field-input.date-field {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%23aaa' stroke-width='2'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: 10px center;
        padding-left: 30px;
    }

    .field-input.time-field {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%23aaa' stroke-width='2'%3E%3Ccircle cx='12' cy='12' r='10'%3E%3C/circle%3E%3Cpolyline points='12 6 12 12 16 14'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: 10px center;
        padding-left: 30px;
    }

    /* ── Section Cards ── */
    .section-card {
        background: #fff;
        border: 1px solid #ebebeb;
        border-radius: 6px;
        padding: 22px 24px;
        margin-bottom: 20px;
        height: 100%;
    }

    .section-card h3 {
        font-size: 1rem;
        font-weight: 700;
        color: #111;
        margin-bottom: 18px;
    }

    /* ── Select2 override ── */
    .select2.select2-container {
        width: 100% !important;
    }

    .select2-container .select2-selection--single {
        height: 36px !important;
        border: 1px solid #ddd !important;
        border-radius: 4px !important;
        padding: 4px 8px !important;
        font-size: 0.85rem !important;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        line-height: 26px !important;
        color: #222 !important;
        border: none !important;
        padding: 0 !important;
    }

    .select2-container .select2-selection--single .select2-selection__arrow {
        height: 34px !important;
    }

    .select2-container--focus .select2-selection--single,
    .select2-container--open .select2-selection--single {
        border-color: #3da087 !important;
        box-shadow: 0 0 0 2px rgba(61, 160, 135, 0.1) !important;
        outline: none !important;
    }

    .select2-container .select2-selection--multiple {
        border: 1px solid #ddd !important;
        border-radius: 4px !important;
        min-height: 36px !important;
        padding: 2px 6px !important;
    }

    .select2-container--focus .select2-selection--multiple {
        border-color: #3da087 !important;
        box-shadow: 0 0 0 2px rgba(61, 160, 135, 0.1) !important;
        outline: none !important;
    }

    .select2-selection__choice {
        background: #e8f5f1 !important;
        border: none !important;
        color: #1a7a60 !important;
        border-radius: 3px !important;
        font-size: 0.78rem !important;
    }

    /* ── intl-tel-input wrapper ── */
    .iti {
        display: block !important;
    }

    .iti .iti__flag-container {
        border-radius: 4px 0 0 4px;
    }

    /* ── Password fields ── */
    .field-input[type="password"] {
        letter-spacing: 0.1em;
    }

    /* ── 4 equal-height cards row ── */
    .cards-equal-row {
        display: flex;
        flex-wrap: wrap;
    }

    .cards-equal-row>.col-6 {
        display: flex;
        flex-direction: column;
    }

    .cards-equal-row>.col-6 .section-card {
        flex: 1;
    }

    /* ── Permissions modal ── */
    .permissions-list {
        column-count: 3;
        column-gap: 20px;
        list-style-position: inside;
    }

    .custom-btn-style {
        font-size: .675rem !important;
        font-weight: 400 !important;
        padding: .325rem 0.5rem !important;
        border-radius: 1px !important;
    }

    /* ── Document tabs ── */
    .opacity-50 {
        opacity: 0.5;
    }

    .document-preview-card {
        max-width: 460px;
        margin: 0 auto;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .document-preview-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12) !important;
    }

    /* groups/permissions edit link */
    .edit-groups-link {
        color: #a7a7a7;
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .edit-groups-link:hover {
        color: #555;
    }

    /* ═══════════════════════════════════════════
    MOBILE RESPONSIVE — Employee Edit Page
    ═══════════════════════════════════════════ */
    .mobile-upload-hint {
        display: none;
    }

    @media (max-width: 767.98px) {

        .main-content {
            background-color: #F9FAFB !important;
        }

        /* ── Profile header: avatar + title centered, fields stacked ── */
        .profile-header-card {
            padding: 20px 16px;
        }

        .profile-header-card > .d-flex {
            flex-direction: column;
            align-items: center;
        }

        .dp-wrapper {
            margin: 0 auto 6px auto !important;
        }

        .user_dp {
            width: 120px;
            height: 120px;
        }

        .dp-edit-icon {
            width: 30px;
            height: 30px;
            background: #3da087;
            color: #fff;
            bottom: 0;
            right: 0;
        }

        .mobile-upload-hint {
            display: block;
            font-size: 0.78rem;
            color: #888;
            margin: 6px 0 14px 0;
            text-align: center;
        }

        .profile-header-card .flex-grow-1::before {
            content: "Employee Information";
            display: block;
            font-size: 1rem;
            font-weight: 700;
            color: #111;
            text-align: center;
            margin-bottom: 16px;
        }

        .profile-header-card .row > div[class^="col-"] {
            flex: 0 0 100% !important;
            max-width: 100% !important;
            margin-bottom: 4px;
        }

        .profile-header-card .row > div[class^="col-"]:nth-last-child(2),
        .profile-header-card .row > div[class^="col-"]:last-child {
            flex: 0 0 48% !important;
            max-width: 48% !important;
            display: inline-block;
        }

        /* ── Tabs become rounded pill buttons that scroll horizontally ── */
        .nav-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
            gap: 8px;
            border-bottom: none;
            padding-bottom: 4px;
            scrollbar-width: none;
        }

        .nav-tabs .nav-link {
            border-radius: 8px;
            background: #ffffff !important;
            border-bottom: none !important;
            padding: 8px 16px;
            white-space: nowrap;
        }

        .nav-tabs .nav-link.active {
            background: #111 !important;
            color: #fff !important;
            border-bottom: none !important;
        }

        /* ── Section cards: stack full width ── */
        .cards-equal-row {
            flex-direction: column;
        }

        .cards-equal-row > .col-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .section-card {
            padding: 16px;
            margin-bottom: 14px;
        }

        .section-card .row > div[class^="col-"] {
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }

        /* ── Card header: icon + title + chevron, same style as the Add Employee page ── */
        .section-card > h3 {
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
            padding-right: 24px;
            font-size: 0.9rem;
            margin-bottom: 14px !important;
        }

        .section-card > h3::before {
            width: 34px;
            height: 34px;
            min-width: 34px;
            border-radius: 8px;
            background: #e8f5f1;
            color: #3da087;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            font-size: 0.9rem;
        }

        .section-card > h3::after {
            content: "\f078"; /* chevron-down */
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            font-size: 0.8rem;
        }

        /* Icon per card on the Basic Information tab, matched by position */
        .cards-equal-row:nth-of-type(1) > .col-6:nth-of-type(1) .section-card > h3::before {
            content: "\f007"; /* user → Personal Details */
        }
        .cards-equal-row:nth-of-type(1) > .col-6:nth-of-type(2) .section-card > h3::before {
            content: "\f3c5"; /* map pin → Contact Details */
        }
        .cards-equal-row:nth-of-type(2) > .col-6:nth-of-type(1) .section-card > h3::before {
            content: "\f0b1"; /* briefcase → Job Details */
        }
        .cards-equal-row:nth-of-type(2) > .col-6:nth-of-type(2) .section-card > h3::before {
            content: "\f023"; /* lock → Login Information */
        }

        /* Icon per card on the document tabs */
        #verification-docs .section-card > h3::before { content: "\f15c"; } /* file-alt */
        #appointment-letter .section-card > h3::before { content: "\f573"; } /* file-signature */
        #contract .section-card > h3::before { content: "\f56c"; } /* file-contract */
        #nda .section-card > h3::before { content: "\f3ed"; } /* shield-alt */

        /* ── Form fields: bold labels, taller rounded inputs ── */
        .section-card .field-group label,
        .profile-header-card .field-group label {
            font-size: 0.78rem;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 6px;
        }

        .section-card .field-input,
        .profile-header-card .field-input,
        .section-card .select2-container .select2-selection--single,
        .profile-header-card .select2-container .select2-selection--single,
        .section-card .select2-container .select2-selection--multiple {
            border: 1px solid #e5e7eb !important;
            border-radius: 8px !important;
            height: 44px !important;
            font-size: 0.9rem !important;
        }

        .section-card .select2-container .select2-selection--single .select2-selection__rendered,
        .profile-header-card .select2-container .select2-selection--single .select2-selection__rendered {
            line-height: 42px !important;
        }

        .section-card .row[style*="row-gap"],
        .profile-header-card .row[style*="row-gap"] {
            row-gap: 18px !important;
        }

        /* ── Document tabs: upload box stacked above the uploaded-files list ── */
        #verification-docs .row,
        #appointment-letter .row,
        #contract .row,
        #nda .row {
            flex-direction: column;
        }

        #verification-docs .col-6,
        #appointment-letter .col-6,
        #contract .col-6,
        #nda .col-6 {
            flex: 0 0 100%;
            max-width: 100%;
            margin-bottom: 16px;
        }

        /* "Attribute Image *" label above the drop zone (injected, since no HTML label exists) */
        .tab-pane .file-drop-zone {
            position: relative;
            margin-top: 28px;
            border: 2px dashed #d8dadf !important;
            border-radius: 12px !important;
            background: #fafafa;
            padding: 34px 16px 24px 16px !important;
            text-align: center;
        }

        .tab-pane .file-drop-zone::before {
            content: "Attribute Image *";
            position: absolute;
            top: -26px;
            left: 0;
            font-size: 0.78rem;
            font-weight: 600;
            color: #374151;
        }

        /* Circle icon above the drag-drop text */
        .tab-pane .file-drop-zone-title {
            color: #555;
            font-size: 0.85rem;
            line-height: 1.5;
            padding-top: 54px;
            position: relative;
        }

        .tab-pane .file-drop-zone-title::before {
            content: "\f15c"; /* file icon */
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f1f2f4;
            color: #555;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        /* Decorative "Upload" button under the text (the drop zone already opens the file picker on any click) */
        .tab-pane .file-drop-zone-title::after {
            content: "Upload";
            display: block;
            width: fit-content;
            margin: 14px auto 0 auto;
            padding: 6px 22px;
            border: 1px solid #3da087;
            border-radius: 6px;
            color: #3da087;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* "Uploaded Documents" → "Uploaded Attribute Images" (text swap via CSS, real text hidden) */
        .tab-pane h4.mb-2 {
            font-size: 0 !important; /* hide the real "Uploaded Documents" text */
            margin-bottom: 10px !important;
            padding-bottom: 10px;
            border-bottom: 1px solid #ececec;
        }

        .tab-pane h4.mb-2::before {
            content: "Uploaded Attribute Images";
            font-size: 0.85rem;
            font-weight: 700;
            color: #111;
        }

        /* Uploaded documents table → stacked rows with rounded icon buttons */
        .tab-pane .table thead {
            display: none;
        }

        .tab-pane .table,
        .tab-pane .table tbody {
            display: block;
            width: 100%;
        }

        .tab-pane .table tr {
            display: grid !important;
            grid-template-columns: minmax(0, 1fr) auto;
            align-items: center;
            column-gap: 10px;
            width: 100%;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .tab-pane .table tr:has(td[colspan]) {
            display: block !important;
            text-align: center;
            padding: 16px 0;
        }

        .tab-pane .table td {
            display: block;
            min-width: 0;
        }

        .tab-pane .table td:first-child {
            font-size: 0.8rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .tab-pane .table td:last-child {
            display: flex;
            gap: 6px;
            justify-content: flex-end;
        }

        /* Base button shape for the 3 icon buttons */
        .tab-pane .table td a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border: 1px solid #ddd;
            border-radius: 6px;
            color: #666 !important;
            margin-right: 0 !important;
            flex-shrink: 0;
        }

        /* View (eye) button — blue */
        .tab-pane .table td a.btn-view-doc {
            border-color: #bcd9f3;
            color: #2563eb !important;
        }

        /* Download button — identified by its "download" attribute */
        .tab-pane .table td a[download] {
            border-color: #ddd;
            color: #555 !important;
        }

        /* Delete button — identified by its onclick="deleteFile(...)" */
        .tab-pane .table td a[onclick^="deleteFile"] {
            border-color: #f3c6c6;
            color: #dc3545 !important;
        }

        ul#employeeTab {
            padding-top: 10px;
            padding-bottom: 16px;
        }

        .back_home_mobile {
            padding-left: 2px;
            padding-bottom: 10px;
        }

        
    }

    @media (min-width: 768px) {
        .back_home_mobile {
            display: none;
        }
    }
</style>

@if ($errors->any())
<div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')<span>Employee Profile</span>@endsection

    @section('back-btn')
    <a href="{{ route('HR.employee_view', ['id' => $user->id]) }}" class="home-btn-color" title="Back">BACK</a>
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

    <input type="hidden" id="user_id" value="{{ $user->id }}">

    {{-- ══════════════════════════════════════════
         PROFILE HEADER
    ══════════════════════════════════════════ --}}
    <div class="profile-header-card">
        <div class="d-flex align-items-start">

            {{-- Avatar --}}
            <div class="dp-wrapper mr-4 flex-shrink-0">
                @if($user->profile_pic)
                <img src="{{ asset($user->profile_pic) }}" class="user_dp" />
                @else
                <img src="{{ asset('assets') }}/img/user/default.png" class="user_dp" />
                @endif
                <div class="dp-edit-icon"><i class="fa fa-pen"></i></div>
                <input type="file" id="dp-file-input" accept="image/*" style="display:none;" />
            </div>

            {{-- Header Fields Grid --}}
            <div class="flex-grow-1">
                <!-- <div class="d-flex justify-content-between align-items-center mb-3">
                    <div></div>
                    <span class="edit-groups-link edit_usergroup" data-uid="{{ $user->id }}">
                        <i class="fa fa-pen-to-square fa-lg mr-1"></i>
                        <small style="font-weight:600; letter-spacing:0.03em;">GROUP & PERMISSIONS</small>
                    </span>
                </div> -->
                <div class="row" style="row-gap: 12px;">
                    <div class="col-3">
                        <div class="field-group">
                            <label>First Name</label>
                            <input class="field-input" id="employee_firstname" type="text"
                                value="{{ explode(' ', $user->name)[0] ?? $user->name }}"
                                data-AlradySaved="{{ $user->name }}" />
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="field-group">
                            <label>Last Name</label>
                            <input class="field-input" id="employee_lastname" type="text"
                                value="{{ implode(' ', array_slice(explode(' ', $user->name), 1)) }}"
                                data-AlradySaved="{{ $user->name }}" />
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="field-group">
                            <label>Employee Number</label>
                            <input class="field-input" type="text"
                                value="{{ 'EMP' . str_pad($user->id, 3, '0', STR_PAD_LEFT) }}" disabled />
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="field-group">
                            <label>Job Title</label>
                            <input class="field-input" id="employee_jobtitle" type="text"
                                value="{{ $user->userDetails->job_title ?? '' }}"
                                data-AlradySaved="{{ $user->userDetails->job_title }}" />
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="field-group">
                            <label>Official Phone Number</label>
                            <input class="field-input" id="employee_phoneNumber" type="text"
                                value="{{ $user->userDetails->m_number ?? '' }}"
                                data-AlradySaved="{{ $user->userDetails->m_number }}" />
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="field-group">
                            <label>Official Email</label>
                            <input class="field-input" type="email"
                                value="{{ $user->email }}" disabled />
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="field-group">
                            <label>Time Zone</label>
                            <select class="header-select2" id="employee_timezone_header"
                                data-AlradySaved="{{ $user->userDetails->timezone }}">
                                <option value="">Select</option>
                                @foreach ($timezoneset as $item)
                                <option value="{{ $item }}" @if($user->userDetails->timezone == $item) selected @endif>{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="field-group">
                            <label>Date</label>
                            <input class="field-input date-field" type="text"
                                value="{{ $user->userDetails && $user->userDetails->timezone ? now()->setTimezone($user->userDetails->timezone)->format('d/m/Y') : now()->format('d/m/Y') }}"
                                disabled />
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="field-group">
                            <label>Current Time</label>
                            <input class="field-input time-field" id="current_time_display" type="text"
                                value="{{ $user->userDetails && $user->userDetails->timezone ? now()->setTimezone($user->userDetails->timezone)->format('H:i:s') : now()->format('H:i:s') }}"
                                disabled style="color: #3da087;" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         TABS
    ══════════════════════════════════════════ --}}
    <ul class="nav nav-tabs mb-3" id="employeeTab" role="tablist">
        <li>
            <a class="nav-link active" data-toggle="tab" href="#basic-info" role="tab">Basic Information</a>
        </li>
        <li>
            <a class="nav-link" data-toggle="tab" href="#verification-docs" role="tab">Verification Documents</a>
        </li>
        <li>
            <a class="nav-link" data-toggle="tab" href="#appointment-letter" role="tab">Appointment Letter</a>
        </li>
        <li>
            <a class="nav-link" data-toggle="tab" href="#contract" role="tab">Contract</a>
        </li>
        <li>
            <a class="nav-link" data-toggle="tab" href="#nda" role="tab">NDA</a>
        </li>
    </ul>

    <div class="tab-content" id="employeeTabContent">

        {{-- ══════════════════════════════════════════
             TAB 1 — BASIC INFORMATION
        ══════════════════════════════════════════ --}}
        <div class="tab-pane fade show active" id="basic-info" role="tabpanel">

            {{-- Row 1: Personal + Contact (equal height) --}}
            <div class="row cards-equal-row">
                {{-- Personal Details --}}
                <div class="col-6">
                    <div class="section-card">
                        <h3>Personal Details</h3>
                        <div class="row" style="row-gap:14px;">
                            <div class="col-4">
                                <div class="field-group">
                                    <label>Date of Birth</label>
                                    <input class="field-input date-field" id="employee_dob" type="text"
                                        value="{{ $user->userDetails->dob }}"
                                        data-AlradySaved="{{ $user->userDetails->dob }}" />
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="field-group">
                                    <label>Marital Status</label>
                                    <select class="field-select2" id="marital_status"
                                        data-AlradySaved="{{ $user->userDetails->Marital_Status }}">
                                        <option value="">Select</option>
                                        <option value="Single" @if($user->userDetails->Marital_Status=='Single') selected @endif>Single</option>
                                        <option value="Married" @if($user->userDetails->Marital_Status=='Married') selected @endif>Married</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="field-group">
                                    <label>Gender</label>
                                    <select class="field-select2" id="employee_Gender"
                                        data-AlradySaved="{{ $user->userDetails->Gender }}">
                                        <option value="">Select</option>
                                        <option value="Male" @if($user->userDetails->Gender=='Male') selected @endif>Male</option>
                                        <option value="Female" @if($user->userDetails->Gender=='Female') selected @endif>Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="field-group">
                                    <label>Nationality</label>
                                    <select class="field-select2" id="employee_Nationality"
                                        data-AlradySaved="{{ $user->userDetails->Nationality }}">
                                        <option value="">Select</option>
                                        @foreach ($nationalities as $nationality)
                                        <option value="{{ $nationality }}" @if($user->userDetails->Nationality==$nationality) selected @endif>{{ $nationality }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="field-group">
                                    <label>Languages</label>
                                    <select class="field-select2-multi" id="employee_Languages" multiple>
                                        @foreach ($languages as $language)
                                        <option value="{{ $language }}" @if(in_array($language, $savedLanguages)) selected @endif>{{ $language }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Contact Details --}}
                <div class="col-6">
                    <div class="section-card">
                        <h3>Contact Details</h3>
                        <div class="row" style="row-gap:14px;">
                            <div class="col-8">
                                <div class="field-group">
                                    <label>Home Address</label>
                                    <input class="field-input" id="employee_address" type="text"
                                        value="{{ $user->userDetails->address }}"
                                        data-AlradySaved="{{ $user->userDetails->address }}" />
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="field-group">
                                    <label>City</label>
                                    <input class="field-input" id="employee_city" type="text"
                                        value="{{ $user->userDetails->city }}"
                                        data-AlradySaved="{{ $user->userDetails->city }}" />
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="field-group">
                                    <label>Country</label>
                                    <select class="field-select2" id="employee_country"
                                        data-AlradySaved="{{ $user->userDetails->country }}">
                                        <option value="">Select</option>
                                        @foreach ($countries as $country)
                                        <option value="{{ $country['code'] }}" @if($user->userDetails->country==$country['code']) selected @endif>
                                            {{ $country['name'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="field-group">
                                    <label>Postal Code</label>
                                    <input class="field-input" id="employee_postalcode" type="text"
                                        value="{{ $user->userDetails->postal_code }}"
                                        data-AlradySaved="{{ $user->userDetails->postal_code }}" />
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="field-group">
                                    <label>Phone Number</label>
                                    <input class="field-input" id="employee_phoneNumber_contact" type="text"
                                        value="{{ $user->userDetails->m_number }}"
                                        data-AlradySaved="{{ $user->userDetails->m_number }}" />
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="field-group">
                                    <label>Private Email</label>
                                    <input class="field-input" id="employee_privateemail" type="email"
                                        value="{{ $user->userDetails->Private_Email }}"
                                        data-AlradySaved="{{ $user->userDetails->Private_Email }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Row 2: Job Details + Login Information (equal height) --}}
            <div class="row cards-equal-row">
                {{-- Job Details --}}
                <div class="col-6">
                    <div class="section-card">
                        <h3>Job Details</h3>
                        <div class="row" style="row-gap:14px;">
                            <div class="col-4">
                                <div class="field-group">
                                    <label>Employment Status</label>
                                    <select class="field-select2" id="employee_Employment_Status"
                                        data-AlradySaved="{{ $user->userDetails->Employment_Status }}">
                                        <option value="">Select</option>
                                        <option value="Full Time" @if($user->userDetails->Employment_Status=='Full Time') selected @endif>Full Time</option>
                                        <option value="Part Time" @if($user->userDetails->Employment_Status=='Part Time') selected @endif>Part Time</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="field-group">
                                    <label>Job Title</label>
                                    <input class="field-input" id="employee_jobtitle_tab" type="text"
                                        value="{{ $user->userDetails->job_title }}"
                                        data-AlradySaved="{{ $user->userDetails->job_title }}" />
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="field-group">
                                    <label>Leave Group</label>
                                    {{-- FIXED --}}
                                    <select class="field-select2" id="employee_leave_type" name="leave_group_id">
                                        <option value="">Select</option>
                                        @foreach ($leaveGroups as $item)
                                        <option value="{{ $item->id }}" @if($user->userDetails->leavetype_id == $item->id) selected @endif>
                                            {{ $item->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="field-group">
                                    <label>Joined Date</label>
                                    <input class="field-input date-field" id="employee_joineddate" type="text"
                                        value="{{ $user->userDetails->joined_date }}"
                                        data-AlradySaved="{{ $user->userDetails->joined_date }}" />
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="field-group">
                                    <label>Department</label>
                                    <select class="field-select2" name="department" id="employee_Department_select">
                                        <option value="">Select Department</option>

                                        @foreach ($departmentsNames as $dept)
                                            <option value="{{ $dept }}"
                                                {{ ($user->userDetails->Department ?? '') == $dept ? 'selected' : '' }}>
                                                {{ $dept }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Login Information --}}
                <div class="col-6">
                    <div class="section-card">
                        <h3>Login Information</h3>
                        <form action="{{ route('userpassword.change') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <div class="row" style="row-gap:14px;">
                                <div class="col-12">
                                    <div class="field-group">
                                        <label>Work Email (Login)</label>
                                        <input class="field-input" type="email" value="{{ $user->email }}" disabled />
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="field-group">
                                        <label>Old Password</label>
                                        <input class="field-input @error('old_password') is-invalid @enderror"
                                            type="password" name="old_password" placeholder="••••••••" />
                                        @error('old_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="field-group">
                                        <label>New Password</label>
                                        <input class="field-input @error('new_password') is-invalid @enderror"
                                            type="password" name="new_password" placeholder="••••••••" />
                                        @error('new_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="field-group">
                                        <label>Confirm Password</label>
                                        <input class="field-input @error('new_password_confirmation') is-invalid @enderror"
                                            type="password" name="new_password_confirmation" placeholder="••••••••" />
                                        @error('new_password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success custom-btn-style">Change Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>{{-- /basic-info --}}

        {{-- TAB 2 — VERIFICATION DOCUMENTS --}}
        <div class="tab-pane fade" id="verification-docs" role="tabpanel">
            <div class="section-card">
                <h3>Verification Documents</h3>
                <div class="row">
                    <div class="col-6">
                        <input id="upload_verificationDocument" type="file" multiple
                            class="no-notify" data-browse-on-zone-click="true">
                    </div>
                    <div class="col-6">
                        <h4 class="mb-2" style="font-size:0.9rem;font-weight:700;">Uploaded Documents</h4>
                        <table class="table">
                            <thead style="background:#929090;color:#fff;">
                                <tr>
                                    <th style="width:80%;">File Name</th>
                                    <th style="text-align:center;width:20%;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="files-verificationDocument"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB 3 — APPOINTMENT LETTER --}}
        <div class="tab-pane fade" id="appointment-letter" role="tabpanel">
            <div class="section-card">
                <h3>Appointment Letter</h3>
                <div class="row">
                    <div class="col-6">
                        <input id="upload_appointmentLetterDocument" type="file" multiple
                            class="no-notify" data-browse-on-zone-click="true">
                    </div>
                    <div class="col-6">
                        <h4 class="mb-2" style="font-size:0.9rem;font-weight:700;">Uploaded Documents</h4>
                        <table class="table">
                            <thead style="background:#929090;color:#fff;">
                                <tr>
                                    <th style="width:80%;">File Name</th>
                                    <th style="text-align:center;width:20%;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="files-appointmentLetterDocument"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB 4 — CONTRACT --}}
        <div class="tab-pane fade" id="contract" role="tabpanel">
            <div class="section-card">
                <h3>Contract</h3>
                <div class="row">
                    <div class="col-6">
                        <input id="upload_contractDocument" type="file" multiple
                            class="no-notify" data-browse-on-zone-click="true">
                    </div>
                    <div class="col-6">
                        <h4 class="mb-2" style="font-size:0.9rem;font-weight:700;">Uploaded Documents</h4>
                        <table class="table">
                            <thead style="background:#929090;color:#fff;">
                                <tr>
                                    <th style="width:80%;">File Name</th>
                                    <th style="text-align:center;width:20%;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="files-contractDocument"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB 5 — NDA --}}
        <div class="tab-pane fade" id="nda" role="tabpanel">
            <div class="section-card">
                <h3>NDA</h3>
                <div class="row">
                    <div class="col-6">
                        <input id="upload_ndaDocument" type="file" multiple
                            class="no-notify" data-browse-on-zone-click="true">
                    </div>
                    <div class="col-6">
                        <h4 class="mb-2" style="font-size:0.9rem;font-weight:700;">Uploaded Documents</h4>
                        <table class="table">
                            <thead style="background:#929090;color:#fff;">
                                <tr>
                                    <th style="width:80%;">File Name</th>
                                    <th style="text-align:center;width:20%;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="files-ndaDocument"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /tab-content --}}
</div>

{{-- ══════════════════════════════════════════
     DOCUMENT VIEWER MODAL
══════════════════════════════════════════ --}}
<div class="modal fade" id="documentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="documentModalLabel">Document Viewer</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body text-center p-0" style="min-height:70vh;background:#f1f1f1;">
                <iframe id="documentIframe" style="width:100%;height:70vh;border:none;" src=""></iframe>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════
     GROUPS & PERMISSIONS MODAL
══════════════════════════════════════════ --}}
<div class="modal fade" id="view_group_Modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Employee Groups & Permissions</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row px-3 pb-2">
                    <div class="col-8">
                        <label class="form-label">Add User Group</label>
                        <select class="select2" id="employee_groups_select" data-uid="" style="width:100%;">
                            <option value="">Select User Group</option>
                        </select>
                    </div>
                </div>
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Group Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider"></tbody>
                </table>
                <h3>Permissions</h3>
                <ol class="permissions-list"></ol>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

<script>
    $(document).ready(function() {

        let userId = $("#user_id").val();
        // ── Profile picture upload ──
        $('.dp-edit-icon').on('click', function() {
            $('#dp-file-input').trigger('click');
        });

        $('#dp-file-input').on('change', function() {
            var file = this.files[0];
            if (!file) return;

            var fd = new FormData();
            fd.append('profile_picture', file);
            fd.append('user_id', userId); // pass target user's ID
            fd.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: '{{ route("updateProfilePicture") }}',
                method: 'POST',
                data: fd,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $(".se-pre-con").fadeIn('fast');
                },
                success: function(r) {
                    $(".se-pre-con").fadeOut('fast');
                    if (r.success) {
                        $('.user_dp').attr('src', r.file_path + '?t=' + Date.now());
                    } else {
                        alert('Upload failed.');
                    }
                },
                error: function() {
                    $(".se-pre-con").fadeOut('fast');
                    alert('Upload failed. Please try again.');
                }
            });
        });
        // ── Select2 inits ──
        $('.field-select2').select2({
            width: '100%',
            minimumResultsForSearch: 6
        });
        $('.field-select2-multi').select2({
            width: '100%',
            placeholder: 'Select...'
        });
        $('.header-select2').select2({
            width: '100%',
            minimumResultsForSearch: 5
        });
        $('#employee_groups_select').select2({
            placeholder: "Select User Group",
            dropdownParent: $("#view_group_Modal"),
            allowClear: true
        });

        // ── Datepickers ──
        $("#employee_dob, #employee_joineddate").datepicker({
            dateFormat: "mm/dd/yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "1900:2025",
            maxDate: "0"
        });

        // ── Live clock ──
        function updateClock() {
            var tz = "{{ $user->userDetails->timezone ?? '' }}";
            if (!tz) return;
            try {
                var now = new Date();
                var timeStr = now.toLocaleTimeString('en-GB', {
                    timeZone: tz,
                    hour12: false
                });
                $("#current_time_display").val(timeStr);
            } catch (e) {}
        }
        setInterval(updateClock, 1000);

        // ── Store initial values ──
        var initial = {
            employee_jobtitle: $("#employee_jobtitle").val(),
            employee_jobtitle_tab: $("#employee_jobtitle_tab").val(),
            employee_phoneNumber: $("#employee_phoneNumber").val(),
            employee_dob: $("#employee_dob").val(),
            marital_status: $("#marital_status").val(),
            employee_Gender: $("#employee_Gender").val(),
            employee_Nationality: $("#employee_Nationality").val(),
            employee_Languages: $("#employee_Languages").val(),
            employee_address: $("#employee_address").val(),
            employee_country: $("#employee_country").val(),
            employee_postalcode: $("#employee_postalcode").val(),
            employee_privateemail: $("#employee_privateemail").val(),
            employee_Employment_Status: $("#employee_Employment_Status").val(),
            employee_leave_type: $("#employee_leave_type").val(),
            employee_joineddate: $("#employee_joineddate").val(),
            employee_timezone: $("#employee_timezone_header").val(),
            employee_city: $("#employee_city").val(),
        };

        // ── Generic update ──
        function updateValue(column, modal, value) {
            $.ajax({
                url: "{{ url('/update-profile') }}",
                method: 'POST',
                data: {
                    colunm: column,
                    modal: modal,
                    value: value,
                    userId: userId,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    $(".se-pre-con").fadeIn('fast');
                },
                success: function() {
                    $(".se-pre-con").fadeOut('fast');
                },
                error: function() {
                    $(".se-pre-con").fadeOut('fast');
                }
            });
        }

        function isValidEmail(e) {
            return /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(e);
        }

        // ── Name ──
        function saveName() {
            var full = ($("#employee_firstname").val() + ' ' + $("#employee_lastname").val()).trim();
            updateValue('name', 'user', full);
        }
        $('#employee_firstname, #employee_lastname').on('keyup focusout', function(e) {
            if (e.type === 'keyup' && e.keyCode !== 13) return;
            saveName();
        });

        // ── Text fields ──
        function watchText(sel, col, modal, key) {
            $(sel).on('keyup focusout', function(e) {
                if (e.type === 'keyup' && e.keyCode !== 13) return;
                var v = $(this).val();
                if (v !== initial[key]) {
                    updateValue(col, modal, v);
                    initial[key] = v;
                }
            });
        }
        watchText('#employee_address', 'address', 'userdetails', 'employee_address');
        watchText('#employee_postalcode', 'postal_code', 'userdetails', 'employee_postalcode');
        watchText('#employee_city', 'city', 'userdetails', 'employee_city');

        $('#employee_jobtitle, #employee_jobtitle_tab').on('keyup focusout', function(e) {
            if (e.type === 'keyup' && e.keyCode !== 13) return;
            var v = $(this).val();
            updateValue('job_title', 'userdetails', v);
            $('#employee_jobtitle, #employee_jobtitle_tab').val(v);
            initial['employee_jobtitle'] = initial['employee_jobtitle_tab'] = v;
        });

        $('#employee_Department').on('keyup focusout', function(e) {
            if (e.type === 'keyup' && e.keyCode !== 13) return;
            updateValue('Department', 'userdetails', $(this).val());
        });

        $('#employee_phoneNumber, #employee_phoneNumber_contact').on('keyup focusout', function(e) {
            if (e.type === 'keyup' && e.keyCode !== 13) return;
            var v = $(this).val();
            if (v !== initial['employee_phoneNumber']) {
                updateValue('m_number', 'userdetails', v);
                $('#employee_phoneNumber, #employee_phoneNumber_contact').val(v);
                initial['employee_phoneNumber'] = v;
            }
        });

        $('#employee_privateemail').on('keyup focusout', function(e) {
            if (e.type === 'keyup' && e.keyCode !== 13) return;
            var v = $(this).val();
            if (!isValidEmail(v)) {
                Swal.fire({
                    icon: "error",
                    title: "Invalid Email",
                    text: "Please enter a valid email address."
                });
                return;
            }
            if (v !== initial['employee_privateemail']) {
                updateValue('Private_Email', 'userdetails', v);
                initial['employee_privateemail'] = v;
            }
        });

        // ── Select watchers ──
        function watchSelect(sel, col, modal, key) {
            $(sel).on('change', function() {
                var v = $(this).val();
                if (JSON.stringify(v) !== JSON.stringify(initial[key])) {
                    updateValue(col, modal, v);
                    initial[key] = v;
                }
            });
        }
        watchSelect('#marital_status', 'Marital_Status', 'userdetails', 'marital_status');
        watchSelect('#employee_Gender', 'Gender', 'userdetails', 'employee_Gender');
        watchSelect('#employee_Nationality', 'Nationality', 'userdetails', 'employee_Nationality');
        watchSelect('#employee_Languages', 'Languages', 'userdetails', 'employee_Languages');
        watchSelect('#employee_Employment_Status', 'Employment_Status', 'userdetails', 'employee_Employment_Status');
        watchSelect('#employee_leave_type', 'leavetype_id', 'userdetails', 'employee_leave_type');
        watchSelect('#employee_Department_select', 'Department', 'userdetails', 'employee_Department');

        $('#employee_dob').on('change', function() {
            var v = $(this).val();
            if (v !== initial['employee_dob']) {
                updateValue('dob', 'userdetails', v);
                initial['employee_dob'] = v;
            }
        });
        $('#employee_joineddate').on('change', function() {
            var v = $(this).val();
            if (v !== initial['employee_joineddate']) {
                updateValue('joined_date', 'userdetails', v);
                initial['employee_joineddate'] = v;
            }
        });

        var tzValue = initial['employee_timezone'];
        $('#employee_timezone_header').on('change', function() {
            var v = $(this).val();
            if (v !== tzValue) {
                updateValue('timezone', 'userdetails', v);
                tzValue = v;
            }
        });

        var countryValue = initial['employee_country'];
        $('#employee_country').on('change', function() {
            var v = $(this).val();
            if (v !== countryValue) {
                updateValue('country', 'userdetails', v);
                countryValue = v;
                $.ajax({
                    url: '{{ route("getTimezones") }}',
                    type: 'GET',
                    data: {
                        country: v
                    },
                    success: function(response) {
                        var sel = $('#employee_timezone_header');
                        sel.empty().append('<option value="' + tzValue + '">' + tzValue + '</option>');
                        $.each(response.timezones, function(k, val) {
                            sel.append('<option value="' + val + '">' + val + '</option>');
                        });
                        sel.trigger('change.select2');
                    }
                });
            }
        });

        // ── Groups modal ──
        function loadGroups(uid) {
            $.ajax({
                url: "{{ url('employee/get/groups') }}",
                type: "POST",
                data: {
                    userId: uid,
                    _token: $('meta[name="csrf-token"]').attr("content")
                },
                success: function(r) {
                    if (!r.success) return;
                    var sel = $('#employee_groups_select');
                    sel.empty().append('<option value="">Select User Group</option>');
                    r.groups.forEach(g => sel.append('<option value="' + g.id + '">' + g.name + '</option>'));
                    sel.attr('data-uid', uid);
                    var tb = $('.table-group-divider');
                    tb.empty();
                    r.userGroups.forEach((g, i) => tb.append('<tr><th>' + (i + 1) + '</th><td>' + g.name + '</td><td><i class="fas fa-trash-alt removeGroup" style="color:#dd4b28;cursor:pointer" data-group-id="' + g.id + '"></i></td></tr>'));
                    var pl = $('.permissions-list');
                    pl.empty();
                    r.permissions.forEach(p => pl.append('<li>' + p + '</li>'));
                }
            });
        }
        $(document).on('click', '.edit_usergroup', function() {
            $('#view_group_Modal').modal('show');
            loadGroups($(this).data('uid'));
        });
        $(document).on('click', '.removeGroup', function() {
            var gid = $(this).data('group-id');
            $.ajax({
                url: "{{ url('user_groups/update_members/delete') }}",
                type: "POST",
                data: {
                    user: userId,
                    user_group_members_group_id: gid,
                    _token: $('meta[name="csrf-token"]').attr("content")
                },
                success: function() {
                    loadGroups(userId);
                }
            });
        });
        $('#employee_groups_select').on('change', function() {
            var v = $(this).val(),
                uid = $(this).attr('data-uid');
            $.ajax({
                url: "{{ url('user_groups/update_members/add') }}",
                type: "POST",
                data: {
                    user: uid,
                    user_group_members_group_id: v,
                    _token: $('meta[name="csrf-token"]').attr("content")
                },
                success: function() {
                    loadGroups(uid);
                }
            });
        });

        // Eye icon click — use already-loaded content, no extra AJAX needed
        $(document).on('click', '.btn-view-doc', function() {
            var content = decodeURIComponent($(this).data('content'));
            var fileName = decodeURIComponent($(this).data('name'));

            $('#documentModalLabel').text(fileName);
            $('#documentIframe').attr('src', '');
            $('#documentModal').modal('show');

            // Convert base64 → Blob → Object URL so iframe can render it
            try {
                var arr = content.split(',');
                var mime = arr[0].match(/:(.*?);/)[1];
                var bstr = atob(arr[1]);
                var n = bstr.length;
                var u8arr = new Uint8Array(n);
                while (n--) {
                    u8arr[n] = bstr.charCodeAt(n);
                }
                var blob = new Blob([u8arr], {
                    type: mime
                });
                var blobUrl = URL.createObjectURL(blob);
                $('#documentIframe').attr('src', blobUrl);

                $('#documentModal').one('hidden.bs.modal', function() {
                    URL.revokeObjectURL(blobUrl);
                    $('#documentIframe').attr('src', '');
                });
            } catch (e) {
                alert("Could not load document preview.");
            }
        });

        // ══════════════════════════════════════════
        // FILE UPLOAD SYSTEM
        // ══════════════════════════════════════════
        var DOC_TYPES = [
            'verificationDocument',
            'appointmentLetterDocument',
            'contractDocument',
            'ndaDocument'
        ];

        var fileinputInitialized = {};

        function shortenFileName(n, max) {
            max = max || 28;
            var ext = n.split('.').pop();
            var base = n.substring(0, n.lastIndexOf('.'));
            return (base.length > max ? base.substring(0, max) + '...' : base) + '.' + ext;
        }

        function addFileToTable(docType, file) {
            var tb = $("#files-" + docType);
            if (tb.find("td[colspan]").length) tb.empty();

            // Store content in a hidden span to avoid huge inline onclick attributes
            tb.append(
                '<tr id="file-row-' + file.id + '">' +
                '<td title="' + file.name + '">' + shortenFileName(file.name) + '</td>' +
                '<td style="text-align:center;">' +
                '<a href="javascript:void(0);" class="btn-view-doc" data-content="' + encodeURIComponent(file.content) + '" data-name="' + encodeURIComponent(file.name) + '" style="margin-right:10px;" title="View"><i class="fas fa-eye"></i></a>' +
                '<a href="' + file.content + '" download="' + file.name + '" style="margin-right:10px;" title="Download"><i class="fas fa-download"></i></a>' +
                '<a href="javascript:void(0);" onclick="deleteFile(' + file.id + ',\'' + docType + '\')" style="color:red;" title="Delete"><i class="fas fa-trash"></i></a>' +
                '</td>' +
                '</tr>'
            );
        }

        function loadFiles(docType) {
            $.ajax({
                url: "{{ url('get-user-files') }}/" + userId + "/" + docType,
                type: "GET",
                dataType: "json",
                success: function(r) {
                    var tb = $("#files-" + docType);
                    tb.empty();
                    if (r.files && r.files.length) {
                        r.files.forEach(function(f) {
                            addFileToTable(docType, f);
                        });
                    } else {
                        tb.html("<tr><td colspan='2' class='text-muted' style='font-size:0.82rem;padding:10px 4px;'>No files uploaded yet.</td></tr>");
                    }
                }
            });
        }

        function initFileinput(docType) {
            if (fileinputInitialized[docType]) return;
            fileinputInitialized[docType] = true;

            $("#upload_" + docType).fileinput({
                theme: "fas",
                showUpload: false,
                showRemove: false,
                showCancel: false,
                dropZoneEnabled: true,
                dropZoneTitle: 'Drag & drop your file here or <span style="color:#3da087;font-weight:600;cursor:pointer;">CLICK HERE</span> to upload files',
                allowedFileExtensions: ["jpg", "png", "gif", "pdf", "docx", "jpeg"],
                maxFileSize: 10240,
                maxFilesNum: 5,
                browseOnZoneClick: true,
                showPreview: true,
                overwriteInitial: false,
                previewFileIcon: '<i class="fas fa-file"></i>',
            });

            // filebatchselected fires AFTER fileinput finishes its own preview render
            // so the preview stays visible while AJAX runs in background
            $("#upload_" + docType).on("filebatchselected", function(event, files) {
                var fd = new FormData();
                fd.append("user_id", userId);
                fd.append("doc_type", docType);
                for (var i = 0; i < files.length; i++) {
                    fd.append("files[]", files[i]);
                }
                $.ajax({
                    url: "{{ route('HR.employee_fileUpload') }}",
                    type: "POST",
                    data: fd,
                    processData: false,
                    contentType: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    beforeSend: function() {
                        $(".se-pre-con").fadeIn('fast');
                    },
                    success: function(r) {
                        $(".se-pre-con").fadeOut('fast');
                        r.files.forEach(function(f) {
                            addFileToTable(docType, f);
                        });
                        // Clear the preview area after successful upload WITHOUT destroying the widget
                        $("#upload_" + docType).fileinput('clear');
                    },
                    error: function() {
                        $(".se-pre-con").fadeOut('fast');
                        console.log(xhr.responseText); // Add this temporarily to see server error details in console
                        alert("Upload failed. Please try again.");
                    }
                });
            });
        }

        // Load all file lists on page load
        DOC_TYPES.forEach(function(dt) {
            loadFiles(dt);
        });

        // Init fileinput widget only when each tab becomes visible (avoids hidden DOM bugs)
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var tabDocTypeMap = {
                "#verification-docs": "verificationDocument",
                "#appointment-letter": "appointmentLetterDocument",
                "#contract": "contractDocument",
                "#nda": "ndaDocument"
            };
            var dt = tabDocTypeMap[$(e.target).attr("href")];
            if (dt) initFileinput(dt);
        });

    }); // end document.ready

    // ── View document in modal (converts base64 → blob URL for iframe) ──
    function openDocModal(fileId, encodedName) {
        var fileName = decodeURIComponent(encodedName);
        var userId = $("#user_id").val();

        $('#documentModalLabel').text(fileName);
        $('#documentIframe').attr('src', '');
        $('#documentModal').modal('show');

        // Fetch the file content fresh and build a blob URL
        $.ajax({
            url: "{{ url('get-user-files') }}/" + fileId,
            // get-user-files/{userId}/{docType}
            type: "GET",
            dataType: "json",
            success: function(r) {
                if (!r.content) return;
                // Convert base64 → Blob → Object URL (browsers allow blob: in iframes)
                var arr = r.content.split(',');
                var mime = arr[0].match(/:(.*?);/)[1];
                var bstr = atob(arr[1]);
                var n = bstr.length;
                var u8arr = new Uint8Array(n);
                while (n--) {
                    u8arr[n] = bstr.charCodeAt(n);
                }
                var blob = new Blob([u8arr], {
                    type: mime
                });
                var blobUrl = URL.createObjectURL(blob);
                $('#documentIframe').attr('src', blobUrl);

                // Revoke blob URL when modal closes to free memory
                $('#documentModal').one('hidden.bs.modal', function() {
                    URL.revokeObjectURL(blobUrl);
                    $('#documentIframe').attr('src', '');
                });
            },
            error: function() {
                alert("Could not load document preview.");
            }
        });
    }

    // ── Delete file ──
    function deleteFile(fileId, docType) {
        if (!confirm("Are you sure you want to delete this file?")) return;
        $.ajax({
            url: "{{ url('employee/delete-file') }}",
            type: "POST",
            data: {
                id: fileId,
                _token: $('meta[name="csrf-token"]').attr("content")
            },
            success: function(r) {
                if (r.success) {
                    $("#file-row-" + fileId).remove();
                } else {
                    alert("Failed to delete file.");
                }
            }
        });
    }

    function goBackOnePage() {
        // If there's a previous page in this tab's history, go back to it
        if (document.referrer && document.referrer.indexOf(window.location.host) !== -1) {
            window.history.back();
        } else {
            // No real previous page (e.g. opened in a new tab/direct link) — fall back to home
            window.location.href = "{{ route('home') }}";
        }
    }
</script>
@endcan
@endsection