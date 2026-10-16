<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AccountsLog;
use App\Models\CheckPayment;
use App\Models\DebitEntry;
use App\Models\FactoryInvoice;
use App\Models\InvoiceProduct;
use App\Models\Notification;
use App\Models\NotificationTemplate;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OtherPayment;
use App\Models\PaymentLog;
use App\Models\PaypalPayment;
use App\Models\PmSectionDiscussion;
use App\Models\PmSectionDiscussionComment;
use App\Models\PmSectionSubDiscussion;
use App\Models\Price;
use App\Models\Project;
use App\Models\PurchaseorderReceipt;
use App\Models\SubProduct;
use App\Models\SummaryAtPayment;
use App\Models\User;
use App\Models\UserEmailTemplate;
use App\Models\VenmoPayment;
use App\Services\EmailNotificationBuilderService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use domainencore\Facades\OrderDatesFacade\ExFactoryDateFacade;
use App\Services\NotificationBuilderService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;

class NewNotificationController extends Controller
{
    

    private function getModalType($notification)
    {
        // done
        if (Str::contains($notification->notification_title, 'Weekly production report')) {
            return "report";
        }

        if (Str::contains($notification->notification_title, 'Confirmation needed for Urgent Order')) {
            return "urgent-order-production";
        }

        if (Str::contains($notification->notification_title, 'Moved To Production')) {
            return "order-production";
        }

        if (Str::contains($notification->notification_title, 'Ex-factory date for Order')) {
            return "factory-order-rejected";
        }

        if (Str::contains($notification->notification_title, 'Ex-factory date for Urgent Order')) {
            return "factory-urgent-order-rejected";
        }

        if (Str::contains($notification->notification_title, 'Ex-factory date confirmed for Order')) {
            return 'confirmed-order';
        }

        if (Str::contains($notification->notification_title, 'Ex-factory date confirmed for Urgent Order')) {
            return 'confirmed-urgent-order';
        }


        if (Str::contains($notification->notification_title, 'Edited')) {
            return 'order-edited';
        }


        if ($notification->comment_mention_id) {
            return "mention";
        }

        if ($notification->is_comment == 1) {
            return "mention";
        }

        if ($notification->sub_task_id) {
            return "assigned";
        }

        if ($notification->task_id) {
            return "assigned";
        }

        if ($notification->is_payment == 1) {
            return "tracking 1";
        }


        if ($notification->project_id) {
            return "assigned";
        }

        if ($notification->is_urgent == 1) {
            return "overdue";
        }



        return null;
    }



    private function getSource($notification)
    {
        if ($notification->orderDetails && $notification->orderDetails->organizationDetails) {
            return $notification->orderDetails->organizationDetails->organization_name;
        }

        // Most specific first — payment
        if ($notification->is_payment == 1) {
            return "Payment Management";
        }

        // Comment mention
        if ($notification->comment_mention_id) {
            return "Mention Comment";
        }

        // Sub task (more specific than task)
        if ($notification->sub_task_id) {
            return "Project Management";
        }

        // Task
        if ($notification->task_id) {
            return "Project Management";
        }

        // Project
        if ($notification->project_id) {
            return "Project Management";
        }

        // Order item
        if ($notification->order_item_id) {
            return "Order Management";
        }

        // Order
        if ($notification->order_id) {
            return "Order Management";
        }

        return $notification->notification_title;
    }

    private function getIcon($notification)
    {
        if ($notification->is_payment == 1) {
            return "fas fa-dollar-sign";
        }

        if (Str::contains($notification->notification_title, 'Confirmation needed for Urgent Order')) {
            return "fas fa-truck-ramp-box";
        }

        if (Str::contains($notification->notification_title, 'Moved To Production')) {
            return "fas fa-truck-ramp-box";
        }

        if (Str::contains($notification->notification_title, 'Ex-factory date for Order')) {
            return "fas fa-truck-ramp-box";
        }

        if (Str::contains($notification->notification_title, 'Ex-factory date for Urgent Order')) {
            return "fas fa-truck-ramp-box";
        }

        if (Str::contains($notification->notification_title, 'Ex-factory date confirmed for Order')) {
            return 'fas fa-truck-ramp-box';
        }

        if (Str::contains($notification->notification_title, 'Ex-factory date confirmed for Urgent Order')) {
            return 'fas fa-truck-ramp-box';
        }

        if (Str::contains($notification->notification_title, 'Edited')) {
            return 'fas fa-truck-ramp-box';
        }


        if ($notification->comment_mention_id) {
            return "fas fa-sitemap";
        }

        if ($notification->is_comment == 1) {
            return "fas fa-comment";
        }

        if ($notification->sub_task_id) {
            return "fas fa-sitemap";
        }

        if ($notification->task_id) {
            return "fas fa-sitemap";
        }

        if ($notification->project_id) {
            return "fas fa-sitemap";
        }

        if ($notification->order_item_id) {
            return "fas fa-box";
        }

        if ($notification->order_id) {
            return "fas fa-shopping-cart";
        }

        if (strcasecmp($notification->notification_title, 'Weekly production report') === 0) {
            return "fas fa-square-poll-vertical";
        }

        return "fas fa-bell";
    }

    private function getIconClass($notification)
    {

        if ($notification->is_read == 0) {
            return "icon-gray";
        }

        if ($notification->is_urgent == 1 || Str::contains($notification->notification_title, 'Urgent Order')) {
            return "icon-red";
        }

        if ($notification->is_payment == 1) {
            return "icon-red";
        }

        return "icon-gray";
    }

    private function getBadge($notification)
    {
        if ($notification->orderDetails) {

            return "Order#" . $notification->orderDetails->order_no;
        }

        return "";
    }


   


    private function formatNotifications($notifications)
    {
        $items = [];
        foreach ($notifications as $notification) {
            $created = Carbon::parse($notification->created_at);
            $displayTime = $created->isToday() || $created->isYesterday()
                ? $created->format('h:i A')
                : $created->format('d M Y');

            $items[] = [
                'id'           => $notification->id,
                'title'        => $notification->notification_title,
                'message'      => strip_tags($notification->notification_message),
                'is_read'      => (bool) $notification->is_read,
                'created_at'   => $notification->created_at,
                'display_time' => $displayTime,
                'source'       => $this->getSource($notification),
                'icon'         => $this->getIcon($notification),
                'icon_class'   => $this->getIconClass($notification),
                'badge'        => $this->getBadge($notification),
                'badge_red'    => false,
                'starred'      => (bool) $notification->is_mark,
                'modal_type'   => $this->getModalType($notification),
            ];
        }
        return $items;
    }


    public function markAsReadNotification(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids) || !is_array($ids)) {
            return response()->json([
                'status'  => false,
                'message' => 'No notifications selected.'
            ], 422);
        }

        $updated = Notification::where('user_id', Auth::id())
            ->whereIn('id', $ids)
            ->update(['is_read' => 1]);

        return response()->json([
            'status'  => true,
            'updated' => $updated,
        ]);
    }

    public function markAsUnreadNotification(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids) || !is_array($ids)) {
            return response()->json([
                'status'  => false,
                'message' => 'No notifications selected.'
            ], 422);
        }

        $updated = Notification::where('user_id', Auth::id())
            ->whereIn('id', $ids)
            ->update(['is_read' => 0]);

        return response()->json([
            'status'  => true,
            'updated' => $updated,
        ]);
    }


    public function toggleStar($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$notification) {
            return response()->json([
                'status'  => false,
                'message' => 'Notification not found.'
            ], 404);
        }

        $notification->is_mark = $notification->is_mark ? 0 : 1;
        $notification->save();

        return response()->json([
            'status'   => true,
            'id'       => $notification->id,
            'is_mark'  => (bool) $notification->is_mark,
        ]);
    }


    public function getNotificationData($id)
    {
        $notification = Notification::with('user')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$notification) {
            return response()->json([
                'status'  => false,
                'message' => 'Notification not found.'
            ], 404);
        }

        $footerModal = NotificationTemplate::whereRaw(
            'CONVERT(template_key USING utf8mb4) = ?',
            [$notification->target_notification_field]
        )->first();

        // ── Compile the stored Blade route snippets into real URLs ──
        if ($footerModal) {
            $footerModal->confirm_route = $this->renderRouteSnippet($footerModal->confirm_route);
            $footerModal->reject_route  = $this->renderRouteSnippet($footerModal->reject_route);
        }

        if ($notification->notification_message && strpos($notification->notification_message, 'ACTION-CELL-') !== false) {
            preg_match_all('/ACTION-CELL-(check|venmo|paypal)-(\d+)-START/', $notification->notification_message, $matches, PREG_SET_ORDER);

            if (!empty($matches)) {
                $message = $notification->notification_message;

                // Group IDs by type so we only query each table once
                $checkIds = [];
                $venmoIds = [];
                $paypalIds = [];
                foreach ($matches as $m) {
                    if ($m[1] === 'check') {
                        $checkIds[] = $m[2];
                    } elseif ($m[1] === 'venmo') {
                        $venmoIds[] = $m[2];
                    } else {
                        $paypalIds[] = $m[2];
                    }
                }

                $checkPayments  = !empty($checkIds)  ? CheckPayment::whereIn('id', $checkIds)->get()->keyBy('id')   : collect();
                $venmoPayments  = !empty($venmoIds)  ? VenmoPayment::whereIn('id', $venmoIds)->get()->keyBy('id')   : collect();
                $paypalPayments = !empty($paypalIds) ? PaypalPayment::whereIn('id', $paypalIds)->get()->keyBy('id') : collect();

                foreach ($matches as $m) {
                    [$full, $type, $paymentId] = $m;

                    if ($type === 'check') {
                        $record = $checkPayments->get($paymentId);
                    } elseif ($type === 'venmo') {
                        $record = $venmoPayments->get($paymentId);
                    } else {
                        $record = $paypalPayments->get($paymentId);
                    }

                    if (!$record || is_null($record->is_approved) || $record->is_approved == 0) {
                        continue; 
                    }

                    $isApproved = $record->is_approved == 1;
                    $replacement = '<div style="display:flex;gap:6px;align-items:center;justify-content:center">'
                        . '<span style="font-size:11px;font-weight:700;color:' . ($isApproved ? '#16a34a' : '#dc2626') . '">'
                        . ($isApproved ? 'APPROVED' : 'REJECTED') . '</span></div>';

                    $pattern = '/<!--ACTION-CELL-' . $type . '-' . $paymentId . '-START-->.*?<!--ACTION-CELL-' . $type . '-' . $paymentId . '-END-->/s';
                    $message = preg_replace($pattern, $replacement, $message, 1);
                }

                $notification->notification_message = $message;
            }
        }


        // Get payment details
        $checkPayment = $notification->check_payment_id
            ? CheckPayment::find($notification->check_payment_id)
            : null;

        $venmoPayment = $notification->venmo_payment_id
            ? VenmoPayment::find($notification->venmo_payment_id)
            : null;

        $paypalPayment = $notification->paypal_payment_id
            ? PaypalPayment::find($notification->paypal_payment_id)
            : null;    

        $otherPayment = $notification->other_payment_id
            ? OtherPayment::find($notification->other_payment_id)
            : null;

        $purchaseOrder = $notification->purchase_order_id
            ? PurchaseorderReceipt::find($notification->purchase_order_id)
            : null;

        $orderDetails = ($notification->is_payment == 1)
            ? Order::with('organizationDetails')->find($notification->order_id)
            : null;

        $emailTemplateAlreadyAdded = $notification->email_template_id
            ? UserEmailTemplate::where('user_id', Auth::id())
                ->where('template_id', $notification->email_template_id)
                ->exists()
            : false;    

        return response()->json([
            'status' => true,
            'data' => [
                'notification'                  => $notification,
                'notification_footer'           => $footerModal,
                'check_payment'                 => $checkPayment,
                'venmo_payment'                 => $venmoPayment,
                'paypal_payment'                => $paypalPayment,
                'other_payment'                 => $otherPayment,
                'purchase_order'                => $purchaseOrder,
                'order_details'                 => $orderDetails,
                'email_template_already_added'  => $emailTemplateAlreadyAdded,
            ]
        ]);
    }

    private function renderRouteSnippet(?string $snippet): ?string
    {
        if (empty($snippet)) {
            return null;
        }

        try {
            return trim(Blade::render($snippet));
        } catch (\Throwable $e) {
            \Log::error('Notification footer route render failed', [
                'snippet' => $snippet,
                'error'   => $e->getMessage(),
            ]);
            return null;
        }
    }


    public function new_urgent_confirm(Request $request)
    {
        $orderId = $request->order_id;
        $notificationId = $request->notificationId;
        $notifi_target_field = $request->target_field;
        $orderItemIds = $request->order_item_id;

        $order = Order::with('organizationDetails', 'contactDetails')->find($orderId);


        $notification = Notification::find($notificationId);
        $notification->order_reject_or_confirm = 2;
        $notification->order_in_hand_due_date = $order->due_date;
        $notification->update();
        
        if (str_contains($orderItemIds, ',')) {
            foreach (explode(',', $orderItemIds) as $id) {
                $orderItem = OrderItem::find($id);
                if ($orderItem) {
                    $orderItem->is_urgent = 1;
                    $orderItem->reject_or_confirm = 2;
                    $orderItem->ex_factory_date = $notification->order_ex_fac_date;
                    $orderItem->update();
                }
            }
        } else {
            $orderItem = OrderItem::find($orderItemIds);
            if ($orderItem) {
                $orderItem->is_urgent = 1;
                $orderItem->reject_or_confirm = 2;
                $orderItem->ex_factory_date = $notification->order_ex_fac_date;
                $orderItem->update();
            }
        }

        if ($order->ex_factory_date != $notification->order_ex_fac_date) {
            ExFactoryDateFacade::create($order->id, Auth::user()->name, $order->ex_factory_date, $notification->order_ex_fac_date, 'Rep suggested ex-factory date has been confirmed by factory');
        }

        $order->is_urgent = 1;
        $order->reject_or_confirm = 2;
        $order->ex_factory_date = Carbon::parse($notification->order_ex_fac_date)->format('m/d/Y');
        $order->factory_confirmation_date = \Carbon\Carbon::now()->format('m/d/Y');
        $order->update();


        $existingNotifications = Notification::where('order_id', $orderId)
        ->where('target_notification_field', $notifi_target_field)
        ->where('order_item_id', $orderItemIds)->where('is_urgent', 1)
        ->whereNull('order_reject_or_confirm')->get();

        foreach ($existingNotifications as $existingNotification) {
            $existingNotification->order_reject_or_confirm = 2;
            $existingNotification->update();
        }

        

        $builder = new NotificationBuilderService();
        $builder->sendNotification('key_ex_factory_date_confirm_urgent', [
            '{order_number}'      => $order->order_no,
            '{ex_factory_date}'   => Carbon::parse($notification->order_ex_fac_date)->format('m/d/Y'),
            '{organization_name}' => optional($order->organizationDetails)->organization_name ?? '',
            '{order_link}' => url("order_details/edit/{$orderId}/order") . '?active_tab=order',
        ], [
            'order_id'                => $orderId,
            'order_item_id'           => $orderItemIds,
            'order_reject_or_confirm' => 2,   
            'target_notification_field' => 'key_ex_factory_date_confirm_urgent',
            'new_notification'       => 1,
        ]);

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_ex_factory_date_confirm_urgent', [
            'orderId'            => $order->id,
            'order_number'       => $order->order_no,
            'customer_details'   => trim(optional($order->contactDetails)->first_name . ' ' . optional($order->contactDetails)->last_name),
            'organization_name'  => optional($order->organizationDetails)->organization_name ?? '',
            'ex_factory_date'    => Carbon::parse($notification->order_ex_fac_date)->format('m/d/Y'),
            'order_link'         => url("order_details/edit/{$order->id}/order") . '?active_tab=order',
        ]);

        $this->create_invoice_by_factory_confirmation($order->id);

        return response()->json(['status' => true, 'message' => 'success'], 201);
    }


    // urgent
    public function new_urgent_reject(Request $request)
    {
        $rejectReason = $request->input('reject_reason');
        $suggestedDate = $request->input('suggested_date');
        $orderId = $request->order_id;
        $notificationId = $request->notificationId;
        $notifi_target_field = $request->target_field;
        $orderItemIds = $request->order_item_id;

        $order = Order::with('organizationDetails', 'contactDetails')->find($orderId);
    
        $notification = Notification::find($notificationId);
        $notification->order_reject_or_confirm = 1;
        $notification->order_ex_fac_date = $suggestedDate;
        $notification->order_in_hand_due_date = $order->due_date;
        $notification->update();

        if (str_contains($orderItemIds, ',')) {
            foreach (explode(',', $orderItemIds) as $id) {
                $orderItem = OrderItem::find($id);
                if ($orderItem) {
                    $orderItem->is_urgent = 1;
                    $orderItem->reject_or_confirm = 1;
                    $orderItem->reject_reason = $rejectReason;
                    $orderItem->suggested_ex_fac_date = $suggestedDate;
                    $orderItem->update();
                }
            }
        } else {
            $orderItem = OrderItem::find($orderItemIds);
            if ($orderItem) {
                $orderItem->is_urgent = 1;
                $orderItem->reject_or_confirm = 1;
                $orderItem->ex_factory_date = $notification->order_ex_fac_date;
                $orderItem->update();
            }
        }
        
        
        $order->is_urgent = 1;
        $order->factory_confirmation_date = 'Waiting for rep Confirmation';
        $order->reject_or_confirm = 1;
        $order->suggested_ex_fac_date = $suggestedDate;
        $order->update();


        $existingNotifications = Notification::where('order_id', $orderId)
        ->where('target_notification_field', $notifi_target_field)
        ->where('order_item_id', $orderItemIds)->where('is_urgent', 1)
        ->whereNull('order_reject_or_confirm')->get();

        foreach ($existingNotifications as $existingNotification) {
            $existingNotification->order_reject_or_confirm = 1;
            $existingNotification->update();
        }

        $builder = new NotificationBuilderService();

        $DownloadTestPrint = url('orders/DownloadTestPrint/' . $orderItemIds);
        $quoteCSV_Download = url('orders/csv/' . $order->id);
        $discussionLink = route('orders.info', ['id' => $order->id, 'type' => 'management']);
        $playerReport = route('store.generatePlayerCSV', ['id' => $order->id]);

        $builder->sendNotification('key_ex_factory_date_urgent_order_rejected', [
            '{order_number}'      => $order->order_no,                                        
            '{suggested_date}'    => Carbon::parse($suggestedDate)->format('m/d/Y'),
            '{reason}'            => $rejectReason,
            '{organization_name}' => optional($order->organizationDetails)->organization_name ?? '', 
            '{discussion_link}'   => $discussionLink,
            '{order_link}'        => url("order_details/edit/{$orderId}/order") . '?active_tab=order',                                          
            '{DownloadTestPrint}' => $DownloadTestPrint,
            '{quoteCSV_Download}' => $quoteCSV_Download,
            '{playerReport}'      => $playerReport,
        ], [
            'order_id'                   => $orderId,
            'order_ex_fac_date'          => $notification->order_ex_fac_date,
            'order_in_hand_due_date'     => $order->due_date,
            'order_item_id'              => $orderItemIds,
            'target_notification_field' => 'key_ex_factory_date_urgent_order_rejected',
            'new_notification'           => 1,
        ]);

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_ex_factory_date_urgent_order_rejected', [
            'orderId'            => $order->id,
            'order_number'       => $order->order_no,
            'customer_details'   => trim(optional($order->contactDetails)->first_name . ' ' . optional($order->contactDetails)->last_name),
            'organization_name'  => optional($order->organizationDetails)->organization_name ?? '',
            'suggested_date'     => Carbon::parse($suggestedDate)->format('m/d/Y'),
            'reject_reason'      => $rejectReason,
            'order_link'         => url("order_details/edit/{$order->id}/order") . '?active_tab=order',
            'techpack_link'      => $DownloadTestPrint,
            'roster_link'        => $quoteCSV_Download,
            'discussion_link'    => $discussionLink,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'success'
        ], 201);
    }

    // confirm
    public function new_factory_confirm(Request $request)
    {
        $orderId = $request->order_id;
        $notificationId = $request->notificationId;
        $notifi_target_field = $request->target_field;
        $orderItemIds = $request->order_item_id;

        $order = Order::with('organizationDetails')->find($orderId);
      
        $notification = Notification::find($notificationId);
        $notification->order_reject_or_confirm = 2;
        $notification->update();

        if (str_contains($orderItemIds, ',')) {
            foreach (explode(',', $orderItemIds) as $id) {
                $orderItem = OrderItem::find($id);
                if ($orderItem) {
                    $orderItem->is_urgent = 0;
                    $orderItem->reject_or_confirm = 2;
                    $orderItem->update();
                }
            }
        } else {
            $orderItem = OrderItem::find($orderItemIds);
            $orderItem->is_urgent = 0;
            $orderItem->reject_or_confirm = 2;
            $orderItem->update();

        }

        $order->is_urgent = 0;
        $order->factory_confirmation_date = \Carbon\Carbon::now()->format('m/d/Y');
        $order->ex_factory_date = Carbon::parse($notification->order_ex_fac_date)->format('m/d/Y');
        $order->reject_or_confirm = 2;
        $order->update();

       
        $existingNotifications = Notification::where('order_id', $orderId)
        ->where('target_notification_field', $notifi_target_field)
        ->where('order_item_id', $orderItemIds)
        ->whereNull('order_reject_or_confirm')->get();

        foreach ($existingNotifications as $existingNotification) {
            $existingNotification->order_reject_or_confirm = 2;
            $existingNotification->update();
        }


        $builder = new NotificationBuilderService();

        $builder->sendNotification('key_ex_factory_date_confirm', [
            '{order_number}'      => $order->order_no,                                        
            '{ex_factory_date}'   => Carbon::parse($order->ex_factory_date)->format('m/d/Y'),                                     
            '{organization_name}' => optional($order->organizationDetails)->organization_name ?? '',
            '{order_link}'        => url("order_details/edit/{$orderId}/order") . '?active_tab=order',                                           
        ], [
            'order_id'                   => $orderId,
            'order_item_id'              => $orderItemIds,
            'order_reject_or_confirm'    => 2, 
            'target_notification_field' => 'key_ex_factory_date_confirm',
            'new_notification'           => 1,
        ]);

        $this->create_invoice_by_factory_confirmation($order->id);

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_ex_factory_date_confirm', [
            'orderId'            => $order->id,
            'order_number'       => $order->order_no,
            'organization_name'  => optional($order->organizationDetails)->organization_name ?? '',
            'ex_factory_date'    => Carbon::parse($order->ex_factory_date)->format('m/d/Y'),
            'order_link'         => url("order_details/edit/{$order->id}/order") . '?active_tab=order',
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'success'
        ], 201);
    }



    public function new_factory_reject(Request $request)
    {
        $rejectReason = $request->input('reject_reason');
        $suggestedDate = $request->input('suggested_date');
        $orderId = $request->order_id;
        $notificationId = $request->notificationId;
        $notifi_target_field = $request->target_field;
        $orderItemIds = $request->order_item_id;

        $order = Order::with('organizationDetails', 'contactDetails')->find($orderId);

        $notificataion = Notification::find($notificationId);
        $notificataion->order_reject_or_confirm = 1;
        $notificataion->update();


        if (str_contains($orderItemIds, ',')) {
            foreach (explode(',', $orderItemIds) as $id) {
                $orderItem = OrderItem::find($id);
                if ($orderItem) {
                    $orderItem->is_urgent = 0;
                    $orderItem->reject_or_confirm = 1;
                    $orderItem->reject_reason = $rejectReason;
                    $orderItem->suggested_ex_fac_date = $suggestedDate;
                    $orderItem->update();
                }
            }
        } else {
            $orderItem = OrderItem::find($orderItemIds);
            $orderItem->is_urgent = 0;
            $orderItem->reject_or_confirm = 1;
            $orderItem->reject_reason = $rejectReason;
            $orderItem->suggested_ex_fac_date = $suggestedDate;
            $orderItem->update();
        }

        if ($order->factory_confirmation_date == null) {
            $order->factory_confirmation_date = 'Rejected by factory';
        }
        

        $order->reject_or_confirm = 1;
        $order->is_urgent = 0;
        $order->reject_reason = $rejectReason;
        $order->suggested_ex_fac_date = $suggestedDate;
        $order->factory_confirmation_date = 'Waiting for rep Confirmation';
        $order->update();

        

        $existingNotifications = Notification::where('order_id', $orderId)
        ->where('target_notification_field', $notifi_target_field)
        ->where('order_item_id', $orderItemIds)
        ->whereNull('order_reject_or_confirm')->get();

        foreach ($existingNotifications as $existingNotification) {
            $existingNotification->order_reject_or_confirm = 1;
            $existingNotification->update();
        }


        $builder = new NotificationBuilderService();

        $DownloadTestPrint = url('orders/DownloadTestPrint/' . $orderItemIds);
        $quoteCSV_Download = url('orders/csv/' . $order->id);
        $discussionLink    = route('orders.info', ['id' => $order->id, 'type' => 'management']);
        $playerReport = route('store.generatePlayerCSV', ['id' => $order->id]);

        $builder->sendNotification('key_ex_factory_date_rejected', [
            '{order_number}'      => $order->order_no,
            '{order_link}'        => url("order_details/edit/{$orderId}/order") . '?active_tab=order',    
            '{suggested_date}'    => Carbon::parse($suggestedDate)->format('m/d/Y'),
            '{reason}'            => $rejectReason,
            '{discussion_link}'   => $discussionLink,
            '{DownloadTestPrint}' => $DownloadTestPrint,
            '{quoteCSV_Download}' => $quoteCSV_Download,
            '{playerReport}'      => $playerReport,
        ], [
            'order_id'                   => $orderId,
            'order_ex_fac_date'          => $suggestedDate,
            'order_in_hand_due_date'     => $order->due_date,
            'order_item_id'              => $orderItemIds,
            'target_notification_field' => 'key_ex_factory_date_rejected',
            'new_notification'           => 1,

        ]);

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_ex_factory_date_rejected', [
            'orderId'            => $order->id,
            'order_number'       => $order->order_no,
            'customer_details'   => trim(optional($order->contactDetails)->first_name . ' ' . optional($order->contactDetails)->last_name), 
            'organization_name'  => optional($order->organizationDetails)->organization_name ?? '',
            'suggested_date'     => Carbon::parse($suggestedDate)->format('m/d/Y'),
            'reject_reason'      => $rejectReason,
            'order_link'         => url("order_details/edit/{$order->id}/order") . '?active_tab=order',
            'techpack_link'      => $DownloadTestPrint,
            'roster_link'        => $quoteCSV_Download,
            'discussion_link'    => $discussionLink,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'success'
        ], 201);
    }


    // normal order
    public function reject_or_confirm_order_directly(Request $request)
    {
        $notifi_target_field = $request->target_field;
        $orderId = $request->order_id;
        $notificationId = $request->notification_id;
        $orderItemIds = $request->order_item_id;
        $suggestedDate = $request->ex_fac_date;
        $notification = Notification::find($notificationId);
        $order = Order::with('organizationDetails', 'contactDetails')->find($orderId);

        if (isset($request->reject_reason)) {
            $order->reject_or_confirm = 1;
            $order->reject_reason = $request->reject_reason;
            $order->suggested_ex_fac_date = $suggestedDate;
            $order->factory_confirmation_date = 'Waiting for rep Confirmation';
            $order->update();


            if (str_contains($orderItemIds, ',')) {
                foreach (explode(',', $orderItemIds) as $id) {
                    $orderItem = OrderItem::find($id);
                    if ($orderItem) {
                        $orderItem->is_urgent = 0;
                        $orderItem->reject_or_confirm = 1;
                        $orderItem->reject_reason = $request->reject_reason;
                        $orderItem->suggested_ex_fac_date = $suggestedDate;
                        $orderItem->save();
                    }
                }
            } else {
                $orderItem = OrderItem::find($orderItemIds);
                $orderItem->is_urgent = 0;
                $orderItem->reject_or_confirm = 1;
                $orderItem->reject_reason = $request->reject_reason;
                $orderItem->suggested_ex_fac_date = $suggestedDate;
                $orderItem->save();

            }
            

            $notification->order_reject_or_confirm = 1;
            $notification->order_ex_fac_date = $suggestedDate;
            $notification->update();

            $existingNotifications = Notification::where('order_id', $orderId)
            ->where('target_notification_field', $notifi_target_field)
            ->where('order_item_id', $orderItemIds)
            ->whereNull('order_reject_or_confirm')->get();

            foreach ($existingNotifications as $existingNotification) {
                $existingNotification->order_reject_or_confirm = 1;
                $existingNotification->update();
            }


            $DownloadTestPrint = route('DownloadTestPrint', ['id' => $notification->order_item_id]);
            $quoteCSV_Download = route('quoteCSV_Download', ['id' => $order->id]);
            $discussionLink = route('orders.info', ['id' => $order->id, 'type' => 'management']);
            $playerReport = route('store.generatePlayerCSV', ['id' => $order->id]);
            

            $builder = new NotificationBuilderService();

            $builder->sendNotification('key_reject_or_confirm_order_directly', [
                '{order_no}'          => $order->order_no,
                '{order_link}'        => url("order_details/edit/{$order->id}/order") . '?active_tab=order',
                '{ex_fac_date}'       => Carbon::parse($suggestedDate)->format('m/d/Y'),
                '{reject_reason}'     => $request->reject_reason,
                '{discussion_link}'   => $discussionLink, 
                '{DownloadTestPrint}' => $DownloadTestPrint,
                '{quoteCSV_Download}' => $quoteCSV_Download,
                '{playerReport}'      => $playerReport,
            ], [
                'order_id'                   => $orderId,
                'order_in_hand_due_date'     => $notification->order_in_hand_due_date,
                'order_ex_fac_date'          => $suggestedDate,
                'order_item_id'              => $orderItemIds,
                'target_notification_field' => 'key_reject_or_confirm_order_directly',
                'new_notification'           => 1,
            ]);

            app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_reject_or_confirm_order_directly', [
                'orderId'            => $order->id,
                'order_number'       => $order->order_no,
                'send_relevent_factory'  => true,
                'customer_details'   => trim(optional($order->contactDetails)->first_name . ' ' . optional($order->contactDetails)->last_name),
                'organization_name'  => optional($order->organizationDetails)->organization_name ?? '',
                'suggested_date'     => Carbon::parse($suggestedDate)->format('m/d/Y'),
                'reject_reason'      => $request->reject_reason,
                'order_link'         => url("order_details/edit/{$order->id}/order") . '?active_tab=order',
                'techpack_link'      => $DownloadTestPrint,
                'roster_link'        => $quoteCSV_Download,
                'discussion_link'    => $discussionLink,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'success'
            ], 201);
        }

        if (isset($request->confirm_text)) {
            $order->is_urgent = 0;
            $order->factory_confirmation_date = \Carbon\Carbon::now()->format('m/d/Y');
            $order->ex_factory_date = Carbon::parse($notification->order_ex_fac_date)->format('m/d/Y');
            $order->reject_or_confirm = 2;
            $order->update();

           if (str_contains($orderItemIds, ',')) {
                foreach (explode(',', $orderItemIds) as $id) {
                    $orderItem = OrderItem::find($id);
                    if ($orderItem) {
                        $orderItem->is_urgent = 0;
                        $orderItem->reject_or_confirm = 2;
                        $orderItem->update();
                    }
                }
           } else {
                $orderItem = OrderItem::find($orderItemIds);
                if ($orderItem) {
                    $orderItem->is_urgent = 0;
                    $orderItem->reject_or_confirm = 2;
                    $orderItem->update();
                }
           }

            $notification->order_reject_or_confirm = 2;
            $notification->update();

            $existingNotifications = Notification::where('order_id', $orderId)
            ->where('target_notification_field', $notifi_target_field)
            ->where('order_item_id', $orderItemIds)
            ->whereNull('order_reject_or_confirm')->get();

            foreach ($existingNotifications as $existingNotification) {
                $existingNotification->order_reject_or_confirm = 2;
                $existingNotification->update();
            }

            $builder = new NotificationBuilderService();

            $builder->sendNotification('key_rep_confirmed_ex_factory_date_normal', [
                '{order_no}'          => $order->order_no,
                '{order_link}'        => url("order_details/edit/{$order->id}/order") . '?active_tab=order',                                              
                '{ex_factory_date}'   => Carbon::parse($notification->order_ex_fac_date)->format('m/d/Y'),                           
                '{organization_name}' => optional($order->organizationDetails)->organization_name ?? '', 
            ], [
                'order_id'                   => $order->id,
                'order_in_hand_due_date'     => $notification->order_in_hand_due_date,
                'order_ex_fac_date'          => $notification->order_ex_fac_date,
                'order_item_id'              => $orderItemIds,
                'order_reject_or_confirm'    => 2, 
                'target_notification_field' => 'key_rep_confirmed_ex_factory_date_normal',
                'new_notification'           => 1,
            ]);

            $this->create_invoice_by_factory_confirmation($order->id);

            
            app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_rep_confirmed_ex_factory_date_normal', [
                'orderId'            => $order->id,
                'send_relevent_factory'  => true,
                'customer_details'   => trim(optional($order->contactDetails)->first_name . ' ' . optional($order->contactDetails)->last_name),
                'order_number'       => $order->order_no,
                'organization_name'  => optional($order->organizationDetails)->organization_name ?? '',
                'ex_factory_date'    => Carbon::parse($notification->order_ex_fac_date)->format('m/d/Y'),
                'order_link'         => url("order_details/edit/{$order->id}/order") . '?active_tab=order',
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'success'
            ], 200);
        }
    }


    public function reject_or_confirm_factory_suggest(Request $request)
    {
        $notifi_target_field = $request->target_field;
        $orderId = $request->order_id;
        $orderItemIds = $request->order_item_id;
        $suggestedDate = $request->ex_fac_date;
        $notification = Notification::find($request->notification_id);
        $order = Order::with('organizationDetails', 'contactDetails')->find($orderId);
        $order_status = null;

        // ── Rep pushes back with a different date → loops back to factory ──
        if (isset($request->reject_reason)) {
            if ($order->factory_confirmation_date == null) {
                $order->factory_confirmation_date = 'Rejected by factory';
            }
            $order->reject_or_confirm = 1;
            $order->reject_reason = $request->reject_reason;
            $order->suggested_ex_fac_date = $suggestedDate;
            $order->factory_confirmation_date = 'Waiting for factory Confirmation';
            $order->update();

            if (str_contains($orderItemIds, ',')) {
                foreach (explode(',', $orderItemIds) as $id) {
                    $orderItem = OrderItem::find($id);
                    if ($orderItem) {
                        $orderItem->is_urgent = 1;
                        $orderItem->reject_or_confirm = 1;
                        $orderItem->reject_reason = $request->reject_reason;
                        $orderItem->suggested_ex_fac_date = $suggestedDate;
                        $orderItem->update();
                    }
                }
                $order_status = true;
            } else {
                $orderItem = OrderItem::find($orderItemIds);
                $orderItem->is_urgent = 1;
                $orderItem->reject_or_confirm = 1;
                $orderItem->reject_reason = $request->reject_reason;
                $orderItem->suggested_ex_fac_date = $suggestedDate;
                $orderItem->update();
                $order_status = false;
            }
            

            $notification->order_reject_or_confirm = 1;
            $notification->order_ex_fac_date = $suggestedDate;
            $notification->update();


            $existingNotifications = Notification::where('order_id', $orderId)
            ->where('target_notification_field', $notifi_target_field)
            ->where('order_item_id', $orderItemIds)->where('is_urgent', 1)
            ->whereNull('order_reject_or_confirm')->get();

            foreach ($existingNotifications as $existingNotification) {
                $existingNotification->order_reject_or_confirm = 1;
                $existingNotification->update();
            }
            

            $this->notifyFactoryUsersExFac($order->id, $orderItemIds, $suggestedDate, $request->reject_reason, $order_status);

            return response()->json(['status' => true, 'message' => 'success'], 200);
        }

        // ── Rep confirms factory's suggested date → terminal, notify factory ──
        if (isset($request->confirm_text)) {
            ExFactoryDateFacade::create($order->id, Auth::user()->name, $order->ex_factory_date, $notification->order_ex_fac_date, 'Factory suggested ex-factory date has been confirmed by rep');

            $order->is_urgent = 1;
            $order->factory_confirmation_date = \Carbon\Carbon::now()->format('m/d/Y');
            $order->ex_factory_date = Carbon::parse($notification->order_ex_fac_date)->format('m/d/Y');
            $order->reject_or_confirm = 2;
            $order->update();

            if (str_contains($orderItemIds, ',')) {
                foreach (explode(',', $orderItemIds) as $id) {
                    $orderItem = OrderItem::find($id);
                    if ($orderItem) {
                        $orderItem->is_urgent = 1;
                        $orderItem->reject_or_confirm = 2;
                        $orderItem->ex_factory_date = $notification->order_ex_fac_date;
                        $orderItem->update();
                    }
                }
            } else {
                $orderItem = OrderItem::find($orderItemIds);
                if ($orderItem) {
                    $orderItem->is_urgent = 1;
                    $orderItem->reject_or_confirm = 2;
                    $orderItem->ex_factory_date = $notification->order_ex_fac_date;
                    $orderItem->update();
                }
            }
            

            $notification->order_reject_or_confirm = 2;
            $notification->update();

            $existingNotifications = Notification::where('order_id', $orderId)
            ->where('target_notification_field', $notifi_target_field)
            ->where('order_item_id', $orderItemIds)->where('is_urgent', 1)
            ->whereNull('order_reject_or_confirm')->get();

            foreach ($existingNotifications as $existingNotification) {
                $existingNotification->order_reject_or_confirm = 2;
                $existingNotification->update();
            }


            $builder = new NotificationBuilderService();
            $builder->sendNotification('key_rep_confirmed_ex_factory_date_urgent', [
                '{order_no}'         => $order->order_no,
                '{order_link}'        => url("order_details/edit/{$order->id}/order") . '?active_tab=order', 
                '{order_ex_fac_date}' => Carbon::parse($notification->order_ex_fac_date)->format('m/d/Y'),
            ], [
                'order_id'                => $orderId,
                'order_item_id'           => $orderItemIds,
                'order_reject_or_confirm' => 2,
                'target_notification_field' => 'key_rep_confirmed_ex_factory_date_urgent',
                'new_notification'       => 1,
            ]);

            $this->create_invoice_by_factory_confirmation($order->id);

            app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_rep_confirmed_ex_factory_date_urgent', [
                'orderId'            => $order->id,
                'send_relevent_factory'  => true,
                'order_number'       => $order->order_no,
                'customer_details'   => trim(optional($order->contactDetails)->first_name . ' ' . optional($order->contactDetails)->last_name),
                'organization_name'  => optional($order->organizationDetails)->organization_name ?? '',
                'ex_factory_date'    => Carbon::parse($notification->order_ex_fac_date)->format('m/d/Y'),
                'order_link'         => url("order_details/edit/{$order->id}/order") . '?active_tab=order',
            ]);

            return response()->json(['status' => true, 'message' => 'success'], 201);
        }
    }


    public function notifyFactoryUsersExFac($orderId, $orderItemIds, $order_ex_fac_date_suggest, $rejectReason = '', $order_status)
    {
        $orderDetails = Order::with('organizationDetails', 'contactDetails')->find($orderId);
        if (!$orderDetails) {
            return false;
        }

        if ($order_status == true) {

            $discussionLink = route('orders.info', ['id' => $orderId, 'type' => 'management']);
            $templateKey = 'key_reject_or_confirm_factory_suggest';

            $orderItems = OrderItem::where('order_id', $orderId)->get();

            // Build styled item rows (icon dot + qty badge, alternating background) — matches design
            $itemListHtml = '';
            foreach ($orderItems as $index => $orderItem) {
                $optional_text = $orderItem->item_description ? ' - ' . $orderItem->item_description : '';
                $sub_product_name = SubProduct::where('sub_product_no', $orderItem->sub_product_no)->first()->product_name ?? '';
                $bg = ($index % 2 === 0) ? 'background:#f9fafb;' : '';
                $borderTop = ($index === 0) ? '' : 'border-top:1px solid #f0f0f0;';

                $itemListHtml .= '<div style="display:flex;align-items:center;justify-content:space-between;gap:10px;padding:12px 16px;font-size:13px;color:#1f2937;' . $bg . $borderTop . '">'
                    . '<span style="display:flex;align-items:center;gap:9px;">'
                    . '<span style="width:7px;height:7px;border-radius:50%;background:#0d9488;flex-shrink:0;display:inline-block;"></span>'
                    . $sub_product_name . $optional_text
                    . '</span>'
                    . '<span style="background:#eef2f7;color:#4b5563;font-size:11px;font-weight:700;padding:3px 10px;border-radius:5px;white-space:nowrap;">Qty - ' . $orderItem->qty . '</span>'
                    . '</div>';
            }

            $ids = $orderItems->pluck('id')->toArray();
            $commaSeparatedIds = implode(',', $ids);

            $builder = new NotificationBuilderService();
            $builder->sendNotification(
                $templateKey,
                [
                    '{order_no}'          => $orderDetails->order_no,
                    '{order_link}'        => url("order_details/edit/{$orderId}/order") . '?active_tab=order', 
                    '{ex_fac_date}'       => Carbon::parse($order_ex_fac_date_suggest)->format('m/d/Y'),
                    '{organization_name}' => optional($orderDetails->organizationDetails)->organization_name ?? '',
                    '{reject_reason}'     => $rejectReason,
                    '{item_list}'         => $itemListHtml,
                    '{discussion_link}'   => $discussionLink,
                ],
                [
                    'order_id'                   => $orderId,
                    'order_item_id'              => $commaSeparatedIds,
                    'is_urgent'                  => 1,
                    'order_ex_fac_date'          => $order_ex_fac_date_suggest,
                    'order_in_hand_due_date'     => $orderDetails->due_date,
                    'order_reject_or_confirm'    => null,
                    'target_notification_field' => $templateKey,
                    'new_notification'           => 1,
                ]
            );

            app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_reject_or_confirm_factory_suggest', [
                'orderId'            => $orderId,
                'send_relevent_factory'  => true,
                'order_number'       => $orderDetails->order_no,
                'customer_details'   => trim(optional($orderDetails->contactDetails)->first_name . ' ' . optional($orderDetails->contactDetails)->last_name),
                'organization_name'  => optional($orderDetails->organizationDetails)->organization_name ?? '',
                'ex_fac_date'        => Carbon::parse($order_ex_fac_date_suggest)->format('m/d/Y'),
                'reject_reason'      => $rejectReason,
                'order_items_list'   => $itemListHtml,
                'order_link'         => url("order_details/edit/{$orderId}/order") . '?active_tab=order',
            ]);
            
        } else {
            $discussionLink = route('orders.info', ['id' => $orderId, 'type' => 'management']);
            $templateKey = 'key_reject_or_confirm_factory_suggest';
            $orderItems = OrderItem::find($orderItemIds);
            $itemListHtml = '';

            $optional_text = $orderItems->item_description ? ' - ' . $orderItems->item_description : '';
            $sub_product_name = SubProduct::where('sub_product_no', $orderItems->sub_product_no)->first()->product_name ?? '';
            $bg = 'background:#f9fafb;';
            $borderTop = 'border-top:1px solid #f0f0f0;';

            $itemListHtml .= '<div style="display:flex;align-items:center;justify-content:space-between;gap:10px;padding:12px 16px;font-size:13px;color:#1f2937;' . $bg . $borderTop . '">'
                . '<span style="display:flex;align-items:center;gap:9px;">'
                . '<span style="width:7px;height:7px;border-radius:50%;background:#0d9488;flex-shrink:0;display:inline-block;"></span>'
                . $sub_product_name . $optional_text
                . '</span>'
                . '<span style="background:#eef2f7;color:#4b5563;font-size:11px;font-weight:700;padding:3px 10px;border-radius:5px;white-space:nowrap;">Qty - ' . $orderItems->qty . '</span>'
                . '</div>';

            $builder = new NotificationBuilderService();
            $builder->sendNotification(
                'key_reject_or_confirm_factory_suggest',
                [
                    '{order_no}'          => $orderId,
                    '{order_link}'        => url("order_details/edit/{$orderId}/order") . '?active_tab=order', 
                    '{ex_fac_date}'       => Carbon::parse($order_ex_fac_date_suggest)->format('m/d/Y'),
                    '{organization_name}' => optional($orderDetails->organizationDetails)->organization_name ?? '',
                    '{reject_reason}'     => $rejectReason,
                    '{item_list}'         => $itemListHtml,
                    '{discussion_link}'   => $discussionLink,
                ],
                [
                    'order_id'                   => $orderId,
                    'order_item_id'              => $orderItemIds,
                    'is_urgent'                  => 1,
                    'order_ex_fac_date'          => $order_ex_fac_date_suggest,
                    'order_in_hand_due_date'     => $orderDetails->due_date,
                    'order_reject_or_confirm'    => null,
                    'target_notification_field' => $templateKey,
                    'new_notification'           => 1,
                ]
            );
            
            app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_reject_or_confirm_factory_suggest', [
                'orderId'            => $orderId,
                'send_relevent_factory'  => true,
                'order_number'       => $orderDetails->order_no,
                'customer_details'   => trim(optional($orderDetails->contactDetails)->first_name . ' ' . optional($orderDetails->contactDetails)->last_name),
                'organization_name'  => optional($orderDetails->organizationDetails)->organization_name ?? '',
                'ex_fac_date'        => Carbon::parse($order_ex_fac_date_suggest)->format('m/d/Y'),
                'reject_reason'      => $rejectReason,
                'order_items_list'   => $itemListHtml,
                'order_link'         => url("order_details/edit/{$orderId}/order") . '?active_tab=order',
            ]);

        }

        return true;
    }




    public function create_invoice_by_factory_confirmation($order_id)
    {
        $isExist = FactoryInvoice::where('order_id', $order_id)->where('active', 1)->exists();

        if (!$isExist) {
            $maxId = FactoryInvoice::max('id');
            $invoice_no = 'INV' . str_pad(($maxId + 1), 4, "0", STR_PAD_LEFT);

            $invoice = new FactoryInvoice();
            $invoice->invoice_number = $invoice_no;
            $invoice->order_id = $order_id;
            $invoice->total_amount = 0;
            $invoice->sub_total = 0;
            $invoice->reduce_value = 0;
            $invoice->status = 0;
            $invoice->save();

            $invoiceId = $invoice->id;

            $order_items = orderItem::where('factory_id', 1)->where('active', 1)->where('order_id', $order_id)->get();

            $sum = 0.00;

            foreach ($order_items as $order_item) {
                $manufacture = Price::where('price_type', '5')->where('active', 1)->where('product_id', $order_item->product_id)->first();
                $manufacture_price = $manufacture ? $manufacture->price : 0.00;
                InvoiceProduct::create([
                    'invoice_id' => $invoiceId,
                    'product_id' => $order_item->product_id,
                    'qty' => $order_item->qty,
                    'order_item_id' => $order_item->id,
                    'unit_price' => $manufacture_price,
                    'total_price' => $manufacture_price * $order_item->qty,
                ]);

                $sum += $manufacture_price * $order_item->qty;
            }

            $saved_invoice = FactoryInvoice::find($invoiceId);
            $saved_invoice->total_amount = number_format($sum, 2, '.', '');
            $saved_invoice->sub_total = number_format($sum, 2, '.', '');
            $saved_invoice->save();
        }
    }

    // -------------------------------------------------------------------------------------------------------------------------


    public function index2()
    {
        return view('pages.settings.notifications.newindex2');
    }


    public function getAllNotifications2(Request $request)
    {
        $perPage    = $request->get('per_page', 20);
        $page       = $request->get('page', 1);
        $filterGroup = $request->get('filter_group', '');
        $filterDate  = $request->get('filter_date', '');
        $search = $request->get('search', '');

        $query = Notification::with(['orderDetails.organizationDetails'])
            ->where('user_id', Auth::id())
            ->where('active', 1);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('notification_title', 'like', "%{$search}%")
                    ->orWhere('notification_message', 'like', "%{$search}%");
            });
        }

        // ── Date filter (calendar picks exact date) ──────────────────
        if (!empty($filterDate)) {
            $query->whereDate('created_at', $filterDate);
        }

        // ── Group filter (dropdown: today / yesterday / this_month / this_year) ──
        elseif (!empty($filterGroup)) {
            switch ($filterGroup) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', Carbon::yesterday());
                    break;
                case 'this_month':
                    $query->whereYear('created_at', Carbon::now()->year)
                        ->whereMonth('created_at', Carbon::now()->month);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', Carbon::now()->year);
                    break;
            }
        }

        $query->latest();

        $total      = $query->count();
        $offset     = ($page - 1) * $perPage;
        $notifications = $query->skip($offset)->take($perPage)->get();

        $items = [];

        foreach ($notifications as $notification) {
            $created = Carbon::parse($notification->created_at);

            if ($created->isToday()) {
                $displayTime = $created->format('h:i A');      
            } elseif ($created->isYesterday()) {
                $displayTime = 'Yesterday';                    
            } else {
                $displayTime = $created->format('d M Y');
            }

            if (
                $notification->notification_message == "Payment Done!" && $notification->orderDetails && $notification->orderDetails->organizationDetails
            ) {
                $notification->notification_message .= ' - ' . $notification->orderDetails->organizationDetails->organization_name;
            }

            $items[] = [
                'id'           => $notification->id,
                'title'        => $notification->notification_title,
                'message'      => strip_tags($notification->notification_message),
                'org_message'  => $notification->notification_message,
                'is_read'      => (bool) $notification->is_read,
                'created_at'   => $notification->created_at,
                'display_time' => $displayTime,
                'source'       => $this->getSource($notification),
                'icon'         => $this->getIcon($notification),
                'icon_class'   => $this->getIconClass($notification),
                'badge'        => $this->getBadge($notification),
                'badge_red'    => false,
                'starred'      => (bool) $notification->is_mark,
                'new_notification' => $notification->new_notification
            ];
        }

        return response()->json([
            'data' => $items,
            'pagination' => [
                'total'        => $total,
                'per_page'     => $perPage,
                'current_page' => $page,
                'last_page'    => (int) ceil($total / max($perPage, 1)),
                'from'         => $total > 0 ? $offset + 1 : 0,
                'to'           => min($offset + $perPage, $total),
            ],
            'active_filter' => !empty($filterDate) ? $filterDate : $filterGroup,
        ]);
    }

    public function getAllUnreadNotifications2(Request $request)
    {
        $perPage     = $request->get('per_page', 20);
        $page        = $request->get('page', 1);
        $filterGroup = $request->get('filter_group', '');
        $filterDate  = $request->get('filter_date', '');
        $search = $request->get('search', '');

        $query = Notification::with(['orderDetails.organizationDetails'])
            ->where('user_id', Auth::id())
            ->where('active', 1)
            ->where('is_read', 0);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('notification_title', 'like', "%{$search}%")
                    ->orWhere('notification_message', 'like', "%{$search}%");
            });
        }

        if (!empty($filterDate)) {
            $query->whereDate('created_at', $filterDate);
        } elseif (!empty($filterGroup)) {
            switch ($filterGroup) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', Carbon::yesterday());
                    break;
                case 'this_month':
                    $query->whereYear('created_at', Carbon::now()->year)
                        ->whereMonth('created_at', Carbon::now()->month);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', Carbon::now()->year);
                    break;
            }
        }

        $query->latest();

        $total      = $query->count();
        $offset     = ($page - 1) * $perPage;
        $notifications = $query->skip($offset)->take($perPage)->get();

        $items = [];

        foreach ($notifications as $notification) {
            $created = Carbon::parse($notification->created_at);

            if ($created->isToday()) {
                $displayTime = $created->format('h:i A');      
            } elseif ($created->isYesterday()) {
                $displayTime = 'Yesterday';                    
            } else {
                $displayTime = $created->format('d M Y');
            }

            if (
                $notification->notification_message == "Payment Done!" && $notification->orderDetails && $notification->orderDetails->organizationDetails
            ) {
                $notification->notification_message .= ' - ' . $notification->orderDetails->organizationDetails->organization_name;
            }

            $items[] = [
                'id'           => $notification->id,
                'title'        => $notification->notification_title,
                'message'      => strip_tags($notification->notification_message),
                'org_message'  => $notification->notification_message,
                'is_read'      => (bool) $notification->is_read,
                'created_at'   => $notification->created_at,
                'display_time' => $displayTime,
                'source'       => $this->getSource($notification),
                'icon'         => $this->getIcon($notification),
                'icon_class'   => $this->getIconClass($notification),
                'badge'        => $this->getBadge($notification),
                'badge_red'    => false,
                'starred'      => (bool) $notification->is_mark,
                'new_notification' => $notification->new_notification
            ];
        }

        return response()->json([
            'data' => $items,
            'pagination' => [
                'total'        => $total,
                'per_page'     => $perPage,
                'current_page' => $page,
                'last_page'    => (int) ceil($total / max($perPage, 1)),
                'from'         => $total > 0 ? $offset + 1 : 0,
                'to'           => min($offset + $perPage, $total),
            ],
            'active_filter' => !empty($filterDate) ? $filterDate : $filterGroup,
        ]);
    }

    public function getAllMentionNotifications2(Request $request)
    {
        $perPage     = $request->get('per_page', 20);
        $page        = $request->get('page', 1);
        $filterGroup = $request->get('filter_group', '');
        $filterDate  = $request->get('filter_date', '');
        $search = $request->get('search', '');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('notification_title', 'like', "%{$search}%")
                    ->orWhere('notification_message', 'like', "%{$search}%");
            });
        }

        $query = Notification::with(['orderDetails.organizationDetails'])
            ->where('user_id', Auth::id())
            ->where('active', 1)
            ->where('is_comment', 1);

        if (!empty($filterDate)) {
            $query->whereDate('created_at', $filterDate);
        } elseif (!empty($filterGroup)) {
            switch ($filterGroup) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', Carbon::yesterday());
                    break;
                case 'this_month':
                    $query->whereYear('created_at', Carbon::now()->year)
                        ->whereMonth('created_at', Carbon::now()->month);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', Carbon::now()->year);
                    break;
            }
        }

        $query->latest();

        $total      = $query->count();
        $offset     = ($page - 1) * $perPage;
        $notifications = $query->skip($offset)->take($perPage)->get();

        $items = [];

        foreach ($notifications as $notification) {
            $created = Carbon::parse($notification->created_at);

            if ($created->isToday()) {
                $displayTime = $created->format('h:i A');      
            } elseif ($created->isYesterday()) {
                $displayTime = 'Yesterday';                    
            } else {
                $displayTime = $created->format('d M Y');
            }

            if (
                $notification->notification_message == "Payment Done!" && $notification->orderDetails && $notification->orderDetails->organizationDetails
            ) {
                $notification->notification_message .= ' - ' . $notification->orderDetails->organizationDetails->organization_name;
            }

            $items[] = [
                'id'           => $notification->id,
                'title'        => $notification->notification_title,
                'message'      => strip_tags($notification->notification_message),
                'org_message'  => $notification->notification_message,
                'is_read'      => (bool) $notification->is_read,
                'created_at'   => $notification->created_at,
                'display_time' => $displayTime,
                'source'       => $this->getSource($notification),
                'icon'         => $this->getIcon($notification),
                'icon_class'   => $this->getIconClass($notification),
                'badge'        => $this->getBadge($notification),
                'badge_red'    => false,
                'starred'      => (bool) $notification->is_mark,
                'new_notification' => $notification->new_notification
            ];
        }

        return response()->json([
            'data' => $items,
            'pagination' => [
                'total'        => $total,
                'per_page'     => $perPage,
                'current_page' => $page,
                'last_page'    => (int) ceil($total / max($perPage, 1)),
                'from'         => $total > 0 ? $offset + 1 : 0,
                'to'           => min($offset + $perPage, $total),
            ],
            'active_filter' => !empty($filterDate) ? $filterDate : $filterGroup,
        ]);
    }


    public function getAllMarkedNotifications2(Request $request)
    {
        $perPage     = $request->get('per_page', 20);
        $page        = $request->get('page', 1);
        $filterGroup = $request->get('filter_group', '');
        $filterDate  = $request->get('filter_date', '');
        $search = $request->get('search', '');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('notification_title', 'like', "%{$search}%")
                    ->orWhere('notification_message', 'like', "%{$search}%");
            });
        }

        $query = Notification::with(['orderDetails.organizationDetails'])
            ->where('user_id', Auth::id())
            ->where('active', 1)
            ->where('is_mark', 1);

        if (!empty($filterDate)) {
            $query->whereDate('created_at', $filterDate);
        } elseif (!empty($filterGroup)) {
            switch ($filterGroup) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', Carbon::yesterday());
                    break;
                case 'this_month':
                    $query->whereYear('created_at', Carbon::now()->year)
                        ->whereMonth('created_at', Carbon::now()->month);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', Carbon::now()->year);
                    break;
            }
        }

        $query->latest();

        $total      = $query->count();
        $offset     = ($page - 1) * $perPage;
        $notifications = $query->skip($offset)->take($perPage)->get();

        $items = [];

        foreach ($notifications as $notification) {
            $created = Carbon::parse($notification->created_at);

            if ($created->isToday()) {
                $displayTime = $created->format('h:i A');      
            } elseif ($created->isYesterday()) {
                $displayTime = 'Yesterday';                    
            } else {
                $displayTime = $created->format('d M Y');
            }

            if (
                $notification->notification_message == "Payment Done!" && $notification->orderDetails && $notification->orderDetails->organizationDetails
            ) {
                $notification->notification_message .= ' - ' . $notification->orderDetails->organizationDetails->organization_name;
            }

            $items[] = [
                'id'           => $notification->id,
                'title'        => $notification->notification_title,
                'message'      => strip_tags($notification->notification_message),
                'org_message'  => $notification->notification_message,
                'is_read'      => (bool) $notification->is_read,
                'created_at'   => $notification->created_at,
                'display_time' => $displayTime,
                'source'       => $this->getSource($notification),
                'icon'         => $this->getIcon($notification),
                'icon_class'   => $this->getIconClass($notification),
                'badge'        => $this->getBadge($notification),
                'badge_red'    => false,
                'starred'      => (bool) $notification->is_mark,
                'new_notification' => $notification->new_notification
            ];
        }

        return response()->json([
            'data' => $items,
            'pagination' => [
                'total'        => $total,
                'per_page'     => $perPage,
                'current_page' => $page,
                'last_page'    => (int) ceil($total / max($perPage, 1)),
                'from'         => $total > 0 ? $offset + 1 : 0,
                'to'           => min($offset + $perPage, $total),
            ],
            'active_filter' => !empty($filterDate) ? $filterDate : $filterGroup,
        ]);
    }


    public function initialCount()
    {
        $userId = Auth::id();

        $initialCount = [
            'unread' => Notification::where('user_id', $userId)
                ->where('active', 1)
                ->where('is_read', 0)
                ->count(),

            'mention' => Notification::where('user_id', $userId)
                ->where('active', 1)
                ->where('is_comment', 1)
                ->count(),

            'marked' => Notification::where('user_id', $userId)
                ->where('active', 1)
                ->where('is_mark', 1)
                ->count(),
        ];

        return response()->json([
            'status' => true,
            'data' => $initialCount,
        ]);
    }


    public function checkApproveAjax(Request $request)
    {
        $checkPayment = CheckPayment::find($request->check_payment_id);

        $sumOfPayments = $this->getSumOfPayments($checkPayment->order_id);

        $checkPayment->amount = $request->approve_amount;
        $checkPayment->is_approved = $request->is_approved;
        if ($request->reject_reason) {
            $checkPayment->reject_reason = $request->reject_reason;
        } else {
            $checkPayment->reject_reason = null;
        }
        $checkPayment->update();

        if ($request->is_approved == 3) {
            return response()->json(['status' => true, 'message' => 'Check Rejected Successfully!']);
        }

        $summaryAtPaymentrow = SummaryAtPayment::where('transaction_id', 'CHK' . $request->check_payment_id)->first();

        if ($summaryAtPaymentrow) {
            $summaryAtPaymentrow->active = 1;
            $summaryAtPaymentrow->created_at = Carbon::now();
            $summaryAtPaymentrow->save();
        }

        AccountsLog::where('order_id', $checkPayment->order_id)
            ->where('type', 0)->where('status', 1)
            ->where('note', 'Outstanding Invoice')->where('active', 0)
            ->update(['active' => 1]);

        $orderDetails = Order::where('id', $checkPayment->order_id)->first();

        if ($orderDetails && ($sumOfPayments + ($checkPayment->amount)) > $orderDetails->order_total) {
            $debitEntry = new DebitEntry();
            $debitEntry->organization_id = $orderDetails->organization_id;
            $debitEntry->order_id = $orderDetails->id;
            $debitEntry->transaction_id = $checkPayment->id;
            $debitEntry->transaction_type = 'CHECK';
            $debitEntry->amount = ($sumOfPayments + ($checkPayment->amount)) - $orderDetails->order_total;
            $debitEntry->note = 'Exess From CHQ' . $checkPayment->id . ' (#' . $orderDetails->order_no . ')';
            $debitEntry->created_at = $checkPayment->created_at->copy()->addMinutes(1);
            $debitEntry->save();
        }

        return response()->json(['status' => true, 'message' => 'Check Approved Successfully!']);
    }

    public function venmoApproveAjax(Request $request)
    {
        $venmoPayment = VenmoPayment::find($request->venmo_payment_id);

        $sumOfPayments = $this->getSumOfPayments($venmoPayment->order_id);

        $venmoPayment->amount = $request->approve_amount;
        $venmoPayment->is_approved = $request->is_approved;
        if ($request->reject_reason) {
            $venmoPayment->reject_reason = $request->reject_reason;
        } else {
            $venmoPayment->reject_reason = null;
        }
        $venmoPayment->update();

        if ($request->is_approved == 3) {
            return response()->json(['status' => true, 'message' => 'Venmo Rejected Successfully!']);
        }

        $summaryAtPaymentrow = SummaryAtPayment::where('transaction_id', 'VENMO' . $request->venmo_payment_id)->first();

        if ($summaryAtPaymentrow) {
            $summaryAtPaymentrow->active = 1;
            $summaryAtPaymentrow->created_at = Carbon::now();
            $summaryAtPaymentrow->save();
        }

        AccountsLog::where('order_id', $venmoPayment->order_id)
            ->where('type', 0)->where('status', 1)
            ->where('note', 'Outstanding Invoice')->where('active', 0)
            ->update(['active' => 1]);

        $orderDetails = Order::where('id', $venmoPayment->order_id)->first();

        if ($orderDetails && ($sumOfPayments + ($venmoPayment->amount)) > $orderDetails->order_total) {
            $debitEntry = new DebitEntry();
            $debitEntry->organization_id = $orderDetails->organization_id;
            $debitEntry->order_id = $orderDetails->id;
            $debitEntry->transaction_id = $venmoPayment->id;
            $debitEntry->transaction_type = 'VENMO';
            $debitEntry->amount = ($sumOfPayments + ($venmoPayment->amount)) - $orderDetails->order_total;
            $debitEntry->note = 'Exess From VNM' . $venmoPayment->id . ' (#' . $orderDetails->order_no . ')';
            $debitEntry->created_at = $venmoPayment->created_at->copy()->addMinutes(1);
            $debitEntry->save();
        }

        return response()->json(['status' => true, 'message' => 'Venmo Approved Successfully!']);
    }

    public function paypalApproveAjax(Request $request)
    {
        $paypalPayment = PaypalPayment::find($request->paypal_payment_id);

        $sumOfPayments = $this->getSumOfPayments($paypalPayment->order_id);

        $paypalPayment->amount = $request->approve_amount;
        $paypalPayment->is_approved = $request->is_approved;
        if ($request->reject_reason) {
            $paypalPayment->reject_reason = $request->reject_reason;
        } else {
            $paypalPayment->reject_reason = null;
        }
        $paypalPayment->update();

        if ($request->is_approved == 3) {
            return response()->json(['status' => true, 'message' => 'PayPal Rejected Successfully!']);
        }

        $summaryAtPaymentrow = SummaryAtPayment::where('transaction_id', 'PAYPAL' . $request->paypal_payment_id)->first();

        if ($summaryAtPaymentrow) {
            $summaryAtPaymentrow->active = 1;
            $summaryAtPaymentrow->created_at = Carbon::now();
            $summaryAtPaymentrow->save();
        }

        AccountsLog::where('order_id', $paypalPayment->order_id)
            ->where('type', 0)->where('status', 1)
            ->where('note', 'Outstanding Invoice')->where('active', 0)
            ->update(['active' => 1]);

        $orderDetails = Order::where('id', $paypalPayment->order_id)->first();

        if ($orderDetails && ($sumOfPayments + ($paypalPayment->amount * 100 / 103)) > $orderDetails->order_total) {
            $debitEntry = new DebitEntry();
            $debitEntry->organization_id = $orderDetails->organization_id;
            $debitEntry->order_id = $orderDetails->id;
            $debitEntry->transaction_id = $paypalPayment->id;
            $debitEntry->transaction_type = 'Paypal';
            $debitEntry->amount = ($sumOfPayments + ($paypalPayment->amount * 100 / 103)) - $orderDetails->order_total;
            $debitEntry->note = 'Exess From PAYPAL' . $paypalPayment->id . ' (#' . $orderDetails->order_no . ')';
            $debitEntry->created_at = $paypalPayment->created_at->copy()->addMinutes(1);
            $debitEntry->save();
        }

        return response()->json(['status' => true, 'message' => 'PayPal Approved Successfully!']);
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


    
    


}
