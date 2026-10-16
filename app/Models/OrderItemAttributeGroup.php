<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class OrderItemAttributeGroup extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    public function attributeGroup(){
        return $this->hasOne('App\Models\AttributeGroup', 'id', 'attribute_group_id');
    }
}
