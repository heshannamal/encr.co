<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class OrderItemsDetailPlayerName extends Model implements Auditable
{
    use AuditableTrait;

    protected $fillable = [
        'player_one', 'player_two', 'player_three', 'player_four', 'player_five', 'player_six', 'player_seven', 'player_eight', 'player_nine',
        'player_ten', 'player_eleven', 'player_twelve', 'player_thirteen', 'player_fourteen', 'player_fifteen', 'player_sixteen', 'player_seventeen', 'player_eighteen', 'player_nineteen',
        'player_twenty', 'player_twenty_one', 'player_twenty_two', 'player_twenty_three', 'player_twenty_four', 'player_twenty_five', 'player_twenty_six', 'player_twenty_seven', 'player_twenty_eight', 'player_twenty_nine',
        'player_thirty', 'player_thirty_one', 'player_thirty_two', 'player_thirty_three', 'player_thirty_four', 'player_thirty_five', 'player_thirty_six', 'player_thirty_seven', 'player_thirty_eight', 'player_thirty_nine',
        'player_forty', 'player_forty_one', 'player_forty_two', 'player_forty_three', 'player_forty_four', 'player_forty_five', 'player_forty_six', 'player_forty_seven', 'player_forty_eight', 'player_forty_nine',

        'player_fifty', 'player_fifty_one', 'player_fifty_two', 'player_fifty_three', 'player_fifty_four', 'player_fifty_five', 'player_fifty_six', 'player_fifty_seven', 'player_fifty_eight', 'player_fifty_nine',
        'player_sixty', 'player_sixty_one', 'player_sixty_two', 'player_sixty_three', 'player_sixty_four', 'player_sixty_five', 'player_sixty_six', 'player_sixty_seven', 'player_sixty_eight', 'player_sixty_nine',
        'player_seventy', 'player_seventy_one', 'player_seventy_two', 'player_seventy_three', 'player_seventy_four', 'player_seventy_five', 'player_seventy_six', 'player_seventy_seven', 'player_seventy_eight', 'player_seventy_nine',
        'player_eighty', 'player_eighty_one', 'player_eighty_two', 'player_eighty_three', 'player_eighty_four', 'player_eighty_five', 'player_eighty_six', 'player_eighty_seven', 'player_eighty_eight', 'player_eighty_nine',
        'player_ninety', 'player_ninety_one', 'player_ninety_two', 'player_ninety_three', 'player_ninety_four', 'player_ninety_five', 'player_ninety_six', 'player_ninety_seven', 'player_ninety_eight', 'player_ninety_nine',

        'player_hundred','player_hundred_one', 'player_hundred_two', 'player_hundred_three', 'player_hundred_four', 'player_hundred_five', 'player_hundred_six', 'player_hundred_seven', 'player_hundred_eight', 'player_hundred_nine',
        'player_hundred_ten', 'player_hundred_eleven', 'player_hundred_twelve', 'player_hundred_thirteen', 'player_hundred_fourteen', 'player_hundred_fifteen', 'player_hundred_sixteen', 'player_hundred_seventeen', 'player_hundred_eighteen', 'player_hundred_nineteen',
        'player_hundred_twenty', 'player_hundred_twenty_one', 'player_hundred_twenty_two', 'player_hundred_twenty_three', 'player_hundred_twenty_four', 'player_hundred_twenty_five', 'player_hundred_twenty_six', 'player_hundred_twenty_seven', 'player_hundred_twenty_eight', 'player_hundred_twenty_nine',
        'player_hundred_thirty', 'player_hundred_thirty_one', 'player_hundred_thirty_two', 'player_hundred_thirty_three', 'player_hundred_thirty_four', 'player_hundred_thirty_five', 'player_hundred_thirty_six', 'player_hundred_thirty_seven', 'player_hundred_thirty_eight', 'player_hundred_thirty_nine',
        'player_hundred_forty', 'player_hundred_forty_one', 'player_hundred_forty_two', 'player_hundred_forty_three', 'player_hundred_forty_four', 'player_hundred_forty_five', 'player_hundred_forty_six', 'player_hundred_forty_seven', 'player_hundred_forty_eight', 'player_hundred_forty_nine',
        'player_hundred_fifty', 'blank_qty', 'blank_player_names',
        'order_items_detail_id',
    ];

    public function getAuditEvents(): array
    {
        return ['updated', 'deleted'];
    }

    /**
     * Prepare the audit data.
     *
     * @return array
     */
    public function transformAudit(array $auditData): array
    {
        // Filter out changes where the old value is null and the new value is an empty string
        $auditData['old_values'] = array_filter($auditData['old_values'], function ($value, $key) use ($auditData) {
            return !($value === null && isset($auditData['new_values'][$key]) && $auditData['new_values'][$key] === '');
        }, ARRAY_FILTER_USE_BOTH);

        // Filter out the corresponding new values
        $auditData['new_values'] = array_intersect_key($auditData['new_values'], $auditData['old_values']);

        // Skip the audit if no meaningful changes are left
        if (empty($auditData['old_values']) && empty($auditData['new_values'])) {
            return [];
        }

        // Retrieve the parent OrderItem
        $orderItemsDetail = $this->orderItemsDetail;
        if ($orderItemsDetail) {
            $sourceData = ['Order Item Detail' => $orderItemsDetail->id];

            $orderItem = $orderItemsDetail->orderItem;
            if ($orderItem) {
                $auditData['order_item_id'] = $orderItem->id;
                $sourceData = ['Order Item' => $orderItem->id, 'Order Item Detail' => $orderItemsDetail->id];

                // Retrieve the parent Order from OrderItem
                $order = $orderItem->order;
                if ($order) {
                    $auditData['order_id'] = $order->id;
                    $sourceData = ['Order' => $order->id, 'Order Item' => $orderItem->id, 'Order Item Detail' => $orderItemsDetail->id];
                }
            }

            // Check if customer portal user is logged in
            if (\Illuminate\Support\Facades\Session::has('customer_portal_user')) {
                $sourceData['Customer Changes'] = 'Customer Changes';

                $customerUser = \Illuminate\Support\Facades\Session::get('customer_portal_user');
                $contactId = $customerUser[0] ?? null;
                if ($contactId) {
                    $contact = \App\Models\Contact::find($contactId);
                    if ($contact) {
                        // Set the audit user as the Contact model
                        $auditData['user_id'] = $contact->id;
                        $auditData['user_type'] = \App\Models\Contact::class;
                    }
                }
            }

            $auditData['source'] = json_encode($sourceData);
        }

        return $auditData;
    }

    /**
     * Determine if the audit data should be recorded.
     *
     * @param array $data
     * @return bool
     */
    public function shouldAudit(array $data): bool
    {
        return !empty($data);
    }

    public function orderItemsDetail(){
        return $this->belongsTo('App\Models\OrderItemsDetail', 'order_items_detail_id');
    }
    public function orderDetail(){
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
    use HasFactory;
}
