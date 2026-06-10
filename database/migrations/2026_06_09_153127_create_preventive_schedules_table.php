<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('preventive_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_contract_id')->nullable()->constrained('service_contracts')->nullOnDelete();
            $table->foreignId('asset_id')->nullable()->constrained('assets')->nullOnDelete();
            $table->foreignId('checklist_template_id')->nullable()->constrained('checklist_templates')->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();

            $table->string('name');
            $table->enum('frequency', ['daily', 'weekly', 'monthly', 'quarterly', 'semester', 'yearly'])->default('monthly');

            $table->date('start_date')->nullable();
            $table->date('next_run_date')->nullable();
            $table->date('last_run_date')->nullable();

            $table->integer('due_days')->default(7);
            $table->text('notes')->nullable();

            $table->enum('status', ['active', 'paused', 'inactive'])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('preventive_schedules');
    }
};
