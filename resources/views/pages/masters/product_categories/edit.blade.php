<style>
    #edit_image_preview {
        width: 100%;
    }
</style>

<div class="modal fade" id="product_category_edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Edit Product Style</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('product_categories.update')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" value="" id="product_category_id" name="product_category_id" />
                    <input type="hidden" id="current_image_path" value="" />

                    <div class="col-md-12 form-field div_none1">
                        <label class="form-lable">Product Style Name: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-input w-80" id="edit_product_category_name" name="edit_product_category_name" required />
                    </div>

                    <div class="col-md-12 form-field mt-5">
                        <div>
                            <label class="form-lable" style="width: 100%;">Product Style Picture</label>
                            <p style="color: #ff0000; font-size: 0.8rem;">Maximum file size: 1MB with a resolution of 500px x 496px</p>
                        </div>
                        <div>
                            <input type="file" class="form-control form-input img-choose" id="edit_profile_pic" name="edit_profile_pic" onchange="edituploadFile()" style="overflow: hidden;" />
                        </div>
                    </div>

                    <div class="col-md-6 form-field mt-4">
                        <div id="edit_image_container">
                            <img id="edit_image_preview" />
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom" type="button" data-dismiss="modal" aria-label="Close">Cancel</button>
                        @if (Gate::check('delete product_categories'))
                        <button type="button" class="btn btn-danger btn-custom delete">Delete</button>
                        @endif
                        @if (Gate::check('edit product_categories'))
                        <button type="submit" class="btn btn-success btn-custom">Save</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // On modal shown
    $('#product_category_edit_modal').on('shown.bs.modal', function (e) {
        var productCategoryId = $('#product_category_id').val();

        $.ajax({
            url: '{{url("product_categories/edit")}}/' + productCategoryId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#edit_product_category_name').val(data.product_category_name);

                if (data.category_image) {
                    var imageName = "{{ asset('') }}/" + data.category_image;
                    $('#edit_image_preview').attr('src', imageName);
                    $('#current_image_path').val(data.category_image);
                } else {
                    $('#edit_image_preview').attr('src', '{{ asset("argon") }}/img/icons/placeholder.png');
                    $('#current_image_path').val('');
                }
            }
        });
    });

    // Handle file upload
    function edituploadFile() {
        var image_preview = document.getElementById("edit_image_preview");
        var file_input = document.getElementById("edit_profile_pic");
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

    // Handle delete button click
    $(".delete").on("click", function () {
        var productCategoryId = $('#product_category_id').val();
        window.location.replace("../../product_categories/delete/" + productCategoryId);
    });

    $('#product_category_edit_modal').on('hidden.bs.modal', function () {
        // Clear input fields
        $('#product_category_id').val('');
        $('#edit_product_category_name').val('');
        $('#edit_profile_pic').val('');

        // Reset the image preview to the placeholder
        $('#edit_image_preview').attr('src', '{{ asset("argon") }}/img/icons/placeholder.png');
        $('#current_image_path').val('');

    });

</script>
