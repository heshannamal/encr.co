@extends('layouts.app', ['activePage' => 'payment_ledger', 'titlePage' => __('Payment Ledger')])

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
.table-container {
    max-width: 100%;
    overflow-x: hidden; /* Prevent horizontal scrolling in the outer container */
}

.dataTables-search,
.dataTables-pagination {
    background-color: #f9f9f9;
    padding: 10px;
}

.table-scrollable {
    max-height: 300px; /* Adjust vertical height as needed */
    overflow-y: auto;  /* Enable vertical scrolling */
    overflow-x: auto;  /* Enable horizontal scrolling */
    width: 100%;       /* Ensure full width for horizontal scroll */
    white-space: nowrap; /* Prevent text wrapping for horizontal scrolling */
}

.table-scrollable table {
    width: 100%;       /* Make table full width */
    table-layout: fixed; /* Ensures columns resize within scrollable area */
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
    #payMultipleModal .table td {
        padding: .5rem 1.5rem;
        height: 2rem;
    }
    .hard-top-border{
        border-top: double #e9ecef !important;
    }
    .no-top-border{
        border-top: none !important;
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
        <span>PAYMENT LEDGER</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12">
        <div class="card">
                <div class="col-md-12 mt-3">
                    <span>Select Financial Year &nbsp;<span>
                        <select id="financial_year" name="financial_year">
                            @foreach($yearList as $year)
                                <option value="{{ $year }}" {{ isset($financial_year) && $financial_year == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="col-md-12 mt-3 mb-3 new-style-table">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="payment_ledger">
                            <thead>
                                <tr>
                                    <th scope="col" class="transaction-id">Transaction id</th>
                                    <th scope="col" class="invoice-total">Invoice total</th>
                                    <th scope="col" class="pay-by-cash">Pay by cash</th>
                                    <th scope="col" class="setle-from-debit">Settle from debit</th>
                                    <th scope="col" class="overpaid">Overpaid</th>
                                    <th scope="col" class="total-paid-amount">Total paid amount</th>
                                    <th scope="col" class="included-invoiced">Included invoices</th>
                                    <th scope="col" class="transaction-description">Description</th>
                                    <th scope="col" class="transaction-date">Transaction date</th>
                                    <th scope="col" class="transaction-time">Transaction time</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($Transactions as $Transaction)
                                    <tr>
                                        <td class="transaction-id">
                                            <a href="javascript:void(0);" class="show-image"
                                               data-image-url="{{ $Transaction->image_url ? url('public/' . $Transaction->image_url) : asset('assets/img/products/product defaul image.jpg') }}"
                                               data-transaction-id="{{ $Transaction->transaction_id }}">
                                                {{ $Transaction->transaction_id }}
                                            </a>
                                        </td>
                                        <td class="invoice-total text-right">{{$Transaction->invoice_total}}</td>
                                        <td class="pay-by-cash text-right">{{$Transaction->cash_amount}}</td>
                                        <td class="setle-from-debit text-right">{{$Transaction->debit_amount}}</td>
                                        <td class="overpaid text-right">{{ $Transaction->paid_amount - $Transaction->invoice_total > 0 ? number_format($Transaction->paid_amount - $Transaction->invoice_total, 2) : '0.00' }}</td>
                                        <td class="total-paid-amount text-right">{{$Transaction->paid_amount}}</td>
                                        <td class="included-invoiced text-center"><button type="button" onclick="showIncludedInvoices([{{$Transaction->invoice_ids}}], '{{ $Transaction->transaction_id }}')">Show invoices</button></td>
                                        <td class="transaction-description">{{ $Transaction->payment_description }}</td>
                                        <td class="transaction-date text-center">{{ $Transaction->created_at->format('m/d/Y') }}</td>
                                        <td class="transaction-time text-center">{{ $Transaction->created_at->format('H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>

@include('pages.accounting.generate_invoice.create')

<!-- Pay multile modal -->
<div class="modal fade" id="payMultipleModal" tabindex="-1" role="dialog" aria-labelledby="payMultipleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="max-width: 1200px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payMultipleModalLabel" style="font-size: 1.2rem;">TRANSACTION - <span id="transaction_id_span"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                @csrf
                <div class="modal-body">
                    <table class="table align-items-center ml-auto">
                        <thead style="background-color: grey;color: white;">
                            <th scope="col" class="text-center">Invoice Number</th>
                            <th scope="col" class="text-center">Order Number</th>
                            <th scope="col" class="text-center">Organization Name</th>
                            <th scope="col" class="text-center">Total amount</th>
                            <th scope="col" class="text-center">Paid amount</th>
                            <th scope="col" class="text-center">Action</th>
                        </thead>
                        <tbody id="selectedInvoiceTr">

                        </tbody>
                        {{-- <tbody class="no-top-border">
                            <tr>
                                <td class="no-top-border" colspan="3">
                                </td>
                                <td class="text-right no-top-border" style="font-weight:800">Cash:  </td>
                                <td class="no-top-border">
                                    <input type="text" name="transaction_amount_cash" id="transaction_amount_cash" value="" class="form-control text-right" style="font-weight:800" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td class="no-top-border" colspan="3" id="debit_acc_summary_line_1"></td>
                                <td class="text-right no-top-border" style="font-weight:800">Settle from Debit:  </td>
                                <td class="no-top-border">
                                    <input type="text" id="transaction_amount_debit" value="" class="form-control text-right" style="font-weight:800" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td class="no-top-border" colspan="3" id="debit_acc_summary_line_2"></td>
                                <td class="text-right no-top-border" style="font-weight:800;font-size: 1rem;">Total payment:  </td>
                                <td class="no-top-border">
                                    <input type="text" id="total_sum_of_payment" value="" class="form-control text-right" style="font-weight:800;" readonly>
                                </td>
                            </tr>
                        </tbody> --}}
                    </table>
                    {{-- <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="payment_reference text">Payment reference text</label><br>
                                <textarea name="payment_reference" class="form-control" id="payment_reference" cols="30" rows="3" style="width: 100%;"></textarea>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group mb-1 mt-3" style="padding: 0rem 1rem;">
                                    <label for="upload_image">Upload Image for payment reference</label>
                                    <input type="file" id="upload_image" name="upload_image" accept="image/png, image/jpeg" class="form-control" style="width: auto;height: auto;" onchange="previewImage(event)">
                                </div>

                                <div class="form-group" id="imagePreview" style="display:none;padding: 0rem 1rem;">
                                    <img id="uploaded_image" src="" alt="Uploaded Image" style="width: auto; height: 5rem;">
                                    <button type="button" id="removeImage">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="imageModalLabel" style="font-size: 1.2rem;">Transaction Image</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          <img id="transactionImage" src="" alt="Transaction Image" style="max-width: 100%; height: auto;">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


<script>

$(document).ready(function () {

    var payment_ledger = $('#payment_ledger').DataTable({
            colReorder: false,
            scrollX: true,
            stateSave: true,
            "autoWidth": true,
            "pageLength": 50,
            "bSort" : false,
            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'Transaction Search'
            }
        });
});

$(document).ready(function() {
    $("#financial_year").change(function() {
        $(".se-pre-con").fadeIn('slow');
        var selectedYear = $(this).val();
        var baseUrl = "{{ url('/') }}";
        window.location.href = baseUrl + "/payment_ledger?financial_year=" + selectedYear;
    });
});

$(document).ready(function() {
    $('.show-image').click(function() {
        var imageUrl = $(this).data('image-url');
        var transactionId = $(this).data('transaction-id');

        $('#transactionImage').attr('src', imageUrl);

        $('#imageModalLabel').text('Transaction Image #' + transactionId);

        $('#imageModal').modal('show');
    });
});

function showIncludedInvoices(arrayData, transaction_id){
    $(".se-pre-con").fadeIn('slow');

    var invoiceArray = arrayData;

    $.ajax({
        url:"{{ route('get_multiple_invoice_details') }}",
        type: "POST",
        data: {
            'invoices': invoiceArray,
            'transaction_id': transaction_id,
            _token: '{{ csrf_token() }}'
        },
        beforeSend: function () {
            $(".se-pre-con").fadeIn('slow');
        },
        success: function (data) {
            $(".se-pre-con").fadeOut('slow');

            $('#selectedInvoiceTr').empty();

            var invoices = data.data;
            invoices.sort((a, b) => a.id - b.id);

            console.log(data.transaction);

            if (invoices && invoices.length > 0) {
                var totalAmount = 0.00;
                invoices.forEach(function(invoice) {

                    var transactionPaidAmount = data.transaction.paid_details.find(
                        (detail) => detail.invoice_id === invoice.id
                    );

                    var paidAmount = transactionPaidAmount ? transactionPaidAmount.paid_amount : invoice.paid_amount;

                    var totalAmountFormatted = parseFloat(invoice.total_amount).toFixed(2);
                    var paidAmountFormatted = parseFloat(paidAmount).toFixed(2);

                    let organizationName = invoice.order_details.organization_details.organization_name;
                    if (organizationName.length > 50) {
                        organizationName = organizationName.substring(0, 40) + '...';
                    }

                    var baseOrderUrl = "{{ route('orders.info', ['id' => 'ORDER_ID', 'type' => 'order']) }}";

                    var row = `
                        <tr>
                            <td class="text-center"><a href="#" class="edit" data-value="${invoice.id}">${invoice.invoice_number}</a></td>
                            <td class="text-center">
                                <a href="${baseOrderUrl.replace('ORDER_ID', invoice.order_id)}?active_tab=order" target="_blank">
                                    #${invoice.order_id}
                                </a>
                            </td>
                            <td class="text-left">${organizationName}</td>
                            <td class="text-right">${totalAmountFormatted}</td>
                            <td class="text-right">${paidAmountFormatted}</td>
                            <td class="text-center"><button class="btn download_invoice_pdf" style="padding: 0.2rem .5rem" data-value="${invoice.id}"><i class="fa fa-download" aria-hidden="true"></i></button></td>
                        </tr>
                    `;
                    $('#selectedInvoiceTr').append(row);

                    totalAmount += parseFloat(paidAmount);
                });

                    var totalRow = `
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right" style="font-weight:800">Paid invoice total : </td>
                                        <td class="text-right">
                                            ${parseFloat(totalAmount).toFixed(2)}
                                        </td>
                                    </tr>
                                `;
                    $('#selectedInvoiceTr').append(totalRow);

                    $('#payMultipleModal').modal('show');
            }
            if (data.transaction){
                $('#transaction_id_span').text(data.transaction.transaction_id);
                // $('#transaction_amount_cash').val(data.transaction.cash_amount);
                // $('#transaction_amount_debit').val(data.transaction.debit_amount);
                // $('#total_sum_of_payment').val(data.transaction.paid_amount);
            }
        }
    });

    $(".se-pre-con").fadeOut('slow');
}
    $(document).on('click', '.edit', function (event) {
        event.preventDefault();

        var invoiceId = $(this).data('value');

        $(".se-pre-con").fadeIn('slow');
        $('.frm_submit_btn').text('Request Payment');

        $('#new_invoice_no').val(invoiceId);
        $('#generate_invoice').attr('data-selected-invoice-id', invoiceId);

        get_invoice_data(invoiceId, true);
    });
    $(document).on('click', '.download_invoice_pdf', function (event) {
        event.preventDefault();

        var invoiceId = $(this).data('value');

        get_invoice_data(invoiceId, false);

        $(".se-pre-con").fadeIn('slow');
    });
    function get_invoice_data(invoiceId, displayModal) {
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

                if (!invoice) {
                    console.log('Invoice data is missing or invalid.');
                    return;
                }

                updateInvoiceFields(invoice);
                updateAdditionalFields(additionalData);

                // Set form action and display modal
                $('#invoice_form').attr('action', `create_factory_invoice`);
                // $('#generate_invoice').modal('show');
            },
            complete: function () {
                // $(".se-pre-con").fadeOut('slow');
                $('#frm_submit_btn_save').hide();
                $('#frm_submit_btn').hide();
                $('#order_number').attr('disabled', true);
                if (!displayModal) {
                    setTimeout(function() {
                        $('#download-pdf-btn').click();
                        $('#generate_invoice').modal('hide');
                    }, 1000);
                }
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


</script>



@endsection
