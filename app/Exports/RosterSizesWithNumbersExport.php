<?php

namespace App\Exports;

use App\Models\OrderItem;
use App\Models\OrderItemsDetail;
use App\Models\Size;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class RosterSizesWithNumbersExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithMapping
{
    private $orderItemId;

    public function __construct($orderItemId)
    {
        $this->orderItemId = $orderItemId;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $productSizes = [1, 2, 3, 4, 5, 6, 7, 8, 9, 26, 17, 18, 19, 11, 12, 13, 14, 15, 20, 21, 22, 23, 24, 25, 16, 28, 29];
        $productItemDetails = OrderItemsDetail::where('order_item_id', $this->orderItemId)->get();
        $sortedProductItemDetails = $productItemDetails->sortBy(function ($item, $key) use ($productSizes) {
            return array_search($item->size_id, $productSizes);
        });
        return $sortedProductItemDetails;
    }

    public function headings(): array
    {
        return [
            'Size ID',
            'Size',
            '1', '2', '3', '4', '5', '6', '7', '8', '9',
            '10', '11', '12', '13', '14', '15', '16', '17', '18', '19',
            '20', '21', '22', '23', '24', '25', '26', '27', '28', '29',
            '30', '31', '32', '33', '34', '35', '36', '37', '38', '39',
            '40', '41', '42', '43', '44', '45', '46', '47', '48', '49',
            '50', '51', '52', '53', '54', '55', '56', '57', '58', '59',
            '60', '61', '62', '63', '64', '65', '66', '67', '68', '69',
            '70', '71', '72', '73', '74', '75', '76', '77', '78', '79',
            '80', '81', '82', '83', '84', '85', '86', '87', '88', '89',
            '90', '91', '92', '93', '94', '95', '96', '97', '98', '99',
            '100', '101', '102', '103', '104', '105', '106', '107', '108', '109',
            '110', '111', '112', '113', '114', '115', '116', '117', '118', '119',
            '120', '121', '122', '123', '124', '125', '126', '127', '128', '129',
            '130', '131', '132', '133', '134', '135', '136', '137', '138', '139',
            '140', '141', '142', '143', '144', '145', '146', '147', '148', '149',
            '150'
        ];
    }

    /**
     * Define the styling for the Excel sheet
     */
    public function styles(Worksheet $sheet)
    {
        // Style the heading row
        $sheet->getStyle('A1:EV1')->applyFromArray([
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

    private function generateColumnNames()
    {
        $columns = [];
        foreach (range('A', 'Z') as $char) {
            $columns[] = $char;
        }

        foreach (range('A', 'E') as $prefix) { // Extend beyond 'Z'
            foreach (range('A', 'Z') as $char) {
                $columns[] = $prefix . $char;
                if ($prefix . $char === 'EV') {
                    break 2; // Stop at 'EV'
                }
            }
        }

        return $columns;
    }

    /**
     * Set column widths
     */
    public function columnWidths(): array
    {
        $columns = $this->generateColumnNames(); // Get columns from A to EV
        $columnWidths = [];

        foreach ($columns as $key => $column) {
            if ($column == 'A') {
                $columnWidths[$column] = 10; // First column width
            } elseif ($column == 'B') {
                $columnWidths[$column] = 25; // Second column width
            } else {
                $columnWidths[$column] = 6;  // Other columns width
            }
        }

        return $columnWidths;
    }

    /**
     * Map the data into the format you want to export
     */
    public function map($productItemDetail): array
    {
        $mappedData = [];

        $orderItem = OrderItem::find($this->orderItemId);

        if (in_array($productItemDetail->size_id, [17, 20, 23])){
            if(empty($orderItem->extra_size)){
                $mappedData[] = [ $productItemDetail->size_id, Size::where('id', $productItemDetail->size_id)->first()->size_name ];
            } else {
                $mappedData[] = [ $productItemDetail->size_id, $orderItem->extra_size ];
            }
        } elseif(in_array($productItemDetail->size_id, [18, 21, 24])) {
            if(empty($orderItem->extra_size_two)) {
                $mappedData[] = [ $productItemDetail->size_id, Size::where('id', $productItemDetail->size_id)->first()->size_name ];
            } else {
                $mappedData[] = [ $productItemDetail->size_id, $orderItem->extra_size_two ];
            }
        } elseif(in_array($productItemDetail->size_id, [19, 22, 25])){
            if(empty($orderItem->extra_size_three)) {
                $mappedData[] = [ $productItemDetail->size_id, Size::where('id', $productItemDetail->size_id)->first()->size_name ];
            } else {
                $mappedData[] = [ $productItemDetail->size_id, $orderItem->extra_size_three ];
            }
        } else {
            $mappedData[] = [ $productItemDetail->size_id, Size::where('id', $productItemDetail->size_id)->first()->size_name ];
        }

        return $mappedData;
    }
}
