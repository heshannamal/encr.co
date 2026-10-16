<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_order_details', function (Blueprint $table) {
            $table->id();
            $table->integer('shipping_information_id')->nullable();
            $table->integer('order_id');
            $table->integer('order_item_id');
            $table->integer('order_item_detail_id');
            $table->integer('size_id');
            $table->string('size_name');
            $table->string('has_blank_qty')->comment('has blanks = yes, has no blanks = no');
            $table->integer('order_qty');
            $table->integer('shipped_qty')->nullable();
            $table->integer('back_ordered_qty')->nullable();
            $table->tinyInteger('is_back_ordered')->default(0);
            $table->string('seq_name')->nullable()->comment('related field name of the player name table');
            $table->string('player_name')->nullable()->comment('player name ');
            $table->string('seq_number')->nullable()->comment('related field name for the player number in order_items_details table');
            $table->string('player_number')->nullable()->comment('player number');
            $table->date('est_delivery_date')->nullable();
            $table->string('tracking_no')->nullable();
            $table->string('tracking_link')->nullable();
            $table->tinyInteger('notify_status')->default(0);
            $table->integer('notified_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_order_details');
    }
}
