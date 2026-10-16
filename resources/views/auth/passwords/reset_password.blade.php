@extends('layouts.app', ['class' => 'bg-default'])

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
                        <div class="text-center text-muted mb-4">
                            <img src="{{ asset('argon') }}/img/encore/logo_dark.png" width="300px" />
                        </div>
                         @if(session()->has('password_error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <span class="alert-inner--text">{{session('password_error')}}</span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        @if(isset($token) && $token != null && $token != '[]')
                        <form role="form" method="POST" action="{{ route('forgot-password.reset-password-submit') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token??'' }}">
                            <input type="hidden" name="email" value="{{ $email??'' }}">
                            <div class="mb-2"><span>Email: {{ $email??'' }}</span></div>

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
                            </div>

                            <div class="form-group{{ $errors->has('conform_password') ? ' has-danger' : '' }}">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input  onchange="checkPasswordMatch()" class="form-control{{ $errors->has('conform_password') ? ' is-invalid' : '' }}" id="conform_password" name="conform_password" placeholder="{{ __('Conform Password') }}" type="password"  required>
                                    <div class="input-group-postpend">
                                        <span class="input-group-text" style="height: 100%;">
                                            <i class="fas fa-eye-slash" id="toggleConformPassword"></i>
                                        </span>
                                    </div>
                                </div>
                                <div id="conform_password_message" class="text-danger" style="display: none;">
                                    <span>password conform not matched...!</span>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-danger my-4" id="reset">{{ __('Reset Password') }}</button>
                            </div>
                        </form>
                        
                        @else
                            Something went wrong!
                        @endif
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-6">
                        <a href="{{ route('login') }}" class="text-light"><i class="fas fa-arrow-left"></i>&nbsp;Back to login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            checkPasswordMatch();
            $("#password").keyup(checkPasswordMatch);
            $("#conform_password").keyup(checkPasswordMatch);

            function checkPasswordMatch() {
                var password = $("#password").val();
                var confirmPassword = $("#conform_password").val();
                if (password != confirmPassword) {
                    $("#edit_conform_password").addClass("is-invalid");
                    document.getElementById('conform_password_message').style.display = 'block';
                    document.getElementById('reset').disabled = true;

                }else {
                    $("#edit_conform_password").removeClass("is-invalid");
                    document.getElementById('conform_password_message').style.display = 'none';
                    document.getElementById('reset').disabled = false;
                }
            }



        });


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

            $('#toggleConformPassword').click( function() {
                var x = document.getElementById("conform_password");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
                $(this).toggleClass('fa-eye fa-eye-slash');
            });


        });

        window.onload = function() {
            document.getElementById("password").focus();
        }
    </script>
@endsection
