<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Services\NotificationBuilderService;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Models\Order;
use App\Services\EmailNotificationBuilderService;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Font;

class CreateWeeklyNotification extends Command
{
    protected $signature = 'notification:create-weekly';
    protected $description = 'Send weekly sent to production order report notification';

    private function ordinal(int $number): string
    {
        if (!in_array($number % 100, [11, 12, 13])) {
            switch ($number % 10) {
                case 1: return $number . 'st';
                case 2: return $number . 'nd';
                case 3: return $number . 'rd';
            }
        }
        return $number . 'th';
    }

    public function handle()
    {
        $tz = 'America/Los_Angeles';

        $startDate = Carbon::now($tz)->subWeek()->startOfWeek(Carbon::MONDAY);
        $endDate = Carbon::now($tz)->subWeek()->endOfWeek(Carbon::SUNDAY);

        // File name
        $fileName = 'weekly_production_orders_' . $startDate->format('Ymd') . '_to_' . $endDate->format('Ymd') . '.xlsx';

        $filePath = storage_path('app/reports/' . $fileName);

        // Generate Excel file
        $this->generateReport($startDate, $endDate, $filePath);

        // Download link
        $downloadLink = route('report.download', ['filename' => $fileName]);

        $weekOfMonth = (int) ceil($startDate->day / 7);
        $weekOrdinal = $this->ordinal($weekOfMonth);
        $monthName   = $startDate->format('F');

        // Send notification
        (new NotificationBuilderService())->sendNotification(
            'key_send_weekly_order_production',
            [
                '{download_link}' => $downloadLink,
                '{file_name}'     => $fileName,
                '{start_date}'    => $startDate->format('M j'),
                '{end_date}'      => $endDate->format('M j, Y'),
                '{week_ordinal}'  => $weekOrdinal,
                '{month_name}'    => $monthName
            ],
            [
                'target_notification_field' => 'key_send_weekly_order_production',
                'new_notification'          => 1,
            ]
        );

        // Send email
        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate(
            'key_email_send_weekly_order_production',
            [
                'download_link'    => $downloadLink,
                'file_name'        => $fileName,
                'start_date'       => $startDate->format('F j'),
                'end_date'         => $endDate->format('F j, Y'),
            ]
        );
    }

    /**
     * Generate and save Excel report
     */
    private function generateReport($startDate, $endDate, $filePath)
    {
        $start = $startDate->copy()->startOfDay()->format('Y-m-d');
        $end   = $endDate->copy()->endOfDay()->format('Y-m-d');

        $orders = Order::query()
            ->where('active', 1)
            ->whereNotNull('production_date')
            ->with(['organizationDetails', 'orderItems.productDetails'])
            ->whereRaw(
                "STR_TO_DATE(production_date, '%m/%d/%Y') BETWEEN ? AND ?",
                [$start, $end]
            )
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->fromArray(['Customer Name', 'Order No', 'Production Date', 'Line Items'], null, 'A1');

        $sheet->getStyle('A1:D1')->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $row = 2;

        foreach ($orders as $order) {
            foreach ($order->orderItems as $index => $item) {

                $sheet->setCellValue('A' . $row, $index === 0 ? ($order->organizationDetails->organization_name ?? '-') : '');
                $sheet->setCellValue('B' . $row, $index === 0 ? $order->order_no : '');
                $sheet->setCellValue(
                    'C' . $row,
                    $index === 0 ? Carbon::createFromFormat('m/d/Y', $order->production_date)->format('m/d/Y') : ''
                );

                $productName = $item->productDetails->product_name ?? 'N/A';
                $lineItem = $productName . ($item->item_description ? ' - ' . $item->item_description : '');

                $url = route('orderitem.info', [
                    'orderid' => $order->id,
                    'orderItemId' => $item->id
                ]);

                $sheet->setCellValue('D' . $row, $lineItem);
                $sheet->getCell('D' . $row)->getHyperlink()->setUrl($url);

                // ✅ Style like real hyperlink (blue + underline)
                $sheet->getStyle('D' . $row)->getFont()->setUnderline(Font::UNDERLINE_SINGLE)->getColor()->setARGB(Color::COLOR_BLUE);

                // Alignment
                $sheet->getStyle('A' . $row . ':D' . $row)
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);

                $sheet->getStyle('B' . $row . ':C' . $row)
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $row++;
            }

            $row++; // spacing row
        }

        $writer = new Xlsx($spreadsheet);

        // ✅ Safe overwrite (atomic)
        $this->saveWithOverwrite($writer, $filePath);
    }

    /**
     * Safe overwrite (prevents corruption)
     */
    private function saveWithOverwrite($writer, $filePath)
    {
        $dir = dirname($filePath);

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $tempPath = $filePath . '.tmp';

        $writer->save($tempPath);

        // Atomic replace
        rename($tempPath, $filePath);
    }
}
