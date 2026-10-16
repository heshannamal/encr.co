@extends('pages.customer_sessions.layout')
@section('title','Available Sessions | Encore Fitness')
@section('content')
@php
    $availableCredits = isset($remainingCredits) ? (int)$remainingCredits : 0;
    $children = isset($children) ? $children : collect();
@endphp
<div class="ec-page-head"><div><h1 class="ec-page-title">Available Sessions</h1><p class="ec-page-subtitle">Select a session and book using one credit.</p></div><a href="{{ route('em.customer.packages') }}" class="ec-btn ec-btn-outline">Buy Package</a></div>
<div class="ec-card mb-4"><div class="ec-card-body">
    <form method="GET" action="{{ url()->current() }}" class="row g-3">
        <div class="col-md-3"><input class="ec-form-control" name="coach" value="{{ request('coach') }}" placeholder="Instructor"></div>
        <div class="col-md-3"><input class="ec-form-control" name="location" value="{{ request('location') }}" placeholder="Location"></div>
        <div class="col-md-3"><input class="ec-form-control" type="date" name="date" value="{{ request('date') }}"></div>
        <div class="col-md-3"><button type="submit" class="ec-btn ec-btn-primary w-100"><i class="fa-solid fa-search"></i>Search</button></div>
    </form>
</div></div>
<div class="row g-3">
@forelse($sessions as $session)
    @php $bookedCount = method_exists($session,'bookings') ? $session->bookings()->whereIn('status',['booked','completed'])->count() : 0; $capacity=max(1,(int)($session->capacity ?: 1)); $spotsLeft=max(0,$capacity-$bookedCount); @endphp
    <div class="col-xl-4 col-md-6"><article class="ec-session-card">
        <div class="ec-session-top"><div><div class="ec-session-date"><i class="fa-regular fa-calendar"></i>{{ \Carbon\Carbon::parse($session->event_date)->format('M d, Y') }}</div><div class="ec-session-date mt-1"><i class="fa-regular fa-clock"></i>{{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($session->end_time)->format('h:i A') }}</div></div><span class="ec-badge {{ $spotsLeft ? 'ec-badge-success' : 'ec-badge-danger' }}">{{ $spotsLeft ? $spotsLeft.' left' : 'Full' }}</span></div>
        <h3 class="ec-session-title">{{ $session->name }}</h3><div><span class="ec-session-type">{{ $session->training_type ?: 'Training' }}</span></div>
        <div class="ec-session-meta"><i class="fa-solid fa-user-tie"></i>{{ $session->instructor ?: $session->coach_name ?: 'Instructor' }}</div><div class="ec-session-meta"><i class="fa-solid fa-location-dot"></i>{{ $session->location }}</div>
        <div class="ec-session-actions"><span class="ec-spots">{{ $bookedCount }} / {{ $capacity }} booked</span><button type="button" class="ec-btn ec-btn-primary js-book-session" data-action="{{ route('em.customer.session.book',$session->id) }}" data-session="{{ $session->name }}" data-has-credits="{{ $availableCredits > 0 ? 1 : 0 }}" {{ $spotsLeft <= 0 ? 'disabled' : '' }}>Book</button></div>
    </article></div>
@empty<div class="col-12"><div class="ec-empty"><i class="fa-regular fa-calendar-xmark"></i><h5>No sessions found</h5></div></div>@endforelse
</div>
@include('pages.customer_sessions.partials.book-modal')
@endsection
@push('scripts')
@include('pages.customer_sessions.partials.book-script')
@endpush
