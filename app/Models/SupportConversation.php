<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class SupportConversation extends Model implements Auditable
{
    use AuditableTrait;
    protected $fillable = [
        'customer_id',
        'support_department_id',
        'assigned_agent_id',
        'subject',
        'status',
        'priority',
        'started_at',
        'closed_at',
        'last_message_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'closed_at' => 'datetime',
        'last_message_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Contact::class);
    }

    public function department()
    {
        return $this->belongsTo(SupportDepartment::class, 'support_department_id');
    }

    public function assignedAgent()
    {
        return $this->belongsTo(SupportAgent::class, 'assigned_agent_id');
    }

    public function messages()
    {
        return $this->hasMany(SupportMessage::class, 'support_conversation_id');
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
                    if (empty($value) || $value == 0) return null;
                    $customer = \App\Models\Contact::find($value);
                    return $customer ? $customer->first_name.' '.$customer->last_name : "Deleted User (ID: {$value})";
                }
            ],
            'support_department_id' => [
                'new_key' => 'department_name',
                'resolve' => function ($value) {
                    if (empty($value) || $value == 0) return null;
                    $department = \App\Models\SupportDepartment::find($value);
                    return $department ? $department->name : "Deleted Department (ID: {$value})";
                }
            ],
            'assigned_agent_id' => [
                'new_key' => 'assigned_agent_name',
                'resolve' => function ($value) {
                    if (empty($value) || $value == 0) return null;
                    $agent = \App\Models\SupportAgent::find($value);
                    return $agent ? ($agent->user->name ?? "Deleted Agent (ID: {$value})") : "Deleted Agent (ID: {$value})";
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
