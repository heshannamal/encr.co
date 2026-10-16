<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttribute extends Model implements Auditable
{
    use AuditableTrait;
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'attribute_id',
    ];

    public function attributes(){
        return $this->hasMany('App\Models\Attribute', 'id', 'attribute_id');
    }
}
