<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data statistik
        $total = 5;
        $menunggu = 2;
        $proses = 2;
        $selesai = 1;

        // Data laporan dummy
        $laporan = collect([
            (object)[
                'id_laporan' => 'R001',
                'status' => 'proses',
                'lokasi' => 'Bleberan, Playen',
                'jumlah_warga' => 245,
                'durasi' => 45,
                'created_at' => now()
            ],
            (object)[
                'id_laporan' => 'R002',
                'status' => 'menunggu',
                'lokasi' => 'Nglipar, Nglipar',
                'jumlah_warga' => 120,
                'durasi' => 30,
                'created_at' => now()
            ],
            (object)[
                'id_laporan' => 'R003',
                'status' => 'selesai',
                'lokasi' => 'Karangmojo, Karangmojo',
                'jumlah_warga' => 80,
                'durasi' => 15,
                'created_at' => now()
            ],
            (object)[
                'id_laporan' => 'R004',
                'status' => 'proses',
                'lokasi' => 'Gedangsari, Gedangsari',
                'jumlah_warga' => 180,
                'durasi' => 38,
                'created_at' => now()
            ],
        ]);

        return view('dashboard', compact(
            'total',
            'menunggu',
            'proses',
            'selesai',
            'laporan'
        ));
    }
}