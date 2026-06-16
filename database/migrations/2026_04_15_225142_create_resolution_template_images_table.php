<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resolution_template_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resolution_template_id');
            $table->string('image_path');
            $table->timestamps();

            $table->foreign('resolution_template_id')
                ->references('id')
                ->on('resolution_templates')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resolution_template_images');
    }
};
