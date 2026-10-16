<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class ProductTaglineList extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    protected $fillable = [
        'product_id',
        'tagline_id',
    ];

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
            'tagline_id' => [
                'new_key' => 'tagline_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $tagline = \App\Models\ProductTagline::find($value);
                    return $tagline ? $tagline->tagline_name : "Deleted Tagline (ID: {$value})";
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
