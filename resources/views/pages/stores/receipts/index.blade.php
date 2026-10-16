@extends('layouts.app', ['activePage' => 'Team Stores', 'titlePage' => __('Team Stores')])

@section('sub-sidebar-content')

<style>
    .main_card {
        margin-top: 20px;
        border: unset;
        padding-bottom: 15px;
        border-radius: unset;
    }

    .accounting_header {
        font-size: 18px;
    }
    .card_div {
        padding: 15px;
        padding-bottom: 5px;
    }
    .per_page {
        font-size: 11px;
        color: #717070;
        font-weight: 500;
        margin-bottom: unset;
    }
    .search_icon {
        padding-top: 3px;
        padding-right: 6px;
    }
    .search_input {
        height: 25px;
        border: unset;
        width: 160px;
    }
    .table_header_text {
        color: white;
        height: 40px;
    }
    .accounting_sub_header {
        font-size: 19px;
    }
    .timeline_topic {
        font-size: 13px;
        color: #4E4C4C;
        font-weight: 600;
        margin-bottom: unset;
    }
    .timeline_details {
        font-size: 13px;
        color: #717070;
        font-weight: 400;
        margin-bottom: unset;
    }
    .account_topic {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: unset;
    }
    .account_details {
        font-size: 13px;
        font-weight: 400;
        margin-bottom: unset;
    }
    .account_details1 {
        font-size: 17px;
        font-weight: 600;
        margin-bottom: unset;
    }
    .timeline_row {
        margin: unset;
    }
    .timeline_topic_div {
        padding-bottom: 5px;
        width: 7rem;
    }
    .account_summary_div {
        padding-bottom: 5px;
        width: 11rem;
    }
    .account_summary_details_div {
        width: 5rem;
        text-align: right;
    }
    .flyer_textarea {
        width: 100%;
        height: 75px !important;
    }
    .dropdown-container {
        position: relative;
        width: 50%;
    }
    .dropdown-input {
        cursor: pointer;
        background-color: #fff;
    }
    .dropdown-chevron {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
    }
    .dropdown-menu-orders {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 1000;
        background: white;
        border: 1px solid #ccc;
        border-radius: 5px;
        max-height: 200px;
        overflow-y: auto;
        display: none;
        padding: 10px;
    }
    .receipt-styles input[type="text"],
    .receipt-styles input[type="checkbox"],
    .receipt-styles select,
    .receipt-styles textarea {
        font-size: .9rem;
        padding-left: .5rem;
        color: #555;
    }
    .receipt-styles select option {
        color: #555;
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

    @media (max-width: 767px) {
        /* Prevent iOS Safari from auto-zooming on focus */
        input[type="text"],
        input[type="number"],
        input[type="search"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        input[type="url"],
        select,
        textarea,
        .form-control,
        .select2-selection,
        .select2-search__field,
        .select2-search input {
            font-size: 16px !important;
        }

        .header-layout {
            margin-bottom: 0 !important;
            height: auto !important;
            min-height: 0 !important;
        }

    }

</style>


<div class="container-fluid mb-5" style="background-color: transparent;padding: 0 !important;">
    <div class="se-pre-con"></div>

    @include('pages.stores.layouts.top_header')

    @yield('stores_header')

    <div class="card col-lg-12 main_card receipt-styles" style="margin-top: 20px;">
        <div class="row">
            <div class="card_div col-md-12 mb-1 mt-2" style="padding: .5rem 2rem;">
                <strong class="accounting_header">Receipts</strong>
            </div>
            <div class="col-lg-6" style="padding: .5rem 2rem;">
                <div class="row">

                    <div class="col-lg-12 name_div mt-2">
                        <label class="info_label">Date Range</label>
                        <div class="row">
                            <div class="col">
                                <label for="from_date" class="small">From</label>
                                <input type="text" id="from_date" name="from_date" value="" class="form-control info_input date-picker">
                            </div>
                            <div class="col">
                                <label for="to_date" class="small">To</label>
                                <input type="text" id="to_date" name="to_date" value="" class="form-control info_input date-picker">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 name_div mt-3">
                        <label class="info_label">Orders</label>
                        <div class="dropdown-container">
                            <input type="text" value="No orders selected" class="form-control info_input dropdown-input" readonly>
                            <span class="dropdown-chevron"><i class="fa fa-chevron-down"></i></span>
                            <div class="dropdown-menu-orders" id="dropdown-menu-orders-list">
                                <p>No orders found.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 name_div mt-3 mb-3">
                        <label class="info_label">Sort By</label>
                        <select name="sort_by" style="width: 50%;" id="sort_by" class="form-control info_input">
                            <option value="created_at">Date created</option>
                            <option value="total">Amount</option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="col-lg-6" style="padding: .5rem 2rem;border-left: 1px solid #eeeeee;">
                <div class="mb-3"><b>Include Information</b></div>
                <div class="name_div">
                    <input type="checkbox" id="order_info" name="order_info" checked disabled>
                    <label for="order_info ">Order Info</label><br>

                    <input type="checkbox" id="customer_info" name="customer_info" checked>
                    <label for="customer_info">Customer Info</label><br>

                    <input type="checkbox" id="shipping_info" name="shipping_info" checked>
                    <label for="shipping_info">Shipping Info</label><br>

                    <input type="checkbox" id="custom_fields" name="custom_fields" checked>
                    <label for="custom_fields">Custom Fields</label><br>

                    <input type="checkbox" id="player_info" name="player_info" checked>
                    <label for="player_info">Player Info</label><br>
                </div>
            </div>
        </div>

        <hr style="margin: unset; margin-bottom: 15px; margin-top: 10px;">

        <div class="row mb-3">
            <div class="col-lg-12 mt-2" style="padding: .5rem 2rem;">
                <b>Custom Message</b>
                <p style="color: #b3b3b3;font-size: .8rem;">Limit message to 100 characters.</p>
                <textarea class="form-control flyer_textarea" name="custom_message" id="custom_message" cols="10" rows="5"></textarea>
            </div>
        </div>

        <hr style="margin: unset; margin-bottom: 15px; margin-top: 10px;">

        <div class="row">
            <div class="col-lg-12">
                <button type="button" class="view_store_btn float-right" id="generate_receipt" style="padding: .7rem 1rem;height: auto;font-size: .8rem;">Generate Receipt</button>
            </div>
        </div>

    </div>

</div>
<script>

    $(document).ready(function() {
        $('.date-picker').datepicker({
            format: 'mm/dd/yyyy',
            maxDate: 0
        }).datepicker('setDate', new Date());

        $(".dropdown-input, .dropdown-chevron").on("click", function () {
            $(".dropdown-menu-orders").toggle();
        });

        $(document).on("click", function (e) {
            if (!$(e.target).closest(".dropdown-container").length) {
                $(".dropdown-menu-orders").hide();
            }
        });

        // $(".dropdown-menu-orders input[type='checkbox']").on("change", function () {
        $(document).on("change", ".dropdown-menu-orders input[type='checkbox']", function () {
            updateDropdownCount();
        });

        $('.date-picker').on('change', function() {
            generateReceipt();
        });

        generateReceipt();

        var selectedOrderNumbers = [];

        function generateReceipt() {

            var fromDate = $('#from_date').val();
            var toDate = $('#to_date').val();
            var sortBy = $('#sort_by').val();

            $.ajax({
                url: "{{ route('store.get_filtered_store_orders') }}",
                type: 'GET',
                data: {
                    from_date: fromDate,
                    to_date: toDate,
                    sort_by: sortBy,
                    store_id: "{{ $store->id }}",
                },
                success: function(response) {

                    var dropdownMenu = $('#dropdown-menu-orders-list');
                    dropdownMenu.empty();

                    if (response.length > 0) {
                        var orderNumbers = '';
                        response.forEach(function(order) {
                            orderNumbers += `<label><input type="checkbox" value="${order.order_no}" checked>&nbsp;&nbsp;#${order.order_no}</label><br>`;
                        });
                        dropdownMenu.html(orderNumbers);
                    }else {
                        dropdownMenu.html('<p>No orders found.</p>');
                    }

                    updateDropdownCount();

                },
                error: function(xhr, status, error) {
                    console.error("Error generating receipt:", error);
                }
            });

        }
        function updateDropdownCount() {
            selectedOrderNumbers = [];
            $(".dropdown-menu-orders input[type='checkbox']:checked").each(function () {
                selectedOrderNumbers.push($(this).val());
            });

            if (selectedOrderNumbers.length) {
                $(".dropdown-input").val(selectedOrderNumbers.length + " Orders Selected");

            } else {
                $(".dropdown-input").val("No orders selected");
            }
        }
        $(document).on('click', '#generate_receipt', function(e) {
            e.preventDefault();

            $(".se-pre-con").fadeIn("slow");

            const storeId = "{{ $store->id }}";

            console.log(selectedOrderNumbers);

            $.ajax({
                url: "{{ route('store.download_order_receipt_all') }}",
                type: 'GET',
                data: {
                    order_numbers: selectedOrderNumbers,
                    store_id: storeId
                 },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(data, status, xhr) {
                    const disposition = xhr.getResponseHeader('Content-Disposition');
                    let filename = 'receipts.pdf';
                    if (disposition && disposition.indexOf('filename=') !== -1) {
                        filename = disposition.split('filename=')[1].replace(/"/g, '');
                    }
                    $(".se-pre-con").fadeOut("slow");

                    const blob = new Blob([data], { type: 'application/pdf' });
                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = filename;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                },
                error: function() {
                    $(".se-pre-con").fadeOut("slow");
                    console.error('Failed to download product report PDF.');
                }
            });
        });
    });
</script>

@endsection
@section('content')
    @include('pages.stores.layouts.sidebar', ['sub_content' => 'receipts'])
@endsection

