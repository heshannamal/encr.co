@extends('layouts.app', ['activePage' => 'all_invoice', 'titlePage' => __('All Invoices')])

@section('content')
<style>
     .table-responsive .table tbody td , .table-responsive .table tbody td a {
        padding: 0.4rem 1rem !important;
        font-size: .9rem !important;
        color: rgba(22, 22, 23, 1) !important;
    }
    .date_p {
        margin: unset;
        font-size: 11px;
        color: black;
        font-weight: 500;
    }
    .date_selection {
        background-color: transparent;
        padding: unset;
        border: unset;
        color: #47D6B6;
        font-size: 11px;
    }
    .select2-selection--single{
        background-color: #F8F8F8 !important;
    }
    .select-width-style .select2.select2-container.select2-container--default{
        width: 8rem !important;
    }
    .select-width-style-item .select2.select2-container.select2-container--default{
        width: 10rem !important;
    }
    .filter_row {
        margin-left: unset;
        padding: 2px 9px 2px 8px;
        background-color: #F8F8F8;
        border: 1px solid #DEDEDE;
        border-radius: 5px;
    }

    .d_flex_and_align_center {
        display: flex;
        align-items: center;
    }

    .date_selection {
        background-color: transparent;
        padding: 0;
        border: none;
        color: #47D6B6;
        font-size: 11px;
    }

    .date_p {
        margin: 0;
        font-size: 11px;
        color: black;
        font-weight: 500;
    }

    .filter_btn {
        padding: 5px;
        width: 70px;
        background-color: #2dce89;
        border: none;
        color: white !important;
        cursor: pointer;
    }
    .page-item .page-link, .page-item span {
        border-radius: 0 !important;
        font-size: 0.7rem;
    }
    .page-item.active .page-link {
        z-index: 1;
        color: grey;
        border-color: #cccccc;
        background-color: #e9e9e9;
        box-shadow:none;
    }
    .table tbody td {
        padding-top: 7.5px;
        padding-bottom: 7.5px;
    }
    .table thead th {
        color: white;
        height: 40px;
        padding-top: 0;
        padding-bottom: 0;
    }
    table.dataTable thead .sorting:before, table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:before, table.dataTable thead .sorting_desc_disabled:after {
        bottom: 0.6rem !important;
    }
    table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
        right: .7rem !important;
    }
    table.dataTable thead .sorting:before, table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:before, table.dataTable thead .sorting_desc_disabled:after {
    bottom: .65em;
    }
    table.dataTable thead .sorting:before,table.dataTable thead .sorting_asc:before,table.dataTable thead .sorting_desc:before,table.dataTable thead .sorting_asc_disabled:before,table.dataTable thead .sorting_desc_disabled:before {
        content: "\f0de";
        font-family: FontAwesome;
    }
    table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:after,table.dataTable thead .sorting_asc_disabled:after,table.dataTable thead .sorting_desc_disabled:after {
        content: "\f0dd";
        font-family: FontAwesome;
        right: .65rem !important;
    }

</style>
<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con" style="display: none;"></div>

        @section('order-header')
            <span>ALL INVOICES</span>
        @endsection

        @section('back-btn')
            <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
        @endsection

        <div class="col-md-12 new-style-table">
            <div class="card">
                <div class="col-md-12 mt-2">
                    <form id="AllInvoice_filter_form">
                        @csrf
                        <div class="row mt-2">
                            <div class="row mx-4 pb-2">
                                {{-- Factory Filter --}}
                                <div class="filter_row d_flex_and_align_center mr-2">
                                    <p class="date_p">FACTORY |</p>
                                    <div class="date_selection select-width-style ps-2">
                                        <select id="Factory_filter" name="Factory_filter" class="summary-select2">
                                            <option value="1">DWC</option>
                                            {{-- @foreach ($factories as $factory)
                                                <option value="{{ $factory->id }}">{{ $factory->factory_code }}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>

                                {{-- Invoice Status Filter --}}
                                <div class="filter_row d_flex_and_align_center mr-2">
                                    <p class="date_p">STATUS |</p>
                                    <div class="date_selection select-width-style ps-2">
                                        <select id="invoice_filter" name="invoice_filter" class="summary-select2">
                                            <option value="all">All</option>
                                            <option value="Payble">Payble Invoice</option>
                                            <option value="Generated">Generated Invoice</option>
                                            <option value="Paid">Paid Invoice</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Start Date --}}
                                <div class="filter_row d_flex_and_align_center mr-2">
                                    <p class="date_p ps-1">Start Date |</p>
                                    <div class="date_selection ps-2">
                                        <input type="text" name="start_date" id="start_date" class="summary-datepicker invoice-inputs" style="height: 2rem;background-color: #F8F8F8;">
                                    </div>
                                </div>

                                {{-- End Date --}}
                                <div class="filter_row d_flex_and_align_center mr-2">
                                    <p class="date_p ps-1">End Date |</p>
                                    <div class="date_selection ps-2">
                                        <input type="text" name="end_date" id="end_date" class="summary-datepicker invoice-inputs" style="height: 2rem;background-color: #F8F8F8;">
                                    </div>
                                </div>

                                {{-- Filter Button --}}
                                <div class="d_flex_and_align_center ml-2">
                                    <button class="filter_btn date_p" type="button" id="pin-filter" title="Filter" style="height: 100%;">
                                        <i class="fa fa-filter"></i>&nbsp;&nbsp;Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-12 mt-2 sec-download-multiple-invoices" style="display: none;">
                    <div class="row">
                        <div class="col-md-6 text-left">
                            <button class="download_multiple_invoices ml-2" style="    background-color: #27cde8;color: white;border: none;padding: .2rem .5rem;border-radius: .5rem;">Download Invoices</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-3 mb-3">
                    <div class="">
                        <table class="table align-items-center table-responsive" id="all_invoice" style="width: 100%">
                            <thead style="background-color: #717070;">
                                <th scope="col">
                                    <input type="checkbox" class="checkbox_of_all_invoice"/>
                                </th>
                                <th scope="col" class="invoice-number text-center text-center">Invoice No</th>
                                <th scope="col" class="order-number text-center">Order #</th>
                                <th scope="col" class="organization text-center">Organization</th>
                                <th scope="col" class="status text-center">Status</th>
                                <th scope="col" class="Total_amount-to-paid text-center">Total Amount</th>
                                <th scope="col" class="paid_amount text-center">Paid Amount</th>
                                <th scope="col" class="created-at text-center">Created At</th>
                                <th scope="col" class="updated-at text-center">Updated At</th>
                            </thead>

                            <tbody>
                                @foreach ($factoryinvoices as $factoryinvoice)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkbox_of_invoice" data-value="{{ $factoryinvoice->order_id }}" />
                                    </td>
                                    <td class="invoice-number"><a href="#" class="edit" data-value="{{ $factoryinvoice->id }}">{{ $factoryinvoice->invoice_number }}</a></td>
                                    <td class="order-number">
                                        <a href="{{ route('orders.info', ['id' => $factoryinvoice->order_id, 'type' => 'order']) }}?active_tab=order" target="_blank">
                                            {{  str_pad($factoryinvoice->order_id, 6, '0', STR_PAD_LEFT)  }}
                                        </a>
                                    </td>
                                    <td class="order-organization">{{$factoryinvoice->orderDetails ? $factoryinvoice->orderDetails->organizationDetails->organization_name : ''}}</td>
                                    <td class="status text-center">
                                        @if($factoryinvoice->status == 0 || $factoryinvoice->status == 2)
                                            <span class="badge badge-pill" style="color:#073180;background-color:#b2d0f8;width:100%">Genarated Invoice</span>
                                        @elseif($factoryinvoice->status == 1)
                                            <span class="badge badge-pill" style="color:#c8d647;background-color:#fffecc;width:100%">Payble Invoice</span>
                                        @elseif($factoryinvoice->status == 4)
                                            <span class="badge badge-pill" style="color:#d65a47;background-color:#ffcccc;width:100%">Rejected</span>
                                        @else
                                            <span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:100%">Paid Invoice</span>

                                        @endif
                                    </td>
                                    <td class="total-amount text-right">{{$factoryinvoice->total_amount}}</td>
                                    <td class="paid-amount text-right">{{$factoryinvoice->paid_amount}}</td>
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
@include('pages.accounting.generate_invoice.create')
<script>
    $(document).ready(function () {
        $('#pin-filter').on('click', function() {
            make_invoice_table();
        });

        $('.summary-select2').select2();
        $('.summary-datepicker').datepicker();

        var generated_invoice = $('#all_invoice').DataTable({
            pageLength: 50,
            responsive: true,
            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'All invoice search'
            },
            columnDefs: [
                {
                    targets: [7, 8],
                    type: 'date'
                }
            ]
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

            // if (status === 1 || status === 3) {
                $('#frm_submit_btn').hide();
                $('#frm_submit_btn_save').hide();
            // } else {
                // $('#frm_submit_btn').show();
            // }

            if (status === 0|| status === 4) {
                createActionButton('Delete', 'delete btn-danger', 'delete', invoice.id);
            }else{
                if($('button.delete').length> 0){
                    $('button.delete').remove();
                }
            }

            // if (status === 1 || status === 2) {
            //     createActionButton('Pay', 'payed btn-warning', 'payed', invoice.id);
            // }else{
                // if($('button.payed').length> 0){
                    $('button.payed').remove();
                // }
            // }
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

        function make_invoice_table() {
            $('.se-pre-con').fadeIn();
            var formData = new FormData($('#AllInvoice_filter_form')[0]);

            $.ajax({
                url: "{{ route('get_all_invoice_data') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    updateTable(response.factoryinvoices);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function getOrderInfoUrl(orderId, type = 'order') {
            const baseRoute = @json(route('orders.info', ['id' => '__ORDER_ID__', 'type' => '__TYPE__']));
            return baseRoute.replace('__ORDER_ID__', orderId).replace('__TYPE__', type);
        }

        function updateTable(invoices) {
            var table = $('#all_invoice').DataTable();
            table.clear(); // Clear current table

            invoices.forEach(function(invoice) {
                let statusBadge = '';
                if (invoice.status == 0 || invoice.status == 2) {
                    statusBadge = `<span class="badge badge-pill" style="color:#073180;background-color:#b2d0f8;width:100%">Generated Invoice</span>`;
                } else if (invoice.status == 1) {
                    statusBadge = `<span class="badge badge-pill" style="color:#c8d647;background-color:#fffecc;width:100%">Payable Invoice</span>`;
                } else if (invoice.status == 4) {
                    statusBadge = `<span class="badge badge-pill" style="color:#d65a47;background-color:#ffcccc;width:100%">Rejected</span>`;
                } else {
                    statusBadge = `<span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:100%">Paid Invoice</span>`;
                }

                table.row.add([
                    `<a href="#" class="edit" data-value="${invoice.id}">${invoice.invoice_number}</a>`,
                    `<a href="${getOrderInfoUrl(invoice.order_id)}?active_tab=order" target="_blank">${String(invoice.order_id).padStart(6, '0')}</a>`,
                    invoice.order_details?.organization_details?.organization_name ?? '',
                    `<div class="text-center">${statusBadge}</div>`,
                    `<div class="text-right">${invoice.total_amount}</div>`,
                    `<div class="text-right">${invoice.paid_amount}</div>`,
                    invoice.created_at ? moment(invoice.created_at).format('MM/DD/YYYY') : '',
                    invoice.updated_at ? moment(invoice.updated_at).format('MM/DD/YYYY') : ''
                ]);
            });

            table.draw(); // Redraw table
            $('.se-pre-con').fadeOut();
        }

        $(document).on('change', '.checkbox_of_all_invoice', function() {
            $('.checkbox_of_invoice').prop('checked', $(this).prop('checked'));
            toggleDownloadSection();
        });

        $(document).on('change', '.checkbox_of_invoice', function() {
            if ($('.checkbox_of_invoice:checked').length === $('.checkbox_of_invoice').length) {
                $('.checkbox_of_all_invoice').prop('checked', true);
            } else {
                $('.checkbox_of_all_invoice').prop('checked', false);
            }
            toggleDownloadSection();
        });
        function toggleDownloadSection() {
            let checkedCount = $('.checkbox_of_invoice:checked').length;
            if (checkedCount > 0) {
                $('.sec-download-multiple-invoices').show();
            } else {
                $('.sec-download-multiple-invoices').hide();
            }
        }
        $(document).on('click', '.download_multiple_invoices', function(e) {
            e.preventDefault();

            let selectedInvoices = [];
            $('.checkbox_of_invoice:checked').each(function() {
                selectedInvoices.push($(this).data('value'));
            });

            if (selectedInvoices.length === 0) {
                Swal.fire({
                    icon: "warning",
                    title: "No invoices selected",
                    text: "Please select at least one invoice to download."
                });
                return;
            }

            // Construct URL with invoice IDs and CSRF token
            const params = new URLSearchParams();
            params.append('_token', "{{ csrf_token() }}");
            selectedInvoices.forEach(id => params.append('invoice_ids[]', id));

            const url = "{{ route('download_multiple_invoices') }}" + '?' + params.toString();

            // Open download in a new tab
            window.open(url, '_blank');
        });
    });
</script>

@endsection
