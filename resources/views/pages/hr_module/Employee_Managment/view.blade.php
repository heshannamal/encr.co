@extends('layouts.app', ['activePage' => 'Employee_Managment', 'titlePage' => __('Employee Managment')])

@section('content')
<style>
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

    .table td {
        padding: 0.6rem !important;
    }

    .table td p {
        margin-top: auto;
        margin-bottom: auto;
    }

    /* Appointment, Contract */

    .opacity-50 {
        opacity: 0.5;
    }

    .fs-5 {
        font-size: 1.25rem !important;
    }

    .document-preview-card {
        max-width: 460px;
        margin: 0 auto;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.2s ease;
    }

    .document-preview-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12) !important;
    }

    .document-preview-placeholder {
        height: 280px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-size: 1.1rem;
        border-bottom: 1px solid #dee2e6;
    }

    .document-info {
        padding: 12px 16px;
        background: #fff;
        text-align: left;
    }

    .document-info p {
        margin: 4px 0;
        font-size: 0.95rem;
    }

    .document-info .label {
        color: #6c757d;
        font-weight: 500;
    }

    #appointment-preview-container img,
    #contract-preview-container img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
    }

    /* ── Document thumbnail grid ── */
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
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.07);
        transition: transform 0.15s, box-shadow 0.15s;
    }

    .doc-thumb-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
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

    .doc-thumb-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .doc-thumb-preview .doc-icon {
        font-size: 2.8rem;
        color: #c0c0c0;
    }

    .doc-thumb-preview .doc-icon.pdf {
        color: #e74c3c;
    }

    .doc-thumb-preview .doc-icon.docx {
        color: #2980b9;
    }

    .doc-thumb-preview .doc-icon.image {
        color: #27ae60;
    }

    .doc-thumb-body {
        padding: 8px 10px;
    }

    .doc-thumb-name {
        font-size: 0.75rem;
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
        font-size: 0.8rem;
        color: #666;
        text-decoration: none;
    }

    .doc-thumb-actions a:hover {
        color: #3da087;
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

    /* ── Unified file type icon (same style for all types) ── */
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
        border-radius: 6px 6px 6px 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.72rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: 0.04em;
        position: relative;
    }

    /* Folded corner effect */
    .file-type-icon .icon-shape::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 14px;
        height: 14px;
        background: rgba(255, 255, 255, 0.25);
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

    /* ═══════════════════════════════════════════
    MOBILE RESPONSIVE — Employee Profile
    ═══════════════════════════════════════════ */
    .mobile-role-subtitle,
    .btn-edit-profile-mobile {
        display: none;
    }

    @media (max-width: 767.98px) {

        /* Hide the desktop "edit" text link, we use the button instead */
        .editbtn_row .edit_account {
            display: none !important;
        }

        /* Profile card: avatar + name centered, stacked */
        .card > .row[style*="padding: 15px"] {
            flex-direction: column;
            align-items: center;
        }

        .card .col-2.d-flex.align-items-center {
            display: block !important;
            width: 100%;
            text-align: center;
            margin-bottom: 12px;
            padding-left: 0;
            padding-right: 0;
        }

        .card .col-2.d-flex.align-items-center + .col {
            width: 100%;
            max-width: 100%;
            flex: 0 0 100%;
        }

        .user_dp {
            width: 90px;
            height: 90px;
            display: block;
            margin: 0 auto;
        }

        /* Name row: centered */
        .empDetailsTable tr:nth-of-type(1) td {
            display: block !important;
            width: 100% !important;
            text-align: center;
            padding: 4px 0 !important;
        }

        .empDetailsTable tr:nth-of-type(1) h1 {
            font-size: 1.05rem;
            white-space: nowrap;
            margin-bottom: 2px;
        }

        .mobile-role-subtitle {
            display: block;
            color: #9ca3af;
            font-size: 0.82rem;
            margin: 0 0 14px 0;
            text-align: center;
        }

        /* Turn the 3-column detail table into a single vertical list */
        .empDetailsTable,
        .empDetailsTable tbody,
        .empDetailsTable tr {
            display: block;
            width: 100%;
        }

        .empDetailsTable tr:nth-of-type(2) td,
        .empDetailsTable tr:nth-of-type(3) td {
            display: grid !important;
            grid-template-columns: 26px 1fr;
            column-gap: 12px;
            align-items: start;
            width: 100% !important;
            padding: 10px 0 !important;
            border-bottom: 1px solid #f3f4f6;
        }

        .empDetailsTable tr:nth-of-type(2) td i,
        .empDetailsTable tr:nth-of-type(3) td i {
            grid-row: 1 / 3;
            grid-column: 1;
            align-self: center;
            font-size: 1rem !important;
            margin: 0 !important;
        }

        .empDetailsTable tr:nth-of-type(2) td h3,
        .empDetailsTable tr:nth-of-type(3) td h3 {
            grid-column: 2;
            font-size: 0.7rem;
            color: #9ca3af;
            font-weight: 500;
            margin: 0 0 2px 0 !important;
        }

        .empDetailsTable tr:nth-of-type(2) td p,
        .empDetailsTable tr:nth-of-type(3) td p {
            grid-column: 2;
            font-weight: 600;
            color: #111;
            margin: 0 !important;
            font-size: 0.88rem !important;
        }

        /* Phone and Official Email cells have no <h3> label in the HTML —
        add one here so they match the other rows */
        .empDetailsTable tr:nth-of-type(2) td:nth-of-type(1)::before {
            content: "Phone";
            grid-column: 2;
            font-size: 0.7rem;
            color: #9ca3af;
            font-weight: 500;
        }

        .empDetailsTable tr:nth-of-type(3) td:nth-of-type(1)::before {
            content: "Official Email";
            grid-column: 2;
            font-size: 0.7rem;
            color: #9ca3af;
            font-weight: 500;
        }

        /* Full-width gray Edit profile button */
        .btn-edit-profile-mobile {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            background: #d9d9d9;
            color: #555;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            font-size: 0.85rem;
            margin-top: 16px;
            cursor: pointer;
        }

        /* ── Tabs: scroll horizontally, hidden scrollbar, white/black pill colors ── */
        .nav-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
            gap: 8px;
            padding-bottom: 4px;
            scrollbar-width: none;
        }

        .nav-tabs .nav-link {
            border-radius: 8px;
            background: #FFFFFF;
            border: 1px solid #D1D5DB !important;
            padding: 8px 16px;
            white-space: nowrap;
        }

        .nav-tabs .nav-link.active {
            background: #000000;
            border: 1px solid #D1D5DB !important;
        }

        .nav-tabs .nav-link.active p {
            color: #fff !important;
        }

        .nav-tabs .nav-link p {
            margin: 0;
            font-size: 0.72rem;
        }

        /* Document thumbnails: center them under the "Verification Documents" title */
        .doc-thumb-grid {
            justify-content: center;
        }

        #basic-info .row .col-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        /* ── Card shell + header: icon badge + title + chevron ── */
        #basic-info .card {
            border-radius: 12px;
            border: 1px solid #ebebeb;
            box-shadow: none;
            margin-bottom: 12px;
        }

        #basic-info .card > .d-flex.align-items-baseline {
            align-items: center !important;
            position: relative;
            padding-right: 28px;
            margin-bottom: 10px !important;
        }

        #basic-info .card > .d-flex.align-items-baseline i {
            width: 34px;
            height: 34px;
            min-width: 34px;
            border-radius: 8px;
            background: #e8f5f1;
            color: #3da087 !important;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem !important;
            margin-right: 10px !important;
        }

        #basic-info h2 {
            font-size: 1rem;
            margin-bottom: 0;
        }

        #basic-info .card > .d-flex.align-items-baseline h2 {
            font-size: 0.95rem;
            font-weight: 700;
        }

        #basic-info .card > .d-flex.align-items-baseline::after {
            content: "\f077"; /* chevron-up — content is shown, not collapsed */
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            font-size: 0.8rem;
        }

        #basic-info .fa-2x {
            font-size: 1.3em !important;
        }

        /* ── Label / value rows: divider lines, bold right-aligned values ── */
        #basic-info .table {
            margin-bottom: 0;
        }

        #basic-info .table td {
            word-break: break-word;
            white-space: normal;
            vertical-align: top;
            border: none !important;
            padding: 12px 0 !important;
        }

        #basic-info .table tbody tr {
            border-bottom: 1px solid #f3f4f6;
        }

        #basic-info .table tbody tr:last-child {
            border-bottom: none;
        }

        #basic-info .table td.wi-40 {
            width: 42% !important;
        }

        #basic-info .table td.wi-40 p {
            color: #9ca3af !important;
            font-size: 0.82rem;
            margin: 0;
        }

        #basic-info .table td:not(.wi-40) {
            text-align: right;
        }

        #basic-info .table td:not(.wi-40) p {
            font-weight: 700;
            color: #111;
            font-size: 0.88rem;
            margin: 0;
        }

        h1.profile-title {
            padding-left: 16px;
        }

        .btn-edit-profile-mobile {
            width: 76%
        }

        ul#employeeTab {
            padding-top: 13px;
            padding-bottom: 10px;
        }

        .back_home_mobile {
            padding-left: 3px;
            padding-bottom: 10px;
        }

        h1.profile-title {
            display: none;
        }
    }

    @media (min-width: 768px) {
        .back_home_mobile {
            display: none;
        }
    }

</style>

<script>
    function deleteFile(fileId) {
        if (!confirm("Are you sure you want to delete this file?")) return;

        $.ajax({
            url: "{{ url('employee/delete-file') }}", // Your Laravel route for deletion
            type: "POST",
            data: {
                id: fileId,
                _token: $('meta[name="csrf-token"]').attr("content")
            },
            success: function(response) {
                if (response.success) {
                    $(`#file-row-${fileId}`).remove(); // Remove row from table
                    alert("File deleted successfully!");
                } else {
                    alert("Failed to delete file.");
                }
            },
            error: function() {
                alert("Error occurred while deleting file.");
            }
        });
    }
</script>

@if ($errors->any())
<div class="alert alert-danger">
    {{ $errors->first() }}
</div>
@endif

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
    <span>EMPLOYEE MNAGMENT</span>
    @endsection

    @section('back-btn')
    <a href="{{ route('HR.Employee_Managment') }}" class="home-btn-color" title="Back to Employee Managment">BACK</a>
    @endsection

    @section('back-btn-Mobile')
        <a href="javascript:void(0);" onclick="goBackOnePage()" class="home-btn-color-mobile" title="Back">
            < BACK
        </a>
    @endsection
    

    <input type="hidden" id="user_id" value="{{$user->id }}">
    <div class="col-md-12">
        @can('edit employee')
        <div class="row editbtn_row">
            <h1 class="profile-title">Employee Profile</h1>
            <span class="d-flex align-items-center edit_account" data-uid="{{$user->id}}" style="color:#a7a7a7">
                <i class=" fa fa-pen-to-square fa-lg" style="cursor: pointer;"></i>
                <h4 class="mx-2 " style="margin-bottom: unset;color:#a7a7a7;cursor: pointer;">EDIT PROFILE</h4>
            </span>
        </div>
        @endcan
        <div class="back_home_mobile">
            <strong>
                @yield('back-btn-Mobile')
            </strong>
        </div>

        <div class="card">
            <div class="row" style="padding: 15px">
                <div class="col-2 d-flex align-items-center">
                    @if ($user->profile_pic == null || $user->profile_pic == '')
                    <img src="{{ asset('assets') }}/img/user/default.png" class="user_dp" />
                    @else
                    <img src="{{ asset($user->profile_pic) }}" class="user_dp" />
                    @endif
                </div>
                <div class="col">
                    <table class="empDetailsTable">
                        <tr>
                            <td class="empDetailsTabletd name" colspan="3">
                                <h1>{{$user->name}}</h1>
                                <p class="mobile-role-subtitle">{{$user->userDetails->job_title ?? ''}}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="empDetailsTabletd"> <i class=" fa fa-phone-volume fa-lg mx-2" style="cursor: pointer;color:#a7a7a7"></i>
                                <p class="ml-2">{{$user->userDetails->m_number ?? '000 0000000'}}</p>
                            </td>
                            <td class="empDetailsTabletd"><i class=" fa fa-user-shield fa-lg mx-2" style="cursor: pointer; color:#a7a7a7"></i>
                                <h3>Employee # : </h3>
                                <p class="ml-2">{{ 'EMP' . str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</p>
                            </td>
                            <td class="empDetailsTabletd"><i class=" fa-regular fa-compass fa-lg mx-2" style="cursor: pointer;color:#a7a7a7"></i>
                                <h3>Time Zone : </h3>
                                <p class="ml-2">{{$user->userDetails->timezone ?? 'not set'}}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="empDetailsTabletd"> <i class=" fa-regular fa-envelope fa-lg mx-2" style="cursor: pointer;color:#a7a7a7"></i>
                                <p class="ml-2">{{$user->email}}</p>
                            </td>
                            <td class="empDetailsTabletd"><i class=" fa fa-crosshairs fa-lg mx-2" style="cursor: pointer; color:#a7a7a7"></i>
                                <h3>Job Title : </h3>
                                <p class="ml-2">{{$user->userDetails->job_title ?? 'not set'}}</p>
                            </td>
                            <td class="empDetailsTabletd"><i class=" fa-regular fa-clock fa-lg mx-2" style="cursor: pointer;color:#a7a7a7"></i>
                                <h3>Time Now : </h3>
                                <p class="ml-2">{{ $user->userDetails && $user->userDetails->timezone ? now()->setTimezone($user->userDetails->timezone)->format('m/d/Y H:i') : 'not set' }}
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>

                @can('edit employee')
                <button type="button" class="btn-edit-profile-mobile edit_account" data-uid="{{$user->id}}">
                    <i class="fa fa-pen-to-square mr-2"></i> Edit profile
                </button>
                @endcan

            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="row">
            <ul class="nav nav-tabs my-2" id="employeeTab" role="tablist">
                <li class="">
                    <a class="nav-link active" id="basic-info-tab" data-toggle="tab" href="#basic-info" role="tab">
                        <p>Basic Information</p>
                    </a>
                </li>
                @can('view employee documents')
                <li class="">
                    <a class="nav-link" id="verification-docs-tab" data-toggle="tab" href="#verification-docs" role="tab">
                        <p>Verification Documents</p>
                    </a>
                </li>
                <li class="">
                    <a class="nav-link" id="appointment-letter-tab" data-toggle="tab" href="#appointment-letter" role="tab">
                        <p>Appointment Letter</p>
                    </a>
                </li>
                <li class="">
                    <a class="nav-link" id="contract-tab" data-toggle="tab" href="#contract" role="tab">
                        <p>Contract</p>
                    </a>
                </li>
                <li class="">
                    <a class="nav-link" id="nda-tab" data-toggle="tab" href="#nda" role="tab">
                        <p>NDA</p>
                    </a>
                </li>
                @endcan
            </ul>
        </div>

        <div class="row">

            <div class="col-12 tab-content mt-3" id="employeeTabContent">
                <!-- Basic Information Tab -->
                <div class="tab-pane fade show active" id="basic-info" role="tabpanel">
                    <div class="row">
                        <div class="col-6">
                            <div class="card p-3 my-2">
                                <div class="d-flex align-items-baseline">
                                    <i class="fa-solid fa-circle-user fa-2x " style="color: #3da087;margin-right:10px"></i>
                                    <h2>Personal Details</h2>
                                </div>
                                <table class="table">

                                    <tbody>
                                        <tr>
                                            <td scope="row" class="wi-40">
                                                <p style="color:#a7a7a7">Date of Birth</p>
                                            </td>
                                            <td>
                                                <p>{{$user->userDetails->dob ?? 'Not Set'}}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row" class="wi-40">
                                                <p style="color:#a7a7a7">Marital Status</p>
                                            </td>
                                            <td>
                                                <p>{{$user->userDetails->Marital_Status ?? 'Not Set'}}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row" class="wi-40">
                                                <p style="color:#a7a7a7">Gender</p>
                                            </td>
                                            <td>
                                                <p>{{$user->userDetails->Gender ?? 'Not Set'}}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row" class="wi-40">
                                                <p style="color:#a7a7a7">Nationality</p>
                                            </td>
                                            <td>
                                                <p>{{$user->userDetails->Nationality ?? 'Not Set'}}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row" class="wi-40">
                                                <p style="color:#a7a7a7">Languages</p>
                                            </td>
                                            <td>
                                                <!-- <p>{{$user->userDetails->Languages ?? 'Not Set'}}</p> -->
                                                <p> {{ $user->userDetails->Languages ? implode(', ', json_decode($user->userDetails->Languages, true) ?? []) : 'Not Set' }} </p>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="card p-3 my-2">
                                <div class="d-flex align-items-baseline">
                                    <i class="fa-solid fa-circle-info fa-2x " style="color: #3da087;margin-right:10px"></i>
                                    <h2>Contact Details</h2>
                                </div>
                                <table class="table">

                                    <tbody>
                                        <tr>
                                            <td scope="row" class="wi-40">
                                                <p style="color:#a7a7a7">Address</p>
                                            </td>
                                            <td>
                                                <p>{{$user->userDetails->address ?? 'Not Set'}}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row" class="wi-40">
                                                <p style="color:#a7a7a7">City</p>
                                            </td>
                                            <td>
                                                <p>{{$user->userDetails->city ?? 'Not Set'}}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row" class="wi-40">
                                                <p style="color:#a7a7a7">Country</p>
                                            </td>
                                            <td>
                                                <p>{{$user->userDetails->country ?? 'Not Set'}}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row" class="wi-40">
                                                <p style="color:#a7a7a7">Postal/Zip Code</p>
                                            </td>
                                            <td>
                                                <p>{{$user->userDetails->postal_code ?? 'Not Set'}}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row" class="wi-40">
                                                <p style="color:#a7a7a7">Phone Number</p>
                                            </td>
                                            <td>
                                                <p>{{$user->userDetails->m_number ?? 'Not Set'}}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row" class="wi-40">
                                                <p style="color:#a7a7a7">Private Email</p>
                                            </td>
                                            <td>
                                                <p>{{$user->userDetails->Private_Email ?? 'Not Set'}}</p>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="card p-3 my-2">
                                <div class="d-flex align-items-baseline">
                                    <i class="fa-solid fa-circle-dollar-to-slot fa-2x " style="color: #3da087;margin-right:10px"></i>
                                    <h2>Job Details</h2>
                                </div>
                                <table class="table">

                                    <tbody>
                                        <tr>
                                            <td scope="row" class="wi-40">
                                                <p style="color:#a7a7a7">Employment Status</p>
                                            </td>
                                            <td>
                                                <p>{{$user->userDetails->Employment_Status ?? 'Not Set'}}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row" class="wi-40">
                                                <p style="color:#a7a7a7">Job Title</p>
                                            </td>
                                            <td>
                                                <p>{{$user->userDetails->job_title ?? 'Not Set'}}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row" class="wi-40">
                                                <p style="color:#a7a7a7">Joined Date</p>
                                            </td>
                                            <td>
                                                <p>{{$user->userDetails->joined_date ?? 'Not Set'}}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row" class="wi-40">
                                                <p style="color:#a7a7a7">Department</p>
                                            </td>
                                            <td>
                                                <p>{{$user->userDetails->Department ?? 'Not Set'}}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="row" class="wi-40">
                                                <p style="color:#a7a7a7">Leave Type</p>
                                            </td>
                                            <td>
                                                <p>{{$user->userDetails->leaveType['name'] ?? 'Not Set'}}</p>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Verification Documents Tab -->
                <div class="tab-pane fade" id="verification-docs" role="tabpanel">
                    <div class="card p-3 my-2">
                        <div class="d-flex align-items-baseline mb-3">
                            <i class="fas fa-folder-open fa-2x" style="color:#3da087;margin-right:10px"></i>
                            <h2>Verification Documents</h2>
                        </div>
                        <div id="container_verificationDocument">
                            <div class="text-center py-5">
                                <i class="fas fa-file-alt fa-5x text-muted mb-4" style="opacity:0.35;"></i>
                                <h3>No Verification Documents</h3>
                                <p class="text-muted mx-auto" style="max-width:480px;">
                                    No verification documents have been uploaded for this employee yet.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Appointment Letter Tab -->
                <div class="tab-pane fade" id="appointment-letter" role="tabpanel">
                    <div class="card p-3 my-2">
                        <div class="d-flex align-items-baseline mb-3">
                            <i class="fas fa-file-signature fa-2x" style="color:#3da087;margin-right:10px"></i>
                            <h2>Appointment Letter</h2>
                        </div>
                        <div id="container_appointmentLetterDocument">
                            <div class="text-center py-5">
                                <i class="fas fa-file-signature fa-5x text-muted mb-4" style="opacity:0.35;"></i>
                                <h3>No Appointment Letter</h3>
                                <p class="text-muted mx-auto" style="max-width:480px;">
                                    No appointment letter has been uploaded for this employee yet.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contract Tab -->
                <div class="tab-pane fade" id="contract" role="tabpanel">
                    <div class="card p-3 my-2">
                        <div class="d-flex align-items-baseline mb-3">
                            <i class="fas fa-file-contract fa-2x" style="color:#3da087;margin-right:10px"></i>
                            <h2>Contract</h2>
                        </div>
                        <div id="container_contractDocument">
                            <div class="text-center py-5">
                                <i class="fas fa-file-contract fa-5x text-muted mb-4" style="opacity:0.35;"></i>
                                <h3>No Contract Uploaded</h3>
                                <p class="text-muted mx-auto" style="max-width:480px;">
                                    No contract has been uploaded for this employee yet.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- NDA Tab -->
                <div class="tab-pane fade" id="nda" role="tabpanel">
                    <div class="card p-3 my-2">
                        <div class="d-flex align-items-baseline mb-3">
                            <i class="fas fa-file-shield fa-2x" style="color:#3da087;margin-right:10px"></i>
                            <h2>NDA</h2>
                        </div>
                        <div id="container_ndaDocument">
                            <div class="text-center py-5">
                                <i class="fas fa-file-shield fa-5x text-muted mb-4" style="opacity:0.35;"></i>
                                <h3>No NDA Uploaded</h3>
                                <p class="text-muted mx-auto" style="max-width:480px;">
                                    No NDA has been uploaded for this employee yet.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Document Viewer Modal -->
                <div class="modal fade" id="documentModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="documentModalLabel">Document Viewer</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center p-0" style="min-height:70vh;background:#f1f1f1;">
                                <iframe id="documentIframe" style="width:100%;height:70vh;border:none;" src=""></iframe>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        var userId = $("#user_id").val();

        var DOC_TYPES = [
            'verificationDocument',
            'appointmentLetterDocument',
            'contractDocument',
            'ndaDocument'
        ];

        var emptyMessages = {
            'verificationDocument': {
                icon: 'fa-file-alt',
                title: 'No Verification Documents',
                text: 'No verification documents have been uploaded for this employee yet.'
            },
            'appointmentLetterDocument': {
                icon: 'fa-file-signature',
                title: 'No Appointment Letter',
                text: 'No appointment letter has been uploaded for this employee yet.'
            },
            'contractDocument': {
                icon: 'fa-file-contract',
                title: 'No Contract Uploaded',
                text: 'No contract has been uploaded for this employee yet.'
            },
            'ndaDocument': {
                icon: 'fa-file-shield',
                title: 'No NDA Uploaded',
                text: 'No NDA has been uploaded for this employee yet.'
            }
        };

        function getFileIcon(fileName) {
            var ext = fileName.split('.').pop().toLowerCase();
            if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].indexOf(ext) > -1) {
                return {
                    label: ext.toUpperCase(),
                    colorClass: 'icon-image'
                };
            }
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
                // Replace this block inside forEach:
                var info = getFileIcon(file.name);
                var preview =
                    '<div class="file-type-icon">' +
                    '<div class="icon-shape ' + info.colorClass + '">' +
                    info.label +
                    '</div>' +
                    '</div>';

                html +=
                    '<div class="doc-thumb-card">' +
                    '<div class="doc-thumb-preview">' + preview + '</div>' +
                    '<div class="doc-thumb-body">' +
                    '<div class="doc-thumb-name" title="' + file.name + '">' + shortenName(file.name) + '</div>' +
                    '<div class="doc-thumb-actions">' +
                    '<a href="javascript:void(0);" class="btn-view-doc" ' +
                    'data-content="' + encodeURIComponent(file.content) + '" ' +
                    'data-name="' + encodeURIComponent(file.name) + '" ' +
                    'title="View">' +
                    '<i class="fas fa-eye"></i> View' +
                    '</a>' +
                    '<a href="' + file.content + '" download="' + file.name + '" title="Download">' +
                    '<i class="fas fa-download"></i> Save' +
                    '</a>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            });

            html += '</div>';
            container.html(html);
        }

        function loadDocs(docType) {
            $.ajax({
                url: "{{ url('get-user-files') }}/" + userId + "/" + docType,
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

        // Load all 4 doc types
        DOC_TYPES.forEach(function(dt) {
            loadDocs(dt);
        });

        // ── Eye icon → modal with blob URL ──
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

        // ── Edit profile redirect ──
        $(document).on('click', '.edit_account', function() {
            var uid = $(this).data('uid');
            window.location.href = "{{ route('HR.employee_edit', ':id') }}".replace(':id', uid);
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