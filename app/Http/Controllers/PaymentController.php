<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\User;
use App\Models\Order;
use App\Models\PaymentLog;
use App\Models\CheckPayment;
use App\Models\OtherPayment;
use App\Models\Notification;
use App\Models\VenmoPayment;
use Illuminate\Http\Request;
use App\Models\PaypalPayment;
use App\Models\SummaryAtPayment;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchaseorderReceipt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Crypt;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Carbon\Carbon;
use App\Models\AccountsLog;
use App\Models\Organization;
use App\Services\PaymentService;
use App\Models\BulkOrderEntry;
use App\Services\NotificationBuilderService;
use App\Models\DebitEntry;
use App\Models\OrderItem;
use App\Services\EmailNotificationBuilderService;

class PaymentController extends Controller {
    protected $PaymentService;
    public function __construct(Request $request , PaymentService $PaymentService) {
        //$this->middleware('auth'); // later enable it when needed user login while payment
        $this->PaymentService = $PaymentService;
    }

    // start page form after start
    public function index(Request $request) {

        $months = array(1 => '01', 2 => '02', 3 => '03', 4 => '04', 5 => '05', 6 => '06', 7 => '07', 8 => '08', 9 => '09', 10 => '10', 11 => '11', 12 => '12');

        $orderId = $request->orderId;

        $orderDetails = Order::with('contactDetails', 'organizationDetails')->find($orderId);

        $cardPayments = PaymentLog::where('order_id', $orderId)->get();
        $checkPayments = CheckPayment::where('order_id', $orderId)->get();
        $otherPayments = OtherPayment::where('order_id', $orderId)->get();
        $venmoPayments = VenmoPayment::where('order_id', $orderId)->get();
        $paypalPayments = PaypalPayment::where('order_id', $orderId)->get();
        $PurchaseorderReceipts = PurchaseorderReceipt::where('order_id', $orderId)->get();

        $cardAmount = PaymentLog::where('order_id', $orderId)->sum('amount');
        $checkAmount = CheckPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
        $otherAmount = OtherPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
        $venmoAmount = VenmoPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
        $paypalAmount = PaypalPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');



        $payment = 0;
//         if($cardAmount > 0 && $paypalAmount > 0){
//             $payment = round($cardAmount - (($orderDetails->order_total * 3)/100),2) + $checkAmount + round($paypalAmount - (($orderDetails->order_total * 3)/100),2) + $venmoAmount;

//         } else if ($cardAmount > 0 && $paypalAmount == 0) {
//             $payment = round($cardAmount - (($orderDetails->order_total * 3)/100),2) + $checkAmount + $paypalAmount + $venmoAmount;

//         } else if ($cardAmount == 0 && $paypalAmount > 0) {
//             $payment = $cardAmount + $checkAmount + round($paypalAmount - (($orderDetails->order_total * 3)/100),2) + $venmoAmount;

//         } else {
//             $payment = $cardAmount + $checkAmount + $paypalAmount + $venmoAmount;
//         }
        if($cardAmount > 0 && $paypalAmount > 0){
            $payment = round(((($cardAmount + $paypalAmount) * 100)/103),2) + $checkAmount + $venmoAmount + $otherAmount;

        } else if ($cardAmount > 0 && $paypalAmount == 0) {
            $payment = round(($cardAmount * 100)/103,2) + $checkAmount + $venmoAmount + $otherAmount;

        } else if ($cardAmount == 0 && $paypalAmount > 0) {
            $payment = $checkAmount + round((($paypalAmount * 100)/103),2) + $venmoAmount + $otherAmount;

        } else {
            $payment = $cardAmount + $checkAmount + $paypalAmount + $venmoAmount + $otherAmount;
        }

        $balnceToBePaid = 0;
        if ($payment == 0 && $orderDetails->order_total > 0) {
            $paymentStatus = 0; // Pending

        } else if ($payment < $orderDetails->order_total && $payment > 0) {
            $paymentStatus = 1; // Partial
            $balnceToBePaid = $orderDetails->order_total - $payment;

        } else {
            $paymentStatus = 2; // Paid
        }

        $totalItemQty = $request->query('totalItemQty');
        $sub_total = $request->query('sub_total');
        $shipping = $request->query('shipping');
        $salesTax = $request->query('salesTax');
        $artwork = $request->query('artwork');
        $processingFee = $request->query('processingFee');
        $orderTotal = $request->query('orderTotal');
        $balancePayment = $request->query('balancePayment');

        return view('pages.order_management.payment.index', [
            'months'=>$months, 'orderDetails'=>$orderDetails, 'cardPayments'=>$cardPayments, 'cardAmount'=>$cardAmount, 'checkAmount'=>$checkAmount, 'otherAmount'=>$otherAmount, 'venmoAmount'=>$venmoAmount, 'paypalAmount'=>$paypalAmount,
            'payment'=>$payment, 'paymentStatus'=>$paymentStatus, 'checkPayments'=>$checkPayments, 'otherPayments'=>$otherPayments, 'venmoPayments'=>$venmoPayments, 'paypalPayments'=>$paypalPayments,
            'totalItemQty' => $totalItemQty, 'sub_total' => $sub_total, 'shipping'=>$shipping, 'salesTax'=>$salesTax, 'artwork'=>$artwork, 'processingFee'=>$processingFee,
            'orderTotal'=>$orderTotal, 'balancePayment'=>$balancePayment,'PurchaseorderReceipts'=>$PurchaseorderReceipts, 'balnceToBePaid' => $balnceToBePaid
        ]);
    }


    public function customerPayment(Request $request) {


        $months = array(1 => '01', 2 => '02', 3 => '03', 4 => '04', 5 => '05', 6 => '06', 7 => '07', 8 => '08', 9 => '09', 10 => '10', 11 => '11', 12 => '12');

        $orderId = $request->orderId;
        $orderDetails = Order::with('contactDetails', 'organizationDetails')->find($orderId);


        if($orderDetails->organizationDetails->sales_tax == null)
        {

            $userRoleId = 3;
            $userIds =  User::whereHas("roles", function($q) use($userRoleId) {
                    $q->where("id", $userRoleId);
                } )->where('active', 1)->get()->pluck('id');

            // foreach ($userIds as $user) {
            //     $notification = new Notification();
            //     $notification->notification_title = 'Seeking for sales tax in Order - #'.$orderId;
            //     $notification->notification_message = 'Order - #'.$orderId . ' seeking for sales tax';//seeking for tax
            //     $notification->is_read = 0;
            //     $notification->is_payment = 0;
            //     $notification->user_id = $user;
            //     $notification->order_id = $orderId;
            //     $notification->save();
            // }
            $builder = new NotificationBuilderService();

            $builder->sendNotification('key_Seekingsales_tax', [
                '{order_no}' => $orderId,
            ], [

                'order_id' => $orderId,
            ]);

            return back()->with("error_msg", "Payment cannot proceed due to missing sales tax on your order. Please contact your sales representative for assistance. We apologize for any inconvenience.");
            exit();
        }


        // if($orderDetails->organizationDetails->sales_tax == null)
        // {
        //     $message_text = "Your Payment Can't be Process please contact Encore Sales Representative ";
        //     $msg_type = "error_msg";

        //     return back()->with($msg_type, $message_text);
        //     exit();
        // }




        $cardPayments = PaymentLog::where('order_id', $orderId)->get();
        $checkPayments = CheckPayment::where('order_id', $orderId)->get();
        $venmoPayments = VenmoPayment::where('order_id', $orderId)->get();
        $paypalPayments = PaypalPayment::where('order_id', $orderId)->get();

        $cardAmount = PaymentLog::where('order_id', $orderId)->sum('amount');
        $checkAmount = CheckPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
        $venmoAmount = VenmoPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
        $paypalAmount = PaypalPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');

        $payment = 0;
//         if($cardAmount > 0 && $paypalAmount > 0){
//             $payment = round($cardAmount - (($orderDetails->order_total * 3)/100),2) + $checkAmount + round($paypalAmount - (($orderDetails->order_total * 3)/100),2) + $venmoAmount;

//         } else if ($cardAmount > 0 && $paypalAmount == 0) {
//             $payment = round($cardAmount - (($orderDetails->order_total * 3)/100),2) + $checkAmount + $paypalAmount + $venmoAmount;

//         } else if ($cardAmount == 0 && $paypalAmount > 0) {
//             $payment = $cardAmount + $checkAmount + round($paypalAmount - (($orderDetails->order_total * 3)/100),2) + $venmoAmount;

//         } else {
//             $payment = $cardAmount + $checkAmount + $paypalAmount + $venmoAmount;
//         }
        if($cardAmount > 0 && $paypalAmount > 0){
            $payment = round(((($cardAmount + $paypalAmount) * 100)/103),2) + $checkAmount + $venmoAmount;

        } else if ($cardAmount > 0 && $paypalAmount == 0) {
            $payment = round(($cardAmount * 100)/103,2) + $checkAmount + $venmoAmount;

        } else if ($cardAmount == 0 && $paypalAmount > 0) {
            $payment = $checkAmount + round((($paypalAmount * 100)/103),2) + $venmoAmount;

        } else {
            $payment = $cardAmount + $checkAmount + $paypalAmount + $venmoAmount;
        }

        $balnceToBePaid = 0;
        if ($payment == 0) {
            $paymentStatus = 0; // Pending

        } else if ($payment < $orderDetails->order_total && $payment > 0) {
            $paymentStatus = 1; // Partial
            $balnceToBePaid = $orderDetails->order_total - $payment;

        } else {
            $paymentStatus = 2; // Paid
        }
// dd($request->qtySum);
        $sub_total = $request->query('sub_total');
        $shipping = $request->query('shipping');
        $salesTax = $request->query('salesTax');
        $artwork = $request->query('artwork');
        $processingFee = $request->query('processingFee');
        $orderTotal = $request->query('orderTotal');
        $balancePayment = $request->query('balancePayment');
        $totalItemQty = $request->qtySum;

        return view('pages.order_management.roster.payment', [
            'months'=>$months, 'orderDetails'=>$orderDetails, 'cardPayments'=>$cardPayments, 'cardAmount'=>$cardAmount, 'checkAmount'=>$checkAmount, 'venmoAmount'=>$venmoAmount, 'paypalAmount'=>$paypalAmount,
            'payment'=>$payment, 'paymentStatus'=>$paymentStatus, 'checkPayments'=>$checkPayments, 'venmoPayments'=>$venmoPayments, 'paypalPayments'=>$paypalPayments,
            'sub_total' => $sub_total, 'shipping'=>$shipping, 'salesTax'=>$salesTax, 'artwork'=>$artwork, 'processingFee'=>$processingFee,
            'orderTotal'=>$orderTotal, 'balancePayment'=>$balancePayment, 'totalItemQty'=>$totalItemQty
        ]);
    }

    public function customerPaymentDownloadCheck(Request $request){
        $decryptedId = Crypt::decrypt($request->sourceId);
        $check = CheckPayment::find($decryptedId);

        $filename = $check->order->order_no.'-cheque-front-image.jpg';
        $tempImage = tempnam(sys_get_temp_dir(), $filename);
        $url = \URL::to('').'/'.$check->check_front;

        // Uses Without SSL
        $contextOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ];
        $context = stream_context_create($contextOptions);
        copy($url, $tempImage,$context);

        // // Use with SSL
        // copy($url, $tempImage);

        return response()->download($tempImage, $filename);
    }

    public function customerPaymentDownloadVenmo(Request $request){
        $decryptedId = Crypt::decrypt($request->sourceId);
        $venmo = VenmoPayment::find($decryptedId);

        $filename = $venmo->order->order_no.'-venmo-payment-image.jpg';
        $tempImage = tempnam(sys_get_temp_dir(), $filename);
        $url = \URL::to('').'/'.$venmo->venmo_receipt;

        // Uses Without SSL
        $contextOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ];
        $context = stream_context_create($contextOptions);
        copy($url, $tempImage,$context);

        // // Use with SSL
        // copy($url, $tempImage);

        return response()->download($tempImage, $filename);
    }

    // order page using payment
    public function handleonlinepay(Request $request) {

        // Remove commas from sub_total and orderTotal
        $subTotal = str_replace(',', '', $request->sub_total);
        $orderTotal = str_replace(',', '', $request->orderTotal);



        $input = $request->input();
        $gateway = getPaymentGatewayConfig();
        /* Create a merchantAuthenticationType object with authentication details retrieved from the constants file */
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();

        //$merchantAuthentication->setName(env('MERCHANT_LOGIN_ID'));
       // $merchantAuthentication->setTransactionKey(env('MERCHANT_TRANSACTION_KEY'));

       /* Payment-gateway-Live */

        // $merchantAuthentication->setName('2gEXK4Vvt54');
        // $merchantAuthentication->setTransactionKey('9X8bxT5z9U45uDCT');


        $merchantAuthentication->setName($gateway['login_id']);
        $merchantAuthentication->setTransactionKey($gateway['transaction_key']);

         /* Payment-gateway-SandBox */
        // $merchantAuthentication->setName('8pB92xhZck');
        // $merchantAuthentication->setTransactionKey('3473R69RQj3f3UnV');

        // Set the transaction's refId
        $refId = 'ref' . time();
        $cardNumber = preg_replace('/\s+/', '', $input['cardNumber']);

        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate($input['expiration-year'] . "-" .$input['expiration-month']);
        $creditCard->setCardCode($input['cvv']);

        // Add the payment data to a paymentType object
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        $orderDetails = Order::with('contactDetails', 'organizationDetails')->where('id', $input['order_id'])->first();

        // Create order information
        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber($orderDetails->order_no);
        $description = substr($orderDetails->order_description, 0, 255);
        $order->setDescription($description);

        // Set the customer's Bill To address
        $customerAddress = new AnetAPI\CustomerAddressType();
        $customerAddress->setFirstName($input['first_name']);
        $customerAddress->setLastName($input['last_name']);
        $customerAddress->setCompany($input['company']);
        $customerAddress->setAddress($input['street']);
        $customerAddress->setCity($input['city']);
        $customerAddress->setState($input['state']);
        $customerAddress->setZip($input['zip_code']);
        $customerAddress->setCountry($input['country']);
        $customerAddress->setPhoneNumber($input['phone']);

        // Set the customer's Ship To address
        $customerShipping = new AnetAPI\CustomerAddressType();
        $customerShipping->setFirstName($orderDetails->contactDetails['first_name']);
        $customerShipping->setLastName($orderDetails->contactDetails['last_name']);
        $customerShipping->setCompany($orderDetails->organizationDetails['organization_name']);
        $customerShipping->setAddress($orderDetails['street']);
        $customerShipping->setCity($orderDetails['city']);
        $customerShipping->setState($orderDetails['state']);
        $customerShipping->setZip($orderDetails['postal_code']);
        $customerShipping->setCountry($orderDetails['country']);
        //$customerShipping->setPhoneNumber($orderDetails['phone_no']);

        // Set the customer's identifying information
        $customerData = new AnetAPI\CustomerDataType();
        $customerData->setType("individual");
        $customerData->setId($orderDetails->contactDetails['id']);
        $customerData->setEmail($input['email']);

        // Create a TransactionRequestType object and add the previous objects to it
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($input['amount']);
        $transactionRequestType->setOrder($order);
        $transactionRequestType->setPayment($paymentOne);
        $transactionRequestType->setBillTo($customerAddress);
        $transactionRequestType->setShipTo($customerShipping);
        $transactionRequestType->setCustomer($customerData);

        // Assemble the complete transaction request
        $requests = new AnetAPI\CreateTransactionRequest();
        $requests->setMerchantAuthentication($merchantAuthentication);
        $requests->setRefId($refId);
        $requests->setTransactionRequest($transactionRequestType);

        // Create the controller and get the response
        $controller = new AnetController\CreateTransactionController($requests);
        // $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);//PRODUCTION //SANDBOX
        $response = $controller->executeWithApiResponse($gateway['environment']);

        if ($response != null) {
            // Check to see if the API request was successfully received and acted upon
            if ($response->getMessages()->getResultCode() == "Ok") {
                // Since the API request was successful, look for a transaction response and parse it to display the results of authorizing the card
                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getMessages() != null) {
                    $message_text = $tresponse->getMessages()[0]->getDescription().", Transaction ID: " . $tresponse->getTransId();
                    $msg_type = "success_msg";

                    $AccLogOrder = Order::where('id' , $request->order_id)->first();
                    $payment_of_order = $this->PaymentService->getPaymentStatus($request->order_id);

                    if($AccLogOrder->order_status_id == 1 && !AccountsLog::where('order_id', $request->order_id)->where('type', 0)->where('status', 1)->where('note', 'Outstanding Invoice')->exists()){
                        $CreditAccount = new AccountsLog();
                        $CreditAccount->organization_id = $AccLogOrder->organization_id;
                        $CreditAccount->amount = $payment_of_order['order_total'];
                        $CreditAccount->order_id = $request->order_id;
                        $CreditAccount->paid = 0;
                        $CreditAccount->balance = 0;
                        $CreditAccount->debit_balance =$payment_of_order['order_total'];
                        $CreditAccount->type = 0;
                        $CreditAccount->user_id = Auth::user()->id;
                        $CreditAccount->status = 1;
                        $CreditAccount->note = 'Outstanding Invoice';
                        $CreditAccount->save();
                    }

                    $sumOfPayments = $this->getSumOfPayments($orderDetails->id);

                    $paymentLog = new PaymentLog();
                    $paymentLog->amount = $input['amount'];
                    $paymentLog->order_id = $input['order_id'];
                    $paymentLog->response_code =$tresponse->getResponseCode();
                    $paymentLog->transaction_id = $tresponse->getTransId();
                    $paymentLog->auth_id = $tresponse->getAuthCode();
                    $paymentLog->message_code = $tresponse->getMessages()[0]->getCode();
                    $paymentLog->name_on_card = trim($input['owner']);
                    $paymentLog->quantity = 1;
                    $paymentLog->save();

                    if ($orderDetails && ($sumOfPayments + ($paymentLog->amount * 100 / 103)) > $orderDetails->order_total) {
                        $debitEntry = new DebitEntry();
                        $debitEntry->organization_id = $orderDetails->organization_id;
                        $debitEntry->order_id = $orderDetails->id;
                        $debitEntry->transaction_id = $paymentLog->id;
                        $debitEntry->transaction_type = 'Card';
                        $debitEntry->amount = ($sumOfPayments + ($paymentLog->amount * 100 / 103)) - $orderDetails->order_total;
                        $debitEntry->note = 'Exess From CARD'.$paymentLog->id.' (#'.$orderDetails->order_no.')';
                        $debitEntry->created_at = $paymentLog->created_at->copy()->addMinutes(1);
                        $debitEntry->save();
                    }

                    $summaryAtPayment = new SummaryAtPayment();
                    $summaryAtPayment->order_id = $request->order_id;
                    $summaryAtPayment->organization_id = $AccLogOrder->organization_id;
                    $summaryAtPayment->totalItemQty = $request->totalItemQty;
                    $summaryAtPayment->subTotal = $subTotal; // Use the cleaned value
                    $summaryAtPayment->shipping = $request->shipping;
                    $summaryAtPayment->payment_type = 'Invoice Payment';
                    $summaryAtPayment->salesTax = $request->salesTax;
                    $summaryAtPayment->artwork = $request->artwork;
                    $summaryAtPayment->processingFee = $request->card_fee;
                    $summaryAtPayment->orderTotal = $orderTotal; // Use the cleaned value
                    $summaryAtPayment->balancePayment = (float) str_replace(',', '', $request->balancePayment);
                    $summaryAtPayment->payedAmount = $request->amount;
                    $summaryAtPayment->method = 'Card';
                    $summaryAtPayment->created_at = Carbon::now()->addMinute();
                    $summaryAtPayment->save();

                    // $users = User::where('user_role_id', 3)->orwhere('user_role_id', 8)->get();
                    $order_for_rep = Order::where('id' , $request->order_id)->first();
                    if($order_for_rep){
                        $order_for_rep_id = $order_for_rep->user_id;
                    }


                    $users =  User::whereIn('id' , [1, 53, 5, 63, 38, $order_for_rep_id])->where('active', 1)->get();


                    // foreach ($users as $user) {
                    //     $notification = new Notification();
                    //     $notification->notification_title = 'Order - #'.$request->order_no;
                    //     $notification->notification_message = 'Payment Done!';
                    //     $notification->is_read = 0;
                    //     $notification->is_payment = 1;
                    //     $notification->user_id = $user->id;
                    //     $notification->order_id = $request->order_id;
                    //     $notification->save();
                    // }
                    $shippingDetailsUrl = url("order_details/edit/{$request->order_id}/order") . '?active_tab=order';
                    $paymentUrl         = route('payment', [
                        'orderId'       => $request->order_id,
                        'totalItemQty'  => $request->totalItemQty,
                        'sub_total'     => number_format((float) $subTotal, 2),
                        'salesTax'      => number_format((float) $request->salesTax, 2),
                        'shipping'      => number_format((float) $request->shipping, 2),
                        'artwork'       => number_format((float) $request->artwork, 2),
                        'processingFee' => number_format((float) $request->card_fee, 2),
                        'orderTotal'    => number_format((float) $orderTotal, 2),
                    ]);

                    $orgForCardNotif = Order::with('organizationDetails')->where('id', $request->order_id)->first();

                    $builder = new NotificationBuilderService();

                    $builder->sendNotification('key_payment_card_new', [
                        '{order_no}'             => $request->order_id,
                        '{shipping_details_url}' => $shippingDetailsUrl,
                        '{organization_name}'    => $orgForCardNotif->organizationDetails->organization_name ?? '',
                        '{transaction_id}'       => $paymentLog->transaction_id,
                        '{payment_made_by}'      => $paymentLog->name_on_card,
                        '{date_time}'            => $paymentLog->created_at->format('m/d/Y') . ' &bull; ' . $paymentLog->created_at->format('H:i:s'),
                        '{amount}'               => '$' . number_format($paymentLog->amount, 2),
                        '{payment_url}'          => $paymentUrl,
                    ], [
                        'order_id'                   => $request->order_id,
                        'is_payment'                 => 1,
                        'user_id'                    => Auth::user()->id ?? null,
                        'target_notification_field'  => 'key_payment_card_new',
                        'new_notification'           => 1,
                    ]);

                    $salesPersonEmail = $this->getSalePersonEmail($request->order_id);

                    $this->sendPaymentMail($request->order_id, $input['amount'], $paymentLog->name_on_card, $paymentUrl);

                } else {
                    $message_text = 'There were some issue with the payment. Please try again later.';
                    $msg_type = "error_msg";

                    if ($tresponse->getErrors() != null) {
                        $message_text = $tresponse->getErrors()[0]->getErrorText();
                        $msg_type = "error_msg";
                    }
                }
                // Or, print errors if the API request wasn't successful
            } else {
                $message_text = 'There were some issue with the payment. Please try again later.';
                $msg_type = "error_msg";

                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getErrors() != null) {
                    $message_text = $tresponse->getErrors()[0]->getErrorText();
                    $msg_type = "error_msg";
                } else {
                    $message_text = $response->getMessages()->getMessage()[0]->getText();
                    $msg_type = "error_msg";
                }
            }
        } else {
            $message_text = "No response returned";
            $msg_type = "error_msg";
        }

        if($msg_type == "success_msg")
        {
            /*$orders = Order::with('organizationDetails', 'userDetails', 'statusDetails', 'contactDetails', 'orderItems',
            'orderItems.productDetails', 'orderItems.statusDetails')
                ->where('id', $input['order_id'])
                ->get();

            $cardPayments = PaymentLog::where('order_id', $input['order_id'])->get();
            $cardAmount = PaymentLog::where('order_id', $input['order_id'])->sum('amount');*/

            $orderPaymentsArray = [];
            $orders = Order::with('organizationDetails', 'userDetails', 'statusDetails', 'contactDetails', 'orderItems', 'orderItems.productDetails', 'orderItems.statusDetails')
                    ->where('id', $input['order_id'])
                    ->get();

            $cardPaymentRecords = PaymentLog::where('order_id', $input['order_id'])->where('response_code','1')->get();
            $checkPaymentRecords = CheckPayment::where('order_id', $input['order_id'])->where('is_approved','1')->get();

            foreach($cardPaymentRecords as $cardPaymentRecord){
                $orderPaymentsArray[] = array('Method'=>'Online','NameonCard'=>$cardPaymentRecord->name_on_card, 'TransactionId'=>$cardPaymentRecord->transaction_id, 'Amount'=>$cardPaymentRecord->amount, 'PaymentDate'=>$cardPaymentRecord->created_at);
            }
            foreach($checkPaymentRecords as $checkPaymentRecord){
                $orderPaymentsArray[] = array('Method'=>'Check','NameonCard'=>'N/A', 'TransactionId'=>'N/A', 'Amount'=>$checkPaymentRecord->amount, 'PaymentDate'=>$checkPaymentRecord->created_at);
            }

            $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
            array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);

            //return view('pages.order_management.orders.invoicepayments', ['orders'=>$orders, 'cardPayments'=>$cardPayments, 'cardAmount'=>$cardAmount,'msg_type'=>$msg_type,'message_text'=>$message_text]);
            return view('pages.order_management.orders.invoicepayments', ['orders'=>$orders, 'orderPaymentsArray'=>$orderPaymentsArray,'msg_type'=>$msg_type,'message_text'=>$message_text, 'pdfdata' => $pdfdata ?? []]);
        }

        return back()->with($msg_type, $message_text);
    }

    // custom portal card payment function
    public function handleCustomerOnlinePay(Request $request) {

        // Remove commas from sub_total and orderTotal
        $subTotal = str_replace(',', '', $request->sub_total);
        $orderTotal = str_replace(',', '', $request->orderTotal);

        $input = $request->input();
        $gateway = getPaymentGatewayConfig();
        /* Create a merchantAuthenticationType object with authentication details retrieved from the constants file */
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        //$merchantAuthentication->setName(env('MERCHANT_LOGIN_ID'));
        //$merchantAuthentication->setTransactionKey(env('MERCHANT_TRANSACTION_KEY'));

        /* Payment-gateway-Live */
        $merchantAuthentication->setName($gateway['login_id']);
        $merchantAuthentication->setTransactionKey($gateway['transaction_key']);

         /* Payment-gateway-SandBox */
        // $merchantAuthentication->setName('8pB92xhZc');
        // $merchantAuthentication->setTransactionKey('3473R69RQj3f3Un');

        // Set the transaction's refId
        $refId = 'ref' . time();
        $cardNumber = preg_replace('/\s+/', '', $input['cardNumber']);

        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate($input['expiration-year'] . "-" .$input['expiration-month']);
        $creditCard->setCardCode($input['cvv']);

        // Add the payment data to a paymentType object
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        $orderDetails = Order::with('contactDetails', 'organizationDetails')->where('id', $input['order_id'])->first();

        // Create order information
        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber($orderDetails->order_no);
        $description = substr($orderDetails->order_description, 0, 255);
        $order->setDescription($description);

        // Set the customer's Bill To address
        $customerAddress = new AnetAPI\CustomerAddressType();
        $customerAddress->setFirstName($input['first_name']);
        $customerAddress->setLastName($input['last_name']);
        $customerAddress->setCompany($input['company']);
        $customerAddress->setAddress($input['street']);
        $customerAddress->setCity($input['city']);
        $customerAddress->setState($input['state']);
        $customerAddress->setZip($input['zip_code']);
        $customerAddress->setCountry($input['country']);
        $customerAddress->setPhoneNumber($input['phone']);

        // Set the customer's Ship To address
        $customerShipping = new AnetAPI\CustomerAddressType();
        $customerShipping->setFirstName($orderDetails->contactDetails['first_name']);
        $customerShipping->setLastName($orderDetails->contactDetails['last_name']);
        $customerShipping->setCompany($orderDetails->organizationDetails['organization_name']);
        $customerShipping->setAddress($orderDetails['street']);
        $customerShipping->setCity($orderDetails['city']);
        $customerShipping->setState($orderDetails['state']);
        $customerShipping->setZip($orderDetails['postal_code']);
        $customerShipping->setCountry($orderDetails['country']);
        //$customerShipping->setPhoneNumber($orderDetails['phone_no']);

        // Set the customer's identifying information
        $customerData = new AnetAPI\CustomerDataType();
        $customerData->setType("individual");
        $customerData->setId($orderDetails->contactDetails['id']);
        $customerData->setEmail($input['email']);

        // Create a TransactionRequestType object and add the previous objects to it
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($input['amount']);
        $transactionRequestType->setOrder($order);
        $transactionRequestType->setPayment($paymentOne);
        $transactionRequestType->setBillTo($customerAddress);
        $transactionRequestType->setShipTo($customerShipping);
        $transactionRequestType->setCustomer($customerData);

        // Assemble the complete transaction request
        $requests = new AnetAPI\CreateTransactionRequest();
        $requests->setMerchantAuthentication($merchantAuthentication);
        $requests->setRefId($refId);
        $requests->setTransactionRequest($transactionRequestType);

        // Create the controller and get the response
        $controller = new AnetController\CreateTransactionController($requests);
        // $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);//PRODUCTION //SANDBOX
        $response = $controller->executeWithApiResponse($gateway['environment']);

        if ($response != null) {
            // Check to see if the API request was successfully received and acted upon
            if ($response->getMessages()->getResultCode() == "Ok") {
                // Since the API request was successful, look for a transaction response and parse it to display the results of authorizing the card
                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getMessages() != null) {
                    $message_text = $tresponse->getMessages()[0]->getDescription().", Transaction ID: " . $tresponse->getTransId();
                    $msg_type = "success_msg";

                    $AccLogOrder = Order::where('id' , $request->order_id)->first();
                    $payment_of_order = $this->PaymentService->getPaymentStatus($request->order_id);

                    $accountNumber = $tresponse->getAccountNumber();

                    $cardLast4 = $accountNumber ? substr($accountNumber, -4) : null;

                    if($AccLogOrder->order_status_id == 1 && !AccountsLog::where('order_id', $request->order_id)->where('type', 0)->where('status', 1)->where('note', 'Outstanding Invoice')->exists()){
                        $CreditAccount = new AccountsLog();
                        $CreditAccount->organization_id = $AccLogOrder->organization_id;
                        $CreditAccount->amount = $payment_of_order['order_total'];
                        $CreditAccount->order_id = $request->order_id;
                        $CreditAccount->paid = 0;
                        $CreditAccount->balance = 0;
                        $CreditAccount->debit_balance =$payment_of_order['order_total'];
                        $CreditAccount->type = 0;
                        $CreditAccount->user_id = $orderDetails->user_id;
                        $CreditAccount->status = 1;
                        $CreditAccount->note = 'Outstanding Invoice';
                        $CreditAccount->save();
                    }

                    $sumOfPayments = $this->getSumOfPayments($orderDetails->id);

                    $paymentLog = new PaymentLog();
                    $paymentLog->amount = $input['amount'];
                    $paymentLog->order_id = $input['order_id'];
                    $paymentLog->response_code =$tresponse->getResponseCode();
                    $paymentLog->transaction_id = $tresponse->getTransId();
                    $paymentLog->auth_id = $tresponse->getAuthCode();
                    $paymentLog->message_code = $tresponse->getMessages()[0]->getCode();
                    $paymentLog->name_on_card = trim($input['owner']);
                    $paymentLog->card_last_digits = $cardLast4;
                    $paymentLog->quantity = 1;
                    $paymentLog->save();

                    if ($orderDetails && ($sumOfPayments + ($paymentLog->amount * 100 / 103)) > $orderDetails->order_total) {
                        $debitEntry = new DebitEntry();
                        $debitEntry->organization_id = $orderDetails->organization_id;
                        $debitEntry->order_id = $orderDetails->id;
                        $debitEntry->transaction_id = $paymentLog->id;
                        $debitEntry->transaction_type = 'Card';
                        $debitEntry->amount = ($sumOfPayments + ($paymentLog->amount * 100 / 103)) - $orderDetails->order_total;
                        $debitEntry->note = 'Exess From CARD'.$paymentLog->id.' (#'.$orderDetails->order_no.')';
                        $debitEntry->created_at = $paymentLog->created_at->copy()->addMinutes(1);
                        $debitEntry->save();
                    }

                    $summaryAtPayment = new SummaryAtPayment();
                    $summaryAtPayment->order_id = $request->order_id;
                    $summaryAtPayment->organization_id = $AccLogOrder->organization_id;
                    $summaryAtPayment->totalItemQty = $request->totalItemQty;
                    $summaryAtPayment->subTotal = $subTotal; // Use the cleaned value
                    $summaryAtPayment->shipping = $request->shipping;
                    $summaryAtPayment->payment_type = 'Invoice Payment';
                    $summaryAtPayment->salesTax = $request->salesTax;
                    $summaryAtPayment->artwork = $request->artwork;
                    $summaryAtPayment->processingFee = $request->card_fee;
                    $summaryAtPayment->orderTotal = $orderTotal; // Use the cleaned value
                    $summaryAtPayment->balancePayment = $request->balancePayment;
                    $summaryAtPayment->payedAmount = $request->amount;
                    $summaryAtPayment->method = 'Card';
                    $summaryAtPayment->created_at = Carbon::now()->addMinute();
                    $summaryAtPayment->save();

                    //$users = User::select('id')->where('user_role_id', 3)->get();
                    // $users = User::where('user_role_id', 3)->orwhere('user_role_id', 8)->get();
                    $order_for_rep = Order::where('id' , $request->order_id)->first();
                    if($order_for_rep){
                        $order_for_rep_id = $order_for_rep->user_id;
                    }

                    $users =  User::whereIn('id' , [1, 53, 5, 63, 38, $order_for_rep_id])->where('active', 1)->get();
                    // foreach ($users as $user) {
                    //     $notification = new Notification();
                    //     $notification->notification_title = 'Order - #'.$request->order_no;
                    //     $notification->notification_message = 'Payment Done!';
                    //     $notification->is_read = 0;
                    //     $notification->is_payment = 1;
                    //     $notification->user_id = $user->id;
                    //     $notification->order_id = $request->order_id;
                    //     $notification->save();
                    // }
                    $shippingDetailsUrl = url("order_details/edit/{$request->order_id}/order") . '?active_tab=order';
                    $paymentUrl         = route('payment', [
                        'orderId'       => $request->order_id,
                        'totalItemQty'  => $request->totalItemQty,
                        'sub_total'     => number_format($subTotal, 2),
                        'salesTax'      => number_format($request->salesTax, 2),
                        'shipping'      => number_format($request->shipping, 2),
                        'artwork'       => number_format($request->artwork, 2),
                        'processingFee' => number_format($request->card_fee, 2),
                        'orderTotal'    => number_format($orderTotal, 2),
                    ]);

                    $orgForCardNotif = Order::with('organizationDetails')->where('id', $request->order_id)->first();

                    $builder = new NotificationBuilderService();

                    $builder->sendNotification('key_payment_card_new', [
                        '{order_no}'             => $request->order_id,
                        '{shipping_details_url}' => $shippingDetailsUrl,
                        '{organization_name}'    => $orgForCardNotif->organizationDetails->organization_name ?? '',
                        '{transaction_id}'       => $paymentLog->transaction_id,
                        '{payment_made_by}'      => $paymentLog->name_on_card,
                        '{date_time}'            => $paymentLog->created_at->format('m/d/Y') . ' &bull; ' . $paymentLog->created_at->format('H:i:s'),
                        '{amount}'               => '$' . number_format($paymentLog->amount, 2),
                        '{payment_url}'          => $paymentUrl,
                    ], [
                        'order_id'                   => $request->order_id,
                        'is_payment'                 => 1,
                        'user_id'                    => Auth::user()->id ?? null,
                        'target_notification_field'  => 'key_payment_card_new',
                        'new_notification'           => 1,
                    ]);

                    $salesPersonEmail = $this->getSalePersonEmail($request->order_id);

                    $this->sendPaymentMail($request->order_id, $input['amount'], $paymentLog->name_on_card, $paymentUrl);

                } else {
                    $message_text = 'There were some issue with the payment. Please try again later.';
                    $msg_type = "error_msg";

                    if ($tresponse->getErrors() != null) {
                        $message_text = $tresponse->getErrors()[0]->getErrorText();
                        $msg_type = "error_msg";
                    }
                }
                // Or, print errors if the API request wasn't successful
            } else {
                $message_text = 'There were some issue with the payment. Please try again later.';
                $msg_type = "error_msg";

                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getErrors() != null) {
                    $message_text = $tresponse->getErrors()[0]->getErrorText();
                    $msg_type = "error_msg";
                } else {
                    $message_text = $response->getMessages()->getMessage()[0]->getText();
                    $msg_type = "error_msg";
                }
            }
        } else {
            $message_text = "No response returned";
            $msg_type = "error_msg";
        }

        if($msg_type == "success_msg")
        {
            /*$orders = Order::with('organizationDetails', 'userDetails', 'statusDetails', 'contactDetails', 'orderItems',
            'orderItems.productDetails', 'orderItems.statusDetails')
                ->where('id', $input['order_id'])
                ->get();

            $cardPayments = PaymentLog::where('order_id', $input['order_id'])->get();
            $cardAmount = PaymentLog::where('order_id', $input['order_id'])->sum('amount');*/

            /* */

            // Generate the PDF
            // $pdf = Pdf::loadView('pages.order_management.orders.customerpayments_pdf', $pdfdata);

            // // Save the PDF to a temporary location
            // $fileName = 'Order_Invoice_Payments_' . now()->format('Y-m-d_H-i-s') . '.pdf';
            // $filePath = storage_path("app/temp/{$fileName}");
            // $pdf->save($filePath);

            // // Generate the download URL
            // $downloadPath = route('download.pdf', ['file' => $fileName]);

            $orderPaymentsArray = [];
            $orders = Order::with(['organizationDetails', 'userDetails', 'statusDetails', 'contactDetails', 'orderItems',
            'orderItems' => function ($query) {
                    $query->with(['productDetails', 'statusDetails'])->where('is_studio_item', 0);
                }
            ])
            ->where('id', $input['order_id'])
            ->get();

            $cardAmount = PaymentLog::where('order_id', $input['order_id'])->where('response_code','1')->sum('amount');
            $checkAmount = CheckPayment::where('order_id', $input['order_id'])->where('is_approved' , 1)->sum('amount');
            $venmoAmount = VenmoPayment::where('order_id', $input['order_id'])->where('is_approved' , 1)->sum('amount');
            $paypalAmount = PaypalPayment::where('order_id', $input['order_id'])->where('is_approved' , 1)->sum('amount');

            $payment = 0;
            if($cardAmount > 0 && $paypalAmount > 0){
                $payment = round(((($cardAmount + $paypalAmount) * 100)/103),2) + $checkAmount + $venmoAmount;

            } else if ($cardAmount > 0 && $paypalAmount == 0) {
                $payment = round(($cardAmount * 100)/103,2) + $checkAmount + $venmoAmount;

            } else if ($cardAmount == 0 && $paypalAmount > 0) {
                $payment = $checkAmount + round((($paypalAmount * 100)/103),2) + $venmoAmount;

            } else {
                $payment = $cardAmount + $checkAmount + $paypalAmount + $venmoAmount;
            }

            $processingFee = round(($cardAmount + $venmoAmount)*3/103 , 2);

            $balnceToBePaid = 0;
            if ($payment == 0) {
                $paymentStatus = 'Pending'; // Pending
                $color ='##d65a47';

            } else if ($payment < $orders[0]->order_total && $payment > 0) {
                $paymentStatus = 'Partial'; // Partial
                $balnceToBePaid = $orders[0]->order_total - $payment;
                $color ='#FFB916';

            } else {
                $paymentStatus = 'Paid'; // Paid
                $color ='#2dce89';
            }

            $pdfdata = [
                'transaction_id' =>  $paymentLog->transaction_id,
                'Customer_name' => $paymentLog->name_on_card,
                'Payment_method' => 'Card',
                'amount_paid' => $paymentLog->amount,
                'processingFee' => $processingFee,
                'Date' =>Carbon::now()->format('m-d-Y'),
                'status' =>'Success',
                'order_id' =>$orders[0]->order_no,
                'title' =>'Payment Receipt',
                'balnceToBePaid' => $balnceToBePaid,
                'paymentReceived' => $payment,
                'orderstatus'=>$paymentStatus,
                'color'=>$color,
            ];
            $billinginfo = [
                'first_name' => $input['first_name'] ?? '',
                'last_name'  => $input['last_name'] ?? '',
                'company'    => $input['company'] ?? '',
                'street'     => $input['street'] ?? '',
                'city'       => $input['city'] ?? '',
                'state'      => $input['state'] ?? '',
                'zip_code'   => $input['zip_code'] ?? '',
                'country'    => $input['country'] ?? '',
                'phone'      => $input['phone'] ?? '',
                'email'      => $input['email'] ?? '',
            ];
            $this->sendPaymentMailCustomer($orders[0], $pdfdata, $input['email'], $billinginfo);

            $cardPaymentRecords = PaymentLog::where('order_id', $input['order_id'])->where('response_code','1')->get();
            $checkPaymentRecords = CheckPayment::where('order_id', $input['order_id'])->where('is_approved','1')->get();

            foreach($cardPaymentRecords as $cardPaymentRecord){
                $orderPaymentsArray[] = array('Method'=>'Online','NameonCard'=>$cardPaymentRecord->name_on_card, 'TransactionId'=>$cardPaymentRecord->transaction_id, 'Amount'=>$cardPaymentRecord->amount, 'PaymentDate'=>$cardPaymentRecord->created_at);
            }
            foreach($checkPaymentRecords as $checkPaymentRecord){
                $orderPaymentsArray[] = array('Method'=>'Check','NameonCard'=>'N/A', 'TransactionId'=>'N/A', 'Amount'=>$checkPaymentRecord->amount, 'PaymentDate'=>$checkPaymentRecord->created_at);
            }

            $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
            array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);
            //return "4";
            //return view('pages.order_management.orders.invoicepayments2', ['orders'=>$orders, 'orderPaymentsArray'=>$orderPaymentsArray]);

            //return view('pages.order_management.orders.invoicepayments', ['orders'=>$orders, 'cardPayments'=>$cardPayments, 'cardAmount'=>$cardAmount,'msg_type'=>$msg_type,'message_text'=>$message_text]);
            return view('pages.order_management.orders.invoicepayments', ['orders'=>$orders, 'orderPaymentsArray'=>$orderPaymentsArray,'msg_type'=>$msg_type,'message_text'=>$message_text,'pdfdata' => $pdfdata,]);//
        }

        return redirect()->back()->with($msg_type, $message_text);
    }

    public function getSumOfPayments($orderId){

        $payment = PaymentLog::where('order_id', $orderId)->sum('amount');
        $checkPayment = CheckPayment::where('order_id', $orderId)->where('is_approved', 1)->sum('amount');
        $paypalPayment = PaypalPayment::where('order_id', $orderId)->where('is_approved', 1)->sum('amount');
        $venmoPayment = VenmoPayment::where('order_id', $orderId)->where('is_approved', 1)->sum('amount');
        $otherPayment = OtherPayment::where('order_id', $orderId)->where('is_approved', 1)->sum('amount');

        $sum = ($payment * 100/103) + $checkPayment + ($paypalPayment * 100/103) + $venmoPayment + $otherPayment;

        return $sum;

    }


    var $smptEncryption = 'SSL';
    var $smptPort = '465';
    var $smptHost = 'server.encr.co';
    var $username = 'info@encr.co';
    var $password = 'Encr.co@ec123';

    public function sendPaymentMail($orderId, $paidAmount, $payBy, $paymentUrl)
    {
        $order = Order::with(['organizationDetails', 'contactDetails'])->find($orderId);
        $organizationName = optional($order->organizationDetails)->organization_name ?? '';
        $customerDetails = trim(optional($order->contactDetails)->first_name . ' ' . optional($order->contactDetails)->last_name);

        $paymentLog = PaymentLog::where('order_id', $orderId)->latest()->first();

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_card_payment_admin', [
            'orderId'            => $orderId,
            'order_number'       => $orderId,
            'organization_name'  => $organizationName,
            'customer_details'   => $customerDetails,
            'transaction_id'     => optional($paymentLog)->transaction_id ?? '',
            'payment_made_by'    => $payBy,
            'paid_date'          => \Carbon\Carbon::now()->format('m/d/Y'),
            'paid_time'          => \Carbon\Carbon::now()->format('H:i:s'),
            'paid_amount'        => number_format((float) $paidAmount, 2),
            'order_link'         => url("order_details/edit/{$orderId}/order") . '?active_tab=order',
            'payment_link'       => $paymentUrl,
        ]);

        return true;
    }
    public function sendPaymentMailCustomer($order, $pdfdata, $mail, $billinginfo)
    {
        
        $orderModel = $order instanceof Order
            ? $order
            : Order::with([
                'organizationDetails',
                'contactDetails',
                'orderItems' => function ($query) {
                    $query->with(['productDetails', 'statusDetails'])->where('is_studio_item', 0);
                },
            ])->find($order);

        if (!$orderModel) {
            logger()->error('sendPaymentMailCustomer: order not found', ['order' => $order]);
            return false;
        }

        // orderItems may not be loaded yet if an Order model without that relation was passed in
        if (!$orderModel->relationLoaded('orderItems')) {
            $orderModel->load([
                'orderItems' => function ($query) {
                    $query->with(['productDetails', 'statusDetails'])->where('is_studio_item', 0);
                },
            ]);
        }

        $paymentCard = PaymentLog::where('order_id', $pdfdata['order_id'])->where('response_code', '1')->latest('created_at')->first();


        $organizationName = optional($orderModel->organizationDetails)->organization_name ?? '';
        $customerName     = trim(optional($orderModel->contactDetails)->first_name . ' ' . optional($orderModel->contactDetails)->last_name);

        // Build the order item list (no images) for the email
        $orderItemsList = [];
        foreach ($orderModel->orderItems as $item) {
            $orderItemsList[] = [
                'product_name' => optional($item->productDetails)->product_name ?? ($item->product_name ?? 'Item'),
                'size'         => $item->size ?? '',
                'qty'          => $item->quantity ?? $item->qty ?? 1,
                'price'        => $item->price ?? $item->unit_price ?? 0,
                'total'        => $item->total_price ?? $item->total ?? (($item->quantity ?? $item->qty ?? 1) * ($item->price ?? $item->unit_price ?? 0)),
            ];
        }

        // Card last 4 digits, when available (PaymentLog now tracks card_last_digits)
        $paymentMethodLabel = $pdfdata['Payment_method'] ?? 'Card';
        if (!empty($pdfdata['card_last_digits'])) {
            $paymentMethodLabel .= ' ending in ' . $pdfdata['card_last_digits'];
        }

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_customer_payment_receipt_card', [
            'custom_email'       => $mail,
            'order_number'       => $pdfdata['order_id'] ?? $orderModel->order_no,
            'order_link'         => url("customer_portal/order_view/{$orderModel->id}") . '?active_tab=order',
            'organization_name'  => $organizationName,
            'customer_name'      => $customerName,
            'customer_email'     => $orderModel->email ?? optional($orderModel->contactDetails)->email ?? '',
            'customer_phone'     => $orderModel->phone_no ?? '',
            'customer_street'    => $orderModel->street ?? '',
            'customer_city'      => $orderModel->city ?? '',
            'customer_state'     => $orderModel->state ?? '',
            'customer_postal'    => $orderModel->postal_code ?? '',
            'customer_country'   => $orderModel->country ?? '',
            'billing_first_name' => $billinginfo['first_name'] ?? '',
            'billing_last_name'  => $billinginfo['last_name'] ?? '',
            'billing_email'      => $billinginfo['email'] ?? '',
            'billing_phone'      => $billinginfo['phone'] ?? '',
            'billing_street'     => $billinginfo['street'] ?? '',
            'billing_city'       => $billinginfo['city'] ?? '',
            'billing_state'      => $billinginfo['state'] ?? '',
            'billing_postal'     => $billinginfo['zip_code'] ?? '',
            'billing_country'    => $billinginfo['country'] ?? '',
            'paymentCard'        => $paymentCard,
            'order_items'        => $orderItemsList,
            'transaction_id'     => $pdfdata['transaction_id'] ?? '',
            'payment_method'     => $paymentMethodLabel,
            'paid_amount'        => number_format((float) ($pdfdata['amount_paid'] ?? 0), 2),
            'processing_fee'     => number_format((float) ($pdfdata['processingFee'] ?? 0), 2),
            'total_paid'         => number_format((float) ($pdfdata['paymentReceived'] ?? 0), 2),
            'order_total'        => number_format((float) ($orderModel->order_total ?? 0), 2),
            'balance_remaining'  => number_format((float) ($pdfdata['balnceToBePaid'] ?? 0), 2),
            'payment_status'     => $pdfdata['orderstatus'] ?? 'Paid',
            'status_color'       => $pdfdata['color'] ?? '#2dce89',
            'paid_date'          => $pdfdata['Date'] ?? now()->format('m-d-Y'),
        ]);

        return true;
       
    }

    public function printPaymentRecept($id)
    {
        $orderNo = $id;
        $orderPaymentsArray = [];
        $orders = Order::with('organizationDetails', 'userDetails', 'statusDetails', 'contactDetails', 'orderItems', 'orderItems.productDetails', 'orderItems.statusDetails')
                ->where('id', $orderNo)
                ->get();

        $cardPaymentRecords = PaymentLog::where('order_id', $orderNo)->where('response_code','1')->get();
        $checkPaymentRecords = CheckPayment::where('order_id', $orderNo)->where('is_approved','1')->get();

        foreach($cardPaymentRecords as $cardPaymentRecord){
            $orderPaymentsArray[] = array('Method'=>'Online','NameonCard'=>$cardPaymentRecord->name_on_card, 'TransactionId'=>$cardPaymentRecord->transaction_id, 'Amount'=>$cardPaymentRecord->amount, 'PaymentDate'=>$cardPaymentRecord->created_at);
        }
        foreach($checkPaymentRecords as $checkPaymentRecord){
            $orderPaymentsArray[] = array('Method'=>'Check','NameonCard'=>'N/A', 'TransactionId'=>'N/A', 'Amount'=>$checkPaymentRecord->amount, 'PaymentDate'=>$checkPaymentRecord->created_at);
        }

        $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
        array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);
        //return "4";
        return view('pages.order_management.orders.invoicepayments2', ['orders'=>$orders, 'orderPaymentsArray'=>$orderPaymentsArray]);
    }

    public function getSalePersonEmail($orderId){

       $orderSalesPerson = Order::with('userDetails')->where('id',$orderId)->get();
       return $orderSalesPerson[0]->userDetails['email'];
    }
    public function do_pay_multiple_orders(Request $request){
        if (isset($request->org_id)) {
            $organization = Organization::find($request->org_id);
        }else{
            $firstOrder = array_key_first($request->payment_amount);
            $organization = Organization::find(Order::find($firstOrder)->organization_id);
        }

        $OtherProofment = self::uploadProofment($request);
        $OtherProofmentback = self::uploadProofmentback($request);
        $total = 0;
        $otherPaymentIDs = [];
        $otherPaymentOrderIDs = [];

        $rowsHtml        = '';
        $totalAmountPaid = 0;
        $paymentMadeBy   = Auth::user()->name;
        $orgName         = $organization->organization_name ?? '';
        $orgURL          = url('organizations/info/' . $organization->id);
        $allOrderIds     = [];

        foreach ($request->payment_amount as $key => $value) {

            $total += $value;

            $paymentorder = $this->PaymentService->getPaymentStatus($key);
            $Order_balance =  $paymentorder['balance_to_be_paid'] ?? 0;
            $orderTotal =  $paymentorder['order_total'] ?? 0;

            $customerPaidPayment = $request->customer_paid_payment ?? $request->total_amount;


            if($total > $customerPaidPayment){

                if((round(($customerPaidPayment - ($total - $value)), 2)) > 0){

                    $otherPayment = new OtherPayment();
                    $otherPayment->order_id = $key;
                    $otherPayment->amount = $customerPaidPayment -($total - $value);
                    $otherPayment->document_url = $OtherProofment;
                    $otherPayment->document_url_back = $OtherProofmentback;
                    $otherPayment->is_approved = 1;
                    $otherPayment->is_bulk = 1;
                    $otherPayment->description = $request->payment_reference;
                    $otherPayment->note = 'Paid by user '.Auth::user()->name;
                    $otherPayment->save();

                    $otherPaymentIDs[] = $otherPayment->id;
                    $otherPaymentOrderIDs[] = $key;

                    if (round(($total - $customerPaidPayment), 2) > 0) {

                        $otherPayment = new OtherPayment();
                        $otherPayment->order_id = $key;
                        $otherPayment->amount = $total - $customerPaidPayment ;
                        $otherPayment->document_url = $OtherProofment;
                        $otherPayment->document_url_back = $OtherProofmentback;
                        $otherPayment->is_approved = 1;
                        $otherPayment->is_bulk = 1;
                        $otherPayment->description = $request->payment_reference ?? 'Deducted from Debit';
                        $otherPayment->note = 'Deducted from Debit (By '.Auth::user()->name.')';
                        $otherPayment->from_debit = 1;
                        $otherPayment->save();

                        $debitAccount = new AccountsLog();
                        $debitAccount->organization_id = $organization->id;
                        $debitAccount->order_id = $key;
                        $debitAccount->amount = 0;
                        $debitAccount->paid = 0;
                        $debitAccount->balance = $total - $customerPaidPayment;
                        $debitAccount->type = 0;
                        $debitAccount->user_id = Auth::user()->id;
                        $debitAccount->status = 1;
                        $debitAccount->debit_balance = $organization->debit_balance - ($total - $customerPaidPayment);
                        $debitAccount->note = 'Deducted from Debit';
                        $debitAccount->document_url = $OtherProofment;
                        $debitAccount->document_url_back = $OtherProofmentback;
                        $debitAccount->save();

                        $organization->debit_balance -= ($total - $customerPaidPayment);
                        $organization->save();

                    }


                }else{

                    if (round($value, 2) > 0) {

                        $otherPayment = new OtherPayment();
                        $otherPayment->order_id = $key;
                        $otherPayment->amount =  $value;
                        $otherPayment->document_url = $OtherProofment;
                        $otherPayment->document_url_back = $OtherProofmentback;
                        $otherPayment->is_approved = 1;
                        $otherPayment->is_bulk = 1;
                        $otherPayment->description = $request->payment_reference ?? 'Deducted from Debit';
                        $otherPayment->note = 'Deducted from Debit (By '.Auth::user()->name.')';
                        $otherPayment->from_debit = 1;
                        $otherPayment->save();

                        $debitAccount = new AccountsLog();
                        $debitAccount->organization_id = $organization->id;
                        $debitAccount->order_id = $key;
                        $debitAccount->amount = 0;
                        $debitAccount->paid = 0;
                        $debitAccount->balance = $value;
                        $debitAccount->type = 0;
                        $debitAccount->user_id = Auth::user()->id;
                        $debitAccount->status = 1;
                        $debitAccount->debit_balance = $organization->debit_balance - ($value);
                        $debitAccount->note = 'Deducted from Debit';
                        $debitAccount->document_url = $OtherProofment;
                        $debitAccount->document_url_back = $OtherProofmentback;
                        $debitAccount->save();

                        $organization->debit_balance -= $value;
                        $organization->save();
                    }

                }

            }else{

                $otherPayment = new OtherPayment();
                $otherPayment->order_id = $key;
                $otherPayment->amount = $value;
                $otherPayment->document_url = $OtherProofment;
                $otherPayment->document_url_back = $OtherProofmentback;
                $otherPayment->is_approved = 1;
                $otherPayment->is_bulk = 1;
                $otherPayment->description = $request->payment_reference;
                $otherPayment->note = 'Paid by user '.Auth::user()->name;
                $otherPayment->save();

                $otherPaymentIDs[] = $otherPayment->id;
                $otherPaymentOrderIDs[] = $key;

            }

            if($total == $request->total_amount){
                if($request->total_sum_of_payment > $request->total_amount){

                    $debitAccount = new AccountsLog();
                    $debitAccount->organization_id = $organization->id;
                    $debitAccount->order_id = $key;
                    $debitAccount->balance = $request->total_sum_of_payment - $request->total_amount;
                    $debitAccount->type = 1;
                    $debitAccount->user_id = Auth::user()->id;
                    $debitAccount->status = 1;
                    $debitAccount->debit_balance = $organization->debit_balance + $request->total_sum_of_payment - $request->total_amount;
                    $debitAccount->note ='Credited from Bulk Order payment';
                    $debitAccount->document_url = $OtherProofment;
                    $debitAccount->document_url_back = $OtherProofmentback;
                    $debitAccount->save();

                    $organization->debit_balance += $request->total_sum_of_payment - $request->total_amount;
                    $organization->save();

                }

            }

            $order_for_rep = Order::where('id' , $key)->first();
            if($order_for_rep){
                $order_for_rep_id = $order_for_rep->user_id;
            }

            $users =  User::whereIn('id' , [53, 5, 63, 38, $order_for_rep_id, Auth::user()->id])->where('active', 1)->get();

            $allOrderIds[] = $key;

            $exFactoryDate = OrderItem::where('order_id', $key)
                ->where('active', 1)
                ->pluck('ex_factory_date')
                ->filter()
                ->sort()
                ->first();

            $orderLink = url("order_details/edit/{$key}/order") . '?active_tab=order';
            $balanceAfterPayment = round($Order_balance - $value, 2);

            $rowsHtml .= '<div style="display:grid;grid-template-columns:84px 122px 109px 102px 111px 95px;gap:8px;align-items:center;padding:12px 16px;font-size:13px;color:#1f2937;border-bottom:1px solid #9ca3af;width:max-content;min-width:100%;box-sizing:border-box">
                <div><a href="' . $orderLink . '" style="color:#111827;text-decoration:none;font-weight:600" target="_blank">#' . e($order_for_rep->order_no ?? $key) . '</a></div>
                <div style="color:#374151">' . ($exFactoryDate ? e($exFactoryDate) : '-') . '</div>
                <div style="color:#374151">$' . number_format($orderTotal, 2) . '</div>
                <div style="font-weight:700;color:#16a34a">$' . number_format($value, 2) . '</div>
                <div style="font-weight:700;color:#16a34a">$' . number_format($balanceAfterPayment, 2) . '</div>
                <div style="text-align:center"><a href="' . $orderLink . '" target="_blank" style="color:#111827;text-decoration:none" title="Go to payment"><i class="fas fa-external-link-alt"></i></a></div>
            </div>';

            $totalAmountPaid += $value;

        }

        $summaryAtPayment = new SummaryAtPayment();
        $summaryAtPayment->payment_type = 'Bulk Payment';
        $summaryAtPayment->organization_id = $organization->id;
        $summaryAtPayment->payedAmount = $customerPaidPayment  ?? 0.00;
        $summaryAtPayment->method = 'Other';
        $summaryAtPayment->save();

        $bulkOrderEntry = new BulkOrderEntry();
        $bulkOrderEntry->organization_id = $organization->id;
        $bulkOrderEntry->other_payment_ids = json_encode($otherPaymentIDs);
        $bulkOrderEntry->amount = $customerPaidPayment  ?? 0.00;
        $bulkOrderEntry->document_url = $OtherProofment;
        $bulkOrderEntry->document_url_back = $OtherProofmentback;
        $bulkOrderEntry->note = 'Applied for orders : ' . implode(' , ', $otherPaymentOrderIDs);
        $bulkOrderEntry->description = json_encode($otherPaymentOrderIDs);
        $bulkOrderEntry->save();

        $orders_user_ids = !empty($otherPaymentOrderIDs)
            ? Order::whereIn('id', $otherPaymentOrderIDs)->pluck('user_id')->toArray()
            : [];

        $all_user_ids = array_unique(array_merge([1, 53, 5, 63, 38], $orders_user_ids));

        $users = User::whereIn('id', $all_user_ids)->where('active', 1)->get();

        $paymentReference = $request->payment_reference ?? 'N/A';

        $this->sendPaymentMailBulk($otherPaymentOrderIDs, $total, $users, asset($OtherProofment), asset($OtherProofmentback), $paymentReference);


        $builder = new NotificationBuilderService();

        $proofFrontUrl = $OtherProofment ? asset($OtherProofment) : null;
        $proofBackUrl  = $OtherProofmentback ? asset($OtherProofmentback) : null;

        $proofDocsHtml = '';

        if ($proofFrontUrl) {
            $proofDocsHtml .= '<div style="display:flex;flex-direction:column;align-items:center;gap:4px">
                <img src="' . e($proofFrontUrl) . '" alt="Payment Proof Front" style="width:110px;height:auto;border:1px solid #e5e7eb;border-radius:4px;cursor:zoom-in;"
                    onclick="(function(src){var o=document.getElementById(\'ncmInlineZoomOverlay\');if(!o){o=document.createElement(\'div\');o.id=\'ncmInlineZoomOverlay\';o.style.cssText=\'display:none;position:fixed;inset:0;background:rgba(0,0,0,0.85);z-index:99999;align-items:center;justify-content:center;cursor:zoom-out;\';var im=document.createElement(\'img\');im.style.cssText=\'max-width:90vw;max-height:88vh;border-radius:6px;box-shadow:0 20px 60px rgba(0,0,0,.5);\';o.appendChild(im);o.addEventListener(\'click\',function(){o.style.display=\'none\';});document.body.appendChild(o);}o.querySelector(\'img\').src=src;o.style.display=\'flex\';})(this.src)">
                <span style="font-size:10px;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:.4px">Front</span>
            </div>';
        }

        if ($proofBackUrl) {
            $proofDocsHtml .= '<div style="display:flex;flex-direction:column;align-items:center;gap:4px">
                <img src="' . e($proofBackUrl) . '" alt="Payment Proof Back" style="width:110px;height:auto;border:1px solid #e5e7eb;border-radius:4px;cursor:zoom-in;"
                    onclick="(function(src){var o=document.getElementById(\'ncmInlineZoomOverlay\');if(!o){o=document.createElement(\'div\');o.id=\'ncmInlineZoomOverlay\';o.style.cssText=\'display:none;position:fixed;inset:0;background:rgba(0,0,0,0.85);z-index:99999;align-items:center;justify-content:center;cursor:zoom-out;\';var im=document.createElement(\'img\');im.style.cssText=\'max-width:90vw;max-height:88vh;border-radius:6px;box-shadow:0 20px 60px rgba(0,0,0,.5);\';o.appendChild(im);o.addEventListener(\'click\',function(){o.style.display=\'none\';});document.body.appendChild(o);}o.querySelector(\'img\').src=src;o.style.display=\'flex\';})(this.src)">
                <span style="font-size:10px;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:.4px">Back</span>
            </div>';
        }

        if (!$proofDocsHtml) {
            $proofDocsHtml = '<span style="color:#9ca3af;font-size:12px">No proof uploaded</span>';
        }

        $builder->sendNotification(
            'key_payment_other',
            [
                '{payment_made_by}'   => $paymentMadeBy,
                '{total_paid}'        => $totalAmountPaid,
                '{organization_name}' => $orgName,
                '{organization_url}'  => $orgURL,
                '{date_time}'         => now()->format('m/d/Y') . ' • ' . now()->format('H:i:s'),
                '{total_amount}'      => '$' . number_format($totalAmountPaid, 2),
                '{proof_docs}'        => $proofDocsHtml,
                '{rowsHtml}'          => $rowsHtml,
            ],
            [
                'is_payment'                 => 1,
                'target_notification_field'  => 'key_payment_other',
                'new_notification'           => 1,
                'order_ids'                  => $allOrderIds,
            ]
        );
        return redirect()->back()->withSuccess('Other payment updated Successfully!');
    }
    public function sendPaymentMailBulk($orderIds, $paidAmount, $users, $front_url, $back_url, $paymentReference)
    {
        config(['mail.host' => $this->smptHost]);
        config(['mail.port' => $this->smptPort]);
        config(['mail.encryption' => $this->smptEncryption]);

        config(['mail.username' => $this->username]);
        config(['mail.password' => $this->password]);

        $fromSettings = [
        'address' => $this->username,
        'name' => 'encorebrand',
        ];
        config(['mail.from' => $fromSettings]);

        $mailToArr = array();
        foreach($users as $user)
        {
            array_push($mailToArr, $user->email);
        }

        $orders = Order::with('organizationDetails')->whereIn('id', $orderIds)->get();

        $organizationNames = $orders->pluck('organizationDetails.organization_name')->filter()->unique()->values()->toArray();

        $data["title"] = "Bulk payment received for order #".implode(' , ', $orderIds);
        $data["orderNo"] = implode(' , ', $orderIds);
        $data["paidDate"] = date("Y-m-d H:i:s");
        $data["paidAmount"] = $paidAmount;
        $data["organizationname"] = implode(' , ', $organizationNames);
        $data["type"] = 'Other';
        $data["front_url"] = $front_url;
        $data["back_url"] = $back_url;
        $data["reference"] = $paymentReference;

        // Mail::send('pages.order_management.payment.payment-notify-template-bulk', $data, function ($message) use ($data, $mailToArr) {

        // foreach ($mailToArr as $mails) {
        //     $message->to($mails);
        // }

        // $message->subject($data["title"]);

        // });
        email_Notify()->sendEmailFromTemplate('key_email_payment_bulk', [

            'orderIds' => implode(' , ', $orderIds),
            'orderNo' => implode(' , ', $orderIds),
            'paidDate' => date("Y-m-d H:i:s"),
            'paidAmount' => $paidAmount,
            'organizationname' => implode(' , ', $organizationNames),
            'type' => 'Other',
            'front_url' => $front_url,
            'back_url' => $back_url,
            'reference' => $paymentReference,
        ]);
        return "ok";
    }
    public function uploadProofment(Request $request) {

        $filePath = null;

        if ($request->hasFile('other_front') && $request->file('other_front')->isValid()) {
            $file = $request->file('other_front');

            $destinationPath = 'uploads/other payments';
            $fileName = Carbon::now()->format('YmdHsi').'_'.$request->order_id.'_other_front.'.$file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);

            return $destinationPath.'/'.$fileName;
        }
    }
    public function uploadProofmentback(Request $request) {

        $filePath = null;

        if ($request->hasFile('other_back') && $request->file('other_back')->isValid()) {
            $file = $request->file('other_back');

            $destinationPath = 'uploads/other payments';
            $fileName = Carbon::now()->format('YmdHsi').'_'.$request->order_id.'_other_back.'.$file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);

            return $destinationPath.'/'.$fileName;
        }
    }

}
