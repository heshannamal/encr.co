    <style>
        #email_view_modal .select2-selection.select2-selection--multiple{
            /* border: 1px solid #eaeaea !important; */
            background-color: white;
        }
    </style>
    <div class="modal fade" id="email_view_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h3 class="modal-title" id="modal-title-default-email">Subject here</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="col-md-12">
                        <table style="width: 100%">
                            <tbody>
                                <tr style="height: 3rem;">
                                    <td style="width: 5%;">
                                        <label for="contactSearchInput" style="width:5%">To:</label>
                                    </td>
                                    <td>
                                        <select class="form-control select2-element mt-2 recipient-input" name="recipient[]" multiple="multiple" id="toRecipientInput" style="width: 95%" aria-placeholder="To" disabled>
                                        </select>
                                    </td>
                                </tr>
                                <tr style="height: 3rem;">
                                    <td style="width: 5%;">
                                        <label for="ccSearchInput" style="width:5%">Cc:</label>
                                    </td>
                                    <td>
                                        <select class="form-control select2-element mt-2 cc-input" name="cc[]" multiple="multiple" id="ccRecipientInput" style="width:95%" disabled>
                                        </select>
                                    </td>
                                </tr>
                                <tr style="height: 3rem;">
                                    <td style="width: 5%;">
                                        <label for="bccSearchInput" style="width:5%">Bcc:</label>
                                    </td>
                                    <td>
                                        <select class="form-control select2-element mt-2 bcc-input" name="bcc[]" multiple="multiple" id="bccRecipientInput" style="width:95%" disabled>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <hr style="margin: .7rem;">
                    <div class="col-md-12 mt-2 ">
                        <input type="text" style="height: 2.5rem;" class="form-control info-form-input mt-2" id="view_subject" name="subject" value="" placeholder="Subject" readonly>
                    </div>
                    <div class="col-md-12 mt-3 mb-1">
                        <label for="new_description" class="form-label mb-1" style="color: black">Email Body</label>
                        <div id="mail-view-container" style="height: 270px;overflow-y:scroll;border: 1px solid #eaeaea;">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<script>
    $('.select2-element').select2();
    $(document).on('click', '.view-email', function(e) {
        e.preventDefault();

        var orgEmailDetails = $(this).data('org_email_id');

        // Log the email details for debugging
        console.log(orgEmailDetails);

        // Populate the modal fields
        $('#modal-title-default-email').text('View Email');
        $('#toRecipientInput').empty();
        $('#ccRecipientInput').empty();
        $('#bccRecipientInput').empty();
        $.ajax({
            url: '{{ url("activities/get_organization_email_body") }}/' + orgEmailDetails.id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {

                $('#mail-view-container').html(sanitizeHTML2(data.body || ''));
            },
            error: function(xhr, status, error) {
                console.error('Error fetching email body:', error);
                $('#mail-view-container').html('<p class="text-danger">Failed to load email body.</p>');
            }
        });


        // Populate "To" recipients
        if (orgEmailDetails.toRecipients) {
            let toRecipients = JSON.parse(orgEmailDetails.toRecipients);
            toRecipients.forEach(function(recipient) {
                $('#toRecipientInput').append(new Option(recipient.emailAddress.address, recipient.emailAddress.address, true, true));
            });
        }

        // Populate "CC" recipients
        if (orgEmailDetails.ccRecipients) {
            let ccRecipients = JSON.parse(orgEmailDetails.ccRecipients);
            ccRecipients.forEach(function(recipient) {
                $('#ccRecipientInput').append(new Option(recipient.emailAddress.address, recipient.emailAddress.address, true, true));
            });
        }

        // Populate "BCC" recipients
        if (orgEmailDetails.bccRecipients) {
            let bccRecipients = JSON.parse(orgEmailDetails.bccRecipients);
            bccRecipients.forEach(function(recipient) {
                $('#bccRecipientInput').append(new Option(recipient.emailAddress.address, recipient.emailAddress.address, true, true));
            });
        }
        $('#view_subject').val(orgEmailDetails.subject);
        // Show the modal
        $('#email_view_modal').modal('show');
    });
    function sanitizeHTML2(htmlString) {
        const container = document.createElement('div');

        container.innerHTML = `<div>${htmlString}</div>`;

        container.querySelectorAll('script').forEach(el => el.remove());

        container.querySelectorAll('style').forEach(el => el.remove());

        return container.innerHTML;
    }
</script>
