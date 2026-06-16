<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('resolution_templates', function (Blueprint $table) {
            $table->string('ai_title')->nullable()->after('title');
            $table->text('ai_summary')->nullable()->after('category');
            $table->json('ai_steps')->nullable()->after('resolution_steps');
            $table->string('ai_category')->nullable()->after('ai_steps');
            $table->boolean('ai_processed')->default(false)->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('resolution_templates', function (Blueprint $table) {
            $table->dropColumn([
                'ai_title',
                'ai_summary',
                'ai_steps',
                'ai_category',
                'ai_processed',
            ]);
        });
    }
};
