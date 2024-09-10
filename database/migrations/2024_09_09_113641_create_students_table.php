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
        // Schema::create('students', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('biography')->nullable();
        //     $table->string('phone');
        //     $table->string('address')->nullable();
        //     $table->string('image')->nullable();
        //     $table->string('email')->nullable();
        //     $table->string('password')->nullable();
        //     $table->string('facebook')->nullable();
        //     $table->string('twitter')->nullable();
        //     $table->string('linkedin')->nullable();
        //     $table->timestamps();
        // });
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('biography')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('user_image')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
