<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class OtherCountryOrdersExport implements WithMultipleSheets
{
    protected $countryOrders;
    protected $overallTotalRevenue;

    public function __construct($countryOrders, $overallTotalRevenue)
    {
        $this->countryOrders = $countryOrders;
        $this->overallTotalRevenue = $overallTotalRevenue;
    }

    public function sheets(): array
    {
        $sheets = [];

        // First sheet: Summary of orders by country
        $sheets[] = new OtherCountrySummarySheet($this->countryOrders, $this->overallTotalRevenue);

        // Additional sheets: One for each country
        foreach ($this->countryOrders as $countryOrders) {
            $sheets[] = new OtherCountryOrderDetailsSheet($countryOrders);
        }

        return $sheets;
    }
}

// Summary Sheet for all countries
class OtherCountrySummarySheet implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithStyles, \Maatwebsite\Excel\Concerns\WithTitle, \Maatwebsite\Excel\Concerns\WithColumnWidths
{
    protected $countryOrders;
    protected $overallTotalRevenue;

    public function __construct($countryOrders, $overallTotalRevenue)
    {
        $this->countryOrders = $countryOrders;
        $this->overallTotalRevenue = $overallTotalRevenue;
    }

    public function collection()
    {
        return collect(
            $this->countryOrders->map(function ($countryOrders) {
                return [
                    $countryOrders['group'], // Country Name
                    $countryOrders['team_store_orders_count'],
                    $countryOrders['bulk_orders_count'],
                    $countryOrders['total_orders'],
                    $countryOrders['new_orders_count'],
                    $countryOrders['total_revenue'],
                    $countryOrders['revenue_percentage'],
                ];
            })->toArray()
        );
    }

    public function headings(): array
    {
        return [
            'Country',
            'Team Store Orders Count',
            'Bulk Orders Count',
            'Total Orders',
            'New Orders Count',
            'Total Revenue',
            'Revenue Percentage (%)',
        ];
    }

    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function title(): string
    {
        return 'Country Summary';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 25,
            'C' => 20,
            'D' => 15,
            'E' => 15,
            'F' => 20,
            'G' => 25,
        ];
    }
}

// Order Details for a single country
class OtherCountryOrderDetailsSheet implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithStyles, \Maatwebsite\Excel\Concerns\WithTitle, \Maatwebsite\Excel\Concerns\WithColumnWidths
{
    protected $countryOrders;

    public function __construct($countryOrders)
    {
        $this->countryOrders = $countryOrders;
    }

    public function collection()
    {
        return collect(
            $this->countryOrders['order_details']->map(function ($order) {
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

    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function title(): string
    {
        return $this->countryOrders['group']; // Title is the country name
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
