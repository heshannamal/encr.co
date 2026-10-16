<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\PaymentLog;
use App\Models\CheckPayment;
use App\Models\OtherPayment;
use App\Models\PaypalPayment;
use App\Models\VenmoPayment;
use App\Models\Organization;
use App\Services\EmailNotificationBuilderService;
use Carbon\Carbon;

class CustomerPaymentReminder extends Command
{
    protected $signature = 'email:customer-payment-reminder';
    protected $description = 'Send weekly customer payment reminder email';

    public function handle()
    {
        $remainingOrderList = $this->getDueOrderList();

        if ($remainingOrderList->isEmpty()) {
            $this->info('No due orders found.');
            return Command::SUCCESS;
        }

        foreach ($remainingOrderList as $organizationId => $orderGroup) {
            if ($orderGroup->isEmpty()) {
                continue;
            }

            $organizationDetails = Organization::where('id', $organizationId)->where('internal_team', '!=', 1)->first();

            if (!$organizationDetails) {
                continue;
            }

            $orderIds = $orderGroup->pluck('id')->implode(',');

            $bulkPaymentUrl = route('customer_portal.pay_multiple_orders', [
                'order_ids' => $orderIds,
            ]);

            if($orderGroup->sum('balance_to_be_paid') > 1){
                app(EmailNotificationBuilderService::class)->sendEmailFromTemplate(
                    'key_email_send_payment_remaining_customer',
                    [
                        'organization_id' => $organizationDetails->id,
                        'orders' => $orderGroup,
                        'organization' => $organizationDetails,
                        'bulk_payment_url' => $bulkPaymentUrl,
                    ]
                );
            }


        }

        return Command::SUCCESS;
    }

    public function getDueOrderList()
    {
        $maxDueDays = (int) env('MAX_DUE_DAYS', 7);

        $NonTsrOrders = Order::with([
            'organizationDetails:id,organization_name',
            'contactDetails:id,first_name,email',
            'orderItems:id,order_id,unit_price,qty,total,sub_product_no',
            'orderItems.subProduct:id,sub_product_no,product_name,pattern_code'
        ])
        ->where('order_no', 'not like', 'TSR%')
        ->whereNotNull('production_date')
        ->whereIn('order_status_id', [3, 4])->whereNotIn('organization_id', [1377, 4184])
        ->where('active', 1)
        ->orderByDesc('id')
        ->get();

        $TsrOrders = Order::with([
            'organizationDetails:id,organization_name',
            'contactDetails:id,first_name,email',
            'orderItems:id,order_id,unit_price,qty,total,sub_product_no',
            'orderItems.subProduct:id,sub_product_no,product_name,pattern_code'
        ])
        ->where('order_no', 'like', 'TSR%')
        ->whereDate('production_date', '>', '2025-12-31')
        ->whereNotNull('production_date')
        ->whereIn('order_status_id', [3, 4])->whereNotIn('organization_id', [1377, 4184])
        ->where('active', 1)
        ->orderByDesc('id')
        ->get();

        $orders = $NonTsrOrders->merge($TsrOrders);

        $filteredOrders = $orders->filter(function ($order) use ($maxDueDays) {
            $paymentDetails = $this->getPaymentDetails($order);

            $overdueDays = -$paymentDetails['remainingDays'];

            if (
                in_array($paymentDetails['paymentStatus'], [0, 1], true) &&
                $overdueDays > $maxDueDays &&
                $paymentDetails['balanceToBePaid'] > 0
            ) {
                $order->payment_status = $paymentDetails['paymentStatus'];
                $order->balance_to_be_paid = $paymentDetails['balanceToBePaid'];
                $order->remaining_days = $paymentDetails['remainingDays'];
                $order->payment = $paymentDetails['payment'];
                $order->paid_processing_fee = $paymentDetails['paid_processing_fee'];

                return true;
            }

            return false;
        });

        return $filteredOrders->groupBy('organization_id');
    }

    public function getPaymentDetails($order)
    {
        if (!$order) {
            return [
                'paymentStatus' => 2,
                'balanceToBePaid' => 0,
                'remainingDays' => 0,
                'payment' => 0,
                'paid_processing_fee' => 0,
            ];
        }

        $remainingDays = 0;

        if (!empty($order->production_date)) {
            try {
                $productionDate = Carbon::createFromFormat('m/d/Y', $order->production_date);
                $currentDate = now();
                $remainingDays = $currentDate->diffInDays($productionDate, false);
            } catch (\Exception $e) {
                $remainingDays = 0;
            }
        }

        $orderId = $order->id;

        $cardPayment   = PaymentLog::where('order_id', $orderId)->sum('amount') ?? 0;
        $checkPayment  = CheckPayment::where('order_id', $orderId)->where('is_approved', 1)->sum('amount') ?? 0;
        $otherPayment  = OtherPayment::where('order_id', $orderId)->where('is_approved', 1)->sum('amount') ?? 0;
        $paypalPayment = PaypalPayment::where('order_id', $orderId)->where('is_approved', 1)->sum('amount') ?? 0;
        $venmoPayment  = VenmoPayment::where('order_id', $orderId)->where('is_approved', 1)->sum('amount') ?? 0;

        $netCardPayment   = $cardPayment > 0 ? round(($cardPayment * 100) / 103, 2) : 0;
        $netPaypalPayment = $paypalPayment > 0 ? round(($paypalPayment * 100) / 103, 2) : 0;

        $paid_processing_fee = round(($netCardPayment + $netPaypalPayment) * 0.03, 2);

        $payment = round(
            $netCardPayment +
            $netPaypalPayment +
            $checkPayment +
            $venmoPayment +
            $otherPayment,
            2
        );

        $orderTotal = round($order->order_total, 2);
        $balanceToBePaid = max(0, round($orderTotal - $payment, 2));

        if ($orderTotal == 0) {
            $paymentStatus = 2;
        } elseif ($payment <= 0) {
            $paymentStatus = 0;
        } elseif ($payment < $orderTotal) {
            $paymentStatus = 1;
        } else {
            $paymentStatus = 2;
        }

        return [
            'paymentStatus' => $paymentStatus,
            'balanceToBePaid' => $balanceToBePaid,
            'remainingDays' => $remainingDays,
            'payment' => $payment,
            'paid_processing_fee' => $paid_processing_fee,
        ];
    }
}
