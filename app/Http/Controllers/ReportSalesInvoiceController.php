<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\CheckPayment;
use App\Models\PaymentLog;
use App\Models\VenmoPayment;
use App\Models\PaypalPayment;
use App\Exports\ReportSalesInvoiceExport;

class ReportSalesInvoiceController extends Controller
{

    public function index()
    {
        $orderDetails = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')
            ->where('active', 1)->where('order_total', '!=', 0)->where('organization_id', '!=', 1377)
            ->where(function ($query) {
                $query->where('order_no', 'NOT LIKE', 'TSR%')
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('order_no', 'LIKE', 'TSR%')
                                 ->where('collect_payment_via_ec', 1);
                    });
            })->get();

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
                'paymentTypes' => $paymentTypes,
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


        $firstTenItems = array_slice($combinedDetails, 0, 10);

        $totalOrderAmount1 = $orderDetails->sum('order_total');
        $totalOrderAmount = number_format($totalOrderAmount1, 2);
        $totalOrderCount = count($orderDetails);

        $partialOrderTotal = number_format($partialOrderTotal1, 2);

        $paidOrderTotal = number_format($paidOrderTotal1, 2);

        $pendingOrderTotal = number_format($pendingOrderTotal1, 2);


        return view('pages.reports.sales_invoice.index', ['firstTenItems' => $firstTenItems, 'totalOrderAmount'=>$totalOrderAmount, 'totalOrderCount'=>$totalOrderCount,
                'partialOrderTotal'=>$partialOrderTotal, 'partialOrderCount'=>$partialOrderCount, 'paidOrderTotal'=>$paidOrderTotal, 'paidOrderCount'=>$paidOrderCount,
                'pendingOrderTotal'=>$pendingOrderTotal, 'pendingOrderCount'=>$pendingOrderCount]);
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

    public function filterSalesInvoice(Request $request){
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $paymentType = $request->input('paymentType');
        $SelectedPaymentStatus = $request->input('paymentStatus');

        $orderDetails = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')
            ->where('active', 1)->where('order_total', '!=', 0)->where('organization_id', '!=', 1377)->whereBetween('created_at', [$startDate, $endDate])
            ->where(function ($query) {
                $query->where('order_no', 'NOT LIKE', 'TSR%')
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('order_no', 'LIKE', 'TSR%')
                                 ->where('collect_payment_via_ec', 1);
                    });
            })->get();

        // Filter orders based on payment type
        if ($paymentType != 'all'){
            $filteredOrders = $this->filterOrdersByPaymentType($orderDetails, $paymentType);
        } else {
            $filteredOrders = $orderDetails;
        }

        if ($SelectedPaymentStatus != 'all') {
            $filteredOrders = collect($filteredOrders)->filter(function ($order) use ($SelectedPaymentStatus) {
                $paymentDetails = $this->getPaymentDetails($order);
                return $paymentDetails['paymentStatus'] == $SelectedPaymentStatus;
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
                'paymentTypes' => $paymentTypes,
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

        return response()->json(['startDate'=>$startDate, 'combinedDetails'=>$combinedDetails]);
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


    public function salesInvoice_CSV_download($startDate, $endDate, $paymentType, $paymentStatus)
    {
        return (new ReportSalesInvoiceExport($startDate, $endDate, $paymentType, $paymentStatus))->download('Sales_Invoice.xlsx');
    }

}
