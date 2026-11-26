<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaxRateSnapshots extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('sales_tax_rate', 8, 5)->nullable();
            $table->string('sales_tax_source', 40)->nullable();
            $table->timestamp('sales_tax_checked_at')->nullable();
            $table->text('sales_tax_address')->nullable();
        });
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('sales_tax_source', 40)->nullable();
            $table->timestamp('sales_tax_checked_at')->nullable();
            $table->text('sales_tax_address')->nullable();
            $table->boolean('sales_tax_auto_update')->default(true);
        });
        Schema::create('organization_tax_rate_updates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id')->index();
            $table->decimal('old_rate', 8, 5)->nullable();
            $table->decimal('new_rate', 8, 5);
            $table->string('source', 40);
            $table->text('address');
            $table->string('jurisdiction')->nullable();
            $table->string('tax_area_code')->nullable();
            $table->timestamp('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('organization_tax_rate_updates');
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn(['sales_tax_source', 'sales_tax_checked_at', 'sales_tax_address', 'sales_tax_auto_update']);
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['sales_tax_rate', 'sales_tax_source', 'sales_tax_checked_at', 'sales_tax_address']);
        });
    }
}
