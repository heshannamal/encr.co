<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class OrderItemsDetail extends Model implements Auditable
{
    use AuditableTrait;

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
        $orderItem = $this->orderItem;

        if ($orderItem) {
            $sourceData = ['Order Item' => $orderItem->id];

            // Retrieve the parent Order from OrderItem
            $order = $orderItem->order;
            if ($order) {
                $sourceData = ['Order' => $order->id, 'Order Item' => $orderItem->id];
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

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function sizeDetails(){
        return $this->belongsTo('App\Models\Size', 'size_id');
    }

    public function playerDetails(){
        return $this->belongsTo('App\Models\OrderItemsDetailPlayerName', 'id', 'order_items_detail_id');
    }

    protected $fillable = [
        'qty', 'size_id', 'blanks', 'numseq_one', 'numseq_two', 'numseq_three', 'numseq_four', 'numseq_five', 'numseq_six', 'numseq_seven', 'numseq_eight',
        'numseq_nine', 'numseq_ten', 'numseq_eleven', 'numseq_twelve', 'numseq_thirteen', 'numseq_fourteen', 'numseq_fifteen', 'numseq_sixteen',
        'numseq_seventeen', 'numseq_eighteen', 'numseq_nineteen', 'numseq_twenty', 'numseq_twenty_one', 'numseq_twenty_two', 'numseq_twenty_three',
        'numseq_twenty_four', 'numseq_twenty_five', 'numseq_twenty_six', 'numseq_twenty_seven', 'numseq_twenty_eight', 'numseq_twenty_nine', 'numseq_thirty',
        'numseq_thirty_one', 'numseq_thirty_two', 'numseq_thirty_three', 'numseq_thirty_four', 'numseq_thirty_five', 'numseq_thirty_six', 'numseq_thirty_seven',
        'numseq_thirty_eight', 'numseq_thirty_nine', 'numseq_forty', 'numseq_forty_one', 'numseq_forty_two', 'numseq_forty_three', 'numseq_forty_four',
        'numseq_forty_five', 'numseq_forty_six', 'numseq_forty_seven', 'numseq_forty_eight', 'numseq_forty_nine',
        'numseq_fifty', 'numseq_fifty_one', 'numseq_fifty_two', 'numseq_fifty_three', 'numseq_fifty_four', 'numseq_fifty_five', 'numseq_fifty_six', 'numseq_fifty_seven', 'numseq_fifty_eight', 'numseq_fifty_nine',
        'numseq_sixty', 'numseq_sixty_one', 'numseq_sixty_two', 'numseq_sixty_three', 'numseq_sixty_four', 'numseq_sixty_five', 'numseq_sixty_six', 'numseq_sixty_seven', 'numseq_sixty_eight', 'numseq_sixty_nine',
        'numseq_seventy', 'numseq_seventy_one', 'numseq_seventy_two', 'numseq_seventy_three', 'numseq_seventy_four', 'numseq_seventy_five', 'numseq_seventy_six', 'numseq_seventy_seven', 'numseq_seventy_eight', 'numseq_seventy_nine',
        'numseq_eighty', 'numseq_eighty_one', 'numseq_eighty_two', 'numseq_eighty_three', 'numseq_eighty_four', 'numseq_eighty_five', 'numseq_eighty_six', 'numseq_eighty_seven', 'numseq_eighty_eight', 'numseq_eighty_nine',
        'numseq_ninety', 'numseq_ninety_one', 'numseq_ninety_two', 'numseq_ninety_three', 'numseq_ninety_four', 'numseq_ninety_five', 'numseq_ninety_six', 'numseq_ninety_seven', 'numseq_ninety_eight', 'numseq_ninety_nine',

        'numseq_hundred','numseq_hundred_one', 'numseq_hundred_two', 'numseq_hundred_three', 'numseq_hundred_four', 'numseq_hundred_five', 'numseq_hundred_six', 'numseq_hundred_seven', 'numseq_hundred_eight', 'numseq_hundred_nine',
        'numseq_hundred_ten', 'numseq_hundred_eleven', 'numseq_hundred_twelve', 'numseq_hundred_thirteen', 'numseq_hundred_fourteen', 'numseq_hundred_fifteen', 'numseq_hundred_sixteen', 'numseq_hundred_seventeen', 'numseq_hundred_eighteen', 'numseq_hundred_nineteen',
        'numseq_hundred_twenty', 'numseq_hundred_twenty_one', 'numseq_hundred_twenty_two', 'numseq_hundred_twenty_three', 'numseq_hundred_twenty_four', 'numseq_hundred_twenty_five', 'numseq_hundred_twenty_six', 'numseq_hundred_twenty_seven', 'numseq_hundred_twenty_eight', 'numseq_hundred_twenty_nine',
        'numseq_hundred_thirty', 'numseq_hundred_thirty_one', 'numseq_hundred_thirty_two', 'numseq_hundred_thirty_three', 'numseq_hundred_thirty_four', 'numseq_hundred_thirty_five', 'numseq_hundred_thirty_six', 'numseq_hundred_thirty_seven', 'numseq_hundred_thirty_eight', 'numseq_hundred_thirty_nine',
        'numseq_hundred_forty', 'numseq_hundred_forty_one', 'numseq_hundred_forty_two', 'numseq_hundred_forty_three', 'numseq_hundred_forty_four', 'numseq_hundred_forty_five', 'numseq_hundred_forty_six', 'numseq_hundred_forty_seven', 'numseq_hundred_forty_eight', 'numseq_hundred_forty_nine',
        'numseq_hundred_fifty', 'show_extra'
    ];
}
