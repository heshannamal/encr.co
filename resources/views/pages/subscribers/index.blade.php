@extends('layouts.app', ['activePage' => 'subscribers', 'titlePage' => __('Subscribers')])

@section('content')
<style>
    .form-field {
        display: flex;
        margin-bottom: 1rem;
        flex-direction: row;
        flex-wrap: nowrap;
        align-items: center;
    }
    .form-lable {
        width: 33%;
    }
    .form-input {
        width: 100%;
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
    div.alphabet {
        display: table;
        width: 100%;
        margin-bottom: 1em;
    }
    div.alphabet span {
        display: table-cell;
        color: #b3b3b3;
        cursor: pointer;
        text-align: center;
        width: 3.5%;
        border: 1px solid #e8e8e8;
    }
    div.alphabet span:hover {
        box-shadow: 2px 2px 5px #e8e8e8;
    }
    div.alphabet span.active {
        color: black;
    }
    .add-btn-position {
        width: 84px;
        position: relative;
        right: -29px;
    }
    .btn-text-position {
        position: relative;
        right: -6%;
        font-size: 15px;
    }
    .content-position {
        position: relative;
        top: -25px;
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
   .search_orga{
    width:200% !important;
   }
   .pagina001{
        flex-wrap: wrap;
     }
  }@media only screen and (min-device-width : 834px) and (max-device-width : 1024px) and (orientation : portrait) {

    }
    .card{
        background-color: white;
        border: none;
        border-radius: 0rem;
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
    }
    .new-style-table th, .new-style-table td {
        padding: 10px;
    }
    .new-style-table table tbody tr:hover{
        background-color: #f6f6ff;
    }
    .table-responsive .table tbody td , .table-responsive .table tbody td a {
        padding: 0.4rem 1rem !important;
        font-size: .9rem !important;
        color: rgba(22, 22, 23, 1) !important;
    }
    .new-style-table table thead tr {
        background-color: rgba(50, 50, 50, 1) !important;
        height: 40px;
    }
    .btn-inside-table button{
        width: 100% !important;
        padding: 5% 3% !important;
        font-size: .7rem !important;
        height: 2.1rem;
        font-size: .7rem !important;
    }
    body {
        font-family: 'Open Sans', 'sans-serif' !important;
    }
    .hide {
        display: none;
    }
    .custom-control-label::before{
        position: relative;
        left: 0.25rem;
    }
    #payMultipleModal .table td {
        padding: .2rem 1.5rem;
    }
    .hard-top-border{
        border-top: double #e9ecef !important;
    }
    .no-top-border{
        border-top: none !important;
    }

</style>


<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con" style="display: none;"></div>

    @section('order-header')
        <span>SUBSCRIBERS</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12 btn-top">
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3 btns-right-position btn_set">
                <div class="row div_align">
                    <div class="col-md-6 btns-padding">
                        {{-- @if (Gate::check('add fabrics'))
                            <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" data-toggle="modal" data-target="#fabric_create_modal" title="Add New Fabrics">
                                Add Fabric
                            </button>
                        @endif --}}
                    </div>
                    <div class="col-md-6 btns-padding">
                            {{-- <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                                Table Layout
                            </button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 new-style-table">
        <div class="card">
                <div class="col-md-12 mt-3 mb-3">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="subscribers_table">
                            <thead>
                                <th scope="col" class="sub-id">#Id</th>
                                <th scope="col" class="sub-email">Email</th>
                                <th scope="col" class="sub-platform">Platform</th>
                                <th scope="col" class="sub-note">Note</th>
                                <th scope="col" class="created-at">Created At</th>
                                <th scope="col" class="updated-at">Updated At</th>
                            </thead>
                            <tbody>
                                @foreach ($subscribers as $subscriber)
                                    <tr>
                                        <td class="sub-id">
                                            {{ $subscriber->id }}
                                        </td>
                                        <td class="sub-email">
                                            {{ $subscriber->email }}
                                        </td>
                                        <td class="sub-platform">
                                            {{ $subscriber->platform }}
                                        </td>
                                        <td class="sub-note">
                                            {{ $subscriber->note }}
                                        </td>
                                        <td class="created-at">{{ \Carbon\Carbon::parse($subscriber->created_at)->format('m/d/Y h:iA') }}</td>
                                        <td class="updated-at">{{ \Carbon\Carbon::parse($subscriber->updated_at)->format('m/d/Y h:iA') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        var subscribers_table = $('#subscribers_table').DataTable({
            colReorder: false,
            scrollX: true,
            stateSave: true,
            "autoWidth": false,
            "pageLength": 500,
            "bSort": false,
            "lengthMenu": [ [25, 50, 100, 500], [25, 50, 100, 500] ],
            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'Subscriber Search'
            }
        });
    });
</script>


@endsection
