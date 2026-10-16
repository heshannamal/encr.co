<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Carbon\Carbon;
class SummaryAtPayment extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;
    public $timestamps = true;
    // Override default created_at behavior to include milliseconds
    public function setCreatedAt($value)
    {
        $this->attributes['created_at'] = Carbon::now()->format('Y-m-d H:i:s.u');
    }
    protected $fillable = [
        'method',
        'payment_type',
        'payedAmount',
        'order_id',
        'totalItemQty',
        'subTotal',
        'shipping',
        'salesTax',
        'artwork',
        'processingFee',
        'orderTotal',
        'balancePayment',
        'created_at',
        'updated_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
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
            'order_id' => [
                'new_key' => 'order_number',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $store = \App\Models\Order::find($id);
                    return $store ? $store->order_no : "Deleted Order (ID: {$id})";
                }
            ],
            'organization_id' => [
                'new_key' => 'organization_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $order = \App\Models\Organization::find($id);
                    return $order ? $order->organization_name : "Deleted Organization (ID: {$id})";
                }
            ],
            'active' => [
                'new_key' => 'active_status',
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

        $order = $this->order;
        $organization = $this->organization;
        if ($order) {
            $auditData['source'] = json_encode(['Order' => $order->id, 'Organization' => $organization->id]);
        }

        return $auditData;
    }
}
