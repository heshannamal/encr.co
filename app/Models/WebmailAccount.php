<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebmailAccount extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    public function userDetails(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
