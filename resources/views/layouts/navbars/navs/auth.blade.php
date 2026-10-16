<style>
    .h4.page-title {
        font-weight: 500;
        font-size: 1.5rem;
        padding-left: 15px;
        color: #707172 !important;
    }
    .notification-link .nav-link {
        color: #767778;
        position: relative;
    }
    .notification-link .nav-link:hover,
    .notification-link .nav-link:focus {
        background-color: transparent !important;
    }
    .notifi-count {
        background-color: #df0029;
        border: 1px solid #df0029;
        height: 20px;
        width: 20px;
        border-radius: 50%;
        color: #fff;
        text-align: center;
        font-size: 12px;
        position: absolute;
        top: 12px;
        right: 0px;
    }
    .email-notifi-count {
        background-color: #df0029;
        border: 1px solid #df0029;
        height: 20px;
        width: 20px;
        border-radius: 50%;
        color: #fff;
        text-align: center;
        font-size: 12px;
        position: absolute;
        top: 12px;
        right: 0px;
    }
    .font {
        font-family: Helvetica, sans-serif;
        font-size: 17px;
        color: #fff;

    }
    .header2 {
        position: relative;
        top: -3px;
        right: -73px;
    }

    .hFont {
        font-family: Helvetica, sans-serif;
        font-size: 20px;
        color: black;
        position: relative;
        top: -2px;
        /* letter-spacing: 1px; */

    }
    .header1 {
        /* position: relative;
        top: 9%;
        margin-left:-3%; */
        text-align: center;
    }
    .bg-box {
        background-color: white;
        width: 100%;
        height: 50px;
        margin-top: 10px;
    }
    .searchbx {
        border-radius: 20px;
        padding: 10px;
        font-size: 16px;
        border: none;
    }
    .container {
        max-width: 800px;
        margin: 0 auto;
    }

    /* Styles for smaller screens */
    @media (max-width: 768px) {
        .header1 {
            position: relative;
            display: none;
        }
    }
    .card1 {
        border-radius: 4px;
        border: #fff;
        position: relative;
    }
    .notifi {
        position: relative;
        right: 10px;
    }
    .notifi1 {
        position: relative;
        justify-content: end;
        right: -80px;
    }
    .search {
        position: relative;
        top: 6px;
        right: -48.5%;
    }
    .profile {
        padding-left: 0%;
    }
    .proimage {
        position: relative;
        top: -10%;
    }
    .padding {
        padding: 6px;
        top: -30px;
    }
    .profile-pic {
        position: relative;

    }
    .notifi-icon {
        position: relative;
        top: -5px;
        right: -90px;
    }
    .fix-nav {
        position: sticky;
        top: 0px;
    }
    .side-bar-btn {
        position: relative;
        left: -54px;
        top: 10px;
    }
    .header-layout {
        z-index: 1;
    }
    .back-home-btn {
        position: relative;
        top: -3px;
        left: -32px;
    }
    .home-btn-color {
        color: black;
        font-size: 12px;
    }
    .home-btn-color:hover {
        color: #e6e6e6
    }
    .navbar-padding {
        padding-bottom: 0 !important;
    }
    @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {
      .navitem01{
        left : -22%;
      }
    }
    .div_nav_top{
        position: relative;
        bottom: 12%;
    }
    .copy-to-clipboard-btn {
        background-color: #47D6B6;
        border: 1px solid #47D6B6 !important;
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
        border-top-right-radius: 3px !important;
        border-bottom-right-radius: 3px !important;
        color: #fff !important;
        font-size: .74rem !important;
        font-weight: 700 !important;
        padding: 0 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 34px;
        min-height: 34px;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
        line-height: 1;
        z-index: inherit !important;
    }
    .copy-to-clipboard-btn:hover {
        background-color: #38c5a7;
        border-color: #38c5a7 !important;
        color: #fff !important;
    }
    .copy-to-clipboard-btn.copied {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
        color: #fff !important;
    }
    .copy-to-clipboard-btn:focus {
        box-shadow: none !important;
        outline: none !important;
    }



</style>

{{-- Top navbar --}}
<div class="bg-box container-fluid mb-5 fix-nav header-layout">
    {{-- Brand --}}
    <div class=" minimize side-bar-btn" >
        <div class="">
          <a class="circlemin" href="#" id="minimize_icon"><i class="fas fa-angle-left"></i></a>
        </div>
    </div>
    <div class=" maximize side-bar-btn" id="maximize_icon">
        <div class="">
            <a class="circlemax" href="#" id="maximize_icon"><i class="fas fa-angle-right"></i></a>
        </div>
    </div>
    <div class="col-md-12 padding div_borderbox_cls">
        <div class="row">
            <nav class="navbar navbar-top navbar-expand-md navbar-dark align-items-center navbar-padding" id="navbar-main">
                    <div class="container-fluid col-md-12 div_nav_top">
                            <div class="d-lg-block col-md-3 back-home-btn">
                                <strong>
                                    @yield('back-btn')
                                </strong>
                            </div>
                            <div class="col-md-6 header1">
                                <strong><span class="hFont headder_size" id="header">
                                    @yield('order-header')
                                </span ></strong>
                            </div>
                        {{-- Name of logged person --}}
                            {{-- <div class="media-body d-none d-lg-block header2 col-md-4">
                                <span class="mb-0 font">Hi {{ auth()->user()->name }}, <a id="greeting"></a></span>
                            </div> --}}
                            <div class="col-md-3">
                                <ul class="align-items-center d-md-flex d-none navbar-nav notifi1">
                                    <li class="nav-item notification-link" title="Emails">
                                        <a class="nav-link unsave_event_class" href="{{ url('/callbackmail') }}">
                                            <i class="fas fa-envelope" style="font-size:25px;"></i>
                                            <div id="unread-email-count22" class="email-notifi-count"></div>
                                        </a>
                                    </li>
                                    <li class="nav-item notification-link" title="Notification">
                                        <a class="nav-link unsave_event_class" href="{{ route('notifications') }}">
                                            <i class="fas fa-bell" style="font-size: 25px;"></i>
                                            <div class="notifi-count">0</div>
                                        </a>
                                    </li>

                                    <li class="nav-item dropdown " title="Profile Menu" style="position: unset;">
                                        <a class="nav-link " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <div class="media align-items-center profile-pic">
                                                <span class="avatar avatar-sm rounded-circle">
                                                    <img alt="Image placeholder" class="profile_pic_change_class" src="{{ asset(auth()->user()->profile_pic) }}" style="height: 39px; width: 39px;border-radius: 50%;border: 1px solid #989898;">
                                                </span>

                                            </div>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                                            <div class=" dropdown-header noti-title">
                                                <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                                            </div>
                                            @can('add orders')

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
                                            @endcan
                                            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                                <i class="ni ni-single-02"></i>
                                                <span>{{ __('My profile') }}</span>
                                            </a>
                                            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                                <i class="ni ni-user-run"></i>
                                                <span>{{ __('Logout') }}</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                    </div>
                </nav>
        </div>
    </div>

</div>


<script>
    // Create an EventSource to listen to the /email-updates SSE route
    const eventSource = new EventSource("{{ url('/email-updates-count') }}");
    const eventSourcenotify = new EventSource("{{ url('notifications/unread_count') }}");

    // Listen for messages (updates)
    eventSource.onmessage = function(event) {
        // Parse the data received from the server
        const data = JSON.parse(event.data);
    if(data.unreadCount == '0'){
        $('#unread-email-count22').hide();
    }else{
        // Update the unread email count in the navbar
        document.getElementById('unread-email-count22').innerText = data.unreadCount;
    }
    };

    // Optional: handle errors
    eventSource.onerror = function(error) {
        console.error('EventSource failed:', error);
        // $('.email-notifi-count').hide();
    };
    //for notification
    eventSourcenotify.onmessage = function(event) {
        // Parse the data received from the server
        const data2 = JSON.parse(event.data);
        if(data2.unreadCount > 0) {
                    $('.notifi-count').html(data2.unreadCount);
                    $('.notifications-count').html(('0'+data2.unreadCount).slice(-2));
        } else {
            $('.notifi-count').hide();
            $('.notifications-count').html('0');
        }
    };

    // Optional: handle errors
    eventSourcenotify.onerror = function(error) {
        console.error('EventSource failed:', error);
        // $('.email-notifi-count').hide();
    };
    $(document).ready(function(){


        var sidebar = localStorage.getItem('sidebar-collapse');

        if(sidebar == 'true'){
            $('.navbar-vertical.navbar-expand-md').addClass('navbar-minimize', 700);
            $('.navbar-vertical.navbar-expand-md').removeClass('navbar-maximize', 700);
            $('#maximize_icon').show();
            $('#logo_large').hide();
            $('#logo_samll').show();
            $('#minimize_icon').hide();

        } else {
            $('.navbar-vertical.navbar-expand-md').removeClass('navbar-minimize', 700);
            $('.navbar-vertical.navbar-expand-md').addClass('navbar-maximize', 700);
            $('#minimize_icon').show();
            $('#logo_large').show();
            $('#logo_samll').hide();
            $('#maximize_icon').hide();
        }
    });

    function getUnreadNotifiCount() {
        $.ajax({
            url:"{{ url('notifications/unread_count') }}/",
            method:'GET',
            dataType:'json',
            success: function (data){
                if(data > 0) {
                    $('.notifi-count').html(data);
                    $('.notifications-count').html(('0'+data).slice(-2));
                } else {
                    $('.notifi-count').hide();
                    $('.notifications-count').html('0');
                }
            }
        });
    }

    $('#minimize_icon').on('click', function(){
        $('.navbar-vertical.navbar-expand-md').addClass('navbar-minimize', 700);
        $('.navbar-vertical.navbar-expand-md').removeClass('navbar-maximize', 700);
        $('#maximize_icon').show();
        $('#logo_large').hide();
        $('#logo_samll').show();
        $(this).hide();

        localStorage.setItem('sidebar-collapse', true);
    });

    $('#maximize_icon').on('click', function(){
        $('.navbar-vertical.navbar-expand-md').removeClass('navbar-minimize', 700);
        $('.navbar-vertical.navbar-expand-md').addClass('navbar-maximize', 700);
        $('#minimize_icon').show();
        $('#logo_large').show();
        $('#logo_samll').hide();
        $(this).hide();

        localStorage.setItem('sidebar-collapse', false);
    });

    // Get the current hour
		var hour = new Date().getHours();

    // Set the greeting message based on the current hour
    var greeting;
    if (hour < 12) {
        greeting = "Good morning!";
    } else {
        greeting = "Good afternoon!";
    }

    // Display the greeting message in the HTML page
    document.getElementById("greeting").innerHTML = greeting;
</script>
