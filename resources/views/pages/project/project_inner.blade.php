<!-- project_inner.blade.php -->

@extends('layouts.app', ['activePage' => 'projects', 'titlePage' => __('Project Inner')])

@section('content')
<style>
    .project-inner-title {
        display: flex;
        align-items: center;
        font-size: 1.5rem;
        font-weight: 700;
        gap: 12px;
    }

    .modern-stage-select {
        appearance: none;
        padding: 4px 28px 4px 12px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid transparent;
        cursor: pointer;
        outline: none;
        transition: all 0.2s ease;
        background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2212%22%20height%3D%2212%22%20fill%3D%22currentColor%22%20class%3D%22bi%20bi-chevron-down%22%20viewBox%3D%220%200%2016%2016%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M1.646%204.646a.5.5%200%200%201%20.708%200L8%2010.293l5.646-5.647a.5.5%200%200%201%20.708.708l-6%206a.5.5%200%200%201-.708%200l-6-6a.5.5%200%200%201%200-.708z%22%2F%3E%3C%2Fsvg%3E');
        background-repeat: no-repeat;
        background-position: right 8px center;
        background-size: 10px;
    }
    .modern-stage-select:hover {
        filter: brightness(0.95);
    }

    .stage-discussion { background-color: #e3f2fd; color: #1976d2; border-color: #bbdefb; }
    .stage-ui-ux-design { background-color: #f3e5f5; color: #7b1fa2; border-color: #e1bee7; }
    .stage-planning { background-color: #e8eaf6; color: #3f51b5; border-color: #c5cae9; }
    .stage-under-development { background-color: #fff3e0; color: #f57c00; border-color: #ffe0b2; }
    .stage-sampling { background-color: #e0f7fa; color: #00838f; border-color: #b2ebf2; }
    .stage-testing { background-color: #e8f5e9; color: #388e3c; border-color: #c8e6c9; }
    .stage-live { background-color: #ffebee; color: #d32f2f; border-color: #ffcdd2; }
    .stage-default { background-color: #f5f5f5; color: #616161; border-color: #e0e0e0; }

    .project-inner-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #fff;
        margin-right: -8px;
        box-shadow: 0 0 0 1px #bbb;
    }
    .project-inner-user-group {
        display: flex;
        align-items: center;
        gap: 0.2rem;
    }
    .project-inner-user-group .project-inner-avatar {
        border: 2px solid #fff;
        margin-left: -8px;
    }
    .project-inner-back-btn {
        border: 1px solid #313131;
        border-radius: 20px;
        padding: 4px 18px;
        background: #fff;
        color: #313131;
        font-size: 13px;
        margin-left: 18px;
        transition: background 0.2s;
    }
    .project-inner-back-btn:hover {
        background: #f5f5f5;
    }
    .project-inner-add-task, .project-inner-add-section {
        color: #888;
        font-size: 1rem;
        cursor: pointer;
        padding: 6px 0 6px 32px;
        display: block;
    }
    .project-inner-add-section {
        font-size: 1.1rem;
        font-weight: 500;
        color: #bbb;
        padding-left: 0;
    }
    /* .project-inner-tabs {
        background-color: #323232;
    } */
    .inner_tab {
        border: none!important;
        background-color: transparent !important;
        color: Black;
        font-size: 1rem;
    }
    .project-management-nav .nav-item .nav-link.active {
        color: black !important;
        border-bottom: 2px solid black !important;
    }
    .project-management-nav .nav-tabs {
        border-bottom: unset;
        padding: 2px;
    }
    .project-management-nav .nav-tabs .nav-item {
        margin-bottom: unset;
    }
    .filter_btn {
        border: 1px solid gray;
        color: gray;
        font-weight: 600;
        padding: 5px 12px;
    }
    .table-responsive .table tbody td {
        padding: 0.4rem 1rem !important;
    }
    .border_left_unset {
        border-left: unset !important;
    }
    .border_right_unset {
        border-right: unset !important;
    }
    .dark_card {
        /* background: #323232; */
        color: #4E4C4C;
        box-shadow: 0px 2px 4px 0px #00000026;
    }
    .margin_right {
        margin-right: 5px;
    }
    .add_task_btn {
        border: unset;
        text-align: left;
        color: gray;
        font-weight: 100;
    }
    .add_task_btn:hover {
        border: unset;
        text-align: left;
        color: gray;
        font-weight: 100;
        background-color: transparent;
    }
    .add_task_btn_div {
        padding: unset;
        background-color: transparent !important;
        border: unset !important;
    }
    .add_task_btn_div:hover {
        padding: unset;
        background-color: transparent !important;
        border: unset !important;
    }
    .project-management-nav .project-inner-tabs .nav-link:focus,
    .project-management-nav .project-inner-tabs .nav-link:focus-visible {
        outline: none;
        box-shadow: none;
    }
    .padding_bottom_5px {
        padding-bottom: 5px;
    }
    .font_15px {
        font-size: 15px !important;
    }
    .margin_left_15px {
        margin-left: 15px;
    }
    /* Base circle style */
    .circle_checkbox {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        width: 20px;
        height: 20px;
        border: 1px solid gray;
        border-radius: 50%;
        position: relative;
        cursor: pointer;
        vertical-align: middle;
        margin-right: 8px;
        display: inline-block;
    }
    .circle_checkbox:checked {
        border: unset;
        background-color: #27ae60
    }

    /* Checked state with right mark (✓) */
    .circle_checkbox:checked::before {
        content: "\2713"; /* Unicode for check mark */
        position: absolute;
        top: 0px;
        left: 5px;
        font-size: 14px;
        color: #ffffff;
        font-weight: bold;
    }
    /* Hide all section rows by default */
    .section-customer-portal {
    display: none;
    }
    .cursor_pointer {
        cursor: pointer;
    }
    .header-layout {
        margin-bottom: 1.5rem !important;
    }
    .content-position {
        padding-left: 20px !important;
        padding-right: 20px !important;
    }
    .input-group.input-group-alternative {
        background-color: white;
    }
    @media ((min-width: 768px)) {
        .content-position {
            padding-left: 20px !important;
            padding-right: 20px !important;
        }
    }

    .custom-breadcrumb {
        background: none !important;
        font-family: Roboto Condensed !important;
        font-size: 12px;
        margin-bottom: 0rem;
    }

    .custom-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
        content: ">" !important;
        color: #999999;
    }

    .custom-breadcrumb .breadcrumb-item a {
        color: #000;
        font-weight: 600;
        text-decoration: none;
    }

    .custom-breadcrumb .breadcrumb-item.active {
        color: #B3B3B3;
    }

    .inner_tab:hover {
        color: Black;
        font-weight: 600;
        border-bottom: 2px solid black !important;
    }
    .bg-box.container-fluid.fix-nav.header-layout{
        margin-bottom: .5rem !important;
    }

    .trash_btn {
        color: rgb(255, 136, 136);
        cursor: pointer;
    }
    .share_btn {
        color: #5e72e4;
        cursor: pointer;
    }
    .delete-project, .share-project, .delete-section-discussion, .delete-discussion, .delete-sub-discussion {
        padding: 5px 8px;
        border: none;
    }

.project-inner-title {
    max-width: calc(100% - 300px);
}

#project_name {
    display: inline-block;
    max-width: 475px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

@media (width >= 1240px) {
   #project_name {
        max-width: 290px;
    }
}

@media (width >= 1340px) {
   #project_name {
        max-width: 350px;
    }
}

@media (width >= 1508px) {
   #project_name {
        max-width: 460px;
    }
}

@media (max-width: 767.98px) {
    .content-position {
        padding: 10px !important;
        /* padding-left: 20px !important;
        padding-right: 20px !important;
        padding-top: 20px !important;
        padding-bottom: 20px !important; */
    }

    /* ── Outer wrapper: transparent shell ── */
    .project-management-nav {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }

    .project-management-nav .card-body.py-2.px-4 {
        padding: 0 !important;
        background: transparent !important;
        display: flex !important;
        flex-direction: column !important;
    }

    /* Dissolve .row so its children join card-body flex context */
    .project-management-nav .card-body.py-2.px-4 > .justify-content-center.pr-2.row {
        display: contents !important;
    }

    /* ── 1. Empty col: always hidden ── */
    .project-management-nav .card-body.py-2.px-4 > .justify-content-center.pr-2.row > .col-md-4:first-child {
        display: none !important;
    }

    /* ── 2. Search col: order 1 — separate, transparent, above white card ── */
    .project-management-nav .card-body.py-2.px-4 > .justify-content-center.pr-2.row > .col-md-4.text-center {
        order: 1 !important;
        width: 100% !important;
        max-width: 100% !important;
        padding: 8px 0 10px 0 !important;
        background: transparent !important;
        display: flex !important;
        justify-content: center !important;
        position: relative !important;
        z-index: 1100 !important;
    }

    /* Search dropdown floats above ALL other elements when open */
    .project-management-nav .advance-search {
        position: relative !important;
        z-index: 1100 !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    .project-management-nav .dropdown-menu-custom {
        z-index: 1200 !important;
    }

    /* ── 3. Project info: order 2 — white card, rounded top ── */
    .project-management-nav .d-flex.flex-wrap.justify-content-between.align-items-center.mb-3.mt-2 {
        order: 2 !important;
        background: #ffffff !important;
        border: 1px solid #e8eaed !important;
        border-bottom: none !important;
        border-radius: 16px 16px 0 0 !important;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.03) !important;
        padding: 14px !important;
        margin: 0 !important;
        width: 100% !important;

        display: grid !important;
        grid-template-columns: 1fr auto !important;
        grid-template-rows: auto auto !important;
        gap: 12px 8px !important;
        align-items: center !important;
        position: relative !important;
    }

    /* ── 4. Tabs col: order 3 — white card middle strip, below project info ── */
    .project-management-nav .card-body.py-2.px-4 > .justify-content-center.pr-2.row > .col-md-4.text-right {
        order: 3 !important;
        width: 100% !important;
        max-width: 100% !important;
        background: #ffffff !important;
        border-left: 1px solid #e8eaed !important;
        border-right: 1px solid #e8eaed !important;
        border-bottom: 1px solid #e8eaed !important;
        padding: 10px 14px !important;
        display: flex !important;
        justify-content: center !important;
    }

    /* ── 5. Tab content: order 4 — white card bottom ── */
    .project-management-nav .tab-content#projectTabContent {
        order: 4 !important;
        display: block !important;
        background: #ffffff !important;
        border: 1px solid #e8eaed !important;
        border-top: none !important;
        border-radius: 0 0 16px 16px !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05) !important;
        padding: 12px 14px 18px 14px !important;
        margin: 0 !important;
    }

    /* ── Project title grid (icon | name / status | stage) ── */
    .project-management-nav .project-inner-title {
        grid-column: 1 !important;
        grid-row: 1 / span 2 !important;
        display: grid !important;
        grid-template-columns: auto 1fr !important;
        grid-template-rows: auto auto !important;
        gap: 8px 10px !important;
        align-items: center !important;
        max-width: 100% !important;
        width: 100% !important;
    }

    .project-management-nav .project-inner-title span:first-of-type {
        grid-column: 1 !important;
        grid-row: 1 !important;
    }

    .project-management-nav #project_name {
        grid-column: 2 !important;
        grid-row: 1 !important;
        font-size: 1.1rem !important;
        font-weight: 700 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        max-width: 180px !important;
    }

    /* Hide separator "|" */
    .project-management-nav .project-inner-title span:nth-of-type(3) {
        display: none !important;
    }

    .project-management-nav .status-badge {
        grid-column: 1 !important;
        grid-row: 2 !important;
        justify-self: start !important;
        padding: 4px 10px !important;
        font-size: 12px !important;
        white-space: nowrap !important;
    }

    .project-management-nav .project-stage-select {
        grid-column: 2 !important;
        grid-row: 2 !important;
        justify-self: start !important;
        margin-left: 0 !important;
    }

    /* ── Avatars + toggle group ── */
    .project-management-nav .project-inner-user-group {
        grid-column: 2 !important;
        grid-row: 1 / span 2 !important;
        position: relative !important;
        min-width: 90px !important;
        height: 68px !important;
        display: block !important;
        border: none !important;
        padding: 0 !important;
        margin: 0 !important;
        width: auto !important;
    }

    .project-management-nav .hide-task-toggle {
        position: absolute !important;
        bottom: 0 !important;
        right: 0 !important;
        margin: 0 !important;
    }

    .project-management-nav .project-inner-avatar {
        position: absolute !important;
        top: 0 !important;
        z-index: 1 !important;
    }

    .project-management-nav .project-inner-avatar:nth-of-type(1) { right: 0 !important; }
    .project-management-nav .project-inner-avatar:nth-of-type(2) { right: 18px !important; }
    .project-management-nav .project-inner-avatar:nth-of-type(3) { right: 36px !important; }
    .project-management-nav .project-inner-avatar:nth-of-type(n+4) { display: none !important; }

    /* ── Tab pills ── */
    .project-management-nav .project-inner-tabs {
        border-bottom: none !important;
        margin: 0 !important;
        padding: 0 !important;
        display: flex !important;
        justify-content: center !important;
        width: 100% !important;
    }

    .project-management-nav .project-inner-tabs .d-flex {
        gap: 8px !important;
        width: 100% !important;
        justify-content: center !important;
    }

    .project-management-nav .nav-tabs .nav-item {
        margin-bottom: 0 !important;
    }

    .project-management-nav .inner_tab {
        border: 1px solid #e2e8f0 !important;
        background-color: #f8fafc !important;
        color: #64748b !important;
        border-radius: 20px !important;
        padding: 6px 20px !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        transition: all 0.2s ease !important;
    }

    .project-management-nav .nav-item .nav-link.active {
        background-color: #1b1c20 !important;
        color: #ffffff !important;
        border-color: #1b1c20 !important;
        border-bottom: 1px solid #1b1c20 !important;
    }

    .project-management-nav .inner_tab:hover {
        color: #1b1c20 !important;
        border-bottom: 1px solid #e2e8f0 !important;
    }

    /* ── Search bar dropdown ── */
    .project-management-nav .advance-search {
        position: relative !important;
        z-index: 1050 !important;
        max-width: 100% !important;
        width: 100% !important;
        margin: 0 auto !important;
    }

    .project-management-nav .advance-search .dropdown-menu-custom {
        background-color: #ffffff !important;
        z-index: 1060 !important;
    }

    .project-management-nav .advance-search .custom-tab-content,
    .project-management-nav .advance-search .custom-tab-pane.active {
        background-color: #ffffff !important;
    }

    /* ── Hide Board tab on mobile ── */
    .project-management-nav .nav-tabs .d-flex .nav-item:last-child {
        display: none !important;
    }

    .project-management-nav .tab-content #board.tab-pane {
        display: none !important;
    }
}

</style>
<div class="container-fluid mb-5 content-position" style="padding-left: 20px !important; padding-right: 20px !important;">
    <div class="se-pre-con"></div>
    @section('order-header')
        <span>PROJECT</span>
    @endsection
    @section('back-btn')
        <a href="{{ route('projects.list') }}" class="home-btn-color">BACK TO PROJECTS</a>
    @endsection

    {{-- <nav aria-label="breadcrumb">
        <ol class="breadcrumb custom-breadcrumb">
            <li class="breadcrumb-item" style="font-family: Roboto Condensed !important;">
                <a href="{{ route('projects.home') }}">Project Management</a>
            </li>
            <li class="breadcrumb-item" style="font-family: Roboto Condensed !important;">
                <a href="{{ route('projects.list') }}">Projects</a>
            </li>
             <li class="breadcrumb-item active" style="font-family: Roboto Condensed !important;">
                {{ $project->current_product->product_name ?? $project->project_name ?? 'New product' }}
            </li>
        </ol>
    </nav> --}}
    <div class="card shadow-sm mb-4 project-management-nav" style="font-family: Arial, sans-serif; z-index: 0;">
        <div class="card-body py-2 px-4">
            <div class="justify-content-center pr-2 row">
                <div class="col-md-4"></div>
                <div class="col-md-4 text-center d-flex justify-content-center" style="padding-left: 10px; padding-top: 8px;">
                    @include('pages.project.partials.project_master_search')
                </div>
                <div class="col-md-4 text-right d-flex justify-content-end pr-0">
                    <!-- Bootstrap Nav Tabs -->
                    <ul class="nav nav-tabs mb-3 project-inner-tabs justify-content-between" id="projectTab" role="tablist">
                        <div class="d-flex">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active inner_tab h-100" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab" aria-controls="list" aria-selected="true">List</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link inner_tab h-100" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="false">Overview</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link inner_tab h-100" id="board-tab" data-bs-toggle="tab" data-bs-target="#board" type="button" role="tab" aria-controls="board" aria-selected="false">Board</button>
                            </li>

                        </div>
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link inner_tab" id="timeline-tab" data-bs-toggle="tab" data-bs-target="#timeline" type="button" role="tab" aria-controls="timeline" aria-selected="false">Timeline</button>
                        </li> --}}
                        {{-- <div class="col-md-5 text-center d-flex justify-content-end" style="padding-left: 10px;">
                            @include('pages.project.partials.project_master_search')
                        </div> --}}
                    </ul>
                </div>
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 mt-2">

                <div class="project-inner-title">

                    <span style="border-radius:50%; padding: 4px; width:50px; height:50px; display:flex; align-items:center; justify-content:center; background:{{ $project->project_color ?? '#b5b5b5' }};">
                        @if ($project->project_icon_url)
                            <img src="{{ $project->project_icon_url }}" alt="Project Icon" style="width: 100%; height: 100%; object-fit: contain;">
                        @else
                            <i class="fa fa-server" style="color:#fff; font-size: smaller;"></i>
                        @endif
                    </span>

                    <span id="project_name">
                        {{ $project->current_product->product_name ?? $project->project_name ?? 'New product' }}
                    </span>

                    <span style="margin: 0 10px; color:#d1d1d1;">|</span>

                    @php
                        $color = '';
                        $label = '';

                        if ($project->project_status_id == 1) {
                            $label = 'New';
                            $color = 'background:#D4F8D4; color:#1A7F1A;';

                        } elseif ($project->project_status_id == 2) {
                            $label = 'Completed';
                            $color = 'background:#DCEBFF; color:#2F5FD1;';

                        } elseif ($project->project_status_id == 3) {
                            $label = 'Cancelled';
                            $color = 'background:#FFD6D6; color:#C62828;';
                        }
                    @endphp

                    <span class="status-badge"
                        style="padding:4px 12px; border-radius:12px; font-size:13px; {{ $color }}">
                        {{ $label }}
                    </span>

                    <select class="modern-stage-select project-stage-select"
                            data-id="{{ $project->id }}"
                            style="margin-left: 10px;">

                        <option value="" {{ !$project->stage_status ? 'selected' : '' }}>-</option>

                        @foreach($project->stage_status_options as $stage)
                            <option value="{{ $stage }}"
                                {{ $project->stage_status == $stage ? 'selected' : '' }}>
                                {{ $stage }}
                            </option>
                        @endforeach

                    </select>

                </div>

                <div class="col-md-4 text-right d-flex align-items-center justify-content-end project-inner-user-group">

                    <label class="d-flex align-items-center justify-content-center mr-3 mb-0 hide-task-toggle"
                        style="
                                width:38px;
                                height:38px;
                                cursor:pointer;
                                background:#dce9dc;
                                border-radius:50%;
                                transition:all .2s ease;
                                box-shadow:0 1px 4px rgba(0,0,0,0.08);
                        "
                        title="Hide Completed Tasks">

                        <input type="checkbox"
                            id="hide_completed_tasks"
                            class="hide-completed-tasks-checkbox d-none"
                            data-project-id="{{ $project->id }}">

                        {{-- Eye Open --}}
                        <i class="fa fa-eye hide-eye-open d-none" title="Complete tasks is visible" style="font-size:16px; color:#198754;"></i>

                        {{-- Eye Closed --}}
                        <i class="fa fa-eye-slash hide-eye-close" title="Complete tasks is hidden" style="font-size:16px; color:#dc3545;"></i>

                    </label>

                    {{-- Avatars --}}
                    @foreach ($projectAssignees[0] as $projectAssignee)
                        <img src="{{ asset($projectAssignee['image']) }}"
                            class="project-inner-avatar"
                            title="{{ $projectAssignee['name'] }}">
                    @endforeach

                </div>

            </div>

            <div class="tab-content" id="projectTabContent">
                <!-- List Tab -->
                <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
                    @include('pages.project.partials.project_inner_list')
                </div>
                <!-- Board Tab -->
                <div class="tab-pane fade" id="board" role="tabpanel" aria-labelledby="board-tab" style="overflow: auto; padding-bottom: 30px;">
                    @include('pages.project.partials.project_inner_board')
                </div>
                <!-- Overview Tab -->
                <div class="tab-pane fade" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                    @if ($project->project_type_id == 2)
                        @include('pages.project.partials.project_inner_product_development')
                    @else
                        @include('pages.project.partials.project_inner_overview')
                    @endif
                </div>
                <!-- Timeline Tab -->
                {{-- <div class="tab-pane fade" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
                    <div class="text-center py-5 text-muted">Timeline coming soon...</div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@include('pages.project.task_comment')

@include('pages.project.partials.share_project_modal')

<script>
    function updateStageSelectColor(selectElement) {
        const val = $(selectElement).val();
        $(selectElement).removeClass('stage-discussion stage-ui-ux-design stage-planning stage-under-development stage-sampling stage-testing stage-live stage-default');
        if (val === 'Discussion') {
            $(selectElement).addClass('stage-discussion');
        } else if (val === 'UI/UX Design') {
            $(selectElement).addClass('stage-ui-ux-design');
        } else if (val === 'Planning') {
            $(selectElement).addClass('stage-planning');
        } else if (val === 'Development') {
            $(selectElement).addClass('stage-under-development');
        } else if (val === 'Sampling') {
            $(selectElement).addClass('stage-sampling');
        } else if (val === 'Testing') {
            $(selectElement).addClass('stage-testing');
        } else if (val === 'Live') {
            $(selectElement).addClass('stage-live');
        } else {
            $(selectElement).addClass('stage-default');
        }
    }

    $(document).ready(function() {
        // ── Restore hide/unhide state from sessionStorage ──────────
        var projectId = $('#hide_completed_tasks').data('project-id');
        var storageKey = 'hideCompletedTasks_' + projectId;
        var savedState = sessionStorage.getItem(storageKey);

        // Default to hidden (true) if no saved state
        var isHiding = (savedState === null) ? true : (savedState === 'true');

        var checkbox = $('#hide_completed_tasks');
        checkbox.prop('checked', isHiding);

        var wrapper = checkbox.closest('.hide-task-toggle');
        if (isHiding) {
            wrapper.find('.hide-eye-open').addClass('d-none');
            wrapper.find('.hide-eye-close').removeClass('d-none');
        } else {
            wrapper.find('.hide-eye-open').removeClass('d-none');
            wrapper.find('.hide-eye-close').addClass('d-none');
        }

        // Apply filter after a short delay to let sections render
        setTimeout(function() {
            applyCompletedTasksFilter(isHiding);
        }, 300);

        // Apply color class to any .modern-stage-select
        $('body').on('change', '.modern-stage-select', function() {
            updateStageSelectColor(this);
        });

        // Top header dropdown change → AJAX save + sync overview select
        $('body').on('change', '.project-stage-select', function() {
            var project_id = $(this).data('id');
            var stage_status = $(this).val();

            // Sync the overview form select
            $('#stage_status').val(stage_status);

            $.ajax({
                url: '{{ route("projects.updateStageStatus") }}',
                method: 'POST',
                data: {
                    project_id: project_id,
                    stage_status: stage_status,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    // updated successfully
                },
                error: function(xhr, status, error) {
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

        // Overview form stage select change → AJAX save + sync top dropdown
        $('body').on('change', '#stage_status', function() {
            var stage_status = $(this).val();
            var topSelect = $('.project-stage-select');
            var project_id = topSelect.data('id');

            // Sync the top dropdown value and color
            topSelect.val(stage_status);
            updateStageSelectColor(topSelect[0]);

            // Save via AJAX immediately
            $.ajax({
                url: '{{ route("projects.updateStageStatus") }}',
                method: 'POST',
                data: {
                    project_id: project_id,
                    stage_status: stage_status,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    // updated successfully
                },
                error: function(xhr, status, error) {
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

        // Initialize colors for all selects on load
        $('.modern-stage-select').each(function() {
            updateStageSelectColor(this);
            $(this).addClass('stage-initialized');
        });
    });
    $(document).on('change', '.hide-completed-tasks-checkbox', function () {
        const wrapper = $(this).closest('.hide-task-toggle');
        const isHiding = $(this).is(':checked');

        // Save state to sessionStorage (persists until logout/tab close)
        var projectId = $(this).data('project-id');
        sessionStorage.setItem('hideCompletedTasks_' + projectId, isHiding);

        if (isHiding) {
            wrapper.find('.hide-eye-open').addClass('d-none');
            wrapper.find('.hide-eye-close').removeClass('d-none');
        } else {
            wrapper.find('.hide-eye-open').removeClass('d-none');
            wrapper.find('.hide-eye-close').addClass('d-none');
        }

        applyCompletedTasksFilter(isHiding);
        refreshOpenSectionsAndDiscussions();
    });

    function applyCompletedTasksFilter(isHiding) {
        if (isHiding) {
            $('tr.parent-discussion-row').each(function() {
                const checkbox = $(this).find('.discussion-check');
                if (checkbox.is(':checked')) {
                    $(this).fadeOut(200);
                } else {
                    $(this).fadeIn(200);
                }
            });

            $('tr.sub-discussion-row').each(function() {
                const checkbox = $(this).find('.sub-discussion-check');
                if (checkbox.is(':checked')) {
                    $(this).fadeOut(200);
                } else {
                    $(this).fadeIn(200);
                }
            });
        } else {
            $('tr.parent-discussion-row, tr.sub-discussion-row').fadeIn(200);
        }
    }

    function refreshOpenSectionsAndDiscussions() {
        const openDiscussionIdsBySection = {};

        $('tr.parent-discussion-row').each(function() {
            const discussionId = $(this).data('discussion-id');
            const sectionId = $(this).data('section-id');
            const discussionLoaded = $(this).data('discussion-loaded');

            if (discussionLoaded === true || discussionLoaded === 'true') {
                openDiscussionIdsBySection[sectionId] = openDiscussionIdsBySection[sectionId] || [];
                openDiscussionIdsBySection[sectionId].push(discussionId);
            }
        });

        $('tr.parent-row').filter(function() {
            return $(this).data('section-loaded') === true || $(this).data('section-loaded') === 'true';
        }).each(function() {
            const sectionId = $(this).data('section-id');
            const openDiscussionIds = openDiscussionIdsBySection[sectionId] || [];
            refreshSectionData(sectionId, openDiscussionIds);
        });
    }

    function refreshSectionData(sectionId, openDiscussionIds) {
        $.ajax({
            url: '{{ url('get_project_management_section_by_id') }}/' + sectionId,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if ($('#hide_completed_tasks').is(':checked')) {
                    data.discussions = data.discussions.filter(function(discussion) {
                        return discussion.is_completed == 0;
                    });
                }

                $('.parent-section-' + sectionId).remove();
                displaySectionDiscussions(data);

                openDiscussionIds.forEach(function(discussionId) {
                    displaySubDiscussionsByDiscussionId(discussionId);
                });
            }
        });
    }
</script>

@endsection
