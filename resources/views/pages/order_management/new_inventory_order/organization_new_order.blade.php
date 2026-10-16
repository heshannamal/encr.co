@extends('layouts.app', ['activePage' => 'new_orders', 'titlePage' => __('New Orders')])

@section('content')
 @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

    <div class="container-fluid mt-5 maxdivw">
        <form action="{{ route('new_orders.create') }}" method="post">
            @csrf
            <div class="card mb-3">
                <div class="card-head">
                    <div class="col-md-12 pt-3 pr-4">
                        <a href="{{route('orders')}}" class="btn btn-secondary-custom float-right"><i class="fas fa-arrow-left"></i> Back to Orders</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table invoice_details">
                                <tr>
                                    <th>Organization :</th>
                                    <td>
                                        <select class="invoice-inputs" name="organization_id" id="organization_id" required>
                                            @foreach($organizations as $organization)
                                            <option value="{{$organization->id}}">{{$organization->organization_name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Order # :</th>
                                    <td><input class="invoice-inputs" name="order_no" id="order_no" type='text' value='{{$orderNo}}' required /></td>
                                </tr>
                                <tr>
                                    <th>Order Status :</th>
                                    <td>
                                        <select class="invoice-inputs" name="order_status_id" id="order_status_id" required>
                                            <option value="">Select a Status</option>
                                            @foreach($orderStatuses as $orderStatus)
                                            <option value="{{$orderStatus->id}}">{{$orderStatus->status_name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>

                            </table>
                        </div>

                        <div class="col-md-6">
                            <table class="table invoice_details">
                                <tr>
                                    <th>Sales Rep :</th>
                                    <td>
                                        <select class="invoice-inputs" name="user_id" id="user_id" required>
                                            <option value="">Select a Sales Rep</option>
                                            @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Open Date :</th>
                                    <td>
                                        <input type="text" class="invoice-inputs" name="open_date" id="open_date" required />
                                    </td>
                                </tr>
                                <tr>
                                    <th>Due Date :</th>
                                    <td>
                                        <input type="text" class="invoice-inputs" name="due_date" id="due_date" required />
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

{{-- Address Details --}}
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table shipping_details">
                                <tr>
                                    <th>Shipping Address:</th>
                                </tr>
                                <tr><td><input class="invoice-inputs" id="shipping_address1"  type='text' value='' readonly/></td></tr>
                                <tr><td><input class="invoice-inputs" id="shipping_address2"  type='text' value='' readonly/></td></tr>
                                <tr><td><input class="invoice-inputs" id="shipping_address3"  type='text' value='' readonly/></td></tr>
                                <tr><td><input class="invoice-inputs" id="shipping_address4"  type='text' value='' readonly/></td></tr>
                                <tr><td><input class="invoice-inputs" id="shipping_address5"  type='text' value='' readonly/></td></tr>
                                <tr><td><input class="invoice-inputs" id="shipping_address6" type='text' value='' readonly/></td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table shipping_details">
                                <tr>
                                    <th>Billing Address:</th>
                                </tr>
                                <tr><td><input class="invoice-inputs" id="billing_address1" type='text' value='' readonly/></td></tr>
                                <tr><td><input class="invoice-inputs" id="billing_address2"  type='text' value='' readonly/></td></tr>
                                <tr><td><input class="invoice-inputs" id="billing_address3"  type='text' value='' readonly/></td></tr>
                                <tr><td><input class="invoice-inputs" id="billing_address4" type='text' value='' readonly/></td></tr>
                                <tr><td><input class="invoice-inputs" id="billing_address5" type='text' value='' readonly/></td></tr>
                                <tr><td><input class="invoice-inputs" id="billing_address6"  type='text' value='' readonly/></td></tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 mb-2 text-right">
                            <button type="button" class="btn btn-info btn-sm" id="add_item"><i class="fas fa-plus"></i> Add Item</button>
                        </div>

                        <div class="col-md-12">
                            <table class="table Product_details" id="order_item_table">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 40%;">ITEM</th>
                                        <th class="text-center">STATUS</th>
                                        <th class="text-center">EST DELIVERY</th>
                                        <th class="text-center">TRACKING</th>
                                        <th class="text-center">QTY</th>
                                        <th class="text-center">UNIT PRICE($)</th>
                                        <th class="text-center">TOTAL($)</th>
                                        <th class="text-center">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody id="product_table_body">
                                    <tr><input type="hidden" value="1" id="row_no"/></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <div class="row text-right">
                        <div class="col-lg-12">
                            <div class="col-lg-6 float-right">
                                <table id="invoice_summery_table" class="table invoice_summery">
                                    <tr>
                                        <th>SUBTOTAL ($) :</th>
                                        <td><input class="invoice-inputs text-right" name="sub_total" id="sub_total" type='text' value='0.00' readonly/></td>
                                    </tr>
                                    <tr>
                                        <th>SALES TAX ($) <span id="sales_tax_display"></span>% RATE :</th>
                                        <td>
                                            <input type="hidden" id="sales_tax_percentage" />
                                            <input class="invoice-inputs text-right" name="sales_tax" id="sales_tax" type='text' value='0' readonly />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>SHIPPING ($) :</th>
                                        <td><input class="invoice-inputs text-right" name="shipping" id="shipping" type='text' value='0'/></td>
                                    </tr>
                                    <tr>
                                        <th>ARTWORK ($) :</th>
                                        <td><input class="invoice-inputs text-right" name="artwork" id="artwork" type='text' value='0'/></td>
                                    </tr>
                                    <tr>
                                        <th>PROCESSING FEE ($) :</th>
                                        <td><input class="invoice-inputs text-right" name="processing_fee" id="processing_fee" type='text' value='0'/></td>
                                    </tr><br>
                                    <tr>
                                        <th class="total">ORDER TOTAL ($) :</th>
                                        <td><input class="invoice-inputs text-right" style="font-weight: bold; font-size: large;" name="order_total" id="order_total" type='text' value='0.00' readonly/></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 control-btns mt-3 no-print">
                <button type="submit" class="btn btn-success">Save</button>
                <button type="button" class="btn btn-secondary">Print</button>
            </div>
        </form>
    </div>

@include('pages.order_management.new_order.add_item_modal');
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        // USA Date Fomat
        var today = (new Date().getMonth()+1)+'/'+new Date().getDate()+'/'+new Date().getFullYear();
        $('#open_date').val(today);
        $('#due_date').val(today);

        $('#open_date').datepicker();
        $('#due_date').datepicker();
        getorganizationvalue();
        function getorganizationvalue(){
            var organizationId = $('#organization_id').val();

            $.ajax({
                url:"{{ url('new_orders/address') }}/"+organizationId,
                method:'GET',
                dataType:'json',
                success: function (data, textStatus, jqXHR){
                    console.log(data);

                    $shippingAddress = data[0].shipping_city+', '+data[0].shipping_state+', '+data[0].shipping_postal_code+', '+data[0].shipping_country;
                    $('#shipping_address1').val(data[0].first_name+' '+data[0].last_name);
                    $('#shipping_address2').val(data[0].shipping_address);
                    $('#shipping_address3').val(data[0].shipping_po_box);
                    $('#shipping_address4').val($shippingAddress);
                    $('#shipping_address5').val(data[0].phone_no);
                    $('#shipping_address6').val(data[0].email);

                    $billingAddress = data[0].billing_city+', '+data[0].billing_state+', '+data[0].billing_postal_code+', '+data[0].billing_country;
                    $('#billing_address1').val(data[0].first_name+' '+data[0].last_name);
                    $('#billing_address2').val(data[0].billing_address);
                    $('#billing_address3').val(data[0].billing_po_box);
                    $('#billing_address4').val($billingAddress);
                    $('#billing_address5').val(data[0].phone_no);
                    $('#billing_address6').val(data[0].email);
                    $('#user_id').val(data[0].user_id);
                    if(data[0].sales_tax_active == 1){
                        $('#sales_tax_display').html(data[0].sales_tax);
                        $('#sales_tax_percentage').val(data[0].sales_tax);
                    } else {
                        $('#sales_tax_display').html(0);
                        $('#sales_tax_percentage').val(0);
                    }
                }
            });

            $('#item_organization').val(organizationId);
        }

        $('#user_id').on('change', function(){
            var userId = $(this).val();
            $('#item_support_agent').val(userId);
        });

// Add Items
        $('#add_item').on('click', function (){
            var itemNo = $('#row_no').val();
            $('#item_id').val(itemNo);

            var orderNo = $('#order_no').val();
            $('#item_no').val(orderNo+'-'+itemNo);
            $('#add_item_modal').modal('show');
        });

// Remove Item
        $('#order_item_table').on('click', '.remove-item', function(){
            $(this).closest('tr').remove();
        });

// Calculate Order Amount
        $('#product_table_body').on('input', '.item-qty', function(){
            var itemQty = $(this).val();
            var itemPrice = $(this).closest('td').next().find('.item-price').val();
            var total = parseFloat(itemQty) * parseFloat(itemPrice);

            $(this).closest('td').next().next().find('.item-total').val(total);

            var sum = 0;
            $('.item-total').each(function(){
                sum += parseFloat(this.value);
            });
            $('#sub_total').val(sum);

            var subTotal = $('#sub_total').val();
            var salesTaxPre = $('#sales_tax_percentage').val();

            var saleTaxAmount = parseFloat(subTotal)/100*parseFloat(salesTaxPre);
            $('#sales_tax').val(saleTaxAmount);

            var salesTax = $('#sales_tax').val();
            var shipping = $('#shipping').val();
            var artwork = $('#artwork').val();
            var processingFee = $('#processing_fee').val();

            totalAmount = parseFloat(subTotal) + parseFloat(salesTax) + parseFloat(shipping) + parseFloat(artwork) + parseFloat(processingFee);
            var orderTotal = $('#order_total').val(totalAmount);
        });

        $('#product_table_body').on('input', '.item-price', function(){
            var itemQty = $(this).closest('td').prev().find('.item-qty').val();
            var itemPrice = $(this).val();
            var total = parseFloat(itemQty) * parseFloat(itemPrice);

            $(this).closest('td').next().find('.item-total').val(total);

            var sum = 0;
            $('.item-total').each(function(){
                sum += parseFloat(this.value);
            });
            $('#sub_total').val(sum);

            var subTotal = $('#sub_total').val();
            var salesTaxPre = $('#sales_tax_percentage').val();

            var saleTaxAmount = parseFloat(subTotal)/100*parseFloat(salesTaxPre);
            $('#sales_tax').val(saleTaxAmount);

            var salesTax = $('#sales_tax').val();
            var shipping = $('#shipping').val();
            var artwork = $('#artwork').val();
            var processingFee = $('#processing_fee').val();

            totalAmount = parseFloat(subTotal) + parseFloat(salesTax) + parseFloat(shipping) + parseFloat(artwork) + parseFloat(processingFee);
            var orderTotal = $('#order_total').val(totalAmount);
        });

        $('#invoice_summery_table').on('input', '#shipping', function(){
            var subTotal = $('#sub_total').val();
            var salesTax = $('#sales_tax').val();
            var shipping = $(this).val();
            var artwork = $('#artwork').val();
            var processingFee = $('#processing_fee').val();

            totalAmount = parseFloat(subTotal) + parseFloat(salesTax) + parseFloat(shipping) + parseFloat(artwork) + parseFloat(processingFee);
            var orderTotal = $('#order_total').val(totalAmount);
        });

        $('#invoice_summery_table').on('input', '#artwork', function(){
            var subTotal = $('#sub_total').val();
            var salesTax = $('#sales_tax').val();
            var shipping = $('#shipping').val();
            var artwork = $(this).val();
            var processingFee = $('#processing_fee').val();

            totalAmount = parseFloat(subTotal) + parseFloat(salesTax) + parseFloat(shipping) + parseFloat(artwork) + parseFloat(processingFee);
            var orderTotal = $('#order_total').val(totalAmount);
        });

        $('#invoice_summery_table').on('input', '#processing_fee', function(){
            var subTotal = $('#sub_total').val();
            var salesTax = $('#sales_tax').val();
            var shipping = $('#shipping').val();
            var artwork = $('#artwork').val();
            var processingFee = $(this).val();

            totalAmount = parseFloat(subTotal) + parseFloat(salesTax) + parseFloat(shipping) + parseFloat(artwork) + parseFloat(processingFee);
            var orderTotal = $('#order_total').val(totalAmount);
        });
    });
</script>
