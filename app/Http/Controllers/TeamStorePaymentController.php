<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Crypt;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Carbon\Carbon;
use App\Models\StoreOrder;
use App\Models\StoreCardPayment;
use App\Models\Store;
use App\Models\StoreCustomer;
use App\Models\Organization;
use Illuminate\Support\Facades\Mail;
use App\Models\StoreOrderReceipt;
use App\Models\StoreCoupon;
use App\Models\StoreOrderItem;
use App\Models\StoreOrderPlayerDetail;
use App\Models\StoreProduct;
use App\Services\EmailNotificationBuilderService;
use Illuminate\Support\Facades\Log;

class TeamStorePaymentController extends Controller
{
    private $smptEncryption = 'SSL';
    private $smptPort = '465';
    private $smptHost = 'mail.encr.co';
    private $mailUsername = 'info@encr.co';
    private $mailPassword = 'Encr.co@ec123';

    public function CustomerOnlinePayment($payment_details)
    {
        // Fetch store order with related details
        $store_order = StoreOrder::where('id', $payment_details['store_order_id'])
            ->with('playerDetails', 'CustomerDetails')
            ->first();

        if (!$store_order || !$store_order->CustomerDetails) {
            return response()->json([
                'message' => 'Order or Customer details not found.',
                'status' => 'error',
            ]);
        }

        $store = Store::find($store_order->store_id);

        if (!$store) {
            return response()->json([
                'message' => 'Store not found.',
                'status' => 'error',
            ]);
        }

        $organization = Organization::find($store->organization_id);
        $customer = $store_order->CustomerDetails;

        $store_payment = new StoreCardPayment();

        /*
        |--------------------------------------------------------------------------
        | Zero-payment order
        |--------------------------------------------------------------------------
        */
        if (
            (float) $payment_details['total_amount'] == 0
            && !empty($payment_details['is_zero_payment'])
        ) {
            $store_payment->store_id = $store_order->store_id;
            $store_payment->store_order_no = $store_order->order_no;
            $store_payment->card_owner = $customer->first_name . ' ' . $customer->last_name;
            $store_payment->payment_amount = 0;
            $store_payment->processing_fee = 0;
            $store_payment->total_amount = 0;
            $store_payment->is_success = 1;
            $store_payment->transaction_id = 'ZERO_' . $store_order->order_no;
            $store_payment->save();

            StoreOrder::where('id', $store_order->id)->update([
                'paid_invoice_amount' => 0,
                'paid_processing_fee' => 0,
                'paid_amount' => 0,
                'is_payment_success' => 1,
                'active' => 1,
            ]);

            return response()->json([
                'message' => 'Order updated successfully with zero payment.',
                'status' => 'success',
                'payment_status' => 'approved',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Authorize.Net merchant authentication
        |--------------------------------------------------------------------------
        */
        $gateway = getPaymentGatewayConfig();

        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName($gateway['login_id']);
        $merchantAuthentication->setTransactionKey($gateway['transaction_key']);

        /*
        |--------------------------------------------------------------------------
        | Build card payment
        |--------------------------------------------------------------------------
        */
        $refId = 'order_' . $store_order->id . '_' . time();

        $cardNumber = preg_replace(
            '/\s+/',
            '',
            (string) $payment_details['card_number']
        );

        $expirationMonth = str_pad(
            (string) $payment_details['expiration']['month'],
            2,
            '0',
            STR_PAD_LEFT
        );

        $expirationYear = (string) $payment_details['expiration']['year'];

        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate($expirationYear . '-' . $expirationMonth);
        $creditCard->setCardCode($payment_details['cvv']);

        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        /*
        |--------------------------------------------------------------------------
        | Order information
        |--------------------------------------------------------------------------
        */
        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber($store_order->order_no);
        $order->setDescription(
            $organization
                ? $organization->organization_name . ' Store Order Payment'
                : 'Store Order Payment'
        );

        /*
        |--------------------------------------------------------------------------
        | Normalize country
        |--------------------------------------------------------------------------
        */
        $normalizeCountry = function ($country) {
            $country = trim((string) $country);
            $upper = strtoupper($country);

            if (
                in_array(
                    $upper,
                    ['US', 'USA', 'UNITED STATES', 'UNITED STATES OF AMERICA'],
                    true
                )
            ) {
                return 'US';
            }

            return $country;
        };

        /*
        |--------------------------------------------------------------------------
        | Billing address
        |--------------------------------------------------------------------------
        |
        | AVS checks this address. This keeps your existing customer billing
        | source while normalizing common US country values.
        |
        */
        $customerAddress = new AnetAPI\CustomerAddressType();
        $customerAddress->setFirstName(trim((string) $customer->first_name));
        $customerAddress->setLastName(trim((string) $customer->last_name));
        $customerAddress->setAddress(trim((string) $customer->street));
        $customerAddress->setCity(trim((string) $customer->city));
        $customerAddress->setState(trim((string) $customer->state));
        $customerAddress->setZip(trim((string) $customer->postal_code));
        $customerAddress->setCountry($normalizeCountry($customer->country));

        if (!empty($customer->phone_number)) {
            $customerAddress->setPhoneNumber(
                trim((string) $customer->phone_number)
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Shipping address
        |--------------------------------------------------------------------------
        |
        | Use the actual shipping address saved on StoreOrder instead of
        | always duplicating the billing address.
        |
        */
        $customerShipping = new AnetAPI\CustomerAddressType();

        $customerShipping->setFirstName(
            trim((string) ($store_order->first_name ?: $customer->first_name))
        );

        $customerShipping->setLastName(
            trim((string) ($store_order->last_name ?: $customer->last_name))
        );

        $customerShipping->setAddress(
            trim((string) ($store_order->street ?: $customer->street))
        );

        $customerShipping->setCity(
            trim((string) ($store_order->city ?: $customer->city))
        );

        $customerShipping->setState(
            trim((string) ($store_order->state ?: $customer->state))
        );

        $customerShipping->setZip(
            trim((string) ($store_order->postal_code ?: $customer->postal_code))
        );

        $customerShipping->setCountry(
            $normalizeCountry(
                $store_order->country ?: $customer->country
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Customer data
        |--------------------------------------------------------------------------
        */
        $customerData = new AnetAPI\CustomerDataType();
        $customerData->setType('individual');
        $customerData->setId((string) $customer->id);

        if (!empty($customer->email)) {
            $customerData->setEmail(trim((string) $customer->email));
        }

        /*
        |--------------------------------------------------------------------------
        | Transaction request
        |--------------------------------------------------------------------------
        */
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType('authCaptureTransaction');
        $transactionRequestType->setAmount(
            number_format(
                (float) $payment_details['total_amount'],
                2,
                '.',
                ''
            )
        );
        $transactionRequestType->setOrder($order);
        $transactionRequestType->setPayment($paymentOne);
        $transactionRequestType->setBillTo($customerAddress);
        $transactionRequestType->setShipTo($customerShipping);
        $transactionRequestType->setCustomer($customerData);

        /*
        |--------------------------------------------------------------------------
        | Customer IP
        |--------------------------------------------------------------------------
        |
        | Important for Authorize.Net fraud/IP velocity checks.
        | Only send IPv4 here because that is the safest format for this field.
        |
        */
        $customerIp = request()->ip();

        if (
            !empty($customerIp)
            && filter_var(
                $customerIp,
                FILTER_VALIDATE_IP,
                FILTER_FLAG_IPV4
            )
        ) {
            $transactionRequestType->setCustomerIP($customerIp);
        }

        /*
        |--------------------------------------------------------------------------
        | Duplicate transaction protection
        |--------------------------------------------------------------------------
        |
        | Protect the same Authorize.Net request from accidental rapid
        | resubmission for 15 minutes.
        |
        */
        $duplicateWindow = new AnetAPI\SettingType();
        $duplicateWindow->setSettingName('duplicateWindow');
        $duplicateWindow->setSettingValue('900');

        $transactionRequestType->addToTransactionSettings(
            $duplicateWindow
        );

        /*
        |--------------------------------------------------------------------------
        | Assemble API request
        |--------------------------------------------------------------------------
        */
        $requests = new AnetAPI\CreateTransactionRequest();
        $requests->setMerchantAuthentication($merchantAuthentication);
        $requests->setRefId($refId);
        $requests->setTransactionRequest($transactionRequestType);

        /*
        |--------------------------------------------------------------------------
        | Execute Authorize.Net call
        |--------------------------------------------------------------------------
        */
        try {
            $controller = new AnetController\CreateTransactionController(
                $requests
            );

            $response = $controller->executeWithApiResponse(
                $gateway['environment']
            );
        } catch (\Throwable $e) {
            Log::error('Authorize.Net request exception', [
                'order_no' => $store_order->order_no,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Unable to connect to the payment gateway. Please try again.',
                'status' => 'error',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Save local payment record
        |--------------------------------------------------------------------------
        */
        $store_payment->store_id = $store_order->store_id;
        $store_payment->store_order_no = $store_order->order_no;
        $store_payment->card_owner = $payment_details['owner'];
        $store_payment->payment_amount = $payment_details['order_total'];
        $store_payment->processing_fee = $payment_details['card_processing_fee'];
        $store_payment->total_amount = $payment_details['total_amount'];
        $store_payment->is_success = 0;
        $store_payment->save();

        $paymentReceiptData = [
            'order_id' => $store_order->id,
            'store_id' => $store_order->store_id,
            'customer_id' => $customer->id,
            'transaction_record_id' => $store_payment->id,
        ];

        /*
        |--------------------------------------------------------------------------
        | Handle Authorize.Net response
        |--------------------------------------------------------------------------
        |
        | Transaction response codes:
        | 1 = Approved
        | 2 = Declined
        | 3 = Error
        | 4 = Held for Review / Action Required
        |
        */
        if ($response != null) {
            $tresponse = $response->getTransactionResponse();

            /*
            |--------------------------------------------------------------------------
            | Always process transactionResponse before top-level API messages
            |--------------------------------------------------------------------------
            */
            if ($tresponse != null) {
                $responseCode = (string) $tresponse->getResponseCode();
                $transactionId = $tresponse->getTransId();

                $accountNumber = $tresponse->getAccountNumber();

                $cardLast4 = $accountNumber
                    ? substr($accountNumber, -4)
                    : null;

                $avsCode = $tresponse->getAvsResultCode();
                $cvvCode = $tresponse->getCvvResultCode();

                $gatewayMessage = null;
                $gatewayReasonCode = null;

                if (
                    $tresponse->getMessages() != null
                    && isset($tresponse->getMessages()[0])
                ) {
                    $gatewayMessage = $tresponse
                        ->getMessages()[0]
                        ->getDescription();

                    $gatewayReasonCode = $tresponse
                        ->getMessages()[0]
                        ->getCode();
                }

                if (
                    !$gatewayMessage
                    && $tresponse->getErrors() != null
                    && isset($tresponse->getErrors()[0])
                ) {
                    $gatewayMessage = $tresponse
                        ->getErrors()[0]
                        ->getErrorText();

                    $gatewayReasonCode = $tresponse
                        ->getErrors()[0]
                        ->getErrorCode();
                }

                Log::info('Authorize.Net transaction response', [
                    'order_no' => $store_order->order_no,
                    'transaction_id' => $transactionId,
                    'response_code' => $responseCode,
                    'reason_code' => $gatewayReasonCode,
                    'message' => $gatewayMessage,
                    'avs_code' => $avsCode,
                    'cvv_code' => $cvvCode,
                    'card_last4' => $cardLast4,
                    'customer_ip' => $customerIp,
                ]);

                /*
                |--------------------------------------------------------------------------
                | 1 = APPROVED
                |--------------------------------------------------------------------------
                */
                if ($responseCode === '1') {
                    $message_text = (
                        $gatewayMessage ?: 'This transaction has been approved.'
                    ) . ' Order #: ' . $store_order->order_no;

                    $store_payment->transaction_id = $transactionId;
                    $store_payment->is_success = 1;
                    $store_payment->card_last_digits = $cardLast4;
                    $store_payment->save();

                    $baseQuery = StoreCardPayment::where(
                            'store_order_no',
                            $store_order->order_no
                        )
                        ->where('is_success', 1);

                    $paidAmount = (clone $baseQuery)
                        ->where('is_refund', 0)
                        ->sum('payment_amount');

                    $refundAmount = (clone $baseQuery)
                        ->where('is_refund', 1)
                        ->sum('payment_amount');

                    $paidTotal = $paidAmount - $refundAmount;

                    StoreOrder::where(
                        'id',
                        $store_order->id
                    )->update([
                        'paid_invoice_amount' => $paidTotal,
                        'paid_processing_fee' => $payment_details['card_processing_fee'],
                        'paid_amount' => $paidTotal + $payment_details['card_processing_fee'],
                        'is_payment_success' => 1,
                        'active' => 1,
                    ]);

                    $this->emailPaymentReceipt($paymentReceiptData);

                    return response()->json([
                        'message' => $message_text,
                        'status' => 'success',
                        'payment_status' => 'approved',
                        'transaction_id' => $transactionId,
                        'avs_code' => $avsCode,
                        'cvv_code' => $cvvCode,
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | 4 = HELD FOR FRAUD REVIEW
                |--------------------------------------------------------------------------
                |
                | IMPORTANT:
                | Return status=success because storePaymentOnline() is being
                | kept unchanged and it only stops when status=error.
                |
                | The ORDER can continue to be created, but the PAYMENT remains
                | unapproved until Authorize.Net later approves it.
                |
                */
                if ($responseCode === '4') {
                    $store_payment->transaction_id = $transactionId;
                    $store_payment->is_success = 0;
                    $store_payment->card_last_digits = $cardLast4;
                    $store_payment->save();

                    StoreOrder::where(
                        'id',
                        $store_order->id
                    )->update([
                        'is_payment_success' => 0,
                    ]);

                    Log::warning(
                        'Authorize.Net payment held for fraud review',
                        [
                            'order_no' => $store_order->order_no,
                            'transaction_id' => $transactionId,
                            'response_code' => $responseCode,
                            'reason_code' => $gatewayReasonCode,
                            'gateway_message' => $gatewayMessage,
                            'avs_code' => $avsCode,
                            'cvv_code' => $cvvCode,
                            'card_last4' => $cardLast4,
                            'customer_ip' => $customerIp,
                        ]
                    );

                    return response()->json([
                        'message' =>
                            'Order submitted successfully. '
                            . 'Payment is currently under review by the payment gateway. '
                            . 'Please do not submit the payment again. '
                            . 'Order #: '
                            . $store_order->order_no,

                        // Intentionally success so existing storePaymentOnline()
                        // continues creating the order and clears the cart.
                        'status' => 'success',
                        'payment_status' => 'under_review',
                        'transaction_id' => $transactionId,
                        'avs_code' => $avsCode,
                        'cvv_code' => $cvvCode,
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | 2 = DECLINED
                |--------------------------------------------------------------------------
                */
                if ($responseCode === '2') {
                    return response()->json([
                        'message' =>
                            $gatewayMessage ?: 'The card was declined.',
                        'status' => 'error',
                        'payment_status' => 'declined',
                        'transaction_id' => $transactionId,
                        'avs_code' => $avsCode,
                        'cvv_code' => $cvvCode,
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | 3 = TRANSACTION ERROR
                |--------------------------------------------------------------------------
                */
                if ($responseCode === '3') {
                    return response()->json([
                        'message' =>
                            $gatewayMessage ?: 'Payment processing error. Please try again.',
                        'status' => 'error',
                        'payment_status' => 'error',
                        'transaction_id' => $transactionId,
                        'avs_code' => $avsCode,
                        'cvv_code' => $cvvCode,
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Other transaction-level error
                |--------------------------------------------------------------------------
                */
                if (
                    $tresponse->getErrors() != null
                    && isset($tresponse->getErrors()[0])
                ) {
                    return response()->json([
                        'message' => $tresponse
                            ->getErrors()[0]
                            ->getErrorText(),
                        'status' => 'error',
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | API-level error
            |--------------------------------------------------------------------------
            */
            if (
                $response->getMessages() != null
                && $response->getMessages()->getMessage() != null
                && isset($response->getMessages()->getMessage()[0])
            ) {
                $message_text = $response
                    ->getMessages()
                    ->getMessage()[0]
                    ->getText();

                Log::warning('Authorize.Net API error', [
                    'order_no' => $store_order->order_no,
                    'message' => $message_text,
                ]);

                return response()->json([
                    'message' => $message_text,
                    'status' => 'error',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Fallback
            |--------------------------------------------------------------------------
            */
            return response()->json([
                'message' => 'Payment failed. Please try again.',
                'status' => 'error',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | No response
        |--------------------------------------------------------------------------
        */
        Log::error('Authorize.Net returned no response', [
            'order_no' => $store_order->order_no,
        ]);

        return response()->json([
            'message' => 'No response from payment gateway.',
            'status' => 'error',
        ]);
    }

    public function getTransactionDetails($transactionID)
    {
        $transaction_details = StoreCardPayment::where('transaction_id', $transactionID)->first();
        // Set up merchant authentication
        $gateway = getPaymentGatewayConfig();

        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName($gateway['login_id']);
        $merchantAuthentication->setTransactionKey($gateway['transaction_key']);

        /* Sandbox Payment Gateway Credentials (Commented out)
        $merchantAuthentication->setName('8pB92xhZck');
        $merchantAuthentication->setTransactionKey('3473R69RQj3f3UnV');
*/
        /* Live Payment Gateway Credentials (Commented out) */
        // $merchantAuthentication->setName('2gEXK4Vvt54');
        // $merchantAuthentication->setTransactionKey('9X8bxT5z9U45uDCT');

        // Create the request object
        $request = new AnetAPI\GetTransactionDetailsRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setTransId($transactionID); // Set the Transaction ID

        // Create the controller and get the response
        $controller = new AnetController\GetTransactionDetailsController($request);
        $response = $controller->executeWithApiResponse($gateway['environment']); // SANDBOX PRODUCTION

        // Handle response
        if ($response != null && $response->getMessages() && $response->getMessages()->getResultCode() == "Ok") {
            $transaction = $response->getTransaction();

            return response()->json([
                'success' => true,
                'data' => $transaction,
                'transaction_details' => $transaction_details,
            ]);

        } else {
            $errorMessage = $response && $response->getMessages()
                ? $response->getMessages()->getMessage()[0]->getText()
                : 'Failed to retrieve transaction details.';

            return response()->json([
                'error' => true,
                'message' => $errorMessage,
            ]);
        }
    }

    public function refundTransaction(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:store_orders,id',
            'transaction_id' => 'required',
            'amount' => 'required|numeric|min:0.01'
        ]);

        $storeOrder = StoreOrder::with('CustomerDetails')->findOrFail($request->order_id);
        $customer = $storeOrder->CustomerDetails;

        if (!$customer) {
            return response()->json(['message' => 'Customer not found.'], 404);
        }

        $cardPaymentRecord = StoreCardPayment::where('transaction_id', $request->transaction_id)->first();
        if (!$cardPaymentRecord) {
            return response()->json(['message' => 'Transaction not found.'], 404);
        }

        $gateway = getPaymentGatewayConfig();

        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName($gateway['login_id']);
        $merchantAuthentication->setTransactionKey($gateway['transaction_key']);

        /* Sandbox Payment Gateway Credentials (Commented out)
        $merchantAuthentication->setName('8pB92xhZck');
        $merchantAuthentication->setTransactionKey('3473R69RQj3f3UnV');
*/
        /* Live Payment Gateway Credentials (Commented out) */
        // $merchantAuthentication->setName('2gEXK4Vvt54');
        // $merchantAuthentication->setTransactionKey('9X8bxT5z9U45uDCT');

        // Step 1: Check transaction status
        $transDetailsRequest = new AnetAPI\GetTransactionDetailsRequest();
        $transDetailsRequest->setMerchantAuthentication($merchantAuthentication);
        $transDetailsRequest->setTransId($request->transaction_id);

        $transDetailsController = new AnetController\GetTransactionDetailsController($transDetailsRequest);
        $transDetailsResponse = $transDetailsController->executeWithApiResponse($gateway['environment']); // SANDBOX PRODUCTION

        if (!$transDetailsResponse || $transDetailsResponse->getMessages()->getResultCode() !== 'Ok') {
            return response()->json(['status' => 'error', 'message' => 'Failed to retrieve transaction status.'], 400);
        }

        // $transactionStatus = $transDetailsResponse->getTransaction()->getTransactionStatus();
        $transaction = $transDetailsResponse->getTransaction();
        $transactionStatus = $transaction->getTransactionStatus();
        $last4 = $transaction->getPayment()->getCreditCard()->getCardNumber();

        $transactionRequest = new AnetAPI\TransactionRequestType();
        $transactionRequest->setRefTransId($request->transaction_id);

        // $transactionRequest = new AnetAPI\TransactionRequestType();

        // Step 2: Decide refund or void
        if ($transactionStatus === 'settledSuccessfully') {

            $creditCard = new AnetAPI\CreditCardType();
            $creditCard->setCardNumber($last4);
            $creditCard->setExpirationDate("XXXX");

            $paymentType = new AnetAPI\PaymentType();
            $paymentType->setCreditCard($creditCard);

            $transactionRequest->setTransactionType("refundTransaction");
            $transactionRequest->setAmount($request->amount);
            $transactionRequest->setPayment($paymentType);

        } else {
            $transactionRequest->setTransactionType("voidTransaction");
        }

        $requestObj = new AnetAPI\CreateTransactionRequest();
        $requestObj->setMerchantAuthentication($merchantAuthentication);
        $requestObj->setRefId('ref' . time());
        $requestObj->setTransactionRequest($transactionRequest);

        $controller = new AnetController\CreateTransactionController($requestObj);
        $response = $controller->executeWithApiResponse($gateway['environment']); // SANDBOX PRODUCTION

        if ($response && $response->getMessages()->getResultCode() === 'Ok') {
            $transactionResponse = $response->getTransactionResponse();
            if ($transactionResponse && $transactionResponse->getResponseCode() === '1') {

                // ==== NEW: voids (and any transaction that reports transId "0") fall back to the original transaction ID ====
                $isVoid = ($transactionStatus !== 'settledSuccessfully');
                $resolvedTransactionId = $transactionResponse->getTransId();

                if ($isVoid || (int) $resolvedTransactionId === 0) {
                    $resolvedTransactionId = $request->transaction_id;
                }
                // ==== END NEW ====

                // Save refund/void record
                $refundRecord = new StoreCardPayment();
                $refundRecord->store_id = $storeOrder->store_id;
                $refundRecord->store_order_no = $storeOrder->order_no;
                $refundRecord->card_owner = $customer->first_name . ' ' . $customer->last_name;
                $refundRecord->card_last_digits = substr($last4, -4);
                $refundRecord->payment_amount = $request->amount;
                $refundRecord->processing_fee = $request->amount * 3 / 100;
                $refundRecord->total_amount = $request->amount * 103/100;
                $refundRecord->transaction_id = $resolvedTransactionId; // ==== CHANGED ====
                $refundRecord->is_refund = 1;
                $refundRecord->is_success = 1;
                $refundRecord->save();

                // Update order payment summary
                $baseQuery = StoreCardPayment::where('store_order_no', $storeOrder->order_no)->where('is_success', 1);
                $paidAmount = (clone $baseQuery)->where('is_refund', 0)->sum('payment_amount');
                $refundAmount = (clone $baseQuery)->where('is_refund', 1)->sum('payment_amount');
                $paidTotal = $paidAmount - $refundAmount;

                StoreOrder::where('id', $storeOrder->id)->update([
                    'paid_invoice_amount' => $paidTotal,
                    'paid_processing_fee' => round($paidTotal * 3/100, 2),
                    'paid_amount' => round($paidTotal * 103 / 100, 2),
                ]);

                $paymentReceiptData = [
                    'order_id' => $storeOrder->id,
                    'store_id' => $storeOrder->store_id,
                    'customer_id' => $customer->id,
                    'transaction_record_id' => $refundRecord->id,
                ];

                $controllerObject = new StoreController();
                $controllerObject->update_store_payment_record($storeOrder->store_id);


                $this->createOrderReceipt($storeOrder->order_no, $refundRecord->id);

                $this->emailRefundReceipt($paymentReceiptData);


                return response()->json([
                    'status' => 'success',
                    'message' => ($transactionStatus === 'settledSuccessfully' ? 'Refund' : 'Void') . ' successful. Transaction ID: ' . $resolvedTransactionId,
                ]);
            }

            // Handle specific error
            $error = 'Unknown transaction error.';
            if ($transactionResponse && $transactionResponse->getErrors()) {
                foreach ($transactionResponse->getErrors() as $e) {
                    $error = $e->getErrorText();
                }
            }

            return response()->json(['status' => 'error', 'message' => $error], 400);
        }

        // General failure
        $message = 'Transaction failed.';
        if ($response && $response->getMessages() && $response->getMessages()->getMessage()) {
            foreach ($response->getMessages()->getMessage() as $msg) {
                $message = $msg->getText();
            }
        }

        return response()->json(['status' => 'error', 'message' => $message], 400);
    }

    public function emailPaymentReceipt($receiptData)
    {
        $storeOrder = StoreOrder::find($receiptData['order_id']);
        $store = Store::with('themeDetails')->find($receiptData['store_id']);
        $customer = StoreCustomer::find($receiptData['customer_id']);

        if (!$storeOrder || !$store || !$customer) {
            return false;
        }

        $receipt = StoreOrderReceipt::where('store_order_no', $storeOrder->order_no)->latest('id')->first();
        $payment = StoreCardPayment::where('store_order_no', $storeOrder->order_no)->latest('id')->first();

        if (!$receipt || !$payment) {
            return false;
        }

        $receipt->order_items = json_decode($receipt->order_items, true);
        $receipt->order_details = json_decode($receipt->order_details, true);
        $receipt->shipping_details = json_decode($receipt->shipping_details, true);
        $receipt->customer_details = $receipt->customer_details ? json_decode($receipt->customer_details, true) : null;



        $removedItemsLog = [];

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_payment_order_receipt', [
            'custom_email' => $customer->email,
            'store' => $store,
            'order_no' => $storeOrder->order_no,
            'receipt' => $receipt,
            'removed_items' => $removedItemsLog,
            'payment' => $payment,
        ]);

        return true;
    }
    public function emailRefundReceipt($receiptData)
    {
        $storeOrder = StoreOrder::find($receiptData['order_id']);
        $store = Store::with('themeDetails')->find($receiptData['store_id']);
        $customer = StoreCustomer::find($receiptData['customer_id']);
        $transactionRecord = StoreCardPayment::find($receiptData['transaction_record_id']);

        if (!$storeOrder || !$store || !$customer || !$transactionRecord) {
            return false;
        }

        $receipt = StoreOrderReceipt::where('store_order_no', $storeOrder->order_no)->latest('id')->first();

        if (!$receipt) {
            return false;
        }

        $receipt->order_items = $receipt->order_items ? json_decode($receipt->order_items, true) : [];
        $receipt->order_details = json_decode($receipt->order_details, true);
        $receipt->shipping_details = json_decode($receipt->shipping_details, true);
        $receipt->customer_details = $receipt->customer_details ? json_decode($receipt->customer_details, true) : null;

        $removedItems = $receipt->order_details['removed_items'] ?? [];
        $orderChangeNotes = $receipt->order_details['order_change_notes'] ?? [];
        $itemChangeLog = $receipt->order_details['item_change_log'] ?? [];

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_refund_receipt', [
            'custom_email' => $customer->email,
            'store' => $store,
            'order_no' => $storeOrder->order_no,
            'receipt' => $receipt,
            'removed_items' => $removedItems,
            'paymentCard' => $transactionRecord,
            'order_change_notes' => $orderChangeNotes,
            'item_change_log' => $itemChangeLog,
        ]);

        return true;
    }
    public function createOrderReceipt($orderId, $refundRecordID){

        $order = StoreOrder::with('OrderItems', 'CustomerDetails', 'paymentDetails', 'shippingMethodDetails')->where('order_no',$orderId)->first();
        $refundRecord = StoreCardPayment::find($refundRecordID);

        $previousReceipt = StoreOrderReceipt::where('store_order_no', $order->order_no)->latest('id')->first();

        $carriedRemovedItems = [];
        $carriedOrderChangeNotes = [];
        $carriedItemChangeLog = [];

        if ($previousReceipt) {
            $prevDetails = json_decode($previousReceipt->order_details, true);
            $carriedRemovedItems = $prevDetails['removed_items'] ?? [];
            $carriedOrderChangeNotes = $prevDetails['order_change_notes'] ?? [];
            $carriedItemChangeLog = $prevDetails['item_change_log'] ?? [];
        }

        $orderData = [];

        if($order->OrderItems->isEmpty()){
            $orderData['order_items'] = [];
        }else{
            foreach ($order->OrderItems as $orderItem) {
                $product = $orderItem->productDetails;

                $qty = $orderItem->qty;
                $price = $product->default_price + $product->priceAdditions->sum('addition_amount');
                $total_price = $qty * $price;

                // ==== NEW: build item_sizes exactly like the edit-order receipt does ====
                $itemSizes = [];
                $itemDetails = StoreOrderPlayerDetail::with('SizeDetails')->where('store_order_item_id', $orderItem->id)->get();
                foreach ($itemDetails as $detail) {
                    $itemSizes[$detail->id]['size'] = $detail->SizeDetails->size_name;
                    $itemSizes[$detail->id]['qty'] = $detail->qty;
                    $itemSizes[$detail->id]['player_name'] = $detail->player_name ?? '';
                    $itemSizes[$detail->id]['player_number'] = $detail->player_number ?? '';
                    $itemSizes[$detail->id]['sub_team'] = $detail->sub_team ?? '';
                }
                // ==== END NEW ====

                $image_url = $product->images->first()
                    ? asset($product->images->first()->url)
                    : asset('public/images/default.png');

                $orderData['order_items'][] = [
                    'qty' => $qty,
                    'product_name' => $product->product_name,
                    'image_url' => $image_url,
                    'price' => $price,
                    'total_price' => $total_price,
                    'item_sizes' => $itemSizes, // ==== NEW ====
                ];
            }
        }


        $orderData['order_details'] = [
                'sub_total' => $order->sub_total,
                'shipping' => $order->shipping,
                'handling_fee' => $order->handling_fee,
                'sales_tax' => $order->sales_tax,
                'total' => $order->total,
                'paid_invoice_amount' => $order->paid_invoice_amount,
                'paid_processing_fee' => $order->paid_processing_fee,
                'paid_amount' => $order->paid_amount,
                'is_shipping_removed' => (bool) $order->is_shipping_removed,
                'removed_items' => $carriedRemovedItems,
                'order_change_notes' => $carriedOrderChangeNotes,
                'item_change_log' => $carriedItemChangeLog,
                'notes' => $order->notes,
                'tracking_no' => $order->tracking_no,
                'tracking_link' => $order->tracking_link,
                'order_discount' => $order->discount,
                'coupon_code' => $order->coupon_code,
                'coupon_details' => $order->coupon_code ? StoreCoupon::where('store_id', $order->store_id)->where('coupon_code', $order->coupon_code)->first() : null,
                'refund_details' => $refundRecord ? [
                    'refund_amount' => $refundRecord->payment_amount,
                    'refund_transaction_id' => $refundRecord->transaction_id,
                    'is_success' => $refundRecord->is_success ? true : false,
                ] : null,
            ];

        $orderData['shipping_details'] = [
                'first_name' => $order->first_name,
                'last_name' => $order->last_name,
                'street' => $order->street,
                'city' => $order->city,
                'state' => $order->state,
                'postal_code' => $order->postal_code,
                'country' => $order->country,
                'phone' => $order->phone,
                'email' => $order->email,
                'shipping_method' => $order->shippingMethodDetails ? $order->shippingMethodDetails->shipping_method_name : 'Direct Ship to Customers',
            ];

        if(!empty($order->CustomerDetails)){

            $orderData['customer_details'] = [
                    'first_name' => $order->CustomerDetails->first_name,
                    'last_name' => $order->CustomerDetails->last_name,
                    'street' => $order->CustomerDetails->street,
                    'city' => $order->CustomerDetails->city,
                    'state' => $order->CustomerDetails->state,
                    'postal_code' => $order->CustomerDetails->postal_code,
                    'country' => $order->CustomerDetails->country,
                    'phone' => $order->CustomerDetails->phone_number,
                    'email' => $order->CustomerDetails->email,
                ];

        }

        $receipt = new StoreOrderReceipt();
        $receipt->store_id = $order->store_id;
        $receipt->store_order_no = $order->order_no;
        $receipt->order_items = isset($orderData['order_items']) ? json_encode($orderData['order_items']) : null;
        $receipt->order_details = json_encode($orderData['order_details']);
        $receipt->shipping_details = json_encode($orderData['shipping_details']);
        $receipt->customer_details = isset($orderData['customer_details']) ? json_encode($orderData['customer_details']) : null;
        $receipt->is_sent = 1;
        $receipt->save();

    }


    public function save_shipping_details_ajax(Request $request)
    {
        $order = StoreOrder::where('order_no',$request->order_no)->first();

        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Order not found.'], 404);
        }

        $orderChangeNotes = [];

        $originalShipping = (float) $order->shipping;
        $originalIsShippingRemoved = (int) $order->is_shipping_removed;

        $order->email= $request->email;
        $order->phone= $request->phone;
        $order->first_name= $request->first_name;
        $order->last_name= $request->last_name;
        $order->street= $request->street;
        $order->city= $request->city;
        $order->state= $request->state;
        $order->postal_code= $request->postal_code;
        $order->country= $request->country;
        $order->tracking_no= $request->tracking_no;
        $order->tracking_link= $request->tracking_link;
        $order->notes= $request->note;
        $order->shipping_method = $request->shipping_method;
        if($request->has('order')){
            $order->sub_total= $request->input('order')['sub_total'];
            $order->shipping= $request->input('order')['shipping'];
            $order->handling_fee= $request->input('order')['handling_fee'];
            $order->sales_tax= $request->input('order')['sales_tax'];
            $order->total= $request->input('order')['grand_total'];
        }
        $order->is_shipping_removed = $request->input('is_shipping_removed');
        $order->save();

        $newIsShippingRemoved = (int) $order->is_shipping_removed;
        $newShipping = (float) $order->shipping;

        if ($originalIsShippingRemoved !== $newIsShippingRemoved) {
            if ($newIsShippingRemoved === 1) {
                $orderChangeNotes[] = 'Shipping fee removed (was $' . number_format($originalShipping, 2) . ').';
            } else {
                $orderChangeNotes[] = 'Shipping fee added ($' . number_format($newShipping, 2) . ').';
            }
        } elseif (round($originalShipping, 2) !== round($newShipping, 2)) {
            $orderChangeNotes[] = 'Shipping fee changed from $' . number_format($originalShipping, 2) . ' to $' . number_format($newShipping, 2) . '.';
        }

        $removedItemsLog = [];
        $itemChangeLog = [];

        if($request->has('deleted_items') && count($request->input('deleted_items')) > 0){

            $recordsForDelete = StoreOrderPlayerDetail::with('SizeDetails')->whereIn('id', $request->deleted_items)->get();
            if ($recordsForDelete->count() > 0) {
                foreach ($recordsForDelete as $record) {

                    $storeOrderItem = StoreOrderItem::with('productDetails.images')->find($record->store_order_item_id);
                    $product = $storeOrderItem ? $storeOrderItem->productDetails : null;
                    $productName = $product->product_name ?? 'Unknown Product';

                    $imageUrl = ($product && $product->images->first())
                        ? asset($product->images->first()->url)
                        : asset('public/images/default.png');

                    $removedItemsLog[] = [
                        'product_name'  => $productName,
                        'image_url'     => $imageUrl,
                        'size'          => optional($record->SizeDetails)->size_name,
                        'qty'           => $record->qty,
                        'player_name'   => $record->player_name,
                        'player_number' => $record->player_number,
                    ];

                    $itemChangeLog[] = [
                        'type' => 'removed',
                        'product_name' => $productName,
                        'qty' => $record->qty,
                    ];

                    $record->delete();
                }
            }
        }

        $changedItemIds = [];

        if ($request->has('players') && count($request->input('players')) > 0) {
            foreach ($request->input('players') as $key => $value) {

                    $player_details = StoreOrderPlayerDetail::find($key);
                    $storeOrderItem = StoreOrderItem::with('productDetails')->where('id', $player_details->store_order_item_id)->first();

                    $tsrOrderItemFound = false;
                    if ($storeOrderItem && !empty($storeOrderItem->system_order_reference)) {
                        $tsrOrderItemFound = true;
                    }

                    if ($player_details) {

                        $oldQty = (int) $player_details->qty;

                        $player_details->size = $value['size'];
                        $player_details->item_status = $value['status'];

                        $player_details->player_name = (isset($value['name']) && $value['name'] !== 'null') ? $value['name'] : NULL;
                        $player_details->player_number = isset($value['number']) ? $value['number'] : NULL;

                        $player_details->sub_team = isset($value['sub_team']) ? $value['sub_team'] : NULL;

                        $player_details->is_name_available = isset($value['name']) ? 1 : 0;
                        $player_details->is_number_available = isset($value['number']) ? 1 : 0;

                        $player_details->qty = $value['qty'];
                        if(isset($value['unit_price'])){
                            $player_details->unit_price = $value['unit_price'];
                        }
                        $player_details->total_amount = $value['total'];
                        $player_details->save();

                        $changes = $player_details->getChanges();
                        unset($changes['updated_at']);

                        if (!empty($changes)) {
                            $changedItemIds[$player_details->store_order_item_id] = true;

                            $newQty = (int) $player_details->qty;
                            if ($oldQty !== $newQty) {
                                $itemChangeLog[] = [
                                    'type' => 'updated',
                                    'product_name' => $storeOrderItem->productDetails->product_name ?? 'Unknown Product',
                                    'old_qty' => $oldQty,
                                    'new_qty' => $newQty,
                                ];
                            }
                        }

                        StoreOrderItem::where('id', $player_details->store_order_item_id)->update([
                            'store_product_id' => $value['product_id'],
                            'is_updated' => $tsrOrderItemFound ? 1 : 0,
                        ]);
                    }
            }

        }

        $addedItemIds = [];

        if ($request->has('new_players') && count($request->input('new_players')) > 0) {
            foreach ($request->input('new_players') as $key => $value) {

                $store_order_item = new StoreOrderItem();
                $store_order_item->store_order_id = $order->id;
                $store_order_item->store_product_id = $value['product_id'];
                $store_order_item->store_id = $order->store_id;
                $store_order_item->qty = $value['qty'];
                $store_order_item->save();

                if ($store_order_item->wasRecentlyCreated) {
                    $addedItemIds[$store_order_item->id] = true;

                    $addedProduct = StoreProduct::find($value['product_id']);
                    $itemChangeLog[] = [
                        'type' => 'added',
                        'product_name' => $addedProduct->product_name ?? 'Unknown Product',
                        'qty' => $value['qty'],
                    ];
                }

                $store_order_item_id = $store_order_item->id;

                $player_details = new StoreOrderPlayerDetail();
                $player_details->store_order_item_id = $store_order_item_id;
                $player_details->store_id = $order->store_id;
                $player_details->store_product_id = $value['product_id'];
                $player_details->is_name_available = isset($value['name']) ? 1 : 0;
                $player_details->is_number_available = isset($value['number']) ? 1 : 0;
                $player_details->size = $value['size'];
                $player_details->item_status = $value['status'];
                if (isset($value['name']) && $value['name'] !== 'null') {
                    $player_details->player_name = $value['name'] ?? NULL;
                }
                if (isset($value['number']) && $value['number'] !== 'null') {
                    $player_details->player_number = $value['number'] ?? NULL;
                }
                if(isset($value['sub_team']) && $value['sub_team'] !== 'null'){
                    $player_details->sub_team = $value['sub_team'] ?? NULL;
                }
                $player_details->qty = $value['qty'];
                $player_details->total_amount = $value['total'];
                $player_details->unit_price = $value['unit_price'];
                $player_details->paid_amount = 0.00;
                $player_details->save();
            }

        }

        $storeOrderItems = StoreOrderItem::where('store_order_id', $order->id)->get();

        foreach ($storeOrderItems as $storeOrderItem) {
            $qty = StoreOrderPlayerDetail::where('store_order_item_id', $storeOrderItem->id)->sum('qty');
            $storeOrderItem->qty = $qty;
            $storeOrderItem->save();

            if($qty == 0){
                $storeOrderItem->delete();
            }
        }

        $storeOrder = StoreOrder::with('OrderItems', 'CustomerDetails', 'paymentDetails')->where('order_no',$request->order_no)->first();

        $orderData = [];

        foreach ($storeOrder->OrderItems as $orderItem) {
            $product = $orderItem->productDetails;

            $qty = $orderItem->qty;
            $price = $product->default_price;
            $total_price = $qty * $price;

            $itemSizes = [];
            $itemDetails = StoreOrderPlayerDetail::with('SizeDetails')->where('store_order_item_id', $orderItem->id)->get();
            foreach ($itemDetails as $detail) {
                $itemSizes[$detail->id]['size'] = $detail->SizeDetails->size_name;
                $itemSizes[$detail->id]['qty'] = $detail->qty;
                $itemSizes[$detail->id]['player_name'] = $detail->player_name ?? '';
                $itemSizes[$detail->id]['player_number'] = $detail->player_number ?? '';
                $itemSizes[$detail->id]['sub_team'] = $detail->sub_team ?? '';
            }

            $image_url = $product->images->first()
                ? asset($product->images->first()->url)
                : asset('public/images/default.png');

            $orderData['order_items'][] = [
                'qty' => $qty,
                'product_name' => $product->product_name,
                'image_url' => $image_url,
                'price' => $price,
                'total_price' => $total_price,
                'item_sizes' => $itemSizes,
            ];
        }

        $pending = $this->getPendingChanges($storeOrder->store_id, $storeOrder->order_no);

        $orderChangeNotes = array_merge($pending['order_change_notes'], $orderChangeNotes);
        $itemChangeLog    = array_merge($pending['item_change_log'], $itemChangeLog);
        $removedItemsLog  = array_merge($pending['removed_items'], $removedItemsLog);

        $orderData['order_details'] = [
                'sub_total' => $order->sub_total,
                'shipping' => $order->shipping,
                'handling_fee' => $order->handling_fee,
                'sales_tax' => $order->sales_tax,
                'total' => $order->total,
                'paid_invoice_amount' => $order->paid_invoice_amount,
                'paid_processing_fee' => $order->paid_processing_fee,
                'paid_amount' => $order->paid_amount,
                'is_shipping_removed' => (bool) $order->is_shipping_removed,
                'removed_items' => $removedItemsLog,
                'order_change_notes' => $orderChangeNotes,
                'item_change_log' => $itemChangeLog,
                'notes' => $order->notes,
                'tracking_no' => $order->tracking_no,
                'tracking_link' => $order->tracking_link,
                'order_discount' => $order->discount,
                'coupon_code' => $order->coupon_code,
                'coupon_details' => $order->coupon_code ? StoreCoupon::where('store_id', $order->store_id)->where('coupon_code', $order->coupon_code)->first() : null,
            ];

        $orderData['shipping_details'] = [
                'first_name' => $order->first_name,
                'last_name' => $order->last_name,
                'street' => $order->street,
                'city' => $order->city,
                'state' => $order->state,
                'postal_code' => $order->postal_code,
                'country' => $order->country,
                'phone' => $order->phone,
                'email' => $order->email,
                'shipping_method' => $order->shippingMethodDetails ? $order->shippingMethodDetails->shipping_method_name : 'Direct Ship to Customers',
            ];

        if(!empty($order->CustomerDetails)){

            $orderData['customer_details'] = [
                    'first_name' => $order->CustomerDetails->first_name,
                    'last_name' => $order->CustomerDetails->last_name,
                    'street' => $order->CustomerDetails->street,
                    'city' => $order->CustomerDetails->city,
                    'state' => $order->CustomerDetails->state,
                    'postal_code' => $order->CustomerDetails->postal_code,
                    'country' => $order->CustomerDetails->country,
                    'phone' => $order->CustomerDetails->phone_number,
                    'email' => $order->CustomerDetails->email,
                ];

        }

        // ==== NEW: ====
        $receipt = new StoreOrderReceipt();
        $receipt->store_id = $storeOrder->store_id;
        $receipt->store_order_no = $storeOrder->order_no;
        $receipt->order_items = isset($orderData['order_items']) ? json_encode($orderData['order_items']) : NULL;
        $receipt->order_details = json_encode($orderData['order_details']);
        $receipt->shipping_details = json_encode($orderData['shipping_details']);
        $receipt->customer_details = isset($orderData['customer_details']) ? json_encode($orderData['customer_details']) : null;
        $receipt->is_sent = 1;
        $receipt->save();
        // ==== END NEW ====

        // ==== NEW: return fresh numbers as JSON instead of redirecting ====
        return response()->json([
            'status' => 'success',
            'order_id' => $order->id,
            'total' => $order->total,
            'paid_invoice_amount' => $order->paid_invoice_amount,
            'overpaid_amount' => max(0, round($order->paid_invoice_amount - $order->total, 2)),
        ]);
        // ==== END NEW ====
    }


    private function getPendingChanges($storeId, $orderNo)
    {
        $empty = [
            'order_change_notes' => [],
            'item_change_log'    => [],
            'removed_items'      => [],
        ];

        $lastReceipt = StoreOrderReceipt::where('store_id', $storeId)
            ->where('store_order_no', $orderNo)
            ->latest('id')
            ->first();

        // No receipt, or the last one was already emailed → nothing pending
        if (!$lastReceipt || (int) $lastReceipt->is_sent === 1) {
            return $empty;
        }

        $details = json_decode($lastReceipt->getRawOriginal('order_details'), true) ?: [];

        return [
            'order_change_notes' => $details['order_change_notes'] ?? [],
            'item_change_log'    => $details['item_change_log'] ?? [],
            'removed_items'      => $details['removed_items'] ?? [],
        ];
    }


}
