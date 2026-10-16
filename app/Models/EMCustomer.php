<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
class EMCustomer extends Model implements Auditable
{
    use AuditableTrait;

    protected $table = 'em_customers';
    protected $fillable = ['first_name','last_name','email','phone','password','google_id','profile_photo','email_verified_at','is_active'];
    protected $hidden = ['password'];
    protected $casts = ['email_verified_at'=>'datetime','is_active'=>'boolean'];
    public function children(){ return $this->hasMany(EMCustomerChild::class,'customer_id'); }

    public function transformAudit(array $auditData): array
    {
        $auditData['old_values'] = array_filter($auditData['old_values'], function ($value, $key) use ($auditData) {
            return !($value === null && isset($auditData['new_values'][$key]) && $auditData['new_values'][$key] === '');
        }, ARRAY_FILTER_USE_BOTH);

        if (empty($auditData['old_values']) && empty($auditData['new_values'])) {
            return [];
        }

        $mappings = [
            'password' => [
                'new_key' => 'password_status',
                'resolve' => function ($value, $valueKey = 'new_values') {
                    if (empty($value)) return null;
                    return $valueKey === 'old_values' ? 'Previous Password' : 'Password Changed';
                }
            ],
            'is_active' => [
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
