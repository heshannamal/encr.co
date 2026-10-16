@extends('layouts.app', ['activePage' => 'order', 'titlePage' => __('Quote')])

@section('content')

<style>
    .content-position {
        padding-left: 15px !important;
        padding-right: 15px !important;
        color: white;
    }
    .top_button {
        font-size: 12px;
        font-weight: 600;
        color: #B3B3B3;
    }
    .print_btn {
        padding-right: 3%;
        padding-left: 2%;
    }
    .canvasjs-chart-credit {
        display: none;
    }
    .bargraph_header {
        color: black;
        font-size: 17px;
    }
    .bargraph_header_div {
        padding-left: 30px;
        padding-top: 15px;
    }
    .table_header_text {
        color: white;
        height: 40px;
    }
    .order_sammary_table {
        padding-top: 20px;
        overflow-x: auto;
        padding-left: 15PX;
        padding-right: 15PX;
        padding-bottom: 15px;
    }
    .pie_table_header {
        color: #717070;
        border: unset !important;
    }
    .colour_box {
        width: 15px;
        height: 9px;
        border-radius: 3px;
    }
    .pie_table_body {
        border: unset !important;
        color: #020202;
    }
    .view_order_btn {
        color: #47D6B6 !important;
        border: 1px solid #47D6B6;
        background-color: transparent;
        border-radius: 5px;
        padding: 7px;
        cursor: pointer;
    }

    .loader {
        transform: rotateZ(45deg);
        perspective: 1000px;
        border-radius: 50%;
        width: 48px;
        height: 48px;
        color: #94ffa6;
      }
        .loader:before,
        .loader:after {
          content: '';
          display: block;
          position: absolute;
          top: 0;
          left: 0;
          width: inherit;
          height: inherit;
          border-radius: 50%;
          transform: rotateX(70deg);
          animation: 1s spin linear infinite;
        }
        .loader:after {
          color: #FF3D00;
          transform: rotateY(70deg);
          animation-delay: .4s;
        }

    .loaderTable {
        transform: rotateZ(45deg);
        perspective: 1000px;
        border-radius: 50%;
        width: 48px;
        height: 48px;
        color: #94ffa6;
      }
        .loaderTable:before,
        .loaderTable:after {
          content: '';
          display: block;
          position: absolute;
          top: 0;
          left: 0;
          width: inherit;
          height: inherit;
          border-radius: 50%;
          transform: rotateX(70deg);
          animation: 1s spin linear infinite;
        }
        .loaderTable:after {
          color: #FF3D00;
          transform: rotateY(70deg);
          animation-delay: .4s;
        }

    .loaderPie {
        transform: rotateZ(45deg);
        perspective: 1000px;
        border-radius: 50%;
        width: 48px;
        height: 48px;
        color: #94ffa6;
      }
        .loaderPie:before,
        .loaderPie:after {
          content: '';
          display: block;
          position: absolute;
          top: 0;
          left: 0;
          width: inherit;
          height: inherit;
          border-radius: 50%;
          transform: rotateX(70deg);
          animation: 1s spin linear infinite;
        }
        .loaderPie:after {
          color: #FF3D00;
          transform: rotateY(70deg);
          animation-delay: .4s;
        }

      @keyframes rotate {
        0% {
          transform: translate(-50%, -50%) rotateZ(0deg);
        }
        100% {
          transform: translate(-50%, -50%) rotateZ(360deg);
        }
      }

      @keyframes rotateccw {
        0% {
          transform: translate(-50%, -50%) rotate(0deg);
        }
        100% {
          transform: translate(-50%, -50%) rotate(-360deg);
        }
      }

      @keyframes spin {
        0%,
        100% {
          box-shadow: .2em 0px 0 0px currentcolor;
        }
        12% {
          box-shadow: .2em .2em 0 0 currentcolor;
        }
        25% {
          box-shadow: 0 .2em 0 0px currentcolor;
        }
        37% {
          box-shadow: -.2em .2em 0 0 currentcolor;
        }
        50% {
          box-shadow: -.2em 0 0 0 currentcolor;
        }
        62% {
          box-shadow: -.2em -.2em 0 0 currentcolor;
        }
        75% {
          box-shadow: 0px -.2em 0 0 currentcolor;
        }
        87% {
          box-shadow: .2em -.2em 0 0 currentcolor;
        }
      }


    .hide {
        display: none;
    }
    .table-bottom-details2 {
        color: #020202
    }
    .header-layout {
        margin-bottom: 2rem !important;
    }
    /* .canvasjs-chart-canvas {
        height: 469px !important;
        padding-top: 14px !important;
        padding-right: 10px !important;
    } */
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }
</style>


@if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif
<div id="buffering_icon1" style="display: none;">
    <img src="{{ asset('argon') }}/img/icons/buffering_icon.gif" />
</div>

<div class=" mb-5 content-position">

    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Sales Lead Summary Report</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    {{-- <div class="col-lg-12" style="margin-bottom: 1rem;">
        <div class="row">
            <div class="ml-auto">
                <a class="top_button" href="#"><i class="fa fa-download" style="margin-right: 8px;"></i>EXPORT REPORT</a>
            </div>
            <div class="ml-auto print_btn" style="margin-left: unset !important;">
                <a class="top_button" href="#"><i class="fa fa-print" style="margin-right: 8px;"></i>PRINT</a>
            </div>
        </div>

    </div> --}}


    <div class="col-md-12">
        <div class="" style="border: unset;">
            <div class="row">
                <div class="bargraph_header_div">
                    <b class="bargraph_header">Sales by Lead</b>
                </div>
                <div class="year bargraph_header_div">
                    <select id="yearSelect">
                        <!-- Options will be added by JavaScript -->
                    </select>
                </div>
                <div class="ml-auto" style="padding-top: 10px;">
                    <a class="top_button export_btn" href="#"><i class="fa fa-download" style="margin-right: 8px;"></i>EXPORT REPORT</a>
                </div>
                <div class="ml-auto print_btn" style="margin-left: unset !important; padding-top: 10px;">
                    <a class="top_button" href="#"><i class="fa fa-print" style="margin-right: 8px;"></i>PRINT</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 " style="padding-right: 5px;">
                    <div class="card barChart_size" style="border: unset;">
                        <span class="loader hide"></span> <!-- Loader element -->
                        <div id="chartBarGraph" class="chartBarGraph" style="height: 530px; width: 100%; position: relative;">

                    </div>
                    </div>
                </div>
                <div class="col-md-6 " style="padding-left: 5px;">
                    <div class="card" style="border: unset; height: 100%; padding-top: 50px;">
                        <span class="loaderPie hide" style="margin-left: 20px;"></span>
                        <div id="chartPieGraph" style=""></div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="col-md-12" style="margin-top: 15px; ">
        <div class="card" style="border: unset; padding-left: 15px;">
            <div class="row">
                <div class="bargraph_header_div">
                    <b class="bargraph_header">Average Sales by Lead</b>
                </div>
                {{-- <div class="year bargraph_header_div">
                    <select id="yearSelectPieChart">
                        <!-- Options will be added by JavaScript -->
                    </select>
                </div> --}}
            </div>

            <div class="row">
                {{-- <span class="loaderPie hide" style="margin-left: 20px;"></span>
                <div id="chartPieGraph" style="height: 300px !important; width: 35%;"></div> --}}
                <div style="width: 100%;">
                    <table  class="table align-items-center" id="pieChartTable">
                        <thead>
                            <tr>
                                <th class="pie_table_header"></th>
                                <th class="pie_table_header"></th>
                                <th class="pie_table_header">SALES (%) </th>
                                <th class="pie_table_header" style="text-align: right; padding-right: 3rem;">SALES ($) </th>
                                <th class="pie_table_header">ORDERS </th>
                                <th class="pie_table_header"></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td class="pie_table_body"><div class="colour_box" style="background-color: #43c2a6"></div></td>
                                <td class="pie_table_body">Email Campaign </td>
                                <td class="pie_table_body" id="email_sale_percent"></td>
                                <td class="pie_table_body" id="email_sale_Total" style="text-align: right; padding-right: 3rem;"></td>
                                <td class="pie_table_body" id="email_sale_count"></td>
                                <td class="pie_table_body"><button class="view_order_btn email_orders">VIEW ORDERS <i class="fa fa-angle-right"></i></button></td>
                            </tr>
                            <tr>
                                <td class="pie_table_body"><div class="colour_box" style="background-color: #4debc7"></div></td>
                                <td class="pie_table_body">Store Walking</td>
                                <td class="pie_table_body" id="walk_sale_percent"></td>
                                <td class="pie_table_body" id="walk_sale_Total" style="text-align: right; padding-right: 3rem;"></td>
                                <td class="pie_table_body" id="walk_sale_count"></td>
                                <td class="pie_table_body"><button class="view_order_btn walk_orders">VIEW ORDERS <i class="fa fa-angle-right"></i></button></td>
                            </tr>
                            <tr>
                                <td class="pie_table_body"><div class="colour_box" style="background-color: #78e6ce"></div></td>
                                <td class="pie_table_body">Online Inquiry</td>
                                <td class="pie_table_body" id="online_sale_percent"></td>
                                <td class="pie_table_body" id="online_sale_Total" style="text-align: right; padding-right: 3rem;"></td>
                                <td class="pie_table_body" id="online_sale_count"></td>
                                <td class="pie_table_body"><button class="view_order_btn online_orders">VIEW ORDERS <i class="fa fa-angle-right"></i></button></td>
                            </tr>
                            <tr>
                                <td class="pie_table_body"><div class="colour_box" style="background-color: #B5EFE2"></div></td>
                                <td class="pie_table_body">Referral</td>
                                <td class="pie_table_body" id="referral_sale_percent"></td>
                                <td class="pie_table_body" id="referral_sale_Total" style="text-align: right; padding-right: 3rem;"></td>
                                <td class="pie_table_body" id="referral_sale_count"></td>
                                <td class="pie_table_body"><button class="view_order_btn referral_orders">VIEW ORDERS <i class="fa fa-angle-right"></i></button></td>
                            </tr>
                            <tr>
                                <td class="pie_table_body"><div class="colour_box" style="background-color: #80E0FF"></div></td>
                                <td class="pie_table_body">Other</td>
                                <td class="pie_table_body" id="other_sale_percent"></td>
                                <td class="pie_table_body" id="other_sale_Total" style="text-align: right; padding-right: 3rem;"></td>
                                <td class="pie_table_body" id="other_sale_count"></td>
                                <td class="pie_table_body"><button class="view_order_btn other_orders">VIEW ORDERS <i class="fa fa-angle-right"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div class="col-md-12" style="margin-top: 15px; margin-bottom: 25px; padding-bottom: 20px;" id="scrollTable">
        <div class="card" style="border: unset;">
            <div class="row">
                <div class="bargraph_header_div">
                    <b class="bargraph_header">Sales Lead Summary</b>
                </div>
                <div class="year bargraph_header_div">
                    <select id="yearSelectSummary">
                        <!-- Options will be added by JavaScript -->
                    </select>
                </div>
                <div class="month bargraph_header_div">
                    <select id="monthSelectSummary">
                        <!-- Options will be added by JavaScript -->
                    </select>
                </div>
                <div class="catagory_option bargraph_header_div">
                    <select id="catagoryOption">
                        <option value="1">Email Campaign </option>
                        <option value="2">Store Walk in</option>
                        <option value="3">Online Enquiries</option>
                        <option value="6">Referral</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="bargraph_header_div">
                    <select id="ordersPerPage" onchange="changeOrdersPerPage()">
                        <option value="5">5 per page</option>
                        <option value="10" selected>10 per page</option>
                        <option value="20">20 per page</option>
                        <option value="50">50 per page</option>
                    </select>
                </div>
                <div class="bargraph_header_div">
                    <span class="loaderTable hide" style="position: absolute;"></span>
                </div>
            </div>

            <div class="order_sammary_table" style="">
                <table class="table align-items-center" id="order_sammary" style="min-width: 100%;">

                    <thead style="background-color: #717070;">
                        <th scope="col" class="table_header_text">ORDER ID</th>
                        <th scope="col" class="table_header_text">SALES LEAD TYPE </th>
                        <th scope="col" class="table_header_text">CREATED DATE </th>
                        <th scope="col" class="table_header_text">IN HAND DUE DATE </th>
                        <th scope="col" class="table_header_text">ORGANIZATION </th>
                        <th scope="col" class="table_header_text">ITEM QTY </th>
                        <th scope="col" class="table_header_text" style="text-align: right;">TOTAL ($)  </th>
                    </thead>

                    <tbody>

                    </tbody>
                </table>

            </div>
            <div  style="padding-top: 10px;">
                <div id="paginationbar" class="row justify-content-center" style="width: 100%;">
                    {{-- pagination bar paste here --}}
                    </div>
                </div>
        </div>
    </div>



</div>

<script type="text/javascript" src="https://cdn.canvasjs.com/canvasjs.min.js"></script>


<script type="text/javascript">
    window.onload = function () {

var orderEmailSumJan = {!! json_encode($orderEmailSumJanu) !!};
var orderwalkingSumJan = {!! json_encode($orderwalkingSumJanu) !!};
var orderonlineSumJan = {!! json_encode($orderonlineSumJanu) !!};
var orderreferralSumJan = {!! json_encode($orderreferralSumJanu) !!};
var orderOtherSumJanu = {!! json_encode($orderOtherSumJanu) !!};

var orderEmailSumFeb = {!! json_encode($orderEmailSumFebu) !!};
var orderwalkingSumFeb = {!! json_encode($orderwalkingSumFebu) !!};
var orderonlineSumFeb = {!! json_encode($orderonlineSumFebu) !!};
var orderreferralSumFeb = {!! json_encode($orderreferralSumFebu) !!};
var orderotherSumFeb = {!! json_encode($orderOtherSumfebu) !!};

var orderEmailSumMarch = {!! json_encode($orderEmailSumMarchu) !!};
var orderwalkingSumMarch = {!! json_encode($orderwalkingSumMarchu) !!};
var orderonlineSumMarch = {!! json_encode($orderonlineSumMarchu) !!};
var orderreferralSumMarch = {!! json_encode($orderreferralSumMarchu) !!};
var orderotherSumMarch = {!! json_encode($orderOtherSumMarchu) !!};

var orderEmailSumApr = {!! json_encode($orderEmailSumApru) !!};
var orderwalkingSumApr = {!! json_encode($orderwalkingSumApru) !!};
var orderonlineSumApr = {!! json_encode($orderonlineSumApru) !!};
var orderreferralSumApr = {!! json_encode($orderreferralSumApru) !!};
var orderotherSumApr = {!! json_encode($orderOtherSumApru) !!};

var orderEmailSumMay = {!! json_encode($orderEmailSumMayu) !!};
var orderwalkingSumMay = {!! json_encode($orderwalkingSumMayu) !!};
var orderonlineSumMay = {!! json_encode($orderonlineSumMayu) !!};
var orderreferralSumMay = {!! json_encode($orderreferralSumMayu) !!};
var orderotherSumMay = {!! json_encode($orderOtherSumMayu) !!};

var orderEmailSumJun = {!! json_encode($orderEmailSumJunu) !!};
var orderwalkingSumJun = {!! json_encode($orderwalkingSumJunu) !!};
var orderonlineSumJun = {!! json_encode($orderonlineSumJunu) !!};
var orderreferralSumJun = {!! json_encode($orderreferralSumJunu) !!};
var orderotherSumJun = {!! json_encode($orderOtherSumJunu) !!};

var orderEmailSumJul = {!! json_encode($orderEmailSumJulu) !!};
var orderwalkingSumJul = {!! json_encode($orderwalkingSumJulu) !!};
var orderonlineSumJul = {!! json_encode($orderonlineSumJulu) !!};
var orderreferralSumJul = {!! json_encode($orderreferralSumJulu) !!};
var orderotherSumJul = {!! json_encode($orderOtherSumJulu) !!};

var orderEmailSumAug = {!! json_encode($orderEmailSumAugu) !!};
var orderwalkingSumAug = {!! json_encode($orderwalkingSumAugu) !!};
var orderonlineSumAug = {!! json_encode($orderonlineSumAugu) !!};
var orderreferralSumAug = {!! json_encode($orderreferralSumAugu) !!};
var orderotherSumAug = {!! json_encode($orderOtherSumAugu) !!};

var orderEmailSumSep = {!! json_encode($orderEmailSumSepu) !!};
var orderwalkingSumSep = {!! json_encode($orderwalkingSumSepu) !!};
var orderonlineSumSep = {!! json_encode($orderonlineSumSepu) !!};
var orderreferralSumSep = {!! json_encode($orderreferralSumSepu) !!};
var orderotherSumSep = {!! json_encode($orderOtherSumSepu) !!};

var orderEmailSumOct = {!! json_encode($orderEmailSumOctu) !!};
var orderwalkingSumOct = {!! json_encode($orderwalkingSumOctu) !!};
var orderonlineSumOct = {!! json_encode($orderonlineSumOctu) !!};
var orderreferralSumOct = {!! json_encode($orderreferralSumOctu) !!};
var orderotherSumOct = {!! json_encode($orderOtherSumOctu) !!};

var orderEmailSumNov = {!! json_encode($orderEmailSumNovu) !!};
var orderwalkingSumNov = {!! json_encode($orderwalkingSumNovu) !!};
var orderonlineSumNov = {!! json_encode($orderonlineSumNovu) !!};
var orderreferralSumNov = {!! json_encode($orderreferralSumNovu) !!};
var orderotherSumNov = {!! json_encode($orderOtherSumNovu) !!};

var orderEmailSumDec = {!! json_encode($orderEmailSumDecu) !!};
var orderwalkingSumDec = {!! json_encode($orderwalkingSumDecu) !!};
var orderonlineSumDec = {!! json_encode($orderonlineSumDecu) !!};
var orderreferralSumDec = {!! json_encode($orderreferralSumDecu) !!};
var orderotherSumDec = {!! json_encode($orderOtherSumDecu) !!};
// bar graph
var chart = new CanvasJS.Chart("chartBarGraph", {
    title:{
        text: ""
    },
    axisY:{
        title: "Sales ($)",
        titleWrap: true,
        titleFontColor: "gray",
        valueFormatString: "#0.#,.",
        gridColor: "#eeeeee",
        titleFontSize: 18,
        labelFontSize: 14,
        labelFontColor: "gray",
        minimum: 0 // Set a minimum value for the y-axis
    },
    axisX:{
        valueFormatString: "#0.#,.",
        gridColor: "#eeeeee",
        titleFontSize: 18,
        labelFontSize: 14,
        labelFontColor: "gray"
    },
    legend: {
        verticalAlign: "top",
        horizontalAlign: "right",
        fontSize: 11,
        fontColor: "gray",
        fontWeight: 100,
        marginTop: 10, // Add margin to the top
        marginRight: 10 // Add margin to the right
    },
    data: [
    {
        type: "stackedColumn",
        legendText: "Email Campaign",
        showInLegend: true,
        color: "#47D6B6",
        columnWidth: 0.05,
        indexLabelFontSize: 12,
        toolTipContent: "{legendText}: ${y}",
        dataPoints: [
            { y: orderEmailSumJan, label: "Jan", id: "1"  },
            { y: orderEmailSumFeb, label: "Feb", id: "2"  },
            { y: orderEmailSumMarch, label: "Mar", id: "3" },
            { y: orderEmailSumApr, label: "Apr", id: "4" },
            { y: orderEmailSumMay, label: "May", id: "5" },
            { y: orderEmailSumJun, label: "Jun", id: "6" },
            { y: orderEmailSumJul, label: "Jul", id: "7" },
            { y: orderEmailSumAug, label: "Aug", id: "8" },
            { y: orderEmailSumSep, label: "Sep", id: "9" },
            { y: orderEmailSumOct, label: "Oct", id: "10" },
            { y: orderEmailSumNov, label: "Nov", id: "11" },
            { y: orderEmailSumDec, label: "Dec", id: "12" }
        ],
    },
    {
        type: "stackedColumn",
        legendText: "Store Walking",
        showInLegend: true,
        color: "#47a3d6",
        indexLabel: "",
        columnWidth: 0.05,
        indexLabelPlacement: "outside",
        indexLabelFontSize: 12,
        toolTipContent: "{legendText}: ${y}",
        dataPoints: [
            { y: orderwalkingSumJan , label: "Jan", id: "1"  },
            { y: orderwalkingSumFeb, label: "Feb", id: "2" },
            { y: orderwalkingSumMarch, label: "Mar", id: "3" },
            { y: orderwalkingSumApr, label: "Apr", id: "4" },
            { y: orderwalkingSumMay, label: "May", id: "5" },
            { y: orderwalkingSumJun, label: "Jun", id: "6" },
            { y: orderwalkingSumJul, label: "Jul", id: "7" },
            { y: orderwalkingSumAug, label: "Aug", id: "8" },
            { y: orderwalkingSumSep, label: "Sep", id: "9" },
            { y: orderwalkingSumOct, label: "Oct", id: "10" },
            { y: orderwalkingSumNov, label: "Nov", id: "11" },
            { y: orderwalkingSumDec, label: "Dec", id: "12" }
        ]
    },
    {
        type: "stackedColumn",
        legendText: "Online Inquiry",
        showInLegend: true,
        color: "#f6ac62",
        indexLabel: "",
        columnWidth: 0.05,
        indexLabelPlacement: "outside",
        indexLabelFontSize: 12,
        toolTipContent: "{legendText}: ${y}",
        dataPoints: [
            { y: orderonlineSumJan , label: "Jan", id: "1"  },
            { y: orderonlineSumFeb, label: "Feb", id: "2" },
            { y: orderonlineSumMarch, label: "Mar", id: "3" },
            { y: orderonlineSumApr, label: "Apr", id: "4" },
            { y: orderonlineSumMay, label: "May", id: "5" },
            { y: orderonlineSumJun, label: "Jun", id: "6" },
            { y: orderonlineSumJul, label: "Jul", id: "7" },
            { y: orderonlineSumAug, label: "Aug", id: "8" },
            { y: orderonlineSumSep, label: "Sep", id: "9" },
            { y: orderonlineSumOct, label: "Oct", id: "10" },
            { y: orderonlineSumNov, label: "Nov", id: "11" },
            { y: orderonlineSumDec, label: "Dec", id: "12" }
        ]
    },
    {
        type: "stackedColumn",
        legendText: "Referral",
        showInLegend: true,
        color: "#9bf662",
        indexLabel: "",
        columnWidth: 0.05,
        indexLabelPlacement: "outside",
        indexLabelFontSize: 12,
        toolTipContent: "{legendText}: ${y}",
        dataPoints: [
            { y: orderreferralSumJan , label: "Jan", id: "1" },
            { y: orderreferralSumFeb, label: "Feb", id: "2" },
            { y: orderreferralSumMarch, label: "Mar", id: "3" },
            { y: orderreferralSumApr, label: "Apr", id: "4" },
            { y: orderreferralSumMay, label: "May", id: "5" },
            { y: orderreferralSumJun, label: "Jun", id: "6" },
            { y: orderreferralSumJul, label: "Jul", id: "7" },
            { y: orderreferralSumAug, label: "Aug", id: "8" },
            { y: orderreferralSumSep, label: "Sep", id: "9" },
            { y: orderreferralSumOct, label: "Oct", id: "10" },
            { y: orderreferralSumNov, label: "Nov", id: "11" },
            { y: orderreferralSumDec, label: "Dec", id: "12" }
        ]
    },
    {
        type: "stackedColumn",
        legendText: "Other",
        showInLegend: true,
        color: "#80E0FF",
        indexLabel: "",
        columnWidth: 0.05,
        indexLabelPlacement: "outside",
        indexLabelFontSize: 12,
        toolTipContent: "{legendText}: ${y}",
        dataPoints: [
            { y: orderOtherSumJanu , label: "Jan", id: "1" },
            { y: orderotherSumFeb, label: "Feb", id: "2" },
            { y: orderotherSumMarch, label: "Mar", id: "3" },
            { y: orderotherSumApr, label: "Apr", id: "4" },
            { y: orderotherSumMay, label: "May", id: "5" },
            { y: orderotherSumJun, label: "Jun", id: "6" },
            { y: orderotherSumJul, label: "Jul", id: "7" },
            { y: orderotherSumAug, label: "Aug", id: "8" },
            { y: orderotherSumSep, label: "Sep", id: "9" },
            { y: orderotherSumOct, label: "Oct", id: "10" },
            { y: orderotherSumNov, label: "Nov", id: "11" },
            { y: orderotherSumDec, label: "Dec", id: "12" }
        ]
    }
    ]
});

chart.render();

    chart.data.forEach(function(dp) {
        dp.dataPoints.forEach(function(point) {
            point.click = function(e) {
                // Access the ID of the clicked data point
                var monthSelect = e.dataPoint.id;
                const yearSelect = document.getElementById('yearSelect');
                var selectedYear = yearSelect.value;

                const yearSelectSummary = document.getElementById('yearSelectSummary');
                const monthSelectSummary = document.getElementById('monthSelectSummary');
                // Set the value of yearSelectSummary to the selectedYear
                yearSelectSummary.value = selectedYear;
                monthSelectSummary.value = monthSelect;

                fetchDataFromController();

                console.log("Clicked ID:", monthSelect);
                console.log("Year:", selectedYear);
            };
        });
    });

    // end bar graph

    // Pie chart

    var orderEmailPercent = {!! json_encode($emailPercentage) !!};
    var orderwalkingPercent = {!! json_encode($walkPercentage) !!};
    var orderonlinePercent = {!! json_encode($onlinePercentage) !!};
    var orderreferralPercent = {!! json_encode($referralPercentage) !!};
    var orderotherPercent = {!! json_encode($otherPercentage) !!};

    var currentTotalSale = {!! json_encode($currentTotalSale2) !!};

    var pieChart = new CanvasJS.Chart("chartPieGraph", {
        title:{
            text: "$ " + currentTotalSale,
            verticalAlign: "center",
            dockInsidePlotArea: true,
            fontColor: "gray",
            fontSize: 18,
            fontFamily: "arial"
        },
        legend:{
            verticalAlign: "bottom",
            horizontalAlign: "center"
        },
        data: [
            {
                indexLabelFontSize: 20,
                indexLabelFontFamily: "Garamond",
                indexLabelFontColor: "darkgrey",
                indexLabelLineColor: "darkgrey",
                indexLabelPlacement: "outside",
                type: "doughnut",
                showInLegend: false,
                innerRadius: "60%",
                toolTipContent: "{legendText}: {y}%",
                dataPoints: []
            }
        ]
    });

    // Function to add data points with non-zero values
    function addDataPoint(value, legendText, color) {
        if (value !== 0) {
            pieChart.options.data[0].dataPoints.push({ y: value, legendText: legendText, color: color });
        }
    }

    // Add data points based on priority

    if (orderEmailPercent != 0) {
        addDataPoint(orderEmailPercent, "Email Campaign", "#47D6B6");
    }
    if (orderwalkingPercent != 0) {
        addDataPoint(orderwalkingPercent, "Store Walking", "#47a3d6");
    }
    if (orderonlinePercent != 0) {
        addDataPoint(orderonlinePercent, "Online Inquiry", "#f6ac62");
    }
    if (orderreferralPercent != 0) {
        addDataPoint(orderreferralPercent, "Referral", "#9bf662");
    }
    if (orderotherPercent != 0) {
        addDataPoint(orderotherPercent, "Other", "#80E0FF");
    }

    // Render the chart
    pieChart.render();

    // end pie chart

    //Pie Chart table Details

    var emailSalePercentTd = document.getElementById("email_sale_percent");
    var walkSalePercentTd = document.getElementById("walk_sale_percent");
    var onlineSalePercentTd = document.getElementById("online_sale_percent");
    var referralSalePercentTd = document.getElementById("referral_sale_percent");
    var otherSalePercentTd = document.getElementById("other_sale_percent");

    emailSalePercentTd.textContent = orderEmailPercent;
    walkSalePercentTd.textContent = orderwalkingPercent;
    onlineSalePercentTd.textContent = orderonlinePercent;
    referralSalePercentTd.textContent = orderreferralPercent;
    otherSalePercentTd.textContent = orderotherPercent;

    var orderEmailTotal = {!! json_encode($currentEmailTotal2) !!};
    var orderwalkingTotal = {!! json_encode($currentWalkTotal2) !!};
    var orderonlineTotal = {!! json_encode($currentOnlineTotal2) !!};
    var orderreferralTotal = {!! json_encode($currentReferralTotal2) !!};
    var orderotherTotal = {!! json_encode($currentOtherotal2) !!};

    var emailSaleTotalTd = document.getElementById("email_sale_Total");
    var walkSaleTotalTd = document.getElementById("walk_sale_Total");
    var onlineSaleTotalTd = document.getElementById("online_sale_Total");
    var referralSaleTotalTd = document.getElementById("referral_sale_Total");
    var otherSaleTotalTd = document.getElementById("other_sale_Total");

    emailSaleTotalTd.textContent = orderEmailTotal;
    walkSaleTotalTd.textContent = orderwalkingTotal;
    onlineSaleTotalTd.textContent = orderonlineTotal;
    referralSaleTotalTd.textContent = orderreferralTotal;
    otherSaleTotalTd.textContent = orderotherTotal;

    var orderEmailCount = {!! json_encode($emailOrderPieCount) !!};
    var orderwalkingCount = {!! json_encode($walkOrderPieCount) !!};
    var orderonlineCount = {!! json_encode($onlineOrderPieCount) !!};
    var orderreferralCount = {!! json_encode($referralOrderPieCount) !!};
    var orderotherCount = {!! json_encode($otherOrderPieCount) !!};

    var emailSaleCountTd = document.getElementById("email_sale_count");
    var walkSaleCountTd = document.getElementById("walk_sale_count");
    var onlineSaleCountTd = document.getElementById("online_sale_count");
    var referralSaleCountTd = document.getElementById("referral_sale_count");
    var otherSaleCountTd = document.getElementById("other_sale_count");

    emailSaleCountTd.textContent = orderEmailCount;
    walkSaleCountTd.textContent = orderwalkingCount;
    onlineSaleCountTd.textContent = orderonlineCount;
    referralSaleCountTd.textContent = orderreferralCount;
    otherSaleCountTd.textContent = orderotherCount;
    //End Pie chart table details

}


    // Bar graph year selection
    const currentYear1 = new Date().getFullYear();
    const selectElement1 = document.getElementById('yearSelect');
    for (let year = currentYear1; year >= currentYear1 - 10; year--) {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        selectElement1.appendChild(option);
    }
    selectElement1.value = currentYear1;

    document.addEventListener('DOMContentLoaded', function() {
    const loader = document.querySelector('.loader');
    const leadChart = document.querySelector('.chartBarGraph');
    const yearSelect = document.getElementById('yearSelect');

    yearSelect.addEventListener('change', function() {
        // loader.classList.remove('hide');
        loadChart();
    });

    function loadChart() {
        var selectedYear = yearSelect.value;
        $.ajax({
            url: '{{ url('/barChartLead/') }}/' + selectedYear,
            method: 'GET',
            cache: false,
            beforeSend: function () {
                // Show loading spinner or indicator
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (data) {
                console.log(data);
                updateChart(data);
            },
            error: function (error) {
                console.log('Error fetching data:', error);
            },
            complete: function() {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    }


    function updateChart(data) {
        var chart = new CanvasJS.Chart("chartBarGraph", {
            title:{
                text: ""
            },
            axisY:{
                title: "Sales ($)",
                titleWrap: true,
                titleFontColor: "gray",
                valueFormatString: "#0.#,.",
                gridColor: "#eeeeee",
                titleFontSize: 18,
                labelFontSize: 14,
                labelFontColor: "gray",
                minimum: 0 // Set a minimum value for the y-axis
            },
            axisX:{
                valueFormatString: "#0.#,.",
                gridColor: "#eeeeee",
                titleFontSize: 18,
                labelFontSize: 14,
                labelFontColor: "gray"
            },
            legend: {
                verticalAlign: "top",
                horizontalAlign: "right",
                fontSize: 11,
                fontColor: "gray",
                fontWeight: 100
            },
            data: [
            {
                type: "stackedColumn",
                legendText: "Email Campaign",
                showInLegend: true,
                color: "#47D6B6",
                indexLabelFontSize: 12,
                toolTipContent: "{label}: ${y}",
                dataPoints: [
                    { y: data.orderEmailSumJanu, label: "Jan", id: "1" },
                    { y: data.orderEmailSumFebu, label: "Feb", id: "2" },
                    { y: data.orderEmailSumMarchu, label: "Mar", id: "3" },
                    { y: data.orderEmailSumApru, label: "Apr", id: "4"  },
                    { y: data.orderEmailSumMayu, label: "May", id: "5" },
                    { y: data.orderEmailSumJunu, label: "Jun", id: "6" },
                    { y: data.orderEmailSumJulu, label: "Jul", id: "7" },
                    { y: data.orderEmailSumAugu, label: "Aug", id: "8" },
                    { y: data.orderEmailSumSepu, label: "Sep", id: "9" },
                    { y: data.orderEmailSumOctu, label: "Oct", id: "10" },
                    { y: data.orderEmailSumNovu, label: "Nov", id: "11" },
                    { y: data.orderEmailSumDecu, label: "Dec", id: "12" }
                ]
            },
            {
                type: "stackedColumn",
                legendText: "Store Walking",
                showInLegend: true,
                color: "#47a3d6",
                indexLabel: "",
                toolTipContent: "{label}: ${y}",
                indexLabelPlacement: "outside",
                indexLabelFontSize: 12,
                dataPoints: [
                    { y: data.orderwalkingSumJanu , label: "Jan", id: "1" },
                    { y: data.orderwalkingSumFebu, label: "Feb", id: "2" },
                    { y: data.orderwalkingSumMarchu, label: "Mar", id: "3" },
                    { y: data.orderwalkingSumApru, label: "Apr", id: "4"  },
                    { y: data.orderwalkingSumMayu, label: "May", id: "5" },
                    { y: data.orderwalkingSumJunu, label: "Jun", id: "6" },
                    { y: data.orderwalkingSumJulu, label: "Jul", id: "7" },
                    { y: data.orderwalkingSumAugu, label: "Aug", id: "8" },
                    { y: data.orderwalkingSumSepu, label: "Sep", id: "9" },
                    { y: data.orderwalkingSumOctu, label: "Oct", id: "10" },
                    { y: data.orderwalkingSumNovu, label: "Nov", id: "11" },
                    { y: data.orderwalkingSumDecu, label: "Dec", id: "12" }
                ]
            },
            {
                type: "stackedColumn",
                legendText: "Online Inquiry",
                showInLegend: true,
                color: "#f6ac62",
                indexLabel: "",
                toolTipContent: "{label}: ${y}",
                indexLabelPlacement: "outside",
                indexLabelFontSize: 12,
                dataPoints: [
                    { y: data.orderonlineSumJanu , label: "Jan", id: "1" },
                    { y: data.orderonlineSumFebu, label: "Feb", id: "2" },
                    { y: data.orderonlineSumMarchu, label: "Mar", id: "3" },
                    { y: data.orderonlineSumApru, label: "Apr", id: "4"  },
                    { y: data.orderonlineSumMayu, label: "May", id: "5" },
                    { y: data.orderonlineSumJunu, label: "Jun", id: "6" },
                    { y: data.orderonlineSumJulu, label: "Jul", id: "7" },
                    { y: data.orderonlineSumAugu, label: "Aug", id: "8" },
                    { y: data.orderonlineSumSepu, label: "Sep", id: "9" },
                    { y: data.orderonlineSumOctu, label: "Oct", id: "10" },
                    { y: data.orderonlineSumNovu, label: "Nov", id: "11" },
                    { y: data.orderonlineSumDecu, label: "Dec", id: "12" }
                ]
            },
            {
                type: "stackedColumn",
                legendText: "Referral",
                showInLegend: true,
                color: "#9bf662",
                indexLabel: "",
                toolTipContent: "{label}: ${y}",
                indexLabelPlacement: "outside",
                indexLabelFontSize: 12,
                dataPoints: [
                    { y: data.orderreferralSumJanu , label: "Jan", id: "1" },
                    { y: data.orderreferralSumFebu, label: "Feb", id: "2" },
                    { y: data.orderreferralSumMarchu, label: "Mar", id: "3" },
                    { y: data.orderreferralSumApru, label: "Apr", id: "4" },
                    { y: data.orderreferralSumMayu, label: "May", id: "5" },
                    { y: data.orderreferralSumJunu, label: "Jun", id: "6" },
                    { y: data.orderreferralSumJulu, label: "Jul", id: "7" },
                    { y: data.orderreferralSumAugu, label: "Aug", id: "8" },
                    { y: data.orderreferralSumSepu, label: "Sep", id: "9" },
                    { y: data.orderreferralSumOctu, label: "Oct", id: "10" },
                    { y: data.orderreferralSumNovu, label: "Nov", id: "11" },
                    { y: data.orderreferralSumDecu, label: "Dec", id: "12" }
                ]
            },
            {
                type: "stackedColumn",
                legendText: "Other",
                showInLegend: true,
                color: "#80E0FF",
                indexLabel: "",
                toolTipContent: "{label}: ${y}",
                indexLabelPlacement: "outside",
                indexLabelFontSize: 12,
                dataPoints: [
                    { y: data.orderOtherSumJanu , label: "Jan", id: "1" },
                    { y: data.orderOtherSumfebu, label: "Feb", id: "2" },
                    { y: data.orderOtherSumMarchu, label: "Mar", id: "3" },
                    { y: data.orderOtherSumApru, label: "Apr", id: "4" },
                    { y: data.orderOtherSumMayu, label: "May", id: "5" },
                    { y: data.orderOtherSumJunu, label: "Jun", id: "6" },
                    { y: data.orderOtherSumJulu, label: "Jul", id: "7" },
                    { y: data.orderOtherSumAugu, label: "Aug", id: "8" },
                    { y: data.orderOtherSumSepu, label: "Sep", id: "9" },
                    { y: data.orderOtherSumOctu, label: "Oct", id: "10" },
                    { y: data.orderOtherSumNovu, label: "Nov", id: "11" },
                    { y: data.orderOtherSumDecu, label: "Dec", id: "12" }
                ]
            }
            ]
        });

    chart.render();

    chart.data.forEach(function(dp) {
        dp.dataPoints.forEach(function(point) {
            point.click = function(e) {
                // Access the ID of the clicked data point
                var monthSelect = e.dataPoint.id;
                const yearSelect = document.getElementById('yearSelect');
                var selectedYear = yearSelect.value;

                console.log("Clicked ID:", monthSelect);
                console.log("Year:", selectedYear);

                const yearSelectSummary = document.getElementById('yearSelectSummary');
                // const yearSelectPieChart = document.getElementById('yearSelectPieChart');
                const monthSelectSummary = document.getElementById('monthSelectSummary');
                // Set the value of yearSelectSummary to the selectedYear
                yearSelectSummary.value = selectedYear;
                // yearSelectPieChart.value = selectedYear;
                monthSelectSummary.value = monthSelect;

                fetchDataFromController();
                // reloadPieChart();

            };
        });
    });


    // $(".se-pre-con").fadeOut('slow');
    }
    });

    // summary year selection
    const currentYear2 = new Date().getFullYear();
    const selectElement2 = document.getElementById('yearSelectSummary');

    for (let year = currentYear2; year >= currentYear2 - 10; year--) {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        selectElement2.appendChild(option);
    }

    selectElement2.value = currentYear2;


    // Month selection Sammary
    const currentMonth = new Date().getMonth();

    const monthNames = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];

    const selectElement = document.getElementById('monthSelectSummary');

    for (let monthIndex = 0; monthIndex < 12; monthIndex++) {
        const option = document.createElement('option');
        option.value = monthIndex + 1;
        option.textContent = monthNames[monthIndex];
        selectElement.appendChild(option);
    }

    selectElement.value = currentMonth + 1;

    // pie graph year selection
    document.addEventListener('DOMContentLoaded', function () {
        const currentYear3 = new Date().getFullYear();
        const selectElement3 = document.getElementById('yearSelect');

        // Populate select options with years
        for (let year = currentYear3; year >= currentYear3 - 10; year--) {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            selectElement3.appendChild(option);
        }

        // Set default selected year to current year
        selectElement3.value = currentYear3;

        // Event listener for VIEW ORDERS button click
        const emailOrderButtons = document.querySelectorAll('.email_orders');
        const walkOrderButtons = document.querySelectorAll('.walk_orders');
        const onlineOrderButtons = document.querySelectorAll('.online_orders');
        const referralOrderButtons = document.querySelectorAll('.referral_orders');
        const otherOrderButtons = document.querySelectorAll('.other_orders');
        emailOrderButtons.forEach(button => {
            button.addEventListener('click', function () {
                const selectedYear = selectElement3.value;
                const category = '1';
                const pdfUrl = '{{ route("viewOrder_pdf") }}?year=' + selectedYear + '&category=' + category;
                window.open(pdfUrl, '_blank');
            });
        });
        walkOrderButtons.forEach(button => {
            button.addEventListener('click', function () {
                const selectedYear = selectElement3.value;
                const category = '2';
                const pdfUrl = '{{ route("viewOrder_pdf") }}?year=' + selectedYear + '&category=' + category;
                window.open(pdfUrl, '_blank');
            });
        });
        onlineOrderButtons.forEach(button => {
            button.addEventListener('click', function () {
                const selectedYear = selectElement3.value;
                const category = '3';
                const pdfUrl = '{{ route("viewOrder_pdf") }}?year=' + selectedYear + '&category=' + category;
                window.open(pdfUrl, '_blank');
            });
        });
        referralOrderButtons.forEach(button => {
            button.addEventListener('click', function () {
                const selectedYear = selectElement3.value;
                const category = '6';
                const pdfUrl = '{{ route("viewOrder_pdf") }}?year=' + selectedYear + '&category=' + category;
                window.open(pdfUrl, '_blank');
            });
        });
        otherOrderButtons.forEach(button => {
            button.addEventListener('click', function () {
                const selectedYear = selectElement3.value;
                const category = 'other';
                const pdfUrl = '{{ route("viewOrder_pdf") }}?year=' + selectedYear + '&category=' + category;
                window.open(pdfUrl, '_blank');
            });
        });
    });



    // default table load
    var emailOrders = {!! json_encode($emailOrders) !!};
    console.log(emailOrders);
    if (emailOrders && typeof emailOrders === 'object') {
        // Check if emailOrders is an object
        var tableBody = document.querySelector('#order_sammary tbody');
        tableBody.innerHTML = '';

        var totalOrderTotal = 0;
        var totalOrderItems = 0;

        // Iterate over the object keys (assuming each key is an object representing an order)
        Object.keys(emailOrders).forEach(key => {
            var order = emailOrders[key];

            var totalItems;
            if (order.order_items && Array.isArray(order.order_items)) {
                totalItems = order.order_items.length;
            }

            var leadSource = order.organization_details.lead_source;
                var leadSourceName;
                if (leadSource == 1 ) {
                    leadSourceName = 'Email Campaign'
                } else if (leadSource == 2) {
                    leadSourceName = 'Store Walk in'
                } else if (leadSource == 3) {
                    leadSourceName = 'Online Enquiries'
                } else if (leadSource == 6) {
                    leadSourceName = 'Referral'
                } else {
                    leadSourceName = 'Other'
                }

            var organization = order.organization_details;
            var row = `
                <tr>
                    <td class="table-bottom-details2"><a href="#" class="edit-order" data-value="${order.id}">${order.order_no}</a></td>
                    <td class="table-bottom-details2">${leadSourceName}</td>
                    <td class="table-bottom-details2">${order.open_date}</td>
                    <td class="table-bottom-details2">${order.due_date}</td>
                    <td class="table-bottom-details2">${organization.organization_name}</td>
                    <td class="table-bottom-details2">${totalItems}</td>
                    <td class="table-bottom-details2" style="text-align: right;">${order.order_total}</td>
                </tr>
            `;

            totalOrderTotal += parseFloat(order.order_total);
            totalOrderItems += parseFloat(totalItems);

            tableBody.innerHTML += row;
        });

        var formattedTotal = totalOrderTotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

        var totalRow = `
            <tr style="background-color: #F5F5F5;">
                <td colspan="5" class="text-right table-bottom-details2" >Total:</td>
                <td class="table-bottom-details2">${totalOrderItems}</td>
                <td class="table-bottom-details2" style="text-align: right;">${formattedTotal}</td>
            </tr>
        `;
        tableBody.innerHTML += totalRow;

    } else {
        console.error('emailOrders is not an object.');
    }
// end default table load

// Change table related with selection
var emailOrders = [];
var ordersPerPage = 10; // Default number of orders per page
var currentPage = 1; // Initialize current page

function fetchDataFromController() {
    var selectedYear = document.getElementById('yearSelectSummary').value;
    var selectedMonth = document.getElementById('monthSelectSummary').value;
    var selectedCategory = document.getElementById('catagoryOption').value;

    $.ajax({
        url: '{{ route('leadRepostTable') }}',
        method: 'GET',
        data: {
            year: selectedYear,
            month: selectedMonth,
            category: selectedCategory
        },
        beforeSend: function () {
            $(".se-pre-con").fadeIn('slow');
        },
        success: function (data) {
            console.log('Fetched data:', data);

            // Ensure emailOrders is an array
            if (Array.isArray(data.emailOrders)) {
                emailOrders = data.emailOrders; // Store fetched data
            } else {
                emailOrders = Object.values(data.emailOrders); // Convert to array if needed
            }

            currentPage = 1; // Reset to first page
            showOrders(currentPage, emailOrders);
        },
        error: function (error) {
            console.log('Error fetching data:', error);
        },
        complete: function() {
            $(".se-pre-con").fadeOut('slow');
        }
    });
}

function showOrders(page, data) {
    var tableBody = document.querySelector('#order_sammary tbody');
    tableBody.innerHTML = '';
    var totalOrderTotal = 0;
    var totalOrderItems = 0;

    var startIndex = (page - 1) * ordersPerPage;
    var endIndex = startIndex + ordersPerPage;
    var totalPages = Math.ceil(data.length / ordersPerPage);

    for (var i = startIndex; i < endIndex && i < data.length; i++) {
        var order = data[i];
        var totalItems = order.order_items && Array.isArray(order.order_items) ? order.order_items.length : 0;
        var organization = order.organization_details;
        var leadSource = order.organization_details.lead_source;
        var leadSourceName;

        switch (leadSource) {
            case 1:
                leadSourceName = 'Email Campaign';
                break;
            case 2:
                leadSourceName = 'Store Walk in';
                break;
            case 3:
                leadSourceName = 'Online Enquiries';
                break;
            case 6:
                leadSourceName = 'Referral';
                break;
            default:
                leadSourceName = 'Other';
        }

        var row = `
            <tr>
                <td class="table-bottom-details2"><a href="#" class="edit-order" data-value="${order.id}">${order.order_no}</a></td>
                <td class="table-bottom-details2">${leadSourceName}</td>
                <td class="table-bottom-details2">${order.open_date}</td>
                <td class="table-bottom-details2">${order.due_date}</td>
                <td class="table-bottom-details2">${organization.organization_name}</td>
                <td class="table-bottom-details2">${totalItems}</td>
                <td class="table-bottom-details2" style="text-align: right;">${order.order_total}</td>
            </tr>
        `;

        totalOrderTotal += parseFloat(order.order_total);
        totalOrderItems += parseFloat(totalItems);

        tableBody.innerHTML += row;
    }

    var formattedTotal = totalOrderTotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    var totalRow = `
        <tr style="background-color: #F5F5F5;">
            <td colspan="5" class="text-right table-bottom-details2">Total:</td>
            <td class="table-bottom-details2">${totalOrderItems}</td>
            <td class="table-bottom-details2" style="text-align: right;">${formattedTotal}</td>
        </tr>
    `;
    tableBody.innerHTML += totalRow;

    updatePagination(totalPages, currentPage);
}

var paginationBar = document.getElementById('paginationbar');
function updatePagination(totalPages, currentPage) {
    paginationBar.innerHTML = '';
    var pagination = '<nav aria-label="Page navigation"><ul class="pagination">';
    // Previous button
    pagination += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
        <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">&laquo;</a></li>`;
    // Page numbers range
    var startPage = Math.max(1, currentPage - 5);
    var endPage = Math.min(totalPages, currentPage + 5);
    if (startPage > 1) {
        pagination += `<li class="page-item"><a class="page-link" href="#" onclick="changePage(1)">1</a></li>`;
        if (startPage > 2) {
            pagination += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
    }
    for (var i = startPage; i <= endPage; i++) {
        pagination += `<li class="page-item ${i === currentPage ? 'active' : ''}">
            <a class="page-link" href="#" onclick="changePage(${i})">${i}</a></li>`;
    }
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            pagination += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
        pagination += `<li class="page-item"><a class="page-link" href="#" onclick="changePage(${totalPages})">${totalPages}</a></li>`;
    }
    // Next button
    pagination += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
        <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">&raquo;</a></li>`;
    pagination += '</ul></nav>';
    paginationBar.innerHTML = pagination;
}

function changePage(event, page) {
    event.preventDefault(); // Prevent the default anchor click behavior
    if (page < 1) page = 1;
    var totalPages = Math.ceil(emailOrders.length / ordersPerPage);
    if (page > totalPages) page = totalPages;
    currentPage = page;
    showOrders(currentPage, emailOrders);

    var table = document.getElementById('scrollTable');
    table.scrollIntoView({ behavior: 'smooth', block: 'start' });

}

function changeOrdersPerPage() {
    ordersPerPage = parseInt(document.getElementById('ordersPerPage').value);
    currentPage = 1; // Reset to first page
    showOrders(currentPage, emailOrders);
}


// Add change event listeners to select boxes
document.getElementById('yearSelectSummary').addEventListener('change', fetchDataFromController);
document.getElementById('monthSelectSummary').addEventListener('change', fetchDataFromController);
document.getElementById('catagoryOption').addEventListener('change', fetchDataFromController);

// End Change table related with selection

//Update Pie Chart
function reloadPieChart() {
    const loaderPie = document.querySelector('.loaderPie');

    var selectedYear = document.getElementById('yearSelect').value;
    console.log(selectedYear);
    $.ajax({
        url: '{{ url('/pieChartLead/') }}/' + selectedYear,
        method: 'GET',
        cache: false,
        beforeSend: function () {
            // Show loading spinner or indicator
            // $(".se-pre-con").fadeIn('slow');
        },
        success: function (data) {
            console.log(data);
            updatePieChart(data);

            var emailSalePercentTd = document.getElementById("email_sale_percent");
            var walkSalePercentTd = document.getElementById("walk_sale_percent");
            var onlineSalePercentTd = document.getElementById("online_sale_percent");
            var referralSalePercentTd = document.getElementById("referral_sale_percent");
            var otherSalePercentTd = document.getElementById("other_sale_percent");

            emailSalePercentTd.textContent = data.emailPercentage;
            walkSalePercentTd.textContent = data.walkPercentage;
            onlineSalePercentTd.textContent = data.onlinePercentage;
            referralSalePercentTd.textContent = data.referralPercentage;
            otherSalePercentTd.textContent = data.otherPercentage;

            var emailSaleTotalTd = document.getElementById("email_sale_Total");
            var walkSaleTotalTd = document.getElementById("walk_sale_Total");
            var onlineSaleTotalTd = document.getElementById("online_sale_Total");
            var referralSaleTotalTd = document.getElementById("referral_sale_Total");
            var otherSaleTotalTd = document.getElementById("other_sale_Total");

            emailSaleTotalTd.textContent = data.currentEmailTotal2;
            walkSaleTotalTd.textContent = data.currentWalkTotal2;
            onlineSaleTotalTd.textContent = data.currentOnlineTotal2;
            referralSaleTotalTd.textContent = data.currentReferralTotal2;
            otherSaleTotalTd.textContent = data.currentOtherTotal2;

            var emailSaleCountTd = document.getElementById("email_sale_count");
            var walkSaleCountTd = document.getElementById("walk_sale_count");
            var onlineSaleCountTd = document.getElementById("online_sale_count");
            var referralSaleCountTd = document.getElementById("referral_sale_count");
            var otherSaleCountTd = document.getElementById("other_sale_count");

            emailSaleCountTd.textContent = data.emailOrderPieCount;
            walkSaleCountTd.textContent = data.walkOrderPieCount;
            onlineSaleCountTd.textContent = data.onlineOrderPieCount;
            referralSaleCountTd.textContent = data.referralOrderPieCount;
            otherSaleCountTd.textContent = data.otherOrderPieCount;
        },
        error: function (error) {
            console.log('Error fetching data:', error);
            updatePieChartError();
            // Set all values to '0'
            document.getElementById("email_sale_percent").textContent = '0';
            document.getElementById("walk_sale_percent").textContent = '0';
            document.getElementById("online_sale_percent").textContent = '0';
            document.getElementById("referral_sale_percent").textContent = '0';
            document.getElementById("other_sale_percent").textContent = '0';

            document.getElementById("email_sale_Total").textContent = '0';
            document.getElementById("walk_sale_Total").textContent = '0';
            document.getElementById("online_sale_Total").textContent = '0';
            document.getElementById("referral_sale_Total").textContent = '0';
            document.getElementById("other_sale_Total").textContent = '0';

            document.getElementById("email_sale_count").textContent = '0';
            document.getElementById("walk_sale_count").textContent = '0';
            document.getElementById("online_sale_count").textContent = '0';
            document.getElementById("referral_sale_count").textContent = '0';
            document.getElementById("other_sale_count").textContent = '0';
        },
        complete: function() {
            // $(".se-pre-con").fadeOut('slow');
        }
    });
}

document.getElementById('yearSelect').addEventListener('change', reloadPieChart);

function updatePieChart(data) {

    var pieChart = new CanvasJS.Chart("chartPieGraph",
    {
        title:{
            text: "$ " + data.currentTotalSale2,
            verticalAlign: "center",
            dockInsidePlotArea: true,
            fontColor: "gray",
            fontSize: 18,
            fontFamily: "arial"
        },

        legend:{
            verticalAlign: "bottom",
            horizontalAlign: "center"
        },
        data: [
            {
                indexLabelFontSize: 20,
                indexLabelFontFamily: "Garamond",
                indexLabelFontColor: "darkgrey",
                indexLabelLineColor: "darkgrey",
                indexLabelPlacement: "outside",
                type: "doughnut",
                showInLegend: false,
                innerRadius: "60%",
                toolTipContent: "{legendText}: {y}%",
                dataPoints: []
            }
        ]
    });
    // Function to add data points with non-zero values
    function addDataPoint(value, legendText, color) {
        if (value !== 0) {
            pieChart.options.data[0].dataPoints.push({ y: value, legendText: legendText, color: color });
        }
    }

    // Add data points based on priority

    if (data.emailPercentage != 0) {
        addDataPoint(data.emailPercentage, "Email Campaign", "#47D6B6");
    }
    if (data.walkPercentage != 0) {
        addDataPoint(data.walkPercentage, "Store Walking", "#47a3d6");
    }
    if (data.onlinePercentage != 0) {
        addDataPoint(data.onlinePercentage, "Online Inquiry", "#f6ac62");
    }
    if (data.referralPercentage != 0) {
        addDataPoint(data.referralPercentage, "Referral", "#9bf662");
    }
    if (data.otherPercentage != 0) {
        addDataPoint(data.otherPercentage, "Other", "#80E0FF");
    }

    pieChart.render();


    // $(".se-pre-con").fadeOut('slow');
}

function updatePieChartError() {

    var pieChart = new CanvasJS.Chart("chartPieGraph",
    {
        title:{
            text: "$ " + '0',
            verticalAlign: "center",
            dockInsidePlotArea: true,
            fontColor: "gray",
            fontSize: 18,
            fontFamily: "arial"
        },

        legend:{
            verticalAlign: "bottom",
            horizontalAlign: "center"
        },
        data: [
            {
                indexLabelFontSize: 20,
                indexLabelFontFamily: "Garamond",
                indexLabelFontColor: "darkgrey",
                indexLabelLineColor: "darkgrey",
                indexLabelPlacement: "outside",
                type: "doughnut",
                showInLegend: false,
                innerRadius: "60%",
                toolTipContent: "{legendText}: {y}%",
                dataPoints: [
                    {  y: '0', legendText:"Email Campaign", color: "#47D6B6" },
                    {  y: '0', legendText:"Store Walking", color: "#4debc7"  },
                    {  y: '0', legendText:"Online Inquiry", color: "#67e4c8"  },
                    {  y: '0', legendText:"Referral", color: "#B5EFE2"  },
                    {  y: '0', legendText:"Other", color: "#80E0FF"  }
                ]
            }
        ]
    });

    pieChart.render();

    // $(".se-pre-con").fadeOut('slow');
}

//End update pie chart


document.addEventListener('DOMContentLoaded', function () {


        var downloadBtn = document.querySelector('.export_btn');
        downloadBtn.addEventListener('click', function () {

            var selectedYear = document.getElementById('yearSelectSummary').value;
            var selectedMonth = document.getElementById('monthSelectSummary').value;
            var selectedCategory = document.getElementById('catagoryOption').value;
// console.log(selectedYear);
            var routeUrl = "{{ url('/reportCSV_Download_withMonth/') }}" + '/' + selectedYear  + '/' + selectedCategory + '/' + selectedMonth;

            // Redirect or perform an action with the generated route URL
            window.location.href = routeUrl;
        });
    });

    $(document).ready(function(){
        $(".se-pre-con").fadeOut('slow');
    });


    $("body").on("click", ".edit-order", function(){
        // $(".se-pre-con").fadeIn('slow');
        var orderId = $(this).data('value');
        // window.location.replace('order_details/edit/'+orderId+'/order?active_tab=order');
        window.open('order_details/edit/'+orderId+'/order?active_tab=order', '_blank');
    });

</script>

@endsection
