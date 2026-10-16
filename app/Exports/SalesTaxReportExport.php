<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalesTaxReportExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Order::with(['organizationDetails', 'userDetails', 'statusDetails']);

        // Date filter
        if ($this->startDate && $this->endDate) {
            $start = Carbon::createFromFormat('m/d/Y', $this->startDate)->startOfDay();
            $end   = Carbon::createFromFormat('m/d/Y', $this->endDate)->endOfDay();
            $query->whereRaw(
        "STR_TO_DATE(production_date, '%m/%d/%Y') BETWEEN ? AND ?",
        [$start, $end]
    );
        }

        // Base filters
        $orders = $query->whereIn('order_status_id', [3, 4, 8])
            ->where('active', 1)
            ->whereNotNull('sales_tax')
            ->where('sales_tax', '>', 0)
            ->whereNotNull('sub_total')
            ->where('sub_total', '>', 0);

        // Exclude TSR orders if no record in store_orders
        $orders = $orders->where(function ($q) {
            $q->where('order_no', 'not like', 'TSR%')
              ->orWhere(function ($sub) {
                  $sub->where('order_no', 'like', 'TSR%')
                      ->whereExists(function ($existQuery) {
                          $existQuery->select(DB::raw(1))
                                     ->from('store_orders')
                                     ->whereColumn('store_orders.system_order_no', 'orders.order_no');
                      });
              });
        });

        $orders = $orders->orderBy('created_at', 'desc')->get();

        $totalSalesTax = 0;

        $rows = $orders->map(function ($row) use (&$totalSalesTax) {
            $rate  = $row->organizationDetails->sales_tax ?? 0;
            $total = $row->sub_total ?? 0;
            $salesTax = $row->sales_tax;

            $totalSalesTax += $salesTax;

            return [
                'Order No'          => $row->order_no,
                'Organization Name' => $row->organizationDetails->organization_name ?? '-',
                'State'             => $row->organizationDetails->shipping_state ?? '-',
                'Sales Person'      => $row->userDetails->name ?? '-',
                'Production Date'   => $row->production_date
                                        ? Carbon::parse($row->production_date)->format('m/d/Y')
                                        : '-',
                'Order Status'      => ucfirst($row->statusDetails->status_name ?? '-'),
                'Order Total'       => $total,
                'Sales Tax Rate (%)'=> $rate,
                'Sales Tax ($)'     => $salesTax,
            ];
        });

        // Add total row
        $rows->push([
            'Order No'          => '',
            'Organization Name' => '',
            'State'             => '',
            'Sales Person'      => '',
            'Production Date'   => '',
            'Order Status'      => '',
            'Order Total'       => '',
            'Sales Tax Rate (%)'=> 'Total Sales Tax',
            'Sales Tax ($)'     => $totalSalesTax,
        ]);

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Order No',
            'Organization Name',
            'State',
            'Sales Person',
            'Production Date',
            'Order Status',
            'Order Total',
            'Sales Tax Rate (%)',
            'Sales Tax ($)',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();

        // Header styling
        $sheet->getStyle("A1:I1")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '323232'],
            ],
        ]);

        // Borders
        $sheet->getStyle("A1:I$lastRow")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Total row bold
        $sheet->getStyle("A$lastRow:I$lastRow")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT],
        ]);

        // Numeric formatting
        $sheet->getStyle("G2:G$lastRow")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
        $sheet->getStyle("H2:H$lastRow")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
        $sheet->getStyle("I2:I$lastRow")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 30,
            'C' => 15,
            'D' => 20,
            'E' => 18,
            'F' => 18,
            'G' => 15,
            'H' => 18,
            'I' => 18,
        ];
    }
}
