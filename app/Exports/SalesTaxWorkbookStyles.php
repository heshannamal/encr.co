<?php

namespace App\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

trait SalesTaxWorkbookStyles
{
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
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => [
                        'argb' => 'FFB7B7B7',
                    ],
                ],
            ],
        ];
    }

    protected function bodyBorderStyle()
    {
        return [
            'font' => [
                'name' => 'Arial',
                'size' => 10,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => [
                        'argb' => 'FFB7B7B7',
                    ],
                ],
            ],
        ];
    }

    protected function grandTotalStyle()
    {
        return [
            'font' => [
                'name' => 'Arial',
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFD9D9D9',
                ],
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => [
                        'argb' => 'FF000000',
                    ],
                ],
                'bottom' => [
                    'borderStyle' => Border::BORDER_DOUBLE,
                    'color' => [
                        'argb' => 'FF000000',
                    ],
                ],
            ],
        ];
    }

    protected function currencyFormat()
    {
        return '$#,##0.00;($#,##0.00);-';
    }

    protected function styleTitleAndGrid(
        $sheet,
        $headerRange,
        $bodyRange,
        $titleCell = 'A1'
    ) {
        $sheet->setShowGridlines(false);

        $sheet->getStyle($titleCell)
            ->getFont()
            ->setName('Arial')
            ->setBold(true)
            ->setSize(16);

        $sheet->getStyle($headerRange)
            ->applyFromArray(
                $this->headerStyle()
            );

        if ($bodyRange) {
            $sheet->getStyle($bodyRange)
                ->applyFromArray(
                    $this->bodyBorderStyle()
                );
        }
    }
}
