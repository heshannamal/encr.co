<div class="modal fade" id="size_create_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Add New Size</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('sizes.create')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row flex_set">
                            <div class="col-md-6 form-field max_width01 div_none1">
                                <label class="form-lable">Size Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-input" id="new_size_name" name="new_size_name" required />
                            </div>

                            <div class="col-md-6 form-field max_width01 div_none1">
                                <label class="form-lable">Size Type <span class="text-danger">*</span></label>
                                <select class="form-control form-input" id="new_size_type" name="new_size_type" required>
                                    <option value="">Select a Size Type</option>
                                    @foreach ($sizeTypes as $sizeType)
                                        <option value="{{ $sizeType->id }}">{{ $sizeType->type_name }}</option>
                                    @endforeach
                                </select>
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
