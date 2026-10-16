<div class="modal fade" id="add_assignee_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Add Project Assignee</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body" style="padding: 1rem 2rem !important;">
                <div class="d-flex">
                    <div class="col-12">
                        <p>Select the project assignee from the following dropdown list.</p>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="form-group">
                        <label for="">Assignee</label>
                        <select class="select2-assignee" name="assignee" id="assignee">
                            <option value="">Select the Project assignee</option>
                                {{-- @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }}
                                    </option>
                                @endforeach --}}
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}" data-type="group">{{ $group->name }}</option>
                                @endforeach
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" data-type="user">{{ $user->name }}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary">CANCEL</button>
                    <button type="button" class="btn btn-success" id="add_assignee">ADD ASSIGNEE</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#assignee').select2({
        width: '100%',
        placeholder: 'Select the Project assignee',
        allowClear: true,
        dropdownParent: $('#add_assignee_modal'),
    });

    $('#add_assignee').on('click', function() {
        var assigneeId = $('#assignee').val();
        if(assigneeId != ''){
            var assigneeDataType = $('#assignee option:selected').attr('data-type');

            $.ajax({
                url:'{{ url("projects/add_assignee") }}',
                method:'POST',
                dataType:'json',
                data:{'project_id':mainProductId, 'assignee_id':assigneeId, 'assignee_type':assigneeDataType, '_token':'{{csrf_token()}}'},
                beforeSend: function(){ $(".se-pre-con").fadeIn(); },
                success: function(data)
                {
                    $(".se-pre-con").fadeOut();
                    $("#add_assignee_modal").modal('hide');
                    console.log(data);
                    Swal.fire(
                        data[3][1],
                        data[3][2],
                        data[3][0],
                    );
                    $('#assignee option').each(function(){
                        console.log($(this).val());
                        if($(this).val() == data[1] && $(this).attr('data-type') == data[2]){
                            $(this).remove();
                        }
                    });

                    displayAssignees();
                },
            });
            console.log(assigneeDataType);
        } else {
            Swal.fire(
                'Error!',
                'Please select an assignee!',
                'error'
            )
        }
    });
</script>
