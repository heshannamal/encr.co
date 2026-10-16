<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Project extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'project_name',
        'project_no',
        'project_description',
        'project_status_id',
        'project_type_id',
        'project_color',
        'project_icon_id',
        'project_icon',
        'project_assignee',
        'project_assignee_users',
        'project_assignee_groups',
        'product_id',
        'product_level',
        'status',
        'stage_status',
        'created_by',
        'updated_by'
    ];

    protected $appends = ['project_icon_url', 'display_name', 'new_display_name', 'stage_status_options'];

    public function transformAudit(array $data): array
    {
        // Filter out changes where the old value is null and the new value is an empty string
        if (isset($data['old_values'])) {
            $data['old_values'] = array_filter($data['old_values'], function ($value, $key) use ($data) {
                return !($value === null && isset($data['new_values'][$key]) && $data['new_values'][$key] === '');
            }, ARRAY_FILTER_USE_BOTH);
        }

        // Skip the audit if no meaningful changes are left
        if (empty($data['old_values']) && empty($data['new_values'])) {
            return [];
        }

        // $parseListIds = function ($value) {
        //     if (empty($value)) return [];
            
        //     if (is_array($value)) {
        //         $rawIds = $value;
        //     } else {
        //         $decoded = json_decode($value, true);
        //         if (is_array($decoded)) {
        //             $rawIds = $decoded;
        //         } else {
        //             $rawIds = explode(',', $value);
        //         }
        //     }

        //     $finalIds = [];
        //     foreach ($rawIds as $item) {
        //         if (is_string($item) && strpos($item, ',') !== false) {
        //             $parts = explode(',', $item);
        //             foreach ($parts as $part) {
        //                 $finalIds[] = trim($part);
        //             }
        //         } else {
        //             $finalIds[] = trim($item);
        //         }
        //     }

        //     return array_filter($finalIds, function ($val) {
        //         return $val !== '' && $val !== null;
        //     });
        // };

        $mappings = [
            'project_status_id' => [
                'new_key' => 'project_status',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $status = \App\Models\ProjectStatus::find($id);
                    return $status ? $status->status_name : "Deleted Status (ID: {$id})";
                }
            ],
            'project_type_id' => [
                'new_key' => 'project_type',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $type = \App\Models\ProjectType::find($id);
                    return $type ? $type->type_name : "Deleted Type (ID: {$id})";
                }
            ],
            'project_icon_id' => [
                'new_key' => 'project_icon_path',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $icon = \App\Models\ProjectIcon::find($id);
                    return $icon ? $icon->icon : "Deleted Icon (ID: {$id})";
                }
            ],
            'project_assignee' => [
                'new_key' => 'project_assignee_name',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $ids = explode(',', $value);
                    $names = [];
                    foreach ($ids as $id) {
                        $user = \App\Models\User::find($id);
                        $names[] = $user ? $user->name : "Deleted User (ID: {$id})";
                    }
                    return implode(', ', $names);
                }
            ],
            'created_by' => [
                'new_key' => 'created_by_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $user = \App\Models\User::find($id);
                    return $user ? $user->name : "Deleted User (ID: {$id})";
                }
            ],
            'updated_by' => [
                'new_key' => 'updated_by_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $user = \App\Models\User::find($id);
                    return $user ? $user->name : "Deleted User (ID: {$id})";
                }
            ],
            'product_id' => [
                'new_key' => 'product_name',
                'resolve' => function ($id) {
                    if (empty($id)) return null;
                    $product = null;
                    if ($this->product_level == 1) {
                        $product = \App\Models\ProductTemp::find($id);
                    } elseif ($this->product_level == 2) {
                        $product = \App\Models\SubProductTemp::find($id);
                    } else {
                        $product = \App\Models\Product::find($id);
                    }
                    if (!$product) return "Deleted Product (ID: {$id})";
                    return $product->product_name ?? $product->product_no ?? "Product (ID: {$id})";
                }
            ],
            'project_assignee_users' => [
                'new_key' => 'project_assignee_user_names',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $ids = explode(',', $value);
                    $names = [];
                    foreach ($ids as $id) {
                        $user = \App\Models\User::find($id);
                        $names[] = $user ? $user->name : "Deleted User (ID: {$id})";
                    }
                    return implode(', ', $names);
                }
            ],
            'project_assignee_groups' => [
                'new_key' => 'project_assignee_group_names',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $ids = explode(',', $value);
                    $names = [];
                    foreach ($ids as $id) {
                        $role = \Spatie\Permission\Models\Role::find($id);
                        $names[] = $role ? $role->name : "Deleted Role (ID: {$id})";
                    }
                    return implode(', ', $names);
                }
            ],
        ];

        foreach (['old_values', 'new_values'] as $valueKey) {
            if (isset($data[$valueKey])) {
                foreach ($mappings as $originalKey => $mapping) {
                    if (array_key_exists($originalKey, $data[$valueKey])) {
                        $value = $data[$valueKey][$originalKey];
                        $resolvedValue = $value !== null && $value !== '' ? $mapping['resolve']($value) : null;
                        
                        $data[$valueKey][$mapping['new_key']] = $resolvedValue;
                        unset($data[$valueKey][$originalKey]);
                    }
                }
            }
        }

        return $data;
    }

    // protected static $logAttributes = ['project_name'];
    // Accessor to get the project icon image URL
    public function getProjectIconUrlAttribute()
    {
        if (!empty($this->attributes['project_icon_url'])) {
            return asset($this->attributes['project_icon_url']);
        }

        if (!empty($this->project_icon)) {
            return asset($this->project_icon);
        }

        if (!empty($this->project_icon_id)) {
            $icon = \App\Models\ProjectIcon::find($this->project_icon_id);

            if ($icon && !empty($icon->icon)) {
                return asset($icon->icon);
            }
        }

        return null;
    }

    /**
     * Get the available stage status options based on project status and type.
     *
     * - status == 1 AND project_type_id == 4  → Discussion, UI/UX Design, Development, Testing, Live
     * - status == 1 AND project_type_id in (1,2,3) → Discussion, Planning, Development, Sampling, Live
     *
     * @return array
     */
    public function getStageStatusOptionsAttribute(): array
    {
        if ($this->status == 1 && $this->project_type_id == 4) {
            return ['Discussion', 'UI/UX Design', 'Development', 'Testing', 'Live'];
        }

        if ($this->status == 1 && in_array($this->project_type_id, [1, 2, 3])) {
            return ['Discussion', 'Planning', 'Development', 'Sampling', 'Live'];
        }

        return [];
    }

    public function getDisplayNameAttribute()
    {
        if($this->project_type_id == 2){
            if($this->product){
                return $this->product->product_name ?? $this->product->product_no;
            } else {
                return 'N/A';
            }
        } else {
            return $this->project_name;
        }
    }

    public function getNewDisplayNameAttribute()
    {
        if ($this->project_type_id != 2) {
            return $this->project_name;
        }

        $product = null;

        if ($this->product_level == 1) {
            $product = $this->productTemp()->first();
        }

        if ($this->product_level == 2) {
            $product = $this->subProductTemp()->first();
        }

        if (!$product) {
            return 'N/A';
        }

        return $product->product_name 
            ?? $product->product_no 
            ?? 'N/A';
    }



    public function product(){
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id');
    }

    public function projectStatus()
    {
        return $this->belongsTo(ProjectStatus::class, 'project_status_id');
    }

    public function projectCreatedBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function productTemp() {
        return $this->belongsTo(ProductTemp::class, 'product_id');
    }

    public function subProductTemp() {
        return $this->belongsTo(SubProductTemp::class, 'product_id');
    }

    public function getCurrentProductAttribute()
    {
        if ($this->product_level == 1) {
            return $this->productTemp;
        }

        if ($this->product_level == 2) {
            return $this->subProductTemp;
        }

        return $this;
    }
}
