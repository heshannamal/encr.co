<style>
.form-group {
    margin-bottom:0px !important;
}

.form-group label {
    font-weight: bold;
}

.select2-container .select2-selection--multiple {
    border: 1px solid #ccc;
    border-radius: 4px;
}

.select2-container .select2-selection--multiple .select2-selection__rendered {
    padding: 5px 10px;
    min-height: 38px;
    overflow-y: auto;
    border-bottom: 0.5px solid #eaeaea;
}

.select2-container .select2-selection--multiple .select2-search__field {
    background-color: transparent;
    border-bottom: none;
    outline: none;
    box-shadow: none;
    padding: 0;
    margin: 0;
    font-size: 14px;
    line-height: 1.5;
}
.displayflex{
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
}


</style>
<div class="modal fade" id="modal-compose" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal- modal-m" role="document" style="position: fixed; bottom: 20px; right: 40px;align-items: flex-end;min-width:600px">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">New Message</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">

                <form action="{{ route('mailSend') }}" method="post" enctype="multipart/form-data" id="email_template_create_form">
                    @csrf
                    <input type="hidden" id="template_id" name="template_id" value="">

                    <div class="col-md-12 form-group displayflex" >
                        <label for="contactSearchInput" style="width:5%">To:</label>
                        <select class="form-control info-form-input mt-2 recipient-input" name="recipient[]" multiple="multiple" id="toRecipientInput" style="width: 95%" aria-placeholder="To">
                        </select>
                    </div>
                    <div class=" col-md-12 form-group displayflex">
                        <label for="ccSearchInput" style="width:5%">Cc:</label>
                        <select class="form-control info-form-input mt-2 cc-input" name="cc[]" multiple="multiple" id="ccRecipientInput" style="width:95%">
                        </select>
                    </div>
                    <div class="col-md-12 form-group displayflex">
                        <label for="bccSearchInput" style="width:5%">Bcc:</label>
                        <select class="form-control info-form-input mt-2 bcc-input" name="bcc[]" multiple="multiple" id="bccRecipientInput" style="width:95%">
                        </select>
                    </div>


                    <div class="col-md-12 mt-2 ">
                        {{-- <label class="form-lable-info form-label" style="width:5%">Subject</label> --}}
                        <input type="text" class="form-control info-form-input mt-2" id="template_subject" name="subject" value="" placeholder="Subject" >
                    </div>
                    <div class="col-md-12 mt-3 mb-1">
                        <label for="new_description" class="form-label mb-1" style="color: black">Email Body</label>
                        <div id="editor-container" style="height: 200px;"></div>
                        <input type="hidden" id="email_body" name="email_body">
                    </div>
                    <input type="file" id="attachment" name="attachments" style="display: none;" multiple>
                    <div class="modal-footer">
                        <div id="file-names-container" style="max-height: 50px;overflow-y: scroll;margin-right: auto;"></div>
                        <label for="attachment" class="btn">
                            <i class="fa fa-paperclip fa-lg" aria-hidden="true"></i>
                        </label>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit_btn_text" class="btn btn-success">Send</button>
                    </div>
                </form>
            </div>

            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
            </div> --}}

        </div>
    </div>
</div>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<!-- Include jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Include Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.4/dist/quill.js"></script>
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.4/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill-image-resize-module"></script>
<script src="https://cdn.jsdelivr.net/npm/quill-delta-to-html@0.12.1/dist/browser/QuillDeltaToHtmlConverter.bundle.min.js"></script>
<script>
   $(document).ready(function() {
// Function to clear the form inputs
        function clearFormInputs() {
                // Clear recipient inputs
                $('.recipient-input').val('').trigger('change');
                $('.cc-input').val('').trigger('change');
                $('.bcc-input').val('').trigger('change');

                // Clear subject and email body inputs
                $('#template_subject').val('');
                quill.setContents('');
        }

            // Event listener for when the modal is hidden
        $('#modal-compose').on('hidden.bs.modal', function () {
            // Clear form inputs when the modal is hidden
            clearFormInputs();
        });
        // Declare quill outside the scope of any functions to make it accessible globally within this file
        // Import Quill and the Block class
        const Quill = window.Quill;
        const Block = Quill.import('blots/block');

        // Extend the Block class to use <div> instead of <p>
        Block.tagName = 'DIV';
        Quill.register(Block, true);

        // Custom blot for <br> (line break)
        class Break extends Quill.import('blots/embed') {
            static blotName = 'br';
            static tagName = 'br';

            static create() {
                return super.create();
            }

            length() {
                return 1;
            }

            value() {
                return '\n';
            }
        }

        // Custom blot for <div> (new paragraph)
        class DivBlot extends Quill.import('blots/block') {
            static blotName = 'div';
            static tagName = 'div';
        }

        // Register the Break and Div blots
        Quill.register(Break);
        Quill.register(DivBlot);

        // Initialize the Quill editor
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                imageResize: {
                    modules: ['Resize', 'DisplaySize', 'Toolbar']
                },
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'], // Text styles
                    [{ 'color': [] }, { 'background': [] }], // Font color
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }], // Lists
                    [{ 'size': ['small', false, 'large', 'huge'] }], // Font size
                    [{ 'align': [] }], // Alignment options
                    ['link', 'image'], // Add images
                    ['clean'] // Remove formatting
                ]
            },
            clipboard: {
                matchers: [
                    // Matcher for <p> tags to convert to <div>
                    ['P', function (node, delta) {
                        delta.ops.forEach(function (op) {
                            if (op.insert && typeof op.insert === 'string') {
                                op.insert = op.insert.replace(/\n/g, '');
                            }
                        });
                        return delta;
                    }]
                ]
            },
            keyboard: {
                bindings: {
                    // Override Enter key behavior for new paragraphs using <div>
                    enter: {
                        key: 13,
                        handler: function (range, context) {
                            if (context.format.list) {
                                // Maintain list behavior if inside a list
                                this.quill.format('list', context.format.list);
                            } else {
                                // Insert a new <div> block for a new paragraph
                                const currentFormat = this.quill.getFormat(range.index);
                                this.quill.insertEmbed(range.index, 'div', true, Quill.sources.USER);
                                this.quill.insertText(range.index + 1, '\n', Quill.sources.USER);
                                this.quill.formatText(range.index + 2, 1, currentFormat, Quill.sources.USER);
                                this.quill.setSelection(range.index + 2, Quill.sources.SILENT);
                            }
                            return false; // Prevent default behavior
                        }
                    },
                    // Override Shift+Enter key behavior for line breaks
                    'shift+enter': {
                        key: 13,
                        shiftKey: true,
                        handler: function (range) {
                            // Insert a line break
                            this.quill.insertEmbed(range.index, 'br', true, Quill.sources.USER);
                            this.quill.setSelection(range.index + 1, Quill.sources.SILENT);
                            return false; // Prevent default behavior
                        }
                    }
                }
            }
        });

        $(document).on('click', '.my-template-use', function() {
            var template_id = $(this).data('template_id');
            console.log(template_id);
            $.ajax({
                url: "{{ url('email/templates/edit') }}/" + template_id,
                method: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function(data) {
                    if (data.body) {
                        try {
                            var bodyData = JSON.parse(data.body); // Parse the body string as JSON
                            if (bodyData.ops) {
                                console.log(data);
                                // Use the existing Quill instance (declared globally) to set the content
                                quill.setContents(bodyData.ops);
                            } else {
                                console.error("Invalid data format: ops property missing");
                                // Handle invalid data format
                            }
                        } catch (error) {
                            console.error("Error parsing body data:", error);
                            // Handle parsing error
                        }
                    } else {
                        console.error("Invalid data format: body property missing");
                        // Handle invalid data format
                    }
                },
                complete: function() {
                    $('#mailtemplateModal').modal('hide');
                    $('#modal-compose').modal('show');
                    $(".se-pre-con").fadeOut('slow');
                },
                error: function(xhr, status, error) {
                    console.error("Error occurred during AJAX request:", error);
                    // Handle AJAX error
                }
            });
        });
});

</script>
<script>

    $(document).ready(function() {
        // Array to store selected files
        var selectedFiles = [];

        // Function to update the list of selected file names
        function updateFileList() {
            // Container to hold the file names
            var fileNamesContainer = $('#file-names-container');
            // Clear any previous file names
            fileNamesContainer.empty();
            // Loop through the selected files and display their names
            for (var i = 0; i < selectedFiles.length; i++) {
                // Create a new <div> element for each file name
                var fileNameElement = $('<div>').addClass('file-name');
                // Create a <span> element to display the file name
                var nameSpan = $('<span>').text(selectedFiles[i].name);
                // Create a <i> element for the remove icon
                var removeIcon = $('<i>').addClass('fa fa-times remove-icon').attr('data-index', i);
                // Append the file name and remove icon to the container
                fileNameElement.append(nameSpan, removeIcon);
                fileNamesContainer.append(fileNameElement);
            }
        }

        // Add event listener to the file input field
        $('#attachment').change(function() {
            // Get the selected files
            var files = $(this)[0].files;
            // Loop through the selected files and add them to the selectedFiles array
            for (var i = 0; i < files.length; i++) {
                selectedFiles.push(files[i]);
            }
            // Update the list of selected file names
            updateFileList();
        });

        // Add event listener to remove icon to remove files from the list
        $(document).on('click', '.remove-icon', function() {
            var index = $(this).data('index');
            selectedFiles.splice(index, 1); // Remove file from selectedFiles array
            updateFileList(); // Update the list of selected file names
        });
    });
</script>
<script>
    $(document).ready(function() {
    function getQuillContent() {
        return quill.root.innerHTML; // Assuming "quill" is your Quill editor instance
    }
    $('#email_template_create_form').submit(function(event) {
        event.preventDefault(); // Prevent the form from submitting normally
        var quillContent = getQuillContent();
        // Log the Quill content to the console
        console.log(quillContent);
        $('#email_body').val(quillContent);
        // Get the form data
        var formData = new FormData($(this)[0]);

        // Make an AJAX request to send the email
        $.ajax({
            url: "{{ route('mailSend') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // Handle the success response
                console.log(response);
                // You can display a success message or redirect the user here
            },
            error: function(xhr, status, error) {
                // Handle the error response
                console.error(xhr.responseText);
                // You can display an error message to the user here
            }
        });
    });
});
   $(document).ready(function() {

    // Initialize Select2 for To recipients
    $('#toRecipientInput').select2({
        placeholder: 'To recipients...',
        ajax: {
            url: "{{ url('/searchcontacts') }}/",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term
                };
            },
            processResults: function(data) {
                var options = $.map(data, function(item) {
                    return {
                        id: item.id,
                        text: item.text
                    };
                });
                return { results: options };
            },
            cache: true
        },
        minimumInputLength: 2,
        tags: true
    });

    // Initialize Select2 for CC recipients
    $('#ccRecipientInput').select2({
        placeholder: 'CC recipients...',
        ajax: {
            url: "{{ url('/searchcontacts') }}/",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term
                };
            },
            processResults: function(data) {
                var options = $.map(data, function(item) {
                    return {
                        id: item.id,
                        text: item.text
                    };
                });
                return { results: options };
            },
            cache: true
        },
        minimumInputLength: 2,
        tags: true
    });

    // Initialize Select2 for BCC recipients
    $('#bccRecipientInput').select2({
        placeholder: 'BCC recipients...',
        ajax: {
            url: "{{ url('/searchcontacts') }}/",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term
                };
            },
            processResults: function(data) {
                var options = $.map(data, function(item) {
                    return {
                        id: item.id,
                        text: item.text
                    };
                });
                return { results: options };
            },
            cache: true
        },
        minimumInputLength: 2,
        tags: true
    });

    // Handle selection event for To recipients
    $('#toRecipientInput').on('select2:select', function(e) {
        var data = e.params.data;
        // Handle selection for To recipients...
    });

    // Handle selection event for CC recipients
    $('#ccRecipientInput').on('select2:select', function(e) {
        var data = e.params.data;
        // Handle selection for CC recipients...
    });

    // Handle selection event for BCC recipients
    $('#bccRecipientInput').on('select2:select', function(e) {
        var data = e.params.data;
        // Handle selection for BCC recipients...
    });
});


    $(document).ready(function() {
        // Initialize Select2 for recipient input
        $('#recipient-select').select2();

        // Function to update recipient labels based on user input
        function updateRecipientLabels() {
            var recipients = $('#recipient-select').val();
            var toLabel = $('#to-label');

            toLabel.html('To');

            if (recipients !== null && recipients.length > 0) {
                toLabel.html('To: ' + recipients.join(', '));
            }
        }

        // Add event listener to Select2 for recipient input to update labels
        $('#recipient-select').on('change', function() {
            updateRecipientLabels();
        });

        // Add initial event listener to update labels
        updateRecipientLabels();
    });
</script>
