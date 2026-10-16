@extends('layouts.app', ['activePage' => 'activities', 'titlePage' => __('Creating Activity')])

@section('content')
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('activities.create')}}" method="post">
                @csrf
                @if (request()->has('organization_id')) <input type="hidden" value="{{ request()->get('organization_id') }}" id="existing_organization" name="existing_organization" /> @endif

                <div class="card mb-2">
                    <div class="card-header">Schedule An Activity</div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="col-md-12 form-field">
                                <label class="modal-form-lable"><i class="far fa-list-alt"></i></label>&nbsp;
                                <input type="text" class="form-control" id="description" name="description" placeholder="Enter Activity Description" required />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-12 form-field">
                                <label class="modal-form-lable"><i class="far fa-clock"></i></label>&nbsp;
                                <div class="row" style="width: 100%;">
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" id="start_date" name="start_date" />
                                    </div>

                                    <div class="col-md-6" style="display: flex;">
                                        <input type="text" class="form-control timepicker" id="start_time" name="start_time" placeholder="hh:mm PM" />
                                        <p style="padding-right: 15px; padding-left: 15px;">-</p>
                                        <input type="text" class="form-control timepicker" id="end_time" name="end_time" placeholder="hh:mm PM" />
                                    </div>

                                    <div class="col-md-3">
                                        <input type="text" class="form-control" id="end_date" name="end_date" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-12 form-field">
                                <label class="modal-form-lable"><i class="far fa-sticky-note"></i></label>&nbsp;
                                <textarea class="form-control" id="notes" name="notes" placeholder="Notes" rows="4"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-12 form-field">
                                <label class="modal-form-lable"><i class="fas fa-user-circle"></i></label>&nbsp;
                                <div class="row" style="width: 100%;">
                                    <div class="col-md-6">
                                        <select class="form-control" id="user_id" name="user_id">
                                            <option value="">Assign</option>
                                            @foreach ($users as $user)
                                                <option value="{{$user->id}}" @if (auth()->user()->id == $user->id) selected @endif>{{$user->name}}</option>
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
                                        <select class="form-control" id="organization_id" name="organization_id">
                                            <option value="">Organization</option>
                                            @foreach ($organizations as $organization)
                                                <option value="{{$organization->id}}">{{$organization->organization_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <select class="form-control" id="contact_id" name="contact_id">
                                            <option value="">People</option>
                                            @foreach ($contacts as $contact)
                                                <option value="{{$contact->id}}">{{$contact->first_name}} {{$contact->last_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <select class="form-control" id="order_id" name="order_id">
                                            <option value=""><i class=""></i> Orders</option>
                                            @foreach ($orders as $order)
                                                <option value="{{$order->id}}">{{$order->order_no}} - {{$order->order_description}}</option>
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
                    <div class="custom-control custom-checkbox" style="display: contents;">
                        <input type="checkbox" class="custom-control-input" id="is_done" name="is_done" title="Mark as Done">
                        <label class="custom-control-label" for="is_done">Mark as Done </label>
                    </div>
                    <button type="submit" class="btn btn-success btn-custom ml-3">Save</button>
                    <button type="reset" class="btn btn-secondary btn-custom">Cancel</button>
                </div>
            </form>
        </div>

        {{-- <div class="col-md-6">
            <div class="card mb-2">
                <div class="card-body">
                    @include('pages.settings.activity.task')
                </div>
                <div class="card-footer"></div>
            </div>
        </div> --}}
    </div>
</div>

<script>
    $(document).ready(function(){
        $('select').select2();

        // USA Date Fomat
        var today = (new Date().getMonth()+1)+'/'+new Date().getDate()+'/'+new Date().getFullYear();
        $('#start_date').val(today);
        $('#end_date').val(today);

        $('#start_date').datepicker();
        $('#end_date').datepicker();

        $('.timepicker').mdtimepicker({
            theme:'purple',
        });

        var existingOrgId = $('#existing_organization').val();
        if($('#existing_organization').length) {
            $('#organization_id').val(existingOrgId).trigger('change');
        }
    });

    // Filter by Order No
    $('#order_id').on('change', function(){
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
                $('#organization_id').html('');
                if(organization == null || organization == '') {
                    $('#organization_id').append('<option value="">Organization</option>');

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
                    $('#order_id').append('<option value=""><i class=""></i> Orders</option>');

                } else {
                    for (var i = 0; i < orders.length; i++) {
                        $('#order_id').append('<option value="'+orders[i].id+'">'+orders[i].order_no+' - '+orders[i].order_description+'</option>');
                    }
                }

                var organization = data.organization;
                $('#organization_id').html('');
                if(organization == null || organization == '') {
                    $('#organization_id').append('<option value="">Organization</option>');

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

@endsection
