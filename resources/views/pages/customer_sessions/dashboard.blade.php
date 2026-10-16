@extends('pages.customer_sessions.layout')
@section('title','Dashboard | Encore Fitness')
@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div>
        <h1 class="ec-page-title">Dashboard</h1>
        <p class="ec-page-subtitle">Welcome back, {{ $customer->name }}.</p>
    </div>
    </div>
    <div class="col-md-4">
        <div class="ec-stat">
            <div class="ec-stat-label">Remaining Credits</div>
            <div class="ec-stat-value">{{ $remainingCredits }}</div>
            <i class="fa-regular fa-credit-card ec-stat-icon"></i>
            <a class="ec-stat-more" href="{{ route('em.customer.packages') }}">More</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="ec-stat">
            <div class="ec-stat-label">Used Credits</div>
            <div class="ec-stat-value">{{ $usedCredits }}</div>
            <i class="fa-regular fa-calendar-check ec-stat-icon"></i>
            <a class="ec-stat-more" href="{{ route('em.customer.bookings') }}">More</a>
        </div>
    </div>
</div>

<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h2 class="ec-card-title">Available Sessions</h2>
        <div class="small text-muted mt-1">Choose a session and reserve a place using one credit.</div>
    </div>
</div>
<div class="row g-3">
    @forelse($sessions as $session)
        @php
            $bookedCount = method_exists($session, 'bookings') ? $session->bookings()->whereIn('status',['booked','completed'])->count() : 0;
            $capacity = max(1, (int)($session->capacity ?: 1));
            $spotsLeft = max(0, $capacity - $bookedCount);
        @endphp
        <div class="col-xl-4 col-md-6">
            <article class="ec-session-card">
                <div class="ec-session-top">
                    <div>
                        <div class="ec-session-date">
                            <i class="fa-regular fa-calendar"></i>
                            {{ \Carbon\Carbon::parse($session->event_date)->format('l, M d, Y') }}
                        </div>

                        <div class="ec-session-date mt-1">
                            <i class="fa-regular fa-clock"></i>
                            {{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }}
                            -
                            {{ \Carbon\Carbon::parse($session->end_time)->format('h:i A') }}
                        </div>
                    </div>
                </div>
                {{-- <h3 class="ec-session-title">{{ $session->name }}</h3> --}}
                <h3 class="ec-session-title">{{ $session->training_type ?: 'Training' }}</h3>
                {{-- <div><span class="ec-session-type">{{ $session->training_type ?: 'Training' }}</span></div> --}}
                @if($session->description)<p class="small text-muted mb-2">{{ \Illuminate\Support\Str::limit($session->description, 90) }}</p>@endif
                <div class="ec-session-meta"><i class="fa-solid fa-user-tie"></i><span>{{ $session->instructor ?: $session->coach_name ?: 'Instructor' }}</span></div>
                <div class="ec-session-meta"><i class="fa-solid fa-location-dot"></i><span>{{ $session->location ?: 'Location TBA' }}</span></div>
                @if($session->what_to_bring)<div class="ec-session-meta"><i class="fa-solid fa-bag-shopping"></i><span>{{ \Illuminate\Support\Str::limit($session->what_to_bring, 70) }}</span></div>@endif
                @if($session->documentation)
                    <div class="ec-session-meta"><i class="fa-regular fa-file-pdf"></i><a href="{{ asset('storage/' . $session->documentation) }}" target="_blank">Documentation</a></div>
                @endif
                <div class="ec-session-actions">
                    <span class="ec-spots {{ $spotsLeft <= 0 ? 'full' : '' }}">{{ $bookedCount }} booked</span>
                    <button type="button"
                            class="ec-btn ec-btn-primary js-book-session"
                            data-action="{{ route('em.customer.session.book', $session->id) }}"
                            data-session="{{ $session->name }}"
                            data-has-credits="{{ $remainingCredits > 0 ? 1 : 0 }}"
                            {{ $spotsLeft <= 0 ? 'disabled' : '' }}>
                        Book
                    </button>
                </div>
            </article>
        </div>
    @empty
        <div class="col-12"><div class="ec-empty"><i class="fa-regular fa-calendar-xmark"></i><h5>No available sessions</h5><p class="mb-0">New sessions will appear here when available.</p></div></div>
    @endforelse
</div>
@include('pages.customer_sessions.partials.book-modal')
@endsection
@push('scripts')
@include('pages.customer_sessions.partials.book-script')
@endpush
