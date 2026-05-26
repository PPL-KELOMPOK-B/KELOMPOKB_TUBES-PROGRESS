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
            'Purwosari'   => 'Giriasih, Giricahyo, Girijati, Girimulyo, Giripurwo',
            'Panggang'    => 'Giriharjo, Girikarto, Girimulyo, Girisuko, Girisekar',
            'Saptosari'   => 'Jetis, Kanigoro, Kepek, Krambilsawit, Monggol, Ngloro, Planjan, Saptosari',
            'Tanjungsari' => 'Banjarejo, Hargosari, Kemadang, Ngestirejo',
            'Tepus'       => 'Giripanggung, Purwodadi, Sidoharjo, Tepus',
        ];

        foreach ($kecamatanList as $kecamatan => $kelurahan) {
            $namaLower = strtolower($kecamatan);
            User::create([
                'name' => 'Petugas ' . $kecamatan,
                'email' => $namaLower . '@gwm.com',
                'password' => Hash::make($namaLower . '123'),
                'role' => 'petugas',
                'kelurahan' => $kelurahan,
            ]);
        }
    }
}
