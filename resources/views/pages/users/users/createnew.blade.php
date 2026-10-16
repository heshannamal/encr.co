@extends('layouts.app', ['activePage' => 'Employee_Managment', 'titlePage' => __('Employee Managment')])

@section('content')

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
        color: #9e9e9e;
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 10px 18px;
        margin-bottom: -2px;
        background: none;
    }

    .nav-tabs .nav-link.active {
        color: #111;
        border-bottom: 2px solid #111;
        background: none;
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

    /* ── Password toggle ── */
    .password-wrapper {
        position: relative;
    }

    .password-wrapper .field-input {
        padding-right: 36px;
    }

    .password-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #aaa;
        font-size: 0.8rem;
    }

    .password-toggle:hover {
        color: #555;
    }

    /* ── Footer Action Bar ── */
    .create-footer-bar {
        background: #fff;
        border: 1px solid #ebebeb;
        border-radius: 6px;
        padding: 14px 24px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-bottom: 40px;
    }

    .btn-create-cancel {
        background: #e8eaf0;
        color: #555;
        border: none;
        border-radius: 5px;
        padding: 9px 26px;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        cursor: pointer;
        transition: background 0.15s;
    }

    .btn-create-cancel:hover {
        background: #d0d3de;
    }

    .btn-create-save {
        background: #3da087;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 9px 30px;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        cursor: pointer;
        transition: background 0.15s;
    }

    .btn-create-save:hover {
        background: #2e8a70;
    }

    /* ── Password mismatch message ── */
    #confirm_password_message {
        font-size: 0.78rem;
        color: #dc3545;
        margin-top: 4px;
        display: none;
    }

    /* ═══════════════════════════════════════════
    MOBILE RESPONSIVE — matches Figma mobile view
    ═══════════════════════════════════════════ */
    @media (max-width: 767.98px) {

        /* Tighten page padding */
        .container-fluid.content-position {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        /* ── Profile header card: centered avatar + title above fields ── */
        .profile-header-card {
            padding: 20px 16px 90px 16px; /* extra bottom padding so sticky footer doesn't cover fields */
            position: relative;
        }

        .profile-header-card > .d-flex {
            flex-direction: column;
            align-items: center;
        }

        .dp-wrapper {
            margin: 0 auto 6px auto !important;
        }

        .user_dp {
            width: 90px;
            height: 90px;
        }

        .mobile-upload-hint {
            display: block;
            font-size: 0.78rem;
            color: #888;
            margin: 6px 0 14px 0;
            text-align: center;
        }

        /* Insert "Employee Information" title above the fields */
        .profile-header-card .flex-grow-1::before {
            content: "Employee Information";
            display: block;
            font-size: 1rem;
            font-weight: 700;
            color: #111;
            text-align: center;
            margin-bottom: 16px;
        }

        /* Keep field labels/inputs left-aligned inside the centered card */
        .profile-header-card .field-group {
            text-align: left;
        }

        /* All header fields stack full width */
        .profile-header-card .row > div[class^="col-"] {
            flex: 0 0 100% !important;
            max-width: 100% !important;
            margin-bottom: 4px;
        }

        /* Exception: Date + Current Time stay side by side (2 columns) like Figma */
        .profile-header-card .row > div[class^="col-"]:nth-last-child(2),
        .profile-header-card .row > div[class^="col-"]:last-child {
            flex: 0 0 48% !important;
            max-width: 48% !important;
            display: inline-block;
        }

        /* ── Sticky Cancel / Save bar, floats above content while scrolling ── */
        .create-footer-bar.mobile-inline-footer {
            position: sticky;
            bottom: 10px;
            margin: 14px auto 0 auto;
            max-width: 92%;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
            z-index: 20;
        }

        .btn-create-cancel,
        .btn-create-save {
            flex: 1;
            text-align: center;
        }

        /* ── Tabs become rounded pill buttons ── */
        .nav-tabs {
            border-bottom: none;
            flex-wrap: nowrap;
            overflow-x: auto;
            gap: 8px;
            padding-bottom: 4px;
        }

        .nav-tabs .nav-link {
            border: none;
            border-radius: 20px;
            background: #f3f4f6;
            color: #6b7280;
            padding: 8px 16px;
            white-space: nowrap;
            font-size: 0.72rem;
        }

        .nav-tabs .nav-link.active {
            background: #111;
            color: #fff;
            border-bottom: none;
        }

        /* ── Section cards: all fields inside become full width, stacked ── */
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

        /* Exception: Postal Code + Phone Number stay side by side */
        .section-card .row > div[class^="col-"]:has(input[name="postal_code"]),
        .section-card .row > div[class^="col-"]:has(input[name="phone_number"]) {
            flex: 0 0 48% !important;
            max-width: 48% !important;
            display: inline-block;
        }

        /* ── Card header: icon + title + chevron, built from the plain <h3> using ::before/::after (no HTML needed) ── */
        .section-card > h3 {
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
            padding-right: 24px; /* room for the chevron on the right */
            font-size: 0.9rem;
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

        /* Give each card its own icon, matched by its position in the page */
        .cards-equal-row:nth-of-type(1) > .col-6:nth-of-type(1) .section-card > h3::before {
            content: "\f007"; /* user icon → Personal Details */
        }
        .cards-equal-row:nth-of-type(1) > .col-6:nth-of-type(2) .section-card > h3::before {
            content: "\f3c5"; /* map pin icon → Contact Details */
        }
        .cards-equal-row:nth-of-type(2) > .col-6:nth-of-type(1) .section-card > h3::before {
            content: "\f0b1"; /* briefcase icon → Job Details */
        }
        .cards-equal-row:nth-of-type(2) > .col-6:nth-of-type(2) .section-card > h3::before {
            content: "\f023"; /* lock icon → Login Information */
        }

        /* ── Form fields: match Figma look, applied to BOTH the top header card and the 4 section cards ── */
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

    } /* ── end mobile media query ── */


    /* ── "Back to home" strip: visible by default (mobile), hidden on desktop ── */
    .back_home_mobile {
        padding-left: 5px;
        padding-bottom: 10px;
    }

    @media (min-width: 768px) {
        .back_home_mobile { display: none; }
        .mobile-upload-hint { display: none; }
    }

</style>

@if ($errors->any())
<div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')<span>Add New Employee</span>@endsection

    @section('back-btn')
    <a href="{{ route('home') }}" class="home-btn-color" title="Back">BACK</a>
    @endsection

    
    @section('back-btn-Mobile')
    <a href="{{ route('HR.Employee_Managment') }}" class="home-btn-color-mobile" title="Back to home">< BACK</a>
    @endsection

    <div class="back_home_mobile">
        <strong>
            @yield('back-btn-Mobile')
        </strong>
    </div>

    <form action="{{ route('HR.employee_store') }}" method="POST" enctype="multipart/form-data" id="createEmployeeForm">
        <!-- <form action="{{ route('users.create') }}" method="POST" enctype="multipart/form-data" id="createEmployeeForm"> -->
        @csrf

        {{-- ══════════════════════════════════════════
             PROFILE HEADER
        ══════════════════════════════════════════ --}}
        <div class="profile-header-card">
            <div class="d-flex align-items-start">

                {{-- Avatar --}}
                <div class="dp-wrapper mr-4 flex-shrink-0">
                    <img src="{{ asset('assets') }}/img/user/default.png" class="user_dp" id="emp_image_preview" />
                    <label class="dp-edit-icon" for="profile_pic_input" title="Upload photo">
                        <i class="fa fa-pen"></i>
                    </label>
                    <input type="file" id="profile_pic_input" name="profile_picture"
                        accept="image/*" style="display:none;" onchange="previewProfilePic(this)" />
                </div>

                {{-- Header Fields Grid --}}
                <div class="flex-grow-1">
                    <div class="row" style="row-gap: 12px;">
                        <div class="col-3">
                            <div class="field-group">
                                <label>First Name <span class="text-danger">*</span></label>
                                <input class="field-input" name="first_name" type="text"
                                    value="{{ old('first_name') }}" placeholder="First name" required />
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="field-group">
                                <label>Last Name</label>
                                <input class="field-input" name="last_name" type="text"
                                    value="{{ old('last_name') }}" placeholder="Last name" />
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="field-group">
                                <label>Employee Number</label>
                                <input class="field-input" name="employee_number" type="text"
                                    value="{{ old('employee_number') }}" placeholder="e.g. EMP001" disabled />
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="field-group">
                                <label>Job Title</label>
                                <input class="field-input" name="job_title" type="text"
                                    value="{{ old('job_title') }}" placeholder="e.g. Software Engineer" />
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="field-group">
                                <label>Official Phone Number</label>
                                <input class="field-input" name="official_phone" type="text"
                                    value="{{ old('official_phone') }}" placeholder="+94 77 000 0000" />
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="field-group">
                                <label>Official Email <span class="text-danger">*</span></label>
                                <input class="field-input" name="email" id="official_email" type="email"
                                    value="{{ old('email') }}" placeholder="email@company.com" required />
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="field-group">
                                <label>Time Zone</label>
                                <!-- <select class="header-select2" name="timezone">
                                    <option value="">Select</option>
                                    @foreach ($timezoneset as $item)
                                    <option value="{{ $item }}" {{ old('timezone') == $item ? 'selected' : '' }}>{{ $item }}</option>
                                    @endforeach
                                </select> -->
                                <select class="header-select2" name="timezone">
                                    <option value="">Select</option>
                                    @foreach ($timezoneset as $tzKey => $tzLabel)
                                    <option value="{{ $tzKey }}" {{ old('timezone') == $tzKey ? 'selected' : '' }}>{{ $tzLabel }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="field-group">
                                <label>Date</label>
                                <input class="field-input date-field" type="text"
                                    value="{{ now()->format('d/m/Y') }}" disabled />
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="field-group">
                                <label>Current Time</label>
                                <input class="field-input time-field" id="current_time_display" type="text"
                                    value="{{ now()->format('H:i:s') }}" disabled style="color: #3da087;" />
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
            {{-- <li>
                <a class="nav-link active" data-toggle="tab" href="#basic-info" role="tab">Basic Information</a>
            </li> --}}
            <!-- <li>
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
            </li> -->
        </ul>

        <div class="tab-content" id="employeeTabContent">

            {{-- ══════════════════════════════════════════
                 TAB 1 — BASIC INFORMATION
            ══════════════════════════════════════════ --}}
            <div class="tab-pane fade show active" id="basic-info" role="tabpanel">

                {{-- Row 1: Personal + Contact --}}
                <div class="row cards-equal-row">

                    {{-- Personal Details --}}
                    <div class="col-6">
                        <div class="section-card">
                            <h3>Personal Details</h3>
                            <div class="row" style="row-gap:14px;">
                                <div class="col-4">
                                    <div class="field-group">
                                        <label>Date of Birth</label>
                                        <input class="field-input date-field" name="dob" type="text"
                                            value="{{ old('dob') }}" placeholder="mm/dd/yyyy" />
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="field-group">
                                        <label>Marital Status</label>
                                        <select class="field-select2" name="marital_status">
                                            <option value="">Select</option>
                                            <option value="Single" {{ old('marital_status') == 'Single' ? 'selected' : '' }}>Single</option>
                                            <option value="Married" {{ old('marital_status') == 'Married' ? 'selected' : '' }}>Married</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="field-group">
                                        <label>Gender</label>
                                        <select class="field-select2" name="gender">
                                            <option value="">Select</option>
                                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="field-group">
                                        <label>Nationality</label>
                                        <select class="field-select2" name="nationality">
                                            <option value="">Select</option>
                                            @foreach ($nationalities as $nationality)
                                            <option value="{{ $nationality }}" {{ old('nationality') == $nationality ? 'selected' : '' }}>{{ $nationality }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="field-group">
                                        <label>Languages</label>
                                        <select class="field-select2-multi" name="languages[]" multiple>
                                            @foreach ($languages as $language)
                                            <option value="{{ $language }}" {{ in_array($language, old('languages', [])) ? 'selected' : '' }}>{{ $language }}</option>
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
                                        <input class="field-input" name="address" type="text"
                                            value="{{ old('address') }}" placeholder="Street address" />
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="field-group">
                                        <label>City</label>
                                        <input class="field-input" name="city" type="text"
                                            value="{{ old('city') }}" placeholder="City" />
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="field-group">
                                        <label>Country</label>
                                        <select class="field-select2" name="country">
                                            <option value="">Select</option>
                                            @foreach ($countries as $country)
                                            <option value="{{ $country['code'] }}" {{ old('country') == $country['code'] ? 'selected' : '' }}>
                                                {{ $country['name'] }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="field-group">
                                        <label>Postal Code</label>
                                        <input class="field-input" name="postal_code" type="text"
                                            value="{{ old('postal_code') }}" placeholder="00000" />
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="field-group">
                                        <label>Phone Number</label>
                                        <input class="field-input" name="phone_number" type="text"
                                            value="{{ old('phone_number') }}" placeholder="+94 77 000 0000" />
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="field-group">
                                        <label>Private Email</label>
                                        <input class="field-input" name="private_email" type="email"
                                            value="{{ old('private_email') }}" placeholder="personal@email.com" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Row 2: Job Details + Login Information --}}
                <div class="row cards-equal-row">

                    {{-- Job Details --}}
                    <div class="col-6">
                        <div class="section-card">
                            <h3>Job Details</h3>
                            <div class="row" style="row-gap:14px;">
                                <div class="col-4">
                                    <div class="field-group">
                                        <label>Employment Status</label>
                                        <select class="field-select2" name="employment_status">
                                            <option value="">Select</option>
                                            <option value="Full Time" {{ old('employment_status') == 'Full Time' ? 'selected' : '' }}>Full Time</option>
                                            <option value="Part Time" {{ old('employment_status') == 'Part Time' ? 'selected' : '' }}>Part Time</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="field-group">
                                        <label>Job Title</label>
                                        <input class="field-input" name="job_title_details" type="text"
                                            value="{{ old('job_title_details') }}" placeholder="e.g. Designer" />
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="field-group">
                                        <label>Leave Group</label>
                                        <select class="field-select2" name="leave_group_id">
                                            <option value="">Select</option>
                                            @foreach ($leaveGroups as $item)
                                            <option value="{{ $item['id'] }}" {{ old('leave_group_id') == $item['id'] ? 'selected' : '' }}>{{ $item['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="field-group">
                                        <label>Joined Date</label>
                                        <input class="field-input date-field" name="joined_date" type="text"
                                            value="{{ old('joined_date') }}" placeholder="mm/dd/yyyy" />
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="field-group">
                                        <label>Department</label>
                                        <select class="field-select2" name="department">
                                            <option value="">Select Department</option>
                                            @foreach ($departmentsNames as $dept)
                                            <option value="{{ $dept }}" >{{ $dept }}</option>
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
                            <div class="row" style="row-gap:14px;">
                                <div class="col-12">
                                    <div class="field-group">
                                        <label>Work Email (Login) <span class="text-danger">*</span></label>
                                        <input class="field-input" name="login_email" id="login_email" type="email"
                                            value="{{ old('login_email') }}" placeholder="Auto-filled from Official Email"
                                            required readonly style="background:#f5f5f5; color:#888; cursor:not-allowed;" />
                                        <small class="text-muted" style="font-size:0.72rem;">
                                            Auto-filled from Official Email. Cannot be edited manually.
                                        </small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="field-group">
                                        <label>Password <span class="text-danger">*</span></label>
                                        <div class="password-wrapper">
                                            <input class="field-input" type="password" id="new_password"
                                                name="password" placeholder="••••••••" required />
                                            <span class="password-toggle" id="togglePassword">
                                                <i class="fas fa-eye-slash"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="field-group">
                                        <label>Confirm Password <span class="text-danger">*</span></label>
                                        <div class="password-wrapper">
                                            <input class="field-input" type="password" id="confirm_password"
                                                name="password_confirmation" placeholder="••••••••" required />
                                            <span class="password-toggle" id="toggleConfirmPassword">
                                                <i class="fas fa-eye-slash"></i>
                                            </span>
                                        </div>
                                        <span id="confirm_password_message">Passwords do not match.</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="field-group">
                                        <label>User Group</label>
                                        <select class="field-select2-multi" name="user_roles[]" multiple required>
                                            @foreach ($userRoles as $userRole)
                                            <option value="{{ $userRole->id }}" {{ in_array($userRole->id, old('user_roles', [])) ? 'selected' : '' }}>{{ $userRole->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>{{-- /basic-info --}}

            {{-- ══════════════════════════════════════════
                 TAB 2 — VERIFICATION DOCUMENTS
            ══════════════════════════════════════════ --}}
            <div class="tab-pane fade" id="verification-docs" role="tabpanel">
                <div class="section-card text-center py-5" style="height:auto;">
                    <i class="fas fa-file-shield fa-5x text-muted mb-4" style="opacity:0.35;"></i>
                    <h3>No Verification Documents</h3>
                    <p class="text-muted mx-auto" style="max-width:480px;">
                        Verification documents can be uploaded after the employee profile has been saved.
                    </p>
                    <small class="text-muted">Save the profile first, then manage VERIFICATION DOCUMENTS from the employee edit page.</small>
                </div>
            </div>

            {{-- ══════════════════════════════════════════
                 TAB 3 — APPOINTMENT LETTER
            ══════════════════════════════════════════ --}}
            <div class="tab-pane fade" id="appointment-letter" role="tabpanel">
                <div class="section-card text-center py-5" style="height:auto;">
                    <i class="fas fa-file-signature fa-5x text-muted mb-4" style="opacity:0.35;"></i>
                    <h3>No Appointment Letter Yet</h3>
                    <p class="text-muted mx-auto" style="max-width:480px;">
                        Appointment letter can be generated and uploaded after saving the employee profile.
                    </p>
                    <small class="text-muted">Save the profile first, then manage APPOINTMENT LETTER documents from the employee edit page.</small>
                </div>
            </div>

            {{-- ══════════════════════════════════════════
                 TAB 4 — CONTRACT
            ══════════════════════════════════════════ --}}
            <div class="tab-pane fade" id="contract" role="tabpanel">
                <div class="section-card text-center py-5" style="height:auto;">
                    <i class="fas fa-file-contract fa-5x text-muted mb-4" style="opacity:0.35;"></i>
                    <h3>No Contract Uploaded</h3>
                    <p class="text-muted mx-auto" style="max-width:480px;">
                        The employment contract can be attached after saving the employee profile.
                    </p>
                    <small class="text-muted">Save the profile first, then manage CONTRACT documents from the employee edit page.</small>
                </div>
            </div>

            {{-- ══════════════════════════════════════════
                TAB 5 — NDA
            ══════════════════════════════════════════ --}}
            <div class="tab-pane fade" id="nda" role="tabpanel">
                <div class="section-card text-center py-5" style="height:auto;">
                    <i class="fas fa-file-shield fa-5x text-muted mb-4" style="opacity:0.35;"></i>
                    <h3>No NDA Uploaded</h3>
                    <p class="text-muted mx-auto" style="max-width:480px;">
                        The Non-Disclosure Agreement (NDA) can be generated or uploaded after saving the employee profile.
                    </p>
                    <small class="text-muted">
                        Save the profile first, then manage NDA documents from the employee edit page.
                    </small>
                </div>
            </div>

        </div>{{-- /tab-content --}}

        {{-- ══════════════════════════════════════════
             FOOTER ACTION BAR
        ══════════════════════════════════════════ --}}
        <div class="create-footer-bar">
            <a href="{{ route('home') }}" class="btn-create-cancel">Cancel</a>
            <button type="submit" class="btn-create-save" id="emp_save_btn">Save</button>
        </div>

    </form>
</div>

<script>
    $(document).ready(function() {

        // ── Auto-fill Work Email from Official Email ──
        function syncLoginEmail() {
            var officialEmail = $("#official_email").val().trim();
            $("#login_email").val(officialEmail);
        }

        // Sync on every keystroke
        $("#official_email").on("keyup input change", syncLoginEmail);

        // Sync on page load for old() repopulation (e.g. after validation fail)
        syncLoginEmail();

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

        // ── Datepickers ──
        $("input[name='dob'], input[name='joined_date']").datepicker({
            dateFormat: "mm/dd/yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "1950:2035",
            maxDate: "0"
        });

        // ── Live clock ──
        setInterval(function() {
            var now = new Date();
            var timeStr = now.toLocaleTimeString('en-GB', {
                hour12: false
            });
            $("#current_time_display").val(timeStr);
        }, 1000);

        // ── Password match validation ──
        function checkPasswordMatch() {
            var pw = $("#new_password").val();
            var cpw = $("#confirm_password").val();
            if (cpw === '') {
                $("#confirm_password_message").hide();
                $("#emp_save_btn").prop('disabled', false);
                return;
            }
            if (pw !== cpw) {
                $("#confirm_password_message").show();
                $("#emp_save_btn").prop('disabled', true);
            } else {
                $("#confirm_password_message").hide();
                $("#emp_save_btn").prop('disabled', false);
            }
        }
        $("#new_password, #confirm_password").on("keyup input", checkPasswordMatch);

        // ── Password visibility toggles ──
        $('#togglePassword').on('click', function() {
            var input = document.getElementById('new_password');
            input.type = input.type === 'password' ? 'text' : 'password';
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        });
        $('#toggleConfirmPassword').on('click', function() {
            var input = document.getElementById('confirm_password');
            input.type = input.type === 'password' ? 'text' : 'password';
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        });

        // ── Form submit guard ──
        $('#createEmployeeForm').on('submit', function(e) {
            var pw = $("#new_password").val();
            var cpw = $("#confirm_password").val();
            var loginEmail = $("#login_email").val().trim();

            if (pw !== cpw) {
                e.preventDefault();
                $("#confirm_password_message").show();
                $("#confirm_password").focus();
                return false;
            }

            // Guard: Work Email must not be empty
            if (!loginEmail) {
                e.preventDefault();
                $("#official_email").focus();
                alert("Please enter the Official Email — it is required for login.");
                return false;
            }

            $(".se-pre-con").fadeIn('fast');
        });

    });

    // ── Profile picture preview ──
    function previewProfilePic(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#emp_image_preview').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection