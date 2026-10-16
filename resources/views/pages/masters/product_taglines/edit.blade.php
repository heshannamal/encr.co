<div class="modal fade" id="product_tagline_edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Edit Product Tagline</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('product_tagline.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" value="" id="product_tagline_id" name="product_tagline_id" />
                    <input type="hidden" id="edit_product_tagline_video_status" name="edit_product_tagline_video_status" value="retain">

                    <div class="col-md-12">
                        <div class="">
                            <label class="form-label">Product Tagline Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-input" id="edit_product_tagline" name="edit_product_tagline" required />
                        </div>
                    </div>

                    <div class="col-md-12 mt-3 div_none1">
                        <label class="form-label">Product Tagline Description<span class="text-danger"></span></label><br>
                        <textarea class="form-control form-input" id="edit_description" name="edit_description" rows="4"></textarea>
                    </div>

                    <div class="col-md-12 mt-3 div_none1">
                        <label class="form-label">Product Tagline Reference Video</label> <label for="" style="color: red;">Maximum file size: 12MB (.mp4 format) with a resolution of 640x420</label><br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12 mt-3" style="padding: 0rem">
                                    <!-- Upload area -->
                                    <label for="edit_product_tagline_video" id="edit_product_tagline_video_upload_area" class="upload-area" style="height: 200px;">
                                        <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                        <div class="upload-icon">
                                            <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD VIDEO</i>
                                        </div>
                                        <p style="color: #b3b3b3;font-size: .8rem;margin-top: .5rem;">
                                            Drag & drop Product Tagline video here or <span style="font-weight: 600">CLICK HERE</span> to upload Product Tagline video
                                        </p>
                                    </label>
                                    <input type="file" id="edit_product_tagline_video" name="edit_product_tagline_video" class="file-select" accept="video/*" style="display: none;" onchange="previewVideoEdit(event)">
                                </div>
                            </div>
                        </div>

                        <!-- Div to display video preview -->
                        <div id="edit_video_preview_container" style="display:none; padding: 0rem">
                            <video id="edit_video_preview" width="100%" height="200" controls></video>
                            <button type="button" onclick="removeVideoEdit()" class="btn btn-danger mt-2">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom" type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        @if (Gate::check('delete product_tagline_types'))
                        <button type="button" class="btn btn-danger btn-custom delete">Delete</button>
                        @endif
                        @if (Gate::check('edit product_tagline_types'))
                        <button type="submit" class="btn btn-success btn-custom">Save</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script>

$('#product_tagline_edit_modal').on('shown.bs.modal', function (e) {
    var productTaglineId = $('#product_tagline_id').val();
    console.log("Product Tagline ID:", productTaglineId);

    $.ajax({
        url: '{{ route("product_tagline.edit", ":id") }}'.replace(':id', productTaglineId),
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log("Data retrieved:", data);

            if (data) {
                $('#edit_product_tagline').val(data.tagline_name);
                $('#edit_description').val(data.description);

                if (data.video_path) {
                    $('#edit_product_tagline_video_upload_area').hide();
                    $('#edit_video_preview_container').show();

                    var videoURL = '{{ url("/") }}' + '/' + data.video_path;

                    console.log('Generated Video URL: ', videoURL);

                    $('#edit_video_preview').attr('src', videoURL);
                    $('#edit_video_preview')[0].load();
                } else {
                    $('#edit_product_tagline_video_upload_area').show();
                    $('#edit_video_preview_container').hide();
                }
            }
        },
        error: function(xhr, status, error) {
            console.error("Error fetching product tagline: ", status, error);
        }
    });
});

function previewVideoEdit(event) {
        const videoInput = event.target;
        const file = videoInput.files[0];
        if (file) {
            // Validate file size (12MB = 12 * 1024 * 1024 bytes)
            if (file.size > 12 * 1024 * 1024) {
                alert('File size exceeds 12MB');
                removeVideoEdit();
                return;
            }

            const videoURL = URL.createObjectURL(file); // Create a URL for the video file
            const videoPreview = document.getElementById('edit_video_preview');
            videoPreview.src = videoURL;

            // Validate video resolution after it's loaded
            videoPreview.onloadedmetadata = function() {
                const videoWidth = videoPreview.videoWidth;
                const videoHeight = videoPreview.videoHeight;

                if (videoWidth !== 640 || videoHeight !== 420) {
                    alert('Video resolution must be exactly 640x420.');
                    removeVideoEdit();
                    return;
                }

                // Show the video preview and hide the upload area
                $('#edit_product_tagline_video_upload_area').hide();
                $('#edit_video_preview_container').show();

                // Update hidden field to indicate a new video is uploaded
                $('#edit_product_tagline_video_status').val('new');
            };
        }
    }

    function removeVideoEdit() {
        // Reset the file input
        const videoInput = $('#edit_product_tagline_video');
        videoInput.val('');

        // Hide the video preview and show the upload area again
        $('#edit_video_preview_container').hide();
        $('#edit_product_tagline_video_upload_area').show();

        // Clear the video source
        $('#edit_video_preview').attr('src', '');

        // Update hidden field to indicate the video should be removed
        $('#edit_product_tagline_video_status').val('remove');
    }

    function validateVideoEdit() {
        const videoInput = document.getElementById('edit_product_tagline_video');
        if (!videoInput.value) {
            alert('Please upload a video file.');
            return false;
        }
        return true; // Submit the form if validation passes
    }

    $(".delete").on("click", function() {
        var productTaglineId = $('#product_tagline_id').val();

        $.ajax({
            url: "{{ route('product_tagline.delete') }}",
            type: "GET",
            data: { id: productTaglineId },
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
