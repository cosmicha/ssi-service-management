<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('service_contracts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_region_id')->nullable()->constrained('customer_regions')->nullOnDelete();
            $table->foreignId('customer_branch_id')->nullable()->constrained('customer_branches')->nullOnDelete();
            $table->foreignId('service_catalog_id')->nullable()->constrained('service_catalogs')->nullOnDelete();

            $table->string('contract_no')->nullable()->unique();
            $table->string('name');

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->string('support_hour')->nullable(); // 8x5, 12x6, 24x7
            $table->integer('response_minutes')->nullable();
            $table->integer('resolution_minutes')->nullable();

            $table->enum('pm_frequency', [
                'daily', 'weekly', 'monthly', 'quarterly', 'semester', 'yearly', 'none'
            ])->default('monthly');

            $table->text('scope')->nullable();
            $table->text('exclusion')->nullable();

            $table->enum('status', ['active', 'inactive', 'expired', 'draft'])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_contracts');
    }
};
