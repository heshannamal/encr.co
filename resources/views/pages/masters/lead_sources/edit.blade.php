
<div class="modal fade" id="lead_source_edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Edit Lead Sources</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('lead_sources.update') }}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" value="" id="lead_source_id" name="lead_source_id" />

                    <div class="col-md-12 form-field div_none1">
                        <label class="form-lable">Lead Source Name: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-input" value=""  id="edit_lead_source_name" name="edit_lead_source_name" required />
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button  class="btn btn-secondary btn-custom"  type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="button" class="btn btn-danger btn-custom delete">Delete</button>
                        <button type="submit" class="btn btn-success btn-custom">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#lead_source_edit_modal').on('shown.bs.modal', function (e) {
        var lead_sourceId = $('#lead_source_id').val();

        $.ajax({
            url: '{{url("lead_sources/edit")}}/'+lead_sourceId,
            type: 'GET',
            dataType: 'json',
            success: function(data){
                $('#edit_lead_source_name').val(data.lead_source_name);
            }
        });
    });

    $(".delete").on("click", function(){
        var lead_sourceId = $('#lead_source_id').val();
        var deleteUrl = "{{ route('lead_sources.delete', ':id') }}";
        deleteUrl = deleteUrl.replace(':id', lead_sourceId);
        window.location.replace(deleteUrl);
    });
</script>
