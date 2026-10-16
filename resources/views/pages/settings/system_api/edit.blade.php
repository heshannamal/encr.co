<div class="modal fade" id="EditAPIModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit API</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editAPIForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="function_name">API Name</label>
                            <input type="text" class="form-control" name="name" id="edit_name" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="function_name">API Type Key</label>
                            <input type="text" class="form-control" name="api_type_key" id="edit_api_type_key" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="function_name">API Token</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="api_token" id="edit_api_token" required>
                                <div class="input-group-append">
                                    <button class="btn-green-generate generate-api-token" type="button" data-for="edit_api_token">Generate</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="controller">Description</label>
                            <input type="text" class="form-control" name="description" id="edit_description">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="edit_status">Status</label>
                            <select name="is_active" id="edit_status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Update API</button>
                </div>
            </form>
        </div>
    </div>
</div>
