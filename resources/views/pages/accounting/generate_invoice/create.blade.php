<style>
    .order-number-details{
        background-color: #eeeeee;
    }
    .order-number-font {
        font-size: 12px;
        width: 100px;
    }
    .date-font {
        font-size: 12px;
        color: black;
    }
    .hr-style{
        margin-top: unset !important;
        margin-bottom: unset !important;
    }
    .table-header {
        font-size: 12px;
        color: #eeeeee;
        border: 1px solid #000000;
        padding-left: 7px;
    }
    .bg-color {
        background-color: rgb(98, 98, 255);
    }
    .table-bottom-details {
        font-size: 14px;
        color: black;
        border: 1px solid #000000;
        padding-left: 7px;
        font-weight: 600;
    }
    .table-bottom-details2 {
        font-size: 12px;
        color: black;
        border: 1px solid #000000;
        padding-left: 7px;
    }
    .bottom-hr {
        margin-bottom: unset !important;
        border: 9px solid rgb(98, 98, 255) !important;
    }
    .address-style {
        font-size: 13px !important;
        color: black !important;
        margin-bottom: 2px !important;
        height: 1.5rem;
    }
    .flex-container {
        display: flex;
        align-items: center;
    }

    /* Optional: Add some spacing between the input and "Other" text */
    .other-reson {
        margin-right: 5px;
        border: unset;
        text-align: center;
        width: 62%;
        outline: unset;
    }
    .other-reson1 {
        margin-right: 5px;
        border: unset;
        text-align: center;
        width: 62%;
        outline: unset;
    }
    .other-reson::placeholder {
            color: rgb(255, 0, 0); /* Replace "blue" with your desired color */
    }
    .hide {
        display: none;
    }
    .factory_image {
        height: 155px;
    }
    #reasonTypeModal .modal-dialog {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: calc(100% - 1rem);
    }
    .swal2-title{
        font-size: 1.2rem !important;
    }

</style>


<div class="modal fade " id="generate_invoice" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true" style="z-index: 1051;">
    <div class="modal-dialog modal- modal-dialog-centered modal-xl" style="max-width: 1300px;" role="document">
        <div class="modal-content invoice-modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-create" style="position: relative; left: 42%;">EDIT COMMERCIAL INVOICE </h3>
                <button type="button" class="close close1" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('create_factory_invoice')}}" method="post" id="invoice_form">
                @csrf

                <input type="hidden" name="order_id" id="order_id">

                <div class="order-number-details">
                    <div class="col-md-12  mt-3">
                        <div class="row">
                            <div class="col-md-8">
                                <img class="factory_image" id="factory_image">

                            </div>
                            <div class="col-md-4">
                                <table>
                                    <tr>
                                        <th class="order-number-font">Date</th>
                                        <td>:</td>
                                        <td id="current-date" class="date-font"></td>
                                    </tr>
                                    <tr>
                                        <th class="order-number-font">Club Name</th>
                                        <td>:</td>
                                        <td id="club-name" class="date-font"></td>
                                    </tr>
                                    <tr>
                                        <th class="order-number-font">Order Number</th>
                                        <td>:</td>
                                        <td>
                                            <select class="select2-invoice order_number" name="order_number" id="order_number">
                                                @foreach ($orders as $order)
                                                        <option value="{{ $order->id }}">{{ $order->order_no }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="order-number-font">Invoice Number</th>
                                        <td>:</td>
                                        <td id="invoice_number" class="date-font"> <input class="form-control" type="text" id="invoice_no" name="invoice_no" value="{{ $productNo }}" readonly></td>
                                        <input type="hidden" id="new_invoice_no" name="new_invoice_no" value="">
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 form-field mt-3">
                        <div class="col-md-6">
                            <h5>SHIPPER</h5><hr class="hr-style">
                            <p class="address-style" id="shipper-name"></p>
                            <p class="address-style" id="shipper-street"></p>
                            <p class="address-style" id="shipper-city"></p>
                            <p class="address-style" id="shipper-postal-code"></p>
                            <p class="address-style" id="shipper-country"></p>
                            <p class="address-style" id="shipper"></p>
                            <p class="address-style" id="shipper"></p>
                        </div>
                        <div class="col-md-6">
                            <h5>CONSIGNEE</h5><hr class="hr-style">
                            <p class="address-style" id="organization-name"></p>
                            <p class="address-style" id="shipping-street"></p>
                            <p class="address-style" id="shipping-city"></p>
                            <p class="address-style" id="shipping-postal-code"></p>
                            <p class="address-style" id="shipping-country"></p>
                            <p class="address-style" id="phone"></p>
                            <p class="address-style" id="email"></p>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <table style="border: 1px solid;" id="order-items-table">
                            <thead class="bg-color">
                                <th class="table-header" style="width: 8.5%">PRODUCT NO</th>
                                <th class="table-header" style="width: 13.5%">PRODUCT NAME</th>
                                <th class="table-header" style="width: 7.5%">STYLE NO</th>
                                <th class="table-header" style="width: 5.5%">FABRIC</th>
                                <th class="table-header" style="width: 8%">EMBELLISHMENT TYPE</th>
                                <th class="table-header" style="width: 5.5%">QUANTITY</th>
                                <th class="table-header" style="width: 5.5%">UNIT PRICE ($)</th>
                                <th class="table-header" style="width: 8.5%">TOTAL ($)</th>
                            </thead>

                                <tbody></tbody>
                                <tr>
                                    <td class="table-bottom-details" colspan="2" rowspan="2">BANK DETAILS</td>

                                    <td class="" colspan="3"></td>
                                    <td class="table-bottom-details" colspan="2">SUBTOTAL ($)</td>
                                    <td class="table-bottom-details" id="subTotal"></td>
                                    <input type="hidden" id="subTotalInput" name="subTotalInput" value="">
                                </tr>
                                <tr>
                                    <td class="" colspan="3"></td>
                                    <td class="table-bottom-details2 "  colspan="3" rowspan="7">
                                        <table style="width: 100%">
                                            @foreach ($additionPayements as $additionPayment)
                                            <tr>
                                                <td style="width: 56%">
                                                    <div class="flex-container">
                                                        <span class="addition_id" data-value="{{ $additionPayment->id }}">{{ $additionPayment->addition_type_name }}
                                                            @if ($additionPayment->addition_type_name === 'Other')
                                                                <span style="color: red; margin-left: 10px;">
                                                                    (<input type="text" class="other-reson" id="other-reson" placeholder="Enter reason" name="other_reson[{{ $additionPayment->id }}]">)
                                                                </span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </td>
                                                <td style="width: 44%">
                                                    <input type="number" class="form-control additional" id="addition_value_{{ $additionPayment->id }}" name="addition_value[{{ $additionPayment->id }}]" step="0.01" oninput="restrictInput(this)" value="" min="0">
                                                </td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </td>

                                </tr>
                                <tr>
                                    <td class="table-bottom-details2"> ACC NAME </td>
                                    <td class="table-bottom-details2"><p class="address-style" id="account_name"></p></td>
                                    <td class="" colspan="3"></td>

                                </tr>
                                <tr>
                                    <td class="table-bottom-details2">ACC NO</td>
                                    <td class="table-bottom-details2"><p class="address-style" id="account_no"></p></td>
                                    <td class="" colspan="3"></td>

                                </tr>
                                <tr>
                                    <td class="table-bottom-details2">BANK</td>
                                    <td class="table-bottom-details2"><p class="address-style" id="bank"></p></td>
                                    <td class="" colspan="3"></td>

                                </tr>
                                <tr>
                                    <td class="table-bottom-details2">BRANCH</td>
                                    <td class="table-bottom-details2"><p class="address-style" id="branch"></p></td>
                                    <td class="" colspan="3"></td>

                                </tr>
                                <tr>
                                    <td class="table-bottom-details2">SWIFT CODE</td>
                                    <td class="table-bottom-details2"><p class="address-style" id="swift_code"></p></td>
                                    <td class="" colspan="3"></td>

                                </tr>
                                <tr>
                                    <td class="table-bottom-details" colspan="2" rowspan="3" id="country"></td>

                                    <td class="" colspan="3"></td>

                                </tr>
                                <tr>
                                    <td class="" colspan="3"></td>
                                    <td class="table-bottom-details" colspan="2">REDUCE VALUE ($)</td>
                                    <td class="table-bottom-details" id="reduce_value">
                                        <input class="form-control reduce_value" type="number" id="reduce_value_input" name="reduce_value" step="0.01" value="" oninput="calculateTotalSum()">
                                    </td>

                                </tr>
                                <tr>
                                    <td class="" colspan="3"></td>
                                    <td class="table-bottom-details" colspan="2">TOTAL ($)</td>
                                    <td class="table-bottom-details" id="total_value"></td>
                                    <input type="hidden" id="total_value_input" name="total_value">
                                </tr>

                        </table>
                        <hr class="bottom-hr">
                    </div>
                </div>
                <input type="hidden" id="Issave" name="Issave">
                <input type="hidden" name="table_data" id="table_data_input" value="">

                <div class="modal-footer" @if (isset($buttonVisibility) && $buttonVisibility == false ) style="display: none" @else style="display: block"  @endif>
                    <div class="col-lg-12 control-btns">
                        <button id="download-pdf-btn" class="btn btn-warning btn-custom" type="button">Download PDF</button>
                        <button class="btn btn-secondary btn-custom"  type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="button" id="frm_submit_btn_save" class="btn btn-success btn-custom _save" onclick="submitInvoiceForm(0)">Save</button>
                        <button type="button" id="frm_submit_btn" class="btn btn-success btn-custom frm_submit_btn" onclick="submitInvoiceForm(1)">Save</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>




<script>

var originalTitle = '';

document.getElementById('download-pdf-btn').addEventListener('click', function() {

    var selectElement = document.getElementById('order_number');
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

    preparePDFContent();

    generateAndDownloadPDF(selectedDisplayText);

    restoreOriginalContent();

    originalButtonStyles.forEach(function(styleObj) {
        styleObj.button.style.display = styleObj.display;
        styleObj.button.style.position = styleObj.position;
    });
});

function preparePDFContent() {
    var buttons = document.querySelectorAll('.btn');
    buttons.forEach(function(button) {
        button.style.display = 'none';
        button.style.position = 'absolute';
    });
    var selectElement = document.getElementById('order_number');
    var selectedOption = selectElement.options[selectElement.selectedIndex];

    var selectedDisplayText = selectedOption.textContent;

    var titleElement = document.getElementById('modal-title-create');
    originalTitle = titleElement.textContent;

    titleElement.textContent = 'COMMERCIAL INVOICE - '+selectedDisplayText;
}

function restoreOriginalContent() {
    var buttons = document.querySelectorAll('.btn');
    buttons.forEach(function(button) {
        button.style.display = 'block';
        button.style.position = 'relative';
    });

    var titleElement = document.getElementById('modal-title-create');
    titleElement.textContent = originalTitle;
}

function generateAndDownloadPDF(orderNumber) {
    var modalContent = document.querySelector('.invoice-modal-content');

    var customWidth = 210; // A4 width in mm
    var customHeight = 297; // A4 height in mm
    var pdf = new jsPDF('p', 'mm', [customWidth, customHeight]); // 'p' for portrait orientation

    var currentPage = 1;
    var pageHeight = pdf.internal.pageSize.height;
    var contentHeight = modalContent.scrollHeight;

    function captureContent(startY) {
        html2canvas(modalContent, {
            windowWidth: modalContent.scrollWidth,
            windowHeight: pageHeight,
            scale: 2,
            logging: true,
            useCORS: true,
            allowTaint: true,
            backgroundColor: null,
            scrollY: startY,
            onclone: function(documentClone) {
                documentClone.querySelector('.invoice-modal-content').style.height = 'auto'; // Set height to auto to capture full content
            }
        }).then(function(canvas) {
            var contentWidth = pdf.internal.pageSize.width;
            var capturedHeight = canvas.height * contentWidth / canvas.width;

            pdf.addImage(canvas.toDataURL('image/jpeg', 1.0), 'JPEG', 0, 0, contentWidth, capturedHeight);

            pdf.save('invoice-' + orderNumber + '-page-' + currentPage + '.pdf');
        });
    }

    captureContent(0);
}




    function restrictInput(inputField) {
        var regex = /^-?\d*\.?\d*$/;

        var currentValue = inputField.value;

        if (!regex.test(currentValue)) {
            var sanitizedValue = currentValue.replace(/[^\d.-]/g, '');

            inputField.value = sanitizedValue;
        }
    }

    // Initialize Select2 on the <select> element
    $(document).ready(function () {
        $('.select2').select2();
    });

        // Function to update the content of the "current-date" element with the current date
        function updateCurrentDate(invoceDate = null) {
            if (invoceDate) {
                var currentDate = new Date(invoceDate);
            } else {
                var currentDate = new Date();
            }
            var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            var formattedDate = currentDate.toLocaleDateString(undefined, options);

            document.getElementById("current-date").textContent = formattedDate;
        }

        // Call the function once the page has loaded to display the current date
        window.onload = updateCurrentDate;


        $(document).ready(function() {

            $('.select2').select2();

            $('#order_number').on('change', function() {
                var userCanPerformAction = @json(auth()->user()->can('edit invoice unit price'));
                var selectedOrderId = $(this).val();
                $.ajax({
                    url: '{{ route('get-order-details') }}',
                    method: 'GET',
                    data: { order_id: selectedOrderId },
                    success: function(response) {
                        var orderID = response.orders.id;
                        console.log(response);

                        $('#order_id').html(orderID)

                        var selectedInvoiceId = $('#generate_invoice').data('selected-invoice-id');


                        if (response.organizations) {
                            console.log(response.organizations.organization_name);


                            $('#club-name').html(response.organizations.organization_name)
                            $('#organization-name').html(response.organizations.organization_name)
                            $('#shipping-street').html(response.orders.street)
                            $('#shipping-city').html(response.orders.city)
                            $('#shipping-postal-code').html(response.orders.postal_code)
                            $('#shipping-country').html(response.orders.country)

                        }

                        var orderItems = response.orderItems;
                        var factories = response.factories;
                        var products = response.products;
                        var embellishments = response.embellishments;
                        var fabrics = response.fabrics;
                        var price = response.price;
                        var invoiceProducts = response.invoiceProducts;
                        var factory_bank = response.bank_details;

                        var productMapping = {};
                        products.forEach(product => {
                        productMapping[product.id] = product;
                        });

                        var filteredProducts = orderItems.reduce((filtered, orderItem) => {
                        var product = productMapping[orderItem.product_id];
                        if (product) {
                            filtered.push(product);
                        }
                        return filtered;
                        }, []);

                        var embellishmentMapping = {};
                        embellishments.forEach(embellishment => {
                        embellishmentMapping[embellishment.id] = embellishment;
                        });

                        var filteredEmbellishment = orderItems.reduce((filtered, orderItem) => {
                        var embellishment = embellishmentMapping[orderItem.embellishment_type_id];
                        if (embellishment) {
                            filtered.push(embellishment);
                        }
                        return filtered;
                        }, []);

                        var fabricMapping = {};
                        fabrics.forEach(fabric => {
                        fabricMapping[fabric.id] = fabric;
                        });

                        var filteredFabric = orderItems.reduce((filtered, orderItem) => {
                        var fabric = fabricMapping[orderItem.fabric_id];
                        if (fabric) {
                            filtered.push(fabric);
                        }
                        return filtered;
                        }, []);


                        var matchedFactories = orderItems.map(orderItem => {
                            var factoryIdFromOrderItem = orderItem.factory_id;
                            var factoryMatch = factories.find(factory => factory.id == factoryIdFromOrderItem);
                            return {
                                orderItem,
                                matchedFactory: factoryMatch
                            };
                        });


                        var tableBody = document.querySelector('#order-items-table tbody');
                        tableBody.innerHTML = '';

                        var totalSum = 0;

                                if (orderItems.length > 0) {
                                orderItems.forEach(orderItem => {
                                    var productId = orderItem.product_id;
                                    var relatedProduct = productMapping[productId];

                                    if (relatedProduct) {
                                    var embellishmentId = orderItem.embellishment_type_id;
                                    var fabricId = orderItem.fabric_id;

                                    var relatedEmbellishment = embellishmentMapping[embellishmentId]
                                    var relatedFabric = fabricMapping[fabricId]

                                    if (relatedFabric) {
                                        var fabric = relatedFabric.fabric_name;
                                    } else {
                                        var fabric = orderItem.fabric_id;
                                    }

                                    var filteredProducts = invoiceProducts.filter(function (product) {
                                        return product.product_id == productId;
                                    });

                                    var matchingProduct = filteredProducts.find(function (product) {
                                        if (product.order_item_id) {
                                            return product.order_item_id == orderItem.id;
                                        } else {
                                            return product.qty == orderItem.qty;
                                        }
                                    });
console.log(matchingProduct);
                                    var unit_price = null;

                                    if (orderItem.sub_product.prices.length > 0) {
                                        manufacturePrice = orderItem.sub_product.prices.find(price => price.price_type == 5);
                                    } else {
                                        manufacturePrice = null;
                                    }
console.log(manufacturePrice);
                                    // const matchingPrice = price.find(product => product.product_id === productId);
                                    // var unit_price = matchingPrice ? matchingPrice.price : 0.00;

                                    var usingManufacturePrice = false;

                                    if (
                                        matchingProduct &&
                                        matchingProduct.unit_price != null &&
                                        parseFloat(matchingProduct.unit_price) != 0
                                    ) {
                                        unit_price = matchingProduct.unit_price;
                                    } else {
                                        unit_price = manufacturePrice ? manufacturePrice.price : 0.00;

                                        // Remember that this price did NOT come from invoice_products
                                        if (manufacturePrice && parseFloat(manufacturePrice.price) > 0) {
                                            usingManufacturePrice = true;
                                        }
                                    }


                                    if (orderItem.factory_id == 1) {


                                        if (relatedEmbellishment) {
                                            var embellishment = relatedEmbellishment.embellishment_name;
                                        } else {
                                            var embellishment = orderItem.embellishment_type_id;
                                        }
                                        var productNo = orderItem.sub_product.sub_product_no;
                                        var InvoiceProduct_id = matchingProduct ? matchingProduct.id : '';
                                        var productName = orderItem.sub_product.product_name;
                                        var styleNo = orderItem.sub_product.pattern_code;
                                        var qty = orderItem.qty;
                                        var total = orderItem.total;

                                        totalSum += parseFloat(total);

                                        var row = `
                                            <tr>
                                            <td class="table-bottom-details2 inv-product-no">${productNo}</td>
                                            <td class="table-bottom-details2">${productName}</td>
                                            <td class="table-bottom-details2">${styleNo}</td>
                                            <td class="table-bottom-details2">${fabric}</td>
                                            <td class="table-bottom-details2">${embellishment}</td>
                                            <td class="table-bottom-details2 inv-product-qty">${qty}</td>
                                            <td class="table-bottom-details2" style="padding: 4px;">
                                                <input class="unit-price-input form-control" style="height: 23px;" type="text" value="${unit_price}" data-qty="${qty}" data-row-total="${total}" data-manufacture-price="${usingManufacturePrice ? 1 : 0}" ${userCanPerformAction?'':'disabled'}>
                                            </td>
                                            <td class="table-bottom-details2" style="display:none;">
                                                <input class="product_id form-control" style="height: 23px;" type="text" value="${productId}">
                                            </td>
                                            <td class="table-bottom-details2 " hidden>
                                                <input class="invoice_id form-control" style="height: 23px;" type="text" value="${InvoiceProduct_id}">
                                                <input class="order_item_id form-control" style="height: 23px;" type="text" value="${orderItem.id}">
                                            </td>
                                            <td class="table-bottom-details2 total_price">${total}</td>
                                            </tr>
                                        `;

                                        tableBody.innerHTML += row;

                                        $('#factory_image').attr('src', '{{ asset("assets") }}/img/factory/dwc.png');
                                        $('#country').html('COUNTRY OF ORIGIN SRI LANKA');
                                    }
                                    // }
                                    }
                                });


                                function calculateSubTotalAndTotal() {
                                    var subTotal = 0;
                                    $('.unit-price-input').each(function() {
                                        var unitPrice = parseFloat($(this).val()) || 0;
                                        var qty = parseFloat($(this).data('qty')) || 0;
                                        var rowTotal = unitPrice * qty;
                                        subTotal += rowTotal;
                                    });

                                    var subTotalCell = document.getElementById('subTotal');
                                    subTotalCell.textContent = subTotal.toFixed(2);

                                    var subTotalInput = document.getElementById('subTotalInput');
                                    subTotalInput.value = subTotal.toFixed(2);

                                }

                                calculateSubTotalAndTotal();

                                function calculateTotalPrice(unitPrice, quantity) {
                                    return (unitPrice * quantity).toFixed(2);
                                }

                                function updateTotalPrice() {
                                    $('.unit-price-input').each(function() {
                                        var unitPrice = parseFloat($(this).val()) || 0;
                                        var quantity = parseFloat($(this).data('qty')) || 0;
                                        var newTotal = calculateTotalPrice(unitPrice, quantity);
                                        $(this).closest('tr').find('.total_price').text(newTotal);
                                        $(this).data('row-total', newTotal);
                                    });
                                }

                                updateTotalPrice();
                                calculateSubTotal();
                                calculateTotalSum();
                                calculateSubTotalAndTotal();

                                $(document).on('input', '.unit-price-input', function() {
                                    var unitPrice = parseFloat($(this).val());
                                    var quantity = parseFloat($(this).data('qty'));
                                    var newTotal = calculateTotalPrice(unitPrice, quantity);
                                    $(this).closest('tr').find('.total_price').text(newTotal);
                                    $(this).data('row-total', newTotal);
                                    calculateSubTotal();
                                    calculateTotalSum();
                                    calculateSubTotalAndTotal();
                                });


                            var TotalInput = document.getElementById('total_value_input');
                            TotalInput.value = totalSum.toFixed(2);

                            var totalValueCell = document.getElementById('total_value');
                            totalValueCell.textContent =  totalSum.toFixed(2);

                        } else {
                            var row = `
                                <tr>
                                    <td colspan="3">No order items found.</td>
                                 </tr>
                            `;
                            tableBody.innerHTML = row;
                        }
                        var containerElement = document.querySelector('#shipper-name');
                        var shipperStreet = document.querySelector('#shipper-street');
                        var shipperCity = document.querySelector('#shipper-city');
                        var shipperPostalCode = document.querySelector('#shipper-postal-code');
                        var shipperCountry = document.querySelector('#shipper-country');

                        var factories = response.factories;
                        var banks = response.bank_details;

                        var hasFactoryIdOne = orderItems.some(orderItem => orderItem.factory_id == 1);

                        if (hasFactoryIdOne) {
                            var targetFactory = factories.find(factory => factory.id == 1);
                            var targetBank = banks.find(factory => factory.id == 1);
                            if (targetFactory) {
                                var factoryName = targetFactory.factory_name;
                                var factoryStreet = targetFactory.street;
                                var factoryCity = targetFactory.city;
                                var factoryPostalCode = targetFactory.postal_code;
                                var factorycountry = targetFactory.country;


                                var factoryId = targetFactory.id;

                                containerElement.textContent =  factoryName ;
                                shipperStreet.textContent =  factoryStreet ;
                                shipperCity.textContent =  factoryCity ;
                                shipperPostalCode.textContent =  factoryPostalCode ;
                                shipperCountry.textContent =  factorycountry ;
                            } else {
                                containerElement.textContent = '';
                                shipperStreet.textContent = '';
                                shipperCity.textContent = '';
                                shipperPostalCode.textContent = '';
                                shipperCountry.textContent = '';
                            }

                            if (targetBank) {
                                $('#account_name').html(targetBank.bank_name);
                                $('#account_no').html(targetBank.account_no);
                                $('#bank').html(targetBank.bank);
                                $('#branch').html(targetBank.branch);
                                $('#swift_code').html(targetBank.swift_code);
                            }
                        }

                        var matchedFactories = [];

                        orderItems.forEach(orderItem => {
                            var productId = orderItem.product_id;
                            var relatedProduct = productMapping[productId];

                            if (relatedProduct && relatedProduct.factory) {
                                var productFactories = relatedProduct.factory.split('/');

                                productFactories.forEach(productFactory => {
                                    var matchingFactory = factories.find(factory => factory.factory_code == productFactory);

                                    if (matchingFactory) {
                                        matchedFactories.push({
                                            orderItem: orderItem,
                                            relatedProduct: relatedProduct,
                                            matchedFactory: matchingFactory
                                        });
                                    }
                                });
                            }
                        });

                        if (matchedFactories.length > 0) {
                            var firstMatchingFactory = matchedFactories[0].matchedFactory;



                            var filteredBankDetails = factory_bank.filter(function(item) {
                                return item.factory_id == firstMatchingFactory.id;
                            });


                        } else {
                        }
                        calculateTotalSum();
                        calculateSubTotal();

                        $('#generate_invoice').modal('show');
                        $(".se-pre-con").fadeOut('slow');

                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });

        var $inputFields = $('.additional');
        var $subTotalElement = $('#subTotal');
        var $reduceTotalElement = $('#reduce_value_input');
        var $totalCell = $('#total_value');
        var $totalInput = $('#total_value_input');

        function calculateTotalSum() {
            var subTotal = parseFloat($subTotalElement.text()) || 0;
            var reduceTotal = parseFloat($reduceTotalElement.val()) || 0;

            var totalSum = subTotal;

            $inputFields.each(function () {
                var value = parseFloat($(this).val()) || 0;
                totalSum += value;
            });

            totalSum -= reduceTotal;

            $totalCell.text(totalSum.toFixed(2));
            $totalInput.val(totalSum.toFixed(2));
        }

        // Bind change/input events
        $inputFields.on('input', calculateTotalSum);
        $reduceTotalElement.on('input', calculateTotalSum);

        // Initial calculation
        calculateTotalSum();


        function calculateSubTotal() {
            var subTotal = 0;
            $('.unit-price-input').each(function() {
                var unitPrice = parseFloat($(this).val()) || 0;
                var qty = parseFloat($(this).data('qty')) || 0;
                var rowTotal = unitPrice * qty;
                subTotal += rowTotal;
            });

            // Update the "subTotal" cell in the table
            var subTotalCell = document.getElementById('subTotal');
            subTotalCell.textContent = subTotal.toFixed(2);

            // Update the "subTotalInput" hidden input with the new subTotal value
            var subTotalInput = document.getElementById('subTotalInput');
            subTotalInput.value = subTotal.toFixed(2);
        }

        function submitInvoiceForm(Issave) {
            var $form = $('#invoice_form');
            var $tableBody = $('#order-items-table tbody');
            var rowData = [];
            var valid = true;
            var zeroPriceProducts = [];
            var errorMessage = '';
            $('#Issave').val(Issave);
            $tableBody.find('tr').each(function() {
                var $row = $(this);

                var productNo = $row.find('.table-bottom-details2:nth-child(1)').text();
                var productName = $row.find('.table-bottom-details2:nth-child(2)').text();
                var fabric = $row.find('.table-bottom-details2:nth-child(4)').text();
                var embellishment = $row.find('.table-bottom-details2:nth-child(5)').text();
                var qty = $row.find('.table-bottom-details2:nth-child(6)').text();
                var unitPrice = $row.find('.unit-price-input').val();
                var productId = $row.find('.product_id').val();
                var invoice_id = $row.find('.invoice_id').val();
                var order_item_id = $row.find('.order_item_id').val();
                var total = $row.find('.table-bottom-details2:last-child').text();

                errorMessage += `<div class="text-left">`;
                if (productNo !== '' && productNo.startsWith('PRO-')) {
                    if(unitPrice =='' || unitPrice === null || unitPrice === undefined){
                        valid = false;
                        errorMessage += `<p style="margin:0">- Product: ${productName} (${productNo})</p>`;
                    }
                    if(parseFloat(unitPrice) == 0.00){
                        zeroPriceProducts.push(`${productName} (${productNo})`);
                    }
                }
                errorMessage += `</div>`;

                rowData.push({
                    productId: productId,
                    productNo: productNo,
                    productName: productName,
                    fabric: fabric,
                    embellishment: embellishment,
                    qty: qty,
                    unitPrice: unitPrice,
                    invoice_id:invoice_id,
                    order_item_id:order_item_id,
                    total: total,
                });
            });

            if (!valid && Issave == 1) {
                console.log(errorMessage);
                Swal.fire({
                    icon: 'error',
                    title: 'Please fill in the unit prices for the following items:',
                    html: errorMessage,
                });

            }else{
                if (zeroPriceProducts.length > 0) {

                    Swal.fire({
                        icon: 'warning',
                        title: 'The following products have a unit price of $0.00:',
                        html: zeroPriceProducts.join('<br>'),
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Continue',
                        cancelButtonText: 'Cancel',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33'
                    }).then((result) => {
                        if (result.value) {
                            $('#table_data_input').val(JSON.stringify(rowData));
                            $form.submit();
                        }
                    });
                }else{
                    $('#table_data_input').val(JSON.stringify(rowData));
                    $form.submit();
                }
            }
        }
var allowInvoiceModalClose = false;
var invoiceCloseWarningOpen = false;


$('#generate_invoice').on('show.bs.modal', function () {

    allowInvoiceModalClose = false;
    invoiceCloseWarningOpen = false;

});


$('#generate_invoice').on('hide.bs.modal', function (e) {

    if (allowInvoiceModalClose) {

        allowInvoiceModalClose = false;

        return;
    }


    if (invoiceCloseWarningOpen) {

        e.preventDefault();

        return false;
    }


    var manufacturePriceProducts = [];


    $('#order-items-table tbody tr').each(function () {

        var $row = $(this);

        var $unitPriceInput =
            $row.find('.unit-price-input');


        if ($unitPriceInput.length === 0) {
            return;
        }


        var usingManufacturePrice =
            $unitPriceInput.attr('data-manufacture-price') == '1';


        if (usingManufacturePrice) {

            var productNo =
                $row.find('.inv-product-no')
                    .text()
                    .trim();


            var productName =
                $row.find('td:nth-child(2)')
                    .text()
                    .trim();


            var unitPrice =
                parseFloat($unitPriceInput.val()) || 0;


            manufacturePriceProducts.push({

                productNo: productNo,

                productName: productName,

                unitPrice: unitPrice

            });

        }

    });


    /*
    |--------------------------------------------------------------------------
    | No unsaved manufacture prices
    |--------------------------------------------------------------------------
    */
    if (manufacturePriceProducts.length === 0) {

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Stop closing
    |--------------------------------------------------------------------------
    */
    e.preventDefault();


    invoiceCloseWarningOpen = true;


    /*
    |--------------------------------------------------------------------------
    | Product list
    |--------------------------------------------------------------------------
    */
    var productList =
        manufacturePriceProducts.map(function (product) {

            return `
                <div style="
                    text-align:left;
                    margin-bottom:6px;
                ">

                    <strong>
                        ${product.productNo}
                    </strong>

                    ${product.productName}

                    - $${product.unitPrice.toFixed(2)}

                </div>
            `;

        }).join('');


    /*
    |--------------------------------------------------------------------------
    | Ask user
    |--------------------------------------------------------------------------
    */
    Swal.fire({

        icon: 'warning',

        title: 'Unsaved Unit Prices',

        html: `
            <div style="text-align:left;">

                <p>
                    The following products are currently using
                    the manufacture price because no saved
                    invoice unit price was found:
                </p>

                ${productList}

                <hr>

                <p style="margin-bottom:0;">
                    Do you want to save these prices before closing?
                </p>

            </div>
        `,

        showCancelButton: true,

        confirmButtonText: 'Yes, Save',

        cancelButtonText: 'No, Close',

        confirmButtonColor: '#28a745',

        cancelButtonColor: '#d33',

        allowOutsideClick: false,

        allowEscapeKey: false


    }).then(function (result) {

        invoiceCloseWarningOpen = false;


        /*
        |--------------------------------------------------------------------------
        | YES
        | Click existing Save button automatically
        |--------------------------------------------------------------------------
        */
        if (result.value) {

            $('#frm_submit_btn_save').trigger('click');

        }


        /*
        |--------------------------------------------------------------------------
        | NO
        | Close without saving
        |--------------------------------------------------------------------------
        */
        else if (
            result.dismiss === Swal.DismissReason.cancel
        ) {

            allowInvoiceModalClose = true;

            $('#generate_invoice').modal('hide');

        }

    });


    return false;

});


</script>
