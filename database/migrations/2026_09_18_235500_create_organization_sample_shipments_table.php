<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationSampleShipmentsTable extends Migration
{
    public function up()
    {
        Schema::create('organization_sample_shipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id')->unique();
            $table->string('status', 20)->default('received')->index();
            $table->date('received_date')->nullable();
            $table->date('delivered_date')->nullable();
            $table->json('products')->nullable();
            $table->json('fabric_swatches')->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->index('created_by');
        });
    }

    public function down()
    {
        Schema::dropIfExists('organization_sample_shipments');
    }
}
