<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventory_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable()->unique();
            $table->string('location_type')->default('warehouse'); // warehouse, branch, engineer
            $table->foreignId('customer_branch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('engineer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('address')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_locations');
    }
};
