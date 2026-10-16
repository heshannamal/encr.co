<?php

namespace App\Imports;

use App\Models\OrderItemsDetail;
use App\Models\OrderItemsDetailPlayerName;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class SingleSizeNumberNameSheetImport implements ToCollection
{
    protected $orderItemId;

    public function __construct($orderItemId)
    {
        $this->orderItemId = $orderItemId;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        // $data = collect();
        $data = [];
        // Skip the header row
        $rows->shift();
        foreach ($rows as $row) {
            $columnNumber = $row[1]; // Column B (Column ID (number))
            $playerName = $row[3]; // Column D (Player Number)
            if (!empty($playerName)) {
                // $data->push([
                //     'player_'.$columnNumber => $playerName,
                // ]);
                $data['player_'.$columnNumber] = $playerName;
            }
        }

        $orderItemDetail = OrderItemsDetail::where('order_item_id', $this->orderItemId)
            ->where('size_id', $this->getSizeIdFromSheetTitle())
            ->first();

        if ($orderItemDetail) {
            $orderItemDetailPlayerName = OrderItemsDetailPlayerName::where('order_items_detail_id', $orderItemDetail->id)->first();

            if($orderItemDetailPlayerName){
                $orderItemDetailPlayerName->update($data);
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
