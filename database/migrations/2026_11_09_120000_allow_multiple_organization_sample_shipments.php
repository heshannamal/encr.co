<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AllowMultipleOrganizationSampleShipments extends Migration
{
    public function up()
    {
        Schema::table('organization_sample_shipments', function (Blueprint $table) {
            $table->dropUnique(['organization_id']);
            $table->index('organization_id');
        });
    }

    public function down()
    {
        if (DB::table('organization_sample_shipments')->select('organization_id')->groupBy('organization_id')->havingRaw('COUNT(*) > 1')->exists()) {
            throw new \RuntimeException('Cannot restore the unique constraint while multiple sample requests exist.');
        }
        Schema::table('organization_sample_shipments', function (Blueprint $table) {
            $table->dropIndex(['organization_id']);
            $table->unique('organization_id');
        });
    }
}
