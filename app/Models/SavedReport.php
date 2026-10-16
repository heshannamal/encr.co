<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class SavedReport extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditableTrait;

    // Specify the table if it doesn't match Laravel's default convention (singular form).
    protected $table = 'saved_reports';

    // Specify the fillable fields
    protected $fillable = [
        'name',
        'type',
        'start_date',
        'end_date',
        'rep_id',
        'processing_rep_id',
        'sport',
        'lead_type_id',
        'sale_type',
        'location',
        'product_id',
        'order_type',
        'active',
    ];

    // Specify the dates to handle timestamps and soft deletes
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Example relationships, if applicable:
    // public function rep()
    // {
    //     return $this->belongsTo(User::class, 'rep_id');
    // }

    // public function processingRep()
    // {
    //     return $this->belongsTo(User::class, 'processing_rep_id');
    // }

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
                    if (empty($value) || $value == 0) return null;
                    $product = \App\Models\Product::find($value);
                    return $product ? $product->product_name : "Deleted Product (ID: {$value})";
                }
            ],
            'rep_id' => [
                'new_key' => 'rep_name',
                'resolve' => function ($value) {
                    if (empty($value) || $value == 0) return null;
                    $user = \App\Models\User::find($value);
                    return $user ? $user->name : "Deleted Rep (ID: {$value})";
                }
            ],
            'processing_rep_id' => [
                'new_key' => 'processing_rep_name',
                'resolve' => function ($value) {
                    if (empty($value) || $value == 0) return null;
                    $user = \App\Models\User::find($value);
                    return $user ? $user->name : "Deleted Processing Rep (ID: {$value})";
                }
            ],
            'lead_type_id' => [
                'new_key' => 'lead_source_name',
                'resolve' => function ($value) {
                    if (empty($value) || $value == 0) return null;
                    $leadSource = \App\Models\LeadSource::find($value);
                    return $leadSource ? $leadSource->lead_source_name : "Deleted Lead Source (ID: {$value})";
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
                        $resolvedValue = ($value !== null && $value !== '') ? $mapping['resolve']($value, $valueKey) : null;
                        
                        $auditData[$valueKey][$mapping['new_key']] = $resolvedValue;
                        unset($auditData[$valueKey][$originalKey]);
                    }
                }
            }
        }

        return $auditData;
    }
}
