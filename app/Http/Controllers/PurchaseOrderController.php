<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseorderReceipt;
use App\Models\Order;
use App\Models\User;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use App\Models\SummaryAtPayment;
use App\Models\AccountsLog;
use App\Services\EmailNotificationBuilderService;
use Mail;
use App\Services\PaymentService;
use App\Services\NotificationBuilderService;
use Illuminate\Support\Facades\Auth;




class PurchaseOrderController extends Controller
{
    protected $PaymentService;

    public function __construct(PaymentService $PaymentService)
    {
        $this->PaymentService = $PaymentService;
    }
    public function customerPaymentPurchaseOrder(Request $request)
    {
        $PoReceipt = self::uploadVenmoReceipt($request);

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
            $CreditAccount->user_id = Auth::user()->id ?? $AccLogOrder->user_id;
            $CreditAccount->status = 1;
            $CreditAccount->note = 'Outstanding Invoice';
            $CreditAccount->save();
        }

        $PurchaseorderReceipt = new PurchaseorderReceipt();
        $PurchaseorderReceipt->order_id = $request->order_id;
        $PurchaseorderReceipt->amount = (float) str_replace(',', '', $request->orderTotal);
        $PurchaseorderReceipt->receipt = $PoReceipt;
        $PurchaseorderReceipt->amount = 0;
        $PurchaseorderReceipt->save();

        $summaryAtPayment = new SummaryAtPayment();
        $summaryAtPayment->order_id = $request->order_id;
        $summaryAtPayment->organization_id = $AccLogOrder->organization_id;
        $summaryAtPayment->payment_type = 'Outstanding Payment';
        $summaryAtPayment->orderTotal = (float) str_replace(',', '', $request->orderTotal);
        $summaryAtPayment->balancePayment =  (float) str_replace(',', '', $request->orderTotal);
        $summaryAtPayment->transaction_id = 'PO'.$PurchaseorderReceipt->id;
        $summaryAtPayment->method = 'Purchase Order';
        $summaryAtPayment->active = 0;
        $summaryAtPayment->created_at = Carbon::now()->addMinute();
        $summaryAtPayment->save();

        $order_for_rep = Order::where('id' , $request->order_id)->first();
        if($order_for_rep){
            $order_for_rep_id = $order_for_rep->user_id;
        }

        $users =  User::whereIn('id' , [ 5, 63, 38, $order_for_rep_id])->where('active', 1)->get();
        // $users =  User::whereIn('id' , [1])->where('active', 1)->get();

     
        $shippingDetailsUrl = url("order_details/edit/{$request->order_id}/order") . '?active_tab=order';
        $orderTotal = (float) str_replace(',', '', $request->orderTotal);

        $shippingDetailsUrl = url("order_details/edit/{$request->order_id}/order") . '?active_tab=order';
        $paymentUrl = route('payment', [
            'orderId'       => $request->order_id,
            'totalItemQty'  => $request->totalItemQty ?? 0,
            'sub_total'     => number_format(0, 2),
            'salesTax'      => number_format((float) $request->salesTax, 2),
            'shipping'      => number_format((float) $request->shipping, 2),
            'artwork'       => number_format((float) $request->artwork, 2),
            'processingFee' => number_format(0, 2),
            'orderTotal'    => number_format($orderTotal, 2),
        ]);

        $poRows = '
        <div style="display:flex; align-items:center; justify-content:space-between; padding:12px 16px; font-size:13px; color:#1f2937; background:#f9fafb;">
            <span style="flex:0 0 140px;">
                <img src="' . e(asset($PoReceipt)) . '" alt="PO Receipt" style="width:90px; height:auto; border:1px solid #e5e7eb; border-radius:4px; cursor:zoom-in;"
                    onclick="(function(src){var o=document.getElementById(\'ncmInlineZoomOverlay\');if(!o){o=document.createElement(\'div\');o.id=\'ncmInlineZoomOverlay\';o.style.cssText=\'display:none;position:fixed;inset:0;background:rgba(0,0,0,0.85);z-index:99999;align-items:center;justify-content:center;cursor:zoom-out;\';var im=document.createElement(\'img\');im.style.cssText=\'max-width:90vw;max-height:88vh;border-radius:6px;box-shadow:0 20px 60px rgba(0,0,0,.5);\';o.appendChild(im);o.addEventListener(\'click\',function(){o.style.display=\'none\';});document.body.appendChild(o);}o.querySelector(\'img\').src=src;o.style.display=\'flex\';})(this.src)">
            </span>
            <span style="flex:0 0 140px; color:#374151;">' . e($PurchaseorderReceipt->created_at->format('m/d/Y')) . ' &bull; ' . e($PurchaseorderReceipt->created_at->format('H:i:s')) . '</span>
            <span style="flex:0 0 90px; text-align:center;">
                <a href="' . e($paymentUrl) . '" target="_blank" rel="noopener noreferrer" style="color:#111827; text-decoration:none;" title="Go to payment">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </span>
        </div>';

        $builder = new NotificationBuilderService();

        $builder->sendNotification('key_purchase_order_new', [
            '{order_no}'             => $request->order_id,
            '{shipping_details_url}' => $shippingDetailsUrl,
            '{organization_name}'    => $order_for_rep->organizationDetails->organization_name ?? '',
            '{po_rows}'              => $poRows,
        ], [
            'order_id'                   => $request->order_id,
            'is_payment'                 => 1,
            'user_id'                    => Auth::user()->id ?? null,
            'purchase_order_id'          => $PurchaseorderReceipt->id,
            'target_notification_field'  => 'key_purchase_order_new',
            'new_notification'           => 1,
        ]);

        $padiAmount = 0;
        $encryptedId = Crypt::encrypt($PurchaseorderReceipt->id);
        $this->sendPaymentMail($request->order_id, $request->order_no, $PoReceipt);

        return redirect()->back()->withSuccess('purchase order receipt has been successfully submitted!')->with('po_order_success', 'Venmo uploaded Successfully!');;
    }
    public function uploadVenmoReceipt(Request $request) {
        $file = $request->file('PurchaseOrder_Receipt');

        $destinationPath = 'uploads/purchase_order';

        $fileName = Carbon::now()->format('YmdHsi').'_'.$request->order_id.'PurchaseOrder_Receipt.'.$file->getClientOriginalExtension();
        $file->move($destinationPath, $fileName);

        return $destinationPath.'/'.$fileName;
    }

    public function sendPaymentMail($orderId, $orderNo, $poReceipt){

        $order = Order::with(['organizationDetails', 'contactDetails'])->find($orderId);
        $organizationName = optional($order->organizationDetails)->organization_name ?? '';
        $customerDetails = trim(optional($order->contactDetails)->first_name . ' ' . optional($order->contactDetails)->last_name);

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_payment_purchaseorder', [
            'orderId'            => $orderId,
            'order_number'       => $order->order_no ?? $orderNo,
            'organization_name'  => $organizationName,
            'customer_details'   => $customerDetails,
            'po_receipt'         => asset($poReceipt),
            'submitted_date'     => \Carbon\Carbon::now()->format('m/d/Y'),
            'submitted_time'     => \Carbon\Carbon::now()->format('H:i:s'),
            'order_link'         => url("order_details/edit/{$orderId}/order") . '?active_tab=order',
            'payment_link'       => route('payment', ['orderId' => $orderId]),
        ]);

        return true;
    }
        
    public function approvepo($id){
        $purchaseorderReceipt = PurchaseorderReceipt::find($id);

        // Update the status or any other field
        $purchaseorderReceipt->is_approved = 1; // Adjust the field and value as needed
        $purchaseorderReceipt->save();

        $summaryAtPaymentrow = SummaryAtPayment::where('transaction_id', 'PO' . $id)->first();

        if ($summaryAtPaymentrow) {
            $summaryAtPaymentrow->active = 1;
            $summaryAtPaymentrow->created_at = Carbon::now(); // Set created_at to the current timestamp
            $summaryAtPaymentrow->save(); // Use save() instead of update() to persist all changes
        }
        // Return a success response
        return response()->json(['success'=>true,'message' => 'Purchase order approved successfully']);
    }
    public function customerPaymentDownloadpo(Request $request){
        $decryptedId = Crypt::decrypt($request->sourceId);
        $po = PurchaseorderReceipt::find($decryptedId);

        $filename = $po->order->order_no.'-po-receipt-image.jpg';
        $tempImage = tempnam(sys_get_temp_dir(), $filename);
        $url = \URL::to('').'/'.$po->receipt;

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

    public function poApproveReject(Request $request)
    {
        $purchaseorderReceipt = PurchaseorderReceipt::find($request->purchase_order_id);

        $purchaseorderReceipt->is_approved = $request->is_approved;
        if ($request->reject_reason) {
            $purchaseorderReceipt->reject_reason = $request->reject_reason;
        } else {
            $purchaseorderReceipt->reject_reason = null;
        }
        $purchaseorderReceipt->amount = 0;
        $purchaseorderReceipt->save();

        if ($request->is_approved == 3) {
            return response()->json(['status' => true, 'message' => 'Purchase order rejected successfully']);
        }

        $summaryAtPaymentrow = SummaryAtPayment::where('transaction_id', 'PO' . $purchaseorderReceipt->id)->first();

        if ($summaryAtPaymentrow) {
            $summaryAtPaymentrow->active = 1;
            $summaryAtPaymentrow->created_at = Carbon::now();
            $summaryAtPaymentrow->save();
        }

        return response()->json(['status' => true, 'message' => 'Purchase order approved successfully']);
    }

    public function poApproveRejectByPaymentPage(Request $request)
    {
        $purchaseorderReceipt = PurchaseorderReceipt::find($request->purchase_order_id);

        if (!$purchaseorderReceipt) {
            return redirect()->back()->withErrors('Purchase order not found!');
        }

        $purchaseorderReceipt->is_approved = $request->is_approved;

        if ($request->reject_reason) {
            $purchaseorderReceipt->reject_reason = $request->reject_reason;
        } else {
            $purchaseorderReceipt->reject_reason = null;
        }
        $purchaseorderReceipt->amount = 0;
        $purchaseorderReceipt->save();

        if ($request->is_approved == 3) {
            return redirect()->back()->withSuccess('Purchase order rejected successfully!');
        }

        $summaryAtPaymentrow = SummaryAtPayment::where('transaction_id', 'PO' . $purchaseorderReceipt->id)->first();

        if ($summaryAtPaymentrow) {

            $summaryAtPaymentrow->active = 1;
            $summaryAtPaymentrow->created_at = Carbon::now();
            $summaryAtPaymentrow->save();
        }

        return redirect()->back()->withSuccess('Purchase order approved successfully!');
    }
}
