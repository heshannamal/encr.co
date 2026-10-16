@php
    $orders = $orders[0] ?? ($order ?? null);
@endphp
<div class="modal fade" id="copy_credentials_modal" tabindex="-1" role="dialog" aria-labelledby="copyCredentialsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="copyCredentialsModalLabel">Copy User Credentials</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 2rem !important;">
                <form>
                    <div class="form-group">
                        <label for="emailInput">Email address</label>
                        <div class="input-group">
                            <input type="email" class="form-control" value="{{$orders->contactDetails->email}}" id="emailInputCredentials" placeholder="Enter email">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" title="Copy Email" type="button" style="padding: 0rem 1rem;border: 1px solid #9cc6d7;" onclick="copyToClipboardCredentials('#emailInputCredentials')">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="passwordInput">Password</label>
                        <div class="input-group">
                            <input type="hidden" id="org_for_credentials" value="{{$orders->organizationDetails['id']}}">
                            <input type="text" class="form-control" value="{{$orders->organizationDetails['password_text']}}" id="passwordInputCredentials" placeholder="Enter password">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" title="Copy Password" type="button" style="padding: 0rem 1rem;border: 1px solid #9cc6d7;" onclick="copyToClipboardCredentials('#passwordInputCredentials')">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                @can('credential update')
                <button type="button" onclick="updateCredentials()" class="btn btn-primary">Update</button>
                @endcan
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '.copy_credentials_btn', function() {
        var order_id = $(this).val();
        $('#copy_credentials_modal').modal('show');
    });
    function copyToClipboardCredentials(elementId) {
        var inputElement = document.querySelector(elementId);
        navigator.clipboard.writeText(inputElement.value)
            .then(function() {
                Swal.fire({
                    title: "Customer Credentials has been successfully copied",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonColor: '#0bd700',
                    confirmButtonText: 'OK',
                });
            })
            .catch(function(error) {
                console.error('Failed to copy: ', error);
                // Optionally, you can show an error message to the user
                Swal.fire({
                    title: "Failed to copy customer credentials",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonColor: '#d60000',
                    confirmButtonText: 'OK',
                });
            });
    }
    function updateCredentials(){
        var org = $('#org_for_credentials').val();
        var pwd = $('#passwordInputCredentials').val();

        $.ajax({
                url: "{{ route('order.update_credentials') }}",
                type: 'POST',
                data: {
                    org: org,
                    pwd: pwd
                },
                dataType: 'json',
                beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                },
                success: function(response) {
                    console.log('Data saved successfully:', response.success);
                    Swal.fire({
                            title: "Done!",
                            text: response.success,
                            type: "success"
                        })
                },
                error: function(xhr, status, error) {
                    console.error('Error occurred while saving data:', error);
                    Swal.fire({
                            type: 'error',
                            title: 'Apologies',
                            text: response.error
                        });
                },
                complete: function () {
                        $(".se-pre-con").fadeOut('slow');
                    }
            });
    }
</script>
