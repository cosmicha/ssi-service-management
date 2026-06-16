<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_photos', function (Blueprint $table) {

            $table->id();

            $table->foreignId('task_id');

            $table->string('photo_type');
            // before, after, issue, completion

            $table->string('photo_path');

            $table->text('notes')
                ->nullable();

            $table->foreignId('uploaded_by')
                ->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_photos');
    }
};
