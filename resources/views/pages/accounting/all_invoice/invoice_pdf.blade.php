<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Encore Cloud - Edit Invoice</title>
<link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
<script src="{{ asset('argon') }}/js/plugins/jszip.js" type="text/javascript"></script>
<style>
.order-number-details{ background-color: #eeeeee; }
.order-number-font { font-size: .7rem; width: auto; }
.date-font { font-size: .7rem; color: black; }
.hr-style{ margin-top: unset !important; margin-bottom: unset !important; }
.table-header { font-size: .7rem; color: #eeeeee; border: 1px solid #000000; padding: .2rem; }
.bg-color { background-color: rgb(98, 98, 255); }
#order-items-table .table-bottom-details { font-size: .7rem; color: black; border: 1px solid #000000; padding: .2rem; font-weight: 600; }
#order-items-table .table-bottom-details2 { color: black; border: 1px solid #000000; padding: .2rem;font-size: .7rem; }
#order-items-table td { padding: .2rem;}
.bottom-hr { margin-bottom: unset !important; border: 9px solid rgb(98, 98, 255) !important; }
.address-style { font-size: .7rem !important; color: black !important; margin-bottom: 2px !important; height: 1.5rem; }
.flex-container { display: flex; align-items: center; }
.other-reson { margin-right: 5px; border: unset; text-align: center; width: 62%; outline: unset; }
.other-reson::placeholder { color: rgb(255, 0, 0); }
.factory_image { height: 120px; }
.form-control {font-size: .7rem;}
</style>
</head>
<body>
<div class="container-fluid mt-4">
    @foreach($InvoiceDetails as $invoiceDetail)
        <div class="card mb-5 pdf-content-for-downloading" data-invoice-number="{{ $invoiceDetail['invoice']->invoice_number ?? '' }}">
            <div class="card-body">

                <!-- Header -->
                <div class="order-number-details">
                    <div class="row mt-3">
                        <div class="col-md-8 d-flex align-items-center">
                            <img class="factory_image" src="{{ asset('assets/img/factory/dwc.png') }}" alt="Factory Logo">
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                            <table>
                                <tr>
                                    <th class="order-number-font">Date</th><td>:</td>
                                    <td class="date-font">{{ \Carbon\Carbon::now()->format('l, F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="order-number-font">Club Name</th><td>:</td>
                                    <td class="date-font">{{ $invoiceDetail['organization']->organization_name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th class="order-number-font">Order Number</th><td>:</td>
                                    <td>{{ str_pad($invoiceDetail['order']->id, 6, '0', STR_PAD_LEFT) }}</td>
                                </tr>
                                <tr>
                                    <th class="order-number-font">Invoice Number</th><td>:</td>
                                    <td class="date-font">{{ $invoiceDetail['invoice']->invoice_number ?? '' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Shipper & Consignee -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h5>SHIPPER</h5><hr class="hr-style">
                        <p class="address-style">{{ $factory->factory_name ?? '' }}</p>
                        <p class="address-style">{{ $factory->street ?? '' }}</p>
                        <p class="address-style">{{ $factory->city ?? '' }}</p>
                        <p class="address-style">{{ $factory->postal_code ?? '' }}</p>
                        <p class="address-style">{{ $factory->country ?? '' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>CONSIGNEE</h5><hr class="hr-style">
                        <p class="address-style">{{ $invoiceDetail['organization']->organization_name ?? '' }}</p>
                        <p class="address-style">{{ $invoiceDetail['order']->street ?? '' }}</p>
                        <p class="address-style">{{ $invoiceDetail['order']->city ?? '' }}</p>
                        <p class="address-style">{{ $invoiceDetail['order']->postal_code ?? '' }}</p>
                        <p class="address-style">{{ $invoiceDetail['order']->country ?? '' }}</p>
                    </div>
                </div>

                    <!-- Order Items Table -->
                    <div class="mt-3">
                        <table style="border: 1px solid;" id="order-items-table">
                            <thead class="bg-color">
                                <tr>
                                    <th class="table-header" style="width:8.5%">PRODUCT NO</th>
                                    <th class="table-header" style="width:13.5%">PRODUCT NAME</th>
                                    <th class="table-header" style="width:7.5%">STYLE NO</th>
                                    <th class="table-header" style="width:5.5%">FABRIC</th>
                                    <th class="table-header" style="width:8%">EMBELLISHMENT TYPE</th>
                                    <th class="table-header" style="width:5.5%">QUANTITY</th>
                                    <th class="table-header" style="width:5.5%">UNIT PRICE ($)</th>
                                    <th class="table-header" style="width:8.5%">TOTAL ($)</th>
                                </tr>
                            </thead>
                            <tbody>
                             @if(isset($invoiceDetail['orderItems']) && $invoiceDetail['orderItems']->count() > 0)
                                @php $totalSum = 0; @endphp
                                @foreach ($invoiceDetail['orderItems'] as $item)
                                    @php
                                        $filteredProducts = $invoiceDetail['invoiceProducts']->filter(function($product) use ($item) {
                                            return $product->product_id == $item->product_id;
                                        });

                                        $matchingProduct = $filteredProducts->first(function($product) use ($item) {
                                            if ($product->order_item_id) {
                                                return $product->order_item_id == $item->id;
                                            } else {
                                                return $product->qty == $item->qty;
                                            }
                                        });

                                        $manufacturePrice = null;
                                        if (isset($item->subProduct->prices) && count($item->subProduct->prices) > 0) {
                                            $manufacturePrice = collect($item->subProduct->prices)->firstWhere('price_type', 5);
                                        }

                                        if ($matchingProduct && $matchingProduct->unit_price !== null && $matchingProduct->unit_price != 0.00) {
                                            $unitPrice = $matchingProduct->unit_price;
                                        } else {
                                            $unitPrice = $manufacturePrice ? $manufacturePrice->price : 0.00;
                                        }

                                        $total = $unitPrice * $item->qty;
                                        $totalSum += $total;
                                    @endphp
                                    <tr>
                                        <td class="table-bottom-details2">{{ $item->subProduct->sub_product_no ?? '' }}</td>
                                        <td class="table-bottom-details2">{{ $item->subProduct->product_name ?? '' }}</td>
                                        <td class="table-bottom-details2">{{ $item->subProduct->pattern_code ?? '' }}</td>
                                        <td class="table-bottom-details2">{{ $item->fabricDetails->fabric_name ?? '' }}</td>
                                        <td class="table-bottom-details2">{{ $item->embellishmentDetails->embellishment_name ?? '' }}</td>
                                        <td class="table-bottom-details2">{{ $item->qty }}</td>
                                        <td class="table-bottom-details2">{{ number_format($unitPrice, 2) }}</td>
                                        <td class="table-bottom-details2">{{ number_format($total, 2) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">No order items available</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="table-bottom-details" colspan="2" rowspan="2">BANK DETAILS</td>

                                <td class="" colspan="3"></td>
                                <td class="table-bottom-details" colspan="2">SUBTOTAL ($)</td>
                                <td class="table-bottom-details" id="subTotal">{{ number_format($totalSum, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td class="table-bottom-details2" colspan="3" rowspan="7">
                                    <table style="width:100%">
                                        @foreach ($additionPayements as $additionPayment)
                                            @php
                                                $savedValue = null;
                                                $savedReason = '';
                                                if(isset($invoiceDetail['additional']) && $invoiceDetail['additional']->count()) {
                                                    $field = $invoiceDetail['additional']->firstWhere('addition_payment_id', $additionPayment->id);
                                                    if($field) {
                                                        $savedValue = $field->amount;
                                                        $savedReason = $field->if_other_reson;
                                                    }
                                                }
                                            @endphp
                                            <tr>
                                                <td style="width:56%">
                                                    <span class="addition_id">
                                                        {{ $additionPayment->addition_type_name }}
                                                        @if ($additionPayment->id == 1 )
                                                            (<input type="text" class="other-reson" placeholder="Enter reason"
                                                                value="{{ $savedReason }}">
                                                            )
                                                        @endif
                                                    </span>
                                                </td>
                                                <td style="width:44%">
                                                    <input type="number" class="form-control additional" style="max-height:1.5rem" step="0.01" value="{{ $savedValue }}" min="0">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <tr>
                                    <td class="table-bottom-details2"> ACC NAME </td>
                                    <td class="table-bottom-details2"><p class="address-style" id="account_name">{{ $bank_details->bank_name}}</p></td>
                                    <td class="" colspan="3"></td>

                                </tr>
                                <tr>
                                    <td class="table-bottom-details2">ACC NO</td>
                                    <td class="table-bottom-details2"><p class="address-style" id="account_no">{{ $bank_details->account_no}}</p></td>
                                    <td class="" colspan="3"></td>

                                </tr>
                                <tr>
                                    <td class="table-bottom-details2">BANK</td>
                                    <td class="table-bottom-details2"><p class="address-style" id="bank">{{ $bank_details->bank}}</p></td>
                                    <td class="" colspan="3"></td>

                                </tr>
                                <tr>
                                    <td class="table-bottom-details2">BRANCH</td>
                                    <td class="table-bottom-details2"><p class="address-style" id="branch">{{ $bank_details->branch}}</p></td>
                                    <td class="" colspan="3"></td>

                                </tr>
                                <tr>
                                    <td class="table-bottom-details2">SWIFT CODE</td>
                                    <td class="table-bottom-details2"><p class="address-style" id="swift_code">{{ $bank_details->swift_code}}</p></td>
                                    <td class="" colspan="3"></td>

                                </tr>
                                <tr>
                                    <td class="table-bottom-details" colspan="2" rowspan="3" id="country">COUNTRY OF ORIGIN SRI LANKA</td>

                                    <td class="" colspan="3"></td>

                                </tr>
                                <tr>
                                    <td class="" colspan="3"></td>
                                    <td class="table-bottom-details" colspan="2">REDUCE VALUE ($)</td>
                                    <td class="table-bottom-details" id="reduce_value">
                                        @php
                                            $reduceValue = 0;
                                            if(isset($invoiceDetail['additional']) && $invoiceDetail['additional']->count()) {
                                                $reduceValue = $invoiceDetail['additional']->sum('amount');
                                            }
                                            echo number_format($reduceValue, 2);
                                        @endphp
                                    </td>

                                </tr>
                                <tr>
                                    <td class="" colspan="3"></td>
                                    <td class="table-bottom-details" colspan="2">TOTAL ($)</td>
                                    <td class="table-bottom-details" id="total_value">{{ number_format($invoiceDetail['invoice']->total_amount, 2) }}</td>
                                </tr>
                            </tr>
                        </tbody>
                    </table>


                 <hr class="bottom-hr">
                </div>

            </div>
        </div>
    @endforeach
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.11.0/jszip.min.js"></script>

<script>
$(document).ready(async function () {
    if (typeof JSZip === 'undefined') {
        console.error('JSZip is not loaded!');
        return;
    }

    const zip = new JSZip();
    const cards = document.querySelectorAll('.pdf-content-for-downloading');

    // Custom PDF size (larger than A4)
    const pdfWidth = 842; // Width in pt (A3)
    const pdfHeight = 1191; // Height in pt (A3)

    for (let i = 0; i < cards.length; i++) {
        const element = cards[i];

        // Use invoice number as filename, fallback to index
        const invoiceNumber = element.dataset.invoiceNumber || (i + 1);
        const fileName = 'invoice_' + invoiceNumber + '.pdf';

        // Clone the element to avoid layout shifts
        const clone = element.cloneNode(true);
        clone.style.position = 'absolute';
        clone.style.left = '-9999px';
        document.body.appendChild(clone);

        // Render canvas
        const canvas = await html2canvas(clone, { scale: 5 });
        const imgData = canvas.toDataURL('image/jpeg', 1.0);

        // Create jsPDF instance
        const pdf = new jspdf.jsPDF({ orientation: 'portrait', unit: 'pt', format: [pdfWidth, pdfHeight] });
        const imgProps = pdf.getImageProperties(imgData);
        const pdfScale = pdfWidth / imgProps.width;
        const imgHeight = imgProps.height * pdfScale;

        pdf.addImage(imgData, 'JPEG', 0, 0, pdfWidth, imgHeight);

        // Add PDF to ZIP
        zip.file(fileName, pdf.output('blob'));

        document.body.removeChild(clone);
    }

    // Generate zip and download
    zip.generateAsync({ type: 'blob' }).then(function(content) {
        saveAs(content, 'invoices.zip');
    });
});

</script>



</body>
</html>
