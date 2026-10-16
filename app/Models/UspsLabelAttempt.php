<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UspsLabelAttempt extends Model
{
    protected $table = 'usps_label_attempts';

    protected $fillable = [
        'store_shipment_id',
        'request_uuid',
        'label_type',
        'state',
        'tracking_number',
        'error_code',
        'error_message',
    ];

    public function shipment()
    {
        return $this->belongsTo(StoreShipment::class, 'store_shipment_id');
    }

    public function profile()
    {
        return $this->belongsTo(UspsShipmentProfile::class, 'store_shipment_id', 'store_shipment_id');
    }
}
