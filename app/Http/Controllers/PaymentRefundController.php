<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentLog;
use App\Models\CardRefundLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class PaymentRefundController extends Controller
{
    public function refundTransaction(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
            'transaction_id' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $paymentLog = PaymentLog::where(
                'transaction_id',
                $request->transaction_id
            )
            ->where('order_id', $request->order_id)
            ->where('response_code', '1')
            ->first();

        if (!$paymentLog) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Successful card payment record not found.',
            ], 404);
        }

        $order = Order::find($request->order_id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Order not found.',
            ], 404);
        }

        /*
         * Normal Encore PaymentLog.amount is the gross amount charged to the
         * card, including the existing 3% fee.
         *
         * The refund modal amount is the order/customer amount, therefore a
         * settled refund sends amount * 103 / 100 back to Authorize.Net.
         */
        $refundAmount = round(
            (float) $request->amount,
            2
        );

        $gatewayRefundAmount = round(
            $refundAmount * 103 / 100,
            2
        );

        $remainingGrossAmount = round(
            (float) $paymentLog->amount,
            2
        );

        $maxRefundAmount = round(
            $remainingGrossAmount * 100 / 103,
            2
        );

        if ($refundAmount > ($maxRefundAmount + 0.001)) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' =>
                    'Refund amount cannot exceed $'
                    . number_format($maxRefundAmount, 2)
                    . '.',
            ], 422);
        }

        $gateway = getPaymentGatewayConfig();

        if (
            empty($gateway['login_id']) ||
            empty($gateway['transaction_key']) ||
            empty($gateway['environment'])
        ) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' =>
                    'Authorize.Net gateway configuration is incomplete.',
            ], 500);
        }

        $merchantAuthentication =
            new AnetAPI\MerchantAuthenticationType();

        $merchantAuthentication->setName(
            $gateway['login_id']
        );

        $merchantAuthentication->setTransactionKey(
            $gateway['transaction_key']
        );

        /*
         * Step 1: Read the original Authorize.Net transaction.
         */
        $transDetailsRequest =
            new AnetAPI\GetTransactionDetailsRequest();

        $transDetailsRequest->setMerchantAuthentication(
            $merchantAuthentication
        );

        $transDetailsRequest->setTransId(
            $request->transaction_id
        );

        $transDetailsController =
            new AnetController\GetTransactionDetailsController(
                $transDetailsRequest
            );

        $transDetailsResponse =
            $transDetailsController->executeWithApiResponse(
                $gateway['environment']
            );

        if (
            !$transDetailsResponse ||
            !$transDetailsResponse->getMessages() ||
            $transDetailsResponse->getMessages()->getResultCode() !== 'Ok'
        ) {
            $this->saveRefundLog(
                $request->order_id,
                $request->transaction_id,
                $gatewayRefundAmount,
                0
            );

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' =>
                    'Failed to retrieve transaction status from Authorize.Net.',
            ], 400);
        }

        $transaction =
            $transDetailsResponse->getTransaction();

        if (!$transaction) {
            $this->saveRefundLog(
                $request->order_id,
                $request->transaction_id,
                $gatewayRefundAmount,
                0
            );

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' =>
                    'Authorize.Net transaction details were empty.',
            ], 400);
        }

        $transactionStatus =
            (string) $transaction->getTransactionStatus();

        /*
         * Same behavior as the StoreCardPayment refund flow:
         *
         * - settledSuccessfully => partial refund
         * - anything else        => void original transaction
         *
         * Important: a void cancels the WHOLE unsettled transaction.
         */
        $isVoid =
            $transactionStatus !== 'settledSuccessfully';

        $transactionRequest =
            new AnetAPI\TransactionRequestType();

        $transactionRequest->setRefTransId(
            $request->transaction_id
        );

        if (!$isVoid) {
            /*
             * Settled payment: create a normal partial refund.
             */
            $cardNumber = '';

            if (
                $transaction->getPayment() &&
                $transaction->getPayment()->getCreditCard()
            ) {
                $cardNumber = (string) $transaction
                    ->getPayment()
                    ->getCreditCard()
                    ->getCardNumber();
            }

            $digits = preg_replace(
                '/\D+/',
                '',
                $cardNumber
            );

            $last4 = strlen($digits) >= 4
                ? substr($digits, -4)
                : '';

            if ($last4 === '') {
                $this->saveRefundLog(
                    $request->order_id,
                    $request->transaction_id,
                    $gatewayRefundAmount,
                    0
                );

                return response()->json([
                    'success' => false,
                    'status' => 'error',
                    'message' =>
                        'Unable to determine the original card last four digits.',
                ], 422);
            }

            $creditCard =
                new AnetAPI\CreditCardType();

            $creditCard->setCardNumber(
                $last4
            );

            $creditCard->setExpirationDate(
                'XXXX'
            );

            $paymentType =
                new AnetAPI\PaymentType();

            $paymentType->setCreditCard(
                $creditCard
            );

            $transactionRequest->setTransactionType(
                'refundTransaction'
            );

            $transactionRequest->setAmount(
                $gatewayRefundAmount
            );

            $transactionRequest->setPayment(
                $paymentType
            );
        } else {
            /*
             * Unsettled payment: void the complete original transaction.
             * Authorize.Net voidTransaction does not accept a partial amount.
             */
            $transactionRequest->setTransactionType(
                'voidTransaction'
            );
        }

        /*
         * Step 2: Execute refund or void.
         */
        $requestObj =
            new AnetAPI\CreateTransactionRequest();

        $requestObj->setMerchantAuthentication(
            $merchantAuthentication
        );

        $requestObj->setRefId(
            'ref' . time()
        );

        $requestObj->setTransactionRequest(
            $transactionRequest
        );

        $controller =
            new AnetController\CreateTransactionController(
                $requestObj
            );

        $response =
            $controller->executeWithApiResponse(
                $gateway['environment']
            );

        if (
            $response &&
            $response->getMessages() &&
            $response->getMessages()->getResultCode() === 'Ok'
        ) {
            $transactionResponse =
                $response->getTransactionResponse();

            if (
                $transactionResponse &&
                (string) $transactionResponse->getResponseCode() === '1'
            ) {
                /*
                 * Authorize.Net can return transaction ID "0" for a void.
                 * Keep the original transaction ID as the resolved reference,
                 * matching the working StoreCardPayment refund implementation.
                 */
                $resolvedTransactionId =
                    $transactionResponse->getTransId();

                if (
                    $isVoid ||
                    (int) $resolvedTransactionId === 0
                ) {
                    $resolvedTransactionId =
                        $request->transaction_id;
                }

                if ($isVoid) {
                    /*
                     * A void cancels the full remaining unsettled charge.
                     * Do not record only the amount typed into the modal.
                     */
                    $processedGrossAmount =
                        $remainingGrossAmount;

                    $processedBaseAmount = round(
                        $remainingGrossAmount * 100 / 103,
                        2
                    );

                    $paymentLog->amount = 0;
                } else {
                    $processedGrossAmount =
                        $gatewayRefundAmount;

                    $processedBaseAmount =
                        $refundAmount;

                    $paymentLog->amount = max(
                        0,
                        round(
                            $remainingGrossAmount -
                            $gatewayRefundAmount,
                            2
                        )
                    );
                }

                $paymentLog->save();

                /*
                 * Keep transaction_id as the ORIGINAL gateway transaction ID.
                 * refund_details() uses this value to retrieve this payment's
                 * full refund/void history.
                 */
                $this->saveRefundLog(
                    $request->order_id,
                    $request->transaction_id,
                    $processedGrossAmount,
                    1
                );

                $actionLabel =
                    $isVoid
                        ? 'Void'
                        : 'Refund';

                $message =
                    $actionLabel
                    . ' successful. Transaction ID: '
                    . $resolvedTransactionId;

                if ($isVoid) {
                    $message .=
                        '. The complete unsettled card transaction was voided.';
                }

                return response()->json([
                    'success' => true,
                    'status' => 'success',
                    'action' =>
                        $isVoid
                            ? 'void'
                            : 'refund',
                    'message' =>
                        $message,
                    'transaction_id' =>
                        $resolvedTransactionId,
                    'original_transaction_id' =>
                        $request->transaction_id,
                    'refund_amount' =>
                        $processedBaseAmount,
                    'gateway_refund_amount' =>
                        $processedGrossAmount,
                    'remaining_gross_amount' =>
                        (float) $paymentLog->amount,
                    'remaining_refund_amount' =>
                        round(
                            ((float) $paymentLog->amount)
                            * 100
                            / 103,
                            2
                        ),
                ]);
            }

            /*
             * Authorize.Net transaction-level error.
             */
            $error =
                'Unknown transaction error.';

            if (
                $transactionResponse &&
                $transactionResponse->getErrors()
            ) {
                foreach (
                    $transactionResponse->getErrors()
                    as $transactionError
                ) {
                    $error =
                        $transactionError->getErrorText();
                }
            }

            $attemptedAmount =
                $isVoid
                    ? $remainingGrossAmount
                    : $gatewayRefundAmount;

            $this->saveRefundLog(
                $request->order_id,
                $request->transaction_id,
                $attemptedAmount,
                0
            );

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $error,
            ], 400);
        }

        /*
         * General Authorize.Net failure.
         */
        $message =
            'Transaction failed.';

        if (
            $response &&
            $response->getMessages() &&
            $response->getMessages()->getMessage()
        ) {
            foreach (
                $response->getMessages()->getMessage()
                as $gatewayMessage
            ) {
                $message =
                    $gatewayMessage->getText();
            }
        }

        $attemptedAmount =
            $isVoid
                ? $remainingGrossAmount
                : $gatewayRefundAmount;

        $this->saveRefundLog(
            $request->order_id,
            $request->transaction_id,
            $attemptedAmount,
            0
        );

        return response()->json([
            'success' => false,
            'status' => 'error',
            'message' => $message,
        ], 400);
    }

    private function saveRefundLog(
        $orderId,
        $transactionId,
        $gatewayAmount,
        $isSuccess
    ) {
        $refundLog =
            new CardRefundLog();

        $refundLog->order_id =
            $orderId;

        $refundLog->transaction_id =
            $transactionId;

        $refundLog->amount = round(
            (float) $gatewayAmount,
            2
        );

        $refundLog->user_id =
            Auth::id();

        $refundLog->is_success =
            (int) $isSuccess;

        $refundLog->save();

        return $refundLog;
    }
}
