<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\SummaryAtPayment;
use App\Models\PaymentLog;
use App\Models\CheckPayment;
use App\Models\PaypalPayment;
use App\Models\VenmoPayment;
use App\Models\OtherPayment;
use App\Models\Order;
use App\Models\User;
use App\Models\Notification;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use App\Models\AccountsLog;
use App\Services\PaymentService;
use App\Services\NotificationBuilderService;

class OtherPaymentController extends Controller
{
    protected $PaymentService;

    public function __construct(PaymentService $PaymentService)
    {
        $this->PaymentService = $PaymentService;
    }
    public function other(Request $request) {

        $subTotal = str_replace(',', '', $request->sub_total);
        $orderTotal = str_replace(',', '', $request->orderTotal);

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

        $OtherProofment = self::uploadProofment($request);
        $OtherProofmentback = self::uploadProofmentback($request);

        $otherPayment = new OtherPayment();
        $otherPayment->order_id = $request->order_id;
        $otherPayment->amount = $request->other_customer_paid_amount;
        $otherPayment->document_url = $OtherProofment;
        $otherPayment->document_url_back = $OtherProofmentback;
        $otherPayment->description = $request->payment_description;
        $otherPayment->note = 'Paid by user '.Auth::user()->name;
        $otherPayment->save();

        $order_for_rep = Order::where('id' , $request->order_id)->first();
        if($order_for_rep){
            $order_for_rep_id = $order_for_rep->user_id;
        }

        $summaryAtPayment = new SummaryAtPayment();
        $summaryAtPayment->order_id = $request->order_id;
        $summaryAtPayment->organization_id = $order_for_rep->organization_id;
        $summaryAtPayment->totalItemQty = $request->totalItemQty;
        $summaryAtPayment->subTotal = $request->sub_total;
        $summaryAtPayment->shipping = $request->shipping;
        $summaryAtPayment->payment_type = 'Invoice Payment';
        $summaryAtPayment->salesTax = $request->salesTax;
        $summaryAtPayment->artwork = $request->artwork;
        $summaryAtPayment->processingFee = 0.00;
        $summaryAtPayment->orderTotal = $orderTotal;
        $summaryAtPayment->balancePayment =(float) str_replace(',', '', $request->balancePayment) ?? 0.00;
        $summaryAtPayment->payedAmount = $request->other_customer_paid_amount;
        $summaryAtPayment->method = 'Other';
        $summaryAtPayment->created_at = Carbon::now()->addMinute();
        $summaryAtPayment->save();


        $shippingDetailsUrl = url("order_details/edit/{$request->order_id}/order") . '?active_tab=order';
        $paymentUrl         = url('customer_payment') . '?orderId=' . $request->order_id;

        $otherRows = '
        <div style="display:grid; grid-template-columns:140px 140px 140px 1fr 90px; align-items:center; padding:12px 16px; font-size:13px; color:#1f2937; background:#f9fafb;">
            <div>
                <img src="' . e(asset($OtherProofment)) . '" alt="Proof Front" style="width:90px; height:auto; border:1px solid #e5e7eb; border-radius:4px; cursor:zoom-in;"
                    onclick="(function(src){var o=document.getElementById(\'ncmInlineZoomOverlay\');if(!o){o=document.createElement(\'div\');o.id=\'ncmInlineZoomOverlay\';o.style.cssText=\'display:none;position:fixed;inset:0;background:rgba(0,0,0,0.85);z-index:99999;align-items:center;justify-content:center;cursor:zoom-out;\';var im=document.createElement(\'img\');im.style.cssText=\'max-width:90vw;max-height:88vh;border-radius:6px;box-shadow:0 20px 60px rgba(0,0,0,.5);\';o.appendChild(im);o.addEventListener(\'click\',function(){o.style.display=\'none\';});document.body.appendChild(o);}o.querySelector(\'img\').src=src;o.style.display=\'flex\';})(this.src)">
            </div>
            <div>
                <img src="' . e(asset($OtherProofmentback)) . '" alt="Proof Back" style="width:90px; height:auto; border:1px solid #e5e7eb; border-radius:4px; cursor:zoom-in;"
                    onclick="(function(src){var o=document.getElementById(\'ncmInlineZoomOverlay\');if(!o){o=document.createElement(\'div\');o.id=\'ncmInlineZoomOverlay\';o.style.cssText=\'display:none;position:fixed;inset:0;background:rgba(0,0,0,0.85);z-index:99999;align-items:center;justify-content:center;cursor:zoom-out;\';var im=document.createElement(\'img\');im.style.cssText=\'max-width:90vw;max-height:88vh;border-radius:6px;box-shadow:0 20px 60px rgba(0,0,0,.5);\';o.appendChild(im);o.addEventListener(\'click\',function(){o.style.display=\'none\';});document.body.appendChild(o);}o.querySelector(\'img\').src=src;o.style.display=\'flex\';})(this.src)">
            </div>
            <div style="color:#374151;">' . e($otherPayment->created_at->format('m/d/Y')) . ' &bull; ' . e($otherPayment->created_at->format('H:i:s')) . '</div>
            <div style="font-weight:700; color:#16a34a; font-size:15px;">$' . e(number_format($request->other_customer_paid_amount, 2)) . '</div>
            <div style="text-align:center;">
                <a href="' . e($paymentUrl) . '" target="_blank" rel="noopener noreferrer" style="color:#111827; text-decoration:none;" title="Go to payment">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
        </div>';

        $builder = new NotificationBuilderService();

        $builder->sendNotification('key_otherpayment_payment_new', [
            '{order_no}'             => $request->order_id,
            '{shipping_details_url}' => $shippingDetailsUrl,
            '{organization_name}'    => $order_for_rep->organizationDetails->organization_name ?? '',
            '{other_rows}'           => $otherRows,
        ], [
            'order_id'                   => $request->order_id,
            'is_payment'                 => 1,
            'user_id'                    => Auth::user()->id ?? null,
            'other_payment_id'           => $otherPayment->id,
            'target_notification_field'  => 'key_otherpayment_payment_new',
            'new_notification'           => 1,
        ]);

        return redirect()->back()->withSuccess('Other payment updated Successfully!');
    }

    // public function uploadProofment(Request $request) {
    //     $file = $request->file('other_front');

    //     $destinationPath = 'uploads/other payments';
    //     $fileName = Carbon::now()->format('YmdHsi').'_'.$request->order_id.'_other_front.'.$file->getClientOriginalExtension();
    //     $file->move($destinationPath, $fileName);

    //     return $destinationPath.'/'.$fileName;
    // }
 public function uploadProofment(Request $request) {

        $filePath = null;

       if ($request->hasFile('other_front') && $request->file('other_front')->isValid()) {
        $file = $request->file('other_front');

        $destinationPath = 'uploads/other payments';
        $fileName = Carbon::now()->format('YmdHsi').'_'.$request->order_id.'_other_front.'.$file->getClientOriginalExtension();
        $file->move($destinationPath, $fileName);

        return $destinationPath.'/'.$fileName;
  }

return response()->json([
        'message' => 'Proofment processed successfully',
        'filePath' => $filePath, // This will be null if no file was uploaded
    ], 200);

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

return response()->json([
    'message' => 'Proofment processed successfully',
    'filePath' => $filePath, // This will be null if no file was uploaded
], 200);

}
    public function order_mark_as_paid(Request $request){

        $orderIdsString = $request->invoices;
        $orderIds = explode(',', $orderIdsString);
        $orderIds = array_filter($orderIds);

        foreach ($orderIds as $orderId) {

            $totalItemQty = OrderItem::where('order_id', $orderId)->where('active', 1)->sum('qty');

            $order = Order::find($orderId);

            $cardPayment = PaymentLog::where('order_id', $orderId)->sum('amount');
            $checkPayment = CheckPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
            $otherPayment = OtherPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
            $paypalPayement = PaypalPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
            $venmoPayment = VenmoPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');

            if($cardPayment > 0 && $paypalPayement > 0){
                $payment = round(((($cardPayment + $paypalPayement) * 100)/103),2) + $checkPayment + $venmoPayment + $otherPayment;

            } else if ($cardPayment > 0 && $paypalPayement == 0) {
                $payment = round(($cardPayment * 100)/103,2) + $checkPayment + $venmoPayment + $otherPayment;

            } else if ($cardPayment == 0 && $paypalPayement > 0) {
                $payment = $checkPayment + round((($paypalPayement * 100)/103),2) + $venmoPayment + $otherPayment;

            } else {
                $payment = round(($cardPayment + $checkPayment + $paypalPayement + $venmoPayment + $otherPayment),2);
            }

            $balnceToBePaid = 0;
            $processingFee = 0;
            $orderTotal = $order->order_total;

            if ($payment < round($order->order_total, 2) && $payment > 0) {
                $balnceToBePaid = $order->order_total - $payment;
                $processingFee = round(($cardPayment + $paypalPayement)*3/103 , 2);

            } else {
                $processingFee = 0;
                $balnceToBePaid = $order->order_total;
            }

            $sub_total = $order->sub_total;
            $salesTax = $order->sales_tax;
            $shipping = $order->shipping;
            $artwork = $order->artwork;
            $processingFee = $processingFee;
            $orderTotal = $order->order_total + $processingFee;
            $balancePayment = $balnceToBePaid;

            if($balancePayment > 0){

                $summaryAtPayment = new SummaryAtPayment();
                $summaryAtPayment->order_id = $orderId;
                $summaryAtPayment->organization_id = $order->organization_id;
                $summaryAtPayment->totalItemQty = $totalItemQty;
                $summaryAtPayment->subTotal = $sub_total;
                $summaryAtPayment->payment_type = 'Bulk Payment';
                $summaryAtPayment->shipping = $shipping;
                $summaryAtPayment->salesTax = $salesTax;
                $summaryAtPayment->artwork = $artwork;
                $summaryAtPayment->processingFee = $processingFee;
                $summaryAtPayment->orderTotal = $orderTotal;
                $summaryAtPayment->balancePayment = $balancePayment;
                $summaryAtPayment->payedAmount = $balancePayment;
                $summaryAtPayment->method = 'Other';
                $summaryAtPayment->save();

                if (!empty($request->file('payment_image'))) {

                    $file = $request->file('payment_image');
                    $destinationPath = 'uploads/other_payments';

                    // Ensure the directory exists
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }

                    // Build the file name
                    $fileName = Carbon::now()->format('YmdHsi') . '_' . $orderId . '_other_front.' . $file->getClientOriginalExtension();

                    try {
                        // Move the file to the destination path
                        $file->move($destinationPath, $fileName);
                        $proofment_url = $destinationPath . '/' . $fileName;
                    } catch (\Exception $e) {
                        // Log the error for debugging purposes
                        \Log::error('File upload error: ' . $e->getMessage());
                        $proofment_url = ''; // Set proofment URL as empty if an error occurs
                    }

                } else {
                    $proofment_url = '';
                }

                $otherPayment = new OtherPayment();
                $otherPayment->order_id = $orderId;
                $otherPayment->amount = $balancePayment;
                $otherPayment->document_url = $proofment_url;
                $otherPayment->description = $request->description;
                $otherPayment->note = 'Paid by user '.Auth::user()->name;
                $otherPayment->save();
            }

        }
    }
}
