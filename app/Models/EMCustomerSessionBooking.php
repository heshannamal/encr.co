<?php

namespace App\Models;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Model;

class EMCustomerSessionBooking extends Model implements Auditable
{
    use AuditableTrait;
    protected $table = 'em_customer_session_bookings';

    protected $fillable = [
        'customer_id','customer_package_id','session_event_id','booking_date','start_time','end_time','status','cancelled_at'
    ];

    public function sessionEvent()
    {
        return $this->belongsTo(EMSessionEvent::class, 'session_event_id');
    }

    public function customerPackage()
    {
        return $this->belongsTo(EMCustomerPackage::class, 'customer_package_id');
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
            'customer_package_id' => [
                'new_key' => 'package_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $package = EMCustomerPackage::find($value);
                    return $package ? $package->package_name : "Deleted Package (ID: {$value})";
                }
            ],
            'session_event_id' => [
                'new_key' => 'session_event_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $session = EMSessionEvent::find($value);
                    return $session ? $session->name : "Deleted Session (ID: {$value})";
                }
            ],
            'status' => [
                'new_key' => 'status_label',
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
