<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class PmSectionDiscussionComment extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use AuditableTrait;

    protected $fillable = [
        'section_id',
        'project_id',
        'section_discussion_id',
        'is_sub_discussion',
        'sub_section_discussion_id',
        'comment',
        'date',
        'is_liked',
        'mentioned_groups',
        'mentioned_users',
        'user_id',
        'edit_count',
        'is_pinned',    
        'pinned_at',  
        'pinned_by',
        'email_sent',
        'email_sent_at'
    ];

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
            'section_discussion_id' => [
                'new_key' => 'section_discussion_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $discussion = \App\Models\PmSectionDiscussion::find($id);
                    return $discussion ? $discussion->discussion_name : "Deleted Discussion (ID: {$id})";
                }
            ],
            'sub_section_discussion_id' => [
                'new_key' => 'sub_section_discussion_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $subDiscussion = \App\Models\PmSectionSubDiscussion::find($id);
                    return $subDiscussion ? $subDiscussion->discussion_name : "Deleted Sub-Discussion (ID: {$id})";
                }
            ],
            'mentioned_groups' => [
                'new_key' => 'mentioned_groups_names',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $ids = explode(',', $value);
                    $names = [];
                    foreach ($ids as $id) {
                        $group = \Spatie\Permission\Models\Role::find($id);
                        $names[] = $group ? $group->name : "Deleted Group (ID: {$id})";
                    }
                    return implode(', ', $names);
                }
            ],
            'mentioned_users' => [
                'new_key' => 'mentioned_users_names',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $ids = explode(',', $value);
                    $names = [];
                    foreach ($ids as $id) {
                        $user = \App\Models\User::find($id);
                        $names[] = $user ? $user->name : "Deleted User (ID: {$id})";
                    }
                    return implode(', ', $names);
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
            'pinned_by' => [
                'new_key' => 'pinned_by_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $user = \App\Models\User::find($id);
                    return $user ? $user->name : "Deleted User (ID: {$id})";
                }
            ],
        ];

        foreach (['old_values', 'new_values'] as $valueKey) {
            if (isset($auditData[$valueKey])) {
                foreach ($mappings as $originalKey => $mapping) {
                    if (array_key_exists($originalKey, $auditData[$valueKey])) {
                        $id = $auditData[$valueKey][$originalKey];
                        $resolvedValue = $id ? $mapping['resolve']($id) : null;
                        
                        $auditData[$valueKey][$mapping['new_key']] = $resolvedValue;
                        unset($auditData[$valueKey][$originalKey]);
                    }
                }
            }
        }

        $project = $this->projectDetail;
        $section = $this->sectionInfo;
        $discussion = $this->discussionInfo;
        $subDiscussion = $this->subDiscussionInfo;

        if ($subDiscussion) {
            $auditData['source'] = json_encode([
                'Project' => $project ? $project->id : null,
                'PmSection' => $section ? $section->id : null,
                'PmSectionDiscussion' => $discussion ? $discussion->id : null,
                'PmSectionSubDiscussion' => $subDiscussion ? $subDiscussion->id : null
            ]);
        } else {
            $auditData['source'] = json_encode([
                'Project' => $project ? $project->id : null,
                'PmSection' => $section ? $section->id : null,
                'PmSectionDiscussion' => $discussion ? $discussion->id : null
            ]);
        }

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

    public static function getReactionTypes()
    {
        return [
            'like' => [
                'icon' => 'fa-regular fa-thumbs-up',
                'icon_active' => 'fa-solid fa-thumbs-up',
                'label' => 'Like',
                'emoji' => '👍'
            ],
            'heart' => [
                'icon' => 'fa-regular fa-heart',
                'icon_active' => 'fa-solid fa-heart',
                'label' => 'Love',
                'emoji' => '❤️'
            ],
            'surprise' => [
                'icon' => 'fa-regular fa-face-surprise',
                'icon_active' => 'fa-solid fa-face-surprise',
                'label' => 'Surprise',
                'emoji' => '😲'
            ],
            'sad' => [
                'icon' => 'fa-regular fa-face-frown',
                'icon_active' => 'fa-solid fa-face-frown',
                'label' => 'Sad',
                'emoji' => '😢'
            ],
            'cry' => [
                'icon' => 'fa-regular fa-face-sad-cry',
                'icon_active' => 'fa-solid fa-face-sad-cry',
                'label' => 'Cry',
                'emoji' => '😭'
            ],
            'sweat' => [
                'icon' => 'fa-regular fa-face-grin-beam-sweat',
                'icon_active' => 'fa-solid fa-face-grin-beam-sweat',
                'label' => 'Sweat',
                'emoji' => '😅'
            ],
            'angry' => [
                'icon' => 'fa-regular fa-face-angry',
                'icon_active' => 'fa-solid fa-face-angry',
                'label' => 'Angry',
                'emoji' => '😠'
            ],
            'tongue' => [
                'icon' => 'fa-regular fa-face-grin-tongue-wink',
                'icon_active' => 'fa-solid fa-face-grin-tongue-wink',
                'label' => 'Silly',
                'emoji' => '😜'
            ],
            'tears' => [
                'icon' => 'fa-regular fa-face-grin-tears',
                'icon_active' => 'fa-solid fa-face-grin-tears',
                'label' => 'Hysterical',
                'emoji' => '😂'
            ],
        ];
    }

    /**
     * Get all reactions for this comment (using separate table)
     */
    public function reactions()
    {
        return $this->hasMany(CommentReaction::class, 'comment_id');
    }

    /**
     * Get reactions grouped by type with counts
     */
    public function getReactionsGroupedAttribute()
    {
        try {
            return $this->reactions()
                ->select('reaction_type', DB::raw('count(*) as count'))
                ->groupBy('reaction_type')
                ->pluck('count', 'reaction_type')
                ->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get total reactions count
     */
    public function getTotalReactionsCountAttribute()
    {
        try {
            return $this->reactions()->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get current user's reaction
     */
    public function getUserReactionAttribute()
    {
        if (!auth()->check()) {
            return null;
        }
        
        try {
            $reaction = $this->reactions()
                ->where('user_id', auth()->id())
                ->first();
                
            return $reaction ? $reaction->reaction_type : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    protected static function booted()
    {
        static::deleting(function ($comment) {
            try {
                // Delete reactions when comment is deleted
                $comment->reactions()->delete();
            } catch (\Exception $e) {
                // Table might not exist
            }
        });
    }

    public function getIsPinnedAttribute($value)
    {
        return (bool) $value;
    }

  
    public function pinnedByUser()
    {
        return $this->belongsTo(User::class, 'pinned_by');
    }

  
    public function scopeOrderByPinned($query)
    {
        return $query->orderBy('is_pinned', 'desc')
                     ->orderBy('pinned_at', 'desc')
                     ->orderBy('created_at', 'desc');
    }


    public function userInfo()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function projectDetail()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function sectionInfo()
    {
        return $this->belongsTo(PmSection::class, 'section_id');
    }

    public function discussionInfo()
    {
        return $this->belongsTo(PmSectionDiscussion::class, 'section_discussion_id');
    }

    public function subDiscussionInfo()
    {
        return $this->belongsTo(PmSectionSubDiscussion::class, 'sub_section_discussion_id');
    }
}
