@extends('layouts.app', ['activePage' => 'config_Settings', 'titlePage' => __('Configuration Settings')])

@section('content')
<style>
    .card{
        border: none;
        border-radius: 0.5rem;
        border: 1px solid #e2e2e2;
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

    .min-height{
        min-height: 240px;
    }
    .btn-grey-text {
        outline: unset !important;
        width: 100%;
        padding: 6%;
        color: #B3B3B3;
        border: none;
        font-weight: 700;
        font-size: .7rem;
        cursor: pointer;
        background-color: transparent;
        border: 1px solid #b3b3b3;
    }
</style>
<div class="container-fluid mb-5 content-position" >
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Configuration Dashboard</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection
    <div class="row">
        <div class="col-md-12 mt-4">
            <div class="card ">
                <h5 class="card-header mode_div" style="background-color: {{ $system_status === 'on' ? '#ffc7c7' : '#c7ffcc' }}; ">System Maintenance Mode {{$system_status}}</h5>
                <div class="card-body">
                    <h5 class="card-title">To change mode</h5>
                    <p class="card-text">The system status is indicated above: if the header is green, the system is live; if it is red, the system is in maintenance mode. Only an admin can change this setting by entering their password. Click the button below to proceed.</p>
                    <a href="#" id="toggleMaintenanceBtn" data-name="{{$system_status}}" class="btn btn-primary">On/Off Mode</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mt-4">
            <div class="card mt-2">
                <h5 class="card-header">Database</h5>
                <div class="card-body min-height">
                    <h5 class="card-title">{{$databasename}}</h5>
                    <p class="card-text">This database is currently in use. Click the 'Change' button to switch.</p>
                    <a href="{{ route('configuration.get_database_data') }}" class="btn btn-grey-text">Change</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="card mt-2">
                <h5 class="card-header">Payment Gatway</h5>
                <div class="card-body min-height">
                    <h5 class="card-title">{{$currentMode}}</h5>
                    <p class="card-text">This gatway is currently in use. Click the 'Change' button to switch.</p>
                    <a href="{{ route('configuration.get_gateway_data') }}" class="btn btn-grey-text">Change</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="card mt-2">
                <h5 class="card-header">System Notifications</h5>
                <div class="card-body min-height">
                    <h5 class="card-title">{{$system_notification_Counts->active_count}}/{{$system_notification_Counts->total_count}} system notifications</h5>
                    <p class="card-text">You have {{$system_notification_Counts->active_count}} active notifications out of {{$system_notification_Counts->total_count}}. Click the View button to see more details or make changes.</p>
                    <a href="{{ route('Notification.Settings') }}" class="btn btn-grey-text">View</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="card mt-2">
                <h5 class="card-header">Email Notifications</h5>
                <div class="card-body min-height">
                    <h5 class="card-title">{{$email_notification_Counts->active_count}}/{{$email_notification_Counts->total_count}} email notifications</h5>
                    <p class="card-text">You have {{$email_notification_Counts->active_count}} active notifications out of {{$email_notification_Counts->total_count}}. Click the View button to see more details or make changes.</p>
                    <a href="{{ route('NotificationEmail.Settings') }}" class="btn btn-grey-text">view</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
 $(document).ready(function () {
        $('#toggleMaintenanceBtn').click(function (e) {
        e.preventDefault();
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
                        url: "{{ route('configuration.toggleMaintenance') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            status: mode,
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
                        'System mode changed',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                }else{
                    Swal.fire(
                        'password Wrong!',
                        'Failed to change mode',
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
