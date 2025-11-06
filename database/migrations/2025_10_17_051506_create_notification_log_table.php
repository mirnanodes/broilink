<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_log', function (Blueprint $table) {
            $table->id('notif_id');

            $table->unsignedBigInteger('sender_user_id')->nullable();
            $table->foreign('sender_user_id')->references('user_id')->on('users')->onDelete('set null');

            $table->unsignedBigInteger('recipient_user_id')->nullable();
            $table->foreign('recipient_user_id')->references('user_id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('farm_id')->nullable();
            $table->foreign('farm_id')->references('farm_id')->on('farms')->onDelete('cascade');

            $table->string('notification_type', 20)->nullable();
            $table->string('message_content', 500)->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->string('status', 20)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_log');
    }
};
