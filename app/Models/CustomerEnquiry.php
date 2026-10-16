<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class CustomerEnquiry extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;
    protected $table = 'customer_enquiries';
    protected $fillable = [
        'organization_id', 'contact_id', 'order_no', 'order_status_id', 'user_id', 'sub_total', 'sales_tax', 'shipping', 'artwork', 'processing_fee', 'order_total',
        'is_editable', 'is_requested', 'request_reasons', 'flag', 'open_date', 'due_date'
    ];

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
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $organization = Organization::find($value);
                    return $organization ? $organization->organization_name : "Deleted Organization (ID: {$value})";
                }
            ],
            'contact_id' => [
                'new_key' => 'contact_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $contact = Contact::find($value);
                    return $contact ? $contact->first_name.' '.$contact->last_name : "Deleted Contact (ID: {$value})";
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

        $auditData['source'] = json_encode(['Organization' => $this->organization_id]);

        return $auditData;
    }
}
