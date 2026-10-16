@extends('layouts.app', ['activePage' => 'Sales_Tax_Report', 'titlePage' => __('Sales Tax Report')])

@section('content')
<style>
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
    .d_flex_and_align_center{
        display: flex;
        align-items: center;
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
    .table_header_text {
        color: white;

    }
    .order_sammary_table {
        padding-top: 5px;
        overflow-x: auto;
        padding-left: 15PX;
        padding-right: 15PX;
        padding-bottom: 15px;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button{
        padding: unset !important;
    }
    div.dataTables_wrapper div.dataTables_length select{
        width: 100% !important;
    }
</style>
<div class=" mb-5 content-position">

    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Sales Tax Report</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12" style="margin-top: 15px; margin-bottom: 25px; padding-bottom: 20px;" id="scrollTable">
        <div class="card" style="border: unset;">
            <form id="sales_tax_filter_form">
                @csrf
                <div class="row" style="margin: 10px;">
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
                    <div class="row " style="padding-bottom: 2px;margin:5px">
                        <div class="d_flex_and_align_center" style="padding-bottom: 2px;height: 100%;">
                            <button class="date_p filter_btn" type="button" id="pin-filter" title="Filter" style="height: 2.3rem;">
                                <i class="fa fa-filter"></i>&nbsp;&nbsp;Filter
                            </button>
                        </div>
                    </div>
                    <div cclass="row " style="padding-bottom: 2px;margin:5px">
                        <div class="d_flex_and_align_center" style="padding-bottom: 2px;height: 100%;">
                            <button class="date_p excel_btn" type="button" id="export-report" title="export report" style="height: 100%;border-radius: 5px">
                                <i class="fa fa-download"></i>&nbsp;&nbsp;Export
                            </button>
                        </div>
                    </div>
                    <div class="col mt-2" style="display: flex;justify-content: flex-end;">
                        <p style="color: #ce322d">Total Sales Tax: $<span id="total-sales-tax">0.00</span></p>
                    </div>
                </div>
            </form>

            <div class="sales_tax_table" style="">
                <table class="table align-items-center" id="sales_tax_summary" style="max-width: 100% !important;">

                    <thead style="background-color: rgba(50, 50, 50, 1) !important;">
                        <tr>
                            <th scope="col" class="table_header_text order-no" data-column="order-no">Order No</th>
                            <th scope="col" class="table_header_text organization-name" data-column="organization-name">Organization Name</th>
                            <th scope="col" class="table_header_text State" data-column="State">State</th>
                            <th scope="col" class="table_header_text sales-rep" data-column="sales-rep">Sales Person</th>
                            <th scope="col" class="table_header_text production-date" data-column="production-date">Production Date</th>
                            <th scope="col" class="table_header_text order_status" data-column="created-date">Order Status</th>
                            <th scope="col" class="table_header_text order_total" data-column="production-date">Order Total</th>
                            <th scope="col" class="table_header_text sales_tax_rate" data-column="sales_tax_rate">Sales Tax Rate(%)</th>
                            <th scope="col" class="table_header_text sales_tax" data-column="sales_tax">Sales Tax ($)</th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
{{-- "pageLength": $('#page_length').val(), --}}
<script>
    $(document).ajaxStart(function () {
        $('.se-pre-con').show();
    }).ajaxStop(function () {
        $('.se-pre-con').fadeOut();
    });

    $(document).ready(function() {

        $('.summary-datepicker').datepicker({
            dateFormat: 'mm/dd/yy'
        });

        let table = $('#sales_tax_summary').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            scrollX: true,
            searching: false,
            ordering: true,
            responsive: true,
            info: false,
            lengthChange: true,
            autoWidth: true,
            pageLength: 150, // <-- default 150 rows per page
            lengthMenu: [50, 100, 150, 200],

            ajax: {
                url: "{{ route('sales.tax.report.data') }}",
                type: "POST",
                data: function (d) {
                    d._token     = "{{ csrf_token() }}";
                    d.start_date = $('#start_date').val();
                    d.end_date   = $('#end_date').val();
                },
                dataSrc: function(json) {
                    // Update total sales tax span
                    $('#total-sales-tax').text(json.total_sales_tax);
                    return json.data;
                }
            },

            columns: [
                { data: 'order_no', className: 'text-center' },
                { data: 'organization_name' },
                { data: 'state', className: 'text-center' },
                { data: 'sales_person' },
                { data: 'production_date', className: 'text-center' },
                { data: 'order_status', className: 'text-center' },
                { data: 'order_total', className: 'text-right' },
                { data: 'sales_tax_rate', className: 'text-right' },
                { data: 'sales_tax', className: 'text-right' },
            ]
        });

        // FILTER BUTTON
        $('#pin-filter').on('click', function () {
            table.ajax.reload();
        });

        $('#export-report').on('click', function() {
            let start_date = $('#start_date').val();
            let end_date   = $('#end_date').val();

            // Create form dynamically to POST
            let form = $('<form action="{{ route("sales.tax.export") }}" method="POST" target="_blank"></form>');
            form.append('@csrf');
            form.append('<input type="hidden" name="start_date" value="' + start_date + '">');
            form.append('<input type="hidden" name="end_date" value="' + end_date + '">');

            $('body').append(form);
            form.submit();
            form.remove();
        });


    });



</script>

@endsection
