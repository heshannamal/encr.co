<style>
.modal-header .btn-close {
    border: none;
    font-size: 1.5rem;
    opacity: 1;
    background-color: transparent;
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
                <button type="button" class="btn-close" aria-hidden="true" data-bs-dismiss="modal">&times;</button>
            </div>

            <!-- Body -->
            <div class="modal-body">

                <form id="modalForm">

                    <!-- Parent Information -->
                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted mb-3">Parent Information</h6>

                        <div class="mb-3">
                            <label for="parent_name" class="form-label">Parent Name</label>
                            <input
                                id="parent_name"
                                type="text"
                                class="form-control form-control-lg"
                                placeholder="John Doe"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="parent_email" class="form-label">Email Address</label>
                            <input
                                id="parent_email"
                                type="email"
                                class="form-control form-control-lg"
                                placeholder="john@example.com"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="parent_cell" class="form-label">Cell Phone</label>
                            <input
                                id="parent_cell"
                                type="text"
                                class="form-control form-control-lg"
                                placeholder="(555) 123-4567"
                            >
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
        modal.show();
    });

    /* ----------------------------------------
       Submit modal form
    ----------------------------------------- */
    $('#submitButton').on('click', function () {

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
            team_store_id: '{{ $store->id }}',
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
                    $('#newsletter-email').val('');

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

                if (xhr.responseJSON && xhr.responseJSON.message) {
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
