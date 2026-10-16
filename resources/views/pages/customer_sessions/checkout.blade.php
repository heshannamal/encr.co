@extends('pages.customer_sessions.layout')

@section('title','Checkout | Encore Fitness')

@section('content')
@php
    $items = collect($items ?? []);

    $subtotal = $totals['subtotal'] ?? ($subtotal ?? $items->sum('total_price'));
    $processingFee = $totals['processing_fee'] ?? round($subtotal * 0.03, 2);
    $tax = $totals['tax'] ?? 0;
    $total = $totals['total'] ?? ($subtotal + $processingFee + $tax);

    $totalCredits = $items->sum(function ($item) {
        return $item->package
            ? ((int) $item->package->available_classes * (int) $item->quantity)
            : 0;
    });

    $customerName = trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? ''));
@endphp

<div class="ec-page-head">
    <div>
        <h1 class="ec-page-title">Checkout</h1>
        <p class="ec-page-subtitle">Complete your package purchase by card.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        Please check the highlighted fields and try again.
    </div>
@endif

<form method="POST" action="{{ route('em.customer.pay') }}" id="checkoutPaymentForm">
    @csrf

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="ec-card position-sticky" style="top:84px">
                <div class="ec-card-body">
                    <h3 class="ec-card-title mb-3">Order Summary</h3>

                    @foreach($items as $item)
                        <div class="d-flex justify-content-between gap-3 py-3 border-bottom">
                            <div>
                                <strong>
                                    {{ $item->package ? $item->package->package_name : 'Package' }}
                                </strong>

                                <div class="small text-muted">
                                    {{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }}
                                </div>

                                @if($item->package)
                                    <div class="small text-muted">
                                        {{ (int) $item->package->available_classes * (int) $item->quantity }} credits
                                    </div>
                                @endif
                            </div>

                            <strong>
                                ${{ number_format($item->total_price, 2) }}
                            </strong>
                        </div>
                    @endforeach

                    <div class="d-flex justify-content-between py-3">
                        <span class="text-muted">Total Credits</span>
                        <strong>{{ $totalCredits }}</strong>
                    </div>

                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted">Subtotal</span>
                        <strong>${{ number_format($subtotal, 2) }}</strong>
                    </div>

                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted">Processing Fee 3%</span>
                        <strong>${{ number_format($processingFee, 2) }}</strong>
                    </div>

                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted">Tax</span>
                        <strong>${{ number_format($tax, 2) }}</strong>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <strong>Total</strong>
                        <strong class="fs-4 text-danger">
                            ${{ number_format($total, 2) }}
                        </strong>
                    </div>

                    <a href="{{ route('em.customer.cart') }}"
                       class="ec-btn ec-btn-outline w-100">
                        Back to Cart
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="ec-card">
                <div class="ec-card-body">
                    <h3 class="ec-card-title mb-4">Billing Information</h3>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="ec-label">First Name <span class="text-danger">*</span></label>
                            <input class="ec-form-control @error('first_name') is-invalid @enderror"
                                   name="first_name"
                                   value="{{ old('first_name', $customer->first_name ?? '') }}"
                                   required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="ec-label">Last Name</label>
                            <input class="ec-form-control @error('last_name') is-invalid @enderror"
                                   name="last_name"
                                   value="{{ old('last_name', $customer->last_name ?? '') }}">
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="ec-label">Email <span class="text-danger">*</span></label>
                            <input type="email"
                                   class="ec-form-control @error('email') is-invalid @enderror"
                                   name="email"
                                   value="{{ old('email', $customer->email ?? '') }}"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="ec-label">Phone</label>
                            <input class="ec-form-control @error('phone') is-invalid @enderror"
                                   name="phone"
                                   value="{{ old('phone', $customer->phone ?? '') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="ec-label">Street Address <span class="text-danger">*</span></label>
                            <input class="ec-form-control @error('street') is-invalid @enderror"
                                   name="street"
                                   value="{{ old('street') }}"
                                   required>
                            @error('street')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-5">
                            <label class="ec-label">City <span class="text-danger">*</span></label>
                            <input class="ec-form-control @error('city') is-invalid @enderror"
                                   name="city"
                                   value="{{ old('city') }}"
                                   required>
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="ec-label">State <span class="text-danger">*</span></label>
                            <input class="ec-form-control @error('state') is-invalid @enderror"
                                   name="state"
                                   value="{{ old('state') }}"
                                   required>
                            @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="ec-label">Zip Code <span class="text-danger">*</span></label>
                            <input class="ec-form-control @error('zip_code') is-invalid @enderror"
                                   name="zip_code"
                                   value="{{ old('zip_code') }}"
                                   required>
                            @error('zip_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="ec-label">Country <span class="text-danger">*</span></label>
                            <input class="ec-form-control @error('country') is-invalid @enderror"
                                   name="country"
                                   value="{{ old('country', 'USA') }}"
                                   required>
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <h3 class="ec-card-title mb-4">Payment Information</h3>

                    <div class="mb-3">
                        <label class="ec-label">Name on Card <span class="text-danger">*</span></label>
                        <input class="ec-form-control @error('owner') is-invalid @enderror"
                               name="owner"
                               value="{{ old('owner', $customerName) }}"
                               placeholder="Name as shown on card"
                               required>
                        @error('owner')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="ec-label">Card Number <span class="text-danger">*</span></label>
                        <input class="ec-form-control @error('cardNumber') is-invalid @enderror"
                               name="cardNumber"
                               value="{{ old('cardNumber') }}"
                               placeholder="1234 1234 1234 1234"
                               autocomplete="cc-number"
                               required>
                        @error('cardNumber')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="ec-label">Expiry Month <span class="text-danger">*</span></label>
                            <select name="expiration-month"
                                    class="ec-form-control @error('expiration-month') is-invalid @enderror"
                                    autocomplete="cc-exp-month"
                                    required>
                                <option value="">MM</option>
                                @for($m = 1; $m <= 12; $m++)
                                    @php $month = str_pad($m, 2, '0', STR_PAD_LEFT); @endphp
                                    <option value="{{ $month }}" {{ old('expiration-month') == $month ? 'selected' : '' }}>
                                        {{ $month }}
                                    </option>
                                @endfor
                            </select>
                            @error('expiration-month')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="ec-label">Expiry Year <span class="text-danger">*</span></label>
                            <select name="expiration-year"
                                    class="ec-form-control @error('expiration-year') is-invalid @enderror"
                                    autocomplete="cc-exp-year"
                                    required>
                                <option value="">YYYY</option>
                                @for($y = now()->year; $y <= now()->year + 15; $y++)
                                    <option value="{{ $y }}" {{ old('expiration-year') == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                            @error('expiration-year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="ec-label">CVV <span class="text-danger">*</span></label>
                            <input class="ec-form-control @error('cvv') is-invalid @enderror"
                                   name="cvv"
                                   value="{{ old('cvv') }}"
                                   placeholder="123"
                                   autocomplete="cc-csc"
                                   required>
                            @error('cvv')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit"
                            class="ec-btn ec-btn-primary w-100 mt-4"
                            id="payButton">
                        <i class="fa-solid fa-lock"></i>
                        Pay ${{ number_format($total, 2) }}
                    </button>

                    <div class="small text-muted text-center mt-3">
                        <i class="fa-solid fa-shield-halved me-1"></i>
                        Your payment information is protected.
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('checkoutPaymentForm');
        const payButton = document.getElementById('payButton');

        form?.addEventListener('submit', function () {
            if (payButton) {
                payButton.disabled = true;
                payButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing Payment...';
            }
        });
    });
</script>
@endsection
