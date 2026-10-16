<style>
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
</style>

<div class="col-md-12 mt-4" id="notifications_interface" @if (request()->has('interface')) @else style="display: none;" @endif>
    <div class="card">
        <div class="card-header">
            <div class="card-header-danger col-md-12">
                <h1 class="float-left header-title">Notifications</h1>

                <div class="float-right header-icons">
                    {{-- <span>
                        <a class="btn btn-round" href="#" data-toggle="modal" data-target="#layout_modal">
                            <i class="fas fa-wrench"></i>
                        </a>
                        <p>Table Layout</p>
                    </span> --}}
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-3 text-right drive-controls">
            <button type="button" class="btn btn-secondary btn-sm" title="Mark As read" id="markAsRead"><i class="fas fa fa-check-circle" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-secondary btn-sm" title="Mark As Unread" id="unreadSelectedRecords"><i class="fas fa fa-minus-circle" aria-hidden="true"></i></button>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                <div class="table-responsive" style="overflow-x: clip;">
                    <table class="table align-items-center table-responsive table-bordered" id="notification_table" style="width: 100%;">
                        <thead class="bg-theme">
                            <th scope='col'>
                                <div class="custom-control custom-checkbox discussion_ckeckbox">
                                    <input type="checkbox" class="custom-control-input"  id='checkAll' name='ids'/>
                                    <label for='checkAll' class="custom-control-label"></label>
                                </div>
                            </th>
                            <th scope="col">Team</th>
                            <th scope="col">Title</th>
                            <th scope="col">Message</th>
                            <th scope="col">Created At</th>
                            <th scope="col" class="is-read">Is Read</th>
                        </thead>

                        <tbody class="list">
                            @foreach ($notifications as $notification)
                                @if($notification->active == 1)
                                    <tr data-notification-id="{{$notification->id}}">
                                        <td id="checklist" class="notification-team @if ($notification->is_read == 0) not-read @endif">
                                            <div class="custom-control custom-checkbox discussion_ckeckbox">
                                                <input type="checkbox" class="custom-control-input clickAllCheckbox"  id='{{$notification->id}}' name='ids' value='{{$notification->id}}'/>
                                                <label for='{{$notification->id}}' class="custom-control-label"></label>
                                            </div>
                                        </td>
                                        <td  class="notification-team @if ($notification->is_read == 0) not-read @endif not-checklist">{{$notification->orderDetails->organizationDetails['organization_name']}}</td>
                                        <td  class="notification-title @if ($notification->is_read == 0) not-read @endif not-checklist">{{$notification->notification_title}}</td>

                                        @if ($notification->task_name)
                                            <td  class="notification-message @if ($notification->is_read == 0) not-read @endif not-checklist">{{'Discussion: '.$notification->task_name.' | '.$notification->notification_message}}</td>
                                        @else
                                            <td  class="notification-message @if ($notification->is_read == 0) not-read @endif not-checklist">{{$notification->notification_message}}</td>
                                        @endif

                                        <td  class="created-at @if ($notification->is_read == 0) not-read @endif not-checklist">{{date('m-d-Y', strtotime($notification->created_at))}}</td>
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

{{-- Notification Modal --}}
<div class="modal fade" id="notification_modal" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-" role="document">
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

<script>
    $(document).ready(function(){
        $('#notification_table').DataTable({
            "order": [[ 5, 'asc' ]],
            "pageLength": 25,
        });
        // $('#notification_table  td:nth-child(1n)').unbind('click');
        //$('#notification_table tr').unbind('click');
    });

    $('.not-checklist').on('click', function(e){
         var $row = $(this).parent().data();
        var notificationId = $(this).parent().data('notification-id');
        console.log($(this).data('notification-id'));
        $.ajax({
            url:"{{ url('notifications/get_details') }}/"+notificationId,
            method:'GET',
            dataType:'json',
            success: function (data){
                console.log(data);
                var notification = data.notification;
                var check_payment = data.check_payment;
                var order_details = data.order_details;

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

                $('#notification_modal_label').html(notification.order_details.organization_details.organization_name);
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

                if (notification.is_comment == 1) {
                    $('#view_details_btn').attr('href', '{{url("order_details/edit")}}/'+notification.order_id+'?active_tab=order_mangement&taskId='+notification.task_id);
                } else {
                    $('#view_details_btn').attr('href', '{{url("order_details/edit")}}/'+notification.order_id+'?active_tab=order');
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
                                var url = window.location.href;
                                url += '?interface=notifications'
                                window.location.href = url;
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
                            success: function (data){
                                console.log(data);
                                var url = window.location.href;
                                url += '?interface=notifications'
                                window.location.href = url;
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

                    $('#check_payment').html(check_images+payment_form);
                } else {
                    $('#check_payment').html('');
                }
            }
        });
    });

    $('#notification_modal').on('hidden.bs.modal', function () {
        if($('#refresh_required').val() == 1) {
            var url = window.location.href;
            url += '?interface=notifications'
            window.location.href = url;
            // location.reload();
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



</script>


