<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('preventive_execution_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('preventive_execution_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('checklist_template_item_id')
                ->nullable()
                ->constrained('checklist_template_items')
                ->nullOnDelete();

            $table->enum('result', [
                'pass',
                'warning',
                'fail'
            ])->nullable();

            $table->text('value_text')->nullable();
            $table->text('remarks')->nullable();

            $table->string('photo_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('preventive_execution_items');
    }
};
