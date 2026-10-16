<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class OtherPayment extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    public function transformAudit(array $data): array
    {
        // Retrieve the parent Order
        $order = $this->order;
        $sourceData = [];
        if ($order) {
            $sourceData['Order'] = $order->id;
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
                    $data['user_id'] = $contact->id;
                    $data['user_type'] = \App\Models\Contact::class;
                }
            }
        }

        if(isset($sourceData) && !empty($sourceData)){
            $data['source'] = json_encode($sourceData);
        }

        return $data;
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }
}
