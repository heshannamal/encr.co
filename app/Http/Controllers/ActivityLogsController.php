<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentLog;
use App\Models\OrderFolder;
use App\Models\ActivityLogs;
use App\Models\CheckPayment;
use App\Models\Notification;
use App\Models\VenmoPayment;
use Illuminate\Http\Request;
use App\Models\InHandDateLog;
use App\Models\OrderItemFile;
use App\Models\PaypalPayment;
use App\Models\ShippedOrders;
use App\Models\TeamStoreOrder;
use App\Models\ExFactoryDateLog;
use App\Models\OrderItemsDetail;
use App\Http\Controllers\Controller;
use App\Models\TeamStorePlayerReport;
use App\Models\TeamStoreProductReport;
use App\Models\ShippingNotificationDraft;
use App\Models\OrderItemsDetailPlayerName;

class ActivityLogsController extends Controller
{
    public function index(){

        if(auth()->user()->can('manage activity logs')){

            $activityLogs = ActivityLogs::orderByDesc('created_at')->paginate(50);

            $users = User::select('id', 'name')->orderBy('id')->get();

            $order = Order::get('id');

            $orderFolder = OrderFolder::get();

            $order_item_details = OrderItemsDetail::join('order_items', 'order_items_details.order_item_id', '=', 'order_items.id')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->select('order_items_details.id as detailsid', 'order_items_details.order_item_id as itemid','order_items.id', 'order_items.order_id as orderid')
                ->get();

            $order_items = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
                ->select('order_items.id', 'order_items.order_id as orderid')
                ->get();

            $order_item_player = OrderItemsDetailPlayerName::join('order_items_details', 'order_items_detail_player_names.order_items_detail_id', '=', 'order_items_details.id')
                ->join('order_items', 'order_items_details.order_item_id', '=', 'order_items.id')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->select('order_items_detail_player_names.id as playerId', 'orders.id as orderId')
                ->get();

            $order_item_files = OrderItemFile::select('order_id', 'id')
                ->get();

            $notifications = Notification::select('id', 'order_id')
                ->get();

            $check_payments = CheckPayment::select('id', 'order_id')
                ->get();

            $payment_logs = PaymentLog::select('id', 'order_id')
                ->get();

            $venmo_payments = VenmoPayment::select('id', 'order_id')
                ->get();

            $team_store_orders = TeamStoreOrder::select('id', 'order_id')
                ->get();

            $team_store_player_reports = TeamStorePlayerReport::
                join('team_store_orders', 'team_store_player_reports.team_store_order_id', '=', 'team_store_orders.id')
                ->select('team_store_player_reports.id as reportId', 'team_store_orders.order_id as orderId')
                ->get();

            $team_store_product_reports = TeamStoreProductReport::
                join('team_store_orders', 'team_store_product_reports.team_store_order_id', '=', 'team_store_orders.id')
                ->select('team_store_product_reports.id as reportId', 'team_store_orders.order_id as orderId')
                ->get();

            $paypal_payments = PaypalPayment::select('id', 'order_id')
                ->get();

            $in_hand_date_logs = InHandDateLog::select('id', 'order_id')
                ->get();

            $ex_factory_date_logs = ExFactoryDateLog::select('id', 'order_id')
                ->get();

            $shipping_notification_drafts = ShippingNotificationDraft::select('id', 'order_id')
                ->get();

            $shipped_orders = ShippedOrders::select('id', 'order_id')
                ->get();

            // dd($check_payments);

        return view('pages.activity_logs.index', compact('activityLogs', 'users', 'order', 'orderFolder', 'order_item_details',
                    'order_items', 'order_item_player', 'order_item_files', 'notifications', 'check_payments', 'payment_logs',
                    'venmo_payments', 'team_store_orders', 'team_store_player_reports', 'team_store_product_reports', 'paypal_payments',
                    'in_hand_date_logs', 'ex_factory_date_logs', 'shipping_notification_drafts', 'shipped_orders'))->render();
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }
}
