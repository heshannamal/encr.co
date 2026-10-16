<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Notification extends Model implements Auditable
{
    use AuditableTrait;

    public function getAuditEvents(): array
    {
        return ['created', 'updated', 'deleted'];
    }

    protected $casts = [
        'changes' => 'array',
    ];

    public function transformAudit(array $data): array
    {
        // Retrieve the parent Order
        $order = $this->order;
        if ($order) {
            $data['source'] = json_encode(['Order'=>$order->id]);
        }

        return $data;
    }
   public function orderDetails(){
      return $this->belongsTo('App\Models\Order', 'order_id');
  }

  public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
