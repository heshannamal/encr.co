<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class NotificationTemplateUser extends Model implements Auditable
{
    use HasFactory, AuditableTrait;
    protected $fillable = [
        'user_id',
        'notification_template_id',
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
            'user_id' => [
                'new_key' => 'user_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $user = User::find($value);
                    return $user ? $user->name : "Deleted User (ID: {$value})";
                }
            ],
            'notification_template_id' => [
                'new_key' => 'template_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $template = NotificationTemplate::find($value);
                    return $template ? $template->name : "Deleted Template (ID: {$value})";
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
