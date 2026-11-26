@extends('layouts.login', ['class' => 'bg-default encore-admin-login'])

@push('css')
    <link rel="stylesheet" href="{{ asset('css/encore/login.css') }}">
@endpush

@section('content')
    <div class="container encore-login-page" id="login_container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card encore-login-card shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        @if (session('status'))
                            <div class="alert alert-success mt-3" role="status">{{ session('status') }}</div>
                        @endif

                        <div class="text-center mb-4">
                            <img class="encore-login-logo" src="{{ asset('argon/img/encore/logo_dark.png') }}" alt="Encore Custom">
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="email" class="sr-only">{{ __('Email') }}</label>
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83" aria-hidden="true"></i></span>
                                    </div>
                                    <input class="form-control @error('email') is-invalid @enderror"
                                        id="email" type="email" name="email" value="{{ old('email') }}"
                                        placeholder="{{ __('Email') }}" autocomplete="username" autofocus required
                                        @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                                </div>
                                <x-encore.field-error name="email" />
                            </div>

                            <div class="form-group">
                                <label for="password" class="sr-only">{{ __('Password') }}</label>
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open" aria-hidden="true"></i></span>
                                    </div>
                                    <input class="form-control @error('password') is-invalid @enderror"
                                        id="password" type="password" name="password"
                                        placeholder="{{ __('Password') }}" autocomplete="current-password" required
                                        @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
                                    <div class="input-group-append">
                                        <x-encore.password-toggle target="password" />
                                    </div>
                                </div>
                                <x-encore.field-error name="password" />
                                <a href="{{ route('forgot-password') }}" class="text-muted encore-forgot-link">
                                    <small>{{ __('Forgot password?') }}</small>
                                </a>
                            </div>

                            <div class="custom-control custom-control-alternative custom-checkbox">
                                <input class="custom-control-input" name="remember" id="customCheckLogin" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customCheckLogin">
                                    <span class="text-danger">{{ __('Remember me') }}</span>
                                </label>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-danger my-4">{{ __('Sign in') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/encore/password.js') }}" defer></script>
@endpush
