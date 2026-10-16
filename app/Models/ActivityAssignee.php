<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class ActivityAssignee extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    public function userDetail(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
