@extends('pages.customer_portal.layouts.sidebar', ['sub_active' => 'shipping'])

@section('sub-sidebar-content')

<style>
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
    .new-style-table .alphabet {
        padding-right: 1rem;
        padding-left: 1rem;
    }
</style>
@section('portal-header')
    SHIPPING
@endsection
<div class="container-fluid new-style-table mt-4" style="padding: 0px;">
    <div class="col-md-12 mt-2" style="padding-right: 19px;">
        <div>
            <table class="table align-items-center cell-border">
                <thead>
                    <th style="color: white">ORDER ID</th>
                    <th style="color: white">SHIPPING DATE</th>
                    <th style="color: white">SALES REP</th>
                    <th style="color: white">AMOUNT ($)</th>
                    <th style="color: white">STATUS</th>
                    <th style="color: white">CONTACT PERSON</th>
                    <th style="color: white">DESCRIPTION</th>
                </thead>

                <tbody>
                        <td><a href="">1578</a></td>
                        <td>024-01-02</td>
                        <td>TEST USER</td>
                        <td>125.00</td>
                        <td>Quote</td>
                        <td>User</td>
                        <td>Test description</td>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
