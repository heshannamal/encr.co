@extends('layouts.app', ['activePage' => 'home', 'titlePage' => __('Dashboard')])

@section('content')

<style>
    .dropdown-content {
        display: none;
        position: absolute;
        top: 31px;
        left: 128px;
        background-color: #ffffff;
        min-width: 125px;
        overflow: auto;
        box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.1);
        z-index: 1;
        padding: 10px 10px;
    }
    .dropdown-content button {
        padding: 5px 5px;
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 1px solid #eeeeee;
        border-radius: 3px;
    }
    .dropdown-content button:focus {
        outline: none;
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
    .total_sales {
        margin: 9px;
    }
    .total_sale_p1 {
        margin: unset;
        font-size: 12px;
        font-weight: 400;
    }
    .total_sale_b {
        font-size: 17px;
    }
    .difference_div {
        background-color: #E0F9D4;
        color: #55A630;
        margin-left: 12px;
        width: 45px;
        font-size: 10px;
        text-align: center;
        margin-top: 5px;
        margin-bottom: 4px;
        border-radius: 10px;
    }
    .difference_div2 {
        background-color: #FFEDEE;
        color: #D00000;
        margin-left: 12px;
        width: 45px;
        font-size: 10px;
        text-align: center;
        margin-top: 5px;
        margin-bottom: 4px;
        border-radius: 10px;
    }
    .total_sale_img_size {
        width: 30px;
    }
    .total_sale_p2 {
        margin: unset;
        font-size: 12px;
        font-weight: 500;
        color: #B3B3B3;
    }
    .detail_card_padding {
        width: 20% !important;
        max-width: 20% !important;
        padding-left: 5px;
        padding-right: 5px;
        padding-right: 5px;
        padding-bottom: 5px;
    }
    .main-content {
        background-color: #f5f5f5 !important;
    }
    .content_position {
        top: -20px;
        position: relative;
    }
    .month_selection {
        text-align: right;
        padding-bottom: 25px;
    }
    .date_p {
        margin: unset;
        font-size: 11px;
        color: #B3B3B3;
        font-weight: 600;
    }
    .date_selection {
        background-color: transparent;
        padding: unset;
        border: unset;
        color: #47D6B6;
        font-size: 12px;
        font-weight: 600;
    }
    .date_p:hover {
        color: #B3B3B3 !important;
    }
    .date_div {
        margin-left: -5px;
        margin-top: 5px;
        width: 98%;
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
    .search_class {
        border: unset;
        border-radius: 2px;
        padding: 2px;
        border-bottom: 1px solid lightgray;
    }
    .table_header_text {
        color: white;
        height: 40px;
        font-size: 10px !important;
        padding-right: unset !important;
        padding-left: 10px !important;
    }
    .table_body_text {
        height: 40px;
        font-size: 11px !important;
        padding-right: unset !important;
        padding-left: 10px !important;
        text-align: center;
    }
    .recent_order {
        padding-bottom: 30px;
    }
    .page-item.active .page-link {
        color: #4e4e4e;
    }
</style>

<div class="container-fluid mb-5 content_position">
    <div class="se-pre-con"></div>

    <div class="col-md-12" style="padding: unset; padding-left: 10px; padding-right: 10px;">
        {{-- <div class="ml-auto month_selection">
            <select name="Month" id="Month" class="select_month1">
            </select>
        </div> --}}
        <div class="row" id="dataContainer">
            <div class="detail_card_padding">
                <div class="card" style="border: unset;">
                    <div class="row total_sales" style="cursor: pointer;" id="urgent_order">
                        <div style="display: flex; justify-content: center; align-items: center;;">
                            <img src="{{ asset('assets') }}/img/dashboard/urgent.png" class="total_sale_img_size" alt="image">
                        </div>
                        <div style="padding-left: 10px;">
                            <div><p class="total_sale_p1" >Urgent Orders</p></div>
                            <div class="row" style="margin: unset;">
                                <b class="total_sale_b">{{ $orderUrgent }}</b>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="detail_card_padding">
                <div class="card" style="border: unset;">
                    <div class="row total_sales" style="cursor: pointer;" id="new_order">
                        <div style="display: flex; justify-content: center; align-items: center;;">
                            <img src="{{ asset('assets') }}/img/dashboard/cart.png" class="total_sale_img_size" alt="image">
                        </div>
                        <div style="padding-left: 10px;">
                            <div><p class="total_sale_p1" >New Orders</p></div>
                            <div class="row" style="margin: unset;">
                                <b class="total_sale_b">{{ $orderNew }}</b>

                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="detail_card_padding">
                <div class="card" style="border: unset;">
                    <div class="row total_sales" style="cursor: pointer;" id="production_order">
                        <div style="display: flex; justify-content: center; align-items: center;;">
                            <img src="{{ asset('assets') }}/img/dashboard/production.png" class="total_sale_img_size" alt="image">
                        </div>
                        <div style="padding-left: 10px;">
                            <div><p class="total_sale_p1" >Orders in Production</p></div>
                            <div class="row" style="margin: unset;">
                                <b class="total_sale_b">{{ $orderProduction }}</b>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="detail_card_padding">
                <div class="card" style="border: unset;">
                    <div class="row total_sales" style="cursor: pointer;" id="pending_shipment">
                        <div style="display: flex; justify-content: center; align-items: center;;">
                            <img src="{{ asset('assets') }}/img/dashboard/shipping.png" class="total_sale_img_size" alt="image">
                        </div>
                        <div style="padding-left: 10px;">
                            <div><p class="total_sale_p1" >Pending Shipment</p></div>
                            <div class="row" style="margin: unset;">
                                <b class="total_sale_b">{{ $matches }}</b>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="detail_card_padding">
                <div class="card" style="border: unset;">
                    <div class="row total_sales" style="cursor: pointer;" id="fulfiled_order">
                        <div style="display: flex; justify-content: center; align-items: center;;">
                            <img src="{{ asset('assets') }}/img/dashboard/fulfilment.png" class="total_sale_img_size" alt="image">
                        </div>
                        <div style="padding-left: 10px;">
                            <div><p class="total_sale_p1" >Fulfilled Orders</p></div>
                            <div class="row" style="margin: unset;">
                                <b class="total_sale_b">{{ $orderFulfiled }}</b>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="detail_card_padding">
                <div class="card" style="border: unset;">
                    <div class="row total_sales" style="cursor: pointer;" id="upcoming_orders">
                        <div style="display: flex; justify-content: center; align-items: center;;">
                            <img src="{{ asset('assets') }}/img/dashboard/production.png" class="total_sale_img_size" alt="image">
                        </div>
                        <div style="padding-left: 10px;">
                            <div><p class="total_sale_p1" >Upcoming Orders</p></div>
                            <div class="row" style="margin: unset;">
                                <b class="total_sale_b">{{ $orderUpcoming }}</b>

                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>

        <div class="row" style="padding: unset; padding-top: 20px; padding-left: 5px; padding-right: 5px;">
            <div class="" style="margin: unset; width: 100%;">
                <div class="card" style="border: unset; width: 100%; padding: 10px;">

                    <b style="font-size: 16px;" id="urgent_order_topic"></b>
                    <div class="recent_order" style=" padding-top: 15px; overflow-x: auto;">
                        <table class="table align-items-center" id="urgent_order_table" style="min-width: 100%;">
                            <thead style="background-color: #717070;">
                                <th scope="col" class="table_header_text" style="">ORDER ID  </th>
                                <th scope="col" class="table_header_text" style="">ORDER TYPE  </th>
                                <th scope="col" class="table_header_text" style="">EX FACTORY DATE</th>
                                <th scope="col" class="table_header_text" style="">ORDERED QTY</th>
                                <th scope="col" class="table_header_text" style="">SALES REP</th>
                            </thead>

                            <tbody id="urgent_orders_body">

                            </tbody>

                        </table>

                        <div>
                            <div id="paginationbarUrgent" class="row justify-content-center" style="width: 100%;">
                              {{-- pagination bar paste here --}}
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="row" style="padding: unset; padding-top: 20px; padding-left: 5px; padding-right: 5px;">
            <div class="" style="margin: unset; width: 100%;">
                <div class="card" style="border: unset; width: 100%; padding: 10px;">
                    <b style="font-size: 16px;">Orders</b>
                    <div class="row"  style="margin-left: 0px; padding-top: 15px; width: 100%; padding-bottom: 5px; border-bottom: 1px solid lightgray;">
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

                        <div style="margin-left: 20px; padding-top: 4px;">
                            <div class="row" style="padding-bottom: 2px;">
                                <a href="#" class="date_p" id="pin-filter" title="Filter">
                                    <i class="fa fa-filter " style="padding-left: 5px; padding-top: 4px; padding-right: 5px;"></i>
                                    Filter
                                </a>
                            </div>
                        </div>

                        <div class="ml-auto print_btn" style="width: 20%;">
                            <input class="search_class" id="searchOrder" type="text" placeholder="Organization or Order" style="width: 100%; font-size: 15px;">
                        </div>

                    </div>

                    <div class="recent_order" style=" padding-top: 20px; overflow-x: auto;">
                        <table class="table align-items-center" id="recent_order_table" style="min-width: 100%;">
                            <thead style="background-color: #717070;">
                                <th scope="col" class="table_header_text" style="">TOKEN </th>
                                <th scope="col" class="table_header_text" style="">ORDER ID  </th>
                                <th scope="col" class="table_header_text" style="">ORGANIZATION </th>
                                {{-- <th scope="col" class="table_header_text" style="">FACTORIES </th> --}}
                                <th scope="col" class="table_header_text" style="">DUE DATE </th>
                                <th scope="col" class="table_header_text" style="">OPEN DATE</th>
                                <th scope="col" class="table_header_text" style="">FACTORY EXP. DATE </th>
                                <th scope="col" class="table_header_text" style="">SALES REP</th>
                            </thead>

                            <tbody id="total_orders_body">

                            </tbody>

                        </table>

                        <div>
                            <div id="paginationbar" class="row justify-content-center" style="width: 100%;">
                              {{-- pagination bar paste here --}}
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
        <div class="modal fade " id="view_upcoming_order_items" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Order Items</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <table class="table table-responsive table-bordered">
                        <thead>
                          <tr style="background-color: #f7f7f7;">
                            <th scope="col">#</th>
                            <th scope="col" style="width:40%">Items</th>
                            <th scope="col" style="width:30%">Attributes included</th>
                            <th scope="col" style="width:25%">Qty</th>

                          </tr>
                        </thead>
                        <tbody id="upcoming_order_items_body">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
            </div>
        </div>

    <script>

        // Order table
        var ordersPerPage = 5;
        var maxPaginationLinks = 10;

        // Initial orders data
        var orders = @json($ordersPegi);
        var currentPage = 1;

        function renderTable(data) {
            var tableBody = document.getElementById('total_orders_body');
            tableBody.innerHTML = '';

            data.forEach(transaction => {
                var uniqueFactories = Array.from(new Set(transaction.order_items.map(item => {
                    return item.factory_details ? item.factory_details.factory_code : null;
                }).filter(factoryCode => factoryCode !== null)));

                var factories = uniqueFactories.join(', ');

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

                var row = tableBody.insertRow();

                var date = new Date(transaction.created_at);
                var formattedCreatedDate = ('0' + (date.getMonth() + 1)).slice(-2) + '/' + ('0' + date.getDate()).slice(-2) + '/' + date.getFullYear();

                var productionDate = transaction.production_date ? transaction.production_date : '';
                var exFactoryDate = transaction.ex_factory_date ? transaction.ex_factory_date : '';
                var dueDate = transaction.due_date ? transaction.due_date : '';

                row.innerHTML = `
                    <td class="table_body_text"><i class="fa fa-star" style="color: ${transaction.flag}"></i></td>
                    <td class="font_color row_padding"><a href="#" class="edit-order" data-value="${transaction.id}">${transaction.order_no}</a></td>
                    <td class="font_color row_padding">${transaction.organization_details.organization_name}</td>
                    <td class="font_color row_padding">${dueDate}</td>
                    <td class="font_color row_padding">${formattedCreatedDate}</td>
                    <td class="font_color row_padding">${exFactoryDate}</td>
                    <td class="font_color row_padding">${transaction.user_details.name}</td>
                `;
            });

            // Set up pagination for new data
            setupPagination(data);
        }

        function setupPagination(data) {
            var totalPages = Math.ceil(data.length / ordersPerPage);

            if (totalPages >= 1) {
                var pagination = '<nav aria-label="Page navigation"><ul class="pagination">';
                pagination += '<li class="page-item"><a class="page-link" href="#" data-page="prev" style="border-radius: unset; background-color:transparent; border:unset;">&laquo;</a></li>';

                if (totalPages <= maxPaginationLinks) {
                    for (var i = 1; i <= totalPages; i++) {
                        pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + i + '"  style="border-radius: unset; background-color:transparent; border:unset;">' + i + '</a></li>';
                    }
                } else {
                    var displayPaginationLinks = Math.min(maxPaginationLinks, totalPages);
                    var startPagination = 1;
                    var endPagination = displayPaginationLinks;

                    if (currentPage > Math.floor(maxPaginationLinks / 2)) {
                        startPagination = currentPage - Math.floor(maxPaginationLinks / 2);
                        endPagination = currentPage + Math.ceil(maxPaginationLinks / 2) - 1;

                        if (endPagination > totalPages) {
                            endPagination = totalPages;
                            startPagination = endPagination - maxPaginationLinks + 1;
                        }
                    }

                    for (var i = startPagination; i <= endPagination; i++) {
                        pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + i + '"  style="border-radius: unset; background-color:transparent; border:unset;">' + i + '</a></li>';
                    }
                }

                pagination += '<li class="page-item"><a class="page-link" href="#" data-page="next"  style="border-radius: unset; background-color:transparent; border:unset;">&raquo;</a></li>';
                pagination += '</ul></nav>';

                $('#paginationbar').empty().append(pagination);

                // Show the initial page
                showPage(currentPage, data);

                // Pagination click event
                $('#paginationbar').on('click', '.page-link', function(e) {
                    e.preventDefault();

                    var page = $(this).data('page');

                    if (page === 'prev') {
                        currentPage = Math.max(1, currentPage - 1);
                    } else if (page === 'next') {
                        currentPage = Math.min(totalPages, currentPage + 1);
                    } else {
                        currentPage = page;
                    }

                    // Update pagination visibility
                    var startPagination = 1;
                    var endPagination = startPagination + maxPaginationLinks - 1;

                    if (currentPage > maxPaginationLinks) {
                        startPagination = currentPage - Math.floor(maxPaginationLinks / 2);
                        endPagination = currentPage + Math.ceil(maxPaginationLinks / 2) - 1;
                    }

                    if (endPagination > totalPages) {
                        endPagination = totalPages;
                        startPagination = endPagination - maxPaginationLinks + 1;
                    }

                    if (startPagination < 1) {
                        startPagination = 1;
                    }

                    pagination = '<nav aria-label="Page navigation"><ul class="pagination">';
                    pagination += '<li class="page-item"><a class="page-link" href="#" data-page="prev"  style="border-radius: unset; background-color:transparent; border:unset;">&laquo;</a></li>';

                    for (var i = startPagination; i <= endPagination; i++) {
                        pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + i + '" style="border-radius: unset; background-color:transparent; border:unset;">' + i + '</a></li>';
                    }

                    pagination += '<li class="page-item"><a class="page-link" href="#" data-page="next" style="border-radius: unset; background-color:transparent; border:unset;">&raquo;</a></li>';
                    pagination += '</ul></nav>';

                    $('#paginationbar').empty().append(pagination);

                    showPage(currentPage, data);
                });

                // Always show the previous and next link buttons
                $('#paginationbar .page-item:first-child').removeClass('d-none');
                $('#paginationbar .page-item:last-child').removeClass('d-none');
            }
        }

        function showPage(pageNum, data) {
            var startIndex = (pageNum - 1) * ordersPerPage;
            var endIndex = startIndex + ordersPerPage;

            // Hide all rows
            $('#total_orders_body tr').hide();

            // Show only the relevant rows
            $('#total_orders_body tr').slice(startIndex, endIndex).show();

            // Update active page in pagination bar
            $('#paginationbar .page-item').removeClass('active');
            $('#paginationbar .page-link[data-page="' + pageNum + '"]').parent().addClass('active');
        }

        // Initial render
        renderTable(orders);

        // Filter order
        document.getElementById('pin-filter').addEventListener('click', function(event) {
            event.preventDefault();

            const orderStatus = document.getElementById('orderStatus').value;

            $.ajax({
                url: '{{ route('filterOrdersFactoryDashboard') }}',
                method: 'GET',
                data: {
                    orderStatus: orderStatus
                },
                beforeSend: function () {
                    // Show loader if needed
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data) {
                    // console.log(data);
                    orders = data.orders; // Update the global orders variable
                    currentPage = 1; // Reset to the first page
                    renderTable(orders);
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
                        url: "{{ route('orderSearchOrder') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            searchValue: searchValue
                        },
                        success: function(response) {
                            // Update your UI with the retrieved data
                            // console.log(response);
                            orders = response.orders; // Update the global orders variable
                            currentPage = 1; // Reset to the first page
                            renderTable(orders);
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            }
        });

        $("body").on("click", ".edit-order", function(){
            var orderId = $(this).data('value');
            window.open('order_details/edit/' + orderId + '/order?active_tab=order', '_blank');
        });
        $("body").on("click", ".edit-order-upcoming", function(){
            var orderId = $(this).data('value');
            $.ajax({
                url: '{{ route('getupcomingorderdetails') }}',
                method: 'GET',
                data: {
                    orderId: orderId
                },
                beforeSend: function () {
                    // Show loader if needed
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data) {
                    var tbody = $('#upcoming_order_items_body');
                    tbody.empty(); // Clear any existing rows
                    var total_qty = 0;
                    if (data.orderDetails) {
                        data.orderDetails.forEach(function(item, index) {
                            var displayName = item.display_name || (item.sub_product ? item.sub_product.product_name : '');
                            // var attributes = item.attributes ? item.attributes : '';
                            var attributeNames = item.order_item_attributes && Array.isArray(item.order_item_attributes)
        ? item.order_item_attributes.map(function(attributeItem) {
            return attributeItem.attribute.attribute_name;
        }).join(', ')
        : '';
                            console.log(attributeNames);
                            // console.log(item.sub_product.product_name);
                            var row = `
                                <tr>
                                    <th scope="row">${index + 1}</th>
                                    <td>${displayName}</td>
                                    <td>${attributeNames}</td>
                                    <td>${item.qty}</td>
                                </tr>
                            `;
                            tbody.append(row);
                            total_qty = total_qty + Number(item.qty);
                        });
                        var row = `
                                <tr style="background-color: #f7f7f7;">
                                    <th scope="row" >*</th>
                                    <td colspan="2" style="text-align: center;">Total Qty</td>
                                    <td>${total_qty}</td>
                                </tr>
                            `;
                            tbody.append(row);
                    } else {
                        var row = `
                            <tr>
                                <td colspan="3" class="text-center">No items found.</td>
                            </tr>
                        `;
                        tbody.append(row);
                    }
                    $('#view_upcoming_order_items').modal('show');
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

        //End order table


        // Shipment table
        var urgentOrders = @json($urgentOrders);
        // console.log(urgentOrders);

        function renderUrgentTable(data, labelText = 'Urgent Orders') {
            var tableBody = document.getElementById('urgent_orders_body');
            tableBody.innerHTML = '';
            // console.log(data);
            data.forEach(transaction => {
                var row = tableBody.insertRow();

                var orderType;

                if (transaction.is_urgent == 1){
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

                var exFactoryDate = transaction.ex_factory_date ? transaction.ex_factory_date : '';

                var totalQty = transaction.order_items.reduce((sum, item) => sum + Number(item.qty), 0);

// console.log(totalQty);
                row.innerHTML = `
                    <td class="font_color row_padding"><a href="#" class="edit-order" data-value="${transaction.id}">${transaction.order_no}</a></td>
                    <td class="font_color row_padding">${orderType}</td>
                    <td class="font_color row_padding">${exFactoryDate}</td>
                    <td class="font_color row_padding">${totalQty}</td>
                    <td class="font_color row_padding">${transaction.user_details.name}</td>
                `;
            });

            var urgentOrderLabel = document.getElementById('urgent_order_topic');
            urgentOrderLabel.innerHTML = labelText;

            setupPaginationUrgent(data);
        }

        function renderUpcomingTable(data, labelText = 'Urgent Orders') {
            var tableBody = document.getElementById('urgent_orders_body');
            tableBody.innerHTML = '';
            // console.log(data);
            data.forEach(transaction => {
                var row = tableBody.insertRow();

                var orderType;

                if (transaction.is_urgent == 1){
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

                var exFactoryDate = transaction.ex_factory_date ? transaction.ex_factory_date : '';

                var totalQty = transaction.order_items.reduce((sum, item) => sum + Number(item.qty), 0);

// console.log(totalQty);
                row.innerHTML = `
                    <td class="font_color row_padding"><a href="#" class="edit-order-upcoming" data-value="${transaction.id}">${transaction.order_no}</a></td>
                    <td class="font_color row_padding">${orderType}</td>
                    <td class="font_color row_padding">${exFactoryDate}</td>
                    <td class="font_color row_padding">${totalQty}</td>
                    <td class="font_color row_padding">${transaction.user_details.name}</td>
                `;
            });

            var urgentOrderLabel = document.getElementById('urgent_order_topic');
            urgentOrderLabel.innerHTML = labelText;

            setupPaginationUrgent(data);
        }

        // Initial call with the default label text
        renderUrgentTable(urgentOrders);

        // document.getElementById('new_order').addEventListener('click', function(event) {
        //     event.preventDefault();

        //     $.ajax({
        //         url: '{{ route('newOrdersFactoryDashboard') }}',
        //         method: 'GET',
        //         data: {},
        //         beforeSend: function () {
        //             // Show loader if needed
        //             $(".se-pre-con").fadeIn('slow');
        //         },
        //         success: function (data) {
        //             // console.log(data);
        //             urgentOrders = data.newOrders; // Update the global orders variable
        //             currentPage = 1; // Reset to the first page
        //             renderUrgentTable(urgentOrders, 'New Orders'); // Pass "New Orders" as the label text
        //         },
        //         error: function (error) {
        //             console.log('Error fetching data:', error);
        //         },
        //         complete: function () {
        //             // Hide loader if needed
        //             $(".se-pre-con").fadeOut('slow');
        //         }
        //     });
        // });


        document.getElementById('urgent_order').addEventListener('click', function(event) {
            event.preventDefault();

            $.ajax({
                url: '{{ route('urgentOrdersFactoryDashboard') }}',
                method: 'GET',
                data: {},
                beforeSend: function () {
                    // Show loader if needed
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data) {
                    // console.log(data);
                    urgentOrders = data.urgentOrders; // Update the global orders variable
                    currentPage = 1; // Reset to the first page
                    renderUrgentTable(urgentOrders, 'Urgent Orders'); // Pass "New Orders" as the label text
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


        document.getElementById('production_order').addEventListener('click', function(event) {
            event.preventDefault();

            $.ajax({
                url: '{{ route('productionOrdersFactoryDashboard') }}',
                method: 'GET',
                data: {},
                beforeSend: function () {
                    // Show loader if needed
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data) {
                    // console.log(data);
                    urgentOrders = data.productionOrders; // Update the global orders variable
                    currentPage = 1; // Reset to the first page
                    renderUrgentTable(urgentOrders, 'Production Orders'); // Pass "New Orders" as the label text
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

        document.getElementById('fulfiled_order').addEventListener('click', function(event) {
            event.preventDefault();

            $.ajax({
                url: '{{ route('fulfiledOrdersFactoryDashboard') }}',
                method: 'GET',
                data: {},
                beforeSend: function () {
                    // Show loader if needed
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data) {
                    // console.log(data);
                    urgentOrders = data.fulfiledOrders; // Update the global orders variable
                    currentPage = 1; // Reset to the first page
                    renderUrgentTable(urgentOrders, 'Fulfilled Orders'); // Pass "New Orders" as the label text
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

        document.getElementById('pending_shipment').addEventListener('click', function(event) {
            event.preventDefault();

            $.ajax({
                url: '{{ route('PendingShipOrdersFactoryDashboard') }}',
                method: 'GET',
                data: {},
                beforeSend: function () {
                    // Show loader if needed
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data) {
                    // console.log(data);
                    urgentOrders = data.commonOrdersArray; // Update the global orders variable
                    currentPage = 1; // Reset to the first page
                    renderUrgentTable(urgentOrders, 'Pending Shipment Orders'); // Pass "New Orders" as the label text
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
        document.getElementById('upcoming_orders').addEventListener('click', function(event) {
            event.preventDefault();

            $.ajax({
                url: '{{ route('upcomingOrdersGet') }}',
                method: 'GET',
                data: {},
                beforeSend: function () {
                    // Show loader if needed
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data) {
                    // console.log(data);
                    urgentOrders = data.commonOrdersArray; // Update the global orders variable
                    currentPage = 1; // Reset to the first page
                    renderUpcomingTable(urgentOrders, 'Upcoming Orders'); // Pass "New Orders" as the label text
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

        function setupPaginationUrgent(data) {
            var totalPages = Math.ceil(data.length / ordersPerPage);

            if (totalPages >= 1) {
                var pagination = '<nav aria-label="Page navigation"><ul class="pagination">';
                pagination += '<li class="page-item"><a class="page-link" href="#" data-page="prev" style="border-radius: unset; background-color:transparent; border:unset;">&laquo;</a></li>';

                if (totalPages <= maxPaginationLinks) {
                    for (var i = 1; i <= totalPages; i++) {
                        pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + i + '"  style="border-radius: unset; background-color:transparent; border:unset;">' + i + '</a></li>';
                    }
                } else {
                    var displayPaginationLinks = Math.min(maxPaginationLinks, totalPages);
                    var startPagination = 1;
                    var endPagination = displayPaginationLinks;

                    if (currentPage > Math.floor(maxPaginationLinks / 2)) {
                        startPagination = currentPage - Math.floor(maxPaginationLinks / 2);
                        endPagination = currentPage + Math.ceil(maxPaginationLinks / 2) - 1;

                        if (endPagination > totalPages) {
                            endPagination = totalPages;
                            startPagination = endPagination - maxPaginationLinks + 1;
                        }
                    }

                    for (var i = startPagination; i <= endPagination; i++) {
                        pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + i + '"  style="border-radius: unset; background-color:transparent; border:unset;">' + i + '</a></li>';
                    }
                }

                pagination += '<li class="page-item"><a class="page-link" href="#" data-page="next"  style="border-radius: unset; background-color:transparent; border:unset;">&raquo;</a></li>';
                pagination += '</ul></nav>';

                $('#paginationbarUrgent').empty().append(pagination);

                // Show the initial page
                showPageUrgent(currentPage, data);

                // Pagination click event
                $('#paginationbarUrgent').on('click', '.page-link', function(e) {
                    e.preventDefault();

                    var page = $(this).data('page');

                    if (page === 'prev') {
                        currentPage = Math.max(1, currentPage - 1);
                    } else if (page === 'next') {
                        currentPage = Math.min(totalPages, currentPage + 1);
                    } else {
                        currentPage = page;
                    }

                    // Update pagination visibility
                    var startPagination = 1;
                    var endPagination = startPagination + maxPaginationLinks - 1;

                    if (currentPage > maxPaginationLinks) {
                        startPagination = currentPage - Math.floor(maxPaginationLinks / 2);
                        endPagination = currentPage + Math.ceil(maxPaginationLinks / 2) - 1;
                    }

                    if (endPagination > totalPages) {
                        endPagination = totalPages;
                        startPagination = endPagination - maxPaginationLinks + 1;
                    }

                    if (startPagination < 1) {
                        startPagination = 1;
                    }

                    pagination = '<nav aria-label="Page navigation"><ul class="pagination">';
                    pagination += '<li class="page-item"><a class="page-link" href="#" data-page="prev"  style="border-radius: unset; background-color:transparent; border:unset;">&laquo;</a></li>';

                    for (var i = startPagination; i <= endPagination; i++) {
                        pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + i + '" style="border-radius: unset; background-color:transparent; border:unset;">' + i + '</a></li>';
                    }

                    pagination += '<li class="page-item"><a class="page-link" href="#" data-page="next" style="border-radius: unset; background-color:transparent; border:unset;">&raquo;</a></li>';
                    pagination += '</ul></nav>';

                    $('#paginationbarUrgent').empty().append(pagination);

                    showPageUrgent(currentPage, data);
                });

                // Always show the previous and next link buttons
                $('#paginationbarUrgent .page-item:first-child').removeClass('d-none');
                $('#paginationbarUrgent .page-item:last-child').removeClass('d-none');
            }
        }

        function showPageUrgent(pageNum, data) {
            var startIndex = (pageNum - 1) * ordersPerPage;
            var endIndex = startIndex + ordersPerPage;

            // Hide all rows
            $('#urgent_orders_body tr').hide();

            // Show only the relevant rows
            $('#urgent_orders_body tr').slice(startIndex, endIndex).show();

            // Update active page in pagination bar
            $('#paginationbarUrgent .page-item').removeClass('active');
            $('#paginationbarUrgent .page-link[data-page="' + pageNum + '"]').parent().addClass('active');
        }

        $(document).ready(function(){
            $(".se-pre-con").fadeOut('slow');
        });

    </script>
@endsection
