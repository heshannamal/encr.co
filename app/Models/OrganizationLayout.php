<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class OrganizationLayout extends Model implements Auditable
{
    use AuditableTrait;

    protected $fillable = [
        'user_id', 'organization_name', 'website', 'email', 'sport', 'user', 'size_of_club', 'colors', 'organization_logo', 'shipping_po_box', 'shipping_city',
        'shipping_state', 'shipping_postal_code', 'shipping_country', 'sales_tax', 'sales_tax_active', 'created', 'updated', 'created_at', 'updated_at'
    ];
}
