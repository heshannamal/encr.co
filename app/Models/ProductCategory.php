<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class ProductCategory extends Model implements Auditable
{
    use AuditableTrait;

    public $timestamps = false;

    protected $fillable = ['product_category_name'];
}
