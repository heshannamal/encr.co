<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class SupportTransfer extends Model implements Auditable
{
    use AuditableTrait;
    protected $fillable = [
        'support_conversation_id',
        'from_agent_id',
        'to_agent_id',
        'from_department_id',
        'to_department_id',
        'reason',
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
            'from_agent_id' => [
                'new_key' => 'from_agent_name',
                'resolve' => function ($value) {
                    if (empty($value) || $value == 0) return null;
                    $agent = \App\Models\SupportAgent::find($value);
                    return $agent ? ($agent->user->name ?? "Deleted Agent (ID: {$value})") : "Deleted Agent (ID: {$value})";
                }
            ],
            'to_agent_id' => [
                'new_key' => 'to_agent_name',
                'resolve' => function ($value) {
                    if (empty($value) || $value == 0) return null;
                    $agent = \App\Models\SupportAgent::find($value);
                    return $agent ? ($agent->user->name ?? "Deleted Agent (ID: {$value})") : "Deleted Agent (ID: {$value})";
                }
            ],
            'from_department_id' => [
                'new_key' => 'from_department_name',
                'resolve' => function ($value) {
                    if (empty($value) || $value == 0) return null;
                    $department = \App\Models\SupportDepartment::find($value);
                    return $department ? $department->name : "Deleted Department (ID: {$value})";
                }
            ],
            'to_department_id' => [
                'new_key' => 'to_department_name',
                'resolve' => function ($value) {
                    if (empty($value) || $value == 0) return null;
                    $department = \App\Models\SupportDepartment::find($value);
                    return $department ? $department->name : "Deleted Department (ID: {$value})";
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

        $auditData['source'] = json_encode([
            'Support Conversation' => $this->support_conversation_id,
        ]);

        return $auditData;
    }
}
