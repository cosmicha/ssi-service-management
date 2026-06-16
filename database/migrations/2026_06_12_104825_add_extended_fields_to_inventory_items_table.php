<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventory_items', function (Blueprint $table) {

            $table->string('manufacturer')->nullable()->after('model');

            $table->string('part_number')->nullable()->after('manufacturer');

            $table->string('vendor')->nullable()->after('part_number');

            $table->string('barcode')->nullable()->after('vendor');

            $table->string('serial_number')->nullable()->after('barcode');

            $table->string('asset_type')->nullable()->after('serial_number');

        });
    }

    public function down(): void
    {
        Schema::table('inventory_items', function (Blueprint $table) {

            $table->dropColumn([
                'manufacturer',
                'part_number',
                'vendor',
                'barcode',
                'serial_number',
                'asset_type',
            ]);

        });
    }
};
