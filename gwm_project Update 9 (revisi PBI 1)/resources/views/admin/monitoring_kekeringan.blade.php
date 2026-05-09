<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWM - Detail Tingkat Kekeringan {{ $laporan->kode }}</title>
    <meta name="description" content="Detail tingkat kekeringan laporan {{ $laporan->kode }} - Gunungkidul Water Monitor">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-color: #f8fafc;
            --sidebar-bg: #ffffff;
            --text-dark: #0f172a;
            --text-gray: #64748b;
            --primary: #2563eb;
            --border: #e2e8f0;
            --card-radius: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            padding: 20px;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
            overflow-y: auto;
        }

        .brand { display: flex; align-items: center; gap: 12px; margin-bottom: 24px; }
        .brand img { width: 100%; max-height: 80px; object-fit: contain; }

        .profile-card {
            display: flex; align-items: center; gap: 12px;
            padding: 12px; background: linear-gradient(135deg, #eff6ff, #e0f2fe);
            border-radius: 12px; margin-bottom: 32px;
        }

        .profile-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }

        .profile-info h4 { font-size: 14px; font-weight: 600; }
        .profile-info p { margin-top: 2px; font-size: 11px; color: var(--text-gray); }

        .nav-menu { list-style: none; flex: 1; }
        .nav-item { margin-bottom: 4px; }

        .nav-link {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 12px; border-radius: 10px; color: #475569;
            text-decoration: none; font-size: 14px; font-weight: 500;
            transition: var(--transition);
        }

        .nav-link.active {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            color: #2563eb; font-weight: 600;
        }

        .nav-link:hover:not(.active) { background-color: #f1f5f9; transform: translateX(4px); }
        .nav-icon { width: 18px; height: 18px; stroke-width: 2; flex-shrink: 0; }
        .nav-bottom { margin-top: auto; }

        .main-content {
            flex: 1; margin-left: 260px; padding: 40px;
            overflow-y: auto; min-height: 100vh;
        }

        /* Breadcrumb */
        .breadcrumb {
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 24px; font-size: 14px;
        }

        .breadcrumb a {
            color: var(--primary); text-decoration: none; font-weight: 500;
            transition: var(--transition);
        }

        .breadcrumb a:hover { text-decoration: underline; }
        .breadcrumb span { color: var(--text-gray); }

        .page-header { margin-bottom: 32px; }
        .page-header h1 { font-size: 26px; font-weight: 700; margin-bottom: 8px; letter-spacing: -0.5px; }
        .page-header p { color: var(--text-gray); font-size: 15px; }

        /* Detail Grid */
        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }

        .detail-card {
            background: white;
            border-radius: var(--card-radius);
            border: 1px solid var(--border);
            padding: 28px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            animation: slideUp 0.4s ease forwards;
        }

        .detail-card.full-width {
            grid-column: 1 / -1;
        }

        .detail-card h3 {
            font-size: 15px; font-weight: 600;
            color: var(--text-gray); margin-bottom: 20px;
            display: flex; align-items: center; gap: 8px;
        }

        .detail-card h3 svg {
            width: 18px; height: 18px; stroke-width: 2;
        }

        /* Severity Meter */
        .severity-container {
            text-align: center;
            padding: 20px 0;
        }

        .severity-level {
            font-size: 48px;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 8px;
            background: linear-gradient(135deg, {{ $laporan->badge_color }}, {{ $laporan->badge_color }}dd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .severity-bar {
            width: 100%;
            height: 12px;
            background: #f1f5f9;
            border-radius: 6px;
            overflow: hidden;
            margin: 16px 0;
            position: relative;
        }

        .severity-fill {
            height: 100%;
            border-radius: 6px;
            transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(90deg, #eab308, #f97316, #ef4444);
        }

        .severity-labels {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: var(--text-gray);
            font-weight: 500;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .info-item {
            padding: 16px;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid #f1f5f9;
        }

        .info-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .info-value {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .info-value.highlight {
            color: {{ $laporan->badge_color }};
        }

        /* Description */
        .description-text {
            font-size: 14px;
            line-height: 1.7;
            color: #475569;
            padding: 20px;
            background: #f8fafc;
            border-radius: 12px;
            border-left: 4px solid {{ $laporan->badge_color }};
        }

        /* Recommendations */
        .rekomendasi-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .rekomendasi-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            background: #f8fafc;
            border-radius: 10px;
            font-size: 14px;
            color: #334155;
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .rekomendasi-item:hover {
            background: white;
            border-color: var(--border);
            transform: translateX(4px);
        }

        .rekomendasi-num {
            width: 24px;
            height: 24px;
            background: linear-gradient(135deg, {{ $laporan->badge_color }}22, {{ $laporan->badge_color }}11);
            color: {{ $laporan->badge_color }};
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            flex-shrink: 0;
        }

        /* Back button */
        .btn-back {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 20px; border-radius: 10px;
            font-size: 14px; font-weight: 600;
            text-decoration: none; color: var(--text-gray);
            border: 1px solid var(--border); background: white;
            transition: var(--transition); margin-top: 8px;
        }

        .btn-back:hover {
            background: #f8fafc;
            transform: translateX(-4px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .btn-back svg { width: 16px; height: 16px; }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .detail-card:nth-child(1) { animation-delay: 0.05s; }
        .detail-card:nth-child(2) { animation-delay: 0.1s; }
        .detail-card:nth-child(3) { animation-delay: 0.15s; }
        .detail-card:nth-child(4) { animation-delay: 0.2s; }

        @media (max-width: 1024px) {
            .detail-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .sidebar { display: none; }
            .main-content { margin-left: 0; padding: 20px; }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="brand">
            <img src="{{ asset('images/logo-gwm.png') }}" alt="GWM Logo">
        </div>

        <div class="profile-card">
            <div class="profile-avatar">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                </svg>
            </div>
            <div class="profile-info">
                <h4>Administrator</h4>
                <p>Admin Gunungkidul</p>
            </div>
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <rect x="3" y="3" width="7" height="9" rx="1" /><rect x="14" y="3" width="7" height="5" rx="1" />
                        <rect x="14" y="12" width="7" height="9" rx="1" /><rect x="3" y="16" width="7" height="5" rx="1" />
                    </svg>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.validasi.index') }}" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Validasi
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                    </svg>
                    Monitoring
                </a>
            </li>
        </ul>

        <div class="nav-bottom">
            <a href="/logout" class="nav-link">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" /><line x1="21" y1="12" x2="9" y2="12" />
                </svg>
                Keluar
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Monitoring</a>
            <span>/</span>
            <span>Detail Tingkat Kekeringan</span>
            <span>/</span>
            <span>{{ $laporan->kode }}</span>
        </div>

        <div class="page-header">
            <h1>Detail Tingkat Kekeringan</h1>
            <p>Desa {{ $laporan->kelurahan }}, {{ str_replace('Petugas ', '', $laporan->kecamatan) }} — {{ $laporan->kode }}</p>
        </div>

        <div class="detail-grid">
            <!-- Severity Indicator -->
            <div class="detail-card">
                <h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="{{ $laporan->badge_color }}" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>
                    </svg>
                    Tingkat Kekeringan
                </h3>
                <div class="severity-container">
                    <div class="severity-level">{{ $laporan->tingkat_kekeringan }}</div>
                    <div class="severity-bar">
                        <div class="severity-fill" style="width: {{ $laporan->tingkat_kekeringan === 'Kritis' ? '100' : ($laporan->tingkat_kekeringan === 'Tinggi' ? '75' : '50') }}%"></div>
                    </div>
                    <div class="severity-labels">
                        <span>Rendah</span>
                        <span>Sedang</span>
                        <span>Tinggi</span>
                        <span>Kritis</span>
                    </div>
                </div>
            </div>

            <!-- Location Info -->
            <div class="detail-card">
                <h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    Informasi Wilayah
                </h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Kelurahan</div>
                        <div class="info-value">{{ $laporan->kelurahan }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Kecamatan</div>
                        <div class="info-value">{{ str_replace('Petugas ', '', $laporan->kecamatan) }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Warga Terdampak</div>
                        <div class="info-value highlight">{{ number_format($laporan->warga_terdampak) }} jiwa</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Durasi Kekeringan</div>
                        <div class="info-value highlight">{{ $laporan->durasi_kekeringan }} hari</div>
                    </div>
                    <div class="info-item" style="grid-column: 1 / -1;">
                        <div class="info-label">Kondisi Air</div>
                        <div class="info-value">{{ $laporan->kondisi_air }}</div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="detail-card full-width">
                <h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="16" x2="12" y2="12"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                    Deskripsi Kondisi
                </h3>
                <div class="description-text">
                    {{ $laporan->deskripsi_kekeringan }}
                </div>
            </div>

            <!-- Recommendations -->
            <div class="detail-card full-width">
                <h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 11l3 3L22 4"/>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                    </svg>
                    Rekomendasi Penanganan
                </h3>
                <ul class="rekomendasi-list">
                    @foreach($laporan->rekomendasi as $i => $rek)
                        <li class="rekomendasi-item">
                            <span class="rekomendasi-num">{{ $i + 1 }}</span>
                            <span>{{ $rek }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"/>
                <polyline points="12 19 5 12 12 5"/>
            </svg>
            Kembali ke Monitoring
        </a>
    </main>

</body>

</html>
