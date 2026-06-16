<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {

            $table->string('customer_signoff_name')
                ->nullable();

            $table->text('customer_signoff_notes')
                ->nullable();

            $table->timestamp('customer_signed_at')
                ->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {

            $table->dropColumn([
                'customer_signoff_name',
                'customer_signoff_notes',
                'customer_signed_at',
            ]);

        });
    }
};
