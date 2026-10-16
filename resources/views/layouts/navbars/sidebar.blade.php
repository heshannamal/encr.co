<style>
    .circlemin {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: white;
        border-radius: 50%;
        left: -10;
        width: 30px;
        height: 30px;
        color: black !important;
        border: 1px solid #212529;
    }
    .circlemax {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: white;
        border-radius: 50%;
        left: -10;
        width: 30px;
        height: 30px;
        color: black !important;
        border: 1px solid #212529;

    }

    .circle a {
        color: black;
    }

    .minimize {
        left: 230px;
        top: 20px;
    }
    .maximize {

        left: 51px;
        top: 20px;
    }

    .bg-box {
        background-color: #909090;
        width: 100%;
        height: 100%;

      }
    .sidenav {
        padding-bottom: 1rem;
    }
    /* Active main topic */
    .nav-item.active > .nav-link {
      /* Your desired styling for the active main topic */
      top: .25rem;
        right: auto;
        bottom: .25rem;
        left: 0;
        border-bottom: 0;
        border-left: 2px solid #c20528;
        color: #ca5d5d !important;
    }

    /* Active subtopic */
    .nav-item .nav-link.active {
      /* Your desired styling for the active subtopic */
      color: #ca5d5d !important;
    }
    @media (min-width: 768px) {
        .navbar-vertical.navbar-expand-md .navbar-collapse {
            padding-right: 1.5rem !important;
            padding-left: 1.5rem !important;
        }
        .navbar-vertical.navbar-expand-md .navbar-nav .nav .nav .nav-link , .nav-link-text , .navbar-vertical .navbar-nav .nav-link {
            font-size: .79rem;
        }
    }

    @media (max-width: 768px) {
        .navbar-collapse.collapsing, .navbar-collapse.show {
            background: #212529;
            height: calc(100vh) !important;
            margin: unset;
            width: 100%;
        }
        .navbar-vertical .navbar-nav .nav-link {
            color: #707172 !important;
        }
        .nav-item .nav-link.active {
            color: #ca5d5d !important;
        }
        .navbar {
            position: fixed !important;
            top: 0;
            left: 0;
            width: 100%;
        }
        html,
        body {
            overflow-x: hidden;
            max-width: 100%;
        }
        .container-fluid {
            /* overflow-x: hidden; */
        }
        .navbar-brand-img {
            max-width: 100%;
            height: auto;
        }
        .navbar-collapse .collapse-brand img {
            width: 100% !important;
            height: unset;;
        }
        .navbar-collapse .navbar-toggler span {
            background: #707172;
        }
        .responsive_top_bar {
            padding: 2rem 1rem !important;
        }
        .profile_icon {
            right: 15px;
            position: relative;
            top: unset;
        }
        .navbar-brand-img {
            max-height: 3rem !important;
        }
        .navbar {
            position: fixed !important;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1050;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        body {
            padding-top: 80px; /* navbar height ekata anuwa */
        }
        .main-content {
            background-color: #F2F3F5 !important;
        }
        .header-layout {
            margin-bottom: 27px !important;
            background-color: transparent !important;
        }
        .header1 {
            position: relative;
            display: block !important;
            top: 94px;
            background-color: white;
            padding-top: 5px;
        }
    }
    @media (max-width: 530px) {
        .navbar-brand-img {
            max-height: 3rem !important;
        }
    }
    @media (max-width: 400px){
        .collapse-brand {
            text-align: center;
            max-width: 76%;
        }
        .navbar-collapse .collapse-brand img {
            height: unset;
        }
        /* .monile_display_none {
            display: none;
        } */
     }

     @media (max-width: 767.98px) {

    .mobile-profile-notification {
        display: flex !important;
        align-items: center !important;
    }

    .mobile-profile-notification i {
        width: 20px !important;
        margin-right: 10px !important;
        font-size: 16px !important;
    }

    .mobile-profile-notification span:first-of-type {
        flex: 1 !important;
    }

    .mobile-notification-count {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;

        min-width: 22px !important;
        height: 22px !important;

        padding: 0 6px !important;

        background: #f5365c !important;
        color: #fff !important;

        border-radius: 50% !important;

        font-size: 11px !important;
        font-weight: 700 !important;
        line-height: 1 !important;
        right: 12px !important;
        top: unset !important
    }
}

/* =====================================================
   MOBILE FLOATING SCROLL DOWN BUTTON
   ===================================================== */

.mobile-scroll-down-btn{
    display: none;
}

@media (max-width: 767.98px){

    .mobile-scroll-down-btn{

        display: flex;

        position: fixed;

        right: 18px;
        bottom: 22px;

        width: 52px;
        height: 52px;

        border: none;
        border-radius: 50%;

        align-items: center;
        justify-content: center;

        background: linear-gradient(135deg,#222,#444);

        color: #fff;

        font-size: 1.1rem;

        cursor: pointer;

        z-index: 9999;

        box-shadow:
            0 8px 25px rgba(0,0,0,.25),
            0 2px 8px rgba(0,0,0,.15);

        transition: all .25s ease;

        animation: scrollBounce 2s infinite;
    }

    .mobile-scroll-down-btn:active{
        transform: scale(.92);
    }

    .mobile-scroll-down-btn i{
        pointer-events: none;
    }


    @keyframes scrollBounce{

        0%,100%{
            transform: translateY(0);
        }

        50%{
            transform: translateY(6px);
        }

    }


    /* Hide button when bottom reached */

    .mobile-scroll-down-btn.hide-scroll-btn{

        opacity: 0;

        visibility: hidden;

        transform: translateY(20px);

        pointer-events: none;
    }

}

    </style>

    <nav style="padding-bottom: 1rem;" class="sidenav navbar navbar-vertical fixed-left navbar-expand-md navbar-dark bg-dark pb-5 responsive_top_bar" id="sidenav-main">



        <div class="container-fluid">



            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Brand -->
            <div class="d-flex align-items-center justify-content-end">
                <a class="navbar-brand pt-0" href="{{ route('home') }}">
                    <img src="{{ asset('argon') }}/img/encore/logo.png" class="navbar-brand-img" id="logo_large" alt="...">
                    <img src="{{ asset('argon') }}/img/encore/logo_small.png" class="navbar-brand-img" id="logo_samll" alt="...">
                </a>

            </div>



            <!-- User -->
            <ul class="nav align-items-center d-md-none">
                <li class="nav-item dropdown profile_icon">
                    <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="media align-items-center">
                            <span class="avatar avatar-sm rounded-circle">
                                {{-- <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1-800x800.jpg"> --}}
                                <img alt="Image placeholder" class="profile_pic_change_class" src="{{ asset(auth()->user()->profile_pic) }}" style="height: 39px; width: 39px;border-radius: 50%;border: 1px solid #989898;">
                            </span>
                        </div>
                    </a>

                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                        <div class=" dropdown-header noti-title">
                            <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                        </div>
                        {{-- Notification --}}
                        <a href="{{ route('notifications') }}"
                        class="dropdown-item mobile-profile-notification">

                            <i class="fas fa-bell"></i>

                            <span>
                                {{ __('Notifications') }}
                            </span>

                            <span class="mobile-notification-count notifi-count">
                                0
                            </span>

                        </a>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <i class="ni ni-single-02"></i>
                            <span>{{ __('My profile') }}</span>
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="ni ni-settings-gear-65"></i>
                            <span>{{ __('Settings') }}</span>
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="ni ni-calendar-grid-58"></i>
                            <span>{{ __('Activity') }}</span>
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="ni ni-support-16"></i>
                            <span>{{ __('Support') }}</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            <i class="ni ni-user-run"></i>
                            <span>{{ __('Logout') }}</span>
                        </a>
                    </div>
                </li>
            </ul>

            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Collapse header -->
                <div class="navbar-collapse-header d-md-none">
                    <div class="row">
                        <div class="col-1 collapse-close ">
                        </div>
                        <div class="col-10 collapse-brand">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('argon') }}/img/encore/logo.png">
                            </a>
                        </div>
                        <div class="col-1 collapse-close">
                            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Search --}}
                <!-- Form -->
                {{-- <form class="mt-4 mb-3 d-md-none">
                    <div class="input-group input-group-rounded input-group-merge">
                        <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Search') }}" aria-label="Search">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <span class="fa fa-search"></span>
                            </div>
                        </div>
                    </div>
                </form> --}}

                <!-- Navigation -->
                <ul class="navbar-nav">

                        <li class="nav-item" title="Dashboard">
                            <a class="nav-link {{ $activePage == 'home' ? ' active' : '' }} unsave_event_class" href="{{ route('home') }}">
                                <i class="fa-solid fas fa-chart-column"></i> {{ __('Dashboard') }}
                            </a>
                        </li>




                    {{-- Orders --}}
                    @if (Gate::check('view orders') || Gate::check('view team store orders') || Gate::check('view inventory orders'))
                        <li class="nav-item{{ $activePage == 'orders' || $activePage == 'plorders' || $activePage == 'inventory_orders' ? ' active' : '' }}" title="Order">
                            <a class="nav-link collapsed" href="#order-panel" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="admin-panel">
                                <i class="fa-solid fas fa-cubes"></i>
                                <span class="nav-link-text">{{ __('Orders') }}</span>
                            </a>

                            <div class="collapse{{ $activePage == 'orders' || $activePage == 'plorders' || $activePage == 'inventory_orders' ? ' show' : '' }}" id="order-panel">
                                <ul class="nav nav-sm flex-column">
                                    @can('view orders')
                                        <li class="nav-item" title="orders">
                                            <a class="nav-link{{ $activePage == 'orders' ? ' active' : '' }} unsave_event_class" href="{{ route('orders') }}">
                                                <i class="fa-solid fas fa-cubes"></i> {{ __('Orders') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view plorders')
                                        <li class="nav-item" title="White Labeling Orders">
                                            <a class="nav-link{{ $activePage == 'plorders' ? ' active' : '' }} unsave_event_class" href="{{ route('plorders') }}">
                                                <i class="fa-solid fas fa-boxes-stacked"></i> {{ __('White Labeling Orders') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view inventory orders')
                                        <li class="nav-item" title="Inventory Orders">
                                            <a class="nav-link{{ $activePage == 'inventory_orders' ? ' active' : '' }} unsave_event_class" href="{{ route('inventory_orders') }}">
                                                <i class="fa-solid fas fa-cart-flatbed"></i> {{ __('Inventory Orders') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endif

                    {{-- Contact --}}
                    @if (Gate::check('view people') || Gate::check('view organization'))
                        <li class="nav-item{{ $activePage == 'organizations' || $activePage == 'people' ? ' active' : '' }}" title="Contact">
                            <a class="nav-link collapsed" href="#contact-panel" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="admin-panel">
                                <i class="fa-solid fas fa-address-book"></i>
                                <span class="nav-link-text">{{ __('Contacts') }}</span>
                            </a>

                            <div  class="collapse{{ $activePage == 'organizations_customers' || $activePage == 'organizations_leads' || $activePage == 'people' ? ' show' : '' }}" id="contact-panel">
                                <ul class="nav nav-sm flex-column">

                                    @can('view organization')
                                        <li class="nav-item" title="Customers">
                                            <a class="nav-link{{ $activePage == 'organizations_customers' ? ' active' : '' }} unsave_event_class" href="{{ route('organizations', ['type' => 'organizations_customers']) }}"">
                                                <i class="fa-solid fas fa-building"></i> {{ __('Organizations') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view organization')
                                        <li class="nav-item" title="Leads">
                                            <a class="nav-link{{ $activePage == 'organizations_leads' ? ' active' : '' }} unsave_event_class" href="{{ route('organizations', ['type' => 'organizations_leads']) }}">
                                                <i class="fa-solid fas fa-ranking-star"></i> {{ __('Leads') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view people')
                                        <li class="nav-item" title="People">
                                            <a class="nav-link{{ $activePage == 'people' ? ' active' : '' }} unsave_event_class" href="{{ route('people') }}">
                                                <i class="fa-solid fas fa-people-group"></i> {{ __('People') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endif

                    @php
                    $activePageName = ''; // Initialize the active page name variable

                    $currentUrl = Request::url();
                    if (strpos($currentUrl, 'emails') !== false) {
                        $activePageName = 'Mail';
                    } elseif (strpos($currentUrl, 'activities') !== false) {
                        $activePageName = 'activities';
                    }else {
                        $activePageName = '';
                    }
                    @endphp

                    {{-- Email & Activities --}}
                    @can('view email')
                    <li class="nav-item {{ $activePage == 'Mail' || $activePage == 'activities' || $activePage == 'Template' ? ' active' : '' }}" title="Email">
                        <a class="nav-link collapsed" href="#Email-Activities" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="admin-panel">
                                <i class="fa-solid fas fa-envelope-circle-check"></i>
                                <span class="nav-link-text">{{ __('Email & Activities') }}</span>
                            </a>

                            <div class="collapse {{ $activePage == 'Mail' || $activePage == 'activities' ? ' show' : '' }}" id="Email-Activities">
                                <ul class="nav nav-sm flex-column">
                                    @can('view email')
                                        <li class="nav-item" title="Email">
                                            <a class="nav-link{{ $activePage == 'Mail' ? ' active' : '' }} unsave_event_class" href="{{ url('/callbackmail') }}">
                                                <i class="fa-solid fas fa-envelope"></i> {{ __('Email') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view activities')
                                        <li class="nav-item" title="Activities">
                                            <a class="nav-link{{ $activePage == 'activities' ? ' active' : '' }} unsave_event_class" href="{{ route('activities') }}">
                                                <i class="fa-solid fas fa-calendar-plus"></i> {{ __('Activities') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view email')
                                        <li class="nav-item" title="Email Templates">
                                            <a class="nav-link{{ $activePage == 'Template' ? ' active' : '' }} unsave_event_class" href="{{ route('email.templates') }}">
                                                <i class="fa-solid fas fa-envelope-open-text"></i> {{ __('Email Templates') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcan

                    {{-- Product Catalog --}}

                    @can('view product catalog')
                        <li class="nav-item" title="product catlog">
                            <a class="nav-link{{ $activePage == 'product_catalog' ? ' active' : '' }} unsave_event_class" href="{{ route('admin_product_catlog') }}">
                                <i class="fa-solid fas fa-shirt"></i> {{ __('Product Catalog') }}
                            </a>
                        </li>
                    @endcan

                    {{-- Customer Portal --}}
                    @if (Gate::check('view tickets') || Gate::check('view customer settings') || Gate::check('customer enquiries') || Gate::check('catalog enquiries') || Gate::check('view subscribers') || Gate::check('view customer supports'))
                        <li class="nav-item{{ $activePage == 'customer_enquiries' || $activePage == 'subscribers' || $activePage == 'under_contruction' ? ' active' : '' }}" title="Customer Portal">
                            <a class="nav-link collapsed" href="#customer-panel" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="admin-panel">
                                <i class="fa-solid fas fa-chalkboard-user"></i>
                                <span class="nav-link-text">{{ __('Customer Portal') }}</span>
                            </a>

                            <div class="collapse{{ $activePage == 'customer_enquiries' || $activePage == 'under_contruction' || $activePage == 'enquiries' || $activePage == 'subscribers' || $activePage == 'customer_supports' ? ' show' : '' }}" id="customer-panel">
                                <ul class="nav nav-sm flex-column">

                                    @can('customer enquiries')
                                        <li class="nav-item" title="Customer Inquiries">
                                            <a class="nav-link{{ $activePage == 'customer_enquiries' ? ' active' : '' }} unsave_event_class" href="{{ url('customer_enquiries') }}">
                                                <i class="fa-solid fas fa-person-circle-question"></i> {{ __('Customer Inquiries') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('catalog enquiries')
                                        <li class="nav-item" title="Catalog Inquiries">
                                            <a class="nav-link{{ $activePage == 'enquiries' ? ' active' : '' }} unsave_event_class" href="{{ url('enquiries') }}">

                                                <i class="fa-solid fas fa-clipboard-question"></i> {{ __('Catalog Inquiries') }}

                                            </a>
                                        </li>
                                    @endcan
                                    @can('view subscribers')
                                        <li class="nav-item" title="Subscribers">
                                            <a class="nav-link{{ $activePage == 'subscribers' ? ' active' : '' }} unsave_event_class" href="{{ url('subscribers') }}">
                                                <i class="fa-solid fas fa-person-circle-plus"></i> {{ __('Subscribers') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view customer supports')
                                        <li class="nav-item" title="customer_supports">
                                            <a class="nav-link {{ $activePage == 'customer_supports' ? ' active' : '' }} " href="{{ route('customer_supports') }}">
                                                <i class="fas fa-comment-dots"></i> {{ __('Customer Supports') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endif

                    @if (Gate::check('view project management') || Gate::check('view project management') )
                        <li class="nav-item{{ $activePage == 'projects' || $activePage == 'pm_dashboard' || $activePage == 'project_inbox' || $activePage == 'my_tasks' ? ' active' : '' }}" title="Project Management">
                            <a class="nav-link collapsed" href="#project-management-panel" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="admin-panel">
                                <i class="fa-solid fas fa-sitemap"></i>
                                <span class="nav-link-text">{{ __('Project Management') }}</span>
                            </a>

                            <div class="collapse{{ $activePage == 'projects' || $activePage == 'pm_dashboard' || $activePage == 'project_inbox' || $activePage == 'my_tasks' ? ' show' : '' }}" id="project-management-panel">
                                <ul class="nav nav-sm flex-column">

                                        <li class="nav-item" title="Project Management Home">
                                            <a class="nav-link{{ $activePage == 'pm_dashboard' ? ' active' : '' }}" href="{{ url('projects/home') }}">
                                                <i class="fa-solid fas fa-house-chimney-user"></i> {{ __('Home') }}
                                            </a>
                                        </li>

                                        <li class="nav-item" title="Project Management List">
                                            <a class="nav-link{{ $activePage == 'projects' ? ' active' : '' }}" href="{{ url('projects/list') }}">
                                               <i class="fa-solid fas fa-layer-group"></i> {{ __('Projects') }}
                                            </a>
                                        </li>

                                        <li class="nav-item" title="Project Management Inbox">
                                            <a class="nav-link{{ $activePage == 'project_inbox' ? ' active' : '' }}" href="{{ url('projects/inbox') }}">
                                                <i class="fa-solid fas fa-comment-dots"></i> {{ __('Inbox') }}
                                            </a>
                                        </li>

                                        <li class="nav-item" title="Project Management My Tasks">
                                            <a class="nav-link{{ $activePage == 'my_tasks' ? ' active' : '' }}" href="{{ url('projects/my_tasks') }}">
                                                <i class="fa-solid fas fa-list-check"></i> {{ __('My Tasks') }}
                                            </a>
                                        </li>

                                </ul>
                            </div>
                        </li>
                    @endif

                    @php
                        $activePageName2 = ''; // Initialize the active page name variable

                        $currentUrl = Request::url();
                        if (strpos($currentUrl, 'OMG/store/add') !== false) {
                            $activePageName2 = 'add_OMG_Store';
                        } elseif (strpos($currentUrl, 'OMG/stores') !== false) {
                            $activePageName2 = 'all_omg_stores';
                        }else {
                            $activePageName2 = '';
                        }
                    @endphp

                    {{-- Team Stores --}}
                    @if (Gate::check('view add omg store') || Gate::check('view all omg store'))

                        <li class="nav-item" title="Team Stores">
                            <a class="nav-link{{ $activePage == 'Team Stores' ? ' active' : '' }} unsave_event_class" href="{{ route('stores') }}">
                                <i class="fa-solid fas fa-people-roof"></i> {{ __('Team Stores') }}
                            </a>
                        </li>
                    @endif

                    {{-- @if (Gate::check('view events and meetings') )
                        <li class="nav-item {{ $activePage == 'schedules' ? 'active' : '' }}"  title="Schedule Management">
                            <a class="nav-link {{ $activePage == 'schedules' ? 'active' : '' }}" href="{{ url('/schedules') }}">
                                <i class="fa-solid fas fa-calendar-days"></i>
                                <span class="nav-link-text">{{ __('Event and Meeting') }}</span>
                            </a>
                        </li>
                    @endif --}}

                    @php
                        $activePageReport = ''; // Initialize the active page name variable

                        $currentUrl = Request::url();
                        if (strpos($currentUrl, 'reports') !== false) {
                            $activePageReport = 'sales_leader_summary';
                        }
                        elseif (strpos($currentUrl, 'customerPayment') !== false) {
                            $activePageReport = 'payment_summary';
                        }
                        elseif (strpos($currentUrl, 'sales_summary') !== false) {
                            $activePageReport = 'sales_summary';
                        }
                        elseif (strpos($currentUrl, 'salesInvoice') !== false) {
                            $activePageReport = 'invoice_sammary';
                        }
                        elseif (strpos($currentUrl, 'orderSummary') !== false) {
                            $activePageReport = 'order_summary';
                        }
                        elseif (strpos($currentUrl, 'orderSheduleSheet') !== false) {
                            $activePageReport = 'order_shedule';
                        }
                        elseif (strpos($currentUrl, 'account_receivable_report') !== false) {
                            $activePageReport = 'ar_report';
                        }
                        elseif (strpos($currentUrl, 'customer_sales') !== false) {
                            $activePageReport = 'cu_sales_summary';
                        }elseif (strpos($currentUrl, 'canceled_order_report') !== false) {
                            $activePageReport = 'canceled_order_report';
                        }elseif(strpos($currentUrl, 'org_wise_product_report') !== false){
                            $activePageReport = 'org_wise_product_report';
                        }

                    @endphp

                    {{-- Reports --}}
                    @if (Gate::check('view reports') || Gate::check('view order embellishments report') || Gate::check('view sales leader summary') || Gate::check('view invoice summary') || Gate::check('view order summary') || Gate::check('view payment summary') || Gate::check('view order shedule') || Gate::check('view organizations with orders report'))

                        <li class="nav-item {{ $activePageReport == 'sales_leader_summary' ||  $activePage == 'sales_activity_report' || $activePage == 'analytical_summary_report' || $activePageReport == 'sales_summary' || $activePageReport == 'order_summary' || $activePageReport == 'payment_summary' || $activePageReport == 'cu_sales_summary' || $activePageReport == 'canceled_order_report' || $activePageReport == 'order_shedule' || $activePage == 'organizations_with_orders' ? ' active' : '' }}" title="Reports">
                            <a class="nav-link collapsed" href="#summary_reports"  data-toggle="collapse" role="button" aria-expanded="false" aria-controls="admin-panel">
                                <i class="fa-solid fas fa-file-waveform"></i> {{ __('Reports') }}
                            </a>
                            <div class="collapse {{ $activePageReport == 'sales_leader_summary' ||  $activePage == 'order_embellishments_report' || $activePage == 'Sales_Tax_Report' ||  $activePage == 'sales_activity_report' || $activePage == 'analytical_summary_report' || $activePageReport == 'sales_summary' || $activePageReport == 'order_summary' || $activePageReport == 'payment_summary' || $activePageReport == 'cu_sales_summary' || $activePageReport == 'canceled_order_report' || $activePage == 'organizations_with_orders' || $activePageReport == 'org_wise_product_report' || $activePageReport == 'order_shedule'? ' show' : '' }}" id="summary_reports">
                                <ul class="nav nav-sm flex-column">

                                    @can('view Sales activity Report')
                                        <li class="nav-item" title="Sales Activity Report">
                                            <a class="nav-link{{ $activePage == 'sales_activity_report' ? ' active' : '' }} unsave_event_class" href="{{ route('reports.sales_activity_report.index') }}">
                                                <i class="fa-solid fas fa-square-poll-vertical"></i> {{ __('Sales Activity Report') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view Analytical Summary Report')
                                        <li class="nav-item" title="Sales Summary">
                                            <a class="nav-link{{ $activePage == 'analytical_summary_report' ? ' active' : '' }} unsave_event_class" href="{{ route('reports.analytical_summary_report.index') }}">
                                                <i class="fa-solid fas fa-square-poll-vertical"></i> {{ __('Analytical Summary Report') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view sales summary report')
                                        <li class="nav-item" title="Sales Summary">
                                            <a class="nav-link{{ $activePageReport == 'sales_summary' ? ' active' : '' }} unsave_event_class" href="{{ route('reports.sales_summary') }}">
                                                <i class="fa-solid fas fa-square-poll-vertical"></i> {{ __('Sales Summary') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view Customer Sales Summary')
                                        <li class="nav-item" title="Customer Sales Summery">
                                            <a class="nav-link{{ $activePageReport == 'cu_sales_summary' ? ' active' : '' }} unsave_event_class" href="{{ route('reports.cu_sales_summary') }}">
                                                <i class="fa-solid fas fa-square-poll-vertical"></i> {{ __('Customer Sales Summary') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view order shedule')
                                        <li class="nav-item" title="Encore Order Shedule">
                                            <a class="nav-link{{ $activePageReport == 'order_shedule' ? ' active' : '' }} unsave_event_class" href="{{ route('orderSheduleSheet') }}">
                                                <i class="fa-solid fas fa-square-poll-vertical"></i>{{ __('Encore Order Shedule') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view canceled quotation')
                                        <li class="nav-item" title="Canceled Sales Report">
                                            <a class="nav-link{{ $activePageReport == 'canceled_order_report' ? ' active' : '' }} unsave_event_class" href="{{ route('reports.canceled_order_report') }}">
                                                <i class="fa-solid fas fa-square-poll-vertical"></i> {{ __('Canceled Quotation') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view compared reports')
                                        <li class="nav-item" title="compaired reports">
                                            <a class="nav-link{{ $activePageReport == 'compared_Reports' ? ' active' : '' }} unsave_event_class" href="{{ route('reports.compared_Reports') }}">
                                                <i class="fa-solid fas fa-square-poll-vertical"></i> {{ __('Comparison Reports') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view sales tax reports')
                                        <li class="nav-item" title="Sales Tax Report">
                                            <a class="nav-link{{ $activePage == 'Sales_Tax_Report' ? ' active' : '' }} unsave_event_class" href="{{ route('reports.Sales_Tax_Report') }}">
                                                <i class="fa-solid fas fa-square-poll-vertical"></i> {{ __('Sales Tax Report') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view organizations with orders report')
                                        <li class="nav-item" title="Organizations with orders">
                                            <a class="nav-link{{ $activePage == 'organizations_with_orders' ? ' active' : '' }} unsave_event_class" href="{{ route('reports.organizations_with_orders') }}">
                                               <i class="fa-solid fas fa-square-poll-vertical"></i> {{ __('Lead Source Report') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view organization-wise product report')
                                        <li class="nav-item" title="Organization-wise Product Report">
                                            <a class="nav-link{{ $activePageReport == 'org_wise_product_report' ? ' active' : '' }} unsave_event_class" href="{{ route('reports.org_wise_product_report') }}">
                                                <i class="fa-solid fas fa-square-poll-vertical"></i> {{ __('Organization-wise Product Report') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view order embellishments report')
                                        <li class="nav-item" title="Order Embellishments Report">
                                            <a class="nav-link{{ $activePage == 'order_embellishments_report' ? ' active' : '' }} unsave_event_class" href="{{ route('reports.order_embellishments_report') }}">
                                                <i class="fa-solid fas fa-square-poll-vertical"></i> {{ __('Order Embellishments Report') }}
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </div>
                        </li>
                    @endif

                    {{-- File Storage --}}
                    @if (Gate::check('view file storage'))
                        <li class="nav-item {{ $activePage == 'my_drive' || $activePage == 'file_share' || $activePage == 'oms' || $activePage == 'trash' ? ' active' : '' }}" title="File Storage">
                            <a class="nav-link collapsed" href="#management-panel" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="admin-panel">
                                <i class="fa-solid fas fa-folder-open"></i>
                                <span class="nav-link-text">{{ __('File Storage') }}</span>
                            </a>

                            <div class="collapse {{ $activePage == 'my_drive' || $activePage == 'file_share' || $activePage == 'oms' || $activePage == 'trash' ? ' show' : '' }}" id="management-panel">
                                <ul class="nav nav-sm flex-column">
                                    @can('view my drive')
                                        <li class="nav-item" title="My Drive">
                                            <a class="nav-link{{ $activePage == 'my_drive' ? ' active' : '' }} unsave_event_class" href="{{ route('file_management.my_drive') }}">
                                                <i class="fa-brands fas fa-google-drive"></i> {{ __('My Drive') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view file share')
                                        <li class="nav-item" title="Shared with Me">
                                            <a class="nav-link{{ $activePage == 'file_share' ? ' active' : '' }} unsave_event_class" href="{{ route('file_management.file_share') }}">
                                                <i class="fa-solid fas fa-share-from-square"></i> {{ __('Shared with Me') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view oms')
                                        <li class="nav-item" title="OMS">
                                            <a class="nav-link{{ $activePage == 'oms' ? ' active' : '' }} unsave_event_class" href="{{ route('file_management.oms') }}">
                                                <i class="fa-solid fas fa-database"></i> {{ __('OMS') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view trash')
                                        <li class="nav-item" title="Trash">
                                            <a class="nav-link{{ $activePage == 'trash' ? ' active' : '' }} unsave_event_class" href="{{ route('file_management.trash') }}">
                                                <i class="fa-solid fas fa-trash"></i> {{ __('Trash') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endif

                    @php
                        $activePageName3 = ''; // Initialize the active page name variable

                        $currentUrl = Request::url();
                        if (strpos($currentUrl, 'transactions') !== false) {
                            $activePageName3 = 'allTransactions';
                        } elseif (strpos($currentUrl, 'payable_invoice') !== false) {
                            $activePageName3 = 'payable';
                        }elseif (strpos($currentUrl, 'generate_invoice') !== false) {
                            $activePageName3 = 'generateInvoice';
                        }else {
                            $activePageName3 = '';
                        }
                    @endphp

                    @if (Gate::check('view accounting'))
                    <li class="nav-item {{ $activePageReport == 'ar_report' || $activePageReport == 'invoice_sammary' || $activePageName3 == 'allTransactions' || $activePageName3 == 'bulk_invoice' || $activePageName3 == 'generateInvoice' || $activePageName3 == 'payable' || $activePage == 'payment_ledger' || $activePage == 'finacial_year' || $activePage == 'credit_account' || $activePage == 'debit_account' ? ' active' : '' }}" title="Accounting">
                        <li class="nav-item {{ $activePageName3 == 'allTransactions' || $activePageName3 == 'bulk_invoice' || $activePageName3 == 'payable' || $activePageName3 == 'generateInvoice' || $activePageReport == 'ar_report' || $activePageReport == 'invoice_sammary' || $activePage == 'payment_ledger' || $activePage == 'finacial_year' || $activePage == 'credit_account' || $activePage == 'tax_report' || $activePage == 'debit_account' ? ' active' : '' }}" title="Accounting">
                            <a class="nav-link" href="#accounting-panel"  data-toggle="collapse" role="button" aria-expanded="false" aria-controls="admin-panel">
                                <i class="fa-solid fas fa-money-check-dollar"></i> {{ __('Accounting') }}
                            </a>
                        </li>

                        <div class="collapse {{ $activePageReport == 'ar_report' || $activePageReport == 'invoice_sammary' || $activePageName3 == 'allTransactions' || $activePageName3 == 'bulk_invoice' || $activePage == 'tax_report' || $activePageName3 == 'generateInvoice' || $activePageName3 == 'payable' || $activePage == 'payment_ledger' || $activePage == 'finacial_year' || $activePage == 'credit_account' || $activePage == 'debit_account' ? ' show' : '' }}" id="accounting-panel">
                            <ul class="nav nav-sm flex-column">
                                @if (Gate::check('view customers account'))
                                    <li class="nav-item {{ $activePageReport == 'ar_report' || $activePageReport == 'invoice_sammary' || $activePageName3 == 'allTransactions' || $activePage == 'tax_report' || $activePageName3 == 'bulk_invoice' ? ' active' : '' }}" title="Masters">
                                        <a class="nav-link" href="#accountingCustomers" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="accountingCustomers">
                                            <i class="fa-solid fas fa-user-tag"></i>
                                            <span class="nav-link-text">{{ __("Customer's Account") }}</span>
                                        </a>

                                        <div class="collapse  {{ $activePageReport == 'ar_report' || $activePageReport == 'invoice_sammary' || $activePageName3 == 'allTransactions' || $activePage == 'tax_report' || $activePageName3 == 'bulk_invoice' ? ' show' : '' }}" id="accountingCustomers">
                                            <ul class="nav nav-sm flex-column">
                                                @can('view account receivable report')
                                                    <li class="nav-item" title="Accounts receivable">
                                                        <a class="nav-link{{ $activePageReport == 'ar_report' ? ' active' : '' }} unsave_event_class" href="{{ route('reports.ar_report') }}">
                                                            <i class="fa-solid fas fa-hand-holding-dollar"></i> {{ __('Accounts receivable') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('view invoice summary')
                                                    <li class="nav-item" title="Invoice Summary">
                                                        <a class="nav-link{{ $activePageReport == 'invoice_sammary' ? ' active' : '' }} unsave_event_class" href="{{ route('salesInvoice') }}">
                                                            <i class="fa-solid fas fa-clipboard-list"></i> {{ __('Invoice Summary') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('view received payments')
                                                    <li class="nav-item" title="Received Payments">
                                                        <a class="nav-link{{ $activePageName3 == 'allTransactions' ? ' active' : '' }} unsave_event_class" href="{{ url('transactions') }}">
                                                            <i class="fa-solid fas fa-money-bill-wave"></i> {{ __('Received Payments') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('view bulk invoice')
                                                    <li class="nav-item" title="Bulk Invoice">
                                                        <a class="nav-link{{ $activePageName3 == 'bulk_invoice' ? ' active' : '' }} unsave_event_class" href="{{ url('bulk_invoices') }}">
                                                            <i class="fa-solid fas fa-file-circle-check"></i> {{ __('Bulk Invoice') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('view tax report')
                                                    <li class="nav-item" title="Tax Report">
                                                        <a class="nav-link{{ $activePage == 'tax_report' ? ' active' : '' }} unsave_event_class" href="{{ url('tax_report') }}">
                                                            <i class="fa-solid fas fa-percent"></i> {{ __('Tax Report') }}
                                                        </a>
                                                    </li>
                                                @endcan

                                            </ul>
                                        </div>
                                    </li>
                                @endif

                                @if (Gate::check('view vendors account'))
                                    <li class="nav-item {{  $activePageName3 == 'generateInvoice' || $activePage == 'all_invoice' || $activePageName3 == 'payable' || $activePage == 'payment_ledger' ? ' active' : '' }}" title="Users & Privileges">
                                        <a class="nav-link collapsed" href="#accountingVendor" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="accountingVendor">
                                            <i class="fa-solid fas fa-store"></i>
                                            <span class="nav-link-text">{{ __("Vendor's Account") }}</span>
                                        </a>

                                        <div class="collapse {{ $activePageName3 == 'generateInvoice' || $activePage == 'all_invoice' || $activePageName3 == 'payable' || $activePage == 'payment_ledger' ? ' show' : '' }}" id="accountingVendor">
                                            <ul class="nav nav-sm flex-column">
                                                @can('view generate invoice')
                                                    <li class="nav-item" title="Generated Invoice">
                                                        <a class="nav-link{{ $activePageName3 == 'generateInvoice' ? ' active' : '' }} unsave_event_class" href="{{ url('generate_invoice') }}">
                                                            <i class="fa-solid fas fa-file-invoice"></i> {{ __('Generated Invoice') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('view payable')
                                                    <li class="nav-item" title="Payable">
                                                        <a class="nav-link{{ $activePageName3 == 'payable' ? ' active' : '' }} unsave_event_class" href="{{ url('payable_invoice') }}">
                                                            <i class="fa-solid fas fa-dollar-sign"></i> {{ __('Payable') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('view payment leger')
                                                    <li class="nav-item" title="Payment Ledger">
                                                        <a class="nav-link{{ $activePage == 'payment_ledger' ? ' active' : '' }} unsave_event_class" href="{{ url('payment_ledger') }}">
                                                            <i class="fa-solid fas fa-book"></i> {{ __('Payment Ledger') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('view All Invoice')
                                                    <li class="nav-item" title="All Invoices">
                                                        <a class="nav-link{{ $activePage == 'all_invoice' ? ' active' : '' }} unsave_event_class" href="{{ url('all_invoices') }}">
                                                            <i class="fa-solid fas fa-file-lines"></i> {{ __('All Invoices') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </div>
                                    </li>
                                @endif
                                @if (Gate::check('view chart of account'))
                                    <li class="nav-item {{  $activePage == 'finacial_year' || $activePage == 'credit_account' || $activePage == 'debit_account' ? ' active' : '' }}" title="Chart of Accounts">
                                        <a class="nav-link collapsed" href="#chartOfAccounts" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="chartOfAccounts">
                                            <i class="fa-solid fas fa-chart-line"></i>
                                            <span class="nav-link-text">{{ __('Chart of Accounts') }}</span>
                                        </a>

                                        <div class="collapse {{ $activePage == 'finacial_year' || $activePage == 'credit_account' || $activePage == 'debit_account' ? ' show' : '' }}" id="chartOfAccounts">
                                            <ul class="nav nav-sm flex-column">
                                                @can('view financial year')
                                                    <li class="nav-item" title="Finacial Year">
                                                        <a class="nav-link{{ $activePage == 'finacial_year'  ? ' active' : '' }} unsave_event_class" href="{{ route('chart_of_accounts.finacial_year') }}">
                                                            <i class="fa-solid fas fa-calendar"></i> {{ __('Financial Year') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('view debit account')
                                                    <li class="nav-item" title="Debit Account">
                                                        <a class="nav-link{{ $activePage == 'debit_account'  ? ' active' : '' }} unsave_event_class" href="{{ route('chart_of_accounts.debit_account') }}">
                                                            <i class="fa-solid fa-credit-card"></i> {{ __('Debit Account') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>

                    @endif

                    {{-- Settings --}}
                    @if (Gate::check('view HR Module') || Gate::check('view user group') || Gate::check('view user group member') || Gate::check('view user') || Gate::check('view activity logs'))
                    <li class="nav-item{{ $activePage == 'HR_Dashboard' || $activePage == 'Employee_Managment' || $activePage == 'Leave_Groups' ||  $activePage == 'Leave_Types' || $activePage == 'Leave_Type' || $activePage == 'Leave_Managment' || $activePage == 'Attendance_Managment' || $activePage == 'Recruitment_Onboard' || $activePage == 'Payroll_Managment' || $activePage == 'user_permissions' || $activePage == 'user_groups' || $activePage == 'user_group_members' ? ' active' : '' }}" title="Order">
                        <a class="nav-link collapsed" href="#HumanResource-panel" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="admin-panel">
                            <i class="fa-solid fas fa-users-between-lines"></i>
                            <span class="nav-link-text">{{ __('Human Resource') }}</span>
                        </a>

                        <div class="collapse{{ $activePage == 'HR_Dashboard' || $activePage == 'Employee_Managment' || $activePage == 'Leave_Groups' ||  $activePage == 'Leave_Types' || $activePage == 'Leave_Type' || $activePage == 'Leave_Managment' || $activePage == 'Attendance_Managment' || $activePage == 'Recruitment_Onboard' || $activePage == 'Payroll_Managment' || $activePage == 'user_permissions' || $activePage == 'user_groups' || $activePage == 'user_group_members'  ? ' show' : '' }}" id="HumanResource-panel">
                            <ul class="nav nav-sm flex-column">
                                @can('view HR Dashboard')
                                    <li class="nav-item" title="HR Dashboard">
                                        <a class="nav-link{{ $activePage == 'HR_Dashboard' ? ' active' : '' }} unsave_event_class" href="{{ route('HR.Dashboard') }}">
                                            <i class="fa-solid fas fa-bars-progress"></i> {{ __('HR Dashboard') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('view Employee Managment')
                                    <li class="nav-item" title="Employee Managment">
                                        <a class="nav-link{{ $activePage == 'Employee_Managment' ? ' active' : '' }} unsave_event_class" href="{{ route('HR.Employee_Managment') }}">
                                            <i class="fa-solid fas fa-users-gear"></i> {{ __('Employee Management') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('view user permissions')
                                    <li class="nav-item" title="Roles">
                                        <a class="nav-link{{ $activePage == 'user_permissions' ? ' active' : '' }} unsave_event_class" href="{{ url('permissions') }}">
                                            <i class="fa-solid fas fa-user-shield"></i> {{ __('Employee  Permissions') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('view user group')
                                    <li class="nav-item" title="User Groups">
                                        <a class="nav-link{{ $activePage == 'user_groups' ? ' active' : '' }} unsave_event_class" href="{{ route('user_roles') }}">
                                            <i class="fa-solid fas fa-user-group"></i> {{ __('Employee Groups') }}
                                        </a>
                                    </li>
                                @endcan
                                <!-- @can('view user group member')
                                    <li class="nav-item" title="User Group Members">
                                        <a class="nav-link{{ $activePage == 'user_group_members' ? ' active' : '' }} unsave_event_class" href="{{ route('user_groups') }}">
                                            <i class="fas fa-user-friends"></i> {{ __('Employee Group Members') }}
                                        </a>
                                    </li>
                                @endcan -->
                                {{-- @can('view Attendance Managment')
                                    <li class="nav-item" title="Attendance Managment">
                                        <a class="nav-link{{ $activePage == 'Attendance_Managment' ? ' active' : '' }} unsave_event_class" href="{{ route('HR.Attendance_Managment') }}">
                                            <i class="fas fa-clipboard"></i> {{ __('Attendance Managment') }}
                                        </a>
                                    </li>
                                @endcan --}}
                                @can('view leave Managment')
                                    <li class="nav-item" title="Leave Managment">
                                        <a class="nav-link{{ $activePage == 'Leave_Managment' ? ' active' : '' }} unsave_event_class" href="{{ route('HR.Leave_managment') }}">
                                            <i class="fa-solid fas fa-calendar-xmark"></i> {{ __('Leave Management') }}
                                        </a>
                                    </li>
                                @endcan
                                <!-- @can('view leave types')
                                    <li class="nav-item" title="Leave Types">
                                        <a class="nav-link{{ $activePage == 'Leave_Types' ? ' active' : '' }} unsave_event_class" href="{{ route('HR.Leave_types') }}">
                                            <i class="fas fa-clipboard"></i> {{ __('Leave Group') }}
                                        </a>
                                    </li>
                                @endcan -->
                                @can('view leave groups')
                                    <li class="nav-item" title="Leave Groups">
                                        <a class="nav-link{{ $activePage == 'Leave_Groups' ? ' active' : '' }} unsave_event_class" href="{{ route('HR.Leave_groups') }}">
                                            <i class="fa-solid fas fa-calendar-xmark"></i> {{ __('Leave Groups') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('view leave type')
                                    <li class="nav-item" title="Leave Type">
                                        <a class="nav-link{{ $activePage == 'Leave_Type' ? ' active' : '' }} unsave_event_class" href="{{ route('HR.Leave_type') }}">
                                            <i class="fa-solid fas fa-calendar-xmark"></i> {{ __('Leave Type') }}
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </div>
                    </li>
                @endif


                    @if (Gate::check('view pdt tool') || Gate::check('view Notification Settings') || Gate::check('view fabric') || Gate::check('view product') || Gate::check('view factory price') || Gate::check('view product categories') || Gate::check('view sizes') || Gate::check('view fits') || Gate::check('view embellishment type') || Gate::check('view product tagline') || Gate::check('view catalog category') || Gate::check('view gender') || Gate::check('manage project icons') || Gate::check('view factories') || Gate::check('view user group') || Gate::check('view user group member') || Gate::check('view user') || Gate::check('view sport') || Gate::check('add size type'))
                    <li class="nav-item {{ $activePage == 'Notification_settings' || $activePage == 'fabrics' || $activePage == 'user_log'  || $activePage == 'factory_priceList' || $activePage == 'products' || $activePage == 'product_categories' || $activePage == 'sizes' || $activePage == 'product_sports' || request()->routeIs('attributes') || $activePage == 'attribute_groups' || $activePage == 'pattern_codes' || $activePage == 'embellishment_types' || $activePage == 'product_tagline' || $activePage == 'catalog_categories' || $activePage == 'gender' || $activePage == 'project_icons' || $activePage == 'project_types'  || $activePage == 'sports'|| $activePage == 'factories' || request()->routeIs('size_type') || request()->routeIs('additional_payment') ? ' active' : '' }}" title="Settings">


                        <a class="nav-link collapsed" href="#admin-panel" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="admin-panel">
                            <i class="fas fa-cog"></i>
                            <span class="nav-link-text">{{ __('Settings') }}</span>
                        </a>



                        <div class="collapse {{$activePage == 'pdt_tool' || $activePage == 'Notification_settings' || $activePage == 'fabrics' || $activePage == 'user_log'  || $activePage == 'lead_sources' || $activePage == 'factory_priceList' || $activePage == 'products' || $activePage == 'master_organizations'|| $activePage == 'product_categories' || $activePage == 'sizes' || $activePage == 'product_sports' || $activePage == 'fits' || request()->routeIs('attributes') || $activePage == 'attribute_groups' || $activePage == 'pattern_codes' || $activePage == 'embellishment_types' || $activePage == 'product_tagline' || $activePage == 'catalog_categories' || $activePage == 'gender' || $activePage == 'project_icons' || $activePage == 'project_types' || $activePage == 'sports' || $activePage == 'factories' || request()->routeIs('size_type') || request()->routeIs('additional_payment') ? ' show' : '' }}" id="admin-panel">

                            <ul class="nav nav-sm flex-column">

                                @if (Gate::check('view fabric') || Gate::check('view product') || Gate::check('view factory price') || Gate::check('view product categories') || Gate::check('view sizes') || Gate::check('view fits') || Gate::check('view embellishment type') || Gate::check('view product tagline') || Gate::check('view catalog category') || Gate::check('view gender') || Gate::check('manage project icons') || Gate::check('view factories') || Gate::check('view sport'))
                                    <li class="nav-item {{ $activePage == 'fabrics' || $activePage == 'lead_sources' || $activePage == 'factory_priceList' || $activePage == 'products' || $activePage == 'master_organizations'|| $activePage == 'product_categories' || $activePage == 'sizes' || $activePage == 'product_sports' || request()->routeIs('attributes') || $activePage == 'attribute_groups' || $activePage == 'pattern_codes' || $activePage == 'embellishment_types' || $activePage == 'product_tagline' || $activePage == 'catalog_categories' || $activePage == 'gender' || $activePage == 'project_icons' || $activePage == 'project_types' || $activePage == 'sports' || $activePage == 'factories' || request()->routeIs('size_type') || request()->routeIs('additional_payment')


                                     ? ' active' : '' }}" title="Masters">
                                        <a class="nav-link" href="#master-panel" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="admin-panel">
                                            <i class="fas fa-crown"></i>
                                            <span class="nav-link-text">{{ __('Masters') }}</span>
                                        </a>


                                        <div class="collapse  {{ $activePage == 'fabrics' || $activePage == 'lead_sources' || $activePage == 'factory_priceList' || $activePage == 'products' || $activePage == 'master_organizations' || $activePage == 'product_categories' || $activePage == 'sizes' || $activePage == 'product_sports' || $activePage == 'fits' || request()->routeIs('attributes') || $activePage == 'attribute_groups' || $activePage == 'pattern_codes' || $activePage == 'embellishment_types' || $activePage == 'product_tagline' || $activePage == 'catalog_categories' || $activePage == 'gender' || $activePage == 'project_icons' || $activePage == 'project_types'  || $activePage == 'sports'|| $activePage == 'factories' || request()->routeIs('size_type') ||request()->routeIs('additional_payment') ? ' show' : '' }}" id="master-panel">

                                            <ul class="nav nav-sm flex-column">
                                                @can('view product')
                                                    <li class="nav-item" title="Products">
                                                        <a class="nav-link{{ $activePage == 'products' ? ' active' : '' }} unsave_event_class" href="{{ route('products') }}">
                                                            <i class="fas fa-tshirt"></i> {{ __('Products') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('organization lead source')
                                                    <li class="nav-item" title="Master Organizations">
                                                        <a class="nav-link{{ $activePage == 'master_organizations' ? ' active' : '' }} unsave_event_class" href="{{ route('master_organizations') }}">
                                                            <i class="fas fa-building"></i> {{ __('Organizations') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('view product categories')
                                                    <li class="nav-item" title="Product Categories">
                                                        <a class="nav-link{{ $activePage == 'product_categories' ? ' active' : '' }} unsave_event_class" href="{{ route('product_categories') }}">
                                                            <i class="fa-solid fas fa-shapes"></i> {{ __('Product Styles') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('view fabric')
                                                    <li class="nav-item" title="Fabrics">
                                                        <a class="nav-link{{ request()->routeIs('fabrics') ? ' active' : '' }} unsave_event_class" href="{{ route('fabrics') }}">
                                                            <i class="fa-solid fas fa-rug"></i> {{ __('Fabrics') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('view lead source')
                                                    <li class="nav-item" title="Lead Sources">
                                                        <a class="nav-link{{ $activePage == 'lead_sources' ? ' active' : '' }} unsave_event_class" href="{{ route('lead_sources') }}">
                                                            <i class="fa-solid fas fa-volume-high"></i> {{ __('Lead Sources') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('view product sports')
                                                    <li class="nav-item" title="Product Sports">
                                                        <a class="nav-link{{ $activePage == 'product_sports' ? ' active' : '' }} unsave_event_class" href="{{ route('products.view_product_sports') }}">
                                                            <i class="fa-solid fas fa-basketball"></i> {{ __('Product sports') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('view factory price')
                                                    <li class="nav-item" title="Products Price List & Weight">
                                                        <a class="nav-link {{ request()->routeIs('factory_priceList') ? 'active' : '' }} unsave_event_class" href="{{ route('factory_priceList') }}">
                                                            <i class="fa-solid fas fa-file-invoice-dollar"></i> {{ __('Products Price List & Weight') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('view sizing fit')
                                                    <li class="nav-item" title="Sizing Fit">
                                                        <a class="nav-link {{ request()->routeIs('sizing_fit') ? 'active' : '' }} unsave_event_class" href="{{ route('sizing_fit') }}">
                                                            <i class="fa-solid fas fa-ruler-combined"></i> {{ __('Size Chart') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('view sizes')
                                                    <li class="nav-item" title="Sizes">
                                                        <a class="nav-link{{ $activePage == 'sizes' ? ' active' : '' }} unsave_event_class" href="{{ route('sizes') }}">
                                                            <i class="fa-solid fas fa-person-arrow-up-from-line"></i> {{ __('Sizes') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('view fits')
                                                    <li class="nav-item" title="Fits">
                                                        <a class="nav-link{{ $activePage == 'fits' ? ' active' : '' }} unsave_event_class" href="{{ route('fits') }}">
                                                            <i class="fa-solid fas fa-person-rays"></i> {{ __('Fits') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('view attributes')
                                                    <li class="nav-item" title="Attributes">
                                                        <a class="nav-link{{ request()->routeIs('attributes') ? ' active' : '' }} unsave_event_class" href="{{ route('attributes') }}">
                                                            <i class="fa-brands fas fa-blackberry"></i> {{ __('Attributes') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('view attribute groups')
                                                    <li class="nav-item" title="Attribute Groups">
                                                        <a class="nav-link{{ $activePage == 'attribute_groups' ? ' active' : '' }} unsave_event_class" href="{{ route('attribute_groups') }}">
                                                            <i class="fa-brands fas fa-perbyte"></i> {{ __('Attribute Groups') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('manage pattern code')
                                                    <li class="nav-item" title="Pattern Code">
                                                        <a class="nav-link{{ $activePage == 'pattern_codes' ? ' active' : '' }} unsave_event_class" href="{{ route('pattern_codes') }}">
                                                            <i class="fa-solid fas fa-hashtag"></i> {{ __('Pattern Code') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('view embellishment type')
                                                    <li class="nav-item" title="Embellishment Types">
                                                        <a class="nav-link{{ $activePage == 'embellishment_types' ? ' active' : '' }} unsave_event_class" href="{{ route('embellishment_types') }}">
                                                            <i class="fa-brands fas fa-firstdraft"></i> {{ __('Embellishment Types') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('view product tagline')
                                                    <li class="nav-item" title="Product Tagline">
                                                        <a class="nav-link{{ $activePage == 'product_tagline' ? ' active' : '' }} unsave_event_class" href="{{ route('product_tagline') }}">
                                                            <i class="fa-solid fas fa-tags"></i> {{ __('Product Tagline') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('view factories')
                                                    <li class="nav-item" title="Factories">
                                                        <a class="nav-link{{ $activePage == 'factories' ? ' active' : '' }} unsave_event_class" href="{{ route('factories') }}">
                                                            <i class="fa-solid fas fa-landmark"></i> {{ __('Factories') }}
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('view project type')
                                                <li class="nav-item" title="Project Type">
                                                    <a class="nav-link{{ $activePage == 'project_types' && !request()->routeIs('sports') && !request()->routeIs('size_type') ? ' active' : '' }} unsave_event_class" href="{{ route('project_type') }}">
                                                        <i class="fa-solid fas fa-diagram-project"></i> {{ __('Project Types') }}
                                                    </a>
                                                </li>
                                            @endcan

                                            @can('view sport')
                                                <li class="nav-item" title="Sports">
                                                    <a class="nav-link {{ request()->routeIs('sports') ? ' active' : '' }} unsave_event_class" href="{{ route('sports') }}">
                                                        <i class="fa-solid fas fa-person-skating"></i> {{ __('Sports') }}
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('view size type')
                                                <li class="nav-item" title="Size Types">
                                                    <a class="nav-link {{ request()->routeIs('size_type') ? ' active' : 'size_type' }} unsave_event_class" href="{{ route('size_type') }}">
                                                        <i class="fa-solid fas fa-swatchbook"></i> {{ __('Size Types') }}
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('view additional payment')
                                                <li class="nav-item" title="Additional Payments">
                                                    <a class="nav-link {{ request()->routeIs('additional_payment') ? ' active' : 'additional_payment' }} unsave_event_class" href="{{ route('additional_payment') }}">
                                                        <i class="fa-solid fas fa-sack-dollar"></i> {{ __('Additional Payments') }}
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('view theme settings')
                                                <li class="nav-item" title="Theme Setting">
                                                    <a class="nav-link{{ $activePage == 'theme_setting' ? ' active' : '' }} unsave_event_class" href="{{ route('theme_setting') }}">
                                                        <i class="fa-solid fas fa-wand-magic-sparkles"></i> {{ __('Theme Setting') }}
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('view catalog category')
                                                <li class="nav-item" title="Catalog Categories">
                                                    <a class="nav-link{{ $activePage == 'catalog_categories' ? ' active' : '' }} unsave_event_class" href="{{ route('catalog_categories') }}">
                                                        <i class="fa-solid fas fa-socks"></i> {{ __('Catalog Categories') }}
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('view gender')
                                                <li class="nav-item" title="Gender">
                                                    <a class="nav-link{{ $activePage == 'gender' ? ' active' : '' }} unsave_event_class" href="{{ route('master_gender') }}">
                                                        <i class="fa-solid fas fa-mars-and-venus"></i> {{ __('Gender') }}
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('manage project icons')
                                                <li class="nav-item" title="Project Icons">
                                                    <a class="nav-link{{ $activePage == 'project_icons' ? ' active' : '' }} unsave_event_class" href="{{ route('project_icons.index') }}">
                                                        <i class="fa-solid fas fa-bezier-curve"></i> {{ __('Project Icons') }}
                                                    </a>
                                                </li>
                                            @endcan

                                            </ul>
                                        </div>
                                    </li>
                                @endif

                                @if (Gate::check('view activity logs'))
                                    @can('view user logs')
                                        <li class="nav-item" title="User Logs">
                                            <a class="nav-link{{ $activePage == 'user_log' ? ' active' : '' }} unsave_event_class" href="{{ route('user_log.index') }}">
                                                <i class="fa-solid fas fa-clipboard-user"></i> {{ __('User Activity Logs') }}
                                            </a>
                                        </li>
                                    @endcan
                                @endif
                                @if (Gate::check('view pdt tool'))
                                    @can('view pdt tool')
                                        <li class="nav-item" title="PDT tool">
                                            <a class="nav-link{{ $activePage == 'pdt_tool' ? ' active' : '' }} " href="{{ route('pdt.index') }}">
                                                <i class="fa-solid fas fa-object-group"></i> {{ __('PDT') }}
                                            </a>
                                        </li>
                                    @endcan
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                {{-- System configurations --}}
                @if (Gate::check('view system configuration'))


                        <li class="nav-item {{ $activePage == 'Notification_settings' || $activePage == 'config_Settings' || $activePage == 'Payment_Gateway' || $activePage == 'folder_structure'  ? ' active' : '' }}" title="System Configuration">


                            <a class="nav-link collapsed" href="#Configurations-panel" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="admin-panel">
                               <i class="fa-solid fas fa-screwdriver-wrench"></i>
                                <span class="nav-link-text">{{ __('System Configuration') }}</span>
                            </a>



                            <div class="collapse {{ $activePage == 'Notification_settings' || $activePage == 'config_Settings' || $activePage == 'Payment_Gateway' || $activePage == 'folder_structure' ? ' show' : '' }}" id="Configurations-panel">

                                <ul class="nav nav-sm flex-column">
                                    @can('view configuration dashboard')
                                        <li class="nav-item" title="configuration dashboard">
                                            <a class="nav-link{{ $activePage == 'config_Settings' ? ' active' : '' }} unsave_event_class" href="{{ route('configuration.get_dashboard_data') }}">
                                                <i class="fa-solid fas fa-sliders"></i> {{ __('Configuration Dashboard') }}
                                            </a>
                                        </li>
                                    @endcan


                                    @can('view Notification Settings')
                                        <li class="nav-item" title="My Drive">
                                            <a class="nav-link{{ $activePage == 'Notification_settings' ? ' active' : '' }} unsave_event_class" href="{{ route('Notification.Settings') }}">
                                                <i class="fas fa-bell"></i> {{ __('Notifications') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view Email Settings')
                                        <li class="nav-item" title="Shared with Me">


                                            <a class="nav-link{{ $activePage == 'file_share' ? ' active' : '' }} unsave_event_class" href="{{ route('NotificationEmail.Settings') }}">


                                                <i class="fas fa-envelope"></i> {{ __('Email') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('manage system api')
                                        <li class="nav-item" title="Stsyem API">
                                            <a class="nav-link{{ $activePage == 'system_api' ? ' active' : '' }} unsave_event_class" href="{{ route('system_api.index') }}">
                                                <i class="fa-solid fas fa-laptop-code"></i> {{ __('System APIs') }}
                                            </a>
                                        </li>
                                    @endcan


                                    @if (Gate::check('view system other configurations'))
                                        <li class="nav-item {{  $activePage == 'Database_Settings' || $activePage == 'Payment_Gateway' || $activePage == 'folder_structure'  ? ' active' : '' }}" title="Users & Privileges">


                                            <a class="nav-link collapsed" href="#OtherConfigurations" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="OtherConfigurations">
                                                <i class="fa-solid fas fa-wrench"></i>
                                                <span class="nav-link-text">{{ __("Other Configurations") }}</span>
                                            </a>


                                            <div class="collapse {{  $activePage == 'Database_Settings' || $activePage == 'folder_structure' || $activePage == 'Payment_Gateway' ? ' show' : '' }}" id="OtherConfigurations">
                                                <ul class="nav nav-sm flex-column">
                                                    @can('view generate invoice')
                                                        <li class="nav-item" title="Database Settings">
                                                            <a class="nav-link{{ $activePage == 'Database_Settings' ? ' active' : '' }} unsave_event_class" href="{{ route('configuration.get_database_data') }}">
                                                                <i class="fa-solid fas fa-database"></i> {{ __('Database') }}
                                                            </a>
                                                        </li>
                                                    @endcan
                                                    @can('view payment gateway')
                                                        <li class="nav-item" title="Payment Gateway">
                                                            <a class="nav-link{{ $activePage == 'Payment_Gateway' ? ' active' : '' }} unsave_event_class" href="{{ route('configuration.get_gateway_data') }}">
                                                               <i class="fa-solid fas fa-money-bill-transfer"></i> {{ __('Payment Gateway') }}
                                                            </a>
                                                        </li>
                                                    @endcan
                                                    @can('view folder structure')
                                                        <li class="nav-item" title="Folder Structure">
                                                            <a class="nav-link{{ $activePage == 'folder_structure' ? ' active' : '' }} " href="{{ route('configuration.getFolderStructure') }}">
                                                                <i class="fa-solid fas fa-folder-tree"></i> {{ __('Folder Structure') }}

                                                            </a>
                                                        </li>
                                                    @endcan

                                                </ul>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                    @endif

                </ul>
             </div>
        </div>
    </nav>
