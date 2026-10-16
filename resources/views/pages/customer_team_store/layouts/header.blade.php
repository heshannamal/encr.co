@php
    $secondaryColorNav = !empty($teamStore->secondary_color)
        ? $teamStore->secondary_color
        : '#ffffff';

    $primaryColor = !empty($teamStore->primary_color)
        ? $teamStore->primary_color
        : '#47D6B6';

    $headerTextColor = !empty($teamStore->header_text_color)
        ? $teamStore->header_text_color
        : ($teamStore->theme == 1 ? '#ffffff' : '#222222');

    $visibleNavbarCategoryIds = collect($navbarCategoryIds ?? [])
        ->map(fn ($categoryId) => (int) $categoryId)
        ->all();

    $selectedCategoryId = (int) request()->query('product_category_id', 0);
    $isViewOnly = request()->query('view-only') === 'true';

    $homeUrl = makeStoreDomainRoute(
        $store->direct_access_url . ($isViewOnly ? '?view-only=true' : '')
    );

    $cartUrl = makeStoreDomainRoute('customerTeamStoreCart/' . $store->id);
@endphp

<style>
    /*
    |--------------------------------------------------------------------------
    | Modern Team Store Header
    |--------------------------------------------------------------------------
    | Desktop and mobile category navigation are separate.
    | Mobile navigation does NOT use Bootstrap collapse.
    */

    .top-navbar {
        overflow: visible !important;
    }

    .team-store-header {
        --store-header-bg: {{ $secondaryColorNav }};
        --store-header-text: {{ $headerTextColor }};
        --store-primary: {{ $primaryColor }};

        position: relative;
        z-index: 1200;
        width: 100%;
        background: var(--store-header-bg);
        color: var(--store-header-text);
        border-bottom: 1px solid rgba(0, 0, 0, .08);
        box-shadow: 0 4px 18px rgba(0, 0, 0, .06);
        overflow: visible !important;
    }

    .team-store-header * {
        box-sizing: border-box;
    }

    .team-store-header-bar {
        width: 100%;
        min-height: 72px;
        padding: 10px 4%;
        display: flex;
        align-items: center;
        gap: 22px;
    }

    /* LOGO */
    .team-store-brand {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        min-width: 150px;
    }

    .team-store-brand-link {
        display: inline-flex;
        align-items: center;
        text-decoration: none !important;
    }

    .team-store-brand-logo {
        display: block;
        width: auto;
        height: 48px;
        max-width: 190px;
        object-fit: contain;
    }

    /* DESKTOP NAV */
    .team-store-desktop-nav {
        flex: 1 1 auto;
        min-width: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .team-store-desktop-list {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        margin: 0;
        padding: 0;
        list-style: none;
        flex-wrap: wrap;
    }

    .team-store-category-link {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 38px;
        padding: 8px 12px;
        border-radius: 9px;
        color: var(--store-header-text) !important;
        font-size: 14px;
        font-weight: 600;
        line-height: 1.2;
        text-decoration: none !important;
        white-space: nowrap;
        transition:
            background-color .16s ease,
            opacity .16s ease,
            transform .16s ease;
    }

    .team-store-category-link:hover,
    .team-store-category-link:focus {
        color: var(--store-header-text) !important;
        text-decoration: none !important;
        background: rgba(127, 127, 127, .13);
        opacity: .9;
    }

    .team-store-category-link.active-category {
        background: rgba(127, 127, 127, .18);
        font-weight: 700;
    }

    .team-store-category-link.active-category::after {
        content: "";
        position: absolute;
        left: 12px;
        right: 12px;
        bottom: 3px;
        height: 2px;
        border-radius: 2px;
        background: var(--store-primary);
    }

    /* RIGHT ACTIONS */
    .team-store-actions {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
        position: relative;
    }

    .team-store-icon-button {
        width: 42px;
        height: 42px;
        border: 1px solid rgba(127, 127, 127, .18);
        border-radius: 11px;
        background: rgba(255, 255, 255, .22);
        color: var(--store-header-text);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        text-decoration: none !important;
        transition: background-color .16s ease, transform .16s ease;
        padding: 0;
    }

    .team-store-icon-button:hover,
    .team-store-icon-button:focus {
        background: rgba(127, 127, 127, .13);
        text-decoration: none !important;
    }

    .team-store-icon-button img {
        width: 24px;
        height: 24px;
        object-fit: contain;
    }

    .team-store-cart-button {
        width: auto;
        min-width: 116px;
        padding: 0 13px;
        gap: 7px;
    }

    .team-store-cart-label {
        color: var(--store-header-text) !important;
        font-size: 14px;
        font-weight: 700;
        white-space: nowrap;
    }

    /* MOBILE HAMBURGER */
    .team-store-mobile-toggle {
        display: none;
        width: 44px;
        height: 42px;
        border: 1px solid rgba(0, 0, 0, .15);
        border-radius: 11px;
        background: #ffffff !important;
        padding: 0;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 4px;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .12);
        flex: 0 0 44px;
    }

    .team-store-mobile-toggle span {
        display: block;
        width: 21px;
        height: 2.5px;
        border-radius: 10px;
        background: #111111 !important;
        transition: transform .18s ease, opacity .18s ease;
    }

    .team-store-mobile-toggle.is-open span:nth-child(1) {
        transform: translateY(6.5px) rotate(45deg);
    }

    .team-store-mobile-toggle.is-open span:nth-child(2) {
        opacity: 0;
    }

    .team-store-mobile-toggle.is-open span:nth-child(3) {
        transform: translateY(-6.5px) rotate(-45deg);
    }

    /* MOBILE MENU - SEPARATE FROM DESKTOP NAV */
    .team-store-mobile-menu {
        display: none;
    }

    /* CART DROPDOWN */
    .team-store-cart-dropdown {
        display: none;
        position: absolute;
        top: calc(100% + 12px);
        right: 0;
        width: 320px;
        max-width: calc(100vw - 24px);
        max-height: 460px;
        overflow-y: auto;
        background: {{ $teamStore->theme == 1 ? '#262626' : '#ffffff' }};
        color: {{ $teamStore->theme == 1 ? '#ffffff' : '#222222' }};
        border: 1px solid rgba(127, 127, 127, .16);
        border-radius: 14px;
        box-shadow: 0 16px 40px rgba(0, 0, 0, .18);
        padding: 16px;
        z-index: 1300;
    }

    .team-store-cart-dropdown.is-open {
        display: block !important;
    }

    .team-store-cart-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 12px;
    }

    .team-store-cart-title strong {
        font-size: 15px;
    }

    .team-store-cart-count-badge {
        min-width: 26px;
        height: 26px;
        padding: 0 8px;
        border-radius: 999px;
        background: var(--store-primary);
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
    }

    .team-store-cart-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 0;
        border-bottom: 1px solid rgba(127, 127, 127, .14);
    }

    .team-store-cart-item:last-child {
        border-bottom: none;
    }

    .team-store-cart-image {
        width: 52px;
        height: 52px;
        border-radius: 8px;
        object-fit: cover;
        flex: 0 0 52px;
    }

    .team-store-cart-info {
        min-width: 0;
        flex: 1 1 auto;
    }

    .team-store-cart-name {
        display: block;
        font-size: 13px;
        font-weight: 600;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .team-store-cart-meta {
        margin-top: 3px;
        font-size: 12px;
        color: #808080;
    }

    .team-store-cart-delete {
        flex: 0 0 30px;
        width: 30px;
        height: 30px;
        border: 0;
        border-radius: 8px;
        background: transparent;
        color: #999999;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .team-store-cart-delete:hover {
        background: rgba(220, 53, 69, .10);
        color: #dc3545;
    }

    .team-store-cart-summary {
        padding-top: 13px;
        margin-top: 8px;
        border-top: 1px solid rgba(127, 127, 127, .15);
    }

    .team-store-cart-subtotal-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .team-store-cart-tax-note {
        margin: 0 0 12px;
        color: #888888;
        font-size: 12px;
    }

    .team-store-cart-link {
        display: flex;
        width: 100%;
        min-height: 42px;
        align-items: center;
        justify-content: center;
        padding: 10px 14px;
        border-radius: 9px;
        border: 0;
        background: var(--store-primary);
        color: #ffffff !important;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none !important;
    }

    .team-store-cart-link:hover {
        color: #ffffff !important;
        text-decoration: none !important;
        opacity: .92;
    }

    /* LOADER */
    .se-pre-con {
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif")
                    center no-repeat #ffffff99;
        display: none;
    }

    /* CLOSED STORE NOTICE */
    .team-store-closed-notice {
        width: 100%;
        margin: 0;
        border-radius: 0;
        text-align: center;
        font-size: 13px;
    }

    /*
    |--------------------------------------------------------------------------
    | TABLET / MOBILE
    |--------------------------------------------------------------------------
    */
    @media (max-width: 991.98px) {
        .team-store-header-bar {
            min-height: 66px;
            padding: 8px 14px;
            gap: 8px;
        }

        .team-store-brand {
            min-width: 0;
            flex: 1 1 auto;
        }

        .team-store-brand-logo {
            height: 43px;
            max-width: 150px;
        }

        .team-store-desktop-nav {
            display: none !important;
        }

        .team-store-mobile-toggle {
            display: inline-flex !important;
            order: 2;
        }

        .team-store-actions {
            order: 3;
            gap: 5px;
        }

        .team-store-cart-button {
            min-width: 42px;
            width: 42px;
            padding: 0;
        }

        .team-store-cart-label {
            display: none;
        }

        /*
         * IMPORTANT:
         * This is its own mobile menu.
         * There is no Bootstrap .collapse / .navbar-collapse here.
         */
        .team-store-mobile-menu {
            display: none !important;
            position: absolute !important;
            top: 100% !important;
            left: 10px !important;
            right: 10px !important;
            width: auto !important;
            padding: 8px !important;
            background: #ffffff !important;
            color: #111111 !important;
            border: 1px solid rgba(0, 0, 0, .10);
            border-radius: 0 0 14px 14px;
            box-shadow: 0 14px 32px rgba(0, 0, 0, .20);
            z-index: 1250 !important;
            max-height: 70vh;
            overflow-y: auto;
        }

        .team-store-mobile-menu.is-open {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        .team-store-mobile-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .team-store-mobile-item + .team-store-mobile-item {
            border-top: 1px solid #eeeeee;
        }

        .team-store-mobile-link {
            display: flex;
            width: 100%;
            min-height: 46px;
            align-items: center;
            padding: 11px 13px;
            border-radius: 8px;
            color: #111111 !important;
            background: transparent !important;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none !important;
        }

        .team-store-mobile-link:hover,
        .team-store-mobile-link:focus {
            background: #f4f5f7 !important;
            color: #111111 !important;
            text-decoration: none !important;
        }

        .team-store-mobile-link.active-category {
            background: #eef0f2 !important;
            color: #111111 !important;
            font-weight: 700;
            box-shadow: inset 3px 0 0 var(--store-primary);
        }

        .team-store-cart-dropdown {
            position: fixed;
            top: 72px;
            right: 12px;
            left: auto;
            width: min(340px, calc(100vw - 24px));
            max-height: calc(100vh - 92px);
        }
    }

    @media (max-width: 575.98px) {
        .team-store-header-bar {
            padding: 7px 10px;
        }

        .team-store-brand-logo {
            height: 39px;
            max-width: 125px;
        }

        .team-store-mobile-toggle,
        .team-store-icon-button {
            width: 40px;
            height: 40px;
            flex-basis: 40px;
            border-radius: 10px;
        }

        .team-store-icon-button img {
            width: 22px;
            height: 22px;
        }

        .team-store-mobile-menu {
            left: 7px !important;
            right: 7px !important;
        }
    }

    /* =========================================================
    Team Store Header - Mobile Layout
    ========================================================= */

    @media (max-width: 767.98px) {

        .team-store-header-bar {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 60px;
            padding: 15px 20px;
        }

        /* -----------------------------------------
        Mobile Hamburger - LEFT
        ----------------------------------------- */

        .team-store-mobile-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            width: 40px;
            height: 40px;
            padding: 0;
            margin: 0;
            border: 0;
            background: transparent !important;
            flex-shrink: 0;
            z-index: 2;
            box-shadow: unset !important;
        }

        .team-store-mobile-toggle span {
            display: block;
            width: 22px;
            height: 2px;
            margin: 3px 0;
            background: currentColor;
            border-radius: 2px;
        }


        /* -----------------------------------------
        Logo - CENTER
        ----------------------------------------- */

        .team-store-brand {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            z-index: 1;
        }

        .team-store-brand-link {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .team-store-brand-logo {
            display: block;
            max-width: 140px;
            width: auto;
            height: auto;
            max-height: 42px;
            object-fit: contain;
        }


        /* -----------------------------------------
        Header Actions / Cart - RIGHT
        ----------------------------------------- */

        .team-store-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-left: auto;
            flex-shrink: 0;
            z-index: 2;
        }

        .team-store-cart-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            padding: 0;
            margin: 0;
        }

        .team-store-cart-button i {
            font-size: 20px;
        }

        /* Hide "My cart (0)" on mobile */
        .team-store-cart-button .cart_text {
            display: none;
        }


        /* -----------------------------------------
        Desktop Navigation - Hide on Mobile
        ----------------------------------------- */

        .team-store-desktop-nav {
            display: none;
        }


        /* -----------------------------------------
        Mobile Menu
        ----------------------------------------- */

        .team-store-mobile-menu {
            display: none;
        }

        .team-store-mobile-menu.active {
            display: block;
        }
        .store-light-theme {
            background-color: rgb(237, 237, 237) !important;
        }
    }


    /* =========================================================
    Small Mobile Screens
    ========================================================= */

    @media (max-width: 380px) {

        .team-store-header-bar {
            min-height: 55px;
            padding-left: 10px;
            padding-right: 10px;
        }

        .team-store-brand-logo {
            max-width: 115px;
            max-height: 36px;
        }

        .team-store-mobile-toggle,
        .team-store-cart-button {
            width: 36px;
            height: 36px;
        }

        .team-store-cart-button i {
            font-size: 18px;
        }
    }

@media (max-width: 767.98px) {

    /* Hide "My cart (0)" text */
    .team-store-cart-button .cart_text {
        display: none !important;
    }

    .team-store-cart-button {
        position: relative !important;
    }

    /* Red cart quantity badge */
    .team-store-mobile-cart-count {
        position: absolute;
        top: 25px;
        right: -9px;

        min-width: 17px;
        height: 17px;
        padding: 0 4px;

        display: flex !important;
        align-items: center;
        justify-content: center;

        background: #e53935 !important;
        color: #fff !important;

        border-radius: 50%;
        border: 2px solid #fff;

        font-size: 9px !important;
        font-weight: 700;
        line-height: 1;
        white-space: nowrap;

        z-index: 10;
    }
}

</style>

@if ($store->store_status != 1 && $isSessionAvailable)
    <div class="alert alert-warning team-store-closed-notice" role="alert">
        🚫 This store is currently closed. View only.
    </div>
@endif

<header
    class="team-store-header"
    id="team-store-header"
>
    <div class="team-store-header-bar">

        {{-- Logo --}}
        <div class="team-store-brand">
            <a href="{{ $homeUrl }}" class="team-store-brand-link">
                <img
                    src="{{ asset($teamStore->primary_logo ?: 'assets/img/teamStore/logo_dark.png') }}"
                    onerror="this.onerror=null; this.src='{{ asset('assets/img/teamStore/logo_dark.png') }}';"
                    alt="{{ $store->store_name }}"
                    class="team-store-brand-logo">
            </a>
        </div>

        {{-- Desktop category navigation --}}
        <nav class="team-store-desktop-nav" aria-label="Store categories">
            <ul class="team-store-desktop-list">
                @foreach ($storeProductCategories as $storeProductCategory)
                    @php
                        $categoryId = (int) $storeProductCategory->id;

                        $categoryIsVisible = empty($visibleNavbarCategoryIds)
                            || in_array($categoryId, $visibleNavbarCategoryIds, true);

                        $categoryUrl = makeStoreDomainRoute(
                            'storeProductCategoryWise'
                            . '?product_category_id=' . $categoryId
                            . '&store_id=' . $store->id
                            . ($isViewOnly ? '&view-only=true' : '')
                        );
                    @endphp

                    @if ($categoryIsVisible)
                        <li>
                            <a
                                href="{{ $categoryUrl }}"
                                class="team-store-category-link {{ $selectedCategoryId === $categoryId ? 'active-category' : '' }}"
                                data-product-category-id="{{ $categoryId }}"
                                data-category-store-id="{{ $store->id }}">
                                {{ $storeProductCategory->category_name }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </nav>

        {{-- Mobile hamburger --}}
        <button
            type="button"
            class="team-store-mobile-toggle"
            id="team-store-mobile-toggle"
            aria-controls="team-store-mobile-menu"
            aria-expanded="false"
            aria-label="Open category menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        {{-- Header actions --}}
        <div class="team-store-actions">

            <button
                type="button"
                class="team-store-icon-button team-store-cart-button"
                id="cart-link"
                aria-expanded="false"
                aria-controls="cart-content"
                aria-label="Open cart">

                <i class="fas fa-shopping-cart"></i>

                <span class="team-store-cart-label cart_text">
                    My cart (0)
                </span>

                <span class="team-store-mobile-cart-count" id="team-store-mobile-cart-count">
                    0
                </span>
            </button>

            {{-- Cart dropdown --}}
            <div
                id="cart-content"
                class="team-store-cart-dropdown"
                aria-label="Shopping cart">

                <div class="team-store-cart-title">
                    <strong>My Cart</strong>
                    <span
                        class="team-store-cart-count-badge"
                        id="team-store-cart-count-badge">
                        0
                    </span>
                </div>

                <div id="cart-items-container" style="max-height: 240px;overflow: hidden;overflow-y: scroll;"></div>

                <div class="team-store-cart-summary">
                    <div class="team-store-cart-subtotal-row">
                        <span>Subtotal</span>
                        <span class="cart-subtotal">$0.00</span>
                    </div>

                    <p class="team-store-cart-tax-note">
                        Taxes will be included in the total.
                    </p>

                    @if (!$isViewOnly)
                        <a
                            href="{{ $cartUrl }}"
                            class="team-store-cart-link go_to_cart"
                            id="go-to-cart-btn">
                            Go To Cart (0)
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Separate mobile category menu --}}
    <nav
        class="team-store-mobile-menu"
        id="team-store-mobile-menu"
        aria-label="Mobile store categories">

        <ul class="team-store-mobile-list">
            @foreach ($storeProductCategories as $storeProductCategory)
                @php
                    $categoryId = (int) $storeProductCategory->id;

                    $categoryIsVisible = empty($visibleNavbarCategoryIds)
                        || in_array($categoryId, $visibleNavbarCategoryIds, true);

                    $categoryUrl = makeStoreDomainRoute(
                        'storeProductCategoryWise'
                        . '?product_category_id=' . $categoryId
                        . '&store_id=' . $store->id
                        . ($isViewOnly ? '&view-only=true' : '')
                    );
                @endphp

                @if ($categoryIsVisible)
                    <li class="team-store-mobile-item">
                        <a
                            href="{{ $categoryUrl }}"
                            class="team-store-mobile-link {{ $selectedCategoryId === $categoryId ? 'active-category' : '' }}"
                            data-product-category-id="{{ $categoryId }}"
                            data-category-store-id="{{ $store->id }}">
                            {{ $storeProductCategory->category_name }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </nav>
</header>

<div class="se-pre-con"></div>

<input
    type="hidden"
    value="{{ $store->id }}"
    name="store_id"
    id="store-id-primary">

<script>
    /*
    |--------------------------------------------------------------------------
    | Mobile category menu
    |--------------------------------------------------------------------------
    | Plain JavaScript only. No Bootstrap collapse dependency.
    */
    (function () {
        const toggle = document.getElementById('team-store-mobile-toggle');
        const menu = document.getElementById('team-store-mobile-menu');
        const header = document.getElementById('team-store-header');

        if (!toggle || !menu || !header) {
            return;
        }

        function isMobile() {
            return window.innerWidth <= 991.98;
        }

        function openMobileMenu() {
            if (!isMobile()) {
                return;
            }

            menu.classList.add('is-open');
            menu.style.setProperty('display', 'block', 'important');

            toggle.classList.add('is-open');
            toggle.setAttribute('aria-expanded', 'true');
            toggle.setAttribute('aria-label', 'Close category menu');
        }

        function closeMobileMenu() {
            menu.classList.remove('is-open');
            menu.style.removeProperty('display');

            toggle.classList.remove('is-open');
            toggle.setAttribute('aria-expanded', 'false');
            toggle.setAttribute('aria-label', 'Open category menu');
        }

        toggle.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            if (menu.classList.contains('is-open')) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });

        menu.addEventListener('click', function (event) {
            event.stopPropagation();
        });

        header.addEventListener('click', function (event) {
            if (
                isMobile()
                && !menu.contains(event.target)
                && !toggle.contains(event.target)
            ) {
                closeMobileMenu();
            }
        });

        document.addEventListener('click', function () {
            if (isMobile()) {
                closeMobileMenu();
            }
        });

        menu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', closeMobileMenu);
        });

        window.addEventListener('resize', function () {
            closeMobileMenu();
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeMobileMenu();
            }
        });
    })();

    /*
    |--------------------------------------------------------------------------
    | Cart dropdown
    |--------------------------------------------------------------------------
    */
    (function () {
        const cartButton = document.getElementById('cart-link');
        const cartContent = document.getElementById('cart-content');

        if (!cartButton || !cartContent) {
            return;
        }

        function closeCart() {
            cartContent.classList.remove('is-open');
            cartButton.setAttribute('aria-expanded', 'false');
        }

        function openCart() {
            cartContent.classList.add('is-open');
            cartButton.setAttribute('aria-expanded', 'true');
        }

        cartButton.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            if (cartContent.classList.contains('is-open')) {
                closeCart();
            } else {
                openCart();
            }
        });

        /*
         * Keep cart clicks available for delegated cart-item actions.
         *
         * Previously every click inside #cart-content called stopPropagation().
         * That prevented the dynamically-rendered delete button from reaching
         * its document-level delegated click handler.
         *
         * Instead, close the cart only when the click is actually outside the
         * cart button and the cart dropdown.
         */
        document.addEventListener('click', function (event) {
            if (
                !cartContent.contains(event.target)
                && !cartButton.contains(event.target)
            ) {
                closeCart();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeCart();
            }
        });
    })();

    /*
    |--------------------------------------------------------------------------
    | Cart AJAX
    |--------------------------------------------------------------------------
    */
    $(function () {
        updateCart();
    });

    /*
     * Cart items are created dynamically by displayCartItems().
     *
     * Delegate the delete event from #cart-content itself so the dynamically
     * generated buttons always work and do not depend on the click reaching
     * document.
     */
    $('#cart-content')
        .off('click.teamStoreCartDelete', '.team-store-cart-delete')
        .on(
            'click.teamStoreCartDelete',
            '.team-store-cart-delete',
            function (event) {
                event.preventDefault();
                event.stopPropagation();

                const $button = $(this);
                const productId = $button.attr('data-product-id');
                const cartItemId = $button.attr('data-cart-item-id');
                const storeId = $('#store-id-primary').val();

                if (!cartItemId) {
                    console.error(
                        'Cart delete failed: cart item id is missing.',
                        {
                            productId: productId,
                            storeId: storeId
                        }
                    );

                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        title: 'Unable to remove this cart item.',
                        showConfirmButton: false,
                        timer: 2200,
                        toast: true
                    });

                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This product will be removed from your cart!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (!result.isConfirmed) {
                        return;
                    }

                    $.ajax({
                        url: "{{ makeStoreDomainRoute('cartDeleteStore') }}",
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            product_id: productId,
                            store_id: storeId,
                            cartItemId: cartItemId,
                            _token: '{{ csrf_token() }}'
                        },
                        beforeSend: function () {
                            $button.prop('disabled', true);
                            $('.se-pre-con').fadeIn('slow');
                        },
                        success: function (response) {
                            if (
                                response
                                && response.success === false
                            ) {
                                Swal.fire({
                                    position: 'top',
                                    icon: 'error',
                                    title: response.message
                                        || 'Failed to remove product!',
                                    showConfirmButton: false,
                                    timer: 2200,
                                    toast: true
                                });

                                return;
                            }

                            updateCart();

                            Swal.fire({
                                position: 'top',
                                icon: 'success',
                                title: 'Product removed from cart!',
                                showConfirmButton: false,
                                timer: 2000,
                                toast: true
                            });
                        },
                        error: function (xhr) {
                            console.error(
                                'Cart delete request failed.',
                                xhr.responseJSON
                                    || xhr.responseText
                                    || xhr
                            );

                            Swal.fire({
                                position: 'top',
                                icon: 'error',
                                title:
                                    xhr.responseJSON?.message
                                    || xhr.responseJSON?.error
                                    || 'Failed to remove product!',
                                showConfirmButton: false,
                                timer: 2500,
                                toast: true
                            });
                        },
                        complete: function () {
                            $button.prop('disabled', false);
                            $('.se-pre-con').fadeOut('slow');
                        }
                    });
                });
            }
        );

    function updateCart() {
        $.ajax({
            url: "{{ makeStoreDomainRoute('get_cart_items') }}",
            method: 'GET',
            data: {
                store_id: $('#store-id-primary').val(),
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function () {
                $('.se-pre-con').fadeIn('slow');
            },
            success: function (data) {
                displayCartItems(data);
            },
            error: function (error) {
                console.error('Error fetching cart data:', error);
            },
            complete: function () {
                $('.se-pre-con').fadeOut('slow');
            }
        });
    }

    function escapeTeamStoreHtml(value) {
        return $('<div>').text(value ?? '').html();
    }

    function displayCartItems(cartItems) {
        const $container = $('#cart-items-container');

        let subtotal = 0;
        let cartCount = 0;

        $container.empty();

        if (Array.isArray(cartItems) && cartItems.length > 0) {
            $.each(cartItems, function (index, item) {
                if (!item.store_product) {
                    return;
                }

                const product = item.store_product;
                const qty = parseInt(item.qty || 0, 10);
                const images = Array.isArray(product.images)
                    ? product.images
                    : [];

                const imageUrl = images.length > 0
                    ? `{{ rtrim(asset(''), '/') }}/${images[0].url}`
                    : `{{ asset('assets/img/products/default-loading.gif') }}`;

                const productName = product.product_name || 'Unknown Product';

                const additions = Array.isArray(product.price_additions)
                    ? product.price_additions.reduce(
                        (sum, addition) =>
                            sum + parseFloat(addition.addition_amount || 0),
                        0
                    )
                    : 0;

                const unitPrice =
                    parseFloat(product.default_price || 0) + additions;

                const itemTotal = unitPrice * qty;

                cartCount += qty;
                subtotal += itemTotal;

                const itemHtml = `
                    <div class="team-store-cart-item">
                        <img
                            src="${imageUrl}"
                            alt="${escapeTeamStoreHtml(productName)}"
                            class="team-store-cart-image">

                        <div class="team-store-cart-info">
                            <span class="team-store-cart-name">
                                ${escapeTeamStoreHtml(productName)}
                            </span>

                            <div class="team-store-cart-meta">
                                ${qty} item${qty === 1 ? '' : 's'}
                                &nbsp;•&nbsp;
                                $${itemTotal.toFixed(2)}
                            </div>
                        </div>

                        <button
                            type="button"
                            class="team-store-cart-delete"
                            data-cart-item-id="${item.id}"
                            data-product-id="${product.id || ''}"
                            aria-label="Remove ${escapeTeamStoreHtml(productName)}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;

                $container.append(itemHtml);
            });
        } else {
            $container.html(
                '<p style="margin:8px 0 14px; color:#888; font-size:13px;">Your cart is empty.</p>'
            );
        }

        $('.cart-subtotal').text(`$${subtotal.toFixed(2)}`);
        $('.cart_text').text(`My cart (${cartCount})`);
        $('.go_to_cart').text(`Go To Cart (${cartCount})`);
        $('#team-store-cart-count-badge').text(cartCount);

        $('#team-store-mobile-cart-count').text(cartCount);
    }
</script>
