<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Models\OrderItem;
use App\Models\Size;

class SingleSizeBlankSheetExport implements FromCollection, WithTitle, WithHeadings, WithStyles, WithColumnWidths
{
    protected $sizeId;
    protected $rows;
    protected $orderItemId;

    public function __construct($sizeId, $rows, $orderItemId)
    {
        $this->sizeId = $sizeId;
        $this->rows = $rows;
        $this->orderItemId = $orderItemId;
    }

    public function collection()
    {
        // Prepare the data
        $data = collect();
        for ($i=0; $i < $this->rows->blanks; $i++) {
            $data->push([
                'SI No' => $i + 1, // Loop index starting from 1
                'Player Name' => null, // Placeholder for Player Name
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'SI No',
            'Player Name'
        ];
    }

    public function title(): string
    {
        // Retrieve the size name based on the provided logic
        $orderItem = OrderItem::find($this->orderItemId);
        $sizeName = '';

        if (in_array($this->sizeId, [17, 20, 23])) {
            $sizeName = empty($orderItem->extra_size)
                ? Size::find($this->sizeId)->size_name
                : $orderItem->extra_size;
        } elseif (in_array($this->sizeId, [18, 21, 24])) {
            $sizeName = empty($orderItem->extra_size_two)
                ? Size::find($this->sizeId)->size_name
                : $orderItem->extra_size_two;
        } elseif (in_array($this->sizeId, [19, 22, 25])) {
            $sizeName = empty($orderItem->extra_size_three)
                ? Size::find($this->sizeId)->size_name
                : $orderItem->extra_size_three;
        } else {
            $sizeName = Size::find($this->sizeId)->size_name;
        }

        return "{$sizeName}-{$this->sizeId}-{$this->orderItemId})";
    }

    /**
     * Define the styling for the Excel sheet
     */
    public function styles(Worksheet $sheet)
    {
        // Style the heading row
        $sheet->getStyle('A1:B1')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D9D9D9'], // Adjust the background color
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Set row height
        $sheet->getRowDimension(1)->setRowHeight(30);
        for ($i = 2; $i <= $sheet->getHighestRow(); $i++) {
            $sheet->getRowDimension($i)->setRowHeight(20); // Other rows height
        }

        return $sheet;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10, // Column A width set to 10
            'B' => 25, // Column B width set to 25
        ];
    }
}
