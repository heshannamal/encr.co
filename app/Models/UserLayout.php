<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class UserLayout extends Model implements Auditable
{
    use AuditableTrait;

    // protected $fillable = [
    //     'profile_pic', 'name', 'email', 'user_role_name', 'user_group_name', 'created', 'updated', 'm_number', 'department',
    // ];
    protected $fillable = [
        'profile_pic',
        'name',
        'email',
        'user_role_name',
        'user_group_name',
        'created',
        'updated',

        // Contact
        'm_number',
        'w_number',
        'private_email',

        // Personal
        'address',
        'about',
        'city',
        'country',
        'postal_code',
        'timezone',

        // Work
        'job_title',
        'department',
        'employment_status',
        'joined_date',

        // Extra
        'dob',
        'marital_status',
        'gender',
        'nationality',
        'languages',
    ];
}