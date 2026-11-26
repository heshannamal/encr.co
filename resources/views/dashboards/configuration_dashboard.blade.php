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

    /* =====================================================================
       Configuration Dashboard - scoped additions 
       ===================================================================== */

    /* Desktop: same colours as the previous inline style on the header */
    .config-dashboard .mode_div.cfg-mode-on  { background-color: #ffc7c7; }
    .config-dashboard .mode_div.cfg-mode-off { background-color: #c7ffcc; }

    /* Mobile-only elements are hidden on desktop */
    .config-dashboard .cfg-mobile-only { display: none; }

    @media (max-width: 767.98px) {
        /* Toggle desktop-only / mobile-only pieces */
        .config-dashboard .cfg-desktop-only { display: none; }
        .config-dashboard .cfg-mobile-only  { display: inline; }

        /* ---------- Spacing between cards ----------
           Bootstrap's mt-4 / mt-2 utilities use !important,
           so !important is needed here to override them on mobile only. */
        .config-dashboard .cfg-col  { margin-top: 10px !important; }
        .config-dashboard .cfg-card { margin-top: 0 !important; }

        /* ---------- Card ---------- */
        .config-dashboard .cfg-card {
            background-color: #fff;
            border: 1px solid #ececec;
            border-radius: 10px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .06);
            overflow: hidden;
        }
        .config-dashboard .cfg-card .card-header {
            margin: 0;
            padding: 14px 14px 4px;
            border-bottom: 0;
            background-color: transparent;
            font-size: 15px;
            font-weight: 700;
            line-height: 1.35;
            color: #1d1d1f;
        }
        /* Remove the red/green header background on mobile (badge shows the status instead) */
        .config-dashboard .mode_div.cfg-mode-on,
        .config-dashboard .mode_div.cfg-mode-off {
            background-color: transparent;
        }
        /* Maintenance header: title on the left, badge on the right */
        .config-dashboard .cfg-maintenance-card .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        /* ---------- Mode badge ---------- */
        .config-dashboard .cfg-mode-badge {
            display: inline-block;
            flex-shrink: 0;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
            line-height: 1.4;
            white-space: nowrap;
        }
        .config-dashboard .cfg-badge-off { color: #2e9e4a; background-color: #dff7e4; }
        .config-dashboard .cfg-badge-on  { color: #d64545; background-color: #ffe3e3; }

        /* ---------- Card body ---------- */
        .config-dashboard .cfg-card .card-body {
            padding: 4px 14px 14px;
        }
        .config-dashboard .cfg-card.cfg-card .min-height {
            min-height: 0;
        }
        .config-dashboard .cfg-card .card-title {
            margin-bottom: 8px;
            font-size: 12.5px;
            font-weight: 700;
            line-height: 1.4;
            color: #1d1d1f;
        }
        .config-dashboard .cfg-card .card-text {
            margin-bottom: 12px;
            font-size: 12px;
            font-weight: 400;
            line-height: 1.45;
            color: #4a4a4a;
        }
        .config-dashboard .cfg-maintenance-card .card-text {
            text-align: justify;
        }

        /* ---------- Outline buttons (Change / View) ---------- */
        .config-dashboard .cfg-card .btn-grey-text {
            display: block;
            width: 100%;
            padding: 7px 12px;
            font-size: 12.5px;
            font-weight: 500;
            line-height: 1.5;
            text-transform: capitalize;
            color: #8c8c8c;
            background-color: #fff;
            border: 1px solid #dedede;
            border-radius: 6px;
            box-shadow: none;
            transform: none;
        }
        .config-dashboard .cfg-card .btn-grey-text:hover,
        .config-dashboard .cfg-card .btn-grey-text:focus {
            color: #6b6b6b;
            border-color: #cfcfcf;
            box-shadow: none;
            transform: none;
        }

        /* ---------- On/Off Mode button (teal, full width) ---------- */
        .config-dashboard .btn.cfg-mode-btn,
        .config-dashboard .btn.cfg-mode-btn:hover,
        .config-dashboard .btn.cfg-mode-btn:focus,
        .config-dashboard .btn.cfg-mode-btn:active {
            display: block;
            width: 100%;
            padding: 8px 12px;
            font-size: 13px;
            font-weight: 600;
            line-height: 1.5;
            text-transform: none;
            color: #fff;
            background-color: #45d4b8;
            border-color: #45d4b8;
            border-radius: 6px;
            box-shadow: none;
            transform: none;
        }
        .config-dashboard .btn.cfg-mode-btn:hover,
        .config-dashboard .btn.cfg-mode-btn:active {
            background-color: #3cc4a9;
            border-color: #3cc4a9;
        }

        /* ---------- Confirm Password popup (SweetAlert2) ----------
           The script adds the "cfg-swal-popup" class to the popup on mobile only,
           after it opens. Inner parts use SweetAlert2's own class names, which
           exist in every version, so no customClass option is needed. */
        .swal2-popup.cfg-swal-popup {
            width: calc(100% - 40px);
            max-width: 360px;
            padding: 0 0 18px;
            border-radius: 12px;
        }
        .swal2-popup.cfg-swal-popup .swal2-title {
            display: block;
            align-self: stretch;
            margin: 0 16px;
            padding: 16px 28px 12px 0;
            text-align: left;
            font-size: 16px;
            font-weight: 700;
            color: #1d1d1f;
            border-bottom: 1px solid #e6e6e6;
        }
        .swal2-popup.cfg-swal-popup .swal2-close {
            font-size: 24px;
            color: #333;
            box-shadow: none;
        }
        .swal2-popup.cfg-swal-popup .swal2-input-label {
            justify-content: flex-start;
            margin: 14px 16px 0;
            font-size: 12.5px;
            color: #333;
        }
        .swal2-popup.cfg-swal-popup .swal2-input {
            box-sizing: border-box;
            width: calc(100% - 32px);
            max-width: none;
            height: 38px;
            margin: 8px 16px 0;
            padding: 0 12px;
            font-size: 14px;
            border: 1px solid #d9d9d9;
            border-radius: 6px;
            box-shadow: none;
        }
        .swal2-popup.cfg-swal-popup .swal2-actions {
            box-sizing: border-box;
            justify-content: flex-end;
            width: calc(100% - 32px);
            margin: 18px 16px 0;
            padding: 0;
            gap: 10px;
        }
        .swal2-popup.cfg-swal-popup .swal2-styled.swal2-confirm,
        .swal2-popup.cfg-swal-popup .swal2-styled.swal2-cancel {
            margin: 0;
            min-width: 84px;
            padding: 8px 18px;
            font-size: 13.5px;
            font-weight: 600;
            color: #fff;
            border-radius: 6px;
            box-shadow: none;
        }
        .swal2-popup.cfg-swal-popup .swal2-styled.swal2-confirm { background-color: #45d4b8; }
        .swal2-popup.cfg-swal-popup .swal2-styled.swal2-cancel  { background-color: #b5b5b5; }
        .swal2-popup.cfg-swal-popup .swal2-styled.swal2-confirm:focus,
        .swal2-popup.cfg-swal-popup .swal2-styled.swal2-cancel:focus {
            box-shadow: none;
        }
    }
</style>
<div class="container-fluid mb-5 content-position config-dashboard" >
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Configuration Dashboard</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="row">
        <div class="col-md-12 mt-4 cfg-col">
            <div class="card cfg-card cfg-maintenance-card">
                <h5 class="card-header mode_div {{ $system_status === 'on' ? 'cfg-mode-on' : 'cfg-mode-off' }}">
                    <span>System Maintenance Mode</span> <span class="cfg-desktop-only">{{$system_status}}</span>
                    <span class="cfg-mobile-only cfg-mode-badge {{ $system_status === 'on' ? 'cfg-badge-on' : 'cfg-badge-off' }}">Mode {{ ucfirst($system_status) }}</span>
                </h5>
                <div class="card-body">
                    <h5 class="card-title">To change mode</h5>
                    <p class="card-text">The system status is indicated above: if the header is green, the system is live; if it is red, the system is in maintenance mode. Only an admin can change this setting by entering their password. Click the button below to proceed.</p>
                    <a href="#" id="toggleMaintenanceBtn" data-name="{{$system_status}}" class="btn btn-primary cfg-mode-btn">On/Off Mode</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mt-4 cfg-col">
            <div class="card mt-2 cfg-card">
                <h5 class="card-header">Database<span class="cfg-mobile-only"> Setting</span></h5>
                <div class="card-body min-height">
                    <h5 class="card-title">{{$databasename}}</h5>
                    <p class="card-text">This database is currently in use. Click the 'Change' button to switch.</p>
                    <a href="{{ route('configuration.get_database_data') }}" class="btn btn-grey-text">Change</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4 cfg-col">
            <div class="card mt-2 cfg-card">
                <h5 class="card-header"><span class="cfg-desktop-only">Payment Gatway</span><span class="cfg-mobile-only">Payment Gateway Setting</span></h5>
                <div class="card-body min-height">
                    <h5 class="card-title">{{$currentMode}}</h5>
                    <p class="card-text">This <span class="cfg-desktop-only">gatway</span><span class="cfg-mobile-only">gateway</span> is currently in use. Click the 'Change' button to switch.</p>
                    <a href="{{ route('configuration.get_gateway_data') }}" class="btn btn-grey-text">Change</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4 cfg-col">
            <div class="card mt-2 cfg-card">
                <h5 class="card-header">System Notifications</h5>
                <div class="card-body min-height">
                    <h5 class="card-title">{{$system_notification_Counts->active_count}}/{{$system_notification_Counts->total_count}} system notifications</h5>
                    <p class="card-text">You have {{$system_notification_Counts->active_count}} active notifications out of {{$system_notification_Counts->total_count}}. Click the View button to see more details or make changes.</p>
                    <a href="{{ route('Notification.Settings') }}" class="btn btn-grey-text">View</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4 cfg-col">
            <div class="card mt-2 cfg-card">
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

            // Is the screen mobile size?
            let isMobile = !!(window.matchMedia && window.matchMedia('(max-width: 767.98px)').matches);

            // Same options as the original popup (desktop stays exactly the same)
            let swalOptions = {
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
            };

            // Mobile only: extra options to match the Figma popup
            if (isMobile) {
                swalOptions.inputLabel = 'Please enter password';
                swalOptions.showCloseButton = true;   // the "x" button
                swalOptions.reverseButtons = true;    // Cancel on the left, Confirm on the right
            }

            let swalPromise = Swal.fire(swalOptions);

            // Mobile only: add our styling class to the opened popup.
            // Wrapped in try/catch so styling can never stop the popup from working.
            if (isMobile) {
                try {
                    let popup = Swal.getPopup();
                    if (popup) {
                        popup.classList.add('cfg-swal-popup');
                    }
                } catch (err) {
                    console.warn('Mobile popup styling skipped:', err);
                }
            }

            swalPromise.then((result) => {
                console.log(result);

                // Popup was closed with Cancel / X / outside click: do nothing
                // (same visible result as before, but without a console error)
                if (!result || result.dismiss || !result.value) {
                    return;
                }

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