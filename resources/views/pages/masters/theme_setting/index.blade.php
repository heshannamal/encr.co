@extends('layouts.app', ['activePage' => 'theme_setting', 'titlePage' => __('Theme Setting')])

@section('content')


<style>
    .content-position {
        position: relative;
        top: -47px;
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
    .btn-inside-table button{
        width: 100% !important;
        font-size: .7rem !important;
        height: 2.1rem;
        font-size: .7rem !important;
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
        border-bottom: 1px solid #d7d7d7;
        border-top: 1px solid #d7d7d7 !important;
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
    .new-style-table table thead tr{
        background-color: rgba(50, 50, 50, 1) !important;
    }
    .new-style-table .table tbody td , .new-style-table .table tbody td a {
        padding: 0.4rem 1rem !important;
        font-size: .9rem !important;
        color: rgba(22, 22, 23, 1) !important;
    }
    .form-input {
        width: 100%;
    }

    /* MOBILE RESPONSIVE STYLES (max-width: 768px) */
    @media (max-width: 768px) {
        body { background-color: #f8fafc !important; }

        .content-position {
            position: relative !important;
            top: 0 !important;
            padding: 12px 16px 30px !important;
        }

        /* Search inputs */
        #searchbox,
        .dataTables_filter input {
            display: block !important;
            width: 100% !important;
            height: 48px !important;
            border-radius: 14px !important;
            border: 1px solid #e2e8f0 !important;
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'%3E%3C/circle%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'%3E%3C/line%3E%3C/svg%3E") no-repeat 14px center !important;
            padding: 10px 16px 10px 44px !important;
            font-size: 14px !important;
            color: #334155 !important;
            box-sizing: border-box !important;
            box-shadow: 0 1px 3px rgba(0,0,0,.03) !important;
            outline: none !important;
            margin: 0 !important;
        }
        #searchbox { margin-bottom: 14px !important; }
        #searchbox::placeholder,
        .dataTables_filter input::placeholder { color: #94a3b8 !important; font-size: 14px !important; }

        /* Wrappers */
        .card {
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            margin-top: 0 !important;
        }
        .col-md-12 { padding: 0 !important; }
        .card > .col-md-4.ml-auto {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 0 14px !important;
        }

        /* Add button */
        table.btn-inside-table,
        table.btn-inside-table tbody,
        table.btn-inside-table tr { display: block !important; width: 100% !important; }
        table.btn-inside-table td:not(:last-child) { display: none !important; }
        table.btn-inside-table td:last-child { display: block !important; width: 100% !important; padding: 0 !important; }

        .btn-green-filled {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            height: 44px !important;
            margin: 0 !important;
            background: #14B8A6 !important;
            border: none !important;
            border-radius: 12px !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #fff !important;
            box-shadow: 0 2px 8px rgba(20,184,166,.25) !important;
        }
        .btn-green-filled:hover,
        .btn-green-filled:active { background: #0d9488 !important; color: #fff !important; }

        /* DataTables layout */
        .dataTables_wrapper { display: flex !important; flex-direction: column !important; width: 100% !important; padding: 0 !important; }
        .dataTables_wrapper .row { margin: 0 !important; width: 100% !important; }
        .dataTables_wrapper .row > [class*="col-"] {
            padding: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }
        .dataTables_filter { order: 1 !important; width: 100% !important; margin: 0 0 14px !important; float: none !important; text-align: left !important; }
        .dataTables_filter label {
            display: block !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            font-size: 0 !important;
            color: transparent !important;
        }
        .dataTables_length { display: none !important; }
        .dataTables_info,
        .new-style-table .dataTables_info {
            order: 3 !important;
            margin: 0 !important;
            padding: 0 4px 12px 4px !important;
            font-size: 13.5px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
        }

        /* Table → cards */
        .col-md-12.new-style-table { padding: 0 !important; order: 4 !important; }
        .table-responsive { overflow: visible !important; border: none !important; margin: 0 !important; }
        #theme_table { display: block !important; width: 100% !important; border: none !important; background: transparent !important; }
        #theme_table thead { display: none !important; }
        #theme_table tbody { display: flex !important; flex-direction: column !important; gap: 14px !important; width: 100% !important; }

        #theme_table tbody tr {
            display: flex !important;
            flex-wrap: wrap !important;
            position: relative !important;
            width: 100% !important;
            min-height: 0 !important;
            padding: 16px 18px !important;
            background: #fff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 20px !important;
            box-shadow: 0 1px 4px rgba(0,0,0,.03) !important;
            box-sizing: border-box !important;
            cursor: pointer !important;
        }
        #theme_table tbody tr td {
            border: none !important;
            padding: 0 !important;
            background: transparent !important;
            vertical-align: top !important;
            font-size: inherit !important;
        }

        /* Name */
        #theme_table td.tagline-name { order: 1 !important; display: block !important; width: 100% !important; position: relative !important; }
        #theme_table td.tagline-name a.edit {
            display: block !important;
            /* min-height: 38px !important; */
            padding: 10px 80px 0 0 !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            line-height: 1.3 !important;
            color: #1F2933 !important;
            text-decoration: none !important;
            word-break: break-word !important;
            white-space: normal !important;
        }
        /* Click overlay so the Edit pill opens the modal */
        #theme_table td.tagline-name a.edit::after {
            content: "" !important;
            position: absolute !important;
            top: -16px !important;
            right: -18px !important;
            width: 120px !important;
            height: 54px !important;
            z-index: 5 !important;
        }

        /* Action */
        #theme_table td.tagline-action {
            order: 2 !important;
            display: block !important;
            width: 100% !important;
            margin: 1px 0 14px !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            color: #6B7280 !important;
        }
        #theme_table td.tagline-action::before { content: "Theme Action  " !important; }

        /* Edit pill */
        #theme_table tbody tr::after {
            content: "Edit" !important;
            position: absolute !important;
            top: 18px !important;
            right: 18px !important;
            height: 32px !important;
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

        /* Created / Updated boxes */
        #theme_table td.created-at,
        #theme_table td.updated-at {
            flex: 1 1 0 !important;
            min-width: 0 !important;
            display: flex !important;
            align-items: center !important;
            position: relative !important;
            padding: 22px 12px 8px !important;
            background: #f1f5f9 !important;
            border-radius: 14px !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            color: #1F2933 !important;
            box-sizing: border-box !important;
        }
        #theme_table td.created-at { order: 3 !important; margin-right: 10px !important; }
        #theme_table td.updated-at { order: 4 !important; }

        #theme_table td.created-at::before,
        #theme_table td.updated-at::before {
            font-family: FontAwesome !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            flex-shrink: 0 !important;
            width: 36px !important;
            height: 36px !important;
            margin: -14px 10px 0 0 !important;
            background: #fff !important;
            border-radius: 10px !important;
            color: #1e293b !important;
            font-size: 15px !important;
            box-shadow: 0 1px 2px rgba(0,0,0,.05) !important;
        }
        #theme_table td.created-at::before { content: "\f073" !important; }
        #theme_table td.updated-at::before { content: "\f017" !important; font-size: 16px !important; }

        #theme_table td.created-at::after,
        #theme_table td.updated-at::after {
            white-space: pre !important;
            position: absolute !important;
            left: 58px !important;
            top: 8px !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            pointer-events: none !important;
        }
        #theme_table td.created-at::after { content: "Created\A" !important; }
        #theme_table td.updated-at::after { content: "Last Updated\A" !important; }

        /* Pagination */
        .dataTables_paginate { display: flex !important; justify-content: center !important; width: 100% !important; margin-top: 16px !important; order: 5 !important; }
        .dataTables_paginate ul.pagination { display: flex !important; flex-wrap: wrap !important; gap: 4px !important; }
        .dataTables_paginate .page-item .page-link,
        .dataTables_paginate .page-item span {
            padding: 6px 12px !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            background: #fff !important;
            color: #475569 !important;
            font-size: 13px !important;
        }
        .dataTables_paginate .page-item.active .page-link {
            background: #14B8A6 !important;
            border-color: #14B8A6 !important;
            color: #fff !important;
            font-weight: 700 !important;
        }

        /* ── Modals (create + edit) ── */
        [id^="theme_setting_"][id$="_modal"] .modal-dialog { margin: 16px auto !important; max-width: calc(100% - 32px) !important; }
        [id^="theme_setting_"][id$="_modal"] .modal-content {
            background: #fff !important;
            border: 1px solid #f1f5f9 !important;
            border-radius: 24px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,.08) !important;
            overflow: hidden !important;
        }
        [id^="theme_setting_"][id$="_modal"] .modal-header {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 22px 24px 18px !important;
            background: #fff !important;
            border-bottom: 1px solid #eef2f6 !important;
        }
        [id^="theme_setting_"][id$="_modal"] .modal-title {
            margin: 0 !important;
            font-size: 20px !important;
            font-weight: 800 !important;
            letter-spacing: -.3px !important;
            color: #111827 !important;
        }
        [id^="theme_setting_"][id$="_modal"] .modal-header button.close {
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            outline: none !important;
            opacity: 1 !important;
            font-size: 24px !important;
            font-weight: 300 !important;
            line-height: 1 !important;
            color: #94a3b8 !important;
        }
        [id^="theme_setting_"][id$="_modal"] .modal-body { padding: 20px 24px 10px !important; background: #fff !important; }
        [id^="theme_setting_"][id$="_modal"] .modal-body .col-md-12 { width: 100% !important; padding: 0 !important; margin: 0 0 16px !important; display: block !important; }
        [id^="theme_setting_"][id$="_modal"] label.form-label {
            display: block !important;
            width: 100% !important;
            margin-bottom: 8px !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
        }

        #new_theme_setting_name,
        #edit_theme_setting {
            display: block !important;
            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
            height: 52px !important;
            padding: 10px 16px !important;
            background: #fff !important;
            border: 1.5px solid #d1d5db !important;
            border-radius: 14px !important;
            font-size: 15px !important;
            font-weight: 500 !important;
            color: #111827 !important;
            box-shadow: none !important;
            outline: none !important;
            box-sizing: border-box !important;
        }
        #new_theme_setting_name::placeholder { color: #94a3b8 !important; font-size: 15px !important; }

        /* Theme Action row: label + toggle inline */
        [id^="theme_setting_"][id$="_modal"] .modal-body .mt-3 {
            display: flex !important;
            align-items: center !important;
            gap: 16px !important;
            margin: 14px 0 10px !important;
        }
        [id^="theme_setting_"][id$="_modal"] .modal-body .mt-3 br { display: none !important; }
        [id^="theme_setting_"][id$="_modal"] .modal-body .mt-3 label.form-label { display: inline-block !important; width: auto !important; margin-bottom: 0 !important; }

        .switch, .switchEdit { width: 52px !important; height: 30px !important; margin: 0 !important; flex-shrink: 0 !important; }
        .slider, .sliderEdit { border-radius: 30px !important; background-color: #e2e8f0 !important; }
        .slider:before, .sliderEdit:before {
            width: 24px !important;
            height: 24px !important;
            left: 3px !important;
            bottom: 3px !important;
            box-shadow: 0 1px 3px rgba(0,0,0,.15) !important;
        }
        input:checked + .slider,
        input:checked + .sliderEdit { background-color: #14b8a6 !important; }
        input:checked + .slider:before,
        input:checked + .sliderEdit:before { transform: translateX(22px) !important; }

        /* Footer + buttons */
        [id^="theme_setting_"][id$="_modal"] .modal-footer,
        [id^="theme_setting_"][id$="_modal"] .card-footer { padding: 16px 24px 24px !important; border-top: none !important; background: #fff !important; }
        [id^="theme_setting_"][id$="_modal"] .control-btns { display: flex !important; align-items: center !important; gap: 10px !important; width: 100% !important; padding: 0 !important; }
        [id^="theme_setting_"][id$="_modal"] .control-btns .btn {
            flex: 1 1 0 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            height: 50px !important;
            margin: 0 !important;
            border: none !important;
            border-radius: 12px !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            color: #fff !important;
            box-shadow: none !important;
        }
        [id^="theme_setting_"][id$="_modal"] .btn-secondary { background: #94a3b8 !important; }
        [id^="theme_setting_"][id$="_modal"] .btn-success   { background: #16a34a !important; }
        [id^="theme_setting_"][id$="_modal"] .btn-danger    { background: #dc2626 !important; }
    }
</style>

<div class="container-fluid mb-5 content-position">
    {{-- <div class="se-pre-con"></div> --}}

    @section('order-header')
        <span>THEME SETTINGS</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="row col-md-12" style="padding: 0rem;">
        <div class="col-md-4 ml-auto text-right mt-3">

        </div>
    </div>

    <div class="col-md-12">
        <div class="card" style="border: unset;">

                <div class="col-md-4 ml-auto mb-2 mt-2">
                    <table class="btn-inside-table" style="width: 100%">
                        <tr>
                            <td style="width: 10%"></td>
                            <td>
                                {{-- <button class="styled-button" style="outline: unset;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                                    Table Layout
                                </button> --}}
                            </td>
                            <td>
                                <button class="btn-green-filled" style="outline: unset;" href="#" data-toggle="modal" data-target="#theme_setting_create_modal" title="Add New Theme Settings">
                                    <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD THEME SETTINGS
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-12 new-style-table">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="theme_table">
                            <thead>
                                <th class="tagline-name" scope="col">Theme Name</th>
                                <th class="tagline-name" scope="col">Theme Action</th>
                                <th class="created-at" scope="col">Created At</th>
                                <th class="updated-at" scope="col">Updated At</th>
                            </thead>

                            <!-- <tbody class="list"> -->

                                <tbody class="list">
                                    @foreach ($themeActions as $themeAction)
                                    <tr>
                                        <td class="tagline-name"><a href="#" class="edit" data-value="{{$themeAction->id}}">{{$themeAction->theme_name}}</a></td>
                                        <td class="tagline-action">{{$themeAction->action}}</td>
                                        <td class="created-at">{{$themeAction->created_at->format('m-d-Y')}}</td>
                                        <td class="updated-at">{{$themeAction->updated_at->format('m-d-Y')}}</td>
                                    </tr>
                                    @endforeach
                                <!-- </tbody> -->

                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>

</div>

@include('pages.masters.theme_setting.create')
@include('pages.masters.theme_setting.edit')

<script>

    $(document).ready(function() {
        // Attach the click event for edit buttons
        setupEditButtonClick();
    });

    function setupEditButtonClick() {
        $("body").on("click", ".edit", handleEditClick);
    }

    function handleEditClick() {
        var productTaglineId = $(this).data('value');
        console.log(productTaglineId);

        // Set the value in the hidden input field and show the modal
        $('#theme_setting_id').val(productTaglineId);
        $('#theme_setting_edit_modal').modal('show');
    }

</script>

<script>
$(document).ready(function () {
    $('#theme_table').DataTable({
        order: [],
        pageLength: 10,
        language: {
            search: '',
            searchPlaceholder: 'Search theme settings...'
        }
    });

    $('body').on('click', '.edit', function (e) {
        e.preventDefault();
        $('#theme_setting_id').val($(this).data('value'));
        $('#theme_setting_edit_modal').modal('show');
    });
});
</script>
@endsection
