<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        //untuk hapus table farm data krn udah di split
        Schema::dropIfExists('farm_data'); 
    }

    public function down(): void
    {
        
    }
};