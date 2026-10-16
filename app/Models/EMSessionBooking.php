<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class EMSessionBooking extends Model implements Auditable
{
    use AuditableTrait;
    protected $table = 'em_customer_session_bookings';

    protected $fillable = [
        'customer_id',
        'customer_child_id',
        'session_event_id',
        'credit_id',
        'booking_no',
        'player_first',
        'player_last',
        'grad_year',
        'positions',
        'status',
        'booked_at',
        'cancelled_at',
    ];

    protected $casts = [
        'positions' => 'array',
        'booked_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function sessionEvent()
    {
        return $this->belongsTo(
            EMSessionEvent::class,
            'session_event_id'
        );
    }

    public function child()
    {
        return $this->belongsTo(
            EMCustomerChild::class,
            'customer_child_id'
        );
    }

    public function credit()
    {
        return $this->belongsTo(
            EMCustomerCredit::class,
            'credit_id'
        );
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
            'session_event_id' => [
                'new_key' => 'session_event_title',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $session = EMSessionEvent::find($value);
                    return $session ? $session->name : "Deleted Session (ID: {$value})";
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
