<style>
    .select2.select2-container {
        width: 100% !important;
    }
    .table.invoice_details.arange th{
        width: 40%;
    }

    #item_attribute+.select2 {
        width: 100% !important;
    }
    #item_attribute+a {
        display: flex;
    }

    #item_attribute{
        height: 110px !important;
    }

    /* #item_attribute + .select2.select2-container{
        min-height: 100px !important;
    } */
    @media screen and (min-width: 600px) and (max-width: 800px) {
        .div_flexdir{
            flex-wrap: wrap;
            flex-direction: column;
        }
        .div_none{
            max-width: none;
        }
    }
    .modal-content .table th, .modal-content .table td{
        border: none;
        padding-left: 5px !important;
        padding-right: 5px !important;
    }
    .invoice_details {
        border: none !important;
    }
    .modal-body .styleUnique .select2-selection__rendered{
        border: none !important;
    }
    .modal-body .styleUnique .select2-selection--single{
        border: 1px solid #B3B3B3 !important;
        border-radius: 0rem !important;
        height: 25px !important;
    }
    .modal-body .item-datepicker{
        border: 1px solid #B3B3B3;
        color: #717070;
    }
    /* .styleUnique .select2-selection--single{
        border: 1px solid !important;
        border-radius: 0rem;
    } */
    #select2-item_attribute-container{
        border: none !important;
    }
    /* .modal-body .select2-selection--multiple{
        border: 1px solid black;
    } */
    /* .select2-container--below{
        border: 1px solid black !important;
        border-radius: 0rem !important;
    } */
    .specialStyles .select2-container--default .select2-selection--multiple {
        border: 1px solid #B3B3B3 !important;
        border-radius: 0rem;
        min-height: 25px;
    }
    .styleUnique .select2-selection__rendered{
        border: none !important;
    }
    .input-container {
    position: relative;
    }

    .invoice-inputs.modal-datepicker {
    padding-right: 30px; /* Adjust the value to set the icon's position */
    }

    .calendar-icon {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    pointer-events: none;
    color: #717070;
    }
    .select2-container--default.select2-container--disabled .select2-selection--single {
    background-color: transparent;
    }
    .add_new_add_btn {
        border: 1px solid #B3B3B3;
        width: 27%;
        color:#B3B3B3 !important;
    }

    @media (max-width: 768px) {

        .invoice_details.arange,
        .invoice_details.arange thead,
        .invoice_details.arange tbody,
        .invoice_details.arange th,
        .invoice_details.arange td,
        .invoice_details.arange tr {
            display: block;
            width: 100%;
            margin-bottom: unset;
        }

        .invoice_details.arange tr {
            margin-bottom: 15px;
        }

        .invoice_details.arange th {
            display: none; /* hide table headers on mobile */
        }

        .invoice_details.arange td {
            display: flex;
            flex-direction: column;
            padding: 8px 0;
            border: none;
            margin-top: 10px;
        }

        .invoice_details.arange td::before {
            content: attr(data-label);
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }

        .invoice_details.arange input,
        .invoice_details.arange select {
            width: 100% !important;
            height: 34px !important;
            border-radius: 5px !important;
        }
        .modal-body .styleUnique .select2-selection--single {
            height: 34px !important;
            border-radius: 5px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            height: 34px !important;
            border-radius: 5px !important;
            padding-top: 5px;
        }
        .mobile_product_filter_div {
            background-color: #F3F4F6;
            padding: 10px !important;
        }
        .mobile_add_new_add_btn {
            margin-top: 20px;
            width: 100%;
            height: 40px;
            background-color: #F7F8F9;
            color: #A3A7AD !important;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .mobile_footer_btns {
            width: 30%;
            padding: 10px !important;
            font-size: 15px !important;
            border-radius: 8px !important;
        }
        .control-btns {
            display: unset;
            gap: 10px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 4px;
        }


    }

        #add_item_modal .select2-container {
            position: inherit !important;
        }

</style>


<div class="modal fade" id="add_item_modal" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content rmwidth001">
        <div class="modal-header">
            <h3 class="modal-title">Add New Item <span style="color: #B3B3B3;font-size: 1rem;font-weight: 400;" id="modalHeaderText"></span></h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

            @foreach ($orders as $order)
            <form>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row div_flexdir">
                            <div class="col-md-12">
                                <div class="card-updated row" style="margin: 1%;">
                                    {{-- <div class="card-header">Section 1 - Product</div> --}}
                                        <div class="col-md-12 row" style="border: none;margin-left: 1%;margin-right: 2%;">
                                            <div class="col-md-12" style="text-align: end">
                                                <button onclick="filterFielsdOptions()" type="button" style="color: #B3B3B3;cursor:pointer; margin-top:1rem;background-color: transparent;border: none;outline: unset;font-size: .8rem;">FILTERS&nbsp;&nbsp;<i id="FilterHideIcon" class="fa fa-chevron-right" aria-hidden="true"></i></button>
                                            </div>
                                        </div>
                                        <table id="FilterFieldsDiv" class="table invoice_details mt-1 arange mobile_product_filter_div" style="border: none;margin-left: 2%;margin-right: 2%;display:none">
                                            <tr>
                                                <th style="color: black;font-size: 1rem;font-weight: 600 !important;height:40px">Product Filters</th>
                                            </tr>
                                            <tr>
                                                <th style="width: 30%" class="form-label">Sport</th>
                                                <th style="width: 30%" class="form-label">Gender</th>
                                                <th style="width: 30%" class="form-label">Category</th>
                                                <th style="width: 10%"></th>

                                            </tr>
                                            <tr>
                                                <td data-label="Sport">
                                                    <select class="invoice-inputs select2-add-item" name="item_sport" id="item_sport" required>
                                                        <option value="all">Select Sport</option>
                                                        @foreach ($sports as $sport)
                                                            <option value="{{$sport->id}}">{{$sport->sport_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>


                                                <td data-label="Gender">
                                                    <select class="invoice-inputs" name="item_gender" id="item_gender" required>
                                                        <option value="all">Select Gender</option>
                                                        <option value="Men">Men's</option>
                                                        <option value="Women">Women's</option>
                                                        <option value="Uni">Uni</option>
                                                    </select>
                                                </td>


                                                <td data-label="Category">
                                                    <select class="invoice-inputs select2-add-item" name="item_category" id="item_category" required>
                                                        <option value="all">Select Category</option>
                                                        @foreach ($categories as $category)
                                                            <option value='{{$category->id}}'>{{$category->product_category_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td style="border-top-color: white;text-align:left">
                                                    <button type="button" class="btn btn-info btn-sm m-1" style="font-size: 14px; background-color:white; color:grey; border-color:transparent;" id="all_conditions" title="Filter Product">
                                                        <i class="fas fa-solid fa-filter fa-2xs" style="color: #787878;" aria-hidden="true"></i>
                                                    </button>
                                                </td>

                                            </tr>

                                        </table>
                                        <div class="col-md-12 sub-header-style ml-2 mb-1" style="margin-top:0rem">
                                            Select Product
                                        </div>

                                        <table class="table invoice_details arange" style="border: none;margin-left: 1%;margin-right: 2%;">
                                            <tr>
                                                <td class="select-container styleUnique" style="padding-left: .7rem !important;">
                                                    <select class="invoice-inputs select2-add-item" name="item_product" onchange="changeDisplayName()" id="item_product"  required>
                                                        <option selected>Select Product</option>
                                                        {{-- @foreach($products as $product)
                                                            @if ($product->gender == 'Men' && $product->sport == 'Lacrosse')
                                                                <option value="{{$product->id}}">
                                                                    {{$product->product_name}}
                                                                    @if ($product->pattern_code)
                                                                        {{' ('.$product->pattern_code.')'}}
                                                                    @endif
                                                                </option>
                                                            @endif
                                                        @endforeach --}}
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="col-md-12 sub-header-style ml-2 mb-2 mt-2">
                                            Display name
                                        </div>
                                        <table class="table invoice_details arange" style="border: none;margin-left: 1%;margin-right: 2%;">
                                            <tr>
                                                <td class="select-container styleUnique" style="padding-left: .7rem !important;">
                                                    <input class="invoice-inputs" type="text" value="" id="product_display_name" name="product_display_name" style="border: 1px solid #B3B3B3 !important;">
                                                </td>
                                            </tr>
                                        </table>


                                        <div class="col-md-8 sub-header-style mt-3" style="border: none;margin-left: 1%;margin-right: 2%;">
                                            Product Details
                                        </div>
                                        <table class="table invoice_details mt-1 arange" style="border: none;margin-left: 2%;margin-right: 2%;">
                                            <tr>
                                                <th class="form-label"style="width:33.33%">Product Price</th>
                                                <th class="form-label" style="width:33.33%">Item Status</th>
                                                <th class="form-label" style="width:33.33%">Factory</th>

                                            </tr>
                                            <tr>
                                                <td data-label="Product Price" >
                                                    {{-- <input type="hidden" name="product_price" id="product_price" value='' /> --}}
                                                    <div class="input-container">
                                                        <input style="margin-top: -3px;border: 1px solid #B3B3B3 !important;height: 24px;" class="invoice-inputs" name="product_price" id="product_price" type='number' value='' />
                                                    </div>
                                                </td>
                                                <td data-label="Item Status">
                                                    <select class="invoice-inputs select2-add-item" name="status_id" id="status_id" required>
                                                        <option value="">Select Status</option>
                                                        @foreach($orderStatuses as $orderStatus)
                                                        <option value="{{$orderStatus->id}}">{{$orderStatus->status_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td data-label="Factory">
                                                    <select class="invoice-inputs select2-add-item" name="factory_id" id="factory_id" required>
                                                        <option value="">Select Factory</option>
                                                        @foreach($factories as $factory)
                                                        <option value="{{$factory->id}}">{{$factory->factory_code}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="table invoice_details mt-1 arange" style="border: none;margin-left: 2%;margin-right: 2%;">
                                            <input class="invoice-inputs" name="product_no" id="product_no" type='hidden' value='' readonly />
                                            <input type="hidden" name="product_name" id="product_name" value='' />
                                            <input type="hidden" name="pattern_code" id="pattern_code" value='' />
                                            <input type="hidden" name="item_delivery_date" id="item_delivery_date" value='' />
                                            {{-- <input type="hidden" name="product_price" id="product_price" value='' /> --}}
                                            {{-- <tr id="product_selection">
                                                <th>Product Name :</th>
                                                <td>
                                                    <select class="invoice-inputs" name="item_product" id="item_product" required>
                                                        <option value="">Select a Product</option>
                                                        @foreach($products as $product)
                                                        <option value="{{$product->id}}">{{$product->product_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr> --}}

                                            <tr>

                                                <th class="form-label" style="width:33.33%">Primary Fabric</th>
                                                <th class="form-label" style="width:33.33%">Embellishment Type</th>
                                                <th class="form-label" style="width:33.33%">Shipping Method</th>
                                            </tr>
                                            <tr>

                                                <td data-label="Primary Fabric" >
                                                    <select class="invoice-inputs" name="item_fabric" id="item_fabric" required disabled>
                                                        <option value="">Select Primary Fabric</option>

                                                        {{-- @foreach($fabrics as $fabric)
                                                        <option value="{{$fabric->id}}">{{$fabric->fabric_name}}</option>
                                                        @endforeach --}}

                                                    </select>
                                                </td>
                                                <td data-label="Embellishment Type">
                                                    <select class="invoice-inputs" name="item_embellishment" id="item_embellishment" required>
                                                        <option value="">Select Embellishment</option>

                                                        {{-- @foreach($embellishmentTypes as $embellishment)
                                                        <option value="{{$embellishment->id}}">{{$embellishment->embellishment_name}}</option>
                                                        @endforeach --}}

                                                    </select>
                                                </td>
                                                <td data-label="Shipping Method" class="uniqueStylePast">
                                                    <select class="invoice-inputs" name="item_shipping_method" id="item_shipping_method" required>
                                                        <option value="">Select Shipping Method</option>
                                                        <option value="Bulk">Bulk</option>
                                                        <option value="Bulk Sorted">Bulk Sorted</option>
                                                        <option value="DTD">DTD</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr style="height:10px"></tr>
                                            <tr>

                                                <th class="form-label" style="width:33.33%">Ex Factory Date</th>
                                                <th class="form-label" style="width:33.33%">Attributes</th>
                                                <th class="form-label" style="width:33.33%">Secondary Fabric</th>
                                            </tr>
                                            <tr>

                                                <td data-label="Ex Factory Date">
                                                    <div class="input-container">
                                                        <input style="margin-top: -3px" class="invoice-inputs item-datepicker" name="item_ex_factory_date" id="item_ex_factory_date" type='text' value='' onchange="changeAddItemExFactoryDate()" required />
                                                        <i class="fas fa-calendar-alt calendar-icon"></i>
                                                    </div>
                                                </td>
                                                <td data-label="Attributes" class="specialStyles">
                                                    <select class="form-control form-input select2-people" id="item_attribute" name="item_attribute[]"  multiple="multiple">
                                                    </select>
                                                </td>
                                                <td data-label="Secondary Fabric" style="vertical-align: bottom !important;height: 40px;">
                                                    <select class="invoice-inputs select2-add-item" name="item_secondary_fabric" id="item_secondary_fabric">
                                                        <option value="">Select Secondary Fabric</option>
                                                        @foreach($fabrics as $fabric)
                                                        <option value="{{$fabric->id}}">{{$fabric->fabric_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>

                                        <table class="table invoice_details mt-1 arange" style="border: none;margin-left: 2%;margin-right: 2%;">

                                            <tr>

                                                <th class="form-label" style="width:33.33%">Customer In-Hand Date</th>
                                                <th class="form-label clouserForHats1" style="width:33.33%;display:none">Clouser Type</th>
                                                <th></th>

                                            </tr>
                                            <tr>

                                                <td data-label="Customer In-Hand Date">
                                                    <div class="input-container">
                                                        <input style="margin-top: -3px" class="invoice-inputs item-datepicker" name="item_due_date" id="item_due_date" type='text' value='' onchange="changeAddItemCustomerInHandDate()" required />
                                                        <i class="fas fa-calendar-alt calendar-icon"></i>
                                                    </div>
                                                </td>
                                                <td class="clouserForHats1" style="display: none">
                                                    <select class="invoice-inputs select2-add-item" name="clouser_type" id="clouser_type_edit">
                                                        <option value="">Select Clouser Type</option>
                                                        @foreach ($clouser_types as $clouser_type)
                                                        <option value="{{$clouser_type->id}}">{{$clouser_type->clouser_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td></td>
                                            </tr>

                                        </table>

                                        <table class="table invoice_details" style="display: none">
                                            <tr>
                                                <th>Organization :</th>
                                                <td>
                                                    <select class="invoice-inputs select2-add-item" name="item_organization" id="item_organization" disabled>
                                                        <option value="">Select Organization</option>
                                                        @foreach($organizations as $organization)
                                                        <option value="{{$organization->id}}" @if ($organization->id == $order->organizationDetails['id']) selected @endif>{{$organization->organization_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <th>Support Agent :</th>
                                                <td>
                                                    <select class="invoice-inputs select2-add-item" name="item_support_agent" id="item_support_agent" disabled>
                                                        <option value="">Select Support Agent</option>
                                                        @foreach($users as $user)
                                                        <option value="{{$user->id}}" @if ($user->id == $order->userDetails['id']) selected @endif>{{$user->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Unique Item # :</th>
                                                <td>
                                                    <input class="invoice-inputs" name="item_no" id="item_no" type='text' readonly />
                                                    <input type="hidden" id="item_id" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Order # :</th>
                                                <td><input class="invoice-inputs" name="item_order_no" id="item_order_no" type='text' value='{{$order->order_no}}' readonly /></td>
                                            </tr>


                                            <tr id="add_item_tr_encore_packing_date" @if($order->order_type == 0 || ($order->order_type == 1 && $order->address_type == 2)) style="display: none" @endif>
                                                <th>Encore Packing Date :</th>
                                                <td><input class="invoice-inputs item-datepicker" name="item_encore_packing_date" id="item_encore_packing_date" type='text' value='' onchange="changeAddItemEncorePackingDate()" required /></td>
                                            </tr>
                                        </table>
                                        <table class="table invoice_details" style="border: none;margin-left: 2%;margin-right: 2%;">
                                            <tr>
                                                <th class="form-label">Ex-Factory Address</th>
                                            </tr>
                                            <tr>
                                                <td style="display: flex;">
                                                    <select class="invoice-inputs select2-add-item" name="item_ex_factory_id" id="item_ex_factory_id" required>
                                                        <option value="0">Same as Customer Address</option>
                                                        @foreach ($exFactories as $exFactory)
                                                            <option value="{{$exFactory->id}}">{{$exFactory->ex_factory_name}} | {{$exFactory->po_box}}, {{$exFactory->city}}, {{$exFactory->state}}, {{$exFactory->postal_code}}, {{$exFactory->country}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="btn input-group-text add_new_add_btn mobile_add_new_add_btn" style="" data-toggle="modal" data-target="#add_ex_factory_modal">
                                                        <i class="fas fa-plus"></i>&nbsp;ADD NEW ADDRESS
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button type="button" class="swal2-confirm mobile_footer_btns" id="btn_add_item"><i class="fas fa-plus"></i> Add</button>
                        <button type="button" style="background-color: #47D6B6 !important" class="swal2-confirm mobile_footer_btns" id="btn_edit_item"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                        <button type="button" class="swal2-cancel mobile_footer_btns" id="btn_cancel_item"><i class="fas fa-eraser"></i> Clear</button>
                    </div>
                </div>
            </form>
            @endforeach
        </div>
    </div>
</div>

@include('pages.settings.ex_factory.create_modal')

<script>
$(document).ready(function () {

    $('#add_item_modal').on('shown.bs.modal', function () {
console.log('hi');
        $('.select2-add-item').each(function () {

            if ($(this).hasClass('select2-hidden-accessible')) {
                $(this).select2('destroy');
            }

            $(this).select2({
                dropdownParent: $('#add_item_modal'),
                width: '100%'
            });

        });

    });

});
</script>

<script>
    $('#add_item_modal').on('shown.bs.modal', function () {
        $('#add_item_modal select').select2({
            dropdownParent: $('#add_item_modal'),
        });
    });
    function changeDisplayName(){

        var sub_product = @json($subProducts);

        var selected_item = $('#item_product').val();

        var filteredSubProduct = sub_product.find(function(subProduct) {
            return subProduct.id == selected_item;
        });

        if(filteredSubProduct){

            $('#product_display_name').val(filteredSubProduct.product_name);

        }


    }
    $('.item-datepicker').datepicker({ minDate: 0});

</script>

<script>
// document.addEventListener("DOMContentLoaded", function() {
//         var style = document.createElement("style");
//         style.textContent = ".select2-selection.select2-selection--multiple { border: 1px solid #e9ecef!important;}";
//         document.head.appendChild(style);
//     });

        $(document).ready(function() {
            $('#add_item_modal .close').on('click', function() {
                $('#add_item_modal').modal('hide');
            });
        });
        // // Get a reference to the close button
        // const closeButton = document.querySelector('#add_item_modal .close');

        // // Add a click event listener to the close button
        // closeButton.addEventListener('click', function() {
        //   // Programmatically close the modal
        //   const modal = document.getElementById('add_item_modal');
        //   $(modal).modal('hide');
        // });

        var modalHeaderText = document.getElementById("modalHeaderText");

        // Set the value of the hidden input element "item_order_no"
        modalHeaderText.textContent = "  |  #"+document.getElementById("item_order_no").value;

        function filterFielsdOptions() {
            var filterFieldsDiv = document.getElementById("FilterFieldsDiv");
            var filterHideIcon = document.getElementById("FilterHideIcon");

            if (filterFieldsDiv.style.display == "none") {
                // Display the filter fields div
                filterFieldsDiv.style.display = "block";
                // Change the icon to "chevron-down"
                filterHideIcon.className = "fa fa-chevron-down";
            } else {
                // Hide the filter fields div
                filterFieldsDiv.style.display = "none";
                // Change the icon to "chevron-right"
                filterHideIcon.className = "fa fa-chevron-right";
            }
        }



//         var sportSelect = document.getElementById('item_sport');
//         var genderSelect = document.getElementById('item_gender');
//         var categorySelect = document.getElementById('item_category');

//         function populateProductOptions() {
//             var selectedSport = sportSelect.value;
//             var selectedGender = genderSelect.value;
//             var selectedCategory = categorySelect.value;

//             var mainProducts = @json($products);
//             var products = @json($subProducts);
// console.log(selectedGender);
//             console.log(selectedSport,selectedGender,selectedCategory);

//             var productSelect = document.getElementById('item_product');
//             productSelect.innerHTML = ''; // Clear existing options



//             // Iterate over the products array
//             for (var i = 0; i < products.length; i++) {
//                 var product = products[i];
//                 var mainProduct = mainProducts[i];
//         console.log('hi '+selectedGender);
//                 if ((selectedGender === 'all' || product.gender === selectedGender) &&
//                     (selectedSport === 'all' || product.sport === selectedSport) &&
//                     (selectedCategory === 'all' || product.product_category_id === selectedCategory)) {
//                     // Create a new option element
//                     var option = document.createElement('option');
//                     option.value = product.id;
//                     option.textContent = product.product_name;

//                     if (product.pattern_code) {
//                         option.textContent += ' (' + product.pattern_code + ')';
//                     }

//                     // Append the new option to the select box
//                     productSelect.appendChild(option);
//                 }
//             }
//         }

//         // Call the function initially when the page loads
//         populateProductOptions();

//         // Get the filter button element
//         var filterButton = document.getElementById('all_conditions');

//         // Add click event listener to the filter button
//         filterButton.addEventListener('click', function() {
//             populateProductOptions();

//         });


function populateProductOptions() {
    var sportSelect = document.getElementById('item_sport');
    var genderSelect = document.getElementById('item_gender');
    var categorySelect = document.getElementById('item_category');

    var selectedSport = sportSelect.value;
    var selectedGender = genderSelect.value;
    var selectedCategory = categorySelect.value;

    var mainProducts = @json($products);
    var products = @json($subProducts);
    var product_sports = @json($product_sports);
    var product_category = @json($product_category);

    var productSelect = document.getElementById('item_product');
    productSelect.innerHTML = ''; // Clear existing options

    var filteredProducts = [];

    // Filter the sportProduct array to get all matching sport products
    var matchingSportProducts = product_sports.filter(function (sportProduct) {
        return sportProduct.sport_id == selectedSport;
    });

    // Filter the categoryProduct array to get all matching sport products
    var matchingCategoryProducts = product_category.filter(function (categoryProduct) {
        return categoryProduct.	product_category_id == selectedCategory;
    });



    // Get an array of product IDs from the matching sport products
    var matchingProductIDs = matchingSportProducts.map(function (sportProduct) {
        return sportProduct.product_id;
    });

    // Get an array of product IDs from the matching category products
    var matchingProductCategory = matchingCategoryProducts.map(function (categoryProduct) {
        return categoryProduct.product_id;
    });

    // Iterate over the products array
    for (var i = 0; i < products.length; i++) {
        var product = products[i];
        var mainProduct = mainProducts.find(mainProd => mainProd.id == product.parent_product_id);

        if (!mainProduct) {
            continue;
        }

        var mainProductGender = mainProduct.gender; // Gender from mainProduct

        if (
            (selectedGender == 'all' || mainProductGender == selectedGender) &&
            (selectedSport == 'all' || matchingProductIDs.includes(product.id)) &&
            (selectedCategory == 'all' || matchingProductCategory.includes(product.id))
        ) {
            // Create a new option element
            var option = document.createElement('option');
            option.value = product.id;
            option.textContent = product.product_name;

            if (product.pattern_code) {
                option.textContent += ' (' + product.pattern_code + ')';
            }

            // Append the new option to the select box
            productSelect.appendChild(option);

            // Add the filtered product to the array
            filteredProducts.push(product);
        }
    }

    // Now you have the filtered products in the filteredProducts array
    console.log('Filtered Products:', filteredProducts);
}

// Call the function initially when the page loads
populateProductOptions();

// Get the filter button element
var filterButton = document.getElementById('all_conditions');

// Add click event listener to the filter button
filterButton.addEventListener('click', function() {
    populateProductOptions();
});



        // Reset the select elements to their default values
        // function resetSelectElements() {
        //     sportSelect.value = sportSelect.getAttribute('data-default');
        //     genderSelect.value = genderSelect.getAttribute('data-default');
        //     categorySelect.value = categorySelect.getAttribute('data-default');
        // }

        // Add event listener to reset the select elements
        // document.addEventListener('DOMContentLoaded', resetSelectElements);


</script>

<script>
    var factories = <?php echo json_encode($factories) ?>;
    var is_inventory_order = '{{ json_encode($orderTrait->isInventoryOrder($orders[0]->organization_id)) }}' ;

    $(document).ready(function (){
        // $('#item_product').select2({
        //     dropdownParent: $("#product_selection")
        // });

        // $('#add_item_modal').on('shown.bs.modal', function (e) {
        //     var dueDate = $('#due_date').val();
        //     var ex_factory_date = $('#ex_factory_date').val();
        //     var orderStatusId = $('#order_status_id').val();

        //     $('#item_due_date').val(dueDate);
        //     $('#item_delivery_date').val(ex_factory_date);
        //     $('#status_id').val(orderStatusId).change();
        // })

        // $('#add_item_modal #item_due_date').datepicker();
        // $('#add_item_modal #item_delivery_date').datepicker();

    // Filter Products by Sport
        // $('#item_sport').on('change', function(){
        //     var sport = $(this).val();
        //     var gender = $('#item_gender').val();
        //     var category = $('#item_category').val();

        //     $.ajax({
        //         url:"{{ url('orders/product_filter') }}/"+sport+"/"+gender+"/"+category,
        //         method:'GET',
        //         dataType:'json',
        //         success: function (data, textStatus, jqXHR){
        //             $('#item_product').html('<option value="">Select a Product</option>');

        //             for (var i = 0; i < data.length; i++) {
        //                 $('#item_product').append('<option value="'+data[i].id+'">'+data[i].product_name+'</option>');
        //             }
        //         }
        //     });
        // });

    // Filter Products by Gender
        // $('#item_gender').on('change', function(){
        //     var sport = $('#item_sport').val();
        //     var gender = $(this).val();
        //     var category = $('#item_category').val();

        //     $.ajax({
        //         url:"{{ url('orders/product_filter') }}/"+sport+"/"+gender+"/"+category,
        //         method:'GET',
        //         dataType:'json',
        //         success: function (data, textStatus, jqXHR){
        //             console.log(data);
        //             $('#item_product').html('<option value="">Select a Product</option>');

        //             for (var i = 0; i < data.length; i++) {
        //                 $('#item_product').append('<option value="'+data[i].id+'">'+data[i].product_name+'</option>');
        //             }
        //         }
        //     });
        // });

    // Filter Products by Category
        // $('#item_category').on('change', function(){
        //     var sport = $('#item_sport').val();
        //     var gender = $('#item_gender').val();
        //     var category = $(this).val();

        //     $.ajax({
        //         url:"{{ url('orders/product_filter') }}/"+sport+"/"+gender+"/"+category,
        //         method:'GET',
        //         dataType:'json',
        //         success: function (data, textStatus, jqXHR){
        //             console.log(data);
        //             $('#item_product').html('<option value="">Select a Product</option>');

        //             for (var i = 0; i < data.length; i++) {
        //                 $('#item_product').append('<option value="'+data[i].id+'">'+data[i].product_name+'</option>');
        //             }
        //         }
        //     });
        // });

        $('#item_product').on('change', function(){
            var subProductId = $(this).val();

            $.ajax({
                url:"{{ route('filter_sub_products') }}",
                method:'GET',
                dataType:'json',
                data:{ subProductId : subProductId},
                success: function (response){


                    $('#product_no').val(response.sub_product.sub_product_no);
                    $('#product_name').val(response.sub_product.product_name);
                    $('#pattern_code').val(response.sub_product.pattern_code);
                    $('#product_price').val(response.sub_product.default_price);

                    console.log('is hat value :'+response.is_hat);

                    $('.clouserForHats1').hide();
                    if(response.is_hat){
                        $('.clouserForHats1').show();
                    }


                    $('#item_fabric').html('');
                    if(response.is_hat){
                        $('#item_fabric').prop('disabled', false);
                        var fabrics = @json($fabrics);
                        fabrics = fabrics.filter(function(fabric) {
                            return fabric.available_for_hats == 1;
                        });
                        if (fabrics.length > 0) {
                            $('<option value="" selected>Select Fabric</option>').appendTo($('#item_fabric'));
                            for (var i = 0; i < fabrics.length; i++) {
                                var option = $('<option>', {
                                    value: fabrics[i].id,
                                    text: fabrics[i].fabric_name
                                });

                                option.appendTo($('#item_fabric'));
                            }
                        }

                    }else{
                        $('#item_fabric').prop('disabled', true);
                        if(response.product_fabric !== null){

                            $('<option value="" selected>'+response.product_fabric+'</option>').appendTo($('#item_fabric'));

                        }else{
                            $('<option value="" selected>No fabric</option>').appendTo($('#item_fabric'));
                        }
                    }

                    var embellishmentTypeList = response.product_embellishment_type;

                    $('#item_embellishment').html('');
                    if(embellishmentTypeList.length > 0){

                        $('<option value="">Select an Embellishment</option>').appendTo($('#item_embellishment'));

                        for(var i = 0; i < embellishmentTypeList.length; i++){
                            $('<option value="'+ embellishmentTypeList[i].id +'">'+embellishmentTypeList[i].embellishment_name+'</option>').appendTo($('#item_embellishment'));
                        }
                    } else {
                        $('<option value="">No Embellishment</option>').appendTo($('#item_embellishment'));
                    }

                    var productAttribute = response.product_attributes;

                    $('#item_attribute').html('');

                    if(productAttribute.length > 0){
                        if(productAttribute.length > 1){
                            for(var i = 0; i < productAttribute.length; i++){
                                $('<option value="'+ productAttribute[i].id +'">'+productAttribute[i].attribute_name+'</option>').appendTo($('#item_attribute'));
                            }
                        }else{
                            $('<option value="'+ productAttribute[0].id +'" selected>'+productAttribute[0].attribute_name+'</option>').appendTo($('#item_attribute'));
                        }
                    }

                    var productFactory = response.product_factories;

                    $('#factory_id').html('');

                    // if(response.is_hat){
                    //     $('#factory_id').prop('disabled', true);
                    //     var factories = @json($factories);
                    //     console.log(factories);
                    //     if(factories.length > 0){
                    //     for (var i = 0; i < factories.length; i++) {
                    //             var option = $('<option>', {
                    //                 value: factories[i].id,
                    //                 text: factories[i].factory_code,
                    //                 selected: factories[i].id == 10
                    //             });

                    //         option.appendTo($('#factory_id'));
                    //     }

                    //     }

                    // }else{
                        // $('#factory_id').prop('disabled', true);
                    // }
                    if(productFactory.length > 0){
                        if(productFactory.length > 1){
                            for(var i = 0; i < productFactory.length; i++){
                                $('<option value="'+ productFactory[i].id +'">'+productFactory[i].factory_code+'</option>').appendTo($('#factory_id'));
                            }
                        }else{
                            $('<option value="'+ productFactory[0].id +'" selected>'+productFactory[0].factory_code+'</option>').appendTo($('#factory_id'));
                        }
                    }


                    doesEditButtonClick = 0;
                }
            });
        });

        $('#btn_add_item').on('click', function(){
            var itemOrganization = $('#item_organization').val();
            var itemSupportAgent = $('#item_support_agent').val();
            var itemDesigner = $('#item_designer').val() || '';
            var itemShippingMethod = $('#item_shipping_method').val();
            var itemExFactory = $('#item_ex_factory_id').val();
            var itemNo = $('#item_id').val();
            var itemUniqueNo = $('#item_no').val();
            var itemOrderNo = $('#item_order_no').val();
            var itemName = $('#product_name').val();
            var displayName = $('#product_display_name').val();
            var patternCode = $('#pattern_code').val();
            var clouser_type = $('#clouser_type_edit').val();
            var itemStatusId = $('#status_id').val();
            var itemStatus = $('#status_id option:selected').text();
            var itemPrice = $('#product_price').val();
            var itemDeliveryDate = $('#item_delivery_date').val();
            var item_delivery_date = $("#item_delivery_date").val();
            var itemEncorePackingDate = $('#item_encore_packing_date').val();

            var itemDueDate = $('#item_due_date').val();
            var itemProduct = $('#item_product').val();
            var itemFabric = $('#item_fabric').val();
            var itemSecondaryFabric = $('#item_secondary_fabric').val();
            var itemEmbellishment = $('#item_embellishment').val();
            var itemSport = $('#item_sport').val();
            var itemGender = $('#item_gender').val();
            var itemFactory = $('#factory_id').val();
            var itemFactoryName = $('#factory_id option:selected').text();

            var itemFabric_text = ($('#item_fabric option:selected').text()=='Select Primary Fabric')? '' : $('#item_fabric option:selected').text();
            var itemEmbellishment_text = ($('#item_embellishment option:selected').text()=='Select an Embellishment')? '' : $('#item_embellishment option:selected').text();
            var itemAttributes = $("#item_attribute").val();

            var itemAttributes_text="";

            $("#item_attribute option:selected").each(function () {
                var $this = $(this);
                if ($this.length) {
                    var selText = $this.text();
                    if(itemAttributes_text==""){
                        itemAttributes_text=selText;
                    }else{
                        itemAttributes_text=itemAttributes_text+", "+selText;
                    }
                }
            });

            if(itemProduct == ""){
                swal({title: "Invalid Input?", text: 'Please Select a Product', type: "error", confirmButtonColor: "#ce0029",})
                .then((value) => {$($('#item_product').attr('data-focus')).focus();});

            } else {
                var factoryOptions = [];
                for (let i = 0; i < factories.length; i++) {
                    if (factories[i].id == itemFactory) {
                        var selectedOption = 'selected';
                    } else {
                        var selectedOption = '';
                    }
                    factoryOptions += '<option value="'+factories[i].id+'" '+selectedOption+'>'+factories[i].factory_code+'</option>';
                }


                var itemStatus = itemStatus;

                var bgColor = '';
                var textColor = '';

                switch (itemStatus) {
                    case 'Quote':
                        textColor = '#FFB916';
                        bgColor = '#ffffcc';
                        break;
                    case 'Production':
                        textColor = '#47D6B6';
                        bgColor = '#d7ffcc';
                        break;
                    case 'Fulfilled':
                        textColor = '#717070';
                        bgColor = '#f8f8f8';
                        break;
                    case 'Canceled':
                        textColor = '#d65a47';
                        bgColor = '#ffcccc';
                        break;
                }

                // $row = '<tr>'+
                //     '<td style="display:none"></td>'+
                //     '<td style="padding-left: .1rem;"><input type="text" class="invoice-inputs item_name" name="item['+itemNo+'][item_name]" value="'+itemName+'" readonly /></td>'+

                //     '<td><input type="text" class="invoice-inputs text-left status status-lable" style="padding-left: 0px !important; color: '+textColor+' !important;background-color:'+bgColor+' !important;" name="item['+itemNo+'][status]" value="'+itemStatus+'" readonly /></td>'+
                //     '<td><input type="text" class="invoice-inputs text-left delivery_date" style="padding-left: 0px !important;" name="item['+itemNo+'][est_delivery_date]" value="'+itemDeliveryDate+'" readonly /></td>'+
                //     '<td style="min-width: 100px;padding-left:0px">'+
                //         '<select class="invoice-inputs factory_id" name="item['+itemNo+'][factory_id]">'+
                //             '<option value="">Select Factory</option>'+
                //             factoryOptions +
                //         '</select>'+
                //     // '<input type="text" class="invoice-inputs" value="'+itemFactoryName+'" />'+
                //     '</td>'+


                //     '<td><input type="text" class="invoice-inputs item-fabric text-left" name="item['+itemNo+'][fabric]" style="padding-left: 0;" value="'+itemFabric_text+'" readonly /></td>'+
                //     '<td><input type="text" class="invoice-inputs item-embellishment text-left" name="item['+itemNo+'][embellishment]" style="padding-left: 0;" value="'+itemEmbellishment_text+'" readonly /></td>'+

                //     '<td><input type="text" style="padding-right: 0;" class="invoice-inputs item-qty text-center" name="item['+itemNo+'][qty]" value="0" /></td>'+
                //     '<td><input type="text" style="padding-right: 0;" class="invoice-inputs item-price text-right" name="item['+itemNo+'][unit_price]" value="'+itemPrice+'" readonly /></td>'+
                //     '<td><input type="text" style="padding-right: 0;" class="invoice-inputs item-total text-right" name="item['+itemNo+'][total]" value="0" readonly /></td>'+

                //     '<td>'+

                //         // '<button type="button" value="'+itemNo+'" class="btn btn-success btn-sm btn-sm-custom btn-gray" title="Edit"><i class="fas fa-eye"></i></button>'+
                //         '<button type="button" style="border: none;background-color: transparent;outline: unset;cursor:pointer" value="'+itemNo+'" class="edit-item" id="edit_item_'+itemNo+'" title="Edit"><i class="fas fa-edit"></i></button>'+
                //         '<button type="button" style="border: none;background-color: transparent;outline: unset;cursor:pointer" value="'+itemNo+'" class="remove-item" title="Delete"><i class="fas fa-trash-alt"></i></button>'+
                //     '</td>'+
                //     '<input type="hidden" name="item['+itemNo+'][organization_id]" class="organization_id" value="'+itemOrganization+'" />'+
                //     '<input type="hidden" name="item['+itemNo+'][support_agent_id]" class="support_agent_id" value="'+itemSupportAgent+'" />'+
                //     '<input type="hidden" name="item['+itemNo+'][designer_id]" class="designer_id" value="'+itemDesigner+'" />'+
                //     '<input type="hidden" name="item['+itemNo+'][shipping_method]" class="shipping_method" value="'+itemShippingMethod+'" />'+
                //     '<input type="hidden" name="item['+itemNo+'][ex_factory_id]" class="ex_factory_id" value="'+itemExFactory+'" />'+
                //     '<input type="hidden" name="item['+itemNo+'][item_no]" class="item_no" value="'+itemUniqueNo+'" />'+
                //     '<input type="hidden" name="item['+itemNo+'][order_id]" class="order_id" value="'+itemOrderNo+'" />'+

                //     '<input type="hidden" name="item['+itemNo+'][ex_factory_date]" class="in_hand_due_date" value="'+item_delivery_date+'" />'+
                //     '<input type="hidden" name="item['+itemNo+'][encore_packing_date]" class="encore_packing_date" value="'+itemEncorePackingDate+'" />'+
                //     '<input type="hidden" name="item['+itemNo+'][in_hand_due_date]" class="in_hand_due_date" value="'+itemDueDate+'" />'+

                //     '<input type="hidden" name="item['+itemNo+'][status_id]" class="status_id" value="'+itemStatusId+'" />'+
                //     '<input type="hidden" name="item['+itemNo+'][product_id]" class="product_id" value="'+itemProduct+'" />'+
                //     '<input type="hidden" name="item['+itemNo+'][fabric_id]" class="fabric_id" value="'+itemFabric+'" />'+
                //     '<input type="hidden" name="item['+itemNo+'][secondary_fabric_id]" class="secondary_fabric_id" value="'+itemSecondaryFabric+'" />'+
                //     '<input type="hidden" name="item['+itemNo+'][embellishment_id]" class="embellishment_id" value="'+itemEmbellishment+'" />'+
                //     '<input type="hidden" name="item['+itemNo+'][sport]" class="sport" value="'+itemSport+'" />'+
                //     '<input type="hidden" name="item['+itemNo+'][gender]" class="gender" value="'+itemGender+'" />'+
                //     '<input type="hidden" name="item['+itemNo+'][factory_id]" class="factory_id" value="'+itemFactory+'" />'+
                //     '<input type="hidden" name="item['+itemNo+'][itemAttribute_ids]" class="itemAttribute_ids" value="'+itemAttributes+'" />'+
                //     '</tr>';
                    if (is_inventory_order=="true") {
                        $row = '<tr data-item-no="'+itemNo+'">'+
                            '<td style="display:none"></td>'+
                            '<td style="padding-left: .1rem;"><input type="text" class="invoice-inputs item_name" name="item['+itemNo+'][item_name]" value="'+displayName+'" style="width:auto" readonly /></td>'+

                            '<td><input type="text" class="invoice-inputs text-left status status-lable" style="padding-left: 0px !important; color: '+textColor+' !important;background-color:'+bgColor+' !important;" name="item['+itemNo+'][status]" value="'+itemStatus+'" readonly /></td>'+
                            '<td><input type="text" class="invoice-inputs text-left delivery_date" style="padding-left: 0px !important;" name="item['+itemNo+'][est_delivery_date]" value="'+itemDeliveryDate+'" readonly /></td>'+
                            '<td style="min-width: 100px;padding-left:0px">'+
                                '<select class="invoice-inputs factory_id" name="item['+itemNo+'][factory_id]">'+
                                    '<option value="">Select Factory</option>'+
                                    factoryOptions +
                                '</select>'+
                            // '<input type="text" class="invoice-inputs" value="'+itemFactoryName+'" />'+
                            '</td>'+


                            '<td><input type="text" class="invoice-inputs item-fabric text-left" name="item['+itemNo+'][fabric]" style="padding-left: 0;" value="'+itemFabric_text+'" readonly /></td>'+
                            '<td><input type="text" class="invoice-inputs item-embellishment text-left" name="item['+itemNo+'][embellishment]" style="padding-left: 0;width: 8rem;" value="'+itemEmbellishment_text+'" readonly /></td>'+

                            '<td><input type="text" style="padding-right: 0;" class="invoice-inputs item-qty text-center" name="item['+itemNo+'][qty]" value="0" /></td>'+
                            // '<td><input type="text" style="padding-right: 0;" class="invoice-inputs item-price text-right" name="item['+itemNo+'][unit_price]" value="'+itemPrice+'" readonly /></td>'+
                            // '<td><input type="text" style="padding-right: 0;" class="invoice-inputs item-total text-right" name="item['+itemNo+'][total]" value="0" readonly /></td>'+

                            '<td>'+

                                // '<button type="button" value="'+itemNo+'" class="btn btn-success btn-sm btn-sm-custom btn-gray" title="Edit"><i class="fas fa-eye"></i></button>'+
                                '<button type="button" style="border: none;background-color: transparent;outline: unset;cursor:pointer" value="'+itemNo+'" class="edit-item" id="edit_item_'+itemNo+'" title="Edit"><i class="fas fa-edit"></i></button>'+
                                '<button type="button" style="border: none;background-color: transparent;outline: unset;cursor:pointer" value="'+itemNo+'" class="remove-item" title="Delete"><i class="fas fa-trash-alt"></i></button>'+
                            '</td>'+
                            '<input type="hidden" name="item['+itemNo+'][organization_id]" class="organization_id" value="'+itemOrganization+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][support_agent_id]" class="support_agent_id" value="'+itemSupportAgent+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][designer_id]" class="designer_id" value="'+itemDesigner+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][shipping_method]" class="shipping_method" value="'+itemShippingMethod+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][ex_factory_id]" class="ex_factory_id" value="'+itemExFactory+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][item_no]" class="item_no" value="'+itemUniqueNo+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][order_id]" class="order_id" value="'+itemOrderNo+'" />'+

                            '<input type="hidden" name="item['+itemNo+'][ex_factory_date]" class="in_hand_due_date" value="'+item_delivery_date+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][encore_packing_date]" class="encore_packing_date" value="'+itemEncorePackingDate+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][in_hand_due_date]" class="in_hand_due_date" value="'+itemDueDate+'" />'+

                            '<input type="hidden" name="item['+itemNo+'][status_id]" class="status_id" value="'+itemStatusId+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][product_id]" class="product_id" value="'+itemProduct+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][fabric_id]" class="fabric_id" value="'+itemFabric+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][secondary_fabric_id]" class="secondary_fabric_id" value="'+itemSecondaryFabric+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][embellishment_id]" class="embellishment_id" value="'+itemEmbellishment+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][sport]" class="sport" value="'+itemSport+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][gender]" class="gender" value="'+itemGender+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][factory_id]" class="factory_id" value="'+itemFactory+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][itemAttribute_ids]" class="itemAttribute_ids" value="'+itemAttributes+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][clouser_type]" class="clouser_type" value="'+clouser_type+'" />'+
                            '</tr>';

                            var mobileCard = `
                                <div class="mobile-item-card" data-item-no="${itemNo}">

                                    <div class="mobile-item-header">
                                        <div>
                                            <h6 class="mb-1 mobile_product_name">${displayName}</h6>
                                        </div>

                                        <div class="mobile-item-actions">
                                            <button type="button"
                                                style="border:none;background:transparent"
                                                value="${itemNo}"
                                                class="edit-item"
                                                id="edit_item_${itemNo}">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button type="button"
                                                style="border:none;background:transparent"
                                                value="${itemNo}"
                                                class="remove-item">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mobile-item-body">

                                        <div class="row">

                                            <div class="col-6 mb-3">
                                                <label class="mobile-label">Status</label>
                                                <div class="mobile-value">
                                                    <span class="mobile-status" style="color:${textColor}">
                                                        ${itemStatus}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <label class="mobile-label">Est Delivery</label>
                                                <div class="mobile-value">
                                                    ${itemDeliveryDate || '-'}
                                                </div>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <label class="mobile-label">Factory</label>
                                                <div class="mobile-value">
                                                    ${itemFactoryName || '-'}
                                                </div>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <label class="mobile-label">Fabric</label>
                                                <div class="mobile-value">
                                                    ${itemFabric_text || '-'}
                                                </div>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <label class="mobile-label">Embellishment</label>
                                                <div class="mobile-value">
                                                    ${itemEmbellishment_text || '-'}
                                                </div>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <label class="mobile-label">Qty</label>
                                                <div class="mobile-value">0</div>
                                            </div>

                                            ${is_inventory_order == "true" ? "" : `
                                            <div class="col-6 mb-3">
                                                <label class="mobile-label">Unit Price</label>
                                                <div class="mobile-value">$${parseFloat(itemPrice).toFixed(2)}</div>
                                            </div>

                                            <div class="col-12">
                                                <div class="d-flex justify-content-between align-items-center mobile_total_price">
                                                    <label class="mobile-label mb-0">Total</label>
                                                    <div class="mobile-value">$0.00</div>
                                                </div>
                                            </div>
                                            `}

                                        </div>

                                    </div>

                                </div>`;
                    } else {console.log('Hi 3');
                        $row = '<tr data-item-no="'+itemNo+'">'+
                            '<td style="display:none"></td>'+
                            '<td style="padding-left: .1rem;"><input type="text" class="invoice-inputs item_name" name="item['+itemNo+'][item_name]" value="'+displayName+'" style="width:auto" readonly /></td>'+

                            '<td><input type="text" class="invoice-inputs text-left status status-lable" style="padding-left: 0px !important; color: '+textColor+' !important;background-color:'+bgColor+' !important;" name="item['+itemNo+'][status]" value="'+itemStatus+'" readonly /></td>'+
                            '<td><input type="text" class="invoice-inputs text-left delivery_date" style="padding-left: 0px !important;" name="item['+itemNo+'][est_delivery_date]" value="'+itemDeliveryDate+'" readonly /></td>'+
                            '<td style="min-width: 100px;padding-left:0px">'+
                                '<select class="invoice-inputs factory_id" name="item['+itemNo+'][factory_id]">'+
                                    '<option value="">Select Factory</option>'+
                                    factoryOptions +
                                '</select>'+
                            // '<input type="text" class="invoice-inputs" value="'+itemFactoryName+'" />'+
                            '</td>'+


                            '<td><input type="text" class="invoice-inputs item-fabric text-left" name="item['+itemNo+'][fabric]" style="padding-left: 0;" value="'+itemFabric_text+'" readonly /></td>'+
                            '<td><input type="text" class="invoice-inputs item-embellishment text-left" name="item['+itemNo+'][embellishment]" style="padding-left: 0;width: 8rem;" value="'+itemEmbellishment_text+'" readonly /></td>'+

                            '<td><input type="text" style="padding-right: 0;" class="invoice-inputs item-qty text-center" name="item['+itemNo+'][qty]" value="0" /></td>'+
                            // '<td><input type="text" style="padding-right: 0;" class="invoice-inputs item-price text-right" name="item['+itemNo+'][unit_price]" value="'+itemPrice+'" readonly /></td>'+
                            // '<td><input type="text" style="padding-right: 0;" class="invoice-inputs item-total text-right" name="item['+itemNo+'][total]" value="0" readonly /></td>'+

                            '<td><input type="text" style="padding-right: 0;" class="invoice-inputs item-price text-right" name="item['+itemNo+'][unit_price]" value="'+itemPrice+'" readonly /></td>'+
                            '<td><input type="text" style="padding-right: 0;" class="invoice-inputs item-total text-right" name="item['+itemNo+'][total]" value="0" readonly /></td>'+

                            '<td>'+

                                // '<button type="button" value="'+itemNo+'" class="btn btn-success btn-sm btn-sm-custom btn-gray" title="Edit"><i class="fas fa-eye"></i></button>'+
                                '<button type="button" style="border: none;background-color: transparent;outline: unset;cursor:pointer" value="'+itemNo+'" class="edit-item" id="edit_item_'+itemNo+'" title="Edit"><i class="fas fa-edit"></i></button>'+
                                '<button type="button" style="border: none;background-color: transparent;outline: unset;cursor:pointer" value="'+itemNo+'" class="remove-item" title="Delete"><i class="fas fa-trash-alt"></i></button>'+
                            '</td>'+
                            '<input type="hidden" name="item['+itemNo+'][organization_id]" class="organization_id" value="'+itemOrganization+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][support_agent_id]" class="support_agent_id" value="'+itemSupportAgent+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][designer_id]" class="designer_id" value="'+itemDesigner+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][shipping_method]" class="shipping_method" value="'+itemShippingMethod+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][ex_factory_id]" class="ex_factory_id" value="'+itemExFactory+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][item_no]" class="item_no" value="'+itemUniqueNo+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][order_id]" class="order_id" value="'+itemOrderNo+'" />'+

                            '<input type="hidden" name="item['+itemNo+'][ex_factory_date]" class="in_hand_due_date" value="'+item_delivery_date+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][encore_packing_date]" class="encore_packing_date" value="'+itemEncorePackingDate+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][in_hand_due_date]" class="in_hand_due_date" value="'+itemDueDate+'" />'+

                            '<input type="hidden" name="item['+itemNo+'][status_id]" class="status_id" value="'+itemStatusId+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][product_id]" class="product_id" value="'+itemProduct+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][fabric_id]" class="fabric_id" value="'+itemFabric+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][secondary_fabric_id]" class="secondary_fabric_id" value="'+itemSecondaryFabric+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][embellishment_id]" class="embellishment_id" value="'+itemEmbellishment+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][sport]" class="sport" value="'+itemSport+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][gender]" class="gender" value="'+itemGender+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][factory_id]" class="factory_id" value="'+itemFactory+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][itemAttribute_ids]" class="itemAttribute_ids" value="'+itemAttributes+'" />'+
                            '<input type="hidden" name="item['+itemNo+'][clouser_type]" class="clouser_type" value="'+clouser_type+'" />'+
                            '</tr>';

                            var mobileCard = `
                                <div class="mobile-item-card" data-item-no="${itemNo}">

                                    <div class="mobile-item-header">
                                        <div>
                                            <h6 class="mb-1 mobile_product_name">${displayName}</h6>
                                        </div>

                                        <div class="mobile-item-actions">
                                            <button type="button"
                                                style="border:none;background:transparent"
                                                value="${itemNo}"
                                                class="edit-item"
                                                id="edit_item_${itemNo}">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button type="button"
                                                style="border:none;background:transparent"
                                                value="${itemNo}"
                                                class="remove-item">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mobile-item-body">

                                        <div class="row">

                                            <div class="col-6 mb-3">
                                                <label class="mobile-label">Status</label>
                                                <div class="mobile-value">
                                                    <span class="mobile-status" style="color:${textColor}">
                                                        ${itemStatus}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <label class="mobile-label">Est Delivery</label>
                                                <div class="mobile-value">
                                                    ${itemDeliveryDate || '-'}
                                                </div>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <label class="mobile-label">Factory</label>
                                                <div class="mobile-value">
                                                    ${itemFactoryName || '-'}
                                                </div>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <label class="mobile-label">Fabric</label>
                                                <div class="mobile-value">
                                                    ${itemFabric_text || '-'}
                                                </div>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <label class="mobile-label">Embellishment</label>
                                                <div class="mobile-value">
                                                    ${itemEmbellishment_text || '-'}
                                                </div>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <label class="mobile-label">Qty</label>
                                                <div class="mobile-value">0</div>
                                            </div>

                                            ${is_inventory_order == "true" ? "" : `
                                            <div class="col-6 mb-3">
                                                <label class="mobile-label">Unit Price</label>
                                                <div class="mobile-value">$${parseFloat(itemPrice).toFixed(2)}</div>
                                            </div>

                                            <div class="col-12">
                                                <div class="d-flex justify-content-between align-items-center mobile_total_price">
                                                    <label class="mobile-label mb-0">Total</label>
                                                    <div class="mobile-value">$0.00</div>
                                                </div>
                                            </div>
                                            `}

                                        </div>

                                    </div>

                                </div>`;
                    }

                $('#product_table_body tr:last').after($row);
                $('#add_item_modal').modal('hide');

                $('#item_designer').val('');
                $('#item_shipping_method').val('');
                $('#item_ex_factory_id').val(0);
                $('#product_name').val('');
                $('#status_id').val('');
                $('#product_price').val('');
                $('#item_product').val('');
                $('#item_fabric').val('');
                $('#item_secondary_fabric').val('');
                $('#item_embellishment').val('');
                $('#product_no').val('');
                $('#item_sport').val('all');
                $('#item_gender').val('all');
                $('#item_category').val('all');
                $('#factory_id').val('');
                $('#row_no').val(parseInt(itemNo)+1);

                $('.mobile-order-cards').append(mobileCard);
            }
        });

        $('#btn_edit_item').on('click', function(){

            var itemOrganization = $('#item_organization').val();
            var itemSupportAgent = $('#item_support_agent').val();
            var itemDesigner = $('#item_designer').val() || '';
            var itemShippingMethod = $('#item_shipping_method').val();
            var itemExFactory = $('#item_ex_factory_id').val();
            var itemNo = $('#item_id').val();
            var itemUniqueNo = $('#item_no').val();
            var itemOrderNo = $('#item_order_no').val();
            var itemName = $('#product_name').val();
            var displayName = $('#product_display_name').val();
            var patternCode = $('#pattern_code').val();
            var clouser_type = $('#clouser_type_edit').val();
            var itemStatusId = $('#status_id').val();
            var itemStatus = $('#status_id option:selected').text();
            var itemPrice = $('#product_price').val();
            var itemDeliveryDate = $('#item_delivery_date').val();

            var itemEncorePackingDate = $('#item_encore_packing_date').val();

            var itemDueDate = $('#item_due_date').val();
            var itemProduct = $('#item_product').val();
            var itemFabric = $('#item_fabric').val();
            var itemSecondaryFabric = $('#item_secondary_fabric').val();
            var itemEmbellishment = $('#item_embellishment').val();
            var itemSport = $('#item_sport').val();
            var itemGender = $('#item_gender').val();
            var itemFactory = $('#factory_id').val();

            var itemFabric_text = ($('#item_fabric option:selected').text()=='Select Primary Fabric')? '' : $('#item_fabric option:selected').text();
            var itemEmbellishment_text = ($('#item_embellishment option:selected').text()=='Select an Embellishment')? '' : $('#item_embellishment option:selected').text();
            var itemAttributes = $("#item_attribute").val();

            var itemAttributes_text="";

            $("#item_attribute option:selected").each(function () {
                var $this = $(this);
                if ($this.length) {
                    var selText = $this.text();
                    if(itemAttributes_text==""){
                        itemAttributes_text=selText;
                    }else{
                        itemAttributes_text=itemAttributes_text+", "+selText;
                    }
                }
            });

            var itemTr = $('#edit_item_'+itemNo).closest('tr');

            if(itemProduct == ""){
                swal({title: "Invalid Input?", text: 'Please Select a Product', type: "error", confirmButtonColor: "#ce0029",})
                .then((value) => {$($('#item_product').attr('data-focus')).focus();});

            } else {

                itemTr.find('.organization_id').val(itemOrganization);
                itemTr.find('.support_agent_id').val(itemSupportAgent);
                itemTr.find('.designer_id').val(itemDesigner);
                itemTr.find('.shipping_method').val(itemShippingMethod);
                itemTr.find('.ex_factory_id').val(itemExFactory);
                itemTr.find('.item_name').val(displayName);
                itemTr.find('.pattern_code').val(patternCode);
                itemTr.find('.clouser_type').val(clouser_type);
                itemTr.find('.status_id').val(itemStatusId);
                itemTr.find('.status').val(itemStatus);
                itemTr.find('.item-price').val(itemPrice);
                itemTr.find('.delivery_date').val(itemDeliveryDate);

                itemTr.find('.encore_packing_date').val(itemEncorePackingDate);

                itemTr.find('.in_hand_due_date').val(itemDueDate);
                itemTr.find('.product_id').val(itemProduct);
                itemTr.find('.fabric_id').val(itemFabric);
                itemTr.find('.secondary_fabric_id').val(itemSecondaryFabric);
                itemTr.find('.embellishment_id').val(itemEmbellishment);
                itemTr.find('.sport').val(itemSport);
                itemTr.find('.gender').val(itemGender);
                itemTr.find('.factory_id').val(itemFactory);
                itemTr.find('.item-fabric').val(itemFabric_text);
                itemTr.find('.item-embellishment').val(itemEmbellishment_text);

                itemTr.find('.itemAttribute_ids').val(itemAttributes);
                itemTr.find('.attributes').val(itemAttributes_text);

                $('#add_item_modal').modal('hide');

                $('#item_designer').val('');
                $('#item_shipping_method').val('');
                $('#item_ex_factory_id').val(0);
                $('#product_name').val('');
                $('#status_id').val('');
                $('#product_price').val('');
                $('#item_product').val('');
                $('#item_fabric').val('');
                $('#clouser_type_edit').val('');
                $('#item_secondary_fabric').val('');
                $('#item_embellishment').val('');
                $('#product_no').val('');
                $('#item_sport').val('all');
                $('#item_gender').val('all');
                $('#item_category').val('all');
                $('#factory_id').val('');
            }
        });

        $('#all_conditions').on('click', function(){
            $('#item_sport').val('all');
            $('#item_gender').val('all');
            $('#item_category').val('all');
        });

        $('#btn_cancel_item').on('click', function(){
            addItemReset();
            addItemStart();
        });
    });

    function addItemStart(){
        $('#btn_edit_item').hide();
        $('#btn_add_item').show();

        var itemNo = $('#row_no').val();
        $('#item_id').val(itemNo);

        var orderNo = $('#order_no').val();
        $('#item_no').val(orderNo+'-'+itemNo);

        var dueDate = $('#due_date').val();
        var encore_packing_date = $('#encore_packing_date').val();
        var ex_factory_date = $('#ex_factory_date').val();
        var orderStatusId = $('#order_status_id').val();
        if(orderStatusId == 8){
            orderStatusId = 3;
        }

        $('#item_due_date').val(dueDate);
        $('#item_encore_packing_date').val(encore_packing_date);
        $('#item_delivery_date').val(ex_factory_date);
        $('#status_id').val(orderStatusId).change();
    }

    var doesEditButtonClick = 0;
    var local_itemFabric = "";
    var local_itemEmbellishment = "";
    var local_itemAttributes = "";

    function editItemStart(itemNo, itemTr){
        $('#btn_add_item').hide();
        $('#btn_edit_item').show();

        var itemOrganization = itemTr.find('.organization_id').val();
        var itemSupportAgent = itemTr.find('.support_agent_id').val();
        var itemDesigner = itemTr.find('.designer_id').val() || '';
        var itemShippingMethod = itemTr.find('.shipping_method').val();
        var itemExFactory = itemTr.find('.ex_factory_id').val();
        var itemUniqueNo = itemTr.find('.item_no').val();
        var itemOrderNo = itemTr.find('.order_id').val();
        var itemStatusId = itemTr.find('.status_id').val();
        var clouser_type = itemTr.find('.clouser_type').val();
        var itemDeliveryDate = itemTr.find('.delivery_date').val();
        var DisplayName = itemTr.find('.item_name').val();
        var itemPrice = itemTr.find('.item-price').val();

        var itemEncorePackingDate = itemTr.find('.encore_packing_date').val();

        var itemDueDate = itemTr.find('.in_hand_due_date').val();
        var itemProduct = itemTr.find('.product_id').val();
        var itemFabric = itemTr.find('.fabric_id').val();
        var itemSecondaryFabric = itemTr.find('.secondary_fabric_id').val();
        var itemEmbellishment = itemTr.find('.embellishment_id').val();
        var itemSport = itemTr.find('.sport').val();
        var itemGender = itemTr.find('.gender').val();
        var itemFactory = itemTr.find('.factory_id').val();

        var itemAttributes = itemTr.find('.itemAttribute_ids').val();

        $('#item_organization').val(itemOrganization).trigger('change');
        $('#item_support_agent').val(itemSupportAgent).trigger('change');
        $('#item_designer').val(itemDesigner).trigger('change');
        $('#item_shipping_method').val(itemShippingMethod).trigger('change');
        $('#item_ex_factory_id').val(itemExFactory).trigger('change');
        $('#item_id').val(itemNo);
        $('#item_no').val(itemUniqueNo);
        $('#item_order_no').val(itemOrderNo);
        $('#status_id').val(itemStatusId).trigger('change');
        $('#clouser_type_edit').val(clouser_type).trigger('change');
        $('#item_delivery_date').val(itemDeliveryDate);

        $('#product_display_name').val(DisplayName);
        $('#product_price').val(itemPrice);

        $('#item_encore_packing_date').val(itemEncorePackingDate);

        $('#item_due_date').val(itemDueDate);
        $('#item_product').val(itemProduct).trigger('change');
        $('#item_fabric').val(itemFabric).trigger('change');
        $('#item_secondary_fabric').val(itemSecondaryFabric).trigger('change');
        $('#item_embellishment').val(itemEmbellishment).trigger('change');
        $('#item_sport').val(itemSport).trigger('change');
        $('#item_gender').val(itemGender).trigger('change');
        $('#factory_id').val(itemFactory).trigger('change');

        doesEditButtonClick = 1;
        local_itemFabric = itemFabric;
        local_itemEmbellishment = itemEmbellishment;
        // local_itemAttributes = JSON.parse("["+itemAttributes+"]");
    }

    function addItemReset(){
        $('#item_designer').val('').trigger('change');
        $('#item_shipping_method').val('').trigger('change');
        $('#item_ex_factory_id').val(0).trigger('change');
        $('#product_name').val('');
        $('#status_id').val('').trigger('change');
        $('#pattern_code').val('');
        $('#clouser_type_edit').val('');
        $('#product_price').val('');
        $('#item_product').val('').trigger('change');
        $('#item_fabric').val('').trigger('change');
        $('#item_secondary_fabric').val('').trigger('change');
        $('#item_embellishment').val('').trigger('change');
        $('#product_no').val('');
        $('#item_sport').val('all').trigger('change');
        $('#item_gender').val('all').trigger('change');
        $('#item_category').val('all').trigger('change');
        $('#factory_id').val('').trigger('change');
        $('#product_display_name').val('');
    }

    function changeAddItemExFactoryDate(){
        var ex_factory_date = $("#item_delivery_date").val();
        var order_type = $("#order_type").val();
        var address_type = $("#address_type").val();

        if(order_type == 0 || (order_type == 1 && address_type==2)){

            $.ajax({
                url:"{{ url('due_date/ex_factory_date') }}",
                method:'POST',
                dataType:'json',
                data: {
                    'ex_factory_date': ex_factory_date, 'typeID': 1, '_token':'{{csrf_token()}}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data){
                    $('#item_due_date').val(data);
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });

        }else if(order_type == 1){

            $.ajax({
                url:"{{ url('due_date/ex_factory_date') }}",
                method:'POST',
                dataType:'json',
                data: {
                    'ex_factory_date': ex_factory_date, 'typeID': 2, '_token':'{{csrf_token()}}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data){
                    $('#item_encore_packing_date').val(data[0]);
                    $('#item_due_date').val(data[1]);
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });

        }

    }

    function changeAddItemEncorePackingDate(){
        var encore_packing_date = $("#item_encore_packing_date").val();

        $.ajax({
            url:"{{ url('encore_packing_date') }}",
            method:'POST',
            dataType:'json',
            data: {
                'encore_packing_date': encore_packing_date, '_token':'{{csrf_token()}}'
            },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (data){
                $('#item_delivery_date').val(data[0]);
                $('#item_due_date').val(data[1]);
            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    }

    function changeAddItemCustomerInHandDate(){
        var due_date = $("#item_due_date").val();
        var order_type = $("#order_type").val();
        var address_type = $("#address_type").val();

        if(order_type == 0 || (order_type == 1 && address_type==2)){

            $.ajax({
                url:"{{ url('ex_factory_date/due_date') }}",
                method:'POST',
                dataType:'json',
                data: {
                    'due_date': due_date,'typeID': 1, '_token':'{{csrf_token()}}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data){
                    $('#item_delivery_date').val(data);
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });

        }else if(order_type == 1){

            $.ajax({
                url:"{{ url('ex_factory_date/due_date') }}",
                method:'POST',
                dataType:'json',
                data: {
                    'due_date': due_date,'typeID': 2, '_token':'{{csrf_token()}}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data){
                    $('#item_delivery_date').val(data[0]);
                    $('#item_encore_packing_date').val(data[1]);
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });

        }
    }
</script>
