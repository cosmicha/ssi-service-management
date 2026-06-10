<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'customer_access_scope')) {
                $table->string('customer_access_scope')->default('ho')->after('customer_id');
            }

            if (!Schema::hasColumn('users', 'customer_branch_id')) {
                $table->foreignId('customer_branch_id')
                    ->nullable()
                    ->after('customer_access_scope')
                    ->constrained('customer_branches')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'customer_branch_id')) {
                $table->dropConstrainedForeignId('customer_branch_id');
            }

            if (Schema::hasColumn('users', 'customer_access_scope')) {
                $table->dropColumn('customer_access_scope');
            }
        });
    }
};
