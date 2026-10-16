<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class StoreAddedShippingMethod extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    protected $casts = [
        'shipping_fee' => 'decimal:2',
    ];

    protected $fillable = [
        'store_id',
        'shipping_method',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function shippingMethod()
    {
        return $this->belongsTo(StoreShippingMethod::class, 'shipping_method', 'id');
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
            'shipping_method' => [
                'new_key' => 'shipping_method_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $method = \App\Models\StoreShippingMethod::find($id);
                    return $method ? $method->shipping_method_name : "Deleted Shipping Method (ID: {$id})";
                }
            ]
        ];

        foreach (['old_values', 'new_values'] as $valueKey) {
            if (isset($auditData[$valueKey])) {
                foreach ($mappings as $originalKey => $mapping) {
                    if (array_key_exists($originalKey, $auditData[$valueKey])) {
                        $id = $auditData[$valueKey][$originalKey];
                        $resolvedValue = ($id !== null && $id !== '') ? $mapping['resolve']($id) : null;
                        
                        $auditData[$valueKey][$mapping['new_key']] = $resolvedValue;
                        unset($auditData[$valueKey][$originalKey]);
                    }
                }
            }
        }

        $store = $this->store;
        if ($store) {
            $auditData['source'] = json_encode(['Store' => $store->id]);
        }

        return $auditData;
    }
}
