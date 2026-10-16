<?php

namespace App\Models;

use domainencore\Facades\PatternCodeFacade\PatternCodeFacade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class OrderItem extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

    protected $table = 'order_items';

    public function getAuditEvents(): array
    {
        return ['created', 'updated', 'deleted'];
    }

    public function transformAudit(array $data): array
    {
        // Retrieve the parent Order
        $order = $this->order;
        if ($order) {
            $sourceData = ['Order' => $order->id];

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

            $data['source'] = json_encode($sourceData);
        }

        return $data;
    }

    // public function toAudit(): array
    // {
    //     $auditData = parent::toAudit();

    //     // Retrieve the parent Order from OrderItem
    //     $order = $this->order;
    //     if ($order) {
    //         $auditData['order_id'] = $order->id;
    //     }

    //     return $auditData;
    // }

    // public function shouldAudit(array $data): bool
    // {
    //     return !empty($data);
    // }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItemDetails(){
        return $this->hasMany('App\Models\OrderItemsDetail');
    }

    public function productDetails(){
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function embellishmentDetails(){
        return $this->belongsTo('App\Models\EmbellishmentType', 'embellishment_type_id');
    }

    public function factoryDetails(){
        return $this->belongsTo('App\Models\Factory', 'factory_id')->with('bankDetails');
    }

    public function fabricDetails(){
        return $this->belongsTo('App\Models\Fabric', 'fabric_id');
    }

    public function secFabricDetails(){
        return $this->belongsTo('App\Models\Fabric', 'secondary_fabric_id');
    }

    public function statusDetails(){
        return $this->belongsTo('App\Models\OrderStatus', 'order_status_id');
    }

    public function exFactoryDetails(){
        return $this->belongsTo('App\Models\ExFactory', 'ex_factory_id');
    }

    public function orderItemFiles(){
        return $this->hasMany('App\Models\OrderItemFile');
    }

    public function notifiedUser(){
        return $this->belongsTo('App\Models\User', 'notified_user_id');
    }

    public function orderItemAttributes(){
        return $this->hasMany('App\Models\OrderItemAttribute', 'order_item_id', 'id');
    }

    public function productAttributes(){
        return $this->hasMany('App\Models\ProductAttribute', 'product_id', 'product_id');
    }

    public function productFabrics(){
        return $this->hasMany('App\Models\ProductFabric', 'product_id', 'product_id');
    }

    public function productEmbellishmentTypes(){
        return $this->hasMany('App\Models\ProductEmbellishmentType', 'product_id', 'product_id');
    }
    public function subProduct()
{
    return $this->belongsTo(\App\Models\SubProduct::class, 'sub_product_no', 'sub_product_no');
}

    public function orderItemProductDetails()
    {
        return $this->belongsTo('App\Models\SubProduct', 'sub_product_no', 'sub_product_no')->with('manufacturePriceDetails:id,sub_product_no,price_type,price,start_date,end_date');
    }

    public function orderItemProductInvoiceDetails()
    {
        return $this->hasOne('App\Models\InvoiceProduct', 'order_item_id', 'id');
    }

    public function scopeOrdered($query)
    {
        return $query
            ->orderByRaw('COALESCE(sort_order, CAST(SUBSTRING_INDEX(item_no, \'-\', -1) AS UNSIGNED)) ASC')
            ->orderBy('id');
    }

    protected $fillable = [
        'item_no', 'sort_order', 'order_id', 'product_id','sub_product_no','display_name', 'organization_id', 'factory_id', 'support_agent_id', 'designer_id', 'shipping_method', 'ex_factory_id', 'ex_factory_date',
        'in_hand_due_date', 'est_delivery_date', 'order_status_id', 'fabric_id', 'secondary_fabric_id', 'embellishment_type_id', 'sport', 'gender', 'qty', 'unit_price', 'total',
        'extra_size', 'extra_size_two', 'extra_size_three', 'double_sided', 'individual_name', 'pockets', 'zipper_pockets', 'dynamic_details',
        'contrast_stratching', 'printing_over_sems', 'tracking_no', 'tracking_link','individual_no', 'is_studio_item', 'remake_status', 'has_remake_item'
    ];

    protected $appends = ['pattern_code', 'manufacture_price'];

    public function getPatternCodeAttribute()
    {
        $sub_product_no = $this->sub_product_no;
        $attribute_ids = OrderItemSubAttribute::where('order_item_id', $this->id)->pluck('attribute_id')->toArray();
        $patterCode = PatternCodeFacade::getOrderItemPatternCode($sub_product_no, $attribute_ids);
        return $patterCode[0];
    }

    public function getManufacturePriceAttribute()
    {
        if ($this->orderItemProductInvoiceDetails) {
            $invoiceUnitPrice = $this->orderItemProductInvoiceDetails->unit_price;
            if ($invoiceUnitPrice !== null && (float)$invoiceUnitPrice > 0) {
                return $invoiceUnitPrice;
            }
        }

        if (
            $this->orderItemProductDetails
            && $this->orderItemProductDetails->manufacturePriceDetails
        ) {
            return $this->orderItemProductDetails->manufacturePriceDetails->price;
        }

        return '0.00';
    }
}
