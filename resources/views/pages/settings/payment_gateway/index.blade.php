@extends('layouts.app', ['activePage' => 'Payment_Gateway', 'titlePage' => __('Payment Gateway')])

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
        width: 35%;
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
       Payment Gateway - scoped additions 
       ===================================================================== */

    /* Mobile-only elements are hidden on desktop */
    .pg-settings .cfg-mobile-only { display: none; }

    @media (max-width: 767.98px) {
        /* Toggle desktop-only / mobile-only pieces */
        .pg-settings .cfg-desktop-only { display: none; }
        .pg-settings .cfg-mobile-only  { display: inline; }

        /* ---------- Page spacing ----------
           mb-5 (3rem, !important) leaves a big empty gap above the footer.
           Use a small bottom space on mobile instead. */
        .pg-settings {
            margin-bottom: 0 !important;
            padding-bottom: 20px;
        }

        /* ---------- Page header (Back to home) ----------
           The layout already shows the page title in its own bar,
           so only the back link is added here. */
        .pg-settings .cfg-mobile-header {
            display: block;
            padding-top: 4px;
        }
        .pg-settings .cfg-back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #3b3b3b;
        }
        .pg-settings .cfg-back-link svg {
            width: 9px;
            height: 9px;
            flex-shrink: 0;
        }

        /* ---------- Outer column ----------
           The column sits directly in .container-fluid (no .row), so on mobile
           it would get double side padding. mt-4 uses !important. */
        .pg-settings .cfg-col {
            margin-top: 12px !important;
            padding-left: 0;
            padding-right: 0;
        }

        /* ---------- Main card ---------- */
        .pg-settings .cfg-card {
            padding: 14px;
            background-color: #fff;
            border: 1px solid #ececec;
            border-radius: 10px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .06);
        }
        /* Bootstrap's m-1 uses !important, so !important is needed here */
        .pg-settings .cfg-card > .row {
            margin: 0 !important;
        }
        .pg-settings .cfg-card > .row > .col-12 {
            padding: 0;
        }

        /* "Select environment" label */
        .pg-settings .cfg-section-label {
            margin: 0 0 12px;
            padding-bottom: 10px;
            font-size: 15px;
            font-weight: 700;
            line-height: 1.35;
            color: #1d1d1f;
            border-bottom: 1px solid #e6e6e6;
        }

        /* ---------- Mode option cards (stacked, full width) ---------- */
        .pg-settings .cfg-card .mini-card {
            position: relative;
            flex: 0 0 100%;
            width: 100%;
            max-width: 100%;
            margin: 0 0 10px;
            padding: 12px 14px;
            background-color: #fff;
            border: 1px solid #dedede;
            border-radius: 8px;
            -webkit-tap-highlight-color: transparent;
            transition: border-color .15s ease, background-color .15s ease;
        }
        .pg-settings .cfg-card .mini-card:last-child {
            margin-bottom: 0;
        }
        .pg-settings .cfg-card .mini-card:active {
            background-color: #f6f6f6;
        }
        .pg-settings .cfg-card .mini-card h2 {
            margin: 0 0 4px;
            padding-right: 64px; /* room for the "In use" badge */
            font-size: 14px;
            font-weight: 700;
            line-height: 1.35;
            color: #1d1d1f;
        }
        .pg-settings .cfg-card .mini-card p {
            margin: 0;
            font-size: 12px;
            font-weight: 400;
            line-height: 1.45;
            color: #4a4a4a;
            word-break: break-word;
        }
        /* The <br> tags are for the narrow desktop boxes; on mobile let text wrap naturally */
        .pg-settings .cfg-card .mini-card p br {
            display: none;
        }

        /* Active (currently used) mode */
        .pg-settings .cfg-card .mini-card.activecard {
            background-color: #eefbf8;
            border: 1px solid #45d4b8;
            box-shadow: 0 0 0 1px #45d4b8 inset;
        }
        .pg-settings .cfg-card .mini-card.activecard::after {
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
<div class="container-fluid mb-5 content-position pg-settings" >
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Payment Gateway Settings</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    {{-- Mobile-only back link (hidden on desktop) --}}
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

                    <div class=" col-3.5 mini-card cardchange {{ $currentMode === 'sandbox' ? 'activecard' : '' }}" data-name="sandbox">
                        <h2>SandBox</h2>
                        <p>This configuration is for testing payments in<br> the sandbox environment.</p>
                    </div>
                    <div class=" col-3.5 mini-card cardchange {{ $currentMode === 'live' ? 'activecard' : '' }}" data-name="live">
                        <h2>Live</h2>
                        <p>This configuration is for processing <br> real payments in  the live environment.</p>
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
        var box = document.querySelector('.pg-settings');
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

    $(document).ready(function () {
        $('.cardchange').click(function () {
            let mode = $(this).data('name');

            // Is the screen mobile size?
            let isMobile = !!(window.matchMedia && window.matchMedia('(max-width: 767.98px)').matches);

            // Same options as the original popup (desktop stays exactly the same)
            let swalOptions = {
                title: 'Confirm Password',
                input: 'password',
                inputLabel: 'Please enter your password to confirm',
                inputAttributes: {
                    autocapitalize: 'off',
                    autocomplete: 'current-password'
                },
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                showLoaderOnConfirm: true,
                preConfirm: (password) => {
                    return $.ajax({
                        url: "{{ route('configuration.updatePaymentMode') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            payment_mode: mode,
                            password: password
                        }
                    }).then(response => {
                        if (response.success) {
                            return response;
                        } else {
                            throw new Error(response.message || 'Failed to change mode.');
                        }
                    }).catch(error => {
                        // Swal.showValidationMessage(error.message);
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            };

            // Mobile only: "x" close button, Cancel on the left, Confirm on the right
            if (isMobile) {
                swalOptions.showCloseButton = true;
                swalOptions.reverseButtons = true;
            }

            let swalPromise = Swal.fire(swalOptions);

            // Mobile only: add the styling class to the opened popup.
            // Wrapped in try/catch so styling can never stop the popup from working.
            if (isMobile) {
                try {
                    let popup = Swal.getPopup();
                    if (popup) {
                        popup.classList.add('cfg-swal-popup');
                    }
                } catch (err) {
                    console.warn('Mobile popup styling skipped:', err);
                }
            }

            swalPromise.then((result) => {
                console.log(result);

                // Popup was closed with Cancel / X / outside click: do nothing
                // (same visible result as before, but without a console error)
                if (!result || result.dismiss || !result.value) {
                    return;
                }

                if (result.value.success) {
                    Swal.fire(
                        'Switched!',
                        'Payment mode changed to ' + mode.toUpperCase(),
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                }else{
                    Swal.fire(
                        'password Wrong!',
                        'Fail to Payment mode changed to ' + mode.toUpperCase(),
                        'error'
                    ).then(() => {
                        location.reload();
                    });
                }
            });


        });
    });
</script>

@endsection