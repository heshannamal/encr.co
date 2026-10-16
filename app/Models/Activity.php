<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Activity extends Model implements Auditable
{
    use AuditableTrait;

    public function orderDetails(){
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function contactDetails(){
        return $this->belongsTo('App\Models\Contact', 'contact_id');
    }

    public function organizationDetails(){
        return $this->belongsTo('App\Models\Organization', 'organization_id');
    }

    public function assigneeDetails(){
        return $this->belongsTo('App\Models\User', 'assigned_to');
    }

    public function userDetails(){
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    public function assignees(){
        return $this->hasMany('App\Models\ActivityAssignee', 'activity_id', 'id')->where('active', 1);
    }
}
