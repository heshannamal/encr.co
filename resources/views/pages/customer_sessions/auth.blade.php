<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $mode === 'register' ? 'Create Account' : 'Login' }} | Encore Fitness</title>
    @include('pages.customer_sessions.partials.styles')
</head>
<body>
<div class="ec-auth">
    <section class="ec-auth-brand">
        <div class="ec-auth-brand-content">
            <img src="https://encr.co/argon/img/encore/logo_dark.png" class="ec-auth-logo" alt="Encore">
            <div class="ec-auth-tagline">Train Hard.<br><span>Play Harder.</span></div>
            <div class="ec-auth-sport"></div>
        </div>
    </section>
    <section class="ec-auth-panel">
        <div class="ec-auth-card">
            <h1 class="ec-auth-title">{{ $mode === 'register' ? 'Create Account' : 'Welcome Back!' }}</h1>
            <p class="ec-auth-subtitle">{{ $mode === 'register' ? 'Register for a new parent account.' : 'Login to parent account.' }}</p>
            @include('pages.customer_sessions.partials.alerts')

            @if($mode === 'register')
                <form method="POST" action="{{ route('em.customer.register.submit') }}" novalidate>
                    @csrf
                    <input type="hidden" name="redirect" value="{{ $redirect ?? '' }}">
                    <div class="mb-3">
                        <label class="ec-label">First Name <span class="text-danger">*</span></label>
                        <input class="ec-form-control" name="first_name" value="{{ old('first_name') }}" placeholder="Parent First Name">
                        @error('first_name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="ec-label">Last Name <span class="text-danger">*</span></label>
                        <input class="ec-form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Parent Last Name">
                        @error('last_name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="ec-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="ec-form-control" name="email" value="{{ old('email') }}" placeholder="Email">
                        @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="ec-label">Phone</label>
                        <input class="ec-form-control" name="phone" value="{{ old('phone') }}" placeholder="Phone Number">
                    </div>
                    <div class="mb-3">
                        <label class="ec-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="ec-form-control" name="password" placeholder="Enter your password">
                        @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="ec-label">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" class="ec-form-control" name="password_confirmation" placeholder="Confirm your password">
                    </div>
                    <button type="submit" class="ec-btn ec-btn-primary w-100">Register</button>
                </form>
                <div class="ec-divider">or</div>
                <a class="ec-google-btn" href="{{ route('em.customer.google') }}"><i class="fa-brands fa-google text-danger"></i> Sign up with Google</a>
                <p class="text-center small text-muted mt-4 mb-0">Already have an account? <a href="{{ route('em.customer.login') }}" class="fw-bold text-danger text-decoration-none">Login</a></p>
            @else
                <form method="POST" action="{{ route('em.customer.login.submit') }}" novalidate>
                    @csrf
                    <input type="hidden" name="redirect" value="{{ $redirect ?? '' }}">
                    <div class="mb-3">
                        <label class="ec-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="ec-form-control" name="email" value="{{ old('email') }}" placeholder="Enter your email">
                        @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="ec-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="ec-form-control" name="password" placeholder="Enter your password">
                        @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4 small">
                        <label class="d-flex align-items-center gap-2 mb-0"><input type="checkbox"> Remember Me</label>
                        <a href="#" class="text-danger text-decoration-none">Forgot Password?</a>
                    </div>
                    <button type="submit" class="ec-btn ec-btn-primary w-100">Login</button>
                </form>
                <div class="ec-divider">or</div>
                <a class="ec-google-btn" href="{{ route('em.customer.google') }}"><i class="fa-brands fa-google text-danger"></i> Login with Google</a>
                <p class="text-center small text-muted mt-4 mb-0">Don't have an account? <a href="{{ route('em.customer.register') }}" class="fw-bold text-danger text-decoration-none">Register</a></p>
            @endif
        </div>
    </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
