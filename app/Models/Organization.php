<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Organization extends Model implements Auditable
{
    use AuditableTrait;

    private $californiaTaxResolved = false;

    public function usesCaliforniaSalesTax(): bool
    {
        return in_array(strtoupper(trim((string) $this->shipping_state)), ['CA', 'CALIFORNIA'], true)
            && in_array(strtoupper(trim((string) $this->shipping_country)),
                ['', 'US', 'USA', 'UNITED STATES', 'UNITED STATES OF AMERICA'], true);
    }

    public function refreshCaliforniaSalesTax(): void
    {
        if (!$this->usesCaliforniaSalesTax()) {
            return;
        }

        $this->applyCaliforniaSalesTax();
        $this->californiaTaxResolved = true;
        try {
            $this->save();
        } finally {
            $this->californiaTaxResolved = false;
        }
    }

    private function applyCaliforniaSalesTax(): void
    {
        $details = app(\App\Services\CaliforniaSalesTax::class)->detailsFor($this);
        $rate = $details['rate'];
        $previousRate = $this->getOriginal('sales_tax');
        if (!$this->cdtfa_updated_at || $previousRate === null || (float) $previousRate !== $rate) {
            $this->cdtfa_previous_rate = $previousRate;
            $this->cdtfa_updated_rate = $rate;
            $this->cdtfa_updated_at = now();
        }
        $this->sales_tax = $rate;
        $this->sales_tax_active = 1;
        $this->shipping_county = $details['county'];
        $this->shipping_county_checked_at = $details['county'] ? now() : null;
    }

    protected static function booted()
    {
        static::saving(function ($organization) {
            if ($organization->isDirty(['shipping_street', 'shipping_city', 'shipping_state', 'shipping_postal_code', 'shipping_country'])
                && !$organization->isDirty('shipping_county') && !$organization->californiaTaxResolved) {
                $organization->shipping_county = null;
                $organization->shipping_county_checked_at = null;
            }
            if ($organization->usesCaliforniaSalesTax() && !$organization->californiaTaxResolved) {
                if (!$organization->exists || $organization->isDirty([
                    'shipping_street', 'shipping_city', 'shipping_state', 'shipping_postal_code', 'shipping_country',
                ]) || (trim((string) $organization->shipping_county) === '' && $organization->hasShippingAddress())) {
                    $organization->applyCaliforniaSalesTax();
                } else {
                    $organization->sales_tax = $organization->getOriginal('sales_tax');
                }
                $organization->sales_tax_active = 1;
            }
        });
    }

    public function hasShippingAddress(): bool
    {
        foreach (['shipping_street', 'shipping_city', 'shipping_state', 'shipping_postal_code', 'shipping_country'] as $field) {
            if (trim((string) $this->{$field}) === '') {
                return false;
            }
        }

        return true;
    }

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
