<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCdtfaUpdateDetailsToOrganizations extends Migration
{
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->decimal('cdtfa_previous_rate', 8, 2)->nullable();
            $table->decimal('cdtfa_updated_rate', 8, 5)->nullable();
            $table->timestamp('cdtfa_updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn(['cdtfa_previous_rate', 'cdtfa_updated_rate', 'cdtfa_updated_at']);
        });
    }
}
