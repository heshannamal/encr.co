<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TSOrderExport implements WithMultipleSheets
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

        $sheets[] = new TSODSSheet($this->id);
        $sheets[] = new ProductReportSheet($this->id);
        $sheets[] = new PlayerReportSheet($this->id);

        return $sheets;
    }
}
