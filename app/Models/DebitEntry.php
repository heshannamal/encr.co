<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class DebitEntry extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    public function organizationDetails(){
        return $this->belongsTo('App\Models\Organization', 'organization_id');
    }

    public function orderDetails(){
        return $this->belongsTo('App\Models\Order', 'order_id');
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
            'organization_id' => [
                'new_key' => 'organization_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $organization = Organization::find($id);
                    return $organization ? $organization->organization_name : "Deleted Organization (ID: {$id})";
                }
            ],
            'order_id' => [
                'new_key' => 'order_no',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $order = Order::find($id);
                    return $order ? $order->order_no : "Deleted Order (ID: {$id})";
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

        $order = $this->orderDetails;
        $organization = $this->organizationDetails;
        if ($order) {
            $auditData['source'] = json_encode(['Order' => $order->id, 'Organization' => $organization->id]);
        }

        return $auditData;
    }
}
