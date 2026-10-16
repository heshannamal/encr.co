<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class remake_order_item extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $fillable = [
        'order_id','shipping_order_details_id', 'order_item_id', 'size_id', 'player_name', 'player_nunmber', 'est_delivery_date', 'qty', 'status', 'reason', 'user_id'
    ];

    public function orderItem()
    {

        return $this->belongsTo('App\Models\OrderItem', 'order_item_id');
    }
}

