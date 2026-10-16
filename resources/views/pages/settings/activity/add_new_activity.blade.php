<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .modal {
        backdrop-filter: brightness(0.3);

    }
    .activity_time_table td {
        /* text-wrap: wrap; */
        white-space: break-spaces;
    }
    .activity_time_table td {
        padding: 0.2rem;
    }
    .activity-list-btn{
        /* text-wrap: balance; */
        white-space: break-spaces;

    }
    .visit-button{

        font-size: .7rem;
        background-color: #8be0ff;
        color: white;
        border: none;
        box-shadow: 2px 2px #e7e7e7;
        cursor: pointer;
        outline: unset;
        height: 77%;
    }
    .ql-container{
        max-width: 39rem !important;
    }
    .display-set{
        display: flex;
    }
    .class_for_repDashboard,
    .mobile_activity_organization_td,
    .mobile_contact_td,
    .mobile_order_td {
        display: flex !important;
        align-items: center;
        gap: 0.5rem;
    }
    .class_for_repDashboard .select2-container,
    .mobile_activity_organization_td .select2-container,
    .mobile_contact_td .select2-container,
    .mobile_order_td .select2-container {
        flex: 1 1 auto;
        width: auto !important;
        min-width: 0;
    }
    .class_for_repDashboard .col-md-2,
    .mobile_activity_organization_td .col-md-2,
    .mobile_contact_td .col-md-2,
    .mobile_order_td .col-md-2 {
        flex: 0 0 auto;
        width: auto !important;
        margin-left: 0;
    }
    .class_for_repDashboard .visit-button,
    .mobile_activity_organization_td .visit-button,
    .mobile_contact_td .visit-button,
    .mobile_order_td .visit-button {
        width: auto;
        height: 25px;
        white-space: nowrap;
    }

@media(max-width:768px){
    #activity_modal_new .activity-form-footer{
        position:fixed;
        left:0;
        right:0;
        bottom:0;
        z-index:99999;
        background:#fff;
        padding:15px;
        border-top:1px solid #ddd;
    }
    #activity_subject {
        margin-top: 0;
    }
    td:has(#activity_subject)::before {
        /* content: "Task"; */
        display:block;
        font-size:13px;
        font-weight:600;
        color:#9CA3AF;
        margin-bottom:6px;
    }
    .icon-td {
        display: none;
    }
    #add_activity_form {
        padding-left: 1rem;
    }
    .mobile_border_div{
        display:block !important;
        width:100%;
        padding:10px !important;
        border:1px solid rgba(227,227,227,.68);
        border-radius:8px !important;
        background:#fff;
        box-sizing:border-box;
        margin-top: 5px;
        margin-bottom: 5px;
    }
    .activity-date-group {
        display:flex !important;
        flex-wrap:wrap;
        gap:10px;
    }
    /* Start date full width */
    .activity-date-group .date-picker {
        width:100% !important;
        flex:0 0 100%;
    }
    /* Hide minus icon */
    .activity-date-group .mx-2 {
        display:none !important;
    }
    /* Time and priority same row */
    .activity-date-group .timepicker_new {
        width:calc(50% - 5px) !important;
        flex:0 0 calc(50% - 5px);
        margin-left:0 !important;
    }
    .activity-date-group #activity_priority {
        width:calc(50% - 5px) !important;
        flex:0 0 calc(50% - 5px);
        margin-left:0 !important;
    }
.mobile-contact-card{
    display:block !important;
    width:100%;
    padding:10px;
    border-left:1px solid rgba(227,227,227,.68);
    border-right:1px solid rgba(227,227,227,.68);
    background:#fff;
}
.mobile-contact-card:first-of-type{
    border-radius:8px 8px 0 0;
}
.mobile-contact-card:last-of-type{
    border-radius:0 0 8px 8px;
}
.select2 {
    width: 100% !important;
}
.mobile_assign_to td.class_for_repDashboard::before {
        content: "👤 Assign To";
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #9CA3AF;
        margin-bottom: 6px;
        padding-left: 8px;
    }
.mobile_organization td.mobile_activity_organization_td::before {
        content: "🏢 Organization";
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #9CA3AF;
        margin-bottom: 6px;
        padding-left: 8px;
        text-align: left;
    }
.mobile_contact td.mobile_contact_td::before {
        content: "👥 Contact Person";
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #9CA3AF;
        margin-bottom: 6px;
        padding-left: 8px;
        text-align: left;
    }
.mobile_order td.mobile_order_td::before {
        content: "📋 Order";
        display:block;
        font-size:13px;
        font-weight:600;
        color:#9CA3AF;
        margin-bottom:8px;
        padding-left:8px;
        text-align: left;
    }
    .class_for_repDashboard,
    .mobile_activity_organization_td,
    .mobile_contact_td,
    .mobile_order_td {
        display:flex !important;
        flex-wrap:wrap;
        align-items:center;
        gap:0.5rem;
        width:100% !important;
    }
    .class_for_repDashboard::before,
    .mobile_activity_organization_td::before,
    .mobile_contact_td::before,
    .mobile_order_td::before {
        flex:0 0 100%;
    }
    .class_for_repDashboard .select2-container,
    .mobile_activity_organization_td .select2-container,
    .mobile_contact_td .select2-container,
    .mobile_order_td .select2-container {
        flex:1 1 0;
        width:auto !important;
        min-width:0;
    }
    .class_for_repDashboard select,
    .mobile_activity_organization_td select,
    .mobile_contact_td select,
    .mobile_order_td select {
        width:75% !important;
    }
    .class_for_repDashboard .col-md-2,
    .mobile_activity_organization_td .col-md-2,
    .mobile_contact_td .col-md-2,
    .mobile_order_td .col-md-2 {
        flex:0 0 auto;
        width:auto !important;
        padding:0 !important;
        margin-left:0;
    }
    .class_for_repDashboard .visit-button,
    .mobile_activity_organization_td .visit-button,
    .mobile_contact_td .visit-button,
    .mobile_order_td .visit-button {
        width:auto;
        height: 25px;
        white-space:nowrap;
    }
    .mobile-contact-card.mobile_assign_to {
        margin-top: 15px;
        border-top: 1px solid rgba(227,227,227,.68);
        border-radius: 8px 8px 0px 0px;
    }
    .mobile-contact-card.mobile_order {
        margin-bottom: 15px;
        border-bottom: 1px solid rgba(227,227,227,.68);
        border-radius: 0px 0px 8px 8px;
    }
    #activity_list1 {
        padding: 1rem;
    }
    #activity_time_table_div {
        margin-right: unset;
    }
    .mobile_created_modify_table {
        width: 100% !important;
        border-top: 1px solid rgb(235, 235, 235);
        margin-left: unset !important;
        margin-bottom: 20px;
        padding: 15px;
        border: 1px solid rgb(235, 235, 235);
        border-radius: 8px;
        display: flex;
    }
    #created_at_tr td {
        padding-top:0 !important;
    }
}

</style>

<!-- Modal -->
<div class="modal fade" id="activity_modal_new"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <div class="col-md-8">
                    <form action="{{ route('activities.create') }}" method="POST" id="add_activity_form" style="width: 100%; padding-right: 1rem; border-right: 1px solid #eeeeee;">
                        @csrf
                        <input type="hidden" name="activity_id" id="activity_id" />
                        @if(session()->has('to_do_available_org'))
                            <input type="hidden" id="to_do_available_org" value="{{ session('to_do_available_org') }}" />
                        @endif


                        <table style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td class="icon-td"><i class="far fa-comment-alt"></i></td>
                                    <td class="mobile_border_div"><input type="text" class="form-control" placeholder="Task name" id="activity_subject" name="activity_subject" required /></td>
                                </tr>

                                <tr>
                                    <td class="icon-td"><i class="far fa-calendar-alt"></i></td>
                                    <td class="mobile_border_div">
                                        <div class="activity-date-group">
                                            <input type="text" class="form-control  date-picker" id="start_date" name="start_date" data-theme="dark" />
                                            <span class="mx-2"><i class="fas fa-minus"></i></span>
                                            <input type="text" class="form-control ms-2 timepicker_new" placeholder="Select Time Here" id="start_time" name="start_time" data-theme="dark"/>
                                            <select class="form-control ml-1" id="activity_priority" name="priority">
                                                <option value="0">Select Priority</option>
                                                <option value="1">&nbsp;Low</option>
                                                <option value="2">&nbsp;Medium</option>
                                                <option value="3">&nbsp;High</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="icon-td" style="padding-top: 5px; vertical-align: top;"><i class="fas fa-file-signature"></i></td>
                                    <td class="mobile_border_div">
                                        <div id="editor-container" style="min-height: 10rem;"></div>
                                        <input type="hidden" id="activity_note" name="activity_note">
                                    </td>
                                </tr>

                                <tr  class="mobile-contact-card mobile_assign_to">
                                    <td class="icon-td"><i class="fas fa-user-tie"></i></td>
                                    <td class="class_for_repDashboard">
                                        <select class="form-control select2-input" id="activity_user_id" name="activity_user_id" style="width: 55%">
                                            @foreach ($users as $user)
                                                <option value="{{$user->id}}" @if ($user->id == auth()->user()->id) selected @endif>{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr  class="mobile-contact-card mobile_organization">
                                    <td class="icon-td"><i class="fas fa-city"></i></td>
                                    <td class="mobile_activity_organization_td" class="display-set">

                                        <select class="form-control select2-input" id="activity_organization_id" name="activity_organization_id" required style="width: 55%"></select>
                                        <div class="col-md-2" style="padding:0px">
                                            <button class="visit-button" id="organization_Visit_btn" type="button" >VISIT <i class="fa fa-external-link" aria-hidden="true"></i></button>
                                            {{-- <a style="color: #909090" href="{{ route('organizations.info', ['id' => $order->organizationDetails['id']]) }}" target="_blank"><i class="fa fa-external-link mt-1" aria-hidden="true"></i></a> --}}
                                        </div>
                                    </td>
                                </tr>
                                <tr  class="mobile-contact-card mobile_contact">
                                    <td class="icon-td"><i class="fas fa-user"></i></td>
                                    <td class="mobile_contact_td" class="display-set">

                                        <select class="form-control select2-input" id="activity_contact_id" name="activity_contact_id" style="width: 55%">
                                            <option value="">Select a Contact Person</option>
                                        </select>
                                        <div class="col-md-2" style="padding:0px">
                                            <button class="visit-button" id="contact_Visit_btn" type="button" >VISIT <i class="fa fa-external-link" aria-hidden="true"></i></button>
                                            {{-- <a style="color: #909090" href="{{ route('organizations.info', ['id' => $order->organizationDetails['id']]) }}" target="_blank"><i class="fa fa-external-link mt-1" aria-hidden="true"></i></a> --}}
                                        </div>
                                    </td>
                                </tr>
                                <tr  class="mobile-contact-card mobile_order">
                                    <td class="icon-td"><i class="fas fa-clipboard"></i></td>
                                    <td class="mobile_order_td" class="display-set">

                                        <select class="form-control select2-input" id="activity_order_id" name="activity_order_id" style="width: 55%">
                                            <option value="">Select an Order</option>
                                        </select>
                                        <div class="col-md-2" style="padding:0px">
                                            <button class="visit-button" id="order_Visit_btn" type="button" >VISIT <i class="fa fa-external-link" aria-hidden="true"></i></button>
                                            {{-- <a style="color: #909090" href="{{ route('organizations.info', ['id' => $order->organizationDetails['id']]) }}" target="_blank"><i class="fa fa-external-link mt-1" aria-hidden="true"></i></a> --}}
                                        </div>
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                        <table class="ml-3 mobile_created_modify_table" style="width: 97%;border-top:1px solid #b3b3b3">
                            <tr id="created_at_tr">
                            </tr>
                            <tr id="modified_at_tr">
                            </tr>
                            <tr>
                                <td class="activity-form-footer mt-3 mb-3">
                                    <div class="custom-control custom-checkbox" id="is_done_div" hidden>
                                        <input type="checkbox" class="custom-control-input" id="is_done" name="is_done" />
                                        <label class="custom-control-label" for="is_done">Mark as done&nbsp;</label>
                                    </div>

                                    <button type="button" class="btn btn-sm btn-secondary btn-activity-form ml-2" data-dismiss="modal" aria-label="Close">Cancel</button>
                                    <button style="display: none" type="button" id="activity_delete_button" class="btn btn-sm btn-danger btn-activity-form"><span id="delete_btn_text">Delete</span></button>
                                    <button type="submit" class="btn btn-sm btn-success btn-activity-form"><span id="submit_btn_text">Save</span></button>
                                </td>
                            </tr>
                        </table>
                    </form>

                </div>
                <div class="col-md-4">
                    <table style="width: 100%;">
                        <tbody>
                            <tr>
                                <td class="text-center" style="height: 20px; border-bottom: 1px solid #eeeeee;">
                                    <button type="button" class="btn btn-sm btn-secondary" id="minus_day"><i class="fas fa-chevron-left"></i></button>
                                    <span><input type="text" id="selected_day" style="text-align: center;"></span>
                                    <input type="hidden" id="selected_date" />
                                    <button type="button" class="btn btn-sm btn-secondary" id="add_day"><i class="fas fa-chevron-right"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td id="activity_list1">
                                    <div id="activity_time_table_div" style="overflow:scroll; height:400px;margin-right:15px">
                                        <table class="table table-bordered activity_time_table" >
                                              <tr>
                                                <td colspan="2" id="activity_list_0"></td>
                                              </tr>
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
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width: 100%;">

                    </table>
                </div>
            </div>
        </div>
        <input type="hidden" id="open_from_calendar" name="open_from_calendar">
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-danger  " data-dismiss="modal" >Close</button>
          <button type="button" class="btn btn-success">Save</button>
        </div> --}}
      </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.3.6/jquery.timepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.3.6/jquery.timepicker.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    $(document).ready(function() {
        $('#activity_delete_button').click(function() {
            var activity_id = $(this.form).find('#activity_id').val();

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $('#mark_to_delete_activites').val(activity_id);
                    $('#mark_as_deleted').closest('form').submit();
                }
            });
        });
    });
    $(document).ready(function() {
        // Click event handler for the "VISIT" button
        $('#organization_Visit_btn').click(function() {
            // Get the selected organization ID
            var selectedOrganizationId = $('#activity_organization_id').val();

            // Check if an organization is selected
            if(selectedOrganizationId) {
                // If an organization is selected, construct the URL
                var url = "{{ route('organizations.info', ':id') }}";
                url = url.replace(':id', selectedOrganizationId);

                // Open the URL in a new tab/window
                window.open(url, '_blank');
            } else {
                // If no organization is selected, show an alert message
                alert('Please select an organization.');
            }
        });
        $(document).on('click', '#contact_Visit_btn', function() {
            // Get the selected contact ID from the select input
            var selectedContactId = $('#activity_contact_id').val();

            // Check if a contact ID is present
            if(selectedContactId) {
                // If a contact ID is present, construct the URL
                var url = "{{ route('people.info', ':id') }}";
                url = url.replace(':id', selectedContactId);

                // Open the URL in a new tab/window
                window.open(url, '_blank');
            } else {
                // If no contact ID is present, show an alert message
                alert('No contact selected.');
            }
        });
        $(document).on('click', '#order_Visit_btn', function() {
        // Get the selected order ID from the select input
        var selectedOrderId = $('#activity_order_id').val();

        // Check if an order ID is present
        if(selectedOrderId) {
            // Construct the URL for the order edit page using the route helper function
            var url = "{{ route('orders.info', [':id', 'order']) }}";
            url = url.replace(':id', selectedOrderId);

            // Append the query parameter to the URL
            url += '?active_tab=order';

            // Open the URL in a new tab
            window.open(url, '_blank');
        } else {
            // If no order ID is present, show an alert message
            alert('No order selected.');
        }
    });
    });



    $(document).ready(function () {
        var cleanButton = $('button.ql-clean');
        cleanButton.attr('title', 'Clear styles');
    });

    var quill = new Quill('#editor-container', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'], // Text styles
                [{ 'color': [] }], // Font color
                [{ 'list': 'ordered'}, { 'list': 'bullet' }], // Lists
                [{ 'size': ['small', false, 'large', 'huge'] }], // Font size
                [{ 'align': [] }], // Alignment options
                ['link'], // Add link option
                ['clean'] // Remove formatting
            ]
        }
    });


    quill.on('text-change', function() {
        var htmlContent = document.querySelector('.ql-editor').innerHTML; // Get the HTML content
        document.getElementById('activity_note').value = htmlContent; // Update the hidden input
    });

    // Clear formatting button functionality
    document.getElementById('clear-formatting').addEventListener('click', function() {
        quill.format('bold', false);
        quill.format('italic', false);
        quill.format('underline', false);
        quill.format('strike', false);
        quill.format('color', false);
        quill.format('size', false);
        quill.format('align', false);
    });
</script>


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
$('#activity_modal_new').on('hidden.bs.modal', function () {
    $('#activity_note').val('');
    quill.clipboard.dangerouslyPasteHTML('');
});



    var activity_order_id = 0;
    var activity_contact_id = 0;

    $(document).ready( function () {
        var successMessage = document.getElementById('success-message');
        if(successMessage && successMessage.innerText.indexOf('Activity Status Updated Successfully!') !== -1){
            console.log("Success message found");
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
                    // var due_date = moment().format('L');

                    var today_day = moment().format('dddd, MMMM Do');
                    var today_date = moment().format('L');
                    $('#selected_day').val(today_day);
                    $('#selected_date').val(today_date);

                    var today_date = today_date.replace(/\//g, '-');
                    getActivitiesByDate(today_date);

                    $('#activity_subject').val('');
                    $('#activity_note').val('');
                    $('#start_date').val(start_date);
                    // $('#start_time').val(start_time);
                    // $('#due_date').val(due_date);
                    $('#is_done').prop('checked', false);

                    $('#activity_priority').val(0).trigger('change');

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
                    var organization_id_modal = "{{ session('organization_id') }}";
                    var order_id_modal = "{{ session('order_id') }}";
                    var contact_id_modal = "{{ session('contact_id') }}";
                    if(organization_id_modal && order_id_modal && contact_id_modal){
                        $('#activity_organization_id').val(organization_id_modal).trigger('change');
                        $('#activity_contact_id').val(contact_id_modal).trigger('change');
                        $('#activity_order_id').val(order_id_modal).trigger('change');
                    }


                },
                complete: function () {

                    var to_do_available_org = $('#to_do_available_org').val();

                    $('#activity_organization_id').val(to_do_available_org).trigger('change');

                    $('#activity_modal_new').modal('show');
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        } else {
            console.log("Success message not found or doesn't match");
        }
        $('.select2-input').select2();
        $('#activity_organization_id').select2();
        $('.timepicker').mdtimepicker();
        $('.timepicker_new').timepicker();

        var today_day = moment().format('dddd, MMMM Do');
        var today_date = moment().format('L');
        $('#selected_day').val(today_day);
        $('#selected_date').val(today_date);

        $('#add_new_activity').on('click', function(){
            $('#activity_delete_button').hide();
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
                    // var due_date = moment().format('L');

                    var today_day = moment().format('dddd, MMMM Do');
                    var today_date = moment().format('L');
                    $('#selected_day').val(today_day);
                    $('#selected_date').val(today_date);

                    var today_date = today_date.replace(/\//g, '-');
                    getActivitiesByDate(today_date);

                    $('#activity_subject').val('');
                    $('.ql-editor').html('');
                    $('#activity_note').val('');
                    $('#start_date').val(start_date);
                    $('#activity_priority').val(0).trigger('change');
                    $('#start_time').val('');
                    // $('#start_time').val(start_time);
                    // $('#due_date').val(due_date);
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

                    $('#created_at_tr').html(``);
                    $('#modified_at_tr').html(``);

                },
                complete: function () {

                    $('#activity_modal_new').modal('show');
                    // var currentHour = new Date().getHours();
                    // var scrollPosition = (currentHour - 1) * 40;
                    // $('#activity_time_table_div').scrollTop(scrollPosition);

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
            var openFromCalendar = $('#open_from_calendar').val();

            if (openFromCalendar == 'Calendar') {
                getMeetingsByDate(due_date);
            } else {
                getActivitiesByDate(due_date);
            }

            $('#selected_day').val(new_day);
            $('#selected_date').val(new_date);
        });

        $('body').on('click', '#add_day', function() {
            var selected_date = $('#selected_date').val();
            var new_day = moment(selected_date).add(1, "days").format('dddd, MMMM Do');
            var new_date = moment(selected_date).add(1, "days").format('L');
            var due_date = new_date.replace(/\//g, '-');

            var openFromCalendar = $('#open_from_calendar').val();

            if (openFromCalendar == 'Calendar') {
                getMeetingsByDate(due_date);
            } else {
                getActivitiesByDate(due_date);
            }

            $('#selected_day').val(new_day);
            $('#selected_date').val(new_date);
        });

        $('#selected_day').datepicker({
            dateFormat: 'yy-mm-dd', // Date picker format
            showAnim: 'slideDown',
            changeMonth: true,
            changeYear: true,
            onSelect: function(dateText) {
                $(this).trigger('change');
            }
        });

        $('#selected_day').change(function() {
            var selected_date = $(this).val();
            console.log(selected_date);
            var moment_date = moment(selected_date, 'YYYY-MM-DD'); // Corrected format
            var due_date = moment_date.format('MM-DD-YYYY');
            console.log(due_date);

            // Assuming getActivitiesByDate function is defined elsewhere
            var openFromCalendar = $('#open_from_calendar').val();

            if (openFromCalendar == 'Calendar') {
                getMeetingsByDate(due_date);
            } else {
                getActivitiesByDate(due_date);
            }

            // Setting values to elements (if needed)
            $('#selected_day').val(due_date);
            $('#selected_date').val(due_date.format('L'));
        });


        $('body').on('click', '.activity-list-btn', function() {
            var activity_id = $(this).val();
            $('#activity_delete_button').show();

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
                    // var due_date = moment(data.due_date).format('L');

                    $('#activity_note').val('');
                    $('#activity_order_id').val('').trigger('change');
                    $('#activity_organization_id').val('').trigger('change');
                    $('#activity_contact_id').val('').trigger('change');

                    $('#activity_id').val(activity_id);
                    $('#activity_subject').val(data.activity_subject);
                    $('#activity_note').val(data.activity_note);
                    quill.clipboard.dangerouslyPasteHTML(data.activity_note);
                    $('#start_date').val(start_date);
                    console.log(start_time);
                    $('#start_time').val(start_time);
                    // $('#due_date').val(due_date);
                    $('#activity_user_id').val(data.assigned_to).trigger('change');
                    $('#activity_priority').val(data.priority).trigger('change');
                    $('#start_date').val(start_date);
                    if(moment(data.start_date).format('HH:mm:ss') !== '00:00:00'){
                        $('#start_time').val(start_time);
                    }else{
                        $('#start_time').val('');
                    }
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
                        var order_id_modal = "{{ session('order_id') }}";
                        var contact_id_modal = "{{ session('contact_id') }}";
                        if( order_id_modal && contact_id_modal){
                            console.log(order_id_modal, contact_id_modal);
                            $('#activity_contact_id').val(contact_id_modal).trigger('change');
                            $('#activity_order_id').val(order_id_modal).trigger('change');
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
                // console.log(data);
                for (let i = 0; i < data.length; i++) {
                    var startHour = parseInt(data[i].start_date.split(' ')[1].split(':')[0]);

                    var activity_list = '<button type="button" class="btn btn-sm activity-list-btn random-button mt-1" value="'+data[i].id+'">'+data[i].activity_subject+'</button>';
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
