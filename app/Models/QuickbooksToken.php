<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuickbooksToken extends Model
{
    protected $table = 'quickbooks_tokens';

    protected $guarded = [];

    protected $casts = [
        'access_token_expires_at' => 'datetime',
    ];
}
