@extends('layouts.app', ['activePage' => 'fileserver', 'titlePage' => __('File Store')])


@section('content')




    <link rel="stylesheet" href="{{ asset('fileserver-assets') }}/css/css-backend.min.css">
    <link rel="stylesheet" href="{{ asset('fileserver-assets') }}/css/css-all.min.css">
    <link rel="stylesheet" href="{{ asset('fileserver-assets') }}/css/css-line-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('fileserver-assets') }}/css/fonts-remixicon.css">

    <!-- Viewer Plugin -->
    <!--PDF-->
    <link rel="stylesheet" href="{{ asset('fileserver-assets') }}/css/pdf-pdf.viewer.css">
    <!--Docs-->
    <!--PPTX-->
    <link rel="stylesheet" href="{{ asset('fileserver-assets') }}/css/css-pptxjs.css">
    <link rel="stylesheet" href="{{ asset('fileserver-assets') }}/css/css-nv.d3.min.css">
    <!--All Spreadsheet -->
    <link rel="stylesheet" href="{{ asset('fileserver-assets') }}/css/SheetJS-handsontable.full.min.css">
    <!--Image viewer-->
    <link rel="stylesheet" href="{{ asset('fileserver-assets') }}/css/css-jquery.verySimpleImageViewer.css">
    <!--officeToHtml-->
    <link rel="stylesheet" href="{{ asset('fileserver-assets') }}/css/officeToHtml-officeToHtml.css">

    <!-- loader Start -->

    <!-- loader END -->
    <!-- Wrapper Start -->
    <div class="wrapper newStyles" style="margin-right: 25px; margin-left: 25px;border-radius: 13px;">

        <div class="iq-sidebar  sidebar-default " style="margin-top: 71px;background: #fafbfe; border: none !important;border-radius: 13px;">

            <div class="data-scrollbar" data-scroll="1">
                <div style="border-top: none;" class="new-create select-dropdown input-prepend input-append">
                    <div class="btn-group">
                        <label data-toggle="dropdown">
                            <div class="search-query selet-caption"><i class="las la-plus pr-2"></i>Create New</div><span
                                class="search-replace"></span>
                            <span class="caret">
                                <!--icon-->
                            </span>
                        </label>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="item"><i class="ri-folder-add-line pr-3"></i>New Folder</div>
                            </li>
                            <li>
                                <div class="item"><i class="ri-file-upload-line pr-3"></i>Upload Files</div>
                            </li>
                            <li>
                                <div class="item"><i class="ri-folder-upload-line pr-3"></i>Upload Folders</div>
                            </li>
                        </ul>
                    </div>
                </div>
                <nav class="iq-sidebar-menu">
                    <ul id="iq-sidebar-toggle" class="iq-menu">
                        
                        <li class="active">
                            <a href="#mydrive" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <i class="las la-hdd"></i><span>My Drive</span>
                                <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                                <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                            </a>
                            <ul id="mydrive" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                <li class=" ">
                                    <a href="page-alexa.html">
                                        <i class="lab la-blogger-b"></i><span>Folder 01</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="page-android.html">
                                        <i class="las la-share-alt"></i><span>Folder 02</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="page-brightspot.html">
                                        <i class="las la-icons"></i><span>Folder 03</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="page-ionic.html">
                                        <i class="las la-icons"></i><span>Folder 04</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class=" ">
                            <a href="page-files.html" class="">
                                <i class="lar la-file-alt iq-arrow-left"></i><span>Files</span>
                            </a>
                            <ul id="page-files" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                            </ul>
                        </li>
                        <li class=" ">
                            <a href="page-folders.html" class="">
                                <i class="las la-stopwatch iq-arrow-left"></i><span>Recent</span>
                            </a>
                            <ul id="page-folders" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                            </ul>
                        </li>
                        <li class=" ">
                            <a href="page-favourite.html" class="">
                                <i class="lar la-star"></i><span>Favourite</span>
                            </a>
                            <ul id="page-fevourite" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                            </ul>
                        </li>
                        <li class=" ">
                            <a href="page-delete.html" class="">
                                <i class="las la-trash-alt iq-arrow-left"></i><span>Trash</span>
                            </a>
                            <ul id="page-delete" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                            </ul>
                        </li>
                        {{-- <li class=" ">
                            <a href="#otherpage" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <i class="lab la-wpforms iq-arrow-left"></i><span>other page</span>
                                <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                                <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                            </a>
                            <ul id="otherpage" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                <li class=" ">
                                    <a href="#user" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                        <i class="las la-user-cog"></i><span>User Details</span>
                                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                                    </a>
                                    <ul id="user" class="iq-submenu collapse" data-parent="#otherpage">
                                        <li class=" ">
                                            <a href="user-profile.html">
                                                <i class="las la-id-card"></i><span>User Profile</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="user-add.html">
                                                <i class="las la-user-plus"></i><span>User Add</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="user-list.html">
                                                <i class="las la-list-alt"></i><span>User List</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class=" ">
                                    <a href="#ui" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                        <i class="lab la-uikit iq-arrow-left"></i><span>UI Elements</span>
                                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                                    </a>
                                    <ul id="ui" class="iq-submenu collapse" data-parent="#otherpage">
                                        <li class=" ">
                                            <a href="ui-avatars.html">
                                                <i class="las la-user-tie"></i><span>Avatars</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="ui-alerts.html">
                                                <i class="las la-exclamation-triangle"></i><span>Alerts</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="ui-badges.html">
                                                <i class="las la-id-badge"></i><span>Badges</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="ui-breadcrumb.html">
                                                <i class="las la-ellipsis-h"></i><span>Breadcrumb</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="ui-buttons.html">
                                                <i class="las la-ticket-alt"></i><span>Buttons</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="ui-buttons-group.html">
                                                <i class="las la-object-group"></i><span>Buttons Group</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="ui-boxshadow.html">
                                                <i class="las la-boxes"></i><span>Box Shadow</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="ui-colors.html">
                                                <i class="las la-brush"></i><span>Colors</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="ui-cards.html">
                                                <i class="las la-credit-card"></i><span>Cards</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="ui-carousel.html">
                                                <i class="las la-sliders-h"></i><span>Carousel</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="ui-grid.html">
                                                <i class="las la-th-large"></i><span>Grid</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="ui-helper-classes.html">
                                                <i class="las la-hands-helping"></i><span>Helper classes</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="ui-images.html">
                                                <i class="las la-image"></i><span>Images</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="ui-list-group.html">
                                                <i class="las la-list-alt"></i><span>list Group</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="ui-media-object.html">
                                                <i class="las la-photo-video"></i><span>Media</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="ui-modal.html">
                                                <i class="las la-columns"></i><span>Modal</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="ui-notifications.html">
                                                <i class="las la-bell"></i><span>Notifications</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="ui-pagination.html">
                                                <i class="las la-ellipsis-h"></i><span>Pagination</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="ui-popovers.html">
                                                <i class="las la-spinner"></i><span>Popovers</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="ui-progressbars.html">
                                                <i class="las la-heading"></i><span>Progressbars</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="ui-typography.html">
                                                <i class="las la-tablet"></i><span>Typography</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="ui-tabs.html">
                                                <i class="las la-tablet"></i><span>Tabs</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="ui-tooltips.html">
                                                <i class="las la-magnet"></i><span>Tooltips</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="ui-embed-video.html">
                                                <i class="las la-play-circle"></i><span>Video</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class=" ">
                                    <a href="#auth" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                        <i class="las la-torah iq-arrow-left"></i><span>Authentication</span>
                                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                                    </a>
                                    <ul id="auth" class="iq-submenu collapse" data-parent="#otherpage">
                                        <li class=" ">
                                            <a href="auth-sign-in.html">
                                                <i class="las la-sign-in-alt"></i><span>Login</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="auth-sign-up.html">
                                                <i class="las la-registered"></i><span>Register</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="auth-recoverpw.html">
                                                <i class="las la-unlock-alt"></i><span>Recover Password</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="auth-confirm-mail.html">
                                                <i class="las la-envelope-square"></i><span>Confirm Mail</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="auth-lock-screen.html">
                                                <i class="las la-lock"></i><span>Lock Screen</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class=" ">
                                    <a href="#pricing" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                        <i class="las la-coins"></i><span>Pricing</span>
                                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                                    </a>
                                    <ul id="pricing" class="iq-submenu collapse" data-parent="#otherpage">
                                        <li class=" ">
                                            <a href="pricing.html">
                                                <i class="las la-weight"></i><span>Pricing 1</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="pricing-2.html">
                                                <i class="las la-dna"></i><span>Pricing 2</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class=" ">
                                    <a href="#pages-error" class="collapsed" data-toggle="collapse"
                                        aria-expanded="false">
                                        <i class="las la-exclamation-triangle"></i><span>Error</span>
                                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                                    </a>
                                    <ul id="pages-error" class="iq-submenu collapse" data-parent="#otherpage">
                                        <li class=" ">
                                            <a href="pages-error.html">
                                                <i class="las la-bomb"></i><span>Error 404</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="pages-error-500.html">
                                                <i class="las la-exclamation-circle"></i><span>Error 500</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class=" ">
                                    <a href="pages-blank-page.html">
                                        <i class="las la-pager"></i><span>Blank Page</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="pages-maintenance.html">
                                        <i class="las la-cubes"></i><span>Maintenance</span>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}
                    </ul>
                </nav>

                <div class="p-3"></div>
            </div>
        </div>
        
        <div class="content-page" style="padding-top: 10px;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                    <div class="iq-search-bar device-search">

                        <form>
                            <div class="input-prepend input-append">
                                <div class="btn-group">
                                    <label class="dropdown-toggle searchbox" data-toggle="dropdown">
                                        <input class="dropdown-toggle search-query text search-input" type="text"
                                            placeholder="Type here to search..."><span class="search-replace"></span>
                                        <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                                        <span class="caret">
                                            <!--icon-->
                                        </span>
                                    </label>
                                    <ul class="dropdown-menu" style="z-index: 100;">
                                        <li><a href="#">
                                                <div class="item"><i class="far fa-file-pdf bg-info"></i>PDFs
                                                </div>
                                            </a></li>
                                        <li><a href="#">
                                                <div class="item"><i
                                                        class="far fa-file-alt bg-primary"></i>Documents</div>
                                            </a></li>
                                        <li><a href="#">
                                                <div class="item"><i
                                                        class="far fa-file-excel bg-success"></i>Spreadsheet</div>
                                            </a></li>
                                        <li><a href="#">
                                                <div class="item"><i
                                                        class="far fa-file-powerpoint bg-danger"></i>Presentation</div>
                                            </a></li>
                                        <li><a href="#">
                                                <div class="item"><i
                                                        class="far fa-file-image bg-warning"></i>Photos &amp; Images</div>
                                            </a></li>
                                        <li><a href="#">
                                                <div class="item"><i
                                                        class="far fa-file-video bg-info"></i>Videos</div>
                                            </a></li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>


                    <div class="col-lg-12">
                        <div class="card card-block card-stretch card-transparent ">
                            <div class="card-header d-flex justify-content-between pb-0">
                                <div class="header-title">
                                    <h4 class="card-title">Recent Documents</h4>
                                </div>
                                <div class="card-header-toolbar d-flex align-items-center">
                                    <a href="page-folders.html" class=" view-more">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body image-thumb">
                                <a href="#" data-title="Terms.pdf" data-load-file="file"
                                    data-load-target="#resolte-contaniner"
                                    data-url="../assets/vendor/doc-viewer/files/demo.pdf" data-toggle="modal"
                                    data-target="#exampleModal">
                                    <div class="mb-4 text-center p-3 rounded iq-thumb">
                                        <div class="iq-image-overlay"></div>
                                        <img src="{{ asset('fileserver-assets') }}/images/page-1-pdf.png"
                                            class="img-fluid" alt="image1">
                                    </div>
                                    <h6>Terms.pdf</h6>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body image-thumb">
                                <a href="#" data-title="New-one.docx" data-load-file="file"
                                    data-load-target="#resolte-contaniner"
                                    data-url="../assets/vendor/doc-viewer/files/demo.docx" data-toggle="modal"
                                    data-target="#exampleModal">
                                    <div class="mb-4 text-center p-3 rounded iq-thumb">
                                        <div class="iq-image-overlay"></div>
                                        <img src="{{ asset('fileserver-assets') }}/images/page-1-doc.png"
                                            class="img-fluid" alt="image1">
                                    </div>
                                    <h6>New-one.docx</h6>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body image-thumb">
                                <a href="#" data-title="Woo-box.xlsx" data-load-file="file"
                                    data-load-target="#resolte-contaniner"
                                    data-url="../assets/vendor/doc-viewer/files/demo.xlsx" data-toggle="modal"
                                    data-target="#exampleModal">
                                    <div class="mb-4 text-center p-3 rounded iq-thumb">
                                        <div class="iq-image-overlay"></div>
                                        <img src="{{ asset('fileserver-assets') }}/images/page-1-xlsx.png"
                                            class="img-fluid" alt="image1">
                                    </div>
                                    <h6>Woo-box.xlsx</h6>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body image-thumb doc-text">
                                <a href="#" data-title="IOS-content.pptx" data-load-file="file"
                                    data-load-target="#resolte-contaniner"
                                    data-url="../assets/vendor/doc-viewer/files/demo.pptx" data-toggle="modal"
                                    data-target="#exampleModal">
                                    <div class="mb-4 text-center p-3 rounded iq-thumb">
                                        <div class="iq-image-overlay"></div>
                                        <img src="{{ asset('fileserver-assets') }}/images/page-1-ppt.png"
                                            class="img-fluid" alt="image1">
                                    </div>
                                    <h6>IOS-content.pptx</h6>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card card-block card-stretch card-transparent">
                            <div class="card-header d-flex justify-content-between pb-0">
                                <div class="header-title">
                                    <h4 class="card-title">Folders</h4>
                                </div>
                                <div class="card-header-toolbar d-flex align-items-center">
                                    <div class="dropdown">
                                        <span class="dropdown-toggle dropdown-bg btn bg-white" id="dropdownMenuButton1"
                                            data-toggle="dropdown">
                                            Name<i class="ri-arrow-down-s-line ml-1"></i>
                                        </span>
                                        <div class="dropdown-menu dropdown-menu-right shadow-none"
                                            aria-labelledby="dropdownMenuButton1">
                                            <a class="dropdown-item" href="#">Last modified</a>
                                            <a class="dropdown-item" href="#">Last modifiedby me</a>
                                            <a class="dropdown-item" href="#">Last opened by me</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <a href="page-alexa.html" class="folder">
                                        <div class="icon-small bg-danger rounded mb-4">
                                            <i class="ri-file-copy-line"></i>
                                        </div>
                                    </a>
                                    <div class="card-header-toolbar">
                                        <div class="dropdown">
                                            <span class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown">
                                                <i class="ri-more-2-fill"></i>
                                            </span>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                aria-labelledby="dropdownMenuButton2">
                                                <a class="dropdown-item" href="#"><i
                                                        class="ri-eye-fill mr-2"></i>View</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="ri-pencil-fill mr-2"></i>Edit</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="ri-printer-fill mr-2"></i>Print</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="ri-file-download-fill mr-2"></i>Download</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="page-alexa.html" class="folder">
                                    <h5 class="mb-2">Folder 01</h5>
                                    <p class="mb-2"><i class="lar la-clock text-danger mr-2 font-size-20"></i>
                                        10 Dec, 2020</p>
                                    <p class="mb-0"><i
                                            class="las la-file-alt text-danger mr-2 font-size-20"></i> 08 Files</p>
                                </a>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <a href="page-android.html" class="folder">
                                        <div class="icon-small bg-primary rounded mb-4">
                                            <i class="ri-file-copy-line"></i>
                                        </div>
                                    </a>
                                    <div class="card-header-toolbar">
                                        <div class="dropdown">
                                            <span class="dropdown-toggle" id="dropdownMenuButton3" data-toggle="dropdown">
                                                <i class="ri-more-2-fill"></i>
                                            </span>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                aria-labelledby="dropdownMenuButton3">
                                                <a class="dropdown-item" href="#"><i
                                                        class="ri-eye-fill mr-2"></i>View</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="ri-pencil-fill mr-2"></i>Edit</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="ri-printer-fill mr-2"></i>Print</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="ri-file-download-fill mr-2"></i>Download</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="page-android.html" class="folder">
                                    <h5 class="mb-2">Folder 02</h5>
                                    <p class="mb-2"><i class="lar la-clock text-primary mr-2 font-size-20"></i>
                                        09 Dec, 2020</p>
                                    <p class="mb-0"><i
                                            class="las la-file-alt text-primary mr-2 font-size-20"></i> 08 Files</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <a href="page-brightspot.html" class="folder">
                                        <div class="icon-small bg-info rounded mb-4">
                                            <i class="ri-file-copy-line"></i>
                                        </div>
                                    </a>
                                    <div class="card-header-toolbar">
                                        <div class="dropdown">
                                            <span class="dropdown-toggle" id="dropdownMenuButton4" data-toggle="dropdown">
                                                <i class="ri-more-2-fill"></i>
                                            </span>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                aria-labelledby="dropdownMenuButton4">
                                                <a class="dropdown-item" href="#"><i
                                                        class="ri-eye-fill mr-2"></i>View</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="ri-pencil-fill mr-2"></i>Edit</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="ri-printer-fill mr-2"></i>Print</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="ri-file-download-fill mr-2"></i>Download</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="page-brightspot.html" class="folder">
                                    <h5 class="mb-2">Folder 03</h5>
                                    <p class="mb-2"><i class="lar la-clock text-info mr-2 font-size-20"></i> 07
                                        Dec, 2020</p>
                                    <p class="mb-0"><i class="las la-file-alt text-info mr-2 font-size-20"></i>
                                        08 Files</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <a href="page-ionic.html" class="folder">
                                        <div class="icon-small bg-success rounded mb-4">
                                            <i class="ri-file-copy-line"></i>
                                        </div>
                                    </a>
                                    <div class="card-header-toolbar">
                                        <div class="dropdown">
                                            <span class="dropdown-toggle" id="dropdownMenuButton5" data-toggle="dropdown">
                                                <i class="ri-more-2-fill"></i>
                                            </span>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                aria-labelledby="dropdownMenuButton5">
                                                <a class="dropdown-item" href="#"><i
                                                        class="ri-eye-fill mr-2"></i>View</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="ri-pencil-fill mr-2"></i>Edit</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="ri-printer-fill mr-2"></i>Print</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="ri-file-download-fill mr-2"></i>Download</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="page-ionic.html" class="folder">
                                    <h5 class="mb-2">Folder 04</h5>
                                    <p class="mb-2"><i class="lar la-clock text-success mr-2 font-size-20"></i>
                                        06 Dec, 2020</p>
                                    <p class="mb-0"><i
                                            class="las la-file-alt text-success mr-2 font-size-20"></i> 08 Files</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xl-12">
                        <div class="card card-block card-stretch card-height files-table">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Files</h4>
                                </div>
                                <div class="card-header-toolbar d-flex align-items-center">
                                    <a href="page-files.html" class=" view-more">View All</a>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-borderless tbl-server-info">
                                        <thead>
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Members</th>
                                                <th scope="col">Last Edit</th>
                                                <th scope="col">Size</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon-small bg-danger rounded mr-3">
                                                            <i class="ri-file-excel-line"></i>
                                                        </div>
                                                        <div data-load-file="file" data-load-target="#resolte-contaniner"
                                                            data-url="../assets/vendor/doc-viewer/files/demo.pdf"
                                                            data-toggle="modal" data-target="#exampleModal"
                                                            data-title="Weekly-report.pdf" style="cursor: pointer;">
                                                            Weekly-report.pdf</div>
                                                    </div>
                                                </td>
                                                <td>Me</td>
                                                <td>jan 21, 2020 me</td>
                                                <td>02 MB</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <span class="dropdown-toggle" id="dropdownMenuButton6"
                                                            data-toggle="dropdown">
                                                            <i class="ri-more-fill"></i>
                                                        </span>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                            aria-labelledby="dropdownMenuButton6">
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-eye-fill mr-2"></i>View</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-pencil-fill mr-2"></i>Edit</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-printer-fill mr-2"></i>Print</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-file-download-fill mr-2"></i>Download</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="active">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon-small bg-primary rounded mr-3">
                                                            <i class="ri-file-download-line"></i>
                                                        </div>
                                                        <div data-load-file="file" data-load-target="#resolte-contaniner"
                                                            data-url="../assets/vendor/doc-viewer/files/demo.pdf"
                                                            data-toggle="modal" data-target="#exampleModal"
                                                            data-title="VueJs.pdf" style="cursor: pointer;">VueJs.pdf</div>
                                                    </div>
                                                </td>
                                                <td>Poul Molive</td>
                                                <td>jan 25, 2020 Poul Molive</td>
                                                <td>64 MB</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <span class="dropdown-toggle" id="dropdownMenuButton7"
                                                            data-toggle="dropdown">
                                                            <i class="ri-more-fill"></i>
                                                        </span>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                            aria-labelledby="dropdownMenuButton7">
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-eye-fill mr-2"></i>View</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-pencil-fill mr-2"></i>Edit</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-printer-fill mr-2"></i>Print</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-file-download-fill mr-2"></i>Download</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon-small bg-info rounded mr-3">
                                                            <i class="ri-file-excel-line"></i>
                                                        </div>
                                                        <div data-load-file="file" data-load-target="#resolte-contaniner"
                                                            data-url="../assets/vendor/doc-viewer/files/demo.docx"
                                                            data-toggle="modal" data-target="#exampleModal"
                                                            data-title="Milestone.docx" style="cursor: pointer;">
                                                            Milestone.docx</div>
                                                    </div>
                                                </td>
                                                <td>Me</td>
                                                <td>Mar 30, 2020 Gail Forcewind</td>
                                                <td>30 MB</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <span class="dropdown-toggle" id="dropdownMenuButton8"
                                                            data-toggle="dropdown">
                                                            <i class="ri-more-fill"></i>
                                                        </span>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                            aria-labelledby="dropdownMenuButton8">
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-eye-fill mr-2"></i>View</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-pencil-fill mr-2"></i>Edit</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-printer-fill mr-2"></i>Print</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-file-download-fill mr-2"></i>Download</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon-small bg-success rounded mr-3">
                                                            <i class="ri-file-excel-line"></i>
                                                        </div>
                                                        <div data-load-file="file" data-load-target="#resolte-contaniner"
                                                            data-url="../assets/vendor/doc-viewer/files/demo.xlsx"
                                                            data-toggle="modal" data-target="#exampleModal"
                                                            data-title="Training center.xlsx" style="cursor: pointer;">
                                                            Training center.xlsx</div>
                                                    </div>
                                                </td>
                                                <td>Me</td>
                                                <td>Mar 30, 2020 Gail Forcewind</td>
                                                <td>10 MB</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <span class="dropdown-toggle" id="dropdownMenuButton9"
                                                            data-toggle="dropdown">
                                                            <i class="ri-more-fill"></i>
                                                        </span>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                            aria-labelledby="dropdownMenuButton9">
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-eye-fill mr-2"></i>View</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-pencil-fill mr-2"></i>Edit</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-printer-fill mr-2"></i>Print</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-file-download-fill mr-2"></i>Download</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon-small bg-warning rounded mr-3">
                                                            <i class="ri-file-excel-line"></i>
                                                        </div>
                                                        <div data-load-file="file" data-load-target="#resolte-contaniner"
                                                            data-url="../assets/vendor/doc-viewer/files/demo.pptx"
                                                            data-toggle="modal" data-target="#exampleModal"
                                                            data-title="Flavour.pptx" style="cursor: pointer;">Flavour.pptx
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Me</td>
                                                <td>Mar 30, 2020 Gail Forcewind</td>
                                                <td>10 MB</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <span class="dropdown-toggle" id="dropdownMenuButton9"
                                                            data-toggle="dropdown">
                                                            <i class="ri-more-fill"></i>
                                                        </span>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                            aria-labelledby="dropdownMenuButton9">
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-eye-fill mr-2"></i>View</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-pencil-fill mr-2"></i>Edit</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-printer-fill mr-2"></i>Print</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-file-download-fill mr-2"></i>Download</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br>



                </div>
            </div>
        </div>
    </div>
    <!-- Wrapper End-->
    
    <!-- Backend Bundle JavaScript -->
    <script src="{{ asset('fileserver-assets') }}/js/js-backend-bundle.min.js"></script>

    <!-- Chart Custom JavaScript -->
    <script src="{{ asset('fileserver-assets') }}/js/js-customizer.js"></script>

    <!-- Chart Custom JavaScript -->
    <script src="{{ asset('fileserver-assets') }}/js/js-chart-custom.js"></script>

    <!--PDF-->
    <script src="{{ asset('fileserver-assets') }}/js/pdf-pdf.js"></script>
    <!--Docs-->
    <script src="{{ asset('fileserver-assets') }}/js/docx-jszip-utils.js"></script>
    <script src="{{ asset('fileserver-assets') }}/js/docx-mammoth.browser.min.js"></script>
    <!--PPTX-->
    <script src="{{ asset('fileserver-assets') }}/js/js-filereader.js"></script>
    <script src="{{ asset('fileserver-assets') }}/js/js-d3.min.js"></script>
    <script src="{{ asset('fileserver-assets') }}/js/js-nv.d3.min.js"></script>
    <script src="{{ asset('fileserver-assets') }}/js/js-pptxjs.js"></script>
    <script src="{{ asset('fileserver-assets') }}/js/js-divs2slides.js"></script>
    <!--All Spreadsheet -->
    <script src="{{ asset('fileserver-assets') }}/js/SheetJS-handsontable.full.min.js"></script>
    <script src="{{ asset('fileserver-assets') }}/js/SheetJS-xlsx.full.min.js"></script>
    <!--Image viewer-->
    <script src="{{ asset('fileserver-assets') }}/js/js-jquery.verySimpleImageViewer.js"></script>
    <!--officeToHtml-->
    <script src="{{ asset('fileserver-assets') }}/js/officeToHtml-officeToHtml.js"></script>
    <script src="{{ asset('fileserver-assets') }}/js/js-doc-viewer.js"></script>
    <!-- app JavaScript -->
    <script src="{{ asset('fileserver-assets') }}/js/js-app.js"></script>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Title</h4>
                    <div>
                        <a class="btn" data-dismiss="modal" aria-label="Close" href="backend.html">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                </div>
                <div class="modal-body">
                    <div id="resolte-contaniner" style="height: 500px;" class="overflow-auto">
                        File not found
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
