<div class="modal fade" id="modal_view_mockup_images" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Mockup Images</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row" style="width: 100%;margin-left: 15px;">
                    <div class="col-md-4">
                        <div class="row">
                            <label class="form-lable"  style="width: 100%">Mockup Image 1 :</label>
                        </div>
                        <br/>
                        <div class="row" style="align-content: center">
                            <img id="preview_mockup_img_1" style="height: 100px; width: 100px;border-color: black;"/>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <label class="form-lable"  style="width: 100%">Mockup Image 2 :</label>
                        </div>
                        <br/>
                        <div class="row" style="align-content: center">
                            <img id="preview_mockup_img_2" style="height: 100px; width: 100px;border-color: black;"/>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <label class="form-lable"  style="width: 100%">Mockup Image 3 :</label>
                        </div>
                        <br/>
                        <div class="row" style="align-content: center">
                            <img id="preview_mockup_img_3" style="height: 100px; width: 100px;border-color: black;"/>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>

    // Get a reference to the close button
const closeButton = document.querySelector('#modal_view_mockup_images .close');

// Add a click event listener to the close button
closeButton.addEventListener('click', function() {
  // Programmatically close the modal
  const modal = document.getElementById('modal_view_mockup_images');
  $(modal).modal('hide');
});

</script>
