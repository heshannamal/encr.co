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
    color: grey;
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
.sub_product_status .select2-selection__rendered {
    border: none;
}
.sub_product_status .select2-container--default .select2-selection--single {
    background-color: transparent;
}
.custom_btn{
    border-radius: 0rem;
    padding: .4rem 1rem;
    font-size: .8rem;
}
.form-input, .select2 .form-input {
    width: 100%;
}
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

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>@if($isDisable == 0 )CREATE SUB-PRODUCT @if($subProductCode !== 'PRO-null.1') - {{$subProductCode}} @endif @endif @if($isDisable == 1)EDIT SUB-PRODUCT - {{$subProductCode}} @endif</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('products') }}" class="home-btn-color" title="Back">BACK</a>
    @endsection

<div class="sub-product-style">
    <form action="{{ route('sub_products.create') }}" method="post" enctype="multipart/form-data" id="sub_product_create_form">
            @csrf
        <div class="row mb-3" style="background-color: transparent">
            {{-- <div class="col-md-9 header-style ml-2" style="font-size: 1.5rem;">
                @if($isDisable == 1){{$subProduct->product_name}} &nbsp; <span style="color: #b3b3b3;font-size: 1.2rem;border-left: 3px solid #b3b3b3;border-right: 3px solid #b3b3b3;"> &nbsp; {{$subProduct->sub_product_no}} &nbsp; </span> @endif
            </div> --}}
            <div class="col-md-3 ml-auto mr-3 text-right">
                <label for="toggleButton">
                    Show in Catalog
                    <div class="toggle-switch">
                        <input type="checkbox" name="show_in_catalog" id="toggleButton" class="toggle-checkbox" @if($isDisable == 1) @if($subProduct->show_in_catalog == 1) checked @endif @endif>
                        <span class="toggle-slider"></span>
                    </div>
                </label>
            </div>
            <div class="col-md-2 mb-2 mr-3 sub_product_status" style="border-bottom: 1px solid #d3d3d3;">
                <select style="border: none;border-radius: 0px;color:#d3d3d3;background-color: transparent;width:100%" class="form-control form-input" id="active" name="active">
                    {{-- <option value="0">Product Status</option> --}}
                    <option value="1" @if($isDisable == 1) @if($subProduct->active == 1) selected @endif @endif>Active</option>
                    <option value="3" @if($isDisable == 1) @if($subProduct->active == 3) selected @endif @endif @if($isDisable == 0) selected @endif>Under Construction</option>
                    <option value="0" @if($isDisable == 1) @if($subProduct->active == 0) selected @endif @endif>Inactive</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" style="padding: .5rem">
                <div class="card-new">
                    <div class="row">
                        <div class="col-md-9 header-style">
                            Product Details
                        </div>
                        {{-- <div class="col-md-3 header-style text-right" style="color: #b3b3b3">
                            @if($selectedProduct !== null || $isDisable == 1)  {{$subProductCode}} @endif
                        </div> --}}
                        {{-- <div class="col-md-12 sub-header-style">
                            Main product
                        </div> --}}
                        <div class="col-md-12">
                            <label for="product_name" class="form-label" style="font-weight: 700">Main Product Name</label>
                            <select class="form-control" id="product_name" name="product_name" @if($isDisable == 1) disabled @endif>
                                @if($selectedProduct == null)
                                    <option value="0" selected>Select Main Product</option>
                                @endif
                                @foreach ($products as $product)
                                    @if($selectedProduct !== null && $selectedProduct->id == $product->id)
                                    <option value="{{$product->id}}" selected>{{$product->product_name}}</option>
                                    @endif
                                    <option value="{{$product->id}}">{{$product->product_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" id="hidden_product_name" @if($isDisable == 0 && $selectedProduct !== null) value="{{$selectedProduct->product_name}}" @endif @if($isDisable == 1) value="{{$selectedProduct->product_name}}" @endif>
                        {{-- <div class="col-md-12 sub-header-style">
                            Sub product
                        </div> --}}
                        <div class="col-md-12">
                            <label for="sub_product_name" style="font-weight: 700" class="form-label">Sub Product Name</label>
                            <input class="form-control" @if($isDisable !== 0) @if($selectedProduct !== null || $isDisable == 1) value="{{$subProduct->product_name}}" @endif @endif   name="sub_product_name" id="sub_product_name" type='text'/>
                        </div>

                        @php
                            if (isset($subProduct)) {
                                $nameToShow = $subProduct->show_in_catalog_name;

                                if (!$nameToShow) {
                                    $productName = $subProduct->product_name;

                                    // '-' මත කොටස් කරන්න
                                    $parts = explode('-', $productName, 2);

                                    if (count($parts) == 2) {
                                        $before = trim($parts[0]); // Men's Collegiate Shooter Performance Tee
                                        $after  = trim($parts[1]); // DezTek

                                        // before එකේ පළමු වචන හඳුනාගන්න
                                        $words = explode(' ', $before, 2);

                                        if (count($words) == 2) {
                                            $firstWord = $words[0];          // Men's
                                            $remaining = $words[1];          // Collegiate Shooter Performance Tee

                                            $nameToShow = $firstWord . ' ' . $after . ' ' . $remaining;
                                        } else {
                                            // fail-safe: original name
                                            $nameToShow = $productName;
                                        }
                                    } else {
                                        $nameToShow = $productName;
                                    }
                                }
                            }else{
                                $nameToShow = '';
                            }
                        @endphp

                        <div class="col-md-12 mt-3">
                            <label for="new_product_name" class="form-label">Name Show in Catalog</label>
                            <input type="text" class="form-control form-input"
                                id="show_in_catalog_name"
                                value="{{ $nameToShow }}"
                                name="show_in_catalog_name">
                        </div>

                        <input @if($selectedProduct !== null || $isDisable == 1) value="{{$subProductCode}}" @endif  name="sub_product_no" id="sub_product_no" type='hidden' readonly/>

                        <div class="col-md-6 pr">
                            <label for="standard_fabric" class="form-label">Fabric</label>
                            <select class="form-control" id="standard_fabric" name="standard_fabric" onchange="subProductText()">
                                <option value="null">Select Fabric</option>
                                @foreach ($fabrics as $fabric)
                                    <option value="{{$fabric->fabric_name}}"  @if ($isDisable == 1 && $subProduct->standard_fabric == $fabric->fabric_name) selected @endif >{{$fabric->fabric_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 pr pl">
                            <label for="sub_product_pattern" class="form-label">Pattern Code</label>
                            <input class="form-control" @if($isDisable == 1) value="{{$subProduct->pattern_code}}" @endif  name="sub_product_pattern" id="sub_product_pattern" type='text'/>
                        </div>
                        <div class="col-md-3 pl">
                            <label for="sub_product_weight" class="form-label">Weight (oz)</label>
                            <input class="form-control" @if($isDisable == 1) value="{{$subProduct->weight}}" @endif  name="sub_product_weight" id="sub_product_weight" min="0.00" step="0.01" type='number'/>
                        </div>
                        {{-- <div class="col-md-12">
                            <label for="fabric_options" class="form-label">Fabric Options</label>
                            <select class="form-control multi-selection" id="fabric_options" name="fabric_options[]" multiple="multiple">
                                @foreach ($fabrics as $fabric)
                                @if($isDisable == 1)
                                    @foreach ($subProduct->fabric_options as $subProductFabricOption)
                                    @if ($subProductFabricOption == $fabric->fabric_name)
                                    <option value="{{$fabric->fabric_name}}" selected>{{$fabric->fabric_name}}</option>
                                    @endif
                                    @endforeach
                                @endif
                                    <option value="{{$fabric->fabric_name}}">{{$fabric->fabric_name}}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="col-md-12">
                            <label for="embellishment_options" class="form-label">Embellishment Options</label>
                            <select class="form-control multi-selection" id="embellishment_options" name="embellishment_options[]" multiple="multiple">
                                @foreach ($embellishmentTypes as $embellishmentType)
                                    <option value="{{ $embellishmentType->id }}"
                                        @if ($isDisable == 1 && $subProduct->embellishmentTypes->contains('embellishment_option', $embellishmentType->id)) selected @endif>
                                        {{ $embellishmentType->embellishment_name }}
                                        @if ($embellishmentType->price != 0) ( +${{ $embellishmentType->price }} ) @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Available Colors <span class="text-danger"></span></label><br>
                            <select class="form-control form-input multy-selection" id="new_available_colors" name="new_available_colors[]" multiple="multiple">
                                @foreach ($colorMasters as $colorMaster)
                                    <option value="{{$colorMaster->id}}" data-hex="{{$colorMaster->hex}}"
                                        @if(isset($subProductColor) && in_array($colorMaster->id, $subProductColor)) selected @endif>
                                        {{$colorMaster->pantone_code}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label for="attribute_on_price" class="form-label">Attributes Included in Unit Price</label>
                            <select class="form-control multi-selection" id="attribute_on_price" name="attribute_on_price[]" multiple="multiple">
                                @foreach ($productAttributes as $productAttribute)
                                    <option value="{{ $productAttribute->id }}"
                                        @if ($isDisable == 1 && $subProduct->attributeOnUnitPrice->contains('attribute__id', $productAttribute->id)) selected @endif>
                                        {{ $productAttribute->attribute_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="sub_product_note" class="form-label">Note</label>
                            <textarea class="form-control" name="sub_product_note" style="min-height: 70px;" id="sub_product_note" type='text'>@if($isDisable == 1) {{$subProduct->notes}} @endif </textarea>
                        </div>
                    </div>

                </div>
                @can('view design files')
                <div class="card-new mt-3">
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
                                    @can('view_Technical_Tech_Pack')
                                        <tr>
                                            <td>Technical Tech Pack</td>
                                            <td><input type="file" id="technical_tech_pack" @if($isDisable == 1) @if($subProduct->technical_tech_pack != null) @if(!Str::startsWith($subProduct->technical_tech_pack, 'http')) style="display:none" @endif @endif @endif  name="technical_tech_pack" onchange="buttonEnableFunc('technical_tech_pack')" class="file-select">
                                                <label for="technical_tech_pack" style="margin-bottom: 0rem; color: black; background-color: #efefef; padding: .1rem .5rem; border-radius: .5rem; cursor: pointer; @if($isDisable == 1) @if($subProduct->technical_tech_pack == null || Str::startsWith($subProduct->technical_tech_pack, 'http')) display:none; @endif @endif">@if($isDisable == 1) {{ basename($subProduct->technical_tech_pack) }} @endif</label>
                                            </td>
                                            <td class="text-center">
                                                @can('upload_Technical_Tech_Pack')
                                                    <button class="uploadStyles" type="button" title="Upload"  onclick="uploadImages('technical_tech_pack', 'technical_tech_pack', 'technical_tech_pack')" id="technical_tech_pack_uploading" style="border-right: 2px solid #b3b3b3" disabled>
                                                        <i class="fa fa-cloud-upload" id="technical_tech_pack_upload"></i><i class="fas fa-spinner fa-spin" id="technical_tech_pack_loading" style="display: none"></i>
                                                    </button>
                                                @else
                                                    <button class="uploadStyles" type="button" title="Upload" onclick="showPermissionError('You do not have permission to upload Technical Tech Packs.')" id="technical_tech_pack_uploading" style="border-right: 2px solid #b3b3b3" disabled>
                                                        <i class="fa fa-cloud-upload" id="technical_tech_pack_upload"></i>
                                                        <i class="fas fa-spinner fa-spin" id="technical_tech_pack_loading" style="display: none"></i>
                                                        <div class="loading-icon"></div>
                                                    </button>
                                                @endcan
                                                <button type="button" id="technical_tech_pack_downloading" title="Download" class="downloadStyles" @if($isDisable == 1)  onclick="window.location.href = '{{ asset('assets') }}{{$subProduct->technical_tech_pack}}'" @if ($subProduct->technical_tech_pack == null) disabled @endif @endif>
                                                    <i class="fa fa-cloud-download"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endcan
                                    @can('view_Pattern_Files')
                                        <tr>
                                            <td>Pattern Files</td>
                                            <td><input type="file" id="pattern_file" @if($isDisable == 1) @if($subProduct->pattern_file != null) @if(!Str::startsWith($subProduct->pattern_file, 'http')) style="display:none" @endif @endif @endif name="pattern_file" onchange="buttonEnableFunc('pattern_file')" class="file-select">
                                                <label for="pattern_file" style="margin-bottom: 0rem; color: black; background-color: #efefef; padding: .1rem .5rem; border-radius: .5rem; cursor: pointer; @if($isDisable == 1) @if($subProduct->pattern_file == null || Str::startsWith($subProduct->pattern_file, 'http')) display:none; @endif @endif">@if($isDisable == 1) {{ basename($subProduct->pattern_file) }} @endif</label>
                                            </td>
                                            <td class="text-center">
                                                @can('upload_Pattern_Files')
                                                    <button class="uploadStyles" type="button" title="Upload"  onclick="uploadImages('pattern_file', 'patterns', 'pattern_file')" id="pattern_file_uploading" style="border-right: 2px solid #b3b3b3" disabled>
                                                        <i class="fa fa-cloud-upload" id="pattern_file_upload"></i><i class="fas fa-spinner fa-spin" id="pattern_file_loading" style="display: none"></i>
                                                    </button>
                                                @else
                                                    <button class="uploadStyles" type="button" title="Upload" onclick="showPermissionError('You do not have permission to upload Pattern Files.')" id="pattern_file_uploading" style="border-right: 2px solid #b3b3b3" disabled>
                                                        <i class="fa fa-cloud-upload" id="pattern_file_upload"></i>
                                                        <i class="fas fa-spinner fa-spin" id="pattern_file_loading" style="display: none"></i>
                                                        <div class="loading-icon"></div>
                                                    </button>
                                                @endcan
                                                <button type="button" id="pattern_file_downloading" title="Download" class="downloadStyles" @if($isDisable == 1)  onclick="window.location.href = '{{ asset('') }}{{$subProduct->pattern_file}}'" @if ($subProduct->pattern_file == null) disabled @endif @endif>
                                                    <i class="fa fa-cloud-download"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endcan
                                    @can('view_size_chart')
                                        <tr>
                                            <td>Size Chart</td>
                                            <td><input type="file" id="size_chart" @if($isDisable == 1) @if($subProduct->size_chart != null) @if(!Str::startsWith($subProduct->size_chart, 'http')) style="display:none" @endif @endif @endif name="size_chart" onchange="buttonEnableFunc('size_chart')" class="file-select">
                                                <label for="size_chart" style="margin-bottom: 0rem; color: black; background-color: #efefef; padding: .1rem .5rem; border-radius: .5rem; cursor: pointer; @if($isDisable == 1) @if($subProduct->size_chart == null || Str::startsWith($subProduct->size_chart, 'http')) display:none; @endif @endif">@if($isDisable == 1) {{ basename($subProduct->size_chart) }} @endif</label>
                                            </td>
                                            <td class="text-center">
                                                @can('upload_size_chart')
                                                    <button class="uploadStyles" type="button" title="Upload"  onclick="uploadImages('size_chart', 'size_chart', 'size_chart')" id="size_chart_uploading" style="border-right: 2px solid #b3b3b3" disabled>
                                                        <i class="fa fa-cloud-upload" id="size_chart_upload"></i><i class="fas fa-spinner fa-spin" id="size_chart_loading" style="display: none"></i>
                                                    </button>
                                                @else
                                                    <button class="uploadStyles" type="button" title="Upload" onclick="showPermissionError('You do not have permission to upload Size chart.')" id="size_chart_uploading" style="border-right: 2px solid #b3b3b3" disabled>
                                                        <i class="fa fa-cloud-upload" id="size_chart_upload"></i>
                                                        <i class="fas fa-spinner fa-spin" id="size_chart_loading" style="display: none"></i>
                                                        <div class="loading-icon"></div>
                                                    </button>
                                                @endcan
                                                <button type="button" id="size_chart_downloading" title="Download" class="downloadStyles" @if($isDisable == 1)  onclick="window.location.href = '{{ asset('') }}{{$subProduct->size_chart}}'" @if ($subProduct->size_chart == null) disabled @endif @endif>
                                                    <i class="fa fa-cloud-download"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endcan
                                    @php
                                        $hasPermission = Gate::none(['view_Technical_Tech_Pack', 'view_size_chart', 'view_Pattern_Files']);
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
                <div class="card-new mt-3">
                    <div class="row">
                        <div class="col-md-12 header-style">
                            Pricing Info
                        </div>
                        {{-- {{dd($subProductPrices)}} --}}
                        <div class="col-md-12 mt-3 mb-2">
                            <table class="subProductTable">
                                <thead>
                                    <tr>
                                        <th>USER TYPE</th>
                                        <th class="text-right">PRICE ($)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>General</td>
                                        <td class="text-right"><input type="number" name="price_1" required @if($isDisable == 1)
                                            @foreach ($subProductPrices as $subProductPrice)
                                                @if ($subProductPrice->price_type == 1)
                                                    value="{{ $subProductPrice->price }}"
                                                @endif
                                            @endforeach
                                        @endif step="0.01" style="border: 1px solid #e7e7e7"></td>
                                    </tr>
                                    <tr>
                                        <td>Silver</td>
                                        <td class="text-right"><input type="number" name="price_2" @if($isDisable == 1)
                                            @foreach ($subProductPrices as $subProductPrice)
                                                @if ($subProductPrice->price_type == 2)
                                                    value="{{ $subProductPrice->price }}"
                                                @endif
                                            @endforeach
                                        @endif step="0.01" style="border: 1px solid #e7e7e7"></td>
                                    </tr>
                                    <tr>
                                        <td>Gold</td>
                                        <td class="text-right"><input type="number" name="price_3" @if($isDisable == 1)
                                            @foreach ($subProductPrices as $subProductPrice)
                                                @if ($subProductPrice->price_type == 3)
                                                    value="{{ $subProductPrice->price }}"
                                                @endif
                                            @endforeach
                                        @endif step="0.01" style="border: 1px solid #e7e7e7"></td>
                                    </tr>
                                    <tr>
                                        <td>Platinum</td>
                                        <td class="text-right"><input type="number" name="price_4" @if($isDisable == 1)
                                            @foreach ($subProductPrices as $subProductPrice)
                                                @if ($subProductPrice->price_type == 4)
                                                    value="{{ $subProductPrice->price }}"
                                                @endif
                                            @endforeach
                                        @endif step="0.01" style="border: 1px solid #e7e7e7"></td>
                                    </tr>
                                    <tr>
                                        <td>Manufacturer</td>
                                        <td class="text-right"><input type="number" name="price_5" @if($isDisable == 1)
                                            @foreach ($subProductPrices as $subProductPrice)
                                                @if ($subProductPrice->price_type == 5)
                                                    value="{{ $subProductPrice->price }}"
                                                @endif
                                            @endforeach
                                        @endif step="0.01" style="border: 1px solid #e7e7e7"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6" style="padding: .5rem">
                <div class="card-new permission-adding-class" style="height: 100%">
                    <div class="row">
                        <div class="col-md-12 header-style">
                            Product Images
                        </div>
                    </div>
                    @php
                        if ($isDisable == 1) {
                            $found_product = \App\Models\Product::find($subProduct->parent_product_id);

                            if ($found_product) {
                                $subProduct->mockup_img_1 = $subProduct->mockup_img_1 ?: $found_product->mockup_img_1;
                                $subProduct->mockup_img_2 = $subProduct->mockup_img_2 ?: $found_product->mockup_img_2;
                                $subProduct->mockup_img_3 = $subProduct->mockup_img_3 ?: $found_product->mockup_img_3;
                            }
                        }
                    @endphp
                    <div class="row mt-1">
                        <div class="col-md-8 pr">
                            <label class="form-label" style="font-weight:100; color:#b3b3b3">Product Image Preview</label>
                            <img @if($isDisable == 1 && $subProduct->mockup_img_1 !== null) src="{{ asset('assets') }}{{$subProduct->mockup_img_1}}"  @else src="{{ asset('public/images/default.png') }}" @endif id="imagePreviewArea" alt="Image" style="width: 100%;height: auto;border: 2px solid #f9f9f9;">
                        </div>
                        <div class="col-md-4 pl">
                            <div class="col-md-12" style="padding: 0rem">
                                <label class="form-label" style="font-weight:700">Front image</label>
                                <label for="front_image" id="front_image_upload_area" class="upload-area" @if($isDisable == 1 && $subProduct->mockup_img_1 !== null) style="display:none" @endif>
                                    <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                    <div class="upload-icon">
                                        <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD IMAGE</i>
                                        <p style="color: #ff0000;font-size: .8rem;">590px x 798px</p>
                                    </div>
                                </label>
                                <label for="front_image" id="front_image_display_area" class="upload-area"  @if($isDisable == 1 && $subProduct->mockup_img_1 == null) style="display: none;" @endif @if($isDisable == 1 && $subProduct->mockup_img_1 !== null) style="display: block;" @endif @if($isDisable == 0) style="display: none;" @endif >
                                    <img @if($isDisable == 1 && $subProduct->mockup_img_1 !== null) src="{{ asset('assets') }}{{$subProduct->mockup_img_1}}"  @else src="{{ asset('public/images/default.png') }}" @endif id="front_image_uploaded" alt="Image" style="width: auto;height: 100%;border: 2px solid #f9f9f9;">
                                    <button type="button" onclick="removeImagePreview('front_image')" class="close-button">X</button>
                                </label>
                                <input type="file" id="front_image" name="front_image" onchange="imageDisplay(this , 'front_image')" class="file-select" accept="image/*" style="display: none">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <button type="button" title="Upload Image" class="functionalities_front_image" onclick="uploadImages('front_image', 'mockup_images', 'mockup_img_1')" style="display: none;"><i class="fa fa-cloud-upload" id="front_image_upload"></i><i class="fas fa-spinner fa-spin" id="front_image_loading" style="display: none"></i></button>
                                    <button type="button" title="Preview Image" class="text-right functionalities_front_image" onclick="previewImg('front_image')"   @if($isDisable == 1 && $subProduct->mockup_img_1 == null) style="display: none;" @endif @if($isDisable == 1 && $subProduct->mockup_img_1 !== null) style="display: block;" @endif @if($isDisable == 0) style="display: none;" @endif ><i class="fa fa-eye" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding: 0rem">
                                <label class="form-label" style="font-weight:700">Side image</label>
                                <label for="side_image" id="side_image_upload_area" class="upload-area" @if($isDisable == 1 && $subProduct->mockup_img_2 !== null) style="display:none" @endif>
                                    <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                    <div class="upload-icon">
                                        <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD IMAGE</i>
                                        <p style="color: #ff0000;font-size: .8rem;">590px x 798px</p>
                                    </div>
                                </label>
                                <label for="side_image" id="side_image_display_area" class="upload-area"  @if($isDisable == 1 && $subProduct->mockup_img_2 == null) style="display: none;" @endif @if($isDisable == 1 && $subProduct->mockup_img_2 !== null) style="display: block;" @endif @if($isDisable == 0) style="display: none;" @endif >
                                    <img @if($isDisable == 1 && $subProduct->mockup_img_1 !== null) src="{{ asset('assets') }}{{$subProduct->mockup_img_2}}"  @else src="{{ asset('public/images/default.png') }}" @endif id="side_image_uploaded" alt="Image" style="width: auto;height: 100%;border: 2px solid #f9f9f9;">
                                    <button type="button" onclick="removeImagePreview('side_image')" class="close-button">X</button>
                                </label>
                                <input type="file" id="side_image" id="name" onchange="imageDisplay(this , 'side_image')" class="file-select" accept="image/*" style="display: none;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <button type="button" title="Upload Image" class="functionalities_side_image" onclick="uploadImages('side_image', 'mockup_images', 'mockup_img_2')" style="display: none;" ><i class="fa fa-cloud-upload" id="side_image_upload"></i><i class="fas fa-spinner fa-spin" id="side_image_loading" style="display: none"></i></button>
                                    <button type="button" title="Preview Image" class="text-right functionalities_side_image" onclick="previewImg('side_image')"   @if($isDisable == 1 && $subProduct->mockup_img_2 == null) style="display: none;" @endif @if($isDisable == 1 && $subProduct->mockup_img_2 !== null) style="display: block;" @endif @if($isDisable == 0) style="display: none;" @endif ><i class="fa fa-eye" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding: 0rem">
                                <label class="form-label" style="font-weight:700">Back image</label>
                                <label for="back_image" id="back_image_upload_area" class="upload-area" @if($isDisable == 1 && $subProduct->mockup_img_3 !== null) style="display:none" @endif>
                                    <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                    <div class="upload-icon">
                                        <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD IMAGE</i>
                                        <p style="color: #ff0000;font-size: .8rem;">590px x 798px</p>
                                    </div>
                                </label>
                                <label for="back_image" id="back_image_display_area" class="upload-area"  @if($isDisable == 1 && $subProduct->mockup_img_3 == null) style="display: none;" @endif @if($isDisable == 1 && $subProduct->mockup_img_3 !== null) style="display: block;" @endif @if($isDisable == 0) style="display: none;" @endif >
                                    <img @if($isDisable == 1 && $subProduct->mockup_img_1 !== null) src="{{ asset('assets') }}{{$subProduct->mockup_img_3}}"  @else src="{{ asset('public/images/default.png') }}" @endif id="back_image_uploaded" alt="Image" style="width: auto;height: 100%;border: 2px solid #f9f9f9;">
                                    <button type="button" onclick="removeImagePreview('back_image')" class="close-button">X</button>
                                </label>
                                <input type="file" id="back_image" name="back_image" onchange="imageDisplay(this , 'back_image')" class="file-select" accept="image/*" style="display: none;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <button type="button" title="Upload Image" class="functionalities_back_image" onclick="uploadImages('back_image', 'mockup_images', 'mockup_img_3')" style="display: none;"><i class="fa fa-cloud-upload" id="back_image_upload"></i><i class="fas fa-spinner fa-spin" id="back_image_loading" style="display: none"></i></button>
                                    <button type="button" title="Upload Image" class="text-right functionalities_back_image" onclick="previewImg('back_image')"  @if($isDisable == 1 && $subProduct->mockup_img_3 == null) style="display: none;" @endif @if($isDisable == 1 && $subProduct->mockup_img_3 !== null) style="display: block;" @endif @if($isDisable == 0) style="display: none;" @endif><i class="fa fa-eye" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        if ($isDisable == 1) {
                            $subProductImages = \App\Models\SubProductImage::where('active', 1)->where('sub_product_no', $subProduct->sub_product_no)->orderBy('id')->get();
                        }
                    @endphp
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
                                <div class="tab-pane tab-pane1 active" id="3d-tab">
                                    <div class="col-md-12 mt-3" style="padding: 0rem">
                                        <label for="3d_images" id="3d_images_upload_area" class="upload-area" style="height: 200px;">
                                            <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                            <div class="upload-icon">
                                                <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD IMAGE</i>
                                            </div>
                                            <p style="color: #b3b3b3;font-size: .8rem;margin-top: .5rem;">Drag & drop FLAT images here or <span style="font-weight: 600">CLICK HERE</span>  to upload FLAT images</p>
                                            <p style="color: #ff0000;font-size: .8rem;">Maximum file size: 1MB with a resolution of 590px x 798px</p>
                                        </label>
                                        <input type="file" id="3d_images" onchange="uploadMultipleImages('3d', null)" class="file-select" accept="image/*" style="display: none;" multiple>
                                    </div>
                                    @if(!empty($subProductImages))
                                    <div class="row mt-2" id="uploaded_3d_images_table" @if(count($subProductImages->where('image_type',1)) < 1 ) style="display: none" @endif>
                                        <div class="col-md-12 sub-header-style">
                                            Uploaded flat Images
                                        </div>
                                        <div class="col-md-12 mt-3 mb-2">
                                            <table class="subProductTable">
                                                <thead>
                                                    <tr>
                                                        <th>FILE NAME</th>
                                                        <th style="width: 20%;" class="text-center">ACTION</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="3d_images_tbody">
                                                    @foreach ($subProductImages as $subProductImage)
                                                        @if ($subProductImage->image_type == 1)
                                                            <tr>
                                                                <td>{{$subProductImage->image_name}}</td>
                                                                <td class="text-center">
                                                                    <button class="uploadStyles" data-toggle="modal" data-target="#image_view_modal" data-img-src="{{ url('') }}{{$subProductImage->image_link}}" type="button" title="View">
                                                                        <i class="fa fa-eye" style="color: grey;"></i>
                                                                    </button>
                                                                    <button class="uploadStyles" type="button" title="Upload">
                                                                        <i class="fa fa-trash" onclick="removeImg({{$subProductImage->id}})" style="color: #e19191;"></i>
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
                                <div class="tab-pane tab-pane1" id="lifestyle-tab">
                                    <div class="col-md-12 mt-3" style="padding: 0rem">
                                        <label for="lifestyle_images" id="lifestyle_images_upload_area" class="upload-area" style="height: 200px;">
                                            <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                            <div class="upload-icon">
                                                <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD IMAGE</i>
                                            </div>
                                            <p style="color: #b3b3b3;font-size: .8rem;margin-top: .5rem;">Drag & drop LIFESTYLE images here or <span style="font-weight: 600">CLICK HERE</span>  to upload LIFESTYLE images</p>
                                            <p style="color: #ff0000;font-size: .8rem;">Maximum file size: 1MB with a resolution of 590px x 798px</p>
                                        </label>
                                        <input type="file" id="lifestyle_images" onchange="uploadMultipleImages('lifestyle', null)" class="file-select" accept="image/*" style="display: none;" multiple>
                                    </div>
                                    @if(!empty($subProductImages))
                                    <div class="row mt-2" id="uploaded_lifestyle_images_table" @if(count($subProductImages->where('image_type',2)) < 1 ) style="display: none" @endif>
                                        <div class="col-md-12 sub-header-style">
                                            Uploaded Lifestyle Images
                                        </div>
                                        <div class="col-md-12 mt-3 mb-2">
                                            <table class="subProductTable">
                                                <thead>
                                                    <tr>
                                                        <th>FILE NAME</th>
                                                        <th style="width: 20%;" class="text-center">ACTION</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="lifestyle_images_tbody">
                                                    @foreach ($subProductImages as $subProductImage)
                                                        @if ($subProductImage->image_type == 2)
                                                            <tr>
                                                                <td>{{$subProductImage->image_name}}</td>
                                                                <td class="text-center">
                                                                    <button class="uploadStyles" data-toggle="modal" data-target="#image_view_modal" data-img-src="{{ url('') }}{{$subProductImage->image_link}}" type="button" title="View">
                                                                        <i class="fa fa-eye" style="color: grey;"></i>
                                                                    </button>
                                                                    <button class="uploadStyles" type="button" title="Upload">
                                                                        <i class="fa fa-trash" onclick="removeImg({{$subProductImage->id}})" style="color: #e19191;"></i>
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
                                        <label for="closeup_images" id="closeup_images_upload_area" class="upload-area" style="height: 200px;">
                                            <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                            <div class="upload-icon">
                                                <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD IMAGE</i>
                                            </div>
                                            <p style="color: #b3b3b3;font-size: .8rem;margin-top: .5rem;">Drag & drop CLOSEUP images here or <span style="font-weight: 600">CLICK HERE</span>  to upload CLOSEUP images</p>
                                            <p style="color: #ff0000;font-size: .8rem;">Maximum file size: 1MB with a resolution of 590px x 798px</p>
                                        </label>
                                        <input type="file" id="closeup_images" onchange="uploadMultipleImages('closeup', null)" class="file-select" accept="image/*" style="display: none;" multiple>
                                    </div>
                                    @if(!empty($subProductImages))
                                    <div class="row mt-2" id="uploaded_closeup_images_table" @if(count($subProductImages->where('image_type',3)) < 1 ) style="display: none" @endif>
                                        <div class="col-md-12 sub-header-style">
                                            Uploaded closeup Images
                                        </div>
                                        <div class="col-md-12 mt-3 mb-2">
                                            <table class="subProductTable">
                                                <thead>
                                                    <tr>
                                                        <th>FILE NAME</th>
                                                        <th style="width: 20%;" class="text-center">ACTION</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="closeup_images_tbody">
                                                    @foreach ($subProductImages as $subProductImage)
                                                        @if ($subProductImage->image_type == 3)
                                                            <tr>
                                                                <td>{{$subProductImage->image_name}}</td>
                                                                <td class="text-center">
                                                                    <button class="uploadStyles" data-toggle="modal" data-target="#image_view_modal" data-img-src="{{ url('') }}{{$subProductImage->image_link}}" type="button" title="View">
                                                                        <i class="fa fa-eye" style="color: grey;"></i>
                                                                    </button>
                                                                    <button class="uploadStyles" type="button" title="Upload">
                                                                        <i class="fa fa-trash" onclick="removeImg({{$subProductImage->id}})" style="color: #e19191;"></i>
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
                                            <p style="color: #b3b3b3;font-size: .8rem;margin-top: .5rem;">Drag & drop BRANDING images here or <span style="font-weight: 600">CLICK HERE</span>  to upload BRANDING images</p>
                                            <p style="color: #ff0000;font-size: .8rem;">Maximum file size: 1MB with a resolution of 590px x 798px</p>
                                        </label>
                                        <input type="file" id="branding_images" onchange="uploadMultipleImages('branding', null)" class="file-select" accept="image/*" style="display: none;" multiple>
                                    </div>
                                    @if(!empty($subProductImages))
                                    <div class="row mt-2" id="uploaded_branding_images_table" @if(count($subProductImages->where('image_type',4)) < 1 ) style="display: none" @endif>
                                        <div class="col-md-12 sub-header-style">
                                            Uploaded branding Images
                                        </div>
                                        <div class="col-md-12 mt-3 mb-2">
                                            <table class="subProductTable">
                                                <thead>
                                                    <tr>
                                                        <th>FILE NAME</th>
                                                        <th style="width: 20%;" class="text-center">ACTION</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="branding_images_tbody">
                                                    @foreach ($subProductImages as $subProductImage)
                                                        @if ($subProductImage->image_type == 4)
                                                            <tr>
                                                                <td>{{$subProductImage->image_name}}</td>
                                                                <td class="text-center">
                                                                    <button class="uploadStyles" data-toggle="modal" data-target="#image_view_modal" data-img-src="{{ url('') }}{{$subProductImage->image_link}}" type="button" title="View">
                                                                        <i class="fa fa-eye" style="color: grey;"></i>
                                                                    </button>
                                                                    <button class="uploadStyles" type="button" title="Upload">
                                                                        <i class="fa fa-trash" onclick="removeImg({{$subProductImage->id}})" style="color: #e19191;"></i>
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
                                            <p style="color: #b3b3b3;font-size: .8rem;margin-top: .5rem;">Drag & drop STUDIO images here or <span style="font-weight: 600">CLICK HERE</span>  to upload STUDIO images</p>
                                            <p style="color: #ff0000;font-size: .8rem;">Maximum file size: 1MB with a resolution of 590px x 798px</p>
                                        </label>
                                        <input type="file" id="studio_images" onchange="uploadMultipleImages('studio', null)" class="file-select" accept="image/*" style="display: none;" multiple>
                                    </div>
                                    @if(!empty($subProductImages))
                                    <div class="row mt-2" id="uploaded_studio_images_table" @if(count($subProductImages->where('image_type',5)) < 1 ) style="display: none" @endif>
                                        <div class="col-md-12 sub-header-style">
                                            Uploaded studio Images
                                        </div>
                                        <div class="col-md-12 mt-3 mb-2">
                                            <table class="subProductTable">
                                                <thead>
                                                    <tr>
                                                        <th>FILE NAME</th>
                                                        <th style="width: 20%;" class="text-center">ACTION</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="studio_images_tbody">
                                                    @foreach ($subProductImages as $subProductImage)
                                                        @if ($subProductImage->image_type == 5)
                                                            <tr>
                                                                <td>{{$subProductImage->image_name}}</td>
                                                                <td class="text-center">
                                                                    <button class="uploadStyles" data-toggle="modal" data-target="#image_view_modal" data-img-src="{{ url('') }}{{$subProductImage->image_link}}" type="button" title="View">
                                                                        <i class="fa fa-eye" style="color: grey;"></i>
                                                                    </button>
                                                                    <button class="uploadStyles" type="button" title="Upload">
                                                                        <i class="fa fa-trash" onclick="removeImg({{$subProductImage->id}})" style="color: #e19191;"></i>
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
            <div class="col-md-12" style="padding: .5rem">
                <div class="card-new">
                    <div class="row">
                        <div class="col-md-12 header-style">
                            Product Description
                        </div>
                        <div class="col-md-12 mt-3 mb-1">
                            <div id="editor-description" style="height: 300px;">@if($isDisable == 1) {!! $subProduct->description !!} @endif</div>
                            <input type="hidden" id="new_description" @if($isDisable == 1) value="{{$subProduct->description}}" @endif name="new_description">
                        </div>
                        <div class="col-md-12 header-style mt-3">
                            Who We Made This For
                        </div>
                        <div class="col-md-12 mt-3 mb-1">
                            <div id="editor-who-we-made-this-for" style="height: 100px;">@if($isDisable == 1) {!! $subProduct->who_we_made_this_for !!} @endif</div>
                            <input type="hidden" id="who_we_made_this_for" @if($isDisable == 1) value="{{$subProduct->who_we_made_this_for}}" @endif name="who_we_made_this_for">
                        </div>
                        <div class="col-md-12 header-style mt-3">
                            Product Features
                        </div>
                        <div class="col-md-12 mt-3 mb-1">
                            <div id="editor-product-features" style="height: 100px;">@if($isDisable == 1) {!! $subProduct->product_features !!} @endif</div>
                            <input type="hidden" id="product_features" @if($isDisable == 1) value="{{$subProduct->product_features}}" @endif name="product_features">
                        </div>
                    </div>
                    <div class="col-md-12 mt-3 mb-3 text-right">
                        @if (Gate::check('edit products') || Gate::check('edit product description'))
                            <button type="submit" class="btn btn-success custom_btn">@if($isDisable == 1) UPDATE @else SAVE @endif</button>
                        @endif
                        @if (Gate::check('delete products'))
                            <button type="button" onclick="deleteSubProduct('{{$subProductCode}}')" class="btn btn-danger custom_btn">Delete</button>
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
                <img id="image_to_display" src="" alt="Image" style="margin: .5rem;width: 97%;">
            </div>
        </div>
    </div>
</div>

<script>
    function showPermissionError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Permission Denied',
            text: message,
            confirmButtonText: 'OK'
        });
    }
    $('#image_view_modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var imgSrc = button.data('img-src');
        var modal = $(this);
        modal.find('#image_to_display').attr('src', imgSrc);
    });
</script>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    $(document).ready( function () {
        $("#fabric_options").select2();
        $("#standard_fabric").select2();
        $("#product_name").select2();
        $("#embellishment_options").select2();
        // $("#new_available_colors").select2();
        $("#attribute_on_price").select2();
        $("#active").select2();
    });
    $(document).ready(function() {
        $('#product_name').change(function() {
            var selectedValue = $(this).val();
            window.location = "../sub_products/" + selectedValue;
        });
    });

    // subProductText();
    function subProductText() {
        const inputElement = document.getElementById("sub_product_name");
        const product_name = $('#hidden_product_name').val() + " - " + $('#standard_fabric').val() + " ";
        const wordCount = product_name.split(/\s+/).length;
        const characterCount = product_name.length;

        inputElement.value = product_name;
        // inputElement.readOnly = true;

        // inputElement.addEventListener("input", function () {
        //     const inputText = inputElement.value.trim();
        //     const inputCharacterCount = inputText.length;

        //     if (inputCharacterCount < characterCount) {
        //         inputElement.value = product_name;
        //     }
        // });

        // inputElement.readOnly = false;
        // inputElement.focus();
    }



    $(document).ready(function() {
        $('#new_available_colors').select2({
            placeholder: "Select colors",
            allowClear: true,
            width: '100%',
            templateResult: formatColorOption, // For dropdown options
            templateSelection: formatColorOption // For selected options
        });

        function formatColorOption(state) {
            if (!state.id) {
                return state.text; // Return text if no id (for placeholder)
            }

            // Get the hex color value from the data attribute
            var hexColor = $(state.element).data('hex');
            var $state = $(
                '<span style="background-color:#' + hexColor + '; color: #fff; padding: 1px 10px; border-radius: 2px;">'
                + state.text + '</span>'
            );
            return $state;
        }

        // If there's an existing set of colors to be preselected, set them here
        var preSelectedColors = @json($subProductColor ?? []);
        $('#new_available_colors').val(preSelectedColors).trigger('change');
    });




    function deleteSubProduct(subProductCode) {

        Swal.fire({
            title: 'Are you sure to delete sub product?',
            text: 'This action delete your sub product.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {

            if (result.value) {

                window.location = "{{ route('sub_products.delete', ':id') }}".replace(':id', subProductCode);

            } else {
                Swal.close();
            }
        });
    }

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

    function imageDisplay(fileInput, displayArea) {
        const imagePreview = document.getElementById(displayArea + '_uploaded');

        if (fileInput.files && fileInput.files[0]) {
            const file = fileInput.files[0];

            validateImage(file, 1, function (isValid, message) {
                if (!isValid) {
                    swal({
                        title: "Invalid Image",
                        text: message,
                        icon: "error",
                        button: "Okay"
                    });
                    return;
                }

            });
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
            };
            reader.readAsDataURL(file);

            $('#' + displayArea + '_upload_area').hide();
            $('#' + displayArea + '_display_area').show();
            $('.functionalities_' + displayArea).show();
        }
    }

    function validateImage(file, maxFileSizeMB, callback) {
        const maxFileSizeBytes = maxFileSizeMB * 1024 * 1024;

        if (file.size > maxFileSizeBytes) {
            callback(false, "Image size exceeds the " + maxFileSizeMB + " MB limit.");
            return;
        }

        const img = new Image();
        const reader = new FileReader();

        reader.onload = function (e) {
            img.src = e.target.result;
        };

        img.onload = function () {
            if (img.width !== 590 || img.height !== 798) {
                callback(false, "Image dimensions must be 590px x 798px, You uploaded "+img.width+"px x "+img.height+"px");
            }
        };

        img.onerror = function () {
            callback(false, "Unable to validate image dimensions.");
        };

        reader.readAsDataURL(file);
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

    function uploadMultipleImages(imageID, ID) {
    $('#uploaded_' + imageID + '_table').show();

    const fileInput = document.getElementById(imageID + '_images');
    const files = fileInput.files;
    const maxFileSizeBytes = 1024 * 1024; // 1MB

    if (ID == null) {
        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            // Validate file size
            if (file.size > maxFileSizeBytes) {
                swal({
                    title: "Invalid Image",
                    text: `Image "${file.name}" size exceeds the 1MB limit.`,
                    icon: "error",
                    button: "Okay"
                });
                continue; // Skip this file
            }

            // Validate image dimensions
            const reader = new FileReader();
            const img = new Image();

            reader.onload = function (e) {
                img.src = e.target.result;
            };

            img.onload = function () {
                if ( imageID == 'lifestyle' || imageID == 'studio') {
                    if (img.width !== 590 || img.height !== 798) {
                        swal({
                            title: "Invalid Image",
                            text: `Image "${file.name}" dimensions must be 590px x 798px.`,
                            icon: "error",
                            button: "Okay"
                        });
                        return;
                    }
                }else{
                    if (img.width !== 590 || img.height !== 798) {
                        swal({
                            title: "Invalid Image",
                            text: `Image "${file.name}" dimensions must be 590px x 798px.`,
                            icon: "error",
                            button: "Okay"
                        });
                        return;
                    }
                }

                const newRowHTML = `
                    <tr>
                        <td>${file.name}</td>
                        <td class="text-center">
                            <button class="uploadStyles" data-toggle="modal" data-target="#image_view_modal" id="imagePreview${i}" data-img-src="{{ asset('public/images/default.png') }}" type="button" title="View">
                                <i class="fa fa-eye" style="color: grey;"></i>
                            </button>
                            <button onclick="uploadMultipleImages('${imageID}', '${i}')" class="uploadStyles" type="button" title="Upload">
                                <i class="fa fa-cloud-upload" id="${imageID}_upload_${i}"></i>
                                <i class="fas fa-spinner fa-spin" id="${imageID}_loading_${i}" style="display: none"></i>
                            </button>
                        </td>
                    </tr>
                `;

                document.getElementById(imageID + "_images_tbody").innerHTML += newRowHTML;

                // Set the preview image
                const imagePreviewButton = document.getElementById('imagePreview' + i);
                imagePreviewButton.setAttribute('data-img-src', img.src);

                // Show table if hidden
                if ($('#uploaded_' + imageID + '_images_table').css('display') === 'none') {
                    $('#uploaded_' + imageID + '_images_table').show();
                }
            };

            img.onerror = function () {
                swal({
                    title: "Invalid Image",
                    text: `Image "${file.name}" could not be loaded. Please try again.`,
                    icon: "error",
                    button: "Okay"
                });
            };

            reader.readAsDataURL(file);
        }
    } else {
        // Upload a specific image
        uploadImagesMultiple(files[ID], imageID, imageID, ID);
    }
}


    function uploadImages(uploaded_image_id, folder_name, db_coloumn_name) {

            var imageDirectoryData = new FormData();

            var files = $('#'+uploaded_image_id)[0].files[0];
            var sub_product_no = $('#sub_product_no').val();
            var main_product_no = $('#product_name').val();

            imageDirectoryData.append('image_uploaded', files);
            imageDirectoryData.append('folder_name', folder_name);
            imageDirectoryData.append('sub_product_no', sub_product_no);
            imageDirectoryData.append('main_product_no', main_product_no);
            imageDirectoryData.append('db_coloumn_name', db_coloumn_name);
            imageDirectoryData.append('_token','{{ csrf_token() }}');

            $.ajax({
                url:"{{ route('sub_products.uploadImages') }}",
                method:'POST',
                dataType:'json',
                data:imageDirectoryData,
                contentType: false,
                processData: false,
                beforeSend:function(){
                    // $('.se-pre-con').fadeIn();
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
                    if(data.responce == "success"){
                        console.log('upload success');
                    } else {

                    }
                },
            });

    }

    function uploadImagesMultiple(uploaded_image_id, folder_name, db_coloumn_name, num) {

        var imageDirectoryData = new FormData();
        var files = uploaded_image_id;

        var sub_product_no = $('#sub_product_no').val();
        var main_product_no = $('#product_name').val();

        imageDirectoryData.append('image_uploaded', files);
        imageDirectoryData.append('folder_name', folder_name);
        imageDirectoryData.append('sub_product_no', sub_product_no);
        imageDirectoryData.append('main_product_no', main_product_no);
        imageDirectoryData.append('db_coloumn_name', db_coloumn_name);
        imageDirectoryData.append('_token','{{ csrf_token() }}');

        $.ajax({
            url:"{{ route('sub_products.uploadImages') }}",
            method:'POST',
            dataType:'json',
            data:imageDirectoryData,
            contentType: false,
            processData: false,
            beforeSend:function(){
                // $('.se-pre-con').fadeIn();
                $('#'+folder_name+'_upload_'+num).hide();
                $('#'+folder_name+'_loading_'+num).show();
            },
            success:function(data){
                $('#'+folder_name+'_upload_'+num).show();
                $('#'+folder_name+'_loading_'+num).hide();

                Swal.fire({
                    type: data.responce,
                    title: data.meessage,
                });
                if(data.responce == "success"){
                    console.log('upload success');
                } else {

                }
            },
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
                url:"{{ route('sub_products.removeImages') }}",
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
</script>

@if (!Gate::check('edit products'))
    <script>
        disableFormElements();
        function disableFormElements() {
            $('#sub_product_create_form')
                .find('input, select, textarea, button')
                .prop('disabled', true);
        }
    </script>
@endif
@if (Gate::check('edit product description'))
    <script>
        $('input[name="_token"]').prop('disabled', false);
        $('#sub_product_no').prop('disabled', false);
        $('#new_description').prop('disabled', false);
        $('#who_we_made_this_for').prop('disabled', false);
        $('#product_features').prop('disabled', false);
        $('.custom_btn').prop('disabled', false);
    </script>
@endif
@if (Gate::check('upload product images'))
    <script>
        $(document).ready(function () {
            $('.card-new.permission-adding-class')
                .find('button, input, select, textarea')
                .prop('disabled', false);
        });
    </script>
@endif


@endsection
