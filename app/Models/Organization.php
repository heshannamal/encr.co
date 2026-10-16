<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Organization extends Model implements Auditable
{
    use AuditableTrait;

    public function userDetails(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function sportDetails(){
        return $this->belongsTo('App\Models\Sport', 'sport', 'sport_name');
    }

    protected $fillable = [
        'organization_name',
        'website',
        'email',
        'sport',
        'user_id',
        'assigned_to',
        'size_of_club',
        'colors',
        'organization_logo',

        'shipping_po_box',
        'shipping_street',
        'shipping_city',
        'shipping_state',
        'shipping_postal_code',
        'shipping_country',

        'same_as_shipping',
        'billing_po_box',
        'billing_street',
        'billing_city',
        'billing_state',
        'billing_postal_code',
        'billing_country',

        'sales_tax',
        'sales_tax_active',
        'lead_source',
        'received_sample',
        'ordering_timeline',
        'pl_status',
        'active',
        'unique_password',
        'password_text',
        'organization_note',
    ];

    public function contactOrganizations(){
        return $this->hasMany('App\Models\ContactOrganization', 'organization_id', 'id')->with('contacts');
    }
    public function orders(){
        return $this->hasMany('App\Models\Order', 'organization_id', 'id');
    }
    public function receivedSamplesOrganizations(){
        return $this->hasMany('App\Models\OrganizationReceivedSample', 'organization_id', 'id');
    }
    public function activities()
    {
        return $this->hasMany(Activity::class, 'organization_id', 'id');
    }
    public function leadSourceDetails()
    {
        return $this->belongsTo(LeadSource::class, 'lead_source', 'id');
    }
}
