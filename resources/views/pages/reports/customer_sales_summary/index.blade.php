@extends('layouts.app', ['activePage' => 'cu_sales_summary', 'titlePage' => __('Customer Sales Summery')])

@section('content')

<style>
    .content-position {
        padding-left: 15px !important;
        padding-right: 15px !important;
    }
    .print_btn {
        padding-right: 3%;
        padding-left: 2%;
    }
    .table_header_text {
        color: white;
        height: 40px;
    }
    .order_sammary_table {
        padding-top: 5px;
        overflow-x: auto;
        padding-left: 15PX;
        padding-right: 15PX;
        padding-bottom: 15px;
    }
    .production_text {
        padding-left: 10px;
        color: rgb(94, 94, 94);
    }
    .filter_row {
        margin-left: unset;
        padding-left: 8px;
        padding-right: 9px;
        background-color: #F8F8F8;
        border: 1px solid#DEDEDE;
        border-radius: 5px;
        padding-top: 2px;
    }
    .date_selection {
        background-color: transparent;
        padding: unset;
        border: unset;
        color: #47D6B6;
        font-size: 11px;
    }
    .date_p {
        margin: unset;
        font-size: 11px;
        color: black;
        font-weight: 500;
    }
    .filter_btn {
        padding: 5px;
        text-align: center;
        width: 70px;
        background-color: #2dce89;
        border: none;
        cursor: pointer;
        color: white !important;
    }
    .excel_btn {
        padding: 5px;
        text-align: center;
        width: 70px;
        border: 1px solid#DEDEDE;
        /* background-color: #c9cecc; */
        cursor: pointer;
        color: rgb(0, 0, 0) !important;
    }

    .table-bottom-details2 {
        color: #020202
    }
    .header-layout {
        margin-bottom: 2rem !important;
    }
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        display: none;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }
    .select-border-style{
        border: 1px solid #b3b3b3 !important;
        border-radius: 0rem !important;
    }
    .select2-selection--single{
        background-color: #F8F8F8 !important;
    }
    .d_flex_and_align_center{
        display: flex;
        align-items: center;
    }
    .select-width-style .select2.select2-container.select2-container--default{
        width: 8rem !important;
    }
    .select-width-style-item .select2.select2-container.select2-container--default{
        width: 10rem !important;
    }
    .page-item .page-link, .page-item span {
        border-radius: 0 !important;
        font-size: 0.7rem;
    }
    .page-item.active .page-link {
        z-index: 1;
        color: grey;
        border-color: #cccccc;
        background-color: #e9e9e9;
        box-shadow:none;
    }
    .table thead th, .table tbody td {
        padding-top: 0;
        padding-bottom: 0;
    }
    .table tbody td {
        padding-top: 7.5px;
        padding-bottom: 7.5px;
    }
    table.dataTable thead .sorting:before, table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:before, table.dataTable thead .sorting_desc_disabled:after {
        bottom: 0.6rem !important;
    }
    table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
        right: .7rem !important;
    }
    table.dataTable thead .sorting:before, table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:before, table.dataTable thead .sorting_desc_disabled:after {
    bottom: .65em;
    }
    table.dataTable thead .sorting:before,table.dataTable thead .sorting_asc:before,table.dataTable thead .sorting_desc:before,table.dataTable thead .sorting_asc_disabled:before,table.dataTable thead .sorting_desc_disabled:before {
        content: "\f0de";
        font-family: FontAwesome;
    }
    table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:after,table.dataTable thead .sorting_asc_disabled:after,table.dataTable thead .sorting_desc_disabled:after {
        content: "\f0dd";
        font-family: FontAwesome;
        right: .65rem !important;
    }
    @media (max-width: 767px) {

        /* ---------- Page: grey background, no big white wrapper ---------- */
        #scrollTable { padding: 0 !important; margin-top: 10px !important; }
        #scrollTable > .card { background: transparent !important; box-shadow: none !important; border: 0 !important; overflow: visible !important; }

        /* ---------- Filter card ---------- */
        #summary_filter_form {
            display: flex; flex-wrap: wrap; align-items: center;
            background: #fff; border-radius: 12px; padding: 12px;
            box-shadow: 0 1px 6px rgba(0,0,0,.08); margin-bottom: 16px;
        }
        
        /* flatten first row so every control can be ordered */
        #summary_filter_form > .row:first-of-type { display: contents; }
        #summary_filter_form > .row:last-of-type { order: 5; width: 100%; margin: 8px 0 !important; }
        #summary_filter_form > .row:last-of-type table { width: auto; }
        #summary_filter_form > .row:last-of-type label { margin: 0 !important; font-size: 13px; color: #000; }

        /* line break after pills */
        #summary_filter_form::before { content: ""; order: 2; flex-basis: 100%; height: 0; }

        /* Date pills */
        .row-for-date-options {
            order: 1; width: auto; margin: 0 6px 8px 0 !important;
            border-radius: 20px !important; background: #fff !important;
            border: 1px solid #DEDEDE !important; padding: 5px 12px !important;
        }
        .row-for-date-options.ml-auto { margin-left: 0 !important; }
        .row-for-date-options .date_p { font-size: 12px; color: #000; white-space: nowrap; }
        .row-for-date-options:has(input:checked) { background: #000 !important; border-color: #000 !important; }
        .row-for-date-options:has(input:checked) .date_p { color: #fff !important; }

        /* Start / End side by side */
        #summary_filter_form > .row:first-of-type > .filter_row:nth-child(2),
        #summary_filter_form > .row:first-of-type > .filter_row:nth-child(3) {
            order: 3; width: calc(50% - 4px); margin: 4px 0 !important; padding: 0 !important;
            background: #F8F8F8; border: 1px solid #DEDEDE; border-radius: 8px;
        }
        #summary_filter_form > .row:first-of-type > .filter_row:nth-child(2) { margin-right: 8px !important; }
        #summary_filter_form > .row:first-of-type > .filter_row:nth-child(2) .date_p,
        #summary_filter_form > .row:first-of-type > .filter_row:nth-child(3) .date_p { display: none; }

        /* Based on date */
        #summary_filter_form > .row:first-of-type > .filter_row:nth-child(4) {
            order: 4; width: 100%; margin: 4px 0 !important; padding: 0 !important;
            background: #F8F8F8; border: 1px solid #DEDEDE; border-radius: 8px;
        }

        #summary_filter_form .filter_row .date_selection,
        #summary_filter_form .filter_row .date_selection input,
        #summary_filter_form .filter_row .date_selection select,
        #summary_filter_form .select2.select2-container { width: 100% !important; }
        #summary_filter_form .filter_row .date_selection { padding: 0 !important; }
        #summary_filter_form .filter_row .date_selection input { border: 0 !important; background: transparent !important; padding: 0 10px; font-size: 13px; color: #777; }
        #summary_filter_form .select2-selection--single { border: 0 !important; background: transparent !important; height: 40px !important; }
        #summary_filter_form .select2-selection__rendered { line-height: 40px !important; font-size: 13px; color: #777 !important; }

        /* Filter button: full width black */
        #summary_filter_form > .row:first-of-type ~ * { }
        #summary_filter_form > .row:first-of-type > div[style*="margin-left"] { order: 6; width: 100%; margin: 4px 0 0 !important; }
        #summary_filter_form > .row:first-of-type > div[style*="margin-left"] .row { margin: 0 !important; }
        .filter_btn { width: 100%; height: 42px !important; background: #000; border-radius: 8px; font-size: 13px; }

        /* Per page: small, bottom of the card */
        #summary_filter_form > .row:first-of-type > .filter_row:nth-child(1) {
            order: 7; width: auto; margin: 10px 0 0 !important; padding: 2px 6px !important;
            background: transparent; border: 0;
        }
        #page_length { color: #777; }

        /* ---------- Table -> separate white cards on grey ---------- */
        .order_sammary_table { padding: 0 !important; overflow: visible !important; background: transparent !important; }
        .order_sammary_table .dataTables_wrapper,
        .order_sammary_table .dataTables_scroll,
        .order_sammary_table .dataTables_scrollBody {
            width: 100% !important; overflow: visible !important; border: 0 !important; background: transparent !important;
        }
        .dataTables_scrollHead, #order_summary thead { display: none !important; }

        /* remove 15px side padding from DataTables inner columns */
        .dataTables_wrapper .row > [class*="col-"] { padding-left: 0 !important; padding-right: 0 !important; }
        .dataTables_wrapper { padding: 0 !important; }

        #order_summary { display: block; width: 100% !important; min-width: 0 !important; margin: 0 !important; background: transparent !important; }
        #order_summary tbody { display: block; width: 100%; background: transparent !important; }
        #order_summary tbody tr {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 6px 8px;
            background: #fff !important; border-radius: 12px; padding: 14px;
            margin-bottom: 14px; box-shadow: 0 1px 4px rgba(0,0,0,.08);
        }
        #order_summary tbody td { display: block; border: 0 !important; padding: 0 !important; text-align: left !important; background: transparent; }

        #order_summary tbody td:nth-child(1) { display: none; }
        #order_summary tbody td:nth-child(2) { grid-column: 1 / 3; grid-row: 1; font-weight: 700; font-size: 15px; min-width: 0; word-break: break-word; padding-right: 8px !important; }
        #order_summary tbody td:nth-child(4) { grid-column: 3; grid-row: 1; text-align: right !important; font-weight: 600; font-size: 13px; white-space: nowrap; }
        #order_summary tbody td:nth-child(4)::after { content: " Orders"; }
        #order_summary tbody td:nth-child(3) { grid-column: 1 / 4; grid-row: 2; color: #777; font-size: 13px; margin-bottom: 6px; }

        #order_summary tbody td:nth-child(5),
        #order_summary tbody td:nth-child(6),
        #order_summary tbody td:nth-child(7) {
            grid-row: 3; background: #F3F3F3 !important; border-radius: 6px; padding: 8px 10px !important;
            font-size: 13px; font-weight: 600;
        }
        #order_summary tbody td:nth-child(5) { grid-column: 1; color: #000; }
        #order_summary tbody td:nth-child(6) { grid-column: 2; color: #3aa335; }
        #order_summary tbody td:nth-child(7) { grid-column: 3; color: #e0001a; }
        #order_summary tbody td:nth-child(5)::before,
        #order_summary tbody td:nth-child(6)::before,
        #order_summary tbody td:nth-child(7)::before { display: block; color: #777; font-size: 12px; font-weight: 400; }
        #order_summary tbody td:nth-child(5)::before { content: "Total"; }
        #order_summary tbody td:nth-child(6)::before { content: "Paid"; }
        #order_summary tbody td:nth-child(7)::before { content: "Balance"; }

        /* ---------- Pagination: only < 1 > on the right ---------- */
        .dataTables_wrapper .row { margin: 0 !important; }
        .dataTables_paginate { float: none !important; width: 100%; margin: 0 !important; }
        .dataTables_paginate .pagination { justify-content: flex-end !important; flex-wrap: nowrap; margin: 4px 0 16px !important; }
        .dataTables_paginate .paginate_button:not(.active):not(.previous):not(.next) { display: none; }
        .dataTables_paginate .page-link { border-radius: 6px !important; min-width: 34px; text-align: center; }
        .dataTables_paginate .paginate_button.active .page-link { background: #000; color: #fff; border-color: #000; }
    }
</style>


@if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif

<div class=" mb-5 content-position">

    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Customer Sales Summary</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection


    <div class="col-md-12" style="margin-top: 15px; margin-bottom: 25px; padding-bottom: 20px;" id="scrollTable">
        <div class="card" style="border: unset;">
            <form id="summary_filter_form">
                @csrf
                <div class="row" style="margin: 10px;">
                    <div class="row filter_row"  style="padding-bottom: 2px;margin:5px">
                        <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                            <select id="page_length" class="date_selection">
                                <option value="5">5 per page</option>
                                <option value="10">10 per page</option>
                                <option value="20" selected>20 per page</option>
                                <option value="50">50 per page</option>
                            </select>
                        </div>
                    </div>
                    <div class="row filter_row" style="padding-bottom: 2px;margin:5px">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">Start Date |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                            <input type="text" name="start_date" class="summary-datepicker invoice-inputs" style="height: 2rem;background-color:#F8F8F8;border: 1px solid #DEDEDE;" id="start_date">
                        </div>
                    </div>
                    <div class="row filter_row" style="padding-bottom: 2px;margin:5px">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">End Date |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                            <input type="text" name="end_date" class="summary-datepicker invoice-inputs" style="height: 2rem;background-color:#F8F8F8;border: 1px solid #DEDEDE;" id="end_date">
                        </div>
                    </div>
                    <div class="row filter_row" style="padding-bottom: 2px;margin:5px">
                        {{-- <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">Report Type</p> --}}
                        <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                            <select id="filtercolumn" name="filtercolumn" class="date_selection summary-select2">
                                <option value="production_date" selected>Based on Production Date</option>
                                <option value="ex_factory_date">Based on Ex-factory Date</option>

                            </select>
                        </div>
                    </div>
                    <div style="margin-left: 45px;">
                        <div class="row d_flex_and_align_center" style="padding-bottom: 2px;height: 100%;">
                            <button class="date_p filter_btn" type="button" id="pin-filter" title="Filter" style="height: 100%;">
                                <i class="fa fa-filter"></i>&nbsp;&nbsp;Filter
                            </button>
                        </div>
                    </div>
                    <div class="row filter_row row-for-date-options ml-auto" style="padding-bottom: 2px; margin:5px;">
                        <label class="d_flex_and_align_center" style="margin: 0;cursor: pointer;">
                            <input type="radio" name="dateFilter" style="display: none" value="thisMonth">
                            <span class="font_color date_p" >This month</span>
                        </label>
                    </div>

                    <div class="row filter_row row-for-date-options" style="padding-bottom: 2px; margin:5px;">
                        <label class="d_flex_and_align_center" style="margin: 0;cursor: pointer;">
                            <input type="radio" name="dateFilter" style="display: none" value="lastMonth">
                            <span class="font_color date_p">Last month</span>
                        </label>
                    </div>

                    <div class="row filter_row row-for-date-options" style="padding-bottom: 2px; margin:5px;background-color: rgb(123, 216, 237);">
                        <label class="d_flex_and_align_center" style="margin: 0;cursor: pointer;">
                            <input type="radio" name="dateFilter" style="display: none" value="thisYear" checked>
                            <span class="font_color date_p">This year</span>
                        </label>
                    </div>

                    <div class="row filter_row row-for-date-options" style="padding-bottom: 2px; margin:5px;">
                        <label class="d_flex_and_align_center" style="margin: 0;cursor: pointer;">
                            <input type="radio" name="dateFilter" style="display: none" value="lastYearToday">
                            <span class="font_color date_p">Last year today</span>
                        </label>
                    </div>

                    <div class="row filter_row row-for-date-options" style="padding-bottom: 2px; margin:5px;">
                        <label class="d_flex_and_align_center" style="margin: 0;cursor: pointer;">
                            <input type="radio" name="dateFilter" style="display: none" value="thisQuarter">
                            <span class="font_color date_p">This quarter</span>
                        </label>
                    </div>
                </div>
                <div class="row" style="margin: 10px;">
                    <table >
                        <tr style="border: none;">
                            <td style="line-height: 1.3em; margin-right:10px"><label class="form-lable-info mx-2">With Internal Team Orders</label></td>
                            <td>
                                <input type="hidden" name="Internal_team_status" value="0">
                                <input type="checkbox" class="Internal_team_status" id="Internal_team_status" name="Internal_team_status" value="1" >
                            </td>
                        </tr>
                    </table>
                </div>

                {{-- <div class="row" style="margin-left: 18px; margin-right: 30px; padding-bottom: 7px;">
                    <div class="row filter_row" style="padding-bottom: 2px;">
                        <p class="font_color date_p d_flex_and_align_center">Rep |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style" style="padding-left: 7px;">
                            <select id="user_filter" name="user_filter" class="date_selection summary-select2">
                                <option value="all">All</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div style="margin-left: 45px;">
                        <div class="row d_flex_and_align_center" style="padding-bottom: 2px;height: 100%;">
                            <button class="date_p filter_btn" type="button" id="pin-filter" title="Filter" style="height: 100%;">
                                <i class="fa fa-filter"></i>&nbsp;&nbsp;Filter
                            </button>
                        </div>
                    </div>
                    <div class="row filter_row ml-auto" style="padding-bottom: 2px;margin:5px;width: fit-content;">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;color: black;">Number of sale |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                            <span class="d_flex_and_align_center text-right" style="height: 1.5rem;background-color:#F8F8F8;width: 100%;color:black" id="number_of_sale">0</span>
                        </div>
                    </div>
                    <div class="row filter_row" style="padding-bottom: 2px;margin:5px;width: fit-content;">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;color: black;">Total ($) |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                            <span class="d_flex_and_align_center text-right" style="height: 1.5rem;background-color:#F8F8F8;width: 100%;color:black" id="total_sale">0.00</span>
                        </div>
                    </div>
                    <div >
                        <div class="row d_flex_and_align_center " style="padding-bottom: 2px;margin: 5px;">
                            <button class="date_p excel_btn" type="button" id="exportButton" title="Filter" style="height: 100%;">
                                <i class="fa fa-download"></i>&nbsp;&nbsp;Excel
                            </button>
                        </div>
                    </div>
                </div> --}}
            </form>


            <div class="order_sammary_table" style="">
                <table class="table align-items-center" id="order_summary" style="min-width: 100%;">

                    <thead style="background-color: #717070;">
                        <th scope="col" class="table_header_text">NO</th>
                        <th scope="col" class="table_header_text">ORGANIZATION NAME</th>
                        <th scope="col" class="table_header_text">SALES LEAD</th>
                        <th scope="col" class="table_header_text"># ORDERS</th>
                        <th scope="col" class="table_header_text" style="text-align: right;">TOTAL ($)</th>
                        <th scope="col" class="table_header_text" style="text-align: right;">PAID ($)</th>
                        <th scope="col" class="table_header_text" style="text-align: right;">BALANCE ($)</th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
            <div  style="padding-top: 10px;">
            <div id="pagination_controls" class="row justify-content-center" style="width: 100%;">
                {{-- pagination bar paste here --}}
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>


<script>

    $('.summary-datepicker').datepicker();
    $('.summary-select2').select2();

    $(document).ready(function() {

        let hoverTimeout;

        if ($(window).width() > 767) {
            if ($('#minimize_icon').length && $('#minimize_icon').css('display') != 'none') {
                $('#minimize_icon')[0].click();
            }

            $('#sidenav-main').hover(
                function() {
                    hoverTimeout = setTimeout(function() {
                        if ($('#maximize_icon').length && $('#maximize_icon').css('display') != 'none') {
                            $('#maximize_icon').click();
                        }
                    }, 500);
                },
                function() {
                    clearTimeout(hoverTimeout);
                    if ($('#minimize_icon').length && $('#minimize_icon').css('display') != 'none') {
                        $('#minimize_icon')[0].click();
                    }
                }
            );
        }

        $('input[name="dateFilter"]').on('click', function() {
            $('#start_date').val('');
            $('#end_date').val('');
            if ($(this).is(':checked')) {
                if ($(this).hasClass('active-radio')) {
                    $(this).prop('checked', false).removeClass('active-radio');
                    $(this).closest('.row-for-date-options').css('background-color', '#F8F8F8');
                    $(this).closest('.row-for-date-options').find('label span').css('color', 'black');
                } else {
                    $('input[name="dateFilter"]').removeClass('active-radio');
                    $(this).addClass('active-radio');
                    $('.row-for-date-options').css('background-color', '#F8F8F8');
                    $('.row-for-date-options label span').css('color', 'black');
                    $(this).closest('.row-for-date-options').css('background-color', '#7bd8ed');
                    $(this).closest('.row-for-date-options').find('label span').css('color', 'white');
                }
            }
        });

        $('#start_date, #end_date').focus(function() {
            $('input[name="dateFilter"]').prop('checked', false);
        });

        var table = $('#order_summary').DataTable({
            "paging": true,
            scrollX: true,
            "pageLength": $('#page_length').val(),
            "searching": false,
            "ordering": true,
            "info": false,
            "lengthChange": false,
            "columnDefs": [{
                        "targets": [4],
                        "className": "text-right"
                    },
                    {
                        "targets": [0,3,4,5,6],
                        "className": "text-center"
                    }]
        });

        function make_summary_table() {
            $('.se-pre-con').fadeIn();
            var formData = new FormData($('#summary_filter_form')[0]);

            $.ajax({
                url: "{{ route('get_cu_sales_summary_data') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#total_sale').text(parseFloat(response.total_sale).toFixed(2));
                    $('#number_of_sale').text(response.number_of_sale);
                    updateTable(response.orders);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function updateTable(data) {
            table.clear();
            var data = Object.values(data);
            data.forEach(function(order,index) {
                 table.row.add([

                    index + 1,
                    '<a style="color:black !important" href="#" class="edit-organization" data-value="'+order.orgid+'">'+order.orgname+'</a>',
                    order.sales_lead,
                    order.number_of_orders,
                    '<td style="text-align: right;">' + parseFloat(order.totalamount).toFixed(2) + '</td>',
                    '<td style="text-align: right;">' + parseFloat(order.total_paid).toFixed(2) + '</td>',
                    '<td style="text-align: right;">' + parseFloat(order.balance).toFixed(2) + '</td>',
                    // order.open_date,
                    // order.production_date,
                    // order.due_date
                ]);
            });

            table.draw();
            $('.se-pre-con').fadeOut();
            function calculateTotalQty(orderItems) {
                return orderItems
                    .filter(item => item && item.deleted_at == null && item.active == 1)
                    .reduce((sum, item) => sum + parseInt(item.qty || 0, 10), 0);
            }
        }

        $('#pin-filter').on('click', function() {
            make_summary_table();
        });

        $('#page_length').on('change', function() {
            table.page.len(parseInt($(this).val())).draw();
        });
        $('#user_filter').on('change', function() {
            make_summary_table();
        });
        $("body").on("click", ".edit-organization", function(){
            var orgrId = $(this).data('value');
            window.open('organizations/info/'+orgrId);
        });

    function setDates(dateType) {
        var startDate, endDate;
        var currentDate = new Date();

        switch (dateType) {
            case 'thisMonth':
                startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
                endDate = currentDate; // Use today's date as the end date
                break;
            case 'lastMonth':
                startDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, 1);
                endDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 0);
                break;
            case 'thisYear':
                startDate = new Date(currentDate.getFullYear(), 0, 1);
                endDate = currentDate; // Use today's date as the end date
                break;
            case 'lastYearToday':
                startDate = new Date(currentDate.getFullYear() - 1, 0, 1);
                endDate = new Date(currentDate.getFullYear() - 1, currentDate.getMonth(), currentDate.getDate());
                break;
            case 'thisQuarter':
                var quarter = Math.floor((currentDate.getMonth() + 3) / 3);
                startDate = new Date(currentDate.getFullYear(), (quarter - 1) * 3, 1);
                endDate = currentDate; // Use today's date as the end date
                break;
            default:
                startDate = '';
                endDate = '';
        }

        if (startDate) {
            $('#start_date').val(formatDate(startDate));
        }
        if (endDate) {
            $('#end_date').val(formatDate(endDate));
        }
        make_summary_table();
    }
    function formatDate(date) {
        var day = String(date.getDate()).padStart(2, '0');
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var year = date.getFullYear();
        return month + '/' + day + '/' + year;
    }

    setDates($('input[name="dateFilter"]:checked').val());

    $('input[name="dateFilter"]').on('change', function() {
        setDates($(this).val());
    });


        make_summary_table();
    });



</script>

@endsection
