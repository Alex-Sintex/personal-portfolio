<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('category_lesson', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');  // Use unsignedBigInteger
            $table->unsignedBigInteger('lesson_id');    // Use unsignedBigInteger
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');

            // Add unique constraint to avoid duplicate relationships
            $table->unique(['category_id', 'lesson_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_lesson');
    }
};
