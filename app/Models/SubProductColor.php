<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class SubProductColor extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    protected $fillable = [
        'sub_product_no',
        'color_master_id'
    ];
    public function subProduct()
    {
        return $this->belongsTo(SubProduct::class, 'sub_product_no', 'sub_product_no');
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
            'color_master_id' => [
                'new_key' => 'color_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $colorMaster = \App\Models\ColorMaster::find($value);
                    return $colorMaster ? $colorMaster->pantone_code . ' - ' . $colorMaster->hex : "Deleted Color (ID: {$value})";
                }
            ],
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

        $subProduct = $this->subProductDetail;
        if($subProduct){
            $auditData['source'] = json_encode(['Sub Product' => $this->subProduct->id]);
        }

        return $auditData;
    }
}
