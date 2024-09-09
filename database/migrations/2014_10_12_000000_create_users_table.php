<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password', 256);
                $table->string('user_type', 20);/* admin, instructor, student */
                $table->string('image')->nullable();
                $table->string('nid_front')->nullable();
                $table->string('nid_back')->nullable();
                $table->string('log_status')->nullable();
                $table->string('status')->nullable();
                $table->integer('otp')->nullable();
                $table->timestamp('otp_expire_time')->nullable();
                $table->timestamp('delete_data_time')->nullable();
                $table->string('last_active')->nullable();
                $table->rememberToken()->nullable();
                $table->integer('created_by')->nullable();
                $table->integer('updated_by')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'users' );
    }
};
