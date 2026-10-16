<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .se-pre-con {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
            display: none;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            margin: 20px;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 1600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        .title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 1200px; /* Ensures horizontal scroll on smaller screens */
            border-collapse: collapse;
            font-size: 12px;
        }

        th {
            background-color: #808080;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            padding: 6px;
            border: 1px solid #333;
        }

        td {
            padding: 6px;
            border: 1px solid #333;
        }

        td.center {
            text-align: center;
        }

        td.right {
            text-align: right;
        }

        .total-row {
            font-weight: bold;
            background-color: #FF0000;
            color: white;
        }

        .total-label {
            text-align: right;
            padding-right: 10px;
        }

        .total-value {
            text-align: right;
        }

        @media (min-width: 1200px) {
            body {
                font-size: 14px;
            }

            table {
                font-size: 13px;
            }

            .title {
                font-size: 24px;
            }
        }

        @media print {
            .se-pre-con {
                display: none !important;
            }

            .container {
                box-shadow: none;
                margin: 0;
                padding: 0;
            }

            .table-responsive {
                overflow: visible !important;
            }

            table {
                width: 100% !important;
                min-width: unset;
                font-size: 12px;
            }

            .title {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="se-pre-con"></div>

    <div class="container">
        <div id="downlodPdfArea" style="padding: 1rem;">
        <div class="title">
            {{ $organizationName }} - Account Statement
            @if(!empty($startDate) && !empty($endDate))
                ({{ $startDate }} - {{ $endDate }})
            @elseif(!empty($startDate))
                (From {{ $startDate }})
            @elseif(!empty($endDate))
                (To {{ $endDate }})
            @endif
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Order #</th>
                        <th>Payment Type</th>
                        <th>Transaction Type</th>
                        <th>Note</th>
                        <th>Amount ($)</th>
                        <th>Paid Invoice Amount ($)</th>
                        <th>Paid Processing Fee ($)</th>
                        <th>Total Paid Amount ($)</th>
                        <th>Debit Entry ($)</th>
                        <th>Balance ($)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        function zeroToEmpty($value) {
                            return in_array($value, ['0', '0.00', 0, 0.0, null], true) ? '' : $value;
                        }
                    @endphp

                    @foreach ($statements as $row)
                        <tr>
                            <td class="center">{{ \Carbon\Carbon::parse($row['created_at'])->format('m/d/Y') }}</td>
                            <td class="center">{{ $row['Order_no'] }}</td>
                            <td class="center" style="width: 9%;">{{ $row['payment_Type'] }}</td>
                            <td class="center">{{ $row['Transaction_Type'] }}</td>
                            <td>{{ $row['Note'] }}</td>
                            <td class="right">{{ zeroToEmpty($row['amount']) }}</td>
                            <td class="right">{{ zeroToEmpty($row['invoice_paid_amount']) }}</td>
                            <td class="right">{{ zeroToEmpty($row['processingFee']) }}</td>
                            <td class="right">{{ zeroToEmpty($row['paid']) }}</td>
                            <td class="right">{{ zeroToEmpty($row['debitentry']) }}</td>
                            <td class="right">{{ zeroToEmpty($row['balance']) }}</td>
                        </tr>
                        @php
                            $lastBalance = $row['balance'];
                        @endphp
                    @endforeach

                    <tr>
                        <td colspan="9" style="border-bottom: unset; border-left: unset;"></td>
                        <td class="total-label total-row">TOTAL OUTSTANDING</td>
                        <td class="total-value">{{ $lastBalance }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</body>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jsPDF and html2canvas -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
    $(window).on('load', function () {
        const { jsPDF } = window.jspdf;

        $(".se-pre-con").fadeIn('slow');

        const doc = new jsPDF({
            orientation: 'landscape',
            unit: 'pt',
            format: 'a4',
        });

        const source = document.getElementById("downlodPdfArea");

        html2canvas(source, {
            scale: 1.5,
            useCORS: true,
            allowTaint: true,
            logging: false,
            windowWidth: source.scrollWidth,
            windowHeight: source.scrollHeight
        }).then(canvas => {
            const imgData = canvas.toDataURL('image/png', 1.0);

            const pageWidth = doc.internal.pageSize.getWidth();
            const pageHeight = doc.internal.pageSize.getHeight();

            const imgWidth = pageWidth;
            const imgHeight = canvas.height * imgWidth / canvas.width;

            let heightLeft = imgHeight;
            let position = 0;

            doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;

            while (heightLeft > 0) {
                position = heightLeft - imgHeight;
                doc.addPage();
                doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
            }

            const organizationName = "{{ $safeName ?? 'account_statement' }}";
            doc.save(organizationName + "_account_statement.pdf");

            window.location.href = document.referrer || '/';
        });
    });
</script>

</html>

