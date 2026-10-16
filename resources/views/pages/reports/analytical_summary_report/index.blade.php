@extends('layouts.app', ['activePage' => 'analytical_summary_report', 'titlePage' => __('Analytical Summary Report')])

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
        border-radius: 20px;
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
    .font_color{
        color:#818181;
    }
    .select2-selection__rendered{
        color: #47D6B6 !important;
        font-size: 11px !important;
    }
    .feather {
        width: 25px;
        height: 25px;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: none;
        }
    .filter_btn {
        padding: 4px;
        text-align: center;
        width: 70px;
        padding-right: 6px;
        background-color: rgb(0, 254, 0);
        border-radius: 5px;
        cursor: pointer;
        color: white !important;

    }
    .multiselect {
        background-color: unset !important;
        color: #8898aa !important;
        font-size: 11px;
        font-weight: unset !important;
        border: unset !important;
        box-shadow: unset !important;
        padding: .425rem 0.5rem !important;
    }
    .dropdown-menu {
        min-width: 15rem;
        font-size: 13px;

    }
    .multiselect-container>li>a>label{
        width: 100%;
        color: #000000 !important;
        padding: 3px 20px 3px 20px !important;
    }
</style>
<script src="https://unpkg.com/feather-icons"></script>
<div class=" mb-5 content-position">

    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Analytical Summary Report</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12" style="margin-top: 15px; margin-bottom: 25px; padding-bottom: 20px;" id="scrollTable">
        <div class="card" style="border: unset;">
            <div class="row" style="margin: 10px;">
<div class="col-10 d-flex flex-wrap">
                <div class="row filter_row" style="padding-bottom: 2px;margin:5px">
                    <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">Start Date |  </p>
                    <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                        <input type="text" name="start_date" class="summary-datepicker invoice-inputs" style="height: 2rem;background-color:#F8F8F8;width: 100px;color:#47D6B6" id="start_date">
                    </div>
                </div>
                <div class="row " style="padding-bottom: 2px;margin:5px">
                    <h4 class="charIco d_flex_and_align_center" style="padding-left: 5px;margin-bottom: unset;color:#B3B3B3"> → </h4>

                </div>
                <div class="row filter_row" style="padding-bottom: 2px;margin:5px">
                    <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">End Date |  </p>
                    <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                        <input type="text" name="end_date" class="summary-datepicker invoice-inputs" style="height: 2rem;background-color:#F8F8F8;width: 100px;color:#47D6B6" id="end_date">
                    </div>
                </div>
                <div class="row " style="padding-bottom: 2px;margin:5px">
                    <h4 class="charIco d_flex_and_align_center" style="padding-left: 5px;margin-bottom: unset;color:#B3B3B3"> | </h4>
                </div>
                <div class="row filter_row" style="padding-bottom: 2px;margin:5px">
                    <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">Report Type</p>
                    <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                        <select id="ReportTypes" class="date_selection">
                            <option value="1">Sales Reps</option>
                            <option value="2">Sports</option>
                            <option value="3">Factory</option>
                            <option value="4">Lead Source</option>
                            <option value="5">New vs Repeated Customers</option>
                            <option value="6">Geographical Breakdown</option>
                            <option value="7">Team Store vs Bulk Orders</option>
                        </select>
                    </div>
                </div>
                <div class="row filter_row" style="padding-bottom: 2px;margin:5px">
                    <select name="order_types[]" multiple id="Order_types">
                        <optgroup label="All Orders">
                            <option class="all" value="all" selected>ALL ORDERS</option>
                            <option class="Bulk ml-3" value="Bulk" selected>BULK ORDERS</option>
                            <option class="TSR ml-3" value="TSR" selected>TSR ORDERS</option>
                            <option class="Wl ml-3" value="Wl" selected>WL ORDERS</option>
                        </optgroup>
                        <optgroup label="Internal">
                            <option class="ITO" value="ITO">INTERNAL TEAM ORDERS</option>
                        </optgroup>
                    </select>
                </div>
                    <div class="row filter_row" style="padding-bottom: 2px;margin:5px">
                    {{-- <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">Report Type</p> --}}
                    <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                        <select id="ReportTypes_cal_date" class="date_selection">
                            <option value="production_date" selected>Based on Production Date</option>
                            <option value="ex_factory_date">Based on Ex-factory Date</option>

                        </select>
                    </div>
                </div>
                <div class="row filter_row" style="padding-bottom: 2px;margin:5px ">
                    <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;cursor: pointer;" id="filterButton"><i class="fa fa-filter " style="padding-right: 5px;"></i> Filter </p>

                </div>
            </div>

                <div class="row align-items-start" style="padding-bottom: 2px;margin:5px;margin-left:auto">
                    <h4 id="export_button" class="charIco d_flex_and_align_center" style="padding-left: 5px;margin-bottom: unset;color:#B3B3B3;font-size:11px;cursor: pointer;"><i class="fa fa-download mx-2" aria-hidden="true"></i> EXPORT REPORT </h4>
                </div>
            </div>
        </div>
    </div>
    {{-- report content --}}
    <div class="col-md-12" style="margin-top: 15px; margin-bottom: 25px; padding-bottom: 20px;" id="scrollTable2">
        <div class="card" style="border: unset;">
            <div class="row" style="margin: 10px;">
                <div class="col">
                    <h3 class="" style="margin-bottom: unset;" id="Reporthedding">Analytical Summary Report For Sales Reps</h3>
                </div>
                <div class="font_color" style="padding-right: 2px;" id="toggleChart">
                    <i class="fa fa-table mx-1" aria-hidden="true" onclick="togglecharttable(0)"></i> | <i class="fa fa-bar-chart ml-1" aria-hidden="true" onclick="togglecharttable(1)"></i>
                </div>
            </div>
            <div class="row justify-content-end" style="margin: 10px;padding: 10px;background-color:#fafafa ;" >
                <div class="col-4 d-flex justify-content-end" style="padding-right: unset">
                    <table>
                        <tr>
                            <td rowspan="2" class="px-2  font_color" style="background-color: #eeeeee;border-radius: 10px;"><i data-feather="shopping-cart"></i></td>
                            <td class="px-2"> <h5 style="margin-bottom: unset;" class="">Total Orders</h5> </td>
                        </tr>
                        <tr>
                            <td class="px-2"><p style="margin-bottom: unset;" class="font_color" id=totalordershow>00</p></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td rowspan="2" class="px-2 py-2 font_color" style="background-color: #eeeeee;border-radius: 10px;"><i data-feather="bar-chart"></i></td>
                            <td class="px-2"> <h5 style="margin-bottom: unset;" class="">Total Revenue</h5> </td>
                        </tr>
                        <tr>
                            <td class="px-2"><p style="margin-bottom: unset;" class="font_color"  id="totalrevenueshow">$00</p></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row" style="margin: 10px;" id="rep_order_summary_table_div">
                <div class="col-12">
                    <div class="order_rep_sammary_table tablediv" id="order_rep_sammary_table_div" >
                        <table class="table align-items-center" id="rep_order_summary" style="min-width: 100%;">

                            <thead style="background-color: #717070;">
                                <th scope="col"></th> <!-- For Expand/Collapse -->
                                <th scope="col" class="table_header_text">NO</th>
                                <th scope="col" class="table_header_text">SALES REP</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">TS ORDERS</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">BULK ORDERS</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">WL ORDERS</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">INTERNAL ORDERS</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">TOTAL ORDERS</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">REVENUE ($)</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">NEW ORDERS</th>
                                <th scope="col" class="table_header_text" style="text-align: center !important;">REVENUE PRECENTAGE </th>

                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                    <div class="order_sport_sammary_table tablediv" id="order_sport_sammary_table_div">
                        <table class="table align-items-center" id="sport_order_summary" style="min-width: 100%;">

                            <thead style="background-color: #717070;">
                                <th scope="col"></th> <!-- For Expand/Collapse -->
                                <th scope="col" class="table_header_text">NO</th>
                                <th scope="col" class="table_header_text">SPORTS</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">TS ORDERS</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">BULK ORDERS</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">WL ORDERS</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">INTERNAL ORDERS</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">TOTAL ORDERS</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">REVENUE ($)</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">NEW ORDERS</th>
                                <th scope="col" class="table_header_text" style="text-align: center !important;">REVENUE PRECENTAGE </th>

                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                    <div class="order_lead_sammary_table tablediv" id="order_LeadSource_sammary_table_div">
                        <table class="table align-items-center" id="lead_order_summary" style="min-width: 100%;">

                            <thead style="background-color: #717070;">
                                <th scope="col"></th> <!-- For Expand/Collapse -->
                                <th scope="col" class="table_header_text">NO</th>
                                <th scope="col" class="table_header_text">LEAD SOURCE</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">TS ORDERS</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">BULK ORDERS</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">WL ORDERS</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">INTERNAL ORDERS</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">TOTAL ORDERS</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">REVENUE ($)</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">NEW ORDERS</th>
                                <th scope="col" class="table_header_text" style="text-align: center !important;">REVENUE PRECENTAGE </th>

                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                    <div class="order_factory_sammary_table tablediv" id="order_factory_sammary_table_div">
                        <table class="table align-items-center" id="factory_order_summary" style="min-width: 100%;">

                            <thead style="background-color: #717070;">
                                {{-- <th scope="col"></th> <!-- For Expand/Collapse --> --}}
                                <th scope="col" class="table_header_text">NO</th>
                                <th scope="col" class="table_header_text">FACTORY</th>
                                {{-- <th scope="col" class="table_header_text" style="text-align: right;">TS ORDERS</th> --}}
                                {{-- <th scope="col" class="table_header_text" style="text-align: right;">BULK ORDERS</th> --}}
                                <th scope="col" class="table_header_text" style="text-align: right;">TOTAL ITEMS</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">REVENUE ($)</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">NEW ORDERS</th>
                                <th scope="col" class="table_header_text" style="text-align: center !important;">REVENUE PRECENTAGE </th>

                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                    <div class="order_tsvsbulk_sammary_table tablediv" id="order_tsvsbulk_sammary_table_div">
                        <div class="row">

                            <div class="col-6">
                                <canvas id="TSvsBULK" style="width: auto"></canvas>
                            </div>
                            <div class="col-6 my-auto">
                                <table style="width:100%">
                                    <tr>
                                        <th></th>
                                        <th class="text-center"><h2>TS Orders</h2></th>
                                        <th class="text-center"><h2>Bulk Orders</h2></th>
                                    </tr>
                                    <tr>
                                        <td class="text-center"> <h3>ORDERS</h3> </td>
                                        <td class="text-center"> <p id="tsordercount">00</p></td>
                                        <td class="text-center"><p id="bulkordercount">00</p></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><h3>REVENUE ($)</h3></td>
                                        <td class="text-center"><p id="tsorderrevenue">00.00</p></td>
                                        <td class="text-center"><p id="bulkorderrevenue">00.00</p></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="order_newvsold_cu_sammary_table tablediv" id="order_newvsold_cu_sammary_table_div">
                        <div class="row">

                            <div class="col-4">
                                <canvas id="newvsold" style="width: auto"></canvas>
                            </div>
                            <div class="col-8 my-auto">
                                <table style="width:100%">
                                    <tr>
                                        <th></th>
                                        <th class="text-center"><h5>#CUSTOMERS</h2></th>
                                        <th class="text-center"><h5>CUSTOMERS (%)</h5></th>
                                        <th class="text-center"><h5>TS ORDERS</h5></th>
                                        <th class="text-center"><h5>BULK ORDERS</h5></th>
                                        <th class="text-center"><h5>#ORDERS</h5></th>
                                        <th class="text-center"><h5>REVENUE ($)</h5></th>
                                    </tr>
                                    <tr>
                                        <td > <h4>New Customers</h4> </td>
                                        <td class="text-center"> <p id="new_cuscount">00</p></td>
                                        <td class="text-center"><p id="new_cuscount_precentage">00</p></td>
                                        <td class="text-center"><p id="new_custscount">00</p></td>
                                        <td class="text-center"><p id="new_cusbulkcount">00</p></td>
                                        <td class="text-center"><p id="new_custotcount">00</p></td>
                                        <td class="text-center"><p id="new_cusrevenue">00</p></td>
                                    </tr>
                                    <tr>
                                        <td ><h4>Repeated Customers</h4></td>
                                        <td class="text-center"> <p id="rep_cuscount">00</p></td>
                                        <td class="text-center"><p id="rep_cuscount_precentage">00</p></td>
                                        <td class="text-center"><p id="rep_custscount">00</p></td>
                                        <td class="text-center"><p id="rep_cusbulkcount">00</p></td>
                                        <td class="text-center"><p id="rep_custotcount">00</p></td>
                                        <td class="text-center"><p id="rep_cusrevenue">00</p></td>
                                    </tr>
                                    <tr>
                                        <td ><h4>Totals</h4></td>
                                        <td class="text-center"> <p id="tot_cuscount">00</p></td>
                                        <td class="text-center"><p id="tot_cuscount_precentage"></p></td>
                                        <td class="text-center"><p id="tot_custscount">00</p></td>
                                        <td class="text-center"><p id="tot_cusbulkcount">00</p></td>
                                        <td class="text-center"><p id="tot_custotcount">00</p></td>
                                        <td class="text-center"><p id="tot_cusrevenue">00</p></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="order_geoChart_sammary_table tablediv" id="order_geoChart_sammary_table_div">
                        {{-- <div class="row">

                            <div class="col-12">
                                <canvas id="geoChart" width="800" height="500"></canvas>
                            </div>

                        </div> --}}
                        <table class="table align-items-center" id="geoChart_order_summary" style="min-width: 100%;">

                            <thead style="background-color: #717070;">
                                <th scope="col"></th> <!-- For Expand/Collapse -->
                                <th scope="col" class="table_header_text">NO</th>
                                <th scope="col" class="table_header_text">COUNTRY</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">TS ORDERS</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">BULK ORDERS</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">TOTAL ORDERS</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">REVENUE ($)</th>
                                <th scope="col" class="table_header_text" style="text-align: right;">NEW ORDERS</th>
                                <th scope="col" class="table_header_text" style="text-align: center !important;">REVENUE PRECENTAGE </th>

                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="row" style="margin: 10px;display:none" id="rep_order_summary_chart_div">
                <div class="col-12" >
                    <div class="order_rep_sammary_chart" style="">
                        <canvas id="salesRepChart" style="width: auto"></canvas>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/topojson-client@3.1.0"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Chart.js Library -->

<script src="https://cdn.jsdelivr.net/npm/chartjs-chart-geo@4.0.0"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js"></script>
<script>
    $('#Order_types').multiselect({
        buttonText: function() {
            return 'Order Types'; // Always show "Order Types"
        },
        includeSelectAllOption: false, // Add "Select All" option
        nonSelectedText: 'Order Types', // Placeholder when nothing is selected
        allSelectedText: 'Order Types', // Prevents selection count
        enableFiltering: false // DISABLES SEARCH
    });
    feather.replace();
    $('.summary-datepicker').datepicker();
    $('#ReportTypes').select2();
    $('#ReportTypes_cal_date').select2();
    setDates();
    function hideDiv(){
        let searchDivs = document.querySelectorAll('.tablediv');

        // Hide all matched divs
        searchDivs.forEach(function(div) {
            console.log('vuvu');

            div.style.display = 'none';
        });
    }
    function togglecharttable(val){
        let selectedValue = $('#ReportTypes').val(); // Selected value
        if(val==1){
            $('#rep_order_summary_table_div').hide();
            $('#rep_order_summary_chart_div').show();
        }else{
            $('#rep_order_summary_chart_div').hide();
            $('#rep_order_summary_table_div').show();
        }
    }
    function formatDate(date) {
        var day = String(date.getDate()).padStart(2, '0');
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var year = date.getFullYear();
        return month + '/' + day + '/' + year;
    }

    function setDates() {
        var startDate, endDate;
        var currentDate = new Date();

        // startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
        startDate =  new Date(currentDate.getFullYear(), 0, 1);
        endDate = currentDate; // Use today's date as the end date


        if (startDate) {
            $('#start_date').val(formatDate(startDate));
        }
        if (endDate) {
            $('#end_date').val(formatDate(endDate));
        }

    }
    $(document).ready(function() {

        var rep_table = $('#rep_order_summary').DataTable({
            "paging": true,
            scrollX: true,
            "pageLength": 40,
            "searching": false,
            "ordering": true,
            "info": false,
            "lengthChange": false,
            "columnDefs": [{
                        "targets": [6,7],
                        "className": "text-right"
                    },
                    {
                        "targets": [0,2,3,4,5],
                        "className": "text-center"
                    },
                    {
                        "targets": [-1],
                        "className": "text-center",
                        "createdCell": function(td, cellData, rowData, row, col) {
                                // Apply the class only to <td> (not <th>)
                                if (row >= 0) {  // Ensure this applies only to table body rows
                                    $(td).addClass("d-flex align-items-center justify-content-end");
                                }
                            }
                    },
                    { "orderable": false, "targets": 0 } // Disable sorting for the last column
                    ]
        });
        var factory_table = $('#factory_order_summary').DataTable({
            "paging": true,
            scrollX: true,
            "pageLength": 40,
            "searching": false,
            "ordering": true,
            "info": false,
            "lengthChange": false,
            "columnDefs": [
                    {
                        "targets": [0,2,3,4],
                        "className": "text-center"
                    },
                    {
                        "targets": [-1],
                        "className": "text-center",
                        "createdCell": function(td, cellData, rowData, row, col) {
                                // Apply the class only to <td> (not <th>)
                                if (row >= 0) {  // Ensure this applies only to table body rows
                                    $(td).addClass("d-flex align-items-center justify-content-end");
                                }
                            }
                    },
                    { "orderable": false, "targets": 0 } // Disable sorting for the last column
                    ]
        });
        var sport_table = $('#sport_order_summary').DataTable({
            "paging": true,
            scrollX: true,
            "pageLength": 40,
            "searching": false,
            "ordering": true,
            "info": false,
            "lengthChange": false,
            "columnDefs": [{
                        "targets": [6,7],
                        "className": "text-right"
                    },
                    {
                        "targets": [0,2,3,4,5],
                        "className": "text-center"
                    },
                    {
                        "targets": [-1],
                        "className": "text-center",
                        "createdCell": function(td, cellData, rowData, row, col) {
                                // Apply the class only to <td> (not <th>)
                                if (row >= 0) {  // Ensure this applies only to table body rows
                                    $(td).addClass("d-flex align-items-center justify-content-end");
                                }
                            }
                    },
                    { "orderable": false, "targets": 0 } // Disable sorting for the last column
                    ]
        });
        var lead_table = $('#lead_order_summary').DataTable({
            "paging": true,
            scrollX: true,
            "pageLength": 40,
            "searching": false,
            "ordering": true,
            "info": false,
            "lengthChange": false,
            "columnDefs": [{
                        "targets": [6,7],
                        "className": "text-right"
                    },
                    {
                        "targets": [0,2,3,4,5],
                        "className": "text-center"
                    },
                    {
                        "targets": [-1],
                        "className": "text-center",
                        "createdCell": function(td, cellData, rowData, row, col) {
                                // Apply the class only to <td> (not <th>)
                                if (row >= 0) {  // Ensure this applies only to table body rows
                                    $(td).addClass("d-flex align-items-center justify-content-end");
                                }
                            }
                    },
                    { "orderable": false, "targets": 0 } // Disable sorting for the last column
                    ]
        });
        var geo_table = $('#geoChart_order_summary').DataTable({
            "paging": true,
            scrollX: true,
            "pageLength": 40,
            "searching": false,
            "ordering": true,
            "info": false,
            "lengthChange": false,
            "columnDefs": [{
                        "targets": [6,7],
                        "className": "text-right"
                    },
                    {
                        "targets": [0,2,3,4,5],
                        "className": "text-center"
                    },
                    {
                        "targets": [-1],
                        "className": "text-center",
                        "createdCell": function(td, cellData, rowData, row, col) {
                                // Apply the class only to <td> (not <th>)
                                if (row >= 0) {  // Ensure this applies only to table body rows
                                    $(td).addClass("d-flex align-items-center justify-content-end");
                                }
                            }
                    },
                    { "orderable": false, "targets": 0 } // Disable sorting for the last column
                    ]
        });
        hideDiv();
        function formatSubTable(orderDetails) {
            // HTML structure for sub-table rows
            var html = `
                <table class="table table-bordered" style=" width: 100%;">
                    <thead>
                        <tr style="background-color: #8b8b8b;color: #ffffff;height: 30px;">
                            <th class="text-center">Order ID</th>
                            <th class="text-center">Organization Name</th>
                            <th class="text-center">Items QTY</th>
                            <th class="text-center">Amount ($)</th>
                            <th class="text-center">In-hand Due Date</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            orderDetails.forEach(function(order) {
                html += `
                    <tr>
                        <td class="text-center"><a href="{{url('order_details/edit/${order.order_id}/order?active_tab=order')}}" style="color: #007bff; text-decoration: none;" target="_blank">${order.order_no}</a></td>
                        <td><a href="{{url('organizations/info/${order.org_id}')}}" style="color: #007bff; text-decoration: none;" target="_blank">${order.org_name}</a></td>
                        <td class="text-center">${order.number_of_items}</td>
                        <td class="text-center">${parseFloat(order.order_amount).toFixed(2)}</td>
                        <td class="text-center">${order.inhand_due_date}</td>
                        <td class="text-center">${order.order_status}</td>
                    </tr>
                `;
            });
            html += `</tbody></table>`;
            return html;
    }
    $(document).ready(function () {
        $('#Order_types').on('change', function () {
            const selectedValues = $(this).val() || [];

            const allValue = 'all';
            const subOptions = ['Bulk', 'TSR', 'Wl'];

            const isAllSelected = selectedValues.includes(allValue);

            if (isAllSelected) {
                subOptions.forEach(val => {
                    $('#Order_types option[value="' + val + '"]').prop('selected', true);
                    $('li.' + val + ' input[type="checkbox"]').prop('checked', true);
                });
            } else {
                subOptions.forEach(val => {
                    const isChecked = selectedValues.includes(val);
                    $('#Order_types option[value="' + val + '"]').prop('selected', isChecked);
                    $('li.' + val + ' input[type="checkbox"]').prop('checked', isChecked);
                });

                $('#Order_types option[value="' + allValue + '"]').prop('selected', false);
                $('li.' + allValue + ' input[type="checkbox"]').prop('checked', false);
            }
        });

    });
    $('#export_button').on('click', function() {
        var reportType = $('#ReportTypes').val();
        var startDate =$('#start_date').val();
        var endDate =$('#end_date').val();
        var selectedColumn = $('#ReportTypes_cal_date').val();
        console.log(reportType);
        console.log(startDate);
        console.log(endDate);
         // Dynamically create a download link
    var url = "{{ route('reports.exportReport') }}" +
        '?start_date=' + encodeURIComponent(startDate) +
        '&end_date=' + encodeURIComponent(endDate) +
        '&selectedColumn=' + encodeURIComponent(selectedColumn) +
        '&reportType=' + encodeURIComponent(reportType);

    // Open the link for download
    window.location.href = url;
        // $.ajax({
        //     url: "{{ route('reports.exportReport') }}",
        //     type: 'GET',
        //     dataType: 'json',
        //     data: {
        //         start_date: startDate,
        //         end_date: endDate,
        //         reportType:reportType
        //     },
        //     beforeSend: function () {
        //         // Show loader if needed
        //         $(".se-pre-con").fadeIn('slow');
        //     },
        //     success: function(response) {
        //         console.log(response);


        //     },
        //     error: function(xhr, status, error) {
        //         console.error(xhr.responseText);
        //     },
        //     complete: function () {
        //         // Hide loader if needed
        //         $(".se-pre-con").fadeOut('slow');
        //     }
        // });
    });
    $('#orderDetailsTable').DataTable();
         // On change event
        $('#filterButton').on('click', function () {
            var selectedValue = $('#ReportTypes').val();

            console.log('Selected value:', selectedValue);
            console.log(selectedValue);
            if(selectedValue == 1){
                $('#export_button').show();
                $('#toggleChart').show();
                $('#Reporthedding').text('Analytical Summary Report For Sales Reps');
                make_rep_summary_table();
            }else if(selectedValue == 2){
                $('#export_button').show();
                $('#toggleChart').show();
                $('#Reporthedding').text('Analytical Summary Report For Sports');
                make_sport_summary_table();
            }else if(selectedValue == 4){
                $('#export_button').show();
                $('#toggleChart').show();
                $('#Reporthedding').text('Analytical Summary Report For Lead Source');
                make_Lead_summary_table();
            }else if(selectedValue == 3){
                $('#export_button').show();
                $('#toggleChart').show();
                make_factory_summary_table();
                $('#Reporthedding').text('Analytical Summary Report For Factory');
            }else if(selectedValue == 7){
                $('#export_button').hide();
                $('#toggleChart').hide();
                $('#rep_order_summary_chart_div').hide();
                $('#rep_order_summary_table_div').show();
                make_tsvsbulk_summary_table();
                $('#Reporthedding').text('Analytical Summary Report For Team vs Bulk Orders');
            }else if(selectedValue == 5){
                $('#export_button').hide();
                $('#toggleChart').hide();
                $('#rep_order_summary_chart_div').hide();
                $('#rep_order_summary_table_div').show();
                make_newvsold_cu_summary_table();
                $('#Reporthedding').text('Analytical Summary Report For New vs Repeated Customers');
            }else if(selectedValue == 6){
                // $('#export_button').hide();
                $('#toggleChart').hide();
                $('#rep_order_summary_chart_div').hide();
                $('#rep_order_summary_table_div').show();
                make_country_summary_table();
                $('#Reporthedding').text('Analytical Summary Report For Geographical Breakdown');
            }
            // Perform any other action here
            // alert('You selected: ' + selectedValue);
        });
        function make_rep_summary_table() {
            $('.se-pre-con').fadeIn();
            var startDate =$('#start_date').val();
            var endDate =$('#end_date').val();
            var selectedColumn = $('#ReportTypes_cal_date').val();
            var OrderTypes = $('#Order_types').val();
            console.log(OrderTypes);
            console.log(endDate);

            $.ajax({
                url: "{{ route('reports.rep_summary_table_data') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    start_date: startDate,
                    end_date: endDate,
                    selectedColumn:selectedColumn,
                    order_types:OrderTypes,
                },
                success: function(response) {
                    console.log(response);
                    update_rep_summary_Table(response.sales_reps);
                    update_rep_summary_chart(response.sales_reps);
                    // Format total_orders with commas
                    $('#totalordershow').text(Number(response.overall.total_orders).toLocaleString());

                    // Format total_revenue with two decimal places and commas
                    $('#totalrevenueshow').text(Number(parseFloat(response.overall.total_revenue).toFixed(2)).toLocaleString());

                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function make_sport_summary_table() {
            $('.se-pre-con').fadeIn();
            var startDate =$('#start_date').val();
            var endDate =$('#end_date').val();
            var selectedColumn = $('#ReportTypes_cal_date').val();
            var OrderTypes = $('#Order_types').val();
            console.log(startDate);
            console.log(endDate);

            $.ajax({
                url: "{{ route('reports.sports_summary_table_data') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    start_date: startDate,
                    end_date: endDate,
                    selectedColumn:selectedColumn,
                    order_types:OrderTypes,
                },
                success: function(response) {
                    console.log(response);
                    update_sport_summary_Table(response.sports);
                    update_sport_summary_chart(response.sports);
                    // update_rep_summary_chart(response.sales_reps);
                    // Format total_orders with commas
                    $('#totalordershow').text(Number(response.overall.total_orders).toLocaleString());

                    // Format total_revenue with two decimal places and commas
                    $('#totalrevenueshow').text(Number(parseFloat(response.overall.total_revenue).toFixed(2)).toLocaleString());


                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        function make_factory_summary_table() {
            $('.se-pre-con').fadeIn();
            var startDate =$('#start_date').val();
            var endDate =$('#end_date').val();
            var selectedColumn = $('#ReportTypes_cal_date').val();
            console.log(startDate);
            console.log(endDate);

            $.ajax({
                url: "{{ route('reports.factory_summary_table_data') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    start_date: startDate,
                    end_date: endDate,
                    selectedColumn:selectedColumn
                },
                success: function(response) {
                    console.log(response);
                    // update_sport_summary_Table(response.sports);
                    update_factory_summary_Table(response.factories);
                    update_factory_summary_chart(response.factories);
                    // Format total_orders with commas
                    $('#totalordershow').text(Number(response.overall.total_orders).toLocaleString());

                    // Format total_revenue with two decimal places and commas
                    $('#totalrevenueshow').text(Number(parseFloat(response.overall.total_revenue).toFixed(2)).toLocaleString());


                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        function make_Lead_summary_table() {
            $('.se-pre-con').fadeIn();
            var startDate =$('#start_date').val();
            var endDate =$('#end_date').val();
            var selectedColumn = $('#ReportTypes_cal_date').val();
            var OrderTypes = $('#Order_types').val();
            console.log(startDate);
            console.log(endDate);

            $.ajax({
                url: "{{ route('reports.lead_summary_table_data') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    start_date: startDate,
                    end_date: endDate,
                    selectedColumn:selectedColumn,
                    order_types:OrderTypes,
                },
                success: function(response) {
                    console.log(response);
                    update_lead_summary_Table(response.lead);
                    update_lead_summary_chart(response.lead);
                    // update_rep_summary_chart(response.sales_reps);
                    // Format total_orders with commas
                    $('#totalordershow').text(Number(response.overall.total_orders).toLocaleString());

                    // Format total_revenue with two decimal places and commas
                    $('#totalrevenueshow').text(Number(parseFloat(response.overall.total_revenue).toFixed(2)).toLocaleString());


                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        let newvsbulkchart = null;
        function make_tsvsbulk_summary_table() {
            $('.se-pre-con').fadeIn();
            hideDiv();
            $('#order_tsvsbulk_sammary_table_div').css('display', 'block');
            var startDate =$('#start_date').val();
            var endDate =$('#end_date').val();
            var selectedColumn = $('#ReportTypes_cal_date').val();
            console.log(startDate);
            console.log(endDate);

            $.ajax({
                url: "{{ route('reports.tsvsbulk_summary_table_data') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    start_date: startDate,
                    end_date: endDate,
                    selectedColumn:selectedColumn
                },
                success: function(response) {
                    $('.se-pre-con').fadeOut();
                    console.log(response);
                    const summary = response.summary;

                    // Prepare chart data
                    const labels = ['Team Store Orders', 'Bulk Orders'];
                    const orderCounts = [
                        summary.team_store.order_count,
                        summary.bulk_orders.order_count
                    ];
                    if (newvsbulkchart) {
                        newvsbulkchart.destroy();
                    }

                    // Draw the bar chart
                    const ctx = document.getElementById('TSvsBULK').getContext('2d');
                    newvsbulkchart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Order Count',
                                    data: orderCounts,
                                    backgroundColor: '#47D6B6',
                                    borderColor: '#31a78d',
                                    borderWidth: 1
                                },

                            ]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Count '
                                    }
                                }
                            },
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Team Store vs Bulk Orders'
                                }
                            }
                        }
                    });
                    $('#tsorderrevenue').text(Number(response.summary.team_store.total_revenue).toLocaleString());
                    $('#bulkorderrevenue').text(Number(response.summary.bulk_orders.total_revenue).toLocaleString());
                    $('#tsordercount').text(Number(response.summary.team_store.order_count).toLocaleString());
                    $('#bulkordercount').text(Number(response.summary.bulk_orders.order_count).toLocaleString());

                    $('#totalordershow').text(Number(response.overall.total_orders).toLocaleString());

                    // Format total_revenue with two decimal places and commas
                    $('#totalrevenueshow').text(Number(parseFloat(response.overall.total_revenue).toFixed(2)).toLocaleString());


                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        let newvsoldcuchart = null;
        function make_newvsold_cu_summary_table() {
            $('.se-pre-con').fadeIn();
            hideDiv();
            $('#order_newvsold_cu_sammary_table_div').css('display', 'block');
            var startDate =$('#start_date').val();
            var endDate =$('#end_date').val();
            var selectedColumn = $('#ReportTypes_cal_date').val();
            console.log(startDate);
            console.log(endDate);

            $.ajax({
                url: "{{ route('reports.newvsrepeated_cu_summary_table_data') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    start_date: startDate,
                    end_date: endDate,
                    selectedColumn:selectedColumn
                },
                success: function(response) {
                    $('.se-pre-con').fadeOut();
                    console.log(response);
                    const summary = response.organizations;
                    $('#totalordershow').text(Number(response.overall.total_orders).toLocaleString());

                    // Format total_revenue with two decimal places and commas
                    $('#totalrevenueshow').text(Number(parseFloat(response.overall.total_revenue).toFixed(2)).toLocaleString());
                    // Prepare chart data
                    const labels = ['New Customers', 'Repeated Customers'];
                    const orderCounts = [
                        summary.new_customers.total_orders,
                        summary.repeated_customers.total_orders
                    ];


                    // Draw the bar chart
                    const ctx = document.getElementById('newvsold').getContext('2d');
                    newvsoldcuchart= new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Order Count',
                                    data: orderCounts,
                                    backgroundColor: ['#47D6B6','#237764'], // Modern colors
                                    borderColor: '#ffffff',
                                    borderWidth: 2
                                },
                            ]
                        },
                        options: {
                            responsive: true,
                            cutout: '60%', // Controls the size of the white center circle
                            plugins: {
                                title: {
                                    display: false,
                                    text: 'New vs Repeated Customers',
                                    font: {
                                        size: 18,
                                        weight: 'bold'
                                    },
                                    padding: {
                                        top: 10,
                                        bottom: 20
                                    }
                                },
                                legend: {
                                    display: true,
                                    position: 'bottom',
                                    labels: {
                                        boxWidth: 15,
                                        padding: 20,
                                        color: '#333',
                                        font: {
                                            size: 14
                                        }
                                    }
                                }
                            }
                        },
                        plugins: [{
                            id: 'centerText', // Custom plugin for center text
                            beforeDraw: function(chart) {
                                const width = chart.width;
                                const height = chart.height;
                                const ctx = chart.ctx;

                                ctx.restore();
                                const fontSize = (height / 300).toFixed(2); // Adjust font size dynamically
                                ctx.font = fontSize + "em sans-serif";
                                ctx.textBaseline = "middle";
                                ctx.textAlign = "center";

                                // Define the lines of text
                                const textLine1 = "Total Customers";
                                const textLine2 = orderCounts.reduce((a, b) => a + b, 0); // e.g., "123"

                                const textX = width / 2;
                                const textY = height / 2;

                                // Set text color
                                ctx.fillStyle = "#333";

                                // Draw first line slightly above center
                                ctx.fillText(textLine1, textX, textY - 10);

                                // Draw second line slightly below center
                                ctx.fillText(textLine2, textX, textY + 10);

                                ctx.save();
                            }
                        }]
                    });
                    // $('#tsorderrevenue').text(Number(response.summary.team_store.total_revenue).toLocaleString());
                    // $('#bulkorderrevenue').text(Number(response.summary.bulk_orders.total_revenue).toLocaleString());
                    // $('#tsordercount').text(Number(response.summary.team_store.order_count).toLocaleString());
                    // $('#bulkordercount').text(Number(response.summary.bulk_orders.order_count).toLocaleString());

                    $('#new_cuscount').text(Number(response.organizations.new_customers.organization_count).toLocaleString());
                    $('#new_cuscount_precentage').text(response.organizations.new_customers.organization_percentage);
                    $('#new_custscount').text(Number(response.organizations.new_customers.team_store_orders_count).toLocaleString());
                    $('#new_cusbulkcount').text(Number(response.organizations.new_customers.bulk_orders_count).toLocaleString());
                    $('#new_custotcount').text(Number(response.organizations.new_customers.total_orders).toLocaleString());
                    $('#new_cusrevenue').text(Number(parseFloat(response.organizations.new_customers.total_revenue).toFixed(2)).toLocaleString());

                    $('#rep_cuscount').text(Number(response.organizations.repeated_customers.organization_count).toLocaleString());
                    $('#rep_cuscount_precentage').text(response.organizations.repeated_customers.organization_percentage);
                    $('#rep_custscount').text(Number(response.organizations.repeated_customers.team_store_orders_count).toLocaleString());
                    $('#rep_cusbulkcount').text(Number(response.organizations.repeated_customers.bulk_orders_count).toLocaleString());
                    $('#rep_custotcount').text(Number(response.organizations.repeated_customers.total_orders).toLocaleString());
                    $('#rep_cusrevenue').text(Number(parseFloat(response.organizations.repeated_customers.total_revenue).toFixed(2)).toLocaleString());

                    $('#tot_cuscount').text(Number(response.organizations.repeated_customers.organization_count + response.organizations.new_customers.organization_count).toLocaleString());
                    // $('#tot_cuscount_precentage').text(response.organizations.repeated_customers.organization_percentage);
                    $('#tot_custscount').text(Number(response.organizations.repeated_customers.team_store_orders_count + response.organizations.new_customers.team_store_orders_count).toLocaleString());
                    $('#tot_cusbulkcount').text(Number(response.organizations.repeated_customers.bulk_orders_count + response.organizations.new_customers.bulk_orders_count).toLocaleString());
                    $('#tot_custotcount').text(Number(response.organizations.repeated_customers.total_orders + response.organizations.new_customers.total_orders).toLocaleString());
                    $('#tot_cusrevenue').text(Number(parseFloat(response.organizations.repeated_customers.total_revenue + response.organizations.new_customers.total_revenue).toFixed(2)).toLocaleString());




                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        function make_country_summary_table() {
            $('.se-pre-con').fadeIn();
            var startDate =$('#start_date').val();
            var endDate =$('#end_date').val();
            var selectedColumn = $('#ReportTypes_cal_date').val();
            console.log(startDate);
            console.log(endDate);

            $.ajax({
                url: "{{ route('reports.country_summary_table_data') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    start_date: startDate,
                    end_date: endDate,
                    selectedColumn:selectedColumn
                },
                success: function(response) {
                    console.log(response);
                    renderGeoChart(response.countries);
                    // update_lead_summary_Table(response.lead);
                    // update_rep_summary_chart(response.sales_reps);
                    // Format total_orders with commas
                    $('#totalordershow').text(Number(response.overall.total_orders).toLocaleString());

                    // Format total_revenue with two decimal places and commas
                    $('#totalrevenueshow').text(Number(parseFloat(response.overall.total_revenue).toFixed(2)).toLocaleString());


                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        make_rep_summary_table();
        function update_rep_summary_Table(data) {
            hideDiv();
            $('#order_rep_sammary_table_div').css('display', 'block');

            rep_table.clear();

            data.forEach(function(rep, index) {
                rep_table.row.add([
                    '<i class="arrow-toggle fa fa-chevron-right" style="cursor: pointer;"></i>',
                    index + 1,
                    rep.sales_rep,
                    rep.team_store_orders_count,
                    rep.bulk_orders_count,
                    rep.wl_orders_count,
                    rep.int_orders_count,
                    rep.total_orders,
                    parseFloat(rep.total_revenue).toFixed(2),
                    rep.new_orders_count,
                    `
                        ${rep.revenue_percentage}%
                        <div class="progress" style="margin-left: 10px;">
                            <div class="progress-bar " role="progressbar" style="width: ${rep.revenue_percentage}%;background-color:#47D6B6" aria-valuenow="${rep.revenue_percentage}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                    `,
                ]).draw(false);
            });

            $('#rep_order_summary tbody').off('click', 'i.arrow-toggle').on('click', 'i.arrow-toggle', function() {
                var tr = $(this).closest('tr');
                var row = rep_table.row(tr);

                if (row.child.isShown()) {
                    // Hide subtable and reset the arrow
                    row.child.hide();
                    $(this).removeClass('fa-chevron-down').addClass('fa-chevron-right');
                    tr.removeClass('shown');
                } else {
                    // Show subtable and change arrow direction
                    var repData = data[row.index()];
                    row.child(formatSubTable(repData.order_details)).show();
                    $(this).removeClass('fa-chevron-right').addClass('fa-chevron-down');
                    tr.addClass('shown');
                }
            });

            $('.se-pre-con').fadeOut();
        }
        let salesRepChartInstance = null;
        function update_rep_summary_chart(salesReps){
            // Extract sales rep names and total revenue
            const labels = salesReps.map(rep => rep.sales_rep);
            const revenues = salesReps.map(rep => rep.total_revenue);
            if (salesRepChartInstance) {
                salesRepChartInstance.destroy();
            }
            // Render the bar chart
            const ctx = document.getElementById('salesRepChart').getContext('2d');
            salesRepChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Revenue',
                        data: revenues,
                        backgroundColor: '#47D6B6',
                        borderColor: '#31a78d',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Revenue ($)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Sales Representatives'
                            }
                        }
                    }
                }
            });
        }
        function update_sport_summary_chart(data) {
            // Extract sports and their corresponding total revenue
            const labels = data.map(item => item.sport);
            const revenues = data.map(item => parseFloat(item.total_revenue).toFixed(2));

            // Check if the chart instance exists, and destroy it before creating a new one
            if (salesRepChartInstance) {
                salesRepChartInstance.destroy();
            }

            // Render the bar chart
            const ctx = document.getElementById('salesRepChart').getContext('2d');
            salesRepChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Revenue ($)',
                        data: revenues,
                        backgroundColor: '#47D6B6',
                        borderColor: '#31a78d',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Revenue ($)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Sports'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return `$${tooltipItem.raw}`;
                                }
                            }
                        }
                    }
                }
            });
        }
        function update_factory_summary_chart(data) {
            // Extract factory names and their corresponding total revenue
            const labels = data.map(item => item.factory_name);
            const revenues = data.map(item => parseFloat(item.total_revenue).toFixed(2));

            // Check if the chart instance exists, and destroy it before creating a new one
            if (salesRepChartInstance) {
                salesRepChartInstance.destroy();
            }

            // Render the bar chart
            const ctx = document.getElementById('salesRepChart').getContext('2d');
            salesRepChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Revenue ($)',
                        data: revenues,
                        backgroundColor: '#47D6B6',
                        borderColor: '#31a78d',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Revenue ($)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Factories'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return `$${tooltipItem.raw}`;
                                }
                            }
                        }
                    }
                }
            });
        }
        function update_lead_summary_chart(data) {
            // Extract lead names and their corresponding total revenue
            const labels = data.map(item => item.leadSource);
            const revenues = data.map(item => parseFloat(item.total_revenue).toFixed(2));

            // Check if the chart instance exists, and destroy it before creating a new one
            if (salesRepChartInstance) {
                salesRepChartInstance.destroy();
            }

            // Render the bar chart
            const ctx = document.getElementById('salesRepChart').getContext('2d');
            salesRepChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Revenue ($)',
                        data: revenues,
                        backgroundColor: '#47D6B6',
                        borderColor: '#31a78d',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Revenue ($)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Leads'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return `$${tooltipItem.raw}`;
                                }
                            }
                        }
                    }
                }
            });
        }



        function update_sport_summary_Table(data) {
            hideDiv();
            $('#order_sport_sammary_table_div').css('display', 'block');
            sport_table.clear();

            data.forEach(function(rep, index) {
                sport_table.row.add([
                    '<i class="arrow-toggle fa fa-chevron-right" style="cursor: pointer;"></i>',
                    index + 1,
                    rep.sport,
                    rep.team_store_orders_count,
                    rep.bulk_orders_count,
                    rep.wl_orders_count,
                    rep.int_orders_count,
                    rep.total_orders,
                    parseFloat(rep.total_revenue).toFixed(2),
                    rep.new_orders_count,
                    `
                        ${rep.revenue_percentage}%
                        <div class="progress" style="margin-left: 10px;">
                            <div class="progress-bar " role="progressbar" style="width: ${rep.revenue_percentage}%;background-color:#47D6B6" aria-valuenow="${rep.revenue_percentage}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                    `,
                ]).draw(false);
            });

            $('#sport_order_summary tbody').off('click', 'i.arrow-toggle').on('click', 'i.arrow-toggle', function() {
                var tr = $(this).closest('tr');
                var row = sport_table.row(tr);

                if (row.child.isShown()) {
                    // Hide subtable and reset the arrow
                    row.child.hide();
                    $(this).removeClass('fa-chevron-down').addClass('fa-chevron-right');
                    tr.removeClass('shown');
                } else {
                    // Show subtable and change arrow direction
                    var repData = data[row.index()];
                    row.child(formatSubTable(repData.order_details)).show();
                    $(this).removeClass('fa-chevron-right').addClass('fa-chevron-down');
                    tr.addClass('shown');
                }
            });

            $('.se-pre-con').fadeOut();
        }
        function update_lead_summary_Table(data) {
            hideDiv();
            $('#order_LeadSource_sammary_table_div').css('display', 'block');
            console.log( 'weda');

            lead_table.clear();

            data.forEach(function(rep, index) {
                lead_table.row.add([
                    '<i class="arrow-toggle fa fa-chevron-right" style="cursor: pointer;"></i>',
                    index + 1,
                    rep.leadSource,
                    rep.team_store_orders_count,
                    rep.bulk_orders_count,
                    rep.wl_orders_count,
                    rep.int_orders_count,
                    rep.total_orders,
                    parseFloat(rep.total_revenue).toFixed(2),
                    rep.new_orders_count,
                    `
                        ${rep.revenue_percentage}%
                        <div class="progress" style="margin-left: 10px;">
                            <div class="progress-bar " role="progressbar" style="width: ${rep.revenue_percentage}%;background-color:#47D6B6" aria-valuenow="${rep.revenue_percentage}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                    `,
                ]).draw(false);
            });

            $('#lead_order_summary tbody').off('click', 'i.arrow-toggle').on('click', 'i.arrow-toggle', function() {
                var tr = $(this).closest('tr');
                var row = lead_table.row(tr);

                if (row.child.isShown()) {
                    // Hide subtable and reset the arrow
                    row.child.hide();
                    $(this).removeClass('fa-chevron-down').addClass('fa-chevron-right');
                    tr.removeClass('shown');
                } else {
                    // Show subtable and change arrow direction
                    var repData = data[row.index()];
                    row.child(formatSubTable(repData.order_details)).show();
                    $(this).removeClass('fa-chevron-right').addClass('fa-chevron-down');
                    tr.addClass('shown');
                }
            });

            $('.se-pre-con').fadeOut();
        }
        function update_factory_summary_Table(data) {
            hideDiv();
            $('#order_factory_sammary_table_div').css('display', 'block');
            console.log( 'weda');

            factory_table.clear();

            data.forEach(function(rep, index) {
                factory_table.row.add([
                    // '<i class="arrow-toggle fa fa-chevron-right" style="cursor: pointer;"></i>',
                    index + 1,
                    rep.factory_name,
                    rep.order_count,
                    parseFloat(rep.total_revenue).toFixed(2),
                    rep.new_order_count,
                    `
                        ${rep.revenue_percentage}%
                        <div class="progress" style="margin-left: 10px;">
                            <div class="progress-bar " role="progressbar" style="width: ${rep.revenue_percentage}%;background-color:#47D6B6" aria-valuenow="${rep.revenue_percentage}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                    `,
                ]).draw(false);
            });

            // $('#lead_order_summary tbody').off('click', 'i.arrow-toggle').on('click', 'i.arrow-toggle', function() {
            //     var tr = $(this).closest('tr');
            //     var row = lead_table.row(tr);

            //     if (row.child.isShown()) {
            //         // Hide subtable and reset the arrow
            //         row.child.hide();
            //         $(this).removeClass('fa-chevron-down').addClass('fa-chevron-right');
            //         tr.removeClass('shown');
            //     } else {
            //         // Show subtable and change arrow direction
            //         var repData = data[row.index()];
            //         row.child(formatSubTable(repData.order_details)).show();
            //         $(this).removeClass('fa-chevron-right').addClass('fa-chevron-down');
            //         tr.addClass('shown');
            //     }
            // });

            $('.se-pre-con').fadeOut();
        }
        // Function to render geographical chart
       // Helper function to get the ISO3 code for a given country name
       function renderGeoChart(data) {
    hideDiv();

    // Display the summary table div and hide the loading spinner
    $('#order_geoChart_sammary_table_div').css('display', 'block');
    geo_table.clear();
    let counter = 0;
    // Populate the main table with country-level data
    Object.keys(data).forEach(function (country) {
        const countryData = data[country];
        counter++;
        geo_table.row.add([
            '<i class="arrow-toggle fa fa-chevron-right" style="cursor: pointer;"></i>',
            counter,
            country,
            countryData.team_store_orders_count || 0,
            countryData.bulk_orders_count || 0,
            countryData.total_orders || 0,
            parseFloat(countryData.total_revenue || 0).toFixed(2),
            countryData.new_orders_count || 0,
            `
                ${countryData.revenue_percentage || 0}%
                <div class="progress" style="margin-left: 10px;">
                    <div class="progress-bar" role="progressbar"
                         style="width: ${countryData.revenue_percentage || 0}%; background-color:#47D6B6;"
                         aria-valuenow="${countryData.revenue_percentage || 0}" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
            `,
        ]).draw(false);
    });

    // Add toggle functionality for rows
    $('#geoChart_order_summary tbody').off('click', 'i.arrow-toggle').on('click', 'i.arrow-toggle', function () {
            const tr = $(this).closest('tr');
            const row = geo_table.row(tr);
            const countryName = row.data()[2]; // Country name in the second column
            const countryData = data[countryName];

            if (row.child.isShown()) {
                // Collapse country row
                row.child.hide();
                $(this).removeClass('fa-chevron-down').addClass('fa-chevron-right');
                tr.removeClass('shown');
            } else {
                // Expand country row
                if (countryName === "United States") {
                    // Handle U.S. states
                    const stateRows = Object.keys(countryData.order_details).map(function (state) {
                        const stateData = countryData.order_details[state];
                        return `
                            <tr>
                                <td><i class="arrow-toggle-state fa fa-chevron-right" style="cursor: pointer;"></i></td>
                                <td>${state}</td>
                                <td>${stateData.team_store_orders_count || 0}</td>
                                <td>${stateData.bulk_orders_count || 0}</td>
                                <td>${stateData.total_orders || 0}</td>
                                <td>${parseFloat(stateData.total_revenue || 0).toFixed(2)}</td>
                                <td>${stateData.new_orders_count || 0}</td>
                            </tr>
                        `;
                    }).join('');

                    const stateTableHTML = `
                        <table class="table table-bordered">
                            <thead>
                                <tr style="background-color: #8b8b8b;color: #ffffff;height: 30px;">
                                    <th></th>
                                    <th>State</th>
                                    <th>Team Store Orders</th>
                                    <th>Bulk Orders</th>
                                    <th>Total Orders</th>
                                    <th>Total Revenue</th>
                                    <th>New Orders</th>
                                </tr>
                            </thead>
                            <tbody>${stateRows}</tbody>
                        </table>
                    `;
                    row.child(stateTableHTML).show();

                    // Handle state toggle functionality
                    row.child().find('.arrow-toggle-state').on('click', function () {
                        const stateRow = $(this).closest('tr');
                        const stateName = stateRow.find('td:nth-child(2)').text();
                        const stateData = countryData.order_details[stateName];

                        if ($(this).hasClass('fa-chevron-right')) {
                            $(this).removeClass('fa-chevron-right').addClass('fa-chevron-down');
                            const ordersTableHTML = formatSubTable(stateData.order_details);
                            stateRow.after(`<tr class="state-orders"><td colspan="7">${ordersTableHTML}</td></tr>`);
                        } else {
                            $(this).removeClass('fa-chevron-down').addClass('fa-chevron-right');
                            stateRow.next('.state-orders').remove();
                        }
                    });
                } else {
                    // Handle non-U.S. countries
                    const ordersTableHTML = formatSubTable(countryData.order_details);
                    row.child(ordersTableHTML).show();
                }

                $(this).removeClass('fa-chevron-right').addClass('fa-chevron-down');
                tr.addClass('shown');
            }
        });

    // Hide spinner after rendering
    $('.se-pre-con').fadeOut();
}



    });

</script>
@endsection
