<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class CustomerEnquiryItem extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;
    protected $table = 'customer_enquiry_items';
    protected $fillable = [
        'item_no', 'order_id', 'product_id', 'organization_id', 'factory_id', 'support_agent_id', 'designer_id', 'shipping_method', 'ex_factory_id',
        'in_hand_due_date', 'est_delivery_date', 'order_status_id', 'fabric_id', 'secondary_fabric_id', 'embellishment_type_id', 'sport', 'gender', 'qty', 'unit_price', 'total',
        'extra_size', 'extra_size_two', 'extra_size_three', 'double_sided', 'individual_name', 'pockets', 'zipper_pockets', 'dynamic_details',
        'contrast_stratching', 'printing_over_sems', 'tracking_no', 'tracking_link'
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
            'order_id' => [
                'new_key' => 'order_no',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $order = Order::find($value);
                    return $order ? $order->order_no : "Deleted Order (ID: {$value})";
                }
            ],
            'product_id' => [
                'new_key' => 'product_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $product = Product::find($value);
                    return $product ? $product->product_name : "Deleted Product (ID: {$value})";
                }
            ],
            'organization_id' => [
                'new_key' => 'organization_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $organization = Organization::find($value);
                    return $organization ? $organization->organization_name : "Deleted Organization (ID: {$value})";
                }
            ],
            'factory_id' => [
                'new_key' => 'factory_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $factory = Factory::find($value);
                    return $factory ? $factory->factory_name : "Deleted Factory (ID: {$value})";
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

        $auditData['source'] = json_encode(['Organization' => $this->organization_id]);

        return $auditData;
    }
}
