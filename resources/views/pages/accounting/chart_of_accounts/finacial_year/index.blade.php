@extends('layouts.app', ['activePage' => 'finacial_year', 'titlePage' => __('Financial Year')])

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

    /* =====================================================================
       FINANCIAL YEAR — MOBILE LAYOUT
       ===================================================================== */
    .fy-m-only { display: none; }

    @media (max-width: 767px) {
        /* Layout's generic title strip / desktop top bar: replaced by the page header */
        .main-content #header,
        .main-content .header1,
        .main-content > .navbar-top,
        .main-content > #navbar-main { display: none !important; }

        .fy-page { margin: 0 16px 24px !important; }   /* inline margin: 1rem */

        /* ---------- Page header: back link, "Set Financial Year" + "Current Year - 2026" ---------- */
        .fy-m-header { display: block; margin: 4px 0 16px; }
        .fy-m-back {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin: 6px 0 14px;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 1.2px;
            color: #4b5563;
            text-decoration: none;
        }
        .fy-m-back i { font-size: 11px; }
        .fy-m-title-row {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 12px;
        }
        .fy-m-title {
            margin: 0;
            min-width: 0;
            font-size: 20px;
            font-weight: 700;
            line-height: 1.25;
            color: #111827;
        }
        .fy-m-year {
            flex: 0 0 auto;
            font-size: 15px;
            color: #6b7280;
            white-space: nowrap;
        }

        /* ---------- Form card ---------- */
        .fy-page > .card {
            border: 1px solid #e5e7eb !important;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 2px 10px rgba(17, 24, 39, 0.06);
        }
        .fy-page > .card > .card-body { padding: 14px; }
        .fy-page .card-body > .col-md-12,
        .fy-page .card-body > .col-md-12 > .row > .col-md-12 { padding: 0; }
        .fy-page .card-body > .col-md-12 > .row { margin: 0; }
        /* The desktop title row is shown as the page header above the card */
        .fy-page form > .row.mb-3 { display: none; }

        /* Start | End, then Timezone, then the button */
        .fy-page form > .row:not(.mb-3) {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin: 0;
        }
        .fy-page form > .row:not(.mb-3) > [class*="col-"] {
            min-width: 0;
            margin: 0 !important;                    /* mt-3 */
            padding: 0;
        }
        .fy-page form > .row:not(.mb-3) > .col-md-3 { flex: 1 1 0; max-width: none; }
        .fy-page form > .row:not(.mb-3) > .col-md-4 { order: 3; flex: 0 0 100%; max-width: 100%; }
        .fy-page form > .row:not(.mb-3) > .col-md-6 { order: 4; flex: 0 0 100%; max-width: 100%; }
        /* The field text replaces the labels (design) */
        .fy-page form label { display: none; }
        .fy-page #start_date,
        .fy-page #end_date,
        .fy-page #timezone {
            display: block;
            width: 100%;
            height: 44px;
            padding: 0 32px 0 12px;
            border: 1px solid #e5e7eb;               /* Timezone: its inline border is swapped by JS */
            border-radius: 8px;
            background: #f5f6f7 url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12'%3E%3Cpath d='M2.5 4.5 6 8l3.5-3.5' fill='none' stroke='%23374151' stroke-width='1.6' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") no-repeat right 12px center / 12px 12px;
            box-shadow: none;
            color: #111827;
            font-size: 15px;
            text-overflow: ellipsis;
            -webkit-appearance: none;
            appearance: none;
            outline: none;
        }
        .fy-page #start_date::placeholder,
        .fy-page #end_date::placeholder { color: #9ca3af; }
        .fy-page #start_date:focus,
        .fy-page #end_date:focus,
        .fy-page #timezone:focus { border-color: #47D6B6 !important; }
        .fy-page .finacial-year-submit {
            width: 100%;
            height: 44px;
            margin: 0;
            border-radius: 8px !important;           /* inline 0 */
            background-color: #111827 !important;    /* inline green */
            box-shadow: none;
            color: #fff;
            font-size: 15px;
            font-weight: 500;
            text-transform: none;
            letter-spacing: 0;
        }
    }

    /* Very small phones (320px - 359px) */
    @media (max-width: 359px) {
        .fy-page { margin: 0 12px 24px !important; }
        .fy-m-title { font-size: 18px; }
        .fy-m-year { font-size: 13px; }
        .fy-page form > .row:not(.mb-3) { gap: 10px; }
        .fy-page #start_date,
        .fy-page #end_date,
        .fy-page #timezone { padding-left: 10px; padding-right: 26px; background-position: right 9px center; font-size: 14px; }
    }
</style>
@php
    $currentYear = now()->year;
@endphp
<div class="fy-page" style="margin: 1rem">
    <div class="se-pre-con"></div>

    {{-- Mobile only: page header --}}
    <div class="fy-m-only fy-m-header">
        {{-- <a href="{{ route('home') }}" class="fy-m-back"><i class="fa fa-chevron-left"></i> BACK TO HOME</a> --}}
        <div class="fy-m-title-row">
            <h1 class="fy-m-title">Set Financial Year</h1>
            <span class="fy-m-year">Current Year - {{ $currentYear }}</span>
        </div>
    </div>
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

        /* ---------------- MOBILE-ONLY HELPERS ---------------- */
        try {
            var fyMobileQuery = window.matchMedia('(max-width: 767px)');
            var isFyMobile = function () { return fyMobileQuery.matches; };

            // The design shows the field names inside the empty date boxes
            if (isFyMobile()) {
                $('#start_date').attr('placeholder', 'Start Date');
                $('#end_date').attr('placeholder', 'End Date');
            }

            // The Timezone select has an inline "!important" square border, which CSS
            // cannot override. On phones swap it for the design border; restore it
            // exactly when the screen gets wider (desktop keeps its original look).
            var fyTz = document.getElementById('timezone');
            var fyTzStyle = fyTz ? fyTz.getAttribute('style') : null;
            var applyFyTzStyle = function () {
                if (!fyTz) return;
                if (isFyMobile()) {
                    fyTz.style.setProperty('border', '1px solid #e5e7eb', 'important');
                    fyTz.style.setProperty('border-radius', '8px', 'important');
                } else if (fyTzStyle !== null) {
                    fyTz.setAttribute('style', fyTzStyle);
                }
            };
            applyFyTzStyle();
            if (fyMobileQuery.addEventListener) { fyMobileQuery.addEventListener('change', applyFyTzStyle); }
            else if (fyMobileQuery.addListener) { fyMobileQuery.addListener(applyFyTzStyle); }

            // Place the page header 16px below the layout's fixed mobile bar(s).
            var fixFyHeaderOffset = function () {
                var top = document.querySelector('.fy-m-header');
                var nav = document.getElementById('sidenav-main');
                if (!top) return;
                top.style.marginTop = '';
                if (!isFyMobile() || !nav || getComputedStyle(nav).position !== 'fixed') return;
                var barBottom = nav.getBoundingClientRect().bottom;
                document.querySelectorAll('.main-content nav, .main-content .navbar').forEach(function (el) {
                    var cs = getComputedStyle(el), r = el.getBoundingClientRect();
                    if (cs.position === 'fixed' && cs.display !== 'none' && cs.visibility !== 'hidden' && r.height > 0 && r.top <= 5) {
                        barBottom = Math.max(barBottom, r.bottom);
                    }
                });
                for (var i = 0; i < 5; i++) {     // margins can collapse: adjust, re-measure, correct
                    var diff = Math.round(barBottom + 16 - (top.getBoundingClientRect().top + window.pageYOffset));
                    if (Math.abs(diff) <= 1) break;
                    top.style.marginTop = (parseFloat(getComputedStyle(top).marginTop) + diff) + 'px';
                }
            };
            // Short page: stretch the page area so the layout's footer (world clocks)
            // sits at the bottom of the screen instead of right under the form.
            var fixFyFooter = function () {
                var page = document.querySelector('.fy-page');
                if (!page) return;
                page.style.minHeight = '';
                if (!isFyMobile()) return;
                // .main-content holds the page and the footer; measure where it ends
                // (margins can collapse, so adjust, re-measure and correct)
                var main = page.closest('.main-content') || document.body;
                for (var i = 0; i < 4; i++) {
                    var gap = Math.floor(window.innerHeight - (main.getBoundingClientRect().bottom + window.pageYOffset));
                    if (gap <= 0) break;
                    page.style.minHeight = (page.getBoundingClientRect().height + gap) + 'px';
                }
            };
            var fyLayout = function () { fixFyHeaderOffset(); fixFyFooter(); };
            fyLayout();
            setTimeout(fyLayout, 350);
            setTimeout(fyLayout, 1300);
            window.addEventListener('load', fyLayout);
            var fyResizeTimer;
            window.addEventListener('resize', function () {
                clearTimeout(fyResizeTimer);
                fyResizeTimer = setTimeout(fyLayout, 150);
            });
        } catch (fyErr) {
            if (window.console) console.error('Financial year mobile view:', fyErr);
        }
        /* -------------------------------------------------------------------- */
    });
</script>
@endsection