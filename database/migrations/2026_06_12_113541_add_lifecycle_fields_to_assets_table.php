<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            if (!Schema::hasColumn('assets', 'lifecycle_status')) {
                $table->string('lifecycle_status')->default('active')->after('status');
            }

            if (!Schema::hasColumn('assets', 'retired_at')) {
                $table->dateTime('retired_at')->nullable()->after('lifecycle_status');
            }

            if (!Schema::hasColumn('assets', 'disposed_at')) {
                $table->dateTime('disposed_at')->nullable()->after('retired_at');
            }

            if (!Schema::hasColumn('assets', 'lifecycle_notes')) {
                $table->text('lifecycle_notes')->nullable()->after('disposed_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            foreach ([
                'lifecycle_notes',
                'disposed_at',
                'retired_at',
                'lifecycle_status',
            ] as $column) {
                if (Schema::hasColumn('assets', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
