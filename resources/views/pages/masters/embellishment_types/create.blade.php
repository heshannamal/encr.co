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

<div class="modal fade" id="embellishment_type_create_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Add New Embellishment Types</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('embellishment_types.create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row flex_set">
                            <div class="col-md-6 max_width01">
                                <div class="">
                                    <label class="form-label">Embellishment Types <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-input" id="new_embellishment_types" name="new_embellishment_types" required />
                                </div>
                            </div>
                            <div class="col-md-6 max_width01">
                                <div class="">
                                    <label class="form-label">Price ($)</label>
                                    <input type="number" class="form-control form-input" id="new_embellishment_type_price" name="new_embellishment_type_price" min="0" oninput="validity.valid||(value='');" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-md-12 mt-3 div_none1">
                        <label class="form-label">Embellishment Description <span class="text-danger"></span></label><br>
                        <textarea class="form-control form-input" id="new_description" name="new_description" rows="4"></textarea>
                    </div> --}}
                    <div class="col-md-12 mt-3 mb-1">
                        <label class="form-label">Embellishment Description</label>

                        <!-- Quill Editor -->
                        <div id="new_description_editor" style="height: 150px; background-color: #fff;"></div>

                        <!-- Hidden Input to store HTML -->
                        <input type="hidden" id="new_description" name="new_description">
                    </div>
                    <div class="col-md-12 mt-4">
                        <label class="form-label fw-bold">Compatible Fabrics</label>
                        <select id="fabrics" class="form-control" name="fabrics_select[]" multiple>
                            @foreach ($fabrics as $fabric )
                                <option value="{{$fabric->fabric_name}}">{{$fabric->fabric_name}}</option>
                            @endforeach
                        </select>
                    </div>


                    {{-- <div class="col-md-12 mt-3 div_none1">
                        <label class="form-label">Embellishment Reference Video</label> <label for="" style="color: red;">Maximum file size: 12MB (.mp4 format) with a resolution of 640x420</label><br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12 mt-3" style="padding: 0rem">
                                    <!-- Upload area -->
                                    <label for="embellishment_video" id="embellishment_video_upload_area" class="upload-area" style="height: 200px;">
                                        <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                        <div class="upload-icon">
                                            <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD VIDEO</i>
                                        </div>
                                        <p style="color: #b3b3b3;font-size: .8rem;margin-top: .5rem;">
                                            Drag & drop EMBELLISHMENT video here or <span style="font-weight: 600">CLICK HERE</span> to upload EMBELLISHMENT video
                                        </p>
                                    </label>
                                    <input type="file" id="embellishment_video" name="embellishment_video" class="file-select" accept="video/*" style="display: none;" onchange="previewVideo(event)">
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
                    </div> --}}
                    <div class="col-md-12 mt-3 div_none1">
                        <label class="form-label">Embellishment Image <span class="text-danger">*</span></label><br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12 mt-3" style="padding: 0rem">
                                    <label for="Embellishment_images" id="Embellishment_images_upload_area" class="upload-area" style="height: 200px;">
                                        <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                        <div class="upload-icon">
                                            <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD IMAGE</i>
                                        </div>
                                        <p style="color: #b3b3b3;font-size: .8rem;margin-top: .5rem;">
                                            Drag & drop Embellishment images here or <span style="font-weight: 600">CLICK HERE</span> to upload Embellishment images
                                        </p>
                                    </label>
                                    <input type="file" id="Embellishment_images" class="file-select" accept="image/*" style="display: none;" multiple onchange="uploadMultipleImages('Embellishment_images')">
                                </div>
                            </div>

                            <!-- Uploaded Embellishment Images Table -->
                            <div class="col-md-6">
                                <div class="row mt-2" id="uploaded_Embellishment_images_table">
                                    <div class="col-md-12 sub-header-style">Uploaded Embellishment Images</div>
                                    <div class="col-md-12 mt-3 mb-2">
                                        <table class="subProductTable" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class="image_table_header">FILE NAME</th>
                                                    <th class="text-center image_table_header">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody id="Embellishment_images_tbody">
                                                <!-- Dynamically generated rows will go here -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <div id="hidden_inputs_container"></div>
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
<!-- Modal for image preview -->
<div class="modal fade" id="image_view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Image Preview</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <img src="" alt="Fabric Image" style="width: 100%;"/>
        </div>
      </div>
    </div>
  </div>

<script>
    // Initialize Select2
        $('#fabrics').select2({
            tags: true,
            placeholder: "Add fabrics ...",
            width: '100%',
            tokenSeparators: [',']
        });
    let EmbellishmentImagesArray = [];
    $('#Embellishment_images').on('change', function () {
            const files = this.files;
            const $tbody = $('#Embellishment_images_tbody');
            const existingCount = $tbody.find('tr').length;
            const totalImages = existingCount + files.length;

            if (totalImages > 4) {
                alert("You can only upload a maximum of 4 images.");
                return;
            }

            const $hiddenContainer = $('#hidden_inputs_container');

            $.each(files, function (i, file) {
                const fileName = file.name;
                const truncateName = fileName.length > 30 ? fileName.slice(0, 30) + '...' : fileName;

                EmbellishmentImagesArray.push(file);

                // Add row to table
                $tbody.append(`
                    <tr>
                        <td>${truncateName}</td>
                        <td class="text-center">
                            <button class="uploadStyles view-img" type="button" data-index="${EmbellishmentImagesArray.length - 1}" title="View">
                                <i class="fa fa-eye" style="color: grey;"></i>
                            </button>
                            <button class="uploadStyles delete-img" type="button" data-name="${fileName}" title="Delete">
                                <i class="fa fa-trash" style="color: #e19191;"></i>
                            </button>
                        </td>
                    </tr>
                `);

                // Create hidden input for file
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);

                const $hiddenInput = $('<input>', {
                    type: 'file',
                    name: 'Embellishment_images[]',
                    style: 'display: none'
                });

                $hiddenInput[0].files = dataTransfer.files;
                $hiddenContainer.append($hiddenInput);
            });

            // Reset file input
            $(this).val('');
        });
         // Preview image
        $(document).on('click', '.view-img', function () {
            const index = $(this).data('index');
            const file = EmbellishmentImagesArray[index];
            const reader = new FileReader();

            reader.onload = function (e) {
                $('#image_view_modal img').attr('src', e.target.result);
                $('#image_view_modal').modal('show');
            };
            reader.readAsDataURL(file);
        });

        // Delete image row and associated hidden input
        $(document).on('click', '.delete-img', function () {
            const fileName = $(this).data('name');
            $(this).closest('tr').remove();

            EmbellishmentImagesArray = EmbellishmentImagesArray.filter(f => f.name !== fileName);

            $('input[name="Embellishment_images[]"]').each(function () {
                if (this.files[0]?.name === fileName) {
                    $(this).remove();
                    return false;
                }
            });
        });
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
                document.getElementById('embellishment_video_upload_area').style.display = 'none';
                document.getElementById('video_preview_container').style.display = 'block';
            };
        }
    }

    function removeVideo() {
        // Reset the file input
        const videoInput = document.getElementById('embellishment_video');
        videoInput.value = '';

        // Hide the video preview and show the upload area again
        document.getElementById('video_preview_container').style.display = 'none';
        document.getElementById('embellishment_video_upload_area').style.display = 'block';

        // Clear the video source
        const videoPreview = document.getElementById('video_preview');
        videoPreview.src = '';
    }

    function validateVideo() {
        const videoInput = document.getElementById('embellishment_video');
        if (!videoInput.value) {
            alert('Please upload a video file.');
            return false;
        }
        return true; // Submit the form if validation passes
    }
</script>

<script>
    let quillNewEditNewDescription;

    document.addEventListener("DOMContentLoaded", function () {
        quillNewDescription = new Quill('#new_description_editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    [{ 'align': [] }],
                    ['link'],
                    ['clean']
                ]
            }
        });

        // Keep hidden input in sync with Quill content
        quillNewDescription.on('text-change', function () {
            document.getElementById('new_description').value = quillNewDescription.root.innerHTML;
        });
    });

</script>


<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
