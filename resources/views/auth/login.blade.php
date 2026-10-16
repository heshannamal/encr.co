@extends('layouts.login', ['class' => 'bg-default'])

@section('content')
<style>
    body {
        height: 100vh;
    }
    .main-content footer {
        display: none;
    }
    .bg-secondary {
        background-color: #f7fafca8 !important;
    }
    #togglePassword {
        cursor: pointer;

    }
    #login_container {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    footer {
        position: fixed;
        bottom: 0;
        width: 100%;
    }
    .copyright {
        text-align: center !important;
    }
</style>

    {{-- @include('layouts.headers.guest') --}}

    <div class="container" id="login_container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        @if (session('status'))
                            <div class="alert alert-success mt-3">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="text-center text-muted mb-4">
                            <img src="{{ asset('argon') }}/img/encore/logo_dark.png" width="350px" />
                        </div>
                        <form role="form" method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" type="email" name="email" value="{{ old('email') }}" value="admin@argon.com" required id="email">
                                </div>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" placeholder="{{ __('Password') }}" type="password"  required>
                                     <div class="input-group-postpend">
                                        <span class="input-group-text" style="height: 100%;">
                                            <i class="fas fa-eye-slash" id="togglePassword"></i>
                                        </span>
                                    </div>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                <a href="{{ route('forgot-password') }}" class="text-muted" style="float: inline-end;">
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

    <script>
        $(document).ready(function() {
            $('#togglePassword').click( function() {
                var x = document.getElementById("password");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
                $(this).toggleClass('fa-eye fa-eye-slash');
            });
        });

        window.onload = function() {
            document.getElementById("email").focus();
        }
    </script>
@endsection
