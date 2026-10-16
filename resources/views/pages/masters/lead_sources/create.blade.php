<div class="modal fade" id="lead_source_create_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Add New Lead Source</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('lead_sources.create')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12 form-field mt-3 div_none1">
                        <label class="form-lable">Lead Source Name: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-input" id="lead_source_name" name="lead_source_name" required />
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
