<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
class EMCustomerCreditLog extends Model implements Auditable
{
    use AuditableTrait;
    protected $table = 'em_customer_credit_logs';
    protected $fillable = ['customer_id','credit_id','booking_id','type','classes','note'];

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
            'booking_id' => [
                'new_key' => 'booking_no',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $booking = EMSessionBooking::find($value);
                    return $booking ? $booking->booking_no : "Deleted Booking (ID: {$value})";
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
