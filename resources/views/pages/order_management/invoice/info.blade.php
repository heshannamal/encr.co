@extends('layouts.app', ['activePage' => 'invoice', 'titlePage' => __('View Invoice')])

@section('content')
    <div class="container-fluid mt-5">
        @foreach ($orders as $order)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table invoice_details">
                                <tr>
                                    <th>Organization :</th>
                                    <td><input class="invoice-inputs" type='text' value='{{$order->organizationDetails['organization_name']}}' /></td>
                                </tr>
                                <tr>
                                    <th>Order # :</th>
                                    <td><input class="invoice-inputs" type='text' value='{{$order->order_no}}' /></td>
                                </tr>
                                <tr>
                                    <th>Status :</th>
                                    <td><input class="invoice-inputs" type='text' value='{{$order->statusDetails['status_name']}}' /></td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <a href="{{route('invoice')}}" class="btn btn-secondary-custom float-right"><i class="fas fa-arrow-left"></i> Back to Invoices</a>
                        </div>
                    </div>
                </div>
            </div>

{{-- Address Details --}}
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <table class="table shipping_details">
                                <tr>
                                    <th>Support Agent :</th>
                                    <td><input class="invoice-inputs" type='text' value='{{$order->userDetails['name']}}' /></td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6 mb-3"></div>

                        <div class="col-md-6">
                            <table class="table shipping_details">
                                <tr>
                                    <th>Shipping Address:</th>
                                </tr>
                                <tr><td><input class="invoice-inputs" type='text' value='{{$order->contactDetails['first_name']}} {{$order->contactDetails['last_name']}}'/></td></tr>
                                <tr><td><input class="invoice-inputs" type='text' value='{{$order->organizationDetails['shipping_address']}}'/></td></tr>
                                <tr><td><input class="invoice-inputs" type='text' value='{{$order->organizationDetails['shipping_po_box']}}'/></td></tr>
                                <tr><td><input class="invoice-inputs" type='text' value='{{$order->organizationDetails['shipping_city']}}, {{$order->organizationDetails['shipping_state']}}, {{$order->organizationDetails['shipping_postal_code']}}, {{$order->organizationDetails['shipping_country']}}'/></td></tr>
                                <tr><td><input class="invoice-inputs" type='text' value='{{$order->contactDetails['phone_no']}}'/></td></tr>
                                <tr><td><input class="invoice-inputs" type='text' value='{{$order->contactDetails['email']}}'/></td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table shipping_details">
                                <tr>
                                    <th>Billing Address:</th>
                                </tr>
                                <tr><td><input class="invoice-inputs" type='text' value='{{$order->contactDetails['first_name']}} {{$order->contactDetails['last_name']}}'/></td></tr>
                                <tr><td><input class="invoice-inputs" type='text' value='{{$order->organizationDetails['billing_address']}}'/></td></tr>
                                <tr><td><input class="invoice-inputs" type='text' value='{{$order->organizationDetails['billing_po_box']}}'/></td></tr>
                                <tr><td><input class="invoice-inputs" type='text' value='{{$order->organizationDetails['billing_city']}}, {{$order->organizationDetails['billing_state']}}, {{$order->organizationDetails['billing_postal_code']}}, {{$order->organizationDetails['billing_country']}}'/></td></tr>
                                <tr><td><input class="invoice-inputs" type='text' value='{{$order->contactDetails['phone_no']}}'/></td></tr>
                                <tr><td><input class="invoice-inputs" type='text' value='{{$order->contactDetails['email']}}'/></td></tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <table class="table Product_details">
                                <thead>
                                    <tr>
                                        <th class="text-center">ITEM</th>
                                        <th class="text-center">QTY</th>
                                        <th class="text-center">UNIT PRICE($)</th>
                                        <th class="text-center">TOTAL($)</th>
                                        <th class="text-center">STATUS</th>
                                        <th class="text-center">EST DELIVERY</th>
                                        <th class="text-center">TRACKING</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($order->orderItems as $orderItem)
                                    <tr>
                                        <td><input type="text" class="invoice-inputs" value="{{$orderItem->productDetails['product_name']}}" /></td>
                                        <td><input type="text" class="invoice-inputs text-center" value="{{$orderItem->qty}}" /></td>
                                        <td><input type="text" class="invoice-inputs text-right" value="{{number_format($orderItem->unit_price, 2)}}" /></td>
                                        <td><input type="text" class="invoice-inputs text-right" value="{{number_format($orderItem->total, 2)}}" /></td>
                                        <td><input type="text" class="invoice-inputs text-center" value="{{$orderItem->statusDetails['status_name']}}" /></td>
                                        <td><input type="text" class="invoice-inputs" value="{{$orderItem->est_delivery_date}}" /></td>
                                        <td><input type="text" class="invoice-inputs" value="" /></td>
                                    </tr>
                                    @endforeach
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
                                        <th class="text-left">SUBTOTAL ($) :</th>
                                        <td><input class="invoice-inputs text-right" type='text' value='{{number_format($order->sub_total, 2)}}'/></td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">SALES TAX ($) {{$order->organizationDetails['sales_tax']}}% RATE :</th>
                                        <td><input class="invoice-inputs text-right" type='text' value='{{number_format($order->sales_tax, 2)}}'/></td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">SHIPPING ($) :</th>
                                        <td><input class="invoice-inputs text-right" type='text' value='{{number_format($order->shipping, 2)}}'/></td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">ARTWORK ($) :</th>
                                        <td><input class="invoice-inputs text-right" type='text' value='{{number_format($order->artwork, 2)}}'/></td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">PROCESSING FEE ($) :</th>
                                        <td><input class="invoice-inputs text-right" type='text' value='{{number_format($order->processing_fee, 2)}}'/></td>
                                    </tr><br>
                                    <tr>
                                        <th class="total text-left">ORDER TOTAL ($) :</th>
                                        <td><input class="invoice-inputs text-right" style="font-weight: bold; font-size: large;" type='text' value='{{number_format($order->order_total, 2)}}'/></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 control-btns mt-4 mb-4">
                <button type="button" class="btn btn-danger btn-custom delete" value="{{$order->id}}">Delete</button>
            </div>
        @endforeach
    </div>

    <script>
        $(document).ready(function(){
            $(".delete").on("click", function(){
                window.location.replace('../../invoice/delete/'+$(this).val());
            });
        });
    </script>
@endsection
