<style>
    #new_image_preview {
        width: 100%;
    }
</style>

<div class="modal fade" id="product_category_create_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Add New Product Style</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('product_category.create')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12 form-field div_none1">
                        <label class="form-lable">Product Style Name: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-input w-80" id="new_product_category_name" name="new_product_category_name" required />
                    </div>

                    <div class="col-md-12 form-field mt-5">
                        <div>
                            <label class="form-label">Product Style Picture</label>
                            <p style="color: #ff0000; font-size: 0.8rem;">Maximum file size: 1MB with a resolution of 500px x 496px</p>
                        </div>
                        <div>
                            <input type="file" class="form-control form-input img-choose" id="new_profile_pic" name="new_profile_pic" onchange="uploadFile()" style="overflow: hidden;" />
                        </div>
                    </div>

                    <div class="col-md-6 form-field mt-4">
                        <div id="new_image_container">
                            <img src="{{ asset('argon') }}/img/icons/placeholder.png" id="new_image_preview" />
                        </div>
                    </div>
                </div>

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


<script>

function uploadFile() {
    var image_preview = document.getElementById("new_image_preview");
    var file = document.querySelector("input[type=file]").files[0];

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
                        document.querySelector("input[type=file]").value = "";
                        image_preview.src = "{{ asset('argon') }}/img/icons/placeholder.png";
                    });
                }
            };
        };
        reader.readAsDataURL(file);
    } else {
        image_preview.src = "{{ asset('argon') }}/img/icons/placeholder.png";
    }
}


</script>
