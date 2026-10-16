<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class SupportAgent extends Model implements Auditable
{
    use AuditableTrait;
    protected $fillable = [
        'user_id',
        'is_online',
        'is_available',
        'max_active_chats',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function departments()
    {
        return $this->belongsToMany(
            SupportDepartment::class,
            'support_agent_departments',
            'support_agent_id',
            'support_department_id'
        );
    }

    public function assignedConversations()
    {
        return $this->hasMany(SupportConversation::class, 'assigned_agent_id');
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
            'user_id' => [
                'new_key' => 'user_name',
                'resolve' => function ($value) {
                    if (empty($value) || $value == 0) return null;
                    $user = \App\Models\User::find($value);
                    return $user ? $user->name : "Deleted User (ID: {$value})";
                }
            ],
            'is_online' => [
                'new_key' => 'online_status',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Yes' : 'No';
                }
            ],
            'is_available' => [
                'new_key' => 'available_status',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Yes' : 'No';
                }
            ],
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
