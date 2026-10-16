
<style>
    .group_name {
        width: 40%;
    }
    #edit_user_group_name,
    #edit_narration {
        width: 60%;
    }
</style>

<div class="modal fade" id="usergroup_edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Edit User Group</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('user_groups.update') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row">
                            <input type="hidden" id="user_group_id" name="user_group_id"/>
                            <div class="col-md-6 form-field">
                                <label class="form-lable group_name">User Group Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-input" id="edit_user_group_name" name="edit_user_group_name" required />
                            </div>

                            <div class="col-md-6 form-field">
                                <label class="form-lable">Narration</label>
                                <textarea type="text" class="form-control form-input" id="edit_narration" name="edit_narration" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom" type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        @can('delete usergroup members')
                        <button type="button" class="btn btn-danger btn-custom delete">Delete</button>
                        @endcan
                        @can('edit usergroup  members')
                        <button type="submit" class="btn btn-success btn-custom">Update</button>
                        @endcan
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#usergroup_edit_modal').on('shown.bs.modal', function (e) {
        var userGroupId = $('#user_group_id').val();

        $.ajax({
            url: '{{url("user_groups/edit")}}/'+userGroupId,
            type: 'GET',
            dataType: 'json',
            success: function(data){
                console.log(data);
                $('#edit_user_group_name').val(data.user_group_name);
                $('#edit_narration').val(data.narration);
            }
        });
    })

    $(".delete").on("click", function(){
        var userGroupId = $('#user_group_id').val();
        window.location.replace("../../user_groups/delete/"+userGroupId);
    });

</script>
