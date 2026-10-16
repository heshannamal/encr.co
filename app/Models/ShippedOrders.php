<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShippedOrders extends Model implements Auditable
{
    use AuditableTrait;

    public function getAuditEvents(): array
    {
        return ['created', 'updated', 'deleted'];
    }

    public function transformAudit(array $data): array
    {
        // Retrieve the parent Order
        $order = $this->orderDetails;
        if ($order) {
            $data['source'] = json_encode(['Order'=>$order->id]);
        }

        return $data;
    }

    public function orderDetails(){
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function orderItemDetails(){
        return $this->belongsTo('App\Models\OrderItem', 'order_item_id');
    }

}
