<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('resolution_templates', function (Blueprint $table) {
            $table->string('canonical_group')->nullable()->after('ai_category');
            $table->boolean('is_primary')->default(true)->after('canonical_group');
            $table->text('merged_from_titles')->nullable()->after('is_primary');
        });
    }

    public function down(): void
    {
        Schema::table('resolution_templates', function (Blueprint $table) {
            $table->dropColumn([
                'canonical_group',
                'is_primary',
                'merged_from_titles',
            ]);
        });
    }
};
