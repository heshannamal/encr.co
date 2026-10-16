<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class EmailNotificationTemplateCustomer extends Model implements Auditable
{
    use AuditableTrait;

    public const TYPE_TO = 0;
    public const TYPE_CC = 1;
    public const TYPE_BCC = 2;

    protected $table = 'email_notification_template_customers';

    protected $fillable = [
        'template_id',
        'organization_id',
        'type',
        'contact_id',
    ];

    protected $casts = [
        'template_id' => 'integer',
        'organization_id' => 'integer',
        'type' => 'integer',
        'contact_id' => 'integer',
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
            'template_id' => [
                'new_key' => 'template_key',
                'resolve' => function ($value) {
                    if (empty($value) || $value == 0) return null;
                    $template = \App\Models\EmailNotification::find($value);
                    return $template ? $template->template_key : "Deleted Template (ID: {$value})";
                }
            ],
            'organization_id' => [
                'new_key' => 'organization_name',
                'resolve' => function ($value) {
                    if (empty($value) || $value == 0) return null;
                    $organization = \App\Models\Organization::find($value);
                    return $organization ? $organization->organization_name : "Deleted Organization (ID: {$value})";
                }
            ],
            'type' => [
                'new_key' => 'type_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return match ((int)$value) {
                        0 => 'To',
                        1 => 'Cc',
                        2 => 'Bcc',
                        default => 'N/A',
                    };
                }
            ],
            'contact_id' => [
                'new_key' => 'contact_name',
                'resolve' => function ($value) {
                    if (empty($value) || $value == 0) return null;
                    $contact = \App\Models\Contact::find($value);
                    return $contact ? $contact->first_name.' '.$contact->last_name : "Deleted Contact (ID: {$value})";
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

    public function template()
    {
        return $this->belongsTo(
            EmailNotification::class,
            'template_id'
        );
    }

    public function organization()
    {
        return $this->belongsTo(
            Organization::class,
            'organization_id'
        );
    }

    public function contact()
    {
        return $this->belongsTo(
            Contact::class,
            'contact_id'
        );
    }
     public static function getEmailsByType($templateId, $type)
    {
        return self::query()
            ->join(
                'contacts',
                'contacts.id',
                '=',
                'email_notification_template_customers.contact_id'
            )
            ->where(
                'email_notification_template_customers.template_id',
                $templateId
            )
            ->where(
                'email_notification_template_customers.type',
                $type
            )
            ->whereNotNull('contacts.email')
            ->where('contacts.email', '!=', '')
            ->distinct()
            ->pluck('contacts.email')
            ->filter()
            ->values()
            ->toArray();
    }
}
