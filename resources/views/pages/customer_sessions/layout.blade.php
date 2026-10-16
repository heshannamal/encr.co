<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Encore Fitness')</title>
    @include('pages.customer_sessions.partials.styles')
    @stack('styles')
</head>
<body>
<div class="ec-app">
    @include('pages.customer_sessions.partials.sidebar')
    <main class="ec-main">
        @include('pages.customer_sessions.partials.topbar')
        <div class="ec-page">
            @include('pages.customer_sessions.partials.alerts')
            @yield('content')
        </div>
        <footer class="ec-footer">Copyright © {{ date('Y') }}. All rights reserved.</footer>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('customerSidebarToggle').addEventListener('click', function(){
    document.getElementById('customerSidebar').classList.toggle('open');
});
document.addEventListener('click', function(event){
    if (window.innerWidth > 991) return;
    var sidebar = document.getElementById('customerSidebar');
    if (!sidebar.contains(event.target) && !event.target.closest('#customerSidebarToggle')) sidebar.classList.remove('open');
});
</script>
@stack('scripts')
</body>
</html>
