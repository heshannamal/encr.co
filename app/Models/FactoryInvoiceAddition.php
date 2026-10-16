<?php

namespace App\Models;

use App\Models\FactoryInvoice;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FactoryInvoiceAddition extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    public function invoice()
    {
        return $this->belongsTo(FactoryInvoice::class, 'invoice_id'); // Replace 'invoice_id' with the actual foreign key column name
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
            'addition_payment_id' => [
                'new_key' => 'addition_payment_number',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $additionPayment = AdditionPayment::find($id);
                    return $additionPayment ? $additionPayment->addition_type_name : "Deleted Addition Payment (ID: {$id})";
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

        $invoice = $this->invoice;
        if ($invoice) {
            $auditData['source'] = json_encode(['FactoryInvoice' => $invoice->id]);
        }

        return $auditData;
    }
}
