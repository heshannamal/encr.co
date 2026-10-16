@extends('layouts.appLayout-email', ['activePage' => 'Mail', 'titlePage' => __('Mail')])
@include('emails.email-compose')

    @include('emails/people/people-create-modal')
    {{-- @include('pages.contacts.organizations.organization_create_modal') --}}
    @include('emails.organizations.organization_edit_modal')
    @include('emails.organizations.organization_create_modal')
    @include('emails.activity.add_activity')
 {{-- @include('pages.contacts.modals.organization_create_modal') --}}

@section('mailsidebarcontent')
<div class="email-side-list"  style="background-color: #212529">
    <div class="compose-button" style="position: relative; margin-bottom: 50px;">
        <a href="#" onclick="toggleCompose(event)"  title="Compose" class="btn-green-filled font-size-15 " style="text-align:center; position:fixed" >

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
  <script>

    $('.select2-people-modal').select2({
            dropdownParent: $('#email_people_create_modal')
        });

        $('#email_people_add_form').submit(function(ev){
            console.log("awoooo");
            ev.preventDefault();
            var formData = $('#email_people_add_form').serialize();

            $(".se-pre-con").fadeIn();
            $.ajax({
                // url:'{{ url("people/create_json") }}',
                url:'{{ url("people/create_contanct_without_org") }}',
                method:'POST',
                dataType:'json',
                data: formData,

                success: function(data){

                    var fnStatus = data[0];
                    var fnResponse = data[1];
                    if(fnStatus == 'success'){

                        var exiCust = [];
                        exiCust = $('#customer_id').val();
                        exiCust.push(fnResponse.id);
                        $('<option value="'+ fnResponse.id +'">'+ fnResponse.first_name +' '+ fnResponse.last_name +'</option>').appendTo($('#customer_id'));
                        // $('#customer_id').val(fnResponse.id).trigger('change');
                        $('#customer_id').val(exiCust).trigger('change');

                        clearFields();

                        Swal.fire({
                            title: "Done!",
                            text: "Customer Created Successfully!",
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                        location.reload();

                    } else if(fnStatus == 'error'){
                        Swal.fire({
                            title: "Error!",
                            text: fnResponse,
                            type: "error",
                        });
                    }

                    $(".se-pre-con").fadeOut();
                    $('#email_people_create_modal').modal('hide');
                }
            });
        });


        $('#people_cancel_btn').click(function(){
            $('.select2-people-modal').each(
                function(index){
                    $(this).val('').trigger("change");
                }
            );
            $('#email_people_create_modal').modal('hide');
        });

    function callViewmail(event, MailBoxId,showHeading ) {
            event.preventDefault();
            console.log(MailBoxId)
            document.getElementById("txtGetEmailType").value = MailBoxId;
            document.getElementById("txtHeaderEmailType").value = showHeading;
            document.getElementById('txtPgNo').value = "1";

            document.getElementById('serachText').value = "";
            document.getElementById('serachOnOff').value = "OFF";

            document.getElementById("formGetEmails").submit();
        };
        var storedValue = localStorage.getItem("txtHeaderEmailType");

        // Check if the value exists in localStorage
        if (storedValue !== null) {
            // Insert the value into the HTML element
            document.getElementById("mailheadder").textContent =  storedValue;
        }



  </script>
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

        {{-- <link rel="stylesheet" type="text/css" href="{{ asset('email-assets') }}/app-assets/css/bootstrap-extended.css"> --}}
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
        .se-pre-con {
                position: fixed;
                left: 0px;
                top: 0px;
                width: 100%;
                height: 100%;
                z-index: 9999;
                background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
                display: none;
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
            height:95vh;
        }
        .body-email-header{
            background-color: #ffffff;
            margin-bottom: 80px;
            height:85vh;

        }
        .btn-logout {
            border: 2px solid #cacaca;
            background-color: #f7f7f7;
            color: #6d6d6d;
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
    .contact-section{
        border: 2px solid #cacaca;
        border-radius: 5px;
        max-width: 300px;
        min-width: 250px;
    }
    .con-section{
        margin: 5px;
        padding-bottom: 8px;
        border-bottom: 1px solid #BBC1E1;
        display: -webkit-box;
        padding-left: 10px;
        flex-flow: wrap;


    }
    .dot {
    height: 39px;
    width: 39px;
    background-color: #a6a4fff5;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 3px;
  }
  .white-text {
    color: rgb(60, 96, 255);
    font-weight: bold;
    font-family: "Arial", sans-serif;
  }
  .nameTag{
    display: -webkit-box;
    align-items: center;
    justify-content: center;
    margin-top: 10px;
    margin-left: 16px;
  }
  .head-of-linkside{
    color: rgb(167, 60, 255);
    font-weight: bold;
    font-family: "Arial", sans-serif;
    margin: 0px 10px;
    text-transform: uppercase;
  }
  .mail-tag{
    display: -webkit-box;
    margin-left: 24px;
    margin-top: 20px;
    overflow: hidden;
  }
  .normal-btn{
    width: 260px;
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
    width: 260px;
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
  .header-layout{
    margin-bottom: 0rem !important;
  }

.button-80 {
  background: #fff;
  backface-visibility: hidden;
  border-radius: .375rem;
  border-style: solid;
  border-width: .125rem;
  box-sizing: border-box;
  color: #28d59d;
  cursor: pointer;
  display: inline-block;
  font-family: Circular,Helvetica,sans-serif;
  font-size: 12px;
  font-weight: 500;
  letter-spacing: -.01em;
  line-height: 1.3;
  padding: 8px 12px;
  position: relative;
  text-align: left;
  text-decoration: none;
  transform: translateZ(0) scale(1);
  transition: transform .2s;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  border-color: initial;
}

.button-80:not(:disabled):hover {
  transform: scale(1.05);
}

.button-80:not(:disabled):hover:active {
  transform: scale(1.05) translateY(.125rem);
}

.button-80:focus {
  outline: 0 solid transparent;
}

.button-80:focus:before {
  content: "";
  left: calc(-1*.375rem);
  pointer-events: none;
  position: absolute;
  top: calc(-1*.375rem);
  transition: border-radius;
  user-select: none;
}

.button-80:focus:not(:focus-visible) {
  outline: 0 solid transparent;
}

.button-80:focus:not(:focus-visible):before {
  border-width: 0;
}

.button-80:not(:disabled):active {
  transform: translateY(.125rem);
}
    .chat-div{
        min-height: 100px;
        border-bottom: 1px solid #BBC1E1;
        cursor: pointer;

    }
    .from-name{
        width: auto !important;
        position: relative;
        left: 20px;
        top: 22px;
    }
    .to-name{
        position: relative;
        top: 25px;
        left: 22px;
        display: contents;
    }
    .time-chat{
        float: inline-end;
        position: relative;
        top: -3px;
        right: 62px;
    }
    .reply-input-feld{
            width: 100%;
            margin-left: 20px;
            margin-right: 20px;
            margin-top: 20px;
            display: inline-table;
        }
        .ql-editor{
            min-height:200px ;
            max-height:200px ;
        }
        .email-sidebar-class {
            /* Your initial styles go here */
     transition: display 0.3s ease; /* Add a smooth transition effect for the display property */
    }
    .all-mail-search{
            position: relative;
            width: 40px;
            left: 359px;
            font-size: 12px;
            top: -6px;
        }
        .search-chk{
                position: relative;
                left: 354px;
                top: -6px;
        }
    @media screen and (width: 1366px) {
        .all-mail-search{
            position: relative;
            width: 40px;
            left: 310px;
            font-size: 12px;
            top: 5px;
        }
        .search-chk{
                position: relative;
                left: 302px;
                top: -6px;
        }
        .width-serch {
            width: 200px !important;
        }
    }
    @media screen and (width: 1440px) {
        .body-email-header{
            max-width: 807px;
        }
        .body_of_mail{
            max-width: 700px;
        }
        .reply-input-feld{

            margin-left: 20px;
            margin-right: 20px;
            margin-top: 20px;

        }
        .ql-editor{
            min-height:200px ;
            max-height:200px ;
        }
        .replymail-chat{
            margin-left: 2px;
        }
        .all-mail-search {
            position: relative;
            width: 40px;
            font-size: 12px;
            transform: translate(0, -50%);
            top: 50%;
            display: flex;
            align-items: center;
            left: 240px;
        }
        .search-chk {
            position: relative;
            left: 232px;
            transform: translate(0, -50%);
            top: 50%;
            display: flex;
            align-items: center;
        }
    }
        .delete-action{
            margin-left: 5px;
            margin-right: 5px;
            margin-top: 3px;
            /* display: none; */
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
        .width-serch{
            width: 200px;
        }
        .width-serch-main{
            left: 394px !important;
        }
        .imagedown {
            opacity: 1;
            display: block;
            width: 100%;
            height: auto;
            transition: .5s ease;
            backface-visibility: hidden;
            }

            .middle {
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
            }

            .attachment-container:hover .image {
            opacity: 0.3;
            }

            .attachment-container:hover .middle {
            opacity: 1;
            }

            .text1212 {
            background-color: #04AA6D;
            color: white;
            font-size: 10px;

            }
            .attachment-container {
        position: relative;
        display: inline-block;
    }

    .download-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #007bff; /* Button background color */
        color: #fff; /* Button text color */
        border: none;
        padding: 10px;
        cursor: pointer;
        border-radius: 5px;
        display: none; /* Hide by default */
    }

    .download-button i {
        margin-right: 5px; /* Adjust spacing between icon and text */
    }

    .attachment-container:hover .download-button {
        display: block; /* Show on hover */
    }
    .disabled-div {
        pointer-events: none;
        opacity: 0.5; /* You can adjust the opacity to make it visually appear disabled */
    }


    </style>

    <div class="container-fluid mb-5 content-position body-email">
        <div class="se-pre-con"></div>

        @section('order-header')
        <span id="mailheadder">{{ $showHeading }}</span>
        @endsection

        <div class="col-12 mx-0 px-0 "  style="height: 20px;;padding: 10px 0;">
            <div style="margin: auto;">
                {{-- <b><span class="align-middle" style=" font-size: 40px;">{{ $showHeading }}</span></b> --}}
                {{-- <a  class="float-right"  href="{{route('azure.logout')}}" >
                    <button type="button" class="btn-logout">
                        <i data-feather="log-out" class="font-medium-2 mr-50"></i>
                        <b>LOGOUT</b>
                    </button>
                </a> --}}



            </div>
        </div>
        <div class="row">
        <div class="body-email-header min-height overflow-scroll col-9 " >
            <form id="formGetEmails" method="post" action="{{ route('getEmails') }}"
            style="margin-bottom: 5px;text-align: end;margin-right: 8px;margin-top: 5px;">
            {{ csrf_field() }}
            <input type="text" value="" id="txtGetEmailType" hidden name="txtGetEmailType" />
            <input type="text" value="" id="txtHeaderEmailType" hidden name="txtHeaderEmailType" />

            <input type="text" id="txtPgNo" value="" hidden name="txtPgNo" />
            <input type="text" id="serachText" value="" hidden name="serachText" />
            <input type="text" id="serachOnOff" value="" hidden name="serachOnOff" />
        </form>

        <form id="deletemail" method="post" action="{{ route('getEmails') }}"
            style="margin-bottom: 5px;text-align: end;margin-right: 8px;margin-top: 5px;">
            {{ csrf_field() }}
            <input type="text" value="" id="txtGetDeleteEmailType" hidden name="txtGetEmailType" />
            <input type="text" value="" id="txtHeaderDeleteEmailType" hidden name="txtHeaderEmailType" />

            <input type="text" id="txtDeletePgNo" value= "1" hidden name="txtPgNo" />
            <input type="text" id="serachDeleteText" value="" hidden name="serachText" />
            <input type="text" id="serachDeleteOnOff" value="OFF" hidden name="serachOnOff" />

            <input type="text" id="messageNo" value="{{ $messageNo }}" hidden name="messageNo" />
        </form>

        <form id="moveMail" method="post" action="{{ route('getEmails') }}"
            style="margin-bottom: 5px;text-align: end;margin-right: 8px;margin-top: 5px;">
            {{ csrf_field() }}
            <input type="text" value="" id="txtGetMoveEmailType" hidden name="txtGetEmailType" />
            <input type="text" value="" id="txtHeaderMoveEmailType" hidden name="txtHeaderEmailType" />

            <input type="text" id="txtMovePgNo" value="" hidden name="txtPgNo" />
            <input type="text" id="serachMoveText" value="" hidden name="serachText" />
            <input type="text" id="serachMoveOnOff" value="" hidden name="serachOnOff" />

            <input type="text" id="txtMoveMailNumber" value="{{ $messageNo }}" hidden
                name="txtMoveMailNumber" />
            <input type="text" id="txtMailMovePath" value="" hidden name="txtMailMovePath" />
        </form>

        <form id="restoremail" method="post" action="{{ route('getEmails') }}"
            style="margin-bottom: 5px;text-align: end;margin-right: 8px;margin-top: 5px;">
            {{ csrf_field() }}
            <input type="text" value="" id="txtGetRestoreEmailType" hidden name="txtGetEmailType" />
            <input type="text" value="" id="txtHeaderRestoreEmailType" hidden name="txtHeaderEmailType" />

            <input type="text" id="txtRestorePgNo" value="" hidden name="txtPgNo" />
            <input type="text" id="serachRestoreText" value="" hidden name="serachText" />
            <input type="text" id="serachRestoreOnOff" value="" hidden name="serachOnOff" />

            <input type="text" id="restoreMessageNo" value="{{ $messageNo }}" hidden
                name="restoreMessageNo" />
        </form>
        <input type="text" name="txtMailSubject" id="txtMailSubject"
        value="{{ $emailSubject}}" hidden />
        <input type="text" name="txtMailRepyTo" id="txtMailRepyTo" value="{{ $fromMailAddress }}" hidden />
        <input type="text" name="txtMailBodyHead" id="txtMailBodyHead"
            value="On {{ $date }}, @php echo $fromAddressName; @endphp wrote:" hidden />

        <input class="spacing" type="hidden" name="txtBodyMessage" id="txtBodyMessage"
            value="{{$plainText}}" hidden />
        <input class="spacing" type="hidden" name="mailboxtype" id="mailboxtype"
            value="{{$showType}}" hidden />
            <div class="row  mt-3" style="margin-left:0.1rem;margin-right: 0.1rem;border-bottom: 2px ridge;width: -webkit-fill-available;height:45px">
                {{-- <div class="me-4 "><input he style="transform: scale(1.5);" class="form-check-input  mt-2"type="checkbox" name="checkboxMail[]" value="" id="selectAllCheck"></div> --}}
                <div class="col-6"  style="display: flex;">
                    <div class="me-4  ReportasSpam" style="width: fit-content;">
                        <span class="action-icon favorite IconColor" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Report spam">
                            <i data-feather="chevron-down" class="font-medium-2  mt-1"></i>
                        </span>
                    </div>
                    <p class=" mx-2 IconColor" style="pointer:cursor;margin-top: 0px !important;width: fit-content;;width: fit-content;">|</p>
                    <div class="me-4  delete-action " style="width: fit-content;">
                        <span class="action-icon favorite IconColor" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Report spam">
                            <i data-feather="alert-octagon" class="font-medium-2  mt-1"></i>
                        </span>
                    </div>
                    <p class=" mx-2 IconColor " style="pointer:cursor;margin-top: 0px !important;width: fit-content;;">|</p>

                    <div class="me-4  delete-action deleteMail "  style="width: fit-content;">
                        <span class="action-icon favorite IconColor " data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
                            <i data-feather="trash-2" class="font-medium-2  mt-1"></i>
                        </span>
                    </div>
                    <p class=" mx-2 IconColor  "  style="pointer:cursor;margin-top: 0px !important;width: fit-content;;">|</p>

                    <div class="me-4  delete-action "  style="width: fit-content;">
                        <span class="action-icon favorite IconColor MarkasRead disabled-div" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Mark as read">
                            <i data-feather="inbox" class="font-medium-2  mt-1"></i>
                        </span>
                    </div>
                    <p class=" mx-2 IconColor  " style="pointer:cursor;margin-top: 0px !important;width: fit-content;;">|</p>

                    <div class="me-4  delete-action "  style="width: fit-content;">
                        <span class="action-icon favorite IconColor MarkasUnRead disabled-div" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Mark as unread">
                            <i data-feather="mail" class="font-medium-2  mt-1"></i>
                        </span>
                    </div>
                    <p class=" mx-2 IconColor " style="pointer:cursor;margin-top: 0px !important;width: fit-content;;">|</p>

                    <div class="me-4  delete-action "  style="width: fit-content;">
                        <span class="action-icon favorite IconColor" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Mail box">
                            <i data-feather="message-square" class="font-medium-2  mt-1"></i>
                        </span>
                    </div>
                    <p class=" mx-2 IconColor " style="pointer:cursor;margin-top: 0px !important;width: fit-content;">|</p>

                    <div class="me-4  delete-action   " onclick="toggleCompose(event)"  style="width: fit-content;">
                        <span class="action-icon favorite IconColor" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Compose">
                            <i data-feather="edit" class="font-medium-2  mt-1"></i>
                        </span>
                    </div>
                    <p class=" mx-2 IconColor " style="pointer:cursor;margin-top: 0px !important;width: fit-content;">|</p>

                    <div class="me-4  delete-action   " onclick="replyMessageOpen()"  style="width: fit-content;">
                        <span class="action-icon favorite IconColor" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Reply">
                            <i data-feather="corner-up-left" class="font-medium-2  mt-1"></i>
                        </span>
                    </div>
                    <p class=" mx-2 IconColor " style="pointer:cursor;margin-top: 0px !important;width: fit-content;">|</p>

                    <div class="me-4  delete-action hide-desiable " onclick="forwardMessage()"  style="width: fit-content;">
                        <span class="action-icon favorite IconColor" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Forward">
                            <i data-feather="corner-up-right" class="font-medium-2  mt-1"></i>
                        </span>
                    </div>
                </div>
                <div class="col-6" style="padding-right:unset">
                    <div class="input-group ">
                        <input class="form-control border rounded-pill" type="search" placeholder="Search emails" id="emailSearch">
                        <div class="input-group-prepend emailsearchcleardiv">
                            <button id="emailSearchClear" type="button" class="btn btn-circle">
                                <i class="fa fa-close" aria-hidden="true"></i></button>
                        </div>
                        <input type="checkbox" aria-label="Checkbox for following text input" class="mx-1" id="myCheckboxsearch">
                        <p class="my-auto" style="font-size: 0.6rem">All mail</p>
                        <a  class="float-right ml-2"  href="{{route('azure.logout')}}"  style="color:#3b3b3b">
                            {{-- <button type="button" class="btn-logout"> --}}
                                <i data-feather="log-out" class="font-medium-2 mr-50" style="height: 1.5rem;width: 1.5rem;"></i>
                                {{-- <b>LOGOUT</b> --}}
                            {{-- </button> --}}
                        </a>
                    </div>
                </div>
                {{-- <div class="col-2">
                </div> --}}
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

                {{-- <div class="row "> --}}
                {{-- </div> --}}


            </div>

            <div class="row  " style="overflow-y: auto;overflow-x: clip;max-height: -webkit-fill-available;">
                <div class="col-12 " style="margin-left:20px" style="display:inline">
                    <h5 style="font-size: 1rem;" >{{ $emailSubject}}</h5>
                <div class=" pr-50">
                    <div class="col-2  my-0 mr-50" style="
                    display: -webkit-inline-box;">
                        <div class="dot">
                            <span class="white-text">
                                @php
                                    $from = $fromAddressName;
                                    $words = explode(' ', $from); // Split the text into words
                                    $abbreviated = '';
                                    for ($i = 0; $i < min(count($words), 2); $i++) {
                                        $abbreviated .= strtoupper(substr($words[$i], 0, 1)); // Append the first letter of each word in uppercase
                                    }
                                    echo $abbreviated;
                                @endphp
                            </span>
                        </div>

                    <h5 class="mb-0" style="width: max-content;margin-left:5px">{{ $fromAddressName }}</h5></div>
                    <div ><h5 class="mb-0" style="position:relative; margin-left:59px;top:-17px;">To me</h5></div>
                </div>
                <div class="card-body mail-message-wrapper pt-2" style="border-bottom: 1px solid #BBC1E1;">
                    <div class="mail-message">
                        <p class="card-text">
                            @php
                                echo quoted_printable_decode($emailMessage);
                            @endphp
                        </p>
                    </div>
                </div>
                                    @php
                        $counter = 0;
                    @endphp

                    @foreach ($emailThread as $emailset)
                        @if ($counter > 0)
                            <div class="row mt-1" data-email="{{ $emailset['id'] }}" onclick="toggleEmailContent(this)">
                                <div class="col-12 chat-div">
                                    <div class="dot mt-4" style="float: left;">
                                        <span class="white-text">
                                            @php
                                                $from = $emailset['from']['emailAddress']['name'];
                                                $words = explode(' ', $from);
                                                $abbreviated = '';
                                                for ($i = 0; $i < min(count($words), 2); $i++) {
                                                    $abbreviated .= strtoupper(substr($words[$i], 0, 1));
                                                }
                                                echo $abbreviated;
                                            @endphp
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="mb-0 from-name" style="width: max-content;margin-left:5px">{{ $emailset['from']['emailAddress']['address'] }}</h4>
                                    </div>
                                    <span class="time-chat">
                                        @php
                                        $dateString = $emailset['receivedDateTime'];

                                        // Create a Carbon instance from the string
                                        $date = \Carbon\Carbon::parse($dateString);

                                        // Format the date according to the custom format
                                        $formattedDate = $date->format("D, d M, H:i");

                                        // Calculate the time difference
                                        $timeDifference = $date->diffForHumans();

                                        // Output the formatted date and time difference
                                        echo $formattedDate . " (" . $timeDifference . ")";
                                    @endphp






                                    </span>
                                    <div class="body_of_mail" style="position: static; margin-top: 30px; margin-left: 60px;word-wrap: break-word;">
                                        <span class="mb-0 to-name" id="short{{ $emailset['id'] }}" style="overflow: hidden; text-overflow: ellipsis;display:contant">
                                            @php
                                                $text = $emailset['bodyPreview'];

                                                // Find the position of the first occurrence of "\r\n"
                                                $position = strpos($text, "\r\n");

                                                // Extract the substring before the first "\r\n"
                                                $result = substr($text, 0, $position);

                                                // Trim any leading or trailing whitespace
                                                $result = trim($result);

                                                // Output the result
                                                echo $result;
                                            @endphp
                                        </span>
                                        <span class="mb-0 to-name" id="long{{ $emailset['id'] }}" style="overflow: hidden; text-overflow: ellipsis;display:none">
                                            @php
                                            echo nl2br(quoted_printable_decode($emailset['bodyPreview']));
                                            @endphp

                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @php
                            $counter++;
                        @endphp
                    @endforeach


            </div>
            <!-- Check if there are attachments -->
            @if (!empty($downloadAttachments))
            {{-- <h3>Attachments:</h3>
            <ul>
                <!-- Loop through each attachment in the array -->
                @foreach ($downloadAttachments as $attachment)
                    <li> --}}
                        {{-- <strong>Filename:</strong> {{ $attachment['filename'] }}<br>
                        <strong>Content ID:</strong> {{ $attachment['contentId'] }}<br>
                        <!-- Display a link or button to download or view the attachment -->
                        <a href="#">Download Attachment</a>
                        <!-- You can also embed images directly in the view if they are images --> --}}
                        {{-- <img src="data:image/png;base64,{{ base64_encode($attachment['attachmentContent']) }}" alt="Attachment Image" style="width: 100px;height:100px">
                    </li>
                @endforeach
            </ul>
            @else
            <p>No attachments found.</p> --}}

                <?php
                        function getFileTypeIconClass($contentType)
                        {
                            // Check the content type and return a corresponding icon class
                            if (str_starts_with($contentType, 'image/')) {
                                return 'fa fa-file-image-o'; // Example class for image files
                            } elseif (str_starts_with($contentType, 'application/pdf')) {
                                return 'fa fa-file-pdf-o'; // Example class for PDF files
                            } elseif (str_starts_with($contentType, 'application/msword')) {
                                return 'fa fa-file-word-o'; // Example class for Word files
                            } else {
                                return 'fa fa-file-o'; // Default class for other file types
                            }
                        }

                    ?>
            <div class="row" style="width: 100%; padding: 30px;">
                @foreach ($downloadAttachments as $attachment)
                    <div class="attachment-container" style="margin: 10px; position: relative; text-align: center;">
                        @if (str_starts_with($attachment['contentType'], 'image/'))
                            {{-- Display image if it's an image --}}
                            <img
                                src="data:{{ $attachment['contentType'] }};base64,{{ base64_encode($attachment['attachmentContent']) }}"
                                alt="Attachment Image"
                                class="attachment-image-with-shadow"
                                style="width: 100px; height: 100px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                onerror="this.onerror=null; this.src='{{ asset('public/email_attachments/default-icon.jpg') }}';"
                            >
                        @else
                            {{-- Display icon if it's not an image --}}
                            <div class="attachment-icon" style="font-size: 100px;">
                                <i class="{{ getFileTypeIconClass($attachment['contentType']) }}"></i>
                            </div>
                        @endif

                        <div class="attachment-info">
                            <div class="middle">
                                <div class="text1212">
                                    <button class="download-button" onclick="downloadAttachment('{{ $attachment['filename'] }}', '{{ base64_encode($attachment['attachmentContent']) }}', '{{ $attachment['contentType'] }}')">
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Hidden link element for triggering download --}}
                        <a id="downloadLink_{{ $attachment['filename'] }}" style="display: none;"></a>
                    </div>
                @endforeach
            </div>









            @endif


            <div class="row replymail-chat " style="width:100%;height:auto;display:none" id="replyEditordiv">
                <div class="reply-input-feld">
                    <i class="fa fa-times" aria-hidden="true" style="position: relative;top: 17px; right: 15px;float: right;" onclick="replyMessageClose()"></i>
                        <div  id="editor-container1" ></div>

                </div>
                {{-- <div class="compose-body input-file-show">
                    <div class="compose-input-feld" style="display:inline" id="showAttachmentArea">
                    </div>
                </div> --}}
                <!-- Example split danger button -->
                {{-- <div class="btn-group">
                    <button type="button" onclick="getEditorContents();" class="btn btn-primary">send</button>
                    <button type="button" id="btnSaveDraft" class="btn btn-primary mx-2">save draft</button>
                    <input type="file" name="file[]" id="file" class="inputfile float-" onchange="getSelectedFiles(this)"
                        data-multiple-caption="{count} files selected" multiple hidden/>

                </div> --}}
            </div>
            <form name="replyMail" id="replyMail" enctype="multipart/form-data" method="post">
                {{ csrf_field() }}
                <input type="text" value="{{$messageNo}}" name = "txtMessgNo" id="txtMessgNo" hidden/>
                <input type="text" value="{{$conversationId}}" name = "conversationId" id="conversationId" hidden/>
                <input type="text" id="copied_message_body1" name="copied_message_body1" hidden>
            </form>
            {{-- @if(session('refresh'))
            <script>
                location.reload(true);
            </script>
            @endif --}}
            <div class="row mb-5" style ="height: 200px;">
                <div class="col-12">
                    <div class="">
                        <div class="card-body">
                            <div>
                                    <a    href="#" id="replyBTN" >
                                        {{-- <button type="button" class="button-80 " onclick="replyMessage()" style="margin-left:40px">

                                        </button> --}}
                                        <button class="button-80" role="button" onclick="replyMessageOpen()" >
                                            REPLY</button>
                                    </a>
                                    <a    href="#" id="replysendBTN" style="display: none">
                                        {{-- <button type="button" class="button-80 " onclick="replyMessage()" style="margin-left:40px">

                                        </button> --}}
                                        <button class="button-80" role="button" onclick="getEditorContentsreply()" style="margin-left:10px;color: #287dd5;">
                                            SEND</button>
                                    </a>


                                    <a    href="#" id="forwardBTN">

                                        <button class="button-80" role="button" onclick="forwardMessage()"  style="margin-left:10px">
                                            FORWARD</button>
                                    </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <div style="height:85vh;background-color:#ffffff;max-width: 333px !important;    position: absolute;right: 20px;" class="float-right col-4 ms-2">
        <div style="margin:5px;width:100%;background-color:#ffffff;height:auto;margin-top: 14px;" class="contact-section">
            <div style="    margin-top: 15px;margin-bottom: 16px;margin-left: 13px;">
                <span class="head-of-linkside">{{ count($allCCAddresses) + count($allToAddresses) + 1 }} people in this conversation</span>
            </div>

            <div class="con-section">
                {{-- <button type="button"  onclick="updateContent_of_email('{{ $fromMailAddress }}')">click me<button> --}}

                <div class="dot" data-email="{{ $fromMailAddress }}" data-org="{{$organizations}}" data-peo="{{$peoples}}" data-orgpeo="{{$peoples_organization}}" onclick="updateContent_of_email(this)">
                    <span class="white-text">
                        @php
                        $from = $fromAddressName;
                        $words = explode(' ', $from); // Split the text into words
                        $abbreviated = '';
                        for ($i = 0; $i < min(count($words), 2); $i++) {
                            $abbreviated .= strtoupper(substr($words[$i], 0, 1)); // Append the first letter of each word in uppercase
                        }
                        echo $abbreviated;
                        @endphp
                    </span>
                </div>
                @foreach ($allCCAddresses as $ccAddress)
                    <div class="dot" data-email="{{ $ccAddress['mail'] }}" data-org="{{$organizations}}" data-peo="{{$peoples}}" data-orgpeo="{{$peoples_organization}}"  onclick="updateContent_of_email(this)" >
                        <span class="white-text">
                            @php
                            $from =$ccAddress['mail'];
                            $words = explode(' ', $from); // Split the text into words
                            $abbreviated = '';
                            for ($i = 0; $i < min(count($words), 2); $i++) {
                                $abbreviated .= strtoupper(substr($words[$i], 0, 1)); // Append the first letter of each word in uppercase
                            }
                            echo $abbreviated;
                            @endphp

                        </span>
                    </div>
                @endforeach
                @foreach ($allToAddresses as $ccAddress)
                    <div class="dot" data-email="{{ $ccAddress['mail'] }}" data-org="{{$organizations}}" data-peo="{{$peoples}}" data-orgpeo="{{$peoples_organization}}" onclick="updateContent_of_email(this)">
                        <span class="white-text">
                            @php
                            $from = $ccAddress['mail'];
                            $words = explode(' ', $from); // Split the text into words
                            $abbreviated = '';
                            for ($i = 0; $i < min(count($words), 2); $i++) {
                                $abbreviated .= strtoupper(substr($words[$i], 0, 1)); // Append the first letter of each word in uppercase
                            }
                            echo $abbreviated;
                            @endphp
                        </span>
                    </div>
                @endforeach
            </div>
            <div id="details_section">
                @php
                $selectedEmail = $fromMailAddress; // Replace this with your selected email
                @endphp
                @php $found = false; @endphp
                @foreach ($peoples as $people )
                    @if($people->email == $selectedEmail)
                            <div class="nameTag">
                                <div class="dot" >
                                    <span class="white-text">
                                        @php
                                        $from = $people->first_name . ' ' . $people->last_name;
                                        $words = explode(' ', $from); // Split the text into words
                                        $abbreviated = '';
                                        for ($i = 0; $i < min(count($words), 2); $i++) {
                                            $abbreviated .= strtoupper(substr($words[$i], 0, 1)); // Append the first letter of each word in uppercase
                                        }
                                        echo $abbreviated;
                                        @endphp
                                    </span>
                                </div>
                                <div><h4 style="position: relative;top: 7px;margin-left: 5px;font-size:0.9rem">{{$people->first_name . ' ' . $people->last_name }}</h4></div>
                            </div>
                            <div class="mail-tag">
                                <i class="fa fa-envelope-o" aria-hidden="true" style="margin-top: 5px;"></i>
                                <h6 style="    position: relative;margin-left: 10px;    padding-right: 18px;" id="peopel_email_address">{{ $people->email }}</h6>
                            </div>
                            <div id="organizationCarousel" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($peoples_organization as $index => $organizationpeo)
                                        @if($organizationpeo->contact_id == $people->id)
                                            <div class="carousel-item {{$index}}{{ $index == 0 ? 'active' : '' }}">
                                                <div class="mail-tag">
                                                    <i class="fa fa-sitemap" aria-hidden="true" style="margin-top: 5px;"></i>
                                                    <h5 style="position: relative; margin-left: 10px; padding-right: 18px;">
                                                        <a href="{{ url('organizations/info', [$organizationpeo->organization_id]) }}">
                                                            @foreach ($organizations as $organization)
                                                                @if($organization->id == $organizationpeo->organization_id)
                                                                    {{ $organization->organization_name ?? 'Not connected with organization' }}
                                                                @endif
                                                            @endforeach
                                                        </a>
                                                    </h5>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#organizationCarousel" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#organizationCarousel" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>




                            {{-- <div class="mail-tag">
                                <i class="fa fa-sitemap" aria-hidden="true" style="margin-top: 5px;"></i>
                                <h5 style="    position: relative;margin-left: 10px;    padding-right: 18px;"><a href="{{ url('organizations/info', [$people->organization_id]) }}">
                                    @foreach ($organizations as $organization )
                                        @if($organization->id == $people->organization_id)
                                        {{ $organization->organization_name ?? 'Not connected with organization' }}
                                        @endif
                                    @endforeach
                                    </a></h5>
                            </div> --}}
                            <div class="mail-tag">
                                <i class="fa fa-map-marker" aria-hidden="true" style="margin-top: 5px;"></i>
                                <h5 style="    position: relative;margin-left: 10px;    padding-right: 18px;">{{ $people->shipping_street ?? 'Not set the address'}}</h5>
                            </div>
                            <div class="normal-btn" id="add_new_activity">
                                <span class="btn-caption"> Add activity</span>
                            </div>
                            @php $found = true; @endphp
                    @endif
                @endforeach
                @if (!$found)
                        <div class="nameTag">
                            <div class="dot" >
                                <span class="white-text">
                                    @php
                                    $from = $fromAddressName;
                                    $words = explode(' ', $from); // Split the text into words
                                    $abbreviated = '';
                                    for ($i = 0; $i < min(count($words), 2); $i++) {
                                        $abbreviated .= strtoupper(substr($words[$i], 0, 1)); // Append the first letter of each word in uppercase
                                    }
                                    echo $abbreviated;
                                    @endphp

                                </span>
                            </div>
                            <div><h4 style="position: relative;top: 7px;margin-left: 5px;" id="peopel_email_addressNAme">{{ $fromAddressName }}</h4></div>
                        </div>
                        <div class="mail-tag">
                            <i class="fa fa-envelope-o" aria-hidden="true" style="margin-top: 5px;"></i>
                            <h5 style="    position: relative;margin-left: 10px;" id="peopel_email_address">{{ $fromMailAddress }}</h5>
                        </div>

                        <div class="normal-btn">
                            <span class="btn-caption"> Add to existing contact</span>
                        </div>

                        <div class="normal-btn-green" id="add_people_from_mail" data-mail="{{ $fromMailAddress }}">
                            <span class="btn-green-caption" > Create new contact</span>
                        </div>
                @endif

            </div>



        </div>
        <div style="margin:5px;width:100%;background-color:#ffffff;height:auto" class="contact-section">
            <input type="hidden" id="organization_mail_sender" value="{{ $organizationMailDetail['sender'] ?? '' }}">
            <input type="hidden" id="organization_mail_type" value="{{ $organizationMailDetail['type'] ?? '' }}">
            <input type="hidden" id="organization_mail_uid" value="{{ $organizationMailDetail['uid'] ?? '' }}">
            <input type="hidden" id="organization_mail_subject" value="{{ $organizationMailDetail['subject'] ?? '' }}">
            <input type="hidden" id="organization_mail_date" value="{{ $organizationMailDetail['date'] ?? '' }}">
            <input type="hidden" id="organization_messageNo" value="{{ $messageNo }}" hidden name="organization_messageNo" />
            @if (isset($linkedOrganization->organizationDetail))

                <div style="    margin-top: 15px;margin-bottom: 16px;margin-left: 13px;">
                    <span class="head-of-linkside">link to an organization</span>
                </div>
                <div class="oragnization-caption">
                    <span style="display: inline-flex;height: 80px;margin: auto 25px;" id="linked_organization_name"><a href="{{ url('organizations/info', [$linkedOrganization->organization_id]) }}">{{ $linkedOrganization->organizationDetail->organization_name ?? '' }}</a></span>
                </div>


                <div class="normal-btn-red" >
                    <span class="btn-green-caption"> Remove organization</span>
                </div>
                @else
                <div style="    margin-top: 15px;margin-bottom: 16px;margin-left: 13px;">
                    <span class="head-of-linkside">link to an organization</span>
                </div>
                <div class="oragnization-caption">
                    <span style="display: inline-flex;height: 80px;margin: auto 25px;">Find an existing organization or create a new one</span>
                </div>
                <div class="normal-btn" id="organization_link">
                    <span class="btn-caption"> Add to existing organization</span>
                </div>

                <div class="normal-btn-green" id="add_organization12">
                    <span class="btn-green-caption"> Create new organization</span>
                </div>
                @endif


        </div>
    </div>


    {{-- <script>
        function toggleEmailContent() {
            var emailBodyPreview = document.getElementById('emailBodyPreview');
            emailBodyPreview.style.whiteSpace = (emailBodyPreview.style.whiteSpace === 'normal') ? 'nowrap' : 'normal';
        }
    </script> --}}
    {{-- <script>
        var expanded = false;

        function toggleSeeMore() {
            var seeMoreContent = document.getElementById('seeMore');
            var emailBodyPreview = document.getElementById('emailBodyPreview');
            var button = document.querySelector('button');

            expanded = !expanded;

            if (expanded) {
                emailBodyPreview.style.whiteSpace = 'normal';
                emailBodyPreview.style.overflow = 'visible';
                seeMoreContent.style.display = 'none';
                button.innerText = 'See Less';
            } else {
                emailBodyPreview.style.whiteSpace = 'nowrap';
                emailBodyPreview.style.overflow = 'hidden';
                seeMoreContent.style.display = 'inline';
                button.innerText = 'See More';
            }
        }
    </script> --}}
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script>
        $(document).ready(function () {
        // Set the first item as active when the carousel is loaded
        $('#organizationCarousel .carousel-item').first().addClass('active');
    });
        $(document).ready(function(){
            // Initialize Bootstrap components
            $('[data-toggle="collapse"]').collapse();
        });
    </script>
   <script>
    function downloadAttachment(filename, file, contentType) {
        // Convert base64 to Blob using b64toBlob function
        var blob = b64toBlob(file, contentType);

        // Create an object URL for the Blob
        var url = URL.createObjectURL(blob);

        // Create a link element
        var link = document.createElement('a');

        // Set the href attribute to the object URL
        link.href = url;

        // Set the download attribute to the desired filename
        link.download = filename;

        // Append the link to the body
        document.body.appendChild(link);

        // Trigger a click on the link to start the download
        link.click();

        // Remove the link from the DOM
        document.body.removeChild(link);
    }

    // Function to convert a base64 string to a Blob
    function b64toBlob(b64Data, contentType = '', sliceSize = 512) {
        var byteCharacters = atob(b64Data);
        var byteArrays = [];

        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            var slice = byteCharacters.slice(offset, offset + sliceSize);

            var byteNumbers = new Array(slice.length);
            for (var i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }

            var byteArray = new Uint8Array(byteNumbers);
            byteArrays.push(byteArray);
        }

        var blob = new Blob(byteArrays, { type: contentType });
        return blob;
    }

</script>


    <script>
        $(document).ready(function() {
        let input = document.getElementById("file");
        let imageName = document.getElementById("imageName")
            var quill = new Quill('#editor-container1', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'], // Text styles
                        [{ 'color': [] }], // Font color
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }], // Lists
                        [{ 'size': ['small', false, 'large', 'huge'] }], // Font size
                        [{ 'align': [] }], // Alignment options
                        ['clean'] // Remove formatting
                    ]
                }
            });

            // Handle changes in the Quill editor and update the hidden input
            quill.on('text-change', function() {
                var htmlContent = quill.root.innerHTML;
                document.getElementById('copied_message_body1').value = htmlContent;
                console.log(htmlContent);
            });

        // Clear formatting button functionality
        document.getElementById('clear-formatting').addEventListener('click', function() {
            quill.format('bold', false);
            quill.format('italic', false);
            quill.format('underline', false);
            quill.format('strike', false);
            quill.format('color', false);
            quill.format('size', false);
        });});
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
        function toggleEmailContent(clickedDot) {
            var id = clickedDot.getAttribute('data-email');
            console.log(id);
            const toggleElement1 = document.getElementById('short' + id);
            const toggleElement2 = document.getElementById('long' + id);

            // Check the current visibility of the first element
            if (toggleElement1.style.display === 'none' || toggleElement1.style.display === '') {
                // If it's hidden, show the first element and hide the second
                toggleElement1.style.display = 'contents';
                toggleElement2.style.display = 'none';
            } else {
                // If it's visible, show the second element and hide the first
                toggleElement1.style.display = 'none';
                toggleElement2.style.display = 'contents';
            }
        };
        function replyMessageOpen(){
            const replybtn = document.getElementById('replyBTN');
            const replysendbtn = document.getElementById('replysendBTN');
            const forwardbtn = document.getElementById('forwardBTN');
            const replyEditor = document.getElementById('replyEditordiv');

            replybtn.style.display = 'none';
            replysendbtn.style.display = 'contents';
            forwardbtn.style.display = 'none';
            replyEditor.style.display = 'contents';
        };
        function replyMessageClose(){
            const replybtn = document.getElementById('replyBTN');
            const replysendbtn = document.getElementById('replysendBTN');
            const forwardbtn = document.getElementById('forwardBTN');
            const replyEditor = document.getElementById('replyEditordiv');

            replybtn.style.display = 'contents';
            replysendbtn.style.display = 'none';
            forwardbtn.style.display = 'contents';
            replyEditor.style.display = 'none';
        }
        function getEditorContentsreply() {

            document.getElementById('replyMail').action = "{{ route('sendreplyemail') }}";
            document.getElementById("replyMail").submit();
        }
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
        $('#add_new_activity').on('click', function(){
            var organizationId = @json($linkedOrganization->organization_id ?? null);

            $.ajax({
                url:"{{ url('activities/get_organizations') }}",
                method:'GET',
                dataType:'json',
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data){
                    var organizations = data;

                    var start_date = moment().format('L');
                    var start_time = moment().format('LT');
                    var due_date = moment().format('L');

                    var today_day = moment().format('dddd, MMMM Do');
                    var today_date = moment().format('L');
                    $('#selected_day').html(today_day);
                    $('#selected_date').val(today_date);

                    var today_date = today_date.replace(/\//g, '-');
                    getActivitiesByDate(today_date);

                    $('#activity_subject').val('');
                    $('#activity_note').val('');
                    $('#start_date').val(start_date);
                    $('#start_time').val(start_time);
                    $('#due_date').val(due_date);
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
                        org_options += '<option value="'+organizations[i].id+'" ' + (organizations[i].id == organizationId ? 'selected' : '') + '>'+organizations[i].organization_name+'</option>';
                    }
                    $('#activity_organization_id').html(org_options);

                },
                complete: function () {
                    $('#activity_modal_new').modal('show');
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        });

        function updateContent_of_email(clickedDot) {

            var found = false;
            const email12 = clickedDot.getAttribute('data-email');
            // const peoples = clickedDot.getAttribute('data-peo');
            // const organizations = clickedDot.getAttribute('data-org');
            console.log('wedooo');
            console.log(email12);

            var peoplesData = JSON.parse(clickedDot.dataset.peo); // Assuming data-peo is a JSON string
            var organizationsData = JSON.parse(clickedDot.dataset.org);
            var peoplesorganizationsData = JSON.parse(clickedDot.dataset.orgpeo);
            console.log(organizationsData);
            // console.log( peoplesorganizationsData);

            // Check if fromMailAddress is present in peoplesData
            var foundPerson = peoplesData.find(function(person) {
                return person.email === email12;
            });


            var targetDiv = document.getElementById('details_section');
                targetDiv.innerHTML = '';
            if (foundPerson) {
                // Check if fromMailAddress is present in organization

            // Update content with people details
            console.log("People Details:", foundPerson);
            // Add your logic to update the content with people details
            var nameTag = document.createElement('div');
                nameTag.className = 'nameTag';

                var dot = document.createElement('div');
                dot.className = 'dot';
                var span = document.createElement('span');
                span.className = 'white-text';

                var from = foundPerson.first_name + ' ' + foundPerson.last_name;
                var words = from.split(' ');
                var abbreviated = '';
                for (var j = 0; j < Math.min(words.length, 2); j++) {
                    abbreviated += words[j].charAt(0).toUpperCase();
                }

                span.textContent = abbreviated;
                dot.appendChild(span);
                nameTag.appendChild(dot);

                var name = document.createElement('h3');
                name.style = 'position: relative; top: 7px; margin-left: 5px;';
                name.textContent = foundPerson.first_name + ' ' + foundPerson.last_name;
                nameTag.appendChild(name);

                targetDiv.appendChild(nameTag);

                var mailTag = document.createElement('div');
                mailTag.className = 'mail-tag';

                var envelopeIcon = document.createElement('i');
                envelopeIcon.className = 'fa fa-envelope-o';
                envelopeIcon.setAttribute('aria-hidden', 'true');
                envelopeIcon.style.marginTop = '5px';
                mailTag.appendChild(envelopeIcon);

                var emailHeader = document.createElement('h5');
                emailHeader.style.position = 'relative';
                emailHeader.style.marginLeft = '10px';
                emailHeader.style.paddingRight = '18px';
                emailHeader.id = 'peopel_email_address';
                emailHeader.textContent = foundPerson.email;
                mailTag.appendChild(emailHeader);

                targetDiv.appendChild(mailTag);

                // var sitemapTag = document.createElement('div');
                // sitemapTag.className = 'mail-tag';

                // var sitemapIcon = document.createElement('i');
                // sitemapIcon.className = 'fa fa-sitemap';
                // sitemapIcon.setAttribute('aria-hidden', 'true');
                // sitemapIcon.style.marginTop = '5px';
                // sitemapTag.appendChild(sitemapIcon);

                // var sitemapHeader = document.createElement('h5');
                // sitemapHeader.style.position = 'relative';
                // sitemapHeader.style.marginLeft = '10px';
                // sitemapHeader.style.paddingRight = '18px';
                // var organizationName = 'Not connected with organization';

// Replace 'yourTargetDivId' with the actual ID of your target div

var carouselDiv = document.createElement('div');
    carouselDiv.id = 'organizationCarousel';
    carouselDiv.className = 'carousel slide';
    carouselDiv.setAttribute('data-ride', 'carousel');

    // Create carousel inner element
    var carouselInner = document.createElement('div');
    carouselInner.className = 'carousel-inner';

    // Loop through peoples_organization data
    for (var index = 0; index < peoplesorganizationsData.length; index++) {
        if (peoplesorganizationsData[index].contact_id === foundPerson.id) {

            // Create a carousel item
            var carouselItem = document.createElement('div');
            carouselItem.className = 'carousel-item' + (index === 0 ? ' active' : '');

            // Create mail tag div
            var mailTagDiv = document.createElement('div');
            mailTagDiv.className = 'mail-tag';

            // Create sitemap icon
            var sitemapIcon = document.createElement('i');
            sitemapIcon.className = 'fa fa-sitemap';
            sitemapIcon.setAttribute('aria-hidden', 'true');
            sitemapIcon.style.marginTop = '5px';
            mailTagDiv.appendChild(sitemapIcon);

            // Create h5 header
            var sitemapHeader = document.createElement('h5');
            sitemapHeader.style.position = 'relative';
            sitemapHeader.style.marginLeft = '10px';
            sitemapHeader.style.paddingRight = '18px';

            // Create organization link
            var orgLink = document.createElement('a');
            orgLink.href = '/Encore-Cloud/organizations/info/' + String(peoplesorganizationsData[index].organization_id);
            orgLink.textContent = (function () {
                for (var i = 0; i < organizationsData.length; i++) {
                    if (organizationsData[i].id === peoplesorganizationsData[index].organization_id) {
                        return organizationsData[i].organization_name || 'Not connected with organization';
                    }
                }
                return 'Not connected with organization';
            })();
            sitemapHeader.appendChild(orgLink);
            mailTagDiv.appendChild(sitemapHeader);

            carouselItem.appendChild(mailTagDiv);
            carouselInner.appendChild(carouselItem);
        }
    }

    // Create carousel controls
    var carouselPrev = document.createElement('a');
    carouselPrev.className = 'carousel-control-prev';
    carouselPrev.href = '#organizationCarousel';
    carouselPrev.role = 'button';
    carouselPrev.setAttribute('data-slide', 'prev');
    carouselPrev.innerHTML = '<span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span>';

    var carouselNext = document.createElement('a');
    carouselNext.className = 'carousel-control-next';
    carouselNext.href = '#organizationCarousel';
    carouselNext.role = 'button';
    carouselNext.setAttribute('data-slide', 'next');
    carouselNext.innerHTML = '<span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span>';

    // Append carousel inner, controls, and the carousel itself to the target div
    carouselDiv.appendChild(carouselInner);
    carouselDiv.appendChild(carouselPrev);
    carouselDiv.appendChild(carouselNext);
    targetDiv.appendChild(carouselDiv);
    $('#organizationCarousel').carousel();



                // var orgLink = document.createElement('a');
                // orgLink.href = '/organizations/info/' + foundPerson.organization_id;
                // orgLink.textContent = organizationName;
                // sitemapHeader.appendChild(orgLink);
                // sitemapTag.appendChild(sitemapHeader);

                // targetDiv.appendChild(sitemapTag);

                var mapTag = document.createElement('div');
                mapTag.className = 'mail-tag';

                var mapIcon = document.createElement('i');
                mapIcon.className = 'fa fa-map-marker';
                mapIcon.setAttribute('aria-hidden', 'true');
                mapIcon.style.marginTop = '5px';
                mapTag.appendChild(mapIcon);

                var mapHeader = document.createElement('h5');
                mapHeader.style.position = 'relative';
                mapHeader.style.marginLeft = '10px';
                mapHeader.style.paddingRight = '18px';
                mapHeader.textContent = foundPerson.shipping_street || 'Not set the address';
                mapTag.appendChild(mapHeader);

                targetDiv.appendChild(mapTag);

                var addActivityBtn = document.createElement('div');
                addActivityBtn.className = 'normal-btn';
                addActivityBtn.id = 'add_new_activity';
                var addActivitySpan = document.createElement('span');
                addActivitySpan.className = 'btn-caption';
                addActivitySpan.textContent = 'Add activity';
                addActivityBtn.appendChild(addActivitySpan);

                targetDiv.appendChild(addActivityBtn);

            } else {
                // Update content with null
                console.log("Null");
                // Add your logic to update the content with null
                var nameTag = document.createElement('div');
            nameTag.className = 'nameTag';

            var dot = document.createElement('div');
            dot.className = 'dot';
            var span = document.createElement('span');
            span.className = 'white-text';

            var from = "fromAddressName";
            var words = from.split(' ');
            var abbreviated = '';
            for (var i = 0; i < Math.min(words.length, 2); i++) {
                abbreviated += words[i].charAt(0).toUpperCase();
            }

            span.textContent = abbreviated;
            dot.appendChild(span);
            nameTag.appendChild(dot);

            var name = document.createElement('h3');
            name.style = 'position: relative; top: 7px; margin-left: 5px;';
            name.id = 'peopel_email_addressNAme';
            name.textContent = email12;
            nameTag.appendChild(name);

            targetDiv.appendChild(nameTag);

            var mailTag = document.createElement('div');
            mailTag.className = 'mail-tag';

            var envelopeIcon = document.createElement('i');
            envelopeIcon.className = 'fa fa-envelope-o';
            envelopeIcon.setAttribute('aria-hidden', 'true');
            envelopeIcon.style.marginTop = '5px';
            mailTag.appendChild(envelopeIcon);

            var emailHeader = document.createElement('h5');
            emailHeader.style.position = 'relative';
            emailHeader.style.marginLeft = '10px';
            emailHeader.id = 'peopel_email_address';
            emailHeader.textContent = email12;
            mailTag.appendChild(emailHeader);

            targetDiv.appendChild(mailTag);

            var addExistingContactBtn = document.createElement('div');
            addExistingContactBtn.className = 'normal-btn';
            var addExistingContactSpan = document.createElement('span');
            addExistingContactSpan.className = 'btn-caption';
            addExistingContactSpan.textContent = 'Add to existing contact';
            addExistingContactBtn.appendChild(addExistingContactSpan);

            targetDiv.appendChild(addExistingContactBtn);

            var createNewContactBtn = document.createElement('div');
            createNewContactBtn.className = 'normal-btn-green';
            createNewContactBtn.id = 'add_people_from_mail';
            createNewContactBtn.setAttribute('data-mail', email12);
            var createNewContactSpan = document.createElement('span');
            createNewContactSpan.className = 'btn-green-caption';
            createNewContactSpan.textContent = 'Create new contact';
            createNewContactBtn.appendChild(createNewContactSpan);

            targetDiv.appendChild(createNewContactBtn);
            }









        $('#add_people_from_mail').click(function(){
            var emailValue = $(this).data('mail');
            $('#people_email').val(emailValue);
            $('#email_people_create_modal').modal('show');
        });

        // Set the first item as active when the carousel is loaded
        $('#organizationCarousel .carousel-item').first().addClass('active');
        $('#add_new_activity').on('click', function(){
            $.ajax({
                url:"{{ url('activities/get_organizations') }}",
                method:'GET',
                dataType:'json',
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data){
                    var organizations = data;

                    var start_date = moment().format('L');
                    var start_time = moment().format('LT');
                    var due_date = moment().format('L');

                    var today_day = moment().format('dddd, MMMM Do');
                    var today_date = moment().format('L');
                    $('#selected_day').html(today_day);
                    $('#selected_date').val(today_date);

                    var today_date = today_date.replace(/\//g, '-');
                    getActivitiesByDate(today_date);

                    $('#activity_subject').val('');
                    $('#activity_note').val('');
                    $('#start_date').val(start_date);
                    $('#start_time').val(start_time);
                    $('#due_date').val(due_date);
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

                },
                complete: function () {
                    $('#activity_modal_new').modal('show');
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        });



    }


        $(window).on('beforeunload', function() {
            $(".se-pre-con").fadeIn('slow');
            $('#emailSearchClear').hide();
        });
        $(window).on('load', function() {
            $(".se-pre-con").fadeOut('slow');
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
            $(".carousel-inner > .item:first").addClass("active");
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

        $("#btnNext").click(function() {
            var currentPg = document.getElementById('txtPgNo').value;
            var nextPage = parseInt(currentPg) + 1;

            document.getElementById('txtPgNo').value = nextPage;
            document.getElementById("formGetEmails").submit();
        });


        </script>
    <script>
        feather.replace();
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
        </script>
    <script src="{{ asset('email-assets') }}/app-assets/vendors/js/vendors.min.js"></script>
    <script src="{{ asset('assets/js/components/moment/moment.min.js') }}"></script>
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

    <!--Datepicker-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <!--Timepicker-->
    <script src="{{ asset('argon') }}/js/plugins/mdtimepicker.js"></script>

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
        })
        </script>
    <script>
        function getOrderDetails()
        {
            console.log("changed");
            $("#orderLinkDealName").text("Order "+$("#order_id_info option:selected").text());
        }

        $("#addDealToEmail").click(function(){
            $.ajax({
                url: "{{ url('email/add/deal') }}",
                type: "post",
                data:{
                    "_token": "{{ csrf_token() }}",
                    emailIdentification: "<?php echo $emailIdentification; ?>",
                    orderID: document.getElementById("order_id_info").value
                },
                dataType: 'json',
                success: function (response) {
                    if(response[0] == "Done Save")
                    {
                        alert("Deal Connected");
                    }

                }
            });
        });
        </script>

<script>
    $('body').on('change', '#activity_organization_id', function() {
            var organization_id = $(this).val();

            if (organization_id) {
                $.ajax({
                    url:"{{ url('activities/get_orders_people_by_organiation') }}/"+organization_id,
                    method:'GET',
                    dataType:'json',
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (data){
                        console.log(data[1]);
                        var orders = data[0];
                        var people = data[1];

                        var order_options = '<option value="">Select an Order</option>';
                        for (let i = 0; i < orders.length; i++) {
                            order_options += '<option value="'+orders[i].id+'">'+orders[i].order_no+'</option>';
                        }
                        $('#activity_order_id').html(order_options);

                        var contact_options = '<option value="">Select a Contact Person</option>';
                        for (let i = 0; i < people.length; i++) {
                            var contacts = people[i].contacts[0];

                            if (contacts.last_name) {
                            var last_name = contacts.last_name;
                            } else {
                                var last_name = '';
                            }

                            contact_options += '<option value="'+contacts.id+'">'+contacts.first_name+' '+last_name+'</option>';
                        }
                        $('#activity_contact_id').html(contact_options);

                        if (activity_order_id == 0) {
                            $('#activity_order_id').val('').trigger('change');
                        } else {
                            console.log(activity_order_id);
                            $('#activity_order_id').val(activity_order_id).trigger('change');
                        }

                        console.log(activity_contact_id);
                        if (activity_contact_id == 0) {
                            $('#activity_contact_id').val('').trigger('change');
                        } else {
                            $('#activity_contact_id').val(activity_contact_id).trigger('change');
                        }
                    },
                    complete: function () {
                        activity_order_id = 0;
                        activity_contact_id = 0;
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            }

        });
    $(document).ready(function() {

        $('#organization_link').click(function() {
            $('#organization_edit_modal').modal('show');
        });
    });
    $("#link_organization").click(function(){
        $.ajax({
            url: "{{url('email/link_organization')}}",
            type: "post",
            dataType: "json",
            data:{
                "_token": "{{ csrf_token() }}",
                messageNo: $("#organization_messageNo").val(),
                sender: $("#organization_mail_sender").val(),
                type: $("#organization_mail_type").val(),
                uId: $("#organization_mail_uid").val(),
                subject: $("#organization_mail_subject").val(),
                date: $("#organization_mail_date").val(),
                organizationId: $("#link_organization_id").val()
            },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (response) {
                console.log(response);
                if(response[0] == "success") {
                    // $("#linked_organization_name").html(response[2])
                    $("#linked_organization_name").html( `<a href="{{ url('organizations/info') }}/`+ response[1] +`">`+ response[2] +`</a>`);
                    Swal.fire(
                        'Done!',
                            'Organization Linked Successfully!',
                            'success'
                            )
                            location.reload();
                        } else {
                            Swal.fire(
                                'Error!',
                                'Something Went Wrong!',
                                'warning'
                                )
                            }

                            $('#organization_edit_modal').modal('hide');
                        },
                        complete: function () {
                            $(".se-pre-con").fadeOut('slow');
                        }
                    });
                });

                $("#add_organization").click(function(){
                    if($("#organization_name").val() == ''){
                        Swal.fire(
                            'Error!',
                            'Please Enter Organization Name!',
                            'warning'
                            );
                            return;
                        }

                        if($("#user_id_org").val() == ''){
                            Swal.fire(
                                'Error!',
                    'Please Select Sales Rep!',
                    'warning'
                    );
                    return;
                }

                $.ajax({
                    url: "{{url('email/add_organization')}}",
                    type: "post",
                    dataType: "json",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        messageNo: $("#organization_messageNo").val(),
                        sender: $("#organization_mail_sender").val(),
                        type: $("#organization_mail_type").val(),
                        uId: $("#organization_mail_uid").val(),
                        subject: $("#organization_mail_subject").val(),
                        date: $("#organization_mail_date").val(),
                        organization_name: $("#organization_name").val(),
                        website: $("#website").val(),
                        organization_email: $("#organization_email").val(),
                        sport: $("#sport").val(),
                        user_id_org: $("#user_id_org").val(),
                        size_of_club: $("#size_of_club").val(),
                        colors: $("#colors").val(),
                        sales_tax: $("#sales_tax").val(),
                        sales_tax_active: $("#sales_tax_active").val(),
                        shipping_street: $("#shipping_street").val(),
                        shipping_city: $("#shipping_city").val(),
                        shipping_state: $("#shipping_state").val(),
                        shipping_postal_code: $("#shipping_postal_code").val(),
                        shipping_country: $("#shipping_country").val(),
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (response) {
                    if(response[0] == "success") {
                        $("#linked_organization_name").html( `<a href="{{ url('organizations/info') }}/`+ response[1] +`">`+ response[2] +`</a>`);
                        Swal.fire(
                            'Done!',
                            'Organization Linked Successfully!',
                            'success'
                            )
                        } else {
                            Swal.fire(
                                'Error!',
                                'Something Went Wrong!',
                                'warning'
                                )
                            }

                            $('#organization_create_modal').modal('hide');
                        },
                        complete: function () {
                            $(".se-pre-con").fadeOut('slow');
                            location.reload();
                        }
                    });
                });



    </script>

<script type="text/javascript">
        function getEditorContents() {

            document.getElementById('composeForm').action = "{{ route('sendemail') }}";

            document.getElementById("composeForm").submit();
        }
        $("#btnSaveDraft").click(function() {
            document.getElementById('composeForm').action = "savedraft";

            document.getElementById("composeForm").submit();
        });

        $("#btnReplyBottom").click(function() {
            $(".replyBtn").click();
        });
        $("#btnForwardBottom").click(function() {
            $(".fowardBtn").click();
        });
        $('#add_people_from_mail').click(function(){
            var emailValue = $(this).data('mail');
            $('#people_email').val(emailValue);
            $('#email_people_create_modal').modal('show');
        });
        $('#add_organization12').click(function(){
            $('#customer_id').val('');
            $('#organization_create_modal').modal('show');
        });

        $('.select2-add-remove-people').select2({
            dropdownParent: $('#add_remove_contacts_modal')
        });

        $("#fileBtn").click(function() {
            $("#file").click();
        });

        function minMaxToggle(){
            $(".min-max-toggle").toggle(300);
        }




        $(document).ready(function() {
            var now_date = moment().format('L');
            duDatepicker('.date-picker', 'setValue', now_date, { format: 'dd mmm, yyyy' });

            $('.select2-organization').select2();

            document.getElementById("txtGetEmailType").value = localStorage.getItem("txtGetEmailType");
            document.getElementById("txtHeaderEmailType").value = localStorage.getItem("txtHeaderEmailType");
            document.getElementById('txtPgNo').value = localStorage.getItem("txtPgNo");
            document.getElementById('serachText').value = localStorage.getItem("serachText");
            document.getElementById('serachOnOff').value = localStorage.getItem("serachOnOff");


            if (localStorage.getItem("sentMail") == "Done") {
                alert("Email Sent ");
                localStorage.setItem("sentMail", "Not Done");
            } else if (localStorage.getItem("draftMail") == "Done") {
                alert("Draft Saved");
                localStorage.setItem("draftMail", "Not Done");
                document.getElementById("formGetEmails").submit();
            }

            $("#editorTextArea").Editor({
                'block_quote':false,
                'undo':false,
                'redo':false,
                'unlink':false,
                'insert_img':true,
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
        });




        $(".fowardBtn").click(function() {
            $('#email-to').find('option').remove();
            $('#emailCC').find('option').remove();
            $('#emailBCC').find('option').remove();
            var headOne = "-------- Original Message --------\n";
            var SubjectMail = "Subject: " + document.getElementById("txtMailSubject").value + "\n";
            var date = "Date: " + "<?php echo $date; ?>" + "\n";
            var fromAddress = "From: " + document.getElementById("txtMailRepyTo").value + "\n";
            var toAddress = "To: ";

            var allToAddresses = <?php if (isset($allToAddresses)) {
                echo json_encode($allToAddresses);
            } else {
                echo 'null';
            } ?>;
            if (allToAddresses.length > 0) {
                for (var address = 0; address < allToAddresses.length; address++) {
                    if (toAddress == "To: ") {
                        toAddress = toAddress + allToAddresses[address]['mail'];
                    } else {
                        toAddress = toAddress + ", " + allToAddresses[address]['mail'];
                    }

                }
            }
            document.getElementById("emailSubject").value = SubjectMail;
            var message_string = document.getElementById("txtBodyMessage").value;
            message_string = message_string.replace(/<br *\/?>/gi, '\n');

            document.getElementById("editorTextArea").value = headOne + SubjectMail + date + fromAddress +
            toAddress + message_string;
            console.log(document.getElementById("editorTextArea").value);
            $('#editorTextArea + .Editor-container .Editor-editor').html(headOne + SubjectMail + date + fromAddress +
            toAddress + message_string);

            var attachArea = "";
            $("#txtAttachmentPaths option").each(function() {
                //alert($(this).val());
                $(this).prop("selected", true);
                attachArea = attachArea +
                "<div style='width: 100%;font-size: 16px;padding: 8px;' class='alert alert-primary' role='alert'><a href='" +
                    $(this).val() + "' download>" + $(this).attr('data-originalName') +
                    "</a><button onclick=\"myFunction(this)\" style='font-size: 10px; padding: 5px; float: right;' type='button' data-removeFile='" +
                    $(this).val() + "' class='btn btn-primary btn-sm'>X</button></div>";
                });

                document.getElementById("showAttachmentArea").innerHTML = attachArea;

                $(this).attr('data-toggle', 'modal');
                $(this).attr('data-target', '#compose-mail');
                $(this).attr('data-backdrop', 'false');




            });

            $("#composeBtn").click(function() {
                var darfTview = "<?php if (isset($draftMessageNo)) {
                    unset($draftMessageNo);
                    echo 'UnSet';
                } else {
                    echo 'UnSet';
                } ?>";


            $('#email-to').find('option').remove();
            $('#emailCC').find('option').remove();
            $('#emailBCC').find('option').remove();
            $('#txtAttachmentPaths').find('option').remove();

            document.getElementById("emailSubject").value = "";
            document.getElementById("editorTextArea").value = "";

        });

        /*$(".btn-remove").click(function(){

            var removeSelectValue =  $(this).attr("data-removeFile");
            $(".ct option[value="+removeSelectValue+"]").remove();
        });*/

        function myFunction(identifier) {
            //alert($(identifier).attr("data-removeFile"));
            var removeSelectValue = $(identifier).attr("data-removeFile");
            $("#txtAttachmentPaths option[value='" + removeSelectValue + "']").prop("selected", false);

            var attachArea = "";
            $("#txtAttachmentPaths option:selected").each(function() {
                //alert($(this).val());
                attachArea = attachArea +
                "<div style='width: 100%;font-size: 16px;padding: 8px;' class='alert alert-primary' role='alert'><a href='" +
                    $(this).val() + "' download>" + $(this).attr('data-originalName') +
                    "</a><button onclick=\"myFunction(this)\" style='font-size: 10px; padding: 5px; float: right;' type='button' data-removeFile='" +
                    $(this).val() + "' class='btn btn-primary btn-sm'>X</button></div>";
                });
                var files = $("#file").prop("files");
                var names = $.map(files, function(val) {
                    return val.name;
                });
                //file
                for (i = 0; i < names.length; i++) {
                    attachArea = attachArea +
                    "<div style='width: 100%;font-size: 16px;padding: 8px;' class='alert alert-primary' role='alert'><a >" +
                        names[i] +
                        "</a><button onclick=\"myFunctionRemoveInput(this)\" style='font-size: 10px; padding: 5px; float: right;' type='button' class='btn btn-primary btn-sm'>X</button></div>";
                    }

                    document.getElementById("showAttachmentArea").innerHTML = attachArea;
                }

                function getSelectedFiles(filesSelected) {
                    var files = $(filesSelected).prop("files");
                    var names = $.map(files, function(val) {
                        return val.name;
                    });
                    var attachArea = "";
                    $("#txtAttachmentPaths option:selected").each(function() {
                        //alert($(this).val());
                        attachArea = attachArea +
                        "<div style='width: 100%;font-size: 16px;padding: 8px;' class='alert alert-primary' role='alert'><a href='" +
                            $(this).val() + "' download>" + $(this).attr('data-originalName') +
                            "</a><button onclick=\"myFunction(this)\" style='font-size: 10px; padding: 5px; float: right;' type='button' data-removeFile='" +
                            $(this).val() + "' class='btn btn-primary btn-sm'>X</button></div>";
                        });

                        for (i = 0; i < names.length; i++) {
                            attachArea = attachArea +
                            "<div style='width: 100%;font-size: 16px;padding: 8px;' class='alert alert-primary' role='alert'><a >" +
                    names[i] +
                    "</a><button onclick=\"myFunctionRemoveInput(this)\" style='font-size: 10px; padding: 5px; float: right;' type='button' class='btn btn-primary btn-sm'>X</button></div>";
                }
                document.getElementById("showAttachmentArea").innerHTML = attachArea;


            }

            function myFunctionRemoveInput(filesInputs) {
                $(filesInputs).parent().remove();

            }






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




        $(".backBtn").click(function() {
            document.getElementById("formGetEmails").submit();
        });

        $(".deleteMail").click(function() {

            document.getElementById("txtGetDeleteEmailType").value = document.getElementById("mailboxtype")
            .value;
            document.getElementById("txtHeaderDeleteEmailType").value = document.getElementById(
                "txtHeaderEmailType").value;
                document.getElementById("txtDeletePgNo").value = document.getElementById('txtPgNo').value;
                document.getElementById("serachDeleteText").value = document.getElementById('serachText').value;
                document.getElementById("serachDeleteOnOff").value = "OFF";

                document.getElementById("deletemail").submit();
            });

            $(".restore").click(function() {

                document.getElementById("txtGetRestoreEmailType").value = document.getElementById("txtGetEmailType")
                .value;
                document.getElementById("txtHeaderRestoreEmailType").value = document.getElementById(
                    "txtHeaderEmailType").value;
                    document.getElementById("txtRestorePgNo").value = document.getElementById('txtPgNo').value;
                    document.getElementById("serachRestoreText").value = document.getElementById('serachText').value;
                    document.getElementById("serachRestoreOnOff").value = document.getElementById('serachOnOff').value;
                    document.getElementById("restoremail").submit();
                });

                $(".mailMoveActions").click(function() {

                    document.getElementById("txtGetMoveEmailType").value = document.getElementById("txtGetEmailType").value;
                    document.getElementById("txtHeaderMoveEmailType").value = document.getElementById("txtHeaderEmailType").value;
                    document.getElementById("txtMovePgNo").value = document.getElementById('txtPgNo').value;
                    document.getElementById("serachMoveText").value = document.getElementById('serachText').value;
                    document.getElementById("serachMoveOnOff").value = document.getElementById('serachOnOff').value;



                    document.getElementById("txtMailMovePath").value = $(this).attr("data-pathMove");
                    document.getElementById("moveMail").submit();

        });

        </script>
        @endsection

