@extends('layouts.app', ['activePage' => 'Team Stores', 'titlePage' => __('Team Stores')])

@section('content')

<style>
    .main_card {
        margin-top: 20px;
        border: unset;
        padding-bottom: 15px;
        border-radius: unset;
    }
    .share_btn {
        border: unset;
        background-color: transparent;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        color: #B3B3B3;
    }
    .btn_section {
        margin-right: 15px;
        padding: 15px;
        padding-bottom: unset;
    }
    .product_report {
        font-size: 18px;
    }
    .card_div {
        padding: 15px;
        padding-bottom: 5px;
    }
    .manage_group_p {
        font-size: 11px;
        color: #717070;
        font-weight: 500;
        margin-bottom: unset;
    }
    .share_btn_div {
        border-right: 1px solid #DEDEDE;
        margin: 5px;
    }
    .total_qty_text {
        font-size: 10px;
        color: #B3B3B3;
        font-weight: 500;
        margin-bottom: unset;
    }
    .total_qty_text2 {
        font-size: 11px;
        color: #B3B3B3;
        font-weight: 500;
        margin-bottom: unset;
    }
    .includes {
        font-size: 11px;
        color: #717070;
        font-weight: 700;
        margin-bottom: unset;
    }
    .qty_div {
        margin-right: 5px;
    }
    .qty_div2 {
        margin-right: 10px;
        margin-left: 5px;
        border-right: 1px solid #DEDEDE;
        padding-right: 10px;
    }
    .date_div {
        margin-right: 5px;
        margin-left: 5px;
        padding-left: 5px;
        padding-right: 5px;
        border-radius: 8px;
    }
    .manufacturer_div {
        margin-right: 5px;
        margin-left: 5px;
        padding-left: 5px;
        padding-right: 5px;
        border-radius: 8px;
    }
    .symbol1 {
        font-size: 16px;
        font-weight: 100;
        line-height: 1.3;
        color: #B3B3B3;
        margin-bottom: unset;
    }
    .table_header_text {
        color: white;
        height: 40px;
    }
    .table_body {
        color: #4E4C4C;
        height: 40px;
    }
    .bg-box.container-fluid.mb-5.fix-nav.header-layout{
        margin-bottom: .5rem !important;
    }

</style>

<div class="container-fluid mb-5" style="padding: 1rem !important;padding-top: 0rem !important;">
    <div class="se-pre-con"></div>

    <div class="card col-lg-12 main_card">
        <strong class="product_report mt-3">Order Item #{{$orders->first()->id}}</strong>
    </div>

    <form action="{{route('store.save_shipping_details')}}" method="POST">

        <input type="hidden" name="order_no" value="{{$orders->first()->order_no}}">

    <div class="card col-lg-12 main_card">
        <div class="">
            <div class="row">
                <div class="card_div">
                    <strong class="product_report">Order Item</strong>
                </div>
            </div>

            <hr style="margin-top:10px; margin-bottom: 10px;">

        </div>

        <div style="padding-left: 10px; padding-right: 10px;" class="mb-3">
            <table class="table align-items-center" id="product_report_table">
                <thead style="background-color: #717070;">
                    <th scope="col" class="table_header_text text-left">PRODUCT</th>
                    <th scope="col" class="table_header_text text-center">QTY</th>
                    <th scope="col" class="table_header_text text-center">STATUS</th>
                    <th scope="col" class="table_header_text text-right">UNIT PRICE ($)</th>
                    <th scope="col" class="table_header_text text-right">TOTAL ($)</th>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr style="border-bottom: 1px solid #DEDEDE;">
                            <td scope="col" class="table_body">
                                <div style="display: table; width: auto; height: 100%;">
                                    <div style="display: table-cell; vertical-align: middle; padding-right: 1rem;">
                                        <img
                                            src="{{$order->ProductDetails->images->first() ? asset($order->ProductDetails->images->first()->url) : asset('public/images/default.png')}}"
                                            alt="Product Image"
                                            style="width: 5rem; height: auto;">
                                    </div>
                                    <div style="display: table-cell; vertical-align: middle;">
                                        <div style="font-weight: bold; font-size: 1rem; margin-bottom: 0.2rem;">
                                            {{$order->ProductDetails->product_name}}
                                        </div>
                                        <div style="font-size: 0.8rem; color: gray;">
                                            Size : {{$order->SizeDetails->size_name}}
                                            <select  name="players[{{$order->id}}][size]" style="height: 1rem;border: none;">
                                                @foreach ($sizes->where('size_type', $order->SizeDetails->size_type) as $size)
                                                    <option value="{{$size->id}}" @if ($order->size == $size->id) selected @endif>{{$size->size_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if ($order->is_name_available == 1)
                                            <div style="font-size: 0.8rem; color: gray;">
                                                Name :  <input type="text" name="players[{{$order->id}}][name]" value="{{$order->player_name}}" style="height: 1rem;border: none;">
                                            </div>
                                        @endif
                                        @if ($order->is_number_available == 1)
                                            <div style="font-size: 0.8rem; color: gray;">
                                                Number : <input type="text" name="players[{{$order->id}}][number]" value="{{$order->player_number}}" style="height: 1rem;border: none;">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td scope="col" class="table_body text-center"><input type="number" class="form-control text-center item-quantity" name="players[{{$order->id}}][qty]" value="{{$order->qty}}" style="height: 1.5rem;"></td>
                            <td scope="col" class="table_body text-center">
                                <select name="players[{{$order->id}}][status]" style="border: none;background-color: #e1e1e1;padding: .3rem;border-radius: .5rem;">
                                    @foreach ($store_order_statuses as $store_order_status)
                                        <option value="{{$store_order_status->id}}" @if ($order->item_status == $store_order_status->id) selected @endif style="color: {{$store_order_status->color}};">{{$store_order_status->status_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td scope="col" class="table_body text-right"><input type="number" class="text-right form-control unit-price" value="{{$order->unit_price}}" disabled style="height: 1.5rem;"></td>
                            <td scope="col" class="table_body text-right"><input type="number" name="players[{{$order->id}}][total]" class="text-right form-control item-total" value="{{$order->total_amount}}" readonly style="height: 1.5rem;"></td>
                        </tr>
                    @endforeach
                    {{-- <tr style="border-bottom: 1px solid #DEDEDE;">
                        <td scope="col" colspan="4" class="table_body">Sub Total ($)</td>
                        <td scope="col" class="table_body text-right"><input type="number" name="order[sub_total]" id="order_sub_total" class="text-right form-control" value="{{$orders->first()->OrderDetails->sub_total}}" readonly style="height: 1.5rem;"></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #DEDEDE;">
                        <td scope="col" colspan="4" class="table_body">Shipping ($)</td>
                        <td scope="col" class="table_body text-right"><input type="number" name="order[shipping]" id="order_shipping" class="text-right form-control" value="{{$orders->first()->OrderDetails->shipping}}" readonly style="height: 1.5rem;"></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #DEDEDE;">
                        <td scope="col" colspan="4" class="table_body">Handling Fee ($)</td>
                        <td scope="col" class="table_body text-right"><input type="number" name="order[handling_fee]" id="order_handling_fee" class="text-right form-control" value="{{$orders->first()->OrderDetails->handling_fee}}" readonly style="height: 1.5rem;"></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #DEDEDE;">
                        <td scope="col" colspan="4" class="table_body">Sales Tax ($)</td>
                        <td scope="col" class="table_body text-right"><input type="number" name="order[sales_tax]" id="order_sales_tax" class="text-right form-control" value="{{$orders->first()->OrderDetails->sales_tax}}" readonly style="height: 1.5rem;"></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #DEDEDE;">
                        <td scope="col" colspan="4" class="table_body" style="font-size: 1rem;font-weight: 600;color:black">Grand Total ($)</td>
                        <td scope="col" class="table_body text-right"><input type="number" name="order[grand_total]" id="order_grand_total" class="text-right form-control" value="{{$orders->first()->OrderDetails->total}}" readonly style="font-size: 1rem;font-weight: 600;color:black;height: 2.5rem;"></td>
                    </tr> --}}
                </tbody>
            </table>
        </div>

        <hr style="margin: unset; margin-bottom: 10px;">


        @csrf
        <div style="padding-left: 5px; padding-right: 10px;">
            <div class="row">
                <div class="col-md-6">
                    <div class="card" style="border-radius: 0rem;">
                            <div class="col-md-12" style="padding: .5rem 1rem;background-color: #dddddd;">
                                Billing Information
                            </div>
                            <div class="col-md-12" style="padding: 1rem;">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="width: 20%;">Email Address</td>
                                        <td><input type="text" class="form-control" style="width: 100%; border: 1px solid rgba(239, 239, 239, 0.3);" value="{{$orders->first()->UserDetails->email}}" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td><input type="text" class="form-control" style="width: 100%; border: 1px solid rgba(239, 239, 239, 0.3);" value="{{$orders->first()->UserDetails->phone_number}}" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>First Name</td>
                                        <td><input type="text" class="form-control" style="width: 100%; border: 1px solid rgba(239, 239, 239, 0.3);" value="{{$orders->first()->UserDetails->first_name}}" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>Last Name</td>
                                        <td><input type="text" class="form-control" style="width: 100%; border: 1px solid rgba(239, 239, 239, 0.3);" value="{{$orders->first()->UserDetails->last_name}}" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>Street</td>
                                        <td><input type="text" class="form-control" style="width: 100%; border: 1px solid rgba(239, 239, 239, 0.3);" value="{{$orders->first()->UserDetails->street}}" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>City</td>
                                        <td><input type="text" class="form-control" style="width: 100%; border: 1px solid rgba(239, 239, 239, 0.3);" value="{{$orders->first()->UserDetails->city}}" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>State</td>
                                        <td><input type="text" class="form-control" style="width: 100%; border: 1px solid rgba(239, 239, 239, 0.3);" value="{{$orders->first()->UserDetails->state}}" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>Postal Code</td>
                                        <td><input type="text" class="form-control" style="width: 100%; border: 1px solid rgba(239, 239, 239, 0.3);" value="{{$orders->first()->UserDetails->postal_code}}" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>Country</td>
                                        <td><input type="text" class="form-control" style="width: 100%; border: 1px solid rgba(239, 239, 239, 0.3);" value="{{$orders->first()->UserDetails->country}}" disabled></td>
                                    </tr>
                                </table>
                            </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="border-radius: 0rem;">
                            <div class="col-md-12" style="padding: .5rem 1rem;background-color: #dddddd;">
                                Shipping Information
                            </div>
                            <div class="col-md-12" style="padding: 1rem;">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="width: 20%;">Email Address</td>
                                        <td><input type="text" name="email" style="width: 100%" class="form-control" value="{{$orders->first()->OrderDetails->email}}"></td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td><input type="text" name="phone" style="width: 100%" class="form-control" value="{{$orders->first()->OrderDetails->phone}}"></td>
                                    </tr>
                                    <tr>
                                        <td>First Name</td>
                                        <td><input type="text" name="first_name" style="width: 100%" class="form-control" value="{{$orders->first()->OrderDetails->first_name}}"></td>
                                    </tr>
                                    <tr>
                                        <td>Last Name</td>
                                        <td><input type="text" name="last_name" style="width: 100%" class="form-control" value="{{$orders->first()->OrderDetails->last_name}}"></td>
                                    </tr>
                                    <tr>
                                        <td>Street</td>
                                        <td><input type="text" name="street" style="width: 100%" class="form-control" value="{{$orders->first()->OrderDetails->street}}"></td>
                                    </tr>
                                    <tr>
                                        <td>City</td>
                                        <td><input type="text" name="city" style="width: 100%" class="form-control" value="{{$orders->first()->OrderDetails->city}}"></td>
                                    </tr>
                                    <tr>
                                        <td>State</td>
                                        <td><input type="text" name="state" style="width: 100%" class="form-control" value="{{$orders->first()->OrderDetails->state}}"></td>
                                    </tr>
                                    <tr>
                                        <td>Postal Code</td>
                                        <td><input type="text" name="postal_code" style="width: 100%" class="form-control" value="{{$orders->first()->OrderDetails->postal_code}}"></td>
                                    </tr>
                                    <tr>
                                        <td>Country</td>
                                        <td><input type="text" name="country" style="width: 100%" class="form-control" value="{{$orders->first()->OrderDetails->country}}"></td>
                                    </tr>
                                </table>
                            </div>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="card" style="border-radius: 0rem;">
                            <div class="col-md-12" style="padding: .5rem 1rem;background-color: #dddddd;">
                                Tracking Information
                            </div>
                            <div class="col-md-12" style="padding: 1rem;">
                                <table style="width: 100%">
                                    <tr>
                                        <td style="width: 8%">Traking Link</td>
                                        <td style="width: 40%"><input type="text" name="tracking_link" style="width: 100%" class="form-control" value="{{$orders->first()->OrderDetails->tracking_link}}"></td>
                                        <td style="width: 2%"></td>
                                        <td style="width: 8%">Tracking #</td>
                                        <td><input type="text" name="tracking_no" style="width: 100%" class="form-control" value="{{$orders->first()->OrderDetails->tracking_no}}"></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </div>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="card" style="border-radius: 0rem;">
                            <div class="col-md-12" style="padding: .5rem 1rem;background-color: #dddddd;">
                                Notes
                            </div>
                            <div class="col-md-12" style="padding: 1rem;">
                                <textarea name="note" id="player_note" class="form-control" style="width: 100%">
                                    {{$orders->first()->OrderDetails->notes}}
                                </textarea>
                            </div>
                    </div>
                </div>
                <div class="col-md-12 mt-3 text-right">
                    <button class="btn btn-primaty" type="submit" style="background-color: #39a0b1;color:white">SAVE</button>
                </div>
            </div>
        </div>
    </form>

    </div>

</div>

<script>
    $(document).on('input', '.item-quantity', function () {
        var $row = $(this).closest('tr');

        var unitPrice = parseFloat($row.find('.unit-price').val()) || 0;

        var quantity = parseFloat($(this).val()) || 0;

        var total = (quantity * unitPrice).toFixed(2);

        $row.find('.item-total').val(total);

        var orderSubTotal = 0;
        $('.item-total').each(function () {
            orderSubTotal += parseFloat($(this).val()) || 0;
        });

        $('#order_sub_total').val(orderSubTotal.toFixed(2));

        var shipping = parseFloat($('#order_shipping').val()) || 0;
        var order_handling_fee = parseFloat($('#order_handling_fee').val()) || 0;
        var order_sales_tax = parseFloat($('#order_sales_tax').val()) || 0;

        $('#order_grand_total').val((orderSubTotal + shipping + order_handling_fee + order_sales_tax).toFixed(2));
    });

</script>

@endsection
