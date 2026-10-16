@extends('pages.customer_portal.layouts.app_new')

@section('content')
<style>
   .sidebar-wrapper {

    height: 100vh;
}
.sidebar-nav {
    overflow-y: auto;
    padding-bottom: 100px; /* so scroll doesn’t hide bottom card */
}



.sidebar-bottom-card {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 10px;
}

/* Make sure the main content area fills the viewport minus header/footer */
.main-content {
    min-height: calc(100vh - 70px - 40px); /* adjust 70px = header height, 40px = footer height */
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}

/* Optional: ensure footer spacing when content is small */
#order_details_tab, #order_shipping_details_tab {
    flex-grow: 1;
}
    .catalog_div {
        background-size: cover;
        background-position: center;
        min-height: 100%;
        border-radius: 8px;
        box-shadow: 0px 4px 10px 0px #00000026;
        padding: 40px;
        display: flex; flex-direction: column; justify-content: space-between;
    }
    .catalog_topic {
        text-align: center;
        font-size: 25px;
        color: white;
        font-weight: 600;
    }
    .catalog_text {
        text-align: center;
        font-size: 10px;
        color: white;
    }
    .catalog_btn {
        padding: 5px 9px;
        background-color: #47D6B6;
        border: unset;
        border-radius: 8px;
        color: white;
    }
    .legend {
        margin-top: 15px;
    }

    .legend span {
        margin-right: 20px;
        font-weight: 500;
    }

    .legend-box {
        display: inline-block;
        width: 12px;
        height: 12px;
        margin-right: 6px;
        vertical-align: middle;
        border-radius: 2px;
    }

    .legend-box.paid {
        background-color: #4CAF50;
    }

    .legend-box.unpaid {
        background-color: #FFC107;
    }
    .hero {
    position: relative;
    height: 50vh;
    overflow: hidden;
    text-align: center;
    background-color: var(--bs-semi-body-bg);;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    padding-left: unset !important;
    padding-right: unset !important;
}

/* TITLE */
.title {
    padding-top: 5px;
    padding-bottom: 5px;
    color: #fefeff;
    font-size: clamp(11px, 4vw, 15px);
    font-weight: bold;
    position: relative;
    z-index: 10;
    background-color: var(--bs-semi-body-bg);;
    width: 100%;
    text-transform: uppercase;
    font-weight: 800;
    border-top: 2px solid #a1a1a1;
    border-bottom: 2px solid #a1a1a1;
}

/* MAIN PRODUCT (FRONT) */
.main-product {
    position: relative;
    z-index: 20; /* FRONT */
    margin: 30px 0 10px;
}

.main-product img {
    width: clamp(120px, 5vw, 130px);
    transform-style: preserve-3d;
}

/* BACKGROUND COLUMNS */
.columns {
    position: absolute;
    left: 0;
    width: 100%;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
    padding: 0 20px;
    z-index: 5; /* BACKGROUND */
    pointer-events: none;
}

/* COLUMN */
.column {
    display: flex;
    flex-direction: column;
    gap: 18px;
    opacity: 0.78;
}

.column img {
    width: 100%;
    border-radius: 16px;
    background: #ffffff;
}

/* CTA */
.cta {
    position: relative;
    z-index: 21;
    margin-top: 20px;
    margin-bottom: 20px;
    background: var(--bs-btn-bg);
    color: white;
    border: none;
    padding: 7px 16px;
    font-size: 10px;
    border-radius: 40px;
    cursor: pointer;
    width: fit-content;
}
.sidebar-close {
    display: none !important;
}
.mobile-header-logo {
    display: none;
}

@media (max-width: 768px) {

    /* =========================================
       MOBILE TOP HEADER
    ========================================= */

    .top-header {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 80px !important;
        background: #202529 !important;
        z-index: 10000 !important;
    }

    .top-header .navbar {
        position: relative !important;
        height: 80px !important;
        padding: 0 10px !important;

        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
    }


    /* =========================================
       TOGGLE BUTTON - LEFT
    ========================================= */

    .top-header .btn-toggle {
        width: 45px !important;
        height: 45px !important;

        display: flex !important;
        align-items: center !important;
        justify-content: center !important;

        flex-shrink: 0 !important;
        z-index: 10002 !important;
    }

    .top-header .btn-toggle a {
        width: 45px !important;
        height: 45px !important;

        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .top-header .btn-toggle i {
        color: #fff !important;
        font-size: 30px !important;
    }


    /* =========================================
       YOUR EXISTING SIDEBAR LOGO
       SHOW IT IN MOBILE HEADER
    ========================================= */

    /* =========================================
    MOBILE LOGO - ALWAYS VISIBLE
    ========================================= */


    .sidebar-wrapper .sidebar-header .logo-img-name {
        display: block !important;

        width: 170px !important;
        max-width: 42vw !important;
        height: auto !important;
    }

    .sidebar-wrapper .sidebar-header .logo-img-name {
        width: 170px !important;
        max-width: 42vw !important;
        height: auto !important;
    }


    /* =========================================
       PROFILE - RIGHT
    ========================================= */

    .top-header .nav-right-links {
        margin-left: auto !important;

        display: flex !important;
        align-items: center !important;
        justify-content: center !important;

        flex-shrink: 0 !important;

        z-index: 10002 !important;
    }

    .top-header .nav-right-links img {
        width: 35px !important;
        height: 35px !important;
        object-fit: cover !important;
    }


    /* =========================================
       SIDEBAR
    ========================================= */

    .sidebar-wrapper {
        position: fixed !important;

        top: 0 !important;
        left: -100vw !important;

        width: 100vw !important;
        height: 100vh !important;

        z-index: 20000 !important;

        background: #202529 !important;

        transition: left 0.3s ease-in-out !important;

        overflow-y: auto !important;

        visibility: hidden !important;
    }

    body.toggled .sidebar-wrapper {
        left: 0 !important;
        visibility: visible !important;
    }


    /* =========================================
       HIDE LOGO INSIDE OPEN SIDEBAR
    ========================================= */

    .sidebar-wrapper .sidebar-header .logo-icon {
        display: none !important;
    }


    /* =========================================
       CLOSE BUTTON
    ========================================= */

    .sidebar-wrapper .sidebar-close {
        display: flex !important;

        position: absolute !important;

        top: 12px !important;
        right: 15px !important;

        width: 45px !important;
        height: 45px !important;

        /* justify-content: right !important; */
        /* z-index: 20005 !important; */
        /* left: 15px; */
        /* text-align: right; */
        align-items: right !important;
    }

    .sidebar-wrapper .sidebar-close span {
        color: #fff !important;
        font-size: 32px !important;
    }
    .sidebar-wrapper .sidebar-header {
        width: 100% !important;
    }

    /* =========================================
       HIDE CATALOG
    ========================================= */

    .sidebar-wrapper .sidebar-bottom-card {
        display: none !important;
    }


    /* =========================================
       TITLE
    ========================================= */

    .top-header > .navbar > .flex-grow-1 {
        position: absolute !important;

        top: 80px !important;
        left: 0 !important;

        width: 100% !important;

        background: #e5e5e5 !important;

        padding: 8px 5px !important;

        z-index: 9990 !important;
    }

    .top-header .heaader_bar_name {
        color: #40536a !important;
        font-size: 11px !important;
        line-height: 16px !important;
        margin: 0 !important;
    }


    /* =========================================
       MAIN CONTENT
    ========================================= */

    .main-wrapper {
        margin-left: 0 !important;
        width: 100% !important;
        background-color: #F2F3F5;
    }

    .main-content {
        padding-top: 60px !important;
        width: 100% !important;
    }
    .top-header .navbar {
        background-color: transparent !important;
    }

    .mobile-header-logo {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;

        position: absolute !important;
        left: 50% !important;
        top: 0 !important;

        transform: translateX(-50%) !important;

        width: 170px !important;
        height: 80px !important;

        z-index: 10001 !important;

        pointer-events: none !important;
    }

    .mobile-header-logo img {
        display: block !important;
        width: 170px !important;
        max-width: 42vw !important;
        height: auto !important;
    }
    .top-header .navbar {
        position: relative !important;
        height: 80px !important;
        padding: 0 10px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
    }
    .sidebar-wrapper .sidebar-header .logo-name {
        display: flex !important;
        position: fixed !important;
        top: 0 !important;
        left: 50% !important;
        transform: translateX(-50%) !important;

        width: auto !important;
        height: 80px !important;

        align-items: center !important;
        justify-content: center !important;

        padding: 0 !important;
        margin: 0 !important;

        z-index: 30000 !important;
        pointer-events: none !important;
    }
}

@media (max-width: 768px) {

    /* =====================================================
       1. BREADCRUMB
    ===================================================== */

    .page-breadcrumb {
        display: flex !important;
        width: 100% !important;
        margin-bottom: 12px !important;
        align-items: center !important;
        overflow: hidden !important;
    }

    .page-breadcrumb .breadcrumb-title {
        padding-right: 8px !important;
        font-size: 12px !important;
        white-space: nowrap !important;
    }

    .page-breadcrumb .ps-3 {
        padding-left: 8px !important;
        min-width: 0 !important;
    }

    .page-breadcrumb .breadcrumb {
        font-size: 12px !important;
        white-space: nowrap !important;
    }

}

</style>

<!--start header-->
  <header class="top-header">
    <nav class="navbar navbar-expand align-items-center gap-4">
      <div class="btn-toggle">
        <a href="javascript:;"><i class="material-icons-outlined">menu</i></a>
      </div>

        <!-- MOBILE LOGO -->
        <div class="mobile-header-logo">
            <img src="{{ asset('assets/customer_portal/assets/images/logo.png') }}"
                alt="Logo">
        </div>

      <div class=" flex-grow-1 " >
        <div class="d-flex gap-1 flex-wrap justify-content-center">
          <h5 class="heaader_bar_name">Encore-Customer Portal |</h5>
          <h5 class="heaader_bar_name">{{ session()->has('customer_portal_org_name') && !empty(session('customer_portal_org_name')[0])
                    ? session('customer_portal_org_name')[0]
                    : 'Welcome !' }}</h5>
        </div>
      </div>
      <ul class="navbar-nav gap-1 nav-right-links align-items-center" style="margin-left: auto">
        {{-- <li class="nav-item d-lg-none mobile-search-btn">
          <a class="nav-link" href="javascript:;"><i class="material-icons-outlined">search</i></a>
        </li> --}}

        <li class="nav-item dropdown search-content" style="display:none">
          <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" data-bs-auto-close="outside"
            data-bs-toggle="dropdown" href="javascript:;"><i class="material-icons-outlined">notifications</i>
            <span class="badge-notify">0</span>
          </a>
          <div class="dropdown-menu dropdown-notify dropdown-menu-end shadow">
            <div class="px-3 py-1 d-flex align-items-center justify-content-between border-bottom">
              <h5 class="notiy-title mb-0">Notifications</h5>
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret option" type="button"
                  data-bs-toggle="dropdown" aria-expanded="false">
                  <span class="material-icons-outlined">
                    more_vert
                  </span>
                </button>
                <div class="dropdown-menu dropdown-option dropdown-menu-end shadow">
                  <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                        class="material-icons-outlined fs-6">inventory_2</i>Archive All</a></div>
                  <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                        class="material-icons-outlined fs-6">done_all</i>Mark all as read</a></div>
                  <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                        class="material-icons-outlined fs-6">mic_off</i>Disable Notifications</a></div>
                  <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                        class="material-icons-outlined fs-6">grade</i>What's new ?</a></div>
                  <div>
                    <hr class="dropdown-divider">
                  </div>
                  <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                        class="material-icons-outlined fs-6">leaderboard</i>Reports</a></div>
                </div>
              </div>
            </div>
            <div class="notify-list">
              {{-- <div>
                <a class="dropdown-item border-bottom py-2" href="javascript:;">
                  <div class="d-flex align-items-center gap-3">
                    <div class="">
                      <img src="assets/images/avatars/01.png" class="rounded-circle" width="45" height="45" alt="">
                    </div>
                    <div class="">
                      <h5 class="notify-title">Congratulations Jhon</h5>
                      <p class="mb-0 notify-desc">Many congtars jhon. You have won the gifts.</p>
                      <p class="mb-0 notify-time">Today</p>
                    </div>
                    <div class="notify-close position-absolute end-0 me-3">
                      <i class="material-icons-outlined fs-6">close</i>
                    </div>
                  </div>
                </a>
              </div>
              <div>
                <a class="dropdown-item border-bottom py-2" href="javascript:;">
                  <div class="d-flex align-items-center gap-3">
                    <div class="user-wrapper bg-primary text-primary bg-opacity-10">
                      <span>RS</span>
                    </div>
                    <div class="">
                      <h5 class="notify-title">New Account Created</h5>
                      <p class="mb-0 notify-desc">From USA an user has registered.</p>
                      <p class="mb-0 notify-time">Yesterday</p>
                    </div>
                    <div class="notify-close position-absolute end-0 me-3">
                      <i class="material-icons-outlined fs-6">close</i>
                    </div>
                  </div>
                </a>
              </div>
              <div>
                <a class="dropdown-item border-bottom py-2" href="javascript:;">
                  <div class="d-flex align-items-center gap-3">
                    <div class="">
                      <img src="assets/images/apps/13.png" class="rounded-circle" width="45" height="45" alt="">
                    </div>
                    <div class="">
                      <h5 class="notify-title">Payment Recived</h5>
                      <p class="mb-0 notify-desc">New payment recived successfully</p>
                      <p class="mb-0 notify-time">1d ago</p>
                    </div>
                    <div class="notify-close position-absolute end-0 me-3">
                      <i class="material-icons-outlined fs-6">close</i>
                    </div>
                  </div>
                </a>
              </div>
              <div>
                <a class="dropdown-item border-bottom py-2" href="javascript:;">
                  <div class="d-flex align-items-center gap-3">
                    <div class="">
                      <img src="assets/images/apps/14.png" class="rounded-circle" width="45" height="45" alt="">
                    </div>
                    <div class="">
                      <h5 class="notify-title">New Order Recived</h5>
                      <p class="mb-0 notify-desc">Recived new order from michle</p>
                      <p class="mb-0 notify-time">2:15 AM</p>
                    </div>
                    <div class="notify-close position-absolute end-0 me-3">
                      <i class="material-icons-outlined fs-6">close</i>
                    </div>
                  </div>
                </a>
              </div>
              <div>
                <a class="dropdown-item border-bottom py-2" href="javascript:;">
                  <div class="d-flex align-items-center gap-3">
                    <div class="">
                      <img src="assets/images/avatars/06.png" class="rounded-circle" width="45" height="45" alt="">
                    </div>
                    <div class="">
                      <h5 class="notify-title">Congratulations Jhon</h5>
                      <p class="mb-0 notify-desc">Many congtars jhon. You have won the gifts.</p>
                      <p class="mb-0 notify-time">Today</p>
                    </div>
                    <div class="notify-close position-absolute end-0 me-3">
                      <i class="material-icons-outlined fs-6">close</i>
                    </div>
                  </div>
                </a>
              </div>
              <div>
                <a class="dropdown-item py-2" href="javascript:;">
                  <div class="d-flex align-items-center gap-3">
                    <div class="user-wrapper bg-danger text-danger bg-opacity-10">
                      <span>PK</span>
                    </div>
                    <div class="">
                      <h5 class="notify-title">New Account Created</h5>
                      <p class="mb-0 notify-desc">From USA an user has registered.</p>
                      <p class="mb-0 notify-time">Yesterday</p>
                    </div>
                    <div class="notify-close position-absolute end-0 me-3">
                      <i class="material-icons-outlined fs-6">close</i>
                    </div>
                  </div>
                </a>
              </div>
            </div> --}}
          </div>
        </li>
        <li class="nav-item dropdown">
          <a href="javascrpt:;" class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
             {{-- <img src="{{ asset('assets') }}/img/organization/default.png" class="rounded-circle p-1 border" width="45" height="45" alt=""> --}}
             <img
                src="{{ session()->has('customer_portal_org_image') && !empty(session('customer_portal_org_image')[0])
                    ? asset(session('customer_portal_org_image')[0])
                    : asset('assets/img/organization/default.png') }}"
                class="rounded-circle p-1 border"
                width="45"
                height="45"
                alt=""
                id="orgLogo_headder"
            >

          </a>
          <div class="dropdown-menu dropdown-user dropdown-menu-end shadow">
            {{-- <a class="dropdown-item  gap-2 py-2" href="javascript:;">
              <div class="text-center">
                <img src="assets/images/avatars/01.png" class="rounded-circle p-1 shadow mb-3" width="90" height="90"
                  alt="">
                <h5 class="user-name mb-0 fw-bold">Hello, Jhon</h5>
              </div>
            </a> --}}
            {{-- <hr class="dropdown-divider">
            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
              class="material-icons-outlined">person_outline</i>Profile</a>
            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
              class="material-icons-outlined">local_bar</i>Setting</a>
            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
              class="material-icons-outlined">dashboard</i>Dashboard</a>
            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
              class="material-icons-outlined">account_balance</i>Earning</a>
              <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                class="material-icons-outlined">cloud_download</i>Downloads</a>
            <hr class="dropdown-divider"> --}}
            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{route('customer_portal.portal_logout')}}"><i
            class="material-icons-outlined">power_settings_new</i>Logout</a>
          </div>
        </li>
      </ul>

    </nav>
  </header>
  <!--end top header-->


   <!--start sidebar-->
   <aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
      <div class="logo-icon logo_for_hide">
        <img src="{{ asset('assets/customer_portal/assets/images/logo-icon.png') }}" class="logo-img " alt="">
      </div>
      <div class="logo-name flex-grow-1">
        <img src="{{ asset('assets/customer_portal/assets/images/logo.png') }}" class="logo-img logo-img-name" style="width: 200px" alt="">
      </div>
      <div class="sidebar-close">
        <span class="material-icons-outlined">close</span>
      </div>
    </div>
    <div class="sidebar-nav">
        <!--navigation-->
        <ul class="metismenu" id="sidenav">
          <li class="{{ request()->routeIs('customer_portal.dashboard') ? 'mm-active' : '' }}">
            <a href="{{ route('customer_portal.dashboard') }}">
                <div class="parent-icon">
                    <i class="material-icons-outlined">home</i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        <li class="{{ request()->routeIs('customer_portal.orders') ? 'mm-active' : '' }}">
            <a href="{{ route('customer_portal.orders') }}">
                <div class="parent-icon">
                    <i class="material-icons-outlined">shopping_bag</i>
                </div>
                <div class="menu-title">My Orders</div>
            </a>
        </li>

        <li class="{{ request()->routeIs('customer_portal.payments') ? 'mm-active' : '' }}">
            <a href="{{ route('customer_portal.payments') }}">
                <div class="parent-icon">
                    <i class="material-icons-outlined">widgets</i>
                </div>
                <div class="menu-title">Payments</div>
            </a>
        </li>

        <li class="{{ request()->routeIs('customer_portal.settings') ? 'mm-active' : '' }}">
            <a href="{{ route('customer_portal.settings') }}">
                <div class="parent-icon">
                    <i class="material-icons-outlined">apps</i>
                </div>
                <div class="menu-title">Settings</div>
            </a>
        </li>
          {{-- <li>
            <a href="{{ route('customer_portal.customer_support') }}">
              <div class="parent-icon"><i class="material-icons-outlined">person</i>
              </div>
              <div class="menu-title">Customer support</div>
            </a>
          </li> --}}
         </ul>
        <!--end navigation-->

    </div>
    <div class="col-12 sidebar-bottom-card" >
        <div class="card w-100 " style="margin-bottom: unset;">
            <div class="card-body hero  " style="padding-top: unset;">
                <div class="title">customizable Products</div>
                <!-- BACKGROUND MOVING ITEMS -->
                <div class="columns">
                    <div class="column col1">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 1.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 2.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 3.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 4.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 1.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 2.png') }}">
                    </div>

                    <div class="column col2">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 5.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 6.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 7.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 8.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 5.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 6.png') }}">

                    </div>

                    <div class="column col3">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 9.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 10.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 11.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 12.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 9.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 10.png') }}">
                    </div>
                </div>

                <!-- FRONT MAIN IMAGE -->
                <div class="main-product">
                    <img src="{{ asset('assets/customer_portal/assets/images/banner/main.png') }}">
                </div>

                <button class="cta btn-success" id="browseCatalogBtn">BROWSE OUR CATALOG</button>

            </div>
        </div>
    </div>
  </aside>
<!--end sidebar-->
<!--start main wrapper-->
  <main class="main-wrapper">
    <div class="main-content">
        @if ($errors->has('payment'))
            <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                <div class="text-white">{{ $errors->first('payment') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                <div class="text-white">
                    {{ session('error') }}
                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close">
                </button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
                <div class="text-white">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @yield('sub-sidebar-content')
    </div>
  </main>
  <!--end main wrapper-->

  <!--start overlay-->
     <div class="overlay btn-toggle"></div>
  <!--end overlay-->

   <!--start footer-->
   <footer class="page-footer">
    <p class="mb-0">Copyright © {{ date('Y') }}. All right reserved.</p>
  </footer>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.getElementById('browseCatalogBtn').addEventListener('click', function () {
        window.open('https://encr.co/customer_catalog', '_blank');
    });
</script>
<script>

// document.addEventListener('DOMContentLoaded', function () {
//     const toggleBtn = document.querySelector('.btn-toggle a');

//     if (toggleBtn) {
//         toggleBtn.addEventListener('click', function (e) {
//             e.preventDefault();

//             document.body.classList.toggle('toggled');
//         });
//     }
// });

document.addEventListener('DOMContentLoaded', function () {

    const toggleBtn = document.querySelector('.btn-toggle a');
    const closeBtn = document.querySelector('.sidebar-close');

    /* OPEN / TOGGLE SIDEBAR */
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function (e) {
            e.preventDefault();

            document.body.classList.toggle('toggled');
        });
    }

    /* CLOSE SIDEBAR - MOBILE ONLY */
    if (closeBtn) {
        closeBtn.addEventListener('click', function () {

            if (window.innerWidth <= 768) {
                document.body.classList.remove('toggled');
            }

        });
    }

});


// FRONT ROTATION

// Duplicate each column content to make infinite scroll seamless
document.querySelectorAll(".column").forEach(col => {
    col.innerHTML += col.innerHTML; // duplicate content
    gsap.set(col, { yPercent: 0 }); // start from top
});

// Smooth continuous upward animation
gsap.to(".column", {
    yPercent: -50,        // move half height because content is duplicated
    duration: 50,         // adjust speed
    ease: "linear",       // constant speed
    repeat: -1
});
</script>
@endsection
