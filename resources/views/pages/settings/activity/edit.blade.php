@extends('layouts.app', ['activePage' => 'activities', 'titlePage' => __('Edit Activity')])

@section('content')
<div class="container-fluid mt-5">
    <form action="{{ route('activities.update')}}" method="post">
        @csrf
        <input type="hidden" name="activity_id" value="{{$activity->id}}" />
        @isset($organizationId) <input type="hidden" name="existing_organization" value="{{$organizationId}}" /> @endisset

        <div class="card mb-2">
            <div class="card-header d-flex justify-content-between">
                <h2> Edit Scheduled Activity </h2>
                <a href="{{ route('activities') }}" class="btn btn-secondary"><i class="fa fa-angle-left" aria-hidden="true"></i> Back To Activities</a>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="col-md-12 form-field">
                        <label class="modal-form-lable"><i class="far fa-list-alt"></i></label>&nbsp;
                        <input type="text" class="form-control" id="description" name="description" placeholder="Enter Activity Description" value="{{$activity->description}}" />
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-12 form-field">
                        <label class="modal-form-lable"><i class="far fa-clock"></i></label>&nbsp;
                        <div class="row" style="width: 100%;">
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="start_date" name="start_date" value="{{$activity->start_date}}" />
                            </div>

                            <div class="col-md-3" style="display: flex;">
                                <input type="text" class="form-control timepicker" id="start_time" name="start_time" placeholder="hh:mm PM" value="{{$activity->start_time}}" />
                                {{-- <p style="padding-right: 15px; padding-left: 15px;">-</p>
                                <input type="text" class="form-control timepicker" id="end_time" name="end_time" placeholder="hh:mm PM" value="{{$activity->end_time}}" /> --}}
                            </div>

                            {{-- <div class="col-md-3">
                                <input type="text" class="form-control" id="end_date" name="end_date" value="{{$activity->end_date}}" />
                            </div> --}}
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-12 form-field">
                        <label class="modal-form-lable"><i class="far fa-sticky-note"></i></label>&nbsp;
                        <textarea class="form-control" id="notes" name="notes" placeholder="Notes" rows="4">{{$activity->notes}}</textarea>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-12 form-field">
                        <label class="modal-form-lable"><i class="fas fa-user-circle"></i></label>&nbsp;
                        <div class="row" style="width: 100%;">
                            <div class="col-md-12">
                                <input type="hidden" name="assign_users" id="assign_users">
                                <input type="hidden" name="assign_groups" id="assign_groups">
                                <select class="form-control" id="assignees" name="assignees[]" style="width: 100%;" multiple>
                                    <option value="">Assign</option>
                                    @foreach ($users as $user)
                                        <option value="{{$user->id}}" data-user-id="{{$user->id}}" @if (auth()->user()->id == $user->id) selected @endif>{{$user->name}}</option>
                                    @endforeach
                                    @foreach ($userGroups as $userGroup)
                                        <option value="{{$userGroup->id}}" data-group-id="{{$userGroup->id}}">{{$userGroup->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-12 form-field">
                        <label class="modal-form-lable"><i class="fas fa-link"></i></label>&nbsp;
                        <div class="row" style="width: 100%;">
                            <div class="col-md-4 mb-2">
                                <select class="form-control" id="organization_id" name="organization_id">
                                    <option value="0">Organization</option>
                                    @foreach ($organizations as $organization)
                                        <option value="{{$organization->id}}" @if ($organization->id == $activity->organization_id) selected @endif>{{$organization->organization_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <select class="form-control" id="contact_id" name="contact_id">
                                    <option value="0">People</option>
                                    @foreach ($contacts as $contact)
                                        <option value="{{$contact->id}}" @if ($contact->id == $activity->contact_id) selected @endif>{{$contact->first_name}} {{$contact->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <select class="form-control" id="order_id" name="order_id">
                                    <option value="0"><i class=""></i> Orders</option>
                                    @foreach ($orders as $order)
                                        <option value="{{$order->id}}" @if ($order->id == $activity->order_id) selected @endif>{{$order->order_no}} - {{$order->order_description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer"></div>
        </div>

        <div class="col-lg-12 control-btns mb-5">
            <button type="submit" class="btn btn-success btn-custom">Save</button>
            <button type="button" class="btn btn-danger btn-custom delete" value="{{$activity->id}}">Delete</button>
            <a href="{{ route('activities') }}" class="btn btn-secondary btn-custom">Cancel</a>
        </div>
    </form>
</div>

<script>
    var assignees = <?php echo json_encode($assignees); ?>;
    $(document).ready(function(){
        $('select').select2();

        // USA Date Fomat
        $('#start_date').datepicker();
        $('#end_date').datepicker();

        $('.timepicker').mdtimepicker({
            theme:'purple',
        });

        setAssignees();

        $("#assignees option").prop('selected', false).trigger("change");
        for (let i = 0; i < assignees.length; i++) {
            $("#assignees option").filter(function() {
                return $(this).text() == assignees[i];
            }).prop('selected', true).trigger("change");
        }
    });

    //delete
    $("body").on("click", ".delete", function(){
        var activityId = $(this).val();
        window.location.replace("../../activities/delete/"+activityId);
    });

    // Filter by Order No
    $('#order_id').on('change', function(){
        var orderId = $(this).val();

        $.ajax({
            url:"{{ url('activities/filter_by_order') }}/"+orderId,
            method:'GET',
            dataType:'json',
            success: function (data, textStatus, jqXHR){
                var contacts = data.contacts;
                $('#contact_id').html('');
                if(contacts == null || contacts == '') {
                    $('#contact_id').append('<option value="0">People</option>');

                } else {
                    for (var i = 0; i < contacts.length; i++) {
                        $('#contact_id').append('<option value="'+contacts[i].id+'">'+contacts[i].first_name+' '+contacts[i].last_name+'</option>');
                    }
                }

                var organization = data.organization;
                $('#organization_id').html('');
                if(organization == null || organization == '') {
                    $('#organization_id').append('<option value="0">Organization</option>');

                } else {
                    for (var i = 0; i < organization.length; i++) {
                        $('#organization_id').append('<option value="'+organization[i].id+'">'+organization[i].organization_name+'</option>');
                    }
                }
            }
        });
    });

    // Filter by Contacts
    $('#contact_id').on('change', function(){
        var contactId = $(this).val();

        $.ajax({
            url:"{{ url('activities/filter_by_contact') }}/"+contactId,
            method:'GET',
            dataType:'json',
            success: function (data, textStatus, jqXHR){
                var orders = data.orders;
                $('#order_id').html('');
                if(orders == null || orders == '') {
                    $('#order_id').append('<option value="0"><i class=""></i> Orders</option>');

                } else {
                    for (var i = 0; i < orders.length; i++) {
                        $('#order_id').append('<option value="'+orders[i].id+'">'+orders[i].order_no+'</option>');
                    }
                }

                var organization = data.organization;
                $('#organization_id').html('');
                if(organization == null || organization == '') {
                    $('#organization_id').append('<option value="0">Organization</option>');

                } else {
                    for (var i = 0; i < organization.length; i++) {
                        $('#organization_id').append('<option value="'+organization[i].id+'">'+organization[i].organization_name+'</option>');
                    }
                }
            }
        });
    });

    // Filter by Organization
    $('#organization_id').on('change', function(){
        var organizationId = $(this).val();

        $.ajax({
            url:"{{ url('activities/filter_by_organization') }}/"+organizationId,
            method:'GET',
            dataType:'json',
            success: function (data, textStatus, jqXHR){
                var orders = data.orders;
                $('#order_id').html('');
                if(orders == null || orders == '') {
                    $('#order_id').append('<option value="0"><i class=""></i> Orders</option>');

                } else {
                    for (var i = 0; i < orders.length; i++) {
                        $('#order_id').append('<option value="'+orders[i].id+'">'+orders[i].order_no+'</option>');
                    }
                }

                var contacts = data.contacts;
                $('#contact_id').html('');
                if(contacts == null || contacts == '') {
                    $('#contact_id').append('<option value="0">People</option>');

                } else {
                    for (var i = 0; i < contacts.length; i++) {
                        $('#contact_id').append('<option value="'+contacts[i].id+'">'+contacts[i].first_name+' '+contacts[i].last_name+'</option>');
                    }
                }
            }
        });
    });

    $('body').on('change', '#assignees', function(){
        setAssignees();
    });

    function setAssignees(){
        var assignUserIds = [];
        var assignUserArr = $("#assignees option:selected");
        for (let i = 0; i < assignUserArr.length; i++) {
            var assignUser  = assignUserArr[i].getAttribute("data-user-id"); // set these into variables and then check
            if(assignUser != null){
                assignUserIds.push(assignUserArr[i].getAttribute("data-user-id"));
            }
        }
        var assignGroupIds = [];
        var assignGroupArr = $("#assignees option:selected");
        for (let i = 0; i < assignGroupArr.length; i++) {
            var assignGroup = assignGroupArr[i].getAttribute("data-group-id");
            if(assignGroup != null){
                assignGroupIds.push(assignGroupArr[i].getAttribute("data-group-id"));
            }
        }
        $('#assign_users').val(JSON.stringify(assignUserIds));
        $('#assign_groups').val(JSON.stringify(assignGroupIds));
    }
</script>

@endsection
