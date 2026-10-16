<style>
.select2.order_number2 + .select2-container {
    width: 100% !important;
}
.select_invoice {
    border: 1px solid rgb(231, 231, 231) !important;
}
/* .select2-container {
    pointer-events: none;
    touch-action: none;
} */

</style>

<div class="modal fade " id="group_invoice" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-xl" style="max-width: 1300px;" role="document">
        <div class="modal-content modal-content-2">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-create" style="position: relative; left: 42%;">GROUP INVOICE </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('group_approval')}}" method="post" id="group_approval">
                @csrf

                <div style="padding: 20px;">
                    <div class="select_invoice">
                        <select class="select2 order_number2" name="invoice_ids" id="order_number2" multiple="multiple" >
                            @foreach ($groupInvoices as $invoice)
                                    <option value="{{ $invoice->id }}">{{ $invoice->invoice_number }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="modal-body">
                        <div class="col-md-12 form-field mt-3">
                            <div class="col-md-6">
                                <h5>SHIPPER</h5><hr class="hr-style">
                                <p class="address-style" id="shipper-name1"></p>
                                <p class="address-style" id="shipper-street1"></p>
                                <p class="address-style" id="shipper-city1"></p>
                                <p class="address-style" id="shipper-postal-code1"></p>
                                <p class="address-style" id="shipper-country1"></p>
                                <p class="address-style" id="shipper"></p>
                                <p class="address-style" id="shipper"></p>
                            </div>

                        </div>

                        <div class="col-md-12 mt-3">


                            <div class="modal-body1">
                                <table style="border: 1px solid;" id="order-items-table1">
                                    <thead class="bg-color">
                                        <th class="table-header" style="width: 8.5%">INVOICE NO</th>
                                        <th class="table-header" style="width: 13.5%">ORDER NO</th>
                                        <th class="table-header" style="width: 7.5%">COMPANY INVOICE</th>
                                        <th class="table-header" style="width: 5.5%">TOTAL AMOUNT ($)</th>
                                    </thead>

                                    <tbody></tbody>

                                    <tfoot>
                                        <th colspan="3" class="table-header" style="height: 35px; color: gray; font-weight: bold;">TOTAL AMOUNT</th>
                                        <th class="total_amount table-header" id="total_amount" style="height: 35px; color: gray; font-weight: bold;"></th>
                                    </tfoot>
                                </table>
                            </div>
                            <hr class="bottom-hr">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button id="download-pdf-btn-1" class="btn btn-warning btn-custom" type="button">Download PDF</button>
                        <button class="btn btn-secondary btn-custom"  type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="submit" id="frm_submit_btn" class="btn btn-success group_submit_btn_all btn-custom frm_submit_btn send_for_approval" onclick="submitInvoiceForm()">Approve Invoice</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>




<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>


<script>

$('#group_invoice').on('hidden.bs.modal', function (e) {
            location.reload();
        });


var originalTitle = '';

document.getElementById('download-pdf-btn-1').addEventListener('click', function() {

    var selectElement = document.getElementById('order_number2');
    var selectedOption = selectElement.options[selectElement.selectedIndex];

    var selectedDisplayText = selectedOption.textContent;

    var originalButtonStyles = [];
    var buttons = document.querySelectorAll('.btn');
    buttons.forEach(function(button) {
        originalButtonStyles.push({
            button: button,
            display: button.style.display,
            position: button.style.position
        });
        button.style.display = 'none';
        button.style.position = 'absolute';
    });



    generateAndDownloadPDF1(selectedDisplayText);



    originalButtonStyles.forEach(function(styleObj) {
        styleObj.button.style.display = styleObj.display;
        styleObj.button.style.position = styleObj.position;
    });
});


function generateAndDownloadPDF1(orderNumber) {
    var modalContent = document.querySelector('.modal-content-2');

    var customWidth = 1000;
    var customHeight = 1000;

    var pdf = new jsPDF('l', 'mm', [customWidth, customHeight]);

    var currentY = 20; // Start a bit lower to give space for the order number

    var pageHeight = pdf.internal.pageSize.height;

    // Add the order number at the top of the PDF content
    pdf.text("Invoice Number: " + orderNumber, 10, currentY);

    function captureContent(startY) {
        html2canvas(modalContent, {
            windowWidth: modalContent.scrollWidth,
            windowHeight: pageHeight,
            scrollY: startY
        }).then(function(canvas) {
            var contentWidth = pdf.internal.pageSize.width;
            var contentHeight = canvas.height * contentWidth / canvas.width;

            var selectElement = document.getElementById('order_number2');
            var selectedOption = selectElement.options[selectElement.selectedIndex];

            var selectedDisplayText = selectedOption.textContent;

            pdf.addImage(canvas, 'PNG', 10, currentY + 10, contentWidth - 20, contentHeight); // Adjust Y position

            currentY += contentHeight + 20; // Increase the offset for spacing

            if (currentY < contentHeight) {
                captureContent(currentY);
            } else {
                pdf.save('invoice-'+selectedDisplayText+'.pdf');
            }
        });
    }

    captureContent(currentY);
}


$(document).ready(function () {
    $('#group_invoice').on('shown.bs.modal', function () {
        $('.order_number2').select2({
            placeholder: "Select orders",
        }).on('change', function (e) {
            var selectedInvoiceIds = $(this).val();
            updateInvoiceDetails(selectedInvoiceIds);
        });

        // Call the updateInvoiceDetails function once initially to load details for already selected items
        var initialSelection = $('#order_number2').val();
        if (initialSelection && initialSelection.length > 0) {
            updateInvoiceDetails(initialSelection);
        }
    });

    function updateInvoiceDetails(selectedItems) {
        var tableBody = $('#order-items-table1 tbody');
        var totalAmount = 0;
        var completedRequests = 0;

        tableBody.empty();

        selectedItems.forEach(function (invoiceId) {
            $.ajax({
                url: '{{ route('get-order-details2') }}',
                method: 'GET',
                data: { invoice_id: invoiceId },
                success: function (response) {
                    var invoice = response.invoice;
                    var order = response.order;

                    var row = `
                        <tr>
                            <td class="table-bottom-details2"><a href="#" class="edit" data-value=${invoice.id}>${invoice.invoice_number}</a></td>
                            <td class="table-bottom-details2">${order.order_no}
                                <input type="hidden" name="order_no[]" class="order_no" value=${order.id}>
                            </td>
                            <td class="table-bottom-details2">${invoice.company_invoice}</td>
                            <td class="table-bottom-details2">${invoice.total_amount}</td>
                        </tr>
                    `;
                    tableBody.append(row);

                    totalAmount += parseFloat(invoice.total_amount);
                    $('#total_amount').text(totalAmount.toFixed(2));

                    completedRequests++;

                    if (completedRequests === selectedItems.length) {
                        // Update shipper details if needed
                        var containerElement = $('#shipper-name1');
                        var factories = response.factories;
                        var targetFactory = factories.find(factory => factory.id == 1);
                        if (targetFactory) {
                            var factoryName = targetFactory.factory_name;
                            var factoryStreet = targetFactory.street;
                            var factoryCity = targetFactory.city;
                            var factoryPostalCode = targetFactory.postal_code;
                            var factoryCountry = targetFactory.country;

                            containerElement.text(factoryName);
                            $('#shipper-street1').text(factoryStreet);
                            $('#shipper-city1').text(factoryCity);
                            $('#shipper-postal-code1').text(factoryPostalCode);
                            $('#shipper-country1').text(factoryCountry);
                        }
                    }
                },
                error: function (error) {
                    console.log(error);
                    completedRequests++;
                }
            });
        });
    }


        var orderNumberHasBeenSet = false;
        $('#order-items-table1').on('click', '.edit', function (e) {
            e.preventDefault();

            // reset();

            $(".se-pre-con").fadeIn('slow');
            $('#modal-title-create').text('GROUP INVOICE');
            $('.frm_submit_btn').text('Update');
            $('.close1').removeClass('close');

            event.preventDefault();
            var invoiceId = $(this).data('value');
            $('#new_invoice_no').val(invoiceId);

            var selectedInvoiceId = invoiceId;

            $('#generate_invoice').attr('data-selected-invoice-id', selectedInvoiceId);
            console.log(selectedInvoiceId);
            $.ajax({
                url: '{{ url('invoice/edit') }}/' + invoiceId,
                method: 'GET',
                cache: false,
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data) {

                    var invoice = data.invoice;
                    var additionData = data.additional;

                    var invoiceA = invoice[0];

                    var invoiceId = parseInt(invoiceA.id, 10);
                        console.log(data);

                    for (var i = 0; i < additionData.length; i++) {
                        var additionPaymentId = additionData[i].addition_payment_id;
                        var additionValue = additionData[i].amount;
                        var otherReason = additionData[i].if_other_reson;

                        var additionalInput = document.getElementById('addition_value_' + additionPaymentId);
                        if (additionalInput) {
                            additionalInput.value = additionValue;
                        }

                        var additionalIdSpan = document.querySelector('.addition_id[data-value="' + additionPaymentId + '"]');
                        if (additionalIdSpan) {
                            additionalIdSpan.setAttribute('data-value', additionPaymentId);
                        }

                        var otherResonInput = document.querySelector('.other-reson[name="other_reson[' + additionPaymentId + ']"]');
                        if (otherResonInput) {
                            otherResonInput.value = otherReason || '';
                        }
                    }

                    $('#company_invoice').val(invoiceA.company_invoice);
                    $('#new_invoice_no').val(invoiceA.id);
                    $('#invoice_no').val(invoiceA.invoice_number);
                    $('#total_value').val(invoiceA.total_amount);
                    $('#reduce_value_input').val(invoiceA.reduce_value);

                    if (!orderNumberHasBeenSet) {
                        $('#order_number').val(invoiceA.order_id).change();
                        orderNumberHasBeenSet = true;
                    }

                    $('#order_number').prop('disabled', true);


                    var statusInt = parseInt(invoiceA.status, 10);

                    if (statusInt === 1) {
                        $('#frm_submit_btn').hide();
                    } else {
                        $('#frm_submit_btn').show();
                    }

                    if (statusInt === 0) {
                        if ($('.delete').length === 0) {
                            var deleteButton = document.createElement('button');
                            deleteButton.className = 'delete btn-danger btn-custom frm_delete_btn btn';
                            deleteButton.setAttribute('data-value', invoiceId);
                            deleteButton.textContent = 'Delete';

                            var updateButton = document.querySelector('.frm_submit_btn');
                            updateButton.parentNode.insertBefore(deleteButton, updateButton.nextSibling);
                        }
                    }

                    if (statusInt === 0) {
                        if ($('.sendApproval').length === 0) {
                            var sendApprovalButton = document.createElement('button');
                            sendApprovalButton.className = 'sendApproval btn-info btn-custom frm_sendApproval_btn btn';
                            sendApprovalButton.setAttribute('data-value', invoiceId);
                            sendApprovalButton.textContent = 'Approve Invoice';

                            var sendButton = document.querySelector('.frm_submit_btn');
                            sendButton.parentNode.insertBefore(sendApprovalButton, sendButton.nextSibling);
                        }
                    }

                    $('#generate_invoice').modal('show');
                    $('#generate_invoice').appendTo('body');
                    $('#generate_invoice').css('z-index', '1050');
                },
                complete: function() {
                    $(".se-pre-con").fadeOut('slow');
                },

                error: function (error) {
                    console.log('Error fetching invoice data:', error);
                }
            });
        });
    // });

    $('#group_approval').submit(function(event) {
            event.preventDefault();

            var selectedInvoiceIds = $('#order_number2').val();

            for (var i = 0; i < selectedInvoiceIds.length; i++) {
                $(this).append('<input type="hidden" name="invoice_ids[]" value="' + selectedInvoiceIds[i] + '">');
            }

            $(this).unbind('submit').submit();
        });

});


</script>

