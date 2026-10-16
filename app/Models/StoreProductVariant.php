<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class StoreProductVariant extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    protected $fillable = ['variant_name', 'variant_value'];
}
