<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class QuickbookRecord extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    protected $table = 'quickbook_records';

    protected $fillable = [
        'order_id',
        'payment_type',
        'is_refund',
        'record_id',
        'transaction_created_at',
        'customer_id',
        'email',
        'send_later',
        'receipt_date',
        'billing_address',
        'shipping_address',
        'ship_via',
        'shipping_date',
        'tracking_no',
        'location',
        'po_number',
        'sales_rep',
        'shipping_from',
        'payment_method_id',
        'reference_no',
        'deposit_account_id',
        'line_items',
        'amount',
        'sales_receipt_id',
        'from_tsr_module',
        'qb_doc_number',
        'qb_sync_token',
        'qb_raw_response',
        'export_status',
        'error_message',
        'export_status',
        'sales_receipt_id',
        'qb_doc_number',
        'qb_doc_number',
        'qb_sync_token',
        'qb_raw_response',
    ];
}
