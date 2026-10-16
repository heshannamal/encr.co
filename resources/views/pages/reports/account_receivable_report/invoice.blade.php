@extends('layouts.app', ['activePage' => 'order', 'titlePage' => __('Invoice')])

@section('content')
    <style>
        .imagesize {
            max-width: 70%;
        }
    </style>

    @section('back-btn')
        <a href="{{ route('reports.ar_report') }}" class="home-btn-color" title="Back to home">BACK</a>
    @endsection

    <div class="se-pre-con"></div>

    <div class="container-fluid mt-5" id="invoice_print">
            <input type="hidden" id="invoice_id" value="{{$bulk_invoice_id}}" />

            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <img src="{{ asset('argon') }}/img/encore/logo1.png" height="150px">
                    </div>

                    <div class="col-lg-6">
                        <h3 class="page-title text-danger text-right">INVOICE</h3>
                        <h5 class="text-right encore-address" style="margin-bottom: 0rem;">Encore Custom</h5>
                        <h5 class="text-right encore-address" style="margin-bottom: 0rem;">891 4th st.</h5>
                        <h5 class="text-right encore-address" style="margin-bottom: 0rem;">San Rafael, CA 94901</h5>
                    </div>

                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th>Bulk Invoice No :</th>
                                <td><h5>BULK-INV-{{ str_pad($bulk_invoice_id, 6, '0', STR_PAD_LEFT) }}</h5></td>
                            </tr>
                            <tr>
                                <th>Date # :</th>
                                <td>
                                    <h5>{{ date('m/d/Y') }}</h5>
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>

            <hr class="page-divider">

            <input type="hidden" id="organization_name" value="{{$organization->organization_name}}">

            <div class="col-lg-12 mb-1">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th>Organization Details:</th>
                            </tr>
                            <tr><td><h5>{{$organization->organization_name}}</h5></td></tr>
                            <tr><td><h5>{{$organization->shipping_street}}</h5></td></tr>
                            <tr><td><h5>{{$organization->shipping_city}} {{$organization->shipping_state}} {{$organization->shipping_postal_code}}</h5></td></tr>
                            <tr><td><h5>{{$organization->shipping_country}}</h5></td></tr>
                            <tr><td><h5>{{$organization->website}}</h5></td></tr>
                            <tr><td><h5>{{$organization->email}}</h5></td></tr>
                        </table>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-md-12">
                        <table class="table" id="invoice_items">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 10%;">ORDER NO</th>
                                    <th class="text-center">CONTACT PERSON</th>
                                    <th class="text-center">EST DELIVERY</th>
                                    <th class="text-right">ORDER TOTAL($)</th>
                                    <th class="text-right">PAID AMOUNT($)</th>
                                    <th class="text-right">AMOUNT TO PAY($)</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <td><h5 class="text-center">{{$order['order']->order_no}}</h5></td>
                                    <td><h5 class="text-left">{{$order['order']->contactDetails['first_name']}} {{$order['order']->contactDetails['last_name']}}</h5></td>
                                    <td><h5 class="text-center">{{$order['order']->est_delivery_date}}</h5></td>
                                    <td><h5 class="text-right">{{number_format($order['order']->order_total, 2)}}</h5></td>
                                    <td><h5 class="text-right">{{number_format($order['paid_amount'], 2)}}</h5></td>
                                    <td><h5 class="text-right">{{number_format($order['order']->order_total - $order['paid_amount'], 2)}}</h5></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-7">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="main-htag mt-4">Thank you for your business!</h1>
                                </div>
                                <div class="col-md-12 mt-4 text-center ">
                                    <img src="{{ asset('argon') }}/img/encore/logo_dark.png" class="navbar-brand-img imagesize" id="logo_large" alt="..." width="350px" >
                                </div>
                            </div>
                        </div>

                    @php
                        $orders_sub_total = 0;
                        $orders_paid_amount = 0;
                    @endphp

                    @foreach ($orders as $order)
                    @php
                        $orders_sub_total += isset($order['order']->order_total) ? $order['order']->order_total : 0;
                        $orders_paid_amount += isset($order['paid_amount']) ? $order['paid_amount'] : 0;
                    @endphp
                    @endforeach

                        <div class="col-lg-5">
                            <table class="table" id="invoice_summery">
                                <tr>
                                    <th class="text-left">SUBTOTAL ($) :</th>
                                    <td>
                                        <h5 class="text-right">{{ number_format($orders_sub_total, 2) }}</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-left">PAID AMOUNT($)</th>
                                    <td>
                                        <h5 class="text-right">{{ number_format($orders_paid_amount, 2) }}</h5>
                                    </td>
                                </tr>
                                <br>
                                <tr>
                                    <th class="total text-left">AMOUNT TO PAY ($) :</th>
                                    <td>
                                        <h5 class="text-right" style="font-weight: bold; font-size: large;">{{ number_format($orders_sub_total - $orders_paid_amount, 2) }}</h5>
                                    </td>
                                </tr>
                            </table>
                        </div>
                </div>
            </div>
    </div>

    <script>
        $(document).ready(function(){
            var orderId = $('#invoice_id').val();
            var organizationName = $('#organization_name').val();

            pdfDownload(orderId, organizationName);
        });

        function pdfDownload(orderId, organizationName){
            var element = document.getElementById('invoice_print');
            var opt = {
                filename: organizationName+'_Invoice_'+orderId+'.pdf',
                jsPDF: { format: 'a4', orientation: 'portrait' },
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>
@endsection
