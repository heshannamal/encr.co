{{-- {{ dd($projectType) }} --}}
@extends('layouts.app', ['activePage' => 'project_types', 'titlePage' => __('Project Types')])

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
    @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {
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

   .pagina001{
        flex-wrap: wrap;
     }
     .flex_set{
        flex-direction: column;
     }
     .max_width01{
        max-width: none;
     }
  }
  @media only screen and (min-device-width: 1024px) and (max-device-height: 1366px) and (-webkit-min-device-pixel-ratio: 2)  and (orientation: portrait) {
        .header1{
            display: inline !important;
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
    @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) and (orientation : landscape) {

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
    body {
        font-family: 'Open Sans', 'sans-serif' !important;
    }
</style>

<div class="container-fluid content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span class="headder_size">PROJECT TYPE</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="row col-md-12 mb-3" style="padding: 0rem;">
        <div class="col-md-4 ml-auto text-right mt-3">
            @if (Gate::check('add project type'))
                <button class="btn-green-filled" style="outline: unset;" href="#"  data-toggle="modal" data-target="#type_create_modal" title="Add New Project Type">
                    <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD PROJECT TYPE
                </button>
            @endif
        </div>
    </div>

    {{-- <div class="col-md-12 btn-top">
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3 btns-right-position">
                <div class="row div_align">
                    <div class="col-md-6 btns-padding"></div>
                    <div class="col-md-6 btns-padding btn_set btn_set1">
                        @if (Gate::check('add project type'))
                            <button class="btns-text btns-style btns-card" style="outline: unset;" href="#"  data-toggle="modal" data-target="#type_create_modal" title="Add New Project Type">
                                Add Project Type
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div> --}}


    {{-- <div class="col-md-12 mt-2">
        <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                <div class="row ">
                    <div class="col-md-8 add-project-btn">
                        <div class="card ">
                            @if (Gate::check('add project type'))
                                <span>
                                    <a class="btn-text" href="#" title="Add New Project Type" class="btn-txt"  data-toggle="modal" data-target="#type_create_modal">
                                        <i class="fas fa-solid fa-plus fa-fade btn-font" style="color: #787878;">   Project Type</i>
                                    </a>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="col-md-12 mt-4">
        <div class="card">
            {{-- <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="float-left header-title">Project Types</h1>
                        </div>
                        <div class="col-md-6 header-icons justify-content-end">
                            <div style="width: 100%;justify-content: flex-end;display: flex">
                                @can('create project type')
                                    <div class="text-center" style="width: 70px; justify-content: flex-end;">
                                        @if (Gate::check('add project type'))
                                        <span>
                                            <a class="btn btn-round" href="#" data-toggle="modal" data-target="#type_create_modal">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                            <p>Add project Type</p>
                                        </span>
                                        @endif
                                    </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
                <div class="col-md-12 new-style-table">
                    <div class="table-responsive mt-3 mb-3">
                        <table class="table align-items-center" id="user_groups_table">
                            <thead>
                                <tr>
                                    {{-- <th class="user-group-name" scope="col">Project Type Id</th> --}}
                                    <th class="narration" scope="col">Project Type Name</th>
                                    <th class="created-at" scope="col">Created At</th>
                                </tr>
                            </thead>

                            <tbody class="list" id="tableBody">
                                @foreach ($projectType as $projectTypes)
                                    <tr class="edit-row">
                                        {{-- <td class="type"><a href="#" class="edit" data-value="{{ $projectTypes->id}}">{{ $projectTypes->id }}</a></td> --}}
                                        <td class="used-model"><a href="#" class="edit" data-value="{{ $projectTypes->id}}">{{ $projectTypes->type_name }}</a></td>
                                        <td class="created-at">{{$projectTypes->created_at->format('m-d-Y')}}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>

                </div>

        </div>
    </div>

</div>
@include('pages.masters.project_type.create')
@include('pages.masters.project_type.edit')

<script>

$(document).ready(function() {
    // Click event handler for table rows
    $('.edit-row').click(function() {
        // Get the data values from the clicked row
        var typeId = $(this).find('.edit').data('value');
        var typeName = $(this).find('.used-model').text();

        // Set the values in the edit modal
        $('#type_id').val(typeId);
        $('#edit_type_name').val(typeName);

        // Show the edit modal
        $('#type_edit_modal').modal('show');
    });
});

</script>

@endsection
