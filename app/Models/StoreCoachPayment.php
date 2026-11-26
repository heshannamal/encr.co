<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreCoachPayment extends Model
{
    protected $table = 'store_coach_payments';

    protected $fillable = [
        'store_id','request_uuid','payment_token','coach_name','coach_email',
        'item_count','payment_amount','processing_fee','total_amount','status',
        'is_success','card_owner','card_last_digits','transaction_id',
        'gateway_response_code','gateway_reason_code','gateway_message',
        'created_by','paid_at',
    ];

    protected $casts = [
        'item_count' => 'integer',
        'payment_amount' => 'decimal:2',
        'processing_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'is_success' => 'boolean',
        'paid_at' => 'datetime',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
