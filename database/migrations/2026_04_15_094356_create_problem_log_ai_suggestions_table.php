<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('problem_log_ai_suggestions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('problem_log_id');
            $table->unsignedBigInteger('resolution_template_id')->nullable();
            $table->text('problem_summary')->nullable();
            $table->text('suggestion_reason')->nullable();
            $table->decimal('similarity_score', 8, 5)->nullable();
            $table->json('structured_problem')->nullable();
            $table->timestamps();

            $table->foreign('problem_log_id')->references('id')->on('problem_logs')->onDelete('cascade');
            $table->foreign('resolution_template_id')->references('id')->on('resolution_templates')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('problem_log_ai_suggestions');
    }
};
