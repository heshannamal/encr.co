<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class SubProductTemp extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use AuditableTrait;
    
    protected $table = 'sub_products_temp';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'product_id',
        'sub_product_id',
        'product_no',
        'product_name',
        'show_in_catalog_name',
        'main_category_id',
        'pattern_code',
        'product_category_id',
        'gender',
        'MOQ',
        'default_price',
        'standard_fabric',
        'fabric_options',
        'attributes',
        'type_of_embellishment',
        'description',
        'who_we_made_this_for',
        'product_features',
        'notes',
        'fabric_id',
        'weight',
        'mockup_img',
        'mockup_img_1',
        'mockup_img_2',
        'mockup_img_3',
        'mockup_caption_1',
        'mockup_caption_2',
        'mockup_caption_3',
        'product_reference_link',
        'pattern',
        'technical_tech_pack',
        'active',
        'show_in_catalog',
        'fits_true_to_size',
        'attribute_on_price',
        'size_id',
        'size_ids',
        'fabric_ids',
        'sport_ids',
        'product_category_list_ids',
        'product_attribute_ids',
        'product_factory_ids',
        'product_tagline_ids',
        'product_fit_ids',
        'embellishment_options',
        'colorIds',
        'transferred',
        'transferred_id',
        'deleted_at'
    ];

    protected $casts = [
        'product_category_id'=> 'array',
        'attribute_on_price' => 'array',
        'main_category_id' => 'array',
        'size_ids' => 'array',
        'fabric_ids' => 'array',
        'sport_ids' => 'array',
        'product_category_list_ids' => 'array',
        'product_attribute_ids' => 'array',
        'product_factory_ids' => 'array',
        'product_tagline_ids' => 'array',
        'product_fit_ids' => 'array',
        'embellishment_options' => 'array',
        'colorIds' => 'array',
    ];

    // public function subProductTemp()
    // {
    //     return $this->belongsTo(SubProductTemp::class, 'product_id');
    // }

    public function transformAudit(array $auditData): array
    {
        $auditData['old_values'] = array_filter($auditData['old_values'], function ($value, $key) use ($auditData) {
            return !($value === null && isset($auditData['new_values'][$key]) && $auditData['new_values'][$key] === '');
        }, ARRAY_FILTER_USE_BOTH);

        if (empty($auditData['old_values']) && empty($auditData['new_values'])) {
            return [];
        }

        $mappings = [
            'product_id' => [
                'new_key' => 'product_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $product = \App\Models\Product::find($value);
                    return $product ? $product->product_name : "Deleted Product (ID: {$value})";
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
            'Product' => $this->product_id, 
        ]);

        return $auditData;
    }
}
