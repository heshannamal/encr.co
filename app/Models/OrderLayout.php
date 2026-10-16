<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class OrderLayout extends Model implements Auditable
{
    use AuditableTrait;

    protected $fillable = [
        'sub_total', 'sales_tax', 'shipping', 'artwork', 'processing_fee', 'created', 'updated', 'created_at', 'updated_at'
    ];
}
