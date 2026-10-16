<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class SubProduct extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    protected $table = 'sub_products';

    public function fabric()
    {
        return $this->belongsTo(Fabric::class, 'fabric_id');
    }
    public function productDetails()
    {
        return $this->belongsTo(Product::class, 'parent_product_id', 'id')
                    ->with([
                        'productSizes',
                        'productFabrics',
                        'productFabric',
                        'productEmbellishmentTypes',
                        'productCategories.categories',
                        'productsport.sport',
                        'productAttributes',
                        'productFactories',
                        'productMainCategories.main_category'
                    ]);
    }

    public function embellishmentTypes()
    {
        return $this->hasMany(SubProductEmbellishmentOptions::class, 'sub_product_id', 'id')->with('EmbellishmentDetails');
    }
    public function prices()
    {
        return $this->hasMany(SubProductPrice::class, 'sub_product_no', 'sub_product_no')->where('active', 1);
    }

    public function manufacturePriceDetails()
    {
        return $this->hasOne(SubProductPrice::class, 'sub_product_no', 'sub_product_no')
                        ->where('active', 1)
                        ->where('price_type', 5);
    }

    public function attributeOnUnitPrice()
    {
        return $this->hasMany(AttributeOnUnitPrice::class, 'sub_product_id', 'id')->with('AttributeDetails');
    }

    public function transformAudit(array $auditData): array
    {
        $auditData['old_values'] = array_filter($auditData['old_values'], function ($value, $key) use ($auditData) {
            return !($value === null && isset($auditData['new_values'][$key]) && $auditData['new_values'][$key] === '');
        }, ARRAY_FILTER_USE_BOTH);

        if (empty($auditData['old_values']) && empty($auditData['new_values'])) {
            return [];
        }

        $mappings = [
            'parent_product_id' => [
                'new_key' => 'product_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $product = \App\Models\Product::find($value);
                    return $product ? $product->product_name : "Deleted Product (ID: {$value})";
                }
            ],
            'type_of_embellishment_ids' => [
                'new_key' => 'type_of_embellishment_names',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $embellishment = \App\Models\EmbellishmentType::find($value);
                    return $embellishment ? $embellishment->embellishment_name : "Deleted Type of Embellishment (ID: {$value})";
                }
            ],
            'fabric_id' => [
                'new_key' => 'fabric_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $fabric = \App\Models\Fabric::find($value);
                    return $fabric ? $fabric->fabric_name : "Deleted Fabric (ID: {$value})";
                }
            ],
            'active' => [
                'new_key' => 'active_status',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Active' : 'Inactive';
                }
            ],
            'show_in_catalog' => [
                'new_key' => 'show_in_catalog_status',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Yes' : 'No';
                }
            ]
        ];

        foreach (['old_values', 'new_values'] as $valueKey) {
            if (isset($auditData[$valueKey])) {
                foreach ($mappings as $originalKey => $mapping) {
                    if (array_key_exists($originalKey, $auditData[$valueKey])) {
                        $value = $auditData[$valueKey][$originalKey];
                        $resolvedValue = ($value !== null && $value !== '') ? $mapping['resolve']($value) : null;
                        
                        $auditData[$valueKey][$mapping['new_key']] = $resolvedValue;
                        unset($auditData[$valueKey][$originalKey]);
                    }
                }
            }
        }

        $auditData['source'] = json_encode([
            'Product' => $this->parent_product_id, 
        ]);

        return $auditData;
    }
}
