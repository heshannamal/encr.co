@extends('pages.customer_sessions.layout')
@section('title','Payment Successful | Encore Fitness')
@section('content')
<div class="ec-card mx-auto text-center" style="max-width:680px;margin-top:35px"><div class="ec-card-body py-5 px-4">
    <div class="mx-auto mb-4 d-flex align-items-center justify-content-center rounded-circle" style="width:70px;height:70px;background:#dbf7e9;color:#00a963;font-size:30px"><i class="fa-solid fa-check"></i></div>
    <h1 class="ec-page-title mb-2">Payment Successful</h1>
    <p class="text-muted">Your package credits have been added to your account.</p>
    <div class="border rounded p-3 my-4 text-start">
        <div class="d-flex justify-content-between"><span>Order Number</span><strong>{{ $order->order_no ?: $order->id }}</strong></div>
        <div class="d-flex justify-content-between mt-2"><span>Amount Paid</span><strong>${{ number_format($order->total,2) }}</strong></div>
    </div>
    <div class="d-flex flex-wrap justify-content-center gap-2"><a href="{{ route('em.customer.dashboard') }}" class="ec-btn ec-btn-primary">View Sessions</a><a href="{{ route('em.customer.bookings') }}" class="ec-btn ec-btn-outline">My Bookings</a></div>
</div></div>
@endsection
