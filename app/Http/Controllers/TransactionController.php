<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckPayment;
use App\Models\Order;
use App\Models\PaymentLog;
use App\Models\CardRefundLog;
use App\Models\User;
use App\Models\VenmoPayment;
use App\Models\PaypalPayment;
use App\Models\PurchaseorderReceipt;
use App\Models\OtherPayment;
use App\Models\StoreCardPayment;
use App\Services\PaymentService;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;

class TransactionController extends Controller
{
    protected $PaymentService;

    public function __construct(PaymentService $PaymentService)
    {
        $this->PaymentService = $PaymentService;
    }

    public function getAllPaymentsByOrderId($orderID){

        $cardPaymentRecords = PaymentLog::where('order_id', $orderID)->where('response_code','1')->get();
        $checkPaymentRecords = CheckPayment::where('order_id', $orderID)->get();
        $venmoPaymentRecords = VenmoPayment::where('order_id', $orderID)->get();
        $paypalPaymentRecords = PaypalPayment::where('order_id', $orderID)->get();
        $otherPaymentRecords = OtherPayment::where('order_id', $orderID)->get();
        $PoPaymentRecords = PurchaseorderReceipt::where('order_id', $orderID)->get();

        foreach($cardPaymentRecords as $cardPaymentRecord){

            $payment_status = $this->PaymentService->getPaymentStatus($cardPaymentRecord->order_id);

            if ($payment_status['payment_status'] == 0) {
                $paymentStatus = "Pending";
            } else if ($payment_status['payment_status'] == 1) {
                $paymentStatus = "Partial";
            }else if ($payment_status['payment_status'] == 2) {
                $paymentStatus = "Paid";
            } else {
                $paymentStatus = "N/A";
            }

            $ProcessingFee = $payment_status['processing_fee'];
            $total_payment = $payment_status['total_payment'];
            $balance_to_be_paid = $payment_status['balance_to_be_paid'];

            $orderPaymentsArray[] = array('Method'=>'Card', 'id'=>$cardPaymentRecord->id,'NameonCard'=>$cardPaymentRecord->name_on_card, 'paymentStatus'=>$paymentStatus, 'is_approve'=>1, 'TransactionId'=>$cardPaymentRecord->transaction_id, 'Amount'=>$cardPaymentRecord->amount, 'ProcessingFee'=>$ProcessingFee, 'total_payment'=>$total_payment, 'balance_to_be_paid'=>$balance_to_be_paid, 'PaymentDate'=>$cardPaymentRecord->created_at);
        }
        foreach($checkPaymentRecords as $checkPaymentRecord){

            $payment_status = $this->PaymentService->getPaymentStatus($checkPaymentRecord->order_id);

            if ($payment_status['payment_status'] == 0) {
                $paymentStatus = "Pending";
            } else if ($payment_status['payment_status'] == 1) {
                $paymentStatus = "Partial";
            }else if ($payment_status['payment_status'] == 2) {
                $paymentStatus = "Paid";
            } else {
                $paymentStatus = "N/A";
            }

            $ProcessingFee = $payment_status['processing_fee'];
            $total_payment = $payment_status['total_payment'];
            $balance_to_be_paid = $payment_status['balance_to_be_paid'];

            $checkPaymentId = 'CHQ'.str_pad(($checkPaymentRecord->id), 6, "0", STR_PAD_LEFT);
            $orderPaymentsArray[] = array('Method'=>'Check', 'id'=>$checkPaymentRecord->id, 'NameonCard'=>'N/A', 'paymentStatus'=>$paymentStatus, 'is_approve'=>$checkPaymentRecord->is_approved, 'TransactionId'=>$checkPaymentId, 'Amount'=>$checkPaymentRecord->amount, 'ProcessingFee'=>$ProcessingFee, 'total_payment'=>$total_payment, 'balance_to_be_paid'=>$balance_to_be_paid, 'PaymentDate'=>$checkPaymentRecord->created_at);
        }
        foreach($venmoPaymentRecords as $venmoPaymentRecord){

            $payment_status = $this->PaymentService->getPaymentStatus($venmoPaymentRecord->order_id);

            if ($payment_status['payment_status'] == 0) {
                $paymentStatus = "Pending";
            } else if ($payment_status['payment_status'] == 1) {
                $paymentStatus = "Partial";
            }else if ($payment_status['payment_status'] == 2) {
                $paymentStatus = "Paid";
            } else {
                $paymentStatus = "N/A";
            }

            $ProcessingFee = $payment_status['processing_fee'];
            $total_payment = $payment_status['total_payment'];
            $balance_to_be_paid = $payment_status['balance_to_be_paid'];

            $venmoPaymentId = 'VNM'.str_pad(($venmoPaymentRecord->id), 6, "0", STR_PAD_LEFT);
            $orderPaymentsArray[] = array('Method'=>'Venmo', 'id'=>$venmoPaymentRecord->id, 'NameonCard'=>'N/A', 'paymentStatus'=>$paymentStatus, 'is_approve'=>$venmoPaymentRecord->is_approved, 'TransactionId'=>$venmoPaymentId, 'Amount'=>$venmoPaymentRecord->amount, 'ProcessingFee'=>$ProcessingFee, 'total_payment'=>$total_payment, 'balance_to_be_paid'=>$balance_to_be_paid, 'PaymentDate'=>$venmoPaymentRecord->created_at);
        }
        foreach($paypalPaymentRecords as $paypalPaymentRecord){

            $payment_status = $this->PaymentService->getPaymentStatus($paypalPaymentRecord->order_id);

            if ($payment_status['payment_status'] == 0) {
                $paymentStatus = "Pending";
            } else if ($payment_status['payment_status'] == 1) {
                $paymentStatus = "Partial";
            }else if ($payment_status['payment_status'] == 2) {
                $paymentStatus = "Paid";
            } else {
                $paymentStatus = "N/A";
            }

            $ProcessingFee = $payment_status['processing_fee'];
            $total_payment = $payment_status['total_payment'];
            $balance_to_be_paid = $payment_status['balance_to_be_paid'];

            $paypalPaymentId = 'PAYPAL'.str_pad(($paypalPaymentRecord->id), 6, "0", STR_PAD_LEFT);
            $orderPaymentsArray[] = array('Method'=>'Paypal', 'id'=>$paypalPaymentRecord->id, 'NameonCard'=>'N/A', 'paymentStatus'=>$paymentStatus, 'is_approve'=>$paypalPaymentRecord->is_approved, 'TransactionId'=>$paypalPaymentId, 'Amount'=>$paypalPaymentRecord->amount, 'ProcessingFee'=>$ProcessingFee, 'total_payment'=>$total_payment, 'balance_to_be_paid'=>$balance_to_be_paid, 'PaymentDate'=>$paypalPaymentRecord->created_at);
        }
        foreach($otherPaymentRecords as $otherPaymentRecord){

            $payment_status = $this->PaymentService->getPaymentStatus($otherPaymentRecord->order_id);

            if ($payment_status['payment_status'] == 0) {
                $paymentStatus = "Pending";
            } else if ($payment_status['payment_status'] == 1) {
                $paymentStatus = "Partial";
            }else if ($payment_status['payment_status'] == 2) {
                $paymentStatus = "Paid";
            } else {
                $paymentStatus = "N/A";
            }

            $ProcessingFee = $payment_status['processing_fee'];
            $total_payment = $payment_status['total_payment'];
            $balance_to_be_paid = $payment_status['balance_to_be_paid'];

            $otherPaymentId = 'OTH'.str_pad(($otherPaymentRecord->id), 6, "0", STR_PAD_LEFT);
            $orderPaymentsArray[] = array('Method'=>'Other', 'id'=>$otherPaymentRecord->id, 'NameonCard'=>'N/A', 'paymentStatus'=>$paymentStatus, 'is_approve'=>$otherPaymentRecord->is_approved, 'TransactionId'=>$otherPaymentId, 'Amount'=>$otherPaymentRecord->amount, 'ProcessingFee'=>$ProcessingFee, 'total_payment'=>$total_payment, 'balance_to_be_paid'=>$balance_to_be_paid, 'PaymentDate'=>$otherPaymentRecord->created_at);
        }
        foreach($PoPaymentRecords as $PoPaymentRecord){

            $payment_status = $this->PaymentService->getPaymentStatus($PoPaymentRecord->order_id);

            if ($payment_status['payment_status'] == 0) {
                $paymentStatus = "Pending";
            } else if ($payment_status['payment_status'] == 1) {
                $paymentStatus = "Partial";
            }else if ($payment_status['payment_status'] == 2) {
                $paymentStatus = "Paid";
            } else {
                $paymentStatus = "N/A";
            }

            $ProcessingFee = $payment_status['processing_fee'];
            $total_payment = $payment_status['total_payment'];
            $balance_to_be_paid = $payment_status['balance_to_be_paid'];

            $poPaymentId = 'PO'.str_pad(($PoPaymentRecord->id), 6, "0", STR_PAD_LEFT);
            $orderPaymentsArray[] = array('Method'=>'PO', 'id'=>$PoPaymentRecord->id, 'NameonCard'=>'N/A', 'paymentStatus'=>$paymentStatus, 'is_approve'=>$PoPaymentRecord->is_approved, 'TransactionId'=>$poPaymentId, 'Amount'=>$PoPaymentRecord->amount, 'ProcessingFee'=>$ProcessingFee, 'total_payment'=>$total_payment, 'balance_to_be_paid'=>$balance_to_be_paid, 'PaymentDate'=>$PoPaymentRecord->created_at);
        }

        return $orderPaymentsArray;

    }

    public function get_order_payments(request $request){

        $order_payments = $this->getAllPaymentsByOrderId($request->orderID);

        return response()->json([
            'order_payments' => $order_payments,
        ]);
    }
    public function get_payment_receipt_data(request $request){

        $payment_status = $this->PaymentService->getPaymentStatus($request->orderID);

        if ($payment_status['payment_status'] == 0) {
            $paymentStatus = "Pending";
        } else if ($payment_status['payment_status'] == 1) {
            $paymentStatus = "Partial";
        }else if ($payment_status['payment_status'] == 2) {
            $paymentStatus = "Paid";
        } else {
            $paymentStatus = "N/A";
        }

        $ProcessingFee = $payment_status['processing_fee'];
        $total_payment = $payment_status['total_payment'];
        $balance_to_be_paid = $payment_status['balance_to_be_paid'];

        if($request->transactionMethod == 'Card') {
            $cardPaymentRecord = PaymentLog::where('id', $request->transactionID)->first();
            $orderPaymentsArray[] = array('Method'=>'Card', 'id'=>$cardPaymentRecord->id,'NameonCard'=>$cardPaymentRecord->name_on_card, 'paymentStatus'=>$paymentStatus, 'is_approve'=>1, 'TransactionId'=>$cardPaymentRecord->transaction_id, 'Amount'=>$cardPaymentRecord->amount, 'ProcessingFee'=>$ProcessingFee, 'total_payment'=>$total_payment, 'balance_to_be_paid'=>$balance_to_be_paid, 'PaymentDate'=>$cardPaymentRecord->created_at);
        } else if ($request->transactionMethod == 'Check') {
            $checkPaymentRecord = CheckPayment::where('id', $request->transactionID)->first();
            $checkPaymentId = 'CHQ'.str_pad(($checkPaymentRecord->id), 6, "0", STR_PAD_LEFT);
            $orderPaymentsArray[] = array('Method'=>'Check', 'id'=>$checkPaymentRecord->id, 'NameonCard'=>'N/A', 'paymentStatus'=>$paymentStatus, 'is_approve'=>$checkPaymentRecord->is_approved, 'TransactionId'=>$checkPaymentId, 'Amount'=>$checkPaymentRecord->amount, 'ProcessingFee'=>$ProcessingFee, 'total_payment'=>$total_payment, 'balance_to_be_paid'=>$balance_to_be_paid, 'PaymentDate'=>$checkPaymentRecord->created_at);
        } else if ($request->transactionMethod == 'Venmo') {
            $venmoPaymentRecord = VenmoPayment::where('id', $request->transactionID)->first();
            $venmoPaymentId = 'VNM'.str_pad(($venmoPaymentRecord->id), 6, "0", STR_PAD_LEFT);
            $orderPaymentsArray[] = array('Method'=>'Venmo', 'id'=>$venmoPaymentRecord->id, 'NameonCard'=>'N/A', 'paymentStatus'=>$paymentStatus, 'is_approve'=>$venmoPaymentRecord->is_approved, 'TransactionId'=>$venmoPaymentId, 'Amount'=>$venmoPaymentRecord->amount, 'ProcessingFee'=>$ProcessingFee, 'total_payment'=>$total_payment, 'balance_to_be_paid'=>$balance_to_be_paid, 'PaymentDate'=>$venmoPaymentRecord->created_at);
        } else if ($request->transactionMethod == 'Paypal') {
            $paypalPaymentRecord = PaypalPayment::where('id', $request->transactionID)->first();
            $paypalPaymentId = 'PAYPAL'.str_pad(($paypalPaymentRecord->id), 6, "0", STR_PAD_LEFT);
            $orderPaymentsArray[] = array('Method'=>'Paypal', 'id'=>$paypalPaymentRecord->id, 'NameonCard'=>'N/A', 'paymentStatus'=>$paymentStatus, 'is_approve'=>$paypalPaymentRecord->is_approved, 'TransactionId'=>$paypalPaymentId, 'Amount'=>$paypalPaymentRecord->amount, 'ProcessingFee'=>$ProcessingFee, 'total_payment'=>$total_payment, 'balance_to_be_paid'=>$balance_to_be_paid, 'PaymentDate'=>$paypalPaymentRecord->created_at);
        } else if ($request->transactionMethod == 'Other') {
            $otherPaymentRecord = OtherPayment::where('id', $request->transactionID)->first();
            $otherPaymentId = 'OTH'.str_pad(($otherPaymentRecord->id), 6, "0", STR_PAD_LEFT);
            $orderPaymentsArray[] = array('Method'=>'Other', 'id'=>$otherPaymentRecord->id, 'NameonCard'=>'N/A', 'paymentStatus'=>$paymentStatus, 'is_approve'=>$otherPaymentRecord->is_approved, 'TransactionId'=>$otherPaymentId, 'Amount'=>$otherPaymentRecord->amount, 'ProcessingFee'=>$ProcessingFee, 'total_payment'=>$total_payment, 'balance_to_be_paid'=>$balance_to_be_paid, 'PaymentDate'=>$otherPaymentRecord->created_at);
        } else if ($request->transactionMethod == 'PO') {
            $PoPaymentRecord = PurchaseorderReceipt::where('id', $request->transactionID)->first();
            $poPaymentId = 'PO'.str_pad(($PoPaymentRecord->id), 6, "0", STR_PAD_LEFT);
            $orderPaymentsArray[] = array('Method'=>'PO', 'id'=>$PoPaymentRecord->id, 'NameonCard'=>'N/A', 'paymentStatus'=>$paymentStatus, 'is_approve'=>$PoPaymentRecord->is_approved, 'TransactionId'=>$poPaymentId, 'Amount'=>$PoPaymentRecord->amount, 'ProcessingFee'=>$ProcessingFee, 'total_payment'=>$total_payment, 'balance_to_be_paid'=>$balance_to_be_paid, 'PaymentDate'=>$PoPaymentRecord->created_at);
        }

        $orderDetails = Order::select('order_no', 'sub_total', 'artwork', 'discount_hidation', 'discountType', 'discount', 'sales_tax', 'shipping', 'order_total', 'organization_id', 'contact_id')->where('id',$request->orderID)->with(['organizationDetails:id,organization_name,sales_tax'])->first();

        return response()->json([
            'payment_receipt' => $orderPaymentsArray,
            'orderDetails' => $orderDetails,
        ]);
    }

    public function get_store_payment_log_details(request $request){

        $logID = $request->paymentLogId;

        $record = PaymentLog::find($logID);

        if(!$record || !$record->store_id){
            return response()->json(['error' => 'Payment log not found.'], 404);
        }

        $paymentLogDetails = StoreCardPayment::where('store_id', $record->store_id)->where('is_success', 1)->get();

        return response()->json($paymentLogDetails);
    }
    public function search_store_payment_logs(Request $request)
    {
        $search = trim($request->search ?? '');

        if ($search === '') {
            return response()->json([
                'payment_log_ids' => []
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Find matching StoreCardPayment records
        |--------------------------------------------------------------------------
        */
        $storeIds = StoreCardPayment::query()
            ->where('is_success', 1)
            ->where(function ($query) use ($search) {

                $query->where('store_order_no', 'LIKE', "%{$search}%")
                    ->orWhere('card_owner', 'LIKE', "%{$search}%")
                    ->orWhere('transaction_id', 'LIKE', "%{$search}%")
                    ->orWhere('payment_amount', 'LIKE', "%{$search}%")
                    ->orWhere('processing_fee', 'LIKE', "%{$search}%")
                    ->orWhere('total_amount', 'LIKE', "%{$search}%")

                    // Search date
                    ->orWhereRaw(
                        "DATE_FORMAT(created_at, '%m/%d/%Y') LIKE ?",
                        ["%{$search}%"]
                    )

                    // Search time
                    ->orWhereRaw(
                        "DATE_FORMAT(created_at, '%H:%i:%s') LIKE ?",
                        ["%{$search}%"]
                    );
            })
            ->pluck('store_id')
            ->filter()
            ->unique()
            ->values();

        if ($storeIds->isEmpty()) {
            return response()->json([
                'payment_log_ids' => []
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Find parent PaymentLog records
        |--------------------------------------------------------------------------
        */
        $paymentLogIds = PaymentLog::query()
            ->whereIn('store_id', $storeIds)
            ->where('response_code', '1')
            ->where('auto_generated', 1)
            ->pluck('id')
            ->values();

        return response()->json([
            'payment_log_ids' => $paymentLogIds
        ]);
    }

    public function allTransactionPayments(Request $request){
        if(auth()->user()->can('manage transaction')){
            $onlinePayments = PaymentLog::where('response_code','1')->orderBy('created_at', 'DESC')->get();

            $checkPayments = CheckPayment::orderBy('created_at', 'DESC')->get();

            $venmoPayments = VenmoPayment::orderBy('created_at', 'DESC')->get();

            $paypalPayments = PaypalPayment::orderBy('created_at', 'DESC')->get();

            $PoReceipts = PurchaseorderReceipt::orderBy('created_at', 'DESC')->get();

            $otherPayments = OtherPayment::orderBy('created_at', 'DESC')->get();

            $TrasnsactionsArray = [];

            // QuickBooks state maps.
            //
            // One PAYMENT may have only one QuickBooks identity:
            // order_id + record_id + payment_type + module + refund flag.
            //
            // UI states:
            //   export_status = 0 => saved locally, not yet synced
            //   export_status = 1 => synced to QuickBooks
            //   export_status = 2 => previous sync attempt failed
            //
            // IMPORTANT:
            // Order and StoreOrder remain separate through from_tsr_module.
            $normalQuickBooksStatusMap = [];
            $storeQuickBooksStatusMap = [];

            $quickBooksRecords = \App\Models\QuickbookRecord::select(
                    'order_id',
                    'record_id',
                    'payment_type',
                    'from_tsr_module',
                    'is_refund',
                    'export_status'
                )
                ->whereIn('export_status', [0, 1, 2])
                ->get();

            $qbStatusFromExportStatus = function ($exportStatus) {
                $exportStatus = (int) $exportStatus;

                if ($exportStatus === 1) {
                    return 'synced';
                }

                if ($exportStatus === 0) {
                    return 'saved';
                }

                if ($exportStatus === 2) {
                    return 'failed';
                }

                return null;
            };

            // If historical duplicate rows exist, never downgrade a successfully
            // synced payment to saved/failed in the UI.
            $mergeQuickBooksStatus = function ($current, $incoming) {
                $priority = [
                    null     => 0,
                    'failed' => 1,
                    'saved'  => 2,
                    'synced' => 3,
                ];

                return ($priority[$incoming] ?? 0) > ($priority[$current] ?? 0)
                    ? $incoming
                    : $current;
            };

            foreach ($quickBooksRecords as $qbRecord) {
                $status = $qbStatusFromExportStatus($qbRecord->export_status);

                if (!$status) {
                    continue;
                }

                // StoreOrder module.
                if ((int) $qbRecord->from_tsr_module === 1) {
                    if (strcasecmp((string) $qbRecord->payment_type, 'Card') !== 0) {
                        continue;
                    }

                    // StoreCardPayment.id is globally unique in its own table.
                    // Keep refund/non-refund states separate.
                    $recordId = (string) $qbRecord->record_id;
                    $refundKey = (string) ((int) $qbRecord->is_refund);

                    if (!isset($storeQuickBooksStatusMap[$recordId])) {
                        $storeQuickBooksStatusMap[$recordId] = [];
                    }

                    $current = $storeQuickBooksStatusMap[$recordId][$refundKey] ?? null;

                    $storeQuickBooksStatusMap[$recordId][$refundKey] =
                        $mergeQuickBooksStatus($current, $status);

                    continue;
                }

                // Normal Order module.
                $key = implode('|', [
                    (string) $qbRecord->order_id,
                    (string) $qbRecord->record_id,
                    strtolower(trim((string) $qbRecord->payment_type)),
                    (string) ((int) $qbRecord->is_refund),
                ]);

                $current = $normalQuickBooksStatusMap[$key] ?? null;

                $normalQuickBooksStatusMap[$key] =
                    $mergeQuickBooksStatus($current, $status);
            }

            $getNormalQuickBooksStatus = function (
                $orderId,
                $recordId,
                $paymentType
            ) use ($normalQuickBooksStatusMap) {
                $key = implode('|', [
                    (string) $orderId,
                    (string) $recordId,
                    strtolower(trim((string) $paymentType)),
                    '0',
                ]);

                return $normalQuickBooksStatusMap[$key] ?? null;
            };

            /*
            |--------------------------------------------------------------------------
            | Auto-generated parent QuickBooks status
            |--------------------------------------------------------------------------
            |
            | An auto-generated PaymentLog is only a collapsed/grouping row for
            | StoreCardPayment records. Show the green synced icon on that parent
            | only when EVERY successful StoreCardPayment under the same store has
            | its exact QuickBooks record marked export_status = 1.
            |
            | This is calculated in one batch query, so the parent icon is correct
            | immediately on page load while the child rows are still collapsed.
            */
            $fullySyncedStoreIds = [];

            /*
             * Customer names for the collapsed StoreCardPayment table.
             *
             * StoreCardPayment does not carry the customer's first/last name.
             * Its store_order_no points to StoreOrder.order_no, so build one
             * lookup here and pass it to the Blade:
             *
             *   StoreCardPayment.id => StoreOrder.first_name + last_name
             */
            $storeCustomerNameMap = [];
            $storeCustomerSearchIndex = [];

            $autoGeneratedStoreIds = $onlinePayments
                ->filter(function ($paymentLog) {
                    return (int) ($paymentLog->auto_generated ?? 0) === 1
                        && !empty($paymentLog->store_id);
                })
                ->pluck('store_id')
                ->filter()
                ->unique()
                ->values();

            if ($autoGeneratedStoreIds->isNotEmpty()) {
                $storeCardPaymentsByStore = \App\Models\StoreCardPayment::select(
                        'id',
                        'store_id',
                        'store_order_no',
                        'is_refund'
                    )
                    ->whereIn('store_id', $autoGeneratedStoreIds->all())
                    ->where('is_success', 1)
                    ->get()
                    ->groupBy('store_id');

                $storeOrderNumbers = $storeCardPaymentsByStore
                    ->flatten(1)
                    ->pluck('store_order_no')
                    ->filter()
                    ->unique()
                    ->values();

                $storeOrdersByOrderNo = $storeOrderNumbers->isNotEmpty()
                    ? \App\Models\StoreOrder::select(
                            'order_no',
                            'first_name',
                            'last_name'
                        )
                        ->whereIn(
                            'order_no',
                            $storeOrderNumbers->all()
                        )
                        ->get()
                        ->keyBy('order_no')
                    : collect();

                /*
                 * Used only so DataTables search can find a Customer Name even
                 * before the collapsed StoreCardPayment rows are opened.
                 */
                $parentPaymentLogIdsByStore = $onlinePayments
                    ->filter(function ($paymentLog) {
                        return (int) ($paymentLog->auto_generated ?? 0) === 1
                            && !empty($paymentLog->store_id);
                    })
                    ->groupBy(function ($paymentLog) {
                        return (string) $paymentLog->store_id;
                    })
                    ->map(function ($paymentLogs) {
                        return $paymentLogs
                            ->pluck('id')
                            ->map(function ($id) {
                                return (int) $id;
                            })
                            ->values()
                            ->all();
                    });

                foreach ($autoGeneratedStoreIds as $storeId) {
                    $eligibleStorePayments =
                        $storeCardPaymentsByStore->get($storeId, collect());

                    if ($eligibleStorePayments->isEmpty()) {
                        $fullySyncedStoreIds[(string) $storeId] = false;
                        continue;
                    }

                    $allSynced = $eligibleStorePayments->every(
                        function ($storePayment) use ($storeQuickBooksStatusMap) {
                            $recordId = (string) $storePayment->id;
                            $refundKey = (string) ((int) ($storePayment->is_refund ?? 0));

                            return (
                                $storeQuickBooksStatusMap[$recordId][$refundKey]
                                ?? null
                            ) === 'synced';
                        }
                    );

                    $fullySyncedStoreIds[(string) $storeId] = $allSynced;

                    foreach ($eligibleStorePayments as $storePayment) {
                        $storeOrder = $storeOrdersByOrderNo->get(
                            $storePayment->store_order_no
                        );

                        $customerName = '';

                        if ($storeOrder) {
                            $customerName = trim(
                                (string) ($storeOrder->first_name ?? '')
                                . ' '
                                . (string) ($storeOrder->last_name ?? '')
                            );
                        }

                        $storeCustomerNameMap[
                            (string) $storePayment->id
                        ] = $customerName;

                        foreach (
                            $parentPaymentLogIdsByStore[
                                (string) $storeId
                            ] ?? []
                            as $parentPaymentLogId
                        ) {
                            $storeCustomerSearchIndex[] = [
                                'payment_id' =>
                                    (int) $storePayment->id,

                                'parent_id' =>
                                    (int) $parentPaymentLogId,

                                'customer_name' =>
                                    $customerName,
                            ];
                        }
                    }
                }
            }

            foreach($otherPayments as $otherPayment)
            {
                $orderPaymentsArray = [];
                $orderDetails = Order::select('id', 'order_no', 'sub_total', 'artwork', 'discount_hidation', 'discountType', 'discount', 'sales_tax', 'shipping', 'order_total', 'organization_id', 'contact_id')->where('id',$otherPayment->order_id)->with([
                    'organizationDetails:id,organization_name,sales_tax',
                    'contactDetails'
                ])->get();
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];

                $customer_name = trim(
                    (string) ($orderDetails[0]->contactDetails->first_name ?? '')
                    . ' '
                    . (string) ($orderDetails[0]->contactDetails->last_name ?? '')
                );

                // if($orderDetails[0]->organizationDetails['id'] == 2890){
                //     continue;
                // }

                $order_payment_status = $this->PaymentService->getPaymentStatus($otherPayment->order_id)['payment_status'];
                $approval = $otherPayment->is_approved == 1 ? 'Approved' : 'Not Approved';
                $PaymentIdUnique = 'OTH'.str_pad(($otherPayment->id), 6, "0", STR_PAD_LEFT);

                $orderPaymentsArray = $this->getAllPaymentsByOrderId($otherPayment->order_id);


                $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
                array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);

                $TrasnsactionsArray[] = array('ID'=>$otherPayment->id, 'Order'=> $otherPayment->order_id, 'OrderNo'=>$orderDetails[0]->order_no,'PaymentType'=>'Other', 'TeamName'=> $organization_name, 'NameonCard'=> 'N/A', 'CustomerName'=> $customer_name, 'checkStatus'=> $approval, 'Amount'=> $otherPayment->amount, 'ProcessingFee'=> 0, 'OrderStatus'=> $order_payment_status, 'TransactionID'=> $PaymentIdUnique, 'PaymentDate'=> $otherPayment->created_at, 'checkFImage'=>$otherPayment->document_url, 'checkBImage'=>$otherPayment->document_url_back, 'OrderPayments'=>json_encode($orderPaymentsArray) ,'auto_generated'=>false, 'QBStatus'=>$getNormalQuickBooksStatus($otherPayment->order_id, $otherPayment->id, 'Other'));

            }
            foreach($PoReceipts as $PoReceipt)
            {
                $orderPaymentsArray = [];
                $orderDetails = Order::select('id', 'order_no', 'sub_total', 'artwork', 'discount_hidation', 'discountType', 'discount', 'sales_tax', 'shipping', 'order_total', 'organization_id', 'contact_id')->where('id',$PoReceipt->order_id)->with([
                    'organizationDetails:id,organization_name,sales_tax',
                    'contactDetails'
                ])->get();
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];

                $customer_name = trim(
                    (string) ($orderDetails[0]->contactDetails->first_name ?? '')
                    . ' '
                    . (string) ($orderDetails[0]->contactDetails->last_name ?? '')
                );

                // if($orderDetails[0]->organizationDetails['id'] == 2890){
                //     continue;
                // }

                $order_payment_status = $this->PaymentService->getPaymentStatus($PoReceipt->order_id)['payment_status'];
                $approval = $PoReceipt->is_approved == 1 ? 'Approved' : 'Not Approved';
                $PaymentIdUnique = 'PO'.str_pad(($PoReceipt->id), 6, "0", STR_PAD_LEFT);

                $orderPaymentsArray = $this->getAllPaymentsByOrderId($PoReceipt->order_id);

                $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
                array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);

                $TrasnsactionsArray[] = array('ID'=>$PoReceipt->id, 'Order'=> $PoReceipt->order_id, 'OrderNo'=>$orderDetails[0]->order_no, 'PaymentType'=>'PO', 'TeamName'=> $organization_name, 'NameonCard'=> 'N/A', 'CustomerName'=> $customer_name, 'checkStatus'=> $approval, 'Amount'=> $PoReceipt->amount, 'ProcessingFee'=> 0, 'OrderStatus'=> $order_payment_status, 'TransactionID'=> $PaymentIdUnique, 'PaymentDate'=> $PoReceipt->created_at,'checkFImage'=>$PoReceipt->receipt, 'OrderPayments'=>json_encode($orderPaymentsArray) ,'auto_generated'=>false, 'QBStatus'=>$getNormalQuickBooksStatus($PoReceipt->order_id, $PoReceipt->id, 'PO'));

            }

            foreach($onlinePayments as $onlinePayment)
            {
                $orderPaymentsArray = [];
                $orderDetails = Order::select('id', 'order_no', 'sub_total', 'artwork', 'discount_hidation', 'discountType', 'discount', 'sales_tax', 'shipping', 'order_total', 'organization_id', 'contact_id')->where('id',$onlinePayment->order_id)->with([
                    'organizationDetails:id,organization_name,sales_tax',
                    'contactDetails'
                ])->get();
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];

                $customer_name = trim(
                    (string) ($orderDetails[0]->contactDetails->first_name ?? '')
                    . ' '
                    . (string) ($orderDetails[0]->contactDetails->last_name ?? '')
                );

                // if($orderDetails[0]->organizationDetails['id'] == 2890){
                //     continue;
                // }

                $order_payment_status = $this->PaymentService->getPaymentStatus($onlinePayment->order_id)['payment_status'];

                $orderPaymentsArray = $this->getAllPaymentsByOrderId($onlinePayment->order_id);

                $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
                array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);
                $ProcessingFee = $onlinePayment->amount * 100 / 103;

                $TrasnsactionsArray[] = array('ID'=>$onlinePayment->id, 'Order'=> $onlinePayment->order_id,'OrderNo'=>$orderDetails[0]->order_no,'PaymentType'=>'Card','TeamName'=> $organization_name,'NameonCard'=> $onlinePayment->name_on_card,'CustomerName'=> ($onlinePayment->auto_generated == 1 ? '' : $customer_name),'checkStatus'=> 'Approved','Amount'=> $onlinePayment->amount,'ProcessingFee'=> $ProcessingFee,'OrderStatus'=> $order_payment_status,'TransactionID'=> $onlinePayment->transaction_id,'PaymentDate'=> $onlinePayment->created_at,'OrderPayments'=>json_encode($orderPaymentsArray),'auto_generated'=>$onlinePayment->auto_generated == 1 ? true : false, 'QBStatus'=>$onlinePayment->auto_generated == 1
                    ? (
                        ($fullySyncedStoreIds[(string) ($onlinePayment->store_id ?? '')] ?? false)
                            ? 'synced'
                            : null
                    )
                    : $getNormalQuickBooksStatus($onlinePayment->order_id, $onlinePayment->id, 'Card'));

            }

            foreach($checkPayments as $checkPayment)
            {
                $orderPaymentsArray = [];
                $orderDetails = Order::select('id', 'order_no', 'sub_total', 'artwork', 'discount_hidation', 'discountType', 'discount', 'sales_tax', 'shipping', 'order_total', 'organization_id', 'contact_id')->where('id',$checkPayment->order_id)->with([
                    'organizationDetails:id,organization_name,sales_tax',
                    'contactDetails'
                ])->get();
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];

                $customer_name = trim(
                    (string) ($orderDetails[0]->contactDetails->first_name ?? '')
                    . ' '
                    . (string) ($orderDetails[0]->contactDetails->last_name ?? '')
                );

                // if($orderDetails[0]->organizationDetails['id'] == 2890){
                //     continue;
                // }

                $order_payment_status = $this->PaymentService->getPaymentStatus($checkPayment->order_id)['payment_status'];
                // $approval = $checkPayment->is_approved == 1 ? 'Approved' : 'Not Approved';
                if (!$checkPayment) {
                    $approval = 'Not Approved';
                } elseif ($checkPayment->is_approved == 1) {
                    $approval = 'Approved';
                } elseif ($checkPayment->is_approved == 3) {
                    $approval = 'Rejected';
                } elseif ($checkPayment->is_approved == 0) {
                    $approval = 'Pending Approval';
                } else {
                    $approval = 'Not Approved';
                }
                $PaymentIdUnique = 'CHQ'.str_pad(($checkPayment->id), 6, "0", STR_PAD_LEFT);

                $orderPaymentsArray = $this->getAllPaymentsByOrderId($checkPayment->order_id);

                $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
                array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);

                $TrasnsactionsArray[] = array('ID'=>$checkPayment->id, 'Order'=> $checkPayment->order_id, 'OrderNo'=>$orderDetails[0]->order_no,'PaymentType'=>'Check', 'TeamName'=> $organization_name, 'NameonCard'=> 'N/A', 'CustomerName'=> $customer_name, 'checkStatus'=> $approval, 'Amount'=> $checkPayment->amount, 'ProcessingFee'=> 0, 'OrderStatus'=> $order_payment_status, 'TransactionID'=> $PaymentIdUnique, 'PaymentDate'=> $checkPayment->created_at, 'checkFImage'=>$checkPayment->check_front, 'checkBImage'=>$checkPayment->check_back, 'OrderPayments'=>json_encode($orderPaymentsArray) ,'auto_generated'=>false, 'QBStatus'=>$getNormalQuickBooksStatus($checkPayment->order_id, $checkPayment->id, 'Check'));

            }

            foreach($venmoPayments as $venmoPayment)
            {
                $orderPaymentsArray = [];
                $orderDetails = Order::select('id', 'order_no', 'sub_total', 'artwork', 'discount_hidation', 'discountType', 'discount', 'sales_tax', 'shipping', 'order_total', 'organization_id', 'contact_id')->where('id',$venmoPayment->order_id)->with([
                    'organizationDetails:id,organization_name,sales_tax',
                    'contactDetails'
                ])->get();
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];

                $customer_name = trim(
                    (string) ($orderDetails[0]->contactDetails->first_name ?? '')
                    . ' '
                    . (string) ($orderDetails[0]->contactDetails->last_name ?? '')
                );

                // if($orderDetails[0]->organizationDetails['id'] == 2890){
                //     continue;
                // }

                $order_payment_status = $this->PaymentService->getPaymentStatus($venmoPayment->order_id)['payment_status'];
                $approval = $venmoPayment->is_approved == 1 ? 'Approved' : 'Not Approved';
                $PaymentIdUnique = 'VNM'.str_pad(($venmoPayment->id), 6, "0", STR_PAD_LEFT);

                $orderPaymentsArray = $this->getAllPaymentsByOrderId($venmoPayment->order_id);

                $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
                array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);

                $TrasnsactionsArray[] = array('ID'=>$venmoPayment->id, 'Order'=> $venmoPayment->order_id, 'OrderNo'=>$orderDetails[0]->order_no,'PaymentType'=>'Venmo', 'TeamName'=> $organization_name, 'NameonCard'=> 'N/A', 'CustomerName'=> $customer_name, 'checkStatus'=> $approval, 'Amount'=> $venmoPayment->amount, 'ProcessingFee'=> 0, 'OrderStatus'=> $order_payment_status, 'TransactionID'=> $PaymentIdUnique, 'PaymentDate'=> $venmoPayment->created_at, 'checkFImage'=>$venmoPayment->venmo_receipt, 'OrderPayments'=>json_encode($orderPaymentsArray) ,'auto_generated'=>false, 'QBStatus'=>$getNormalQuickBooksStatus($venmoPayment->order_id, $venmoPayment->id, 'Venmo'));

            }

            foreach($paypalPayments as $paypalPayment)
            {
                $orderPaymentsArray = [];
                $orderDetails = Order::select('id', 'order_no', 'sub_total', 'artwork', 'discount_hidation', 'discountType', 'discount', 'sales_tax', 'shipping', 'order_total', 'organization_id', 'contact_id')->where('id',$paypalPayment->order_id)->with([
                    'organizationDetails:id,organization_name,sales_tax',
                    'contactDetails'
                ])->get();
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];

                $customer_name = trim(
                    (string) ($orderDetails[0]->contactDetails->first_name ?? '')
                    . ' '
                    . (string) ($orderDetails[0]->contactDetails->last_name ?? '')
                );

                // if($orderDetails[0]->organizationDetails['id'] == 2890){
                //     continue;
                // }

                $order_payment_status = $this->PaymentService->getPaymentStatus($paypalPayment->order_id)['payment_status'];
                $approval = $paypalPayment->is_approved == 1 ? 'Approved' : 'Not Approved';
                $PaymentIdUnique = 'PAYPAL'.str_pad(($paypalPayment->id), 6, "0", STR_PAD_LEFT);

                $orderPaymentsArray = $this->getAllPaymentsByOrderId($paypalPayment->order_id);

                $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
                array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);
                $ProcessingFee = $paypalPayment->amount * 100 / 103;

                $TrasnsactionsArray[] = array('ID'=>$paypalPayment->id, 'Order'=> $paypalPayment->order_id, 'OrderNo'=>$orderDetails[0]->order_no, 'PaymentType'=>'Paypal', 'TeamName'=> $organization_name, 'NameonCard'=> 'N/A', 'CustomerName'=> $customer_name, 'checkStatus'=> $approval, 'Amount'=> $paypalPayment->amount, 'ProcessingFee'=> $ProcessingFee, 'OrderStatus'=> $order_payment_status, 'TransactionID'=> $PaymentIdUnique, 'PaymentDate'=> $paypalPayment->created_at, 'checkFImage'=>$paypalPayment->paypal_receipt, 'OrderPayments'=>json_encode($orderPaymentsArray) ,'auto_generated'=>false, 'QBStatus'=>$getNormalQuickBooksStatus($paypalPayment->order_id, $paypalPayment->id, 'Paypal'));

            }


            $filtered = collect($TrasnsactionsArray);

            // -----------------------------------------------------------
            // 1. FILTER BY DATE RANGE (support missing start or end)
            // -----------------------------------------------------------

            if ($request->start_date || $request->end_date) {

                // Start date (Y-m-d)
                $start = $request->start_date
                    ? Carbon::parse($request->start_date)->toDateString()
                    : null;

                // End date (Y-m-d)
                $end = $request->end_date
                    ? Carbon::parse($request->end_date)->toDateString()
                    : null;

                $filtered = $filtered->filter(function ($item) use ($start, $end) {

                    // PaymentDate from array
                    $paymentDate = $item['PaymentDate'] instanceof \Carbon\Carbon
                        ? $item['PaymentDate']->toDateString()
                        : Carbon::parse($item['PaymentDate'])->toDateString();

                    // Only start_date
                    if ($start && !$end) {
                        return $paymentDate >= $start;
                    }

                    // Only end_date
                    if (!$start && $end) {
                        return $paymentDate <= $end;
                    }

                    // Both
                    if ($start && $end) {
                        return ($paymentDate >= $start && $paymentDate <= $end);
                    }

                    return true;
                });
            }



            // -----------------------------------------------------------
            // 2. FILTER BY PAYMENT TYPE
            // -----------------------------------------------------------

            if ($request->payment_type && $request->payment_type !== 'all') {
                $filtered = $filtered->filter(function ($item) use ($request) {
                    return trim($item['PaymentType']) === trim($request->payment_type);
                });
            }

            // -----------------------------------------------------------
            // 3. FILTER BY PAYMENT STATUS
            // -----------------------------------------------------------

            if ($request->payment_status && $request->payment_status !== 'all') {

                $status = (int) $request->payment_status;

                $filtered = $filtered->filter(function ($item) use ($status) {

                    $orderStatus = isset($item['OrderStatus']) ? (int) $item['OrderStatus'] : null;

                    if ($status === 1) {
                        return $orderStatus === 1;
                    }
                    else if ($status === 2) {
                        return $orderStatus === 2;
                    }
                    else {
                        return ($orderStatus !== 1 && $orderStatus !== 2);
                    }
                });
            }


            // -----------------------------------------------------------
            // 4. SORT FINAL RESULTS BY PaymentDate DESC
            // -----------------------------------------------------------

            $TransactionsArray = $filtered->values()->toArray();

            usort($TransactionsArray, function ($a, $b) {
                return strtotime($b['PaymentDate']) <=> strtotime($a['PaymentDate']);
            });

            if ($request->order_type && $request->order_type != 'all') {
                $type = $request->order_type;

                $TransactionsArray = array_filter($TransactionsArray, function ($order) use ($type) {
                    if ($type == 'TSR' && strpos($order['OrderNo'], 'TSR') !== false) {
                        return true;
                    }
                    if ($type == 'WL' && strpos($order['OrderNo'], 'WL') !== false) {
                        return true;
                    }
                    return false;
                });
            }

            /*
            |--------------------------------------------------------------------------
            | Collapsed StoreCardPayment search support
            |--------------------------------------------------------------------------
            |
            | DataTables only knows about the parent <tr> rows that exist when the
            | table is initialized. StoreCardPayment rows are loaded later by AJAX,
            | so the Blade needs to know whether this result set contains any
            | expandable/auto-generated parent rows.
            |
            | Do NOT decide this from order_type (TSR/TSRM/etc.). Search support
            | should work whenever expandable rows are actually present.
            */
            $TransactionsArray = array_values($TransactionsArray);

            $hasStorePaymentParents = collect($TransactionsArray)
                ->contains(function ($transaction) {
                    return !empty($transaction['auto_generated']);
                });

            return view('transactions.all-transactions', [
                'TrasnsactionsArray' => $TransactionsArray,
                'storeQuickBooksStatusMap' => $storeQuickBooksStatusMap,
                'storeCustomerNameMap' => $storeCustomerNameMap,
                'storeCustomerSearchIndex' => $storeCustomerSearchIndex,
                'hasStorePaymentParents' => $hasStorePaymentParents,
            ]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }
    public function tax_report(Request $request)
    {
        if (auth()->user()->can('view tax report')) {

            $orderType = $request->has('order_type') ? $request->order_type : 'all';

            $from_date = $request->start_date ? date('Y-m-d', strtotime($request->start_date)) : null;
            $to_date   = $request->end_date ? date('Y-m-d', strtotime($request->end_date)) : null;

            $ordersQuery = Order::with(['organizationDetails', 'userDetails', 'statusDetails'])
                        ->where('active', 1)->where('sales_tax', '>', 0)
                        ->whereNotIn('order_status_id', [1, 7])
                        ->whereHas('organizationDetails', function ($q) {
                            $q->where('sales_tax_active', 1);
                        });

            if ($orderType && $orderType != 'all') {
                if ($orderType == 'tsr') {
                    $ordersQuery->where('order_no', 'LIKE', 'TSR%');
                } else{
                    $ordersQuery->where('order_no', 'NOT LIKE', 'TSR%');
                }
            }

            if ($from_date && $to_date) {
                $ordersQuery->whereBetween('created_at', [$from_date . ' 00:00:00', $to_date . ' 23:59:59']);
            } elseif ($from_date) {
                $ordersQuery->whereDate('created_at', '>=', $from_date);
            } elseif ($to_date) {
                $ordersQuery->whereDate('created_at', '<=', $to_date);
            }

            $orders = $ordersQuery->orderBy('created_at', 'desc')->get();

            return view('pages.accounting.tax_report.index', [
                'orders'     => $orders
            ]);

        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }
    public function export(Request $request)
    {
        $orderType = $request->has('order_type') ? $request->order_type : 'all';

        $from_date = $request->start_date ? date('Y-m-d', strtotime($request->start_date)) : null;
        $to_date   = $request->end_date ? date('Y-m-d', strtotime($request->end_date)) : null;

        $ordersQuery = Order::with(['organizationDetails', 'userDetails', 'statusDetails'])
                    ->where('active', 1)->where('sales_tax', '>', 0)
                    ->whereNotIn('order_status_id', [1, 7])
                    ->whereHas('organizationDetails', function ($q) {
                        $q->where('sales_tax_active', 1);
                    });

        if ($orderType && $orderType != 'all') {
            if ($orderType == 'tsr') {
                $ordersQuery->where('order_no', 'LIKE', 'TSR%');
            } else{
                $ordersQuery->where('order_no', 'NOT LIKE', 'TSR%');
            }
        }

        if ($from_date && $to_date) {
            $ordersQuery->whereBetween('created_at', [$from_date . ' 00:00:00', $to_date . ' 23:59:59']);
        } elseif ($from_date) {
            $ordersQuery->whereDate('created_at', '>=', $from_date);
        } elseif ($to_date) {
            $ordersQuery->whereDate('created_at', '<=', $to_date);
        }

        $orders = $ordersQuery->orderBy('created_at', 'desc')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Tax Report');

        $headers = [
            'Order #', 'Organization Name', 'State', 'Sales Person',
            'Production Date', 'Order Status', 'Order Total', 'Sales Tax Rate(%)', 'Sales Tax ($)'
        ];
        $sheet->fromArray($headers, null, 'A1');

        $row = 2;
        $totalTax = 0;

        foreach ($orders as $order) {
            $orderTotal = $order->sub_total;
            $taxRate = $order->organizationDetails->sales_tax ?? 0;
            $salesTax = $order->sales_tax;

            $sheet->setCellValue("A{$row}", $order->order_no);
            $sheet->setCellValue("B{$row}", $order->organizationDetails->organization_name ?? 'N/A');
            $sheet->setCellValue("C{$row}", $order->organizationDetails->shipping_state ?? 'N/A');
            $sheet->setCellValue("D{$row}", $order->userDetails->name ?? 'N/A');
            $sheet->setCellValue("E{$row}", $order->production_date ? \Carbon\Carbon::parse($order->production_date)->format('m/d/Y') : 'N/A');
            $sheet->setCellValue("F{$row}", $order->statusDetails->status_name ?? 'N/A');
            $sheet->setCellValue("G{$row}", $orderTotal);
            $sheet->setCellValue("H{$row}", $taxRate);
            $sheet->setCellValue("I{$row}", $salesTax);

            $totalTax += $salesTax;
            $row++;
        }

        // Add total row for Sales Tax
        $sheet->setCellValue("H{$row}", "Total Sales Tax");
        $sheet->setCellValue("I{$row}", $totalTax);

        $sheet->getStyle("H{$row}:I{$row}")->getFont()->setBold(true);
        $sheet->getStyle("H{$row}:I{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle('A1:I'.$row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $writer = new Xlsx($spreadsheet);
        $fileName = 'tax_report_' . now()->format('Ymd_His') . '.xlsx';

        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]);
    }


    public function getOrderOrganization()
    {
        $orderDetails = Order::where('id',1)->with(['organizationDetails:id,organization_name,sales_tax'])->get();
        return $orderDetails;
    }

    public function checkPayments(){
        $checkPayments = CheckPayment::orderBy('created_at', 'DESC')->get();

        return view('transactions.check-transactions',['checkPayments'=>$checkPayments]);
    }
    public function refund_details(Request $request)
    {
        $request->validate([
            'payment_log_id' => 'required|integer',
            'order_id' => 'required|integer',
        ]);

        $paymentLog = PaymentLog::where(
                'id',
                $request->payment_log_id
            )
            ->where(
                'order_id',
                $request->order_id
            )
            ->where(
                'response_code',
                '1'
            )
            ->first();

        if (!$paymentLog) {
            return response()->json([
                'success' => false,
                'message' => 'Card payment record not found.',
            ], 404);
        }

        $order = Order::find(
            $request->order_id
        );

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.',
            ], 404);
        }

        $refundLogs = CardRefundLog::with('user')
            ->where(
                'order_id',
                $order->id
            )
            ->where(
                'transaction_id',
                $paymentLog->transaction_id
            )
            ->orderBy(
                'created_at',
                'DESC'
            )
            ->get();

        $successfulRefundGross =
            $refundLogs
                ->where(
                    'is_success',
                    1
                )
                ->sum('amount');

        /*
        * Existing refund behavior reduces PaymentLog.amount after a refund.
        * Current amount + successful refund logs reconstructs the original
        * card charge.
        */
        $remainingGross = round(
            (float) $paymentLog->amount,
            2
        );

        $originalGross = round(
            $remainingGross +
            (float) $successfulRefundGross,
            2
        );

        $refunds = [];

        foreach ($refundLogs as $refundLog) {
            $refunds[] = [
                'id' =>
                    $refundLog->id,

                'refund_amount' =>
                    round(
                        ((float) $refundLog->amount) *
                        100 /
                        103,
                        2
                    ),

                'gateway_amount' =>
                    round(
                        (float) $refundLog->amount,
                        2
                    ),

                'is_success' =>
                    (int) $refundLog->is_success,

                'user_name' =>
                    optional(
                        $refundLog->user
                    )->name
                    ?: (
                        $refundLog->user_id
                            ? 'User #' . $refundLog->user_id
                            : 'System'
                    ),

                'created_at' =>
                    $refundLog->created_at
                        ? $refundLog->created_at->format(
                            'm/d/Y H:i:s'
                        )
                        : '',
            ];
        }

        return response()->json([
            'success' => true,

            'payment' => [
                'payment_log_id' =>
                    (int) $paymentLog->id,

                'order_id' =>
                    (int) $order->id,

                'order_number' =>
                    $order->order_no
                        ?: $order->id,

                'gateway_transaction_id' =>
                    $paymentLog->transaction_id,

                'original_gross_amount' =>
                    $originalGross,

                'remaining_gross_amount' =>
                    $remainingGross,

                'max_refund_amount' =>
                    round(
                        $remainingGross *
                        100 /
                        103,
                        2
                    ),

                'successful_refunded_gross' =>
                    round(
                        (float) $successfulRefundGross,
                        2
                    ),
            ],

            'refunds' =>
                $refunds,
        ]);
    }

    public function refund_excess(Request $request)
    {
        $request->validate([
            'payment_log_id' =>
                'required|integer',

            'order_id' =>
                'required|integer',

            'transaction_method' =>
                'required|string',

            'amount' =>
                'required|numeric|min:0.01',
        ]);

        if (
            strcasecmp(
                (string) $request->transaction_method,
                'Card'
            ) !== 0
        ) {
            return response()->json([
                'success' => false,
                'message' =>
                    'Only card payments can be refunded from this action.',
            ], 422);
        }

        $paymentLog = PaymentLog::where(
                'id',
                $request->payment_log_id
            )
            ->where(
                'order_id',
                $request->order_id
            )
            ->where(
                'response_code',
                '1'
            )
            ->first();

        if (!$paymentLog) {
            return response()->json([
                'success' => false,
                'message' =>
                    'Card payment record not found.',
            ], 404);
        }

        $order = Order::find(
            $request->order_id
        );

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' =>
                    'Order not found.',
            ], 404);
        }

        $maxRefundAmount = round(
            ((float) $paymentLog->amount) *
            100 /
            103,
            2
        );

        $refundAmount = round(
            (float) $request->amount,
            2
        );

        if (
            $refundAmount >
            ($maxRefundAmount + 0.001)
        ) {
            return response()->json([
                'success' => false,
                'message' =>
                    'Refund amount cannot exceed $'
                    . number_format(
                        $maxRefundAmount,
                        2
                    )
                    . '.',
            ], 422);
        }

        $refundRequest = new Request([
            'order_id' =>
                $order->id,

            'transaction_id' =>
                $paymentLog->transaction_id,

            'amount' =>
                $refundAmount,
        ]);

        return app(
            PaymentRefundController::class
        )->refundTransaction(
            $refundRequest
        );
    }
}
