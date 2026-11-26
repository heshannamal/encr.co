@extends('layouts.customer_team_store.app')

@section('content')
<style>
.coach-payment-page{padding-top:90px;padding-bottom:50px;min-height:80vh;background:#f7f8fa}.coach-payment-card{background:#fff;border:1px solid #eceff3;border-radius:12px;box-shadow:0 3px 14px rgba(0,0,0,.05);overflow:hidden}.coach-payment-header{padding:20px 22px;border-bottom:1px solid #eceff3}.coach-payment-header h3{margin:0;font-size:20px;font-weight:700;color:#32325d}.coach-payment-header p{margin:5px 0 0;font-size:12px;color:#8898aa}.coach-payment-body{padding:22px}.coach-payment-summary{width:100%;font-size:13px;color:#525f7f}.coach-payment-summary td{padding:8px 0;border-bottom:1px solid #f0f1f3}.coach-payment-summary tr:last-child td{border-bottom:0;padding-top:14px;font-size:16px;font-weight:700;color:#111827}.coach-payment-section-title{margin:20px 0 10px;font-size:12px;font-weight:700;text-transform:uppercase;color:#525f7f}.coach-payment-field{margin-bottom:12px}.coach-payment-field label{display:block;font-size:11px;font-weight:600;color:#525f7f;margin-bottom:4px}.coach-payment-field .form-control{min-height:38px;font-size:14px}.coach-pay-btn{width:100%;min-height:44px;border:0;border-radius:8px;background:#17a589;color:#fff;font-size:14px;font-weight:700;cursor:pointer}.coach-pay-btn:hover{background:#12836e}.coach-payment-complete{padding:20px;background:#ecfdf5;border:1px solid #b7e4d6;color:#117a65;border-radius:10px;text-align:center;font-weight:700}.coach-payment-review{padding:20px;background:#fff7d6;border:1px solid #f0c36d;color:#8a5a00;border-radius:10px;text-align:center;font-weight:700}@media(max-width:767px){.coach-payment-page{padding-top:75px}}
</style>

<div class="coach-payment-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                @if(session('warning'))<div class="alert alert-warning">{{ session('warning') }}</div>@endif
                @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
                @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

                <div class="coach-payment-card">
                    <div class="coach-payment-header">
                        <h3>Coach Shipping Payment</h3>
                        <p>{{ $store->store_name ?? $store->name ?? 'Team Store' }}</p>
                    </div>

                    <div class="coach-payment-body">
                        @if($payment->status === 'paid' || $payment->is_success)
                            <div class="coach-payment-complete">
                                <i class="fa fa-check-circle"></i> This coach shipping payment has been completed.
                                <div style="margin-top:5px;font-size:18px;">${{ number_format((float) $payment->total_amount, 2) }}</div>
                            </div>
                        @elseif(in_array($payment->status, ['under_review', 'review_required', 'processing'], true))
                            <div class="coach-payment-review"><i class="fa fa-clock-o"></i> This payment is under review or its result is uncertain. Please do not submit it again.</div>
                        @elseif($payment->status !== 'pending')
                            <div class="alert alert-warning">This payment link is no longer active.</div>
                        @else
                            <table class="coach-payment-summary">
                                <tr><td>Coach items</td><td class="text-right">{{ (int) $payment->item_count }}</td></tr>
                                <tr><td>Coach shipping amount</td><td class="text-right">${{ number_format((float) $payment->payment_amount, 2) }}</td></tr>
                                <tr><td>Card processing fee (3%)</td><td class="text-right">${{ number_format((float) $payment->processing_fee, 2) }}</td></tr>
                                <tr><td>Total amount to pay</td><td class="text-right">${{ number_format((float) $payment->total_amount, 2) }}</td></tr>
                            </table>

                            <form method="POST" action="{{ function_exists('makeStoreDomainRoute') ? makeStoreDomainRoute('store/coach-payment/' . $payment->payment_token . '/pay') : route('store.coach_payment.pay', ['token' => $payment->payment_token]) }}" id="coach-payment-form">
                                @csrf
                                <div class="coach-payment-section-title">Billing Details</div>
                                <div class="row">
                                    <div class="col-md-6 coach-payment-field"><label>First Name *</label><input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required></div>
                                    <div class="col-md-6 coach-payment-field"><label>Last Name *</label><input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required></div>
                                    <div class="col-md-12 coach-payment-field"><label>Street Address *</label><input type="text" class="form-control" name="street" value="{{ old('street') }}" required></div>
                                    <div class="col-md-5 coach-payment-field"><label>City *</label><input type="text" class="form-control" name="city" value="{{ old('city') }}" required></div>
                                    <div class="col-md-3 coach-payment-field"><label>State *</label><input type="text" class="form-control" name="state" value="{{ old('state') }}" required></div>
                                    <div class="col-md-4 coach-payment-field"><label>ZIP *</label><input type="text" class="form-control" name="zip_code" value="{{ old('zip_code') }}" required></div>
                                    <div class="col-md-4 coach-payment-field"><label>Country *</label><input type="text" class="form-control" name="country" value="{{ old('country', 'US') }}" required></div>
                                    <div class="col-md-4 coach-payment-field"><label>Phone</label><input type="text" class="form-control" name="phone" value="{{ old('phone') }}"></div>
                                    <div class="col-md-4 coach-payment-field"><label>Email *</label><input type="email" class="form-control" name="email" value="{{ old('email', $payment->coach_email) }}" required></div>
                                </div>

                                <div class="coach-payment-section-title">Card Details</div>
                                <div class="row">
                                    <div class="col-md-6 coach-payment-field"><label>Name on Card *</label><input type="text" class="form-control" name="owner" value="{{ old('owner', $payment->coach_name) }}" required></div>
                                    <div class="col-md-6 coach-payment-field"><label>Card Number *</label><input type="text" class="form-control" name="cardNumber" inputmode="numeric" autocomplete="cc-number" required></div>
                                    <div class="col-md-3 coach-payment-field"><label>Month *</label><select class="form-control" name="expiration-month" required>@foreach($months as $key => $month)<option value="{{ $key }}">{{ $month }}</option>@endforeach</select></div>
                                    <div class="col-md-3 coach-payment-field"><label>Year *</label><select class="form-control" name="expiration-year" required>@for($year = date('Y'); $year <= date('Y') + 15; $year++)<option value="{{ $year }}">{{ $year }}</option>@endfor</select></div>
                                    <div class="col-md-3 coach-payment-field"><label>CVV *</label><input type="password" class="form-control" name="cvv" inputmode="numeric" autocomplete="cc-csc" minlength="3" maxlength="4" required></div>
                                </div>

                                <button type="submit" class="coach-pay-btn" id="coach-pay-button"><i class="fa fa-lock"></i> Pay ${{ number_format((float) $payment->total_amount, 2) }}</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$('#coach-payment-form').on('submit', function(){
    $('#coach-pay-button').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing Payment...');
});
</script>
@endsection
