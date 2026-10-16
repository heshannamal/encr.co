<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Encore Custom</title>
        <!-- Favicon -->
        <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Extra details for Live View on GitHub Pages -->

        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <!-- <script src="https://kit.fontawesome.com/9fc2607ab9.js" crossorigin="anonymous"></script> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        <link type="text/css" href="{{ asset('argon') }}/css/custom_css.css" rel="stylesheet">
        <link type="text/css" href="{{ asset('argon') }}/css/timeline.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script>
            // Polyfill for deprecated/removed jQuery fn.andSelf (removed in jQuery 3.0)
            if (typeof jQuery !== 'undefined' && !jQuery.fn.andSelf) {
                jQuery.fn.andSelf = jQuery.fn.addBack;
            }
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

        <!-- DataTables css -->
        <link rel="stylesheet" href="{{ asset('argon') }}/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ asset('argon') }}/css/responsive.dataTables.min.css">
        <link rel="stylesheet" href="{{ asset('argon') }}/css/colReorder.dataTables.min.css">

        <!--Datepicker-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

        <!--Timepicker-->
        <link rel="stylesheet" href="{{ asset('argon') }}/css/mdtimepicker.css">
        <script src="{{ asset('argon') }}/js/plugins/mdtimepicker.js"></script>

        <link rel="stylesheet" href="{{ asset('argon') }}/css/duDatepicker.css">
        <script src="{{ asset('argon') }}/js/plugins/duDatepicker.js"></script>
        <script src="{{ asset('argon') }}/js/plugins/moment.js"></script>

        {{-- PDf Plugins --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
        <script src="{{ asset('argon') }}/js/plugins/html2canvas.js"></script>
        <script src="{{ asset('argon') }}/js/plugins/html2pdf.bundle.min.js"></script>

        {{-- Rich Text Editor --}}
        <link rel="stylesheet" href="{{ asset('argon') }}/css/editor.css" type="text/css" />
        <script src="{{ asset('argon') }}/js/plugins/editor.js"></script>

        {{-- JsZip --}}
        <script src="{{ asset('argon') }}/js/plugins/jszip.js" type="text/javascript"></script>
    </head>

    <body class="{{ $class ?? '' }}">
        <style>
            .body {
                font-family: 'Open Sans', 'sans-serif' !important;
            }
            @media (max-width: 768px) {

                input,
                textarea,
                select {
                    font-size: 16px !important;
                }

                .form-control,
                .invoice-inputs,
                .select2-selection__rendered,
                .select2-selection {
                    font-size: 16px !important;
                }
                .select2-container .select2-search__field {
                    font-size: 16px !important;
                }
                .form-control,
                .invoice-inputs,
                textarea,
                .select2-container--default .select2-selection--single,
                .select2-container--default .select2-selection--multiple,
                .select2-search__field {
                    font-size: 16px !important;
                }

            }
        </style>
        <div id="buffering_icon" style="display: none;">
            <img src="{{ asset('argon') }}/img/icons/buffering_icon.gif" />
        </div>

        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @include('layouts.navbars.sidebar')
        @endauth

        <div class="main-content" style="background-color: #fafafa">
            @include('layouts.navbars.navbar')

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-inner--text">{{session('success')}}</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="alert-inner--text">{{session('error')}}</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @include('layouts.upload_modal')

            @yield('content')
            @include('layouts.footers.auth')
        </div>


        <button type="button" id="mobileScrollDownBtn" class="mobile-scroll-down-btn" title="Scroll to bottom">
            <i class="fas fa-chevron-down"></i>
        </button>
        @guest()
            @include('layouts.footers.guest')
        @endguest

        <script>
            $(document).ready(function(){
                $('div.alert').delay(5000).slideUp(300);
            });
            $(document).ready(function() {
                let hoverTimeout;
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
                    }
                );
            });
        </script>



        <script>
            $(document).ready(function () {

                const scrollBtn = $('#mobileScrollDownBtn');

                scrollBtn.on('click', function () {

                    $('html, body').animate({
                        scrollTop: $(document).height()
                    }, 700);

                });

                $(window).on('scroll', function () {

                    const scrollTop = $(window).scrollTop();
                    const windowHeight = $(window).height();
                    const documentHeight = $(document).height();

                    if (scrollTop + windowHeight >= documentHeight - 80) {
                        scrollBtn.addClass('hide-scroll-btn');
                    } else {
                        scrollBtn.removeClass('hide-scroll-btn');
                    }

                });

            });

            function copyToClipboard(text, btnElement) {
                var $btn = null;

                if (btnElement && (btnElement instanceof Element || btnElement.jquery)) {
                    $btn = $(btnElement);
                } else if (text && (text instanceof Element || text.nodeType || text.jquery)) {
                    $btn = $(text);
                    text = null;
                } else if (window.event && window.event.target) {
                    $btn = $(window.event.target).closest('.copy-to-clipboard-btn, #copySampleTrackingLink, button');
                }

                var linkToCopy = '';

                if (typeof text === 'string') {
                    var trimmed = text.trim();
                    if (trimmed && trimmed !== '{tracking_link}') {
                        linkToCopy = trimmed;
                    }
                }

                if (!linkToCopy && $btn && $btn.length) {
                    linkToCopy = ($btn.attr('data-url') || $btn.attr('data-link') || $btn.data('url') || $btn.data('link') || '').toString().trim();

                    if (!linkToCopy || linkToCopy === '{tracking_link}') {
                        var $nearbyLink = $btn.closest('div').find('a');
                        if ($nearbyLink.length) {
                            var href = ($nearbyLink.attr('href') || '').trim();
                            var textContent = ($nearbyLink.text() || '').trim();
                            if (href && href !== '#' && !href.startsWith('javascript:') && href !== '{tracking_link}') {
                                linkToCopy = href;
                            } else if (textContent && textContent !== '{tracking_link}') {
                                linkToCopy = textContent;
                            }
                        }
                    }
                }

                if (!linkToCopy || linkToCopy === '{tracking_link}') {
                    linkToCopy = ($('#sample_tracking_link').val() || '').trim();
                }

                if (!linkToCopy || linkToCopy === '{tracking_link}') {
                    if (typeof showSampleAlert === 'function') {
                        showSampleAlert('Tracking link is empty.', 'error');
                    } else if (typeof swal === 'function') {
                        swal('Warning', 'Tracking link is empty.', 'warning');
                    } else if (typeof Swal !== 'undefined' && Swal.fire) {
                        Swal.fire({ icon: 'warning', title: 'Warning', text: 'Tracking link is empty.' });
                    }
                    return;
                }

                var originalHtml = '';
                if ($btn && $btn.length) {
                    originalHtml = $btn.data('original-html') || $btn.html();
                    if (!$btn.data('original-html')) {
                        $btn.data('original-html', originalHtml);
                    }
                }

                function doCopy(textVal) {
                    if (navigator.clipboard && window.isSecureContext) {
                        return navigator.clipboard.writeText(textVal);
                    } else {
                        return new Promise(function (resolve, reject) {
                            try {
                                var $temp = $('<textarea>');
                                $temp.css({ position: 'fixed', left: '-9999px', top: '0', opacity: '0' });
                                $('body').append($temp);
                                $temp.val(textVal).select();
                                var successful = document.execCommand('copy');
                                $temp.remove();
                                if (successful) {
                                    resolve();
                                } else {
                                    reject(new Error('Copy failed'));
                                }
                            } catch (err) {
                                reject(err);
                            }
                        });
                    }
                }

                doCopy(linkToCopy).then(function () {
                    if ($btn && $btn.length) {
                        $btn.html('<i class="fa fa-check mr-1"></i> Copied!').addClass('copied');
                        setTimeout(function () {
                            $btn.html(originalHtml).removeClass('copied');
                        }, 2000);
                    }
                }).catch(function (err) {
                    console.error('Failed to copy: ', err);
                    if (typeof showSampleAlert === 'function') {
                        showSampleAlert('Failed to copy tracking link to clipboard.', 'error');
                    } else if (typeof swal === 'function') {
                        swal('Error', 'Failed to copy tracking link to clipboard.', 'error');
                    } else if (typeof Swal !== 'undefined' && Swal.fire) {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to copy tracking link to clipboard.' });
                    }
                });
            }

            window.copyToClipboard = copyToClipboard;

            $(document).on('click', '.copy-to-clipboard-btn, #copySampleTrackingLink', function (e) {
                var $btn = $(this);
                if ($btn.hasClass('copied')) {
                    return;
                }
                copyToClipboard(null, this);
            });
        </script>

        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

        <!-- DataTables js -->
        <script src="{{ asset('argon') }}/js/plugins/jquery.dataTables.min.js"></script>
        <script src="{{ asset('argon') }}/js/plugins/dataTables.bootstrap4.min.js"></script>
        <script src="{{ asset('argon') }}/js/datatables.js"></script>
        <script src="{{ asset('argon') }}/js/plugins/dataTables.responsive.min.js"></script>
        <script src="{{ asset('argon') }}/js/plugins/dataTables.colReorder.min.js"></script>

        @stack('js')

        <!-- Argon JS -->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
        <!--  Plugin for Sweet Alert -->
        <script src="{{ asset('argon') }}/js/plugins/sweetalert2.js"></script>
        <!--  Plugin for Table Export -->
        <script src="{{ asset('argon') }}/js/plugins/tableexport.js"></script>
        <script src="{{ asset('argon') }}/js/plugins/tableExport.min.js"></script>
    </body>
</html>
