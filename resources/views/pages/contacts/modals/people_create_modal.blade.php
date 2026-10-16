<style>
    .select2 {
        height: 1.8rem;
        border-radius: 5px !important;
    }
    .select2-selection.select2-selection--single {
        height: 1.6rem !important;
    }
    #people_create_modal .select2.select2-container {
        width: 75% !important;
    }
.input-container {
        width: 75%;
        display: flex;
        flex-direction: column;
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
                <form enctype="multipart/form-data" id="people_add_form">
                    @csrf
                    {{-- Basic Information --}}
                    <div class="card">
                        <div class="modal-card-header card-header">Basic Information</div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control modal-form-input" id="people_first_name" name="first_name" required />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Org. Name <span class="text-danger">*</span></label>
                                    <select class="form-control modal-form-input select2-people-modal" id="people_organization_id" disabled="true" required>
                                        <option value="">Select an Organization</option>
                                        @foreach ($organizations as $organization)
                                        <option value="{{$organization->id}}">{{$organization->organization_name}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" id="people_organization_id_hide" name="organization_id"/>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control modal-form-input" id="people_last_name" name="last_name" required />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Lead Source</label>
                                    <select class="form-control modal-form-input select2-people-modal" id="people_lead_source" name="lead_source">
                                        <option value="">Select lead source</option>
                                        @if(isset($lead_sources))
                                            @foreach ($lead_sources as $lead_source)
                                                <option value="{{$lead_source->id}}">{{$lead_source->lead_source_name}}</option>
                                            @endforeach
                                        @endif
                                        
                                    </select>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Phone No </label>
                                    <input type="text" class="form-control modal-form-input" id="people_phone_no" name="phone_no"/>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Email <span class="text-danger">*</span></label>
                                    <!-- <input type="email" class="form-control modal-form-input people-email-class" id="people_email" name="email"/> -->
                                    <div class="input-container">

                                        <input type="email" class="form-control modal-form-input people-email-class" id="people_email" name="email" style="width:100%"/>

                                    </div>
                                </div>
                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Secondary Email </label>
                                    <input type="email" class="form-control modal-form-input" id="email_Secondary" name="email_Secondary"/>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Title </label>
                                    <input type="text" class="form-control modal-form-input" id="people_title" name="title"/>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Assigned To <span class="text-danger">*</span></label>
                                    <select class="form-control modal-form-input select2-people-modal" id="people_user_id" name="user_id" required>
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

                    {{-- Shipping Address --}}
                    <div class="card mt-2">
                        <div class="modal-card-header card-header">Postal Address</div>

                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Street</label>
                                    <input type="text" class="form-control modal-form-input" id="people_shipping_street" name="shipping_street" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">City</label>
                                    <input type="text" class="form-control modal-form-input" id="people_shipping_city" name="shipping_city" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">State</label>
                                    <input type="text" class="form-control modal-form-input" id="people_shipping_state" name="shipping_state" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Postal Code</label>
                                    <input type="text" class="form-control modal-form-input" id="people_shipping_zip" name="shipping_zip" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Country</label>
                                    <input type="text" class="form-control modal-form-input" id="people_shipping_country" name="shipping_country" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 control-btns mt-3 mb-5">
                        <button type="button" id="people_submit_btn" onclick = "people_add_Submit()" class="btn btn-success btn-custom">Save</button>
                        <button type="reset" id="people_cancel_btn" class="btn btn-secondary btn-custom">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('.select2-people-modal').select2({
            dropdownParent: $('#people_create_modal')
        });

        // $('#people_add_form').submit(function(ev){
            //     ev.preventDefault();
//     $(".se-pre-con").fadeIn();
        //     $.ajax({
        //         url:'{{ url("people/create_json") }}',
        //         method:'POST',
        //         dataType:'json',
        //         data: $('#people_add_form').serialize(),
        //         success: function(data){
        //             var fnStatus = data[0];
        //             var fnResponse = data[1];
        //             if(fnStatus == 'success'){

        //                 $('<option value="'+ fnResponse.id +'">'+ fnResponse.first_name +' '+ fnResponse.last_name +'</option>').appendTo($('#customer_id'));
        //                 $('#customer_id').val(fnResponse.id).trigger('change');

        //                 Swal.fire({
        //                     title: "Done!",
        //                     text: "Customer Created Successfully!",
        //                     type: "success",
        //                     timer: 1500,
        //                     showConfirmButton: false
        //                 });
        //             } else if(fnStatus == 'error'){
        //                 Swal.fire({
        //                     title: "Error!",
        //                     text: fnResponse,
        //                     type: "error",
        //                 });
        //             }

        //             $(".se-pre-con").fadeOut();
        //             $('#people_create_modal').modal('hide');
        //         }
        //     });
        // });

        $('#people_cancel_btn').click(function(){
            $('.select2-people-modal').each(
                function(index){
                    $(this).val('').trigger("change");
                }
            );
            $('#people_create_modal').modal('hide');
        });

    });

    function clear_people_create_modal(){
        $("#people_first_name").val("");
        $("#people_last_name").val("");
        $("#people_phone_no").val("");
        $("#people_email").val("");
        $("#people_title").val("");

        $("#people_shipping_street").val("");
        $("#people_shipping_city").val("");
        $("#people_shipping_state").val("");
        $("#people_shipping_zip").val("");
        $("#people_shipping_country").val("");
    }
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
            $(".se-pre-con").fadeIn();
            $.ajax({
                url:'{{ url("people/create_json") }}',
                method:'POST',
                dataType:'json',
                data: $('#people_add_form').serialize(),
                success: function(data){
                    var fnStatus = data[0];
                    var fnResponse = data[1];
                    if(fnStatus == 'success'){

                        $('<option value="'+ fnResponse.id +'">'+ fnResponse.first_name +' '+ fnResponse.last_name +'</option>').appendTo($('#customer_id'));
                        $('#customer_id').val(fnResponse.id).trigger('change');

                        Swal.fire({
                            title: "Done!",
                            text: "Customer Created Successfully!",
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else if(fnStatus == 'error'){
                        Swal.fire({
                            title: "Error!",
                            text: fnResponse,
                            type: "error",
                        });
                    }

                    $(".se-pre-con").fadeOut();
                    $('#people_create_modal').modal('hide');
                }
            });
            }
</script>
