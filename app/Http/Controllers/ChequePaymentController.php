<?php

namespace App\Http\Controllers;

use Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\CheckPayment;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\SummaryAtPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\AccountsLog;
use App\Services\PaymentService;
use App\Services\NotificationBuilderService;
use App\Models\PaymentLog;
use App\Models\PaypalPayment;
use App\Models\VenmoPayment;
use App\Models\OtherPayment;
use App\Models\DebitEntry;
use App\Services\EmailNotificationBuilderService;

class ChequePaymentController extends Controller
{
    protected $PaymentService;

    public function __construct(PaymentService $PaymentService)
    {
        $this->PaymentService = $PaymentService;
    }
    public function check(Request $request) {

            // Remove commas from sub_total and orderTotal
            $subTotal = str_replace(',', '', $request->sub_total);
            $orderTotal = str_replace(',', '', $request->orderTotal);




        $checkFront = self::uploadCheckFront($request);
        $checkBack = self::uploadCheckBack($request);

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
            $CreditAccount->active = 0;
            $CreditAccount->note = 'Outstanding Invoice';
            $CreditAccount->save();
        }

        $checkPayment = new CheckPayment();
        $checkPayment->order_id = $request->order_id;
        $checkPayment->customer_paid_amount = $request->check_customer_paid_amount;
        $checkPayment->check_front = $checkFront;
        $checkPayment->check_back = $checkBack;
        $checkPayment->save();

        $order_for_rep = Order::where('id' , $request->order_id)->first();
        if($order_for_rep){
            $order_for_rep_id = $order_for_rep->user_id;
        }

        $summaryAtPayment = new SummaryAtPayment();
        $summaryAtPayment->order_id = $request->order_id;
        $summaryAtPayment->organization_id = $order_for_rep->organization_id;
        $summaryAtPayment->totalItemQty = $request->totalItemQty;
        $summaryAtPayment->subTotal = $subTotal;
        $summaryAtPayment->payment_type = 'Invoice Payment';
        $summaryAtPayment->shipping = $request->shipping;
        $summaryAtPayment->salesTax = $request->salesTax;
        $summaryAtPayment->artwork = $request->artwork;
        $summaryAtPayment->processingFee = $request->processingFee;
        $summaryAtPayment->orderTotal = $orderTotal;
        $summaryAtPayment->balancePayment = $request->balancePayment;
        $summaryAtPayment->payedAmount = $request->check_customer_paid_amount;
        $summaryAtPayment->method = 'Check';
        $summaryAtPayment->active = 0;
        $summaryAtPayment->transaction_id = 'CHK'.$checkPayment->id;
        $summaryAtPayment->created_at = Carbon::now()->addMinute();
        $summaryAtPayment->save();




        $users =  User::whereIn('id' , [53, 5, 63, 38, $order_for_rep_id, Auth::user()->id])->where('active', 1)->get();


        $shippingDetailsUrl = url("order_details/edit/{$request->order_id}/order") . '?active_tab=order';
        $paymentUrl = route('payment', [
            'orderId'       => $request->order_id,
            'totalItemQty'  => $request->totalItemQty,
            'sub_total'     => number_format((float) $subTotal, 2),
            'salesTax'      => number_format((float) $request->salesTax, 2),
            'shipping'      => number_format((float) $request->shipping, 2),
            'artwork'       => number_format((float) $request->artwork, 2),
            'processingFee' => number_format((float) $request->card_fee, 2),
            'orderTotal'    => number_format((float) $orderTotal, 2),
        ]);

        $checkRows = '
        <div style="display:flex; align-items:center; gap:16px; padding:12px 16px; font-size:13px; color:#1f2937; background:#f9fafb;">
            <span style="flex:0 0 140px;">
                <img src="' . e(asset($checkFront)) . '" alt="Check Front" style="width:90px; height:auto; border:1px solid #e5e7eb; border-radius:4px; cursor:zoom-in;"
                    onclick="(function(src){var o=document.getElementById(\'ncmInlineZoomOverlay\');if(!o){o=document.createElement(\'div\');o.id=\'ncmInlineZoomOverlay\';o.style.cssText=\'display:none;position:fixed;inset:0;background:rgba(0,0,0,0.85);z-index:99999;align-items:center;justify-content:center;cursor:zoom-out;\';var im=document.createElement(\'img\');im.style.cssText=\'max-width:90vw;max-height:88vh;border-radius:6px;box-shadow:0 20px 60px rgba(0,0,0,.5);\';o.appendChild(im);o.addEventListener(\'click\',function(){o.style.display=\'none\';});document.body.appendChild(o);}o.querySelector(\'img\').src=src;o.style.display=\'flex\';})(this.src)">
            </span>
            <span style="flex:0 0 140px;">
                <img src="' . e(asset($checkBack)) . '" alt="Check Back" style="width:90px; height:auto; border:1px solid #e5e7eb; border-radius:4px; cursor:zoom-in;"
                    onclick="(function(src){var o=document.getElementById(\'ncmInlineZoomOverlay\');if(!o){o=document.createElement(\'div\');o.id=\'ncmInlineZoomOverlay\';o.style.cssText=\'display:none;position:fixed;inset:0;background:rgba(0,0,0,0.85);z-index:99999;align-items:center;justify-content:center;cursor:zoom-out;\';var im=document.createElement(\'img\');im.style.cssText=\'max-width:90vw;max-height:88vh;border-radius:6px;box-shadow:0 20px 60px rgba(0,0,0,.5);\';o.appendChild(im);o.addEventListener(\'click\',function(){o.style.display=\'none\';});document.body.appendChild(o);}o.querySelector(\'img\').src=src;o.style.display=\'flex\';})(this.src)">
            </span>
            <span style="flex:0 0 140px; color:#374151;">' . e($checkPayment->created_at->format('m/d/Y')) . ' &bull; ' . e($checkPayment->created_at->format('H:i:s')) . '</span>
            <span style="flex:1 1 auto; font-weight:700; color:#16a34a; font-size:15px;">$' . e(number_format($request->check_customer_paid_amount, 2)) . '</span>
            <span style="flex:0 0 90px; text-align:right; margin-right: 27px;">
                <a href="' . e($paymentUrl) . '" target="_blank" rel="noopener noreferrer" style="color:#111827; text-decoration:none;" title="Go to payment">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </span>
        </div>';

        $builder = new NotificationBuilderService();

        $builder->sendNotification('key_payment_check_new', [
            '{order_no}'             => $request->order_id,
            '{shipping_details_url}' => $shippingDetailsUrl,
            '{organization_name}'    => $order_for_rep->organizationDetails->organization_name ?? '',
            '{check_rows}'           => $checkRows,
        ], [
            'order_id'                   => $request->order_id,
            'is_payment'                 => 1,
            'user_id'                    => Auth::user()->id ?? null,
            'check_payment_id'           => $checkPayment->id,
            'target_notification_field'  => 'key_payment_check_new',
            'new_notification'       => 1,
        ]);

        $encryptedId = Crypt::encrypt($checkPayment->id);
        $this->sendPaymentMail($request->order_id, $encryptedId, $request->check_customer_paid_amount, $checkFront, $checkBack, $paymentUrl);


        return redirect()->back()->withSuccess('Check uploaded Successfully!');
    }


    public function customerPaymentCheck(Request $request)
    {

        $subTotal   = str_replace(',', '', $request->sub_total);
        $orderTotal = str_replace(',', '', $request->orderTotal);

        $checkFront = self::uploadCheckFront($request);
        $checkBack  = self::uploadCheckBack($request);

        $AccLogOrder      = Order::where('id', $request->order_id)->first();
        $payment_of_order = $this->PaymentService->getPaymentStatus($request->order_id);

        if ($AccLogOrder->order_status_id == 1 && !AccountsLog::where('order_id', $request->order_id)->where('type', 0)->where('status', 1)->where('note', 'Outstanding Invoice')->exists()) {
            $CreditAccount = new AccountsLog();
            $CreditAccount->organization_id = $AccLogOrder->organization_id;
            $CreditAccount->amount = $payment_of_order['order_total'];
            $CreditAccount->order_id = $request->order_id;
            $CreditAccount->paid = 0;
            $CreditAccount->balance = 0;
            $CreditAccount->debit_balance = $payment_of_order['order_total'];
            $CreditAccount->type = 0;
            $CreditAccount->user_id = $AccLogOrder->user_id;
            $CreditAccount->status = 1;
            $CreditAccount->active = 0;
            $CreditAccount->note = 'Outstanding Invoice';
            $CreditAccount->save();
        }

        $checkPayment = new CheckPayment();
        $checkPayment->order_id = $request->order_id;
        $checkPayment->customer_paid_amount = $request->check_customer_paid_amount;
        $checkPayment->check_front = $checkFront;
        $checkPayment->check_back = $checkBack;
        $checkPayment->is_approved = 0; 
        $checkPayment->save();

        $orderData = Order::where('id', $request->order_id)->with('organizationDetails')->first();


        $summaryAtPayment = new SummaryAtPayment();
        $summaryAtPayment->order_id = $request->order_id;
        $summaryAtPayment->organization_id = $orderData->organization_id;
        $summaryAtPayment->totalItemQty = $request->totalItemQty;
        $summaryAtPayment->subTotal = $subTotal;
        $summaryAtPayment->shipping = $request->shipping;
        $summaryAtPayment->payment_type = 'Invoice Payment';
        $summaryAtPayment->salesTax = $request->salesTax;
        $summaryAtPayment->artwork = $request->artwork;
        $summaryAtPayment->processingFee = $request->processingFee;
        $summaryAtPayment->orderTotal = $orderTotal;
        $summaryAtPayment->balancePayment = $request->balancePayment;
        $summaryAtPayment->payedAmount = $request->check_customer_paid_amount;
        $summaryAtPayment->transaction_id = 'CHK' . $checkPayment->id;
        $summaryAtPayment->method = 'Check';
        $summaryAtPayment->active = 0;
        $summaryAtPayment->created_at = Carbon::now()->addMinute();
        $summaryAtPayment->save();


        $shippingDetailsUrl = url("order_details/edit/{$request->order_id}/order") . '?active_tab=order';
        $paymentUrl = route('payment', [
            'orderId'       => $request->order_id,
            'totalItemQty'  => $request->totalItemQty,
            'sub_total'     => number_format((float) $subTotal, 2),
            'salesTax'      => number_format((float) $request->salesTax, 2),
            'shipping'      => number_format((float) $request->shipping, 2),
            'artwork'       => number_format((float) $request->artwork, 2),
            'processingFee' => number_format((float) $request->card_fee, 2),
            'orderTotal'    => number_format((float) $orderTotal, 2),
        ]);

        $checkRows = '
        <div style="display:flex; align-items:center; gap:16px; padding:12px 16px; font-size:13px; color:#1f2937; background:#f9fafb;">
            <span style="flex:0 0 140px;">
                <img src="' . e(asset($checkFront)) . '" alt="Check Front" style="width:90px; height:auto; border:1px solid #e5e7eb; border-radius:4px; cursor:zoom-in;"
                    onclick="(function(src){var o=document.getElementById(\'ncmInlineZoomOverlay\');if(!o){o=document.createElement(\'div\');o.id=\'ncmInlineZoomOverlay\';o.style.cssText=\'display:none;position:fixed;inset:0;background:rgba(0,0,0,0.85);z-index:99999;align-items:center;justify-content:center;cursor:zoom-out;\';var im=document.createElement(\'img\');im.style.cssText=\'max-width:90vw;max-height:88vh;border-radius:6px;box-shadow:0 20px 60px rgba(0,0,0,.5);\';o.appendChild(im);o.addEventListener(\'click\',function(){o.style.display=\'none\';});document.body.appendChild(o);}o.querySelector(\'img\').src=src;o.style.display=\'flex\';})(this.src)">
            </span>
            <span style="flex:0 0 140px;">
                <img src="' . e(asset($checkBack)) . '" alt="Check Back" style="width:90px; height:auto; border:1px solid #e5e7eb; border-radius:4px; cursor:zoom-in;"
                    onclick="(function(src){var o=document.getElementById(\'ncmInlineZoomOverlay\');if(!o){o=document.createElement(\'div\');o.id=\'ncmInlineZoomOverlay\';o.style.cssText=\'display:none;position:fixed;inset:0;background:rgba(0,0,0,0.85);z-index:99999;align-items:center;justify-content:center;cursor:zoom-out;\';var im=document.createElement(\'img\');im.style.cssText=\'max-width:90vw;max-height:88vh;border-radius:6px;box-shadow:0 20px 60px rgba(0,0,0,.5);\';o.appendChild(im);o.addEventListener(\'click\',function(){o.style.display=\'none\';});document.body.appendChild(o);}o.querySelector(\'img\').src=src;o.style.display=\'flex\';})(this.src)">
            </span>
            <span style="flex:0 0 140px; color:#374151;">' . e($checkPayment->created_at->format('m/d/Y')) . ' &bull; ' . e($checkPayment->created_at->format('H:i:s')) . '</span>
            <span style="flex:1 1 auto; font-weight:700; color:#16a34a; font-size:15px;">$' . e(number_format($request->check_customer_paid_amount, 2)) . '</span>
            <span style="flex:0 0 90px; text-align:right;margin-right: 22px;">
                <a href="' . e($paymentUrl) . '" target="_blank" rel="noopener noreferrer" style="color:#111827; text-decoration:none;" title="Go to payment">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </span>
        </div>';

        $builder = new NotificationBuilderService();

        $builder->sendNotification('key_payment_check_new', [
            '{order_no}'             => $request->order_id,
            '{shipping_details_url}' => $shippingDetailsUrl,
            '{organization_name}'    => $orderData->organizationDetails->organization_name ?? '',
            '{check_rows}'           => $checkRows,
        ], [
            'order_id'                   => $request->order_id,
            'is_payment'                 => 1,
            'user_id'                    => Auth::user()->id ?? null,
            'check_payment_id'           => $checkPayment->id,
            'target_notification_field'  => 'key_payment_check_new',
            'new_notification'       => 1,
        ]);

        $encryptedId = Crypt::encrypt($checkPayment->id);
        $this->sendPaymentMail($request->order_id, $encryptedId, $request->check_customer_paid_amount, $checkFront, $checkBack, $paymentUrl);

        $customerEmailForReceipt = optional($orderData->contactDetails)->email;
        if ($customerEmailForReceipt) {
            $this->sendPaymentMailCustomerCheck($request->order_id, $checkPayment, $summaryAtPayment, $customerEmailForReceipt);
        }

        return redirect()->back()->withSuccess('Check uploaded Successfully!')->with('payment_success', 'Check uploaded Successfully!');
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

    public function checkApprove(Request $request) {
        $checkPayment = CheckPayment::find($request->check_payment_id);

        $sumOfPayments = $this->getSumOfPayments($checkPayment->order_id);

        $checkPayment->amount = $request->approve_amount;
        $checkPayment->is_approved = $request->is_approved;
        if($request->reject_reason){
            $checkPayment->reject_reason = $request->reject_reason;
        }else{
            $checkPayment->reject_reason = null;
        }
        $checkPayment->update();

        if($request->is_approved == 3){
            return redirect()->back()->withSuccess('Check Rejected Successfully!');
        }else{
            $summaryAtPaymentrow = SummaryAtPayment::where('transaction_id', 'CHK' . $request->check_payment_id)->first();

            if ($summaryAtPaymentrow) {
                $summaryAtPaymentrow->active = 1;
                $summaryAtPaymentrow->created_at = Carbon::now(); // Set created_at to the current timestamp
                $summaryAtPaymentrow->save(); // Use save() instead of update() to persist all changes
            }

            AccountsLog::where('order_id', $checkPayment->order_id)->where('type', 0)->where('status', 1)->where('note', 'Outstanding Invoice')->where('active', 0)->update(['active' => 1]);

            $orderDetails = Order::where('id', $checkPayment->order_id)->first();

            if ($orderDetails && ($sumOfPayments + ($checkPayment->amount)) > $orderDetails->order_total) {
                $debitEntry = new DebitEntry();
                $debitEntry->organization_id = $orderDetails->organization_id;
                $debitEntry->order_id = $orderDetails->id;
                $debitEntry->transaction_id = $checkPayment->id;
                $debitEntry->transaction_type = 'CHECK';
                $debitEntry->amount = ($sumOfPayments + ($checkPayment->amount)) - $orderDetails->order_total;
                $debitEntry->note = 'Exess From CHQ'.$checkPayment->id.' (#'.$orderDetails->order_no.')';
                $debitEntry->created_at = $checkPayment->created_at->copy()->addMinutes(1);
                $debitEntry->save();
            }

            return redirect()->back()->withSuccess('Check Approved Successfully!');
        }

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

    // var $smptEncryption = 'TLS';
    // var $smptPort = '587';
    // var $smptHost = 'smtp-mail.outlook.com';
    // var $username = 'info@encorebrand.com';
    // var $password = 'EncoreCus!0077';

    // var $smptEncryption = 'SSL';
    // var $smptPort = '465';
    // var $smptHost = 'server.encr.co';
    // var $username = 'info@encr.co';
    // var $password = 'Encr.co@ec123';


    public function sendPaymentMail($orderNo, $encryptedId, $paidAmount, $checkFront, $checkBack, $paymentUrl){

        $order = Order::with('organizationDetails', 'contactDetails')->find($orderNo);
        $organizationName = optional($order->organizationDetails)->organization_name ?? '';

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_checkpayment', [
            'orderId'            => $orderNo,
            'order_number'       => $orderNo,
            'organization_name'  => $organizationName,
            'customer_details'   => trim(optional($order->contactDetails)->first_name . ' ' . optional($order->contactDetails)->last_name),
            'paid_date'          => \Carbon\Carbon::now()->format('m/d/Y'),
            'paid_time'          => \Carbon\Carbon::now()->format('H:i:s'),
            'paid_amount'        => number_format((float) $paidAmount, 2),
            'check_front'        => url($checkFront),
            'check_back'         => url($checkBack),
            'order_link'         => url("order_details/edit/{$orderNo}/order") . '?active_tab=order',
            'payment_link'       => $paymentUrl,
            'download_link'      => route('customer_payment_download.check', ['sourceId' => $encryptedId]),
        ]);

        return true;
    }

    public function sendPaymentMailCustomerCheck($order, $checkPayment, $summaryAtPayment, $mail)
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
            logger()->error('sendPaymentMailCustomerCheck: order not found', ['order' => $order]);
            return false;
        }

        if (!$orderModel->relationLoaded('orderItems')) {
            $orderModel->load([
                'orderItems' => function ($query) {
                    $query->with(['productDetails', 'statusDetails'])->where('is_studio_item', 0);
                },
            ]);
        }

        $organizationName = optional($orderModel->organizationDetails)->organization_name ?? '';
        $customerName     = trim(optional($orderModel->contactDetails)->first_name . ' ' . optional($orderModel->contactDetails)->last_name);

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

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_customer_payment_receipt_check', [
            'custom_email'       => $mail,
            'order_number'       => $orderModel->order_no,
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
            'order_items'        => $orderItemsList,
            'check_front_url'    => url($checkPayment->check_front),
            'check_back_url'     => url($checkPayment->check_back),
            'transaction_id'     => $summaryAtPayment->transaction_id ?? ('CHK' . $checkPayment->id),
            'paid_amount'        => number_format((float) ($checkPayment->customer_paid_amount ?? 0), 2),
            'order_total'        => number_format((float) ($orderModel->order_total ?? 0), 2),
            'balance_remaining'  => number_format((float) ($summaryAtPayment->balancePayment ?? 0), 2),
            'paid_date'          => optional($checkPayment->created_at)->format('m-d-Y') ?? now()->format('m-d-Y'),
        ]);

        return true;
        
    }
}
