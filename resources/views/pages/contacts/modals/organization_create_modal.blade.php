<style>
    #organization_create_modal .select2.select2-container {
        width: 75% !important;
    }
    #organization_image_container {
        width: 100px;
        height: 100px;
        overflow: hidden;
        border-radius: 50%;
    }
    #organization_image_preview {
        height: 100px;
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
    #organization_create_modal .select2-selection--single{
        border: 0.5px solid #eaeaea !important;
    }
    .color-selection-style .select2-selection--multiple{
        min-height: 32px;
        border-radius: 0rem;
        height: auto !important;
    }
    .color-selection-style .select2-container--default.select2-container--focus .select2-selection--multiple{
        height: auto !important;
    }
    .color-selection-style .select2-container--default.select2-container--focus .select2-selection--multiple{
        min-height: 32px;
        border-radius: 0rem;
        border: 0.5px solid #eaeaea !important;
    }
</style>
<div class="modal fade" id="organization_create_modal" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
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
                                    <select class="organization-select-text form-control modal-form-input" id="organization_organization_name" name="organization_name" required>
                                        <option value="">Enter Organization Name</option>
                                    </select>
                                    {{-- <input type="text" class="form-control modal-form-input" id="organization_organization_name" name="organization_name" required> --}}
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
                                    <label class="form-lable">Lead Source  <span class="text-danger">*</span></label>
                                    <select class="form-control modal-form-input select2-organization-modal" id="lead_source_org" name="lead_source" style="width: 75%;" required>
                                        <option value="">Select lead source</option>
                                         @if(isset($lead_sources))
                                            @foreach ($lead_sources as $lead_source)
                                                <option value="{{$lead_source->id}}">{{$lead_source->lead_source_name}}</option>
                                            @endforeach
                                         @endif
                                    </select>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Size Of Club</label>
                                    <input type="number" class="form-control modal-form-input" id="organization_size_of_club" name="size_of_club" />
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
                                <div class="col-md-6 modal-form-field color-selection-style">
                                    <label class="form-lable">Colors</label>
                                    {{-- <input type="text" class="form-control modal-form-input" id="organization_colors" name="colors" /> --}}
                                    <select name="colors[]" class="form-control form-input multy-selection select2-organization-modal" id="organization_colors" multiple="multiple">
                                        @foreach($colorMasters as $colorMaster)
                                            <option value="{{ $colorMaster->id }}" data-hex="{{ $colorMaster->hex }}">{{ $colorMaster->pantone_code }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 modal-form-field color-selection-style">
                                    <label class="form-lable" style="width: fit-content;">Customer with White Labeling</label>
                                    {{-- <input type="text" class="form-control form-input select2-organization-modal" id="colors" name="colors" /> --}}
                                    <input type="hidden" name="add_plcustomer" value="0">
                                    <input type="checkbox" class="add_plcustomer mx-4" id="add_plcustomer" name="add_plcustomer" value="1" >
                                </div>
                            </div>
                            {{-- <div class="row mt-3">
                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Organization Logo</label>
                                    <input type="file" class="form-control form-input" id="organization_organization_logo" name="organization_logo" onchange="uploadOrganizationFile()" accept=".jpg,.jpeg,.png" style="width:75%; overflow: hidden;" />
                                </div>
                                <div class="col-md-6">
                                    <div id="organization_image_container">
                                        <img src="{{ asset('argon') }}/img/icons/placeholder.png" id="organization_image_preview" />
                                    </div>
                                </div>
                            </div> --}}
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
                                    {{-- <input type="text" class="form-control modal-form-input" id="organization_shipping_country" name="shipping_country" /> --}}
                                    <select class="form-control modal-form-input shipping_country_select2 select2-organization-modal" style="width: 75%;" id="shipping_country" name="shipping_country">
                                        <option value="">Select a Country</option>
                                    </select>
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
    $(document).ready(function() {
        $('.organization-select-text').each(function() {
            initializeOrganizationSelect2(this);
        });
    });
    function initializeOrganizationSelect2(input) {
        $(input).select2({
            ajax: {
                url: "{{ url('/pipedrive/searchorganizations') }}",
                dataType: 'json',
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    var options = $.map(data, function(item) {
                        return {
                            id: item.id,
                            text: item.organization_name,
                            isNew: false
                        };
                    });

                    return { results: options };
                },
                cache: true
            },
            minimumInputLength: 2,
            tags: true,
            createTag: function(params) {
                return {
                    id: params.term,
                    text: params.term,
                    isNew: true
                };
            }
        }).on('select2:select', function (e) {
            var data = e.params.data;
            var selectedText = data.text;

            if (data.isNew) {
                var newOrganizationName = selectedText;
                $(this).val(newOrganizationName);

            } else {
                swal({
                    title: "Use another name",
                    text: "Existing Organization name selected",
                    icon: "info",
                    confirmButtonText: 'OK',
                }).then((exist) => {
                    $(this).val('').trigger('change');
                });
            }
        });
    }
    $(document).ready(function() {
        $('.select2-organization-modal').select2({
            dropdownParent: $('#organization_create_modal')
        });

        $('#organization_add_form').submit(function(ev){
            ev.preventDefault();
            $(".se-pre-con").fadeIn();
            console.log($('#organization_add_form').serialize());
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

                        if($('#from_order_create_page').length){

                            // $('<option value="'+ fnResponse.id +'">'+ fnResponse.organization_name +'</option>').appendTo($('#organization_id'));
                            $('<option>', { value: fnResponse.id,text: fnResponse.organization_name,'data-plstatus': fnResponse.pl_status}).appendTo($('#organization_id'));
                            $('#organization_id').val(fnResponse.id).trigger('change');

                            $('<option value="'+ fnResponse.id +'">'+ fnResponse.organization_name +'</option>').appendTo($('#people_organization_id'));
                            $('#people_organization_id').val(fnResponse.id).trigger('change');
                            $('#people_organization_id_hide').val(fnResponse.id);

                            $('<option value="'+ fnResponse.id +'">'+ fnResponse.organization_name +'</option>').appendTo($('#item_organization'));
                            $('#item_organization').val(fnResponse.id).trigger('change');


                        }else if($('#new_organization_id').length){

                            var exiOrg = [];
                            exiOrg = $('#new_organization_id').val();
                            exiOrg.push(fnResponse.id);
                            $('<option value="'+ fnResponse.id +'">'+ fnResponse.organization_name +'</option>').appendTo($('#new_organization_id'));
                            $('#new_organization_id').val(exiOrg).trigger('change');

                        }else{

                            $('<option value="'+ fnResponse.id +'">'+ fnResponse.organization_name +'</option>').appendTo($('#people_organization_id'));
                            $('#people_organization_id').val(fnResponse.id).trigger('change');

                        }

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

    function uploadOrganizationFile() {
        var image_preview = document.getElementById("organization_image_preview");
        var file = document.querySelector("input[type=file]").files[0];

        var reader = new FileReader();
        reader.onloadend = function () {
            image_preview.src = reader.result;
            document.getElementById("base64").value = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            image_preview.src = "";

        }
    }

    function clearFields(){
        $("#organization_organization_name").val("");
        $("#organization_website").val("");
        // $("#sport").val("").trigger("change");
        $("#organization_email").val("");
        $("#organization_size_of_club").val("");
        $("#organization_colors").val("");
        // $("#user_id_org").val("").trigger("change");
        $("#organization_sales_tax").val("");
        $("#organization_sales_tax_active").val("");

        $("#organization_shipping_street").val("");
        $("#organization_shipping_city").val("");
        $("#organization_shipping_state").val("");
        $("#organization_shipping_zip").val("");
        $("#organization_shipping_country").val("");
        $("#organization_shipping_postal_code").val("");
    }
</script>
