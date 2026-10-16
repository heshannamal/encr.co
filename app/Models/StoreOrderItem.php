<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class StoreOrderItem extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    protected $table = 'store_order_items';
    public function OrderItemDetails()
    {
        return $this->hasMany(StoreOrderPlayerDetail::class, 'store_order_item_id', 'id')->with('ColorDetails', 'SizeDetails');
    }
    public function productDetails()
    {
        return $this->hasOne(StoreProduct::class, 'id', 'store_product_id')->with('sizes','images','priceAdditions','IndividualNameDetails','IndividualNumberDetails');
    }
    public function orderDetails(){
        return $this->hasOne(StoreOrder::class,'id','store_order_id')->with('customerDetails');
    }
    public function storeDetails(){
        return $this->belongsTo(Store::class,'store_id','id');
    }

    public function transformAudit(array $auditData): array
    {
        $auditData['old_values'] = array_filter($auditData['old_values'], function ($value, $key) use ($auditData) {
            return !($value === null && isset($auditData['new_values'][$key]) && $auditData['new_values'][$key] === '');
        }, ARRAY_FILTER_USE_BOTH);

        if (empty($auditData['old_values']) && empty($auditData['new_values'])) {
            return [];
        }

        $mappings = [
            'store_id' => [
                'new_key' => 'store_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $store = \App\Models\Store::find($id);
                    return $store ? $store->store_name : "Deleted Store (ID: {$id})";
                }
            ],
            'store_order_id' => [
                'new_key' => 'store_order_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $order = \App\Models\StoreOrder::find($id);
                    return $order ? $order->order_no : "Deleted Order (ID: {$id})";
                }
            ],
            'store_product_id' => [
                'new_key' => 'store_product_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $product = \App\Models\StoreProduct::find($id);
                    return $product ? $product->product_name : "Deleted Product (ID: {$id})";
                }
            ],
            'is_updated' => [
                'new_key' => 'updated_status',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Yes' : 'No';
                }
            ]
        ];

        foreach (['old_values', 'new_values'] as $valueKey) {
            if (isset($auditData[$valueKey])) {
                foreach ($mappings as $originalKey => $mapping) {
                    if (array_key_exists($originalKey, $auditData[$valueKey])) {
                        $value = $auditData[$valueKey][$originalKey];
                        $resolvedValue = ($value !== null && $value !== '') ? $mapping['resolve']($value) : null;
                        
                        $auditData[$valueKey][$mapping['new_key']] = $resolvedValue;
                        unset($auditData[$valueKey][$originalKey]);
                    }
                }
            }
        }

        $store = $this->storeDetails;
        $product = $this->productDetails;
        $order = $this->orderDetails;
        if ($store) {
            $auditData['source'] = json_encode(['Store' => $store->id, 'Order' => $order->id, 'Product' => $product->id]);
        }

        return $auditData;
    }
}
