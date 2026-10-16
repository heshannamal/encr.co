<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class StoreProduct extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;
    public function StoreCategoryDetails()
    {
        return $this->hasMany(ProductCategory::class, 'category_id', 'id');
    }
    public function IndividualNameDetails()
    {
        return $this->hasOne(StoreIndividualName::class, 'store_product_id', 'id');
    }
    public function IndividualNumberDetails()
    {
        return $this->hasOne(StoreIndividualNumber::class, 'store_product_id', 'id');
    }
    public function carts()
    {
        return $this->hasMany(StoreCart::class, 'store_product_id');
    }
    public function images()
    {
        return $this->hasMany(StoreProductImage::class, 'store_product_id')->where('active', 1)->orderByRaw("CASE WHEN order_index IS NULL THEN 1 ELSE 0 END, order_index ASC");
    }
    public function sizes()
    {
        return $this->hasMany(StoreProductSize::class, 'store_product_id')->with('size');
    }
    public function StoreProductAddedVariant()
    {
        return $this->hasMany(StoreProductAddedVariant::class, 'store_product_id')->with('variant');
    }
    public function StoreProductCategoryList()
    {
        return $this->hasMany(StoreProductCategoryList::class, 'product_id');
    }
    public function products()
    {
        return $this->hasOne(SubProduct::class, 'id', 'product_id')->with('productDetails');
    }
    public function priceAdditions()
    {
        return $this->hasMany(StoreProductPriceAddition::class, 'store_product_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
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
            'store_id' => [
                'new_key' => 'store_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $store = \App\Models\Store::find($id);
                    return $store ? $store->store_name : "Deleted Store (ID: {$id})";
                }
            ],
            'product_id' => [
                'new_key' => 'product_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $product = \App\Models\SubProduct::find($id);
                    return $product ? $product->product_name : "Deleted Product (ID: {$id})";
                }
            ],
            'size_type_id' => [
                'new_key' => 'size_type_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $sizeType = \App\Models\SizeType::find($value);
                    return $sizeType ? $sizeType->type_name : "Deleted Size Type (ID: {$value})";
                }
            ],
            'category_id' => [
                'new_key' => 'category_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $category = \App\Models\StoreProductCategory::find($value);
                    return $category ? $category->category_name : "Deleted Category (ID: {$value})";
                }
            ],
            'mandotary' => [
                'new_key' => 'mandotary_status',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Yes' : 'No';
                }
            ],
            'product_availability' => [
                'new_key' => 'product_availability_status',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Yes' : 'No';

                }
            ],
            'set_individual_name' => [
                'new_key' => 'set_individual_name_status',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Yes' : 'No';
                }
            ],
            'set_individual_number' => [
                'new_key' => 'set_individual_number_status',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Yes' : 'No';
                }
            ],
            'active' => [
                'new_key' => 'active_status',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Active' : 'Inactive';
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

        $store = $this->store;
        if ($store) {
            $auditData['source'] = json_encode(['Store' => $store->id]);
        }

        return $auditData;
    }
}
