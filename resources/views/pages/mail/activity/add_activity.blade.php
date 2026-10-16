<style>
    .modal {
        backdrop-filter: brightness(0.3);

    }
    .activity_time_table td {
        /* text-wrap: wrap; */
        white-space: break-spaces;
    }
    .activity_time_table td {
        padding: 0.2rem !important;
    }
    .activity-list-btn{
        /* text-wrap: balance; */
        white-space: break-spaces;

    }
    .ql-container{
        max-width: 39rem !important;
    }

</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!-- Modal -->
<div class="modal fade activity_modal_new" id="activity_modal_new"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="new_activity_form_title">Add Activity</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-8">
                    <form action="{{ route('activities.create') }}" method="POST" id="add_activity_form" style="width: 100%; padding-right: 1rem; border-right: 1px solid #eeeeee;">
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
                                            <input type="text" class="form-control  date-picker" id="start_date" name="start_date" data-theme="dark" />
                                            <span class="mx-2"><i class="fas fa-minus"></i></span>
                                            <input type="text" class="form-control ms-2 timepicker" id="start_time" name="start_time" value="{{date('h:i A')}}" data-theme="dark"/>
                                            {{-- <input type="text" class="form-control  date-picker" id="due_date" name="due_date" data-theme="dark" /> --}}
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
                                        <select class="form-control select2 select2-input" id="activity_user_id" name="activity_user_id" style="width: 55%">
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
                                            <select class="form-control select2-input" id="activity_organization_id" name="activity_organization_id" required style="width: 50%"></select>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-append activity-input-group">
                                                <button type="button" class="btn btn-secondary btn-sm"><i class="fas fa-city"></i></button>
                                            </div>
                                            <select class="form-control select2-input" id="activity_contact_id" name="activity_contact_id" style="width: 50%">
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
                                            <select class="form-control select2-input" id="activity_order_id" name="activity_order_id" style="width: 50%">
                                                <option value="">Select an Order</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td class="activity-form-footer mt-3 mb-3">
                                        <div class="custom-control custom-checkbox" id="is_done_div" hidden>
                                            <input type="checkbox" class="custom-control-input" id="is_done" name="is_done" />
                                            <label class="custom-control-label" for="is_done">Mark as done&nbsp;</label>
                                        </div>

                                        <button type="button" class="btn btn-sm btn-secondary btn-activity-form " data-dismiss="modal" aria-label="Close">Cancel</button>
                                        <button type="submit" class="btn btn-sm btn-success btn-activity-form"><span id="submit_btn_text">Save</span></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>

                </div>
                <div class="col-4">
                    <table style="width: 100%;">
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
                                <td id="activity_list1">
                                    <div id="" style="overflow:scroll; height:400px;margin-right:15px">
                                        <table class="table table-bordered activity_time_table" >
                                            <tr>
                                                <td>01:00</td>
                                                <td id="activity_list_1" style="text-wrap: wrap;"></td>
                                              </tr>
                                              <tr>
                                                <td>02:00</td>
                                                <td id="activity_list_2"></td>
                                              </tr>
                                              <tr>
                                                <td>03:00</td>
                                                <td id="activity_list_3"></td>
                                              </tr>
                                              <tr>
                                                <td>04:00</td>
                                                <td id="activity_list_4"></td>
                                              </tr>
                                              <tr>
                                                <td>05:00</td>
                                                <td id="activity_list_5"></td>
                                              </tr>
                                              <tr>
                                                <td>06:00</td>
                                                <td id="activity_list_6"></td>
                                              </tr>
                                              <tr>
                                                <td>07:00</td>
                                                <td id="activity_list_7"></td>
                                              </tr>
                                              <tr>
                                                <td>08:00</td>
                                                <td id="activity_list_8"></td>
                                              </tr>
                                              <tr>
                                                <td>09:00</td>
                                                <td id="activity_list_9"></td>
                                              </tr>
                                              <tr>
                                                <td>10:00</td>
                                                <td id="activity_list_10"></td>
                                              </tr>
                                              <tr>
                                                <td>11:00</td>
                                                <td id="activity_list_11"></td>
                                              </tr>
                                              <tr>
                                                <td>12:00</td>
                                                <td id="activity_list_12"></td>
                                              </tr>
                                              <tr>
                                                <td>13:00</td>
                                                <td id="activity_list_13"></td>
                                              </tr>
                                              <tr>
                                                <td>14:00</td>
                                                <td id="activity_list_14"></td>
                                              </tr>
                                              <tr>
                                                <td>15:00</td>
                                                <td id="activity_list_15"></td>
                                              </tr>
                                              <tr>
                                                <td>16:00</td>
                                                <td id="activity_list_16"></td>
                                              </tr>
                                              <tr>
                                                <td>17:00</td>
                                                <td id="activity_list_17"></td>
                                              </tr>
                                              <tr>
                                                <td>18:00</td>
                                                <td id="activity_list_18"></td>
                                              </tr>
                                              <tr>
                                                <td>19:00</td>
                                                <td id="activity_list_19"></td>
                                              </tr>
                                              <tr>
                                                <td>20:00</td>
                                                <td id="activity_list_20"></td>
                                              </tr>
                                              <tr>
                                                <td>21:00</td>
                                                <td id="activity_list_21"></td>
                                              </tr>
                                              <tr>
                                                <td>22:00</td>
                                                <td id="activity_list_22"></td>
                                              </tr>
                                              <tr>
                                                <td>23:00</td>
                                                <td id="activity_list_23"></td>
                                              </tr>
                                              <tr>
                                                <td>00:00</td>
                                                <td id="activity_list_24"></td>
                                              </tr>

                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-danger  " data-dismiss="modal" >Close</button>
          <button type="button" class="btn btn-success">Save</button>
        </div> --}}
      </div>
    </div>
</div>


  {{-- script --}}

  <script>
    function getRandomColor() {
        // Generate random RGB values in the range of 150 to 255 (lighter colors)
        var r = Math.floor(Math.random() * 106) + 150; // Red
        var g = Math.floor(Math.random() * 106) + 150; // Green
        var b = Math.floor(Math.random() * 106) + 150; // Blue

        return 'rgb(' + r + ',' + g + ',' + b + ')';
    }
    $('#activity_modal_new').on('shown.bs.modal', function () {
        document.querySelectorAll('.random-button').forEach(function(button) {
            // Set a random background color for each button
            button.style.backgroundColor = getRandomColor();
        });
    });
    var activity_order_id = 0;
    var activity_contact_id = 0;
    $(document).on('select2:open', () => {
        document.querySelector('.select2-container--open .select2-search__field').focus();
    });
    $(document).ready( function () {
        $('.select2-input').select2();
        $('#activity_organization_id').select2();
        $('.timepicker').mdtimepicker();

        var today_day = moment().format('dddd, MMMM Do');
        var today_date = moment().format('L');
        $('#selected_day').html(today_day);
        $('#selected_date').val(today_date);

        $('#add_new_activity').on('click', function(){
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
                    $('#new_activity_form_title').html('Add Activity');
                    $('#is_done_div').prop('hidden', true);
                    $('#add_activity_form').attr('action', '{{ route("activities.create") }}');

                    var org_options = '<option value="">Select an Organization</option>';
                    for (let i = 0; i < organizations.length; i++) {
                        org_options += '<option value="'+organizations[i].id+'">'+organizations[i].organization_name+'</option>';
                    }
                    $('#activity_organization_id').html(org_options);

                },
                complete: function () {
                    $('#activity_modal_new').modal('show');
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
                    $('#add_activity_form').attr('action', '{{ route("activities.update") }}');
                    $('#submit_btn_text').html('Update');
                    $('#new_activity_form_title').html('Edit Activity');
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
        var activityListTDElements = document.querySelectorAll('[id^="activity_list_"]');

        // Loop through each selected <td> element and set its inner HTML to an empty string
        activityListTDElements.forEach(function(td) {
        td.innerHTML = '';
        });

        $.ajax({
            url: '{{ url("activities/get_activities_by_date") }}/'+user_id+'/'+due_date,
            type: "GET",
            dataType: 'json',
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (data) {
                var activity_list = [];
                console.log(data);
                for (let i = 0; i < data.length; i++) {
                    var startHour = parseInt(data[i].start_date.split(' ')[1].split(':')[0]);
                    console.log(startHour);
                    var activity_list = '<button type="button" class="btn btn-sm activity-list-btn mt-1" value="'+data[i].id+'">'+data[i].activity_subject+'</button>';
                    var timeSlotId = '#activity_list_' + startHour;
                    console.log(timeSlotId);
                    $(timeSlotId).append(activity_list);


                }

                // $('#activity_list').html(activity_list);
                // // Parse the start_date string to get the hour
                // var startHour = parseInt(start_date.split(' ')[1].split(':')[0]);

                // // Initialize an array to hold activities for each time slot
                // var timeSlotActivities = Array(24).fill('');

                // // Loop through the data to assign activities to the respective time slots
                // for (let i = 0; i < data.length; i++) {
                // var activity = data[i];
                // var activityHour = parseInt(activity.start_date.split(' ')[1].split(':')[0]);
                // // Calculate the index of the time slot in the table
                // var index = (activityHour - startHour + 24) % 24;
                // // Append the activity button to the corresponding time slot
                // timeSlotActivities[index] += '<button type="button" class="btn btn-sm activity-list-btn" value="' + activity.id + '">' + activity.activity_subject + '</button>';
                // }

                // // Loop through each time slot in the table and add the corresponding activities
                // for (let i = 0; i < 24; i++) {
                // var timeSlotId = '#activity_list_' + ((i + startHour) % 24 + 1);
                // $(timeSlotId).html(timeSlotActivities[i]);

            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    }
</script>

