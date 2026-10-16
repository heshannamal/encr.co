<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class StoreOrder extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;
    protected $table = 'store_orders';

    protected $fillable = [
        'store_id',
        'store_customer_id',
        'sub_total',
        'shipping',
        'handling_fee',
        'sales_tax',
        'total',
        'paid_invoice_amount',
        'paid_processing_fee',
        'paid_amount',
        'payment_method',
        'shipping_method',
        'carrier',
        'order_no',
    ];

    public function StatusDetails()
    {
        return $this->hasOne(StoreOrderStatus::class, 'id', 'order_status');
    }
    public function CustomerDetails()
    {
        return $this->hasOne(StoreCustomer::class, 'id', 'store_customer_id');
    }
    public function ShipmentDetails()
    {
        return $this->hasOne(StoreShipment::class, 'store_order_no', 'order_no');
    }
    public function OrderReceipts()
    {
        return $this->hasMany(StoreOrderReceipt::class, 'store_order_no', 'order_no');
    }
    public function storeCustomer()
    {
        return $this->belongsTo(StoreCustomer::class, 'store_customer_id');
    }
    public function OrderItems()
    {
        return $this->hasMany(StoreOrderItem::class, 'store_order_id', 'id')->with('OrderItemDetails','productDetails','orderDetails');
    }
    public function playerDetails()
    {
        return $this->hasMany(StoreOrderItem::class, 'store_order_id', 'id')->with('OrderItemDetails');
    }
    public function paymentDetails()
    {
        return $this->hasMany(StoreCardPayment::class, 'store_order_no', 'order_no');
    }
    public function receipts()
    {
        return $this->hasMany(StoreOrderReceipt::class, 'store_order_no', 'order_no');
    }
    public function shippingMethodDetails()
    {
        return $this->hasOne(StoreShippingMethod::class, 'id', 'shipping_method');
    }
    public function couponDetails()
    {
        return $this->hasOne(StoreCoupon::class, 'coupon_code', 'coupon_code');
    }
    public function storeDetails()
    {
        return $this->hasOne(Store::class, 'id', 'store_id')->with('organizationDetails','contactCoachesDetails','userDetails');
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
                    $store = \App\Models\Store::find($id);
                    return $store ? $store->store_name : "Deleted Store (ID: {$id})";
                }
            ],
            'store_customer_id' => [
                'new_key' => 'store_customer_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $customer = \App\Models\StoreCustomer::find($id);
                    return $customer ? $customer->first_name.' '.$customer->last_name : "Deleted Customer (ID: {$id})";
                }
            ],
            'shipping_method' => [
                'new_key' => 'shipping_method_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return match ((int)$value) {
                        1 => 'Direct Ship to Customers',
                        2 => 'Bulk Ship to Coach',
                        3 => 'Pick Up',
                        default => null,
                    };
                }
            ],
            'is_shipping_removed' => [
                'new_key' => 'is_shipping_removed_status',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Yes' : 'No';
                }
            ],
            'order_status' => [
                'new_key' => 'order_status_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return match ((int)$value) {
                        1 => 'New',
                        2 => 'Quote',
                        3 => 'Production',
                        4 => 'Shipped',
                        5 => 'Complete',
                        default => 'Quote',
                    };
                }
            ],
            'is_payment_success' => [
                'new_key' => 'is_payment_success_status',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Yes' : 'No';
                }
            ],
            'send_store_close_soon_email' => [
                'new_key' => 'send_store_close_soon_email_status',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Active' : 'Inactive';
                }
            ],
            'send_store_closed_email' => [
                'new_key' => 'send_store_closed_email_status',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Active' : 'Inactive';
                }
            ],
            'send_order_shipped_email' => [
                'new_key' => 'send_order_shipped_email_status',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    return $value == 1 ? 'Active' : 'Inactive';
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

        $store = $this->storeDetails;
        if ($store) {
            $auditData['source'] = json_encode(['Store' => $store->id]);
        }

        return $auditData;
    }

}
