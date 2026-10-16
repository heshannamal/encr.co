<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class ProductCatalogTemporyUser extends Model implements Auditable
{
    use HasFactory, AuditableTrait;
    protected $table = 'product_catalog_tempory_users';
    protected $fillable = ['organization', 'address', 'email', 'phone_number', 'contact_person'];

    public $timestamps = true;
}
