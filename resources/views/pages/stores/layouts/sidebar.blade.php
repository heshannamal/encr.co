<style>
    #sub-navbar {
        background-color: #212529 !important;
        color: #b3b3b3;
        transition: width 0.3s ease, transform 0.3s ease;
        border-left: 1px solid grey;
        overflow-y: auto;
        overflow-x: hidden;
        /* sticky+height so overflow-y:auto triggers scroll on desktop */
        position: sticky;
        top: 0;
        height: 100vh;
        will-change: transform;
        flex-shrink: 0;
    }

    #sub-navbar .navbar {
        background-color: transparent !important;
    }

    #sub-navbar .navbar-nav {
        background-color: transparent !important;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    #sub-navbar .nav-link {
        background-color: transparent !important;
        font-size: 0.7rem;
        display: flex;
        align-items: center;
        padding: 10px 15px;
        transition: background-color 0.2s ease;
        color: #b3b3b3;
    }

    #sub-navbar .nav-link:hover {
        background-color: #2d2d2d;
        color: white;
    }

    #sub-navbar .nav-link.active {
        background-color: #2d2d2d;
        color: white;
    }

    #sub-navbar .nav-link i {
        font-size: 1.1rem;
        width: 25px;
        text-align: center;
        margin-right: 10px;
        transition: margin 0.3s ease;
    }

    #sub-navbar.collapsed .nav-link i {
        margin-right: 0;
    }

    #sub-navbar .nav-text {
        transition: opacity 0.3s ease;
        white-space: nowrap;
    }

    #sub-navbar.collapsed .nav-text {
        opacity: 0;
        display: none;
    }

    #sub-navbar .section-title {
        color: #fff;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        margin: 15px 0 5px 15px;
        text-transform: uppercase;
    }

    #sub-navbar.collapsed .section-title {
        display: none;
    }

    #sub-navbar.collapsed {
        width: 6rem;
    }

    /* Desktop content area */
    .sub-navbar-content {
        transition: width 0.3s ease;
        width: calc(100% - 230px);
        overflow-y: auto;
        overflow-x: hidden;
    }

    #sub-navbar.collapsed+.sub-navbar-content {
        width: calc(100% - 70px);
    }

    /* Desktop inside-sidebar toggle button — visible on desktop only */
    .sub-sidebar-inner-toggler {
        border: 1px solid grey;
        background: transparent;
        color: white;
        margin: 10px auto;
        display: block;
        outline: none !important;
        box-shadow: none !important;
        cursor: pointer;
    }

    #sub-navbar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.48);
        z-index: 1049;
        /* below sidebar (1050) but above all page content */
        -webkit-tap-highlight-color: transparent;
    }

    #sub-navbar-overlay.active {
        display: block;
    }

    /* ---------- Mobile left-edge trigger button ---------- */
    #teamstore-toggle {
        display: none;
        /* hidden on desktop */
    }

    @media (max-width: 767.98px) {

        /* Sidebar: off-screen to the left, slides in as a drawer */
        #sub-navbar {
            position: fixed !important;
            left: 0;
            top: 0;
            /* Use 100dvh when supported (handles mobile browser chrome) */
            height: 100vh;
            height: 100dvh;
            width: 270px !important;
            /* override .collapsed too */
            z-index: 1050;
            border-left: none;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 4px 0 18px rgba(0, 0, 0, 0.45);
            /* Hidden: -100% instead of -110% to avoid partial-visible flicker on fast renders */
            transform: translateX(-100%);
        }

        /* Opened state — added by JS */
        #sub-navbar.mobile-open {
            transform: translateX(0);
        }

        .sub-navbar-content,
        #sub-navbar+#sub-navbar-overlay+.sub-navbar-content {
            width: 100% !important;
            margin-top: 0 !important;
            padding-top: 0 !important;
            overflow-x: hidden;
        }

        /* Mobile nav-link colours / sizing */
        #sub-navbar .nav-link {
            color: #e6e6e6;
            font-size: 0.82rem;
            padding: 12px 18px;
        }

        #sub-navbar .nav-link i,
        #sub-navbar .nav-text,
        #sub-navbar .section-title {
            color: #e6e6e6;
        }

        #sub-navbar .nav-link:hover,
        #sub-navbar .nav-link:hover i {
            color: #ffffff;
        }

        #sub-navbar .nav-link.active {
            background-color: #2d2d2d !important;
        }

        #sub-navbar .nav-link.active i,
        #sub-navbar .nav-link.active .nav-text {
            color: #ca5d5d !important;
        }

        /* Left-edge trigger pill */
        #teamstore-toggle {
            display: flex;
            position: fixed;
            left: 6px;
            top: 50%;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            background: #212529;
            color: #fff;
            z-index: 1110;
            /* above everything */
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
            cursor: pointer;
            transition: left 0.3s ease, background 0.2s ease;
        }

        #teamstore-toggle i {
            font-size: 1rem;
            pointer-events: none;
        }

        /* When the drawer is open, push the trigger button to the right of it
       so it's never hidden underneath the sidebar */
        #teamstore-toggle.sidebar-open {
            left: 278px;
            background: #2d2d2d;
        }

        /* Hide the inner collapse button on mobile — external pill (#teamstore-toggle) is used instead */
        .sub-sidebar-inner-toggler {
            display: none !important;
        }
    }
</style>

@section('order-header')
<span>Team Store</span>
@endsection

<!-- Mobile left-edge trigger button (fixed, only visible on small screens) -->
<button id="teamstore-toggle"
    type="button"
    aria-label="Toggle team store sidebar"
    aria-expanded="false"
    aria-controls="sub-navbar"
    onclick="toggleSubNavbar()">
    <i class="fa fa-angle-double-right" id="teamstore-toggle-icon"></i>
</button>

<!-- Backdrop overlay — OUTSIDE the row so position:fixed covers the full viewport -->
<div id="sub-navbar-overlay" role="presentation" aria-hidden="true"></div>

<div class="row m-0" style="flex-wrap: nowrap; min-height: calc(100vh - 80px);">
    <!-- Sub-sidebar -->
    <div id="sub-navbar" class="col-auto p-0" role="navigation" aria-label="Team Store Navigation">
        <div class="navbar navbar-dark flex-column align-items-stretch p-0">

            <!-- Desktop/mobile close button -->
            <button class="sub-sidebar-inner-toggler navbar-toggler"
                type="button"
                aria-label="Collapse sidebar"
                onclick="toggleSubNavbar()">
                <i class="fa fa-angle-double-left" id="navbar-collapse-icon"></i>
            </button>

            <ul class="navbar-nav flex-column mt-2">
                <!-- BUILD -->
                <li class="section-title">BUILD</li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('store.overview') ? 'active' : '' }}"
                        href="{{ route('store.overview', ['id' => $store->id]) }}" title="OVERVIEW">
                        <i class="fa fa-newspaper"></i><span class="nav-text">OVERVIEW</span>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    @if ($store->store_status == 3)
                        <a class="nav-link" href="#" title="UNARCHIVE STORE">
                            <i class="fa fa-archive"></i><span class="nav-text unarchive_store"
                                data-store_id="{{ $store->id }}">UNARCHIVE STORE</span>
                </a>
                @else
                <a class="nav-link" href="#" title="ARCHIVE STORE">
                    <i class="fa fa-archive"></i><span class="nav-text archive_store"
                        data-store_id="{{ $store->id }}">ARCHIVE STORE</span>
                </a>
                @endif
                </li> --}}

                <!-- COMMUNICATE -->
                <li class="section-title">COMMUNICATE</li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('store.email_customer') ? 'active' : '' }}"
                        href="{{ route('store.email_customer', ['id' => $store->id]) }}" title="EMAIL CUSTOMERS">
                        <i class="fa fa-user-circle"></i><span class="nav-text">EMAIL CUSTOMERS</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('store.flyer') ? 'active' : '' }}"
                        href="{{ route('store.flyer', ['id' => $store->id]) }}" title="FLYER">
                        <i class="fa fa-newspaper"></i><span class="nav-text">FLYER</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('store.manage_group') ? 'active' : '' }}"
                        href="{{ route('store.manage_group', ['id' => $store->id]) }}" title="MANAGE GROUP ACCESS">
                        <i class="fa fa-user-secret"></i><span class="nav-text">MANAGE GROUP ACCESS</span>
                    </a>
                </li>

                <!-- FULFILL -->
                <li class="section-title">FULFILL</li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('store.manage_orders') ? 'active' : '' }}"
                        href="{{ route('store.manage_orders', ['id' => $store->id]) }}" title="MANAGE ORDERS">
                        <i class="fa fa-file-text"></i><span class="nav-text">MANAGE ORDERS</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('store.product_report') ? 'active' : '' }}"
                        href="{{ route('store.product_report', ['id' => $store->id]) }}" title="PRODUCT REPORT">
                        <i class="fa fa-sticky-note"></i><span class="nav-text">PRODUCT REPORT</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('store.player_report') ? 'active' : '' }}"
                        href="{{ route('store.player_report', ['id' => $store->id]) }}" title="PLAYER REPORT">
                        <i class="fa fa-address-card"></i><span class="nav-text">PLAYER REPORT</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('store.packing_slip') ? 'active' : '' }}"
                        href="{{ route('store.packing_slip', ['id' => $store->id]) }}" title="PACKING SLIPS BUILDER">
                        <i class="fa fa-fax"></i><span class="nav-text">PACKING SLIPS BUILDER</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('store.store_shipping') ? 'active' : '' }}"
                        href="{{ route('store.store_shipping', ['id' => $store->id]) }}" title="SHIPPING">
                        <i class="fa fa-shopping-cart"></i><span class="nav-text">SHIPPING</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('store.name_not_for_printing') ? 'active' : '' }}"
                        href="{{ route('store.name_not_for_printing', ['id' => $store->id]) }}" title="NAMES NOT FOR PRINTING">
                        <i class="fa fa-address-book"></i><span class="nav-text">NAMES NOT FOR PRINTING</span>
                    </a>
                </li>

                <!-- ACCOUNTING -->
                <li class="section-title">ACCOUNTING</li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('store.accounting_report') ? 'active' : '' }}"
                        href="{{ route('store.accounting_report', ['id' => $store->id]) }}" title="ACCOUNTING REPORT">
                        <i class="fa fa-bar-chart"></i><span class="nav-text">ACCOUNTING REPORT</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('store.receipts') ? 'active' : '' }}"
                        href="{{ route('store.receipts', ['id' => $store->id]) }}" title="RECEIPTS">
                        <i class="fa fa-credit-card"></i><span class="nav-text">RECEIPTS</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('store.fundraising_report') ? 'active' : '' }}"
                        href="{{ route('store.fundraising_report', ['id' => $store->id]) }}" title="FUNDRAISING REPORT">
                        <i class="fa fa-id-card"></i><span class="nav-text">FUNDRAISING REPORT</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main content area -->
    <div class="sub-navbar-content col mt-3">
        @yield('sub-sidebar-content')
    </div>
</div>

<script>
    (function() {
        'use strict';

        var MOBILE_BP = 768;

        function isMobile() {
            return window.innerWidth < MOBILE_BP;
        }

        /* ---- Open drawer (mobile only) ---- */
        function openSidebar() {
            var sidebar = document.getElementById('sub-navbar');
            var overlay = document.getElementById('sub-navbar-overlay');
            var toggle = document.getElementById('teamstore-toggle');
            var togIcon = document.getElementById('teamstore-toggle-icon');
            var closeBtn = document.getElementById('navbar-collapse-icon');

            sidebar.classList.add('mobile-open');
            overlay.classList.add('active');

            if (toggle) {
                toggle.classList.add('sidebar-open');
                toggle.setAttribute('aria-expanded', 'true');
            }
            if (togIcon) {
                togIcon.className = 'fa fa-angle-double-left';
            }
            if (closeBtn) {
                closeBtn.className = 'fa fa-angle-double-left';
            }

            // Prevent background scrolling while drawer is open
            document.body.style.overflow = 'hidden';
        }

        /* ---- Close drawer (mobile only) ---- */
        function closeSidebar() {
            var sidebar = document.getElementById('sub-navbar');
            var overlay = document.getElementById('sub-navbar-overlay');
            var toggle = document.getElementById('teamstore-toggle');
            var togIcon = document.getElementById('teamstore-toggle-icon');
            var closeBtn = document.getElementById('navbar-collapse-icon');

            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');

            if (toggle) {
                toggle.classList.remove('sidebar-open');
                toggle.setAttribute('aria-expanded', 'false');
            }
            if (togIcon) {
                togIcon.className = 'fa fa-angle-double-right';
            }
            if (closeBtn) {
                closeBtn.className = 'fa fa-angle-double-left';
            }

            // Restore background scrolling
            document.body.style.overflow = '';
        }

        /* ---- Public toggle — called by both trigger buttons ---- */
        window.toggleSubNavbar = function() {
            if (isMobile()) {
                var sidebar = document.getElementById('sub-navbar');
                if (sidebar.classList.contains('mobile-open')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
                return;
            }

            /* Desktop: collapse/expand sidebar width */
            var sidebar = document.getElementById('sub-navbar');
            var closeBtn = document.getElementById('navbar-collapse-icon');
            var wasCollapsed = sidebar.classList.contains('collapsed');

            sidebar.classList.toggle('collapsed');

            if (closeBtn) {
                closeBtn.className = wasCollapsed ?
                    'fa fa-angle-double-left' :
                    'fa fa-angle-double-right';
            }

            /* Minimise the main left-nav when expanding sub-sidebar */
            if (wasCollapsed && typeof $ !== 'undefined') {
                var $minIcon = $('#minimize_icon');
                if ($minIcon.length && $minIcon.css('display') !== 'none') {
                    $minIcon.trigger('click');
                }
            }
        };

        /* ---- DOMContentLoaded ---- */
        document.addEventListener('DOMContentLoaded', function() {
            var sidebar = document.getElementById('sub-navbar');
            var overlay = document.getElementById('sub-navbar-overlay');

            /* Ensure a clean initial state on mobile */
            if (isMobile()) {
                sidebar.classList.remove('mobile-open', 'collapsed');
                document.body.style.overflow = '';
            }

            /* Overlay tap → close */
            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }

            /* Resize handler — debounced to prevent rapid state flipping */
            var resizeTimer = null;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    if (!isMobile()) {
                        /* Switched to desktop: strip all mobile state */
                        sidebar.classList.remove('mobile-open');
                        if (overlay) overlay.classList.remove('active');
                        document.body.style.overflow = '';

                        var toggle = document.getElementById('teamstore-toggle');
                        var togIcon = document.getElementById('teamstore-toggle-icon');
                        var closeBtn = document.getElementById('navbar-collapse-icon');
                        if (toggle) {
                            toggle.classList.remove('sidebar-open');
                            toggle.setAttribute('aria-expanded', 'false');
                        }
                        if (togIcon) {
                            togIcon.className = 'fa fa-angle-double-right';
                        }
                        if (closeBtn) {
                            closeBtn.className = 'fa fa-angle-double-left';
                        }
                    } else {
                        /* Switched to mobile: strip desktop-only .collapsed so width is correct */
                        sidebar.classList.remove('collapsed');
                        /* If sidebar is not open, make sure body scroll is restored */
                        if (!sidebar.classList.contains('mobile-open')) {
                            document.body.style.overflow = '';
                        }
                    }
                }, 150);
            });

            /* Bootstrap tooltips */
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                var tooltipEls = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipEls.forEach(function(el) {
                    new bootstrap.Tooltip(el);
                });
            }
        });

    }());
</script>