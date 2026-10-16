<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class PmTaskAssignee extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use AuditableTrait;

    protected $fillable = [
        'project_id',
        'section_id',
        'discussion_id',
        'is_sub_discussion',
        'sub_discussion_id',
        'assignee_id',
        'assigned_by',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function section()
    {
        return $this->belongsTo(PmSection::class, 'section_id');
    }

    public function discussion()
    {
        return $this->belongsTo(PmSectionDiscussion::class, 'discussion_id');
    }

    public function subDiscussion()
    {
        return $this->belongsTo(PmSectionSubDiscussion::class, 'sub_discussion_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function assignedByUser()
    {
        return $this->belongsTo(User::class, 'assigned_by');
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
            'project_id' => [
                'new_key' => 'project_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $project = \App\Models\Project::find($value);
                    return $project ? $project->project_name : "Deleted Project (ID: {$value})";
                }
            ],
            'section_id' => [
                'new_key' => 'section_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $section = \App\Models\PmSection::find($value);
                    return $section ? $section->section_name : "Deleted Section (ID: {$value})";
                }
            ],
            'discussion_id' => [
                'new_key' => 'task_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $task = \App\Models\PmSectionDiscussion::find($value);
                    return $task ? $task->discussion_name : "Deleted Task (ID: {$value})";
                }
            ],
            'is_sub_discussion' => [
                'new_key' => 'task_type',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Sub Task' : 'Task';
                }
            ],
            'sub_discussion_id' => [
                'new_key' => 'sub_task_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $section = \App\Models\PmSectionSubDiscussion::find($value);
                    return $section ? $section->discussion_name : "Deleted Sub Task (ID: {$value})";
                }
            ],
            'assignee_id' => [
                'new_key' => 'assignee_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $assignee = \App\Models\User::find($value);
                    return $assignee ? $assignee->name : "Deleted User (ID: {$value})";
                }
            ],
            'assigned_by' => [
                'new_key' => 'assigned_by_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $user = \App\Models\User::find($value);
                    return $user ? $user->name : "Deleted User (ID: {$value})";
                }
            ],
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

        $auditData['source'] = json_encode([
            'Project' => $this->project_id, 
            'PmSection' => $this->section_id,
            'PmSectionDiscussion' => $this->discussion_id,
        ]);

        return $auditData;
    }
}
