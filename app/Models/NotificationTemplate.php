<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class NotificationTemplate extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditableTrait;

    protected $table = 'notification_templates';

    protected $fillable = [
        'function_name',
        'controller',
        'template_key',
        'title',
        'modal_title',
        'notification_body',
        'modal_footer',
        'confirm_route',
        'reject_route',
        'description',
        'status',
        'name',
    ];

    /**
     * The users this notification template is assigned to.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'notification_template_users')
                    ->withTimestamps();
    }

    /**
     * Send this notification template to all assigned users.
     *
     * @param array $placeholders
     * @param array $extraData
     * @return void
     */
    // public function sendToAssignedUsers(array $placeholders = [], array $extraData = [])
    // {
    //     foreach ($this->users as $user) {
    //         Notification::create(array_merge([
    //             'notification_title'   => strtr($this->notification_body, $placeholders),
    //             'notification_message' => strtr($this->notification_body, $placeholders),
    //             'user_id'              => $user->id,
    //         ], $extraData));
    //     }
    // }

    public function transformAudit(array $auditData): array
    {
        $auditData['old_values'] = array_filter($auditData['old_values'], function ($value, $key) use ($auditData) {
            return !($value === null && isset($auditData['new_values'][$key]) && $auditData['new_values'][$key] === '');
        }, ARRAY_FILTER_USE_BOTH);

        if (empty($auditData['old_values']) && empty($auditData['new_values'])) {
            return [];
        }

        $mappings = [
            'status' => [
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
