<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactOrganization extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

    public function organizations(){
        return $this->hasMany('App\Models\Organization', 'id', 'organization_id');
    }

    public function contacts(){
        return $this->hasMany('App\Models\Contact','id','contact_id');
    }
}
