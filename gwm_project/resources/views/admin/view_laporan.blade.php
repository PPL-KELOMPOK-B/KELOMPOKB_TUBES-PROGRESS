<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWM - Detail Laporan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-color: #f8fafc;
            --sidebar-bg: #ffffff;
            --text-dark: #0f172a;
            --text-gray: #64748b;
            --border: #e2e8f0;
            --card-radius: 12px;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            padding: 20px;
            box-sizing: border-box;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            background-color: #0ea5e9;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-text h2 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
        }

        .brand-text p {
            margin: 0;
            font-size: 11px;
            color: var(--text-gray);
        }

        .profile-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background-color: #eff6ff;
            border-radius: 10px;
            margin-bottom: 32px;
        }

        .profile-avatar {
            width: 36px;
            height: 36px;
            background-color: #3b82f6;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-info h4 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
        }

        .profile-info p {
            margin: 2px 0 0;
            font-size: 11px;
            color: #64748b;
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex: 1;
        }

        .nav-item {
            margin-bottom: 4px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 8px;
            color: #475569;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .nav-link.active {
            background-color: #eff6ff;
            color: #2563eb;
        }

        .nav-link:hover:not(.active) {
            background-color: #f1f5f9;
        }

        .nav-icon {
            width: 18px;
            height: 18px;
            stroke-width: 2;
        }

        .nav-bottom {
            margin-top: auto;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text-dark);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 24px;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #3b82f6;
        }

        /* Report Document */
        .report-doc {
            background: white;
            border-radius: 12px;
            padding: 48px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.03);
            max-width: 800px;
            margin: 0 auto;
        }

        .report-doc-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .report-doc-header h2 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 4px 0;
            letter-spacing: 0.5px;
        }

        .report-doc-header .subtitle {
            font-size: 13px;
            color: var(--text-gray);
            margin: 0 0 12px 0;
        }

        .report-doc-header .meta {
            font-size: 12px;
            color: var(--text-gray);
        }

        .report-doc-header .meta .separator {
            margin: 0 8px;
            color: #cbd5e1;
        }

        .section-divider {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin-bottom: 32px;
        }

        .section-divider-light {
            border: none;
            border-top: 1px solid #f1f5f9;
            margin-bottom: 32px;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 16px 0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 12px;
            font-size: 13px;
        }

        .info-label {
            color: var(--text-gray);
        }

        .info-value {
            font-weight: 600;
            color: var(--text-dark);
        }

        .kondisi-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .kondisi-aman { background: #d1fae5; color: #065f46; }
        .kondisi-waspada { background: #fef3c7; color: #92400e; }
        .kondisi-siaga { background: #ffedd5; color: #9a3412; }
        .kondisi-kritis { background: #fee2e2; color: #ef4444; }

        .description-text {
            font-size: 13px;
            line-height: 1.6;
            color: var(--text-gray);
        }

        .photo-grid {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .photo-item {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            width: 200px;
            background: #f8fafc;
        }

        .photo-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            display: block;
        }

        .photo-item .photo-label {
            padding: 12px;
            text-align: center;
            font-size: 11px;
            color: var(--text-gray);
            border-top: 1px solid #e2e8f0;
        }

        .no-photo {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            max-width: 400px;
            background: #f8fafc;
            padding: 40px 20px;
            text-align: center;
            color: #94a3b8;
        }

        .no-photo p {
            font-size: 12px;
            margin: 8px 0 0;
        }

        .report-doc-footer {
            text-align: center;
            color: #94a3b8;
            font-size: 11px;
            line-height: 1.6;
        }

        /* Footer Actions */
        .footer-actions {
            position: sticky;
            bottom: 0;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(8px);
            padding: 20px 40px;
            margin: 40px -40px -40px -40px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: flex-end;
            gap: 16px;
        }

        .btn-back {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: white;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            cursor: pointer;
            text-decoration: none;
            font-family: inherit;
            transition: all 0.2s;
        }

        .btn-back:hover {
            border-color: #3b82f6;
            color: #3b82f6;
        }

        .btn-action-approve {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: #10b981;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            color: white;
            cursor: pointer;
            font-family: inherit;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            transition: all 0.2s;
        }

        .btn-action-approve:hover {
            background: #059669;
        }

        .btn-action-reject {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: #ef4444;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            color: white;
            cursor: pointer;
            font-family: inherit;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
            transition: all 0.2s;
        }

        .btn-action-reject:hover {
            background: #dc2626;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="white" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>
                </svg>
            </div>
            <div class="brand-text">
                <h2>GWM</h2>
                <p>Gunungkidul Water Monitor</p>
            </div>
        </div>

        <div class="profile-card">
            <div class="profile-avatar">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="profile-info">
                <h4>Administrator</h4>
                <p>{{ auth()->user()->nama ?? 'Admin Gunungkidul' }}</p>
            </div>
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.create_petugas') }}" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
                    Buat Akun Petugas
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.validasi') }}" class="nav-link active">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="20 6 9 17 4 12"/></svg>
                    Validasi
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    Prioritas
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    Tindak Lanjut
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    Monitoring
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    Log Aktivitas
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Export Data
                </a>
            </li>
        </ul>

        <div class="nav-bottom">
            <a href="/logout" class="nav-link">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Keluar
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <a href="{{ route('admin.validasi') }}" class="back-link">
            <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Kembali ke Validasi
        </a>

        <div class="report-doc">
            <div class="report-doc-header">
                <h2>LAPORAN KONDISI KEKERINGAN</h2>
                <p class="subtitle">Gunungkidul Water Monitor (GWM)</p>
                <div class="meta">
                    Tanggal: <strong>{{ \Carbon\Carbon::parse($laporan->created_at)->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY') }}</strong>
                    <span class="separator">|</span>
                    Kecamatan: <strong>{{ $laporan->kecamatan->nama_kecamatan ?? '-' }}</strong>
                </div>
            </div>

            <hr class="section-divider">

            <!-- 1. Informasi Wilayah -->
            <div style="margin-bottom: 32px;">
                <h3 class="section-title">1. Informasi Wilayah</h3>
                <div class="info-grid">
                    <div class="info-label">Kecamatan</div>
                    <div class="info-value">: {{ $laporan->kecamatan->nama_kecamatan ?? '-' }}</div>
                    <div class="info-label">Kelurahan</div>
                    <div class="info-value">: Kelurahan {{ $laporan->kelurahan->nama_kelurahan ?? '-' }}</div>
                </div>
            </div>

            <hr class="section-divider-light">

            <!-- 2. Kondisi Kekeringan -->
            <div style="margin-bottom: 32px;">
                <h3 class="section-title">2. Kondisi Kekeringan</h3>
                <div class="info-grid" style="align-items: center;">
                    <div class="info-label">Kondisi Air</div>
                    <div>
                        @php
                            $kondisiLabels = [
                                'aman' => 'Aman',
                                'waspada' => 'Waspada',
                                'siaga' => 'Siaga',
                                'kritis' => 'Parah - Kekeringan',
                            ];
                            $kondisiLabel = $kondisiLabels[$laporan->kondisi_air] ?? ucfirst($laporan->kondisi_air);
                        @endphp
                        : <span class="kondisi-badge kondisi-{{ $laporan->kondisi_air }}">{{ $kondisiLabel }}</span>
                    </div>
                    <div class="info-label">Warga Terdampak</div>
                    <div class="info-value">: {{ $laporan->jumlah_terdampak ?? 0 }} jiwa</div>
                    <div class="info-label">Durasi</div>
                    <div class="info-value">: {{ $laporan->durasi_hari ?? 0 }} hari</div>
                </div>
            </div>

            <hr class="section-divider-light">

            <!-- 3. Deskripsi Kondisi -->
            <div style="margin-bottom: 32px;">
                <h3 class="section-title">3. Deskripsi Kondisi</h3>
                <p class="description-text">
                    {{ $laporan->catatan ?? '-' }}
                </p>
            </div>

            <hr class="section-divider-light">

            <!-- 4. Dokumentasi -->
            <div style="margin-bottom: 48px;">
                <h3 class="section-title">4. Dokumentasi</h3>
                @if($laporan->fotos->count() > 0)
                    <div class="photo-grid">
                        @foreach($laporan->fotos as $index => $foto)
                            <div class="photo-item">
                                <img src="{{ asset('storage/' . $foto->path_foto) }}" alt="Dokumentasi {{ $index + 1 }}">
                                <div class="photo-label">Foto {{ $index + 1 }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="no-photo">
                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        <p>Tidak ada dokumentasi foto</p>
                    </div>
                @endif
            </div>

            <hr class="section-divider">

            <div class="report-doc-footer">
                Laporan ini dibuat melalui sistem GWM (Gunungkidul Water Monitor)<br>
                Diajukan oleh: {{ $laporan->user->nama ?? '-' }}
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="footer-actions">
            <a href="{{ route('admin.validasi') }}" class="btn-back">
                <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Kembali
            </a>

            @if($laporan->status === 'diajukan')
                <form action="{{ route('admin.reject_laporan', $laporan->id) }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn-action-reject" onclick="return confirm('Reject laporan ini?');">
                        <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        Reject
                    </button>
                </form>
                <form action="{{ route('admin.approve_laporan', $laporan->id) }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn-action-approve" onclick="return confirm('Approve laporan ini?');">
                        <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        Approve
                    </button>
                </form>
            @endif
        </div>
    </main>
</body>
</html>
