<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('resolution_templates', function (Blueprint $table) {
            $table->integer('success_count')->default(0)->after('usage_count');
            $table->timestamp('last_used_at')->nullable()->after('success_count');
            $table->decimal('learning_score', 8, 2)->default(0)->after('last_used_at');
        });
    }

    public function down(): void
    {
        Schema::table('resolution_templates', function (Blueprint $table) {
            $table->dropColumn(['success_count', 'last_used_at', 'learning_score']);
        });
    }
};
