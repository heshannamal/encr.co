<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kit_name',
        'order_item_ids',
    ];

    protected $casts = [
        'order_item_ids' => 'array',
    ];
}
