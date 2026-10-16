<style>
    #new_image_container {
        width: 100px;
        height: 100px;
        margin-left: 15px;
        margin-top: -30px;
        border-radius: 10%;
        overflow: hidden;
    }
    #new_image_preview {
        width: 100%;
        height: 100%;
    }
    #toggleNewPassword {
        cursor: pointer;
    }
    #toggleNewConfirmPassword {
        cursor: pointer;
    }
    .img-choose {
        position: relative;
        left: 63px;
        width: 62% !important;
    }
    #new_catalog_container {
        width: 100%;
    }
</style>

<div class="modal fade" id="icon_create_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Add New Icon</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('project_icons.create') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-8 form-field mt-5">
                                <label class="form-lable">Project Icon</label>
                                <input type="file" class="form-control form-input img-choose" id="new_project_icon" name="new_project_icon" accept=".png,image/png" onchange="uploadFile()" style="overflow: hidden;" required/>
                            </div>

                            <div class="col-md-4 form-field mt-5">
                                <div id="new_image_container">
                                    <img src="{{ asset('argon') }}/img/icons/placeholder.png" id="new_image_preview" />
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-12 form-field mt-5" style="padding-left: unset;">
                            <div>
                                <label class="form-lable" style="width:100%;">Catalog Picture</label>
                                <p style="color: #ff0000; font-size: 0.8rem;">Maximum file size: 1MB with a resolution of 500px x 496px</p>
                            </div>
                            <div>
                                <input type="file" class="form-control form-input img-choose" id="new_catalog_pic" name="new_catalog_pic" onchange="uploadCatalogFile()" style="overflow: hidden;" />
                            </div>
                        </div>

                        <div class="col-md-6 form-field mt-4">
                            <div id="new_catalog_container">
                                <img src="{{ asset('argon') }}/img/icons/placeholder.png" id="new_catalog_preview" />
                            </div>
                        </div> --}}
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom"  type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="submit" class="btn btn-success btn-custom" id="save">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

function uploadFile() {
        var image_preview = document.getElementById("new_image_preview");
        var file = document.querySelector("input[type=file]").files[0];

        var reader = new FileReader();
        reader.onloadend = function () {
            image_preview.src = reader.result;
            document.getElementById("base64").value = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            image_preview.src = "";

        }
    }


    function uploadCatalogFile() {
        // Get the preview image element and the selected file
        var image_preview_catalog = document.getElementById("new_catalog_preview");
        var fileCatalog = document.getElementById("new_catalog_pic").files[0];

        if (fileCatalog) {
            var readerCatalog = new FileReader(); // Use FileReader (corrected)
            readerCatalog.onloadend = function () {
                var img = new Image(); // Create a new Image object (corrected)
                img.src = readerCatalog.result;

                img.onload = function () {
                    // Validate image dimensions
                    if (img.width === 500 && img.height === 496) {
                        image_preview_catalog.src = readerCatalog.result; // Set preview to the uploaded image
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Invalid Image Size",
                            text: "The uploaded image must be 500px x 496px.",
                            confirmButtonText: "OK",
                        }).then(() => {
                            // Reset the file input and preview image
                            document.getElementById("new_catalog_pic").value = ""; // Clear the file input
                            image_preview_catalog.src = "{{ asset('argon') }}/img/icons/placeholder.png"; // Reset to placeholder
                        });
                    }
                };
            };
            readerCatalog.readAsDataURL(fileCatalog); // Read the file as a data URL
        } else {
            // Reset to placeholder if no file is selected
            image_preview_catalog.src = "{{ asset('argon') }}/img/icons/placeholder.png";
        }
    }

</script>
