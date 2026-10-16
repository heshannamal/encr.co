<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Contact extends Model implements Auditable
{
    use AuditableTrait;


    public function userDetails(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function getNameAttribute(): string
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }

    public function organizationDetails(){
        return $this->belongsTo('App\Models\Organization', 'organization_id');
    }
    public function leadSourceDetails(){
        return $this->belongsTo('App\Models\LeadSource', 'lead_source');
    }

    protected $fillable = [
        'first_name', 'last_name', 'lead_source', 'phone_no', 'personal_phone_no', 'email','email_two', 'title', 'user_id', 'receiver_name', 'shipping_po_box','apartment',
        'shipping_street', 'shipping_city', 'shipping_state', 'shipping_zip', 'shipping_country','receiver_name2','apartment2',
        'shipping_street_2', 'shipping_city_2', 'shipping_state_2', 'shipping_zip_2', 'shipping_country_2'
    ];

    public function contactOrganizations(){
        return $this->hasMany('App\Models\ContactOrganization', 'contact_id', 'id');
    }
}
