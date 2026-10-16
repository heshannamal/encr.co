<style>
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }
    .select2 {
        border-radius: 5px !important;
    }


    #select2-organization_filter-container{
        font-size: 10px !important;
    }
    #select2-asign_to_filter-container{
        font-size: 10px !important;
    }
    .card-stats .btn-sm {
        border-radius: .1rem;
    }
    .btn-link {
        color: #4c4c4c;
    }
    .btn-link.active {
        color: #5e72e4;
        background-color: #11cdef3b;
    }
    .notification-message {
        display: inline-block;
        width: 500px;
        overflow: hidden !important;
        text-overflow: ellipsis;
    }
    .is-read {
        display: none;
    }
    .not-read {
        font-weight: bold;
        color: #373737;
    }
    #notification_table tbody tr {
        cursor: pointer;
    }
    #notification_modal_label {
        font-size: 1rem;
    }
    #notification_modal_message {
        line-height: 1.4;
        overflow: auto;
    }
    .check-image {
        width: 50%;
        height: 200px;
        padding: 5px;
        overflow: hidden;
    }
    .check-image img {
        width: 100%;
        transition: all 1s;
    }
    .check-image img:hover  {
        opacity: 0.5;
    }
    #delete_btn,
    #unread_btn {
        background: transparent;
    }
    .discussion_ckeckbox .custom-control-label::before {
        border-radius: 1rem;
    }
    .discussion_ckeckbox.custom-control-input:active~.custom-control-label::before {
        background-color: #2dce89;
    }
    #comment_section {
        background-color: #f5f5f5;
        border-radius: 3px;
        font-size: 12px;
        padding: 0.5rem;
    }
    #comment_section a {
        font-size: 12px !important;
    }
    .content-position {
        position: relative;
        top: -25px;
    }
    .read-btn-position {
        position: relative;
        top: 16px;
        left: 22px;
    }
    .table-responsive .table tbody td {
        padding: 0.1rem !important;
    }
    .notification-title{
        white-space: nowrap !important;
        overflow: hidden !important;
    }
    .w200{
        width: 200px !important;
    }
    .w180{
        width: 180px !important;
    }
    .w300{
        width: 300px !important;
    }
    .w30{
        width: 20px !important;
        padding-left: 0px !important;
        padding-right: 0px !important;
    }
</style>

{{-- Notification Modal --}}
<div class="modal fade" id="notification_modal" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-" style="width: fit-content;max-width: 80%;" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal_title_notification">Your attention is required</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <input type="hidden" id="refresh_required" value="0" />
                </div>

                <div class="modal-body">
                    <div class="py-3 text-center">
                        <img src="{{asset('argon')}}/img/icons/notification_icon.png" style="width: 80px;" />
                        <h4 class="heading mt-4" id="notification_modal_label"></h4>
                        <p id="notification_modal_message"></p>

                        <div id="urgent_message">
                            <div id="confirm_message">
                                <p style="margin-bottom: unset; font-weight: 600; color: red; margin-top: 25px;">This is an urgent order.</p>
                                <p> Therefore please confirm the Ex Factory Date.</p>
                            </div>
                            <div id="in_hand_date">
                                <p></p>
                            </div>
                            <div id="ex_factory_date">
                                <p></p>
                            </div>
                            <button type="button" id="confirm_urgent" class="btn btn-outline-success">Confirm</button>
                            <button type="button" id="reject_urgent" class="btn btn-outline-warning">Reject</button>
                        </div>

                        <div id="order_confirmation_message" style="display: none">
                            <div id="order_confirm_request_message">
                                <p style="margin-bottom: unset; font-weight: 600; color: red; margin-top: 25px;">The order is now in 'PRODUCTION' status,</p>
                                <p> We kindly request your confirmation.</p>
                            </div>
                            <div id="order_confirm_or_reject_message" style="display: none"></div>
                            <div id="order_in_hand_date">
                                <p></p>
                            </div>
                            <div id="order_ex_factory_date">
                                <p></p>
                            </div>
                            <div class="mt-2 mb-3" id="techpack_download_area">

                            </div>
                            <button type="button" id="confirm_order_factory" class="btn btn-outline-success">Confirm</button>
                            <button type="button" id="reject_order_factory" class="btn btn-outline-warning">Reject</button>
                        </div>

                        <div class="col-md-12" id="comment_section">
                            <span id="notification_modal_task"></span><br>
                            <span id="notification_modal_comment"></span>
                        </div>

                        <p id="order_team" style="margin-bottom: 0rem;"></p>
                        <p id="order_description"></p>
                        <div class="col-md-12">
                            <div class="row" id="check_payment"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="" class="btn btn-white btn-sm" id="view_details_btn" style="background-color: #d2d2d2;">View Details</a>
                    <a href="" class="btn btn-white btn-sm ml-1" id="unread_btn"><i class="far fa-check-circle"></i> Mark Unread</a>
                    <a href="" class="btn btn-white btn-sm ml-1" id="delete_btn">Delete</a>
                    <button type="button" class="btn btn-link text-white ml-auto btn-sm" data-dismiss="modal">Close</button>
                </div>
        </div>
    </div>
</div>

{{-- Order Reject reson modal --}}
<div class="modal fade" id="order_rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Reason</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="order_rejecting_form">
            <div class="modal-body">
                <p>Please enter the reason for reject this order</p>
                <input type="text" name="reject_reason" class="form-control" required>
                <p>Suggested Date</p>
                <input type="text" name="ex_fac_date" id="order_ex_fac_date" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <!-- You can add a rejection action here if needed -->
                <button type="submit" class="btn btn-danger">Reject</button>
            </div>
            </form>
        </div>
    </div>
</div>
{{-- Reject reson modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Reject Reason</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Please enter the reason for reject this order</p>
                <input type="text" name="reject_reason" class="reject_reason form-control">
                <p>Suggested Date</p>
                <input type="text" name="ex_fac_date" id="ex_fac_date" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <!-- You can add a rejection action here if needed -->
                <button type="button" id="rejectOrderButton" class="btn btn-danger">Reject</button>
            </div>
        </div>
    </div>
</div>

{{-- Order Confirm Modal --}}
<div class="modal fade" id="order_confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="order_confirmation_form">
            <div class="modal-body">
                <p>Please enter the "Confirm" for confirm this order</p>
                <input type="text" name="confirm_text" class="form-control" required>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <!-- You can add a rejection action here if needed -->
                <button type="submit" class="btn btn-success">Confirm</button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- Confirm Modal --}}
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Please enter the "Confirm" for confirm this order</p>
                <input type="text" name="confirm_text" class="confirm_text form-control">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <!-- You can add a rejection action here if needed -->
                <button type="button" id="confirmOrderButton" class="btn btn-success">Confirm</button>
            </div>
        </div>
    </div>
</div>

{{--factory ex. date reject modal --}}

<div class="modal fade" id="factory_ex_rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Reason</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('reject_or_confirm_factory_suggest') }}" method="post">
            @csrf
            <input type="hidden" id="notification_id_factory_suggest_reject" name="notification_id" value="">
            <div class="modal-body">
                <p>Please enter the reason for reject this order</p>
                <input type="text" name="reject_reason" class="form-control" required>
                <p>Suggested Date</p>
                <input type="text" name="ex_fac_date" class="form-control datepicker">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Reject</button>
            </div>
            </form>
        </div>
    </div>
</div>

{{--factory ex. date confirm modal --}}

<div class="modal fade" id="factory_ex_confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('reject_or_confirm_factory_suggest') }}" method="post">
            @csrf
            <input type="hidden" id="notification_id_factory_suggest_confirm" name="notification_id" value="">
            <div class="modal-body">
                <p>Please enter the "Confirm" for confirm this order</p>
                <input type="text" name="confirm_text" class="form-control" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Confirm</button>
            </div>
            </form>
        </div>
    </div>
</div>

</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>