<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private function getDashboardData()
    {
        // Data statistik dummy
        return [
            'total' => 5,
            'menunggu' => 2,
            'proses' => 2,
            'selesai' => 1,
            'laporan' => collect([
                (object)['id_laporan' => 'R001', 'status' => 'proses', 'lokasi' => 'Bleberan, Playen', 'jumlah_warga' => 245, 'durasi' => 45, 'created_at' => now()],
                (object)['id_laporan' => 'R002', 'status' => 'menunggu', 'lokasi' => 'Nglipar, Nglipar', 'jumlah_warga' => 120, 'durasi' => 30, 'created_at' => now()],
                (object)['id_laporan' => 'R003', 'status' => 'selesai', 'lokasi' => 'Karangmojo, Karangmojo', 'jumlah_warga' => 80, 'durasi' => 15, 'created_at' => now()],
                (object)['id_laporan' => 'R004', 'status' => 'proses', 'lokasi' => 'Gedangsari, Gedangsari', 'jumlah_warga' => 180, 'durasi' => 38, 'created_at' => now()],
            ])
        ];
    }

    public function adminIndex()
    {
        if (auth()->user()->role !== 'admin') abort(403);
        return view('admin.dashboard', $this->getDashboardData());
    }

    public function petugasIndex()
    {
        if (auth()->user()->role !== 'petugas') abort(403);
        return view('petugas.dashboard', $this->getDashboardData());
    }

    public function createPetugas()
    {
        if (auth()->user()->role !== 'admin') abort(403);
        return view('admin.create_petugas');
    }

    public function storePetugas(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403, 'Hanya admin yang dapat membuat akun petugas.');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users', // using as username/email
            'password' => 'required|string|min:8',
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'petugas',
        ]);

        return redirect()->route('admin.create_petugas')->with('success', 'Akun petugas berhasil dibuat!');
    }
}