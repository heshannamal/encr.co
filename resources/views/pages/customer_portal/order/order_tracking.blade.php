@extends('pages.customer_portal.layouts.sidebar', ['sub_active' => 'orders'])

@section('sub-sidebar-content')
<style>
.hh-grayBox {
	background-color: #F8F8F8;
	margin-bottom: 20px;
	padding: 35px;
  margin-top: 20px;
}
#Order_number_link:hover {
    background-color: #f1f5f9;
}

.pt45{padding-top:45px;}
.order-tracking{
	text-align: center;
	width: 25%;
	position: relative;
	display: block;
}
.order-tracking .is-complete{
	display: block;
	position: relative;
	border-radius: 50%;
	height: 30px;
	width: 30px;
	border: 0px solid #AFAFAF;
	background-color: #cecece;
	margin: 0 auto;
	transition: background 0.25s linear;
	-webkit-transition: background 0.25s linear;
	z-index: 2;
}
.order-tracking .is-complete:after {
	display: block;
	position: absolute;
	content: '';
	height: 14px;
	width: 7px;
	top: -2px;
	bottom: 0;
	left: 5px;
	margin: auto 0;
	border: 0px solid #AFAFAF;
	border-width: 0px 2px 2px 0;
	transform: rotate(45deg);
	opacity: 0;
}
.order-tracking.completed .is-complete{
	border-color: #27aa80;
	border-width: 0px;
	background-color: #27aa80;
}
.order-tracking.completed .is-complete:after {
	border-color: #fff;
	border-width: 0px 3px 3px 0;
	width: 7px;
	left: 11px;
	opacity: 1;
}
.order-tracking p {
	color: #A4A4A4;
	font-size: 16px;
	margin-top: 8px;
	margin-bottom: 0;
	line-height: 20px;
}
.order-tracking p span{font-size: 14px;}
.order-tracking.completed p{color: #ffffff;}
.order-tracking::before {
	content: '';
	display: block;
	height: 3px;
	width: calc(100% - 40px);
	background-color: #cecece;
	top: 13px;
	position: absolute;
	left: calc(-50% + 20px);
	z-index: 0;
}
.order-tracking:first-child:before{display: none;}
.order-tracking.completed:before{background-color: #27aa80;}
/* ===== MOBILE RESPONSIVE FIX ===== */
@media (max-width: 768px) {
    .order-tracking {
        width: 100%;
        text-align: left;
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    /* Remove connecting horizontal line */
    .order-tracking::before {
        display: none;
    }

    /* Dot on the left instead of top center */
    .order-tracking .is-complete {
        margin: 0 15px 0 0;
        height: 20px;
        width: 20px;
    }
    .order-tracking.completed .is-complete:after {
	border-color: #fff;
	border-width: 0px 3px 3px 0;
	width: 5px;
	left: 8px;
	opacity: 1;
}

    /* Label next to the dot */
    .order-tracking p {
        margin: 0;
        font-size: 15px;
        color: #333;
    }

    /* Optional — add vertical line between steps */
    .order-tracking:not(:last-child) {
        position: relative;
    }
    .order-tracking:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 9px;
        top: 25px;
        width: 2px;
        height: 20px;
        background-color: #cecece;
    }
    .order-tracking.completed:not(:last-child)::after {
        background-color: #27aa80;
    }

    table#shipment_table thead {
        display: none;
    }

    table#shipment_table,
    table#shipment_table tbody,
    table#shipment_table tr,
    table#shipment_table td {
        display: block;
        width: 100%;
    }

    table#shipment_table tr {
        border: 1px solid #dee2e6;
        border-radius: 12px;
        padding: 12px;
        margin-bottom: 15px;
        background: #fff;
    }

    table#shipment_table td {
        text-align: left;
        padding: 8px 10px;
        border: none;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    /* Label */
    table#shipment_table td::before {
        content: attr(data-label);
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 3px;
        font-weight: 500;
    }

    /* FULL WIDTH BUTTON */
    table#shipment_table td button,
    table#shipment_table td a {
        width: 100%;
    }
}
#shipmentModalBody table {
    width: 100%;
    border-collapse: collapse;
}

#shipmentModalBody table th,
#shipmentModalBody table td {
    padding: 0.8rem 0.5rem;
    font-size: 14px;
}

/* MOBILE STYLING */
@media (max-width: 768px) {
    /* Stack table elements */
    #shipmentModalBody table,
    #shipmentModalBody thead,
    #shipmentModalBody tbody,
    #shipmentModalBody tfoot,
    #shipmentModalBody tr,
    #shipmentModalBody td {
        display: block;
        width: 100%;
    }

    #shipmentModalBody thead {
        display: none; /* Hide headers on mobile */
    }

    #shipmentModalBody tr {
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }

    /* Standard cell layout: Label on left, Value on right */
    #shipmentModalBody td {
        text-align: right;
        padding-left: 50% !important;
        position: relative;
        border: none !important;
    }

    #shipmentModalBody td::before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        width: 45%;
        text-align: left;
        font-weight: 700;
        color: #666;
    }

    /* FIX: FULL WIDTH TOTAL ROW */
    #shipmentModalBody tfoot tr.total-row td.desktop-td {
        display: none !important;
    }

    #shipmentModalBody tfoot tr.total-row td.mobile-td {
        display: block !important;
        width: 100% !important;
        padding-left: 0 !important; /* Remove the 50% gap */
        text-align: center !important; /* Center the text */
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6 !important;
        padding: 15px 0 !important;
    }

    /* Ensure no label appears before the Total text */
    #shipmentModalBody tfoot tr.total-row td.mobile-td::before {
        content: none !important;
    }
}
/* ===== MOBILE RESPONSIVE FIX ===== */
@media (max-width: 768px) {
    .order-tracking {
        width: 100%;
        text-align: left;
        display: flex;
        align-items: center;
        margin-bottom: 15px; /* Spacing between steps */
        padding-left: 10px;
    }

    /* Remove connecting horizontal line from desktop */
    .order-tracking::before {
        display: none !important;
    }

    /* Dot on the left instead of top center */
    .order-tracking .is-complete {
        margin: 0 15px 0 0 !important; /* Forces margin to the right of the dot */
        flex-shrink: 0;
        height: 25px;
        width: 25px;
    }

    /* Center the checkmark inside the smaller dot */
    .order-tracking.completed .is-complete:after {
        left: 9px;
        top: 3px;
        width: 6px;
        height: 11px;
    }

    /* Label next to the dot */
    .order-tracking p {
        margin: 0;
        font-size: 15px;
        color: #6c757d; /* Muted color for incomplete */
        text-align: left;
    }

    /* Green text for completed steps */
    .order-tracking.completed p {
        color: #27aa80 !important;
        font-weight: 600;
    }

    /* Vertical line between steps */
    .order-tracking:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 22px; /* Centers under the 25px dot */
        top: 25px;
        width: 2px;
        height: 20px;
        background-color: #cecece;
        z-index: 1;
    }

    /* Green vertical line if the current step is completed */
    .order-tracking.completed:not(:last-child)::after {
        background-color: #27aa80;
    }
}
.search-btn {
    width: 48px;
    flex-shrink: 0;
    border-radius: 50px;
    min-width: 60px;
}
.order-visit-icon {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #60a5fa; /* light blue */
    font-size: 14px;
}

#Order_number_link:hover .order-visit-icon {
    color: #3b82f6; /* slightly darker on hover */
}





</style>
<!--breadcrumb-->
<div class="row">

    <div class="col page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3"><a href="{{ route('customer_portal.dashboard') }}" class="text-decoration-none" style="color: unset;"> HOME</a></div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0" id="orderBreadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Order Tracking</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-2 col-lg-3 search-bar flex-grow-1 ">
        <div class="position-relative">
            <div class="col-12 search-bar flex-grow-1">
                    <div class="d-flex gap-2">

                        <!-- Search input -->
                        <div class="position-relative flex-grow-1">
                            <input
                                class="form-control rounded-5 px-5"
                                id="dashboard_order_tracking_search"
                                type="text"
                                placeholder="Enter your Order Number">

                            <span class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50 text-muted">
                                search
                            </span>
                        </div>

                        <!-- Round button -->
                        <button
                            class="btn btn-success  d-flex align-items-center justify-content-center search-btn"
                            id="dashboard_order_tracking_btn"
                            type="button">
                            Find
                        </button>

                    </div>
                </div>

        </div>
    </div>
</div>
<!--end breadcrumb-->
{{-- <div class="row ">
    <div class="col-12 col-lg-12 d-flex mb-4">
        <div class="card mt-4 w-100">
            <div class="card-body">
                <div class="search-bar flex-grow-1">
                    <div class="position-relative">
                        <input class="form-control rounded-5 px-5"
                            id="order_tracking_search"
                            type="text"
                            placeholder="Enter your Order Number">

                        <span class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50">
                            search
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="row" id="order_shipping_details_tab" style="display: none">
    <div class="col-12 col-lg-12 d-flex mb-4">
        <div class="mt-4 w-100">
            <div class="">
                {{-- <h6>Order Details</h6> --}}
                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-md-12 pb20 ">
							<div class="row justify-content-between" id="order_tracking_steps">
                                 <div class="order-tracking" data-status-id="1">
                                    <span class="is-complete"></span> Quote
                                </div>
                                <div class="order-tracking" data-status-id="3">
                                    <span class="is-complete"></span> Production
                                </div>
                                <div class="order-tracking" data-status-id="6">
                                    <span class="is-complete"></span> Shipped
                                </div>
                                <div class="order-tracking" data-status-id="4">
                                    <span class="is-complete"></span> Fulfilled
                                </div>
							</div>
						</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Order Details Section (initially hidden) -->
<div class="row" id="order_details_tab" style="display: none">
    <div class="col-12 col-lg-4 d-flex mb-4">
        <div class="card mt-4 w-100">
            <div class="card-body">
                <h6>Order Information</h6>
                <div class="col-md-12 mb-2">
                    <label class="form-label">Order Number</label>
                    <a href="javascript:void(0)"
                        id="Order_number_link"
                        class="form-control position-relative d-flex align-items-center text-decoration-none"
                        target="_blank"
                        style="cursor:pointer;">

                            <span id="Order_number_text">N/A</span>

                            <i class="bi bi-box-arrow-up-right order-visit-icon"></i>
                        </a>
                </div>
                <div class="col-md-12 mb-2">
                    <label class="form-label">Open date</label>
                    <input type="text" class="form-control" id="pickup_date" readonly>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Est Delivery date</label>
                    <input type="text" class="form-control" id="delivery_date" readonly>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4 d-flex mb-4 cc">
        <div class="card mt-4 w-100">
            <div class="card-body">
                <h6>Address Details</h6>

                <div class="col-md-12">
                    <label class="form-label">Shipping address</label>
                    <textarea class="form-control" id="shipping_address" rows="5" readonly></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4 d-flex mb-4">
        <div class="card mt-4 w-100">
            <div class="card-body">
                <h6>Customer Information</h6>
                <div class="col-md-12 mb-2">
                    <label class="form-label">Customer Name</label>
                    <input type="text" class="form-control" id="customer_name" readonly>
                </div>
                <div class="col-md-12 mb-2">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="customer_phone" readonly>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" id="customer_email" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-12 d-flex mb-4">
        <div class="card mt-4 w-100">
            <div class="card-body">
                <h6>Shipment Details</h6>
                <!-- Shipments will be injected here -->
                <div class="table-responsive">
                <table class="table table-bordered align-middle text-center" id="shipment_table">
                    <thead class="table-light">
                        <tr>
                            <th>Shipment</th>
                            <th>Courier Service</th>
                            <th>Tracking No</th>
                            <th>Tracking Link</th>
                            <th>Mark as Received</th>
                            <th>Inquiry</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody id="shipment_container">
                        <!-- rows injected here -->
                    </tbody>
                </table>
            </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="enquiryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <input type="hidden" id="tracking_no">
            <input type="hidden" id="courier">
            <input type="hidden" id="tracking_link">
            <input type="hidden" id="order_id">
            <input type="hidden" id="order_no">
            <div class="modal-header">
                <h5 class="modal-title">Shipment Inquiry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="enquiry_shipment_id">

                <div class="mb-3 text-start">
                    <label class="form-label">Your Message</label>
                    {{-- <!-- Toolbar -->
                    <div id="enquiry-toolbar">
                        <span class="ql-formats">
                            <button class="ql-bold"></button>
                            <button class="ql-italic"></button>
                            <button class="ql-underline"></button>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-list" value="ordered"></button>
                            <button class="ql-list" value="bullet"></button>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-link"></button>
                        </span>
                    </div> --}}

                    <!-- Editor -->
                    <div id="enquiry-editor" style="height: 150px;"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button class="btn btn-primary" id="sendEnquiryBtn">
                    Send Inquiry
                </button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="shipmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Shipment Summary</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="shipmentModalBody">
                <div class="text-center py-5">
                    <div class="spinner-border"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
document.addEventListener('click', function (e) {

    let btn = e.target.closest('.mark-received-btn');
    if (!btn) return;

    let shipmentId = btn.dataset.shipmentid;

    Swal.fire({
        title: 'Confirm',
        text: 'Have you received this shipment?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Received',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (!result.isConfirmed) return;

        btn.disabled = true;
        btn.innerText = 'Processing...';

        fetch("{{route('customer.markAsReceived')}}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                tracking_no: shipmentId
            })
        })
        .then(res => res.json())
        .then(res => {

            if (res.success) {
                Swal.fire('Success', 'Shipment marked as received', 'success');

                // ✅ Update UI
                btn.innerText = 'Received';
                btn.classList.remove('btn-success');
                btn.classList.add('btn-secondary');
                btn.disabled = true;

            } else {
                Swal.fire('Error', res.message || 'Something went wrong', 'error');
                btn.disabled = false;
                btn.innerText = 'Mark as Received';
            }
        })
        .catch(() => {
            Swal.fire('Error', 'Network error', 'error');
            btn.disabled = false;
            btn.innerText = 'Mark as Received';
        });

    });
});

let enquiryQuill;

document.addEventListener('DOMContentLoaded', function () {
    enquiryQuill = new Quill('#enquiry-editor', {
        theme: 'snow',
        placeholder: 'Type your enquiry here...',
        modules: {
            toolbar: [
                [{ font: [] }, { size: [] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ color: [] }, { background: [] }],
                [{ list: 'ordered' }, { list: 'bullet' }],
                [{ align: [] }],
                ['link'],   // ✅ image enabled
                ['clean']
            ]
        }
    });
});
$(document).ready(function () {
    const paramsurl = new URLSearchParams(window.location.search);
    const orderNofromurl = paramsurl.get('order');

    if (orderNofromurl) {
        $('#order_tracking_search').val(orderNofromurl);
        searchOrder(orderNofromurl);

        // ✅ Remove order param from URL (no reload)
        const cleanUrl = window.location.origin + window.location.pathname;
        window.history.replaceState({}, document.title, cleanUrl);
    }


// Button click
$('#dashboard_order_tracking_btn').on('click', function () {
    const orderNo = $('#dashboard_order_tracking_search').val().trim();
    if (!orderNo) return;
    searchOrder(orderNo);
});

    function searchOrder(orderNumber) {

    if (!orderNumber) {
        Swal.fire('Please enter your order number');
        return;
    }

    $.ajax({
        url: "{{ route('orders.get_order_tracking') }}",
        method: 'GET',
        data: { order_number: orderNumber },
        beforeSend: function () {
            Swal.fire({
                title: 'Searching...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        },
        success: function (response) {
            Swal.close();

            if (response.success) {
                $('#pickup_date').val(response.order_details.open_date ?? 'N/A');

                $('#delivery_date').val(response.order_details.est_delivery_date ?? 'N/A');
                $('#shipping_address').val(response.shippingAddress ?? 'N/A');
                $('#customer_name').val(response.order_details.contact_details.first_name ?? 'N/A');
                $('#customer_phone').val(response.order_details.contact_details.phone_no ?? 'N/A');
                $('#customer_email').val(response.order_details.contact_details.email ?? 'N/A');
                if (response.order_details?.order_no && response.order_details?.id) {
                    $('#Order_number_text').text(response.order_details.order_no);
                    $('#Order_number_link')
                    .attr(
                        'href',
                        "{{ route('customer_portal.order_view', ':id') }}".replace(
                            ':id',
                            response.order_details.id
                        )
                    );

                } else {
                    $('#Order_number_link')
                        .text('N/A')
                        .attr('href', 'javascript:void(0)');
                }

                updateOrderTracking(response.order_details.order_status_id);
                renderShipments(
                    response.shipping_tracking,
                    response.order_details.id,
                    response.order_details.order_no
                );

                $('#order_details_tab').slideDown();
                $('#order_shipping_details_tab').slideDown();


            } else {
                $('#order_details_tab, #order_shipping_details_tab').hide();
                Swal.fire('Order does not exist', 'No order found for that number', 'warning');
            }
        },
        error: function (xhr) {
            Swal.close();

            let message = xhr.responseJSON?.message || 'Something went wrong';

            if (xhr.status === 404) {
                Swal.fire('Not Found', message, 'warning');
            } else if (xhr.status === 403) {
                Swal.fire('Access Denied', message, 'error');
            } else {
                Swal.fire('Error', message, 'error');
            }

            $('#order_details_tab, #order_shipping_details_tab').hide();
        }
    });
}
$('#order_tracking_search').on('keypress', function (e) {
    if (e.which === 13) {
        e.preventDefault();
        searchOrder($(this).val().trim());
    }
});

  function renderShipments(shipments, order_id, order_no) {
    const container = $('#shipment_container');
    container.empty();

    // No shipments
    if (!shipments || shipments.length === 0) {
        container.append(`
            <tr>
                <td colspan="6">
                    <div class="alert alert-secondary mb-0">
                        Shipment details not available (N/A)
                    </div>
                </td>
            </tr>
        `);
        return;
    }

    shipments.forEach((shipment, index) => {
        const trackingLink = shipment.tracking_link
            ? `<a class="btn btn-primary btn-sm" href="${shipment.tracking_link}" target="_blank">Track</a>`
            : 'N/A';

        // ✅ Check if already received
        var isReceived = shipment.customer_received ? true : false;
        console.log(shipment.customer_received );

        var btnClass = isReceived ? 'btn-secondary' : 'btn-success';
        var btnText = isReceived ? 'Received' : 'Mark Received';
        var btnDisabled = isReceived ? 'disabled' : '';

        container.append(`
            <tr>
                <td data-label="Shipment" >Shipment ${index + 1}</td>

                <td data-label="Courier Service" >${shipment.CourierService ?? 'N/A'}</td>

                <td data-label="Tracking No" >${shipment.tracking_no ?? 'N/A'}</td>

                <td>${trackingLink}</td>

                <td>
                    <button class="btn ${btnClass} btn-sm mark-received-btn"
                        data-shipmentid="${shipment.tracking_no}" ${btnDisabled}>
                        ${btnText}
                    </button>
                </td>

                <td>
                    <button class="btn btn-danger btn-sm enquiry-btn"
                        data-tracking="${shipment.tracking_no}"
                        data-courier="${shipment.CourierService}"
                        data-trackinglink="${shipment.tracking_link}"
                        data-orderid="${order_id}"
                        data-orderno="${order_no}"
                        >
                        Inquiry
                    </button>
                </td>

                <td>
                    <button class="btn btn-outline-secondary btn-sm more-details-btn"
                        data-tracking_no="${shipment.tracking_no}" >
                        More Details
                    </button>
                </td>
            </tr>
        `);
    });
}


    function updateOrderTracking(currentStatusId) {
        $('#order_tracking_steps .order-tracking').each(function() {
            const stepStatusId = parseInt($(this).data('status-id'));

            // Logic: mark all steps as completed up to the current one in the correct order
            if (
                (currentStatusId == 1 && stepStatusId == 1) || // Quote
                (currentStatusId == 3 && [1, 3].includes(stepStatusId)) || // Production
                (currentStatusId == 6 && [1, 3, 6].includes(stepStatusId)) || // Shipped
                (currentStatusId == 4 && [1, 3, 6, 4].includes(stepStatusId)) // Fulfilled
            ) {
                $(this).addClass('completed');
            } else {
                $(this).removeClass('completed');
            }
        });
    }


});

$(document).on('click', '.enquiry-btn', function () {

    $('#tracking_no').val($(this).data('tracking'));
    $('#courier').val($(this).data('courier'));
    $('#tracking_link').val($(this).data('trackinglink'));
    $('#order_id').val($(this).data('orderid'));
    $('#order_no').val($(this).data('orderno'));

    enquiryQuill.root.innerHTML = '';
    $('#enquiryModal').modal('show');
});

$('#sendEnquiryBtn').on('click', function () {

    fetch("{{ route('customer.shipmentEnquiry') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            tracking_no: $('#tracking_no').val(),
            courier: $('#courier').val(),
            tracking_link: $('#tracking_link').val(),
            order_id: $('#order_id').val(),
            order_no: $('#order_no').val(),
            message: enquiryQuill.root.innerHTML
        })
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            $('#enquiryModal').modal('hide');
             Swal.fire('Success', 'Enquiry sent successfully', 'success');
        } else {
            $('#enquiryModal').modal('hide');
            Swal.fire('Error', res.message, 'error');
        }
    });
});


$(document).on('click', '.more-details-btn', function () {

    var trackingNo = $(this).data('tracking_no');

    $('#shipmentModal').modal('show');
    $('#shipmentModalBody').html(`
        <div class="text-center py-5">
            <div class="spinner-border"></div>
        </div>
    `);
    var url = "{{ route('customer.Shippingdetails', ':trackingNo') }}"
        .replace(':trackingNo', trackingNo);

    $.ajax({
        url: url,
        type: 'GET',
        success: function (res) {
            $('#shipmentModalBody').html(buildShipmentHTML(res));
        },
        error: function () {
            $('#shipmentModalBody').html(`
                <div class="alert alert-danger">Failed to load shipment details</div>
            `);
        }
    });
});

function buildShipmentHTML(data) {
    let lastProduct = null;
    let rows = '';
    let totalOrdered = 0;
    let totalShipped = 0;

    // Build item rows
    data.items.forEach(item => {
        const showProduct = item.name !== lastProduct;
        lastProduct = item.name;

        rows += `
            <tr>
                <td data-label="ITEM">
                    ${showProduct ? item.name : `<span class="d-md-none text-muted">${item.name}</span>`}
                </td>
                <td data-label="SIZE">${item.size}</td>
                <td data-label="ORDERED QTY" class="text-end">${item.ordered_qty}</td>
                <td data-label="SHIPPED QTY" class="text-end">${item.shipped_qty}</td>
            </tr>
        `;

        totalOrdered += item.ordered_qty;
        totalShipped += item.shipped_qty;
    });

    let receivedRow = '';
    if (data.received_at) {
        receivedRow = `
            <div class="row mb-2">
                <div class="col-4 text-muted">Status</div>
                <div class="col-8">
                    <span class="badge bg-success">
                        ✓ Received on ${data.received_at}
                    </span>
                </div>
            </div>
        `;
    }

    return `
        <div class="row mb-2">
            <div class="col-4 text-muted">Tracking ID</div>
            <div class="col-8">${data.tracking_no}</div>
        </div>

        <div class="row mb-2">
            <div class="col-4 text-muted">Tracking Link</div>
            <div class="col-8">
                <a href="${data.tracking_link}" target="_blank" class="text-success fw-bold">
                    CLICK HERE
                </a>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4 text-muted">Courier Service</div>
            <div class="col-8">${data.Courier_Service}</div>
        </div>

        ${receivedRow}

        <h6 class="fw-bold mt-4">ITEM LIST</h6>

        <table class="table table-bordered mt-2">
            <thead class="table-secondary">
                <tr>
                    <th>ITEM</th>
                    <th>SIZE</th>
                    <th class="text-end">ORDERED QTY</th>
                    <th class="text-end">SHIPPED QTY</th>
                </tr>
            </thead>
            <tbody>
                ${rows}
            </tbody>
            <tfoot>
                <tr class="fw-bold bg-light total-row">
                    <td class="desktop-td"></td>
                    <td class="desktop-td"></td>
                    <td class="text-end desktop-td">TOTAL Ordered: ${totalOrdered}</td>
                    <td class="text-end desktop-td">TOTAL Shipped: ${totalShipped}</td>

                    <td class="mobile-td" colspan="4" style="display:none;">
                        TOTAL Ordered: ${totalOrdered} | Shipped: ${totalShipped}
                    </td>
                </tr>
            </tfoot>
        </table>
    `;
}
</script>
@endsection
