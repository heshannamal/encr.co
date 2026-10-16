<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class StoreProductExtraSize extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    public function storeProduct()
    {
        return $this->belongsTo(StoreProduct::class);
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
            'store_product_id' => [
                'new_key' => 'store_product_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $store = \App\Models\StoreProduct::find($id);
                    return $store ? $store->product_name : "Deleted Product (ID: {$id})";
                }
            ],
            'size_id' => [
                'new_key' => 'size_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $size = \App\Models\Size::find($id);
                    return $size ? $size->size_name : "Deleted Size (ID: {$id})";
                }
            ],
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
        if ($storeProduct) {
            $auditData['source'] = json_encode(['Store Product' => $storeProduct->id]);
        }

        return $auditData;
    }
}
