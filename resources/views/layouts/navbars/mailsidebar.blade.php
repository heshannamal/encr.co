
<!-- Bootstrap row -->
<div class="row" id="body-row">
    <!-- Sidebar -->
    <div id="sidebar-container" class="sidebar-expanded d-none d-md-block navbar-vertical">
        <!-- d-* hiddens the Sidebar in smaller devices. Its itens can be kept on the Navbar 'Menu' -->
        <!-- Bootstrap List Group -->
        <ul class="list-group">
            <!-- Separator with title -->
            <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
               <a class="navbar-brand pt-0" href="{{ route('home') }}">
                    <img src="{{ asset('argon') }}/img/encore/Logo2.png"  style="margin-left: -89px !important;"  class="navbar-brand-img" alt="...">
                </a>
            </li>
             </br></br>
            <!-- /END Separator -->
            <!-- Submenu content -->
            <a href="{{ route('home') }}" class="text-muted list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class=" fas fa-tv mr-3"></span>
                    <span class="menu-collapsed">Dashbord</span>
                </div>
            </a>
            
            <!-- /END Separator -->
           <a href="#contacts" data-toggle="collapse" aria-expanded="false" class="text-muted list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-user-circle fa-fw mr-3"></span>
                    <span class="menu-collapsed">Contacts</span>
                    <span class="nav-link-text"></span>
                </div>
            </a>
            <!-- Submenu content -->
            <div id='contacts' class="collapse sidebar-submenu">
                <a href="{{ route('people') }}" class="text-muted list-group-item list-group-item-action text-white">
                    <span class="menu-collapsed">People</span>
                </a>
                <a href="{{ route('organizations') }}" class="text-muted list-group-item list-group-item-action text-white">
                    <span class="menu-collapsed">Organizations</span>
                </a>
            </div>
            <a href="{{ route('orders') }}" class="text-muted list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-list-ul fa-fw mr-3"></span>
                    <span class="menu-collapsed">Orders</span>
                </div>
            </a>
            
            <a href="#masterSubMenu" data-toggle="collapse" aria-expanded="false" class="text-muted list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-crown fa-fw mr-3"></span>
                    <span class="menu-collapsed">Masters</span>
                    <span class="nav-link-text"></span>
                </div>
            </a>
            
            <!-- Submenu content -->
            <div id='masterSubMenu' class="collapse sidebar-submenu">
                <a href="{{ route('fabrics') }}" class="text-muted list-group-item list-group-item-action text-white">
                    <span class="menu-collapsed">Fabrics</span>
                </a>
                <a href="{{ route('products') }}" class="text-muted list-group-item list-group-item-action text-white">
                    <span class="menu-collapsed">Products</span>
                </a>
                <a href="{{ route('product_categories') }}" class="text-muted list-group-item list-group-item-action  text-white">
                    <span class="menu-collapsed">Product Categories</span>
                </a>
                <a href="{{ route('sizes') }}" class="text-muted list-group-item list-group-item-action text-white">
                    <span class="menu-collapsed">Sizes</span>
                </a>
                <a href="{{ route('embellishment_types') }}" class="text-muted list-group-item list-group-item-action text-white">
                    <span class="menu-collapsed">Embellishment Types</span>
                </a>
                <a href="{{ route('factories') }}" class="text-muted list-group-item list-group-item-action text-white">
                    <span class="menu-collapsed">Factories</span>
                </a>
            </div>
            
            <a href="#userSub" data-toggle="collapse" aria-expanded="false" class=" text-muted list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-user-circle fa-fw mr-3"></span>
                    <span class="menu-collapsed">Users & Privileges</span>
                    <span class="nav-link-text"></span>
                </div>
            </a>
            <!-- Submenu content -->
            <div id='userSub' class="collapse sidebar-submenu">
                <a href="{{ route('user_roles') }}" class=" text-muted list-group-item list-group-item-action text-white">
                    <span class="menu-collapsed">User Roles</span>
                </a>
                <a href="{{ route('user_groups') }}" class="text-muted list-group-item list-group-item-action text-white sub-padding">
                    <span class="menu-collapsed">User Groups</span>
                </a>
                <a href="{{ route('users') }}" class="list-group-item list-group-item-action text-white sub-padding">
                    <span class="menu-collapsed">Users</span>
                </a>
            </div>
            <a href="#top" data-toggle="sidebar-colapse" class="text-muted list-group-item list-group-item-action d-flex align-items-center">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span id="collapse-icon" class="fa fa-2x mr-3"></span>
                    <span id="collapse-text" class="menu-collapsed">Collapse</span>
                </div>
            </a>
        </ul>
    </div>
    <!-- MAIN -->
     <div class="col p-4">
        <div class="card">
            <div class="card-body">
               <div class="col-md-12 main">
                    <!--<iframe width='1080' id="myFrame" height='760' style="width: 100%;" src="https://enrichmeetup.com/webmailsetup/" frameborder="0" allowfullscreen></iframe>-->
                </div>
            </div>
        </div>
    </div><!-- Main Col END -->
</div><!-- body-row END -->
