<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RosterSizesWithNamesImport implements WithMultipleSheets
{
    protected $orderItemId;

    public function __construct($orderItemId)
    {
        $this->orderItemId = $orderItemId;
    }

    public function sheets(): array
    {
        // return [
        //     '*' => new SingleSizeBlankSheetImport($this->orderItemId), // Process each sheet
        // ];
        $sheets = [];
        $allSheets = \Maatwebsite\Excel\Facades\Excel::toArray(null, request()->file('import_file'));

        foreach (array_keys($allSheets) as $sheetName) {
            $sheets[$sheetName] = new SingleSizeBlankSheetImport($this->orderItemId);
        }

        if (empty($sheets)) {
            throw new \Exception("No sheets found in the uploaded Excel file.");
        }

        return $sheets;
    }
}
