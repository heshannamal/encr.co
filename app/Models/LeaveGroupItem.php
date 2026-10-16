<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class LeaveGroupItem extends Model implements Auditable
{
    use AuditableTrait;
    protected $table = 'leave_group_items';
    protected $fillable = ['leave_group_id', 'leave_type_id', 'leave_days'];

    // Relationship back to the Master Type name
    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }

    public function leaveGroup()
    {
        return $this->belongsTo(LeaveGroup::class, 'leave_group_id');
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
            'leave_group_id' => [
                'new_key' => 'leave_group',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $store = LeaveGroup::find($id);
                    return $store ? $store->name : "Deleted Leave Group (ID: {$id})";
                }
            ],
            'leave_type_id' => [
                'new_key' => 'leave_type',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $store = LeaveType::find($id);
                    return $store ? $store->name : "Deleted Leave Type (ID: {$id})";
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

        $leaveGroup = $this->leaveGroup;
        if ($leaveGroup) {
            $auditData['source'] = json_encode(['Leave Group' => $leaveGroup->name]);
        }

        return $auditData;
    }
}
