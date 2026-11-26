<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class AddPdtTemplateVisibilityAndSoftDeletes extends Migration{
 public function up(){Schema::table('templates',function(Blueprint $t){$t->boolean('show_in_product')->default(true);$t->softDeletes();});}
 public function down(){Schema::table('templates',function(Blueprint $t){$t->dropColumn(['show_in_product','deleted_at']);});}
}
