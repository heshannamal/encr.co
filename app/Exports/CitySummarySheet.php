<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class CitySummarySheet implements
    FromArray,
    WithTitle,
    WithEvents
{
    protected $data;
    protected $countyRowRanges = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'City Summary';
    }

    public function array(): array
    {
        $rows = [
            ['City Summary'],
            [
                'County',
                'City',
                'Order Count',
                'Sales Tax Rate (%)',
                'Use Tax  Rate (%)',
                'Taxable Total Sales ($)',
                'Sales Tax ($)',
                'Use Tax ($)',
                'Total Sales Tax ($)',
                'Total Use Tax ($)',
            ],
        ];

        $currentRow = 3;

        foreach (
            $this->data['hierarchy'] as
            $countyIndex => $county
        ) {
            $cities = collect(
                $county['cities'] ?? []
            )->values();

            if ($cities->isEmpty()) {
                continue;
            }

            $startRow = $currentRow;

            foreach ($cities as $cityIndex => $city) {
                $rows[] = [
                    $cityIndex === 0
                        ? ($county['name'] ?? '')
                        : null,

                    $city['name'] ?? '',

                    (int) (
                        $city['order_count'] ?? 0
                    ),

                    isset($city['tax_rate'])
                    && $city['tax_rate'] !== ''
                        ? (float) $city['tax_rate']
                        : null,

                    10.00,

                    (float) (
                        $city['order_total'] ?? 0
                    ),

                    (float) (
                        $city['sales_tax'] ?? 0
                    ),

                    (float) (
                        $city['use_tax'] ?? 0
                    ),

                    $cityIndex === 0
                        ? (float) (
                            $county['sales_tax'] ?? 0
                        )
                        : null,

                    $cityIndex === 0
                        ? (float) (
                            $county['use_tax'] ?? 0
                        )
                        : null,
                ];

                $currentRow++;
            }

            $this->countyRowRanges[] = [
                'start' => $startRow,
                'end' => $currentRow - 1,
                'shade' =>
                    ($countyIndex % 2) === 1,
            ];
        }

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

                $sheet->getStyle('A2:J2')
                    ->applyFromArray(
                        $this->headerStyle()
                    );

                $sheet->getStyle(
                    'A3:J' . $lastRow
                )->applyFromArray(
                    $this->bodyStyle()
                );

                $sheet->getStyle(
                    'C2:J' . $lastRow
                )->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_RIGHT
                    );

                $sheet->getStyle(
                    'C3:C' . $lastRow
                )->getNumberFormat()
                    ->setFormatCode('#,##0');

                $sheet->getStyle(
                    'D3:E' . $lastRow
                )->getNumberFormat()
                    ->setFormatCode('0.00');

                $sheet->getStyle(
                    'F3:J' . $lastRow
                )->getNumberFormat()
                    ->setFormatCode(
                        '$#,##0.00;($#,##0.00);-'
                    );

                foreach ($this->countyRowRanges as $range) {
                    if (!$range['shade']) {
                        continue;
                    }

                    $sheet->getStyle(
                        'A' . $range['start']
                        . ':J' . $range['end']
                    )->getFill()
                        ->setFillType(
                            Fill::FILL_SOLID
                        )
                        ->getStartColor()
                        ->setARGB('FFF3F3F4');
                }

                $widths = [
                    'A' => 24,
                    'B' => 18,
                    'C' => 14,
                    'D' => 18,
                    'E' => 18,
                    'F' => 23,
                    'G' => 17,
                    'H' => 17,
                    'I' => 20,
                    'J' => 19,
                ];

                foreach ($widths as $column => $width) {
                    $sheet->getColumnDimension($column)
                        ->setWidth($width);
                }

                $sheet->getRowDimension(1)
                    ->setRowHeight(25);

                $sheet->getRowDimension(2)
                    ->setRowHeight(22);

                for ($row = 3; $row <= $lastRow; $row++) {
                    $sheet->getRowDimension($row)
                        ->setRowHeight(19);
                }
            },
        ];
    }
}
