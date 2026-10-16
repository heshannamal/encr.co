<div class="modal fade" id="master_fit_edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Edit Master Fit</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('master_fit.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" value="" id="master_fit_id" name="master_fit_id" />
                    {{-- <input type="hidden" id="edit_product_tagline_video_status" name="edit_product_tagline_video_status" value="retain"> --}}

                    <div class="col-md-12">
                        <div class="">
                            <label class="form-label">Master Fit Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-input" id="edit_master_fit" name="edit_master_fit" required />
                        </div>
                    </div>

                    <div class="col-md-12 mt-3 div_none1">
                        <label class="form-label">Master Fit Description<span class="text-danger"></span></label><br>
                        <textarea class="form-control form-input" id="edit_description" name="edit_description" rows="4"></textarea>
                    </div>

                </div>

                <div class="card-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom" type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        @if (Gate::check('delete master_fit_types'))
                        <button type="button" class="btn btn-danger btn-custom delete">Delete</button>
                        @endif
                        @if (Gate::check('edit master_fit_types'))
                        <button type="submit" class="btn btn-success btn-custom">Save</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script>

$('#master_fit_edit_modal').on('shown.bs.modal', function (e) {
    var masterFitId = $('#master_fit_id').val();
    // console.log("Product Tagline ID:", masterFitId);

    $.ajax({
        url: '{{ route("master_fit.edit", ":id") }}'.replace(':id', masterFitId),
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            // console.log("Data retrieved:", data);

            $('#edit_master_fit').val(data.fit_name);
            $('#edit_description').val(data.description);
        },
        error: function(xhr, status, error) {
            console.error("Error fetching product tagline: ", status, error);
        }
    });
});

    $(".delete").on("click", function() {
        var masterFitId = $('#master_fit_id').val();

        $.ajax({
            url: "{{ route('master_fit.delete') }}",
            type: "GET",
            data: { id: masterFitId },
            success: function(response) {
                    location.reload();

            },
            error: function(xhr) {
                // Handle any errors here
                alert("An error occurred: " + xhr.responseText);
            }
        });
    });


</script>
