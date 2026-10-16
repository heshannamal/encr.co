<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('support_conversations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('support_department_id')->constrained('support_departments')->restrictOnDelete();

            $table->foreignId('assigned_agent_id')
                ->nullable()
                ->constrained('support_agents')
                ->nullOnDelete();

            $table->string('subject')->nullable();

            $table->enum('status', ['waiting', 'active', 'closed'])->default('waiting');
            $table->enum('priority', ['low', 'normal', 'high'])->default('normal');

            $table->timestamp('started_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamp('last_message_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_conversations');
    }
};
