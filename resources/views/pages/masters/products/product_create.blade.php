@extends('layouts.app', ['activePage' => 'products', 'titlePage' => __('Products')])

@section('content')

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
.se-pre-con {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
}
.card-new{
    background-color: #fff;
    padding: 1rem;
}
.header-style{
    color: black;
    font-size: 1.2rem;
    font-weight: 600;
}
.form-label{
    margin-top: 0.5rem;
    color: black;
    font-size: 0.8rem;
    font-weight: 500;
    margin-bottom: .1rem;
}
.sub-header-style{
    color: black;
    font-size: 1rem;
    margin-top: 1rem;
    font-weight: 600;
}
.form-control {
    border-radius: 0rem;
}
.sub-product-style .pr{
    padding-right: .5rem;
}
.sub-product-style .pl{
    padding-left: .5rem;
}
.select2-selection__rendered{
    border: 1px solid #DEDEDE;
    border-radius: 0rem;
    color: #717070;
    padding-left: 7px;
    font-size: 0.8rem;
}
.select2 .selection .select2-selection--multiple{
    border: 1px solid #DEDEDE !important;
    border-radius: 0rem !important;
    color: #717070 !important;
    min-height: calc(1.5rem + 1px);
}
.select2-selection--multiple .select2-selection__rendered{
    border: none !important;
}
.fix-nav {
    margin-bottom: 1.5rem !important;
}
.subProductTable{
    width: 100%;
}
.subProductTable thead tr{
    background-color: grey;
    color: white;
    font-size: .7rem;
    height: 2.5rem;
}
.subProductTable tbody tr{
    height: 2.2rem;
    color: grey;
    border-bottom: 1px solid #e5e5e5
}
.subProductTable th, .subProductTable td{
    padding-left: 1rem;
    padding-right: 1rem;
}
.ql-toolbar{
    background-color: #fbfbfb;
}
.upload-area {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 95px;
    border: 2px dashed #ccc;
    text-align: center;
    padding: 10px;
    cursor: pointer;
}

.upload-area:hover {
    border-color: #007bff;
    cursor: pointer;
}
.navbarStylePaste.nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
    border-color: none;
}
.navbarStylePaste.nav-tabs{
    border-bottom: white;
}
.navbarStylePaste .nav-link{
    color: grey !important;
    background-color: white !important;
    border: none;
    border-bottom: 3px solid #dee2e6 !important;
}
.navbarStylePaste .nav-tabs .active, .navbarStylePaste .nav-link:hover{
    color: black !important;
    background-color: white !important;
    border: none;
    border-bottom: 3px solid black !important;
}
.close-button{
    position: absolute;
    top: 24%;
    right: 1%;
    background: none;
    border: none;
    outline: unset;
    cursor: pointer;
    color: #b3b3b3;
}
.functionalities_front_image, .functionalities_side_image, .functionalities_back_image, .functionalities_3d_images, .functionalities_lifestyle_images{
    background-color: transparent;
    color: #00af77;
    font-weight: 800;
    border: none;
    border-radius: .5rem;
    cursor: pointer;
}
.uploadStyles, .downloadStyles{
    border: none;
    background-color: transparent;
    outline: unset;
    cursor: pointer;
}
.uploadStyles{
    color: #00af77;
}
.downloadStyles{
    color:#44b4b4;
}
.uploadStyles:disabled, .downloadStyles:disabled {
    color: #dedede;
    border: none;
    background-color: transparent;
    outline: unset;
    cursor: not-allowed;
}
.fitsSizesRadioLayouts {
  display: none;
}

/* Style the custom square icons for radio buttons */
.fitsSizesRadioLayouts + label::before {
  content: "\25A0"; /* Unicode character for a solid square */
  font-size: 16px; /* Adjust the icon size as needed */
  padding-right: 5px; /* Add spacing between the icon and label text */
}

/* Style the labels for radio buttons */
.fitsSizesRadioLayouts + label {
  cursor: pointer;
  font-size: 0.9rem; /* Adjust the font size as needed */
  color: grey; /* Default text color */
}

/* Style the checked radio button */
.fitsSizesRadioLayouts:checked + label::before {
  color: black; /* Color when checked */
}
.checkboxLable::after{
    display: none;
}
.fitsSizesRadioLayouts + label::before {
    content: "\25A0";
    font-size: 16px;
    padding-right: 0px;
    content: "\2014";
    display: inline-block;
    transform: scaleY(4);
    padding-bottom: .18rem;
}
.form-input, .select2 .form-input {
    width: 100%;
}
.custom_btn{
    border-radius: 0rem;
    padding: .4rem 1rem;
    font-size: .8rem;
}

</style>
<style>
    .fa-spinner {
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    /* Container for the toggle switch */
.toggle-switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 24px;
    margin-left: 10px;
}

/* Hide the checkbox */
.toggle-checkbox {
    opacity: 0;
    width: 0;
    height: 0;
}

/* The slider */
.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 34px;
}

/* The circle inside the slider */
.toggle-slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 2px;
    bottom: 2px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
}

/* Move the slider to the right when checked */
.toggle-checkbox:checked + .toggle-slider {
    background-color: #4CAF50; /* Change this color to what you prefer for the "on" state */
}

/* Move the circle inside the slider */
.toggle-checkbox:checked + .toggle-slider:before {
    transform: translateX(26px);
}

/* Optional: Style the label */
.toggle-label {
    display: flex;
    align-items: center;
    font-size: 14px;
    font-weight: bold;
    color: #333; /* Text color */
    user-select: none; /* Disable text selection */
}
</style>

{{-- {{dd($product)}} --}}

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>@if($isExist == 1) EDIT PRODUCT - {{"PRO-". $productID }} @else CREATE PRODUCT - {{"PRO-". $productID }}  @endif</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('products') }}" class="home-btn-color" title="Back">BACK</a>
    @endsection

<div class="sub-product-style">
    <form action="{{ route('create_product') }}" method="post" enctype="multipart/form-data" id="product_create_form">
            @csrf

        <input type="hidden" id="product_id" name="product_id" value="{{$productID}}" readonly>
        <input type="hidden" id="new_product_no" name="new_product_no" value="{{"PRO-". $productID }}" readonly>
        <input type="hidden" id="existence" value="{{$isExist}}">

        {{-- @if($isExist == 1)
        <div class="row mb-3" style="background-color: transparent">
            <div class="col-md-12 header-style ml-2" style="font-size: 1.5rem;">
                 {{$product->product_name}}  &nbsp; <span style="color: #b3b3b3;font-size: 1.2rem;border-left: 3px solid #b3b3b3;border-right: 3px solid #b3b3b3;"> &nbsp; {{"PRO - ". $productID }} &nbsp; </span>
            </div>
        </div>
        @endif --}}
        <div class="row mb-3" style="border-bottom: 1px solid #d3d3d3;border-radius: 0px;">
            <div class="col-md-6 mb-2" style="padding-right: 2rem;">
                <input placeholder="Product Reference Link" @if($isExist == 1) value="{{$product->product_reference_link}}" @endif style="border: none;border-bottom: 1px solid #d3d3d3;border-radius: 0px;color:#d3d3d3;background-color: transparent;" type="text" class="form-control form-input" id="new_product_reference_link" name="new_product_reference_link">
            </div>
            <div class="col-md-3 ml-auto text-right">
                <label for="toggleButton">
                    Show in Catalog
                    <div class="toggle-switch">
                        <input type="checkbox" name="show_in_catalog" id="toggleButton" class="toggle-checkbox" @if($isExist == 1) @if($product->show_in_catalog == 1) checked @endif @endif>
                        <span class="toggle-slider"></span>
                    </div>
                </label>
            </div>
            <div class="col-md-2 mb-2 mr-3" style="border-bottom: 1px solid #d3d3d3;">
                <select style="border: none;border-radius: 0px;color:#d3d3d3;background-color: transparent;" class="form-control form-input" id="active" name="active">
                    {{-- <option value="0">Product Status</option> --}}
                    <option value="1" @if($isExist == 1) @if($product->active == 1) selected @endif @endif>Active</option>
                    <option value="3" @if($isExist == 1) @if($product->active == 3) selected @endif @endif @if($isExist == 0) selected @endif>Under Construction</option>
                    <option value="0" @if($isExist == 1) @if($product->active == 0) selected @endif @endif>Inactive</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" style="padding: .5rem">
                <div class="row" style="margin:unset;">
                    <div class="card-new col-md-6">
                        <div class="row">
                            <div class="col-md-9 header-style">
                                Product
                            </div>
                            {{-- <div class="col-md-3 header-style text-right" style="color: #b3b3b3">
                                {{"PRO - ". $productID }}
                            </div> --}}
                            <div class="col-md-12 mt-3">
                                <label for="new_product_name" class="form-label">Name</label>
                                <input type="text" class="form-control form-input" id="new_product_name" @if($isExist == 1) value="{{$product->product_name}}" @endif name="new_product_name">
                            </div>
                            <div class="col-md-12 mt-3">
                                <label for="new_product_name" class="form-label">Name Show in Catalog</label>
                                <input type="text" class="form-control form-input"
                                    id="show_in_catalog_name"
                                    @if($isExist == 1)
                                        value="{{ $product->show_in_catalog_name ?? $product->product_name }}"
                                    @endif
                                    name="show_in_catalog_name">

                            </div>
                            <div class="col-md-6 mt-3 mb-1">
                                <label for="new_main_category_id" class="form-label">Category</label>
                                <select class="form-control form-input multy-selection" id="new_main_category_id" name="new_main_category_id[]" multiple="multiple">
                                    @foreach ($mainCategories as $mainCategorie)
                                        <option value="{{$mainCategorie->id}}" @if($isExist == 1) @if($product->main_category_id->contains($mainCategorie->id)) selected @endif @endif>{{$mainCategorie->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="pattern_code" class="form-label">Pattern Code</label>
                                <input type="text" class="form-control form-input" id="pattern_code" @if($isExist == 1) value="{{$product->pattern_code}}" @endif name="pattern_code">
                            </div>
                                <div class="col-md-6 mt-3 mb-1">
                                    <label for="new_gender" class="form-label">Gender</label>
                                    <select class="form-control form-input" id="new_gender" name="new_gender">
                                        <option value="0">Select a Gender</option>
                                        <option value="Men" @if($isExist == 1) @if($product->gender == 'Men') selected @endif @endif>Men's</option>
                                        <option value="Women" @if($isExist == 1) @if($product->gender == 'Women') selected @endif @endif>Women's</option>
                                        <option value="Uni" @if($isExist == 1) @if($product->gender == 'Uni') selected @endif @endif>Uni</option>
                                        <option value="Kisd" @if($isExist == 1) @if($product->gender == 'Kisd') selected @endif @endif>Kids</option>
                                    </select>
                                </div>
                            <div class="col-md-6 mt-3 mb-1">
                                <label for="new_size_id" class="form-label">Size</label>
                                <select class="form-control form-input" id="new_size_id" name="new_size_id">
                                    <option value="">Select a Size</option>
                                    @foreach ($sizeTypes as $sizeType)
                                        <option value="{{ $sizeType->id }}" @if($isExist == 1) @if($sizeType->id == $product->size_id) selected @endif @endif>{{ $sizeType->type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mt-3 mb-1">
                                <label class="form-label">Fits true to size</label>
                                <div class="row ml-1" style="color: grey; font-size: .9rem;">
                                    <span>smaller&nbsp;&nbsp;</span>
                                    <input class="fitsSizesRadioLayouts" type="radio" id="fitsSizes1" name="fitsSizes" value="1" @if($isExist == 1) @if($product->fits_true_to_size == 1) checked @endif @endif>
                                    <label class="checkboxLable" for="fitsSizes1"></label>&nbsp;

                                    <input class="fitsSizesRadioLayouts" type="radio" id="fitsSizes2" name="fitsSizes" value="2" @if($isExist == 1) @if($product->fits_true_to_size == 2) checked @endif @endif>
                                    <label class="checkboxLable" for="fitsSizes2"></label>&nbsp;

                                    <input class="fitsSizesRadioLayouts" type="radio" id="fitsSizes3" name="fitsSizes" value="3" @if($isExist == 0) checked @endif @if($isExist == 1) @if($product->fits_true_to_size == 3) checked @endif @endif>
                                    <label class="checkboxLable" for="fitsSizes3"></label>&nbsp;

                                    <input class="fitsSizesRadioLayouts" type="radio" id="fitsSizes4" name="fitsSizes" value="4" @if($isExist == 1) @if($product->fits_true_to_size == 4) checked @endif @endif>
                                    <label class="checkboxLable" for="fitsSizes4"></label>&nbsp;

                                    <input class="fitsSizesRadioLayouts" type="radio" id="fitsSizes5" name="fitsSizes" value="5"@if($isExist == 1) @if($product->fits_true_to_size == 5) checked @endif @endif>
                                    <label class="checkboxLable" for="fitsSizes5"></label>

                                    <span>&nbsp;&nbsp;Larger</span>
                                </div>

                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="MOQ" class="form-label">MOQ</label>
                                <input type="number" class="form-control form-input" id="MOQ" @if($isExist == 1) value="{{$product->MOQ}}" @endif name="MOQ">
                            </div>
                            <div class="col-md-12">
                            <label for="embellishment_options" class="form-label">Embellishment Options</label>
                            <select class="form-control form-input multy-selection" id="embellishment_options" name="new_embellishment_type_id[]" multiple="multiple">
                                @foreach ($embellishmentTypes as $embellishmentType)
                                    <option value="{{ $embellishmentType->id }}" @if ($isExist == 1 && !empty($product->embellishmentTypes) && $product->embellishmentTypes->contains($embellishmentType->id)) selected @endif>
                                        {{ $embellishmentType->embellishment_name }}
                                        @if ($embellishmentType->price != 0) ( +${{ $embellishmentType->price }} ) @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                            {{-- <div class="col-md-12 mt-3 mb-1 div_none1">
                                <label class="form-label">Available Colors <span class="text-danger"></span></label><br>
                                <select class="form-control form-input multy-selection" id="new_available_colors" name="new_available_colors[]" multiple="multiple">
                                    @foreach ($colorMasters as $colorMaster)
                                        <option value="{{$colorMaster->id}}" data-hex="{{$colorMaster->hex}}"
                                            @if(isset($mainProductColor) && in_array($colorMaster->id, $mainProductColor)) selected @endif>
                                            {{$colorMaster->pantone_code}}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="col-md-12 mt-3 mb-1">
                                <label for="new_product_category_id" class="form-label">Styles</label>
                                <select class="form-control form-input multy-selection" id="new_product_category_id" name="new_product_category_id[]" multiple="multiple">
                                    @foreach ($productCategories as $productCategory)
                                        <option value="{{$productCategory->id}}" @if($isExist == 1) @if($product->product_category_id->contains($productCategory->id)) selected @endif @endif>{{$productCategory->product_category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mt-3 mb-1">
                                <label for="new_sport" class="form-label">Sport</label>
                                <select class="form-control form-input multy-selection" id="new_sport" name="new_sport[]" multiple="multiple">
                                    @foreach ($sports as $sport)
                                        <option value="{{$sport->id}}" @if($isExist == 1) @if($product->sport->contains($sport->id)) selected @endif @endif>{{$sport->sport_name}}</option>
                                        @endforeach
                                    </select>
                            </div>
                            <div class="col-md-12 mt-3 mb-1">
                                <label for="new_product_attribute_id" class="form-label">Attributes</label>
                                <select class="form-control form-input multy-selection" id="new_product_attribute_id" name="new_product_attribute_id[]" multiple="multiple">
                                    @foreach ($productAttributes as $productAttribute)
                                        <option value="{{$productAttribute->id}}" @if($isExist == 1) @if($product->attributes->contains($productAttribute->id)) selected @endif @endif>{{$productAttribute->attribute_name}} @if ($productAttribute->price != 0) {{'(+$'.$productAttribute->price.')'}} @endif</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- {{dd($product->attribute_on_price)}} --}}
                            <div class="col-md-12">
                                <label for="attribute_on_price" class="form-label">Attributes Included in Unit Price</label>
                                <select class="form-control multi-selection" id="attribute_on_price" name="attribute_on_price[]" multiple="multiple">
                                    @foreach ($productAttributes as $productAttribute)
                                        <option value="{{$productAttribute->id}}"
                                            @if($isExist == 1)
                                                @foreach ($product->attribute_on_price as $attribute_on_price)
                                                    @if ($attribute_on_price == $productAttribute->id)
                                                    selected
                                                    @endif
                                                @endforeach
                                            @endif
                                        >{{$productAttribute->attribute_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mt-3 mb-1">
                                <label for="new_product_factory_id" class="form-label">Factories</label>
                                <select class="form-control form-input multy-selection" id="new_product_factory_id" name="new_product_factory_id[]" multiple="multiple">
                                    @foreach ($factories as $factory)
                                        <option value="{{$factory->id}}"  @if($isExist == 1) @if($product->factory->contains($factory->id)) selected @endif @endif>{{$factory->factory_code}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mt-3 mb-1">
                                <label for="product_tagline_id" class="form-label">Available Product Taglines</label>
                                <select class="form-control form-input multy-selection" id="product_tagline_id" name="product_tagline_id[]" multiple="multiple">
                                    @foreach ($productTaglines as $productTagline)
                                        <option value="{{$productTagline->id}}"  @if($isExist == 1) @if($product->tagline->contains($productTagline->id)) selected @endif @endif>{{$productTagline->tagline_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mt-3 mb-1">
                                <label for="product_fit_id" class="form-label">Available Fits</label>
                                <select class="form-control form-input multy-selection" id="product_fit_id" name="product_fit_id[]" multiple="multiple">
                                    @foreach ($masterFits as $masterFit)
                                        <option value="{{$masterFit->id}}"  @if($isExist == 1) @if($product->fit->contains($masterFit->id)) selected @endif @endif>{{$masterFit->fit_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mt-3 mb-1">
                                <label for="new_notes" class="form-label">Note</label>
                                <textarea style="height: 40px;" class="form-control form-input" id="new_notes" name="new_notes" rows="3">@if($isExist == 1) {{$product->notes}} @endif</textarea>
                            </div>
                        </div>

                    </div>

                    <div class="card-new col-md-6 permission-adding-class" style="margin-left: 10px; max-width: 47%;">
                        <div class="row">
                            <div class="col-md-12 header-style">
                                Product Images
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-8 pr">
                                <label class="form-label" style="font-weight:100; color:#b3b3b3">Product Image Preview</label>
                                <img @if($isExist == 1 && $product->mockup_img_1 !== null) src="{{ asset('assets') }}{{$product->mockup_img_1}}" @else src="{{ asset('public/images/default.png') }}" @endif id="imagePreviewArea" alt="Image" style="width: 100%;height: auto;border: 2px solid #f9f9f9;">
                            </div>
                            <div class="col-md-4 pl">
                                <!-- Front Image -->
                                <div class="col-md-12" style="padding: 0rem">
                                    <label class="form-label" style="font-weight:700">Front image</label>
                                    <label for="front_image" id="front_image_upload_area" class="upload-area"
                                        @if($isExist == 1 && $product->mockup_img_1 == null || $isExist != 1) style="display: block;" @else style="display: none;" @endif>
                                        <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                        <div class="upload-icon">
                                            <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD IMAGE</i><br>
                                            <p style="color: #ff0000;font-size: .8rem;">590px x 798px</p>
                                        </div>
                                    </label>
                                    <label for="front_image" id="front_image_display_area" class="upload-area"
                                        @if($isExist == 1 && $product->mockup_img_1 !== null) style="display: block;" @else style="display: none;" @endif>
                                        <img src="{{ $isExist == 1 && $product->mockup_img_1 !== null ? asset('assets') . $product->mockup_img_1 : asset('public/images/default.png') }}"
                                             id="front_image_uploaded" alt="Image" style="width: auto;height: 100%;border: 2px solid #f9f9f9;">
                                        <button type="button" onclick="removeImagePreview('front_image')" class="close-button">X</button>
                                    </label>
                                    <input type="file" id="front_image" name="front_image" onchange="imageDisplay(this , 'front_image')" class="file-select" accept="image/*" style="display: none">
                                    <div style="display: flex; align-items: center;">
                                        <button type="button" title="Upload Image" class="functionalities_front_image" onclick="uploadImages('front_image', 'mockup', 'Mockup - Front Side', 'mockup_img_1')" style="display: none;">
                                            <i class="fa fa-cloud-upload" id="front_image_upload"></i><i class="fas fa-spinner fa-spin" id="front_image_loading" style="display: none"></i>
                                        </button>
                                        <div class="row" style="margin: unset;">
                                            <button type="button" title="Preview Image" class="text-right functionalities_front_image"
                                                    onclick="previewImg('front_image')"
                                                    @if($isExist == 1 && $product->mockup_img_1 !== null) style="display: block;" @else style="display: none;" @endif>
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </button>
                                            <button type="button" title="Image Caption" class="text-right functionalities_front_image image_caption"
                                                    @if($isExist == 1 && !empty($product) && $product->mockup_img_1 !== null)
                                                        style="display: block;"
                                                        onclick="openModal('{{ asset('assets' . $product->mockup_img_1) }}', '{{ $productID }}', 'mockup_img_1')"
                                                    @else
                                                        style="display: none;"
                                                    @endif>
                                                <img src="{{ asset('assets/img/products/text_icon.png') }}" alt="image" style="width: 21px; color:black" class="image_width">
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Side Image -->
                                <div class="col-md-12" style="padding: 0rem">
                                    <label class="form-label" style="font-weight:700">Side image</label>
                                    <label for="side_image" id="side_image_upload_area" class="upload-area"
                                        @if($isExist == 1 && $product->mockup_img_2 == null || $isExist != 1) style="display: block;" @else style="display: none;" @endif>
                                        <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                        <div class="upload-icon">
                                            <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD IMAGE</i><br>
                                            <p style="color: #ff0000;font-size: .8rem;">590px x 798px</p>
                                        </div>
                                    </label>
                                    <label for="side_image" id="side_image_display_area" class="upload-area"
                                        @if($isExist == 1 && $product->mockup_img_2 !== null) style="display: block;" @else style="display: none;" @endif>
                                        <img src="{{ $isExist == 1 && $product->mockup_img_2 !== null ? asset('assets') . $product->mockup_img_2 : asset('public/images/default.png') }}"
                                             id="side_image_uploaded" alt="Image" style="width: auto;height: 100%;border: 2px solid #f9f9f9;">
                                        <button type="button" onclick="removeImagePreview('side_image')" class="close-button">X</button>
                                    </label>
                                    <input type="file" id="side_image" name="side_image" onchange="imageDisplay(this , 'side_image')" class="file-select" accept="image/*" style="display: none">
                                    <div style="display: flex; align-items: center;">
                                        <button type="button" title="Upload Image" class="functionalities_side_image" onclick="uploadImages('side_image', 'mockup', 'Mockup - Side', 'mockup_img_2')" style="display: none;">
                                            <i class="fa fa-cloud-upload" id="side_image_upload"></i><i class="fas fa-spinner fa-spin" id="side_image_loading" style="display: none"></i>
                                        </button>
                                        <button type="button" title="Preview Image" class="text-right functionalities_side_image"
                                                onclick="previewImg('side_image')"
                                                @if($isExist == 1 && $product->mockup_img_2 !== null) style="display: block;" @else style="display: none;" @endif>
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                        <button type="button" title="Image Caption" class="text-right functionalities_side_image image_caption"
                                                @if($isExist == 1 && $product->mockup_img_2 !== null)
                                                    style="display: block;"
                                                    onclick="openModal('{{ asset('assets' . $product->mockup_img_2) }}', '{{ $productID }}', 'mockup_img_2')"
                                                @else
                                                    style="display: none;"
                                                @endif>
                                            <img src="{{ asset('assets/img/products/text_icon.png') }}" alt="image" style="width: 21px; color:black" class="image_width">
                                        </button>
                                    </div>
                                </div>

                                <!-- Back Image -->
                                <div class="col-md-12" style="padding: 0rem">
                                    <label class="form-label" style="font-weight:700">Back image</label>
                                    <label for="back_image" id="back_image_upload_area" class="upload-area"
                                        @if($isExist == 1 && $product->mockup_img_3 == null || $isExist != 1) style="display: block;" @else style="display: none;" @endif>
                                        <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                        <div class="upload-icon">
                                            <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD IMAGE</i><br>
                                            <p style="color: #ff0000;font-size: .8rem;">590px x 798px</p>
                                        </div>
                                    </label>
                                    <label for="back_image" id="back_image_display_area" class="upload-area"
                                        @if($isExist == 1 && $product->mockup_img_3 !== null) style="display: block;" @else style="display: none;" @endif>
                                        <img src="{{ $isExist == 1 && $product->mockup_img_3 !== null ? asset('assets') . $product->mockup_img_3 : asset('public/images/default.png') }}"
                                             id="back_image_uploaded" alt="Image" style="width: auto;height: 100%;border: 2px solid #f9f9f9;">
                                        <button type="button" onclick="removeImagePreview('back_image')" class="close-button">X</button>
                                    </label>
                                    <input type="file" id="back_image" name="back_image" onchange="imageDisplay(this , 'back_image')" class="file-select" accept="image/*" style="display: none">
                                    <div style="display: flex; align-items: center;">
                                        <button type="button" title="Upload Image" class="functionalities_back_image" onclick="uploadImages('back_image', 'mockup', 'Mockup - Back Side', 'mockup_img_3')" style="display: none;">
                                            <i class="fa fa-cloud-upload" id="back_image_upload"></i><i class="fas fa-spinner fa-spin" id="back_image_loading" style="display: none"></i>
                                        </button>
                                        <button type="button" title="Preview Image" class="text-right functionalities_back_image"
                                                onclick="previewImg('back_image')"
                                                @if($isExist == 1 && $product->mockup_img_3 !== null) style="display: block;" @else style="display: none;" @endif>
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                        <button type="button" title="Image Caption" class="text-right functionalities_back_image image_caption"
                                                @if($isExist == 1 && $product->mockup_img_3 !== null)
                                                    style="display: block;"
                                                    onclick="openModal('{{ asset('assets' . $product->mockup_img_3) }}', '{{ $productID }}', 'mockup_img_3')"
                                                @else
                                                    style="display: none;"
                                                @endif>
                                            <img src="{{ asset('assets/img/products/text_icon.png') }}" alt="image" style="width: 21px; color:black" class="image_width">
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        {{-- {{dd($productImages)}} --}}
                        <div class="row navbarStylePaste">
                            <div class="tab-container" style="width:100%;padding: 1rem;">
                                <ul class="nav nav-tabs" style="border: none">
                                    <li class="nav-item">
                                        <a class="nav-link nav-link1 active" id="tab-3d" href="#3d-tab" style="font-size: 10px;">FLAT IMG</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link nav-link1" id="tab-lifestyle" href="#lifestyle-tab" style="font-size: 10px;">LIFESTYLE IMG</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link nav-link1" id="tab-closeup" href="#closeup-tab" style="font-size: 10px;">FEATURE CLOSE-UP IMG </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link nav-link1" id="tab-branding" href="#branding-tab" style="font-size: 10px;">BRANDING IMG</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link nav-link1" id="tab-studio" href="#studio-tab" style="font-size: 10px;">STUDIO IMG</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane tab-pane1" id="lifestyle-tab">
                                        <div class="col-md-12 mt-3" style="padding: 0rem">
                                            <label for="lifestyle_images" id="lifestyle_images_upload_area" class="upload-area" style="height: 200px;">
                                                <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                                <div class="upload-icon">
                                                    <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD IMAGE</i>
                                                </div>
                                                <p style="color: #b3b3b3;font-size: .8rem;margin-top: .5rem; margin-bottom: unset;">Drag & drop LIFESTYLE images here or <span style="font-weight: 600">CLICK HERE</span>  to upload LIFESTYLE images</p><br>
                                                <p style="color: #ff0000;font-size: .8rem;">Maximum file size: 1MB with a resolution of 590px x 798px</p>
                                            </label>

                                            <input type="file" id="lifestyle_images" onchange="uploadMultipleImages('lifestyle_images', null)" class="file-select" accept="image/*" style="display: none;" multiple>

                                        </div>
                                        @if($productImages !== null)
                                        <div class="row mt-2" id="uploaded_lifestyle_images_table" @if(count($productImages->where('image_type',2)) < 1 ) style="display: none" @endif>
                                            <div class="col-md-12 sub-header-style">
                                                Uploaded Lifestyle Images
                                            </div>
                                            <div class="col-md-12 mt-3 mb-2">
                                                <table class="subProductTable">
                                                    <thead>
                                                        <tr>
                                                            <th>FILE NAME</th>
                                                            <th style="width: 40%;" class="text-center">ACTION</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="lifestyle_images_tbody">
                                                        @foreach ($productImages as $productImage)
                                                            @if ($productImage->image_type == 2)
                                                                <tr>
                                                                    <td>{{ \Illuminate\Support\Str::limit($productImage->image_name, 30, '...') }}</td>
                                                                    <td class="text-center">
                                                                        <button class="uploadStyles" data-toggle="modal" data-target="#image_view_modal" data-img-src="{{ asset('') }}{{$productImage->image_link}}" type="button" title="View">
                                                                            <i class="fa fa-eye" style="color: grey;"></i>
                                                                        </button>

                                                                        <button type="button" title="Image Caption" class="text-right functionalities_front_image image_caption"
                                                                            onclick="openImageModal('{{ asset($productImage->image_link) }}', '{{ $productID }}', '{{ $productImage->id }}')">
                                                                            <img src="{{ asset('assets/img/products/text_icon.png') }}" alt="image" style="width: 21px; color:black" class="image_width">
                                                                        </button>

                                                                        <button class="uploadStyles" type="button" title="Upload">
                                                                            <i class="fa fa-trash" onclick="removeImg({{$productImage->id}})" style="color: #e19191;"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane tab-pane1  active" id="3d-tab">
                                        <div class="col-md-12 mt-3" style="padding: 0rem">
                                            <label for="3D_images" id="3D_images_upload_area" class="upload-area" style="height: 200px;">
                                                <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                                <div class="upload-icon">
                                                    <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD IMAGE</i>
                                                </div>
                                                <p style="color: #b3b3b3;font-size: .8rem;margin-top: .5rem; margin-bottom:unset;">Drag & drop Flat images here or <span style="font-weight: 600">CLICK HERE</span> to upload Flat images</p>
                                                <p style="color: #ff0000;font-size: .8rem;">Maximum file size: 1MB with a resolution of 590px x 798px.</p>
                                            </label>
                                            <input type="file" id="3D_images" onchange="uploadMultipleImages('3D_images', null)" class="file-select" accept="image/*" style="display: none;" multiple>

                                        </div>
                                        @if($productImages !== null)
                                        <div class="row mt-2" id="uploaded_3D_images_table" @if(count($productImages->where('image_type',1)) < 1 ) style="display: none" @endif>
                                            <div class="col-md-12 sub-header-style">
                                                Uploaded Flat Images
                                            </div>
                                            <div class="col-md-12 mt-3 mb-2">
                                                <table class="subProductTable">
                                                    <thead>
                                                        <tr>
                                                            <th>FILE NAME</th>
                                                            <th style="width: 40%;" class="text-center">ACTION</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="3D_images_tbody">
                                                        @foreach ($productImages as $productImage)
                                                            @if ($productImage->image_type == 1)
                                                                <tr>
                                                                    <td>{{ \Illuminate\Support\Str::limit($productImage->image_name, 30, '...') }}</td>
                                                                    <td class="text-center">
                                                                        <button class="uploadStyles" data-toggle="modal" data-target="#image_view_modal" data-img-src="{{ asset('') }}{{$productImage->image_link}}" type="button" title="View">
                                                                            <i class="fa fa-eye" style="color: grey;"></i>
                                                                        </button>

                                                                        <button type="button" title="Image Caption" class="text-right functionalities_front_image image_caption"
                                                                            onclick="openImageModal('{{ asset($productImage->image_link) }}', '{{ $productID }}', '{{ $productImage->id }}')">
                                                                            <img src="{{ asset('assets/img/products/text_icon.png') }}" alt="image" style="width: 21px; color:black" class="image_width">
                                                                        </button>

                                                                        <button class="uploadStyles" type="button" title="Upload">
                                                                            <i class="fa fa-trash" onclick="removeImg({{$productImage->id}})" style="color: #e19191;"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane tab-pane1" id="closeup-tab">
                                        <div class="col-md-12 mt-3" style="padding: 0rem">
                                            <label for="close_up_images" id="close_up_images_upload_area" class="upload-area" style="height: 200px;">
                                                <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                                <div class="upload-icon">
                                                    <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD IMAGE</i>
                                                </div>
                                                <p style="color: #b3b3b3;font-size: .8rem;margin-top: .5rem; margin-bottom: unset;">Drag & drop CLOSE_UP images here or <span style="font-weight: 600">CLICK HERE</span> to upload CLOSE_UP images</p><br>
                                                <p style="color: #ff0000;font-size: .8rem;">Maximum file size: 1MB with a resolution of 590px x 798px</p>
                                            </label>
                                            <input type="file" id="close_up_images" onchange="uploadMultipleImages('close_up_images', null)" class="file-select" accept="image/*" style="display: none;" multiple>

                                        </div>
                                        @if($productImages !== null)
                                        <div class="row mt-2" id="uploaded_close_up_images_table" @if(count($productImages->where('image_type',3)) < 1 ) style="display: none" @endif>
                                            <div class="col-md-12 sub-header-style">
                                                Uploaded Close-up Images
                                            </div>
                                            <div class="col-md-12 mt-3 mb-2">
                                                <table class="subProductTable">
                                                    <thead>
                                                        <tr>
                                                            <th>FILE NAME</th>
                                                            <th style="width: 40%;" class="text-center">ACTION</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="close_up_images_tbody">
                                                        @foreach ($productImages as $productImage)
                                                            @if ($productImage->image_type == 3)
                                                                <tr>
                                                                    <td>{{ \Illuminate\Support\Str::limit($productImage->image_name, 30, '...') }}</td>
                                                                    <td class="text-center">
                                                                        <button class="uploadStyles" data-toggle="modal" data-target="#image_view_modal" data-img-src="{{ asset('') }}{{$productImage->image_link}}" type="button" title="View">
                                                                            <i class="fa fa-eye" style="color: grey;"></i>
                                                                        </button>

                                                                        <button type="button" title="Image Caption" class="text-right functionalities_front_image image_caption"
                                                                            onclick="openImageModal('{{ asset($productImage->image_link) }}', '{{ $productID }}', '{{ $productImage->id }}')">
                                                                            <img src="{{ asset('assets/img/products/text_icon.png') }}" alt="image" style="width: 21px; color:black" class="image_width">
                                                                        </button>

                                                                        <button class="uploadStyles" type="button" title="Upload">
                                                                            <i class="fa fa-trash" onclick="removeImg({{$productImage->id}})" style="color: #e19191;"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane tab-pane1" id="branding-tab">
                                        <div class="col-md-12 mt-3" style="padding: 0rem">
                                            <label for="branding_images" id="branding_images_upload_area" class="upload-area" style="height: 200px;">
                                                <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                                <div class="upload-icon">
                                                    <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD IMAGE</i>
                                                </div>
                                                <p style="color: #b3b3b3;font-size: .8rem;margin-top: .5rem; margin-bottom: unset;">Drag & drop BRANDING images here or <span style="font-weight: 600">CLICK HERE</span> to upload BRANDING images</p><br>
                                                <p style="color: #ff0000;font-size: .8rem;">Maximum file size: 1MB with a resolution of 590px x 798px</p>
                                            </label>

                                            <input type="file" id="branding_images" onchange="uploadMultipleImages('branding_images', null)" class="file-select" accept="image/*" style="display: none;" multiple>

                                        </div>
                                        @if($productImages !== null)
                                        <div class="row mt-2" id="uploaded_branding_images_table" @if(count($productImages->where('image_type',4)) < 1 ) style="display: none" @endif>
                                            <div class="col-md-12 sub-header-style">
                                                Uploaded Branding Images
                                            </div>
                                            <div class="col-md-12 mt-3 mb-2">
                                                <table class="subProductTable">
                                                    <thead>
                                                        <tr>
                                                            <th>FILE NAME</th>
                                                            <th style="width: 40%;" class="text-center">ACTION</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="branding_images_tbody">
                                                        @foreach ($productImages as $productImage)
                                                            @if ($productImage->image_type == 4)
                                                                <tr>
                                                                    <td>{{ \Illuminate\Support\Str::limit($productImage->image_name, 30, '...') }}</td>
                                                                    <td class="text-center">
                                                                        <button class="uploadStyles" data-toggle="modal" data-target="#image_view_modal" data-img-src="{{ asset('') }}{{$productImage->image_link}}" type="button" title="View">
                                                                            <i class="fa fa-eye" style="color: grey;"></i>
                                                                        </button>

                                                                        <button type="button" title="Image Caption" class="text-right functionalities_front_image image_caption"
                                                                            onclick="openImageModal('{{ asset($productImage->image_link) }}', '{{ $productID }}', '{{ $productImage->id }}')">
                                                                            <img src="{{ asset('assets/img/products/text_icon.png') }}" alt="image" style="width: 21px; color:black" class="image_width">
                                                                        </button>

                                                                        <button class="uploadStyles" type="button" title="Upload">
                                                                            <i class="fa fa-trash" onclick="removeImg({{$productImage->id}})" style="color: #e19191;"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane tab-pane1" id="studio-tab">
                                        <div class="col-md-12 mt-3" style="padding: 0rem">
                                            <label for="studio_images" id="studio_images_upload_area" class="upload-area" style="height: 200px;">
                                                <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                                <div class="upload-icon">
                                                    <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD IMAGE</i>
                                                </div>
                                                <p style="color: #b3b3b3;font-size: .8rem;margin-top: .5rem; margin-bottom: unset;">Drag & drop STUDIO images here or <span style="font-weight: 600">CLICK HERE</span> to upload STUDIO images</p><br>
                                                <p style="color: #ff0000;font-size: .8rem;">Maximum file size: 1MB with a resolution of 590px x 798px</p>
                                            </label>

                                            <input type="file" id="studio_images" onchange="uploadMultipleImages('studio_images', null)" class="file-select" accept="image/*" style="display: none;" multiple>

                                        </div>
                                        @if($productImages !== null)
                                        <div class="row mt-2" id="uploaded_studio_images_table" @if(count($productImages->where('image_type',5)) < 1 ) style="display: none" @endif>
                                            <div class="col-md-12 sub-header-style">
                                                Uploaded Studio Images
                                            </div>
                                            <div class="col-md-12 mt-3 mb-2">
                                                <table class="subProductTable">
                                                    <thead>
                                                        <tr>
                                                            <th>FILE NAME</th>
                                                            <th style="width: 40%;" class="text-center">ACTION</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="studio_images_tbody">
                                                        @foreach ($productImages as $productImage)
                                                            @if ($productImage->image_type == 5)
                                                                <tr>

                                                                    <td>{{ \Illuminate\Support\Str::limit($productImage->image_name, 30, '...') }}</td>
                                                                    <td class="text-center">
                                                                        <button class="uploadStyles" data-toggle="modal" data-target="#image_view_modal" data-img-src="{{ asset('') }}{{$productImage->image_link}}" type="button" title="View">
                                                                            <i class="fa fa-eye" style="color: grey;"></i>
                                                                        </button>

                                                                        <button type="button" title="Image Caption" class="text-right functionalities_front_image image_caption"
                                                                            onclick="openImageModal('{{ asset($productImage->image_link) }}', '{{ $productID }}', '{{ $productImage->id }}')">
                                                                            <img src="{{ asset('assets/img/products/text_icon.png') }}" alt="image" style="width: 21px; color:black" class="image_width">
                                                                        </button>

                                                                        <button class="uploadStyles" type="button" title="Upload">
                                                                            <i class="fa fa-trash" onclick="removeImg({{$productImage->id}})" style="color: #e19191;"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-md-12" style="padding: .5rem">
                <div class="row" style="margin: unset;">
                    @can('view design files')
                        <div class="card-new mt-3 col-md-6">
                            <div class="row">
                                <div class="col-md-12 header-style">
                                    Design Files
                                </div>
                                <div class="col-md-12 mt-3 mb-2">
                                    <table class="subProductTable">
                                        <thead>
                                            <tr>
                                                <th>FILE NAME</th>
                                                <th></th>
                                                <th class="text-center">ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @can('view_2D_Mockup_Template')
                                                <tr>
                                                    <td>2D Mockup Template</td>
                                                    <td><input type="file" id="2D_mockup_template" @if($isExist == 1) @if ($product->{'2D_mockup'} != null) @if(!Str::startsWith($product->{'2D_mockup'}, 'http')) style="display:none" @endif @endif @endif name="2D_mockup_template" onchange="buttonEnableFunc('2D_mockup_template')" class="file-select">
                                                        <label for="2D_mockup_template" style="margin-bottom: 0rem; color: black; background-color: #efefef; padding: .1rem .5rem; border-radius: .5rem; cursor: pointer; @if($isExist == 1 ) @if($product->{'2D_mockup'} == null || Str::startsWith($product->{'2D_mockup'}, 'http')) display:none; @endif @endif">@if($isExist == 1 ) {{ basename($product->{'2D_mockup'}) }} @endif</label>
                                                    </td>
                                                    <td class="text-center">
                                                        @can('upload_2D_Mockup_Template')
                                                            <button disabled class="uploadStyles" type="button" title="Upload"  onclick="uploadImages('2D_mockup_template', '2D_mockup', '2D Mockup Template' , '2D_mockup')" id="2D_mockup_template_uploading" style="border-right: 2px solid #b3b3b3" disabled>
                                                                <i class="fa fa-cloud-upload" id="2D_mockup_template_upload"></i><i class="fas fa-spinner fa-spin" id="2D_mockup_template_loading" style="display: none"></i>
                                                            </button>
                                                        @else
                                                            <button class="uploadStyles" type="button" title="Upload" onclick="showPermissionError(`You do not have permission to upload 2D Mockup Templates.`)" id="2D_mockup_template_uploading" style="border-right: 2px solid #b3b3b3" disabled>
                                                                <i class="fa fa-cloud-upload" id="2D_mockup_template_upload"></i>
                                                                <i class="fas fa-spinner fa-spin" id="2D_mockup_template_loading" style="display: none"></i>
                                                            </button>
                                                        @endcan
                                                        <button type="button" id="2D_mockup_template_downloading" title="Download" class="downloadStyles" @if($isExist == 1) @if($product->{'2D_mockup'} == null) disabled @else onclick="window.location.href = '{{ asset('assets') }}{{ $product->{'2D_mockup'} }}'" @endif @endif @if($isExist == 0) disabled @endif>
                                                            <i class="fa fa-cloud-download"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endcan
                                            @can('view_3D_Mockup_Template')
                                                <tr>
                                                    <td>3D Mockup Template</td>
                                                    <td><input type="file" id="3D_mockup_template" @if($isExist == 1) @if ($product->{'3D_mockup'} != null) @if(!Str::startsWith($product->{'3D_mockup'}, 'http')) style="display:none" @endif @endif @endif name="3D_mockup_template" onchange="buttonEnableFunc('3D_mockup_template')" class="file-select">
                                                        <label for="3D_mockup_template" style="margin-bottom: 0rem; color: black; background-color: #efefef; padding: .1rem .5rem; border-radius: .5rem; cursor: pointer; @if($isExist == 1 ) @if($product->{'3D_mockup'} == null || Str::startsWith($product->{'3D_mockup'}, 'http')) display:none; @endif @endif">@if($isExist == 1 ) {{ basename($product->{'3D_mockup'}) }} @endif</label>
                                                    </td>
                                                    <td class="text-center">
                                                        @can('upload_3D_Mockup_Template')
                                                            <button disabled class="uploadStyles" type="button" title="Upload" onclick="uploadImages('3D_mockup_template', '3D_mockup', '3D Mockup Template', '3D_mockup')" id="3D_mockup_template_uploading" style="border-right: 2px solid #b3b3b3">
                                                                <i class="fa fa-cloud-upload" id="3D_mockup_template_upload"></i>
                                                                <i class="fas fa-spinner fa-spin" id="3D_mockup_template_loading" style="display: none"></i>
                                                            </button>
                                                        @else
                                                            <button class="uploadStyles" type="button" title="Upload" onclick="showPermissionError(`You do not have permission to upload 3D Mockup Templates.`)" id="3D_mockup_template_uploading" style="border-right: 2px solid #b3b3b3" disabled>
                                                                <i class="fa fa-cloud-upload" id="3D_mockup_template_upload"></i>
                                                                <i class="fas fa-spinner fa-spin" id="3D_mockup_template_loading" style="display: none"></i>
                                                            </button>
                                                        @endcan
                                                        <button type="button" id="3D_mockup_template_downloading" title="Download" class="downloadStyles" @if($isExist == 1) @if($product->{'3D_mockup'} == null) disabled @else onclick="window.location.href = '{{ asset('assets') }}{{ $product->{'3D_mockup'} }}'" @endif @endif @if($isExist == 0) disabled @endif>
                                                            <i class="fa fa-cloud-download"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endcan
                                            @can('view_Design_Tech_Pack')
                                                <tr>
                                                    <td>Design Tech Pack</td>
                                                    <td><input type="file" id="design_tech_pack" @if($isExist == 1) @if ($product->tech_pack != null) @if(!Str::startsWith($product->tech_pack, 'http')) style="display:none" @endif @endif @endif name="design_tech_pack" onchange="buttonEnableFunc('design_tech_pack')" class="file-select">
                                                        <label for="design_tech_pack" style="margin-bottom: 0rem; color: black; background-color: #efefef; padding: .1rem .5rem; border-radius: .5rem; cursor: pointer; @if($isExist == 1 ) @if($product->tech_pack == null || Str::startsWith($product->tech_pack, 'http')) display:none; @endif @endif">@if($isExist == 1 ) {{ basename($product->tech_pack) }} @endif</label>
                                                    </td>
                                                    <td class="text-center">
                                                        @can('upload_Design_Tech_Pack')
                                                            <button disabled class="uploadStyles" type="button" title="Upload" onclick="uploadImages('design_tech_pack', 'tech_pack', 'Design Tech Pack', 'tech_pack')" id="design_tech_pack_uploading" style="border-right: 2px solid #b3b3b3">
                                                                <i class="fa fa-cloud-upload" id="design_tech_pack_upload"></i>
                                                                <i class="fas fa-spinner fa-spin" id="design_tech_pack_loading" style="display: none"></i>
                                                            </button>
                                                        @else
                                                            <button class="uploadStyles" type="button" title="Upload" onclick="showPermissionError('You do not have permission to upload Design Tech Packs.')" id="design_tech_pack_uploading" style="border-right: 2px solid #b3b3b3" disabled>
                                                                <i class="fa fa-cloud-upload" id="design_tech_pack_upload"></i>
                                                                <i class="fas fa-spinner fa-spin" id="design_tech_pack_loading" style="display: none"></i>
                                                            </button>
                                                        @endcan
                                                        <button type="button" id="design_tech_pack_downloading" title="Download" class="downloadStyles" @if($isExist == 1) @if($product->tech_pack == null) disabled @else onclick="window.location.href = '{{ asset('assets') }}{{$product->tech_pack}}'" @endif @endif @if($isExist == 0) disabled @endif>
                                                            <i class="fa fa-cloud-download"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endcan
                                            @can('view_Measurement_Chart')
                                                <tr>
                                                    <td>Measurement Chart</td>
                                                    <td><input type="file" id="measurement_chart" @if($isExist == 1) @if ($product->measurement != null) @if(!Str::startsWith($product->measurement, 'http')) style="display:none" @endif @endif @endif name="measurement_chart" onchange="buttonEnableFunc('measurement_chart')" class="file-select">
                                                        <label for="measurement_chart" style="margin-bottom: 0rem; color: black; background-color: #efefef; padding: .1rem .5rem; border-radius: .5rem; cursor: pointer; @if($isExist == 1 ) @if($product->measurement == null || Str::startsWith($product->measurement, 'http')) display:none; @endif @endif">@if($isExist == 1 ) {{ basename($product->measurement) }} @endif</label>
                                                    </td>
                                                    <td class="text-center">
                                                        @can('upload_Measurement_Chart')
                                                            <button disabled class="uploadStyles" type="button" title="Upload" onclick="uploadImages('measurement_chart', 'measurement', 'Measurement Chart', 'measurement')" id="measurement_chart_uploading" style="border-right: 2px solid #b3b3b3">
                                                                <i class="fa fa-cloud-upload" id="measurement_chart_upload"></i>
                                                                <i class="fas fa-spinner fa-spin" id="measurement_chart_loading" style="display: none"></i>
                                                            </button>
                                                        @else
                                                            <button class="uploadStyles" type="button" title="Upload" onclick="showPermissionError('You do not have permission to upload Measurement Charts.')" id="measurement_chart_uploading" style="border-right: 2px solid #b3b3b3" disabled>
                                                                <i class="fa fa-cloud-upload" id="measurement_chart_upload"></i>
                                                                <i class="fas fa-spinner fa-spin" id="measurement_chart_loading" style="display: none"></i>
                                                            </button>
                                                        @endcan
                                                        <button type="button" id="measurement_chart_downloading" title="Download" class="downloadStyles" @if($isExist == 1) @if($product->measurement == null) disabled @else onclick="window.location.href = '{{ asset('assets') }}{{$product->measurement}}'" @endif @endif @if($isExist == 0) disabled @endif>
                                                            <i class="fa fa-cloud-download"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endcan
                                            @can('view_Production_Layout')
                                                <tr>
                                                    <td>Production Layout</td>
                                                    <td><input type="file" id="production_layouts" @if($isExist == 1) @if ($product->product_layout != null) @if(!Str::startsWith($product->product_layout, 'http')) style="display:none" @endif @endif @endif name="production_layouts" onchange="buttonEnableFunc('production_layouts')" class="file-select">
                                                        <label for="production_layouts" style="margin-bottom: 0rem; color: black; background-color: #efefef; padding: .1rem .5rem; border-radius: .5rem; cursor: pointer; @if($isExist == 1 ) @if($product->product_layout == null || Str::startsWith($product->product_layout, 'http')) display:none; @endif @endif">@if($isExist == 1 ) {{ basename($product->product_layout) }} @endif</label>
                                                    </td>
                                                    <td class="text-center">
                                                        @can('upload_Production_Layout')
                                                            <button disabled class="uploadStyles" type="button" title="Upload" onclick="uploadImages('production_layouts', 'product_layout', 'Production Layout', 'product_layout')" id="production_layouts_uploading" style="border-right: 2px solid #b3b3b3">
                                                                <i class="fa fa-cloud-upload" id="production_layouts_upload"></i>
                                                                <i class="fas fa-spinner fa-spin" id="production_layouts_loading" style="display: none"></i>
                                                                <div class="loading-icon"></div>
                                                            </button>
                                                        @else
                                                            <button class="uploadStyles" type="button" title="Upload" onclick="showPermissionError('You do not have permission to upload Production Layouts.')" id="production_layouts_uploading" style="border-right: 2px solid #b3b3b3" disabled>
                                                                <i class="fa fa-cloud-upload" id="production_layouts_upload"></i>
                                                                <i class="fas fa-spinner fa-spin" id="production_layouts_loading" style="display: none"></i>
                                                                <div class="loading-icon"></div>
                                                            </button>
                                                        @endcan
                                                        <button type="button" id="production_layouts_downloading" title="Download" class="downloadStyles" @if($isExist == 1) @if($product->product_layout == null) disabled @else onclick="window.location.href = '{{ asset('assets') }}{{$product->product_layout}}'" @endif @endif @if($isExist == 0) disabled @endif>
                                                            <i class="fa fa-cloud-download"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endcan
                                            @can('view_Technical_Tech_Pack')
                                                <tr>
                                                    <td>Technical Tech Pack</td>
                                                    <td><input type="file" id="technical_tech_pack" @if($isExist == 1) @if ($product->technical_tech_pack != null) @if(!Str::startsWith($product->technical_tech_pack , 'http')) style="display:none" @endif @endif @endif name="technical_tech_pack" onchange="buttonEnableFunc('technical_tech_pack')" class="file-select">
                                                        <label for="technical_tech_pack" style="margin-bottom: 0rem; color: black; background-color: #efefef; padding: .1rem .5rem; border-radius: .5rem; cursor: pointer; @if($isExist == 1 ) @if($product->technical_tech_pack == null || Str::startsWith($product->technical_tech_pack, 'http')) display:none; @endif @endif">@if($isExist == 1 ) {{ basename($product->technical_tech_pack) }} @endif</label>
                                                    </td>
                                                    <td class="text-center">
                                                        @can('upload_Technical_Tech_Pack')
                                                            <button disabled class="uploadStyles" type="button" title="Upload" onclick="uploadImages('technical_tech_pack', 'technical_tech_pack', 'Technical Tech Pack', 'technical_tech_pack')" id="technical_tech_pack_uploading" style="border-right: 2px solid #b3b3b3">
                                                                <i class="fa fa-cloud-upload" id="technical_tech_pack_upload"></i>
                                                                <i class="fas fa-spinner fa-spin" id="technical_tech_pack_loading" style="display: none"></i>
                                                                <div class="loading-icon"></div>
                                                            </button>
                                                        @else
                                                            <button class="uploadStyles" type="button" title="Upload" onclick="showPermissionError('You do not have permission to upload Technical Tech Packs.')" id="technical_tech_pack_uploading" style="border-right: 2px solid #b3b3b3" disabled>
                                                                <i class="fa fa-cloud-upload" id="technical_tech_pack_upload"></i>
                                                                <i class="fas fa-spinner fa-spin" id="technical_tech_pack_loading" style="display: none"></i>
                                                                <div class="loading-icon"></div>
                                                            </button>
                                                        @endcan
                                                        <button type="button" id="technical_tech_pack_downloading" title="Download" class="downloadStyles" @if($isExist == 1) @if($product->technical_tech_pack == null) disabled @else onclick="window.location.href = '{{ asset('assets') }}{{$product->technical_tech_pack}}'" @endif @endif @if($isExist == 0) disabled @endif>
                                                            <i class="fa fa-cloud-download"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endcan
                                            @can('view_Pattern_Files')
                                                <tr>
                                                    <td>Pattern Files</td>
                                                    <td><input type="file" id="pattern_file" @if($isExist == 1) @if ($product->pattern != null) @if(!Str::startsWith($product->pattern, 'http')) style="display:none" @endif @endif @endif name="pattern_file" onchange="buttonEnableFunc('pattern_file')" class="file-select">
                                                        <label for="pattern_file" style="margin-bottom: 0rem; color: black; background-color: #efefef; padding: .1rem .5rem; border-radius: .5rem; cursor: pointer; @if($isExist == 1 ) @if($product->pattern == null || Str::startsWith($product->pattern, 'http')) display:none; @endif @endif">@if($isExist == 1 ) {{ basename($product->pattern) }} @endif</label>
                                                    </td>
                                                    <td class="text-center">
                                                        @can('upload_Pattern_Files')
                                                            <button disabled class="uploadStyles" type="button" title="Upload" onclick="uploadImages('pattern_file', 'pattern_file', 'Pattern File', 'pattern')" id="pattern_file_uploading" style="border-right: 2px solid #b3b3b3">
                                                                <i class="fa fa-cloud-upload" id="pattern_file_upload"></i>
                                                                <i class="fas fa-spinner fa-spin" id="pattern_file_loading" style="display: none"></i>
                                                                <div class="loading-icon"></div>
                                                            </button>
                                                        @else
                                                            <button class="uploadStyles" type="button" title="Upload" onclick="showPermissionError('You do not have permission to upload Pattern Files.')" id="pattern_file_uploading" style="border-right: 2px solid #b3b3b3" disabled>
                                                                <i class="fa fa-cloud-upload" id="pattern_file_upload"></i>
                                                                <i class="fas fa-spinner fa-spin" id="pattern_file_loading" style="display: none"></i>
                                                                <div class="loading-icon"></div>
                                                            </button>
                                                        @endcan
                                                        <button type="button" id="pattern_file_downloading" title="Download" class="downloadStyles" @if($isExist == 1) @if($product->pattern == null) disabled @else onclick="window.location.href = '{{ asset('assets') }}{{$product->pattern}}'" @endif @endif @if($isExist == 0) disabled @endif>
                                                            <i class="fa fa-cloud-download"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endcan
                                            @can('view_size_chart')
                                                <tr>
                                                    <td>Size Chart</td>
                                                    <td><input type="file" id="size_chart" @if($isExist == 1) @if ($product->size_chart != null) @if(!Str::startsWith($product->size_chart, 'http')) style="display:none" @endif @endif @endif name="size_chart" onchange="buttonEnableFunc('size_chart')" class="file-select">
                                                        <label for="size_chart" style="margin-bottom: 0rem; color: black; background-color: #efefef; padding: .1rem .5rem; border-radius: .5rem; cursor: pointer; @if($isExist == 1 ) @if($product->size_chart == null || Str::startsWith($product->size_chart, 'http')) display:none; @endif @endif">@if($isExist == 1 ) {{ basename($product->size_chart) }} @endif</label>
                                                    </td>
                                                    <td class="text-center">
                                                        @can('upload_size_chart')
                                                            <button disabled class="uploadStyles" type="button" title="Upload" onclick="uploadImages('size_chart', 'size_chart', 'Size Chart', 'size_chart')" id="size_chart_uploading" style="border-right: 2px solid #b3b3b3">
                                                                <i class="fa fa-cloud-upload" id="size_chart_upload"></i>
                                                                <i class="fas fa-spinner fa-spin" id="size_chart_loading" style="display: none"></i>
                                                                <div class="loading-icon"></div>
                                                            </button>
                                                        @else
                                                            <button class="uploadStyles" type="button" title="Upload" onclick="showPermissionError('You do not have permission to upload size chart.')" id="size_chart_uploading" style="border-right: 2px solid #b3b3b3" disabled>
                                                                <i class="fa fa-cloud-upload" id="size_chart_upload"></i>
                                                                <i class="fas fa-spinner fa-spin" id="size_chart_loading" style="display: none"></i>
                                                                <div class="loading-icon"></div>
                                                            </button>
                                                        @endcan
                                                        @can('view_size_chart')
                                                            <button type="button" id="size_chart_downloading" title="Download" class="downloadStyles" @if($isExist == 1) @if($product->size_chart == null) disabled @else onclick="window.location.href = '{{ asset('assets') }}{{$product->size_chart}}'" @endif @endif @if($isExist == 0) disabled @endif>
                                                                <i class="fa fa-cloud-download"></i>
                                                            </button>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endcan
                                            @php
                                                $hasPermission = Gate::none(['view_2D_Mockup_Template', 'view_3D_Mockup_Template', 'view_Design_Tech_Pack', 'view_Measurement_Chart', 'view_Production_Layout', 'view_Technical_Tech_Pack', 'view_Pattern_Files', 'view_size_chart']);
                                            @endphp

                                            @if($hasPermission)
                                                <tr>
                                                    <td colspan="2" style="text-align: center; color: red;">
                                                        You do not have permissions to view any templates or files. Please contact the administrator if you need access.
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endcan

                    <div class="card-new mt-3 col-md-6" style="margin-left: 10px; max-width: 47%;">
                        <div class="row">
                            <div class="col-md-12 header-style">
                                Pricing Info
                            </div>
                            <div class="col-md-12 mt-3 mb-2">
                                <table class="subProductTable">
                                    <thead style="background-color: grey;color: white;height: 25px;font-size: .7rem;">
                                        <th style="color: white">USER TYPE</th>
                                        <th style="color: white">PRICE</th>
                                    </thead>
                                    <tr>
                                        <td>
                                            Genaral
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-input" @if($isExist == 1)
                                            @foreach ($prices as $price)
                                            @if($price->price_type == 1)
                                             value="{{$price->price}}"
                                            @endif
                                            @endforeach
                                            @endif id="new_default_price" style="border: none;" name="new_default_price"  pattern="\d+(\.\d{0,2})?" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @foreach ($priceTypes as $priceType)
                                                @if ($priceType->id == 2)
                                                    {{ $priceType->type_name }}
                                                    <input type="hidden" value="{{ $priceType->id }}" name="price_type_2">
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <input type="text" @if($isExist == 1)
                                            @foreach ($prices as $price)
                                            @if($price->price_type == 2)
                                             value="{{$price->price}}"
                                            @endif
                                            @endforeach
                                            @endif class="form-control form-input" style="border: none;" id="new_default_price2" name="new_default_price2" pattern="\d+(\.\d{0,2})?">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @foreach ($priceTypes as $priceType)
                                                @if ($priceType->id == 3)
                                                    {{ $priceType->type_name }}
                                                    <input type="hidden" value="{{ $priceType->id }}" name="price_type_3">
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <input type="text" @if($isExist == 1)
                                            @foreach ($prices as $price)
                                            @if($price->price_type == 3)
                                             value="{{$price->price}}"
                                            @endif
                                            @endforeach
                                            @endif class="form-control form-input" style="border: none;" id="new_default_price3" name="new_default_price3"  pattern="\d+(\.\d{0,2})?" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @foreach ($priceTypes as $priceType)
                                                @if ($priceType->id == 4)
                                                    {{ $priceType->type_name }}
                                                    <input type="hidden" value="{{ $priceType->id }}" name="price_type_4">
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <input type="text" @if($isExist == 1)
                                            @foreach ($prices as $price)
                                            @if($price->price_type == 4)
                                             value="{{$price->price}}"
                                            @endif
                                            @endforeach
                                            @endif class="form-control form-input" style="border: none;" id="new_default_price4" name="new_default_price4"  pattern="\d+(\.\d{0,2})?" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @foreach ($priceTypes as $priceType)
                                                @if ($priceType->id == 5)
                                                    {{ $priceType->type_name }}
                                                    <input type="hidden" value="{{ $priceType->id }}" name="price_type_5">
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <input type="text" @if($isExist == 1)
                                            @foreach ($prices as $price)
                                            @if($price->price_type == 5)
                                             value="{{$price->price}}"
                                            @endif
                                            @endforeach
                                            @endif class="form-control form-input" style="border: none;" id="new_default_price5" name="new_default_price5"  pattern="\d+(\.\d{0,2})?" >
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-12" style="padding: .5rem">
                <div class="card-new">
                    <div class="row">
                        <div class="col-md-12 header-style">
                            Product Description
                        </div>
                        <div class="col-md-12 mt-3 mb-1">
                            <div id="editor-description" style="height: 300px;">@if($isExist == 1) {!! $product->description !!} @endif</div>
                            <input type="hidden" id="new_description" @if($isExist == 1) value="{{$product->description}}" @endif name="new_description">
                        </div>
                        <div class="col-md-12 header-style mt-3">
                            Who We Made This For
                        </div>
                        <div class="col-md-12 mt-3 mb-1">
                            <div id="editor-who-we-made-this-for" style="height: 100px;">@if($isExist == 1) {!! $product->who_we_made_this_for !!} @endif</div>
                            <input type="hidden" id="who_we_made_this_for" @if($isExist == 1) value="{{$product->who_we_made_this_for}}" @endif name="who_we_made_this_for">
                        </div>
                        <div class="col-md-12 header-style mt-3">
                            Product Features
                        </div>
                        <div class="col-md-12 mt-3 mb-1">
                            <div id="editor-product-features" style="height: 100px;">@if($isExist == 1) {!! $product->product_features !!} @endif</div>
                            <input type="hidden" id="product_features" @if($isExist == 1) value="{{$product->product_features}}" @endif name="product_features">
                        </div>
                    </div>
                    <div class="col-md-12 mt-3 mb-3 text-right">
                        @if (Gate::check('edit products') || Gate::check('edit product description'))
                            <button type="submit" class="btn btn-success custom_btn">@if($isExist == 1) UPDATE @else SAVE @endif</button>
                        @endif
                        @if (Gate::check('delete products'))
                            <button type="button" class="btn btn-danger custom_btn" @if($isExist == 1) onclick="deleteProduct({{$product->id}})" @endif>DELETE</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

    </div>

</div>
<!-- Modal -->
<div class="modal fade" id="image_view_modal" tabindex="-1" role="dialog" aria-labelledby="image_view_modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="image_to_display" src="" alt="Image" style="margin: .5rem; width: 97%;">
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageCaptionModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="max-width: 80%;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Add Caption</h2>
                <button type="button" class="close" onclick="closeModal()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <img id="modalImage" src="" alt="Product Image" style="width: 92%; padding-left: 8%;">
                        <input type="hidden" id="product_id" name="product_id" value="">
                        <input type="hidden" id="image_caption_type" name="image_caption_type" value="">
                    </div>
                    <div class="col-md-6">
                        <div>
                            <strong>Image Caption</strong>
                        </div>
                        <div>
                            <span style="color: gray;">Maximum 250 characters</span>
                        </div>
                        <div style="padding-top: 10px;">
                            <textarea class="form-control form-input" id="new_caption" name="new_caption" rows="8"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="deleteCaption()">Delete</button>
                <button type="button" class="btn btn-success" onclick="saveCaption()">Save Caption</button>
            </div>
        </div>
    </div>
</div>


<!-- Image Modal -->
<div id="imageCaptionModal2" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="max-width: 80%;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Add Caption</h2>
                <button type="button" class="close" onclick="closeImageModal()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <img id="otherImage" src="" alt="Product Image" style="width: 92%; padding-left: 8%;">
                        <input type="hidden" id="image_product_id" name="image_product_id" value="">
                        <input type="hidden" id="image_caption_id" name="image_caption_id" value="">
                    </div>
                    <div class="col-md-6">
                        <div>
                            <strong>Image Caption</strong>
                        </div>
                        <div>
                            <span style="color: gray;">Maximum 250 characters</span>
                        </div>
                        <div style="padding-top: 10px;">
                            <textarea class="form-control form-input" id="new_image_caption" name="new_image_caption" rows="8"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeImageModal()">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="deleteImageCaption()">Delete</button>
                <button type="button" class="btn btn-success" onclick="saveImageCaption()">Save Caption</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#image_view_modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var imgSrc = button.data('img-src'); // Extract info from data-* attributes
            var modal = $(this);
            modal.find('#image_to_display').attr('src', imgSrc); // Update the modal's image source
        });
    });

    function showPermissionError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Permission Denied',
            text: message,
            confirmButtonText: 'OK'
        });
    }

    function openModal(imageSrc, productId, imageCaptionType) {
        document.getElementById('modalImage').src = imageSrc;

        document.getElementById('product_id').value = productId;
        document.getElementById('image_caption_type').value = imageCaptionType;

        $.ajax({
            url: "{{ route('getImageCaption') }}",
            method: "GET",
            data: {
                productId: productId,
                imageCaptionType: imageCaptionType
            },
            success: function(response) {
                console.log(response);
                document.getElementById('new_caption').value = response.productImageCaption || '';

                $('#imageCaptionModal').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
                alert("Failed to load caption data. Please try again.");
            }
        });
    }

    function saveCaption() {
        const caption = document.getElementById('new_caption').value;
        const productId = document.getElementById('product_id').value;
        const imageType = document.getElementById('image_caption_type').value;

        if (caption.length > 250) {
            alert("Caption exceeds the maximum length of 250 characters.");
            return;
        }

        $.ajax({
            url: "{{ route('saveProductImageCaption') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                productId: productId,
                imageType: imageType,
                caption: caption
            },
            success: function(response) {
                alert("Caption saved successfully!");
                closeModal();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
            }
        });
    }

    function deleteCaption() {
        const productId = document.getElementById('product_id').value;
        const imageType = document.getElementById('image_caption_type').value;

        $.ajax({
            url: "{{ route('deleteProductImageCaption') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                productId: productId,
                imageType: imageType
            },
            success: function(response) {
                alert("Caption deleted successfully!");
                document.getElementById('new_caption').value = ''; // Clear the textarea
                closeModal();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
            }
        });
    }


    function openImageModal(imageSrc, productId, imageId) {
        document.getElementById('otherImage').src = imageSrc;

        document.getElementById('image_product_id').value = productId;
        document.getElementById('image_caption_id').value = imageId;

        $.ajax({
            url: "{{ route('getOtherImageCaption') }}",
            method: "GET",
            data: {
                productId: productId,
                imageId: imageId
            },
            success: function(response) {
                console.log(response);
                document.getElementById('new_image_caption').value = response.productImageCaption || '';

                $('#imageCaptionModal2').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
                alert("Failed to load caption data. Please try again.");
            }
        });
    }


    function saveImageCaption() {
        const caption = document.getElementById('new_image_caption').value;
        const productId = document.getElementById('image_product_id').value;
        const imageID = document.getElementById('image_caption_id').value;

        if (caption.length > 250) {
            alert("Caption exceeds the maximum length of 250 characters.");
            return;
        }

        $.ajax({
            url: "{{ route('saveOtherImageCaption') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                productId: productId,
                imageID: imageID,
                caption: caption
            },
            success: function(response) {
                alert("Caption saved successfully!");
                closeImageModal();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
            }
        });
    }

    function deleteImageCaption() {
        const productId = document.getElementById('image_product_id').value;
        const imageID = document.getElementById('image_caption_id').value;

        $.ajax({
            url: "{{ route('deleteOtherImageCaption') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                productId: productId,
                imageID: imageID
            },
            success: function(response) {
                alert("Caption deleted successfully!");
                document.getElementById('new_image_caption').value = ''; // Clear the textarea
                closeImageModal();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
            }
        });
    }

    function closeModal() {
        $('#imageCaptionModal').modal('hide');
    }

    function closeImageModal() {
        $('#imageCaptionModal2').modal('hide');
    }

</script>


<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    $(document).ready( function () {
        $("#new_main_category_id").select2();
        $("#new_gender").select2();
        $("#new_size_id").select2();
        $("#new_product_category_id").select2();
        $("#embellishment_options").select2();
        $("#new_sport").select2();
        $("#new_product_attribute_id").select2();
        $("#attribute_on_price").select2();
        $("#new_product_factory_id").select2();
        $("#product_tagline_id").select2();
        $("#product_fit_id").select2();
    });

    $(document).ready(function () {
        var quillDescription = new Quill('#editor-description', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'], // Text styles
                    [{ 'color': [] }], // Font color
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }], // Lists
                    [{ 'size': ['small', false, 'large', 'huge'] }], // Font size
                    [{ 'align': [] }], // Alignment options
                    ['link'],
                    ['clean'] // Remove formatting
                ]
            }
        });

        var quillWhoWeMadeThisFor = new Quill('#editor-who-we-made-this-for', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    [{ 'align': [] }],
                    ['link'],
                    ['clean']
                ]
            }
        });

        var quillProductFeatures = new Quill('#editor-product-features', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    [{ 'align': [] }],
                    ['link'],
                    ['clean']
                ]
            }
        });

        quillDescription.on('text-change', function() {
            var htmlContent = document.querySelector('#editor-description .ql-editor').innerHTML.replace(/<div>/g, '').replace(/<\/div>/g, '<br>');
            document.getElementById('new_description').value = htmlContent;
        });

        quillWhoWeMadeThisFor.on('text-change', function() {
            var htmlContent = document.querySelector('#editor-who-we-made-this-for .ql-editor').innerHTML.replace(/<div>/g, '').replace(/<\/div>/g, '<br>');
            document.getElementById('who_we_made_this_for').value = htmlContent;
        });

        quillProductFeatures.on('text-change', function() {
            var htmlContent = document.querySelector('#editor-product-features .ql-editor').innerHTML.replace(/<div>/g, '').replace(/<\/div>/g, '<br>');
            document.getElementById('product_features').value = htmlContent;
        });

        document.getElementById('clear-formatting').addEventListener('click', function() {
            quillDescription.format('bold', false);
            quillDescription.format('italic', false);
            quillDescription.format('underline', false);
            quillDescription.format('strike', false);
            quillDescription.format('color', false);
            quillDescription.format('size', false);

            quillWhoWeMadeThisFor.format('bold', false);
            quillWhoWeMadeThisFor.format('italic', false);
            quillWhoWeMadeThisFor.format('underline', false);
            quillWhoWeMadeThisFor.format('strike', false);
            quillWhoWeMadeThisFor.format('color', false);
            quillWhoWeMadeThisFor.format('size', false);

            quillProductFeatures.format('bold', false);
            quillProductFeatures.format('italic', false);
            quillProductFeatures.format('underline', false);
            quillProductFeatures.format('strike', false);
            quillProductFeatures.format('color', false);
            quillProductFeatures.format('size', false);
        });
    });

    function imageDisplay(fileInput , displayArea){
        const imagePreview = document.getElementById(displayArea + '_uploaded');
        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.src = e.target.result;
            };

            reader.readAsDataURL(fileInput.files[0]);

            $('#'+displayArea+'_upload_area').hide();
            $('#'+displayArea+'_display_area').show();
            $('.functionalities_'+displayArea).show();
        }
    }
    function removeImagePreview(img){
        $('#'+img+'_display_area').hide();
        $('.functionalities_'+img).hide();
        $('#'+img+'_upload_area').show();
    }

    function previewImg(imageToDisplay){

        const imagePreview = document.getElementById(imageToDisplay+'_uploaded');
        const imagePreviewArea = document.getElementById('imagePreviewArea');

        const src = imagePreview.getAttribute('src');

        imagePreviewArea.setAttribute('src', src);
    }

    document.addEventListener("change", function (event) {
        if (event.target && event.target.type === "file") {

            var existence = $('#existence');
            console.log('clicked');
        }
    });

//     function uploadMultipleImages(imageID, ID) {
//     $('#uploaded_' + imageID + '_table').show();
//     var fileID = document.getElementById(imageID);
//     var files = fileID.files;

//     if (ID === null) {
//         // Clear any existing rows
//         document.getElementById(imageID + "_tbody").innerHTML = "";

//         // Loop through all selected files to display and queue them for upload
//         for (let i = 0; i < files.length; i++) {
//             // Create a new row for each file with unique IDs for each preview and upload button
//             let newRowHTML = `
//                 <tr>
//                     <td>${files[i].name}</td>
//                     <td class="text-center">
//                         <button class="uploadStyles" data-toggle="modal" data-target="#image_view_modal" id="imagePreview${imageID}_${i}" data-img-src="" type="button" title="View">
//                             <i class="fa fa-eye" style="color: grey;"></i>
//                         </button>
//                         <button onclick="uploadMultipleImages('${imageID}', ${i})" class="uploadStyles" type="button" title="Upload">
//                             <i class="fa fa-cloud-upload" id="${imageID}_upload_${i}"></i>
//                             <i class="fas fa-spinner fa-spin" id="${imageID}_loading_${i}" style="display: none"></i>
//                         </button>
//                     </td>
//                 </tr>
//             `;
//             document.getElementById(imageID + "_tbody").innerHTML += newRowHTML;

//             // Immediately initiate the upload for each file by calling uploadImagesMultiple with each file and its index
//             uploadImagesMultiple(files[i], getFolderName(imageID), getFileCategory(imageID), 'image_link', i, imageID);
//         }
//     } else {
//         // In case the upload is triggered by a specific ID, we only upload that specific image.
//         uploadImagesMultiple(files[ID], getFolderName(imageID), getFileCategory(imageID), 'image_link', ID, imageID);
//     }

//     // Generate previews for each image using FileReader
//     for (let i = 0; i < files.length; i++) {
//         let reader = new FileReader();
//         reader.onload = (function(fileIndex) {
//             return function(e) {
//                 let imageContainer = document.getElementById('imagePreview' + imageID + '_' + fileIndex);
//                 imageContainer.setAttribute('data-img-src', e.target.result);
//             };
//         })(i);
//         reader.readAsDataURL(files[i]);
//     }
// }

// // Helper functions to determine folder name and file category based on imageID
// function getFolderName(imageID) {
//     switch (imageID) {
//         case 'lifestyle_images':
//             return 'Life_Style_Image';
//         case 'close_up_images':
//             return 'Close_Up_Image';
//         case 'branding_images':
//             return 'Branding_Image';
//         case 'studio_images':
//             return 'Studio_Image';
//         default:
//             return '3D_Image';
//     }
// }

// function getFileCategory(imageID) {
//     switch (imageID) {
//         case 'lifestyle_images':
//             return 'lifeStyle Images File';
//         case 'close_up_images':
//             return 'closeUp Images File';
//         case 'branding_images':
//             return 'branding Images File';
//         case 'studio_images':
//             return 'Studio Images File';
//         default:
//             return '3D Images File';
//     }
// }


//     function uploadImages(uploaded_image_id, folder_name, fileCategory, db_coloumn_name) {

//         const fileInput = document.getElementById(uploaded_image_id);
//         const file = fileInput.files[0];

//         if (!file) {
//             Swal.fire({
//                 type: "error",
//                 title: "No file selected.",
//             });
//             return;
//         }

//         validateImage(file, 1, 472, 590, function (isValid, message) {
//             if (!isValid) {
//                 Swal.fire({
//                     type: "error",
//                     title: message,
//                 });
//                 return;
//             }
//             var fileCat =fileCategory;
//             var folder =folder_name;
//             var dbField =db_coloumn_name;
//             var productNo =$('#new_product_no').val();
//             var product_id =$('#product_id').val();

//             var formData = new FormData();
//             formData.append('file_category', fileCat);
//             formData.append('folder', folder);
//             formData.append('product_no', productNo);

//             if(folder_name == 'Life_Style_Image' || folder_name == '3D_Image' || folder_name == 'Close_Up_Image' || folder_name == 'Branding_Image' || folder_name == 'Studio_Image'){
//                 var files = uploaded_image_id;

//                 formData.append('image_uploaded', files);
//                 formData.append('product_id', product_id);
//                 formData.append('db_image_field', dbField);
//                 formData.append('_token', '{{ csrf_token() }}');


//             }else{
//                 var files = $('#'+uploaded_image_id)[0].files[0];

//                 formData.append('image_uploaded',files);
//                 formData.append('db_field',dbField);
//                 formData.append('_token','{{ csrf_token() }}');
//             }


//             $.ajax({
//                 url:"{{ route('products.upload_image') }}",
//                 method:'POST',
//                 dataType:'json',
//                 data:formData,
//                 contentType: false,
//                 processData: false,
//                 beforeSend:function(){
//                     $('#'+uploaded_image_id+'_upload').hide();
//                     $('#'+uploaded_image_id+'_loading').show();
//                     },
//                 success:function(data){

//                     $('#'+uploaded_image_id+'_upload').show();
//                     $('#'+uploaded_image_id+'_loading').hide();

//                     Swal.fire({
//                         type: data.responce,
//                         title: data.meessage,
//                     });

//                 },
//             });
//         });

//     }
//     function uploadImagesMultiple(uploaded_image_id, folder_name, fileCategory, db_coloumn_name, num , idName) {

//         const file = uploaded_image_id;

//         validateImage(file, 1, 472, 590, function (isValid, message) {
//             if (!isValid) {
//                 Swal.fire({
//                     type: "error",
//                     title: message,
//                 });
//                 return;
//             }

//             var fileCat =fileCategory;
//             var folder =folder_name;
//             var dbField =db_coloumn_name;
//             var productNo =$('#new_product_no').val();
//             var product_id =$('#product_id').val();

//             var formData = new FormData();
//             formData.append('file_category', fileCat);
//             formData.append('folder', folder);
//             formData.append('product_no', productNo);

//             var files = uploaded_image_id;

//             formData.append('image_uploaded', files);
//             formData.append('product_id', product_id);
//             formData.append('db_image_field', dbField);
//             formData.append('_token', '{{ csrf_token() }}');


//             $.ajax({
//                 url:"{{ route('products.upload_image') }}",
//                 method:'POST',
//                 dataType:'json',
//                 data:formData,
//                 contentType: false,
//                 processData: false,
//                 beforeSend:function(){
//                     $('#'+idName+'_upload_'+num).hide();
//                     $('#'+idName+'_loading_'+num).show();
//                     },
//                 success:function(data){

//                     $('#'+idName+'_upload_'+num).show();
//                     $('#'+idName+'_loading_'+num).hide();

//                     Swal.fire({
//                         type: data.responce,
//                         title: data.meessage,
//                     });
//                     location.reload();

//                 },
//             });
//         });

//     }

function uploadImage(file, folderName, fileCategory, dbField, onSuccess, onError) {
    const fileDimensions = folderName === 'Life_Style_Image' || folderName === 'Studio_Image'
        ? { width: 590, height: 798 }
        : { width: 590, height: 798 };

    validateImage(file, 1, fileDimensions.width, fileDimensions.height, function (isValid, message) {
        if (!isValid) {
            Swal.fire({
                icon: "error",
                title: message,
            });
            return onError && onError(message);
        }

        const formData = new FormData();
        formData.append('file_category', fileCategory);
        formData.append('folder', folderName);
        formData.append('product_no', $('#new_product_no').val());
        formData.append('image_uploaded', file);
        formData.append('product_id', $('#product_id').val());
        formData.append('db_image_field', dbField);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: "{{ route('products.upload_image') }}",
            method: 'POST',
            dataType: 'json',
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                Swal.fire({
                    type: data.responce,
                    title: data.message,
                });
                if (onSuccess) onSuccess(data);
                location.reload();
            },
            error: function (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Upload failed. Please try again.',
                });
                if (onError) onError(err);
            }
        });
    });
}

function uploadMultipleImages(imageID, ID = null) {
    const fileInput = document.getElementById(imageID);
    const files = fileInput.files;

    if (!files.length) {
        Swal.fire({
            icon: "error",
            title: "No files selected.",
        });
        return;
    }

    // Display the file table
    $('#uploaded_' + imageID + '_table').show();

    // Clear existing rows if ID is null (bulk upload)
    if (ID === null) {
        document.getElementById(imageID + "_tbody").innerHTML = "";

        for (let i = 0; i < files.length; i++) {
            addFileRow(imageID, files[i].name, i);
            handleFilePreview(imageID, files[i], i);
            uploadImage(files[i], getFolderName(imageID), getFileCategory(imageID), 'image_link');
        }
    } else {
        // Upload a specific file
        uploadImage(
            files[ID],
            getFolderName(imageID),
            getFileCategory(imageID),
            'image_link',
            () => updateFileStatus(imageID, ID, "success"),
            () => updateFileStatus(imageID, ID, "error")
        );
    }
}

function addFileRow(imageID, fileName, index) {
    const newRowHTML = `
        <tr>
            <td>${fileName}</td>
            <td class="text-center">
                <button class="uploadStyles" data-toggle="modal" data-target="#image_view_modal" id="imagePreview${imageID}_${index}" data-img-src="" type="button" title="View">
                    <i class="fa fa-eye" style="color: grey;"></i>
                </button>
                <button onclick="uploadMultipleImages('${imageID}', ${index})" class="uploadStyles" type="button" title="Upload">
                    <i class="fa fa-cloud-upload" id="${imageID}_upload_${index}"></i>
                    <i class="fas fa-spinner fa-spin" id="${imageID}_loading_${index}" style="display: none"></i>
                </button>
            </td>
        </tr>
    `;
    document.getElementById(imageID + "_tbody").innerHTML += newRowHTML;
}

function handleFilePreview(imageID, file, index) {
    const reader = new FileReader();
    reader.onload = function (e) {
        const imageContainer = document.getElementById('imagePreview' + imageID + '_' + index);
        imageContainer.setAttribute('data-img-src', e.target.result);
    };
    reader.readAsDataURL(file);
}

function updateFileStatus(imageID, index, status) {
    const uploadIcon = document.getElementById(imageID + '_upload_' + index);
    const loadingIcon = document.getElementById(imageID + '_loading_' + index);

    if (status === "success") {
        loadingIcon.style.display = "none";
        uploadIcon.style.display = "inline";
    } else if (status === "error") {
        loadingIcon.style.display = "none";
        uploadIcon.style.display = "inline";
        Swal.fire({
            icon: 'error',
            title: 'Failed to upload file.',
        });
    }
}

function getFolderName(imageID) {
    const folderMap = {
        'lifestyle_images': 'Life_Style_Image',
        'studio_images': 'Studio_Image',
        'close_up_images': 'Close_Up_Image',
        'branding_images': 'Branding_Image'
    };
    return folderMap[imageID] || '3D_Image';
}

function getFileCategory(imageID) {
    const categoryMap = {
        'lifestyle_images': 'lifeStyle Images File',
        'studio_images': 'Studio Images File',
        'close_up_images': 'closeUp Images File',
        'branding_images': 'branding Images File'
    };
    return categoryMap[imageID] || '3D Images File';
}

function uploadImages(uploaded_image_id, folder_name, fileCategory, db_coloumn_name) {

        const fileInput = document.getElementById(uploaded_image_id);
        const file = fileInput.files[0];

        if (!file) {
            Swal.fire({
                type: "error",
                title: "No file selected.",
            });
            return;
        }

        validateImage(file, 1, 590, 798, function (isValid, message) {
            if (!isValid && db_coloumn_name != 'size_chart') {
                Swal.fire({
                    type: "error",
                    title: message,
                });
                return;
            }
            var fileCat =fileCategory;
            var folder =folder_name;
            var dbField =db_coloumn_name;
            var productNo =$('#new_product_no').val();
            var product_id =$('#product_id').val();

            var formData = new FormData();
            formData.append('file_category', fileCat);
            formData.append('folder', folder);
            formData.append('product_no', productNo);

            if(folder_name == 'Life_Style_Image' || folder_name == '3D_Image' || folder_name == 'Close_Up_Image' || folder_name == 'Branding_Image' || folder_name == 'Studio_Image'){
                var files = uploaded_image_id;

                formData.append('image_uploaded', files);
                formData.append('product_id', product_id);
                formData.append('db_image_field', dbField);
                formData.append('_token', '{{ csrf_token() }}');


            }else{
                var files = $('#'+uploaded_image_id)[0].files[0];

                formData.append('image_uploaded',files);
                formData.append('db_field',dbField);
                formData.append('_token','{{ csrf_token() }}');
            }


            $.ajax({
                url:"{{ route('products.upload_image') }}",
                method:'POST',
                dataType:'json',
                data:formData,
                contentType: false,
                processData: false,
                beforeSend:function(){
                    $('#'+uploaded_image_id+'_upload').hide();
                    $('#'+uploaded_image_id+'_loading').show();
                    },
                success:function(data){

                    $('#'+uploaded_image_id+'_upload').show();
                    $('#'+uploaded_image_id+'_loading').hide();

                    Swal.fire({
                        type: data.responce,
                        title: data.meessage,
                    });

                },
            });
        });

    }


    function removeImg(imgID){
        Swal.fire({
            title: 'Are you sure to delete?',
            text: 'This action delete your image.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {

            if (result.value) {
            $.ajax({
                url:"{{ route('products.removeImages') }}",
                method:'POST',
                dataType:'json',
                data:{
                    '_token': '{{ csrf_token() }}',
                    imgID: imgID },
                beforeSend:function(){
                    $('.se-pre-con').fadeIn();
                },
                success:function(data){

                    $('.se-pre-con').fadeOut();

                    Swal.fire({
                        type: data.responce,
                        title: data.meessage,
                    });
                    location.reload();
                },
            });

            } else {
                Swal.close();
            }
        });




    }

    function buttonEnableFunc(buttonID){
        $("#"+buttonID+"_uploading").prop("disabled", false);
    }

    function deleteProduct(ProductID) {

    Swal.fire({
        title: 'Are you sure to delete product?',
        text: 'This action delete your product.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
    }).then((result) => {

        if (result.value) {

            console.log('success');
            window.location = "../delete/" + ProductID;

        } else {
            Swal.close();
        }
    });
    }

</script>

<script>
$(document).ready(function() {
    $(".nav-link1").on("click", function(e) {
        e.preventDefault();

        // Remove the "active" class from all tab links
        $(".nav-link1").removeClass("active");

        // Add the "active" class to the clicked tab link
        $(this).addClass("active");

        // Get the target tab ID from the link's ID
        var targetTabID = $(this).attr("id").replace("tab-", "");

        // Hide all tab content
        $(".tab-pane1").hide();

        // Show the tab content associated with the clicked link
        $("#" + targetTabID + "-tab").show();
    });
});
$('.se-pre-con').hide();


function validateImage(file, maxFileSizeMB, requiredWidth, requiredHeight, callback) {
    const maxFileSizeBytes = maxFileSizeMB * 1024 * 1024;

    // Check if the file is an image
    if (!file.type.startsWith("image/")) {
        callback(true, "Valid image.");
        return;
    }

    // Check file size
    if (file.size > maxFileSizeBytes) {
        callback(false, "Image size exceeds the " + maxFileSizeMB + " MB limit.");
        return;
    }

    // Validate dimensions
    const img = new Image();
    img.onload = function () {
        if (img.width !== requiredWidth || img.height !== requiredHeight) {
            callback(false, `Image dimensions must be ${requiredWidth}px x ${requiredHeight}px.`);
        } else {
            callback(true, "Valid image.");
        }
    };
    img.onerror = function () {
        callback(false, "Unable to validate image dimensions.");
    };

    img.src = URL.createObjectURL(file);
}



// $(document).ready(function() {
//     $('#new_available_colors').select2({
//         placeholder: "Select colors",
//         allowClear: true,
//         width: '100%',
//         templateResult: formatColorOption, // For dropdown options
//         templateSelection: formatColorOption // For selected options
//     });

//     function formatColorOption(state) {
//         if (!state.id) {
//             return state.text; // Return text if no id (for placeholder)
//         }

//         // Get the hex color value from the data attribute
//         var hexColor = $(state.element).data('hex');
//         var $state = $(
//             '<span style="background-color:#' + hexColor + '; color: #fff; padding: 1px 10px; border-radius: 2px;">'
//             + state.text + '</span>'
//         );
//         return $state;
//     }

//     // If there's an existing set of colors to be preselected, set them here
//     var preSelectedColors = @json($mainProductColor ?? []);
//     $('#new_available_colors').val(preSelectedColors).trigger('change');
// });
</script>

@if (!Gate::check('edit products'))
    <script>
        disableFormElements();
        function disableFormElements() {
            $('#product_create_form')
                .find('input, select, textarea, button')
                .not('#size_chart_downloading')
                .prop('disabled', true);
        }
    </script>
@endif
@if (Gate::check('edit product description'))
    <script>
        $('input[name="_token"]').prop('disabled', false);
        $('#product_id').prop('disabled', false);
        $('#new_description').prop('disabled', false);
        $('#who_we_made_this_for').prop('disabled', false);
        $('#product_features').prop('disabled', false);
        $('.custom_btn').prop('disabled', false);
    </script>
@endif
@if (Gate::check('upload product images'))
    <script>
        $(document).ready(function () {
            $('.card-new.col-md-6.permission-adding-class')
                .find('button, input, select, textarea')
                .prop('disabled', false);
        });
    </script>
@endif


@endsection
