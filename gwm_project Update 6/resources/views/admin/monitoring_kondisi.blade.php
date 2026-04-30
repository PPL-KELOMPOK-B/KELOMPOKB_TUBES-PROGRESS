<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWM - Detail Level Kondisi {{ $laporan->kode }}</title>
    <meta name="description" content="Detail level kondisi laporan {{ $laporan->kode }} - Gunungkidul Water Monitor">
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

        .breadcrumb {
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 24px; font-size: 14px;
        }

        .breadcrumb a {
            color: var(--primary); text-decoration: none; font-weight: 500;
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

        /* Level Display */
        .level-container {
            text-align: center;
            padding: 20px 0;
        }

        .level-badge-large {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 32px;
            border-radius: 16px;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: white;
            background: linear-gradient(135deg, {{ $laporan->level_color }}, {{ $laporan->level_color }}cc);
            box-shadow: 0 4px 20px {{ $laporan->level_color }}44;
            margin-bottom: 16px;
        }

        .level-score {
            font-size: 14px;
            color: var(--text-gray);
            font-weight: 500;
        }

        .level-score strong {
            color: {{ $laporan->level_color }};
            font-size: 18px;
        }

        /* Parameter Cards */
        .parameter-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .parameter-item {
            padding: 18px 20px;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid #f1f5f9;
            transition: var(--transition);
        }

        .parameter-item:hover {
            background: white;
            border-color: var(--border);
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .parameter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .parameter-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .parameter-value {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-gray);
        }

        .parameter-bar {
            width: 100%;
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 6px;
        }

        .parameter-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .parameter-fill.low { background: linear-gradient(90deg, #10b981, #34d399); }
        .parameter-fill.medium { background: linear-gradient(90deg, #eab308, #facc15); }
        .parameter-fill.high { background: linear-gradient(90deg, #f97316, #fb923c); }
        .parameter-fill.critical { background: linear-gradient(90deg, #ef4444, #f87171); }

        .parameter-score {
            font-size: 12px;
            color: var(--text-gray);
            text-align: right;
        }

        /* Total score */
        .total-score {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            background: linear-gradient(135deg, {{ $laporan->level_color }}11, {{ $laporan->level_color }}08);
            border-radius: 12px;
            border: 1px solid {{ $laporan->level_color }}33;
            margin-top: 16px;
        }

        .total-score-label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .total-score-value {
            font-size: 20px;
            font-weight: 700;
            color: {{ $laporan->level_color }};
        }

        /* Description */
        .condition-desc {
            font-size: 14px;
            line-height: 1.7;
            color: #475569;
            padding: 20px;
            background: linear-gradient(135deg, {{ $laporan->level_color }}08, {{ $laporan->level_color }}05);
            border-radius: 12px;
            border-left: 4px solid {{ $laporan->level_color }};
        }

        /* Scale Legend */
        .scale-legend {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-top: 8px;
        }

        .scale-item {
            padding: 14px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid transparent;
            transition: var(--transition);
        }

        .scale-item.active {
            border-color: {{ $laporan->level_color }};
            background: {{ $laporan->level_color }}08;
        }

        .scale-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin: 0 auto 8px;
        }

        .scale-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .scale-range {
            font-size: 11px;
            color: var(--text-gray);
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
            .scale-legend { grid-template-columns: 1fr; }
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
            <span>Detail Level Kondisi</span>
            <span>/</span>
            <span>{{ $laporan->kode }}</span>
        </div>

        <div class="page-header">
            <h1>Detail Level Kondisi</h1>
            <p>Desa {{ $laporan->kelurahan }}, {{ str_replace('Petugas ', '', $laporan->kecamatan) }} — {{ $laporan->kode }}</p>
        </div>

        <div class="detail-grid">
            <!-- Level Indicator -->
            <div class="detail-card">
                <h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="{{ $laporan->level_color }}" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                    </svg>
                    Level Kondisi
                </h3>
                <div class="level-container">
                    <div class="level-badge-large">{{ $laporan->level_kondisi }}</div>
                    <div class="level-score">
                        Skor Penilaian: <strong>{{ $laporan->skor_kondisi }}</strong> / 9
                    </div>
                </div>

                <div class="condition-desc" style="margin-top: 16px;">
                    {{ $laporan->deskripsi_kondisi }}
                </div>
            </div>

            <!-- Parameter Assessment -->
            <div class="detail-card">
                <h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="20" x2="18" y2="10"/>
                        <line x1="12" y1="20" x2="12" y2="4"/>
                        <line x1="6" y1="20" x2="6" y2="14"/>
                    </svg>
                    Parameter Penilaian
                </h3>
                <div class="parameter-list">
                    @foreach($laporan->parameter as $param)
                        <div class="parameter-item">
                            <div class="parameter-header">
                                <span class="parameter-name">{{ $param['nama'] }}</span>
                                <span class="parameter-value">{{ $param['nilai'] }}</span>
                            </div>
                            <div class="parameter-bar">
                                <div class="parameter-fill {{ $param['skor'] >= 3 ? 'critical' : ($param['skor'] >= 2 ? 'high' : 'low') }}"
                                     style="width: {{ ($param['skor'] / $param['max']) * 100 }}%"></div>
                            </div>
                            <div class="parameter-score">Skor: {{ $param['skor'] }} / {{ $param['max'] }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="total-score">
                    <span class="total-score-label">Total Skor</span>
                    <span class="total-score-value">{{ $laporan->skor_kondisi }} / 9</span>
                </div>
            </div>

            <!-- Scale Legend -->
            <div class="detail-card full-width">
                <h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="16" x2="12" y2="12"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                    Skala Penilaian Level Kondisi
                </h3>
                <div class="scale-legend">
                    <div class="scale-item {{ $laporan->level_kondisi === 'Waspada' ? 'active' : '' }}" style="background: #fefce811;">
                        <div class="scale-dot" style="background: #eab308;"></div>
                        <div class="scale-label">Waspada</div>
                        <div class="scale-range">Skor 3 — 4</div>
                    </div>
                    <div class="scale-item {{ $laporan->level_kondisi === 'Siaga' ? 'active' : '' }}" style="background: #fff7ed11;">
                        <div class="scale-dot" style="background: #f97316;"></div>
                        <div class="scale-label">Siaga</div>
                        <div class="scale-range">Skor 5 — 6</div>
                    </div>
                    <div class="scale-item {{ $laporan->level_kondisi === 'Darurat' ? 'active' : '' }}" style="background: #fef2f211;">
                        <div class="scale-dot" style="background: #dc2626;"></div>
                        <div class="scale-label">Darurat</div>
                        <div class="scale-range">Skor 7 — 9</div>
                    </div>
                </div>
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
