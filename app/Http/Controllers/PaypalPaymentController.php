<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Order;
use App\Models\Notification;
use Illuminate\Http\Request;
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
use App\Services\NotificationBuilderService;

class PaypalPaymentController extends Controller
{
    protected $PaymentService;
    public function __construct(Request $request , PaymentService $PaymentService) {
        //$this->middleware('auth'); // later enable it when needed user login while payment
        $this->PaymentService = $PaymentService;
    }
    public function paypal(Request $request) {
        // Remove commas from sub_total and orderTotal
        $subTotal = str_replace(',', '', $request->sub_total);
        $orderTotal = str_replace(',', '', $request->orderTotal);



        $paypalReceipt = self::uploadPaypalReceipt($request);

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

        $paypalPayment = new PaypalPayment();
        $paypalPayment->order_id = $request->order_id;
        $paypalPayment->amount = $request->amount;
        $paypalPayment->paypal_receipt = $paypalReceipt;
        $paypalPayment->save();

        $summaryAtPayment = new SummaryAtPayment();
        $summaryAtPayment->order_id = $request->order_id;
        $summaryAtPayment->organization_id = $AccLogOrder->organization_id;
        $summaryAtPayment->totalItemQty = $request->totalItemQty;
        $summaryAtPayment->subTotal = $subTotal; // Use the cleaned value
        $summaryAtPayment->shipping = $request->shipping;
        $summaryAtPayment->salesTax = $request->salesTax;
        $summaryAtPayment->payment_type = 'Invoice Payment';
        $summaryAtPayment->artwork = $request->artwork;
        $summaryAtPayment->processingFee = $request->paypal_fee;
        $summaryAtPayment->orderTotal = $orderTotal; // Use the cleaned value
        $summaryAtPayment->balancePayment = (float) str_replace(',', '', $request->balancePayment);
        $summaryAtPayment->payedAmount = $request->amount;
        $summaryAtPayment->method = 'Paypal';
        $summaryAtPayment->active = 0;
        $summaryAtPayment->transaction_id = 'PAYPAL'.$paypalPayment->id;
        $summaryAtPayment->created_at = Carbon::now()->addMinute();
        $summaryAtPayment->save();

        $orderData = Order::where('id' , $request->order_id)->first();
        


       
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

        $paypalRows = '
        <div style="display:flex; align-items:center; gap:16px; padding:12px 16px; font-size:13px; color:#1f2937; background:#f9fafb;">
            <span style="flex:0 0 140px;">
                <img src="' . e(asset($paypalReceipt)) . '" alt="Paypal Receipt" style="width:90px; height:auto; border:1px solid #e5e7eb; border-radius:4px; cursor:zoom-in;"
                    onclick="(function(src){var o=document.getElementById(\'ncmInlineZoomOverlay\');if(!o){o=document.createElement(\'div\');o.id=\'ncmInlineZoomOverlay\';o.style.cssText=\'display:none;position:fixed;inset:0;background:rgba(0,0,0,0.85);z-index:99999;align-items:center;justify-content:center;cursor:zoom-out;\';var im=document.createElement(\'img\');im.style.cssText=\'max-width:90vw;max-height:88vh;border-radius:6px;box-shadow:0 20px 60px rgba(0,0,0,.5);\';o.appendChild(im);o.addEventListener(\'click\',function(){o.style.display=\'none\';});document.body.appendChild(o);}o.querySelector(\'img\').src=src;o.style.display=\'flex\';})(this.src)">
            </span>
            <span style="flex:0 0 140px; color:#374151;">' . e($paypalPayment->created_at->format('m/d/Y')) . ' &bull; ' . e($paypalPayment->created_at->format('H:i:s')) . '</span>
            <span style="flex:1 1 auto; font-weight:700; color:#16a34a; font-size:15px;">$' . e(number_format($request->amount, 2)) . '</span>
            <span style="flex:0 0 90px; text-align:right;">
                <a href="' . e($paymentUrl) . '" target="_blank" rel="noopener noreferrer" style="color:#111827; text-decoration:none;" title="Go to payment">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </span>
        </div>';

        $builder = new NotificationBuilderService();

        $builder->sendNotification('key_payment_paypal_new', [
            '{order_no}'             => $request->order_id,
            '{shipping_details_url}' => $shippingDetailsUrl,
            '{organization_name}'    => $orderData->organizationDetails->organization_name ?? '',
            '{paypal_rows}'          => $paypalRows,
        ], [
            'order_id'                   => $request->order_id,
            'is_payment'                 => 1,
            'user_id'                    => Auth::user()->id ?? null,
            'paypal_payment_id'          => $paypalPayment->id,
            'target_notification_field'  => 'key_payment_paypal_new',
            'new_notification'           => 1,
        ]);

        $this->sendPaymentMail($request->order_id, $request->amount, $paypalReceipt, $paymentUrl);

        return redirect()->back()->withSuccess('Paypal uploaded Successfully!');
    }

    public function customerPaymentPaypal(Request $request) {

        // Remove commas from sub_total and orderTotal
        $subTotal = str_replace(',', '', $request->sub_total);
        $orderTotal = str_replace(',', '', $request->orderTotal);



        $paypalReceipt = self::uploadPaypalReceipt($request);

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
            $CreditAccount->user_id = $AccLogOrder->user_id;
            $CreditAccount->status = 1;
            $CreditAccount->active = 0;
            $CreditAccount->note = 'Outstanding Invoice';
            $CreditAccount->save();
        }

        $paypalPayment = new PaypalPayment();
        $paypalPayment->order_id = $request->order_id;
        $paypalPayment->amount = $request->amount;
        $paypalPayment->paypal_receipt = $paypalReceipt;
        $paypalPayment->save();


        $summaryAtPayment = new SummaryAtPayment();
        $summaryAtPayment->order_id = $request->order_id;
        $summaryAtPayment->organization_id = $AccLogOrder->organization_id;
        $summaryAtPayment->totalItemQty = $request->totalItemQty;
        $summaryAtPayment->subTotal = $subTotal; // Use the cleaned value
        $summaryAtPayment->shipping = $request->shipping;
        $summaryAtPayment->salesTax = $request->salesTax;
        $summaryAtPayment->artwork = $request->artwork;
        $summaryAtPayment->payment_type = 'Invoice Payment';
        $summaryAtPayment->processingFee = $request->paypal_fee;
        $summaryAtPayment->orderTotal = $orderTotal; // Use the cleaned value
        $summaryAtPayment->balancePayment = (float) str_replace(',', '', $request->balancePayment);
        $summaryAtPayment->payedAmount = $request->amount;
        $summaryAtPayment->method = 'Paypal';
        $summaryAtPayment->active = 0;
        $summaryAtPayment->transaction_id = 'PAYPAL'.$paypalPayment->id;
        $summaryAtPayment->created_at = Carbon::now()->addMinute();
        $summaryAtPayment->save();

        $orderData = Order::where('id' , $request->order_id)->first();

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

        $paypalRows = '
        <div style="display:flex; align-items:center; justify-content:space-between; padding:12px 16px; font-size:13px; color:#1f2937; background:#f9fafb;">
            <span style="flex:0 0 140px;">
                <img src="' . e(asset($paypalReceipt)) . '" alt="Paypal Receipt" style="width:90px; height:auto; border:1px solid #e5e7eb; border-radius:4px; cursor:zoom-in;"
                    onclick="(function(src){var o=document.getElementById(\'ncmInlineZoomOverlay\');if(!o){o=document.createElement(\'div\');o.id=\'ncmInlineZoomOverlay\';o.style.cssText=\'display:none;position:fixed;inset:0;background:rgba(0,0,0,0.85);z-index:99999;align-items:center;justify-content:center;cursor:zoom-out;\';var im=document.createElement(\'img\');im.style.cssText=\'max-width:90vw;max-height:88vh;border-radius:6px;box-shadow:0 20px 60px rgba(0,0,0,.5);\';o.appendChild(im);o.addEventListener(\'click\',function(){o.style.display=\'none\';});document.body.appendChild(o);}o.querySelector(\'img\').src=src;o.style.display=\'flex\';})(this.src)">
            </span>
            <span style="flex:0 0 140px; color:#374151;">' . e($paypalPayment->created_at->format('m/d/Y')) . ' &bull; ' . e($paypalPayment->created_at->format('H:i:s')) . '</span>
            <span style="flex:0 0 160px; font-weight:700; color:#16a34a; font-size:15px;">$' . e(number_format($request->amount, 2)) . '</span>
            <span style="flex:0 0 90px; text-align:center;">
                <a href="' . e($paymentUrl) . '" target="_blank" rel="noopener noreferrer" style="color:#111827; text-decoration:none;" title="Go to payment">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </span>
        </div>';

        $builder = new NotificationBuilderService();

        $builder->sendNotification('key_payment_paypal_new', [
            '{order_no}'             => $request->order_id,
            '{shipping_details_url}' => $shippingDetailsUrl,
            '{organization_name}'    => $orderData->organizationDetails->organization_name ?? '',
            '{paypal_rows}'          => $paypalRows,
        ], [
            'order_id'                   => $request->order_id,
            'is_payment'                 => 1,
            'user_id'                    => Auth::user()->id ?? null,
            'paypal_payment_id'          => $paypalPayment->id,
            'target_notification_field'  => 'key_payment_paypal_new',
            'new_notification'           => 1,
        ]);


        $this->sendPaymentMail($request->order_id, $request->amount, $paypalReceipt, $paymentUrl);

        $customerEmailForReceipt = optional($orderData->contactDetails)->email;
        if ($customerEmailForReceipt) {
            $this->sendPaymentMailCustomerPaypal($request->order_id, $paypalPayment, $summaryAtPayment, $customerEmailForReceipt);
        }


        // return redirect()->back()->withSuccess('Paypal uploaded Successfully!');
        return redirect()->back()->with('success', 'Paypal uploaded Successfully!')->with('payment_success', 'Paypal uploaded Successfully!');

    }

    public function uploadPaypalReceipt(Request $request) {
        $file = $request->file('paypal_receipt');

        $destinationPath = 'uploads/paypal';

        $file->move($destinationPath, $file->getClientOriginalName());

        return $destinationPath.'/'.$file->getClientOriginalName();
    }

    public function paypalApprove(Request $request) {


        $paypalPayment = PaypalPayment::find($request->paypal_payment_id);

        $sumOfPayments = $this->getSumOfPayments($paypalPayment->order_id);

        $paypalPayment->amount = $request->approve_amount;
        $paypalPayment->is_approved = $request->is_approved;
        if($request->reject_reason){
            $paypalPayment->reject_reason = $request->reject_reason;
        }else{
            $paypalPayment->reject_reason = null;
        }
        $paypalPayment->update();

        if($request->is_approved == 3){
            return redirect()->back()->withSuccess('PayPal Rejected Successfully!');
        }else{
            $summaryAtPaymentrow = SummaryAtPayment::where('transaction_id', 'PAYPAL' . $request->paypal_payment_id)->first();

            if ($summaryAtPaymentrow) {
                $summaryAtPaymentrow->active = 1;
                $summaryAtPaymentrow->created_at = Carbon::now(); // Set created_at to the current timestamp
                $summaryAtPaymentrow->save(); // Use save() instead of update() to persist all changes
            }

            AccountsLog::where('order_id', $paypalPayment->order_id)->where('type', 0)->where('status', 1)->where('note', 'Outstanding Invoice')->where('active', 0)->update(['active' => 1]);

            $orderDetails = Order::where('id', $paypalPayment->order_id)->first();

            if ($orderDetails && ($sumOfPayments + ($paypalPayment->amount * 100 / 103)) > $orderDetails->order_total) {
                $debitEntry = new DebitEntry();
                $debitEntry->organization_id = $orderDetails->organization_id;
                $debitEntry->order_id = $orderDetails->id;
                $debitEntry->transaction_id = $paypalPayment->id;
                $debitEntry->transaction_type = 'Paypal';
                $debitEntry->amount = ($sumOfPayments + ($paypalPayment->amount * 100 / 103)) - $orderDetails->order_total;
                $debitEntry->note = 'Exess From PAYPAL'.$paypalPayment->id.' (#'.$orderDetails->order_no.')';
                $debitEntry->created_at = $paypalPayment->created_at->copy()->addMinutes(1);
                $debitEntry->save();
            }

            return redirect()->back()->withSuccess('PayPal Approved Successfully!');
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


    public function sendPaymentMail($orderId, $amount, $paypalReceipt, $paymentUrl){

        $order = Order::with(['organizationDetails', 'contactDetails'])->find($orderId);
        $organizationName = optional($order->organizationDetails)->organization_name ?? '';

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_payment_paypal', [
            'orderId'            => $orderId,
            'order_number'       => $orderId,
            'organization_name'  => $organizationName,
            'customer_details'   => trim(optional($order->contactDetails)->first_name . ' ' . optional($order->contactDetails)->last_name),
            'paid_date'          => \Carbon\Carbon::now()->format('m/d/Y'),
            'paid_time'          => \Carbon\Carbon::now()->format('H:i:s'),
            'paid_amount'        => number_format((float) $amount, 2),
            'paypal_receipt'     => asset($paypalReceipt),
            'order_link'         => url("order_details/edit/{$orderId}/order") . '?active_tab=order',
            'payment_link'       => $paymentUrl,
        ]);

        return true;
    }

    public function sendPaymentMailCustomerPaypal($order, $paypalPayment, $summaryAtPayment, $mail)
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
            logger()->error('sendPaymentMailCustomerPaypal: order not found', ['order' => $order]);
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

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_customer_payment_receipt_paypal', [
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
            'paypal_receipt_url' => asset($paypalPayment->paypal_receipt),
            'transaction_id'     => $summaryAtPayment->transaction_id ?? ('PAYPAL' . $paypalPayment->id),
            'paid_amount'        => number_format((float) ($paypalPayment->amount ?? 0), 2),
            'order_total'        => number_format((float) ($orderModel->order_total ?? 0), 2),
            'balance_remaining'  => number_format((float) ($summaryAtPayment->balancePayment ?? 0), 2),
            'paid_date'          => optional($paypalPayment->created_at)->format('m-d-Y') ?? now()->format('m-d-Y'),
        ]);

        return true;
       
    }
}
