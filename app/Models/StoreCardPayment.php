<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class StoreCardPayment extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    public function OrderDetails()
    {
        return $this->hasOne(StoreOrder::class, 'order_no', 'store_order_no')->with('CustomerDetails','OrderItems','ShipmentDetails','storeDetails');
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
            'is_success' => [
                'new_key' => 'success_status',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    return $id == 1 ? 'Success' : 'Failed';
                }
            ],
            'is_refund' => [
                'new_key' => 'refunded_status',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    return $id == 1 ? 'Refunded' : 'Not Refunded';
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
