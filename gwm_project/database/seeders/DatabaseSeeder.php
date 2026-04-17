<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin GWM',
            'email' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Petugas Kecamatan',
            'email' => 'petugas', // For easier testing, changed to just 'petugas'
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
        ]);
    }
}
