<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Farm;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // TODO: Run this seeder with: php artisan db:seed --class=SampleDataSeeder
        
        // NOTE: Make sure roles are already seeded (run DatabaseSeeder first)
        
        // Create Owner User
        $owner = User::create([
            'role_id' => 2,
            'username' => 'john_owner',
            'email' => 'owner@broilink.com',
            'password' => Hash::make('owner123'),
            'name' => 'John Owner',
            'phone_number' => '081234567891',
            'status' => 'active',
            'date_joined' => now()->toDateString(),
            'last_login' => now(),
        ]);

        // Create Peternak Users
        $peternak1 = User::create([
            'role_id' => 3,
            'username' => 'budi_peternak',
            'email' => 'budi@broilink.com',
            'password' => Hash::make('peternak123'),
            'name' => 'Budi Santoso',
            'phone_number' => '081234567892',
            'status' => 'active',
            'date_joined' => now()->toDateString(),
            'last_login' => now(),
        ]);

        $peternak2 = User::create([
            'role_id' => 3,
            'username' => 'ahmad_peternak',
            'email' => 'ahmad@broilink.com',
            'password' => Hash::make('peternak123'),
            'name' => 'Ahmad Wijaya',
            'phone_number' => '081234567893',
            'status' => 'active',
            'date_joined' => now()->toDateString(),
            'last_login' => now(),
        ]);

        // Create Sample Farms
        $farm1 = Farm::create([
            'owner_id' => $owner->id,
            'peternak_id' => $peternak1->id,
            'farm_name' => 'Farm Broiler Yogyakarta A',
            'location' => 'Sleman, Yogyakarta',
            'latitude' => -7.7456,
            'longitude' => 110.4389,
            'farm_area' => 500.00,
            'capacity' => 5000,
            'current_cycle' => 1,
            'status' => 'active',
        ]);

        $farm2 = Farm::create([
            'owner_id' => $owner->id,
            'peternak_id' => $peternak2->id,
            'farm_name' => 'Farm Broiler Bantul',
            'location' => 'Bantul, Yogyakarta',
            'latitude' => -7.8883,
            'longitude' => 110.3293,
            'farm_area' => 300.00,
            'capacity' => 3000,
            'current_cycle' => 2,
            'status' => 'active',
        ]);

        $farm3 = Farm::create([
            'owner_id' => $owner->id,
            'farm_name' => 'Farm Broiler Kulon Progo',
            'location' => 'Wates, Kulon Progo',
            'latitude' => -7.8567,
            'longitude' => 110.1591,
            'farm_area' => 400.00,
            'capacity' => 4000,
            'current_cycle' => 1,
            'status' => 'maintenance',
        ]);

        // TODO: Add farm configurations
        // DB::table('farm_config')->insert([...]);
        
        // TODO: Add sample IoT data
        // DB::table('iot_data')->insert([...]);
        
        // TODO: Add sample manual data
        // DB::table('manual_data')->insert([...]);

        $this->command->info('Sample data seeded successfully!');
        $this->command->info('');
        $this->command->info('Login Credentials:');
        $this->command->info('Admin: admin_utama / password_rahasia');
        $this->command->info('Owner: john_owner / owner123');
        $this->command->info('Peternak 1: budi_peternak / peternak123');
        $this->command->info('Peternak 2: ahmad_peternak / peternak123');
    }
}
