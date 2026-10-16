<style>
    .btn-circle {
        width: 35px;
        height: 35px;
        padding: 6px 0px;
        border-radius: 20px;
        text-align: center;
        font-size: 12px;
        line-height: 1.42857;
        background: transparent;
    }
    hr {
        margin-top: 0rem;
        margin-right: 11px;
        margin-bottom: 1rem;
        border: 0;
        border-top: 2px solid rgba(0, 0, 0, .1);
    }
    dl {
        list-style-type: none;
    }
    dl li{
        padding: 0.3rem 0.5rem;
        border-left: 3px solid #d1d0d0;
        border-radius: 7px;
        background-color: #f4f4f4;
        margin-top: 0.25rem;
        font-size: 12px;
    }
    dl li:before {
        content: '\f017';
        font-family: FontAwesome;
        display: inline-block;
    }
    dl span{
        color: #ada8a8;
    }
    .btn-activity {
        cursor: pointer;
    }
    .btn-activity:hover {
        transform: translateY(-1px);
        box-shadow: 0 7px 14px rgba(50, 50, 93, .1), 0 3px 6px rgba(0, 0, 0, .08);
    }
    .btn-activity:visited {
        color: #f4f4f4;
    }
    .btn-activity.active {
        background-color: lightgreen;
        border-color: yellow;
    }
</style>
<div class="modal fade" id="create_activity_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Schedule An Activity</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            {{-- @foreach ($orders as $order)
            <form> --}}
            <form action="{{ route('activities.create')}}" method="post">
                @csrf
                @if (request()->has('organization_id')) <input type="hidden" value="{{ request()->get('organization_id') }}" id="existing_organization" name="existing_organization" /> @endif
                <input type="hidden" id="existing_organization" name="existing_organization">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8" style="border-right: 2px solid #e7e7e7;">
                            <div class="row" style="margin-left: -7px;">
                                <div class="col-md-12">
                                    <div class="col-md-12 form-field">
                                        <label class="modal-form-lable"><i class="far fa-list-alt"></i></label>&nbsp;
                                        <input type="text" class="form-control" id="create_description" name="description" placeholder="Enter Activity Description" required />
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-12 form-field">
                                        <label class="modal-form-lable"><i class="far fa-clock"></i></label>&nbsp;
                                        <div class="row" style="width: 100%;">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="create_start_date" name="start_date" />
                                            </div>

                                            <div class="col-md-6" style="display: flex;">
                                                <input type="text" class="form-control timepicker" id="create_start_time" name="start_time" placeholder="hh:mm PM" />
                                                {{-- <p style="padding-right: 15px; padding-left: 15px;">-</p>
                                                <input type="text" class="form-control timepicker" id="end_time" name="end_time" placeholder="hh:mm PM" /> --}}
                                            </div>

                                            {{-- <div class="col-md-3">
                                                <input type="text" class="form-control" id="end_date" name="end_date" />
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-12 form-field">
                                        <label class="modal-form-lable"><i class="far fa-sticky-note"></i></label>&nbsp;
                                        <textarea class="form-control" id="create_notes" name="notes" placeholder="Notes" rows="4"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-12 form-field">
                                        <label class="modal-form-lable"><i class="fas fa-user-circle"></i></label>&nbsp;
                                        <div class="row" style="width: 100%;">
                                            <div class="col-md-12">
                                                <input type="hidden" name="assign_users" id="assign_users">
                                                <input type="hidden" name="assign_groups" id="assign_groups">
                                                <select class="form-control select2-activity-modal" id="assignees" name="assignees[]" style="width: 100%;" multiple>
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
                                            <div class="col-md-6 mb-2">
                                                <select class="form-control select2-activity-modal" id="activity_organization_id" name="organization_id" style="width: 100%;">
                                                    <option value="">Organization</option>
                                                    @foreach ($organizations as $organization)
                                                        <option value="{{$organization->id}}">{{$organization->organization_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <select class="form-control select2-activity-modal" id="contact_id" name="contact_id" style="width: 100%;">
                                                    <option value="">People</option>
                                                    @foreach ($contacts as $contact)
                                                        <option value="{{$contact->id}}">{{$contact->first_name}} {{$contact->last_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <select class="form-control select2-activity-modal" id="order_id" name="order_id" style="width: 100%;">
                                                    <option value=""><i class=""></i> Orders</option>
                                                    @foreach ($orders as $order)
                                                        <option value="{{$order->id}}">{{$order->order_no}} - {{$order->order_description}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 control-btns">
                                    <div class="custom-control custom-checkbox" style="display: contents;">
                                        <input type="checkbox" class="custom-control-input" id="is_done" name="is_done" title="Mark as Done">
                                        <label class="custom-control-label" for="is_done">Mark as Done </label>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-custom ml-3" id="save_btn">Save</button>
                                    <button type="reset" class="btn btn-primary btn-custom" id="reset_btn" style="display: none;">Reset</button>
                                    <button type="reset" class="btn btn-secondary btn-custom" id="cancel_btn">Cancel</button>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4" style="border-left: 2px solid #e7e7e7;">
                            <div class="row" style="margin-right: -7px;">
                                <div class="col-md-7" style="padding-top: 5px;">
                                    <span id="display_date"></span>
                                </div>
                                <div class="col-md-5 text-right">
                                    <button id="btnPrev" type="button" class="btn btn-circle"><i class="fa fa-chevron-left"></i></button>
                                    <button id="btnNext" type="button" class="btn btn-circle"><i class="fa fa-chevron-right"></i></button>
                                </div>
                            </div>
                            <hr>
                            <div class="row" style="margin-right: -7px; justify-content: center;">
                                <div class="col-md-10" style="max-height: 24.25rem; overflow: auto;">
                                    <dl id="activity_list">
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    {{-- <div class="col-lg-12 control-btns mb-5">
                        <div class="custom-control custom-checkbox" style="display: contents;">
                            <input type="checkbox" class="custom-control-input" id="is_done" name="is_done" title="Mark as Done">
                            <label class="custom-control-label" for="is_done">Mark as Done </label>
                        </div>
                        <button type="submit" class="btn btn-success btn-custom ml-3">Save</button>
                        <button type="reset" class="btn btn-secondary btn-custom" id="cancel_btn">Cancel</button>
                    </div> --}}
                </div>
            </form>
            {{-- </form>
            @endforeach --}}
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        // $('select').select2({
        //     dropdownParent: $('#create_activity_modal')
        // });
        // USA Date Fomat
        var today = ("0" + (new Date().getMonth() + 1)).slice(-2)+'/'+("0" + (new Date().getDate())).slice(-2)+'/'+new Date().getFullYear();

        $('#create_start_date').val(today);
        // $('#end_date').val(today);

        $('#create_start_date').datepicker();
        // $('#end_date').datepicker();

        $('.timepicker').mdtimepicker({
            theme:'purple',
        });

        getActivities(today);

        $('#cancel_btn').click(function(){
            $('.btn-activity').removeClass('active');
            resetFilter();
            // $('.select2-activity-modal').each( function(index){
            //     $(this).val('').trigger("change");
            // });

            $('#create_activity_modal').modal('hide');
        });

        // var existingOrgId = $('#existing_organization').val();
        // if($('#existing_organization').length) {
        //     $('#activity_organization_id').val(existingOrgId).trigger('change');
        // }
    });

    $('#create_activity_modal').on('shown.bs.modal', function (e) {
        setAssignees();
    });

    // Filter by Order No
    $('#order_id').on('change', function(){
        if($(this).val() != ''){
            var orderId = $(this).val();
        } else {
            var orderId = 'all';
        }

        $.ajax({
            url:"{{ url('activities/filter_by_order') }}/"+orderId,
            method:'GET',
            dataType:'json',
            success: function (data, textStatus, jqXHR){
                var contacts = data.contacts;
                $('#contact_id').html('');
                if(contacts == null || contacts == '') {
                    $('#contact_id').append('<option value="">People</option>');

                } else {
                    for (var i = 0; i < contacts.length; i++) {
                        $('#contact_id').append('<option value="'+contacts[i].id+'">'+contacts[i].first_name+' '+contacts[i].last_name+'</option>');
                    }
                }

                var organization = data.organization;
                $('#activity_organization_id').html('');
                if(organization == null || organization == '') {
                    $('#activity_organization_id').append('<option value="">Organization</option>');

                } else {
                    for (var i = 0; i < organization.length; i++) {
                        $('#activity_organization_id').append('<option value="'+organization[i].id+'">'+organization[i].organization_name+'</option>');
                    }
                }
            }
        });
    });

    // Filter by Contacts
    $('#contact_id').on('change', function(){
        if($(this).val() != ''){
            var contactId = $(this).val();
        } else {
            var contactId = 'all';
        }

        $.ajax({
            url:"{{ url('activities/filter_by_contact') }}/"+contactId,
            method:'GET',
            dataType:'json',
            success: function (data, textStatus, jqXHR){
                var orders = data.orders;
                $('#order_id').html('');
                if(orders == null || orders == '') {
                    $('#order_id').append('<option value=""><i class=""></i> Orders</option>');

                } else {
                    for (var i = 0; i < orders.length; i++) {
                        $('#order_id').append('<option value="'+orders[i].id+'">'+orders[i].order_no+' - '+orders[i].order_description+'</option>');
                    }
                }

                var organization = data.organization;
                $('#activity_organization_id').html('');
                if(organization == null || organization == '') {
                    $('#activity_organization_id').append('<option value="">Organization</option>');

                } else {
                    for (var i = 0; i < organization.length; i++) {
                        $('#activity_organization_id').append('<option value="'+organization[i].id+'">'+organization[i].organization_name+'</option>');
                    }
                }
            }
        });
    });

    // Filter by Organization
    $('#activity_organization_id').on('change', function(){
        if($(this).val() != ''){
            var organizationId = $(this).val();
        } else {
            var organizationId = 'all';
        }

        $.ajax({
            url:"{{ url('activities/filter_by_organization') }}/"+organizationId,
            method:'GET',
            dataType:'json',
            success: function (data, textStatus, jqXHR){
                var orders = data.orders;
                $('#order_id').html('');
                if(orders == null || orders == '') {
                    $('#order_id').append('<option value=""><i class=""></i> Orders</option>');

                } else {
                    for (var i = 0; i < orders.length; i++) {
                        $('#order_id').append('<option value="'+orders[i].id+'">'+orders[i].order_no+' - '+orders[i].order_description+'</option>');
                    }
                }

                var contacts = data.contacts;
                $('#contact_id').html('');
                if(contacts == null || contacts == '') {
                    $('#contact_id').append('<option value="">People</option>');

                } else {
                    for (var i = 0; i < contacts.length; i++) {
                        $('#contact_id').append('<option value="'+contacts[i].id+'">'+contacts[i].first_name+' '+contacts[i].last_name+'</option>');
                    }
                }
            }
        });
    });

    $('#btnNext').on('click', function() {
        getActivities($(this).val());
    });

    $('#btnPrev').on('click', function() {
        getActivities($(this).val());
    });

    $('#create_start_date').on('change', function() {
        getActivities($(this).val());
    });

    $('body').on('change', '#assignees', function(){
        setAssignees();
    });

    $('body').on('click', '.btn-activity', function() {
        $('.btn-activity').removeClass('active');
        $(this).addClass('active');
        var activityId = $(this).attr('data-value');
        resetFilter().done(function(){
            $.ajax({
                url: '{{ url("activities/get_activity_by_id") }}/'+activityId,
                type: "GET",
                dataType: 'json',
                success: function (data) {
                    var activity = data[0];
                    var assignees = data[1];

                    $("#assignees option").prop('selected', false).trigger("change");

                    $("#create_description").val(activity.description);
                    $("#create_start_date").val(activity.start_date);
                    $("#create_start_time").val(activity.start_time);
                    $("#create_notes").html(activity.notes);

                    for (let i = 0; i < assignees.length; i++) {
                        const element = assignees[i];
                        $("#assignees option").filter(function() {
                            return $(this).text() == assignees[i];
                        }).prop('selected', true).trigger("change");
                    }

                    $("#activity_organization_id").val(activity.organization_id).trigger("change");
                    $("#contact_id").val(activity.contact_id).trigger("change");
                    $("#order_id").val(activity.order_id).trigger("change");
                    if(activity.is_done == 1){
                        $("#is_done").prop('checked', true);
                    } else {
                        $("#is_done").prop('checked', false);
                    }

                    $('#save_btn').hide();
                    $('#reset_btn').show(200);
                }
            });
        });
    });

    $('body').on('click', '#reset_btn', function() {
        $('.btn-activity').removeClass('active');
        resetFilter();
        $('#reset_btn').hide();
        $('#save_btn').show(200);
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

    function getActivities(date){
        var searchDate = new Date(date);
        var fullMonth = searchDate.toLocaleString('en-US', {month: 'long'});
        var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
        var fullDay = weekday[searchDate.getDay()];
        var searchDay = searchDate.getDate();
        var suffix = 'th';
        if(searchDay == 1 || searchDay == 21 || searchDay == 31){
            suffix = 'st';
        } else if(searchDay == 2 || searchDay == 22){
            suffix = 'nd';
        } else if(searchDay == 3 || searchDay == 23){
            suffix = 'rd';
        }
        var displayDate = fullDay+', '+fullMonth+' '+searchDay+suffix;
        $('#display_date').html(displayDate);

        var nextDate = new Date(searchDate);
        var preDate = new Date(searchDate);

        nextDate.setDate(nextDate.getDate()+1);
        preDate.setDate(preDate.getDate()-1);

        var newNextDate = ("0" + (nextDate.getMonth() + 1)).slice(-2)+'/'+("0" +  (nextDate.getDate()) ).slice(-2) + '/' + nextDate.getFullYear();
        var newPreDate = ("0" + (preDate.getMonth() + 1)).slice(-2)+'/'+("0" +  (preDate.getDate()) ).slice(-2) + '/' + preDate.getFullYear();

        $('#btnNext').val(newNextDate);
        $('#btnPrev').val(newPreDate);

        $('#create_start_date').val(date);

        $.ajax({
            url:"{{ url('activities/get_by_date') }}",
            method:'POST',
            dataType:'json',
            data:{date:date, '_token':'{{csrf_token()}}'},
            success: function (data, textStatus, jqXHR){
                $('#activity_list').html('');
                if(data.length > 0){
                    $('#activity_list').removeClass('text-center');
                    for (var i = 0; i < data.length; i++) {
                        // $('#activity_list').append('<button type="button" class="btn-activity" value="'+data[i].id+'"> '+data[i].description+'</button>');
                        $('#activity_list').append('<li class="btn-activity" data-value="'+data[i].id+'"> '+data[i].description+'</li>');
                    }
                } else {
                    $('#activity_list').addClass('text-center');
                    $('#activity_list').append('<span>No Activites</span>');
                }
            }
        });
    }

    function resetFilter(){
        return $.ajax({
                    url:"{{ url('activities/filter_reset') }}",
                    method:'GET',
                    dataType:'json',
                    success: function (data, textStatus, jqXHR){
                        var orderArray = data[0];
                        var contactArray = data[1];
                        var organizationArray = data[2];

                        $('#activity_organization_id').html('');
                        if(organizationArray == null || organizationArray == '') {
                            $('#activity_organization_id').append('<option value="">Organization</option>');

                        } else {
                            $('#activity_organization_id').append('<option value="">Organization</option>');
                            for (var i = 0; i < organizationArray.length; i++) {
                                $('#activity_organization_id').append('<option value="'+organizationArray[i].id+'">'+organizationArray[i].organization_name+'</option>');
                            }
                        }

                        $('#contact_id').html('');
                        if(contactArray == null || contactArray == '') {
                            $('#contact_id').append('<option value="">People</option>');

                        } else {
                            $('#contact_id').append('<option value="">People</option>');
                            for (var i = 0; i < contactArray.length; i++) {
                                $('#contact_id').append('<option value="'+contactArray[i].id+'">'+contactArray[i].first_name+' '+contactArray[i].last_name+'</option>');
                            }
                        }

                        $('#order_id').html('');
                        if(orderArray == null || orderArray == '') {
                            $('#order_id').append('<option value=""><i class=""></i> Orders</option>');

                        } else {
                            $('#order_id').append('<option value=""><i class=""></i> Orders</option>');
                            for (var i = 0; i < orderArray.length; i++) {
                                $('#order_id').append('<option value="'+orderArray[i].id+'">'+orderArray[i].order_no+' - '+orderArray[i].order_description+'</option>');
                            }
                        }

                        $('#assignees').val('').trigger("change");
                    }
                });
    }
</script>
