<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Encroms</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->


    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    
    <style>
        #body-row {
    margin-left:0;
    margin-right:0;
    }
    #sidebar-container {
        min-height: 100vh;   
        background-color: white;
        padding: 0;
    }
    
    /* Sidebar sizes when expanded and expanded */
    .sidebar-expanded {
        width: 230px;
    }
    .sidebar-collapsed {
        width: 60px;
    }
    
    /* Menu item*/
    #sidebar-container .list-group a {
        height: 50px;
        color: white;
    }
    
    /* Submenu item*/
    #sidebar-container .list-group .sidebar-submenu a {
        height: 45px;
        padding-left: 28%;
    }
    .sidebar-submenu {
        font-size: 0.9rem;
    }
    
    .navbar-vertical {
         box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15) !important;
    }

    /* Separators */
    .sidebar-separator-title {
        background-color: #3330;
        height: 135px;
    }
    .sidebar-separator {
        background-color: #333;
        height: 25px;
    }
    .logo-separator {
        background-color: #333;    
        height: 60px;
    }
    
    /* Closed submenu icon */
    #sidebar-container .list-group .list-group-item[aria-expanded="false"] .submenu-icon::after {
      content: " \f0d7";
      font-family: FontAwesome;
      display: inline;
      text-align: right;
      padding-left: 10px;
    }
    /* Opened submenu icon */
    #sidebar-container .list-group .list-group-item[aria-expanded="true"] .submenu-icon::after {
      content: " \f0da";
      font-family: FontAwesome;
      display: inline;
      text-align: right;
      padding-left: 10px;
    }
    
    .list-group-item{
         border: 0px solid rgba(0,0,0,.125) !important;   
    }
    
    .card-body {
       padding:0 !important;   
    }
    </style>
</head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
             @include('layouts.navbars.mailsidebar')
        @endauth
   
        <div class="main-content">
          
            @include('layouts.footers.auth')
        </div>

        @guest()
            @include('layouts.footers.guest')
        @endguest

        <!-- jQuery CDN - Slim version (=without AJAX) -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <!-- Popper.JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
        
        <script>
            SidebarCollapse();
            
            // Hide submenus
            $('#body-row .collapse').collapse('hide'); 
            
            // Collapse/Expand icon
            $('#collapse-icon').addClass('fa-angle-double-left'); 
            
            // Collapse click
             $('[data-toggle=sidebar-colapse]').click(function() {
                SidebarCollapse();
              });
            
            function SidebarCollapse () {
                $('.menu-collapsed').toggleClass('d-none');
                $('.sidebar-submenu').toggleClass('d-none');
                $('.submenu-icon').toggleClass('d-none');
                $('#sidebar-container').toggleClass('sidebar-expanded sidebar-collapsed');
                
                // Treating d-flex/d-none on separators with title
                var SeparatorTitle = $('.sidebar-separator-title');
                if ( SeparatorTitle.hasClass('d-flex') ) {
                    SeparatorTitle.removeClass('d-flex');
                } else {
                    SeparatorTitle.addClass('d-flex');
                }
                
                // Collapse/Expand icon
                $('#collapse-icon').toggleClass('fa-angle-double-left fa-angle-double-right');
            }
        </script>
    </body>
</html>
