<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
class EMCustomerChild extends Model implements Auditable
{
    use AuditableTrait;
    protected $table = 'em_customer_children';

    protected $fillable = [
        'customer_id',
        'player_first',
        'player_last',
        'grad_year',
        'positions',
        'is_active',
    ];

    protected $casts = [
        'positions' => 'array',
        'is_active' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(EMCustomer::class, 'customer_id');
    }

    public function bookings()
    {
        return $this->hasMany(EMSessionBooking::class, 'customer_child_id');
    }

    public function getFullNameAttribute()
    {
        return trim($this->player_first . ' ' . $this->player_last);
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
            'customer_id' => [
                'new_key' => 'customer_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $customer = EMCustomer::find($value);
                    return $customer ? $customer->first_name.' '.$customer->last_name : "Deleted Customer (ID: {$value})";
                }
            ],
            'is_active' => [
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
                        $resolvedValue = ($value !== null && $value !== '') ? $mapping['resolve']($value, $valueKey) : null;
                        
                        $auditData[$valueKey][$mapping['new_key']] = $resolvedValue;
                        unset($auditData[$valueKey][$originalKey]);
                    }
                }
            }
        }

        return $auditData;
    }
}
