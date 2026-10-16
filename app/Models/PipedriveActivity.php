<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class PipedriveActivity extends Model implements Auditable
{
    use AuditableTrait;

    public function pDODetails(){
        return $this->hasOne('App\Models\PipedriveOrganization', 'organization_name' ,'organization_name');
    }

    public function pDCDetails(){
        return $this->hasOne('App\Models\PipedriveContact', 'contact_name' ,'contact_name');
    }
}
