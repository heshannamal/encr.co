<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RosterSizesWithNumberNamesExport implements WithMultipleSheets
{
    protected $groupedData;
    protected $orderItemId;

    public function __construct($groupedData, $orderItemId)
    {
        $this->groupedData = $groupedData;
        $this->orderItemId = $orderItemId;
    }

    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->groupedData as $rows) {
            $sheets[] = new SingleSizeNumberNameSheetExport($rows->size_id, $rows, $this->orderItemId);
        }

        return $sheets;
    }
}
