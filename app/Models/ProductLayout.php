<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class ProductLayout extends Model implements Auditable
{
    use AuditableTrait;

    protected $fillable = [
        'product_no', 'product_name', 'product_category_id', 'sport', 'gender', 'default_price', 'description', 'notes', 'created', 'updated',
    ];
}
