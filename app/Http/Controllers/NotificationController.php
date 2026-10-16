<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\OrderItem;
use App\Models\CheckPayment;
use App\Models\OtherPayment;
use App\Models\Notification;
use App\Models\Organization;
use App\Models\VenmoPayment;
use App\Models\FactoryInvoice;
use App\Models\InvoiceProduct;
use App\Models\Price;
use App\Models\NotificationTemplate;
use App\Models\NotificationTemplateUser;
use App\Models\EmailNotification;
use App\Models\ContactOrganization;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationBuilderService;
use App\Models\EmailNotificationTemplateUser;
use Carbon\Carbon;
use domainencore\Facades\OrderDatesFacade\ExFactoryDateFacade;
use Illuminate\Support\Facades\DB;


class NotificationController extends Controller
{
    public function index(){
            $users = User::where('active',1)->orderBy('name')->get();

            $userGroups = Role::where('active','1')->orderBy('name')->get();

            $orders = Order::where('active', 1)->orderBy('order_no')->get();

            $contacts = Contact::where('active', 1)->orderBy('first_name')->get();

            $organizations = Organization::where('active', 1)->orderBy('organization_name')->get();

            $notifications = Notification::with('orderDetails')->orderBy('created_at', 'DESC')->where('user_id', Auth::user()->id)->get();

        foreach($notifications as $notification )
            {
                $current_notification_message = $notification->notification_message;
                if($current_notification_message == "Payment Done!")
                {
                    $organizationName = Organization::select('organization_name')->where('id', $notification->orderDetails['organization_id'])->get();
                    $notification->notification_message = $current_notification_message . " - " . $organizationName[0]->organization_name;
                }
            }


            return view('pages.settings.notifications.index', [
                'users'=>$users,
                'orders'=>$orders,
                'contacts'=>$contacts,
                'organizations'=>$organizations,
                'notifications'=>$notifications,
                'userGroups'=>$userGroups
            ]);
    }

    public function settings_index(){
        return view('pages.settings.notifications.settings');
    }
    public function email_settings_index(){
        return view('pages.settings.notifications.email.settings');
    }
    public function unreadCount()
    {
        $userId = Auth::id();

        if (!$userId) {
            abort(401);
        }

        return response()->stream(function () use ($userId) {

            while (!connection_aborted()) {

                try {
                    $unreadCount = Notification::where('user_id', $userId)
                        ->where('is_read', 0)
                        ->count();

                    echo "data: " . json_encode([
                        'unreadCount' => $unreadCount
                    ]) . "\n\n";

                    if (ob_get_level() > 0) {
                        ob_flush();
                    }

                    flush();

                } catch (\Exception $e) {
                    \Log::error('Notification SSE Error', [
                        'message' => $e->getMessage(),
                        'user_id' => $userId,
                    ]);

                    echo "data: " . json_encode([
                        'unreadCount' => 0
                    ]) . "\n\n";

                    flush();
                }

                sleep(60);
            }
        }, 200, [
            'Content-Type'      => 'text/event-stream',
            'Cache-Control'     => 'no-cache, no-store, must-revalidate',
            'Pragma'            => 'no-cache',
            'Expires'           => '0',
            'X-Accel-Buffering' => 'no', // Nginx
        ]);
    }

    public function readNotification($id) {
        $notification = Notification::find($id);
        $notification->is_read = 1;
        $notification->update();

        return json_encode('Notification Read!');
    }

    public function getDetails($id) {
        $data = array();

        $notification = Notification::with('orderDetails', 'orderDetails.organizationDetails')->find($id);

        if ($notification->check_payment_id) {
            $checkPayment = CheckPayment::find($notification->check_payment_id);
        } else {
            $checkPayment = '';
        }

        if ($notification->venmo_payment_id) {
            $venmoPayment = VenmoPayment::find($notification->venmo_payment_id);
        } else {
            $venmoPayment = '';
        }
        if ($notification->other_payment_id) {
            $OtherPayment = OtherPayment::find($notification->other_payment_id);
        } else {
            $OtherPayment = '';
        }

        if ($notification->is_payment == 1) {
            $orderDetails = Order::with('organizationDetails')->find($notification->order_id);
        } else {
            $orderDetails = '';
        }

        $data['notification'] = $notification;
        $data['check_payment'] = $checkPayment;
        $data['venmo_payment'] = $venmoPayment;
        $data['other_payment'] = $OtherPayment;
        $data['order_details'] = $orderDetails;

        return json_encode($data);
    }

    public function checkApprove(Request $request) {
        $checkPayment = CheckPayment::find($request->check_payment_id);
        $checkPayment->amount = $request->check_amount;
        $checkPayment->is_approved = 1;
        $checkPayment->update();

        return redirect()->back()->withSuccess('Check Approved Successfully!');
    }

    public function delete($id) {
        $notification = Notification::find($id);
        $notification->active = 0;
        $notification->update();

        return json_encode('Notification Deleted!');
    }

    public function unread($id) {
        $notification = Notification::find($id);
        $notification->is_read = 0;
        $notification->update();

        return json_encode('Notification Unread!');
    }

    public function markAsRead(Request $request){
         $notifications = $request->allid;
        //  return json_encode( $notifications);
         foreach ($notifications as $notification) {
            // Notification::whereIn('id',[$notification])->is_read = 1;
            $notificationRow = Notification::find($notification);
           $notificationRow->is_read = 1;
           // return json_encode( $notification);
           // return json_encode($notification);
           // $notification_id++;
           //$notifications->update();
           $notificationRow->update();
        }

        return json_encode('Notifications mark as read!');

    }

    public function  markAsUnRead(Request $request){
        $notifications = $request->allid;
       //  return json_encode( $notifications);
        foreach ($notifications as $notification) {
           // Notification::whereIn('id',[$notification])->is_read = 1;
           $notificationRow = Notification::find($notification);
          $notificationRow->is_read = 0;
          // return json_encode( $notification);
          // return json_encode($notification);
          // $notification_id++;
          //$notifications->update();
          $notificationRow->update();
       }

       return json_encode('Notifications mark as unread!');

   }

   public function reject(Request $request){
        $rejectReason = $request->input('reject_reason');
        $suggestedDate = $request->input('suggested_date');
        $orderId = $request->order_id;
        $notificationId = $request->notificationId;

        $order = Order::with('organizationDetails')->find($orderId);
        $order->is_urgent = 1;
        $order->factory_confirmation_date = 'Waiting for rep Confirmation';
        $order->reject_or_confirm = 1;
        // $order->reject_reason = $rejectReason;
        $order->suggested_ex_fac_date = $suggestedDate;
        $order->update();

        $orderItemIdString = $request->order_item_id;

        $orderItemIds = explode(',', $orderItemIdString);
        $orderItems = [];

        foreach ($orderItemIds as $orderIds) {
            $orderItem = OrderItem::find($orderIds);
            $orderItem->is_urgent = 1;
            $orderItem->reject_or_confirm = 1;
            $orderItem->reject_reason = $rejectReason;
            $orderItem->suggested_ex_fac_date = $suggestedDate;
            $orderItem->update();
        }

        // $allOrderItems = OrderItem::where('order_id', $orderId)->get();

        // $allConfirmed = $allOrderItems->every(function ($rejectedOrderItem) {
        //     return $rejectedOrderItem->reject_or_confirm == 1;
        // });

        // if ($allConfirmed) {

        //     $rejectedOrder = Order::find($orderId);
        //     $rejectedOrder->order_status_id = 1;
        //     $rejectedOrder->update();

        // }

        $oldNotification = Notification::find($notificationId);
        $oldNotification->order_reject_or_confirm = 1;
        $oldNotification->order_ex_fac_date = $suggestedDate;
        $oldNotification->order_in_hand_due_date = $order->due_date;
        $oldNotification->update();

        // $existingNotifications = Notification::where('is_payment', 0)->where('order_id', $oldNotification->order_id)
        //     ->where('is_comment', 0)->where('is_order_edit',0)
        //     ->where('active',1)->where('notification_message', 'like', '%has been moved to production%')
        //     ->whereNull('order_reject_or_confirm')->get();

        //     foreach ($existingNotifications as $existingNotification) {
        //         $existingNotification->order_reject_or_confirm = 1;
        //         $existingNotification->update();
        //     }

        // $notification = new Notification();
        // $notification->notification_title = 'Ex-factory date for Urgent Order | Order - #'.$order->order_no. ' has been rejected.';
        // $notification->notification_message = 'Ex-factory date for Urgent Order | Order - #'.$order->order_no. ' has been rejected. <ul> Suggested date is '.$suggestedDate. '.</ul> <ul> The reason to reject is "'.$rejectReason.'".</ul>
        //                                         <ul>
        //                                             <button type="button" class="btn btn-reject-factory-ex btn-danger mt-3">Reject</button>
        //                                             <button type="button" class="btn btn-confirm-factory-ex btn-success mt-3">Confirm</button>
        //                                         </ul>';
        // $notification->user_id = $order->user_id;
        // $notification->order_id = $orderId;
        // $notification->order_ex_fac_date = $oldNotification->order_ex_fac_date;
        // $notification->order_in_hand_due_date = $order->due_date;
        // $notification->order_item_id = $orderItemIdString;
        // $notification->save();

        $builder = new NotificationBuilderService();

        $DownloadTestPrint = url('orders/DownloadTestPrint/' . $orderItemIdString);
        $quoteCSV_Download   = url('orders/csv/' . $order->id);

        $builder->sendNotification('key_Ex_factory_date_rejected', [
            '{order_no}' => $order->order_no,
            '{suggested_date}' => $suggestedDate,
            '{reason}' => $rejectReason,
            '{DownloadTestPrint}' => $DownloadTestPrint,
            '{quoteCSV_Download}' => $quoteCSV_Download,
        ], [

            'order_id' => $orderId,
            'order_ex_fac_date' => $oldNotification->order_ex_fac_date,
            'order_in_hand_due_date' => $order->due_date,
            'order_item_id' => $orderItemIdString,
        ]);

        email_Notify()->sendEmailFromTemplate('key_email_urjent_order_factory_reject_ex_fac_date', [
                'orderId' => $order->id,
                'organizationname' => $order->organizationDetails->organization_name,
                'suggested_date' => $suggestedDate,
                'reject_reason' => $rejectReason,
                'order_link' => url("order_details/edit/{$order->id}/order?active_tab=order"),
            ]);

        return redirect()->route('orders');
   }


   public function confirm(Request $request){
        $orderId = $request->order_id;
        $notificationId = $request->notificationId;

        $order = Order::with('organizationDetails')->find($orderId);

        $orderItemIdString = $request->order_item_id;

        $orderItemIds = explode(',', $orderItemIdString);

        $oldNotification = Notification::find($notificationId);
        $oldNotification->order_reject_or_confirm = 2;
        $oldNotification->order_in_hand_due_date = $order->due_date;
        $oldNotification->update();

        foreach ($orderItemIds as $orderIds) {
            $orderItem = OrderItem::find($orderIds);
            $orderItem->is_urgent = 1;
            $orderItem->reject_or_confirm = 2;
            $orderItem->ex_factory_date = $oldNotification->order_ex_fac_date;
            $orderItem->update();
        }

        if($order->ex_factory_date != $oldNotification->order_ex_fac_date){
            $exDateLog = ExFactoryDateFacade::create($order->id, Auth::user()->name, $order->ex_factory_date, $oldNotification->order_ex_fac_date, 'Rep suggested ex-factory date has been confirmed by factory');
        }


        $order->is_urgent = 1;
        $order->reject_or_confirm = 2;
        $order->ex_factory_date = $oldNotification->order_ex_fac_date;
        $order->factory_confirmation_date = \Carbon\Carbon::now()->format('m/d/Y');
        $order->update();

        // $existingNotifications = Notification::where('is_payment', 0)->where('order_id', $oldNotification->order_id)
        //     ->where('is_comment', 0)->where('is_order_edit',0)
        //     ->where('active',1)->where('notification_message', 'like', '%has been moved to production%')
        //     ->whereNull('order_reject_or_confirm')->get();

            // foreach ($existingNotifications as $existingNotification) {
            //     $existingNotification->order_reject_or_confirm = 1;
            //     $existingNotification->update();
            // }

        // $notification = new Notification();
        // $notification->notification_title = 'Ex-factory date confirmed for Urgent Order | Order - #'.$order->order_no;
        // $notification->notification_message = 'Ex-factory date confirmed for Urgent Order | Order - #'.$order->order_no;
        // $notification->user_id = $order->user_id;
        // $notification->order_id = $order->id;
        // $notification->order_ex_fac_date = $oldNotification->order_ex_fac_date;
        // $notification->order_item_id = $orderItemIdString;
        // $notification->save();

        $builder = new NotificationBuilderService();

        $builder->sendNotification('key_Ex_factory_date_confirm_Urgent', [
            '{order_no}' => $order->order_no,
        ], [

            'order_id' => $order->id,
            'order_ex_fac_date' => $oldNotification->order_ex_fac_date,
            'order_item_id' => $orderItemIdString,
        ]);

        email_Notify()->sendEmailFromTemplate('key_email_urjent_order_factory_confirm_ex_fac_date', [
            'orderId' => $order->id,
            'organizationname' => $order->organizationDetails->organization_name,
            'ex_factory_date' => $oldNotification->order_ex_fac_date,
            'order_link' => url("order_details/edit/{$order->id}/order?active_tab=order"),
        ]);



        $this->create_invoice_by_factory_confirmation($order->id);

        return back();
   }
   public function factory_reject(Request $request){
        $rejectReason = $request->input('reject_reason');
        $suggestedDate = $request->input('suggested_date');
        $orderId = $request->order_id;
        $notificationId = $request->notificationId;

        $order = Order::with('organizationDetails')->find($orderId);
        $order->is_urgent = 0;
        if($order->factory_confirmation_date == NULL){
            $order->factory_confirmation_date = 'Rejected by factory';
        }
        $order->reject_or_confirm = 1;
        $order->reject_reason = $rejectReason;
        $order->suggested_ex_fac_date = $suggestedDate;
        $order->factory_confirmation_date = 'Waiting for rep Confirmation';
        $order->update();

        $orderItemIdString = $request->order_item_id;


        $orderItemIds = explode(',', $orderItemIdString);
        $orderItems = [];

        foreach ($orderItemIds as $orderIds) {
            $orderItem = OrderItem::find($orderIds);
            $orderItem->is_urgent = 0;
            $orderItem->reject_or_confirm = 1;
            $orderItem->reject_reason = $rejectReason;
            $orderItem->suggested_ex_fac_date = $suggestedDate;
            $orderItem->update();
        }

        $allOrderItems = OrderItem::where('order_id', $orderId)->get();

        $allConfirmed = $allOrderItems->every(function ($rejectedOrderItem) {
            return $rejectedOrderItem->reject_or_confirm == 1;
        });

        // if ($allConfirmed) {

        //     $rejectedOrder = Order::find($orderId);
        //     $rejectedOrder->order_status_id = 1;
        //     $rejectedOrder->update();

        // }

        $oldNotification = Notification::find($notificationId);
        $oldNotification->order_reject_or_confirm = 1;
        $oldNotification->update();

        $existingNotifications = Notification::where('is_payment', 0)->where('order_id', $oldNotification->order_id)
            ->where('is_comment', 0)->where('is_order_edit',0)
            ->where('active',1)->where('notification_message', 'like', '%has been moved to production%')
            ->whereNull('order_reject_or_confirm')->get();

            foreach ($existingNotifications as $existingNotification) {
                $existingNotification->order_reject_or_confirm = 1;
                $existingNotification->update();
            }

        $users = User::where('role_id', 'LIKE', '%"2"%')->where('active', 1)->pluck('id')->toArray();

        if (!is_null($order->order_procesing_user_id) && !in_array($order->order_procesing_user_id, $users)) {
            $users[] = $order->order_procesing_user_id;
        }
        if (!is_null($order->user_id) && !in_array($order->user_id, $users)) {
            $users[] = $order->user_id;
        }

        // foreach ($users as $userId) {

        // $notification = new Notification();
        // $notification->notification_title = 'Ex-factory date for Order | Order - #'.$order->order_no. ' has been rejected.';
        // $notification->notification_message = 'Ex-factory date for Order | Order - #'.$order->order_no. ' has been rejected.
        //                                             <ul> Suggested date is '.$suggestedDate. '.</ul>
        //                                             <ul> The reason to reject is "'.$rejectReason.'".</ul>';
        // $notification->user_id = $userId;
        // $notification->order_id = $orderId;
        // $notification->order_ex_fac_date = $suggestedDate;
        // $notification->order_in_hand_due_date = $order->due_date;
        // $notification->order_item_id = $orderItemIdString;
        // $notification->save();

        // }
        $builder = new NotificationBuilderService();

        $DownloadTestPrint = url('orders/DownloadTestPrint/' . $orderItemIdString);
        $quoteCSV_Download   = url('orders/csv/' . $order->id);

        $builder->sendNotification('key_Ex_factory_date_rejected_message', [
            '{order_no}' => $order->order_no,
            '{suggested_date}' => $suggestedDate,
            '{reason}' => $rejectReason,
            '{DownloadTestPrint}' => $DownloadTestPrint,
            '{quoteCSV_Download}' => $quoteCSV_Download,
        ], [

            'order_id' => $orderId,
            'order_ex_fac_date' => $suggestedDate,
            'order_in_hand_due_date' => $order->due_date,
            'order_item_id' => $orderItemIdString,
        ]);

        email_Notify()->sendEmailFromTemplate('key_email_factory_reject_ex_fac_date', [
            'orderId' => $order->id,
            'organizationname' => $order->organizationDetails->organization_name,
            'suggested_date' => $suggestedDate,
            'reject_reason' => $rejectReason,
            'order_link' => url("order_details/edit/{$order->id}/order?active_tab=order"),
        ]);

        return redirect()->route('orders');
    }
   public function factory_confirm(Request $request){
        $orderId = $request->order_id;
        $notificationId = $request->notificationId;

        $order = Order::with('organizationDetails')->find($orderId);
        $order->is_urgent = 0;
        $order->factory_confirmation_date = \Carbon\Carbon::now()->format('m/d/Y');
        $order->reject_or_confirm = 2;
        $order->update();

        $orderItemIdString = $request->order_item_id;

        $orderItemIds = explode(',', $orderItemIdString);
        $orderItems = [];

        foreach ($orderItemIds as $orderIds) {
            $orderItem = OrderItem::find($orderIds);
            $orderItem->is_urgent = 0;
            $orderItem->reject_or_confirm = 2;
            $orderItem->update();
        }

        $oldNotification = Notification::find($notificationId);
        $oldNotification->order_reject_or_confirm = 2;
        $oldNotification->update();

        $existingNotifications = Notification::where('is_payment', 0)->where('order_id', $oldNotification->order_id)
            ->where('is_comment', 0)->where('is_order_edit',0)
            ->where('active',1)->where('notification_message', 'like', '%has been moved to production%')
            ->whereNull('order_reject_or_confirm')->get();

            foreach ($existingNotifications as $existingNotification) {
                $existingNotification->order_reject_or_confirm = 1;
                $existingNotification->update();
            }

        $users = User::where('role_id', 'LIKE', '%"2"%')->where('active', 1)->pluck('id')->toArray();

        if (!is_null($order->order_procesing_user_id) && !in_array($order->order_procesing_user_id, $users)) {
            $users[] = $order->order_procesing_user_id;
        }
        if (!is_null($order->user_id) && !in_array($order->user_id, $users)) {
            $users[] = $order->user_id;
        }

        // foreach ($users as $userId) {
        // $notification = new Notification();
        // $notification->notification_title = 'Ex-factory date confirmed for Order | Order - #'.$order->order_no;
        // $notification->notification_message = 'Ex-factory date confirmed for Order | Order - #'.$order->order_no;
        // $notification->user_id = $userId;
        // $notification->order_id = $order->id;
        // $notification->order_item_id = $orderItemIdString;
        // $notification->save();
        // }
        $builder = new NotificationBuilderService();

        $builder->sendNotification('key_Ex_factory_date_confirm', [
            '{order_no}' => $order->order_no,
        ], [

            'order_id' => $order->id,
            'order_item_id' => $orderItemIdString,
        ]);

        email_Notify()->sendEmailFromTemplate('key_email_factory_confirm_ex_fac_date', [
            'orderId' => $order->id,
            'organizationname' => $order->organizationDetails->organization_name,
            'ex_factory_date' => $oldNotification->order_ex_fac_date,
            'order_link' => url("order_details/edit/{$order->id}/order?active_tab=order"),
        ]);

        $this->create_invoice_by_factory_confirmation($order->id);

        return back();
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

    public function notification_templates_store(Request $request){
        $request->validate([
            'function_name' => 'required|string|max:50',
            'notification_key' => 'required|string|max:50',
            'controller' => 'required|string|max:50',
            'notification_body' => 'nullable',
            'description' => 'nullable|string',
            'modal_footer' => 'nullable|string',
            'status' => 'required|integer',
            'modal_title' => 'nullable|string',
        ]);

        $template = NotificationTemplate::create([
            'function_name' => $request->function_name,
            'name' => $request->notification_name,
            'template_key' => $request->notification_key,
            'controller' => $request->controller,
            'title' => $request->title,
            'modal_title' => $request->modal_title,
            'notification_body' => $request->notification_body,
            'modal_footer' => $request->modal_footer,
            'confirm_route' => $request->confirm_route,
            'reject_route' => $request->reject_route,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        // Assign selected users to the template
        $template->users()->sync($request->users);

        return redirect()->back()->withSuccess('Template created Successfully!');

    }
    public function notification_email_templates_store(Request $request){
        $request->validate([
            'function_name' => 'required|string|max:50',
            'notification_key' => 'required|string|max:50',
            'controller' => 'required|string|max:50',
            'notification_body' => 'nullable',
            'description' => 'nullable|string',
            'status' => 'required|integer',
        ]);

        $template = EmailNotification::create([
            'function_name' => $request->function_name,
            'name' => $request->notification_name,
            'template_key' => $request->notification_key,
            'controller' => $request->controller,
            'subject' => $request->title,
            'body' => $request->notification_body,
            'description' => $request->description,
            'active' => $request->status,
        ]);

        // Assign selected users to the template
        // $template->users()->sync($request->users);

        return redirect()->back()->withSuccess('Template created Successfully!');

    }
    public function get_table_data(){
        $templates = NotificationTemplate::get();
        return response()->json([
            'templates' => $templates
        ]);
    }
    public function email_get_table_data(){
        $templates = EmailNotification::get();
        return response()->json([
            'templates' => $templates
        ]);
    }
    public function notification_templates_change_status(Request $request)
    {
        $template = NotificationTemplate::find($request->id);
        if ($template) {
            $template->status = $request->status;
            $template->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
    public function notification_email_templates_change_status(Request $request)
    {
        $template = EmailNotification::find($request->id);
        if ($template) {
            $template->active = $request->status;
            $template->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function notification_templates_edit($id)
    {
        $template = NotificationTemplate::findOrFail($id);
        return response()->json($template);
    }
    public function email_notification_templates_edit($id)
    {
        $template = EmailNotification::findOrFail($id);
        return response()->json($template);
    }
    public function notification_templates_update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'function_name' => 'required|string|max:50',
            'notification_key' => 'required|string|max:50',
            'notification_name' => 'required|string|max:50',
            'controller' => 'required|string|max:50',
            'notification_body' => 'nullable',
            'description' => 'nullable|string',
            'modal_footer' => 'nullable|string',
            'status' => 'required|integer',
            'modal_title' => 'nullable|string',
        ]);

        // Find the template by ID
        $template = NotificationTemplate::findOrFail($id);

        // Update the template fields
        $template->update([
            'function_name' => $request->function_name,
            'template_key' => $request->notification_key,
            'name' => $request->notification_name,
            'controller' => $request->controller,
            'title' => $request->title,
            'modal_title' => $request->modal_title,
            'notification_body' => $request->notification_body,
            'modal_footer' => $request->modal_footer,
            'confirm_route' => $request->confirm_route,
            'reject_route' => $request->reject_route,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        // Reassign selected users to the template (optional)
        if ($request->has('users')) {
            $template->users()->sync($request->users);
        }

        // Redirect back with a success message
        return redirect()->back()->withSuccess('Template updated successfully!');
    }
    public function searchOrganizations(Request $request)
{
    $search = trim((string) $request->input('search'));

    $organizations = Organization::query()
        ->where('active', 1)
        ->when($search !== '', function ($query) use ($search) {
            $query->where(
                'organization_name',
                'like',
                '%' . $search . '%'
            );
        })
        ->orderBy('organization_name')
        ->limit(30)
        ->get([
            'id',
            'organization_name',
        ]);

   return response()->json([
    'results' => $organizations->map(function ($organization) {
        return [
            'id' => (string) $organization->id,
            'text' => $organization->organization_name,
        ];
    })->values()->all(),
]);
}
public function organizationCustomers($organizationId)
{
    $customers = Contact::query()
        ->join(
            'contact_organizations',
            'contact_organizations.contact_id',
            '=',
            'contacts.id'
        )
        ->where(
            'contact_organizations.organization_id',
            $organizationId
        )
        ->whereNull('contact_organizations.deleted_at')
        ->select([
            'contacts.id',
            'contacts.first_name',
            'contacts.last_name',
            'contacts.email',
        ])
        ->distinct()
        ->orderBy('contacts.first_name')
        ->orderBy('contacts.last_name')
        ->get()
        ->map(function ($contact) {
            $name = trim(
                ($contact->first_name ?? '') . ' ' .
                ($contact->last_name ?? '')
            );

            return [
                'id' => $contact->id,
                'name' => $name !== ''
                    ? $name
                    : ($contact->email ?? 'Unnamed customer'),
                'first_name' => $contact->first_name,
                'last_name' => $contact->last_name,
                'email' => $contact->email,
            ];
        })
        ->values();

    return response()->json([
        'customers' => $customers,
    ]);
}
    public function email_notification_templates_update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'function_name' => 'required|string|max:50',
            'notification_key' => 'required|string|max:50',
            'notification_name' => 'required|string|max:50',
            'controller' => 'required|string|max:50',
            'notification_body' => 'nullable',
            'description' => 'nullable|string',
            'status' => 'required|integer',
        ]);

        // Find the template by ID
        $template = EmailNotification::findOrFail($id);

        // Update the template fields
        $template->update([
            'function_name' => $request->function_name,
            'template_key' => $request->notification_key,
            'name' => $request->notification_name,
            'controller' => $request->controller,
            'subject' => $request->title,
            'body' => $request->notification_body,
            'description' => $request->description,
            'active' => $request->status,
            'environment' => $request->environment ?? 1
        ]);

        // // Reassign selected users to the template (optional)
        // if ($request->has('users')) {
        //     $template->users()->sync($request->users);
        // }

        // Redirect back with a success message
        return redirect()->back()->withSuccess('Template updated successfully!');
    }
    public function get_notification_template_users($id){
        // $roles = Role::with('users')->get();
        $roles = Role::with([
                    'users' => function ($query) {
                        $query->where('active', 1);
                    }
                ])->get();
        $selectedUsers = NotificationTemplateUser::where('notification_template_id', $id)
                    ->pluck('user_id') // <-- this is key
                    ->toArray();
        $template = NotificationTemplate::findOrFail($id);
        return response()->json([
            'groups' => $roles,
            'selectedUsers' => $selectedUsers,
            'template_id' => $id,
            'template' => $template,

        ]);
    }
public function get_email_notification_template_users($id)
{
    // $roles = Role::with('users')->get();
    $roles = Role::with([
                'users' => function ($query) {
                    $query->where('active', 1);
                }
            ])->get();

    /*
    |--------------------------------------------------------------------------
    | Selected normal users
    |--------------------------------------------------------------------------
    */

    $selected = EmailNotificationTemplateUser::where(
            'template_id',
            $id
        )
        ->select('user_id', 'type')
        ->get()
        ->groupBy('type')
        ->map(function ($group) {
            return $group
                ->pluck('user_id')
                ->map(function ($userId) {
                    return (string) $userId;
                })
                ->values()
                ->toArray();
        });

    $selectedUsers = [
        'to' => $selected->get(0, []),
        'cc' => $selected->get(1, []),
        'bcc' => $selected->get(2, []),
    ];

    /*
    |--------------------------------------------------------------------------
    | Notification template
    |--------------------------------------------------------------------------
    */

    $template = EmailNotification::findOrFail($id);

    /*
    |--------------------------------------------------------------------------
    | Selected specific organization customers
    |--------------------------------------------------------------------------
    */

    $specificOrganizationCustomers = DB::table(
            'email_notification_template_customers'
        )
        ->leftJoin(
            'organizations',
            'organizations.id',
            '=',
            'email_notification_template_customers.organization_id'
        )
        ->where(
            'email_notification_template_customers.template_id',
            $id
        )
        ->select([
            'email_notification_template_customers.id',
            'email_notification_template_customers.template_id',
            'email_notification_template_customers.organization_id',
            'email_notification_template_customers.contact_id',
            'email_notification_template_customers.type',
            'organizations.organization_name',
        ])
        ->orderBy(
            'email_notification_template_customers.organization_id'
        )
        ->orderBy(
            'email_notification_template_customers.contact_id'
        )
        ->get()
        ->values()
        ->toArray();

    /*
     * Add dynamic data to the template JSON response.
     */
    $template->setAttribute(
        'specific_organization_customers',
        $specificOrganizationCustomers
    );

    return response()->json([
        'groups' => $roles,
        'selectedUsers' => $selectedUsers,
        'template_id' => (int) $id,
        'template' => $template,
    ]);
}

    public function toggleUser(Request $request)
    {
// dd($request);
        $templateId = $request->input('Template_id');
        $userIds = $request->input('user_ids', []); // May contain duplicates

        // Remove duplicates
        $uniqueUserIds = array_unique($userIds);

        // Example usage: sync with template's users (if using many-to-many relationship)

        $template = NotificationTemplate::findOrFail($templateId);

        $template->sales_rep = $request->has('salesRep') ? 1 : 0;
        $template->proccessing_rep = $request->has('OrderProssingRep') ? 1 : 0;
        $template->related_fac = $request->has('Related_Factories') ? 1 : 0;

        $template->save();

        $template->users()->sync($uniqueUserIds);

        return redirect()->back()->with('success', 'Notification users updated successfully.');
    }
   public function email_toggleUser(Request $request)
{
    $request->validate([
        'Template_id' => ['required', 'integer', 'exists:email_notifications,id'],

        'to_user_ids' => ['nullable', 'array'],
        'cc_user_ids' => ['nullable', 'array'],
        'bcc_user_ids' => ['nullable', 'array'],

        'specific_customers' => ['nullable', 'array'],
    ]);

    $templateId = (int) $request->input('Template_id');

    DB::beginTransaction();

    try {
        $template = EmailNotification::findOrFail($templateId);

        /*
        |--------------------------------------------------------------------------
        | General options
        |--------------------------------------------------------------------------
        */

        $template->sales_rep = $request->has('salesRep') ? 1 : 0;
        $template->proccessing_rep = $request->has('OrderProssingRep') ? 1 : 0;
        $template->related_fac = $request->has('Related_Factories') ? 1 : 0;
        $template->order_customer = $request->has('order_customer') ? 1 : 0;

        /*
        |--------------------------------------------------------------------------
        | Organization-related users
        |--------------------------------------------------------------------------
        */

        $sendOrganization = $request->has('send_organization') ? 1 : 0;

        $orgTo = $request->input('to_org_related', []);
        $orgCc = $request->input('cc_org_related', []);
        $orgBcc = $request->input('bcc_org_related', []);

        /*
         * Specific Organizations and Organization Customers
         * cannot be active at the same time.
         */
        if ($sendOrganization === 1) {
            unset($orgTo['customers']);
            unset($orgCc['customers']);
            unset($orgBcc['customers']);
        }

        $organizationUser = [
            'to' => [
                'organization' => isset($orgTo['organization']) ? 1 : 0,
                'sales_rep' => isset($orgTo['sales_rep']) ? 1 : 0,
                'customers' => isset($orgTo['customers']) ? 1 : 0,
            ],
            'cc' => [
                'organization' => isset($orgCc['organization']) ? 1 : 0,
                'sales_rep' => isset($orgCc['sales_rep']) ? 1 : 0,
                'customers' => isset($orgCc['customers']) ? 1 : 0,
            ],
            'bcc' => [
                'organization' => isset($orgBcc['organization']) ? 1 : 0,
                'sales_rep' => isset($orgBcc['sales_rep']) ? 1 : 0,
                'customers' => isset($orgBcc['customers']) ? 1 : 0,
            ],
        ];

        $template->organization_user = json_encode($organizationUser);
        $template->send_organization = $sendOrganization;

        /*
        |--------------------------------------------------------------------------
        | HR-related users
        |--------------------------------------------------------------------------
        */

        $hrTo = $request->input('to_hr_related', []);
        $hrCc = $request->input('cc_hr_related', []);
        $hrBcc = $request->input('bcc_hr_related', []);

        $hrUser = [
            'to' => [
                'employee' => isset($hrTo['employee']) ? 1 : 0,
            ],
            'cc' => [
                'employee' => isset($hrCc['employee']) ? 1 : 0,
            ],
            'bcc' => [
                'employee' => isset($hrBcc['employee']) ? 1 : 0,
            ],
        ];

        $template->hr_users = json_encode($hrUser);

        /*
        |--------------------------------------------------------------------------
        | Store-related users
        |--------------------------------------------------------------------------
        */

        $storeTo = $request->input('to_store_related', []);
        $storeCc = $request->input('cc_store_related', []);
        $storeBcc = $request->input('bcc_store_related', []);

        $storeUser = [
            'to' => [
                'sales_rep' => isset($storeTo['sales_rep']) ? 1 : 0,
                'store_customers' => isset($storeTo['store_customers']) ? 1 : 0,
            ],
            'cc' => [
                'sales_rep' => isset($storeCc['sales_rep']) ? 1 : 0,
                'store_customers' => isset($storeCc['store_customers']) ? 1 : 0,
            ],
            'bcc' => [
                'sales_rep' => isset($storeBcc['sales_rep']) ? 1 : 0,
                'store_customers' => isset($storeBcc['store_customers']) ? 1 : 0,
            ],
        ];

        $template->store_users = json_encode($storeUser);

        /*
        |--------------------------------------------------------------------------
        | Project Management-related users
        |--------------------------------------------------------------------------
        */

        $pmTo = $request->input('to_pm_related', []);
        $pmCc = $request->input('cc_pm_related', []);
        $pmBcc = $request->input('bcc_pm_related', []);

        $pmUser = [
            'to' => [
                'project_owner' => isset($pmTo['project_owner']) ? 1 : 0,
                'task_assignees' => isset($pmTo['task_assignees']) ? 1 : 0,
                'sub_task_assignees' => isset($pmTo['sub_task_assignees']) ? 1 : 0,
            ],
            'cc' => [
                'project_owner' => isset($pmCc['project_owner']) ? 1 : 0,
                'task_assignees' => isset($pmCc['task_assignees']) ? 1 : 0,
                'sub_task_assignees' => isset($pmCc['sub_task_assignees']) ? 1 : 0,
            ],
            'bcc' => [
                'project_owner' => isset($pmBcc['project_owner']) ? 1 : 0,
                'task_assignees' => isset($pmBcc['task_assignees']) ? 1 : 0,
                'sub_task_assignees' => isset($pmBcc['sub_task_assignees']) ? 1 : 0,
            ],
        ];

        $template->pm_users = json_encode($pmUser);

        /*
        |--------------------------------------------------------------------------
        | Custom emails
        |--------------------------------------------------------------------------
        */

        $customTo = $request->input('to_custom_related', []);
        $customCc = $request->input('cc_custom_related', []);
        $customBcc = $request->input('bcc_custom_related', []);

        $customUser = [
            'to' => [
                'custom_email' => isset($customTo['custom_email']) ? 1 : 0,
            ],
            'cc' => [
                'custom_email' => isset($customCc['custom_email']) ? 1 : 0,
            ],
            'bcc' => [
                'custom_email' => isset($customBcc['custom_email']) ? 1 : 0,
            ],
        ];

        $template->custom_email = json_encode($customUser);

        /*
         * Save email_notifications first.
         */
        $template->save();

        /*
        |--------------------------------------------------------------------------
        | Save normal template users
        |--------------------------------------------------------------------------
        */

        EmailNotificationTemplateUser::where(
            'template_id',
            $templateId
        )->delete();

        $normalUserRows = [];

        $normalRecipientTypes = [
            'to_user_ids' => 0,
            'cc_user_ids' => 1,
            'bcc_user_ids' => 2,
        ];

        foreach ($normalRecipientTypes as $inputName => $type) {
            $userIds = array_unique(
                array_filter(
                    array_map(
                        'intval',
                        $request->input($inputName, [])
                    )
                )
            );

            foreach ($userIds as $userId) {
                $normalUserRows[] = [
                    'template_id' => $templateId,
                    'user_id' => $userId,
                    'type' => $type,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (!empty($normalUserRows)) {
            EmailNotificationTemplateUser::insert(
                $normalUserRows
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Save specific organization contacts
        |--------------------------------------------------------------------------
        */

        DB::table('email_notification_template_customers')
            ->where('template_id', $templateId)
            ->delete();

        if ($sendOrganization === 1) {
            $specificCustomers = $request->input(
                'specific_customers',
                []
            );

            $specificCustomerRows = [];

            $specificRecipientTypes = [
                'to' => 0,
                'cc' => 1,
                'bcc' => 2,
            ];

            foreach (
                $specificCustomers as $organizationId => $recipientGroups
            ) {
                $organizationId = (int) $organizationId;

                if ($organizationId <= 0 || !is_array($recipientGroups)) {
                    continue;
                }

                foreach (
                    $specificRecipientTypes as $recipientName => $type
                ) {
                    $contactIds = $recipientGroups[$recipientName] ?? [];

                    if (!is_array($contactIds)) {
                        continue;
                    }

                    $contactIds = array_unique(
                        array_filter(
                            array_map('intval', $contactIds)
                        )
                    );

                    foreach ($contactIds as $contactId) {
                        $specificCustomerRows[] = [
                            'template_id' => $templateId,
                            'organization_id' => $organizationId,
                            'type' => $type,
                            'contact_id' => $contactId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
            }

            if (!empty($specificCustomerRows)) {
                DB::table(
                    'email_notification_template_customers'
                )->insert($specificCustomerRows);
            }
        }

        DB::commit();

        return redirect()
            ->back()
            ->with(
                'success',
                'Email template users updated successfully.'
            );
    } catch (\Throwable $exception) {
        DB::rollBack();

        report($exception);

        return redirect()
            ->back()
            ->with(
                'error',
                'Unable to update email template users: ' .
                $exception->getMessage()
            );
    }
}






}
