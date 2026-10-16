<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class PeopleLayout extends Model implements Auditable
{
    use AuditableTrait;

    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'organization_id', 'lead_source', 'phone_no', 'email', 'title', 'user', 'shipping_po_box', 'shipping_street',
        'shipping_city', 'shipping_state', 'shipping_zip', 'shipping_country', 'created', 'updated', 'created_at',  'updated_at'
    ];
}
