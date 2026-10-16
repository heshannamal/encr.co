<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PmInbox extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'section_id',
        'discussion_id',
        'is_sub_discussion',
        'sub_discussion_id',
        'is_comment',
        'comment_id',
        'user_id',
        'is_read',
        'assigned_by',
    ];

    public function projectDetail()
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

    public function comment()
    {
        return $this->belongsTo(PmSectionDiscussionComment::class, 'comment_id');
    }

    public function userData()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignedByUser()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
