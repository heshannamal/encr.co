<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class EmailNotificationTemplateUser extends Model implements Auditable
{
    use AuditableTrait;

    protected $table = 'email_notification_template_users';

    protected $fillable = [
        'template_id',
        'type',
        'user_id',
    ];

    public $timestamps = true;

    // Scopes to filter by type

    public function scopeTo($query)
    {
        return $query->where('type', 0);
    }

    public function scopeCc($query)
    {
        return $query->where('type', 1);
    }

    public function scopeBcc($query)
    {
        return $query->where('type', 2);
    }

    /**
     * Get emails by type for a given template_id
     */
    public static function getEmailsByType(int $templateId, int $type): array
    {
        $userIds = self::where('template_id', $templateId)
                        ->where('type', $type)
                        ->pluck('user_id');

        return \App\Models\User::whereIn('id', $userIds)
                    ->pluck('email')
                    ->toArray();
    }

    // Optional relation to template
    public function template()
    {
        return $this->belongsTo(EmailNotification::class, 'template_id');
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
            'template_id' => [
                'new_key' => 'template_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $template = EmailNotification::find($value);
                    return $template ? $template->name : "Deleted Template (ID: {$value})";
                }
            ],
            'user_id' => [
                'new_key' => 'user_name',
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

        return $auditData;
    }
}
