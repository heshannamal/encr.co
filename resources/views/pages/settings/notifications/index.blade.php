@extends('layouts.app', ['activePage' => 'notifications', 'titlePage' => __('Notifications')])

@section('content')
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
    .custom-control-label::after {
        position: relative;
    }
    .custom-control-label.layout::after {
        position: absolute;
    }
    .activity-checkbox {
        margin-top: 0;
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
<div class="container-fluid mb-5 content-position" >
    <div class="se-pre-con"></div>

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12 mt-4">
        <div class="card">
            {{-- <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <h1 class="float-left header-title">Notifications</h1>

                    <div class="float-right header-icons">
                        <span>
                            <a class="btn btn-round" href="#" data-toggle="modal" data-target="#layout_modal">
                                <i class="fas fa-wrench"></i>
                            </a>
                            <p>Table Layout</p>
                        </span>
                    </div>
                </div>
            </div> --}}
            <div class="col-md-12 mb-3 drive-controls read-btn-position">
                <button type="button" class="btn btn-secondary btn-sm" title="Mark As read" style="background-color: #e1ffe1;" id="markAsRead"><i class="fas fa fa-check-circle" style="color: lime;" aria-hidden="true"></i></button>
                <button type="button" class="btn btn-secondary btn-sm" title="Mark As Unread" style="background-color: #ffeeee;" id="unreadSelectedRecords"><i class="fas fa fa-minus-circle" style="color: #ff3737;" aria-hidden="true"></i></button>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="table-responsive" style="overflow-x: clip;">
                        <table class="table align-items-center table-responsive table-bordered" id="notification_table" style="width: 100%;">
                            <thead class="bg-theme">
                                <th scope='col' class="w30">
                                    <div class="custom-control custom-checkbox discussion_ckeckbox">
                                        <input type="checkbox" class="custom-control-input"  id='checkAll' name='ids'/>
                                        <label for='checkAll' class="custom-control-label"></label>
                                    </div>
                                </th>
                                <th scope="col" class="w180">Team</th>
                                <th scope="col " class="w300">Title</th>
                                <th scope="col " class="w300">Message</th>
                                <th scope="col">Created At</th>
                                <th scope="col" class="is-read">Is Read</th>
                            </thead>

                            <tbody class="list">
                                @foreach ($notifications as $notification)
                                <?php
                                    $notification_title = $notification->notification_title;
                                    $shortened_title = strlen($notification_title) > 30 ? substr($notification_title, 0, 30) . '...' : $notification_title;

                                ?>
                                    @if($notification->active == 1)
                                        <tr data-notification-id="{{$notification->id}}">
                                            <td id="checklist " class="notification-team w30 @if ($notification->is_read == 0) not-read @endif">
                                                <div class="custom-control custom-checkbox discussion_ckeckbox">
                                                    <input type="checkbox" class="custom-control-input clickAllCheckbox"  id='{{$notification->id}}' name='ids' value='{{$notification->id}}'/>
                                                    <label for='{{$notification->id}}' class="custom-control-label"></label>
                                                </div>
                                            </td>
                                            <td  class="notification-team w180 @if ($notification->is_read == 0) not-read @endif not-checklist">{{$notification->orderDetails->organizationDetails['organization_name'] ?? ''}}</td>
                                            <td  class="notification-title w300 @if ($notification->is_read == 0) not-read @endif not-checklist">{{ $shortened_title}}</td>

                                            @if ($notification->task_name)
                                                <td class="notification-message w300 @if ($notification->is_read == 0) not-read @endif not-checklist">
                                                    {{ 'Discussion: '.$notification->task_name.' | '.strip_tags($notification->notification_message) }}
                                                </td>
                                            @else
                                                <td class="notification-message w300 @if ($notification->is_read == 0) not-read @endif not-checklist">
                                                    {{ strip_tags($notification->notification_message) }}
                                                </td>
                                            @endif

                                            <td  class="created-at @if ($notification->is_read == 0) not-read @endif not-checklist">{{date('m-d-Y h:i A', strtotime($notification->created_at))}}</td>
                                            <td class="is-read">{{$notification->is_read}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
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

<script>

$('#ex_fac_date').datepicker({
  minDate: 0 // Setting minDate to 0 ensures that today's date is the minimum selectable date
});
$('#order_ex_fac_date').datepicker({
  minDate: 0 // Setting minDate to 0 ensures that today's date is the minimum selectable date
});

    let header = "NOTIFICATIONS";
        document.getElementById("header").innerHTML = header;

    $(document).ready(function(){
        $('#notification_table').DataTable({
            "order": [[ 5, 'asc' ]],
            "pageLength": 25,
        });
        // $('#notification_table  td:nth-child(1n)').unbind('click');
        //$('#notification_table tr').unbind('click');
        $(".se-pre-con").fadeOut('slow');
    });

    $('.not-checklist').on('click', function(e){
         var $row = $(this).parent().data();
        var notificationId = $(this).parent().data('notification-id');
        $('#notification_id_factory_suggest_confirm').val(notificationId);
        $('#notification_id_factory_suggest_reject').val(notificationId);
        console.log('notificationId '+notificationId);
        $.ajax({
            url:"{{ url('notifications/get_details') }}/"+notificationId,
            method:'GET',
            dataType:'json',
            success: function (data){
                console.log(data);
                var notification = data.notification;
                var check_payment = data.check_payment;
                var venmo_payment = data.venmo_payment;
                var other_payment = data.other_payment;
                var order_details = data.order_details;

                console.log('order details :'+data.order_details);

                if (order_details) {
                    var order_team = '<small>'+notification.notification_title+'</small>';
                    var order_description = '<small>Description : '+order_details.order_description+'</small>';
                    $('#order_team').html(order_team);
                    $('#order_description').html(order_description);
                } else {
                    $('#order_team').html('');
                    $('#order_description').html('');
                }

                var notifi_at = new Date(notification.created_at);
                var notifi_date = notifi_at.getDate();
                var notifi_month = notifi_at.getMonth()+1;
                var notifi_year = notifi_at.getFullYear();

                if(notifi_month == 1){ var notifi_month_name = 'Jan';
                } else if(notifi_month == 2){ var notifi_month_name = 'Feb';
                } else if(notifi_month == 3){ var notifi_month_name = 'Mar';
                } else if(notifi_month == 4){ var notifi_month_name = 'Apr';
                } else if(notifi_month == 5){ var notifi_month_name = 'May';
                } else if(notifi_month == 6){ var notifi_month_name = 'Jun';
                } else if(notifi_month == 7){ var notifi_month_name = 'Jul';
                } else if(notifi_month == 8){ var notifi_month_name = 'Aug';
                } else if(notifi_month == 9){ var notifi_month_name = 'Sep';
                } else if(notifi_month == 10){ var notifi_month_name = 'Oct';
                } else if(notifi_month == 11){ var notifi_month_name = 'Nov';
                } else { var notifi_month_name = 'Dec';
                }

                if (notification.order_details && notification.order_details.organization_details) {
                    $('#notification_modal_label').html(notification.order_details.organization_details.organization_name);
                }else{
                    $('#notification_modal_label').html('');
                }
                $('#notification_modal_message').html(notification.notification_message);
                if (notification.task_name) {
                    $('#comment_section').show();
                    $('#notification_modal_task').html('Discussion: '+notification.task_name);
                    $('#notification_modal_comment').html(notification.task_comments);
                } else {
                    $('#comment_section').hide();
                    $('#notification_modal_task').html('');
                    $('#notification_modal_comment').html('');
                }
                $('#modal_title_notification').html(notifi_month_name+'-'+('0' + notifi_date).slice(-2)+'-'+notifi_year);

                //If Moved to production
                $('#order_confirmation_message').hide();

                if(notification.notification_message && notification.notification_message.includes('has been moved to production') && notification.is_urgent != 1){
                    console.log('Here works !');
                    $('#techpack_download_area').html('');
                    var orderItemId = notification.order_item_id;
                    var redirectUrl = "{{ url('orders/DownloadTestPrint/') }}" + "/" + encodeURIComponent(orderItemId);

                    $('#order_confirmation_message').show();
                    $('#order_in_hand_date p').text('In Hand Due Date : '+notification.order_in_hand_due_date);
                    $('#order_ex_factory_date p').text('Ex Factory Date : '+notification.order_ex_fac_date);
                    if(notification.order_reject_or_confirm == 1){

                        $('#order_confirm_request_message').hide();
                        $('#confirm_order_factory').hide();
                        $('#reject_order_factory').hide();
                        $('#order_confirm_or_reject_message').html('<p style="margin-bottom: unset; font-weight: 600; color: red; margin-top: 25px;" class="mt-1 mb-1">Order rejected</p>');
                        $('#order_confirm_or_reject_message').show();

                        $('#techpack_download_area').append('<p>To Check Techpack - <a href="' + redirectUrl + '">Click Here</a></p>');

                    }else if(notification.order_reject_or_confirm == 2){
                        $('#order_confirm_request_message').hide();
                        $('#confirm_order_factory').hide();
                        $('#reject_order_factory').hide();
                        $('#order_confirm_or_reject_message').html('<p style="margin-bottom: unset; font-weight: 600; color: green; margin-top: 25px;" class="mt-1 mb-1">Order already confirmed</p>');
                        $('#order_confirm_or_reject_message').show();

                        $('#techpack_download_area').append('<p>To Check Techpack - <a href="' + redirectUrl + '">Click Here</a></p>');
                    }else{
                        $('#order_confirm_or_reject_message').hide();
                        $('#order_confirm_request_message').show();
                        $('#confirm_order_factory').show();
                        $('#reject_order_factory').show();

                        $('#techpack_download_area').append('<p>To Check Techpack - <a href="' + redirectUrl + '">Click Here</a></p>');
                    }
                    $('#reject_order_factory').on('click', function() {
                        $('#order_rejectModal').modal('show'); // Open the reject modal
                    });

                    $('#confirm_order_factory').on('click', function() {
                        $('#order_confirmModal').modal('show'); // Open the confirm modal
                    });

                    $('#order_rejecting_form').on('submit', function() {
                        var formData = $(this).serialize();
                        var urlParams = new URLSearchParams(formData);

                        var rejectReason = urlParams.get('reject_reason');

                        var suggestedDate = urlParams.get('ex_fac_date');

                        var orderId = notification.order_id;
                        var orderItemId = notification.order_item_id;

                        var redirectUrl = "{{ url('factory_order_reject') }}?reject_reason=" + encodeURIComponent(rejectReason) + "&suggested_date=" + encodeURIComponent(suggestedDate) + "&order_id=" + encodeURIComponent(orderId) + "&notificationId=" + encodeURIComponent(notificationId) + "&order_item_id=" + encodeURIComponent(orderItemId);

                        window.location.href = redirectUrl;

                        return false;

                    });
                    $('#order_confirmation_form').on('submit', function() {
                        var formData = $(this).serialize();
                        var urlParams = new URLSearchParams(formData);

                        var orderId = notification.order_id;
                        var orderItemId = notification.order_item_id;
                        var confirmText = urlParams.get('confirm_text').toLowerCase();

                        if (confirmText === "confirm") {
                            var redirectUrl = "{{ url('factory_order_confirm') }}?order_id=" + encodeURIComponent(orderId) + "&notificationId=" + encodeURIComponent(notificationId) + "&order_item_id=" + encodeURIComponent(orderItemId);
                            window.location.href = redirectUrl;
                        } else {
                            alert("Confirm is different with 'Confirm'.");
                        }

                        return false;
                    });

                }

                // If urgent order
                if (notification.is_urgent == 1) {
                    $('#urgent_message').show();
                    if (notification.order_reject_or_confirm == 2 || notification.order_reject_or_confirm == 1) {
                        if (notification.order_reject_or_confirm == 1) {
                            $('#confirm_message p').text("This urgent order was Rejected");
                        } else {
                            $('#confirm_message p').text("This urgent order was Confirmed");
                            $('#in_hand_date p').text('In Hand Due Date : '+notification.order_in_hand_due_date);
                            $('#ex_factory_date p').text('Ex Factory Date : '+notification.order_ex_fac_date);
                        }

                        $('#confirm_urgent').hide();
                        $('#reject_urgent').hide();

                    } else {

                        // $('#confirm_message p').text("This is an urgent order. Therefore please confirm the Ex Factory Date.");
                        $('#in_hand_date p').text('In Hand Due Date : '+notification.order_in_hand_due_date);
                        $('#ex_factory_date p').text('Ex Factory Date : '+notification.order_ex_fac_date);

                    }

                } else {
                    $('#urgent_message').hide();
                }

                $('#reject_urgent').on('click', function() {
                    $('#rejectModal').modal('show'); // Open the reject modal
                });

                $('#confirm_urgent').on('click', function() {
                    $('#confirmModal').modal('show'); // Open the reject modal
                });

                // Reject button
                $('#rejectOrderButton').click(function() {
                    var rejectReason = $('.reject_reason').val();

                    var suggestedDate = $('#ex_fac_date').val();

                    var orderId = notification.order_id;
                    var orderItemId = notification.order_item_id;

                    var redirectUrl = "{{ url('urgent_order_reject') }}?reject_reason=" + encodeURIComponent(rejectReason) + "&suggested_date=" + encodeURIComponent(suggestedDate) + "&order_id=" + encodeURIComponent(orderId) + "&notificationId=" + encodeURIComponent(notificationId) + "&order_item_id=" + encodeURIComponent(orderItemId);

                    window.location.href = redirectUrl;

                    return false;
                });

                // Confirm button
                $('#confirmOrderButton').click(function() {
                    var orderId = notification.order_id;
                    var orderItemId = notification.order_item_id;
                    var confirmText = $('.confirm_text').val().toLowerCase();

                    if (confirmText === "confirm") {
                        var redirectUrl = "{{ url('urgent_order_confirm') }}?order_id=" + encodeURIComponent(orderId) + "&notificationId=" + encodeURIComponent(notificationId) + "&order_item_id=" + encodeURIComponent(orderItemId);
                        window.location.href = redirectUrl;
                    } else {
                        // Display a message without refreshing the page
                        alert("Confirm is different with 'Confirm'."); // You can customize the message as needed
                    }

                    return false;
                });


                if (notification.is_comment == 1) {
                    // $('#view_details_btn').attr('href', '{{url("order_details/edit")}}/'+notification.order_id+'?active_tab=order_mangement&taskId='+notification.task_id+'&comment_mention_id='+notification.comment_mention_id);
                    $('#view_details_btn').attr('href', '{{url("order_details/edit")}}/'+notification.order_id+'/order?active_tab=order_mangement_tab&taskId='+notification.task_id+'&comment_mention_id='+notification.comment_mention_id);
                }else if(notification.activity_id){
                    $('#view_details_btn').attr('href', '{{ route("activities") }}?open_modal=true&activity_id=' + notification.activity_id);
                }else if(notification.project_id){
                    $('#view_details_btn').attr('href', '{{ url("projects/view") }}/'+notification.project_id);
                }else if(notification.task_id){
                    $('#view_details_btn').attr('href', '{{ route("projects.my_tasks") }}?open_chat=true&type="discussion"&discussion_id=' + notification.task_id);
                }else if(notification.sub_task_id){
                    $('#view_details_btn').attr('href', '{{ route("projects.my_tasks") }}?open_chat=true&type="sub_discussion"&discussion_id=' + notification.sub_task_id);
                } else {
                    if(notification.is_order_edit == 1){
                        $('#view_details_btn').attr('href', '{{url("order_details/edit")}}/'+notification.order_id+'/order?active_tab='+notification.order_item_id+'&notify_field='+notification.target_field);
                    } else {
                        $('#view_details_btn').attr('href', '{{url("order_details/edit")}}/'+notification.order_id+'/order?active_tab=order');
                    }
                }

                // unread notification
                $('#unread_btn').click(function () {
                    var id = $(this).attr("id");

                    $.ajax({
                            url:"{{ url('notifications/unread') }}/"+notificationId,
                            method:'GET',
                            dataType:'json',
                            success: function (data){
                                console.log(data);
                                location.reload();

                                // var url = window.location.href;
                                // // url += '?interface=notifications'
                                // window.location.href = url;
                            }

                    });

                    return false;
                });
                // delete notification
                $('#delete_btn').click(function () {
                    var id = $(this).attr("id");

                    $.ajax({
                            url:"{{ url('notifications/delete') }}/"+notificationId,
                            method:'GET',
                            dataType:'json',
                            beforeSend: function (){
                                $(".se-pre-con").fadeIn();
                            },
                            success: function (data){
                                console.log(data);
                                location.reload();
                                // var url = window.location.href;
                                // // url += '?interface=notifications'
                                // window.location.href = url;
                            }

                    });

                    return false;
                });

                  $('#notification_modal').modal('show');

                 if(notification.is_read == 0) {
                   updateNotifiState(notificationId);
                } else {
                    $('#refresh_required').val(0);
                }

                if (check_payment) {
                    var order_no = ('000000' + check_payment.order_id).slice(-6);

                    var check_images = '<a class="check-image" download="'+order_no+'-check-front.jpg" href="{{asset("uploads")}}/../'+check_payment.check_front+'" title="Check Front">'+
                                            '<img src="{{asset("uploads")}}/../'+check_payment.check_front+'" />'+
                                        '</a>'+
                                        '<a class="check-image" download="'+order_no+'-check-back.jpg" href="{{asset("uploads")}}/../'+check_payment.check_back+'" title="Check Back">'+
                                            '<img src="{{asset("uploads")}}/../'+check_payment.check_back+'" />'+
                                        '</a>';

                    if (check_payment.is_approved == 0) {
                        var payment_form = '<form method="post" action="{{ route("activities.check_approve") }}" class="col-md-12 mt-3">@csrf'+
                                            '<div class="col-md-12 form-field text-center">'+
                                                '<input type="number" step="0.01" class="form-control" id="check_amount" name="check_amount" placeholder="Check Amount ($)" required />'+
                                                '<button type="submit" class="btn btn-success btn-sm" name="check_payment_id" value="'+check_payment.id+'">Approve</button>'
                                            '</div>'+
                                       '</form>';
                    } else {
                        var payment_form = '<div class="col-md-12 mt-3"><button type="button" class="btn btn-success btn-sm">Check Approved</button></div>';
                    }

                    $("#check_payment").removeClass('justify-content-center');
                    $('#check_payment').html(check_images+payment_form);
                }else if (other_payment) {
                    var order_no = ('000000' + other_payment.order_id).slice(-6);

                    var check_images = '<a class="check-image" download="'+order_no+'-other-front.jpg" href="{{asset("uploads")}}/../'+other_payment.document_url+'" title="Check Front">'+
                                            '<img src="{{asset("uploads")}}/../'+other_payment.document_url+'" />'+
                                        '</a>'+
                                        '<a class="check-image" download="'+order_no+'-other-back.jpg" href="{{asset("uploads")}}/../'+other_payment.document_url_back+'" title="Check Back">'+
                                            '<img src="{{asset("uploads")}}/../'+other_payment.document_url_back+'" />'+
                                        '</a>';

                    // if (other_payment.is_approved == 0) {
                    //     var payment_form = '<form method="post" action="{{ route("activities.check_approve") }}" class="col-md-12 mt-3">@csrf'+
                    //                         '<div class="col-md-12 form-field text-center">'+
                    //                             '<input type="number" step="0.01" class="form-control" id="check_amount" name="check_amount" placeholder="Check Amount ($)" required />'+
                    //                             '<button type="submit" class="btn btn-success btn-sm" name="other_payment_id" value="'+other_payment.id+'">Approve</button>'
                    //                         '</div>'+
                    //                    '</form>';
                    // } else {
                    //     var payment_form = '<div class="col-md-12 mt-3"><button type="button" class="btn btn-success btn-sm">Payment Approved</button></div>';
                    // }
                    var payment_form = '<div class="col-md-12 mt-3"><button type="button" class="btn btn-success btn-sm">Payment Approved</button></div>';

                    $("#check_payment").removeClass('justify-content-center');
                    $('#check_payment').html(check_images+payment_form);
                } else if (venmo_payment) {
                    var order_no = ('000000' + venmo_payment.order_id).slice(-6);

                    var venmo_images = '<a class="check-image" download="'+order_no+'-venmo.jpg" href="{{asset("uploads")}}/../'+venmo_payment.venmo_receipt+'" title="Venmo Receipt">'+
                                            '<img src="{{asset("uploads")}}/../'+venmo_payment.venmo_receipt+'" />'+
                                        '</a>';

                    if (venmo_payment.is_approved == 0) {
                        var payment_form = '<form method="post" action="{{ route("payment.venmo_approve") }}" class="col-md-12 mt-3">@csrf'+
                                            '<div class="col-md-12 form-field text-center">'+
                                                '<input type="number" step="0.01" class="form-control" id="venmo_amount" name="approve_amount" placeholder="Venmo Amount ($)" required />'+
                                                '<button type="submit" class="btn btn-success btn-sm" name="venmo_payment_id" value="'+venmo_payment.id+'">Approve</button>'
                                            '</div>'+
                                       '</form>';
                    } else {
                        var payment_form = '<div class="col-md-12 mt-3"><button type="button" class="btn btn-success btn-sm">Venmo Approved</button></div>';
                    }

                    $("#check_payment").addClass('justify-content-center');
                    $('#check_payment').html(venmo_images+payment_form);
                } else {
                    $('#check_payment').html('');
                }
            }
        });
    });

    $(document).on('click', '.btn-reject-factory-ex', function() {
        $('#factory_ex_rejectModal').modal('show');
    });
    $(document).on('click', '.btn-confirm-factory-ex', function() {
        $('#factory_ex_confirmModal').modal('show');
    });

    $('#notification_modal').on('hidden.bs.modal', function () {
        if($('#refresh_required').val() == 1) {
            // var url = window.location.href;
            // // url += '?interface=notifications'
            // window.location.href = url;
            location.reload();
        }
    })

    function updateNotifiState(notificationId) {
        $.ajax({
            url:"{{ url('activities/read_notification') }}/"+notificationId,
            method:'GET',
            dataType:'json',
            success: function (data){
                $('#refresh_required').val(1);
                console.log(data);
            }
        });
    }


    function updateMarkread(notificationId) {
        $.ajax({
            url:"{{ url('activities/read_notification') }}/"+notificationId,
            method:'GET',
            dataType:'json',
            success: function (data){
                $('#refresh_required').val(1);
                console.log(data);
            }
        });
    }


    $('#markAsRead').click(function(e){
        e.preventDefault();
        var allid = [];
        $("input:checkbox[name=ids]:checked").each(function(){
            allid.push($(this).val());
        });

        allid = jQuery.grep(allid, function(value) {
            return value != 'on';
        });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
            url:"{{ url('notifications/mark_as_read')}}",
            method:'POST',
            data: {
                 allid:allid,
                _token:$("input[name=_token]").val()

            },
            success: function(data){
                Swal.fire({
                    title: "Done!",
                    text: "Notifications Mark As Read!",
                    type: "success",
                    allowOutsideClick: false,
                }).then(function(isConfirm) {
                    if (isConfirm.value == true) {
                        location.reload();
                    }
                });
                console.log(data);
            }
        });
    });


    $('#unreadSelectedRecords').click(function(e){
        e.preventDefault();
        var allid = [];
        $("input:checkbox[name=ids]:checked").each(function(){
            allid.push($(this).val());
        });

        allid = jQuery.grep(allid, function(value) {
            return value != 'on';
        });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{ url('notifications/mark_as_unread')}}",
            method:'POST',
            data: {
                allid:allid,
                _token:$("input[name=_token]").val()

            },
            success: function(data){
                Swal.fire({
                    title: "Done!",
                    text: "Notifications Mark As Unread!",
                    type: "success",
                    allowOutsideClick: false,
                }).then(function(isConfirm) {
                    if (isConfirm.value == true) {
                        location.reload();
                    }
                });
                console.log(data);
            }
        });
    });


    $('#checkAll').click(function(e){
        var table= $(e.target).closest('table');
        $('td input:checkbox',table).prop('checked',this.checked);
    });
    $(document).on('click', '.add_to_my_list', function() {
        var templateId = $(this).data('template_id');
        $.ajax({
            url: "{{ url('email/templates/add') }}/" + templateId,
            method: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data) {
                $(".se-pre-con").fadeOut('slow');
                Swal.fire({
                    title: 'Success!',
                    text: 'Successfully added to your list.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },

        });
    })



</script>

@endsection
