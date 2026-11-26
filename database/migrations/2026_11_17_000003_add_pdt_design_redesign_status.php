<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class AddPdtDesignRedesignStatus extends Migration {
 public function up(){Schema::table('pdt_design_request_templates',function(Blueprint $t){$t->string('design_status',30)->default('ready');});}
 public function down(){Schema::table('pdt_design_request_templates',function(Blueprint $t){$t->dropColumn('design_status');});}
}
