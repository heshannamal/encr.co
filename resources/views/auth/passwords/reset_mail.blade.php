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
                        @if(session()->has('sent_success'))
                            <div class="text-center text-dark mb-2">
                                <span class="alert-inner--text">{{session('sent_success')}}</span>
                                <br>
                                <span class="alert-inner--text">{{'Email: '. session('sent_email')}}</span>
                                <br>
                                <span class="text-danger">Note: Password reset link will be expired after <b>one hour</b> from now</span>
                            </div>
                            <script>
                                setTimeout(function(){ window.location = "{{ route('forgot-password') }}";}, 60*60*1000);
                            </script>
                        @else
                            @if(session()->has('password_error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <span class="alert-inner--text">{{session('password_error')}}</span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        <form role="form" method="POST" action="{{ route('forgot-password.reset-mail') }}">
                            @csrf

                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" type="email" name="email" value="{{ old('email') }}" value="admin@argon.com" required id='email'>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-danger my-4">{{ __('Sent Reset Link') }}</button>
                            </div>
                        </form>
                        @endif
                        <div class="justify-content-between">
                            
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-6">
                        <a href="{{ route('login') }}" class="text-light"><i class="fas fa-arrow-left"></i>&nbsp;Back to login</a>
                    </div>
                    <div class="col-6 text-right">
                        @if(session()->has('sent_success'))
                        <a href="{{ route('forgot-password') }}" class="float-right" class="text-light">Request again</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.onload = function() {
            document.getElementById("email").focus();
        }
    </script>

@endsection
