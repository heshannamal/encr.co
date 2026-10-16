<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class FabricLayout extends Model implements Auditable
{
    use AuditableTrait;

    protected $fillable = [
        'fabric_name', 'factory_code', 'created', 'updated'
    ];
}
