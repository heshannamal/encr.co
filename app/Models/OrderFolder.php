<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class OrderFolder extends Model implements Auditable
{
    use AuditableTrait;

    public function getAuditEvents(): array
    {
        return ['created', 'updated', 'deleted'];
    }

    public function transformAudit(array $auditData): array
    {
        // Retrieve the parent OrderItem
        $order = $this->order;

        if ($order) {
            $auditData['source'] = json_encode(['Order'=>$order->id]);
        }

        return $auditData;
    }


    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
