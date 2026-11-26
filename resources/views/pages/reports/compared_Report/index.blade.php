@extends('layouts.app', ['activePage' => 'sales_summary', 'titlePage' => __('Sales Summary')])

@section('content')

<style>
    .swal2-popup .swal2-styled.swal2-confirm{
        font-size: 0.9rem !important;
    }
    .swal2-popup .swal2-styled.swal2-cancel {
        font-size: 0.9rem !important;
    }
    .swal2-popup .swal2-content {
        font-size: 0.9rem !important;
    }
    .swal2-popup .swal2-title{
        font-size: 1.5rem !important;
    }

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
        margin-top: 10px;
    }
    .date_selection {
        background-color: transparent;
        padding: unset;
        border: unset;
        color: #383838;
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
        background-color: #2da0ce;
        border: none;
        cursor: pointer;
        color: white !important;
    }
    .pdf_btn {
        padding: 5px;
        text-align: center;
        width: 70px;
        background-color: #2dce90;
        border: none;
        cursor: pointer;
        color: white !important;
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
    /* .select-width-style .select2.select2-container.select2-container--default{
        width: 10rem !important;
    }
    .select-width-style-item .select2.select2-container.select2-container--default{
        width: 10rem !important;
    } */
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
    .excel_btn {
        padding: 5px;
        text-align: center;
        width: 70px;
        border: 1px solid#DEDEDE;
        /* background-color: #c9cecc; */
        cursor: pointer;
        color: rgb(0, 0, 0) !important;
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
    .select-width-style .select2-container{
        width: 10rem !important;
    }

    /* Mobile Responsive CSS matching Figma design */
    @media (max-width: 767.98px) {
        .card{
            background-color: transparent !important;
        }
        .content-position {
            padding-left: 12px !important;
            padding-right: 12px !important;
            margin-top: 80px !important;
            background-color: #f8fafc !important;
        }

        /* Order Header & Export PDF button header alignment */
        .content-position {
            position: relative;
        }

        /* Stop horizontal overflow / page shifting */
        html, body {
            overflow-x: hidden !important;
        }
        #scrollTable,
        #summary_filter_form,
        #summary_filter_form .row {
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        /* Fix 1: Select2 dropdown must stay inside the card */
        .select2-container--open .select2-dropdown {
            width: 200px !important;
            /* width: auto !important; */
            /* min-width: 0 !important; */
            /* max-width: calc(100vw - 50px) !important; */
            left: 0 !important;
            box-sizing: border-box !important;
        }
        .select2-container--open {
            max-width: calc(100vw - 50px) !important;
        }
        .select2-search--dropdown .select2-search__field {
            width: 100% !important;
            box-sizing: border-box !important;
        }

        /* Fix 2: Report title input - kill the 400px width and black border */
        #summary_filter_form .select-width-style-item {
            width: 100% !important;
            max-width: 100% !important;
        }
        #summary_filter_form input#title,
        #summary_filter_form input#title:focus {
            width: 100% !important;
            max-width: 100% !important;
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            background-color: transparent !important;
            box-sizing: border-box !important;
        }
        #scrollTable {
            margin-top: 5px !important;
            margin-bottom: 15px !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /* Filter Form inside single white card */
        #summary_filter_form {
            background: #ffffff !important;
            border-radius: 16px !important;
            padding: 16px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04) !important;
            border: 1px solid #f1f5f9 !important;
        }

        #summary_filter_form .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        /* Stack each filter item 100% width line-by-line so titles and values fit without truncation */
        #summary_filter_form .row:first-child {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
        }

        #summary_filter_form .row:first-child .filter_row {
            margin-left: 0 !important;
            margin-right: 0 !important;
            margin-bottom: 0 !important;
            width: 100% !important;
        }

        #summary_filter_form .filter_row {
            margin-left: 0 !important;
            margin-right: 0 !important;
            margin-bottom: 12px !important;
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 10px !important;
            padding: 6px 12px !important;
            box-shadow: none !important;
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: flex-start !important;
            height: 46px !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        /* Enable title labels inside filter rows */
        #summary_filter_form .filter_row .date_p {
            display: inline-block !important;
            font-size: 13px !important;
            color: #334155 !important;
            font-weight: 600 !important;
            white-space: nowrap !important;
            margin-bottom: 0 !important;
            margin-right: 8px !important;
            flex-shrink: 0 !important;
        }

        #summary_filter_form .paymen_type_div {
            flex: 1 !important;
            width: auto !important;
            min-width: 0 !important;
            padding-left: 0 !important;
        }

        #summary_filter_form .select-width-style,
        #summary_filter_form .select-width-style-item {
            width: 100% !important;
            flex: 1 !important;
            min-width: 0 !important;
        }

        #summary_filter_form .select2-container {
            width: 100% !important;
            min-width: 0 !important;
        }

        #summary_filter_form .select2-container--default .select2-selection--single {
            background-color: transparent !important;
            border: none !important;
            height: 34px !important;
            display: flex !important;
            align-items: center !important;
        }

        #summary_filter_form .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #64748b !important;
            padding-left: 4px !important;
            font-size: 13px !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
        }

        #summary_filter_form .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 34px !important;
            right: 0 !important;
        }

        #summary_filter_form input#title {
            width: 100% !important;
            border: none !important;
            background-color: transparent !important;
            height: 34px !important;
            font-size: 13px !important;
            color: #334155 !important;
            padding: 0 4px !important;
        }

        #summary_filter_form input#title::placeholder {
            color: #94a3b8 !important;
        }

        #summary_filter_form .row.mt-2 {
            /* margin-top: 12px !important; */
            display: flex !important;
            flex-direction: column !important;
        }

        #summary_filter_form .row.mt-2 .filter_row {
            margin-bottom: 12px !important;
        }

        #summary_filter_form div[style*="margin-left: 45px"] {
            margin-left: 0 !important;
            width: 100% !important;
        }

        /* Dark compare button styled exact as Figma */
        #pin-compare {
            width: 100% !important;
            height: 46px !important;
            margin-top: 4px !important;
            background-color: #0d1527 !important;
            color: #ffffff !important;
            border-radius: 10px !important;
            font-weight: 500 !important;
            font-size: 14px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border: none !important;
            text-transform: capitalize !important;
            box-shadow: 0 4px 12px rgba(13, 21, 39, 0.15) !important;
        }

        /* Floating Export PDF button top right */
        #summary_filter_form .col {
            position: absolute !important;
            top: -55px !important;
            right: 15px !important;
            width: auto !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        #exportPDF_report {
            background-color: #46e3b7 !important;
            color: #ffffff !important;
            border-radius: 20px !important;
            padding: 6px 18px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            height: 36px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            border: none !important;
            box-shadow: 0 4px 10px rgba(70, 227, 183, 0.3) !important;
        }

        /* Chart container styling into clean white cards */
        #report_area1, #report_area2 {
            margin-left: 0 !important;
            padding: 0 !important;
        }

        #compared-chart-Label {
            font-size: 16px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            margin-top: 25px !important;
            margin-bottom: 20px !important;
            text-align: center !important;
            line-height: 1.4 !important;
        }

        #report_area1 .row, #report_area2 .row {
            display: flex !important;
            flex-direction: column !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            gap: 15px !important;
        }

        #report_area1 .col-5, #report_area2 .col-5 {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            background: #ffffff !important;
            border-radius: 16px !important;
            padding: 15px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03) !important;
            border: 1px solid #f1f5f9 !important;
            box-sizing: border-box !important;
        }

        #report_area1 canvas, #report_area2 canvas {
            max-width: 100% !important;
            height: 260px !important;
        }

        #report-text, #report-text2, #report-text3 {
            padding: 10px 5px !important;
            color: #334155 !important;
            font-size: 14px !important;
            line-height: 1.6 !important;
        }

        #report-text h3, #report-text2 h3, #report-text3 h3 {
            font-size: 16px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            margin-top: 15px !important;
            margin-bottom: 10px !important;
        }

        #report-text2 ul {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            padding-left: 15px !important;
        }
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
        <span>Compared Reports</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection


    <div class="col-md-12" style="margin-top: 15px; margin-bottom: 25px; padding-bottom: 20px;" id="scrollTable">
        <div class="card" style="border: unset;">
            <form id="summary_filter_form">
                @csrf


                <div class="row" style="margin-left: 18px; margin-right: 30px; padding-bottom: 7px;">
                    <div class="row filter_row" style="padding-bottom: 2px;">
                        <p class="font_color date_p d_flex_and_align_center">Report type |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style" style="padding-left: 7px;">
                            <select id="Report_type_filter" name="Report_type_filter" class="date_selection summary-select2">
                                <option value="1">Sales Summary Report</option>
                                {{-- <option value="2">AR Report</option> --}}
                                {{-- <option value="3">Customer Sales Summary</option> --}}
                            </select>
                        </div>
                    </div>

                    <div class="row filter_row ml-auto" style="padding-bottom: 2px; margin-left: 20px;">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">First Report |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style" style="padding-left: 10px;">
                            <select id="first_report_filter" name="first_report_filter" class="date_selection summary-select2">
                                <option value="">Select a report</option>
                                @foreach ($SavedReports as $SavedReport)
                                    <option value="{{ $SavedReport->id }}">{{ $SavedReport->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row filter_row" style="padding-bottom: 2px; margin-left: 20px;">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">Second Report |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style" style="padding-left: 7px;">
                            <select id="second_report_filter" name="second_report_filter" class="date_selection summary-select2">
                                <option value="">Select a report</option>
                                @foreach ($SavedReports as $SavedReport)
                                    <option value="{{ $SavedReport->id }}">{{ $SavedReport->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-2"  style="margin-left: 18px; margin-right: 10px; padding-bottom: 7px;">
                    <div class="row filter_row"  style="padding-bottom: 2px;">
                        <p class="font_color date_p d_flex_and_align_center">Report title |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style-item" style="padding-left: 7px;">
                            <input type="text" name="title" class=" invoice-inputs" style="height: 2rem;background-color:#F8F8F8;border: 1px solid #DEDEDE;width:400px" id="title">
                        </div>
                    </div>

                    <div style="margin-left: 45px;">
                        <div class="row d_flex_and_align_center" style="padding-bottom: 2px;height: 100%;">
                            <button class="date_p filter_btn" type="button" id="pin-compare" title="compare" style="height: 2.3rem;margin-top: 10px;">
                                <i class="fa fa-exchange"></i>&nbsp;&nbsp;compare
                            </button>
                        </div>
                    </div>

                    <div class="col  " style="padding-bottom: 2px;margin: 5px;">
                        <button class="date_p  pdf_btn" type="button" id="exportPDF_report" title="savereport" style="height: 2.3rem;margin-top: 10px;float: right;">
                            <i class="fa fa-floppy-o"></i>&nbsp;&nbsp;pdf
                        </button>
                    </div>
                </div>
            </form>

            <hr>
            <div style="margin-left: 2%;" id="report_area1">

                <div class="col-12 text-center mb-3">

                    <h2 class="" id="compared-chart-Label"></h2>
                </div>
                <div class="row " style="justify-content: space-evenly;">
                    <div class="col-5" style="">
                        <canvas id="comparedChartCanvas" style="max-width: 100%; height: 400px;"></canvas>
                    </div>
                    <div class="col-5" style="">
                        <canvas id="comparedChartCanvas-sale" style="max-width: 100%; height: 400px;"></canvas>
                    </div>
                </div>
                <div id="report-text" class="col-12"></div>
                <div class="row " style="justify-content: space-evenly;">

                    <div class="col-5">
                        <canvas id="comparedChartCanvas-total-order" style="max-width: 100%; height: 400px;"></canvas>
                    </div>
                    <div class="col-5">
                        <canvas id="comparedChartCanvas-total-sale" style="max-width: 100%; height: 400px;"></canvas>
                    </div>
                </div>
                <div id="report-text2" class="col-12"></div>
            </div>
            <div style="margin-left: 2%;" id="report_area2">
                <div class="row " style="justify-content: space-evenly;">

                    <div class="col-5">
                        <canvas id="comparedChartCanvas-piechart1" style="max-width: 100%; height: 400px;"></canvas>
                    </div>
                    <div class="col-5">
                        <canvas id="comparedChartCanvas-piechart2" style="max-width: 100%; height: 400px;"></canvas>
                    </div>
                </div>
                <div id="report-text3" class="col-12 mt-5"></div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>



<script>
var comparedChart = null;
    $('.summary-datepicker').datepicker();
    $('.summary-select2').select2();

    $(document).ready(function() {
        document.getElementById('exportPDF_report').addEventListener('click', async function() {
    // Access jsPDF constructor correctly for the new version
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF('p', 'mm', 'a4'); // Portrait, A4 page size

    // Function to capture and add a section to the PDF
    async function captureAndAddToPDF(element) {
        const canvas = await html2canvas(element, { scale: 2 });
        const imgData = canvas.toDataURL('image/png');
        const imgWidth = 210; // A4 width in mm
        const imgHeight = canvas.height * imgWidth / canvas.width; // Maintain aspect ratio
        const pageHeight = pdf.internal.pageSize.height;
        let heightLeft = imgHeight;
        let position = 0;

        // Add the image to the PDF, handling multiple pages if necessary
        while (heightLeft >= 0) {
            pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;
            position -= pageHeight;
            if (heightLeft >= 0) {
                pdf.addPage(); // Add a new page if there's more content
            }
        }
    }

    // Capture and add report_area1 to the PDF
    const reportArea1 = document.getElementById('report_area1');
    await captureAndAddToPDF(reportArea1);

    // Add a new page for report_area2
    pdf.addPage();

    // Capture and add report_area2 to the PDF
    const reportArea2 = document.getElementById('report_area2');
    await captureAndAddToPDF(reportArea2);

    // Save the PDF with a filename
    pdf.save('report.pdf');
});


        $('.summary-select2').select2();

        // When first dropdown changes
        $('#first_report_filter').on('change', function() {
            let selectedFirst = $(this).val();  // Get the selected value in the first dropdown
            let secondSelect = $('#second_report_filter');

            // Reset all options first (enable all)
            secondSelect.find('option').prop('disabled', false);

            // If there's a selection, disable it in the second dropdown
            if (selectedFirst) {
                secondSelect.find('option[value="' + selectedFirst + '"]').prop('disabled', true);
            }

            // Refresh the second Select2 to reflect changes
            secondSelect.select2();
        });

        // When second dropdown changes
        $('#second_report_filter').on('change', function() {
            let selectedSecond = $(this).val();  // Get the selected value in the second dropdown
            let firstSelect = $('#first_report_filter');

            // Reset all options first (enable all)
            firstSelect.find('option').prop('disabled', false);

            // If there's a selection, disable it in the first dropdown
            if (selectedSecond) {
                firstSelect.find('option[value="' + selectedSecond + '"]').prop('disabled', true);
            }

            // Refresh the first Select2 to reflect changes
            firstSelect.select2();
        });
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







        function make_compare_report() {
            $('.se-pre-con').fadeIn();
            var formData = new FormData($('#summary_filter_form')[0]);

            $.ajax({
                url: "{{ route('make_compare_report') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    $(".se-pre-con").fadeOut('fast');
                    months=['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                    drawChart(response.first_filter.order_count_by_month, response.second_filter.order_count_by_month,"comparedChartCanvas",response.first_filter.report_name, response.second_filter.report_name, "Number of Orders",'line',months);
                    drawChart(response.first_filter.order_sale_by_month, response.second_filter.order_sale_by_month,"comparedChartCanvas-sale",response.first_filter.report_name, response.second_filter.report_name, "Total Value",'line',months);
                    drawBarChart(response.first_filter.number_of_sale, response.second_filter.number_of_sale,"comparedChartCanvas-total-order",response.first_filter.report_name, response.second_filter.report_name, "Number of Orders",'bar',[response.first_filter.report_name,response.second_filter.report_name],'rgba(255, 99, 132, 0.2)');
                    drawBarChart(response.first_filter.total_sale, response.second_filter.total_sale,"comparedChartCanvas-total-sale",response.first_filter.report_name, response.second_filter.report_name, "Total Value",'bar',[response.first_filter.report_name,response.second_filter.report_name],'rgba(75, 192, 192, 0.2)');

                    // Assuming sales_rep_performance is your data array
                    let salesRepPerformance = response.sales_rep_performance;

                    // Prepare arrays to hold the names and values for the pie chart
                    let salesRepNames = [];
                    let numberOfSales = [];
                    let totalSalesAmounts = [];

                    // Iterate over the sales_rep_performance data
                    salesRepPerformance.forEach(rep => {
                        console.log(rep.user_name);

                        salesRepNames.push(rep.user_name); // Assuming user_details has the name field
                        numberOfSales.push(rep.number_of_sales); // Total number of sales for each rep
                        totalSalesAmounts.push(rep.total_sales_amount); // Total sales amount for each rep
                    });
                    console.log(salesRepNames);
                    console.log(numberOfSales);
                    console.log(totalSalesAmounts);

                    drawPieChart(numberOfSales,salesRepNames,'comparedChartCanvas-piechart1','Total Sales Comparison by Number of sales','Number of Sales');
                    drawPieChart(totalSalesAmounts,salesRepNames,'comparedChartCanvas-piechart2','Total Sales Comparison by sales values','Value of Sales');
                    // document.getElementById('compared-chart-Label').textContent = response.report_title;
                    // Assuming `response` is the object that contains report data
                    if (response.report_title) {
                        // If reportText exists, set it in the report-text element
                        document.getElementById('compared-chart-Label').innerHTML = response.report_title;
                    } else {
                        // If reportText is null or undefined, set a default message
                        var comparedMessage = "This is a compared report of " +
                                            (response.second_filter.report_name || "First Report") + " and " +
                                            (response.first_filter.report_name || "Second Report");
                        document.getElementById('compared-chart-Label').innerHTML = comparedMessage;
                    }

                    document.getElementById('report-text').innerHTML = response.reportText;
                    // $('#compared-chart-modal').modal('show');
                    // Assuming you already have the performance data ready

                    let reportText = "<h3>Sales Representative Performance Summary</h3><ul style='display:flex;gap: 50px;flex-wrap: wrap;'>";

                    // Iterate through the sales rep performance data to create a report
                    salesRepPerformance.forEach(rep => {
                        const userName = rep.user_name ? rep.user_name : 'Unknown User'; // Modify as per your data structure
                        reportText += `<li><strong>${userName}</strong>:
                                    <br>Number of Sales: ${rep.number_of_sales}
                                    <br>Total Sales Amount: $${rep.total_sales_amount.toFixed(2)}</li>`;
                    });

                    reportText += "</ul>";

                    // Set the report text in the designated div
                    document.getElementById('report-text2').innerHTML = reportText;
                    document.getElementById('report-text3').innerHTML = response.salesComparison.conclusion;

                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        function getRandomColor(opacity = 1) {
            const r = Math.floor(Math.random() * 256);
            const g = Math.floor(Math.random() * 256);
            const b = Math.floor(Math.random() * 256);
            return `rgba(${r}, ${g}, ${b}, ${opacity})`;
        }
        function drawPieChart(data,lableset,CanvasId,title_text,lable2) {
            let chartStatus = Chart.getChart(CanvasId); // <canvas> id
            if (chartStatus != undefined) {
                chartStatus.destroy();
            }

            var totalSalesCtx = document.getElementById(CanvasId).getContext('2d');
            // Generate colors for each segment
            const backgroundColors = [];
            const borderColors = [];

            // Create colors for each data point
            for (let i = 0; i < data.length; i++) {
                backgroundColors.push(getRandomColor(0.5)); // 50% opacity
                borderColors.push(getRandomColor(1)); // 100% opacity
            }
            // Create a pie chart for total sales
            var totalSalesChart = new Chart(totalSalesCtx, {
                type: 'pie', // Pie chart type
                data: {
                    labels: lableset, // Labels for the chart
                    datasets: [{
                        label: lable2, //'Total Sales', // Label for the chart
                        data: data,//[firstReportTotal, secondReportTotal, others], // Total sales for both reports and the overall total
                        backgroundColor: backgroundColors, // Dynamic background colors
                        borderColor: borderColors, // Dynamic border colors
                        borderWidth: 1 // Width of the pie slice borders
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: title_text //'Total Sales Comparison'
                        },
                        legend: {
                            display: true, // Show the legend
                            position: 'bottom' // Position the legend at the bottom
                        }
                    }
                }
            });
        }

        function drawChart(firstReportData, secondReportData, CanvasId, report_name1, report_name2, y_label,chart_type,x_axis) {

            let chartStatus = Chart.getChart(CanvasId); // <canvas> id
            if (chartStatus != undefined) {
                chartStatus.destroy();
            }
            var ctx = document.getElementById(CanvasId).getContext('2d');
            // Check if the chart already exists and destroy it


            var comparedChart = new Chart(ctx, {
                type: chart_type,
                data: {
                    labels: x_axis, // X-axis (Months)
                    datasets: [
                        {
                            label: report_name1,
                            data: firstReportData,  // Array of data points for first report
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: false,
                        },
                        {
                            label: report_name2,
                            data: secondReportData,  // Array of data points for second report
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: false,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Months'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: y_label
                            }
                        }
                    }
                }
            });
        }

        function drawBarChart(firstReportData, secondReportData, CanvasId, report_name1, report_name2, y_label,chart_type,x_axis,bg_color) {

            let chartStatus = Chart.getChart(CanvasId); // <canvas> id
            if (chartStatus != undefined) {
                chartStatus.destroy();
            }
            var ctx = document.getElementById(CanvasId).getContext('2d');
            // Check if the chart already exists and destroy it


            var comparedChart = new Chart(ctx, {
                type: chart_type,
                data: {
                    labels: x_axis, // X-axis (Months)
                    datasets: [
                        {
                            label: report_name1,report_name2,
                            data: [firstReportData, secondReportData,],  // Array of data points for first report
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: bg_color,
                            fill: false,
                        },
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Reports'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: y_label
                            }
                        }
                    }
                }
            });
        }

        $('#pin-compare').on('click', function() {
            make_compare_report();
        });

    });




</script>

@endsection
