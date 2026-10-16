@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Payment')])

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
    .form-field {
        display: flex;
        margin-bottom: 1rem;
        flex-direction: row;
        flex-wrap: nowrap;
        align-items: center;
    }
    .form-lable {
        width: 13rem;
    }
    fieldset {
        min-width: 0px;
        margin: 0;
        padding: 1rem;
        border: 1px solid #e4e4e4;
    }
    legend {
        font-size: 0.8rem;
        font-weight: bold;
        line-height: inherit;
        display: block;
        width: 100%;
        max-width: 120px;
        margin-bottom: 0rem;
        padding: 0;
        white-space: normal;
        color: inherit;
        padding: .5rem;
    }
    footer.py-5 {
        display: none;
    }
    .disclaimer {
        width: 100%;
        margin-bottom: 0rem;
        font-size: 14px;
        font-weight: bold;
    }
    .payment-status {
        font-size: 14px;
        color: #ffffff;
        text-align: center;
        padding: 0.1rem 1rem;
        width: 100px;
        text-transform: uppercase;
        float: right;
    }
    .uploaded-checks {
        width: 130px !important;
        height: 100px;
        overflow: hidden;
    }
    .uploaded-checks img {
        width: 100%;
    }
</style>

<div class="container-fluid mb-5">
    <div class="se-pre-con"></div>

    @if(session('success_msg'))
        <div class="alert alert-success fade in alert-dismissible show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true" style="font-size:20px">×</span>
            </button>
            {{ session('success_msg') }}
        </div>
    @endif

    @if(session('error_msg'))
        <div class="alert alert-danger fade in alert-dismissible show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true" style="font-size:20px">×</span>
            </button>
            {{ session('error_msg') }}
        </div>
    @endif

    <div class="col-md-8 mt-4" style="margin-left: auto; margin-right: auto;">
        <div class="card">
            <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <h1 class="float-left header-title">Payment</h1>

                    <div class="float-right header-icons">
                        <span>
                            <a class="btn btn-round" href="{{ url('roster/'.$orderDetails->id.'?active_tab=order') }}" title="Back to the Order">
                                <i class="fas fa-arrow-left mt-1"></i>
                            </a>
                            <p>Back to the Order</p>
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body" style="padding-bottom: 0rem;">
                <div class="col-md-12">
                    <fieldset>
                        <legend>Payment Type</legend>

                        <div class="row">
                            <div class="col-md-8 pl-5">
                                <div class="row">
                                    <div class="form-check form-check-radio mr-5">
                                        <label class="form-check-label">
                                            <input class="form-check-input payment-type" type="radio" name="payment_type" id="card_payment" value="card" checked>
                                            Card
                                            <span class="circle">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>

                                    <div class="form-check form-check-radio mr-5">
                                        <label class="form-check-label">
                                            <input class="form-check-input payment-type" type="radio" name="payment_type" id="check_payment" value="cash">
                                            Check
                                            <span class="circle">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>

                                    <div class="form-check form-check-radio mr-5">
                                        <label class="form-check-label">
                                            <input class="form-check-input payment-type" type="radio" name="payment_type" id="venmo_payment" value="venmo">
                                            Venmo
                                            <span class="circle">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>

                                    <div class="form-check form-check-radio">
                                        <label class="form-check-label">
                                            <input class="form-check-input payment-type" type="radio" name="payment_type" id="paypal_payment" value="paypal">
                                            PayPal
                                            <span class="circle">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                @if ($paymentStatus == 0)
                                    <p class="payment-status" style="background-color: #adb5bd;">Pending</p>
                                @elseif ($paymentStatus == 1)
                                    <p class="payment-status" style="background-color: #fb6340;">Partial</p>
                                @else
                                    <p class="payment-status" style="background-color: #2dce89;">Paid</p>
                                @endif
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>

            <div class="card-body card-payment" style="padding-top: 0rem;">
                @if ($cardPayments->isEmpty())
                    <div class="col-md-12"></div>
                @else
                    <div class="col-md-12">
                        <fieldset class="mt-3">
                            <legend>Payment Details</legend>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <th>Transaction Id</th>
                                        <th>Name</th>
                                        <th>Date / Time</th>
                                        <th class="text-right">Amount</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($cardPayments as $cardPayment)
                                            <tr>
                                                <td>{{$cardPayment->transaction_id}}</td>
                                                <td>{{$cardPayment->name_on_card}}</td>
                                                <td>{{$cardPayment->created_at->format('m-d-Y H:m:s')}}</td>
                                                <td class="text-right">$ {{number_format($cardPayment->amount, 2)}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <th colspan="3">Total Amount</th>
                                        <th class="text-right">$ {{number_format($cardAmount, 2)}}</th>
                                    </tfoot>
                                </table>
                            </div>
                        </fieldset>
                    </div>
                @endif

                @if ($paymentStatus == 0 || $paymentStatus == 1)
                    <form id="payment-card-info" method="post" action="{{ route("customer_payment.online") }}">
                        @csrf

                        <input type="hidden" name="totalItemQty" value="{{ $totalItemQty }}">
                        <input type="hidden" name="sub_total" value="{{ $sub_total }}">
                        <input type="hidden" name="shipping" value="{{ $shipping }}">
                        <input type="hidden" name="salesTax" value="{{ $salesTax }}">
                        <input type="hidden" name="artwork" value="{{ $artwork }}">
                        <input type="hidden" name="processingFee" value="{{ $processingFee }}">
                        <input type="hidden" name="orderTotal" value="{{ $orderTotal }}">
                        <input type="hidden" name="balancePayment" value="{{ $balancePayment }}">

                        <div class="col-md-12">
                            <fieldset class="mt-3">
                                <legend>Payment Details</legend>
                                <div class="row">
                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable" style="font-size: 1rem">Order #: <span style="font-weight: 700">{{$orderDetails->order_no}}</span> </label>
                                        <input type="hidden" class="form-control" name="order_id" value="{{$orderDetails->id}}"/>
                                        <input type="hidden" class="form-control" name="order_no" value="{{$orderDetails->order_no}}" readonly/>
                                    </div>

                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable" style="font-size: 1rem">Invoice Amount ($): <span style="font-weight: 700; color:#2dce89">{{number_format(($orderDetails->order_total - $payment), 2)}}</span></label>
                                        <input type="hidden" class="form-control" value="{{number_format(($orderDetails->order_total - $payment), 2)}}" readonly>
                                        <input type="hidden" class="form-control" id="invoice_amount" value="{{($orderDetails->order_total - $payment)}}" />
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="mt-3">
                                <legend>Card Details</legend>

                                <div class="row">



                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Owner: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="owner" name="owner" value="{{ old('owner') }}" placeholder="Card Owner's Name" required />
                                    </div>

                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Card No: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="cardNumber" name="cardNumber" value="{{ old('cardNumber') }}" placeholder="Card Number" required />
                                    </div>

                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Expiration Date: <span class="text-danger">*</span></label>
                                        <div style="display: flex; width: 100%;">
                                            <select class="form-control" id="expiration-month" name="expiration-month">
                                                @foreach($months as $k=>$v)
                                                    <option value="{{ $k }}" {{ old('expiration-month') == $k ? 'selected' : '' }}>{{ $v }}</option>
                                                @endforeach
                                            </select>
                                            <select class="form-control" id="expiration-year" name="expiration-year">
                                                @for($i = date('Y'); $i <= (date('Y') + 15); $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">CVV: <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="cvv" name="cvv" value="{{ old('cvv') }}" placeholder="CVV" required />
                                    </div>

                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Payment Amount ($): <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" onchange="updatePaymentDetails(this)" value="{{number_format(($orderDetails->order_total - $payment), 2)}}">
                                    </div>
                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Card Processing<br>Fee (3%) ($):</label>
                                        <input type="text" style="border: none;" class="form-control" id="card_fee" name="card_fee" value="{{number_format((($orderDetails->order_total - $payment)/100*3), 2)}}" readonly>
                                        <input type="hidden" class="form-control" id="card_processing_fee" value="{{($orderDetails->order_total - $payment)/100*3}}" />
                                    </div>

                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Full Amount<br> to pay ($):</label>
                                        <input type="number" style="border: none;color: #2dce89;font-size: 1.2rem;font-weight: 600;" class="form-control card_amount_of_full" id="amount" name="amount" min="0" step='0.01' readonly/>
                                    </div>

                                    <div class="col-md-12 form-field mt-3">
                                        <div class="row ml-1">
                                            <p class="disclaimer">Disclaimer: 3% additional charge will be added to all card payments.</p><br>
                                            <img src="{{asset('argon')}}/img/icons/visa.png" style="width: 45px;" />
                                            <img src="{{asset('argon')}}/img/icons/mastercard.png" class="ml-1" style="width: 45px;" />
                                            <!--<img src="{{asset('argon')}}/img/icons/american_express.png" class="ml-1" style="width: 45px;" />-->
                                            <img src="{{asset('argon')}}/img/icons/discover.png" class="ml-1" style="width: 45px;" />
                                        </div>
                                    </div>
                                </div>
                            </fieldset>



                            <fieldset class="mt-3">
                                <legend>Billing Address</legend>

                                <div class="row">
                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">First Name: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{$orderDetails->contactDetails['first_name']}}" required />
                                    </div>

                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Last Name: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{$orderDetails->contactDetails['last_name']}}" required />
                                    </div>

                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Company: </label>
                                        <input type="text" class="form-control" id="company" name="company" value="{{$orderDetails->organizationDetails['organization_name']}}"/>
                                    </div>

                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Street: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="street" name="street" value="{{$orderDetails->street}}" required />
                                    </div>

                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">City: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="city" name="city" value="{{$orderDetails->city}}" required />
                                    </div>

                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">State: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="state" name="state" value="{{$orderDetails->state}}" required />
                                    </div>

                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Zip: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{$orderDetails->postal_code}}" required />
                                    </div>

                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Country: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="country" name="country" value="{{$orderDetails->country}}" required />
                                    </div>

                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Phone No: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{$orderDetails->phone_no}}" required />
                                    </div>

                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Email: <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{$orderDetails->email}}" required />
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-lg-12 control-btns">
                            <button type="submit" class="btn btn-success btn-custom" id="confirm-purchase">Confirm Payment</button>
                        </div>
                    </form>
                @else
                    <div class="col-md-12"></div>
                @endif
            </div>

            <div class="card-body check-payment" style="padding-top: 0rem;">
                @if ($checkPayments->isEmpty())
                    <div class="col-md-12"></div>
                @else
                    <div class="col-md-12">
                        <fieldset class="mt-3">
                            <legend>Payment Details</legend>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <th>Check Front</th>
                                        <th>Check Back</th>
                                        <th>Date / Time</th>
                                        <th class="text-right">Cust. Paid Amount</th>
                                        <th class="text-right">Amount</th>
                                        <th class="text-center">Approve</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($checkPayments as $checkPayment)
                                            <tr>
                                                <td class="uploaded-checks">
                                                    <a href="{{asset('uploads')}}/../{{$checkPayment->check_front}}" download="{{$orderDetails->order_no}}-check-front.{{ pathinfo(storage_path($checkPayment->check_front), PATHINFO_EXTENSION) }}">
                                                        @if(pathinfo(storage_path($checkPayment->check_front), PATHINFO_EXTENSION) == 'pdf')
                                                            <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                        @else
                                                            <img src="{{asset('uploads')}}/../{{$checkPayment->check_front}}" />
                                                        @endif
                                                    </a>
                                                </td>
                                                <td class="uploaded-checks">
                                                    <a href="{{asset('uploads')}}/../{{$checkPayment->check_back}}" download="{{$orderDetails->order_no}}-check-back.{{ pathinfo(storage_path($checkPayment->check_back), PATHINFO_EXTENSION) }}">
                                                        @if(pathinfo(storage_path($checkPayment->check_back), PATHINFO_EXTENSION) == 'pdf')
                                                            <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                        @else
                                                            <img src="{{asset('uploads')}}/../{{$checkPayment->check_back}}" />
                                                        @endif
                                                    </a>
                                                </td>
                                                <td style="vertical-align: middle;">{{$checkPayment->created_at->format('m-d-Y H:m:s')}}</td>
                                                <td style="vertical-align: middle;" class="text-right">$ {{number_format($checkPayment->customer_paid_amount, 2)}}</td>
                                                <td style="vertical-align: middle;" class="text-right">$ {{number_format($checkPayment->amount, 2)}}</td>
                                                <td style="vertical-align: middle;" class="text-center">
                                                    @if ($checkPayment->is_approved == 1)
                                                        <span class="badge badge-pill badge-success">Approved</span>
                                                    @else
                                                        <span class="badge badge-pill badge-warning">Pending</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <th colspan="3">Total Amount</th>
                                        <th class="text-right">$ {{number_format($checkAmount, 2)}}</th>
                                        <td></td>
                                    </tfoot>
                                </table>
                            </div>
                        </fieldset>
                    </div>
                @endif

                @if ($paymentStatus == 0 || $paymentStatus == 1)
                    <form id="payment-check-info" method="post" action="{{ route("customer_payment.check") }}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="totalItemQty" value="{{ $totalItemQty }}">
                        <input type="hidden" name="sub_total" value="{{ $sub_total }}">
                        <input type="hidden" name="shipping" value="{{ $shipping }}">
                        <input type="hidden" name="salesTax" value="{{ $salesTax }}">
                        <input type="hidden" name="artwork" value="{{ $artwork }}">
                        <input type="hidden" name="processingFee" value="{{ $processingFee }}">
                        <input type="hidden" name="orderTotal" value="{{ $orderTotal }}">
                        <input type="hidden" name="balancePayment" value="{{ $balancePayment }}">

                        <div class="col-md-12">
                            <fieldset class="mt-3 check-payment">
                                <legend>Check Payment</legend>

                                <div class="form-row">
                                    <div class="col-md-12">
                                        <p class="disclaimer">Please address check payments to: Encore Custom and upload the front and back of your check below to confirm payment.</p>
                                    </div>

                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Order #:</label>
                                        <input type="hidden" class="form-control" name="order_id" value="{{$orderDetails->id}}"/>
                                        <input type="text" class="form-control" name="order_no" value="{{$orderDetails->order_no}}" readonly/>
                                    </div>

                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Amount ($):</label>
                                        <input type="text" class="form-control" value="{{number_format(($orderDetails->order_total - $payment), 2)}}" readonly>
                                        <input type="hidden" class="form-control" id="check_amount" value="{{($orderDetails->order_total - $payment)}}" />
                                    </div>
                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Amount of Payment ($): <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="check_customer_paid_amount" id="check_customer_paid_amount" step="0.01" required/>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-field">
                                        <label class="form-lable">Upload Check (Front): <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" name="check_front" id="check_front" onchange="encodeFrontFileAsURL(this)" data-img-uri="" data-empty-message="Please Select a Payment Receipt" accept=".jpg,.jpeg,.png,.pdf" required />
                                    </div>

                                    <div class="col-md-6 form-field">
                                        <div id="check_front_preview">
                                            <img src="{{asset('argon')}}/img/icons/check.png" style="width: 50%; opacity: 0.5;" />
                                        </div>
                                    </div>

                                    <div class="col-md-6 form-field">
                                        <label class="form-lable">Upload Check (Back): <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" name="check_back" id="check_back" onchange="encodeBackFileAsURL(this)" data-img-uri="" data-empty-message="Please Select a Payment Receipt" accept=".jpg,.jpeg,.png,.pdf" required />
                                    </div>

                                    <div class="col-md-6 form-field">
                                        <div id="check_back_preview">
                                            <img src="{{asset('argon')}}/img/icons/check.png" style="width: 50%; opacity: 0.5;" />
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-lg-12 control-btns">
                            <button type="submit" class="btn btn-success btn-custom">Confirm Payment</button>
                        </div>
                    </form>
                @else
                    <div class="col-md-12"></div>
                @endif
            </div>

            <div class="card-body venmo-payment" style="padding-top: 0rem;">
                @if ($venmoPayments->isEmpty())
                    <div class="col-md-12"></div>
                @else
                    <div class="col-md-12">
                        <fieldset class="mt-3">
                            <legend>Payment Details</legend>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <th>Venmo Receipt</th>
                                        <th>Date / Time</th>
                                        <th class="text-right">Cust. Paid Amount</th>
                                        <th class="text-right">Amount</th>
                                        <th class="text-center">Approve</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($venmoPayments as $venmoPayment)
                                            <tr>
                                                <td class="uploaded-checks">
                                                    <a href="{{asset('uploads')}}/../{{$venmoPayment->venmo_receipt}}" download="{{$orderDetails->order_no}}-venmo-receipt.{{ pathinfo(storage_path($venmoPayment->venmo_receipt), PATHINFO_EXTENSION) }}">
                                                        @if(pathinfo(storage_path($venmoPayment->venmo_receipt), PATHINFO_EXTENSION) == 'pdf')
                                                            <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                        @else
                                                            <img src="{{asset('uploads')}}/../{{$venmoPayment->venmo_receipt}}" />
                                                        @endif
                                                    </a>
                                                </td>
                                                <td style="vertical-align: middle;">{{$venmoPayment->created_at->format('m-d-Y H:m:s')}}</td>
                                                <td style="vertical-align: middle;" class="text-right">$ {{number_format($venmoPayment->customer_paid_amount, 2)}}</td>
                                                <td style="vertical-align: middle;" class="text-right">$ {{number_format($venmoPayment->amount, 2)}}</td>
                                                <td style="vertical-align: middle;" class="text-center">
                                                    @if ($venmoPayment->is_approved == 1)
                                                        <span class="badge badge-pill badge-success">Approved</span>
                                                    @else
                                                        <span class="badge badge-pill badge-warning">Pending</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <th colspan="3">Total Amount</th>
                                        <th class="text-right">$ {{number_format($venmoAmount, 2)}}</th>
                                        <td></td>
                                    </tfoot>
                                </table>
                            </div>
                        </fieldset>
                    </div>
                @endif

                @if ($paymentStatus == 0 || $paymentStatus == 1)
                    <form id="payment-venmo-info" method="post" action="{{ route("customer_payment.venmo") }}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="totalItemQty" value="{{ $totalItemQty }}">
                        <input type="hidden" name="sub_total" value="{{ $sub_total }}">
                        <input type="hidden" name="shipping" value="{{ $shipping }}">
                        <input type="hidden" name="salesTax" value="{{ $salesTax }}">
                        <input type="hidden" name="artwork" value="{{ $artwork }}">
                        <input type="hidden" name="processingFee" value="{{ $processingFee }}">
                        <input type="hidden" name="orderTotal" value="{{ $orderTotal }}">
                        <input type="hidden" name="balancePayment" value="{{ $balancePayment }}">

                        <div class="col-md-12">
                            <fieldset class="mt-3 venmo-payment">
                                <legend>Venmo Payment</legend>

                                <div class="form-row">
                                    <div class="col-md-12">
                                        <p class="disclaimer">Please send Vemno Payments to: Encore-Custom and upload your receipt below to confirm payment.</p>
                                    </div>

                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Order #:</label>
                                        <input type="hidden" class="form-control" name="order_id" value="{{$orderDetails->id}}"/>
                                        <input type="text" class="form-control" name="order_no" value="{{$orderDetails->order_no}}" readonly/>
                                    </div>

                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Amount ($):</label>
                                        <input type="text" class="form-control" value="{{number_format(($orderDetails->order_total - $payment), 2)}}" readonly>
                                        <input type="hidden" class="form-control" id="venmo_amount" value="{{($orderDetails->order_total - $payment)}}" />
                                    </div>
                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Amount of Payment ($): <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="venmo_customer_paid_amount" id="venmo_customer_paid_amount" step="0.01" required />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-field">
                                        <label class="form-lable">Upload Venmo Receipt: <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" name="venmo_receipt" id="venmo_receipt" onchange="encodeVenmoFileAsURL(this)" data-img-uri="" data-empty-message="Please Select a Payment Receipt" accept=".jpg,.jpeg,.png,.pdf" required />
                                    </div>

                                    <div class="col-md-6 form-field">
                                        <div id="venmo_receipt_preview">
                                            <img src="{{asset('argon')}}/img/icons/check.png" style="width: 50%; opacity: 0.5;" />
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-lg-12 control-btns">
                            <button type="submit" class="btn btn-success btn-custom">Confirm Payment</button>
                        </div>
                    </form>
                @else
                    <div class="col-md-12"></div>
                @endif
            </div>

            <div class="card-body paypal-payment" style="padding-top: 0rem;">
                @if ($paypalPayments->isEmpty())
                    <div class="col-md-12"></div>
                @else
                    <div class="col-md-12">
                        <fieldset class="mt-3">
                            <legend>Payment Details</legend>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <th>paypal Receipt</th>
                                        <th>Date / Time</th>
                                        <th class="text-right">Amount</th>
                                        <th class="text-center">Approve</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($paypalPayments as $paypalPayment)
                                            <tr>
                                                <td class="uploaded-checks">
                                                    <a href="{{asset('uploads')}}/../{{$paypalPayment->paypal_receipt}}" download="{{$orderDetails->order_no}}-paypal-receipt.{{ pathinfo(storage_path($paypalPayment->paypal_receipt), PATHINFO_EXTENSION) }}">
                                                        @if(pathinfo(storage_path($paypalPayment->paypal_receipt), PATHINFO_EXTENSION) == 'pdf')
                                                            <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                        @else
                                                            <img src="{{asset('uploads')}}/../{{$paypalPayment->paypal_receipt}}" />
                                                        @endif
                                                    </a>
                                                </td>
                                                <td style="vertical-align: middle;">{{$paypalPayment->created_at->format('m-d-Y H:m:s')}}</td>
                                                <td style="vertical-align: middle;" class="text-right">$ {{number_format($paypalPayment->amount, 2)}}</td>
                                                <td style="vertical-align: middle;" class="text-center">
                                                    @if ($paypalPayment->is_approved == 1)
                                                        <span class="badge badge-pill badge-success">Approved</span>
                                                    @else
                                                        <span class="badge badge-pill badge-warning">Pending</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <th colspan="3">Total Amount</th>
                                        <th class="text-right">$ {{number_format($paypalAmount, 2)}}</th>
                                        <td></td>
                                    </tfoot>
                                </table>
                            </div>
                        </fieldset>
                    </div>
                @endif

                @if ($paymentStatus == 0 || $paymentStatus == 1)
                    <form id="payment-paypal-info" method="post" action="{{ route("customer_payment.paypal") }}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="totalItemQty" value="{{ $totalItemQty }}">
                        <input type="hidden" name="sub_total" value="{{ $sub_total }}">
                        <input type="hidden" name="shipping" value="{{ $shipping }}">
                        <input type="hidden" name="salesTax" value="{{ $salesTax }}">
                        <input type="hidden" name="artwork" value="{{ $artwork }}">
                        <input type="hidden" name="processingFee" value="{{ $processingFee }}">
                        <input type="hidden" name="orderTotal" value="{{ $orderTotal }}">
                        <input type="hidden" name="balancePayment" value="{{ $balancePayment }}">

                        <div class="col-md-12">
                            <fieldset class="mt-3 paypal-payment">
                                <legend>PayPal Payment</legend>

                                <div class="form-row">
                                    <div class="col-md-12">
                                        <p class="disclaimer">Please send PayPal Payments to: Encore-Custom and upload your receipt below to confirm payment.</p>
                                    </div>
                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Order #:</label>
                                        <input type="hidden" class="form-control" name="order_id" value="{{$orderDetails->id}}"/>
                                        <input type="text" class="form-control" name="order_no" value="{{$orderDetails->order_no}}" readonly/>
                                    </div>

                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Invoice Amount ($):</label>
                                        <input type="text" class="form-control" value="{{number_format(($orderDetails->order_total - $payment), 2)}}" readonly>
                                        <input type="hidden" class="form-control" id="paypal_invoice_amount" value="{{($orderDetails->order_total - $payment)}}" />
                                    </div>

                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Payment Amount ($):<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" onchange="updatePaymentDetailsPaypal(this)" value="{{number_format(($orderDetails->order_total - $payment), 2)}}">
                                    </div>

                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Card Processing<br>Fee (3%) ($):</label>
                                        <input type="text" style="border: none;" class="form-control" id="paypal_fee" name="paypal_fee" value="{{number_format((($orderDetails->order_total - $payment)/100*3), 2)}}" readonly>
                                        <input type="hidden" class="form-control" id="paypal_card_processing_fee" value="{{($orderDetails->order_total - $payment)/100*3}}" />
                                    </div>
                                    <div class="col-md-6 form-field mt-3">
                                        <label class="form-lable">Full Amount<br> to pay ($):</label>
                                        <input type="number" style="border: none;color: #2dce89;font-size: 1.2rem;font-weight: 600;" class="form-control" id="paypal_amount" name="amount" min="0" step='0.01' required readonly>
                                    </div>

                                    <div class="col-md-6"></div>


                                    <div class="col-md-6 form-field">
                                        <label class="form-lable">Upload PayPal Receipt: <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" name="paypal_receipt" id="paypal_receipt" onchange="encodePaypalFileAsURL(this)" data-img-uri="" data-empty-message="Please Select a Payment Receipt" accept=".jpg,.jpeg,.png,.pdf" required />
                                    </div>

                                    <div class="col-md-6 form-field">
                                        <div id="paypal_receipt_preview">
                                            <img src="{{asset('argon')}}/img/icons/check.png" style="width: 50%; opacity: 0.5;" />
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-lg-12 control-btns">
                            <button type="submit" class="btn btn-success btn-custom">Confirm Payment</button>
                        </div>
                    </form>
                @else
                    <div class="col-md-12"></div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function updatePaymentDetails(invoice_amount) {

        var invoiceAmount = parseFloat(invoice_amount.value);

        var cardProcessingFee = (invoiceAmount / 100) * 3;
        $('#card_fee').val(cardProcessingFee.toFixed(2));

        var fullAmount = cardProcessingFee + invoiceAmount;
        $('.card_amount_of_full').val(fullAmount.toFixed(2));

    }
    function updatePaymentDetailsPaypal(invoice_amount) {

        var invoiceAmount = parseFloat(invoice_amount.value);

        var cardProcessingFee = (invoiceAmount / 100) * 3;
        $('#paypal_fee').val(cardProcessingFee.toFixed(2));

        var fullAmount = cardProcessingFee + invoiceAmount;
        $('#paypal_amount').val(fullAmount.toFixed(2));

    }
</script>


<script>
    $(document).ready(function(){
        $('body').on('submit', function() {
            $(".se-pre-con").fadeIn();
        });

        $("#customer_portal_nav").show();
        $('.check-payment').hide();
        $('.venmo-payment').hide();
        $('.paypal-payment').hide();

        if(localStorage.getItem("showInvoice") == "Done")
        {
            localStorage.setItem("showInvoice", "NotDone");
            location.reload();
        }
        else{
            $(".se-pre-con").fadeOut('slow');
        }

        var invoice_amount = $('#invoice_amount').val();
        var card_processing_fee = $('#card_processing_fee').val();
        var total = parseFloat(invoice_amount) + parseFloat(card_processing_fee);
        console.log(total);
        $('#amount').val(total.toFixed(2));

        var invoice_amount = $('#paypal_invoice_amount').val();
        var card_processing_fee = $('#paypal_card_processing_fee').val();
        var total = parseFloat(invoice_amount) + parseFloat(card_processing_fee);
        $('#paypal_amount').val(total.toFixed(2));
    });

    function encodeFrontFileAsURL(element) {
        var file = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            element.setAttribute('data-img-uri', reader.result);

            var image = "<img src='" + reader.result + "' style='max-width: 200px; max-height: 200px' alt='image_preview'/>";

            $("#check_front_preview").html(image);
        }

        reader.readAsDataURL(file);
    }

    function encodeBackFileAsURL(element) {
        var file = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            element.setAttribute('data-img-uri', reader.result);

            var image = "<img src='" + reader.result + "' style='max-width: 200px; max-height: 200px' alt='image_preview'/>";

            $("#check_back_preview").html(image);
        }

        reader.readAsDataURL(file);
    }

    function encodeVenmoFileAsURL(element) {
        var file = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            element.setAttribute('data-img-uri', reader.result);

            var image = "<img src='" + reader.result + "' style='max-width: 200px; max-height: 200px' alt='image_preview'/>";

            $("#venmo_receipt_preview").html(image);
        }

        reader.readAsDataURL(file);
    }

    function encodePaypalFileAsURL(element) {
        var file = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            element.setAttribute('data-img-uri', reader.result);

            var image = "<img src='" + reader.result + "' style='max-width: 200px; max-height: 200px' alt='image_preview'/>";

            $("#paypal_receipt_preview").html(image);
        }

        reader.readAsDataURL(file);
    }

    $('.payment-type').on('change', function(){
        var paymentType = $(this).val();
        if (paymentType == 'card') {
            $('.check-payment').hide();
            $('.venmo-payment').hide();
            $('.paypal-payment').hide();
            $('.card-payment').show(700);

        } else if (paymentType == 'cash') {
            $('.card-payment').hide();
            $('.venmo-payment').hide();
            $('.paypal-payment').hide();
            $('.check-payment').show(700);
        } else if (paymentType == 'venmo') {
            $('.card-payment').hide();
            $('.check-payment').hide();
            $('.paypal-payment').hide();
            $('.venmo-payment').show(700);
        } else if (paymentType == 'paypal') {
            $('.card-payment').hide();
            $('.check-payment').hide();
            $('.venmo-payment').hide();
            $('.paypal-payment').show(700);
        }
    });
</script>
@endsection
