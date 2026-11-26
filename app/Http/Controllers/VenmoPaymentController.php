<?php

namespace App\Http\Controllers;

use Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Notification;
use App\Models\VenmoPayment;
use Illuminate\Http\Request;
use App\Models\SummaryAtPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\AccountsLog;
use App\Services\PaymentService;
use App\Services\NotificationBuilderService;
use App\Models\PaymentLog;
use App\Models\PaypalPayment;
use App\Models\CheckPayment;
use App\Models\OtherPayment;
use App\Models\DebitEntry;
use App\Models\EmailNotification;
use App\Services\EmailNotificationBuilderService;
use Illuminate\Support\Facades\Blade;

class VenmoPaymentController extends Controller
{
    protected $PaymentService;

    public function __construct(PaymentService $PaymentService)
    {
        $this->PaymentService = $PaymentService;
    }
    public function venmo(Request $request) {

        // Remove commas from sub_total and orderTotal
        $subTotal = str_replace(',', '', $request->sub_total);
        $orderTotal = str_replace(',', '', $request->orderTotal);



        $venmoReceipt = self::uploadVenmoReceipt($request);

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

        $venmoPayment = new VenmoPayment();
        $venmoPayment->customer_paid_amount = $request->venmo_customer_paid_amount;
        $venmoPayment->order_id = $request->order_id;
        $venmoPayment->venmo_receipt = $venmoReceipt;
        $venmoPayment->save();

        $summaryAtPayment = new SummaryAtPayment();
        $summaryAtPayment->order_id = $request->order_id;
        $summaryAtPayment->organization_id = $AccLogOrder->organization_id;
        $summaryAtPayment->totalItemQty = $request->totalItemQty;
        $summaryAtPayment->subTotal = $subTotal; // Use the cleaned value
        $summaryAtPayment->shipping = $request->shipping;
        $summaryAtPayment->salesTax = $request->salesTax;
        $summaryAtPayment->artwork = $request->artwork;
        $summaryAtPayment->payment_type = 'Invoice Payment';
        $summaryAtPayment->processingFee = 0.00;
        $summaryAtPayment->orderTotal = $orderTotal; // Use the cleaned value
        $summaryAtPayment->balancePayment = (float) str_replace(',', '', $request->balancePayment);
        $summaryAtPayment->payedAmount = $request->venmo_customer_paid_amount;
        $summaryAtPayment->method = 'Venmo';
        $summaryAtPayment->active = 0;
        $summaryAtPayment->transaction_id = 'VENMO'.$venmoPayment->id;
        $summaryAtPayment->created_at = Carbon::now()->addMinute();
        $summaryAtPayment->save();

        $order_for_rep = Order::where('id' , $request->order_id)->first();
        if($order_for_rep){
            $order_for_rep_id = $order_for_rep->user_id;
        }

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

        $venmoRows = '
        <div style="display:grid; grid-template-columns:140px 140px 1fr 90px; align-items:center; padding:12px 16px; font-size:13px; color:#1f2937; background:#f9fafb;">
            <div style="display:flex; align-items:center;">
                <img src="' . e(asset($venmoReceipt)) . '" alt="Venmo Receipt" style="width:90px; height:auto; border:1px solid #e5e7eb; border-radius:4px; cursor:zoom-in;"
                    onclick="(function(src){var o=document.getElementById(\'ncmInlineZoomOverlay\');if(!o){o=document.createElement(\'div\');o.id=\'ncmInlineZoomOverlay\';o.style.cssText=\'display:none;position:fixed;inset:0;background:rgba(0,0,0,0.85);z-index:99999;align-items:center;justify-content:center;cursor:zoom-out;\';var im=document.createElement(\'img\');im.style.cssText=\'max-width:90vw;max-height:88vh;border-radius:6px;box-shadow:0 20px 60px rgba(0,0,0,.5);\';o.appendChild(im);o.addEventListener(\'click\',function(){o.style.display=\'none\';});document.body.appendChild(o);}o.querySelector(\'img\').src=src;o.style.display=\'flex\';})(this.src)">
            </div>
            <div style="display:flex; align-items:center; color:#374151;">' . e($venmoPayment->created_at->format('m/d/Y')) . ' &bull; ' . e($venmoPayment->created_at->format('H:i:s')) . '</div>
            <div style="display:flex; align-items:center; justify-content:center; font-weight:700; color:#16a34a; font-size:15px;">$' . e(number_format($request->venmo_customer_paid_amount, 2)) . '</div>
            <div style="display:flex; align-items:center; justify-content:center;">
                <a href="' . e($paymentUrl) . '" target="_blank" rel="noopener noreferrer" style="color:#111827; text-decoration:none;" title="Go to payment">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
        </div>';

        $builder = new NotificationBuilderService();

        $builder->sendNotification('key_payment_venmo_new', [
            '{order_no}'             => $request->order_id,
            '{shipping_details_url}' => $shippingDetailsUrl,
            '{organization_name}'    => $order_for_rep->organizationDetails->organization_name ?? '',
            '{venmo_rows}'           => $venmoRows,
        ], [
            'order_id'                   => $request->order_id,
            'is_payment'                 => 1,
            'user_id'                    => Auth::user()->id ?? null,
            'venmo_payment_id'           => $venmoPayment->id,
            'target_notification_field'  => 'key_payment_venmo_new',
            'new_notification'           => 1,
        ]);

        $orderData = Order::where('id', $request->order_id)->with('organizationDetails', 'contactDetails')->first();


        $encryptedId = Crypt::encrypt($venmoPayment->id);
        $this->sendPaymentMail($request->order_id, $encryptedId, $request->venmo_customer_paid_amount, $venmoReceipt,  $paymentUrl);

        $customerEmailForReceipt = optional($orderData->contactDetails)->email;
        if ($customerEmailForReceipt) {
            $this->sendPaymentMailCustomerVenmo($request->order_id, $venmoPayment, $summaryAtPayment, $customerEmailForReceipt);
        }

        return redirect()->back()->withSuccess('Venmo uploaded Successfully!');
    }


    public function customerPaymentVenmo(Request $request)
    {
        // Remove commas from sub_total and orderTotal
        $subTotal   = str_replace(',', '', $request->sub_total);
        $orderTotal = str_replace(',', '', $request->orderTotal);

        $venmoReceipt = self::uploadVenmoReceipt($request);

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

        $venmoPayment = new VenmoPayment();
        $venmoPayment->order_id = $request->order_id;
        $venmoPayment->customer_paid_amount = $request->venmo_customer_paid_amount;
        $venmoPayment->venmo_receipt = $venmoReceipt;
        $venmoPayment->save();

        $orderData = Order::where('id', $request->order_id)->with('organizationDetails', 'contactDetails')->first();

        $summaryAtPayment = new SummaryAtPayment();
        $summaryAtPayment->order_id = $request->order_id;
        $summaryAtPayment->organization_id = $orderData->organization_id;
        $summaryAtPayment->totalItemQty = $request->totalItemQty;
        $summaryAtPayment->subTotal = $subTotal;
        $summaryAtPayment->shipping = $request->shipping;
        $summaryAtPayment->salesTax = $request->salesTax;
        $summaryAtPayment->artwork = $request->artwork;
        $summaryAtPayment->payment_type = 'Invoice Payment';
        $summaryAtPayment->processingFee = 0.00;
        $summaryAtPayment->orderTotal = $orderTotal;
        $summaryAtPayment->balancePayment = $request->balancePayment;
        $summaryAtPayment->payedAmount = $request->venmo_customer_paid_amount;
        $summaryAtPayment->method = 'Venmo';
        $summaryAtPayment->active = 0;
        $summaryAtPayment->transaction_id = 'VENMO' . $venmoPayment->id;
        $summaryAtPayment->created_at = Carbon::now()->addMinute();
        $summaryAtPayment->save();


        $shippingDetailsUrl = url("order_details/edit/{$request->order_id}/order") . '?active_tab=order';
        $paymentUrl         = route('payment', [
            'orderId'       => $request->order_id,
            'totalItemQty'  => $request->totalItemQty,
            'sub_total'     => number_format((float) $subTotal, 2),
            'salesTax'      => number_format((float) $request->salesTax, 2),
            'shipping'      => number_format((float) $request->shipping, 2),
            'artwork'       => number_format((float) $request->artwork, 2),
            'processingFee' => number_format((float) $request->card_fee, 2),
            'orderTotal'    => number_format((float) $orderTotal, 2),
        ]);

        $venmoRows = '
        <div style="display:grid; grid-template-columns:140px 140px 1fr 90px; align-items:center; padding:12px 16px; font-size:13px; color:#1f2937; background:#f9fafb;">
            <div style="display:flex; align-items:center;">
                <img src="' . e(asset($venmoReceipt)) . '" alt="Venmo Receipt" style="width:90px; height:auto; border:1px solid #e5e7eb; border-radius:4px; cursor:zoom-in;"
                    onclick="(function(src){var o=document.getElementById(\'ncmInlineZoomOverlay\');if(!o){o=document.createElement(\'div\');o.id=\'ncmInlineZoomOverlay\';o.style.cssText=\'display:none;position:fixed;inset:0;background:rgba(0,0,0,0.85);z-index:99999;align-items:center;justify-content:center;cursor:zoom-out;\';var im=document.createElement(\'img\');im.style.cssText=\'max-width:90vw;max-height:88vh;border-radius:6px;box-shadow:0 20px 60px rgba(0,0,0,.5);\';o.appendChild(im);o.addEventListener(\'click\',function(){o.style.display=\'none\';});document.body.appendChild(o);}o.querySelector(\'img\').src=src;o.style.display=\'flex\';})(this.src)">
            </div>
            <div style="display:flex; align-items:center; color:#374151;">' . e($venmoPayment->created_at->format('m/d/Y')) . ' &bull; ' . e($venmoPayment->created_at->format('H:i:s')) . '</div>
            <div style="display:flex; align-items:center; justify-content:center; font-weight:700; color:#16a34a; font-size:15px;">$' . e(number_format($request->venmo_customer_paid_amount, 2)) . '</div>
            <div style="display:flex; align-items:center; justify-content:center;">
                <a href="' . e($paymentUrl) . '" target="_blank" rel="noopener noreferrer" style="color:#111827; text-decoration:none;" title="Go to payment">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
        </div>';

        $builder = new NotificationBuilderService();

        $builder->sendNotification('key_payment_venmo_new', [
            '{order_no}'             => $request->order_id,
            '{shipping_details_url}' => $shippingDetailsUrl,
            '{organization_name}'    => $orderData->organizationDetails->organization_name ?? '',
            '{venmo_rows}'           => $venmoRows,
        ], [
            'order_id'                   => $request->order_id,
            'is_payment'                 => 1,
            'user_id'                    => Auth::user()->id ?? null,
            'venmo_payment_id'           => $venmoPayment->id,
            'target_notification_field'  => 'key_payment_venmo_new',
            'new_notification'           => 1,
        ]);

        $encryptedId = Crypt::encrypt($venmoPayment->id);
        $this->sendPaymentMail($request->order_id, $encryptedId, $request->venmo_customer_paid_amount, $venmoReceipt, $paymentUrl);

        $customerEmailForReceipt = optional($orderData->contactDetails)->email;
        if ($customerEmailForReceipt) {
            $this->sendPaymentMailCustomerVenmo($request->order_id, $venmoPayment, $summaryAtPayment, $customerEmailForReceipt);
        }

        $receipt = $this->prepareSingleVenmoReceiptDownload(
            $request->order_id,
            $venmoPayment,
            $summaryAtPayment,
            $customerEmailForReceipt ?? ''
        );



        session()->flash('success', 'Venmo uploaded Successfully!');
        session()->flash('payment_success', 'Venmo uploaded Successfully!');


        if (!empty($receipt['base64'])) {
            return view('pages.customer_portal.single_payment_redirect', [
                'pdfBase64'   => $receipt['base64'],
                'fileName'    => $receipt['name'],
                'redirectUrl' => url()->previous(),  
            ]);
        }

        return redirect()->back();
    }

    public function uploadVenmoReceipt(Request $request) {
        $file = $request->file('venmo_receipt');

        $destinationPath = 'uploads/venmo';

        $fileName = Carbon::now()->format('YmdHsi').'_'.$request->order_id.'_venmo_receipt.'.$file->getClientOriginalExtension();
        $file->move($destinationPath, $fileName);

        return $destinationPath.'/'.$fileName;
    }

    public function venmoApprove(Request $request) {
        $venmoPayment = VenmoPayment::find($request->venmo_payment_id);

        $sumOfPayments = $this->getSumOfPayments($venmoPayment->order_id);

        $venmoPayment->amount = $request->approve_amount;
        $venmoPayment->is_approved = $request->is_approved;
        if($request->reject_reason){
            $venmoPayment->reject_reason = $request->reject_reason;
        }else{
            $venmoPayment->reject_reason = null;
        }
        $venmoPayment->update();

        if($request->is_approved == 3){
            return redirect()->back()->withSuccess('Venmo Rejected Successfully!');
        }else{
            $summaryAtPaymentrow = SummaryAtPayment::where('transaction_id', 'VENMO' . $request->venmo_payment_id)->first();

            if ($summaryAtPaymentrow) {
                $summaryAtPaymentrow->active = 1;
                $summaryAtPaymentrow->created_at = Carbon::now(); // Set created_at to the current timestamp
                $summaryAtPaymentrow->save(); // Use save() instead of update() to persist all changes
            }

            AccountsLog::where('order_id', $venmoPayment->order_id)->where('type', 0)->where('status', 1)->where('note', 'Outstanding Invoice')->where('active', 0)->update(['active' => 1]);

            $orderDetails = Order::where('id', $venmoPayment->order_id)->first();

            if ($orderDetails && ($sumOfPayments + ($venmoPayment->amount)) > $orderDetails->order_total) {
                $debitEntry = new DebitEntry();
                $debitEntry->organization_id = $orderDetails->organization_id;
                $debitEntry->order_id = $orderDetails->id;
                $debitEntry->transaction_id = $venmoPayment->id;
                $debitEntry->transaction_type = 'VENMO';
                $debitEntry->amount = ($sumOfPayments + ($venmoPayment->amount)) - $orderDetails->order_total;
                $debitEntry->note = 'Exess From VNM'.$venmoPayment->id.' (#'.$orderDetails->order_no.')';
                $debitEntry->created_at = $venmoPayment->created_at->copy()->addMinutes(1);
                $debitEntry->save();
            }

            return redirect()->back()->withSuccess('Venmo Approved Successfully!');
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


    public function sendPaymentMail($orderNo, $encryptedId, $paidAmount,$venmoReceipt, $paymentUrl){

        $order = Order::with('organizationDetails')->find($orderNo);
        $organizationName = optional($order->organizationDetails)->organization_name ?? '';

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_payment_venmo', [
            'orderId'            => $orderNo,
            'order_number'       => $orderNo,
            'customer_details'   => trim(optional($order->contactDetails)->first_name . ' ' . optional($order->contactDetails)->last_name),
            'organization_name'  => $organizationName,
            'paid_date'          => \Carbon\Carbon::now()->format('m/d/Y'),
            'paid_time'          => \Carbon\Carbon::now()->format('H:i:s'),
            'paid_amount'        => number_format((float) $paidAmount, 2),
            'venmo_receipt'      => url($venmoReceipt),
            'order_link'         => url("order_details/edit/{$orderNo}/order") . '?active_tab=order',
            'payment_link'       => $paymentUrl,
            'download_link'      => route('customer_payment_download.venmo', ['sourceId' => $encryptedId]),
        ]);

        return true;
    }

    public function sendPaymentMailCustomerVenmo($order, $venmoPayment, $summaryAtPayment, $mail)
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
                logger()->error('sendPaymentMailCustomerVenmo: order not found', ['order' => $order]);
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

            app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_customer_payment_receipt_venmo', [
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

                'venmo_receipt_url'  => $venmoPayment->venmo_receipt ? url($venmoPayment->venmo_receipt) : '',
                'transaction_id'     => $summaryAtPayment->transaction_id ?? ('VENMO' . $venmoPayment->id),
                'paid_amount'        => number_format((float) str_replace(',', '', $venmoPayment->customer_paid_amount ?? 0), 2),
                'paid_date'          => optional($venmoPayment->created_at)->format('m-d-Y') ?? now()->format('m-d-Y'),

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
            // A failed email will not break the payment flow
            logger()->error('sendPaymentMailCustomerVenmo failed: ' . $e->getMessage(), [
                'order' => $order instanceof Order ? $order->id : $order,
            ]);
            return false;
        }
    }


    /**
     * SINGLE VENMO PAYMENT: build the receipt PDF
     */
    private function prepareSingleVenmoReceiptDownload($orderId, $venmoPayment, $summaryAtPayment, $mail): ?array
    {
        try {
            $pdfContent = $this->buildSingleVenmoReceiptPdfContent($orderId, $venmoPayment, $summaryAtPayment, $mail);

            $orderNo  = Order::where('id', $orderId)->value('order_no') ?? $orderId;
            $fileName = 'Venmo_Payment_Receipt_' . $orderNo . '_' . now()->format('Ymd_His') . '.pdf';

            return [
                'base64' => base64_encode($pdfContent),
                'name'   => $fileName,
            ];

        } catch (\Throwable $e) {
            logger()->error('prepareSingleVenmoReceiptDownload failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Render the same email template (key_email_customer_payment_receipt_venmo) → PDF bytes.
     */
    private function buildSingleVenmoReceiptPdfContent($orderId, $venmoPayment, $summaryAtPayment, $mail): string
    {
        // 1) Same data as sendPaymentMailCustomerVenmo()
        $templateData = $this->buildSingleVenmoReceiptData($orderId, $venmoPayment, $summaryAtPayment, $mail);

        // 2) Render the same email template
        $template = EmailNotification::where('template_key', 'key_email_customer_payment_receipt_venmo')->first();
        if (!$template || empty($template->body)) {
            throw new \Exception('Template key_email_customer_payment_receipt_venmo not found.');
        }

        $html = Blade::render($template->body, array_merge(['order_items_Array' => ''], $templateData));

        // 3) Venmo receipt image → embedded from disk (DomPDF does not need to download it)
        $url     = $templateData['venmo_receipt_url'] ?? '';
        $dataUri = $this->singleImageFileToDataUri($venmoPayment->venmo_receipt ?? '');

        if ($url && $dataUri) {
            $html = str_replace('src="' . e($url) . '"', 'src="' . $dataUri . '"', $html);
            $html = str_replace('src="' . $url . '"', 'src="' . $dataUri . '"', $html);
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
     * Same data as sendPaymentMailCustomerVenmo() sends to the email template.
     */
    private function buildSingleVenmoReceiptData($order, $venmoPayment, $summaryAtPayment, $mail): array
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
            throw new \Exception('buildSingleVenmoReceiptData: order not found.');
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

            'venmo_receipt_url' => $venmoPayment->venmo_receipt ? url($venmoPayment->venmo_receipt) : '',
            'transaction_id'    => $summaryAtPayment->transaction_id ?? ('VENMO' . $venmoPayment->id),
            'paid_amount'       => number_format((float) str_replace(',', '', $venmoPayment->customer_paid_amount ?? 0), 2),
            'paid_date'         => optional($venmoPayment->created_at)->format('m-d-Y') ?? now()->format('m-d-Y'),

            'order_total'       => number_format((float) ($orderModel->order_total ?? 0), 2),
            'balance_remaining' => number_format((float) str_replace(',', '', $summaryAtPayment->balancePayment ?? 0), 2),

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

    /**
     * Prepare the email HTML for DomPDF:
     * 1) Remove the outer wrapper table so the footer is not cut off.
     * 2) Make the 880px main table fit A4 (~794px).
     */
    private function prepareSingleReceiptHtmlForPdf(string $html): string
    {
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
