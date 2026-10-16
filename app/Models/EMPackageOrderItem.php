<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
class EMPackageOrderItem extends Model implements Auditable
{
    use AuditableTrait;
    protected $table = 'em_package_order_items';
    protected $fillable = ['order_id','package_id','package_name','quantity','classes_per_package','unit_price','total_price'];
    public function order()
    {
        return $this->belongsTo(EMPackageOrder::class, 'order_id');
    }

    public function package()
    {
        return $this->belongsTo(EMPackage::class, 'package_id');
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
                'new_key' => 'order_no',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $order = EMPackageOrder::find($value);
                    return $order ? $order->order_no : "Deleted Order (ID: {$value})";
                }
            ],
            'package_id' => [
                'new_key' => 'package_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $package = EMPackage::find($value);
                    return $package ? $package->package_name : "Deleted Package (ID: {$value})";
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

        $auditData['source'] = json_encode(['EMPackageOrder' => $this->order_id]);
        
        return $auditData;
    }
}
