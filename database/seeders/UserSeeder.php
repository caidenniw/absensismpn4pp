<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@absensi.com',
        //     'password' => Hash::make('admin'),
        //     'role' => 'admin',
        // ]);

        User::updateOrCreate(
            // Kondisi pencarian record
            ['email' => 'admin@absensi.com'],

            // Data yang akan diupdate atau dibuat
            [
                'name' => 'Admin',
                'password' => Hash::make('admin'),
                'role' => 'admin',
            ]
        );

        // User::factory()->count(5)->create();
    }
}
