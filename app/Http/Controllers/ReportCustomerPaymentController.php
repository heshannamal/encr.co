<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\CheckPayment;
use App\Models\PaymentLog;
use App\Models\VenmoPayment;
use App\Models\PaypalPayment;
use App\Exports\ReportCustomerPaymentExport;

class ReportCustomerPaymentController extends Controller
{
    public function index(){

        $onlinePayments = PaymentLog::where('response_code','1')->get();

        $checkPayments = CheckPayment::get();

        $venmoPayments = VenmoPayment::get();

        $paypalPayments = PaypalPayment::get();

        $TrasnsactionsArray = [];


        foreach($onlinePayments as $onlinePayment)
        {
            $orderPaymentsArray = [];

            $orderDetails = Order::where('id',$onlinePayment->order_id)->with('organizationDetails')->where('organization_id', '!=', 1377)->where('order_no', 'NOT LIKE', 'TSR%')->get();

            if ($orderDetails->isEmpty()) {
                continue;
            }
            $order_no = $orderDetails[0]->order_no;
            $sub_total = $orderDetails[0]->sub_total;
            $shipping = $orderDetails[0]->shipping;
            $sales_tax = $orderDetails[0]->sales_tax;
            $artwork = $orderDetails[0]->artwork;
            $totalQty = $orderDetails[0]->orderItems->sum('qty');

            $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];
            $cardPaymenttot = PaymentLog::where('order_id', $onlinePayment->order_id)->sum('amount');
            $checkPaymenttot = CheckPayment::where('order_id', $onlinePayment->order_id)->sum('amount');
            $payment = $cardPaymenttot + $checkPaymenttot;

            $balnceToBePaid = 0;
            if ($payment == 0) {
                $paymentStatus = "Pending";
                $paymentStatus2 = 0;
            } else if ($payment < $orderDetails[0]->order_total && $payment > 0) {
                $balnceToBePaid = $orderDetails[0]->order_total - $payment;
                $paymentStatus = "Partial";
                $paymentStatus2 = 1;
            } else {
                $paymentStatus = "Paid";
                $paymentStatus2 = 2;
            }
            $processingFee = round(($cardPaymenttot)*3/103 , 2);

            $cardPaymentRecords = PaymentLog::where('order_id', $onlinePayment->order_id)->where('response_code','1')->get();
            $checkPaymentRecords = CheckPayment::where('order_id', $onlinePayment->order_id)->where('is_approved','1')->get();

            foreach($cardPaymentRecords as $cardPaymentRecord){
                $orderPaymentsArray[] = array('Method'=>'Online','NameonCard'=>$cardPaymentRecord->name_on_card, 'TransactionId'=>$cardPaymentRecord->transaction_id, 'Amount'=>$cardPaymentRecord->amount, 'PaymentDate'=>$cardPaymentRecord->created_at);
            }
            foreach($checkPaymentRecords as $checkPaymentRecord){
                $orderPaymentsArray[] = array('Method'=>'Check','NameonCard'=>'N/A', 'TransactionId'=>'N/A', 'Amount'=>$checkPaymentRecord->amount, 'PaymentDate'=>$checkPaymentRecord->created_at);
            }


            $payedAmount = number_format($payment, 2);

            // $TrasnsactionsArray[] = array('Order'=> $onlinePayment->order_id, 'PaymentType'=>'Online', 'TeamName'=> $organization_name, 'NameonCard'=> $onlinePayment->name_on_card, 'checkStatus'=> 'Approved', 'Amount'=> $onlinePayment->amount, 'OrderStatus'=> $paymentStatus, 'TransactionID'=> $onlinePayment->transaction_id,
            //                 'PaymentDate'=> $onlinePayment->created_at, 'OrderPayments'=>json_encode($orderPaymentsArray), 'OrderTotal' => $orderDetails[0]->order_total, 'OpenDate' => $orderDetails[0]->open_date, 'DueDate' => $orderDetails[0]->due_date, 'payedAmount'=>$payedAmount);

            $TrasnsactionsArray[] = array('Order'=> $onlinePayment->order_id, 'OrderNo'=>$order_no, 'paymentStatus2'=>$paymentStatus2, 'balnceToBePaid'=>$balnceToBePaid,  'processingFee'=>$processingFee, 'TotalQty' => $totalQty, 'SubTotal'=>$sub_total , 'Shipping'=>$shipping , 'SalesTax'=>$sales_tax , 'ArtWork'=>$artwork , 'PaymentType'=>'Online', 'TeamName'=> $organization_name, 'NameonCard'=> $onlinePayment->name_on_card, 'checkStatus'=> 'Approved', 'Amount'=> $onlinePayment->amount, 'OrderStatus'=> $paymentStatus, 'TransactionID'=> $onlinePayment->transaction_id,
                            'PaymentDate'=> $onlinePayment->created_at, 'OrderPayments'=>json_encode($orderPaymentsArray));

        }

        foreach($checkPayments as $checkPayment)
        {
            $orderPaymentsArray = [];
            //return $checkPayment->order_id;
            $orderDetails = Order::where('id',$checkPayment->order_id)->with('organizationDetails')->where('organization_id', '!=', 1377)->where('order_no', 'NOT LIKE', 'TSR%')->get();

            if ($orderDetails->isEmpty()) {
                continue;
            }

            $order_no = $orderDetails[0]->order_no;
            $sub_total = $orderDetails[0]->sub_total;
            $shipping = $orderDetails[0]->shipping;
            $sales_tax = $orderDetails[0]->sales_tax;
            $artwork = $orderDetails[0]->artwork;
            $totalQty = $orderDetails[0]->orderItems->sum('qty');

            $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];
            $cardPaymenttot = PaymentLog::where('order_id', $checkPayment->order_id)->sum('amount');
            $checkPaymenttot = CheckPayment::where('order_id', $checkPayment->order_id)->sum('amount');
            $payment = $cardPaymenttot + $checkPaymenttot;


            $balnceToBePaid = 0;
            if ($payment == 0) {
                $paymentStatus = "Pending";
                $paymentStatus2 = 0;
            } else if ($payment < $orderDetails[0]->order_total && $payment > 0) {
                $balnceToBePaid = $orderDetails[0]->order_total - $payment;
                $paymentStatus = "Partial";
                $paymentStatus2 = 1;
            } else {
                $paymentStatus = "Paid";
                $paymentStatus2 = 2;
            }

            if($checkPayment->is_approved == "1")
            {
                $checkStatus = "Approved";
            }
            elseif($checkPayment->is_approved == "3")
            {
                $checkStatus = "Rejected";
            }
            else{
                $checkStatus = "Not Approved";
            }

            $processingFee = number_format(0, 2);

            $cardPaymentRecords = PaymentLog::where('order_id', $checkPayment->order_id)->where('response_code','1')->get();
            $checkPaymentRecords = CheckPayment::where('order_id', $checkPayment->order_id)->where('is_approved','1')->get();

            $checkPaymentId = 'CHQ'.str_pad(($checkPayment->id), 6, "0", STR_PAD_LEFT);

            foreach($cardPaymentRecords as $cardPaymentRecord){
                $orderPaymentsArray[] = array('Method'=>'Online','NameonCard'=>$cardPaymentRecord->name_on_card, 'TransactionId'=>$cardPaymentRecord->transaction_id, 'Amount'=>$cardPaymentRecord->amount, 'PaymentDate'=>$cardPaymentRecord->created_at);
            }
            foreach($checkPaymentRecords as $checkPaymentRecord){
                $orderPaymentsArray[] = array('Method'=>'Check','NameonCard'=>'N/A', 'TransactionId'=>$checkPaymentId, 'Amount'=>$checkPaymentRecord->amount, 'PaymentDate'=>$checkPaymentRecord->created_at);
            }


            $payedAmount = number_format($payment, 2);

            // $TrasnsactionsArray[] = array('Order'=> $checkPayment->order_id,'PaymentType'=>'Check', 'TeamName'=> $organization_name, 'NameonCard'=> 'N/A', 'checkStatus'=> $checkStatus, 'Amount'=> $checkPayment->amount, 'OrderStatus'=> $paymentStatus, 'TransactionID'=> $checkPaymentId,
            //                 'PaymentDate'=> $checkPayment->created_at, 'checkFImage'=>$checkPayment->check_front, 'checkBImage'=>$checkPayment->check_back, 'OrderPayments'=>json_encode($orderPaymentsArray), 'OrderTotal' => $orderDetails[0]->order_total, 'OpenDate' => $orderDetails[0]->open_date, 'DueDate' => $orderDetails[0]->due_date, 'payedAmount'=>$payedAmount);

            $TrasnsactionsArray[] = array('Order'=> $checkPayment->order_id,'processingFee'=>$processingFee, 'paymentStatus2'=>$paymentStatus2,  'balnceToBePaid'=>$balnceToBePaid,  'OrderNo'=>$order_no, 'TotalQty' => $totalQty,  'SubTotal'=>$sub_total , 'Shipping'=>$shipping , 'SalesTax'=>$sales_tax , 'ArtWork'=>$artwork ,  'PaymentType'=>'Check', 'TeamName'=> $organization_name, 'NameonCard'=> 'N/A', 'checkStatus'=> $checkStatus, 'Amount'=> $checkPayment->amount, 'OrderStatus'=> $paymentStatus, 'TransactionID'=> $checkPaymentId, 'PaymentDate'=> $checkPayment->created_at, 'checkFImage'=>$checkPayment->check_front, 'checkBImage'=>$checkPayment->check_back, 'OrderPayments'=>json_encode($orderPaymentsArray));

        }

        foreach($venmoPayments as $venmoPayment)
        {
            $orderPaymentsArray = [];
            //return $venmoPayment->order_id;
            $orderDetails = Order::where('id',$venmoPayment->order_id)->with('organizationDetails')->get();

            if ($orderDetails->isEmpty()) {
                continue;
            }

            $order_no = $orderDetails[0]->order_no;
            $sub_total = $orderDetails[0]->sub_total;
            $shipping = $orderDetails[0]->shipping;
            $sales_tax = $orderDetails[0]->sales_tax;
            $artwork = $orderDetails[0]->artwork;
            $totalQty = $orderDetails[0]->orderItems->sum('qty');

            $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];
            $cardPaymenttot = PaymentLog::where('order_id', $venmoPayment->order_id)->sum('amount');
            $checkPaymenttot = CheckPayment::where('order_id', $venmoPayment->order_id)->sum('amount');
            $venmoPaymenttot = VenmoPayment::where('order_id', $venmoPayment->order_id)->sum('amount');
            $payment = $cardPaymenttot + $checkPaymenttot + $venmoPaymenttot;

            $balnceToBePaid = 0;
            if ($payment == 0) {
                $paymentStatus = "Pending";
                $paymentStatus2 = 0;
            } else if ($payment < $orderDetails[0]->order_total && $payment > 0) {
                $balnceToBePaid = $orderDetails[0]->order_total - $payment;
                $paymentStatus = "Partial";
                $paymentStatus2 = 1;
            } else {
                $paymentStatus = "Paid";
                $paymentStatus2 = 2;
            }

            if($venmoPayment->is_approved == "1")
            {
                $checkStatus = "Approved";
            }
            elseif($venmoPayment->is_approved == "3")
            {
                $checkStatus = "Rejected";
            }
            else{
                $checkStatus = "Not Approved";
            }
            $processingFee = number_format(0, 2);

            $cardPaymentRecords = PaymentLog::where('order_id', $venmoPayment->order_id)->where('response_code','1')->get();
            $checkPaymentRecords = CheckPayment::where('order_id', $venmoPayment->order_id)->where('is_approved','1')->get();
            $venmoPaymentRecords = VenmoPayment::where('order_id', $venmoPayment->order_id)->where('is_approved','1')->get();

            $venmoPaymentId = 'VNM'.str_pad(($venmoPayment->id), 6, "0", STR_PAD_LEFT);

            foreach($cardPaymentRecords as $cardPaymentRecord){
                $orderPaymentsArray[] = array('Method'=>'Online','NameonCard'=>$cardPaymentRecord->name_on_card, 'TransactionId'=>$cardPaymentRecord->transaction_id, 'Amount'=>$cardPaymentRecord->amount, 'PaymentDate'=>$cardPaymentRecord->created_at);
            }
            foreach($checkPaymentRecords as $checkPaymentRecord){
                $orderPaymentsArray[] = array('Method'=>'Check','NameonCard'=>'N/A', 'TransactionId'=>$checkPaymentId, 'Amount'=>$checkPaymentRecord->amount, 'PaymentDate'=>$checkPaymentRecord->created_at);
            }
            foreach($venmoPaymentRecords as $venmoPaymentRecord){
                $orderPaymentsArray[] = array('Method'=>'Venmo','NameonCard'=>'N/A', 'TransactionId'=>$venmoPaymentId, 'Amount'=>$venmoPaymentRecord->amount, 'PaymentDate'=>$venmoPaymentRecord->created_at);
            }


            $payedAmount = number_format($payment, 2);

            // $TrasnsactionsArray[] = array('Order'=> $venmoPayment->order_id,'PaymentType'=>'Venmo', 'TeamName'=> $organization_name, 'NameonCard'=> 'N/A', 'checkStatus'=> $checkStatus, 'Amount'=> $venmoPayment->amount, 'OrderStatus'=> $paymentStatus, 'TransactionID'=> $venmoPaymentId, 'PaymentDate'=> $venmoPayment->created_at,
            //                 'checkFImage'=>$venmoPayment->venmo_receipt, 'OrderPayments'=>json_encode($orderPaymentsArray), 'OrderTotal' => $orderDetails[0]->order_total, 'OpenDate' => $orderDetails[0]->open_date, 'DueDate' => $orderDetails[0]->due_date, 'payedAmount'=>$payedAmount);

            $TrasnsactionsArray[] = array('Order'=> $venmoPayment->order_id, 'OrderNo'=>$order_no, 'paymentStatus2'=>$paymentStatus2,  'balnceToBePaid'=>$balnceToBePaid,  'processingFee'=>$processingFee,  'TotalQty' => $totalQty, 'SubTotal'=>$sub_total , 'Shipping'=>$shipping , 'SalesTax'=>$sales_tax , 'ArtWork'=>$artwork ,  'PaymentType'=>'Venmo', 'TeamName'=> $organization_name, 'NameonCard'=> 'N/A', 'checkStatus'=> $checkStatus, 'Amount'=> $venmoPayment->amount, 'OrderStatus'=> $paymentStatus, 'TransactionID'=> $venmoPaymentId, 'PaymentDate'=> $venmoPayment->created_at, 'checkFImage'=>$venmoPayment->venmo_receipt, 'OrderPayments'=>json_encode($orderPaymentsArray));

        }

        foreach($paypalPayments as $paypalPayment)
        {
            $orderPaymentsArray = [];
            //return $paypalPayment->order_id;
            $orderDetails = Order::where('id',$paypalPayment->order_id)->with('organizationDetails')->get();

            if ($orderDetails->isEmpty()) {
                continue;
            }

            $order_no = $orderDetails[0]->order_no;
            $sub_total = $orderDetails[0]->sub_total;
            $shipping = $orderDetails[0]->shipping;
            $sales_tax = $orderDetails[0]->sales_tax;
            $artwork = $orderDetails[0]->artwork;
            $totalQty = $orderDetails[0]->orderItems->sum('qty');

            $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];
            $cardPaymenttot = PaymentLog::where('order_id', $paypalPayment->order_id)->sum('amount');
            $checkPaymenttot = CheckPayment::where('order_id', $paypalPayment->order_id)->sum('amount');
            $venmoPaymenttot = VenmoPayment::where('order_id', $venmoPayment->order_id)->sum('amount');
            $paypalPaymenttot = PaypalPayment::where('order_id', $paypalPayment->order_id)->sum('amount');
            $payment = $cardPaymenttot + $checkPaymenttot + $venmoPaymenttot + $paypalPaymenttot;

            $balnceToBePaid = 0;
            if ($payment == 0) {
                $paymentStatus = "Pending";
                $paymentStatus2 = 0;
            } else if ($payment < $orderDetails[0]->order_total && $payment > 0) {
                $balnceToBePaid = $orderDetails[0]->order_total - $payment;
                $paymentStatus = "Partial";
                $paymentStatus2 = 1;
            } else {
                $paymentStatus = "Paid";
                $paymentStatus2 = 2;
            }

            if($paypalPayment->is_approved == "1")
            {
                $checkStatus = "Approved";
            }
            elseif($paypalPayment->is_approved == "3")
            {
                $checkStatus = "Rejected";
            }
            else{
                $checkStatus = "Not Approved";
            }

            $processingFee = round(($paypalPaymenttot)*3/103 , 2);

            $cardPaymentRecords = PaymentLog::where('order_id', $paypalPayment->order_id)->where('response_code','1')->get();
            $checkPaymentRecords = CheckPayment::where('order_id', $paypalPayment->order_id)->where('is_approved','1')->get();
            $venmoPaymentRecords = VenmoPayment::where('order_id', $venmoPayment->order_id)->where('is_approved','1')->get();
            $paypalPaymentRecords = PaypalPayment::where('order_id', $paypalPayment->order_id)->where('is_approved','1')->get();

            $paypalPaymentId = 'VNM'.str_pad(($paypalPayment->id), 6, "0", STR_PAD_LEFT);

            foreach($cardPaymentRecords as $cardPaymentRecord){
                $orderPaymentsArray[] = array('Method'=>'Online','NameonCard'=>$cardPaymentRecord->name_on_card, 'TransactionId'=>$cardPaymentRecord->transaction_id, 'Amount'=>$cardPaymentRecord->amount, 'PaymentDate'=>$cardPaymentRecord->created_at);
            }
            foreach($checkPaymentRecords as $checkPaymentRecord){
                $orderPaymentsArray[] = array('Method'=>'Check','NameonCard'=>'N/A', 'TransactionId'=>$checkPaymentId, 'Amount'=>$checkPaymentRecord->amount, 'PaymentDate'=>$checkPaymentRecord->created_at);
            }
            foreach($venmoPaymentRecords as $venmoPaymentRecord){
                $orderPaymentsArray[] = array('Method'=>'Venmo','NameonCard'=>'N/A', 'TransactionId'=>$venmoPaymentId, 'Amount'=>$venmoPaymentRecord->amount, 'PaymentDate'=>$venmoPaymentRecord->created_at);
            }
            foreach($paypalPaymentRecords as $paypalPaymentRecord){
                $orderPaymentsArray[] = array('Method'=>'Paypal','NameonCard'=>'N/A', 'TransactionId'=>$paypalPaymentId, 'Amount'=>$paypalPaymentRecord->amount, 'PaymentDate'=>$paypalPaymentRecord->created_at);
            }

            $payedAmount = number_format($payment, 2);

            // $TrasnsactionsArray[] = array('Order'=> $paypalPayment->order_id,'PaymentType'=>'Paypal', 'TeamName'=> $organization_name, 'NameonCard'=> 'N/A', 'checkStatus'=> $checkStatus, 'Amount'=> $paypalPayment->amount, 'OrderStatus'=> $paymentStatus, 'TransactionID'=> $paypalPaymentId, 'PaymentDate'=> $paypalPayment->created_at, 'checkFImage'=>$paypalPayment->paypal_receipt,
            //                     'OrderPayments'=>json_encode($orderPaymentsArray), 'OrderTotal' => $orderDetails[0]->order_total, 'OpenDate' => $orderDetails[0]->open_date, 'DueDate' => $orderDetails[0]->due_date, 'payedAmount'=>$payedAmount);

            $TrasnsactionsArray[] = array('Order'=> $paypalPayment->order_id, 'OrderNo'=>$order_no,  'paymentStatus2'=>$paymentStatus2, 'balnceToBePaid'=>$balnceToBePaid, 'processingFee'=>$processingFee,  'TotalQty' => $totalQty, 'SubTotal'=>$sub_total , 'Shipping'=>$shipping , 'SalesTax'=>$sales_tax , 'ArtWork'=>$artwork ,  'PaymentType'=>'Paypal', 'TeamName'=> $organization_name, 'NameonCard'=> 'N/A', 'checkStatus'=> $checkStatus, 'Amount'=> $paypalPayment->amount, 'OrderStatus'=> $paymentStatus, 'TransactionID'=> $paypalPaymentId, 'PaymentDate'=> $paypalPayment->created_at, 'checkFImage'=>$paypalPayment->paypal_receipt, 'OrderPayments'=>json_encode($orderPaymentsArray));


        }

        $totalsArray = array_column($TrasnsactionsArray, 'Amount');
        $totalSum1 = array_sum($totalsArray);
        $totalSum = number_format($totalSum1, 2);

        $totalOrderCount = count($TrasnsactionsArray);

        $paidOrders = array_filter($TrasnsactionsArray, function($transaction) {
            return $transaction['OrderStatus'] == 'Paid';
        });
        $totalPaidAmount = array_sum(array_column($paidOrders, 'Amount'));
        $totalPaidAmountSum = number_format($totalPaidAmount, 2);

        $totalPaidCount = count($paidOrders);

        $partialOrders = array_filter($TrasnsactionsArray, function($transaction) {
            return $transaction['OrderStatus'] == 'Partial';
        });
        $totalPartialAmount = array_sum(array_column($partialOrders, 'Amount'));
        $totalPartialAmountSum = number_format($totalPartialAmount, 2);

        $totalPartialCount = count($partialOrders);

        $pendingOrders = array_filter($TrasnsactionsArray, function($transaction) {
            return $transaction['OrderStatus'] == 'Pending';
        });
        $totalPendingAmount = array_sum(array_column($pendingOrders, 'OrderTotal'));
        $totalPendingAmountSum = number_format($totalPendingAmount, 2);

        $totalPendingCount = count($pendingOrders);

        usort($TrasnsactionsArray, function($a, $b) {
            return $b['Order'] - $a['Order'];
        });

        $firstTenItems = array_slice($TrasnsactionsArray, 0, 10);

        // dd($firstTenItems);
        return view('pages.reports.customer_payment.index', ['totalSum'=>$totalSum, 'totalOrderCount'=>$totalOrderCount, 'totalPaidAmountSum'=>$totalPaidAmountSum, 'totalPaidCount'=>$totalPaidCount,
                    'totalPartialAmountSum'=>$totalPartialAmountSum, 'totalPartialCount'=>$totalPartialCount, 'totalPendingAmountSum'=>$totalPendingAmountSum, 'totalPendingCount'=>$totalPendingCount,
                    'TrasnsactionsArray'=>$TrasnsactionsArray, 'firstTenItems'=>$firstTenItems]);
    }

    public function filterCustomerPayment(Request $request){

        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $paymentType = $request->input('paymentType');
        $SelectedPaymentStatus = $request->input('paymentStatus');

        $onlinePayments = PaymentLog::where('response_code', '1')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();


        $checkPayments = CheckPayment::whereBetween('created_at', [$startDate, $endDate])->get();

        $venmoPayments = VenmoPayment::whereBetween('created_at', [$startDate, $endDate])->get();

        $paypalPayments = PaypalPayment::whereBetween('created_at', [$startDate, $endDate])->get();

        $TrasnsactionsArray = [];


        foreach($onlinePayments as $onlinePayment)
        {
            if ($paymentType === 'Online' || $paymentType === 'all') {
                $orderPaymentsArray = [];

                $orderDetails = Order::where('id',$onlinePayment->order_id)->with('organizationDetails')->where('organization_id', '!=', 1377)->where('order_no', 'NOT LIKE', 'TSR%')->get();
                if ($orderDetails->isEmpty()) {
                    continue;
                }
                $order_no = $orderDetails[0]->order_no;
                $sub_total = $orderDetails[0]->sub_total;
                $shipping = $orderDetails[0]->shipping;
                $sales_tax = $orderDetails[0]->sales_tax;
                $artwork = $orderDetails[0]->artwork;
                $totalQty = $orderDetails[0]->orderItems->sum('qty');

                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];
                $cardPaymenttot = PaymentLog::where('order_id', $onlinePayment->order_id)->sum('amount');
                $checkPaymenttot = CheckPayment::where('order_id', $onlinePayment->order_id)->sum('amount');
                $payment = $cardPaymenttot + $checkPaymenttot;

                $balnceToBePaid = 0;
                if ($payment == 0) {
                    $paymentStatus = "Pending";
                    $paymentStatus2 = 0;
                } else if ($payment < $orderDetails[0]->order_total && $payment > 0) {
                    $balnceToBePaid = $orderDetails[0]->order_total - $payment;
                    $paymentStatus = "Partial";
                    $paymentStatus2 = 1;
                } else {
                    $paymentStatus = "Paid";
                    $paymentStatus2 = 2;
                }
                $processingFee = round(($cardPaymenttot)*3/103 , 2);

                $cardPaymentRecords = PaymentLog::where('order_id', $onlinePayment->order_id)->where('response_code','1')->get();
                $checkPaymentRecords = CheckPayment::where('order_id', $onlinePayment->order_id)->where('is_approved','1')->get();

                foreach($cardPaymentRecords as $cardPaymentRecord){
                    $orderPaymentsArray[] = array('Method'=>'Online','NameonCard'=>$cardPaymentRecord->name_on_card, 'TransactionId'=>$cardPaymentRecord->transaction_id, 'Amount'=>$cardPaymentRecord->amount, 'PaymentDate'=>$cardPaymentRecord->created_at);
                }
                foreach($checkPaymentRecords as $checkPaymentRecord){
                    $orderPaymentsArray[] = array('Method'=>'Check','NameonCard'=>'N/A', 'TransactionId'=>'N/A', 'Amount'=>$checkPaymentRecord->amount, 'PaymentDate'=>$checkPaymentRecord->created_at);
                }


                $payedAmount = number_format($payment, 2);

                if ($SelectedPaymentStatus === $paymentStatus || $SelectedPaymentStatus === 'all') {

                    // $TrasnsactionsArray[] = array('Order'=> $onlinePayment->order_id, 'PaymentType'=>'Online', 'TeamName'=> $organization_name, 'NameonCard'=> $onlinePayment->name_on_card, 'checkStatus'=> 'Approved', 'Amount'=> $onlinePayment->amount, 'OrderStatus'=> $paymentStatus, 'TransactionID'=> $onlinePayment->transaction_id,
                    //             'PaymentDate'=> $onlinePayment->created_at, 'OrderPayments'=>json_encode($orderPaymentsArray), 'OrderTotal' => $orderDetails[0]->order_total, 'OpenDate' => $orderDetails[0]->open_date, 'DueDate' => $orderDetails[0]->due_date, 'payedAmount'=>$payedAmount);

                    $TrasnsactionsArray[] = array('Order'=> $onlinePayment->order_id, 'OrderNo'=>$order_no, 'paymentStatus2'=>$paymentStatus2, 'balnceToBePaid'=>$balnceToBePaid,  'processingFee'=>$processingFee, 'TotalQty' => $totalQty, 'SubTotal'=>$sub_total , 'Shipping'=>$shipping , 'SalesTax'=>$sales_tax , 'ArtWork'=>$artwork , 'PaymentType'=>'Online', 'TeamName'=> $organization_name, 'NameonCard'=> $onlinePayment->name_on_card, 'checkStatus'=> 'Approved', 'Amount'=> $onlinePayment->amount, 'OrderStatus'=> $paymentStatus, 'TransactionID'=> $onlinePayment->transaction_id, 'PaymentDate'=> $onlinePayment->created_at, 'OrderPayments'=>json_encode($orderPaymentsArray));

                }
            }
        }

        foreach($checkPayments as $checkPayment)
        {
           if ($paymentType === 'Check' || $paymentType === 'all') {
                $orderPaymentsArray = [];
                //return $checkPayment->order_id;
                $orderDetails = Order::where('id',$checkPayment->order_id)->with('organizationDetails')->get();

                if ($orderDetails->isEmpty()) {
                    continue;
                }

                $order_no = $orderDetails[0]->order_no;
                $sub_total = $orderDetails[0]->sub_total;
                $shipping = $orderDetails[0]->shipping;
                $sales_tax = $orderDetails[0]->sales_tax;
                $artwork = $orderDetails[0]->artwork;
                $totalQty = $orderDetails[0]->orderItems->sum('qty');

                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];
                $cardPaymenttot = PaymentLog::where('order_id', $checkPayment->order_id)->sum('amount');
                $checkPaymenttot = CheckPayment::where('order_id', $checkPayment->order_id)->sum('amount');
                $payment = $cardPaymenttot + $checkPaymenttot;

                $balnceToBePaid = 0;
                if ($payment == 0) {
                    $paymentStatus = "Pending";
                    $paymentStatus2 = 0;
                } else if ($payment < $orderDetails[0]->order_total && $payment > 0) {
                    $balnceToBePaid = $orderDetails[0]->order_total - $payment;
                    $paymentStatus = "Partial";
                    $paymentStatus2 = 1;
                } else {
                    $paymentStatus = "Paid";
                    $paymentStatus2 = 2;
                }

                if($checkPayment->is_approved == "1")
                {
                    $checkStatus = "Approved";
                }
                elseif($checkPayment->is_approved == "3")
                {
                    $checkStatus = "Rejected";
                }
                else{
                    $checkStatus = "Not Approved";
                }
                $processingFee = number_format(0, 2);

                $cardPaymentRecords = PaymentLog::where('order_id', $checkPayment->order_id)->where('response_code','1')->get();
                $checkPaymentRecords = CheckPayment::where('order_id', $checkPayment->order_id)->where('is_approved','1')->get();

                $checkPaymentId = 'CHQ'.str_pad(($checkPayment->id), 6, "0", STR_PAD_LEFT);

                foreach($cardPaymentRecords as $cardPaymentRecord){
                    $orderPaymentsArray[] = array('Method'=>'Online','NameonCard'=>$cardPaymentRecord->name_on_card, 'TransactionId'=>$cardPaymentRecord->transaction_id, 'Amount'=>$cardPaymentRecord->amount, 'PaymentDate'=>$cardPaymentRecord->created_at);
                }
                foreach($checkPaymentRecords as $checkPaymentRecord){
                    $orderPaymentsArray[] = array('Method'=>'Check','NameonCard'=>'N/A', 'TransactionId'=>$checkPaymentId, 'Amount'=>$checkPaymentRecord->amount, 'PaymentDate'=>$checkPaymentRecord->created_at);
                }


                $payedAmount = number_format($payment, 2);

                if ($SelectedPaymentStatus === $paymentStatus || $SelectedPaymentStatus === 'all') {
                    // $TrasnsactionsArray[] = array('Order'=> $checkPayment->order_id,'PaymentType'=>'Check', 'TeamName'=> $organization_name, 'NameonCard'=> 'N/A', 'checkStatus'=> $checkStatus, 'Amount'=> $checkPayment->amount, 'OrderStatus'=> $paymentStatus, 'TransactionID'=> $checkPaymentId,
                    //                 'PaymentDate'=> $checkPayment->created_at, 'checkFImage'=>$checkPayment->check_front, 'checkBImage'=>$checkPayment->check_back, 'OrderPayments'=>json_encode($orderPaymentsArray), 'OrderTotal' => $orderDetails[0]->order_total, 'OpenDate' => $orderDetails[0]->open_date, 'DueDate' => $orderDetails[0]->due_date, 'payedAmount'=>$payedAmount);

                    $TrasnsactionsArray[] = array('Order'=> $checkPayment->order_id,'processingFee'=>$processingFee, 'paymentStatus2'=>$paymentStatus2,  'balnceToBePaid'=>$balnceToBePaid,  'OrderNo'=>$order_no, 'TotalQty' => $totalQty,  'SubTotal'=>$sub_total , 'Shipping'=>$shipping , 'SalesTax'=>$sales_tax , 'ArtWork'=>$artwork ,  'PaymentType'=>'Check', 'TeamName'=> $organization_name, 'NameonCard'=> 'N/A', 'checkStatus'=> $checkStatus, 'Amount'=> $checkPayment->amount, 'OrderStatus'=> $paymentStatus, 'TransactionID'=> $checkPaymentId, 'PaymentDate'=> $checkPayment->created_at, 'checkFImage'=>$checkPayment->check_front, 'checkBImage'=>$checkPayment->check_back, 'OrderPayments'=>json_encode($orderPaymentsArray));


                }
            }

        }

        foreach($venmoPayments as $venmoPayment)
        {
            if ($paymentType === 'Venmo' || $paymentType === 'all') {
                $orderPaymentsArray = [];
                //return $venmoPayment->order_id;
                $orderDetails = Order::where('id',$venmoPayment->order_id)->with('organizationDetails')->where('organization_id', '!=', 1377)->where('order_no', 'NOT LIKE', 'TSR%')->get();

                if ($orderDetails->isEmpty()) {
                    continue;
                }

                $order_no = $orderDetails[0]->order_no;
                $sub_total = $orderDetails[0]->sub_total;
                $shipping = $orderDetails[0]->shipping;
                $sales_tax = $orderDetails[0]->sales_tax;
                $artwork = $orderDetails[0]->artwork;
                $totalQty = $orderDetails[0]->orderItems->sum('qty');

                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];
                $cardPaymenttot = PaymentLog::where('order_id', $venmoPayment->order_id)->sum('amount');
                $checkPaymenttot = CheckPayment::where('order_id', $venmoPayment->order_id)->sum('amount');
                $venmoPaymenttot = VenmoPayment::where('order_id', $venmoPayment->order_id)->sum('amount');
                $payment = $cardPaymenttot + $checkPaymenttot + $venmoPaymenttot;

                $balnceToBePaid = 0;
                if ($payment == 0) {
                    $paymentStatus = "Pending";
                    $paymentStatus2 = 0;
                } else if ($payment < $orderDetails[0]->order_total && $payment > 0) {
                    $balnceToBePaid = $orderDetails[0]->order_total - $payment;
                    $paymentStatus = "Partial";
                    $paymentStatus2 = 1;
                } else {
                    $paymentStatus = "Paid";
                    $paymentStatus2 = 2;
                }

                if($venmoPayment->is_approved == "1")
                {
                    $checkStatus = "Approved";
                }
                elseif($venmoPayment->is_approved == "3")
                {
                    $checkStatus = "Rejected";
                }
                else{
                    $checkStatus = "Not Approved";
                }
                $processingFee = number_format(0, 2);

                $cardPaymentRecords = PaymentLog::where('order_id', $venmoPayment->order_id)->where('response_code','1')->get();
                $checkPaymentRecords = CheckPayment::where('order_id', $venmoPayment->order_id)->where('is_approved','1')->get();
                $venmoPaymentRecords = VenmoPayment::where('order_id', $venmoPayment->order_id)->where('is_approved','1')->get();

                $venmoPaymentId = 'VNM'.str_pad(($venmoPayment->id), 6, "0", STR_PAD_LEFT);

                foreach($cardPaymentRecords as $cardPaymentRecord){
                    $orderPaymentsArray[] = array('Method'=>'Online','NameonCard'=>$cardPaymentRecord->name_on_card, 'TransactionId'=>$cardPaymentRecord->transaction_id, 'Amount'=>$cardPaymentRecord->amount, 'PaymentDate'=>$cardPaymentRecord->created_at);
                }
                foreach($checkPaymentRecords as $checkPaymentRecord){
                    $orderPaymentsArray[] = array('Method'=>'Check','NameonCard'=>'N/A', 'TransactionId'=>'N/A', 'Amount'=>$checkPaymentRecord->amount, 'PaymentDate'=>$checkPaymentRecord->created_at);
                }
                foreach($venmoPaymentRecords as $venmoPaymentRecord){
                    $orderPaymentsArray[] = array('Method'=>'Venmo','NameonCard'=>'N/A', 'TransactionId'=>$venmoPaymentId, 'Amount'=>$venmoPaymentRecord->amount, 'PaymentDate'=>$venmoPaymentRecord->created_at);
                }


                $payedAmount = number_format($payment, 2);

                if ($SelectedPaymentStatus === $paymentStatus || $SelectedPaymentStatus === 'all') {
                    // $TrasnsactionsArray[] = array('Order'=> $venmoPayment->order_id,'PaymentType'=>'Venmo', 'TeamName'=> $organization_name, 'NameonCard'=> 'N/A', 'checkStatus'=> $checkStatus, 'Amount'=> $venmoPayment->amount, 'OrderStatus'=> $paymentStatus, 'TransactionID'=> $venmoPaymentId, 'PaymentDate'=> $venmoPayment->created_at,
                    //             'checkFImage'=>$venmoPayment->venmo_receipt, 'OrderPayments'=>json_encode($orderPaymentsArray), 'OrderTotal' => $orderDetails[0]->order_total, 'OpenDate' => $orderDetails[0]->open_date, 'DueDate' => $orderDetails[0]->due_date, 'payedAmount'=>$payedAmount);

                    $TrasnsactionsArray[] = array('Order'=> $venmoPayment->order_id, 'OrderNo'=>$order_no, 'paymentStatus2'=>$paymentStatus2,  'balnceToBePaid'=>$balnceToBePaid,  'processingFee'=>$processingFee,  'TotalQty' => $totalQty, 'SubTotal'=>$sub_total , 'Shipping'=>$shipping , 'SalesTax'=>$sales_tax , 'ArtWork'=>$artwork ,  'PaymentType'=>'Venmo', 'TeamName'=> $organization_name, 'NameonCard'=> 'N/A', 'checkStatus'=> $checkStatus, 'Amount'=> $venmoPayment->amount, 'OrderStatus'=> $paymentStatus, 'TransactionID'=> $venmoPaymentId, 'PaymentDate'=> $venmoPayment->created_at, 'checkFImage'=>$venmoPayment->venmo_receipt, 'OrderPayments'=>json_encode($orderPaymentsArray));

                }

            }
        }

        foreach($paypalPayments as $paypalPayment)
        {
            if ($paymentType === 'Paypal' || $paymentType === 'all') {
                $orderPaymentsArray = [];
                //return $paypalPayment->order_id;
                $orderDetails = Order::where('id',$paypalPayment->order_id)->with('organizationDetails')->where('organization_id', '!=', 1377)->where('order_no', 'NOT LIKE', 'TSR%')->get();

                if ($orderDetails->isEmpty()) {
                    continue;
                }

                $order_no = $orderDetails[0]->order_no;
                $sub_total = $orderDetails[0]->sub_total;
                $shipping = $orderDetails[0]->shipping;
                $sales_tax = $orderDetails[0]->sales_tax;
                $artwork = $orderDetails[0]->artwork;
                $totalQty = $orderDetails[0]->orderItems->sum('qty');

                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];
                $cardPaymenttot = PaymentLog::where('order_id', $paypalPayment->order_id)->sum('amount');
                $checkPaymenttot = CheckPayment::where('order_id', $paypalPayment->order_id)->sum('amount');
                $venmoPaymenttot = VenmoPayment::where('order_id', $venmoPayment->order_id)->sum('amount');
                $paypalPaymenttot = PaypalPayment::where('order_id', $paypalPayment->order_id)->sum('amount');
                $payment = $cardPaymenttot + $checkPaymenttot + $venmoPaymenttot + $paypalPaymenttot;

                $balnceToBePaid = 0;
                if ($payment == 0) {
                    $paymentStatus = "Pending";
                    $paymentStatus2 = 0;
                } else if ($payment < $orderDetails[0]->order_total && $payment > 0) {
                    $balnceToBePaid = $orderDetails[0]->order_total - $payment;
                    $paymentStatus = "Partial";
                    $paymentStatus2 = 1;
                } else {
                    $paymentStatus = "Paid";
                    $paymentStatus2 = 2;
                }

                if($paypalPayment->is_approved == "1")
                {
                    $checkStatus = "Approved";
                }
                elseif($paypalPayment->is_approved == "3")
                {
                    $checkStatus = "Rejected";
                }
                else{
                    $checkStatus = "Not Approved";
                }
                $processingFee = round(($paypalPaymenttot)*3/103 , 2);

                $cardPaymentRecords = PaymentLog::where('order_id', $paypalPayment->order_id)->where('response_code','1')->get();
                $checkPaymentRecords = CheckPayment::where('order_id', $paypalPayment->order_id)->where('is_approved','1')->get();
                $venmoPaymentRecords = VenmoPayment::where('order_id', $venmoPayment->order_id)->where('is_approved','1')->get();
                $paypalPaymentRecords = PaypalPayment::where('order_id', $paypalPayment->order_id)->where('is_approved','1')->get();

                $paypalPaymentId = 'VNM'.str_pad(($paypalPayment->id), 6, "0", STR_PAD_LEFT);

                foreach($cardPaymentRecords as $cardPaymentRecord){
                    $orderPaymentsArray[] = array('Method'=>'Online','NameonCard'=>$cardPaymentRecord->name_on_card, 'TransactionId'=>$cardPaymentRecord->transaction_id, 'Amount'=>$cardPaymentRecord->amount, 'PaymentDate'=>$cardPaymentRecord->created_at);
                }
                foreach($checkPaymentRecords as $checkPaymentRecord){
                    $orderPaymentsArray[] = array('Method'=>'Check','NameonCard'=>'N/A', 'TransactionId'=>$checkPaymentId, 'Amount'=>$checkPaymentRecord->amount, 'PaymentDate'=>$checkPaymentRecord->created_at);
                }
                foreach($venmoPaymentRecords as $venmoPaymentRecord){
                    $orderPaymentsArray[] = array('Method'=>'Venmo','NameonCard'=>'N/A', 'TransactionId'=>$venmoPaymentId, 'Amount'=>$venmoPaymentRecord->amount, 'PaymentDate'=>$venmoPaymentRecord->created_at);
                }
                foreach($paypalPaymentRecords as $paypalPaymentRecord){
                    $orderPaymentsArray[] = array('Method'=>'Paypal','NameonCard'=>'N/A', 'TransactionId'=>$paypalPaymentId, 'Amount'=>$paypalPaymentRecord->amount, 'PaymentDate'=>$paypalPaymentRecord->created_at);
                }

                $payedAmount = number_format($payment, 2);

                if ($SelectedPaymentStatus === $paymentStatus || $SelectedPaymentStatus === 'all') {
                    // $TrasnsactionsArray[] = array('Order'=> $paypalPayment->order_id,'PaymentType'=>'Paypal', 'TeamName'=> $organization_name, 'NameonCard'=> 'N/A', 'checkStatus'=> $checkStatus, 'Amount'=> $paypalPayment->amount, 'OrderStatus'=> $paymentStatus, 'TransactionID'=> $paypalPaymentId, 'PaymentDate'=> $paypalPayment->created_at, 'checkFImage'=>$paypalPayment->paypal_receipt,
                    //                 'OrderPayments'=>json_encode($orderPaymentsArray), 'OrderTotal' => $orderDetails[0]->order_total, 'OpenDate' => $orderDetails[0]->open_date, 'DueDate' => $orderDetails[0]->due_date, 'payedAmount'=>$payedAmount);

                    $TrasnsactionsArray[] = array('Order'=> $paypalPayment->order_id, 'OrderNo'=>$order_no,  'paymentStatus2'=>$paymentStatus2, 'balnceToBePaid'=>$balnceToBePaid, 'processingFee'=>$processingFee,  'TotalQty' => $totalQty, 'SubTotal'=>$sub_total , 'Shipping'=>$shipping , 'SalesTax'=>$sales_tax , 'ArtWork'=>$artwork ,  'PaymentType'=>'Paypal', 'TeamName'=> $organization_name, 'NameonCard'=> 'N/A', 'checkStatus'=> $checkStatus, 'Amount'=> $paypalPayment->amount, 'OrderStatus'=> $paymentStatus, 'TransactionID'=> $paypalPaymentId, 'PaymentDate'=> $paypalPayment->created_at, 'checkFImage'=>$paypalPayment->paypal_receipt, 'OrderPayments'=>json_encode($orderPaymentsArray));

                }
            }
        }


        usort($TrasnsactionsArray, function($a, $b) {
            return $b['Order'] - $a['Order'];
        });

        return response()->json(['startDate'=>$startDate, 'TrasnsactionsArray'=>$TrasnsactionsArray]);
    }

    public function customerPayment_CSV_download($startDate, $endDate, $paymentType, $SelectedPaymentStatus)
    {
        return (new ReportCustomerPaymentExport($startDate, $endDate, $paymentType, $SelectedPaymentStatus))->download('Customer_Payment_Summary.xlsx');
    }
}
