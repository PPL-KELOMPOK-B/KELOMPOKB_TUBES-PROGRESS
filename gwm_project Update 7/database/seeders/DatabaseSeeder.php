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
        // Admin
        User::create([
            'name' => 'Admin GWM',
            'email' => 'admin@gwm.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Petugas per Kecamatan
        $kecamatanList = [
            'Purwosari',
            'Panggang',
            'Saptosari',
            'Tanjungsari',
            'Tepus',
        ];

        foreach ($kecamatanList as $kecamatan) {
            $namaLower = strtolower($kecamatan);
            User::create([
                'name' => 'Petugas ' . $kecamatan,
                'email' => $namaLower . '@gwm.com',
                'password' => Hash::make($namaLower . '123'),
                'role' => 'petugas',
            ]);
        }
    }
}
