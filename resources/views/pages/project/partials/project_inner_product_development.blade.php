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
/* .select2-selection__rendered{
    border: 1px solid #DEDEDE;
    border-radius: 0rem;
    color: #717070;
    padding-left: 7px;
    font-size: 0.8rem;
} */
.select2 .selection .select2-selection--multiple{
    border: 1px solid #DEDEDE !important;
    border-radius: 0rem !important;
    color: #717070 !important;
    min-height: calc(1.5rem + 1px);

}
.select2-container .select2-selection--single .select2-selection__rendered {
    border: 1px solid #DEDEDE !important;
}
/* .select2-selection--multiple .select2-selection__rendered{
    border: 1px solid #DEDEDE !important;
} */
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


.form-input {
    height: 38px;
    font-size: 14px;
}
textarea.form-input {
    min-height: 60px;
}


/* Make Select2 fully responsive */
.select2-container {
    width: 100% !important;
}

/* remove horizontal scroll 🔥 */
.modal-dialog {
    max-width: 800px;
}

/* control image size */
.modal-img {
    max-height: 300px;
    object-fit: contain;
}

/* fix overflow issue */
.modal-body {
    overflow-x: hidden;
}

@media (max-width: 767px) {
    .sub-product-style {
        padding-left: 0px !important;
        padding-right: 0px !important;
    }

    .sub-product-style .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }

    /* Stack columns vertically */
    .sub-product-style .col-md-6,
    .sub-product-style .col-md-12 {
        width: 100% !important;
        max-width: 100% !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
    
    /* Style single-header cards */
    .sub-product-style .card-new:not(.multi-header) {
        background: #fff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        padding: 15px !important;
        margin: 0 0 12px 0 !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important;
    }
    
    .sub-product-style .card-new:not(.multi-header) .header-style {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        margin: 0 !important;
        display: flex !important;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        user-select: none;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
    }
    
    /* Style multi-header card container */
    .sub-product-style .card-new.multi-header {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    
    /* Style headers in multi-header cards as individual cards */
    .sub-product-style .card-new.multi-header .header-style {
        background: #fff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        padding: 15px !important;
        margin: 0 0 12px 0 !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important;
        display: flex !important;
        justify-content: space-between;
        align-items: center;
        user-select: none;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
    }
    
    /* Expanded state styles for multi-header accordion headers */
    .sub-product-style .card-new.multi-header .header-style.expanded {
        border-radius: 8px 8px 0 0 !important;
        margin-bottom: 0 !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }
    
    /* Style content divs inside multi-header card when expanded */
    .sub-product-style .card-new.multi-header .header-style + div {
        background: #fff !important;
        border: 1px solid #e2e8f0 !important;
        border-top: none !important;
        border-radius: 0 0 8px 8px !important;
        padding: 15px !important;
        margin-top: 0 !important;
        margin-bottom: 12px !important;
    }
    
    /* FontAwesome Chevrons for headers */
    .sub-product-style .header-style::after {
        content: "\f105"; /* FontAwesome angle right */
        font-family: "Font Awesome 5 Free", "FontAwesome";
        font-weight: 900;
        font-size: 1.1rem;
        color: #888;
        transition: transform 0.2s;
    }
    
    .sub-product-style .header-style.expanded::after {
        content: "\f107"; /* FontAwesome angle down */
    }
    
    /* Accordion collapse logic */
    /* Hide row elements except header in collapsed single-header cards */
    .sub-product-style .card-new:not(.multi-header):not(.expanded) .row > div:not(.header-style) {
        display: none !important;
    }
    
    /* Hide content wrapper if multi-header title is not expanded */
    .sub-product-style .card-new.multi-header .header-style:not(.expanded) + div {
        display: none !important;
    }
    
    /* Keep submit buttons and moveForm container visible at all times */
    .sub-product-style .card-new.multi-header > .row > .text-right,
    .sub-product-style .card-new.multi-header > .row > form {
        display: block !important;
    }

    /* Design Files Table Mobile Styling */
    .subProductTable thead {
        display: none !important;
    }
    
    .subProductTable, 
    .subProductTable tbody, 
    .subProductTable tr {
        display: block !important;
        width: 100% !important;
    }
    
    .subProductTable tr {
        display: grid !important;
        grid-template-columns: 1fr auto !important;
        grid-template-rows: auto auto !important;
        row-gap: 8px !important;
        border-bottom: 1px solid #f1f5f9 !important;
        padding: 12px 0 !important;
        height: auto !important;
        align-items: center !important;
    }
    
    .subProductTable td {
        display: block !important;
        padding: 0 !important;
        border: none !important;
        height: auto !important;
        line-height: normal !important;
    }
    
    /* First TD: File Name */
    .subProductTable td:nth-child(1) {
        grid-column: 1 !important;
        grid-row: 1 !important;
        font-size: 0.9rem !important;
        font-weight: 500 !important;
        color: #222 !important;
        text-align: left !important;
    }
    
    /* Third TD: Action Buttons */
    .subProductTable td:nth-child(3) {
        grid-column: 2 !important;
        grid-row: 1 !important;
        display: flex !important;
        justify-content: flex-end !important;
        align-items: center !important;
        gap: 8px !important;
    }
    
    /* Second TD: File selector / Label */
    .subProductTable td:nth-child(2) {
        grid-column: 1 / span 2 !important;
        grid-row: 2 !important;
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        width: 100% !important;
    }
    
    /* Styling the file input on mobile to have button on left and native text on right */
    .subProductTable td:nth-child(2) input[type="file"] {
        width: 100% !important;
        font-size: 0.8rem !important;
        color: #717070 !important;
        cursor: pointer !important;
    }
    
    /* Override native display of file input on mobile for cleaner spacing */
    .subProductTable td:nth-child(2) input[type="file"]::file-selector-button {
        background-color: #f3f4f6 !important;
        color: #1f2937 !important;
        border: 1px solid #d1d5db !important;
        border-radius: 6px !important;
        padding: 6px 12px !important;
        font-size: 0.8rem !important;
        cursor: pointer !important;
        margin-right: 10px !important;
        transition: background-color 0.2s !important;
    }

    .subProductTable td:nth-child(2) input[type="file"]::file-selector-button:hover {
        background-color: #e5e7eb !important;
    }
    
    /* Style the uploaded file label to look like a button-label pair on mobile */
    .subProductTable td:nth-child(2) label {
        display: flex; /* No !important here so inline display:none style works */
        justify-content: space-between !important;
        align-items: center !important;
        width: 100% !important;
        background-color: transparent !important;
        border: none !important;
        padding: 0 !important;
        margin: 0 !important;
        font-size: 0.8rem !important;
        color: #4b5563 !important;
        /* overflow: hidden !important;
        word-break: break-all !important;
        white-space: normal !important; */
    }
    
    .subProductTable td:nth-child(2) label::before {
        content: "Choose File" !important;
        display: inline-block !important;
        background-color: #f3f4f6 !important;
        color: #1f2937 !important;
        border: 1px solid #d1d5db !important;
        border-radius: 6px !important;
        padding: 6px 12px !important;
        font-size: 0.8rem !important;
        margin-right: 10px !important;
        cursor: pointer !important;
        /* flex-shrink: 0 !important; */
    }

    /* Make product image tabs display on one scrollable row in mobile view */
    .navbarStylePaste .nav-tabs {
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        white-space: nowrap !important;
        -webkit-overflow-scrolling: touch !important;
    }
    .navbarStylePaste .nav-tabs::-webkit-scrollbar {
        display: none !important; /* Hide scrollbar */
    }
    .navbarStylePaste .nav-tabs .nav-item {
        flex-shrink: 0 !important;
    }

    /* Style Project Reference Link input on mobile */
    .sub-product-style .row:has(#new_product_reference_link) {
        border-bottom: none !important;
        margin-bottom: 0px !important;
        padding: 0 15px !important;
    }
    .sub-product-style div:has(> #new_product_reference_link) {
        padding-right: 0 !important;
        display: flex !important;
        flex-direction: column !important;
    }
    .sub-product-style div:has(> #new_product_reference_link)::before {
        content: "Project Reference Link" !important;
        display: block !important;
        font-size: 0.9rem !important;
        color: #333 !important;
        margin-bottom: 0.5rem !important;
        font-weight: 500 !important;
    }
    .sub-product-style input#new_product_reference_link {
        background-color: #fff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        padding: 10px 15px !important;
        height: 45px !important;
        color: #333 !important;
    }
    .sub-product-style input#new_product_reference_link::placeholder {
        color: #a0aec0 !important;
    }
}


</style>

<div class="sub-product-style">
    <form action="{{ route('create_product_temp') }}" method="post" enctype="multipart/form-data" id="product_create_form">
            @csrf

        <input type="hidden" id="product_id" name="product_id" value="{{ optional($project->current_product)->id }}" readonly>
        <input type="hidden" id="project_id" name="project_id" value="{{$project->id}}" readonly>
        <input type="hidden" id="new_product_no" name="new_product_no" value="{{ optional($project->current_product)->product_no }}" readonly>
        <input type="hidden" id="existence" value="{{$isExist}}">
        <input type="hidden" name="is_project_management" value="true">


        <div class="row mb-3" style="border-bottom: 1px solid #d3d3d3;border-radius: 0px;">

            @php
                $product_reference_link = optional($project->current_product)->product_reference_link;
            @endphp

            <div class="col-md-6 mb-2" style="padding-right: 2rem;">
                <input
                    placeholder="Product Reference Link"
                    value="{{ $product_reference_link }}"
                    style="border: none;border-bottom: 1px solid #d3d3d3;border-radius: 0px;color:#d3d3d3;background-color: transparent;"
                    type="text"
                    class="form-control form-input"
                    id="new_product_reference_link"
                    name="new_product_reference_link"
                >
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

                            @if ($project->product_level == 2)
                                <div class="col-md-12 mt-3">
                                    <label for="new_product_name" class="form-label">Main Product Name</label>
                                    <input type="text" class="form-control form-input" value="{{ $mainProduct->product_name }}" name="new_product_name" disabled>
                                </div>
                            @endif
        
                            <div class="col-md-12 mt-3">
                                <label for="new_product_name" class="form-label">
                                @if ($project->product_level == 1)
                                Name    
                                @else
                                Sub Product Name   
                                @endif</label>
                                <input type="text" class="form-control form-input" id="new_product_name" value="{{ $project->current_product->product_name }}" name="new_product_name">
                            </div>

                            <div class="col-md-12 mt-3">
                                <label for="new_product_name" class="form-label">Name Show in Catalog</label>
                                <input type="text" class="form-control form-input" id="show_in_catalog_name"
                                    value="{{ $project->current_product->show_in_catalog_name ?? $project->current_product->show_in_catalog_name}}"
                                    name="show_in_catalog_name">

                            </div>
                            

                            @php
                                $main_category_ids = optional($project->current_product)->main_category_id ?? [];

                                if (!is_array($main_category_ids)) {
                                    $main_category_ids = [$main_category_ids];
                                }
                            @endphp
                            @if ($project->product_level == 1)
                                <div class="col-md-12 mt-3 mb-1">
                                    <label for="new_main_category_id" class="form-label">Category</label>

                                    <select class="form-control form-input multy-selection category"
                                            id="new_main_category_id"
                                            name="new_main_category_id[]"
                                            multiple>

                                        @foreach ($mainCategories as $mainCategorie)
                                            <option value="{{ $mainCategorie->id }}"
                                                @if(in_array($mainCategorie->id, $main_category_ids)) selected @endif>

                                                {{ $mainCategorie->category_name }}

                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            @endif
                            

                            <div class="col-md-12 mt-3">
                                <label for="pattern_code" class="form-label">Pattern Code</label>
                                <input type="text" class="form-control form-input" id="pattern_code" value="{{ $project->current_product->pattern_code }}" name="pattern_code">
                            </div>

                            @if ($project->product_level == 2)
                            <div class="col-md-6 mt-3 mb-1">
                                <label for="standard_fabric" class="form-label">Fabric</label>
                                <select class="form-control form-input" id="standard_fabric" name="standard_fabric">
                                    <option value="null">Select Fabric</option>
                                    @foreach ($fabrics as $fabric)
                                        <option value="{{$fabric->id}}" {{ $fabric->id == $project->current_product->fabric_id ? 'selected' : '' }}>{{$fabric->fabric_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mt-3 mb-1">
                                <label for="sub_product_weight" class="form-label">Weight (oz)</label>
                                <input class="form-control form-input" value="{{$project->current_product->weight}}"  name="sub_product_weight" id="sub_product_weight" min="0.00" step="0.01" type='number'/>
                            </div>
                            @endif

                            @if ($project->product_level==1)
                            @php
                                $gender = optional($project->current_product)->gender;
                            @endphp

                            <div class="col-md-6 mt-3 mb-1">
                                <label for="new_gender" class="form-label">Gender</label>

                                <select class="form-control form-input" id="new_gender" name="new_gender">
                                    <option value="0">Select a Gender</option>

                                    <option value="Men" {{ $gender === 'Men' ? 'selected' : '' }}>Men's</option>
                                    <option value="Women" {{ $gender === 'Women' ? 'selected' : '' }}>Women's</option>
                                    <option value="Uni" {{ $gender === 'Uni' ? 'selected' : '' }}>Uni</option>
                                    <option value="Kids" {{ $gender === 'Kids' ? 'selected' : '' }}>Kids</option>
                                </select>
                            </div>


                            @php
                                $size_id = optional($project->current_product)->size_id;
                            @endphp

                            <div class="col-md-6 mt-3 mb-1">
                                <label for="new_size_id" class="form-label">Size</label>

                                <select class="form-control form-input" id="new_size_id" name="new_size_id">
                                    <option value="">Select a Size</option>

                                    @foreach ($sizeTypes as $sizeType)
                                        <option value="{{ $sizeType->id }}"
                                            {{ $size_id == $sizeType->id ? 'selected' : '' }}>

                                            {{ $sizeType->type_name }}

                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @php
                                $fits_true_to_size = optional($project->current_product)->fits_true_to_size ?: 3;
                            @endphp

                            <div class="col-md-6 mt-3 mb-1">
                                <label class="form-label">Fits true to size</label>

                                <div class="row ml-1" style="color: grey; font-size: .9rem;">

                                    <input class="fitsSizesRadioLayouts" type="radio" id="fitsSizes1" name="fitsSizes" value="1"
                                        {{ $fits_true_to_size == 1 ? 'checked' : '' }}>
                                    <label class="checkboxLable" for="fitsSizes1"></label>&nbsp;

                                    <input class="fitsSizesRadioLayouts" type="radio" id="fitsSizes2" name="fitsSizes" value="2"
                                        {{ $fits_true_to_size == 2 ? 'checked' : '' }}>
                                    <label class="checkboxLable" for="fitsSizes2"></label>&nbsp;

                                    <input class="fitsSizesRadioLayouts" type="radio" id="fitsSizes3" name="fitsSizes" value="3"
                                        {{ $fits_true_to_size == 3 ? 'checked' : '' }}>
                                    <label class="checkboxLable" for="fitsSizes3"></label>&nbsp;

                                    <input class="fitsSizesRadioLayouts" type="radio" id="fitsSizes4" name="fitsSizes" value="4"
                                        {{ $fits_true_to_size == 4 ? 'checked' : '' }}>
                                    <label class="checkboxLable" for="fitsSizes4"></label>&nbsp;

                                    <input class="fitsSizesRadioLayouts" type="radio" id="fitsSizes5" name="fitsSizes" value="5"
                                        {{ $fits_true_to_size == 5 ? 'checked' : '' }}>
                                    <label class="checkboxLable" for="fitsSizes5"></label>

                                    <span>&nbsp;&nbsp;Larger</span>
                                </div>
                            </div>

                            @php
                                $MOQ = optional($project->current_product)->MOQ;
                            @endphp

                            <div class="col-md-6 mt-3">
                                <label for="MOQ" class="form-label">MOQ</label>

                                <input 
                                    type="number" 
                                    class="form-control form-input" 
                                    id="MOQ" 
                                    value="{{ $MOQ }}" 
                                    name="MOQ"
                                >
                            </div>
                            @endif

                            @if ($project->product_level==2)
                            @php
                                $embellishmentIds = optional($project->current_product)->embellishment_options;

                                if (!is_array($embellishmentIds)) {
                                    $embellishmentIds = [];
                                }
                            @endphp

                            <div class="col-md-12 ">
                                <label for="embellishment_options" class="form-label">Embellishment Options</label>
                                <select class="form-control form-input multy-selection" id="embellishment_options" name="embellishment_options[]" multiple="multiple">
                                    @foreach ($embellishmentTypes as $embellishmentType)
                                        <option value="{{ $embellishmentType->id }}" {{ in_array($embellishmentType->id, $embellishmentIds) ? 'selected' : '' }}>
                                            {{ $embellishmentType->embellishment_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            @if ($project->product_level==1)
                            @php
                                $style_ids = optional($project->current_product)->product_category_id;

                                if (!is_array($style_ids)) {
                                    $style_ids = [];
                                }
                            @endphp

                            <div class="col-md-12 mt-3 mb-1">
                                <label for="new_product_category_id" class="form-label">Styles</label>

                                <select class="form-control form-input multy-selection"
                                        id="new_product_category_id"
                                        name="new_product_category_id[]"
                                        multiple="multiple">

                                    @foreach ($productCategories as $productCategory)
                                        <option value="{{ $productCategory->id }}"
                                            {{ in_array($productCategory->id, $style_ids) ? 'selected' : '' }}>

                                            {{ $productCategory->product_category_name }}

                                        </option>
                                    @endforeach

                                </select>
                            </div>
                            @endif


                            @if ($project->product_level==2)
                            @php
                                $color_ids = optional($project->current_product)->colorIds;

                                if (!is_array($color_ids)) {
                                    $color_ids = [];
                                }
                            @endphp

                            <div class="col-md-12 mt-3 mb-1">
                                <label class="form-label">Available Colors <span class="text-danger"></span></label><br>
                                <select class="form-control form-input multy-selection" id="new_available_colors" name="new_available_colors[]" multiple="multiple">
                                    @foreach ($colorMasters as $colorMaster)
                                        <option value="{{$colorMaster->id}}" data-hex="{{$colorMaster->hex}}" {{ in_array($colorMaster->id, $color_ids) ? 'selected' : '' }}>
                                            {{$colorMaster->pantone_code}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                             @endif

                            @if ($project->product_level==1)
                            @php
                                $sport_ids = optional($project->current_product)->sport_ids;

                                if (!is_array($sport_ids)) {
                                    $sport_ids = [];
                                }
                            @endphp

                            <div class="col-md-12 mt-3 mb-1">
                                <label for="new_sport" class="form-label">Sport</label>

                                <select class="form-control form-input multy-selection"
                                        id="new_sport"
                                        name="new_sport[]"
                                        multiple="multiple">

                                    @foreach ($sports as $sport)
                                        <option value="{{ $sport->id }}"
                                            {{ in_array($sport->id, $sport_ids) ? 'selected' : '' }}>

                                            {{ $sport->sport_name }}

                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            @php
                                $attribute_ids = optional($project->current_product)->product_attribute_ids;

                                if (!is_array($attribute_ids)) {
                                    $attribute_ids = [];
                                }
                            @endphp
                            

                            <div class="col-md-12 mt-3 mb-1">
                                <label for="new_product_attribute_id" class="form-label">Attributes</label>

                                <select class="form-control form-input multy-selection"
                                        id="new_product_attribute_id"
                                        name="new_product_attribute_id[]"
                                        multiple="multiple">

                                    @foreach ($productAttributes as $productAttribute)
                                        <option value="{{ $productAttribute->id }}"
                                            {{ in_array($productAttribute->id, $attribute_ids) ? 'selected' : '' }}>

                                            {{ $productAttribute->attribute_name }} {{'(+$'.$productAttribute->price.')'}}

                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            @php
                                $attribute_on_price_ids = optional($project->current_product)->attribute_on_price;

                                if (!is_array($attribute_on_price_ids)) {
                                    $attribute_on_price_ids = [];
                                }
                            @endphp

                            <div class="col-md-12">
                                <label for="attribute_on_price" class="form-label">
                                    Attributes Included in Unit Price
                                </label>

                                <select class="form-control multi-selection"
                                        id="attribute_on_price"
                                        name="attribute_on_price[]"
                                        multiple="multiple">

                                    @foreach ($productAttributes as $productAttribute)
                                        <option value="{{ $productAttribute->id }}"
                                            {{ in_array($productAttribute->id, $attribute_on_price_ids) ? 'selected' : '' }}>

                                            {{ $productAttribute->attribute_name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            @if ($project->product_level==1)

                            @php
                                $factory_ids = optional($project->current_product)->product_factory_ids;

                                if (!is_array($factory_ids)) {
                                    $factory_ids = [];
                                }
                            @endphp

                            <div class="col-md-12 mt-3 mb-1">
                                <label for="new_product_factory_id" class="form-label">Factories</label>

                                <select class="form-control form-input multy-selection"
                                        id="new_product_factory_id"
                                        name="new_product_factory_id[]"
                                        multiple="multiple">

                                    @foreach ($factories as $factory)
                                        <option value="{{ $factory->id }}"
                                            {{ in_array($factory->id, $factory_ids) ? 'selected' : '' }}>

                                            {{ $factory->factory_code }}

                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            @php
                                $tagline_ids = optional($project->current_product)->product_tagline_ids;

                                if (!is_array($tagline_ids)) {
                                    $tagline_ids = [];
                                }
                            @endphp

                            <div class="col-md-12 mt-3 mb-1">
                                <label for="product_tagline_id" class="form-label">
                                    Available Product Taglines
                                </label>

                                <select class="form-control form-input multy-selection"
                                        id="product_tagline_id"
                                        name="product_tagline_id[]"
                                        multiple="multiple">

                                    @foreach ($productTaglines as $productTagline)
                                        <option value="{{ $productTagline->id }}"
                                            {{ in_array($productTagline->id, $tagline_ids) ? 'selected' : '' }}>

                                            {{ $productTagline->tagline_name }}

                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            @php
                                $fit_ids = optional($project->current_product)->product_fit_ids;

                                if (!is_array($fit_ids)) {
                                    $fit_ids = [];
                                }
                            @endphp

                            <div class="col-md-12 mt-3 mb-1">
                                <label for="product_fit_id" class="form-label">Available Fits</label>

                                <select class="form-control form-input multy-selection"
                                        id="product_fit_id"
                                        name="product_fit_id[]"
                                        multiple="multiple">

                                    @foreach ($masterFits as $masterFit)
                                        <option value="{{ $masterFit->id }}"
                                            {{ in_array($masterFit->id, $fit_ids) ? 'selected' : '' }}>

                                            {{ $masterFit->fit_name }}

                                        </option>
                                    @endforeach

                                </select>
                            </div>
                            @endif

                            <div class="col-md-12 mt-3 mb-1">
                                <label for="new_notes" class="form-label">Note</label>

                                <textarea style="height: 40px;"
                                        class="form-control form-input"
                                        id="new_notes"
                                        name="new_notes"
                                        rows="3">{{ optional($project->current_product)->notes }}</textarea>
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
                                <img @if( optional($project->current_product)->mockup_img_1 !== null) src="{{ asset('assets') }}{{ optional($project->current_product)->mockup_img_1 }}" @else src="{{ asset('public/images/default.png') }}" @endif id="imagePreviewArea" alt="Image" style="width: 100%;height: auto;border: 2px solid #f9f9f9;">
                            </div>
                            <div class="col-md-4 pl">
                                <!-- Front Image -->
                                @php
                                    $frontImage = optional($project->current_product)->mockup_img_1;
                                @endphp

                                <div class="col-md-12" style="padding: 0rem">
                                    <label class="form-label" style="font-weight:700">Front image</label>

                                    {{-- UPLOAD AREA --}}
                                    <label for="front_image"
                                        id="front_image_upload_area"
                                        class="upload-area"
                                        @if($frontImage === null)
                                            style="display: block;"
                                        @else
                                            style="display: none;"
                                        @endif>

                                        <i class="fa fa-cloud-upload" style="font-size: 2rem; color:#b3b3b3"></i>

                                        <div class="upload-icon">
                                            <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD IMAGE</i><br>
                                            <p style="color: #ff0000;font-size: .8rem;">590px x 798px</p>
                                        </div>
                                    </label>

                                    {{-- DISPLAY AREA --}}
                                    <label for="front_image"
                                        id="front_image_display_area"
                                        class="upload-area"
                                        @if($frontImage !== null)
                                            style="display: block;"
                                        @else
                                            style="display: none;"
                                        @endif>

                                        <img src="{{ $frontImage ? asset('assets'.$frontImage) : asset('public/images/default.png') }}"
                                            id="front_image_uploaded"
                                            alt="Image"
                                            style="width: auto;height: 100%;border: 2px solid #f9f9f9;">

                                        <button type="button"
                                                onclick="removeImagePreview('front_image')"
                                                class="close-button">X</button>
                                    </label>

                                    <input type="file"
                                        id="front_image"
                                        name="front_image"
                                        onchange="imageDisplay(this , 'front_image')"
                                        class="file-select"
                                        accept="image/*"
                                        style="display: none">

                                    <div style="display: flex; align-items: center;">
                                        <button type="button"
                                                title="Upload Image"
                                                class="functionalities_front_image"
                                                onclick="uploadImages('front_image', 'mockup', 'Mockup - Front Side', 'mockup_img_1')"
                                                style="display: none;">
                                            <i class="fa fa-cloud-upload" id="front_image_upload"></i>
                                            <i class="fas fa-spinner fa-spin"
                                            id="front_image_loading"
                                            style="display: none"></i>
                                        </button>

                                        <div class="row" style="margin: unset;">
                                            <button type="button"
                                                    title="Preview Image"
                                                    class="text-right functionalities_front_image"
                                                    onclick="previewImg('front_image')"
                                                    @if($frontImage !== null)
                                                        style="display: block;"
                                                    @else
                                                        style="display: none;"
                                                    @endif>
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            @if ($project->product_level == 1)
                                            <button type="button"
                                                    title="Image Caption"
                                                    class="text-right functionalities_front_image image_caption"
                                                    @if($frontImage !== null)
                                                        style="display: block;"
                                                        onclick="openModal('{{ asset('assets'.$frontImage) }}', '{{ optional($project->current_product)->id }}', 'mockup_img_1')"
                                                    @else
                                                        style="display: none;"
                                                    @endif>
                                                <img src="{{ asset('assets/img/products/text_icon.png') }}"
                                                    alt="image"
                                                    style="width: 21px;"
                                                    class="image_width">
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Side Image -->
                                @php
                                    $sideImage = optional($project->current_product)->mockup_img_2;
                                @endphp

                                <div class="col-md-12" style="padding: 0rem">
                                    <label class="form-label" style="font-weight:700">Side image</label>

                                    {{-- UPLOAD AREA --}}
                                    <label for="side_image"
                                        id="side_image_upload_area"
                                        class="upload-area"
                                        @if($sideImage === null)
                                            style="display: block;"
                                        @else
                                            style="display: none;"
                                        @endif>

                                        <i class="fa fa-cloud-upload" style="font-size: 2rem; color:#b3b3b3"></i>

                                        <div class="upload-icon">
                                            <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD IMAGE</i><br>
                                            <p style="color: #ff0000;font-size: .8rem;">590px x 798px</p>
                                        </div>
                                    </label>

                                    {{-- DISPLAY AREA --}}
                                    <label for="side_image"
                                        id="side_image_display_area"
                                        class="upload-area"
                                        @if($sideImage !== null)
                                            style="display: block;"
                                        @else
                                            style="display: none;"
                                        @endif>

                                        <img src="{{ $sideImage ? asset('assets'.$sideImage) : asset('public/images/default.png') }}"
                                            id="side_image_uploaded"
                                            alt="Image"
                                            style="width: auto;height: 100%;border: 2px solid #f9f9f9;">

                                        <button type="button"
                                                onclick="removeImagePreview('side_image')"
                                                class="close-button">X</button>
                                    </label>

                                    <input type="file"
                                        id="side_image"
                                        name="side_image"
                                        onchange="imageDisplay(this , 'side_image')"
                                        class="file-select"
                                        accept="image/*"
                                        style="display: none">

                                    <div style="display: flex; align-items: center;">

                                        <button type="button"
                                                title="Upload Image"
                                                class="functionalities_side_image"
                                                onclick="uploadImages('side_image', 'mockup', 'Mockup - Side', 'mockup_img_2')"
                                                style="display: none;">
                                            <i class="fa fa-cloud-upload" id="side_image_upload"></i>
                                            <i class="fas fa-spinner fa-spin"
                                            id="side_image_loading"
                                            style="display: none"></i>
                                        </button>

                                        <button type="button"
                                                title="Preview Image"
                                                class="text-right functionalities_side_image"
                                                onclick="previewImg('side_image')"
                                                @if($sideImage !== null)
                                                    style="display: block;"
                                                @else
                                                    style="display: none;"
                                                @endif>
                                            <i class="fa fa-eye"></i>
                                        </button>

                                        @if ($project->product_level == 1)
                                        <button type="button"
                                                title="Image Caption"
                                                class="text-right functionalities_side_image image_caption"
                                                @if($sideImage !== null)
                                                    style="display: block;"
                                                    onclick="openModal('{{ asset('assets'.$sideImage) }}', '{{ optional($project->current_product)->id }}', 'mockup_img_2')"
                                                @else
                                                    style="display: none;"
                                                @endif>
                                            <img src="{{ asset('assets/img/products/text_icon.png') }}"
                                                alt="image"
                                                style="width: 21px;"
                                                class="image_width">
                                        </button>
                                        @endif

                                    </div>
                                </div>

                                <!-- Back Image -->
                                @php
                                    $backImage = optional($project->current_product)->mockup_img_3;
                                @endphp

                                <div class="col-md-12" style="padding: 0rem">
                                    <label class="form-label" style="font-weight:700">Back image</label>

                                    {{-- UPLOAD AREA --}}
                                    <label for="back_image"
                                        id="back_image_upload_area"
                                        class="upload-area"
                                        @if($backImage === null)
                                            style="display: block;"
                                        @else
                                            style="display: none;"
                                        @endif>

                                        <i class="fa fa-cloud-upload" style="font-size: 2rem; color:#b3b3b3"></i>

                                        <div class="upload-icon">
                                            <i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"> UPLOAD IMAGE</i><br>
                                            <p style="color: #ff0000;font-size: .8rem;">590px x 798px</p>
                                        </div>
                                    </label>

                                    {{-- DISPLAY AREA --}}
                                    <label for="back_image"
                                        id="back_image_display_area"
                                        class="upload-area"
                                        @if($backImage !== null)
                                            style="display: block;"
                                        @else
                                            style="display: none;"
                                        @endif>

                                        <img src="{{ $backImage ? asset('assets'.$backImage) : asset('public/images/default.png') }}"
                                            id="back_image_uploaded"
                                            alt="Image"
                                            style="width: auto;height: 100%;border: 2px solid #f9f9f9;">

                                        <button type="button"
                                                onclick="removeImagePreview('back_image')"
                                                class="close-button">X</button>
                                    </label>

                                    <input type="file"
                                        id="back_image"
                                        name="back_image"
                                        onchange="imageDisplay(this , 'back_image')"
                                        class="file-select"
                                        accept="image/*"
                                        style="display: none">

                                    <div style="display: flex; align-items: center;">

                                        <button type="button"
                                                title="Upload Image"
                                                class="functionalities_back_image"
                                                onclick="uploadImages('back_image', 'mockup', 'Mockup - Back Side', 'mockup_img_3')"
                                                style="display: none;">
                                            <i class="fa fa-cloud-upload" id="back_image_upload"></i>
                                            <i class="fas fa-spinner fa-spin"
                                            id="back_image_loading"
                                            style="display: none"></i>
                                        </button>

                                        <button type="button"
                                                title="Preview Image"
                                                class="text-right functionalities_back_image"
                                                onclick="previewImg('back_image')"
                                                @if($backImage !== null)
                                                    style="display: block;"
                                                @else
                                                    style="display: none;"
                                                @endif>
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        @if ($project->product_level == 1)
                                        <button type="button"
                                                title="Image Caption"
                                                class="text-right functionalities_back_image image_caption"
                                                @if($backImage !== null)
                                                    style="display: block;"
                                                    onclick="openModal('{{ asset('assets'.$backImage) }}', '{{ optional($project->current_product)->id }}', 'mockup_img_3')"
                                                @else
                                                    style="display: none;"
                                                @endif>
                                            <img src="{{ asset('assets/img/products/text_icon.png') }}"
                                                alt="image"
                                                style="width: 21px;"
                                                class="image_width">
                                        </button>
                                        @endif

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
                                                                        @if ($project->product_level == 1)
                                                                        <button type="button" title="Image Caption" class="text-right functionalities_front_image image_caption"
                                                                            onclick="openImageModal('{{ asset($productImage->image_link) }}', '{{ optional($project->current_product)->id }}', '{{ $productImage->id }}')">
                                                                            <img src="{{ asset('assets/img/products/text_icon.png') }}" alt="image" style="width: 21px; color:black" class="image_width">
                                                                        </button>
                                                                        @endif

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
                                                <p style="color: #ff0000;font-size: .8rem;">Maximum file size: 1MB with a resolution of 590p x 798px.</p>
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
                                                                        @if ($project->product_level == 1)
                                                                        <button type="button" title="Image Caption" class="text-right functionalities_front_image image_caption"
                                                                            onclick="openImageModal('{{ asset($productImage->image_link) }}', '{{ optional($project->current_product)->id }}', '{{ $productImage->id }}')">
                                                                            <img src="{{ asset('assets/img/products/text_icon.png') }}" alt="image" style="width: 21px; color:black" class="image_width">
                                                                        </button>
                                                                         @endif

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
                                                                        @if ($project->product_level == 1)
                                                                        <button type="button" title="Image Caption" class="text-right functionalities_front_image image_caption"
                                                                            onclick="openImageModal('{{ asset($productImage->image_link) }}', '{{ optional($project->current_product)->id }}', '{{ $productImage->id }}')">
                                                                            <img src="{{ asset('assets/img/products/text_icon.png') }}" alt="image" style="width: 21px; color:black" class="image_width">
                                                                        </button>
                                                                        @endif

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
                                                                        @if ($project->product_level == 1)
                                                                        <button type="button" title="Image Caption" class="text-right functionalities_front_image image_caption"
                                                                            onclick="openImageModal('{{ asset($productImage->image_link) }}', '{{ optional($project->current_product)->id }}', '{{ $productImage->id }}')">
                                                                            <img src="{{ asset('assets/img/products/text_icon.png') }}" alt="image" style="width: 21px; color:black" class="image_width">
                                                                        </button>
                                                                        @endif

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
                                                                        @if ($project->product_level == 1)   
                                                                        <button type="button" title="Image Caption" class="text-right functionalities_front_image image_caption"
                                                                            onclick="openImageModal('{{ asset($productImage->image_link) }}', '{{ optional($project->current_product)->id }}', '{{ $productImage->id }}')">
                                                                            <img src="{{ asset('assets/img/products/text_icon.png') }}" alt="image" style="width: 21px; color:black" class="image_width">
                                                                        </button>
                                                                        @endif

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
                                            @if ($project->product_level==1)
                                            @can('view_2D_Mockup_Template')
                                            @php
                                                $twoDMockup = optional($project->current_product)->{'2D_mockup'};
                                            @endphp

                                            <tr>
                                                <td>2D Mockup Template</td>

                                                <td>
                                                    <input type="file"
                                                        id="2D_mockup_template"
                                                        name="2D_mockup_template"
                                                        onchange="buttonEnableFunc('2D_mockup_template')"
                                                        class="file-select"
                                                        @if($twoDMockup && !Str::startsWith($twoDMockup, 'http'))
                                                            style="display:none"
                                                        @endif>

                                                    <label for="2D_mockup_template"
                                                        style="margin-bottom: 0rem; color: black; background-color: #efefef; padding: .1rem .5rem; border-radius: .5rem; cursor: pointer;
                                                        @if(!$twoDMockup || Str::startsWith($twoDMockup, 'http'))
                                                            display:none;
                                                        @endif">

                                                        {{ $twoDMockup ? basename($twoDMockup) : '' }}

                                                    </label>
                                                </td>

                                                <td class="text-center">

                                                    @can('upload_2D_Mockup_Template')

                                                    <button disabled
                                                        class="uploadStyles"
                                                        type="button"
                                                        title="Upload"
                                                        onclick="uploadImages('2D_mockup_template', '2D_mockup', '2D Mockup Template' , '2D_mockup')"
                                                        id="2D_mockup_template_uploading"
                                                        style="border-right: 2px solid #b3b3b3">

                                                        <i class="fa fa-cloud-upload" id="2D_mockup_template_upload"></i>
                                                        <i class="fas fa-spinner fa-spin"
                                                        id="2D_mockup_template_loading"
                                                        style="display: none"></i>
                                                    </button>

                                                    @else
                                                    <button class="uploadStyles"
                                                        type="button"
                                                        title="Upload"
                                                        onclick="showPermissionError(`You do not have permission to upload 2D Mockup Templates.`)"
                                                        disabled
                                                        style="border-right: 2px solid #b3b3b3">

                                                        <i class="fa fa-cloud-upload"></i>
                                                        <i class="fas fa-spinner fa-spin"
                                                        style="display: none"></i>
                                                    </button>
                                                    @endcan

                                                    <button type="button"
                                                            id="2D_mockup_template_downloading"
                                                            title="Download"
                                                            class="downloadStyles"
                                                            @if(!$twoDMockup)
                                                                disabled
                                                            @else
                                                                onclick="window.location.href='{{ asset('assets') }}{{ $twoDMockup }}'"
                                                            @endif>
                                                        <i class="fa fa-cloud-download"></i>
                                                    </button>

                                                </td>
                                            </tr>

                                            @endcan
                                            @endif
                                            
                                            @if ($project->product_level==1)
                                            @can('view_3D_Mockup_Template')
                                                @php
                                                    $threeDMockup = optional($project->current_product)->{'3D_mockup'};
                                                @endphp

                                                <tr>
                                                    <td>3D Mockup Template</td>

                                                    <td>
                                                        <input type="file"
                                                            id="3D_mockup_template"
                                                            name="3D_mockup_template"
                                                            onchange="buttonEnableFunc('3D_mockup_template')"
                                                            class="file-select"
                                                            @if($threeDMockup && !Str::startsWith($threeDMockup, 'http'))
                                                                style="display:none"
                                                            @endif>

                                                        <label for="3D_mockup_template"
                                                            style="margin-bottom: 0rem; color: black; background-color: #efefef; padding: .1rem .5rem; border-radius: .5rem; cursor: pointer;
                                                            @if(!$threeDMockup || Str::startsWith($threeDMockup, 'http'))
                                                                display:none;
                                                            @endif">

                                                            {{ $threeDMockup ? basename($threeDMockup) : '' }}

                                                        </label>
                                                    </td>

                                                    <td class="text-center">

                                                        @can('upload_3D_Mockup_Template')

                                                            <button disabled
                                                                class="uploadStyles"
                                                                type="button"
                                                                title="Upload"
                                                                onclick="uploadImages('3D_mockup_template', '3D_mockup', '3D Mockup Template', '3D_mockup')"
                                                                id="3D_mockup_template_uploading"
                                                                style="border-right: 2px solid #b3b3b3">

                                                                <i class="fa fa-cloud-upload" id="3D_mockup_template_upload"></i>
                                                                <i class="fas fa-spinner fa-spin"
                                                                id="3D_mockup_template_loading"
                                                                style="display: none"></i>
                                                            </button>

                                                        @else

                                                            <button class="uploadStyles"
                                                                type="button"
                                                                title="Upload"
                                                                onclick="showPermissionError(`You do not have permission to upload 3D Mockup Templates.`)"
                                                                disabled
                                                                style="border-right: 2px solid #b3b3b3">

                                                                <i class="fa fa-cloud-upload"></i>
                                                                <i class="fas fa-spinner fa-spin"
                                                                style="display: none"></i>
                                                            </button>

                                                        @endcan


                                                        <button type="button"
                                                            id="3D_mockup_template_downloading"
                                                            title="Download"
                                                            class="downloadStyles"
                                                            @if(!$threeDMockup)
                                                                disabled
                                                            @else
                                                                onclick="window.location.href='{{ asset('assets') }}{{ $threeDMockup }}'"
                                                            @endif>
                                                            <i class="fa fa-cloud-download"></i>
                                                        </button>

                                                    </td>
                                                </tr>

                                            @endcan
                                            @endif

                                            @if ($project->product_level==1)
                                            @can('view_Design_Tech_Pack')
                                            @php
                                                $techPack = optional($project->current_product)->tech_pack;
                                            @endphp

                                            <tr>
                                                <td>Design Tech Pack</td>

                                                <td>
                                                    <input type="file"
                                                        id="design_tech_pack"
                                                        name="design_tech_pack"
                                                        onchange="buttonEnableFunc('design_tech_pack')"
                                                        class="file-select"
                                                        @if($techPack && !Str::startsWith($techPack, 'http'))
                                                            style="display:none"
                                                        @endif>

                                                    <label for="design_tech_pack"
                                                        style="margin-bottom: 0rem; color: black; background-color: #efefef; padding: .1rem .5rem; border-radius: .5rem; cursor: pointer;
                                                        @if(!$techPack || Str::startsWith($techPack, 'http'))
                                                            display:none;
                                                        @endif">

                                                        {{ $techPack ? basename($techPack) : '' }}

                                                    </label>
                                                </td>

                                                <td class="text-center">

                                                    @can('upload_Design_Tech_Pack')

                                                        <button disabled
                                                            class="uploadStyles"
                                                            type="button"
                                                            title="Upload"
                                                            onclick="uploadImages('design_tech_pack', 'tech_pack', 'Design Tech Pack', 'tech_pack')"
                                                            id="design_tech_pack_uploading"
                                                            style="border-right: 2px solid #b3b3b3">

                                                            <i class="fa fa-cloud-upload" id="design_tech_pack_upload"></i>
                                                            <i class="fas fa-spinner fa-spin"
                                                            id="design_tech_pack_loading"
                                                            style="display: none"></i>
                                                        </button>

                                                    @else

                                                        <button class="uploadStyles"
                                                            type="button"
                                                            title="Upload"
                                                            onclick="showPermissionError('You do not have permission to upload Design Tech Packs.')"
                                                            disabled
                                                            style="border-right: 2px solid #b3b3b3">

                                                            <i class="fa fa-cloud-upload"></i>
                                                            <i class="fas fa-spinner fa-spin"
                                                            style="display: none"></i>
                                                        </button>

                                                    @endcan


                                                    <button type="button"
                                                            id="design_tech_pack_downloading"
                                                            title="Download"
                                                            class="downloadStyles"
                                                            @if(!$techPack)
                                                                disabled
                                                            @else
                                                                onclick="window.location.href='{{ asset('assets') }}{{ $techPack }}'"
                                                            @endif>
                                                        <i class="fa fa-cloud-download"></i>
                                                    </button>

                                                </td>
                                            </tr>

                                            @endcan 
                                            @endif
                                            
                                            @if ($project->product_level==1)
                                            @can('view_Measurement_Chart')
                                            @php
                                                $measurement = optional($project->current_product)->measurement;
                                            @endphp

                                            <tr>
                                                <td>Measurement Chart</td>

                                                <td>
                                                    <input type="file"
                                                        id="measurement_chart"
                                                        name="measurement_chart"
                                                        onchange="buttonEnableFunc('measurement_chart')"
                                                        class="file-select"
                                                        @if($measurement && !Str::startsWith($measurement, 'http'))
                                                            style="display:none"
                                                        @endif>

                                                    <label for="measurement_chart"
                                                        style="margin-bottom: 0rem; color: black; background-color: #efefef; padding: .1rem .5rem; border-radius: .5rem; cursor: pointer;
                                                        @if(!$measurement || Str::startsWith($measurement, 'http'))
                                                            display:none;
                                                        @endif">

                                                        {{ $measurement ? basename($measurement) : '' }}

                                                    </label>
                                                </td>

                                                <td class="text-center">

                                                    @can('upload_Measurement_Chart')

                                                        <button disabled
                                                            class="uploadStyles"
                                                            type="button"
                                                            title="Upload"
                                                            onclick="uploadImages('measurement_chart', 'measurement', 'Measurement Chart', 'measurement')"
                                                            id="measurement_chart_uploading"
                                                            style="border-right: 2px solid #b3b3b3">

                                                            <i class="fa fa-cloud-upload" id="measurement_chart_upload"></i>
                                                            <i class="fas fa-spinner fa-spin"
                                                            id="measurement_chart_loading"
                                                            style="display: none"></i>
                                                        </button>

                                                    @else

                                                        <button class="uploadStyles"
                                                            type="button"
                                                            title="Upload"
                                                            onclick="showPermissionError('You do not have permission to upload Measurement Charts.')"
                                                            disabled
                                                            style="border-right: 2px solid #b3b3b3">

                                                            <i class="fa fa-cloud-upload"></i>
                                                            <i class="fas fa-spinner fa-spin"
                                                            style="display: none"></i>
                                                        </button>

                                                    @endcan


                                                    <button type="button"
                                                        id="measurement_chart_downloading"
                                                        title="Download"
                                                        class="downloadStyles"
                                                        @if(!$measurement)
                                                            disabled
                                                        @else
                                                            onclick="window.location.href='{{ asset('assets') }}{{ $measurement }}'"
                                                        @endif>
                                                        <i class="fa fa-cloud-download"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endcan
                                            @endif

                                            @if ($project->product_level==1)
                                            @can('view_Production_Layout')
                                            @php
                                                $product_layout = optional($project->current_product)->product_layout;
                                            @endphp

                                            <tr>
                                                <td>Production Layout</td>

                                                <td>
                                                    <input type="file"
                                                        id="production_layouts"
                                                        name="production_layouts"
                                                        onchange="buttonEnableFunc('production_layouts')"
                                                        class="file-select"
                                                        @if($product_layout && !Str::startsWith($product_layout, 'http'))
                                                            style="display:none"
                                                        @endif>

                                                    <label for="production_layouts"
                                                        style="margin-bottom: 0rem; color: black; background-color: #efefef; padding: .1rem .5rem; border-radius: .5rem; cursor: pointer;
                                                        @if(!$product_layout || Str::startsWith($product_layout, 'http'))
                                                            display:none;
                                                        @endif">

                                                        {{ $product_layout ? basename($product_layout) : '' }}

                                                    </label>
                                                </td>

                                                <td class="text-center">

                                                    @can('upload_Production_Layout')

                                                        <button disabled
                                                            class="uploadStyles"
                                                            type="button"
                                                            title="Upload"
                                                            onclick="uploadImages('production_layouts', 'product_layout', 'Production Layout', 'product_layout')"
                                                            id="production_layouts_uploading"
                                                            style="border-right: 2px solid #b3b3b3">

                                                            <i class="fa fa-cloud-upload" id="production_layouts_upload"></i>
                                                            <i class="fas fa-spinner fa-spin"
                                                            id="production_layouts_loading"
                                                            style="display: none"></i>

                                                            <div class="loading-icon"></div>
                                                        </button>

                                                    @else

                                                        <button class="uploadStyles"
                                                            type="button"
                                                            title="Upload"
                                                            onclick="showPermissionError('You do not have permission to upload Production Layouts.')"
                                                            disabled
                                                            style="border-right: 2px solid #b3b3b3">

                                                            <i class="fa fa-cloud-upload"></i>
                                                            <i class="fas fa-spinner fa-spin"
                                                            style="display: none"></i>

                                                            <div class="loading-icon"></div>
                                                        </button>

                                                    @endcan


                                                    <button type="button"
                                                        id="production_layouts_downloading"
                                                        title="Download"
                                                        class="downloadStyles"
                                                        @if(!$product_layout)
                                                            disabled
                                                        @else
                                                            onclick="window.location.href='{{ asset('assets') }}{{ $product_layout }}'"
                                                        @endif>
                                                        <i class="fa fa-cloud-download"></i>
                                                    </button>

                                                </td>
                                            </tr>
                                            @endcan
                                            @endif

                                           
                                            @can('view_Technical_Tech_Pack')
                                            @php
                                                $technical_tech_pack = optional($project->current_product)->technical_tech_pack;
                                            @endphp

                                            <tr>
                                                <td>Technical Tech Pack</td>

                                                <td>
                                                    <input type="file"
                                                        id="technical_tech_pack"
                                                        name="technical_tech_pack"
                                                        onchange="buttonEnableFunc('technical_tech_pack')"
                                                        class="file-select"
                                                        @if($technical_tech_pack && !Str::startsWith($technical_tech_pack, 'http'))
                                                            style="display:none"
                                                        @endif>

                                                    <label for="technical_tech_pack"
                                                        style="margin-bottom: 0rem; color: black; background-color: #efefef; padding: .1rem .5rem; border-radius: .5rem; cursor: pointer;
                                                        @if(!$technical_tech_pack || Str::startsWith($technical_tech_pack, 'http'))
                                                            display:none;
                                                        @endif">

                                                        {{ $technical_tech_pack ? basename($technical_tech_pack) : '' }}

                                                    </label>
                                                </td>

                                                <td class="text-center">

                                                    @can('upload_Technical_Tech_Pack')

                                                        <button disabled
                                                            class="uploadStyles"
                                                            type="button"
                                                            title="Upload"
                                                            onclick="uploadImages(
                                                                'technical_tech_pack',
                                                                'technical_tech_pack',
                                                                'Technical Tech Pack',
                                                                'technical_tech_pack'
                                                            )"
                                                            id="technical_tech_pack_uploading"
                                                            style="border-right: 2px solid #b3b3b3">

                                                            <i class="fa fa-cloud-upload" id="technical_tech_pack_upload"></i>
                                                            <i class="fas fa-spinner fa-spin"
                                                            id="technical_tech_pack_loading"
                                                            style="display: none"></i>

                                                            <div class="loading-icon"></div>
                                                        </button>

                                                    @else

                                                        <button class="uploadStyles"
                                                            type="button"
                                                            title="Upload"
                                                            onclick="showPermissionError('You do not have permission to upload Technical Tech Packs.')"
                                                            disabled
                                                            style="border-right: 2px solid #b3b3b3">

                                                            <i class="fa fa-cloud-upload"></i>
                                                            <i class="fas fa-spinner fa-spin"
                                                            style="display: none"></i>

                                                            <div class="loading-icon"></div>
                                                        </button>

                                                    @endcan


                                                    <button type="button"
                                                        id="technical_tech_pack_downloading"
                                                        title="Download"
                                                        class="downloadStyles"
                                                        @if(!$technical_tech_pack)
                                                            disabled
                                                        @else
                                                            onclick="window.location.href='{{ asset('assets') }}{{ $technical_tech_pack }}'"
                                                        @endif>
                                                        <i class="fa fa-cloud-download"></i>
                                                    </button>

                                                </td>
                                            </tr>

                                            @endcan

                                            @can('view_Pattern_Files')
                                            @php
                                                $pattern_file = optional($project->current_product)->pattern;
                                            @endphp

                                            <tr>
                                                <td>Pattern Files</td>

                                                <td>
                                                    <input type="file"
                                                        id="pattern_file"
                                                        name="pattern_file"
                                                        onchange="buttonEnableFunc('pattern_file')"
                                                        class="file-select"
                                                        @if($pattern_file && !Str::startsWith($pattern_file, 'http'))
                                                            style="display:none"
                                                        @endif>

                                                    <label for="pattern_file"
                                                        style="margin-bottom: 0rem;
                                                            color: black;
                                                            background-color: #efefef;
                                                            padding: .1rem .5rem;
                                                            border-radius: .5rem;
                                                            cursor: pointer;
                                                        @if(!$pattern_file || Str::startsWith($pattern_file, 'http'))
                                                            display:none;
                                                        @endif">

                                                        {{ $pattern_file ? basename($pattern_file) : '' }}

                                                    </label>
                                                </td>

                                                <td class="text-center">

                                                    @can('upload_Pattern_Files')

                                                        <button disabled
                                                            class="uploadStyles"
                                                            type="button"
                                                            title="Upload"
                                                            onclick="uploadImages(
                                                                'pattern_file',
                                                                'pattern_file',
                                                                'Pattern File',
                                                                'pattern'
                                                            )"
                                                            id="pattern_file_uploading"
                                                            style="border-right: 2px solid #b3b3b3">

                                                            <i class="fa fa-cloud-upload" id="pattern_file_upload"></i>
                                                            <i class="fas fa-spinner fa-spin"
                                                            id="pattern_file_loading"
                                                            style="display: none"></i>

                                                            <div class="loading-icon"></div>
                                                        </button>

                                                    @else

                                                        <button class="uploadStyles"
                                                            type="button"
                                                            title="Upload"
                                                            onclick="showPermissionError('You do not have permission to upload Pattern Files.')"
                                                            disabled
                                                            style="border-right: 2px solid #b3b3b3">

                                                            <i class="fa fa-cloud-upload"></i>
                                                            <i class="fas fa-spinner fa-spin"
                                                            style="display: none"></i>

                                                            <div class="loading-icon"></div>
                                                        </button>

                                                    @endcan


                                                    <button type="button"
                                                        id="pattern_file_downloading"
                                                        title="Download"
                                                        class="downloadStyles"
                                                        @if(!$pattern_file)
                                                            disabled
                                                        @else
                                                            onclick="window.location.href='{{ asset('assets') }}{{ $pattern_file }}'"
                                                        @endif>
                                                        <i class="fa fa-cloud-download"></i>
                                                    </button>

                                                </td>
                                            </tr>
                                            @endcan

                                            @can('view_size_chart')
                                            @php
                                                $size_chart = optional($project->current_product)->size_chart;
                                            @endphp

                                            <tr>
                                                <td>Size Chart</td>

                                                <td>
                                                    <input type="file"
                                                        id="size_chart"
                                                        name="size_chart"
                                                        onchange="buttonEnableFunc('size_chart')"
                                                        class="file-select"
                                                        @if($size_chart && !Str::startsWith($size_chart, 'http'))
                                                            style="display:none"
                                                        @endif>

                                                    <label for="size_chart"
                                                        style="margin-bottom: 0rem;
                                                            color: black;
                                                            background-color: #efefef;
                                                            padding: .1rem .5rem;
                                                            border-radius: .5rem;
                                                            cursor: pointer;
                                                        @if(!$size_chart || Str::startsWith($size_chart, 'http'))
                                                            display:none;
                                                        @endif">

                                                        {{ $size_chart ? basename($size_chart) : '' }}
                                                    </label>
                                                </td>

                                                <td class="text-center">

                                                    @can('upload_size_charts')

                                                        <button disabled
                                                            class="uploadStyles"
                                                            type="button"
                                                            title="Upload"
                                                            onclick="uploadImages(
                                                                'size_chart',
                                                                'size_chart',
                                                                'Size Chart',
                                                                'size_chart'
                                                            )"
                                                            id="size_chart_uploading"
                                                            style="border-right: 2px solid #b3b3b3">

                                                            <i class="fa fa-cloud-upload" id="size_chart_upload"></i>
                                                            <i class="fas fa-spinner fa-spin"
                                                            id="size_chart_loading"
                                                            style="display: none"></i>

                                                            <div class="loading-icon"></div>
                                                        </button>

                                                    @else

                                                        <button class="uploadStyles"
                                                            type="button"
                                                            title="Upload"
                                                            onclick="showPermissionError('You do not have permission to upload Size Chart.')"
                                                            disabled
                                                            style="border-right: 2px solid #b3b3b3">

                                                            <i class="fa fa-cloud-upload"></i>
                                                            <i class="fas fa-spinner fa-spin"
                                                            style="display: none"></i>

                                                            <div class="loading-icon"></div>
                                                        </button>

                                                    @endcan

                                                    <button type="button"
                                                        id="size_chart_downloading"
                                                        title="Download"
                                                        class="downloadStyles"
                                                        @if(!$size_chart)
                                                            disabled
                                                        @else
                                                            onclick="window.location.href='{{ asset('assets') }}{{ $size_chart }}'"
                                                        @endif>
                                                        <i class="fa fa-cloud-download"></i>
                                                    </button>

                                                </td>
                                            </tr>
                                            @endcan
                                            
                                            @php
                                                $hasPermission = Gate::none(['view_2D_Mockup_Template', 'view_3D_Mockup_Template', 'view_Design_Tech_Pack', 'view_Measurement_Chart', 'view_Production_Layout', 'view_Technical_Tech_Pack', 'view_Pattern_Files']);
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
                        @php
                            $price1 = $prices->firstWhere('price_type', 1);
                            $price2 = $prices->firstWhere('price_type', 2);
                            $price3 = $prices->firstWhere('price_type', 3);
                            $price4 = $prices->firstWhere('price_type', 4);
                            $price5 = $prices->firstWhere('price_type', 5);
                        @endphp
                        <div class="row">
                            <div class="col-md-12 header-style">
                                Pricing Info
                            </div>
                            <div class="col-md-12 mt-3 mb-2">
                                <table class="subProductTable">
                                    <thead style="background-color: grey;color: white;height: 25px;font-size: .7rem;">
                                        <th>USER TYPE</th>
                                        <th>PRICE</th>
                                    </thead>

                                    @foreach($priceTypes as $type)
                                        <tr>
                                            <td>
                                                {{ $type->type_name }}
                                                <input type="hidden" name="price_type[]" value="{{ $type->id }}">
                                            </td>

                                            <td>
                                                <input type="text"
                                                    class="form-control form-input"
                                                    style="border:none;"
                                                    name="price[{{ $type->id }}]"
                                                    value="{{ $prices[$type->id]->price ?? '' }}"
                                                    pattern="\d+(\.\d{0,2})?"
                                                >
                                            </td>
                                        </tr>
                                    @endforeach
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

                        @php
                            $description = optional($project->current_product)->description;
                        @endphp

                        <div class="col-md-12 mt-3 mb-1">
                            <div id="editor-description" style="height: 300px;">
                                {!! $description !!}
                            </div>

                            <input type="hidden"
                                id="new_description"
                                value="{{ $description }}"
                                name="new_description">
                        </div>
                        <div class="col-md-12 header-style mt-3">
                            Who We Made This For
                        </div>

                        @php
                            $who_we_made_this_for = optional($project->current_product)->who_we_made_this_for;
                        @endphp

                        <div class="col-md-12 mt-3 mb-1">
                            <div id="editor-who-we-made-this-for" style="height: 100px;">
                                {!! $who_we_made_this_for !!}
                            </div>

                            <input type="hidden"
                                id="who_we_made_this_for"
                                value="{{ $who_we_made_this_for }}"
                                name="who_we_made_this_for">
                        </div>

                        <div class="col-md-12 header-style mt-3">
                            Product Features
                        </div>

                        @php
                            $product_features = optional($project->current_product)->product_features;
                        @endphp

                        <div class="col-md-12 mt-3 mb-1">
                            <div id="editor-product-features" style="height: 100px;">
                                {!! $product_features !!}
                            </div>

                            <input type="hidden"
                                id="product_features"
                                value="{{ $product_features }}"
                                name="product_features">
                        </div>

                    </div>
                    @if (Gate::check('edit products') || Gate::check('edit product description'))
                    <div class="col-md-12 mt-3 mb-3 text-right">
                        @if ($project->current_product->transferred == 0)
                            <button type="submit" class="btn btn-success custom_btn">UPDATE</button> 
                        @else
                            <a href="#" class="btn btn-success custom_btn">This Product Has Already Been Transferred</a> 
                        @endif
        
                    </form>
                        @if ($project->current_product->transferred == 0)
                            <form id="moveForm" action="{{ route('product_move', $project->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="button" class="btn btn-secondary custom_btn" onclick="confirmAndSubmit()" {{ optional($project->current_product)->transferred === 1 ? 'disabled' : '' }}>
                                    CREATE A MASTER PRODUCT
                                </button>
                            </form>
                        @else
                            @php
                                $url = $project->product_level == 1
                                    ? route('edit_product', ['id' => $project->current_product->transferred_id])
                                    : route('sub_products.edit', ['id' => $subProductNo->sub_product_no]);
                            @endphp

                            <a href="{{ $url }}" class="btn btn-info custom_btn" target="_blank">
                                View MASTER PRODUCT
                            </a>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
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
<div id="imageCaptionModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header">
                <h5 class="modal-title">Add Caption</h5>
                <button type="button" class="close" onclick="closeModal()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- BODY -->
            <div class="modal-body">
                <div class="row align-items-center">

                    <!-- IMAGE -->
                    <div class="col-md-6 text-center">
                        <img id="modalImage"
                             src=""
                             class="img-fluid rounded shadow-sm modal-img">
                    </div>

                    <!-- CAPTION -->
                    <div class="col-md-6">
                        <label><strong>Image Caption</strong></label>
                        <small class="text-muted d-block mb-2">Max 250 characters</small>

                        <textarea class="form-control"
                                  id="new_caption"
                                  rows="6"
                                  maxlength="250"></textarea>

                        <small id="charCount" class="text-muted">0 / 250</small>
                    </div>

                </div>

                <!-- hidden fields -->
                <input type="hidden" id="product_id">
                <input type="hidden" id="image_caption_type">
            </div>

            <!-- FOOTER -->
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                <button class="btn btn-danger" onclick="deleteCaption()">Delete</button>
                <button class="btn btn-success" onclick="saveCaption()">Save</button>
            </div>

        </div>
    </div>
</div>


<!-- Image Modal -->
<div id="imageCaptionModal2" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header">
                <h5 class="modal-title">Add Caption</h5>
                <button type="button" class="close" onclick="closeImageModal()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- BODY -->
            <div class="modal-body">
                <div class="row align-items-center">

                    <!-- IMAGE -->
                    <div class="col-md-6 text-center">
                        <img id="otherImage"
                             src=""
                             class="img-fluid rounded shadow-sm modal-img">
                    </div>

                    <!-- CAPTION -->
                    <div class="col-md-6">
                        <label><strong>Image Caption</strong></label>
                        <small class="text-muted d-block mb-2">Max 250 characters</small>

                        <textarea class="form-control"
                                  id="new_image_caption"
                                  rows="6"
                                  maxlength="250"></textarea>

                        <small id="charCount2" class="text-muted">0 / 250</small>
                    </div>

                </div>

                <!-- hidden fields -->
                <input type="hidden" id="image_product_id">
                <input type="hidden" id="image_caption_id">
            </div>

            <!-- FOOTER -->
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeImageModal()">Cancel</button>
                <button class="btn btn-danger" onclick="deleteImageCaption()">Delete</button>
                <button class="btn btn-success" onclick="saveImageCaption()">Save</button>
            </div>

        </div>
    </div>
</div>




<script>
$('#new_caption').on('input', function () {
    $('#charCount').text(this.value.length + ' / 250');
});

$('#new_image_caption').on('input', function () {
    $('#charCount2').text(this.value.length + ' / 250');
});
function confirmAndSubmit(){

    Swal.fire({
        title: "Create Master Product?",
        text: "Do you want to create this as a master product?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#2dce89',
        cancelButtonColor: '#f5365c',
        confirmButtonText: "Yes, Create",
        cancelButtonText: "Cancel"
    }).then(function(result) {

        if (result.value === true) {

            // Open new tab immediately after confirmation
            window.open('about:blank','productTab');

            // Submit form
            document.getElementById('moveForm').submit();
        }

    });
}
</script>

<script>
    $('#new_main_category_id').select2({
        dropdownCssClass: 'category-select2',
        containerCssClass: 'category-select2'
    });
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

        const projectId = document.getElementById('project_id').value;
        document.getElementById('image_caption_type').value = imageCaptionType;

        $.ajax({
            url: "{{ route('getImageCaptionTemp') }}",
            method: "GET",
            data: {
                projectId: projectId,
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
        const projectId = document.getElementById('project_id').value;
        const imageType = document.getElementById('image_caption_type').value;

        if (caption.length > 250) {
            alert("Caption exceeds the maximum length of 250 characters.");
            return;
        }

        $.ajax({
            url: "{{ route('saveProductImageCaptionTemp') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                projectId: projectId,
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
        const projectId = document.getElementById('project_id').value;
        const imageType = document.getElementById('image_caption_type').value;

        $.ajax({
            url: "{{ route('deleteProductImageCaptionTemp') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                projectId: projectId,
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
            url: "{{ route('getOtherImageCaptionTemp') }}",
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
        const projectId = document.getElementById('project_id').value;
        const imageID = document.getElementById('image_caption_id').value;

        if (caption.length > 250) {
            alert("Caption exceeds the maximum length of 250 characters.");
            return;
        }

        $.ajax({
            url: "{{ route('saveOtherImageCaptionTemp') }}",
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
            url: "{{ route('deleteOtherImageCaptionTemp') }}",
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

        function formatColorOption(state) {
            if (!state.id) return state.text;

            var hexColor = $(state.element).data('hex');

            return $(`
                <span style="
                    background-color:#${hexColor};
                    color:#fff;
                    padding:2px 8px;
                    border-radius:3px;
                    display:inline-block;
                ">
                    ${state.text}
                </span>
            `);
        }

        $('#new_available_colors').select2({
            placeholder: "Select colors",
            allowClear: true,
            width: '100%',
            templateResult: formatColorOption,
            templateSelection: formatColorOption,
            escapeMarkup: function (m) { return m; } // IMPORTANT
        });

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
            formData.append('project_id', $('#project_id').val());
            formData.append('image_uploaded', file);
            formData.append('product_id', $('#product_id').val());
            formData.append('db_image_field', dbField);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: "{{ route('products.upload_image.temp') }}",
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
            if (!isValid) {
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
            var projectId =$('#project_id').val();
            var product_id =$('#product_id').val();

            var formData = new FormData();
            formData.append('file_category', fileCat);
            formData.append('folder', folder);
            formData.append('product_no', productNo);
            formData.append('project_id', projectId);

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
                url:"{{ route('products.upload_image.temp') }}",
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

                    console.log(data);

                $('#'+uploaded_image_id+'_upload').show();
                $('#'+uploaded_image_id+'_loading').hide();

                let productId = $('#product_id').val();


                let imagePath = data.data[dbField];

                if(!imagePath){
                    console.error("Image path not found!");
                    return;
                }

                let baseUrl = window.location.origin + '/Encore-Cloud';
                let fullUrl = baseUrl + '/assets' + encodeURI(imagePath);

                let btn = $('.functionalities_'+uploaded_image_id)
                    .closest('div')
                    .find('.image_caption');

                btn.attr('onclick', `openModal('${fullUrl}', '${productId}', '${dbField}')`);

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
                url:"{{ route('products.removeImagesTemp') }}",
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

    // Mobile View Accordion Collapse/Expand
    function initMobileAccordion() {
        // Tag multi-header card container
        $('.sub-product-style .card-new').each(function() {
            var headersCount = $(this).find('.header-style').length;
            if (headersCount > 1) {
                $(this).addClass('multi-header');
            } else {
                $(this).removeClass('multi-header');
            }
        });

        if ($(window).width() < 768) {
            $('.sub-product-style .header-style').each(function() {
                var card = $(this).closest('.card-new');
                var headersCount = card.find('.header-style').length;
                if (headersCount === 1) {
                    card.removeClass('expanded');
                    $(this).removeClass('expanded');
                } else {
                    $(this).removeClass('expanded');
                }
            });
        } else {
            // Ensure expanded on desktop
            $('.sub-product-style .card-new').addClass('expanded');
            $('.sub-product-style .header-style').addClass('expanded');
        }
    }
    
    initMobileAccordion();
    $(window).on('resize', initMobileAccordion);

    $(document).on('click', '.sub-product-style .header-style', function() {
        if ($(window).width() < 768) {
            var card = $(this).closest('.card-new');
            var headersCount = card.find('.header-style').length;
            if (headersCount === 1) {
                card.toggleClass('expanded');
                $(this).toggleClass('expanded');
            } else {
                $(this).toggleClass('expanded');
            }
        }
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
</script>

@if (!Gate::check('edit products'))
    <script>
        disableFormElements();
        function disableFormElements() {
            $('#product_create_form')
                .find('input, select, textarea, button')
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
