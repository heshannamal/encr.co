
<style>
    .uploadStyles{
        border: none;
        background-color: transparent;
        padding: .5rem;
        cursor: pointer;
    }

    /* MOBILE VIEW CSS (Edit Fabrics Modal) */
    @media (max-width: 768px) {
        #fabric_edit_modal .modal-dialog {
            margin: 12px auto !important;
            max-width: 95% !important;
            width: 95% !important;
        }

        #fabric_edit_modal .modal-content {
            border-radius: 20px !important;
            border: 1px solid #edf0f2 !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
            padding: 8px 10px !important;
            background: #ffffff !important;
        }

        #fabric_edit_modal .modal-header {
            border-bottom: 1px solid #f1f3f5 !important;
            padding: 14px 14px 12px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
        }

        #fabric_edit_modal .modal-title {
            font-size: 18px !important;
            font-weight: 700 !important;
            color: #111827 !important;
            margin: 0 !important;
        }

        #fabric_edit_modal .modal-header .close {
            font-size: 24px !important;
            font-weight: 300 !important;
            color: #9ca3af !important;
            opacity: 1 !important;
            padding: 0 !important;
            margin: 0 !important;
            line-height: 1 !important;
            outline: none !important;
        }

        #fabric_edit_modal .modal-body {
            padding: 14px 10px !important;
        }

        #fabric_edit_modal .col-md-12 {
            padding-left: 6px !important;
            padding-right: 6px !important;
        }

        /* Form Labels */
        #fabric_edit_modal .form-label,
        #fabric_edit_modal .form-lable {
            font-size: 13.5px !important;
            font-weight: 700 !important;
            color: #111827 !important;
            margin-bottom: 6px !important;
            display: block !important;
        }

        /* Text Input */
        #fabric_edit_modal input[type="text"].form-control {
            border-radius: 10px !important;
            border: 1px solid #e5e7eb !important;
            padding: 10px 14px !important;
            height: 44px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            color: #111827 !important;
            box-shadow: none !important;
        }

        /* +Add Color Button */
        #fabric_edit_modal #addColor2 {
            background-color: #ffffff !important;
            border: 1.5px solid #2563eb !important;
            color: #2563eb !important;
            border-radius: 999px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            padding: 5px 18px !important;
            margin-top: 8px !important;
            box-shadow: none !important;
            outline: none !important;
        }

        /* Select2 Embellishments Container */
        #fabric_edit_modal .select2-container--bootstrap-5 .select2-selection--multiple,
        #fabric_edit_modal .select2-container .select2-selection--multiple {
            border-radius: 12px !important;
            border: 1px solid #e5e7eb !important;
            min-height: 44px !important;
            padding: 4px 8px !important;
        }

        /* Quill Editor Box */
        #fabric_edit_modal .ql-toolbar {
            border-top-left-radius: 12px !important;
            border-top-right-radius: 12px !important;
            border: 1px solid #e5e7eb !important;
            background-color: #f3f4f6 !important;
            padding: 8px 10px !important;
        }

        #fabric_edit_modal .ql-container {
            border-bottom-left-radius: 12px !important;
            border-bottom-right-radius: 12px !important;
            border: 1px solid #e5e7eb !important;
            border-top: none !important;
            background: #ffffff !important;
            font-size: 14px !important;
        }

        #fabric_edit_modal #edit_description_editor {
            height: 110px !important;
        }

        /* Upload Area */
        #fabric_edit_modal .upload-area {
            border: 1.5px dashed #d1d5db !important;
            border-radius: 16px !important;
            background-color: #f9fafb !important;
            height: auto !important;
            min-height: 170px !important;
            padding: 20px 14px !important;
            margin-top: 6px !important;
        }

        /* Hide default icon & text, replaced with clean modern icon and upload button */
        #fabric_edit_modal .upload-area i.fa-cloud-upload {
            display: none !important;
        }

        #fabric_edit_modal .upload-area .upload-icon {
            display: none !important;
        }

        #fabric_edit_modal .upload-area::before {
            content: "" !important;
            display: block !important;
            width: 44px !important;
            height: 44px !important;
            margin: 0 auto 10px auto !important;
            background: #e5e7eb url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23374151' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><rect x='3' y='3' width='18' height='18' rx='2' ry='2'></rect><circle cx='8.5' cy='8.5' r='1.5'></circle><polyline points='21 15 16 10 5 21'></polyline></svg>") center/22px no-repeat !important;
            border-radius: 10px !important;
        }

        #fabric_edit_modal .upload-area p {
            font-size: 12px !important;
            color: #374151 !important;
            margin: 0 0 12px 0 !important;
            line-height: 1.4 !important;
            text-align: center !important;
            font-weight: 500 !important;
        }

        #fabric_edit_modal .upload-area::after {
            content: "Upload" !important;
            display: inline-block !important;
            margin: 0 auto !important;
            padding: 6px 26px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #2563eb !important;
            background-color: #ffffff !important;
            border: 1.5px solid #2563eb !important;
            border-radius: 8px !important;
        }

        /* Uploaded Images Section */
        #fabric_edit_modal #uploaded_fabric_images_table {
            margin-top: 14px !important;
        }

        #fabric_edit_modal .sub-header-style {
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #111827 !important;
            margin-bottom: 8px !important;
        }

        #fabric_edit_modal .subProductTable thead {
            display: none !important;
        }

        #fabric_edit_modal .subProductTable tr {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            border-bottom: 1px solid #f3f4f6 !important;
            padding: 8px 0 !important;
        }

        #fabric_edit_modal .subProductTable td {
            font-size: 13px !important;
            color: #4b5563 !important;
            padding: 0 !important;
            border: none !important;
        }

        #fabric_edit_modal .subProductTable td:first-child {
            flex: 1 1 auto !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
            padding-right: 8px !important;
        }

        #fabric_edit_modal .subProductTable td.text-center {
            display: flex !important;
            gap: 6px !important;
            flex: 0 0 auto !important;
        }

        #fabric_edit_modal .uploadStyles {
            width: 34px !important;
            height: 34px !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 8px !important;
            background: #ffffff !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 0 !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03) !important;
        }

        #fabric_edit_modal .uploadStyles i {
            font-size: 14px !important;
        }

        /* Modal Footer Action Buttons (Delete, Cancel, Save/Update) */
        #fabric_edit_modal .modal-footer {
            border-top: none !important;
            padding: 14px 10px 10px !important;
        }

        #fabric_edit_modal .control-btns {
            display: flex !important;
            gap: 10px !important;
            width: 100% !important;
            padding: 0 !important;
        }

        #fabric_edit_modal .control-btns .btn {
            flex: 1 1 33.33% !important;
            height: 46px !important;
            border-radius: 12px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: 0 !important;
            border: none !important;
        }

        #fabric_edit_modal .control-btns .btn-danger {
            background-color: #dc2626 !important;
            color: #ffffff !important;
        }

        #fabric_edit_modal .control-btns .btn-secondary {
            background-color: #94a3b8 !important;
            color: #ffffff !important;
        }

        #fabric_edit_modal .control-btns .btn-success {
            background-color: #10b981 !important;
            color: #ffffff !important;
        }
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
