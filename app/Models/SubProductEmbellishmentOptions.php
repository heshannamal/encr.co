<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class SubProductEmbellishmentOptions extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    protected $fillable = [
        'sub_product_id',
        'embellishment_option',
    ];
    public function EmbellishmentDetails()
    {
        return $this->belongsTo(EmbellishmentType::class, 'embellishment_option');
    }

    public function subProductDetail()
    {
        return $this->belongsTo(SubProduct::class, 'sub_product_id');
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
            'sub_product_id' => [
                'new_key' => 'sub_product_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $subProduct = \App\Models\SubProduct::find($value);
                    return $subProduct ? $subProduct->product_name : "Deleted Sub Product (ID: {$value})";
                }
            ],
            'embellishment_option' => [
                'new_key' => 'embellishment_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $embellishment = \App\Models\EmbellishmentType::find($value);
                    return $embellishment ? $embellishment->embellishment_name : "Deleted Embellishment (ID: {$value})";
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

        $auditData['source'] = json_encode(['Sub Product' => $this->sub_product_id]);

        return $auditData;
    }
}
