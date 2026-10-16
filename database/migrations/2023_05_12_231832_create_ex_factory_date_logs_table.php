<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExFactoryDateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ex_factory_date_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('user_id')->nullable();
            $table->string('pre_date')->nullable();
            $table->string('new_date');
            $table->string('reason')->nullable();
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
        Schema::dropIfExists('ex_factory_date_logs');
    }
}
