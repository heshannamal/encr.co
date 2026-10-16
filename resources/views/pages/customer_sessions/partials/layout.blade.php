<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Encore Fitness</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @include('pages.customer_sessions.partials.styles')
    @stack('styles')
</head>
<body>
@include('pages.customer_sessions.partials.header')
@if(session('success'))<div class="em-container pb-0"><div class="alert alert-success">{{ session('success') }}</div></div>@endif
@if(session('error'))<div class="em-container pb-0"><div class="alert alert-danger">{{ session('error') }}</div></div>@endif
@yield('content')
<footer class="em-footer"><div class="em-container"><div class="row"><div class="col-md-4"><strong>Encore Fitness</strong><p class="text-muted mb-0">Book packages and reserve fitness sessions easily.</p></div><div class="col-md-4"><strong>Explore</strong><div><a href="{{ route('em.customer.packages') }}">Packages</a></div></div><div class="col-md-4"><strong>Support</strong><div>info@encr.co</div></div></div></div></footer>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('scripts')
</body>
</html>
