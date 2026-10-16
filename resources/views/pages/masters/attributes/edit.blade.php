<div class="modal fade" id="attribute_edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Edit Attributes</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('attributes.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" value="" id="attribute_id" name="attribute_id" />

                    <div class="col-md-12">
                        <div class="row flex_set">
                            <div class="col-md-6 max_width01">
                                <div class="">
                                    <label class="form-label">Attribute <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-input" id="edit_attribute" name="edit_attribute" required />
                                </div>
                            </div>
                            <div class="col-md-6 max_width01">
                                <div class="">
                                    <label class="form-label">Price ($)</label>
                                    <input type="number" class="form-control form-input" id="edit_attribute_price" name="edit_attribute_price" min="0" oninput="validity.valid||(value='');"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3 div_none1">
                        <label class="form-label">Available Colors <span class="text-danger"></span></label><br>
                        <select class="form-control form-input multy-selection" id="edit_attribute_colors" name="edit_attribute_colors[]" multiple="multiple">
                            @foreach ($colorMasters as $colorMaster)
                                <option value="{{$colorMaster->id}}" data-hex="{{$colorMaster->hex}}">
                                    {{$colorMaster->pantone_code}}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-12 mt-3 div_none1">
                        <label class="form-label">Attribute Description <span class="text-danger"></span></label><br>
                        <textarea class="form-control form-input" id="edit_description" name="edit_description" rows="4"></textarea>
                    </div>

                    <div class="col-md-12 mt-3 div_none1">
                        <div class="custom-control custom-checkbox toggle-checkbox">
                            <input name="is_sub_attribute" type="checkbox" value="1" class="custom-control-input" id="edit_is_sub_attribute">
                            <label class="custom-control-label" for="edit_is_sub_attribute">&nbsp; Mark as Sub Attribute &nbsp;</label>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3 div_none1">
                        <label class="form-label">Attribute Image <span class="text-danger">*</span></label><br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12 mt-3" style="padding: 0rem">
                                    <label for="edit_attribute_images" id="edit_attribute_images_upload_area" class="upload-area" style="height: 200px;">
                                        <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                        <div class="upload-icon">
                                            <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD IMAGE</i>
                                        </div>
                                        <p style="color: #b3b3b3;font-size: .8rem;margin-top: .5rem;">
                                            Drag & drop ATTRIBUTE images here or <span style="font-weight: 600">CLICK HERE</span> to upload ATTRIBUTE images
                                        </p>
                                    </label>
                                    <input type="file" id="edit_attribute_images" class="file-select" accept="image/*" style="display: none;" multiple onchange="editUploadMultipleImages('edit_attribute_images')">
                                </div>
                                <div id="existing_images_container" style="display: none;"></div>
                            </div>

                            <!-- Uploaded Attribute Images Table -->
                            <div class="col-md-6">
                                <div class="row mt-2" id="uploaded_attribute_images_table">
                                    <div class="col-md-12 sub-header-style">Uploaded Attribute Images</div>
                                    <div class="col-md-12 mt-3 mb-2">
                                        <table class="subProductTable" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class="image_table_header">FILE NAME</th>
                                                    <th class="text-center image_table_header">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody id="attribute_images_tbody_edit">
                                                <!-- Dynamically generated rows will go here -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom"  type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        @if (Gate::check('delete attributes'))
                        <button type="button" class="btn btn-danger btn-custom delete">Delete</button>
                        @endif
                        @if (Gate::check('edit attributes'))
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
          <img src="" alt="Attribute Image" style="width: 100%;"/>
        </div>
      </div>
    </div>
  </div>

<script>
    $('#attribute_edit_modal').on('shown.bs.modal', function (e) {
        var attributeId = $('#attribute_id').val();
        $.ajax({
            url: '{{url("attributes/edit")}}/'+attributeId,
            type: 'GET',
            dataType: 'json',
            success: function(data){console.log(data);
                $('#edit_attribute').val(data.attribute.attribute_name);
                $('#edit_attribute_price').val(data.attribute.price);
                $('#edit_description').val(data.attribute.description);

                if(data.attribute.is_sub_attribute == 1){
                    $('#edit_is_sub_attribute').prop('checked', true);
                } else {
                    $('#edit_is_sub_attribute').prop('checked', false);
                }

                $('#edit_attribute_colors').val(null).trigger('change');

                let selectedColors = data.attributeColor.map(color => color.color_master_id);
                $('#edit_attribute_colors').val(selectedColors).trigger('change');

                $('#attribute_images_tbody_edit').empty();
                $('#existing_images_container').empty();

                existingImageCount = data.images.length; // Update existing image count

                data.images.forEach((image) => {
                    if (image) {
                        var fileName = image.split('/').pop();
                        var truncatedFileName = fileName.length > 30 ? fileName.substring(0, 30) + '...' : fileName;

                        var newHiddenInput = `<input type="hidden" name="existing_images[]" value="${image}" />`;
                        $('#existing_images_container').append(newHiddenInput);

                        var newRowHTML = `
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
                            </tr>
                        `;
                        $('#attribute_images_tbody_edit').append(newRowHTML);
                    }
                });

            }
        });
    })

    function editUploadMultipleImages(inputId) {
        var input = document.getElementById(inputId);
        var files = input.files;
        var newFilesCount = files.length;
        var tbody = document.getElementById("attribute_images_tbody_edit");
        var existingRows = tbody.getElementsByTagName("tr").length;
        var totalImages = existingRows + files.length;

        var availableSlots = 5 - existingImageCount;

        if (totalImages > 5) {
            alert(`You can only upload a maximum of 5 more images.`);
            return;
        }

        for (var i = 0; i < newFilesCount; i++) {
            var file = files[i];

            var truncatedName = file.name.length > 30 ? file.name.substring(0, 30) + '...' : file.name;

            var newRowHTML = `
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
                </tr>
            `;
            $('#attribute_images_tbody_edit').append(newRowHTML);

            var inputContainer = document.getElementById("existing_images_container");
            var newInput = document.createElement("input");
            newInput.type = "file";
            newInput.name = `edit_attribute_images[]`;
            newInput.style.display = "none";
            inputContainer.appendChild(newInput);

            var dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            newInput.files = dataTransfer.files;
        }

        existingImageCount += newFilesCount;
    }

    function viewImage(imagePath) {
        var modal = document.getElementById("edit_image_view_modal");
        modal.querySelector("img").src = imagePath;
        $(modal).modal('show');
    }

    function deleteImage(button, imageName) {

        var row = button.closest('tr');
        row.remove();

        $('input[name="existing_images[]"][value="' + imageName + '"]').remove();

        if (row.querySelector("input[name='existing_images[]']") !== null) {
            existingImageCount--;
        } else {
            existingImageCount--;
        }
    }

    $(".delete").on("click", function(){
        var attributeId = $('#attribute_id').val();
        window.location.replace("../../attributes/delete/"+attributeId);
    });

    $('#edit_attribute_price').focus(function(){
        $('#edit_attribute_price').select();
    });

    $(document).ready(function() {
        $('#attribute_edit_modal').on('shown.bs.modal', function () {
            $('#edit_attribute_colors').select2({
                placeholder: "Select colors",
                allowClear: true,
                width: '100%',
                templateResult: formatColorOption, // For dropdown options
                templateSelection: formatColorOption // For selected options
            });
        });

        function formatColorOption(state) {
            if (!state.id) {
                return state.text; // Return text if no id (for placeholder)
            }

            // Get the hex color value from the data attribute (no extra # needed)
            var hexColor = $(state.element).data('hex');
            var $state = $(
                '<span style="background-color:#' + hexColor + '; color: #fff; padding: 1px 10px; border-radius: 2px;">'
                + state.text + '</span>'
            );
            return $state;
        }
    });
</script>
