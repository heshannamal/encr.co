<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FactoryOrdersExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    protected $factoriesData;

    public function __construct($factoriesData)
    {
        $this->factoriesData = $factoriesData;
    }

    /**
     * Return the collection of data to be exported.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->factoriesData);
    }

    /**
     * Return the headings for the Excel sheet.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Factory ID',
            'Factory Name',
            'Total Item Count',
            'New Orders Count',
            'Total Revenue ($)',
            'Revenue Percentage (%)',
        ];
    }

    /**
     * Apply styling to the sheet.
     *
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'alignment' => ['horizontal' => 'center'],
            ],
            'A' => ['font' => ['size' => 11]],
            'B' => ['font' => ['size' => 11]],
            'C' => ['font' => ['size' => 11]],
            'D' => ['font' => ['size' => 11]],
            'E' => ['font' => ['size' => 11]],
            'F' => ['font' => ['size' => 11]],
            'C' => ['alignment' => ['horizontal' => 'center']],
            'D' => ['alignment' => ['horizontal' => 'center']],
            'A' => ['alignment' => ['horizontal' => 'center']],
        ];
    }

    /**
     * Define column widths.
     *
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 20, // Factory ID
            'B' => 25, // Factory Name
            'C' => 20, // Total Orders Count
            'D' => 20, // New Orders Count
            'E' => 20, // Total Revenue
            'F' => 20, // Revenue Percentage
        ];
    }
}
