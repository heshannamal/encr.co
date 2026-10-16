<style>
    .upload-area {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 95px;
        border: 2px dashed #ccc;
        text-align: center;
        padding: 10px;
        cursor: pointer;
    }

    .upload-area:hover {
        border-color: #007bff;
        cursor: pointer;
    }
</style>

<div class="modal fade" id="fit_create_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Add Master Fit</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('fit.create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="">
                            <label class="form-label">Master Fit Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-input" id="new_product_fit" name="new_product_fit" required />
                        </div>
                    </div>

                    <div class="col-md-12 mt-3 div_none1">
                        <label class="form-label">Master Fit Description<span class="text-danger"></span></label><br>
                        <textarea class="form-control form-input" id="new_description" name="new_description" rows="4"></textarea>
                    </div>


                </div>


                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom" type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="submit" class="btn btn-success btn-custom">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>


</script>
