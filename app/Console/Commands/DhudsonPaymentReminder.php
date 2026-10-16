<?php

namespace App\Console\Commands;

use App\Models\{Order, PaymentLog, CheckPayment, OtherPayment, PaypalPayment, VenmoPayment, Organization};
use App\Services\EmailNotificationBuilderService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DhudsonPaymentReminder extends Command
{
    protected $signature = 'email:d-hudson-payment-reminder';
    protected $description = 'Send weekly d-hudson payment reminder email';

    public function handle()
    {
        $groups = $this->getDueOrderList();

        if ($groups->isEmpty()) {
            $this->info('No due orders found.');
            return self::SUCCESS;
        }

        foreach ($groups as $organizationId => $orders) {
            $organization = Organization::whereKey($organizationId)
                ->where('internal_team', '!=', 1)
                ->first();

            if (!$organization || $orders->sum('balance_to_be_paid') <= 1) {
                continue;
            }

            app(EmailNotificationBuilderService::class)->sendEmailFromTemplate(
                'key_email_send_payment_remaining_d_hudson',
                [
                    'organization_id' => $organization->id,
                    'organization' => $organization,
                    'orders' => $orders,
                    'bulk_payment_url' => route('customer_portal.pay_multiple_orders', [
                        'order_ids' => $orders->pluck('id')->implode(','),
                    ]),
                    'custom_email' => [
                        'to' => [
                            'jeff@dhudsongolfwear.com',
                            'kristi@dhudsongolfwear.com',
                        ],
                    ],
                ]
            );
        }

        return self::SUCCESS;
    }

    public function getDueOrderList()
    {
        $maxDueDays = (int) env('MAX_DUE_DAYS', 7);
        $tsrCutoff = Carbon::create(2025, 12, 31)->startOfDay();

        // Query once. The TSR cutoff is applied after parsing production_date,
        // which supports both m/d/Y strings and SQL date/datetime values.
        $orders = Order::with([
            'organizationDetails:id,organization_name',
            'contactDetails:id,first_name,email',
            'orderItems:id,order_id,unit_price,qty,total,sub_product_no',
            'orderItems.subProduct:id,sub_product_no,product_name,pattern_code',
        ])
            ->where('organization_id', 4184)
            ->where('active', 1)
            ->whereIn('order_status_id', [3, 4])
            ->whereNotNull('production_date')
            ->orderByDesc('id')
            ->get();

        if ($orders->isEmpty()) {
            return collect();
        }

        // Five grouped SUM queries instead of five queries for every order.
        $totals = $this->loadPaymentTotals($orders->pluck('id')->all());

        return $orders->filter(function ($order) use ($maxDueDays, $tsrCutoff, $totals) {
            $productionDate = $this->parseProductionDate($order->production_date);

            if (!$productionDate) {
                return false;
            }

            if (stripos((string) $order->order_no, 'TSR') === 0
                && !$productionDate->greaterThan($tsrCutoff)) {
                return false;
            }

            $details = $this->getPaymentDetails($order, $totals, $productionDate);
            $overdueDays = -$details['remainingDays'];

            if ($overdueDays <= $maxDueDays
                || $details['paymentStatus'] === 2
                || $details['balanceToBePaid'] <= 0) {
                return false;
            }

            $order->payment_status = $details['paymentStatus'];
            $order->balance_to_be_paid = $details['balanceToBePaid'];
            $order->remaining_days = $details['remainingDays'];
            $order->payment = $details['payment'];
            $order->paid_processing_fee = $details['paid_processing_fee'];

            return true;
        })->groupBy('organization_id');
    }

    public function getPaymentDetails($order, ?array $totals = null, ?Carbon $productionDate = null)
    {
        $empty = [
            'paymentStatus' => 2,
            'balanceToBePaid' => 0,
            'remainingDays' => 0,
            'payment' => 0,
            'paid_processing_fee' => 0,
        ];

        if (!$order) {
            return $empty;
        }

        $totals ??= $this->loadPaymentTotals([$order->id]);
        $productionDate ??= $this->parseProductionDate($order->production_date);
        $remainingDays = $productionDate
            ? Carbon::today()->diffInDays($productionDate, false)
            : 0;

        $amount = fn ($type) => (float) ($totals[$type][$order->id] ?? 0);
        $netCard = $amount('card') > 0 ? round($amount('card') * 100 / 103, 2) : 0;
        $netPaypal = $amount('paypal') > 0 ? round($amount('paypal') * 100 / 103, 2) : 0;
        $processingFee = round(($netCard + $netPaypal) * 0.03, 2);
        $paid = round(
            $netCard + $netPaypal + $amount('check') + $amount('other') + $amount('venmo'),
            2
        );

        $total = round((float) $order->order_total, 2);
        $status = $total == 0 || $paid >= $total ? 2 : ($paid > 0 ? 1 : 0);

        return [
            'paymentStatus' => $status,
            'balanceToBePaid' => max(0, round($total - $paid, 2)),
            'remainingDays' => $remainingDays,
            'payment' => $paid,
            'paid_processing_fee' => $processingFee,
        ];
    }

    private function loadPaymentTotals(array $orderIds): array
    {
        $sources = [
            'card' => PaymentLog::query(),
            'check' => CheckPayment::where('is_approved', 1),
            'other' => OtherPayment::where('is_approved', 1),
            'paypal' => PaypalPayment::where('is_approved', 1),
            'venmo' => VenmoPayment::where('is_approved', 1),
        ];

        $totals = [];

        foreach ($sources as $type => $query) {
            $totals[$type] = $query->whereIn('order_id', $orderIds)
                ->select('order_id')
                ->selectRaw('SUM(amount) AS total')
                ->groupBy('order_id')
                ->pluck('total', 'order_id')
                ->all();
        }

        return $totals;
    }

    private function parseProductionDate($value): ?Carbon
    {
        if ($value instanceof \DateTimeInterface) {
            return Carbon::instance($value)->startOfDay();
        }

        $value = trim((string) $value);

        foreach (['!m/d/Y', '!Y-m-d', '!Y-m-d H:i:s'] as $format) {
            try {
                $date = Carbon::createFromFormat($format, $value);
                if ($date !== false) {
                    return $date->startOfDay();
                }
            } catch (\Throwable $e) {
                // Try the next supported date format.
            }
        }

        return null;
    }
}
