<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TeamStoreImport implements WithMultipleSheets
{
    public $schema = [];

    public function __construct($startRow)
    {
        $this->schema[0] = new FirstSheetImport($startRow);
        $this->schema[1] = new SecondSheetImport($startRow);
    }

    public function sheets(): array
    {
        return $this->schema;
    }
}
