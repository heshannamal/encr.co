<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SalesTaxReportSheet implements
    FromArray,
    WithTitle,
    WithEvents
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Sales Tax Report';
    }

    public function array(): array
    {
        $rows = [
            ['Sales Tax Report'],
            [
                'Date range: '
                . ($this->data['start_date'] ?: 'All')
                . ' – '
                . ($this->data['end_date'] ?: 'All')
                . '  |  County: '
                . ($this->data['county'] ?: 'All')
                . '  |   City: '
                . ($this->data['city'] ?: 'All')
                . '  |   Exported: '
                . date('m/d/Y'),
            ],
            [
                'County',
                'City',
                'Order Count',
                'Taxable Total Sales ($)',
                'Sales Tax Rate (%)',
                'Sales Tax Total ($)',
                'Use Tax Total ($)',
            ],
        ];

        foreach ($this->data['hierarchy'] as $county) {
            $firstCity = collect(
                $county['cities'] ?? []
            )->first();

            $rows[] = [
                $county['name'] ?? 'Unknown County',
                $firstCity['name'] ?? '',
                (int) ($county['order_count'] ?? 0),
                (float) ($county['order_total'] ?? 0),
                isset($firstCity['tax_rate'])
                    && $firstCity['tax_rate'] !== ''
                        ? (float) $firstCity['tax_rate']
                        : null,
                (float) ($county['sales_tax'] ?? 0),
                (float) ($county['use_tax'] ?? 0),
            ];
        }

        $summary = $this->data['summary'];

        $rows[] = [
            'Grand Total',
            null,
            (int) ($summary['order_count'] ?? 0),
            (float) ($summary['taxable_total_sales'] ?? 0),
            null,
            (float) ($summary['sales_tax_total'] ?? 0),
            (float) ($summary['use_tax_total'] ?? 0),
        ];

        return $rows;
    }

    protected function headerStyle()
    {
        return [
            'font' => [
                'name' => 'Arial',
                'bold' => true,
                'color' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FF6F6E73',
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' =>
                        Border::BORDER_THIN,
                    'color' => [
                        'argb' => 'FFB7B7B7',
                    ],
                ],
            ],
        ];
    }

    protected function bodyStyle()
    {
        return [
            'font' => [
                'name' => 'Arial',
                'size' => 10,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' =>
                        Border::BORDER_THIN,
                    'color' => [
                        'argb' => 'FFB7B7B7',
                    ],
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();

                $sheet->setShowGridlines(false);

                $sheet->getStyle('A1')
                    ->getFont()
                    ->setName('Arial')
                    ->setBold(true)
                    ->setSize(16);

                $sheet->getStyle('A2:G2')
                    ->getFont()
                    ->setName('Arial')
                    ->setSize(10)
                    ->getColor()
                    ->setARGB('FF777777');

                $sheet->getStyle('A3:G3')
                    ->applyFromArray(
                        $this->headerStyle()
                    );

                $sheet->getStyle(
                    'A4:G' . $lastRow
                )->applyFromArray(
                    $this->bodyStyle()
                );

                $sheet->getStyle(
                    'C3:G' . $lastRow
                )->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_RIGHT
                    );

                $sheet->getStyle(
                    'C4:C' . $lastRow
                )->getNumberFormat()
                    ->setFormatCode('#,##0');

                $sheet->getStyle(
                    'D4:D' . $lastRow
                )->getNumberFormat()
                    ->setFormatCode(
                        '$#,##0.00;($#,##0.00);-'
                    );

                $sheet->getStyle(
                    'E4:E' . $lastRow
                )->getNumberFormat()
                    ->setFormatCode('0.00');

                $sheet->getStyle(
                    'F4:G' . $lastRow
                )->getNumberFormat()
                    ->setFormatCode(
                        '$#,##0.00;($#,##0.00);-'
                    );

                $sheet->getStyle(
                    'A' . $lastRow
                    . ':G' . $lastRow
                )->getFont()
                    ->setBold(true);

                $sheet->getStyle(
                    'A' . $lastRow
                    . ':G' . $lastRow
                )->getFill()
                    ->setFillType(
                        Fill::FILL_SOLID
                    )
                    ->getStartColor()
                    ->setARGB('FFD9D9D9');

                $sheet->getStyle(
                    'A' . $lastRow
                    . ':G' . $lastRow
                )->getBorders()
                    ->getBottom()
                    ->setBorderStyle(
                        Border::BORDER_DOUBLE
                    );

                $sheet->getColumnDimension('A')
                    ->setWidth(24);

                $sheet->getColumnDimension('B')
                    ->setWidth(18)
                    ->setVisible(false);

                $sheet->getColumnDimension('C')
                    ->setWidth(18);

                $sheet->getColumnDimension('D')
                    ->setWidth(23);

                $sheet->getColumnDimension('E')
                    ->setWidth(18)
                    ->setVisible(false);

                $sheet->getColumnDimension('F')
                    ->setWidth(19);

                $sheet->getColumnDimension('G')
                    ->setWidth(18);

                $sheet->getRowDimension(1)
                    ->setRowHeight(25);

                $sheet->getRowDimension(2)
                    ->setRowHeight(19);

                $sheet->getRowDimension(3)
                    ->setRowHeight(22);

                for ($row = 4; $row <= $lastRow; $row++) {
                    $sheet->getRowDimension($row)
                        ->setRowHeight(19);
                }
            },
        ];
    }
}
