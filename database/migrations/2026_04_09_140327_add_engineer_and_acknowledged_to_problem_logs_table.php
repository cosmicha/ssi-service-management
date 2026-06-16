<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('problem_logs', function (Blueprint $table) {
            $table->string('engineer_name')->nullable()->after('photo');
            $table->timestamp('acknowledged_at')->nullable()->after('engineer_name');
        });
    }

    public function down(): void
    {
        Schema::table('problem_logs', function (Blueprint $table) {
            $table->dropColumn(['engineer_name', 'acknowledged_at']);
        });
    }
};
