<?php

namespace App\Imports;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemsDetail;
use App\Models\OrderItemsDetailPlayerName;
use App\Models\Organization;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;

class OrderRosterImport implements ToCollection
{
    protected $orderId;

    public function __construct(int $orderId)
    {
        $this->orderId = $orderId;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //All Data Validation
        $validator = Validator::make($collection->toArray(), [
            '*.0' => 'required',
            '*.3' => 'required',
        ], [
            '*.0.required' => 'Item Number fields are required!',
            '*.3.required' => 'Size fields are required!',
        ]);

        if ($validator->fails()) {
            // Retrieve validation errors
            $errors = $validator->errors()->toArray();

            // Format the errors into a readable string or structure
            $errorMessages = [];
            foreach ($errors as $key => $errorArray) {
                // $errorMessages[] = "Row {$key}: " . implode(', ', $errorArray);
                $errorMessages[] = implode(', ', $errorArray);
            }

            // Throw a Validation Exception with the error messages
            throw new \Exception(implode("\n", $errorMessages));
        }

        $mainArr = [];

        foreach ($collection as $index => $row) {
            if ($index === 0) continue;

            // order item Id
            $impOrderItemId = $row[0];

            // size Id
            $impSizeColum = $row[3];
            $sizeArr = explode('-', $impSizeColum);
            $impSizeId = $sizeArr[0];

            // quantity
            $impQty = $row[4];

            // player Number
            $impNumber = $row[5];

            // player name
            $impName = $row[6];

            // $orderItemQty = 0;
            // $orderItemBlankQty = 0;

            $mainArr[$impOrderItemId][$impSizeId][] = ['quantity'=>$impQty, 'player_number'=>$impNumber, 'player_name'=>$impName ];

        }

        $validationErrors = [];
        foreach($mainArr as $itemId=>$items)
        {
            $orderItem = OrderItem::find($itemId);
            if($orderItem)
            {
                foreach($items as $sizeId=>$sizedItems)
                {
                    foreach($sizedItems as $itemDetail)
                    {
                        $quantity = $itemDetail['quantity'];
                        $playerNumber = $itemDetail['player_number'];
                        $playerName = $itemDetail['player_name'];

                        $error = $this->validateRoster($orderItem, $quantity, $playerNumber, $playerName);

                        if ($error) {
                            $validationErrors[] =  "Item ID : $itemId - ". $error ;
                        }
                    }
                }
            }
        }
        if (!empty($validationErrors)) {
            throw new \Exception(implode("\n", $validationErrors));
        }

        $orderQty = 0;
        foreach($mainArr as $itemId=>$items)
        {
            $orderItem = OrderItem::find($itemId);
            if($orderItem)
            {
                $orderItemQty = 0;
                $rostertype = 'blank';
                if($orderItem->individual_name == 1 ){
                    $rostertype = 'name';
                }
                if($orderItem->individual_no == 1 ){
                    $rostertype = 'number';
                }
                foreach($items as $sizeId=>$sizedItems)
                {
                    $orderItemDetail = OrderItemsDetail::where('order_item_id', $orderItem->id)->where('size_id', $sizeId)->first();
                    if($orderItemDetail)
                    {
                        $itemSizeQty = 0;
                        $lastSeqNo = 1;
                        $updateItemDetailArr = [];
                        $updateItemDetailPlayerArr = [];
                        foreach($sizedItems as $itemDetail)
                        {
                            $sizedItemsQty = $itemDetail['quantity'];
                            $sizedItemsNo = $itemDetail['player_number'];
                            $sizedItemsName = $itemDetail['player_name'];
                            $itemSizeQty += $sizedItemsQty;

                            if($rostertype == 'blank'){
                                $updateItemDetailArr['blanks'] = $sizedItemsQty;
                            } elseif($rostertype == 'name'){
                                $updateItemDetailArr['blanks'] = $sizedItemsQty;

                                $playerNameArray = array_fill(0, $sizedItemsQty, $sizedItemsName);
                                $updateItemDetailPlayerArr['blank_qty'] = $sizedItemsQty;
                                $updateItemDetailPlayerArr['blank_player_names'] = json_encode($playerNameArray);

                            } elseif($rostertype == 'number'){
                                $playerNoArr = [];
                                $playerNameArr = [];
                                for($q=0; $q<$sizedItemsQty; $q++){
                                    $numseqKey = 'numseq_' . $this->numberToWords($lastSeqNo);
                                    $playerseqKey = 'player_'. $this->numberToWords($lastSeqNo);
                                    if($sizedItemsNo !== null && $sizedItemsNo !== ''){
                                        $playerNoArr[$numseqKey] = $sizedItemsNo;
                                    }
                                    if($sizedItemsName){
                                        $playerNameArr[$playerseqKey] = $sizedItemsName;
                                    }
                                    $lastSeqNo++;
                                }
                                // Log::debug('playerNoArr:', $playerNoArr);
                                // Log::debug('playerNameArr:', $playerNameArr);

                                $sizedItemCurrentQty = $sizedItemsQty + ($updateItemDetailArr['qty'] ?? 0);
                                $updateItemDetailArr['qty'] = $sizedItemCurrentQty;
                                $updateItemDetailArr = array_merge($updateItemDetailArr, $playerNoArr);
                                $updateItemDetailPlayerArr = array_merge($updateItemDetailPlayerArr, $playerNameArr);
                            }
                        }
                        // Log::debug('updateItemDetailArr:', $updateItemDetailArr);
                        // Log::debug('updateItemDetailPlayerArr:', $updateItemDetailPlayerArr);

                        $orderItemQty += ($updateItemDetailArr['blanks'] ?? 0) + ($updateItemDetailArr['qty'] ?? 0);

                        $orderItemDetail->update($updateItemDetailArr);
                        $orderItemsDetailPlayer = OrderItemsDetailPlayerName::where('order_items_detail_id', $orderItemDetail->id)->first();
                        if($orderItemsDetailPlayer){
                            $orderItemsDetailPlayer->update($updateItemDetailPlayerArr);
                        }
                        else {
                            $updateItemDetailPlayerArr = array_merge($updateItemDetailPlayerArr, ['order_items_detail_id'=>$orderItemDetail->id]);

                            Log::debug('updateItemDetailPlayerArr:', $updateItemDetailPlayerArr);
                            OrderItemsDetailPlayerName::create($updateItemDetailPlayerArr);
                        }
                    } else {
                        if (!$orderItemDetail) {
                            Log::warning("OrderItemsDetail for OrderItem ID $orderItem->id and Size ID $sizeId not found.");
                            continue; // Skip this size
                        }
                    }
                }

                $orderQty += $orderItemQty;
                $orderItem->qty = $orderItemQty;

                $orderItem->total =  $orderItem->unit_price * $orderItemQty;

                $orderItem->update();

            } else {
                Log::warning("OrderItem with ID $itemId not found.");
                continue; // Skip this item
            }
        }

        $order = Order::find($this->orderId);
        $organization = Organization::find($order->organization_id);
        $orderSubTotal = OrderItem::where('order_id', $this->orderId)->sum('total');
        if ($organization->sales_tax_active == 1) {
            $salesTax = $organization->sales_tax;
        } else {
            $salesTax = 0;
        }
        $orderSalesTax = ($orderSubTotal / 100) * $salesTax;
        $orderShipping = $order->shipping ?? '';
        $orderArtwork = $order->artwork ?? '';
        $orderProcessingFee = $order->processing_fee ?? '';
        $orderFeesTotal = $orderSalesTax + $orderShipping + $orderArtwork + $orderProcessingFee;

        $order->sub_total = $orderSubTotal;
        $order->order_total = $orderSubTotal + $orderFeesTotal;
        $order->sales_tax = $orderSalesTax;
        $order->save();

        $this->setShippingFee($order->id);
    }

    protected function validateRoster($orderItem, $quantity, $playerNumber, $playerName)
    {
        $errorMessages = [];
        if (!$quantity) {
            $errorMessages[] = 'Quantity field is required';
        }
        if ($orderItem->individual_no == 0 && $orderItem->individual_name == 0) {
            if ($playerNumber !== null && $playerNumber !== '') {
                $errorMessages[] = 'Player numbers are not allowed';
            }

            if ($playerName) {
                $errorMessages[] = 'Player names are not allowed';
            }

            if (!empty($errorMessages)) {
                return implode(' and ', $errorMessages);
            }

        } elseif ($orderItem->individual_no == 1 && $orderItem->individual_name == 0) {
            if ($playerNumber === null || $playerNumber === '') {
                $errorMessages[] = 'Player number is required';
            }
            if ($playerName) {
                $errorMessages[] = 'Player names are not allowed';
            }
            if (!empty($errorMessages)) {
                return implode(' and ', $errorMessages);
            }

        } elseif ($orderItem->individual_no == 0 && $orderItem->individual_name == 1) {
            if ($playerNumber !== null && $playerNumber !== '') {
                $errorMessages[] = 'Player numbers are not allowed';
            }
            if (!$playerName) {
                $errorMessages[] = 'Player name is required';
            }
            if (!empty($errorMessages)) {
                return implode(' and ', $errorMessages);
            }

        } elseif ($orderItem->individual_no == 1 && $orderItem->individual_name == 1) {
            if ($playerNumber === null || $playerNumber === '') {
                $errorMessages[] = 'Player number is required';
            }
            if (!$playerName) {
                $errorMessages[] = 'Player name is required';
            }
            if (!empty($errorMessages)) {
                return implode(' and ', $errorMessages);
            }
        }

        return null; // No validation errors
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

    public function setShippingFee($orderId){
        $order = Order::find($orderId);
        $orderTotal = $order->order_total;
        $orderTotal = $orderTotal - $order->shipping;
        $orderQty = OrderItem::where('order_id', $orderId)->get()->sum('qty');
        if($orderQty > 70){
            $shippingFee = 0.5 * $orderQty;
        } else if($orderQty == 0){
            $shippingFee = 0;
        } else {
            $shippingFee = 35;
        }
        $order->shipping = $shippingFee;
        $order->order_total = $orderTotal + $shippingFee;
        $order->update();
    }
}
