<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('support_agent_departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('support_agent_id')->constrained('support_agents')->cascadeOnDelete();
            $table->foreignId('support_department_id')->constrained('support_departments')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['support_agent_id', 'support_department_id'], 'sad_unique_agent_department');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_agent_departments');
    }
};
