<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class PurchaseorderReceipt extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    protected $table = 'purchaseorder_receipts';

    protected $fillable = [
        'order_id',
        'receipt',
        'is_approved',
        'reject_reason',
    ];

    public $timestamps = true;

    protected $casts = [
        'is_approved' => 'integer',
    ];

    public function getAuditEvents(): array
    {
        return ['created', 'updated', 'deleted'];
    }

    public function transformAudit(array $data): array
    {
        // Retrieve the parent Order
        $order = $this->order;
        if ($order) {
            $data['source'] = json_encode(['Order'=>$order->id]);
        }

        return $data;
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
