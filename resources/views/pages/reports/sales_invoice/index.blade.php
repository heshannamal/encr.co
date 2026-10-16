@extends('layouts.app', ['activePage' => 'order', 'titlePage' => __('Pdf')])

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
        padding-right: 1%;
        padding-left: 1%;
    }
    .order_list_topic {
        color: black;
        font-size: 19px;
    }
    .table_header_text {
        color: white;
        height: 40px;
    }
    .table-bottom-details2 {
        color: #020202;
        padding-bottom: 12px !important;
        padding-top: 12px !important;
    }
    .header-layout {
        margin-bottom: 2rem !important;
    }
    .font_color {
        color: #020202
    }
    .total_summary_card {
        border: unset;
        border-radius: 2px;
        padding: 10px;
    }
    .sub_card {
        background-color: #FCFCFC;
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
    .bargraph_header {
        color: black;
        font-size: 17px;
    }
    .page-item.active .page-link {
        color: #4e4e4e;
    }
    .page-item.active .page-link {
        color: #fff;
        border-color: #cccccc;
        background-color: #cccccc;
        box-shadow: 0 3px 10px rgba(50, 50, 93, .1), 0 3px 10px rgba(0, 0, 0, .08);
    }
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
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
</style>

@if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif
<div id="buffering_icon1" style="display: none;">
    <img src="{{ asset('argon') }}/img/icons/buffering_icon.gif" />
</div>

<div class=" mb-5 content-position ">

    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Sales Invoice Summary Report</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection


    <div class="col-md-12 "  style="padding-bottom: 25px !important;">

        <div class="card total_summary_card">
            <div class="row">
                <div class="col-md-3 sub_card">
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style="background-color: #068267;"></div>
                        <b style="font-weight: 500;"class="font_color">Total Invoices</b>
                    </div>
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style=""></div>
                        <strong style="font-size: 17px;" class="font_color">{{ $totalOrderCount }}</strong>
                    </div>
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style=""></div>
                        <p style="color: #818181; font-size: 11px; margin: unset;" class="font_color">Amount : $ {{ $totalOrderAmount }}</p>
                    </div>
                </div>

                <div class="col-md-3 sub_card">
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style="background-color: #55A630;"></div>
                        <b style="font-weight: 500;"class="font_color">Paid Invoices</b>
                    </div>
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style=""></div>
                        <strong style="font-size: 17px;" class="font_color">{{ $paidOrderCount }}</strong>
                    </div>
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style=""></div>
                        <p style="color: #818181; font-size: 11px; margin: unset;" class="font_color">Amount : $ {{ $paidOrderTotal }}</p>
                    </div>
                </div>

                <div class="col-md-3 sub_card">
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style="background-color: #023E8A;"></div>
                        <b style="font-weight: 500;"class="font_color">Partial Payment Invoices</b>
                    </div>
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style=""></div>
                        <strong style="font-size: 17px;" class="font_color">{{ $partialOrderCount }}</strong>
                    </div>
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style=""></div>
                        <p style="color: #818181; font-size: 11px; margin: unset;" class="font_color">Amount : $ {{ $partialOrderTotal }}</p>
                    </div>
                </div>

                <div class="col-md-3 sub_card">
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style="background-color: #FFB916;"></div>
                        <b style="font-weight: 500;"class="font_color">Pending Payment Invoices</b>
                    </div>
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style=""></div>
                        <strong style="font-size: 17px;" class="font_color">{{ $pendingOrderCount }}</strong>
                    </div>
                    <div class="row" style="padding-left: 20px;">
                        <div class="color_div" style=""></div>
                        <p style="color: #818181; font-size: 11px; margin: unset;" class="font_color">Amount : $ {{ $pendingOrderTotal }}</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="card filter_div">
            <div class="row" style="padding-left: 25px;">
                <div style="margin-right: 20px;">
                    <div class="row filter_row">
                        <p class="font_color date_p">Date Range | </p>
                        <input class="date_selection" type="date" id="start-date" name="start-date" max="" value="">
                        <i class="fa fa-arrow-right date_p" style="padding-left: 5px; padding-top: 4px; padding-right: 5px;"></i>
                        <input class="date_selection" type="date" id="end-date" name="end-date" max="" value="">
                    </div>
                </div>

                <div style="margin-right: 20px;">
                    <div class="row filter_row" style="padding-bottom: 2px;">
                        <p class="font_color date_p">Payment Type |  </p>
                        <div class="paymen_type_div date_selection">
                            <select id="paymentType" class="date_selection">
                                <option value="all">All</option>
                                <option value="Online">Card</option>
                                <option value="Check">Check</option>
                                <option value="Venmo">Venmo</option>
                                <option value="Paypal">Paypal</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div style="margin-right: 20px;">
                    <div class="row filter_row" style="padding-bottom: 2px;">
                        <p class="font_color date_p">Payment Status |  </p>
                        <div class="paymen_type_div date_selection">
                            <select id="paymentStatus" class="date_selection">
                                <option value="all">All</option>
                                <option value="Paid">Paid</option>
                                <option value="Partial">Partial</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div style="margin-right: 20px;">

                </div>

                <div style="margin-left: 20px; ">
                    <div class="row" style="padding-bottom: 2px;">
                        <a href="#" class="date_p filter_btn" id="pin-filter" title="Filter">
                            <i class="fa fa-filter " style="padding-left: 5px; padding-top: 4px; padding-right: 5px;"></i>
                            Filter
                        </a>
                    </div>
                </div>

                <div class="ml-auto print_btn">
                    <a class="top_button download_btn export_btn" href="#"><i class="fa fa-download" style="margin-right: 8px;"></i></a>
                </div>
                <div class="ml-auto print_btn" style="margin-left: unset !important; margin-right: 1%;">
                    <a class="top_button print_button" href="#"><i class="fa fa-print" style="margin-right: 8px;"></i></a>
                </div>
            </div>
        </div>


        <div class="card orders_summary print_content" style="border: unset; padding: 10px;">


            <div style="padding: 5px;">
                {{-- <b class="bargraph_header font_color">Sales Invoice Summary</b> --}}
                <select id="itemsPerPageSelect" onchange="changeItemsPerPage(this.value)">
                    <option value="10">10 per page</option>
                    <option value="20" selected>20 per page</option>
                    <option value="30">30 per page</option>
                    <option value="50">50 per page</option>
                </select>
            </div>


            <div class="order_sammary_table" style="overflow-x: auto; height: 100%;">
                <table class="table align-items-center" id="order_sammary_table" style="min-width: 100%;">

                    <thead style="background-color: #717070;">
                        <th scope="col" class="table_header_text">ORDER ID</th>
                        <th scope="col" class="table_header_text">ORGANIZATION </th>
                        <th scope="col" class="table_header_text">TOTAL ($)  </th>
                        <th scope="col" class="table_header_text">PAID ($)</th>
                        <th scope="col" class="table_header_text">PAYMENT STATUS </th>
                        <th scope="col" class="table_header_text">PAYMENT APPROVAL </th>
                        <th scope="col" class="table_header_text">PAYMENT TYPE </th>
                        <th scope="col" class="table_header_text">CREATED DATE </th>
                        <th scope="col" class="table_header_text">IN HAND DUE DATE </th>
                    </thead>

                    <tbody id="table_body">

                    </tbody>
                </table>



            </div>
            <div style="padding-top: 10px;">
                <div id="paginationbarUrgent" class="row justify-content-center" style="width: 100%;">
                  {{-- pagination bar paste here --}}
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){
        $(".se-pre-con").fadeOut('slow');
    });

    const startDateInput = document.getElementById('start-date');

    const today = new Date().toISOString().split('T')[0];
    startDateInput.max = today;
    startDateInput.value = today;

    startDateInput.addEventListener('input', () => {
        startDateInput.blur();
    });

    const endDateInput = document.getElementById('end-date');

    endDateInput.max = today;
    endDateInput.value = today;

    endDateInput.addEventListener('input', () => {
        endDateInput.blur();
    });

    var ordersPerPage = 20; // Default number of orders per page
    var maxPaginationLinks = 10; // Maximum number of pagination links to display
    var currentPage = 1; // Initialize the current page
    var transactionsArray = @json($firstTenItems); // Assuming this contains your initial data

    function setupPaginationInvoice(data) {
        var totalPages = Math.ceil(data.length / ordersPerPage);

        if (totalPages >= 1) {
            var pagination = '<nav aria-label="Page navigation"><ul class="pagination">';
            pagination += '<li class="page-item"><a class="page-link" href="#" data-page="prev" style="">&laquo;</a></li>';

            var startPagination = 1;
            var endPagination = Math.min(maxPaginationLinks, totalPages);

            if (currentPage > Math.floor(maxPaginationLinks / 2)) {
                startPagination = currentPage - Math.floor(maxPaginationLinks / 2);
                endPagination = currentPage + Math.ceil(maxPaginationLinks / 2) - 1;

                if (endPagination > totalPages) {
                    endPagination = totalPages;
                    startPagination = endPagination - maxPaginationLinks + 1;
                }
            }

            if (startPagination < 1) {
                startPagination = 1;
            }

            // Add the first page link
            if (startPagination > 1) {
                pagination += '<li class="page-item"><a class="page-link" href="#" data-page="1" style="">1</a></li>';
                if (startPagination > 2) {
                    pagination += '<li class="page-item disabled"><a class="page-link" href="#" style="">...</a></li>';
                }
            }

            // Add the page numbers
            for (var i = startPagination; i <= endPagination; i++) {
                if (i === currentPage) {
                    pagination += '<li class="page-item active"><a class="page-link" href="#" data-page="' + i + '" style="">' + i + '</a></li>';
                } else {
                    pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + i + '" style="">' + i + '</a></li>';
                }
            }

            // Add the last page link
            if (endPagination < totalPages) {
                if (endPagination < totalPages - 1) {
                    pagination += '<li class="page-item disabled"><a class="page-link" href="#" style="">...</a></li>';
                }
                pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + totalPages + '" style="">' + totalPages + '</a></li>';
            }

            pagination += '<li class="page-item"><a class="page-link" href="#" data-page="next" style="">&raquo;</a></li>';
            pagination += '</ul></nav>';

            $('#paginationbarUrgent').empty().append(pagination);

            // Show the initial page
            showPageInvoice(currentPage, data);

            // Pagination click event
            $('#paginationbarUrgent').off('click').on('click', '.page-link', function(e) {
                e.preventDefault();

                var page = $(this).data('page');

                if (page === 'prev') {
                    currentPage = Math.max(1, currentPage - 1);
                } else if (page === 'next') {
                    currentPage = Math.min(totalPages, currentPage + 1);
                } else {
                    currentPage = parseInt(page);
                }

                // Update pagination visibility
                startPagination = 1;
                endPagination = Math.min(maxPaginationLinks, totalPages);

                if (currentPage > Math.floor(maxPaginationLinks / 2)) {
                    startPagination = currentPage - Math.floor(maxPaginationLinks / 2);
                    endPagination = currentPage + Math.ceil(maxPaginationLinks / 2) - 1;

                    if (endPagination > totalPages) {
                        endPagination = totalPages;
                        startPagination = endPagination - maxPaginationLinks + 1;
                    }
                }

                if (startPagination < 1) {
                    startPagination = 1;
                }

                pagination = '<nav aria-label="Page navigation"><ul class="pagination">';
                pagination += '<li class="page-item"><a class="page-link" href="#" data-page="prev" style="">&laquo;</a></li>';

                // Add the first page link
                if (startPagination > 1) {
                    pagination += '<li class="page-item"><a class="page-link" href="#" data-page="1" style="">1</a></li>';
                    if (startPagination > 2) {
                        pagination += '<li class="page-item disabled"><a class="page-link" href="#" style="">...</a></li>';
                    }
                }

                // Add the page numbers
                for (var i = startPagination; i <= endPagination; i++) {
                    if (i === currentPage) {
                        pagination += '<li class="page-item active"><a class="page-link" href="#" data-page="' + i + '" style="">' + i + '</a></li>';
                    } else {
                        pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + i + '" style="">' + i + '</a></li>';
                    }
                }

                // Add the last page link
                if (endPagination < totalPages) {
                    if (endPagination < totalPages - 1) {
                        pagination += '<li class="page-item disabled"><a class="page-link" href="#" style="">...</a></li>';
                    }
                    pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + totalPages + '" style="">' + totalPages + '</a></li>';
                }

                pagination += '<li class="page-item"><a class="page-link" href="#" data-page="next" style="">&raquo;</a></li>';
                pagination += '</ul></nav>';

                $('#paginationbarUrgent').empty().append(pagination);

                showPageInvoice(currentPage, data);
            });

            // Always show the previous and next link buttons
            $('#paginationbarUrgent .page-item:first-child').removeClass('d-none');
            $('#paginationbarUrgent .page-item:last-child').removeClass('d-none');
        }
    }



    function showPageInvoice(pageNum, data) {
        var startIndex = (pageNum - 1) * ordersPerPage;
        var endIndex = startIndex + ordersPerPage;

        // Get the table body element
        var tableBody = document.getElementById('table_body');

        // Clear existing rows in the table body
        tableBody.innerHTML = '';

        var totalAmount = 0;
        var orderTotalAmount = 0;

        // Show only the relevant rows
        data.slice(startIndex, endIndex).forEach(transaction => {
            var row = tableBody.insertRow();

            var paymentTypesHtml = transaction.details.paymentTypes.map(type => `<span class="badge badge-pill">${type}</span>`).join(' ');

            var orderStatusBadge;
            if (transaction.details.paymentStatus === 'Paid') {
                orderStatusBadge = '<span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:100%">Paid</span>';
            } else if (transaction.details.paymentStatus === 'Partial') {
                orderStatusBadge = '<span class="badge badge-pill" style="color:#023E8A;background-color:#D4E6FD; width:100%">Partial</span>';
            } else {
                orderStatusBadge = '<span class="badge badge-pill" style="color:#FFB916;background-color:#FFF6CC;width:100%">Pending</span>';
            }

            var checkStatusBadge;

            if (transaction.details.paymentApproval === 'Approved') {
                checkStatusBadge = '<span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:100%">Approved</span>';
            } else if (transaction.details.paymentApproval === 'Rejected') {
                checkStatusBadge = '<span class="badge badge-pill" style="color:#d65a47;background-color:#ffcccc;width:100%">Rejected</span>';
            } else {
                checkStatusBadge = '<span class="badge badge-pill" style="color:#d381ff;background-color:#f9dfff;width:100%">Not Approved</span>';
            }

            row.innerHTML = `
                <td class="font_color row_padding"><a href="#" class="edit-order" data-value="${transaction.details.order.id}">${transaction.details.order.order_no}</a></td>
                <td class="font_color row_padding">${transaction.details.organization.organization_name}</td>
                <td class="font_color row_padding" style="text-align: right;">${transaction.details.order.order_total.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                <td class="font_color row_padding" style="text-align: right;">${transaction.details.payedAmount}</td>
                <td class="font_color row_padding">${orderStatusBadge}</td>
                <td class="font_color row_padding">${checkStatusBadge}</td>
                <td class="font_color row_padding">${paymentTypesHtml}</td>
                <td class="font_color row_padding">${transaction.details.order.open_date}</td>
                <td class="font_color row_padding">${transaction.details.order.due_date}</td>
            `;

            totalAmount += parseFloat(transaction.details.paymentCal);
            orderTotalAmount += parseFloat(transaction.details.order.order_total);
        });

        // Add row for total amount
        var totalRow = tableBody.insertRow();
        totalRow.innerHTML = `
            <td style="background-color: #F5F5F5;"></td>
            <td class="font_color row_padding" style="text-align:right;background-color: #F5F5F5;">Total Amount</td>
            <td class="font_color row_padding" style="text-align:right;background-color: #F5F5F5;">${orderTotalAmount.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
            <td style="background-color: #F5F5F5;"></td>
            <td style="background-color: #F5F5F5;"></td>
            <td style="background-color: #F5F5F5;"></td>
            <td style="background-color: #F5F5F5;"></td>
            <td style="background-color: #F5F5F5;"></td>
            <td style="background-color: #F5F5F5;"></td>
        `;

        $('#urgenttotalamount').text(totalAmount.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
    }

    function changeItemsPerPage(items) {
        ordersPerPage = parseInt(items);
        currentPage = 1; // Reset to the first page when items per page changes
        setupPaginationInvoice(transactionsArray); // Re-setup the pagination with new items per page
    }

    // Initial setup with the first set of data
    setupPaginationInvoice(transactionsArray);


    // Event listener for filter button
    document.getElementById('pin-filter').addEventListener('click', function(event) {
        event.preventDefault();

        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;
        const paymentType = document.getElementById('paymentType').value;
        const paymentStatus = document.getElementById('paymentStatus').value;

        $.ajax({
            url: '{{ route('filterSalesInvoice') }}',
            method: 'GET',
            data: {
                startDate: startDate,
                endDate: endDate,
                paymentType: paymentType,
                paymentStatus: paymentStatus
            },
            beforeSend: function () {
                // Show loader if needed
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (data) {
                console.log(data);
                updateTable(data);
            },
            error: function (error) {
                console.log('Error fetching data:', error);
            },
            complete: function () {
                // Hide loader if needed
                $(".se-pre-con").fadeOut('slow');
            }
        });
    });

    // Function to update table with new data
    function updateTable(data) {
        transactionsArray = data.combinedDetails; // Update global array with new data

        // Setup pagination with the new data
        setupPaginationInvoice(transactionsArray);

        // Reset pagination to page 1
        currentPage = 1;

        // Show the first page content
        showPageInvoice(currentPage, transactionsArray);
    }



    function printContent() {
        var content = document.querySelector('.print_content');
        var originalBody = document.body.innerHTML;
        document.body.innerHTML = content.innerHTML;
        window.print();
        document.body.innerHTML = originalBody;
    }

    document.addEventListener('DOMContentLoaded', function () {
        var printBtn = document.querySelector('.print_button');
        printBtn.addEventListener('click', function () {
            printContent();
        });
    });

    //Download CSV
    document.addEventListener('DOMContentLoaded', function () {


    var downloadBtn = document.querySelector('.download_btn');
        downloadBtn.addEventListener('click', function () {

            const startDate = document.getElementById('start-date').value;
            const endDate = document.getElementById('end-date').value;
            const paymentType = document.getElementById('paymentType').value;
            const paymentStatus = document.getElementById('paymentStatus').value;
        // console.log(startDate);
            var routeUrl = "{{ url('/salesInvoice_CSV_download/') }}" + '/' + startDate  + '/' + endDate + '/' + paymentType + '/' + paymentStatus;

            window.location.href = routeUrl;
        });
    });

    $("body").on("click", ".edit-order", function(){
        // $(".se-pre-con").fadeIn('slow');
        var orderId = $(this).data('value');
        // window.location.replace('order_details/edit/'+orderId+'/order?active_tab=order');
        window.open('order_details/edit/'+orderId+'/order?active_tab=order', '_blank');
    });

</script>

@endsection
