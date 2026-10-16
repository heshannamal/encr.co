<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                <form  method="post" enctype="multipart/form-data" id="add_form">
                    @csrf
                    {{-- Organization Details --}}
                    <div class="card">
                        <div class="modal-card-header card-header">Organization Details</div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 modal-form-field">
                                    <label class="form-lable">Org. Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control modal-form-input" id="organization_name" name="organization_name" style="width: 88%;" required>
                                </div>

                                <div class="col-md-12 modal-form-field">
                                    <label class="form-lable">Contact Persons</label>
                                    <select class="form-control modal-form-input select2-people-modal" id="customer_id" name="customer_id[]" style="width: 83%;"  multiple="multiple">
                                        <option value="">Select a People</option>
                                        @foreach ($peoples as $people)
                                        <option value="{{$people->id}}">{{$people->first_name.' '.$people->last_name}}</option>
                                        @endforeach
                                    </select>

                                    <button id="btn_new_organiztion_add_Contacts" title="Add Contact Person" type="button" class="btn btn-sm input-group-text" data-toggle="modal" data-target="#people_create_modal12">
                                        <i class="fas fa-plus"></i>
                                    </button>
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
                                    {{-- <input type="text" class="form-control form-input select2-organization-modal" id="colors" name="colors" /> --}}
                                    <select class="form-control form-input select2-organization-modal" id="colors" name="colors[]"  multiple="multiple">
                                        <option value="">Select a People</option>
                                        @foreach($colorMasters as $colorMaster)
                                            <option value="{{ $colorMaster->id }}" data-hex="{{ $colorMaster->hex }}">{{ $colorMaster->pantone_code }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12 mb-3">
                                    <label class="form-lable">Organization Logo</label>
                                    <input type="file" style="height: calc(1.7rem + 2px);border-radius: 0rem;width:50%" class="form-control form-input" id="organization_logo" name="organization_logo" onchange="uploadCreateFile()" accept=".jpg,.jpeg,.png" style="width:75%; overflow: hidden;" />
                                </div>
                                <div class="col-md-6">
                                    <div id="image_container">
                                        <img src="{{ asset('argon') }}/img/icons/placeholder.png" id="create_image_preview" />
                                    </div>
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
                                    <input type="text" class="form-control modal-form-input" id="shipping_country" name="shipping_country" />
                                </div>
                            </div>
                        </div>
                    </div>

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

        $("#btn_new_organiztion_add_Contacts").click(function(){
            $("#new_organiztion_add_Contacts").val(1);
        });

        $('#cancel_btn').click(function(){
            // $('#add_form input[type=text]').each(
            //     function(index){
            //         $(this).html('');
            //         // var input = $(this);
            //         // console.log('Type: ' + input.attr('type') + 'Name: ' + input.attr('name') + 'Value: ' + input.val());
            //     }
            // );
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

        // $('#customer_id').change(function(){
        //     var contactId = $(this).val();
        //     $.ajax({
        //         url:'{{ url("organizations/check_contact") }}/'+contactId,
        //         method:'GET',
        //         dataType:'json',
        //         success: function(data){
        //             if(data){
        //                 Swal.fire({
        //                     title: "Caution!",
        //                     text: "This Customer Assigned to an Organization Already!",
        //                     type: "warning",
        //                     showConfirmButton: true
        //                 });
        //             }
        //         }
        //     });
        // });

    });

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
    $('.select2-organization-modal').select2({
            dropdownParent: $('#organization_create_modal')
        });
    $('#organization_create_modal').on('shown.bs.modal', function (e) {
        $.ajax({
            url: '{{ url("organizations/get_people_list") }}',
            type: "GET",
            dataType: 'json',
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data) {
                console.log(data);
                var people_options = '<option value="">Select a Contact Person</option>';
                for (let index = 0; index < data.length; index++) {
                    if (data[index].first_name) {
                        var first_name = data[index].first_name;
                    } else {
                        var first_name = '';
                    }

                    if (data[index].last_name) {
                        var last_name = data[index].last_name;
                    } else {
                        var last_name = '';
                    }
                    people_options += '<option value="'+data[index].id+'">'+first_name+' '+last_name+'</option>';
                }

                $('#customer_id').html(people_options);
            },
            complete: function() {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    })
</script>

