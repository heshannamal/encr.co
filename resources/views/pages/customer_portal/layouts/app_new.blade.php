<!doctype html>
<html lang="en" data-bs-theme="semi-dark">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>EncoreCustom</title>

  <!--favicon-->
  <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">

  <!-- loader -->
  <link href="{{ asset('assets/customer_portal/assets/css/center-radar.css') }}" rel="stylesheet">
  <script src="{{ asset('assets/customer_portal/assets/js/pace.min.js') }}"></script>

  <!-- plugins -->
  <link href="{{ asset('assets/customer_portal/assets/plugins/perfectscrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/customer_portal/assets/plugins/metismenu/metisMenu.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/customer_portal/assets/plugins/metismenu/mm-vertical.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/customer_portal/assets/plugins/simplebar/css/simplebar.css') }}">


  <!-- bootstrap css -->
  <link href="{{ asset('assets/customer_portal/assets/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">

  <!-- main css -->
  <link href="{{ asset('assets/customer_portal/assets/css/bootstrap-extended.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/customer_portal/sass/main.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/customer_portal/sass/dark-theme.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/customer_portal/sass/blue-theme.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/customer_portal/sass/semi-dark.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/customer_portal/sass/bordered-theme.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/customer_portal/sass/responsive.css') }}" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.all.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
<style>
    .heaader_bar_name {
    font-size: clamp(0.75rem,4vw,1.5rem); /* desktop default */
}

/* @media (max-width: 700px) {
    .heaader_bar_name {
        font-size: 0.7rem; /* mobile */
    /* }
} */
/* 1. Hide the default Pace.js progress bar */
.pace {
    display: none !important;
}

/* 2. Hide your custom loader by default */
.encore-loader {
    position: fixed;
    inset: 0;
    background: rgba(158, 155, 155, 0.8); /* Adjusted for better visibility */
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 99999;

    /* Smooth Transition Setup */
    transition: opacity 0.6s ease-out, visibility 0.6s ease-out;
    opacity: 0;
    visibility: hidden;
}

/* Show loader when Pace is running */
body.pace-running .encore-loader {
    opacity: 1;
    visibility: visible;
}

/* Keep loader visible during the transition to 'done' */
body.pace-done .encore-loader {
    opacity: 0;
    visibility: hidden;
}

/* Rest of your existing animations (pulse, bounce, etc.) */
.loader-logo { width: 450px; margin-bottom: 18px; animation: pulse 1.8s infinite ease-in-out; }
.dot-loader { display: flex; gap: 8px; }
.dot-loader span { width: 8px; height: 8px; background: #ff2d2d; border-radius: 50%; animation: bounce 1.4s infinite ease-in-out both; }
.dot-loader span:nth-child(1) { animation-delay: -0.32s; }
.dot-loader span:nth-child(2) { animation-delay: -0.16s; }

@keyframes bounce { 0%, 80%, 100% { transform: scale(0); opacity: 0.3; } 40% { transform: scale(1); opacity: 1; } }
@keyframes pulse { 0% { transform: scale(1); opacity: 0.8; } 50% { transform: scale(1.05); opacity: 1; } 100% { transform: scale(1); opacity: 0.8; } }
@media (max-width: 768px) { .loader-logo { width: 250px; } }

:root {
    --as-primary: #212529;
    --as-primary-dark: #212529;
    --as-bg-soft: #f9fafb;
}

/* Floating button */
.as-chat-trigger {
    position: fixed;
    right: 20px;
    bottom: 20px;
    width: 58px;
    height: 58px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--as-primary), var(--as-primary-dark));
    color: #fff;
    font-size: 24px;
    display: grid;
    place-items: center;
    cursor: pointer;
    box-shadow: 0 18px 35px rgba(0, 0, 0, 0.45);
    z-index: 9999;
}

/* Panel */
.as-chat-panel {
    position: fixed;
    right: 20px;
    bottom: 90px;
    width: 360px;
    height: 520px;
    background: #fff;
    border-radius: 22px;
    box-shadow: 0 30px 70px rgba(0,0,0,.25);
    display: flex;
    flex-direction: column;
    overflow: hidden;

    opacity: 0;
    transform: translateY(40px);
    pointer-events: none;
    transition: all .35s ease;
    z-index: 9999;
}

.as-chat-panel.as-open {
    opacity: 1;
    transform: translateY(0);
    pointer-events: auto;
}

/* Header */
.as-chat-top {
    padding: 16px;
    background: linear-gradient(135deg, var(--as-primary), var(--as-primary-dark));
    color: #fff;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.as-chat-top h6 {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: #fff;
}

.as-chat-top small {
    opacity: .85;
}

.as-chat-top span {
    font-size: 22px;
    cursor: pointer;
}

/* Messages */
.as-chat-messages {
    flex: 1;
    padding: 14px;
    background: var(--as-bg-soft);
    overflow-y: auto;
}

/* Message bubbles */
.as-msg {
    max-width: 78%;
    padding: 10px 14px;
    margin-bottom: 10px;
    border-radius: 16px;
    font-size: 14px;
    line-height: 1.45;
}

.as-msg-support {
    background: #e5e7eb;
    color: #111;
    border-bottom-left-radius: 4px;
}

.as-msg-user {
    background: var(--as-primary);
    color: #fff;
    margin-left: auto;
    border-bottom-right-radius: 4px;
}
.message-content,
.as-msg,
.as-msg-user,
.as-msg-agent {
    overflow-wrap: anywhere;
    word-break: break-word;
}

.message-content a,
.as-msg a {
    word-break: break-all;
    overflow-wrap: anywhere;
    white-space: normal;
}

/* Input area */
.as-chat-input-area {
    padding: 10px;
    background: #fff;
    display: flex;
    gap: 8px;
    border-top: 1px solid #e5e7eb;
}

.as-chat-input-area input {
    flex: 1;
    border: none;
    background: #f1f5f9;
    padding: 10px 14px;
    border-radius: 999px;
    outline: none;
}

.as-chat-input-area button {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    border: none;
    background: var(--as-primary);
    color: #fff;
    cursor: pointer;
}
/* Attachment button */
.as-attach-btn {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: #e5e7eb;
    display: grid;
    place-items: center;
    cursor: pointer;
    font-size: 18px;
    flex-shrink: 0;
}

.as-attach-btn:hover {
    background: #d1d5db;
}

/* File preview bubble */
.as-msg-file {
    background: #eef2ff;
    color: #111;
    border-radius: 14px;
    padding: 10px;
    font-size: 13px;
}

.as-msg-file span {
    display: block;
    font-weight: 600;
    margin-bottom: 4px;
}
/* ================================
   Encore Custom Button Colors
   Use with Bootstrap: class="btn ec-btn-primary-800"
================================ */


/* Primary Buttons */
.ec-btn-primary-800 {
    background-color: #39AB92 !important;
    border-color: #39AB92 !important;
    color: #fff !important;
}

.ec-btn-primary-600 {
    background-color: #47D6B6 !important;
    border-color: #47D6B6 !important;
    color: #fff !important;
}

.ec-btn-primary-400 {
    background-color: #B5EFE2 !important;
    border-color: #B5EFE2 !important;
    color: #333 !important;
}

.ec-btn-primary-300 {
    background-color: #DAF7F0 !important;
    border-color: #DAF7F0 !important;
    color: #333 !important;
}

.ec-btn-primary-200 {
    background-color: #E6F2F0 !important;
    border-color: #E6F2F0 !important;
    color: #333 !important;
}

.ec-btn-primary-100 {
    background-color: #E9F7F4 !important;
    border-color: #E9F7F4 !important;
    color: #333 !important;
}


/* Neutral / Gray Buttons */
.ec-btn-neutral-900 {
    background-color: #020202 !important;
    border-color: #020202 !important;
    color: #fff !important;
}

.ec-btn-neutral-800 {
    background-color: #4E4C4C !important;
    border-color: #4E4C4C !important;
    color: #fff !important;
}

.ec-btn-neutral-700 {
    background-color: #717070 !important;
    border-color: #717070 !important;
    color: #fff !important;
}

.ec-btn-neutral-600 {
    background-color: #818181 !important;
    border-color: #818181 !important;
    color: #fff !important;
}

.ec-btn-neutral-500 {
    background-color: #B3B3B3 !important;
    border-color: #B3B3B3 !important;
    color: #fff !important;
}

.ec-btn-neutral-400 {
    background-color: #CAC9C9 !important;
    border-color: #CAC9C9 !important;
    color: #333 !important;
}

.ec-btn-neutral-300 {
    background-color: #DEDEDE !important;
    border-color: #DEDEDE !important;
    color: #333 !important;
}

.ec-btn-neutral-200 {
    background-color: #F5F5F5 !important;
    border-color: #F5F5F5 !important;
    color: #333 !important;
}

.ec-btn-neutral-100 {
    background-color: #F8F8F8 !important;
    border-color: #F8F8F8 !important;
    color: #333 !important;
}

.ec-btn-neutral-white {
    background-color: #FFFFFF !important;
    border-color: #DEDEDE !important;
    color: #333 !important;
}


/* Success Buttons */
.ec-btn-success-dark {
    background-color: #55A630 !important;
    border-color: #55A630 !important;
    color: #fff !important;
}

.ec-btn-success-light {
    background-color: #E0F9D4 !important;
    border-color: #E0F9D4 !important;
    color: #333 !important;
}


/* Danger / Negative Buttons */
.ec-btn-danger-500 {
    background-color: #BB0000 !important;
    border-color: #BB0000 !important;
    color: #fff !important;
}

.ec-btn-danger-400 {
    background-color: #D00000 !important;
    border-color: #D00000 !important;
    color: #fff !important;
}

.ec-btn-danger-300 {
    background-color: #EC9999 !important;
    border-color: #EC9999 !important;
    color: #fff !important;
}

.ec-btn-danger-200 {
    background-color: #FAE6E6 !important;
    border-color: #FAE6E6 !important;
    color: #333 !important;
}

.ec-btn-danger-100 {
    background-color: #FFEDEE !important;
    border-color: #FFEDEE !important;
    color: #333 !important;
}


/* Warning Buttons */
.ec-btn-warning-dark {
    background-color: #FFB916 !important;
    border-color: #FFB916 !important;
    color: #333 !important;
}

.ec-btn-warning-light {
    background-color: #FFF6CC !important;
    border-color: #FFF6CC !important;
    color: #333 !important;
}


/* Info Buttons */
.ec-btn-info-dark {
    background-color: #023E8A !important;
    border-color: #023E8A !important;
    color: #fff !important;
}

.ec-btn-info-light {
    background-color: #D4E6FD !important;
    border-color: #D4E6FD !important;
    color: #333 !important;
}


/* Common hover/focus */
[class*="ec-btn-"]:hover,
[class*="ec-btn-"]:focus {
    opacity: 0.85;
    box-shadow: none !important;
}


/* Disabled */
[class*="ec-btn-"]:disabled,
[class*="ec-btn-"].disabled {
    opacity: 0.55;
    cursor: not-allowed;
}


/* Mobile full-screen */
@media (max-width: 576px) {
    .as-chat-panel {
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        border-radius: 0;
    }
}
.as-temp-sending {
    opacity: 0.85;
}

.as-bubble-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 6px;
    margin-top: 4px;
}

.as-send-spinner {
    width: 13px;
    height: 13px;
    border: 2px solid rgba(255,255,255,0.45);
    border-top-color: #ffffff;
    border-radius: 50%;
    display: inline-block;
    animation: asSpin 0.7s linear infinite;
}

@keyframes asSpin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

@media (max-width: 768px) {

    input:focus,
    textarea:focus,
    select:focus,
    .form-control:focus,
    .invoice-inputs:focus,
    .select2-selection__rendered:focus,
    .select2-selection:focus,
    .select2-search__field:focus {
        font-size: 16px !important;
    }

}

@media (max-width: 768px) {

    .select2-container .select2-search__field {
        font-size: 16px !important;
    }

}

</style>
</head>

<body>
    <audio id="newMessageSound" preload="auto">
        <source src="{{ asset('assets/customer_portal/assets/sms.mp3') }}" type="audio/mpeg">
    </audio>
@include('pages.customer_portal.partials.support-chat')
@include('pages.customer_portal.partials.order_info_notice_modal')




    <div class="encore-loader">
        <img src="{{ asset('assets/customer_portal/assets/images/logo_dark.png') }}" alt="Encore Loader" class="loader-logo">

        <div class="dot-loader">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

  <div class="app layout-wrapper">
    @yield('content')
  </div>

  <!-- bootstrap js -->
  <script src="{{ asset('assets/customer_portal/assets/js/bootstrap.bundle.min.js') }}"></script>

  <!-- plugins -->
  <script src="{{ asset('assets/customer_portal/assets/js/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/customer_portal/assets/plugins/perfectscrollbar/js/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('assets/customer_portal/assets/plugins/metismenu/metisMenu.min.js') }}"></script>
  <script src="{{ asset('assets/customer_portal/assets/plugins/apexchart/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/customer_portal/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/customer_portal/assets/plugins/peity/jquery.peity.min.js') }}"></script>

</body>
</html>

