<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //drop kolom role
            $table->dropColumn('role'); 
            
            
            $table->foreignId('role_id')
                  ->nullable()
                  ->after('user_id') 
                  ->constrained('roles') 
                  ->onDelete('set null'); 
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rollback: Hapus Foreign Key
            $table->dropConstrainedForeignId('role_id'); 
            
            // Rollback: Kembalikan kolom 'role' lama
            $table->string('role', 15)->after('user_id')->nullable(false); 
        });
    }
};