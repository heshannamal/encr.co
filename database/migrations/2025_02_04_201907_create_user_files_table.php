<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('user_files', function (Blueprint $table) {
            $table->string('doc_type')->default('verificationDocument')->after('file_path');
        });
    }
    
    public function down()
    {
        Schema::table('user_files', function (Blueprint $table) {
            $table->dropColumn('doc_type');
        });
    }

    // public function up()
    // {
    //     Schema::create('user_files', function (Blueprint $table) {
    //         $table->id();
    //         $table->unsignedBigInteger('user_id');
    //         $table->string('file_name');
    //         $table->string('file_path');
    //         $table->timestamps();

    //         $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    //     });
    // }

    // public function down()
    // {
    //     Schema::dropIfExists('user_files');
    // }
};
