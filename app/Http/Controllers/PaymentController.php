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
use App\Models\EmailNotification;
use App\Models\OrderItem;
use App\Services\EmailNotificationBuilderService;
use Illuminate\Support\Facades\Blade;

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
        // Authorize.Net limits company names to 50 characters.
        $customerAddress->setCompany(mb_substr($input['company'], 0, 50, 'UTF-8'));
        $customerAddress->setAddress($input['street']);
        $customerAddress->setCity($input['city']);
        $customerAddress->setState($input['state']);
        $customerAddress->setZip($input['zip_code']);
        $customerAddress->setCountry($input['country']);
        $customerAddress->setPhoneNumber($input['phone']);

        $strLimitCompanyName = mb_substr($orderDetails->organizationDetails['organization_name'], 0, 50, 'UTF-8');

        // Set the customer's Ship To address
        $customerShipping = new AnetAPI\CustomerAddressType();
        $customerShipping->setFirstName($orderDetails->contactDetails['first_name']);
        $customerShipping->setLastName($orderDetails->contactDetails['last_name']);
        $customerShipping->setCompany($strLimitCompanyName);
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
        // Authorize.Net limits company names to 50 characters.
        $customerAddress->setCompany(mb_substr($input['company'], 0, 50, 'UTF-8'));
        $customerAddress->setAddress($input['street']);
        $customerAddress->setCity($input['city']);
        $customerAddress->setState($input['state']);
        $customerAddress->setZip($input['zip_code']);
        $customerAddress->setCountry($input['country']);
        $customerAddress->setPhoneNumber($input['phone']);

        $strLimitCompanyName = mb_substr($orderDetails->organizationDetails['organization_name'], 0, 50, 'UTF-8');

        // Set the customer's Ship To address
        $customerShipping = new AnetAPI\CustomerAddressType();
        $customerShipping->setFirstName($orderDetails->contactDetails['first_name']);
        $customerShipping->setLastName($orderDetails->contactDetails['last_name']);
        $customerShipping->setCompany($strLimitCompanyName);
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
            // return view('pages.order_management.orders.invoicepayments', ['orders'=>$orders, 'orderPaymentsArray'=>$orderPaymentsArray,'msg_type'=>$msg_type,'message_text'=>$message_text,'pdfdata' => $pdfdata,]);//
            return $this->downloadSingleCardReceiptPdf(
                $orders[0],
                $pdfdata,
                $input['email'] ?? null,
                $billinginfo,
                $orderPaymentsArray,
                // old view data → used only if the new PDF fails (old flow)
                [
                    'orders'             => $orders,
                    'orderPaymentsArray' => $orderPaymentsArray,
                    'msg_type'           => $msg_type,
                    'message_text'       => $message_text,
                    'pdfdata'            => $pdfdata,
                ]
            );
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
            'sub_total'          => number_format((float) ($orderModel->sub_total ?? 0), 2),
            'discountType'       => $orderModel->discountType ?? '',
            'discount'           => $orderModel->discount ?? '',
            'artwork'            => number_format((float) ($orderModel->artwork ?? 0), 2),
            'sales_tax_rate'     => $orderModel->sales_tax_rate ?? '',
            'discount_hidation'  => $orderModel->discount_hidation ?? '',
            'sale_tax'           => number_format((float) ($orderModel->sales_tax ?? 0), 2),
            'shipping_fee'       => number_format((float) ($orderModel->shipping ?? 0), 2),
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

    /**
     * SINGLE CARD PAYMENT
     */
    private function downloadSingleCardReceiptPdf($order, array $pdfdata, $mail, array $billinginfo, array $orderPaymentsArray, array $oldViewData)
    {
        try {
            // 1) Same data as sendPaymentMailCustomer()
            $templateData = $this->buildSingleCardReceiptData($order, $pdfdata, $mail, $billinginfo);

            // 2) Render the same email template
            $template = EmailNotification::where('template_key', 'key_email_customer_payment_receipt_card')->first();
            if (!$template || empty($template->body)) {
                throw new \Exception('Template key_email_customer_payment_receipt_card not found.');
            }

            $html = Blade::render($template->body, array_merge(['order_items_Array' => ''], $templateData));

            // 3) Prepare the full email for PDF
            $html = $this->prepareSingleReceiptHtmlForPdf($html);

            // 4) Footer → only at the bottom of the receipt page (page 1), rounded corners kept
            $html = $this->movePdfFooterToFirstPageBottom($html);

            // 5) Add "Payment Details" on a new page (no footer there)
            $html = $this->addPaymentDetailsToReceiptHtml($html, $orderPaymentsArray);

            // 6) Make the PDF
            $pdfContent = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'isRemoteEnabled' => true,
                    'defaultFont'     => 'Arial',
                ])
                ->output();

            // 7) Download with a single-payment file name, then redirect
            $orderNo     = $templateData['order_number'] ?? ($order->order_no ?? $order->id);
            $fileName    = 'Payment_Receipt_' . $orderNo . '_' . now()->format('Ymd_His') . '.pdf';
            $redirectUrl = url("customer_portal/individual_payment/payments");

            return view('pages.customer_portal.single_payment_redirect', [
                'pdfBase64'   => base64_encode($pdfContent),
                'fileName'    => $fileName,
                'redirectUrl' => $redirectUrl,
            ]);

        } catch (\Throwable $e) {
            logger()->error('downloadSingleCardReceiptPdf failed: ' . $e->getMessage());

            // Safety: old flow
            return view('pages.order_management.orders.invoicepayments', $oldViewData);
        }
    }

    /**
     * Same data as sendPaymentMailCustomer() sends to the email template.
     */
    private function buildSingleCardReceiptData($order, array $pdfdata, $mail, array $billinginfo): array
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
            throw new \Exception('buildSingleCardReceiptData: order not found');
        }

        if (!$orderModel->relationLoaded('orderItems')) {
            $orderModel->load([
                'orderItems' => function ($query) {
                    $query->with(['productDetails', 'statusDetails'])->where('is_studio_item', 0);
                },
            ]);
        }

        $paymentCard = PaymentLog::where('order_id', $orderModel->id)
            ->where('response_code', '1')
            ->latest('created_at')
            ->first();

        $organizationName = optional($orderModel->organizationDetails)->organization_name ?? '';
        $customerName     = trim(optional($orderModel->contactDetails)->first_name . ' ' . optional($orderModel->contactDetails)->last_name);

        $orderItemsList = [];
        foreach ($orderModel->orderItems as $item) {
            $qty   = $item->quantity ?? $item->qty ?? 1;
            $price = $item->price ?? $item->unit_price ?? 0;
            $orderItemsList[] = [
                'product_name' => optional($item->productDetails)->product_name ?? ($item->product_name ?? 'Item'),
                'size'         => $item->size ?? '',
                'qty'          => $qty,
                'price'        => $price,
                'total'        => $item->total_price ?? $item->total ?? ($qty * $price),
            ];
        }

        $paymentMethodLabel = $pdfdata['Payment_method'] ?? 'Card';
        if (!empty($pdfdata['card_last_digits'])) {
            $paymentMethodLabel .= ' ending in ' . $pdfdata['card_last_digits'];
        }

        return [
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
            'sub_total'          => number_format((float) ($orderModel->sub_total ?? 0), 2),
            'discountType'       => $orderModel->discountType ?? '',
            'discount'           => $orderModel->discount ?? '',
            'artwork'            => number_format((float) ($orderModel->artwork ?? 0), 2),
            'sales_tax_rate'     => $orderModel->sales_tax_rate ?? '',
            'discount_hidation'  => $orderModel->discount_hidation ?? '',
            'sale_tax'           => number_format((float) ($orderModel->sales_tax ?? 0), 2),
            'shipping_fee'       => number_format((float) ($orderModel->shipping ?? 0), 2),
            'payment_status'     => $pdfdata['orderstatus'] ?? 'Paid',
            'status_color'       => $pdfdata['color'] ?? '#2dce89',
            'paid_date'          => $pdfdata['Date'] ?? now()->format('m-d-Y'),
        ];
    }

    /**
     * "Payment Details" list
     * Added at the very end, after the full email.
     */
    private function addPaymentDetailsToReceiptHtml(string $html, array $orderPaymentsArray): string
    {
        $rowsHtml    = '';
        $row         = 0;
        $totalAmount = 0;

        foreach ($orderPaymentsArray as $payment) {
            $row++;
            $amount = (float) ($payment['Amount'] ?? 0);
            $totalAmount += $amount;

            $date = $payment['PaymentDate'] ?? null;
            $dateText = $date instanceof \DateTimeInterface ? $date->format('m-d-Y H:i:s') : (string) $date;

            $rowsHtml .= '
                <tr>
                    <td style="padding:6px 10px;font-size:12px;color:#111827;border-bottom:1px solid #f3f4f6;">' . $row . '</td>
                    <td style="padding:6px 10px;font-size:12px;color:#111827;border-bottom:1px solid #f3f4f6;">' . e($payment['Method'] ?? '') . '</td>
                    <td style="padding:6px 10px;font-size:12px;color:#111827;border-bottom:1px solid #f3f4f6;">' . e($payment['NameonCard'] ?? '') . '</td>
                    <td style="padding:6px 10px;font-size:12px;color:#111827;border-bottom:1px solid #f3f4f6;">' . e($payment['TransactionId'] ?? '') . '</td>
                    <td style="padding:6px 10px;font-size:12px;color:#111827;border-bottom:1px solid #f3f4f6;">' . e($dateText) . '</td>
                    <td align="right" style="padding:6px 10px;font-size:12px;color:#111827;border-bottom:1px solid #f3f4f6;">$' . number_format($amount, 2) . '</td>
                </tr>';
        }

        if ($rowsHtml === '') {
            $rowsHtml = '<tr><td colspan="6" style="padding:8px 10px;font-size:12px;color:#6b7280;">No payments found.</td></tr>';
        }

        $section = '
            <!-- PAYMENT DETAILS (PDF only, new page) -->
            <div style="page-break-before:always;padding:0 48px;">
                <div style="font-size:15px;font-weight:700;color:#111827;margin-bottom:8px;">Payment Details</div>
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="border-collapse:collapse;border:1px solid #e5e7eb;font-family:Arial, Helvetica, sans-serif;">
                    <thead>
                        <tr style="background:#f9fafb;" bgcolor="#f9fafb">
                            <th align="left" style="padding:6px 10px;font-size:11px;font-weight:700;color:#6b7280;border-bottom:1px solid #e5e7eb;width:30px;">#</th>
                            <th align="left" style="padding:6px 10px;font-size:11px;font-weight:700;color:#6b7280;border-bottom:1px solid #e5e7eb;">METHOD</th>
                            <th align="left" style="padding:6px 10px;font-size:11px;font-weight:700;color:#6b7280;border-bottom:1px solid #e5e7eb;">NAME</th>
                            <th align="left" style="padding:6px 10px;font-size:11px;font-weight:700;color:#6b7280;border-bottom:1px solid #e5e7eb;">TRANSACTION ID</th>
                            <th align="left" style="padding:6px 10px;font-size:11px;font-weight:700;color:#6b7280;border-bottom:1px solid #e5e7eb;">DATE / TIME</th>
                            <th align="right" style="padding:6px 10px;font-size:11px;font-weight:700;color:#6b7280;border-bottom:1px solid #e5e7eb;">AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody>
                        ' . $rowsHtml . '
                        <tr>
                            <td colspan="5" style="padding:8px 10px;font-size:13px;font-weight:700;color:#111827;">Total Amount</td>
                            <td align="right" style="padding:8px 10px;font-size:13px;font-weight:700;color:#111827;">$' . number_format($totalAmount, 2) . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>';

        if (stripos($html, '</body>') !== false) {
            return str_ireplace('</body>', $section . '</body>', $html);
        }

        return $html . $section;
    }

    /**
     * Prepare the email HTML for DomPDF:
     */
    private function prepareSingleReceiptHtmlForPdf(string $html): string
    {
        // 1) Remove outer wrapper: <body><table width="100%"><tr><td align="center"> ... </td></tr></table></body>
        $html = preg_replace(
            '/(<body[^>]*>)\s*<table[^>]*width="100%"[^>]*>\s*<tr>\s*<td[^>]*align="center"[^>]*>/is',
            '$1',
            $html,
            1
        );
        $html = preg_replace(
            '/<\/td>\s*<\/tr>\s*<\/table>\s*(<\/body>)/is',
            '$1',
            $html,
            1
        );

        // 2) width="880" → 100%. Small widths like the logos stay the same.
        $html = preg_replace_callback('/width="(\d+)"/', function ($m) {
            return ((int) $m[1] > 600) ? 'width="100%"' : $m[0];
        }, $html);

        $pdfCss = '<style>
            @page { margin: 20px; }
            body { background: #ffffff !important; margin: 0; padding: 0; }
            tr { page-break-inside: avoid; }
        </style>';

        if (stripos($html, '</head>') !== false) {
            return str_ireplace('</head>', $pdfCss . '</head>', $html);
        }

        return $pdfCss . $html;
    }

    /**
     * PDF only: take the email footer out of the content and show it ONCE,
     */
    private function movePdfFooterToFirstPageBottom(string $html): string
    {
        $footerHeight = 105;   // height of the footer area (px)

        // Find the footer row: <!-- FOOTER --> <tr>...</tr> right before </table></body>
        if (!preg_match('/<!--\s*FOOTER\s*-->\s*(<tr>.*?<\/tr>)\s*(<\/table>\s*<\/body>)/is', $html, $match)) {
            return $html;
        }

        $footerRow = $match[1];

        // 1) Remove the footer from the main content
        $html = str_replace($match[0], $match[2], $html);

        // 2) Footer drawn ONCE (absolute = only on page 1), rounded bottom corners like the email
        $firstPageFooter = '
            <div class="pdf-first-page-footer">
                <div style="background:#ECEBE5;border-radius:0 0 12px 12px;overflow:hidden;">
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                        style="border-collapse:collapse;">' . $footerRow . '</table>
                </div>
            </div>';

        $html = preg_replace('/(<body[^>]*>)/i', '$1' . $firstPageFooter, $html, 1);

        // 3) Reserve space at the bottom of PAGE 1 ONLY
        $footerCss = '<style>
            @page { margin: 20px; }
            @page :first { margin-bottom: ' . ($footerHeight + 25) . 'px; }
            .pdf-first-page-footer {
                position: absolute;
                left: 0;
                right: 0;
                bottom: -' . ($footerHeight + 5) . 'px;
                height: ' . $footerHeight . 'px;
            }
        </style>';

        if (stripos($html, '</head>') !== false) {
            return str_ireplace('</head>', $footerCss . '</head>', $html);
        }

        return $footerCss . $html;
    }
    public function downloadPaymentReceiptPdf($type, $id)
    {
        $type = strtolower(trim((string) $type));
        $id   = (int) $id;

        /*
        |--------------------------------------------------------------------------
        | Payment Model
        |--------------------------------------------------------------------------
        */
        $paymentModels = [
            'card'   => PaymentLog::class,
            'check'  => CheckPayment::class,
            'other'  => OtherPayment::class,
            'venmo'  => VenmoPayment::class,
            'paypal' => PaypalPayment::class,
        ];

        abort_unless(
            isset($paymentModels[$type]),
            404,
            'Payment type not found.'
        );

        $payment = $paymentModels[$type]::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Order
        |--------------------------------------------------------------------------
        */
        $order = Order::with([
            'organizationDetails',
            'contactDetails',
            'orderItems' => function ($query) {
                $query->with([
                    'productDetails',
                    'statusDetails',
                ])->where('is_studio_item', 0);
            },
        ])->findOrFail($payment->order_id);

        /*
        |--------------------------------------------------------------------------
        | Transaction ID / Payment Method
        |--------------------------------------------------------------------------
        */
        switch ($type) {
            case 'card':
                $transactionId = (string) ($payment->transaction_id ?? ('CARD' . $payment->id));
                $paymentMethod = 'Card';
                break;

            case 'check':
                $transactionId = 'CHECK' . $payment->id;
                $paymentMethod = 'Check';
                break;

            case 'other':
                $transactionId = 'OTHER' . $payment->id;
                $paymentMethod = 'Other';
                break;

            case 'venmo':
                $transactionId = 'VENMO' . $payment->id;
                $paymentMethod = 'Venmo';
                break;

            case 'paypal':
                $transactionId = 'PAYPAL' . $payment->id;
                $paymentMethod = 'PayPal';
                break;

            default:
                abort(404, 'Payment type not found.');
        }

        /*
        |--------------------------------------------------------------------------
        | Individual Payment Status
        |--------------------------------------------------------------------------
        */
        if ($type === 'card') {

            $paymentStatus = ((string) ($payment->response_code ?? '') === '1')
                ? 'Completed'
                : 'Failed';

        } elseif (in_array($type, ['check', 'venmo', 'paypal'])) {

            $approvalStatus = (int) ($payment->is_approved ?? 0);

            if ($approvalStatus === 1) {
                $paymentStatus = 'Completed';
            } elseif ($approvalStatus === 0) {
                $paymentStatus = 'Pending';
            } else {
                $paymentStatus = 'Rejected';
            }

        } else {

            $paymentStatus = ((int) ($payment->is_approved ?? 1) === 1)
                ? 'Completed'
                : 'Rejected';
        }

        switch ($paymentStatus) {
            case 'Completed':
                $paymentStatusColor = '#16a34a';
                break;

            case 'Pending':
                $paymentStatusColor = '#f59e0b';
                break;

            case 'Rejected':
            case 'Failed':
                $paymentStatusColor = '#dc2626';
                break;

            default:
                $paymentStatusColor = '#64748b';
                break;
        }

        /*
        |--------------------------------------------------------------------------
        | Payment Amount / Processing Fee
        |--------------------------------------------------------------------------
        |
        | Card and PayPal store the amount including the 3% processing fee.
        |
        */
        $rawPaymentAmount = (float) ($payment->amount ?? 0);

        if ($type === 'card' || $type === 'paypal') {

            $paymentAmount = round(
                ($rawPaymentAmount * 100) / 103,
                2
            );

            $processingFee = round(
                ($rawPaymentAmount * 3) / 103,
                2
            );

        } else {

            $paymentAmount = $rawPaymentAmount;
            $processingFee = 0.00;
        }

        /*
        |--------------------------------------------------------------------------
        | Customer / Organization
        |--------------------------------------------------------------------------
        */
        $organizationName =
            optional($order->organizationDetails)->organization_name ?? '';

        $customerName = trim(
            (string) optional($order->contactDetails)->first_name
            . ' '
            . (string) optional($order->contactDetails)->last_name
        );

        if ($customerName === '') {
            $customerName = trim(
                (string) ($order->first_name ?? '')
                . ' '
                . (string) ($order->last_name ?? '')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Order Items
        |--------------------------------------------------------------------------
        */
        $orderItems = [];

        foreach ($order->orderItems as $item) {

            $qty = (float) (
                $item->quantity
                ?? $item->qty
                ?? 1
            );

            $price = (float) (
                $item->price
                ?? $item->unit_price
                ?? 0
            );

            $total = (float) (
                $item->total_price
                ?? $item->total
                ?? ($qty * $price)
            );

            $orderItems[] = [
                'product_name' =>
                    optional($item->productDetails)->product_name
                    ?? ($item->product_name ?? 'Item'),

                'size'  => $item->size ?? '',
                'qty'   => $qty,
                'price' => $price,
                'total' => $total,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Invoice Amounts
        |--------------------------------------------------------------------------
        */
        $subTotal = (float) ($order->sub_total ?? 0);
        $artwork  = (float) ($order->artwork ?? 0);
        $discount = (float) ($order->discount ?? 0);

        $discountAmount       = 0.00;
        $invoiceBeforeDiscount = $subTotal + $artwork;

        if ((int) ($order->discount_hidation ?? 0) === 1) {

            if ((int) ($order->discountType ?? 0) === 1) {

                // Percentage discount
                $discountAmount =
                    ($invoiceBeforeDiscount / 100) * $discount;

            } elseif ((int) ($order->discountType ?? 0) === 2) {

                // Fixed discount
                $discountAmount = $discount;
            }
        }

        $totalInvoiceAmount = max(0,$invoiceBeforeDiscount - $discountAmount);

        /*
        |--------------------------------------------------------------------------
        | Calculate Payments Up To This Receipt
        |--------------------------------------------------------------------------
        |
        | This keeps historical receipts accurate by excluding payments made
        | after the selected payment.
        |
        */
        $cutoff = $payment->created_at ?? now();

        $cardAmount = (float) PaymentLog::where('order_id', $order->id)
            ->where('response_code', '1')
            ->where('created_at', '<=', $cutoff)
            ->sum('amount');

        $checkAmount = (float) CheckPayment::where('order_id', $order->id)
            ->where('is_approved', 1)
            ->where('created_at', '<=', $cutoff)
            ->sum('amount');

        $otherAmount = (float) OtherPayment::where('order_id', $order->id)
            ->where('is_approved', 1)
            ->where('created_at', '<=', $cutoff)
            ->sum('amount');

        $venmoAmount = (float) VenmoPayment::where('order_id', $order->id)
            ->where('is_approved', 1)
            ->where('created_at', '<=', $cutoff)
            ->sum('amount');

        $paypalAmount = (float) PaypalPayment::where('order_id', $order->id)
            ->where('is_approved', 1)
            ->where('created_at', '<=', $cutoff)
            ->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | Total Paid
        |--------------------------------------------------------------------------
        */
        $cardNetAmount = $cardAmount > 0
            ? round(($cardAmount * 100) / 103, 2)
            : 0.00;

        $paypalNetAmount = $paypalAmount > 0
            ? round(($paypalAmount * 100) / 103, 2)
            : 0.00;

        $totalPaid =
            $cardNetAmount
            + $paypalNetAmount
            + $checkAmount
            + $venmoAmount
            + $otherAmount;

        $totalPaid = round($totalPaid, 2);

        /*
        |--------------------------------------------------------------------------
        | Order Payment Status
        |--------------------------------------------------------------------------
        */
        $orderTotal = (float) ($order->order_total ?? 0);

        $balanceRemaining = max(
            0,
            round($orderTotal - $totalPaid, 2)
        );

        if ($totalPaid <= 0 && $orderTotal > 0) {

            $orderPaymentStatus      = 'Pending';
            $orderPaymentStatusColor = '#64748b';

        } elseif ($totalPaid < $orderTotal) {

            $orderPaymentStatus      = 'Partial';
            $orderPaymentStatusColor = '#f59e0b';

        } else {

            $orderPaymentStatus      = 'Paid';
            $orderPaymentStatusColor = '#16a34a';
        }

        /*
        |--------------------------------------------------------------------------
        | Convert Images To PDF-Friendly Sources
        |--------------------------------------------------------------------------
        */
        $imageSource = function ($value) {

            $value = trim((string) $value);

            if ($value === '') {
                return null;
            }

            /*
            * Already a base64 data image.
            */
            if (strpos($value, 'data:') === 0) {
                return $value;
            }

            $pathOnly = parse_url($value, PHP_URL_PATH);

            $relative = ltrim(
                (string) ($pathOnly ?: $value),
                '/'
            );

            $localPath = public_path($relative);

            /*
            * Local file → Base64.
            * Most reliable option for DomPDF.
            */
            if (is_file($localPath)) {

                $mime = mime_content_type($localPath)
                    ?: 'image/jpeg';

                return 'data:'
                    . $mime
                    . ';base64,'
                    . base64_encode(
                        file_get_contents($localPath)
                    );
            }

            /*
            * Existing external URL.
            */
            if (
                strpos($value, 'http://') === 0
                || strpos($value, 'https://') === 0
            ) {
                return $value;
            }

            /*
            * Relative public URL.
            */
            return url($relative);
        };

        /*
        |--------------------------------------------------------------------------
        | Logos
        |--------------------------------------------------------------------------
        */
        $logo = $imageSource(
            'argon/img/encore/logo.png'
        );

        $footerLogo = $imageSource(
            'argon/img/encore/logo_dark.png'
        );

        /*
        |--------------------------------------------------------------------------
        | Check Images
        |--------------------------------------------------------------------------
        */
        $checkFront = null;
        $checkBack  = null;

        if ($type === 'check') {

            $checkFront = $imageSource(
                $payment->check_front ?? null
            );

            $checkBack = $imageSource(
                $payment->check_back ?? null
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Other Payment Receipt / Proof Images
        |--------------------------------------------------------------------------
        */
        $paymentReceiptImage = null;
        $paymentReceiptImageBack = null;

        if ($type === 'venmo') {

            $paymentReceiptImage = $imageSource(
                $payment->venmo_receipt ?? null
            );

        } elseif ($type === 'paypal') {

            $paymentReceiptImage = $imageSource(
                $payment->paypal_receipt ?? null
            );

        } elseif ($type === 'other') {

            $paymentReceiptImage = $imageSource(
                $payment->document_url
                ?? $payment->receipt
                ?? $payment->other_receipt
                ?? $payment->file
                ?? null
            );

            $paymentReceiptImageBack = $imageSource(
                $payment->document_url_back ?? null
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PDF Data
        |--------------------------------------------------------------------------
        */
        $data = [
            'logo'        => $logo,
            'footer_logo' => $footerLogo,

            'order'             => $order,
            'order_number'      => $order->order_no,
            'organization_name' => $organizationName,
            'customer_name'     => $customerName,

            'customer_email' =>
                $order->email
                ?? optional($order->contactDetails)->email
                ?? '',

            'customer_phone' =>
                $order->phone_no
                ?? optional($order->contactDetails)->phone_no
                ?? '',

            'customer_street'  => $order->street ?? '',
            'customer_city'    => $order->city ?? '',
            'customer_state'   => $order->state ?? '',
            'customer_postal'  => $order->postal_code ?? '',
            'customer_country' => $order->country ?? '',

            'order_items' => $orderItems,

            /*
            * Selected payment
            */
            'payment_method'       => $paymentMethod,
            'transaction_id'       => $transactionId,
            'payment_status'       => $paymentStatus,
            'payment_status_color' => $paymentStatusColor,

            'payment_date' =>
                optional($payment->created_at)->format('m/d/Y')
                ?? now()->format('m/d/Y'),

            'payment_time' =>
                optional($payment->created_at)->format('H:i:s')
                ?? now()->format('H:i:s'),

            'paid_amount'    => $paymentAmount,
            'processing_fee' => $processingFee,

            /*
            * Invoice
            */
            'sub_total'            => $subTotal,
            'artwork'              => $artwork,
            'discount_type'        => (int) ($order->discountType ?? 0),
            'discount'             => $discount,
            'discount_amount'      => $discountAmount,
            'total_invoice_amount' => $totalInvoiceAmount,

            'sales_tax_rate' =>
                $order->sales_tax_rate ?? null,

            'sales_tax' =>
                (float) ($order->sales_tax ?? 0),

            'shipping_fee' =>
                (float) ($order->shipping ?? 0),

            'order_total' => $orderTotal,

            /*
            * Payment summary as of this transaction
            */
            'total_paid'                 => $totalPaid,
            'balance_remaining'          => $balanceRemaining,
            'order_payment_status'       => $orderPaymentStatus,
            'order_payment_status_color' => $orderPaymentStatusColor,

            /*
            * Card
            */
            'card_last_digits' =>
                $type === 'card'
                    ? ($payment->card_last_digits ?? null)
                    : null,

            'card_owner' =>
                $type === 'card'
                    ? ($payment->name_on_card ?? null)
                    : null,

            /*
            * Receipt images
            */
            'check_front' => $checkFront,
            'check_back'  => $checkBack,

            'payment_receipt_image' =>
                $paymentReceiptImage,

            'payment_receipt_image_back' =>
                $paymentReceiptImageBack,
        ];

        /*
        |--------------------------------------------------------------------------
        | Generate PDF
        |--------------------------------------------------------------------------
        */
        $pdf = Pdf::loadView(
            'pages.order_management.payment.payment_receipt_pdf',
            $data
        )->setOptions([
            'isRemoteEnabled'      => true,
            'isHtml5ParserEnabled' => true,
            'defaultFont'          => 'Arial',
        ]);

        $pdf->setPaper('A4', 'portrait');

        /*
        |--------------------------------------------------------------------------
        | File Name
        |--------------------------------------------------------------------------
        */
        $safeOrderNo = preg_replace(
            '/[^A-Za-z0-9\-_]/',
            '_',
            (string) $order->order_no
        );

        $safeTransactionId = preg_replace(
            '/[^A-Za-z0-9\-_]/',
            '_',
            (string) $transactionId
        );

        $fileName =
            'Payment_Receipt_'
            . $safeOrderNo
            . '_'
            . $safeTransactionId
            . '.pdf';

        /*
        |--------------------------------------------------------------------------
        | Download
        |--------------------------------------------------------------------------
        */
        return $pdf->download($fileName);
    }
}
