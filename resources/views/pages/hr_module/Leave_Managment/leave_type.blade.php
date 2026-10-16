@extends('layouts.app', ['activePage' => 'Leave_Type', 'titlePage' => __('Leave Type')])


<style>
@media (max-width: 767px) {

    .main-content {
        min-height: auto !important;
        height: auto !important;
    }9

    /* ===== Page padding ===== */
    .container-fluid.mb-5.content-position {
        padding-left: 4px !important;
        padding-right: 4px !important;
    }
    .container-fluid.mb-5.content-position .col-md-12 {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
    .container-fluid.mb-5.content-position .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }

    /* ===== Add Leave Type button -> full width, green, with + icon ===== */
    .col.d-flex.justify-content-end {
        justify-content: stretch !important;
    }
    .add_leave_type {
        width: 100% !important;
        margin-top: 0 !important;
        margin-bottom: 12px !important;
        padding: 12px !important;
        border-radius: 8px !important;
        background-color: #1AA05A !important;
        border-color: #1AA05A !important;
        font-size: 0 !important;
    }
    .add_leave_type::after {
        content: "+  Add Leave Type";
        font-size: 14px;
    }

    /* ===== Card wrapper around the table ===== */
    .container-fluid.mb-5.content-position > .col-md-12 > .card {
        background: transparent;
        box-shadow: none;
        border: none;
    }

    /* ===== DataTables search box / length / info / pagination ===== */
    #employee_leave_type_table_wrapper .dataTables_length { display: none; }
    #employee_leave_type_table_wrapper .dataTables_filter {
        width: 100%;
        text-align: left;
        margin-bottom: 10px;
        position: relative;
    }
    #employee_leave_type_table_wrapper .dataTables_filter label {
        width: 100%;
        display: block;
        font-size: 0;
    }
    #employee_leave_type_table_wrapper .dataTables_filter input {
        width: 100% !important;
        margin-left: 0 !important;
        border-radius: 10px;
        height: 42px;
        padding: 0 14px 0 34px;
        font-size: 14px;
        border: 1px solid #ddd;
        box-sizing: border-box;
    }
    #employee_leave_type_table_wrapper .dataTables_filter::before {
        font-family: "FontAwesome";
        content: "\f002";
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
        font-size: 13px;
        z-index: 2;
    }
    #employee_leave_type_table_wrapper .dataTables_info,
    #employee_leave_type_table_wrapper .dataTables_paginate {
        width: 100%;
        text-align: center;
        font-size: 12px;
        padding: 6px 0;
    }

    /* ===== Reorder: search box -> button -> "Showing X" -> cards -> pagination ===== */
    #employee_leave_type_table_wrapper {
        display: flex;
        flex-direction: column;
    }
    #employee_leave_type_table_wrapper .dataTables_filter { order: 1; }
    #employee_leave_type_table_wrapper > .row { order: 2; }
    #employee_leave_type_table_wrapper .dataTables_info {
        order: 3;
        text-align: left !important;
        margin: 4px 0 10px !important;
    }
    #employee_leave_type_table_wrapper #employee_leave_type_table { order: 4; }
    #employee_leave_type_table_wrapper .dataTables_paginate { order: 5; }

    /* ===== Table -> card list ===== */
    #employee_leave_type_table thead { display: none; }
    #employee_leave_type_table,
    #employee_leave_type_table tbody {
        display: block;
        width: 100%;
    }
    #employee_leave_type_table tbody tr {
        display: grid;
        grid-template-columns: auto 1fr auto;
        grid-template-areas: "id name action";
        column-gap: 8px;
        align-items: center;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 14px;
        margin-bottom: 10px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }
    #employee_leave_type_table tbody td {
        display: block;
        border: none !important;
        padding: 0 !important;
        text-align: left !important;
    }

    /* ID (column 1) */
    #employee_leave_type_table tbody td:nth-child(1) {
        grid-area: id;
        font-size: 14px;
        font-weight: 700;
        color: #1a1a1a;
    }

    /* Leave Type name (column 2) */
    #employee_leave_type_table tbody td:nth-child(2) {
        grid-area: name;
        font-size: 14px;
        font-weight: 600;
        color: #1a1a1a;
    }

    /* Action buttons (column 3) -> icon circles */
    #employee_leave_type_table tbody td:nth-child(3) {
        grid-area: action;
        justify-self: end;
        display: flex;
        gap: 6px;
    }
    #employee_leave_type_table tbody td:nth-child(3) .btn {
        width: 28px !important;
        height: 28px !important;
        padding: 0 !important;
        border-radius: 50% !important;
        font-size: 0 !important;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        border: none !important;
    }
    #employee_leave_type_table tbody td:nth-child(3) .btn-primary {
        background: #eaf1ff !important;
    }
    #employee_leave_type_table tbody td:nth-child(3) .btn-primary::before {
        font-family: "FontAwesome";
        content: "\f044";
        font-size: 12px;
        color: #2f6fed;
    }
    #employee_leave_type_table tbody td:nth-child(3) .btn-danger {
        background: #fdecea !important;
    }
    #employee_leave_type_table tbody td:nth-child(3) .btn-danger::before {
        font-family: "FontAwesome";
        content: "\f1f8";
        font-size: 12px;
        color: #e53935;
    }

    /* ===== Add/Edit Leave Type modals ===== */
    #leavetype_create_Modal .modal-dialog,
    #leavetype_edit_Modal .modal-dialog {
        margin: 30px 14px !important;
        max-width: calc(100% - 28px) !important;
        width: calc(100% - 28px) !important;
    }
    #leavetype_create_Modal .modal-content,
    #leavetype_edit_Modal .modal-content {
        border-radius: 14px !important;
        border: none !important;
        overflow: hidden;
    }
    #leavetype_create_Modal .modal-header,
    #leavetype_edit_Modal .modal-header {
        border-bottom: 1px solid #eee !important;
        padding: 18px 20px 14px !important;
    }
    #leavetype_create_Modal .modal-title,
    #leavetype_edit_Modal .modal-title {
        font-size: 18px !important;
        font-weight: 700 !important;
        color: #1a1a1a;
    }
    #leavetype_create_Modal .card.p-3.h-100,
    #leavetype_edit_Modal .card.p-3.h-100 {
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
    }
    #leavetype_create_Modal .modal-body,
    #leavetype_edit_Modal .modal-body {
        padding: 18px 20px !important;
    }
    #leavetype_create_Modal .modal-body > .col-12.mb-3,
    #leavetype_edit_Modal .modal-body > .col-12.mb-3 {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
    #leavetype_create_Modal .modal-body .row.px-3.pb-2,
    #leavetype_edit_Modal .modal-body .row.px-3.pb-2 {
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
    #leavetype_create_Modal .form-label,
    #leavetype_edit_Modal .form-label {
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #1a1a1a;
        margin-bottom: 6px !important;
    }
    #leavetype_create_Modal .modal-body input.form-control,
    #leavetype_edit_Modal .modal-body input.form-control {
        border: 1px solid #e0e0e0 !important;
        border-radius: 8px !important;
        padding: 12px 14px !important;
        font-size: 14px !important;
        height: auto !important;
    }
    #leavetype_create_Modal .modal-footer,
    #leavetype_edit_Modal .modal-footer {
        border-top: none !important;
        padding: 14px 20px 20px !important;
        display: flex !important;
        gap: 10px;
    }
    #leavetype_create_Modal .modal-footer .btn,
    #leavetype_edit_Modal .modal-footer .btn {
        flex: 1 1 0;
        margin: 0 !important;
        padding: 12px !important;
        border-radius: 8px !important;
        font-size: 14px !important;
        font-weight: 600;
    }
    #leavetype_create_Modal .modal-footer .btn-secondary,
    #leavetype_edit_Modal .modal-footer .btn-secondary {
        background: #b9bfc7 !important;
        border: none !important;
        color: #fff !important;
    }
    #leavetype_create_Modal .modal-footer .btn-success,
    #leavetype_edit_Modal .modal-footer .btn-success {
        background: #1AA05A !important;
        border: none !important;
        color: #fff !important;
    }

   

    .back_home_mobile {
        padding-left: 20px;
        padding-bottom: 10px;
    }

    .swal2-popup .swal2-styled {
        margin: 0 .3125em;
        padding: 5px 8px !important;
        font-weight: 500;
        box-shadow: none;
    }

    .leave-type-row {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
    .leave-type-row > .col {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    .container-fluid.mb-5.content-position {
        min-height: 34rem!important;
        height: auto !important;
    }

    
}

@media (min-width: 768px) {
    .back_home_mobile {
        display: none;
    }
    .leave-type-row {
        margin-left: 10px !important;
        margin-right: 10px !important;
         margin-top: 10px !important;
    }

    
}


</style>

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    {{ $errors->first() }}
</div>
@endif

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
    <span>LEAVE TYPES</span>
    @endsection

    @section('back-btn')
    <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    
    @section('back-btn-Mobile')
    <a href="javascript:void(0);" onclick="goBackOnePage()" class="home-btn-color-mobile" title="Back">
        < BACK
    </a>
    @endsection

    <div class="back_home_mobile">
        <strong>
            @yield('back-btn-Mobile')
        </strong>
    </div>


    <div class="col-md-12">
        <div class="row">
            <div class="col d-flex justify-content-end">

                <button type="button" class="btn btn-success add_leave_type mt-2" style="margin-bottom:0.5rem">Add Leave Type</button>
            </div>
        </div>
        <div class="card">
            <div class="row leave-type-row">
                <div class="col">

                    <table class="table align-items-center " id="employee_leave_type_table" style="width:100%;">

                        <thead style="background-color: #717070;">
                            <th class="table_header_text">ID</th>
                            <th class="table_header_text">LEAVE TYPE</th>
                            <th class="table_header_text" style="text-align: center;">ACTION</th>
                        </thead>
                        <tbody>
                            @foreach ($leaveTypes as $leaveType)
                            <tr>
                                <td style="text-align: center;">{{$leaveType->id}}</td>
                                <td>{{$leaveType->name}}</td>
                                <td style="text-align: center;">
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#leavetype_edit_Modal"
                                        onclick="editLeaveType({{ $leaveType->id }}, '{{ $leaveType->name }}')">
                                        Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteLeaveType({{ $leaveType->id }})">Delete</button>
                                </td>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Edit -->
<div class="modal fade" id="leavetype_edit_Modal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Leave Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('masterleavetype.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- This is important for sending the PUT request to update -->
                <div class="modal-body">
                    <input type="hidden" name="leave_type_id" id="edit_leave_type_id"> <!-- Hidden input for the leave type ID -->

                    <div class="col-12 mb-3">
                        <div class="card p-3 h-100">
                            <div class="row px-3 pb-2">
                                <div class="col-12">
                                    <label for="edit_leave_type_name" class="form-label">Edit Type Name</label>
                                    <input
                                        class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                        name="leave_type_name"
                                        id="edit_leave_type_name" type='text'
                                        value="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for New -->
<div class="modal fade" id="leavetype_create_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Leave Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('masterleavetype.create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="col-12 mb-3">
                        <div class="card p-3 h-100">

                            <div class="row px-3 pb-2">

                                <div class="col-12">
                                    <label for="leave_type_name" class="form-label">Leave Type Name</label>
                                    <input
                                        class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                        name="leave_type_name"
                                        id="leave_type_name" type='text'
                                        value="" />
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editLeaveType(id, name) {
        // Set the modal fields with the leave type data
        $('#edit_leave_type_id').val(id);
        $('#edit_leave_type_name').val(name);
    }

    function deleteLeaveType(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {

            if (result.value) {
                // Send the DELETE request to the server
                $.ajax({
                    url: "{{ url('/leave-Manage/mastertype/delete') }}/" + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}', // Add CSRF token
                    },
                    success: function(response) {
                        Swal.fire(
                            'Deactivated!',
                            'The leave type has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload(); // Reload the page to reflect the changes
                        });
                    },
                    error: function(response) {
                        Swal.fire(
                            'Error!',
                            'There was an issue deleting the leave type.',
                            'error'
                        );
                    }
                });
            }
        });
    }
    $(document).ready(function() {

        $(document).on('click', '.add_leave_type', function() {
            $('#leavetype_create_Modal').modal('show'); // Open the modal
        });
        $('#employee_leave_type_table').DataTable({
            paging: true, // Enable pagination
            searching: true, // Enable search functionality
            ordering: true, // Enable column sorting
            info: true, // Show table info (e.g., "Showing 1 to 10 of 50 entries")
            responsive: true, // Make table responsive on smaller screens
        });

        $('#employee_leave_type_table_wrapper .dataTables_filter input').attr('placeholder', 'Search');


    });

    function goBackOnePage() {
        if (document.referrer && document.referrer.indexOf(window.location.host) !== -1) {
            window.history.back();
        } else {
            window.location.href = "{{ route('home') }}";
        }
    }
</script>
@endsection