<style>
    #edit_image_container {
        width: 100px;
        height: 100px;
        margin-left: 15px;
        margin-top: -30px;
        border-radius: 10%;
        overflow: hidden;
    }
    #edit_image_preview {
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
    #edit_catalog_preview {
        width: 100%;
    }
    #new_catalog_container {
        width: 100%;
    }

</style>

<div class="modal fade" id="sport_edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Add Edit Sport</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('sports.update') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row">
                            <input type="hidden" value="" id="sport_id" name="sport_id" />
                            <input type="hidden" id="current_image_path" value="" />

                            <div class="col-md-12 form-field">
                                <label class="form-lable">Sport Name <span class="text-danger">*</span></label>
                                <input type="text" class="required form-control form-input" id="sport_edit_name" name="sport_edit_name" required />
                            </div>

                            <div class="col-md-8 form-field mt-5">
                                <label class="form-lable">Sport Picture</label>
                                <input type="file" class="form-control form-input img-choose" id="edit_profile_pic" name="edit_profile_pic" onchange="edituploadFile()" style="overflow: hidden;" />
                            </div>

                            <div class="col-md-4 form-field mt-5">
                                <div id="edit_image_container">
                                    <img id="edit_image_preview" >
                                </div>
                            </div>


                        </div>

                        <div class="col-md-12 form-field mt-5">
                            <div>
                                <label class="form-lable" style="width: 100%;">Catalog Picture</label>
                                <p style="color: #ff0000; font-size: 0.8rem;">Maximum file size: 1MB with a resolution of 500px x 496px</p>
                            </div>
                            <div>
                                <input type="file" class="form-control form-input img-choose" id="edit_catalog_pic" name="edit_catalog_pic" onchange="editCatalogFile()" style="overflow: hidden;" />
                            </div>
                        </div>

                        <div class="col-md-6 form-field mt-4">
                            <div id="">
                                <img id="edit_catalog_preview" />
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom"  type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="button" class="btn btn-danger btn-custom delete" id="save">Delete</button>
                        <button type="submit" class="btn btn-success btn-custom" id="save">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

function edituploadFile() {
    var image_preview = document.getElementById("edit_image_preview");
    var file_input = document.getElementById("edit_profile_pic");
    var file = file_input.files[0];

    var reader = new FileReader();
    reader.onloadend = function () {
        image_preview.src = reader.result;
    };

    if (file) {
        reader.readAsDataURL(file);
    } else {
        image_preview.src = "";
    }
}


    $('#sport_edit_modal').on('shown.bs.modal', function (e) {
        var sportId = $('#sport_id').val();

        $.ajax({
            url: '{{url("sports/edit")}}/' + sportId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#sport_edit_name').val(data.sport_name);
console.log(data);
                if (data.sport_image) {
                    // Extract the filename from the path
                    var imageName = "assets/" +data.sport_image;
                    console.log(imageName);
                    // Update the image source using the correct path
                    $('#edit_image_preview').attr('src', imageName);
                } else {
                    $('#edit_image_preview').attr('src', '{{ asset("argon") }}/img/icons/placeholder.png');
                }

                if (data.catalog_image) {
                    var imageName = "{{ asset('') }}/" + data.catalog_image;
                    $('#edit_catalog_preview').attr('src', imageName);
                    $('#current_image_path').val(data.catalog_image);
                } else {
                    $('#edit_catalog_preview').attr('src', '{{ asset("argon") }}/img/icons/placeholder.png');
                    $('#current_image_path').val('');
                }
            }
        });
    });

    function editCatalogFile() {
        var image_preview = document.getElementById("edit_catalog_preview");
        var file_input = document.getElementById("edit_catalog_pic");
        var file = file_input.files[0];

        var previousImagePath = document.getElementById("current_image_path").value;

        if (file) {
            var reader = new FileReader();
            reader.onloadend = function () {
                var img = new Image();
                img.src = reader.result;

                img.onload = function () {

                    if (img.width === 500 && img.height === 496) {

                        image_preview.src = reader.result;
                    } else {

                        Swal.fire({
                            icon: "error",
                            title: "Invalid Image Size",
                            text: "The uploaded image must be 500px x 496px.",
                            confirmButtonText: "OK",
                        }).then(() => {

                            file_input.value = "";
                            if (previousImagePath) {
                                image_preview.src = "{{ asset('') }}/" + previousImagePath;
                            } else {
                                image_preview.src = "{{ asset('argon') }}/img/icons/placeholder.png";
                            }
                        });
                    }
                };
            };

            reader.readAsDataURL(file);
        } else {

            if (previousImagePath) {
                image_preview.src = "{{ asset('') }}/" + previousImagePath;
            } else {
                image_preview.src = "{{ asset('argon') }}/img/icons/placeholder.png";
            }
        }
    }

    $(".delete").on("click", function(){
        var sportId = $('#sport_id').val();
        var deleteUrl = "{{ route('sports.delete', ['id' => ':id']) }}";
        deleteUrl = deleteUrl.replace(':id', sportId);
        window.location.replace(deleteUrl);

    });

    $('#sport_edit_modal').on('hidden.bs.modal', function () {
        // Clear input fields
        $('#sport_id').val('');
        $('#sport_edit_name').val('');
        $('#edit_catalog_pic').val('');

        // Reset the image preview to the placeholder
        $('#edit_catalog_preview').attr('src', '{{ asset("argon") }}/img/icons/placeholder.png');
        $('#current_image_path').val('');

    });

</script>


