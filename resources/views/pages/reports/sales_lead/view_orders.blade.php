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
        padding-right: 3%;
        padding-left: 2%;
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
</style>

@if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif
<div id="buffering_icon1" style="display: none;">
    <img src="{{ asset('argon') }}/img/icons/buffering_icon.gif" />
</div>

<div class=" mb-5 content-position print_content">

    @section('order-header')
        <span>Sales Lead Summary Report</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('reports') }}" class="home-btn-color" title="BACK TO LEAD SUMMARY">BACK TO LEAD SUMMARY</a>
    @endsection


    <div class="col-md-12 "  style="padding-bottom: 25px !important;">

        <div class="row" style="padding-left: 25px;">
            <strong class="order_list_topic">{{ $Selectedcategory }} Order List  {{ $Selectedyear }}</strong>

            <div style="padding-left: 20px; padding-top: 5px;">
                <select id="ordersPerPage" onchange="changeOrdersPerPage()">
                    <option value="5">5 per page</option>
                    <option value="10" >10 per page</option>
                    <option value="20" selected>20 per page</option>
                    <option value="50">50 per page</option>
                </select>
            </div>

            <div class="ml-auto print_btn">
                <a class="top_button download_btn" href="#"><i class="fa fa-download" style="margin-right: 8px;"></i></a>
            </div>
            <div class="ml-auto print_btn" style="margin-left: unset !important;">
                <a class="top_button print_button" href="#"><i class="fa fa-print" style="margin-right: 8px;"></i></a>
            </div>

        </div>

        <div class="card orders_summary" style="border: unset; padding: 10px;">
            <div class="order_sammary_table" style="overflow-x: auto;">
                <table class="table align-items-center" id="order_sammary_table" style="min-width: 100%;">

                    <thead style="background-color: #717070;">
                        <th scope="col" class="table_header_text">ORDER ID</th>
                        <th scope="col" class="table_header_text">CREATED DATE </th>
                        <th scope="col" class="table_header_text">IN HAND DUE DATE </th>
                        <th scope="col" class="table_header_text">ORGANIZATION </th>
                        <th scope="col" class="table_header_text">ITEM QTY </th>
                        <th scope="col" class="table_header_text" style="text-align: right;">TOTAL ($)  </th>
                    </thead>

                    <tbody>

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

var emailOrders = {!! json_encode($viewOrders) !!};
console.log(emailOrders);

if (emailOrders && typeof emailOrders === 'object') {
    var tableBody = document.querySelector('#order_sammary_table tbody');
    var paginationBar = document.getElementById('paginationbar');
    var totalOrderTotal = 0;
    var totalOrderItems = 0;
    var ordersPerPage = 20; // Default number of orders per page
    var currentPage = 1; // Initialize current page

    // Convert emailOrders to an array for easier pagination handling
    var emailOrdersArray = Object.keys(emailOrders).map(key => emailOrders[key]);

    // Function to display orders for a given page
    function showOrders(page, data) {
        tableBody.innerHTML = ''; // Clear existing table rows
        totalOrderTotal = 0; // Reset total order total
        totalOrderItems = 0; // Reset total order items

        var startIndex = (page - 1) * ordersPerPage;
        var endIndex = startIndex + ordersPerPage;
        var totalPages = Math.ceil(data.length / ordersPerPage);

        for (var i = startIndex; i < endIndex && i < data.length; i++) {
            var order = data[i];
            var totalItems = order.order_items && Array.isArray(order.order_items) ? order.order_items.length : 0;
            var organization = order.organization_details;

            var row = `
                <tr>
                    <td class="table-bottom-details2"><a href="#" class="edit-order" data-value="${order.id}">${order.order_no}</a></td>
                    <td class="table-bottom-details2">${order.open_date}</td>
                    <td class="table-bottom-details2">${order.due_date}</td>
                    <td class="table-bottom-details2">${organization.organization_name}</td>
                    <td class="table-bottom-details2">${totalItems}</td>
                    <td class="table-bottom-details2" style="text-align: right;">${order.order_total}</td>
                </tr>
            `;

            totalOrderTotal += parseFloat(order.order_total);
            totalOrderItems += parseFloat(totalItems);

            tableBody.innerHTML += row;
        }

        var formattedTotal = totalOrderTotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        var totalRow = `
            <tr style="background-color: #F5F5F5;">
                <td colspan="4" class="text-right">Total:</td>
                <td class="table-bottom-details2">${totalOrderItems}</td>
                <td class="table-bottom-details2" style="text-align: right;">${formattedTotal}</td>
            </tr>
        `;
        tableBody.innerHTML += totalRow;

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
        var totalPages = Math.ceil(emailOrdersArray.length / ordersPerPage);
        if (page > totalPages) page = totalPages;
        currentPage = page;
        showOrders(currentPage, emailOrdersArray);
    }

    // Function to handle change in number of orders per page
    function changeOrdersPerPage() {
        ordersPerPage = parseInt(document.getElementById('ordersPerPage').value);
        currentPage = 1; // Reset to first page
        showOrders(currentPage, emailOrdersArray);
    }

    // Initialize pagination
    showOrders(currentPage, emailOrdersArray);
} else {
    console.error('emailOrders is not an object.');
}


    document.addEventListener('DOMContentLoaded', function () {
        var Selectedcategory = {!! json_encode($Selectedcategory) !!};
        var Selectedyear = {!! json_encode($Selectedyear) !!};

        var downloadBtn = document.querySelector('.download_btn');
        downloadBtn.addEventListener('click', function () {
            // Assuming selectedYear is defined and contains the selected year value
            var selectedYear = Selectedyear;
            var selectedcategory = Selectedcategory;

            var routeUrl = "{{ url('/reportCSV_Download/') }}" + '/' + selectedYear  + '/' + selectedcategory;

            // Redirect or perform an action with the generated route URL
            window.location.href = routeUrl;
        });
    });

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

    $("body").on("click", ".edit-order", function(){
        // $(".se-pre-con").fadeIn('slow');
        var orderId = $(this).data('value');
        // window.location.replace('order_details/edit/'+orderId+'/order?active_tab=order');
        window.open('order_details/edit/'+orderId+'/order?active_tab=order', '_blank');
    });

</script>

@endsection
