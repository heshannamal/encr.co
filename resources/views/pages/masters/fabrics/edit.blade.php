
<style>
    .uploadStyles{
        border: none;
        background-color: transparent;
        padding: .5rem;
        cursor: pointer;
    }
</style>

<div class="modal fade" id="fabric_edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Edit Fabrics</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('fabrics.update') }}" method="POST" id="fabric_edit_form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="fabric_id" name="fabric_id" />

                    <div class="col-md-12 mt-3">
                        <label class="form-label">Fabric Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_fabric_name" name="edit_fabric_name" required />
                    </div>

                    <div class="col-md-12 mt-4">
                        <label class="form-label fw-bold">Fabric Colors</label>
                        <div id="fabricColorsWrapper" class="row g-2">
                            {{-- <div class="col-md-6 d-flex align-items-center fabric-color-group">
                                <input type="color" class="form-control form-control-color me-2 colorpick" name="fabric_colors[]" value="#000000" title="Choose color">
                                <input type="text" class="form-control me-2" name="fabric_color_names[]" placeholder="Color name (e.g., Black)">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-color">&times;</button>
                            </div> --}}
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm mt-3" id="addColor2">+ Add Color</button>
                    </div>

                    <div class="col-md-12 mt-4">
                        <label class="form-label fw-bold">Embellishment Types</label>
                        <select id="embellishments1" class="form-control" name="embellishments_select[]" multiple>
                            @foreach ($embellishmentTypes as $embellishmentType)
                                <option value="{{ $embellishmentType->embellishment_name }}">{{ $embellishmentType->embellishment_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 mt-3 mb-1">
                        <label class="form-label">Fabric Description</label>
                        <div id="edit_description_editor" style="height: 150px; background-color: #fff;"></div>
                        <input type="hidden" id="edit_description" name="edit_description">
                    </div>

                    <div class="col-md-12 mt-3">
                        <label class="form-label">Fabric Image <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12 mt-3 p-0">
                                    <label for="edit_fabric_images" id="edit_fabric_images_upload_area" class="upload-area" style="height: 200px;">
                                        <i class="fa fa-cloud-upload" style="font-size: 2rem; color:#b3b3b3"></i>
                                        <div class="upload-icon">
                                            <i class="fa fa-upload" style="font-size: .7rem; color: #b3b3b3;"> UPLOAD IMAGE</i>
                                        </div>
                                        <p style="color: #b3b3b3; font-size: .8rem; margin-top: .5rem;">
                                            Drag & drop FABRIC images here or <span style="font-weight: 600">CLICK HERE</span> to upload FABRIC images
                                        </p>
                                    </label>
                                    <input type="file" id="edit_fabric_images" class="file-select" accept="image/*" multiple style="display: none;" onchange="editUploadMultipleImages('edit_fabric_images')">
                                </div>
                                <div id="existing_images_container" style="display: none;"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mt-2" id="uploaded_fabric_images_table">
                                    <div class="col-md-12 sub-header-style">Uploaded Fabric Images</div>
                                    <div class="col-md-12 mt-3 mb-2">
                                        <table class="subProductTable w-100">
                                            <thead>
                                                <tr>
                                                    <th class="image_table_header">FILE NAME</th>
                                                    <th class="text-center image_table_header">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody id="fabric_images_tbody_edit"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom" type="button" data-dismiss="modal">Cancel</button>
                        @can('delete fabrics')
                            <button type="button" class="btn btn-danger btn-custom delete">Delete</button>
                        @endcan
                        @canany(['edit fabrics', 'edit fabric description'])
                            <button type="submit" class="btn btn-success btn-custom">Update</button>
                        @endcanany
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


<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
    $(document).ready(function () {
        let quillEditDescription;

        quillEditDescription = new Quill('#edit_description_editor', {
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

        quillEditDescription.on('text-change', function () {
            $('#edit_description').val(quillEditDescription.root.innerHTML);
        });

        let existingImageCount = 0;

        $('#addColor2').on('click', function () {
            const group = $('<div class="col-md-6 d-flex align-items-center fabric-color-group mb-2">').html(`
                <input type="color" class="form-control form-control-color me-2 colorpick" name="fabric_colors[]" value="#000000" title="Choose color">
                <input type="text" class="form-control me-2" name="fabric_color_names[]" placeholder="Color name (e.g., Red)">
                <button type="button" class="btn btn-outline-danger btn-sm remove-color">×</button>
            `);
            $('#fabricColorsWrapper').append(group);
        });

        $(document).on('click', '.remove-color', function () {
            $(this).closest('.fabric-color-group').remove();
        });

        $('#fabric_edit_modal').on('shown.bs.modal', function () {
            const fabricId = $('#fabric_id').val();

            $.ajax({
                url: '{{url("fabrics/edit")}}/' + fabricId,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#edit_fabric_name').val(data.fabric_name);
                    $('#edit_description').val(data.description);
                    $('#fabricColorsWrapper').empty();

                    if (data.colors && data.colors.length > 0) {
                        data.colors.forEach(color => {
                            const colorGroup = `<div class="col-md-6 mb-2 d-flex align-items-center">
                                <input type="color" name="fabric_colors[]" class="form-control form-control-color me-2 colorpick" value="${color.code}" required />
                                <input type="text" name="fabric_color_names[]" class="form-control" value="${color.name}" placeholder="Color Name" required />
                            </div>`;
                            $('#fabricColorsWrapper').append(colorGroup);
                        });
                    }

                    const embellishments = data.embellishmentTypes || [];
                    const $embellishmentSelect = $('#embellishments1');

                    $embellishmentSelect.val(null).trigger('change');
                    const existingOptions = new Set();
                    $embellishmentSelect.find('option').each(function () {
                        existingOptions.add($(this).val());
                    });

                    embellishments.forEach(item => {
                        if (!existingOptions.has(item)) {
                            const option = new Option(item, item, true, true);
                            $embellishmentSelect.append(option);
                        } else {
                            $embellishmentSelect.find(`option[value="${item}"]`).prop('selected', true);
                        }
                    });
                    $embellishmentSelect.trigger('change');

                    if (quillEditDescription) {
                        quillEditDescription.root.innerHTML = data.description;
                    }

                    $('#fabric_images_tbody_edit, #existing_images_container').empty();
                    existingImageCount = data.images.length;

                    data.images.forEach(image => {
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

                            $('#fabric_images_tbody_edit').append(newRowHTML);
                        }
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("Error fetching fabric data:", textStatus, errorThrown);
                }
            });
        });

        window.editUploadMultipleImages = function (inputId) {
            const input = document.getElementById(inputId);
            const files = input.files;
            const newFilesCount = files.length;
            const tbody = $('#fabric_images_tbody_edit');
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
                    name: 'edit_fabric_images[]',
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

        $('.delete').on('click', function () {
            const fabricId = $('#fabric_id').val();
            window.location.replace('../../fabrics/delete/' + fabricId);
        });

        $('#fabric_edit_modal').on('hidden.bs.modal', function () {
            $('#edit_fabric_name').val('');

            if (typeof quillEditDescription !== 'undefined') {
                quillEditDescription.setContents([]);
                $('#edit_description').val('');
            }

            $('#fabricColorsWrapper').empty().append();

            $('#embellishments1').val(null).trigger('change');

            $('#edit_fabric_images').val('');
            $('#fabric_images_tbody_edit').empty();
            $('#existing_images_container').empty().hide();
        });
    });
</script>
