<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithStartRow;

class FirstSheetImport implements ToArray, WithStartRow
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
                    'product_code' => $row[0],
                    'product_name' => $row[1],
                    'product_year' => $row[2],
                    'fabric' => $row[3],
                    'embellishment' => $row[4],
                    'quantity' => $row[5],
                    'size' => $row[6],
                    'factory_code' => $row[7]
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
