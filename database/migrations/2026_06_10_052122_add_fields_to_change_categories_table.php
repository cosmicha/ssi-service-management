<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('change_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('change_categories', 'name')) {
                $table->string('name')->nullable()->after('id');
            }

            if (!Schema::hasColumn('change_categories', 'description')) {
                $table->text('description')->nullable()->after('name');
            }

            if (!Schema::hasColumn('change_categories', 'status')) {
                $table->string('status')->default('active')->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('change_categories', function (Blueprint $table) {
            if (Schema::hasColumn('change_categories', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('change_categories', 'description')) {
                $table->dropColumn('description');
            }

            if (Schema::hasColumn('change_categories', 'name')) {
                $table->dropColumn('name');
            }
        });
    }
};
