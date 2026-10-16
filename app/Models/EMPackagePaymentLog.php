<?php

namespace App\Models;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Model;

class EMPackagePaymentLog extends Model implements Auditable
{
    use AuditableTrait;
    protected $table = 'em_package_payment_logs';

    protected $fillable = [
        'package_order_id',
        'customer_id',

        'gateway',
        'environment',
        'payment_method',
        'status',

        'subtotal',
        'processing_fee',
        'tax',
        'amount',

        'response_code',
        'transaction_id',
        'auth_id',
        'message_code',
        'message_text',
        'ref_id',

        'name_on_card',
        'card_last_four',

        'billing_first_name',
        'billing_last_name',
        'billing_email',
        'billing_phone',
        'billing_street',
        'billing_city',
        'billing_state',
        'billing_zip',
        'billing_country',

        'quantity',
        'paid_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'processing_fee' => 'decimal:2',
        'tax' => 'decimal:2',
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(EMPackageOrder::class, 'package_order_id');
    }

    public function customer()
    {
        return $this->belongsTo(EMCustomer::class, 'customer_id');
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
            'package_order_id' => [
                'new_key' => 'package_order_no',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $order = EMPackageOrder::find($value);
                    return $order ? $order->order_no : "Deleted Order (ID: {$value})";
                }
            ],
            'customer_id' => [
                'new_key' => 'customer_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $customer = EMCustomer::find($value);
                    return $customer ? $customer->first_name.' '.$customer->last_name : "Deleted Customer (ID: {$value})";
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
