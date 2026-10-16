<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrganizationStoreProductSize extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    public function organizationStoreProductDetails(){
        return $this->belongsTo('App\Models\OrganizationStoreProduct', 'organization_store_product_id');
    }
    public function sizeDetails(){
        return $this->belongsTo('App\Models\Size', 'size_id');
    }
}
