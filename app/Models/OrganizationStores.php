<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrganizationStores extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    public function getAuditEvents(): array
    {
        return ['created', 'updated', 'deleted'];
    }

    public function transformAudit(array $data): array
    {
        // Retrieve the parent Organization
        $organizationDetails = $this->organizationDetails;
        if ($organizationDetails) {
            $data['source'] = json_encode(['Organization'=>$organizationDetails->id]);
        }

        return $data;
    }

    public function organizationDetails(){
        return $this->belongsTo('App\Models\Organization', 'organization_id');
    }
    protected $fillable = [
        'id','organization_id','store_name','cover_pic', 'profile_pic'

    ];

}
