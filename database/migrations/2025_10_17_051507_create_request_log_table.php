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
        Schema::create('request_log', function (Blueprint $table) {
            $table->id('request_id'); // PK
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            
            $table->string('sender_name', 50)->nullable();
            $table->string('request_type', 50)->nullable();
            $table->string('request_content', 500)->nullable();
            $table->string('status', 20)->nullable();
            $table->dateTime('sent_time')->nullable(false); // NOT NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_log');
    }
};
