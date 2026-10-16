@extends('layouts.app', ['activePage' => 'projects', 'titlePage' => __('Projects')])

@section('content')
<style>
    .dataTables_filter {
        display: none;
    }
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
         .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
        }

    #searchbox:-ms-input-placeholder { /* Internet Explorer 10-11 */
        color: #aaaaaa;
    }
    #searchbox::-ms-input-placeholder { /* Microsoft Edge */
        color: #aaaaaa;
    }

    .alphabet1 button{
        width: 3.7%;
        margin-bottom: 1em;
        background-color: #fff;
    }
    .button-styling{
        display: table-cell;
        color: #b3b3b3;
        cursor: pointer;
        text-align: center;
        width: 3.5%;
        border: 1px solid #e8e8e8;
    }
    .alphabet1 {
        padding: 16px
    }
    button.active {
    background-color: #ffffff;
    color: #787878;
    }
    .select2.select2-container {
        width: 100% !important;
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
        white-space: break-spaces;
    }
    .select2-container .select2-selection--single {
        overflow: hidden;
    }
    .filter-inputs {
        align-items: center;
    }
    .radio {
        width: 16%;
        height: calc(1rem + 5px);
    }
    .ts-form-field {
        align-items: center;
    }
    .ts-form-field .form-lable {
        width: 30%;
    }
    .btn-team-store-download {
        border-radius: 1rem;
        padding: 0.1rem 0.5rem;
        font-size: 10px;
    }
    .filter-inputs {
        align-items: center;
    }
    .dropbox-position {
        position: relative;
        top: 9px;
        left: 15px;
    }
    .btn-position {
        position: relative;
        top: 12px;
        left: 15px;
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
    .add-btn-text {
        position: relative;
        font-size: 15px;
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
    .table-btn-text {
        font-size: 15px;
        position: relative;
        right: -17px;
    }
    .btn-div {
        position: relative;
        right: 55px;
    }
    .content-position {
        position: relative;
        top: -25px;
    }
    .table-font-size {
        font-size: 13px;
    }
    .table-border {
        border: unset !important;
    }
    .card-margin {
        margin: -0.5rem;
    }
    .save-btn {
        width: 90px !important;
        position: relative;
        right: -9px;
    }
    .btns-padding {
        padding-right: 5px;
        padding-left: 5px;
    }
    .second-top-position {
        position: relative;
        top: -7px;
    }
    .second-top-height {
        height: 73px;
    }
    .second-top-row {
        position: relative;
        top: 9px;
        width: 100%;
        left: 16px;
    }
    .btn-div-position {
        position: relative;
        top: 2px;
    }
    .select2.select2-container.select2-container--default {
        border: 1px #e5e5e5 solid !important;
        border-radius: 5px !important;
    }
    .checkbox-style {
        z-index: 1;
        position: relative;
        left: -7px;
        top: 3px;
        cursor: pointer;
    }
    .alphabet {
    display: flex;
    justify-content: center;
    margin-bottom: 10px;
    border-radius: 3px;
    padding: 5px;
  }
  .alphabet .filter-item {
    cursor: pointer;
    padding: 0px;
    margin: 0 5px;
    color: #b3b3b3;
  }
  .alphabet .filter-item.active {
    color: #000000;
  }
  @media screen and (min-width: 600px) and (max-width: 800px) {
        .div_flexdir{
            flex-wrap: wrap;
            flex-direction: column;
        }
        .div_none{
            max-width: none;
        }
        .btn_set{
            max-width: none;
            flex:none;
            right:0px;

        }
        .div_display{
            display:none;
        }
        .div_align{
            justify-content: center;
        }
        .div_btn_size{
            width:200%;
        }
        .div_nav_top{
            top:-13%;
        }
        .th_width1{
            width:155px !important;
        }
        .th_width2{
            width:212px !important;
        }
    }
    @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {
        .header1{
            display: inline !important;
        }
        .headder_size{
            font-size:15px;
        }
    }
    @media only screen and (min-device-width : 834px) and (max-device-width : 1024px) and (orientation : portrait) {
        .div_flexdir{
            flex-wrap: wrap;
            flex-direction: column;
        }
        .div_none{
            max-width: none;
        }
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
    .btn-grey-filled{
        outline: unset !important;
        width: 100%;
        padding: 4%;
        color: white;
        background-color: #B3B3B3;
        border: 2px solid #B3B3B3;
        font-weight: 700;
        font-size: .7rem;
        cursor: pointer;
    }
    .dropdown-style-grey{
        border: none;
        color: #b3b3b3;
        outline: unset;
        align-content: center;
    }
    .selectbox-div{
        border: 1px solid #B3B3B3;
        border-radius: 1rem;
        padding: 1%;
        padding-left: 6%;
    }
    .searchbox-layout{
        margin-top: 0 !important;
        width: 100% !important;
        height: 29px;
        font-size: .7rem;
        color: #B3B3B3;
        border: unset;
    }
    .header-style{
        background-color: #717070;
        color: white;
        font-size: 0.7rem;
        /* height: 50px; */
    }
    table.dataTable thead .sorting:before, table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:before, table.dataTable thead .sorting_desc_disabled:after {
    bottom: .65em;
    }
    table.dataTable thead .sorting:before,table.dataTable thead .sorting_asc:before,table.dataTable thead .sorting_desc:before,table.dataTable thead .sorting_asc_disabled:before,table.dataTable thead .sorting_desc_disabled:before {
        content: "\f0de";
        font-family: FontAwesome;
    }
    table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:after,table.dataTable thead .sorting_asc_disabled:after,table.dataTable thead .sorting_desc_disabled:after {
        content: "\f0dd";
        font-family: FontAwesome;
        right: .65rem !important;
    }
    .edit-order{
        color:#717070 !important;
        font-size: 0.7rem !important;
    }
    .order-no{
        font-size: 0.7rem !important;
    }
    .organization-id{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .sorting_1{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .factory-id{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .due-date{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .open-date{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .est-ship-date{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .user-id{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .order-total{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .order-status-id{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .contact-person{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .order-description{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .sub-total{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .sales-tax{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .shipping{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .artwork{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .processing-fee{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .team-store-file{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .created-at{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .updated-at{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .color-star{
        font-size: 16px;
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
    .filtering-div{
        border: 1px solid #B3B3B3;
        border-radius: 1rem;
        padding-top: .2rem;
        padding-bottom: .2rem;
        color: #B3B3B3;
        margin: 1%;
    }
    .filter-elements{
        background-color: transparent;
        border: none;
        cursor: pointer;
        color: #B3B3B3;
        outline: unset;
        border-radius: .5rem;
    }
    .filter-field{
        align-items: center;
        border: 1px solid #B3B3B3;
        border-radius: 1rem;
    }
    .left-border{
        border-left: 1px solid #B3B3B3;
        border-radius: 0;
    }
    .form-field{
        margin-bottom: 0%;
    }
    .custom-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-color: white;
        border: 1px solid #ccc;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
    }
    .custom-select:focus {
        outline: none;
        border-color: #ccc;
    }
    .header-layout{
        margin-bottom: 1rem !important;
    }

</style>

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color">BACK TO HOME</a>
    @endsection

    <div class="mb-5">
        <div class="row">
            <div class="col-lg-4 row ml-auto" style="margin-right: 3.75%; justify-content: end;">
                <div class="col-lg-5" style="position: relative;left: 6%;">
                    @can('create project')
                        <button class="btn-green-filled" style="width: 120%;" onclick="addNewOrder()" title="Add New Project" data-toggle="modal" data-target="#adding_project_step_modal">
                            <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD Project
                        </button>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="col-md-12 mt-2 second-top-position">
        <div class="card second-top-height">
            <div class="row second-top-row ">
                <div class="col-md-3 form-field filter-inputs dropbox-position flex_set flex_set2 t-unset">
                    <label class="form-lable w-95">Project Type</label>
                    <select class="form-control" id="type_id">
                        <option value="0">View All</option>
                        @foreach($type as $projecttype)
                            <option value="{{$projecttype->id}}">{{$projecttype->type_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 form-field filter-inputs dropbox-position flex_set flex_set2 t-unset">
                    <label class="form-lable w-95">Project Status</label>
                    <select class="form-control" id="status_id">
                        <option value="0">View All</option>
                        @foreach($projectStatus as $projectState)
                            <option value="{{$projectState->id}}">{{$projectState->status_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 text-center btn-position t-unset t-set-10">
                    <button type="button" class="btn btn-sm btn-secondary btn-un" id="filter"  title="Filter "><i class="fas fa-solid fa-filter fa-2xs"></i></button>
                    <button type="button" class="btn btn-sm btn-secondary" id="filter_save_option" title="Filter & Save"><i class="fas fa-solid fa-thumbtack"></i></button>
                </div>
                <div class="col-md-4 text-center">
                    <input type="text" id="searchbox" placeholder="Project #/ Project Name Search" style="width: 90%; margin-right: 20px; color: #787878; border-radius: 7px; border: 0.125rem solid #787878;">
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div class="col-md-12 mt-1 mb-2 btn-div-position r-52">
        <div class="row div_align">
            <div class="col-md-9 "></div>
            <div class="col-md-3 btn-div btn_set">
                <div class="row">
                    <div class="col-md-6 btns-padding">
                        <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" title="Add New Project" data-toggle="modal" data-target="#add_project">
                            Add Project
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

    <div class="col-md-12 mt-3">
        <div class="card mb-3">
            <div class="row ml-4 mt-2 mb-2 align-items-center">
                <div class="col-md-3 mr-1 form-field filter-inputs filter-field">
                    <label class="form-lable width-50" style="margin-right: 4%;color:#B3B3B3;font-weight: 700;">Project Type  </label>
                    <select class="form-control dropdown-style-grey left-border" id="type_id" style="height: calc(1.5rem + 1px) !important;">
                        <option value="0">View All</option>
                        @foreach($type as $projecttype)
                            <option value="{{$projecttype->id}}">{{$projecttype->type_name}}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-3 ml-1 form-field filter-inputs filter-field">
                    <label class="form-lable width-50" style="margin-right: 4%;color:#B3B3B3;font-weight: 700;">Project Status</label>
                    <select class="form-control dropdown-style-grey left-border" id="status_id" style="height: calc(1.5rem + 1px) !important;">
                        <option value="0">View All</option>
                        @foreach($projectStatus as $projectState)
                            <option value="{{$projectState->id}}">{{$projectState->status_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 row">
                    <div class="col-lg-1">
                        <button type="button" class="filter-elements" id="filter" title="Filter"><i class="fas fa-solid fa-filter fa-2xs" style="color: #787878;"></i></button>
                    </div>
                    <div class="col-lg-8">
                        <button type="button" class="filter-elements" id="filter_save_option" title="Filter & Save"><i class="fas fa-solid fa-thumbtack fa-2xs" style="color: #787878;"></i></button>
                    </div>
                </div>
                {{-- <div class="col-lg-3 ml-auto">
                    <div class="row" style="width: 101%;">
                        <div class="col-lg-1" style="border-bottom: 1px solid #B3B3B3 !important;">
                            <i class="fa fa-search" aria-hidden="true" style="font-size: 19px;color: #B3B3B3;top: 23%;position: relative;"></i>
                        </div>
                        <div class="col-lg-10 text-center" style="border-bottom: 1px solid #B3B3B3 !important;">
                            <input class="searchbox-layout"  type="text" id="searchbox" placeholder="Project #/ Project Name Search">
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="card">
            <div class="row mt-3">
                <div class="col-lg-6 d-flex align-items-center">
                    <div class="col-md-6 d-flex">
                        <div class="col-lg-9" style="font-size: .8rem;color:#B3B3B3;font-weight: 500;">
                            Show rows per page
                        </div>
                        <div class="col-lg-3 selectbox-div">
                            <select class="dropdown-style-grey" name="row_per_page" id="row_per_page">
                                <option value="50">50</option>
                                <option value="75">75</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex">
                        <div class="col-lg-1" style="border-bottom: 1px solid #B3B3B3 !important;">
                            <i class="fa fa-search" aria-hidden="true" style="font-size: 19px;color: #B3B3B3;top: 23%;position: relative;"></i>
                        </div>
                        <div class="col-lg-10 text-center" style="border-bottom: 1px solid #B3B3B3 !important;">
                            <input class="searchbox-layout"  type="text" id="searchbox" placeholder="Project #/ Project Name Search">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-1 ml-1 row align-items-center">

                </div>
                <div class="col-lg-2 ml-auto row mr-1 align-items-center">
                    {{-- <div class="col-lg-6">
                        @can('add orders')
                            <button class="btn-grey-text"  style="width: 100%;" href="#" id="export_csv" data-href="{{ route('orders.export_csv') }}" onclick="exportTasks(event.target);"  title="Export CSV">
                                CSV Export
                            </button>
                        @endcan
                    </div> --}}
                    <div class="col-lg-12">
                        @can('view team store orders')
                            <button class="btn-grey-text" style="width: 100%;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                                Table Layout
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
            {{-- <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <h1 class="float-left header-title">Project Management</h1>
                        </div>
                        <div class="col-md-8 text-center">
                            <div class="row align-items-center">

                                <div class="col-md-12 header-icons justify-content-center">
                                    <div style="width: 100%;justify-content: flex-end;display: flex">
                                        <input type="text" id="searchbox" placeholder="Project Search" style="width: 50%;margin-right: 20px">

                                            <div class="text-center" style="width: 70px; justify-content: flex-end;">
                                                <span>
                                                    <a class="btn btn-round" href="{{ route('new_projects') }}" title="Add New Project">
                                                        <i class="fas fa-file-invoice"></i>
                                                    </a>
                                                    <p>Add Projects</p>
                                                </span>
                                            </div>
                                        <div class="text-center" style="width: 70px; justify-content: flex-end;">
                                            <span>
                                                <a class="btn btn-round" href="#" data-toggle="modal" data-target="#layout_modal">
                                                    <i class="fas fa-wrench"></i>
                                                </a>
                                                <p>Table Layout</p>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div> --}}

            {{-- <div class="card-body"> --}}
                {{-- <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4 form-field filter-inputs">
                            <label class="form-lable">Project Type</label>
                            <select class="form-control" id="type_id">
                                <option value="0">View All</option>
                                @foreach($type as $projecttype)
                                    <option value="{{$projecttype->id}}">{{$projecttype->type_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 form-field filter-inputs">
                            <label class="form-lable">Project Status</label>
                            <select class="form-control" id="status_id">
                                <option value="0">View All</option>
                                @foreach($projectStatus as $projectState)
                                    <option value="{{$projectState->id}}">{{$projectState->status_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 text-center">
                            <button type="button" class="btn btn-sm btn-secondary" id="filter"><i class="fas fa-sliders-h"></i> Filter</button>
                            <button type="button" class="btn btn-sm btn-secondary" id="filter_save_option"><i class="fas fa-sliders-h"></i> Filter & Save</button>
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="card-body alphabet1" id="alphabet"></div> --}}

                <div class="col-md-12 mt-2" style="padding-right: 19px;">
                    <div class="table-responsive">
                        {{-- <div id="alphabet-filter"></div> --}}
                        <table class="table align-items-center cell-border table-responsive" id="table" >
                            <thead class="bg-theme">
                                <th class="project-color toggleable" data-col="project_color">Color #</th>
                                <th class="project-no toggleable" data-col="project_no">Project #</th>
                                <th class="project-name toggleable" data-col="project_name">Project Name</th>
                                <th class="no-sort toggleable" data-col="type_name">Project Type</th>
                                <th class="no-sort toggleable" data-col="status_name">Status</th>
                                <th class="project-description toggleable" data-col="project_description">Description</th>
                                <th class="project-assignee toggleable" data-col="assignee">Assignees</th>
                                <th class="created-by toggleable" data-col="created_by">Created By</th>
                                <th class="created-at toggleable" data-col="created_at">Created At</th>
                                <th class="updated-at toggleable" data-col="updated_at">Updated At</th>
                            </thead>
                            <tbody id="tableBody">
                            @foreach ($project as $projects)
                            <tr>
                                <td>
                                    {{-- <div class="color-picker-wrapper" style="background-color: {{ $projects->project_color }};  position: relative; right: -21px;">
                                        <input type="color" value="{{ $projects->project_color }}" class="color-picker" style="width:16px;" disabled>
                                    </div> --}}
                                    <div class="color-picker-wrapper {{ $projects->id }}" style="background-color: transparent;border: none;">
                                        <input type="color" value="{{ $projects->project_color }}" class="color-picker {{ $projects->id }}" list="presetColors" data-value="{{ $projects->id }}" style="position: relative;right: -10px;top: 2px;z-index: 1;">
                                        <datalist id="presetColors">
                                            <option>#d7dadb</option>
                                            <option>#fb5779</option>
                                            <option>#ff7510</option>
                                            <option>#ffa800</option>
                                            <option>#ffd101</option>
                                            <option>#ace610</option>
                                            <option>#19db7d</option>
                                            <option>#00D4CB</option>
                                            <option>#48dafd</option>
                                            <option>#0064fb</option>
                                            <option>#6458f9</option>
                                            <option>#A147E4</option>
                                            <option>#ff78ff</option>
                                            <option>#ff4ba6</option>
                                            <option>#ff93af</option>
                                            <option>#5a7896</option>
                                        </datalist>
                                    </div>
                                    <i class="fa fa-star" style="color:{{ $projects->project_color }};font-size:16px;position: relative;right: 7px;" id="picker-star{{ $projects->id }}" aria-hidden="true"></i>
                                </td>
                                <td class="toggleable" data-col="project_no"><a href="{{ route('project_details', [$projects->id]) }}">{{ $projects->project_no }}</a></td>
                                <td class="projectName toggleable project_name" data-col="project_name">{{ $projects->project_name }}</td>

                                <td class="no-sort toggleable" data-col="type_name">
                                    @foreach ($type as $projectType)
                                        @if(isset($projectType) && !empty($projectType) && $projectType->id == $projects->project_type_id)
                                            {{ $projectType->type_name }}
                                        @endif
                                    @endforeach
                                </td>

                                <td class="no-sort toggleable" data-col="status_name">
                                    @foreach ($projectStatus as $projectStat)
                                        @if(isset($projectStat) && !empty($projectStat) && $projectStat->id == $projects->project_status_id)
                                            {{ $projectStat->status_name }}
                                        @endif
                                    @endforeach
                                </td>

                                <td class="project-description toggleable" data-col="project_description">{{ $projects->project_description }}</td>

                                <td  class="project-assignee toggleable" data-col="assignee">
                                    @foreach($users as $user)
                                        @foreach (explode(',', $projects->project_assignee) as $assignee)
                                                @if(isset($user) && !empty($user) && $user->id ==  $assignee )
                                                    {{ $user->name }} <br>
                                                @endif
                                        @endforeach
                                    @endforeach
                                </td>

                                <td  class="created-by toggleable" data-col="created_by">
                                    @foreach ($users as $user)
                                        @if(isset($user) && !empty($user) && $user->id ==  $projects->created_by )
                                            {{ $user->name }}
                                        @endif
                                    @endforeach
                                </td>

                                <td  class="created-at toggleable" data-col="created_at">{{ $projects->created_at->format('Y-m-d') }}</td>

                                @if(!empty($projects->updated_at))
                                    <td  class="updated-at toggleable" data-col="updated_at">{{ $projects->updated_at->format('Y-m-d') }}</td>
                                @else
                                    <td  class="updated-at toggleable" data-col="updated_at"></td>
                                @endif
                            </tr>
                            @endforeach
                            {{-- <tbody id="order_table_body"></tbody>--}}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 mt-2 ">
                    <div style="float: right " >
                        {{ $project->onEachSide(5)->withQueryString()->links('layouts.paginationlinks') }}
                    </div>
                </div>
            {{-- </div> --}}
        </div>
    </div>
</div>

@include('pages.project.partials.add_new_project_old')
@include('pages.project.partials.add_project_step')

<input type="hidden" id="from_project_create_page" value="1"/>
<input type="hidden" id="organization_id_from_contact" value="{{app('request')->input('organization_id')}}"/>

@include('pages.project.partials.labels')

<script>
    //Alphabet filter
    document.addEventListener('DOMContentLoaded', function() {
      var alphabetLetters = Array.from(Array(26)).map((_, i) => String.fromCharCode(65 + i));

      var alphabetFilter = document.getElementById('alphabet-filter');
      alphabetFilter.innerHTML = '';
      var alphabetBox = document.createElement('div');
      alphabetBox.classList.add('alphabet');

      var allFilterItem = document.createElement('span');
      allFilterItem.textContent = 'All';
      allFilterItem.classList.add('filter-item');
      alphabetBox.appendChild(allFilterItem);

      alphabetLetters.forEach(function(letter) {
        var filterItem = document.createElement('span');
        filterItem.textContent = letter;
        filterItem.classList.add('filter-item');
        alphabetBox.appendChild(filterItem);
      });

      alphabetFilter.appendChild(alphabetBox);

      var filterItems = document.querySelectorAll('.filter-item');
      filterItems.forEach(function(item) {
        item.addEventListener('click', function() {
          filterItems.forEach(function(filterItem) {
            filterItem.classList.remove('active');
          });

          item.classList.add('active');

          var filterText = item.textContent;

          var rows = document.querySelectorAll('#table tbody tr');

          rows.forEach(function(row) {
            var organizationNameCell = row.querySelector('.project_name');
            var organizationName = organizationNameCell.textContent.trim();

            if (filterText === 'All' || organizationName.charAt(0).toUpperCase() === filterText) {
              row.style.display = '';
            } else {
              row.style.display = 'none';
            }
          });
        });
      });
    });
</script>

<script>

    let header = "PROJECT MANAGEMENTS";
        document.getElementById("header").innerHTML = header;

    var previousTextareaValue = "";

    function handleRemovedText() {
        var currentText = document.getElementById("project_assignee").value;
        var removedText = findRemovedText(previousTextareaValue, currentText);

        removedText = removedText.replace(/\n/g, '');

        console.log("Removed Text:", removedText);

        if (removedText.trim() !== "") {
            removeFromSelectedOptions(removedText);
        }


        previousTextareaValue = currentText;
    }

    function findRemovedText(previousValue, currentValue) {
        if (previousValue.length > currentValue.length) {
            return previousValue.substring(currentValue.length);
        }
        return "";
    }
    function removeFromSelectedOptions(text) {
        var index = selectedOptions.indexOf(text);
        if (index !== -1) {
            selectedOptions.splice(index, 1);
            console.log('deleted');
        }
    }




    var selectedOptions = [];
    var selectedOptions1 = [];

    function selectAssignee(type) {
        var dropdown = document.getElementById("assignee");
        var textArea = document.getElementById("project_assignee");
        var textArea1 = document.getElementById("project_assignee_id");
        var selectedOption = dropdown.options[dropdown.selectedIndex].text;
        var selectedOption1 = dropdown.options[dropdown.selectedIndex].value;
        selectedOptions.push(selectedOption);
        selectedOptions1.push(selectedOption1);
        console.log(selectedOptions);
        textArea.value = selectedOptions.join("\n");
        textArea1.value = selectedOptions1.join("\n");
        previousTextareaValue = textArea.value;



        if (type == 'group') {
            var groups = $('#project_assignee_groups').val();
            if(groups != ''){
                groups = JSON.parse(groups);
                groups.push(selectedOption1);
                $('#project_assignee_groups').val(JSON.stringify(groups));
            } else {
                var newArr = [];
                newArr.push(selectedOption1);
                $('#project_assignee_groups').val(JSON.stringify(newArr));
            }
        } else if(type == 'user') {
            var users = $('#project_assignee_users').val();
            if(users != ''){
                users = JSON.parse(users);
                users.push(selectedOption1);
                $('#project_assignee_users').val(JSON.stringify(users));
            } else {
                var newArr2 = [];
                newArr2.push(selectedOption1);
                $('#project_assignee_users').val(JSON.stringify(newArr2));
            }
        }
        // var array3 = array1.concat(array2).unique();
    }

    // document.addEventListener('DOMContentLoaded', function() {
    //     var colorPickers = document.querySelectorAll('.color-picker');

    //     colorPickers.forEach(function(picker) {
    //         picker.addEventListener('change', function() {
    //             var selectedColor = this.value;
    //             var colorPickerWrapper = this.closest('.color-picker-wrapper');
    //             colorPickerWrapper.style.backgroundColor = selectedColor;
    //         });
    //     });
    // });




    $.ajax({
        url: "projects/get_projects",
        type: "GET",
        success: function(data) {
            localStorage.setItem("projects_data", JSON.stringify(data));
        }
    });

    // search project name
    const searchInput = document.getElementById('searchbox');
    const tableBody = document.getElementById('tableBody');

    searchInput.addEventListener('input', () => {

        const searchQuery = searchInput.value.toLowerCase();

        for (let i = 0; i < tableBody.rows.length; i++) {

            const projectNo = tableBody.rows[i].cells[1];
            const projectName = tableBody.rows[i].cells[2];

            if ((projectNo.textContent.toLowerCase().includes(searchQuery)) || (projectName.textContent.toLowerCase().includes(searchQuery))) {
                tableBody.rows[i].style.display = '';
            } else {
                tableBody.rows[i].style.display = 'none';
            }
        }
    });


   // Filter using type and status
    const filterDropdown = document.getElementById('type_id');
    const filterDropdown2 = document.getElementById('status_id');
    const filterButton = document.getElementById('filter');

    let filterValue = '';
    let filterStatus = '';

    filterDropdown.addEventListener('change', handleFilterChange);
    filterDropdown2.addEventListener('change', handleFilterChange);
    filterButton.addEventListener('click', handleFilterClick);

    function handleFilterChange() {
        filterValue = filterDropdown.options[filterDropdown.selectedIndex].text;
        filterStatus = filterDropdown2.options[filterDropdown2.selectedIndex].text;
    }

    function handleFilterClick() {
        const tableBody = document.getElementById('tableBody');
        const rows = tableBody.rows;

        for (let i = 0; i < rows.length; i++) {
            const projectType = rows[i].cells[3].textContent.trim();
            const projectStatus = rows[i].cells[4].textContent.trim();

            const isTypeMatch = filterValue === 'View All' || filterValue === projectType;
            const isStatusMatch = filterStatus === 'View All' || filterStatus === projectStatus;

            if (isTypeMatch && isStatusMatch) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }



    //Alphabet filtter
    // const alphabetDiv = document.getElementById('alphabet');
    // const tableRows = document.querySelectorAll('#tableBody');

    // const alphabet = 'abcdefghijklmnopqrstuvwxyz'.split('');

    // let selectedButton = null;

    // const allButton = document.createElement('button');
    // allButton.textContent = 'All';
    // allButton.classList.add('button-styling');
    // alphabetDiv.appendChild(allButton);

    // allButton.addEventListener('click', () => {
    // tableRows.forEach(row => {
    //     row.style.display = '';
    // });
    // alphabetDiv.querySelectorAll('button').forEach(button => {
    //     button.classList.remove('active');
    // });
    // });

    // alphabet.forEach(letter => {
    // const button = document.createElement('button');
    // button.textContent = letter.toUpperCase();
    // button.classList.add('button-styling');
    // alphabetDiv.appendChild(button);

    // button.addEventListener('click', () => {
    //     tableRows.forEach(row => {
    //     const projectName = row.querySelector('.projectName').textContent.trim();
    //     if (projectName.toLowerCase().startsWith(letter)) {
    //         row.style.display = '';
    //     } else {
    //         row.style.display = 'none';
    //     }
    //     });
    // alphabetDiv.querySelectorAll('button').forEach(button => {
    //   button.classList.remove('active');
    // });
    // button.classList.add('active');
    // });
    // });



    //Table Layout
    $(document).ready(function() {
        $(".se-pre-con").fadeOut('slow');

        var checkboxes = $('input[type=checkbox]');

        checkboxes.each(function() {
            var checkbox = $(this);
            var colId = checkbox.attr('id');

            checkbox.change(function() {
                var column = $('th[data-col=' + colId + '], td[data-col=' + colId + ']');

                if (checkbox.prop('checked')) {
                    column.show();
                } else {
                    column.hide();
                }
            });
        });

        $('.color-picker').on('change', function(){
            var projectId = $(this).data('value');
            var flagColor = $('.color-picker.'+projectId).val();
            var flagStar = $('#picker-star'+projectId);
            flagStar.css("color", flagColor);
            //$('.color-picker-wrapper.'+projectId).css('background-color', flagColor);
            var colorValue = flagColor.replace('#', '')
            changeOrderFlag(projectId, colorValue);
        });

        // $('.color-picker').on('change', function(){
        //     var orderId = $(this).data('value');
        //     var flagColor = $('.color-picker.'+orderId).val();

        //     //$('.color-picker-wrapper.'+orderId).css('background-color', flagColor);
        //     var colorValue = flagColor.replace('#', '')

        //     changeOrderFlag(orderId, colorValue);
        // });

        function changeOrderFlag(projectId, colorValue){
            $.ajax({
                url:"{{ url('projects/change_flag') }}/"+projectId+"/"+colorValue,
                method:"GET",
                dataType:"json",
                beforeSend:function(){
                    $(".se-pre-con").fadeIn();
                },
                success:function(data){
                    $(".se-pre-con").fadeOut();
                    if(data == 'success'){
                        Swal.fire({
                            title: "Done!",
                            text: "Order Flag Changed  Successfully!",
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: data.errorInfo[2],
                            type: "error",
                        });
                    }
                }
            });
        }
    });



</script>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // $('.select2-new-project').select2();

        $('.select2-new-project').select2({
            dropdownParent: $('.select-container')
        });
    });
</script>
