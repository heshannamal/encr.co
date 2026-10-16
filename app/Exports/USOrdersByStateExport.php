<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class USOrdersByStateExport implements WithMultipleSheets
{
    protected $usOrders;
    protected $overallTotalRevenue;

    public function __construct($usOrders, $overallTotalRevenue)
    {
        $this->usOrders = $usOrders;
        $this->overallTotalRevenue = $overallTotalRevenue;
    }

    public function sheets(): array
    {
        $sheets = [];

        // First sheet: Summary of orders by state in the US
        $sheets[] = new USOrdersSummarySheet($this->usOrders, $this->overallTotalRevenue);

        // Additional sheets: One for each state in the US
        foreach ($this->usOrders as $stateOrders) {
            $sheets[] = new USStateOrderDetailsSheet($stateOrders);
        }

        return $sheets;
    }
}
//test
class USOrdersSummarySheet implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths
{
    protected $usOrders;
    protected $overallTotalRevenue;

    public function __construct($usOrders, $overallTotalRevenue)
    {
        $this->usOrders = $usOrders;
        $this->overallTotalRevenue = $overallTotalRevenue;
    }

    public function collection()
    {
        return collect(
            $this->usOrders->map(function ($stateOrders) {
                return [
                    $stateOrders['group'],
                    $stateOrders['team_store_orders_count'],
                    $stateOrders['bulk_orders_count'],
                    $stateOrders['total_orders'],
                    $stateOrders['new_orders_count'],
                    $stateOrders['total_revenue'],
                    $stateOrders['revenue_percentage'],
                ];
            })->toArray()
        );
    }

    public function headings(): array
    {
        return [
            'States',
            'Team Store Orders Count',
            'Bulk Orders Count',
            'Total Orders',
            'New Orders Count',
            'Total Revenue',
            'Revenue Percentage (%)',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'alignment' => ['horizontal' => 'center'],
            ],
            'A' => ['font' => ['size' => 11]],
            'B' => ['font' => ['size' => 11]],
            'C' => ['font' => ['size' => 11]],
            'D' => ['font' => ['size' => 11]],
            'E' => ['font' => ['size' => 11]],
            'F' => ['font' => ['size' => 11]],
            'G' => ['font' => ['size' => 11]],
            // Center align the columns for numeric data
            'B' => ['alignment' => ['horizontal' => 'center']],
            'C' => ['alignment' => ['horizontal' => 'center']],
            'D' => ['alignment' => ['horizontal' => 'center']],
            'E' => ['alignment' => ['horizontal' => 'center']],
        ];
    }

    public function title(): string
    {
        return 'US Orders Summary';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25, // Lead Source
            'B' => 25, // Team Store Orders Count
            'C' => 20, // Bulk Orders Count
            'D' => 15, // Total Orders
            'E' => 15, // New Orders Count
            'F' => 20, // Total Revenue
            'G' => 25, // Revenue Percentage
        ];
    }
}

class USStateOrderDetailsSheet implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths
{
    protected $stateOrders;

    public function __construct($stateOrders)
    {
        $this->stateOrders = $stateOrders;
    }

    public function collection()
    {
        return collect(
            $this->stateOrders['order_details']->map(function ($order) {
                return [
                    $order['order_id'],
                    $order['org_name'],
                    $order['inhand_due_date'],
                    $order['number_of_items'],
                    $order['order_amount'],
                    $order['order_status'],
                ];
            })->toArray()
        );
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Organization Name',
            'Inhand Due Date',
            '#Items',
            'Amount($)',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'alignment' => ['horizontal' => 'center'],
            ],
            'A' => ['font' => ['size' => 11]],
            'B' => ['font' => ['size' => 11]],
            'C' => ['font' => ['size' => 11]],
            'D' => ['font' => ['size' => 11]],
            'E' => ['font' => ['size' => 11]],
            'F' => ['font' => ['size' => 11]],
            'C' => ['alignment' => ['horizontal' => 'center']],
            'D' => ['alignment' => ['horizontal' => 'center']],
            'A' => ['alignment' => ['horizontal' => 'center']],
            'F' => ['alignment' => ['horizontal' => 'center']],
        ];
    }

    public function title(): string
    {
        return $this->stateOrders['group']; // Title is the state name
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 25,
            'C' => 20,
            'D' => 20,
            'E' => 15,
            'F' => 15,
        ];
    }
}
