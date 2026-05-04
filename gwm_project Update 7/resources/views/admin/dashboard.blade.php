<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWM - Dashboard Administrator</title>
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --bg-color: #f8fafc;
            --sidebar-bg: #ffffff;
            --text-dark: #0f172a;
            --text-gray: #64748b;
            --primary: #blue;
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

        /* Sidebar Styles */
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

        .page-header {
            margin-bottom: 32px;
        }

        .page-header h1 {
            margin: 0 0 8px 0;
            font-size: 28px;
            font-weight: 600;
        }

        .page-header p {
            margin: 0;
            color: var(--text-gray);
            font-size: 15px;
        }

        /* Stat Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: white;
            border-radius: var(--card-radius);
            padding: 20px;
            border: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .stat-info {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .stat-label {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-gray);
        }

        .stat-value {
            font-size: 32px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
            line-height: 1;
        }

        .stat-extra {
            font-size: 13px;
            color: var(--text-gray);
            margin: 0;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Icons Colors */
        .icon-blue {
            background-color: #eff6ff;
            color: #3b82f6;
        }

        .icon-red {
            background-color: #fef2f2;
            color: #ef4444;
        }

        .icon-orange {
            background-color: #fff7ed;
            color: #f97316;
        }

        .icon-green {
            background-color: #f0fdf4;
            color: #10b981;
        }

        /* Laporan Prioritas Tinggi Section */
        .monitoring-section {
            background: white;
            border-radius: var(--card-radius);
            padding: 28px;
            border: 1px solid var(--border);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .monitoring-section h3 {
            margin: 0 0 24px 0;
            font-size: 16px;
            font-weight: 600;
        }

        .report-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .report-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: white;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .report-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
        }

        .report-card.kritis::before { background: #ef4444; }
        .report-card.tinggi::before { background: #f97316; }
        .report-card.sedang::before { background: #eab308; }
        .report-card.rendah::before { background: #10b981; }

        .report-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .report-info {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .report-meta {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .report-code {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-gray);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-kritis { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .badge-tinggi { background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; }
        .badge-sedang { background: #fefce8; color: #a16207; border: 1px solid #fde68a; }
        .badge-rendah { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }

        .report-location {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .report-stats {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 13px;
            color: var(--text-gray);
        }

        .report-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
        }

        .btn-detail {
            display: inline-flex;
            align-items: center;
            flex-direction: column;
            gap: 2px;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            border: 1px solid var(--border);
            background: white;
            color: #475569;
            text-align: center;
            line-height: 1.3;
        }

        .btn-detail span {
            font-weight: 600;
            color: var(--text-dark);
        }

        .btn-detail:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .empty-monitoring {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-gray);
            font-size: 14px;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .report-card { animation: slideUp 0.3s ease forwards; }
        .report-card:nth-child(1) { animation-delay: 0.05s; }
        .report-card:nth-child(2) { animation-delay: 0.1s; }
        .report-card:nth-child(3) { animation-delay: 0.15s; }
        .report-card:nth-child(4) { animation-delay: 0.2s; }
        .report-card:nth-child(5) { animation-delay: 0.25s; }

        /* Distribusi & Keterangan Section */
        .distribusi-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 32px;
        }

        .distribusi-card {
            background: white;
            border-radius: var(--card-radius);
            padding: 28px;
            border: 1px solid var(--border);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .distribusi-card h3 {
            margin: 0 0 24px 0;
            font-size: 16px;
            font-weight: 600;
        }

        .chart-container {
            position: relative;
            width: 100%;
            max-width: 320px;
            margin: 0 auto;
        }

        .chart-legend {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 16px;
            margin-top: 20px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--text-gray);
            font-weight: 500;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* Keterangan Items */
        .keterangan-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .keterangan-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 16px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: white;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .keterangan-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
        }

        .keterangan-item.status-kritis::before { background: #ef4444; }
        .keterangan-item.status-tinggi::before { background: #f97316; }
        .keterangan-item.status-sedang::before { background: #eab308; }
        .keterangan-item.status-rendah::before { background: #10b981; }

        .keterangan-item:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            transform: translateY(-1px);
        }

        .keterangan-rank {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }

        .rank-kritis { background: #ef4444; }
        .rank-tinggi { background: #f97316; }
        .rank-sedang { background: #eab308; }
        .rank-rendah { background: #10b981; }

        .keterangan-content {
            flex: 1;
            min-width: 0;
        }

        .keterangan-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 4px;
        }

        .keterangan-desa {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .keterangan-badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .keterangan-meta {
            font-size: 12px;
            color: var(--text-gray);
            margin-bottom: 4px;
        }

        .keterangan-desc {
            font-size: 12px;
            color: #94a3b8;
            line-height: 1.5;
        }

        .keterangan-item { animation: slideUp 0.3s ease forwards; }
        .keterangan-item:nth-child(1) { animation-delay: 0.05s; }
        .keterangan-item:nth-child(2) { animation-delay: 0.1s; }
        .keterangan-item:nth-child(3) { animation-delay: 0.15s; }
        .keterangan-item:nth-child(4) { animation-delay: 0.2s; }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="brand" style="margin-bottom: 24px; padding: 0;">
            <img src="{{ asset('images/logo-gwm.png') }}" alt="GWM Logo"
                style="width: 100%; max-height: 80px; object-fit: contain;">
        </div>

        <div class="profile-card">
            <div class="profile-avatar">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="profile-info">
                <h4>Administrator</h4>
                <p>Admin</p>
            </div>
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <rect x="3" y="3" width="7" height="9" rx="1" />
                        <rect x="14" y="3" width="7" height="5" rx="1" />
                        <rect x="14" y="12" width="7" height="9" rx="1" />
                        <rect x="3" y="16" width="7" height="5" rx="1" />
                    </svg>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.create_petugas') }}" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <line x1="19" y1="8" x2="19" y2="14"></line>
                        <line x1="22" y1="11" x2="16" y2="11"></line>
                    </svg>
                    Buat Akun Petugas
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.validasi.index') }}" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Validasi
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                    Prioritas
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                        <polyline points="10 9 9 9 8 9" />
                    </svg>
                    Tindak Lanjut
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                    Monitoring
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                        <polyline points="10 9 9 9 8 9" />
                    </svg>
                    Log Aktivitas
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" y1="15" x2="12" y2="3" />
                    </svg>
                    Export Data
                </a>
            </li>
        </ul>

        <div class="nav-bottom">
            <a href="/logout" class="nav-link">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
                Keluar
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header">
            <h1>Dashboard Administrator</h1>
            <p>Monitor kondisi kekeringan di seluruh wilayah Gunungkidul</p>
        </div>

        <!-- Five Stat Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-info">
                    <span class="stat-label">Total Laporan</span>
                    <span class="stat-value">{{ $total }}</span>
                </div>
                <div class="stat-icon icon-blue">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <span class="stat-label">Laporan Kritis</span>
                    <span class="stat-value">{{ $kritis }}</span>
                </div>
                <div class="stat-icon icon-red">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z">
                        </path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <span class="stat-label">Warga Terdampak</span>
                    <div>
                        <span class="stat-value">{{ number_format($warga_terdampak) }}</span>
                        <span class="stat-extra">jiwa</span>
                    </div>
                </div>
                <div class="stat-icon icon-orange">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <span class="stat-label">Tervalidasi</span>
                    <span class="stat-value">{{ $tervalidasi }}</span>
                </div>
                <div class="stat-icon icon-green">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <span class="stat-label">Tidak Tervalidasi</span>
                    <span class="stat-value">{{ $tidak_tervalidasi ?? 0 }}</span>
                </div>
                <div class="stat-icon icon-red">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Distribusi & Keterangan Section -->
        <div class="distribusi-section">
            <!-- Kiri: Pie Chart -->
            <div class="distribusi-card">
                <h3>Distribusi Tingkat Kekeringan</h3>
                <div class="chart-container">
                    <canvas id="distribusiChart"></canvas>
                </div>
                <div class="chart-legend">
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #10b981;"></span>
                        Rendah: {{ $rendah ?? 0 }}
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #eab308;"></span>
                        Sedang: {{ $sedang ?? 0 }}
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #f97316;"></span>
                        Tinggi: {{ $tinggi ?? 0 }}
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #ef4444;"></span>
                        Kritis: {{ $kritis ?? 0 }}
                    </div>
                </div>
            </div>

            <!-- Kanan: Keterangan -->
            <div class="distribusi-card">
                <h3>Keterangan</h3>
                <div class="keterangan-list">

                    @forelse($desaRanking as $index => $item)
                        <div class="keterangan-item status-{{ $item->tipe }}">
                            <div class="keterangan-rank rank-{{ $item->tipe }}">#{{ $index + 1 }}</div>
                            <div class="keterangan-content">
                                <div class="keterangan-header">
                                    <span class="keterangan-desa">Desa {{ $item->kelurahan }}</span>
                                    <span class="keterangan-badge badge-{{ $item->tipe }}">{{ $item->status_text }}</span>
                                </div>
                                <div class="keterangan-meta">{{ $item->warna_text }}: {{ $item->status_text }} · {{ number_format($item->warga_terdampak) }} Warga Terdampak</div>
                                <div class="keterangan-desc">{{ $item->desc }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-monitoring" style="padding: 20px 0;">
                            <p>Belum ada data laporan masuk.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Laporan Prioritas Tinggi -->
        <div class="monitoring-section">
            <h3>Laporan Prioritas Tinggi</h3>

            @if($laporanPrioritas->count() > 0)
                <div class="report-list">
                    @foreach($laporanPrioritas as $laporan)
                        <div class="report-card {{ strtolower($laporan->tingkat_kekeringan) }}">
                            <div class="report-info">
                                <div class="report-meta">
                                    <span class="report-code">{{ $laporan->kode }}</span>
                                    <span class="badge badge-{{ strtolower($laporan->tingkat_kekeringan) }}">
                                        {{ $laporan->tingkat_kekeringan }}
                                    </span>
                                </div>
                                <div class="report-location">
                                    Desa {{ $laporan->kelurahan }}, {{ str_replace('Petugas ', '', $laporan->kecamatan) }}
                                </div>
                                <div class="report-stats">
                                    {{ number_format($laporan->warga_terdampak) }} warga terdampak · {{ $laporan->durasi_kekeringan }} hari
                                </div>
                            </div>
                            <div class="report-actions">
                                <a href="{{ '#' }}" class="btn-detail" id="btn-kekeringan-{{ $laporan->id }}">
                                    <span>Detail</span>
                                    Tingkat Kekeringan
                                </a>
                                <a href="{{ '#' }}" class="btn-detail" id="btn-kondisi-{{ $laporan->id }}">
                                    <span>Detail</span>
                                    Level Kondisi
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-monitoring">
                    <p>Tidak ada laporan prioritas tinggi saat ini.</p>
                </div>
            @endif
        </div>
    </main>

    <script>
        // Pie Chart - Distribusi Tingkat Kekeringan
        const ctx = document.getElementById('distribusiChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Rendah', 'Sedang', 'Tinggi', 'Kritis'],
                datasets: [{
                    data: [
                        {{ ($rendah ?? 0) == 0 && ($sedang ?? 0) == 0 && ($tinggi ?? 0) == 0 && ($kritis ?? 0) == 0 ? 1 : ($rendah ?? 0) }},
                        {{ ($rendah ?? 0) == 0 && ($sedang ?? 0) == 0 && ($tinggi ?? 0) == 0 && ($kritis ?? 0) == 0 ? 1 : ($sedang ?? 0) }},
                        {{ ($rendah ?? 0) == 0 && ($sedang ?? 0) == 0 && ($tinggi ?? 0) == 0 && ($kritis ?? 0) == 0 ? 1 : ($tinggi ?? 0) }},
                        {{ ($rendah ?? 0) == 0 && ($sedang ?? 0) == 0 && ($tinggi ?? 0) == 0 && ($kritis ?? 0) == 0 ? 1 : ($kritis ?? 0) }}
                    ],
                    backgroundColor: ['#10b981', '#eab308', '#f97316', '#ef4444'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleFont: { family: 'Inter', size: 13, weight: '600' },
                        bodyFont: { family: 'Inter', size: 12 },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                //Ambil Data
                                const rawData = [
                                    {{ $rendah ?? 0 }},
                                    {{ $sedang ?? 0 }},
                                    {{ $tinggi ?? 0 }},
                                    {{ $kritis ?? 0 }}
                                ];
                                const actualValue = rawData[context.dataIndex];
                                const total = rawData.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((actualValue / total) * 100).toFixed(1) : 0;
                                return context.label + ': ' + actualValue + ' (' + percentage + '%)';
                            }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 800,
                    easing: 'easeOutQuart'
                }
            }
        });
    </script>

</body>

</html>
