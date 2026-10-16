<div class="modal fade" id="userrole_create_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="width: 400px; height: 500px;">
        <div class="modal-content rounded-0">
            <div class="modal-header border-bottom">
                <h2 class="modal-title font-weight-bold">Add New Employee Group</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('user_roles.create') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-normal p-2">Employee Group Name</label>
                        <input
                            type="text"
                            class="form-control form-control-sm p-2"
                            id="new_user_role_name"
                            name="new_user_role_name"
                            style="border:1px solid #ced4da;"
                            required />
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-normal p-2">Narration</label>
                        <textarea
                            class="form-control form-control-sm p-2"
                            id="new_narration"
                            name="new_narration"
                            rows="4"
                            style="border:1px solid #ced4da;"></textarea>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0">
                    <button class="btn btn-secondary btn-sm text-uppercase px-4" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm text-uppercase px-4">Save Employee Group</button>
                </div>
            </form>
        </div>
    </div>
</div>