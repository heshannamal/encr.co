@extends('layouts.app', ['activePage' => 'Mail', 'titlePage' => __('Email')])

@section('content')

@include('pages.mail.reply')
@include('pages.mail.organizations.organization_create_modal')
@include('pages.mail.organizations.organization_edit_modal')
@include('pages.mail.people.people-create-modal')
@include('pages.mail.activity.create_activity_modal')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>


#templatetitle .select2-container--default .select2-selection--single{
    border: 1px solid #aaaaaa4f !important;
}
#templatetitle-reply .select2-container--default .select2-selection--single{
    border: 1px solid #aaaaaa4f !important;
}
    .Attachments-container {
        flex: 0 0 auto;
        margin-left: 4px;
        height: 150px;


        }

        .Attachments-button {
        display: inline-block;
        padding: 12px 12px 10px;
        border: 1px solid;
        border-radius: 3px;
        background: #f7f3f1;
        text-decoration: none;
        transition: all 1.2s ease-in-out;

        i::after {
            content: "\f019";
            font-size: 40px;
            color: #fff;
        }

        &:hover {
            animation: pulse 0.2s 2 both;
        }

        &.loading {
            i {
            animation: loading 2s infinite linear;

            &::after {
                content: "\f1ce";
            }
            }
        }

        &.success {
            border-radius: 50%;
            background: #80bca3;

            i::after {
            content: "\f00c";
            color: transparent;
            animation: change-icon 1s 0.6s linear both;
            }
        }
        }

        @keyframes loading {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(359deg);
            transform: rotate(359deg);
        }
        }

        @keyframes change-icon {
        0% {
            color: transparent;
        }

        100% {
            color: #fff;
        }
        }

        @keyframes pulse {
        from {
            transform: scale3d(1, 1, 1);
        }

        50% {
            transform: scale3d(1.05, 1.05, 1.05);
        }

        to {
            transform: scale3d(1, 1, 1);
        }
        }


    .normal-btn-1{
        border: none;
        margin: 5px auto;
        display: flex;
        cursor: pointer;
        margin-left: .5rem;
        color: #80cfff;
        font-size: .8rem;
    }
    .normal-btn-1 .btn-caption{
        font-size: .8rem;
        font-weight: 100;
    }

    .normal-btn{
        border: 1px solid #a3a3a3;
        border-radius: 3px;
        position: relative;
        margin: 5px auto;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
  .normal-btn-green{
    border: 1px solid #a3a3a3;
    border-radius: 3px;
    background-color: #038323;
    position: relative;
    margin: 5px auto;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
  }
  .btn-caption{
    font-weight: bold;
    font-family: "Arial", sans-serif;
    font-size: 14px;
    cursor: pointer;
  }
  .btn-green-caption{
    color: #E1E6F9;
    font-weight: bold;
    font-family: "Arial", sans-serif;
    font-size: 14px;
    cursor: pointer;
  }
  .oragnization-caption{
    display: flex;
    align-items: center;
    justify-content: center;

  }
  .normal-btn-red{
    width: 260px;
    border: 1px solid #a3a3a3;
    border-radius: 3px;
    background-color: #8d1010;
    position: relative;
    margin: 5px auto;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
  }

    .sidebar{
        width: fit-content;
        border-right: 0.5px solid #e4dfdf;
        height: 75vh;
        overflow-y: scroll;
    }
    .sidebar-content{
        min-width: 15rem;
    }
    .bg-box.-flui.mb-.fix-na.header-layout{
        margin-bottom:.5rem !important;
    }
    .sidebar-content ul li{
        height: 40px;
        line-height: 2.5;
        font-size: 1rem;
        padding-left: 5px;
    }
    .sidebar-content ul li i{
        margin-right: 5px;

    }
    .sidebar-content-li:hover {
        background-color: rgb(240, 240, 240) !important; /* Added !important */
        cursor: pointer !important; /* Added !important */
        color: #df6a6a
    }
    .Icon-bar{
        border-bottom: 0.5px solid #e4dfdf;
        width:100%;
        height: 60px;
        /* background-color:rgb(197, 197, 197); */
    }
    .sidebar-item-list {
        list-style-type: none;
        padding-inline-end: 20px;
        padding-inline-start: 20px;

    }
    .chat-list{
        padding-inline-end: 2px;
        padding-inline-start: 2px;
    }

    .email-details li{
        height: unset !important;
        line-height: unset !important;
    }

    .chatliclass{
        height: 58px;
        line-height: 4.5;
    }
    .chatliclass:hover{
        background-color: rgb(240, 240, 240) !important; /* Added !important */
        cursor: pointer !important; /* Added !important */
    }
    .avator-image img{
        width: 40px;
        height: 40px;
    }
    .avator-image{
        width: 40px;
        margin-left: 10px;
        margin-right: 10px;
    }
    .chat-row{
        margin-right: 0px;
        margin-left: 0px;
        padding-left: 10px;
    }
    .starbox i{
        margin-left: 10px;
        margin-right: 10px;
    }
    .chat-name{
        width: 20%;
        overflow: hidden;
        margin-right: 10px;
    }
    .chat-subject{
        overflow: hidden;
        margin-right: 10px;
    }
    .margin-unset{
        margin-block-start: 1em;
        margin-block-end: 1em;
        font-size: 0.8rem;
    }
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }
    .dot {
        height: 39px;
        width: 39px;
        background-color: #a6a4fff5;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        /* margin-top: 10px; */
        margin-left: 10px;
        margin-right: 10px;
    }
    .white-text {
        color: rgb(60, 96, 255);
        font-weight: bold;
        font-family: "Arial", sans-serif;
    }
    .float-right {
        float: right;
    }
    .chat-row {
        display: flex;
        align-items: center; /* Centers items vertically */
    }

    .chat-date {
        margin-left: auto; /* Pushes chat-date to the end of the row */
        margin-right: 10px;
    }
    .btn-green-filled{
        outline: unset !important;
        color: white;
        background-color: #47D6B6;
        border: 2px solid #47D6B6;
        font-weight: 700;
        font-size: .7rem;
        cursor: pointer;
        /* padding: .4rem;
        padding-left: 1rem;
        padding-right: 1rem; */
        width: 100%;
        height: 100%;
    }
    .compose-li{
        height: 50px;
        margin-bottom: 10px;
    }
    .sidebar-item-div{
        width: 95%;
    }
    .down-arrow{
        width: 5%;
    }
    .sidebar-content-li {
        display: flex;
        align-items: center; /* Align items vertically */
    }
    .sidebar-item-div {
        display: flex;
        line-height: 2.5;

    }
    .custom-button {
        border: none;
        box-shadow: none;
        background-color: transparent;
        color: #464444;
        /* Additional styles */
        /* Add your additional styles here */
    }
    .searchbox-layout{
        margin-top: 0 !important;
        width: 100% !important;
        height: 29px;
        font-size: .7rem;
        color: #464444;
        border: unset;
        background-color: inherit;
    }
    .searchbox-layout:focus {
        border: none; /* Remove border on focus */
        outline: none; /* Optionally remove the focus outline */
    }
    .btn-back:focus{
        border: none; /* Remove border on focus */
        outline: none; /* Optionally remove the focus outline */
    }
    .custom-button:focus {
        border: none; /* Remove border on focus */
        outline: none; /* Optionally remove the focus outline */
    }
    .icon-set{
        display: flex;
        flex-direction: row;
    }
    .{
        border-right: 1px solid #000000;
        padding: 5px;
    }
    .mail-icon {
        margin: 0 10px; /* Adjust the value to set the desired gap */
    }
    .no-messages{
        text-align-last: center;
    }
    .show {
        display: block !important;
    }
    /* Style for file names container */
    #file-names-container {
        margin-top: 10px;
    }

    /* Style for each file name entry */
    .file-name {
        margin-bottom: 5px;
    }

    /* Style for remove icon */
    .remove-icon {
        margin-left: 5px;
        cursor: pointer;
        color: red;
    }
    .remove-icon-reply{
        margin-left: 5px;
        cursor: pointer;
        color: red;
    }
    .email-reply-area {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        background-color: #f9f9f9;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin: .5rem 1.5rem;

    }

    .email-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .email-header-left {
        flex: 1;
    }

    .email-header-label {
        font-weight: bold;
        margin-right: 5px;
    }

    .email-header-value {
        margin-right: 10px;
    }

    .email-header-right {
        flex-shrink: 0;
    }

    .email-body {
        padding: 15px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .email-details {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 15px;
    }

    .email-detail {
        flex: 1;
        margin-right: 15px;
    }

    .email-content textarea {
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        resize: vertical;
    }

    .btn-send, .btn-discard {
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 8px 16px;
        cursor: pointer;
        margin-left: 10px;
        transition: background-color 0.3s;
    }

    .btn-send:hover, .btn-discard:hover {
        background-color: #45a049;
    }
    .selectalldiv{
        height: 20px !important;
        line-height: 2 !important;
    }
    .selectalldiv:hover {
        background-color: transparent !important; /* Override background-color */
        cursor: auto !important; /* Override cursor */
    }
    .bg-unread{
        background-color: #c7efdeff;
    }
    .hidden_div {

        position: fixed;
        top: 24%;
        right: 2%;
        background-color: #fff; /* Adjust as needed */
        padding: 10px;
        z-index: 1000; /* Ensure it's above other content */
        border: 1px solid #ccc; /* Optional border */
        height: 70vh;
        animation: slideFromSide 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        width: 500px;
        box-shadow: -5px 0px 10px rgba(212, 212, 212, 0.5); /* Add shadow to the left */
        }
    .hidden {
            display: none;
    }
    .displayview{
        display: inline-flex !important;
    }
    @keyframes slideFromSide {
        0% {
            transform: translateX(100%);
        }
        100% {
            transform: translateX(0);
        }
    }
    .ql-snow .ql-tooltip {
        z-index: 2;
        left: auto !important;
    }
    .compose-div{
        /* height: 70vh; */
        padding-left: 0px !important;
        padding-right: 0px !important;
        border: 1px solid #b6b6b6;
        border-radius: 5px;
        background-color: #fff;
        padding-top: 20px;
    }
    .to-field{
        height: 6vh;
        /* background-color: #038323; */
        border-bottom: 1px solid #b6b6b6;
        display: flex;
        flex-wrap: wrap;
        align-content: flex-start;
        justify-content: center;
        flex-direction: column;
    }
    .select2-container .select2-selection--multiple {
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .select2-container .select2-selection--multiple .select2-selection__rendered {
        padding: 5px 10px;
        min-height: 38px;
        overflow-y: auto;
        border: none !important;
        border-radius: 5px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__rendered {
        width: 100% !important;
    }

    .select2-container .select2-selection--multiple .select2-search__field {
        background-color: transparent;
        border-bottom: none;
        outline: none;
        box-shadow: none;
        padding: 0;
        margin: 0;
        font-size: 14px;
        line-height: 1.5;
    }
    .select2-search__field{
        min-width: 100px !important;
    }
    .displayflex{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        padding: 0px !important;
        padding-left: 20px !important;
    }
    .ql-toolbar.ql-snow + .ql-container.ql-snow {
        border-top: 1px solid #ccc !important;
    }


    .color-set::placeholder {
        color:#000000 !important; /* Change the color to your desired color */
    }
    /* Dropdown Button */
.dropbtn {
  background-color: #8b8b8b;
  color: rgb(0, 0, 0);
  padding: 5px;

  border: none;
  cursor: pointer;
}

/* Dropdown button on hover & focus */


/* The search field */
#myInput {
  box-sizing: border-box;
  background-image: url('searchicon.png');
  background-position: 14px 12px;
  background-repeat: no-repeat;
  font-size: 16px;
  padding: 14px 20px 12px 45px;
  border: none;
  border-bottom: 1px solid #ddd;
}

/* The search field when it gets focus/clicked on */
#myInput:focus {outline: 3px solid #ddd;}
#myInput2 {
  box-sizing: border-box;
  background-image: url('searchicon.png');
  background-position: 14px 12px;
  background-repeat: no-repeat;
  font-size: 16px;
  padding: 14px 20px 12px 45px;
  border: none;
  border-bottom: 1px solid #ddd;
}

/* The search field when it gets focus/clicked on */
#myInput2:focus {outline: 3px solid #ddd;}

/* The container <div> - needed to position the dropdown content */
.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f6f6f6;
    min-width: 230px;
    border: 1px solid #ddd;
    z-index: 1;
    height: 200px;
    overflow-y: scroll;
}

/* Links inside the dropdown */
.dropdown-content p {
  color: black;
  text-decoration: none;
  display: block;
}
.quill-editor {
  display: flex;
  flex-direction: column-reverse;
}
.linked-org{
    color: black !important;
}
.linked-org:hover {
    text-decoration: underline;
}
.next-act-tab .list-group-item.list-group-item-action:hover{
    background-color: lightskyblue;
}

/* Change color of dropdown links on hover */
.dropdown-content p:hover {background-color: #f1f1f1}

/* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
.show {display:block;}

    @media screen and (min-width: 1440px) and (min-height: 900px) {
        .sidebar{
            height: 72vh;
        }
    }
    #editor-container{
        min-width: 100%;
    }
    .custom-btn:hover{
        box-shadow: none !important;
    }
    .bg-box.container-fluid.mb-5.fix-nav.header-layout{
        margin-bottom: 1rem !important;
    }
    .custom-btn-style{
        font-size: .675rem !important;
        font-weight: 400 !important;
        padding: .325rem 0.5rem !important;
        border-radius: 1px !important;
    }
    .custome-color{
        border-color: #bbbdbe !important;
        background-color: #bbbdbe !important;
    }
    #mail_filter_div .select2-container--default .select2-selection--single{
        border: 1px solid black !important;
    }
    #mail_filter_div .select2-selection__rendered{
        color: #000000 !important;
    }
    #mail_filter_div .select2-container{
        width: 80px !important;
    }
    .message-content p, .ql-editor p{
        line-height: 1.5;
    }
</style>
<div class="container-fluid "  >
    <div class="se-pre-con"></div>

    @section('order-header')
        <span id="email-header">{{$showHeading}}</span>
    @endsection
    <div class="row" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 15px 0 rgba(0, 0, 0, 0.19);">
        <div class="Icon-bar mx-2" style="">
            <div class="row mt-3 mx-2">
                <input type="hidden" name="" id="needtoload" value="{{$loadmessageId}}">
                <div class="icon-set col-4">
                    <div class="mail-icon mt-2 col-1 chat-mail-action" data-action="delete"><i class="fa fa-trash-o fa-lg" title="Remove" aria-hidden="true"></i></div>
                    <div class="mail-icon mt-2 col-1 chat-mail-action" data-action="move"><i class="fa fa-arrows fa-lg" title="Move" aria-hidden="true"></i></div>
                    <div class="mail-icon mt-2 col-1 chat-mail-action" data-action="unread"><i class="fa fa-envelope-o fa-lg" title="Mark as unread" aria-hidden="true"></i></div>
                    <div class="mail-icon mt-2 col-1 chat-mail-action" data-action="read"><i class="fa fa-envelope-open-o fa-lg" title="Marrk as read" aria-hidden="true"></i></div>
                    <div class="mail-icon mt-2 col-1 chat-mail-action" data-action="flag"><i class="fa fa-star-o fa-lg" title="Favourite" aria-hidden="true"></i></div>
                    <div class="mail-icon mt-2 col-1" data-action="forward"><i class="fa fa-share fa-lg"  title="Forward" aria-hidden="true"></i></div>
                    <div class="mail-icon mt-2 col-1 chat-mail-action" data-action="spam"><i class="fa fa-exclamation-circle fa-lg" title="Spam" aria-hidden="true"></i></div>
                    <div class="mail-icon mt-2 col-1 mail-template" data-action="template"><i class="fa fa-signature fa-lg" title="Signature" aria-hidden="true"></i></div>
                    {{-- <div class="mail-icon  col-4" id="mail_filter_div" >
                        <select class="" id="mail_filter" name="state">
                            <option value="AL">All</option>
                            <option value="WY">Unread</option>
                          </select>
                    </div> --}}
                </div>
                <div class="col-lg-3 ml-6" style="padding-right: 0px;">
                    <div class="row" style="width: 101%;">
                        <div class="col-lg-1" style="border-bottom: 1px solid #464444 !important;">
                            <i class="fa fa-search" aria-hidden="true" style="font-size: 19px;color: #464444;top: 23%;position: relative;"></i>
                        </div>
                        <div class="col-lg-10 text-center" style="border-bottom: 1px solid #464444 !important;">
                            <input class="searchbox-layout"  type="text" id="searchbox" placeholder="Email Search">
                        </div>

                    </div>

                </div>

                <div class="email-navigator mt-1 ml-auto d-flex">
                    <div class="mail-icon  " id="mail_filter_div" >
                        <select class="" id="mail_filter" name="state">
                            <option value="0" @if ($filter == 0) selected @endif>All</option>
                            <option value="1" @if ($filter == 1) selected @endif>Unread</option>
                        </select>
                    </div>
                    <button class="btn-pre custom-button" disabled><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
                    <label for="" class="d-block" style="align-content: flex-end;">showing message <span id="start_count">1</span> -<span id="end_count">50</span> of <span id="full_count">@if($filter == 1){{$sidebarItems[0]['unreadItemCount']}}@else {{$sidebarItems[0]['totalItemCount']}} @endif</span></label>
                    <button class="btn-next custom-button"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                    <div class="icon-set col-1" style="padding-right: opx !important;padding-left: opx !important">
                        <div class="mail-icon mt-2 col-1 org-set-toggle" style="margin-left: 0px;display:none" ><i class="fa fa-angle-double-left fa-lg toggle-between-details" aria-hidden="true"></i></div>
                        <div class="mail-icon mt-2 col-1 log-out" style="margin-left: 0px;" ><i class="fa fa-power-off fa-lg" title="Logout" aria-hidden="true"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sidebar mt-3" >
            <div class="sidebar-content">
                <ul class="sidebar-item-list">
                    <li class="compose-li">
                        <button class="btn-green-filled compose-btn" style="outline: unset;" >
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> COMPOSE
                        </button>
                    </li>


                    @foreach ($sidebarItems as $item )
                        <li class="sidebar-content-li">
                            <div class="sidebar-item-div mail-sidebar-item" data-folder = "{{$item['id']}}" >

                                <p style="margin-top: 15px;margin-bottom: 1rem;font-size: .9rem;"> {{$item['displayName']}}</p>
                                @if($item['displayName'] == 'Drafts')
                                    @if(!($item['totalItemCount'] == 0))
                                        <p class="item-count" style="margin-left: auto; margin-top: 15px; margin-bottom: 1rem; font-size: .5rem; display: inline-block; background-color: #47D6B6; color: white; border-radius: 1rem; padding: 5px 10px;width: auto;
                                        height: 25px;">{{$item['totalItemCount']}}</p>
                                    @endif
                                @else
                                    @if(!($item['unreadItemCount'] == 0))

                                        <p class="item-count" style="margin-left: auto; margin-top: 15px; margin-bottom: 1rem; font-size: .5rem; display: inline-block; background-color: #47D6B6; color: white; border-radius: 1rem; padding: 5px 10px;width: auto;
                                        height: 25px;">{{$item['unreadItemCount']}}</p>



                                    @endif
                                @endif
                            </div>
                            @if (!empty($item['childFolders']))
                                <div class="down-arrow">
                                    <i class="fa fa-chevron-right" style="margin-left: 5px" aria-hidden="true"></i>
                                </div>
                            @endif
                        </li>
                        @if (!empty($item['childFolders']))
                        <ul class="sidebar-item-list child-list" style="padding-inline-end: 0px;display:none" >
                            @foreach ($item['childFolders'] as $itemChild )
                            <li class="sidebar-content-li">
                                <div class="sidebar-item-div mail-sidebar-item" data-folder = "{{$itemChild['id']}}" >

                                    <p style="margin-top: 15px;margin-bottom: 1rem;"> {{$itemChild['displayName']}}</p>
                                    <p style="margin-left: auto;margin-top: 15px;margin-bottom: 1rem;" class="child-item-count">{{$itemChild['unreadItemCount']}}/{{$itemChild['totalItemCount']}}</p>
                                </div>

                            </li>
                            @endforeach
                        </ul>
                        @endif
                    @endforeach

                </ul>

            </div>
        </div>
        <input type="hidden" id="message_no_opened" value="">
        <div class="col  mt-3 mb-5" style="height: 80vh;overflow-y: scroll;overflow-x: clip;" id="composereply">

            <ul type="none" class="chat-list mailchat-div" id="mailchat-div">

                @foreach ($inboxMessages as $item)
                    <li class="{{ $item['Status'] ? '' : 'bg-unread' }} chatliclass">
                        <div class="row chat-row " >
                            <div class="chkbox"><input class="chk_boxes" type="checkbox" value="{{$item['Message_ID']}}" id="flexCheckDefault" style="margin-right: 20px;"></div>
                            <div class="starbox"><i class="fa fa-star fa-lg" aria-hidden="true" @if ( $item['flagStatus'] == 'flagged') style="color: #db0000;" @else style="color: rgb(120, 120, 121);"  @endif></i></div>
                            <div class="dot">
                                <span class="white-text">
                                    @php
                                        $from = $item['From'];
                                        $words = explode(' ', $from); // Split the text into words
                                        $abbreviated = '';
                                        for ($i = 0; $i < min(count($words), 2); $i++) {
                                            $abbreviated .= strtoupper(substr($words[$i], 0, 1)); // Append the first letter of each word in uppercase
                                        }
                                        echo $abbreviated;
                                    @endphp
                                </span>
                            </div>
                            <div class="chat-name inbox_msg_row" data-message_id="{{$item['Message_ID']}}"><p class="margin-unset">{{$item['From']}}</p></div>
                            <div class="chat-subject inbox_msg_row" data-message_id="{{$item['Message_ID']}}"><p class="margin-unset">{{substr($item['Subject'], 0, 53)}}</p></div>
                            <div class="chat-date float-right inbox_msg_row" data-message_id="{{$item['Message_ID']}}"><p class="margin-unset">{{ date('d M', strtotime($item['Date'])) }}</p></div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="col-12 compose-div hidden my-2" id="compose-div" >
                {{-- <div class="col-12 to-field form-group displayflex">

                        <label for="contactSearchInput" style="width:5%;margin-top: 13px !important;">To:</label>
                        <select class="form-control info-form-input mt-2 recipient-input" name="recipient[]" multiple="multiple" id="toRecipientInput" style="width: 80%;height: 1.75rem;" aria-placeholder="To">
                        </select>

                </div> --}}
                <form  method="post" enctype="multipart/form-data" id="email_template_create_form">
                    @csrf
                    <input type="hidden" id="template_id" name="template_id" value="">

                    <div class="col-md-12 mb-3 " style="display: table;border-bottom: 1px solid #b6b6b6;" >
                        <label for="contactSearchInput" style="width:8%">To:</label>
                        <select class="form-control info-form-input mt-2 recipient-input" name="recipient[]" multiple="multiple" id="toRecipientInput" style="width: 90%;height: 1.75rem;" placeholder="To">
                        </select>
                        <label class="toggle-cc-bcc" for="contactSearchInput" style="margin-left: 3px;"><i class="fa fa-sort fa-lg" aria-hidden="true"></i></label>
                    </div>
                    <div class=" col-md-12 mb-3  ccbcc-input  hidden" style="border-bottom: 1px solid #b6b6b6;" >
                        <label for="ccSearchInput" style="width:8%">Cc:</label>
                        <select class="form-control info-form-input mt-2 cc-input" name="cc[]" multiple="multiple" id="ccRecipientInput" style="width: 90%;height: 1.75rem;" >
                        </select>
                    </div>
                    <div class="col-md-12 mb-2  ccbcc-input  hidden" style="border-bottom: 1px solid #b6b6b6;" >
                        <label for="bccSearchInput" style="width:8%">Bcc:</label>
                        <select class="form-control info-form-input mt-2 bcc-input" name="bcc[]" multiple="multiple" id="bccRecipientInput" style="width: 90%;height: 1.75rem;">
                        </select>
                    </div>


                    <div class="col-md-12  " style="display: inline-flex;">
                        <label  style="width:8%;align-content: center;">Subject</label>
                        <input type="text" class="form-control info-form-input mt-2 color-set" id="template_subject" name="subject" value=""   style="width: 90%;height: 2.5rem;">
                    </div>
                    <div class="to-field col-12">
                        <div >
                            <div  class="btn-green-filled customBtn-DroupDown" style="padding: 5px">Pick template</div>
                            <div id="myDropdown" class="dropdown-content">
                              <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()">

                              @foreach ($emailTemplates as $item )
                                <p style="margin-left: 10px;" class="pick-template" data-template_id="{{$item['id']}}"> {{$item['title']}}</p>
                              @endforeach
                              @if (isset($AddedEmailTemplates))
                                @foreach ($AddedEmailTemplates as $item )
                                    <p style="margin-left: 10px;" class="pick-template" data-template_id="{{$item['id']}}"> {{$item['title']}}</p>
                                @endforeach
                              @endif
                            </div>
                          </div>
                    </div>


                    <div class="col-md-12 mt-3 mb-1" style="display: flex;flex-direction: column-reverse;">
                        <div id="editor-container" style="height: 400px;"></div>
                        <div style="display: flex; align-items: center;">
                            <label for="new_description" class="form-label mb-1" style="color: black; width: fit-content;">Email Body</label>
                            <label for="draftsavealert" id="draftsavealert" class="form-label mb-1" style="color: rgb(95, 95, 95); width: fit-content; margin-right: 10px;margin-left: auto;"></label>
                        </div>
                        <input type="hidden" id="email_body" name="email_body">
                    </div>
                    <input type="file" id="attachment" name="attachments[]" style="display: none;" value="" multiple>
                    <input type="text" id="Draftmessageid" name="Draftmessageid" style="display: none;" value="">
                    <input type="hidden" id="SavedDraftId" name="SavedDraftId"  value="">
                    <input type="hidden" id="organization_linked_email" name="organization_linked"  value="">
                    <div class="col-md-12 mb-3 text-right">
                        <div id="file-names-container" style="max-height: 50px;overflow-y: scroll;margin-right: auto;"></div>
                        <button type="button"  class="btn btn-danger compose-close-btn custom-btn-style" data-dismiss="modal"><i class="fa fa-close " style="margin-right: 2px" aria-hidden="true" ></i> Close</button>
                        <label for="attachment" style="margin-bottom:0rem" class="btn btn-secondary custom-btn-style custome-color" >
                            <i class="fa fa-paperclip " style="margin-right: 2px" aria-hidden="true"></i>Attach
                        </label>
                        <button type="button"  id="save-draft" class="btn btn-secondary custom-btn-style custome-color"><i class="fa fa-floppy-o " style="margin-right: 2px" aria-hidden="true" ></i>Save Draft</button>
                        <button type="button"  id="save-template" class="btn btn-secondary custom-btn-style custome-color"><i class="fa fa-plus " style="margin-right: 2px" aria-hidden="true" ></i>Add to Template</button>
                        {{-- <button for="attachment" type="button" style="padding: 0.2rem 1.2rem !important;" class="btn btn-info " data-dismiss="modal"><i class="fa fa-paperclip " aria-hidden="true"></i></button> --}}
                        <button type="submit"  id="submit_btn_text" class="btn btn-success custom-btn-style"><i class="fa fa-send " style="margin-right: 2px" aria-hidden="true" ></i>Send</button>
                    </div>
                </form>
            </div>


        </div>
        <div class="col" style="max-width: 17rem;padding-left: 0;display:none" id="section-of-sidebar">
        </div>
    </div>
</div>
<input type="hidden" id="pageNumber" value="">
<input type="hidden" id="saveallattachments" value="">
<input type="hidden" id="mailboxId" value="">
<input type="hidden" id="Searchtext" value="">
<input type="hidden" id="mail_filter_value" value="{{$filter}}">

<!-- Modal -->
<div class="modal fade" id="chatfolderselect" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Select the mailbox</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <select class="mailboxselect2" name="mailbox">

              </select>
        </div>
        <div class="modal-footer">
          <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button"  id="confirmMoveButton" class="btn btn-primary">Move</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="templatetitle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Template Settings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table style="width: 95%;margin-left:auto;margin-right:auto" >
                    <tr style="    height: 65px;">
                        <td style="width: 20%"> <label for="template_title_get">Template Title</label></td>
                        <td style="width: auto"><input type="text" class="form-control info-form-input color-set" id="template_title_get" name="title" value="" style="width:100%;height: 2.5rem;"></td>
                    </tr>
                    <tr style="    height: 65px;">
                        <td style="width: 20%"> <label>Publish Type</label></td>
                        <td style="width: auto">
                            <select class="js-example-basic-single " id="mail_template_publish_type" name="publish_type" style="width: 100%;">
                                <option value="0">Private</option>
                                <option value="1">Public</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger custom-btn-style" data-dismiss="modal">
                    <i class="fa fa-close" style="margin-right: 2px" aria-hidden="true"></i>Close
                </button>
                <button type="button" id="confirmcreateButton" class="btn btn-success custom-btn-style">
                    <i class="fa fa-plus" style="margin-right: 2px" aria-hidden="true"></i>Create
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="templatetitle-reply" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Template Settings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table style="width: 95%;margin-left:auto;margin-right:auto" >
                    <tr style="    height: 65px;">
                        <td style="width: 20%"> <label for="template_title_get">Template Title</label></td>
                        <td style="width: auto"><input type="text" class="form-control info-form-input color-set" id="template_title_get-reply" name="title" value="" style="width:100%;height: 2.5rem;"></td>
                    </tr>
                    <tr style="    height: 65px;">
                        <td style="width: 20%"> <label>Publish Type</label></td>
                        <td style="width: auto">
                            <select class="js-example-basic-single " id="mail_template_publish_type-reply" name="publish_type" style="width: 100%;">
                                <option value="0">Private</option>
                                <option value="1">Public</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger custom-btn-style" data-dismiss="modal">
                    <i class="fa fa-close" style="margin-right: 2px" aria-hidden="true"></i>Close
                </button>
                <button type="button" id="confirmcreateButton-reply" class="btn btn-success custom-btn-style">
                    <i class="fa fa-plus" style="margin-right: 2px" aria-hidden="true"></i>Create
                </button>
            </div>
        </div>
    </div>
</div>

  <!-- Modal -->
<div class="modal fade" id="mail-signature" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="exampleModalLabel">Email Signature</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body mailtemplate-modal-body">
            <div id="signature-editor-container" style="height: 250px;max-width: unset !important;"></div>
        </div>
        <div class="modal-footer">
            <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="signature-create" class="btn btn-primary">save</button>
          </div>
      </div>
    </div>
  </div>
    <div class="modal fade" id="organizationModalShow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Linked Organizations</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body mailtemplate-modal-body">
                    <ul id="organizationList"></ul>
                </div>
            </div>
        </div>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/quill-delta-to-html"></script>
  <script src="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.4/dist/quill.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.4/dist/quill.snow.css" rel="stylesheet">
  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/quill-image-resize-module"></script>
  <script src="https://cdn.jsdelivr.net/npm/quill-delta-to-html@0.12.1/dist/browser/QuillDeltaToHtmlConverter.bundle.min.js"></script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <!-- After quill script includes -->
  <script src="https://unpkg.com/quill-magic-url@3.0.0/dist/index.js"></script>
  <script>
    $(document).ready(function() {
        $('#mail_template_publish_type-reply').select2({
            placeholder: "Select publish type"
        });


        $(document).on('click', '.message-content a', function(e) {
            // Ensure the link opens in a new tab
            e.preventDefault();
            window.open($(this).attr('href'), '_blank');
        });

        $('#mail_filter').select2({
            minimumResultsForSearch: Infinity
        });


        $('#mail_template_publish_type').select2({
            placeholder: "Select publish type"
        });

        $('#mail_filter').on('change', function() {
            // Get the updated value of $filter when selection changes
            var filter = $(this).val();
            console.log('Selected filter:', filter);
            $.ajax({
                url: "{{ url('/save-filter') }}/"+filter,
                method: "GET",
                success: function(response) {
                    // Handle success response (if needed)
                    console.log(response);
                    $('#mail_filter_value').val(filter);
                    var page_number = $('#pageNumber').val();
                    var mailbox_id = $('#mailboxId').val();
                    loadMessages(mailbox_id,page_number);
                    updateSidebarCounts();
                    // For example, you can redirect the user to another page
                    // window.location.href = "/";
                },
                error: function(xhr, status, error) {
                    // Handle error response (if needed)
                    console.error(error);
                }
            });
            // Perform actions based on the selected value, such as filtering messages
            // or making an AJAX request to retrieve specific message data.
        });
    });
    $(document).ready(function() {
        let hoverTimeout;

        if ($('#minimize_icon').css('display') != 'none') {
            $('#minimize_icon')[0].click();
        }

        $('#sidenav-main').hover(
            function() {
                hoverTimeout = setTimeout(function() {
                    if ($('#maximize_icon').css('display') != 'none') {
                        $('#maximize_icon').click();
                    }
                }, 500);
            },
            function() {
                clearTimeout(hoverTimeout);
                if ($('#minimize_icon').css('display') != 'none') {
                    $('#minimize_icon')[0].click();
                }
            }
        );
    });
</script>
  <script>

    function clearChatList() {
            $('.chat-list').empty();

        }
    function loadMessages(mailbox_id,page_number) {
            $('#section-of-sidebar').hide();
            $('.org-set-toggle').hide();
            // AJAX request
            $.ajax({
                url: "{{ url('/get/maiibox/chat') }}/",
                method: 'GET',
                data: { mailbox_id: mailbox_id, page_number: page_number },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('fast');
                },
                success: function(response) {
                    console.log(response);
                    var startCount = (page_number - 1) * 50 + 1;
                    var endCount = (page_number - 1) * 50 + response.length;
                    $('#start_count').text(startCount);
                    $('#end_count').text(endCount);
                    var fullMails = @json($sidebarItems);
                    var mailfilter = $('#mail_filter_value').val();

                    var foundMailbox = fullMails.find(function(mailbox) {
                        return mailbox.id === mailbox_id;
                    });

                    if (foundMailbox) {
                        var totalItemCount = foundMailbox.totalItemCount;
                        var unreadItemCount = foundMailbox.unreadItemCount;
                        if(mailfilter == 1 ){
                            $('#full_count').text(unreadItemCount);
                        }else{
                            $('#full_count').text(totalItemCount);
                        }

                    }else if($('#email-header').text().trim() === 'All Inbox Mails'){
                        var foundMailbox = fullMails[0];
                        var totalItemCount = foundMailbox.totalItemCount;
                        var unreadItemCount = foundMailbox.unreadItemCount;
                        if(mailfilter == 1 ){
                            $('#full_count').text(unreadItemCount);
                        }else{
                            $('#full_count').text(totalItemCount);
                        }
                    } else {
                        $('#full_count').text(0);
                    }
                    clearChatList(); // Clear existing messages
                    if (response.length === 0) {
                        $('#start_count').text('0');
                        // If there are no messages, display a message
                        $('.chat-list').append('<p class="no-messages">No messages yet</p>');
                    } else {

                        if (response.length < 50) {
                            $('.btn-next').prop('disabled', true);
                        } else {
                            $('.btn-next').prop('disabled', false);
                        }
                        // Append messages to the chat list
                        $.each(response, function(index, item) {
                            var abbreviatedName = '';
                            var name = $('#email-header').text().trim() === 'Drafts' ? item.To : item.From;
                            if (!name) {
                                name = 'Not Set';
                            }
                            var words = name.split(' ');
                            for (var i = 0; i < Math.min(words.length, 2); i++) {
                                abbreviatedName += words[i].charAt(0).toUpperCase();
                            }
                            var truncatedSubject = item.Subject.length > 53 ? item.Subject.substr(0, 53) : item.Subject;
                            if (!truncatedSubject) {
                                truncatedSubject = 'Not Set';
                            }
                            var starColor = item.flagStatus === 'flagged' ? '#db0000' : 'rgb(120, 120, 121)';
                            $('.chat-list').append(
                                '<li class="' + (item.Status ? '' : 'bg-unread') + ' chatliclass">' +
                                '<div class="row chat-row" >' +
                                '<div class="chkbox"><input class="chk_boxes" type="checkbox" value="'+item.Message_ID+'" id="flexCheckDefault" style="margin-right: 20px;"></div>' +
                                '<div class="starbox"><i class="fa fa-star fa-lg" aria-hidden="true" style="color'+starColor+'"></i></div>' +
                                '<div class="dot">' +
                                '<span class="white-text">' +
                                abbreviatedName +
                                '</span>' +
                                '</div>' +
                                '<div class="chat-name inbox_msg_row" data-message_id="'+item.Message_ID+'"><p class="margin-unset" style="font-size: 0.8rem;">' + name + '</p></div>' +
                                '<div class="chat-subject inbox_msg_row" data-message_id="'+item.Message_ID+'"><p class="margin-unset" style="font-size: 0.8rem;">' + truncatedSubject + '</p></div>' +
                                '<div class="chat-date float-right inbox_msg_row" data-message_id="'+item.Message_ID+'"><p class="margin-unset" style="font-size: 0.8rem;">' + item.Date + '</p></div>' +
                                '</div>' +
                                '</li>'
                            );
                        });

                    }
                    var dots = document.querySelectorAll('.dot');
                    dots.forEach(function(dot) {
                        dot.style.backgroundColor = getRandomLightColor();
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                },
                complete: function () {

                    $(".se-pre-con").fadeOut('fast');
                }
            });
        }
    function logoutFunction() {
        // Make an AJAX request to the logout route
        $.ajax({
            url: "{{ route('azure.logout') }}",
            method: "GET",
            success: function(response) {
                // Handle success response (if needed)
                console.log(response);
                // For example, you can redirect the user to another page
                // window.location.href = "/";
            },
            error: function(xhr, status, error) {
                // Handle error response (if needed)
                console.error(error);
            }
        });
    }
    function searchload(searchText,pageNumber){
        $.ajax({
            url: "{{ url('/search/email') }}/", // This is the URL of the server-side script that will process the search
            method: 'get', // You can also use GET depending on your server setup
            data: {
                searchText: searchText,
                pageNumber:pageNumber
            },
            beforeSend: function () {
                    $(".se-pre-con").fadeIn('fast');
                },
            success: function(response){
                $('#email-header').text("Search Results");
                $('#full_count').text(response.totalItemCount);
                // Handle the response here, for example, update a div with the search results
                // $('#search-results').html(response);
                console.log(response.messages);
                $('.chat-list').empty(); // Clear existing messages
                    if (response.messages.length === 0) {
                        // If there are no messages, display a message
                        $('.chat-list').append('<p class="no-messages">No messages yet</p>');
                    } else {

                        if (response.messages.length < 50) {
                            $('.btn-next').prop('disabled', true);
                        } else {
                            $('.btn-next').prop('disabled', false);
                        }
                        // Append messages to the chat list
                        $.each(response.messages, function(index, item) {
                            var abbreviatedName = '';
                            var words = item.From.split(' ');
                            for (var i = 0; i < Math.min(words.length, 2); i++) {
                                abbreviatedName += words[i].charAt(0).toUpperCase();
                            }
                            var truncatedSubject = item.Subject.length > 53 ? item.Subject.substr(0, 53) : item.Subject;
                            var starColor = item.flagStatus === 'flagged' ? '#db0000' : 'rgb(120, 120, 121)';
                            $('.chat-list').append(
                                '<li class="' + (item.Status ? '' : 'bg-unread') + ' chatliclass">' +
                                '<div class="row chat-row" >' +
                                '<div class="chkbox"><input class="chk_boxes" type="checkbox" value="'+item.Message_ID+'" id="flexCheckDefault" style="margin-right: 20px;"></div>' +
                                '<div class="starbox"><i class="fa fa-star fa-lg" aria-hidden="true" style="color'+starColor+'"></i></div>' +
                                '<div class="dot">' +
                                '<span class="white-text">' +
                                abbreviatedName +
                                '</span>' +
                                '</div>' +
                                '<div class="chat-name inbox_msg_row" data-message_id="'+item.Message_ID+'"><p class="margin-unset" style="font-size: 0.8rem;">' + item.From + '</p></div>' +
                                '<div class="chat-subject inbox_msg_row" data-message_id="'+item.Message_ID+'"><p class="margin-unset" style="font-size: 0.8rem;">' + truncatedSubject + '</p></div>' +
                                '<div class="chat-date float-right inbox_msg_row" data-message_id="'+item.Message_ID+'"><p class="margin-unset" style="font-size: 0.8rem;">' + item.Date + '</p></div>' +
                                '</div>' +
                                '</li>'
                            );
                        });

                    }
                    var dots = document.querySelectorAll('.dot');
                    dots.forEach(function(dot) {
                        dot.style.backgroundColor = getRandomLightColor();
                    });
            },
            error: function(xhr, status, error){
                console.error(error);
            },
            complete: function () {

                $(".se-pre-con").fadeOut('fast');
            }

        });
    }
    $(document).ready(function(){
        $('#Attachments-button').on('click', function(event) {
            event.preventDefault(); // Prevent default button behavior
            // Add your custom logic here
            console.log("down button clicked");
            /* Start loading process. */
            downloadButton.classList.add('loading');

            /* Set delay before switching from loading to success. */
            window.setTimeout(function() {
            downloadButton.classList.remove('loading');
            downloadButton.classList.add('success');
            }, 3000);

            /* Reset animation. */
            window.setTimeout(function() {
            downloadButton.classList.remove('success');
            }, 8000);
        });



        // $('.navbar-vertical.navbar-expand-md').addClass('navbar-minimize', 700);
        const logoutButton = $('.log-out');

        // Add click event listener
        logoutButton.on('click', function() {
            // Call your logout function here
            Swal.fire({
                title: 'Do you need to logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, logout',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                // If user confirms logout
                console.log(result);
                if (result.value) {
                    // Redirect to logout route
                    window.location.href = '{{ route("azure.logout") }}';
                }
            });
        });
        $('#searchbox').on('keypress', function(event){
            if (event.keyCode === 13) { // Check if Enter key is pressed
                var searchText = $(this).val();
                var pageNumber = 1;
                $('#pageNumber').val(pageNumber);
                $('#Searchtext').val(searchText);
                console.log('weda');
                console.log($('#Searchtext').val());
                searchload(searchText,1);

            }
        });
    });

    function filterFunction() {
            console.log("Custom button type");
            var input, filter, ul, li, a, i;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            div = document.getElementById("myDropdown");
            a = div.getElementsByTagName("p");
            for (i = 0; i < a.length; i++) {
                txtValue = a[i].textContent || a[i].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    a[i].style.display = "";
                } else {
                    a[i].style.display = "none";
                }
            }
        }
        function filterFunction2() {
            console.log("Custom button type");
            var input, filter, ul, li, a, i;
            input = document.getElementById("myInput2");
            filter = input.value.toUpperCase();
            div = document.getElementById("myDropdown2");
            a = div.getElementsByTagName("p");
            for (i = 0; i < a.length; i++) {
                txtValue = a[i].textContent || a[i].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    a[i].style.display = "";
                } else {
                    a[i].style.display = "none";
                }
            }
        }
        function onComposeDivHidden() {
            // Add your custom logic here
            console.log("compose-div is hidden");
            // Trigger your function here
            // functionName();
        }
    $(document).ready(function() {

        $('#compose-div').on('hidden.bs.modal', function(e) {
            // onComposeDivHidden();
            console.log('allagtha');
        });
        $('.customBtn-DroupDown').on('click', function() {
            event.preventDefault(); // Prevent default button behavior
            // Add your custom logic here
            console.log("Custom button clicked");
            $('#myDropdown').toggle();
        });



        // Array to store selected files
        var selectedFilesCompose = [];
        function updateFileInput() {
            const dataTransfer = new DataTransfer();

            selectedFilesCompose.forEach(file => dataTransfer.items.add(file)); // Add each valid file
            $('#attachment')[0].files = dataTransfer.files; // Set files to the updated FileList
            console.log('adxa');
            console.log(document.getElementById('attachment').files);

        }
        // Function to update the list of selected file names
        function updateFileList() {
            // var selectedFiles = $('#attachment')[0].files;
            // Get the selected files
            updateFileInput();
            // Container to hold the file names
            var fileNamesContainer = $('#file-names-container');
            // Clear any previous file names
            fileNamesContainer.empty();
            // Loop through the selected files and display their names
            for (var i = 0; i < selectedFilesCompose.length; i++) {
                // Create a new <div> element for each file name
                var fileNameElement = $('<div>').addClass('file-name');
                // Create a <span> element to display the file name
                var nameSpan = $('<span>').text(selectedFilesCompose[i].name);
                // Create a <i> element for the remove icon
                var removeIcon = $('<i>').addClass('fa fa-times remove-icon').attr('data-index', i);
                // Append the file name and remove icon to the container
                fileNameElement.append(nameSpan, removeIcon);
                fileNamesContainer.append(fileNameElement);
            }
        }

        // Add event listener to the file input field
        // var selectedFiles = []; // Array to store the selected files

        $('#attachment').change(function() {

            // Get the selected files
            var files = $(this)[0].files;
            var maxFileSize = 20 * 1024 * 1024; // 20 MB in bytes

            // Loop through the selected files
            for (var i = 0; i < files.length; i++) {
                if (files[i].size <= maxFileSize) {
                    // If the file size is within the limit, add it to the selectedFiles array
                    selectedFilesCompose.push(files[i]);
                } else {
                    // If the file size exceeds 20 MB, show a Swal2 alert and do not add the file
                    Swal.fire({
                        icon: 'error',
                        title: 'File too large',
                        text: "The file '" + files[i].name + "' exceeds the 20 MB size limit.",
                    });
                }
            }

            // Update the list of selected file names
            updateFileInput();
            updateFileList();
        });


        // Add event listener to remove icon to remove files from the list
        $(document).on('click', '.remove-icon', function() {
            var index = $(this).data('index');
            // var selectedFiles = $('#attachment')[0].files;
            selectedFilesCompose.splice(index, 1); // Remove file from selectedFiles array
            updateFileInput();
            updateFileList(); // Update the list of selected file names
        });

         function clearFormInputs() {
                 // Clear recipient inputs
                 $('.recipient-input').val('').trigger('change');
                 $('.cc-input').val('').trigger('change');
                 $('.bcc-input').val('').trigger('change');

                 // Clear subject and email body inputs
                 $('#template_subject').val('');
                 quill.setContents('');
         }

  // Function to clear the form inputs


          // Declare quill outside the scope of any functions to make it accessible globally within this file
          var quill = new Quill('#editor-container', {
              theme: 'snow',
              modules: {
                  imageResize: {
                      modules: ['Resize', 'DisplaySize', 'Toolbar']
                  },
                  toolbar: [
                      ['bold', 'italic', 'underline', 'strike'], // Text styles
                      [{ 'color': [] }, { 'background': [] }], // Font color
                      [{ 'list': 'ordered'}, { 'list': 'bullet' }], // Lists
                      [{ 'size': ['small', false, 'large', 'huge'] }], // Font size
                      [{ 'align': [] }], // Alignment options
                      ['link', 'image'], // Add images
                      ['clean'], // Remove formatting
                      [{ 'signature': '' }]
                  ],
                  magicUrl: true,
              }
          });
            var toolbar = quill.getModule('toolbar');
            var signatureButton = toolbar.container.querySelector('.ql-signature');
            signatureButton.innerHTML = '<i class="fa  fa-signature"></i>';
            signatureButton.addEventListener('click', function() {
                // Handle click event
                $.ajax({
                    url: "{{ url('/get/email/signature') }}",
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('fast');
                    },
                    success: function(response) {
                    console.log(response);


                    var parsedData = JSON.parse(response[0].signature);
                    var converter = new QuillDeltaToHtmlConverter(parsedData.ops, {});
                    var htmlContent = converter.convert();
                    console.log(htmlContent);
                    // var htmlContent = htmlContent.replaceAll('<br/>', '<br/>\n');
                    // Insert the HTML content into the Quill editor at the end
                    quill.root.innerHTML += htmlContent;
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    },
                    complete: function () {
                        $(".se-pre-con").fadeOut('fast');

                    }
                });

            });
            $(document).on('click', '.compose-btn', function() {

                var hiddenDiv = document.getElementById("compose-div");
                var chatDiv = document.getElementById("mailchat-div");

                // Toggle the 'hidden' class for compose-div and chatDiv
                if (hiddenDiv.classList.contains("hidden")) {
                    document.getElementById('attachment').value = '';
                    console.log(document.getElementById('attachment').value);

                    $('#file-names-container').empty(); // Clears the content of the container
                    selectedFilesCompose = []; // Empties the array
                    console.log(selectedFilesCompose );

                    $('#email_template_create_form').trigger('reset');

                    $('.recipient-input').val('').trigger('change');
                    $('.cc-input').val('').trigger('change');
                    $('.bcc-input').val('').trigger('change');

                    // Clear subject and email body inputs
                    $('#template_subject').val('');
                    $.ajax({
                        url: "{{ url('/get/email/signature') }}",
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function () {
                            $(".se-pre-con").fadeIn('fast');
                        },
                        success: function(response) {
                        console.log(response);
                        if (response.length > 0) {

                            var bodyData = JSON.parse(response[0].signature);
                            var quillContents = [{ insert: '\n\n' }].concat(bodyData.ops);
                            // Set the contents of the Quill editor
                            quill.setContents(quillContents);

                        }

                        // Show the modal after handling the response

                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        },
                        complete: function () {
                            $(".se-pre-con").fadeOut('fast');

                        }
                    });
                    // quill.setContents('');
                    hiddenDiv.classList.remove("hidden");
                    chatDiv.classList.add("hidden");
                } else {
                    hiddenDiv.classList.add("hidden");
                    $('#SavedDraftId').val('');
                    chatDiv.classList.remove("hidden");
                }

                });
          // Function to replace img src attributes with base64 encoded images
            function replaceImgSrcWithBase64(htmlContent) {
                // Find all img elements in the HTML content
                var imgElements = $(htmlContent).find('img');

                // Loop through each img element
                imgElements.each(function() {
                    var imgSrc = $(this).attr('src');
                    var imgBase64 = getBase64Image(imgSrc);

                    // Replace the img src attribute with the base64 encoded image
                    $(this).attr('src', imgBase64);
                });

                // Return the updated HTML content
                return $(htmlContent).prop('outerHTML');
            }

            // Function to convert image URL to base64
            function getBase64Image(imgUrl) {
                var img = new Image();
                img.src = imgUrl;
                img.crossOrigin = 'Anonymous';

                var canvas = document.createElement('canvas');
                var ctx = canvas.getContext('2d');

                img.onload = function() {
                    canvas.width = this.width;
                    canvas.height = this.height;
                    ctx.drawImage(this, 0, 0);
                };

                return canvas.toDataURL();
            }

            function getQuillContent() {
                 return quill.root.innerHTML; // Assuming "quill" is your Quill editor instance
            }
            // Initialize the Quill editor
            var quillInstanceforDraft = document.querySelector('#editor-container').__quill;

            // Function to save or update the draft
            function saveDraft() {
                $('#draftsavealert').text('Saving draft');
                        // Get the content from the Quill editor
                        var quillContent = $('#editor-container').html();

                        // Replace image src attributes with base64 encoded images
                        quillContent = replaceImgSrcWithBase64(quillContent);
                        console.log(quillContent);
                        $('#email_body').val(quillContent);

                        // Get the form data
                        var formData = new FormData($('#email_template_create_form')[0]);

                        // Check if there's a saved draft ID
                        var draftId = $('#SavedDraftId').val();
                        var url = draftId ? "{{ route('updateDraft') }}" : "{{ route('saveDraft') }}"; // Update this with your save/update draft routes

                        // Make an AJAX request to save or update the draft
                        $.ajax({
                            url: url,
                            type: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            beforeSend: function () {
                                // $(".se-pre-con").fadeIn('fast');
                            },
                            success: function(response) {
                                // Handle the success response
                                // $(".se-pre-con").fadeOut('fast');
                                console.log(response);
                                // Assuming 'response' contains the JSON response from the server
                                if (response.message) {
                                    // Swal.fire({
                                    //     icon: 'success',
                                    //     title: 'Draft Saved!',
                                    //     text: response.message
                                    // });
                                    $('#draftsavealert').text(response.message);

                                    // Remove the text after 4 seconds
                                    setTimeout(function() {
                                        $('#draftsavealert').text('');
                                    }, 4000);
                                    // Optionally, you can reset the form or perform other actions here

                                    // Set the draft ID if it was a new draft
                                    if (!draftId && response.draftId) {
                                        $('#SavedDraftId').val(response.draftId);
                                    }
                                } else if (response.error) {
                                    // Swal.fire({
                                    //     icon: 'error',
                                    //     title: 'Error!',
                                    //     text: response.error
                                    // });
                                    $('#draftsavealert').text(response.error);

                                    // Remove the text after 4 seconds
                                    setTimeout(function() {
                                        $('#draftsavealert').text('');
                                    }, 4000);
                                }
                            },
                            error: function(xhr, status, error) {
                                // Handle the error response
                                $(".se-pre-con").fadeOut('fast');
                                console.error(xhr.responseText);
                                $('#draftsavealert').text('Fail to save Draft');

                                // Remove the text after 4 seconds
                                setTimeout(function() {
                                    $('#draftsavealert').text('');
                                }, 4000);
                            }
                        });

            }

            // Variable to store the timeout ID
            var saveDraftTimeout;

            // Function to start the save draft timeout
            function startSaveDraftTimeout() {
                // Clear any existing timeout
                clearTimeout(saveDraftTimeout);
                // Set a new timeout to save the draft after 15 seconds of inactivity
                saveDraftTimeout = setTimeout(saveDraft, 15000); // 15 seconds
            }

            // Attach the text-change event to the Quill editor
            quillInstanceforDraft.on('text-change', function(delta, oldDelta, source) {
                if (source == 'user') {
                    startSaveDraftTimeout();
                }
            });
            $(document).on('click', '#save-draft', saveDraft);

            // $(document).on('click', '#save-draft', function() {
            //     Swal.fire({
            //     title: "Are you sure?",
            //     text: "Save this message in Draft",
            //     icon: "warning",
            //     showCancelButton: true,
            //     confirmButtonColor: "#3085d6",
            //     cancelButtonColor: "#d33",
            //     confirmButtonText: "Yes"
            //     }).then((result) => {
            //         if (result.value) {
            //             // Get the content from the Quill editor
            //             var quillContent = $('#editor-container').html();

            //             // Replace image src attributes with base64 encoded images
            //             quillContent = replaceImgSrcWithBase64(quillContent);
            //             console.log(quillContent);
            //             $('#email_body').val(quillContent);

            //             // Get the form data
            //             var formData = new FormData($('#email_template_create_form')[0]);

            //             // Make an AJAX request to save the draft
            //             $.ajax({
            //                 url: "{{ route('saveDraft') }}", // Update this with your save draft route
            //                 type: "POST",
            //                 data: formData,
            //                 contentType: false,
            //                 processData: false,
            //                 beforeSend: function () {
            //                     $(".se-pre-con").fadeIn('fast');
            //                 },
            //                 success: function(response) {
            //                     // Handle the success response
            //                     $(".se-pre-con").fadeOut('fast');
            //                     console.log(response);
            //                     // Assuming 'response' contains the JSON response from the server
            //                     if (response.message) {
            //                         Swal.fire({
            //                             icon: 'success',
            //                             title: 'Draft Saved!',
            //                             text: response.message
            //                         });
            //                         // Optionally, you can reset the form or perform other actions here

            //                     } else if (response.error) {
            //                         Swal.fire({
            //                             icon: 'error',
            //                             title: 'Error!',
            //                             text: response.error
            //                         });
            //                     }

            //                     // You can display a success message or redirect the user here
            //                 },
            //                 error: function(xhr, status, error) {
            //                     // Handle the error response
            //                     $(".se-pre-con").fadeOut('fast');
            //                     console.error(xhr.responseText);
            //                     Swal.fire({
            //                         icon: 'error',
            //                         title: 'Error!',
            //                         text: 'Failed to save draft'
            //                     });
            //                 }
            //             });

            //         }
            //     });
            // });
            $(document).on('click', '#save-template-reply', function() {
                $('#templatetitle-reply').modal('show');
            });
            $('#confirmcreateButton-reply').click(function() {
                    var delta = replymodalquill.getContents();
                    // Convert Delta format to JSON string for saving to the database
                    var jsonContent = JSON.stringify(delta);
                    var escapedJsonContent = jsonContent.replace(/'/g, "&apos;");
                    var subject = $('#reply_head_subject').val();

                    // Get the selected mailbox ID using Select2
                    template_title = $('#template_title_get-reply').val();
                    // Perform any actions you need with the selected mailbox ID
                    console.log('Selected Mailbox ID:', subject);
                    var selectElement = document.getElementById("mail_template_publish_type-reply");
                    var selectedValue = selectElement.value;
                    var selectedValueInt = parseInt(selectedValue, 10);
                    var formData = {

                            title: template_title,
                            subject: subject ,
                            templatecontent: escapedJsonContent,
                            publish_type: selectedValueInt,
                        };
                        console.log('form data'+formData);
                        $.ajax({
                            url: '{{ route("email.templates.store") }}', // Your backend endpoint
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token in headers
                            },
                            data: formData,
                            beforeSend: function () {
                                $(".se-pre-con").fadeIn('fast');
                            },
                            success: function(response) {
                                // Handle success response
                                // alert('Email template saved successfully');
                                // Optionally, you can clear the form or redirect the user

                                $('#template_title_get-reply').val('');
                                $('#templatetitle-reply').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Email template saved successfully'
                                });
                            },
                            error: function(xhr, status, error) {
                                // Handle error response
                                $(".se-pre-con").fadeOut('fast');
                                console.error('Error:', error);
                                // alert('Failed to save email template');
                                $('#templatetitle-reply').modal('hide');
                                $('#template_title_get-reply').val('');
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Failed to save email template'
                                });
                            },
                            complete: function () {
                                $(".se-pre-con").fadeOut('fast');

                            }
                        });
                    // Close the modal if necessary


                });
            $(document).on('click', '#save-template', function() {
                $('#templatetitle').modal('show');
            });
                // console.log(quillContent);
                $('#confirmcreateButton').click(function() {
                    var delta = quill.getContents();
                    // Convert Delta format to JSON string for saving to the database
                    var jsonContent = JSON.stringify(delta);
                    var escapedJsonContent = jsonContent.replace(/'/g, "&apos;");
                    var subject = $('#template_subject').val();

                    // Get the selected mailbox ID using Select2
                    template_title = $('#template_title_get').val();
                    // Perform any actions you need with the selected mailbox ID
                    console.log('Selected Mailbox ID:', subject);
                    var selectElement = document.getElementById("mail_template_publish_type");
                    var selectedValue = selectElement.value;
                    var selectedValueInt = parseInt(selectedValue, 10);
                    var formData = {

                            title: template_title,
                            subject: subject ,
                            templatecontent: escapedJsonContent,
                            publish_type: selectedValueInt,
                        };
                        console.log('form data'+formData);
                        $.ajax({
                            url: '{{ route("email.templates.store") }}', // Your backend endpoint
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token in headers
                            },
                            data: formData,
                            beforeSend: function () {
                                $(".se-pre-con").fadeIn('fast');
                            },
                            success: function(response) {
                                // Handle success response
                                // alert('Email template saved successfully');
                                // Optionally, you can clear the form or redirect the user

                                $('#template_title_get').val('');
                                $('#templatetitle').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Email template saved successfully'
                                });
                            },
                            error: function(xhr, status, error) {
                                // Handle error response
                                $(".se-pre-con").fadeOut('fast');
                                console.error('Error:', error);
                                // alert('Failed to save email template');
                                $('#templatetitle').modal('hide');
                                $('#template_title_get').val('');
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Failed to save email template'
                                });
                            },
                            complete: function () {
                                $(".se-pre-con").fadeOut('fast');

                            }
                        });
                    // Close the modal if necessary


                });


            $('#email_template_create_form').submit(function(event) {
                // Prevent the form from submitting normally
                event.preventDefault();

                // Check if the recipient input is empty
                if ($('#toRecipientInput').val().length === 0) {
                    // Display an error message to the user
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Please select at least one recipient.'
                    });
                    return false; // Explicitly return false to stop the form submission
                }

                // Check if the subject is empty
                if ($('#template_subject').val().trim() === '') {
                    // Ask the user if they want to send the email without a subject
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Subject',
                        text: 'Do you want to send the email without a subject?',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, send it',
                        cancelButtonText: 'No, add a subject'
                    }).then((result) => {
                        if (result.value) {
                            // User confirmed, proceed with form submission
                            proceedWithFormSubmission();
                        }
                    });
                } else {
                    // Subject is not empty, proceed with form submission
                    proceedWithFormSubmission();
                }

                function proceedWithFormSubmission() {
                    console.log('quillContent');

                    // Get the content from the Quill editor
                    var quillContent = $('#editor-container').html();

                    // Replace image src attributes with base64 encoded images
                    quillContent = replaceImgSrcWithBase64(quillContent);
                    console.log(quillContent);
                    $('#email_body').val(quillContent);

                    // Get the form data
                    var formData = new FormData($('#email_template_create_form')[0]);
                    $('#Draftmessageid').val('');

                    // Make an AJAX request to send the email
                    $.ajax({
                        url: "{{ route('mailSend') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function () {
                                $(".se-pre-con").fadeIn('fast');
                        },
                        success: function(response) {
                            // Handle the success response
                            console.log(response);
                            // Assuming 'response' contains the JSON response from the server
                            if (response.message) {
                                $(".se-pre-con").fadeOut('fast');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: response.message
                                });
                                $(".se-pre-con").fadeIn('fast');
                                location.reload();
                            } else if (response.error) {
                                $(".se-pre-con").fadeOut('fast');
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: response.error
                                });
                                $(".se-pre-con").fadeIn('fast');
                                location.reload();
                            }
                            // You can display a success message or redirect the user here
                        },
                        error: function(xhr, status, error) {
                            // Handle the error response
                            $(".se-pre-con").fadeOut('fast');
                            console.error(xhr.responseText);
                            // You can display an error message to the user here
                        }
                    });
                }
            });

            var signaturequill = new Quill('#signature-editor-container', {
              theme: 'snow',
              modules: {
                  imageResize: {
                      modules: ['Resize', 'DisplaySize', 'Toolbar']
                  },
                  toolbar: [
                      ['bold', 'italic', 'underline', 'strike'], // Text styles
                      [{ 'color': [] }, { 'background': [] }], // Font color
                      [{ 'list': 'ordered'}, { 'list': 'bullet' }], // Lists
                      [{ 'size': ['small', false, 'large', 'huge'] }], // Font size
                      [{ 'align': [] }], // Alignment options
                      ['link', 'image'], // Add images
                      ['clean'] // Remove formatting
                  ],
                  magicUrl: true,
              }
          });
            $(document).on('click', '#signature-create', function() {

                var delta = signaturequill.getContents();
                // Convert Delta format to JSON string for saving to the database
                var jsonContent = JSON.stringify(delta);
                var escapedJsonContent = jsonContent.replace(/'/g, "&apos;");
                var active = 1;
              $.ajax({
                    url: '{{ route("save.signature") }}',
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token in headers
                    },
                    data: {

                        signature: escapedJsonContent,
                        active: active
                    },
                    success: function(response) {
                        console.log(response);
                        Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                timer: 2000,
                                text: response.message
                            });
                            $('#mail-signature').modal('hide');
                        // Handle success response
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Handle error response
                    }
                });
          });

          $(document).on('click', '.mail-template', function() {

                console.log('works 2');

                $.ajax({
                    url: "{{ url('/get/email/signature') }}",
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('fast');
                    },
                    success: function(response) {
                    console.log(response);
                    if (response.length > 0) {

                        var bodyData = JSON.parse(response[0].signature);
                        signaturequill.setContents(bodyData.ops);
                    }

                    // Show the modal after handling the response
                    $('#mail-signature').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    },
                    complete: function () {
                        $(".se-pre-con").fadeOut('fast');
                        $('#mail-signature').modal('show');
                    }
                });

            });

          $(document).on('click', '.pick-template', function() {
              var template_id = $(this).data('template_id');
              console.log(template_id);
              $.ajax({
                  url: "{{ url('email/templates/pick') }}/" + template_id,
                  method: 'GET',
                  dataType: 'json',
                  beforeSend: function() {
                      $(".se-pre-con").fadeIn('slow');
                  },
                  success: function(data) {
                      if (data.body) {
                          try {
                            $('#template_subject').val(data.subject);
                              var bodyData = JSON.parse(data.body); // Parse the body string as JSON
                              if (bodyData.ops) {
                                  console.log(data);
                                  // Use the existing Quill instance (declared globally) to set the content
                                  quill.setContents(bodyData.ops);
                              } else {
                                  console.error("Invalid data format: ops property missing");
                                  // Handle invalid data format
                              }
                          } catch (error) {
                              console.error("Error parsing body data:", error);
                              // Handle parsing error
                          }
                      } else {
                          console.error("Invalid data format: body property missing");
                          // Handle invalid data format
                      }
                  },
                  complete: function() {
                    $('#myDropdown').toggle();
                      $(".se-pre-con").fadeOut('slow');
                  },
                  error: function(xhr, status, error) {
                      console.error("Error occurred during AJAX request:", error);
                      // Handle AJAX error
                  }
              });
          });

  });

  </script>

{{-- <script>
    var quill = new Quill('#editor', {
        theme: 'snow' // Specify theme ('snow' or 'bubble')
    });
</script> --}}
{{-- <script>
    $(document).ready(function() {

});
</script> --}}
<script>
   $(document).ready(function() {

// Initialize Select2 for To recipients
$('#toRecipientInput').select2({
    placeholder: 'To recipients...',
    ajax: {
        url: "{{ url('/searchcontacts') }}/",
        dataType: 'json',
        delay: 250,
        data: function(params) {
            return {
                q: params.term
            };
        },
        processResults: function(data) {
            var options = $.map(data, function(item) {
                return {
                    id: item.text,
                    text: item.text
                };
            });
            return { results: options };
        },
        cache: true
    },
    minimumInputLength: 2,
    tags: true
});

// Initialize Select2 for CC recipients
$('#ccRecipientInput').select2({
    placeholder: 'CC recipients...',
    ajax: {
        url: "{{ url('/searchcontacts') }}/",
        dataType: 'json',
        delay: 250,
        data: function(params) {
            return {
                q: params.term
            };
        },
        processResults: function(data) {
            var options = $.map(data, function(item) {
                return {
                    id: item.text,
                    text: item.text
                };
            });
            return { results: options };
        },
        cache: true
    },
    minimumInputLength: 2,
    tags: true
});

// Initialize Select2 for BCC recipients
$('#bccRecipientInput').select2({
    placeholder: 'BCC recipients...',
    ajax: {
        url: "{{ url('/searchcontacts') }}/",
        dataType: 'json',
        delay: 250,
        data: function(params) {
            return {
                q: params.term
            };
        },
        processResults: function(data) {
            var options = $.map(data, function(item) {
                return {
                    id: item.text,
                    text: item.text
                };
            });
            return { results: options };
        },
        cache: true
    },
    minimumInputLength: 2,
    tags: true
});

// Handle selection event for To recipients
// $('#toRecipientInput').on('select2:select', function(e) {
//     var data = e.params.data;
//     // Handle selection for To recipients...
// });

// // Handle selection event for CC recipients
// $('#ccRecipientInput').on('select2:select', function(e) {
//     var data = e.params.data;
//     // Handle selection for CC recipients...
// });

// // Handle selection event for BCC recipients
// $('#bccRecipientInput').on('select2:select', function(e) {
//     var data = e.params.data;
//     // Handle selection for BCC recipients...
// });

});

</script>
<script>
    // Get the current URL path
    console.log('message id from url : test');
    var loadmessageId =$('#needtoload').val();
    console.log('message id from url :'+loadmessageId);
    // Auto open message using Sales rep dashboard
    if (loadmessageId) {
        loadMsgData(loadmessageId, 'Inbox');
        $('#needtoload').val('');
        // Remove everything after /callbackmail from the URL path
        var baseUrl = '{{ url('/') }}'; // Laravel's base URL
        // Construct the new URL
        var newUrl = baseUrl + '/callbackmail';
        // Update the browser's URL without reloading the page
            window.history.replaceState(null, null, newUrl);
        console.log('test work 2 ');
    }


    $(document).ready(function() {

        $(document).on('click', '.org-set-toggle', function() {
            var $hiddenDiv = $('#hiddenDiv');
            if ($hiddenDiv.hasClass('hidden')) {
                $hiddenDiv.removeClass('hidden');
                $('#section-of-sidebar').show();
            } else {
                $hiddenDiv.addClass('hidden');
                $('#section-of-sidebar').hide();
            }
        });

        $(document).on('click', '.inbox_msg_row', function() {
            var messageId = $(this).data('message_id');
            var mailbox_id = $('#mailboxId').val();
            console.log('works 1');
            loadMsgData(messageId,mailbox_id);
        });



    });
    $(document).ready(function() {
        // $('.select2-people-modal').select2({
        //     dropdownParent: $('#email_people_create_modal')
        // });

        $(document).on('click', '#add_organization12', function() {
            $('#organization_create_modal').modal('show');
        });
        $(document).on('click', '.toggle-between-details', function() {

            $(this).toggleClass('fa-angle-double-right fa-angle-double-left');

            var idValue = $(this).data('message-id-value');

            $('#msg_detail_displaying' + idValue).toggleClass('col-md-9 col-md-12');
            $('#other_detail_displaying' + idValue).toggle();
        });
        $(document).on('click', '.btn-discard', function() {
            var divToRemove = document.getElementById('html-reply');

                // Check if the div exists before trying to remove it
                if (divToRemove) {
                    // Remove the div from the DOM
                    divToRemove.remove();
                    toggleButtonRow();
                } else {
                    console.log('The div does not exist.');
                }
        });

        $(document).on('click', '#add_people_from_mail', function() {
            var peopleDetails = $(this).data('people_creating_details');

            var fullName = peopleDetails.name;

            clearFields();
            if(fullName){

                fullName = fullName.toLowerCase();

                var nameParts = fullName.split(' ');

                var firstName = nameParts[0] || '';

                var lastName = nameParts.slice(1).join(' ');

                $("#people_first_name").val(firstName);
                $("#people_last_name").val(lastName);

            }
            if(peopleDetails.address){
                $("#people_email").val(peopleDetails.address);
            }


            $("#email_people_create_modal").modal('show');
        });
        $(document).on('click', '#organization_link', function() {

            $("#organization_edit_modal").modal('show');

        });
        $(document).on('click', '.add_new_activity', function() {

            var org_id_act = $(this).data('activity_org_id');
            var contact_id_act = $(this).data('activity_contact_id');

            $.ajax({
                url:"{{ url('activities/get_organizations') }}",
                method:'GET',
                dataType:'json',
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data){
                    var organizations = data;

                    console.log(organizations);

                    var start_date = moment().format('L');
                    var start_time = moment().format('LT');

                    var today_day = moment().format('dddd, MMMM Do');
                    var today_date = moment().format('L');
                    $('#selected_day').val(today_day);
                    $('#selected_date').val(today_date);

                    var today_date = today_date.replace(/\//g, '-');
                    getActivitiesByDate(today_date);

                    $('#activity_subject').val('');
                    $('.ql-editor').html('');
                    $('#activity_note').val('');
                    $('#start_date').val(start_date);
                    console.log(start_date);
                    $('#activity_priority').val(0).trigger('change');
                    $('#start_time').val('');
                    $('#is_done').prop('checked', false);

                    $('.activity-type-label').removeClass('active');
                    $('#activity_call').addClass('active');
                    $('.activity-type').prop('checked', false);
                    $('#activity_call .activity-type').prop('checked', true);

                    $('#submit_btn_text').html('Save');
                    $('#new_activity_form_title').html('Add Activity');
                    $('#is_done_div').prop('hidden', true);
                    $('#add_activity_form').attr('action', '{{ route("activities.create") }}');

                    var org_options = '<option value="">Select an Organization</option>';
                    for (let i = 0; i < organizations.length; i++) {
                        org_options += '<option value="'+organizations[i].id+'">'+organizations[i].organization_name+'</option>';
                    }
                    $('#activity_organization_id').html(org_options);
                    $('#activity_organization_id').val(org_id_act).trigger('change');
                    $('#activity_organization_id').prop('disabled', false);

                    if(contact_id_act){

                        contact_options = '<option value="'+contact_id_act.id+'">'+contact_id_act.first_name+' '+contact_id_act.last_name+'</option>';

                        $('#activity_contact_id').html(contact_options);
                    }

                    $('#activity_contact_id').prop('disabled', false);

                },
                complete: function () {

                    $('#activity_modal_new').modal('show');
                    $(".se-pre-con").fadeOut('slow');
                }
            });

        });
        $('body').on('click', '.activity-edit', function(e){
        e.preventDefault();
        var activity_id = $(this).data('activity_id');

        console.log('activity_id'+activity_id);

        $.ajax({
            url:"{{ url('activities/get_organizations') }}",
            method:'GET',
            dataType:'json',
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (data){
                var organizations = data;

                var org_options = '<option value="">Select an Organization</option>';
                for (let i = 0; i < organizations.length; i++) {
                    org_options += '<option value="'+organizations[i].id+'">'+organizations[i].organization_name+'</option>';
                }
                $('#activity_organization_id').html(org_options);
            },
            complete: function () {
                $.ajax({
                    url:"{{ url('activities/get_activity_by_id') }}/"+activity_id,
                    method:'GET',
                    dataType:'json',
                    success: function (data){
                        console.log('data');
                        console.log(data);
                        var start_date = moment(data.start_date).format('L');
                        var start_time = moment(data.start_date).format('LT');
                        var due_date = moment(data.due_date).format('L');

                        var today_day = moment().format('dddd, MMMM Do');
                        var today_date = moment().format('L');
                        $('#selected_day').html(today_day);
                        $('#selected_date').val(today_date);

                        var today_date = today_date.replace(/\//g, '-');

                        $('#activity_note').val('');
                        $('#activity_order_id').val('').trigger('change');
                        $('#activity_organization_id').val('').trigger('change');
                        $('#activity_contact_id').val('').trigger('change');

                        $('#activity_id').val(activity_id);
                        $('#activity_subject').val(data.activity_subject);
                        $('#activity_note').val(data.activity_note);
                        $('.ql-editor').html(data.activity_note);
                        $('#start_date').val(start_date);
                        $('#start_time').val(start_time);
                        $('#due_date').val(due_date);
                        $('#activity_user_id').val(data.assigned_to).trigger('change');
                        $('#is_done').prop('checked', data.is_done == 1);

                        $('#activity_organization_id').val(data.organization_id).trigger('change');
                        activity_order_id = data.order_id;
                        activity_contact_id = data.contact_id;

                        $('#submit_btn_text').html('Update');
                        // $('#activity_form_title').html('Edit');
                        $('#new_activity_form_title').html('Edit Activity');
                        $('#is_done_div').removeAttr('hidden');
                        $('#add_activity_form').attr('action', '{{ route("activities.update") }}');

                        var assignedUserName = '';
                        var modifiedUserName = '';


                        var all_users = @json($users);
                        var auth_user = @json(auth()->user()->id);

                        if(data.created_by !== null){
                            var assignedUser = all_users.find(user => user.id == data.created_by);
                        }else{
                            var assignedUser = all_users.find(user => user.id == data.assigned_to);
                        }
                        if(assignedUser){
                            if(assignedUser.id == auth_user){
                                assignedUserName = assignedUser.name + ' (You)'
                            }else{
                                assignedUserName = assignedUser.name
                            }
                        }else{
                            assignedUserName = '';
                        }
                        if(data.modified_by !== null){
                            var modifiedUser = all_users.find(user => user.id == data.modified_by);
                            if(modifiedUser){
                                if(modifiedUser.id == auth_user){
                                    modifiedUserName = modifiedUser.name + ' (You)'
                                }else{
                                    modifiedUserName = modifiedUser.name
                                }
                            }else{
                                modifiedUserName = '';
                            }
                        }

                        $('#created_at_tr').html(`<td></td><td style="color: grey;padding-top: .5rem;">Created : ${formatDate(data.created_at)}  ${assignedUserName} </td>`);
                        $('#modified_at_tr').html(`<td></td><td style="color: grey;">Last Modified : ${formatDate(data.updated_at)}  ${modifiedUserName} </td>`);
                    },
                    complete: function () {
                        // $('#activity_popup').show(700);
                        $('#activity_modal_new').modal('show');
                        $(".se-pre-con").fadeOut('slow');
                    }
                });

            }
        });
    });
        $(document).on('click', '.customBtn-DroupDown2', function() {

                event.preventDefault(); // Prevent default button behavior
                // Add your custom logic here
                console.log("Custom button clicked");
                $('#myDropdown2').toggle();
        });
        $(document).on('click', '.btn-reply', function() {
            var dataset = $(this).data('message_data');
            var from = $(this).data('message_from');
            var subject = $(this).data('subject');
            var message_id = $(this).data('message_id');

            var card = $(this).closest('.row');

            console.log(dataset);
            console.log(message_id);
            console.log(from);

            var htmlReply = `<div class="mb-4 " style="width:100%" id="html-reply">
                                            <div class="email-reply-area">

                                <div class="email-body">
                                    <div class="email-details" >
                                        <div class="col-md-12  " style="display: flex;align-content: center;flex-wrap: wrap;align-items: flex-end;height:60px;" >
                                            <label for="contactSearchInput" style="width:8%">To:</label>
                                            <select class="form-control info-form-input mt-2 recipient-input" name="recipient[]" multiple="multiple" id="toRecipientInputreply" style="width:90%;height: 1.75rem;" aria-placeholder="To">
                                            </select>
                                            <label class="toggle-cc-bcc-reply" for="contactSearchInput" style="width:2%;"><i class="fa fa-sort fa-lg" aria-hidden="true"></i></label>
                                        </div>
                                        <div class=" col-md-12  ccbcc-input-reply  hidden" style="height:50px;">
                                            <label for="ccSearchInput" style="width:8%">Cc:</label>
                                            <select class="form-control info-form-input mt-2 cc-input" name="cc[]" multiple="multiple" id="ccRecipientInputreply" style="width: 90%;height: 1.75rem;" >
                                            </select>
                                        </div>
                                        <div class="col-md-12  ccbcc-input-reply  hidden" style="height:50px;">
                                            <label for="bccSearchInput" style="width:8%">Bcc:</label>
                                            <select class="form-control info-form-input mt-2 bcc-input" name="bcc[]" multiple="multiple" id="bccRecipientInputreply" style="width: 90%;height: 1.75rem;">
                                            </select>
                                        </div>
                                        <div class="col-md-12  " style="display: inline-flex;">
                                            <label  style="width:8%;align-content: center;">Subject</label>
                                            <input type="text" class="form-control info-form-input mt-2 color-set" id="reply-subject" name="subject" value="${subject}"   style="width: 90%;height: 2.5rem;">
                                        </div>
                                        <div class="to-field col-12">
                                        <div >
                                            <div  class="btn-green-filled customBtn-DroupDown2" style="padding: 5px">Pick template</div>
                                            <div id="myDropdown2" class="dropdown-content">
                                            <input type="text" placeholder="Search.." id="myInput2" onkeyup="filterFunction2()">

                                            @foreach ($emailTemplates as $item )
                                                <p style="margin-left: 10px;" class="pick-template-reply" data-template_id="{{$item['id']}}"> {{$item['title']}}</p>
                                            @endforeach
                                            @if (isset($AddedEmailTemplates))
                                                @foreach ($AddedEmailTemplates as $item )
                                                    <p style="margin-left: 10px;" class="pick-template-reply" data-template_id="{{$item['id']}}"> {{$item['title']}}</p>
                                                @endforeach
                                            @endif
                                            </div>
                                        </div>
                                    </div>

                                    </div>
                                    <div class="email-content">
                                        <div id="reply-editor-container" style="height: 250px;"></div>
                                        <input type="hidden" id="reply-email_body" name="email_body">

                                    </div>
                                </div>
                                <div class="email-header">

                            <div class="email-header-left">


                            </div>
                                <div class="email-header-right mt-3">
                                    <button class="btn btn-send" data-message_id="${message_id}">Send</button>
                                    <button class="btn btn-discard">Discard</button>
                                </div>
                            </div>
                            </div>
                            </div>`;

            var newCardBody = $(htmlReply);


            card.before(newCardBody);
            toggleButtonRow();
            var quill = new Quill('#reply-editor-container', {
              theme: 'snow',
              modules: {
                  imageResize: {
                      modules: ['Resize', 'DisplaySize', 'Toolbar']
                  },
                  toolbar: [
                      ['bold', 'italic', 'underline', 'strike'], // Text styles
                      [{ 'color': [] }, { 'background': [] }], // Font color
                      [{ 'list': 'ordered'}, { 'list': 'bullet' }], // Lists
                      [{ 'size': ['small', false, 'large', 'huge'] }], // Font size
                      [{ 'align': [] }], // Alignment options
                      ['link', 'image'], // Add images
                      ['clean'], // Remove formatting

                  ],
                  magicUrl: true,
              }
          });
          $.ajax({
                        url: "{{ url('/get/email/signature') }}",
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function () {
                            $(".se-pre-con").fadeIn('fast');
                        },
                        success: function(response) {
                        console.log(response);
                        if (response.length > 0) {

                            var bodyData = JSON.parse(response[0].signature);
                            quill.setContents(bodyData.ops);
                        }

                        // Show the modal after handling the response

                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        },
                        complete: function () {
                            $(".se-pre-con").fadeOut('fast');

                        }
                    });


            $('#toRecipientInputreply').select2({
                placeholder: 'To recipients...',
                ajax: {
                    url: "{{ url('/searchcontacts') }}/",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        var options = $.map(data, function(item) {
                            return {
                                id: item.text,
                                text: item.text
                            };
                        });
                        return { results: options };
                    },
                    cache: true
                },
                minimumInputLength: 2,
                tags: true
            });

            // Initialize Select2 for CC recipients
            $('#ccRecipientInputreply').select2({
                placeholder: 'CC recipients...',
                ajax: {
                    url: "{{ url('/searchcontacts') }}/",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        var options = $.map(data, function(item) {
                            return {
                                id: item.text,
                                text: item.text
                            };
                        });
                        return { results: options };
                    },
                    cache: true
                },
                minimumInputLength: 2,
                tags: true
            });

            // Initialize Select2 for BCC recipients
            $('#bccRecipientInputreply').select2({
                placeholder: 'BCC recipients...',
                ajax: {
                    url: "{{ url('/searchcontacts') }}/",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        var options = $.map(data, function(item) {
                            return {
                                id: item.text,
                                text: item.text
                            };
                        });
                        return { results: options };
                    },
                    cache: true
                },
                minimumInputLength: 2,
                tags: true
            });
            var newOption = $('<option>', {
                value: from,
                text: from,
                selected: true // Select the option
            });

// Append the new option to the select element
$('#toRecipientInputreply').append(newOption);

        });
        $(document).on('click', '.dot_for_create_people', function() {
            var peopleDetails = $(this).data('people_details');

            $('#selected_people').html('<i class="fa fa-address-card ml-1" aria-hidden="true"></i>&nbsp;'+peopleDetails.name);
            $('#selected_email').html('<i class="fa fa-envelope-o ml-1" aria-hidden="true"></i>&nbsp;'+peopleDetails.address);
            $('.contact_organization').hide();

            var msgNo = $('#message_no_opened').val();

            console.log('Msg no 1 :'+msgNo);

            var email = peopleDetails.address;
            $("#add_people_from_mail").attr("data-people_creating_details", JSON.stringify(peopleDetails));

            $.ajax({
                url: '{{ url('get_organization_act') }}' + '/' + msgNo+ '/' + email,
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('fast');
                },
                success: function(response) {

                    console.log(response);
                    $('.add_new_activity-show').hide();
                    $('#organization_linked_email').val('');
                    if(response.linkedOrganization){

                        var organizationId = response.linkedOrganization.organization_detail.id;
                        var url = "{{ route('organizations.info', ['id' => ':id']) }}";
                        url = url.replace(':id', organizationId);
                        var anchorTag = '<a href="' + url + '" target="blank" class="linked-org">' +
                                            '<i class="fa fa-building ml-5" aria-hidden="true"></i>&nbsp;' +
                                            response.linkedOrganization.organization_detail.organization_name +
                                        '</a>';

                        $('#organization_linked_email').val(organizationId);

                        $('#linked_org_collection').html('');
                        $('#linked_org_collection').html('<br>' + anchorTag);
                        $('.next-act-tab').show();
                        $.ajax({
                                url: "{{ url('/email/get_next_activity') }}/",
                                method: 'GET',
                                data: {
                                    orgID: organizationId
                                },
                                beforeSend: function () {
                                    $(".se-pre-con").fadeIn('fast');
                                },
                                success: function(response) {
                                    $(".se-pre-con").fadeOut('fast');
                                    if(response.status == "success"){
                                        console.log('response Here');
                                        console.log(response.activity);
                                        $('.no-next-found').show();
                                        $('#next-act-found').show();
                                        $('#next-act-date').text(formatDate(response.activity.start_date));
                                        var truncatedSubject = response.activity.activity_subject.length > 30
                                                ? response.activity.activity_subject.substring(0, 30) + '...'
                                                : response.activity.activity_subject;
                                        $('#next-act-subject').text(truncatedSubject);
                                        $('#next-act-found').attr('data-activity_id', response.activity.id);
                                    }else{
                                        console.log('Not found records');
                                        $('.no-next-found').hide();
                                        $('#next-act-date').text('');
                                        $('#next-act-subject').text('');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error:', error);
                                }
                        });
                        $("#add_new_act_from_act").attr("data-activity_org_id", organizationId);

                        $('#organization_link').show();
                        $('#add_organization12').show();
                        $('#relink_new_org_text').text('Relink to new organization');
                        $('#relink_exist_org_text').text('Relink to existing organization');
                        //change text
                    }else{
                        $('#linked_org_collection').html('<i class="fa fa-building ml-4 mt-1 mb-1" aria-hidden="true"></i>&nbsp;No Organizations Linked');
                        $('#organization_link').show();
                        $('#add_organization12').show();
                        $('#relink_new_org_text').text('Create new organization');
                        $('#relink_exist_org_text').text('Add to existing organization');
                        $('.next-act-tab').hide();
                    }
                    if(response.contact){
                        $('.contact_organization_create').hide();
                        $('#selected_org').show();
                        if(response.contact_org_detail && response.contact_org_detail.length > 0){
                            $('#selected_org').html('');
                            if(response.contact_org_detail.length > 5){
                                $('#organizationList').html('');
                                response.contact_org_detail.forEach(element => {
                                    $('#organizationList').append('<i class="fa fa-building ml-1" aria-hidden="true"></i>&nbsp;'+element.organization_name+'<br>');
                                });
                                $('#selected_org').append('<a href="#organizationModalShow" class="modal-open-button ml-4" data-toggle="modal">View Organizations</a>');

                            }else{
                                response.contact_org_detail.forEach(element => {
                                    $('#selected_org').append('<i class="fa fa-building ml-1" aria-hidden="true"></i>&nbsp;'+element.organization_name+'<br>');
                                });
                            }
                            // $('#selected_org').html('<i class="fa fa-building ml-1" aria-hidden="true"></i>&nbsp;'+response.contact_org_detail.organization_name);
                            $('.contact_organization').show();
                            $('.add_new_activity-show').show();
                            $("#add_new_act_from_email").attr("data-activity_contact_id", JSON.stringify(response.contact));
                            $("#add_new_act_from_email").attr("data-activity_org_id", response.contact_org_detail[0].id);
                        }else{
                            $('.add_new_activity-show').hide();
                        }
                    }else{
                        $('#selected_org').show();
                        $('#organization_linked_email').val('');
                        if(response.linkedOrganization){
                            var organizationId = response.linkedOrganization.organization_detail.id;
                            var url = "{{ route('organizations.info', ['id' => ':id']) }}";
                            url = url.replace(':id', organizationId);
                            var anchorTag = '<a href="' + url + '" target="blank" class="linked-org">' +
                                                '<i class="fa fa-building ml-5" aria-hidden="true"></i>&nbsp;' +
                                                response.linkedOrganization.organization_detail.organization_name +
                                            '</a>';

                            $('#organization_linked_email').val(organizationId);

                            $('#linked_org_collection').html('');
                            $('#linked_org_collection').html(anchorTag);
                            $('.next-act-tab').show();
                            $.ajax({
                                url: "{{ url('/email/get_next_activity') }}/",
                                method: 'GET',
                                data: {
                                    orgID: organizationId
                                },
                                beforeSend: function () {
                                    $(".se-pre-con").fadeIn('fast');
                                },
                                success: function(response) {
                                    $(".se-pre-con").fadeOut('fast');
                                    if(response.status == "success"){
                                        console.log('response Here');
                                        console.log(response.activity);
                                        $('.no-next-found').show();
                                        $('#next-act-found').show();
                                        $('#next-act-date').text(formatDate(response.activity.start_date));
                                        var truncatedSubject = response.activity.activity_subject.length > 30
                                                ? response.activity.activity_subject.substring(0, 30) + '...'
                                                : response.activity.activity_subject;
                                        $('#next-act-subject').text(truncatedSubject);
                                        $('#next-act-found').attr('data-activity_id', response.activity.id);
                                    }else{
                                        console.log('Not found records');
                                        $('.no-next-found').hide();
                                        $('#next-act-date').text('');
                                        $('#next-act-subject').text('');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error:', error);
                                }
                            });
                            $("#add_new_act_from_act").attr("data-activity_org_id", organizationId);
                        }else{
                            $('#linked_org_collection').html('<i class="fa fa-building ml-4 mt-1 mb-1" aria-hidden="true"></i>&nbsp;No Organizations Linked');
                            $('.next-act-tab').hide();
                        }
                        $('.add_new_activity-show').hide();
                        $('.contact_organization_create').show();


                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                },
                complete: function () {
                $(".se-pre-con").fadeOut('fast');
                }
            });
        });
    });
    function formatDate(dateString) {
            // Create a new Date object from the dateString
            var date = new Date(dateString);

            // Extract the day, month, and year
            var day = String(date.getDate()).padStart(2, '0');
            var month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based
            var year = date.getFullYear();

            // Format the date as DD/MM/YYYY
            return `${day}/${month}/${year}`;
    }
    function replaceImgSrcWithBase64(htmlContent) {
                // Find all img elements in the HTML content
                var imgElements = $(htmlContent).find('img');

                // Loop through each img element
                imgElements.each(function() {
                    var imgSrc = $(this).attr('src');
                    var imgBase64 = getBase64Image(imgSrc);

                    // Replace the img src attribute with the base64 encoded image
                    $(this).attr('src', imgBase64);
                });

                // Return the updated HTML content
                return $(htmlContent).prop('outerHTML');
            }
            function getBase64Image(imgUrl) {
                var img = new Image();
                img.src = imgUrl;
                img.crossOrigin = 'Anonymous';

                var canvas = document.createElement('canvas');
                var ctx = canvas.getContext('2d');

                img.onload = function() {
                    canvas.width = this.width;
                    canvas.height = this.height;
                    ctx.drawImage(this, 0, 0);
                };

                return canvas.toDataURL();
            }
    // $(document).on('click', '.btn-send', function() {
    //     var from = $('.email-header-value').text(); // Get the 'From' email address
    //     var messageId = $(this).data('message_id');
    //     var quillContent = $('#reply-editor-container').html();

    //     // Replace image src attributes with base64 encoded images
    //     quillContent = replaceImgSrcWithBase64(quillContent);
    //     console.log(quillContent);
    //     $('#reply-email_body').val(quillContent);
    //     // Get other necessary data
    //     var to = $('#toRecipientInputreply').val(); // Get the 'To' recipients
    //     var cc = $('#ccRecipientInputreply').val(); // Get the 'Cc' recipients
    //     var bcc = $('#bccRecipientInputreply').val(); // Get the 'Bcc' recipients
    //     var message = $('#reply-email_body').val(); // Get the message content
    //     var subject = $('#reply-subject').val();

    //     // Prepare the data to be sent
    //     var replyData = {
    //         from: from,
    //         messageId: messageId,
    //         to: to,
    //         cc: cc,
    //         bcc: bcc,
    //         message: message,
    //         subject:subject
    //     };

    //     // Send the reply data to the server
    //     $.ajax({
    //         url: '{{ route("send.reply") }}', // Route to your controller method
    //         method: 'POST',
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token in headers
    //         },
    //         data: replyData,
    //         success: function(response) {
    //             console.log(response);
    //             // Handle success response from the server
    //             console.log('Reply sent successfully');
    //             if (response.message) {
    //                         Swal.fire({
    //                             icon: 'success',
    //                             title: 'Success!',
    //                             text: response.message
    //                         });
    //                         location.reload();
    //                     } else if (response.error) {
    //                         Swal.fire({
    //                             icon: 'error',
    //                             title: 'Error!',
    //                             text: response.error
    //                         });
    //                         location.reload();

    //                     }
    //             // Optionally, you can perform additional actions here, such as displaying a success message to the user
    //         },
    //         error: function(xhr, status, error) {
    //             // Handle error response from the server
    //             console.error('Failed to send reply:', error);
    //             // Optionally, you can display an error message to the user
    //         }
    //     });
    // });


    function loadMsgData(msgID ,mailbox_id){

        var dataset = '';

        $('#message_no_opened').val(msgID);

        $.ajax({
            url: '{{ url('view/message/') }}' + '/' + mailbox_id + '/' + msgID,
            type: 'GET',
            dataType: 'json',
            beforeSend: function () {
                $(".se-pre-con").fadeIn('fast');
            },
            success: function(response) {
                dataset = response['resultMessages'];
                var OtherMailData = response['syncingDetails'];

                if(OtherMailData.orglinkedstatus && OtherMailData.organizationId && OtherMailData.unlinkedMessageIds.length > 0){
                    syncingEmailsToOrg(OtherMailData);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            },
            complete: function () {
            $(".se-pre-con").fadeOut('fast');
                console.log('complete : '+dataset);
                if ($('#email-header').text().trim() === 'Drafts') {
                    console.log('darft nis pennanne ne..');
                    dataset = dataset[0];
                    console.log(dataset);

                    $('.recipient-input').val('').trigger('change');
                    $('.cc-input').val('').trigger('change');
                    $('.bcc-input').val('').trigger('change');
                    $('#template_subject').val('');
                    var toRecipients = dataset['message'].toRecipients;
                    var ccRecipients = dataset['message'].ccRecipients;
                    var bccRecipients = dataset['message'].bccRecipients;
                    var draftSubject = dataset['message'].subject;
                    var draftBody = dataset['message'].body['content'];
                    // console.log(draftBody);
                    function populateSelect(selector, data) {
                        var $select = $(selector);

                        $.each(data, function(index, recipient) {
                            var newOption = $('<option>', {
                                value: recipient.emailAddress.address,
                                text: recipient.emailAddress.address,
                                selected: true // Select the option
                            });

                        // Append the new option to the select element
                        $(selector).append(newOption);
                        });
                    }

                    // Populate cc and bcc selects
                    populateSelect('#ccRecipientInput', ccRecipients);
                    populateSelect('#bccRecipientInput',bccRecipients);
                    populateSelect('#toRecipientInput', toRecipients);
                    $('#template_subject').val(draftSubject);
                    $('#Draftmessageid').val(dataset['message'].id);
                    var quillInstance = document.querySelector('#editor-container').__quill;
                    if (quillInstance) {
                        quillInstance.clipboard.dangerouslyPasteHTML(draftBody);
                    }

                    var hiddenDiv = document.getElementById("compose-div");
                    var chatDiv = document.getElementById("mailchat-div");
                    hiddenDiv.classList.remove("hidden");
                    chatDiv.classList.add("hidden");
                }else{
                    $('.chat-list').empty();
                    $('.org-set-toggle').show();
                    for (var i = 0; i < dataset.length; i++) {
                        appendMsgBody(dataset[i],i);
                    }

                    appendSidebar(dataset[0].message,0);

                    var buttonset = `
                            <button type="button" style="border:none !important;border-radius: 1rem !important;background-color:transparent !important;cursor:pointer;height: 2.5rem;" class="btn-custom btn-back " title="Back"><i class="fa fa-arrow-left" style="margin-right: 10px !important; " aria-hidden="true"></i>Back</button>
                            <input class="chk_boxes" type="checkbox" value="`+msgID+`"  style="display:none;" checked>
                        `;
                    $('.chat-list').prepend(buttonset);

                    $('.toggle-between-details').click();

                    $('.dot_for_create_people:first').trigger('click');
                    $('.message-headder:first').trigger('click');


                }
            }
        });




    }
    function syncingEmailsToOrg(AllData) {

        var messageIdSet = AllData.unlinkedMessageIds;
        var Org_id = AllData.organizationId;
        var CountOfRecMsg = AllData.countOfRecMessage;

        var ajaxPromises = [];

        messageIdSet.forEach(function (messageId, index) {

            var ajaxRequest = $.ajax({
                url: '{{ url('syncing') }}' + '/' + messageId + '/' + CountOfRecMsg + '/' + Org_id,
                type: 'GET',
                success: function(response) {
                    $('#linked_org_collection').html('');
                    $('#linked_org_collection').html('<i class="fa fa-building ml-4 mt-1 mb-1" aria-hidden="true"></i>&nbsp;syncing....');
                },
                error: function(xhr, status, error) {
                    console.error('Error syncing message ' + messageId + ':', error);
                }
            });

            ajaxPromises.push(ajaxRequest);
        });

        $.when.apply($, ajaxPromises).done(function() {
            console.log('All messages have been synced.');
            $('.dot_for_create_people:first').trigger('click');
        }).fail(function() {
            console.log('Some requests failed.');
            $('.dot_for_create_people:first').trigger('click');
        });
    }


    $(document).on('click', '.message-headder', function() {
        var messageId = $(this).data('messageid');
        var container = document.getElementById('messagebodyforadd_' + messageId);
        var container2 = document.getElementById('messageAttachforadd_' + messageId);

        if (container.innerHTML.trim() === "") {
            $.ajax({
                url: "{{ url('get/message/messagedetails') }}" ,
                type: 'POST',
                dataType: 'json',
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('fast');
                },
                data: {
                    messageId: messageId,
                },
                success: function(response) {
                    var dataset = response;
                    console.log(dataset.body);


                    container.innerHTML = dataset.body;

                    $(container).closest('.row').find('.message-content').toggle();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('fast');
                }
            });

            $.ajax({
                url: "{{ url('get/message/attachments') }}/" + messageId,
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    // $(".se-pre-con").fadeIn('fast');
                },
                success: function(response) {
                    var dataset = response;
                    console.log(dataset);

                    // Initialize a variable to build the message content
                    var message = "";
                    var inlineattach = false;
                    if (dataset && dataset.length > 0) {
                                                message +=
                            '<div class="card-body">' +
                                '<p>Attachments</p>' +
                                '<div class="col-12" style="display: flex;">';

                        dataset.forEach(function(attachment) {
                            if (!attachment.isInline) {
                                inlineattach = true;
                                // Detect the file type based on the attachment name's extension
                                var fileExtension = attachment.name.split('.').pop().toLowerCase();
                                var mimeType = '';

                                switch (fileExtension) {
                                    case 'jpg':
                                    case 'jpeg':
                                        mimeType = 'image/jpeg';
                                        break;
                                    case 'png':
                                        mimeType = 'image/png';
                                        break;
                                    case 'pdf':
                                        mimeType = 'application/pdf';
                                        break;
                                    case 'doc':
                                    case 'docx':
                                        mimeType = 'application/msword';
                                        break;
                                    case 'xlsx':
                                        mimeType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                                        break;
                                    case 'zip':
                                        mimeType = 'application/zip';
                                        break;
                                    default:
                                        mimeType = 'application/octet-stream';  // Default binary stream for unknown file types
                                        break;
                                }

                                var attachmentContent = 'data:' + mimeType + ';base64,' + attachment.content;
                                var truncatedName = attachment.name.length > 40 ? attachment.name.substring(0, 40) + '...' : attachment.name;

                                // Use JavaScript to trigger download
                                message +=
                                    '<div class="Attachments-container">' +
                                        '<button  class="Attachments-button" onclick="downloadAttachment(\'' + attachmentContent + '\', \'' + attachment.name + '\')" style="width: 100px; height: 110px;">' +
                                            truncatedName +
                                        '</button>' +
                                    '</div>';
                            }
                        });

                        message +=
                            '</div>' +
                            '</div>';


                        // Append or update the message body container
                        // $('#yourMessageContainer').append(message); // Adjust the selector to your actual container
                        if(inlineattach){
                            container2.innerHTML = message;
                            container2.style.display = 'block';
                        }
                    }

                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                },
                complete: function () {
                    // Any actions after the AJAX completes
                    // $(".se-pre-con").fadeOut('fast');
                }
            });
        } else {
            // If message is already loaded, simply toggle the content visibility
            $(container).closest('.row').find('.message-content').toggle();
        }

        console.log(messageId);
    });

    function downloadAttachment(content, fileName) {
    var link = document.createElement('a');
    link.href = content;
    link.download = fileName;

    // Append the link to the body
    document.body.appendChild(link);

    // Trigger the download
    link.click();

    // Remove the link after triggering the download
    document.body.removeChild(link);
}
    function appendMsgBody(dataset,index_value){

        console.log('dataset');
        console.log(dataset);
        var azureLoggedUser = '{{ session("azure_logged_email") }}';
        var nameSentBy = dataset['message'].from.emailAddress.name;
        var id = dataset['message'].id;
        var emailSentBy = dataset['message'].from.emailAddress.address;
        var toRecipients = dataset['message'].toRecipients;
        var ccRecipients = dataset['message'].ccRecipients;
        var bccRecipients = dataset['message'].bccRecipients;
        var formattedDateTime = dataset['formatted_date'];
        // var dateSentBy = new Date(dateSentBy);
        var forwardcustomclz = ''
        var customclz = ''
        if (azureLoggedUser === emailSentBy) {
            // Hide the reply button group
            customclz = 'hidden';
        }else{
            forwardcustomclz = 'hidden';
        }
        // Get day, month, year, hours, and minutes
        // var day = dateSentBy.getDate().toString().padStart(2, '0');
        // var month = (dateSentBy.getMonth() + 1).toString().padStart(2, '0'); // Month is zero-based
        // var year = dateSentBy.getFullYear();
        // var hours = dateSentBy.getHours().toString().padStart(2, '0');
        // var minutes = dateSentBy.getMinutes().toString().padStart(2, '0');

        // // Format the date and time string
        // var formattedDateTime = day + '/' + month + '/' + year + ' - ' + hours + ':' + minutes;
        var subject = dataset['message'].subject;
        // var body = dataset['message'].body.content;

        var ccEmails = dataset['message'].ccRecipients;

        var msgNo = $('#message_no_opened').val();

        console.log('Msg no 2:'+msgNo);

        $('#organization_messageNo').val(msgNo);
        $('#organization_mail_sender').val(dataset['message'].from.emailAddress.name);
        $('#organization_mail_subject').val(dataset['message'].subject);
        $('#organization_messageNo_edit').val(msgNo);
        $('#organization_mail_sender_edit').val(dataset['message'].from.emailAddress.name);
        $('#organization_mail_subject_edit').val(dataset['message'].subject);


        var message = `<div class="card " style="max-height: 100vh; overflow-y: auto;border-top:1px solid rgba(0, 0, 0, .05);overflow-x: clip;">
                <div class="card-header message-headder" data-messageid = "`+id+`">
                    <h2>`+subject+`</h2>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div>
                                    <div class="dot" style="background-color: `+getRandomColor()+`">
                                        <span class="white-text" style="color:white;">
                                            `+nameSentBy.charAt(0).toUpperCase()+`
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <small style="font-size: 100%;"><span class="text-bold">`+nameSentBy+`</span> &lt;`+emailSentBy+`&gt;</small><br>
                                    `;

                                    // Check if ccRecipients array is not empty
                                    if (toRecipients.length > 0) {
                                        message += `<small class="hover_my_acc" style="font-size: 100%; color: grey; cursor: pointer">to: `;
                                        // Loop through ccRecipients array and concatenate each email address
                                        for (var i = 0; i < toRecipients.length; i++) {
                                            message += toRecipients[i].emailAddress.address + ',&nbsp;&nbsp;&nbsp';
                                        }
                                        message += `</small><br>`;
                                    }

                                    message += `

                                    `;

                                    // Check if ccRecipients array is not empty
                                    if (ccRecipients.length > 0) {
                                        message += `<small class="hover_my_acc" style="font-size: 100%; color: grey; cursor: pointer">cc: `;
                                        // Loop through ccRecipients array and concatenate each email address
                                        for (var i = 0; i < ccRecipients.length; i++) {
                                            message += ccRecipients[i].emailAddress.address + ',&nbsp;&nbsp;&nbsp';
                                        }
                                        message += `</small><br>`;
                                    }

                                    message += `
                                    `;
// `+ (index_value == 0 ? '' : ' style="display: none;"') +`
                                    // Check if ccRecipients array is not empty
                                    if (bccRecipients.length > 0) {
                                        message += `<small class="hover_my_acc" style="font-size: 100%; color: grey; cursor: pointer">cc: `;
                                        // Loop through ccRecipients array and concatenate each email address
                                        for (var i = 0; i < bccRecipients.length; i++) {
                                            message += bccRecipients[i].emailAddress.address + ',&nbsp;&nbsp;&nbsp';
                                        }
                                        message += `</small><br>`;
                                    }

                                    message += `

                                </div>

                            </div>

                        </div>

                        <div class="col-md-3 text-right">
                            <small style="font-size: 100%;">`+formattedDateTime+`</small><br>

                            <div class="btn-group">
                                <button type="button"  data-messageid = "`+id+`" class="btn custom-btn btn-outline-secondary btn-sm reply-all-head"><i class="fas fa-reply-all" style="padding-right: 5px;"></i>Reply All</button>
                                <button type="button" class="btn btn-outline-secondary custom-btn btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item reply-head" data-messageid = "`+id+`" href="#">Reply</a>
                                    <a class="dropdown-item reply-all-head" data-messageid = "`+id+`" href="#">Reply All</a>
                                    <a class="dropdown-item forward-head" data-messageid = "`+id+`" href="#">Forward</a>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row" style="    height: fit-content;overflow-y: scroll;overflow-x:clip">
                    <div class="col-md-12 message-content" id="msg_detail_displaying`+index_value+`" style="display: none;" >
                        <div class="modal-body reply_here_add" id = "replyadd_`+id+`"> </div>
                        <div class="card-body " id="messageAttachforadd_`+id+`" style="padding-top:0;padding-bottom: 0px;border-bottom: 1px solid #cdcdcd;display:none">

                        </div>
                        <div class="card-body " id="messagebodyforadd_`+id+`" style="padding-top:0">

                        </div>
                        `;

                        // if (dataset['attachments'] && dataset['attachments'].length > 0) {
                        //     message += `
                        //             <div class="card-body">
                        //                 <p>Attachments</p>
                        //                 <div class="col-12" style="display: flex;">`;

                        //     dataset['attachments'].forEach(function(attachment) {
                        //         if(!(attachment.isInline)){

                        //             var attachmentContent = 'data:application/octet-stream;base64,' + attachment.content; // Adjust this based on your data structure
                        //             var truncatedName = attachment.name.length > 40 ? attachment.name.substring(0, 40) + '...' : attachment.name;
                        //             message += `
                        //                         <div class="Attachments-container">
                        //                             <a href="` + attachmentContent + `" download="` + attachment.name + `" class="Attachments-button" style="width: 100px; height: 110px;">
                        //                                 ` + truncatedName + `
                        //                             </a>
                        //                         </div>`;
                        //         }
                        //     });

                        //     message += `
                        //                 </div>
                        //             </div>`;
                        // }

                        message += `
                    </div>


                </div>

            </div>`;

            $('.chat-list').append(message);
    }
    function appendSidebar(dataset, index_value) {
    var nameSentBy = dataset.from.emailAddress.name;
    var emailSentBy = dataset.from.emailAddress.address;
    var ccEmails = dataset.ccRecipients || [];
    var replyToEmails = dataset.replyTo || [];
    var toEmails = dataset.toRecipients || [];
    var peopleElement = '';

    // Create the initial people element for the sender
    peopleElement += `
        <div class="dot dot_for_create_people" data-people_details='${JSON.stringify(dataset.from.emailAddress)}' style="margin:3px;cursor:pointer;background-color: ${getRandomColor()}">
            <span class="white-text" style="color:white;">
                ${nameSentBy.charAt(0).toUpperCase()}
            </span>
        </div>`;

    // Add ccRecipients to peopleElement
    ccEmails.forEach(cc => {
        peopleElement += `
            <div class="dot dot_for_create_people" data-people_details='${JSON.stringify(cc.emailAddress)}' style="margin:3px;cursor:pointer;background-color: ${getRandomColor()}">
                <span class="white-text" style="color:white;">
                    ${cc.emailAddress.name.charAt(0).toUpperCase()}
                </span>
            </div>`;
    });

    // Add replyTo to peopleElement
    replyToEmails.forEach(replyTo => {
        peopleElement += `
            <div class="dot dot_for_create_people" data-people_details='${JSON.stringify(replyTo.emailAddress)}' style="margin:3px;cursor:pointer;background-color: ${getRandomColor()}">
                <span class="white-text" style="color:white;">
                    ${replyTo.emailAddress.name.charAt(0).toUpperCase()}
                </span>
            </div>`;
    });

    // Add toRecipients to peopleElement
    toEmails.forEach(to => {
        peopleElement += `
            <div class="dot dot_for_create_people" data-people_details='${JSON.stringify(to.emailAddress)}' style="margin:3px;cursor:pointer;background-color: ${getRandomColor()}">
                <span class="white-text" style="color:white;">
                    ${to.emailAddress.name.charAt(0).toUpperCase()}
                </span>
            </div>`;
    });

    var totalPeople = 1 + ccEmails.length + replyToEmails.length + toEmails.length;

    var sidebarHTML = `
    <div  id="hiddenDiv" class="hidden" style="width:17rem;background-color: white;padding: .5rem;">
                        <div class=" mt-3">
                            <div class="col-md-12 mt-2" style="color: rgb(167, 60, 255);font-weight: bold;margin: 0px 10px;text-transform: uppercase;">
                                `+((ccEmails.length) + 1)+` PEOPLE IN THIS CONVERSATION
                            </div>
                            <div class="col-md-12 row mt-2" style="margin:0px">
                                `+peopleElement+`
                            </div>
                            <div class="col-md-12 row mt-2 pt-1" style="border-top:1px solid #BBC1E1;margin:0px">
                                <div style="display: flex; align-items: center;">
                                    <small class="text-bold" style="font-size: 100%;" id="selected_people"><i class="fa fa-address-card ml-1" aria-hidden="true"></i>&nbsp;`+nameSentBy+`</small><br>
                                </div>
                            </div>
                            <div class="col-md-12 mt-1">
                                <small class="text-bold" style="font-size: 100%;" id="selected_email"><i class="fa fa-envelope-o ml-1" aria-hidden="true"></i>&nbsp;`+emailSentBy+`</small><br>
                            </div>
                            <div class="col-md-12 mt-1 mb-2 contact_organization" style="display:none">
                                <small class="text-bold" style="font-size: 100%;" id="selected_org"><i class="fa fa-building ml-1" aria-hidden="true"></i>&nbsp;No Organization Linked</small><br>
                            </div>
                            <div class="col-md-12" style="border-bottom: 1px solid #BBC1E1;">
                                <div class="normal-btn-1 add_new_activity add_new_activity-show contact_organization mb-3 mt-1" data-activity_contact_id="" data-activity_org_id="" id="add_new_act_from_email" style="display:none">
                                <span class="btn-caption"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;ADD ACTIVITY   </span>
                                </div>

                                <div class="normal-btn-green contact_organization_create mb-2" id="add_people_from_mail" data-people_creating_details="">
                                    <span class="btn-green-caption" > Create new contact</span>
                                </div>
                            </div>
                        </div>
                        <div class="" style="margin-top: 20px;">
                            <div class="col-md-12 mt-2" style="color: rgb(167, 60, 255);font-weight: bold;margin: 0px 10px;text-transform: uppercase;">
                                LINK TO AN ORGANIZATION
                            </div>
                            <div class="col-md-12 mt-2 mb-2">
                                <div class="oragnization-caption">
                                    <span style="display: inline-flex;margin: auto 25px;">Find an existing organization or create a new one</span>
                                </div>
                                <div class="mb-2" id="linked_org_collection">
                                </div>
                                <div class="normal-btn" id="organization_link">
                                    <span class="btn-caption" id="relink_exist_org_text"> Add to existing organization</span>
                                </div>

                                <div class="normal-btn-green" id="add_organization12">
                                    <span class="btn-green-caption" id="relink_new_org_text"> Create new organization</span>
                                </div>
                            </div>
                        </div>
                        <div class="next-act-tab mt-2 mb-5"  style="border-top: 1px solid #BBC1E1;display:none">
                            <div class="col-md-12 mt-2" style="color: rgb(167, 60, 255);font-weight: bold;margin: 0px 10px;text-transform: uppercase;">
                                NEXT ACTIVITY
                            </div>
                            <div class="list-group mt-2 no-next-found" style="padding: 0rem 1rem 0rem 1rem;display:none">
                                <a href="#" id="next-act-found" class="list-group-item list-group-item-action activity-edit" tabindex="-1" aria-disabled="true" style="border-radius: 0rem;" data-activity_id="">
                                    <small style="font-size: .8rem;color: black;" id="next-act-subject"></small><br>
                                    <small style="font-size: .8rem;" id="next-act-date"></small>
                                </a>
                            </div>
                            <div class="col-md-12 mt-2 mb-2">
                                <div class="normal-btn-1 mb-3 mt-1 add_new_activity" data-activity_contact_id="" data-activity_org_id="" id="add_new_act_from_act">
                                <span class="btn-caption"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;ADD ACTIVITY   </span>
                                </div>
                            </div>
                        </div>
                    </div>`;

    console.log(sidebarHTML);

    $('#section-of-sidebar').html(sidebarHTML);
}
    function getRandomColor() {
        var red = Math.floor(Math.random() * 256);
        var green = Math.floor(Math.random() * 256);
        var blue = Math.floor(Math.random() * 256);

        var redHex = ('0' + red.toString(16)).slice(-2);
        var greenHex = ('0' + green.toString(16)).slice(-2);
        var blueHex = ('0' + blue.toString(16)).slice(-2);

        var color = '#' + redHex + greenHex + blueHex;

        return color;
    }
</script>


{{-- script section --}}
<script>

        function updateSidebarCounts() {
            $.ajax({
                url: "{{ url('/sidebar-counts') }}/",
                method: 'GET',
                success: function(data) {
                    data.forEach(item => {
                        let sidebarItem = $(`.mail-sidebar-item[data-folder="${item.id}"]`);
                        if (sidebarItem.length) {
                            if (item.displayName === 'Drafts' && item.totalItemCount > 0) {
                                sidebarItem.find('.item-count').text(item.totalItemCount).show();
                            } else if (item.unreadItemCount > 0) {
                                sidebarItem.find('.item-count').text(item.unreadItemCount).show();
                            } else {
                                sidebarItem.find('.item-count').hide();
                            }
                        }

                        if (item.childFolders && item.childFolders.length) {
                            item.childFolders.forEach(child => {
                                let childItem = $(`.mail-sidebar-item[data-folder="${child.id}"]`);
                                if (childItem.length) {
                                    childItem.find('.child-item-count').text(`${child.unreadItemCount}/${child.totalItemCount}`);
                                }
                            });
                        }
                    });
                },
                error: function(error) {
                    console.error('Error fetching sidebar counts:', error);
                }
            });
        }

        // Fetch and update counts periodically
        setInterval(updateSidebarCounts, 60000); // Update every 60 seconds
        updateSidebarCounts(); // Initial call

    function makeAjaxRequest(action, checkedValues, selectedMailboxId) {
        // Make an AJAX request to fetch data
        $.ajax({
            url: "{{ url('/maiibox/action') }}/",
            method: 'GET',
            data: {
                action: action,
                chat_id_set: checkedValues,
                move_to: selectedMailboxId
            },
            beforeSend: function () {
                    $(".se-pre-con").fadeIn('fast');
                },
            success: function(response) {
                // Assuming the response is an object with 'title' and 'content' properties
                console.log(response);
                var page_number = $('#pageNumber').val();
                var mailbox_id = $('#mailboxId').val();
                loadMessages(mailbox_id,page_number);
                updateSidebarCounts();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
    $(document).ready(function() {
        $('.mailboxselect2').select2(
            {
                width: '100%',
            }
        );
        var sidebarItems = @json($sidebarItems);

        // Select the Select2 dropdown element
        var $select = $('.mailboxselect2');

        // Clear existing options
        $select.empty();
        $select.css('border', '1px solid #ccc');
        // Add options dynamically
        sidebarItems.forEach(function(item) {
            $select.append($('<option>', {
                value: item.id,
                text: item.displayName
            }));
        });
        // Listen for clicks on the "SelectAll" checkbox
        $(document).on('click', '#SelectAll', function() {
            console.log('SelectAll checkbox clicked');
            // If it's checked, check all checkboxes with class "chk_boxes"
            if ($(this).prop('checked')) {
                $('.chk_boxes').prop('checked', true);
            } else {
                // If it's unchecked, uncheck all checkboxes with class "chk_boxes"
                $('.chk_boxes').prop('checked', false);
                $('.selectalldiv').remove();
            }
        });

        //icon set script
        $('.chat-mail-action').click(function() {
                // Retrieve the folder from the data-folder attribute
                var action = $(this).data('action');
                console.log(action);
                var checkedValues = [];
                var selectedMailboxId = '';

                // Iterate over each checkbox with class .chk_boxes
                $('.chk_boxes').each(function() {
                    // Check if the checkbox is checked
                    if ($(this).prop('checked')) {
                        // Push the value of the checked checkbox into the array
                        checkedValues.push($(this).val());
                    }
                });

                // Check if no checkboxes are checked
                if (checkedValues.length === 0) {
                    // Display a SweetAlert alert if no checkboxes are checked
                    swal("Oops!", "Please select the chat first.", "warning");
                } else {
                    // Proceed with the desired action since at least one checkbox is checked
                    // For example, continue with sending the form data or performing any other action
                    console.log("Checkbox values:", checkedValues);
                    if (action == 'move') {
                        $('#chatfolderselect').modal('show');
                        $('#confirmMoveButton').click(function() {
                            // Get the selected mailbox ID using Select2
                            selectedMailboxId = $('.mailboxselect2').val();
                            // Perform any actions you need with the selected mailbox ID
                            console.log('Selected Mailbox ID:', selectedMailboxId);
                            // Close the modal if necessary
                            $('#chatfolderselect').modal('hide');
                            makeAjaxRequest(action, checkedValues, selectedMailboxId);
                        });
                    }else{

                        makeAjaxRequest(action, checkedValues, selectedMailboxId);
                    }
                }
        });
    });
</script>
<script>
    $(document).ready(function() {
        document.querySelectorAll('.down-arrow').forEach(function(arrow) {
    arrow.addEventListener('click', function() {
        // Toggle the visibility of the next sibling element with class "child-list"
        var childList = this.parentNode.nextElementSibling;
        if (childList) {
            childList.classList.toggle('show');
            this.querySelector('i').classList.toggle('fa-chevron-down');
            this.querySelector('i').classList.toggle('fa-chevron-right');
        }
    });
});



});


     $(document).ready(function() {
        $(".se-pre-con").fadeOut('slow');
        var pageNumber = 1;
        var mailboxId = 'Inbox';
        $('#pageNumber').val(pageNumber);
        $('#mailboxId').val(mailboxId);

     });

     function toggleButtonRow() {
        var btnRow = document.getElementById('btn-row');
        btnRow.style.display = (btnRow.style.display === 'none') ? 'block' : 'none';
    }

    $(document).ready(function() {
        function destory_editor(selector){
            if($(selector)[0])
            {
                var content = $(selector).find('.ql-editor').html();
                $(selector).html(content);

                $(selector).siblings('.ql-toolbar').remove();
                $(selector + " *[class*='ql-']").removeClass (function (index, css) {
                return (css.match (/(^|\s)ql-\S+/g) || []).join(' ');
                });

                $(selector + "[class*='ql-']").removeClass (function (index, css) {
                return (css.match (/(^|\s)ql-\S+/g) || []).join(' ');
                });
            }
            else
            {
                console.error('editor not exists');
            }
        }

        // $(document).on('click', '#save-draft-reply', function() {
        //     // $('#modal-reply').modal('hide');
        //     var messageId = $(this).data('message_id');
        //     var quillContent = $('#reply-modal-editor-container').html();
        //     var mailboxId = $('#mailboxId').val();

        //     // Replace image src attributes with base64 encoded images
        //     quillContent = replaceImgSrcWithBase64(quillContent);
        //     $('#email_body-replymessage').val(quillContent);

        //     var to = $('#replytoRecipientInput').val();
        //     var cc = $('#replyccRecipientInput').val();
        //     var bcc = $('#replybccRecipientInput').val();
        //     var message = $('#email_body-replymessage').val();
        //     var subject = $('#reply_head_subject').val();
        //     var attachments = document.getElementById('attachmentreply').files;

        //     var attachmentPromises = [];

        //     // Convert each attachment to Base64
        //     for (var i = 0; i < attachments.length; i++) {
        //         let file = attachments[i];
        //         attachmentPromises.push(new Promise((resolve, reject) => {
        //             let reader = new FileReader();
        //             reader.onload = function(e) {
        //                 resolve({
        //                     name: file.name,
        //                     type: file.type,
        //                     content: e.target.result.split(',')[1]  // Get the base64 content without the prefix
        //                 });
        //             };
        //             reader.onerror = function(e) {
        //                 reject(e);
        //             };
        //             reader.readAsDataURL(file);
        //         }));
        //     }

        //     Promise.all(attachmentPromises).then((base64Attachments) => {
        //         var replyData = {
        //             messageId: messageId,
        //             to: to,
        //             cc: cc,
        //             bcc: bcc,
        //             message: message,
        //             subject: subject,
        //             attachments: base64Attachments
        //         };

        //         $.ajax({
        //             url: '{{ route("saveDraftReply") }}', // Route to your controller method
        //             method: 'POST',
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             contentType: 'application/json',
        //             data: JSON.stringify(replyData),
        //             beforeSend: function() {
        //                 $(".se-pre-con").fadeIn('slow');
        //             },
        //             success: function(response) {
        //                 console.log(response);
        //                 $(".se-pre-con").fadeOut('fast');
        //                 $('#attachmentreply').val('');
        //                 var fileNamesContainer = $('#file-names-container-reply');
        //                 // Clear any previous file names
        //                 fileNamesContainer.empty();
        //                 if (response.message) {
        //                     Swal.fire({
        //                         icon: 'success',
        //                         title: 'Success!',
        //                         timer: 2000,
        //                         text: response.message
        //                     });

        //                 } else if (response.error) {
        //                     Swal.fire({
        //                         icon: 'error',
        //                         title: 'Error!',
        //                         timer: 2000,
        //                         text: response.error
        //                     });

        //                 }
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error('Failed to send reply:', error);
        //                 $('#modal-reply').modal('hide');
        //                 $('#attachmentreply').val('');
        //                 var fileNamesContainer = $('#file-names-container-reply');
        //                 // Clear any previous file names
        //                 fileNamesContainer.empty();
        //                 $(".se-pre-con").fadeOut('fast');
        //                 Swal.fire({
        //                     icon: 'error',
        //                     title: 'Error!',
        //                     timer: 2000,
        //                     text: 'Failed to save draft message ' + error
        //                 });
        //             }
        //         });
        //     }).catch((error) => {
        //         console.error('Failed to convert attachments to Base64:', error);
        //     });
        // });

        $(document).on('click', '#reply-btn-send', function() {
            var messageId = $(this).data('message_id');
            var quillContent = $('#reply-modal-editor-container').html();
            var mailboxId = $('#mailboxId').val();

            // Replace image src attributes with base64 encoded images
            quillContent = replaceImgSrcWithBase64(quillContent);
            $('#email_body-replymessage').val(quillContent);

            var to = $('#replytoRecipientInput').val();
            var cc = $('#replyccRecipientInput').val();
            var bcc = $('#replybccRecipientInput').val();
            var message = $('#email_body-replymessage').val();
            var subject = $('#reply_head_subject').val();
            var attachments = document.getElementById('attachmentreply').files;
            var draftId = $('#SavedDraftIdReply').val();

            // Check if the recipient input is empty
            if (to.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Please select at least one recipient.'
                });
                return false; // Explicitly return false to stop the form submission
            }

            // Check if the subject is empty
            if (subject.trim() === '') {
                // Ask the user if they want to send the email without a subject
                Swal.fire({
                    icon: 'warning',
                    title: 'No Subject',
                    text: 'Do you want to send the email without a subject?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, send it',
                    cancelButtonText: 'No, add a subject'
                }).then((result) => {
                    if (result.value) {
                        // User confirmed, proceed with form submission
                        sendReply(messageId, mailboxId, quillContent, to, cc, bcc, message, subject, attachments, draftId);
                    }
                });
            } else {
                // Subject is not empty, proceed with form submission
                sendReply(messageId, mailboxId, quillContent, to, cc, bcc, message, subject, attachments, draftId);
            }
        });

        function sendReply(messageId, mailboxId, quillContent, to, cc, bcc, message, subject, attachments, draftId) {
            $('#modal-reply').modal('hide');
            var attachmentPromises = [];

            // Convert each attachment to Base64
            for (var i = 0; i < attachments.length; i++) {
                let file = attachments[i];
                attachmentPromises.push(new Promise((resolve, reject) => {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        resolve({
                            name: file.name,
                            type: file.type,
                            content: e.target.result.split(',')[1]  // Get the base64 content without the prefix
                        });
                    };
                    reader.onerror = function(e) {
                        reject(e);
                    };
                    reader.readAsDataURL(file);
                }));
            }

            Promise.all(attachmentPromises).then((base64Attachments) => {
                var replyData = {
                    messageId: messageId,
                    to: to,
                    cc: cc,
                    bcc: bcc,
                    message: message,
                    subject: subject,
                    attachments: base64Attachments,
                    draftId : draftId,
                };

                $.ajax({
                    url: '{{ route("send.reply") }}', // Route to your controller method
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: 'application/json',
                    data: JSON.stringify(replyData),
                    beforeSend: function() {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function(response) {
                        console.log(response);
                        $(".se-pre-con").fadeOut('fast');
                        $('#attachmentreply').val('');
                        var fileNamesContainer = $('#file-names-container-reply');
                        // Clear any previous file names
                        fileNamesContainer.empty();
                        if (response.message) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                timer: 2000,
                                text: response.message
                            });
                            loadMsgData(messageId, mailboxId);
                        } else if (response.error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                timer: 2000,
                                text: response.error
                            });
                            loadMsgData(messageId, mailboxId);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to send reply:', error);
                        $('#modal-reply').modal('hide');
                        $('#attachmentreply').val('');
                        var fileNamesContainer = $('#file-names-container-reply');
                        // Clear any previous file names
                        fileNamesContainer.empty();
                        $(".se-pre-con").fadeOut('fast');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            timer: 2000,
                            text: 'Failed to send message ' + error
                        });
                    }
                });
            }).catch((error) => {
                console.error('Failed to convert attachments to Base64:', error);
            });
        }

        $(document).on('click', '#reply-btn-forward', function() {

            var messageId = $(this).data('message_id');
            var quillContent = $('#reply-modal-editor-container').html();
            var mailboxId = $('#mailboxId').val();

            // Replace image src attributes with base64 encoded images
            quillContent = replaceImgSrcWithBase64(quillContent);
            $('#email_body-replymessage').val(quillContent);

            var to = $('#replytoRecipientInput').val();
            var cc = $('#replyccRecipientInput').val();
            var bcc = $('#replybccRecipientInput').val();
            var message = $('#email_body-replymessage').val();
            var subject = $('#reply_head_subject').val();
            var attachments = document.getElementById('attachmentreply').files;
            var draftId = $('#SavedDraftIdReply').val();

            // Check if the recipient input is empty
            if (to.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Please select at least one recipient.'
                });
                return false; // Explicitly return false to stop the form submission
            }

            // Check if the subject is empty
            if (subject.trim() === '') {
                // Ask the user if they want to send the email without a subject
                Swal.fire({
                    icon: 'warning',
                    title: 'No Subject',
                    text: 'Do you want to send the email without a subject?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, send it',
                    cancelButtonText: 'No, add a subject'
                }).then((result) => {
                    if (result.value) {
                        // User confirmed, proceed with form submission
                        sendForward(messageId, mailboxId, quillContent, to, cc, bcc, message, subject, attachments, draftId);
                    }
                });
            } else {
                // Subject is not empty, proceed with form submission
                sendForward(messageId, mailboxId, quillContent, to, cc, bcc, message, subject, attachments, draftId);
            }
        });

function sendForward(messageId, mailboxId, quillContent, to, cc, bcc, message, subject, attachments, draftId) {
    var attachmentPromises = [];
    $('#modal-reply').modal('hide');
    // Convert each attachment to Base64
    for (var i = 0; i < attachments.length; i++) {
        let file = attachments[i];
        attachmentPromises.push(new Promise((resolve, reject) => {
            let reader = new FileReader();
            reader.onload = function(e) {
                resolve({
                    name: file.name,
                    type: file.type,
                    content: e.target.result.split(',')[1]  // Get the base64 content without the prefix
                });
            };
            reader.onerror = function(e) {
                reject(e);
            };
            reader.readAsDataURL(file);
        }));
    }

    Promise.all(attachmentPromises).then((base64Attachments) => {
        var forwardData = {
            messageId: messageId,
            to: to,
            cc: cc,
            bcc: bcc,
            message: message,
            subject: subject,
            attachments: base64Attachments,
            draftId : draftId,
        };

        $.ajax({
            url: '{{ route("send.forward") }}', // Route to your controller method
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: 'application/json',
            data: JSON.stringify(forwardData),
            beforeSend: function() {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(response) {
                console.log(response);
                $(".se-pre-con").fadeOut('fast');
                $('#attachmentreply').val('');
                $('#file-names-container-reply').empty(); // Clear any previous file names
                if (response.message) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        timer: 2000,
                        text: response.message
                    });
                    loadMsgData(messageId, mailboxId);
                } else if (response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        timer: 2000,
                        text: response.error
                    });
                    loadMsgData(messageId, mailboxId);
                }
            },
            error: function(xhr, status, error) {
                console.error('Failed to send forward:', error);
                $('#modal-reply').modal('hide');
                $('#attachmentreply').val('');
                $('#file-names-container-reply').empty(); // Clear any previous file names
                $(".se-pre-con").fadeOut('fast');
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    timer: 2000,
                    text: 'Failed to send message ' + error
                });
            }
        });
    }).catch((error) => {
        console.error('Failed to convert attachments to Base64:', error);
    });
}

        // $(document).on('click', '#save-draft-forward', function() {
        //     // $('#modal-reply').modal('hide');
        //     var messageId = $(this).data('message_id');
        //     var quillContent = $('#reply-modal-editor-container').html();
        //     var mailboxId = $('#mailboxId').val();

        //     // Replace image src attributes with base64 encoded images
        //     quillContent = replaceImgSrcWithBase64(quillContent);
        //     $('#email_body-replymessage').val(quillContent);

        //     var to = $('#replytoRecipientInput').val();
        //     var cc = $('#replyccRecipientInput').val();
        //     var bcc = $('#replybccRecipientInput').val();
        //     var message = $('#email_body-replymessage').val();
        //     var subject = $('#reply_head_subject').val();
        //     var attachments = document.getElementById('attachmentreply').files;

        //     var attachmentPromises = [];

        //     // Convert each attachment to Base64
        //     for (var i = 0; i < attachments.length; i++) {
        //         let file = attachments[i];
        //         attachmentPromises.push(new Promise((resolve, reject) => {
        //             let reader = new FileReader();
        //             reader.onload = function(e) {
        //                 resolve({
        //                     name: file.name,
        //                     type: file.type,
        //                     content: e.target.result.split(',')[1]  // Get the base64 content without the prefix
        //                 });
        //             };
        //             reader.onerror = function(e) {
        //                 reject(e);
        //             };
        //             reader.readAsDataURL(file);
        //         }));
        //     }

        //     Promise.all(attachmentPromises).then((base64Attachments) => {
        //         var replyData = {
        //             messageId: messageId,
        //             to: to,
        //             cc: cc,
        //             bcc: bcc,
        //             message: message,
        //             subject: subject,
        //             attachments: base64Attachments
        //         };

        //         $.ajax({
        //             url: '{{ route("DraftForward") }}', // Route to your controller method
        //             method: 'POST',
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             contentType: 'application/json',
        //             data: JSON.stringify(replyData),
        //             beforeSend: function() {
        //                 $(".se-pre-con").fadeIn('slow');
        //             },
        //             success: function(response) {
        //                 console.log(response);
        //                 $(".se-pre-con").fadeOut('fast');
        //                 $('#attachmentreply').val('');
        //                 var fileNamesContainer = $('#file-names-container-reply');
        //                 // Clear any previous file names
        //                 fileNamesContainer.empty();
        //                 if (response.message) {
        //                     Swal.fire({
        //                         icon: 'success',
        //                         title: 'Success!',
        //                         timer: 2000,
        //                         text: response.message
        //                     });

        //                 } else if (response.error) {
        //                     Swal.fire({
        //                         icon: 'error',
        //                         title: 'Error!',
        //                         timer: 2000,
        //                         text: response.error
        //                     });

        //                 }
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error('Failed to send reply:', error);
        //                 $('#modal-reply').modal('hide');
        //                 $('#attachmentreply').val('');
        //                 var fileNamesContainer = $('#file-names-container-reply');
        //                 // Clear any previous file names
        //                 fileNamesContainer.empty();
        //                 $(".se-pre-con").fadeOut('fast');
        //                 Swal.fire({
        //                     icon: 'error',
        //                     title: 'Error!',
        //                     timer: 2000,
        //                     text: 'Failed to save Draft ' + error
        //                 });
        //             }
        //         });
        //     }).catch((error) => {
        //         console.error('Failed to convert attachments to Base64:', error);
        //     });
        // });

        // $(document).on('click', '#reply-btn-forward', function() {
        //     $('#modal-reply').modal('hide');
        //     var messageId = $(this).data('message_id');
        //     var action = $(this).data('action');
        //     var quillContent = $('#reply-modal-editor-container').html();
        //     var mailboxId = $('#mailboxId').val();
        //     // Replace image src attributes with base64 encoded images
        //     quillContent = replaceImgSrcWithBase64(quillContent);
        //     console.log(quillContent);
        //     $('#email_body-replymessage').val(quillContent);
        //     // Get other necessary data
        //     var to = $('#replytoRecipientInput').val(); // Get the 'To' recipients
        //     var cc = $('#replyccRecipientInput').val(); // Get the 'Cc' recipients
        //     var bcc = $('#replybccRecipientInput').val(); // Get the 'Bcc' recipients
        //     var message = $('#email_body-replymessage').val(); // Get the message content
        //     var subject = $('#reply_head_subject').val();

        //     // Prepare the data to be sent
        //     var replyData = {

        //         messageId: messageId,
        //         to: to,
        //         cc: cc,
        //         bcc: bcc,
        //         message: message,
        //         subject:subject
        //     };
        //     console.log(messageId);

        //     // Send the reply data to the server
        //     $.ajax({
        //         url: '{{ route("send.forward") }}', // Route to your controller method
        //         method: 'POST',
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token in headers
        //         },
        //         data: replyData,
        //         beforeSend: function() {
        //               $(".se-pre-con").fadeIn('slow');
        //           },
        //         success: function(response) {
        //             console.log(response);
        //             $(".se-pre-con").fadeOut('fast');
        //             $('#attachmentreply').val('');
        //             // Handle success response from the server
        //             console.log('Reply sent successfully');
        //             if (response.message) {
        //                         Swal.fire({
        //                             icon: 'success',
        //                             title: 'Success!',
        //                             timer: 2000,
        //                             text: response.message
        //                         });
        //                         loadMsgData(messageId ,mailboxId);
        //             } else if (response.error) {
        //                         Swal.fire({
        //                             icon: 'error',
        //                             title: 'Error!',
        //                             timer: 2000,
        //                             text: response.error
        //                         });
        //                         loadMsgData(messageId ,mailboxId);

        //                     }
        //             // Optionally, you can perform additional actions here, such as displaying a success message to the user
        //         },
        //         error: function(xhr, status, error) {
        //             // Handle error response from the server
        //             console.error('Failed to send reply:', error);
        //             $('#modal-reply').modal('hide');
        //             Swal.fire({
        //                             icon: 'error',
        //                             title: 'Error!',
        //                             timer: 2000,
        //                             text: 'Failed to send message '+ error
        //                         });
        //             // Optionally, you can display an error message to the user
        //         }
        //     });
        // });
        function saveDraftReply() {
            console.log('draft wedaa');

            const sendBtn = document.getElementById('reply-btn-send');
            const forwardBtn = document.getElementById('reply-btn-forward');
            if (!forwardBtn.classList.contains('hidden')) {
                var messageId = $('#reply-btn-forward').data('message_id');
                var url = "{{ route('DraftForward') }}";
            }else if(!sendBtn.classList.contains('hidden')){
                var messageId = $('#save-draft-reply').data('message_id');
                var url = "{{ route('saveDraftReply') }}";
            }

            var quillContent = $('#reply-modal-editor-container').html();
            // Replace image src attributes with base64 encoded images
            quillContent = replaceImgSrcWithBase64(quillContent);
            $('#email_body-replymessage').val(quillContent);

            var organization_linked = $('#organization_linked_email').val();
            var to = $('#replytoRecipientInput').val();
            var cc = $('#replyccRecipientInput').val();
            var bcc = $('#replybccRecipientInput').val();
            var message = $('#email_body-replymessage').val();
            var subject = $('#reply_head_subject').val();
            var attachments = document.getElementById('attachmentreply').files;

            var attachmentPromises = [];
            for (var i = 0; i < attachments.length; i++) {
                let file = attachments[i];
                attachmentPromises.push(new Promise((resolve, reject) => {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        resolve({
                            name: file.name,
                            type: file.type,
                            content: e.target.result.split(',')[1]
                        });
                    };
                    reader.onerror = function(e) {
                        reject(e);
                    };
                    reader.readAsDataURL(file);
                }));
            }
            var draftId = $('#SavedDraftIdReply').val();
            Promise.all(attachmentPromises).then((base64Attachments) => {
                var replyData = {
                    messageId: messageId,
                    to: to,
                    cc: cc,
                    bcc: bcc,
                    message: message,
                    subject: subject,
                    attachments: base64Attachments,
                    draftId : draftId,
                    organization_linked : organization_linked
                };




                $.ajax({
                    url: url,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: 'application/json',
                    data: JSON.stringify(replyData),
                    success: function(response) {
                        console.log(response);
                        $('#attachmentreply').val('');
                        var fileNamesContainer = $('#file-names-container-reply');
                        fileNamesContainer.empty();
                        if (response.message) {
                            $('#draftreplysavealert').text(response.message);
                            setTimeout(function() {
                                $('#draftreplysavealert').text('');
                            }, 4000);
                            if (!draftId && response.draftId) {
                                $('#SavedDraftIdReply').val(response.draftId);
                            }
                        } else if (response.error) {
                            $('#draftreplysavealert').text(response.error);
                            setTimeout(function() {
                                $('#draftreplysavealert').text('');
                            }, 4000);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to save draft reply:', error);
                        $('#draftreplysavealert').text('Failed to save draft reply');
                        setTimeout(function() {
                            $('#draftreplysavealert').text('');
                        }, 4000);
                    }
                });
            }).catch((error) => {
                console.error('Failed to convert attachments to Base64:', error);
            });
        }
        var saveDraftreplyTimeout;
        // Attach save draft reply functionality to button click
        // $(document).on('click', '#save-draft-reply', saveDraftReply);
        $(document).on('click', '#save-draft-reply', function() {
            saveDraftReply();
        });
        $(document).on('click', '#save-draft-forward', function() {
            saveDraftReply();
        });
        // $(document).on('click', '#save-draft-forward', saveDraftReply);
        function startSaveDraftReplyTimeout() {
            clearTimeout(saveDraftreplyTimeout);
            saveDraftreplyTimeout = setTimeout(saveDraftReply, 15000); // 15 seconds
        }
        // Attach the text-change event to the Quill editor for reply modal
        // var quillInstanceforDraftReply  = document.querySelector('#reply-modal-editor-container').__quill;

        $(document).on('click', '.reply-head', function() {
            var MessageId = $(this).data('messageid');
            document.querySelectorAll('.reply_here_add').forEach(function(element) {
                element.innerHTML = '';
            });
            selectedFilesreply = [];
            console.log(MessageId);
            var maildata = '';
            $.ajax({
                url: '{{ url('get/message') }}/' + MessageId,
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('fast');
                },
                success: function(response) {
                    maildata = response;
                    var replyModal = `<input type="hidden" id="SavedDraftIdReply" name="SavedDraftIdReply"  value="">

                        <input type="hidden" id="template_id" name="template_id" value="">

                        <div class="col-md-12 form-group displayflex" >
                            <label for="contactSearchInput" style="width:5%">To:</label>
                            <select class="form-control info-form-input mt-2 recipient-input" name="recipient[]" multiple="multiple" id="replytoRecipientInput" style="width: 95%" aria-placeholder="To">
                            </select>
                        </div>
                        <div class=" col-md-12 form-group displayflex">
                            <label for="ccSearchInput" style="width:5%">Cc:</label>
                            <select class="form-control info-form-input mt-2 cc-input" name="cc[]" multiple="multiple" id="replyccRecipientInput" style="width:95%">
                            </select>
                        </div>
                        <div class="col-md-12 form-group displayflex">
                            <label for="bccSearchInput" style="width:5%">Bcc:</label>
                            <select class="form-control info-form-input mt-2 bcc-input" name="bcc[]" multiple="multiple" id="replybccRecipientInput" style="width:95%">
                            </select>
                        </div>


                        <div class="col-md-12 mt-2 ">
                            {{-- <label class="form-lable-info form-label" style="width:5%">Subject</label> --}}
                            <input type="text" class="form-control info-form-input mt-2" id="reply_head_subject" name="subject" value="" placeholder="Subject" >
                        </div>
                        <div class="to-field col-12 " style="display:none;" id="template-section">
                            <div >
                                <div  class="btn-green-filled customBtn-DroupDown2" style="padding: 5px">Pick template</div>
                                <div id="myDropdown2" class="dropdown-content">
                                <input type="text" placeholder="Search.." id="myInput2" onkeyup="filterFunction2()">

                                @foreach ($emailTemplates as $item )
                                    <p style="margin-left: 10px;" class="pick-template-reply" data-template_id="{{$item['id']}}"> {{$item['title']}}</p>
                                @endforeach
                                @if (isset($AddedEmailTemplates))
                                    @foreach ($AddedEmailTemplates as $item )
                                        <p style="margin-left: 10px;" class="pick-template-reply" data-template_id="{{$item['id']}}"> {{$item['title']}}</p>
                                    @endforeach
                                @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3 mb-1">
                            <div style="display: flex; align-items: center;">
                                <label for="new_description" class="form-label mb-1" style="color: black; width: fit-content;">Email Body</label>
                                <label for="draftreplysavealert" id="draftreplysavealert" class="form-label mb-1" style="color: rgb(95, 95, 95); width: fit-content; margin-right: 10px;margin-left: auto;"></label>
                            </div>
                            <div id="reply-modal-editor-container" style="height: 400px;max-width: unset !important;" class="col "></div>
                            <input type="hidden" id="email_body-replymessage" name="email_body">
                        </div>
                        <input type="file" id="attachmentreply" name="attachments" style="display: none;" multiple>
                        <div class="modal-footer">
                            <div id="file-names-container-reply" style="max-height: 50px;overflow-y: scroll;margin-right: auto;"></div>
                            <button type="button" class="btn btn-danger custom-btn-style closemessage" ><i class="fa fa-close " style="margin-right: 2px" aria-hidden="true" ></i> Close</button>
                            <label for="attachmentreply" class="btn btn-info custom-btn-style" style="margin-bottom: unset !important;">
                                <i class="fa fa-paperclip" aria-hidden="true" style="margin-right: 2px"></i>Attach
                            </label>
                            <button type="button"  id="save-draft-reply" data-message_id="`+MessageId+`"  class="btn btn-secondary custom-btn-style custome-color"><i class="fa fa-floppy-o " style="margin-right: 2px" aria-hidden="true" ></i>Save Draft</button>
                            <button type="button"  id="save-draft-forward" data-message_id="`+MessageId+`"  class="btn btn-secondary custom-btn-style custome-color"><i class="fa fa-floppy-o " style="margin-right: 2px" aria-hidden="true" ></i>Save Draft</button>
                            <button type="button"  id="save-template-reply" class="btn btn-secondary custom-btn-style custome-color"><i class="fa fa-plus " style="margin-right: 2px" aria-hidden="true" ></i>Add to Template</button>
                            <button type="button" id="reply-btn-send" data-action="Send" data-message_id="`+MessageId+`"  class="btn btn-success reply-btn-send custom-btn-style"><i class="fa fa-send " style="margin-right: 2px" aria-hidden="true" ></i>Send</button>
                            <button type="button" id="reply-btn-forward" data-action="Forward" data-message_id="`+MessageId+`" class="btn btn-success reply-btn-send custom-btn-style"><i class="fa fa-share " style="margin-right: 2px" aria-hidden="true" ></i>Forward</button>
                        </div>`;

                        // var myDiv = $('#replyadd_'+MessageId);
                        var myDiv = document.getElementById('replyadd_' + MessageId);
                        // Change the content of the div
                        myDiv.innerHTML = replyModal;
                        var container = document.getElementById('messagebodyforadd_' + MessageId);
                        var messageContent = $(container).closest('.row').find('.message-content');

                        // Check if the message content is not visible
                        if (!messageContent.is(':visible')) {
                            // If it's hidden, show it
                            messageContent.show();
                        }


                        // document.querySelector('.reply_here_add').innerHTML = replyModal;
                        var replymodalquill = new Quill('#reply-modal-editor-container', {
                        theme: 'snow',
                        modules: {
                            imageResize: {
                                modules: ['Resize', 'DisplaySize', 'Toolbar']
                            },
                            toolbar: [
                                ['bold', 'italic', 'underline', 'strike'], // Text styles
                                [{ 'color': [] }, { 'background': [] }], // Font color
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }], // Lists
                                [{ 'size': ['small', false, 'large', 'huge'] }], // Font size
                                [{ 'align': [] }], // Alignment options
                                ['link', 'image'], // Add images
                                ['clean'] // Remove formatting
                            ],
                            magicUrl: true,
                        },
                        clipboard: {
                            matchers: [
                                // Matcher for <p> tags to convert to <div>
                                ['P', function (node, delta) {
                                    delta.ops.forEach(function (op) {
                                        if (op.insert && typeof op.insert === 'string') {
                                            op.insert = op.insert.replace(/\n/g, '');
                                        }
                                    });
                                    return delta;
                                }]
                            ]
                        },
                        keyboard: {
                            bindings: {
                                // Override Enter key behavior for new paragraphs using <div>
                                enter: {
                                    key: 13,
                                    handler: function (range, context) {
                                        if (context.format.list) {
                                            // Maintain list behavior if inside a list
                                            this.quill.format('list', context.format.list);
                                        } else {
                                            // Insert a new <div> block for a new paragraph
                                            const currentFormat = this.quill.getFormat(range.index);
                                            this.quill.insertEmbed(range.index, 'div', true, Quill.sources.USER);
                                            this.quill.insertText(range.index + 1, '\n', Quill.sources.USER);
                                            this.quill.formatText(range.index + 2, 1, currentFormat, Quill.sources.USER);
                                            this.quill.setSelection(range.index + 2, Quill.sources.SILENT);
                                        }
                                        return false; // Prevent default behavior
                                    }
                                },
                                // Override Shift+Enter key behavior for line breaks
                                'shift+enter': {
                                    key: 13,
                                    shiftKey: true,
                                    handler: function (range) {
                                        // Insert a line break
                                        this.quill.insertEmbed(range.index, 'br', true, Quill.sources.USER);
                                        this.quill.setSelection(range.index + 1, Quill.sources.SILENT);
                                        return false; // Prevent default behavior
                                    }
                                }
                            }
                        }
                        });
                        replymodalquill.on('text-change', function(delta, oldDelta, source) {
                            if (source == 'user') {
                                console.log('works 1');
                                startSaveDraftReplyTimeout();
                            }
                        });

                    console.log(maildata);
                    $('#replytoRecipientInput').select2({
                        placeholder: 'To recipients...',
                        ajax: {
                            url: "{{ url('/searchcontacts') }}/",
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                return {
                                    q: params.term
                                };
                            },
                            processResults: function(data) {
                                var options = $.map(data, function(item) {
                                    return {
                                        id: item.text,
                                        text: item.text
                                    };
                                });
                                return { results: options };
                            },
                            cache: true
                        },
                        minimumInputLength: 2,
                        tags: true
                    });

                    // Initialize Select2 for CC recipients
                    $('#replyccRecipientInput').select2({
                        placeholder: 'CC recipients...',
                        ajax: {
                            url: "{{ url('/searchcontacts') }}/",
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                return {
                                    q: params.term
                                };
                            },
                            processResults: function(data) {
                                var options = $.map(data, function(item) {
                                    return {
                                        id: item.text,
                                        text: item.text
                                    };
                                });
                                return { results: options };
                            },
                            cache: true
                        },
                        minimumInputLength: 2,
                        tags: true
                    });

                    // Initialize Select2 for BCC recipients
                    $('#replybccRecipientInput').select2({
                        placeholder: 'BCC recipients...',
                        ajax: {
                            url: "{{ url('/searchcontacts') }}/",
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                return {
                                    q: params.term
                                };
                            },
                            processResults: function(data) {
                                var options = $.map(data, function(item) {
                                    return {
                                        id: item.text,
                                        text: item.text
                                    };
                                });
                                return { results: options };
                            },
                            cache: true
                        },
                        minimumInputLength: 2,
                        tags: true
                    });
                    $('#reply_head_subject').val(maildata.subject);
                    var newOption = $('<option>', {
                                    value: maildata.sender,
                                    text: maildata.sender,
                                    selected: true // Select the option
                                });

                    // Append the new option to the select element
                    $('#replytoRecipientInput').append(newOption);

                    $.ajax({
                        url: "{{ url('/get/email/signature') }}",
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function () {
                            $(".se-pre-con").fadeIn('fast');
                        },
                        success: function(response) {
                        console.log(response);
                        if (response.length > 0) {

                            var bodyData = JSON.parse(response[0].signature);
                            var quillContents = [{ insert: '\n\n' }].concat(bodyData.ops);
                            // Set the contents of the Quill editor
                            replymodalquill.setContents(quillContents);
                        }

                        // Show the modal after handling the response

                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        },
                        complete: function () {
                            $(".se-pre-con").fadeOut('fast');

                        }
                    });
                    $(".se-pre-con").fadeOut('fast');
                    $('#reply-btn-send').data('message_id', MessageId);
                    $('#save-draft-reply').data('message_id', MessageId);
                    // Get the buttons and submit button
                    const sendBtn = document.getElementById('reply-btn-send');
                    const DraftsendBtn = document.getElementById('save-draft-reply');
                    const forwardBtn = document.getElementById('reply-btn-forward');
                    const draftforwardBtn = document.getElementById('save-draft-forward');
                    $('#template-section').show();
                    if (!forwardBtn.classList.contains('hidden')) {
                        forwardBtn.classList.add('hidden');
                    }
                    if (sendBtn.classList.contains('hidden')) {
                        sendBtn.classList.remove('hidden');
                    }
                    if (!draftforwardBtn.classList.contains('hidden')) {
                        draftforwardBtn.classList.add('hidden');
                    }
                    if (DraftsendBtn.classList.contains('hidden')) {
                        DraftsendBtn.classList.remove('hidden');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                },
                complete: function () {
                    // replymodalquill = new Quill('#reply-modal-editor-container', {
                    //     theme: 'snow',
                    //     modules: {
                    //         imageResize: {
                    //             modules: ['Resize', 'DisplaySize', 'Toolbar']
                    //         },
                    //         toolbar: [
                    //             ['bold', 'italic', 'underline', 'strike'], // Text styles
                    //             [{ 'color': [] }, { 'background': [] }], // Font color
                    //             [{ 'list': 'ordered'}, { 'list': 'bullet' }], // Lists
                    //             [{ 'size': ['small', false, 'large', 'huge'] }], // Font size
                    //             [{ 'align': [] }], // Alignment options
                    //             ['link', 'image'], // Add images
                    //             ['clean'] // Remove formatting
                    //         ]
                    //     }
                    // });




                    // $('#modal-title-default-reply').text('Reply Message');
                    // $('#modal-reply').modal('show');

                }
            });
        });
        var selectedFilesreply = [];
        function updateFileInputreply() {
            const dataTransferreply = new DataTransfer();

            selectedFilesreply.forEach(file => dataTransferreply.items.add(file)); // Add each valid file
            $('#attachmentreply')[0].files = dataTransferreply.files; // Set files to the updated FileList
            console.log('adxa');


        }
        $(document).on('change', '#attachmentreply', function() {
                // Get the selected files
                // var files = $(this)[0].files;
                // // Loop through the selected files and add them to the selectedFiles array
                // for (var i = 0; i < files.length; i++) {
                //     selectedFiles.push(files[i]);
                // }

                // var selectedFiles = [];
                var files = $(this)[0].files;
                var maxFileSize = 20 * 1024 * 1024; // 20 MB in bytes

                // Loop through the selected files
                for (var i = 0; i < files.length; i++) {
                    if (files[i].size <= maxFileSize) {
                        // If the file size is within the limit, add it to the selectedFiles array
                        selectedFilesreply.push(files[i]);
                    } else {
                        // If the file size exceeds 20 MB, show a Swal2 alert and do not add the file
                        Swal.fire({
                            icon: 'error',
                            title: 'File too large',
                            text: "The file '" + files[i].name + "' exceeds the 20 MB size limit.",
                        });
                    }
                }
                // Update the list of selected file names
                updateFileInputreply();
                updateFileList_reply();

            });
            function updateFileList_reply() {
                updateFileInputreply();
                // Container to hold the file names
                var fileNamesContainer = $('#file-names-container-reply');
                // Clear any previous file names
                fileNamesContainer.empty();
                // Loop through the selected files and display their names
                for (var i = 0; i < selectedFilesreply.length; i++) {
                    // Create a new <div> element for each file name
                    var fileNameElement = $('<div>').addClass('file-name');
                    // Create a <span> element to display the file name
                    var nameSpan = $('<span>').text(selectedFilesreply[i].name);
                    // Create a <i> element for the remove icon
                    var removeIcon = $('<i>').addClass('fa fa-times remove-icon-reply').attr('data-index', i);
                    // Append the file name and remove icon to the container
                    fileNameElement.append(nameSpan, removeIcon);
                    fileNamesContainer.append(fileNameElement);
                }
            }
            $(document).on('click', '.remove-icon-reply', function() {
                var index = $(this).data('index');
                selectedFilesreply.splice(index, 1); // Remove file from selectedFiles array
                updateFileInputreply();
                updateFileList_reply(); // Update the list of selected file names
            });

            // Function to update the list of selected file names
        $(document).on('click', '.forward-head', function() {
            var MessageId = $(this).data('messageid');
            document.querySelectorAll('.reply_here_add').forEach(function(element) {
                element.innerHTML = '';
            });
            selectedFilesreply = [];
            console.log(MessageId);
            var maildata = '';
            $.ajax({
                url: '{{ url('get/message') }}/' + MessageId,
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('fast');
                },
                success: function(response) {
                    var replyModal = `<input type="hidden" id="SavedDraftIdReply" name="SavedDraftIdReply"  value="">

                        <input type="hidden" id="template_id" name="template_id" value="">

                        <div class="col-md-12 form-group displayflex" >
                            <label for="contactSearchInput" style="width:5%">To:</label>
                            <select class="form-control info-form-input mt-2 recipient-input" name="recipient[]" multiple="multiple" id="replytoRecipientInput" style="width: 95%" aria-placeholder="To">
                            </select>
                        </div>
                        <div class=" col-md-12 form-group displayflex">
                            <label for="ccSearchInput" style="width:5%">Cc:</label>
                            <select class="form-control info-form-input mt-2 cc-input" name="cc[]" multiple="multiple" id="replyccRecipientInput" style="width:95%">
                            </select>
                        </div>
                        <div class="col-md-12 form-group displayflex">
                            <label for="bccSearchInput" style="width:5%">Bcc:</label>
                            <select class="form-control info-form-input mt-2 bcc-input" name="bcc[]" multiple="multiple" id="replybccRecipientInput" style="width:95%">
                            </select>
                        </div>


                        <div class="col-md-12 mt-2 ">
                            {{-- <label class="form-lable-info form-label" style="width:5%">Subject</label> --}}
                            <input type="text" class="form-control info-form-input mt-2" id="reply_head_subject" name="subject" value="" placeholder="Subject" >
                        </div>
                        <div class="to-field col-12 " style="display:none;" id="template-section">
                            <div >
                                <div  class="btn-green-filled customBtn-DroupDown2" style="padding: 5px">Pick template</div>
                                <div id="myDropdown2" class="dropdown-content">
                                <input type="text" placeholder="Search.." id="myInput2" onkeyup="filterFunction2()">

                                @foreach ($emailTemplates as $item )
                                    <p style="margin-left: 10px;" class="pick-template-reply" data-template_id="{{$item['id']}}"> {{$item['title']}}</p>
                                @endforeach
                                @if (isset($AddedEmailTemplates))
                                    @foreach ($AddedEmailTemplates as $item )
                                        <p style="margin-left: 10px;" class="pick-template-reply" data-template_id="{{$item['id']}}"> {{$item['title']}}</p>
                                    @endforeach
                                @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3 mb-1">
                            <div style="display: flex; align-items: center;">
                                <label for="new_description" class="form-label mb-1" style="color: black; width: fit-content;">Email Body</label>
                                <label for="draftreplysavealert" id="draftreplysavealert" class="form-label mb-1" style="color: rgb(95, 95, 95); width: fit-content; margin-right: 10px;margin-left: auto;"></label>
                            </div>
                            <div id="reply-modal-editor-container" style="height: 400px;max-width: unset !important;" class="col "></div>
                            <input type="hidden" id="email_body-replymessage" name="email_body">
                        </div>
                        <input type="file" id="attachmentreply" name="attachments" style="display: none;" multiple>
                        <div class="modal-footer">
                            <div id="file-names-container-reply" style="max-height: 50px;overflow-y: scroll;margin-right: auto;"></div>
                            <button type="button" class="btn btn-danger custom-btn-style closemessage"  ><i class="fa fa-close " style="margin-right: 2px" aria-hidden="true" ></i> Close</button>
                            <label for="attachmentreply" class="btn btn-info custom-btn-style" style="margin-bottom: unset !important;">
                                <i class="fa fa-paperclip" aria-hidden="true" style="margin-right: 2px"></i>Attach
                            </label>
                            <button type="button"  id="save-draft-reply" data-message_id="`+MessageId+`"  class="btn btn-secondary custom-btn-style custome-color"><i class="fa fa-floppy-o " style="margin-right: 2px" aria-hidden="true" ></i>Save Draft</button>
                            <button type="button"  id="save-draft-forward" data-message_id="`+MessageId+`"  class="btn btn-secondary custom-btn-style custome-color"><i class="fa fa-floppy-o " style="margin-right: 2px" aria-hidden="true" ></i>Save Draft</button>
                            <button type="button"  id="save-template-reply" class="btn btn-secondary custom-btn-style custome-color"><i class="fa fa-plus " style="margin-right: 2px" aria-hidden="true" ></i>Add to Template</button>
                            <button type="button" id="reply-btn-send" data-action="Send" data-message_id="`+MessageId+`"  class="btn btn-success reply-btn-send custom-btn-style"><i class="fa fa-send " style="margin-right: 2px" aria-hidden="true" ></i>Send</button>
                            <button type="button" id="reply-btn-forward" data-action="Forward" data-message_id="`+MessageId+`" class="btn btn-success reply-btn-send custom-btn-style"><i class="fa fa-share " style="margin-right: 2px" aria-hidden="true" ></i>Forward</button>
                        </div>`;

                        // var myDiv = $('#replyadd_'+MessageId);
                        var myDiv = document.getElementById('replyadd_' + MessageId);
                        // Change the content of the div
                        myDiv.innerHTML = replyModal;
                        var container = document.getElementById('messagebodyforadd_' + MessageId);
                        var messageContent = $(container).closest('.row').find('.message-content');

                        // Check if the message content is not visible
                        if (!messageContent.is(':visible')) {
                            // If it's hidden, show it
                            messageContent.show();
                        }
                        // var quillInstanceforDraftReply  = document.querySelector('#reply-modal-editor-container').__quill;
                        // Function to save or update the draft reply


                        // document.querySelector('.reply_here_add').innerHTML = replyModal;
                        var replymodalquill = new Quill('#reply-modal-editor-container', {
                        theme: 'snow',
                        modules: {
                            imageResize: {
                                modules: ['Resize', 'DisplaySize', 'Toolbar']
                            },
                            toolbar: [
                                ['bold', 'italic', 'underline', 'strike'], // Text styles
                                [{ 'color': [] }, { 'background': [] }], // Font color
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }], // Lists
                                [{ 'size': ['small', false, 'large', 'huge'] }], // Font size
                                [{ 'align': [] }], // Alignment options
                                ['link', 'image'], // Add images
                                ['clean'] // Remove formatting
                            ],
                            magicUrl: true,
                        },
                        clipboard: {
                            matchers: [
                                // Matcher for <p> tags to convert to <div>
                                ['P', function (node, delta) {
                                    delta.ops.forEach(function (op) {
                                        if (op.insert && typeof op.insert === 'string') {
                                            op.insert = op.insert.replace(/\n/g, '');
                                        }
                                    });
                                    return delta;
                                }]
                            ]
                        },
                        keyboard: {
                            bindings: {
                                // Override Enter key behavior for new paragraphs using <div>
                                enter: {
                                    key: 13,
                                    handler: function (range, context) {
                                        if (context.format.list) {
                                            // Maintain list behavior if inside a list
                                            this.quill.format('list', context.format.list);
                                        } else {
                                            // Insert a new <div> block for a new paragraph
                                            const currentFormat = this.quill.getFormat(range.index);
                                            this.quill.insertEmbed(range.index, 'div', true, Quill.sources.USER);
                                            this.quill.insertText(range.index + 1, '\n', Quill.sources.USER);
                                            this.quill.formatText(range.index + 2, 1, currentFormat, Quill.sources.USER);
                                            this.quill.setSelection(range.index + 2, Quill.sources.SILENT);
                                        }
                                        return false; // Prevent default behavior
                                    }
                                },
                                // Override Shift+Enter key behavior for line breaks
                                'shift+enter': {
                                    key: 13,
                                    shiftKey: true,
                                    handler: function (range) {
                                        // Insert a line break
                                        this.quill.insertEmbed(range.index, 'br', true, Quill.sources.USER);
                                        this.quill.setSelection(range.index + 1, Quill.sources.SILENT);
                                        return false; // Prevent default behavior
                                    }
                                }
                            }
                        }
                        });
                        replymodalquill.on('text-change', function(delta, oldDelta, source) {
                            if (source == 'user') {
                                console.log('works 1');
                                startSaveDraftReplyTimeout();
                            }
                        });
                    maildata = response;
                    $('#replytoRecipientInput').select2({
                        placeholder: 'To recipients...',
                        ajax: {
                            url: "{{ url('/searchcontacts') }}/",
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                return {
                                    q: params.term
                                };
                            },
                            processResults: function(data) {
                                var options = $.map(data, function(item) {
                                    return {
                                        id: item.text,
                                        text: item.text
                                    };
                                });
                                return { results: options };
                            },
                            cache: true
                        },
                        minimumInputLength: 2,
                        tags: true
                    });

                    // Initialize Select2 for CC recipients
                    $('#replyccRecipientInput').select2({
                        placeholder: 'CC recipients...',
                        ajax: {
                            url: "{{ url('/searchcontacts') }}/",
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                return {
                                    q: params.term
                                };
                            },
                            processResults: function(data) {
                                var options = $.map(data, function(item) {
                                    return {
                                        id: item.text,
                                        text: item.text
                                    };
                                });
                                return { results: options };
                            },
                            cache: true
                        },
                        minimumInputLength: 2,
                        tags: true
                    });

                    // Initialize Select2 for BCC recipients
                    $('#replybccRecipientInput').select2({
                        placeholder: 'BCC recipients...',
                        ajax: {
                            url: "{{ url('/searchcontacts') }}/",
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                return {
                                    q: params.term
                                };
                            },
                            processResults: function(data) {
                                var options = $.map(data, function(item) {
                                    return {
                                        id: item.text,
                                        text: item.text
                                    };
                                });
                                return { results: options };
                            },
                            cache: true
                        },
                        minimumInputLength: 2,
                        tags: true
                    });
                    console.log(maildata);
                    $('#reply_head_subject').val(maildata.subject);

                    $(".se-pre-con").fadeOut('fast');
                    $('#modal-title-default-reply').text('Forward Message');
                    $('#reply-btn-forward').data('message_id', MessageId);
                    $('#save-draft-forward').data('message_id', MessageId);
                    // Get the buttons and submit button
                    const sendBtn = document.getElementById('reply-btn-send');
                    const DraftsendBtn = document.getElementById('save-draft-reply');
                    const forwardBtn = document.getElementById('reply-btn-forward');
                    const DraftforwardBtn = document.getElementById('save-draft-forward');
                    $('#template-section').hide();
                    if (!sendBtn.classList.contains('hidden')) {
                        sendBtn.classList.add('hidden');
                    }
                    if (forwardBtn.classList.contains('hidden')) {
                        forwardBtn.classList.remove('hidden');
                    }
                    if (!DraftsendBtn.classList.contains('hidden')) {
                        DraftsendBtn.classList.add('hidden');
                    }
                    if (DraftforwardBtn.classList.contains('hidden')) {
                        DraftforwardBtn.classList.remove('hidden');
                    }
                    replymodalquill.clipboard.dangerouslyPasteHTML(maildata.body);
                    $.ajax({
                        url: "{{ url('/get/email/signature') }}",
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function () {
                            $(".se-pre-con").fadeIn('fast');
                        },
                        success: function(response) {
                        console.log(response);
                        if (response.length > 0) {

                            var bodyData = JSON.parse(response[0].signature);
                            var quillContents = [{ insert: '\n\n' }].concat(bodyData.ops);
                            var currentContent = replymodalquill.getContents();
                            var currentOps = currentContent.ops;
                            // Concatenate signature content with current content
                            var newContent = quillContents.concat(currentOps);
                            var newDelta = {
                                ops: newContent
                            };
                            // Set the editor's content to the new content with signature

                            replymodalquill.setContents(newDelta);
                        }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        },
                        complete: function () {
                            $(".se-pre-con").fadeOut('fast');

                        }
                    });

                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                },
                complete: function () {
                    // replymodalquill = new Quill('#reply-modal-editor-container', {
                    //     theme: 'snow',
                    //     modules: {
                    //         imageResize: {
                    //             modules: ['Resize', 'DisplaySize', 'Toolbar']
                    //         },
                    //         toolbar: [
                    //             ['bold', 'italic', 'underline', 'strike'], // Text styles
                    //             [{ 'color': [] }, { 'background': [] }], // Font color
                    //             [{ 'list': 'ordered'}, { 'list': 'bullet' }], // Lists
                    //             [{ 'size': ['small', false, 'large', 'huge'] }], // Font size
                    //             [{ 'align': [] }], // Alignment options
                    //             ['link', 'image'], // Add images
                    //             ['clean'] // Remove formatting
                    //         ]
                    //     }
                    // });

                    // $('#modal-reply').modal('show');

                }
            });

        });
        $(document).on('click', '.closemessage', function() {

            document.querySelectorAll('.reply_here_add').forEach(function(element) {
                element.innerHTML = '';
            });
        });
        $(document).on('click', '.reply-all-head', function() {
            var MessageId = $(this).data('messageid');
            document.querySelectorAll('.reply_here_add').forEach(function(element) {
                element.innerHTML = '';
            });
            selectedFilesreply = [];
            console.log(MessageId);
            var maildata = '';
            var azureLoggedUser = '{{ session("azure_logged_email") }}';
            $.ajax({
                url: '{{ url('get/message') }}/' + MessageId,
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('fast');
                },
                success: function(response) {
                    maildata = response;
                    var replyModal = `<input type="hidden" id="SavedDraftIdReply" name="SavedDraftIdReply"  value="">

                        <input type="hidden" id="template_id" name="template_id" value="">

                        <div class="col-md-12 form-group displayflex" >
                            <label for="contactSearchInput" style="width:5%">To:</label>
                            <select class="form-control info-form-input mt-2 recipient-input" name="recipient[]" multiple="multiple" id="replytoRecipientInput" style="width: 95%" aria-placeholder="To">
                            </select>
                        </div>
                        <div class=" col-md-12 form-group displayflex">
                            <label for="ccSearchInput" style="width:5%">Cc:</label>
                            <select class="form-control info-form-input mt-2 cc-input" name="cc[]" multiple="multiple" id="replyccRecipientInput" style="width:95%">
                            </select>
                        </div>
                        <div class="col-md-12 form-group displayflex">
                            <label for="bccSearchInput" style="width:5%">Bcc:</label>
                            <select class="form-control info-form-input mt-2 bcc-input" name="bcc[]" multiple="multiple" id="replybccRecipientInput" style="width:95%">
                            </select>
                        </div>


                        <div class="col-md-12 mt-2 ">
                            {{-- <label class="form-lable-info form-label" style="width:5%">Subject</label> --}}
                            <input type="text" class="form-control info-form-input mt-2" id="reply_head_subject" name="subject" value="" placeholder="Subject" >
                        </div>
                        <div class="to-field col-12 " style="display:none;" id="template-section">
                            <div >
                                <div  class="btn-green-filled customBtn-DroupDown2" style="padding: 5px">Pick template</div>
                                <div id="myDropdown2" class="dropdown-content">
                                <input type="text" placeholder="Search.." id="myInput2" onkeyup="filterFunction2()">

                                @foreach ($emailTemplates as $item )
                                    <p style="margin-left: 10px;" class="pick-template-reply" data-template_id="{{$item['id']}}"> {{$item['title']}}</p>
                                @endforeach
                                @if (isset($AddedEmailTemplates))
                                    @foreach ($AddedEmailTemplates as $item )
                                        <p style="margin-left: 10px;" class="pick-template-reply" data-template_id="{{$item['id']}}"> {{$item['title']}}</p>
                                    @endforeach
                                @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3 mb-1">
                            <div style="display: flex; align-items: center;">
                                <label for="new_description" class="form-label mb-1" style="color: black; width: fit-content;">Email Body</label>
                                <label for="draftreplysavealert" id="draftreplysavealert" class="form-label mb-1" style="color: rgb(95, 95, 95); width: fit-content; margin-right: 10px;margin-left: auto;"></label>
                            </div>
                            <div id="reply-modal-editor-container" style="height: 400px;max-width: unset !important;" class="col "></div>
                            <input type="hidden" id="email_body-replymessage" name="email_body">
                        </div>
                        <input type="file" id="attachmentreply" name="attachments" style="display: none;" multiple>
                        <div class="modal-footer">
                            <div id="file-names-container-reply" style="max-height: 50px;overflow-y: scroll;margin-right: auto;"></div>
                            <button type="button" class="btn btn-danger custom-btn-style closemessage" "><i class="fa fa-close " style="margin-right: 2px" aria-hidden="true" ></i> Close</button>
                            <label for="attachmentreply" class="btn btn-info custom-btn-style" style="margin-bottom: unset !important;">
                                <i class="fa fa-paperclip" aria-hidden="true" style="margin-right: 2px"></i>Attach
                            </label>
                            <button type="button"  id="save-draft-reply" data-message_id="`+MessageId+`"  class="btn btn-secondary custom-btn-style custome-color"><i class="fa fa-floppy-o " style="margin-right: 2px" aria-hidden="true" ></i>Save Draft</button>
                            <button type="button"  id="save-draft-forward" data-message_id="`+MessageId+`"  class="btn btn-secondary custom-btn-style custome-color"><i class="fa fa-floppy-o " style="margin-right: 2px" aria-hidden="true" ></i>Save Draft</button>
                            <button type="button"  id="save-template-reply" class="btn btn-secondary custom-btn-style custome-color"><i class="fa fa-plus " style="margin-right: 2px" aria-hidden="true" ></i>Add to Template</button>
                            <button type="button" id="reply-btn-send" data-action="Send" data-message_id="`+MessageId+`"  class="btn btn-success reply-btn-send custom-btn-style"><i class="fa fa-send " style="margin-right: 2px" aria-hidden="true" ></i>Send</button>
                            <button type="button" id="reply-btn-forward" data-action="Forward" data-message_id="`+MessageId+`" class="btn btn-success reply-btn-send custom-btn-style"><i class="fa fa-share " style="margin-right: 2px" aria-hidden="true" ></i>Forward</button>
                        </div>`;

                        // var myDiv = $('#replyadd_'+MessageId);
                        var myDiv = document.getElementById('replyadd_' + MessageId);
                        // Change the content of the div
                        myDiv.innerHTML = replyModal;
                        var container = document.getElementById('messagebodyforadd_' + MessageId);
                        var messageContent = $(container).closest('.row').find('.message-content');

                        // Check if the message content is not visible
                        if (!messageContent.is(':visible')) {
                            // If it's hidden, show it
                            messageContent.show();
                        }



                    // document.querySelector('.reply_here_add').innerHTML = replyModal;
                    var replymodalquill = new Quill('#reply-modal-editor-container', {
                        theme: 'snow',
                        modules: {
                            imageResize: {
                                modules: ['Resize', 'DisplaySize', 'Toolbar']
                            },
                            toolbar: [
                                ['bold', 'italic', 'underline', 'strike'], // Text styles
                                [{ 'color': [] }, { 'background': [] }], // Font color
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }], // Lists
                                [{ 'size': ['small', false, 'large', 'huge'] }], // Font size
                                [{ 'align': [] }], // Alignment options
                                ['link', 'image'], // Add images
                                ['clean'] // Remove formatting
                            ],
                            magicUrl: true,
                        },
                        clipboard: {
                            matchers: [
                                // Matcher for <p> tags to convert to <div>
                                ['P', function (node, delta) {
                                    delta.ops.forEach(function (op) {
                                        if (op.insert && typeof op.insert === 'string') {
                                            op.insert = op.insert.replace(/\n/g, '');
                                        }
                                    });
                                    return delta;
                                }]
                            ]
                        },
                        keyboard: {
                            bindings: {
                                // Override Enter key behavior for new paragraphs using <div>
                                enter: {
                                    key: 13,
                                    handler: function (range, context) {
                                        if (context.format.list) {
                                            // Maintain list behavior if inside a list
                                            this.quill.format('list', context.format.list);
                                        } else {
                                            // Insert a new <div> block for a new paragraph
                                            const currentFormat = this.quill.getFormat(range.index);
                                            this.quill.insertEmbed(range.index, 'div', true, Quill.sources.USER);
                                            this.quill.insertText(range.index + 1, '\n', Quill.sources.USER);
                                            this.quill.formatText(range.index + 2, 1, currentFormat, Quill.sources.USER);
                                            this.quill.setSelection(range.index + 2, Quill.sources.SILENT);
                                        }
                                        return false; // Prevent default behavior
                                    }
                                },
                                // Override Shift+Enter key behavior for line breaks
                                'shift+enter': {
                                    key: 13,
                                    shiftKey: true,
                                    handler: function (range) {
                                        // Insert a line break
                                        this.quill.insertEmbed(range.index, 'br', true, Quill.sources.USER);
                                        this.quill.setSelection(range.index + 1, Quill.sources.SILENT);
                                        return false; // Prevent default behavior
                                    }
                                }
                            }
                        }
                    });
                    replymodalquill.on('text-change', function(delta, oldDelta, source) {
                            if (source == 'user') {
                                console.log('works 1');
                                startSaveDraftReplyTimeout();
                            }
                        });
                    console.log(maildata);
                    $('#replytoRecipientInput').select2({
                        placeholder: 'To recipients...',
                        ajax: {
                            url: "{{ url('/searchcontacts') }}/",
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                return {
                                    q: params.term
                                };
                            },
                            processResults: function(data) {
                                var options = $.map(data, function(item) {
                                    return {
                                        id: item.text,
                                        text: item.text
                                    };
                                });
                                return { results: options };
                            },
                            cache: true
                        },
                        minimumInputLength: 2,
                        tags: true
                    });

                    // Initialize Select2 for CC recipients
                    $('#replyccRecipientInput').select2({
                        placeholder: 'CC recipients...',
                        ajax: {
                            url: "{{ url('/searchcontacts') }}/",
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                return {
                                    q: params.term
                                };
                            },
                            processResults: function(data) {
                                var options = $.map(data, function(item) {
                                    return {
                                        id: item.text,
                                        text: item.text
                                    };
                                });
                                return { results: options };
                            },
                            cache: true
                        },
                        minimumInputLength: 2,
                        tags: true
                    });

                    // Initialize Select2 for BCC recipients
                    $('#replybccRecipientInput').select2({
                        placeholder: 'BCC recipients...',
                        ajax: {
                            url: "{{ url('/searchcontacts') }}/",
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                return {
                                    q: params.term
                                };
                            },
                            processResults: function(data) {
                                var options = $.map(data, function(item) {
                                    return {
                                        id: item.text,
                                        text: item.text
                                    };
                                });
                                return { results: options };
                            },
                            cache: true
                        },
                        minimumInputLength: 2,
                        tags: true
                    });
                    $('#reply_head_subject').val(maildata.subject);
                    if (maildata.sender !== azureLoggedUser) {
                        var newOption = $('<option>', {
                            value: maildata.sender,
                            text: maildata.sender,
                            selected: true // Select the option
                        });

                        // Append the new option to the select element
                        $('#replytoRecipientInput').append(newOption);
                    }
                    // Function to populate select options
                    function populateSelect(selector, data) {
                        var $select = $(selector);

                        $.each(data, function(index, recipient) {
                            var newOption = $('<option>', {
                                value: recipient.emailAddress.address,
                                text: recipient.emailAddress.address,
                                selected: true // Select the option
                            });

                        // Append the new option to the select element
                        $(selector).append(newOption);
                        });
                    }


                    // Populate cc and bcc selects
                    populateSelect('#replyccRecipientInput', maildata.cc);
                    populateSelect('#replybccRecipientInput', maildata.bcc);
                    populateSelect('#replytoRecipientInput', maildata.to);

                    $.ajax({
                        url: "{{ url('/get/email/signature') }}",
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function () {
                            $(".se-pre-con").fadeIn('fast');
                        },
                        success: function(response) {
                        console.log(response);
                        if (response.length > 0) {

                            var bodyData = JSON.parse(response[0].signature);
                            var quillContents = [{ insert: '\n\n\n\n\n' }].concat(bodyData.ops);
                            // Set the contents of the Quill editor

                            replymodalquill.setContents(quillContents);
                        }

                        // Show the modal after handling the response

                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        },
                        complete: function () {
                            $(".se-pre-con").fadeOut('fast');

                        }
                    });
                    $(".se-pre-con").fadeOut('fast');
                    // $('#modal-title-default-reply').text('Reply All Message');
                    $('#reply-btn-send').data('message_id', MessageId);
                    $('#save-draft-reply').data('message_id', MessageId);
                    // Get the buttons and submit button
                    const sendBtn = document.getElementById('reply-btn-send');
                    const DraftsendBtn = document.getElementById('save-draft-reply');
                    const forwardBtn = document.getElementById('reply-btn-forward');
                    const DraftforwardBtn = document.getElementById('save-draft-forward');
                    $('#template-section').show();
                    if (!forwardBtn.classList.contains('hidden')) {
                        forwardBtn.classList.add('hidden');
                    }
                    if (sendBtn.classList.contains('hidden')) {
                        sendBtn.classList.remove('hidden');
                    }
                    if (!DraftforwardBtn.classList.contains('hidden')) {
                        DraftforwardBtn.classList.add('hidden');
                    }
                    if (DraftsendBtn.classList.contains('hidden')) {
                        DraftsendBtn.classList.remove('hidden');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                },
                complete: function () {


                    // $('#modal-reply').modal('show');

                }
            });

        });
        $(document).on('click', '.reply-all-conversation', function() {
            var MessageId = $(this).data('messageid');
            console.log(MessageId);
            var maildata = '';
            $.ajax({
                url: '{{ url('get/conversation/message') }}/' + MessageId,
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('fast');
                },
                success: function(response) {
                    maildata = response;
                    console.log(maildata.to);
                    $('#reply_head_subject').val(maildata.subject);
                    // var newOption = $('<option>', {
                    //                 value: maildata.sender,
                    //                 text: maildata.sender,
                    //                 selected: true // Select the option
                    //             });

                    // // Append the new option to the select element
                    // $('#replytoRecipientInput').append(newOption);
                    // Function to populate select options
                    function populateSelect(selector, data) {
                        var $select = $(selector);

                        $.each(data, function(index, recipient) {
                            var newOption = $('<option>', {
                                value: recipient,
                                text: recipient,
                                selected: true // Select the option
                            });

                        // Append the new option to the select element
                        $(selector).append(newOption);
                        });
                    }

                    // Populate cc and bcc selects
                    populateSelect('#replyccRecipientInput', maildata.cc);

                    populateSelect('#replybccRecipientInput', maildata.bcc);
                    populateSelect('#replytoRecipientInput', maildata.to);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                },
                complete: function () {
                    // replymodalquill = new Quill('#reply-modal-editor-container', {
                    //     theme: 'snow',
                    //     modules: {
                    //         imageResize: {
                    //             modules: ['Resize', 'DisplaySize', 'Toolbar']
                    //         },
                    //         toolbar: [
                    //             ['bold', 'italic', 'underline', 'strike'], // Text styles
                    //             [{ 'color': [] }, { 'background': [] }], // Font color
                    //             [{ 'list': 'ordered'}, { 'list': 'bullet' }], // Lists
                    //             [{ 'size': ['small', false, 'large', 'huge'] }], // Font size
                    //             [{ 'align': [] }], // Alignment options
                    //             ['link', 'image'], // Add images
                    //             ['clean'] // Remove formatting
                    //         ]
                    //     }
                    // });
                    $.ajax({
                        url: "{{ url('/get/email/signature') }}",
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function () {
                            $(".se-pre-con").fadeIn('fast');
                        },
                        success: function(response) {
                        console.log(response);
                        if (response.length > 0) {

                            var bodyData = JSON.parse(response[0].signature);
                            var quillContents = [{ insert: '\n\n\n\n\n' }].concat(bodyData.ops);
                            // Set the contents of the Quill editor
                            var replymodalquill = document.querySelector('#reply-modal-editor-container').__quill;
                            replymodalquill.setContents(quillContents);
                        }

                        // Show the modal after handling the response

                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        },
                        complete: function () {
                            $(".se-pre-con").fadeOut('fast');

                        }
                    });
                    $(".se-pre-con").fadeOut('fast');
                    $('#modal-title-default-reply').text('Reply All Message');
                    $('#reply-btn-send').data('message_id', MessageId);
                    $('#save-draft-reply').data('message_id', MessageId);
                    // Get the buttons and submit button
                    const sendBtn = document.getElementById('reply-btn-send');
                    const DraftsendBtn = document.getElementById('save-draft-reply');
                    const forwardBtn = document.getElementById('reply-btn-forward');
                    const DraftforwardBtn = document.getElementById('save-draft-forward');
                    $('#template-section').show();
                    if (!forwardBtn.classList.contains('hidden')) {
                        forwardBtn.classList.add('hidden');
                    }
                    if (sendBtn.classList.contains('hidden')) {
                        sendBtn.classList.remove('hidden');
                    }
                    if (!DraftforwardBtn.classList.contains('hidden')) {
                        DraftforwardBtn.classList.add('hidden');
                    }
                    if (DraftsendBtn.classList.contains('hidden')) {
                        DraftsendBtn.classList.remove('hidden');
                    }
                    $('#modal-reply').modal('show');

                }
            });

        });
        $(document).on('click', '.pick-template-reply', function() {
              var template_id = $(this).data('template_id');
              var replymodalquill = document.querySelector('#reply-modal-editor-container').__quill;
              console.log(template_id);
              $.ajax({
                  url: "{{ url('email/templates/pick') }}/" + template_id,
                  method: 'GET',
                  dataType: 'json',
                  beforeSend: function() {
                      $(".se-pre-con").fadeIn('slow');
                  },
                  success: function(data) {
                      if (data.body) {
                          try {
                            $('#reply_head_subject').val(data.subject);
                              var bodyData = JSON.parse(data.body); // Parse the body string as JSON
                              if (bodyData.ops) {
                                  console.log(data);
                                  // Use the existing Quill instance (declared globally) to set the content
                                  replymodalquill.setContents(bodyData.ops);
                              } else {
                                  console.error("Invalid data format: ops property missing");
                                  // Handle invalid data format
                              }
                          } catch (error) {
                              console.error("Error parsing body data:", error);
                              // Handle parsing error
                          }
                      } else {
                          console.error("Invalid data format: body property missing");
                          // Handle invalid data format
                      }
                  },
                  complete: function() {
                    $('#myDropdown2').toggle();
                      $(".se-pre-con").fadeOut('slow');
                  },
                  error: function(xhr, status, error) {
                      console.error("Error occurred during AJAX request:", error);
                      // Handle AJAX error
                  }
              });
          });
        $('#modal-reply').on('hidden.bs.modal', function () {
            $('#replytoRecipientInput').val(null).trigger('change');
            $('#replyccRecipientInput').val(null).trigger('change');
            $('#replybccRecipientInput').val(null).trigger('change');
            $('#reply_head_subject').val('');
            $('#SavedDraftIdReply').val('');
            $('#file-names-container').empty();

        });
        $(document).on('click', '.compose-close-btn', function() {
            var hiddenDiv = document.getElementById("compose-div");
            var chatDiv = document.getElementById("mailchat-div");
            hiddenDiv.classList.add("hidden");
            $('#SavedDraftId').val('');
            chatDiv.classList.remove("hidden");
        });

        $(document).on('click', '.btn-back', function() {
            var page_number = $('#pageNumber').val();
            var mailbox_id = $('#mailboxId').val();
            loadMessages(mailbox_id,page_number);
        });
        $(document).on('change', '.chk_boxes', function() {
            if ($(this).is(':checked')) {
                // Add "Select All" button if not already added
                if ($('.selectalldiv').length === 0) {
                    $('.chat-list').prepend(
                        '<li class="selectalldiv chatliclass" style="background-color: transparent !important; cursor: auto !important;padding-left: 10px;">'+
                        '<div class="chkbox"><input class="selectAll" type="checkbox" value="" id="SelectAll" style="margin-right: 10px;">'+
                        '<lable class=" selectAllText">Select All</lable>'+
                        '</div>' +
                        '</li>'
                    );
                }
            } else {
                // Remove "Select All" button if no checkboxes are checked
                if ($('.chk_boxes:checked').length === 0) {
                    $('.selectalldiv').remove();
                }
            }
        });

        // Code inside this function will run after the DOM is fully loaded

        $('.toggle-cc-bcc').click(function() {
            $('.ccbcc-input').each(function() {
                if ($(this).hasClass("hidden")) {
                    $(this).removeClass("hidden");
                    $(this).addClass("displayview");
                    $('#editor-container').css('height', '165px');
                } else {
                    $(this).removeClass("displayview");
                    $(this).addClass("hidden");
                    $('#editor-container').css('height', '250px');
                }
            });
        });
        $(document).on('click', '.toggle-cc-bcc-reply', function() {
            $('.ccbcc-input-reply').each(function() {
                if ($(this).hasClass("hidden")) {
                    $(this).removeClass("hidden");


                } else {

                    $(this).addClass("hidden");

                }
            });
        });

        // Add click event handler to mail sidebar items
        $('.mail-sidebar-item').click(function() {
            // Retrieve the folder from the data-folder attribute
            $('#Searchtext').val('');
            var mailbox_id = $(this).data('folder');
            var page_number = 1;
            $('#pageNumber').val(page_number);
            $('#mailboxId').val(mailbox_id);
            var displayName = $(this).find('p:first').text().trim();
            // Set the header text dynamically
            $('#email-header').text(displayName);
            var hiddenDiv = document.getElementById("compose-div");
            var chatDiv = document.getElementById("mailchat-div");

                // Toggle the 'hidden' class for compose-div and chatDiv
            if (chatDiv.classList.contains("hidden")) {
                    hiddenDiv.classList.add("hidden");
                    $('#SavedDraftId').val('');
                    chatDiv.classList.remove("hidden");
            }
            var fullMails = @json($sidebarItems);
            var mailfilter = $('#mail_filter_value').val();

            var foundMailbox = fullMails.find(function(mailbox) {
                return mailbox.id === mailbox_id;
            });

            if (foundMailbox) {
                var totalItemCount = foundMailbox.totalItemCount;
                var unreadItemCount = foundMailbox.unreadItemCount;
                if(mailfilter == 1 ){
                    $('#full_count').text(unreadItemCount);
                }else{
                    $('#full_count').text(totalItemCount);
                }

            } else {
                $('#full_count').text(0);
            }
            loadMessages(mailbox_id,page_number);
        });
        $('.btn-next').click(function() {
            var searchtext = $('#Searchtext').val() ?? '';
            console.log('search = ',searchtext);
            if(searchtext != ''){
                console.log('next btn click search' );
                var page_number = $('#pageNumber').val();
                page_number++;
                searchload(searchtext,page_number);
                if (page_number <= 1) {
                    $('.btn-pre').prop('disabled', true);
                } else {
                    $('.btn-pre').prop('disabled', false);
                }
                $('#pageNumber').val(page_number);
                var startCount = (page_number - 1) * 50 + 1;
                var endCount = page_number * 50;
                $('#start_count').text(startCount);
                $('#end_count').text(endCount);
            }else{

                // Retrieve the folder from the data-folder attribute
                console.log('next btn click');
                var page_number = $('#pageNumber').val();
                var mailbox_id = $('#mailboxId').val();
                page_number++;
                loadMessages(mailbox_id,page_number);
                if (page_number <= 1) {
                    $('.btn-pre').prop('disabled', true);
                } else {
                    $('.btn-pre').prop('disabled', false);
                }
                $('#pageNumber').val(page_number);
                var startCount = (page_number - 1) * 50 + 1;
                var endCount = page_number * 50;
                $('#start_count').text(startCount);
                $('#end_count').text(endCount);

                var fullMails = @json($sidebarItems);

                var foundMailbox = fullMails.find(function(mailbox) {
                    return mailbox.id === mailbox_id;
                });

                if (foundMailbox) {
                    var totalItemCount = foundMailbox.totalItemCount;
                    $('#full_count').text(totalItemCount);
                } else {
                    $('#full_count').text(0);
                }
            }
        });
        $('.btn-pre').click(function() {
            var searchtext = $('#Searchtext').val() ?? '';
            console.log('search = ',searchtext);
            if(searchtext != ''){
                console.log('next btn click search' );
                var page_number = $('#pageNumber').val();
                page_number--;
                searchload(searchtext,page_number);
                if (page_number <= 1) {
                    $('.btn-pre').prop('disabled', true);
                } else {
                    $('.btn-pre').prop('disabled', false);
                }
                $('#pageNumber').val(page_number);
                var startCount = (page_number - 1) * 50 + 1;
                var endCount = page_number * 50;
                $('#start_count').text(startCount);
                $('#end_count').text(endCount);
            }else{

                // Retrieve the folder from the data-folder attribute
                console.log('pre btn click');
                var page_number = $('#pageNumber').val();
                var mailbox_id = $('#mailboxId').val();
                page_number--;
                loadMessages(mailbox_id,page_number);
                if (page_number <= 1) {
                    $('.btn-pre').prop('disabled', true);
                } else {
                    $('.btn-pre').prop('disabled', false);
                }
                $('#pageNumber').val(page_number);
                var startCount = (page_number - 1) * 50 + 1;
                var endCount = page_number * 50;
                $('#start_count').text(startCount);
                $('#end_count').text(endCount);

                var fullMails = @json($sidebarItems);

                var foundMailbox = fullMails.find(function(mailbox) {
                    return mailbox.id === mailbox_id;
                });

                if (foundMailbox) {
                    var totalItemCount = foundMailbox.totalItemCount;
                    $('#full_count').text(totalItemCount);
                } else {
                    $('#full_count').text(0);
                }
            }
        });
    });


    // Function to generate random light color
    function getRandomLightColor() {
        var letters = '89ABCDEF'; // Letters for lighter colors
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * letters.length)];
        }
        return color;
    }

    // Get all elements with the class 'dot'
    var dots = document.querySelectorAll('.dot');

    // Iterate through each dot and set its background color to a random light color
    dots.forEach(function(dot) {
        dot.style.backgroundColor = getRandomLightColor();
    });

// Wait for the DOM to be fully loaded before running the script
// document.addEventListener('DOMContentLoaded', (event) => {
//     // Check if the element with the class 'replymodaleditorcontainer' exists
//     const editorContainer = document.querySelector('#reply-modal-editor-container');

//     if (editorContainer) {
//         // Ensure the element has a Quill instance associated with it
//         if (editorContainer.__quill) {
//             var quillInstanceforDraftReply = editorContainer.__quill;

//             // Attach the text-change event listener to the Quill instance
//             quillInstanceforDraftReply.on('text-change', function(delta, oldDelta, source) {
//                 console.log('works 122');
//                 if (source == 'user') {
//                     // Uncomment the function call if it exists
//                     // startSaveDraftReplyTimeout();
//                     console.log('User made a change');
//                 }
//             });
//             console.log('Event listener attached');
//         } else {
//             console.error('No Quill instance found on the element.');
//         }
//     } else {
//         console.error('Element with class "replymodaleditorcontainer" not found.');
//     }
// });


</script>

@endsection
