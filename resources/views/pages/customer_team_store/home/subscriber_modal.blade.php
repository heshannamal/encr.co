<style>
.modal-header .btn-close {
    border: none;
    font-size: 1.5rem;
    opacity: 1;
    background-color: transparent;
    background-image: none;
    line-height: 1;
    cursor: pointer;
    position: relative;
    z-index: 2;
}
#modalForm.was-validated .form-control:not([required]):valid {
    border-color: #dee2e6;
    background-image: none;
    padding-right: .75rem;
}
#modalForm.was-validated .form-control:not([required]):valid:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
}
</style>
<!-- Modal -->
<div class="modal fade" id="newsletterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 shadow p-3">

            <!-- Header -->
            <div class="modal-header border-0">
                <div>
                    <h2 class="modal-title fw-bold">Get In Touch</h2>
                    <p class="text-muted mb-0">
                        Fill out the form below and our team will reach out shortly.
                    </p>
                </div>
                <button type="button" class="btn-close" id="newsletterModalClose" aria-label="Close">&times;</button>
            </div>

            <!-- Body -->
            <div class="modal-body">

                <form id="modalForm" novalidate>

                    <!-- Parent Information -->
                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted mb-3">Parent Information</h6>

                        <div class="mb-3">
                            <label for="parent_name" class="form-label">Parent Name <span class="text-danger">*</span></label>
                            <input
                                id="parent_name"
                                type="text"
                                class="form-control form-control-lg"
                                placeholder="John Doe"
                                required
                            >
                            <div class="invalid-feedback">Please enter the parent name.</div>
                        </div>

                        <div class="mb-3">
                            <label for="parent_email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input
                                id="parent_email"
                                type="email"
                                class="form-control form-control-lg"
                                placeholder="john@example.com"
                                required
                            >
                            <div class="invalid-feedback">Please enter a valid email address.</div>
                        </div>

                        <div class="mb-3">
                            <label for="parent_cell" class="form-label">Cell Phone <span class="text-danger">*</span></label>
                            <input
                                id="parent_cell"
                                type="text"
                                class="form-control form-control-lg"
                                placeholder="(555) 123-4567"
                                required
                            >
                            <div class="invalid-feedback">Please enter a cell phone number.</div>
                        </div>
                    </div>

                    <!-- Player Information -->
                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted mb-3">Player Information</h6>

                        <div class="mb-3">
                            <label for="player_name" class="form-label">Player Name</label>
                            <input
                                id="player_name"
                                type="text"
                                class="form-control form-control-lg"
                                placeholder="Player Name"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="player_grade" class="form-label">Player Grade</label>
                            <input
                                id="player_grade"
                                type="text"
                                class="form-control form-control-lg"
                                placeholder="Grade Level"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="player_rec" class="form-label">
                                Spring Rec Club / High School
                            </label>
                            <input
                                id="player_rec"
                                type="text"
                                class="form-control form-control-lg"
                                placeholder="Club or School Name"
                            >
                        </div>
                    </div>

                    <!-- Additional Comments -->
                    <div class="mb-2">
                        <h6 class="text-uppercase text-muted mb-3">Additional Details</h6>

                        <textarea
                            id="other_comments"
                            class="form-control"
                            rows="4"
                            placeholder="Any questions or additional information..."
                        ></textarea>
                    </div>

                </form>

            </div>

            <!-- Footer -->
            <div class="modal-footer border-0 justify-content-center">
                <button
                    id="submitButton"
                    type="button"
                    class="btn btn-primary btn-lg w-100"
                    style="background-color:#ec4899;border:none;"
                >
                    Submit
                </button>
            </div>

        </div>
    </div>
</div>

<script>
$(document).ready(function () {

    const SUBSCRIBER_API = "{{ env('SUBSCRIBER_API') }}";
    const API_TOKEN = "{{ env('API_Token') }}";
    const API_TYPE = "{{ env('API_TYPE') }}";

    const modal = new bootstrap.Modal(document.getElementById('newsletterModal'));
    const form = document.getElementById('modalForm');

    $('#newsletterModalClose').on('click', function () {
        form.classList.remove('was-validated');
        modal.hide();
    });

    /* ----------------------------------------
       Open modal & prefill email
    ----------------------------------------- */
    $('#team-store-subscriber-btn').on('click', function (e) {
        e.preventDefault();

        const email = $('#team-store-subscriber').val().trim();

        if (email === '') {
            Swal.fire({
                position: 'top',
                icon: 'warning',
                title: 'Please enter your email address',
                showConfirmButton: false,
                timer: 3000,
                toast: true
            });
            return;
        }

        $('#parent_email').val(email);
        form.classList.remove('was-validated');
        modal.show();
    });

    /* ----------------------------------------
       Submit modal form
    ----------------------------------------- */
    $('#submitButton').on('click', function () {

        $('#modalForm input[required]').each(function () {
            this.value = this.value.trim();
        });

        form.classList.add('was-validated');
        if (!form.checkValidity()) {
            $('#modalForm :invalid').first().focus();
            return;
        }

        const $btn = $(this);
        $btn.prop('disabled', true).text('Sending...');

        const payload = {
            parent_name: $('#parent_name').val(),
            email: $('#parent_email').val(),
            parent_cell: $('#parent_cell').val(),
            player_name: $('#player_name').val(),
            player_grade: $('#player_grade').val(),
            player_rec: $('#player_rec').val(),
            other_comments: $('#other_comments').val(),
            platform: '{{ $store->store_name }}',
            note: 'Submitted via Team Store contact modal',
            type: 1,
            team_store_id: {{ $store->id }}
        };

        $.ajax({
            url: SUBSCRIBER_API,
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + API_TOKEN,
                'API-Type': API_TYPE,
                'Accept': 'application/json'
            },
            contentType: 'application/json',
            data: JSON.stringify(payload),

            success: function (data) {
                if (data.success) {
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: data.message || 'Subscription successful!',
                        showConfirmButton: false,
                        timer: 4000,
                        toast: true
                    });

                    $('#modalForm').find('input, textarea').val('');
                    $('#team-store-subscriber').val('');
                    form.classList.remove('was-validated');

                    modal.hide();
                } else {
                    Swal.fire({
                        position: 'top',
                        icon: 'warning',
                        title: data.message || 'Validation failed',
                        showConfirmButton: false,
                        timer: 4000,
                        toast: true
                    });
                }
            },

            error: function (xhr) {
                let message = 'API not reachable or configuration invalid.';

                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    const firstError = Object.values(xhr.responseJSON.errors)[0];
                    message = Array.isArray(firstError) ? firstError[0] : firstError;
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                Swal.fire({
                    position: 'top',
                    icon: 'error',
                    title: message,
                    showConfirmButton: false,
                    timer: 5000,
                    toast: true
                });
            },

            complete: function () {
                $btn.prop('disabled', false).text('Submit');
            }
        });
    });

});
</script>