{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
<style>
    #image_container {
        width: 100px;
        height: 100px;
        overflow: hidden;
        /* border-radius: 50%; */
    }
    #create_image_preview {
        height: 100px;
        width: 100px;
    }
    .oragnewstyle .modal-form-field .form-lable {
        width: 45%;
    }
    .form-lable, .card-header{
        color: black;
    }
    .oragnewstyle .modal-form-input{
        border-radius: 0rem;
    }
    .oragnewstyle .select2-selection__rendered{
        border-radius: 0rem;
    }
    .oragnewstyle .select2-container--default{
        border-radius: 0rem !important;
        border: 0.5px solid #eaeaea !important;
    }
    .oragnewstyle .multiple-color .select2-container--default{
        width: 90% !important;
    }
    .oragnewstyle .select2-container--default .select2-selection--multiple{
        background-color: transparent;
    }
    .swal2-styled {
        border: none !important;
        border-radius: 0rem !important;
        font-size: .8rem !important;
        padding: .2em 2em !important;
        color: white !important;
        cursor: pointer;
    }
    .oragnewstyle .select2-selection__rendered{
        border: none !important;
    }
</style>
<div class="modal fade oragnewstyle" id="organization_create_modal" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default" style="color: black">Add New Organization</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form  method="post" enctype="multipart/form-data" id="add_form">
                    @csrf
                    {{-- Organization Details --}}
                    <div class="card">
                        <div class="modal-card-header card-header">Organization Details</div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 modal-form-field">
                                    <label class="form-lable" style="width: 15.6%;">Org. Name <span class="text-danger">*</span></label>
                                    <select class="organization-select-text form-control" id="organization_name" name="organization_name" style="width: 88%;" required>
                                        <option value="">Enter Organization Name</option>
                                    </select>
                                    {{-- <input type="text" class="form-control" id="organization_name" name="organization_name" required> --}}
                                </div>

                                <div class="col-md-12 mb-3 modal-form-field">
                                    <label class="form-lable" style="width: 17.6%;">Contact Persons</label>
                                    <select class="form-control modal-form-input org-modal" id="customer_id" name="customer_id[]" style="width: 100%"  multiple="multiple">
                                        @foreach ($peoples as $people)
                                        <option value="{{$people->id}}">{{$people->first_name.' '.$people->last_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Website</label>
                                    <input type="text" class="form-control" id="website" name="website" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Sport</label>
                                    <select class="form-control modal-form-input org-modal" id="sport" name="sport" style="width: 100%">
                                        <option value="">Select a Sport</option>
                                        @foreach ($sports as $sport)
                                            <option value="{{$sport->sport_name}}">{{$sport->sport_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Sales Rep <span class="text-danger">*</span></label>
                                    <select class="form-control modal-form-input org-modal" id="user_id_org" name="user_id" style="width: 100%" required>
                                        @foreach ($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Lead Source  <span class="text-danger">*</span></label>
                                    <select class="form-control modal-form-input org-modal" id="lead_source_org" name="lead_source" style="width: 100%;" required>
                                        <option value="">Select lead source</option>
                                        @foreach ($lead_sources as $lead_source)
                                            <option value="{{$lead_source->id}}">{{$lead_source->lead_source_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Size Of Club</label>
                                    <input type="number" class="form-control" id="size_of_club" name="size_of_club" />
                                </div>


                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Sales Tax (%)</label>
                                    <input type="number" class="form-control" id="sales_tax" name="sales_tax" step="0.01" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable">Sales Tax Active</label>
                                    <select class="form-control modal-form-input org-modal" id="sales_tax_active" name="sales_tax_active" style="width: 100%">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <div class="col-md-12 modal-form-field multiple-color">
                                    <label class="form-lable" style="width: 15.6%;">Colors</label>
                                    <select class="form-control modal-form-input org-modal" id="colors" name="colors[]"  multiple="multiple">
                                        <option value="">Select a Color</option>
                                        @foreach($colorMasters as $colorMaster)
                                            <option value="{{ $colorMaster->id }}" data-hex="{{ $colorMaster->hex }}">{{ $colorMaster->pantone_code }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 modal-form-field ">
                                    <label class="form-lable" style="width: fit-content;">Customer with White Labeling</label>
                                    {{-- <input type="text" class="form-control form-input select2-organization-modal" id="colors" name="colors" /> --}}
                                    <input type="hidden" name="add_plcustomer" value="0">
                                    <input type="checkbox" class="add_plcustomer mx-4" id="add_plcustomer" name="add_plcustomer" value="1" >
                                </div>
                            </div>
                            {{-- <div class="row mt-3">
                                <div class="col-md-12 mb-3">
                                    <label class="form-lable">Organization Logo</label>
                                    <input type="file" style="height: calc(1.7rem + 2px);border-radius: 0rem;width:50%" class="form-control form-input" id="organization_logo" name="organization_logo" onchange="uploadCreateFile()" accept=".jpg,.jpeg,.png" style="width:75%; overflow: hidden;" />
                                </div>
                                <div class="col-md-6">
                                    <div id="image_container">
                                        <img src="{{ asset('argon') }}/img/icons/placeholder.png" id="create_image_preview" />
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
                                    <input type="text" class="form-control" id="shipping_street" name="shipping_street" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable"> City</label>
                                    <input type="text" class="form-control" id="shipping_city" name="shipping_city" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable"> State</label>
                                    <input type="text" class="form-control" id="shipping_state" name="shipping_state" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable"> Postal Code</label>
                                    <input type="text" class="form-control" id="shipping_postal_code" name="shipping_postal_code" />
                                </div>

                                <div class="col-md-6 modal-form-field">
                                    <label class="form-lable"> Country</label>
                                    {{-- <input type="text" class="form-control" id="shipping_country" name="shipping_country" /> --}}
                                    <select class="form-control modal-form-input shipping_country_select2 select2-organization-modal" style="width: 75%;" id="shipping_country" name="shipping_country">
                                        <option value="">Select a Country</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="organization_messageNo" id="organization_messageNo" value="">
                    <input type="hidden" name="organization_mail_sender" id="organization_mail_sender" value="">
                    <input type="hidden" name="organization_mail_subject" id="organization_mail_subject" value="">

                    <div class="col-lg-12 control-btns mb-5" style="background-color: white">
                        <button type="button" class="swal2-confirm" style="background-color: #47D6B6" id="add_organization">Save</button>
                        <button type="reset" class="swal2-confirm" id="cancel_btn" style="background-color: #b3b3b3">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="new_organiztion_add_Contacts" value="0">


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
    // $(document).ready(function() {

    //     $("#btn_new_organiztion_add_Contacts").click(function(){
    //         $("#new_organiztion_add_Contacts").val(1);
    //     });

    //     $('#cancel_btn').click(function(){
    //         $('.select2-organization-modal').each(
    //             function(index){
    //                 var input = $(this);
    //                 if(input.attr('id') == 'sales_tax_active'){
    //                     input.val(1).trigger("change");
    //                 } else {
    //                     input.val('').trigger("change");
    //                 }
    //             }
    //         );
    //         $('#organization_create_modal').modal('hide');
    //     });
    // });
    $(document).ready(function() {
        $('.org-modal').select2();
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

    function uploadCreateFile() {
        var image_preview = document.getElementById("create_image_preview");
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
    $('.modal-form-input').select2();
    // $('#organization_create_modal').on('shown.bs.modal', function (e) {
    //     $.ajax({
    //         url: '{{ url("organizations/get_people_list") }}',
    //         type: "GET",
    //         dataType: 'json',
    //         beforeSend: function () {
    //             $(".se-pre-con").fadeIn('slow');
    //         },
    //         success: function(data) {
    //             console.log(data);
    //             var people_options = '<option value="">Select a Contact Person</option>';
    //             for (let index = 0; index < data.length; index++) {
    //                 if (data[index].first_name) {
    //                     var first_name = data[index].first_name;
    //                 } else {
    //                     var first_name = '';
    //                 }

    //                 if (data[index].last_name) {
    //                     var last_name = data[index].last_name;
    //                 } else {
    //                     var last_name = '';
    //                 }
    //                 people_options += '<option value="'+data[index].id+'">'+first_name+' '+last_name+'</option>';
    //             }

    //             $('#customer_id').html(people_options);
    //         },
    //         complete: function() {
    //             $(".se-pre-con").fadeOut('slow');
    //         }
    //     });
    // });


    $(document).on('click', '#add_organization', function() {
        if($("#organization_name").val() == ''){
            Swal.fire(
                'Error!',
                'Please Enter Organization Name!',
                'warning'
                );
                return;
        }

        if($("#user_id_org").val() == ''){
            Swal.fire(
                'Error!',
                'Please Select Sales Rep!',
                'warning'
                    );
            return;
        }

        $.ajax({
            url: "{{url('email/linkNewOrganizationEmail')}}",
            type: "post",
            dataType: "json",
            data: $("#add_form").serialize(),
        beforeSend: function () {
            $(".se-pre-con").fadeIn('slow');
        },
        success: function (response) {
            console.log(response.data);
            if(response.status == "success") {
                Swal.fire(
                    'Done!',
                    'Organization Linked Successfully!',
                    'success'
                    )
            } else {
                Swal.fire(
                        'Error!',
                        'Something Went Wrong!',
                        'warning'
                        )
            }

                $('#organization_create_modal').modal('hide');
            },
        complete: function () {
            $(".se-pre-con").fadeOut('slow');
            $('#organization_create_modal').modal('hide');
            $('.dot_for_create_people:first').trigger('click');

        }
        });
    });
</script>

