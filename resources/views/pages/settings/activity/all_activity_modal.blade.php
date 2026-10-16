<div class="modal fade" id="all_activity_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="all_activity_modal_title">Search All Activities</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-6 form-field">
                        <label class="modal-form-lable"><i class="fas fa-user-circle"></i></label>&nbsp;
                        <div class="row" style="width: 100%;">
                            <div class="col-md-12">
                                <select class="form-control select2-all-activity-modal" id="search_user_id" name="search_user_id" style="width: 100%;">
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 float-right">
                        <button type="button" class="btn btn-success btn-custom ml-3" id="search_activities"><i class="fas fa-search"></i>Search</button>
                        <button type="reset" class="btn btn-secondary btn-custom" >Cancel</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table align-items-center table-responsive" id="all_activity_table">
                            <thead class="bg-theme">
                                <th scope="col">#</th>
                                <th scope="col">Done</th>
                                <th scope="col">Description</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">Start Time</th>
                                <th scope="col">End Time</th>
                                <th scope="col">Notes</th>
                                <th scope="col">Assign To
                                    {{-- <br>
                                    <select class="invoice-inputs" id="asign_to_filter">
                                        <option value="">View All</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->name}}">{{$user->name}}</option>
                                        @endforeach
                                    </select> --}}
                                </th>
                                <th scope="col">Order No</th>
                                <th scope="col">People</th>
                                <th scope="col">Organization
                                    {{-- <br>
                                    <select class="invoice-inputs" id="organization_filter">
                                        <option value="">View All</option>
                                        @foreach($organizations as $organization)
                                            <option value="{{$organization->organization_name}}">{{$organization->organization_name}}</option>
                                        @endforeach
                                    </select> --}}
                                </th>
                                <th scope="col" class="created-by">Created By</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        var allActivityTable = $('#all_activity_table').DataTable({
            "columnDefs": [ {
                "targets": 'no-sort',
                "orderable": false,
            } ]
        });

        $('#search_activities').click(function(){
            var userId = $('#search_user_id').val();

            if(userId != ''){
                $.ajax({
                    url:"{{ url('activities/get_by_user') }}/"+userId,
                    method:'GET',
                    dataType:'json',
                    success: function (data, textStatus, jqXHR){
                        allActivityTable.clear().draw();
                        for (var i = 0; i < data.length; i++) {
                            var $checked = "";
                            var $assignee_name = "";
                            var $order_no = "";
                            var $contact_name = "";
                            var $organization_name = "";
                            var $user_name = "";

                            if(data[i].is_done == 1){
                                $checked = "checked";
                            }
                            if(data[i].assignees != null && data[i].assignees.length > 0){
                                for (let j = 0; j < data[i].assignees.length; j++) {
                                    if(j != 0){$assignee_name += '<br>'}
                                    $assignee_name += data[i].assignees[j].user_detail.name;
                                }
                                // $assignee_name = data[i].assignee_details.name;
                            }
                            if(data[i].order_details != null){
                                $order_no = data[i].order_details.order_no;
                            }
                            if(data[i].contact_details != null){
                                $contact_name = data[i].contact_details.first_name+' '+data[i].contact_details.last_name;
                            }
                            if(data[i].organization_details != null){
                                $organization_name = data[i].organization_details.organization_name;
                            }
                            if(data[i].user_details != null){
                                $user_name = data[i].user_details.name;
                            }

                            var row = allActivityTable.row.add([
                                data[i].id,
                                '<div class="custom-control custom-checkbox activity-checkbox"><input type="checkbox" disabled class="custom-control-input" id="is_done_'+data[i].id+'" value="'+data[i].id+'" title="Done" '+ $checked +' /><label class="custom-control-label" for="is_done_'+data[i].id+'"></label></div>',
                                '<a href="#" class="activity_edit" data-value="'+data[i].id+'">'+data[i].description+'</a>',
                                data[i].start_date,
                                data[i].start_time,
                                data[i].end_time,
                                data[i].notes,
                                $assignee_name,
                                '<a href="#" class="order_edit" data-value="'+data[i].order_id+'">'+$order_no+'</a>',
                                '<a href="#" class="people_info" data-value="'+data[i].contact_id+'">'+$contact_name+'</a>',
                                '<a href="#" class="organization_info" data-value="'+data[i].organization_id+'">'+$organization_name+'</a>',
                                $user_name,
                            ]);
                            allActivityTable.row(row).draw();
                        }
                    }
                });
            }
        })

        $('#cancel_btn').click(function(){
            $.ajax({
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

                    $('#user_id').val('').trigger("change");
                }
            });
            // $('.select2-all-activity-modal').each( function(index){
            //     $(this).val('').trigger("change");
            // });

            $('#all_activity_modal').modal('hide');
        });

        // var existingOrgId = $('#existing_organization').val();
        // if($('#existing_organization').length) {
        //     console.log('this');
        //     $('#activity_organization_id').val(existingOrgId).trigger('change');
        // }
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

</script>
