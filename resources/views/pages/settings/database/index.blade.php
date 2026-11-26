@extends('layouts.app', ['activePage' => 'Database_Settings', 'titlePage' => __('Database Settings')])

@section('content')
<style>
    .card{
        border: none;
        border-radius: 0rem;
    }
    .font-color{
        color: #979797;
    }
    .border-buttom{
        border-bottom: 1px solid rgba(0, 0, 0, .1);
    }
    .mini-card{
        border: 1px solid rgba(43, 43, 43, 0.548);
        margin: 5px;
        padding: 15px;
        cursor: pointer;
    }
    .activecard{
        border-color:#418d47;
        background-color: #28b63456;
        border: 2px solid;
    }
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

    /* =====================================================================
       Database Settings - scoped additions 
       ===================================================================== */

    /* Mobile-only elements are hidden on desktop */
    .db-settings .cfg-mobile-only { display: none; }

    @media (max-width: 767.98px) {
        /* Toggle desktop-only / mobile-only pieces */
        .db-settings .cfg-desktop-only { display: none; }
        .db-settings .cfg-mobile-only  { display: inline; }

        /* ---------- Page spacing ----------
           mb-5 (3rem, !important) left a big empty gap above the footer.
           Use a small bottom space on mobile instead. */
        .db-settings {
            margin-bottom: 0 !important;
            padding-bottom: 20px;
        }

        /* ---------- Page header (Back to home) ----------
           The layout already shows the page title in its own bar,
           so only the back link is added here. */
        .db-settings .cfg-mobile-header {
            display: block;
            padding-top: 4px;
        }
        .db-settings .cfg-back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #3b3b3b;
        }
        .db-settings .cfg-back-link svg {
            width: 9px;
            height: 9px;
            flex-shrink: 0;
        }
        .db-settings .cfg-page-title {
            margin: 12px 0 0;
            font-size: 18px;
            font-weight: 700;
            line-height: 1.3;
            color: #1d1d1f;
        }

        /* ---------- Outer column ----------
           The column sits directly in .container-fluid (no .row), so on mobile
           it would get double side padding. Remove it so the card lines up
           with the header. mt-4 uses !important, so !important is needed. */
        .db-settings .cfg-col {
            margin-top: 12px !important;
            padding-left: 0;
            padding-right: 0;
        }

        /* ---------- Main card ---------- */
        .db-settings .cfg-card {
            padding: 14px;
            background-color: #fff;
            border: 1px solid #ececec;
            border-radius: 10px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .06);
        }
        /* Bootstrap's m-1 uses !important, so !important is needed here */
        .db-settings .cfg-card > .row {
            margin: 0 !important;
        }
        .db-settings .cfg-card > .row > .col-12 {
            padding: 0;
        }

        /* "Select environment" label */
        .db-settings .cfg-section-label {
            margin: 0 0 12px;
            padding-bottom: 10px;
            font-size: 15px;
            font-weight: 700;
            line-height: 1.35;
            color: #1d1d1f;
            border-bottom: 1px solid #e6e6e6;
        }

        /* ---------- Environment option cards (stacked, full width) ---------- */
        .db-settings .cfg-card .mini-card {
            position: relative;
            flex: 0 0 100%;
            max-width: 100%;
            margin: 0 0 10px;
            padding: 12px 14px;
            background-color: #fff;
            border: 1px solid #dedede;
            border-radius: 8px;
            -webkit-tap-highlight-color: transparent;
            transition: border-color .15s ease, background-color .15s ease;
        }
        .db-settings .cfg-card .mini-card:last-child {
            margin-bottom: 0;
        }
        .db-settings .cfg-card .mini-card:active {
            background-color: #f6f6f6;
        }
        .db-settings .cfg-card .mini-card h2 {
            margin: 0 0 4px;
            padding-right: 64px; /* room for the "In use" badge */
            font-size: 14px;
            font-weight: 700;
            line-height: 1.35;
            color: #1d1d1f;
        }
        .db-settings .cfg-card .mini-card p {
            margin: 0;
            font-size: 12px;
            font-weight: 400;
            line-height: 1.45;
            color: #4a4a4a;
            word-break: break-word;
        }

        /* Active (currently used) environment */
        .db-settings .cfg-card .mini-card.activecard {
            background-color: #eefbf8;
            border: 1px solid #45d4b8;
            box-shadow: 0 0 0 1px #45d4b8 inset;
        }
        .db-settings .cfg-card .mini-card.activecard::after {
            content: 'In use';
            position: absolute;
            top: 12px;
            right: 12px;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
            line-height: 1.4;
            white-space: nowrap;
            color: #2e9e4a;
            background-color: #dff7e4;
        }

        /* ---------- Popups (SweetAlert2) ----------
           The script adds the "cfg-swal-popup" class to the popup on mobile only,
           after it opens. Inner parts use SweetAlert2's own class names. */
        .swal2-popup.cfg-swal-popup {
            width: calc(100% - 40px);
            max-width: 360px;
            padding: 0 0 18px;
            border-radius: 12px;
        }
        .swal2-popup.cfg-swal-popup .swal2-title {
            display: block;
            align-self: stretch;
            margin: 0 16px;
            padding: 16px 28px 12px 0;
            text-align: left;
            font-size: 16px;
            font-weight: 700;
            color: #1d1d1f;
            border-bottom: 1px solid #e6e6e6;
        }
        .swal2-popup.cfg-swal-popup .swal2-close {
            font-size: 24px;
            color: #333;
            box-shadow: none;
        }
        /* Message text ("Do you want to switch...") - both old and new class names */
        .swal2-popup.cfg-swal-popup .swal2-html-container,
        .swal2-popup.cfg-swal-popup .swal2-content {
            margin: 14px 16px 0;
            padding: 0;
            text-align: left;
            font-size: 13px;
            line-height: 1.5;
            color: #4a4a4a;
        }
        .swal2-popup.cfg-swal-popup .swal2-input-label {
            justify-content: flex-start;
            margin: 14px 16px 0;
            font-size: 12.5px;
            color: #333;
        }
        .swal2-popup.cfg-swal-popup .swal2-input {
            box-sizing: border-box;
            width: calc(100% - 32px);
            max-width: none;
            height: 38px;
            margin: 8px 16px 0;
            padding: 0 12px;
            font-size: 14px;
            border: 1px solid #d9d9d9;
            border-radius: 6px;
            box-shadow: none;
        }
        .swal2-popup.cfg-swal-popup .swal2-actions {
            box-sizing: border-box;
            justify-content: flex-end;
            width: calc(100% - 32px);
            margin: 18px 16px 0;
            padding: 0;
            gap: 10px;
        }
        .swal2-popup.cfg-swal-popup .swal2-styled.swal2-confirm,
        .swal2-popup.cfg-swal-popup .swal2-styled.swal2-cancel {
            margin: 0;
            min-width: 84px;
            padding: 8px 18px;
            font-size: 13.5px;
            font-weight: 600;
            color: #fff;
            border-radius: 6px;
            box-shadow: none;
        }
        .swal2-popup.cfg-swal-popup .swal2-styled.swal2-confirm { background-color: #45d4b8; }
        .swal2-popup.cfg-swal-popup .swal2-styled.swal2-cancel  { background-color: #b5b5b5; }
        .swal2-popup.cfg-swal-popup .swal2-styled.swal2-confirm:focus,
        .swal2-popup.cfg-swal-popup .swal2-styled.swal2-cancel:focus {
            box-shadow: none;
        }
    }
</style>
<div class="container-fluid mb-5 content-position db-settings" >
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Database Settings</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    {{-- Mobile-only page header (hidden on desktop) --}}
    <div class="cfg-mobile-only cfg-mobile-header">
        {{-- <a href="{{ route('home') }}" class="cfg-back-link" title="Back to home">
            <svg viewBox="0 0 10 10" aria-hidden="true"><path d="M6.5 1.5 3 5l3.5 3.5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            BACK TO HOME
        </a> --}}
    </div>

    <div class="col-md-12 mt-4 cfg-col">
        <div class="card cfg-card">
            <div class="row m-1">
                <div class="col-12">

                    <p class="font-color border-buttom cfg-section-label"><span class="cfg-desktop-only">Select enviroment</span><span class="cfg-mobile-only">Select environment</span></p>

                </div>
            </div>

            <div class="row m-1">
                {{-- <div class="col-12"> --}}

                    <div class=" col-3.5 mini-card cardchange {{ $databasename === 'testing' ? 'activecard' : '' }}" data-name="testing">
                        <h2>Testing Database</h2>
                        <p>Database name : {{$test_databasename}}</p>
                    </div>
                    <div class=" col-3.5 mini-card cardchange {{ $databasename === 'live' ? 'activecard' : '' }}" data-name="live">
                        <h2>Live Database</h2>
                        <p>Database name : {{$live_databasename}}</p>
                    </div>
                    <div class=" col-3.5 mini-card cardchange {{ $databasename === 'development' ? 'activecard' : '' }}" data-name="development">
                        <h2>Development Database</h2>
                        <p>Database name : {{$dev_databasename}}</p>
                    </div>

                {{-- </div> --}}
            </div>
        </div>
    </div>
</div>
<script>
// Mobile only: when the page content is shorter than the screen, stretch the
// content area so the footer sits at the very bottom (no empty space under it).
// On desktop this does nothing.
(function () {
    var box = document.querySelector('.db-settings');
    if (!box || !window.matchMedia) {
        return;
    }
    var mq = window.matchMedia('(max-width: 767.98px)');

    function pageContentBottom() {
        var bottom = 0;
        var children = document.body.children;
        for (var i = 0; i < children.length; i++) {
            var el = children[i];
            var style = window.getComputedStyle(el);
            if (style.display === 'none' || style.position === 'fixed' || style.position === 'absolute') {
                continue;
            }
            var rect = el.getBoundingClientRect();
            if (rect.height > 0) {
                bottom = Math.max(bottom, rect.bottom + window.pageYOffset + (parseFloat(style.marginBottom) || 0));
            }
        }
        return bottom;
    }

    function fillScreen() {
        box.style.minHeight = '';
        if (!mq.matches) {
            return;
        }
        var gap = window.innerHeight - pageContentBottom();
        if (gap > 0) {
            box.style.minHeight = Math.ceil(box.offsetHeight + gap) + 'px';
        }
    }

    window.addEventListener('load', fillScreen);
    window.addEventListener('resize', fillScreen);
    fillScreen();
})();

// Mobile only: add the styling class to the popup that just opened.
// Wrapped in try/catch so styling can never stop a popup from working.
function cfgStyleSwalForMobile(isMobile) {
    if (!isMobile) {
        return;
    }
    try {
        var popup = Swal.getPopup();
        if (popup) {
            popup.classList.add('cfg-swal-popup');
        }
    } catch (err) {
        console.warn('Mobile popup styling skipped:', err);
    }
}

$('.cardchange').on('click', function () {
    var database_name = $(this).data('name');
    var current_database = "{{ $databasename }}"; // coming from blade
    var user_id = "{{ auth()->id() }}";

    // Is the screen mobile size?
    var isMobile = !!(window.matchMedia && window.matchMedia('(max-width: 767.98px)').matches);

    var isLiveChange =
        (current_database === 'live' || database_name === 'live') ;

    if (isLiveChange) {
        // Same options as the original popup (desktop stays exactly the same)
        var passwordOptions = {
            title: 'Confirm Password',
            input: 'password',
            inputLabel: 'Enter your password to switch database',
            inputAttributes: {
                autocapitalize: 'off',
                autocomplete: 'current-password'
            },
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            showLoaderOnConfirm: true,
            preConfirm: (password) => {
                return $.ajax({
                    url: "{{ route('configuration.database.password.change') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        database_name: database_name,
                        password: password
                    }
                }).then(response => {

                        return response.message;

                })
            },
            allowOutsideClick: () => !Swal.isLoading()
        };

        // Mobile only: "x" close button, Cancel on the left, Confirm on the right
        if (isMobile) {
            passwordOptions.showCloseButton = true;
            passwordOptions.reverseButtons = true;
        }

        var passwordPopup = Swal.fire(passwordOptions);
        cfgStyleSwalForMobile(isMobile);

        passwordPopup.then(result => {
            console.log(result);

            if (result.value == "Database changed successfully.") {
                Swal.fire('Success', result.value, 'success').then(() => {
                    location.reload();
                });
            }else if(result.dismiss){
 location.reload();
            }else{
                Swal.fire(
                        'password Wrong!',
                        'Fail to change Database!',
                        'error'
                    ).then(() => {
                        location.reload();
                    });
            }
        });
    }
    else {
        // Same options as the original popup (desktop stays exactly the same)
        var confirmOptions = {
            title: 'Are you sure?',
            text: "Do you want to switch to the '" + database_name + "' database?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        };

        // Mobile only: match the app's popup style.
        // The button colours are removed here because SweetAlert2 sets them as
        // inline styles, which would override the mobile teal/grey buttons.
        // The big warning icon is hidden so the left-aligned layout stays clean.
        if (isMobile) {
            delete confirmOptions.confirmButtonColor;
            delete confirmOptions.cancelButtonColor;
            delete confirmOptions.icon;
            confirmOptions.showCloseButton = true;
            confirmOptions.reverseButtons = true;
        }

        var confirmPopup = Swal.fire(confirmOptions);
        cfgStyleSwalForMobile(isMobile);

        confirmPopup.then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{ url('configuration/database/change') }}/" + database_name,
                    method: 'GET',
                    dataType: 'json',
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (data) {
                        Swal.fire('Success', data, 'success').then(() => {
                            location.reload();
                        });
                    },
                    complete: function () {
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            }
        });
    }
});


</script>
@endsection