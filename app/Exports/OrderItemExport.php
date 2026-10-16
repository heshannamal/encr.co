<?php

namespace App\Exports;

use App\Models\OrderItem;
use App\Models\OrderItemAttribute;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class OrderItemExport implements WithMultipleSheets
{
    use Exportable;

    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function sheets(): array
    {
        $sheets = [];

        $id = $this->id;

        $orderItem = OrderItem::with('orderItemDetails.sizeDetails')
            ->where('id', $id)->first();

            $adultItems = [];
            $youthItems = [];
            $extraItems = [];

            foreach ($orderItem->orderItemDetails as $orderItemDetail) {
                $sizeName = $orderItemDetail->sizeDetails['size_name'];
                if (strpos($sizeName, 'Adult') === 0) {
                    $adultItems[] = $orderItemDetail;
                } elseif (strpos($sizeName, 'Youth') === 0) {
                    $youthItems[] = $orderItemDetail;
                } else {
                    $extraItems[] = $orderItemDetail;
                }
            }

// dd($adultItems);
        $sheets[] = new OrderItemSheet($this->id);
        $varTemp = OrderItemAttribute::where('order_item_id', $orderItem->id)->where('attribute_id', 2)->exists();
        if ($varTemp) {
            if ($adultItems!==null) {
                $sheets[] = new AdultSizeSheet($this->id);
            }
            if ($youthItems!==null) {
                $sheets[] = new YouthSizeSheet($this->id);
            }
            if ($extraItems!==null) {
                $sheets[] = new ExtraSizeSheet($this->id);
            }
        }



        return $sheets;
    }
}
