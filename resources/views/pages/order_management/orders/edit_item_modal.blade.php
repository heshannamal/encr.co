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
    .modal-body .modal-datepicker{
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
            height: unset !important;
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
            width: 100% !important;
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
        .modal-dialog {
            margin: 3rem auto !important;
        }
    }

</style>


<div class="modal fade" id="edit_item_modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content rmwidth001">
        <div class="modal-header">
            <h3 class="modal-title">Edit Item <span style="color: #B3B3B3;font-size: 1rem;font-weight: 400;" id="saved_item_text"></span></h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
            <form id="edit_saved_item_form">
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row div_flexdir">
                            <div class="col-md-12">
                                <div class="card-updated row" style="margin: 1%;">
                                        <input type="hidden" id="saved_item_itemNo" name="saved_item_itemNo">
                                        <div class="col-md-12 sub-header-style ml-2 mb-2" style="margin-top:0rem">
                                            Product
                                        </div>

                                        <table class="table invoice_details mt-1 arange" style="border: none;margin-left: 1%;margin-right: 2%;margin-bottom: 0rem;">
                                            <tr>
                                                <td class="select-container styleUnique" style="padding-left: .7rem !important;">
                                                    <select class="invoice-inputs" name="item_product" id="item_product_edit" disabled required>
                                                        <option selected>Select Product</option>
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
                                                    <input class="invoice-inputs" type="text" value="" id="selected_display_name" style="border: 1px solid #B3B3B3 !important;" disabled>
                                                </td>
                                            </tr>
                                        </table>

                                        <div class="col-md-8 sub-header-style mt-3" style="border: none;margin-left: 1%;margin-right: 2%;">
                                            Product Details
                                        </div>
                                        <table class="table invoice_details mt-1 arange" style="border: none;margin-left: 2%;margin-right: 2%;">

                                            <tr>
                                                <th class="form-label" style="width:33.33%">Product Price</th>
                                                <th class="form-label" style="width:33.33%">Item Status</th>
                                                <th class="form-label" style="width:33.33%">Factory</th>
                                            </tr>
                                            <tr>
                                                <td data-label="Product Price">
                                                    <div class="input-container">
                                                        <input style="margin-top: -3px;border: 1px solid #B3B3B3 !important;" class="invoice-inputs" name="product_price" id="product_price_edit" type='number' value='' />
                                                    </div>
                                                </td>
                                                <td data-label="Item Status">
                                                    <select class="invoice-inputs" name="status_id" id="status_id_edit" required>

                                                    </select>
                                                </td>
                                                <td data-label="Factory">
                                                    <select class="invoice-inputs" name="factory_id" id="factory_id_edit" required>
                                                        <option value="">Select Factory</option>

                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="table invoice_details mt-1 arange" style="border: none;margin-left: 2%;margin-right: 2%;">

                                            <tr>

                                                <th class="form-label" style="width:33.33%">Primary Fabric</th>
                                                <th class="form-label" style="width:33.33%">Embellishment Type</th>
                                                <th class="form-label" style="width:33.33%">Shipping Method</th>
                                            </tr>
                                            <tr>

                                                <td data-label="Primary Fabric">
                                                    <select class="invoice-inputs" name="item_fabric" id="item_fabric_edit" required disabled>
                                                    </select>
                                                </td>
                                                <td data-label="Embellishment Type">
                                                    <select class="invoice-inputs" name="item_embellishment" id="item_embellishment_edit">
                                                        <option value="">Select Embellishment</option>
                                                    </select>
                                                </td>
                                                <td data-label="Shipping Method" class="uniqueStylePast">
                                                    <select class="invoice-inputs" name="item_shipping_method" id="item_shipping_method_edit" required>

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr style="height:10px"></tr>
                                            <tr>

                                                <th class="form-label" style="width:33.33%">Ex Factory Date</th>
                                                <th class="form-label" style="width:33.33%">Secondary Fabric</th>
                                                <th class="form-label" style="width:33.33%">Customer In-Hand Date</th>
                                            </tr>
                                            <tr>

                                                <td  data-label="Ex Factory Date">
                                                    <div class="input-container">
                                                        <input style="margin-top: -3px" onchange="changeAddItemExFactoryDateEdit()" class="invoice-inputs modal-datepicker" name="item_delivery_date" id="item_delivery_date_edit" type='text' value=''/>
                                                        <i class="fas fa-calendar-alt calendar-icon"></i>
                                                    </div>
                                                </td>
                                                <td  data-label="Secondary Fabric" style="vertical-align: bottom !important;height: 40px;">
                                                    <select class="invoice-inputs" name="item_secondary_fabric" id="item_secondary_fabric_edit">

                                                    </select>
                                                </td>
                                                <td  data-label="Customer In-Hand Date margin_top_30_mobile">
                                                    <div class="input-container">
                                                        <input style="margin-top: -3px" onchange="changeAddItemCustomerInHandDateEdit()" class="invoice-inputs modal-datepicker" name="item_in_hand_date" id="item_in_hand_date_edit" type='text' value='' required/>
                                                        <i class="fas fa-calendar-alt calendar-icon"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>

                                        <table class="table invoice_details mt-1 arange clouserForHats" style="border: none;margin-left: 2%;margin-right: 2%;display:none">

                                            <tr>

                                                <th style="width: 33.33%">Clouser Type</th>
                                                <th style="width: 33.33%"></th>
                                                <th style="width: 33.33%"></th>

                                            </tr>
                                            <tr>

                                                <td>
                                                    <select class="invoice-inputs" name="clouser_type" id="clouser_type_edit" required>
                                                        <option value="">Select Clouser Type</option>
                                                        @foreach ($clouser_types as $clouser_type)
                                                            <option value="{{$clouser_type->id}}">{{$clouser_type->clouser_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </table>

                                        <table class="table invoice_details" style="display: none">
                                            <tr>
                                                <th>Organization :</th>
                                                <td>
                                                    <select class="invoice-inputs" name="item_organization" id="item_organization_edit" disabled>
                                                        <option value="">Select Organization</option>
                                                        @foreach($organizations as $organization)
                                                        <option value="{{$organization->id}}" @if ($organization->id == $order->organizationDetails['id']) selected @endif>{{$organization->organization_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <th>Support Agent :</th>
                                                <td>
                                                    <select class="invoice-inputs" name="item_support_agent" id="item_support_agent_edit" disabled>
                                                        <option value="">Select Support Agent</option>
                                                        @foreach($users as $user)
                                                        <option value="{{$user->id}}" @if ($user->id == $order->userDetails['id']) selected @endif>{{$user->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>


                                            <tr id="add_item_tr_encore_packing_date_edit" @if($order->order_type == 0 || ($order->order_type == 1 && $order->address_type == 2)) style="display: none" @endif>
                                                <th>Encore Packing Date :</th>
                                                <td><input class="invoice-inputs modal-datepicker" name="item_encore_packing_date" id="item_encore_packing_date_edit" type='text' value='' required /></td>
                                            </tr>
                                        </table>
                                        <table class="table invoice_details" style="border: none;margin-left: 2%;margin-right: 2%;">
                                            <tr>
                                                <th class="form-label">Ex-Factory Address</th>
                                            </tr>
                                            <tr>
                                                <td style="display: flex;">
                                                    <select class="invoice-inputs" name="item_ex_factory_id" id="item_ex_factory_id_edit" required>
                                                        <option value="0">Same as Customer Address</option>

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="btn input-group-text add_new_add_btn mobile_add_new_add_btn" style="border: 1px solid #B3B3B3;width: 27%;color:#B3B3B3 !important" data-toggle="modal" data-target="#add_ex_factory_modal">
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
                        <button type="submit" style="background-color: #47D6B6 !important" class="swal2-confirm mobile_footer_btns" onclick="saved_item_form_data()" id="btn_edit_item_edit"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script>

    $('.modal-datepicker').datepicker({ minDate: 0});


    document.getElementById('edit_saved_item_form').addEventListener('submit', function (event) {
        event.preventDefault();
        saved_item_form_data();
    });

    function saved_item_form_data() {
        var form = document.getElementById('edit_saved_item_form');

        var formData = new FormData(form);

        $.ajax({
            url: "{{ route('saved_order_item_update') }}",
            method: 'POST',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (data) {
                if (data.status === 201) {
                    $('#edit_item_modal').modal('hide');
                    location.reload();
                }
            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    }


    function update_product_details(sub_pro_no, order_item){

        $("#saved_item_text").text("  #" + order_item.item_no);

        $('#saved_item_itemNo').val(order_item.item_no);

        $('.clouserForHats').hide();
        if(order_item.clouser_type != null){
            $('#clouser_type_edit').val(order_item.clouser_type).trigger('change');
            $('.clouserForHats').show();
        }

        var orderStatuses = @json($orderStatuses);

        $('#status_id_edit').html('');
        if(orderStatuses.length > 0){

            for(var i = 0; i < orderStatuses.length; i++){
                var option = $('<option>', {
                    value: orderStatuses[i].id,
                    text: orderStatuses[i].status_name,
                    selected: orderStatuses[i].id == order_item.order_status_id
                });

                option.appendTo($('#status_id_edit'));
            }

        }

        var factories = @json($factories);

        $('#factory_id_edit').html('');
        if(factories.length > 0){

            for (var i = 0; i < factories.length; i++) {
                var option = $('<option>', {
                    value: factories[i].id,
                    text: factories[i].factory_code,
                    selected: factories[i].id == order_item.factory_id
                });

                option.appendTo($('#factory_id_edit'));
            }

        }

        var exFactories = @json($exFactories);

        $('#item_ex_factory_id_edit').html('');
        $('<option>', {
            value: 0,
            text: 'Same as Customer Address',
            selected: true
        }).appendTo($('#item_ex_factory_id_edit'));

        if (exFactories.length > 0) {
            for (var i = 0; i < exFactories.length; i++) {
                var option = $('<option>', {
                    value: exFactories[i].id,
                    text: exFactories[i].ex_factory_name + ' | ' + exFactories[i].po_box + ', ' + exFactories[i].city + ', ' + exFactories[i].state + ', ' + exFactories[i].postal_code + ', ' + exFactories[i].country,
                    selected: exFactories[i].id == order_item.ex_factory_id
                });

                option.appendTo($('#item_ex_factory_id_edit'));
            }
        }

        $('#item_shipping_method_edit').html('');
        var shippingMethods = ["Bulk", "Bulk Sorted", "DTD"];
        for (var i = 0; i < shippingMethods.length; i++) {
            var option = $('<option>', {
                value: shippingMethods[i],
                text: shippingMethods[i],
                selected: shippingMethods[i] === order_item.shipping_method
            });

            option.appendTo($('#item_shipping_method_edit'));
        }

        var fabrics = @json($fabrics);

        $('#item_secondary_fabric_edit').html('');
        if (fabrics.length > 0) {
            $('<option value="">Select Secondary fabric</option>').appendTo($('#item_secondary_fabric_edit'));
            for (var i = 0; i < fabrics.length; i++) {
                var option = $('<option>', {
                    value: fabrics[i].id,
                    text: fabrics[i].fabric_name,
                    selected: fabrics[i].id == order_item.secondary_fabric_id
                });

                option.appendTo($('#item_secondary_fabric_edit'));
            }
        }

        // console.log(order_item);
        $('#item_in_hand_date_edit').val(order_item.in_hand_due_date);
        $('#item_delivery_date_edit').val(order_item.ex_factory_date);
        $('#item_encore_packing_date').val(order_item.encore_packing_date);
        $('#product_price_edit').val(order_item.unit_price);
        $('#selected_display_name').val(order_item.display_name);

        var subProductId = sub_pro_no;

            $.ajax({
                url:"{{ route('filter_sub_products') }}",
                method:'GET',
                dataType:'json',
                data:{ subProductId : subProductId},
                success: function (response){

                    $('#item_product_edit').html('');
                    $('<option value="" selected>'+response.sub_product.product_name+'</option>').appendTo($('#item_product_edit'));


                    $('#item_fabric_edit').html('');
                    if(response.is_hat){
                        fabrics = fabrics.filter(function(fabric) {
                            return fabric.available_for_hats == 1;
                        });
                        $('#item_fabric_edit').prop('disabled', false);
                            if (fabrics.length > 0) {
                                for (var i = 0; i < fabrics.length; i++) {
                                    var option = $('<option>', {
                                        value: fabrics[i].id,
                                        text: fabrics[i].fabric_name,
                                        selected: fabrics[i].id == order_item.fabric_id
                                    });

                                    option.appendTo($('#item_fabric_edit'));
                                }
                            }

                    }else{
                        $('#item_fabric_edit').prop('disabled', true);
                        if(response.product_fabric !== null){

                            $('<option value="" selected>'+response.product_fabric+'</option>').appendTo($('#item_fabric_edit'));

                        }else{
                            $('<option value="" selected>No fabric</option>').appendTo($('#item_fabric_edit'));
                        }
                    }

                    var embellishmentTypeList = response.product_embellishment_type;

                    $('#item_embellishment_edit').html('');
                    if(embellishmentTypeList.length > 0){

                        $('<option value="">Select an Embellishment</option>').appendTo($('#item_embellishment_edit'));

                        for (var i = 0; i < embellishmentTypeList.length; i++) {
                            var option = $('<option>', {
                                value: embellishmentTypeList[i].id,
                                text: embellishmentTypeList[i].embellishment_name,
                                selected: embellishmentTypeList[i].id == order_item.embellishment_type_id
                            });

                            option.appendTo($('#item_embellishment_edit'));
                        }

                    } else {
                        $('<option value="">No Embellishment</option>').appendTo($('#item_embellishment_edit'));
                    }

                    var productAttribute = response.product_attributes;

                    $('#item_attribute_edit').html('');

                    if(productAttribute.length > 0){
                        for (var i = 0; i < productAttribute.length; i++) {
                            var option = $('<option>', {
                                value: productAttribute[i].id,
                                text: productAttribute[i].attribute_name,
                                selected: order_item.order_item_attributes.includes(productAttribute[i].id)
                            });

                            option.appendTo($('#item_attribute_edit'));
                        }

                    }

                    doesEditButtonClick = 0;
                }
            });
    }
    $("#your-input-id").datepicker({
    beforeShow: function(input, inst) {
        var inputTop = $(input).offset().top;
        var inputLeft = $(input).offset().left;

        inst.dpDiv.css({
            top: inputTop + $(input).outerHeight(),
            left: inputLeft
        });
    }
});
function changeAddItemExFactoryDateEdit(){
        var ex_factory_date = $("#item_delivery_date_edit").val();

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
                $('#item_in_hand_date_edit').val(data);
            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
            }
        });

    }

    function changeAddItemCustomerInHandDateEdit(){
        var due_date = $("#item_in_hand_date_edit").val();

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
                $('#item_delivery_date_edit').val(data);
            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    }

</script>
