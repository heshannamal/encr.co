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
                'message' => 'Successful card payment record not found.',
            ], 404);
        }

        $order = Order::find($request->order_id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.',
            ], 404);
        }

        /*
         * Existing Encore card payments store the gross charged amount in
         * PaymentLog.amount. The order/customer amount is gross * 100 / 103.
         */
        $refundAmount = round((float) $request->amount, 2);
        $gatewayRefundAmount = round(
            $refundAmount * 103 / 100,
            2
        );

        $remainingGrossAmount = round(
            (float) $paymentLog->amount,
            2
        );

        if ($gatewayRefundAmount > ($remainingGrossAmount + 0.01)) {
            return response()->json([
                'success' => false,
                'message' =>
                    'Refund amount exceeds the remaining refundable card amount.',
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

        $detailsRequest =
            new AnetAPI\GetTransactionDetailsRequest();

        $detailsRequest->setMerchantAuthentication(
            $merchantAuthentication
        );

        $detailsRequest->setTransId(
            $request->transaction_id
        );

        $detailsController =
            new AnetController\GetTransactionDetailsController(
                $detailsRequest
            );

        $detailsResponse =
            $detailsController->executeWithApiResponse(
                $gateway['environment']
            );

        if (
            !$detailsResponse ||
            !$detailsResponse->getMessages() ||
            $detailsResponse->getMessages()->getResultCode() !== 'Ok'
        ) {
            $this->saveRefundLog(
                $request->order_id,
                $request->transaction_id,
                $gatewayRefundAmount,
                0
            );

            return response()->json([
                'success' => false,
                'message' =>
                    'Failed to retrieve the Authorize.Net transaction details.',
            ], 400);
        }

        $transaction = $detailsResponse->getTransaction();

        if (!$transaction) {
            $this->saveRefundLog(
                $request->order_id,
                $request->transaction_id,
                $gatewayRefundAmount,
                0
            );

            return response()->json([
                'success' => false,
                'message' =>
                    'Authorize.Net transaction details were empty.',
            ], 400);
        }

        $transactionStatus =
            (string) $transaction->getTransactionStatus();

        /*
         * Do not turn a partial refund request into a full void.
         * Wait for settlement before allowing a partial refund.
         */
        if ($transactionStatus !== 'settledSuccessfully') {
            $this->saveRefundLog(
                $request->order_id,
                $request->transaction_id,
                $gatewayRefundAmount,
                0
            );

            return response()->json([
                'success' => false,
                'message' =>
                    'This card transaction is not settled yet. '
                    . 'Partial refund is available after Authorize.Net settlement. '
                    . 'Current status: '
                    . $transactionStatus,
            ], 422);
        }

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

        $digits = preg_replace('/\D+/', '', $cardNumber);

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
                'message' =>
                    'Unable to determine the original card last four digits.',
            ], 422);
        }

        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($last4);
        $creditCard->setExpirationDate('XXXX');

        $paymentType = new AnetAPI\PaymentType();
        $paymentType->setCreditCard($creditCard);

        $transactionRequest =
            new AnetAPI\TransactionRequestType();

        $transactionRequest->setTransactionType(
            'refundTransaction'
        );

        $transactionRequest->setAmount(
            $gatewayRefundAmount
        );

        $transactionRequest->setRefTransId(
            $request->transaction_id
        );

        $transactionRequest->setPayment(
            $paymentType
        );

        $createRequest =
            new AnetAPI\CreateTransactionRequest();

        $createRequest->setMerchantAuthentication(
            $merchantAuthentication
        );

        $createRequest->setRefId(
            'refund-' . time()
        );

        $createRequest->setTransactionRequest(
            $transactionRequest
        );

        $controller =
            new AnetController\CreateTransactionController(
                $createRequest
            );

        $response =
            $controller->executeWithApiResponse(
                $gateway['environment']
            );

        if (
            !$response ||
            !$response->getMessages() ||
            $response->getMessages()->getResultCode() !== 'Ok'
        ) {
            $this->saveRefundLog(
                $request->order_id,
                $request->transaction_id,
                $gatewayRefundAmount,
                0
            );

            $message = 'Authorize.Net refund failed.';

            if (
                $response &&
                $response->getMessages() &&
                $response->getMessages()->getMessage()
            ) {
                $messages =
                    $response->getMessages()->getMessage();

                if (!empty($messages[0])) {
                    $message .=
                        ' ' .
                        $messages[0]->getText();
                }
            }

            return response()->json([
                'success' => false,
                'message' => $message,
            ], 400);
        }

        $transactionResponse =
            $response->getTransactionResponse();

        if (
            !$transactionResponse ||
            (string) $transactionResponse->getResponseCode() !== '1'
        ) {
            $this->saveRefundLog(
                $request->order_id,
                $request->transaction_id,
                $gatewayRefundAmount,
                0
            );

            $message = 'Refund failed.';

            if (
                $transactionResponse &&
                $transactionResponse->getErrors()
            ) {
                $errors =
                    $transactionResponse->getErrors();

                if (!empty($errors[0])) {
                    $message .=
                        ' ' .
                        $errors[0]->getErrorText();
                }
            }

            return response()->json([
                'success' => false,
                'message' => $message,
            ], 400);
        }

        /*
         * Preserve the current Encore accounting behavior:
         * PaymentLog.amount becomes the remaining gross card amount.
         */
        $paymentLog->amount = max(
            0,
            round(
                $remainingGrossAmount -
                $gatewayRefundAmount,
                2
            )
        );

        $paymentLog->save();

        $this->saveRefundLog(
            $request->order_id,
            $request->transaction_id,
            $gatewayRefundAmount,
            1
        );

        return response()->json([
            'success' => true,
            'message' => 'Card refund processed successfully.',
            'refund_transaction_id' =>
                $transactionResponse->getTransId(),
            'refund_amount' =>
                $refundAmount,
            'gateway_refund_amount' =>
                $gatewayRefundAmount,
            'remaining_gross_amount' =>
                (float) $paymentLog->amount,
            'remaining_refund_amount' =>
                round(
                    ((float) $paymentLog->amount) *
                    100 /
                    103,
                    2
                ),
        ]);
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

        $refundLog->amount =
            round(
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
