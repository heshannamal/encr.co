<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class DraftEmail extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    protected $table = 'draft_emails';



    protected $fillable = [
        'email_id',
        'draft_id',
        'type',
    ];
}
