<?php

namespace App\Models;

use App\Models\FactoryInvoiceAddition;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FactoryInvoice extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $table = 'factory_invoices';

    protected $fillable = ['invoice_number', 'order_id', 'total_amount'];

    public function additions()
    {
        return $this->hasMany(FactoryInvoiceAddition::class, 'invoice_id');
    }
    public function invoiceProduct()
    {
        return $this->hasMany(InvoiceProduct::class, 'invoice_id');
    }
    public function orderDetails()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id')->with('organizationDetails');
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
            'order_id' => [
                'new_key' => 'order_number',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $store = \App\Models\Order::find($id);
                    return $store ? $store->order_no : "Deleted Order (ID: {$id})";
                }
            ],
            'status' => [
                'new_key' => 'status',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return match ((int)$value) {
                        0 => 'Pending',
                        1 => 'Paid',
                        2 => 'Partial',
                        3 => 'Partial',
                        default => 'Pending',
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

        $order = $this->orderDetails;
        if ($order) {
            $auditData['source'] = json_encode(['Order' => $order->id]);
        }

        return $auditData;
    }
}
