<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class StoreOrderPlayerDetail extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    public function setPlayerNumberAttribute($value)
    {
        $value = is_string($value) ? trim($value) : $value;
        $this->attributes['player_number'] = ($value === '' || $value === 'null') ? null : $value;
    }

    public function ColorDetails()
    {
        return $this->hasOne(StoreProductVariant::class, 'id', 'color');
    }
    public function SizeDetails()
    {
        return $this->hasOne(Size::class, 'id', 'size');
    }
    public function productDetails()
    {
        return $this->hasOne(StoreProduct::class, 'id', 'store_product_id');
    }
    public function orderItemDetails(){
        return $this->hasOne(StoreOrderItem::class,'id','store_order_item_id')->with('orderDetails');
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
            'store_product_id' => [
                'new_key' => 'store_product_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $product = \App\Models\StoreProduct::find($id);
                    return $product ? $product->product_name : "Deleted Product (ID: {$id})";
                }
            ],
            'size' => [
                'new_key' => 'size_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $size = \App\Models\Size::find($id);
                    return $size ? $size->size_name : "Deleted Size (ID: {$id})";
                }
            ],
            'is_name_available' => [
                'new_key' => 'name_availablility',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Yes' : 'No';
                }
            ],
            'is_number_available' => [
                'new_key' => 'number_availablility',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Yes' : 'No';
                }
            ],
            'item_status' => [
                'new_key' => 'updated_status',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return match ((int)$value) {
                        1 => 'New',
                        2 => 'Quote',
                        3 => 'Production',
                        4 => 'Shipped',
                        5 => 'Complete',
                        default => 'Quote',
                    };
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
        $orderItem = $this->orderItemDetails;
        if ($store) {
            $auditData['source'] = json_encode(['Store' => $store->id, 'Order Item' => $orderItem->id, 'Product' => $product->id]);
        }

        return $auditData;
    }
}
