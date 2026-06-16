<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            if (!Schema::hasColumn('customers', 'sla_enabled')) {
                $table->boolean('sla_enabled')->default(false);
            }

            if (!Schema::hasColumn('customers', 'response_minutes')) {
                $table->integer('response_minutes')->nullable();
            }

            if (!Schema::hasColumn('customers', 'resolution_minutes')) {
                $table->integer('resolution_minutes')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            foreach (['resolution_minutes','response_minutes','sla_enabled'] as $column) {
                if (Schema::hasColumn('customers', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
