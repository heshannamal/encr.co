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
use App\Models\EmailNotification;
use App\Services\EmailNotificationBuilderService;
use Illuminate\Support\Facades\Blade;

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

        $orderData = Order::where('id', $request->order_id)->with('organizationDetails', 'contactDetails')->first();

        $customerEmailForReceipt = optional($orderData->contactDetails)->email;
        if ($customerEmailForReceipt) {
            $this->sendPaymentMailCustomerCheck($request->order_id, $checkPayment, $summaryAtPayment, $customerEmailForReceipt);
        }

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

        $receipt = $this->prepareSingleCheckReceiptDownload(
            $request->order_id,
            $checkPayment,
            $summaryAtPayment,
            $customerEmailForReceipt ?? ''
        );

        session()->flash('success', 'Check uploaded Successfully!');
        session()->flash('payment_success', 'Check uploaded Successfully!');

       
        if (!empty($receipt['base64'])) {
            return view('pages.customer_portal.single_payment_redirect', [
                'pdfBase64'   => $receipt['base64'],
                'fileName'    => $receipt['name'],
                'redirectUrl' => url()->previous(),  
            ]);
        }

        return redirect()->back();
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
        try {
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

            $orderModel->loadMissing(['organizationDetails', 'contactDetails']);

            if (!$orderModel->relationLoaded('orderItems')) {
                $orderModel->load([
                    'orderItems' => function ($query) {
                        $query->with(['productDetails', 'statusDetails'])->where('is_studio_item', 0);
                    },
                ]);
            }

            $organizationName = optional($orderModel->organizationDetails)->organization_name ?? '';
            $customerName     = trim(
                (optional($orderModel->contactDetails)->first_name ?? '') . ' ' .
                (optional($orderModel->contactDetails)->last_name ?? '')
            );

            $orderItemsList = [];
            foreach ($orderModel->orderItems as $item) {
                $qty   = $item->quantity ?? $item->qty ?? 1;
                $price = $item->price ?? $item->unit_price ?? 0;

                $orderItemsList[] = [
                    'product_name' => optional($item->productDetails)->product_name ?? ($item->product_name ?? 'Item'),
                    'size'         => $item->size ?? '',
                    'qty'          => $qty,
                    'price'        => $price,
                    'total'        => $item->total_price ?? $item->total ?? ($qty * $price),
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

                // Check details
                'check_front_url'    => $checkPayment->check_front ? url($checkPayment->check_front) : '',
                'check_back_url'     => $checkPayment->check_back ? url($checkPayment->check_back) : '',
                'transaction_id'     => $summaryAtPayment->transaction_id ?? ('CHK' . $checkPayment->id),
                'paid_amount'        => number_format((float) ($checkPayment->customer_paid_amount ?? 0), 2),
                'paid_date'          => optional($checkPayment->created_at)->format('m-d-Y') ?? now()->format('m-d-Y'),

                // Payment summary
                'order_total'        => number_format((float) ($orderModel->order_total ?? 0), 2),
                'balance_remaining'  => number_format((float) str_replace(',', '', $summaryAtPayment->balancePayment ?? 0), 2),
                'sub_total'          => number_format((float) ($orderModel->sub_total ?? 0), 2),
                'discountType'       => $orderModel->discountType ?? '',
                'discount'           => $orderModel->discount ?? '',
                'artwork'            => number_format((float) ($orderModel->artwork ?? 0), 2),
                'sales_tax_rate'     => $orderModel->sales_tax_rate ?? '',
                'discount_hidation'  => $orderModel->discount_hidation ?? '',
                'sale_tax'           => number_format((float) ($orderModel->sales_tax ?? 0), 2),
                'shipping_fee'       => number_format((float) ($orderModel->shipping ?? 0), 2),
            ]);

            return true;

        } catch (\Throwable $e) {
            logger()->error('sendPaymentMailCustomerCheck failed: ' . $e->getMessage(), [
                'order' => $order instanceof Order ? $order->id : $order,
            ]);
            return false;
        }
    }

    /**
     * SINGLE CHECK PAYMENT: build the receipt PDF.
     */
    private function prepareSingleCheckReceiptDownload($orderId, $checkPayment, $summaryAtPayment, $mail): ?array
    {
        try {
            $pdfContent = $this->buildSingleCheckReceiptPdfContent($orderId, $checkPayment, $summaryAtPayment, $mail);

            $orderNo  = Order::where('id', $orderId)->value('order_no') ?? $orderId;
            $fileName = 'Check_Payment_Receipt_' . $orderNo . '_' . now()->format('Ymd_His') . '.pdf';

            return [
                'base64' => base64_encode($pdfContent),
                'name'   => $fileName,
            ];

        } catch (\Throwable $e) {
            logger()->error('prepareSingleCheckReceiptDownload failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Render the same email template (key_email_customer_payment_receipt_check) → PDF bytes.
     */
    private function buildSingleCheckReceiptPdfContent($orderId, $checkPayment, $summaryAtPayment, $mail): string
    {
        // 1) Same data as sendPaymentMailCustomerCheck()
        $templateData = $this->buildSingleCheckReceiptData($orderId, $checkPayment, $summaryAtPayment, $mail);

        // 2) Render the same email template
        $template = EmailNotification::where('template_key', 'key_email_customer_payment_receipt_check')->first();
        if (!$template || empty($template->body)) {
            throw new \Exception('Template key_email_customer_payment_receipt_check not found.');
        }

        $html = Blade::render($template->body, array_merge(['order_items_Array' => ''], $templateData));

        // 3) Check images → embedded from disk (DomPDF does not need to download them)
        foreach (['check_front' => 'check_front_url', 'check_back' => 'check_back_url'] as $column => $urlKey) {
            $url     = $templateData[$urlKey] ?? '';
            $dataUri = $this->singleImageFileToDataUri($checkPayment->{$column} ?? '');

            if ($url && $dataUri) {
                $html = str_replace('src="' . e($url) . '"', 'src="' . $dataUri . '"', $html);
                $html = str_replace('src="' . $url . '"', 'src="' . $dataUri . '"', $html);
            }
        }

        // 4) Prepare for PDF (A4 width, remove outer wrapper)
        $html = $this->prepareSingleReceiptHtmlForPdf($html);

        // 5) NEW: footer → at the bottom of the page, rounded corners kept
        $html = $this->movePdfFooterToFirstPageBottom($html);

        // 6) PDF bytes
        return \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isRemoteEnabled' => true,   // logo images are https:// URLs
                'defaultFont'     => 'Arial',
            ])
            ->output();
    }

    /**
     * Same data as sendPaymentMailCustomerCheck() sends to the email template.
     */
    private function buildSingleCheckReceiptData($order, $checkPayment, $summaryAtPayment, $mail): array
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
            throw new \Exception('buildSingleCheckReceiptData: order not found.');
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

        return [
            'custom_email'      => $mail,
            'order_number'      => $orderModel->order_no,
            'order_link'        => url("customer_portal/order_view/{$orderModel->id}") . '?active_tab=order',
            'organization_name' => $organizationName,
            'customer_name'     => $customerName,
            'customer_email'    => $orderModel->email ?? optional($orderModel->contactDetails)->email ?? '',
            'customer_phone'    => $orderModel->phone_no ?? '',
            'customer_street'   => $orderModel->street ?? '',
            'customer_city'     => $orderModel->city ?? '',
            'customer_state'    => $orderModel->state ?? '',
            'customer_postal'   => $orderModel->postal_code ?? '',
            'customer_country'  => $orderModel->country ?? '',
            'order_items'       => $orderItemsList,
            'check_front_url'   => url($checkPayment->check_front),
            'check_back_url'    => url($checkPayment->check_back),
            'transaction_id'    => $summaryAtPayment->transaction_id ?? ('CHK' . $checkPayment->id),
            'paid_amount'       => number_format((float) ($checkPayment->customer_paid_amount ?? 0), 2),
            'order_total'       => number_format((float) ($orderModel->order_total ?? 0), 2),
            'balance_remaining' => number_format((float) ($summaryAtPayment->balancePayment ?? 0), 2),
            'paid_date'         => optional($checkPayment->created_at)->format('m-d-Y') ?? now()->format('m-d-Y'),
            'sub_total'         => number_format((float) ($orderModel->sub_total ?? 0), 2),
            'discountType'      => $orderModel->discountType ?? '',
            'discount'          => $orderModel->discount ?? '',
            'artwork'           => number_format((float) ($orderModel->artwork ?? 0), 2),
            'sales_tax_rate'    => $orderModel->sales_tax_rate ?? '',
            'discount_hidation' => $orderModel->discount_hidation ?? '',
            'sale_tax'          => number_format((float) ($orderModel->sales_tax ?? 0), 2),
            'shipping_fee'      => number_format((float) ($orderModel->shipping ?? 0), 2),
        ];
    }

    /**
     * Read an uploaded image from disk and return it as a data URI for DomPDF.
     * Returns null if the file is missing or not an image.
     */
    private function singleImageFileToDataUri(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        $clean = ltrim($path, '/');

        $candidates = [
            public_path($clean),                                                   // public/uploads/...
            storage_path('app/public/' . preg_replace('#^storage/#', '', $clean)), // storage/app/public/...
            base_path($clean),
            $path,                                                                 // absolute path
        ];

        foreach ($candidates as $file) {
            if (is_file($file) && is_readable($file)) {
                $mime = mime_content_type($file) ?: '';

                if (strpos($mime, 'image/') !== 0) {
                    logger()->warning("Single receipt image is not an image: {$file} ({$mime})");
                    return null;
                }

                return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($file));
            }
        }

        logger()->warning("Single receipt image not found for PDF: {$path}");
        return null;
    }

    private function prepareSingleReceiptHtmlForPdf(string $html): string
    {
        // 1) Remove outer wrapper: <body><table width="100%"><tr><td align="center"> ... </td></tr></table></body>
        $html = preg_replace(
            '/(<body[^>]*>)\s*<table[^>]*width="100%"[^>]*>\s*<tr>\s*<td[^>]*align="center"[^>]*>/is',
            '$1',
            $html,
            1
        );
        $html = preg_replace(
            '/<\/td>\s*<\/tr>\s*<\/table>\s*(<\/body>)/is',
            '$1',
            $html,
            1
        );

        // 2) width="880" → 100%. Small widths like the logos stay the same.
        $html = preg_replace_callback('/width="(\d+)"/', function ($m) {
            return ((int) $m[1] > 600) ? 'width="100%"' : $m[0];
        }, $html);

        $pdfCss = '<style>
            @page { margin: 20px; }
            body { background: #ffffff !important; margin: 0; padding: 0; }
            tr { page-break-inside: avoid; }
        </style>';

        if (stripos($html, '</head>') !== false) {
            return str_ireplace('</head>', $pdfCss . '</head>', $html);
        }

        return $pdfCss . $html;
    }

    /**
     * PDF only: take the email footer out of the content and show it ONCE,
     */
    private function movePdfFooterToFirstPageBottom(string $html): string
    {
        $footerHeight = 105;   // height of the footer area (px)

        // Find the footer row: <!-- FOOTER --> <tr>...</tr> right before </table></body>
        if (!preg_match('/<!--\s*FOOTER\s*-->\s*(<tr>.*?<\/tr>)\s*(<\/table>\s*<\/body>)/is', $html, $match)) {
            return $html;
        }

        $footerRow = $match[1];

        // 1) Remove the footer from the main content
        $html = str_replace($match[0], $match[2], $html);

        // 2) Footer drawn ONCE (absolute = only on page 1), rounded bottom corners like the email
        $firstPageFooter = '
            <div class="pdf-first-page-footer">
                <div style="background:#ECEBE5;border-radius:0 0 12px 12px;overflow:hidden;">
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                        style="border-collapse:collapse;">' . $footerRow . '</table>
                </div>
            </div>';

        $html = preg_replace('/(<body[^>]*>)/i', '$1' . $firstPageFooter, $html, 1);

        // 3) Reserve space at the bottom of PAGE 1 for the footer
        $footerCss = '<style>
            @page { margin: 20px; }
            @page :first { margin-bottom: ' . ($footerHeight + 25) . 'px; }
            .pdf-first-page-footer {
                position: absolute;
                left: 0;
                right: 0;
                bottom: -' . ($footerHeight + 5) . 'px;
                height: ' . $footerHeight . 'px;
            }
        </style>';

        if (stripos($html, '</head>') !== false) {
            return str_ireplace('</head>', $footerCss . '</head>', $html);
        }

        return $footerCss . $html;
    }
}
