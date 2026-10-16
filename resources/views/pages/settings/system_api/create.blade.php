<div class="modal fade" id="AddAPIModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New API</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('system_api.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="function_name">API Name</label>
                            <input type="text" class="form-control" name="name" id="add_name" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="function_name">API Type Key</label>
                            <input type="text" class="form-control" name="api_type_key" id="add_api_type_key" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="function_name">API Token</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="api_token" id="add_api_token" required>
                                <div class="input-group-append">
                                    <button class="btn-green-generate generate-api-token" type="button" data-for="add_api_token">Generate</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="controller">Description</label>
                            <input type="text" class="form-control" name="description" id="add_description" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create API</button>
                </div>
            </form>
        </div>
    </div>
</div>
