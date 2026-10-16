<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class PmSection extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use AuditableTrait;

    protected $fillable = [
        'project_id',
        'section_name',
        'user_id',
        'sort_index',
        'stage_status',
    ];

    public function getAuditEvents(): array
    {
        return ['created', 'updated', 'deleted'];
    }

    public function transformAudit(array $data): array
    {
        // Filter out changes where the old value is null and the new value is an empty string
        if (isset($data['old_values'])) {
            $data['old_values'] = array_filter($data['old_values'], function ($value, $key) use ($data) {
                return !($value === null && isset($data['new_values'][$key]) && $data['new_values'][$key] === '');
            }, ARRAY_FILTER_USE_BOTH);
        }

        // Skip the audit if no meaningful changes are left
        if (empty($data['old_values']) && empty($data['new_values'])) {
            return [];
        }

        // Map IDs to names and rename keys
        $mappings = [
            'project_id' => [
                'new_key' => 'project_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $project = \App\Models\Project::find($id);
                    return $project ? $project->project_name : "Deleted Project (ID: {$id})";
                }
            ],
            'user_id' => [
                'new_key' => 'user_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $user = \App\Models\User::find($id);
                    return $user ? $user->name : "Deleted User (ID: {$id})";
                }
            ],
        ];

        foreach (['old_values', 'new_values'] as $valueKey) {
            if (isset($data[$valueKey])) {
                foreach ($mappings as $originalKey => $mapping) {
                    if (array_key_exists($originalKey, $data[$valueKey])) {
                        $id = $data[$valueKey][$originalKey];
                        $resolvedValue = $id ? $mapping['resolve']($id) : null;
                        
                        $data[$valueKey][$mapping['new_key']] = $resolvedValue;
                        unset($data[$valueKey][$originalKey]);
                    }
                }
            }
        }

        $project = $this->project;
        if ($project) {
            $data['source'] = json_encode(['Project' => $project->id]);
        }

        return $data;
    }

    public function discussions()
    {
        return $this->hasMany(PmSectionDiscussion::class, 'section_id', 'id');
    }

    public function myDiscussions()
    {
        // return $this->hasMany(PmSectionDiscussion::class, 'section_id', 'id')->where('assignee_id', auth()->user()->id);
        return $this->hasMany(PmSectionDiscussion::class, 'section_id', 'id')
        ->where(function ($q) {
            $q->where('assignee_id', auth()->id())
              ->orWhereHas('subDiscussions', function ($subQuery) {
                  $subQuery->where('assignee_id', auth()->id());
              });
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
