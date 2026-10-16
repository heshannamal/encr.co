<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class OrganizationSampleShipment extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    protected $fillable = [
        'organization_id',
        'status',
        'received_date',
        'delivered_date',
        'products',
        'fabric_swatches',
        'note',
        'contact_id',
        'shipping_street',
        'shipping_city',
        'shipping_state',
        'shipping_postal_code',
        'shipping_country',
        'tracking_link',
        'tracking_number',
        'created_by',
        'confirmed_by',
    ];

    protected $casts = [
        'received_date' => 'date',
        'delivered_date' => 'date',
        'products' => 'array',
        'fabric_swatches' => 'array',
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
            'organization_id' => [
                'new_key' => 'organization_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $org = \App\Models\Organization::find($id);
                    return $org ? $org->organization_name : "Deleted Organization (ID: {$id})";
                }
            ],
            'contact_id' => [
                'new_key' => 'contact_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $contact = \App\Models\Contact::find($id);
                    return $contact ? $contact->first_name.' '.$contact->last_name : "Deleted Contact (ID: {$id})";
                }
            ],
            'created_by' => [
                'new_key' => 'requested_by_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $user = \App\Models\User::find($value);
                    return $user ? $user->name : "Deleted User (ID: {$value})";
                }
            ],
            'confirmed_by' => [
                'new_key' => 'confirmed_by_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $user = \App\Models\User::find($value);
                    return $user ? $user->name : "Deleted User (ID: {$value})";
                }
            ],
            'received_date' => [
                'new_key' => 'requested_date',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return \Carbon\Carbon::parse($value)->format('m/d/Y');
                }
            ],
            'delivered_date' => [
                'new_key' => 'est._delivered_date',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return \Carbon\Carbon::parse($value)->format('m/d/Y');
                }
            ],
            'fabric_swatches' => [
                'new_key' => 'fabric_swatches_names',
                'resolve' => function ($value) {
                    if (empty($value)) return null;

                    if ($value instanceof \Illuminate\Support\Collection) {
                        $ids = $value->toArray();
                    } elseif (is_array($value)) {
                        $ids = $value;
                    } elseif (is_string($value)) {
                        $decoded = json_decode($value, true);
                        $ids = is_array($decoded) ? $decoded : explode(',', $value);
                    } else {
                        $ids = [$value];
                    }

                    $names = [];
                    foreach ($ids as $id) {
                        if (is_array($id)) continue;
                        $id = trim((string) $id);
                        if ($id === '') continue;

                        $fabric = \App\Models\Fabric::find($id);
                        $names[] = $fabric ? $fabric->fabric_name : "Deleted Fabric (ID: {$id})";
                    }

                    return !empty($names) ? implode(', ', $names) : null;
                }
            ],
            'products' => [
                'new_key' => 'products_and_sizes',
                'resolve' => function ($value) {
                    if (empty($value)) return null;

                    if ($value instanceof \Illuminate\Support\Collection) {
                        $items = $value->toArray();
                    } elseif (is_array($value)) {
                        $items = $value;
                    } elseif (is_string($value)) {
                        $decoded = json_decode($value, true);
                        $items = is_array($decoded) ? $decoded : [];
                    } else {
                        $items = [];
                    }

                    $names = [];
                    foreach ($items as $item) {
                        if (is_string($item)) {
                            $decodedItem = json_decode($item, true);
                            if (is_array($decodedItem)) {
                                $item = $decodedItem;
                            }
                        }

                        if (is_object($item)) {
                            $item = (array) $item;
                        }

                        if (!is_array($item)) {
                            continue;
                        }

                        $productId = $item['product_id'] ?? null;
                        $sizeId = $item['size_id'] ?? null;

                        if (empty($productId) && empty($sizeId)) {
                            continue;
                        }

                        $productName = null;
                        if (!empty($productId)) {
                            $product = \App\Models\SubProduct::find($productId) ?: \App\Models\Product::find($productId);
                            $productName = $product ? $product->product_name : "Deleted Product (ID: {$productId})";
                        }

                        $sizeName = null;
                        if (!empty($sizeId)) {
                            $size = \App\Models\Size::find($sizeId);
                            $sizeName = $size ? $size->size_name : "Deleted Size (ID: {$sizeId})";
                        }

                        if ($productName && $sizeName) {
                            $names[] = "{$productName} - {$sizeName}";
                        } elseif ($productName) {
                            $names[] = $productName;
                        } elseif ($sizeName) {
                            $names[] = $sizeName;
                        }
                    }

                    return !empty($names) ? implode(', ', $names) : null;
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

        $auditData['source'] = json_encode(['Organization' => $this->organization_id]);

        return $auditData;
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function confirmedUser()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }
}
