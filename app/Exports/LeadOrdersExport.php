<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LeadOrdersExport implements WithMultipleSheets
{
    protected $leadResults;
    protected $overallTotalRevenue;

    public function __construct($leadResults, $overallTotalRevenue)
    {
        $this->leadResults = $leadResults;
        $this->overallTotalRevenue = $overallTotalRevenue;
    }

    public function sheets(): array
    {
        $sheets = [];

        // First sheet: Summary of all lead sources
        $sheets[] = new LeadSummarySheet($this->leadResults, $this->overallTotalRevenue);

        // Additional sheets: One for each lead source
        foreach ($this->leadResults as $leadResult) {
            $sheets[] = new LeadOrderDetailsSheet($leadResult);
        }

        return $sheets;
    }
}

class LeadSummarySheet implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths
{
    protected $leadResults;
    protected $overallTotalRevenue;

    public function __construct($leadResults, $overallTotalRevenue)
    {
        $this->leadResults = $leadResults;
        $this->overallTotalRevenue = $overallTotalRevenue;
    }

    public function collection()
    {
        return collect([
            ...$this->leadResults->map(function ($leadResult) {
                return [
                    $leadResult['lead_source'],
                    $leadResult['team_store_orders_count'],
                    $leadResult['bulk_orders_count'],
                    $leadResult['total_orders'],
                    $leadResult['new_orders_count'],
                    $leadResult['total_revenue'],
                    $leadResult['revenue_percentage'],
                ];
            }),
        ]);
    }

    public function headings(): array
    {
        return [
            'Lead Source',
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
            'B' => ['alignment' => ['horizontal' => 'center']],
            'C' => ['alignment' => ['horizontal' => 'center']],
            'D' => ['alignment' => ['horizontal' => 'center']],
            'E' => ['alignment' => ['horizontal' => 'center']],
        ];
    }

    public function title(): string
    {
        return 'Lead Source Summary'; // Title for the summary sheet
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25, // Lead Source
            'B' => 20, // Team Store Orders Count
            'C' => 20, // Bulk Orders Count
            'D' => 15, // Total Orders
            'E' => 15, // New Orders Count
            'F' => 20, // Total Revenue
            'G' => 20, // Revenue Percentage
        ];
    }
}

class LeadOrderDetailsSheet implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths
{
    protected $lead;

    public function __construct($lead)
    {
        $this->lead = $lead;
    }

    public function collection()
    {
        return collect([
            ...$this->lead['order_details']->map(function ($order) {
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
            'A' => ['alignment' => ['horizontal' => 'center']], // Amount($)
            'F' => ['alignment' => ['horizontal' => 'center']],
        ];
    }

    public function title(): string
    {
        return $this->lead['lead_source']; // Use lead source name as the title of the sheet
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
