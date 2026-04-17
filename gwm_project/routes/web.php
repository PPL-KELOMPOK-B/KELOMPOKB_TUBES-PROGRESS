<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('login');

Route::post('/login', function (Illuminate\Http\Request $request) {
    // Authenticate via database
    $credentials = $request->only('email', 'password');

    if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
        
        $user = auth()->user();
        
        // Cek jika tab/login_type yang dipilih tidak sesuai dengan role user
        if ($user->role !== $request->login_type) {
            \Illuminate\Support\Facades\Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return back()->withErrors([
                'roleError' => 'Akun Anda (' . strtoupper($user->role) . ') tidak berhak masuk dari tab login ini. Silakan gunakan tab yang tepat.'
            ]);
        }

        $request->session()->regenerate();
        
        // Redirect based on role
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        } else {
            return redirect('/petugas/dashboard');
        }
    }

    return back()->withErrors(['email' => 'Username atau password salah.']);
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
    Route::get('/admin/petugas/create', [DashboardController::class, 'createPetugas'])->name('admin.create_petugas');
    Route::post('/admin/petugas/create', [DashboardController::class, 'storePetugas'])->name('admin.store_petugas');
    
    // Petugas Routes
    Route::get('/petugas/dashboard', [DashboardController::class, 'petugasIndex'])->name('petugas.dashboard');
    Route::get('/petugas/laporan/create', [DashboardController::class, 'createLaporan'])->name('petugas.create_laporan');
    Route::post('/petugas/laporan', [DashboardController::class, 'storeLaporan'])->name('petugas.store_laporan');
    Route::get('/petugas/laporan/{id}/edit', [DashboardController::class, 'editLaporan'])->name('petugas.edit_laporan');
    Route::post('/petugas/laporan/{id}', [DashboardController::class, 'updateLaporan'])->name('petugas.update_laporan');
    Route::delete('/petugas/laporan/{id}/foto', [DashboardController::class, 'deleteFotoLaporan'])->name('petugas.delete_foto_laporan');
    Route::get('/petugas/laporan/{id}/preview', [DashboardController::class, 'previewLaporan'])->name('petugas.preview_laporan');
    Route::post('/petugas/laporan/{id}/submit', [DashboardController::class, 'submitLaporan'])->name('petugas.submit_laporan');
    Route::get('/petugas/draft', [DashboardController::class, 'draftLaporan'])->name('petugas.draft');
    Route::delete('/petugas/laporan/{id}', [DashboardController::class, 'deleteLaporan'])->name('petugas.delete_laporan');
});