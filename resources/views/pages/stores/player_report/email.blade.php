<!-- Compose Email Modal -->
<div class="modal fade" id="composeEmailModal" tabindex="-1" role="dialog" aria-labelledby="composeEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Compose Email</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: .5rem 2rem !important;">
            <div class="col-md-12 mb-1" style="border: 1px solid #f5efef;">
                <select class="form-control mb-3" id="toEmail" multiple>
                </select>
            </div>
            <div class="col-md-12 mb-1" style="border: 1px solid #f5efef;">
                <select class="form-control mb-3" id="ccEmail" multiple>
                    <option value="">CC (Optional)</option>
                </select>
            </div>
            <div class="col-md-12 mb-1" style="border: 1px solid #f5efef;">
                <input type="text" style="border:none" class="form-control" placeholder="Subject" id="emailSubject">
            </div>
            <div class="col-md-12" style="padding: 0;">
                <div class="dropdown mt-2 mb-3" style="position: unset;">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="picTemplateDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #e1e1e1;color: black;">
                    Pic Template
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="picTemplateDropdown"  id="picTemplateDropdownContent" style="max-height: 200px; overflow-y: auto;">
                    </div>
                </div>
            </div>
            <div class="col-md-12 mb-1" style="border: 1px solid #f5efef;padding: 0;">
                <div id="quillEditor" style="height: 250px;"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-info" id="saveTemplateBtn">Save as template</button>
          <button type="button" class="btn btn-primary" id="sendEmailBtn">Send</button>
        </div>
      </div>
    </div>
</div>

  <!-- Quill -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
    let quill;
    let selectedEmails = @json(!empty($order->CustomerDetails->email) ? [$order->CustomerDetails->email] : []);
    let ccEmail = @json(!empty(auth()->user()->email) ? [auth()->user()->email] : []);

    $(document).ready(function () {

        $('#toEmail, #ccEmail').select2({
            tags: true,
            tokenSeparators: [',', ' '],
            width: '100%',
            placeholder: 'Type email and press Enter'
        });

        $('#compose_email_button').on('click', function () {
            $(".se-pre-con").fadeIn('slow');

            const $toEmail = $('#toEmail');
            const $ccEmail = $('#ccEmail');

            // Clear old values/options
            $toEmail.empty();
            $ccEmail.empty();

            // Add default TO emails
            selectedEmails.forEach(function (email) {
                if (email && email.trim() !== '') {
                    let option = new Option(email, email, true, true);
                    $toEmail.append(option);
                }
            });

            // Add default CC emails
            ccEmail.forEach(function (email) {
                if (email && email.trim() !== '') {
                    let option = new Option(email, email, true, true);
                    $ccEmail.append(option);
                }
            });

            // Refresh Select2
            $toEmail.trigger('change');
            $ccEmail.trigger('change');

            $('#composeEmailModal').modal('show');
            $(".se-pre-con").fadeOut('slow');
        });

        $('#composeEmailModal').on('shown.bs.modal', function () {
            if (!quill) {
                quill = new Quill('#quillEditor', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{ header: [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline'],
                            [{ color: [] }, { background: [] }],
                            [{ list: 'ordered' }, { list: 'bullet' }],
                            ['link'],
                            ['clean']
                        ]
                    }
                });
            }
        });

        $(document).on('click', '.dropdown-menu a.dropdown-item', function(e) {
            e.preventDefault();

            $(".se-pre-con").fadeIn('slow');

            const encodedSubject = $(this).data('subject') || '';
            const encodedTemplate = $(this).data('template') || '';

            const subject = decodeURIComponent(encodedSubject);
            const templateBody = decodeURIComponent(encodedTemplate);

            $('#emailSubject').val(subject);

            quill.setContents([]);
            quill.clipboard.dangerouslyPasteHTML(templateBody);

            $(this).closest('.dropdown-menu').removeClass('show');
            $(".se-pre-con").fadeOut('slow');
        });

        $('#saveTemplateBtn').on('click', function () {
            $('#composeEmailModal').modal('hide');
            Swal.fire({
                title: 'Enter Template Name',
                input: 'text',
                inputLabel: 'Template Name',
                inputPlaceholder: 'Enter template name',
                showCancelButton: true,
                allowOutsideClick: false,
                inputAttributes: {
                    autocapitalize: 'off',
                    autocomplete: 'off',
                    spellcheck: 'false',
                },
                inputValidator: (value) => {
                    if (!value || !value.trim()) {
                        return 'Template name is required!';
                    }
                }
            }).then((result) => {
                if (result.value) {
                    const templateName = result.value.trim();

                    const subject = $('#emailSubject').val();
                    const message = encodeURIComponent(quill.root.innerHTML);

                    if (!subject.trim() || !message.trim()) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Missing Fields',
                            text: 'Please fill all fields before saving.'
                        });
                        return;
                    }

                    $(".se-pre-con").fadeIn('slow');

                    $.ajax({
                        url: "{{ route('store.saveEmailTemplate') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            template_name: templateName,
                            subject: subject,
                            body: message
                        },
                        success: function (response) {
                            $(".se-pre-con").fadeOut('slow');
                            getEmailTemplates();
                            Swal.fire({
                                icon: 'success',
                                title: 'Template Saved',
                                text: response.message || 'Template saved successfully!'
                            });
                            $('#composeEmailModal').modal('show');
                        },
                        error: function () {
                            $(".se-pre-con").fadeOut('slow');
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                text: 'Something went wrong while saving the template.'
                            });
                        }
                    });
                }
            });
        });



        $('#sendEmailBtn').on('click', function () {
            $(".se-pre-con").fadeIn('slow');
            const subject = $('#emailSubject').val();
            const message = quill.root.innerHTML;
            const to = $('#toEmail').val();

            if (to.length === 0 || subject.trim() === '' || message.trim() === '') {
                $(".se-pre-con").fadeOut('slow');
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing Fields',
                    text: 'Please fill all fields before sending.'
                });
                return;
            }

            $.ajax({
                url: "{{ route('store.emailToCucstomer') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    emails: to,
                    cc_emails: ccEmail,
                    subject: subject,
                    message: message
                },
                success: function (response) {
                    $(".se-pre-con").fadeOut('slow');
                    Swal.fire({
                        icon: 'success',
                        title: 'Email Sent',
                        text: response.message || 'Emails sent successfully!'
                    });
                    $('#composeEmailModal').modal('hide');

                },
                error: function (xhr) {
                    $(".se-pre-con").fadeOut('slow');
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'Something went wrong while sending emails.'
                    });
                }
            });
        });
    });
    function getEmailTemplates() {
        $.ajax({
            url: "{{ route('store.getEmailTemplates') }}",
            method: "GET",
            success: function (response) {
                const $dropdown = $('#picTemplateDropdownContent');
                $dropdown.empty();
                if (response.length === 0) {
                    $dropdown.append('<a class="dropdown-item" href="#">No templates available</a>');
                    return;
                }
                response.forEach(function (template) {
                    const encodedBody = encodeURIComponent(template.body);
                    const encodedSubject = encodeURIComponent(template.subject);
                    $dropdown.append(
                        `<a class="dropdown-item" href="#" data-template="${encodedBody}" data-subject="${encodedSubject}">${template.template_name}</a>`
                    );
                });
            },
            error: function () {
                console.error('Failed to fetch email templates.');
            }
        });
    }
    getEmailTemplates();
</script>
