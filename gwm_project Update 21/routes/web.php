<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('welcome');
})->name('login');

Route::post('/login', function (Illuminate\Http\Request $request) {

    $loginInput = $request->email;

    // Ambil user berdasarkan email, username (prefix email), atau nama lengkap
    $user = \App\Models\User::where(function($query) use ($loginInput) {
        $query->where('email', $loginInput)
              ->orWhere('name', $loginInput);
        
        // Jika input tidak mengandung '@', coba pasangkan dengan '@gwm.com'
        if (!str_contains($loginInput, '@')) {
            $query->orWhere('email', $loginInput . '@gwm.com');
            // Coba cari juga dengan format nama 'Petugas [Nama]' atau 'Admin [Nama]'
            $query->orWhere('name', 'Petugas ' . ucfirst($loginInput))
                  ->orWhere('name', 'Admin ' . ucfirst($loginInput));
        }
    })->first();

    // ❌ Email atau Username tidak ditemukan
    if (!$user) {
        return back()
            ->with('error', 'Username atau Email tidak terdaftar') // <-- Ditambahkan untuk memicu pop-up
            ->withErrors(['email' => 'Username atau Email tidak terdaftar'])
            ->withInput($request->except('password')); // <-- Menjaga email tidak hilang dari input form
    }


    // ❌ Password salah (pakai Hash)
    if (!\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
        return back()
            ->with('error', 'Password anda salah') // <-- Ditambahkan untuk memicu pop-up
            ->withErrors(['password' => 'Password anda salah'])
            ->withInput($request->except('password'));
    }

    // ✅ Login manual (JANGAN pakai Auth::attempt lagi)
    \Illuminate\Support\Facades\Auth::login($user);

    // ❌ Role tidak sesuai
    if ($user->role !== $request->login_type) {
        \Illuminate\Support\Facades\Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $pesanError = 'Akun Anda (' . strtoupper($user->role) . ') tidak berhak masuk dari tab login ini.';
        
        return back()
            ->with('error', $pesanError) // <-- Ditambahkan untuk memicu pop-up
            ->withErrors(['roleError' => $pesanError]);
    }

    // ✅ Session regenerate
    $request->session()->regenerate();

    // Redirect
    if ($user->role === 'admin') {
        return redirect('/admin/dashboard');
    } else {
        return redirect('/petugas/dashboard');
    }
});

Route::get('/logout', function (Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Role-based Dashboards
Route::middleware(['auth'])->group(function () {
    // Admin Routes
    Route::get('/admin/dashboard', [DashboardController::class, 'adminIndex'])->name('admin.dashboard');
    Route::get('/admin/export', [DashboardController::class, 'adminExport'])->name('admin.export.index');
    Route::get('/admin/petugas/create', [DashboardController::class, 'createPetugas'])->name('admin.create_petugas');
    Route::post('/admin/petugas/create', [DashboardController::class, 'storePetugas'])->name('admin.store_petugas');
    Route::delete('/admin/petugas/{id}', [DashboardController::class, 'deletePetugas'])->name('admin.delete_petugas');

    // Admin Validasi Routes
    Route::get('/admin/validasi', [DashboardController::class, 'adminValidasi'])->name('admin.validasi.index');
    Route::get('/admin/validasi/{id}', [DashboardController::class, 'adminValidasiDetail'])->name('admin.validasi.detail');
    Route::post('/admin/validasi/{id}/action', [DashboardController::class, 'adminValidasiAction'])->name('admin.validasi.action');
    Route::delete('/admin/validasi/{id}', [DashboardController::class, 'deleteLaporanAdmin'])->name('admin.validasi.destroy');
    Route::get('/admin/prioritas', [DashboardController::class, 'adminPrioritas'])->name('admin.prioritas');
    Route::get('/admin/tindak-lanjut', [DashboardController::class, 'adminTindakLanjut'])->name('admin.tindak_lanjut');
    Route::get('/admin/monitoring', [DashboardController::class, 'adminMonitoring'])->name('admin.monitoring');
    Route::get('/admin/monitoring/kekeringan/{id}', [DashboardController::class, 'klasifikasiKekeringan'])->name('admin.monitoring.kekeringan');
    Route::get('/admin/monitoring/kondisi/{id}', [DashboardController::class, 'levelKondisi'])->name('admin.monitoring.kondisi');
    Route::get('/admin/riwayat-kondisi', [DashboardController::class, 'riwayatKondisi'])->name('admin.riwayat_kondisi');
    Route::post('/admin/tindak-lanjut', [DashboardController::class, 'storeTindakLanjut'])->name('admin.tindak_lanjut.store');
    Route::post('/admin/tindak-lanjut/{id}/status', [DashboardController::class, 'updateStatusTindakLanjut'])->name('admin.tindak_lanjut.status');
    Route::delete('/admin/tindak-lanjut/{id}', [DashboardController::class, 'deleteTindakLanjut'])->name('admin.tindak_lanjut.destroy');
    Route::put('/admin/tindak-lanjut/{id}', [DashboardController::class, 'updateTindakLanjut'])->name('admin.tindak_lanjut.update');
    Route::get('/admin/klasifikasi-kekeringan/{id}', [DashboardController::class, 'klasifikasiKekeringan'])->name('admin.klasifikasi_kekeringan');
    Route::get('/admin/level-kondisi/{id}', [DashboardController::class, 'levelKondisi'])->name('admin.level_kondisi');
    
    // Petugas Routes
    Route::get('/petugas/dashboard', [DashboardController::class, 'petugasIndex'])->name('petugas.dashboard');
    Route::get('/petugas/laporan', [DashboardController::class, 'laporanIndex'])->name('petugas.laporan.index');
    Route::get('/petugas/laporan/create', [DashboardController::class, 'createLaporan'])->name('petugas.create_laporan');
    Route::post('/petugas/laporan', [DashboardController::class, 'storeLaporan'])->name('petugas.store_laporan');
    Route::get('/petugas/laporan/{id}/edit', [DashboardController::class, 'editLaporan'])->name('petugas.edit_laporan');
    Route::post('/petugas/laporan/{id}', [DashboardController::class, 'updateLaporan'])->name('petugas.update_laporan');
    Route::delete('/petugas/laporan/{id}/foto', [DashboardController::class, 'deleteFotoLaporan'])->name('petugas.delete_foto_laporan');
    Route::get('/petugas/laporan/{id}/preview', [DashboardController::class, 'previewLaporan'])->name('petugas.preview_laporan');
    Route::post('/petugas/laporan/{id}/submit', [DashboardController::class, 'submitLaporan'])->name('petugas.submit_laporan');
    Route::get('/petugas/draft', [DashboardController::class, 'draftLaporan'])->name('petugas.draft');
    Route::delete('/petugas/laporan/{id}', [DashboardController::class, 'deleteLaporan'])->name('petugas.delete_laporan');

    // Laporan Detail & Edit dari Daftar Laporan
    Route::get('/petugas/laporan/{id}/detail', [DashboardController::class, 'showLaporan'])->name('petugas.show_laporan');
    Route::get('/petugas/laporan/{id}/edit-list', [DashboardController::class, 'editLaporanList'])->name('petugas.edit_laporan_list');
    Route::put('/petugas/laporan/{id}/update-list', [DashboardController::class, 'updateLaporanFromList'])->name('petugas.update_laporan_list');

    // Petugas Notifikasi Routes
    Route::get('/petugas/notifikasi', [NotificationController::class, 'index'])->name('petugas.notifikasi');
    Route::get('/petugas/notifikasi/read/{id}', [NotificationController::class, 'markAsRead'])->name('petugas.notifikasi.read');
    Route::post('/petugas/notifikasi/read-all', [NotificationController::class, 'markAllAsRead'])->name('petugas.notifikasi.read_all');

    // History Admin
    Route::get('/admin/history', [DashboardController::class, 'historyIndex'])->name('admin.history');
    Route::get('/admin/history/{id}', [DashboardController::class, 'historyDetail'])->name('admin.history.detail');
});