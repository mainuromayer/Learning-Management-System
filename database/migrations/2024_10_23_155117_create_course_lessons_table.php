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
        Schema::create('course_lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('course_section_id')->constrained('course_sections')->onDelete('cascade');
            $table->string('lesson_type');
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->string('iframe')->nullable();
            $table->json('google_drive')->nullable();
            $table->json('document')->nullable();
            $table->json('attachment')->nullable();
            $table->time('duration')->nullable();
            $table->text('text')->nullable();
            $table->text('summary')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_lessons');
    }
};
