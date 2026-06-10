<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            if (!Schema::hasColumn('tasks', 'dispatch_status')) {
                $table->string('dispatch_status')->default('not_dispatched');
            }

            if (!Schema::hasColumn('tasks', 'dispatched_at')) {
                $table->dateTime('dispatched_at')->nullable();
            }

            if (!Schema::hasColumn('tasks', 'travel_started_at')) {
                $table->dateTime('travel_started_at')->nullable();
            }

            if (!Schema::hasColumn('tasks', 'arrived_at')) {
                $table->dateTime('arrived_at')->nullable();
            }

            if (!Schema::hasColumn('tasks', 'work_started_at')) {
                $table->dateTime('work_started_at')->nullable();
            }

            if (!Schema::hasColumn('tasks', 'work_paused_at')) {
                $table->dateTime('work_paused_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            foreach ([
                'work_paused_at',
                'work_started_at',
                'arrived_at',
                'travel_started_at',
                'dispatched_at',
                'dispatch_status',
            ] as $column) {
                if (Schema::hasColumn('tasks', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
