@extends('layouts.app', ['activePage' => 'pm_dashboard', 'titlePage' => __('Project Management Dashboard')])

@section('content')

<style>
    .nav-tabs .nav-link {
        border: none !important;
        background: none !important;
        color: #222 !important;
        font-size: 1.1rem;
        font-weight: 600;
        padding-bottom: 8px;
        margin-right: 18px;
    }
    .nav-tabs .nav-link.active {
        border-bottom: 3px solid #222 !important;
        color: #222 !important;
        background: none !important;
    }
    .nav-tabs .nav-link:focus {
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        border-bottom: 3px solid #222 !important;
    }
    .custom-task-list .list-group-item {
        font-family: roboto;
        border: none;
        border-bottom: 1px solid #eee;
        font-size: 0.8rem;
        font-weight: 500;
        padding: 14px 0 14px 0;
        background: none;
    }
    .custom-checkbox {
        display: inline-block;
        position: relative;
        width: 22px;
        height: 22px;
        margin-bottom: 0;
    }
    .custom-checkbox input[type="checkbox"] {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .custom-checkbox .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        border-radius: 50%;
        border: 2px solid #bbb;
        background: #fff;
        transition: border-color 0.2s;
    }
    .custom-checkbox input[type="checkbox"]:checked ~ .checkmark {
        background-color: #27ae60;
        border-color: #27ae60;
    }
    .custom-checkbox .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }
    .custom-checkbox input[type="checkbox"]:checked ~ .checkmark:after {
        display: block;
    }
    .custom-checkbox .checkmark:after {
        left: 6px;
        top: 2px;
        width: 6px;
        height: 10px;
        border: solid #fff;
        border-width: 0 3px 3px 0;
        border-radius: 2px;
        transform: rotate(45deg);
        content: '';
    }
    .nav-tabs .nav-link {
        border: none !important;
        background: none !important;
        color: #222 !important;
        font-size: 1.1rem;
        font-weight: 600;
        padding-bottom: 8px;
        margin-right: 18px;
    }
    .nav-tabs .nav-link.active {
        border-bottom: 3px solid #222 !important;
        color: #222 !important;
        background: none !important;
    }
    .nav-tabs .nav-link:focus {
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        border-bottom: 3px solid #222 !important;
    }
    .custom-project-grid .project-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 15px;
        font-size: 1.5rem;
        background: #eee;
        color: #fff;
        padding: 6px;
    }
    .custom-project-grid .create-project-icon {
        background: #f5f5f5;
        border-radius: 50%;
        /* border: 2px dashed #bbb; */
        color: #bbb;
        width: 56px;
        height: 56px;
    }
    .create-project-icon-square {
        width: 25px;
        height: 25px;
        border-radius: 5px;
        border: 1.6px dashed #494949;
    }
    .custom-project-grid .project-orange {
        background: #ff7043;
    }
    .custom-project-grid .project-pink {
        background: #f48fb1;
    }
    .custom-project-grid .project-blue {
        background: #536dfe;
    }
    .custom-project-grid .fw-medium {
        font-size: 1rem;
        font-weight: 500;
        color: #222;
        font-family: roboto;
    }
    .custom-people-grid {
        font-family: roboto;
        font-weight: 500;
    }
    /* Custom select dropdown styling for week/month/day */
    #weekSelect {
        font-family: 'Roboto', sans-serif;
        font-size: 13px;
        color: #222;
        background: none;
        border: none;
        outline: none;
        box-shadow: none;
        padding-right: 24px;
        width: auto;
        min-width: 90px;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
    }
    #weekSelect:focus {
        outline: none;
        box-shadow: none;
    }
    #weekSelect option {
        color: #222;
        padding: 0 10px;
    }
    .me-4.position-relative select::-ms-expand {
        display: none;
    }
    .me-4.position-relative {
        min-width: 110px;
    }
    .me-4.position-relative .fa-chevron-down {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: #222;
    }
    /* Hide default arrow for Chrome, Safari, Edge */
    #weekSelect::-webkit-appearance {
        appearance: none;
    }
    #weekSelect::-ms-expand {
        display: none;
    }
    #weekSelect::-webkit-input-placeholder {
        color: #222;
    }
    .custom-task-list {
        max-height: 11rem;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #bbb #fff;
    }
    .custom-task-list::-webkit-scrollbar {
        width: 6px;
        background: #fff;
    }
    .custom-task-list::-webkit-scrollbar-thumb {
        background: #bbb;
        border-radius: 4px;
    }
    .pointer {
        cursor: pointer;
    }
    .container-fluid {
        font-family: Arial, sans-serif;
    }
    .card {
        border: unset;
    }
    .header-layout {
        margin-bottom: 1.5rem !important;
    }
    .content-position {
        padding-left: 20px !important;
        padding-right: 20px !important;
    }
    /* .dropdown-menu {
        left: 50%;
    } */
    @media ((min-width: 768px)) {
        .content-position {
            padding-left: 20px !important;
            padding-right: 20px !important;
        }
    }
    .bg-box.container-fluid.fix-nav.header-layout{
        margin-bottom: .5rem !important;
    }

    #task_assignee_filter + .select2-container {
    width: 230px !important;
}

.select2-container--default .select2-selection--single {
    height: 40px !important;
    border: 1px solid #dee2e6 !important;
    border-radius: 8px !important;
    display: flex !important;
    align-items: center !important;
    background: #fff !important;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 38px !important;
    padding-left: 30px !important;
    padding-right: 2px !important;
    color: #495057 !important;
    font-size: 14px !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 38px !important;
    right: 8px !important;
}

.select2-container--default .select2-selection--single .select2-selection__clear {
    position: absolute;
    right: 35px;
    top: 50%;
    transform: translateY(-50%);
    margin: 0 !important;
    font-size: 16px;
    color: #666;
}

.select2-dropdown {
    border: 1px solid #dee2e6 !important;
    border-radius: 8px !important;
}

.select2-search__field {
    border-radius: 6px !important;
}

@media (max-width: 767px) {

    /* Top greeting/search card */
    .container-fluid.content-position > .card.shadow-sm.mb-2 {
        margin-top: 8% !important;
    }

    /* --- Page container --- */
    .container-fluid.content-position {
        padding-left: 12px !important;
        padding-right: 12px !important;
    }

    /* --- Cards: full-width, rounded, compact --- */
    .card {
        border-radius: 16px !important;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08) !important;
        margin-bottom: 14px !important;
    }

    /* --- Header card: stack greeting + search vertically --- */
    .card .card-body .row.align-items-center.g-0 {
        flex-direction: column !important;
        align-items: flex-start !important;
    }

    .card .card-body .row.align-items-center.g-0 .col-auto,
    .card .card-body .row.align-items-center.g-0 .col-md-5 {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
        padding-left: 0 !important;
        justify-content: flex-start !important;
    }

    /* Greeting text sizes */
    .card .card-body span[style*="font-size: 20px"] {
        font-size: 16px !important;
    }

    .card .card-body span.fw-bold[style*="font-size: 14px"] {
        font-size: 13px !important;
    }

    /* Search bar full width with spacing */
    .card .card-body .row.align-items-center.g-0 .col-md-5 {
        margin-top: 12px !important;
        padding: 0 !important;
        justify-content: center !important;
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
    }

    /* --- Section titles (MY TASKS, PROJECTS, PEOPLE) --- */
    .card-title.fw-bold {
        font-size: 0.95rem !important;
        letter-spacing: 0.5px;
    }

    /* --- Tab pills: Upcoming / Overdue / Completed style --- */
    .nav-tabs .nav-link {
        font-size: 0.75rem !important;
        font-weight: 500 !important;
        padding: 5px 14px !important;
        margin-right: 6px !important;
        border-radius: 10px !important;
        border: 1.5px solid #d0d0d0 !important;
        color: #444 !important;
        background: #fff !important;
        transition: background 0.2s, color 0.2s;
        white-space: nowrap !important;
    }

    .nav-tabs .nav-link.active {
        background: #1a1a1a !important;
        color: #fff !important;
        border-color: #1a1a1a !important;
        border-bottom: 1.5px solid #1a1a1a !important;
    }

    .nav-tabs .nav-link:focus {
        border-bottom: 1.5px solid #1a1a1a !important;
    }

    /* Remove bottom border from tab row on mobile */
    .nav-tabs.custom-task-tabs,
    .nav-tabs.custom-project-tabs {
        border-bottom: none !important;
        gap: 4px;
        flex-wrap: nowrap;
        /* overflow-x: auto; */
        /* padding-bottom: 2px; */
        /* overflow-y: visible !important; */
        padding: 2px 2px 10px 2px !important;
        margin-bottom: 10px !important;
    }

    /* --- Fix long task names wrapping under checkbox --- */
    .custom-task-list .list-group-item {
        display: flex !important;
        align-items: flex-start !important;
    }

    .custom-task-list .list-group-item .custom-checkbox {
        flex: 0 0 22px !important;
        margin-top: 2px !important;
    }

    .custom-task-list .list-group-item label,
    .custom-task-list .list-group-item span:not(.checkmark) {
        flex: 1 1 auto !important;
        word-break: break-word !important;
        padding-left: 8px !important;
        line-height: 1.3 !important;
    }

    /* --- Task list --- */
    .custom-task-list .list-group-item {
        font-size: 0.78rem !important;
        padding: 10px 0 !important;
    }

    /* --- Task / Projects content max-height on mobile --- */
    #upcoming-task-content,
    #overdue-task-content,
    #completed-task-content,
    #recent-projects-content,
    #started-projects-content,
    #all-projects-content {
        max-height: 200px !important;
    }

    /* --- Loader containers --- */
    #upcoming-task-loader,
    #overdue-task-loader,
    #completed-task-loader,
    #recent-projects-loader,
    #started-projects-loader,
    #all-projects-loader {
        height: 130px !important;
    }

    /* --- Projects grid items --- */
    .custom-project-grid .project-icon {
        width: 40px !important;
        height: 40px !important;
        border-radius: 10px !important;
        font-size: 1.1rem !important;
        flex-shrink: 0 !important;
    }

    .custom-project-grid .fw-medium {
        font-size: 0.78rem !important;
    }

    /* --- People grid --- */
    .custom-people-grid {
        font-size: 0.8rem !important;
    }

    .custom-people-grid > .col-md-3 {
        width: 50% !important;
        max-width: 50% !important;
        flex: 0 0 50% !important;
    }

    .custom-people-grid a {
        flex-shrink: 0 !important;
    }

    /* --- Row: My Tasks & Projects become single column --- */
    .row > .col-lg-6 {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
    }

    /* --- Super Admin select2 filter --- */
    #task_assignee_filter + .select2-container {
        width: 100% !important;
    }

    /* --- mb-5 spacing reduction --- */
    .container-fluid.mb-5 {
        margin-bottom: 2rem !important;
    }

    /* --- Task / Projects content: remove internal scroll on mobile --- */
    #upcoming-task-content,
    #overdue-task-content,
    #completed-task-content,
    #recent-projects-content,
    #started-projects-content,
    #all-projects-content {
        max-height: none !important;
        /* overflow-y: visible !important; */
    }

    /* --- Loader containers can stay fixed height, or shrink --- */
    #upcoming-task-loader,
    #overdue-task-loader,
    #completed-task-loader,
    #recent-projects-loader,
    #started-projects-loader,
    #all-projects-loader {
        height: 130px !important;
    }

        .custom-task-list {
        max-height: none !important;
        /* overflow-y: visible !important; */
    }

    #upcoming-task-content,
    #overdue-task-content,
    #completed-task-content {
        max-height: none !important;
        /* overflow-y: visible !important; */
    }
}

</style>

<div class="container-fluid mb-5 content-position" style="padding-left: 20px !important; padding-right: 20px !important;">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>PROJECT MANAGEMENT - HOME</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color">BACK TO HOME</a>
    @endsection

    <!-- Header Section as Card -->
    <div class="card shadow-sm mb-2" style="">
        <div class="card-body py-2 px-4">
            <div class="row align-items-center g-0">

                <div class="col-auto">
                    <div>
                        <span style="font-size: 20px; letter-spacing: -0.5px;">
                            Good&nbsp;&nbsp;{{ $helper->getGreetingTime() }}, {{ auth()->user()->name }}
                        </span><br>
                        <span class="fw-bold" style="font-size: 14px; font-weight: 900;">
                            {{ $helper->getFormatedDate(date('Y-m-d'), 'l, F d') }}
                        </span>
                    </div>
                </div>

                <div class="col-md-5 text-center d-flex justify-content-end" style="padding-left: 10px;">
                    @include('pages.project.partials.project_master_search')
                </div>

                {{-- <div class="ml-auto d-flex justify-content-md-center justify-content-start">
                    <div class="align-items-center justify-content-center w-100" style="border: 0.5px solid #d4d4d4; border-radius: 4px; padding: 5px; background: #fff;">
                        <div class="col-md-3">
                            <div class="me-4" style="display: inline-block;">
                                <select id="weekSelect" class="form-select border-0 p-0 m-0 bg-transparent"
                                    style="font-size: 13px; width: auto; appearance: none; box-shadow: none; outline: none; cursor: pointer; background: none; padding-right: 24px;">
                                    <option value="month" selected>My Month</option>
                                    <option value="week">My Week</option>
                                    <option value="day">My Day</option>
                                </select>
                                <span style="position: absolute; top: 50%; transform: translateY(-50%); pointer-events: none;">
                                    <i class="fa fa-chevron-down ms-1" style="font-size: 13px;"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-5 text-center" style="border-right: 1px solid #d4d4d4;">
                            <span class="me-4 border-start ps-4">
                                <span id="completed_task_count">00</span> &nbsp;<i class="fa fa-check ms-1" style="font-size: 13px;"></i> Tasks Completed
                            </span>
                        </div>
                        <div class="col-md-4">
                            <span><span id="collaborators_count">00</span> &nbsp; <i class="fa fa-users ms-1" style="font-size: 13px;"></i> Collaborators</span>
                        </div>
                    </div>
                </div> --}}

            </div>

            {{-- <div class="row align-items-center g-0"> --}}

                {{-- <div class="col-md-7">
                    <div>
                        <span style="font-size: 20px; letter-spacing: -0.5px;">
                            Good&nbsp;&nbsp;{{ $helper->getGreetingTime() }}, {{ auth()->user()->name }}
                        </span>
                    </div>
                </div> --}}

                <!-- Search Input Below Summary Bar -->
                {{-- <div class="ml-auto">
                    <input type="text" class="form-control" placeholder="Search..." style="width: 300px; padding-left: 15px; font-size: 13px; border: 0.5px solid #d4d4d4; border-radius: 4px;">
                </div> --}}
                {{-- @include('pages.project.partials.project_master_search') --}}
            {{-- </div> --}}

        </div>
    </div>
    <!-- End Header Section -->

    <!-- Main Content Section -->
    <div class="row">
        <!-- My Tasks Card -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body pb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="card-title fw-bold mb-0" style="font-size: 1rem;">MY TASKS</h4>
                        @if(auth()->user()->hasRole('Super Admin'))
                            <select id="task_assignee_filter" class="form-control">
                                <option value="">All Assignees</option>

                                @foreach($activeUsers as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <ul class="nav nav-tabs custom-task-tabs mb-3" id="tasksTab" role="tablist" style="border-bottom: 1.5px solid #eee;">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" aria-current="page" href="#upcoming" id="upcoming-tab" style="font-size: 0.8rem; font-weight: 200; color: #222; background: none; border: none;">Upcoming</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="#overdue" id="overdue-tab" style="font-size: 0.8rem; font-weight: 200; color: #222; background: none; border: none;">Overdue</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="#completed" id="completed-tab" style="font-size: 0.8rem; font-weight: 200; color: #222; background: none; border: none;">Completed</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="tasksTabContent">
                        <div class="tab-pane fade show active" id="upcoming" role="tabpanel">
                            <!-- Loading Content -->
                            <div id="upcoming-task-loader" class="row g-4 custom-project-grid justify-content-center align-items-center" style="height: 11rem; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #bbb #fff; position: relative; background-color: #ececec;">
                                <img src="{{ asset('argon/img/loader/Spinner-1s-200px.gif') }}" alt="Loading..." style="width: 5rem; height: 5rem;">
                            </div>

                            <!-- Upcoming Tasks Content -->
                            <div id="upcoming-task-content" class="g-4" style="max-height: 11rem; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #bbb #fff; position: relative; display: none;">
                                <ul class="list-group list-group-flush custom-task-list">
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="overdue" role="tabpanel">
                            <!-- Loading Content -->
                            <div id="overdue-task-loader" class="row g-4 custom-project-grid justify-content-center align-items-center" style="height: 11rem; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #bbb #fff; position: relative; background-color: #ececec; display: none;">
                                <img src="{{ asset('argon/img/loader/Spinner-1s-200px.gif') }}" alt="Loading..." style="width: 5rem; height: 5rem;">
                            </div>

                            <!-- Overdue Tasks Content -->
                            <div id="overdue-task-content" class="g-4" style="max-height: 11rem; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #bbb #fff; position: relative;">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="completed" role="tabpanel">
                            <!-- Loading Content -->
                            <div id="completed-task-loader" class="row g-4 custom-project-grid justify-content-center align-items-center" style="height: 11rem; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #bbb #fff; position: relative; background-color: #ececec; display: none;">
                                <img src="{{ asset('argon/img/loader/Spinner-1s-200px.gif') }}" alt="Loading..." style="width: 5rem; height: 5rem;">
                            </div>

                            <!-- completed Tasks Content -->
                            <div id="completed-task-content" class="g-4" style="max-height: 11rem; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #bbb #fff; position: relative;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Projects Card -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body pb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <a href="{{ route('projects.list') }}"> <h4 class="card-title fw-bold mb-0" style="font-size: 1rem;">PROJECTS</h4> </a>
                        {{-- <span style="font-size: 1.5rem; color: #444; cursor: pointer;">&#8226;&#8226;&#8226;</span> --}}
                    </div>
                    <ul class="nav nav-tabs custom-project-tabs mb-3" id="projectsTab" role="tablist" style="border-bottom: 1.5px solid #eee; font-size: 0.8rem; font-weight: 600;">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" aria-current="page" href="#recents" id="recents-tab" style="font-size: 0.8rem; font-weight: 200; color: #222; background: none; border: none;">Recents</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="#started" id="started-tab" style="font-size: 0.8rem; font-weight: 200; color: #222; background: none; border: none;">Started</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="#all-projects" id="all-projects-tab" style="font-size: 0.8rem; font-weight: 200; color: #222; background: none; border: none;">All</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="projectsTabContent">
                        <div class="tab-pane fade show active" id="recents" role="tabpanel">
                            <!-- Loading Content -->
                            <div id="recent-projects-loader" class="row g-4 custom-project-grid justify-content-center align-items-center" style="height: 11rem; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #bbb #fff; position: relative; background-color: #ececec;">
                                <img src="{{ asset('argon/img/loader/Spinner-1s-200px.gif') }}" alt="Loading..." style="width: 5rem; height: 5rem;">
                            </div>

                            <!-- Projects Content -->
                            <div id="recent-projects-content" class="row g-4 custom-project-grid" style="max-height: 11rem; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #bbb #fff; position: relative; display: none;">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="started" role="tabpanel">
                            <!-- Loading Content -->
                            <div id="started-projects-loader" class="row g-4 custom-project-grid justify-content-center align-items-center" style="height: 11rem; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #bbb #fff; position: relative; background-color: #ececec;">
                                <img src="{{ asset('argon/img/loader/Spinner-1s-200px.gif') }}" alt="Loading..." style="width: 5rem; height: 5rem;">
                            </div>

                            <!-- Projects Content -->
                            <div id="started-projects-content" class="row g-4 custom-project-grid" style="max-height: 11rem; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #bbb #fff; position: relative; display: none;">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="all-projects" role="tabpanel">
                            <!-- Loading Content -->
                            <div id="all-projects-loader" class="row g-4 custom-project-grid justify-content-center align-items-center" style="height: 11rem; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #bbb #fff; position: relative; background-color: #ececec;">
                                <img src="{{ asset('argon/img/loader/Spinner-1s-200px.gif') }}" alt="Loading..." style="width: 5rem; height: 5rem;">
                            </div>

                            <!-- Projects Content -->
                            <div id="all-projects-content" class="row g-4 custom-project-grid" style="max-height: 11rem; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #bbb #fff; position: relative; display: none;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- People Section -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title fw-bold mb-3">PEOPLE</h4>
                    <!-- Loading Content -->
                    <div id="collaborators-loader" class="row justify-content-center align-items-center custom-people-grid" style="background-color: #ececec;">
                        <img src="{{ asset('argon/img/loader/Spinner-1s-200px.gif') }}" alt="Loading..." style="width: 5rem; height: 5rem;">
                    </div>
                    <div id="collaborators-content" class="row align-items-center custom-people-grid" style="display: none;">
                        {{-- <div class="col-md-2 d-flex align-items-center me-4 mb-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mr-2" style="width:45px;height:45px;background:#e0e0e0;">
                                <i class="fa fa-plus fa-2x text-secondary"></i>
                            </div>
                            <span class="ms-2">Invite people</span>
                        </div> --}}
                        {{-- <div class="col-md-2 d-flex align-items-center mb-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mr-2" style="width:45px;height:45px;background:#f48fb1;">
                                <i class="fa fa-user fa-2x text-white"></i>
                            </div>
                            <span class="ms-2">Oshadi</span>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@include('pages.project.task_comment')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var triggerTabList = [].slice.call(document.querySelectorAll('#tasksTab .nav-link'));
        triggerTabList.forEach(function (triggerEl) {
            triggerEl.addEventListener('click', function (e) {
                e.preventDefault();
                var tabTrigger = new bootstrap.Tab(triggerEl);
                tabTrigger.show();
            });
        });

        var triggerProjectTabList = [].slice.call(document.querySelectorAll('#projectsTab .nav-link'));
        triggerProjectTabList.forEach(function (triggerEl) {
            triggerEl.addEventListener('click', function (e) {
                e.preventDefault();
                var tabTrigger = new bootstrap.Tab(triggerEl);
                tabTrigger.show();
            });
        });

        $(document).ready(function () {

            loadMyTasks('upcoming');
            loadProjects('recent');
            loadProjectsCollaborators();

            if ($('#task_assignee_filter').length) {

                $('#task_assignee_filter').select2({
                    placeholder: 'All Assignees',
                    allowClear: true,
                    width: '250px'
                });

            }
                
        });


        $('#upcoming-tab').on('click', function () {
            loadMyTasks('upcoming');
        });

        $('#overdue-tab').on('click', function () {
            loadMyTasks('overdue');
        });

        $('#completed-tab').on('click', function () {
            loadMyTasks('completed');
        });

        $('#recents-tab').on('click', function () {
            loadProjects('recent');
        });

        $('#started-tab').on('click', function () {
            loadProjects('started');

        });

        $('#all-projects-tab').on('click', function () {

            loadProjects('all');

        });

        $(document).on('change', '#task_assignee_filter', function () {

            const activeTab = $('#tasksTab .nav-link.active').attr('href').replace('#', '');

            loadMyTasks(activeTab);

        });

        $(document).on('change', '#task_assignee_filter', function () {

            $('#recent-projects-content').empty();
            $('#started-projects-content').empty();
            $('#all-projects-content').empty();

            const activeTab = $('#projectsTab .nav-link.active')
                .attr('href')
                .replace('#', '');

            let loadType = 'recent';

            if (activeTab === 'started') {
                loadType = 'started';
            }

            if (activeTab === 'all-projects') {
                loadType = 'all';
            }

            loadProjects(loadType);

        });


        function loadMyTasks(taskType)
        {
            var assigneeId = $('#task_assignee_filter').length
                ? $('#task_assignee_filter').val()
                : '';

            $.ajax({
                url: '{{ route("projects.get_my_tasks") }}',
                method: 'GET',
                data: {
                    task_type: taskType,
                    assignee_id: assigneeId
                },

                beforeSend: function () {

                    $('#' + taskType + '-task-content').hide().empty();
                    $('#' + taskType + '-task-loader').show();

                },

                success: function (data) {

                    $('#' + taskType + '-task-content').html(data);

                    $('#' + taskType + '-task-loader').hide();

                    $('#' + taskType + '-task-content').show();

                },

                error: function () {

                    $('#' + taskType + '-task-loader').hide();

                    $('#' + taskType + '-task-content')
                        .html('<div class="text-center text-muted">No Tasks Found</div>')
                        .show();
                }
            });
        }

        function loadProjects(type)
        {
            var assigneeId = $('#task_assignee_filter').length
                ? $('#task_assignee_filter').val()
                : '';

            $.ajax({

                url: '{{ route("projects.get_paginated_projects") }}',
                method: 'GET',

                data: {
                    load_type: type,
                    assignee_id: assigneeId
                },

                beforeSend: function () {

                    $('#' + type + '-projects-content')
                        .hide()
                        .empty();

                    $('#' + type + '-projects-loader')
                        .show();
                },

                success: function (data) {

                    $('#' + type + '-projects-content')
                        .html(data);

                    $('#' + type + '-projects-loader')
                        .hide();

                    $('#' + type + '-projects-content')
                        .show();
                },

                error: function () {

                    $('#' + type + '-projects-loader')
                        .hide();

                    $('#' + type + '-projects-content')
                        .html(`
                            <div class="col-12 text-center text-muted">
                                No Projects Found
                            </div>
                        `)
                        .show();
                }
            });
        }


       

        function loadProjectsCollaborators()
        {
            var dtRange = 'week'
            $.ajax({
                url: '{{ route("projects.get_projects_collaborators") }}',
                method: 'GET',
                data: { 'date_range': dtRange },
                beforeSend: function () {
                    $('#collaborators-content').fadeOut(function () {
                        $('#collaborators-loader').show(200);
                        $(this).empty();
                    });
                },
                success: function (data) {
                    $('#collaborators-content').html(data);
                    $('#collaborators-loader').fadeOut(function () {
                        $('#collaborators-content').show(200);
                    });
                },
                error: function (xhr, status, error) {
                    // Log error to console
                    console.error('Error loading recent collaborators:', error, xhr.responseText);
                    // Optionally handle errors and clear content
                    $('#collaborators-content').empty().show();
                    $('#collaborators-loader').hide();
                }
            });
        }


        $('body').on('change', '.my-task-check', function() {

            let checkbox = $(this);
            let discussionId = checkbox.val();
            let discussionType = checkbox.data('discussion-type');

            let isCompleted = checkbox.is(':checked') ? 1 : 0;

            let url = '';

            if (discussionType == 'discussion') {

                url = '{{ url("project_management_section_discussion/update") }}/' + discussionId;

            } else if (discussionType == 'sub_discussion') {

                url = '{{ url("project_management_section_sub_discussion/update") }}/' + discussionId;

            } else {

                return;
            }

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    is_completed: isCompleted,
                    _token: '{{ csrf_token() }}'
                },

                success: function(response) {

                    // reload active tab
                    let activeTab = $('#tasksTab .nav-link.active')
                        .attr('href')
                        .replace('#', '');

                    loadMyTasks(activeTab);

                },

                error: function(xhr, status, error) {

                    checkbox.prop('checked', !isCompleted);

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

        
    });
</script>
@endsection
