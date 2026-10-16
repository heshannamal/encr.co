<style>
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
    }
    .styleUnique .select2-selection__rendered{
        border: none !important;
    }
    .uniqueStylePast .select2-container--default{
        margin-top: .5rem;
    }
    .newOrderStyles .select2-selection__rendered{
        border: 1px solid #DEDEDE;
        border-radius: 0rem !important;
        color: #717070 !important;
        padding-left: 7px !important;
        font-size: 0.8rem !important;
        height: calc(1.5rem + 1px) !important;
    }
    .newOrderStyles #item_attribute + .select2.select2-container {
        min-height: 10px !important;
    }
    .newOrderStyles .select2-selection.select2-selection--multiple {
        border: 1px solid #e9ecef!important;
        height: 20px !important;
    }
    .newOrderStyles .modal-datepicker.hasDatepicker{
        padding: 5px;
        padding-left: 6px;
        height: calc(1.5rem + 1px);
        border-radius: 0rem !important;
        color: #717070;
        border: 1px solid #DEDEDE;
        margin-top: 5px;
    }
</style>
<div class="modal fade newOrderStyles" id="add_item_modal" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding-left: 2.5rem;">
                <h3 class="modal-title" id="modal-title-default" style="color: black">Add a New Item</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form id="add_modal_form">
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row div_flexdir">
                            <div class="col-md-12">
                                <div class="card-updated row">
                                    {{-- <div class="card-header">Section 1 - Product</div> --}}
                                    <div class="col-md-12 row" style="border: none;margin-left: 1%;margin-right: 2%;">
                                        <div class="col-md-12" style="text-align: end">
                                            <button onclick="filterFielsdOptions()" type="button" style="color: #B3B3B3;cursor:pointer; margin-top:1rem;background-color: transparent;border: none;outline: unset;font-size: .8rem;">FILTERS&nbsp;&nbsp;<i id="FilterHideIcon" class="fa fa-chevron-right" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                    <table id="FilterFieldsDiv" class="table invoice_details mt-1 arange" style="border: none;margin-left: 2%;margin-right: 2%;display:none">
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
                                            <td>
                                                <select class="invoice-inputs" name="item_sport" id="item_sport" required>
                                                    <option value="all">Select Sport</option>
                                                    @foreach ($sports as $sport)
                                                        <option value="{{$sport->id}}">{{$sport->sport_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>


                                            <td>
                                                <select class="invoice-inputs" name="item_gender" id="item_gender" required>
                                                    <option value="all">Select Gender</option>
                                                    <option value="Men">Men's</option>
                                                    <option value="Women">Women's</option>
                                                    <option value="Uni">Uni</option>
                                                </select>
                                            </td>


                                            <td>
                                                <select class="invoice-inputs" name="item_category" id="item_category" required>
                                                    <option value="all">Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value='{{$category->id}}'>{{$category->product_category_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td style="border-top-color: white;text-align:left">
                                                <button type="button" class="btn btn-info btn-sm m-1" style="font-size: 14px; background-color:white; color:grey; border-color:transparent;" id="all_conditions1" title="Filter Product">
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
                                                <select class="invoice-inputs" name="item_product" onchange="changeDisplayName()" id="item_product"  required>
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
                                        <input class="invoice-inputs" name="product_no" id="product_no" type='hidden' value='' readonly />
                                        <input type="hidden" name="product_name" id="product_name" value='' />
                                        <input type="hidden" name="pattern_code" id="pattern_code" value='' />
                                        <input type="hidden" name="product_price" id="product_price" value='' />
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
                                            <th class="form-label" style="width:33.33%">Item Status</th>
                                            <th class="form-label" style="width:33.33%">Factory</th>
                                            <th class="form-label" style="width:33.33%">Primary Fabric</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select class="invoice-inputs" name="status_id" id="status_id" required>
                                                    <option value="">Select Status</option>
                                                    @foreach($orderStatuses as $orderStatus)
                                                    <option value="{{$orderStatus->id}}">{{$orderStatus->status_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="invoice-inputs" name="factory_id" id="factory_id" required>
                                                    <option value="">Select Factory</option>
                                                    @foreach($factories as $factory)
                                                    <option value="{{$factory->id}}">{{$factory->factory_code}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="invoice-inputs" name="item_fabric" id="item_fabric" required>
                                                    <option value="">Select Primary Fabric</option>

                                                    {{-- @foreach($fabrics as $fabric)
                                                    <option value="{{$fabric->id}}">{{$fabric->fabric_name}}</option>
                                                    @endforeach --}}

                                                </select>
                                            </td>
                                        </tr>
                                        <tr style="height:10px"></tr>
                                        <tr>
                                            <th class="form-label" style="width:33.33%">Embellishment Type</th>
                                            <th class="form-label" style="width:33.33%">Shipping Method</th>
                                            <th class="form-label" style="width:33.33%">Ex Factory Date</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select class="invoice-inputs" name="item_embellishment" id="item_embellishment" required>
                                                    <option value="">Select Embellishment</option>

                                                    {{-- @foreach($embellishmentTypes as $embellishment)
                                                    <option value="{{$embellishment->id}}">{{$embellishment->embellishment_name}}</option>
                                                    @endforeach --}}

                                                </select>
                                            </td>
                                            <td class="uniqueStylePast">
                                                <select class="invoice-inputs" name="item_shipping_method" id="item_shipping_method" required>
                                                    <option value="">Select Shipping Method</option>
                                                    <option value="Bulk">Bulk</option>
                                                    <option value="Bulk Sorted">Bulk Sorted</option>
                                                    <option value="DTD">DTD</option>
                                                </select>
                                            </td>
                                            <td>
                                                <div class="input-container">
                                                    <input style="margin-top: -3px" class="invoice-inputs item-datepicker" name="item_delivery_date" id="item_delivery_date" type='text' value='' onchange="changeAddItemExFactoryDate()" required />
                                                    <i class="fas fa-calendar-alt calendar-icon"></i>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>

                                    <table class="table invoice_details mt-1 arange" style="border: none;margin-left: 2%;margin-right: 2%;">

                                        <tr>
                                            <th class="form-label" style="width:50%">Attributes</th>
                                            <th class="form-label" style="width:25%">Secondary Fabric</th>
                                            <th class="form-label" style="width:25%">Customer In-Hand Date</th>

                                        </tr>
                                        <tr>
                                            <td class="specialStyles">
                                                <select class="form-control form-input select2-people" id="item_attribute" name="item_attribute[]"  multiple="multiple">
                                                </select>
                                            </td>
                                            <td style="vertical-align: bottom !important;height: 40px;">
                                                <select class="invoice-inputs" name="item_secondary_fabric" id="item_secondary_fabric">
                                                    <option value="">Select Secondary Fabric</option>
                                                    @foreach($fabrics as $fabric)
                                                    <option value="{{$fabric->id}}">{{$fabric->fabric_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <div class="input-container">
                                                    <input style="margin-top: -3px" class="invoice-inputs item-datepicker" name="item_due_date" id="item_due_date" type='text' value='' onchange="changeAddItemCustomerInHandDate()" required />
                                                    <i class="fas fa-calendar-alt calendar-icon"></i>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>

                                    <table class="table invoice_details" style="display: none">
                                        <tr>
                                            <th>Organization :</th>
                                            <td>
                                                <select class="invoice-inputs" name="item_organization" id="item_organization" disabled>
                                                    <option value="">Select Organization</option>
                                                    @foreach($organizations as $organization)
                                                    <option value="{{$organization->id}}">{{$organization->organization_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <th>Support Agent :</th>
                                            <td>
                                                <select class="invoice-inputs" name="item_support_agent" id="item_support_agent" disabled>
                                                    <option value="">Select Support Agent</option>
                                                    @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
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
                                            <td><input class="invoice-inputs" name="item_order_no" id="item_order_no" type='text' value='{{$orderNo}}' readonly /></td>
                                        </tr>


                                        {{-- <tr id="add_item_tr_encore_packing_date" @if($order->order_type == 0 || ($order->order_type == 1 && $order->address_type == 2)) style="display: none" @endif>
                                            <th>Encore Packing Date :</th>
                                            <td><input class="invoice-inputs item-datepicker" name="item_encore_packing_date" id="item_encore_packing_date" type='text' value='' onchange="changeAddItemEncorePackingDate()" required /></td>
                                        </tr> --}}
                                    </table>
                                    <table class="table invoice_details" style="border: none;margin-left: 2%;margin-right: 2%;">
                                        <tr>
                                            <th class="form-label">Ex-Factory Address</th>
                                        </tr>
                                        <tr>
                                            <td style="display: flex;">
                                                <select class="invoice-inputs" name="item_ex_factory_id" id="item_ex_factory_id" required>
                                                    <option value="0">Same as Customer Address</option>
                                                    @foreach ($exFactories as $exFactory)
                                                        <option value="{{$exFactory->id}}">{{$exFactory->ex_factory_name}} | {{$exFactory->po_box}}, {{$exFactory->city}}, {{$exFactory->state}}, {{$exFactory->postal_code}}, {{$exFactory->country}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="#" class="btn input-group-text" style="border: 1px solid #B3B3B3;width: 27%;color:#B3B3B3 !important" data-toggle="modal" data-target="#add_ex_factory_modal">
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
                    <div class="col-lg-12 control-btns" style="background-color: white">
                        <button type="button" class="swal2-confirm" id="btn_add_item"><i class="fas fa-plus"></i> Add</button>
                        <button type="button" style="background-color: rgb(125, 125, 206) !important" class="swal2-confirm" id="btn_edit_item"><i class="fas fa-edit"></i> Edit</button>
                        <button type="button" class="swal2-cancel" id="btn_cancel_item"><i class="fas fa-eraser"></i> Clear</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@include('pages.settings.ex_factory.create_modal')
<script>
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
</script>

<script>
    function filterFielsdOptions() {
            var filterFieldsDiv = document.getElementById("FilterFieldsDiv");
            var filterHideIcon = document.getElementById("FilterHideIcon");

            if (filterFieldsDiv.style.display === "none") {
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
    document.addEventListener("DOMContentLoaded", function() {
        var style = document.createElement("style");
        style.textContent = ".select2-selection.select2-selection--multiple { border: 1px solid #e9ecef!important;height: 100px !important; }";
        document.head.appendChild(style);
    });

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
    var filterButton = document.getElementById('all_conditions1');

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
    $(document).ready(function (){

        // $('#add_item_modal').on('shown.bs.modal', function (e) {
        //     addItemStart();
        // });

        // $('#item_product').select2({
        //     dropdownParent: $("#product_selection")
        // });

    // Filter Products by Sport
        // $('#item_sport').on('change', function(){
        //     var sport = $(this).val();
        //     var gender = $('#item_gender').val();
        //     var category = $('#item_category').val();

        //     $.ajax({
        //         url:"{{ url('new_orders/product_filter') }}/"+sport+"/"+gender+"/"+category,
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
        //         url:"{{ url('new_orders/product_filter') }}/"+sport+"/"+gender+"/"+category,
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
        //         url:"{{ url('new_orders/product_filter') }}/"+sport+"/"+gender+"/"+category,
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

        // $("#add_item_modal").on('shown.bs.modal', function (e) {
        //     // USA Date Fomat
        //     var today = (new Date().getMonth()+1)+'/'+new Date().getDate()+'/'+new Date().getFullYear();
        //     $('.modal-datepicker').val(today);
        //     $('.modal-datepicker').datepicker();
        // });

        $('select').select2();
        $('.item-datepicker').datepicker({ minDate: 0});

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


                    $('#item_fabric').html('');
                    if(response.product_fabric !== null){

                        $('<option value="" selected>'+response.product_fabric+'</option>').appendTo($('#item_fabric'));

                    }else{
                        $('<option value="" selected>No fabric</option>').appendTo($('#item_fabric'));
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
            var itemDesigner = $('#item_designer').val();
            var itemShippingMethod = $('#item_shipping_method').val();
            var itemExFactory = $('#item_ex_factory_id').val();
            var itemNo = $('#item_id').val();
            var itemUniqueNo = $('#item_no').val();
            var itemOrderNo = $('#item_order_no').val();
            var itemName = $('#product_name').val();
            var displayName = $('#product_display_name').val();
            var patternCode = $('#pattern_code').val();
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

            if(itemProduct == ""){
                swal({title: "Invalid Input?", text: 'Please Select a Product', type: "error", confirmButtonColor: "#ce0029",})
                .then((value) => {$($('#item_product').attr('data-focus')).focus();});

            } else {
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

                $row = '<tr>'+
                    '<td><input type="text" class="invoice-inputs item-table-inputs item_name" name="item['+itemNo+'][item_name]" value="'+displayName+'" style="text-align: left;padding-left: 0px !important;" readonly /></td>'+
                    '<td><input type="text" class="invoice-inputs item-table-inputs pattern_code" value="'+patternCode+'" style="text-align: left;padding-left: 0px !important;" readonly /></td>'+
                    '<td style="width: 75px;vertical-align: middle;"><input type="text" class="invoice-inputs text-left status status-lable" style="color: '+textColor+' !important;background-color:'+bgColor+' !important;" name="item['+itemNo+'][status]" value="'+itemStatus+'" style="text-align: left;padding-left: 0px !important;" readonly /></td>'+
                    '<td><input type="text" class="invoice-inputs delivery_date" name="item['+itemNo+'][est_delivery_date]" value="'+itemDeliveryDate+'" style="text-align: left;padding-left: 0px !important;" readonly /></td>'+
                    '<td><input type="text" class="invoice-inputs tracking" name="item['+itemNo+'][tracking]" value="" style="text-align: left;padding-left: 0px !important;" readonly /></td>'+

                    '<td><input type="text" class="invoice-inputs item-table-inputs fabric" name="item['+itemNo+'][fabric]" value="'+itemFabric_text+'" style="width: 60px; text-align: left;padding-left: 0px !important;" readonly /></td>'+
                    '<td><input type="text" class="invoice-inputs item-table-inputs embellishment" name="item['+itemNo+'][embellishment]" value="'+itemEmbellishment_text+'" readonly style="text-align: left;padding-left: 0px !important;" /></td>'+
                    '<td><input type="text" class="invoice-inputs item-table-inputs attributes" name="item['+itemNo+'][attributes]" value="'+itemAttributes_text+'" style="text-align: left;padding-left: 0px !important;" readonly /></td>'+

                    '<td><input type="text" class="invoice-inputs item-qty text-right" name="item['+itemNo+'][qty]" value="0" style="padding-right: 0px !important;" readonly /></td>'+
                    // '<td><input type="text" class="invoice-inputs item-price text-right" name="item['+itemNo+'][unit_price]" value="'+itemPrice+'" style="text-align: right;padding-right: 0px !important;" readonly /></td>'+
                    // '<td><input type="text" class="invoice-inputs item-total text-right" name="item['+itemNo+'][total]" value="0" style="text-align: right;padding-right: 0px !important;" readonly /></td>'+
                    '<td  style="vertical-align: middle;width:62px">'+
                        // '<button type="button" value="'+itemNo+'" class="btn btn-success btn-sm btn-sm-custom btn-gray" title="Edit"><i class="fas fa-eye"></i></button>'+
                        '<button type="button" value="'+itemNo+'" style="border: none;background-color: transparent;outline: unset;cursor:pointer; color:#B3B3B3" class="edit-item" id="edit_item_'+itemNo+'" title="Edit"><i class="fas fa-edit"></i></button>'+
                        '<button type="button" value="'+itemNo+'" style="border: none;background-color: transparent;outline: unset;cursor:pointer;color:#D00000" class="remove-item" title="Delete"><i class="fas fa-trash-alt"></i></button>'+
                    '</td>'+
                    '<input type="hidden" name="item['+itemNo+'][organization_id]" class="organization_id" value="'+itemOrganization+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][support_agent_id]" class="support_agent_id" value="'+itemSupportAgent+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][designer_id]" class="designer_id" value="'+itemDesigner+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][shipping_method]" class="shipping_method" value="'+itemShippingMethod+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][ex_factory_id]" class="ex_factory_id" value="'+itemExFactory+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][item_no]" class="item_no" value="'+itemUniqueNo+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][order_id]" class="order_id" value="'+itemOrderNo+'" />'+
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
                    '</tr>';

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
            }
        });

        $('#btn_edit_item').on('click', function(){

            var itemOrganization = $('#item_organization').val();
            var itemSupportAgent = $('#item_support_agent').val();
            var itemDesigner = $('#item_designer').val();
            var itemShippingMethod = $('#item_shipping_method').val();
            var itemExFactory = $('#item_ex_factory_id').val();
            var itemNo = $('#item_id').val();
            var itemUniqueNo = $('#item_no').val();
            var itemOrderNo = $('#item_order_no').val();
            var itemName = $('#product_name').val();
            var displayName = $('#product_display_name').val();
            var patternCode = $('#pattern_code').val();
            var itemStatusId = $('#status_id').val();
            var itemStatus = $('#status_id option:selected').text();
            var itemPrice = $('#product_price').val();
            var itemDeliveryDate = $('#item_delivery_date').val();
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
                itemTr.find('.status_id').val(itemStatusId);
                itemTr.find('.status').val(itemStatus);
                itemTr.find('.item-price').val(itemPrice);
                itemTr.find('.delivery_date').val(itemDeliveryDate);
                itemTr.find('.in_hand_due_date').val(itemDueDate);
                itemTr.find('.product_id').val(itemProduct);
                itemTr.find('.fabric_id').val(itemFabric);
                itemTr.find('.secondary_fabric_id').val(itemSecondaryFabric);
                itemTr.find('.embellishment_id').val(itemEmbellishment);
                itemTr.find('.sport').val(itemSport);
                itemTr.find('.gender').val(itemGender);
                itemTr.find('.factory_id').val(itemFactory);
                itemTr.find('.fabric').val(itemFabric_text);
                itemTr.find('.embellishment').val(itemEmbellishment_text);

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
        // var encore_packing_date = $('#encore_packing_date').val();
        var ex_factory_date = $('#ex_factory_date').val();
        var orderStatusId = $('#order_status_id').val();

        $('#item_due_date').val(dueDate);
        // $('#item_encore_packing_date').val(encore_packing_date);
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
        var itemDesigner = itemTr.find('.designer_id').val();
        var itemShippingMethod = itemTr.find('.shipping_method').val();
        var itemExFactory = itemTr.find('.ex_factory_id').val();
        var itemUniqueNo = itemTr.find('.item_no').val();
        var itemOrderNo = itemTr.find('.order_id').val();
        var itemStatusId = itemTr.find('.status_id').val();
        var itemDeliveryDate = itemTr.find('.delivery_date').val();
        var DisplayName = itemTr.find('.item_name').val();
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
        $('#item_delivery_date').val(itemDeliveryDate);
        $('#item_encore_packing_date').val(itemEncorePackingDate);
        $('#item_due_date').val(itemDueDate);
        $('#item_product').val(itemProduct).trigger('change');
        // $('#item_fabric').val(itemFabric).trigger('change');
        $('#item_secondary_fabric').val(itemSecondaryFabric).trigger('change');
        // $('#item_embellishment').val(itemEmbellishment).trigger('change');
        $('#item_sport').val(itemSport).trigger('change');
        $('#item_gender').val(itemGender).trigger('change');
        $('#factory_id').val(itemFactory).trigger('change');

        doesEditButtonClick = 1;
        local_itemFabric = itemFabric;
        local_itemEmbellishment = itemEmbellishment;
        local_itemAttributes = JSON.parse("["+itemAttributes+"]");
    }

    function addItemReset(){
        $('#item_designer').val('').trigger('change');
        $('#item_shipping_method').val('').trigger('change');
        $('#item_ex_factory_id').val(0).trigger('change');
        $('#product_name').val('');
        $('#status_id').val('').trigger('change');
        $('#pattern_code').val('');
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
        $('#item_attribute').val('').trigger('change');
        $('#product_display_name').val('');
    }

    function changeAddItemExFactoryDate(){
        var ex_factory_date = $("#item_delivery_date").val();

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

    }

    function changeAddItemCustomerInHandDate(){
        var due_date = $("#item_due_date").val();

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
    }
</script>
