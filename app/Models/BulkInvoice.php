<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class BulkInvoice extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;
    public function organizationDetails(){
        return $this->belongsTo('App\Models\Organization', 'organization_id');
    }
}
