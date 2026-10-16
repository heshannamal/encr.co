<?php
namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;

class PaymentsStatementExport implements FromCollection, WithHeadings, WithEvents, WithColumnWidths
{
    protected Collection $data;
    protected string $organizationName;

    public function __construct(Collection $data, string $organizationName)
    {
        $this->data = $data;
        $this->organizationName = $organizationName;
    }

    public function collection()
    {
        return $this->data->map(function ($transaction) {
            $createdDate = \Carbon\Carbon::parse($transaction['created_at'])->format('m/d/Y');

            // Helper to convert '0' or '0.00' to ''
            $zeroToEmpty = fn($value) => in_array($value, ['0', '0.00', 0, 0.0, null], true) ? '' : $value;

            return [
                'Date' => $createdDate,
                'Order #' => $transaction['Order_no'] ?? '-',
                'Payment Type' => $transaction['payment_Type'] ?? '-',
                'Transaction Type' => $transaction['Transaction_Type'] ?? '-',
                'Note' => $transaction['Note'] ?? '-',
                'Amount ($)' => $zeroToEmpty($transaction['amount'] ?? '0.00'),
                'Paid Invoice Amount ($)' => $zeroToEmpty($transaction['invoice_paid_amount'] ?? '0.00'),
                'Paid Processing Fee ($)' => $zeroToEmpty($transaction['processingFee'] ?? '0.00'),
                'Total Paid Amount ($)' => $zeroToEmpty($transaction['paid'] ?? '0.00'),
                'Debit Entry ($)' => $zeroToEmpty($transaction['debitentry'] ?? '0.00'),
                'Balance ($)' => $zeroToEmpty($transaction['balance'] ?? '0.00'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            [$this->organizationName.' - Account Statement'], // First row
            [   // Second row (actual headers)
                'Date',
                'Order #',
                'Payment Type',
                'Transaction Type',
                'Note',
                'Amount ($)',
                'Paid Invoice Amount ($)',
                'Paid Processing Fee ($)',
                'Total Paid Amount ($)',
                'Debit Entry ($)',
                'Balance ($)',
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Merge A1 to K1 for the title
                $sheet->mergeCells('A1:K1');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 20],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Style the second row (headers)
                $sheet->getStyle('A2:K2')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '808080'],
                    ],
                ]);

                // Center align A–D from row 3 down
                foreach (['A', 'B', 'C', 'D'] as $col) {
                    $sheet->getStyle("{$col}3:{$col}1000")->getAlignment()->setHorizontal(
                        \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                    );
                }

                // Right align F–K from row 3 down
                foreach (range('F', 'K') as $col) {
                    $sheet->getStyle("{$col}3:{$col}1000")->getAlignment()->setHorizontal(
                        \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT
                    );
                }

                // Calculate actual last data row based on collection count
                $dataCount = $this->data->count(); // Number of data rows
                $summaryRow = $dataCount + 3; // +2 for title/header rows, +1 for next row

                // Add "TOTAL OUTSTANDING" label in column J
                $sheet->setCellValue("J{$summaryRow}", 'TOTAL OUTSTANDING');
                $sheet->getStyle("J{$summaryRow}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FF0000']],
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT],
                ]);

                // Add last balance value in K column of the summary row
                $lastBalanceRow = $dataCount + 2; // Data starts from row 3
                $sheet->setCellValue("K{$summaryRow}", "=K{$lastBalanceRow}");
                $sheet->getStyle("K{$summaryRow}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FF0000'],
                    ],
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT],
                ]);
            },
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 12, // Date
            'B' => 15, // Order #
            'C' => 18, // Payment Type
            'D' => 20, // Transaction Type
            'E' => 30, // Note
            'F' => 15, // Amount ($)
            'G' => 30, // Paid Invoice Amount ($)
            'H' => 30, // Paid Processing Fee ($)
            'I' => 30, // Total Paid Amount ($)
            'J' => 18, // Debit Entry ($)
            'K' => 20, // Balance ($)
        ];
    }
}
