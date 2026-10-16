<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductEmbellishmentType extends Model implements Auditable
{
    use AuditableTrait;
    use SoftDeletes;

    protected $table = 'product_embellishment_types';

    public function embellishmentTypes(){
        return $this->hasMany('App\Models\EmbellishmentType', 'id', 'embellishment_type_id');
    }
}
