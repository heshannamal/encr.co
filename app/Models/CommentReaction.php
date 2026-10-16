<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentReaction extends Model
{
    use HasFactory;

    protected $table = 'comment_reactions';

    protected $fillable = [
        'comment_id',
        'user_id',
        'reaction_type',
    ];

    /**
     * Get the comment that owns the reaction
     */
    public function comment()
    {
        return $this->belongsTo(PmSectionDiscussionComment::class, 'comment_id');
    }

    /**
     * Get the user who made the reaction
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
