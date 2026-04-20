<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\LaporanFoto;
use App\Models\Kelurahan;
use App\Models\Kecamatan;
use App\Models\Validasi;

class DashboardController extends Controller
{
    private function getDashboardData()
    {
        $user = auth()->user();
        
        // Query laporan milik user ini
        $laporanQuery = Laporan::where('user_id', $user->id);
        
        return [
            'total' => (clone $laporanQuery)->count(),
            'menunggu' => (clone $laporanQuery)->where('status', 'diajukan')->count(),
            'proses' => (clone $laporanQuery)->where('status', 'diproses')->count(),
            'selesai' => (clone $laporanQuery)->where('status', 'selesai')->count(),
            'laporan' => (clone $laporanQuery)->with(['kecamatan', 'kelurahan'])->latest()->take(5)->get(),
        ];
    }

    public function adminIndex()
    {
        if (auth()->user()->role !== 'admin') abort(403);
        
        $laporanQuery = Laporan::query();
        $data = [
            'total' => (clone $laporanQuery)->count(),
            'menunggu' => (clone $laporanQuery)->where('status', 'diajukan')->count(),
            'proses' => (clone $laporanQuery)->where('status', 'diproses')->count(),
            'selesai' => (clone $laporanQuery)->where('status', 'selesai')->count(),
            'laporan' => (clone $laporanQuery)->with(['kecamatan', 'kelurahan'])->latest()->take(5)->get(),
        ];
        
        return view('admin.dashboard', $data);
    }

    public function petugasIndex()
    {
        if (auth()->user()->role !== 'petugas') abort(403);
        return view('petugas.dashboard', $this->getDashboardData());
    }

    public function createLaporan()
    {
        if (auth()->user()->role !== 'petugas') abort(403);
        
        $user = auth()->user();
        $kelurahans = Kelurahan::where('kecamatan_id', $user->kecamatan_id)->get();
        
        return view('petugas.create_laporan', compact('kelurahans'));
    }

    public function storeLaporan(Request $request)
    {
        if (auth()->user()->role !== 'petugas') abort(403);

        $rules = [
            'kelurahan_id' => 'required|integer|exists:kelurahan,id',
            'kondisi_air' => 'required|string|in:aman,waspada,siaga,kritis',
            'jumlah_terdampak' => 'required|integer',
            'durasi_hari' => 'required|integer',
            'catatan' => 'required|string',
            'foto_upload' => 'nullable|array|max:3',
            'foto_upload.*' => 'image|max:10240',
        ];

        $messages = [
            'kelurahan_id.required' => 'Kelurahan wajib dipilih.',
            'kondisi_air.required' => 'Kondisi air wajib dipilih.',
            'jumlah_terdampak.required' => 'Jumlah warga terdampak wajib diisi.',
            'durasi_hari.required' => 'Durasi kekeringan wajib diisi.',
            'catatan.required' => 'Keterangan wajib diisi.',
        ];

        if ($request->action !== 'draft') {
            $rules['foto_upload'] = 'required|array|min:1|max:3';
            $messages['foto_upload.required'] = 'Minimal 1 foto wajib diunggah.';
        }

        $request->validate($rules, $messages);

        // Determine level based on kondisi_air
        $levelMap = [
            'aman' => 'green',
            'waspada' => 'yellow',
            'siaga' => 'orange',
            'kritis' => 'red',
        ];

        $laporan = Laporan::create([
            'user_id' => auth()->id(),
            'kecamatan_id' => auth()->user()->kecamatan_id,
            'kelurahan_id' => $request->kelurahan_id,
            'kondisi_air' => $request->kondisi_air,
            'jumlah_terdampak' => $request->jumlah_terdampak,
            'durasi_hari' => $request->durasi_hari,
            'catatan' => $request->catatan,
            'level' => $levelMap[$request->kondisi_air] ?? 'green',
            'status' => 'draft',
        ]);

        // Handle foto uploads
        if ($request->hasFile('foto_upload')) {
            foreach ($request->file('foto_upload') as $file) {
                $path = $file->store('foto', 'public');
                LaporanFoto::create([
                    'laporan_id' => $laporan->id,
                    'path_foto' => $path,
                ]);
            }
        }

        if ($request->action === 'preview') {
            return redirect()->route('petugas.preview_laporan', $laporan->id);
        }

        if ($request->action === 'submit') {
            $laporan->update(['status' => 'diajukan']);
            return redirect()->route('petugas.dashboard')->with('success', 'Laporan berhasil dikirim dan menunggu validasi.');
        }

        return redirect()->route('petugas.dashboard')->with('success', 'Draft laporan berhasil disimpan.');
    }

    public function editLaporan($id)
    {
        if (auth()->user()->role !== 'petugas') abort(403);
        $laporan = Laporan::where('id', $id)->where('user_id', auth()->id())->with('fotos')->firstOrFail();
        
        $user = auth()->user();
        $kelurahans = Kelurahan::where('kecamatan_id', $user->kecamatan_id)->get();
        
        return view('petugas.create_laporan', compact('laporan', 'kelurahans'));
    }

    public function updateLaporan(Request $request, $id)
    {
        if (auth()->user()->role !== 'petugas') abort(403);
        $laporan = Laporan::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $rules = [
            'kelurahan_id' => 'required|integer|exists:kelurahan,id',
            'kondisi_air' => 'required|string|in:aman,waspada,siaga,kritis',
            'jumlah_terdampak' => 'required|integer',
            'durasi_hari' => 'required|integer',
            'catatan' => 'required|string',
            'foto_upload' => 'nullable|array|max:3',
            'foto_upload.*' => 'image|max:10240',
        ];

        $messages = [
            'kelurahan_id.required' => 'Kelurahan wajib dipilih.',
            'kondisi_air.required' => 'Kondisi air wajib dipilih.',
            'jumlah_terdampak.required' => 'Jumlah warga terdampak wajib diisi.',
            'durasi_hari.required' => 'Durasi kekeringan wajib diisi.',
            'catatan.required' => 'Keterangan wajib diisi.',
        ];

        // Handle removed fotos
        if ($request->filled('removed_fotos')) {
            $removed = json_decode($request->removed_fotos, true);
            if (is_array($removed)) {
                foreach ($removed as $fotoId) {
                    $foto = LaporanFoto::where('id', $fotoId)->where('laporan_id', $laporan->id)->first();
                    if ($foto) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($foto->path_foto);
                        $foto->delete();
                    }
                }
            }
        }

        $existingFotoCount = $laporan->fotos()->count();
        $hasNewFotos = $request->hasFile('foto_upload');

        if ($request->action !== 'draft' && $existingFotoCount == 0 && !$hasNewFotos) {
            $rules['foto_upload'] = 'required|array|min:1|max:3';
            $messages['foto_upload.required'] = 'Minimal 1 foto wajib diunggah/tersedia.';
        }

        $request->validate($rules, $messages);

        $levelMap = [
            'aman' => 'green',
            'waspada' => 'yellow',
            'siaga' => 'orange',
            'kritis' => 'red',
        ];

        $laporan->update([
            'kelurahan_id' => $request->kelurahan_id,
            'kondisi_air' => $request->kondisi_air,
            'jumlah_terdampak' => $request->jumlah_terdampak,
            'durasi_hari' => $request->durasi_hari,
            'catatan' => $request->catatan,
            'level' => $levelMap[$request->kondisi_air] ?? 'green',
        ]);

        // Handle new foto uploads
        if ($request->hasFile('foto_upload')) {
            $currentCount = $laporan->fotos()->count();
            foreach ($request->file('foto_upload') as $file) {
                if ($currentCount < 3) {
                    $path = $file->store('foto', 'public');
                    LaporanFoto::create([
                        'laporan_id' => $laporan->id,
                        'path_foto' => $path,
                    ]);
                    $currentCount++;
                }
            }
        }

        if ($request->action === 'preview') {
            return redirect()->route('petugas.preview_laporan', $laporan->id);
        }

        if ($request->action === 'submit') {
            $laporan->update(['status' => 'diajukan']);
            return redirect()->route('petugas.dashboard')->with('success', 'Laporan berhasil diperbarui dan dikirim menunggu validasi.');
        }

        return redirect()->route('petugas.dashboard')->with('success', 'Draft laporan berhasil diperbarui.');
    }

    public function deleteFotoLaporan($id)
    {
        if (auth()->user()->role !== 'petugas') return response()->json(['success' => false], 403);
        
        $foto = LaporanFoto::whereHas('laporan', function($q) {
            $q->where('user_id', auth()->id());
        })->where('id', $id)->first();
        
        if ($foto) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($foto->path_foto);
            $foto->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    public function previewLaporan($id)
    {
        if (auth()->user()->role !== 'petugas') abort(403);
        $laporan = Laporan::where('id', $id)->where('user_id', auth()->id())->with(['kecamatan', 'kelurahan', 'fotos'])->firstOrFail();
        
        return view('petugas.preview_laporan', compact('laporan'));
    }

    public function submitLaporan(Request $request, $id)
    {
        if (auth()->user()->role !== 'petugas') abort(403);
        $laporan = Laporan::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        
        $laporan->update(['status' => 'diajukan']);
        
        return redirect()->route('petugas.dashboard')->with('success', 'Laporan berhasil dikirim dan menunggu validasi.');
    }

    public function draftLaporan()
    {
        if (auth()->user()->role !== 'petugas') abort(403);
        $drafts = Laporan::where('user_id', auth()->id())
                    ->where('status', 'draft')
                    ->with(['kecamatan', 'kelurahan'])
                    ->orderBy('updated_at', 'desc')
                    ->get();
        return view('petugas.draft_laporan', compact('drafts'));
    }

    public function deleteLaporan($id)
    {
        if (auth()->user()->role !== 'petugas') abort(403);
        $laporan = Laporan::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        
        // Delete associated fotos
        foreach ($laporan->fotos as $foto) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($foto->path_foto);
            $foto->delete();
        }
        
        $laporan->delete();
        return redirect()->back()->with('success', 'Draft laporan berhasil dihapus.');
    }

    public function daftarLaporan(Request $request)
    {
        if (auth()->user()->role !== 'petugas') abort(403);

        $query = Laporan::where('user_id', auth()->id())
                    ->where('status', '!=', 'draft')
                    ->with(['kecamatan', 'kelurahan']);

        // Search by kelurahan or kecamatan name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('kelurahan', function($q2) use ($search) {
                    $q2->where('nama_kelurahan', 'like', "%{$search}%");
                })->orWhereHas('kecamatan', function($q2) use ($search) {
                    $q2->where('nama_kecamatan', 'like', "%{$search}%");
                });
            });
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        $laporan = $query->orderBy('created_at', 'desc')->get();

        return view('petugas.daftar_laporan', compact('laporan'));
    }

    public function createPetugas()
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $accounts = \App\Models\User::where('role', 'petugas')->with('kecamatan')->get();
        $kecamatans = Kecamatan::all();
        return view('admin.create_petugas', compact('accounts', 'kecamatans'));
    }

    public function storePetugas(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403, 'Hanya admin yang dapat membuat akun petugas.');

        $request->validate([
            'nama' => 'required|string|max:255',
            'kecamatan_id' => 'required|integer|exists:kecamatan,id',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        \App\Models\User::create([
            'nama' => $request->nama,
            'kecamatan_id' => $request->kecamatan_id,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'petugas',
        ]);

        return redirect()->route('admin.create_petugas')->with('success', 'Akun petugas berhasil dibuat!');
    }

    // ==================== ADMIN VALIDASI ====================

    public function validasiIndex(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $query = Laporan::whereIn('status', ['diajukan', 'divalidasi', 'ditolak'])
                    ->with(['kecamatan', 'kelurahan', 'validasi', 'user']);

        // Search by lokasi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('kelurahan', function($q2) use ($search) {
                    $q2->where('nama_kelurahan', 'like', "%{$search}%");
                })->orWhereHas('kecamatan', function($q2) use ($search) {
                    $q2->where('nama_kecamatan', 'like', "%{$search}%");
                });
            });
        }

        // Filter by kecamatan
        if ($request->filled('kecamatan_id') && $request->kecamatan_id !== 'semua') {
            $query->where('kecamatan_id', $request->kecamatan_id);
        }

        $perPage = $request->input('per_page', 10);
        $laporan = $query->orderBy('created_at', 'desc')->paginate($perPage)->appends($request->query());
        $kecamatans = Kecamatan::all();

        return view('admin.validasi_laporan', compact('laporan', 'kecamatans'));
    }

    public function approveLaporan(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $laporan = Laporan::findOrFail($id);
        $laporan->update(['status' => 'divalidasi']);

        // Create or update validasi record
        Validasi::updateOrCreate(
            ['laporan_id' => $id],
            [
                'admin_id' => auth()->id(),
                'status_validasi' => 'approve',
                'catatan' => $request->input('catatan', 'Laporan disetujui'),
            ]
        );

        return redirect()->route('admin.validasi')->with('success', 'Laporan berhasil di-approve.');
    }

    public function rejectLaporan(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $laporan = Laporan::findOrFail($id);
        $laporan->update(['status' => 'ditolak']);

        // Create or update validasi record
        Validasi::updateOrCreate(
            ['laporan_id' => $id],
            [
                'admin_id' => auth()->id(),
                'status_validasi' => 'reject',
                'catatan' => $request->input('catatan', 'Laporan ditolak'),
            ]
        );

        return redirect()->route('admin.validasi')->with('success', 'Laporan berhasil di-reject.');
    }

    public function viewLaporan($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $laporan = Laporan::with(['kecamatan', 'kelurahan', 'fotos', 'user', 'validasi'])->findOrFail($id);

        return view('admin.view_laporan', compact('laporan'));
    }
}