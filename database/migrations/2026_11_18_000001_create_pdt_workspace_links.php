<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreatePdtWorkspaceLinks extends Migration {
 public function up(){Schema::create('pdt_workspace_links',function(Blueprint $t){$t->id();$t->unsignedBigInteger('request_id')->index();$t->unsignedBigInteger('issued_by');$t->string('token_hash',64)->unique();$t->timestamp('expires_at');$t->timestamp('revoked_at')->nullable();$t->timestamps();});}
 public function down(){Schema::dropIfExists('pdt_workspace_links');}
}
