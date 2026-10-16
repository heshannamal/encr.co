<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class PatternCodeLayout extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

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
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $user = \App\Models\User::find($value);
                    return $user ? $user->name : "Deleted User (ID: {$value})";
                }
            ],
            'pattern_code' => [
                'new_key' => 'display_pattern_code',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Displayed' : 'Hidden';
                }
            ],
            'product_name' => [
                'new_key' => 'display_product_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Displayed' : 'Hidden';
                }
            ],
            'attribute_name' => [
                'new_key' => 'display_attribute_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Displayed' : 'Hidden';
                }
            ],
            'created' => [
                'new_key' => 'display_created',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Displayed' : 'Hidden';
                }
            ],
            'updated' => [
                'new_key' => 'display_updated',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Displayed' : 'Hidden';
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

        return $auditData;
    }
}
