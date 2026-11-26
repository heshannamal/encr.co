<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\StoreCoachPayment;
use App\Models\StoreOrder;
use App\Models\StoreTheme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class StoreCoachPaymentController extends Controller
{
    private function coachPaymentSummary($storeId)
    {
        $orders = StoreOrder::with('OrderItems')
            ->where('store_id', $storeId)
            ->where('shipping_method', 2)
            ->where('active', 1)
            ->where('is_payment_success', 1)
            ->get();

        $itemCount = $orders->sum(function ($order) {
            return $order->OrderItems->sum('qty');
        });

        if ($itemCount > 70) {
            $requiredAmount = round(0.50 * $itemCount, 2);
        } elseif ($itemCount > 0) {
            $requiredAmount = 35.00;
        } else {
            $requiredAmount = 0.00;
        }

        $paidAmount = (float) StoreCoachPayment::where('store_id', $storeId)
            ->where('is_success', 1)
            ->sum('payment_amount');

        return [
            'item_count' => (int) $itemCount,
            'required_amount' => (float) $requiredAmount,
            'paid_amount' => (float) $paidAmount,
            'balance' => max(0, round($requiredAmount - $paidAmount, 2)),
        ];
    }

    public function prepare(Request $request, $store)
    {
        if (!$request->user()) {
            abort(403);
        }

        $storeModel = Store::findOrFail((int) $store);

        $data = $request->validate([
            'coach_name' => 'nullable|string|max:190',
            'coach_email' => 'nullable|email|max:190',
        ]);

        $summary = $this->coachPaymentSummary($storeModel->id);

        $unresolvedPayment = StoreCoachPayment::where('store_id', $storeModel->id)
            ->where('is_success', 0)
            ->whereIn('status', ['under_review', 'review_required', 'processing'])
            ->latest('id')
            ->first();

        if ($unresolvedPayment) {
            return response()->json([
                'success' => false,
                'message' => 'A coach payment transaction is still under review. Verify it before creating another payment request.',
            ], 409);
        }

        if ($summary['item_count'] <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'There are no paid coach-shipping orders to collect.',
            ], 422);
        }

        if ($summary['balance'] <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Coach shipping is already fully paid.',
            ], 422);
        }

        $processingFee = round($summary['balance'] * 0.03, 2);
        $totalAmount = round($summary['balance'] + $processingFee, 2);

        StoreCoachPayment::where('store_id', $storeModel->id)
            ->where('is_success', 0)
            ->where('status', 'pending')
            ->where(function ($query) use ($summary) {
                $query->where('item_count', '<>', $summary['item_count'])
                    ->orWhere('payment_amount', '<>', $summary['balance']);
            })
            ->update([
                'status' => 'superseded',
                'updated_at' => now(),
            ]);

        $payment = StoreCoachPayment::where('store_id', $storeModel->id)
            ->where('is_success', 0)
            ->where('status', 'pending')
            ->where('item_count', $summary['item_count'])
            ->where('payment_amount', $summary['balance'])
            ->latest('id')
            ->first();

        if (!$payment) {
            $payment = StoreCoachPayment::create([
                'store_id' => $storeModel->id,
                'request_uuid' => (string) Str::uuid(),
                'payment_token' => Str::random(64),
                'coach_name' => $data['coach_name'] ?? null,
                'coach_email' => $data['coach_email'] ?? null,
                'item_count' => $summary['item_count'],
                'payment_amount' => $summary['balance'],
                'processing_fee' => $processingFee,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'is_success' => 0,
                'created_by' => optional($request->user())->id,
            ]);
        } else {
            $payment->coach_name = $data['coach_name'] ?? $payment->coach_name;
            $payment->coach_email = $data['coach_email'] ?? $payment->coach_email;
            $payment->processing_fee = $processingFee;
            $payment->total_amount = $totalAmount;
            $payment->save();
        }

        $path = 'store/coach-payment/' . $payment->payment_token;

        $paymentUrl = function_exists('makeStoreDomainRoute')
            ? makeStoreDomainRoute($path)
            : route('store.coach_payment.show', ['token' => $payment->payment_token]);

        return response()->json([
            'success' => true,
            'payment_url' => $paymentUrl,
            'item_count' => $summary['item_count'],
            'required_amount' => $summary['required_amount'],
            'paid_amount' => $summary['paid_amount'],
            'payment_amount' => (float) $payment->payment_amount,
            'processing_fee' => (float) $payment->processing_fee,
            'total_amount' => (float) $payment->total_amount,
        ]);
    }

    public function show($token)
    {
        $payment = StoreCoachPayment::where('payment_token', (string) $token)
            ->firstOrFail();

        $store = Store::findOrFail($payment->store_id);

        $teamStore = StoreTheme::where('store_id', $store->id)
            ->where('active', 1)
            ->first();

        $months = [
            1 => '01', 2 => '02', 3 => '03', 4 => '04',
            5 => '05', 6 => '06', 7 => '07', 8 => '08',
            9 => '09', 10 => '10', 11 => '11', 12 => '12',
        ];

        return view('pages.customer_team_store.home.coach_shipping_payment', [
            'payment' => $payment,
            'store' => $store,
            'teamStore' => $teamStore,
            'months' => $months,
        ]);
    }

    public function pay(Request $request, $token)
    {
        $payment = StoreCoachPayment::where('payment_token', (string) $token)
            ->firstOrFail();

        if ($payment->is_success || $payment->status === 'paid') {
            return redirect()->route('store.coach_payment.show', [
                'token' => $payment->payment_token,
            ])->with('success', 'This coach shipping payment has already been completed.');
        }

        if ($payment->status !== 'pending') {
            return redirect()->route('store.coach_payment.show', [
                'token' => $payment->payment_token,
            ])->with('error', 'This payment link is no longer active.');
        }

        $currentSummary = $this->coachPaymentSummary($payment->store_id);

        if (
            $currentSummary['balance'] <= 0
            || abs((float) $payment->payment_amount - (float) $currentSummary['balance']) > 0.009
        ) {
            $payment->status = 'superseded';
            $payment->save();

            return redirect()->route('store.coach_payment.show', [
                'token' => $payment->payment_token,
            ])->with('error', 'The coach shipping balance changed after this link was created. Ask the store for a new payment link.');
        }

        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'street' => 'required|string|max:200',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:20',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:50',
            'phone' => 'nullable|string|max:30',
            'email' => 'required|email|max:190',
            'owner' => 'required|string|max:190',
            'cardNumber' => 'required|string|max:30',
            'expiration-month' => 'required|integer|min:1|max:12',
            'expiration-year' => 'required|integer|min:' . date('Y'),
            'cvv' => 'required|string|min:3|max:4',
        ]);

        $store = Store::findOrFail($payment->store_id);
        $gateway = getPaymentGatewayConfig();

        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName($gateway['login_id']);
        $merchantAuthentication->setTransactionKey($gateway['transaction_key']);

        $cardNumber = preg_replace('/\s+/', '', (string) $data['cardNumber']);
        $expirationMonth = str_pad((string) $data['expiration-month'], 2, '0', STR_PAD_LEFT);
        $expirationYear = (string) $data['expiration-year'];

        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate($expirationYear . '-' . $expirationMonth);
        $creditCard->setCardCode($data['cvv']);

        $paymentType = new AnetAPI\PaymentType();
        $paymentType->setCreditCard($creditCard);

        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber('COACH-' . $payment->id);
        $order->setDescription('Coach Shipping Payment');

        $billTo = new AnetAPI\CustomerAddressType();
        $billTo->setFirstName($data['first_name']);
        $billTo->setLastName($data['last_name']);
        $billTo->setAddress($data['street']);
        $billTo->setCity($data['city']);
        $billTo->setState($data['state']);
        $billTo->setZip($data['zip_code']);
        $billTo->setCountry($data['country']);

        if (!empty($data['phone'])) {
            $billTo->setPhoneNumber($data['phone']);
        }

        $customerData = new AnetAPI\CustomerDataType();
        $customerData->setType('individual');
        $customerData->setId('coach_' . $payment->id);
        $customerData->setEmail($data['email']);

        $transactionRequest = new AnetAPI\TransactionRequestType();
        $transactionRequest->setTransactionType('authCaptureTransaction');
        $transactionRequest->setAmount(number_format((float) $payment->total_amount, 2, '.', ''));
        $transactionRequest->setOrder($order);
        $transactionRequest->setPayment($paymentType);
        $transactionRequest->setBillTo($billTo);
        $transactionRequest->setCustomer($customerData);

        $customerIp = $request->ip();
        if (!empty($customerIp) && filter_var($customerIp, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $transactionRequest->setCustomerIP($customerIp);
        }

        $duplicateWindow = new AnetAPI\SettingType();
        $duplicateWindow->setSettingName('duplicateWindow');
        $duplicateWindow->setSettingValue('900');
        $transactionRequest->addToTransactionSettings($duplicateWindow);

        $apiRequest = new AnetAPI\CreateTransactionRequest();
        $apiRequest->setMerchantAuthentication($merchantAuthentication);
        $apiRequest->setRefId('coach_' . $payment->id . '_' . time());
        $apiRequest->setTransactionRequest($transactionRequest);

        $payment->status = 'processing';
        $payment->save();

        try {
            $controller = new AnetController\CreateTransactionController($apiRequest);
            $response = $controller->executeWithApiResponse($gateway['environment']);
        } catch (\Throwable $e) {
            Log::error('Coach shipping payment gateway exception', [
                'store_id' => $store->id,
                'coach_payment_id' => $payment->id,
                'error' => $e->getMessage(),
            ]);

            $payment->status = 'review_required';
            $payment->gateway_message = mb_substr($e->getMessage(), 0, 500);
            $payment->save();

            return redirect()->route('store.coach_payment.show', [
                'token' => $payment->payment_token,
            ])->with('warning', 'The payment result is uncertain. Please do not submit again until the store verifies the transaction.');
        }

        if (!$response) {
            $payment->status = 'review_required';
            $payment->gateway_message = 'No response from payment gateway.';
            $payment->save();

            return redirect()->route('store.coach_payment.show', [
                'token' => $payment->payment_token,
            ])->with('warning', 'The payment result is uncertain. Please do not submit again until the store verifies the transaction.');
        }

        $transactionResponse = $response->getTransactionResponse();

        if ($transactionResponse) {
            $responseCode = (string) $transactionResponse->getResponseCode();
            $transactionId = $transactionResponse->getTransId();
            $accountNumber = $transactionResponse->getAccountNumber();
            $cardLast4 = $accountNumber ? substr($accountNumber, -4) : null;
            $gatewayMessage = null;
            $gatewayReasonCode = null;

            if ($transactionResponse->getMessages() != null && isset($transactionResponse->getMessages()[0])) {
                $gatewayMessage = $transactionResponse->getMessages()[0]->getDescription();
                $gatewayReasonCode = $transactionResponse->getMessages()[0]->getCode();
            }

            if (!$gatewayMessage && $transactionResponse->getErrors() != null && isset($transactionResponse->getErrors()[0])) {
                $gatewayMessage = $transactionResponse->getErrors()[0]->getErrorText();
                $gatewayReasonCode = $transactionResponse->getErrors()[0]->getErrorCode();
            }

            $payment->card_owner = $data['owner'];
            $payment->coach_name = trim($data['first_name'] . ' ' . $data['last_name']);
            $payment->coach_email = $data['email'];
            $payment->card_last_digits = $cardLast4;
            $payment->transaction_id = $transactionId;
            $payment->gateway_response_code = $responseCode;
            $payment->gateway_reason_code = $gatewayReasonCode;
            $payment->gateway_message = $gatewayMessage;

            if ($responseCode === '1') {
                $payment->is_success = 1;
                $payment->status = 'paid';
                $payment->paid_at = now();
                $payment->save();

                return redirect(
                    $this->coachPaymentReturnUrl(
                        $payment->payment_token
                    )
                )->with(
                    'success',
                    $gatewayMessage
                        ?: 'Coach shipping payment completed successfully.'
                );
            }

            if ($responseCode === '4') {
                $payment->is_success = 0;
                $payment->status = 'under_review';
                $payment->save();

                return redirect()->route('store.coach_payment.show', [
                    'token' => $payment->payment_token,
                ])->with('warning', 'Payment was submitted and is under review. Please do not submit it again.');
            }

            $payment->is_success = 0;
            $payment->status = 'pending';
            $payment->save();

            return back()->with('error', $gatewayMessage ?: 'The payment could not be completed.');
        }

        return back()->with('error', 'The payment gateway did not return a transaction result.');
    }
    private function coachPaymentReturnUrl($token)
    {
        return makeStoreDomainRoute(
            'store/coach-payment/' . $token
        );
    }
}
