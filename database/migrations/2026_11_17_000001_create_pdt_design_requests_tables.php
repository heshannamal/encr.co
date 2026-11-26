<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePdtDesignRequestsTables extends Migration
{
    public function up()
    {
        Schema::create('pdt_design_requests',function(Blueprint $t){
            $t->id();$t->unsignedBigInteger('requested_by')->index();$t->string('title',180);$t->text('brief')->nullable();
            $t->string('status',20)->default('pending')->index();$t->unsignedBigInteger('completed_by')->nullable();$t->timestamp('completed_at')->nullable();$t->timestamps();
        });
        Schema::create('pdt_design_request_items',function(Blueprint $t){
            $t->id();$t->foreignId('request_id')->constrained('pdt_design_requests')->onDelete('cascade');
            $t->unsignedBigInteger('pdt_product_id')->index();$t->timestamps();$t->unique(['request_id','pdt_product_id'],'pdt_request_product_unique');
        });
        Schema::create('pdt_design_request_templates',function(Blueprint $t){
            $t->id();$t->foreignId('request_item_id')->constrained('pdt_design_request_items')->onDelete('cascade');
            $t->unsignedBigInteger('template_id')->index();$t->unsignedBigInteger('added_by');$t->timestamps();
            $t->unique(['request_item_id','template_id'],'pdt_request_template_unique');
        });
        if(Schema::hasTable('permissions')){
            foreach(['view pdt design requests','create pdt design requests','manage pdt design requests'] as $name){
                DB::table('permissions')->insertOrIgnore(['name'=>$name,'guard_name'=>'web','created_at'=>now(),'updated_at'=>now()]);
            }
            app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        }
    }
    public function down()
    {
        Schema::dropIfExists('pdt_design_request_templates');Schema::dropIfExists('pdt_design_request_items');Schema::dropIfExists('pdt_design_requests');
    }
}
