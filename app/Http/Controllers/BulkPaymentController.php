<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\NotificationBuilderService;
use App\Models\User;
use App\Models\Order;
use App\Models\Notification;
use App\Models\PaymentLog;
use App\Models\PaypalPayment;
use App\Models\VenmoPayment;
use App\Models\CheckPayment;
use App\Models\OtherPayment;
use App\Models\DebitEntry;
use App\Models\SummaryAtPayment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Services\PaymentService;
use App\Models\AccountsLog;
use App\Services\EmailNotificationBuilderService;
use Illuminate\Support\Facades\Crypt;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;



class BulkPaymentController extends Controller
{
    protected $PaymentService;
    public function __construct(Request $request , PaymentService $PaymentService) {
        //$this->middleware('auth'); // later enable it when needed user login while payment
        $this->PaymentService = $PaymentService;
    }

    public function customer_payment_bulk(Request $request)
{

    $ordersInput = $request->input('orders');
    if (!$ordersInput || count($ordersInput) === 0) {
        return redirect()->back()
            ->withErrors(['payment' => 'Please select at least one order to pay.'])
            ->withInput();
    }

    $total = array_sum($ordersInput);
    $currentPayments = [];

    switch ($request->payment_type) {

        case '215sds2358': // CARD
            $expectedAmount = round($total + ($total * 0.03), 2);
            if (round($request->amount, 2) != $expectedAmount) {
                return redirect()->back()
                    ->withErrors(['payment' => 'Card payment amount mismatch.'])
                    ->withInput();
            }
            $currentPayments = $this->customer_card_payment($request, true);
            break;

        case '89421ssafs524': // CHECK
            if (round($request->check_customer_paid_amount, 2) != round($total, 2)) {
                return redirect()->back()
                    ->withErrors(['payment' => 'Check payment amount mismatch.'])
                    ->withInput();
            }
            $currentPayments = $this->customer_check_payment($request);
            break;

        case '458665sfsf25': // PAYPAL
            $expectedAmount = round($total + ($total * 0.03), 2);
            if (round($request->amount, 2) != $expectedAmount) {
                return redirect()->back()
                    ->withErrors(['payment' => 'PayPal payment amount mismatch.'])
                    ->withInput();
            }
            $currentPayments = $this->customer_paypal_payment($request);
            break;

        case '23565sdss58': // VENMO
            if (round($request->venmo_customer_paid_amount, 2) != round($total, 2)) {
                return redirect()->back()
                    ->withErrors(['payment' => 'Venmo payment amount mismatch.'])
                    ->withInput();
            }
            $currentPayments = $this->customer_venmo_payment($request);
            break;

        default:
            return redirect()->back()
                ->withErrors(['payment' => 'Invalid payment method selected.']);
    }

   if ($currentPayments instanceof \Illuminate\Http\RedirectResponse) {
        return $currentPayments;
    }

    if (!is_array($currentPayments)) {
        return redirect()->back()
            ->withErrors([
                'payment' => 'Payment completed, but invoice generation failed. Please contact support.'
            ]);
    }

    return $this->downloadBulkInvoicePdf(array_keys($ordersInput), $currentPayments);
    }


    private function customer_card_payment(Request $request, $returnPaymentsOnly = false){

        $input = $request->input();
        $firstOrderId = array_key_first($input['orders']);
        $currentPayments = [];
        $gateway = getPaymentGatewayConfig();
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName($gateway['login_id']);
        $merchantAuthentication->setTransactionKey($gateway['transaction_key']);
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

        $orderDetails = Order::with('contactDetails', 'organizationDetails')->where('id', $firstOrderId)->first();
        // Set the customer's Bill To address
        $customerAddress = new AnetAPI\CustomerAddressType();
        $customerAddress->setFirstName($input['first_name']);
        $customerAddress->setLastName($input['last_name']);
        $customerAddress->setCompany($orderDetails->organizationDetails->organization_name);
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
        // $transactionRequestType->setOrder($order);
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
            if ($response->getMessages()->getResultCode() == "Ok") {
                $tresponse = $response->getTransactionResponse();
                if ($tresponse != null && $tresponse->getMessages() != null) {
                    $message_text = $tresponse->getMessages()[0]->getDescription().", Transaction ID: " . $tresponse->getTransId();
                    $msg_type = "success_msg";
                    $orders = $request->input('orders');

                    $accountNumber = $tresponse->getAccountNumber();

                    $cardLast4 = $accountNumber ? substr($accountNumber, -4) : null;

                    $rowsHtml   = '';
                    $orderIdPills = '';  
                    $totalAmountPaid = 0;
                    $transactionId   = null;
                    $paymentMadeBy   = $request->owner;
                    $orgName = '';
                    $orgURL = '';
                    $allOrderIds = [];

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

                    foreach ($orders as $orderId => $amount) {
                        $AccLogOrder = Order::where('id' , $orderId)->first();
                        $payment_of_order = $this->PaymentService->getPaymentStatus($orderId);

                        $Order = Order::where('id', $orderId)->firstOrFail();

                        $Order->payment_status = app(\App\Services\PaymentService::class)
                            ->getPaymentStatus($Order->id);

                        $baseAmount = $amount;
                        $processingFee = round($baseAmount * 0.03, 2);
                        $finalAmount = round($baseAmount + $processingFee, 2);

                        if($AccLogOrder->order_status_id == 1 && !AccountsLog::where('order_id', $orderId)->where('type', 0)->where('status', 1)->where('note', 'Outstanding Invoice')->exists()){
                            $CreditAccount = new AccountsLog();
                            $CreditAccount->organization_id = $AccLogOrder->organization_id;
                            $CreditAccount->amount = $payment_of_order['order_total'];
                            $CreditAccount->order_id = $orderId;
                            $CreditAccount->paid = 0;
                            $CreditAccount->balance = 0;
                            $CreditAccount->debit_balance =$payment_of_order['order_total'];
                            $CreditAccount->type = 0;
                            $CreditAccount->user_id = $AccLogOrder->user_id;
                            $CreditAccount->status = 1;
                            $CreditAccount->note = 'Outstanding Invoice';
                            $CreditAccount->save();
                        }
                        $paymentLog = new PaymentLog();
                        $paymentLog->amount = $finalAmount;
                        $paymentLog->order_id = $orderId;
                        $paymentLog->response_code =$tresponse->getResponseCode();
                        $paymentLog->transaction_id = $tresponse->getTransId();
                        $paymentLog->auth_id = $tresponse->getAuthCode();
                        $paymentLog->message_code = $tresponse->getMessages()[0]->getCode();
                        $paymentLog->name_on_card = trim($input['owner']);
                        $paymentLog->card_last_digits = $cardLast4;
                        $paymentLog->quantity = 1;
                        $paymentLog->save();

                        $summaryAtPayment = new SummaryAtPayment();
                        $summaryAtPayment->order_id = $orderId;
                        $summaryAtPayment->organization_id = $AccLogOrder->organization_id;
                        // $summaryAtPayment->totalItemQty = $request->totalItemQty;
                        $summaryAtPayment->subTotal = $Order->sub_total; // Use the cleaned value
                        $summaryAtPayment->shipping = $Order->shipping;
                        $summaryAtPayment->salesTax = $Order->sales_tax;
                        $summaryAtPayment->artwork = $Order->artwork;
                        $summaryAtPayment->payment_type = 'Invoice Payment';
                        $summaryAtPayment->processingFee = $processingFee;
                        $summaryAtPayment->orderTotal = $Order->order_total; // Use the cleaned value
                        $summaryAtPayment->balancePayment = (float) str_replace(',', '', $Order->payment_status['balance_to_be_paid']);
                        $summaryAtPayment->payedAmount = $finalAmount;
                        $summaryAtPayment->method = 'Card';
                        $summaryAtPayment->created_at = Carbon::now()->addMinute();
                        $summaryAtPayment->save();

                        $currentPayments[] = [
                            'order_id'       => $orderId,
                            'order_no'       => $Order->order_no,
                            'method'         => 'Card',
                            'transaction_id' => $tresponse->getTransId(),
                            'paid_at'        => now(),
                            'amount'         => $finalAmount,
                        ];



                       $order = Order::with('organizationDetails')->find($orderId);

                       $allOrderIds[] = $orderId;

                        $transactionId = $paymentLog->transaction_id;
                        $orgName = optional($order->organizationDetails)->organization_name ?? '';
                        $orgURL = url('organizations/info/' . optional($order->organizationDetails)->id);

                        if (!$order) {
                            continue;
                        }


                        $orderLink = url("order_details/edit/{$orderId}/order") . '?active_tab=order';
                        $paymentUrl         = route('payment', [
                            'orderId'       => $summaryAtPayment->order_id,
                            'totalItemQty'  => $summaryAtPayment->totalItemQty,
                            'sub_total'     => number_format($summaryAtPayment->sub_total, 2),
                            'salesTax'      => number_format($summaryAtPayment->salesTax, 2),
                            'shipping'      => number_format($summaryAtPayment->shipping, 2),
                            'artwork'       => number_format($summaryAtPayment->artwork, 2),
                            'processingFee' => number_format($summaryAtPayment->card_fee, 2),
                            'orderTotal'    => number_format($summaryAtPayment->order_total, 2),
                        ]);

                        $rowsHtml .= '<div style="display:grid;grid-template-columns:84px 122px 109px 102px 111px 95px;gap:8px;gap:8px;align-items:center;padding:12px 16px;font-size:13px;color:#1f2937;border-bottom:1px solid #9ca3af;width:max-content;min-width:100%;box-sizing:border-box">
                            <div><a href="' . $orderLink . '" style="color:#111827;text-decoration:none;font-weight:600" target="_blank">#' . e($order->order_no) . '</a></div>
                            <div style="color:#374151">' . ($order->ex_factory_date ? e($order->ex_factory_date) : '-') . '</div>
                            <div style="color:#374151">$' . number_format($order->order_total, 2) . '</div>
                            <div style="font-weight:700;color:#16a34a">$' . number_format($amount, 2) . '</div>
                            <div style="font-weight:700;color:#16a34a">$' . number_format($summaryAtPayment->balancePayment, 2) . '</div>
                            <div style="text-align:center"><a href="' . $paymentUrl . '" target="_blank" style="color:#111827;text-decoration:none" title="Go to payment"><i class="fas fa-external-link-alt"></i></a></div>
                        </div>';

                        $orderIdPills .= '<span style="display:inline-block;background:#f9fafb;border:1px solid #e5e7eb;border-radius:6px;padding:6px 12px;margin:0 6px 8px 0;font-size:13px;font-weight:700;color:#111827;">'
                            . '<a href="' . e($orderLink) . '" target="_blank" style="color:#111827;text-decoration:none;">#' . e($order->order_no) . ' &#8599;</a>'
                            . '</span>';

                        $totalAmountPaid += $finalAmount;

                        // $salesPersonEmail = $this->getSalePersonEmail($orderId);

                        // $this->sendPaymentMail($orderId, $finalAmount, $users);

                    }
                    $builder = new NotificationBuilderService();

                    $builder->sendNotification(
                        'key_payment_card',
                        [
                            '{order_no}'       => $Order->order_no,
                            '{transaction_id}'  => $transactionId ?? '-',
                            '{payment_made_by}' => $paymentMadeBy,
                            '{total_paid}'      => $totalAmountPaid,
                            '{organization_name}' => $orgName,
                            '{organization_url}' => $orgURL,
                            '{date_time}'       => now()->format('m/d/Y') . ' • ' . now()->format('H:i:s'),
                            '{total_amount}'    => '$' . number_format($totalAmountPaid, 2),
                            '{rowsHtml}'      => $rowsHtml,
                        ],
                        [
                            'is_payment'                 => 1,
                            'target_notification_field'  => 'key_payment_card',
                            'new_notification'           => 1,
                            'order_ids'                  => $allOrderIds,
                        ]
                    );

                    $this->sendBulkCardPaymentMail($allOrderIds, $orderIdPills, $transactionId, $paymentMadeBy, $totalAmountPaid, $paymentUrl ?? url('/'));
                    $this->sendBulkCardPaymentMailCustomer($allOrderIds, $currentPayments, $transactionId, $paymentMadeBy, $totalAmountPaid, $input['email'] ?? null, $billinginfo ?? []);

                    
                    // return redirect()->route('customer_portal.payments')->with($msg_type, $message_text);
                    if ($returnPaymentsOnly) {
                        return $currentPayments;
                    }

                    return $this->downloadBulkInvoicePdf(
                        array_keys($orders),
                        $currentPayments
                    );

                }else {
                    $message_text = 'There were some issue with the payment. Please try again later.';
                    $msg_type = "error_msg";

                    if ($tresponse->getErrors() != null) {
                        $message_text = $tresponse->getErrors()[0]->getErrorText();
                        $msg_type = "error_msg";
                    }
                }

            }else {
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

        }
        else {
            $message_text = "No response returned";
            $msg_type = "error_msg";
        }

        return redirect()->back()->with($msg_type, $message_text);

    }
    private function customer_paypal_payment(Request $request){

        $orders = $request->input('orders');
        $paypalReceipt = self::uploadPaypalReceipt($request);
        $currentPayments = [];

        $rowsHtml   = '';
        $orderIdPills = ''; 
        $totalAmountPaid = 0;
        $orgName = '';
        $orgURL = '';
        $allOrderIds = []; 
        foreach ($orders as $orderId => $amount) {

            $Order = Order::where('id', $orderId)->firstOrFail();

            $Order->payment_status = app(\App\Services\PaymentService::class)
                ->getPaymentStatus($Order->id);

            $baseAmount = $amount;
            $processingFee = round($baseAmount * 0.03, 2);
            $finalAmount = round($baseAmount + $processingFee, 2);
            $payment_of_order = $this->PaymentService->getPaymentStatus($orderId);

            if($Order->order_status_id == 1 && !AccountsLog::where('order_id', $Order->id)->where('type', 0)->where('status', 1)->where('note', 'Outstanding Invoice')->exists()){
                $CreditAccount = new AccountsLog();
                $CreditAccount->organization_id = $Order->organization_id;
                $CreditAccount->amount = $payment_of_order['order_total'];
                $CreditAccount->order_id = $orderId;
                $CreditAccount->paid = 0;
                $CreditAccount->balance = 0;
                $CreditAccount->debit_balance =$payment_of_order['order_total'];
                $CreditAccount->type = 0;
                $CreditAccount->user_id = $Order->user_id;
                $CreditAccount->status = 1;
                $CreditAccount->active = 0;
                $CreditAccount->note = 'Outstanding Invoice';
                $CreditAccount->save();
            }

            $paypalPayment = new PaypalPayment();
            $paypalPayment->order_id = $Order->id;
            $paypalPayment->amount = $finalAmount;
            $paypalPayment->paypal_receipt = $paypalReceipt;
            $paypalPayment->save();


            $summaryAtPayment = new SummaryAtPayment();
            $summaryAtPayment->order_id = $Order->id;
            $summaryAtPayment->organization_id = $Order->organization_id;
            // $summaryAtPayment->totalItemQty = $Order->totalItemQty;
            $summaryAtPayment->subTotal = $Order->sub_total; // Use the cleaned value
            $summaryAtPayment->shipping = $Order->shipping;
            $summaryAtPayment->salesTax = $Order->sales_tax;
            $summaryAtPayment->artwork = $Order->artwork;
            $summaryAtPayment->payment_type = 'Invoice Payment';
            $summaryAtPayment->processingFee = $processingFee ;
            $summaryAtPayment->orderTotal = $Order->order_total; // Use the cleaned value
            $summaryAtPayment->balancePayment = (float) str_replace(',', '', $Order->payment_status['balance_to_be_paid']);
            $summaryAtPayment->payedAmount = $finalAmount;
            $summaryAtPayment->method = 'Paypal';
            $summaryAtPayment->active = 0;
            $summaryAtPayment->transaction_id = 'PAYPAL'.$paypalPayment->id;
            $summaryAtPayment->created_at = Carbon::now()->addMinute();
            $summaryAtPayment->save();

            $currentPayments[] = [
                'order_id'       => $orderId,
                'order_no'       => $Order->order_no,
                'method'         => 'PayPal',
                'transaction_id' => 'PAYPAL'.$paypalPayment->id,
                'paid_at'        => now(),
                'amount'         => $finalAmount,
            ];

            $order_for_rep = Order::where('id' , $Order->id)->first();
            if($order_for_rep){
                $order_for_rep_id = $order_for_rep->user_id;
            }
           
            $order = Order::with('organizationDetails')->find($orderId);
            
            $allOrderIds[] = $orderId;

            $orgName = optional($order->organizationDetails)->organization_name ?? '';
            $orgURL = url('organizations/info/' . optional($order->organizationDetails)->id);

            if (!$order) {
                continue;
            }

            $orderLink = url("order_details/edit/{$orderId}/order") . '?active_tab=order';
            $paymentUrl         = route('payment', [
                'orderId'       => $summaryAtPayment->order_id,
                'totalItemQty'  => $summaryAtPayment->totalItemQty,
                'sub_total'     => number_format($summaryAtPayment->sub_total, 2),
                'salesTax'      => number_format($summaryAtPayment->salesTax, 2),
                'shipping'      => number_format($summaryAtPayment->shipping, 2),
                'artwork'       => number_format($summaryAtPayment->artwork, 2),
                'processingFee' => number_format($summaryAtPayment->card_fee, 2),
                'orderTotal'    => number_format($summaryAtPayment->order_total, 2),
            ]);



            $rowsHtml .= '<div style="display:grid;grid-template-columns:61px 97px 75px 94px 101px 89px 86px;gap:8px;align-items:center;padding:12px 16px;font-size:13px;color:#1f2937;border-bottom:1px solid #9ca3af;width:max-content;min-width:100%;box-sizing:border-box">
                <div><a href="' . $orderLink . '" style="color:#111827;text-decoration:none;font-weight:600" target="_blank">#' . e($order->order_no) . '</a></div>
                <div style="color:#374151">' . ($order->ex_factory_date ? e($order->ex_factory_date) : '-') . '</div>
                <div style="color:#374151">$' . number_format($order->order_total, 2) . '</div>
                <div style="font-weight:700;color:#16a34a">$' . number_format($amount, 2) . '</div>
                <div style="font-weight:700;color:#16a34a">$' . number_format($summaryAtPayment->balancePayment, 2) . '</div>
                <div style="text-align:center"><a href="' . $paymentUrl . '" target="_blank" style="color:#111827;text-decoration:none" title="Go to payment"><i class="fas fa-external-link-alt"></i></a></div>
                <!--ACTION-CELL-paypal-' . $paypalPayment->id . '-START--><div style="display:flex;gap:6px;align-items:center;justify-content:center">
                    <button class="reject-btn" data-payment-id="' . $paypalPayment->id . '" onclick="isBulkPaymentMode=true;currentPaymentId=this.dataset.paymentId;openNcmPaymentRejectDialog()" style="background:#dc2626;border:none;border-radius:6px;color:#fff;font-size:10px;font-weight:700;letter-spacing:.3px;padding:6px 12px;cursor:pointer">REJECT</button>
                    <button class="conform-btn" data-payment-id="' . $paypalPayment->id . '" onclick="isBulkPaymentMode=true;currentPaymentId=this.dataset.paymentId;openNcmPaymentApproveDialog()" style="background:#0d9488;border:none;border-radius:6px;color:#fff;font-size:10px;font-weight:700;letter-spacing:.3px;padding:6px 12px;cursor:pointer;display:flex;align-items:center;gap:5px">
                        <i class="far fa-check-square" style="font-size:9px"></i> APPROVE
                    </button>
                </div><!--ACTION-CELL-paypal-' . $paypalPayment->id . '-END-->
            </div>';

            $orderIdPills .= '<span style="display:inline-block;background:#f9fafb;border:1px solid #e5e7eb;border-radius:6px;padding:6px 12px;margin:0 6px 8px 0;font-size:13px;font-weight:700;color:#111827;">'
            . '<a href="' . e($orderLink) . '" target="_blank" style="color:#111827;text-decoration:none;">#' . e($order->order_no) . ' &#8599;</a>'
            . '</span>';

            $totalAmountPaid += $amount;

            // $this->sendPaymentMail($Orderid, $users);
        }

        $paypalImagesHtml = '<div style="margin-bottom:20px;flex:0 0 auto">
            <div style="font-size:10px;font-weight:700;letter-spacing:.7px;text-transform:uppercase;color:#9ca3af;margin-bottom:10px">
                PAYPAL RECEIPT
            </div>
            <div style="display:flex;gap:16px;align-items:flex-start">
                <span style="flex:0 0 140px;text-align:center">
                    <img src="' . e(asset($paypalReceipt)) . '" alt="Venmo Receipt" style="width:120px;height:auto;border:1px solid #e5e7eb;border-radius:4px;cursor:zoom-in;display:block;margin:0 auto 6px"
                        onclick="(function(src){var o=document.getElementById(\'ncmInlineZoomOverlay\');if(!o){o=document.createElement(\'div\');o.id=\'ncmInlineZoomOverlay\';o.style.cssText=\'display:none;position:fixed;inset:0;background:rgba(0,0,0,0.85);z-index:99999;align-items:center;justify-content:center;cursor:zoom-out;\';var im=document.createElement(\'img\');im.style.cssText=\'max-width:90vw;max-height:88vh;border-radius:6px;box-shadow:0 20px 60px rgba(0,0,0,.5);\';o.appendChild(im);o.addEventListener(\'click\',function(){o.style.display=\'none\';});document.body.appendChild(o);}o.querySelector(\'img\').src=src;o.style.display=\'flex\';})(this.src)">
                    <span style="font-size:11px;font-weight:600;color:#6b7280">Receipt</span>
                </span>
            </div>
        </div>';

        $builder = new NotificationBuilderService();

        $builder->sendNotification(
            'key_payment_paypal',
            [
                '{order_no}'       => $Order->order_no,
                '{paypal_id}'          => '-',
                '{total_paid}'      => $totalAmountPaid,
                '{organization_name}' => $orgName,
                '{organization_url}' => $orgURL,
                '{date_time}'       => now()->format('m/d/Y') . ' • ' . now()->format('H:i:s'),
                '{total_amount}'    => '$' . number_format($totalAmountPaid, 2),
                '{paypalImagesHtml}' => $paypalImagesHtml,
                '{rowsHtml}'      => $rowsHtml,
            ],
            [
                'is_payment'                 => 1,
                'target_notification_field'  => 'key_payment_paypal',
                'new_notification'           => 1,
                'order_ids'                  => $allOrderIds,
            ]
        );
        
        $this->sendBulkPaypalPaymentMail($allOrderIds, $orderIdPills, $paypalReceipt, $totalAmountPaid);
        $this->sendBulkPaypalPaymentMailCustomer($allOrderIds, $currentPayments, $paypalReceipt, $totalAmountPaid);

        return $currentPayments;
        

    }
    private function customer_venmo_payment(Request $request){

        $venmoReceipt = self::uploadVenmoReceipt($request);
        $orders = $request->input('orders');
        $currentPayments = [];

        $rowsHtml   = '';
        $orderIdPills = '';
        $totalAmountPaid = 0;
        $orgName = '';
        $orgURL = '';
        $allOrderIds = []; 
        foreach ($orders as $orderId => $amount) {

            $Order = Order::where('id', $orderId)->firstOrFail();

            $Order->payment_status = app(\App\Services\PaymentService::class)
                ->getPaymentStatus($Order->id);

            $payment_of_order = $this->PaymentService->getPaymentStatus($orderId);

            if($Order->order_status_id == 1 && !AccountsLog::where('order_id', $orderId)->where('type', 0)->where('status', 1)->where('note', 'Outstanding Invoice')->exists()){
                $CreditAccount = new AccountsLog();
                $CreditAccount->organization_id = $Order->organization_id;
                $CreditAccount->amount = $payment_of_order['order_total'];
                $CreditAccount->order_id = $orderId;
                $CreditAccount->paid = 0;
                $CreditAccount->balance = 0;
                $CreditAccount->debit_balance =$payment_of_order['order_total'];
                $CreditAccount->type = 0;
                $CreditAccount->user_id = Auth::user()->id;
                $CreditAccount->status = 1;
                $CreditAccount->active = 0;
                $CreditAccount->note = 'Outstanding Invoice';
                $CreditAccount->save();
            }

            $venmoPayment = new VenmoPayment();
            $venmoPayment->order_id = $Order->id;
            $venmoPayment->customer_paid_amount = $amount;
            $venmoPayment->venmo_receipt = $venmoReceipt;
            $venmoPayment->save();

            $summaryAtPayment = new SummaryAtPayment();
            $summaryAtPayment->order_id = $Order->id;
            $summaryAtPayment->organization_id = $Order->organization_id;
            // $summaryAtPayment->totalItemQty = $request->totalItemQty;
            $summaryAtPayment->subTotal = $Order->sub_total; // Use the cleaned value
            $summaryAtPayment->shipping = $Order->shipping;
            $summaryAtPayment->salesTax = $Order->sales_tax;
            $summaryAtPayment->artwork = $Order->artwork;
            $summaryAtPayment->payment_type = 'Invoice Payment';
            $summaryAtPayment->processingFee = 0.00 ;
            $summaryAtPayment->orderTotal = $Order->order_total; // Use the cleaned value
            $summaryAtPayment->balancePayment = (float) str_replace(',', '', $Order->payment_status['balance_to_be_paid']);
            $summaryAtPayment->payedAmount = $amount;
            $summaryAtPayment->method = 'Venmo';
            $summaryAtPayment->active = 0;
            $summaryAtPayment->transaction_id = 'Venmo'.$venmoPayment->id;
            $summaryAtPayment->created_at = Carbon::now()->addMinute();
            $summaryAtPayment->save();

            $currentPayments[] = [
                'order_id'       => $orderId,
                'order_no'       => $Order->order_no,
                'method'         => 'Venmo',
                'transaction_id' => 'Venmo'.$venmoPayment->id,
                'paid_at'        => now(),
                'amount'         => $amount,
            ];

            $order_for_rep = Order::where('id' , $Order->id)->first();
            if($order_for_rep){
                $order_for_rep_id = $order_for_rep->user_id;
            }

            $order = Order::with('organizationDetails')->find($orderId);

            $allOrderIds[] = $orderId;

            $orgName = optional($order->organizationDetails)->organization_name ?? '';
            $orgURL = url('organizations/info/' . optional($order->organizationDetails)->id);

            if (!$order) {
                continue;
            }

            $orderLink = url("order_details/edit/{$orderId}/order") . '?active_tab=order';
            $paymentUrl         = route('payment', [
                'orderId'       => $summaryAtPayment->order_id,
                'totalItemQty'  => $summaryAtPayment->totalItemQty,
                'sub_total'     => number_format($summaryAtPayment->sub_total, 2),
                'salesTax'      => number_format($summaryAtPayment->salesTax, 2),
                'shipping'      => number_format($summaryAtPayment->shipping, 2),
                'artwork'       => number_format($summaryAtPayment->artwork, 2),
                'processingFee' => number_format($summaryAtPayment->card_fee, 2),
                'orderTotal'    => number_format($summaryAtPayment->order_total, 2),
            ]);



            $rowsHtml .= '<div style="display:grid;grid-template-columns:61px 97px 82px 82px 62px 64px 161px;gap:8px;align-items:center;padding:12px 16px;font-size:13px;color:#1f2937;border-bottom:1px solid #9ca3af;width:max-content;min-width:100%;box-sizing:border-box">
                <div><a href="' . $orderLink . '" style="color:#111827;text-decoration:none;font-weight:600" target="_blank">#' . e($order->order_no) . '</a></div>
                <div style="color:#374151">' . ($order->ex_factory_date ? e($order->ex_factory_date) : '-') . '</div>
                <div style="color:#374151">$' . number_format($order->order_total, 2) . '</div>
                <div style="font-weight:700;color:#16a34a">$' . number_format($amount, 2) . '</div>
                <div style="font-weight:700;color:#16a34a">$' . number_format($summaryAtPayment->balancePayment, 2) . '</div>
                <div style="text-align:center"><a href="' . $paymentUrl . '" target="_blank" style="color:#111827;text-decoration:none" title="Go to payment"><i class="fas fa-external-link-alt"></i></a></div>
                <!--ACTION-CELL-venmo-' . $venmoPayment->id . '-START--><div style="display:flex;gap:6px;align-items:center;justify-content:center">
                    <button class="reject-btn" data-payment-id="' . $venmoPayment->id . '" onclick="isBulkPaymentMode=true;currentPaymentId=this.dataset.paymentId;openNcmPaymentRejectDialog()" style="background:#dc2626;border:none;border-radius:6px;color:#fff;font-size:10px;font-weight:700;letter-spacing:.3px;padding:6px 12px;cursor:pointer">REJECT</button>
                    <button class="conform-btn" data-payment-id="' . $venmoPayment->id . '" onclick="isBulkPaymentMode=true;currentPaymentId=this.dataset.paymentId;openNcmPaymentApproveDialog()" style="background:#0d9488;border:none;border-radius:6px;color:#fff;font-size:10px;font-weight:700;letter-spacing:.3px;padding:6px 12px;cursor:pointer;display:flex;align-items:center;gap:5px">
                        <i class="far fa-check-square" style="font-size:9px"></i> APPROVE
                    </button>
                </div><!--ACTION-CELL-venmo-' . $venmoPayment->id . '-END-->
            </div>';

            $orderIdPills .= '<span style="display:inline-block;background:#f9fafb;border:1px solid #e5e7eb;border-radius:6px;padding:6px 12px;margin:0 6px 8px 0;font-size:13px;font-weight:700;color:#111827;">'
            . '<a href="' . e($orderLink) . '" target="_blank" style="color:#111827;text-decoration:none;">#' . e($order->order_no) . ' &#8599;</a>'
            . '</span>';

            $totalAmountPaid += $amount;


            $encryptedId = Crypt::encrypt($venmoPayment->id);
            // $this->sendPaymentMail($Order->id, $Order->order_no, $encryptedId, $amount, $users);
        }

        $checkImagesHtml = '<div style="margin-bottom:20px;flex:0 0 auto">
            <div style="font-size:10px;font-weight:700;letter-spacing:.7px;text-transform:uppercase;color:#9ca3af;margin-bottom:10px">
                VENMO RECEIPT
            </div>
            <div style="display:flex;gap:16px;align-items:flex-start">
                <span style="flex:0 0 140px;text-align:center">
                    <img src="' . e(asset($venmoReceipt)) . '" alt="Venmo Receipt" style="width:120px;height:auto;border:1px solid #e5e7eb;border-radius:4px;cursor:zoom-in;display:block;margin:0 auto 6px"
                        onclick="(function(src){var o=document.getElementById(\'ncmInlineZoomOverlay\');if(!o){o=document.createElement(\'div\');o.id=\'ncmInlineZoomOverlay\';o.style.cssText=\'display:none;position:fixed;inset:0;background:rgba(0,0,0,0.85);z-index:99999;align-items:center;justify-content:center;cursor:zoom-out;\';var im=document.createElement(\'img\');im.style.cssText=\'max-width:90vw;max-height:88vh;border-radius:6px;box-shadow:0 20px 60px rgba(0,0,0,.5);\';o.appendChild(im);o.addEventListener(\'click\',function(){o.style.display=\'none\';});document.body.appendChild(o);}o.querySelector(\'img\').src=src;o.style.display=\'flex\';})(this.src)">
                    <span style="font-size:11px;font-weight:600;color:#6b7280">Receipt</span>
                </span>
            </div>
        </div>';

        $builder = new NotificationBuilderService();

        $builder->sendNotification(
            'key_payment_venmo',
            [
                '{order_no}'       => $Order->order_no,
                '{venmo_id}'          => '-',
                '{total_paid}'      => $totalAmountPaid,
                '{organization_name}' => $orgName,
                '{organization_url}' => $orgURL,
                '{date_time}'       => now()->format('m/d/Y') . ' • ' . now()->format('H:i:s'),
                '{total_amount}'    => '$' . number_format($totalAmountPaid, 2),
                '{checkImagesHtml}' => $checkImagesHtml,
                '{rowsHtml}'      => $rowsHtml,
            ],
            [
                'is_payment'                 => 1,
                'target_notification_field'  => 'key_payment_venmo',
                'new_notification'           => 1,
                'order_ids'                  => $allOrderIds,
            ]
        );

        $this->sendBulkVenmoPaymentMail($allOrderIds, $orderIdPills, $venmoReceipt, $totalAmountPaid);
        $this->sendBulkVenmoPaymentMailCustomer($allOrderIds, $currentPayments, $venmoReceipt, $totalAmountPaid);


        return $currentPayments;


    }
    private function customer_check_payment($request){
        $checkFront = self::uploadCheckFront($request);
        $checkBack = self::uploadCheckBack($request);
        $orders = $request->input('orders');
        $currentPayments = [];

        $rowsHtml   = '';
        $orderIdPills = ''; 
        $totalAmountPaid = 0;
        $orgName = '';
        $orgURL = '';
        $allOrderIds = [];
        foreach ($orders as $orderId => $amount) {


            $Order = Order::where('id', $orderId)->firstOrFail();

            $Order->payment_status = app(\App\Services\PaymentService::class)
                ->getPaymentStatus($Order->id);


            $payment_of_order = $this->PaymentService->getPaymentStatus($orderId);

            if($Order->order_status_id == 1 && !AccountsLog::where('order_id', $orderId)->where('type', 0)->where('status', 1)->where('note', 'Outstanding Invoice')->exists()){
                $CreditAccount = new AccountsLog();
                $CreditAccount->organization_id = $Order->organization_id;
                $CreditAccount->amount = $payment_of_order['order_total'];
                $CreditAccount->order_id = $orderId;
                $CreditAccount->paid = 0;
                $CreditAccount->balance = 0;
                $CreditAccount->debit_balance =$payment_of_order['order_total'];
                $CreditAccount->type = 0;
                $CreditAccount->user_id = $Order->user_id;
                $CreditAccount->status = 1;
                $CreditAccount->active = 0;
                $CreditAccount->note = 'Outstanding Invoice';
                $CreditAccount->save();
            }

            $checkPayment = new CheckPayment();
            $checkPayment->order_id = $Order->id;
            $checkPayment->customer_paid_amount = $amount;
            $checkPayment->check_front = $checkFront;
            $checkPayment->check_back = $checkBack;
            $checkPayment->save();

            $order_for_rep = Order::where('id' , $Order->id)->first();
            if($order_for_rep){
                $order_for_rep_id = $order_for_rep->user_id;
            }

            $summaryAtPayment = new SummaryAtPayment();
            $summaryAtPayment->order_id = $Order->id;
            $summaryAtPayment->organization_id = $order_for_rep->organization_id;
            // $summaryAtPayment->totalItemQty = $request->totalItemQty;
            $summaryAtPayment->subTotal = $Order->sub_total; // Use the cleaned value
            $summaryAtPayment->shipping = $Order->shipping;
            $summaryAtPayment->salesTax = $Order->sales_tax;
            $summaryAtPayment->artwork = $Order->artwork;
            $summaryAtPayment->payment_type = 'Invoice Payment';
            $summaryAtPayment->processingFee = 0.00 ;
            $summaryAtPayment->orderTotal = $Order->order_total; // Use the cleaned value
            $summaryAtPayment->balancePayment = (float) str_replace(',', '', $Order->payment_status['balance_to_be_paid']);
            $summaryAtPayment->payedAmount = $amount;
            $summaryAtPayment->method = 'Check';
            $summaryAtPayment->active = 0;
            $summaryAtPayment->transaction_id = 'CHK'.$checkPayment->id;
            $summaryAtPayment->created_at = Carbon::now()->addMinute();
            $summaryAtPayment->save();

            $currentPayments[] = [
                'order_id'       => $orderId,
                'order_no'       => $Order->order_no,
                'method'         => 'Check',
                'transaction_id' => 'CHK'.$checkPayment->id,
                'paid_at'        => now(),
                'amount'         => $amount,
            ];

            $order = Order::with('organizationDetails')->find($orderId);

            $allOrderIds[] = $orderId;

            $orgName = optional($order->organizationDetails)->organization_name ?? '';
            $orgURL = url('organizations/info/' . optional($order->organizationDetails)->id);

            if (!$order) {
                continue;
            }


            $orderLink = url("order_details/edit/{$orderId}/order") . '?active_tab=order';
            $paymentUrl         = route('payment', [
                'orderId'       => $summaryAtPayment->order_id,
                'totalItemQty'  => $summaryAtPayment->totalItemQty,
                'sub_total'     => number_format($summaryAtPayment->sub_total, 2),
                'salesTax'      => number_format($summaryAtPayment->salesTax, 2),
                'shipping'      => number_format($summaryAtPayment->shipping, 2),
                'artwork'       => number_format($summaryAtPayment->artwork, 2),
                'processingFee' => number_format($summaryAtPayment->card_fee, 2),
                'orderTotal'    => number_format($summaryAtPayment->order_total, 2),
            ]);



            $rowsHtml .= '<div style="display:grid;grid-template-columns:61px 97px 82px 82px 62px 64px 161px;gap:8px;align-items:center;padding:12px 16px;font-size:13px;color:#1f2937;border-bottom:1px solid #9ca3af;width:max-content;min-width:100%;box-sizing:border-box">
                <div><a href="' . $orderLink . '" style="color:#111827;text-decoration:none;font-weight:600" target="_blank">#' . e($order->order_no) . '</a></div>
                <div style="color:#374151">' . ($order->ex_factory_date ? e($order->ex_factory_date) : '-') . '</div>
                <div style="color:#374151">$' . number_format($order->order_total, 2) . '</div>
                <div style="font-weight:700;color:#16a34a">$' . number_format($amount, 2) . '</div>
                <div style="font-weight:700;color:#16a34a">$' . number_format($summaryAtPayment->balancePayment, 2) . '</div>
                <div style="text-align:center"><a href="' . $paymentUrl . '" target="_blank" style="color:#111827;text-decoration:none" title="Go to payment"><i class="fas fa-external-link-alt"></i></a></div>
                <!--ACTION-CELL-check-' . $checkPayment->id . '-START--><div style="display:flex;gap:6px;align-items:center;justify-content:center">
                    <button class="reject-btn" data-payment-id="' . $checkPayment->id . '" onclick="isBulkPaymentMode=true;currentPaymentId=this.dataset.paymentId;openNcmPaymentRejectDialog()" style="background:#dc2626;border:none;border-radius:6px;color:#fff;font-size:10px;font-weight:700;letter-spacing:.3px;padding:6px 12px;cursor:pointer">REJECT</button>
                    <button class="conform-btn" data-payment-id="' . $checkPayment->id . '" onclick="isBulkPaymentMode=true;currentPaymentId=this.dataset.paymentId;openNcmPaymentApproveDialog()" style="background:#0d9488;border:none;border-radius:6px;color:#fff;font-size:10px;font-weight:700;letter-spacing:.3px;padding:6px 12px;cursor:pointer;display:flex;align-items:center;gap:5px">
                        <i class="far fa-check-square" style="font-size:9px"></i> APPROVE
                    </button>
                </div><!--ACTION-CELL-check-' . $checkPayment->id . '-END-->
            </div>';

            $orderIdPills .= '<span style="display:inline-block;background:#f9fafb;border:1px solid #e5e7eb;border-radius:6px;padding:6px 12px;margin:0 6px 8px 0;      font-size:13px;font-weight:700;color:#111827;">'
            . '<a href="' . e($orderLink) . '" target="_blank" style="color:#111827;text-decoration:none;">#' . e($order->order_no) . ' &#8599;</a>'
            . '</span>';

            $totalAmountPaid += $amount;


            $encryptedId = Crypt::encrypt($checkPayment->id);
            // $this->sendPaymentMail($Order->id, $Order->order_no, $encryptedId, $amount, $users);
        }

        $checkImagesHtml = '<div style="margin-bottom:20px;flex:0 0 auto">
            <div style="font-size:10px;font-weight:700;letter-spacing:.7px;text-transform:uppercase;color:#9ca3af;margin-bottom:10px">
                CHECK IMAGES
            </div>
            <div style="display:flex;gap:16px;align-items:flex-start">
                <span style="flex:0 0 140px;text-align:center">
                    <img src="' . e(asset($checkFront)) . '" alt="Check Front" style="width:120px;height:auto;border:1px solid #e5e7eb;border-radius:4px;cursor:zoom-in;display:block;margin:0 auto 6px"
                        onclick="(function(src){var o=document.getElementById(\'ncmInlineZoomOverlay\');if(!o){o=document.createElement(\'div\');o.id=\'ncmInlineZoomOverlay\';o.style.cssText=\'display:none;position:fixed;inset:0;background:rgba(0,0,0,0.85);z-index:99999;align-items:center;justify-content:center;cursor:zoom-out;\';var im=document.createElement(\'img\');im.style.cssText=\'max-width:90vw;max-height:88vh;border-radius:6px;box-shadow:0 20px 60px rgba(0,0,0,.5);\';o.appendChild(im);o.addEventListener(\'click\',function(){o.style.display=\'none\';});document.body.appendChild(o);}o.querySelector(\'img\').src=src;o.style.display=\'flex\';})(this.src)">
                    <span style="font-size:11px;font-weight:600;color:#6b7280">Front</span>
                </span>
                <span style="flex:0 0 140px;text-align:center">
                    <img src="' . e(asset($checkBack)) . '" alt="Check Back" style="width:120px;height:auto;border:1px solid #e5e7eb;border-radius:4px;cursor:zoom-in;display:block;margin:0 auto 6px"
                        onclick="(function(src){var o=document.getElementById(\'ncmInlineZoomOverlay\');if(!o){o=document.createElement(\'div\');o.id=\'ncmInlineZoomOverlay\';o.style.cssText=\'display:none;position:fixed;inset:0;background:rgba(0,0,0,0.85);z-index:99999;align-items:center;justify-content:center;cursor:zoom-out;\';var im=document.createElement(\'img\');im.style.cssText=\'max-width:90vw;max-height:88vh;border-radius:6px;box-shadow:0 20px 60px rgba(0,0,0,.5);\';o.appendChild(im);o.addEventListener(\'click\',function(){o.style.display=\'none\';});document.body.appendChild(o);}o.querySelector(\'img\').src=src;o.style.display=\'flex\';})(this.src)">
                    <span style="font-size:11px;font-weight:600;color:#6b7280">Back</span>
                </span>
            </div>
        </div>';

        $builder = new NotificationBuilderService();

        $builder->sendNotification(
            'key_payment_check',
            [
                '{order_no}'       => $Order->order_no,
                '{check_id}'  =>   '-',
                '{total_paid}'      => $totalAmountPaid,
                '{organization_name}' => $orgName,
                '{organization_url}' => $orgURL,
                '{date_time}'       => now()->format('m/d/Y') . ' • ' . now()->format('H:i:s'),
                '{total_amount}'    => '$' . number_format($totalAmountPaid, 2),
                '{checkImagesHtml}' => $checkImagesHtml,
                '{rowsHtml}'      => $rowsHtml,
            ],
            [
                'is_payment'                 => 1,
                'target_notification_field'  => 'key_payment_check',
                'new_notification'           => 1,
                'order_ids'                  => $allOrderIds,
            ]
        );

        $this->sendBulkCheckPaymentMail($allOrderIds, $orderIdPills, $checkFront, $checkBack, $totalAmountPaid);
        $this->sendBulkCheckPaymentMailCustomer($allOrderIds, $currentPayments, $checkFront, $checkBack, $totalAmountPaid);

        return $currentPayments;

    }
    public function uploadCheckFront(Request $request) {
        $file = $request->file('check_front');

        $destinationPath = 'uploads/check';
        $fileName = Carbon::now()->format('YmdHsi').'_'.$request->order_id.'_check_front.'.$file->getClientOriginalExtension();
        $file->move($destinationPath, $fileName);

        return $destinationPath.'/'.$fileName;
    }

    public function uploadCheckBack(Request $request) {
        $file = $request->file('check_back');

        $destinationPath = 'uploads/check';
        $fileName = Carbon::now()->format('YmdHsi').'_'.$request->order_id.'_check_back.'.$file->getClientOriginalExtension();

        $file->move($destinationPath, $fileName);

        return $destinationPath.'/'.$fileName;
    }
    public function uploadPaypalReceipt(Request $request) {
        $file = $request->file('paypal_receipt');

        $destinationPath = 'uploads/paypal';

        $file->move($destinationPath, $file->getClientOriginalName());

        return $destinationPath.'/'.$file->getClientOriginalName();
    }
    public function uploadVenmoReceipt(Request $request) {
        $file = $request->file('venmo_receipt');

        $destinationPath = 'uploads/venmo';

        $fileName = Carbon::now()->format('YmdHsi').'_'.$request->order_id.'_venmo_receipt.'.$file->getClientOriginalExtension();
        $file->move($destinationPath, $fileName);

        return $destinationPath.'/'.$fileName;
    }
    public function sendPaymentMail($orderId, $users){
        config(['mail.host' => $this->smptHost]);
        config(['mail.port' => $this->smptPort]);
        config(['mail.encryption' => $this->smptEncryption]);

        config(['mail.username' => $this->username]); //logged user email
        config(['mail.password' => $this->password]); //logged user email pass

        $fromSettings = [
        'address' => $this->username,
        'name' => 'Encore Custom',
        ];
        config(['mail.from' => $fromSettings]);

        $mailToArr = array();
        foreach($users as $user) {
            array_push($mailToArr, $user->email);
        }

        $order = Order::with('organizationDetails')->find($orderId);
        // dd($order->organizationDetails['organization_name']);
        $oraganizationalName = $order->organizationDetails['organization_name'];

        $data["title"] = "Paypal payment received for order #".$orderId;
        $data["orderId"] = $orderId;
        $data["paidDate"] = date("Y-m-d H:i:s");
        $data["organizationname"] = $oraganizationalName;
        $data["type"] = 'paypal';

        // Mail::send('pages.order_management.payment.payment-notify-template-paypal', $data, function ($message) use ($data, $mailToArr) {

        // foreach ($mailToArr as $mails) {
        //     $message->to($mails);
        // }

        // $message->subject($data["title"]);

        // });
        email_Notify()->sendEmailFromTemplate('key_email_payment_paypal', [

            'orderId' => $orderId,
            // 'orderNo' => implode(' , ', $orderIds),
            'paidDate' => date("Y-m-d H:i:s"),
            'organizationname' => $oraganizationalName,
            'type' => 'paypal',
        ]);
        return "ok";
    }
    public function downloadBulkInvoicePdf(array $orderIds, array $currentPayments)
    {
        $orders = Order::with([
            'organizationDetails',
            'contactDetails',
            'userDetails',
            'statusDetails',
            'orderItems.productDetails',
            'orderItems.statusDetails'
        ])->whereIn('id', $orderIds)->get()
        ->transform(function ($order) {
                $order->payment_status = app(\App\Services\PaymentService::class)->getPaymentStatus($order->id);
                return $order;
            });

        $pdf = pdf::loadView('pages.customer_portal.payments.bulk_invoice', [
            'orders'   => $orders,
            'payments' => $currentPayments,
        ])->setPaper('a4', 'portrait');

        // return $pdf->download(
        //     'Bulk_Invoice_' . now()->format('Ymd_His') . '.pdf'
        // );
        // Store PDF temporarily
        // Encode PDF as base64 for inline download
    $pdfBase64 = base64_encode($pdf->output());

    // Redirect URL after download
    $redirectUrl = route('customer_portal.payments');

    return view('pages.customer_portal.bulk_payment_redirect', compact('pdfBase64', 'redirectUrl'));

    }

    public function sendBulkCardPaymentMail($allOrderIds, $orderIdPills, $transactionId, $paymentMadeBy, $totalAmountPaid, $paymentUrl)
    {
        $order = Order::with(['organizationDetails', 'contactDetails'])->find($allOrderIds[0] ?? null);

        if (!$order) {
            return false;
        }

        $organizationName = optional($order->organizationDetails)->organization_name ?? '';
        $customerDetails = trim(optional($order->contactDetails)->first_name . ' ' . optional($order->contactDetails)->last_name);

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_bulk_card_payment', [
            'orderId'            => $allOrderIds[0],
            'order_id_pills'     => $orderIdPills,
            'organization_name'  => $organizationName,
            'customer_details'   => $customerDetails,
            'transaction_id'     => $transactionId ?? '-',
            'payment_made_by'    => $paymentMadeBy,
            'paid_date'          => now()->format('m/d/Y'),
            'paid_time'          => now()->format('H:i:s'),
            'paid_amount'        => number_format((float) $totalAmountPaid, 2)
        ]);

        return true;
    }

    public function sendBulkCheckPaymentMail($allOrderIds, $orderIdPills, $checkFront, $checkBack, $totalAmountPaid)
    {
        $order = Order::with(['organizationDetails', 'contactDetails'])->find($allOrderIds[0] ?? null);

        if (!$order) {
            return false;
        }

        $organizationName = optional($order->organizationDetails)->organization_name ?? '';
        $customerDetails = trim(optional($order->contactDetails)->first_name . ' ' . optional($order->contactDetails)->last_name);

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_bulk_check_payment', [
            'orderId'            => $allOrderIds[0],
            'order_id_pills'     => $orderIdPills,
            'organization_name'  => $organizationName,
            'customer_details'   => $customerDetails,
            'check_front'        => asset($checkFront),
            'check_back'         => asset($checkBack),
            'paid_date'          => now()->format('m/d/Y'),
            'paid_time'          => now()->format('H:i:s'),
            'paid_amount'        => number_format((float) $totalAmountPaid, 2),
        ]);

        return true;
    }


    public function sendBulkVenmoPaymentMail($allOrderIds, $orderIdPills, $venmoReceipt, $totalAmountPaid)
    {
        $order = Order::with(['organizationDetails', 'contactDetails'])->find($allOrderIds[0] ?? null);

        if (!$order) {
            return false;
        }

        $organizationName = optional($order->organizationDetails)->organization_name ?? '';
        $customerDetails = trim(optional($order->contactDetails)->first_name . ' ' . optional($order->contactDetails)->last_name);

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_bulk_venmo_payment', [
            'orderId'            => $allOrderIds[0],
            'order_id_pills'     => $orderIdPills,
            'organization_name'  => $organizationName,
            'customer_details'   => $customerDetails,
            'venmo_receipt'      => asset($venmoReceipt),
            'paid_date'          => now()->format('m/d/Y'),
            'paid_time'          => now()->format('H:i:s'),
            'paid_amount'        => number_format((float) $totalAmountPaid, 2),
        ]);

        return true;
    }

    public function sendBulkPaypalPaymentMail($allOrderIds, $orderIdPills, $paypalReceipt, $totalAmountPaid)
    {
        $order = Order::with(['organizationDetails', 'contactDetails'])->find($allOrderIds[0] ?? null);

        if (!$order) {
            return false;
        }

        $organizationName = optional($order->organizationDetails)->organization_name ?? '';
        $customerDetails = trim(optional($order->contactDetails)->first_name . ' ' . optional($order->contactDetails)->last_name);

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_bulk_paypal_payment', [
            'orderId'            => $allOrderIds[0],
            'order_id_pills'     => $orderIdPills,
            'organization_name'  => $organizationName,
            'customer_details'   => $customerDetails,
            'paypal_receipt'     => asset($paypalReceipt),
            'paid_date'          => now()->format('m/d/Y'),
            'paid_time'          => now()->format('H:i:s'),
            'paid_amount'        => number_format((float) $totalAmountPaid, 2),
        ]);

        return true;
    }

    public function sendBulkCardPaymentMailCustomer($allOrderIds, $currentPayments, $transactionId, $paymentMadeBy, $totalAmountPaid, $mail, $billinginfo = [])
    {
        try {
            if (empty($allOrderIds) || empty($mail)) {
                return false;
            }

            $orders = Order::with('organizationDetails')->whereIn('id', $allOrderIds)->get()->keyBy('id');
            $firstOrder = $orders->first();
            $organizationName = optional(optional($firstOrder)->organizationDetails)->organization_name ?? '';

            // Card details for this bulk transaction (same charge covers every order in $allOrderIds)
            $paymentCard = PaymentLog::where('transaction_id', $transactionId)
                ->where('response_code', '1')
                ->latest('created_at')
                ->first();

            $orderRows        = [];
            $orderTotalSum     = 0;
            $processingFeeSum  = 0;
            $balanceSum        = 0;

            foreach ($currentPayments as $payment) {
                $orderModel = $orders->get($payment['order_id']);
                if (!$orderModel) {
                    continue;
                }

                $paymentStatus = $this->PaymentService->getPaymentStatus($payment['order_id']);
                $balance = (float) str_replace(',', '', $paymentStatus['balance_to_be_paid'] ?? 0);

                // finalAmount was base + 3% fee, so back out the fee for display
                $finalAmount = (float) $payment['amount'];
                $baseAmount  = round($finalAmount / 1.03, 2);
                $feeAmount   = round($finalAmount - $baseAmount, 2);

                $orderTotalSum    += (float) $orderModel->order_total;
                $processingFeeSum += $feeAmount;
                $balanceSum       += $balance;

                $orderRows[] = [
                    'order_no'    => $payment['order_no'] ?? $orderModel->order_no,
                    'order_link'  => url("customer_portal/order_view/{$orderModel->id}") . '?active_tab=order',
                    'order_total' => number_format((float) $orderModel->order_total, 2),
                    'paid_amount' => number_format($finalAmount, 2),
                    'balance'     => number_format($balance, 2),
                ];
            }

            $paymentMethodLabel = 'Card';
            if ($paymentCard && !empty($paymentCard->card_last_digits)) {
                $paymentMethodLabel .= ' ending in ' . $paymentCard->card_last_digits;
            }

            $paymentStatusLabel = $balanceSum > 0 ? 'Partial' : 'Paid';
            $statusColor        = $balanceSum > 0 ? '#FFB916' : '#2dce89';

            app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_customer_bulk_payment_receipt_card', [
                'custom_email'       => $mail,
                'organization_name'  => $organizationName,
                'order_rows'         => $orderRows,
                'order_count'        => count($orderRows),
                'billing_first_name' => $billinginfo['first_name'] ?? $paymentMadeBy ?? '',
                'billing_last_name'  => $billinginfo['last_name'] ?? '',
                'billing_email'      => $billinginfo['email'] ?? '',
                'billing_phone'      => $billinginfo['phone'] ?? '',
                'billing_street'     => $billinginfo['street'] ?? '',
                'billing_city'       => $billinginfo['city'] ?? '',
                'billing_state'      => $billinginfo['state'] ?? '',
                'billing_postal'     => $billinginfo['zip_code'] ?? '',
                'billing_country'    => $billinginfo['country'] ?? '',
                'paymentCard'        => $paymentCard,
                'transaction_id'     => $transactionId ?? '',
                'payment_method'     => $paymentMethodLabel,
                'order_total'        => number_format($orderTotalSum, 2),
                'processing_fee'     => number_format($processingFeeSum, 2),
                'paid_amount'        => number_format((float) $totalAmountPaid, 2),
                'total_paid'         => number_format((float) $totalAmountPaid, 2),
                'balance_remaining'  => number_format($balanceSum, 2),
                'payment_status'     => $paymentStatusLabel,
                'status_color'       => $statusColor,
                'paid_date'          => now()->format('m-d-Y'),
            ]);

            return true;
        } catch (\Throwable $e) {
            logger()->error('sendBulkCardPaymentMailCustomer failed: ' . $e->getMessage());
            return false;
        }
    }

    public function sendBulkCheckPaymentMailCustomer($allOrderIds, $currentPayments, $checkFront, $checkBack, $totalAmountPaid)
    {
        try {
            if (empty($allOrderIds)) {
                return false;
            }

            $orders = Order::with(['organizationDetails', 'contactDetails'])->whereIn('id', $allOrderIds)->get()->keyBy('id');
            $firstOrder = $orders->first();
            if (!$firstOrder) {
                return false;
            }

            $mail = $firstOrder->email ?? optional($firstOrder->contactDetails)->email;
            if (!$mail) {
                logger()->error('sendBulkCheckPaymentMailCustomer: no customer email found', ['orders' => $allOrderIds]);
                return false;
            }

            $organizationName = optional($firstOrder->organizationDetails)->organization_name ?? '';
            $customerName = trim(optional($firstOrder->contactDetails)->first_name . ' ' . optional($firstOrder->contactDetails)->last_name);

            $orderRows     = [];
            $orderTotalSum = 0;
            $balanceSum    = 0;

            foreach ($currentPayments as $payment) {
                $orderModel = $orders->get($payment['order_id']);
                if (!$orderModel) {
                    continue;
                }

                $paymentStatus = $this->PaymentService->getPaymentStatus($payment['order_id']);
                $balance = (float) str_replace(',', '', $paymentStatus['balance_to_be_paid'] ?? 0);

                $orderTotalSum += (float) $orderModel->order_total;
                $balanceSum    += $balance;

                $orderRows[] = [
                    'order_no'    => $payment['order_no'] ?? $orderModel->order_no,
                    'order_link'  => url("customer_portal/order_view/{$orderModel->id}") . '?active_tab=order',
                    'order_total' => number_format((float) $orderModel->order_total, 2),
                    'paid_amount' => number_format((float) $payment['amount'], 2),
                    'balance'     => number_format($balance, 2),
                ];
            }

            app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_customer_bulk_payment_receipt_check', [
                'custom_email'      => $mail,
                'organization_name' => $organizationName,
                'customer_name'     => $customerName,
                'customer_email'    => $mail,
                'customer_phone'    => $firstOrder->phone_no ?? '',
                'customer_street'   => $firstOrder->street ?? '',
                'customer_city'     => $firstOrder->city ?? '',
                'customer_state'    => $firstOrder->state ?? '',
                'customer_postal'   => $firstOrder->postal_code ?? '',
                'customer_country'  => $firstOrder->country ?? '',
                'order_rows'        => $orderRows,
                'order_count'       => count($orderRows),
                'check_front_url'   => url($checkFront),
                'check_back_url'    => url($checkBack),
                'order_total'       => number_format($orderTotalSum, 2),
                'paid_amount'       => number_format((float) $totalAmountPaid, 2),
                'balance_remaining' => number_format($balanceSum, 2),
                'paid_date'         => now()->format('m-d-Y'),
            ]);

            return true;
        } catch (\Throwable $e) {
            logger()->error('sendBulkCheckPaymentMailCustomer failed: ' . $e->getMessage());
            return false;
        }
    }


    public function sendBulkVenmoPaymentMailCustomer($allOrderIds, $currentPayments, $venmoReceipt, $totalAmountPaid)
    {
        try {
            if (empty($allOrderIds)) {
                return false;
            }

            $orders = Order::with(['organizationDetails', 'contactDetails'])->whereIn('id', $allOrderIds)->get()->keyBy('id');
            $firstOrder = $orders->first();
            if (!$firstOrder) {
                return false;
            }

            $mail = $firstOrder->email ?? optional($firstOrder->contactDetails)->email;
            if (!$mail) {
                logger()->error('sendBulkVenmoPaymentMailCustomer: no customer email found', ['orders' => $allOrderIds]);
                return false;
            }

            $organizationName = optional($firstOrder->organizationDetails)->organization_name ?? '';
            $customerName = trim(optional($firstOrder->contactDetails)->first_name . ' ' . optional($firstOrder->contactDetails)->last_name);

            $orderRows     = [];
            $orderTotalSum = 0;
            $balanceSum    = 0;

            foreach ($currentPayments as $payment) {
                $orderModel = $orders->get($payment['order_id']);
                if (!$orderModel) {
                    continue;
                }

                $paymentStatus = $this->PaymentService->getPaymentStatus($payment['order_id']);
                $balance = (float) str_replace(',', '', $paymentStatus['balance_to_be_paid'] ?? 0);

                $orderTotalSum += (float) $orderModel->order_total;
                $balanceSum    += $balance;

                $orderRows[] = [
                    'order_no'    => $payment['order_no'] ?? $orderModel->order_no,
                    'order_link'  => url("customer_portal/order_view/{$orderModel->id}") . '?active_tab=order',
                    'order_total' => number_format((float) $orderModel->order_total, 2),
                    'paid_amount' => number_format((float) $payment['amount'], 2),
                    'balance'     => number_format($balance, 2),
                ];
            }

            // NOTE: intentionally not passing reject_reason anywhere in this email.
            app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_customer_bulk_payment_receipt_venmo', [
                'custom_email'      => $mail,
                'organization_name' => $organizationName,
                'customer_name'     => $customerName,
                'customer_email'    => $mail,
                'customer_phone'    => $firstOrder->phone_no ?? '',
                'customer_street'   => $firstOrder->street ?? '',
                'customer_city'     => $firstOrder->city ?? '',
                'customer_state'    => $firstOrder->state ?? '',
                'customer_postal'   => $firstOrder->postal_code ?? '',
                'customer_country'  => $firstOrder->country ?? '',
                'order_rows'        => $orderRows,
                'order_count'       => count($orderRows),
                'venmo_receipt_url' => url($venmoReceipt),
                'order_total'       => number_format($orderTotalSum, 2),
                'paid_amount'       => number_format((float) $totalAmountPaid, 2),
                'balance_remaining' => number_format($balanceSum, 2),
                'paid_date'         => now()->format('m-d-Y'),
            ]);

            return true;
        } catch (\Throwable $e) {
            logger()->error('sendBulkVenmoPaymentMailCustomer failed: ' . $e->getMessage());
            return false;
        }
    }


    public function sendBulkPaypalPaymentMailCustomer($allOrderIds, $currentPayments, $paypalReceipt, $totalAmountPaid)
    {
        try {
            if (empty($allOrderIds)) {
                return false;
            }

            $orders = Order::with(['organizationDetails', 'contactDetails'])->whereIn('id', $allOrderIds)->get()->keyBy('id');
            $firstOrder = $orders->first();
            if (!$firstOrder) {
                return false;
            }

            $mail = $firstOrder->email ?? optional($firstOrder->contactDetails)->email;
            if (!$mail) {
                logger()->error('sendBulkPaypalPaymentMailCustomer: no customer email found', ['orders' => $allOrderIds]);
                return false;
            }

            $organizationName = optional($firstOrder->organizationDetails)->organization_name ?? '';
            $customerName = trim(optional($firstOrder->contactDetails)->first_name . ' ' . optional($firstOrder->contactDetails)->last_name);

            $orderRows        = [];
            $orderTotalSum     = 0;
            $processingFeeSum  = 0;
            $balanceSum        = 0;

            foreach ($currentPayments as $payment) {
                $orderModel = $orders->get($payment['order_id']);
                if (!$orderModel) {
                    continue;
                }

                $paymentStatus = $this->PaymentService->getPaymentStatus($payment['order_id']);
                $balance = (float) str_replace(',', '', $paymentStatus['balance_to_be_paid'] ?? 0);

                // finalAmount was base + 3% fee, so back out the fee for display
                $finalAmount = (float) $payment['amount'];
                $baseAmount  = round($finalAmount / 1.03, 2);
                $feeAmount   = round($finalAmount - $baseAmount, 2);

                $orderTotalSum    += (float) $orderModel->order_total;
                $processingFeeSum += $feeAmount;
                $balanceSum       += $balance;

                $orderRows[] = [
                    'order_no'    => $payment['order_no'] ?? $orderModel->order_no,
                    'order_link'  => url("customer_portal/order_view/{$orderModel->id}") . '?active_tab=order',
                    'order_total' => number_format((float) $orderModel->order_total, 2),
                    'paid_amount' => number_format($finalAmount, 2),
                    'balance'     => number_format($balance, 2),
                ];
            }

            app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_customer_bulk_payment_receipt_paypal', [
                'custom_email'       => $mail,
                'organization_name'  => $organizationName,
                'customer_name'      => $customerName,
                'customer_email'     => $mail,
                'customer_phone'     => $firstOrder->phone_no ?? '',
                'customer_street'    => $firstOrder->street ?? '',
                'customer_city'      => $firstOrder->city ?? '',
                'customer_state'     => $firstOrder->state ?? '',
                'customer_postal'    => $firstOrder->postal_code ?? '',
                'customer_country'   => $firstOrder->country ?? '',
                'order_rows'         => $orderRows,
                'order_count'        => count($orderRows),
                'paypal_receipt_url' => asset($paypalReceipt),
                'order_total'        => number_format($orderTotalSum, 2),
                'processing_fee'     => number_format($processingFeeSum, 2),
                'paid_amount'        => number_format((float) $totalAmountPaid, 2),
                'balance_remaining'  => number_format($balanceSum, 2),
                'paid_date'          => now()->format('m-d-Y'),
            ]);

            return true;
        } catch (\Throwable $e) {
            logger()->error('sendBulkPaypalPaymentMailCustomer failed: ' . $e->getMessage());
            return false;
        }
    }

}
