<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
      Schema::create('users', function (Blueprint $table) {
        $table->id('user_id'); 
        $table->string('role', 15)->nullable(false); 
        $table->string('username', 50)->unique()->nullable(false); 
        $table->string('email', 100)->unique()->nullable(false); 
        $table->string('password', 255)->nullable(false); 
        $table->string('name', 100)->nullable(false); 
        $table->string('phone_number', 20)->nullable();
        $table->string('profile_pic', 255)->nullable();
        $table->string('status', 20)->nullable();
        $table->date('date_joined')->nullable();
        $table->dateTime('last_login')->nullable();
        $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};