<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWM - Dashboard Petugas</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --bg-body: #f4f8fb;
            --bg-sidebar: #ffffff;
            --bg-card: #ffffff;
            --text-dark: #1e293b;
            --text-gray: #64748b;
            --primary: #63a4d9;
            --primary-gradient: linear-gradient(135deg, #70b4df, #528fc3);
            --border: #f1f5f9;
            --shadow-sm: 0 2px 10px rgba(0,0,0,0.02);
            --shadow-md: 0 8px 30px rgba(0,0,0,0.04);
            --radius-md: 12px;
            --radius-lg: 16px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Public Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background-color: var(--bg-sidebar);
            display: flex;
            flex-direction: column;
            padding: 24px;
            border-right: 1px solid var(--border);
            z-index: 10;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 32px;
            padding-left: 8px;
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            background: var(--primary-gradient);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 4px 12px rgba(99, 164, 217, 0.3);
        }

        .brand-text h2 {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
            line-height: 1.2;
        }

        .brand-text p {
            font-size: 11px;
            color: var(--text-gray);
        }

        .profile-container {
            background-color: #f8fbfe;
            border: 1px solid #e2f0fb;
            border-radius: var(--radius-lg);
            padding: 16px;
            margin-bottom: 32px;
        }

        .profile-top {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px dashed #cce3f5;
        }

        .profile-avatar {
            width: 40px;
            height: 40px;
            background-color: #63a4d9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .profile-info h4 {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .profile-info p {
            font-size: 12px;
            color: var(--text-gray);
            margin-top: 2px;
        }

        .profile-bottom {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .profile-bottom svg {
            color: var(--primary);
        }

        .profile-location {
            display: flex;
            flex-direction: column;
        }

        .profile-location span {
            font-size: 10px;
            color: var(--text-gray);
        }

        .profile-location strong {
            font-size: 13px;
            color: var(--primary);
            font-weight: 600;
        }

        .nav-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
        }

        .nav-item a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            border-radius: var(--radius-md);
            color: var(--text-gray);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .nav-item a svg {
            stroke-width: 2;
        }

        .nav-item a.active {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 14px rgba(99, 164, 217, 0.3);
            font-weight: 600;
        }

        .nav-item a:hover:not(.active) {
            background-color: #f8fbfe;
            color: var(--primary);
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

        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 32px;
        }

        .page-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: #2b567a;
            margin-bottom: 6px;
        }

        .page-title p {
            font-size: 14px;
            color: var(--text-gray);
        }

        .top-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            background-color: white;
            padding: 10px 16px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 500;
            color: var(--primary);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            padding: 24px;
            box-shadow: var(--shadow-md);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-info {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .stat-label {
            font-size: 13px;
            color: var(--text-gray);
            font-weight: 500;
        }

        .stat-val {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-blue { background-color: #63a4d9; color: white; }
        .icon-yellow { background-color: #f5b94f; color: white; }
        .icon-teal { background-color: #4fbab5; color: white; }
        .icon-green { background-color: #649e7a; color: white; }

        /* Middle Section */
        .middle-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            margin-bottom: 32px;
        }

        .card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            padding: 24px;
            box-shadow: var(--shadow-md);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }

        .card-header::before {
            content: '';
            width: 4px;
            height: 16px;
            background-color: var(--primary);
            border-radius: 4px;
        }

        .card-header h3 {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .chart-container-inner {
            height: 250px;
            width: 100%;
        }

        .actions-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 14px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 12px rgba(99, 164, 217, 0.2);
        }

        .btn-primary:hover {
            box-shadow: 0 6px 16px rgba(99, 164, 217, 0.3);
            transform: translateY(-1px);
        }

        .btn-outline {
            background: white;
            color: var(--text-dark);
            border: 1px solid #e2e8f0;
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Bottom Section */
        .card-header-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .card-header-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .card-header-left::before {
            content: '';
            width: 4px;
            height: 16px;
            background-color: var(--primary);
            border-radius: 4px;
        }

        .card-header-left h3 {
            font-size: 15px;
            font-weight: 700;
        }

        .link-all {
            font-size: 13px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
            color: var(--text-gray);
            border: 1px dashed #cbd5e1;
            border-radius: var(--radius-md);
            background-color: #f8fafc;
        }

        .empty-state svg {
            width: 48px;
            height: 48px;
            margin-bottom: 16px;
            color: #94a3b8;
        }

        .empty-state p {
            font-size: 14px;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="brand" style="margin-bottom: 24px; padding: 0;">
            <img src="{{ asset('images/logo-gwm.png') }}" alt="GWM Logo" style="width: 100%; max-height: 80px; object-fit: contain;">
        </div>

        <div class="profile-container">
            <div class="profile-top">
                <div class="profile-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <div class="profile-info">
                    <h4>Petugas</h4>
                    <p>{{ auth()->user()->name ?? 'Petugas Kecamatan' }}</p>
                </div>
            </div>
            <div class="profile-bottom">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
                <div class="profile-location">
                    <span>Wilayah Aktif</span>
                    <strong>Kecamatan {{ auth()->user()->name ?? 'Gedangsari' }}</strong>
                </div>
            </div>
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('petugas.dashboard') }}">
                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('petugas.laporan.index') }}">
                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    Laporan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('petugas.draft') }}">
                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/><path d="M12 18v-5M9 15h6"></path></svg>
                    Draft
                </a>
            </li>
            <li class="nav-item">
                <a href="#">
                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                    Notifikasi
                </a>
            </li>
        </ul>

        <div class="nav-bottom">
            <li class="nav-item" style="list-style: none;">
                <a href="/logout">
                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Keluar
                </a>
            </li>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div style="margin-bottom: 24px;">
            <a href="{{ route('petugas.edit_laporan', $laporan->id) }}" style="display: inline-flex; align-items: center; gap: 8px; color: var(--text-dark); text-decoration: none; font-size: 14px; font-weight: 600;">
                <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Kembali
            </a>
        </div>
        
        <div class="page-title" style="margin-bottom: 32px;">
            <h1 style="font-size: 28px; color: var(--text-dark);">Preview Laporan</h1>
        </div>

        <div style="background: white; border-radius: 12px; padding: 48px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); max-width: 800px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 32px;">
                <h2 style="font-size: 18px; font-weight: 700; color: var(--text-dark); margin-bottom: 4px; letter-spacing: 0.5px;">LAPORAN KONDISI KEKERINGAN</h2>
                <p style="font-size: 13px; color: var(--text-gray); margin-bottom: 12px;">Gunungkidul Water Monitor (GWM)</p>
                <div style="font-size: 12px; color: var(--text-gray);">
                    Tanggal: {{ $laporan->created_at->format('d F Y') }} <span style="margin: 0 8px; color: #cbd5e1;">|</span> Kecamatan: {{ $laporan->kecamatan }}
                </div>
            </div>

            <hr style="border: none; border-top: 1px solid #e2e8f0; margin-bottom: 32px;">

            <!-- 1. Informasi Wilayah -->
            <div style="margin-bottom: 32px;">
                <h3 style="font-size: 14px; font-weight: 700; color: var(--text-dark); margin-bottom: 16px;">1. Informasi Wilayah</h3>
                <div style="display: grid; grid-template-columns: 200px 1fr; gap: 12px; font-size: 13px;">
                    <div style="color: var(--text-gray);">Kecamatan</div>
                    <div style="font-weight: 600; color: var(--text-dark);">: {{ $laporan->kecamatan }}</div>
                    <div style="color: var(--text-gray);">Kelurahan</div>
                    <div style="font-weight: 600; color: var(--text-dark);">: {{ $laporan->kelurahan ?? '-' }}</div>
                </div>
            </div>

            <hr style="border: none; border-top: 1px solid #f1f5f9; margin-bottom: 32px;">

            <!-- 2. Kondisi Kekeringan -->
            <div style="margin-bottom: 32px;">
                <h3 style="font-size: 14px; font-weight: 700; color: var(--text-dark); margin-bottom: 16px;">2. Kondisi Kekeringan</h3>
                <div style="display: grid; grid-template-columns: 200px 1fr; gap: 16px; font-size: 13px; align-items: center;">
                    <div style="color: var(--text-gray);">Kondisi Air</div>
                    <div>
                        : <span style="display: inline-block; padding: 4px 12px; background: #fee2e2; color: #ef4444; border-radius: 20px; font-size: 11px; font-weight: 600;">{{ $laporan->kondisi_air ?? 'Kritis' }}</span>
                    </div>
                    <div style="color: var(--text-gray);">Warga Terdampak</div>
                    <div style="font-weight: 700; color: var(--text-dark);">: {{ $laporan->warga_terdampak ?? 0 }} jiwa</div>
                    <div style="color: var(--text-gray);">Durasi</div>
                    <div style="font-weight: 700; color: var(--text-dark);">: {{ $laporan->durasi_kekeringan ?? 0 }} hari</div>
                </div>
            </div>

            <hr style="border: none; border-top: 1px solid #f1f5f9; margin-bottom: 32px;">

            <!-- 3. Deskripsi Kondisi -->
            <div style="margin-bottom: 32px;">
                <h3 style="font-size: 14px; font-weight: 700; color: var(--text-dark); margin-bottom: 16px;">3. Deskripsi Kondisi</h3>
                <p style="font-size: 13px; line-height: 1.6; color: var(--text-gray);">
                    {{ $laporan->keterangan ?? '-' }}
                </p>
            </div>

            <hr style="border: none; border-top: 1px solid #f1f5f9; margin-bottom: 32px;">

            <!-- 4. Dokumentasi -->
            <div style="margin-bottom: 48px;">
                <h3 style="font-size: 14px; font-weight: 700; color: var(--text-dark); margin-bottom: 16px;">4. Dokumentasi</h3>
                @if($laporan->foto)
                    @php
                        $fotosArray = json_decode($laporan->foto, true);
                        if (!is_array($fotosArray)) {
                            $fotosArray = [$laporan->foto];
                        }
                    @endphp
                    <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                        @foreach($fotosArray as $index => $fotoPath)
                            <div style="border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; width: 200px; background: #f8fafc;">
                                <img src="{{ asset('storage/' . $fotoPath) }}" alt="Dokumentasi {{ $index + 1 }}" style="width: 100%; height: 150px; object-fit: cover; display: block;">
                                <div style="padding: 12px; text-align: center; font-size: 11px; color: var(--text-gray); border-top: 1px solid #e2e8f0;">Foto {{ $index + 1 }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; max-width: 400px; background: #f8fafc;">
                        <div style="padding: 40px 20px; text-align: center; color: #94a3b8;">
                            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 8px;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                            <p style="font-size: 12px;">Tidak ada dokumentasi</p>
                        </div>
                    </div>
                @endif
            </div>

            <hr style="border: none; border-top: 1px solid #e2e8f0; margin-bottom: 24px;">

            <div style="text-align: center; color: #94a3b8; font-size: 11px; line-height: 1.6;">
                Laporan ini dibuat melalui sistem GWM (Gunungkidul Water Monitor)<br>
                Periksa kembali data sebelum mengirim laporan
            </div>
        </div>

        <!-- Float Footer -->
        <div style="position: sticky; bottom: 0; background: rgba(255,255,255,0.9); backdrop-filter: blur(8px); padding: 20px 40px; margin: 40px -40px -40px -40px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 16px;">
            <a href="{{ route('petugas.edit_laporan', $laporan->id) }}" style="display: flex; align-items: center; gap: 8px; padding: 12px 24px; background: white; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; font-weight: 600; color: var(--text-dark); cursor: pointer; text-decoration: none; font-family: inherit;">
                <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                Edit Laporan
            </a>
            <form action="{{ route('petugas.submit_laporan', $laporan->id) }}" method="POST">
                @csrf
                <button type="submit" style="display: flex; align-items: center; gap: 8px; padding: 12px 24px; background: #6366f1; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; color: white; cursor: pointer; font-family: inherit; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);">
                    <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    Submit Laporan
                </button>
            </form>
        </div>
    </main>
</body>
</html>