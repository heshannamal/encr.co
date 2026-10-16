@extends('pages.customer_portal.layouts.sidebar', ['sub_active' => 'dashboard'])

@section('sub-sidebar-content')

<style>

.search-btn {
    width: 48px;
    flex-shrink: 0;
    border-radius: 50px;
    min-width: 60px;
}

@media (max-width: 768px) {
    .padding_top_10 {
        padding-top: 10px;
    }
    .margin_bottom_10 {
        margin-bottom: 20px !important;
    }
}
/* Desktop - normal table */
.recent-orders-table {
    width: 100%;
}

@media (max-width: 768px) {

    /* Remove table responsive behavior */
    .recent-orders-table {
        overflow: visible !important;
    }

    .recent-orders-table table {
        display: block !important;
        width: 100% !important;
    }

    .recent-orders-table thead {
        display: none !important;
    }

    .recent-orders-table tbody {
        display: flex !important;
        flex-direction: column !important;
        gap: 10px !important;
        width: 100% !important;
    }

    /* Each order becomes a card */
    .recent-orders-table tbody tr {
        display: grid !important;

        grid-template-columns: 1fr auto !important;
        grid-template-rows: auto auto !important;

        width: 100% !important;

        padding: 12px 14px !important;
        margin: 0 !important;

        background: #fff !important;

        border: 1px solid #e5e7eb !important;
        border-radius: 12px !important;

        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06) !important;

        align-items: center !important;
    }

    /* Remove normal table borders */
    .recent-orders-table tbody td {
        border: none !important;
        padding: 0 !important;
    }

    /* =========================
       ORDER NUMBER
       ========================= */

    .recent-orders-table tbody td:nth-child(1) {
        grid-column: 1 !important;
        grid-row: 1 !important;

        font-size: 14px !important;
        font-weight: 700 !important;
    }

    .recent-orders-table tbody td:nth-child(1) a {
        text-decoration: none !important;
        color: #2563EB !important;
    }

    /* Add "Order" before order number */
    .recent-orders-table tbody td:nth-child(1) a::before {
        content: "#" !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        color: #2563EB !important;
    }


    /* =========================
       AMOUNT - RIGHT TOP
       ========================= */

    .recent-orders-table tbody td:nth-child(4) {
        grid-column: 2 !important;
        grid-row: 1 / span 2 !important;

        align-self: center !important;

        text-align: right !important;

        font-size: 15px !important;
        font-weight: 700 !important;

        color: #40536a !important;

        white-space: nowrap !important;
        padding-left: 10px !important;
    }


    /* =========================
       STATUS
       ========================= */

    .recent-orders-table tbody td:nth-child(2) {
        grid-column: 1 !important;
        grid-row: 2 !important;

        padding-top: 7px !important;
    }

    .recent-orders-table tbody td:nth-child(2) .lable-table {
        display: inline-block !important;

        font-size: 9px !important;
        padding: 4px 8px !important;

        white-space: nowrap !important;
        width: 85px;
        text-align: center;
    }


    /* =========================
       SALES REP
       ========================= */

    .recent-orders-table tbody td:nth-child(3) {
        content: "👤" !important;
        grid-column: 1 !important;
        grid-row: 2 !important;

        padding-top: 7px !important;
        padding-left: 100px !important;

        font-size: 11px !important;
        color: #68707c !important;
    }

    /* Put status + sales rep in same row */
    .recent-orders-table tbody td:nth-child(2),
    .recent-orders-table tbody td:nth-child(3) {
        display: inline-block !important;
    }


}

/* =========================================
   UNPAID ORDERS - MOBILE CARD VIEW
========================================= */

@media (max-width: 768px) {

    .unpaid-orders-table {
        overflow: visible !important;
    }

    .unpaid-orders-table table {
        width: 100% !important;
        border-collapse: separate !important;
        border-spacing: 0 10px !important;
    }

    /* Hide table header */
    .unpaid-orders-table thead {
        display: none !important;
    }

    /* Each TR becomes a card */
    .unpaid-orders-table tbody tr.unpaid-order-card {
        display: grid !important;

        grid-template-columns: 1fr auto !important;
        grid-template-rows: auto auto !important;

        position: relative !important;

        background: #ffffff !important;

        border: 1px solid #e5e7eb !important;
        border-radius: 12px !important;

        padding: 16px 14px !important;

        margin-bottom: 10px !important;

        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06) !important;
    }

    /* Remove normal table behavior */
    .unpaid-orders-table tbody tr.unpaid-order-card td {
        display: block !important;

        border: none !important;

        padding: 0;

        background: transparent !important;
    }

    /* -----------------------------------------
       ROW 1 - ORDER ID
    ----------------------------------------- */

    .unpaid-orders-table .unpaid-order-id {
        grid-column: 1 / 2 !important;
        grid-row: 1 !important;

        font-size: 14px !important;
        font-weight: 700 !important;

        padding-bottom: 8px !important;
    }
    .unpaid-orders-table .unpaid-order-id a::before {
        content: "#" !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        color: #2563EB !important;
    }

    .unpaid-orders-table .unpaid-order-id a {
        color: #2563EB !important;
        text-decoration: none !important;
    }


    /* -----------------------------------------
       ROW 2 - SALES REP
    ----------------------------------------- */

    .unpaid-orders-table .unpaid-order-sales {
        grid-column: 1 / 2 !important;
        grid-row: 2 !important;

        font-size: 12px !important;
        color: #6b7280 !important;

        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;

        padding-left: 100px !important;
    }


    /* -----------------------------------------
       ROW 2 - DUE DATE
    ----------------------------------------- */

    .unpaid-orders-table .unpaid-order-due {
        grid-column: 1 / 2 !important;
        grid-row: 2 !important;

        margin-left: 0 !important;
        /* padding-left: 120px !important; */

        font-size: 12px !important;
        color: #6b7280 !important;

        white-space: nowrap !important;
    }


    /* -----------------------------------------
       AMOUNT - RIGHT CORNER
    ----------------------------------------- */

    .unpaid-orders-table .unpaid-order-amount {
        grid-column: 2 / 3 !important;
        grid-row: 1 / 3 !important;

        align-self: center !important;
        justify-self: end !important;

        font-size: 15px !important;
        font-weight: 700 !important;

        color: #DC2626 !important;

        white-space: nowrap !important;

        padding-left: 15px !important;
    }

}

</style>
<div id="order-data" data-percentage-change="{{ $percentageChangeFormatted }}"></div>

<div class="row g-2 margin_bottom_10" style="margin-bottom: 1.5rem;">
    <!-- Find My Order -->
    <div class="col-12 col-lg-8 d-flex">
        <div class="card w-100 h-100 rounded-4 d-flex flex-column">
            <div class="card-body d-flex flex-column">
                <p class="mb-1">Find My Order</p>
                <div class="search-bar flex-grow-1">
                    <div class="d-flex gap-2">
                        <div class="position-relative flex-grow-1">
                            <input
                                class="form-control rounded-5 px-5"
                                id="dashboard_order_tracking_search"
                                type="text"
                                placeholder="Enter your Order Number"
                            >
                            <span class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50 text-muted">
                                search
                            </span>
                        </div>
                        <button class="btn btn-success d-flex align-items-center justify-content-center search-btn" id="dashboard_order_tracking_btn" type="button">
                            Find
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders in Production -->
    <div class="col-6 col-lg-2 d-flex padding_top_10">
        <div class="card w-100 h-100 rounded-4 d-flex flex-column">
            <div class="card-body">
                <p class="mb-3">Orders in Production</p>
                <h4 class="mb-0" style="color: #29ff22">{{$CompleteorderCount}}</h4>
            </div>
        </div>
    </div>

    <!-- Total Outstanding -->
    <div class="col-6 col-lg-2 d-flex padding_top_10">
        <div class="card w-100 h-100 rounded-4 d-flex flex-column">
            <div class="card-body">
                <p class="mb-3">Total Outstanding</p>
                <h6 class="mb-0" style="color: #ff4322">
                    ${{ number_format($totalOutstanding, 2) }}
                </h6>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12 col-lg-12 ">
        {{-- <div class="card w-100 rounded-4">
            <div class="card-body"> --}}
                <div class="col-12 col-lg-12  d-flex  flex-column" >
                    <div class="col-lg-12 col-xxl-12 d-flex align-items-stretch ">
                        <div class="card w-100 rounded-4">
                        <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div class="">
                                <h5 class="mb-0">Recent Orders</h5>
                            </div>
                            </div>
                            <div class="table-responsive recent-orders-table">
                                <table class="table align-middle">
                                <thead>
                                    <tr>
                                    <th>Order #</th>
                                    <th>Status</th>
                                    <th>Seles Rep</th>
                                    <th>Amount</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                    @foreach ($resentOrders as $resentOrder )
                                    @php
                                                if ($resentOrder->order_status_id == 1) {
                                                    $order_status = 'QUOTE';
                                                    $bg_color = 'bg-warning-subtle text-warning';
                                                    $icon = 'bi-info-circle';
                                                } elseif ($resentOrder->order_status_id == 2) {
                                                    $order_status = 'INVOICE';
                                                    $bg_color = '#0f9f00';
                                                    $color = '#b0ffc4';
                                                    $icon = 'bi-info-circle';
                                                } elseif ($resentOrder->order_status_id == 3) {
                                                    $order_status = 'PRODUCTION';
                                                    $bg_color = 'bg-primary-subtle text-primary';
                                                    $icon = 'bi-check2';
                                                } elseif ($resentOrder->order_status_id == 4) {
                                                    $order_status = 'FULFILLED';
                                                    $bg_color = 'bg-success-subtle text-success';
                                                    $icon = 'bi-check2';
                                                } elseif ($resentOrder->order_status_id == 5) {
                                                    $order_status = 'SHIPPED';
                                                    $bg_color = '#0f9f00';
                                                    $color = '#b0ffc4';
                                                    $icon = 'bi-info-circle';
                                                } elseif ($resentOrder->order_status_id == 6) {
                                                    $order_status = 'DELIVERED';
                                                    $bg_color = '#0f9f00';
                                                    $color = '#b0ffc4';
                                                    $icon = 'bi-info-circle';
                                                } else {
                                                    $order_status = 'CANCELED';
                                                    $bg_color = '#0f9f00';
                                                    $color = '#b0ffc4';
                                                    $icon = 'bi-info-circle';
                                                }
                                            @endphp
                                        <tr>
                                            <td><a href="{{ route('customer_portal.order_view', ['id' => $resentOrder->id]) }}">{{$resentOrder->order_no}}</a></td>
                                            <td><span class="lable-table {{ $bg_color }} rounded border border-success-subtle font-text2 fw-bold">{{ $order_status }}</span></td>
                                            <td>{{$resentOrder->userDetails->name}}</td>
                                            <td>${{ number_format($resentOrder->order_total, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-12  d-flex  flex-column align-items-stretch" >
                    <div class="col-lg-12 col-xxl-12 d-flex align-items-stretch ">
                        <div class="card w-100 rounded-4">
                        <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div class="">
                                <h5 class="mb-0">Unpaid Orders</h5>
                            </div>
                            </div>
                            <div class="table-responsive unpaid-orders-table">
                                <table class="table align-middle">
                                <thead>
                                    <tr>
                                    <th>Order #</th>
                                    <th>Sales Rep</th>
                                    <th>Due Date</th>
                                    <th>Amount</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        @foreach ($unpaidOrders as $unpaidOrder )
                                        <tr class="unpaid-order-card">
                                            <td class="unpaid-order-id"><a href="{{ route('customer_portal.order_view', ['id' => $unpaidOrder->id]) }}">{{$unpaidOrder->order_no}}</a></td>
                                            <td class="unpaid-order-sales">{{$unpaidOrder->userDetails->name}}</td>
                                            <td class="unpaid-order-due">{{$unpaidOrder->due_date}}</td>
                                            <td class="unpaid-order-amount">${{ number_format($unpaidOrder->order_total, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            {{-- </div>
        </div> --}}
    </div>
    {{-- <div class="col-12 col-lg-4 d-flex align-items-stretch">
        <div class="card w-100 rounded-4">
            <div class="card-body hero rounded-4 h-100" style="padding-top: unset;">
                <div class="title">fully customizable</div>
                <!-- BACKGROUND MOVING ITEMS -->
                <div class="columns">
                    <div class="column col1">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 1.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 2.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 3.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 4.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 1.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 2.png') }}">
                    </div>

                    <div class="column col2">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 5.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 6.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 7.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 8.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 5.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 6.png') }}">

                    </div>

                    <div class="column col3">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 9.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 10.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 11.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 12.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 9.png') }}">
                        <img src="{{ asset('assets/customer_portal/assets/images/banner/Rectangle 10.png') }}">
                    </div>
                </div>

                <!-- FRONT MAIN IMAGE -->
                <div class="main-product">
                    <img src="{{ asset('assets/customer_portal/assets/images/banner/main.png') }}">
                </div>

                <button class="cta" id="browseCatalogBtn">BROWSE OUR CATALOG</button>

            </div>
        </div>
    </div> --}}
</div>
<!-- GSAP -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>


{{-- <script>
    // 1. Get current Year-Month (e.g., "2025-12")
    const now = new Date();
    const currentMonthStr = now.getFullYear() + "-" + String(now.getMonth() + 1).padStart(2, '0');
    $(".month-picker").flatpickr({
        disableMobile: "true", // Recommended: mobile native pickers often don't support month-only

        plugins: [
            new monthSelectPlugin({
                shorthand: false,    // "January" instead of "Jan"
                dateFormat: "Y-m",   // Value in the actual hidden input (for DB)
                altFormat: "F Y",    // Value displayed to user
                theme: "light"
            })
        ],
        altInput: true,             // Enables the user-friendly display format
        allowInput: false,          // Prevents users from typing manually
        clickOpens: true,
        defaultDate: currentMonthStr,
        onChange: function(selectedDates, dateStr, instance) {
            if(dateStr) {
                console.log("Selected Month:", dateStr); // Output: 2025-12
                fetchChartData(dateStr);
            }
        }

    });
    fetchChartData(currentMonthStr);
// Function to fetch chart data from Laravel for a given month
function fetchChartData(month) {
    // 1. Manually show the Encore Loader
    const body = document.body;
    body.classList.remove('pace-done');
    body.classList.add('pace-running');

    axios.get("{{ route('dashboard.chart.order-tracking') }}", { params: { month } })
        .then(response => {
            // Destructure month_name from your Laravel response
            const { dates, paid, unpaid, month_name } = response.data;

            // 2. Pass data to the drawing function
            drawChart(response.data);
        })
        .catch(error => {
            console.error("Error fetching order data:", error);
        })
        .finally(() => {
            // 3. Hide the loader with the fade-out effect
            body.classList.remove('pace-running');
            body.classList.add('pace-done');
        });
}
// Global chart instance
let orderChart = null;

function drawChart(data) {
    const ctx = document.getElementById('orderTrackingChart').getContext('2d');
    const statusLabels = ['Quote', 'Production', 'Shipping', 'Fulfilled'];
// 2. CRITICAL: Destroy the old chart if it exists
    if (orderChart !== null) {
        orderChart.destroy();
    }
    orderChart = new Chart(ctx, {
        type: 'line',
        data: {
            datasets: [
                {
                    label: 'Paid',
                    data: data.paid, // Uses the {x, y} objects directly
                    borderColor: '#4CAF50',
                    tension: 0,
                    spanGaps: true
                },
                {
                    label: 'Unpaid',
                    data: data.unpaid,
                    borderColor: '#FFC107',
                    tension: 0,
                    spanGaps: true,
                    pointRadius: 0
                }
            ]
        },
        options: {
            scales: {
                x: {
                    type: 'linear',
                    min: 1,
                    max: data.daysInMonth,
                    ticks: { stepSize: 1 }
                },
                y: {
                    min: 0,
                    max: 3,
                    ticks: {
                        stepSize: 1,
                        callback: (value) => statusLabels[value]
                    }
                }
            }
        }
    });
}
function showNoDataMessage() {
    document.getElementById('no-data-notice').style.display = 'block';
}
</script> --}}

<script>

    function trackOrder() {
    const orderNo = $('#dashboard_order_tracking_search').val().trim();
    if (!orderNo) return;

    const url =
        "{{ route('customer.orders.track') }}?order=" + encodeURIComponent(orderNo);

    window.open(url, '_blank');
}

// Enter key
$('#dashboard_order_tracking_search').on('keypress', function (e) {
    if (e.which === 13) {
        e.preventDefault();
        trackOrder();
    }
});

// Button click
$('#dashboard_order_tracking_btn').on('click', function () {
    trackOrder();
});


    function isEmptyData(arr) {
        return arr.every(v => v === 0);
    }

    const monthLabels = [
        'Jan','Feb','Mar','Apr','May','Jun',
        'Jul','Aug','Sep','Oct','Nov','Dec'
    ];


    // // Center text plugin
    // const centerTextPlugin = {
    //     id: 'centerText',
    //     beforeDraw(chart) {
    //         const { ctx, width, height } = chart;
    //         const text = chart.config.options.plugins.centerText?.text;

    //         if (!text) return;

    //         ctx.save();
    //         ctx.font = 'bold 18px sans-serif';
    //         ctx.fillStyle = '#0f172a';
    //         ctx.textAlign = 'center';
    //         ctx.textBaseline = 'middle';
    //         ctx.fillText(text, width / 2, height / 2);
    //         ctx.restore();
    //     }
    // };

    // Chart.register(ChartDataLabels, centerTextPlugin);
    document.getElementById('yearSelect').addEventListener('change', function () {
        fetchPieChartData(this.value);
    });

    // Global chart instances
    let orderStatusChart = null;
    let paymentStatusChart = null;

    // Default year = current year
    const currentYear = new Date().getFullYear();
console.log(currentYear);

    // Initial load
    fetchPieChartData(2025);

    /**
     * Fetch chart data from Laravel
     */
    function fetchPieChartData(year) {
    axios.get("{{ route('dashboard.chart.order-summary') }}", {
        params: { year }
    }).then(res => {
        //drawOrderStatusLine(res.data.order_status_monthly);
       // drawOrderStatusBar(res.data.order_status_monthly);
        // drawPaymentStatusLine(res.data.payment_status_monthly);
    });
}

function hideZeroBars(arr) {
    return arr.map(v => (v === 0 ? null : v));
}

    /**
     * PIE CHART 1 - Order Status Counts
     */
   function drawOrderStatusLine(data) {

    const ctx = document.getElementById('orderStatusLine');

    if (orderStatusChart) orderStatusChart.destroy();

    const allValues = [
        ...data.quote,
        ...data.production,
        ...data.shipping,
        ...data.fulfilled
    ];

    // EMPTY STATE
    if (isEmptyData(allValues)) {
        orderStatusChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'No Data',
                    data: Array(12).fill(null),
                    borderColor: '#e5e7eb',
                    tension: 0
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'No order data available'
                    }
                },
                elements: {
                    line: { tension: 0 }
                }
            }
        });
        return;
    }

    orderStatusChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: monthLabels,
            datasets: [
                {
                    label: 'Quote',
                    data: data.quote,
                    borderColor: '#64748b',
                    tension: 0
                },
                {
                    label: 'Production',
                    data: data.production,
                    borderColor: '#3b82f6',
                    tension: 0
                },
                {
                    label: 'Shipping',
                    data: data.shipping,
                    borderColor: '#f59e0b',
                    tension: 0
                },
                {
                    label: 'Fulfilled',
                    data: data.fulfilled,
                    borderColor: '#22c55e',
                    tension: 0
                }
            ]
        },
        options: {
            responsive: true,
            elements: {
                line: {
                    tension: 0 // 🔥 force straight lines globally
                }
            },
            animation: {
                duration: 1200,
                easing: 'easeOutQuart'
            },
            plugins: {
                legend: { position: 'bottom' },
                tooltip: { mode: 'index', intersect: false }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function drawOrderStatusBar(data) {

    const ctx = document.getElementById('orderStatusLine');

    if (orderStatusChart) orderStatusChart.destroy();

    const datasetsRaw = {
        quote: hideZeroBars(data.quote),
        production: hideZeroBars(data.production),
        shipping: hideZeroBars(data.shipping),
        fulfilled: hideZeroBars(data.fulfilled),
    };

    const allValues = [
        ...datasetsRaw.quote,
        ...datasetsRaw.production,
        ...datasetsRaw.shipping,
        ...datasetsRaw.fulfilled
    ];

    // EMPTY STATE
    if (isEmptyData(allValues)) {
        orderStatusChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'No Data',
                    data: Array(12).fill(null),
                    backgroundColor: '#e5e7eb'
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'No order data available'
                    }
                }
            }
        });
        return;
    }

    orderStatusChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: monthLabels,
            datasets: [
                {
                    label: 'Quote',
                    data: datasetsRaw.quote,
                    backgroundColor: '#64748b'
                },
                {
                    label: 'Production',
                    data: datasetsRaw.production,
                    backgroundColor: '#3b82f6'
                },
                {
                    label: 'Shipping',
                    data: datasetsRaw.shipping,
                    backgroundColor: '#f59e0b'
                },
                {
                    label: 'Fulfilled',
                    data: datasetsRaw.fulfilled,
                    backgroundColor: '#22c55e'
                }
            ]
        },
        options: {
            responsive: true,
            animation: {
                duration: 800,
                easing: 'easeOutQuart'
            },
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                x: {
                    stacked: false
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}


    /**
     * PIE CHART 2 - Payment Status (Amount-based)
     */
    function drawPaymentStatusLine(data) {

    const ctx = document.getElementById('paymentStatusLine');

    if (paymentStatusChart) paymentStatusChart.destroy();

    const allValues = [
        ...data.paid,
        ...data.partial,
        ...data.unpaid
    ];

    // EMPTY STATE
    if (isEmptyData(allValues)) {
        paymentStatusChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'No Data',
                    data: Array(12).fill(null),
                    borderColor: '#e5e7eb'
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'No payment data available'
                    }
                }
            }
        });
        return;
    }

    paymentStatusChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: monthLabels,
            datasets: [
                {
                    label: 'Paid',
                    data: data.paid,
                    borderColor: '#16a34a',
                    tension: 0.4
                },
                {
                    label: 'Partial',
                    data: data.partial,
                    borderColor: '#facc15',
                    tension: 0.4
                },
                {
                    label: 'Unpaid',
                    data: data.unpaid,
                    borderColor: '#dc2626',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            animation: {
                duration: 1200,
                easing: 'easeOutQuart'
            },
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: ctx =>
                            ctx.dataset.label +
                            ': LKR ' + ctx.raw.toLocaleString()
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}


</script>


@endsection
