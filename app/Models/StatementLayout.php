<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class StatementLayout extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    protected $fillable = [
        'user_id', 'date', 'order_no', 'payment_type', 'transaction_type',
        'note', 'amount', 'payment', 'paid_processing_fee',
        'total_paid_amount', 'debit_entry', 'balance',
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
            'user_id' => [
                'new_key' => 'user_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $user = \App\Models\User::find($value);
                    return $user ? $user->name : "Deleted User (ID: {$value})";
                }
            ],
            'date' => [
                'new_key' => 'display_date',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Displayed' : 'Hidden';
                }
            ],
            'order_no' => [
                'new_key' => 'display_order_no',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Displayed' : 'Hidden';
                }
            ],
            'payment_type' => [
                'new_key' => 'display_payment_type',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Displayed' : 'Hidden';
                }
            ],
            'transaction_type' => [
                'new_key' => 'display_transaction_type',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Displayed' : 'Hidden';
                }
            ],
            'note' => [
                'new_key' => 'display_note',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Displayed' : 'Hidden';
                }
            ],
            'amount' => [
                'new_key' => 'display_amount',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Displayed' : 'Hidden';
                }
            ],
            'payment' => [
                'new_key' => 'display_payment',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Displayed' : 'Hidden';
                }
            ],
            'paid_processing_fee' => [
                'new_key' => 'display_paid_processing_fee',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Displayed' : 'Hidden';
                }
            ],
            'total_paid_amount' => [
                'new_key' => 'display_total_paid_amount',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Displayed' : 'Hidden';
                }
            ],
            'debit_entry' => [
                'new_key' => 'display_debit_entry',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Displayed' : 'Hidden';
                }
            ],
            'balance' => [
                'new_key' => 'display_balance',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Displayed' : 'Hidden';
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

        return $auditData;
    }
}
