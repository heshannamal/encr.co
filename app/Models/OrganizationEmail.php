<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrganizationEmail extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    public function getAuditEvents(): array
    {
        return ['created', 'updated', 'deleted'];
    }

    public function transformAudit(array $data): array
    {
        // Retrieve the parent organizationDetail
        $organizationDetail = $this->organizationDetail;
        if ($organizationDetail) {
            $data['source'] = json_encode(['Organization'=>$organizationDetail->id]);
        }

        return $data;
    }

    public function organizationDetail(){
        return $this->belongsTo('App\Models\Organization', 'organization_id');
    }
}
