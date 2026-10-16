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
        <span>Customer Payment Summary</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection


    <div class="col-md-12 "  style="padding-bottom: 25px !important;">


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

                <div style="margin-right: 20px; padding-top: 2px;">

                </div>

                <div style="margin-left: 20px;">
                    <div class="row" style="padding-bottom: 2px;">
                        <a href="#" class="date_p filter_btn" id="pin-filter" title="Filter">
                            <i class="fa fa-filter  " style="padding-left: 5px; padding-top: 4px; padding-right: 5px;"></i>
                            Filter
                        </a>
                    </div>
                </div>

                <div class="ml-auto print_btn">
                    <a class="top_button download_btn" href="#"><i class="fa fa-download" style="margin-right: 8px;"></i></a>
                </div>
                <div class="ml-auto print_btn" style="margin-left: unset !important; margin-right: 1%;">
                    <a class="top_button print_button" href="#"><i class="fa fa-print" style="margin-right: 8px;"></i></a>
                </div>
            </div>
        </div>


        <div class="card orders_summary print_content" style="border: unset; padding: 10px;">

            <div style="padding: 5px;">
                {{-- <b class="bargraph_header font_color">Customer Payment Summary</b> --}}
                <select id="transactions-per-page" onchange="updateTransactionsPerPage(this.value)">
                    <option value="10">10 per page</option>
                    <option value="20" selected>20 per page</option>
                    <option value="30">30 per page</option>
                    <option value="50">50 per page</option>
                </select>
            </div>


            <div class="order_sammary_table" style="overflow-x: auto;">
                <table class="table align-items-center" id="order_sammary_table" style="min-width: 100%;">

                    <thead style="background-color: #717070;">
                        <th scope="col" class="table_header_text">ORDER ID</th>
                        <th scope="col" class="table_header_text">PAYMENT ID</th>
                        <th scope="col" class="table_header_text">PAYMENT DATE</th>
                        <th scope="col" class="table_header_text">PAYMENT STATUS </th>
                        <th scope="col" class="table_header_text">ORGANIZATION </th>
                        <th scope="col" class="table_header_text">PAYMENT TYPE </th>
                        <th scope="col" class="table_header_text"> NAME ON CARD</th>
                        <th scope="col" class="table_header_text">PAYMENT APPROVAL</th>
                    </thead>

                    <tbody id="table_body">

                    </tbody>
                </table>


            </div>
            <div style="padding-top: 10px;">
                <div id="paginationbar" class="row justify-content-center" style="width: 100%;">
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


    var transactionsArray = @json($firstTenItems); // Initial data

    var tableBody = document.getElementById('table_body');
    var paginationBar = document.getElementById('paginationbar');
    var totalAmount = 0;
    var transactionsPerPage = 20; // Default transactions per page
    var currentPage = 1;

    // Function to show transactions
    function showTransactions(page, data) {
        tableBody.innerHTML = '';
        totalAmount = 0;

        var startIndex = (page - 1) * transactionsPerPage;
        var endIndex = startIndex + transactionsPerPage;
        var totalPages = Math.ceil(data.length / transactionsPerPage);

        for (var i = startIndex; i < endIndex && i < data.length; i++) {
            var transaction = data[i];
            var row = tableBody.insertRow();
            var amount = transaction.Amount !== null ? parseFloat(transaction.Amount) : 0;
            totalAmount += amount;

            var amount = transaction.Amount ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.Amount) : "0.00";
            var subTotal = transaction.SubTotal ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.SubTotal) : "0.00";
            var shipping = transaction.Shipping ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.Shipping) : "0.00";
            var artWork = transaction.ArtWork ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.ArtWork) : "0.00";
            var salesTax = transaction.SalesTax ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.SalesTax) : "0.00";
            var processingFee = transaction.processingFee ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.processingFee) : "0.00";
            var balnceToBePaid = transaction.balnceToBePaid ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.balnceToBePaid) : "0.00";


            var orderStatusBadge;
            if (transaction.OrderStatus === 'Paid') {
                orderStatusBadge = '<span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:100%">Paid</span>';
            } else if (transaction.OrderStatus === 'Partial') {
                orderStatusBadge = '<span class="badge badge-pill" style="color:#023E8A;background-color:#D4E6FD; width:100%">Partial</span>';
            } else {
                orderStatusBadge = '<span class="badge badge-pill" style="color:#FFB916;background-color:#FFF6CC;width:100%">Pending</span>';
            }

            var checkStatusBadge;
            if (transaction.checkStatus === 'Not Approved') {
                checkStatusBadge ='<span class="badge badge-pill" style="color:#d381ff;background-color:#f9dfff;width:100%">Not Approved</span>';
            } else if (transaction.checkStatus === 'Approved') {
                checkStatusBadge = '<span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:100%">Approved</span>';
            } else if (transaction.checkStatus === 'Rejected') {
                checkStatusBadge = '<span class="badge badge-pill" style="color:#d65a47;background-color:#ffcccc;width:100%">Rejected</span>';
            } else {
                checkStatusBadge = '<span class="badge badge-pill" style="color:#FFB916;background-color:#ffffcc;width:100%">Payed</span>';
            }

            var paymentDate = new Date(transaction.PaymentDate);
            var formattedPaymentDate = paymentDate.toISOString().split('T')[0];

            var paymentRoute = "{{ route('payment') }}";

            var paymentLink = `
                <a href="${paymentRoute}?orderId=${transaction.Order}&totalItemQty=${transaction.TotalQty}&sub_total=${subTotal}&salesTax=${salesTax}&shipping=${shipping}&artwork=${artWork}&processingFee=${processingFee}&orderTotal=${amount}&paymentStatus=${transaction.paymentStatus2}&balancePayment=${transaction.paymentStatus2 == 1 ? balnceToBePaid : ''}" target="_blank">${transaction.TransactionID}</a>
            `;

            row.innerHTML = `
                <td class="font_color row_padding"><a href="#" class="edit-order" data-value="${transaction.Order}">${transaction.OrderNo}</a></td>
                <td class="font_color row_padding">${paymentLink}</td>
                <td class="font_color row_padding">${formattedPaymentDate}</td>
                <td class="font_color row_padding">${orderStatusBadge}</td>
                <td class="font_color row_padding">${transaction.TeamName}</td>
                <td class="font_color row_padding">${transaction.PaymentType}</td>
                <td class="font_color row_padding">${transaction.NameonCard}</td>
                <td class="font_color row_padding">${checkStatusBadge}</td>
            `;
        }

        // Update pagination controls
        updatePagination(totalPages, currentPage);
    }

    // Function to update transactions per page
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

    // Function to handle page change
    function changePage(page) {
        if (page < 1) page = 1;
        var totalPages = Math.ceil(transactionsArray.length / transactionsPerPage);
        if (page > totalPages) page = totalPages;
        currentPage = page;
        showTransactions(currentPage, transactionsArray); // Use transactionsArray here
    }

    // Function to update transactions per page
    function updateTransactionsPerPage(value) {
        transactionsPerPage = parseInt(value, 10);
        currentPage = 1;
        showTransactions(currentPage, transactionsArray);
    }

    // Initialize pagination with initial data
    showTransactions(currentPage, transactionsArray);

    // Event listener for filter button click
    document.getElementById('pin-filter').addEventListener('click', function(event) {
        event.preventDefault();

        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;
        const paymentType = document.getElementById('paymentType').value;
        const paymentStatus = document.getElementById('paymentStatus').value;

        $.ajax({
            url: '{{ route('filterCustomerPayment') }}',
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
                transactionsArray = data.TrasnsactionsArray; // Update transactionsArray with filtered data
                currentPage = 1;
                showTransactions(currentPage, transactionsArray); // Show updated data
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



    function updateTable(data) {
        var transactionsArray = data.TrasnsactionsArray;

        console.log(transactionsArray);

        var tableBody = document.getElementById('table_body');
        tableBody.innerHTML = ''; // Clear old table rows

        var totalAmount = 0; // Initialize total amount variable

        transactionsArray.forEach(transaction => {
            var row = tableBody.insertRow();
            var amount = transaction.Amount !== null ? parseFloat(transaction.Amount) : 0; // Convert amount to float
            totalAmount += amount;

            var amount = transaction.Amount ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.Amount) : "0.00";
            var subTotal = transaction.SubTotal ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.SubTotal) : "0.00";
            var shipping = transaction.Shipping ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.Shipping) : "0.00";
            var artWork = transaction.ArtWork ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.ArtWork) : "0.00";
            var salesTax = transaction.SalesTax ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.SalesTax) : "0.00";
            var processingFee = transaction.processingFee ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.processingFee) : "0.00";
            var balnceToBePaid = transaction.balnceToBePaid ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.balnceToBePaid) : "0.00";

            var orderStatusBadge;
            if (transaction.OrderStatus === 'Paid') {
                orderStatusBadge = '<span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:100%">Paid</span>';
            } else if (transaction.OrderStatus === 'Partial') {
                orderStatusBadge = '<span class="badge badge-pill" style="color:#023E8A;background-color:#D4E6FD; width:100%">Partial</span>';
            } else {
                orderStatusBadge = '<span class="badge badge-pill" style="color:#FFB916;background-color:#FFF6CC;width:100%">Pending</span>';
            }

            var checkStatusBadge;

            if (transaction.checkStatus === 'Not Approved') {
                checkStatusBadge = '<span class="badge badge-pill" style="color:#d381ff;background-color:#f9dfff;width:100%">Not Approved</span>';
            } else if (transaction.checkStatus === 'Approved') {
                checkStatusBadge = '<span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:100%">Approved</span>';
            } else if (transaction.checkStatus === 'Rejected') {
                checkStatusBadge = '<span class="badge badge-pill" style="color:#d65a47;background-color:#ffcccc;width:100%">Rejected</span>';
            } else {
                checkStatusBadge = '<span class="badge badge-pill" style="color:#FFB916;background-color:#ffffcc;width:100%">Payed</span>';
            }

            var paymentDate = new Date(transaction.PaymentDate);
            var formattedPaymentDate = paymentDate.toISOString().split('T')[0];


            var paymentRoute = "{{ route('payment') }}";

            var paymentLink = `
                <a href="${paymentRoute}?orderId=${transaction.Order}&totalItemQty=${transaction.TotalQty}&sub_total=${subTotal}&salesTax=${salesTax}&shipping=${shipping}&artwork=${artWork}&processingFee=${processingFee}&orderTotal=${amount}&paymentStatus=${transaction.paymentStatus2}&balancePayment=${transaction.paymentStatus2 == 1 ? balnceToBePaid : ''}" target="_blank">${transaction.TransactionID}</a>
            `;

            row.innerHTML = `
                <td class="font_color row_padding"><a href="#" class="edit-order" data-value="${transaction.Order}">${transaction.OrderNo}</a></td>
                <td class="font_color row_padding">${paymentLink}</td>
                <td class="font_color row_padding">${formattedPaymentDate}</td>
                <td class="font_color row_padding">${orderStatusBadge}</td>
                <td class="font_color row_padding">${transaction.TeamName}</td>
                <td class="font_color row_padding">${transaction.PaymentType}</td>
                <td class="font_color row_padding">${transaction.NameonCard}</td>
                <td class="font_color row_padding">${checkStatusBadge}</td>
            `;
        });


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
                const SelectedPaymentStatus = document.getElementById('paymentStatus').value;

                var routeUrl = "{{ url('/customerPayment_CSV_download/') }}" + '/' + startDate  + '/' + endDate + '/' + paymentType + '/' + SelectedPaymentStatus;

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
