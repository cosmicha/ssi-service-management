<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            if (!Schema::hasColumn('incidents', 'responded_at')) {
                $table->dateTime('responded_at')->nullable();
            }

            if (!Schema::hasColumn('incidents', 'resolved_at')) {
                $table->dateTime('resolved_at')->nullable();
            }

            if (!Schema::hasColumn('incidents', 'response_sla_status')) {
                $table->string('response_sla_status')->nullable();
            }

            if (!Schema::hasColumn('incidents', 'resolution_sla_status')) {
                $table->string('resolution_sla_status')->nullable();
            }

            if (!Schema::hasColumn('incidents', 'sla_breached_at')) {
                $table->dateTime('sla_breached_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            foreach ([
                'sla_breached_at',
                'resolution_sla_status',
                'response_sla_status',
                'resolved_at',
                'responded_at',
            ] as $column) {
                if (Schema::hasColumn('incidents', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
