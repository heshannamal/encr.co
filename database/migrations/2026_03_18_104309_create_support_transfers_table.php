<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('support_transfers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('support_conversation_id')->constrained('support_conversations')->cascadeOnDelete();

            $table->foreignId('from_agent_id')
                ->nullable()
                ->constrained('support_agents')
                ->nullOnDelete();

            $table->foreignId('to_agent_id')
                ->nullable()
                ->constrained('support_agents')
                ->nullOnDelete();

            $table->foreignId('from_department_id')
                ->nullable()
                ->constrained('support_departments')
                ->nullOnDelete();

            $table->foreignId('to_department_id')
                ->nullable()
                ->constrained('support_departments')
                ->nullOnDelete();

            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_transfers');
    }
};
