<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('change_requests', function (Blueprint $table) {

            $table->id();

            $table->string('change_no')->unique();

            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('customer_region_id')->nullable()->constrained('customer_regions')->nullOnDelete();
            $table->foreignId('customer_branch_id')->nullable()->constrained('customer_branches')->nullOnDelete();

            $table->foreignId('asset_id')->nullable()->constrained()->nullOnDelete();

            $table->foreignId('change_category_id')->nullable()->constrained()->nullOnDelete();

            $table->foreignId('task_id')->nullable()->constrained()->nullOnDelete();

            $table->string('title');

            $table->longText('description')->nullable();

            $table->longText('business_reason')->nullable();

            $table->enum('risk_level',[
                'low',
                'medium',
                'high'
            ])->default('medium');

            $table->longText('implementation_plan')->nullable();

            $table->longText('rollback_plan')->nullable();

            $table->string('requested_by')->nullable();

            $table->timestamp('requested_date')->nullable();

            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            $table->timestamp('implementation_date')->nullable();

            $table->longText('verification_notes')->nullable();

            $table->enum('status',[
                'draft',
                'submitted',
                'approved',
                'scheduled',
                'in_progress',
                'completed',
                'rejected'
            ])->default('draft');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('change_requests');
    }
};
