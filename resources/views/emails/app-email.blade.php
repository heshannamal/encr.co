@extends('layouts.appLayout-email', ['activePage' => 'Mail', 'titlePage' => __('Mail')])
@include('emails.email-compose')
@section('mailsidebarcontent')
<div class="email-side-list"  style="background-color: #212529">
    <div class="compose-button" style="position: relative; margin-bottom: 50px;">
        <a href="#staticBackdrop" onclick="toggleCompose(event)"  title="Compose" class="btn-green-filled font-size-15 " style="text-align:center; position:fixed" >

                <i data-feather="edit" class="font-medium-2 mr-50"></i>&nbsp;&nbsp;COMPOSE

        </a>


    </div>
    <div class="email-menu-list" style="position: fixed; display: contents;">
        @foreach($sidebarItems as $sidebarItem)
            @if($sidebarItem['displayName'] == 'Inbox')
                @php
                    $customClass = "";
                    if ($showType === $sidebarItem['id']) {
                        $customClass = "activeItem";
                    }
                @endphp
                <a href="#" class="email-item {{ $customClass }}" onclick="toggleCollapse('{{ $sidebarItem['id'] }}')">

                    {{-- <i data-feather="check" class="font-medium-3 mr-50"></i> --}}
                    {{-- <i data-feather="chevron-right" class="font-medium-2 float-right mt-1"></i> --}}
                    <span class="align-middle" onclick="callViewmail(event, '{{ $sidebarItem['id'] }}','{{ $sidebarItem['displayName'] }}')">{{ $sidebarItem['displayName'] }}</span>
                    <span class="float-right" style="font-size: 12px;">{{ $sidebarItem['unreadItemCount'] }}/{{ $sidebarItem['totalItemCount'] }}</span>
                </a>

                @if(!empty($sidebarItem['childFolders']))
                    <div id="{{ $sidebarItem['id'] }}" class="collapse">
                        @foreach($sidebarItem['childFolders'] as $sidebarSubItem)
                            <a href="#" class="email-item" style="font-size: 0.65rem" onclick="callViewmail(event, '{{ $sidebarSubItem['id'] }}','{{ $sidebarSubItem['displayName'] }}')">
                                {{-- <i data-feather="check" class="font-medium-3 mr-50"></i> --}}
                                <span class="align-middle">{{ $sidebarSubItem['displayName'] }}</span>
                                <span class="float-right" style="font-size: 12px;">{{ $sidebarSubItem['unreadItemCount'] }}/{{ $sidebarSubItem['totalItemCount'] }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            @endif
        @endforeach
        @foreach($sidebarItems as $sidebarItem)
            @if($sidebarItem['displayName'] == 'Sent Items')
                @php
                    $customClass = "";
                    if ($showType === $sidebarItem['id']) {
                        $customClass = "activeItem";
                    }
                @endphp
                <a href="#" class="email-item {{ $customClass }}" onclick="toggleCollapse('{{ $sidebarItem['id'] }}')">

                    {{-- <i data-feather="check" class="font-medium-3 mr-50"></i> --}}
                    {{-- <i data-feather="chevron-right" class="font-medium-2 float-right mt-1"></i> --}}
                    <span class="align-middle" onclick="callViewmail(event, '{{ $sidebarItem['id'] }}','{{ $sidebarItem['displayName'] }}')">{{ $sidebarItem['displayName'] }}</span>
                    <span class="float-right" style="font-size: 12px;">{{ $sidebarItem['unreadItemCount'] }}/{{ $sidebarItem['totalItemCount'] }}</span>
                </a>

                @if(!empty($sidebarItem['childFolders']))
                    <div id="{{ $sidebarItem['id'] }}" class="collapse">
                        @foreach($sidebarItem['childFolders'] as $sidebarSubItem)
                            <a href="#" class="email-item" style="font-size: 0.65rem" onclick="callViewmail(event, '{{ $sidebarSubItem['id'] }}','{{ $sidebarSubItem['displayName'] }}')">
                                {{-- <i data-feather="check" class="font-medium-3 mr-50"></i> --}}
                                <span class="align-middle">{{ $sidebarSubItem['displayName'] }}</span>
                                <span class="float-right" style="font-size: 12px;">{{ $sidebarSubItem['unreadItemCount'] }}/{{ $sidebarSubItem['totalItemCount'] }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            @endif
        @endforeach
        @foreach($sidebarItems as $sidebarItem)
            @if($sidebarItem['displayName'] == 'Drafts')
                @php
                    $customClass = "";
                    if ($showType === $sidebarItem['id']) {
                        $customClass = "activeItem";
                    }
                @endphp
                <a href="#" class="email-item {{ $customClass }}" onclick="toggleCollapse('{{ $sidebarItem['id'] }}')">

                    {{-- <i data-feather="check" class="font-medium-3 mr-50"></i> --}}
                    {{-- <i data-feather="chevron-right" class="font-medium-2 float-right mt-1"></i> --}}
                    <span class="align-middle" onclick="callViewmail(event, '{{ $sidebarItem['id'] }}','{{ $sidebarItem['displayName'] }}')">{{ $sidebarItem['displayName'] }}</span>
                    <span class="float-right" style="font-size: 12px;">{{ $sidebarItem['unreadItemCount'] }}/{{ $sidebarItem['totalItemCount'] }}</span>
                </a>

                @if(!empty($sidebarItem['childFolders']))
                    <div id="{{ $sidebarItem['id'] }}" class="collapse">
                        @foreach($sidebarItem['childFolders'] as $sidebarSubItem)
                            <a href="#" class="email-item" style="font-size: 0.65rem" onclick="callViewmail(event, '{{ $sidebarSubItem['id'] }}','{{ $sidebarSubItem['displayName'] }}')">
                                {{-- <i data-feather="check" class="font-medium-3 mr-50"></i> --}}
                                <span class="align-middle">{{ $sidebarSubItem['displayName'] }}</span>
                                <span class="float-right" style="font-size: 12px;">{{ $sidebarSubItem['unreadItemCount'] }}/{{ $sidebarSubItem['totalItemCount'] }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            @endif
        @endforeach
        @foreach($sidebarItems as $sidebarItem)
            @if($sidebarItem['displayName'] == 'Junk Email')
                @php
                    $customClass = "";
                    if ($showType === $sidebarItem['id']) {
                        $customClass = "activeItem";
                    }
                @endphp
                <a href="#" class="email-item {{ $customClass }}" onclick="toggleCollapse('{{ $sidebarItem['id'] }}')">

                    {{-- <i data-feather="check" class="font-medium-3 mr-50"></i> --}}
                    {{-- <i data-feather="chevron-right" class="font-medium-2 float-right mt-1"></i> --}}
                    <span class="align-middle" onclick="callViewmail(event, '{{ $sidebarItem['id'] }}','{{ $sidebarItem['displayName'] }}')">{{ $sidebarItem['displayName'] }}</span>
                    <span class="float-right" style="font-size: 12px;">{{ $sidebarItem['unreadItemCount'] }}/{{ $sidebarItem['totalItemCount'] }}</span>
                </a>

                @if(!empty($sidebarItem['childFolders']))
                    <div id="{{ $sidebarItem['id'] }}" class="collapse">
                        @foreach($sidebarItem['childFolders'] as $sidebarSubItem)
                            <a href="#" class="email-item" style="font-size: 0.65rem" onclick="callViewmail(event, '{{ $sidebarSubItem['id'] }}','{{ $sidebarSubItem['displayName'] }}')">
                                {{-- <i data-feather="check" class="font-medium-3 mr-50"></i> --}}
                                <span class="align-middle">{{ $sidebarSubItem['displayName'] }}</span>
                                <span class="float-right" style="font-size: 12px;">{{ $sidebarSubItem['unreadItemCount'] }}/{{ $sidebarSubItem['totalItemCount'] }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            @endif
        @endforeach

        @foreach($sidebarItems as $sidebarItem)
            @if (!in_array($sidebarItem['displayName'], ['Inbox', 'Drafts', 'Sent Items', 'Junk Email']))
                @php
                    $customClass = "";
                    if ($showType === $sidebarItem['id']) {
                        $customClass = "activeItem";
                    }
                @endphp
                <a href="#" class="email-item {{ $customClass }}" onclick="toggleCollapse('{{ $sidebarItem['id'] }}')" >

                    {{-- <i data-feather="check" class="font-medium-3 mr-50"></i> --}}
                    {{-- <i data-feather="chevron-right" class="font-medium-2 float-right mt-1"></i> --}}


                    <span class="align-middle" onclick="callViewmail(event, '{{ $sidebarItem['id'] }}','{{ $sidebarItem['displayName'] }}')">{{ $sidebarItem['displayName'] }}</span>
                    @if(!empty($sidebarItem['childFolders']))
                    <i data-feather="chevron-right" class="font-medium-2  " id="main_{{ $sidebarItem['id'] }}"></i>
                    @endif
                    <span class="float-right" style="font-size: 12px;">{{ $sidebarItem['unreadItemCount'] }}/{{ $sidebarItem['totalItemCount'] }}</span>
                </a>

                @if(!empty($sidebarItem['childFolders']))
                    <div id="{{ $sidebarItem['id'] }}" class="collapse">
                        @foreach($sidebarItem['childFolders'] as $sidebarSubItem)
                            <a href="#" class="email-item" style="font-size: 0.65rem" onclick="callViewmail(event, '{{ $sidebarSubItem['id'] }}','{{ $sidebarSubItem['displayName'] }}')">
                                {{-- <i data-feather="check" class="font-medium-3 mr-50"></i> --}}
                                <span class="align-middle " style="margin-left: 18px">{{ $sidebarSubItem['displayName'] }}</span>
                                <span class="float-right" style="font-size: 12px;">{{ $sidebarSubItem['unreadItemCount'] }}/{{ $sidebarSubItem['totalItemCount'] }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            @endif
        @endforeach

        <script>
            function toggleCollapse(itemId) {
                var collapseElement = document.getElementById(itemId);
                var iconElement = document.getElementById('main_'.itemId);
                // var iconElement = main_collapseElement.querySelector('svg');
console.log(iconElement);
                // Toggle the 'show' class on the collapse element
                collapseElement.classList.toggle('show');

                // Toggle the icon based on whether the collapse element is shown or hidden
                if (collapseElement.classList.contains('show')) {
                    // If the collapse element is shown, change the icon to 'chevron-down'
                    iconElement.classList.remove('feather-chevron-right');
                    iconElement.classList.add('feather-chevron-down');
                } else {
                    // If the collapse element is hidden, change the icon to 'chevron-right'
                    iconElement.classList.remove('feather-chevron-down');
                    iconElement.classList.add('feather-chevron-right');
                }
            }
        </script>
    </div>
  </div>
@endsection
@section('content')

        <link rel="apple-touch-icon" href="{{ asset('email-assets') }}/app-assets/images/ico/apple-icon-120.png">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('email-assets') }}/app-assets/images/ico/favicon.ico">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
            rel="stylesheet">

        <!-- BEGIN: Vendor CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('email-assets') }}/app-assets/vendors/css/vendors.min.css">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('email-assets') }}/app-assets/vendors/css/editors/quill/katex.min.css">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('email-assets') }}/app-assets/vendors/css/editors/quill/monokai-sublime.min.css">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('email-assets') }}/app-assets/vendors/css/editors/quill/quill.snow.css">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('email-assets') }}/app-assets/vendors/css/extensions/toastr.min.css">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('email-assets') }}/app-assets/vendors/css/forms/select/select2.min.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="stylesheet" type="text/css"
            href="https://fonts.googleapis.com/css2?family=Inconsolata&amp;family=Roboto+Slab&amp;family=Slabo+27px&amp;family=Sofia&amp;family=Ubuntu+Mono&amp;display=swap">
        <!-- END: Vendor CSS-->

        <!-- BEGIN: Theme CSS-->

        <link rel="stylesheet" type="text/css" href="{{ asset('email-assets') }}/app-assets/css/bootstrap-extended.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('email-assets') }}/app-assets/css/colors.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('email-assets') }}/app-assets/css/components.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('email-assets') }}/app-assets/css/themes/dark-layout.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('email-assets') }}/app-assets/css/themes/bordered-layout.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('email-assets') }}/app-assets/css/themes/semi-dark-layout.css">

        <!-- BEGIN: Page CSS-->
        <link rel="stylesheet" type="text/css"
            href="{{ asset('email-assets') }}/app-assets/css/core/menu/menu-types/vertical-menu.css">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('email-assets') }}/app-assets/css/plugins/forms/form-quill-editor.css">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('email-assets') }}/app-assets/css/plugins/extensions/ext-component-toastr.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('email-assets') }}/app-assets/css/pages/app-email.css">
        <!-- END: Page CSS-->

        <!-- BEGIN: Custom CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('email-assets') }}/assets/css/style.css">
        <!-- END: Custom CSS-->

        <!-- BEGIN: editor CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('argon') }}/css/editor.css">
        <!-- END: editor CSS-->
    <style>
        ..circlemax{
            z-index:99;
        }

        .compose-button{
            padding-top: 60px;
            align-items: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .mail-sidebar{

            z-index: -10;
        }
        .email-menu-list{

            padding-top: 30px;
            padding-bottom: 20%;
            position: fixed;
            min-width:12%;
        }
        .btn-green-filled{
            outline: unset !important;
            width: 140px;
            padding:.4rem 1rem;
            margin-bottom: 30px;
            color: white;
            background-color: #47D6B6;
            border: 2px solid #47D6B6;
            font-weight: 700;
            font-size: .8rem;
            cursor: pointer;

        }
        .btn-green-filled:hover{
            text-decoration: none;
            color: rgb(235, 235, 235) !important;
        }
        .email-item-list{
            height: 50px;
            margin: auto;


        }
        .email-item:hover{

            background-color: rgba(255, 255, 255, 0.05);
            color: rgba(179, 70, 70, 1) !important;
        }
        .activeItem{
            background-color: rgba(255, 255, 255, 0.05);
            color: rgba(179, 70, 70, 1) !important;
        }
        .email-item{


            padding: 2%;
            color:rgb(112 113 114);
            font-weight: 700;
            font-size: .75rem;
            margin-top: 6px;
            margin-bottom: 6px;
            display: block;

        }
        .email-side-list{
            padding-left: 1%;
            padding-right: 1%;
            padding-top: 30px;
            min-width: 15%;
            height:120%;
        }
        .body-email{
            background-color: #f7f7f7;
            margin-bottom: 80px;
            height:600px;
        }
        .body-email-header{
            background-color: #ffffff;
            margin-bottom: 80px;
            height:600px;
            flex-direction: column;
            flex-wrap: nowrap;
        }
        .btn-logout {
            border: 2px solid #cacaca;
            background-color: #f7f7f7;
            color: #cacaca;
            padding: 7px 15px;
            font-size: 12px;
            cursor: pointer;
            }
        .square-button:hover {
            /* Reset any hover styles to their default values */
            background-color: initial !important; /* Reset the background color */
            color: initial !important; /* Reset the text color */
            /* Add any other styles you want to reset on hover */
        }
        #btnNext i.fa.fa-chevron-right {
            margin-right: 0px;
        }
        form{
            display: inline;
        }
        .delete-action{
            margin-left: 10px;
            /* display: none; */
        }



  @supports (-webkit-appearance: none) or (-moz-appearance: none) {
    .checkbox-wrapper-13 input[type=checkbox] {
      --active: #275EFE;
      --active-inner: #fff;
      --focus: 2px rgba(39, 94, 254, .3);
      --border: #BBC1E1;
      --border-hover: #275EFE;
      --background: #fff;
      --disabled: #F6F8FF;
      --disabled-inner: #E1E6F9;
      -webkit-appearance: none;
      -moz-appearance: none;
      height: 21px;
      outline: none;
      display: inline-block;
      vertical-align: top;
      position: relative;
      margin: 0;
      cursor: pointer;
      border: 1px solid var(--bc, var(--border));
      background: var(--b, var(--background));
      transition: background 0.3s, border-color 0.3s, box-shadow 0.2s;
    }
    .checkbox-wrapper-13 input[type=checkbox]:after {
      content: "";
      display: inline;
      left: 0;
      top: 0;
      position: absolute;
      transition: transform var(--d-t, 0.3s) var(--d-t-e, ease), opacity var(--d-o, 0.2s);
    }
    .checkbox-wrapper-13 input[type=checkbox]:checked {
      --b: var(--active);
      --bc: var(--active);
      --d-o: .3s;
      --d-t: .6s;
      --d-t-e: cubic-bezier(.2, .85, .32, 1.2);
    }
    .checkbox-wrapper-13 input[type=checkbox]:disabled {
      --b: var(--disabled);
      cursor: not-allowed;
      opacity: 0.9;
    }
    .checkbox-wrapper-13 input[type=checkbox]:disabled:checked {
      --b: var(--disabled-inner);
      --bc: var(--border);
    }
    .checkbox-wrapper-13 input[type=checkbox]:disabled + label {
      cursor: not-allowed;
    }
    .checkbox-wrapper-13 input[type=checkbox]:hover:not(:checked):not(:disabled) {
      --bc: var(--border-hover);
    }
    .checkbox-wrapper-13 input[type=checkbox]:focus {
      box-shadow: 0 0 0 var(--focus);
    }
    .checkbox-wrapper-13 input[type=checkbox]:not(.switch) {
      width: 21px;
    }
    .checkbox-wrapper-13 input[type=checkbox]:not(.switch):after {
      opacity: var(--o, 0);
    }
    .checkbox-wrapper-13 input[type=checkbox]:not(.switch):checked {
      --o: 1;
    }
    .checkbox-wrapper-13 input[type=checkbox] + label {
      display: inline-block;
      vertical-align: middle;
      cursor: pointer;
      margin-left: 4px;
    }

    .checkbox-wrapper-13 input[type=checkbox]:not(.switch) {
      border-radius: 2px;
    }
    .checkbox-wrapper-13 input[type=checkbox]:not(.switch):after {
      width: 5px;
      height: 9px;
      border: 2px solid var(--active-inner);
      border-top: 0;
      border-left: 0;
      left: 7px;
      top: 4px;
      transform: rotate(var(--r, 20deg));
    }
    .checkbox-wrapper-13 input[type=checkbox]:not(.switch):checked {
      --r: 43deg;
    }
  }

  .checkbox-wrapper-13 * {
    box-sizing: inherit;
  }
  .checkbox-wrapper-13 *:before,
  .checkbox-wrapper-13 *:after {
    box-sizing: inherit;
  }
  .marglef{
    margin-left: 1.5rem !important;
  }
  .emailItem:hover{
    background-color: rgba(221, 221, 221, 0.3)
  }
  .emailItem{
    padding-left: 15px;
    padding-right: 15px;
    border-radius: 5px;
  }
  .IconColor{
    color: #3b3b3b
  }
  .IconDiv{
    margin-left: 10px;
    display: inline !important;
  }
  .btncolor{
    background-color: transparent;
  }
  .dot {
    height: 39px;
    width: 39px;
    background-color: #a6a4fff5;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .white-text {
    color: rgb(60, 96, 255);
    font-weight: bold;
    font-family: "Arial", sans-serif;
  }
  .header-layout{
    margin-bottom: 0rem !important;
  }
  .email-sidebar-class {
            /* Your initial styles go here */
     transition: display 0.3s ease; /* Add a smooth transition effect for the display property */
    }
    .disabled-div {
        pointer-events: none;
        opacity: 0.5; /* You can adjust the opacity to make it visually appear disabled */
    }
    .colorstar{
        fill:#ffd400b5;
    }
    #emailSearchClear{
            padding: 10px;
            box-shadow: none;
            background: transparent;

        }
        .emailsearchcleardiv{
            z-index: 5;
            right: 4px;
            position: absolute;
        }
        @media screen and (width: 1440px) {
            .width-serch{
                width: 595px;
            }
            .all-mail-search {
                position: relative;
                width: 40px;
                left: 636px;
                font-size: 12px;
                transform: translate(0, -50%);
                top: 50%;
                display: flex;
                align-items: center;
            }
            .search-chk {
                position: relative;
                left: 632px;
                transform: translate(0, -50%);
                top: 50%;
                display: flex;
                align-items: center;
            }
        }


    </style>

    <div class="container-fluid mb-5 content-position body-email sidebarNav">
        <div class="se-pre-con"></div>

        @section('order-header')
        <span>{{ $showHeading }}</span>
        @endsection

        <div class="col-12 mx-0 px-0 " style="height: 55px;;padding: 10px 0;">
            <div style="margin: auto;">
                {{-- <b><span class="align-middle" style=" font-size: 40px;">{{ $showHeading }}</span></b> --}}
                <a  class="float-right"  href="{{route('azure.logout')}}" >
                    <button type="button" class="btn-logout">
                        <i data-feather="log-out" class="font-medium-2 mr-50"></i>
                        <b>LOGOUT</b>
                    </button>
                </a>
                <form id="formGetEmails" method="post" action="emails" >
                    {{ csrf_field() }}
                    <input type="text" value="{{ $showType }}" id="txtGetEmailType" hidden name="txtGetEmailType" />
                    <input type="text" value="{{ $showHeading }}" id="txtHeaderEmailType" hidden name="txtHeaderEmailType" />
                    <input type="text" id="label" value="@if ($allMails == 0) No mails found @else {{ $labelRange }} @endif" hidden />
                    <input type="text" id="txtPgNo" value="{{ $pageNo }}" hidden name="txtPgNo" />
                    <span class="float-left mt-2"  style="padding-right: 20px; font-size: 15px; color:#cacaca;">Showing @if ($allMails == 0) No mails found @else {{ $labelRange }} @endif results</span>
                    <button id="btnPrev" {{ $prevBtn }} type="button" style="padding:0.01px 0.55px !important" class="btn btncolor btn-circle float-left mt-2"><i
                        class="fa fa-chevron-left"></i>
                    </button>
                    <button id="btnNext" {{ $nextBtn }} style="padding:0.01px 0.55px !important" type="button"
                        class="btn btn-circle btncolor float-left mt-2"><i class="fa fa-chevron-right"></i></button>
                        <input type="text" id="serachText" value="{{ $searchString }}" hidden name="serachText" />
                        <input type="text" id="serachOnOff" value="{{ $searchOnOF }}" hidden name="serachOnOff" />
                        <input type="text" id="allmailsearch" value="OFF" hidden name="allmailsearch" />

                        <input type="text" name="txtDraftView" value="OFF" id="txtDraftView" hidden />
                        <input type="text" value="" name="txtUidMessage" id="txtUidMessage" hidden />
                        <input type="text" value="" name="txtMessageNo" id="txtMessageNo" hidden />



                </form>



            </div>
        </div>
        <div class="row body-email-header ">
            <div class="row  mt-3" style="margin-left:3.1rem;margin-right: 2.5rem;border-bottom: 4px ridge;width: -webkit-fill-available;height:45px">
                <div class="me-4 "><input he style="transform: scale(1.5);" class="form-check-input  mt-2"type="checkbox" name="checkboxMail[]" value="" id="selectAllCheck"></div>
                <div class="me-4 ">
                    <span class="action-icon favorite IconColor" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Report spam">
                        <i data-feather="chevron-down" class="font-medium-2 float-right mt-1"></i>
                    </span>
                </div><p class="float-right mx-2 IconColor" style="pointer:cursor">|</p>
                <div class="me-4  delete-action hide-desiable disabled-div ReportasSpam">
                    <span class="action-icon favorite IconColor" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Report spam">
                        <i data-feather="alert-octagon" class="font-medium-2 float-right mt-1"></i>
                    </span>
                </div>
                <p class="float-right mx-2 IconColor " style="pointer:cursor">|</p>

                <div class="me-4  delete-action hide-desiable deleteMail disabled-div">
                    <span class="action-icon favorite IconColor " data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
                        <i data-feather="trash-2" class="font-medium-2 float-right mt-1"></i>
                    </span>
                </div>
                <p class="float-right mx-2 IconColor  "  style="pointer:cursor">|</p>

                <div class="me-4  delete-action hide-desiable disabled-div">
                    <span class="action-icon favorite IconColor MarkasRead" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Mark as read">
                        <i data-feather="inbox" class="font-medium-2 float-right mt-1"></i>
                    </span>
                </div>
                <p class="float-right mx-2 IconColor  " style="pointer:cursor">|</p>

                <div class="me-4  delete-action hide-desiable disabled-div">
                    <span class="action-icon favorite IconColor MarkasUnRead" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Mark as unread">
                        <i data-feather="mail" class="font-medium-2 float-right mt-1"></i>
                    </span>
                </div>
                <p class="float-right mx-2 IconColor " style="pointer:cursor">|</p>

                <div class="me-4  delete-action hide-desiable disabled-div">
                    <span class="action-icon favorite IconColor" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Mail box">
                        <i data-feather="message-square" class="font-medium-2 float-right mt-1"></i>
                    </span>
                </div>
                <p class="float-right mx-2 IconColor " style="pointer:cursor">|</p>

                <div class="me-4  delete-action  "  onclick="toggleCompose(event)">
                    <span class="action-icon favorite IconColor" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Compose">
                        <i data-feather="edit" class="font-medium-2 float-right mt-1"></i>
                    </span>
                </div>
                <p class="float-right mx-2 IconColor " style="pointer:cursor">|</p>

                <div class="me-4  delete-action  disabled-div ">
                    <span class="action-icon favorite IconColor" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Reply">
                        <i data-feather="corner-up-left" class="font-medium-2 float-right mt-1"></i>
                    </span>
                </div>
                <p class="float-right mx-2 IconColor " style="pointer:cursor">|</p>

                <div class="me-4  delete-action hide-desiable disabled-div">
                    <span class="action-icon favorite IconColor" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Forward">
                        <i data-feather="corner-up-right" class="font-medium-2 float-right mt-1"></i>
                    </span>
                </div>
                {{-- <div class="app-fixed-search d-flex align-items-center">
                    <div class="sidebar-toggle d-block d-lg-none ml-1">
                        <i data-feather="menu" class="font-medium-5"></i>
                    </div>

                    <div class="d-flex align-content-center justify-content-between w-100">
                        <div class="input-group input-group-merge" style="background-color: #efefef;">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i data-feather="search" class="text-muted"></i></span>
                            </div>
                            <input type="text" class="form-control" id="emailSearch" placeholder="Search emails"
                                aria-label="Search..." aria-describedby="email-search" value="{{ $searchString }}" />
                            <div class="input-group-prepend">
                                <button id="emailSearchClear" type="button" class="btn btn-circle">
                                    <i class="fa fa-close" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="row " style="width: 671px;">
                    <div class="col-md-5 ml-auto" style="width: 775px;position: absolute;left: 486px;">

                        <div class="input-group width-serch">
                            <input class="form-control border rounded-pill" type="search" placeholder="Search emails" id="emailSearch">
                            <div class="input-group-prepend emailsearchcleardiv">
                                <button id="emailSearchClear" type="button" class="btn btn-circle">
                                    <i class="fa fa-close" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                    <input type="checkbox" aria-label="Checkbox for following text input" class="search-chk" id="myCheckboxsearch">
                    <p class="all-mail-search">All mail</p>
                </div>


            </div>

            <div class="row col-12 mx-0 mt-3" style="margin-top: -1rem">
                <table style="width:100%" >
                    <form id="emailActions" method="post" action="emails">
                        {{ csrf_field() }}
                        <input type="text" value="" name="mailActions" hidden id="mailActions" />
                        <input type="text" value="" name="mailStatusChange" hidden id="mailStatusChange" />
                        <input type="text" value="{{ $showType }}" id="txtMailActionGetEmailType" hidden
                            name="txtGetEmailType" />
                        <input type="text" value="{{ $showHeading }}" id="txtMailActionHeaderEmailType" hidden
                            name="txtHeaderEmailType" />
                        <input type="text" id="txtMailActionPgNo" value="{{ $pageNo }}" hidden name="txtPgNo" />
                        <input type="text" id="serachMailActionText" value="{{ $searchString }}" hidden name="serachText" />
                        <input type="text" id="serachOnOffMailAction" value="{{ $searchOnOF }}" hidden name="serachOnOff" />
                        @if (empty($MessageArray))
                            <p style="font-size: 2.5rem;margin: auto;color: #b5b5b5cc;">No messages found.</p>
                        @else
                        @foreach ($MessageArray as $Message)
                            @php
                                if ($Message['Status'] == 'Unseen') {
                                    $ReadorNotRead = '';
                                } else {
                                    $ReadorNotRead = 'mail-read';
                                }
                            @endphp
                            <tr style="height:50px; cursor: pointer; "  data-UID="{{ $Message['Uid'] }}" data-MessNo="{{ $Message['Msgno'] }}"
                            class="py-1 @if ($showHeading == 'Drafts') draft-email @else view-email @endif  media {{ $ReadorNotRead }} emailItem" onmouseover="chbg1('{{ $Message['Msgno'] }}')" onmouseout="chbg2('{{ $Message['Msgno'] }}')">
                                <td style="width:5%">
                                    <div class="form-check mt-2">
                                        <input he style="transform: scale(1.5);" class="form-check-input checkboxMails " id="showDivCheckbox"
                                            type="checkbox" name="checkboxMail[]" value="{{ $Message['Msgno'] }}">
                                        <label class="form-check-label" for="flexCheckChecked">
                                        </label>
                                    </div>
                                </td>
                                <td style="width:5%"><i data-feather="star" class="font-medium-2 mt-2 IconColor @if ( $Message['flagStatus'] == 'flagged') colorstar @else nocolorstar  @endif" data-row="{{ $Message['Msgno'] }}" ></i></td>
                                <td style="width:5%">
                                    <div class=" pr-50">
                                        <div class=" my-0 mr-50">
                                            {{-- <img alt="Image placeholder" src="https://localhost/Encore-Cloud/assets/img/user/default_muted.png" style="height: 39px; width: 39px;border-radius: 50%;border: 1px solid #989898;"> --}}
                                            {{-- <span class="dot">HN</span> --}}
                                            <div class="dot">
                                                <span class="white-text">
                                                    @php
                                                        $from = $Message['From'];
                                                        $words = explode(' ', $from); // Split the text into words
                                                        $abbreviated = '';
                                                        for ($i = 0; $i < min(count($words), 2); $i++) {
                                                            $abbreviated .= strtoupper(substr($words[$i], 0, 1)); // Append the first letter of each word in uppercase
                                                        }
                                                        echo $abbreviated;
                                                    @endphp
                                                </span>
                                              </div>
                                        </div>
                                    </div>
                                </td>
                                <td style="width:25% ;overflow:hidden !important">
                                    <h4 class="mb-25 mt-2" style="font-size: 14px;margin-bottom: 0;overflow:hidden !important">@php echo ($Message['From']); @endphp</h4>
                                </td>
                                <td style="width:40%;margin-top:0.5rem;overflow:hidden !important">
                                    <span class="text-truncate" style="margin-top:0.5rem !important;font-size: 12px;color:#7c7c7c">@php echo ($Message['Subject']); @endphp</span>
                                </td>
                                <td style="width:20%">
                                    <div class="mail-meta-item mt-2" id ="{{ $Message['Msgno'] }}time">
                                        <span class="mail-date float-right" style="font-size: 12px;color:#7c7c7c">{{ $Message['Date'] }}</span>
                                        @if ($Message['Status'] == 'Unseen') <span class="mr-50 bullet bullet-success bullet-sm float-right mt-1" style="margin-right:0.5rem "></span> @endif
                                    </div>
                                    <div class="mail-meta-item mt-2" style="display:none" id ="{{ $Message['Msgno'] }}iconset" >
                                        <div class="me-4 IconDiv"><span class="action-icon favorite IconColor" data-bs-toggle="tooltip" data-bs-title="Default tooltip"><i data-feather="trash-2" class="font-medium-2 float-right mt-1 delete-mail-msg" data-row="{{ $Message['Msgno'] }}"></i></span></div><p class="float-right mx-2 IconColor" style="pointer:cursor">|</p>
                                        <div class="me-4 IconDiv"><span class="action-icon favorite IconColor"><i data-feather="mail" class="font-medium-2 float-right mt-1 markunread" data-row="{{ $Message['Msgno'] }}"></i></span></div><p class="float-right mx-2 IconColor" style="pointer:cursor">|</p>
                                        <div class="me-4 IconDiv"><span class="action-icon favorite IconColor"><i data-feather="alert-octagon" class="font-medium-2 float-right mt-1 ReportasSpam2" data-row="{{ $Message['Msgno'] }}"></i></span></div><p class="float-right mx-2 IconColor" style="pointer:cursor">|</p>
                                        <div class="me-4 IconDiv"><span class="action-icon favorite IconColor ms-5"><i data-feather="inbox" class="font-medium-2 float-right mt-1 addtoArchive" data-row="{{ $Message['Msgno'] }}"></i></span></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @endif
                    </form>
                </table>
            </div>
        </div>
    </div>

    <form id="formViewEmail" method="get" action="emails">
        <input type="text" value="" name="id" id="id" hidden />
        <!--<input type="text" value="" id="txtGetEmailTypeView" hidden name="txtGetEmailTypeView"/>
                                                          <input type="text" value="" id="txtHeaderEmailTypeView" hidden name="txtHeaderEmailTypeView"/>-->
    </form>

    <script src="{{ asset('email-assets') }}/app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('email-assets') }}/app-assets/vendors/js/editors/quill/katex.min.js"></script>
    <script src="{{ asset('email-assets') }}/app-assets/vendors/js/editors/quill/highlight.min.js"></script>
    <script src="{{ asset('email-assets') }}/app-assets/vendors/js/editors/quill/quill.min.js"></script>
    <script src="{{ asset('email-assets') }}/app-assets/vendors/js/extensions/toastr.min.js"></script>
    <script src="{{ asset('email-assets') }}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('email-assets') }}/app-assets/js/core/app-menu.js"></script>
    <script src="{{ asset('email-assets') }}/app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('email-assets') }}/app-assets/js/scripts/pages/app-email.js"></script>
    <!-- END: Page JS-->

    <!-- BEGIN: Editor JS-->
    <script src="{{ asset('argon') }}/js/plugins/editor.js"></script>
    <!-- END: Editor JS-->

    <script>
        function chbg1(id) {
            document.getElementById(id+"time").style.display = "None";
            document.getElementById(id +"iconset").style.display = "inline";
        }
        function chbg2(id) {
            document.getElementById(id+"time").style.display = "inline";
            document.getElementById(id+"iconset").style.display = "None";
        }
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
            $('.navbar-vertical.navbar-expand-md').addClass('navbar-minimize', 700);
            $('.navbar-vertical.navbar-expand-md').removeClass('navbar-maximize', 700);
            $('#maximize_icon').show();
            $('#logo_large').hide();
            $('#logo_samll').show();
            $('#minimize_icon').hide();
        })
        $('#btnPrev').click(function(){
            $(".se-pre-con").fadeIn('slow');
        });
        $('#btnNext').click(function(){
            $(".se-pre-con").fadeIn('slow');
        });
        $("#btnPrev").click(function() {
            var currentPg = document.getElementById('txtPgNo').value;
            var prevPage = parseInt(currentPg) - 1;

            document.getElementById('txtPgNo').value = prevPage;
            document.getElementById("formGetEmails").submit();
        });

        $("#btnNext").click(function() {
            var currentPg = document.getElementById('txtPgNo').value;
            var nextPage = parseInt(currentPg) + 1;

            document.getElementById('txtPgNo').value = nextPage;
            document.getElementById("formGetEmails").submit();
        });

        function callViewmail(event, MailBoxId, showHeading1) {
            event.preventDefault();

            console.log(showHeading1);

            document.getElementById("txtGetEmailType").value = MailBoxId;
            document.getElementById("txtHeaderEmailType").value = showHeading1;
            document.getElementById('txtPgNo').value = "1";

            document.getElementById('serachText').value = "";
            document.getElementById('serachOnOff').value = "OFF";

            document.getElementById("formGetEmails").submit();
        }
        function chbg1(id) {

            document.getElementById(id+"time").style.display = "None";
            document.getElementById(id +"iconset").style.display = "inline";
        }
        function chbg2(id) {
            document.getElementById(id+"time").style.display = "inline";
            document.getElementById(id+"iconset").style.display = "None";

        }


    </script>

    <script>
        feather.replace()
        $(".view-email").click(function(e) {
            if ($(e.target).is('.checkboxMails')) {} else {
                //console.log( $(this).attr("data-MessID"));
                var uId = $(this).attr("data-UID");
                var mID = $(this).attr("data-MessNo");
                var type = document.getElementById("txtGetEmailType").value;
                document.getElementById('id').value = mID;
                location.href = "emails/" + type + "/" + uId + "/" + mID;

                if (typeof(Storage) !== "undefined") {

                    localStorage.setItem("txtGetEmailType", document.getElementById("txtGetEmailType").value);
                    localStorage.setItem("txtHeaderEmailType", document.getElementById("txtHeaderEmailType").value);
                    localStorage.setItem("txtPgNo", document.getElementById("txtPgNo").value);
                    localStorage.setItem("serachText", document.getElementById("serachText").value);
                    localStorage.setItem("serachOnOff", document.getElementById("serachOnOff").value);

                } else {
                    console.log("Sorry, your browser does not support Web Storage...");
                }
            }

            //alert(mID);
        });
    </script>
    <script>
        $(function () {
            $('[data-bs-toggle="tooltip"]').tooltip()
        })
    </script>
    <script>
        /var checkbox = document.getElementById("showDivCheckbox");
        // Select elements by class name
        var divs = document.getElementById("forHide");

        // Add an event listener to the checkbox
        checkbox.addEventListener("change", function() {
            // If the checkbox is checked, show the elements; otherwise, hide them
            var displayValue = checkbox.checked ? "block" : "none";
            for (var i = 0; i < divs.length; i++) {
                divs[i].style.display = displayValue;
            }
        });
    </script>

     <script src="{{ asset('email-assets') }}/app-assets/vendors/js/vendors.min.js"></script>
     <!-- BEGIN Vendor JS-->

     <!-- BEGIN: Page Vendor JS-->
     <script src="{{ asset('email-assets') }}/app-assets/vendors/js/editors/quill/katex.min.js"></script>
     <script src="{{ asset('email-assets') }}/app-assets/vendors/js/editors/quill/highlight.min.js"></script>
     <script src="{{ asset('email-assets') }}/app-assets/vendors/js/editors/quill/quill.min.js"></script>
     <script src="{{ asset('email-assets') }}/app-assets/vendors/js/extensions/toastr.min.js"></script>
     <script src="{{ asset('email-assets') }}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
     <!-- END: Page Vendor JS-->

     <!-- BEGIN: Theme JS-->
     <script src="{{ asset('email-assets') }}/app-assets/js/core/app-menu.js"></script>
     <script src="{{ asset('email-assets') }}/app-assets/js/core/app.js"></script>
     <!-- END: Theme JS-->

     <!-- BEGIN: Page JS-->
     <script src="{{ asset('email-assets') }}/app-assets/js/scripts/pages/app-email.js"></script>
     <!-- END: Page JS-->

     <!-- BEGIN: Editor JS-->
     <script src="{{ asset('argon') }}/js/plugins/editor.js"></script>
     <!-- END: Editor JS-->

     <script>
         $(window).on('load', function() {
             if (feather) {
                 feather.replace({
                     width: 14,
                     height: 14
                 });
             }
             $('.navbar-vertical.navbar-expand-md').addClass('navbar-minimize', 700);
             $('.navbar-vertical.navbar-expand-md').removeClass('navbar-maximize', 700);
             $('#maximize_icon').show();
             $('#logo_large').hide();
             $('#logo_samll').show();
             $('#minimize_icon').hide();
             $('#emailSearchClear').hide();
         })
     </script>
     <script>
        // Wrap the script in a DOMContentLoaded event listener
        document.addEventListener('DOMContentLoaded', function () {
            // Target element with the specified class
            var navbarElement = document.querySelector('.navbar-vertical.navbar-expand-md');

            // Sidebar element
            var sidebarElement = document.querySelector('.mail-sidebar-class');

            // Function to handle changes to the class attribute
            var handleClassChange = function (mutationsList, observer) {
                for (var mutation of mutationsList) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        // Check if 'navbar-minimize' class is present
                        if (navbarElement.classList.contains('navbar-maximize')) {
                            // If the class is present, set the display property of the sidebar element to 'none'
                            sidebarElement.style.display = 'none';
                        } else {
                            // If the class is not present, set the display property of the sidebar element to its default value
                            sidebarElement.style.display = ''; // empty string resets to default
                        }
                    }
                }
            };

            // Create a MutationObserver instance
            var observer = new MutationObserver(handleClassChange);

            // Configure the observer to watch for changes in the class attribute
            var observerConfig = { attributes: true };

            // Start observing the target element
            observer.observe(navbarElement, observerConfig);
        });
    </script>
     <script>
        var serchTxt = document.getElementById("emailSearch");
        serchTxt.addEventListener("keyup", function(event) {
            var checkbox = document.getElementById("myCheckboxsearch");
                // Check if the checkbox is checked
                if (checkbox.checked) {
                    document.getElementById('allmailsearch').value = "ON";
                } else {
                    document.getElementById('allmailsearch').value = "OFF";
                }
            if (event.keyCode === 13) {
                event.preventDefault();

                document.getElementById('txtPgNo').value = "1";
                var searchTextString = document.getElementById('emailSearch').value;
                document.getElementById('serachText').value = searchTextString;
                document.getElementById('serachOnOff').value = "ON";
                document.getElementById("formGetEmails").submit();

            }
        });
    </script>
     <script type="text/javascript">

         $("#composeBtn").click(function() {
             var darfTview = "<?php if (isset($draftMessageNo)) { unset($draftMessageNo); echo 'UnSet'; } else { echo 'UnSet'; } ?>";
             document.getElementById("txtMailBoxType").value = "";
             document.getElementById("txtMessgNo").value = "";

             $('#email-to').find('option').remove();
             $('#emailCC').find('option').remove();
             $('#emailBCC').find('option').remove();
             var editorElement = $('#editorTextArea + .Editor-container .Editor-editor');
             editorElement.empty();

             document.getElementById("emailSubject").value = "";
             document.getElementById("editorTextArea").value = "";

         });
         $("#btnSaveDraft").click(function() {

             var darfTview = "<?php if (isset($draftMessageNo)) { echo 'Set'; } else { echo 'UnSet'; } ?>";
             if(darfTview == "Set")
             {
                 document.getElementById("txtMessgNo").value = "<?php if (isset($draftMessageNo)) { echo $draftMessageNo; }?>";
             }
             var mailBody = $('#editorTextArea + .Editor-container .Editor-editor').html();
             $("#copied_message_body").val(mailBody);

             document.getElementById('composeForm').action = "savedraft";

             document.getElementById("composeForm").submit();

         });

        //  $("#selectAllCheck").click(function(){
        //      //alert("Test");
        //      if($(".checkboxMails:checked").length > 0){
        //          $("#selectAllCheck").prop("checked", false);
        //          $(".checkboxMails").prop('checked', false).attr('checked', false);
        //          $('.delete-action').hide(200);
        //      } else {
        //          if($("#selectAllCheck").is(':checked'))
        //          {
        //              $(".checkboxMails").prop('checked', true).attr('checked', true);
        //              $('.delete-action').show(200);
        //          }else
        //          {
        //              $(".checkboxMails").prop('checked', false).attr('checked', false);
        //              $('.delete-action').hide(200);
        //          }
        //      }
        //  });

        //  $(".checkboxMails").click(function(){
        //      if($(".checkboxMails:checked").length > 0){
        //          $("#selectAllCheck").prop("indeterminate", true);
        //          $('.delete-action').show(200);
        //      } else {
        //          $("#selectAllCheck").prop("indeterminate", false);
        //          $('.delete-action').hide(200);
        //      }
        //  });
        $("#selectAllCheck").click(function() {
    var isChecked = $(this).is(':checked');

    // Enable or disable delete-action divs based on the checkbox state
    if (isChecked) {
        $(".hide-desiable").removeClass('disabled-div');
        $(".checkboxMails").prop('checked', true).attr('checked', true);
        // $('.hide-desiable').show(200);
    } else {
        $(".hide-desiable").addClass('disabled-div');
        $(".checkboxMails").prop('checked', false).attr('checked', false);
        // $('.hide-desiable').hide(200);
    }
});

$(".checkboxMails").click(function() {
    var anyCheckboxChecked = $(".checkboxMails:checked").length > 0;

    // Enable or disable hide-desiable divs based on whether any checkbox is checked
    if (anyCheckboxChecked) {
        $(".hide-desiable").removeClass('disabled-div');
        $("#selectAllCheck").prop("indeterminate", true);
        // $('.hide-desiable').show(200);
    } else {
        $(".hide-desiable").addClass('disabled-div');
        $("#selectAllCheck").prop("indeterminate", false);
        // $('.hide-desiable').hide(200);
    }
});




         $('.list-group-item-action').click(function(){
             $(".se-pre-con").fadeIn('slow');
         });

         $('#btnPrev').click(function(){
             $(".se-pre-con").fadeIn('slow');
         });

         $('#btnNext').click(function(){
             $(".se-pre-con").fadeIn('slow');
         });


         $(document).ready(function() {
             $(".se-pre-con").fadeOut('slow');

             $("#editorTextArea").Editor({
                 'block_quote':false,
                 'undo':false,
                 'redo':false,
                 'unlink':false,
                 'insert_img':false,
                 'insert_table':false,
                 'splchars':false,
                 'hr_line':false,
                 'print':false,
                 'rm_format':false,
                 'select_all':false,
                 'source':false,
                 'togglescreen':false,
                 'extraeffects' : false,
             });

             if (localStorage.getItem("sentMail") == "Done") {
                 alert("Email Sent ");
                 localStorage.setItem("sentMail", "Not Done");
                 document.getElementById("formGetEmails").submit();
             } else if (localStorage.getItem("draftMail") == "Done") {
                 alert("Draft Saved");
                 localStorage.setItem("draftMail", "Not Done");
                 document.getElementById("formGetEmails").submit();
             }
             // remove this later
             if (localStorage.getItem("draftShowNot") == "Show") {
                 alert("draft set 1");
             }
             //not this
             if (localStorage.getItem("savedDraftShow") == "show") {



                 //subject
                 var darftSubject = "<?php if (isset($draftEmailSubject)) {
     echo $draftEmailSubject;
 } else {
     echo null;
 } ?>";
                 document.getElementById("emailSubject").value = darftSubject;

                 //toaddress
                 var draftAllToAddresses = <?php if (isset($draftAllToAddresses)) {
     echo json_encode($draftAllToAddresses);
 } else {
     echo 'null';
 } ?>;
                 if (draftAllToAddresses.length > 0) {
                     for (var toI = 0; toI < draftAllToAddresses.length; toI++) {
                         if (!$("#email-to option[value='" + draftAllToAddresses[toI]['mail'] + "']").length > 0) {
                             $("#email-to").append("<option value=" + draftAllToAddresses[toI]['mail'] + ">" +
                                 draftAllToAddresses[toI]['mail'] + "</option>");

                             $("#email-to option[value='" + draftAllToAddresses[toI]['mail'] + "']").prop('selected',
                                 true).attr('selected', true);
                         }
                     }
                 }

                 //ccaddresses
                 var draftAllCCAddresses = <?php if (isset($draftAllCCAddresses)) {
     echo json_encode($draftAllCCAddresses);
 } else {
     echo 'null';
 } ?>;
                 if (draftAllCCAddresses.length > 0) {
                     $(".cc-wrapper").css("display", "show");
                     for (var ccI = 0; ccI < draftAllCCAddresses.length; ccI++) {
                         if (!$("#emailCC option[value='" + draftAllCCAddresses[ccI]['mail'] + "']").length > 0) {
                             $("#emailCC").append("<option value=" + draftAllCCAddresses[ccI]['mail'] + ">" +
                                 draftAllCCAddresses[ccI]['mail'] + "</option>");
                             $("#emailCC option[value='" + draftAllCCAddresses[ccI]['mail'] + "']").prop('selected',
                                 true).attr('selected', true);
                         }
                     }
                 }

                 //bccaddresses
                 var draftAllBCCAddresses = <?php if (isset($draftAllBCCAddresses)) {
     echo json_encode($draftAllBCCAddresses);
 } else {
     echo 'null';
 } ?>;
                 if (draftAllBCCAddresses.length > 0) {
                     $(".bcc-wrapper").css("display", "show");
                     for (var bccI = 0; bccI < draftAllBCCAddresses.length; bccI++) {
                         if (!$("#emailBCC option[value='" + draftAllBCCAddresses[bccI]['mail'] + "']").length > 0) {
                             $("#emailBCC").append("<option value=" + draftAllBCCAddresses[bccI]['mail'] + ">" +
                                 draftAllBCCAddresses[bccI]['mail'] + "</option>");
                             $("#emailBCC option[value='" + draftAllBCCAddresses[bccI]['mail'] + "']").prop(
                                 'selected',
                                 true).attr('selected', true);
                         }
                     }
                 }


                 //mailBody



                 var message_string = document.getElementById("txtBodyMessage").value;
                 message_string = message_string.replace(/<br *\/?>/gi, '\n');
                 document.getElementById("editorTextArea").value = message_string;
                 console.log(document.getElementById("editorTextArea").value);
                 $('#editorTextArea + .Editor-container .Editor-editor').html(message_string);

                 var attachArea = "";
                 $("#txtAttachmentPaths option").each(function() {
                     //alert($(this).val());
                     $(this).prop("selected", true);
                     attachArea = attachArea + "<div style='width: 100%;font-size: 16px;padding: 8px;' class='alert alert-primary' role='alert'><a href='"+$(this).val()+"' download>"+ $(this).attr('data-originalName') +"</a><button onclick=\"myFunction(this)\" style='font-size: 10px; padding: 5px; float: right;' type='button' data-removeFile='"+ $(this).val() +"' class='btn btn-primary btn-sm'>X</button></div>";
                 });

                 document.getElementById("showAttachmentArea").innerHTML = attachArea;


                 // ./public/attachment
                 //var downloadAttachments = <?php if (isset($downloadAttachments)) { echo json_encode($downloadAttachments); } else { echo 'null'; } ?>;
                /* if (downloadAttachments.length > 0) {
                     for (var attI = 0; attI < downloadAttachments.length; attI++) {

                         if (!$("#attahcemnts option[value='" + downloadAttachments[attI]['filename'] + "']")
                             .length > 0) {
                             $("#attahcemnts").append("<option value='" + downloadAttachments[attI]['filename'] +
                                 "'>" +
                                 downloadAttachments[attI]['OriginalName'] + "</option>");
                             $("#attahcemnts option[value='" + downloadAttachments[attI]['filename'] + "']").prop(
                                 'selected',
                                 true).attr('selected', true);
                         }

                     }
                 }*/

                 // getAttachmentArea();


                 $("#drftViewBtn").click();

                 localStorage.setItem("savedDraftShow", "notShow");
             }


         });

         /*function getAttachmentArea()
         {
             //alert("test");
             var inputArea = "";
             $("#attahcemnts option").each(function() {
                 //alert($(this).val());
                 inputArea = inputArea + "<div style='width: 100%;font-size: 16px;padding: 8px;' class='alert alert-primary' role='alert'><a href='../public/attachment/"+$(this).val()+"' download>"+ $(this).text() +"</a></a><button style='font-size: 10px; padding: 5px; float: right;' type='button' class='btn btn-primary btn-sm'>X</button></div>";
             });

             document.getElementById("attahArea").innerHTML = inputArea;
         }
 */




         $("#sentBtn").click(function() {
             document.getElementById("txtGetEmailType").value = "SentItems";
             document.getElementById("txtHeaderEmailType").value = "All Sent Mails";
             document.getElementById('txtPgNo').value = "1";

             document.getElementById('serachText').value = "";
             document.getElementById('serachOnOff').value = "OFF";

             document.getElementById("formGetEmails").submit();
         });

         $("#allInbox").click(function() {
             document.getElementById("txtGetEmailType").value = "Inbox";
             document.getElementById("txtHeaderEmailType").value = "All Inbox Mails";
             document.getElementById('txtPgNo').value = "1";

             document.getElementById('serachText').value = "";
             document.getElementById('serachOnOff').value = "OFF";

             document.getElementById("formGetEmails").submit();
         });

         $("#darftBtn").click(function() {
             document.getElementById("txtGetEmailType").value = "Drafts";
             document.getElementById("txtHeaderEmailType").value = "All Draft Mails";
             document.getElementById('txtPgNo').value = "1";

             document.getElementById('serachText').value = "";
             document.getElementById('serachOnOff').value = "OFF";

             document.getElementById("formGetEmails").submit();
         });

         $("#starredBtn").click(function() {
             document.getElementById("txtGetEmailType").value = "Inbox";
             document.getElementById("txtHeaderEmailType").value = "All Starred Mails";
             document.getElementById('txtPgNo').value = "1";

             document.getElementById('serachText').value = "";
             document.getElementById('serachOnOff').value = "OFF";

             document.getElementById("formGetEmails").submit();

         });

         $("#spamBtn").click(function() {
             document.getElementById("txtGetEmailType").value = "junkemail";
             document.getElementById("txtHeaderEmailType").value = "All Spam Mails";
             document.getElementById('txtPgNo').value = "1";

             document.getElementById('serachText').value = "";
             document.getElementById('serachOnOff').value = "OFF";

             document.getElementById("formGetEmails").submit();

         });

         $("#trashBtn").click(function() {
             document.getElementById("txtGetEmailType").value = "deleteditems";
             document.getElementById("txtHeaderEmailType").value = "All Trash Mails";
             document.getElementById('txtPgNo').value = "1";

             document.getElementById('serachText').value = "";
             document.getElementById('serachOnOff').value = "OFF";

             document.getElementById("formGetEmails").submit();
         });


         $("#btnPrev").click(function() {
             var currentPg = document.getElementById('txtPgNo').value;
             var prevPage = parseInt(currentPg) - 1;

             document.getElementById('txtPgNo').value = prevPage;
             document.getElementById("formGetEmails").submit();
         });



         $(".view-email").click(function(e) {
             if ($(e.target).is('.checkboxMails')) {} else {
                 //console.log( $(this).attr("data-MessID"));
                 var uId = $(this).attr("data-UID");
                 var mID = $(this).attr("data-MessNo");
                 var type = document.getElementById("txtGetEmailType").value;
                 document.getElementById('id').value = mID;
                 location.href = "emails/" + type + "/" + uId + "/" + mID;

                 if (typeof(Storage) !== "undefined") {

                     localStorage.setItem("txtGetEmailType", document.getElementById("txtGetEmailType").value);
                     localStorage.setItem("txtHeaderEmailType", document.getElementById("txtHeaderEmailType").value);
                     localStorage.setItem("txtPgNo", document.getElementById("txtPgNo").value);
                     localStorage.setItem("serachText", document.getElementById("serachText").value);
                     localStorage.setItem("serachOnOff", document.getElementById("serachOnOff").value);

                 } else {
                     console.log("Sorry, your browser does not support Web Storage...");
                 }
             }

             //alert(mID);
         });
         $(".deleteMail").click(function() {
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                console.log(result.value);
            if (result.value) {
                Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                )
                document.getElementById('emailActions').action = "emails";
                document.getElementById("mailActions").value = "DeleteMails";
                document.getElementById("emailActions").submit();
            }
            })
         });
         $(".delete-mail-msg").click(function() {
            var rowId = $(this).data('row');
            console.log(rowId);
            $(".checkboxMails[value='" + rowId + "']").prop("checked", true);
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                console.log(result.value);
            if (result.value) {
                Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                )
                document.getElementById('emailActions').action = "emails";
                document.getElementById("mailActions").value = "DeleteMails";
                document.getElementById("emailActions").submit();
            }
            })
         });
         $(".MarkasRead").click(function() {
            Swal.fire({
            title: 'Are you sure?',
            text: "This chats are make to mark as read!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
            }).then((result) => {
                console.log(result.value);
            if (result.value) {
                // Swal.fire(
                // 'Deleted!',
                // 'Your file has been deleted.',
                // 'success'
                // )
                document.getElementById('emailActions').action = "emails";
                document.getElementById("mailStatusChange").value = "MarkasRead";
                document.getElementById("emailActions").submit();
            }
            })

         });
         $(".colorstar").click(function() {
            var rowId = $(this).data('row');
            $(".checkboxMails[value='" + rowId + "']").prop("checked", true);
            Swal.fire({
            title: 'Are you sure?',
            text: "This chats are make as unflagged!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
            }).then((result) => {
                console.log(result.value);
            if (result.value) {
                // Swal.fire(
                // 'Deleted!',
                // 'Your file has been deleted.',
                // 'success'
                // )
                document.getElementById('emailActions').action = "emails";
                document.getElementById("mailStatusChange").value = "flagged";
                document.getElementById("emailActions").submit();

            }
            })

         });
         $(".addtoArchive").click(function() {
            var rowId = $(this).data('row');
            $(".checkboxMails[value='" + rowId + "']").prop("checked", true);
            Swal.fire({
            title: 'Are you sure?',
            text: "This chats are add to Archive!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
            }).then((result) => {
                console.log(result.value);
            if (result.value) {
                // Swal.fire(
                // 'Deleted!',
                // 'Your file has been deleted.',
                // 'success'
                // )
                document.getElementById('emailActions').action = "emails";
                document.getElementById("mailStatusChange").value = "Archive";
                document.getElementById("emailActions").submit();

            }
            })

         });
         $(".nocolorstar").click(function() {
            var rowId = $(this).data('row');
            $(".checkboxMails[value='" + rowId + "']").prop("checked", true);
            Swal.fire({
            title: 'Are you sure?',
            text: "This chats are make as flagged!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
            }).then((result) => {
                console.log(result.value);
            if (result.value) {
                // Swal.fire(
                // 'Deleted!',
                // 'Your file has been deleted.',
                // 'success'
                // )
                document.getElementById('emailActions').action = "emails";
                document.getElementById("mailStatusChange").value = "un_flagged";
                document.getElementById("emailActions").submit();
            }
            })

         });
         $(".MarkasUnRead").click(function() {
            Swal.fire({
            title: 'Are you sure?',
            text: "This chats are make to mark as unread!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
            }).then((result) => {
                console.log(result.value);
            if (result.value) {
                // Swal.fire(
                // 'Deleted!',
                // 'Your file has been deleted.',
                // 'success'
                // )
                document.getElementById('emailActions').action = "emails";
                document.getElementById("mailStatusChange").value = "MarkasUnRead";
                document.getElementById("emailActions").submit();
            }
            })

         });
         $(".markunread").click(function() {
            var rowId = $(this).data('row');
            $(".checkboxMails[value='" + rowId + "']").prop("checked", true);
            Swal.fire({
            title: 'Are you sure?',
            text: "This chats are make to mark as unread!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
            }).then((result) => {
                console.log(result.value);
            if (result.value) {
                // Swal.fire(
                // 'Deleted!',
                // 'Your file has been deleted.',
                // 'success'
                // )
                document.getElementById('emailActions').action = "emails";
                document.getElementById("mailStatusChange").value = "MarkasUnRead";
                document.getElementById("emailActions").submit();
            }
            })

         });
         $(".ReportasSpam").click(function() {
            Swal.fire({
            title: 'Are you sure?',
            text: "This chats are make to mark as spam!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
            }).then((result) => {
                console.log(result.value);
            if (result.value) {
                // Swal.fire(
                // 'Deleted!',
                // 'Your file has been deleted.',
                // 'success'
                // )
                document.getElementById('emailActions').action = "emails";
                document.getElementById("mailStatusChange").value = "ReportasSpam";
                document.getElementById("emailActions").submit();
            }
            })

         });
         $(".ReportasSpam2").click(function() {
            var rowId = $(this).data('row');
            $(".checkboxMails[value='" + rowId + "']").prop("checked", true);
            Swal.fire({
            title: 'Are you sure?',
            text: "This chats are make to mark as spam!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
            }).then((result) => {
                console.log(result.value);
            if (result.value) {
                // Swal.fire(
                // 'Deleted!',
                // 'Your file has been deleted.',
                // 'success'
                // )
                document.getElementById('emailActions').action = "emails";
                document.getElementById("mailStatusChange").value = "ReportasSpam";
                document.getElementById("emailActions").submit();
            }
            })

         });

         $(".draft-email").click(function() {
             document.getElementById('txtUidMessage').value = $(this).attr("data-UID");
             document.getElementById('txtMessageNo').value = $(this).attr("data-MessNo");
             document.getElementById('txtDraftView').value = "Show";

             document.getElementById("formGetEmails").submit();
         });

         $("#fileBtn").click(function(){
             $("#file").click();
         });

         $('#emailSearch').on('input',function(){
             if($(this).val() != ''){
                 $('#emailSearchClear').show(200);
             } else {
                 $('#emailSearchClear').hide(200);
             }
         });

         $("#emailSearchClear").click(function(){
             $("#emailSearch").val('');
             $('#emailSearchClear').hide(200);
         });

         function minMaxToggle(){
             $(".min-max-toggle").toggle(300);
         }



         function myFunctionRemoveInput(filesInputs){
             $(filesInputs).parent().remove();

         }

         function myFunction(identifier) {
             //alert($(identifier).attr("data-removeFile"));
             var removeSelectValue =  $(identifier).attr("data-removeFile");
             $("#txtAttachmentPaths option[value='"+removeSelectValue+"']").prop("selected", false);

             var attachArea = "";
             $( "#txtAttachmentPaths option:selected").each(function() {
                 //alert($(this).val());
                 attachArea = attachArea + "<div style='width: 100%;font-size: 16px;padding: 8px;' class='alert alert-primary' role='alert'><a href='"+$(this).val()+"' download>"+ $(this).attr('data-originalName') +"</a><button onclick=\"myFunction(this)\" style='font-size: 10px; padding: 5px; float: right;' type='button' data-removeFile='"+ $(this).val() +"' class='btn btn-primary btn-sm'>X</button></div>";
             });
             var files = $("#file").prop("files");
             var names = $.map(files, function(val) { return val.name; });
             //file
             for(i=0;i<names.length;i++)
             {
                 attachArea = attachArea + "<div style='width: 100%;font-size: 16px;padding: 8px;' class='alert alert-primary' role='alert'><a >"+ names[i] +"</a><button onclick=\"myFunctionRemoveInput(this)\" style='font-size: 10px; padding: 5px; float: right;' type='button' class='btn btn-primary btn-sm'>X</button></div>";
             }

             document.getElementById("showAttachmentArea").innerHTML = attachArea;
         }

     function toggleCompose(event) {
            event.preventDefault();
            var element1 = document.getElementsByClassName("ql-editor");
            element1[0].innerHTML = "";
            document.getElementById('emailSubject').value = '';
            var composeSection = document.querySelector(".compose-main-section");
            if (composeSection.style.display === "none" || composeSection.style.display === "") {
                composeSection.style.display = "block";
            } else {
                composeSection.style.display = "none";
            }
        }
        function getEditorContents() {

            var darfTview = "<?php if (isset($draftMessageNo)) { echo 'Set'; } else { echo 'UnSet'; } ?>";
            if(darfTview == "Set")
            {
                document.getElementById("txtMailBoxType").value = "Drafts";
                document.getElementById("txtMessgNo").value = "<?php if (isset($draftMessageNo)) { echo $draftMessageNo; }?>";
            }
            document.getElementById('composeForm').action = "sendemail";
            document.getElementById("composeForm").submit();
        }


     </script>


@endsection
