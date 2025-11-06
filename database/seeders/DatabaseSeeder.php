<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; 

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Admin', 'description' => 'Akses penuh ke sistem dan konfigurasi', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Owner', 'description' => 'Pemilik kandang dengan akses laporan dan pengaturan', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Peternak', 'description' => 'Petugas lapangan untuk input data manual', 'created_at' => now(), 'updated_at' => now()],
        ]);

        User::create([
            'role_id' => 1, 
            'username' => 'admin_utama', 
            'email' => 'admin@broilink.com', 
            'password' => Hash::make('password_rahasia'), 
            'name' => 'Admin Utama Broilink', 
            
            'phone_number' => '08123456789',
            'profile_pic' => null,
            'status' => 'active',
            'date_joined' => now()->toDateString(),
            'last_login' => now(),
        ]);
    }
}