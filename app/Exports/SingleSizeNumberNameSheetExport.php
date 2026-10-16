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

class SingleSizeNumberNameSheetExport implements FromCollection, WithTitle, WithHeadings, WithStyles, WithColumnWidths
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

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = collect();
        $j = 1;
        for ($i = 2; $i <= 151; $i++) {
            $numWord = $this->numberToWords($i - 1);
            $numseqKey = 'numseq_' . $numWord;

            if ($this->rows->{$numseqKey}) {
                $data->push([
                    'SI No' => $j, // Loop index starting from 1
                    'Column ID' => $numWord, // Placeholder for Column Id
                    'Player Number' => $this->rows->{$numseqKey}, // Placeholder for Player Number
                    'Player Name' => null, // Placeholder for Player Name
                ]);
                $j++;
            }
        }
        return $data;
    }

    public function headings(): array
    {
        return [
            'SI No',
            'Column ID',
            'Player Number',
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
        $sheet->getStyle('A1:D1')->applyFromArray([
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
            'A' => 6, // Column A width set to 10
            'B' => 20, // Column B width set to 25
            'C' => 15, // Column B width set to 25
            'D' => 30, // Column B width set to 25
        ];
    }

    private function numberToWords($number)
    {
        $words = [
            1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten',
            11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen',
            20 => 'twenty', 30 => 'thirty', 40 => 'forty', 50 => 'fifty', 60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety',
            100 => 'hundred', 101 => 'hundred_one', 102 => 'hundred_two', 103 => 'hundred_three', 104 => 'hundred_four', 105 => 'hundred_five', 106 => 'hundred_six', 107 => 'hundred_seven', 108 => 'hundred_eight', 109 => 'hundred_nine',
            110 => 'hundred_ten', 111 => 'hundred_eleven', 112 => 'hundred_twelve', 113 => 'hundred_thirteen', 114 => 'hundred_fourteen', 115 => 'hundred_fifteen', 116 => 'hundred_sixteen', 117 => 'hundred_seventeen', 118 => 'hundred_eighteen', 119 => 'hundred_nineteen'
        ];

        if (array_key_exists($number, $words)) {
            return $words[$number];
        }

        if ($number < 100) {
            $tens = ((int) ($number / 10)) * 10;
            $units = $number % 10;
            return $words[$tens] . ($units ? '_' . $words[$units] : '');
        }

        if ($number > 100 && $number <= 151) {
            $hundreds = 'hundred';
            $remainder = $number % 100;
            if ($remainder === 0) {
                return $hundreds;
            }

            // For numbers from 101 to 151
            $tens = ((int) ($remainder / 10)) * 10;
            $units = $remainder % 10;

            $tensWord = $tens > 0 ? ($words[$tens] ?? '') : '';
            $unitsWord = $units > 0 ? ($words[$units] ?? '') : '';

            return $hundreds . ($tensWord ? '_' . $tensWord : '') . ($unitsWord ? '_' . $unitsWord : '');
        }
        return 'out_of_range';
    }
}
