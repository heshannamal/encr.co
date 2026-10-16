@extends('layouts.app', ['activePage' => 'order', 'titlePage' => __('Invoice')])

@section('content')
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
        
         .imagesize {
            max-width: 70%;
        }
    </style>

    <div class="se-pre-con"></div>
    @if(isset($msg_type))
        <div class="alert alert-success fade in alert-dismissible show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true" style="font-size:20px">×</span>
            </button>
            {{ $message_text }}
        </div>
    @endif

    <div class="container-fluid mt-5" id="invoice_print" style="margin-top: 0px !important;margin-bottom: 70px;">
        @foreach ($orders as $order)
            <input type="hidden" id="invoice_id" value="{{$order->id}}" />

            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <img src="{{ asset('argon') }}/img/encore/logo1.png" height="150px">
                    </div>

                    <div class="col-lg-6">
                        <h3 class="page-title text-danger text-right">INVOICE</h3>
                    </div>

                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th>Organization :</th>
                                <td><h5>{{$order->organizationDetails['organization_name']}}</h5></td>
                            </tr>
                            <tr>
                                <th>Order # :</th>
                                <td><h5>{{$order->order_no}}</h5></td>
                            </tr>
                            <tr>
                                <th>Status :</th>
                                <td><h5>{{$order->statusDetails['status_name']}}</h5></td>
                            </tr>
                            <tr>
                                <th>Sales Rep :</th>
                                <td><h5>{{$order->userDetails['name']}}</h5></td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>

            <hr class="page-divider">

{{-- Address Details --}}
            <div class="col-lg-12 mb-1">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th>Shipping Address:</th>
                            </tr>
                            <tr><td><h5>{{$order->contactDetails['first_name']}} {{$order->contactDetails['last_name']}}</h5></td></tr>
                            <tr><td><h5>{{$order->street}}</h5></td></tr>
                            <tr><td><h5>{{$order->city}} {{$order->state}} {{$order->postal_code}}</h5></td></tr>
                            <tr><td><h5>{{$order->country}}</h5></td></tr>
                            <tr><td><h5>{{$order->phone_no}}</h5></td></tr>
                            <tr><td><h5>{{$order->email}}</h5></td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th>Billing Address:</th>
                            </tr>
                            <tr><td><h5>{{$order->contactDetails['first_name']}} {{$order->contactDetails['last_name']}}</h5></td></tr>
                            <tr><td><h5>{{$order->street}}</h5></td></tr>
                            <tr><td><h5>{{$order->city}} {{$order->state}} {{$order->postal_code}}</h5></td></tr>
                            <tr><td><h5>{{$order->country}}</h5></td></tr>
                            <tr><td><h5>{{$order->phone_no}}</h5></td></tr>
                            <tr><td><h5>{{$order->email}}</h5></td></tr>
                        </table>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-md-12">
                        <table class="table" id="invoice_items">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50%;">ITEM</th>
                                    <th class="text-center">STATUS</th>
                                    <th class="text-center">EST DELIVERY</th>
                                    <th class="text-center">QTY</th>
                                    <th class="text-right">UNIT PRICE($)</th>
                                    <th class="text-right">TOTAL($)</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($order->orderItems as $orderItem)
                                <tr>
                                    <td><h5>{{$orderItem->productDetails['product_name']}}</h5></td>
                                    <td><h5 class="text-center">{{$orderItem->statusDetails['status_name']}}</h5></td>
                                    <td><h5 class="text-center">{{$orderItem->est_delivery_date}}</h5></td>
                                    <td><h5 class="text-center">{{$orderItem->qty}}</h5></td>
                                    <td><h5 class="text-right">{{number_format($orderItem->unit_price, 2)}}</h5></td>
                                    <td><h5 class="text-right">{{number_format($orderItem->total, 2)}}</h5></td>
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
                        {{-- <div class="mt-4">
                            <h4>Payment can be submitted via PayPal, Venmo, Debit/Credit Card or Check. If submitting via PayPal or
                                Venmo, please include the invoice #, as well as your team and contact information.</h4>
                        </div>
                        <div class="mt-4">
                            <table>
                                <tr>
                                    <td><h4 class="text-small">PayPal :</h4></td>
                                    <td><h4 class="text-small"><span class="text-muted">info@encorelacrosse.com</span></h4></td>
                                </tr>
                                <tr>
                                    <td><h4 class="text-small">Venmo :</h4></td>
                                    <td><h4 class="text-small">: <span class="text-muted">@encore-lacrosse</span></h4></td>
                                </tr>
                                <tr>
                                    <td><h4 class="text-small">Credit Card/Check :</h4></td>
                                    <td><h4 class="text-small"><span class="text-muted">Please make payment through sales rep or accounting dept.</span></h4></td>
                                </tr>
                            </table>
                        </div> --}}
                    </div>

                    <div class="col-lg-5">
                        <table class="table" id="invoice_summery">
                            <tr>
                                <th class="text-left">SUBTOTAL ($) :</th>
                                <td><h5 class="text-right">{{number_format($order->sub_total, 2)}}</h5></td>
                            </tr>
                            <tr>
                                <th class="text-left">SALES TAX ($) {{$order->organizationDetails['sales_tax']}}% RATE :</th>
                                <td><h5 class="text-right">{{number_format($order->sales_tax, 2)}}</h5></td>
                            </tr>
                            <tr>
                                <th class="text-left">SHIPPING ($) :</th>
                                <td><h5 class="text-right">{{number_format($order->shipping, 2)}}</h5></td>
                            </tr>
                            <tr>
                                <th class="text-left">ARTWORK ($) :</th>
                                <td><h5 class="text-right">{{number_format($order->artwork, 2)}}</h5></td>
                            </tr>
                            <tr>
                                <th class="text-left">PROCESSING FEE ($) :</th>
                                <td><h5 class="text-right">{{number_format($order->processing_fee, 2)}}</h5></td>
                            </tr><br>
                            <tr>
                                <th class="total text-left">ORDER TOTAL ($) :</th>
                                <td><h5 class="text-right" style="font-weight: bold; font-size: large;">{{number_format($order->order_total, 2)}}</h5></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-body card-payment" style="padding-top: 0rem;border: grey 2px solid;padding-bottom: 0rem;">
                <div class="col-md-12">
                    <fieldset class="mt-3">
                        <legend style="font-size: 18px;">Payment Details</legend>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <th>#</th>
                                    <th>Method</th>
                                    <th>Name</th>
                                    <th>Transaction Id</th>
                                    <th>Date / Time</th>
                                    <th class="text-right">Amount</th>
                                </thead>
                                <tbody>
                                    @php $row = 0;$totalAmount = 0; @endphp
                                    @foreach ($orderPaymentsArray as $orderPaymentArray)
                                        <tr>
                                            <td style="padding-left: 0px !important;">{{ ++$row }}</td>
                                            <td style="padding-left: 0px !important;">{{$orderPaymentArray['Method']}}</td>
                                            <td style="padding-left: 0px !important;">{{$orderPaymentArray['NameonCard']}}</td>
                                            <td style="padding-left: 0px !important;">{{$orderPaymentArray['TransactionId']}}</td>
                                            <td>{{$orderPaymentArray['PaymentDate']->format('m-d-Y H:m:s')}}</td>
                                            <td class="text-right" style="padding-right: 0px !important;">$ {{number_format($orderPaymentArray['Amount'], 2)}}</td>
                                            {{-- @foreach ($cardPayments as $cardPayment)
                                                <tr>
                                                    <td>{{$cardPayment->transaction_id}}</td>
                                                    <td>{{$cardPayment->name_on_card}}</td>
                                                    <td>{{$cardPayment->created_at->format('m-d-Y H:m:s')}}</td>
                                                    <td class="text-right">$ {{number_format($cardPayment->amount, 2)}}</td>
                                                </tr>
                                            @endforeach --}}
                                        </tr>
                                        @php $totalAmount = $totalAmount + $orderPaymentArray['Amount']; @endphp
                                    @endforeach
                                </tbody>
                                <br>
                                <tfoot>
                                    <th style="font-size: 15px;" colspan="5">Total Amount</th>
                                    <th style="font-size: 15px;" class="text-right">$ {{number_format($totalAmount, 2)}}</th>
                                </tfoot>
                            </table>
                        </div>
                    </fieldset>
                </div>
            </div>
            <br>
            <a href="{{url('order_details/edit')}}/{{$order->id}}/?active_tab={{$orderItem->id}}" id="redirect_link" style="display: none;">redirect link</a>
        @endforeach
    </div>



    <script>



        $(document).ready(function(){

            var orderId = $('#invoice_id').val();
            localStorage.setItem("showInvoice", "Done");
            pdfDownload(orderId);
            //window.close();

        });

        function pdfDownload(orderId){
            var element = document.getElementById('invoice_print');
            var opt = {
                filename: 'Invoice_'+orderId+'.pdf',
                jsPDF: { format: 'a4', orientation: 'portrait' },
            };
            html2pdf().set(opt).from(element).save();

            setTimeout(function(){
                window.close();
            },5000);
        }


    </script>
@endsection
