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
        Schema::create('farms', function (Blueprint $table) {
            $table->id('farm_id'); // PK
            
            // FK 1: Owner (NOT NULL)
            $table->unsignedBigInteger('owner_id')->nullable(false);
            $table->foreign('owner_id')->references('user_id')->on('users')->onDelete('cascade');
            
            // FK 2: Peternak (NULLABLE)
            $table->unsignedBigInteger('peternak_id')->nullable();
            $table->foreign('peternak_id')->references('user_id')->on('users')->onDelete('set null'); 

            $table->string('farm_name', 100)->nullable(false); 
            $table->string('location', 255)->nullable();
            $table->integer('initial_population')->nullable();
            $table->decimal('initial_weight', 10, 2)->nullable();
            $table->integer('farm_area')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farms');
    }
};
