<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductFactory extends Model implements Auditable
{
    use AuditableTrait;
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'product_factory_id',
    ];

    public function getAuditEvents(): array
    {
        return ['created', 'updated', 'deleted'];
    }

    // public function transformAudit(array $data): array
    // {
    //     // Retrieve the parent factories
    //     $factories = $this->factories;
    //     if ($factories) {
    //         $data['source'] = json_encode(['Factory'=>$factories->id]);
    //     }

    //     return $data;
    // }

    public function factory(){
        return $this->belongsTo(Factory::class, 'product_factory_id');
    }
    public function factories(){
        return $this->hasMany('App\Models\Factory', 'id', 'product_factory_id');
    }
}
