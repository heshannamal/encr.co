<?php
namespace App\Services;

use App\Models\NotificationTemplate;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Store;

class NotificationBuilderService
{
    protected function send( $title, $modal_title, $message, array $meta)
    {


        $notification = new Notification();
        $notification->notification_title      = $title;
        $notification->modal_title             = $modal_title ?? null;
        $notification->notification_message    = $message;
        $notification->is_read                 = $meta['is_read'] ?? 0;
        $notification->user_id                 = $meta['user_id'] ?? null;
        $notification->order_id                = $meta['order_id'] ?? null;
        $notification->activity_id             = $meta['activity_id'] ?? null;
        $notification->order_item_id           = $meta['order_item_id'] ?? null;
        $notification->check_payment_id        = $meta['check_payment_id'] ?? null;
        $notification->venmo_payment_id        = $meta['venmo_payment_id'] ?? null;
        $notification->paypal_payment_id       = $meta['paypal_payment_id'] ?? null;
        $notification->email_template_id       = $meta['email_template_id'] ?? null; 
        $notification->purchase_order_id       = $meta['purchase_order_id'] ?? null;
        $notification->other_payment_id        = $meta['other_payment_id'] ?? null;
        $notification->project_id              = $meta['project_id'] ?? null;
        $notification->is_payment              = $meta['is_payment'] ?? 0;
        $notification->is_comment              = $meta['is_comment'] ?? 0;
        $notification->is_order_edit           = $meta['is_order_edit'] ?? 0;
        $notification->task_id                 = $meta['task_id'] ?? null;
        $notification->is_task_due             = $meta['is_task_due'] ?? 0;
        $notification->sub_task_id             = $meta['sub_task_id'] ?? null;
        $notification->is_subtask_due          = $meta['is_subtask_due'] ?? 0;
        $notification->task_name               = $meta['task_name'] ?? null;
        $notification->task_comments           = $meta['task_comments'] ?? null;
        $notification->target_field            = $meta['target_field'] ?? null;
        $notification->comment_mention_id      = $meta['comment_mention_id'] ?? null;
        $notification->active                  = $meta['active'] ?? 1;
        $notification->chatDiscussionStatus    = $meta['chatDiscussionStatus'] ?? 0;
        $notification->sectionValue            = $meta['sectionValue'] ?? null;
        $notification->is_urgent               = $meta['is_urgent'] ?? null;
        $notification->order_ex_fac_date       = $meta['order_ex_fac_date'] ?? null;
        $notification->order_in_hand_due_date  = $meta['order_in_hand_due_date'] ?? null;
        $notification->order_reject_or_confirm = $meta['order_reject_or_confirm'] ?? null;
        $notification->new_notification = $meta['new_notification'] ?? 0;
        $notification->target_notification_field = $meta['target_notification_field'] ?? null;
        $notification->save();


        return $notification;
    }

    protected function applyReplacements(string $text, array $replacements): string
    {
        foreach ($replacements as $placeholder => $value) {
            $text = str_replace($placeholder, $value, $text);
        }
        return $text;
    }

    // public function Other_Payment_Notification($templateKey, array $replacements, array $meta)
    // {
    //     $template = NotificationTemplate::with('users')->where('template_key', $templateKey)->first();

    //     if (!$template) {
    //         return false;
    //         // throw new \Exception("Notification template '$templateKey' not found.");
    //     }

    //     // Apply replacements to title and message
    //     $title = $this->applyReplacements($template->title, $replacements);
    //     $message = $this->applyReplacements($template->notification_body, $replacements);

    //     if ($template->status != 1) {
    //         return true; // Notification disabled
    //     }

    //     // Start collecting user IDs
    //     $userIds = $template->users->pluck('id')->toArray();

    //     // Load the order if required
    //     if (!empty($meta['order_id'])) {
    //         $order = Order::find($meta['order_id']);

    //         if ($order) {
    //             // Add processing rep if enabled
    //             if ($template->proccessing_rep == 1 && $order->processing_rep_id) {
    //                 $userIds[] = $order->processing_rep_id;
    //             }

    //             // Add sales rep if enabled
    //             if ($template->sales_rep == 1 && $order->sales_rep_id) {
    //                 $userIds[] = $order->sales_rep_id;
    //             }
    //         }
    //     }

    //     // Remove duplicate user IDs
    //     $uniqueUserIds = array_unique($userIds);

    //     // Send notification to each user
    //     foreach ($uniqueUserIds as $userId) {
    //         $this->send($title, $message, array_merge($meta, ['user_id' => $userId]));
    //     }

    //     return true;
    // }

    // public function Activity_Create_Notification($templateKey, array $replacements, array $meta)
    // {
    //     $template = NotificationTemplate::with('users')->where('template_key', $templateKey)->first();

    //     if (!$template) {
    //         return false;
    //         // throw new \Exception("Notification template '$templateKey' not found.");
    //     }

    //     // Apply replacements to title and message
    //     $title = $this->applyReplacements($template->title, $replacements);
    //     $message = $this->applyReplacements($template->notification_body, $replacements);

    //     if ($template->status != 1) {
    //         return true; // Notification disabled
    //     }

    //     // Start collecting user IDs
    //     $userIds = $template->users->pluck('id')->toArray();
    //     // Add manually passed user_id if available
    //     if (!empty($meta['user_id'])) {
    //         $userIds[] = $meta['user_id'];
    //     }
    //     // Remove duplicate user IDs
    //     $uniqueUserIds = array_unique($userIds);
    //     // Send notification to each user
    //     foreach ($uniqueUserIds as $userId) {
    //         $this->send($title, $message, array_merge($meta, ['user_id' => $userId]));
    //     }

    //     return true;
    // }
    // public function Activity_Update_Notification($templateKey, array $replacements, array $meta)
    // {
    //     $template = NotificationTemplate::with('users')->where('template_key', $templateKey)->first();

    //     if (!$template) {
    //         return false;
    //         // throw new \Exception("Notification template '$templateKey' not found.");
    //     }

    //     // Apply replacements to title and message
    //     $title = $this->applyReplacements($template->title, $replacements);
    //     $message = $this->applyReplacements($template->notification_body, $replacements);

    //     if ($template->status != 1) {
    //         return true; // Notification disabled
    //     }

    //     // Start collecting user IDs
    //     $userIds = $template->users->pluck('id')->toArray();
    //     // Add manually passed user_id if available
    //     if (!empty($meta['user_id'])) {
    //         $userIds[] = $meta['user_id'];
    //     }
    //     // Remove duplicate user IDs
    //     $uniqueUserIds = array_unique($userIds);
    //     // Send notification to each user
    //     foreach ($uniqueUserIds as $userId) {
    //         $this->send($title, $message, array_merge($meta, ['user_id' => $userId]));
    //     }

    //     return true;
    // }

// public function sendNotification(string $templateKey, array $replacements, array $meta)
// {
//     $template = NotificationTemplate::with('users')->where('template_key', $templateKey)->first();

//     if (!$template) {
//         return false;
//     }

//     if ($template->status != 1) {
//         return true; // Notification disabled
//     }
//     $body = html_entity_decode($template->notification_body, ENT_QUOTES | ENT_HTML5, 'UTF-8');
//     // Apply replacements
//     $title = $this->applyReplacements($template->title, $replacements);
//     $modal_title = $this->applyReplacements($template->modal_title ?? '', $replacements);
//     $message = $this->applyReplacements($body, $replacements);

//     $userIds = $template->users->pluck('id')->toArray();

//     // Add manually passed user
//     if (!empty($meta['user_id'])) {
//         $userIds[] = $meta['user_id'];
//     }

//     // Include order-related reps if enabled
//     if ($template->proccessing_rep == 1 && !empty($meta['order_id']) || ($template->sales_rep == 1 && !empty($meta['order_id']))) {
//         $order = Order::find($meta['order_id']);
//         if ($order) {
//             if ($template->proccessing_rep == 1 && $order->order_procesing_user_id) {
//                 $userIds[] = $order->order_procesing_user_id;
//             }
//             if ($template->sales_rep == 1 && $order->user_id) {
//                 $userIds[] = $order->user_id;
//             }
//         }
//     }
//     if($template->related_fac == 1 && !empty($meta['order_item_id'])){
//          $orderItem = OrderItem::where('id', $meta['order_item_id'])->first();
//          $factory_id = $orderItem->factory_id ?? null;
//         if($factory_id == 2){     // PBS Factory
//             $userRoleId = 5;  // PBS
//         }
//         if($factory_id == 1){     // WDC Factory
//             $userRoleId = 6;  // WDC
//         }
//         if($factory_id == 3){     // BII Factory
//             $userRoleId = 7;  // BII
//         }
//         if($factory_id == 7){     // UET Factory
//             $userRoleId = 8;  // UET
//         }
//         if($factory_id == 10){     // ZYS Factory
//             $userRoleId = 11;  // ZYS
//         }
//         if($factory_id == 16){     // Test Factory
//             $userRoleId = 12;  // Test
//         }
//         if($factory_id == null){
//             $userRoleId = null;
//         }

//     }

//     // Remove duplicates and send notifications
//     foreach (array_unique($userIds) as $userId) {
//         if ($template->related_fac == 1 && !empty($meta['order_item_id']) && isset($factory_id, $userRoleId) ) {
//             $user = User::find($userId);
//             if ($user) {
//                 $userRoles = json_decode($user->role_id, true); // decode JSON
//                 if (!in_array($userRoleId, $userRoles)) {
//                     continue; // Skip this user
//                 }
//             }
//         }
//         $this->send($title, $modal_title, $message, array_merge($meta, ['user_id' => $userId]));
//     }

//     return true;
// }




    public function sendNotification(string $templateKey, array $replacements, array $meta) {
        $template = NotificationTemplate::with('users')->where('template_key', $templateKey)->first();

        if (!$template) {
            return false;
        }

        if ($template->status != 1) {
            return true; // Notification disabled
        }
        $body = html_entity_decode($template->notification_body, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        // Apply replacements
        $title = $this->applyReplacements($template->title, $replacements);
        $modal_title = $this->applyReplacements($template->modal_title ?? '', $replacements);
        $message = $this->applyReplacements($body, $replacements);

        $userIds = $template->users->pluck('id')->toArray();

        // Add manually passed user
        if (!empty($meta['user_id'])) {
            $userIds[] = $meta['user_id'];
        }

        
        $orderIdsToProcess = [];
        if (!empty($meta['order_id'])) {
            $orderIdsToProcess[] = $meta['order_id'];
        }
        if (!empty($meta['order_ids']) && is_array($meta['order_ids'])) {
            $orderIdsToProcess = array_merge($orderIdsToProcess, $meta['order_ids']);
        }
        $orderIdsToProcess = array_unique($orderIdsToProcess);

        // Include order-related reps if enabled — now loops across ALL relevant orders
        if (!empty($orderIdsToProcess) && ($template->proccessing_rep == 1 || $template->sales_rep == 1)) {
            $orders = Order::whereIn('id', $orderIdsToProcess)->get();
            foreach ($orders as $order) {
                if ($template->proccessing_rep == 1 && $order->order_procesing_user_id) {
                    $userIds[] = $order->order_procesing_user_id;
                }
                if ($template->sales_rep == 1 && $order->user_id) {
                    $userIds[] = $order->user_id;
                }
            }
        }

        if ($template->related_fac == 1 && !empty($meta['order_item_id'])) {

            $orderItem = OrderItem::find($meta['order_item_id']);
            $factory_id = $orderItem->factory_id ?? null;

            $factoryRoleMap = [
                1  => 6,   // WDC
                2  => 5,   // PBS
                3  => 7,   // BII
                7  => 8,   // UET
                10 => 11,  // ZYS
                16 => 12,  // Test
                17 => 17,  // HBM
                18 => 27,  // BT
            ];

            $userRoleId = $factoryRoleMap[$factory_id] ?? null;

            if ($userRoleId) {
                $userIds = User::whereHas('roles', function ($q) use ($userRoleId) {
                        $q->where('id', $userRoleId);
                    })
                    ->where('active', 1)
                    ->pluck('id')
                    ->toArray();
            } else {
                $userIds = [];
            }
        }

        // Remove duplicates and send notifications
        foreach (array_unique($userIds) as $userId) {
            $this->send($title, $modal_title, $message, array_merge($meta, [
                'user_id' => $userId
            ]));
        }

        return true;
    }





}
