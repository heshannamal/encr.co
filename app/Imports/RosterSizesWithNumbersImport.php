<?php

namespace App\Imports;

use App\Models\OrderItem;
use App\Models\OrderItemsDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Size;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;

class RosterSizesWithNumbersImport implements ToCollection
{
    protected $orderItemId;

    public function __construct(int $orderItemId)
    {
        $this->orderItemId = $orderItemId;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(Collection $rows)
    {
        $orderItem = OrderItem::find($this->orderItemId);
        $itemQty = $orderItem->qty;
        foreach ($rows as $index => $row) {
        // Skip header row
            if ($index === 0) continue;

            $orderItemDetail = OrderItemsDetail::where('order_item_id', $this->orderItemId)->where('size_id', $row[0])->first(); // Size id is in column "A" (index 0)
            if (!$orderItemDetail) {
                continue; // Skip if size not found
            }

            $qty = $orderItemDetail->qty ?? 0;
            Log::info('Number Qty', ['initial qty' => $qty]);

            // if($row[2]){ if(!$orderItemDetail->numseq_one){ $qty++; } $orderItemDetail->numseq_one = $row[2]; }
            // if($row[3]){ if(!$orderItemDetail->numseq_two){ $qty++; } $orderItemDetail->numseq_two = $row[3]; }
            // if($row[4]){ if(!$orderItemDetail->numseq_three){ $qty++; } $orderItemDetail->numseq_three = $row[4]; }
            // if($row[5]){ if(!$orderItemDetail->numseq_four){ $qty++; } $orderItemDetail->numseq_four = $row[5]; }

            for ($i = 2; $i <= 151; $i++) {
                if ($row[$i]) {
                    $numseqKey = 'numseq_' . $this->numberToWords($i - 1);

                    if (! $orderItemDetail->{$numseqKey}) {
                        $qty++;
                    }

                    $orderItemDetail->{$numseqKey} = $row[$i];
                }
            }

            if($qty > $orderItemDetail->qty)
            {
                $orderItemDetail->qty = $qty;
                $itemQty = $itemQty+$qty;
            }

            $orderItemDetail->update();
        }

        if($itemQty > $orderItem->qty)
        {
            $orderItem->qty = $itemQty;
            $orderItem->update();
        }
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
