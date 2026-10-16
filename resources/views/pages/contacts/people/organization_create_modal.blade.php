<style>
    #create_image_preview {
        height: 100px;
        width: 100px;
    }
    #organization_create_modal .modal-form-field .form-lable {
        width: 100px;
    }
    .form-lable, .card-header{
        color: black;
    }
    #organization_create_modal .modal-form-input{
        border-radius: 0rem;
    }
    #organization_create_modal .select2-selection__rendered{
        border-radius: 0rem;
    }
    #organization_create_modal .select2-container--default{
        border-radius: 0rem !important;
        border: 0.5px solid #eaeaea !important;
        width: 75% !important;
    }
    #organization_create_modal .multiple-color .select2-container--default{
        width: 90% !important;
    }
    #organization_create_modal .select2-container--default .select2-selection--multiple{
        background-color: transparent;
    }
    .swal2-confirm {
        border: none !important;
        border-radius: 0rem !important;
        font-size: .8rem !important;
        padding: .2em 2em !important;
        color: white !important;
        cursor: pointer;
    }
</style>
<div class="modal fade" id="organization_create_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default" style="color: black">Add New Organization</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- <form action="{{ url('organizations/create') }}" method="post" enctype="multipart/form-data" id="organization_add_form"> --}}
                    <form action="{{ url('organizations/create') }}" enctype="multipart/form-data" id="organization_add_form">
                    @csrf
                    {{-- Organization Details --}}
                    <div class="card">
                        <div class="modal-card-header card-header">Organization Details</div>
                        <input type="hidden" value="{{$peoples->id}}" name="existing_people" />

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Org. Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control modal-form-input" id="organization_name" name="organization_name" required>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Website</label>
                                    <input type="text" class="form-control modal-form-input" id="website" name="website" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Email</label>
                                    <input type="email" class="form-control modal-form-input" id="email" name="email" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Sport</label>
                                    <select class="form-control modal-form-input select2-organization-modal" id="sport" name="sport" style="width: 75%;">
                                        <option value="">Select a Sport</option>
                                        @foreach ($sports as $sport)
                                            <option value="{{$sport->sport_name}}">{{$sport->sport_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Sales Rep <span class="text-danger">*</span></label>
                                    <select class="form-control modal-form-input select2-organization-modal" id="user_id_org" name="user_id" style="width: 75%;" required>
                                        @foreach ($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Lead Source  <span class="text-danger">*</span></label>
                                    <select class="form-control modal-form-input select2-organization-modal" id="lead_source_org" name="lead_source" style="width: 75%;" required>
                                        <option value="">Select lead source</option>
                                        @foreach ($lead_sources as $lead_source)
                                            <option value="{{$lead_source->id}}">{{$lead_source->lead_source_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Size Of Club</label>
                                    <input type="number" class="form-control modal-form-input" id="size_of_club" name="size_of_club" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Sales Tax (%)</label>
                                    <input type="number" class="form-control modal-form-input" id="sales_tax" name="sales_tax" step="0.01" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Sales Tax Active</label>
                                    <select class="form-control modal-form-input select2-organization-modal" id="sales_tax_active" name="sales_tax_active" style="width: 75%;">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <div class="col-md-12 modal-form-field multiple-color">
                                    <label class="form-lable">Colors</label>
                                    {{-- <input type="text" class="form-control modal-form-input" id="colors" name="colors" /> --}}
                                    <select class="form-control form-input select2-people" id="colors" name="colors[]"  multiple="multiple">
                                        <option value="">Select a People</option>
                                        @foreach($colorMasters as $colorMaster)
                                            <option value="{{ $colorMaster->id }}" data-hex="{{ $colorMaster->hex }}">{{ $colorMaster->pantone_code }}</option>
                                        @endforeach
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
                                    <input type="text" class="form-control modal-form-input" id="shipping_street" name="shipping_street" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable"> City</label>
                                    <input type="text" class="form-control modal-form-input" id="shipping_city" name="shipping_city" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable"> State</label>
                                    <input type="text" class="form-control modal-form-input" id="shipping_state" name="shipping_state" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable"> Postal Code</label>
                                    <input type="text" class="form-control modal-form-input" id="shipping_postal_code" name="shipping_postal_code" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable"> Country</label>
                                    {{-- <input type="text" class="form-control modal-form-input" id="shipping_country" name="shipping_country" /> --}}
                                    <select class="form-control modal-form-input shipping_country_select2 select2-organization-modal" style="width: 75%;" id="shipping_country" name="shipping_country">
                                        <option value="">Select a Country</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 control-btns mb-5" style="background-color: white">
                        <button type="submit" class="swal2-confirm" style="background-color: #47D6B6">Save</button>
                        <button type="reset" class="swal2-confirm" id="cancel_btn" style="background-color: #b3b3b3">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        $('#organization_add_form').submit(function(ev){
            ev.preventDefault();
            $(".se-pre-con").fadeIn();
            $.ajax({
                url:'{{ url("organizations/create_json") }}',
                method:'POST',
                dataType:'json',
                data: $('#organization_add_form').serialize(),
                success: function(data){
                    console.log(data);
                    var fnStatus = data[0];
                    var fnResponse = data[1];
                    if(fnStatus == 'success'){

                        if($("#from_people_create_organizations").val() == 1){
                            var exiOrg = [];
                            exiOrg = $('#organization_id_info').val();
                            exiOrg.push(fnResponse.id);
                            $('<option value="'+ fnResponse.id +'">'+ fnResponse.organization_name +'</option>').appendTo($('#organization_id_info'));
                            $('#organization_id_info').val(exiOrg).trigger('change');
                        }else if($("#new_organization_id").length){
                            var exiOrg = [];
                            exiOrg = $('#new_organization_id').val();
                            exiOrg.push(fnResponse.id);
                            $('<option value="'+ fnResponse.id +'">'+ fnResponse.organization_name +'</option>').appendTo($('#new_organization_id'));
                            $('#new_organization_id').val(exiOrg).trigger('change');
                        }

                        $("#from_people_create_organizations").val(0);
                        clearFields();

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

        $('#cancel_btn').click(function(){

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

    function clearFields(){
        $("#organization_name").val("");
        $("#website").val("");
        // $("#sport").val("").trigger("change");
        $("#email").val("");
        $("#size_of_club").val("");
        $("#colors").val("");
        // $("#user_id_org").val("").trigger("change");
        $("#sales_tax").val("");
        $("#sales_tax_active").val("");

        $("#shipping_street").val("");
        $("#shipping_city").val("");
        $("#shipping_state").val("");
        $("#shipping_zip").val("");
        $("#shipping_country").val("");
    }
    $(document).ready(function() {
        // Initialize Select2
        $('.shipping_country_select2').select2({
            placeholder: 'Select a Country',
            allowClear: true,
            width: '100%'
        });

        // Fetch country data
        $.ajax({
            url: 'https://countriesnow.space/api/v0.1/countries',
            method: 'GET',
            success: function(data) {
                const countries = data.data.map(country => ({
                    id: country.country,
                    text: country.country
                }));
                $('.shipping_country_select2').select2({
                    data: countries,
                    placeholder: 'Select a Country',
                    allowClear: true,
                    width: '100%'
                });
            },
            error: function(error) {
                console.error('Error fetching countries:', error);
            }
        });

    });
</script>
