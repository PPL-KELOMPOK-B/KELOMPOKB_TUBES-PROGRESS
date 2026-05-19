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

        
        $stats = [
            'total' => $allReports->count(),
            'kritis' => $allReports->where('kondisi_air', 'Kritis')->count(),
            'warga_terdampak' => $allReports->sum('warga_terdampak'),
            'tervalidasi' => $allReports->whereIn('status', ['selesai', 'proses', 'diterima'])->count(), 
            'tidak_tervalidasi' => $allReports->where('status', 'ditolak')->count(),
            'menunggu' => $allReports->where('status', 'menunggu_validasi')->count(),
            'proses' => $allReports->where('status', 'proses')->count(),
            'selesai' => $allReports->where('status', 'selesai')->count(),
        ];

        
        $distKekeringan = [
            'Sedang' => 0,
            'Tinggi' => 0,
            'Kritis' => 0,
        ];

        foreach ($allReports as $lap) {
            $score = $this->calculatePriorityScore($lap);
            $level = $this->getPriorityLevel($score);
            $distKekeringan[$level]++;
        }

        $stats['distribusi_kekeringan'] = $distKekeringan;
        $stats['sedang'] = $distKekeringan['Sedang'];
        $stats['tinggi'] = $distKekeringan['Tinggi'];
        $stats['kritis'] = $distKekeringan['Kritis'];

        
        $stats['distribusi_area'] = $allReports->groupBy('kelurahan')
            ->map(fn($laps) => $laps->sum('warga_terdampak'))
            ->toArray();

        
        $stats['laporan'] = $allReports->sortByDesc('created_at')->take(5);

        return $stats;
    }

    public function adminIndex()
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $data = $this->getDashboardData();

        $laporanPrioritas = \App\Models\Laporan::where('status', '!=', 'draft')
            ->with('user')
            ->get();

        $laporanPrioritas->each(function ($laporan) {
            $score = $this->calculatePriorityScore($laporan);
            $laporan->skor_prioritas = $score;
            $laporan->tingkat = $this->getPriorityLevel($score);
            $laporan->kode = 'R' . str_pad($laporan->id, 3, '0', STR_PAD_LEFT);

            // Variabel untuk Dashboard View
            $laporan->tipe = strtolower($laporan->tingkat);
            $laporan->status_text = $laporan->tingkat;
            $laporan->tingkat_kekeringan = $laporan->tingkat;

            if ($laporan->tingkat === 'Kritis') {
                $laporan->tingkat_color = '#ef4444';
                $laporan->tingkat_bg = '#fef2f2';
                $laporan->tingkat_border = '#fecaca';
                $laporan->warna_text = 'Merah';
                $laporan->desc = 'Kondisi darurat, semua sumber air mengering. Diperlukan bantuan segera.';
            } elseif ($laporan->tingkat === 'Tinggi') {
                $laporan->tingkat_color = '#f97316';
                $laporan->tingkat_bg = '#fff7ed';
                $laporan->tingkat_border = '#fed7aa';
                $laporan->warna_text = 'Oranye';
                $laporan->desc = 'Kondisi kekeringan parah, sumber air mulai menipis. Membutuhkan bantuan.';
            } else {
                $laporan->tingkat_color = '#eab308';
                $laporan->tingkat_bg = '#fefce8';
                $laporan->tingkat_border = '#fde68a';
                $laporan->warna_text = 'Kuning';
                $laporan->desc = 'Kondisi mulai kering, ketersediaan air berkurang. Perlu pemantauan.';
            }
        });

        $sortedLaporan = $laporanPrioritas->sort(function ($a, $b) {
            $tingkatBobot = ['Kritis' => 3, 'Tinggi' => 2, 'Sedang' => 1];
            $bobotA = $tingkatBobot[$a->tingkat] ?? 0;
            $bobotB = $tingkatBobot[$b->tingkat] ?? 0;

            if ($bobotA != $bobotB) {
                return $bobotB <=> $bobotA;
            }
            if ($a->warga_terdampak != $b->warga_terdampak) {
                return $b->warga_terdampak <=> $a->warga_terdampak;
            }
            if ($a->durasi_kekeringan != $b->durasi_kekeringan) {
                return $b->durasi_kekeringan <=> $a->durasi_kekeringan;
            }
            return $b->skor_prioritas <=> $a->skor_prioritas;
        })->values();

        $data['laporanPrioritas'] = $sortedLaporan->take(10);

        // Keterangan Ranking (4 tertinggi)
        $data['desaRanking'] = $sortedLaporan->take(4);

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
            if ($request->status === 'Tervalidasi') {
                $query->whereIn('status', ['diterima', 'proses', 'selesai']);
            } elseif ($request->status === 'Tidak tervalidasi') {
                $query->where('status', 'ditolak');
            } else {
                $query->where('status', strtolower(str_replace(' ', '_', $request->status)));
            }
        }

        $laporans = $query->with('tindakLanjuts')->orderBy('created_at', 'desc')->get();
        
        return view('petugas.laporan', compact('laporans'));
    }

    public function showLaporan($id)
    {
        if (auth()->user()->role !== 'petugas') abort(403);
        $laporan = \App\Models\Laporan::where('id', $id)
                    ->where('user_id', auth()->id())
                    ->where('status', '!=', 'draft')
                    ->with('tindakLanjuts')
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

        $kelurahanString = auth()->user()->kelurahan;
        $kelurahans = $kelurahanString ? array_map('trim', explode(',', $kelurahanString)) : [];

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
        
        $kelurahanString = auth()->user()->kelurahan;
        $kelurahans = $kelurahanString ? array_map('trim', explode(',', $kelurahanString)) : [];

        return view('petugas.create_laporan', compact('kelurahans'));
    }

    public function storeLaporan(Request $request)
    {
        if (auth()->user()->role !== 'petugas') abort(403);

        $rules = [
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'kondisi_air' => 'required|string',
            'warga_terdampak' => 'required|integer|min:1',
            'durasi_kekeringan' => 'required|integer|min:1',
            'foto_upload' => 'nullable|array|max:3',
            'foto_upload.*' => 'image|max:10240',
            'keterangan' => 'required|string',
        ];

        if ($request->action === 'draft') {
            if (empty($request->kelurahan) && empty($request->kondisi_air) && 
                empty($request->warga_terdampak) && empty($request->durasi_kekeringan) && 
                empty($request->keterangan) && !$request->hasFile('foto_upload')) {
                return redirect()->back()->withInput()->with('error', 'Minimal satu field harus diisi untuk menyimpan draft.');
            }

            $rules = [
                'kecamatan' => 'nullable|string',
                'kelurahan' => 'nullable|string',
                'kondisi_air' => 'nullable|string',
                'warga_terdampak' => 'nullable|integer|min:1',
                'durasi_kekeringan' => 'nullable|integer|min:1',
                'foto_upload' => 'nullable|array|max:3',
                'foto_upload.*' => 'image|max:10240',
                'keterangan' => 'nullable|string',
            ];
        }

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
        
        $kelurahanString = auth()->user()->kelurahan;
        $kelurahans = $kelurahanString ? array_map('trim', explode(',', $kelurahanString)) : [];

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
            'warga_terdampak' => 'required|integer|min:1',
            'durasi_kekeringan' => 'required|integer|min:1',
            'foto_upload' => 'nullable|array|max:3',
            'foto_upload.*' => 'image|max:10240',
            'keterangan' => 'required|string',
        ];

        if ($request->action === 'draft') {
            $existingFotosCount = $laporan->foto ? count(json_decode($laporan->foto, true) ?? [$laporan->foto]) : 0;
            $removedCount = $request->filled('removed_fotos') ? count(json_decode($request->removed_fotos, true) ?? []) : 0;
            $finalFotosCount = $existingFotosCount - $removedCount + ($request->hasFile('foto_upload') ? count($request->file('foto_upload')) : 0);

            if (empty($request->kelurahan) && empty($request->kondisi_air) && 
                empty($request->warga_terdampak) && empty($request->durasi_kekeringan) && 
                empty($request->keterangan) && $finalFotosCount == 0) {
                return redirect()->back()->withInput()->with('error', 'Minimal satu field harus diisi untuk menyimpan draft.');
            }

            $rules = [
                'kecamatan' => 'nullable|string',
                'kelurahan' => 'nullable|string',
                'kondisi_air' => 'nullable|string',
                'warga_terdampak' => 'nullable|integer|min:1',
                'durasi_kekeringan' => 'nullable|integer|min:1',
                'foto_upload' => 'nullable|array|max:3',
                'foto_upload.*' => 'image|max:10240',
                'keterangan' => 'nullable|string',
            ];
        }

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
            'kelurahan' => 'required|array',
            'kelurahan.*' => 'string|max:255',
            'email' => 'required|string|max:255|unique:users', // using as username/email
            'password' => 'required|string|min:8',
        ], [
            'kelurahan.required' => 'Kelurahan wajib dipilih minimal satu.',
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'kelurahan' => implode(', ', $request->kelurahan),
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'petugas',
        ]);

        return redirect()->route('admin.create_petugas')->with('success', 'Akun petugas berhasil dibuat!');
    }

    public function deletePetugas($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $user = \App\Models\User::where('id', $id)->where('role', 'petugas')->firstOrFail();
        $user->delete();
        return redirect()->back()->with('success_delete', 'Akun petugas berhasil dihapus!');
    }

    public function klasifikasiKekeringan($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $laporan = \App\Models\Laporan::with('user')->findOrFail($id);

        // ===== SCORING SYSTEM =====
        // Factor 1: Kondisi Air (Bobot 50%) - Primary classification factor
        if ($laporan->kondisi_air === 'Air tidak tersedia') {
            $skor_kondisi = 3;
            $label_kondisi = 'Air tidak tersedia';
            $desc_kondisi = 'Seluruh sumber air di wilayah ini telah mengering sepenuhnya. Tidak ada akses air bersih bagi warga.';
        } elseif ($laporan->kondisi_air === 'Ketersediaan air tidak mencukupi') {
            $skor_kondisi = 2;
            $label_kondisi = 'Air tidak mencukupi';
            $desc_kondisi = 'Sumber air yang tersedia tidak mampu memenuhi kebutuhan warga. Pasokan air semakin menipis.';
        } else {
            $skor_kondisi = 1;
            $label_kondisi = 'Air mulai berkurang';
            $desc_kondisi = 'Ketersediaan air mulai menunjukkan penurunan. Beberapa sumber air mengalami penyusutan debit.';
        }

        // Factor 2: Durasi Kekeringan (Bobot 30%)
        $durasi = $laporan->durasi_kekeringan ?? 0;
        if ($durasi >= 30) {
            $skor_durasi = 3;
            $label_durasi = 'Sangat Lama (≥ 30 hari)';
            $desc_durasi = 'Kekeringan telah berlangsung lebih dari 30 hari. Dampak jangka panjang sangat mungkin terjadi.';
        } elseif ($durasi >= 14) {
            $skor_durasi = 2;
            $label_durasi = 'Lama (14–29 hari)';
            $desc_durasi = 'Kekeringan berlangsung selama 2-4 minggu. Cadangan air semakin menipis secara signifikan.';
        } else {
            $skor_durasi = 1;
            $label_durasi = 'Singkat (< 14 hari)';
            $desc_durasi = 'Kekeringan baru berlangsung kurang dari dua minggu. Masih dalam tahap awal.';
        }

        // Factor 3: Warga Terdampak (Bobot 20%)
        $warga = $laporan->warga_terdampak ?? 0;
        if ($warga >= 200) {
            $skor_warga = 3;
            $label_warga = 'Sangat Banyak (≥ 200 orang)';
            $desc_warga = 'Lebih dari 200 warga terdampak langsung. Dibutuhkan respons berskala besar.';
        } elseif ($warga >= 100) {
            $skor_warga = 2;
            $label_warga = 'Banyak (100–199 orang)';
            $desc_warga = 'Jumlah warga terdampak cukup besar. Perlu penanganan segera dan terkoordinasi.';
        } else {
            $skor_warga = 1;
            $label_warga = 'Sedikit (< 100 orang)';
            $desc_warga = 'Dampak masih terbatas pada sejumlah kecil warga. Tetap perlu pemantauan.';
        }

        // Calculate weighted total score
        $bobot_kondisi = 50;
        $bobot_durasi = 30;
        $bobot_warga = 20;

        $nilai_kondisi = ($skor_kondisi / 3) * $bobot_kondisi;
        $nilai_durasi = ($skor_durasi / 3) * $bobot_durasi;
        $nilai_warga = ($skor_warga / 3) * $bobot_warga;
        $total_skor = $nilai_kondisi + $nilai_durasi + $nilai_warga;

        // Determine classification based on total weighted score
        if ($total_skor >= 75) {
            $tingkat_kekeringan = 'Kritis';
        } elseif ($total_skor >= 50) {
            $tingkat_kekeringan = 'Tinggi';
        } else {
            $tingkat_kekeringan = 'Sedang';
        }

        // Build scoring data array
        $scoring = [
            'total_skor' => round($total_skor, 1),
            'faktor' => [
                [
                    'nama' => 'Kondisi Air',
                    'bobot' => $bobot_kondisi,
                    'skor' => $skor_kondisi,
                    'max_skor' => 3,
                    'nilai' => round($nilai_kondisi, 1),
                    'label' => $label_kondisi,
                    'deskripsi' => $desc_kondisi,
                    'persen' => round(($skor_kondisi / 3) * 100),
                ],
                [
                    'nama' => 'Durasi Kekeringan',
                    'bobot' => $bobot_durasi,
                    'skor' => $skor_durasi,
                    'max_skor' => 3,
                    'nilai' => round($nilai_durasi, 1),
                    'label' => $label_durasi,
                    'deskripsi' => $desc_durasi,
                    'persen' => round(($skor_durasi / 3) * 100),
                    'detail' => $durasi . ' hari',
                ],
                [
                    'nama' => 'Warga Terdampak',
                    'bobot' => $bobot_warga,
                    'skor' => $skor_warga,
                    'max_skor' => 3,
                    'nilai' => round($nilai_warga, 1),
                    'label' => $label_warga,
                    'deskripsi' => $desc_warga,
                    'persen' => round(($skor_warga / 3) * 100),
                    'detail' => number_format($warga) . ' orang',
                ],
            ],
        ];

        return view('admin.klasifikasi_kekeringan', compact('laporan', 'tingkat_kekeringan', 'scoring'));
    }

    public function levelKondisi($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $laporan = \App\Models\Laporan::with('user')->findOrFail($id);

        $skor = $this->calculatePriorityScore($laporan);
        $tingkat = $this->getPriorityLevel($skor);

        $laporan->skor_prioritas = $skor;
        $laporan->tingkat_kekeringan = $tingkat;

        if ($tingkat === 'Kritis') {
            $laporan->tingkat_color = '#ef4444';
            $laporan->tingkat_bg = '#fef2f2';
            $laporan->desc = 'Kondisi darurat, semua sumber air mengering. Diperlukan bantuan segera. Kondisi ini berpotensi berdampak besar terhadap kebutuhan dasar masyarakat, seperti air minum dan sanitasi. Berdasarkan parameter seperti kondisi air yang sangat terbatas dan durasi kekeringan yang tinggi, sistem mengklasifikasikan wilayah tersebut ke dalam level kondisi Kritis/Darurat.';
        } elseif ($tingkat === 'Tinggi') {
            $laporan->tingkat_color = '#f97316';
            $laporan->tingkat_bg = '#fff7ed';
            $laporan->desc = 'Kondisi kekeringan parah, sumber air mulai menipis secara signifikan. Berdasarkan parameter sistem, wilayah tersebut diklasifikasikan ke dalam level kondisi Tinggi/Siaga.';
        } else {
            $laporan->tingkat_color = '#eab308';
            $laporan->tingkat_bg = '#fefce8';
            $laporan->desc = 'Kondisi mulai kering, ketersediaan air berkurang namun masih dapat memenuhi sebagian kebutuhan. Sistem mengklasifikasikan wilayah tersebut ke dalam level kondisi Sedang/Waspada.';
        }

        return view('admin.level_kondisi', compact('laporan', 'tingkat'));
    }

    public function adminPrioritas(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        // Hanya ambil laporan yang SUDAH TERVALIDASI (diterima, proses, selesai)
        $validatedStatuses = ['diterima', 'proses', 'selesai'];

        $query = \App\Models\Laporan::whereIn('status', $validatedStatuses)->with('user');

        // Filter opsional berdasarkan kecamatan
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', 'like', '%' . $request->kecamatan . '%');
        }

        // Filter opsional berdasarkan prioritas (tingkat kekeringan)
        $filterPrioritas = $request->input('prioritas', '');

        $laporans = $query->get();

        // Hitung skor prioritas untuk setiap laporan
        $laporans = $laporans->map(function ($lap) {
            $lap->skor_prioritas = $this->calculatePriorityScore($lap);
            $lap->tingkat = $this->getPriorityLevel($lap->skor_prioritas);

            if ($lap->tingkat === 'Kritis') {
                $lap->tingkat_color = '#ef4444';
                $lap->tingkat_bg = '#fef2f2';
                $lap->tingkat_border = '#fecaca';
            } elseif ($lap->tingkat === 'Tinggi') {
                $lap->tingkat_color = '#ea580c';
                $lap->tingkat_bg = '#fff7ed';
                $lap->tingkat_border = '#fed7aa';
            } else {
                $lap->tingkat = 'Sedang';
                $lap->tingkat_color = '#a16207';
                $lap->tingkat_bg = '#fefce8';
                $lap->tingkat_border = '#fde68a';
            }

            // Label kondisi air
            if ($lap->kondisi_air === 'Air tidak tersedia') {
                $lap->label_kondisi = 'Air tidak tersedia';
            } elseif ($lap->kondisi_air === 'Ketersediaan air tidak mencukupi') {
                $lap->label_kondisi = 'Air tidak mencukupi';
            } else {
                $lap->label_kondisi = 'Air mulai berkurang';
            }

            return $lap;
        });

        // Filter berdasarkan tingkat jika diminta
        if ($request->filled('prioritas')) {
            $laporans = $laporans->filter(fn($l) => strtolower($l->tingkat) === strtolower($request->prioritas));
        }

        // Sorting (Default: Warga Terdampak DESC, then Durasi DESC)
        // Sorting logic
        $sortBy = $request->input('sort', 'warga');
        if ($sortBy === 'warga') {
            // Primary: Warga Terdampak, Secondary: Priority Score
            $laporans = $laporans->sortByDesc('skor_prioritas')
                                 ->sortByDesc('warga_terdampak')
                                 ->values();
        } elseif ($sortBy === 'durasi') {
            // Primary: Durasi Kekeringan, Secondary: Priority Score
            $laporans = $laporans->sortByDesc('skor_prioritas')
                                 ->sortByDesc('durasi_kekeringan')
                                 ->values();
        } elseif ($sortBy === 'tingkat') {
            // Primary: Tingkat Prioritas (Skor), Secondary: Warga Terdampak
            $laporans = $laporans->sortByDesc('warga_terdampak')
                                 ->sortByDesc('skor_prioritas')
                                 ->values();
        } else {
            // Default: Tingkat Prioritas first
            $laporans = $laporans->sortByDesc('warga_terdampak')
                                 ->sortByDesc('skor_prioritas')
                                 ->values();
        }

        // Statistik ringkasan (dari semua tervalidasi, tanpa filter)
        $allValidated = \App\Models\Laporan::whereIn('status', $validatedStatuses)->get();
        $totalValidated = $allValidated->count();

        $stats = $allValidated->map(function ($l) {
            $l->tk = $this->getPriorityLevel($this->calculatePriorityScore($l));
            return $l;
        });

        $jumlahKritis = $stats->where('tk', 'Kritis')->count();
        $jumlahTinggi = $stats->where('tk', 'Tinggi')->count();
        $jumlahSedang = $stats->where('tk', 'Sedang')->count();

        return view('admin.prioritas', compact(
            'laporans', 'sortBy', 'filterPrioritas',
            'totalValidated', 'jumlahKritis', 'jumlahTinggi', 'jumlahSedang'
        ));
    }

    public function adminTindakLanjut(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $query = \App\Models\TindakLanjut::with('laporan');

        // Deteksi apakah kata kunci pencarian adalah tingkatan prioritas
        $search = strtolower($request->input('search', ''));
        $priorityKeywords = ['kritis', 'tinggi', 'sedang'];
        $searchPriority = null;
        
        foreach ($priorityKeywords as $pk) {
            if (str_contains($search, $pk)) {
                $searchPriority = $pk;
                break;
            }
        }
        
        // Filter: Pencarian (Kelurahan, Kecamatan, Kode, Status, atau Deskripsi)
        if ($request->filled('search')) {
            // Jika pencarian BUKAN hanya kata kunci prioritas, terapkan filter SQL
            if (!in_array(trim($search), $priorityKeywords)) {
                $query->where(function($q) use ($search) {
                    $q->whereHas('laporan', function($lq) use ($search) {
                        // Bersihkan awalan 'R' dan angka nol di depan untuk pencarian ID yang lebih akurat
                        $cleanId = ltrim(str_replace('R', '', strtoupper($search)), '0');
                        
                        $lq->where('kelurahan', 'like', '%' . $search . '%')
                           ->orWhere('kecamatan', 'like', '%' . $search . '%');
                        
                        if (is_numeric($cleanId) && $cleanId !== '') {
                            $lq->orWhere('id', $cleanId)
                               ->orWhere('id', 'like', '%' . $cleanId . '%');
                        }
                    })->orWhere('deskripsi_aksi', 'like', '%' . $search . '%')
                      ->orWhere('status', 'like', '%' . $search . '%');
                });
            }
        }

        if ($request->filled('kecamatan')) {
            $kec = $request->kecamatan;
            $query->whereHas('laporan', function($q) use ($kec) {
                $q->where('kecamatan', 'like', '%' . $kec . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tindakLanjuts = $query->orderBy('created_at', 'desc')->get();
        
        // Filter: Prioritas (Dilakukan pada koleksi karena skor dihitung dinamis)
        if ($request->filled('prioritas') || $searchPriority) {
            $prioritas = $request->input('prioritas') ?: $searchPriority;
            $tindakLanjuts = $tindakLanjuts->filter(function($tl) use ($prioritas) {
                if (!$tl->laporan) return false;
                $score = $this->calculatePriorityScore($tl->laporan);
                $level = $this->getPriorityLevel($score);
                return strtolower($level) === strtolower($prioritas);
            });
        }

        // Tambahkan skor prioritas ke setiap laporan dalam tindak lanjut
        foreach ($tindakLanjuts as $tl) {
            if ($tl->laporan) {
                $tl->laporan->skor_prioritas = $this->calculatePriorityScore($tl->laporan);
                $tl->laporan->tingkat_prioritas = $this->getPriorityLevel($tl->laporan->skor_prioritas);
                $tl->laporan->kode = 'R' . str_pad($tl->laporan->id, 3, '0', STR_PAD_LEFT);
            }
        }

        // Ambil data untuk filter kecamatan
        $kecamatans = \App\Models\Laporan::distinct()->pluck('kecamatan')
            ->map(fn($k) => str_replace('Petugas ', '', $k))
            ->unique()
            ->sort()
            ->values();

        // Ambil laporan yang sudah divalidasi (diterima/proses) untuk dropdown "Tambah Aksi"
        $existingLaporanIds = \App\Models\TindakLanjut::pluck('laporan_id')->toArray();
        $laporansReady = \App\Models\Laporan::whereIn('status', ['diterima', 'proses', 'selesai'])
            ->whereNotIn('id', $existingLaporanIds)
            ->orderBy('created_at', 'desc')
            ->get();
        
        foreach ($laporansReady as $lap) {
            $lap->skor_prioritas = $this->calculatePriorityScore($lap);
            $lap->tingkat_prioritas = $this->getPriorityLevel($lap->skor_prioritas);
            $lap->kode = 'R' . str_pad($lap->id, 3, '0', STR_PAD_LEFT);
        }

        return view('admin.tindak_lanjut', compact('tindakLanjuts', 'laporansReady', 'kecamatans'));
    }

    public function storeTindakLanjut(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $request->validate([
            'laporan_id' => 'required|exists:laporans,id',
            'deskripsi_aksi' => 'required|string',
            'deskripsi_selesai' => 'nullable|string',
            'tanggal' => 'required|date',
            'status' => 'required|string',
        ]);

        \App\Models\TindakLanjut::create([
            'laporan_id' => $request->laporan_id,
            'deskripsi_aksi' => $request->deskripsi_aksi,
            'deskripsi_selesai' => $request->deskripsi_selesai,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
        ]);

        // Update status laporan utama
        $laporan = \App\Models\Laporan::find($request->laporan_id);
        if ($request->status === 'Selesai') {
            $laporan->update(['status' => 'selesai']);
        } else {
            $laporan->update(['status' => 'proses']);
        }

        return redirect()->back()->with('success', 'Aksi tindak lanjut berhasil ditambahkan.');
    }

    public function updateStatusTindakLanjut(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $tl = \App\Models\TindakLanjut::findOrFail($id);

        // Validasi: Jika sudah Selesai, tidak boleh diubah lagi
        if ($tl->status === 'Selesai') {
            return redirect()->back()->with('error', 'Mohon maaf, tindak lanjut yang telah berstatus Selesai bersifat permanen dan tidak dapat diubah kembali untuk menjaga validitas data.');
        }

        $tl->update(['status' => $request->status]);

        // Sinkronisasi status laporan utama
        $laporan = $tl->laporan;
        if ($laporan) {
            if ($request->status === 'Selesai') {
                $laporan->update(['status' => 'selesai']);
            } else {
                $laporan->update(['status' => 'proses']);
            }
        }
        
        return redirect()->back()->with('success', 'Status aksi dan laporan berhasil diperbarui.');
    }

    public function updateTindakLanjut(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $request->validate([
            'deskripsi_aksi' => 'required|string',
            'deskripsi_selesai' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $tl = \App\Models\TindakLanjut::findOrFail($id);
        
        $tl->update([
            'deskripsi_aksi' => $request->deskripsi_aksi,
            'deskripsi_selesai' => $request->deskripsi_selesai,
            'status' => $request->status,
        ]);

        // Sync main report status
        if ($tl->laporan) {
            $tl->laporan->update(['status' => $request->status === 'Selesai' ? 'selesai' : 'proses']);
        }

        return redirect()->back()->with('success', 'Tindak lanjut berhasil diperbarui.');
    }

    public function deleteTindakLanjut($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $tl = \App\Models\TindakLanjut::findOrFail($id);
        $tl->delete();

        return redirect()->back()->with('success', 'Aksi tindak lanjut berhasil dihapus.');
    }

    private function calculatePriorityScore($lap)
    {
        if ($lap->kondisi_air === 'Air tidak tersedia') { $sk = 3; }
        elseif ($lap->kondisi_air === 'Ketersediaan air tidak mencukupi') { $sk = 2; }
        else { $sk = 1; }

        $dur = $lap->durasi_kekeringan ?? 0;
        if ($dur >= 30) { $sd = 3; } elseif ($dur >= 14) { $sd = 2; } else { $sd = 1; }

        $wrg = $lap->warga_terdampak ?? 0;
        if ($wrg >= 200) { $sw = 3; } elseif ($wrg >= 100) { $sw = 2; } else { $sw = 1; }

        return round(($sk / 3) * 50 + ($sd / 3) * 30 + ($sw / 3) * 20, 1);
    }

    private function getPriorityLevel($skor)
    {
        if ($skor >= 75) return 'Kritis';
        if ($skor >= 50) return 'Tinggi';
        return 'Sedang';
    }

    public function adminValidasi(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403);
        
        $query = \App\Models\Laporan::where('status', '!=', 'draft');

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', 'like', '%' . $request->kecamatan . '%');
        }

        $perPage = $request->input('per_page', 10);
        $laporans = $query->orderBy('created_at', 'desc')->paginate($perPage);

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

    public function deleteLaporanAdmin($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $laporan = \App\Models\Laporan::findOrFail($id);
        
        if ($laporan->foto) {
            $fotos = json_decode($laporan->foto, true);
            if (is_array($fotos)) {
                foreach ($fotos as $foto) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($foto);
                }
            } else {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($laporan->foto);
            }
        }
        
        $laporan->delete();
        return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    }
}