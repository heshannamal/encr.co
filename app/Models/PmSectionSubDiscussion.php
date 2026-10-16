<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class PmSectionSubDiscussion extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use AuditableTrait;

    protected $fillable = [
        'section_id',
        'project_id',
        'assignee_id',
        'assigned_by',
        'discussion_id',
        'discussion_name',
        'discussion_description',
        'due_date',
        'is_completed',
        'priority',
        'user_id',
        'sort_index',
        'email_sent',
        'email_sent_at'
    ];

    protected $appends = ['discussion_type'];

    public function getAuditEvents(): array
    {
        return ['created', 'updated', 'deleted'];
    }

    public function transformAudit(array $auditData): array
    {

        // Filter out changes where the old value is null and the new value is an empty string
        $auditData['old_values'] = array_filter($auditData['old_values'], function ($value, $key) use ($auditData) {
            return !($value === null && isset($auditData['new_values'][$key]) && $auditData['new_values'][$key] === '');
        }, ARRAY_FILTER_USE_BOTH);

        // Filter out the corresponding new values
        // $auditData['new_values'] = array_intersect_key($auditData['new_values'], $auditData['old_values']);

        // Skip the audit if no meaningful changes are left
        if (empty($auditData['old_values']) && empty($auditData['new_values'])) {
            return [];
        }

        // Map IDs to names and rename keys
        $mappings = [
            'section_id' => [
                'new_key' => 'section_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $section = \App\Models\PmSection::find($id);
                    return $section ? $section->section_name : "Deleted Section (ID: {$id})";
                }
            ],
            'project_id' => [
                'new_key' => 'project_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $project = \App\Models\Project::find($id);
                    return $project ? $project->project_name : "Deleted Project (ID: {$id})";
                }
            ],
            'assignee_id' => [
                'new_key' => 'assignee_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $user = \App\Models\User::find($id);
                    return $user ? $user->name : "Deleted User (ID: {$id})";
                }
            ],
            'assigned_by' => [
                'new_key' => 'assigned_by_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $user = \App\Models\User::find($id);
                    return $user ? $user->name : "Deleted User (ID: {$id})";
                }
            ],
            'discussion_id' => [
                'new_key' => 'discussion_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $discussion = \App\Models\PmSectionDiscussion::find($id);
                    return $discussion ? $discussion->discussion_name : "Deleted Discussion (ID: {$id})";
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
            'is_completed' => [
                'new_key' => 'is_completed_status',
                'resolve' => function ($value) {
                    return $value == 1 ? 'Completed' : 'Pending';
                }
            ],
        ];

        foreach (['old_values', 'new_values'] as $valueKey) {
            if (isset($auditData[$valueKey])) {
                foreach ($mappings as $originalKey => $mapping) {
                    if (array_key_exists($originalKey, $auditData[$valueKey])) {
                        $id = $auditData[$valueKey][$originalKey];
                        $resolvedValue = ($id !== null && $id !== '') ? $mapping['resolve']($id) : null;
                        
                        $auditData[$valueKey][$mapping['new_key']] = $resolvedValue;
                        unset($auditData[$valueKey][$originalKey]);
                    }
                }
            }
        }

        $project = $this->projectDetail;
        $section = $this->section;
        $discussion = $this->discussionDetail;

        // if ($orderItem) {
        //     $auditData['source'] = json_encode(['Order Item'=>$orderItem->id]);

        //     // Retrieve the parent Order from OrderItem
        //     $order = $orderItem->order;
            // if ($project) {
                $auditData['source'] = json_encode([
                    'Project' => $project ? $project->id : null,
                    'PmSection' => $section ? $section->id : null,
                    'PmSectionDiscussion' => $discussion ? $discussion->id : null
                ]);
            // }
        // }

        return $auditData;
    }

    /**
     * Determine if the audit data should be recorded.
     *
     * @param array $data
     * @return bool
     */
    public function shouldAudit(array $data): bool
    {
        return !empty($data);
    }

    public function getDiscussionTypeAttribute()
    {
        return 'sub_discussion';
    }

    public function comments()
    {
        return $this->hasMany(PmSectionDiscussionComment::class, 'sub_section_discussion_id', 'id');
    }

    public function assigneeUser()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function discussionDetail()
    {
        return $this->belongsTo(PmSectionDiscussion::class, 'discussion_id');
    }

    public function projectDetail()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function section()
    {
        return $this->belongsTo(PmSection::class, 'section_id');
    }

    public function lastAssign()
    {
        return $this->hasOne(PmTaskAssignee::class, 'sub_discussion_id', 'id')->orderByDesc('id');
    }

    public function assignedUser() {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
