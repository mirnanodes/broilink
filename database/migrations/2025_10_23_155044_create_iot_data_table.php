<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iot_data', function (Blueprint $table) {
            $table->id(); // PK
            
            $table->foreignId('farm_id')->constrained('farms', 'farm_id')->onDelete('cascade'); 
            
            $table->dateTime('timestamp')->nullable(false)->index(); // Wajib diisi

            // Kolom Data Sensor
            $table->decimal('temperature', 5, 2)->nullable();
            $table->decimal('humidity', 5, 2)->nullable();
            $table->decimal('ammonia', 5, 2)->nullable();
            
            // Kolom data_source 
            $table->string('data_source', 10)->default('IOT'); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iot_data');
    }
};