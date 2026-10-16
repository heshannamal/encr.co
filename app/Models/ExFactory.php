<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class ExFactory extends Model implements Auditable
{
    use AuditableTrait;
    protected $fillable = [
        'apartment','order_item_id', 'ex_factory_name', 'po_box', 'city', 'state', 'postal_code', 'country', 'active', 'created_by'
    ];
}
