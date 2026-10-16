<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrganizationStoreProduct extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    public function getAuditEvents(): array
    {
        return ['created', 'updated', 'deleted'];
    }

    public function transformAudit(array $data): array
    {
        // Retrieve the parent organizationStoreDetails
        $organizationStoreDetails = $this->organizationStoreDetails;
        if ($organizationStoreDetails) {
            $data['source'] = json_encode(['OrganizationStores'=>$organizationStoreDetails->id]);
        }

        return $data;
    }

    public function organizationStoreDetails(){
        return $this->belongsTo('App\Models\OrganizationStores', 'organization_store_id');
    }

    public function productDetails(){
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

}
