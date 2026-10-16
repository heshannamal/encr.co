<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SalesRepOrdersExport implements WithMultipleSheets
{
    protected $salesRepResults;
    protected $overallTotalRevenue;

    public function __construct($salesRepResults, $overallTotalRevenue)
    {
        $this->salesRepResults = $salesRepResults;
        $this->overallTotalRevenue = $overallTotalRevenue;
    }

    public function sheets(): array
    {
        $sheets = [];

        // First sheet: Summary of all sales reps
        $sheets[] = new SalesRepSummarySheet($this->salesRepResults, $this->overallTotalRevenue);

        // Additional sheets: One for each sales rep
        foreach ($this->salesRepResults as $salesRep) {
            $sheets[] = new SalesRepOrderDetailsSheet($salesRep);
        }

        return $sheets;
    }
}

class SalesRepSummarySheet implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths
{
    protected $salesRepResults;
    protected $overallTotalRevenue;

    public function __construct($salesRepResults, $overallTotalRevenue)
    {
        $this->salesRepResults = $salesRepResults;
        $this->overallTotalRevenue = $overallTotalRevenue;
    }

    public function collection()
    {
        return collect([
            ...$this->salesRepResults->map(function ($repResult) {
                return [
                    $repResult['sales_rep'],
                    $repResult['team_store_orders_count'],
                    $repResult['bulk_orders_count'],
                    $repResult['total_orders'],
                    $repResult['new_orders_count'],
                    $repResult['total_revenue'],
                    $repResult['revenue_percentage'],
                ];
            }),
        ]);
    }

    public function headings(): array
    {
        return [
            'Sales Rep',
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
            // Apply styles to headings
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'alignment' => ['horizontal' => 'center'],
            ],
            // Adjust general font size for the entire sheet
            'A' => ['font' => ['size' => 11]],
            'B' => ['font' => ['size' => 11]],
            'C' => ['font' => ['size' => 11]],
            'D' => ['font' => ['size' => 11]],
            'E' => ['font' => ['size' => 11]],
            'F' => ['font' => ['size' => 11]],
            'G' => ['font' => ['size' => 11]],
            // Center align the columns for numeric data
            'B' => ['alignment' => ['horizontal' => 'center']], // Team Store Orders Count
            'C' => ['alignment' => ['horizontal' => 'center']], // Bulk Orders Count
            'D' => ['alignment' => ['horizontal' => 'center']], // Total Orders
            'E' => ['alignment' => ['horizontal' => 'center']], // New Orders Count
        ];
    }

    public function title(): string
    {
        return 'Summary'; // Title for the summary sheet
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25, // Sales Rep
            'B' => 20, // Team Store Orders Count
            'C' => 20, // Bulk Orders Count
            'D' => 15, // Total Orders
            'E' => 15, // New Orders Count
            'F' => 20, // Total Revenue
            'G' => 20, // Revenue Percentage
        ];
    }
}

class SalesRepOrderDetailsSheet implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths
{
    protected $salesRep;

    public function __construct($salesRep)
    {
        $this->salesRep = $salesRep;
    }

    public function collection()
    {
        return collect([
            ...$this->salesRep['order_details']->map(function ($order) {
                return [
                    $order['order_id'],
                    $order['org_name'],
                    $order['inhand_due_date'],
                    $order['number_of_items'],
                    $order['order_amount'],
                    $order['order_status'],
                ];
            }),
        ]);
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
            // Apply styles to headings
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'alignment' => ['horizontal' => 'center'],
            ],
            // Adjust general font size for the entire sheet
            'A' => ['font' => ['size' => 11]],
            'B' => ['font' => ['size' => 11]],
            'C' => ['font' => ['size' => 11]],
            'D' => ['font' => ['size' => 11]],
            'E' => ['font' => ['size' => 11]],
            'F' => ['font' => ['size' => 11]],
            // Center align the columns for specific data
            'C' => ['alignment' => ['horizontal' => 'center']], // Inhand Due Date
            'D' => ['alignment' => ['horizontal' => 'center']], // #Items
            'E' => ['alignment' => ['horizontal' => 'center']], // Amount($)
            'F' => ['alignment' => ['horizontal' => 'center']], // Amount($)
        ];
    }

    public function title(): string
    {
        // Use sales rep name as the title of the sheet
        return $this->salesRep['sales_rep'];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, // Order ID
            'B' => 25, // Organization Name
            'C' => 20, // Inhand Due Date
            'D' => 20, // Number of Items
            'E' => 15, // Order Amount
            'F' => 15, // Order Amount
        ];
    }
}
