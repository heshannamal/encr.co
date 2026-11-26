<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RepairSampleShipmentShippingFields extends Migration
{
    public function up()
    {
        foreach (['shipping_street', 'shipping_city', 'shipping_state', 'shipping_postal_code', 'shipping_country'] as $column) {
            if (!Schema::hasColumn('organization_sample_shipments', $column)) {
                Schema::table('organization_sample_shipments', function (Blueprint $table) use ($column) {
                    $table->string($column, $column === 'shipping_postal_code' ? 100 : 255)->nullable();
                });
            }
        }
    }

    public function down()
    {
        // Preserve saved addresses and columns that may predate this repair.
    }
}
