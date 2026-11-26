<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FashionModelPhotoshootPhoto extends Model
{
    protected $table = 'fashion_model_photoshoot_photos';
 
    public const MAX_PHOTOS = 20;   
 
    protected $fillable = [
        'fashion_model_id',
        'image_path',
        'original_name',
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
