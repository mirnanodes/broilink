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
        Schema::create('farm_config', function (Blueprint $table) {
            $table->id('config_id'); // PK
            $table->unsignedBigInteger('farm_id')->nullable(false);
            $table->foreign('farm_id')->references('farm_id')->on('farms')->onDelete('cascade');
            
            $table->string('parameter_name', 50)->nullable(false); 
            $table->decimal('value', 10, 2)->nullable();
            
            // Constraint: parameter_name harus UNIK per farm
            $table->unique(['farm_id', 'parameter_name']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farm_config');
    }
};
