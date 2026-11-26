<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShootPersonItem extends Model
{
   use HasFactory, SoftDeletes;

    protected $table = 'shoot_person_items';

    protected $fillable = [
        'shoot_id',
        'fashion_model_id',
        'order_item_ids',
    ];

    protected $casts = [
        'order_item_ids' => 'array',
    ];
}
