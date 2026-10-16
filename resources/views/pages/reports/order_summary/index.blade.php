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
    .search_class {
        border: 1px solid #d6d6d6;
        border-radius: 2px;
        padding: 2px;
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
        <span>Order Summary Report</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection


    <div class="col-md-12 "  style="padding-bottom: 25px !important;">


        <div class="card filter_div">
            <div class="row" style="padding-left: 15px;">
                <div style="margin-right: 20px;">
                    <div class="row filter_row">
                        <p class="font_color date_p">
                            <select id="dateType" class="date_p">
                                <option value="created_at">Created Date</option>
                                <option value="due_date">In Hand Due Date</option>
                                <option value="ex_factory">Ex Factory Date</option>
                            </select>
                        </p>
                        <input class="date_selection" type="date" id="start-date" name="start-date" max="" value="">
                        <i class="fa fa-arrow-right date_p" style="padding-left: 5px; padding-top: 4px; padding-right: 5px;"></i>
                        <input class="date_selection" type="date" id="end-date" name="end-date" max="" value="">
                    </div>
                </div>

                <div style="margin-right: 20px;">
                    <div class="row filter_row" style="padding-bottom: 2px;">
                        <p class="font_color date_p">Factory |  </p>
                        <div class="paymen_type_div date_selection">
                            <select id="factory" class="date_selection">
                                <option value="all">All</option>
                                @foreach ($factories as $factory)
                                    <option value="{{ $factory->id }}">{{ $factory->factory_code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div style="margin-right: 20px;">
                    <div class="row filter_row" style="padding-bottom: 2px;">
                        <p class="font_color date_p">Order Status |  </p>
                        <div class="paymen_type_div date_selection">
                            <select id="orderStatus" class="date_selection">
                                <option value="all">All</option>
                                @foreach ($orderStatus as $orderStatuss)
                                    <option value="{{ $orderStatuss->id }}">{{ $orderStatuss->status_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div style="margin-right: 20px;">
                    <div class="row filter_row" style="padding-bottom: 2px;">
                        <p class="font_color date_p">Test Pring |  </p>
                        <div class="paymen_type_div date_selection">
                            <select id="testPrint" class="date_selection">
                                <option value="all">All</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
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
                                <option value="Partial">Partial</option>
                                <option value="Paid">Paid</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div style="margin-left: 20px;">
                    <div class="row" style="padding-bottom: 2px;">
                        <a href="#" class="date_p filter_btn" id="pin-filter" title="Filter">
                            <i class="fa fa-filter " style="padding-left: 5px; padding-top: 4px; padding-right: 5px;"></i>
                            Filter
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <div class="card orders_summary print_content" style="border: unset; padding: 10px;">

            <div class="row" style="padding-left: 15px;">
                <div style="padding: 5px;">
                    <select id="itemsPerPage" onchange="changeItemsPerPage(this.value)">
                        <option value="10">10 per page</option>
                        <option value="20" selected>20 per page</option>
                        <option value="30">30 per page</option>
                        <option value="50">50 per page</option>
                    </select>

                </div>

                <div class="ml-auto print_btn">

                        <input class="search_class" id="searchOrder" type="text" placeholder="Organization or Order">

                </div>

                <div class="ml-auto print_btn" style="margin-left: 1% !important;">
                    <a class="top_button download_btn" href="#"><i class="fa fa-download" style="margin-right: 8px;"></i></a>
                </div>
                <div class="ml-auto print_btn" style="margin-left: unset !important; margin-right: 1%;">
                    <a class="top_button print_button" href="#"><i class="fa fa-print" style="margin-right: 8px;"></i></a>
                </div>

            </div>



            <div class="order_sammary_table" style="overflow-x: auto;">
                <table class="table align-items-center" id="order_sammary_table" style="min-width: 100%;">

                    <thead style="background-color: #717070;">
                        <th scope="col" class="table_header_text">ORDER ID</th>
                        <th scope="col" class="table_header_text">ORGANIZATION </th>
                        <th scope="col" class="table_header_text">FACTORY </th>
                        <th scope="col" class="table_header_text">ORDER CREATED DATE</th>
                        <th scope="col" class="table_header_text">SENT TO PRODUCTION</th>
                        <th scope="col" class="table_header_text">FACTORY CONFIRMED</th>
                        <th scope="col" class="table_header_text"> EX FACTORY DATE </th>
                        <th scope="col" class="table_header_text">IN HAND DUE DATE </th>
                        <th scope="col" class="table_header_text">REQUESTED EX FACTORY DATE </th>
                        <th scope="col" class="table_header_text">TEST PRINT NEEDED? </th>
                        <th scope="col" class="table_header_text">ORDER TYPE </th>
                        <th scope="col" class="table_header_text">ORDER QTY</th>
                        <th scope="col" class="table_header_text">ORDER TOTAL</th>
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
    // startDateInput.max = today;
    startDateInput.value = today;

    startDateInput.addEventListener('input', () => {
        startDateInput.blur();
    });

    const endDateInput = document.getElementById('end-date');

    // endDateInput.max = today;
    endDateInput.value = today;

    endDateInput.addEventListener('input', () => {
        endDateInput.blur();
    });

    var orderArray = @json($firstTenItems);
    var ordersData = orderArray.data;
    var tableBody = document.getElementById('table_body');
    var paginationBar = document.getElementById('paginationbar');
    var ordersPerPage = 20;
    var currentPage = 1;
    function showOrders(page, data) {
        tableBody.innerHTML = '';
        var startIndex = (page - 1) * ordersPerPage;
        var endIndex = startIndex + ordersPerPage;
        var totalPages = Math.ceil(data.length / ordersPerPage);
        for (var i = startIndex; i < endIndex && i < data.length; i++) {
            var transaction = data[i];

            var uniqueFactories = Array.from(new Set(transaction.order_items.map(item => item.factory_details?.factory_code ?? '')));
            var factories = uniqueFactories.filter(code => code !== '').join(', ');

            var testPrintNeeded = transaction.order_items.some(item => item.test_print_needed === 1) ? 'Yes' : 'No';

            var orderType;
            if (transaction.is_urgent == 1) {
                orderType = 'Urgent Order';
            } else if (transaction.order_type == 0 && transaction.is_reordered == 0) {
                orderType = 'Bulk New Order';
            } else if (transaction.order_type == 1 && transaction.is_reordered == 0) {
                orderType = 'TS Order';
            } else if (transaction.is_reordered == 1) {
                orderType = 'Reorder';
            } else {
                orderType = 'New Order';
            }

            var date = new Date(transaction.created_at);
            var formattedCreatedDate = ('0' + (date.getMonth() + 1)).slice(-2) + '/' + ('0' + date.getDate()).slice(-2) + '/' + date.getFullYear();
            var productionDate = transaction.production_date ? transaction.production_date : '';
            var exFactoryDate = transaction.ex_factory_date ? transaction.ex_factory_date : '';
            var dueDate = transaction.due_date ? transaction.due_date : '';
            // Determine factory confirmation status
            var factoryConfirm;
            if (transaction.reject_or_confirm == 1) {
                factoryConfirm = 'Rejected';
            } else if (transaction.reject_or_confirm == null) {
                factoryConfirm = '';
            } else {
                factoryConfirm = 'Confirmed';
            }
            // Count order items
            var orderItemCount = transaction.order_items.length;
            // Insert row into table body
            var row = tableBody.insertRow();
            row.innerHTML = `
                <td class="font_color row_padding"><a href="#" class="edit-order" data-value="${transaction.id}">${transaction.order_no}</a></td>
                <td class="font_color row_padding">${transaction.organization_details.organization_name}</td>
                <td class="font_color row_padding">${factories}</td>
                <td class="font_color row_padding">${formattedCreatedDate}</td>
                <td class="font_color row_padding">${productionDate}</td>
                <td class="font_color row_padding">${factoryConfirm}</td>
                <td class="font_color row_padding">${exFactoryDate}</td>
                <td class="font_color row_padding">${dueDate}</td>
                <td class="font_color row_padding"></td>
                <td class="font_color row_padding">${testPrintNeeded}</td>
                <td class="font_color row_padding">${orderType}</td>
                <td class="font_color row_padding">${orderItemCount}</td>
                <td class="font_color row_padding" style="text-align: right;">${transaction.order_total}</td>
            `;
        }
        // Update pagination controls
        updatePagination(totalPages, currentPage);
    }
    // Function to update pagination controls
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
        var totalPages = Math.ceil(ordersData.length / ordersPerPage);
        if (page > totalPages) page = totalPages;
        currentPage = page;
        showOrders(currentPage, ordersData);
    }
    // Function to handle user input for items per page
    function changeItemsPerPage(itemsPerPage) {
        ordersPerPage = parseInt(itemsPerPage);
        currentPage = 1; // Reset to first page when changing items per page
        showOrders(currentPage, ordersData);
    }
    // Initial setup: Show orders for the first page
    showOrders(currentPage, ordersData);
    // Event listener for filter button (assuming 'pin-filter' is your filter button)
    document.getElementById('pin-filter').addEventListener('click', function(event) {
        event.preventDefault();
        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;
        const filterDate = document.getElementById('dateType').value;
        const filterFactory = document.getElementById('factory').value;
        const orderStatus = document.getElementById('orderStatus').value;
        const testPrint = document.getElementById('testPrint').value;
        const paymentStatus = document.getElementById('paymentStatus').value;
        $.ajax({
            url: '{{ route('filterOrderSummary') }}',
            method: 'GET',
            data: {
                startDate: startDate,
                endDate: endDate,
                filterDate: filterDate,
                filterFactory: filterFactory,
                orderStatus: orderStatus,
                testPrint: testPrint,
                paymentStatus: paymentStatus
            },
            beforeSend: function () {
                // Show loader if needed
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (data) {
                console.log(data);
                ordersData = data.orders;
                currentPage = 1;
                showOrders(currentPage, ordersData);
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

        var ordersData = data.orders;

console.log(ordersData);

        var tableBody = document.getElementById('table_body');
        tableBody.innerHTML = '';

        var totalAmount = 0; // Initialize total amount variable


        ordersData.forEach(transaction => {

            var uniqueFactories = Array.from(new Set(transaction.order_items.map(item => item.factory_details.factory_code)));
            var factories = uniqueFactories.join(', ');

            var testPrintNeeded = transaction.order_items.some(item => item.test_print_needed === 1) ? 'Yes' : 'No';

            var orderType;

            if (transaction.is_urgent == 1){
                orderType = 'Urgent Order'
            } else if (transaction.order_type == 0 && transaction.is_reordered == 0) {
                orderType = 'Bulk New Order'
            } else if (transaction.order_type == 1 && transaction.is_reordered == 0) {
                orderType = 'TS Order'
            } else if (transaction.is_reordered == 1) {
                orderType = 'Reorder'
            } else {
                orderType = 'New Order'
            }

            var row = tableBody.insertRow();

            var date = new Date(transaction.created_at);
            var formattedCreatedDate = ('0' + (date.getMonth() + 1)).slice(-2) + '/' + ('0' + date.getDate()).slice(-2) + '/' + date.getFullYear();

            var productionDate = transaction.production_date ? transaction.production_date : '';
            var exFactoryDate = transaction.ex_factory_date ? transaction.ex_factory_date : '';
            var dueDate = transaction.due_date ? transaction.due_date : '';

            var factoryConfirm;

            if (transaction.reject_or_confirm == 1){
                factoryConfirm = 'Rejected'
            } else if (transaction.reject_or_confirm == null) {
                factoryConfirm = ''
            } else {
                factoryConfirm = 'Confirmed'
            }

            var orderItemCount = transaction.order_items.length;

            row.innerHTML = `
                <td class="font_color row_padding">${transaction.order_no}</td>
                <td class="font_color row_padding">${transaction.organization_details.organization_name}</td>
                <td class="font_color row_padding">${factories}</td>
                <td class="font_color row_padding">${formattedCreatedDate}</td>
                <td class="font_color row_padding">${productionDate}</td>
                <td class="font_color row_padding">${factoryConfirm}</td>
                <td class="font_color row_padding">${exFactoryDate}</td>
                <td class="font_color row_padding">${dueDate}</td>
                <td class="font_color row_padding"></td>
                <td class="font_color row_padding">${testPrintNeeded}</td>
                <td class="font_color row_padding">${orderType}</td>
                <td class="font_color row_padding">${orderItemCount}</td>
                <td class="font_color row_padding"  style="text-align: right;">${transaction.order_total}</td>
            `;
        });


    }


    // Search order

    $(document).ready(function() {
        var searchValue = null; // Initialize searchValue as null

        $('#searchOrder').on('keyup', function(e) {
            if (e.key === 'Enter') {
                if ($('#searchOrder').val().trim() === '') {
                location.reload();
            } else {
                performSearch();
            }
            }
        });

        $('#searchOrder').on('blur', function() {
            if ($('#searchOrder').val().trim() === '') {
                location.reload();
            } else {
                performSearch();
            }
        });

        function performSearch() {
            var inputValue = $('#searchOrder').val().trim();
            if (inputValue !== searchValue) { // Check if the input value has changed
                searchValue = inputValue; // Update searchValue
                $.ajax({
                    url: "{{ route('orderSummarySearchOrder') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        searchValue: searchValue
                    },
                    beforeSend: function () {
                        // Show loader if needed
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function(response) {
                        // Update your UI with the retrieved data
                        console.log(response);
                        ordersData = response.orders;
                        currentPage = 1;
                        showOrders(currentPage, ordersData);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    },
                    complete: function () {
                        // Hide loader if needed
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            }
        }
    });


    function searchTable(response) {

        var ordersData = response.orders;

        console.log(ordersData);

        var tableBody = document.getElementById('table_body');
        tableBody.innerHTML = '';

        var totalAmount = 0; // Initialize total amount variable


        ordersData.forEach(transaction => {

            var uniqueFactoriesSet = new Set(); // Use Set for uniqueness

            transaction.order_items.forEach(item => {
                if (item.factory_details && item.factory_details.factory_code) {
                    uniqueFactoriesSet.add(item.factory_details.factory_code); // Add factory code to the Set
                }
            });

            var factories = Array.from(uniqueFactoriesSet).join(', ');

            var testPrintNeeded = transaction.order_items.some(item => item.test_print_needed === 1) ? 'Yes' : 'No';

            var orderType;

            if (transaction.is_urgent == 1){
                orderType = 'Urgent Order'
            } else if (transaction.order_type == 0 && transaction.is_reordered == 0) {
                orderType = 'Bulk New Order'
            } else if (transaction.order_type == 1 && transaction.is_reordered == 0) {
                orderType = 'TS Order'
            } else if (transaction.is_reordered == 1) {
                orderType = 'Reorder'
            } else {
                orderType = 'New Order'
            }

            var row = tableBody.insertRow();

            var date = new Date(transaction.created_at);
            var formattedCreatedDate = ('0' + (date.getMonth() + 1)).slice(-2) + '/' + ('0' + date.getDate()).slice(-2) + '/' + date.getFullYear();

            var productionDate = transaction.production_date ? transaction.production_date : '';
            var exFactoryDate = transaction.ex_factory_date ? transaction.ex_factory_date : '';
            var dueDate = transaction.due_date ? transaction.due_date : '';

            var factoryConfirm;

            if (transaction.reject_or_confirm == 1){
                factoryConfirm = 'Rejected'
            } else if (transaction.reject_or_confirm == null) {
                factoryConfirm = ''
            } else {
                factoryConfirm = 'Confirmed'
            }

            var orderItemCount = transaction.order_items.length;

            row.innerHTML = `
                <td class="font_color row_padding">${transaction.order_no}</td>
                <td class="font_color row_padding">${transaction.organization_details.organization_name}</td>
                <td class="font_color row_padding">${factories}</td>
                <td class="font_color row_padding">${formattedCreatedDate}</td>
                <td class="font_color row_padding">${productionDate}</td>
                <td class="font_color row_padding">${factoryConfirm}</td>
                <td class="font_color row_padding">${exFactoryDate}</td>
                <td class="font_color row_padding">${dueDate}</td>
                <td class="font_color row_padding"></td>
                <td class="font_color row_padding">${testPrintNeeded}</td>
                <td class="font_color row_padding">${orderType}</td>
                <td class="font_color row_padding">${orderItemCount}</td>
                <td class="font_color row_padding"  style="text-align: right;">${transaction.order_total}</td>
            `;
        });


        }


    //Download CSV
    document.addEventListener('DOMContentLoaded', function () {


    var downloadBtn = document.querySelector('.download_btn');
        downloadBtn.addEventListener('click', function () {

            const dateType = document.getElementById('dateType').value;
            const startDate1 = document.getElementById('start-date').value;
            const endDate1 = document.getElementById('end-date').value;
            const filterFactory = document.getElementById('factory').value;
            const orderStatus = document.getElementById('orderStatus').value;
            const testPrint = document.getElementById('testPrint').value;
            const paymentStatus1 = document.getElementById('paymentStatus').value;
        // console.log(startDate);
            var routeUrl = "{{ url('/orderSummary_CSV_download/') }}" + '/' + dateType  + '/' + startDate1 + '/' + endDate1 + '/' + filterFactory + '/' + orderStatus + '/' + testPrint + '/' + paymentStatus1;

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
