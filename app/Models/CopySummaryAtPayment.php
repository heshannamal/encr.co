<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CopySummaryAtPayment extends Model
{
    use HasFactory;
    public $timestamps = true;
    // Override default created_at behavior to include milliseconds
    public function setCreatedAt($value)
    {
        $this->attributes['created_at'] = Carbon::now()->format('Y-m-d H:i:s.u');
    }
}
