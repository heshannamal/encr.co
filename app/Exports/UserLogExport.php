<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class UserLogExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public $audits;

    public function __construct($audits)
    {
        $this->audits = $audits;
    }

    public function view(): View
    {
        return view('exports.customerlog_report', ['audits' => $this->audits]);
    }
}
