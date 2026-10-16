<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class StoreProductImage extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;
    public function storeProduct()
    {
        return $this->belongsTo(StoreProduct::class, 'store_product_id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
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
                    $store = \App\Models\StoreProduct::find($id);
                    return $store ? $store->product_name : "Deleted Product (ID: {$id})";
                }
            ],
            'active' => [
                'new_key' => 'status',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Active' : 'Inactive';
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

        $storeProduct = $this->storeProduct;
        $store = $this->store;
        if ($store) {
            $auditData['source'] = json_encode(['Store' => $store->id, 'Store Product' => $storeProduct->id]);
        }

        return $auditData;
    }
}
