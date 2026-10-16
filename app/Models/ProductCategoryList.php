<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategoryList extends Model implements Auditable
{
    use AuditableTrait;
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'product_category_id',
    ];


    public function categories(){
        return $this->hasMany('App\Models\ProductCategory', 'id', 'product_category_id');
   }
}
