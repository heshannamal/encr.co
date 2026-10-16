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

<div class="modal fade" id="icon_edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Edit Sport</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('project_icons.update') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row">
                            <input type="hidden" value="" id="project_icon_id" name="project_icon_id" />
                            <input type="hidden" id="current_image_path" value="" />

                            <div class="col-md-8 form-field mt-5">
                                <label class="form-lable">Project Icon</label>
                                <input type="file" class="form-control form-input img-choose" id="edit_project_icon" name="edit_project_icon" accept=".png,image/png" onchange="edituploadFile()" style="overflow: hidden;" required/>
                            </div>

                            <div class="col-md-4 form-field mt-5">
                                <div id="edit_image_container">
                                    <img id="edit_image_preview" >
                                </div>
                            </div>


                        </div>

                        {{-- <div class="col-md-12 form-field mt-5">
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
                        </div> --}}

                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom"  type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="button" class="btn btn-danger btn-custom delete">Delete</button>
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
    var file_input = document.getElementById("edit_project_icon");
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


    $('#icon_edit_modal').on('shown.bs.modal', function (e) {
        var iconId = $('#project_icon_id').val();

        $.ajax({
            url: '{{url("get_project_icon_by_id")}}/' + iconId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {

                if (data.icon) {
                    // Extract the filename from the path
                    var imageName = '{{ asset("") }}/'+data.icon;
                    console.log(imageName);
                    // Update the image source using the correct path
                    $('#edit_image_preview').attr('src', imageName);
                } else {
                    $('#edit_image_preview').attr('src', '{{ asset("argon") }}/img/icons/placeholder.png');
                }
            }
        });
    });

    $(".delete").on("click", function(){
        var iconId = $('#project_icon_id').val();
        var deleteUrl = "{{ route('project_icons.delete', ['id' => ':id']) }}";
        deleteUrl = deleteUrl.replace(':id', iconId);

        Swal.fire({
            title: "Confirm Delete?",
            text: "Do You Want to Delete This Icon?",
            type: "warning",
            buttons: true,
            dangerMode: true,
            showCancelButton: true,
            confirmButtonColor: '#2dce89',
            closeOnConfirm: false,
            closeOnCancel: true

        }).then(function(isConfirm) {
            if (isConfirm.value == true) {
                window.location.replace(deleteUrl);
            }
        });
    });

    $('#icon_edit_modal').on('hidden.bs.modal', function () {
        // Clear input fields
        $('#project_icon_id').val('');
        $('#current_image_path').val('');
    });

</script>


