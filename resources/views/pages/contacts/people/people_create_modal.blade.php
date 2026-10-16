<style>
    .select2 {
        height: 1.8rem;
        border-radius: 5px !important;
    }
    .select2-selection.select2-selection--single {
        height: 1.6rem !important;
    }
    #people_create_modal .modal-form-field .form-lable  {
        width: 100px;
    }

    #people_create_modal input, #people_create_modal .select2-container--default{
        border-radius: 0rem !important;
    }
    .button-set-dubmit {
        border: none !important;
        border-radius: 0rem !important;
        font-size: .8rem !important;
        padding: .2em 2em !important;
        color: white !important;
        cursor: pointer;
    }
.input-container {
        width: 75%;
        display: flex;
        flex-direction: column;
    }
    .swal2-popup .swal2-styled {
        margin: 0 .3125em;
        padding: .25em 1rem;
        font-weight: 500;
        box-shadow: none;
    }
</style>
<div class="modal fade" id="people_create_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Add New Contact</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('people.create') }}" method="post" enctype="multipart/form-data" id="add_form" class="peopleaddform">
                    @csrf
                    {{-- Basic Information --}}
                    <div class="card">
                        <div class="modal-card-header card-header">Basic Information</div>
                        @if (request()->has('organization_id')) <input type="hidden" value="{{ request()->get('organization_id') }}" name="existing_organization" /> @endif

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control modal-form-input" id="first_name" name="first_name" required />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control modal-form-input" id="last_name" name="last_name" required />
                                </div>

                                <div class="col-md-12 modal-form-field">
                                    <label class="form-lable">Org. Name <span class="text-danger">*</span></label>
                                    <select class="form-control form-input select2-people-modal" id="new_organization_id" name="new_organization_id[]" style="width: 83%;" multiple="multiple" required>
                                        <option value="">Select an Organization</option>
                                        {{-- @foreach ($organizations as $organization)
                                        <option value="{{$organization->id}}">{{$organization->organization_name}}</option>
                                        @endforeach --}}
                                    </select>
                                    <button type="button" class="btn btn-sm input-group-text" data-toggle="modal" data-target="#organization_create_modal">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Lead Source</label>
                                    <select class="form-control modal-form-input select2-people-modal" id="lead_source" name="lead_source" style="width: 75%;">
                                        <option value="">Select lead source</option>
                                        @if($lead_sources)
                                            @foreach ($lead_sources as $lead_source)
                                                <option value="{{$lead_source->id}}">{{$lead_source->lead_source_name}}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Work No </label>
                                    <input type="text" class="form-control modal-form-input" id="phone_no" name="phone_no"/>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Personal No </label>
                                    <input type="text" class="form-control modal-form-input" id="personal_phone_no" name="personal_phone_no"/>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Email  <span class="text-danger">*</span></label>
                                    <!-- <input type="email" class="form-control modal-form-input people-email-class" id="email" name="email" required/> -->
                                    <div class="input-container">
                                        <input type="email" class="form-control modal-form-input people-email-class" id="email" name="email" required style = "width:100%">

                                    </div>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Secondary Email </label>
                                    <input type="email" class="form-control modal-form-input" id="email_Secondary" name="email_Secondary"/>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Title </label>
                                    <input type="text" class="form-control modal-form-input" id="title" name="title"/>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Assigned To <span class="text-danger">*</span></label>
                                    <select class="form-control modal-form-input select2-people-modal" id="user_id" name="user_id" style="width: 75%;" required>
                                        <option value="">Select assigned to</option>
                                        <optgroup label="Users">
                                            @foreach ($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="Groups">
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="card-footer"></div> --}}
                    </div>

                    {{-- Primary Shipping Address --}}
                    <div class="card mt-2">
                        <div class="modal-card-header card-header">Primary Shipping Address</div>

                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Street</label>
                                    <input type="text" class="form-control modal-form-input" id="shipping_street" name="shipping_street" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">City</label>
                                    <input type="text" class="form-control modal-form-input" id="shipping_city" name="shipping_city" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">State</label>
                                    <input type="text" class="form-control modal-form-input" id="shipping_state" name="shipping_state" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Postal Code</label>
                                    <input type="text" class="form-control modal-form-input" id="shipping_zip" name="shipping_zip" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Country</label>
                                    <input type="text" class="form-control modal-form-input" id="shipping_country" name="shipping_country" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Secondary Shipping Address --}}
                    <div class="card mt-2">
                        <div class="modal-card-header card-header">Secondary Shipping Address</div>

                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Street</label>
                                    <input type="text" class="form-control modal-form-input" id="shipping_street_2" name="shipping_street_2" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">City</label>
                                    <input type="text" class="form-control modal-form-input" id="shipping_city_2" name="shipping_city_2" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">State</label>
                                    <input type="text" class="form-control modal-form-input" id="shipping_state_2" name="shipping_state_2" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Postal Code</label>
                                    <input type="text" class="form-control modal-form-input" id="shipping_zip_2" name="shipping_zip_2" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Country</label>
                                    <input type="text" class="form-control modal-form-input" id="shipping_country_2" name="shipping_country_2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 control-btns mt-3 mb-5" style="background-color: white">
                        <button type="button"  class="button-set-dubmit" style="background-color: #47D6B6" onclick="people_add_Submit()">Save</button>
                        <button type="reset" id="cancel_btn" class="button-set-dubmit" style="background-color: #b3b3b3">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        var allowClose = false;
        $('#people_create_modal').on('hide.bs.modal', function(e) {
            var hasValue = false;
            if (allowClose) {
                allowClose = false;
                return true;
            }
            $('#people_create_modal').find('input, select').each(function() {
                if ($(this).attr('name') !== '_token') {
                    if ($(this).is('select')) {
                        if ($(this).val() && $(this).val().length > 0) {
                            hasValue = true;
                            return false;
                        }
                    } else if ($(this).val() && $(this).val() !== '') {
                        hasValue = true;
                        return false;
                    }
                }
            })
            if (hasValue) {
                e.preventDefault();

                    Swal.fire({
                    title: 'Are you sure?',
                    text: "Your changes are not saved, do you want to close?",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'No, keep editing',
                    cancelButtonText: 'Yes, close it!'
                    }).then((result) => {
                    if (result.dismiss == 'cancel') {
                        allowClose = true;
                        $('#people_create_modal').modal('hide');
                    }
                });
            }
        });
        });
    $(document).ready(function() {
        // $('.select2-people-modal').select2({
        //     dropdownParent: $('#people_create_modal')
        // });

        $('#cancel_btn').click(function(){
            // $('#add_form input[type=text]').each(
            //     function(index){
            //         $(this).html('');
            //         // var input = $(this);
            //         // console.log('Type: ' + input.attr('type') + 'Name: ' + input.attr('name') + 'Value: ' + input.val());
            //     }
            // );

            $('.select2-people-modal').each(
                function(index){
                    $(this).val('').trigger("change");
                    // var input = $(this);
                    // if(input.attr('id') != 'user_id'){
                        // input.val('').trigger("change");
                        // input.val('');
                    // }
                }
            );
            $('#people_create_modal').modal('hide')
        });

        $('#people_create_modal').on('shown.bs.modal', function (e) {
            $.ajax({
                url: '{{ url("people/get_organization_list") }}',
                type: "GET",
                dataType: 'json',
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function(data) {
                    var org_options = '<option value="">Select an Organization</option>';
                    for (let index = 0; index < data.length; index++) {
                        org_options += '<option value="'+data[index].id+'">'+data[index].organization_name+'</option>';
                    }

                    $('#new_organization_id').html(org_options);
                },
                complete: function() {
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        })
    });
</script>


    <script>
        function people_add_Submit() {
            var emailInput = document.querySelector('.people-email-class');
            var email = emailInput.value;
            var errorMessageSpan = document.getElementById('email-error-message');
            if (errorMessageSpan) {
                errorMessageSpan.parentNode.removeChild(errorMessageSpan);
            }
            // Check if the email is not empty
            if (email.trim() === '') {
                showErrorMessage('Email is required.', emailInput);

            }else{
                // Check if the email already exists asynchronously
            $.ajax({
                url: '{{ url("people/checkemailexists") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: { email: email },
                dataType: 'json',
                success: function (response) {
                    var errorMessageSpan = document.getElementById('email-error-message');

                    if (response.exists) {
                        if (!errorMessageSpan) {
                            errorMessageSpan = document.createElement('span');
                            errorMessageSpan.id = 'email-error-message';
                            errorMessageSpan.className = 'text-danger';
                            errorMessageSpan.innerText = 'Email already exists. Please use a different email address.';
                            emailInput.parentNode.appendChild(errorMessageSpan);
                        }

                        // Prevent form submission when there's an error

                    } else {
                        // Remove the error message if it exists
                        removeErrorMessage(errorMessageSpan);
                        // Proceed with form submission
                        submitForm();
                    }
                },
                error: function () {
                    showErrorMessage('Error checking email existence. Please try again.', emailInput);
                    // Prevent form submission when there's an error

                }
            });

            // Prevent the default form submission
            return false;
            }


        }

        function removeErrorMessage(errorMessageSpan) {
            if (errorMessageSpan) {
                errorMessageSpan.parentNode.removeChild(errorMessageSpan);
            }
        }

        function showErrorMessage(message, targetElement) {
            var errorMessageSpan = document.createElement('span');
            errorMessageSpan.id = 'email-error-message';
            errorMessageSpan.className = 'text-danger';
            errorMessageSpan.innerText = message;

            // Append the error message span next to the target element
            targetElement.parentNode.appendChild(errorMessageSpan);
        }

        function submitForm() {
            document.getElementById('add_form').submit();
        }
    </script>






