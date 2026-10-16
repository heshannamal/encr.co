<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SecondSheetImport implements ToArray, WithStartRow
{
    private $data;
    private $startRow;

    public function __construct($stRow)
    {
        $this->data = [];
        $this->startRow=$stRow;
    }

    public function array(array $rows)
    {
        foreach ($rows as $row) {
            if(count($row)>=8){
                $this->data[] = array(
                    'player_name' => $row[0],
                    'billing_name' => $row[1],
                    'order_number' => $row[2],
                    'order_quantity' => $row[3],
                    'product_name' => $row[4],
                    'player_no' => $row[5],
                    'quantity' => $row[6],
                    'size' => $row[7]
                );
            }
        }
    }

    public function startRow(): int
    {
        return $this->startRow;
    }

    public function getArray(): array
    {
        return $this->data;
    }
}
