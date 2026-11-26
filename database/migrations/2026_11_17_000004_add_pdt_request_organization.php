<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class AddPdtRequestOrganization extends Migration {
 public function up(){Schema::table('pdt_design_requests',function(Blueprint $t){$t->unsignedBigInteger('organization_id')->nullable()->index();});}
 public function down(){Schema::table('pdt_design_requests',function(Blueprint $t){$t->dropColumn('organization_id');});}
}
