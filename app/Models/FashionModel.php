<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FashionModel extends Model
{
    use HasFactory, SoftDeletes;
 
    protected $table = 'fashion_models';
 
    public const GENDERS = ['Female', 'Male'];
 
    public const MODEL_TYPES = ['Fit & Fashion', 'Commercial', 'Runway', 'Fitness', 'Plus Size', 'Parts'];
 
    
    public const MEASUREMENTS = [
        'height'             => 'Height',
        'waist'              => 'Waist',
        'bust'               => 'Bust',
        'chest'              => 'Chest',
        'hips'               => 'Hips',
        'neck_width'         => 'Neck Width',
        'thigh'              => 'Thigh',
        'leg_opening'        => 'Leg Opening',
        'across_shoulder'    => 'Across Shoulder',
        'sleeve_length'      => 'Sleeve Length',
        'cuff_opening'       => 'Cuff Opening',
        'head_circumference' => 'Head Circumference',
    ];
 
    protected $fillable = [
        'name',
        'profile_photo',
        'address',
        'country',
        'nationality',
        'phone_number',
        'email',
        'age',
        'date_of_birth',
        'gender',
        'us_size',
        'model_type',
        'experience',
        'experience_details',
 
        'height',
        'waist',
        'bust',
        'chest',
        'hips',
        'neck_width',
        'thigh',
        'leg_opening',
        'across_shoulder',
        'sleeve_length',
        'cuff_opening',
        'head_circumference',
 
        'measurements_updated_at',
    ];
 
    protected $casts = [
        'date_of_birth'            => 'date',
        'experience'               => 'boolean',
        'measurements_updated_at'  => 'datetime',
    ];
 
    protected static function booted()
    {
        static::saving(function (FashionModel $model) {
            // age always follows the date of birth
            if ($model->isDirty('date_of_birth')) {
                $model->age = $model->date_of_birth ? $model->date_of_birth->age : null;
            }
 
            // a measurement changed -> new "last updated" time
            if ($model->isDirty(array_keys(self::MEASUREMENTS))) {
                $model->measurements_updated_at = now();
            }
        });
    }
 
 
    // Front / Right / Left / Back images
    public function images()
    {
        return $this->hasMany(FashionModelImage::class, 'fashion_model_id');
    }
 
    // Previous photoshoot photos
    public function photoshootPhotos()
    {
        return $this->hasMany(FashionModelPhotoshootPhoto::class, 'fashion_model_id')->orderBy('id');
    }
 

    public function shootPersonItems()
    {
        return $this->hasMany(ShootPersonItem::class, 'fashion_model_id');
    }
 
    /* ---------------- Helpers ---------------- */
 
    // #002871
    public function getModelCodeAttribute(): string
    {
        return '#' . str_pad((string) $this->id, 6, '0', STR_PAD_LEFT);
    }
 
    public function getHeightLabelAttribute(): ?string
    {
        if ($this->height === null) {
            return null;
        }
        $feet   = (int) floor($this->height / 12);
        $inches = round($this->height - $feet * 12, 1);
 
        return $feet . "'" . (fmod($inches, 1) == 0 ? (int) $inches : $inches) . '"';
    }
 
    public function getProfilePhotoUrlAttribute(): ?string
    {
        return self::fileUrl($this->profile_photo);
    }
 
    
    public static function fileUrl(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }
 
        $path    = ltrim(str_replace('\\', '/', $path), '/');
        $encoded = implode('/', array_map('rawurlencode', explode('/', $path)));
 
        return url('public/storage/' . $encoded);
    }
 
    // ['front' => url|null, 'right' => url|null, 'left' => url|null, 'back' => url|null]
    public function sideImageUrls(): array
    {
        $urls = array_fill_keys(FashionModelImage::SIDES, null);
 
        foreach ($this->images as $image) {
            $urls[$image->side] = $image->url;
        }
 
        return $urls;
    }
}
