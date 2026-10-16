<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class UserGroupLayout extends Model implements Auditable
{
    use AuditableTrait;

    protected $fillable = [
        'user_group_name', 'narration', 'created', 'updated'
    ];
}
