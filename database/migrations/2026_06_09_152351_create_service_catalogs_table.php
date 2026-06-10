<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('service_catalogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_category_id')->nullable()->constrained('service_categories')->nullOnDelete();

            $table->string('name');
            $table->string('code')->nullable()->unique();
            $table->text('description')->nullable();

            $table->string('default_support_hour')->nullable(); // 8x5, 12x6, 24x7
            $table->integer('default_response_minutes')->nullable();
            $table->integer('default_resolution_minutes')->nullable();

            $table->enum('default_pm_frequency', [
                'daily', 'weekly', 'monthly', 'quarterly', 'semester', 'yearly', 'none'
            ])->default('monthly');

            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_catalogs');
    }
};
