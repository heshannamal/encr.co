<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class PaymentLog extends Model implements Auditable
{
    use AuditableTrait;

    protected $fillable = [
        'amount','response_code','transaction_id', 'auth_id','quantity','message_code','name_on_card', 'card_last_digits'
    ];

    public function transformAudit(array $auditData): array
    {

        $order = $this->order;
        if ($order) {
            $sourceData = ['Order' => $order->id];
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

        if(isset($sourceData) && !empty($sourceData)){
            $auditData['source'] = json_encode($sourceData);
        }
        return $auditData;
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }
}

