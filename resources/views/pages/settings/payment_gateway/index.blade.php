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
</style>
<div class="container-fluid mb-5 content-position" >
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Payment Gateway Settings</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection
    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="row m-1">
                <div class="col-12">

                    <p class="font-color border-buttom">Select enviroment</p>

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
    $(document).ready(function () {
        $('.cardchange').click(function () {
            let mode = $(this).data('name');

            Swal.fire({
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
            }).then((result) => {
                console.log(result);

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
