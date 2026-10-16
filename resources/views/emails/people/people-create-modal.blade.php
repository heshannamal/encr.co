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
</style>
<div class="modal fade" id="email_people_create_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
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
                                        <option value="">Select a Lead Source</option>
                                        <option value="Cold Call">Cold Call</option>
                                        <option value="Existing Customer">Existing Customer</option>
                                        <option value="Self Generated">Self Generated</option>
                                        <option value="Employee">Employee</option>
                                        <option value="Partner">Partner</option>
                                        <option value="Public Relations">Public Relations</option>
                                        <option value="Direct Mail">Direct Mail</option>
                                        <option value="Conference">Conference</option>
                                        <option value="Trade Show">Trade Show</option>
                                        <option value="Web Site">Web Site</option>
                                        <option value="Word of Mouth">Word of Mouth</option>
                                        <option value="Other">Other</option>
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
                        <button type="submit" id="people_submit_btn" class="btn btn-success btn-custom">Save</button>
                        <button type="reset" id="people_cancel_btn" class="btn btn-secondary btn-custom">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>

        



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
    }
</script>
