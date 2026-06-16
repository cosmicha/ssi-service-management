<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customer_slas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('severity');

            $table->integer('response_minutes')->nullable();
            $table->integer('resolution_minutes')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(['customer_id', 'severity']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_slas');
    }
};
