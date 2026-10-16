@extends('layouts.app', ['activePage' => 'activities', 'titlePage' => __('Activities')])

@section('content')
<style>
    body, p {
        font-weight: 400; /* Regular weight */
    }

    .bg-box{
        margin-bottom: unset !important;
    }
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
        display: block;
    }
    .btn-outline-danger {
        color: #ffffffc2;
    }
    .btn-group-toggle .btn-sm,
    .btn-group-toggle .btn-sm {
        font-size: 12px;
    }
    .count-text-color {
        color: #787878;
    }
    .header-height {
        height: 50px;
    }
    .filter-text {
        color: #787878;
    }
    .add-btn-padding {
        padding-right: unset;
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
        right: 52px;
    }
    .btn-top {
        position: relative;
        top: 11px;
    }
    .bottom-content {
        position: relative;
        top: 16px;
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
        background-color: rgba(50, 50, 50, 1);
        color: white;
        height: 40px;
        font-size: .7rem;
    }
    .new-style-table table tr{
        background-color: white;
        color: rgba(22, 22, 23, 1) ;
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

    /* Keep the DataTable fitted to its parent container when columns are hidden/shown. */
    .new-style-table .table-responsive {
        width: 100%;
    }

    .new-style-table #activity_table {
        width: 100% !important;
        max-width: 100%;
        display: table !important;
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
        padding: .399rem;
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
    #activity_table_filter {
        display: none;
    }
    .dropdown-menu-custom {
        left: 45% !important;
        transform: translateX(-50%);
        width: 230% !important;
        max-height: 60vh;
        border-radius: 0rem;
    }
    .custom-tabs {
    display: flex;
    }

    .custom-tab-bar {
        flex: 0 0 auto;
        min-height: 60vh;
        border: none;
        background-color: rgb(247, 247, 247);
    }

    .custom-tab {
        display: block;
        padding: 0.8rem 3rem 0.8rem 0.8rem;
        text-decoration: none;
        color: #333;
        border: none;
        font-size: .8rem;
    }

    .custom-tab:hover {
        background-color: #0f101029;
        color: black;
    }
    .custom-tab.active{
        background-color: #d7eddd;
        color: #4c91e9;
    }

    .custom-tab-content {
        flex: 1 1 auto;
    }

    .custom-tab-pane {
        display: none;
    }

    .custom-tab-pane.active {
        display: block;
    }
    .heading-link:hover {
        text-decoration: underline;
    }
    .highlight {
        background-color: yellow !important;
    }
    .list-group-item{
        min-height: 3.5rem;
    }
    .bulk_table .select2-container{
        width: 100%;
    }
    .bulk_table .select2-container{
        width: 100% !important;
        border: 1px solid #b3b3b3 !important;
        border-radius: 0rem !important;
    }
    .btn-grey-text{
        outline: unset !important;
        width: 100%;
        padding: 6%;
        color: #B3B3B3;
        border: none;
        font-weight: 700;
        font-size: .7rem;
        cursor: pointer;
        background-color: transparent;
        border: 1px solid #b3b3b3;
    }

@media (max-width: 678px){
        .mobile_logged_used_div_1 {
            padding: unset;
            width: 70%;
            padding-left: unset !important;
        }
        .mobile_logged_used_select {
            margin-left: unset !important;
        }
        .mobile_activity_count {
            width: 30%;
            padding-right: unset;
            text-align: center;
        }
        .mobile_activity_count span {
            width: 100%;
        }
        .mobile_card_div {
            background-color: transparent;
        }
        .mobile_search_div {
            padding: unset !important;
        }
        .mobile_search_div_2 {
            width: 100% !important;
        }
        .dropdown-menu-custom {
            width: 133% !important;
        }
        .mobile_main_buttons_div {
            margin-top: unset !important;
        }
        .mobile_add_active_button {
            width: 95%;
        }
        .mobile_activities_sort {
            padding: unset;
            margin-top: unset !important;
        }
        .mobile_activities_sort_2 {
            padding: unset;
        }
        .mobile_activities_sort_3 {
            margin-left: unset !important;
            gap: 5px;
        }
        .mobile_table_div {
            padding: unset;
            padding-top: 10px;
        }
        .dataTables_length {
            text-align: left !important;
        }
        .mobile_temp_buttons {
            padding-bottom: 15px;
        }
    #activity_table {
        display: block !important;
        width: 100% !important;
    }
    #activity_table thead {
        display: block !important;
    }
    #activity_table thead tr {
        display: block !important;
        background-color: transparent;
        border-bottom: unset;
    }
    #activity_table thead th:not(.activity-done) {
        display: none !important;
    }
    #activity_table thead th.activity-done {
        display: flex !important;
        width:100% !important;
        padding: 10px 15px !important;
        border:none !important;
    }
    #activity_table tbody {
        display: block !important;
        width: 100% !important;
    }
    #activity_table tbody tr {
        display:flex !important;
        flex-direction:column;
        width: 100% !important;
        background: #fff;
        border-radius: 12px;
        margin-bottom: 15px;
        padding: 15px;
        box-shadow: 0 3px 12px rgba(0,0,0,.08);
    }
    #activity_table tbody tr td {
        display: flex !important;
        flex-direction: column !important;
        width: 100% !important;
        border: none !important;
        padding: 8px 0 !important;
        align-items: flex-start !important;
        white-space: normal !important;
    }
    #activity_table tbody tr td:before {
        width: 100% !important;
        margin-bottom: 4px;
        font-weight: 600;
        color: #525f7f;
    }
    /* Labels */
    #activity_table tbody td.activity-start-date:before {
        /* content: "Start Date"; */
    }
    #activity_table tbody td.activity-assign-to:before {
        content: "Assign To";
    }
    #activity_table tbody td.activity-description:before {
        /* content: "Subject"; */
    }
    #activity_table tbody td.activity-organization:before {
        content: "Organization";
    }
    #activity_table tbody td.activity-notes:before {
        content: "Notes";
    }
    #activity_table tbody td.activity-order-no:before {
        content: "Order No";
    }
    #activity_table tbody td.activity-contact-person:before {
        content: "Contact Person";
    }
    #activity_table tbody td.activity-created-by:before {
        content: "Created By";
    }
    #activity_table tbody td.activity-priority:before {
        content: "Priority";
    }
    /* Checkbox top right */
    #activity_table tbody td.activity-done {
        position: absolute;
        top: 15px;
        left: 15px;
        width: auto !important;
        display: block !important;
        padding:0 !important;
    }
    #activity_table tbody tr {
        position: relative;
    }
    /* remove datatable width issue */
    .dataTables_scroll,
    .dataTables_scrollBody {
        width: 100% !important;
        overflow: visible !important;
    }
    #activity_table tbody tr {
        position: relative;
        padding: 45px 15px 15px 15px !important;
    }
    #activity_table tbody td.activity-description {
        order: 2;
    }
    #activity_table tbody td.activity-start-date {
        order: 1;
    }
    #activity_table tbody td.activity-priority {
        order: 9;
    }
    #activity_table tbody td.activity-assign-to {
        order: 3;
    }
    #activity_table tbody td.activity-organization {
        order: 4;
    }
    #activity_table tbody td.activity-contact-person {
        order: 7;
    }
    #activity_table tbody td.activity-order-no {
        order: 6;
    }
    #activity_table tbody td.activity-notes {
        order: 5;
    }
    #activity_table tbody td.activity-created-by {
        order: 8;
    }
    #activity_table tbody tr {
        display:flex !important;
        flex-direction:row;
        flex-wrap:wrap;
    }
    #activity_table tbody td.activity-assign-to,
    #activity_table tbody td.activity-order-no,
    #activity_table tbody td.activity-contact-person,
    #activity_table tbody td.activity-created-by,
    #activity_table tbody td.activity-priority,
    #activity_table tbody td.activity-organization {
        width:50% !important;
        flex:0 0 50%;
        box-sizing:border-box;
        display:flex !important;
        flex-direction:column !important;
    }
    #activity_table tbody td.activity-assign-to:empty::after,
    #activity_table tbody td.activity-organization:empty::after,
    #activity_table tbody td.activity-contact-person:empty::after,
    #activity_table tbody td.activity-created-by:empty::after,
    #activity_table tbody td.activity-priority:empty::after,
    #activity_table tbody td.activity-notes:empty::after,
    #activity_table tbody td.activity-start-date:empty::after,
    #activity_table tbody td.activity-order-no:empty::after {
        content:"-";
        color:#8898aa;
    }
    #activity_table tbody td.activity-notes:empty::after {
        width: 100%;
        padding: 5px;
        background-color: rgba(128, 128, 128, 0.12);
    }
    .mobile_table_layout {
        display: none;
    }
    .btn-grey-text {
        padding: .4rem !important;
    }
}


</style>
<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    {{-- <div class="row col-md-12 mb-3" style="padding: 0rem;">
        <div class="col-md-4 ml-auto text-right">
            <button class="btn-green-filled" style="outline: unset;" href="#"  id="add_new_activity" title="Add New Activity">
                ADD ACTIVITY
            </button>
        </div>
    </div> --}}

    {{-- <div class="col-md-12">
        <div class="card header-height">
            <div class="row">
                <div class="col-md-4 mt-2">
                    <div class="row">
                        <div class="col-md-9">
                            <select class="form-control ml-2" id="loggedin_user_id">
                                @foreach ($users as $user)
                                <option value="{{$user->id}}" @if ($user->id == auth()->user()->id) selected @endif>{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-center">
                            <span class="badge badge-pill badge-info"><span id="activity_count"></span>&nbsp;Activites</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">

                </div>
                <div class="col-md-4 mt-2 text-right">
                    <div class="row btn-group btn-group-toggle" data-toggle="buttons" style="padding-right: 2rem;">
                        <label class="btn btn-sm btn-outline-danger active">
                            <input type="radio" class="activity-filter" value="0" autocomplete="off" checked /><span class="filter-text">To Do</span>
                        </label>
                        <label class="btn btn-sm btn-outline-danger">
                            <input type="radio" class="activity-filter"value="1" autocomplete="off" /><span class="filter-text"> Overdue</span>
                        </label>
                        <label class="btn btn-sm btn-outline-danger">
                            <input type="radio" class="activity-filter"value="2" autocomplete="off" /><span class="filter-text"> Today</span>
                        </label>
                        <label class="btn btn-sm btn-outline-danger">
                            <input type="radio" class="activity-filter"value="3" autocomplete="off" id="activity_select_period" /><span class="filter-text"> Selected Period</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div class="col-md-12 btn-top">
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3 btns-right-position">
                <div class="row">
                    <div class="col-md-6 btns-padding">
                            <button class="btns-text btns-style btns-card" style="outline: unset;" href="#"  id="add_activity" title="Add New Activity">
                                Add Activity
                            </button>
                    </div>
                    <div class="col-md-6 btns-padding">
                            <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                                Table Layout
                            </button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="col-md-12 mt-2 bottom-content"  id="activities_interface">

        <div class="card mobile_card_div">
            <div class="row" style="padding-left: 1rem;padding-right: 1rem;">
                <div class="col-md-3 mt-3">
                    <div class="row">
                        <div class="col-md-9 mobile_logged_used_div_1" style="padding-left: 5px;">
                            <select class="form-control ml-2 mobile_logged_used_select" id="loggedin_user_id">
                                @foreach ($users as $user)
                                <option value="{{$user->id}}" @if ($user->id == auth()->user()->id) selected @endif>{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-center mobile_activity_count">
                            <span class="btn-secondary btn-sm" style="background-color: rgba(7, 213, 51, 1); color:white"><span id="activity_count"></span>&nbsp;Activities</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 mt-3 text-center d-flex justify-content-center mobile_search_div" style="padding-left: 10px;">
                    <div class="form-group mobile_search_div_2" style="width: 75%">
                        <div class="input-group input-group-alternative" style="border: 1px solid #b3b3b3;">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="background-color: transparent;"><i class="ni ni-zoom-split-in"></i></span>
                            </div>
                            <input class="form-control" placeholder="Input more than 2 characters" type="text" id="search_input_text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <!-- Dropdown menu -->
                            <div class="dropdown-menu dropdown-menu-custom mt-3" aria-labelledby="search_input_text" style="padding: 0px">
                                <div class="custom-tabs">
                                    <div class="custom-tab-bar">
                                        <a href="#" class="custom-tab active" data-tab="all-tab-content">
                                            <i class="fas fa-list"></i>&nbsp; All
                                        </a>
                                        <a href="#" class="custom-tab" data-tab="organization-tab-content">
                                            <i class="fas fa-building"></i>&nbsp; Organizations
                                        </a>
                                        <a href="#" class="custom-tab" data-tab="peoples-tab-content">
                                            <i class="fas fa-users"></i>&nbsp; Peoples
                                        </a>
                                        <a href="#" class="custom-tab" data-tab="activities-tab-content">
                                            <i class="fas fa-tasks"></i>&nbsp; Activities
                                        </a>
                                    </div>
                                    <div class="custom-tab-content">
                                        <div class="custom-tab-pane active" id="all-tab-content">
                                            <div class="list-group" style="max-height: 59vh; overflow-y: auto;">
                                                <ul class="list-group list-group-flush" id="all-list-ul">
                                                    <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                                        <div class="text-center mt-8">
                                                            <div class="spinner-border" role="status">
                                                                <span><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>&nbsp;&nbsp;Searching Results...</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="custom-tab-pane" id="organization-tab-content">
                                            <div class="list-group" style="max-height: 59vh; overflow-y: auto;">
                                                <ul class="list-group list-group-flush" id="organization-list-ul">
                                                    <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                                        <div class="text-center mt-8">
                                                            <div class="spinner-border" role="status">
                                                                <span><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>&nbsp;&nbsp;Searching Results...</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="custom-tab-pane" id="peoples-tab-content">
                                            <div class="list-group" style="max-height: 59vh; overflow-y: auto;">
                                                <ul class="list-group list-group-flush" id="peoples-list-ul">
                                                    <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                                        <div class="text-center mt-8">
                                                            <div class="spinner-border" role="status">
                                                                <span><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>&nbsp;&nbsp;Searching Results...</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="custom-tab-pane" id="activities-tab-content">
                                            <div class="list-group" style="max-height: 59vh; overflow-y: auto;">
                                                <ul class="list-group list-group-flush" id="activities-list-ul">
                                                    <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                                        <div class="text-center mt-8">
                                                            <div class="spinner-border" role="status">
                                                                <span><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>&nbsp;&nbsp;Searching Results...</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-sm-2 ml-auto mt-3 mb-3 text-right">
                    <button class="styled-button" style="outline: unset;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                        Table Layout
                    </button>
                </div> --}}
                <div class="col-md-4 mt-3 mb-3 text-right mobile_main_buttons_div">
                    <div class="row">
                        <div class="col" style="padding: 0;">
                            <button class="btn-grey-text" href="#" id="export_csv" onclick="exportTasks();"  title="Export CSV">
                                Export
                            </button>
                        </div>
                        <div class="col mobile_table_layout" style="padding: 0;">
                            <button class="styled-button" style="outline: unset;width: 95%;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                                Table Layout
                            </button>
                        </div>
                        <div class="col" style="padding: 0;">
                            <button class="btn-green-filled mobile_add_active_button" style="outline: unset;" href="#"  id="add_new_activity" title="Add New Activity">
                                ADD ACTIVITY
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-2 mobile_activities_sort">
                    <div class="row" style="margin: 0px">
                        <div class="col-md-4 drive-controls activity-top-controls mobile_temp_buttons" style="justify-content: flex-start;padding-left: 0px;display:none">
                            <form action="{{ route('activities.mark_as_done') }}" method="POST">
                                @csrf
                                <input type="hidden" id="mark_as_done_activites" name="mark_as_done_activites[]" />
                                <button type="submit" class="btn btn-secondary btn-sm" title="Mark as Done" style="background-color: rgba(7, 213, 51, 1);color:white" id="mark_as_done"><i class="far fa-check-circle"></i><small>Mark as Done</small></button>
                            </form>
                            <form action="{{ route('activities.mark_as_delete') }}" method="POST">
                                @csrf
                                <input type="hidden" id="mark_to_delete_activites" name="mark_to_delete_activites[]" />
                                <button type="submit" class="btn btn-secondary btn-sm" title="Delete Selected" style="background-color: rgb(255 121 116);color:white" id="mark_as_deleted"><i class="fa fa-times-circle" aria-hidden="true"></i><small>Delete Selected</small></button>
                            </form>
                            <button type="button" class="btn btn-secondary btn-sm" title="Bulk Options" style="background-color: rgb(108 165 221);color:white" id="mark_to_bulk_options"><i class="fa fa-bars" aria-hidden="true"></i><small>Bulk Options</small></button>
                        </div>
                        <div class="col-md-8 text-right ml-auto mobile_activities_sort_2">
                            <div class="row btn-group btn-group-toggle ml-2 mobile_activities_sort_3" data-toggle="buttons" >
                                <label class="btn btn-sm btn-outline-danger active">
                                    <input type="radio" class="activity-filter"value="1" autocomplete="off"  checked  /><span class="filter-text"> Overdue</span>
                                </label>
                                <label class="btn btn-sm btn-outline-danger">
                                    <input type="radio" class="activity-filter"value="2" autocomplete="off"/><span class="filter-text"> Today</span>
                                </label>
                                <label class="btn btn-sm btn-outline-danger">
                                    <input type="radio" class="activity-filter"value="4" autocomplete="off" /><span class="filter-text"> Tommorow </span>
                                </label>
                                <label class="btn btn-sm btn-outline-danger">
                                    <input type="radio" class="activity-filter"value="5" autocomplete="off" /><span class="filter-text"> This Week</span>
                                </label>
                                <label class="btn btn-sm btn-outline-danger">
                                    <input type="radio" class="activity-filter"value="6" autocomplete="off" /><span class="filter-text"> Next Week</span>
                                </label>
                                <label class="btn btn-sm btn-outline-danger">
                                    <input type="radio" class="activity-filter"value="3" autocomplete="off" id="activity_select_period" /><span class="filter-text"> Selected Period</span>
                                </label>
                                <label class="btn btn-sm btn-outline-danger">
                                    <input type="radio" class="activity-filter" value="0" autocomplete="off"/><span class="filter-text">All</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-2 new-style-table mobile_table_div">
                    <div class="table-responsive">
                        @if(session('success'))
                            <div  id="success-message" style="display: none">
                                {{ session('success') }}
                            </div>
                        @endif
                        <table class="table align-items-center table-responsive activity-mobile-card-table" id="activity_table" style="">
                            <thead class="header-style">
                                <th scope="col" class="activity-done">
                                    <div class="custom-control custom-checkbox activity-chechbox-div">
                                        <input type="checkbox" class="custom-control-input" id="activity_chechbox_all" />
                                        <label class="custom-control-label" for="activity_chechbox_all"></label>
                                    </div>
                                </th>
                                <th scope="col" class="activity-start-date">Start Date</th>
                                <th scope="col" class="activity-assign-to">Assign To</th>
                                <th scope="col" class="activity-description">Subject</th>
                                <th scope="col" class="activity-organization">Organization</th>
                                <th scope="col" class="activity-notes">Notes</th>
                                {{-- <th scope="col" class="activity-start-time">Start Time</th> --}}
                                {{-- <th scope="col" class="activity-due-date">Due Date</th> --}}
                                <th scope="col" class="activity-order-no">Order No</th>
                                <th scope="col" class="activity-contact-person">Contact Person</th>
                                <th scope="col" class="activity-created-by">Created By</th>
                                <th scope="col" class="activity-priority">Priority</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('pages.settings.activity.add_activity')
@include('pages.settings.activity.add_new_activity')

<div class="modal fade" id="select_date_range" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title-default">Select Date Range</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form id="add_modal_form">
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="activity-date-group">
                            <input type="text" class="form-control mr-2 date-picker" id="from_date" data-theme="dark" />
                            <span class="mr-2"><i class="fas fa-minus"></i></span>
                            <input type="text" class="form-control mr-2 date-picker" id="to_date" data-theme="dark" />
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn brn-sm btn-success btn-activity-form" id="filter_data"><small>Filter</small></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="layout_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Orders Fields &amp; Layouts</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">
                        <input type="hidden" id="layout_id" name="layout_id" value="{{$activityLayout['id'] ?? 0}}" />
                        <input type="hidden" id="column_reorder" name="column_reorder" value="{{$columnLayout['id'] ?? 0}}" />

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="activity_done"
                                    name="activity_done"
                                    title="Mark as Done"
                                    @isset($activityLayout)
                                        @if ($activityLayout['activity_done'] == 1) checked @endif
                                    @endisset
                                    @empty($activityLayout) checked @endempty
                                />
                                <label class="custom-control-label show-hide-label" for="activity_done">Mark as Done</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="activity_description"
                                    name="activity_description"
                                    title="Description"
                                    @isset($activityLayout)
                                        @if ($activityLayout['activity_description'] == 1) checked @endif
                                    @endisset
                                    @empty($activityLayout) checked @endempty
                                />
                                <label class="custom-control-label show-hide-label" for="activity_description">Description</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="activity_start_date"
                                    name="activity_start_date"
                                    title="Start Date"
                                    @isset($activityLayout)
                                        @if ($activityLayout['activity_start_date'] == 1) checked @endif
                                    @endisset
                                    @empty($activityLayout) checked @endempty
                                />
                                <label class="custom-control-label show-hide-label" for="activity_start_date">Start Date</label>
                            </div>
                        </div>

                        <div class="col-md-4" style="display: none">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="activity_start_time"
                                    name="activity_start_time"
                                    title="Start Time"
                                    @isset($activityLayout)
                                        @if ($activityLayout['activity_start_time'] == 1) checked @endif
                                    @endisset
                                    @empty($activityLayout) checked @endempty
                                />
                                <label class="custom-control-label show-hide-label" for="activity_start_time">Start Time</label>
                            </div>
                        </div>

                        {{-- <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="activity_due_date"
                                    name="activity_due_date"
                                    title="Due Date"
                                    @isset($activityLayout)
                                        @if ($activityLayout['activity_due_date'] == 1) checked @endif
                                    @endisset
                                    @empty($activityLayout) checked @endempty
                                />
                                <label class="custom-control-label show-hide-label" for="activity_due_date">Due Date</label>
                            </div>
                        </div> --}}

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="activity_notes"
                                    name="activity_notes"
                                    title="Notes"
                                    @isset($activityLayout)
                                        @if ($activityLayout['activity_notes'] == 1) checked @endif
                                    @endisset
                                    @empty($activityLayout) checked @endempty
                                />
                                <label class="custom-control-label show-hide-label" for="activity_notes">Notes</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="activity_assign_to"
                                    name="activity_assign_to"
                                    title="Assign To"
                                    @isset($activityLayout)
                                        @if ($activityLayout['activity_assign_to'] == 1) checked @endif
                                    @endisset
                                    @empty($activityLayout) checked @endempty
                                />
                                <label class="custom-control-label show-hide-label" for="activity_assign_to">Assign To</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="activity_order_no"
                                    name="activity_order_no"
                                    title="Order No"
                                    @isset($activityLayout)
                                        @if ($activityLayout['activity_order_no'] == 1) checked @endif
                                    @endisset
                                    @empty($activityLayout) checked @endempty
                                />
                                <label class="custom-control-label show-hide-label" for="activity_order_no">Order No</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="activity_organization"
                                    name="activity_organization"
                                    title="Organization"
                                    @isset($activityLayout)
                                        @if ($activityLayout['activity_organization'] == 1) checked @endif
                                    @endisset
                                    @empty($activityLayout) checked @endempty
                                />
                                <label class="custom-control-label show-hide-label" for="activity_organization">Organization</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="activity_contact_person"
                                    name="activity_contact_person"
                                    title="Contact Person"
                                    @isset($activityLayout)
                                        @if ($activityLayout['activity_contact_person'] == 1) checked @endif
                                    @endisset
                                    @empty($activityLayout) checked @endempty
                                />
                                <label class="custom-control-label show-hide-label" for="activity_contact_person">Contact Person</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="activity_created_by"
                                    name="activity_created_by"
                                    title="Created By"
                                    @isset($activityLayout)
                                        @if ($activityLayout['activity_created_by'] == 1) checked @endif
                                    @endisset
                                    @empty($activityLayout) checked @endempty
                                />
                                <label class="custom-control-label show-hide-label" for="activity_created_by">Created By</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="activity_priority_layout"
                                    name="activity_priority"
                                    title="priority"
                                    @isset($activityLayout)
                                        @if ($activityLayout['activity_priority'] == 1) checked @endif
                                    @endisset
                                    @empty($activityLayout) checked @endempty
                                />
                                <label class="custom-control-label show-hide-label" for="activity_priority_layout">Priority</label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal-footer"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="bulk_options" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered" role="document" style="width: 25rem;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title-default" style="color: black;font-size: 1.2rem;">Bulk Options</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('activities.bulk_options') }}" method="POST" id="bulk_edit_form">
            @csrf
            <input type="hidden" id="mark_to_bulk_options_activites" name="mark_to_bulk_options_activites[]" />

            <div class="modal-body">
                <div class="col-md-12">
                    <table style="width: 100%;" class="bulk_table">
                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col-md-12">
                                        <i class="fa fa-circle" style="color: green" aria-hidden="true">&nbsp;</i><label class="form-label" style="color: grey;">Subject</label>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <select name="bulk[subject][is_edit]" class="invoice-inputs bulk_edit bulk_edit_change">
                                            <option value="0" selected>Keep current value</option>
                                            <option value="1">Edit current value</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3 edit_values">
                                        <input type="text" class="form-control" placeholder="Enter Subject" name="bulk[subject][val]"/>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col-md-12">
                                        <i class="fa fa-circle" style="color: green" aria-hidden="true">&nbsp;</i><label class="form-label" style="color: grey;">Assinged user</label>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <select name="bulk[user][is_edit]" class="invoice-inputs bulk_edit bulk_edit_change">
                                            <option value="0" selected>Keep current value</option>
                                            <option value="1">Edit current value</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3 edit_values">
                                        <select name="bulk[user][val]" class="form-control ml-2 bulk_edit">
                                            @foreach ($users as $user)
                                                <option value="{{$user->id}}" @if ($user->id == auth()->user()->id) selected @endif>{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col-md-12">
                                        <i class="fa fa-circle" style="color: green" aria-hidden="true">&nbsp;</i><label class="form-label" style="color: grey;">Priority</label>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <select name="bulk[priority][is_edit]" class="invoice-inputs bulk_edit bulk_edit_change">
                                            <option value="0" selected>Keep current value</option>
                                            <option value="1">Edit current value</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3 edit_values">
                                        <select name="bulk[priority][val]" class="form-control ml-2 bulk_edit">
                                            <option value="0">Select Priority</option>
                                            <option value="1">&nbsp;Low</option>
                                            <option value="2">&nbsp;Medium</option>
                                            <option value="3">&nbsp;High</option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col-md-12">
                                        <i class="fa fa-circle" style="color: green" aria-hidden="true">&nbsp;</i><label class="form-label" style="color: grey;">Done</label>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <select name="bulk[done][is_edit]" class="invoice-inputs bulk_edit bulk_edit_change">
                                            <option value="0" selected>Keep current value</option>
                                            <option value="1">Edit current value</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3 edit_values">
                                        <div class="col-md-12 mb-3 edit_values">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" id="bulk_edit_mark_done" class="custom-control-input" name="bulk[done][val]"/>
                                                <label class="custom-control-label" for="bulk_edit_mark_done">Mark as done&nbsp;</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col-md-12">
                                        <i class="fa fa-circle" style="color: green" aria-hidden="true">&nbsp;</i><label class="form-label" style="color: grey;">Start date</label>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <select name="bulk[start_date][is_edit]" class="invoice-inputs bulk_edit bulk_edit_change">
                                            <option value="0" selected>Keep current value</option>
                                            <option value="1">Edit current value</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3 edit_values">
                                        <input type="text" class="form-control date-picker" placeholder="Select date Here" name="bulk[start_date][val]" data-theme="dark"/>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" style="width: 100%;font-size: 1rem;" class="btn brn-sm btn-success btn-activity-form"><small>Edit <span id="bulk_option_checked_count">10</span> activities</small></button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
            $('.bulk_edit_change').change(function() {
                var $this = $(this);
                var selectedValue = $this.val();
                var $tr = $this.closest('tr');

                if (selectedValue == '0') {
                    $tr.find('.edit_values').hide();
                    $tr.find('.fa-circle').hide();
                } else {
                    $tr.find('.edit_values').show();
                    $tr.find('.fa-circle').show();
                }
            }).trigger('change');
        });
        $('#bulk_edit_form').on('submit', function(e){
            e.preventDefault();
            $(".se-pre-con").fadeIn('slow');
            this.submit();
        });
    $(document).ready(function() {

        $('.bulk_edit').select2();

        $('#mark_to_bulk_options').click(function() {
            $('#bulk_options').modal('show');
        });

        $(".custom-tab").click(function(event) {
            event.preventDefault();
            var targetTabId = $(this).data("tab");
            var targetTab = $("#" + targetTabId);
            if (!targetTab.hasClass("active")) {
                $(".custom-tab-pane").removeClass("active");
                targetTab.addClass("active");
                $(".custom-tab").removeClass("active");
                $(this).addClass("active");
            }
        });


       $(document).click(function(event) {
            var dropdownMenu = $('.dropdown-menu-custom');
            var searchInput = $('#search_input_text');
            if (!dropdownMenu.is(event.target) && dropdownMenu.has(event.target).length === 0 && !searchInput.is(event.target)) {
                dropdownMenu.removeClass('show');
            }
        });


        $('#search_input_text').focus(function() {
            $('.dropdown-menu-custom').addClass('show');
        });

        $('#search_input_text').on('input', function() {

            var input_text = $(this).val();

            if(input_text != '' && input_text.length > 2){
                $.ajax({
                    url: '{{ url("activities/filter_search_data") }}',
                    type: "GET",
                    dataType: 'json',
                    data: {
                        'input_text': input_text, '_token':'{{csrf_token()}}'
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (data) {
                        var persons = @json($all_persons);
                        var organizations = @json($all_organizations);

                        var activity_content = '';

                        if(data[0].length > 0){
                            data[0].forEach(element => {

                                var activity_org = organizations.find(organization => organization.id == element.organization_id);
                                var orgName = (activity_org) ? activity_org.organization_name + ', ' : '';

                                var act_person = persons.find(person => person.id == element.contact_id);

                                var personName = (act_person) ? ((act_person.first_name ? act_person.first_name : '') + ' ' + (act_person.last_name ? act_person.last_name : '')) : '';

                                activity_content +=
                                                    `<li class="list-group-item d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-tasks fa-lg mr-3" style="color: black;"></i>
                                                            <div>
                                                                <a href="#" class="mb-1 heading-link activity-edit" data-activiy_id="${element.id}"  style="font-size: 1rem;color: black;font-weight: 500;">${element.activity_subject}</a><br>
                                                                <small>${orgName} ${personName}</small>
                                                            </div>
                                                        </div>
                                                    </li>`;
                            });
                        }else{
                            var activity_content = `<div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                                        <div class="text-center mt-8">
                                                            <div class="spinner-border" role="status">
                                                                <span><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>&nbsp;&nbsp;No result found...</span>
                                                            </div>
                                                        </div>
                                                    </div>`;
                        }
                        var org_content = '';
                        if(data[1].length > 0){
                            data[1].forEach(element => {
                                var organizationId = element.id;
                                var route = '{{ route("organizations.info", ['id' => ':id']) }}';
                                var url = route.replace(':id', organizationId);

                                var org_shipping_street = (element.shipping_street) ? element.shipping_street + ', ' : '';
                                var org_shipping_city = (element.shipping_city) ? element.shipping_city + ', ' : '';
                                var org_shipping_state = (element.shipping_state) ? element.shipping_state + ', ' : '';
                                var org_shipping_postal_code = (element.shipping_postal_code) ? element.shipping_postal_code + ', ' : '';
                                var org_shipping_country = (element.shipping_country) ? element.shipping_country : '';

                                var full_address =  org_shipping_street + org_shipping_city + org_shipping_state + org_shipping_postal_code + org_shipping_country;

                                if(full_address.length > 60){
                                    full_address = full_address.substring(0, 60) + '...';
                                }

                                var org_website = (element.website) ? element.website + ', ' : '';

                                if(org_website.length > 60){
                                    org_website = org_website.substring(0, 60) + '...';
                                }

                                var org_email = (element.email) ? element.email : '';

                                var line1 = (full_address) ? `<small>${full_address}</small><br>` : '';
                                var line2 = (org_website || org_email) ? `<small>${org_website} ${org_email}</small>` : '';


                                org_content +=
                                                `<li class="list-group-item d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-building fa-lg mr-3" style="color: black;"></i>
                                                        <div>
                                                            <a href="${url}" target="blank" class="mb-1 heading-link" style="font-size: 1rem;color: black;font-weight: 500;">${element.organization_name}</a><br>
                                                            ${line1}
                                                            ${line2}
                                                        </div>
                                                    </div>
                                                </li>`;
                            });
                        }else{
                            var org_content = `<div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                                        <div class="text-center mt-8">
                                                            <div class="spinner-border" role="status">
                                                                <span><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>&nbsp;&nbsp;No result found...</span>
                                                            </div>
                                                        </div>
                                                    </div>`;
                        }
                        var people_content = '';
                        if(data[2].length > 0){
                            data[2].forEach(element => {
                                var peopleId = element.id;
                                var route = '{{ route('people.info', ['id' => ':id']) }}';
                                var url = route.replace(':id', peopleId);

                                var person_name = (element.first_name ? element.first_name : '') + ' ' + (element.last_name ? element.last_name : '')

                                var person_email = (element.email ? element.email : '')

                                var people_shipping_street = (element.shipping_street) ? element.shipping_street + ', ' : '';
                                var people_shipping_city = (element.shipping_city) ? element.shipping_city + ', ' : '';
                                var people_shipping_state = (element.shipping_state) ? element.shipping_state + ', ' : '';
                                var people_shipping_zip = (element.shipping_zip) ? element.shipping_zip + ', ' : '';
                                var people_shipping_country = (element.shipping_country) ? element.shipping_country : '';

                                var full_address =  people_shipping_street + people_shipping_city + people_shipping_state + people_shipping_zip + people_shipping_country;

                                if(full_address.length > 60){
                                    full_address = full_address.substring(0, 60) + '...';
                                }

                                var line1 = (full_address) ? `<small>${full_address}</small><br>` : '';
                                var line2 = (person_email) ? `<small>${person_email}</small>` : '';

                                people_content +=
                                                `<li class="list-group-item d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-user fa-lg mr-3" style="color: black;"></i>
                                                        <div>
                                                            <a href="${url}" target="blank" class="mb-1 heading-link" style="font-size: 1rem;color: black;font-weight: 500;">${person_name}</a><br>
                                                            ${line1}
                                                            ${line2}
                                                        </div>
                                                    </div>
                                                </li>`;
                            });
                        }else{
                            var people_content = `<div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                                        <div class="text-center mt-8">
                                                            <div class="spinner-border" role="status">
                                                                <span><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>&nbsp;&nbsp;No result found...</span>
                                                            </div>
                                                        </div>
                                                    </div>`;
                        }


                        var highlighted_activity_content = highlightSearchText(activity_content, data[3]);
                        $('#activities-list-ul').html(highlighted_activity_content);

                        var highlighted_people_content = highlightSearchText(people_content, data[3]);
                        $('#peoples-list-ul').html(highlighted_people_content);

                        var highlighted_org_content = highlightSearchText(org_content, data[3]);
                        $('#organization-list-ul').html(highlighted_org_content);

                        if(data[0].length == 0){
                            if(data[1].length == 0){
                                $('#all-list-ul').html(highlighted_people_content);
                            }else if(data[2].length == 0){
                                $('#all-list-ul').html(highlighted_org_content);
                            }else{
                                $('#all-list-ul').html(highlighted_org_content + highlighted_people_content);
                            }

                        }else if(data[1].length == 0){
                            if(data[0].length == 0){
                                $('#all-list-ul').html(highlighted_people_content);
                            }else if(data[2].length == 0){
                                $('#all-list-ul').html(highlighted_activity_content);
                            }else{
                                $('#all-list-ul').html(highlighted_people_content + highlighted_activity_content);
                            }


                        }else if(data[2].length == 0){
                            if(data[0].length == 0){
                                $('#all-list-ul').html(highlighted_org_content);
                            }else if(data[1].length == 0){
                                $('#all-list-ul').html(highlighted_activity_content);
                            }else{
                                $('#all-list-ul').html(highlighted_org_content + highlighted_activity_content);
                            }
                        }else{
                            $('#all-list-ul').html(highlighted_org_content + highlighted_people_content + highlighted_activity_content);
                        }

                    },
                    complete: function () {
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            }



        });
    });
    function highlightSearchText(content, searchText) {
        var escapedSearchText = searchText.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        // Regular expression to exclude matches within attribute values
        var regex = new RegExp(`(?!<a[^>]*?>)(?![^<]*?(?:"|'))(${escapedSearchText})(?![^<]*?<\/a>)`, 'gi');
        var highlightedContent = content.replace(regex, '<span class="highlight">$1</span>');
        return highlightedContent;
    }
</script>


<script>

    $(document).ready(function() {
        $('#mark_as_deleted').click(function(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    // If user confirms, submit the form
                    $('#mark_to_delete_activites').closest('form').submit();
                }
            });
        });
    });

    let header = "ACTIVITIES";
        document.getElementById("header").innerHTML = header;

        $(document).ready(function() {
            $('#activity_chechbox_all').change(function() {
                var checked = $(this).is(':checked');
                $('.activity-chechbox').prop('checked', checked).trigger('change');
            });

            $('body').on('change', '.activity-chechbox', function() {
                var activity_array = [];
                $('.activity-chechbox:checked').each(function() {
                    activity_array.push($(this).val());
                });

                $('#bulk_option_checked_count').text(activity_array.length);

                if (activity_array.length > 0) {
                    $('#mark_as_done_activites').val(activity_array);
                    $('#mark_to_bulk_options_activites').val(activity_array);
                    $('#mark_to_delete_activites').val(activity_array);
                    $('.activity-top-controls').show(700);
                } else {
                    $('#mark_as_done_activites').val('');
                    $('#mark_to_bulk_options_activites').val('');
                    $('#mark_to_delete_activites').val('');
                    $('.activity-top-controls').hide(700);
                }
            });
        });

    $(document).ready( function () {
        // var now_date = moment().format('L');
        // duDatepicker('.date-picker', 'setValue', now_date, { format: 'dd mmm, yyyy' });

        // var layout_id = $('#layout_id').val();
        // if (layout_id == 0) {
        //     $.ajax({
        //         url: "{{ url('activities/column_layout') }}",
        //         type: "POST",
        //         data: { '_token':'{{csrf_token()}}' },
        //         success: function (data) {
        //             console.log(data);
        //         },
        //     });
        // }
        $('.date-picker').datepicker({
            dateFormat: 'mm/dd/yy', // Date picker format
            showAnim: 'slideDown',
            changeMonth: true,
            changeYear: true,
            onSelect: function(dateText) {
                $(this).trigger('change');
            }
        });

        var activityTable = $('#activity_table').DataTable({
            colReorder: true,
            stateSave: true,
            "autoWidth": false,
            "pageLength": 50,
            "columnDefs": [
                { "orderable": false, "targets": "activity-done" }
            ],
            "drawCallback": function(settings) {
                displayTable();
            }
        });

        // save column order when move
        activityTable.on('column-reorder', function (e, settings, details) {
            var column_reorder = $('#column_reorder').val();

            if (column_reorder == 0) {
                var column_order = '[0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]';

            } else {
                var columnStr = localStorage.getItem("DataTables_activity_table_/activities");
                var columnObj = JSON.parse(columnStr);
                var colReorder = new $.fn.dataTable.ColReorder( activityTable );
                var curr = colReorder.fnOrder();
                var column_order = JSON.stringify(curr);
            }

            console.log(column_order);

            var interface_name = 'Activity';
            var interface_id = 14;

            $.ajax({
                url: '{{ route("datatable.column_order") }}',
                type: "POST",
                data: {
                    'interface_name': interface_name, 'interface_id': interface_id, 'column_order':column_order, '_token':'{{csrf_token()}}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function(data) {
                    console.log(data);
                    $('#column_reorder').val(column_order);
                },
                complete: function () {
                    displayTable();
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        });

        var user_id = $('#loggedin_user_id').val();
        var filter = $('input:radio.activity-filter:checked').val();
        var from_date = '01-01-2000';
        var to_date = '01-01-2050';
        getActivities(user_id, filter, from_date, to_date);

        // $(document).on('click', function(event) {
        //     if (!$(event.target).closest('#search_input_text').length) {
        //         searchActivities();
        //     }
        // });

        // $('#search_input_text').keypress(function(event) {
        //     if (event.which === 13) {
        //         searchActivities();
        //     }
        // });

        // function searchActivities() {
        //     var search_input_text = $('#search_input_text').val().trim();
        //     if (search_input_text !== '') {
        //         var user_id = $('#loggedin_user_id').val();
        //         var filter = $('input:radio.activity-filter:checked').val();
        //         var from_date = 0;
        //         var to_date = search_input_text;
        //         getActivities(user_id, filter, from_date, to_date);
        //     }
        // }

        function getActivities(user_id, filter, from_date, to_date) {
            console.log(user_id, filter, from_date, to_date);
            $.ajax({
                url: '{{ url("activities/get_activities") }}/'+user_id+'/'+filter+'/'+from_date+'/'+to_date,
                type: "GET",
                dataType: 'json',
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data) {
                    if (data[1] < 10) {
                        var activity_count = '0'+data[1];
                    } else {
                        var activity_count = data[1];
                    }
                    $('#activity_count').html(activity_count);

                    makeTable(data[0]);
                    $('#search_input_text').val('');
                },
                complete: function () {
                    displayTable();
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        }

        function makeTable(data) {

            $('#mark_as_done_activites').val('');
            $('#mark_to_bulk_options_activites').val('');
            $('#mark_to_delete_activites').val('');
            $('.activity-top-controls').hide(700);
            $('#activity_chechbox_all').prop('checked', false).trigger('change');

            activityTable.clear().draw();

            var columnStr = localStorage.getItem("DataTables_activity_table_/activities");
            var columnObj = JSON.parse(columnStr);
            var colReorder = new $.fn.dataTable.ColReorder( activityTable );
            var curr = colReorder.fnOrder();

            var classArr = [];
            classArr.push(
                'activity-done', 'activity-start-date', 'activity-assign-to', 'activity-description', 'activity-organization', 'activity-notes',
                'activity-order-no', 'activity-contact-person', 'activity-created-by', 'activity-priority'
            );

            for (let i = 0; i < data.length; i++) {
                var start_date = moment(data[i].start_date).format('L');
                var start_time = moment(data[i].start_date).format('LT');
                var due_date = moment(data[i].due_date).format('L');

                var priority = '';
                if(data[i].priority == 1){
                    priority = '<span class="badge badge-pill" style="color:#FFB916;background-color:#FFF6CC;width:100%">LOW</span>';
                }else if(data[i].priority == 2){
                    priority = '<span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:100%">MEDIUM</span>';
                }else if(data[i].priority == 3){
                    priority = '<span class="badge badge-pill" style="color:#d381ff;background-color:#f9dfff;width:100%">HIGH</span>';
                }

                if (data[i].order_details) {
                    var order_no = data[i].order_details.order_no
                } else {
                    var order_no = '';
                }

                if (data[i].organization_details) {
                    var organization_name = data[i].organization_details.organization_name;
                    var organization_id = data[i].organization_details.id ?? '';
                } else {
                    var organization_name = '';
                }

                if (data[i].contact_details) {
                    var contact_name = data[i].contact_details.first_name + ' ' + data[i].contact_details.last_name;
                } else {
                    var contact_name = '';
                }

                if (data[i].assignee_details) {
                    var assignee_name = data[i].assignee_details.name;
                } else {
                    var assignee_name = '';
                }

                if (data[i].user_details) {
                    var user_name = data[i].user_details.name;
                } else {
                    var user_name = '';
                }

                var is_checked = '';

                if(data[i].is_done == 1){
                    var is_checked = 'checked';
                }

                var checkbox = '<div class="custom-control custom-checkbox activity-chechbox-div">'+
                                    '<input type="checkbox" class="custom-control-input for_tr_styles activity-chechbox" id="activity_chechbox_'+data[i].id+'" value="'+data[i].id+'"'+is_checked+' />'+
                                    '<label class="custom-control-label" for="activity_chechbox_'+data[i].id+'"></label>'+
                                '</div>';

                var column_data_arr = [];

                var a_tag_color = '';

                var over_due_tr = '';

                var start_date = new Date(data[i].start_date);
                start_date.setHours(0, 0, 0, 0);
                var now = new Date();
                now.setHours(0, 0, 0, 0);

                console.log('assignee_name '+assignee_name+ 'Date start : now '+start_date+' : '+now);

                if(data[i].is_done == 1){
                    console.log('match for done');
                    var a_tag_color = 'style="color:rgb(179, 179, 179) !important;"';
                }else{
                    console.log('match for no done');
                    if(start_date.getTime() === now.getTime()){

                        console.log('match dates');
                        var a_tag_color = 'style="color:#2dce89 !important;"';
                        var over_due_tr = 'today_tr_class';
                    }else if(start_date < now){
                        console.log('Not match dates');
                        var a_tag_color = 'style="color:red !important;"';
                        var over_due_tr = 'overdue_tr_class';
                    }

                }

                var htmlContent = data[i].activity_note;
                var tempElement = document.createElement('div');
                tempElement.innerHTML = htmlContent;

                var plainTextNote = tempElement.innerText;
                if (plainTextNote.length > 100) {
                    plainTextNote = plainTextNote.substring(0, 100) + "...";
                }

                var activitySubject = data[i].activity_subject;
                if (activitySubject.length > 100) {
                    activitySubject = activitySubject.substring(0, 100) + "...";
                }


                column_data_arr.push(
                    checkbox,
                    moment(start_date).format("MM/DD/YYYY"),
                    assignee_name,
                    '<a href="#" '+ a_tag_color +' class="activity-edit '+over_due_tr+'" data-activiy_id="'+data[i].id+'">'+activitySubject+'</a>',
                    '<a '+ a_tag_color +'  href="organizations/info/'+ organization_id +'" target="_blank">' + organization_name + '</a>', // Link to organization page
                    plainTextNote,
                    order_no,
                    contact_name,
                    user_name,
                    priority
                );

                var row = activityTable.row.add([
                    column_data_arr[curr[0]],
                    column_data_arr[curr[1]],
                    column_data_arr[curr[2]],
                    column_data_arr[curr[3]],
                    column_data_arr[curr[4]],
                    column_data_arr[curr[5]],
                    column_data_arr[curr[6]],
                    column_data_arr[curr[7]],
                    column_data_arr[curr[8]],
                    column_data_arr[curr[9]],
                ]);

                activityTable.row(row).draw();
                activityTable.row(row).column(0).nodes().to$().addClass(classArr[curr[0]]);
                activityTable.row(row).column(1).nodes().to$().addClass(classArr[curr[1]]);
                activityTable.row(row).column(2).nodes().to$().addClass(classArr[curr[2]]);
                activityTable.row(row).column(3).nodes().to$().addClass(classArr[curr[3]]);
                activityTable.row(row).column(4).nodes().to$().addClass(classArr[curr[4]]);
                activityTable.row(row).column(5).nodes().to$().each(function() {
                                                                                    var $this = $(this);
                                                                                    var text = $this.text();
                                                                                    if (text.length > 20) {
                                                                                        text = text.substring(0, 20) + '...'; // Truncate text to 20 characters and add ellipsis
                                                                                    }
                                                                                    $this.text(text);
                                                                                }).addClass(classArr[curr[5]]);
                activityTable.row(row).column(6).nodes().to$().addClass(classArr[curr[6]]);
                activityTable.row(row).column(7).nodes().to$().addClass(classArr[curr[7]]);
                activityTable.row(row).column(8).nodes().to$().addClass(classArr[curr[8]]);
                // activityTable.row(row).column(6).nodes().to$().addClass(classArr[curr[6]]);
                activityTable.row(row).column(9).nodes().to$().addClass(classArr[curr[9]]);
                activityTable.row(row).draw();
            }
            textStyle();

        }


        $('#loggedin_user_id').on('change', function() {
            var user_id = $(this).val();
            var filter = $('.active .activity-filter').val();
            var from_date = '01-01-2000';
            var to_date = '01-01-2050';

            getActivities(user_id, filter, from_date, to_date);
        });

        $('input:radio.activity-filter').on('change', function() {
            var user_id = $('#loggedin_user_id').val();
            var filter = $(this).val();
            var from_date = '01-01-2000';
            var to_date = '01-01-2050';

            if (filter == 3) {
                $('#select_date_range').modal('show');
            } else {
                getActivities(user_id, filter, from_date, to_date);
            }
        });

        $('#activity_select_period').on('focus', function() {
            $('#select_date_range').modal('show');
        });

        $('#filter_data').on('click', function() {
            var user_id = $('#loggedin_user_id').val();
            var filter = 3;
            var from_date = $('#from_date').val().replace(/\//g, '-');
            var to_date = $('#to_date').val().replace(/\//g, '-');

            $('#select_date_range').modal('hide');

            getActivities(user_id, filter, from_date, to_date);
        });
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('open_modal')) {
                const activity_id = urlParams.get('activity_id');


                // Optionally, use the activityId to load data
                if (activity_id) {
                    $('#activity_delete_button').show();

$.ajax({
    url:"{{ url('activities/get_organizations') }}",
    method:'GET',
    dataType:'json',
    beforeSend: function () {
        $(".se-pre-con").fadeIn('slow');
    },
    success: function (data){
        var organizations = data;

        var org_options = '<option value="">Select an Organization</option>';
        for (let i = 0; i < organizations.length; i++) {
            org_options += '<option value="'+organizations[i].id+'">'+organizations[i].organization_name+'</option>';
        }
        $('#activity_organization_id').html(org_options);
    },
    complete: function () {
        $.ajax({
            url:"{{ url('activities/get_activity_by_id') }}/"+activity_id,
            method:'GET',
            dataType:'json',
            success: function (data){
                var start_date = moment(data.start_date).format('L');
                var start_time = moment(data.start_date).format('LT');
                var due_date = moment(data.due_date).format('L');

                var today_day = moment().format('dddd, MMMM Do');
                var today_date = moment().format('L');
                $('#selected_day').html(today_day);
                $('#selected_date').val(today_date);

                var today_date = today_date.replace(/\//g, '-');
                getActivitiesByDate(today_date);

                $('#activity_note').val('');
                $('#activity_order_id').val('').trigger('change');
                $('#activity_organization_id').val('').trigger('change');
                $('#activity_contact_id').val('').trigger('change');

                $('#activity_id').val(activity_id);
                $('#activity_subject').val(data.activity_subject);
                $('#activity_note').val(data.activity_note);
                quill.clipboard.dangerouslyPasteHTML(data.activity_note);
                $('#activity_priority').val(data.priority).trigger('change');
                $('#start_date').val(start_date);
                if(moment(data.start_date).format('HH:mm:ss') !== '00:00:00'){
                    $('#start_time').val(start_time);
                }else{
                    $('#start_time').val('');
                }
                $('#due_date').val(due_date);
                $('#activity_user_id').val(data.assigned_to).trigger('change');

                $('#activity_organization_id').val(data.organization_id).trigger('change');
                activity_order_id = data.order_id;
                activity_contact_id = data.contact_id;

                $('#submit_btn_text').html('Update');
                $('#new_activity_form_title').html('Edit Activity');
                $('#is_done_div').removeAttr('hidden');
                $('#add_activity_form').attr('action', '{{ route("activities.update") }}');

                var assignedUserName = '';
                var modifiedUserName = '';


                var all_users = @json($all_users);
                var auth_user = @json(auth()->user()->id);

                if(data.created_by !== null){
                var assignedUser = all_users.find(user => user.id == data.created_by);
                }else{
                    var assignedUser = all_users.find(user => user.id == data.assigned_to);
                }
                if(assignedUser){
                    if(assignedUser.id == auth_user){
                        assignedUserName = assignedUser.name + ' (You)'
                    }else{
                        assignedUserName = assignedUser.name
                    }
                }else{
                    assignedUserName = '';
                }
                if(data.modified_by !== null){
                    var modifiedUser = all_users.find(user => user.id == data.modified_by);
                    if(modifiedUser){
                        if(modifiedUser.id == auth_user){
                            modifiedUserName = modifiedUser.name + ' (You)'
                        }else{
                            modifiedUserName = modifiedUser.name
                        }
                    }else{
                        modifiedUserName = '';
                    }
                }

                $('#created_at_tr').html(`<td style="color: grey;padding-top:15px">Created : ${formatDate(data.created_at)}  ${assignedUserName} </td>`);
                $('#modified_at_tr').html(`<td style="color: grey;">Last Modified : ${formatDate(data.updated_at)}  ${modifiedUserName} </td>`);
            },
            complete: function () {
                // $('#activity_popup').show(700);
                $('#activity_modal_new').modal('show');
                $(".se-pre-con").fadeOut('slow');
            }
        });

    }
});
                }
            }
        });

        $('body').on('click', '.activity-edit', function(e){
            e.preventDefault();
            var activity_id = $(this).data('activiy_id');
            $('#activity_delete_button').show();

            $.ajax({
                url:"{{ url('activities/get_organizations') }}",
                method:'GET',
                dataType:'json',
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data){
                    var organizations = data;

                    var org_options = '<option value="">Select an Organization</option>';
                    for (let i = 0; i < organizations.length; i++) {
                        org_options += '<option value="'+organizations[i].id+'">'+organizations[i].organization_name+'</option>';
                    }
                    $('#activity_organization_id').html(org_options);
                },
                complete: function () {
                    $.ajax({
                        url:"{{ url('activities/get_activity_by_id') }}/"+activity_id,
                        method:'GET',
                        dataType:'json',
                        success: function (data){
                            var start_date = moment(data.start_date).format('L');
                            var start_time = moment(data.start_date).format('LT');
                            var due_date = moment(data.due_date).format('L');

                            var today_day = moment().format('dddd, MMMM Do');
                            var today_date = moment().format('L');
                            $('#selected_day').html(today_day);
                            $('#selected_date').val(today_date);

                            var today_date = today_date.replace(/\//g, '-');
                            getActivitiesByDate(today_date);

                            $('#activity_note').val('');
                            $('#activity_order_id').val('').trigger('change');
                            $('#activity_organization_id').val('').trigger('change');
                            $('#activity_contact_id').val('').trigger('change');

                            $('#activity_id').val(activity_id);
                            $('#activity_subject').val(data.activity_subject);
                            $('#activity_note').val(data.activity_note);
                            quill.clipboard.dangerouslyPasteHTML(data.activity_note);
                            $('#activity_priority').val(data.priority).trigger('change');
                            $('#start_date').val(start_date);
                            if(moment(data.start_date).format('HH:mm:ss') !== '00:00:00'){
                                $('#start_time').val(start_time);
                            }else{
                                $('#start_time').val('');
                            }
                            $('#due_date').val(due_date);
                            $('#activity_user_id').val(data.assigned_to).trigger('change');

                            $('#activity_organization_id').val(data.organization_id).trigger('change');
                            activity_order_id = data.order_id;
                            activity_contact_id = data.contact_id;

                            $('#submit_btn_text').html('Update');
                            $('#new_activity_form_title').html('Edit Activity');
                            $('#is_done_div').removeAttr('hidden');
                            $('#add_activity_form').attr('action', '{{ route("activities.update") }}');

                            var assignedUserName = '';
                            var modifiedUserName = '';


                            var all_users = @json($all_users);
                            var auth_user = @json(auth()->user()->id);

                            if(data.created_by !== null){
                            var assignedUser = all_users.find(user => user.id == data.created_by);
                            }else{
                                var assignedUser = all_users.find(user => user.id == data.assigned_to);
                            }
                            if(assignedUser){
                                if(assignedUser.id == auth_user){
                                    assignedUserName = assignedUser.name + ' (You)'
                                }else{
                                    assignedUserName = assignedUser.name
                                }
                            }else{
                                assignedUserName = '';
                            }
                            if(data.modified_by !== null){
                                var modifiedUser = all_users.find(user => user.id == data.modified_by);
                                if(modifiedUser){
                                    if(modifiedUser.id == auth_user){
                                        modifiedUserName = modifiedUser.name + ' (You)'
                                    }else{
                                        modifiedUserName = modifiedUser.name
                                    }
                                }else{
                                    modifiedUserName = '';
                                }
                            }

                            $('#created_at_tr').html(`<td style="color: grey;padding-top:15px">Created : ${formatDate(data.created_at)}  ${assignedUserName} </td>`);
                            $('#modified_at_tr').html(`<td style="color: grey;">Last Modified : ${formatDate(data.updated_at)}  ${modifiedUserName} </td>`);
                        },
                        complete: function () {
                            // $('#activity_popup').show(700);
                            $('#activity_modal_new').modal('show');
                            $(".se-pre-con").fadeOut('slow');
                        }
                    });

                }
            });


        });
        const formatDate = (datetime) => {
            const date = new Date(datetime);
            const options = {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                hour12: true,
                timeZoneName: 'short'
            };

            return new Intl.DateTimeFormat('en-US', options).format(date);
        };
    });

    function displayTable() {
        if($('#activity_done').is(':checked')) {
            $('.activity-done').css('display', 'table-cell');
        } else {
            $('.activity-done').css('display', 'none');
        }

        if($('#activity_description').is(':checked')) {
            $('.activity-description').css('display', 'table-cell');
        } else {
            $('.activity-description').css('display', 'none');
        }

        if($('#activity_start_date').is(':checked')) {
            $('.activity-start-date').css('display', 'table-cell');
        } else {
            $('.activity-start-date').css('display', 'none');
        }

        if($('#activity_start_time').is(':checked')) {
            $('.activity-start-time').css('display', 'none');
        } else {
            $('.activity-start-time').css('display', 'none');
        }

        if($('#activity_due_date').is(':checked')) {
            $('.activity-due-date').css('display', 'table-cell');
        } else {
            $('.activity-due-date').css('display', 'none');
        }

        if($('#activity_notes').is(':checked')) {
            $('.activity-notes').css('display', 'table-cell');
        } else {
            $('.activity-notes').css('display', 'none');
        }

        if($('#activity_assign_to').is(':checked')) {
            $('.activity-assign-to').css('display', 'table-cell');
        } else {
            $('.activity-assign-to').css('display', 'none');
        }

        if($('#activity_order_no').is(':checked')) {
            $('.activity-order-no').css('display', 'table-cell');
        } else {
            $('.activity-order-no').css('display', 'none');
        }

        if($('#activity_organization').is(':checked')) {
            $('.activity-organization').css('display', 'table-cell');
        } else {
            $('.activity-organization').css('display', 'none');
        }

        if($('#activity_contact_person').is(':checked')) {
            $('.activity-contact-person').css('display', 'table-cell');
        } else {
            $('.activity-contact-person').css('display', 'none');
        }

        if($('#activity_created_by').is(':checked')) {
            $('.activity-created-by').css('display', 'table-cell');
        } else {
            $('.activity-created-by').css('display', 'none');
        }
        if($('#activity_priority_layout').is(':checked')) {
            $('.activity-priority').css('display', 'table-cell');
        } else {
            $('.activity-priority').css('display', 'none');
        }

        // Recalculate DataTables column widths after changing column visibility.
        if ($.fn.DataTable.isDataTable('#activity_table')) {
            var table = $('#activity_table').DataTable();
            table.columns.adjust();
            $('#activity_table').css('width', '100%');
        }
    }

    $('body').on('click', '#layout_modal_show', function(){
        $('#layout_modal').modal('show');
    });
    $('body').on('click', '#activity_priority_layout', function(){
        if($(this).is(':checked')) {
            $('.activity-priority').css('display', 'table-cell');
            var attribute_name = 'activity_priority';
            showColumn(attribute_name);

        } else {
            $('.activity-priority').css('display', 'none');
            var attribute_name = 'activity_priority';
            hideColumn(attribute_name);
        }
    });

    $('body').on('click', '#activity_done', function(){
        if($(this).is(':checked')) {
            $('.activity-done').css('display', 'table-cell');
            var attribute_name = 'activity_done';
            showColumn(attribute_name);

        } else {
            $('.activity-done').css('display', 'none');
            var attribute_name = 'activity_done';
            hideColumn(attribute_name);
        }
    });

    $('body').on('click', '#activity_description', function(){
        if($(this).is(':checked')) {
            $('.activity-description').css('display', 'table-cell');
            var attribute_name = 'activity_description';
            showColumn(attribute_name);

        } else {
            $('.activity-description').css('display', 'none');
            var attribute_name = 'activity_description';
            hideColumn(attribute_name);
        }
    });

    $('body').on('click', '#activity_start_date', function(){
        if($(this).is(':checked')) {
            $('.activity-start-date').css('display', 'table-cell');
            var attribute_name = 'activity_start_date';
            showColumn(attribute_name);

        } else {
            $('.activity-start-date').css('display', 'none');
            var attribute_name = 'activity_start_date';
            hideColumn(attribute_name);
        }
    });

    $('body').on('click', '#activity_start_time', function(){
        if($(this).is(':checked')) {
            $('.activity-start-time').css('display', 'none');
            var attribute_name = 'activity_start_time';
            showColumn(attribute_name);

        } else {
            $('.activity-start-time').css('display', 'none');
            var attribute_name = 'activity_start_time';
            hideColumn(attribute_name);
        }
    });

    $('body').on('click', '#activity_due_date', function(){
        if($(this).is(':checked')) {
            $('.activity-due-date').css('display', 'table-cell');
            var attribute_name = 'activity_due_date';
            showColumn(attribute_name);

        } else {
            $('.activity-due-date').css('display', 'none');
            var attribute_name = 'activity_due_date';
            hideColumn(attribute_name);
        }
    });

    $('body').on('click', '#activity_notes', function(){
        if($(this).is(':checked')) {
            $('.activity-notes').css('display', 'table-cell');
            var attribute_name = 'activity_notes';
            showColumn(attribute_name);

        } else {
            $('.activity-notes').css('display', 'none');
            var attribute_name = 'activity_notes';
            hideColumn(attribute_name);
        }
    });

    $('body').on('click', '#activity_assign_to', function(){
        if($(this).is(':checked')) {
            $('.activity-assign-to').css('display', 'table-cell');
            var attribute_name = 'activity_assign_to';
            showColumn(attribute_name);

        } else {
            $('.activity-assign-to').css('display', 'none');
            var attribute_name = 'activity_assign_to';
            hideColumn(attribute_name);
        }
    });

    $('body').on('click', '#activity_order_no', function(){
        if($(this).is(':checked')) {
            $('.activity-order-no').css('display', 'table-cell');
            var attribute_name = 'activity_order_no';
            showColumn(attribute_name);

        } else {
            $('.activity-order-no').css('display', 'none');
            var attribute_name = 'activity_order_no';
            hideColumn(attribute_name);
        }
    });

    $('body').on('click', '#activity_organization', function(){
        if($(this).is(':checked')) {
            $('.activity-organization').css('display', 'table-cell');
            var attribute_name = 'activity_organization';
            showColumn(attribute_name);

        } else {
            $('.activity-organization').css('display', 'none');
            var attribute_name = 'activity_organization';
            hideColumn(attribute_name);
        }
    });

    $('body').on('click', '#activity_contact_person', function(){
        if($(this).is(':checked')) {
            $('.activity-contact-person').css('display', 'table-cell');
            var attribute_name = 'activity_contact_person';
            showColumn(attribute_name);

        } else {
            $('.activity-contact-person').css('display', 'none');
            var attribute_name = 'activity_contact_person';
            hideColumn(attribute_name);
        }
    });

    $('body').on('click', '#activity_created_by', function(){
        if($(this).is(':checked')) {
            $('.activity-created-by').css('display', 'table-cell');
            var attribute_name = 'activity_created_by';
            showColumn(attribute_name);

        } else {
            $('.activity-created-by').css('display', 'none');
            var attribute_name = 'activity_created_by';
            hideColumn(attribute_name);
        }
    });


    function showColumn(attribute_name) {
        $.ajax({
            url: "{{ url('activities/show_column') }}",
            type: "POST",
            data: {
                'attribute_name':attribute_name, '_token':'{{csrf_token()}}'
            },
            beforeSend: function() {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (data) {
                console.log(data);
            },
            complete: function() {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    }

    function hideColumn(attribute_name) {
        $.ajax({
            url: "{{ url('activities/hide_column') }}",
            type: "POST",
            data: {
                'attribute_name':attribute_name, '_token':'{{csrf_token()}}'
            },
            beforeSend: function() {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (data) {
                console.log(data);
            },
            complete: function() {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    }
    $(document).ready(function() {
        $(document).on('click', 'a.page-link', function() {
            textStyle();
        });
        $('.activity-start-time').hide();
    });
    function textStyle(){
        $('.for_tr_styles').each(function() {
            var isChecked = $(this).prop('checked');
            var row = $(this).closest('tr');

            if (isChecked) {
                row.find('td').css({
                'color': '#b3b3b3',
                'text-decoration': 'line-through'
                });
            }
        });
        $('a.overdue_tr_class').closest('tr').each(function() {
            $(this).css('color', 'red');
        });
        $('a.today_tr_class').closest('tr').each(function() {
            $(this).css('color', '#2dce89');
        });
    }
    function exportTasks() {
        var user_id = $('#loggedin_user_id').val();
        var filter = $('.active .activity-filter').val();

        if(filter == 3){
            var from_date = $('#from_date').val().replace(/\//g, '-');
            var to_date = $('#to_date').val().replace(/\//g, '-');
        }else{
            var from_date = '01-01-2000';
            var to_date = '01-01-2050';
        }


        console.log(user_id, filter, from_date, to_date);

        $.ajax({
            url: '{{ url("activities/get_activities") }}/'+user_id+'/'+filter+'/'+from_date+'/'+to_date,
            type: "GET",
            dataType: 'json',
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (data) {
                console.log(data);
                $.ajax({
                    url: '{{ route("activities.export_csv") }}',
                    type: "POST",
                    data: {
                        activities: JSON.stringify(data),
                        _token: '{{ csrf_token() }}'
                    },
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function (blob, status, xhr) {
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = 'activities.csv';
                        link.click();
                    },
                    complete: function () {
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            }
        });
    }


    // $(document).mouseup(function(e){
    //     if(!$('#activity_popup').is(e.target) && $('#activity_popup').has(e.target).length === 0){
    //         if((!$('.dcalendarpicker').is(e.target) && $('.dcalendarpicker').has(e.target).length === 0) && (!$('.mdtimepicker').is(e.target) && $('.mdtimepicker').has(e.target).length === 0) && (!$('.select2-results__options').is(e.target) && $('.select2-results__options').has(e.target).length === 0)) {
    //             $("#activity_popup").hide(700);
    //         }
    //     }
    // });
</script>

@endsection
