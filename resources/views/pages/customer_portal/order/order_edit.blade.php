@extends('pages.customer_portal.layouts.sidebar', ['sub_active' => 'orders'])

@section('sub-sidebar-content')

<style>
    .no-spinner::-webkit-inner-spin-button,
    .no-spinner::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }

    .no-spinner {
    -moz-appearance: textfield;
    }
   .list_item_set {
    position: relative;
    overflow: hidden;
}

.list_item_set::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 4px;
    height: 100%;
    background: #198754;
    transform: scaleY(0);
    transform-origin: top;
    transition: transform 0.25s ease;
}

.list_item_set.active::before {
    transform: scaleY(1);
}
#detailsContainer {
    transition: opacity 0.2s ease;
}

#detailsContainer.loading {
    opacity: 0.4;
}

    @media (max-width: 767px) {
        .mobile-card-table {
            border: 0 !important;
            background: transparent !important;
        }

        .mobile-card-table thead {
            display: none;
        }

        .mobile-card-table tbody,
        .mobile-card-table tr,
        .mobile-card-table td {
            display: block;
            width: 100%;
        }

        .mobile-card-table tr {
            background: #ffffff;
            color: #000000;
            border: 1px solid #ddd;
            border-radius: 12px;
            margin-bottom: 12px;
            padding: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .mobile-card-table td {
            border: 0 !important;
            padding: 8px 0 !important;
            text-align: left !important;
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: flex-start;
        }

        .mobile-card-table td::before {
            content: attr(data-label);
            font-weight: 700;
            color: #555;
            min-width: 90px;
            flex-shrink: 0;
        }

        .mobile-card-table td p {
            margin-bottom: 0;
            text-align: right;
        }

        .mobile-card-table .view-file-btn {
            padding: 4px 10px;
            font-size: 12px;
            white-space: nowrap;
        }

        .mobile-card-table td:first-child {
            display: block;
            border-bottom: 1px solid #eee !important;
            padding-bottom: 10px !important;
            margin-bottom: 6px;
        }

        .mobile-card-table td:first-child::before {
            display: block;
            margin-bottom: 4px;
        }

        .mobile-card-table td:first-child p {
            text-align: left;
        }
    }
    .order-view-row {
        align-items: stretch;
    }

    .order-view-row {
        align-items: stretch;
    }

    .order-left-card {
        max-height: calc(100vh - 130px);
        overflow: hidden;
    }

    .order-left-card-body {
        display: flex;
        flex-direction: column;
        overflow: hidden;
        height: 100%;
    }

    .order-view-row {
        display: flex;
        align-items: stretch;
    }

    .order-left-col {
        align-self: stretch;
    }

    .order-left-card {
        height: 100%;
        min-height: 100%;
        overflow: hidden;
    }

    .order-left-card-body {
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .order-items-scroll {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        padding-right: 6px;
    }

    /* scrollbar */
    .order-items-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .order-items-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .order-items-scroll::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .order-items-scroll::-webkit-scrollbar-thumb:hover {
        background: #999;
    }

    @media (max-width: 991px) {
        .order-view-row {
            display: block;
        }

        .order-left-card {
            height: auto;
            max-height: 420px;
        }

        .order-items-scroll {
            max-height: 320px;
            overflow-y: auto;
        }
    }
@media (max-width: 768px) {
    .mobile_bc_none {
        background-color: transparent;
    }
    .mobile_margin_bottom_unset {
        margin-bottom: unset !important;
    }
    .mobile_padding_unset {
        padding: unset !important;
    }
    .page-breadcrumb.d-none.d-sm-flex {
        display: flex !important;
    }
}


</style>
<!--breadcrumb-->
				<div class="page-breadcrumb d-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">
                        <a href="{{ route('customer_portal.dashboard') }}"
                        class="text-decoration-none"
                        style="color: unset;">
                            HOME
                        </a>
                    </div>

                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript:;">
                                        <i class="bx bx-home-alt"></i>
                                    </a>
                                </li>

                                <li class="breadcrumb-item active" aria-current="page">
                                    Order Details
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="ms-auto">
                        <div class="btn-group">
                        </div>
                    </div>
                </div>
				<!--end breadcrumb-->


 <form id="orderform" method="POST" action="{{ route('customer_portal.roster_update') }}" >
    @csrf
        <div class="card">
          <div class="card-body">
              <div class="d-flex flex-lg-row flex-column align-items-start align-items-lg-center justify-content-between gap-3">
                 <div class="flex-grow-1">
                   <h4 class="fw-bold">Order #{{ $order->id }}</h4>
                   <p class="mb-0">Organization : <a href="javascript:;">{{ $order->organizationDetails->organization_name ?? 'N/A' }}</a></p>
                 </div>
                 {{-- <div class="overflow-auto">
                  <div class="btn-group position-static">
                    <div class="btn-group position-static">
                      <button type="button" class="btn btn-outline-primary">
                        <i class="bi bi-printer-fill me-2"></i>Print
                      </button>
                    </div>
                    <div class="btn-group position-static">
                      <button type="button" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-clockwise me-2"></i>Refund
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                        <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                      </ul>
                    </div>
                    <div class="btn-group position-static">
                      <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        More Actions
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                        <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                      </ul>
                    </div>
                  </div>
                </div> --}}
              </div>
          </div>
        </div>

        <div class="row order-view-row">
            <div class="col-12 col-lg-3 d-flex mb-4 order-left-col">
                <div class="card w-100 order-left-card mobile_margin_bottom_unset">
                    <div class="card-body order-left-card-body">

                        <div role="button"
                            class="card border list_item_set order-tab active activetabview"
                            id="orderDetailsTab">
                            <div class="card-body">
                                Order Details
                            </div>
                        </div>

                        <div class="order-items-scroll">
                            @foreach ($order->orderItems as $item)
                                <div class="card order-item-tab border list_item_set order-tab activetabview"
                                    role="button"
                                    data-item-id="{{ $item->id }}"
                                    data-order-id="{{ $item->order_id }}">
                                    <div class="card-body">
                                        {{ $item->display_name ?? $item->subProduct->product_name }} - {{ $item->item_description }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-9 mb-4" id="detailsContainer">
                @include('pages.customer_portal.order.includes.order_detail', [
                    'order' => $order,
                    'contacts' => $contacts
                ])
            </div>
        </div>
         <div class="row">
            <div class="col-12 col-lg-12 d-flex mb-4 flex-column" id="extraDetailsContainer">

            </div>
        </div>
    </form>

<script>
$(document).ready(function () {
    initPlayerNumberRoster(document);
});

function initPlayerNumberRoster(container) {
    const scope = container ? $(container) : $(document);

    scope.find('.player-number-table').each(function () {
        const firstInput = $(this).find('input[class*="num-input-count-"]').first();

        if (!firstInput.length) {
            return;
        }

        const classList = firstInput.attr('class').split(/\s+/);

        const detailClass = classList.find(function (cls) {
            return cls.indexOf('num-input-count-') === 0;
        });

        if (!detailClass) {
            return;
        }

        const OrderDetailId = detailClass.replace('num-input-count-', '');

        updatePlayerNumberRows(OrderDetailId);
    });
}

 function NumberQtyCountUpdate(OrderDetailId, itemId) {
    const numQtyTotalCount = $('.num-input-count-' + OrderDetailId).filter(function () {
        return $(this).val().trim() !== '';
    }).length;

    $('#num-total-count-' + OrderDetailId).val(numQtyTotalCount);

    updatePlayerNumberRows(OrderDetailId);

    updateNumQty(itemId);
}

function updatePlayerNumberRows(OrderDetailId) {
    const rows = $('.player-number-row-' + OrderDetailId);

    rows.each(function (index) {
        const row = $(this);

        // First 2 rows always show
        if (index < 2) {
            row.removeClass('roster-row-hidden');
            return;
        }

        const previousRow = rows.eq(index - 1);

        // Show this row only if:
        // 1. This row has saved/filled values
        // 2. Previous row is fully filled
        if (isPlayerNumberRowHasValue(row) || isPlayerNumberRowFilled(previousRow)) {
            row.removeClass('roster-row-hidden');
        } else {
            row.addClass('roster-row-hidden');
        }
    });
}

function isPlayerNumberRowFilled(row) {
    const inputs = row.find('input');

    if (!inputs.length) {
        return false;
    }

    const filledCount = inputs.filter(function () {
        return $(this).val().trim() !== '';
    }).length;

    return filledCount === inputs.length;
}

function isPlayerNumberRowHasValue(row) {
    const inputs = row.find('input');

    if (!inputs.length) {
        return false;
    }

    return inputs.filter(function () {
        return $(this).val().trim() !== '';
    }).length > 0;
}

       // Use event delegation on a static parent (like document or a container)
        document.addEventListener('click', function (e) {
            // Check if the clicked element has the class 'view-file-btn'
            if (e.target && e.target.classList.contains('view-file-btn')) {

                var file = e.target.dataset.file;
                console.log('Button clicked');

                if (!file) {
                    Swal.fire('No File Found', 'This file is not available yet', 'warning');
                    return;
                }

                try {
                    window.open(file, '_blank');
                } catch (err) {
                    Swal.fire('Error', 'Unable to open file', 'error');
                }
            }
        });





    function limitDigits(el, maxLength) {
            if (el.value.length > maxLength) {
                el.value = el.value.slice(0, maxLength);
            }
        }

    function updateBlankQty(itemId){
        var sum = 0;
        $('.blank-qty-'+itemId).each(function() {
            sum += parseFloat($(this).val()) || 0;
        });
        $('#blank-qty-total-'+itemId).val(sum);
    }
    function updateNumQty(itemId){

        var sum = 0;
        $('.num-sum-count-total-' + itemId + ' input').each(function() {
            var value = parseFloat($(this).val());
            if (!isNaN(value)) {
                sum += value;
            }
        });

        $('#num-sum-qty-total-'+itemId).val(sum);
    }
    function submitOrderForm() {
        document.getElementById('orderform').submit();
    }
    document.getElementById("approve-btn").addEventListener("click", function() {
        let orderId = this.getAttribute("data-order_id");
        Swal.fire({
            title: "Are you sure?",
            text: "Thoroughly review the tech pack, order roster, shipping details, and all relevant aspects before approving for production.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#28a745",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Approve",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.value) {
                // Get PC Name (hostname)
                let pcName = window.location.hostname;

                // Fetch IP address using an external API
                fetch('https://api64.ipify.org?format=json')
                    .then(response => response.json())
                    .then(data => {
                        let ipAddress = data.ip;

                        // Send AJAX request to Laravel backend
                        fetch("{{ route('approve.production') }}", {
                            method: "POST",
                            headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                ip_address: ipAddress,
                                order_id: orderId
                            })
                        })


                        .then(response => {
                            if (!response.ok) {
                                // If the response is not OK (e.g., 400, 403), handle the error
                                return response.json().then(errorData => {
                                    // Check if there's an error message from the server
                                    throw new Error(errorData.message || "Something went wrong");
                                });
                            }
                            return response.json(); // If the response is OK, continue with the data
                        })

                        .then(result => {
                            Swal.fire("Approved!", "Order has been approved for production.", "success");
                            document.getElementById("approve-btn").disabled = true;
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            Swal.fire("Error!", "Failed to approve.", "error");
                        });
                    })
                    .catch(error => console.error("Error fetching IP:", error));
            }
        });
    });
    function PlayerNameTabBarOptions(tab, button ,id){
        $('.player-name-tab_'+id).hide();
        $('.'+tab).show();
        $('.player-name-tab-button_'+id).removeClass('active');
        $(button).addClass('active');
    }
$(document).ready(function () {


    function updateBlankQty(itemId){
        var sum = 0;
        $('.blank-qty-'+itemId).each(function() {
            sum += parseFloat($(this).val()) || 0;
        });
        $('#blank-qty-total-'+itemId).val(sum);
    }
    // Show Order Details
    // $('#orderDetailsTab').on('click', function (e) {
    //     e.preventDefault();
    //     $('.list_item_set').removeClass('active');
    //     $(this).addClass('active');

    //     $.ajax({
    //         url: "{{ route('orders.showDetails', $order->id) }}",
    //         type: 'GET',
    //         success: function (response) {
    //             $('#extraDetailsContainer').empty();
    //             $('#detailsContainer').html(response);
    //         }
    //     });
    // });

    // Show Order Item Details
    // $('.order-item-tab').on('click', function (e) {
    //     e.preventDefault();

    //     $('.list_item_set').removeClass('active');
    //     $(this).addClass('active');

    //     const itemId = $(this).data('item-id');
    //     const orderId = $(this).data('order-id');

    //     $.ajax({
    //         url: "{{ route('orders.itemDetails') }}",
    //         type: 'GET',
    //         data: {
    //             item_id: itemId,
    //             orderId: orderId
    //         },
    //         success: function (response) {
    //             // $('#detailsContainer').html(response);
    //             const html = $('<div>').html(response);

    //             // Fill main section
    //             $('#detailsContainer').html(html.find('#mainDetails').html());

    //             // Fill extra section (2nd row)
    //             $('#extraDetailsContainer').empty();
    //             $('#extraDetailsContainer').html(html.find('#extraDetails').html());
    //         }
    //     });
    // });
    $(document).on('click', '.order-tab', function (e) {
        e.preventDefault();

        $('#detailsContainer').addClass('loading');

        let itemId = $(this).data('item-id');
        let orderId = $(this).data('order-id');

        // Remove active from all order tabs
        $('.order-tab').removeClass('active');

        if (!itemId) {
            // Active Order Details tab
            $('#orderDetailsTab').addClass('active');

            $.get("{{ route('orders.showDetails', $order->id) }}", function (response) {
                $('#extraDetailsContainer').empty();
                $('#detailsContainer').removeClass('loading');
                $('#detailsContainer').html(response);

            });
            return;
        }

        // Add active to clicked item AND matching card/table item
        $('.order-tab[data-item-id="' + itemId + '"]').addClass('active');

        $.get("{{ route('orders.itemDetails') }}", {
            item_id: itemId,
            orderId: orderId
        }, function (response) {
            const html = $('<div>').html(response);

            $('#detailsContainer').removeClass('loading');
            $('#detailsContainer').html(html.find('#mainDetails').html());
            $('#extraDetailsContainer').html(html.find('#extraDetails').html());
            initPlayerNumberRoster('#extraDetailsContainer');
        });
    });


});
</script>

@endsection
