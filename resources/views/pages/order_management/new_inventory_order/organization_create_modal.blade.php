<style>
    #organization_create_modal .select2.select2-container {
        width: 75% !important;
    }
</style>
<div class="modal fade" id="organization_create_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Add New Organization</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ url('organizations/create_json') }}" enctype="multipart/form-data" id="organization_add_form">
                    @csrf
                    {{-- Organization Details --}}
                    <div class="card">
                        <div class="modal-card-header card-header">Organization Details</div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Org. Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control modal-form-input" id="organization_organization_name" name="organization_name" required>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Website</label>
                                    <input type="text" class="form-control modal-form-input" id="organization_website" name="website" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Email</label>
                                    <input type="email" class="form-control modal-form-input" id="organization_email" name="email" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Sport</label>
                                    <select class="form-control modal-form-input select2-organization-modal" id="organization_sport" name="sport" style="width: 75%;">
                                        <option value="">Select a Sport</option>
                                        @foreach ($sports as $sport)
                                            <option value="{{$sport->sport_name}}">{{$sport->sport_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Sales Rep <span class="text-danger">*</span></label>
                                    <select class="form-control modal-form-input select2-organization-modal" id="organization_user_id_org" name="user_id" style="width: 75%;" required>
                                        @foreach ($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Size Of Club</label>
                                    <input type="number" class="form-control modal-form-input" id="organization_size_of_club" name="size_of_club" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Colors</label>
                                    <input type="text" class="form-control modal-form-input" id="organization_colors" name="colors" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Sales Tax (%)</label>
                                    <input type="number" class="form-control modal-form-input" id="organization_sales_tax" name="sales_tax" step="0.01" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Sales Tax Active</label>
                                    <select class="form-control modal-form-input select2-organization-modal" id="organization_sales_tax_active" name="sales_tax_active" style="width: 75%;">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Shipping Address --}}
                    <div class="card mb-2 mt-2">
                        <div class="modal-card-header card-header">Postal Address</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Street</label>
                                    <input type="text" class="form-control modal-form-input" id="organization_shipping_street" name="shipping_street" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable"> City</label>
                                    <input type="text" class="form-control modal-form-input" id="organization_shipping_city" name="shipping_city" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable"> State</label>
                                    <input type="text" class="form-control modal-form-input" id="organization_shipping_state" name="shipping_state" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable"> Postal Code</label>
                                    <input type="text" class="form-control modal-form-input" id="organization_shipping_postal_code" name="shipping_postal_code" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable"> Country</label>
                                    <input type="text" class="form-control modal-form-input" id="organization_shipping_country" name="shipping_country" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 control-btns mb-5">
                        <button type="submit" class="btn btn-success btn-custom">Save</button>
                        <button type="reset" class="btn btn-secondary btn-custom" id="organization_cancel_btn">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('.select2-organization-modal').select2({
            dropdownParent: $('#organization_create_modal')
        });

        $('#organization_add_form').submit(function(ev){
            ev.preventDefault();
            $(".se-pre-con").fadeIn();
            $.ajax({
                url:'{{ url("organizations/create_json") }}',
                method:'POST',
                dataType:'json',
                data: $('#organization_add_form').serialize(),
                success: function(data){
                    var fnStatus = data[0];
                    var fnResponse = data[1];
                    if(fnStatus == 'success'){

                        $('<option value="'+ fnResponse.id +'">'+ fnResponse.organization_name +'</option>').appendTo($('#organization_id'));
                        $('<option value="'+ fnResponse.id +'">'+ fnResponse.organization_name +'</option>').appendTo($('#people_organization_id'));
                        $('#organization_id').val(fnResponse.id).trigger('change');

                        Swal.fire({
                            title: "Done!",
                            text: "Organization Created Successfully!",
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
                    $('#organization_create_modal').modal('hide');
                }
            });
        });

        $('#organization_cancel_btn').click(function(){
            $('.select2-organization-modal').each(
                function(index){
                    var input = $(this);
                    if(input.attr('id') == 'sales_tax_active'){
                        input.val(1).trigger("change");
                    } else {
                        input.val('').trigger("change");
                    }
                }
            );
            $('#organization_create_modal').modal('hide');
        });

    });
</script>
