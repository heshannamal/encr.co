<div class="modal fade" id="adding_project_step_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Add Project</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('new_projects.create') }}" id="crt_project_form" method="POST">
                    @csrf
                    {{-- <div class="card">
                        <div class="card-body"> --}}
                            <div class="row">
                                <div class="col-md-12 row justify-content-center">
                                    <a href="#" class="pr-3" style="color: black;" id="project_step_1">
                                        <i class="fa fa-check-circle" aria-hidden="true" style="color: #01d101; font-size: 19px;"></i> Project Type
                                    </a>
                                    <div class="p-1"><i class="fa fa-chevron-right" aria-hidden="true"></i></div>
                                    <a href="#" class="pl-3" style="color: black;" id="project_step_2">
                                        <i class="fa fa-check-circle" aria-hidden="true" style="color: #01d101; font-size: 19px;"></i> Project Info
                                    </a>
                                </div>
                            </div>
                            <hr>
                        {{-- </div>
                    </div> --}}
                    {{-- <div class="card">
                        <div class="card-body"> --}}
                            <div class="row mt-3 px-5">
                                <div class="col-md-12" id="project_type_tab">
                                    <div class="row px-4">
                                        <div class="col-md-12">
                                            <h4>Project Type</h4>
                                        </div>
                                        <div class="col-md-12 pl-5">
                                            {{-- <div class="form-group"> --}}
                                                @foreach ($type as $projectType)
                                                    {{-- <input type="radio" name="project_type" id="project_type_{{ $projectType->id }}" value="{{ $projectType->id }}">
                                                    <label for="project_type_{{ $projectType->id }}">{{ $projectType->type_name }}</label> --}}
                                                    <div class="form-check">
                                                        <input class="form-check-input project-type" type="radio" name="project_type" id="project_type_{{ $projectType->id }}" value="{{ $projectType->id }}">
                                                        <label class="form-check-label" for="project_type_{{ $projectType->id }}">
                                                            {{ $projectType->type_name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            {{-- </div> --}}
                                        </div>
                                    </div>
                                    <div class="row py-3">
                                        <div class="col-md-12 text-right">
                                            <button type="button" class="btn btn-secondary cancel">CANCEL</button>
                                            <button type="button" class="btn btn-success" id="continue_btn">CONTINUE</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" id="project_info_tab">
                                    <div class="row px-4" id="project_info_div">
                                        <div class="col-md-12">
                                            <h4>Product Status</h4>
                                        </div>
                                        <div class="col-md-12 pl-5">
                                            <div class="border border-secondary p-3">
                                                <div class="form-check">
                                                    <input class="form-check-input product-status" type="radio" name="product_status" id="create_new" value="1">
                                                    <label class="form-check-label" for="create_new"> Create a new product </label>
                                                </div>
                                            </div>
                                            <div class="border border-secondary p-3 mt-3">
                                                <div class="form-check">
                                                    <input class="form-check-input product-status" type="radio" name="product_status" id="create_existing" value="2">
                                                    <label class="form-check-label" for="create_existing"> Create an existing product </label>
                                                </div>
                                                <div class="choose-product">
                                                    <label class="mt-4">Choose the product from the following dropdown list.</label>
                                                    <div class="form-group">
                                                        <label class="mb-0"> <strong>Product</strong></label>
                                                        <select class="form-control" name="product_for_create" id="product_for_create">
                                                            @foreach ($products as $product)
                                                                <option value="{{ $product->id }}">{{ $product->product_no }} - {{ $product->product_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {{-- </div>
                                <div class="col-md-12" id="project_details_tab"> --}}
                                    <div class="row px-4" id="project_details_div">
                                        <div class="col-md-12 pl-5 mt-4">
                                            <label class="mt-1">Enter your project details below.</label>
                                        </div>
                                        <div class="col-md-12 pl-5">
                                            <div class="form-group">
                                                <label class="mb-0"> <strong>Project Name</strong></label>
                                                <input type="text" name="project_name" id="crt_project_name"class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12 pl-5">
                                            <div class="form-group">
                                                <label class="mb-0"> <strong>Project status</strong></label>
                                                <select class="form-control" name="project_status" id="project_status">
                                                    @foreach ($projectStatuses as $projectStatus)
                                                        <option value="{{ $projectStatus->id }}">{{ $projectStatus->status_name  }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 pl-5">
                                            <div class="form-group">
                                                <label class="mb-0"> <strong>Project Description</strong></label>
                                                <textarea class="form-control" name="project_description" id="crt_project_description" rows="2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row py-3">
                                        <div class="col-md-12 text-right">
                                            <button type="button" class="btn btn-secondary cancel">CANCEL</button>
                                            <button type="button" class="btn btn-success" id="project_create_btn">CREATE PROJECT</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {{-- </div>
                    </div> --}}

                    <div class="row">
                        <div class="col-md-12"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){
        goToStepOne();
    });

    $('#continue_btn').on('click', function(){
        var projectType = $('.project-type:checked').val();
        if(projectType){
            goToStepTwo(projectType);
        }
    });

    $('.project-type').on('click', function(){
        pTypeSelectedCheck();
    });

    $('.product-status').on('click', function(){
        pChooseSelectedCheck();
    });

    $('#project_step_1').on('click', function(){
        goToStepOne();
    });

    $('#project_create_btn').on('click', function(){
        if(validateCreateForm()){
            $(".se-pre-con").fadeIn();
            $('#crt_project_form').submit();
        }
    });

    function validateCreateForm()
    {
        if($('.project-type:checked').val()){
            console.log($('.project-type:checked').val());

            if($('.project-type:checked').val() == 2){
                console.log('work');
                if($('.product-status').val()){
                    if($('.product-status').val() == 2){

                        if($('#product_for_create').val() != ''){
                            return true;
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: 'Please Select a Product...',
                                type: "error",
                            });
                            return false;
                        }

                    } else {
                        return true;
                    }
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: 'Please Select a Product Status...',
                        type: "error",
                    });
                    return false;
                }

            } else {
                console.log($('#crt_project_description').val());
                if($('#crt_project_name').val() == '' || $('#crt_project_name').val() == undefined){
                    Swal.fire({
                        title: "Error!",
                        text: 'Please Enter a Project Name...',
                        type: "error",
                    });
                    return false;
                }
                if($('#project_status').val() == '' || $('#project_status').val() == undefined){
                    Swal.fire({
                        title: "Error!",
                        text: 'Please Select a Project Status...',
                        type: "error",
                    });
                    return false;
                }
                if($('#crt_project_description').val() == '' || $('#crt_project_description').val() == undefined){
                    Swal.fire({
                        title: "Error!",
                        text: 'Please Enter a Project Description...',
                        type: "error",
                    });
                    return false;
                }

                return true;

            }

        } else {
            Swal.fire({
                title: "Error!",
                text: 'Please Select a Project Type...',
                type: "error",
            });
            return false;
        }
    }

    function pTypeSelectedCheck()
    {
        if($('.project-type:checked').length === 0 ){
            $('#continue_btn').prop('disabled', true);
        } else {
            $('#continue_btn').prop('disabled', false);
        }
    }

    function pChooseSelectedCheck()
    {
        if($('.product-status:checked').val() == 2){
            $('.choose-product').show(500);
        } else {
            $('.choose-product').hide(200);
        }
    }

    function goToStepOne()
    {
        $('#project_step_2').prop('disabled', true);
        pTypeSelectedCheck();

        $('#project_info_tab').hide(200);
        $('#project_info_div').hide(200);
        $('#project_details_div').hide(200);
        $('.choose-product').hide(200);
        $('#project_type_tab').show(500);
        resetAllChecks();
    }

    function resetAllChecks()
    {
        $('.project-type').prop('checked', false);
        $('.product-status').prop('checked', false);
    }

    function mainRest()
    {
        resetAllChecks();
        $('#crt_project_name').val('');
        $('#project_status').val('');
        $('#crt_project_description').text('');
        $('#product_for_create').val('');
    }

    function goToStepTwo($pType)
    {
        $('#project_type_tab').hide(200);
        $('.choose-product').hide(200);

        if($pType == 2){
            $('#project_details_div').hide(200);
            $('#project_info_div').show();
        } else {
            $('#project_info_div').hide(200);
            $('#project_details_div').show();
        }

        $('#project_info_tab').show(500);

    }


</script>
