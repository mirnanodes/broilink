<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('farm_config', function (Blueprint $table) {
            $table->id('config_id');
            $table->unsignedBigInteger('farm_id')->nullable(false);
            $table->foreign('farm_id')->references('farm_id')->on('farms')->onDelete('cascade');
            
            $table->string('parameter_name', 50)->nullable(false); 
            $table->decimal('value', 10, 2)->nullable();
            
            $table->unique(['farm_id', 'parameter_name']); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('farm_config');
    }
};
