<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Factory extends Model implements Auditable
{
    use AuditableTrait;

    public function bankDetails()
    {
        return $this->hasMany('App\Models\FactoryBankDetail', 'factory_id', 'id');
    }

    protected $fillable = ['factory_name', 'factory_code','permission_id'];
}
