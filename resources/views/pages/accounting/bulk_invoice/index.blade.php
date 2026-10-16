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
    #bulkInvoiceModal .table th, .table td {
        padding: .2rem;
        vertical-align: top;
        border-top: none;
    }
    .modal-2xl {
        max-width: 90%;
        width: auto;
    }
</style>


<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con" style="display: none;"></div>

    @section('order-header')
        <span>BULK INVOICE</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12 new-style-table">
        <div class="card">
                <div class="col-md-12 mt-2">
                    <input type="hidden" id="pay_multiple_invoices" value="" />
                </div>
                <div class="col-md-12 mt-3 mb-3">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="bulk_invoice">
                            <thead>
                                <th scope="col" class="invoice-number text-center text-center">Bulk Invoice Number</th>
                                <th scope="col" class="order-organization text-center">Organization</th>
                                <th scope="col" class="total-amount text-center">Total amount</th>
                                <th scope="col" class="paid-amount text-center">Paid amount</th>
                                <th scope="col" class="amount-to-paid text-center">Amount to paid</th>
                                <th scope="col" class="status text-center">Status</th>
                                <th scope="col" class="created-at text-center">Created At</th>
                            </thead>

                            <tbody>
                                @foreach ($bulk_invoices as $bulk_invoice)
                                    <tr>
                                        <td class="text-center">
                                            <a class="edit-bulk-inv" href="" data-inv-id="{{$bulk_invoice['invoice']->id}}" style="color:black">
                                                BULK-INV-{{ str_pad($bulk_invoice['invoice']->id, 6, '0', STR_PAD_LEFT) }}
                                            </a>
                                        </td>
                                        <td class="text-left">
                                            <input type="hidden" id="hidden_invoices_{{$bulk_invoice['invoice']->id}}" value="{{$bulk_invoice['invoice']->order_ids}}">
                                            {{$bulk_invoice['invoice']->organizationDetails->organization_name}}
                                        </td>

                                        @php
                                            $totalOrderAmount = 0;
                                            $totalPaidAmount = 0;

                                            foreach($bulk_invoice['order'] as $orderData) {
                                                $totalOrderAmount += $orderData['order']->order_total ?? 0;
                                                $totalPaidAmount += $orderData['paid_amount'] ?? 0;
                                            }

                                            $remainingAmount = $totalOrderAmount - $totalPaidAmount;
                                        @endphp

                                        <td class="text-right">
                                            {{ number_format($totalOrderAmount, 2) }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($totalPaidAmount, 2) }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($remainingAmount, 2) }}
                                        </td>
                                        <td>
                                            @if ($bulk_invoice['invoice']->payment_status == 0)
                                                <span class="badge badge-pill" style="color:black;background-color:#d1c8d6;width:100%">Pending</span>
                                            @elseif ($bulk_invoice['invoice']->payment_status == 1)
                                                <span class="badge badge-pill" style="color:black;background-color:#4be5c4;width:100%">Paid</span>
                                            @else
                                                <span class="badge badge-pill" style="color:black;background-color:#bce05e;width:100%">Partial</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{$bulk_invoice['invoice']->created_at->format('m/d/Y')}}
                                        </td>
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
<!-- Modal Structure -->
<div class="modal fade" id="bulkInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="bulkInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-2xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bulkInvoiceModalLabel">Bulk Invoice Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <input type="hidden" id="bulk_invoice_id">
        <div class="modal-body" id="bulkInvoiceContent"> </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="bulkMarkAspaid">Mark as paid</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Payment Received Modal -->
<div class="modal fade" id="paymentReceivedModal" tabindex="-1" role="dialog" aria-labelledby="paymentReceivedModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form>
          @csrf <!-- Include CSRF token for security -->
          <div class="modal-header">
            <h5 class="modal-title" id="paymentReceivedModalLabel">Payment Received</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="pay_multiple_invoices_bulk" value="">
            <!-- Image upload section -->
            <div class="form-group">
              <label for="payment_image">Upload Payment Image</label>
              <input type="file" class="form-control-file" id="payment_image" name="payment_image" accept="image/*">
            </div>

            <!-- Image preview -->
            <div class="form-group">
              <img id="imagePreview" src="#" alt="Payment Image Preview" style="max-width: 100%;display:none; height: auto;" />
            </div>

            <!-- Description textarea -->
            <div class="form-group">
              <label for="description">Payment Description</label>
              <textarea class="form-control" name="description" id="other_payment_description" rows="3" placeholder="Enter a description of the payment" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="submit_payment_received" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<script>
    $(document).ready(function() {
        $('#payment_image').change(function(event) {
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result);
                    $('#imagePreview').show();
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
    });
    $(document).ready(function () {

        var generated_invoice = $('#bulk_invoice').DataTable({
            colReorder: false,
            scrollX: true,
            stateSave: true,
            "autoWidth": false,
            "pageLength": 50,
            "bSort" : false,
            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'Bulk invoice search'
            }
        });

        $('.edit-bulk-inv').on('click', function(event) {
            event.preventDefault();
            var invId = $(this).data('inv-id');
            console.log(invId);

            $.ajax({
                url: "{{ route('get_bulk_invoice_details') }}",
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    inv_id: invId,
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function(response) {

                    if(response){
                        $('#bulk_invoice_id').val(response.bulk_invoice.id);
                    }else{
                        $('#bulk_invoice_id').val('');
                        return;
                    }

                    console.log(response);

                    var bulk_invoice_id = response.bulk_invoice.id;
                    var order_ids_string = response.bulk_invoice.order_ids;
                    var organization = response.bulk_invoice.organization_details;
                    var orders_details = Object.values(response.orders);
                    const createdAt = new Date(response.bulk_invoice.created_at);

                    if(response.bulk_invoice.payment_status == 1){
                        $('#bulkMarkAspaid').hide();
                    }else{
                        $('#bulkMarkAspaid').show();
                    }

                    let modalBody = `
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <img src="{{ asset('argon') }}/img/encore/logo1.png" height="150px">
                                </div>
                                <div class="col-lg-6">
                                    <h3 class="page-title text-danger text-right">INVOICE</h3>
                                    <h5 class="text-right encore-address" style="margin-bottom: 0rem;">Encore Custom</h5>
                                    <h5 class="text-right encore-address" style="margin-bottom: 0rem;">891 4th st.</h5>
                                    <h5 class="text-right encore-address" style="margin-bottom: 0rem;">San Rafael, CA 94901</h5>
                                </div>

                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <th>Bulk Invoice No :</th>
                                            <td><h5>BULK-INV-${bulk_invoice_id.toString().padStart(6, '0')}</h5></td>
                                        </tr>
                                        <tr>
                                            <th>Date # :</th>
                                            <td><h5>${String(createdAt.getMonth() + 1).padStart(2, '0')}/${String(createdAt.getDate()).padStart(2, '0')}/${createdAt.getFullYear()}</h5></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <hr class="page-divider">

                        <input type="hidden" id="organization_name" value="${organization.organization_name}">

                        <div class="col-lg-12 mb-1">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr><th>Organization Details:</th></tr>
                                        <tr><td><h5>${organization.organization_name}</h5></td></tr>
                                        <tr><td><h5>${organization.shipping_street}</h5></td></tr>
                                        <tr><td><h5>${organization.shipping_city} ${organization.shipping_state} ${organization.shipping_postal_code}</h5></td></tr>
                                        <tr><td><h5>${organization.shipping_country}</h5></td></tr>
                                        <tr><td><h5>${organization.website}</h5></td></tr>
                                        <tr><td><h5>${organization.email}</h5></td></tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-md-12">
                                    <table class="table" id="invoice_items">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 10%;">ORDER NO</th>
                                                <th class="text-center">CONTACT PERSON</th>
                                                <th class="text-center">EST DELIVERY</th>
                                                <th class="text-center">SUB TOTAL($)</th>
                                                <th class="text-center">PAID AMOUNT($)</th>
                                                <th class="text-center">AMOUNT TO PAY($)</th>
                                                <th class="text-center">PAYMENT STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody>`;
                    var orders_sub_total = 0;
                    var orders_paid_amount = 0;

                    orders_details.forEach(order => {
                        var payment_status = '';
                        if(Number(order.order.order_total) > Number(order.paid_amount)){
                            if(Number(order.paid_amount) > 0){
                                payment_status = `<span class="badge badge-pill" style="color:black;background-color:#bce05e;width: fit-content;">Partial</span>`;
                            }else{
                                payment_status = `<span class="badge badge-pill" style="color:black;background-color:#d1c8d6;width: fit-content;">Pending</span>`;
                            }

                        }else if(Number(order.order.order_total) == Number(order.paid_amount)){
                                payment_status = `<span class="badge badge-pill" style="color:black;background-color:#4be5c4;width: fit-content;">Paid</span>`;
                        }

                        modalBody += `
                            <tr>
                                <td><h5 class="text-center"><a style="color:black !important" href="#" class="edit-order" data-value="${order.order.id}">${order.order.order_no}</a></h5></td>
                                <td><h5 class="text-center">${order.order.contact_details.first_name} ${order.order.contact_details.last_name}</h5></td>
                                <td><h5 class="text-center">${order.order.est_delivery_date ?? ''}</h5></td>
                                <td><h5 class="text-right">${Number(order.order.order_total).toFixed(2)}</h5></td>
                                <td><h5 class="text-right">${Number(order.paid_amount).toFixed(2)}</h5></td>
                                <td><h5 class="text-right">${(order.order.order_total - order.paid_amount).toFixed(2)}</h5></td>
                                <td class="text-center">${payment_status}</td>
                            </tr>`;

                            orders_sub_total += Number(order.order.order_total);
                            orders_paid_amount += Number(order.paid_amount);
                    });

                    modalBody += `
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>`;
                    modalBody += `
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h1 class="main-htag mt-4">Thank you for your business!</h1>
                                        </div>
                                        <div class="col-md-12 mt-4 text-center">
                                            <img src="{{ asset('argon') }}/img/encore/logo_dark.png" class="navbar-brand-img imagesize" id="logo_large" alt="..." width="350px">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <table class="table" id="invoice_summary">
                                        <tr>
                                            <th class="text-left">SUBTOTAL ($) :</th>
                                            <td><h5 class="text-right">${Number(orders_sub_total).toFixed(2)}</h5></td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">PAID AMOUNT ($) :</th>
                                            <td><h5 class="text-right">${Number(orders_paid_amount).toFixed(2)}</h5></td>
                                        </tr>
                                        <tr>
                                            <th class="total text-left">AMOUNT TO PAY ($) :</th>
                                            <td><h5 class="text-right" style="font-weight: bold; font-size: large;">${Number((orders_sub_total - orders_paid_amount)).toFixed(2)}</h5></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>`;

                    $('#bulkInvoiceContent').html(modalBody);
                    $('#bulkInvoiceModal').modal('show');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });

        });

        $("body").on("click", ".edit-order", function(){
            var orderId = $(this).data('value');
            window.open('order_details/edit/'+orderId+'/order?active_tab=order', '_blank');
        });

        $('#bulkMarkAspaid').on('click', function() {
            console.log($('#bulk_invoice_id').val());
            var bulk_invoice_id = $('#bulk_invoice_id').val();

            $('#imagePreview').attr('src', '');
            $('#payment_image').val('');

            var invoices = $('#hidden_invoices_'+bulk_invoice_id).val();

            $('#pay_multiple_invoices_bulk').val(invoices);

            $('#imagePreview').hide();
            $('#paymentReceivedModal').modal('show');
        });

        $('#submit_payment_received').click(function(e) {
            e.preventDefault();

            var arrayData = $('#pay_multiple_invoices_bulk').val();
            var invoiceArray = arrayData.split(',').map(function(item) {
                return item.trim();
            });

            var paymentImage = $('#payment_image')[0].files[0];
            var paymentDescription = $('#other_payment_description').val();

            if (!paymentDescription) {
                Swal.fire(
                    'Incomplete Form',
                    'Please enter a description.',
                    'warning'
                );
                return;
            }

            var formData = new FormData();
            formData.append('payment_image', paymentImage);
            formData.append('description', paymentDescription);
            formData.append('invoices', invoiceArray);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: "{{ route('order_mark_as_paid') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function(response) {
                    $(".se-pre-con").fadeOut('slow');
                    Swal.fire(
                        'Payment Submitted!',
                        'The payment has been successfully submitted.',
                        'success'
                    );
                    $.ajax({
                        url: "{{ route('pay_bulk_invoice') }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            bulk_invoice_id: $('#bulk_invoice_id').val(),
                        },
                        beforeSend: function () {
                            $(".se-pre-con").fadeIn('slow');
                        },
                        success: function(response) {
                            console.log(response);
                            $('#bulkInvoiceModal').modal('hide');
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                },
                error: function(xhr, status, error) {
                    $(".se-pre-con").fadeOut('slow');
                    Swal.fire(
                        'Error!',
                        'There was an error processing the payment. Please try again.',
                        'error'
                    );
                }
            });
        });
    });
</script>
@endsection
