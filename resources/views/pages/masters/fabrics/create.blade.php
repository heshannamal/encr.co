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
    .image_table_header {
        background-color: gray;
        color: white;
        padding: 7px;
    }
    .uploadStyles{
        border: none;
        background-color: transparent;
        padding: .5rem;
        cursor: pointer;
    }
</style>

<div class="modal fade" id="fabric_create_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Add New Fabrics</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('fabrics.create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Fabric Name and Description Fields -->
                    <div class="col-md-12 mt-3 div_none1">
                        <label class="form-lable">Fabric Name <span class="text-danger">*</span></label><br>
                        <input type="text" class="form-control form-input" id="new_fabric_name" name="new_fabric_name" required />
                    </div>
                    <div class="col-md-12 mt-4">
                        <label class="form-label fw-bold">Fabric Colors</label>
                        <div id="AddfabricColorsWrapper" class="row g-2">
{{--
                            <!-- First color input -->
                            <div class="col-md-6 d-flex align-items-center fabric-color-group">
                                <input type="color" class="form-control form-control-color me-2 colorpick" name="add_fabric_colors[]" value="#000000" title="Choose color">
                                <input type="text" class="form-control me-2" name="add_fabric_color_names[]" placeholder="Color name (e.g., Black)">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-color">×</button>
                            </div> --}}

                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm mt-3" id="addColor">
                            + Add Color
                        </button>
                    </div>
                    <div class="col-md-12 mt-4">
                        <label class="form-label fw-bold">Embellishment Types</label>
                        <select id="embellishments" class="form-control" name="embellishments_select[]" multiple>
                            @foreach ($embellishmentTypes as $embellishmentType )
                                <option value="{{$embellishmentType->embellishment_name}}">{{$embellishmentType->embellishment_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- <div class="col-md-12 mt-3 div_none1">
                        <label class="form-label">Fabric Description <span class="text-danger"></span></label><br>
                        <textarea class="form-control form-input" id="new_description" name="new_description" rows="4"></textarea>
                    </div> --}}
                    <div class="col-md-12 mt-3 mb-1">
                        <label class="form-label">Fabric Description</label>

                        <!-- Quill Editor -->
                        <div id="new_description_editor" style="height: 150px; background-color: #fff;"></div>

                        <!-- Hidden Input to store HTML -->
                        <input type="hidden" id="new_description" name="new_description">
                    </div>

                    <!-- Fabric Images Upload -->
                    <div class="col-md-12 mt-3 div_none1">
                        <label class="form-label">Fabric Image <span class="text-danger">*</span></label><br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12 mt-3" style="padding: 0rem">
                                    <label for="fabric_images" id="fabric_images_upload_area" class="upload-area" style="height: 200px;">
                                        <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                        <div class="upload-icon">
                                            <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD IMAGE</i>
                                        </div>
                                        <p style="color: #b3b3b3;font-size: .8rem;margin-top: .5rem;">
                                            Drag & drop FABRIC images here or <span style="font-weight: 600">CLICK HERE</span> to upload FABRIC images
                                        </p>
                                    </label>
                                    <input type="file" id="fabric_images" class="file-select" accept="image/*" style="display: none;" multiple onchange="uploadMultipleImages('fabric_images')">
                                </div>
                            </div>

                            <!-- Uploaded Fabric Images Table -->
                            <div class="col-md-6">
                                <div class="row mt-2" id="uploaded_fabric_images_table">
                                    <div class="col-md-12 sub-header-style">Uploaded Fabric Images</div>
                                    <div class="col-md-12 mt-3 mb-2">
                                        <table class="subProductTable" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class="image_table_header">FILE NAME</th>
                                                    <th class="text-center image_table_header">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody id="fabric_images_tbody">
                                                <!-- Dynamically generated rows will go here -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hidden inputs container for the uploaded files -->
                <div id="hidden_inputs_container"></div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom" type="button" data-dismiss="modal" aria-label="Close">Cancel</button>
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

  <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    $(document).ready(function () {
        // Initialize Select2
        $('#embellishments, #embellishments1').select2({
            tags: true,
            placeholder: "Add embellishment types...",
            width: '100%',
            tokenSeparators: [',']
        });

        // Add fabric color input
        $('#addColor').on('click', function () {
            const group = $(`
                <div class="col-md-6 d-flex align-items-center fabric-color-group mb-2">
                    <input type="color" class="form-control form-control-color me-2 colorpick" name="add_fabric_colors[]" value="#000000" title="Choose color">
                    <input type="text" class="form-control me-2" name="add_fabric_color_names[]" placeholder="Color name (e.g., Red)">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-color">×</button>
                </div>
            `);
            $('#AddfabricColorsWrapper').append(group);
        });

        // Remove color input group
        $(document).on('click', '.remove-color', function () {
            $(this).closest('.fabric-color-group').remove();
        });

        let fabricImagesArray = [];

        // Handle file input change for image uploads
        $('#fabric_images').on('change', function () {
            const files = this.files;
            const $tbody = $('#fabric_images_tbody');
            const existingCount = $tbody.find('tr').length;
            const totalImages = existingCount + files.length;

            if (totalImages > 5) {
                alert("You can only upload a maximum of 5 images.");
                return;
            }

            const $hiddenContainer = $('#hidden_inputs_container');

            $.each(files, function (i, file) {
                const fileName = file.name;
                const truncateName = fileName.length > 30 ? fileName.slice(0, 30) + '...' : fileName;

                fabricImagesArray.push(file);

                // Add row to table
                $tbody.append(`
                    <tr>
                        <td>${truncateName}</td>
                        <td class="text-center">
                            <button class="uploadStyles view-img" type="button" data-index="${fabricImagesArray.length - 1}" title="View">
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
                    name: 'fabric_images[]',
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
            const file = fabricImagesArray[index];
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

            fabricImagesArray = fabricImagesArray.filter(f => f.name !== fileName);

            $('input[name="fabric_images[]"]').each(function () {
                if (this.files[0]?.name === fileName) {
                    $(this).remove();
                    return false;
                }
            });
        });

        // Initialize Quill editor
        const quill = new Quill('#new_description_editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    [{ 'align': [] }],
                    ['link'],
                    ['clean']
                ]
            }
        });

        quill.on('text-change', function () {
            $('#new_description').val(quill.root.innerHTML);
        });
    });
</script>



<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
