@extends('pages.customer_sessions.layout')
@section('title','My Bookings | Encore Fitness')
@section('content')
<div class="ec-page-head"><div><h1 class="ec-page-title">My Bookings</h1><p class="ec-page-subtitle">View upcoming and previous session reservations.</p></div></div>
@php
    $upcomingBookings = $bookings->filter(function($booking){ return $booking->status === 'booked' && $booking->sessionEvent && \Carbon\Carbon::parse($booking->sessionEvent->event_date)->endOfDay()->gte(now()); });
    $pastBookings = $bookings->reject(function($booking) use ($upcomingBookings){ return $upcomingBookings->contains('id',$booking->id); });
@endphp
<ul class="nav ec-tabs" role="tablist">
    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#upcomingBookings" type="button">Upcoming</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#pastBookings" type="button">Past & Cancelled</button></li>
</ul>
<div class="tab-content">
    <div class="tab-pane fade show active" id="upcomingBookings">
        <div class="ec-table-wrap">
            @if($upcomingBookings->count())
                <div class="table-responsive"><table class="ec-table"><thead><tr><th>Session</th><th>Date & Time</th><th>Location</th><th>Player</th><th>Status</th><th>Action</th></tr></thead><tbody>
                    @foreach($upcomingBookings as $booking)
                        @php $session = $booking->sessionEvent; @endphp
                        <tr>
                            <td><strong class="text-dark">{{ $session ? $session->name : 'Session' }}</strong><div class="small text-muted">{{ $session ? ($session->training_type ?: 'Training') : '' }}</div></td>
                            <td>
                                {{ $session
                                    ? \Carbon\Carbon::parse($session->event_date)->format('l, M d, Y')
                                    : '-'
                                }}

                                <div class="small text-muted">
                                    {{ $session
                                        ? \Carbon\Carbon::parse($session->start_time)->format('h:i A')
                                            . ' - ' .
                                        \Carbon\Carbon::parse($session->end_time)->format('h:i A')
                                        : ''
                                    }}
                                </div>
                            </td>
                            <td>{{ $session ? $session->location : '-' }}</td>
                            <td>{{ $booking->player_first }} {{ $booking->player_last }}<div class="small text-muted">{{ is_array($booking->positions) ? implode(', ',$booking->positions) : '' }}</div></td>
                            <td><span class="ec-badge ec-badge-success">{{ ucfirst($booking->status) }}</span></td>
                            <td><form method="POST" action="{{ route('em.customer.booking.cancel',$booking->id) }}" onsubmit="return confirm('Cancel this booking and return the credit?')">@csrf<button class="ec-btn ec-btn-danger" type="submit">Cancel</button></form></td>
                        </tr>
                    @endforeach
                </tbody></table></div>
            @else<div class="ec-empty m-3"><i class="fa-regular fa-calendar"></i><h5>No upcoming bookings</h5></div>@endif
        </div>
    </div>
    <div class="tab-pane fade" id="pastBookings">
        <div class="ec-table-wrap">
            @if($pastBookings->count())
                <div class="table-responsive"><table class="ec-table"><thead><tr><th>Session</th><th>Date</th><th>Player</th><th>Status</th></tr></thead><tbody>
                @foreach($pastBookings as $booking)
                    <tr><td><strong>{{ $booking->sessionEvent ? $booking->sessionEvent->name : 'Session' }}</strong></td><td>{{ $booking->sessionEvent ? \Carbon\Carbon::parse($booking->sessionEvent->event_date)->format('M d, Y') : '-' }}</td><td>{{ $booking->player_first }} {{ $booking->player_last }}</td><td><span class="ec-badge {{ $booking->status === 'completed' ? 'ec-badge-info' : 'ec-badge-danger' }}">{{ ucfirst($booking->status) }}</span></td></tr>
                @endforeach
                </tbody></table></div>
            @else<div class="ec-empty m-3"><i class="fa-solid fa-clock-rotate-left"></i><h5>No past bookings</h5></div>@endif
        </div>
    </div>
</div>
@endsection
