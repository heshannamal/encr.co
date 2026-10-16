<div class="modal fade" id="embellishment_type_edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Edit Embellishment Types</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('embellishment_types.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" value="" id="embellishment_type_id" name="embellishment_type_id" />
                    <input type="hidden" id="edit_embellishment_video_status" name="edit_embellishment_video_status" value="retain">

                    <div class="col-md-12">
                        <div class="row flex_set">
                            <div class="col-md-6 max_width01">
                                <div class="">
                                    <label class="form-label">Embellishment Types <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-input" id="edit_embellishment_types" name="edit_embellishment_types" required />
                                </div>
                            </div>
                            <div class="col-md-6 max_width01">
                                <div class="">
                                    <label class="form-label">Price ($)</label>
                                    <input type="number" class="form-control form-input" id="edit_embellishment_type_price" name="edit_embellishment_type_price" min="0" oninput="validity.valid||(value='');" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-md-12 mt-3 div_none1">
                        <label class="form-label">Embellishment Description <span class="text-danger"></span></label><br>
                        <textarea class="form-control form-input" id="edit_description" name="edit_description" rows="4"></textarea>
                    </div> --}}

                    <div class="col-md-12 mt-3 mb-1">
                        <label class="form-label">Embellishment Description</label>

                                                <!-- Quill Editor -->
                        <div id="edit_description_editor" style="height: 150px; background-color: #fff;"></div>

                        <!-- Hidden Input to store HTML -->
                        <input type="hidden" id="edit_description" name="edit_description">
                    </div>
                    <div class="col-md-12 mt-4">
                        <label class="form-label fw-bold">Compatible Fabrics</label>
                        <select id="edit_fabrics" class="form-control" name="fabrics_select[]" multiple>
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
                                    <label for="edit_embellishment_video" id="edit_embellishment_video_upload_area" class="upload-area" style="height: 200px;">
                                        <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                        <div class="upload-icon">
                                            <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD VIDEO</i>
                                        </div>
                                        <p style="color: #b3b3b3;font-size: .8rem;margin-top: .5rem;">
                                            Drag & drop EMBELLISHMENT video here or <span style="font-weight: 600">CLICK HERE</span> to upload EMBELLISHMENT video
                                        </p>
                                    </label>
                                    <input type="file" id="edit_embellishment_video" name="edit_embellishment_video" class="file-select" accept="video/*" style="display: none;" onchange="previewVideoEdit(event)">
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
                    </div> --}}
                    <div class="col-md-12 mt-3">
                        <label class="form-label">Embellishment Image <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12 mt-3 p-0">
                                    <label for="edit_Embellishment_images" id="edit_Embellishment_images_upload_area" class="upload-area" style="height: 200px;">
                                        <i class="fa fa-cloud-upload" style="font-size: 2rem; color:#b3b3b3"></i>
                                        <div class="upload-icon">
                                            <i class="fa fa-upload" style="font-size: .7rem; color: #b3b3b3;"> UPLOAD IMAGE</i>
                                        </div>
                                        <p style="color: #b3b3b3; font-size: .8rem; margin-top: .5rem;">
                                            Drag & drop Embellishment images here or <span style="font-weight: 600">CLICK HERE</span> to upload Embellishment images
                                        </p>
                                    </label>
                                    <input type="file" id="edit_Embellishment_images" class="file-select" accept="image/*" multiple style="display: none;" onchange="editUploadMultipleImages('edit_Embellishment_images')">
                                </div>
                                <div id="existing_images_container" style="display: none;"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mt-2" id="uploaded_Embellishment_images_table">
                                    <div class="col-md-12 sub-header-style">Uploaded Embellishment Images</div>
                                    <div class="col-md-12 mt-3 mb-2">
                                        <table class="subProductTable w-100">
                                            <thead>
                                                <tr>
                                                    <th class="image_table_header">FILE NAME</th>
                                                    <th class="text-center image_table_header">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody id="Embellishment_images_tbody_edit"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom" type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        @if (Gate::check('delete embellishment_types'))
                        <button type="button" class="btn btn-danger btn-custom delete">Delete</button>
                        @endif
                        @if (Gate::check('edit embellishment_types'))
                        <button type="submit" class="btn btn-success btn-custom">Save</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="edit_image_view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Image Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="" alt="Fabric Image" style="width: 100%;" />
            </div>
        </div>
    </div>
</div>

<script>
    let existingImageCount = 0;
    $('#edit_fabrics').select2({
            tags: true,
            placeholder: "Add fabrics ...",
            width: '100%',
            tokenSeparators: [',']
        });
    $('#embellishment_type_edit_modal').on('shown.bs.modal', function (e) {
        var embellishmentTypeId = $('#embellishment_type_id').val();

        $.ajax({
            url: '{{url("embellishment_types/edit")}}/' + embellishmentTypeId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#existing_images_container').empty().hide();
                $('#Embellishment_images_tbody_edit').empty();
                // Populate form fields with the retrieved data
                $('#edit_embellishment_types').val(data.embellishment_name);
                $('#edit_embellishment_type_price').val(data.price);
                $('#edit_description').val(data.description);
                if (quillEditDescription) {
                    quillEditDescription.root.innerHTML = data.description;
                }
                const fabrics = data.fabrics ? JSON.parse(data.fabrics) : [];
                const $fabricSelect = $('#edit_fabrics');

                $fabricSelect.val(null).trigger('change');
                const existingOptions = new Set();
                $fabricSelect.find('option').each(function () {
                    existingOptions.add($(this).val());
                });
                if ((fabrics != null)) {

                    fabrics.forEach(item => {
                        if (!existingOptions.has(item)) {
                            const option = new Option(item, item, true, true);
                            $fabricSelect.append(option);
                        } else {
                            $fabricSelect.find(`option[value="${item}"]`).prop('selected', true);
                        }
                    });
                }
                $fabricSelect.trigger('change');
                // Check if there's a video path
                if (data.video_path) {
                    // Hide the upload area and show the video preview
                    $('#edit_embellishment_video_upload_area').hide();
                    $('#edit_video_preview_container').show();

                    // Use the raw video path without encoding spaces
                    var videoURL = '{{ url("/") }}' + '/' + data.video_path;

                    console.log('Generated Video URL: ', videoURL); // Log the URL to confirm

                    // Set the video preview source and load it
                    $('#edit_video_preview').attr('src', videoURL);
                    $('#edit_video_preview')[0].load();
                } else {
                    // No video found, reset and show the upload area
                    $('#edit_embellishment_video_upload_area').show();
                    $('#edit_video_preview_container').hide();
                }
                $('#Embellishment_images_tbody_edit, #existing_images_container').empty();
                var images = [data.image_1,data.image_2,data.image_3,data.image_4];
                    existingImageCount = images.length;
                    images.forEach(image => {
                        if (image) {
                            const fileName = image.split('/').pop();
                            const truncatedFileName = fileName.length > 30 ? fileName.substring(0, 30) + '...' : fileName;

                            const newHiddenInput = `<input type="hidden" name="existing_images[]" value="${image}" />`;
                            $('#existing_images_container').append(newHiddenInput);

                            const newRowHTML = `
                                <tr>
                                    <td>${truncatedFileName}</td>
                                    <td class="text-center">
                                        <button class="uploadStyles" type="button" title="View" onclick="viewImage('${image}')">
                                            <i class="fa fa-eye" style="color: grey;"></i>
                                        </button>
                                        <button onclick="deleteImage(this, '${image}')" class="uploadStyles" type="button" title="Delete">
                                            <i class="fa fa-trash" style="color: #e19191;"></i>
                                        </button>
                                    </td>
                                </tr>`;

                            $('#Embellishment_images_tbody_edit').append(newRowHTML);
                        }
                    });
            },
            error: function(xhr, status, error) {
                console.error("Error fetching embellishment type: ", status, error);
            }
        });
    });

window.editUploadMultipleImages = function (inputId) {
            const input = document.getElementById(inputId);
            const files = input.files;
            const newFilesCount = files.length;
            const tbody = $('#Embellishment_images_tbody_edit');
            const existingRows = tbody.find('tr').length;
            const totalImages = existingRows + newFilesCount;
            const availableSlots = 5 - existingImageCount;

            if (totalImages > 5) {
                alert('You can only upload a maximum of 5 more images.');
                return;
            }

            for (let i = 0; i < newFilesCount; i++) {
                const file = files[i];
                const truncatedName = file.name.length > 30 ? file.name.substring(0, 30) + '...' : file.name;

                const newRowHTML = `
                    <tr>
                        <td>${truncatedName}</td>
                        <td class="text-center">
                            <button class="uploadStyles" type="button" title="View" onclick="viewImage('${URL.createObjectURL(file)}')">
                                <i class="fa fa-eye" style="color: grey;"></i>
                            </button>
                            <button onclick="deleteImage(this, '${file.name}')" class="uploadStyles" type="button" title="Delete">
                                <i class="fa fa-trash" style="color: #e19191;"></i>
                            </button>
                        </td>
                    </tr>`;

                tbody.append(newRowHTML);

                const newInput = $('<input>', {
                    type: 'file',
                    name: 'edit_Embellishment_images[]',
                    style: 'display: none'
                });
                $('#existing_images_container').append(newInput);

                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                newInput[0].files = dataTransfer.files;
            }

            existingImageCount += newFilesCount;
        };

        window.viewImage = function (imagePath) {
            $('#edit_image_view_modal img').attr('src', imagePath);
            $('#edit_image_view_modal').modal('show');
        };

        window.deleteImage = function (button, imageName) {
            const $row = $(button).closest('tr');
            $row.remove();

            $(`input[name="existing_images[]"][value="${imageName}"]`).remove();
            existingImageCount--;
        };
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
                $('#edit_embellishment_video_upload_area').hide();
                $('#edit_video_preview_container').show();

                // Update hidden field to indicate a new video is uploaded
                $('#edit_embellishment_video_status').val('new');
            };
        }
    }

    function removeVideoEdit() {
        // Reset the file input
        const videoInput = $('#edit_embellishment_video');
        videoInput.val('');

        // Hide the video preview and show the upload area again
        $('#edit_video_preview_container').hide();
        $('#edit_embellishment_video_upload_area').show();

        // Clear the video source
        $('#edit_video_preview').attr('src', '');

        // Update hidden field to indicate the video should be removed
        $('#edit_embellishment_video_status').val('remove');
    }

    function validateVideoEdit() {
        const videoInput = document.getElementById('edit_embellishment_video');
        if (!videoInput.value) {
            alert('Please upload a video file.');
            return false;
        }
        return true; // Submit the form if validation passes
    }

    $(".delete").on("click", function(){
        var embellishmentTypeId = $('#embellishment_type_id').val();
        window.location.replace("../../embellishment_types/delete/"+embellishmentTypeId);
    });

    $('#edit_embellishment_type_price').focus(function(){
        $('#edit_embellishment_type_price').select();
    });
</script>


<script>
    let quillEditDescription;

    document.addEventListener("DOMContentLoaded", function () {
        quillEditDescription = new Quill('#edit_description_editor', {
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
        quillEditDescription.on('text-change', function () {
            document.getElementById('edit_description').value = quillEditDescription.root.innerHTML;
        });
    });

</script>


<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
