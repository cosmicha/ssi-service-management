<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            if (!Schema::hasColumn('incidents', 'response_due_at')) {
                $table->dateTime('response_due_at')->nullable()->after('reported_at');
            }

            if (!Schema::hasColumn('incidents', 'resolution_due_at')) {
                $table->dateTime('resolution_due_at')->nullable()->after('response_due_at');
            }

            if (!Schema::hasColumn('incidents', 'first_response_at')) {
                $table->dateTime('first_response_at')->nullable()->after('resolution_due_at');
            }

            if (!Schema::hasColumn('incidents', 'sla_status')) {
                $table->string('sla_status')->default('on_track')->after('first_response_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            foreach (['sla_status','first_response_at','resolution_due_at','response_due_at'] as $column) {
                if (Schema::hasColumn('incidents', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
