@extends('layouts.app', ['activePage' => 'order', 'titlePage' => __('Pdf')])

@section('content')

<style>
    .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
        background-color: transparent !important;
    }
    .table_header_text {
        color: white;
        height: 40px;
    }
    .bargraph_header {
        color: black;
        font-size: 17px;
    }
    .color_div {
        border: 1px solid rgb(189, 189, 189);
        margin-right: 15px;
        border-radius: 3px;
        margin-left: 10px;
        height: 17px;
        margin-top: 10px;
    }
    .row_padding {
        padding-bottom: 10px !important;
        padding-top: 10px !important;
    }
    .nav-item.active > .nav-link {
        border-left: unset !important;
    }
    .print_btn {
        padding-right: 3%;
        padding-left: 1%;
    }
    .top_button {
        font-size: 12px;
        font-weight: 600;
        color: #B3B3B3;
    }
    .search_class {
        padding: 2px;
        border: unset;
        border-bottom: 2px solid rgb(212, 212, 212);
        margin-right: 30px;
        font-size: 14px;
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
    .nav-tabs {
        border-bottom: unset;
    }
    .today_color {
        background-color: rgba(25, 219, 125, 0.72);
        width: 15px;
        height: 15px;
        border-radius: 3px;
        margin-top: 2px;
    }
    .past_color {
        background-color: rgba(255, 0, 0, 0.82);
        width: 15px;
        height: 15px;
        border-radius: 3px;
        margin-top: 2px;
        margin-left: 25px;
    }
    .thisWeek_color {
        background-color: rgba(255, 117, 17, 0.76);
        width: 15px;
        height: 15px;
        border-radius: 3px;
        margin-top: 2px;
        margin-left: 25px;
    }
    .fulfilled_color {
        background-color: rgb(205, 205, 205);
        width: 15px;
        height: 15px;
        border-radius: 3px;
        margin-top: 2px;
        margin-left: 25px;
    }
    .cancel_color {
        background-color: rgba(255, 0, 0, 0.4);
        width: 15px;
        height: 15px;
        border-radius: 3px;
        margin-top: 2px;
        margin-left: 25px;
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
        color: #B3B3B3;
        font-weight: 500;
    }
    .date_p:hover {
        color: #B3B3B3 !important;
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
        <span>Encore Order Schedule</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12" style="padding-bottom: 25px !important;">
        <div class="row" style="margin-left: 5px; margin-right: 30px; padding-bottom: 7px;">
            <div class="col-md-2" style="margin-bottom: 10px;">
                <select class="form-control" id="yearSelect" style="height: 20px;">
                    @php
                        $currentYear = now()->year;
                        $startYear = $currentYear - 4;
                    @endphp
                    @for ($year = $startYear; $year <= $currentYear; $year++)
                        <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="col-md-2">
            </div>
            <div class="ml-auto">
                {{-- <div class="ml-auto"> --}}
                    <div class="row">

                        <div class="today_color"></div>
                        <strong class="production_text">Today Orders</strong>

                        <div class="past_color"></div>
                        <strong class="production_text">Past The Ex Factory Date </strong>

                        <div class="thisWeek_color"></div>
                        <strong class="production_text"> This Week Shipment</strong>

                        <div class="fulfilled_color"></div>
                        <strong class="production_text">Fulfilled Orders </strong>

                        <div class="cancel_color"></div>
                        <strong class="production_text">Canceled Orders </strong>

                    </div>
                {{-- </div> --}}
            </div>
        </div>

        <div class="row" style="margin-left: 18px; margin-right: 30px; padding-bottom: 7px;">
            <div class="row filter_row " style="padding-bottom: 2px;">
                <p class="font_color date_p" style="padding-left: 5px;">Factory |  </p>
                <div class="paymen_type_div date_selection" style="padding-left: 10px;">
                    <select id="factory" class="date_selection">
                        <option value="all">All</option>
                        @foreach ($factories as $factory)
                            <option value="{{ $factory->id }}">{{ $factory->factory_code }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row filter_row" style="padding-bottom: 2px;margin-left: 20px;">
                <p class="font_color date_p">Order Status |  </p>
                <div class="paymen_type_div date_selection" style="padding-left: 7px;">
                    <select id="orderStatus" class="date_selection">
                        <option value="all">All</option>
                        @foreach ($orderStatus as $orderStatuss)
                            <option value="{{ $orderStatuss->id }}">{{ $orderStatuss->status_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row filter_row" style="padding-bottom: 2px; margin-left: 20px;">
                <p class="font_color date_p" style="padding-left: 5px;">Test Pring |  </p>
                <div class="paymen_type_div date_selection" style="padding-left: 7px;">
                    <select id="testPrint" class="date_selection">
                        <option value="all">All</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>

            <div class="row filter_row" style="padding-bottom: 2px; margin-left: 20px;">
                <p class="font_color date_p">Rep |  </p>
                <div class="paymen_type_div date_selection" style="padding-left: 7px;">
                    <select id="usersSales" class="date_selection">
                        <option value="all">All</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="margin-left: 45px;">
                <div class="row" style="padding-bottom: 2px;">
                    <a href="#" class="date_p filter_btn" id="pin-filter" title="Filter">
                        <i class="fa fa-filter " style="padding-left: 5px; padding-top: 4px; padding-right: 5px;"></i>
                        Filter
                    </a>
                </div>
            </div>

        </div>

        <div class="row" style="margin-left: 10px; margin-right: 10px; border-bottom: 3px solid #dee2e6; padding-bottom: 7px;">
            <div>
                <ul class="nav nav-tabs" id="myTabs" role="tablist">
                    @php
                        $currentMonth = now()->month;
                        $months = [
                            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
                        ];
                    @endphp

                    @foreach ($months as $monthNum => $monthName)
                        <li class="nav-item month-tab" id="month{{ $monthNum }}">
                            <a class="nav-link" id="tab-{{ $monthNum }}" data-toggle="tab" href="#content-{{ $monthNum }}"
                                role="tab" aria-controls="content-{{ $monthNum }}">
                                {{ $monthName }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>


        </div>




        <div class="card orders_summary print_content" style="border: unset; padding: 10px;">

            <div class="row" style="padding-left: 10px; padding-right: 10px;">
                <div style="padding: 5px;">
                    <b class="bargraph_header font_color">Order Schedule Sheet</b>
                </div>

                <div class="" style="padding-left: 40px;">
                    <div class="row">
                        <label for="" style="margin-bottom: unset; padding-top: 8px;">Select a Color</label>
                        <div class="color_div">
                            <input type="color" id="favcolor" name="favcolor" value="">
                        </div>
                    </div>
                </div>

                <div class="ml-auto print_btn" style="width: 32%;">
                    <div class="row">
                        <input class="search_class" id="searchOrder" type="text" placeholder="Order Search" style="width: 80%;">
                        <a class="top_button download_btn export_btn" href="#" title="Export CSV"><i class="fa fa-download" style="margin-right: 8px; margin-top: 8px;"></i></a>
                    </div>
                </div>
            </div>

            <div class="order_shedule_table" style="overflow-x: auto;">
                <table class="table align-items-center" id="order_shedule_table" style="min-width: 100%;">

                    <thead style="background-color: #717070;">
                        <th scope="col" class="table_header_text">FLAG</th>
                        <th scope="col" class="table_header_text">ORDER #</th>
                        <th scope="col" class="table_header_text">FACTORY</th>
                        <th scope="col" class="table_header_text">ORGANIZATION </th>
                        <th scope="col" class="table_header_text">CONFIRMED EX FACTORY </th>
                        <th scope="col" class="table_header_text">REQUESTED EX FACTORY </th>
                        <th scope="col" class="table_header_text">IN HAND</th>
                        <th scope="col" class="table_header_text">TEST PRINT NEEDED?</th>
                        <th scope="col" class="table_header_text">TEST PRINT DUE DATE</th>
                        <th scope="col" class="table_header_text">ORDER STATUS</th>
                        <th scope="col" class="table_header_text">ORDER TYPE </th>
                        <th scope="col" class="table_header_text">SALES REP</th>
                        <th scope="col" class="table_header_text">RECEIVED DATE </th>
                        <th scope="col" class="table_header_text">ORDER QTY </th>
                        <th scope="col" class="table_header_text">SPECIAL COMMENTS </th>
                    </thead>

                    <tbody id="table_body">

                    </tbody>
                </table>

            </div>
        </div>
    </div>


</div>

<!-- Special Comment Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('saveSpecialComment') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Special Comment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea class="form-control special_comment" id="special_comment" name="special_comment" style="resize: vertical;"></textarea>
                    <input type="hidden" class="order_id" id="order_id" name="order_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>


<script>
    // function updateTabs() {
    //     var currentYear = new Date().getFullYear();
    //     var currentMonth = new Date().getMonth() + 1; // Months are zero-indexed
    //     var selectedYear = document.getElementById('yearSelect').value;

    //     var monthTabs = document.getElementsByClassName('month-tab');
    //     for (var i = 0; i < monthTabs.length; i++) {
    //         var monthTab = monthTabs[i];
    //         var monthNum = parseInt(monthTab.id.replace('month', ''));

    //         if (selectedYear == currentYear) {
    //             // Hide future months for the current year
    //             if (monthNum > currentMonth) {
    //                 monthTab.style.display = 'none';
    //             } else {
    //                 monthTab.style.display = '';
    //             }
    //         } else {
    //             // Show all months for past years
    //             monthTab.style.display = '';
    //         }
    //     }
    // }

    // // Initial call to set the correct tabs on page load
    // updateTabs();


    // default table load
    var transactionsArray = @json($orders);
    var ordersData = transactionsArray.data;

    var tableBody = document.getElementById('table_body');

    console.log(ordersData);

    // Collect rows with order_status_id 4 or 7
    let specialRows = [];

    // Process each transaction
    ordersData.forEach(transaction => {
        var uniqueFactories = Array.from(new Set(transaction.order_items.map(item => item.factory_details?.factory_code ?? '')));
        var factories = uniqueFactories.filter(code => code !== '').join(', ');

        var factoryConfirmedDate = transaction.factory_confirmation_date ? transaction.factory_confirmation_date : '';

        var dueDate = transaction.due_date ? transaction.due_date : '';

        var testPrintNeeded = transaction.order_items.some(item => item.test_print_needed == 1) &&
                      transaction.order_items.every(item => item.test_print_needed == 0 || item.test_print_needed == 1)
                      ? 'Yes'
                      : 'No';

        var formattedNearestTestPrintDueDate = null;

        if (testPrintNeeded === 'Yes') {
            orderItem = transaction.order_items;
            let currentDate = new Date().getTime(); // Current date in milliseconds
            let nearestDate = Infinity; // Initialize nearestDate to a large value

            orderItem.forEach(transactions => {
                let testPrintDueDate = new Date(transactions.test_print_due_date).getTime();
                if (!isNaN(testPrintDueDate)) { // Check if the date is valid
                    let diff = Math.abs(testPrintDueDate - currentDate);
                    if (diff < nearestDate) {
                        nearestDate = diff;
                        formattedNearestTestPrintDueDate = transactions.test_print_due_date;
                    }
                }
            });

            // If no valid date was found, set formattedNearestTestPrintDueDate to an empty string
            if (nearestDate === Infinity) {
                formattedNearestTestPrintDueDate = '';
            }
        } else {
            formattedNearestTestPrintDueDate = '';
        }


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

        var orderItemCount = transaction.order_items.length;

        var row = tableBody.insertRow();

        var specialCommentCell;
        if (transaction.shedule_comment) {
            const comments = transaction.shedule_comment.split('\n');
            const firstComment = comments[0].trim();
            specialCommentCell = `<td class="font_color row_padding">${firstComment} <a href="#" class="specialCommentUpdate" id="specialCommentUpdate" data-value="${transaction.id}" data-schedule-comment="${transaction.shedule_comment}" style="margin-left: 13px;"><i class="fa fa-pen"></i></a></td>`;
        } else {
            specialCommentCell = `<td class="font_color row_padding" style="text-align: center;"><a href="#" class="specialComment" id="specialComment" data-value="${transaction.id}"><i class="fa fa-comment-dots"></i></a></td>`;
        }

        var receivedDate = transaction.production_date ? transaction.production_date : '';

        row.innerHTML = `
            <td class="font_color row_padding color_picker">
                <div class="" id="colorDisplay_${transaction.order_no}">
                    <input type="checkbox" class="order_checkbox" id="${transaction.order_no}" name="${transaction.id}" value="${transaction.id}">
                </div>
            </td>
            <td class="font_color row_padding"><a href="#" class="edit-order" data-value="${transaction.id}">${transaction.order_no}</a></td>
            <td class="font_color row_padding">${factories}</td>
            <td class="font_color row_padding">${transaction.organization_details.organization_name}</td>
            <td class="font_color row_padding">${factoryConfirmedDate}</td>
            <td class="font_color row_padding">${transaction.ex_factory_date}</td>
            <td class="font_color row_padding">${dueDate}</td>
            <td class="font_color row_padding">${testPrintNeeded}</td>
            <td class="font_color row_padding">${formattedNearestTestPrintDueDate}</td>
            <td class="font_color row_padding">${transaction.status_details.status_name}</td>
            <td class="font_color row_padding">${orderType}</td>
            <td class="font_color row_padding">${transaction.user_details.name}</td>
            <td class="font_color row_padding">${receivedDate}</td>
            <td class="font_color row_padding">${orderItemCount}</td>
            ${specialCommentCell}
        `;

        const exFactoryDate = new Date(transaction.ex_factory_date);
        const currentDate = new Date();
        const oneDayInMillis = 24 * 60 * 60 * 1000;

        const startOfToday = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate());

        const isToday = exFactoryDate.getFullYear() === currentDate.getFullYear() &&
                exFactoryDate.getMonth() === currentDate.getMonth() &&
                exFactoryDate.getDate() === currentDate.getDate();

        // Calculate start of the current week (Monday)
        const startOfCurrentWeek = new Date(currentDate);
        const day = startOfCurrentWeek.getDay();
        const diff = startOfCurrentWeek.getDate() - day + (day === 0 ? -6 : 1); // Adjust when day is Sunday
        startOfCurrentWeek.setDate(diff);

        // Calculate end of the current week (Sunday)
        const endOfCurrentWeek = new Date(startOfCurrentWeek);
        endOfCurrentWeek.setDate(startOfCurrentWeek.getDate() + 6);

        const isThisWeek = exFactoryDate >= startOfCurrentWeek && exFactoryDate <= endOfCurrentWeek;



         if (isToday && transaction.order_status_id == 3) { // today
            row.style.backgroundColor = 'rgba(25, 219, 125, 0.72)';
        } else  if (exFactoryDate < startOfToday && transaction.order_status_id == 3) { // past day delay
            row.style.backgroundColor = 'rgba(255, 0, 0, 0.82)';
        } else if (isThisWeek && transaction.order_status_id == 3) { // this week shipment from today
            row.style.backgroundColor = 'rgba(255, 117, 17, 0.76)';
        } else if (transaction.order_status_id == 4 ) { // Fulfilled
            row.style.backgroundColor = 'rgb(205, 205, 205)';
            specialRows.push(row);
        } else if (transaction.order_status_id == 7) { //Cancel
            row.style.backgroundColor = 'rgba(255, 0, 0, 0.4)';
            specialRows.push(row);
        // } else if (transaction.order_status_id == 3) {
        //     row.style.backgroundColor = 'rgba(251, 87, 121, 0.73)';
        } else if (transaction.shedule_color) {
            row.style.backgroundColor = transaction.shedule_color;
        }

        const colorInput = document.getElementById('favcolor');
        const checkboxes = document.querySelectorAll('.order_checkbox');

        colorInput.addEventListener('input', function() {
            const selectedColor = colorInput.value;
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const row = checkbox.closest('tr');
                    row.style.backgroundColor = selectedColor;
                }
            });
        });

        // Special Comment Update
        document.addEventListener('DOMContentLoaded', function() {
            const specialCommentUpdateLinks = document.querySelectorAll('.specialCommentUpdate');

            specialCommentUpdateLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();

                    const orderId = this.getAttribute('data-value');
                    const scheduleComment = this.getAttribute('data-schedule-comment');
                    openUpdateModal(orderId, scheduleComment);
                });
            });

            function openUpdateModal(orderId, scheduleComment) {
                const modalTitle = document.getElementById('modalTitle');
                modalTitle.textContent = 'Special Comment - Order ID: ' + orderId;

                const orderIdInput = document.querySelector('.order_id');
                const specialCommentUpdate = document.querySelector('.special_comment');
                orderIdInput.value = orderId;
                specialCommentUpdate.value = scheduleComment;

                $('#myModal').modal('show');
            }
        });
        // End Special Comment Update
    });

    // Append special rows at the end of the table
    specialRows.forEach(row => tableBody.appendChild(row));

    // End default table load


    //Change color
    document.addEventListener('DOMContentLoaded', function() {
        const colorInput = document.getElementById('favcolor');

        // Function to send AJAX request
        function sendColorData(data) {
            $.ajax({
                url: '{{ route('orderSheduleColor') }}',
                method: 'POST',
                data: {
                    selectedOrders: data.selectedOrders,
                    selectedColor: data.selectedColor
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log(response);
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        }

        // Event listener for color input change
        colorInput.addEventListener('input', function() {
            const checkboxes = document.querySelectorAll('.order_checkbox');
            const selectedOrders = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);
            const selectedColor = colorInput.value;
            const data = { selectedOrders, selectedColor };
            console.log(data);
            sendColorData(data);
        });
    });
    // End Change color


    //Month display change related selected year
    document.addEventListener('DOMContentLoaded', function () {
        // Function to toggle active class for tabs
        function toggleActiveTab(tabId) {
            var tabs = document.querySelectorAll('.nav-link');
            tabs.forEach(function (tab) {
                tab.classList.remove('active');
            });
            var tabToActivate = document.querySelector('#tab-' + tabId);
            tabToActivate.classList.add('active');
        }

        var currentMonth = new Date().getMonth() + 1;
        toggleActiveTab(currentMonth);

        // document.getElementById('yearSelect').addEventListener('change', function () {
        //     var selectedYear = parseInt(this.value);
        //     var currentYear = new Date().getFullYear();
        //     var currentMonth = new Date().getMonth() + 1;

        //     if (selectedYear < currentYear) {
        //         for (var i = 1; i <= 12; i++) {
        //             document.getElementById('month' + i).style.display = 'block';
        //         }
        //     } else {
        //         for (var i = 1; i <= 12; i++) {
        //             if (i <= currentMonth) {
        //                 document.getElementById('month' + i).style.display = 'block';
        //             } else {
        //                 document.getElementById('month' + i).style.display = 'none';
        //             }
        //         }
        //         toggleActiveTab(currentMonth);
        //     }
        // });

        document.getElementById('yearSelect').dispatchEvent(new Event('change'));

        // Event listener for tab clicks
        var tabs = document.querySelectorAll('.nav-link');
        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                var tabId = this.getAttribute('id').replace('tab-', '');
                toggleActiveTab(tabId);
            });
        });
    });
    // End Month display change related selected year

    // Update table data related selected month and year
    $(document).ready(function() {
        $('#myTabs a').on('click', function (e) {
            e.preventDefault();
            var month = $(this).attr('id').replace('tab-', '');
            var year = $('#yearSelect').val();
            const factory = document.getElementById('factory').value;
            const orderStatus = document.getElementById('orderStatus').value;
            const testPrint = document.getElementById('testPrint').value;
            const usersSales = document.getElementById('usersSales').value;
            fetchDataFromController(month, year, factory, orderStatus, testPrint, usersSales);
            // console.log(orderStatus);
        });

        var searchValue = null;

        function fetchDataFromController(month, year, factory, orderStatus, testPrint, usersSales) {
            var searchValue = $('#searchOrder').val().trim();
            $.ajax({
                url: '{{ route('filterOrdershedule') }}',
                method: 'GET',
                data: { month: month,
                        year: year,
                        searchValue: searchValue,
                        factory: factory,
                        orderStatus: orderStatus,
                        testPrint: testPrint,
                        usersSales: usersSales
                     },
                beforeSend: function () {
                    // Show loader if needed
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function(response) {
                    console.log(response);
                    updateTable(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                },
                complete: function () {
                    // Hide loader if needed
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        }
    });
    // End Update table data related selected month and year

    // filter orders
    document.getElementById('pin-filter').addEventListener('click', function(event) {
        event.preventDefault();
        const factory = document.getElementById('factory').value;
        const orderStatus = document.getElementById('orderStatus').value;
        const testPrint = document.getElementById('testPrint').value;
        const usersSales = document.getElementById('usersSales').value;
        const year = document.getElementById('yearSelect').value;
        var activeTab = document.querySelector('.nav-link.active');
        if (activeTab) {
            var month = activeTab.id.replace('tab-', '');
            console.log(month);
        }
        $.ajax({
            url: '{{ route('filterOrdershedule') }}',
            method: 'GET',
            data: {
                factory: factory,
                orderStatus: orderStatus,
                testPrint: testPrint,
                usersSales: usersSales,
                year: year,
                month: month,
            },
            beforeSend: function () {
                // Show loader if needed
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (response) {
                console.log(response);
                updateTable(response);
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

    //end filter orders

    // Update table
    function updateTable(response) {

        var ordersData = response.orders;

        var tableBody = document.getElementById('table_body');
        tableBody.innerHTML = '';

        console.log(ordersData);

        // Collect rows with order_status_id 4 or 7
        let specialRows = [];

        // Process each transaction
        ordersData.forEach(transaction => {
            var uniqueFactories = Array.from(new Set(transaction.order_items.map(item => item.factory_details && item.factory_details.factory_code)));

            var factories = uniqueFactories.join(', ');

            var factoryConfirmedDate = transaction.factory_confirmation_date ? transaction.factory_confirmation_date : '';

            var dueDate = transaction.due_date ? transaction.due_date : '';

            // Determine if testPrintNeeded is 'Yes' or 'No'
            // var testPrintNeeded = (transaction.order_items.filter(item => item.test_print_needed == 1).length == 1 && transaction.order_items.every(item => item.test_print_needed == 0 || item.test_print_needed == 1))
            //     ? 'Yes'
            //     : 'No';

            var testPrintNeeded = transaction.order_items.some(item => item.test_print_needed == 1) &&
                      transaction.order_items.every(item => item.test_print_needed == 0 || item.test_print_needed == 1)
                      ? 'Yes'
                      : 'No';



            var formattedNearestTestPrintDueDate = null;

            if (testPrintNeeded === 'Yes') {
                orderItem = transaction.order_items;
                let currentDate = new Date().getTime(); // Current date in milliseconds
                let nearestDate = Infinity; // Initialize nearestDate to a large value

                orderItem.forEach(transactions => {
                    let testPrintDueDate = new Date(transactions.test_print_due_date).getTime();
                    if (!isNaN(testPrintDueDate)) { // Check if the date is valid
                        let diff = Math.abs(testPrintDueDate - currentDate);
                        if (diff < nearestDate) {
                            nearestDate = diff;
                            formattedNearestTestPrintDueDate = transactions.test_print_due_date;
                        }
                    }
                });

                // If no valid date was found, set formattedNearestTestPrintDueDate to an empty string
                if (nearestDate === Infinity) {
                    formattedNearestTestPrintDueDate = '';
                }
            } else {
                formattedNearestTestPrintDueDate = '';
            }


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

            var orderItemCount = transaction.order_items.length;

            var row = tableBody.insertRow();

            var specialCommentCell;
            if (transaction.shedule_comment) {
                specialCommentCell = `<td class="font_color row_padding">${transaction.shedule_comment} <a href="#" class="specialCommentUpdate" id="specialCommentUpdate" data-value="${transaction.id}" data-schedule-comment="${transaction.shedule_comment}" style="margin-left: 13px;"><i class="fa fa-pen"></i></a></td>`;
            } else {
                specialCommentCell = `<td class="font_color row_padding" style="text-align: center;"><a href="#" class="specialComment" id="specialComment" data-value="${transaction.id}"><i class="fa fa-comment-dots"></i></a></td>`;
            }

            var receivedDate = transaction.production_date ? transaction.production_date : '';

            row.innerHTML = `
                <td class="font_color row_padding color_picker">
                    <div class="" id="colorDisplay_${transaction.order_no}">
                        <input type="checkbox" class="order_checkbox" id="${transaction.order_no}" name="${transaction.id}" value="${transaction.id}">
                    </div>
                </td>
                <td class="font_color row_padding"><a href="#" class="edit-order" data-value="${transaction.id}">${transaction.order_no}</a></td>
                <td class="font_color row_padding">${factories}</td>
                <td class="font_color row_padding">${transaction.organization_details.organization_name}</td>
                <td class="font_color row_padding">${factoryConfirmedDate}</td>
                <td class="font_color row_padding">${transaction.ex_factory_date}</td>
                <td class="font_color row_padding">${dueDate}</td>
                <td class="font_color row_padding">${testPrintNeeded}</td>
                <td class="font_color row_padding">${formattedNearestTestPrintDueDate}</td>
                <td class="font_color row_padding">${transaction.status_details.status_name}</td>
                <td class="font_color row_padding">${orderType}</td>
                <td class="font_color row_padding">${transaction.user_details.name}</td>
                <td class="font_color row_padding">${receivedDate}</td>
                <td class="font_color row_padding">${orderItemCount}</td>
                ${specialCommentCell}
            `;


            const exFactoryDate = new Date(transaction.ex_factory_date);
            const currentDate = new Date();
            const oneDayInMillis = 24 * 60 * 60 * 1000;

            const startOfToday = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate());

            const isToday = exFactoryDate.getFullYear() === currentDate.getFullYear() &&
                    exFactoryDate.getMonth() === currentDate.getMonth() &&
                    exFactoryDate.getDate() === currentDate.getDate();

            // Calculate start of the current week (Monday)
            const startOfCurrentWeek = new Date(currentDate);
            const day = startOfCurrentWeek.getDay();
            const diff = startOfCurrentWeek.getDate() - day + (day === 0 ? -6 : 1); // Adjust when day is Sunday
            startOfCurrentWeek.setDate(diff);

            // Calculate end of the current week (Sunday)
            const endOfCurrentWeek = new Date(startOfCurrentWeek);
            endOfCurrentWeek.setDate(startOfCurrentWeek.getDate() + 6);

            const isThisWeek = exFactoryDate >= startOfCurrentWeek && exFactoryDate <= endOfCurrentWeek;



            if (isToday && transaction.order_status_id == 3) { // today
                row.style.backgroundColor = 'rgba(25, 219, 125, 0.72)';
            } else  if (exFactoryDate < startOfToday && transaction.order_status_id == 3) { // past day delay
                row.style.backgroundColor = 'rgba(255, 0, 0, 0.82)';
            } else if (isThisWeek && transaction.order_status_id == 3) { // next week shipment from today
                row.style.backgroundColor = 'rgba(255, 117, 17, 0.76)';
            } else if (transaction.order_status_id == 4 ) { // Fulfilled
                row.style.backgroundColor = 'rgb(205, 205, 205)';
                specialRows.push(row);
            } else if (transaction.order_status_id == 7) { //Cancel
                row.style.backgroundColor = 'rgba(255, 0, 0, 0.4)';
                specialRows.push(row);
            // } else if (transaction.order_status_id == 3) {
            //     row.style.backgroundColor = 'rgba(251, 87, 121, 0.73)';
            } else if (transaction.shedule_color) {
                row.style.backgroundColor = transaction.shedule_color;
            }

            // Change color filtered
            const colorInput = document.getElementById('favcolor');
            const checkboxes = document.querySelectorAll('.order_checkbox');

            colorInput.addEventListener('input', function() {
                const selectedColor = colorInput.value;
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const row = checkbox.closest('tr');
                        row.style.backgroundColor = selectedColor;
                    }
                });
            });
            // End Change color filtered

            // Special Comment Update filtered
            const specialCommentUpdateLinks = document.querySelectorAll('.specialCommentUpdate');

            specialCommentUpdateLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();

                    const orderId = this.getAttribute('data-value');
                    const scheduleComment = this.getAttribute('data-schedule-comment');
                    openUpdateModal1(orderId, scheduleComment);
                });
            });

            function openUpdateModal1(orderId, scheduleComment) {
                const modalTitle = document.getElementById('modalTitle');
                modalTitle.textContent = 'Special Comment - Order ID: ' + orderId;

                const orderIdInput = document.querySelector('.order_id');
                const specialCommentUpdate = document.querySelector('.special_comment');
                orderIdInput.value = orderId;
                specialCommentUpdate.value = scheduleComment;

                $('#myModal').modal('show');
            }
            // End Special Comment Update filtered
        });

        // Append special rows at the end of the table
        specialRows.forEach(row => tableBody.appendChild(row));

        // End update table


        //Special Comment filtered
        const specialCommentLinks = document.querySelectorAll('.specialComment');

        specialCommentLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();

                const orderId = this.getAttribute('data-value');
                openModal1(orderId);
            });
        });

        function openModal1(orderId) {

            const modalTitle = document.getElementById('modalTitle');
            modalTitle.textContent = 'Special Comment - Order ID: ' + orderId;

            const orderIdInput = document.querySelector('.order_id');
            orderIdInput.value = orderId;

            $('#myModal').modal('show');
        }
        // End Special Comment filtered

    }
    //end update table

    //Special Comment
    document.addEventListener('DOMContentLoaded', function() {
        const specialCommentLinks = document.querySelectorAll('.specialComment');

        specialCommentLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();

                const orderId = this.getAttribute('data-value');
                openModal(orderId);
            });
        });

        function openModal(orderId) {

            const modalTitle = document.getElementById('modalTitle');
            modalTitle.textContent = 'Special Comment - Order ID: ' + orderId;

            const orderIdInput = document.querySelector('.order_id');
            orderIdInput.value = orderId;

            $('#myModal').modal('show');
        }

    });
    //Special Comment End

    //Download CSV
    document.addEventListener('DOMContentLoaded', function () {
        var downloadBtn = document.querySelector('.download_btn');
        downloadBtn.addEventListener('click', function () {
            var selectedYear = document.getElementById('yearSelect').value;

            var selectedMonthElement = document.querySelector('.nav-link.active');
            var selectedMonthName = selectedMonthElement.textContent.trim();

            var months = {
                'January': 1, 'February': 2, 'March': 3, 'April': 4,
                'May': 5, 'June': 6, 'July': 7, 'August': 8,
                'September': 9, 'October': 10, 'November': 11, 'December': 12,
            };
            var selectedMonth = months[selectedMonthName];

            console.log('Selected Year:', selectedYear);
            console.log('Selected Month:', selectedMonth);

            var routeUrl = "{{ url('/orderShedule_CSV_download/') }}" + '/' + selectedYear  + '/' + selectedMonth;

            window.location.href = routeUrl;

        });
    });

    // order redirect
    $("body").on("click", ".edit-order", function(){
        // $(".se-pre-con").fadeIn('slow');
        var orderId = $(this).data('value');
        // window.location.replace('order_details/edit/'+orderId+'/order?active_tab=order');
        window.open('order_details/edit/'+orderId+'/order?active_tab=order', '_blank');
    });
    // End order redirect

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
                var selectedYear = $('#yearSelect').val();
                var selectedMonth = $('.nav-tabs .nav-link.active').attr('id').split('-')[1];

                if (inputValue !== searchValue) { // Check if the input value has changed
                    searchValue = inputValue;
                    $.ajax({
                        url: "{{ route('sheduleSearchOrder') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            searchValue: searchValue,
                            selectedYear: selectedYear,
                            selectedMonth: selectedMonth
                        },
                        beforeSend: function () {
                            // Show loader if needed
                            $(".se-pre-con").fadeIn('slow');
                        },
                        success: function(response) {
                            // Update your UI with the retrieved data
                            console.log(response);
                            updateTable(response);
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

        // End Search order


        $(document).ready(function(){
            $(".se-pre-con").fadeOut('slow');
            $('.panel').css('display', 'block');
        });

</script>

@endsection
