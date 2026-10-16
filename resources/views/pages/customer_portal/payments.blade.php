@extends('pages.customer_portal.layouts.sidebar', ['sub_active' => 'payments'])

@section('sub-sidebar-content')

<style>
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
        background-color:rgba(50, 50, 50, 1);
        color: white;
        height: 40px;
        font-size: .7rem;
    }
    .new-style-table table tr{
        background-color: white;
        color:rgba(50, 50, 50, 1);
        min-height: 40px;
        font-size: .7rem;
        border-bottom: 1px solid #b3b3b3;
        border-top: 1px solid #e9ecef !important;
    }
    .new-style-table table tr a{
        color:rgba(50, 50, 50, 1) !important;
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
    .searchbox-layout{
        margin-top: 0 !important;
        width: 100% !important;
        height: 29px;
        font-size: .7rem;
        color: #B3B3B3;
        border: unset;
    }
    .table-container {
        overflow-x: auto; /* Enable horizontal scrolling */
        width: 100%; /* Set the container's width */
        white-space: nowrap; /* Prevent line breaks */
    }

    .table {
        min-width: 100%; /* Ensure the table fills the container */
    }
    /* select styles */
    .select-ellipse-styles{
        border: 1px solid #b3b3b3;
        border-radius: 1rem;
        color: #47D6B6;
        width: fit-content;
        padding: .1rem .5rem;
    }
    /* pagination */
    #pagination {
        text-align: right; /* Align pagination to the right */
        margin-top: 10px; /* Add some space between the table and pagination */
    }

    #pagination a {
        display: inline-block;
        cursor: pointer;
    }
    .page-link {
        line-height: 1.25;
        position: relative;
        display: block;
        margin-left: -1px;
        padding: .5rem .75rem;
        color: #8898aa;
        border: 1px solid #dee2e6;
        background-color: #fff;
        margin: .1rem;
    }

    #pagination a:hover {
        background-color: #e9ecef;
    }

    #pagination .active {
        background-color: #dedede;
        color: #fff;
    }
    .order-status{
        color: white;
        padding: .2rem .7rem;
        border-radius: 1rem;
    }
</style>
@section('portal-header')
    PAYMENTS
@endsection
<div class="container-fluid" style="padding: 0px;">
    <div class="col-md-12 mt-2 pb-3" style="padding-right: 1rem;">
        <table style="width: 100%;border-bottom:1px solid #b3b3b3">
            <tr style="height: 4rem;">
                <td style="width: 11%;">
                    Show rows per page
                </td>
                <td style="width: 8%;">
                    <div class="select-ellipse-styles">
                        <select id="num_of_rows" onchange="pagination_function()" style="border: none;color: #47D6B6;outline:unset">
                            <option value="10">10</option>
                            <option value="20" selected>20</option>
                            <option value="30">30</option>
                        </select>
                    </div>
                </td>
                <td style="width: 20%">
                    <div class="row" style="width: 100%;">
                        <div class="col-lg-1" style="border-bottom: 1px solid #B3B3B3 !important;">
                            <i class="fa fa-search" aria-hidden="true" style="font-size: 19px;color: #B3B3B3;top: 23%;position: relative;"></i>
                        </div>
                        <div class="col-lg-10 text-center" style="border-bottom: 1px solid #B3B3B3 !important;">
                            <input class="searchbox-layout"  type="text" id="searchbox" placeholder="Order Search">
                        </div>
                    </div>
                </td>
                <td style="width: 15%;">
                    <div class="select-ellipse-styles" style="color: grey;background-color: #fafafa;">
                        Status &nbsp;&nbsp;
                        <select style="border: none;outline:unset;color:#47D6B6;width: 5rem;background-color: #fafafa;" id="status_filter">
                            <option value="Pending">Pending</option>
                            <option value="Partial">Partial</option>
                            <option value="Paid">Paid</option>
                        </select>
                    </div>
                </td>
                <td>
                    <div class="col-lg-8">
                        <button type="button" style="background-color:transparent;color:grey;border:none" id="filter_save_option" title="Filter & Save"><i class="fas fa-solid fa-thumbtack fa-2xs" style="color: #787878;"></i>&nbsp;&nbsp;PIN FILTER RESULTS</button>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-md-12 mt-2 new-style-table" style="padding-right: 19px;">
        <div style="width: 100%; overflow-x: auto;">
            <table class="table align-items-center cell-border" id="order-payments-table">
                <thead>
                    <th class="text-center" style="color: white">ORDER NO</th>
                    <th style="color: white">SALES REP</th>
                    <th class="text-center" style="color: white">OPEN DATE</th>
                    <th class="text-center" style="color: white">PAYMENT STATUS</th>
                    <th class="text-right" style="color: white">SALES TAX ($)</th>
                    <th class="text-right" style="color: white">TOTAL ($)</th>
                </thead>

                <tbody id="paymentsTableBody">
                    @foreach ($payments as $orderId => $payment)
                    @php
                        $order = App\Models\Order::find($orderId);
                    @endphp


                    @php
                        if ($payment['paymentStatus'] == 0) {
                            $payment_status = "PENDING";
                            $payment_bg_color = '#ff5252'; $payment_color = 'white';
                        } elseif ($payment['paymentStatus'] == 1) {
                            $payment_status = "PARTIAL";
                            $payment_bg_color = '#fff052'; $payment_color = 'white';
                        }  else {
                            $payment_status = "PAID";
                            $payment_bg_color = '#0f9f00'; $payment_color = '#b0ffc4';
                        }
                    @endphp
                        <tr>
                            <td class="text-center">
                                @if(str_starts_with($order->order_no, 'TSR'))
                                {{ $order->order_no }}
                                @else
                                    <a href="{{ route('customer_portal.payment_edit', [
                                        'orderId' => $payment['orderDetail']->id,
                                        'sub_total' => number_format($payment['orderDetail']->sub_total, 2),
                                        'salesTax' => number_format($payment['orderDetail']->sales_tax, 2),
                                        'shipping' => number_format($payment['orderDetail']->shipping, 2),
                                        'artwork' => number_format($payment['orderDetail']->artwork, 2),
                                        'processingFee' => number_format($payment['orderDetail']->processing_fee, 2),
                                        'orderTotal' => number_format($payment['orderDetail']->order_total, 2),
                                        'balancePayment' => number_format($payment['balanceToBePaid'], 2),
                                        'qtySum' => ''
                                    ]) }}" disabled>
                                        {{ $order->order_no }}
                                    </a>
                                @endif
                            </td>
                            <td class="text-left">{{ $users->where('id' , $payment['orderDetail']->user_id)->first()->name ?? '' }}</td>
                            <td class="text-center">{{ $payment['orderDetail']->open_date }}</td>
                            <td class="text-center status-column">
                                <span class="order-status" @if(str_starts_with($order->order_no, 'TSR')) style="background-color: #0f9f00;color:#b0ffc4" @else style="background-color: {{$payment_bg_color}};color:{{$payment_color}}" @endif>@if(str_starts_with($order->order_no, 'TSR')) PAID @else {{$payment_status}} @endif</span>
                            </td>
                            <td class="text-right">{{ number_format($payment['orderDetail']->sales_tax, 2) }}</td>
                            <td class="text-right">{{ number_format($payment['orderDetail']->order_total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-12" id="pagination"></div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    pagination_function();
    function pagination_function() {
    $('#pagination').empty();

    var rowsPerPage = parseInt($('#num_of_rows').val()); // Ensure rowsPerPage is parsed as an integer
    var currentPage = 1;
    var tableRows = $('#paymentsTableBody tr'); // Select tbody rows

    // Function to show/hide rows based on the current page
    function showPage(page) {
        var startIndex = (page - 1) * rowsPerPage;
        var endIndex = Math.min(startIndex + rowsPerPage, tableRows.length);

        // Ensure all rows are initially hidden before showing specific rows
        tableRows.hide();

        // Show rows within the range of the current page
        tableRows.slice(startIndex, endIndex).show();

        // Highlight the active pagination link
        $('#pagination a').removeClass('active');
        $('#pagination a[data-page="' + page + '"]').addClass('active');
    }

    // Initialize pagination
    function initPagination() {
        var totalPages = Math.ceil(tableRows.length / rowsPerPage);
        var pagination = $('#pagination');
        pagination.empty();

        // Previous button
        var prevLink = $('<a class="page-link" href="#">').append('<i class="fa fa-arrow-left" aria-hidden="true"></i>');
        prevLink.click(function() {
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
            }
        });
        pagination.append(prevLink);

        // Page links
        for (var i = 1; i <= totalPages; i++) {
            var link = $('<a class="page-link" href="#">').text(i).attr('data-page', i);
            link.click(function() {
                var page = parseInt($(this).attr('data-page'));
                currentPage = page;
                showPage(currentPage);
            });
            pagination.append(link);
        }

        // Next button
        var nextLink = $('<a class="page-link" href="#">').append('<i class="fa fa-arrow-right" aria-hidden="true"></i>');
        nextLink.click(function() {
            if (currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
            }
        });
        pagination.append(nextLink);
    }

    // Show the initial page
    showPage(currentPage);

    // Initialize pagination
    initPagination();
};

function search_function() {
    var searchText = $('#searchbox').val().toLowerCase();
    $('#order-payments-table tbody tr').each(function() {
        var rowText = $(this).text().toLowerCase();
        if (rowText.includes(searchText)) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
    pagination_function();
}

$(document).ready(function() {

    $('#searchbox').on('input', function() {
        search_function();
    });

    $('#status_filter').change(function() {
        var selectedStatus = $(this).val().toLowerCase();
        $('#order-payments-table tbody tr').each(function() {
            var rowStatus = $(this).find('.status-column').text().toLowerCase();
            if (selectedStatus === '' || rowStatus === selectedStatus) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        pagination_function();
    });
});

</script>
@endsection
