@extends('layouts.app', ['activePage' => 'profile.edit', 'titlePage' => __('User Profile')])

@section('content')

<style>
    .custom-btn-style {
        font-size: .675rem !important;
        font-weight: 400 !important;
        padding: .325rem 0.5rem !important;
        border-radius: 1px !important;
    }

    .background-image {
        height: 250px;
        border-bottom-left-radius: 20px;
        border-top-right-radius: 20px;
        background-image: url("{{ asset('argon') }}/img/encore/bg-img.jpg");
        background-size: cover;
        background-position: center;
    }

    .profile-image {
        width: 250px;
        height: 250px;
        background-color: rgb(255, 255, 255);
        border-radius: 100%;
        position: relative;
        top: 100px;
        left: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .img-user {
        width: 240px;
        height: 240px;
        border-radius: 100%;
    }

    .border-r-s {
        border-bottom: solid black 1px;
    }

    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        display: none;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }

    .editbtn_row {
        justify-content: space-between;
        align-items: center;
    }

    .user_dp {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        padding-top: auto;
    }

    .empDetailsTabletd {
        padding: 10px;
        display: inline-flex;
        align-items: baseline;
        width: 33.33%;
    }

    .empDetailsTable {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        /* Ensures equal column widths */
    }

    p {
        font-size: 0.9rem !important;
    }

    .nav-tabs .nav-link.active,
    .nav-tabs .nav-item.show .nav-link {
        color: #000102;
        font-weight: 400;
        border-color: transparent;
        background-color: unset;
        border-bottom-color: #000102;
    }

    .nav-tabs {
        border-bottom: unset;
    }

    .wi-40 {
        width: 40%;
    }

    .wi-60 {
        width: 60%;
    }

    .select2.select2-container {
        width: 100% !important;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        border: 1px solid #c8c8c8 !important;
    }

    .iti {
        display: block !important;
    }

    .card {
        display: block !important;
    }

    /* ── Document thumbnail grid (same as HR view) ── */
    .doc-thumb-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        padding: 4px 0;
    }

    .doc-thumb-card {
        width: 160px;
        border: 1px solid #e8e8e8;
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 1px 4px rgba(0, 0, 0, .07);
        transition: transform .15s, box-shadow .15s;
    }

    .doc-thumb-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, .12);
    }

    .doc-thumb-preview {
        width: 100%;
        height: 110px;
        background: #f4f6f8;
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 1px solid #eee;
        overflow: hidden;
    }

    .doc-thumb-body {
        padding: 8px 10px;
    }

    .doc-thumb-name {
        font-size: .75rem;
        color: #333;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 6px;
    }

    .doc-thumb-actions {
        display: flex;
        gap: 10px;
    }

    .doc-thumb-actions a {
        font-size: .8rem;
        color: #666;
        text-decoration: none;
    }

    .doc-thumb-actions a:hover {
        color: #3da087;
    }

    .file-type-icon {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
    }

    .file-type-icon .icon-shape {
        width: 54px;
        height: 62px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .72rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: .04em;
        position: relative;
    }

    .file-type-icon .icon-shape::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 14px;
        height: 14px;
        background: rgba(255, 255, 255, .25);
        clip-path: polygon(0 0, 100% 100%, 100% 0);
        border-radius: 0 6px 0 0;
    }

    .icon-image {
        background: #e74c3c;
    }

    .icon-pdf {
        background: #e74c3c;
    }

    .icon-doc {
        background: #2980b9;
    }

    .icon-generic {
        background: #7f8c8d;
    }

    .LeaveManage-mobile { display: none; }

    /* ============ MOBILE VIEW ============ */
    @media (max-width: 767.98px) {

        /* ---- Profile header card ---- */
        .background-image { display: none; }

        .editbtn_row {
            flex-direction: column;
            justify-content: center !important;
            text-align: center;
        }
        .editbtn_row h1 {
            width: 100%;
            text-align: center;
            font-size: 1.15rem;
            margin-bottom: 6px;
        }
        .editbtn_row .LeaveManage {
            display: none !important;
        }

        .LeaveManage-mobile {
            display: inline-flex !important;
            justify-content: center !important;
            align-items: center;
            margin: 10px auto 0 auto !important;
            background: #f2f2f2;
            border-radius: 16px;
            padding: 5px 14px;
            width: fit-content;
        }
        .LeaveManage-mobile i { font-size: .75rem !important; }
        .LeaveManage-mobile h4 { font-size: .75rem !important; }

        .card {
            height: auto !important;
            min-height: 0 !important;
            overflow: visible !important;
        }
        .card .row[style*="padding: 15px"] {
            display: block !important;
            text-align: center;
            padding: 18px 15px 16px !important;
        }
        .card .col-2.d-flex.align-items-center {
            display: block !important;
            width: 100% !important;
            max-width: 100% !important;
            float: none !important;
            text-align: center;
            padding: 0 !important;
            margin-bottom: 8px;
        }
        .card .col {
            display: block !important;
            width: 100% !important;
            max-width: 100% !important;
            float: none !important;
            padding: 0;
        }

        /* Avatar + camera badge */
        .dp-wrapper {
            position: relative;
            width: 90px;
            height: 90px;
            margin: 0 auto;
        }
        .dp-wrapper .user_dp {
            width: 90px;
            height: 90px;
            display: block;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,.12);
        }
        .dp-edit-icon {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #3da087;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .8rem;
            border: 2px solid #fff;
            cursor: pointer;
        }

        .empDetailsTable {
            display: block !important;
            width: 100% !important;
            table-layout: auto !important;
        }
        .empDetailsTable tbody { display: block !important; width: 100%; }
        .empDetailsTable tr:not(:nth-of-type(1)) { display: none !important; }
        .empDetailsTable tr:nth-of-type(1) { display: block !important; width: 100% !important; }
        .empDetailsTable tr:nth-of-type(1) td {
            display: block !important;
            width: 100% !important;
            text-align: center;
            padding: 6px 0 0 !important;
        }
        .empDetailsTable tr:nth-of-type(1) h1 {
            font-size: 1.05rem;
            white-space: nowrap;
            margin-bottom: 2px;
        }
        .profile-subtitle {
            font-size: .8rem !important;
            color: #8a8a8a !important;
            font-style: italic;
            margin: 0 !important;
        }

        .col-12.mb-3 > .card {
            margin-bottom: 20px;
            border-radius: 16px;
            box-shadow: 0 1px 8px rgba(0,0,0,.06);
        }

        /* ---- Pill-style scrollable TAB BAR (the only scrollbar on this page besides the page itself) ---- */
        #profileTab.nav-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-bottom: none;
            padding: 4px 0 10px 0;
            margin-top: 0 !important;
            margin-bottom: 10px !important;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        #profileTab.nav-tabs::-webkit-scrollbar { display: none; }
        #profileTab .nav-item { flex: 0 0 auto; }
        #profileTab .nav-link {
            white-space: nowrap;
            border: 1px solid #e0e0e0 !important;
            border-radius: 10px !important;
            padding: 6px 16px !important;
            margin-right: 8px;
            font-size: .85rem;
            color: #444;
        }
        #profileTab .nav-link.active {
            background-color: #1a1a1a !important;
            color: #fff !important;
            border-color: #1a1a1a !important;
        }
        #profileTab .nav-link p { margin: 0; }

        /* ---- Basic Information: normal stacked cards ---- */
        #basic-info .row > .col-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
        #basic-info .row.px-3.pb-2 > .col-6,
        #basic-info .row.px-3.pb-2 > .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
            margin-bottom: 14px;
        }
        div:has(> #employee_postalcode),
        div:has(> .iti #employee_phoneNumber) {
            flex: 0 0 48% !important;
            max-width: 48% !important;
            margin-bottom: 14px;
        }

        #basic-info .card {
            padding: 18px !important;
            border-radius: 16px !important;
            box-shadow: 0 1px 8px rgba(0,0,0,.06) !important;
        }
        #basic-info h3 {
            font-size: .95rem;
            margin-bottom: 14px;
        }
        #basic-info .form-label {
            font-size: .8rem;
            margin-bottom: 5px;
            color: #555;
            font-weight: 600;
        }

        /* Plain text/date inputs — safe to restyle directly */
        #basic-info input.form-control {
            font-size: .9rem !important;
            border: 1px solid #e0e0e0 !important;
            border-radius: 10px !important;
            padding: 10px 12px !important;
            height: auto !important;
            background: #fafafa;
        }

        /* select2 dropdowns (Marital Status, Gender, Nationality, Languages, Country, Timezone, etc.)
        — these must be sized as a FIXED height matching the box, text line-height, and arrow height
        together, or the arrow and text go crooked. This is the correct way to restyle select2. */
        #basic-info .select2-container .select2-selection--single {
            border: 1px solid #e0e0e0 !important;
            border-radius: 10px !important;
            background: #fafafa !important;
            height: 42px !important;
        }
        #basic-info .select2-container .select2-selection--single .select2-selection__rendered {
            line-height: 42px !important;
            padding-left: 12px !important;
            font-size: .9rem !important;
            color: #333 !important;
        }
        #basic-info .select2-container .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
            right: 8px !important;
        }
        #basic-info .select2-container--default.select2-container--disabled .select2-selection--single {
            background: #f0f0f0 !important;
        }
        /* multi-select (Languages) uses a different internal layout */
        #basic-info .select2-container--default .select2-selection--multiple {
            border: 1px solid #e0e0e0 !important;
            border-radius: 10px !important;
            background: #fafafa !important;
            min-height: 42px !important;
            padding: 4px 6px !important;
        }

        #basic-info .col-6.d-flex.align-items-end,
        #basic-info .col-md-6.d-flex.align-items-center {
            flex: 0 0 100% !important;
            max-width: 100% !important;
            justify-content: center !important;
            margin-top: 6px;
        }
        #basic-info .profile_group_view,
        #basic-info button[type="submit"] {
            width: 100%;
            border-radius: 999px !important;
            padding: 10px !important;
            font-weight: 600;
        }

        /* ---- Document tabs (view-only) ---- */
        .doc-thumb-grid { justify-content: center; }
        .doc-thumb-card { width: 45%; min-width: 130px; }
        .tab-pane .card h2 { font-size: 1rem; }

        .back_home_mobile {
            padding-left: 20px;
            padding-bottom: 10px;
        }

        #basic-info .select2-container .select2-selection--single .select2-selection__rendered {
            border: none !important;
        }

        #basic-info .iti input.form-control {
            padding-left: 56px !important;
        }
        
    }
        

    @media (min-width: 768px) {
        p.profile-subtitle {
            display: none;
        }

        .back_home_mobile {
            display: none;
        }
        .LeaveManage-mobile {
            display: none !important;
        }
       
    }
</style>

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
    <span>User Profile</span>
    @endsection

    @section('back-btn')
    <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    @section('back-btn-Mobile')
    <a href="{{ route('home') }}" class="home-btn-color-mobile" title="Back to home">< BACK TO HOME</a>
    @endsection

    <div class="back_home_mobile">
        <strong>
            @yield('back-btn-Mobile')
        </strong>
    </div>


    <input type="hidden" id="user_id" value="{{$userInfo->id }}">
    <div class="col-md-12">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="row editbtn_row">
                    <h1>Edit Profile</h1>
                    <span class="d-flex align-items-center LeaveManage" style="color:#a7a7a7">
                        <i class=" fa fa-pen-to-square fa-lg" style="cursor: pointer;"></i>
                        <h4 class="mx-2 " style="margin-bottom: unset;color:#a7a7a7;cursor: pointer;">Leave Manage</h4>
                    </span>
                </div>
                <div class="card">
                    <div class="row" style="padding: 15px">
                        <div class="col-2 d-flex align-items-center">
                            <div class="dp-wrapper">
                                @if ($userInfo->profile_pic == null || $userInfo->profile_pic == '')
                                <img src="{{ asset('assets') }}/img/user/default.png" class="user_dp profile_pic_change_class" />
                                @else
                                <img src="{{ asset($userInfo->profile_pic) }}" class="user_dp profile_pic_change_class" />
                                @endif
                                <span class="dp-edit-icon" onclick="document.getElementById('profile-picture-input').click()">
                                    <i class="fa fa-camera"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col">
                            <table class="empDetailsTable">
                                <tr>
                                    <td class="empDetailsTabletd" colspan="3">
                                        <h1>{{$userInfo->name}}</h1>
                                        @if(!empty($userInfo->userDetails->job_title))
                                        <p class="profile-subtitle">{{$userInfo->userDetails->job_title}}</p>
                                        @endif
                                        <span class="d-flex align-items-center LeaveManage LeaveManage-mobile" style="color:#a7a7a7">
                                            <i class=" fa fa-pen-to-square fa-lg" style="cursor: pointer;"></i>
                                            <h4 class="mx-2 " style="margin-bottom: unset;color:#a7a7a7;cursor: pointer;">Leave Manage</h4>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="empDetailsTabletd"> <i class=" fa fa-phone-volume fa-lg mx-2" style="cursor: pointer;color:#a7a7a7"></i>
                                        <p class="ml-2">{{$userInfo->userDetails->m_number ?? '000 0000000'}}</p>
                                    </td>
                                    <td class="empDetailsTabletd"><i class=" fa fa-user-shield fa-lg mx-2" style="cursor: pointer; color:#a7a7a7"></i>
                                        <h3>Employee # : </h3>
                                        <p class="ml-2">{{ 'EMP' . str_pad($userInfo->id, 3, '0', STR_PAD_LEFT) }}</p>
                                    </td>
                                    <td class="empDetailsTabletd"><i class=" fa-regular fa-compass fa-lg mx-2" style="cursor: pointer;color:#a7a7a7"></i>
                                        <h3>Time Zone : </h3>
                                        <p class="ml-2">{{$userInfo->userDetails->timezone ?? 'not set'}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="empDetailsTabletd"> <i class=" fa-regular fa-envelope fa-lg mx-2" style="cursor: pointer;color:#a7a7a7"></i>
                                        <p class="ml-2">{{$userInfo->email}}</p>
                                    </td>
                                    <td class="empDetailsTabletd"><i class=" fa fa-crosshairs fa-lg mx-2" style="cursor: pointer; color:#a7a7a7"></i>
                                        <h3>Job Title : </h3>
                                        <p class="ml-2">{{$userInfo->userDetails->job_title ?? 'not set'}}</p>
                                    </td>
                                    <td class="empDetailsTabletd"><i class=" fa-regular fa-clock fa-lg mx-2" style="cursor: pointer;color:#a7a7a7"></i>
                                        <h3>Time Now : </h3>
                                        <p class="ml-2">{{ now()->setTimezone($userInfo->userDetails->timezone ?? 'Not Set')->format('m/d/Y  H:i') }}</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Tab Navigation ── --}}
            <div class="col-12">
                <ul class="nav nav-tabs my-2" id="profileTab" role="tablist">
                    <li class=""><a class="nav-link active" data-toggle="tab" href="#basic-info" role="tab">
                            <p>Basic Information</p>
                        </a></li>
                    <li class=""><a class="nav-link" data-toggle="tab" href="#verification-docs" role="tab">
                            <p>Verification Documents</p>
                        </a></li>
                    <li class=""><a class="nav-link" data-toggle="tab" href="#appointment-letter" role="tab">
                            <p>Appointment Letter</p>
                        </a></li>
                    <li class=""><a class="nav-link" data-toggle="tab" href="#contract" role="tab">
                            <p>Contract</p>
                        </a></li>
                    <li class=""><a class="nav-link" data-toggle="tab" href="#nda" role="tab">
                            <p>NDA</p>
                        </a></li>
                </ul>
            </div>

            <div class="col-12 tab-content mt-2" id="profileTabContent">

                {{-- ════════════════════════════════════════
                     TAB 1  Basic Information
                ════════════════════════════════════════ --}}
                <div class="tab-pane fade show active" id="basic-info" role="tabpanel">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="card p-3 h-100">
                                <div class="col-12">
                                    <h3>Personal Details</h3>
                                </div>
                                <div class="row px-3 pb-2">
                                    <div class="col-md-12">
                                        <label for="employee_name" class="form-label">Employee Name</label>
                                        <input
                                            class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                            name="employee_name"
                                            id="employee_name" type='text'
                                            value="{{ $userInfo->name }}"
                                            data-AlradySaved="{{ $userInfo->name }}" required />
                                    </div>
                                </div>
                                <div class="row px-3 pb-2">
                                    <div class="col-6">
                                        <label for="employee_number" class="form-label">Employee Number</label>
                                        <input
                                            class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                            name="employee_number"
                                            id="employee_number" type='text'
                                            value="{{ 'EMP' . str_pad($userInfo->id, 3, '0', STR_PAD_LEFT) }}"
                                            data-AlradySaved="{{ $userInfo->id }}" disabled />
                                    </div>
                                    <div class="col-6">
                                        <label for="employee_dob" class="form-label">Date of Birth</label>
                                        <input
                                            class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                            name="employee_dob"
                                            id="employee_dob" type='text'
                                            value="{{$userInfo->userDetails->dob}}"
                                            data-AlradySaved="{{$userInfo->userDetails->dob}}" required />
                                    </div>
                                </div>
                                <div class="row px-3 pb-2">
                                    <div class="col-6">
                                        <label for="marital_status" class="form-label">Marital Status</label>
                                        <select class=" select2 form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                            name="marital_status"
                                            id="marital_status"
                                            data-AlradySaved="{{$userInfo->userDetails->Marital_Status}}" required>
                                            <option value="">Select Marital Status</option>
                                            <option value="Single" @if ($userInfo->userDetails->Marital_Status == 'Single') selected @endif>
                                                Single
                                            </option>
                                            <option value="Married" @if ($userInfo->userDetails->Marital_Status == 'Married') selected @endif>
                                                Married
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="employee_Gender" class="form-label">Gender</label>
                                        <select class=" select2 form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                            name="employee_Gender"
                                            id="employee_Gender"
                                            data-AlradySaved="{{$userInfo->userDetails->Gender}}" required>
                                            <option value="">Select Gender</option>
                                            <option value="Male" @if ($userInfo->userDetails->Gender == 'Male') selected @endif>
                                                Male
                                            </option>
                                            <option value="Female" @if ($userInfo->userDetails->Gender == 'Female') selected @endif>
                                                Female
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row px-3 pb-2">
                                    <div class="col-6">
                                        <label for="employee_Nationality" class="form-label">Nationality</label>
                                        <select class=" select2 form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                            name="employee_Nationality"
                                            id="employee_Nationality"
                                            data-AlradySaved="{{$userInfo->userDetails->Nationality}}" required>
                                            <option value="">Select Nationality</option>
                                            @foreach ($nationalities as $nationality)
                                            <option value="{{ $nationality }}"
                                                @if ($userInfo->userDetails->Nationality == $nationality) selected @endif>
                                                {{ $nationality }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="employee_Languages" class="form-label">Languages</label>
                                        <select
                                            class="select2 form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                            name="employee_Languages[]"
                                            id="employee_Languages"
                                            multiple="multiple" required>
                                            <option value="">Select Languages</option>
                                            @foreach ($languages as $language)
                                            <option value="{{ $language }}"
                                                @if (in_array($language, $savedLanguages)) selected @endif>
                                                {{ $language }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row px-3 pb-2">
                                    <div class="col-12">
                                        <label for="employee_number" class="form-label">Change Profile Picture</label>
                                        <input class="form-control" type="file" id="profile-picture-input" onchange="updateProfilePicture(event)">
                                        <div class="invalid-feedback" id="profilevalidation">
                                            Please select a valid image file (JPEG, PNG, GIF, JPG).
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="card p-3 h-100">
                                <div class="col-12">
                                    <h3>Contact Details</h3>
                                </div>
                                <div class="row px-3 pb-2">
                                    <div class="col-6">
                                        <label for="employee_address" class="form-label">Home Address</label>
                                        <input
                                            class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                            name="employee_address"
                                            id="employee_address" type='text'
                                            value="{{ $userInfo->userDetails->address}}"
                                            data-AlradySaved="{{ $userInfo->userDetails->address }}" required />
                                    </div>
                                    <div class="col-6">
                                        <label for="employee_country" class="form-label">Country</label>
                                        <select class=" select2 form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                            name="employee_country"
                                            id="employee_country"
                                            data-AlradySaved="{{$userInfo->userDetails->country}}" required>
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                            <option value="{{ $country['code'] }}"
                                                @if ($userInfo->userDetails->country == $country['code']) selected @endif>
                                                {{ $country['name'] }} (+{{ $country['code'] }})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row px-3 pb-2">
                                    <div class="col-6">
                                        <label for="employee_postalcode" class="form-label">Postal code</label>
                                        <input
                                            class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                            name="employee_postalcode"
                                            id="employee_postalcode" type='text'
                                            value="{{$userInfo->userDetails->postal_code}}"
                                            data-AlradySaved="{{ $userInfo->userDetails->postal_code }}" required />
                                    </div>
                                    <div class="col-6">
                                        <label for="employee_phoneNumber" class="form-label">Phone Number</label>
                                        <input
                                            class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                            name="employee_phoneNumber"
                                            id="employee_phoneNumber" type='text'
                                            value="{{$userInfo->userDetails->m_number}}"
                                            data-AlradySaved="{{$userInfo->userDetails->m_number}}" required />
                                    </div>
                                </div>
                                <div class="row px-3 pb-2">
                                    <div class="col-6">
                                        <label for="employee_workemail" class="form-label">Work Email</label>
                                        <input
                                            class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                            name="employee_workemail"
                                            id="employee_workemail" type='email'
                                            value="{{ $userInfo->email }}"
                                            data-AlradySaved="{{ $userInfo->email }}" disabled />
                                    </div>
                                    <div class="col-6">
                                        <label for="employee_privateemail" class="form-label">Private Email</label>
                                        <input
                                            class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                            name="employee_privateemail"
                                            id="employee_privateemail" type='email'
                                            value="{{$userInfo->userDetails->Private_Email}}"
                                            data-AlradySaved="{{$userInfo->userDetails->Private_Email}}" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="card p-3 h-100">
                                <div class="col-12">
                                    <h3>Job Details</h3>
                                </div>
                                <div class="row px-3 pb-2">
                                    <div class="col-6">
                                        <label for="employee_Employment_Status" class="form-label">Employee Status</label>
                                        <select class=" select2 form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                            name="employee_Employment_Status"
                                            id="employee_Employment_Status"
                                            data-AlradySaved="{{$userInfo->userDetails->Employment_Status}}" required disabled>
                                            <option value="">Select Employment Status</option>
                                            <option value="Full Time" @if ($userInfo->userDetails->Employment_Status == 'Full Time') selected @endif>
                                                Full Time
                                            </option>
                                            <option value="Part Time" @if ($userInfo->userDetails->Employment_Status == 'Part Time') selected @endif>
                                                Part Time
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="employee_jobtitle" class="form-label">Job Title</label>
                                        <input
                                            class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                            name="employee_jobtitle"
                                            id="employee_jobtitle" type='text'
                                            value="{{$userInfo->userDetails->job_title}}"
                                            data-AlradySaved="{{$userInfo->userDetails->job_title}}" required disabled />
                                    </div>
                                </div>
                                <div class="row px-3 pb-2">
                                    <div class="col-6">
                                        <label for="employee_joineddate" class="form-label">Joined Date</label>
                                        <input
                                            class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                            name="employee_joineddate"
                                            id="employee_joineddate" type='text'
                                            value="{{ $userInfo->userDetails->joined_date }}"
                                            data-AlradySaved="{{ $userInfo->userDetails->joined_date }}" required disabled />
                                    </div>
                                    <div class="col-6">
                                        <label for="employee_timezone" class="form-label">Time Zone</label>
                                        <select class="select2 form-control"
                                            style="border: 1px solid #DEDEDE;border-radius:0rem"
                                            name="employee_timezone"
                                            id="employee_timezone"
                                            data-AlradySaved="{{$userInfo->userDetails->timezone}}"
                                            disabled>

                                            @foreach ($timezoneset as $item)
                                            <option value="{{$item}}" @if($userInfo->userDetails->timezone == $item) selected @endif>
                                                {{$item}}
                                            </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="row px-3 pb-2">
                                    <div class="col-6">
                                        <label for="employee_Department" class="form-label">Department</label>
                                        <input
                                            class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                            name="employee_Department"
                                            id="employee_Department" type='text'
                                            value="{{ $userInfo->userDetails->Department }}"
                                            data-AlradySaved="{{ $userInfo->userDetails->Department }}" required disabled />
                                    </div>
                                    <div class="col-6 d-flex align-items-end">
                                        {{-- <div class="col-md-6 d-flex align-items-center"> --}}
                                        {{-- <button type="submit" class="btn btn-primary">Change Password</button> --}}
                                        <button type="button" class="btn btn-success custom-btn-style profile_group_view">View User Groups</button>
                                        {{-- </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="card p-3 h-100">
                                <div class="col-12">
                                    <h3>Login Informations</h3>
                                </div>
                                <form action="{{ route('password.change') }}" method="POST">
                                    @csrf
                                    <div class="row px-3 pb-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="old-password" class="form-control-label">Old password</label>
                                                <input class="form-control @error('old_password') is-invalid @enderror" type="password" id="old-password" name="old_password" placeholder="Enter old password">
                                                @error('old_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="new-password" class="form-control-label">New password</label>
                                                <input class="form-control @error('new_password') is-invalid @enderror" type="password" id="new-password" name="new_password" placeholder="Enter new password">
                                                @error('new_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="confirm-password" class="form-control-label">Confirm password</label>
                                                <input class="form-control @error('new_password_confirmation') is-invalid @enderror" type="password" id="confirm-password" name="new_password_confirmation" placeholder="Confirm new password">
                                                @error('new_password_confirmation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-flex align-items-center">
                                            {{-- <button type="submit" class="btn btn-primary">Change Password</button> --}}
                                            <button type="submit" class="btn btn-success custom-btn-style">change password</button>
                                        </div>
                                    </div>

                                    <!-- Success message -->
                                    @if (session('status'))
                                    <div class="alert alert-success mt-3">
                                        {{ session('status') }}
                                    </div>
                                    @endif

                                    <!-- General error message -->
                                    @if ($errors->any())
                                    <div class="alert alert-danger mt-3">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>{{-- /#basic-info --}}

                {{-- ════════════════════════════════════════
                     TAB 2  Verification Documents  (view-only)
                ════════════════════════════════════════ --}}
                <div class="tab-pane fade" id="verification-docs" role="tabpanel">
                    <div class="card p-3 my-2">
                        <div class="d-flex align-items-baseline mb-3">
                            <i class="fas fa-folder-open fa-2x" style="color:#3da087;margin-right:10px"></i>
                            <h2>Verification Documents</h2>
                        </div>
                        <div id="container_verificationDocument">
                            <div class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x text-muted"></i></div>
                        </div>
                    </div>
                </div>

                {{-- ════════════════════════════════════════
                     TAB 3  Appointment Letter  (view-only)
                ════════════════════════════════════════ --}}
                <div class="tab-pane fade" id="appointment-letter" role="tabpanel">
                    <div class="card p-3 my-2">
                        <div class="d-flex align-items-baseline mb-3">
                            <i class="fas fa-file-signature fa-2x" style="color:#3da087;margin-right:10px"></i>
                            <h2>Appointment Letter</h2>
                        </div>
                        <div id="container_appointmentLetterDocument">
                            <div class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x text-muted"></i></div>
                        </div>
                    </div>
                </div>

                {{-- ════════════════════════════════════════
                     TAB 4  Contract  (view-only)
                ════════════════════════════════════════ --}}
                <div class="tab-pane fade" id="contract" role="tabpanel">
                    <div class="card p-3 my-2">
                        <div class="d-flex align-items-baseline mb-3">
                            <i class="fas fa-file-contract fa-2x" style="color:#3da087;margin-right:10px"></i>
                            <h2>Contract</h2>
                        </div>
                        <div id="container_contractDocument">
                            <div class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x text-muted"></i></div>
                        </div>
                    </div>
                </div>

                {{-- ════════════════════════════════════════
                     TAB 5  NDA  (view-only)
                ════════════════════════════════════════ --}}
                <div class="tab-pane fade" id="nda" role="tabpanel">
                    <div class="card p-3 my-2">
                        <div class="d-flex align-items-baseline mb-3">
                            <i class="fas fa-file-shield fa-2x" style="color:#3da087;margin-right:10px"></i>
                            <h2>NDA</h2>
                        </div>
                        <div id="container_ndaDocument">
                            <div class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x text-muted"></i></div>
                        </div>
                    </div>
                </div>

            </div>{{-- /.tab-content --}}

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="employee_view_group_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Employee Groups </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Group Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userRoles as $index => $userRole)
                            <tr>
                                <td>{{ $index + 1 }}</td> <!-- Index (starting from 1) -->
                                <td>{{ $userRole->name }}</td> <!-- Role Name -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>

    {{-- Document Viewer Modal --}}
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

    {{-- <div class="row" >
        <div class="col-12 background-image mt-1">
            <div class="profile-image">
                <img alt="Image placeholder"  src="{{ asset(auth()->user()->profile_pic) }}" class="img-user profile_pic_change_class">
</div>
<h2 style="text-align: center" id="myHeading_name">{{auth()->user()->name}}</h2>
</div>
<div class="col-12 border-r-s" style="margin-top: 90px">
    <div class=" py-4 px-1">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center" style="    flex-wrap: nowrap;justify-content: space-between;">
                            <p class="mb-0">Edit Profile</p>

                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-uppercase text-sm">User Information</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Name</label>
                                    <input class="form-control" id="name" type="text" value="{{$userInfo->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Email address</label>
                                    <input class="form-control" type="email" value="{{$userInfo->email}}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Profile picture</label>
                                    <input class="form-control" type="file" id="profile-picture-input" onchange="updateProfilePicture(event)">
                                    <div class="invalid-feedback" id="profilevalidation">
                                        Please select a valid image file (JPEG, PNG, GIF, JPG).
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Contact Information</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Address</label>
                                    <input class="form-control" id="address" type="text" value="{{$userInfo->userDetails->address}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">City</label>
                                    <input class="form-control" id="city" type="text" value="{{$userInfo->userDetails->city}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Country</label>
                                    {{-- <input class="form-control" type="text" value="{{$userInfo->userDetails->country}}"> --}}
                                    {{-- <select class="js-example-basic-single countryselect" name="state" id="countrySelect" style="width: 100%;border:1px solid black">
                                @foreach ($countries as $key=>$item)
                                    <option value="{{$key}}" @if($userInfo->userDetails->country == $key) selected @endif>{{$item}}</option>
                                    @endforeach
                                    </select> --}}
                                    {{-- <div class="invalid-feedback">
                                Please provide a valid zip.
                              </div> --}}
                                    {{-- </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="example-text-input" class="form-control-label">Postal code</label>
                              <input class="form-control"  id="postal_code" type="text" value="{{$userInfo->userDetails->postal_code}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Mobile number</label>
                                    <input class="form-control save-changes" id="m_number" type="text" value="{{$userInfo->userDetails->m_number}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Whatsapp number</label>
                                    <input class="form-control" id="w_number" type="text" value="{{$userInfo->userDetails->w_number}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Time Zone</label> --}}
                                    {{-- <input class="form-control" type="text" value="{{$userInfo->userDetails->timezone}}"> --}}
                                    {{-- <select class="js-example-basic-single timezoneselect" name="state" id="timezoneSelect" style="width: 100%;border:1px solid black">
                                @foreach ($timezoneset as $item)
                                    <option value="{{$item}}" @if($userInfo->userDetails->timezone == $item) selected @endif>{{$item}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">About me</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">About me</label>
                                    <input class="form-control" id="about" type="text" value="{{$userInfo->userDetails->about}}">
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Logging info</p>
                        <form action="{{ route('password.change') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="old-password" class="form-control-label">Old password</label>
                                        <input class="form-control @error('old_password') is-invalid @enderror" type="password" id="old-password" name="old_password" placeholder="Enter old password">
                                        @error('old_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new-password" class="form-control-label">New password</label>
                                        <input class="form-control @error('new_password') is-invalid @enderror" type="password" id="new-password" name="new_password" placeholder="Enter new password">
                                        @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="confirm-password" class="form-control-label">Confirm password</label>
                                        <input class="form-control @error('new_password_confirmation') is-invalid @enderror" type="password" id="confirm-password" name="new_password_confirmation" placeholder="Confirm new password">
                                        @error('new_password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <button type="submit" class="btn btn-primary">Change Password</button> --}}
                            {{-- <button type="submit"   class="btn btn-success custom-btn-style">change password</button> --}}

                            <!-- Success message -->
                            {{-- @if (session('status'))
                                <div class="alert alert-success mt-3">
                                    {{ session('status') }}
                    </div>
                    @endif --}}

                    <!-- General error message -->
                    {{-- @if ($errors->any())
                                <div class="alert alert-danger mt-3">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
                @endif
                </form>


            </div>
        </div>
    </div>
</div>
</div> --}}
{{-- </div> --}}


</div>
<!-- Include intl-tel-input CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />

<!-- Include intl-tel-input JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script>
    $('select').select2();

    function updateProfilePicture(event) {
        const input = event.target;
        const validationMessage = document.getElementById('profilevalidation');
        validationMessage.style.display = 'none';
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];

            if (!validImageTypes.includes(file.type)) {
                // alert('Please select a valid image file (JPEG, PNG, GIF, JPG).');
                validationMessage.style.display = 'block';
                return;
            }
            $(".se-pre-con").fadeIn('fast');
            // Display the selected image
            const reader = new FileReader();
            reader.onload = function(e) {
                const profilePictures = document.getElementsByClassName('profile_pic_change_class');
                for (let i = 0; i < profilePictures.length; i++) {
                    profilePictures[i].src = e.target.result;
                }
            }
            reader.readAsDataURL(file);

            // Create a FormData object to send the file via AJAX
            const formData = new FormData();
            formData.append('profile_picture', file);

            // Send the image to the server using AJAX
            fetch("{{ url('/update-profile-picture') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    $(".se-pre-con").fadeOut('fast');
                    if (data.success) {
                        console.log('Profile picture updated successfully');
                    } else {
                        console.error('Error updating profile picture');
                    }
                })
                .catch(error => {
                    $(".se-pre-con").fadeOut('fast');
                    console.error('Error:', error);
                });
        }
    }

    // ════════════════════════════════════════════
    // Document tab helpers (mirrors HR view page)
    // ════════════════════════════════════════════
    function getFileIcon(fileName) {
        var ext = fileName.split('.').pop().toLowerCase();
        if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].indexOf(ext) > -1) return {
            label: ext.toUpperCase(),
            colorClass: 'icon-image'
        };
        if (ext === 'pdf') return {
            label: 'PDF',
            colorClass: 'icon-pdf'
        };
        if (ext === 'docx' || ext === 'doc') return {
            label: 'DOC',
            colorClass: 'icon-doc'
        };
        return {
            label: ext.toUpperCase() || 'FILE',
            colorClass: 'icon-generic'
        };
    }

    function shortenName(n, max) {
        max = max || 22;
        var ext = n.split('.').pop();
        var base = n.substring(0, n.lastIndexOf('.'));
        return (base.length > max ? base.substring(0, max) + '...' : base) + '.' + ext;
    }

    var emptyMessages = {
        verificationDocument: {
            icon: 'fa-file-alt',
            title: 'No Verification Documents',
            text: 'No verification documents have been uploaded for you yet.'
        },
        appointmentLetterDocument: {
            icon: 'fa-file-signature',
            title: 'No Appointment Letter',
            text: 'No appointment letter has been uploaded for you yet.'
        },
        contractDocument: {
            icon: 'fa-file-contract',
            title: 'No Contract Uploaded',
            text: 'No contract has been uploaded for you yet.'
        },
        ndaDocument: {
            icon: 'fa-file-shield',
            title: 'No NDA Uploaded',
            text: 'No NDA has been uploaded for you yet.'
        }
    };

    function renderDocs(docType, files) {
        var container = $('#container_' + docType);
        var empty = emptyMessages[docType];

        if (!files || files.length === 0) {
            container.html(
                '<div class="text-center py-5">' +
                '<i class="fas ' + empty.icon + ' fa-5x text-muted mb-4" style="opacity:0.35;"></i>' +
                '<h3>' + empty.title + '</h3>' +
                '<p class="text-muted mx-auto" style="max-width:480px;">' + empty.text + '</p>' +
                '</div>'
            );
            return;
        }

        var html = '<div class="doc-thumb-grid">';
        files.forEach(function(file) {
            var info = getFileIcon(file.name);
            var preview = '<div class="file-type-icon"><div class="icon-shape ' + info.colorClass + '">' + info.label + '</div></div>';
            html +=
                '<div class="doc-thumb-card">' +
                '<div class="doc-thumb-preview">' + preview + '</div>' +
                '<div class="doc-thumb-body">' +
                '<div class="doc-thumb-name" title="' + file.name + '">' + shortenName(file.name) + '</div>' +
                '<div class="doc-thumb-actions">' +
                '<a href="javascript:void(0);" class="btn-view-doc"' +
                ' data-content="' + encodeURIComponent(file.content) + '"' +
                ' data-name="' + encodeURIComponent(file.name) + '"' +
                ' title="View"><i class="fas fa-eye"></i> View</a>' +
                '<a href="' + file.content + '" download="' + file.name + '" title="Download"><i class="fas fa-download"></i> Save</a>' +
                '</div></div></div>';
        });
        html += '</div>';
        container.html(html);
    }

    function loadDocs(docType) {
        $.ajax({
            url: "{{ url('get-user-files') }}/" + $('#user_id').val() + "/" + docType,
            type: "GET",
            dataType: "json",
            success: function(r) {
                renderDocs(docType, r.files || []);
            },
            error: function() {
                renderDocs(docType, []);
            }
        });
    }

    $(document).ready(function() {
        $(document).on('click', '.LeaveManage', function() {
            window.location.href = "{{ route('leave.manage') }}";
        });
        $(document).on('click', '.profile_group_view', function() {
            $('#employee_view_group_Modal').modal('show'); // Open the modal
        });

        // ── Load all 4 document tabs on page load ──
        ['verificationDocument', 'appointmentLetterDocument', 'contractDocument', 'ndaDocument']
        .forEach(loadDocs);

        // ── View document in modal ──
        $(document).on('click', '.btn-view-doc', function() {
            var content = decodeURIComponent($(this).data('content'));
            var fileName = decodeURIComponent($(this).data('name'));
            $('#documentModalLabel').text(fileName);
            $('#documentIframe').attr('src', '');
            $('#documentModal').modal('show');
            try {
                var arr = content.split(',');
                var mime = arr[0].match(/:(.*?);/)[1];
                var bstr = atob(arr[1]);
                var n = bstr.length;
                var u8arr = new Uint8Array(n);
                while (n--) u8arr[n] = bstr.charCodeAt(n);
                var blobUrl = URL.createObjectURL(new Blob([u8arr], {
                    type: mime
                }));
                $('#documentIframe').attr('src', blobUrl);
                $('#documentModal').one('hidden.bs.modal', function() {
                    URL.revokeObjectURL(blobUrl);
                    $('#documentIframe').attr('src', '');
                });
            } catch (e) {
                alert("Could not load document preview.");
            }
        });

        var input = document.querySelector("#employee_phoneNumber");
        let userId = $("#user_id").val();
        var iti = window.intlTelInput(input, {
            initialCountry: "auto",
            geoIpLookup: function(callback) {
                fetch("https://ipinfo.io/json?token=YOUR_TOKEN") // Replace with your API token
                    .then(response => response.json())
                    .then(data => callback(data.country))
                    .catch(() => callback("US"));
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });

        // Format number on form submit
        document.querySelector("form").addEventListener("submit", function() {
            input.value = iti.getNumber();
        });
        $("#employee_dob").datepicker({
            dateFormat: "mm/dd/yy", // MM/DD/YYYY format
            changeMonth: true,
            changeYear: true,
            yearRange: "1900:2025", // Allow selection from 1900 to 2025
            maxDate: "0" // Prevents selecting a future date
        });
        $("#employee_joineddate").datepicker({
            dateFormat: "mm/dd/yy", // MM/DD/YYYY format
            changeMonth: true,
            changeYear: true,
            yearRange: "1900:2025", // Allow selection from 1900 to 2025
            maxDate: "0" // Prevents selecting a future date
        });

        var countryValue = $("#countrySelect").val();
        var timezoneValue = $("#employee_timezone").val();
        var employee_nameValue = $("#employee_name").val();
        var employee_dobValue = $("#employee_dob").val();
        var employee_marital_statusValue = $("#marital_status").val();
        var employee_employee_GenderValue = $("#employee_Gender").val();
        var employee_employee_NationalityValue = $("#employee_Nationality").val();
        var employee_employee_LanguagesValue = $("#employee_Languages").val();
        var employee_addressValue = $("#employee_address").val();
        var employee_countryValue = $("#employee_country").val();
        var employee_postalcodeValue = $("#employee_postalcode").val();
        var employee_phoneNumberValue = $("#employee_phoneNumber").val();
        var employee_privateemailValue = $("#employee_privateemail").val();
        var employee_Employment_StatusValue = $("#employee_Employment_Status").val();
        var employee_jobtitleValue = $("#employee_jobtitle").val();
        var employee_joineddateValue = $("#employee_joineddate").val();
        var employee_timezoneValue = $("#employee_timezone").val();
        var employee_DepartmentValue = $("#employee_Department").val();

        $("#employee_Department").on('keyup focusout', function(event) {
            var currentValue = $(this).val();

            // Check if Enter key was pressed (event.keyCode === 13) or focusout occurred
            if (event.type === 'keyup' && event.keyCode !== 13) {
                return; // Ignore keyup events unless Enter key
            }

            // Perform update if value has changed
            if (currentValue !== employee_DepartmentValue) {
                updateValue('Department', 'userdetails', currentValue); // Replace with your update function
                employee_DepartmentValue = currentValue; // Update initial value
            }
        });
        $('#employee_timezone').on('change', function() {
            var currentValue = $(this).val();
            console.log(currentValue);

            // Perform update if value has changed
            if (currentValue !== employee_timezoneValue) {
                updateValue('timezone', 'userdetails', currentValue); // Replace with your update function
                employee_timezoneValue = currentValue; // Update initial value
            }
        });
        $('#employee_joineddate').on('change', function() {
            var currentValue = $(this).val();
            console.log(currentValue);

            // Perform update if value has changed
            if (currentValue !== employee_joineddateValue) {
                updateValue('joined_date', 'userdetails', currentValue); // Replace with your update function
                employee_joineddateValue = currentValue; // Update initial value
            }
        });
        $("#employee_jobtitle").on('keyup focusout', function(event) {
            var currentValue = $(this).val();

            // Check if Enter key was pressed (event.keyCode === 13) or focusout occurred
            if (event.type === 'keyup' && event.keyCode !== 13) {
                return; // Ignore keyup events unless Enter key
            }

            // Perform update if value has changed
            if (currentValue !== employee_jobtitleValue) {
                updateValue('job_title', 'userdetails', currentValue); // Replace with your update function
                employee_jobtitleValue = currentValue; // Update initial value
            }
        });
        $('#employee_Employment_Status').on('change', function() {
            var currentValue = $(this).val();
            console.log(currentValue);

            // Perform update if value has changed
            if (currentValue !== employee_Employment_StatusValue) {
                updateValue('Employment_Status', 'userdetails', currentValue); // Replace with your update function
                employee_Employment_StatusValue = currentValue; // Update initial value
            }
        });
        $("#employee_privateemail").on('keyup focusout', function(event) {
            var currentValue = $(this).val();


            // Check if Enter key was pressed (event.keyCode === 13) or focusout occurred
            if (event.type === 'keyup' && event.keyCode !== 13) {
                return; // Ignore keyup events unless Enter key
            }
            if (!isValidEmail(currentValue)) {
                Swal.fire({
                    icon: "error",
                    title: "Invalid Email",
                    text: "Please enter a valid email address.",
                });
                return;
            }
            // Perform update if value has changed
            if (currentValue !== employee_privateemailValue) {
                updateValue('Private_Email', 'userdetails', currentValue); // Replace with your update function
                employee_privateemailValue = currentValue; // Update initial value
            }
        });
        $("#employee_phoneNumber").on('keyup focusout', function(event) {
            var currentValue = iti.getNumber();
            console.log(currentValue);


            // Check if Enter key was pressed (event.keyCode === 13) or focusout occurred
            if (event.type === 'keyup' && event.keyCode !== 13) {
                return; // Ignore keyup events unless Enter key
            }

            // Perform update if value has changed
            if (currentValue !== employee_phoneNumberValue) {
                updateValue('m_number', 'userdetails', currentValue); // Replace with your update function
                employee_phoneNumberValue = currentValue; // Update initial value
            }
        });
        $("#employee_postalcode").on('keyup focusout', function(event) {
            var currentValue = $(this).val();

            // Check if Enter key was pressed (event.keyCode === 13) or focusout occurred
            if (event.type === 'keyup' && event.keyCode !== 13) {
                return; // Ignore keyup events unless Enter key
            }

            // Perform update if value has changed
            if (currentValue !== employee_postalcodeValue) {
                updateValue('postal_code', 'userdetails', currentValue); // Replace with your update function
                employee_postalcodeValue = currentValue; // Update initial value
            }
        });
        $('#employee_country').on('change', function() {
            var currentValue = $(this).val();
            console.log(currentValue);

            // Perform update if value has changed
            if (currentValue !== employee_countryValue) {
                updateValue('country', 'userdetails', currentValue); // Replace with your update function
                employee_countryValue = currentValue; // Update initial value
            }
        });
        $("#employee_address").on('keyup focusout', function(event) {
            var currentValue = $(this).val();

            // Check if Enter key was pressed (event.keyCode === 13) or focusout occurred
            if (event.type === 'keyup' && event.keyCode !== 13) {
                return; // Ignore keyup events unless Enter key
            }

            // Perform update if value has changed
            if (currentValue !== employee_addressValue) {
                updateValue('address', 'userdetails', currentValue); // Replace with your update function
                employee_addressValue = currentValue; // Update initial value
            }
        });
        $('#employee_Languages').on('change', function() {
            var currentValue = $(this).val();
            console.log(currentValue);

            // Perform update if value has changed
            if (currentValue !== employee_employee_LanguagesValue) {
                updateValue('Languages', 'userdetails', currentValue); // Replace with your update function
                employee_employee_LanguagesValue = currentValue; // Update initial value
            }
        });
        $('#employee_Nationality').on('change', function() {
            var currentValue = $(this).val();
            console.log(currentValue);

            // Perform update if value has changed
            if (currentValue !== employee_employee_NationalityValue) {
                updateValue('Nationality', 'userdetails', currentValue); // Replace with your update function
                employee_employee_NationalityValue = currentValue; // Update initial value
            }
        });
        $('#employee_Gender').on('change', function() {
            var currentValue = $(this).val();
            console.log(currentValue);

            // Perform update if value has changed
            if (currentValue !== employee_employee_GenderValue) {
                updateValue('Gender', 'userdetails', currentValue); // Replace with your update function
                employee_employee_GenderValue = currentValue; // Update initial value
            }
        });
        $('#marital_status').on('change', function() {
            var currentValue = $(this).val();
            // Perform update if value has changed
            if (currentValue !== employee_marital_statusValue) {
                updateValue('Marital_Status', 'userdetails', currentValue); // Replace with your update function
                employee_marital_statusValue = currentValue; // Update initial value
            }
        });
        $('#employee_dob').on('change', function() {
            var currentValue = $(this).val();
            // Perform update if value has changed
            if (currentValue !== employee_dobValue) {
                updateValue('dob', 'userdetails', currentValue); // Replace with your update function
                employee_dobValue = currentValue; // Update initial value
            }
        });

        $('#employee_country').on('change', function() {
            var currentValue = $(this).val();
            console.log(currentValue);

            // Perform update if value has changed
            if (currentValue !== countryValue) {
                // updateValue('country','userdetails',currentValue); // Replace with your update function
                countryValue = currentValue; // Update initial value
                $.ajax({
                    url: '{{ route("getTimezones") }}', // Your route to get timezones
                    type: 'GET',
                    data: {
                        country: countryValue
                    },
                    success: function(response) {
                        var timezoneSelect = $('#employee_timezone');
                        timezoneSelect.empty();
                        timezoneSelect.append('<option value="' + timezoneValue + '">' + timezoneValue + '</option>');
                        $.each(response.timezones, function(key, value) {
                            timezoneSelect.append('<option value="' + value + '">' + value + '</option>');
                        });
                    }
                });
            }
        });
        $("#employee_name").on('keyup focusout', function(event) {
            var currentValue = $(this).val();

            // Check if Enter key was pressed (event.keyCode === 13) or focusout occurred
            if (event.type === 'keyup' && event.keyCode !== 13) {
                return; // Ignore keyup events unless Enter key
            }

            // Perform update if value has changed
            if (currentValue !== employee_nameValue) {
                updateValue('name', 'user', currentValue); // Replace with your update function
                employee_nameValue = currentValue; // Update initial value
            }
        });

        function isValidEmail(email) {
            var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            return emailRegex.test(email);
        }

        function updateValue(colunm, modal, value) {
            // console.log("New value:", value);
            $.ajax({
                url: "{{ url('/update-profile') }}", // Replace with your URL
                method: 'POST', // or 'PUT' depending on your server setup
                data: {
                    colunm: colunm,
                    modal: modal,
                    value: value,
                    userId: userId,
                    _token: '{{ csrf_token() }}' // Include CSRF token for Laravel
                },
                beforeSend: function() {
                    $(".se-pre-con").fadeIn('fast');
                },
                success: function(response) {
                    $(".se-pre-con").fadeOut('fast');
                    console.log("Update successful:", response);
                    // Handle successful update (e.g., display a success message)
                },
                error: function(xhr, status, error) {
                    $(".se-pre-con").fadeOut('fast');
                    console.error("Update failed:", status, error);
                    // Handle update failure (e.g., display an error message)
                }
            });
            // Your update logic here (e.g., AJAX call)
        }
    });

    //     $(document).ready(function() {
    //         $('.timezoneselect').select2();
    //         $('.countryselect').select2();
    //     });
    //     $(document).ready(function() {
    //     var nameValue = $("#name").val(); // Initial value
    //     var addressValue = $("#address").val(); // Initial value
    //     var cityValue = $("#city").val(); // Initial value
    //     var postal_codeValue = $("#postal_code").val(); // Initial value
    //     var m_numberValue = $("#m_number").val(); // Initial value
    //     var w_numberValue = $("#w_number").val(); // Initial value
    //     var aboutValue = $("#about").val(); // Initial value
    //     var countryValue = $("#countrySelect").val(); // Initial value
    //     var timezoneValue = $("#timezoneSelect").val(); // Initial value

    //     // Monitor keyup events (including Enter key) and focusout event
    //     $("#name").on('keyup focusout', function(event) {
    //         var currentValue = $(this).val();

    //         // Check if Enter key was pressed (event.keyCode === 13) or focusout occurred
    //         if (event.type === 'keyup' && event.keyCode !== 13) {
    //             return; // Ignore keyup events unless Enter key
    //         }

    //         // Perform update if value has changed
    //         if (currentValue !== nameValue) {
    //             updateValue('name','user',currentValue); // Replace with your update function
    //             nameValue = currentValue; // Update initial value
    //             document.getElementById('myHeading_name').textContent = currentValue;
    //         }
    //     });
    //     $("#address").on('keyup focusout', function(event) {
    //         var currentValue = $(this).val();

    //         // Check if Enter key was pressed (event.keyCode === 13) or focusout occurred
    //         if (event.type === 'keyup' && event.keyCode !== 13) {
    //             return; // Ignore keyup events unless Enter key
    //         }

    //         // Perform update if value has changed
    //         if (currentValue !== addressValue) {
    //             updateValue('address','userdetails',currentValue); // Replace with your update function
    //             addressValue = currentValue; // Update initial value
    //         }
    //     });
    //     $("#city").on('keyup focusout', function(event) {
    //         var currentValue = $(this).val();

    //         // Check if Enter key was pressed (event.keyCode === 13) or focusout occurred
    //         if (event.type === 'keyup' && event.keyCode !== 13) {
    //             return; // Ignore keyup events unless Enter key
    //         }

    //         // Perform update if value has changed
    //         if (currentValue !== cityValue) {
    //             updateValue('city','userdetails',currentValue); // Replace with your update function
    //             cityValue = currentValue; // Update initial value
    //         }
    //     });
    //     $("#postal_code").on('keyup focusout', function(event) {
    //         var currentValue = $(this).val();

    //         // Check if Enter key was pressed (event.keyCode === 13) or focusout occurred
    //         if (event.type === 'keyup' && event.keyCode !== 13) {
    //             return; // Ignore keyup events unless Enter key
    //         }

    //         // Perform update if value has changed
    //         if (currentValue !== postal_codeValue) {
    //             updateValue('postal_code','userdetails',currentValue); // Replace with your update function
    //             postal_codeValue = currentValue; // Update initial value
    //         }
    //     });
    //     $("#about").on('keyup focusout', function(event) {
    //         var currentValue = $(this).val();

    //         // Check if Enter key was pressed (event.keyCode === 13) or focusout occurred
    //         if (event.type === 'keyup' && event.keyCode !== 13) {
    //             return; // Ignore keyup events unless Enter key
    //         }

    //         // Perform update if value has changed
    //         if (currentValue !== aboutValue) {
    //             updateValue('about','userdetails',currentValue); // Replace with your update function
    //             aboutValue = currentValue; // Update initial value
    //         }
    //     });
    //     $("#m_number").on('keyup focusout', function(event) {
    //         var currentValue = $(this).val();

    //         // Check if Enter key was pressed (event.keyCode === 13) or focusout occurred
    //         if (event.type === 'keyup' && event.keyCode !== 13) {
    //             return; // Ignore keyup events unless Enter key
    //         }

    //         // Perform update if value has changed
    //         if (currentValue !== m_numberValue) {
    //             updateValue('m_number','userdetails',currentValue); // Replace with your update function
    //             currentValue = currentValue; // Update initial value
    //         }
    //     });
    //     $("#w_number").on('keyup focusout', function(event) {
    //         var currentValue = $(this).val();

    //         // Check if Enter key was pressed (event.keyCode === 13) or focusout occurred
    //         if (event.type === 'keyup' && event.keyCode !== 13) {
    //             return; // Ignore keyup events unless Enter key
    //         }

    //         // Perform update if value has changed
    //         if (currentValue !== w_numberValue) {
    //             updateValue('w_number','userdetails',currentValue); // Replace with your update function
    //             w_numberValue = currentValue; // Update initial value
    //         }
    //     });
    //     $('#countrySelect').on('change', function() {
    //         var currentValue = $(this).val();
    //         // Perform update if value has changed
    //         if (currentValue !== countryValue) {
    //             updateValue('country','userdetails',currentValue); // Replace with your update function
    //             countryValue = currentValue; // Update initial value
    //             $.ajax({
    //                 url: '{{ route("getTimezones") }}', // Your route to get timezones
    //                 type: 'GET',
    //                 data: { country: countryValue },
    //                 success: function(response) {
    //                     var timezoneSelect = $('#timezoneSelect');
    //                     timezoneSelect.empty();
    //                     timezoneSelect.append('<option value="' + timezoneValue + '">' + timezoneValue + '</option>');
    //                     $.each(response.timezones, function(key, value) {
    //                         timezoneSelect.append('<option value="' + value + '">' + value + '</option>');
    //                     });
    //                 }
    //             });
    //         }
    //     });
    //     $('#timezoneSelect').on('change', function() {
    //         var currentValue = $(this).val();
    //         // Perform update if value has changed
    //         if (currentValue !== timezoneValue) {
    //             updateValue('timezone','userdetails',currentValue); // Replace with your update function
    //             timezoneValue = currentValue; // Update initial value
    //         }
    //     });

    //     // Example update function
    //     function updateValue(colunm,modal,value) {
    //         // console.log("New value:", value);
    //         $.ajax({
    //             url: "{{ url('/update-profile') }}", // Replace with your URL
    //             method: 'POST', // or 'PUT' depending on your server setup
    //             data: {
    //                 colunm: colunm,
    //                 modal: modal,
    //                 value: value,
    //                 _token: '{{ csrf_token() }}' // Include CSRF token for Laravel
    //             },
    //             beforeSend: function () {
    //                     $(".se-pre-con").fadeIn('fast');
    //                 },
    //             success: function(response) {
    //                 $(".se-pre-con").fadeOut('fast');
    //                 console.log("Update successful:", response);
    //                 // Handle successful update (e.g., display a success message)
    //             },
    //             error: function(xhr, status, error) {
    //                 $(".se-pre-con").fadeOut('fast');
    //                 console.error("Update failed:", status, error);
    //                 // Handle update failure (e.g., display an error message)
    //             }
    //         });
    //         // Your update logic here (e.g., AJAX call)
    //     }
    // });
</script>
@endsection