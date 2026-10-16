{{-- <div class="col-md-12" id="activity_popup" style="display: none;">
    <div class="row pt-3 pb-3" style="border-bottom: 1px solid #d2d2d2;">
        <div class="col-md-4">
            <span style="font-weight: bold;"><span id="activity_form_title">Add/Edit</span> Activity</span>
        </div>

        <div class="col-md-8 text-right activity-controls">
            <button type="button" class="btn btn-sm btn-secondary activity-close" title="Close"><i class="fas fa-sign-in-alt"></i></button>
        </div>
    </div>

    <div class="row mt-3 activity-details-container">
        <form action="{{ route('activities.create') }}" method="POST" id="add_activity_form" style="width: 65%; padding-right: 1rem; border-right: 1px solid #eeeeee;">
            @csrf
            <input type="hidden" name="activity_id" id="activity_id" />

            <table style="width: 100%;">
                <tbody>
                    <tr>
                        <td class="icon-td"><i class="far fa-comment-alt"></i></td>
                        <td><input type="text" class="form-control" id="activity_subject" name="activity_subject" required /></td>
                    </tr>

                    <tr>
                        <td class="icon-td"><i class="far fa-calendar-alt"></i></td>
                        <td>
                            <div class="activity-date-group">
                                <input type="text" class="form-control mr-2 date-picker" id="start_date" name="start_date" data-theme="dark" />
                                <input type="text" class="form-control mr-2 timepicker" id="start_time" name="start_time" value="{{date('h:i A')}}" data-theme="dark"/>
                                <span class="mr-2"><i class="fas fa-minus"></i></span>
                                <input type="text" class="form-control mr-2 date-picker" id="due_date" name="due_date" data-theme="dark" />
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="icon-td" style="padding-top: 5px; vertical-align: top;"><i class="fas fa-file-signature"></i></td>
                        <td><textarea class="form-control" rows="5" id="activity_note" name="activity_note"></textarea></td>
                    </tr>

                    <tr>
                        <td class="icon-td"><i class="fas fa-user-tie"></i></td>
                        <td>
                            <select class="form-control select2-input" id="activity_user_id" name="activity_user_id">
                                @foreach ($users as $user)
                                    <option value="{{$user->id}}" @if ($user->id == auth()->user()->id) selected @endif>{{$user->name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="icon-td" rowspan="3" style="padding-top: 5px; vertical-align: top;"><i class="fas fa-link"></i></td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-append activity-input-group">
                                    <button type="button" class="btn btn-secondary btn-sm"><i class="fas fa-user-alt"></i></button>
                                </div>
                                <select class="form-control select2-input" id="activity_organization_id" name="activity_organization_id" required></select>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="input-group">
                                <div class="input-group-append activity-input-group">
                                    <button type="button" class="btn btn-secondary btn-sm"><i class="fas fa-city"></i></button>
                                </div>
                                <select class="form-control select2-input" id="activity_contact_id" name="activity_contact_id">
                                    <option value="">Select a Contact Person</option>
                                </select>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="input-group">
                                <div class="input-group-append activity-input-group">
                                    <button type="button" class="btn btn-secondary btn-sm"><i class="far fa-clipboard"></i></button>
                                </div>
                                <select class="form-control select2-input" id="activity_order_id" name="activity_order_id">
                                    <option value="">Select an Order</option>
                                </select>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td class="activity-form-footer mt-3 mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_done" name="is_done" />
                                <label class="custom-control-label" for="is_done">Mark as done&nbsp;</label>
                            </div>

                            <button type="reset" class="btn btn-sm btn-secondary btn-activity-form">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-success btn-activity-form"><span id="submit_btn_text">Save</span></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>

        <table style="width: 35%;">
            <tbody>
                <tr>
                    <td class="text-center" style="height: 20px; border-bottom: 1px solid #eeeeee;">
                        <button type="button" class="btn btn-sm btn-secondary" id="minus_day"><i class="fas fa-chevron-left"></i></button>
                        <span id="selected_day"></span>
                        <input type="hidden" id="selected_date" />
                        <button type="button" class="btn btn-sm btn-secondary" id="add_day"><i class="fas fa-chevron-right"></i></button>
                    </td>
                </tr>
                <tr>
                    <td id="activity_list"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    var activity_order_id = 0;
    var activity_contact_id = 0;

    $(document).ready( function () {
        $('.select2-input').select2();

        $('.timepicker').mdtimepicker();

        var today_day = moment().format('dddd, MMMM Do');
        var today_date = moment().format('L');
        $('#selected_day').html(today_day);
        $('#selected_date').val(today_date);

        $('#add_activity').on('click', function(){
            $.ajax({
                url:"{{ url('activities/get_organizations') }}",
                method:'GET',
                dataType:'json',
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data){
                    var organizations = data;

                    var start_date = moment().format('L');
                    var start_time = moment().format('LT');
                    var due_date = moment().format('L');

                    var today_day = moment().format('dddd, MMMM Do');
                    var today_date = moment().format('L');
                    $('#selected_day').html(today_day);
                    $('#selected_date').val(today_date);

                    var today_date = today_date.replace(/\//g, '-');
                    getActivitiesByDate(today_date);

                    $('#activity_subject').val('');
                    $('#activity_note').val('');
                    $('#start_date').val(start_date);
                    $('#start_time').val(start_time);
                    $('#due_date').val(due_date);
                    $('#is_done').prop('checked', false);

                    $('.activity-type-label').removeClass('active');
                    $('#activity_call').addClass('active');
                    $('.activity-type').prop('checked', false);
                    $('#activity_call .activity-type').prop('checked', true);

                    $('#submit_btn_text').html('Save');
                    $('#activity_form_title').html('Add');
                    $('#add_activity_form').attr('action', '{{ route("activities.create") }}');

                    var org_options = '<option value="">Select an Organization</option>';
                    for (let i = 0; i < organizations.length; i++) {
                        org_options += '<option value="'+organizations[i].id+'">'+organizations[i].organization_name+'</option>';
                    }
                    $('#activity_organization_id').html(org_options);

                },
                complete: function () {
                    $('#activity_popup').show(700);
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        });

        $('.activity-close').on('click', function(){
            $('#activity_popup').hide(700);
        });

        $('body').on('click', '#minus_day', function() {
            var selected_date = $('#selected_date').val();
            var new_day = moment(selected_date).subtract(1, "days").format('dddd, MMMM Do');
            var new_date = moment(selected_date).subtract(1, "days").format('L');
            var due_date = new_date.replace(/\//g, '-');

            getActivitiesByDate(due_date);

            $('#selected_day').html(new_day);
            $('#selected_date').val(new_date);
        });

        $('body').on('click', '#add_day', function() {
            var selected_date = $('#selected_date').val();
            var new_day = moment(selected_date).add(1, "days").format('dddd, MMMM Do');
            var new_date = moment(selected_date).add(1, "days").format('L');
            var due_date = new_date.replace(/\//g, '-');

            getActivitiesByDate(due_date);

            $('#selected_day').html(new_day);
            $('#selected_date').val(new_date);
        });

        $('body').on('click', '.activity-list-btn', function() {
            var activity_id = $(this).val();

            $.ajax({
                url:"{{ url('activities/get_activity_by_id') }}/"+activity_id,
                method:'GET',
                dataType:'json',
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data){
                    var start_date = moment(data.start_date).format('L');
                    var start_time = moment(data.start_date).format('LT');
                    var due_date = moment(data.due_date).format('L');

                    $('#activity_note').val('');
                    $('#activity_order_id').val('').trigger('change');
                    $('#activity_organization_id').val('').trigger('change');
                    $('#activity_contact_id').val('').trigger('change');

                    $('#activity_id').val(activity_id);
                    $('#activity_subject').val(data.activity_subject);
                    $('#activity_note').val(data.activity_note);
                    $('#start_date').val(start_date);
                    $('#start_time').val(start_time);
                    $('#due_date').val(due_date);
                    $('#activity_user_id').val(data.assigned_to).trigger('change');
                    $('#activity_organization_id').val(data.organization_id).trigger('change');
                    activity_order_id = data.order_id;
                    activity_contact_id = data.contact_id;
                },
                complete: function () {
                    $('#activity_popup').show(700);
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        });

        $('body').on('change', '#activity_organization_id', function() {
            var organization_id = $(this).val();

            if (organization_id) {
                $.ajax({
                    url:"{{ url('activities/get_orders_people_by_organiation') }}/"+organization_id,
                    method:'GET',
                    dataType:'json',
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (data){
                        console.log(data[1]);
                        var orders = data[0];
                        var people = data[1];

                        var order_options = '<option value="">Select an Order</option>';
                        for (let i = 0; i < orders.length; i++) {
                            order_options += '<option value="'+orders[i].id+'">'+orders[i].order_no+'</option>';
                        }
                        $('#activity_order_id').html(order_options);

                        var contact_options = '<option value="">Select a Contact Person</option>';
                        for (let i = 0; i < people.length; i++) {
                            var contacts = people[i].contacts[0];

                            if (contacts.last_name) {
                            var last_name = contacts.last_name;
                            } else {
                                var last_name = '';
                            }

                            contact_options += '<option value="'+contacts.id+'">'+contacts.first_name+' '+last_name+'</option>';
                        }
                        $('#activity_contact_id').html(contact_options);

                        if (activity_order_id == 0) {
                            $('#activity_order_id').val('').trigger('change');
                        } else {
                            console.log(activity_order_id);
                            $('#activity_order_id').val(activity_order_id).trigger('change');
                        }

                        console.log(activity_contact_id);
                        if (activity_contact_id == 0) {
                            $('#activity_contact_id').val('').trigger('change');
                        } else {
                            $('#activity_contact_id').val(activity_contact_id).trigger('change');
                        }
                    },
                    complete: function () {
                        activity_order_id = 0;
                        activity_contact_id = 0;
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            }

        });
    });

    function getActivitiesByDate(due_date) {
        var user_id = $('#loggedin_user_id').val();

        $.ajax({
            url: '{{ url("activities/get_activities_by_date") }}/'+user_id+'/'+due_date,
            type: "GET",
            dataType: 'json',
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (data) {
                var activity_list = [];
                for (let i = 0; i < data.length; i++) {
                    activity_list += '<button type="button" class="btn btn-sm activity-list-btn" value="'+data[i].id+'">'+data[i].activity_subject+'</button>';
                }

                $('#activity_list').html(activity_list);
            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    }
</script> --}}
