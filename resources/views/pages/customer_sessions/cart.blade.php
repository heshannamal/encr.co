@extends('pages.customer_sessions.layout')

@section('title','Cart | Encore Fitness')

@section('content')
@php
    $items = collect($items ?? []);
    $subtotal = $subtotal ?? $items->sum('total_price');
    $processingFee = $processingFee ?? round($subtotal * 0.03, 2);
    $tax = $tax ?? 0;
    $total = $subtotal + $processingFee + $tax;

    $totalCredits = $items->sum(function ($item) {
        return $item->package
            ? ((int) $item->package->available_classes * (int) $item->quantity)
            : 0;
    });
@endphp

<div class="ec-page-head">
    <div>
        <h1 class="ec-page-title">Your Cart</h1>
        <p class="ec-page-subtitle">Review selected packages before checkout.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="row g-4">
    <div class="col-lg-8">
        <div class="ec-table-wrap">
            @if($items->count())
                <div class="table-responsive">
                    <table class="ec-table">
                        <thead>
                            <tr>
                                <th>Package</th>
                                <th>Credits</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($items as $item)
                            @php
                                $package = $item->package;
                                $credits = $package
                                    ? ((int) $package->available_classes * (int) $item->quantity)
                                    : 0;
                            @endphp

                            <tr>
                                <td>
                                    <strong class="text-dark">
                                        {{ $package ? $package->package_name : 'Package' }}
                                    </strong>

                                    <div class="small text-muted">
                                        ${{ number_format($item->unit_price, 2) }} each
                                    </div>
                                </td>

                                <td>
                                    <strong>{{ $credits }}</strong>
                                </td>

                                <td>
                                    <form method="POST"
                                          action="{{ route('em.customer.cart.update', $item->id) }}"
                                          class="d-flex gap-2"
                                          style="max-width:150px">
                                        @csrf

                                        <input type="number"
                                               min="1"
                                               max="20"
                                               name="quantity"
                                               value="{{ $item->quantity }}"
                                               class="ec-form-control"
                                               style="height:34px;padding:5px 8px">

                                        <button class="ec-btn ec-btn-outline"
                                                type="submit"
                                                style="padding:6px 9px">
                                            <i class="fa-solid fa-rotate"></i>
                                        </button>
                                    </form>
                                </td>

                                <td>
                                    <strong class="text-dark">
                                        ${{ number_format($item->total_price, 2) }}
                                    </strong>
                                </td>

                                <td>
                                    <form method="POST"
                                          action="{{ route('em.customer.cart.remove', $item->id) }}"
                                          onsubmit="return confirm('Remove this package from cart?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm text-danger"
                                                type="submit"
                                                title="Remove">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="ec-empty m-3">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <h5>Your cart is empty</h5>

                    <a href="{{ route('em.customer.packages') }}"
                       class="ec-btn ec-btn-primary mt-2">
                        Browse Packages
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-4">
        <div class="ec-card position-sticky" style="top:84px">
            <div class="ec-card-body">
                <h3 class="ec-card-title mb-3">Order Summary</h3>

                <div class="d-flex justify-content-between py-2">
                    <span class="text-muted">Items</span>
                    <strong>{{ $items->count() }}</strong>
                </div>

                <div class="d-flex justify-content-between py-2">
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
                    <span class="fw-bold">Total</span>
                    <strong class="fs-4 text-danger">
                        ${{ number_format($total, 2) }}
                    </strong>
                </div>

                @if($items->count())
                    <a href="{{ route('em.customer.checkout') }}"
                       class="ec-btn ec-btn-primary w-100">
                        Proceed to Checkout
                    </a>
                @endif

                <a href="{{ route('em.customer.packages') }}"
                   class="ec-btn ec-btn-outline w-100 mt-2">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
