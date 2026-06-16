<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('problem_logs', function (Blueprint $table) {
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('in_progress_at')->nullable();
            $table->timestamp('closed_at')->nullable();

            $table->text('close_note')->nullable();
            $table->string('closed_photo')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('problem_logs', function (Blueprint $table) {
            $table->dropColumn([
                'opened_at',
                'in_progress_at',
                'closed_at',
                'close_note',
                'closed_photo'
            ]);
        });
    }
};
