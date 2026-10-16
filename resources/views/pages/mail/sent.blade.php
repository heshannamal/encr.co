@extends('layouts.app', ['activePage' => 'sent', 'titlePage' => __('Sent')])

@section('content')
<style>
    .table td,
    .table th {
        padding: .5rem 1rem;
    }
    .custom-control-label::before,
    .custom-control-label::after {
        top: -0.7rem;
    }
    .view-email {
        text-decoration: none;
        color: #525f7f;
    }
</style>

<div class="container-fluid mb-5">
    <div class="se-pre-con"></div>

    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <h1 class="float-left header-title">Sent</h1>

                    <div class="float-right header-icons"></div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder=" Search">
                        </div>
                    </div>

                    <div class="col-md-6 text-right drive-controls">
                        <button type="button" class="btn btn-secondary btn-sm" title="Support"><i class="far fa-question-circle"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="Settings"><i class="fas fa-cog"></i></button>
                    </div>
                </div>

                {{-- Files card --}}
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <td>
                                    <div class="row">
                                        <div class="custom-control custom-checkbox" style="margin-left: 19px;">
                                            <input type="checkbox" class="custom-control-input" id="select_all">
                                            <label class="custom-control-label" for="select_all"></label>
                                        </div>

                                        <i class="fas fa-redo" style="padding: .3rem;"></i>
                                    </div>
                                </td>
                                <th></th>
                                <th></th>
                                <th></th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <i class="fas fa-grip-vertical" style="padding: .3rem; color: #d2d2d2;"></i>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input select-single" id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1"></label>
                                            </div>

                                            <i class="far fa-star" style="padding: .3rem;"></i>
                                        </div>
                                    </td>
                                    <th><a href="{{ route('mail.view') }}" class="view-email">To: Prasad</a></th>
                                    <td><a href="{{ route('mail.view') }}" class="view-email">Help strengthen the security of your Google Account</a></td>
                                    <td class="text-right">July 14</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <i class="fas fa-grip-vertical" style="padding: .3rem; color: #d2d2d2;"></i>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input select-single" id="customCheck2">
                                                <label class="custom-control-label" for="customCheck2"></label>
                                            </div>

                                            <i class="far fa-star" style="padding: .3rem;"></i>
                                        </div>
                                    </td>
                                    <th><a href="{{ route('mail.view') }}" class="view-email">To: Prasad</a></th>
                                    <td><a href="{{ route('mail.view') }}" class="view-email">Updates to the Twilio Terms of Service, Twilio Acceptable Use Policy, and Twilio Security Overview</a></td>
                                    <td class="text-right">July 14</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <i class="fas fa-grip-vertical" style="padding: .3rem; color: #d2d2d2;"></i>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input select-single" id="customCheck3">
                                                <label class="custom-control-label" for="customCheck3"></label>
                                            </div>

                                            <i class="far fa-star" style="padding: .3rem;"></i>
                                        </div>
                                    </td>
                                    <th><a href="{{ route('mail.view') }}" class="view-email">To: Prasad</a></th>
                                    <td><a href="{{ route('mail.view') }}" class="view-email">Help strengthen the security of your Google Account</a></td>
                                    <td class="text-right">July 14</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <i class="fas fa-grip-vertical" style="padding: .3rem; color: #d2d2d2;"></i>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input select-single" id="customCheck4">
                                                <label class="custom-control-label" for="customCheck4"></label>
                                            </div>

                                            <i class="far fa-star" style="padding: .3rem;"></i>
                                        </div>
                                    </td>
                                    <th><a href="{{ route('mail.view') }}" class="view-email">To: Prasad</a></th>
                                    <td><a href="{{ route('mail.view') }}" class="view-email">Updates to the Twilio Terms of Service, Twilio Acceptable Use Policy, and Twilio Security Overview</a></td>
                                    <td class="text-right">July 14</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $('#select_all').on('change', function(){
        if($(this).is(':checked')) {
            $('.select-single').prop('checked', true);
        } else {
            $('.select-single').prop('checked', false);
        }
    });
</script>
@endsection
