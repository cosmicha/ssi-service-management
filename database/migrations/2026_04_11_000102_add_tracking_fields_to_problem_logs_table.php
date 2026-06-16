<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('problem_logs', function (Blueprint $table) {
            $table->foreignId('created_by_user_id')->nullable()->after('company_id')->constrained('users')->nullOnDelete();
            $table->foreignId('assigned_by_user_id')->nullable()->after('created_by_user_id')->constrained('users')->nullOnDelete();
            $table->foreignId('acknowledged_by_user_id')->nullable()->after('assigned_by_user_id')->constrained('users')->nullOnDelete();
            $table->foreignId('closed_by_user_id')->nullable()->after('acknowledged_by_user_id')->constrained('users')->nullOnDelete();

            $table->timestamp('response_due_at')->nullable()->after('closed_by_user_id');
            $table->timestamp('resolution_due_at')->nullable()->after('response_due_at');

            $table->boolean('response_sla_breached')->default(false)->after('resolution_due_at');
            $table->boolean('resolution_sla_breached')->default(false)->after('response_sla_breached');
        });
    }

    public function down(): void
    {
        Schema::table('problem_logs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_by_user_id');
            $table->dropConstrainedForeignId('assigned_by_user_id');
            $table->dropConstrainedForeignId('acknowledged_by_user_id');
            $table->dropConstrainedForeignId('closed_by_user_id');

            $table->dropColumn([
                'response_due_at',
                'resolution_due_at',
                'response_sla_breached',
                'resolution_sla_breached',
            ]);
        });
    }
};
