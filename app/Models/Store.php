<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Store extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    public $fillable = [
        'organization_id',
        'sport_id',
        'store_name',
        'salese_person',
        'direct_access_url',
        'product_prefix',
        'set_store_deadline',
        'open_date',
        'close_date',
        'contact_coach_id',
        'coach_name',
        'coach_email',
        'sales_assistant',
        'service_phone',
        'service_website',
        'service_email',
        'shipping_method',
        'sales_tax',
        'handling_fee',
        'service_charge',
        'other',
        'store_amount',
        'store_status',
        'send_closing_soon_email',
        'send_store_close_email',
        'send_order_production_completed_email',
        'send_final_update_email',
        'active'
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
            'organization_id' => [
                'new_key' => 'organization_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $organization = \App\Models\Organization::find($id);
                    return $organization ? $organization->organization_name : "Deleted Organization (ID: {$id})";
                }
            ],
            'salese_person' => [
                'new_key' => 'salese_person_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $user = \App\Models\User::find($id);
                    return $user ? $user->name : "Deleted User (ID: {$id})";
                }
            ],
            'contact_coach_id' => [
                'new_key' => 'contact_coach_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $contact = \App\Models\Contact::find($id);
                    return $contact ? $contact->first_name : "Deleted User (ID: {$id})";
                }
            ],
            'active' => [
                'new_key' => 'active_status',
                'resolve' => function ($value) {
                    return $value == 1 ? 'Active' : 'Inactive';
                }
            ],
        ];

        foreach (['old_values', 'new_values'] as $valueKey) {
            if (isset($auditData[$valueKey])) {
                foreach ($mappings as $originalKey => $mapping) {
                    if (array_key_exists($originalKey, $auditData[$valueKey])) {
                        $id = $auditData[$valueKey][$originalKey];
                        $resolvedValue = ($id !== null && $id !== '') ? $mapping['resolve']($id) : null;
                        
                        $auditData[$valueKey][$mapping['new_key']] = $resolvedValue;
                        unset($auditData[$valueKey][$originalKey]);
                    }
                }
            }
        }

        return $auditData;
    }

    public function organizationDetails()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }
    public function contactCoachesDetails()
    {
        return $this->belongsTo(Contact::class, 'contact_coach_id', 'id');
    }
    public function userDetails()
    {
        return $this->belongsTo(User::class, 'salese_person', 'id');
    }
    public function StoreAddedCoupons()
    {
        return $this->hasMany(StoreAddedCoupon::class, 'store_id', 'id');
    }
    public function StoreCustomInformations()
    {
        return $this->hasMany(StoreCustomInformation::class, 'store_id', 'id');
    }
    public function StoreAddedCustomInformations()
    {
        return $this->hasMany(StoreAddedCustomInformation::class, 'store_id', 'id')->with('storeCustomInformationsDetails');
    }
    public function StoreAddedProducts()
    {
        return $this->hasMany(StoreProduct::class, 'store_id', 'id')->where('active', 1)->whereNotNull('category_id')->with('images','priceAdditions');
    }
    public function StoreAddedShippingMethods()
    {
        return $this->hasMany(StoreAddedShippingMethod::class, 'store_id', 'id')->with('shippingMethod');
    }
    public function StoreAddedTaxCategories()
    {
        return $this->hasMany(StoreAddedTaxCategory::class, 'store_id', 'id')->with('taxCategory');
    }
    public function StoreProductBundles()
    {
        return $this->hasMany(StoreProductBundle::class, 'store_id', 'id');
    }
    public function StoreEditedCategory()
    {
        return $this->hasMany(StoreProductEditedCategory::class, 'store_id', 'id');
    }
    public function StoreOrders()
    {
        return $this->hasMany(StoreOrder::class, 'store_id', 'id')->with('OrderItems','storeCustomer','ShipmentDetails', 'couponDetails')->where('active',1);
    }
    public function flyerDetails()
    {
        return $this->belongsTo(StoreFlyer::class, 'id', 'store_id');
    }
    public function themeDetails()
    {
        return $this->belongsTo(StoreTheme::class, 'id', 'store_id');
    }
    public function categoryOrder()
    {
        return $this->belongsTo(StoreCategoryOrder::class, 'id', 'store_id');
    }
    public function groupAccessDetails()
    {
        return $this->hasMany(StoreGroupAccess::class, 'store_id', 'id');
    }
    public function saleAssistant()
    {
        return $this->belongsTo(User::class, 'sales_assistant', 'id');
    }
}
