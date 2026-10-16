<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Organization;
use App\Models\Order;
use App\Models\ShippingOrderDetails;

class dHudsonWeeklyReport extends Command
{
    protected $signature = 'email:d-hudson-weekly-report';
    protected $description = 'Send weekly report email to D Hudson';

    public function handle()
    {
        $orgID = 4184;

        $orgDeatails = Organization::where('id', $orgID)->first();

        $orderList1 = Order::with('userDetails', 'orderItems')->where('organization_id', $orgID)->whereNotNull('production_date')->whereIn('order_status_id', [3])->where('active', 1)->orderByDesc('id')->get();

        $lastFriday12 = now()->previous('Friday')->setTime(12, 0, 0);

        $orderListLast7Days = ShippingOrderDetails::whereBetween('updated_at', [$lastFriday12, now()])->pluck('order_id')->toArray();
        $orderList2 = Order::with('userDetails', 'orderItems')->where('organization_id', $orgID)->whereIn('id', $orderListLast7Days)->whereNotNull('production_date')->whereIn('order_status_id', [4])->where('active', 1)->orderByDesc('id')->get();

        $orderList = $orderList1->merge($orderList2)->sortByDesc('id');

        foreach ($orderList as $order) {
            $order->tracking_no = $this->getTrackingNo($order->id) ?? NULL;
            $order->tracking_link = $this->getTrackingLink($order->id) ?? NULL;

            $link = route('customer_portal.shipment_summary_view', ['id' => $order->id]);
            $order->shipment_summary = $link;
        }

        email_Notify()->sendEmailFromTemplate(
            'key_email_send_d_hudson_weekly_report',
            [
                'organization_id' => $orgID,
                'organization' => $orgDeatails,
                'orders' => $orderList,
            ]
        );

        return Command::SUCCESS;
    }

    public function getTrackingNo($orderID)
    {
        $orderShippingDetails = ShippingOrderDetails::where('order_id', $orderID)->whereNotNull('tracking_no')->first();
        return $orderShippingDetails ? $orderShippingDetails->tracking_no : NULL;
    }
    public function getTrackingLink($orderID)
    {
        $orderShippingDetails = ShippingOrderDetails::where('order_id', $orderID)->whereNotNull('tracking_link')->first();
        return $orderShippingDetails ? $orderShippingDetails->tracking_link : NULL;
    }

}
