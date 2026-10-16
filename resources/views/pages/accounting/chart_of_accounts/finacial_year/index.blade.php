@extends('layouts.app', ['activePage' => 'financial_year', 'titlePage' => __('Financial Year')])

@section('content')
<style>
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
@php
    $currentYear = now()->year;
@endphp
<div style="margin: 1rem">
    <div class="se-pre-con"></div>
    <div class="card">
        <div class="card-body">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <form action="" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6" style="font-weight: 600;font-size:1.2rem">
                                    Set Finacial Year
                                </div>
                                <div class="col-md-6 text-right" style="font-weight: 600;font-size:1.2rem">
                                    Current Year - {{ $currentYear }}
                                </div>
                                <input type="hidden" name="current_year" value="{{ $currentYear }}">
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="start_date">Start Date</label>
                                    <input type="text" class="form-control" id="start_date" name="start_date" value="{{ isset($date_element) ? $date_element->start_date : '' }}" required autocomplete="off">
                                </div>
                                <div class="col-md-3">
                                    <label for="end_date">End Date</label>
                                    <input type="text" class="form-control" id="end_date"value="{{ isset($date_element) ? $date_element->end_date : '' }}" name="end_date" required autocomplete="off">
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <button type="button" class="btn btn-primary finacial-year-submit" style="background-color: #91db91;border: none;border-radius: 0rem;">Set Financial Year</button>
                                    {{-- <button type="button" class="btn btn-primary ml-2" style="background-color: #91c7db;border: none;border-radius: 0rem;">Start Financial Year</button> --}}
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label for="timezone">Timezone</label>
                                    <select class="form-control select2" id="timezone" name="timezone" style="border: 1px solid #b3b3b3 !important;border-radius: 0rem !important;">
                                        <option value="-08:00" selected>(US & Canada) - California (-08:00)</option>
                                        <option value="+05:30">Sri Lanka (SL +05:30)</option>
                                        <option value="-05:00">Colombia - Bogota (-05:00)</option>
                                        <option value="+07:00">Indonesia - Jakarta (+07:00)</option>
                                        <option value="+08:00">Pakistan - Makassar (+08:00)</option>
                                        <option value="+08:00">China (+08:00)</option>
                                        <option value="+08:00">Philippines (+08:00)</option>
                                        <option value="-03:00">Brazil - São Paulo (-03:00)</option>
                                        <option value="+07:00">Thailand - Bangkok (+07:00)</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $(document).ready(function () {
        $('#start_date').datepicker({
            dateFormat: 'mm/dd/yy',
            changeMonth: true,
            changeYear: true,
            onSelect: function(selectedDate) {
                $(".se-pre-con").fadeIn('slow');
                var startDate = $(this).datepicker('getDate');

                var endDate = new Date(startDate);
                endDate.setFullYear(startDate.getFullYear() + 1);
                endDate.setDate(startDate.getDate() - 1);

                $('#end_date').datepicker('setDate', endDate);
                $(".se-pre-con").fadeOut('slow');
            }
        });

        $('#end_date').datepicker({
            dateFormat: 'mm/dd/yy',
            changeMonth: true,
            changeYear: true,
            onSelect: function(selectedDate) {
                $(".se-pre-con").fadeIn('slow');
                var endDate = $(this).datepicker('getDate');

                var startDate = new Date(endDate);
                startDate.setFullYear(endDate.getFullYear() - 1);
                startDate.setDate(endDate.getDate() + 1);

                $('#start_date').datepicker('setDate', startDate);
                $(".se-pre-con").fadeOut('slow');
            }
        });


        $('#start_date').on('change', function() {
            $(".se-pre-con").fadeIn('slow');
            var startDate = $(this).datepicker('getDate');
            var endDate = new Date(startDate);
            endDate.setFullYear(startDate.getFullYear() + 1);
            endDate.setDate(startDate.getDate() - 1);
            $('#end_date').datepicker('setDate', endDate);
            $(".se-pre-con").fadeOut('slow');
        });

        $('#end_date').on('change', function() {
            $(".se-pre-con").fadeIn('slow');
            var endDate = $(this).datepicker('getDate');
            var startDate = new Date(endDate);
            startDate.setFullYear(endDate.getFullYear() - 1);
            startDate.setDate(endDate.getDate() + 1);
            $('#start_date').datepicker('setDate', startDate);
            $(".se-pre-con").fadeOut('slow');
        });

        $('.finacial-year-submit').on('click', function () {
            $(".se-pre-con").fadeIn('slow');
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();
            var timezone = $('#timezone').val();

            if (!startDate || !endDate) {
                return;
            }

            $.ajax({
                url: '{{ route('chart_of_accounts.save_finacial_year') }}',
                type: 'POST',
                data: {
                    start_date: startDate,
                    end_date: endDate,
                    timezone: timezone,
                    current_year: '{{ $currentYear }}',
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    console.log(response);
                    location.reload();
                },
                error: function (xhr) {
                    alert('An error occurred: ' + xhr.responseText);
                }
            });
        });
    });
</script>
@endsection

