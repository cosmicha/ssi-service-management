<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->integer('sla_response_minutes')->default(30)->after('name');
            $table->integer('sla_resolution_minutes')->default(240)->after('sla_response_minutes');
            $table->boolean('sla_active')->default(true)->after('sla_resolution_minutes');
            $table->text('notification_emails')->nullable()->after('sla_active');
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'sla_response_minutes',
                'sla_resolution_minutes',
                'sla_active',
                'notification_emails',
            ]);
        });
    }
};
