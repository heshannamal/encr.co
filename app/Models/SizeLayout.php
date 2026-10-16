<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class SizeLayout extends Model implements Auditable
{
    use AuditableTrait;

    protected $fillable = [
        'size_name', 'size_type', 'created', 'updated'
    ];
}
