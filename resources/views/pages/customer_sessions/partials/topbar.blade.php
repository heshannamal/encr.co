@php
    $profilePhoto = isset($customer) && $customer ? $customer->profile_photo : null;
    $profilePhotoUrl = null;
    if ($profilePhoto) {
        $profilePhotoUrl = \Illuminate\Support\Str::startsWith($profilePhoto, ['http://','https://'])
            ? $profilePhoto
            : asset('storage/' . ltrim($profilePhoto, '/'));
    }
@endphp
<header class="ec-topbar">
    <div class="ec-topbar-left">
        <button type="button" class="ec-menu-btn" id="customerSidebarToggle" aria-label="Toggle menu"><i class="fa-solid fa-bars"></i></button>
        <div class="ec-portal-title">Encore Fitness</div>
    </div>
    <div class="ec-topbar-actions">
        <a href="{{ route('em.customer.cart') }}" class="ec-cart-link" title="Cart">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="ec-cart-count">{{ isset($cartCount) ? $cartCount : 0 }}</span>
        </a>
        <div class="dropdown">
            <a href="#" class="ec-user-menu dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="ec-avatar">
                    @if($profilePhotoUrl)
                        <img src="{{ $profilePhotoUrl }}" alt="{{ isset($customer) && $customer ? $customer->name : 'Customer' }}">
                    @else
                        {{ strtoupper(substr(isset($customer) && $customer ? $customer->name : 'C', 0, 1)) }}
                    @endif
                </span>
                <span class="ec-user-name">{{ isset($customer) && $customer ? $customer->name : 'Customer' }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                <li><a class="dropdown-item small" href="{{ route('em.customer.profile') }}"><i class="fa-regular fa-user me-2"></i>Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('em.customer.logout') }}">
                        @csrf
                        <button class="dropdown-item small text-danger" type="submit"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
