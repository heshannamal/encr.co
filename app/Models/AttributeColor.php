<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class AttributeColor extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    public function attributeDetails() {
        return $this->belongsTo(Attribute::class, 'attribute_id');
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
            'attribute_id' => [
                'new_key' => 'attribute_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $attribute = \App\Models\Attribute::find($id);
                    return $attribute ? $attribute->attribute_name : "Deleted Attribute (ID: {$id})";
                }
            ],
            'color_master_id' => [
                'new_key' => 'color_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $color = \App\Models\ColorMaster::find($id);
                    return $color ? $color->pantone_code . ' - ' . $color->hex : "Deleted Color (ID: {$id})";
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

        $attributeDetails = $this->attributeDetails;
        if ($attributeDetails) {
            $auditData['source'] = json_encode(['Attribute' => $attributeDetails->id]);
        }

        return $auditData;
    }
}
