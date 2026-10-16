<?php

namespace App\Imports;

use App\Models\OrderItemsDetail;
use App\Models\OrderItemsDetailPlayerName;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class SingleSizeBlankSheetImport implements ToCollection
{
    protected $orderItemId;

    public function __construct($orderItemId)
    {
        $this->orderItemId = $orderItemId;
    }

    public function collection(Collection $rows)
    {
        // Skip the header row
        $rows->shift();

        $playerNameArr = [];
        foreach ($rows as $row) {
            $playerName = $row[1]; // Column B (Player Name)

            if (!empty($playerName)) {
                // Logic to update `OrderItemsDetail` records
                array_push($playerNameArr,$playerName);
            }
        }

        $orderItemDetail = OrderItemsDetail::where('order_item_id', $this->orderItemId)
            ->where('size_id', $this->getSizeIdFromSheetTitle())
            ->first();

        if ($orderItemDetail) {
            $orderItemDetailPlayerName = OrderItemsDetailPlayerName::where('order_items_detail_id', $orderItemDetail->id)->first();

            if($orderItemDetailPlayerName){
                $orderItemDetailPlayerName->blank_player_names = json_encode($playerNameArr);
                $orderItemDetailPlayerName->update();
            }
        }
    }

    private function getSizeIdFromSheetTitle()
    {
        $title = request()->sheetTitle ?? ''; // Pass title dynamically if required
        $titleArr = explode('-', $title);

        return $titleArr[1] ?? null;
    }
}
