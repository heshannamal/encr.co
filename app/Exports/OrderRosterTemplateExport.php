<?php

namespace App\Exports;

use App\Models\OrderItem;
use App\Models\OrderItemsDetail;
use App\Models\Product;
use App\Models\Size;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class OrderRosterTemplateExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithMapping, WithEvents, WithTitle
{
    private $orderId;

    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    public function collection()
    {
        // Fetch all OrderItems for the given order
        return OrderItem::where('order_id', $this->orderId)->get();
    }

    public function headings(): array
    {
        return [
            'Item Number',
            'Product Code',
            'Product Name',
            'Size',
            'Quantity',
            'Player Number',
            'Player Name',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:G1')->applyFromArray([
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
        $sheet->getRowDimension(1)->setRowHeight(30);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,
            'C' => 50,
            'D' => 30,
            'E' => 15,
            'F' => 15,
            'G' => 15,
        ];
    }

    public function map($orderItem): array
    {
        $product = Product::find($orderItem->product_id);
        return [
            $orderItem->id,
            // 'PRO-' . $orderItem->product_id,
            $orderItem->sub_product_no,
            // $product ? $product->product_name : 'Unknown Product',
            $orderItem->display_name.' '.$orderItem->item_description,
            null,
            null,
            null,
            null,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $orderItems = $this->collection();

                $rowIndex = 2; // Start after the header row
                foreach ($orderItems as $orderItem) {
                    // Generate dropdown options for the current OrderItem
                    $dropdownOptions = $this->generateDropdownOptions($orderItem);

                    // Define the range for the dropdown in the current row's Size column (column D)
                    $dropdownRange = "D{$rowIndex}";

                    // Set dropdown validation for the current row
                    $validation = $sheet->getCell($dropdownRange)->getDataValidation();
                    $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
                    $validation->setAllowBlank(true);
                    $validation->setShowDropDown(true);
                    $validation->setFormula1('"' . implode(',', $dropdownOptions) . '"');
                    $sheet->setDataValidation("D{$rowIndex}", $validation);

                    $rowIndex++;
                }
            },
        ];
    }

    private function generateDropdownOptions($orderItem)
    {
        $productSizes = [
            1, 2, 3, 4, 5, 6, 7, 8, 9, 26, 17, 18, 19, 11, 12, 13, 14, 15, 20, 21, 22, 23, 24, 25, 16, 28, 29
        ];

        $dropdownOptions = [];
        $productItemDetails = OrderItemsDetail::where('order_item_id', $orderItem->id)->get();

        $sortedProductItemDetails = $productItemDetails->sortBy(function ($item) use ($productSizes) {
            return array_search($item->size_id, $productSizes);
        });

        foreach ($sortedProductItemDetails as $sortedProductItemDetail) {
            $sizeId = $sortedProductItemDetail->size_id;
            $sizeName = Size::where('id', $sizeId)->value('size_name');

            if (in_array($sizeId, [17, 20, 23])) {
                $dropdownOptions[] = $sizeId.'-'.$sizeName ?? 'Unknown';
            } elseif (in_array($sizeId, [18, 21, 24])) {
                $dropdownOptions[] = $sizeId.'-'.$sizeName ?? 'Unknown';
            } elseif (in_array($sizeId, [19, 22, 25])) {
                $dropdownOptions[] = $sizeId.'-'.$sizeName ?? 'Unknown';
            } else {
                $dropdownOptions[] = $sizeId.'-'.$sizeName ?? 'Unknown';
            }
        }

        return $dropdownOptions;
    }

    public function title(): string
    {
        return 'Player Report - '.$this->orderId; // Set sheet name
    }
}
