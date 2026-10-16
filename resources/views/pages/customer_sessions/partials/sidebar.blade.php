<aside class="ec-sidebar" id="customerSidebar">
    <a class="ec-sidebar-brand" href="{{ route('em.customer.landing.index') }}">
        <img src="https://encr.co/argon/img/encore/logo_dark.png" alt="Encore">
    </a>
    <nav class="ec-sidebar-nav">
        <a class="ec-nav-link {{ request()->routeIs('em.customer.dashboard') ? 'active' : '' }}" href="{{ route('em.customer.dashboard') }}">
            <i class="fa-solid fa-house"></i><span>Dashboard</span>
        </a>
        <a class="ec-nav-link {{ request()->routeIs('em.customer.bookings') ? 'active' : '' }}" href="{{ route('em.customer.bookings') }}">
            <i class="fa-regular fa-calendar-check"></i><span>My Bookings</span>
        </a>
        <a class="ec-nav-link {{ request()->routeIs('em.customer.packages') || request()->routeIs('em.customer.package.*') ? 'active' : '' }}" href="{{ route('em.customer.packages') }}">
            <i class="fa-solid fa-box-open"></i><span>Packages</span>
        </a>
        <a class="ec-nav-link {{ request()->routeIs('em.customer.profile') ? 'active' : '' }}" href="{{ route('em.customer.profile') }}">
            <i class="fa-regular fa-user"></i><span>My Profile</span>
        </a>
        <form method="POST" action="{{ route('em.customer.logout') }}" class="m-0">
            @csrf
            <button type="submit" class="ec-nav-link border-0 w-100 text-start" style="background:transparent">
                <i class="fa-solid fa-arrow-right-from-bracket"></i><span>Logout</span>
            </button>
        </form>
    </nav>
    <div class="ec-sidebar-help">
        <strong><i class="fa-regular fa-lightbulb me-2"></i>Need Help?</strong>
        info@encr.co
    </div>
</aside>
