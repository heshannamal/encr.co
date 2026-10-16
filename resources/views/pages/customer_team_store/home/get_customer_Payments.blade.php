@extends('layouts.customer_team_store.app')

@section('content')

<style>
    .top-navbar {
        background-color: white;
        z-index: 99;
        position: fixed !important;
        top: 0;
        left: 0;
        width: 100%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .cart_topic_text {
        font-size: 33px;
    }
    .cart_items {
        padding-top: 15px;
        padding-bottom: 15px !important;
        border-bottom: 1px solid rgb(231, 231, 231);
    }
    .cart_summary {
        max-width: 35%;
        width: 35%;
    }
    .text_input {
        font-size: 12px;
        border: 1px solid #DEDEDE !important;
        border-radius: 0rem !important;
        color: #717070 !important;
    }
    .text_input_div {
        margin-top: 5px;
        margin-bottom: 5px;
    }

    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
        display: none;
    }
    .form-field {
        display: flex;
        margin-bottom: 1rem;
        flex-direction: row;
        flex-wrap: nowrap;
        align-items: center;
    }
    .form-lable {
        width: 12rem;
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
        max-width: 100%;
        max-height: 100%;
    }
    .back-btn-div-position {
        padding: 0.5rem;
    }
    .btn-right {
        position: relative;
        right: 15px;
    }
    .back-btn-div {
        padding: 0.5rem;
        background-color: #787878;
        border-radius: 0.125rem;
        font-size: xx-small;
    }
    .content-div {
        position: relative;
        top: -20px;
    }
    .forPaymentStyles .nav-link2{
        background-color: white !important;
        color: grey !important;
        font-weight: 600 !important;
        border: none !important;
        border-bottom: 2px solid #b3b3b3 !important;
    }
    .forPaymentStyles .nav-link2.active, .forPaymentStyles .nav-link2:hover{
        background-color: white !important;
        color: black !important;
        font-weight: 600 !important;
        border: none !important;
        border-bottom: 2px solid black !important;
    }
    .border-style{
    border: 1px solid #DEDEDE !important;
    border-radius: 0rem !important;
    color: #717070 !important;
    }
    .forPaymentStyles .form-control{
        border: 1px solid #DEDEDE;
        border-radius: 0rem !important;
        color: #717070 !important;
        padding-left: 7px !important;
        font-size: 0.8rem !important;
        height: calc(1.5rem + 1px) !important;
        margin-bottom: 0rem !important;
    }
    .forPaymentStyles label {
        margin-bottom: 0rem ;
        color: black;
    }
    .header-style{
        color: black;
        font-size: 1.1rem;
        font-weight: 600;
    }
    .forPaymentStyles .form-label{
        margin-top: 0.5rem;
        color: black;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .sub-header-style{
        color: black;
        font-size: .8rem;
        margin-top: 1rem;
        font-weight: 600;
    }
    .disabled-style{
        background-color: #F8F8F8;
        border: none !important;
        line-height: 14px;
    }
    .forPaymentStyles .custom-file-input-label:hover{
        border: 2px dashed #b3b3b3 !important;
    }
    .paymentSummaryTable thead tr{
        background-color: grey;
        color: white;
        height: 40px;
        font-size: .7rem;
    }
    .paymentSummaryTable tr{
        background-color: white;
        color: grey;
        min-height: 40px;
        font-size: .7rem;
        border-bottom: 1px solid #b3b3b3;
    }
    .paymentSummaryTable{
        width: 100%;
    }
    .paymentSummaryTable th, .paymentSummaryTable td {
        padding: 10px;
    }
    .btn-success:disabled {
        color: #fff;
        border-color: #787878;
        background-color: #787878;
    }
    .save_continue_btn {
        padding-top: unset !important;
        padding-bottom: unset !important;
        padding-left: 5px !important;
        padding-right: 5px !important;
    }
    .back_edit_btn {
        padding-top: unset !important;
        padding-bottom: unset !important;
        padding-left: 5px !important;
        padding-right: 5px !important;
    }
    .details_card {
        padding: 10px;
        background-color: rgb(236, 236, 236);
        border-radius: 5px;
        margin-bottom: 10px;
    }
    .completed-section {
        background-color: transparent !important;
        border: unset !important;
    }
</style>
<div class="navbar top-navbar  col-12 col-lg-12 {{ $teamStore->theme == 1 ? 'top_nav_dark' : '' }}" style=" background-color:white; z-index:99;">

    @include('pages.customer_team_store.layouts.header')

</div>

<div class="col-lg-12 mt-4 forPaymentStyles" style="padding-top: 80px;">
    <div class="se-pre-con"></div>
    <div class="row" style="margin: unset;">
        <div class="col-md-9">
            <div class="card" style="border-radius: 0rem; border:none">
                <div class="col-md-12 header-style mt-3 ml-3">
                    Payment Method
                </div>

                <div class="tab-container" style="width:100%;padding: 1rem; font-size: 0.8rem;">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link nav-link2 active" id="tab-card" data-toggle="tab" href="#card-tab">CARD</a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3">
                        <div class="tab-pane tab-pane2 active" id="card-tab" style="min-height: 30rem;">

                                <form id="payment-card-info" method="post" action="{{ makeStoreDomainRoute('store/OrderExtraPaymentOnline') }}">
                                    @csrf
                                    <input type="hidden" name="total_item_qty" value="{{$order->OrderItems->sum('qty')}}">
                                    <input type="hidden" name="store_order_id" value="{{$order->id}}">
                                    <input type="hidden" name="balance_to_pay" value="{{number_format(($balanceToPay), 2)}}">
                                    <input type="hidden" name="fee_to_pay" value="{{number_format(($balanceToPay * 3 /100), 2)}}">
                                    <input type="hidden" name="total_balance_to_pay" value="{{number_format(($balanceToPay * 103 / 100), 2)}}">

                                    <div class="row" style="padding-left: 15px;">
                                        <div class="col-md-12 header-style mt-2">
                                            Shipping Details
                                        </div>
                                        <div class="col-md-12" id="section_0">
                                            <div class="row">
                                                <input type="hidden" name="store_id" value="{{$store->id}}">
                                                <div class="col-md-6">
                                                    <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{$order->CustomerDetails->first_name ?? ''}}" required />
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{$order->CustomerDetails->last_name ?? ''}}" required />
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="street" class="form-label">Street Address <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="street" name="street" value="{{$order->CustomerDetails->street ?? ''}}" required />
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="city" name="city" value="{{$order->CustomerDetails->city ?? ''}}" required />
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="state" name="state" value="{{$order->CustomerDetails->state ?? ''}}" required />
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="country" name="country" value="{{$order->CustomerDetails->country ?? ''}}" required />
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="zip_code" class="form-label">Postal Code <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{$order->CustomerDetails->postal_code ?? ''}}" required />
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="phone" class="form-label">Phone No <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="phone" name="phone" value="{{$order->CustomerDetails->phone_number ?? ''}}" required />
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" id="email" name="email" value="{{$order->CustomerDetails->email ?? ''}}" required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 row details_card mt-4" style=" margin: unset;">

                                            <div class="col-md-12 header-style mt-5" style="margin-top: .5rem!important; padding-left: unset;">
                                                Card Details
                                            </div>

                                            <div class="col-md-12"  id="card_details_section">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="owner" class="form-label">Name on Card <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="owner" name="owner" value="{{ old('owner') }}" placeholder="Card Owner's Name" required />
                                                    </div>
                                                    <div class="col-md-6" style="padding-right: 0">
                                                        <label for="cardNumber" class="form-label">Card Number <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="cardNumber" name="cardNumber" value="{{ old('cardNumber') }}" placeholder="Card Number" required />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="expiration-month" class="form-label">Expiration Date <span class="text-danger">*</span></label>
                                                        <div style="display: flex; width: 100%;">
                                                            <select class="form-control mr-2" id="expiration-month" name="expiration-month">
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
                                                    <div class="col-md-3" style="padding-left: 0">
                                                        <label for="cvv" class="form-label">CVV: <span class="text-danger">*</span></label>
                                                        <input type="password" class="form-control" id="cvv" name="cvv" value="{{ old('cvv') }}" placeholder="CVV" required />
                                                    </div>
                                                    <div class="col-md-6 form-field mt-3" style="display: none">
                                                        <label class="form-lable">Order #:</label>
                                                        <input type="hidden" class="form-control" name="order_id" value=""/>
                                                    </div>

                                                    <div class="col-md-6 mt-2">
                                                        <label class="form-lable">Payment Amount ($): <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" readonly value="{{number_format($balanceToPay, 2)}}"/>
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                        <label class="form-lable">Card Processing Fee (3%) ($):</label>
                                                        <input type="text" class="form-control" value="{{number_format($balanceToPay * 3 /100, 2)}}" readonly />
                                                    </div>

                                                    <div class="col-md-6 mt-2">
                                                        <label class="form-lable">Amount To Pay ($): <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control card_payment_amount" value="{{number_format($balanceToPay * 103/100, 2)}}" readonly/>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-lg-12 control-btns" style="background-color: white">
                                        <button style="display: none" type="submit" class="btn btn-success btn-custom" id="confirm-purchase-card">Confirm Payment</button>
                                    </div>

                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Order Summary --}}

        <div class="col-md-3 card tab-content" style="border: none;border-radius:0rem;min-height: 30rem;">
            <div class="tab-pane tab-pane2 active" id="card-tab" style="height: 100%;">
                <div class="col-md-12 header-style mt-3" style="padding: 0">
                    Payment Summary
                </div>
                <div class="col-md-12 mt-3" style="padding: 0">
                    <table style="color: #717070; font-size:.8rem;width:100%; line-height: 2;border-bottom:1px solid #b3b3b3">
                        <tr>
                            <td>Total item qty</td>
                            <td class="text-right">{{$order->OrderItems->sum('qty')}}</td>
                        </tr>
                        <tr>
                            <td>Order item amount ($)</td>
                            <td class="text-right">{{number_format($order->sub_total, 2)}}</td>
                        </tr>
                        <tr>
                            <td>Sales tax fee {{$store->sales_tax}}% ($)</td>
                            <td class="text-right">{{number_format($order->sales_tax , 2)}}</td>
                        </tr>
                        <tr>
                            <td>Shipping fee ($)</td>
                            <td class="text-right">{{number_format($order->shipping , 2)}}</td>
                        </tr>
                        <tr>
                            <td>Artwork & other fees ($)</td>
                            <td class="text-right">{{number_format($order->handling_fee , 2)}}</td>
                        </tr>


                        <tr style="vertical-align: bottom;font-weight:700;height:40px">
                            <td>Total invoice amount ($)</td>
                            <td class="text-right">{{number_format($order->total, 2)}}</td>
                        </tr>

                        <tr style="vertical-align: bottom;font-weight:700;height:40px">
                            <td>Paid amount ($)</td>
                            <td class="text-right">{{number_format($totalPaidAmount, 2)}}</td>
                        </tr>
                        <tr>
                            <td>Paid Processing Fee ($)</td>
                            <td class="text-right">{{number_format($paidProcessingFee , 2)}}</td>
                        </tr>

                        <tr style="height: 10px;"></tr>
                        <tr style="color: black;line-height: 1.5;border-top:1px solid #b3b3b3">
                            <td style="font-size: .8rem;font-weight: 600;">Balance invoice amount ($)</td>
                            <td style="font-size:16px; font-weight: 700;" class="text-right">{{number_format($balanceToPay, 2)}} </td>
                        </tr>
                        <tr>
                            <td>Processing fee 3% ($)</td>
                            <td class="text-right">{{number_format($balanceToPay * 3 / 100, 2)}}</td>
                        </tr>
                        <tr style="color: black;">
                            <td style="font-size: .8rem;font-weight: 600;">Total amount to pay ($)</td>
                            <td style="font-size:16px; font-weight: 700; color:red" id="amount" class="text-right">{{number_format(($balanceToPay * 103 / 100), 2)}}</td>
                        </tr>

                    </table>
                </div>
                <div class="col-md-12 text-right" style="padding-right: 0px">
                    <button type="button" class="btn btn-success btn-custom mt-2" id="pay_button" onclick="submitCardForm()" ><i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;  CONFIRM & PAY</button>
                </div>
                <div class="col-md-12 form-field" style="padding: 0;">
                    <div class="row ml-1 mt-3" style="margin-bottom: 0rem !important;border-top: 1px solid #b3b3b3;margin-right:2rem">
                        <div class="col-md-12 mt-3" style="padding: 0px">
                            <img src="{{asset('argon')}}/img/icons/visa.png" style="height: 25px;" />
                            <img src="{{asset('argon')}}/img/icons/mastercard.png" class="ml-1" style="height: 25px;" />
                            <img src="{{asset('argon')}}/img/icons/discover.png" class="ml-1" style="height: 25px;" />
                            <img src="{{asset('argon')}}/img/icons/american_express.png" class="ml-1" style="height: 25px;" />
                            <img src="{{asset('argon')}}/img/icons/venmo.png" class="ml-1" style="height: 25px;" />
                            <img src="{{asset('argon')}}/img/icons/paypal.png" class="ml-1" style="width: 50px;" />
                        </div>

                        <div class="col-md-12 mt-2" style="padding: 0px"><p style="color: #5a5a5a;font-size:.7rem;line-height:1rem"><i style="color: blue" class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;<b style="font-weight: 700">DISCLAIMER</b> <br/> 3% processing fee will be added to all card payments.</p></div>
                    </div>
                </div>
            </div>

        </div>

        {{-- End Order Summary --}}
    </div>
</div>

@include('pages.customer_team_store.layouts.footer')

<script>
    function submitCardForm() {
        $('.se-pre-con').fadeIn();
        $('#confirm-purchase-card').click();
    }
</script>
@endsection
