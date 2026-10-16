<div class="modal fade" id="catalog_category_edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Edit Catalog Category</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('catalog_category.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" value="" id="catalog_category_id" name="catalog_category_id" />
                    <input type="hidden" id="current_image_path" value="" />

                    <div class="col-md-12">
                        <div class="">
                            <label class="form-label" style="width: 100%;">Catalog Category Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-input" id="edit_catalog_category_name" name="edit_catalog_category_name" required />
                        </div>
                    </div>

                    <div class="col-md-12 form-field mt-5">
                        <div>
                            <label class="form-lable">Catalog Category Picture</label>
                            <p style="color: #ff0000; font-size: 0.8rem;">Maximum file size: 1MB with a resolution of 300px x 343px</p>
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

                <div class="card-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom" type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        @if (Gate::check('delete catalog_category_types'))
                        <button type="button" class="btn btn-danger btn-custom delete" data-delete-url="{{ route('catalog_category.delete', ':id') }}">Delete</button>
                        @endif
                        @if (Gate::check('edit catalog_category_types'))
                        <button type="submit" class="btn btn-success btn-custom">Save</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script>

$('#catalog_category_edit_modal').on('shown.bs.modal', function (e) {
    var categoryId = $('#catalog_category_id').val();
    console.log("Product Tagline ID:", categoryId);

    $.ajax({
        url: '{{ route("catalog_category.edit", ":id") }}'.replace(':id', categoryId),
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log("Data retrieved:", data);

            if (data) {
                $('#edit_catalog_category_name').val(data.category_name);

                if (data.style_image) {
                    var imageName = "{{ asset('') }}/" + data.style_image;
                    $('#edit_image_preview').attr('src', imageName);
                    $('#current_image_path').val(data.style_image);
                } else {
                    $('#edit_image_preview').attr('src', '{{ asset("argon") }}/img/icons/placeholder.png');
                    $('#current_image_path').val('');
                }

            }
        },
        error: function(xhr, status, error) {
            console.error("Error fetching product tagline: ", status, error);
        }
    });
});


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

                    if (img.width === 300 && img.height === 343) {

                        image_preview.src = reader.result;
                    } else {

                        Swal.fire({
                            icon: "error",
                            title: "Invalid Image Size",
                            text: "The uploaded image must be 300px x 343px.",
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

    // Delete button click handler
    $(".delete").on("click", function () {
        var categoryId = $('#catalog_category_id').val();
        var deleteUrl = $(this).data('delete-url').replace(':id', categoryId);  // Replacing the :id placeholder

        if (confirm("Are you sure you want to delete this category?")) {
            window.location.href = deleteUrl;
        }
    });

    $('#catalog_category_edit_modal').on('hidden.bs.modal', function () {
        // Clear input fields
        $('#catalog_category_id').val('');
        $('#edit_catalog_category_name').val('');
        $('#edit_profile_pic').val('');

        // Reset the image preview to the placeholder
        $('#edit_image_preview').attr('src', '{{ asset("argon") }}/img/icons/placeholder.png');
        $('#current_image_path').val('');
        
    });

</script>
