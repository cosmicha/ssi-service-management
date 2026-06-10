<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_region_id')->nullable()->constrained('customer_regions')->nullOnDelete();
            $table->foreignId('customer_branch_id')->nullable()->constrained('customer_branches')->nullOnDelete();
            $table->foreignId('asset_category_id')->nullable()->constrained('asset_categories')->nullOnDelete();

            $table->string('name');
            $table->string('asset_code')->nullable()->unique();

            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('ip_address')->nullable();

            $table->date('purchase_date')->nullable();
            $table->date('warranty_expiry')->nullable();

            $table->enum('status', ['active', 'inactive', 'maintenance', 'faulty', 'retired'])->default('active');

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
