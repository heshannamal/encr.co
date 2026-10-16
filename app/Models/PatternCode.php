<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class PatternCode extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use AuditableTrait;

    public function subProduct()
    {
        return $this->belongsTo(SubProduct::class, 'sub_product_id', 'id');
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
                'new_key' => 'parent_product_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $parentProduct = \App\Models\Product::find($value);
                    return $parentProduct ? $parentProduct->product_name : "Deleted Product (ID: {$value})";
                }
            ],
            'sub_product_id' => [
                'new_key' => 'sub_product_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $subProduct = \App\Models\SubProduct::find($value);
                    return $subProduct ? $subProduct->product_name : "Deleted Sub Product (ID: {$value})";
                }
            ],
            'pattern_attribute' => [
                'new_key' => 'roles_names',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $ids = json_decode($value, true);
                    if (!is_array($ids)) $ids = [$ids];
                    $names = [];
                    foreach ($ids as $id) {
                        $group = \App\Models\Attribute::find($id);
                        $names[] = $group ? $group->attribute_name : "Deleted Attribute (ID: {$id})";
                    }
                    return implode(', ', $names);
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

        $auditData['source'] = json_encode([
            'Product' => $this->parent_product_id, 
            'Sub Product' => $this->sub_product_id
        ]);

        return $auditData;
    }
}
