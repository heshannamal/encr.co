<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class AccountsLog extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditableTrait;
    public $timestamps = true;
    protected $table = 'accounts_logs';

    protected $fillable = [
        'organization_id',
        'order_id',
        'amount',
        'paid',
        'balance',
        'type',
        'user_id',
        'status',
        'note',
        'document_url',
    ];
    // Override default created_at behavior to include milliseconds
    public function setCreatedAt($value)
    {
        $this->attributes['created_at'] = Carbon::now()->format('Y-m-d H:i:s.u');
    }
    protected $dates = ['deleted_at'];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
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
            'organization_id' => [
                'new_key' => 'organization_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $store = \App\Models\Organization::find($id);
                    return $store ? $store->store_name : "Deleted Store (ID: {$id})";
                }
            ],
            'order_id' => [
                'new_key' => 'order_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $order = \App\Models\Order::find($id);
                    return $order ? $order->order_no : "Deleted Order (ID: {$id})";
                }
            ],
            'user_id' => [
                'new_key' => 'user_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $user = \App\Models\User::find($id);
                    return $user ? $user->name : "Deleted User (ID: {$id})";
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

        $order = $this->order;
        if ($order) {
            $auditData['source'] = json_encode(['Order' => $order->id]);
        }

        return $auditData;
    }
}
