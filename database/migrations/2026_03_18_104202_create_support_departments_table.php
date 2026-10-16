<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('support_departments', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Technical Support, Sales Support, Account Support
            $table->string('slug')->unique(); // technical-support, sales-support, account-support
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_departments');
    }
};
