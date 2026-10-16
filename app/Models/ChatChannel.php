<?php

// app/Models/ChatChannel.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class ChatChannel extends Model implements Auditable
{
    use AuditableTrait;
    protected $fillable = [
        'organization_id',
        'issue_type',
        'assigned_user_id',
        'status',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'channel_id');
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
            'organization_id' => [
                'new_key' => 'organization_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $organization = Organization::find($value);
                    return $organization ? $organization->organization_name : "Deleted Organization (ID: {$value})";
                }
            ],
            'assigned_user_id' => [
                'new_key' => 'assigned_user_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $user = User::find($value);
                    return $user ? $user->name : "Deleted User (ID: {$value})";
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
