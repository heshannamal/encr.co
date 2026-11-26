{{-- {{ dd($projectType) }} --}}
@extends('layouts.app', ['activePage' => 'project_icons', 'titlePage' => __('Project Icons')])

@section('content')
<style>

#searchbox{
        border: 2px solid #ffffff;
        height: 35px;
        /* width: 250px; */
        width: 100%;
        border-radius: 30px;
        padding: 0px 5px;
        background-color: #ffffff1a;
        margin-top: 10px;
        color: #ffffff;
    }
    #searchbox::placeholder {
        color: #aaaaaa;
        opacity: 1; /* Firefox */
        font-size: 14px;
    }
    #searchbox:focus {
        outline: 0px;
    }
    #searchbox:-ms-input-placeholder { /* Internet Explorer 10-11 */
        color: #aaaaaa;
    }
    #searchbox::-ms-input-placeholder { /* Microsoft Edge */
        color: #aaaaaa;
    }
    .btn-text {
        font-size: small;
        position: relative;
        top: -2px;
        right: -8px;
    }
    .content-position {
        position: relative;
        top: -47px;
    }
    .add-project-btn {
        position: relative;
        right: -66px;
    }
    .add-btn-text {
        position: relative;
        right: -13px;
    }
    .btns-text {
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
    }
    .btns-text:hover {
        color: #909090 ;
    }
    .btns-style {
        width: 100%;
        height: 100%;
        background-color: #909090;
        border: unset;
        border-radius: 5px;
    }
    .btns-card:hover {
        background-color: #ffffff
    }
    .btns-padding {
        padding-left: 0.2rem;
        padding-right: 0.2rem;
    }
    .btns-right-position {
        position: relative;
        right: 14px;
    }
    .btn-top {
        position: relative;
        top: 11px;
    }
    .edit-item-label {
        width: 50% !important;
        position: relative;
        top: 6px;
    }
    .new-style-table table.dataTable thead .sorting:before,table.dataTable thead .sorting_asc:before,table.dataTable thead .sorting_desc:before,table.dataTable thead .sorting_asc_disabled:before,table.dataTable thead .sorting_desc_disabled:before {
        content: "\f0de";
        font-family: FontAwesome;
    }
    .new-style-table table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:after,table.dataTable thead .sorting_asc_disabled:after,table.dataTable thead .sorting_desc_disabled:after {
        content: "\f0dd";
        font-family: FontAwesome;
        right: .65rem !important;
    }
    .new-style-table table thead tr{
        background-color: grey;
        color: white;
        height: 40px;
        font-size: .7rem;
    }
    .new-style-table table tr{
        background-color: white;
        color: grey;
        min-height: 40px;
        font-size: .7rem;
        border-bottom: 1px solid #b3b3b3;
        border-top: 1px solid #e9ecef !important;
    }
    .new-style-table table tbody tr:hover{
        background-color: #f6f6ff;
    }
    .new-style-table th, .new-style-table td {
        padding: 10px;
        vertical-align: middle !important;
    }
    .new-style-table .dataTables_info {
        color:#b3b3b3;
    }
    .card{
        background-color: white;
        border: none;
        border-radius: 0rem;
    }
    .styled-button{
        outline: unset;
        color: #d3d3d3;
        background-color: #fafafa;;
        border: 1px solid #d3d3d3;
        padding: .3rem;
        padding-left: .7rem;
        padding-right: .7rem;
        margin: 0rem;
        cursor: pointer;
    }
    .page-item .page-link, .page-item span {
        border-radius: 0 !important;
        font-size: 0.7rem;
    }
    .page-item.active .page-link {
        z-index: 1;
        color: grey;
        border-color: #cccccc;
        background-color: #e9e9e9;
        box-shadow:none;
    }
    .btn-green-filled{
        outline: unset !important;
        color: white;
        background-color: #47D6B6;
        border: 2px solid #47D6B6;
        font-weight: 700;
        font-size: .7rem;
        cursor: pointer;
        padding: .4rem;
        padding-left: 1rem;
        padding-right: 1rem;
    }
    .new-style-table table thead tr{
        background-color: rgba(50, 50, 50, 1) !important;
    }
    .new-style-table .table tbody td , .new-style-table .table tbody td a {
        padding: 0.4rem 1rem !important;
        font-size: .9rem !important;
        color: rgba(22, 22, 23, 1) !important;
    }
    .trash_btn {
        color: rgb(255, 136, 136);
        cursor: pointer;
    }
    .edit_btn {
        color: rgb(136, 148, 255);
        cursor: pointer;
    }
    .delete-icon {
        padding: 5px 8px;
        border: none;
    }
    .edit-icon {
        padding: 5px 8px;
        border: none;
    }
    body {
        font-family: 'Open Sans', 'sans-serif' !important;
    }

    /* MOBILE RESPONSIVE STYLES (max-width: 768px) */
    @media (max-width: 768px) {

        body {
            background-color: #f8fafc !important;
        }

        /* Page wrapper */
        .content-position {
            position: relative !important;
            top: 0 !important;
            padding: 12px 16px 30px 16px !important;
        }

        /* ADD PROJECT ICONS button row — full width on mobile */
        .content-position > .row.col-md-12 {
            display: block !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 0 12px 0 !important;
        }

        .content-position > .row.col-md-12 .col-md-4 {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            text-align: left !important;
        }

        /* Card container */
        .card {
            background-color: transparent !important;
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            margin-top: 0 !important;
        }

        .col-md-12 {
            padding: 0 !important;
        }

        /* ── +Add Project Icons button ── */
        .btn-green-filled {
            display: flex !important;
            width: 100% !important;
            height: 44px !important;
            background-color: #14B8A6 !important;
            border: none !important;
            border-radius: 12px !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: 0 2px 8px rgba(20,184,166,0.25) !important;
            cursor: pointer !important;
            margin: 0 0 14px 0 !important;
            order: 2 !important;
        }

        .btn-green-filled:hover,
        .btn-green-filled:active {
            background-color: #0d9488 !important;
            color: #ffffff !important;
        }

        /* Showing N entries info */
        .dataTables_info,
        .new-style-table .dataTables_info {
            font-size: 13.5px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            padding: 0 4px 10px 4px !important;
            margin: 0 !important;
            order: 3 !important;
        }

        /* ── Table → Card list ── */
        .col-md-12.new-style-table {
            padding: 0 !important;
            order: 4 !important;
        }

        .table-responsive {
            overflow: visible !important;
            border: none !important;
            margin: 0 !important;
        }

        #user_groups_table {
            display: block !important;
            width: 100% !important;
            border: none !important;
            background: transparent !important;
        }

        /* Hide table header on mobile */
        #user_groups_table thead {
            display: none !important;
        }

        .new-style-table table tr {
            border-bottom: none !important;
            border-top: none !important;
            background-color: transparent !important;
        }

        .new-style-table table tbody tr:hover {
            background-color: transparent !important;
        }

        .new-style-table th,
        .new-style-table td {
            padding: 0 !important;
            vertical-align: top !important;
        }

        .new-style-table .table tbody td,
        .new-style-table .table tbody td a {
            padding: 0 !important;
            font-size: inherit !important;
        }

        /* tbody: flex column of cards */
        #user_groups_table tbody {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            width: 100% !important;
        }

        /* Each row = white card matching */
        #user_groups_table tbody tr {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            position: relative !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 18px !important;
            padding: 14px 16px !important;
            box-shadow: 0 1px 4px rgba(0,0,0,0.03) !important;
            box-sizing: border-box !important;
            width: 100% !important;
            min-height: 0 !important;
            cursor: pointer !important;
            transition: box-shadow 0.2s ease !important;
        }

        #user_groups_table tbody tr td {
            border: none !important;
            padding: 0 !important;
            background: transparent !important;
        }

        /* Project Icon Thumbnail cell */
        #user_groups_table tbody tr td.type {
            order: 1 !important;
            width: auto !important;
            display: flex !important;
            align-items: center !important;
            position: static !important;
            margin-right: 14px !important;
            flex-shrink: 0 !important;
        }

        #user_groups_table tbody tr td.type a.edit {
            display: inline-block !important;
            text-decoration: none !important;
        }

        #user_groups_table tbody tr td.type a.edit img {
            width: 44px !important;
            height: 44px !important;
            border-radius: 50% !important;
            /* object-fit: contain !important; */
            display: block !important;
        }

        /* Invisible overlay covering the Edit pill area on top-right of card */
        #user_groups_table tbody tr td.type a.edit::after {
            content: "" !important;
            position: absolute !important;
            top: 0 !important;
            right: 0 !important;
            width: 120px !important;
            height: 100% !important;
            z-index: 5 !important;
            cursor: pointer !important;
        }

        /* "Created YYYY-MM-DD" label to the right of the icon */
        #user_groups_table tbody tr td:nth-child(2) {
            order: 2 !important;
            display: flex !important;
            align-items: center !important;
            width: auto !important;
            flex: 1 !important;
            margin-top: 0 !important;
            padding-right: 80px !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            color: #1F2933 !important;
            padding-left: 0 !important;
            box-sizing: border-box !important;
        }

        /* Insert "Created " label before the date text */
        #user_groups_table tbody tr td:nth-child(2)::before {
            content: "Created " !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            margin-right: 4px !important;
        }

        /* ── Edit pill button — absolute right of card ── */
        #user_groups_table tbody tr::after {
            content: "Edit" !important;
            position: absolute !important;
            top: 50% !important;
            right: 16px !important;
            transform: translateY(-50%) !important;
            height: 28px !important;
            display: inline-flex !important;
            align-items: center !important;
            padding: 0 12px 0 28px !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 10px !important;
            background: #ffffff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%23334155' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7'/><path d='M18.5 2.5a2.1 2.1 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z'/></svg>") 9px center no-repeat !important;
            color: #334155 !important;
            font-family: 'Open Sans', sans-serif !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03) !important;
            pointer-events: none !important;
        }

        #icon_create_modal .modal-dialog,
        #icon_edit_modal .modal-dialog {
            margin: 16px auto !important;
            max-width: calc(100% - 32px) !important;
        }

        #icon_create_modal .modal-content,
        #icon_edit_modal .modal-content {
            border-radius: 24px !important;
            border: 1px solid #f1f5f9 !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
            background: #ffffff !important;
            overflow: hidden !important;
        }

        #icon_create_modal .modal-header,
        #icon_edit_modal .modal-header {
            padding: 22px 24px 18px 24px !important;
            border-bottom: 1px solid #eef2f6 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            background: #ffffff !important;
        }

        #icon_create_modal .modal-title {
            font-size: 20px !important;
            font-weight: 800 !important;
            color: #111827 !important;
            margin: 0 !important;
            letter-spacing: -0.3px !important;
        }

        /* In edit.blade.php the title says "Edit Sport" in HTML; change to "Edit Icon" via CSS on mobile */
        #icon_edit_modal .modal-title {
            font-size: 0 !important;
            margin: 0 !important;
            line-height: 1 !important;
        }

        #icon_edit_modal .modal-title::before {
            content: "Edit Icon" !important;
            font-size: 20px !important;
            font-weight: 800 !important;
            color: #111827 !important;
            letter-spacing: -0.3px !important;
            display: block !important;
        }

        #icon_create_modal .modal-header button.close,
        #icon_edit_modal .modal-header button.close {
            font-size: 24px !important;
            color: #94a3b8 !important;
            opacity: 1 !important;
            padding: 0 !important;
            margin: 0 !important;
            background: transparent !important;
            border: none !important;
            line-height: 1 !important;
            outline: none !important;
            font-weight: 300 !important;
        }

        #icon_create_modal .modal-body,
        #icon_edit_modal .modal-body {
            padding: 20px 24px 10px 24px !important;
            background: #ffffff !important;
            position: relative !important;
        }

        /* Reset modal layout */
        #icon_create_modal .modal-body .col-md-12,
        #icon_edit_modal .modal-body .col-md-12 {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
        }

        #icon_create_modal .modal-body .row,
        #icon_edit_modal .modal-body .row {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            display: block !important;
            position: relative !important;
        }

        /* ── FIELD: Project Icon Card Container ── */
        #icon_create_modal .modal-body .col-md-8.form-field.mt-5,
        #icon_edit_modal .modal-body .col-md-8.form-field.mt-5 {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            display: block !important;
            margin-top: 0 !important;
            margin-bottom: 20px !important;
            position: relative !important;
            padding: 0 !important;
        }

        /* Label: Project Icon Image */
        #icon_create_modal .modal-body .col-md-8.form-field.mt-5 label.form-lable,
        #icon_edit_modal .modal-body .col-md-8.form-field.mt-5 label.form-lable {
            font-size: 0 !important;
            display: block !important;
            width: 100% !important;
            margin: 0 0 4px 0 !important;
            padding: 0 !important;
            line-height: 1.3 !important;
        }

        #icon_create_modal .modal-body .col-md-8.form-field.mt-5 label.form-lable::before,
        #icon_edit_modal .modal-body .col-md-8.form-field.mt-5 label.form-lable::before {
            content: "Project Icon Image" !important;
            display: block !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            white-space: nowrap !important;
            margin-bottom: 4px !important;
        }

        /* Red resolution note */
        #icon_create_modal .modal-body .col-md-8.form-field.mt-5 label.form-lable::after {
            content: "Maximum file size: 1MB with a resolution of 96px X 96px" !important;
            display: block !important;
            color: #ef4444 !important;
            font-size: 11px !important;
            font-weight: 400 !important;
            white-space: nowrap !important;
            margin: 0 0 10px 0 !important;
        }

        #icon_edit_modal .modal-body .col-md-8.form-field.mt-5 label.form-lable::after {
            content: "Maximum file size: 1MB with a resolution of 300px x 343px" !important;
            display: block !important;
            color: #ef4444 !important;
            font-size: 11px !important;
            font-weight: 400 !important;
            white-space: nowrap !important;
            margin: 0 0 10px 0 !important;
        }

        /* Outer Rounded Box for Upload card */
        #icon_create_modal .modal-body .col-md-8.form-field.mt-5::after,
        #icon_edit_modal .modal-body .col-md-8.form-field.mt-5::after {
            content: "" !important;
            display: block !important;
            width: 100% !important;
            height: 140px !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 16px !important;
            box-sizing: border-box !important;
        }

        /* Upload button pill on the left inside the box */
        #icon_create_modal .modal-body .col-md-8.form-field.mt-5::before,
        #icon_edit_modal .modal-body .col-md-8.form-field.mt-5::before {
            content: "Upload" !important;
            position: absolute !important;
            left: 36px !important;
            bottom: 48px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 82px !important;
            height: 40px !important;
            border: 1.5px solid #2563eb !important;
            border-radius: 12px !important;
            color: #2563eb !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            background: #ffffff !important;
            pointer-events: none !important;
            z-index: 2 !important;
        }

        /* Transparent file input overlay over the Upload pill */
        #icon_create_modal input#new_project_icon,
        #icon_edit_modal input#edit_project_icon {
            position: absolute !important;
            left: 36px !important;
            bottom: 48px !important;
            width: 82px !important;
            height: 40px !important;
            opacity: 0 !important;
            cursor: pointer !important;
            z-index: 5 !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Preview container on the right inside the card */
        #icon_create_modal .modal-body .col-md-4.form-field.mt-5,
        #icon_edit_modal .modal-body .col-md-4.form-field.mt-5 {
            position: absolute !important;
            right: 10px !important;
            bottom: 17px !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 110px !important;
            height: 110px !important;
            z-index: 4 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        #new_image_container,
        #edit_image_container {
            width: 110px !important;
            height: 110px !important;
            margin: 0 !important;
            border: 1.5px dashed #cbd5e1 !important;
            border-radius: 16px !important;
            background-color: #f8fafc !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            overflow: hidden !important;
            box-sizing: border-box !important;
        }

        #new_image_preview,
        #edit_image_preview {
            max-width: 90px !important;
            max-height: 90px !important;
            /* object-fit: contain !important; */
            display: block !important;
            border-radius: 50% !important;
        }

        /* Placeholder icon inside dashed box */
        #new_image_preview[src*="placeholder"],
        #edit_image_preview[src*="placeholder"],
        #edit_image_preview:not([src]) {
            width: 32px !important;
            height: 32px !important;
            border-radius: 0 !important;
            object-fit: contain !important;
        }

        /* Modal footer */
        #icon_create_modal .modal-footer,
        #icon_edit_modal .modal-footer {
            padding: 16px 24px 24px 24px !important;
            border-top: none !important;
            background: #ffffff !important;
        }

        /* Button row */
        #icon_create_modal .control-btns,
        #icon_edit_modal .control-btns {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 10px !important;
            width: 100% !important;
            padding: 0 !important;
        }

        #icon_create_modal .control-btns .btn,
        #icon_edit_modal .control-btns .btn {
            flex: 1 1 0 !important;
            height: 50px !important;
            border-radius: 12px !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            border: none !important;
            box-shadow: none !important;
            margin: 0 !important;
            cursor: pointer !important;
        }

        /* Cancel button — grey */
        #icon_create_modal .control-btns .btn-secondary,
        #icon_edit_modal .control-btns .btn-secondary {
            background-color: #94a3b8 !important;
            color: #ffffff !important;
            /* order: 2 !important; */
        }
    }
</style>

<div class="container-fluid content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>PROJECT ICONS</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="row col-md-12 mb-3" style="padding: 0rem;">
        <div class="col-md-4 ml-auto text-right mt-3">
            @if (Gate::check('add project icon'))
                <button class="btn-green-filled" style="outline: unset;" href="#"  data-toggle="modal" data-target="#icon_create_modal" title="Add New Project Icon">
                    <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD ICON
                </button>
            @endif
        </div>
    </div>

    {{-- <div class="col-md-12 btn-top">
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3 btns-right-position">
                <div class="row">
                    <div class="col-md-6 btns-padding"></div>
                    <div class="col-md-6 btns-padding btn_set1">
                        @if (Gate::check('add sport'))
                            <button class="btns-text btns-style btns-card" style="outline: unset;" href="#"  data-toggle="modal" data-target="#icon_create_modal" title="Add New Sport">
                                Add Sport
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div> --}}


    <div class="col-md-12 mt-4">
        <div class="card">
                <div class="col-md-12 new-style-table">
                    <div class="table-responsive mt-3 mb-3">
                        <table class="table align-items-center" id="user_groups_table">
                            <thead>
                                <tr>
                                    <th class="user-group-name" scope="col">Project Icon</th>
                                    <th class="narration" scope="col">Created by</th>
                                    {{-- <th class="action" scope="col">Action</th> --}}
                                </tr>
                            </thead>

                            <tbody class="list" id="tableBody">
                                @foreach ($projectIcons as $projectIcon)
                                    <tr class="edit-row">
                                        <td class="type">
                                            <a href="javascript:void(0);" class="edit" data-value="{{ $projectIcon->id}}">
                                                <img src="{{ asset($projectIcon->icon) }}" alt="Project Icon" style="width:50px; height:50px;">
                                            </a>
                                        </td>
                                        <td class="">{{ $projectIcon->created_at->format('m-d-Y') }}</td>
                                        {{-- <td>
                                            <button type="button" class="btn btn-sm edit-icon" style="background: none;"  data-id="{{ $projectIcon->id }}" data-toggle="tooltip" data-placement="bottom" title="Edit this icon"><i class="fa fas fa-pencil edit_btn"></i> </button>
                                            <button type="button" class="btn btn-sm delete-icon" style="background: none;"  data-id="{{ $projectIcon->id }}" data-toggle="tooltip" data-placement="bottom" title="Delete this icon"><i class="fa fas fa-trash trash_btn"></i> </button>
                                        </td> --}}
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>

                </div>
        </div>
    </div>

</div>
@include('pages.masters.project_icons.create')
@include('pages.masters.project_icons.edit')

<script>

    $("body").on("click", ".edit", function(){
        var iconId = $(this).data('value');
        $('#project_icon_id').val(iconId);
        $('#icon_edit_modal').modal('show');
    });

// $(document).ready(function() {
//   // Click event handler for table rows
//   $('.edit-row').click(function() {
//     // Get the data values from the clicked row
//     var sportId = $(this).find('.edit').data('value');
//     var sportName = $(this).find('.sport-name').text();
//     var sportImg = $(this).find('.sport_image').val();

//     // Set the values in the edit modal
//     $('#sport_id').val(sportId);
//     $('#sport_edit_name').val(sportName);

//     // Display the image in the modal
//     $('#new_image_preview').attr('src', sportImg);
//     $('#new_image_preview').attr('alt', 'Sport Image');

//     // Show the edit modal
//     $('#icon_edit_modal').modal('show');
//   });
// });

</script>

@endsection
