<?php

namespace App\Services;

use App\Models\PaymentLog;
use App\Models\CheckPayment;
use App\Models\OtherPayment;
use App\Models\PaypalPayment;
use App\Models\VenmoPayment;
use App\Models\Order;

class PaymentService
{
    const STATUS_PENDING = 0;
    const STATUS_PARTIAL = 1;
    const STATUS_PAID    = 2;
    protected array $statusNames = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_PARTIAL => 'Partial',
        self::STATUS_PAID    => 'Paid',
    ];
    public function getPaymentStatus($orderId)
    {

        $cardPayment = PaymentLog::where('order_id', $orderId)->sum('amount');
        $checkPayment = CheckPayment::where('order_id', $orderId)->where('is_approved', 1)->sum('amount');
        $otherPayment = OtherPayment::where('order_id', $orderId)->where('is_approved', 1)->sum('amount');
        $paypalPayment = PaypalPayment::where('order_id', $orderId)->where('is_approved', 1)->sum('amount');
        $venmoPayment = VenmoPayment::where('order_id', $orderId)->where('is_approved', 1)->sum('amount');

        $payment = 0;

        if ($cardPayment > 0 && $paypalPayment > 0) {
            $payment = round(((($cardPayment + $paypalPayment) * 100) / 103), 2) + $checkPayment + $venmoPayment + $otherPayment;
        } elseif ($cardPayment > 0 && $paypalPayment == 0) {
            $payment = round(($cardPayment * 100) / 103, 2) + $checkPayment + $venmoPayment + $otherPayment;
        } elseif ($cardPayment == 0 && $paypalPayment > 0) {
            $payment = $checkPayment + round((($paypalPayment * 100) / 103), 2) + $venmoPayment + $otherPayment;
        } else {
            $payment = round(($cardPayment + $checkPayment + $paypalPayment + $venmoPayment + $otherPayment), 2);
        }

        $balanceToBePaid = 0;
        $processingFee = 0;
        $orderTotal = Order::where('id', $orderId)->value('order_total');
        $totalPayment = round($cardPayment, 2) + round($paypalPayment, 2);

        if ($payment == 0 && $orderTotal > 0) {
            $paymentStatus = 0; // Pending
            $balanceToBePaid = $orderTotal - $payment;
        } elseif ($payment < round($orderTotal, 2) && $payment > 0) {
            $paymentStatus = 1; // Partial
            $balanceToBePaid = $orderTotal - $payment;
            $processingFee = round(($cardPayment + $venmoPayment) * 3 / 103, 2);
        } else {
            $paymentStatus = 2; // Paid
            if ($totalPayment > 0 && $totalPayment > $orderTotal) {
                $processingFee = round(($cardPayment + $venmoPayment) * 3 / 103, 2);
            }
        }

        if (empty($orderTotal) || (float) $orderTotal === 0.0) {
            $balanceToBePaid = 0;
            $paymentStatus = 2;
        }

        $order_no = Order::where('id', $orderId)->pluck('order_no')->first();

        if (str_starts_with($order_no, 'TSR')) {
            $balanceToBePaid = 0;
            $paymentStatus = 2;
        }

        return [
            'payment_status' => $paymentStatus,
            'payment_status_name'  => $this->statusNames[$paymentStatus] ?? 'Unknown',
            'balance_to_be_paid' => $balanceToBePaid,
            'processing_fee' => $processingFee,
            'total_payment' => $payment,
            'order_total' =>  $orderTotal,
        ];
    }
}
