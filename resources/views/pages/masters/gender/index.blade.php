@extends('layouts.app', ['activePage' => 'gender', 'titlePage' => __('Gender')])

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
</style>


<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span class="headder_size2">GENDER</span>
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
                            </td>
                            <td>
                                <button class="btn-green-filled" style="outline: unset;" href="#" data-toggle="modal" data-target="#gender_create_modal" title="Add New Catalog Category">
                                    <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD GENDER
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-12 new-style-table">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="emblishment_table">
                            <thead>
                                <th class="tagline-name" scope="col">Gender</th>
                                <th class="created-at" scope="col">Created At</th>
                            </thead>

                            <tbody class="list">
                                @foreach ($genders as $genders)
                                <tr>
                                    <td class="tagline-name"><a href="#" class="edit" data-value="{{$genders->id}}">{{$genders->gender_name}}</a></td>
                                    <td class="created-at">{{$genders->created_at->format('m-d-Y')}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>

</div>


@include('pages.masters.gender.create')
@include('pages.masters.gender.edit')

<script>

    $(document).ready(function() {
        // Attach the click event for edit buttons
        setupEditButtonClick();
    });

    function setupEditButtonClick() {
        $("body").on("click", ".edit", handleEditClick);
    }

    function handleEditClick() {
        var genderId = $(this).data('value');
        console.log(genderId);

        // Set the value in the hidden input field and show the modal
        $('#gender_id').val(genderId);
        $('#gender_edit_modal').modal('show');
    }

</script>

@endsection
