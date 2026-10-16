<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class StoreCustomInformation extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;
    protected $table = 'store_custom_informations';

    public function store()
    {
        return $this->belongsTo(Store::class);
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
            'store_id' => [
                'new_key' => 'store_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $store = \App\Models\Store::find($id);
                    return $store ? $store->store_name : "Deleted Store (ID: {$id})";
                }
            ],
            'make_as_sub_team' => [
                'new_key' => 'sub_team_status',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Sub Team' : 'Main Team';
                }
            ],
            'type' => [
                'new_key' => 'type_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return match ((int)$value) {
                        1 => 'Input Text',
                        2 => 'Select Input',
                        3 => 'Input Number',
                        default => null,
                    };
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
                        $id = $auditData[$valueKey][$originalKey];
                        $resolvedValue = ($id !== null && $id !== '') ? $mapping['resolve']($id) : null;
                        
                        $auditData[$valueKey][$mapping['new_key']] = $resolvedValue;
                        unset($auditData[$valueKey][$originalKey]);
                    }
                }
            }
        }

        $store = $this->store;
        if ($store) {
            $auditData['source'] = json_encode(['Store' => $store->id]);
        }

        return $auditData;
    }
}
