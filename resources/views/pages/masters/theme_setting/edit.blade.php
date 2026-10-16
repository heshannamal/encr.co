<style>

.switchEdit {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }

    .switchEdit input {
        display: none;
    }

    .sliderEdit {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 24px;
    }

    .sliderEdit:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 4px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    input:checked + .sliderEdit {
        background-color: #28a745; /* Green for active state */
    }

    input:checked + .sliderEdit:before {
        transform: translateX(26px);
    }
</style>

<div class="modal fade" id="theme_setting_edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Edit Master Fit</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('theme_setting.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" value="" id="theme_setting_id" name="theme_setting_id" />

                    <div class="col-md-12">
                        <div class="">
                            <label class="form-label">Theme Setting Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-input" id="edit_theme_setting" name="edit_theme_setting" required />
                        </div>
                    </div>

                    <div class="col-md-12 mt-3 div_none1">
                        <label class="form-label">Theme Action<span class="text-danger"></span></label><br>
                        <!-- Toggle Button -->
                        <label class="switchEdit">
                            <input type="checkbox" id="themeActionToggleEdit" name="themeActionToggleEdit">
                            <span class="sliderEdit"></span>
                        </label>
                    </div>

                </div>

                <div class="card-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom" type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        @if (Gate::check('delete theme_settings'))
                        <button type="button" class="btn btn-danger btn-custom delete">Delete</button>
                        @endif
                        @if (Gate::check('edit theme_settings'))
                        <button type="submit" class="btn btn-success btn-custom">Save</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

    $('#theme_setting_edit_modal').on('shown.bs.modal', function (e) {
        var themeSettingId = $('#theme_setting_id').val();
        // console.log("Product Tagline ID:", themeSettingId);

        $.ajax({
            url: '{{ route("theme_setting.edit", ":id") }}'.replace(':id', themeSettingId),
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // console.log("Data retrieved:", data);

                $('#edit_theme_setting').val(data.theme_name);

                if (data.themeActionToggle === 1 || data.themeActionToggle === "1") {
                    $('#themeActionToggleEdit').prop('checked', true);
                } else {
                    $('#themeActionToggleEdit').prop('checked', false);
                }

            },
            error: function(xhr, status, error) {
                console.error("Error fetching product tagline: ", status, error);
            }
        });
    });

    $(".delete").on("click", function() {
        var themeSettingId = $('#theme_setting_id').val();

        $.ajax({
            url: "{{ route('theme_setting.delete') }}",
            type: "GET",
            data: { id: themeSettingId },
            success: function(response) {
                    location.reload();

            },
            error: function(xhr) {
                // Handle any errors here
                alert("An error occurred: " + xhr.responseText);
            }
        });
    });


</script>
