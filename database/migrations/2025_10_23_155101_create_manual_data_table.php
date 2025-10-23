<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('manual_data', function (Blueprint $table) {
            $table->id(); // PK
            
            // FK ke FARMS 
            $table->foreignId('farm_id')->constrained('farms', 'farm_id')->onDelete('cascade'); 
            
            // FK ke USERS 
            $table->foreignId('user_id_input')->nullable()->constrained('users', 'user_id')->onDelete('set null'); 
            
            $table->date('report_date')->nullable(false); 
            
            // Kolom Data Input Manual
            $table->decimal('konsumsi_pakan', 10, 2)->nullable();
            $table->decimal('konsumsi_air', 10, 2)->nullable();
            $table->integer('jumlah_kematian')->nullable();
            
            $table->timestamps();

            // Constraint: Memastikan hanya ada satu laporan manual per Farm per Tanggal
            $table->unique(['farm_id', 'report_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manual_data');
    }
};