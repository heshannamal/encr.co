<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class StoreCustomerCustomInformation extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    protected $table = 'store_customer_custom_informations';

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
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $customer = \App\Models\StoreCustomer::find($id);
                    return $customer ? $customer->customer_name : "Deleted Customer (ID: {$id})";
                }
            ],
            'custom_information_id' => [
                'new_key' => 'custom_information_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $custom_information = \App\Models\StoreCustomInformation::find($id);
                    return $custom_information ? $custom_information->custom_name : "Deleted Custom Information (ID: {$id})";
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

        return $auditData;
    }
}
