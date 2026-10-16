
    <script>
        $(document).on('click', '.compose-btn', function() {
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
                        $('#modal-title-default-reply').text('Compose Email');
                        const sendBtn = document.getElementById('reply-btn-send');
                        const DraftsendBtn = document.getElementById('save-draft-reply');
                        const forwardBtn = document.getElementById('reply-btn-forward');
                        const composeBtn = document.getElementById('btn-compose');
                        const composeBtnDraft = document.getElementById('btn-compose-draft');
                        const DraftforwardBtn = document.getElementById('save-draft-forward');
                        $('#template-section').show();
                        if (!sendBtn.classList.contains('hidden')) {
                            sendBtn.classList.add('hidden');
                        }
                        if (!composeBtnDraft.classList.contains('hidden')) {
                            composeBtnDraft.classList.add('hidden');
                        }
                        if (composeBtn.classList.contains('hidden')) {
                            composeBtn.classList.remove('hidden');
                        }
                        if (!DraftsendBtn.classList.contains('hidden')) {
                            DraftsendBtn.classList.add('hidden');
                        }
                        if (!forwardBtn.classList.contains('hidden')) {
                            forwardBtn.classList.add('hidden');
                        }
                        if (DraftforwardBtn.classList.contains('hidden')) {
                            DraftforwardBtn.classList.remove('hidden');
                        }
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
                        var contacts = @json($contacts);
                        console.log(contacts);
                        $('#modal-reply').modal('show');
                        var selectElement = $('#replytoRecipientInput');
                        contacts.forEach(function(contact) {
                            var option = $('<option>', {
                                value: contact.email,
                                text: contact.email,
                                selected: true
                            });

                            selectElement.append(option);
                        });

            });
            $(document).on('click', '.compose-btn-new', function() {
                event.preventDefault();

                if ($('#replytoRecipientInput').val().length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Please select at least one recipient.'
                    });
                    return false;
                }

                if ($('#reply_head_subject').val().trim() === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Subject',
                        text: 'Do you want to send the email without a subject?',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, send it',
                        cancelButtonText: 'No, add a subject'
                    }).then((result) => {
                        if (result.value) {
                            proceedWithFormSubmission();
                        }
                    });
                } else {
                    proceedWithFormSubmission();
                }
                function gatherFormData() {
                    var formData = new FormData();

                    var quillContent = $('#reply-modal-editor-container').html();

                    quillContent = replaceImgSrcWithBase64(quillContent);
                    $('#email_body-replymessage').val(quillContent);

                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    formData.append('_token', csrfToken);

                    formData.append('template_id', $('#template_id').val());

                    $('#replytoRecipientInput option:selected').each(function() {
                        formData.append('recipient[]', $(this).val());
                    });

                    $('#replyccRecipientInput option:selected').each(function() {
                        formData.append('cc[]', $(this).val());
                    });

                    $('#replybccRecipientInput option:selected').each(function() {
                        formData.append('bcc[]', $(this).val());
                    });

                    formData.append('subject', $('#reply_head_subject').val());

                    formData.append('email_body', $('#email_body-replymessage').val());

                    var attachments = $('#attachmentreply')[0].files;
                    for (var i = 0; i < attachments.length; i++) {
                        formData.append('attachments[]', attachments[i]);
                    }

                    if ($('#Draftmessageid').length) {
                        formData.append('Draftmessageid', $('#Draftmessageid').val());
                    }

                    return formData;
                }

                function proceedWithFormSubmission() {
                    console.log('quillContent');

                    var quillContent = $('#editor-container').html();

                    quillContent = replaceImgSrcWithBase64(quillContent);
                    console.log(quillContent);
                    $('#email_body').val(quillContent);
                    $('#Draftmessageid').val('');
                    var formData = gatherFormData();
                    $(".se-pre-con").fadeIn('slow');
                    $.ajax({
                        url: "{{ route('mailSend') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function () {
                                $(".se-pre-con").fadeIn('slow');
                            },
                        success: function(response) {
                            console.log(response.sent_message);
                            $('#modal-reply').modal('hide');
                            if (response.message) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: response.message
                                });

                                if(response.sent_message){

                                    var org_id = $('#organization_id').val();
                                    var emailDetails = JSON.stringify(response.sent_message);

                                    var formData = new FormData();
                                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                                    formData.append('_token', csrfToken);
                                    formData.append('link_organization_id', org_id);
                                    formData.append('emailDetails', emailDetails);

                                    $.ajax({
                                        url: "{{url('email/linkExistOrganizationInfo')}}",
                                        type: "post",
                                        dataType: "json",
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function (response) {
                                            if(response.status == "success") {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Done!',
                                                    text: 'Organization Linked Successfully!'
                                                }).then(function() {
                                                    location.reload();
                                                });
                                            } else {
                                                Swal.fire({
                                                    icon: 'warning',
                                                    title: 'Error!',
                                                    text: 'Something Went Wrong!'
                                                });
                                                    }
                                            },
                                            complete: function () {
                                                loadAllTab();
                                                $(".se-pre-con").fadeOut('slow');
                                            }
                                    });
                                }else{
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Error!',
                                        text: 'Something Went Wrong!'
                                    });
                                }

                            } else if (response.error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: response.error
                                });
                                $(".se-pre-con").fadeOut('slow');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
            $('#reply-modal-editor-container').on('input', '.ql-editor', function() {
                startSaveDraftReplyTimeout();
            });
            var saveDraftreplyTimeout;
            function startSaveDraftReplyTimeout() {
                clearTimeout(saveDraftreplyTimeout);
                if($('#modal-title-default-reply').text() == 'Compose Email'){
                    saveDraftreplyTimeout = setTimeout(saveDraft, 10000);
                }else{
                    saveDraftreplyTimeout = setTimeout(saveDraftReply, 10000);
                }
            }
            function saveDraftReply() {
                $('#draftsavealert').text('Saving draft');
                const sendBtn = document.getElementById('reply-btn-send');
                const forwardBtn = document.getElementById('reply-btn-forward');
                let messageId, url;

                if (!forwardBtn.classList.contains('hidden')) {
                    messageId = $('#reply-btn-forward').data('message_id');
                    url = "{{ route('DraftForward') }}";
                } else if (!sendBtn.classList.contains('hidden')) {
                    messageId = $('#save-draft-reply').data('message_id');
                    url = "{{ route('saveDraftReply') }}";
                }

                var quillContent = $('#reply-modal-editor-container .ql-editor').html();
                // quillContent = replaceImgSrcWithBase64(quillContent);

                var organization_linked = $('#organization_id').val();
                var to = $('#replytoRecipientInput').val();
                var cc = $('#replyccRecipientInput').val();
                var bcc = $('#replybccRecipientInput').val();
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

                var draftId = $('#SavedDraftIdReply').val();
                console.log('SavedDraftIdReply :'+draftId);
                Promise.all(attachmentPromises).then((base64Attachments) => {
                    var replyData = {
                        messageId: messageId,
                        to: to,
                        cc: cc,
                        bcc: bcc,
                        message: quillContent,
                        subject: subject,
                        attachments: base64Attachments,
                        draftId: draftId,
                        organization_linked: organization_linked
                    };

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: url,
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(replyData),
                        success: function(response) {
                            console.log(response);
                            $('#attachmentreply').val('');
                            var fileNamesContainer = $('#file-names-container-reply');
                            fileNamesContainer.empty();
                            if (response.message) {
                                $('#draftsavealert').text(response.message);
                                setTimeout(function() {
                                    $('#draftsavealert').text('');
                                }, 4000);
                                if (!draftId && response.draftId) {
                                    $('#SavedDraftIdReply').val(response.draftId);
                                    $('#Draftmessageid').val(response.draftId);
                                    const composeBtn = document.getElementById('btn-compose');
                                    const composeBtnDraft = document.getElementById('btn-compose-draft');
                                    const forwardBtn = document.getElementById('reply-btn-forward');
                                    if (!composeBtn.classList.contains('hidden')) {
                                        composeBtn.classList.add('hidden');
                                    }
                                    if (composeBtnDraft.classList.contains('hidden')) {
                                        composeBtnDraft.classList.remove('hidden');
                                    }
                                    if (!forwardBtn.classList.contains('hidden')) {
                                        composeBtnDraft.classList.add('hidden');
                                    }
                                }
                            } else if (response.error) {
                                $('#draftsavealert').text(response.error);
                                setTimeout(function() {
                                    $('#draftsavealert').text('');
                                }, 4000);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Failed to save draft reply:', error);
                            $('#draftsavealert').text('Failed to save draft reply');
                            setTimeout(function() {
                                $('#draftsavealert').text('');
                            }, 4000);
                        }
                    });
                }).catch((error) => {
                    console.error('Failed to convert attachments to Base64:', error);
                });
            }
            function saveDraft() {
                $('#draftsavealert').text('Saving draft');

                var draftId = $('#SavedDraftId').val();
                console.log('SavedDraftId :'+draftId);
                var url = draftId ? "{{ route('updateDraft') }}" : "{{ route('saveDraft') }}";

                var quillContent = $('#reply-modal-editor-container .ql-editor').html();
                // quillContent = replaceImgSrcWithBase64(quillContent);

                var organization_linked = $('#organization_id').val();
                var to = $('#replytoRecipientInput').val();
                var cc = $('#replyccRecipientInput').val();
                var bcc = $('#replybccRecipientInput').val();
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
                        to: to,
                        cc: cc,
                        bcc: bcc,
                        email_body: quillContent,
                        subject: subject,
                        attachments: base64Attachments,
                        SavedDraftId: draftId,
                        organization_linked: organization_linked,
                    };

                    // Refresh CSRF token
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    console.log('Console before ajax');

                    $.ajax({
                        url: url,
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(replyData),
                        success: function(response) {
                            console.log(response);
                            $('#attachmentreply').val('');
                            var fileNamesContainer = $('#file-names-container-reply');
                            fileNamesContainer.empty();
                            if (response.message) {
                                $('#draftsavealert').text(response.message);
                                setTimeout(function() {
                                    $('#draftsavealert').text('');
                                }, 4000);
                                if (!draftId && response.draftId) {
                                    $('#SavedDraftId').val(response.draftId);
                                    $('#Draftmessageid').val(response.draftId);
                                    const composeBtn = document.getElementById('btn-compose');
                                    const composeBtnDraft = document.getElementById('btn-compose-draft');
                                    const forwardBtn = document.getElementById('reply-btn-forward');
                                    if (!composeBtn.classList.contains('hidden')) {
                                        composeBtn.classList.add('hidden');
                                    }
                                    // if (!forwardBtn.classList.contains('hidden')) {
                                    //     forwardBtn.classList.add('hidden');
                                    // }
                                    if (composeBtnDraft.classList.contains('hidden')) {
                                        composeBtnDraft.classList.remove('hidden');
                                    }
                                    if (!forwardBtn.classList.contains('hidden')) {
                                        composeBtnDraft.classList.add('hidden');
                                    }
                                }
                            } else if (response.error) {
                                $('#draftsavealert').text(response.error);
                                setTimeout(function() {
                                    $('#draftsavealert').text('');
                                }, 4000);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Failed to save draft reply:', error);
                            $('#draftsavealert').text('Failed to save draft reply');
                            setTimeout(function() {
                                $('#draftsavealert').text('');
                            }, 4000);
                        }
                    });
                }).catch((error) => {
                    console.error('Failed to convert attachments to Base64:', error);
                });

            }
            $(document).on('click', '#save-draft-reply', saveDraftReply);
            $(document).on('click', '#save-draft-forward', saveDraftReply);

            $(document).on('click', '.unlink-head', function() {
                var MessageId = $(this).data('messageid');
                var link_organization_id = $('#organization_id').val();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                var formData = new FormData();
                formData.append('organization_messageNo', MessageId);
                formData.append('link_organization_id', link_organization_id);
                formData.append('_token', csrfToken);
                $.ajax({
                    url: "{{url('email/unlinkExistOrganizationInfo')}}",
                    type: "post",
                    dataType: "json",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $(".se-pre-con").fadeOut('slow');
                        if(response.status == "success") {
                            Swal.fire({
                            icon: 'success',
                            title: 'Done!',
                            text: 'Organization Un-linked Successfully!'
                        }).then(function() {
                            location.reload(); // Reload the page after success
                        });
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Error!',
                                text: 'Something Went Wrong!'
                            });
                                }
                    },
                    complete: function () {
                        loadAllTab();
                    }
                });
            });

            // Draft functions

            $(document).on('click', '.draft-email', function() {
                event.preventDefault();

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
                $('#modal-title-default-reply').text('Draft Email');
                const sendBtn = document.getElementById('reply-btn-send');
                const DraftsendBtn = document.getElementById('save-draft-reply');
                const forwardBtn = document.getElementById('reply-btn-forward');
                const composeBtn = document.getElementById('btn-compose');
                const composeBtnDraft = document.getElementById('btn-compose-draft');
                const DraftforwardBtn = document.getElementById('save-draft-forward');
                $('#template-section').show();
                if (!sendBtn.classList.contains('hidden')) {
                    sendBtn.classList.add('hidden');
                }
                if (!composeBtn.classList.contains('hidden')) {
                    composeBtn.classList.add('hidden');
                }
                if (composeBtnDraft.classList.contains('hidden')) {
                    composeBtnDraft.classList.remove('hidden');
                }
                if (!DraftsendBtn.classList.contains('hidden')) {
                    DraftsendBtn.classList.add('hidden');
                }
                if (!forwardBtn.classList.contains('hidden')) {
                    forwardBtn.classList.add('hidden');
                }
                if (DraftforwardBtn.classList.contains('hidden')) {
                    DraftforwardBtn.classList.remove('hidden');
                }

                var orgEmailId = $(this).data('org_email_id');

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

                var ccRecipients = JSON.parse(orgEmailId.ccRecipients);
                var bccRecipients = JSON.parse(orgEmailId.bccRecipients);
                var toRecipients = JSON.parse(orgEmailId.toRecipients);

                populateSelect('#replyccRecipientInput', ccRecipients);
                populateSelect('#replybccRecipientInput', bccRecipients);
                populateSelect('#replytoRecipientInput', toRecipients);

                $('#reply_head_subject').val(orgEmailId.subject);

                $('#Draftmessageid').val(orgEmailId.message_no);
                replymodalquill.clipboard.dangerouslyPasteHTML(orgEmailId.body);

                $('#modal-reply').modal('show');

                });
                    $(document).on('click', '.draft-compose-btn-new', function() {
                        event.preventDefault();

                        if ($('#replytoRecipientInput').val().length === 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Please select at least one recipient.'
                            });
                            return false;
                        }

                        if ($('#reply_head_subject').val().trim() === '') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'No Subject',
                                text: 'Do you want to send the email without a subject?',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, send it',
                                cancelButtonText: 'No, add a subject'
                            }).then((result) => {
                                if (result.value) {
                                    proceedWithFormSubmission_draft();
                                }
                            });
                        } else {
                            proceedWithFormSubmission_draft();
                        }
                        function gatherFormData_draft() {
                            var formData = new FormData();

                            var quillContent = $('#reply-modal-editor-container').html();

                            quillContent = replaceImgSrcWithBase64(quillContent);
                            $('#email_body-replymessage').val(quillContent);

                            var csrfToken = $('meta[name="csrf-token"]').attr('content');
                            formData.append('_token', csrfToken);

                            formData.append('template_id', $('#template_id').val());

                            $('#replytoRecipientInput option:selected').each(function() {
                                formData.append('recipient[]', $(this).val());
                            });

                            $('#replyccRecipientInput option:selected').each(function() {
                                formData.append('cc[]', $(this).val());
                            });

                            $('#replybccRecipientInput option:selected').each(function() {
                                formData.append('bcc[]', $(this).val());
                            });

                            formData.append('subject', $('#reply_head_subject').val());

                            formData.append('email_body', $('#email_body-replymessage').val());

                            var attachments = $('#attachmentreply')[0].files;
                            for (var i = 0; i < attachments.length; i++) {
                                formData.append('attachments[]', attachments[i]);
                            }

                            if ($('#Draftmessageid').length) {
                                formData.append('Draftmessageid', $('#Draftmessageid').val());
                            }

                            return formData;
                        }

                        function proceedWithFormSubmission_draft() {
                            console.log('quillContent');

                            var quillContent = $('#editor-container').html();

                            quillContent = replaceImgSrcWithBase64(quillContent);
                            console.log(quillContent);
                            $('#email_body').val(quillContent);

                            var formData = gatherFormData_draft();
                            $(".se-pre-con").fadeIn('slow');
                            $.ajax({
                                url: "{{ route('mailSend') }}",
                                type: "POST",
                                data: formData,
                                contentType: false,
                                processData: false,
                                beforeSend: function () {
                                        $(".se-pre-con").fadeIn('slow');
                                    },
                                success: function(response) {
                                    console.log(response);

                                    if (response.message) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success!',
                                            text: response.message
                                        });

                                        if(response.sent_message){

                                            var org_id = $('#organization_id').val();
                                            var emailDetails = JSON.stringify(response.sent_message);

                                            var formData = new FormData();
                                            var csrfToken = $('meta[name="csrf-token"]').attr('content');
                                            formData.append('_token', csrfToken);
                                            formData.append('link_organization_id', org_id);
                                            formData.append('emailDetails', emailDetails);

                                            $.ajax({
                                                url: "{{url('email/linkExistOrganizationInfo')}}",
                                                type: "post",
                                                dataType: "json",
                                                data: formData,
                                                processData: false,
                                                contentType: false,
                                                success: function (response) {
                                                    if(response.status == "success") {
                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Done!',
                                                            text: 'Organization Linked Successfully!'
                                                        }).then(function() {

                                                            location.reload();
                                                        });
                                                    } else {
                                                        Swal.fire({
                                                            icon: 'warning',
                                                            title: 'Error!',
                                                            text: 'Something Went Wrong!'
                                                        });
                                                            }
                                                    },
                                                    complete: function () {
                                                        loadAllTab();
                                                        $(".se-pre-con").fadeOut('slow');
                                                    }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: 'warning',
                                                title: 'Error!',
                                                text: 'Something Went Wrong!'
                                            });
                                        }

                                    } else if (response.error) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error!',
                                            text: response.error
                                        });
                                        $(".se-pre-con").fadeOut('slow');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText);
                                }
                            });
                        }
                    });
                    $(document).on('click', '.email-draft-delete', function() {
                        var MessageId = $(this).data('draft_id_to_delete');

                        var formData = new FormData();
                        formData.append('chat_id_set', MessageId);

                        var csrfToken = $('meta[name="csrf-token"]').attr('content');
                        formData.append('_token', csrfToken);

                        console.log(MessageId);

                        $.ajax({
                            url: '{{ route("delete.draft") }}',
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            beforeSend: function() {
                                $(".se-pre-con").fadeIn('slow');
                            },
                            success: function(response) {
                                console.log(response);
                                $(".se-pre-con").fadeOut('fast');
                                if (response.message) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        timer: 2000,
                                        text: response.message
                                    }).then(function() {
                                        location.reload();
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
                                $(".se-pre-con").fadeOut('fast');
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    timer: 2000,
                                    text: 'Failed to delete draft message ' + error
                                });
                            }
                        });
                    });
    </script>
