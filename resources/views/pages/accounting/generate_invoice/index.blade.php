@extends('layouts.app', ['activePage' => 'generate-invoice', 'titlePage' => __('Generate Invoice')])

@section('content')
<style>
    .form-field {
        display: flex;
        margin-bottom: 1rem;
        flex-direction: row;
        flex-wrap: nowrap;
        align-items: center;
    }
    .form-lable {
        width: 33%;
    }
    .form-input {
        width: 100%;
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
    div.alphabet {
        display: table;
        width: 100%;
        margin-bottom: 1em;
    }
    div.alphabet span {
        display: table-cell;
        color: #b3b3b3;
        cursor: pointer;
        text-align: center;
        width: 3.5%;
        border: 1px solid #e8e8e8;
    }
    div.alphabet span:hover {
        box-shadow: 2px 2px 5px #e8e8e8;
    }
    div.alphabet span.active {
        color: black;
    }
    .add-btn-position {
        width: 84px;
        position: relative;
        right: -29px;
    }
    .btn-text-position {
        position: relative;
        right: -6%;
        font-size: 15px;
    }
    .content-position {
        position: relative;
        top: -25px;
    }
    .add-btn-text {
        position: relative;
        right: -13px;
    }
    .btns-text {
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
    }
    .btns-text:hover {
        color: #909090 ;
    }
    .btns-style {
        width: 100%;
        height: 100%;
        background-color: #909090;
        border: unset;
        border-radius: 5px;
    }
    .btns-card:hover {
        background-color: #ffffff
    }
    .btns-padding {
        padding-left: 0.2rem;
        padding-right: 0.2rem;
    }
    .btns-right-position {
        position: relative;
        right: 14px;
    }
    .btn-top {
        position: relative;
        top: 11px;
    }
    @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {
   .btn_set{
    max-width: none;
    flex:none;
    right:0px;

   }
   .div_display{
    display:none;
   }
   .div_align{
    justify-content: center;
   }
   .search_orga{
    width:200% !important;
   }
   .pagina001{
        flex-wrap: wrap;
     }
  }@media only screen and (min-device-width : 834px) and (max-device-width : 1024px) and (orientation : portrait) {

    }
    .hide {
  display: none;
}

.filter {
        padding-bottom: 0rem;
        position: relative;
        width: 98%;
        left: 1%;
        top: -0.25rem;
        border-radius: 6px !important;
    }
    .search1 {
        position: relative;
        margin-top: -0.6rem;
        margin-bottom: 1rem;
    }
    .card{
        background-color: white;
        border: none;
        border-radius: 0rem;
    }
    .styled-button{
        outline: unset;
        color: #d3d3d3;
        background-color: #fafafa;;
        border: 1px solid #d3d3d3;
        padding: .3rem;
        padding-left: .7rem;
        padding-right: .7rem;
        margin: 0rem;
        cursor: pointer;
    }
    .searchbox-layout{
        margin-top: 0 !important;
        width: 100% !important;
        height: 29px;
        font-size: .9rem;
        color: #B3B3B3;
        border: unset;
    }
    .new-style-table table.dataTable thead .sorting:before,table.dataTable thead .sorting_asc:before,table.dataTable thead .sorting_desc:before,table.dataTable thead .sorting_asc_disabled:before,table.dataTable thead .sorting_desc_disabled:before {
        content: "\f0de";
        font-family: FontAwesome;
    }
    .new-style-table table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:after,table.dataTable thead .sorting_asc_disabled:after,table.dataTable thead .sorting_desc_disabled:after {
        content: "\f0dd";
        font-family: FontAwesome;
        right: .65rem !important;
    }
    .new-style-table table thead tr{
        background-color: grey;
        color: white;
        height: 40px;
        font-size: .7rem;
    }
    .new-style-table table tr{
        background-color: white;
        color: grey;
        min-height: 40px;
        font-size: .7rem;
        border-bottom: 1px solid #b3b3b3;
    }
    .new-style-table table tbody tr:hover{
        background-color: #f6f6ff;
    }
    .new-style-table th, .new-style-table td {
        padding: 10px;
    }
    .table-responsive .table tbody td , .table-responsive .table tbody td a {
        padding: 0.4rem 1rem !important;
        font-size: .9rem !important;
        color: rgba(22, 22, 23, 1) !important;
    }
    .new-style-table table thead tr{
        background-color: rgba(50, 50, 50, 1) !important;
        height: 40px;
    }
    .btn-inside-table button{
        width: 100% !important;
        padding: 5% 3% !important;
        font-size: .7rem !important;
        height: 2.1rem;
        font-size: .7rem !important;
    }
    body {
        font-family: 'Open Sans', 'sans-serif' !important;
    }
    .hide {
        display: none;
    }
    .dataTables_scrollHeadInner{
        min-width: 100%;
    }
</style>

@if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>GENERATED INVOICE</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection


    <div class="col-md-12">
        <div class="card">
                <div class="col-md-12 mt-2">
                    <input type="hidden" id="request_multiple_invoices" name="request_multiple_invoices[]" value="" />
                    <button type="submit" class="btn multiple-request-button btn-secondary btn-sm" title="Request payment" style="background-color: rgba(7, 213, 51, 1);color:white;display:none" id="request_multiple"><i class="far fa-check-circle"></i><small>Request payment selected (<span id="invoice_checked_count"></span>)</small></button>
                </div>
                {{-- <div class="row mt-3" style="padding-left: 1rem;padding-right: 1rem;">
                    <div class=" text-left" style="margin-left: 10px; margin-right: 10px;">
                        @if (Gate::check('generate invoice'))
                            <button class="styled-button" id="generate_invoice_btn" style="outline: unset;" href="#" data-toggle="modal" data-target="#generate_invoice" title="Generate New Invoice">
                                GENARATE INVOICE
                            </button>
                        @endif
                    </div>
                </div> --}}
                <div class="col-md-12 mt-3 mb-3 new-style-table">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="generated_invoice" style="min-width: 100%;">
                            <thead>
                                <th>
                                    <input type="checkbox" class="checkbox_of_invoice_all" id="checkbox_of_invoice_all" />
                                </th>
                                <th scope="col" class="invoice-number-topic">Invoice Number</th>
                                <th scope="col" class="order-number">Order Number</th>
                                <th scope="col" class="inv-org">Organization</th>
                                <th scope="col" class="Embellishments">Embellishments</th>
                                <th scope="col" class="total-amount">Total amount</th>
                                {{-- <th scope="col" class="status text-center">Status</th> --}}
                                <th scope="col" class="created-at">Created At</th>
                                <th scope="col" class="updated-at">Updated At</th>
                            </thead>

                            <tbody>
                                @foreach ($invoices as $invoice)
                                    @php
                                        $matchingOrder = $orders->firstWhere('id', $invoice->order_id);
                                    @endphp

                                    @if ($matchingOrder)
                                    @php
                                        $matchingOrganization = $organizations->firstWhere('id', $matchingOrder->organization_id);
                                    @endphp
                                        <tr>
                                            <td class="invoice-number">
                                                <input type="checkbox" class="checkbox_of_invoice" value="{{$invoice->id}}" id="checkbox_of_invoice_{{$invoice->id}}"  />
                                            </td>
                                            <td class="invoice-number">
                                                <a href="#" class="edit" data-value="{{ $invoice->id }}">{{ $invoice->invoice_number }}</a>
                                            </td>
                                            <td class="order-number">
                                                <a href="{{ route('orders.info', ['id' => $matchingOrder->id, 'type' => 'order']) }}?active_tab=order" target="_blank">
                                                    {{ $matchingOrder->order_no }}
                                                </a>
                                            </td>
                                            <td class="inv-org">{{ $matchingOrganization ? $matchingOrganization->organization_name : '' }}</td>
                                            <td class="Embellishments" style="text-align: center;">
                                                @if($matchingOrder->embellishment == 'yes')
                                                    <span class="badge badge-success">Yes</span>
                                                @else
                                                    <span class="badge badge-secondary">No</span>
                                                @endif
                                            </td>
                                            <td class="total-amount">{{ $invoice->total_amount }}</td>
                                            {{-- <td class="status text-center">
                                                @switch($invoice->status)
                                                    @case(0)
                                                        <span class="badge badge-pill" style="color:#d381ff;background-color:#f9dfff;width:100%">Not Approved</span>
                                                        @break
                                                    @case(1)
                                                        <span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:100%">Approved</span>
                                                        @break
                                                    @case(2)
                                                        <span class="badge badge-pill" style="color:#717070;background-color:#f8f8f8;width:100%">Pending Approval</span>
                                                        @break
                                                    @case(4)
                                                        <span class="badge badge-pill" style="color:#d65a47;background-color:#ffcccc;width:100%">Rejected</span>
                                                        @break
                                                    @default
                                                        <span class="badge badge-pill" style="color:#FFB916;background-color:#ffffcc;width:100%">Paid</span>
                                                @endswitch
                                            </td> --}}
                                            <td class="created-at">{{ $invoice->created_at->format('m/d/Y') }}</td>
                                            <td class="updated-at">{{ $invoice->updated_at->format('m/d/Y') }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>
<!-- Pay multile modal -->
<div class="modal fade" id="requestMultipleModal" tabindex="-1" role="dialog" aria-labelledby="requestMultipleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestMultipleModalLabel">Request payment for Multiple Invoices</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="multipleRequestForm" action="{{ route('do_pay_multiple_invoice') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <table class="table align-items-center">
                        <thead style="background-color: grey;color: white;">
                            <th scope="col" class="text-center">Invoice Number</th>
                            <th scope="col" class="text-center">Order Number</th>
                            <th scope="col" class="text-center">Organization Name</th>
                            <th scope="col" class="text-center">Invoice amount</th>
                        </thead>
                        <tbody id="selectedInvoiceTr">
                            <!-- Dynamic rows will be appended here -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmGroupRequest">Request payments</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('pages.accounting.generate_invoice.create')

<script>

$(document).ready(function () {

    var generated_invoice = $('#generated_invoice').DataTable({
        colReorder: false,
        scrollX: true,
        stateSave: false,
        autoWidth: true,

        pageLength: 300, // Default page length

        lengthMenu: [
            [100, 200, 300, 500], // Values used internally
            [100, 200, 300, 500]  // Labels shown in dropdown
        ],

        bSort: false,

        language: {
            search: '<i class="fas fa-search"></i>',
            searchPlaceholder: 'Invoice Search'
        }
    });


    var orderNumberHasBeenSet = false;
    function reset(){
        $('#invoice_no').val('');
    }

    $('#checkbox_of_invoice_all').change(function() {
            var checked = $(this).is(':checked');
            $('.checkbox_of_invoice').prop('checked', checked).trigger('change');
        });

        $('body').on('change', '.checkbox_of_invoice', function() {
                console.log('works !');
                var invoice_array = [];
                $('.checkbox_of_invoice:checked').each(function() {
                    invoice_array.push($(this).val());
                });

                $('#invoice_checked_count').text(invoice_array.length);

                if (invoice_array.length > 0) {
                    $('#request_multiple').show();
                    $('#request_multiple_invoices').val(invoice_array);
                } else {
                    $('#request_multiple').hide();
                    $('#request_multiple_invoices').val('');
                }
        });

        $('body').on('click', '.multiple-request-button', function(e){
            e.preventDefault();

            $(".se-pre-con").fadeIn('slow');

            var arrayData = $('#request_multiple_invoices').val();

            var invoiceArray = arrayData.split(',');

            invoiceArray = invoiceArray.map(function(item) {
                return item.trim();
            });

            $.ajax({
                    url:"{{ route('get_multiple_invoice_details') }}",
                    type: "POST",
                    data: {
                        'invoices': invoiceArray,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (data) {
                        $(".se-pre-con").fadeOut('slow');

                        $('#selectedInvoiceTr').empty();

                        if (data.data && data.data.length > 0) {
                            var totalAmount = 0.00;

                            data.data.forEach(function(invoice) {
                                var invoiceTotalAmount = parseFloat(invoice.total_amount); // Parse the total amount as a float
                                var row = `
                                            <tr>
                                                <td class="text-center">${invoice.invoice_number}</td>
                                                <td class="text-center">${invoice.order_id}</td>
                                                <td>${invoice.order_details.organization_details.organization_name}</td>
                                                <td class="text-right">
                                                    ${invoiceTotalAmount.toFixed(2)}<input type="number" style="display:none" max="${invoiceTotalAmount}" class="invoice_request_amount text-right form-control" name="payment_amount[${invoice.id}]" value="${invoiceTotalAmount}">
                                                </td>
                                            </tr>
                                        `;
                                $('#selectedInvoiceTr').append(row);

                                totalAmount += invoiceTotalAmount;
                            });

                            var totalRow = `
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td class="text-right" style="font-weight:800">Total : </td>
                                                <td class="text-right">
                                                    ${totalAmount.toFixed(2)} <!-- Ensure total has two decimal places -->
                                                </td>
                                            </tr>
                                        `;
                            $('#selectedInvoiceTr').append(totalRow);

                            $('#requestMultipleModal').modal('show');
                        }

                    }
                });

                $(".se-pre-con").fadeOut('slow');
        });

        $('#confirmGroupRequest').click(function(e) {
            $(".se-pre-con").fadeIn('slow');
            e.preventDefault();

            var formData = $('#multipleRequestForm').serialize();

            $.ajax({
                url: "{{ route('request_multiple_invoice') }}",
                method: "POST",
                data: formData,
                success: function(response) {
                    console.log(response);
                    $('#requestMultipleModal').modal('hide');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });

    function get_invoice_data(invoiceId) {
        $.ajax({
            url: `{{ url('invoice/edit') }}/${invoiceId}`,
            method: 'GET',
            cache: false,
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (data) {
                var invoice = data.invoice && Array.isArray(data.invoice) && data.invoice.length > 0 ? data.invoice[0] : null;
                var additionalData = data.additional || [];

                console.log(data);

                if (!invoice) {
                    console.log('Invoice data is missing or invalid.');
                    return;
                }

                updateInvoiceFields(invoice);
                updateAdditionalFields(additionalData);
                handleInvoiceStatus(invoice);

                // Set form action and display modal
                $('#invoice_form').attr('action', `create_factory_invoice`);
                // $('#generate_invoice').modal('show');
            },
            complete: function () {
                // $(".se-pre-con").fadeOut('slow');
            },
            error: function (error) {
                console.log('Error fetching invoice data:', error);
            }
        });
    }

    function updateInvoiceFields(invoice) {
        $('#new_invoice_no').val(invoice.id);
        $('#invoice_no').val(invoice.invoice_number);
        $('#total_value').val(invoice.total_amount);
        $('#reduce_value_input').val(invoice.reduce_value);
        $('#order_number').val(invoice.order_id).trigger('change');
        updateCurrentDate(invoice.created_at);
    }

    function updateAdditionalFields(additionalData) {
        $('.additional').val(''); // Clear all additional fields first
        additionalData.forEach(function (item) {
            var additionalInput = document.getElementById(`addition_value_${item.addition_payment_id}`);
            if (additionalInput) {
                additionalInput.value = item.amount;
            }

            var additionalIdSpan = document.querySelector(`.addition_id[data-value="${item.addition_payment_id}"]`);
            if (additionalIdSpan) {
                additionalIdSpan.setAttribute('data-value', item.addition_payment_id);
            }

            var otherReasonInput = document.querySelector(`.other-reson[name="other_reson[${item.addition_payment_id}]"]`);
            if (otherReasonInput) {
                otherReasonInput.value = item.if_other_reson || '';
            }
        });
    }

    function handleInvoiceStatus(invoice) {
        var status = parseInt(invoice.status, 10);

        if (status === 1 || status === 3) {
            $('#frm_submit_btn').hide();
        } else {
            $('#frm_submit_btn').show();
        }

        if (status === 0|| status === 4) {
            createActionButton('Delete', 'delete btn-danger', 'delete', invoice.id);
        }else{
            if($('button.delete').length> 0){
                $('button.delete').remove();
            }
        }

        if (status === 1 || status === 2) {
            createActionButton('Pay', 'payed btn-warning', 'payed', invoice.id);
        }else{
            if($('button.payed').length> 0){
                $('button.payed').remove();
            }
        }
    }

    function createActionButton(text, classes, action, invoiceId) {
        if ($(`.${action}`).length === 0) {
            var button = document.createElement('button');
            button.className = `${classes} btn-custom frm_${action}_btn btn`;
            button.setAttribute('data-value', invoiceId);
            button.textContent = text;

            var updateButton = document.querySelector('.frm_submit_btn');
            updateButton.parentNode.insertBefore(button, updateButton.nextSibling);
        }
    }

    $('#generate_invoice_btn').on('click', function(){

        updateCurrentDate();
    });

    $(document).on('click', '.edit', function (event) {
        event.preventDefault();

        var invoiceId = $(this).data('value'); // Retrieve invoice ID from the data attribute

        $(".se-pre-con").fadeIn('slow'); // Show loading animation
        $('.frm_submit_btn').text('Request Payment'); // Change button text

        $('#new_invoice_no').val(invoiceId); // Set the invoice ID in the input
        $('#generate_invoice').attr('data-selected-invoice-id', invoiceId); // Set the invoice ID as a custom data attribute

        get_invoice_data(invoiceId);
    });

    $("body").on("click", ".delete", function(e) {
        e.preventDefault();

        var invoiceId = $(this).data('value');

        Swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            text: 'Do you really want to delete this invoice?',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then(function(result) {
            if (result.value == true) {
                $.ajax({
                    url: '{{url("invoice/delete")}}/' + invoiceId,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function() {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function(data) {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: data.success,
                                showConfirmButton: false,
                                timer: 3000
                            }).then(function() {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.error
                            });
                        }
                    },
                    complete: function() {
                        $(".se-pre-con").fadeOut('slow');
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please try again.'
                        });
                    }
                });
            }
        });
    });


    $("body").on("click", ".payed", function(e){
        e.preventDefault(); // Prevent the default click behavior

        var invoiceId = $(this).data('value');

        // Show a confirmation popup using SweetAlert2
        if (confirm("Are you sure you want to payed this invoice?")) {
                // User confirmed, send an AJAX request to payed the product
                $.ajax({
                    url: '{{url("invoice/payed")}}/'+invoiceId,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function(data){
                        if (data.success) {
                            // Product pay successful, display success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: data.success,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function() {
                                // Reload the current page
                                location.reload();
                            });
                        } else {
                            // Product pay failed, display the error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.error
                            });
                        }
                    },

                    complete: function() {
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            }

        });
    });


    $(document).ready(function() {
        $('.select2-invoice').select2({
            dropdownParent: $('#generate_invoice')
        });
    });
    $(document).ready(function() {
        // Store the original values when the page loads
        $('#order-items-table tbody tr').each(function() {
            var $row = $(this);
            $row.data('original-product-no', $row.find('.inv-product-no').text());
            $row.data('original-qty', $row.find('.inv-product-qty').text());
        });

        // On form submission
        $('#invoice_form').on('submit', function(e) {
            $('#order-items-table tbody tr').each(function() {
                var $row = $(this);

                // Reset values if they have been edited
                if ($row.find('.inv-product-no').text() !== $row.data('original-product-no')) {
                    $row.find('.inv-product-no').text($row.data('original-product-no'));
                }
                if ($row.find('.inv-product-qty').text() !== $row.data('original-qty')) {
                    $row.find('.inv-product-qty').text($row.data('original-qty'));
                }
            });
        });
    });


</script>



@endsection
