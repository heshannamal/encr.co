<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class ProductSize extends Model implements Auditable
{
    use AuditableTrait;

    public function getAuditEvents(): array
    {
        return ['created', 'updated', 'deleted'];
    }

    public function transformAudit(array $data): array
    {
        // Retrieve the parent factories
        $product = $this->product;
        if ($product) {
            $data['source'] = json_encode(['Product'=>$product->id]);
        }

        return $data;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
