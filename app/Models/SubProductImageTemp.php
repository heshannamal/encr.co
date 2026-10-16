<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class SubProductImageTemp extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    protected $table = 'sub_product_image_temps';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'sub_product_no',
        'image_link',
        'image_name',
        'image_type',
        'active',
    ];

    public function subProductDetail()
    {
        return $this->hasOne(SubProduct::class, 'sub_product_no', 'sub_product_no');
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
            'image_type' => [
                'new_key' => 'image_type_status',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return match ((int)$value) {
                        1 => '3D Image',
                        2 => 'Lifestyle Image',
                        3 => 'Close Up Image',
                        4 => 'Branding Image',
                        5 => 'Studio Image',
                        default => null,
                    };
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

        $subProduct = $this->subProductDetail;
        if($subProduct){
            $auditData['source'] = json_encode(['Sub Product' => $this->subProduct->id]);
        }

        return $auditData;
    }
}
