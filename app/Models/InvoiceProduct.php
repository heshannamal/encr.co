<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class InvoiceProduct extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'order_item_id',
        'product_id',
        'qty',
        'unit_price',
        'total_price',
    ];

    public function invoice()
    {
        return $this->belongsTo(FactoryInvoice::class, 'invoice_id');
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
            'invoice_id' => [
                'new_key' => 'invoice_number',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $invoice = FactoryInvoice::find($id);
                    return $invoice ? $invoice->invoice_number : "Deleted Invoice (ID: {$id})";
                }
            ],
            'product_id' => [
                'new_key' => 'product_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $product = Product::find($id);
                    return $product ? $product->product_name : "Deleted Product (ID: {$id})";
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

        $invoice = $this->invoice;
        if ($invoice) {
            $auditData['source'] = json_encode(['FactoryInvoice' => $invoice->id]);
        }

        return $auditData;
    }
}
