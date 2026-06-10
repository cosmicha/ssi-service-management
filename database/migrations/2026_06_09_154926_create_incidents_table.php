<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('incidents', function (Blueprint $table) {

            $table->id();

            $table->string('incident_no')->unique();

            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('customer_region_id')->nullable()->constrained('customer_regions')->nullOnDelete();
            $table->foreignId('customer_branch_id')->nullable()->constrained('customer_branches')->nullOnDelete();

            $table->foreignId('asset_id')->nullable()->constrained()->nullOnDelete();

            $table->foreignId('incident_category_id')->nullable()->constrained()->nullOnDelete();

            $table->foreignId('task_id')->nullable()->constrained()->nullOnDelete();

            $table->string('title');
            $table->longText('description')->nullable();

            $table->enum('severity',[
                'low',
                'medium',
                'high',
                'critical'
            ])->default('medium');

            $table->string('reported_by')->nullable();

            $table->timestamp('reported_at')->nullable();

            $table->enum('status',[
                'open',
                'assigned',
                'in_progress',
                'resolved',
                'closed'
            ])->default('open');

            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
