
<style>
    .role_name {
        width: 40%;
    }
    #edit_user_role_name,
    #edit_narration {
        width: 60%;
    }
    .check-role {
        height: 16px;
    }
</style>

<div class="modal fade" id="permission_user_edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Edit User Permission</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('user_permission.update') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row">
                            <input type="hidden" id="permission_id" name="permission_id"/>
                            <div class="col-md-8 form-field">
                                <label class="form-lable role_name">Permission Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-input" id="edit_permission_name" name="permission_name" required />
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($roles as $role)
                                <div class="col-md-3 form-field">
                                    <input type="checkbox" class="form-input check-role" name="roles[{{ $role->id }}]" id="edit_check-{{ $role->id }}" value="{{ $role->id }}">
                                    <label for="edit_check-{{ $role->id }}"> {{ $role->name }} </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom"  type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="button" class="btn btn-danger btn-custom delete">Delete</button>
                        <button type="submit" class="btn btn-success btn-custom">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#permission_user_edit_modal').on('shown.bs.modal', function (e) {
        var permissionId = $('#permission_id').val();
        $(".check-role").prop('checked', false);

        $.ajax({
            url: '{{url("permission/edit")}}/'+permissionId,
            type: 'GET',
            dataType: 'json',
            success: function(data){
                var permission = data[0];
                var roleArr = data[1];
                console.log(roleArr);
                $('#edit_permission_name').val(permission.name);
                if(roleArr.length > 0){
                    for (var i = 0; i < roleArr.length; i++) {
                        console.log(roleArr[i].id);
                        $('#edit_check-'+ roleArr[i].id).prop('checked', true);
                    }
                }
            }
        });
    })

    $(".delete").on("click", function(){
        var permissionId = $('#permission_id').val();
        window.location.replace("{{ url('permission/delete') }}/"+permissionId);
    });

</script>
