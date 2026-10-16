<div class="modal fade" id="sizeType_edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Edit Factories</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('sizeType.update') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row">
                            <input type="hidden" value="" id="sizeType_id" name="sizeType_id" />

                            <div class="col-md-12 form-field div_none1 flex-none">
                                <label class="form-lable">Size Type: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-input" id="edit_sizeType_name" name="edit_sizeType_name" required />
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom"  type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        @if (Gate::check('delete size types'))
                        <button type="button" class="btn btn-danger btn-custom delete">Delete</button>
                        @endif
                        @if (Gate::check('edit size types'))
                        <button type="submit" class="btn btn-success btn-custom">Save</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#sizeType_edit_modal').on('shown.bs.modal', function (e) {
        var sizeTypeId = $('#sizeType_id').val();

        $.ajax({
            url: '{{url("sizeType/edit")}}/'+sizeTypeId,
            type: 'GET',
            dataType: 'json',
            success: function(data){
                $('#edit_sizeType_name').val(data.type_name);
            }
        });
    })

    $(".delete").on("click", function(){
        var sizeTypeId = $('#sizeType_id').val();
        var deleteUrl = "{{ route('sizeType.delete', ['id' => ':id']) }}";
        deleteUrl = deleteUrl.replace(':id', sizeTypeId);
        window.location.replace(deleteUrl);

    });
</script>
