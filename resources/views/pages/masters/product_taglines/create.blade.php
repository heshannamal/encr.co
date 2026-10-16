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

<div class="modal fade" id="product_tagline_create_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Add Product Tagline</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('product_tagline.create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="">
                            <label class="form-label">Product Tagline Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-input" id="new_product_tagline" name="new_product_tagline" required />
                        </div>
                    </div>

                    <div class="col-md-12 mt-3 div_none1">
                        <label class="form-label">Product Tagline Description<span class="text-danger"></span></label><br>
                        <textarea class="form-control form-input" id="new_description" name="new_description" rows="4"></textarea>
                    </div>

                    <div class="col-md-12 mt-3 div_none1">
                        <label class="form-label">Product Tagline Reference Video</label> <label for="" style="color: red;">Maximum file size: 12MB (.mp4 format) with a resolution of 640x420</label><br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12 mt-3" style="padding: 0rem">
                                    <!-- Upload area -->
                                    <label for="tagline_video" id="tagline_video_upload_area" class="upload-area" style="height: 200px;">
                                        <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                        <div class="upload-icon">
                                            <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD VIDEO</i>
                                        </div>
                                        <p style="color: #b3b3b3;font-size: .8rem;margin-top: .5rem;">
                                            Drag & drop Product Tagline video here or <span style="font-weight: 600">CLICK HERE</span> to upload Product Tagline video
                                        </p>
                                    </label>
                                    <input type="file" id="tagline_video" name="tagline_video" class="file-select" accept="video/*" style="display: none;" onchange="previewVideo(event)">
                                </div>
                            </div>
                        </div>

                        <!-- Div to display video preview -->
                        <div id="video_preview_container" style="display:none; padding: 0rem">
                            <video id="video_preview" width="100%" height="200" controls></video>
                            <button type="button" onclick="removeVideo()" class="btn btn-danger mt-2">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
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

function previewVideo(event) {
        const videoInput = event.target;
        const file = videoInput.files[0];

        if (file) {
            // Validate file size (12MB = 12 * 1024 * 1024 bytes)
            if (file.size > 12 * 1024 * 1024) {
                alert('File size exceeds 12MB');
                removeVideo();
                return;
            }

            const videoURL = URL.createObjectURL(file);
            const videoPreview = document.getElementById('video_preview');
            videoPreview.src = videoURL;

            // Validate video resolution after it's loaded
            videoPreview.onloadedmetadata = function() {
                const videoWidth = videoPreview.videoWidth;
                const videoHeight = videoPreview.videoHeight;

                if (videoWidth !== 640 || videoHeight !== 420) {
                    alert('Video resolution must be exactly 640x420.');
                    removeVideo();
                    return;
                }

                // Show the video preview and hide the upload area
                document.getElementById('tagline_video_upload_area').style.display = 'none';
                document.getElementById('video_preview_container').style.display = 'block';
            };
        }
    }

    function removeVideo() {
        // Reset the file input
        const videoInput = document.getElementById('tagline_video');
        videoInput.value = '';

        // Hide the video preview and show the upload area again
        document.getElementById('video_preview_container').style.display = 'none';
        document.getElementById('tagline_video_upload_area').style.display = 'block';

        // Clear the video source
        const videoPreview = document.getElementById('video_preview');
        videoPreview.src = '';
    }

    function validateVideo() {
        const videoInput = document.getElementById('tagline_video');
        if (!videoInput.value) {
            alert('Please upload a video file.');
            return false;
        }
        return true; // Submit the form if validation passes
    }

</script>
