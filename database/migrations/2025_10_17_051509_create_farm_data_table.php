<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('farm_data', function (Blueprint $table) {
            $table->id('data_id');
            
            $table->unsignedBigInteger('farm_id')->nullable(false);
            $table->foreign('farm_id')->references('farm_id')->on('farms')->onDelete('cascade');
            
            $table->unsignedBigInteger('user_id_input')->nullable();
            $table->foreign('user_id_input')->references('user_id')->on('users')->onDelete('set null'); 
            
            $table->dateTime('timestamp')->nullable(false);
            $table->date('report_date')->nullable();
            
            $table->decimal('temperature', 5, 2)->nullable();
            $table->decimal('humidity', 5, 2)->nullable();
            $table->decimal('ammonia', 5, 2)->nullable();
            $table->decimal('konsumsi_pakan', 10, 2)->nullable();
            $table->decimal('konsumsi_air', 10, 2)->nullable();
            
            $table->integer('jumlah_kematian')->nullable();
            $table->string('data_source', 10)->nullable(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('farm_data');
    }
};
