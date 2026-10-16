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
    .card{
        background-color: white;
        border: none;
        border-radius: 0rem;
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
    .new-style-table th, .new-style-table td {
        padding: 10px;
    }
    .new-style-table table tbody tr:hover{
        background-color: #f6f6ff;
    }
    .table-responsive .table tbody td , .table-responsive .table tbody td a {
        padding: 0.4rem 1rem !important;
        font-size: .9rem !important;
        color: rgba(22, 22, 23, 1) !important;
    }
    .new-style-table table thead tr {
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
    .custom-control-label::before{
        position: relative;
        left: 0.25rem;
    }
    #payMultipleModal .table td {
        padding: .2rem 1.5rem;
    }
    .hard-top-border{
        border-top: double #e9ecef !important;
    }
    .no-top-border{
        border-top: none !important;
    }

</style>


<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con" style="display: none;"></div>

    @section('order-header')
        <span>PAYABLE INVOICE</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12 btn-top">
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3 btns-right-position btn_set">
                <div class="row div_align">
                    <div class="col-md-6 btns-padding">
                        {{-- @if (Gate::check('add fabrics'))
                            <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" data-toggle="modal" data-target="#fabric_create_modal" title="Add New Fabrics">
                                Add Fabric
                            </button>
                        @endif --}}
                    </div>
                    <div class="col-md-6 btns-padding">
                            {{-- <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                                Table Layout
                            </button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 new-style-table">
        <div class="card">
            @if (isset($buttonVisibility) && $buttonVisibility == true )
                <div class="col-md-12 mt-2">
                    <input type="hidden" id="pay_multiple_invoices" name="pay_multiple_invoices[]" value="" />
                    <button type="submit" class="btn multiple-pay-button btn-secondary btn-sm" title="Pay" style="background-color: rgba(7, 213, 51, 1);color:white;display:none" id="pay_multiple"><i class="far fa-check-circle"></i><small>Pay selected (<span id="invoice_checked_count"></span>)</small></button>
                </div>
            @endif
                <div class="col-md-12 mt-3 mb-3">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="generated_invoice">
                            <thead>
                                <th>
                                    <input type="checkbox" class="checkbox_of_invoice_all" id="checkbox_of_invoice_all" />
                                </th>
                                <th scope="col" class="invoice-number">Invoice Number</th>
                                {{-- <th scope="col" class="company-invoice">Company Invoice</th>
                                <th scope="col" class="group-invoice">Group Invoice</th> --}}
                                <th scope="col" class="order-number">Order Number</th>
                                <th scope="col" class="order-organization">Organization</th>
                                <th scope="col" class="total-amount">Total amount</th>
                                <th scope="col" class="paid-amount">Paid amount</th>
                                {{-- <th scope="col" class="status">Status</th> --}}
                                <th scope="col" class="created-at">Created At</th>
                                <th scope="col" class="updated-at">Updated At</th>
                            </thead>

                            <tbody>
                                    @foreach ($factoryinvoices as $factoryinvoice)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="checkbox_of_invoice" value="{{$factoryinvoice->id}}" id="checkbox_of_invoice_{{$factoryinvoice->id}}" />
                                                </td>
                                                <td class="invoice-number"><a href="#" class="edit" data-value="{{ $factoryinvoice->id }}">{{ $factoryinvoice->invoice_number }}</a></td>
                                                {{-- <td class="company-invoice"><a href="#" class="edit" data-value="{{$factoryinvoice->id}}">{{$factoryinvoice->company_invoice}}</a></td>
                                                @if (isset($factoryinvoice->group_invoice_id))
                                                    <td class="company-invoice"><a href="#" class="group" data-value="{{$factoryinvoice->group_invoice_id}}">GROUP - {{$factoryinvoice->group_invoice_id}}</a></td>
                                                @else
                                                    <td></td>
                                                @endif --}}
                                                <td class="order-number">
                                                    <a href="{{ route('orders.info', ['id' => $factoryinvoice->order_id, 'type' => 'order']) }}?active_tab=order" target="_blank">
                                                        {{  str_pad($factoryinvoice->order_id, 6, '0', STR_PAD_LEFT)  }}
                                                    </a>
                                                </td>
                                                <td class="order-organization">{{$factoryinvoice->orderDetails ? $factoryinvoice->orderDetails->organizationDetails->organization_name : ''}}</td>
                                                <td class="total-amount text-right">{{$factoryinvoice->total_amount}}</td>
                                                <td class="paid-amount text-right">{{$factoryinvoice->paid_amount}}</td>
                                                {{-- <td class="status text-center">
                                                    @if($factoryinvoice->status == 0 )
                                                        <span class="badge badge-pill" style="color:#d381ff;background-color:#f9dfff;width:100%">Not Approved</span>
                                                    @elseif($factoryinvoice->status == 2)
                                                        <span class="badge badge-pill" style="color:#717070;background-color:#f8f8f8;width:100%">Pending Approval</span>

                                                    @elseif($factoryinvoice->status == 1)
                                                        <span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:100%">Approved</span>
                                                    @elseif($factoryinvoice->status == 4)
                                                        <span class="badge badge-pill" style="color:#d65a47;background-color:#ffcccc;width:100%">Rejected</span>
                                                    @else
                                                        <span class="badge badge-pill" style="color:#FFB916;background-color:#ffffcc;width:100%">Paid</span>

                                                    @endif
                                                </td> --}}
                                                <td class="created-at">{{$factoryinvoice->created_at->format('m/d/Y')}}</td>
                                                <td class="updated-at">{{$factoryinvoice->updated_at->format('m/d/Y')}}</td>
                                            </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>

</div>
<!-- Pay multile modal -->
<div class="modal fade" id="payMultipleModal" tabindex="-1" role="dialog" aria-labelledby="payMultipleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="max-width:1125px !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payMultipleModalLabel" style="font-size: 1.2rem;">TRANSACTION - {{$transactionID}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="multiplePayForm" action="{{ route('do_pay_multiple_invoice') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <table class="table align-items-center ml-auto">
                        <thead style="background-color: grey;color: white;">
                            <th scope="col" class="text-center">Invoice Number</th>
                            <th scope="col" class="text-center">Order Number</th>
                            <th scope="col" class="text-center">Organization Name</th>
                            <th scope="col" class="text-center">Total amount</th>
                            <th scope="col" class="text-center">Paid amount</th>
                            <th scope="col" class="text-center">Payment amount</th>
                        </thead>
                        <tbody id="selectedInvoiceTr">

                        </tbody>
                        <tbody class="no-top-border">
                            <tr>
                                <td class="no-top-border" colspan="4"><p style="margin: 0;font-weight: 600;color: #cf4b4b;font-size: 1.3rem;">Current debit account balace = ${{$currentDebitValue}}</p></td>
                                <td class="text-right no-top-border" style="font-weight:800">Payment Amount:  </td>
                                <td class="no-top-border">
                                    <input type="text" name="transaction_amount_cash" id="transaction_amount_cash" value="" class="form-control text-right" style="font-weight:800">
                                </td>
                            </tr>
                            <tr>
                                <td class="no-top-border" colspan="4" id="debit_acc_summary_line_1"></td>
                                <td class="text-right no-top-border" style="font-weight:800">Settle from Debit:  </td>
                                <td class="no-top-border">
                                    <input type="text" name="transaction_amount_debit" id="transaction_amount_debit" value="0.00" class="form-control text-right" style="font-weight:800">
                                    <input type="text" name="plus_amount_to_debit" id="plus_amount_to_debit" value="0.00" style="display:none">
                                    <input type="text" name="current_value" id="current_value" value="{{$currentDebitValue}}" style="display:none">
                                </td>
                            </tr>
                            <tr>
                                <td class="no-top-border" colspan="4" id="debit_acc_summary_line_2"></td>
                                <td class="text-right no-top-border" style="font-weight:800;font-size: 1rem;">Total payment:  </td>
                                <td class="no-top-border">
                                    <input type="text" name="total_sum_of_payment" id="total_sum_of_payment" value="0.00" class="form-control text-right" style="font-weight:800;" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="transaction_id" value="{{$transactionID}}">
                    <div class="col-md-12">
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
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmGroupPay">Pay</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Reason Type Modal -->



@include('pages.accounting.generate_invoice.create')
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('uploaded_image');
            output.src = reader.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]); // Preview the image
    }

    // Remove image functionality
    document.getElementById('removeImage').addEventListener('click', function() {
        document.getElementById('upload_image').value = ''; // Clear file input
        document.getElementById('uploaded_image').src = ''; // Clear image preview
        document.getElementById('imagePreview').style.display = 'none'; // Hide image preview area
    });
</script>

<script>

$('body').on('click', '.close', function () {
        // reset();
    })

    $(document).ready(function () {

        var generated_invoice = $('#generated_invoice').DataTable({
            colReorder: false,
            scrollX: true,
            stateSave: true,
            "autoWidth": false,
            "pageLength": 500,
            "bSort": false,
            "lengthMenu": [ [25, 50, 100, 500], [25, 50, 100, 500] ],
            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'Payables Search'
            }
        });

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
                    $('#pay_multiple').show();
                    $('#pay_multiple_invoices').val(invoice_array);
                } else {
                    $('#pay_multiple').hide();
                    $('#pay_multiple_invoices').val('');
                }
            });

        var orderNumberHasBeenSet = false;

        $('body').on('click', '.multiple-pay-button', function(e){
            e.preventDefault();

            $(".se-pre-con").fadeIn('slow');

            var arrayData = $('#pay_multiple_invoices').val();

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

                        var invoices = data.data;
                        invoices.sort((a, b) => a.id - b.id);

                        if (invoices && invoices.length > 0) {
                            var totalAmount = 0.00;
                            invoices.forEach(function(invoice) {
                                let organizationName = invoice.order_details.organization_details.organization_name;
                                if (organizationName.length > 50) {
                                    organizationName = organizationName.substring(0, 50) + '...';
                                }
                                var row = `
                                            <tr>
                                                <td class="text-center">${invoice.invoice_number}</td>
                                                <td class="text-center">${invoice.order_id}</td>
                                                <td class="text-left">${organizationName}</td>
                                                <td class="text-right total-amount-to-pay">${parseFloat(invoice.total_amount).toFixed(2)}</td>
                                                <td class="text-right paid-amount-total">${invoice.paid_amount}</td>
                                                <td>
                                                    <input type="text" max="${invoice.total_amount - invoice.paid_amount}" class="invoice_payment_amount form-control text-right" name="payment_amount[${invoice.id}]" value="${parseFloat(invoice.total_amount - invoice.paid_amount).toFixed(2)}">
                                                </td>
                                            </tr>
                                        `;
                                        $('#selectedInvoiceTr').append(row);

                                        totalAmount += invoice.total_amount - invoice.paid_amount;
                            });

                            var totalRow = `
                                            <tr>
                                                <td class="hard-top-border"></td>
                                                <td class="hard-top-border"></td>
                                                <td class="hard-top-border"></td>
                                                <td class="hard-top-border"></td>
                                                <td class="text-right hard-top-border" style="font-weight:800">Amount to pay : </td>
                                                <td class="hard-top-border">
                                                    <input type="text" name="total_amount" id="total_paid_amount" value="${parseFloat(totalAmount).toFixed(2)}" class="form-control text-right" style="font-weight:800" readonly>
                                                </td>
                                            </tr>
                                        `;
                            $('#selectedInvoiceTr').append(totalRow);

                            $('#transaction_amount_cash,#total_sum_of_payment').val(parseFloat(totalAmount).toFixed(2));

                            $('#payMultipleModal').modal('show');
                        }
                    }
                });

                $(".se-pre-con").fadeOut('slow');
        });

        $("body").on("click", ".payed", function(e){
            e.preventDefault();

            var invoiceId = $(this).data('value');
            $('#pay_multiple_invoices').val(invoiceId);
            $(".se-pre-con").fadeIn('slow');

            var arrayData = $('#pay_multiple_invoices').val();
            var invoiceArray = [arrayData.trim()];

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

                        var invoices = data.data;
                        invoices.sort((a, b) => a.id - b.id);

                        if (invoices && invoices.length > 0) {
                            var totalAmount = 0.00;
                            invoices.forEach(function(invoice) {
                                let organizationName = invoice.order_details.organization_details.organization_name;
                                if (organizationName.length > 50) {
                                    organizationName = organizationName.substring(0, 50) + '...';
                                }
                                var row = `
                                            <tr>
                                                <td class="text-center">${invoice.invoice_number}</td>
                                                <td class="text-center">${invoice.order_id}</td>
                                                <td class="text-left">${organizationName}</td>
                                                <td class="text-right total-amount-to-pay">${parseFloat(invoice.total_amount).toFixed(2)}</td>
                                                <td class="text-right paid-amount-total">${invoice.paid_amount}</td>
                                                <td>
                                                    <input type="text" max="${invoice.total_amount - invoice.paid_amount}" class="invoice_payment_amount form-control text-right" name="payment_amount[${invoice.id}]" value="${parseFloat(invoice.total_amount - invoice.paid_amount).toFixed(2)}">
                                                </td>
                                            </tr>
                                        `;
                                        $('#selectedInvoiceTr').append(row);

                                        totalAmount += invoice.total_amount - invoice.paid_amount;
                            });

                            var totalRow = `
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-right" style="font-weight:800">Amount to pay : </td>
                                                <td>
                                                    <input type="text" name="total_amount" id="total_paid_amount" value="${parseFloat(totalAmount).toFixed(2)}" class="form-control text-right" style="font-weight:800" readonly>
                                                </td>
                                            </tr>
                                        `;
                            $('#selectedInvoiceTr').append(totalRow);

                            $('#transaction_amount_cash, #total_sum_of_payment').val(parseFloat(totalAmount).toFixed(2));

                            $('#generate_invoice').modal('hide');
                            $('#payMultipleModal').modal('show');
                        }
                    }
                });

                $(".se-pre-con").fadeOut('slow');

        });

        $(document).on('change', '#transaction_amount_cash', function() {
            handlePaymentValues();
        });

        $(document).on('change', '#transaction_amount_debit', function() {
            handlePaymentValues();
        });

        function handlePaymentValues() {
            $(".se-pre-con").fadeIn('slow');
            var sum = 0;

            $('#selectedInvoiceTr tr').each(function() {
                var $row = $(this);

                var totalAmountToPay = parseFloat($row.find('.total-amount-to-pay').text()) || 0;
                var paidAmountTotal = parseFloat($row.find('.paid-amount-total').text()) || 0;

                sum += totalAmountToPay;

                var remainingAmount = totalAmountToPay - paidAmountTotal;

                $row.find('.invoice_payment_amount').val(remainingAmount.toFixed(2));
            });

            $('#total_paid_amount').val(sum.toFixed(2));
            var total_paid_amount = parseFloat($('#total_paid_amount').val()) || 0;
            var transaction_amount_cash = parseFloat($('#transaction_amount_cash').val()) || 0;
            var transaction_amount_debit = parseFloat($('#transaction_amount_debit').val()) || 0;
            var current_value = parseFloat($('#current_value').val()) || 0;

            $('#transaction_amount_debit').prop('readonly', false);
            $('#plus_amount_to_debit').val(0.00);

            $('#total_sum_of_payment').val(parseFloat(transaction_amount_cash + transaction_amount_debit).toFixed(2));

            if (transaction_amount_cash > total_paid_amount) {
                var overPayment = (transaction_amount_cash - total_paid_amount).toFixed(2);
                var htmlContent1 = '<p style="margin: 0;font-weight: 600;color: grey;">Excess payment for this transaction = $' + overPayment + '</p>';
                var htmlContent2 = '<p style="margin: 0;font-weight: 600;color: grey;">Current debit balance (' + parseFloat(current_value).toFixed(2) + ' + ' + overPayment + ') = $' + (current_value + parseFloat(overPayment)).toFixed(2) + '</p>';

                $('#plus_amount_to_debit').val(overPayment);
                $('#debit_acc_summary_line_1').html(htmlContent1);
                $('#debit_acc_summary_line_2').html(htmlContent2);

                // $('#transaction_amount_debit').prop('readonly', true);
            }

            if (transaction_amount_cash < total_paid_amount) {

                $('#transaction_amount_debit').prop('readonly', false);

                if (transaction_amount_debit > 0) {
                    if (transaction_amount_debit == total_paid_amount - transaction_amount_cash) {
                        console.log('Payment settled');
                        $('#debit_acc_summary_line_1, #debit_acc_summary_line_2').html('');
                        $('#transaction_amount_debit').prop('readonly', true);
                    } else {
                        var remaining_payment = (total_paid_amount - transaction_amount_cash - transaction_amount_debit).toFixed(2);
                        var htmlContent1 = '<p style="margin: 0;font-weight: 600;color: grey;">Excess payment for this transaction = $' + remaining_payment + '</p>';
                        var htmlContent2 = '<p style="margin: 0;font-weight: 600;color: grey;">Current debit balance (' + parseFloat(current_value).toFixed(2) + ' + ' + remaining_payment + ') = $' + (current_value + parseFloat(remaining_payment)).toFixed(2) + '</p>';

                        $('#plus_amount_to_debit').val(remaining_payment);
                        $('#debit_acc_summary_line_1').html(htmlContent1);
                        $('#debit_acc_summary_line_2').html(htmlContent2);
                    }

                    let total = 0;
                    let is_exeed = false;

                    $('#selectedInvoiceTr').find('tr td .invoice_payment_amount').each(function () {
                        let value = parseFloat($(this).val()) || 0;
                        total += value;

                        if(!is_exeed){
                            if(total >  (transaction_amount_cash + transaction_amount_debit)){
                            $(this).val((value - total + (transaction_amount_cash + transaction_amount_debit)).toFixed(2)).trigger('change');
                            is_exeed = true;
                        }
                        }else{
                            $(this).val((0).toFixed(2)).trigger('change');
                        }
                    });
                    calculateTotalAmount();
                } else {
                    $('#debit_acc_summary_line_1, #debit_acc_summary_line_2').html('');

                    let total = 0;
                    let is_exeed = false;

                    $('#selectedInvoiceTr').find('tr td .invoice_payment_amount').each(function () {
                        let value = parseFloat($(this).val()) || 0;
                        total += value;

                        if(!is_exeed){
                            if(total >  (transaction_amount_cash + transaction_amount_debit)){
                            $(this).val((value - total + (transaction_amount_cash + transaction_amount_debit)).toFixed(2)).trigger('change');
                            is_exeed = true;
                        }
                        }else{
                            $(this).val((0).toFixed(2)).trigger('change');
                        }
                    });
                    calculateTotalAmount();

                }
            }

            if (transaction_amount_cash == total_paid_amount) {
                console.log('Payment settled');
                // $('#transaction_amount_debit').prop('readonly', true);
                $('#debit_acc_summary_line_1, #debit_acc_summary_line_2').html('');
            }

            $(".se-pre-con").fadeOut('slow');
        }



        function calculateTotalAmount() {
            var totalAmount = 0;
            $('.invoice_payment_amount').each(function() {
                var amount = parseFloat($(this).val());
                if (!isNaN(amount)) {
                    totalAmount += amount;
                }
            });
            // $('#total_paid_amount').val(totalAmount.toFixed(2));
            if ($('#transaction_amount_cash').val() > totalAmount) {
                $('#transaction_amount_cash').val(totalAmount.toFixed(2));
            }
        }

        $(document).on('input', '.invoice_payment_amount', function() {
            calculateTotalAmount();
        });

        $('#confirmGroupPay').click(function(e) {
            $(".se-pre-con").fadeIn('slow');
            e.preventDefault();

            var formData = new FormData($('#multiplePayForm')[0]);

            $.ajax({
                url: "{{ route('do_pay_multiple_invoice') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    $('#payMultipleModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });

            $(".se-pre-con").fadeOut('slow');
        });


        calculateTotalAmount();

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

                if (!invoice) {
                    console.log('Invoice data is missing or invalid.');
                    return;
                }

                updateInvoiceFields(invoice);
                updateAdditionalFields(additionalData);
                handleInvoiceStatus(invoice);

                // Set form action and display modal
                $('#invoice_form').attr('action', `invoice/approve/${invoice.id}`);
                $('#generate_invoice').modal('show');
            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
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

    function handleInvoiceStatus(invoice) {
        var status = parseInt(invoice.status, 10);

        if (status === 1 || status === 3 || status === 5) {
            $('#frm_submit_btn').hide();
            $('#frm_submit_btn_save').hide();
        } else {
            $('#frm_submit_btn').show();
            $('#frm_submit_btn_save').show();
        }

        if (status === 0|| status === 4) {
            createActionButton('Delete', 'delete btn-danger', 'delete', invoice.id);
        }else{
            if($('button.delete').length> 0){
                $('button.delete').remove();
            }
        }

        if (status === 1 || status === 2 || status === 5) {
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

        get_invoice_data(invoiceId); // Call the function to get invoice data
    });

    $('#payMultipleModal').on('hidden.bs.modal', function (e) {
        location.reload();
    });
});
</script>
@endsection
