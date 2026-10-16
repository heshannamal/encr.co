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
    .select2-container {
        border: 1px solid rgb(236, 236, 236) !important;
        border-radius: 5px !important;
    }
</style>

<div class="modal fade" id="attribute_create_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Add New Attributes</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('attributes.create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row flex_set">
                            <div class="col-md-6 max_width01">
                                <div class="">
                                    <label class="form-label">Attribute <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-input" id="new_attribute" name="new_attribute" required />
                                </div>
                            </div>
                            <div class="col-md-6 max_width01">
                                <div class="">
                                    <label class="form-label">Price ($)</label>
                                    <input type="number" class="form-control form-input" id="new_attribute_price" name="new_attribute_price" min="0" oninput="validity.valid||(value='');"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3 div_none1">
                        <label class="form-label">Available Colors <span class="text-danger"></span></label><br>
                        <select class="form-control form-input multy-selection" id="new_attribute_colors" name="new_attribute_colors[]" multiple="multiple">
                            @foreach ($colorMasters as $colorMaster)
                                <option value="{{$colorMaster->id}}" data-hex="{{$colorMaster->hex}}">
                                    {{$colorMaster->pantone_code}}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-12 mt-3 div_none1">
                        <label class="form-label">Attribute Description <span class="text-danger"></span></label><br>
                        <textarea class="form-control form-input" id="new_description" name="new_description" rows="4"></textarea>
                    </div>

                    <div class="col-md-12 mt-3 div_none1">
                        <div class="custom-control custom-checkbox toggle-checkbox">
                            <input name="is_sub_attribute" type="checkbox" value="1" class="custom-control-input" id="new_is_sub_attribute">
                            <label class="custom-control-label" for="new_is_sub_attribute">&nbsp; Mark as Sub Attribute &nbsp;</label>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3 div_none1">
                        <label class="form-label">Attribute Image <span class="text-danger">*</span></label><br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12 mt-3" style="padding: 0rem">
                                    <label for="attribute_images" id="attribute_images_upload_area" class="upload-area" style="height: 200px;">
                                        <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                        <div class="upload-icon">
                                            <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD IMAGE</i>
                                        </div>
                                        <p style="color: #b3b3b3;font-size: .8rem;margin-top: .5rem;">
                                            Drag & drop ATTRIBUTE images here or <span style="font-weight: 600">CLICK HERE</span> to upload ATTRIBUTE images
                                        </p>
                                    </label>
                                    <input type="file" id="attribute_images" class="file-select" accept="image/*" style="display: none;" multiple onchange="uploadMultipleImages('attribute_images')">
                                </div>
                            </div>

                            <!-- Uploaded attribute Images Table -->
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
                                            <tbody id="attribute_images_tbody">
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

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom"  type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="submit" class="btn btn-success btn-custom">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

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
          <img src="" alt="Sttribute Image" style="width: 100%;"/>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let attributeImagesArray = [];

    // Function to upload multiple images
    function uploadMultipleImages(inputId) {
        var input = document.getElementById(inputId);
        var files = input.files;
        var tbody = document.getElementById("attribute_images_tbody");
        var existingRows = tbody.getElementsByTagName("tr").length; // Count existing rows
        var totalImages = existingRows + files.length;

        // Allow a maximum of 5 images
        if (totalImages > 5) {
            alert("You can only upload a maximum of 5 images.");
            return;
        }

        if (files.length > 0) {
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var fileName = file.name;
                var truncateName = fileName.length > 30 ? fileName.substring(0, 30) + '...' : fileName;
                // Add the file to the attributeImagesArray
                attributeImagesArray.push(file);

                console.log(attributeImagesArray);

                // Create new row using template literals
                var newRowHTML = `
                    <tr>
                        <td>${truncateName}</td>
                        <td class="text-center">
                            <button class="uploadStyles" type="button" title="View" onclick="viewImage(${attributeImagesArray.length - 1})">
                                <i class="fa fa-eye" style="color: grey;"></i>
                            </button>
                            <button onclick="deleteImage(this, '${fileName}')" class="uploadStyles" type="button" title="Delete">
                                <i class="fa fa-trash" style="color: #e19191;"></i>
                            </button>
                        </td>
                    </tr>
                `;

                // Insert the new row into the table body
                tbody.insertAdjacentHTML('beforeend', newRowHTML);

                // Dynamically create hidden input and assign the image to it
                var inputContainer = document.getElementById("hidden_inputs_container");
                var newInput = document.createElement("input");
                newInput.type = "file";
                newInput.name = `attribute_images[]`;
                newInput.style.display = "none";
                inputContainer.appendChild(newInput);

                // Assign the file to the new input field using DataTransfer
                var dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                newInput.files = dataTransfer.files;
            }
        }

        // Clear the input value so the same file can be selected again if needed
        input.value = '';
    }

    // Function to handle image preview
    function viewImage(index) {
        var file = attributeImagesArray[index]; // Get the file from the array
        var reader = new FileReader();
        reader.onload = function(event) {
            var modal = document.getElementById("image_view_modal");
            modal.querySelector("img").src = event.target.result; // Set the modal image source
            $(modal).modal('show'); // Show the modal
        };
        reader.readAsDataURL(file); // Read the file as a data URL
    }

    // Function to delete image row
    function deleteImage(button, fileName) {
        // Remove the row from the table
        var row = button.closest('tr');
        row.remove();

        // Remove the file from the attributeImagesArray
        attributeImagesArray = attributeImagesArray.filter(f => f.name !== fileName);

        // Remove the hidden input as well
        var inputs = document.querySelectorAll('input[name="attribute_images[]"]');
        for (var input of inputs) {
            if (input.files[0].name === fileName) {
                input.remove(); // Remove the corresponding hidden input
                break;
            }
        }
    }

// When the modal is shown, initialize select2

$(document).ready(function() {
    $('#attribute_create_modal').on('shown.bs.modal', function () {
        $('#new_attribute_colors').select2({
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
