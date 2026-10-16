@extends('layouts.app', ['activePage' => 'tax_report', 'titlePage' => __('Tax Report')])

@section('content')
<style>
    .form-field {
        display: flex;
        margin-bottom: 1rem;
        flex-direction: row;
        flex-wrap: nowrap;
        align-items: center;
    }
    .form-lable {
        width: 33%;
    }
    .form-input,
    .select2.select2-container {
        width: 100% !important;
    }
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
    div.alphabet {
        display: table;
        width: 100%;
        margin-bottom: 1em;
    }
    div.alphabet span {
        display: table-cell;
        color: #b3b3b3;
        cursor: pointer;
        text-align: center;
        width: 3.5%;
        border: 1px solid #e8e8e8;
    }
    div.alphabet span:hover {
        box-shadow: 2px 2px 5px #e8e8e8;
    }
    div.alphabet span.active {
        color: black;
    }
    .user_dp {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }
    .check-image {
        width: 50%;
        height: 200px;
        padding: 5px;
        overflow: hidden;
    }
    .check-image img {
        width: 70%;
        transition: all 1s;
    }
    .check-image img:hover  {
        opacity: 0.5;
    }
    .venmo-image {
        width: auto;
        height: 200px;
        padding: 5px;
        overflow: hidden;
    }
    .venmo-image img {
        width: auto;
        height: 200px;
        transition: all 1s;
    }
    .venmo-image img:hover  {
        opacity: 0.5;
    }
    .export-btn {
        padding: 0.2rem;
        background-color: #787878;
        color: white;
        width: 85px;
        position: relative;
        right: -73px;
    }
    .btn-position {
        position: relative;
        top: -12px;
    }
    .add-btn-text {
        position: relative;
        right: -13px;
    }
    .btns-text {
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
    }
    .btns-text:hover {
        color: #909090 ;
    }
    .btns-style {
        width: 100%;
        height: 100%;
        background-color: #909090;
        border: unset;
        border-radius: 5px;
    }
    .btns-card:hover {
        background-color: #ffffff
    }
    .btns-padding {
        padding-left: 0.2rem;
        padding-right: 0.2rem;
    }
    .btns-right-position {
        position: relative;
        right: 14px;
    }
    .btn-top {
        position: relative;
        top: 11px;
    }
    .content-position {
        position: relative;
        top: -45px;
    }
    .new-style-table table.dataTable thead .sorting:before,table.dataTable thead .sorting_asc:before,table.dataTable thead .sorting_desc:before,table.dataTable thead .sorting_asc_disabled:before,table.dataTable thead .sorting_desc_disabled:before {
        content: "\f0de";
        font-family: FontAwesome;
    }
    .new-style-table table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:after,table.dataTable thead .sorting_asc_disabled:after,table.dataTable thead .sorting_desc_disabled:after {
        content: "\f0dd";
        font-family: FontAwesome;
        right: .65rem !important;
    }
    .new-style-table table thead tr{
        background-color: grey;
        color: white;
        height: 40px;
        font-size: .7rem;
    }
    .new-style-table table tr{
        background-color: white;
        color: grey;
        min-height: 40px;
        font-size: .7rem;
        border-bottom: 1px solid #b3b3b3;
        border-top: 1px solid #e9ecef !important;
    }
    .new-style-table table tbody tr:hover{
        background-color: #f6f6ff;
    }
    .new-style-table th, .new-style-table td {
        padding: 10px;
        vertical-align: middle !important;
    }
    .new-style-table .dataTables_info {
        color:#b3b3b3;
    }
    .card{
        background-color: white;
        border: none;
        border-radius: 0rem;
    }
    .styled-button{
        outline: unset;
        color: #d3d3d3;
        background-color: #fafafa;;
        border: 1px solid #d3d3d3;
        padding: .3rem;
        padding-left: .7rem;
        padding-right: .7rem;
        margin: 0rem;
        cursor: pointer;
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
    .table-responsive .table tbody td , .table-responsive .table tbody td a {
        padding: 0.4rem 1rem !important;
        font-size: .9rem !important;
        color: rgba(22, 22, 23, 1) !important;
    }
    .btn-inside-table button{
        width: 100% !important;
        padding: 5% 3% !important;
        font-size: .7rem !important;
        height: 2.1rem;
        font-size: .7rem !important;
    }
    body {
        font-family: 'Open Sans', 'sans-serif' !important;
    }
    .new-style-table table thead tr {
        background-color: rgba(50, 50, 50, 1) !important;
        height: 40px;
    }
    .color_div {
        width: 12px;
        height: 7px;
        margin-top: 5px;
        margin-right: 10px;
        border-radius: 3px;
    }
    .filter_div {
        margin-top: 15px;
        margin-bottom: 15px;
        border-radius: 2px;
        border: unset;
        padding: 10px;
    }
    .filter_row {
        margin-left: unset;
        padding-left: 8px;
        padding-right: 9px;
        background-color: #F8F8F8;
        border: 1px solid#DEDEDE;
        border-radius: 16px;
        padding-top: 2px;
    }
    .date_p {
        margin: unset;
        font-size: 11px;
        color: #B3B3B3;
        font-weight: 500;
    }
    .date_selection {
        background-color: transparent;
        padding: unset;
        border: unset;
        color: #47D6B6;
        font-size: 11px;
    }
    .date_p:hover {
        color: #B3B3B3 !important;
    }
    .row_padding {
        padding-top: 10px !important;
        padding-bottom: 10px !important;
    }
    .filter_btn {
        padding: 4px;
        text-align: center;
        width: 5rem;
        padding-right: 6px;
        background-color: rgb(0, 254, 0);
        border-radius: 5px;
        cursor: pointer;
        color: white !important;
        margin: 0rem .5rem;
    }
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
        padding-right: 1%;
        padding-left: 1%;
    }
    .order_list_topic {
        color: black;
        font-size: 19px;
    }
</style>

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="row" style="padding-left: 1rem;padding-right: 1rem;">
                <div class="col-md-12">
                    <div class="card filter_div">
                        @php
                            $startDate = request()->get('start_date') ?? '';
                            $endDate = request()->get('end_date') ?? '';
                            $orderType = request()->get('order_type') ?? 'all';
                            $salesTaxSum = 0;
                            $numberOfOrders = count($orders);
                        @endphp
                        <div class="row" style="padding-left: 25px;">
                            <div style="margin-right: 20px;">
                                <div class="row filter_row">
                                    <p class="font_color date_p">Date Range | </p>
                                    <input class="date_selection" type="date" id="start-date" name="start-date" max="" value="{{ $startDate }}">
                                    <p class="font_color date_p">&nbsp; &nbsp; &nbsp;</p>
                                    <input class="date_selection" type="date" id="end-date" name="end-date" max="" value="{{ $endDate }}">
                                </div>
                            </div>
                            <div style="margin-right: 20px;">
                                <div class="row filter_row" style="padding-bottom: 2px;">
                                    <p class="font_color date_p">Order Type |  </p>
                                    <div class="paymen_type_div date_selection">
                                        <select id="orderType" class="date_selection">
                                            <option value="all" {{ $orderType == 'all' ? 'selected' : '' }}>All Orders</option>
                                            <option value="tsr" {{ $orderType == 'tsr' ? 'selected' : '' }}>Team Store Orders</option>
                                            <option value="bulk" {{ $orderType == 'bulk' ? 'selected' : '' }}>Bulk Orders</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-left: 20px;">
                                <div class="row" style="padding-bottom: 2px;">
                                    <a href="#" class="date_p filter_btn" id="pin-filter" title="Filter">
                                        <i class="fa fa-filter" style="padding-left: 5px; padding-top: 4px; padding-right: 5px;"></i>
                                        Filter
                                    </a>
                                </div>
                            </div>
                            <div style="margin-left: 20px;">
                                <div class="row" style="padding-bottom: 2px;">
                                    <a href="#" class="date_p filter_btn" id="reset-filter" title="Filter" style="background-color:#b3b3b3">
                                        <i class="fa fa-times" style="padding-left: 5px; padding-top: 4px; padding-right: 5px;"></i>
                                        Clear
                                    </a>
                                </div>
                            </div>
                            @can('create people')
                                <button class="styled-button ml-auto" style="outline: unset;" href="#" onclick="exportReport()" title="Export CSV">
                                    CSV Export
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="col-md-12 new-style-table">
                    <div class="table-responsive">
                        <table class="table align-items-center table-responsive" id="tax_report_table">
                            <thead class="header-style">
                                <th style="text-align: center;" class="order-no" scope="col">Order #</th>
                                <th style="text-align: center;" class="org-name" scope="col">Organization Name</th>
                                <th style="text-align: center;" class="state" scope="col">State</th>
                                <th style="text-align: center;" class="sales-person" scope="col">Sales Person</th>
                                <th style="text-align: center;" class="production-date" scope="col">Production Date</th>
                                <th style="text-align: center;" class="order-status" scope="col">Order Status</th>
                                <th style="text-align: center;" class="order-total" scope="col">Order Total</th>
                                <th style="text-align: center;" class="sales-tax-rate" scope="col">Sales Tax Rate(%)</th>
                                <th style="text-align: center;" class="sales-tax" scope="col">Sales Tax ($)</th>
                            </thead>

                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td style="text-align-last: left;" class="order-no">
                                            <a href="#" class="edit-order" data-value="{{$order->order_no}}">{{$order->order_no}}</a>
                                        </td>
                                        <td style="text-align-last: left;" class="org-name">{{ $order->organizationDetails->organization_name ?? 'N/A' }}</td>
                                        <td style="text-align-last: left;" class="state">{{ $order->organizationDetails->shipping_state ?? 'N/A' }}</td>
                                        <td style="text-align-last: left;" class="sales-person">{{ $order->userDetails->name ?? 'N/A' }}</td>
                                        <td style="text-align-last: center;" class="production-date">{{ $order->production_date ? \Carbon\Carbon::parse($order->production_date)->format('m/d/Y') : 'N/A' }}</td>
                                        <td style="text-align-last: right;" class="order-status">{{ $order->statusDetails->status_name }}</td>
                                        <td style="text-align-last: right;" class="order-total">$ {{ number_format($order->sub_total, 2) }}</td>
                                        <td style="text-align-last: right;" class="sales-tax-rate">{{ $order->organizationDetails->sales_tax ?? '0' }}%</td>
                                        <td style="text-align-last: right;" class="sales-tax">$ {{ number_format($order->sales_tax ?? 0, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="8" style="text-align: right;font-size: 1.2rem;color:black">Total Sales Tax:</th>
                                    <th style="text-align: right;font-size: 1.2rem;color:black">$ {{ number_format($orders->sum('sales_tax'), 2) }}</th>
                                </tr>
                                <tr>
                                    <th colspan="8" style="text-align: right;font-size: 1rem;color:black">Number of Orders:</th>
                                    <th style="text-align: right;font-size: 1rem;color:black">{{ $numberOfOrders }}</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#tax_report_table').DataTable({
            lengthMenu: [100, 300, 500],
            pageLength: 100,
            order: [[4, 'asc']],
            columnDefs: [
                {
                    targets: ['production-date', 'created-at'],
                    type: 'date',
                }
            ]
        });
    });

    function exportReport() {
        $('.se-pre-con').fadeIn();

        let startDate = $('#start-date').val();
        let endDate = $('#end-date').val();
        let orderType = $('#orderType').val();

        $.ajax({
            url: "{{ route('tax_report.export') }}",
            method: "POST",
            data: {
                start_date: startDate,
                end_date: endDate,
                order_type: orderType,
                _token: "{{ csrf_token() }}"
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response, status, xhr) {
                let filename = "tax_report.xlsx";
                let disposition = xhr.getResponseHeader('Content-Disposition');
                if (disposition && disposition.indexOf('filename=') !== -1) {
                    filename = disposition.split('filename=')[1].replace(/"/g, '');
                }

                let link = document.createElement('a');
                link.href = window.URL.createObjectURL(response);
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            },
            complete: function() {
                $('.se-pre-con').fadeOut();
            },
            error: function(err) {
                alert("Error exporting report. Please try again.");
            }
        });
    }

    $("body").on("click", ".edit-order", function(){
        var orderId = $(this).data('value');
        window.open('order_details/edit/'+orderId+'/order?active_tab=order', '_blank');
    });
    $('#pin-filter').on('click', function() {
        var startDate = $('#start-date').val();
        var endDate = $('#end-date').val();
        var orderType = $('#orderType').val();
        var url = "{{ url('tax_report') }}";
        var queryParams = [];

        if (startDate) {
            queryParams.push('start_date=' + encodeURIComponent(startDate));
        }
        if (endDate) {
            queryParams.push('end_date=' + encodeURIComponent(endDate));
        }
        if (orderType) {
            queryParams.push('order_type=' + encodeURIComponent(orderType));
        }

        if (queryParams.length > 0) {
            url += '?' + queryParams.join('&');
        }

        window.location.href = url;
    });
    $('#reset-filter').on('click', function() {
        window.location.href = "{{ url('tax_report') }}";
    });
</script>
@endsection
