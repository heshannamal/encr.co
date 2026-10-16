<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItemSubAttribute extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    public function attribute(){
        return $this->hasOne('App\Models\Attribute', 'id', 'attribute_id');
    }
}
