<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class ItemExFactoryDateLog extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;
    protected $fillable = [
        'order_item_id',
        'user_id',
        'pre_date',
        'new_date',
        'reason',
    ];

    public function getByOrderItem($orderItemId)
    {
        return $this->where('order_item_id', $orderItemId)->with('userDetail')->get();
    }

    public function userDetail(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function orderItemDetail(){
        return $this->belongsTo('App\Models\OrderItem', 'order_item_id', 'id');
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
            'user_id' => [
                'new_key' => 'user_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $user = \App\Models\User::find($id);
                    return $user ? $user->name : "Deleted User (ID: {$id})";
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

        $order = $this->orderItemDetail->order;
        if ($order) {
            $auditData['source'] = json_encode(['Order' => $order->id]);
        }
        $auditData['source'] = json_encode(['Order Item' => $this->order_item_id]);

        return $auditData;
    }
}
