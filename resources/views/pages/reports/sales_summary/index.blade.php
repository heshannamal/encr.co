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
    .multiselect {
        background-color: unset !important;
        color: #8898aa !important;
        font-size: 13px;
        font-weight: unset;
        border: unset !important;
        box-shadow: unset !important;
    }
    .dropdown-menu {
        min-width: 15rem;
        font-size: 13px;

    }
    .multiselect-container>li>a>label{
        width: 100%;
        color: #000000 !important;
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
        <span>Sales Summary Report</span>
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
                    <div class="row filter_row" style="padding-bottom: 2px; margin: 5px;">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">Search |</p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                            <input type="text" name="search_query" id="search_query" class="form-control invoice-inputs" placeholder="By Team Name or Order No" style="height: 2rem; background-color: #F8F8F8; border: 1px solid #DEDEDE;">
                        </div>
                    </div>
                    <div class="row filter_row row-for-date-options ml-auto" style="padding-bottom: 2px; margin:5px;background-color: rgb(123, 216, 237);">
                        <label class="d_flex_and_align_center" style="margin: 0;cursor: pointer;">
                            <input type="radio" name="dateFilter" style="display: none" value="thisMonth" checked>
                            <span class="font_color date_p" style="color: rgb(255, 255, 255);">This month</span>
                        </label>
                    </div>

                    <div class="row filter_row row-for-date-options" style="padding-bottom: 2px; margin:5px;">
                        <label class="d_flex_and_align_center" style="margin: 0;cursor: pointer;">
                            <input type="radio" name="dateFilter" style="display: none" value="lastMonth">
                            <span class="font_color date_p">Last month</span>
                        </label>
                    </div>

                    <div class="row filter_row row-for-date-options" style="padding-bottom: 2px; margin:5px;">
                        <label class="d_flex_and_align_center" style="margin: 0;cursor: pointer;">
                            <input type="radio" name="dateFilter" style="display: none" value="thisYear">
                            <span class="font_color date_p">This year</span>
                        </label>
                    </div>

                    <div class="row filter_row row-for-date-options" style="padding-bottom: 2px; margin:5px;">
                        <label class="d_flex_and_align_center" style="margin: 0;cursor: pointer;">
                            <input type="radio" name="dateFilter" style="display: none" value="lastYearToday">
                            <span class="font_color date_p">Last year to date</span>
                        </label>
                    </div>

                    <div class="row filter_row row-for-date-options" style="padding-bottom: 2px; margin:5px;">
                        <label class="d_flex_and_align_center" style="margin: 0;cursor: pointer;">
                            <input type="radio" name="dateFilter" style="display: none" value="thisQuarter">
                            <span class="font_color date_p">This quarter</span>
                        </label>
                    </div>
                </div>

                <div class="row" style="margin-left: 18px; margin-right: 30px; padding-bottom: 7px;">
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
                    <div class="row filter_row" style="padding-bottom: 2px; margin-left: 20px;">
                        <p class="font_color date_p d_flex_and_align_center">Processing Rep |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style" style="padding-left: 7px;">
                            <select id="order_processing_rep" name="order_processing_rep" class="date_selection summary-select2">
                                <option value="all">All</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row filter_row ml-auto" style="padding-bottom: 2px; margin-left: 20px;">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">Sport |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style" style="padding-left: 10px;">
                            <select id="sport_filter" name="sport_filter" class="date_selection summary-select2">
                                <option value="all">All</option>
                                @foreach ($sports as $sport)
                                    <option value="{{ $sport->sport_name }}">{{ $sport->sport_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row filter_row" style="padding-bottom: 2px; margin-left: 20px;">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">Lead Type |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style" style="padding-left: 7px;">
                            <select id="lead_source_filter" name="lead_source_filter" class="date_selection summary-select2">
                                <option value="all">All</option>
                                @foreach ($lead_sources as $lead_source)
                                    <option value="{{ $lead_source->id }}">{{ $lead_source->lead_source_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row filter_row" style="padding-bottom: 2px; margin-left: 20px;">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">Sale Type |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style" style="padding-left: 7px;">
                            <select id="sale_type_filter" name="sale_type_filter" class="date_selection summary-select2">
                                <option value="all" selected>All</option>
                                <option value="1">Return sale</option>
                                <option value="0">New sale</option>
                            </select>
                        </div>
                    </div>
                    <div class="row filter_row" style="padding-bottom: 2px; margin-left: 20px;">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">Location |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style" style="padding-left: 7px;">
                            <select id="location_filter" name="location_filter" class="date_selection summary-select2">
                                <option value="all">All</option>
                                @foreach ($organization_countries as $organization_country)
                                    <option value="{{ $organization_country }}">{{ $organization_country }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row mt-2"  style="margin-left: 18px; margin-right: 10px; padding-bottom: 7px;">
                    <div class="row filter_row"  style="padding-bottom: 2px;">
                        <p class="font_color date_p d_flex_and_align_center">Items |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style-item" style="padding-left: 7px;">
                            <select id="product_filter" name="product_filter" class="date_selection summary-select2">
                                <option value="all">All</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row filter_row" style="padding-bottom: 2px; margin-left: 20px;margin-right: 10px;">
                        {{-- <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style" style="padding-left: 7px;" multiple>
                            <select id="order_type" name="order_type" class=" select2-multiple2" multiple>
                                <option value="all" selected>ALL ORDERS</option>
                                <option value="Bulk">BULK ORDERS</option>
                                <option value="TSR">TSR ORDERS</option>
                            </select>
                        </div> --}}
                        <select name="order_types[]" multiple id="langOpt">
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
                    <div class="row filter_row" style="padding-bottom: 2px;">
                        <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style" style="padding-left: 7px;">
                            <select id="filterColumn" name="filterColumn" class="date_selection summary-select2">
                                <option value="production_date" selected>Based on Production Date</option>
                                <option value="ex_factory_date">Based on Ex-factory Date</option>
                            </select>
                        </div>
                    </div>
                    <div style="margin-left: 45px;">
                        <div class="row d_flex_and_align_center" style="padding-bottom: 2px;height: 100%;">
                            <button class="date_p filter_btn" type="button" id="pin-filter" title="Filter" style="height: 2.3rem;margin-top: 10px;">
                                <i class="fa fa-filter"></i>&nbsp;&nbsp;Filter
                            </button>
                        </div>
                    </div>
                    <div style="margin-left: 45px;">
                        <div class="row d_flex_and_align_center" style="padding-bottom: 2px;height: 100%;">
                            <button class="date_p filter_btn" type="button" data-toggle="modal" data-target="#layout_modal" title="Filter" style="height: 2.3rem;margin-top: 10px;width:auto;background-color: #b3b3b3;">
                                Table Layout
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
                            <span class="d_flex_and_align_center text-right" style="height: 1.5rem;background-color:#F8F8F8;width: 100%;color:black;font-size: .8rem;font-weight: 600;" id="total_sale">0.00</span>
                        </div>
                    </div>

                        <div class="row d_flex_and_align_center " style="padding-bottom: 2px;margin: 5px;">
                            <button class="date_p excel_btn" type="button" id="save-report" title="save report" style="height: 100%;border-radius: 5px">
                                <i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save
                            </button>
                        </div>
                        <div class="row d_flex_and_align_center " style="padding-bottom: 2px;margin: 5px;">
                            <button class="date_p excel_btn" type="button" id="export-report" title="export report" style="height: 100%;border-radius: 5px">
                                <i class="fa fa-download"></i>&nbsp;&nbsp;Export
                            </button>
                        </div>

                </div>
            </form>


            <div class="order_sammary_table" style="">
                <table class="table align-items-center" id="order_summary" style="max-width: 100% !important;">

                    <thead style="background-color: rgba(50, 50, 50, 1) !important;">
                        <tr>
                            <th scope="col" class="table_header_text order-no" data-column="order-no">Order No</th>
                            <th scope="col" class="table_header_text organization-name" data-column="organization-name">Organization Name</th>
                            <th scope="col" class="table_header_text sales-rep" data-column="sales-rep">Sales Lead</th>
                            <th scope="col" class="table_header_text item-qty" data-column="item-qty">Item Qty</th>
                            <th scope="col" class="table_header_text total-value" data-column="total-value">Total ($)</th>
                            <th scope="col" class="table_header_text created-date" data-column="created-date">Created Date</th>
                            <th scope="col" class="table_header_text production-date" data-column="production-date">Production Date</th>
                            <th scope="col" class="table_header_text in-hand-date" data-column="in-hand-date">In Hand Due Date</th>
                            <th scope="col" class="table_header_text order-status" data-column="order-status">Status</th>
                            <th scope="col" class="table_header_text order-description" data-column="order-description">Order Description</th>
                            <th scope="col" class="table_header_text order-sub-total" data-column="order-sub-total">Sub Total ($)</th>
                            <th scope="col" class="table_header_text order-sales-tax" data-column="order-sales-tax">Sales Tax ($)</th>
                            <th scope="col" class="table_header_text order-shipping" data-column="order-shipping">Shipping ($)</th>
                            <th scope="col" class="table_header_text order-artwork" data-column="order-artwork">Artwork ($)</th>
                            <th scope="col" class="table_header_text order-processing-fee" data-column="order-processing-fee">Processing Fee ($)</th>
                        </tr>
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

<div class="modal fade" id="layout_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content rmwidth001">
            <!-- Modal Header -->
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Summary Fields &amp; Layouts</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">

                        <!-- Checkbox Options for Table Columns -->
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input summary-table-layout" id="order_no" data-column-class="order-no" />
                                <label class="custom-control-label" for="order_no">Order No</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input summary-table-layout" id="organization_name" data-column-class="organization-name" />
                                <label class="custom-control-label" for="organization_name">Organization Name</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input summary-table-layout" id="sales_lead" data-column-class="sales-rep" />
                                <label class="custom-control-label" for="sales_lead">Sales Lead</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input summary-table-layout" id="item_qty" data-column-class="item-qty" />
                                <label class="custom-control-label" for="item_qty">Item Qty</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input summary-table-layout" id="total_value" data-column-class="total-value" />
                                <label class="custom-control-label" for="total_value">Total ($)</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input summary-table-layout" id="created_date" data-column-class="created-date" />
                                <label class="custom-control-label" for="created_date">Created Date</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input summary-table-layout" id="production_date" data-column-class="production-date" />
                                <label class="custom-control-label" for="production_date">Production Date</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input summary-table-layout" id="in_hand_date" data-column-class="in-hand-date" />
                                <label class="custom-control-label" for="in_hand_date">In Hand Due Date</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input summary-table-layout" id="order_status" data-column-class="order-status" />
                                <label class="custom-control-label" for="order_status">Status</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input summary-table-layout" id="order_description" data-column-class="order-description" />
                                <label class="custom-control-label" for="order_description">Description</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input summary-table-layout" id="order_sub_total" data-column-class="order-sub-total" />
                                <label class="custom-control-label" for="order_sub_total">Sub total ($)</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input summary-table-layout" id="order_sales_tax" data-column-class="order-sales-tax" />
                                <label class="custom-control-label" for="order_sales_tax">Sales Tax</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input summary-table-layout" id="order_shipping" data-column-class="order-shipping" />
                                <label class="custom-control-label" for="order_shipping">Shipping</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input summary-table-layout" id="order_artwork" data-column-class="order-artwork" />
                                <label class="custom-control-label" for="order_artwork">Artwork</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input summary-table-layout" id="order_processing_fee" data-column-class="order-processing-fee" />
                                <label class="custom-control-label" for="order_processing_fee">Processing Fee</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer with Save Button -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveLayoutButton">Save Layout</button>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap Multiselect Plugin -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js"></script>

<script>
    $('.summary-datepicker').datepicker();
    $('.summary-select2').select2();
    $('#langOpt').multiselect({
        buttonText: function() {
            return 'Order Types'; // Always show "Order Types"
        },
        includeSelectAllOption: false, // Add "Select All" option
        nonSelectedText: 'Order Types', // Placeholder when nothing is selected
        allSelectedText: 'Order Types', // Prevents selection count
        enableFiltering: false // DISABLES SEARCH
    });
    $(document).ready(function() {

        $('#start_date, #end_date').on('change', function () {
            console.log('works');
            // Ensure radio buttons are unchecked
            $('input[name="dateFilter"]').each(function () {
                $(this).prop('checked', false);
                $(this).prop('checked', false).removeClass('active-radio');
                $(this).closest('.row-for-date-options').css('background-color', '#F8F8F8');
                $(this).closest('.row-for-date-options').find('label span').css('color', 'black');
            });
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

        $('input[name="dateFilter"]').on('click', function() {
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

        var table = $('#order_summary').DataTable({
            "paging": true,
            scrollX: true,
            "pageLength": $('#page_length').val(),
            "searching": false,
            "ordering": true,
            "info": false,
            "lengthChange": false,
            colReorder: true,
            stateSave: true,
            "autoWidth": false,
            "columnDefs": [{
                        "targets": [4,10,11,12,13,14],
                        "className": "text-right"
                    },
                    {
                        "targets": [0,3,4,5,6,7],
                        "className": "text-center"
                    },
                    {
                        targets: [5, 6, 7], // Specify your target columns
                        type: 'date', // Ensure that these columns are sorted as dates
                        render: function(data, type, row) {
                            // Convert the mm/dd/yyyy string to a proper Date object
                            if (type === 'sort') {
                                var dateParts = data.split('/');
                                // Return the date in a sortable format (yyyy-mm-dd)
                                return new Date(dateParts[2], dateParts[0] - 1, dateParts[1]).toISOString();
                            }
                            return data; // Default rendering for other types
                        }
                    }
                ]
        });

        function make_summary_table() {
            $('.se-pre-con').fadeIn();
            var formData = new FormData($('#summary_filter_form')[0]);

            $.ajax({
                url: "{{ route('get_summary_report_data') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    $('#total_sale').text(parseFloat(response.total_sale).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                    $('#number_of_sale').text(response.number_of_sale);
                    updateTable(response.orders);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        function save_summary_report() {
            // Show SweetAlert2 input prompt for report name
            Swal.fire({
                title: 'Enter Report Name',
                input: 'text',
                inputPlaceholder: 'Report Name',
                showCancelButton: true,
                confirmButtonText: 'Save Report',
                inputValidator: (value) => {
                    if (!value) {
                        return 'You need to enter a report name!';
                    }
                }
            }).then((result) => {
                if (result.value) {
                    // Show the loader
                    $('.se-pre-con').fadeIn();

                    // Prepare form data
                    var formData = new FormData($('#summary_filter_form')[0]);
                    // Add report name to form data
                    formData.append('report_name', result.value); // result.value contains the inputted report name

                    $.ajax({
                        url: "{{ route('save_summary_report_data') }}", // URL to Laravel route
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log(response);
                            // Hide the loader
                            $('.se-pre-con').fadeOut();

                            // Show success alert using SweetAlert2
                            Swal.fire({
                                title: 'Success!',
                                text: response.message, // Using the message from the server response
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            $('.se-pre-con').fadeOut();

                            // Show error alert using SweetAlert2
                            Swal.fire({
                                title: 'Error!',
                                text: 'There was a problem saving the report. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        }

        $('#export-report').click(function() {
            export_summary_report();
        });

        function export_summary_report() {
        var formData = new FormData($('#summary_filter_form')[0]);

        Swal.fire({
            title: 'Do you want to export the report?',
            input: 'text',
            inputValue: 'exported_summary_report',
            showCancelButton: true,
            confirmButtonText: 'Export report',
            preConfirm: (reportName) => {
                if (!reportName) {
                    Swal.showValidationMessage('Please enter a report name');
                }
                return reportName;
            }
        }).then((result) => {
            if (result.value) {
                const reportName = result.value;

                formData.append('report_name', reportName);

                $('.se-pre-con').fadeIn();

                $.ajax({
                    url: "{{ route('reports.exportCsv') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(response, status, xhr) {
                        $('.se-pre-con').fadeOut();

                        const url = window.URL.createObjectURL(new Blob([response]));
                        const link = document.createElement('a');
                        link.href = url;

                        const contentDisposition = xhr.getResponseHeader('Content-Disposition');
                        let fileName = reportName + '.csv';
                        if (contentDisposition) {
                            const matches = /filename="([^"]*)"/.exec(contentDisposition);
                            if (matches && matches[1]) fileName = matches[1];
                        }
                        link.setAttribute('download', fileName);

                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);

                        Swal.fire({
                            title: 'Success!',
                            text: 'Report exported successfully',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('.se-pre-con').fadeOut();

                        Swal.fire({
                            title: 'Error!',
                            text: 'There was a problem exporting the report. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    }

    $(document).ready(function () {
        $('#langOpt').on('change', function () {
            const selectedValues = $(this).val() || [];

            const allValue = 'all';
            const subOptions = ['Bulk', 'TSR', 'Wl'];

            const isAllSelected = selectedValues.includes(allValue);

            if (isAllSelected) {
                subOptions.forEach(val => {
                    $('#langOpt option[value="' + val + '"]').prop('selected', true);
                    $('li.' + val + ' input[type="checkbox"]').prop('checked', true);
                });
            } else {
                subOptions.forEach(val => {
                    const isChecked = selectedValues.includes(val);
                    $('#langOpt option[value="' + val + '"]').prop('selected', isChecked);
                    $('li.' + val + ' input[type="checkbox"]').prop('checked', isChecked);
                });

                $('#langOpt option[value="' + allValue + '"]').prop('selected', false);
                $('li.' + allValue + ' input[type="checkbox"]').prop('checked', false);
            }
        });

    });

        // Update table data
        function updateTable(data) {

            table.clear(); // Clear the existing table data

            // Get the current column order as set by colReorder
            var currentColumnOrder = table.colReorder.order();

            // Add new data rows based on the current column order
            data.forEach(function(order) {
                // Prepare the data for each row, but not in any specific order yet
                var rowData = [
                    '<a style="color:black !important" href="#" class="edit-order" data-value="' + order.id + '">' + order.order_no + '</a>', // 0: Order No.
                    order.organization_details.organization_name, // 1: Organization Name
                    order.user_details.name, // 2: Sales Rep
                    calculateTotalQty(order.order_items), // 3: Item Qty
                    parseFloat(order.order_total).toFixed(2), // 4: Total Value
                    order.open_date, // 5: Created Date
                    order.production_date, // 6: Production Date
                    order.due_date, // 7: In Hand Date
                    order.status_details.status_name, // 8: Order Status
                    order.order_description, // 9: Order Description
                    parseFloat(order.sub_total).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"), // 10: Sub Total
                    parseFloat(order.sales_tax).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"), // 11: Sales Tax
                    parseFloat(order.shipping).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"), // 12: Shipping
                    parseFloat(order.artwork).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"), // 13: Artwork
                    parseFloat(order.processing_fee).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"), // 14: Processing Fee
                ];

                // Now, reorder the rowData to match the current column order
                var reorderedRowData = currentColumnOrder.map(function(index) {
                    return rowData[index];
                });

                // Add the reordered row data to the table
                table.row.add(reorderedRowData);
            });

            // Redraw the table to reflect the added rows
            table.draw();

            // Apply class names to specific columns after drawing the table
            $('#order_summary tbody tr').each(function() {
                $(this).find('td').eq(0).addClass('order-no');
                $(this).find('td').eq(1).addClass('organization-name');
                $(this).find('td').eq(2).addClass('sales-rep');
                $(this).find('td').eq(3).addClass('item-qty');
                $(this).find('td').eq(4).addClass('total-value').css('text-align', 'right');
                $(this).find('td').eq(5).addClass('created-date');
                $(this).find('td').eq(6).addClass('production-date');
                $(this).find('td').eq(7).addClass('in-hand-date');
                $(this).find('td').eq(8).addClass('order-status');
                $(this).find('td').eq(9).addClass('order-description');
                $(this).find('td').eq(10).addClass('order-sub-total');
                $(this).find('td').eq(11).addClass('order-sales-tax');
                $(this).find('td').eq(12).addClass('order-shipping');
                $(this).find('td').eq(13).addClass('order-artwork');
                $(this).find('td').eq(14).addClass('order-processing-fee');
            });

            table.page.len(parseInt($('#page_length').val())).draw();

            $('.se-pre-con').fadeOut();

            function calculateTotalQty(orderItems) {
                return orderItems
                    .filter(item => item && item.deleted_at == null && item.active == 1)
                    .reduce((sum, item) => sum + parseInt(item.qty || 0, 10), 0);
            }
        }

        function loadColumnSettings() {
            var columnVisibility = JSON.parse(localStorage.getItem('order_summary_column_visibility'));

            if (columnVisibility) {
                $('.summary-table-layout').each(function() {
                    var columnClass = $(this).data('column-class');
                    var isVisible = columnVisibility[columnClass] !== false;

                    var columnIndex = table.column('.' + columnClass).index();
                    table.column(columnIndex).visible(isVisible);

                    $(this).prop('checked', isVisible);
                });
            } else {
                $('.summary-table-layout').each(function() {
                    var columnClass = $(this).data('column-class');
                    $('#order_summary th[data-column="' + columnClass + '"]').show();
                    $('#order_summary td.' + columnClass).show();
                    $(this).prop('checked', true);
                });
            }
        }

        function saveColumnSettings() {
            var columnVisibility = {};
            $('.summary-table-layout').each(function() {
                var columnClass = $(this).data('column-class');
                columnVisibility[columnClass] = $(this).is(':checked');
            });
            localStorage.setItem('order_summary_column_visibility', JSON.stringify(columnVisibility));
        }

        function saveColumnOrder() {
            var columnOrder = table.colReorder.order(); // Get the current column order
            localStorage.setItem("orders_table_column_order", JSON.stringify(columnOrder));
        }

        // Function to load column order from localStorage
        function loadColumnOrder() {
            var columnOrderStr = localStorage.getItem("orders_table_column_order");

            if (columnOrderStr) {
                try {
                    var columnOrder = JSON.parse(columnOrderStr);
                    if (Array.isArray(columnOrder)) {
                        // Apply the saved column order to the table
                        table.colReorder.order(columnOrder);

                        // Redraw the table to ensure both thead and tbody are synchronized
                        table.draw();
                    }
                } catch (e) {
                    console.error('Error parsing column order:', e);
                }
            } else {
                // Reset to default order if no saved column order is found
                table.colReorder.order([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]); // Adjust this based on your default order
            }
        }


        loadColumnSettings();
        loadColumnOrder();

        $('.summary-table-layout').change(function() {
            var columnClass = $(this).data('column-class');
            var isVisible = $(this).is(':checked');

            var columnIndex = table.column('.' + columnClass).index();
            table.column(columnIndex).visible(isVisible);

            saveColumnSettings();
        });

        $('#saveLayoutButton').click(function() {
            saveColumnSettings();
            // saveColumnOrder();
            $('#layout_modal').modal('hide');
        });

        // Event listener for column reorder to save the new order
        table.on('column-reorder', function () {
            saveColumnOrder(); // Save the column order whenever it changes
        });

        $('#pin-filter').on('click', function() {
            make_summary_table();
        });
        $('#save-report').on('click', function() {
            save_summary_report();
        });

        $('#page_length').on('change', function() {
            table.page.len(parseInt($(this).val())).draw();
        });
        $("body").on("click", ".edit-order", function(){
            var orderId = $(this).data('value');
            window.open('order_details/edit/'+orderId+'/order?active_tab=order', '_blank');
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
