<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Order extends Model implements Auditable
{
    use AuditableTrait;

    public function orderItems(){
        // return $this->hasMany('App\Models\OrderItem');
        return $this->hasMany('App\Models\OrderItem')->ordered();
    }

    public function studioOrderItems(){
        return $this->hasMany('App\Models\OrderItem', 'parent_order_id', 'id')->where('is_studio_item', 1);
    }

    public function organizationDetails(){
        return $this->belongsTo('App\Models\Organization', 'organization_id');
    }

    public function contactDetails(){
        return $this->belongsTo('App\Models\Contact', 'contact_id');
    }

    public function userDetails(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function orderProcessingUserDetails(){
        return $this->belongsTo('App\Models\User', 'order_procesing_user_id');
    }

    public function statusDetails(){
        return $this->belongsTo('App\Models\OrderStatus', 'order_status_id');
    }

    public function inventoryDetails(){
        return $this->hasOne('App\Models\InventoryAddedOrder', 'order_id', 'id');
    }

    // public function contacts(){
    //     return $this->hasMany('App\Models\Contact', 'organization_id', 'organization_id');
    // }

    public function teamStoreDetails(){
        return $this->belongsTo('App\Models\TeamStoreOrder', 'id', 'order_id');
    }
    public function invoiceDetails(){
        return $this->belongsTo('App\Models\FactoryInvoice', 'id', 'order_id');
    }
    public function billingDetails(){
        return $this->belongsTo('App\Models\OrderBillingDetail', 'id', 'order_id');
    }
    public function contactOrganizations(){
        return $this->hasMany('App\Models\ContactOrganization', 'organization_id', 'organization_id');
    }
    public function productionApprovalDetail()
    {
        return $this->hasOne('App\Models\ProductionApprovalDetail');
    }

    protected $fillable = [
        'organization_id', 'contact_id', 'order_no', 'order_status_id', 'user_id', 'sub_total', 'sales_tax', 'shipping', 'artwork', 'processing_fee', 'order_total', 'ex_factory_date',
        'is_editable', 'is_requested', 'request_reasons', 'flag', 'open_date', 'due_date', 'discount', 'discountType', 'plorder'
    ];

    protected $appends = [
        'type_of_order'
    ];
    /**
     * Get the order type attribute
     *
     * @return string
     */
    public function getTypeOfOrderAttribute()
    {
        // Get inventory organization IDs
        $inventoryOrgIds = \domainencore\Facades\OrdersCommenFacade\OrdersCommenFacade::getEncoreOrgIds()->toArray();

        // Check if organization_id is in inventory organization IDs
        if (in_array($this->organization_id, $inventoryOrgIds)) {
            return 'inventory_order';
        }

        // Check plorder value
        if ($this->plorder == 1) {
            return 'white_labeling_order';
        }

        // Default case when plorder is 0
        return 'order';
    }

    public function transformAudit(array $data): array
    {
        // $sourceData = ['Order' => $this->id];

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
            
            $data['source'] = json_encode($sourceData);
        }


        return $data;
    }
}
