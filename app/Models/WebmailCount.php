<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebmailCount extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;


    protected $fillable = [
                            'user_id',
                            'inbox_count',
                            'spam_count',
                            'draft_count',
                            ];
}
