<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItemFile extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    public function getAuditEvents(): array
    {
        return ['created', 'updated', 'deleted'];
    }

    public function transformAudit(array $auditData): array
    {
        // Retrieve the parent OrderItem
        $orderItem = $this->orderItem;

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


    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}
