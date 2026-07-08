<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['customers', 'companies'] as $tableName) {
            if (!Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (!Schema::hasColumn($tableName, 'notification_emails')) {
                    $table->text('notification_emails')->nullable();
                }

                if (!Schema::hasColumn($tableName, 'admin_notification_emails')) {
                    $table->text('admin_notification_emails')->nullable();
                }

                if (!Schema::hasColumn($tableName, 'escalation_emails')) {
                    $table->text('escalation_emails')->nullable();
                }

                if (!Schema::hasColumn($tableName, 'whatsapp_group')) {
                    $table->string('whatsapp_group')->nullable();
                }

                if (!Schema::hasColumn($tableName, 'default_engineer_id')) {
                    $table->unsignedBigInteger('default_engineer_id')->nullable();
                }

                if (!Schema::hasColumn($tableName, 'sla_profile')) {
                    $table->string('sla_profile')->nullable();
                }

                if (!Schema::hasColumn($tableName, 'working_hours')) {
                    $table->string('working_hours')->nullable();
                }

                if (!Schema::hasColumn($tableName, 'timezone')) {
                    $table->string('timezone')->nullable()->default('Asia/Jakarta');
                }

                if (!Schema::hasColumn($tableName, 'enable_email_notifications')) {
                    $table->boolean('enable_email_notifications')->default(true);
                }
            });
        }
    }

    public function down(): void
    {
        // intentionally no-op for production safety
    }
};
