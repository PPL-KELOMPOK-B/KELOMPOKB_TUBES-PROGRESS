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

    public function createLaporan()
    {
        if (auth()->user()->role !== 'petugas') abort(403);
        return view('petugas.create_laporan');
    }

    public function storeLaporan(Request $request)
    {
        if (auth()->user()->role !== 'petugas') abort(403);

        $rules = [
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'kondisi_air' => 'required|string',
            'warga_terdampak' => 'required|integer',
            'durasi_kekeringan' => 'required|integer',
            'foto_upload' => 'nullable|array|max:3',
            'foto_upload.*' => 'image|max:10240',
            'keterangan' => 'required|string',
        ];

        $messages = [
            'kelurahan.required' => 'Kelurahan wajib dipilih.',
            'kondisi_air.required' => 'Kondisi air wajib dipilih.',
            'warga_terdampak.required' => 'Jumlah warga terdampak wajib diisi.',
            'durasi_kekeringan.required' => 'Durasi kekeringan wajib diisi.',
            'keterangan.required' => 'Keterangan wajib diisi.',
        ];

        // If not just saving a draft, require at least one photo
        if ($request->action !== 'draft') {
            $rules['foto_upload'] = 'required|array|min:1|max:3';
            $messages['foto_upload.required'] = 'Minimal 1 foto wajib diunggah.';
        }

        $request->validate($rules, $messages);

        $fotoPaths = [];
        if ($request->hasFile('foto_upload')) {
            foreach ($request->file('foto_upload') as $file) {
                $fotoPaths[] = $file->store('laporan_fotos', 'public');
            }
        }
        $fotoJson = !empty($fotoPaths) ? json_encode($fotoPaths) : null;

        $laporan = \App\Models\Laporan::create([
            'user_id' => auth()->id(),
            'kecamatan' => $request->kecamatan ?? (auth()->user()->name ?? 'Purwosari'),
            'kelurahan' => $request->kelurahan,
            'kondisi_air' => $request->kondisi_air,
            'warga_terdampak' => $request->warga_terdampak,
            'durasi_kekeringan' => $request->durasi_kekeringan,
            'foto' => $fotoJson,
            'keterangan' => $request->keterangan,
            'status' => 'draft',
        ]);

        if ($request->action === 'preview') {
            return redirect()->route('petugas.preview_laporan', $laporan->id);
        }

        if ($request->action === 'submit') {
            $laporan->update(['status' => 'menunggu_validasi']);
            return redirect()->route('petugas.dashboard')->with('success', 'Laporan berhasil dikirim dan menunggu validasi.');
        }

        return redirect()->route('petugas.dashboard')->with('success', 'Draft laporan berhasil disimpan.');
    }

    public function editLaporan($id)
    {
        if (auth()->user()->role !== 'petugas') abort(403);
        $laporan = \App\Models\Laporan::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        
        return view('petugas.create_laporan', compact('laporan'));
    }

    public function updateLaporan(Request $request, $id)
    {
        if (auth()->user()->role !== 'petugas') abort(403);
        $laporan = \App\Models\Laporan::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $rules = [
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'kondisi_air' => 'required|string',
            'warga_terdampak' => 'required|integer',
            'durasi_kekeringan' => 'required|integer',
            'foto_upload' => 'nullable|array|max:3',
            'foto_upload.*' => 'image|max:10240',
            'keterangan' => 'required|string',
        ];

        $messages = [
            'kelurahan.required' => 'Kelurahan wajib dipilih.',
            'kondisi_air.required' => 'Kondisi air wajib dipilih.',
            'warga_terdampak.required' => 'Jumlah warga terdampak wajib diisi.',
            'durasi_kekeringan.required' => 'Durasi kekeringan wajib diisi.',
            'keterangan.required' => 'Keterangan wajib diisi.',
        ];

        $existingFotos = [];
        if ($laporan->foto) {
            $decoded = json_decode($laporan->foto, true);
            $existingFotos = is_array($decoded) ? $decoded : [$laporan->foto];
        }

        if ($request->filled('removed_fotos')) {
            $removed = json_decode($request->removed_fotos, true);
            if (is_array($removed)) {
                foreach ($removed as $remFile) {
                    if (($key = array_search($remFile, $existingFotos)) !== false) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($remFile);
                        unset($existingFotos[$key]);
                    }
                }
                $existingFotos = array_values($existingFotos);
            }
        }

        $currentFotoCount = count($existingFotos);
        $hasNewFotos = $request->hasFile('foto_upload');

        if ($request->action !== 'draft' && $currentFotoCount == 0 && !$hasNewFotos) {
            $rules['foto_upload'] = 'required|array|min:1|max:3';
            $messages['foto_upload.required'] = 'Minimal 1 foto wajib diunggah/tersedia.';
        }

        $request->validate($rules, $messages);

        if ($request->hasFile('foto_upload')) {
            foreach ($request->file('foto_upload') as $file) {
                if (count($existingFotos) < 3) {
                    $existingFotos[] = $file->store('laporan_fotos', 'public');
                }
            }
        }

        $laporan->foto = !empty($existingFotos) ? json_encode($existingFotos) : null;
        
        $laporan->update([
            'kelurahan' => $request->kelurahan,
            'kondisi_air' => $request->kondisi_air,
            'warga_terdampak' => $request->warga_terdampak,
            'durasi_kekeringan' => $request->durasi_kekeringan,
            'keterangan' => $request->keterangan,
            'foto' => $laporan->foto,
        ]);

        if ($request->action === 'preview') {
            return redirect()->route('petugas.preview_laporan', $laporan->id);
        }

        if ($request->action === 'submit') {
            $laporan->update(['status' => 'menunggu_validasi']);
            return redirect()->route('petugas.dashboard')->with('success', 'Laporan berhasil diperbarui dan dikirim menunggu validasi.');
        }

        return redirect()->route('petugas.dashboard')->with('success', 'Draft laporan berhasil diperbarui.');
    }

    public function deleteFotoLaporan($id)
    {
        if (auth()->user()->role !== 'petugas') return response()->json(['success' => false], 403);
        $laporan = \App\Models\Laporan::where('id', $id)->where('user_id', auth()->id())->first();
        
        if ($laporan && $laporan->foto) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($laporan->foto);
            $laporan->foto = null;
            $laporan->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    public function previewLaporan($id)
    {
        if (auth()->user()->role !== 'petugas') abort(403);
        $laporan = \App\Models\Laporan::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        
        return view('petugas.preview_laporan', compact('laporan'));
    }

    public function submitLaporan(Request $request, $id)
    {
        if (auth()->user()->role !== 'petugas') abort(403);
        $laporan = \App\Models\Laporan::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        
        $laporan->update(['status' => 'menunggu_validasi']);
        
        return redirect()->route('petugas.dashboard')->with('success', 'Laporan berhasil dikirim dan menunggu validasi.');
    }

    public function draftLaporan()
    {
        if (auth()->user()->role !== 'petugas') abort(403);
        $drafts = \App\Models\Laporan::where('user_id', auth()->id())
                    ->where('status', 'draft')
                    ->orderBy('updated_at', 'desc')
                    ->get();
        return view('petugas.draft_laporan', compact('drafts'));
    }

    public function deleteLaporan($id)
    {
        if (auth()->user()->role !== 'petugas') abort(403);
        $laporan = \App\Models\Laporan::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        if ($laporan->foto) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($laporan->foto);
        }
        $laporan->delete();
        return redirect()->back()->with('success', 'Draft laporan berhasil dihapus.');
    }

    public function createPetugas()
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $accounts = \App\Models\User::where('role', 'petugas')->get();
        return view('admin.create_petugas', compact('accounts'));
    }

    public function storePetugas(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403, 'Hanya admin yang dapat membuat akun petugas.');

        $request->validate([
            'name' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users', // using as username/email
            'password' => 'required|string|min:8',
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'kelurahan' => $request->kelurahan,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'petugas',
        ]);

        return redirect()->route('admin.create_petugas')->with('success', 'Akun petugas berhasil dibuat!');
    }
}