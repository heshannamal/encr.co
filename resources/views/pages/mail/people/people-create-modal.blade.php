<style>
    .email_people_create_modal .select2 {
        height: 1.8rem;
        border-radius: 5px !important;
    }
    .email_people_create_modal .select2-selection.select2-selection--single {
        height: 1.6rem !important;
    }
    .email_people_create_modal .select2.select2-container {
        width: 75% !important;
    }
</style>
<div class="modal fade email_people_create_modal" id="email_people_create_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Add New Contact</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" id="email_people_add_form">
                    <input type="hidden" value="1" name="from_organization_people_add_function"/>
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
                                    <label class="form-lable">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control modal-form-input" id="people_last_name" name="last_name" required />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Lead Source</label>
                                    <select class="form-control modal-form-input select2-people-modal" id="people_lead_source" name="lead_source">
                                        <option value="">Select lead source</option>
                                        @foreach ($lead_sources as $lead_source)
                                            <option value="{{$lead_source->id}}">{{$lead_source->lead_source_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Phone No </label>
                                    <input type="text" class="form-control modal-form-input" id="people_phone_no" name="phone_no"/>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Email </label>
                                    <input type="email" class="form-control modal-form-input" id="people_email" name="email" readonly/>
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
                        <button type="button" id="people_submit_btn" class="btn btn-success btn-custom" onclick="submitForm()">Save</button>
                        <button type="button" id="people_cancel_btn" class="btn btn-secondary btn-custom" onclick="clearFields()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>

function submitForm() {
    $(".se-pre-con").fadeIn();
    $.ajax({
     url:'{{ url("people/create_contanct_without_org") }}',
     method:'POST',
     dataType:'json',
     data: $('#email_people_add_form').serialize(),
     success: function(data){

         var fnStatus = data[0];
         var fnResponse = data[1];
         if(fnStatus == 'success'){
             clearFields();

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
         $('#email_people_create_modal').modal('hide');
         $('.dot_for_create_people:first').trigger('click');
        }
    });
}





    function clearFields(){
        $("#people_first_name").val("");
        $("#people_last_name").val("");
        $("#people_lead_source").val("").trigger("change");
        $("#people_phone_no").val("");
        $("#people_email").val("");
        $("#people_title").val("");
        // $("#people_user_id").val("").trigger("change");

        $("#people_shipping_street").val("");
        $("#people_shipping_city").val("");
        $("#people_shipping_state").val("");
        $("#people_shipping_zip").val("");
        $("#people_shipping_country").val("");

        $('#people_create_modal').modal('hide');
    }
</script>
