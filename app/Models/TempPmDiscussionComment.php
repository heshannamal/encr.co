<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TempPmDiscussionComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'project_id',
        'section_discussion_id',
        'is_sub_discussion',
        'sub_section_discussion_id',
        'comment',
        'date',
        'mentioned_groups',
        'mentioned_users',
        'user_id',
    ];

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
