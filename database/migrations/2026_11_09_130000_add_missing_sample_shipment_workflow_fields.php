<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingSampleShipmentWorkflowFields extends Migration
{
    public function up()
    {
        // Some installations already have these fields from manual schema updates.
        foreach (['contact_id', 'confirmed_by', 'tracking_number', 'tracking_link'] as $column) {
            if (!Schema::hasColumn('organization_sample_shipments', $column)) {
                Schema::table('organization_sample_shipments', function (Blueprint $table) use ($column) {
                    if (in_array($column, ['contact_id', 'confirmed_by'], true)) {
                        $table->unsignedBigInteger($column)->nullable();
                    } else {
                        $table->string($column)->nullable();
                    }
                });
            }
        }
    }

    public function down()
    {
        // Preserve workflow data and columns that may predate this repair.
    }
}
