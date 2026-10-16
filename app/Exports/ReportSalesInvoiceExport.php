<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\CheckPayment;
use App\Models\PaymentLog;
use App\Models\VenmoPayment;
use App\Models\PaypalPayment;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ReportSalesInvoiceExport implements FromView, WithColumnWidths
{
    use Exportable;

    protected $startDate1;
    protected $endDate1;
    protected $paymentType1;
    protected $paymentStatus1;

    public function __construct($startDate, $endDate, $paymentType, $paymentStatus)
    {
        $this->startDate1 = $startDate;
        $this->endDate1 = $endDate;
        $this->paymentType1 = $paymentType;
        $this->paymentStatus1 = $paymentStatus;
    }
    public function view(): View
    {

        $startDate = $this->startDate1;
        $endDate = $this->endDate1;
        $paymentType = $this->paymentType1;
        $paymentStatus = $this->paymentStatus1;

        if($startDate == $endDate){

            $orderDetails = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')
            ->where('active', 1)->where('order_total', '!=', 0)->get();

            $combinedDetails = [];
            $partialOrderTotal1 = 0;
            $partialOrderCount = 0;
            $paidOrderTotal1 = 0;
            $paidOrderCount = 0;
            $pendingOrderTotal1 = 0;
            $pendingOrderCount = 0;

            foreach ($orderDetails as $order) {
                $paymentDetails = $this->getPaymentDetails($order);

                if ($paymentDetails['paymentStatus'] == 'Partial') {
                    $partialOrderTotal1 += $order->order_total;
                    $partialOrderCount++;
                }

                if ($paymentDetails['paymentStatus'] == 'Paid') {
                    $paidOrderTotal1 += $order->order_total;
                    $paidOrderCount++;
                }

                if ($paymentDetails['paymentStatus'] == 'Pending') {
                    $pendingOrderTotal1 += $order->order_total;
                    $pendingOrderCount++;
                }

                $cardPayment = PaymentLog::where('order_id', $order->id)->get();
                $checkPayment = CheckPayment::where('order_id', $order->id)->get();
                $venmoPayment = VenmoPayment::where('order_id', $order->id)->get();
                $paypalPayment = PaypalPayment::where('order_id', $order->id)->get();

                $paymentTypes = [];

                // Check and add payment types to the array
                if (!$cardPayment->isEmpty()) {
                    $paymentTypes[] = 'Card';
                }

                if (!$checkPayment->isEmpty()) {
                    $paymentTypes[] = 'Check';
                }

                if (!$venmoPayment->isEmpty()) {
                    $paymentTypes[] = 'Venmo';
                }

                if (!$paypalPayment->isEmpty()) {
                    $paymentTypes[] = 'Paypal';
                }

                $paymentTypesString = implode(', ', $paymentTypes);

                $details = [
                    'order' => $order,
                    'organization' => $order->organizationDetails,
                    'user' => $order->userDetails,
                    'contact' => $order->contactDetails,
                    'status' => $order->statusDetails,
                    'team_store' => $order->teamStoreDetails,
                    'payment' => $paymentDetails['payment'],
                    'paymentStatus' => $paymentDetails['paymentStatus'],
                    'payedAmount' => $paymentDetails['payedAmount'],
                    'paymentCal' => $paymentDetails['paymentCal'],
                    'paymentTypes' => $paymentTypesString,
                ];

                if (!$cardPayment->isEmpty()) {
                    $details['paymentApproval'] = 'Approved';
                }

                if (!$checkPayment->isEmpty()) {
                    $details['paymentApproval'] = $this->getApprovalStatus($checkPayment);
                }

                if (!$venmoPayment->isEmpty()) {
                    $details['paymentApproval'] = $this->getApprovalStatus($venmoPayment);
                }

                if (!$paypalPayment->isEmpty()) {
                    $details['paymentApproval'] = $this->getApprovalStatus($paypalPayment);
                }

                $combinedDetails[] = [
                    'order_id' => $order->id,
                    'details' => $details,
                ];
            }

            $firstTenItems = $combinedDetails;


            return view('pages.reports.sales_invoice.export_csv', [
                'firstTenItems' => $firstTenItems,  'partialOrderCount'=>$partialOrderCount, 'paidOrderCount'=>$paidOrderCount,
                 'pendingOrderCount'=>$pendingOrderCount
            ]);
        } else {

            $orderDetails = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')
            ->where('active', 1)->where('order_total', '!=', 0)->whereBetween('created_at', [$startDate, $endDate])->get();

            // Filter orders based on payment type
            if ($paymentType != 'all'){
                $filteredOrders = $this->filterOrdersByPaymentType($orderDetails, $paymentType);
            } else {
                $filteredOrders = $orderDetails;
            }

            if ($paymentStatus != 'all') {
                $filteredOrders = collect($filteredOrders)->filter(function ($order) use ($paymentStatus) {
                    $paymentDetails = $this->getPaymentDetails($order);
                    return $paymentDetails['paymentStatus'] == $paymentStatus;
                })->values();
            }



            $combinedDetails = [];

            foreach ($filteredOrders as $order) {
                $paymentDetails = $this->getPaymentDetails($order);

                $cardPayment = PaymentLog::where('order_id', $order->id)->get();
                $checkPayment = CheckPayment::where('order_id', $order->id)->get();
                $venmoPayment = VenmoPayment::where('order_id', $order->id)->get();
                $paypalPayment = PaypalPayment::where('order_id', $order->id)->get();

                $paymentTypes = [];

                // Check and add payment types to the array
                if (!$cardPayment->isEmpty()) {
                    $paymentTypes[] = 'Card';
                }

                if (!$checkPayment->isEmpty()) {
                    $paymentTypes[] = 'Check';
                }

                if (!$venmoPayment->isEmpty()) {
                    $paymentTypes[] = 'Venmo';
                }

                if (!$paypalPayment->isEmpty()) {
                    $paymentTypes[] = 'Paypal';
                }

                $paymentTypesString = implode(', ', $paymentTypes);

                $details = [
                    'order' => $order,
                    'organization' => $order->organizationDetails,
                    'user' => $order->userDetails,
                    'contact' => $order->contactDetails,
                    'status' => $order->statusDetails,
                    'team_store' => $order->teamStoreDetails,
                    'payment' => $paymentDetails['payment'],
                    'paymentStatus' => $paymentDetails['paymentStatus'],
                    'payedAmount' => $paymentDetails['payedAmount'],
                    'paymentCal' => $paymentDetails['paymentCal'],
                    'paymentTypes' => $paymentTypesString,
                ];

                if (!$cardPayment->isEmpty()) {
                    $details['paymentApproval'] = 'Approved';
                }

                if (!$checkPayment->isEmpty()) {
                    $details['paymentApproval'] = $this->getApprovalStatus($checkPayment);
                }

                if (!$venmoPayment->isEmpty()) {
                    $details['paymentApproval'] = $this->getApprovalStatus($venmoPayment);
                }

                if (!$paypalPayment->isEmpty()) {
                    $details['paymentApproval'] = $this->getApprovalStatus($paypalPayment);
                }

                $combinedDetails[] = [
                    'order_id' => $order->id,
                    'details' => $details,
                ];
            }

            $firstTenItems = $combinedDetails;

            return view('pages.reports.sales_invoice.export_csv', [
                'firstTenItems' => $firstTenItems,
            ]);

        }

    }

    public function getApprovalStatus($payments)
    {
        foreach ($payments as $payment) {
            if ($payment->is_approved == 1) {
                return 'Approved';
            } elseif ($payment->is_approved == 0) {
                return 'Rejected';
            }
        }

        return 'Not Approved';
    }


    public function getPaymentDetails($order)
    {
        $cardPaymenttot = PaymentLog::where('order_id', $order->id)->sum('amount');
        $checkPaymenttot = CheckPayment::where('order_id', $order->id)->sum('amount');
        $venmoPaymenttot = VenmoPayment::where('order_id', $order->id)->sum('amount');
        $paypalPaymenttot = PaypalPayment::where('order_id', $order->id)->sum('amount');

        $payment = number_format($cardPaymenttot + $checkPaymenttot + $venmoPaymenttot + $paypalPaymenttot, 2);
        $paymentCal = $cardPaymenttot + $checkPaymenttot + $venmoPaymenttot + $paypalPaymenttot;
        $orderTotal = number_format($order->order_total, 2);

        $paymentStatus = 'Pending';

        if ($payment == 0) {
            $paymentStatus = "Pending";
        } else if ($payment < $orderTotal && $payment > 0) {
            $paymentStatus = "Partial";
        } else {
            $paymentStatus = "Paid";
        }

        return [
            'payment' => $payment,
            'paymentCal' =>$paymentCal,
            'paymentStatus' => $paymentStatus,
            'payedAmount' => $payment, 2,
        ];
    }

    private function filterOrdersByPaymentType($orderDetails, $paymentType) {
        $filteredOrders = [];

        foreach ($orderDetails as $order) {
            $cardPayment = PaymentLog::where('order_id', $order->id)->get();
            $checkPayment = CheckPayment::where('order_id', $order->id)->get();
            $venmoPayment = VenmoPayment::where('order_id', $order->id)->get();
            $paypalPayment = PaypalPayment::where('order_id', $order->id)->get();

            if ($paymentType == 'Check' && !$checkPayment->isEmpty()) {
                $filteredOrders[] = $order;
            } else if ($paymentType == 'Online' && !$cardPayment->isEmpty()) {
                $filteredOrders[] = $order;
            } else if ($paymentType == 'Venmo' && !$venmoPayment->isEmpty()) {
                $filteredOrders[] = $order;
            } else if ($paymentType == 'Paypal' && !$paypalPayment->isEmpty()) {
                $filteredOrders[] = $order;
            }
        }

        return $filteredOrders;
    }


    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 30,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 20,
            'I' => 20,
        ];
    }

}
