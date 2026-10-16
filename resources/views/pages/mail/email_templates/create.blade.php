<div class="modal fade" id="template_create_modal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="new_template_form_title">Create Template</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('email.templates.store') }}" method="post" enctype="multipart/form-data" id="email_template_create_form">
                @csrf
                <input type="hidden"  id="template_id" name="template_id" value="">

                <div class="col-md-12">
                    <label class="form-lable-info form-label">Template Title</label>
                    <input type="text" class="form-control info-form-input mt-2" id="template_title" name="title" value="" >
                </div>
                <div class="col-md-12 mt-4">
                    <label class="form-lable-info form-label">Email Subject</label>
                    <input type="text" class="form-control info-form-input mt-2" id="template_subject" name="subject" value="">
                </div>
                <div class="col-md-12 mt-3 mb-1">
                    <label for="new_description" class="form-label mb-1" style="color: black">Email Body</label>
                    <div id="editor-container" style="height: 300px;"></div>
                    <input type="hidden" id="template_body" name="template_body">
                </div>
                <div class="col-md-12 mt-3 mb-1" id="template_privacy_section">
                    <label for="new_description" class="form-label mb-1" style="color: black">Template Privacy</label>
                    <select class="js-example-basic-single" id="publish_type" name="publish_type" style="width: 10%">
                        <option value="0">Private</option>
                        <option value="1">Public</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger  " data-dismiss="modal" >Close</button>
                    <button type="submit" id="submit_btn_text" class="btn btn-success">Save</button>
                </div>
            </form>
      </div>
    </div>
</div>
  <script src="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.4/dist/quill.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.4/dist/quill.snow.css" rel="stylesheet">
  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/quill-image-resize-module"></script>
  <script src="https://cdn.jsdelivr.net/npm/quill-delta-to-html@0.12.1/dist/browser/QuillDeltaToHtmlConverter.bundle.min.js"></script>



<script>

  $(document).ready(function() {


  $('.js-example-basic-single').on('change', function() {
    var selectedValue = $(this).val();
    var renderedElement = $(this).next('.select2-container').find('.select2-selection__rendered');

    if (selectedValue === '0') {
      renderedElement.css('background-color', '#fc595970'); // Set background color for Private
    } else if (selectedValue === '1') {
      renderedElement.css('background-color', 'rgb(132, 255, 132)'); // Set background color for Public
    }
  });
});
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
    $(document).ready(function () {

     Quill.register('modules/imageDrop', ImageDrop);
        var cleanButton = $('button.ql-clean');
        cleanButton.attr('title', 'Clear styles');
    });

    var quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                imageResize: {
                  modules: ['Resize', 'DisplaySize', 'Toolbar']
                        },
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'], // Text styles
                    [{ 'color': [] }, { 'background': [] }], // Font color
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }], // Lists
                    [{ 'size': ['small', false, 'large', 'huge'] }], // Font size
                    [{ 'align': [] }], // Alignment options
                    ['link', 'image'], // Add images
                    ['clean'] // Remove formatting
                ]
            }
        });
        // Handle form submission
        $('#email_template_create_form').on('submit', function(event) {
            // Prevent default form submission
            event.preventDefault();

            // Get the current contents of the Quill editor
            var delta = quill.getContents();

            // Convert Delta format to JSON string for saving to the database
            var jsonContent = JSON.stringify(delta);
            var escapedJsonContent = jsonContent.replace(/'/g, "&apos;");
            // Add Quill editor content to form data
            $(this).append('<input type="hidden" name="templatecontent" value=\'' + escapedJsonContent + '\' />');

            // Submit the form
            this.submit();
        });


        // Handle changes in the Quill editor and update the hidden input
        quill.on('text-change', function() {
            // Manually insert line breaks within the same <p> tag
            var htmlContent = document.querySelector('.ql-editor').innerHTML.replace(/<div>/g, '').replace(/<\/div>/g, '<br>');
            document.getElementById('template_body').value = htmlContent;
            // console.log(htmlContent);
        });

    // Clear formatting button functionality
    document.getElementById('clear-formatting').addEventListener('click', function() {
        quill.format('bold', false);
        quill.format('italic', false);
        quill.format('underline', false);
        quill.format('strike', false);
        quill.format('color', false);
        quill.format('size', false);
    });
</script>
