<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements Auditable
{
    use AuditableTrait;
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_role_id', 'role_id', 'user_group_id', 'profile_pic'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function userRoleDetails(){
    //     // return $this->belongsTo('App\Models\UserRole', 'user_role_id');
    //     return $this->belongsTo('Spatie\Permission\Models', 'role_id');
    // }

    protected $appends = ['profile_pic_url'];

    public function getProfilePicUrlAttribute()
    {
        $defaultImage = 'assets/img/user/default.png';

        if (!empty($this->profile_pic)) {
            return asset($this->profile_pic);
        }
        return asset($defaultImage);
    }

    public function userGroupDetails(){
        return $this->belongsTo('App\Models\UserGroup', 'user_group_id');
    }
    public function emailTemplates()
    {
        return $this->hasMany(EmailTemplate::class);
    }
    public function emailSignature()
    {
        return $this->hasOne(EmailSignature::class);
    }
    public function emailFilter()
    {
        return $this->hasOne(EmailFilter::class, 'user_id');
    }
    public function userDetails()
    {
        return $this->hasOne(UserDetails::class);
    }
    public function isAdmin()
    {
        return in_array(1, json_decode($this->role_id, true)); // Assuming role ID 1 is for admin
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
            'role_id' => [
                'new_key' => 'roles_names',
                'resolve' => function ($value) {
                    if (empty($value)) return null;
                    $ids = json_decode($value, true);
                    if (!is_array($ids)) $ids = [$ids];
                    $names = [];
                    foreach ($ids as $id) {
                        $group = \Spatie\Permission\Models\Role::find($id);
                        $names[] = $group ? $group->name : "Deleted Group (ID: {$id})";
                    }
                    return implode(', ', $names);
                }
            ],
            'password' => [
                'new_key' => 'password_status',
                'resolve' => function ($value, $valueKey = 'new_values') {
                    if (empty($value)) return null;
                    return $valueKey === 'old_values' ? 'Previous Password' : 'Password Changed';
                }
            ],
            'remember_token' => [
                'new_key' => 'login_in',
                'resolve' => function ($value, $valueKey = 'new_values') {
                    if (empty($value)) return null;
                    return $valueKey === 'old_values' ? 'Logged Out' : 'Logged In';
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
