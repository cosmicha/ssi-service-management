<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('preventive_executions', function (Blueprint $table) {
            if (!Schema::hasColumn('preventive_executions', 'pm_no')) {
                $table->string('pm_no')->nullable()->unique()->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('preventive_executions', function (Blueprint $table) {
            if (Schema::hasColumn('preventive_executions', 'pm_no')) {
                $table->dropColumn('pm_no');
            }
        });
    }
};
