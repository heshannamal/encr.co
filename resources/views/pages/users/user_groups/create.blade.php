<style>
    .group_name {
        width: 40%;
    }
    #new_user_group_name,
    #new_narration {
        width: 60%;
    }
</style>

<div class="modal fade" id="usergroup_create_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Add New User Group</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('user_groups.create') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6 form-field">
                                <label class="form-lable group_name">User Group Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-input" id="new_user_group_name" name="new_user_group_name" required />
                            </div>

                            <div class="col-md-6 form-field">
                                <label class="form-lable">Narration</label>
                                <textarea type="text" class="form-control form-input" id="new_narration" name="new_narration" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom"  type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="submit" class="btn btn-success btn-custom">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
