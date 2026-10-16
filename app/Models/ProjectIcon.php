<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class ProjectIcon extends Model  implements Auditable
{
    use AuditableTrait;
    use SoftDeletes;

    protected $fillable = ['icon'];
}
