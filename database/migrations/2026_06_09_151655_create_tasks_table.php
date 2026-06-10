<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->string('task_no')->unique();

            $table->enum('task_type', [
                'preventive',
                'corrective',
                'change',
                'general',
                'site_survey',
                'implementation'
            ])->default('general');

            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('customer_region_id')->nullable()->constrained('customer_regions')->nullOnDelete();
            $table->foreignId('customer_branch_id')->nullable()->constrained('customer_branches')->nullOnDelete();
            $table->foreignId('asset_id')->nullable()->constrained('assets')->nullOnDelete();

            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->string('title');
            $table->text('description')->nullable();

            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');

            $table->enum('status', [
                'open',
                'assigned',
                'in_progress',
                'pending',
                'completed',
                'cancelled'
            ])->default('open');

            $table->date('planned_date')->nullable();
            $table->dateTime('due_date')->nullable();

            $table->dateTime('started_at')->nullable();
            $table->dateTime('completed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
