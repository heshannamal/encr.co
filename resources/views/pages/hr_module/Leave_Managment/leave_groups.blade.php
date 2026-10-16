@extends('layouts.app', ['activePage' => 'Leave_Groups', 'titlePage' => __('Leave Groups')])

<style>
@media (max-width: 767px) {

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

    /* ===== Add Leave Group button -> full width, green, with + icon ===== */
    .col.d-flex.justify-content-end {
        justify-content: stretch !important;
        padding-right: 0px;
        padding-left: 0px;
    }
    .add_leave_group_btn {
        width: 100% !important;
        margin-top: 0 !important;
        margin-bottom: 12px !important;
        padding: 12px !important;
        font-size: 14px !important;
        border-radius: 8px !important;
        background-color: #14B8A6 !important;
        border-color: #2dce89 !important;
        font-size: 0 !important; /* hide original text, add "+ " version below */
    }
    .add_leave_group_btn::after {
        content: "+  Add Leave Group";
        font-size: 14px;
    }

    /* ===== Card wrapper around the table ===== */
    .container-fluid.mb-5.content-position > .col-md-12 > .card {
        background: transparent;
        box-shadow: none;
        border: none;
    }

    /* ===== DataTables search box / length / info / pagination ===== */
    #employee_leave_group_table_wrapper .dataTables_length { display: none; }
    #employee_leave_group_table_wrapper .dataTables_filter {
        width: 100%;
        text-align: left;
        margin-bottom: 10px;
        position: relative;
    }
    #employee_leave_group_table_wrapper .dataTables_filter label {
        width: 100%;
        display: block;
        font-size: 0;
    }
     #employee_leave_group_table_wrapper .dataTables_filter input {
        width: 100% !important;
        margin-left: 0 !important;
        border-radius: 10px;
        height: 42px;
        padding: 0 14px 0 34px;
        font-size: 14px;
        border: 1px solid #ddd;
        box-sizing: border-box;
    }
    #employee_leave_group_table_wrapper .dataTables_filter::before {
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
    #employee_leave_group_table_wrapper .dataTables_info,
    #employee_leave_group_table_wrapper .dataTables_paginate {
        width: 100%;
        text-align: center;
        font-size: 12px;
        padding: 6px 0;
    }

    /* ===== Table -> card list ===== */
    #employee_leave_group_table thead { display: none; }
    #employee_leave_group_table,
    #employee_leave_group_table tbody {
        display: block;
        width: 100%;
    }
    #employee_leave_group_table tbody tr {
        display: grid;
        grid-template-columns: auto 1fr auto;
        grid-template-areas:
            "id name action"
            "badges badges badges";
        column-gap: 8px;
        row-gap: 8px;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 14px;
        margin-bottom: 10px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }
    #employee_leave_group_table tbody td {
        display: block;
        border: none !important;
        padding: 0 !important;
        text-align: left !important;
    }

    /* ID (column 1) — small bold number before the name */
    #employee_leave_group_table tbody td:nth-child(1) {
        grid-area: id;
        font-size: 14px;
        font-weight: 700;
        color: #1a1a1a;
    }

    /* Group Name (column 2) */
    #employee_leave_group_table tbody td:nth-child(2) {
        grid-area: name;
        font-size: 14px;
        font-weight: 600;
        color: #1a1a1a;
    }

    /* Leave Details badges (column 3) */
    #employee_leave_group_table tbody td:nth-child(3) {
        grid-area: badges;
        display: flex !important;
        flex-wrap: wrap;
        gap: 6px;
    }
    #employee_leave_group_table tbody td:nth-child(3) .badge {
        background: #f2f3f4 !important;
        color: #555555 !important;
        border: none !important;
        border-radius: 20px !important;
        padding: 5px 12px !important;
        font-size: 11px !important;
        font-weight: 500;
        margin-right: 0 !important;
    }

    /* Action buttons (column 4) -> icon circles */
    #employee_leave_group_table tbody td:nth-child(4) {
        grid-area: action;
        justify-self: end;
        align-self: start;
        display: flex;
        gap: 6px;
    }
    #employee_leave_group_table tbody td:nth-child(4) .btn {
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
    #employee_leave_group_table tbody td:nth-child(4) .btn-primary {
        background: #eaf1ff !important;
    }
    #employee_leave_group_table tbody td:nth-child(4) .btn-primary::before {
        font-family: "FontAwesome";
        content: "\f044"; /* pencil */
        font-size: 12px;
        color: #2f6fed;
    }
    #employee_leave_group_table tbody td:nth-child(4) .btn-danger {
        background: #fdecea !important;
    }
    #employee_leave_group_table tbody td:nth-child(4) .btn-danger::before {
        font-family: "FontAwesome";
        content: "\f1f8"; /* trash */
        font-size: 12px;
        color: #e53935;
    }

    /* ===== Reorder search box / button / "Showing X" / cards ===== */
    #employee_leave_group_table_wrapper {
        display: flex;
        flex-direction: column;
    }
    #employee_leave_group_table_wrapper .dataTables_filter { order: 1; }
    #employee_leave_group_table_wrapper > .row { order: 2; }
    #employee_leave_group_table_wrapper .dataTables_info {
        order: 3;
        text-align: left !important;
        margin: 4px 0 10px !important;
    }
    #employee_leave_group_table_wrapper #employee_leave_group_table { order: 4; }
    #employee_leave_group_table_wrapper .dataTables_paginate { order: 5; }
    

        /* ===== Add/Edit Leave Group modals ===== */
    #leavegroup_create_Modal .modal-dialog,
    #leavegroup_edit_Modal .modal-dialog {
        margin: 30px 14px !important;
        max-width: calc(100% - 28px) !important;
        width: calc(100% - 28px) !important;
    }
    #leavegroup_create_Modal .modal-content,
    #leavegroup_edit_Modal .modal-content {
        border-radius: 14px !important;
        border: none !important;
        overflow: hidden;
    }
    #leavegroup_create_Modal .modal-header,
    #leavegroup_edit_Modal .modal-header {
        border-bottom: 1px solid #eee !important;
        padding: 18px 20px 14px !important;
    }
    #leavegroup_create_Modal .modal-title,
    #leavegroup_edit_Modal .modal-title {
        font-size: 18px !important;
        font-weight: 700 !important;
        color: #1a1a1a;
    }
    #leavegroup_create_Modal .card.p-3.h-100,
    #leavegroup_edit_Modal .card.p-3.h-100 {
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
    }
    #leavegroup_create_Modal .modal-body,
    #leavegroup_edit_Modal .modal-body {
        padding: 18px 20px !important;
    }
    #leavegroup_create_Modal .form-label,
    #leavegroup_edit_Modal .form-label {
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #1a1a1a;
        margin-bottom: 6px !important;
    }
    #leavegroup_create_Modal .modal-body input.form-control,
    #leavegroup_edit_Modal .modal-body input.form-control {
        border: 1px solid #e0e0e0 !important;
        border-radius: 8px !important;
        padding: 10px 12px !important;
        font-size: 14px !important;
        height: auto !important;
    }
    #leavegroup_create_Modal .modal-footer,
    #leavegroup_edit_Modal .modal-footer {
        border-top: none !important;
        padding: 14px 20px 20px !important;
        display: flex !important;
        gap: 10px;
    }
    #leavegroup_create_Modal .modal-footer .btn,
    #leavegroup_edit_Modal .modal-footer .btn {
        flex: 1 1 0;
        margin: 0 !important;
        padding: 12px !important;
        border-radius: 8px !important;
        font-size: 14px !important;
        font-weight: 600;
    }
    #leavegroup_create_Modal .modal-footer .btn-secondary,
    #leavegroup_edit_Modal .modal-footer .btn-secondary {
        background: #b9bfc7 !important;
        border: none !important;
        color: #fff !important;
    }
    #leavegroup_create_Modal .modal-footer .btn-success,
    #leavegroup_edit_Modal .modal-footer .btn-success {
        background: #1AA05A !important;
        border: none !important;
        color: #fff !important;
    }

        /* ===== Give the Add/Edit form more breathing room + wider inputs ===== */
            /* ===== Give the Add/Edit form more breathing room + wider inputs ===== */
    #leavegroup_create_Modal .modal-body > .col-12.mb-3,
    #leavegroup_edit_Modal .modal-body > .col-12.mb-3 {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
    #leavegroup_create_Modal .modal-body .row.px-3.pb-2,
    #leavegroup_edit_Modal .modal-body .row.px-3.pb-2 {
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        margin-bottom: 10px !important;
    }
    #leavegroup_create_Modal .modal-body .row.px-3.pb-2 > [class*="col-"],
    #leavegroup_edit_Modal .modal-body .row.px-3.pb-2 > [class*="col-"] {
        padding-left: 6px !important;
        padding-right: 6px !important;
    }
    #leavegroup_create_Modal .modal-body input.form-control,
    #leavegroup_edit_Modal .modal-body input.form-control {
        padding: 12px 14px !important;
    }
    .back_home_mobile {
        padding-left: 32px;
        padding-bottom: 10px;
    }

    .swal2-popup .swal2-styled {
        margin: 0 .3125em;
        padding: 5px 8px !important;
        font-weight: 500;
        box-shadow: none;
    }
}

@media (min-width: 768px) {
    .back_home_mobile {
        display: none;
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
        <span>LEAVE GROUP</span>
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
                <button type="button" class="btn btn-success add_leave_group_btn mt-2" style="margin-bottom:0.5rem">Add Leave Group</button>
            </div>
        </div>
        <div class="card">
            <div class="row" style="margin: 10px;">
                <div class="col">
                    <table class="table align-items-center " id="employee_leave_group_table" style="width:100%;">
                        <thead style="background-color: #717070;">
                            <th class="table_header_text">ID</th>
                            <th class="table_header_text">GROUP NAME</th>
                            <th class="table_header_text">LEAVE DETAILS</th>
                            <th class="table_header_text" style="text-align: center;">ACTION</th>
                        </thead>
                        <tbody>
                            @foreach ($leaveGroups as $group)
                            <tr>
                                <td style="text-align: center;">{{ $group->id }}</td>
                                <td>{{ $group->name }}</td>
                                <td>
                                    @foreach($group->leaveGroupItems as $item)
                                        <span class="badge badge-secondary" style="background-color: #e9ecef; color: #495057; border: 1px solid #ced4da; margin-right: 5px;">
                                            {{ $item->leaveType ? $item->leaveType->name : 'Unknown Type' }} : <strong>{{ $item->leave_days }}</strong>
                                        </span>
                                    @endforeach
                                </td>
                                <td style="text-align: center;">
                                    <button class="btn btn-primary btn-sm" 
                                        onclick='editLeaveGroup(@json($group))'>
                                        Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteLeaveGroup({{ $group->id }})">Delete</button>
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

<!-- Update Leave Group Edit Model-->
<div class="modal fade" id="leavegroup_edit_Modal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Leave Group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('leavegroup.update') }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="leave_group_id" id="edit_leave_group_id">

                    <div class="col-12 mb-3">
                        <div class="card p-3 h-100">
                            <div class="row px-3 pb-2">
                                <div class="col-12">
                                    <label for="edit_leave_group_name" class="form-label">Group Name</label>
                                    <input class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                        name="leave_group_name" id="edit_leave_group_name" type='text' required />
                                </div>
                            </div>

                            <div class="row px-3 pb-2">
                                @foreach($masterTypes as $mType)
                                <div class="col-6 mb-2">
                                    <label class="form-label">{{ $mType->name }}</label>
                                    <input class="form-control edit_leave_days_input" 
                                        style="border: 1px solid #DEDEDE;border-radius:0rem"
                                        name="leave_days[{{ $mType->id }}]" 
                                        id="edit_days_{{ $mType->id }}" 
                                        type='number' value="0" />
                                </div>
                                @endforeach
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

<!-- Create New Leave Group Model-->
<div class="modal fade" id="leavegroup_create_Modal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createModalLabel">Add Leave Group</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('leavegroup.create') }}" method="post">
            @csrf
            <div class="modal-body">
                <div class="col-12 mb-3">
                    <div class="card p-3 h-100">
                        <div class="row px-3 pb-2" >
                            <div class="col-12">
                                <label for="leave_group_name" class="form-label">Group Name</label>
                                <input class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                    name="leave_group_name" id="leave_group_name" type='text' placeholder="Add Leave Group Name" required />
                            </div>
                        </div>

                        <div class="row px-3 pb-2">
                            @foreach($masterTypes as $mType)
                            <div class="col-6 mb-2">
                                <label class="form-label">{{ $mType->name }}</label>
                                <input class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                    name="leave_days[{{ $mType->id }}]" type='number' value="0" />
                            </div>
                            @endforeach
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
    
    function editLeaveGroup(group) {
        // Set Group ID and Name
        $('#edit_leave_group_id').val(group.id);
        $('#edit_leave_group_name').val(group.name);

        // Reset all dynamic inputs in the edit modal to 0
        $('.edit_leave_days_input').val(0);

        // Fill inputs based on the group's items
        if(group.leave_group_items) {
            group.leave_group_items.forEach(function(item) {
                $('#edit_days_' + item.leave_type_id).val(item.leave_days);
            });
        }
        
        $('#leavegroup_edit_Modal').modal('show');
    }

    function deleteLeaveGroup(id) {
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
                $.ajax({
                    url: "{{ url('/leave-Manage/leavegroups/delete') }}/" + id,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        Swal.fire('Deleted!', 'The group has been removed.', 'success')
                        .then(() => { location.reload(); });
                    },
                    error: function() {
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    }

    $(document).ready(function() {
        $('.add_leave_group_btn').on('click', function() {
            $('#leavegroup_create_Modal').modal('show');
        });

        $('#employee_leave_group_table').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            responsive: true,
        });

        $('#employee_leave_group_table_wrapper .dataTables_filter input').attr('placeholder', 'Search');
        if (window.innerWidth <= 767) {
            var $btnRow = $('.add_leave_group_btn').closest('.row');
            var $filterBox = $('#employee_leave_group_table_wrapper .dataTables_filter');
            if ($btnRow.length && $filterBox.length) {
                $btnRow.insertAfter($filterBox);
            }
        }
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