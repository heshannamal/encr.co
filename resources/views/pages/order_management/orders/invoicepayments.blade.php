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
            <a href="{{url('order_details/edit')}}/{{$order->id}}/order?active_tab=order" id="redirect_link" style="display: none;">redirect link</a>
        @endforeach
    </div>



    <script>



        $(document).ready(function(){

            var orderId = $('#invoice_id').val();
            localStorage.setItem("showInvoice", "Done");
            pdfDownload(orderId);
             var pdfdata = @json($pdfdata ?? []);
            if(Object.keys(pdfdata).length > 0){
                pdfDownload2(orderId);
            }


        });

        function pdfDownload(orderId){
            var element = document.getElementById('invoice_print');
            var opt = {
                filename: 'Invoice_'+orderId+'.pdf',
                jsPDF: { format: 'a4', orientation: 'portrait' },
            };
            html2pdf().set(opt).from(element).save();

            setTimeout(function(){
                $(".se-pre-con").fadeOut('slow');
            },5000);
        }
        function pdfDownload2(orderId){
            var pdfdata = @json($pdfdata);
            var order = @json($orders[0]);
            var DiscountText = '';
            var discountAmount = 0;
            var totalWithoutDisc = parseFloat(order['sub_total']) + parseFloat(order['sales_tax']) + parseFloat(order['shipping']) +parseFloat(order['artwork']) ;
            if (order['discountType'] === 1) {
                discountAmount = (totalWithoutDisc / 100) * order['discount'];
            } else if (order['discountType'] === 2) {
                discountAmount = order['discount'];
            }
            if(order['discount_hidation'] == 1){
                DiscountText += `<div class="row" style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div class="label" style="font-weight: bold; color: #555;">DISCOUNT ($) :</div>
                                            <div class="value" style="color: #333;">`+parseFloat(parseFloat(discountAmount).toFixed(2)).toLocaleString('en-US')+`</div>
                                        </div>`;
            }
            var element = `<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9;">
                                <div class="container" style="width: 700px; margin: 20px auto; background: #fff; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                                    <div class="header" style="text-align: center; margin-bottom: 20px;">

                                        <h1 style="font-size: 22px; margin: 0; color: #333;">Payment Receipt</h1>
                                    </div>

                                    <div class="section" style="margin: 20px 0;">
                                        <div class="row" style="display: flex; justify-content: space-between; padding: 5px 0;border-bottom: 2px solid #ddd;">
                                            <div  style="font-size: 16px; font-weight: bold;  padding-bottom: 5px; margin-bottom: 15px;">Transaction Details</div>
                                            <div >`+pdfdata['Date']+`</div>
                                        </div>
                                        <div class="row" style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div class="label" style="font-weight: bold; color: #555;">Order ID</div>
                                            <div class="value" style="color: #333;">`+pdfdata['order_id']+`</div>
                                        </div>
                                        <div class="row" style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div class="label" style="font-weight: bold; color: #555;">Transaction ID</div>
                                            <div class="value" style="color: #333;">`+pdfdata['transaction_id']+`</div>
                                        </div>
                                        <div class="row" style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div class="label" style="font-weight: bold; color: #555;">Customer Name</div>
                                            <div class="value" style="color: #333;">`+pdfdata['Customer_name']+`</div>
                                        </div>
                                        <div class="row" style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div class="label" style="font-weight: bold; color: #555;">Payment Method</div>
                                            <div class="value" style="color: #333;">`+pdfdata['Payment_method']+`</div>
                                        </div>
                                        <div class="row" style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div class="label" style="font-weight: bold; color: #555;">Amount Paid ($)</div>
                                            <div class="value" style="color: #333;">`+parseFloat(parseFloat(pdfdata['amount_paid']).toFixed(2)).toLocaleString('en-US')+`</div>
                                        </div>
                                        <div class="row" style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div class="label" style="font-weight: bold; color: #555;">Card Processing Fee (3%) ($)</div>
                                            <div class="value" style="color: #333;">`+parseFloat(parseFloat((pdfdata['amount_paid']*3)/103).toFixed(2)).toLocaleString('en-US')+`</div>
                                        </div>
                                        <div class="row" style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div class="label" style="font-weight: bold; color: #555;">Date</div>
                                            <div class="value" style="color: #333;">`+pdfdata['Date']+`</div>
                                        </div>
                                        <div class="row" style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div class="label" style="font-weight: bold; color: #555;">Status</div>
                                            <div class="value" style="color: #333;">`+pdfdata['status']+`</div>
                                        </div>
                                    </div>

                                    <div class="section" style="margin: 20px 0;">
                                        <div class="row" style="display: flex; justify-content: space-between; padding: 5px 0;border-bottom: 2px solid #ddd;">
                                            <div  style="font-size: 16px; font-weight: bold;  padding-bottom: 5px; margin-bottom: 15px;">Order Summary</div>

                                        </div>
                                        <div class="row" style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div class="label" style="font-weight: bold; color: #555;">ORDER ITEM AMOUNT ($) :</div>
                                            <div class="value" style="color: #333;">{{number_format($order->sub_total, 2)}}</div>
                                        </div>
                                        <div class="row" style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div class="label" style="font-weight: bold; color: #555;">SALES TAX ($) {{$order->organizationDetails['sales_tax']}}% RATE :</div>
                                            <div class="value" style="color: #333;">{{number_format($order->sales_tax, 2)}}</div>
                                        </div>
                                        <div class="row" style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div class="label" style="font-weight: bold; color: #555;">SHIPPING ($) :</div>
                                            <div class="value" style="color: #333;">{{number_format($order->shipping, 2)}}</div>
                                        </div>
                                        <div class="row" style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div class="label" style="font-weight: bold; color: #555;">ARTWORK & OTHER FEES ($) :</div>
                                            <div class="value" style="color: #333;">{{number_format($order->artwork, 2)}}</div>
                                        </div>`
                                        + DiscountText
                                        +
                                        `

                                        <div class="row" style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div class="label" style="font-weight: bold; color: #555;">AMOUNT TO PAY ($) :</div>
                                            <div class="value" style="color: #333;">{{number_format($order->order_total, 2)}}</div>
                                        </div>
                                        <div class="row" style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div class="label" style="font-weight: bold; color: #2dce89;">PAID AMOUNT ($) :</div>
                                            <div class="value" style="color: #2dce89;">`+parseFloat(parseFloat(pdfdata['paymentReceived']).toFixed(2)).toLocaleString('en-US')+`</div>
                                        </div>
                                        <div class="row" style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div class="label" style="font-weight: bold; color: #555;">PAID PROCESSING FEE ($) :</div>
                                            <div class="value" style="color: #333;">`+parseFloat(parseFloat((pdfdata['paymentReceived']*3)/103).toFixed(2)).toLocaleString('en-US')+`</div>
                                        </div>
                                        <div class="row" style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div class="label" style="font-weight: bold; color: #fb6340;">BALANCE TO PAY ($) :</div>
                                            <div class="value" style="color: #fb6340;">`+parseFloat(parseFloat(pdfdata['balnceToBePaid']).toFixed(2)).toLocaleString('en-US')+`</div>
                                        </div>
                                        <div class="row" style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div class="label" style="font-weight: bold; color: #555;">ORDER STATUS :</div>
                                            <div class="value" style="color:`+pdfdata['color']+`;">`+pdfdata['orderstatus']+`</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h1 class="main-htag mt-4">Thank you for your business!</h1>
                                            </div>
                                            <div class="col-md-12 mt-4 text-center ">
                                                <img src="{{ asset('argon') }}/img/encore/logo_dark.png" class="navbar-brand-img imagesize" id="logo_large" alt="..." width="350px" >
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </body>`;
            var opt = {
                filename: 'Payment_Receipt_'+orderId+'.pdf',
                jsPDF: { format: 'a4', orientation: 'portrait' },
            };
            html2pdf().set(opt).from(element).save();

            setTimeout(function(){
                $(".se-pre-con").fadeOut('slow');
            },5000);
        }


    </script>
@endsection
