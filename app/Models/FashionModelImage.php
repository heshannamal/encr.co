<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FashionModelImage extends Model
{
    protected $table = 'fashion_model_images';
 
    public const SIDES = ['front', 'right', 'left', 'back'];
 
    protected $fillable = [
        'fashion_model_id',
        'side',
        'image_path',
    ];
 
    protected $appends = ['url'];
 
    public function fashionModel()
    {
        return $this->belongsTo(FashionModel::class, 'fashion_model_id');
    }
 
    public function getUrlAttribute(): string
    {
        return FashionModel::fileUrl($this->image_path);
    }
}
