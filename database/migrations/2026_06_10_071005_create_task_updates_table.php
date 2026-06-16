<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('task_updates', function (Blueprint $table) {
            $table->id();

            $table->foreignId('task_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->enum('update_type', [
                'comment',
                'status_change',
                'assignment',
                'work_log',
                'resolution'
            ])->default('comment');

            $table->text('message')->nullable();

            $table->string('old_status')->nullable();
            $table->string('new_status')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_updates');
    }
};
