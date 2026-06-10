<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            if (!Schema::hasColumn('tasks', 'incident_id')) {
                $table->foreignId('incident_id')
                    ->nullable()
                    ->after('preventive_schedule_id')
                    ->constrained('incidents')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('tasks', 'change_request_id')) {
                $table->foreignId('change_request_id')
                    ->nullable()
                    ->after('incident_id')
                    ->constrained('change_requests')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            if (Schema::hasColumn('tasks', 'change_request_id')) {
                $table->dropConstrainedForeignId('change_request_id');
            }

            if (Schema::hasColumn('tasks', 'incident_id')) {
                $table->dropConstrainedForeignId('incident_id');
            }
        });
    }
};
