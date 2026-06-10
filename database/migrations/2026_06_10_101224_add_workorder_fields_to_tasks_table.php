<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            if (!Schema::hasColumn('tasks', 'work_order_no')) {
                $table->string('work_order_no')->nullable()->after('task_no');
            }

            if (!Schema::hasColumn('tasks', 'assigned_vendor')) {
                $table->string('assigned_vendor')->nullable()->after('assigned_to');
            }

            if (!Schema::hasColumn('tasks', 'team_name')) {
                $table->string('team_name')->nullable()->after('assigned_vendor');
            }

            if (!Schema::hasColumn('tasks', 'planned_start_at')) {
                $table->dateTime('planned_start_at')->nullable();
            }

            if (!Schema::hasColumn('tasks', 'planned_finish_at')) {
                $table->dateTime('planned_finish_at')->nullable();
            }

            if (!Schema::hasColumn('tasks', 'actual_start_at')) {
                $table->dateTime('actual_start_at')->nullable();
            }

            if (!Schema::hasColumn('tasks', 'actual_finish_at')) {
                $table->dateTime('actual_finish_at')->nullable();
            }

            if (!Schema::hasColumn('tasks', 'travel_minutes')) {
                $table->integer('travel_minutes')->nullable();
            }

            if (!Schema::hasColumn('tasks', 'work_minutes')) {
                $table->integer('work_minutes')->nullable();
            }

            if (!Schema::hasColumn('tasks', 'waiting_minutes')) {
                $table->integer('waiting_minutes')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            foreach ([
                'waiting_minutes',
                'work_minutes',
                'travel_minutes',
                'actual_finish_at',
                'actual_start_at',
                'planned_finish_at',
                'planned_start_at',
                'team_name',
                'assigned_vendor',
                'work_order_no',
            ] as $column) {
                if (Schema::hasColumn('tasks', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
