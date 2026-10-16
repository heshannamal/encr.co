<style>
    .form-group {
        margin-bottom:0px !important;
    }

    .form-group label {
        font-weight: bold;
    }

    .modal-reply.select2-container .select2-selection--multiple {
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .modal-reply.select2-container .select2-selection--multiple .select2-selection__rendered {
        padding: 5px 10px;
        min-height: 38px;
        overflow-y: auto;
        border-bottom: 0.5px solid #eaeaea;
    }

    .modal-reply.select2-container .select2-selection--multiple .select2-search__field {
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
    .custom-btn-style{
        font-size: .675rem !important;
        font-weight: 400 !important;
        padding: .325rem 0.5rem !important;
    }




    </style>
    <div class="modal fade modal-reply" id="modal-reply" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal- modal-lg" role="document" >
            <div class="modal-content">

                <div class="modal-header">
                    <h3 class="modal-title" id="modal-title-default-reply">Reply Message</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">

                        <meta name="csrf-token" content="{{ csrf_token() }}">

                        <input type="hidden" id="template_id" name="template_id" value="">

                        <div class="col-md-12">
                            <table style="width: 100%">
                                <tbody>
                                    <tr style="height: 3rem;">
                                        <td style="width: 5%;">
                                            <label for="contactSearchInput" style="width:5%">To:</label>
                                        </td>
                                        <td>
                                            <select class="form-control info-form-input mt-2 recipient-input" name="recipient[]" multiple="multiple" id="replytoRecipientInput" style="width: 95%" aria-placeholder="To">
                                            </select>
                                        </td>
                                    </tr>
                                    <tr style="height: 3rem;">
                                        <td style="width: 5%;">
                                            <label for="ccSearchInput" style="width:5%">Cc:</label>
                                        </td>
                                        <td>
                                            <select class="form-control info-form-input mt-2 cc-input" name="cc[]" multiple="multiple" id="replyccRecipientInput" style="width:95%">
                                            </select>
                                        </td>
                                    </tr>
                                    <tr style="height: 3rem;">
                                        <td style="width: 5%;">
                                            <label for="bccSearchInput" style="width:5%">Bcc:</label>
                                        </td>
                                        <td>
                                            <select class="form-control info-form-input mt-2 bcc-input" name="bcc[]" multiple="multiple" id="replybccRecipientInput" style="width:95%">
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <hr style="margin: .7rem;">

                        <div class="col-md-12 mt-2 ">
                            <input type="text" style="height: 2.5rem;" class="form-control info-form-input mt-2" id="reply_head_subject" name="subject" value="" placeholder="Subject" >
                        </div>
                        <div class="to-field col-12 " style="display:none;" id="template-section">
                            <div >
                                <div class="col-md-12" style="padding: 10px;padding-left: 0;"><button type="button"  class="btn-green-filled customBtn-DroupDown2">Pick template</button></div>
                                <div id="myDropdown2" class="dropdown-content">
                                <input type="text" placeholder="Search.." id="myInput2" onkeyup="filterFunction2()">

                                @foreach ($emailTemplates as $item )
                                    <p style="margin-left: 10px;" class="pick-template-reply" data-template_id="{{$item['id']}}"> {{$item['title']}}</p>
                                @endforeach
                                @if (isset($AddedEmailTemplates))
                                    @foreach ($AddedEmailTemplates as $item )
                                        <p style="margin-left: 10px;" class="pick-template-reply" data-template_id="{{$item['id']}}"> {{$item['title']}}</p>
                                    @endforeach
                                @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3 mb-1">
                            <label for="new_description" class="form-label mb-1" style="color: black">Email Body</label>
                            <label for="draftsavealert" id="draftsavealert" class="form-label mb-1" style="color: rgb(95, 95, 95); width: fit-content; margin-right: 10px;margin-left: auto;font-size: .8rem;"></label>
                            <div id="reply-modal-editor-container" style="height: 200px;max-width: unset !important;" class="col"></div>
                            <input type="hidden" id="email_body-replymessage" name="email_body">
                        </div>
                        <input type="file" id="attachmentreply" name="attachments" style="display: none;" multiple>
                        <input type="hidden" id="Draftmessageid" name="Draftmessageid" style="display: none;" value="">
                        <input type="hidden" id="SavedDraftIdReply" name="SavedDraftIdReply"  value="">
                        <input type="hidden" id="SavedDraftId" name="SavedDraftId"  value="">
                        <div class="modal-footer">
                            <div id="file-names-container-reply" style="max-height: 50px;overflow-y: scroll;margin-right: auto;"></div>
                            <button type="button" class="btn btn-danger custom-btn-style" data-dismiss="modal"><i class="fa fa-close " style="margin-right: 2px" aria-hidden="true" ></i> Close</button>
                            <label for="attachmentreply" class="btn btn-info custom-btn-style" style="margin-bottom: unset !important;">
                                <i class="fa fa-paperclip" aria-hidden="true" style="margin-right: 2px"></i>Attach
                            </label>
                            <button type="button"  id="save-draft-reply" data-message_id=""  class="btn btn-secondary custom-btn-style custome-color"><i class="fa fa-floppy-o " style="margin-right: 2px" aria-hidden="true" ></i>Save Draft</button>
                            <button type="button"  id="save-draft-forward" data-message_id=""  class="btn btn-secondary custom-btn-style custome-color"><i class="fa fa-floppy-o " style="margin-right: 2px" aria-hidden="true" ></i>Save Draft</button>
                            <button type="button"  id="save-template-org" class="btn btn-secondary custom-btn-style custome-color"><i class="fa fa-plus " style="margin-right: 2px" aria-hidden="true" ></i>Add to Template</button>
                            <button type="button" id="reply-btn-send" data-action="Send" data-message_id=""  class="btn btn-success reply-btn-send custom-btn-style"><i class="fa fa-send " style="margin-right: 2px" aria-hidden="true" ></i>Send</button>
                            <button type="button" id="reply-btn-forward" data-action="Forward" data-message_id="" class="btn btn-success reply-btn-send custom-btn-style"><i class="fa fa-share " style="margin-right: 2px" aria-hidden="true" ></i>Forward</button>
                            <button type="button" id="btn-compose" data-action="Send Mail" class="btn btn-success reply-btn-send custom-btn-style compose-btn-new"><i class="fa fa-send " style="margin-right: 2px" aria-hidden="true" ></i>Send</button>
                            <button type="button" id="btn-compose-draft" data-action="Send Mail" class="btn btn-success reply-btn-send custom-btn-style draft-compose-btn-new"><i class="fa fa-send " style="margin-right: 2px" aria-hidden="true" ></i>Send</button>
                        </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Modal for template create confrmation -->
    <div class="modal fade" id="templatetitle-org" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Template Settings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table style="width: 95%;margin-left:auto;margin-right:auto" >
                        <tr style="    height: 65px;">
                            <td style="width: 20%"> <label for="template_title_get">Template Title</label></td>
                            <td style="width: auto"><input type="text" class="form-control info-form-input color-set" id="template_title_get-org" name="title" value="" style="width:100%;height: 2.5rem;"></td>
                        </tr>
                        <tr style="    height: 65px;">
                            <td style="width: 20%"> <label>Publish Type</label></td>
                            <td style="width: auto">
                                <select class="js-example-basic-single " id="mail_template_publish_type-org" name="publish_type" style="width: 100%;">
                                    <option value="0">Private</option>
                                    <option value="1">Public</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger custom-btn-style" data-dismiss="modal">
                        <i class="fa fa-close" style="margin-right: 2px" aria-hidden="true"></i>Close
                    </button>
                    <button type="button" id="confirmcreateButton-org" class="btn btn-success custom-btn-style">
                        <i class="fa fa-plus" style="margin-right: 2px" aria-hidden="true"></i>Create
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.4/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.4/dist/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill-image-resize-module"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill-delta-to-html@0.12.1/dist/browser/QuillDeltaToHtmlConverter.bundle.min.js"></script>
    <!-- After quill script includes -->
<script src="https://unpkg.com/quill-magic-url@3.0.0/dist/index.js"></script>
    <script>

       $(document).ready(function() {
        $('#mail_template_publish_type-org').select2({
            placeholder: "Select publish type"
        });
            function clearFormInputs() {
                    $('.recipient-input').val('').trigger('change');
                    $('.cc-input').val('').trigger('change');
                    $('.bcc-input').val('').trigger('change');

                    $('#template_subject').val('');
                    quill.setContents('');
            }


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
                                var bodyData = JSON.parse(data.body);
                                if (bodyData.ops) {
                                    console.log(data);
                                    quill.setContents(bodyData.ops);
                                } else {
                                    console.error("Invalid data format: ops property missing");
                                }
                            } catch (error) {
                                console.error("Error parsing body data:", error);
                            }
                        } else {
                            console.error("Invalid data format: body property missing");
                        }
                    },
                    complete: function() {
                        $('#mailtemplateModal').modal('hide');
                        $('#modal-compose').modal('show');
                        $(".se-pre-con").fadeOut('slow');
                    },
                    error: function(xhr, status, error) {
                        console.error("Error occurred during AJAX request:", error);
                    }
                });
            });
    });

    </script>
    <script>

        $(document).ready(function() {
            var selectedFiles = [];

            function updateFileList() {
                var fileNamesContainer = $('#file-names-container-reply');
                fileNamesContainer.empty();
                for (var i = 0; i < selectedFiles.length; i++) {
                    var fileNameElement = $('<div>').addClass('file-name');
                    var nameSpan = $('<span>').text(selectedFiles[i].name);
                    var removeIcon = $('<i>').addClass('fa fa-times remove-icon').attr('data-index', i);
                    fileNameElement.append(nameSpan, removeIcon);
                    fileNamesContainer.append(fileNameElement);
                }
            }

            $('#attachmentreply').change(function() {
                var files = $(this)[0].files;
                for (var i = 0; i < files.length; i++) {
                    selectedFiles.push(files[i]);
                }
                updateFileList();
            });

            $(document).on('click', '.remove-icon', function() {
                var index = $(this).data('index');
                selectedFiles.splice(index, 1);
                updateFileList();
            });
        });
    </script>
    <script>

       $(document).ready(function() {

        $('#replytoRecipientInput').select2({
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
                    console.log("added email ",data);
                    var options = $.map(data, function(item) {
                        return {
                            id: item.text,
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
        // ✅ Email validation after selection
        $('#replytoRecipientInput').on('select2:select', function (e) {
            const selectedEmail = e.params.data.id;
            var org_id = $('#organization_id').val();
            const BASE_URL = "{{ url('/') }}";
            $.ajax({
                url: "{{ url('check/email/organization') }}",
                type: 'POST',
                data: {
                    org_id:org_id,
                    email: selectedEmail,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.linked_to_another_org) {
                        // Remove email from select
                        let $select = $('#replytoRecipientInput');
                        let updated = $select.val().filter(val => val !== selectedEmail);
                        $select.val(updated).trigger('change');

                        // Create clickable list of orgs
                        const linksHtml = response.org_list.map(org =>
                            `<li><a href="${BASE_URL}/organizations/info/${org.id}" target="_blank">${org.name}</a></li>`
                        ).join('');

                        Swal.fire({
                            title: 'Email belongs to another organization',
                            html: `
                                <p>The selected email is linked to the following organization(s):</p>
                                <ul style="text-align: left;">
                                    ${linksHtml}
                                </ul>
                            `,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        });

        $('#replyccRecipientInput').select2({
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
                            id: item.text,
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

        $('#replybccRecipientInput').select2({
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
                            id: item.text,
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


    });


        $(document).ready(function() {
            $('#recipient-select').select2();

            function updateRecipientLabels() {
                var recipients = $('#recipient-select').val();
                var toLabel = $('#to-label');

                toLabel.html('To');

                if (recipients !== null && recipients.length > 0) {
                    toLabel.html('To: ' + recipients.join(', '));
                }
            }

            $('#recipient-select').on('change', function() {
                updateRecipientLabels();
            });

            updateRecipientLabels();
        });
    </script>
    <script>
        $(document).on('click', '.reply-all-head', function() {
                var MessageId = $(this).data('messageid');
                console.log(MessageId);
                var maildata = '';
                var azureLoggedUser = '{{ session("azure_logged_email") }}';
                $.ajax({
                    url: '{{ url('get/message') }}/' + MessageId,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('fast');
                    },
                    success: function(response) {
                        maildata = response;
                        if(maildata){
                            $('#reply_head_subject').val(maildata.subject);
                            if (maildata.sender !== azureLoggedUser) {
                                var newOption = $('<option>', {
                                    value: maildata.sender,
                                    text: maildata.sender,
                                    selected: true
                                });

                                $('#replytoRecipientInput').append(newOption);
                            }
                            function populateSelect(selector, data) {
                                var $select = $(selector);

                                $.each(data, function(index, recipient) {
                                    var newOption = $('<option>', {
                                        value: recipient.emailAddress.address,
                                        text: recipient.emailAddress.address,
                                        selected: true
                                        });

                                        console.log('newOption :'+recipient.emailAddress.address);
                                        $(selector).append(newOption);
                                });
                            }

                            populateSelect('#replyccRecipientInput', maildata.cc);
                            populateSelect('#replybccRecipientInput', maildata.bcc);
                            populateSelect('#replytoRecipientInput', maildata.to);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    },
                    complete: function () {
                        // Import Quill and the Block blot
                        const Quill = window.Quill;
                        const Block = Quill.import('blots/block');

                        // Extend the Block class to use <div> instead of <p>
                        Block.tagName = 'DIV';
                        Quill.register(Block, true);

                        // Create a new Quill instance with customized options
                        const replymodalquill = new Quill('#reply-modal-editor-container', {
                            theme: 'snow',
                            modules: {
                                imageResize: {
                                    modules: ['Resize', 'DisplaySize', 'Toolbar']
                                },
                                toolbar: [
                                    ['bold', 'italic', 'underline', 'strike'],
                                    [{ 'color': [] }, { 'background': [] }],
                                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                                    [{ 'size': ['small', false, 'large', 'huge'] }],
                                    [{ 'align': [] }],
                                    ['link', 'image'],
                                    ['clean']
                                ],
                                magicUrl: true,
                                clipboard: {
                                    matchers: [
                                        // Matcher for P tags to strip newline characters
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
                                        // Override Enter key behavior for new paragraphs
                                        enter: {
                                            key: 13,
                                            handler: function (range, context) {
                                                if (context.format.list) {
                                                    // Maintain list behavior if inside a list
                                                    this.quill.format('list', context.format.list);
                                                } else {
                                                    // Insert a new <div> block
                                                    const currentFormat = this.quill.getFormat(range.index);
                                                    this.quill.insertText(range.index, '\n', Quill.sources.USER);
                                                    this.quill.formatText(range.index + 1, 1, currentFormat, Quill.sources.USER);
                                                    this.quill.setSelection(range.index + 1, Quill.sources.SILENT);
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
                            }
                        });
                        $.ajax({
                            url: "{{ url('/get/email/signature') }}",
                            type: 'GET',
                            dataType: 'json',
                            beforeSend: function () {
                                $(".se-pre-con").fadeIn('fast');
                            },
                            success: function(response) {
                            console.log(response);
                            if (response.length > 0) {

                                var bodyData = JSON.parse(response[0].signature);
                                var quillContents = [{ insert: '\n\n\n\n\n' }].concat(bodyData.ops);
                                replymodalquill.setContents(quillContents);
                            }


                            },
                            error: function(xhr, status, error) {
                                console.error('Error:', error);
                            },
                            complete: function () {
                                $(".se-pre-con").fadeOut('fast');

                            }
                        });
                        $(".se-pre-con").fadeOut('fast');
                        $('#modal-title-default-reply').text('Reply All Message');
                        $('#reply-btn-send').attr('data-message_id', MessageId);
                        $('#save-draft-reply').attr('data-message_id', MessageId);
                        const sendBtn = document.getElementById('reply-btn-send');
                        const DraftsendBtn = document.getElementById('save-draft-reply');
                        const composeBtn = document.getElementById('btn-compose');
                        const composeBtnDraft = document.getElementById('btn-compose-draft');
                        const forwardBtn = document.getElementById('reply-btn-forward');
                        const DraftforwardBtn = document.getElementById('save-draft-forward');
                        $('#template-section').show();
                        if (!forwardBtn.classList.contains('hidden')) {
                            forwardBtn.classList.add('hidden');
                        }
                        if (!composeBtn.classList.contains('hidden')) {
                            composeBtn.classList.add('hidden');
                        }
                        if (!composeBtnDraft.classList.contains('hidden')) {
                            composeBtnDraft.classList.add('hidden');
                        }
                        if (sendBtn.classList.contains('hidden')) {
                            sendBtn.classList.remove('hidden');
                        }
                        if (!DraftforwardBtn.classList.contains('hidden')) {
                            DraftforwardBtn.classList.add('hidden');
                        }
                        if (DraftsendBtn.classList.contains('hidden')) {
                            DraftsendBtn.classList.remove('hidden');
                        }
                        $('#modal-reply').modal('show');

                    }
                });

            });
            $('#modal-reply').on('hidden.bs.modal', function () {

                $('#replytoRecipientInput').val(null).trigger('change');

                $('#replyccRecipientInput').val(null).trigger('change');

                $('#replybccRecipientInput').val(null).trigger('change');

                $('#reply_head_subject').val('');

                $('#SavedDraftIdReply').val('');
                $('#SavedDraftId').val('');
                $('#Draftmessageid').val('');
            });
            $(document).on('click', '.reply-head', function() {
                var MessageId = $(this).data('messageid');
                console.log(MessageId);
                var maildata = '';
                $.ajax({
                    url: '{{ url('get/message') }}/' + MessageId,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('fast');
                    },
                    success: function(response) {
                        maildata = response;
                        if(maildata){
                            console.log(maildata);
                            $('#reply_head_subject').val(maildata.subject);
                            var newOption = $('<option>', {
                                            value: maildata.sender,
                                            text: maildata.sender,
                                            selected: true
                                        });

                            $('#replytoRecipientInput').append(newOption);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    },
                    complete: function () {
                        // Import Quill and the Block blot
                        const Quill = window.Quill;
                        const Block = Quill.import('blots/block');

                        // Extend the Block class to use <div> instead of <p>
                        Block.tagName = 'DIV';
                        Quill.register(Block, true);

                        // Create a new Quill instance with customized options
                        const replymodalquill = new Quill('#reply-modal-editor-container', {
                            theme: 'snow',
                            modules: {
                                imageResize: {
                                    modules: ['Resize', 'DisplaySize', 'Toolbar']
                                },
                                toolbar: [
                                    ['bold', 'italic', 'underline', 'strike'],
                                    [{ 'color': [] }, { 'background': [] }],
                                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                                    [{ 'size': ['small', false, 'large', 'huge'] }],
                                    [{ 'align': [] }],
                                    ['link', 'image'],
                                    ['clean']
                                ],
                                magicUrl: true,
                                clipboard: {
                                    matchers: [
                                        // Matcher for P tags to strip newline characters
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
                                        // Override Enter key behavior for new paragraphs
                                        enter: {
                                            key: 13,
                                            handler: function (range, context) {
                                                if (context.format.list) {
                                                    // Maintain list behavior if inside a list
                                                    this.quill.format('list', context.format.list);
                                                } else {
                                                    // Insert a new <div> block
                                                    const currentFormat = this.quill.getFormat(range.index);
                                                    this.quill.insertText(range.index, '\n', Quill.sources.USER);
                                                    this.quill.formatText(range.index + 1, 1, currentFormat, Quill.sources.USER);
                                                    this.quill.setSelection(range.index + 1, Quill.sources.SILENT);
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
                            }
                        });
                        $.ajax({
                            url: "{{ url('/get/email/signature') }}",
                            type: 'GET',
                            dataType: 'json',
                            beforeSend: function () {
                                $(".se-pre-con").fadeIn('fast');
                            },
                            success: function(response) {
                            console.log(response);
                            if (response.length > 0) {

                                var bodyData = JSON.parse(response[0].signature);
                                var quillContents = [{ insert: '\n\n\n\n\n' }].concat(bodyData.ops);
                                replymodalquill.setContents(quillContents);
                            }


                            },
                            error: function(xhr, status, error) {
                                console.error('Error:', error);
                            },
                            complete: function () {
                                $(".se-pre-con").fadeOut('fast');

                            }
                        });
                        $(".se-pre-con").fadeOut('fast');
                        $('#reply-btn-send').attr('data-message_id', MessageId);
                        $('#save-draft-reply').attr('data-message_id', MessageId);
                        const sendBtn = document.getElementById('reply-btn-send');
                        const DraftsendBtn = document.getElementById('save-draft-reply');
                        const forwardBtn = document.getElementById('reply-btn-forward');
                        const composeBtn = document.getElementById('btn-compose');
                        const composeBtnDraft = document.getElementById('btn-compose-draft');
                        const draftforwardBtn = document.getElementById('save-draft-forward');
                        $('#template-section').show();
                        if (!forwardBtn.classList.contains('hidden')) {
                            forwardBtn.classList.add('hidden');
                        }
                        if (!composeBtn.classList.contains('hidden')) {
                            composeBtn.classList.add('hidden');
                        }
                        if (!composeBtnDraft.classList.contains('hidden')) {
                            composeBtnDraft.classList.add('hidden');
                        }
                        if (sendBtn.classList.contains('hidden')) {
                            sendBtn.classList.remove('hidden');
                        }
                        if (!draftforwardBtn.classList.contains('hidden')) {
                            draftforwardBtn.classList.add('hidden');
                        }
                        if (DraftsendBtn.classList.contains('hidden')) {
                            DraftsendBtn.classList.remove('hidden');
                        }


                        $('#modal-title-default-reply').text('Reply Message');
                        $('#modal-reply').modal('show');

                    }
                });
            });
            $(document).on('click', '.forward-head', function() {
                var MessageId = $(this).data('messageid');
                console.log(MessageId);
                var maildata = '';
                $.ajax({
                    url: '{{ url('get/message') }}/' + MessageId,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('fast');
                    },
                    success: function(response) {
                        maildata = response;
                        console.log(maildata);
                        $('#reply_head_subject').val(maildata.subject);
                        const composeBtn = document.getElementById('btn-compose');
                        const composeBtnDraft = document.getElementById('btn-compose-draft');
                        if (!composeBtn.classList.contains('hidden')) {
                            composeBtn.classList.add('hidden');
                        }
                        if (composeBtnDraft.classList.contains('hidden')) {
                            composeBtnDraft.classList.remove('hidden');
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    },
                    complete: function () {
                        // Import Quill and the Block blot
                        const Quill = window.Quill;
                        const Block = Quill.import('blots/block');

                        // Extend the Block class to use <div> instead of <p>
                        Block.tagName = 'DIV';
                        Quill.register(Block, true);

                        // Create a new Quill instance with customized options
                        const replymodalquill = new Quill('#reply-modal-editor-container', {
                            theme: 'snow',
                            modules: {
                                imageResize: {
                                    modules: ['Resize', 'DisplaySize', 'Toolbar']
                                },
                                toolbar: [
                                    ['bold', 'italic', 'underline', 'strike'],
                                    [{ 'color': [] }, { 'background': [] }],
                                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                                    [{ 'size': ['small', false, 'large', 'huge'] }],
                                    [{ 'align': [] }],
                                    ['link', 'image'],
                                    ['clean']
                                ],
                                magicUrl: true,
                                clipboard: {
                                    matchers: [
                                        // Matcher for P tags to strip newline characters
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
                                        // Override Enter key behavior for new paragraphs
                                        enter: {
                                            key: 13,
                                            handler: function (range, context) {
                                                if (context.format.list) {
                                                    // Maintain list behavior if inside a list
                                                    this.quill.format('list', context.format.list);
                                                } else {
                                                    // Insert a new <div> block
                                                    const currentFormat = this.quill.getFormat(range.index);
                                                    this.quill.insertText(range.index, '\n', Quill.sources.USER);
                                                    this.quill.formatText(range.index + 1, 1, currentFormat, Quill.sources.USER);
                                                    this.quill.setSelection(range.index + 1, Quill.sources.SILENT);
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
                            }
                        });

                        // Custom blot for <br>
                        class Break extends Quill.import('blots/embed') {
                            static blotName = 'br';
                            static tagName = 'br';

                            static create() {
                                let node = super.create();
                                return node;
                            }

                            length() {
                                return 1;
                            }

                            value() {
                                return '\n';
                            }
                        }

                        // Register the Break blot
                        Quill.register(Break);

                        $(".se-pre-con").fadeOut('fast');
                        $('#modal-title-default-reply').text('Forward Message');
                        $('#reply-btn-forward').attr('data-message_id', MessageId);
                        $('#save-draft-forward').attr('data-message_id', MessageId);
                        const sendBtn = document.getElementById('reply-btn-send');
                        const DraftsendBtn = document.getElementById('save-draft-reply');
                        const forwardBtn = document.getElementById('reply-btn-forward');
                        forwardBtn.textContent = 'Forward';
                        const DraftforwardBtn = document.getElementById('save-draft-forward');
                        const composeBtnDraft = document.getElementById('btn-compose-draft');
                        $('#template-section').hide();
                        if (!sendBtn.classList.contains('hidden')) {
                            sendBtn.classList.add('hidden');
                        }
                        if (forwardBtn.classList.contains('hidden')) {
                            forwardBtn.classList.remove('hidden');
                        }
                        if (!DraftsendBtn.classList.contains('hidden')) {
                            DraftsendBtn.classList.add('hidden');
                        }
                        if (!composeBtnDraft.classList.contains('hidden')) {
                            composeBtnDraft.classList.add('hidden');
                        }
                        if (DraftforwardBtn.classList.contains('hidden')) {
                            DraftforwardBtn.classList.remove('hidden');
                        }
                        replymodalquill.clipboard.dangerouslyPasteHTML(maildata.body);
                        $.ajax({
                            url: "{{ url('/get/email/signature') }}",
                            type: 'GET',
                            dataType: 'json',
                            beforeSend: function () {
                                $(".se-pre-con").fadeIn('fast');
                            },
                            success: function(response) {
                            console.log(response);
                            if (response.length > 0) {

                                var bodyData = JSON.parse(response[0].signature);
                                var quillContents = [{ insert: '\n\n' }].concat(bodyData.ops);
                                var currentContent = replymodalquill.getContents();
                                var currentOps = currentContent.ops;
                                var newContent = quillContents.concat(currentOps);
                                var newDelta = {
                                    ops: newContent
                                };
                                replymodalquill.setContents(newDelta);
                            }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error:', error);
                            },
                            complete: function () {
                                $(".se-pre-con").fadeOut('fast');

                            }
                        });
                        $('#modal-reply').modal('show');

                    }
                });

            });
            $(document).on('click', '.customBtn-DroupDown2', function() {

            event.preventDefault();
            console.log("Custom button clicked");
            $('#myDropdown2').toggle();
            });
            $(document).on('click', '.btn-reply', function() {
                var dataset = $(this).data('message_data');
                var from = $(this).data('message_from');
                var subject = $(this).data('subject');
                var message_id = $(this).data('message_id');

                var card = $(this).closest('.row');

                console.log(dataset);
                console.log(message_id);
                console.log(from);

                var htmlReply = `<div class="mb-4 " style="width:100%" id="html-reply">
                                                <div class="email-reply-area">

                                    <div class="email-body">
                                        <div class="email-details" >
                                            <div class="col-md-12  " style="display: flex;align-content: center;flex-wrap: wrap;align-items: flex-end;height:60px;" >
                                                <label for="contactSearchInput" style="width:8%">To:</label>
                                                <select class="form-control info-form-input mt-2 recipient-input" name="recipient[]" multiple="multiple" id="toRecipientInputreply" style="width:90%;height: 1.75rem;" aria-placeholder="To">
                                                </select>
                                                <label class="toggle-cc-bcc-reply" for="contactSearchInput" style="width:2%;"><i class="fa fa-sort fa-lg" aria-hidden="true"></i></label>
                                            </div>
                                            <div class=" col-md-12  ccbcc-input-reply  hidden" style="height:50px;">
                                                <label for="ccSearchInput" style="width:8%">Cc:</label>
                                                <select class="form-control info-form-input mt-2 cc-input" name="cc[]" multiple="multiple" id="ccRecipientInputreply" style="width: 90%;height: 1.75rem;" >
                                                </select>
                                            </div>
                                            <div class="col-md-12  ccbcc-input-reply  hidden" style="height:50px;">
                                                <label for="bccSearchInput" style="width:8%">Bcc:</label>
                                                <select class="form-control info-form-input mt-2 bcc-input" name="bcc[]" multiple="multiple" id="bccRecipientInputreply" style="width: 90%;height: 1.75rem;">
                                                </select>
                                            </div>
                                            <div class="col-md-12  " style="display: inline-flex;">
                                                <label  style="width:8%;align-content: center;">Subject</label>
                                                <input type="text" class="form-control info-form-input mt-2 color-set" id="reply-subject" name="subject" value="${subject}"   style="width: 90%;height: 2.5rem;">
                                            </div>
                                            <div class="to-field col-12" style="display:none">
                                            <div >
                                                <div  class="btn-green-filled customBtn-DroupDown2" style="padding: 5px;">Pick template</div>
                                                <div id="myDropdown2" class="dropdown-content">
                                                <input type="text" placeholder="Search.." id="myInput2" onkeyup="filterFunction2()">

                                                @foreach ($emailTemplates as $item )
                                                    <p style="margin-left: 10px;" class="pick-template-reply" data-template_id="{{$item['id']}}"> {{$item['title']}}</p>
                                                @endforeach
                                                @if (isset($AddedEmailTemplates))
                                                    @foreach ($AddedEmailTemplates as $item )
                                                        <p style="margin-left: 10px;" class="pick-template-reply" data-template_id="{{$item['id']}}"> {{$item['title']}}</p>
                                                    @endforeach
                                                @endif
                                                </div>
                                            </div>
                                        </div>

                                        </div>
                                        <div class="email-content">
                                            <div id="reply-editor-container" style="height: 250px;"></div>
                                            <input type="hidden" id="reply-email_body" name="email_body">

                                        </div>
                                    </div>
                                    <div class="email-header">

                                <div class="email-header-left">


                                </div>
                                    <div class="email-header-right mt-3">
                                        <button class="btn btn-send" data-message_id="${message_id}">Send</button>
                                        <button class="btn btn-discard">Discard</button>
                                    </div>
                                </div>
                                </div>
                                </div>`;

                var newCardBody = $(htmlReply);


                card.before(newCardBody);
                toggleButtonRow();
                // Import Quill and the Block class
                const Quill = window.Quill;
                const Block = Quill.import('blots/block');

                // Extend the Block class to use <div> instead of <p>
                Block.tagName = 'DIV';
                Quill.register(Block, true);

                // Create a new Quill instance with customized options
                var quill = new Quill('#reply-editor-container', {
                    theme: 'snow',
                    modules: {
                        imageResize: {
                            modules: ['Resize', 'DisplaySize', 'Toolbar']
                        },
                        toolbar: [
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'color': [] }, { 'background': [] }],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            [{ 'size': ['small', false, 'large', 'huge'] }],
                            [{ 'align': [] }],
                            ['link', 'image'],
                            ['clean'],
                        ],
                        magicUrl: true,
                        clipboard: {
                            matchers: [
                                // Matcher for P tags to replace with divs
                                ['P', function(node, delta) {
                                    // Replace newline characters with space within <p> tags
                                    delta.ops.forEach(function(op) {
                                        if (op.insert && typeof op.insert === 'string') {
                                            op.insert = op.insert.replace(/\n/g, ' ');
                                        }
                                    });
                                    return delta;
                                }]
                            ]
                        },
                        keyboard: {
                            bindings: {
                                // Override Enter key behavior for new paragraphs using div
                                enter: {
                                    key: 13,
                                    handler: function(range, context) {
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
                                    handler: function(range) {
                                        // Insert a line break
                                        this.quill.insertEmbed(range.index, 'br', true, Quill.sources.USER);
                                        this.quill.setSelection(range.index + 1, Quill.sources.SILENT);
                                        return false; // Prevent default behavior
                                    }
                                }
                            }
                        }
                    }
                });

                // Custom blot for <br>
                class Break extends Quill.import('blots/embed') {
                    static blotName = 'br';
                    static tagName = 'br';

                    static create() {
                        let node = super.create();
                        return node;
                    }

                    length() {
                        return 1;
                    }

                    value() {
                        return '\n';
                    }
                }

                // Custom blot for <div>
                class DivBlot extends Quill.import('blots/block') {
                    static blotName = 'div';
                    static tagName = 'div';
                }

                // Register the Break and Div blots
                Quill.register(Break);
                Quill.register(DivBlot);
              $.ajax({
                            url: "{{ url('/get/email/signature') }}",
                            type: 'GET',
                            dataType: 'json',
                            beforeSend: function () {
                                $(".se-pre-con").fadeIn('fast');
                            },
                            success: function(response) {
                            console.log(response);
                            if (response.length > 0) {

                                var bodyData = JSON.parse(response[0].signature);
                                quill.setContents(bodyData.ops);
                            }

                            },
                            error: function(xhr, status, error) {
                                console.error('Error:', error);
                            },
                            complete: function () {
                                $(".se-pre-con").fadeOut('fast');

                            }
                        });


                $('#toRecipientInputreply').select2({
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
                                    id: item.text,
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

                $('#ccRecipientInputreply').select2({
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
                                    id: item.text,
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

                $('#bccRecipientInputreply').select2({
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
                                    id: item.text,
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
                var newOption = $('<option>', {
                    value: from,
                    text: from,
                    selected: true
                });

    $('#toRecipientInputreply').append(newOption);

            });
            function filterFunction() {
                console.log("Custom button type");
                var input, filter, ul, li, a, i;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                div = document.getElementById("myDropdown");
                a = div.getElementsByTagName("p");
                for (i = 0; i < a.length; i++) {
                    txtValue = a[i].textContent || a[i].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        a[i].style.display = "";
                    } else {
                        a[i].style.display = "none";
                    }
                }
            }
            function filterFunction2() {
                console.log("Custom button type");
                var input, filter, ul, li, a, i;
                input = document.getElementById("myInput2");
                filter = input.value.toUpperCase();
                div = document.getElementById("myDropdown2");
                a = div.getElementsByTagName("p");
                for (i = 0; i < a.length; i++) {
                    txtValue = a[i].textContent || a[i].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        a[i].style.display = "";
                    } else {
                        a[i].style.display = "none";
                    }
                }
            }
            $(document).on('click', '.pick-template-reply', function() {
                  var template_id = $(this).data('template_id');
                  var replymodalquill = document.querySelector('#reply-modal-editor-container').__quill;
                  console.log(template_id);
                  $.ajax({
                      url: "{{ url('email/templates/pick') }}/" + template_id,
                      method: 'GET',
                      dataType: 'json',
                      beforeSend: function() {
                          $(".se-pre-con").fadeIn('slow');
                      },
                      success: function(data) {
                          if (data.body) {
                              try {
                                $('#reply_head_subject').val(data.subject);
                                  var bodyData = JSON.parse(data.body);
                                  if (bodyData.ops) {
                                      console.log(data);
                                      replymodalquill.setContents(bodyData.ops);
                                  } else {
                                      console.error("Invalid data format: ops property missing");
                                  }
                              } catch (error) {
                                  console.error("Error parsing body data:", error);
                              }
                          } else {
                              console.error("Invalid data format: body property missing");
                          }
                      },
                      complete: function() {
                        $('#myDropdown2').toggle();
                          $(".se-pre-con").fadeOut('slow');
                      },
                      error: function(xhr, status, error) {
                          console.error("Error occurred during AJAX request:", error);
                      }
                  });
              });
            $('#modal-reply').on('hidden.bs.modal', function () {
                $('#replytoRecipientInput').val(null).trigger('change');
                $('#replyccRecipientInput').val(null).trigger('change');
                $('#replybccRecipientInput').val(null).trigger('change');
                $('#reply_head_subject').val('');
                $('#reply-modal-editor-container').empty();
                $('#file-names-container').empty();
                destory_editor('#reply-modal-editor-container');
            });
            function destory_editor(selector){
            if($(selector)[0])
            {
                var content = $(selector).find('.ql-editor').html();
                $(selector).html(content);

                $(selector).siblings('.ql-toolbar').remove();
                $(selector + " *[class*='ql-']").removeClass (function (index, css) {
                return (css.match (/(^|\s)ql-\S+/g) || []).join(' ');
                });

                $(selector + "[class*='ql-']").removeClass (function (index, css) {
                return (css.match (/(^|\s)ql-\S+/g) || []).join(' ');
                });
            }
            else
            {
                console.error('editor not exists');
            }
        }
        $(document).on('click', '#reply-btn-send', function() {
            var messageId = $(this).data('message_id');
            var quillContent = $('#reply-modal-editor-container').html();
            var mailboxId = $('#mailboxId').val();

            quillContent = replaceImgSrcWithBase64(quillContent);
            $('#email_body-replymessage').val(quillContent);

            var to = $('#replytoRecipientInput').val();
            var cc = $('#replyccRecipientInput').val();
            var bcc = $('#replybccRecipientInput').val();
            var message = $('#email_body-replymessage').val();
            var subject = $('#reply_head_subject').val();
            var attachments = document.getElementById('attachmentreply').files;

            if (to.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Please select at least one recipient.'
                });
                return false;
            }

            if (subject.trim() === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Subject',
                    text: 'Do you want to send the email without a subject?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, send it',
                    cancelButtonText: 'No, add a subject'
                }).then((result) => {
                    if (result.value) {
                        sendReply(messageId, mailboxId, quillContent, to, cc, bcc, message, subject, attachments);
                    }
                });
            } else {
                sendReply(messageId, mailboxId, quillContent, to, cc, bcc, message, subject, attachments);
            }
        });
        $(document).on('click', '#save-draft-reply', function() {
            var messageId = $(this).data('message_id');
            var quillContent = $('#reply-modal-editor-container').html();
            var mailboxId = $('#mailboxId').val();

            quillContent = replaceImgSrcWithBase64(quillContent);
            $('#email_body-replymessage').val(quillContent);

            var to = $('#replytoRecipientInput').val();
            var cc = $('#replyccRecipientInput').val();
            var bcc = $('#replybccRecipientInput').val();
            var message = $('#email_body-replymessage').val();
            var subject = $('#reply_head_subject').val();
            var attachments = document.getElementById('attachmentreply').files;

            var attachmentPromises = [];

            for (var i = 0; i < attachments.length; i++) {
                let file = attachments[i];
                attachmentPromises.push(new Promise((resolve, reject) => {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        resolve({
                            name: file.name,
                            type: file.type,
                            content: e.target.result.split(',')[1]
                        });
                    };
                    reader.onerror = function(e) {
                        reject(e);
                    };
                    reader.readAsDataURL(file);
                }));
            }

            Promise.all(attachmentPromises).then((base64Attachments) => {
                var replyData = {
                    messageId: messageId,
                    to: to,
                    cc: cc,
                    bcc: bcc,
                    message: message,
                    subject: subject,
                    attachments: base64Attachments
                };

                $.ajax({
                    url: '{{ route("saveDraftReply") }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: 'application/json',
                    data: JSON.stringify(replyData),
                    beforeSend: function() {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function(response) {
                        console.log(response);
                        $(".se-pre-con").fadeOut('fast');
                        $('#attachmentreply').val('');
                        var fileNamesContainer = $('#file-names-container-reply');
                        fileNamesContainer.empty();
                        if (response.message) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                timer: 2000,
                                text: response.message
                            });

                        } else if (response.error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                timer: 2000,
                                text: response.error
                            });

                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to send reply:', error);
                        $('#modal-reply').modal('hide');
                        $('#attachmentreply').val('');
                        var fileNamesContainer = $('#file-names-container-reply');
                        fileNamesContainer.empty();
                        $(".se-pre-con").fadeOut('fast');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            timer: 2000,
                            text: 'Failed to save draft message ' + error
                        });
                    }
                });
            }).catch((error) => {
                console.error('Failed to convert attachments to Base64:', error);
            });
        });

        function sendReply(messageId, mailboxId, quillContent, to, cc, bcc, message, subject, attachments) {
            $('#modal-reply').modal('hide');
            var attachmentPromises = [];

            for (var i = 0; i < attachments.length; i++) {
                let file = attachments[i];
                attachmentPromises.push(new Promise((resolve, reject) => {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        resolve({
                            name: file.name,
                            type: file.type,
                            content: e.target.result.split(',')[1]
                        });
                    };
                    reader.onerror = function(e) {
                        reject(e);
                    };
                    reader.readAsDataURL(file);
                }));
            }

            Promise.all(attachmentPromises).then((base64Attachments) => {
                var replyData = {
                    messageId: messageId,
                    to: to,
                    cc: cc,
                    bcc: bcc,
                    message: message,
                    subject: subject,
                    attachments: base64Attachments
                };

                $.ajax({
                    url: '{{ route("send.reply") }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: 'application/json',
                    data: JSON.stringify(replyData),
                    beforeSend: function() {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function(response) {
                        console.log(response);
                        $(".se-pre-con").fadeOut('fast');
                        $('#attachmentreply').val('');
                        var fileNamesContainer = $('#file-names-container-reply');
                        fileNamesContainer.empty();
                        if (response.message) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                timer: 2000,
                                text: response.message
                            });
                        } else if (response.error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                timer: 2000,
                                text: response.error
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to send reply:', error);
                        $('#modal-reply').modal('hide');
                        $('#attachmentreply').val('');
                        var fileNamesContainer = $('#file-names-container-reply');
                        fileNamesContainer.empty();
                        $(".se-pre-con").fadeOut('fast');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            timer: 2000,
                            text: 'Failed to send message ' + error
                        });
                    }
                });
            }).catch((error) => {
                console.error('Failed to convert attachments to Base64:', error);
            });
        }
        function replaceImgSrcWithBase64(htmlContent) {
                var imgElements = $(htmlContent).find('img');

                imgElements.each(function() {
                    var imgSrc = $(this).attr('src');
                    var imgBase64 = getBase64Image(imgSrc);

                    $(this).attr('src', imgBase64);
                });

                return $(htmlContent).prop('outerHTML');
            }

            function getBase64Image(imgUrl) {
                var img = new Image();
                img.src = imgUrl;
                img.crossOrigin = 'Anonymous';

                var canvas = document.createElement('canvas');
                var ctx = canvas.getContext('2d');

                img.onload = function() {
                    canvas.width = this.width;
                    canvas.height = this.height;
                    ctx.drawImage(this, 0, 0);
                };

                return canvas.toDataURL();
            }
            $(document).on('click', '#reply-btn-forward', function() {

            var messageId = $(this).data('message_id');
            var quillContent = $('#reply-modal-editor-container').html();
            var mailboxId = $('#mailboxId').val();

            quillContent = replaceImgSrcWithBase64(quillContent);
            $('#email_body-replymessage').val(quillContent);

            var to = $('#replytoRecipientInput').val();
            var cc = $('#replyccRecipientInput').val();
            var bcc = $('#replybccRecipientInput').val();
            var message = $('#email_body-replymessage').val();
            var subject = $('#reply_head_subject').val();
            var attachments = document.getElementById('attachmentreply').files;

            if (to.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Please select at least one recipient.'
                });
                return false;
            }

            if (subject.trim() === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Subject',
                    text: 'Do you want to send the email without a subject?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, send it',
                    cancelButtonText: 'No, add a subject'
                }).then((result) => {
                    if (result.value) {
                        sendForward(messageId, mailboxId, quillContent, to, cc, bcc, message, subject, attachments);
                    }
                });
            } else {
                sendForward(messageId, mailboxId, quillContent, to, cc, bcc, message, subject, attachments);
            }
            });

            function sendForward(messageId, mailboxId, quillContent, to, cc, bcc, message, subject, attachments) {
            var attachmentPromises = [];
            $('#modal-reply').modal('hide');
            for (var i = 0; i < attachments.length; i++) {
            let file = attachments[i];
            attachmentPromises.push(new Promise((resolve, reject) => {
            let reader = new FileReader();
            reader.onload = function(e) {
                resolve({
                    name: file.name,
                    type: file.type,
                    content: e.target.result.split(',')[1]
                });
            };
            reader.onerror = function(e) {
                reject(e);
            };
            reader.readAsDataURL(file);
            }));
            }

            Promise.all(attachmentPromises).then((base64Attachments) => {
            var forwardData = {
            messageId: messageId,
            to: to,
            cc: cc,
            bcc: bcc,
            message: message,
            subject: subject,
            attachments: base64Attachments
            };

            $.ajax({
            url: '{{ route("send.forward") }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: 'application/json',
            data: JSON.stringify(forwardData),
            beforeSend: function() {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(response) {
                console.log(response);
                $(".se-pre-con").fadeOut('fast');
                $('#attachmentreply').val('');
                $('#file-names-container-reply').empty();
                if (response.message) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        timer: 2000,
                        text: response.message
                    });
                } else if (response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        timer: 2000,
                        text: response.error
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Failed to send forward:', error);
                $('#modal-reply').modal('hide');
                $('#attachmentreply').val('');
                $('#file-names-container-reply').empty();
                $(".se-pre-con").fadeOut('fast');
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    timer: 2000,
                    text: 'Failed to send message ' + error
                });
            }
            });
            }).catch((error) => {
            console.error('Failed to convert attachments to Base64:', error);
            });
            }

    // edited by heshan namal

            $(document).on('click', '#save-template-org', function() {
                $('#templatetitle-org').modal('show');
            });
            $('#confirmcreateButton-org').click(function() {
                    var delta = replymodalquill.getContents();
                    // Convert Delta format to JSON string for saving to the database
                    var jsonContent = JSON.stringify(delta);
                    var escapedJsonContent = jsonContent.replace(/'/g, "&apos;");
                    var subject = $('#reply_head_subject').val();

                    // Get the selected mailbox ID using Select2
                    template_title = $('#template_title_get-org').val();
                    // Perform any actions you need with the selected mailbox ID
                    console.log('Selected Mailbox ID:', subject);
                    var selectElement = document.getElementById("mail_template_publish_type-org");
                    var selectedValue = selectElement.value;
                    var selectedValueInt = parseInt(selectedValue, 10);
                    var formData = {

                            title: template_title,
                            subject: subject ,
                            templatecontent: escapedJsonContent,
                            publish_type: selectedValueInt,
                        };
                        console.log('form data'+formData);
                        $.ajax({
                            url: '{{ route("email.templates.store") }}', // Your backend endpoint
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token in headers
                            },
                            data: formData,
                            beforeSend: function () {
                                $(".se-pre-con").fadeIn('fast');
                            },
                            success: function(response) {
                                // Handle success response
                                // alert('Email template saved successfully');
                                // Optionally, you can clear the form or redirect the user

                                $('#template_title_get-org').val('');
                                $('#templatetitle-org').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Email template saved successfully'
                                });
                            },
                            error: function(xhr, status, error) {
                                // Handle error response
                                $(".se-pre-con").fadeOut('fast');
                                console.error('Error:', error);
                                // alert('Failed to save email template');
                                $('#templatetitle-org').modal('hide');
                                $('#template_title_get-org').val('');
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Failed to save email template'
                                });
                            },
                            complete: function () {
                                $(".se-pre-con").fadeOut('fast');

                            }
                        });



                });
    </script>
