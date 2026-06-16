<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('preventive_executions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('task_id')->nullable()->constrained('tasks')->nullOnDelete();
            $table->foreignId('preventive_schedule_id')->nullable()->constrained('preventive_schedules')->nullOnDelete();
            $table->foreignId('engineer_id')->nullable()->constrained('users')->nullOnDelete();

            $table->dateTime('started_at')->nullable();
            $table->dateTime('completed_at')->nullable();

            $table->enum('overall_result', [
                'pass',
                'warning',
                'fail'
            ])->nullable();

            $table->text('summary')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('preventive_executions');
    }
};
