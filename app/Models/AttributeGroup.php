<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeGroup extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

    public function groupAttributes()
    {
        return $this->hasMany(AttributeGroupAttribute::class, 'attribute_group_id', 'id');
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }
}
