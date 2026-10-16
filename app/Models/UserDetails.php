<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class UserDetails extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    protected $table = 'user_details';

    protected $fillable = [
        'user_id',
        'm_number',
        'w_number',
        'address',
        'about',
        'city',
        'country',
        'postal_code',
        'timezone',
        'job_title',
        'joined_date',
        'leavetype_id',
        'dob',
        'Marital_Status',
        'Gender',
        'Nationality',
        'Languages',
        'Employment_Status',
        'Department',
        'Private_Email',
    ];

    public function getAuditEvents(): array
    {
        return ['created', 'updated', 'deleted'];
    }

    public function transformAudit(array $data): array
    {
        $data['old_values'] = array_filter($data['old_values'], function ($value, $key) use ($data) {
            return !($value === null && isset($data['new_values'][$key]) && $data['new_values'][$key] === '');
        }, ARRAY_FILTER_USE_BOTH);

        if (empty($data['old_values']) && empty($data['new_values'])) {
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
            'leavetype_id' => [
                'new_key' => 'leave_gourp_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $user = LeaveGroup::find($value);
                    return $user ? $user->name : "Deleted User (ID: {$value})";
                }
            ],
            'Languages' => [
                'new_key' => 'languages_names',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $langNames = is_array($value) ? $value : json_decode($value, true);
                    if (!is_array($langNames)) $langNames = [$langNames];
                    return implode(', ', $langNames);
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
            if (isset($data[$valueKey])) {
                foreach ($mappings as $originalKey => $mapping) {
                    if (array_key_exists($originalKey, $data[$valueKey])) {
                        $value = $data[$valueKey][$originalKey];
                        $resolvedValue = ($value !== null && $value !== '') ? $mapping['resolve']($value) : null;
                        
                        $data[$valueKey][$mapping['new_key']] = $resolvedValue;
                        unset($data[$valueKey][$originalKey]);
                    }
                }
            }
        }

        // Retrieve the parent Order
        $user = $this->user;
        if ($user) {
            $data['source'] = json_encode(['User' => $user->id]);
        }

        return $data;
    }

    public function setLanguagesAttribute($value)
    {
        $this->attributes['Languages'] = is_array($value) ? json_encode($value) : $value;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function leaveType()
    {
        return $this->belongsTo(LeaveGroup::class, 'leavetype_id');
    }
}
