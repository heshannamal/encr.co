<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shoot extends Model
{
    use HasFactory, SoftDeletes;
 
    protected $fillable = [
        'shoot_name',
        'shoot_date',
        'shoot_time',
        'note',
        'order_item_ids',
        'discussion_id',
    ];
 
    protected $casts = [
        'shoot_date' => 'date',
        'order_item_ids' => 'array',
    ];
 
    /** Which fashion model wears which items in this shoot */
    public function personItems()
    {
        return $this->hasMany(ShootPersonItem::class, 'shoot_id');
    }
}
