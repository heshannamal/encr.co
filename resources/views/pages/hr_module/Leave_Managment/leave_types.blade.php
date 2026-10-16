@extends('layouts.app', ['activePage' => 'Leave_Types', 'titlePage' => __('Leave Types')])

@section('content')
<style>
.btn-grey-text {
        outline: unset !important;
        padding: 10px;
        color: #B3B3B3;
        font-weight: 700;
        font-size: .7rem;
        cursor: pointer;
        background-color: transparent;
        border: 1px solid #b3b3b3;
        border-radius: 5px;
    }
    .btn-grey-text:hover{
        color: #ffffff;
        background-color: #B3B3B3;
    }
</style>

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


    <div class="col-md-12">
        <div class="row">
            <div class="col d-flex justify-content-end">

                <button type="button"   class="btn btn-success add_leave_type mt-2" style="margin-bottom:0.5rem">Add Leave Group</button>
            </div>
        </div>
        <div class="card">
            <div class="row" style="margin: 10px;">
                <div class="col">

                    <table class="table align-items-center " id="employee_leave_type_table" style="width:100%;">

                        <thead style="background-color: #717070;">
                            <th class="table_header_text">ID</th>
                            <th class="table_header_text">TYPE NAME</th>
                            <th class="table_header_text" style="text-align: center;">ANNUAL LEAVE</th>
                            <th class="table_header_text" style="text-align: center;">MEDICAL LEAVE</th>
                            <th class="table_header_text" style="text-align: center;">CASUAL LEAVE</th>
                            <th class="table_header_text" style="text-align: center;">ACTION</th>
                        </thead>
                        <tbody>
                            @foreach ($leaveTypes as $leaveType)
                            <tr>
                                <td style="text-align: center;">{{$leaveType->id}}</td>
                                <td>{{$leaveType->name}}</td>
                                <td style="text-align: center;">{{$leaveType->annual}}</td>
                                <td style="text-align: center;">{{$leaveType->medical}}</td>
                                <td style="text-align: center;">{{$leaveType->casual}}</td>
                                <td style="text-align: center;">
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#leavetype_edit_Modal"
                                        onclick="editLeaveType({{ $leaveType->id }}, '{{ $leaveType->name }}', {{ $leaveType->annual }}, {{ $leaveType->medical }}, {{ $leaveType->casual }})">
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
                <h5 class="modal-title" id="editModalLabel">Edit Leave Group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('leavetype.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- This is important for sending the PUT request to update -->
                <div class="modal-body">
                    <input type="hidden" name="leave_type_id" id="edit_leave_type_id"> <!-- Hidden input for the leave type ID -->

                    <div class="col-12 mb-3">
                        <div class="card p-3 h-100">
                            <div class="row px-3 pb-2">
                                <div class="col-12">
                                    <label for="edit_employee_leave_title" class="form-label">Type Name</label>
                                    <input
                                        class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                        name="employee_leave_title"
                                        id="edit_employee_leave_title" type='text'
                                        value=""
                                    />
                                </div>
                            </div>

                            <div class="row px-3 pb-2 leave-div" id="multiple_days_div">
                                <div class="col-6">
                                    <label for="edit_Annual_Leaves" class="form-label">Annual Leave</label>
                                    <input
                                        class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                        name="Annual_Leaves"
                                        id="edit_Annual_Leaves" type='number'
                                        value=""
                                    />
                                </div>
                                <div class="col-6">
                                    <label for="edit_Medical_Leaves" class="form-label">Medical Leave</label>
                                    <input
                                        class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                        name="Medical_Leaves"
                                        id="edit_Medical_Leaves" type='number'
                                        value=""
                                    />
                                </div>
                                <div class="col-6">
                                    <label for="edit_Casual_Leaves" class="form-label">Casual Leave</label>
                                    <input
                                        class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                        name="Casual_Leaves"
                                        id="edit_Casual_Leaves" type='number'
                                        value=""
                                    />
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

<!-- Modal -->
<div class="modal fade" id="leavetype_create_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Leave Group</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('leavetype.create') }}" method="post" enctype="multipart/form-data">
            @csrf
        <div class="modal-body">
            <div class="col-12 mb-3">
                <div class="card p-3 h-100">

                    <div class="row px-3 pb-2" >

                        <div class="col-12">
                            <label for="employee_leave_title" class="form-label">Type Name</label>
                            <input
                            class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                            name="employee_leave_title"
                            id="employee_leave_title" type='text'
                            value=""
                              />
                        </div>

                    </div>

                    <div class="row px-3 pb-2 leave-div" id="multiple_days_div" >

                        <div class="col-6">
                            <label for="Annual_Leaves" class="form-label">Annual Leave</label>
                            <input
                                class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                name="Annual_Leaves"
                                id="Annual_Leaves" type='number'
                                value=""
                                />
                        </div>
                        <div class="col-6">
                            <label for="Medical_Leaves" class="form-label">Medical Leave</label>
                            <input
                                class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                name="Medical_Leaves"
                                id="Medical_Leaves" type='number'
                                value=""
                                />
                        </div>
                        <div class="col-6">
                            <label for="Casual_Leaves" class="form-label">Casual Leave</label>
                            <input
                                class="form-control" style="border: 1px solid #DEDEDE;border-radius:0rem"
                                name="Casual_Leaves"
                                id="Casual_Leaves" type='number'
                                value=""
                                />
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
    function editLeaveType(id, name, annual, medical, casual) {
        // Set the modal fields with the leave type data
        $('#edit_leave_type_id').val(id);
        $('#edit_employee_leave_title').val(name);
        $('#edit_Annual_Leaves').val(annual);
        $('#edit_Medical_Leaves').val(medical);
        $('#edit_Casual_Leaves').val(casual);
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
                    url: "{{ url('/leave-type/delete') }}/" + id,
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
            paging: true,         // Enable pagination
            searching: true,      // Enable search functionality
            ordering: true,       // Enable column sorting
            info: true,           // Show table info (e.g., "Showing 1 to 10 of 50 entries")
            responsive: true,     // Make table responsive on smaller screens
        });


    });
</script>
@endsection
