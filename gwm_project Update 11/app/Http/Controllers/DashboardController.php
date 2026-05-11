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
            // Weighted scoring (same as detail page)
            if ($lap->kondisi_air === 'Air tidak tersedia') { $sk = 3; }
            elseif ($lap->kondisi_air === 'Ketersediaan air tidak mencukupi') { $sk = 2; }
            else { $sk = 1; }

            $dur = $lap->durasi_kekeringan ?? 0;
            if ($dur >= 30) { $sd = 3; } elseif ($dur >= 14) { $sd = 2; } else { $sd = 1; }

            $wrg = $lap->warga_terdampak ?? 0;
            if ($wrg >= 200) { $sw = 3; } elseif ($wrg >= 100) { $sw = 2; } else { $sw = 1; }

            $total = ($sk / 3) * 50 + ($sd / 3) * 30 + ($sw / 3) * 20;

            if ($total >= 75) $distKekeringan['Kritis']++;
            elseif ($total >= 50) $distKekeringan['Tinggi']++;
            else $distKekeringan['Sedang']++;
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
            ->orderBy('durasi_kekeringan', 'desc')
            ->get();

        $laporanPrioritas->each(function ($laporan) {
            // Weighted scoring system (same as detail page)
            // Factor 1: Kondisi Air (Bobot 50%)
            if ($laporan->kondisi_air === 'Air tidak tersedia') { $sk = 3; }
            elseif ($laporan->kondisi_air === 'Ketersediaan air tidak mencukupi') { $sk = 2; }
            else { $sk = 1; }

            // Factor 2: Durasi Kekeringan (Bobot 30%)
            $dur = $laporan->durasi_kekeringan ?? 0;
            if ($dur >= 30) { $sd = 3; }
            elseif ($dur >= 14) { $sd = 2; }
            else { $sd = 1; }

            // Factor 3: Warga Terdampak (Bobot 20%)
            $wrg = $laporan->warga_terdampak ?? 0;
            if ($wrg >= 200) { $sw = 3; }
            elseif ($wrg >= 100) { $sw = 2; }
            else { $sw = 1; }

            $total = ($sk / 3) * 50 + ($sd / 3) * 30 + ($sw / 3) * 20;

            if ($total >= 75) {
                $laporan->tingkat_kekeringan = 'Kritis';
                $laporan->badge_color = '#ef4444';
            } elseif ($total >= 50) {
                $laporan->tingkat_kekeringan = 'Tinggi';
                $laporan->badge_color = '#f97316';
            } else {
                $laporan->tingkat_kekeringan = 'Sedang';
                $laporan->badge_color = '#eab308';
            }

            $skor = 0;
            if ($laporan->durasi_kekeringan >= 30) $skor += 3;
            elseif ($laporan->durasi_kekeringan >= 14) $skor += 2;
            else $skor += 1;

            if ($laporan->warga_terdampak >= 200) $skor += 3;
            elseif ($laporan->warga_terdampak >= 100) $skor += 2;
            else $skor += 1;

            if ($laporan->kondisi_air === 'Air tidak tersedia') $skor += 3;
            elseif ($laporan->kondisi_air === 'Ketersediaan air tidak mencukupi') $skor += 2;
            else $skor += 1;

            if ($skor >= 7) {
                $laporan->level_kondisi = 'Darurat';
                $laporan->level_color = '#dc2626';
            } elseif ($skor >= 5) {
                $laporan->level_kondisi = 'Siaga';
                $laporan->level_color = '#f97316';
            } else {
                $laporan->level_kondisi = 'Waspada';
                $laporan->level_color = '#eab308';
            }

            $laporan->kode = 'R' . str_pad($laporan->id, 3, '0', STR_PAD_LEFT);
        });

        $data['laporanPrioritas'] = $laporanPrioritas;

        // Keterangan Ranking (4 tertinggi)
        // Sort by: Kritis > Tinggi > Sedang > Rendah, then warga_terdampak desc
        $data['desaRanking'] = \App\Models\Laporan::where('status', '!=', 'draft')
            ->get()
            ->map(function($l) {
                // Weighted scoring (same as detail page)
                if ($l->kondisi_air === 'Air tidak tersedia') { $sk = 3; }
                elseif ($l->kondisi_air === 'Ketersediaan air tidak mencukupi') { $sk = 2; }
                else { $sk = 1; }

                $dur = $l->durasi_kekeringan ?? 0;
                if ($dur >= 30) { $sd = 3; } elseif ($dur >= 14) { $sd = 2; } else { $sd = 1; }

                $wrg = $l->warga_terdampak ?? 0;
                if ($wrg >= 200) { $sw = 3; } elseif ($wrg >= 100) { $sw = 2; } else { $sw = 1; }

                $total = ($sk / 3) * 50 + ($sd / 3) * 30 + ($sw / 3) * 20;
                $l->skor_total = $total;

                if ($total >= 75) {
                    $l->priority = 3; $l->tipe = 'kritis'; $l->status_text = 'Kritis'; $l->warna_text = 'Merah';
                    $l->desc = 'Kondisi darurat, semua sumber air mengering. Diperlukan bantuan segera.';
                } elseif ($total >= 50) {
                    $l->priority = 2; $l->tipe = 'tinggi'; $l->status_text = 'Tinggi'; $l->warna_text = 'Oranye';
                    $l->desc = 'Kondisi kekeringan parah, sumber air mulai menipis. Membutuhkan bantuan dalam waktu dekat.';
                } else {
                    $l->priority = 1; $l->tipe = 'sedang'; $l->status_text = 'Sedang'; $l->warna_text = 'Kuning';
                    $l->desc = 'Kondisi mulai kering, ketersediaan air berkurang. Perlu pemantauan dan antisipasi.';
                }
                return $l;
            })
            ->sort(function($a, $b) {
                if ($a->priority !== $b->priority) return $b->priority <=> $a->priority;
                return $b->skor_total <=> $a->skor_total;
            })
            ->take(5)
            ->values();

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