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

/* ================= MODERN DATEPICKER ================= */
#ui-datepicker-div.ui-datepicker {
    width: 300px !important;
    padding: 14px !important;
    background: #fff !important;
    border: 1px solid #E2E8F0 !important;
    border-radius: 14px !important;
    box-shadow: 0 12px 32px rgba(15, 23, 42, 0.18) !important;
    font-family: 'Open Sans', sans-serif !important;
    z-index: 99999 !important;      /* above bootstrap modals */
}

/* ---------- Header ---------- */
#ui-datepicker-div .ui-datepicker-header {
    position: relative !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 4px 36px 12px !important;
    background: transparent !important;
    border: none !important;
}
#ui-datepicker-div .ui-datepicker-title {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
    width: 100% !important;
    margin: 0 !important;
    line-height: normal !important;
}

/* ---------- Month / Year selects ---------- */
#ui-datepicker-div .ui-datepicker-title select {
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    appearance: none !important;

    height: 34px !important;
    margin: 0 !important;
    padding: 0 28px 0 12px !important;

    font-family: 'Open Sans', sans-serif !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    color: #1E293B !important;

    background-color: #F8FAFC !important;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748B' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") !important;
    background-repeat: no-repeat !important;
    background-position: right 10px center !important;
    background-size: 12px !important;

    border: 1px solid #E2E8F0 !important;
    border-radius: 999px !important;
    outline: none !important;
    box-shadow: none !important;
    cursor: pointer;
    transition: background-color .15s, border-color .15s, box-shadow .15s;

    text-overflow: ellipsis;
    white-space: nowrap;
}
#ui-datepicker-div .ui-datepicker-title select:hover {
    background-color: #E6FAF6 !important;
    border-color: #47D6B6 !important;
    color: #0F766E !important;
}
#ui-datepicker-div .ui-datepicker-title select:focus {
    background-color: #fff !important;
    border-color: #47D6B6 !important;
    box-shadow: 0 0 0 3px rgba(71, 214, 182, .25) !important;
}
#ui-datepicker-div .ui-datepicker-title select.ui-datepicker-month { flex: 1 1 58% !important; width: auto !important; }
#ui-datepicker-div .ui-datepicker-title select.ui-datepicker-year  { flex: 1 1 42% !important; width: auto !important; }
#ui-datepicker-div .ui-datepicker-title select option {
    font-size: 14px;
    font-weight: 500;
    color: #1E293B;
    background: #fff;
    padding: 6px 10px;
}

/* ---------- Prev / Next arrows ---------- */
#ui-datepicker-div .ui-datepicker-prev,
#ui-datepicker-div .ui-datepicker-next {
    position: absolute !important;
    top: 2px !important;
    width: 30px !important;
    height: 30px !important;
    border: none !important;
    border-radius: 50% !important;
    background: transparent !important;
    cursor: pointer;
    transition: background .15s;
}
#ui-datepicker-div .ui-datepicker-prev { left: 0 !important; }
#ui-datepicker-div .ui-datepicker-next { right: 0 !important; }
#ui-datepicker-div .ui-datepicker-prev:hover,
#ui-datepicker-div .ui-datepicker-next:hover { background: #F1F5F9 !important; }
#ui-datepicker-div .ui-datepicker-prev span,
#ui-datepicker-div .ui-datepicker-next span { display: none !important; }
#ui-datepicker-div .ui-datepicker-prev::after,
#ui-datepicker-div .ui-datepicker-next::after {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    width: 7px;
    height: 7px;
    border-color: #475569;
    border-style: solid;
}
#ui-datepicker-div .ui-datepicker-prev::after {
    border-width: 0 0 2px 2px;
    transform: translate(-30%, -50%) rotate(45deg);
}
#ui-datepicker-div .ui-datepicker-next::after {
    border-width: 2px 2px 0 0;
    transform: translate(-70%, -50%) rotate(45deg);
}
#ui-datepicker-div .ui-datepicker-prev.ui-state-disabled,
#ui-datepicker-div .ui-datepicker-next.ui-state-disabled { opacity: .3; cursor: default; }

/* ---------- Calendar grid ---------- */
#ui-datepicker-div table.ui-datepicker-calendar {
    width: 100% !important;
    margin: 0 !important;
    border-collapse: separate !important;
    border-spacing: 2px !important;
}
#ui-datepicker-div .ui-datepicker-calendar th {
    padding: 6px 0 !important;
    font-size: 11px !important;
    font-weight: 600 !important;
    text-transform: uppercase;
    color: #94A3B8 !important;
    text-align: center !important;
    border: none !important;
    background: transparent !important;
}
#ui-datepicker-div .ui-datepicker-calendar th span { font-weight: 600 !important; }
#ui-datepicker-div .ui-datepicker-calendar td {
    padding: 0 !important;
    border: none !important;
    background: transparent !important;
}

/* ---------- Day cells ---------- */
#ui-datepicker-div .ui-datepicker-calendar td a,
#ui-datepicker-div .ui-datepicker-calendar td span {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 34px !important;
    height: 34px !important;
    margin: 0 auto !important;
    padding: 0 !important;
    font-size: 13px !important;
    font-weight: 500 !important;
    color: #1E293B !important;
    text-align: center !important;
    background: transparent !important;
    border: none !important;
    border-radius: 50% !important;
    transition: background .15s, color .15s;
}
#ui-datepicker-div .ui-datepicker-calendar td a:hover {
    background: #E6FAF6 !important;
    color: #0F766E !important;
}
/* days of other months */
#ui-datepicker-div .ui-datepicker-other-month a,
#ui-datepicker-div .ui-datepicker-other-month span { color: #CBD5E1 !important; }
/* today */
#ui-datepicker-div .ui-datepicker-today a,
#ui-datepicker-div td a.ui-state-highlight {
    background: #F1F5F9 !important;
    color: #0F766E !important;
    font-weight: 700 !important;
    box-shadow: inset 0 0 0 1.5px #47D6B6;
}
/* selected day */
#ui-datepicker-div td a.ui-state-active,
#ui-datepicker-div .ui-datepicker-current-day a {
    background: #47D6B6 !important;
    color: #fff !important;
    font-weight: 700 !important;
    box-shadow: 0 2px 6px rgba(71, 214, 182, .45);
}
/* disabled days */
#ui-datepicker-div .ui-state-disabled span { color: #E2E8F0 !important; }

/* ---------- Button panel (only if showButtonPanel is enabled) ---------- */
#ui-datepicker-div .ui-datepicker-buttonpane {
    margin: 8px 0 0 !important;
    padding: 8px 0 0 !important;
    border: none !important;
    border-top: 1px solid #F1F5F9 !important;
    background: transparent !important;
}
#ui-datepicker-div .ui-datepicker-buttonpane button {
    padding: 5px 12px !important;
    font-size: 12px !important;
    color: #475569 !important;
    background: #F1F5F9 !important;
    border: none !important;
    border-radius: 8px !important;
    opacity: 1 !important;
}

/* ---------- Small screens ---------- */
@media (max-width: 480px) {
    #ui-datepicker-div.ui-datepicker { width: 280px !important; padding: 10px !important; }
    #ui-datepicker-div .ui-datepicker-calendar td a,
    #ui-datepicker-div .ui-datepicker-calendar td span { width: 32px !important; height: 32px !important; }
    #ui-datepicker-div .ui-datepicker-title select { font-size: 16px !important; height: 36px !important; }
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
    $.datepicker.setDefaults({
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        selectOtherMonths: true,
        yearRange: 'c-10:c+10',
        prevText: '',
        nextText: ''
    });

    // also update any pickers that were already initialized
    $(function () {
        $('.hasDatepicker').datepicker('option', {
            changeMonth: true,
            changeYear: true,
            yearRange: 'c-10:c+10'
        });
    });
    // Calendar only: no keyboard on tap
    $(function () {
        function lockDatepickerInputs() {
            $('.hasDatepicker, .summary-datepicker, .modal-datepicker, .item-datepicker')
                .attr('readonly', true)
                .attr('inputmode', 'none')
                .css('background-color', function () {
                    // keep the input looking normal (readonly can turn it grey)
                    return $(this).css('background-color');
                });
        }

        lockDatepickerInputs();

        // inputs inside modals / created later
        $(document).on('focus click', '.hasDatepicker, .summary-datepicker, .modal-datepicker, .item-datepicker', function () {
            $(this).attr('readonly', true).attr('inputmode', 'none');
        });
        $('.modal').on('shown.bs.modal', lockDatepickerInputs);
    });
</script>

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

