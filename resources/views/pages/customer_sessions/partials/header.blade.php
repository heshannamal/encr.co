@php
    $currentPath = request()->path();
    $customerName = $customer->name ?? 'Customer';
    $photo = $customer->profile_photo ?? null;
    $photoUrl = $photo ? (Str::startsWith($photo, ['http://','https://']) ? $photo : asset('storage/'.$photo)) : null;
@endphp
<header class="em-topbar">
    <div class="em-container py-0 h-100 d-flex align-items-center justify-content-between">
        <a href="{{ route('em.customer.landing.index') }}" class="em-logo">
            <span class="em-logo-icon"><i class="fa-solid fa-dumbbell"></i></span>
            Encore Fitness
        </a>
        <nav class="em-nav">
            <a href="{{ route('em.customer.packages') }}" class="{{ str_contains($currentPath,'packages') ? 'active' : '' }}">Packages</a>
            <a href="{{ route('em.customer.bookings') }}" class="{{ str_contains($currentPath,'bookings') ? 'active' : '' }}">My Bookings</a>
        </nav>
        <div class="d-flex align-items-center gap-3">
            <a class="em-cart" href="{{ route('em.customer.cart') }}">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="em-cart-count">{{ $cartCount ?? 0 }}</span>
            </a>
            <div class="dropdown">
                <a class="d-flex align-items-center gap-2 text-decoration-none text-dark" href="#" data-bs-toggle="dropdown">
                    @if($photoUrl)
                        <img class="em-avatar" src="{{ $photoUrl }}" alt="{{ $customerName }}">
                    @else
                        <span class="em-avatar">{{ strtoupper(substr($customerName,0,1)) }}</span>
                    @endif
                    <strong class="d-none d-md-inline">{{ $customerName }}</strong>
                    <i class="fa-solid fa-chevron-down small text-muted"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 p-2">
                    <a class="dropdown-item rounded-3" href="{{ route('em.customer.profile') }}"><i class="fa-regular fa-user me-2"></i>Profile</a>
                    <a class="dropdown-item rounded-3" href="{{ route('em.customer.bookings') }}"><i class="fa-regular fa-calendar-check me-2"></i>My Bookings</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('em.customer.logout') }}" class="m-0">
                        @csrf
                        <button class="dropdown-item rounded-3 text-danger" type="submit"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
