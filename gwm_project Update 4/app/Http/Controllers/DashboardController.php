<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private function getDashboardData($userId = null)
    {
        $query = \App\Models\Laporan::where('status', '!=', 'draft');
        
        if ($userId) {
            $query->where('user_id', $userId);
        }

        $allReports = $query->get();

        // Calculate stats
        $stats = [
            'total' => $allReports->count(),
            'kritis' => $allReports->where('kondisi_air', 'Kritis')->count(),
            'warga_terdampak' => $allReports->sum('warga_terdampak'),
            'tervalidasi' => $allReports->whereIn('status', ['selesai', 'proses'])->count(), 
            'menunggu' => $allReports->where('status', 'menunggu_validasi')->count(),
            'proses' => $allReports->where('status', 'proses')->count(),
            'selesai' => $allReports->where('status', 'selesai')->count(),
        ];

        // Drought distribution mapping
        $distKekeringan = [
            'Rendah' => 0,
            'Sedang' => 0,
            'Tinggi' => 0,
            'Kritis' => 0,
        ];

        foreach ($allReports as $lap) {
            if ($lap->kondisi_air == 'Ketersediaan air mulai berkurang') $distKekeringan['Sedang']++;
            elseif ($lap->kondisi_air == 'Ketersediaan air tidak mencukupi') $distKekeringan['Tinggi']++;
            elseif ($lap->kondisi_air == 'Air tidak tersedia') $distKekeringan['Kritis']++;
            else $distKekeringan['Rendah']++;
        }

        $stats['distribusi_kekeringan'] = $distKekeringan;
        $stats['kritis'] = $distKekeringan['Kritis'];

        // Area distribution (for bar chart)
        $stats['distribusi_area'] = $allReports->groupBy('kelurahan')
            ->map(fn($laps) => $laps->sum('warga_terdampak'))
            ->toArray();

        // Latest reports
        $stats['laporan'] = $allReports->sortByDesc('created_at')->take(5);

        return $stats;
    }

    public function adminIndex()
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $data = $this->getDashboardData();
        return view('admin.dashboard', $data);
    }

    public function petugasIndex()
    {
        if (auth()->user()->role !== 'petugas') abort(403);
        $data = $this->getDashboardData(auth()->id());
        return view('petugas.dashboard', $data);
    }

    public function laporanIndex(Request $request)
    {
        if (auth()->user()->role !== 'petugas') abort(403);
        
        $query = \App\Models\Laporan::where('user_id', auth()->id())
                    ->where('status', '!=', 'draft');

        if ($request->filled('search')) {
            $query->where('kelurahan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status') && $request->status !== 'Semua Status') {
            $query->where('status', strtolower(str_replace(' ', '_', $request->status)));
        }

        $laporans = $query->orderBy('created_at', 'desc')->get();
        
        return view('petugas.laporan', compact('laporans'));
    }

    public function showLaporan($id)
    {
        if (auth()->user()->role !== 'petugas') abort(403);
        $laporan = \App\Models\Laporan::where('id', $id)
                    ->where('user_id', auth()->id())
                    ->where('status', '!=', 'draft')
                    ->firstOrFail();
        return view('petugas.show_laporan', compact('laporan'));
    }

    public function editLaporanList($id)
    {
        if (auth()->user()->role !== 'petugas') abort(403);
        $laporan = \App\Models\Laporan::where('id', $id)
                    ->where('user_id', auth()->id())
                    ->where('status', '!=', 'draft')
                    ->firstOrFail();

        if (!$laporan->isEditable()) {
            return redirect()->route('petugas.show_laporan', $id)
                ->with('error', 'Laporan tidak dapat diedit setelah divalidasi oleh Admin.');
        }

        $kecamatanList = [
            'Purwosari'   => ['Giriasih', 'Giricahyo', 'Girijati'],
            'Panggang'    => ['Giriharjo', 'Girijati Panggang'],
            'Saptosari'   => ['Jetis', 'Planjan'],
            'Tanjungsari' => ['Kemadang', 'Banjarejo'],
            'Tepus'       => ['Tepus', 'Purwodadi'],
        ];
        $userKecamatan = trim(str_replace('Petugas', '', auth()->user()->name));
        $kelurahans    = $kecamatanList[$userKecamatan] ?? [];

        return view('petugas.edit_laporan_list', compact('laporan', 'kelurahans'));
    }

    public function updateLaporanFromList(Request $request, $id)
    {
        if (auth()->user()->role !== 'petugas') abort(403);
        $laporan = \App\Models\Laporan::where('id', $id)
                    ->where('user_id', auth()->id())
                    ->firstOrFail();

        // Business rule: hanya bisa edit jika masih menunggu validasi
        if (!$laporan->isEditable()) {
            return redirect()->route('petugas.laporan.index')
                ->with('error', 'Laporan tidak dapat diedit setelah divalidasi.');
        }

        $request->validate([
            'kelurahan'         => 'required|string',
            'kondisi_air'       => 'required|string',
            'warga_terdampak'   => 'required|integer|min:0',
            'durasi_kekeringan' => 'required|integer|min:0',
            'keterangan'        => 'required|string',
            'foto_upload'       => 'nullable|array|max:3',
            'foto_upload.*'     => 'image|max:10240',
        ], [
            'kelurahan.required'         => 'Kelurahan wajib dipilih.',
            'kondisi_air.required'       => 'Kondisi air wajib dipilih.',
            'warga_terdampak.required'   => 'Jumlah warga terdampak wajib diisi.',
            'durasi_kekeringan.required' => 'Durasi kekeringan wajib diisi.',
            'keterangan.required'        => 'Keterangan wajib diisi.',
        ]);

        // Kelola foto
        $existingFotos = [];
        if ($laporan->foto) {
            $decoded = json_decode($laporan->foto, true);
            $existingFotos = is_array($decoded) ? $decoded : [$laporan->foto];
        }

        if ($request->filled('removed_fotos')) {
            $removed = json_decode($request->removed_fotos, true);
            if (is_array($removed)) {
                foreach ($removed as $path) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
                    $existingFotos = array_values(array_filter($existingFotos, fn($f) => $f !== $path));
                }
            }
        }

        if ($request->hasFile('foto_upload')) {
            foreach ($request->file('foto_upload') as $file) {
                if (count($existingFotos) < 3) {
                    $existingFotos[] = $file->store('laporan_fotos', 'public');
                }
            }
        }

        $laporan->update([
            'kelurahan'         => $request->kelurahan,
            'kondisi_air'       => $request->kondisi_air,
            'warga_terdampak'   => $request->warga_terdampak,
            'durasi_kekeringan' => $request->durasi_kekeringan,
            'keterangan'        => $request->keterangan,
            'foto'              => !empty($existingFotos) ? json_encode(array_values($existingFotos)) : null,
        ]);

        return redirect()->route('petugas.laporan.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function createLaporan()
    {
        if (auth()->user()->role !== 'petugas') abort(403);
        
        $kecamatanList = [
            'Purwosari' => ['Giriasih', 'Giricahyo', 'Girijati'],
            'Panggang' => ['Giriharjo', 'Girijati Panggang'],
            'Saptosari' => ['Jetis', 'Planjan'],
            'Tanjungsari' => ['Kemadang', 'Banjarejo'],
            'Tepus' => ['Tepus', 'Purwodadi']
        ];
        
        $userKecamatan = trim(str_replace('Petugas', '', auth()->user()->name));
        $kelurahans = $kecamatanList[$userKecamatan] ?? [];

        return view('petugas.create_laporan', compact('kelurahans'));
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
            'kecamatan' => $request->kecamatan ?? str_replace('Petugas ', '', auth()->user()->name ?? 'Purwosari'),
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
        
        $kecamatanList = [
            'Purwosari' => ['Giriasih', 'Giricahyo', 'Girijati'],
            'Panggang' => ['Giriharjo', 'Girijati Panggang'],
            'Saptosari' => ['Jetis', 'Planjan'],
            'Tanjungsari' => ['Kemadang', 'Banjarejo'],
            'Tepus' => ['Tepus', 'Purwodadi']
        ];
        
        $userKecamatan = trim(str_replace('Petugas', '', auth()->user()->name));
        $kelurahans = $kecamatanList[$userKecamatan] ?? [];

        return view('petugas.create_laporan', compact('laporan', 'kelurahans'));
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

    public function adminValidasi()
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $laporans = \App\Models\Laporan::where('status', '!=', 'draft')->orderBy('created_at', 'desc')->get();
        return view('admin.validasi', compact('laporans'));
    }

    public function adminValidasiDetail($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $laporan = \App\Models\Laporan::findOrFail($id);
        return view('admin.validasi_detail', compact('laporan'));
    }

    public function adminValidasiAction(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $laporan = \App\Models\Laporan::findOrFail($id);
        
        $action = $request->input('action'); // 'approve' or 'reject'
        
        if ($action === 'approve') {
            $laporan->update(['status' => 'diterima']);
        } elseif ($action === 'reject') {
            $laporan->update(['status' => 'ditolak']);
        }

        return redirect()->route('admin.validasi.index')->with('success', 'Status validasi laporan berhasil diperbarui.');
    }
}