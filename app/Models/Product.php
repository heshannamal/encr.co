<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Product extends Model implements Auditable
{
    use AuditableTrait;

    protected $fillable = [
        'product_name', 'product_no',
        'product_no', 'product_no',
        'pattern_code', 'product_category_id',
        'sport', 'gender',
        'default_price', 'size_id',
        'standard_fabric', 'fabric_options',
        'attributes', 'type_of_embellishment',
        'factory', 'description',
        'notes', 'fabric_id',
        'weight', 'mockup_img',
        'mockup_img_1', 'mockup_img_2',
        'mockup_img_3', 'product_reference_link',
        '2D_mockup', '3D_mockup',
        'tech_pack', 'measurement',
        'product_layout', 'pattern',
        'active','technical_tech_pack',
    ];

     public function productSizes(){
          return $this->hasMany('App\Models\ProductSize', 'product_id', 'id');
     }

     public function productFabrics(){
        return $this->hasMany('App\Models\ProductFabric', 'product_id', 'id');
     }

     public function productFabric(){
         return $this->hasOne('App\Models\Fabric', 'id', 'fabric_id');
     }

     public function productEmbellishmentTypes(){
        return $this->hasMany('App\Models\ProductEmbellishmentType', 'product_id', 'id');
     }

     public function productCategories(){
          return $this->hasMany('App\Models\ProductCategoryList', 'product_id', 'id');
     }

     public function productsport(){
          return $this->hasMany('App\Models\ProductSport', 'product_id', 'id');
     }

     public function productAttributes(){
          return $this->hasMany('App\Models\ProductAttribute', 'product_id', 'id');
     }

     public function productFactories(){
          return $this->hasMany('App\Models\ProductFactory', 'product_id', 'id');
     }
     public function productMainCategories()
    {
        return $this->hasMany(ProductMainCategory::class, 'product_id');
    }
    public function stores()
    {
        return $this->belongsToMany(Store::class, 'store_products', 'product_id', 'store_id');
    }
    public function storeProducts()
    {
        return $this->hasMany(StoreProduct::class, 'product_id');
    }

    public function productManufacturePrice()
    {
        return $this->hasOne(Price::class, 'product_id')->where('price_type', 5)->where('active', 1);
    }
}
