@extends('pages.customer_sessions.layout')
@section('title',$package->package_name . ' | Encore Fitness')
@section('content')
<div class="mb-3"><a href="{{ route('em.customer.packages') }}" class="text-decoration-none text-muted small"><i class="fa-solid fa-arrow-left me-2"></i>Back to Packages</a></div>
<div class="ec-card">
    <div class="ec-card-body p-lg-4">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-6">
                @if($package->package_image)
                    @php $packageImage = \Illuminate\Support\Str::startsWith($package->package_image,['http://','https://']) ? $package->package_image : asset('storage/' . ltrim($package->package_image,'/')); @endphp
                    <img src="{{ $packageImage }}" alt="{{ $package->package_name }}" class="w-100 h-100" style="min-height:440px;object-fit:cover;border-radius:7px">
                @else
                    <div class="ec-package-visual h-100" style="min-height:440px;border-radius:7px"><div class="ec-package-number" style="font-size:110px">{{ (int)$package->available_classes }}<small>CLASS PACK</small></div></div>
                @endif
            </div>
            <div class="col-lg-6 d-flex flex-column">
                <h1 class="ec-page-title mb-2">{{ $package->package_name }}</h1>
                <div class="ec-package-price mb-3">${{ number_format($package->package_price,2) }}</div>
                <p class="text-muted">{{ $package->package_description }}</p>
                <ul class="ec-package-features fs-6">
                    <li><i class="fa-solid fa-check"></i>{{ (int)$package->available_classes }} session credits</li>
                    <li><i class="fa-solid fa-check"></i>Use any time within {{ (int)($package->valid_days ?: 30) }} days</li>
                    <li><i class="fa-solid fa-check"></i>Any training type</li>
                    <li><i class="fa-solid fa-check"></i>All available locations</li>
                    <li><i class="fa-solid fa-check"></i>Credits are assigned immediately after payment</li>
                </ul>
                <form method="POST" action="{{ route('em.customer.cart.add',$package->id) }}" class="mt-auto">
                    @csrf
                    <label class="ec-label">Quantity</label>
                    <div class="d-flex gap-2 mb-3" style="max-width:180px">
                        <input type="number" class="ec-form-control" min="1" max="20" name="quantity" value="1">
                    </div>
                    <button type="submit" class="ec-btn ec-btn-primary px-5"><i class="fa-solid fa-cart-plus"></i>Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
