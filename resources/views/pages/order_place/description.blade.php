@extends('layouts.app', ['activePage' => 'omg_details', 'titlePage' => __('OMG Details')])

@section('content')
<style>
    #image_container {
        width: 100px;
        height: 100px;
        margin-left: 15px;
        margin-top: -30px;
        border-radius: 50%;
        overflow: hidden;
    }
    #image_preview {
        width: 100%;
        height: 100%;
    }
</style>

<div class="container-fluid mb-5">
    <div class="se-pre-con"></div>
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <div class="col-md-5 float-left header-details">
                        <h4 class="mb-0">
                            <span class="d-block details-name">OMG Details</span>
                        </h4>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <form action="{{ url('pages-order_place-description-store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{-- Basic Information --}}
                    <div class="card mb-2">
                        
                        @if (request()->has('organization_id')) <input type="hidden" value="{{ request()->get('organization_id') }}" name="existing_organization" /> @endif
            
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 form-field">
                                    <label class="form-lable">Description <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-input" id="description" name="description" required />
                                </div>
            
            
                                <div class="col-md-6 form-field">
                                    <label class="form-lable">Price<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-input" id="price" name="price" required />
                                </div>
            
            
                                <div class="col-md-6 form-field">
                                    <label class="form-lable">Title </label>
                                    <label class="radio-inline" style="margin-right: 15px;"><input type="radio" name="gender" value="Men" checked>Men</label>
                                    <label class="radio-inline" style="margin-right: 15px;"><input type="radio" name="gender" value="Women">Women</label>
                                    <label class="radio-inline" style="margin-right: 15px;"><input type="radio" name="gender" value="Accessories">Accessories</label>
                                </div>
            
                                {{-- front picture --}}
                                <div class="col-md-6 form-field">
            
                                    <label class="form-lable">Front Picture<span class="text-danger">*</span></label>
                                          <input type="file" name="cover_image" id="cover_image" onchange="profilePreview(this);" class="form-control" style="width: 222px;">
            
                                            <label for="cover_image"></label>
                                             <img id="preview_img1" src="http://w3adda.com/wp-content/uploads/2019/09/No_Image-128.png" class="" width="210" height="150" style="margin-top:50px; margin-left: -210px;"/>
            
                                </div>
                                {{-- end --}}
            
                                {{-- Left side Picture --}}
                                <div class="col-md-6 form-field">
            
                                    <label class="form-lable">Left Side Picture<span class="text-danger">*</span></label>
                                          <input type="file" name="left_image" id="left_image" onchange="profilePreview1(this);" class="form-control" style="width: 222px;">
            
                                            <label for="cover_image1"></label>
                                             <img id="preview_img2" src="http://w3adda.com/wp-content/uploads/2019/09/No_Image-128.png" class="" width="210" height="150" style="margin-top:50px; margin-left: -210px;"/>
            
                                </div>
                                {{-- end --}}
            
                                {{-- Right side Picture --}}
                                <div class="col-md-6 form-field">
            
                                    <label class="form-lable">Right side Picture<span class="text-danger">*</span></label>
                                          <input type="file" name="right_image" id="right_image" onchange="profilePreview2(this);" class="form-control" style="width: 222px;">
            
                                            <label for="cover_image2"></label>
                                            <img id="preview_img3" src="http://w3adda.com/wp-content/uploads/2019/09/No_Image-128.png" class="" width="210" height="150" style="margin-top:50px; margin-left: -210px;"/>
                                </div>
                                {{-- end --}}
            
                                {{-- edit --}}
                                {{-- <label class="radio-inline"><input type="radio" name="vessel_type" value="local" @if($vesselvoyages->vessel_type == 'local') checked  @endif>Local</label>
                                 <label class="radio-inline"><input type="radio" name="vessel_type" value="feeder" @if($vesselvoyages->vessel_type == 'feeder') checked  @endif>Feeder</label> --}}
                                {{-- end --}}
            
                            </div>
                        </div>
            
                        <div class="card-footer"></div>
                    </div>
            
            
            
                    <div class="col-lg-12 control-btns mt-3 mb-5">
                        <button type="submit" id="submit_btn" class="btn btn-success btn-custom">Save</button>
                        <button type="reset" id="cancel_btn" class="btn btn-secondary btn-custom">Cancel</button>
                    </div>
                </form>
            </div>
        </div>



    </div>
</div>



<script>
    // $(document).ready(function() {
    //     $('select').select2();
    // });

    // function uploadFile() {
    //     var image_preview = document.getElementById("image_preview");
    //     var file = document.querySelector("input[type=file]").files[0];

    //     var reader = new FileReader();
    //     reader.onloadend = function () {
    //         image_preview.src = reader.result;
    //         document.getElementById("base64").value = reader.result;
    //     };

    //     if (file) {
    //         reader.readAsDataURL(file);

    //     } else {
    //         image_preview.src = "";

    //     }
    // }


    // front picture
    function profilePreview(input, id) {
    id = id || '#preview_img1';
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(id)
                    .attr('src', e.target.result)
                    .width(200)
                    .height(150);
        };

        reader.readAsDataURL(input.files[0]);
    }
 }
//  end

    // left side picture
    function profilePreview1(input, id) {
    id = id || '#preview_img2';
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(id)
                    .attr('src', e.target.result)
                    .width(200)
                    .height(150);
        };

        reader.readAsDataURL(input.files[0]);
    }
 }
//  end

    // right side picture
    function profilePreview2(input, id) {
    id = id || '#preview_img3';
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(id)
                    .attr('src', e.target.result)
                    .width(200)
                    .height(150);
        };

        reader.readAsDataURL(input.files[0]);
    }
 }
//  end


</script>
@endsection
