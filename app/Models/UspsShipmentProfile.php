<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UspsShipmentProfile extends Model
{
    protected $table = 'usps_shipment_profiles';

    protected $fillable = [
        'store_shipment_id',
        'status',
        'recipient_first_name',
        'recipient_last_name',
        'recipient_street',
        'recipient_street2',
        'recipient_city',
        'recipient_state',
        'recipient_zip',
        'recipient_phone',
        'recipient_email',
        'recipient_country',
        'weight_lb',
        'length_in',
        'width_in',
        'height_in',
        'rate_indicator',
        'processing_category',
        'destination_entry_facility_type',
        'mailing_date',
        'suppress_postage',
        'usps_label_request_uuid',
        'label_path',
        'actual_postage',
        'label_metadata',
        'label_created_at',
        'reprint_count',
        'refund_dispute_id',
        'refund_status',
    ];

    protected $casts = [
        'weight_lb' => 'float',
        'length_in' => 'float',
        'width_in' => 'float',
        'height_in' => 'float',
        'suppress_postage' => 'boolean',
        'actual_postage' => 'float',
        'label_metadata' => 'array',
        'mailing_date' => 'date',
        'label_created_at' => 'datetime',
        'reprint_count' => 'integer',
    ];

    public function shipment()
    {
        return $this->belongsTo(StoreShipment::class, 'store_shipment_id');
    }

    public function labelAttempts()
    {
        return $this->hasMany(UspsLabelAttempt::class, 'store_shipment_id', 'store_shipment_id');
    }
}
