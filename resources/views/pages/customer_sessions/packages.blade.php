@extends('pages.customer_sessions.layout')
@section('title','Packages | Encore Fitness')
@section('content')
<div class="ec-page-head">
    <div><h1 class="ec-page-title">Packages</h1><p class="ec-page-subtitle">Choose a package and receive class credits.</p></div>
</div>
<div class="row g-3">
    @forelse($packages as $package)
        <div class="col-xl-4 col-md-6">
            <div class="ec-package-card">
                @if($package->package_image)
                    @php
                        $packageImage = \Illuminate\Support\Str::startsWith($package->package_image,['http://','https://']) ? $package->package_image : asset('storage/' . ltrim($package->package_image,'/'));
                    @endphp
                    <img src="{{ $packageImage }}" alt="{{ $package->package_name }}" style="height:180px;width:100%;object-fit:cover">
                @else
                    <div class="ec-package-visual"><div class="ec-package-number">{{ (int)$package->available_classes }}<small>CLASS PACK</small></div></div>
                @endif
                <div class="ec-package-body">
                    <div class="ec-package-name">{{ $package->package_name }}</div>
                    <div class="ec-package-price">${{ number_format($package->package_price,2) }}</div>
                    <p class="small text-muted">{{ \Illuminate\Support\Str::limit($package->package_description,110) }}</p>
                    <ul class="ec-package-features">
                        <li><i class="fa-solid fa-check"></i>{{ (int)$package->available_classes }} session credits</li>
                        {{-- <li><i class="fa-solid fa-check"></i>Valid for {{ (int)($package->valid_days ?: 30) }} days</li> --}}
                        <li><i class="fa-solid fa-check"></i>Use credits on any available session</li>
                    </ul>
                    <a href="{{ route('em.customer.package.details',$package->id) }}" class="ec-btn ec-btn-dark w-100 mt-auto">View Details</a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12"><div class="ec-empty"><i class="fa-solid fa-box-open"></i><h5>No packages available</h5></div></div>
    @endforelse
</div>
@endsection
