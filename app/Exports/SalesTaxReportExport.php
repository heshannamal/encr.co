<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SalesTaxReportExport implements WithMultipleSheets
{
    protected $data;

    public function __construct(
        $startDate = null,
        $endDate = null,
        $county = null,
        $city = null
    ) {
        $this->data = SalesTaxReportExportData::build(
            $startDate,
            $endDate,
            $county,
            $city
        );
    }

    public function sheets(): array
    {
        return [
            new SalesTaxReportSheet($this->data),
            new LocalTaxSummarySheet($this->data),
            new CitySummarySheet($this->data),
        ];
    }
}
