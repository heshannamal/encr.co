<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class InventoryAddedOrder extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $fillable = [
        'order_id',
        'inventory_type_id',
        'status',
        'sent_by',
        'responded_by',
        'inventory_id',
    ];

    public function sentBy()
    {
        return $this->belongsTo('App\Models\User', 'sent_by', 'id');
    }
}
