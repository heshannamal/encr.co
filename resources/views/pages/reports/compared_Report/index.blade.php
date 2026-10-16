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

        if ($('#minimize_icon').css('display') != 'none') {
            $('#minimize_icon')[0].click();
        }

        $('#sidenav-main').hover(
            function() {
                hoverTimeout = setTimeout(function() {
                    if ($('#maximize_icon').css('display') != 'none') {
                        $('#maximize_icon').click();
                    }
                }, 500);
            },
            function() {
                clearTimeout(hoverTimeout);
                if ($('#minimize_icon').css('display') != 'none') {
                    $('#minimize_icon')[0].click();
                }
            }
        );







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
