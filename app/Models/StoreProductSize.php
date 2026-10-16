<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Support\Str;

class StoreProductSize extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;
    public function product()
    {
        return $this->belongsTo(StoreProduct::class, 'store_product_id');
    }
    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id')->with('storeExtraSizeDetails');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function getSizeAttribute($value)
    {
        $size = $this->getRelationValue('size') ?? $this->size()->first();

        if ($size && Str::startsWith($size->size_name, 'Extra')) {
            $extra = $size->storeExtraSizeDetails;
            if ($extra && !empty($extra->size_name)) {
                $size->size_name = $extra->size_name;
            }
        }

        return $size;
    }

    protected $appends = ['resolved_size_name'];

    public function getResolvedSizeNameAttribute()
    {
        $size = $this->size;
        return $size ? $size->size_name : null;
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
                    $store = Store::find($id);
                    return $store ? $store->store_name : "Deleted Store (ID: {$id})";
                }
            ],
            'store_product_id' => [
                'new_key' => 'store_product_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $product = StoreProduct::find($id);
                    return $product ? $product->product_name : "Deleted Product (ID: {$id})";
                }
            ],
            'size_id' => [
                'new_key' => 'size_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $size = \App\Models\Size::find($id);
                    if ($size && Str::startsWith($size->size_name, 'Extra')) {
                        $extra = $size->storeExtraSizeDetails;
                        if ($extra && !empty($extra->size_name)) {
                            return $extra->size_name;
                        }
                    }
                    return $size ? $size->size_name : "Deleted Size (ID: {$id})";
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

        $store = $this->store;
        $storeProduct = $this->product;
        if ($store) {
            $auditData['source'] = json_encode(['Store' => $store->id, 'Store Product' => $storeProduct->id]);
        }

        return $auditData;
    }
}
