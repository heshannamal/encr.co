<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Support\Str;

class StoreCartItems extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    protected $table = 'store_cart_items';

    protected $appends = ['resolved_size_name'];

    public function setCustomNumberAttribute($value)
    {
        $value = is_string($value) ? trim($value) : $value;
        $this->attributes['custom_number'] = ($value === '' || $value === 'null') ? null : $value;
    }

    public function StoreCartItemsNameNumber()
    {
        return $this->hasMany(StoreCartItemNameNumber::class, 'id', 'store_cart_item_id');
    }

    // Original relation
    public function SizeDetails()
    {
        return $this->belongsTo(Size::class, 'size_id', 'id')->with('storeExtraSizeDetails');
    }

    // Optional: alias for convenience
    public function size()
    {
        return $this->SizeDetails();
    }

    // Accessor for resolved size
    public function getSizeDetailsAttribute()
    {
        // get the related Size model
        $size = $this->getRelationValue('SizeDetails') ?? $this->SizeDetails()->first();

        if ($size && Str::startsWith($size->size_name, 'Extra')) {
            $extra = $size->storeExtraSizeDetails;
            if ($extra && !empty($extra->size_name)) {
                $size->size_name = $extra->size_name;
            }
        }

        return $size;
    }

    // Resolved size name for convenience
    public function getResolvedSizeNameAttribute()
    {
        $size = $this->sizeDetails; // uses accessor above
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
            'store_product_id' => [
                'new_key' => 'product_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $product = \App\Models\Product::find($value);
                    return $product ? $product->product_name : "Deleted Product (ID: {$value})";
                }
            ],
            'store_id' => [
                'new_key' => 'store_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $store = \App\Models\Store::find($value);
                    return $store ? $store->store_name : "Deleted Store (ID: {$value})";
                }
            ],
            'size_id' => [
                'new_key' => 'size_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $size = \App\Models\Size::find($value);
                    return $size ? $size->size_name : "Deleted Size (ID: {$value})";
                }
            ],
            'type' => [
                'new_key' => 'type_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return match ((int)$value) {
                        1 => 'Single',
                        2 => 'Multiple',
                        default => null,
                    };
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
            'Store' => $this->store_id, 
            'Store Cart' => $this->store_cart_id, 
        ]);

        return $auditData;
    }
}
