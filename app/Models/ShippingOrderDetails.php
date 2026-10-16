<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class ShippingOrderDetails extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    protected $fillable = [
        'shipping_information_id',
        'order_id',
        'order_item_id',
        'order_item_detail_id',
        'size_id',
        'size_name',
        'has_blank_qty',
        'has_blank_name',
        'order_qty',
        'shipped_qty',
        'back_ordered_qty',
        'is_back_ordered',
        'initail_order_qty',
        'player_name',
        'player_number',
        'seq_name',
        'seq_number',
        'est_delivery_date',
        'tracking_no',
        'CourierService',
        'tracking_link',
        'notify_status',
        'notified_by',
        'is_saved'
    ];

    public function getAuditEvents(): array
    {
        return ['updated', 'deleted'];
    }

    public function transformAudit(array $auditData): array
    {
        // Retrieve the parent OrderItem
        $orderItem = $this->orderItems;

        if ($orderItem) {
            $auditData['source'] = json_encode(['Order Item'=>$orderItem->id]);

            // Retrieve the parent Order from OrderItem
            $order = $orderItem->order;
            if ($order) {
                $auditData['source'] = json_encode(['Order'=>$order->id, 'Order Item'=>$orderItem->id]);
            }
        }

        return $auditData;
    }

    public function orderItems()
    {
        return $this->belongsTo('App\Models\OrderItem', 'order_item_id');
    }

    public function notifiedUser()
    {
        return $this->belongsTo('App\Models\User', 'notified_by');
    }

    public function orderItemDetailQtys(){
        return $this->belongsTo('App\Models\OrderItemsDetail', 'order_item_detail_id');
    }
}
