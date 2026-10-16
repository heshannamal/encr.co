@extends('layouts.app', ['activePage' => 'Team Stores', 'titlePage' => __('Team Stores')])

@section('sub-sidebar-content')

<style>
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
    .main_card {
        margin-top: 20px;
        border: unset;
        padding-bottom: 15px;
        border-radius: unset;
    }

    .packing_slip_topic {
        font-size: 18px;
    }
    .card_div {
        padding: 15px;
        padding-bottom: 5px;
    }
    .total_qty_text {
        font-size: 10px;
        color: #B3B3B3;
        font-weight: 500;
        margin-bottom: unset;
    }
    .stepper_b {
        color: #4E4C4C;
        font-size: 12px;
    }


/* stepper tab  */
    .container1 {
        width: 25%;
    }

    .step1 {
        padding: 10px;
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
        background-color: cream;
    }

    .v-stepper1 {
        position: relative;
        /*   visibility: visible; */
    }


    /* regular step */
    .step1 .circle {
        background-color: white;
        border: 3px solid gray;
        border-radius: 100%;
        width: 20px;    /* +6 for border */
        height: 20px;
        display: inline-block;
    }

    .step1 .line {
        top: 20px;
        left: 9px;
        /*   height: 120px; */
        height: 100%;
        position: absolute;
        border-left: 3px solid gray;
    }

    .step1.completed .circle {
        visibility: visible;
        background-color: #47D6B6;
        border-color: #47D6B6;
    }

    .step1.completed .line {
        border-left: 3px solid #47D6B6;
    }

    .step1.active .circle {
        visibility: visible;
        border-color: #47D6B6;
    }

    .step1.empty .circle {
        visibility: hidden;
    }

    .step1.empty .line {
        /*     visibility: hidden; */
        /*   height: 150%; */
        top: 0;
        height: 150%;
    }


    .step1:last-child .line {
        border-left: 3px solid white;
        z-index: -1; /* behind the circle to completely hide */
    }

    .content1 {
        margin-left: 20px;
        display: inline-block;
    }

/* end stepper tab  */


    .steps_div {
        width: 75%;
    }
    .steps_div2 {
        background-color: #FCFCFC;
        padding: 5px;
        margin-bottom: 15px;
    }
    .steps_div_row {
        margin: unset;
        padding: 10px;
    }
    .stepper_p {
        font-size: 12px;
        color: #717070;
        font-weight: 500;
        margin-bottom: unset;
        margin-left: 5px;
    }
    .select_box {
        width: 100%;
        height: 25px;
        border: 1px solid #838383;
        color: #555;
    }
    .step_label {
        font-size: 12px;
    }
    .info_input {
        height: 25px;
        border-radius: unset;
    }
    .add_message {
        width: 175px;
        height: 35px;
        background-color: #F8F8F8;
        border: 1px solid #838383;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        color: #B3B3B3;
    }
    .note_b {
        color: #717070;
        font-size: 11px;
    }
    .note_p {
        color: #717070;
        font-size: 11px;
        padding-left: 5px;
    }
    .add_secondary {
        color: #B3B3B3;
        font-size: 10px;
    }
    .add_secondary_btn {
        background-color: transparent;
        border: unset;
        cursor: pointer;
    }
    .download_pdf {
        width: 150px;
        height: 35px;
        background-color: #F8F8F8;
        border: 1px solid #DEDEDE;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        color: #B3B3B3;
    }
    .email_pdf {
        width: 125px;
        height: 35px;
        background-color: #F8F8F8;
        border: 1px solid #DEDEDE;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        color: #B3B3B3;
        margin-left: 12px;
    }

    @media (max-width: 767px) {
        .header-layout {
            margin-bottom: 0 !important;
            height: auto !important;
            min-height: 0 !important;
        }

        .swal2-popup .swal2-actions {
            width: 100% !important;
            display: flex !important;
            flex-direction: row !important;
            gap: 10px !important;
            padding: 0 10px !important;
            margin-top: 20px !important;
        }

        .swal2-popup .swal2-styled.swal2-confirm,
        .swal2-popup .swal2-styled.swal2-cancel {
            flex: 1 !important;
            margin: 0 !important;
            height: 50px !important;
            border-radius: 10px !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: none !important;
        }

        .swal2-popup .swal2-styled.swal2-confirm {
            background-color: #47D6B6 !important;
            border: 1px solid #47D6B6 !important;
            color: #ffffff !important;
        }

        .swal2-popup .swal2-styled.swal2-cancel {
            background-color: #ffffff !important;
            border: 1px solid #47D6B6 !important;
            color: #47D6B6 !important;
        }

        .swal2-popup .swal2-styled.swal2-confirm:active,
        .swal2-popup .swal2-styled.swal2-cancel:active {
            transform: scale(0.98) !important;
        }

        .swal2-popup .swal2-styled:focus {
            box-shadow: none !important;
        }

        .steps_div_row:has(.download_pdf) {
            display: flex !important;
            gap: 10px !important;
            padding: 15px 10px !important;
        }

        .download_pdf,
        .email_pdf {
            width: 100% !important;
            height: 46px !important;
            margin-left: 0 !important;
            border-radius: 8px !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            letter-spacing: 0.3px !important;
        }

        .download_pdf {
            background-color: #47D6B6 !important;
            border: 1px solid #47D6B6 !important;
            color: #ffffff !important;
        }

        .email_pdf {
            background-color: #ffffff !important;
            border: 1px solid #47D6B6 !important;
            color: #47D6B6 !important;
        }

        .download_pdf:active,
        .email_pdf:active {
            transform: scale(0.98) !important;
        }

        /* selectedOrdersModal mobile layout */
        #selectedOrdersModal .modal-dialog {
            margin: 10px !important;
            max-width: calc(100% - 20px) !important;
        }

        #selectedOrdersModal .modal-content {
            border-radius: 16px !important;
            border: none !important;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        }

        #selectedOrdersModal .modal-header {
            border-bottom: 1px dashed #e2e8f0 !important;
            padding: 15px 20px !important;
        }

        #selectedOrdersModal .modal-title {
            font-size: 18px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
        }

        #selectedOrdersModal .modal-body {
            padding: 15px !important;
            background-color: #f1f5f9 !important;
            max-height: 70vh !important;
            overflow-y: auto !important;
        }

        #selectedOrdersModal .col-md-12 {
            overflow-x: visible !important;
            padding: 0 !important;
        }

        #selected_orders_table {
            border: none !important;
            background: transparent !important;
            width: 100% !important;
            display: block !important;
        }

        #selected_orders_table thead {
            display: none !important;
        }

        #selected_orders_table tbody {
            display: block !important;
            background: transparent !important;
        }

        #selected_orders_table tr {
            display: grid !important;
            grid-template-columns: 40px 1fr auto !important;
            align-items: center !important;
            background: #ffffff !important;
            border: 1px solid #e8e8e8 !important;
            border-radius: 14px !important;
            padding: 12px 16px !important;
            margin-bottom: 12px !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04) !important;
            height: auto !important;
            border-bottom: 1px solid #e8e8e8 !important;
        }

        #selected_orders_table td {
            display: block !important;
            padding: 0 !important;
            border: none !important;
            text-align: left !important;
            height: auto !important;
            width: auto !important;
        }

        /* 1st td: Checkbox */
        #selected_orders_table td:nth-child(1) {
            grid-column: 1 !important;
            grid-row: 1 !important;
        }

        #selected_orders_table td:nth-child(1) input[type="checkbox"] {
            width: 18px !important;
            height: 18px !important;
            margin: 0 !important;
            accent-color: #10b981 !important;
        }

        /* 2nd td: Order No */
        #selected_orders_table td:nth-child(2) {
            grid-column: 2 !important;
            grid-row: 1 !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            font-size: 14px !important;
        }

        #selected_orders_table td:nth-child(2)::before {
            content: "Order #" !important;
        }

        /* 9th td: Status badge */
        #selected_orders_table td:nth-child(9) {
            grid-column: 3 !important;
            grid-row: 1 !important;
            justify-self: end !important;
        }

        /* 3rd td: Customer Name */
        #selected_orders_table td:nth-child(3) {
            grid-column: 2 / span 2 !important;
            grid-row: 2 !important;
            font-size: 12px !important;
            color: #64748b !important;
            margin-top: 8px !important;
        }

        #selected_orders_table td:nth-child(3)::before {
            content: "Customer: " !important;
            color: #94a3b8 !important;
            font-weight: 500 !important;
        }

        /* 6th td: Order Date */
        #selected_orders_table td:nth-child(6) {
            grid-column: 2 / span 2 !important;
            grid-row: 3 !important;
            font-size: 12px !important;
            color: #64748b !important;
            margin-top: 2px !important;
        }

        #selected_orders_table td:nth-child(6)::before {
            content: "Date: " !important;
            color: #94a3b8 !important;
            font-weight: 500 !important;
        }

        /* 8th td: Shipping Method */
        #selected_orders_table td:nth-child(8) {
            grid-column: 2 / span 2 !important;
            grid-row: 4 !important;
            font-size: 12px !important;
            color: #64748b !important;
            margin-top: 2px !important;
        }

        #selected_orders_table td:nth-child(8)::before {
            content: "Shipping: " !important;
            color: #94a3b8 !important;
            font-weight: 500 !important;
        }

        /* 7th td: Encr Order No */
        #selected_orders_table td:nth-child(7) {
            grid-column: 2 / span 2 !important;
            grid-row: 5 !important;
            font-size: 12px !important;
            color: #64748b !important;
            margin-top: 2px !important;
        }

        #selected_orders_table td:nth-child(7)::before {
            content: "Encr order no: " !important;
            color: #94a3b8 !important;
            font-weight: 500 !important;
        }

        /* 4th td: Order Total */
        #selected_orders_table td:nth-child(4) {
            grid-column: 2 !important;
            grid-row: 6 !important;
            font-size: 12px !important;
            color: #0f172a !important;
            margin-top: 4px !important;
        }

        #selected_orders_table td:nth-child(4)::before {
            content: "Order Total: $" !important;
            color: #94a3b8 !important;
            font-weight: 500 !important;
        }

        /* 5th td: Paid Amount */
        #selected_orders_table td:nth-child(5) {
            grid-column: 3 !important;
            grid-row: 6 !important;
            font-size: 12px !important;
            color: #10b981 !important;
            font-weight: 700 !important;
            margin-top: 4px !important;
            text-align: right !important;
        }

        #selected_orders_table td:nth-child(5)::before {
            content: "Paid Total: $" !important;
            color: #94a3b8 !important;
            font-weight: 500 !important;
        }

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
    }
</style>

<div class="container-fluid mb-5" style="padding: 0 !important;">
    <div class="se-pre-con"></div>

    @include('pages.stores.layouts.top_header')

    @yield('stores_header')

    <div class="card col-lg-12 main_card" style="margin-top: 20px;">
        <div class="">
            <div class="row">
                <div class="card_div" style="width: 80%;">
                    <strong class="packing_slip_topic">Packing Slips Builder</strong>
                </div>
            </div>
            <hr style="margin: unset; margin-bottom: 10px;">

        </div>

        <div class="row" style="padding: 20px;">

            <div class="container1">
                <!-- completed -->
                  <div class="step1 completed" id="step_1">
                    <div class="v-stepper1">
                      <div class="circle"></div>
                      <div class="line"></div>
                    </div>

                    <div class="content1">
                      <b class="stepper_b">STEP 1</b>
                      <p class="total_qty_text">Search and select orders</p>
                    </div>
                </div>

                <!-- active -->
                {{-- <div class="step1 active">
                  <div class="v-stepper1">
                    <div class="circle"></div>
                    <div class="line"></div>
                  </div>

                  <div class="content1">
                        <b class="stepper_b">STEP 2</b>
                      <p class="total_qty_text">Customize packing slips (Optional)</p>
                  </div>
                </div> --}}

                  <!-- empty -->
                <div class="step1" id="step_2">
                    <div class="v-stepper1">
                      <div class="circle"></div>
                      <div class="line"></div>
                    </div>

                    <div class="content1">
                        <b class="stepper_b">STEP 2</b>
                        <p class="total_qty_text">Sort packing slips for download (Optional)</p>
                    </div>
                </div>

                <!-- regular -->
                <div class="step1" id="step_3">
                    <div class="v-stepper1">
                      <div class="circle"></div>
                      <div class="line"></div>
                    </div>

                    <div class="content1">
                        <b class="stepper_b">STEP 3</b>
                        <p class="total_qty_text">Generate packing slips</p>
                    </div>
                </div>

            </div>

            <div class="steps_div">
                <div class="steps_div2">
                    <div class="row steps_div_row">
                        <b class="stepper_b">STEP 1 - </b>
                        <p class="stepper_p">Search and select orders to create packing slips. (At least one order is required.)</p>
                    </div>

                    <div class="row steps_div_row">

                        <div class="col-lg-12" style="padding-left: unset;">
                            <b class="stepper_b">Date Range Filter</b>
                        </div>

                        <div class="col-lg-4" style="padding-left: unset;">
                            <label for="filter" class="step_label">Start Date</label>
                            <div style="position: relative;">
                                <img src="{{asset('assets')}}/img/team_stores/calendar.png" style="width: 13px; position: absolute; left: 10px; top: 50%; transform: translateY(-50%);" />
                                <input type="text" name="start_date" value="{{ \Carbon\Carbon::parse($order_start_date)->format('m/d/Y') }}" class="form-control info_input date-picker" style="padding-left: 30px;">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <label for="shipping_method" class="step_label">End Date</label>
                            <div style="position: relative;">
                                <img src="{{asset('assets')}}/img/team_stores/calendar.png" style="width: 13px; position: absolute; left: 10px; top: 50%; transform: translateY(-50%);" />
                                <input type="text" name="end_date" value="{{ \Carbon\Carbon::parse($order_end_date)->format('m/d/Y') }}" class="form-control info_input date-picker" style="padding-left: 30px;">
                            </div>
                        </div>

                    </div>

                    <div class="row steps_div_row">

                        {{-- <div class="col-lg-4" style="padding-left: unset;">
                            <label for="label" class="step_label">Label</label>
                            <select name="label" id="label" class="select_box">
                                <option value="">Select Label</option>
                              </select>
                        </div> --}}

                        <div class="col-lg-4">
                            <label for="filter" class="step_label">Custom Data Filter</label>
                            <select name="filter" id="data_filter" class="select_box">
                                <option value="1" selected>Order Number (Ascending)</option>
                                <option value="2">Order Number (Descending)</option>
                                <option value="3">Order Date (Ascending)</option>
                                <option value="4">Order Date (Descending)</option>
                                <option value="5">Customer Name (Ascending)</option>
                              </select>
                        </div>

                        <div class="col-lg-4">
                            <label for="shipping_method" class="step_label">Shipping Method Filters</label>
                            <select name="shipping_method" id="shipping_method" class="select_box">
                                <option value="0" selected>All</option>
                                @if (isset($store->StoreAddedShippingMethods) && $store->StoreAddedShippingMethods->count() > 0)
                                    @foreach ($store->StoreAddedShippingMethods as $shippingMethod)
                                        <option value="{{ $shippingMethod->shippingMethod->id }}">{{ $shippingMethod->shippingMethod->shipping_method_name }}</option>
                                    @endforeach
                                @endif
                              </select>
                        </div>

                    </div>

                    <div class="row steps_div_row view-orders-btn" data-toggle="modal" data-target="#selectedOrdersModal" style="cursor:pointer;">
                        <div style="padding-right: 5px;">
                            <img src="{{asset('assets')}}/img/team_stores/list.png" style="width: 13px;" />
                        </div>
                        <p class="stepper_p" style="padding-top: 1px;">VIEW LIST OF SELECTED ORDERS <span id="filterd_order_count">(0)</span></p>
                    </div>
                </div>

                <div class="steps_div2" style="display: none;">
                    <div class="row steps_div_row">
                        <b class="stepper_b">STEP 2 - </b>
                        <p class="stepper_p">Customize packing slips (Optional)</p>
                    </div>

                    <div class="row steps_div_row">
                        <input type="checkbox" id="item_pic" name="item_pic" value="Item Pictures" style="margin-top: 2px;">
                        <label for="item_pic" class="total_qty_text" style="padding-left: 10px;"> Include Item Pictures In Packing Slips</label>
                    </div>
                    <div class="row steps_div_row">
                        <button class="add_message" data-toggle="modal" data-target="#customMessageModal">ADD CUSTOM MESSAGE </button>
                    </div>
                    <div class="row steps_div_row">
                        <b class="note_b">NOTE : </b>
                        <p class="note_p"> If you would like to edit your Disclaimer or Return and  Exchange Policy, Please visit our store template page in Dealer Settings. </p>
                    </div>
                </div>

                <div class="steps_div2">
                    <div class="row steps_div_row">
                        <b class="stepper_b">STEP 2 - </b>
                        <p class="stepper_p">Sort packing slips for download (Optional)</p>
                    </div>

                    <div class="row steps_div_row">
                        <div class="col-lg-12" style="padding-left: unset;">
                            <label for="custom_sort_for_slip" class="step_label">Custom Data Filter</label><br>
                        </div>

                        <div class="col-lg-4" style="padding-left: unset;">
                            <select name="custom_sort_for_slip" id="custom_sort_for_slip" class="select_box">
                                <option value="1" selected>Order Number (Ascending)</option>
                                <option value="2">Order Number (Descending)</option>
                                <option value="3">Order Date (Ascending)</option>
                                <option value="4">Order Date (Descending)</option>
                                <option value="5">Customer Name (Ascending)</option>
                            </select>
                        </div>
                        {{-- <div class="col-lg-4" style="padding-left: unset;">
                            <button class="add_secondary_btn">
                                <i class="fa fa-plus add_secondary"></i>
                                <b class="add_secondary"> ADD SECONDARY SORT FILTER </b>
                            </button>
                        </div> --}}
                    </div>

                </div>

                <div class="steps_div2">
                    <div class="row steps_div_row">
                        <b class="stepper_b">STEP 3 - </b>
                        <p class="stepper_p">Generate packing slips</p>
                    </div>

                    <div class="row steps_div_row">
                        <button class="download_pdf">DOWNLOAD PDF </button>
                        <button class="email_pdf">EMAIL PDF </button>
                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

<div class="modal fade" id="selectedOrdersModal" tabindex="-1" role="dialog" aria-labelledby="selectedOrdersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document"  style="max-width: 85rem">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="selectedOrdersModalLabel">Filtered Orders</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" style="overflow-x: scroll;">
                        <table class="table" id="selected_orders_table">
                            <thead>
                                <tr style="color: white;background-color: #4E4C4C;height: 35px;">
                                    <th></th>
                                    <th class="text-center" scope="col" style="padding-left: 10px;">ORDER NO</th>
                                    <th class="text-center" scope="col">CUSTOMER NAME</th>
                                    <th class="text-center" scope="col">ORDER TOTAL ($)</th>
                                    <th class="text-center" scope="col">PAID AMOUNT ($)</th>
                                    <th class="text-center" scope="col">ORDER DATE</th>
                                    <th class="text-center" scope="col">ENCR ORDER NO</th>
                                    <th class="text-center" scope="col">SHIPPING METHOD</th>
                                    <th class="text-center" scope="col">STATUS</th>
                                </tr>
                            </thead>
                            <tbody id="selected_orders_tbody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="customMessageModal" tabindex="-1" role="dialog" aria-labelledby="customMessageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="customMessageModalLabel">Add Custom Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <textarea id="customMessageInput" class="form-control" rows="5" placeholder="Type your message here..."></textarea>
      </div>
    </div>
  </div>
</div>



<script>
    $(document).ready(function() {
        $('.date-picker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
        loadOrders();
    });
    $(document).on('change', '#data_filter, #shipping_method', function() {
        loadOrders();
    });

    $(document).on('input change', '#start_date, #end_date', function() {
        loadOrders();
    });
    $(document).on('change', '#custom_sort_for_slip', function() {
        $('#step_2').addClass('completed');
    });
    function loadOrders(){
        $('.se-pre-con').fadeIn('slow');
        $.ajax({
            url: "{{ route('store.get_store_orders_for_packing_slip') }}",
            data: {
                start_date: $('input[name="start_date"]').val(),
                end_date: $('input[name="end_date"]').val(),
                filter_by: $('#data_filter').val(),
                shipping_method: $('#shipping_method').val(),
                store_id: "{{ $store->id }}",
            },
            type: "GET",
            success: function (response) {
                let tbody = $('#selected_orders_tbody');
                tbody.empty();

                var orderCount = 0;

                if (response.length === 0) {
                    tbody.append('<tr><td colspan="7" class="text-center">No orders found</td></tr>');
                } else {
                    response.forEach(function (order) {
                        let shippingMethod = order.shipping_method == 1 ? 'Direct Ship to Customers' :
                                            order.shipping_method == 2 ? 'Bulk Ship to Coach' :
                                            order.shipping_method == 3 ? 'Pick Up' : 'Other';

                        var isShippoOrderCreated = order.shippo_order_id ? true : false;

                        orderCount++;

                        let status = '<span class="badge" style="background-color:'+order.status_details.color+'">'+order.status_details.status_name+'</span>';

                        let row = `
                            <tr style="color: #4E4C4C; height: 35px;border-bottom: 1px solid #b3b3b3;">
                                <td style="width: 30px;">
                                    <input type="checkbox" class="order-checkbox-for-slips" value="${order.id}" checked/>
                                </td>
                                <td style="padding-left: 10px;" class="text-center">${order.order_no}</td>
                                <td class="text-center">${order.customer_details ? order.customer_details.first_name + ' ' + order.customer_details.last_name : '-'}</td>
                                <td class="text-center">${order.total ?? '-'}</td>
                                <td class="text-center">${order.paid_amount ?? '-'}</td>
                                <td class="text-center">${order.created_at ? moment(order.created_at).format('MM/DD/YYYY') : '-'}</td>
                                <td class="text-center">${order.system_order_no ?? 'Not Created'}</td>
                                <td class="text-center">${shippingMethod}</td>
                                <td class="text-center">${status}</td>
                            </tr>
                        `;
                        tbody.append(row);
                    });

                    $('#filterd_order_count').text('(' + orderCount + ')');
                }
                $('.se-pre-con').fadeOut('slow');
            },
            error: function () {
                console.error('Error fetching orders');
                $('#filterd_order_count').text('0');
                $('.se-pre-con').fadeOut('slow');
                $('#selected_orders_tbody').html('<tr><td colspan="7" class="text-center">Error fetching orders</td></tr>');
            }
        });
    }

    $(document).ready(function() {
        $('.download_pdf').on('click', function(e) {
            e.preventDefault();

            let orderIds = [];
            $('.order-checkbox-for-slips:checked').each(function() {
                orderIds.push($(this).val());
            });

            if (orderIds.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Orders Selected',
                    text: 'Please select at least one order to download the packing slips.',
                });
                return;
            }

            let customSort = $('#custom_sort_for_slip').val();

            Swal.fire({
                title: 'Download Options',
                text: 'How would you like to download the packing slips?',
                icon: 'question',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: 'All in One PDF',
                cancelButtonText: 'One By One PDFs'
            }).then((result) => {

                if (result.value || result.dismiss) {

                    let downloadMode = result.value == true ? 'merged' : 'separate';

                    Swal.fire({
                        title: 'Generating...',
                        html: 'Please wait while your packing slips are being prepared.',
                        didOpen: () => {
                            Swal.showLoading();
                        },
                        allowOutsideClick: false,
                    });

                    $('.se-pre-con').fadeIn('slow');
                    $('#step_2').addClass('completed');
                    $('#step_3').addClass('completed');

                    $.ajax({
                        url: "{{ route('shippo.download_packing_slips') }}",
                        method: 'GET',
                        data: {
                            order_ids: orderIds,
                            custom_sort: customSort,
                            download_mode: downloadMode
                        },
                        xhrFields: {
                            responseType: 'blob'
                        },
                        success: function(data, status, xhr) {
                            Swal.close();

                            let disposition = xhr.getResponseHeader('Content-Disposition');
                            let filename = 'packing_slips.pdf';

                            if (disposition && disposition.indexOf('filename=') !== -1) {
                                filename = disposition.split('filename=')[1].replace(/"/g, '');
                            }

                            let blob = new Blob([data], { type: xhr.getResponseHeader('Content-Type') });
                            let link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = filename;
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);

                            $('.se-pre-con').fadeOut('slow');
                        },
                        error: function(xhr) {
                            $('.se-pre-con').fadeOut('slow');
                            Swal.fire({
                                icon: 'error',
                                title: 'Download Failed',
                                text: xhr.responseText || 'Something went wrong while generating the packing slips.',
                            });
                        }
                    });

                }
            });

        });

    });

</script>

@endsection
@section('content')
    @include('pages.stores.layouts.sidebar', ['sub_content' => 'overview'])
@endsection
