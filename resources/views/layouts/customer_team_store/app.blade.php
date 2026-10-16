<!doctype html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{$store->store_name}}</title>

        <link rel="icon" type="image/x-icon" href="{{ asset($teamStore->primary_logo) }}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Extra details for Live View on GitHub Pages -->

        <!-- Icons -->
        <link href="{{ asset('argon/vendor/nucleo/css/nucleo.css') }}" rel="stylesheet">
        <script src="https://kit.fontawesome.com/4e5c8d5a83.js" crossorigin="anonymous"></script>

        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon/css/argon.css?v=1.0.0') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('argon/css/custom_css.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('argon/css/timeline.css') }}" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="{{ asset('argon/vendor/jquery/dist/jquery.min.js') }}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

        <!-- DataTables css -->
        <link rel="stylesheet" href="{{ asset('argon/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('argon/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('argon/css/colReorder.dataTables.min.css') }}">

        <!--Datepicker-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

        <!--Timepicker-->
        <link rel="stylesheet" href="{{ asset('argon/css/mdtimepicker.css') }}">
        <script src="{{ asset('argon/js/plugins/mdtimepicker.js') }}"></script>

        <link rel="stylesheet" href="{{ asset('argon/css/duDatepicker.css') }}">
        <script src="{{ asset('argon/js/plugins/duDatepicker.js') }}"></script>
        <script src="{{ asset('argon/js/plugins/moment.js') }}"></script>

        {{-- PDf Plugins --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
        <script src="{{ asset('argon/js/plugins/html2canvas.js') }}"></script>
        <script src="{{ asset('argon/js/plugins/html2pdf.bundle.min.js') }}"></script>

        {{-- Rich Text Editor --}}
        <link rel="stylesheet" href="{{ asset('argon/css/editor.css') }}" type="text/css" />
        <script src="{{ asset('argon/js/plugins/editor.js') }}"></script>

        {{-- JsZip --}}
        <script src="{{ asset('argon/js/plugins/jszip.js') }}" type="text/javascript"></script>


        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://kit.fontawesome.com/4e5c8d5a83.js" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <style>
            .body_class {
                /* background-color: rgb(239, 239, 239); */
            }
        </style>
    </head>

    <body class="body_class {{ $teamStore->theme == 1 ? 'store-dark-theme' : 'store-light-theme' }}" style=" background-size: cover;">

        <style>
            .body {
                font-family: 'Open Sans', 'sans-serif' !important;
            }
        </style>

        {{-- <img style="width: 26px;" src="{{ asset(') }}/argon/img/icons/customer_portal/background.jpg" alt="image"> --}}

        @yield('content')

    </body>

</html>
