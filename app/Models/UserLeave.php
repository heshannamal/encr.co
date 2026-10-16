<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class UserLeave extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;
    
    protected $table = 'user_leaves';

    protected $fillable = [
        'user_id',
        'title',
        'start_date',
        'end_date',
        'type',
        'day_type',
        'request_note',
        'approve_by',
        'status',
        'note',
        'active',
        'short_from_time',
        'short_to_time',
        'covering_leave_date',
        'covering_cover_date',
    ];

    public $timestamps = true;

    public function userDetails()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    // In UserLeave.php model
    public function user()
    {
        return $this->belongsTo(User::class);
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
                    if (empty($value)) return null;
                    $user = User::find($value);
                    return $user ? $user->name : "Deleted User (ID: {$value})";
                }
            ],
            'approve_by' => [
                'new_key' => 'approve_by_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $user = User::find($value);
                    return $user ? $user->name : "Deleted User (ID: {$value})";
                }
            ],
            'type' => [
                'new_key' => 'type_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return match ((int)$value) {
                        0 => 'Half Day',
                        1 => 'One Day',
                        2 => 'Multiple Days',
                        3 => 'Short Leave',
                        default => 'One Day',
                    };
                }
            ],
            'day_type' => [
                'new_key' => 'day_type_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return match ((int)$value) {
                        0 => 'First Half',
                        1 => 'Second Half',
                        default => 'First Half',
                    };
                }
            ],
            'status' => [
                'new_key' => 'leave_status',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return match ((int)$value) {
                        0 => 'Pending',
                        1 => 'Approved',
                        2 => 'Rejected',
                        default => 'Pending',
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
                        $value = $auditData[$valueKey][$originalKey];
                        $resolvedValue = ($value !== null && $value !== '') ? $mapping['resolve']($value) : null;
                        
                        $auditData[$valueKey][$mapping['new_key']] = $resolvedValue;
                        unset($auditData[$valueKey][$originalKey]);
                    }
                }
            }
        }

        $user = $this->user;
        if ($user) {
            $auditData['source'] = json_encode(['User' => $user->id.' - '.$user->name]);
        }
        
        return $auditData;
    }
}
