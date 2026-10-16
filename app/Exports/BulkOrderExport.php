<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BulkOrderExport implements WithMultipleSheets
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

        $sheets[] = new BulkODSSheet($this->id);
        $sheets[] = new OrderRosterSheet($this->id);

        return $sheets;
    }
}
