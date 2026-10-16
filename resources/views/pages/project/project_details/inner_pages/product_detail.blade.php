<style>
    .table-font-size {
        font-size: 13px;
    }
    .table-border {
        border: unset !important;
    }
    .card-margin {
        margin: -0.5rem;
    }
    @media screen and (min-width: 600px) and (max-width: 800px) {
        .div_flexdir{
            flex-wrap: wrap;
            flex-direction: column;
        }
        .div_none{
            max-width: none;
        }
    }
    @media only screen and (min-device-width : 834px) and (max-device-width : 1024px) and (orientation : portrait) {
        .div_flexdir{
            flex-wrap: wrap;
            flex-direction: column;
        }
        .div_none{
            max-width: none;
        }
    }

    . {
        width: 248px !important;
    }
    .multy-box {
        height: 60px;
    }
    .image-tr-position {
        position: relative;
        top: 18px;
    }
    .image-shadow {
        border: none !important;
        box-shadow: 0 4px 6px rgba(50, 50, 93, .11), 0 0px 5px rgba(0, 0, 0, .08);
    }
    .image-size {
        height: 250px;
        width: 223px;
        position: relative;
        left: 20.5%;
        top: 5%;
    }
    .previous-btn {
        width: 26px;
        position: relative;
        left: 20px;
        top: -122px;
    }
    .next-btn {
        width: 26px;
        position: relative;
        top: -156px;
        right: -329px;
    }
    .add-mockup-font {
        font-size: small;
        /* color: #c4c4c4; */
        color: #525f7f;
    }
    .custom-file-upload {
        display: inline-block;
        position: relative;
        top: 9px;
        overflow: hidden;
        }

    .custom-file-upload input[type="file"] {
        display: block;
        position: absolute;
        top: 0;
        right: 0;
        opacity: 0;
        font-size: 100px; /* adjust this value to increase/decrease button size */
        cursor: pointer;
    }

    .custom-file-upload label {
        display: inline-block;
        padding: 5px 4px;
        background: #787878;
        color: #fff;
        cursor: pointer;
        width: 39px;
        height: 17px;
        font-size: 5px;
        padding-top: 5px;
        text-align: center;
        border-radius: 3px;
    }

    .custom-file-upload label:hover {
        background: #787878;
    }
    .file-list {
        font-size: 13px;
        font-weight: 750;
    }
    .status-tr {
        position: relative;
        top: 30px;
    }
    .btn-div {
        background-color: transparent !important;
    }
    .upload-file-font {
        color: #b7b7b7;
    }
    .btn-position {
        position: relative;
        right: -7px;
        top: 5px;
    }
    .progress {
        margin-left: inherit;
        width: 90%;
        height: inherit;
    }
    .thumbnail_size {
        height: auto;
        width: 7.7rem;
        border-radius: 5px;
        object-fit: cover;
    }
    .thumbnail {
        height: 100%;
        width: 100%;
        border-radius: 5px;
    }
    #slide_image {
        height: 100%;
        width: 100%;
        border-radius: 5px;
        {{-- object-fit: contain; --}}
    }
    #slideshow {
        height: 100%;
        width: 100%;
        border-radius: 5px;
    }
    .mockup-img {
        {{-- text-align: center; --}}
        color: grey;
        height: 2rem;
    }

    @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {
   .model_flex{
    flex-direction: column;

   }
   .div_maxwidth{
    max-width: none;
   }
   .table_width{
    width:100%;
   }

  }

    .hidden-input{
        display: none;
    }
    .visible-input {

    }
    .image-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 5px;
}

.upload-icon {
  margin-right: 10px;
  margin-left: 10px;
}

.cancel-button {
  background: none;
  border: none;
  cursor: pointer;
}
.image-name {
  display: block;
  width: 250px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.hoverable:hover {
    color: #1aff5f; /* Change the color to red on hover */
    cursor: pointer;
    transform: scale(1.05);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}
.price-position {
    position: relative;
    left: -10px;
}

</style>
<style>
.addItemStyleDiv .form-control{
    border-radius: 0rem;
    height: calc(1.5rem + 1px);
    border: 1px solid #DEDEDE;
}
.addItemStyleDiv .select2-selection--single{
    border-radius: 0rem !important;
    height: calc(1.5rem + 1px) !important;
    border: 1px solid #DEDEDE !important;
}
.addItemStyleDiv .select2-selection--multiple{
    border-radius: 0rem !important;
    min-height: 32px !important;
    border: 1px solid #DEDEDE !important;
    min-height: 10px !important;
    height: auto !important;
}
.select2-container--default.select2-container--focus .select2-selection--multiple {
    border: 1px solid #DEDEDE !important;
    height: auto !important;
}
.addItemStyleDiv .form-label{
    color: black;
}
#new_fabric_id + .select2.select2-container, #new_embellishment_type_id + .select2.select2-container, #new_product_attribute_id + .select2.select2-container, #new_product_category_id + .select2.select2-container, #new_main_category_id + .select2.select2-container, #new_product_factory_id + .select2.select2-container, #edit_fabric_id + .select2.select2-container, #edit_embellishment_type_id + .select2.select2-container, #edit_product_attribute_id + .select2.select2-container, #edit_product_factory_id + .select2.select2-container, #edit_product_category_id + .select2.select2-container, #edit_main_category_id + .select2.select2-container {
    min-height: 10px !important;
}
.allPricesTable .form-control{
    border: none !important;
}
.allPricesTable{
    width: 100%
}

.allPricesTable tr{
    color: grey;
    height: 25px;
    border-bottom: 1px solid #e7e7e7;
    font-size: .7rem !important;
}
.allPricesTable td, .allPricesTable th{
    padding-left: 10px;
    /* padding-right: 10px; */
}
.allPricesTable .form-control{
    height: 25px !important;
    border: none !important;
}
.sub-headers{
    color: black;
    font-size: .9rem;
    font-weight: 600;
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
.row{
    margin-right: 0px;
    margin-left: 0px;
}
label {
    margin-bottom: 0rem;
}
.ql-picker{
    margin-bottom: .25rem;
}
.ql-formats .selection{
    display: none;
}
.ql-formats .select2-hidden-accessible{
    display: none;
}
.ql-formats .select2-container{
    display: none;
}
/* Hide the default radio buttons */
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
</style>

<form action="{{ route('products.create') }}" method="post" enctype="multipart/form-data" id="product_create_form">
                @csrf
                <input type="hidden" name="product_id" id="new_product_id" value="">
                <div class="modal-body">
                    <div class="col-md-12" style="padding-left: 5px;padding-right: 5px;">
                        <div class="row model_flex" style="margin-left: 0px">
                            <div class="col-md-12 row mb-3" style="border-bottom: 1px solid #d3d3d3;border-radius: 0px;">
                                <div class="col-md-6 mb-2" style="padding-right: 2rem;">
                                    <input placeholder="Product Reference Link" style="border: none;border-bottom: 1px solid #d3d3d3;border-radius: 0px;color:#d3d3d3" type="text" class="form-control form-input" id="new_product_reference_link" name="new_product_reference_link">
                                </div>
                                <div class="col-md-3 mb-2 ml-auto mr-3" style="border-bottom: 1px solid #d3d3d3;">
                                    <select style="border: none;border-bottom: 1px solid #d3d3d3;border-radius: 0px;color:#d3d3d3" class="form-control form-input" id="active" name="active">
                                        <option value="0">Product Status</option>
                                        <option value="1">Active</option>
                                        <option value="3">Under Construction</option>
                                        <option value="4">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 row div_maxwidth addItemStyleDiv" style="padding-left: 0px;">
                                <div class="col-md-12 mt-3">
                                    <label for="new_product_name" class="form-label">Name</label>
                                    <input type="text" class="form-control form-input" id="new_product_name" name="new_product_name" required>
                                </div>
                                <div class="col-md-12 mt-3 mb-1">
                                    <label for="new_main_category_id" class="form-label">Category</label>
                                    {{-- <select class="form-control form-input" id="new_main_category_id" name="new_main_category_id">
                                        @foreach ($mainCategories as $mainCategorie)
                                            <option value="{{$mainCategorie->id}}">{{$mainCategorie->category_name}}</option>
                                        @endforeach
                                    </select> --}}
                                    <select class="form-control form-input multy-selection" id="new_main_category_id" name="new_main_category_id[]" multiple="multiple" required>
                                        @foreach ($mainCategories as $mainCategorie)
                                            <option value="{{$mainCategorie->id}}">{{$mainCategorie->category_name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    <div class="col-md-4 mt-3 mb-1">
                                        <label for="new_weight" class="form-label">Pattern No</label>
                                        <input type="text" class="form-control form-input" id="new_pattern_code" name="new_pattern_code">
                                    </div>
                                    <div class="col-md-4 mt-3 mb-1">
                                        <label for="new_weight" class="form-label">Weight</label>
                                        <input type="text" class="form-control form-input" id="new_weight" name="new_weight" pattern="\d+(\.\d{0,3})?" />
                                    </div>
                                    <div class="col-md-4 mt-3 mb-1">
                                        <label for="new_gender" class="form-label">Gender</label>
                                        <select class="form-control form-input" id="new_gender" name="new_gender" required>
                                            <option value="">Select a Gender</option>
                                            <option value="Men">Men's</option>
                                            <option value="Women">Women's</option>
                                        <option value="Uni">Uni</option>
                                        <option value="Kisd">Kids</option>
                                    </select>
                                    </div>
                                <div class="col-md-4 mt-3 mb-1">
                                    <label for="new_size_id" class="form-label">Size</label>
                                    <select class="form-control form-input" id="new_size_id" name="new_size_id" required>
                                        <option value="">Select a Size</option>
                                        @foreach ($sizeTypes as $sizeType)
                                            <option value="{{ $sizeType->id }}">{{ $sizeType->type_name }}</option>
                                        @endforeach
                                        {{-- <option value="1">YS-XXL</option>
                                        <option value="2">Sock</option>
                                        <option value="3">N/A</option> --}}
                                    </select>
                                </div>
                                <div class="col-md-8 mt-3 mb-1">
                                    <label class="form-label">Fits true to size</label>
                                    <div class="row" style="color: grey; font-size: .9rem;">
                                        <span>smaller&nbsp;&nbsp;</span>
                                        <input class="fitsSizesRadioLayouts" type="radio" id="fitsSizes1" name="fitsSizes" value="1">
                                        <label class="checkboxLable" for="fitsSizes1"></label>&nbsp;

                                        <input class="fitsSizesRadioLayouts" type="radio" id="fitsSizes2" name="fitsSizes" value="2">
                                        <label class="checkboxLable" for="fitsSizes2"></label>&nbsp;

                                        <input class="fitsSizesRadioLayouts" type="radio" id="fitsSizes3" name="fitsSizes" value="3" checked>
                                        <label class="checkboxLable" for="fitsSizes3"></label>&nbsp;

                                        <input class="fitsSizesRadioLayouts" type="radio" id="fitsSizes4" name="fitsSizes" value="4">
                                        <label class="checkboxLable" for="fitsSizes4"></label>&nbsp;

                                        <input class="fitsSizesRadioLayouts" type="radio" id="fitsSizes5" name="fitsSizes" value="5">
                                        <label class="checkboxLable" for="fitsSizes5"></label>

                                        <span>&nbsp;&nbsp;Larger</span>
                                    </div>

                                </div>
                                <div class="col-md-12 mt-3 mb-1">
                                    <label for="new_product_category_id" class="form-label">Styles</label>
                                    <select class="form-control form-input multy-selection" id="new_product_category_id" name="new_product_category_id[]" multiple="multiple" required>
                                        @foreach ($productCategories as $productCategory)
                                            <option value="{{$productCategory->id}}">{{$productCategory->product_category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mt-3 mb-1">
                                    <label for="new_sport" class="form-label">Sport</label>
                                    <select class="form-control form-input multy-selection" id="new_sport" name="new_sport[]" multiple="multiple" required>
                                        @foreach ($sports as $sport)
                                            <option value="{{$sport->id}}">{{$sport->sport_name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="col-md-12 mt-3 mb-1">
                                    <label for="new_standard_fabric_id" class="form-label">Fabric</label>
                                    <select class="form-control form-input" id="new_standard_fabric_id" name="new_standard_fabric_id">
                                        @foreach ($fabrics as $fabric)
                                            <option value="{{$fabric->id}}">{{$fabric->fabric_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mt-3 mb-1">
                                    <label for="new_fabric_id" class="form-label">Fabric Options</label>
                                    <select class="form-control form-input multy-selection" id="new_fabric_id" name="new_fabric_id[]" multiple="multiple">
                                        @foreach ($fabrics as $fabric)
                                            <option value="{{$fabric->id}}">{{$fabric->fabric_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mt-3 mb-1">
                                    <label for="new_embellishment_type_id" class="form-label">Embellishment</label>
                                    <select class="form-control form-input multy-selection" id="new_embellishment_type_id" name="new_embellishment_type_id[]" multiple="multiple">
                                        @foreach ($embellishmentTypes as $embellishmentType)
                                            <option value="{{$embellishmentType->id}}">{{$embellishmentType->embellishment_name}} @if ($embellishmentType->price != 0) {{'(+$'.$embellishmentType->price.')'}} @endif</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mt-3 mb-1">
                                    <label for="new_product_attribute_id" class="form-label">Attributes</label>
                                    <select class="form-control form-input multy-selection" id="new_product_attribute_id" name="new_product_attribute_id[]" multiple="multiple">
                                        @foreach ($productAttributes as $productAttribute)
                                            <option value="{{$productAttribute->id}}">{{$productAttribute->attribute_name}} @if ($productAttribute->price != 0) {{'(+$'.$productAttribute->price.')'}} @endif</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mt-3 mb-1">
                                    <label for="new_product_factory_id" class="form-label">Factories</label>
                                    <select class="form-control form-input multy-selection" id="new_product_factory_id" name="new_product_factory_id[]" multiple="multiple" required>
                                        @foreach ($factories as $factory)
                                            <option value="{{$factory->id}}">{{$factory->factory_code}}</option>
                                        @endforeach
                                    </select>
                                </div>



                                <div class="col-md-12 mt-3 mb-1">
                                    <label for="new_notes" class="form-label">Note</label>
                                    <textarea style="height: 40px;" class="form-control form-input" id="new_notes" name="new_notes" rows="3"></textarea>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <div class="sub-headers mb-2">
                                        Pricing Info
                                    </div>
                                    <table class="allPricesTable" style="font-size: .7rem">
                                        <thead style="background-color: grey;color: white;height: 25px;font-size: .7rem;">
                                            <th style="color: white">USER TYPE</th>
                                            <th style="color: white">PRICE</th>
                                        </thead>
                                        <tr>
                                            <td>
                                                Genaral
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-input" id="new_default_price" name="new_default_price"  pattern="\d+(\.\d{0,2})?"  required>
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
                                                <input type="text" class="form-control form-input" id="new_default_price2" name="new_default_price2" pattern="\d+(\.\d{0,2})?">
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
                                                <input type="text" class="form-control form-input" id="new_default_price3" name="new_default_price3"  pattern="\d+(\.\d{0,2})?" >
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
                                                <input type="text" class="form-control form-input" id="new_default_price4" name="new_default_price4"  pattern="\d+(\.\d{0,2})?" >
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
                                                <input type="text" class="form-control form-input" id="new_default_price5" name="new_default_price5"  pattern="\d+(\.\d{0,2})?" >
                                            </td>
                                        </tr>
                                    </table>
                                </div>



                                <table class="table-font-size invoice_details table-border table_width" style="width: 96%; display:none">
                                    {{-- <tr>
                                        <th style="width: 98px;">Name</th>
                                        <th style="width: 10px;">:</th>
                                        <td style="width: 64%;">

                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <th>Sport</th>
                                        <th>:</th>
                                        <td class="form-control">
                                            <select class="form-control form-input multy-selection" id="new_sport" name="new_sport[]" multiple="multiple" required>
                                                @foreach ($sports as $sport)
                                                    <option value="{{$sport->id}}">{{$sport->sport_name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <th>Gender</th>
                                        <th>:</th>
                                        <td class="form-control">
                                            <select class="form-control form-input" id="new_gender" name="new_gender" required>
                                                <option value="">Select a Gender</option>
                                                <option value="Men">Men's</option>
                                                <option value="Women">Women's</option>
                                                <option value="Uni">Uni</option>
                                                <option value="Kisd">Kids</option>
                                            </select>
                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <th>Weight</th>
                                        <th>:</th>
                                        <td>
                                            <input type="text" class="form-control form-input" id="new_weight" name="new_weight" pattern="\d+(\.\d{0,3})?" />

                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <th>Fabric</th>
                                        <th>:</th>
                                        <td class="form-control">
                                            <select class="form-control form-input" id="new_standard_fabric_id" name="new_standard_fabric_id">
                                                @foreach ($fabrics as $fabric)
                                                    <option value="{{$fabric->id}}">{{$fabric->fabric_name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <th>Category</th>
                                        <th>:</th>
                                        <td class="form-control">
                                            <select class="form-control form-input" id="new_main_category_id" name="new_main_category_id">
                                                @foreach ($mainCategories as $mainCategorie)
                                                    <option value="{{$mainCategorie->id}}">{{$mainCategorie->category_name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <th>Factories</th>
                                        <th>:</th>
                                        <td class="form-control multy-box">
                                            <select class="form-control form-input multy-selection" id="new_product_factory_id" name="new_product_factory_id[]" multiple="multiple" required>
                                                @foreach ($factories as $factory)
                                                    <option value="{{$factory->id}}">{{$factory->factory_code}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <th>Styles</th>
                                        <th>:</th>
                                        <td class="form-control multy-box">
                                            <select class="form-control form-input multy-selection" id="new_product_category_id" name="new_product_category_id[]" multiple="multiple" required>
                                                @foreach ($productCategories as $productCategory)
                                                    <option value="{{$productCategory->id}}">{{$productCategory->product_category_name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <th>Fabric Options</th>
                                        <th>:</th>
                                        <td class="form-control multy-box">
                                            <select class="form-control form-input multy-selection" id="new_fabric_id" name="new_fabric_id[]" multiple="multiple">
                                                @foreach ($fabrics as $fabric)
                                                    <option value="{{$fabric->id}}">{{$fabric->fabric_name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <th>Embellishment</th>
                                        <th>:</th>
                                        <td class="form-control multy-box">
                                            <select class="form-control form-input multy-selection" id="new_embellishment_type_id" name="new_embellishment_type_id[]" multiple="multiple">
                                                @foreach ($embellishmentTypes as $embellishmentType)
                                                    <option value="{{$embellishmentType->id}}">{{$embellishmentType->embellishment_name}} @if ($embellishmentType->price != 0) {{'(+$'.$embellishmentType->price.')'}} @endif</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <th>Attributes</th>
                                        <th>:</th>
                                        <td class="form-control multy-box">
                                            <select class="form-control form-input multy-selection" id="new_product_attribute_id" name="new_product_attribute_id[]" multiple="multiple">
                                                @foreach ($productAttributes as $productAttribute)
                                                    <option value="{{$productAttribute->id}}">{{$productAttribute->attribute_name}} @if ($productAttribute->price != 0) {{'(+$'.$productAttribute->price.')'}} @endif</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <th>Description</th>
                                        <th>:</th>
                                        <td>
                                            <textarea class="form-control form-input" id="new_description" name="new_description" rows="3"></textarea>
                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <th>Note</th>
                                        <th>:</th>
                                        <td>
                                            <textarea class="form-control form-input" id="new_notes" name="new_notes" rows="3"></textarea>
                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <th>Price ($)</th>
                                        <th>:</th>
                                        <td>
                                            <input type="text" class="form-control form-input" id="new_default_price" name="new_default_price"  pattern="\d+(\.\d{0,2})?"  required>
                                        </td>
                                    </tr> --}}

                                    {{-- @foreach ($priceTypes as $priceType)
                                        @if ($priceType->id != 1)
                                            <tr>
                                                <th>
                                                    {{ $priceType->type_name }} ($)
                                                        <input type="hidden" value="{{ $priceType->id }}" name="price_type">
                                                </th>
                                                <th>:</th>
                                                <td>
                                                    <input type="number" class="form-control form-input" id="new_default_price2" name="new_default_price2" step="0.01" min="0" oninput="validity.valid||(value='');" >
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach --}}

                                    {{-- <tr>
                                        <th>
                                            @foreach ($priceTypes as $priceType)
                                                @if ($priceType->id == 2)
                                                    {{ $priceType->type_name }} ($)
                                                    <input type="hidden" value="{{ $priceType->id }}" name="price_type_2">
                                                @endif
                                            @endforeach
                                        </th>
                                        <th>:</th>
                                        <td>
                                            <input type="text" class="form-control form-input" id="new_default_price2" name="new_default_price2" pattern="\d+(\.\d{0,2})?">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            @foreach ($priceTypes as $priceType)
                                                @if ($priceType->id == 3)
                                                    {{ $priceType->type_name }} ($)
                                                    <input type="hidden" value="{{ $priceType->id }}" name="price_type_3">
                                                @endif
                                            @endforeach
                                        </th>
                                        <th>:</th>
                                        <td>
                                            <input type="text" class="form-control form-input" id="new_default_price3" name="new_default_price3"  pattern="\d+(\.\d{0,2})?" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            @foreach ($priceTypes as $priceType)
                                                @if ($priceType->id == 4)
                                                    {{ $priceType->type_name }} ($)
                                                    <input type="hidden" value="{{ $priceType->id }}" name="price_type_4">
                                                @endif
                                            @endforeach
                                        </th>
                                        <th>:</th>
                                        <td>
                                            <input type="text" class="form-control form-input" id="new_default_price4" name="new_default_price4"  pattern="\d+(\.\d{0,2})?" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            @foreach ($priceTypes as $priceType)
                                                @if ($priceType->id == 5)
                                                    {{ $priceType->type_name }} ($)
                                                    <input type="hidden" value="{{ $priceType->id }}" name="price_type_5">
                                                @endif
                                            @endforeach
                                        </th>
                                        <th>:</th>
                                        <td>
                                            <input type="text" class="form-control form-input" id="new_default_price5" name="new_default_price5"  pattern="\d+(\.\d{0,2})?" >
                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <th class="price-position">
                                            <select name="price_type_2" id="price_type_2">
                                                @foreach ($priceTypes as $priceType)
                                                    @if ($priceType->id != 1)
                                                        <option value="{{ $priceType->id }}">{{ $priceType->type_name }} ($)</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </th>
                                        <th>:</th>
                                        <td>
                                            <input type="number" class="form-control form-input" id="new_default_price2" name="new_default_price2" step="0.01" min="0" oninput="validity.valid||(value='');" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="price-position">
                                            <select name="price_type_3" id="price_type_3"  >
                                                @foreach ($priceTypes as $priceType)
                                                @if ($priceType->id != 1)
                                                    <option value="{{ $priceType->id }}">{{ $priceType->type_name }} ($)</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </th>
                                        <th>:</th>
                                        <td>
                                            <input type="number" class="form-control form-input" id="new_default_price3" name="new_default_price3" step="0.01" min="0" oninput="validity.valid||(value='');" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="price-position">
                                            <select name="price_type_4" id="price_type_4">
                                                @foreach ($priceTypes as $priceType)
                                                @if ($priceType->id != 1)
                                                    <option value="{{ $priceType->id }}">{{ $priceType->type_name }} ($)</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </th>
                                        <th>:</th>
                                        <td>
                                            <input type="number" class="form-control form-input" id="new_default_price4" name="new_default_price4" step="0.01" min="0" oninput="validity.valid||(value='');">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="price-position">
                                            <select name="price_type_5" id="price_type_5">
                                                @foreach ($priceTypes as $priceType)
                                                @if ($priceType->id != 1)
                                                    <option value="{{ $priceType->id }}">{{ $priceType->type_name }} ($)</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </th>
                                        <th>:</th>
                                        <td>
                                            <input type="number" class="form-control form-input" id="new_default_price5" name="new_default_price5" step="0.01" min="0" oninput="validity.valid||(value='');" >
                                        </td>
                                    </tr> --}}
                                </table>
                            </div>
                            <div class="col-md-6 row div_maxwidth navbarStylePaste" style="padding-right: 0px;">
                                <div class="col-md-12 sub-headers">
                                    Product Images
                                </div>
                                <div class="col-md-12">
                                    <div style="border: none !important;">
                                        <div id="slideshow" style="text-align: left;">
                                            <img id="slide_image" style="border-radius: 0rem;height: auto;width:100%" class="slider-img-reset"  src="uploads/default_img.jpg" />
                                        </div>
                                        {{-- <div class="slideshow-buttons">
                                            <a href="#" type="button" class="form-control previous-btn" onclick="showPreviousSlide()"><span class="btn-position"> &#8249;</span></a href="#">
                                            <a href="#" type="button" class="next-btn form-control" onclick="showNextSlide()"><span class="btn-position"> &#8250;</span></a>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="col-md-4 text-center justify-content-center mt-2">
                                    <div class="card tab-container" style="width:100%; height:auto; border: none !important;">
                                        <div id="thumbnail_front" class="thumbnail slider-img-data-reset" data-image="uploads/default_img.jpg" style="align-content: center;">
                                            <img id="thumbnail_front_img" style="border-radius: 0rem" class="thumbnail_size slider-img-reset" src="uploads/default_img.jpg" />
                                        </div>
                                    </div>
                                    <div id="mockup-front-progress">
                                        <a href="#" id="mockup-front-upload">
                                            <i class="fas fa-solid fa-upload" style="color: #a3a3a3;"></i>
                                        </a>
                                        <div class="progress" id="mockup-front-upload-progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Uploading...</div>
                                        </div>
                                    </div>
                                    <div class="hover-trigger-front mt-2 mockup-img">
                                        <h2 class="add-mockup-font toggle-text element-front-to-toggle" style="color: grey">Front</h2>
                                        <label for="mockup-front-image" class="file-label toggle-file element-front-to-toggle" style="padding: 5px">
                                            <i class="fa fa-upload" aria-hidden="true" style="font-size: 12px; cursor: pointer;"> UPLOAD</i>
                                        </label>
                                        <input type="file" class="file-select" id="mockup-front-image" name="file" multiple style="display: none;">
                                    </div>
                                </div>
                                {{-- Front Side End --}}
                                {{-- Side Start --}}
                                <div class="col-md-4 text-center justify-content-center mt-2">
                                    <div class="card tab-container" style="width:100%; height:auto; border: none !important;">
                                        <div id="thumbnail_side" class="thumbnail slider-img-data-reset" data-image="uploads/default_img.jpg" style="align-content: center;">
                                            <img id="thumbnail_side_img" style="border-radius: 0rem" class="thumbnail_size slider-img-reset" src="uploads/default_img.jpg" />
                                        </div>
                                    </div>
                                    <div id="mockup-side-progress">
                                        <a href="#" id="mockup-side-upload">
                                            <i class="fas fa-solid fa-upload" style="color: #a3a3a3;"></i>
                                        </a>
                                        <div class="progress" id="mockup-side-upload-progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Uploading...</div>
                                        </div>
                                    </div>
                                    <div class="hover-trigger-side mt-2 mockup-img">
                                        <h2 class="add-mockup-font toggle-text element-side-to-toggle" style="color: grey">Side</h2>
                                        <label for="mockup-side-image" class="file-label toggle-file element-side-to-toggle" style="padding: 5px">
                                            <i class="fa fa-upload" aria-hidden="true" style="font-size: 12px; cursor: pointer;"> UPLOAD</i>
                                        </label>
                                        <input type="file" class="file-select" id="mockup-side-image" name="file" multiple style="display: none;">
                                    </div>
                                </div>
                                {{-- Side End --}}
                                {{-- Back Side Start --}}
                                <div class="col-md-4 text-center justify-content-center mt-2">
                                    <div class="card tab-container" style="width:100%; height:auto; border: none !important;">
                                        <div id="thumbnail_back" class="thumbnail slider-img-data-reset" data-image="uploads/default_img.jpg" style="align-content: center;">
                                            <img id="thumbnail_back_img" style="border-radius: 0rem" class="thumbnail_size slider-img-reset" src="uploads/default_img.jpg" />
                                        </div>
                                    </div>
                                    <div id="mockup-back-progress">
                                        <a href="#" id="mockup-back-upload">
                                            <i class="fas fa-solid fa-upload" style="color: #a3a3a3;"></i>
                                        </a>
                                        <div class="progress" id="mockup-back-upload-progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Uploading...</div>
                                        </div>
                                    </div>
                                    <div class="hover-trigger-back mt-2 mockup-img">
                                        <h2 class="add-mockup-font toggle-text element-back-to-toggle" style="color: grey">Back</h2>
                                        <label for="mockup-back-image" class="file-label toggle-file element-back-to-toggle" style="padding: 5px">
                                            <i class="fa fa-upload" aria-hidden="true" style="font-size: 12px; cursor: pointer;"> UPLOAD</i>
                                        </label>
                                        <input type="file" class="file-select" id="mockup-back-image" name="file" multiple style="display: none;">
                                    </div>
                                </div>


                                <div class="tab-container" style="width:100%;padding: 1rem;">
                                    <ul class="nav nav-tabs" style="border: none">
                                        <li class="nav-item">
                                            <a class="nav-link nav-link1 active" id="tab-lifestyle" href="#lifestyle-tab">LIFESTYLE IMG</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link nav-link1" id="tab-3d" href="#3d-tab">3D IMG</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane tab-pane1 active" id="lifestyle-tab">
                                            <!-- Content for Lifestyle tab goes here -->
                                            <div class="row">
                                                <div class="col-md-4 mt-3">
                                                    <div class="card tab-container" style="width:100%; height:auto; border: none !important;">
                                                        <div id="thumbnail_lifeStyle" class="thumbnail slider-img-data-reset" data-image="uploads/default_img.jpg" style="align-content: center;">
                                                            <img id="thumbnail_lifeStyle_img" style="border-radius: 0rem" class="thumbnail_size slider-img-reset" src="uploads/default_img.jpg" />
                                                        </div>
                                                    </div>

                                                    <div class="hover-trigger-lifeStyle mt-2 mockup-img">
                                                    <h2 class="add-mockup-font toggle-text element-lifeStyle-to-toggle" style="color: grey;text-align:left">Life Style Images</h2>
                                                        <label for="mockup-lifeStyle-image" class="file-label toggle-file element-lifeStyle-to-toggle" style="padding: 5px">
                                                            <i class="fa fa-upload" aria-hidden="true" style="font-size: 12px; cursor: pointer;"> UPLOAD</i>
                                                        </label>
                                                    <input type="file" class="file-select" id="mockup-lifeStyle-image" name="file" multiple style="display: none;">
                                                    </div>
                                                </div>
                                                <div class="col-md-8 mt-3">
                                                    <div class="col-md-12" id="uploaded-lifeStyle-images" style="padding: 0px;font-size:.7rem">

                                                    </div>
                                                    {{-- <div class="col-md-4"></div> --}}
                                                    <div class="col-md-12" id="uploaded-lifeStyle-images-container">
                                                        <!-- Uploaded image names will be displayed here -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane tab-pane1" id="3d-tab">
                                            <!-- Content for 3D Images tab goes here -->
                                            <div class="row">
                                                <div class="col-md-4 mt-3">
                                                    <div class="card tab-container" style="width:100%; height:auto; border: none !important;">

                                                        <div id="thumbnail_3d" class="thumbnail slider-img-data-reset" data-image="uploads/default_img.jpg" style="align-content: center;">
                                                            <img id="thumbnail_3d_img" style="border-radius: 0rem" class="thumbnail_size slider-img-reset" src="uploads/default_img.jpg" />
                                                        </div>
                                                    </div>
                                                    <div class="hover-trigger-3d mt-2 mockup-img">
                                                    <h2 class="add-mockup-font toggle-text element-3d-to-toggle" style="color: grey;text-align:left">3D Images</h2>
                                                        <label for="mockup-3d-image" class="file-label toggle-file element-3d-to-toggle" style="padding: 5px">
                                                            <i class="fa fa-upload" aria-hidden="true" style="font-size: 12px; cursor: pointer;"> UPLOAD</i>
                                                        </label>
                                                    <input type="file" class="file-select" id="mockup-3d-image" name="file" multiple style="display: none;">
                                                    </div>
                                                </div>
                                                <div class="col-md-8 mt-3">
                                                    <div class="col-md-12" id="uploaded-3d-images" style="padding: 0px;font-size:.7rem">
                                                        {{-- <table>
                                                            @foreach ($productImages as $productImage)
                                                                @if ($productImage->image_type == 1)
                                                                    <tr>
                                                                        <input type="hidden" value="{{  $productImage->id }}">
                                                                        <td>{{ $productImage->image_name }}</td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </table> --}}
                                                    </div>
                                                    <div class="col-md-12" id="uploaded-images-container">
                                                        <!-- Uploaded image names will be displayed here -->
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @can('view design files')
                                <div class="col-md-12 sub-headers mb-2 mt-3">
                                    Design Files
                                </div>
                                <div class="col-md-12">
                                    <table class="allPricesTable">
                                        <thead style="background-color: grey;color: white;height: 25px;font-size: .7rem;">
                                            <th style="color: white;width: 37%;">FILE NAME</th>
                                            <th colspan="4" style="color: white; text-align:center">ACTION</th>
                                        </thead>
                                        <tr>
                                            <th class="upload-file-font">2D Mockup Template</th>
                                            <th>
                                                <label for="2D-mockup-image" class="file-label">
                                                {{-- <i class="fas fa-solid fa-upload" style="color: #6b6b6b;"></i> --}}
                                                <i class="fa fa-upload" title="Upload 2D Mockup" aria-hidden="true" style="font-size: 15px; color:#1aff5f; cursor: pointer;"></i>
                                                <input type="file" class="file-select" id="2D-mockup-image" name="file" multiple style="display: none;">
                                            </th>
                                            <td id="2D-mockup" style="width: 42%;font-size: .6rem;"></td>
                                            <td id="2D-mockup-progress" style="width: 20%;">
                                                <a href="#" id="2D-mockup-upload">
                                                    <i class="fas fa-solid fa-upload" style="color: #a3a3a3;"></i>
                                                </a>
                                                <div class="progress" id="2D-mockup-upload-progress">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Uploading...</div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="#" id="downloadLink2D" download>
                                                    <i class="fas fa-solid fa-download" title="Download 2D Mockup" style="color: #a3a3a3;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="upload-file-font">3D Mockup Template</th>
                                            <th>
                                                <label for="3D-mockup-image" class="file-label">
                                                {{-- <i class="fas fa-solid fa-upload" style="color: #6b6b6b;"></i> --}}
                                                <i class="fa fa-upload" title="Upload 3D Mockup" aria-hidden="true" style="color:#1aff5f;font-size: 15px; cursor: pointer;"></i>
                                                <input type="file" class="file-select" id="3D-mockup-image" multiple style="display: none;">
                                            </th>
                                            <td id="3D-mockup" style="font-size: .6rem;"></td>
                                            <td id="3D-mockup-progress">
                                                <a href="#" id="3D-mockup-upload">
                                                    <i class="fas fa-solid fa-upload" style="color: #a3a3a3;"></i>
                                                </a>
                                                <div class="progress" id="3D-mockup-upload-progress">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Uploading...</div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="#" id="downloadLink3D" download>
                                                    <i class="fas fa-solid fa-download" title="Download 3D Mockup" style="color: #a3a3a3;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="upload-file-font">Design Tech Pack</th>
                                            <th>
                                                <label for="tech-pack-image" class="file-label">
                                                {{-- <i class="fas fa-solid fa-upload" style="color: #6b6b6b;"></i> --}}
                                                <i class="fa fa-upload" title="Upload Design Tech Pack" aria-hidden="true" style="color:#1aff5f;font-size: 15px; cursor: pointer;"></i>
                                                <input type="file" class="file-select" id="tech-pack-image" multiple style="display: none;">
                                            </th>
                                            <td id="tech-pack" style="font-size: .6rem;"></td>
                                            <td id="tech-pack-progress">
                                                <a href="#" id="tech-pack-upload">
                                                    <i class="fas fa-solid fa-upload" style="color: #a3a3a3;"></i>
                                                </a>
                                                <div class="progress" id="tech-pack-upload-progress">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Uploading...</div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="#" id="downloadLinkTech" download>
                                                    <i class="fas fa-solid fa-download" title="Download Design Tech Pack" style="color: #a3a3a3;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="upload-file-font">Measurement Chart</th>
                                            <th>
                                                <label for="measurement-image" class="file-label">
                                                {{-- <i class="fas fa-solid fa-upload" style="color: #6b6b6b;"></i> --}}
                                                <i class="fa fa-upload" title="Upload Mesurement Chart" aria-hidden="true" style="color:#1aff5f;font-size: 15px; cursor: pointer;"></i>
                                                <input type="file" class="file-select" id="measurement-image" multiple style="display: none;">
                                            </th>
                                            <td id="measurement" style="font-size: .6rem;"></td>
                                            <td id="measurement-progress">
                                                <a href="#" id="measurement-upload">
                                                    <i class="fas fa-solid fa-upload" style="color: #a3a3a3;"></i>
                                                </a>
                                                <div class="progress" id="measurement-upload-progress">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Uploading...</div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="#" id="downloadLinkchart" download>
                                                    <i class="fas fa-solid fa-download" title="Download Mesurement Chart" style="color: #a3a3a3;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="upload-file-font">Production Layout</th>
                                            <th>
                                                <label for="product-layout-image" class="file-label">
                                                {{-- <i class="fas fa-solid fa-upload" style="color: #6b6b6b;"></i> --}}
                                                <i class="fa fa-upload" aria-hidden="true" title="Upload Production Layout" style="color:#1aff5f;font-size: 15px; cursor: pointer;"></i>
                                                <input type="file" class="file-select" id="product-layout-image" multiple style="display: none;">
                                            </th>
                                            <td id="product-layout" style="font-size: .6rem;"></td>
                                            <td id="product-layout-progress">
                                                <a href="#" id="product-layout-upload">
                                                    <i class="fas fa-solid fa-upload" style="color: #a3a3a3;"></i>
                                                </a>
                                                <div class="progress" id="product-layout-upload-progress">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Uploading...</div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="#" id="downloadLinklayout" download>
                                                    <i class="fas fa-solid fa-download" title="Download Production Layout" style="color: #a3a3a3;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="upload-file-font">Pattern File</th>
                                            <th>
                                                <label for="pattern-image" class="file-label">
                                                {{-- <i class="fas fa-solid fa-upload" style="color: #6b6b6b;"></i> --}}
                                                <i class="fa fa-upload" aria-hidden="true" title="Upload Pattern File" style="color:#1aff5f;font-size: 15px; cursor: pointer;"></i>
                                                <input type="file" class="file-select" id="pattern-image" multiple style="display: none;">
                                            </th>
                                            <td id="pattern" style="font-size: .6rem;"></td>
                                            <td id="pattern-progress">
                                                <a href="#" id="pattern-upload">
                                                    <i class="fas fa-solid fa-upload" style="color: #a3a3a3;"></i>
                                                </a>
                                                <div class="progress" id="pattern-upload-progress">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Uploading...</div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="#" id="downloadLinkPattern" download>
                                                    <i class="fas fa-solid fa-download" title="Download Pattern File" style="color: #a3a3a3;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="upload-file-font">Technical Tech Pack</th>
                                            <th>
                                                <label for="technical-techPack-image" class="file-label">
                                                {{-- <i class="fas fa-solid fa-upload" style="color: #6b6b6b;"></i> --}}
                                                <i class="fa fa-upload" title="Upload Technical Tech Pack" aria-hidden="true" style="color:#1aff5f;font-size: 15px; cursor: pointer;"></i>
                                                <input type="file" class="file-select" id="technical-techPack-image" multiple style="display: none;">
                                            </th>
                                            <td id="technical-techPack" style="font-size: .6rem;"></td>
                                            <td id="technical-techPack-progress">
                                                <a href="#" id="technical-techPack-upload">
                                                    <i class="fas fa-solid fa-upload" style="color: #a3a3a3;"></i>
                                                </a>
                                                <div class="progress" id="technical-techPack-upload-progress">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Uploading...</div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="#" id="downloadLinkTechnicalTechPack" download>
                                                    <i class="fas fa-solid fa-download" title="Download Technical Tech Pack" style="color: #a3a3a3;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                @endcan


                                {{-- Back Side End --}}
                                <table class="table-font-size invoice_details table-border table_width" style="display: none">
                                    <tr>
                                        <th style="width: 98px;">Product #</th>
                                        <th style="width: 10px;">:</th>
                                        <td style="width: 70%;">
                                            <input type="text" class="form-control form-input" id="new_product_no" name="new_product_no" value="" readonly>
                                            {{-- <input type="hidden" class="form-control form-input visible-input" id="product_number_input" name="" value="{{"PRO - ". $newProductNo }}" readonly> --}}
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <th>Pattern #</th>
                                        <th>:</th>
                                        <td>
                                            <input type="text" class="form-control form-input" id="new_pattern_code" name="new_pattern_code">
                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <th>Size</th>
                                        <th>:</th>
                                        <td class="form-control">
                                            <select class="form-control form-input" id="new_size_id" name="new_size_id" required>
                                                <option value="">Select a Size</option>
                                                @foreach ($sizeTypes as $sizeType)
                                                    <option value="{{ $sizeType->id }}">{{ $sizeType->type_name }}</option>
                                                @endforeach
                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <th>Price ($)</th>
                                        <th>:</th>
                                        <td>
                                            <input type="number" class="form-control form-input" id="new_default_price" name="new_default_price" step="0.01" min="0" oninput="validity.valid||(value='');"  required>
                                        </td>
                                    </tr> --}}
                                    <tr class="image-tr-position">
                                        <td colspan="3">
                                            {{-- <div class="row" style="width: 104%;">
                                                <div class="card tab-container" style="width: 100%; height: 20rem;  border: none !important;">
                                                    <div id="slideshow" style="align-content: center;">
                                                        <img id="slide_image" class="slider-img-reset"  src="uploads/default_img.jpg" />
                                                    </div> --}}
                                                    {{-- <div class="slideshow-buttons">
                                                        <a href="#" type="button" class="form-control previous-btn" onclick="showPreviousSlide()"><span class="btn-position"> &#8249;</span></a href="#">
                                                        <a href="#" type="button" class="next-btn form-control" onclick="showNextSlide()"><span class="btn-position"> &#8250;</span></a>
                                                    </div> --}}
                                                {{-- </div>
                                            </div> --}}
                                            <div class="row mt-3" style="width: 104%;">
                                                {{-- Front Side Start --}}

                                            </div>

                                            {{-- 3D image --}}
                                            <div class="row mt-3" style="width: 104%;">

                                            </div>

                                            {{-- Life Style Images --}}
                                            <div class="row mt-3" style="width: 104%;">

                                            </div>

                                            {{-- <div class="row" style="margin-top: 10px;">
                                                <div>
                                                    <h1 class="add-mockup-font">Upload Mockup </h1>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="card" style="border: 1px solid #d1d1d1 !important; border-radius: 5px !important; width: 100%; padding: 5px;">
                                                    <table class="table-font-size invoice_details table-border" style="width:100%;">
                                                        <tr>
                                                            <th class="upload-file-font" style="width: 20%;">Front Side</th>
                                                            <th>
                                                                <label for="mockup-front-image" class="file-label" style="padding: 5px">
                                                                <i class="fa fa-file-image-o" aria-hidden="true" style="font-size: 15px; cursor: pointer;"></i>
                                                                <input type="file" class="file-select" id="mockup-front-image" name="file" multiple style="display: none;">
                                                            </th>
                                                            <td id="mockup-front" style="width: 60%;"></td>
                                                            <td id="mockup-front-progress" style="width: 20%;">
                                                                <a href="#" id="mockup-front-upload">
                                                                    <i class="fas fa-solid fa-upload" style="color: #a3a3a3;"></i>
                                                                </a>
                                                                <div class="progress" id="mockup-front-upload-progress">
                                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Uploading...</div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="upload-file-font">Side</th>
                                                            <th>
                                                                <label for="mockup-side-image" class="file-label" style="padding: 5px">
                                                                <i class="fa fa-file-image-o" aria-hidden="true" style="font-size: 15px; cursor: pointer;"></i>
                                                                <input type="file" class="file-select" id="mockup-side-image" name="file" multiple style="display: none;">
                                                            </th>
                                                            <td id="mockup-side"></td>
                                                            <td id="mockup-side-progress" >
                                                                <a href="#" id="mockup-side-upload">
                                                                    <i class="fas fa-solid fa-upload" style="color: #a3a3a3;"></i>
                                                                </a>
                                                                <div class="progress" id="mockup-side-upload-progress">
                                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Uploading...</div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="upload-file-font">Back Side</th>
                                                            <th>
                                                                <label for="mockup-back-image" class="file-label" style="padding: 5px">
                                                                <i class="fa fa-file-image-o" aria-hidden="true" style="font-size: 15px; cursor: pointer;"></i>
                                                                <input type="file" class="file-select" id="mockup-back-image" name="file" multiple style="display: none;">
                                                            </th>
                                                            <td id="mockup-back"></td>
                                                            <td id="mockup-back-progress" style="width: 20%;">
                                                                <a href="#" id="mockup-back-upload">
                                                                    <i class="fas fa-solid fa-upload" style="color: #a3a3a3;"></i>
                                                                </a>
                                                                <div class="progress" id="mockup-back-upload-progress">
                                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Uploading...</div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div> --}}
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <td colspan="3" style="padding-top: 25px !important;">
                                            <h5>Product Reference Link :</h5>
                                            <input type="text" class="form-control form-input" id="new_product_reference_link" name="new_product_reference_link">
                                        </td>
                                    </tr>
                                    <tr class="status-tr">
                                        <th>Product Status</th>
                                        <th>:</th>
                                        <td class="form-control ">
                                            <select class="form-control form-input" id="active" name="active">
                                                <option value="0">Select a Status</option>
                                                <option value="1">Active</option>
                                                <option value="3">Under Construction</option>
                                                <option value="4">Inactive</option>
                                            </select>
                                        </td>
                                    </tr> --}}
                                </table>
                            </div>

                            {{-- <div class="col-md-6 form-field">
                                <label class="form-lable">Product Name: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-input" id="new_product_name" name="new_product_name" required>
                            </div> --}}

                            {{-- <div class="col-md-6 form-field">
                                <label class="form-lable">Product No: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-input" id="new_product_no" name="new_product_no" value="{{$productNo}}" readonly>
                            </div> --}}

                            {{-- <div class="col-md-6 form-field">
                                <label class="form-lable">Pattern Code: </label>
                                <input type="text" class="form-control form-input" id="new_pattern_code" name="new_pattern_code">
                            </div> --}}

                            {{-- <div class="col-md-6 form-field">
                                <label class="form-lable">Sport: <span class="text-danger">*</span></label>
                                <select class="form-control form-input" id="new_sport" name="new_sport" required>
                                    <option value="">Select a Sport</option>
                                    <option value="All">ALL</option>
                                    @foreach ($sports as $sport)
                                        <option value="{{$sport->sport_name}}">{{$sport->sport_name}}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            {{-- <div class="col-md-6 form-field">
                                <label class="form-lable">Gender: <span class="text-danger">*</span></label>
                                <select class="form-control form-input" id="new_gender" name="new_gender" required>
                                    <option value="">Select a Gender</option>
                                    <option value="Men">Men's</option>
                                    <option value="Women">Women's</option>
                                    <option value="Uni">Uni</option>
                                </select>
                            </div> --}}

                            {{-- <div class="col-md-6 form-field">
                                <label class="form-lable">Default Price ($): <span class="text-danger">*</span></label>
                                <input type="number" class="form-control form-input" id="new_default_price" name="new_default_price" step="0.01" required>
                            </div> --}}

                            {{-- <div class="col-md-6 form-field">
                                <label class="form-lable">Product Category: <span class="text-danger">*</span></label>
                                <select class="form-control form-input" id="new_product_category_id" name="new_product_category_id[]" multiple="multiple" required>
                                    @foreach ($productCategories as $productCategory)
                                        <option value="{{$productCategory->id}}">{{$productCategory->product_category_name}}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            {{-- <div class="col-md-6 form-field">
                                <label class="form-lable">Product Sizes: <span class="text-danger">*</span></label>
                                <select class="form-control form-input" id="new_size_id" name="new_size_id" required>
                                    <option value="">Select a Size</option>
                                    <option value="1">YS-XXL</option>
                                    <option value="2">Sock</option>
                                    <option value="3">N/A</option>
                                </select>
                            </div> --}}

                            {{-- <div class="col-md-6 form-field">
                                <label class="form-lable">Standard Fabric:</label>
                                <select class="form-control form-input" id="new_standard_fabric_id" name="new_standard_fabric_id">
                                    @foreach ($fabrics as $fabric)
                                        <option value="{{$fabric->id}}">{{$fabric->fabric_name}}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            {{-- <div class="col-md-6 form-field">
                                <label class="form-lable">Fabric Options:</label>
                                <select class="form-control form-input" id="new_fabric_id" name="new_fabric_id[]" multiple="multiple">
                                    @foreach ($fabrics as $fabric)
                                        <option value="{{$fabric->id}}">{{$fabric->fabric_name}}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            {{-- <div class="col-md-6 form-field">
                                <label class="form-lable">Embellishment Options:</label>
                                <select class="form-control form-input" id="new_embellishment_type_id" name="new_embellishment_type_id[]" multiple="multiple">
                                    @foreach ($embellishmentTypes as $embellishmentType)
                                        <option value="{{$embellishmentType->id}}">{{$embellishmentType->embellishment_name}} @if ($embellishmentType->price != 0) {{'(+$'.$embellishmentType->price.')'}} @endif</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            {{-- <div class="col-md-6 form-field">
                                <label class="form-lable">Attributes:</label>
                                <select class="form-control form-input" id="new_product_attribute_id" name="new_product_attribute_id[]" multiple="multiple">
                                    @foreach ($productAttributes as $productAttribute)
                                        <option value="{{$productAttribute->id}}">{{$productAttribute->attribute_name}} @if ($productAttribute->price != 0) {{'(+$'.$productAttribute->price.')'}} @endif</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            {{-- <div class="col-md-6 form-field">
                                <label class="form-lable">Weight (oz):</label>
                                <input type="number" class="form-control form-input" id="new_weight" name="new_weight"/>
                            </div> --}}

                            {{-- <div class="col-md-6 form-field">
                                <label class="form-lable">Factories:</label>
                                <select class="form-control form-input" id="new_product_factory_id" name="new_product_factory_id[]" multiple="multiple">
                                    @foreach ($factories as $factory)
                                        <option value="{{$factory->id}}">{{$factory->factory_name}}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            {{-- <div class="col-md-6 form-field">
                                <label class="form-lable">Description:</label>
                                <textarea class="form-control form-input" id="new_description" name="new_description" rows="3"></textarea>
                            </div> --}}

                            {{-- <div class="col-md-6 form-field">
                                <label class="form-lable">Notes:</label>
                                <textarea class="form-control form-input" id="new_notes" name="new_notes" rows="3"></textarea>
                            </div> --}}

                            {{-- <hr style="height: 2px; width:100%;">

                            <div class="col-md-12 form-field">
                                <label class="form-lable" style="font-weight: bold">Mockup templates and mockup images</label>
                            </div>

                            <div class="row" style="width: 100%;margin-left: 15px;">
                                <div class="col-md-4">
                                    <div class="row" style="margin-bottom: 10px;">
                                        <label class="form-lable"  style="width: 100%">Mockup Image 1 :</label>
                                    </div>
                                    <div class="row">
                                        <input type="file" id="mockup_img_1" name="mockup_img_1" onchange="uploadFile(1)" style="width: 100%" class="form-lable"/><br/>
                                    </div>
                                    <br/>
                                    <div class="row" style="align-content: center">
                                        <img id="preview_mockup_img_1" style="height: 100px; width: 100px;border-color: black;" src="uploads/default_img.jpg"/>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="row" style="margin-bottom: 10px;">
                                        <label class="form-lable"  style="width: 100%">Mockup Image 2 :</label>
                                    </div>
                                    <div class="row">
                                        <input type="file" id="mockup_img_2" name="mockup_img_2" onchange="uploadFile(2)" style="width: 100%" class="form-lable"/>
                                    </div>
                                    <br/>
                                    <div class="row" style="align-content: center">
                                        <img id="preview_mockup_img_2" style="height: 100px; width: 100px;border-color: black;" src="uploads/default_img.jpg"/>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="row" style="margin-bottom: 10px;">
                                        <label class="form-lable"  style="width: 100%">Mockup Image 3 :</label>
                                    </div>
                                    <div class="row">
                                        <input type="file" id="mockup_img_3" name="mockup_img_3" onchange="uploadFile(3)" style="width: 90%" class="form-lable"/>
                                    </div>
                                    <br/>
                                    <div class="row" style="align-content: center">
                                        <img id="preview_mockup_img_3" style="height: 100px; width: 100px;border-color: black;" src="uploads/default_img.jpg"/>
                                    </div>
                                </div>
                            </div> --}}

                        </div>
                        <div class="col-md-12 mt-3 mb-1">
                            <label for="new_description" class="form-label mb-1" style="color: black">Description</label>
                            <div id="editor-container" style="height: 300px;"></div>
                            <input type="hidden" id="new_description" name="new_description">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns btn-div">
                        @can('edit products')
                        <button type="submit" class="btn btn-success btn-custom frm_submit_btn" >Save</button>
                        @endcan

                        {{-- <button type="button" class="btn btn-danger btn-custom frm_delete_btn delete" data-value="productId">Delete</button> --}}
                        <button  class="btn btn-secondary btn-custom" type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                    </div>
                </div>
            </form>
