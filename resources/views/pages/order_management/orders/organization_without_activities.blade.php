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
        <span>ORGANIZATION WITHOUT ACTIVITIES</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12 mt-4">
        <div class="card">
                <div class="col-md-12 mt-3 text-right">
                    <a href="{{ route('orders.organization_without_activities_export') }}"
                    class="btn-green-filled">
                        EXPORT CSV
                    </a>
                </div>
                <div class="col-md-12 new-style-table">
                    <div class="mt-3 mb-3">
                        <table class="table-responsive table align-items-center" id="organization_wo_actvities_table">
                            <thead>
                                <th scope="col">Organization Name</th>
                                    <th scope="col">Sport</th>
                                    <th scope="col">Website</th>
                                    <th scope="col">Country</th>
                                    <th scope="col">Sales Tax</th>
                                    <th scope="col">Active</th>
                                    <th scope="col">Created At</th>
                            </thead>

                            <tbody class="list" id="tableBody">
                                @forelse ($organizations as $organization)
                                    <tr>
                                        <td>
                                            <a href="{{ route('organizations.info', $organization->id) }}">
                                                {{ $organization->organization_name }}
                                            </a>
                                        </td>

                                        <td>{{ $organization->sport ?? 'N/A' }}</td>

                                        <td>
                                            @if ($organization->website)
                                                <a href="{{ $organization->website }}" target="_blank">
                                                    {{ $organization->website }}
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </td>

                                        <td>{{ $organization->shipping_country ?? 'N/A' }}</td>

                                        <td>
                                            {{ number_format($organization->sales_tax, 2) }}
                                            @if ($organization->sales_tax_active)
                                                <span class="badge badge-success ml-1">Active</span>
                                            @else
                                                <span class="badge badge-secondary ml-1">Inactive</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($organization->active)
                                                <span class="badge badge-success">Yes</span>
                                            @else
                                                <span class="badge badge-danger">No</span>
                                            @endif
                                        </td>

                                        <td>{{ $organization->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            No organizations found
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>

                    </div>

                </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function () {
        $('#organization_wo_actvities_table').DataTable({
            colReorder: true,
            stateSave: true,
            autoWidth: false,

            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'Search'
            },

            paging: true,
            pageLength: 50,     // default rows per page
            info: false,

            columnDefs: [
                { type: 'date', targets: [6] }
            ]
        });
    });
</script>



@endsection
