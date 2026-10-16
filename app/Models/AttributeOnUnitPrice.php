<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class AttributeOnUnitPrice extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;
    
    public function AttributeDetails()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }

    public function subProductDetails()
    {
        return $this->belongsTo(SubProduct::class, 'sub_product_id');
    }

    public function attributeDetail()
    {
        return $this->belongsTo(Attribute::class, 'attribute__id');
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
            'attribute__id' => [
                'new_key' => 'attribute_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $attribute = \App\Models\Attribute::find($id);
                    return $attribute ? $attribute->attribute_name : "Deleted Attribute (ID: {$id})";
                }
            ],
            'sub_product_id' => [
                'new_key' => 'sub_product_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $subProduct = \App\Models\SubProduct::find($id);
                    return $subProduct ? $subProduct->product_name : "Deleted Sub Product (ID: {$id})";
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

        $subProductDetails = $this->subProductDetails;
        $attributeDetails = $this->attributeDetail;
        if ($subProductDetails) {
            $auditData['source'] = json_encode(['Sub Product' => $subProductDetails->id, 'Attribute' => $attributeDetails->id]);
        }

        return $auditData;
    }
}
