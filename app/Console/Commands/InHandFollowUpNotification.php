<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\EmailNotificationBuilderService;
use App\Services\NotificationBuilderService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class InHandFollowUpNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inhandfollowup:due-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email and notification when order in hand due date is passed 10 days ago';
    protected $notification_builder;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(NotificationBuilderService $notification_builder)
    {
        parent::__construct();

        $this->notification_builder = $notification_builder;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today();

        $tenDaysPast = $today->copy()->subDays(10);

        $orders = Order::with('organizationDetails')
            ->where('order_status_id', 3)
            ->where('due_date', $tenDaysPast->format('m/d/Y'))
            ->get();

        foreach ($orders as $order) {

            $orderItems = OrderItem::where('order_id', $order->id)
                ->where('order_status_id', 3)
                ->where('in_hand_due_date', $tenDaysPast->format('m/d/Y'))
                ->whereNull('deleted_at')
                ->get()
                ->unique('order_id');

            foreach ($orderItems as $orderItem) {

                $this->notification_builder->sendNotification(
                    'key_inhand_followup_due_date',
                    [
                        '{order_number}'      => $orderItem->order_id,
                        '{order_link}'        => url("order_details/edit/{$orderItem->order_id}/order") . '?active_tab=order',
                        '{ex_factory_date}'   => $orderItem->ex_factory_date,
                        '{in_hand_due_date}'  => $orderItem->in_hand_due_date,
                        '{organization_name}' => optional($order->organizationDetails)->organization_name ?? '',
                        '{order_description}' => $order->order_description ?? '',
                    ],
                    [
                        'order_id'                  => $orderItem->order_id,
                        'order_ex_fac_date'         => $order->ex_factory_date,
                        'order_in_hand_due_date'    => $order->due_date,
                        'target_notification_field' => 'key_inhand_followup_due_date',
                        'new_notification'          => 1,
                    ]

                );

                app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_inhand_followup_due_date', [
                    'orderId'          => $orderItem->order_id,
                    'order_number'      => $orderItem->order_id,
                    'order_link'        => url("order_details/edit/{$orderItem->order_id}/order") . '?active_tab=order',
                    'ex_factory_date'   => $orderItem->ex_factory_date,
                    'in_hand_due_date'  => $orderItem->in_hand_due_date,
                    'organization_name' => optional($order->organizationDetails)->organization_name ?? '',
                    'order_description' => $order->order_description ?? '',
                ]);
            }

        } 

        
        return 0;
    }
}
