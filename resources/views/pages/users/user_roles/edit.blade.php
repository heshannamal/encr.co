<div class="modal fade" id="userrole_edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="width: 400px; height: 500px;">
        <div class="modal-content rounded-0">
            <div class="modal-header border-bottom">
                <h2 class="modal-title font-weight-bold">Edit Employee Group</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('user_roles.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="edit_user_role_id" name="user_role_id" />

                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-normal p-2">Employee Group Name</label>
                        <input
                            type="text"
                            class="form-control form-control-sm p-2"
                            id="edit_user_role_name"
                            name="edit_user_role_name"
                            style="border:1px solid #ced4da; width: 100%;"
                            required />
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-normal p-2">Narration</label>
                        <textarea
                            class="form-control form-control-sm p-2"
                            id="edit_narration"
                            name="edit_narration"
                            rows="4"
                            style="border:1px solid #ced4da; width: 100%;">
                        </textarea>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0">
                    <button class="btn btn-secondary btn-sm text-uppercase px-4" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm text-uppercase px-4">Update Employee Group</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#userrole_edit_modal').on('shown.bs.modal', function(e) {
        var userRoleId = $('#edit_user_role_id').val();
        if (!userRoleId) return;

        $.ajax({
            url: "{{ url('user_roles/edit') }}/" + userRoleId,
            type: 'GET',
            success: function(data) {
                var obj = typeof data === 'string' ? JSON.parse(data) : data;
                $('#edit_user_role_name').val(obj.name);
                $('#edit_narration').val(obj.narration);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert("Ajax error");
            }
        });
    });
</script>