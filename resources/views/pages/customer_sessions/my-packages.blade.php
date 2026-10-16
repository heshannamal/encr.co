@extends('pages.customer_sessions.layout')
@section('title','Credits | Encore Fitness')
@section('content')
<div class="ec-page-head"><div><h1 class="ec-page-title">Package Credits</h1><p class="ec-page-subtitle">View active and expired package credits.</p></div><a href="{{ route('em.customer.packages') }}" class="ec-btn ec-btn-primary">Buy Package</a></div>
<div class="row g-3">
@forelse($credits as $credit)
    @php $total=max(1,(int)$credit->total_classes); $remaining=(int)$credit->remaining_classes; $percent=min(100,round(($remaining/$total)*100)); @endphp
    <div class="col-lg-6"><div class="ec-card"><div class="ec-card-body"><div class="d-flex justify-content-between"><div><h3 class="ec-card-title">{{ $credit->package ? $credit->package->package_name : 'Package' }}</h3><div class="small text-muted mt-1">Valid until {{ $credit->valid_until ? \Carbon\Carbon::parse($credit->valid_until)->format('M d, Y') : '-' }}</div></div><span class="ec-badge {{ $credit->status === 'active' ? 'ec-badge-success' : 'ec-badge-danger' }}">{{ ucfirst($credit->status) }}</span></div><div class="d-flex justify-content-between mt-4 mb-2"><span>{{ $remaining }} remaining</span><strong>{{ $total }} total</strong></div><div class="ec-credit-bar"><span style="width:{{ $percent }}%"></span></div></div></div></div>
@empty<div class="col-12"><div class="ec-empty"><i class="fa-solid fa-ticket"></i><h5>No package credits</h5></div></div>@endforelse
</div>
@endsection
