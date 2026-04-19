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

        /* Report List Styles */
        .report-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .report-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s;
        }

        .report-card:hover {
            border-color: #63a4d9;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .report-main {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .report-top {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 4px;
        }

        .badge-id {
            background: #f1f5f9;
            color: #94a3b8;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            text-transform: uppercase;
        }

        .badge-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Status Colors Mapping */
        .status-menunggu { background: #e0f2fe; color: #0ea5e9; }
        .status-proses { background: #fef3c7; color: #d97706; }
        .status-selesai { background: #dcfce7; color: #15803d; }

        .report-title {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .report-meta {
            font-size: 13px;
            color: #64748b;
            font-weight: 400;
        }

        .report-date {
            font-size: 14px;
            color: #94a3b8;
            font-weight: 500;
            text-align: right;
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
                <a href="#" class="active">
                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="#">
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
        <div class="top-header">
            <div class="page-title">
                <h1>Dashboard</h1>
                <p>Selamat datang kembali, {{ auth()->user()->name ?? 'Budi Santoso' }}</p>
            </div>
            <div class="top-pill">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
                Kecamatan {{ auth()->user()->name ?? 'Purwosari' }}
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-info">
                    <span class="stat-label">Total Laporan</span>
                    <span class="stat-val">{{ $total }}</span>
                </div>
                <div class="stat-icon icon-blue">
                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-info">
                    <span class="stat-label">Menunggu Validasi</span>
                    <span class="stat-val">{{ $menunggu }}</span>
                </div>
                <div class="stat-icon icon-yellow">
                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <span class="stat-label">Sedang Diproses</span>
                    <span class="stat-val">{{ $proses }}</span>
                </div>
                <div class="stat-icon icon-teal">
                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <span class="stat-label">Selesai</span>
                    <span class="stat-val">{{ $selesai }}</span>
                </div>
                <div class="stat-icon icon-green">
                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
            </div>
        </div>

        <div class="middle-grid">
            <div class="card">
                <div class="card-header">
                    <h3>Distribusi Status Laporan</h3>
                </div>
                <div class="chart-container-inner">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Tindakan Cepat</h3>
                </div>
                <div class="actions-list">
                    <a href="{{ route('petugas.create_laporan') }}" class="action-btn btn-primary">
                        <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Buat Laporan Baru
                    </a>
                    <a href="{{ route('petugas.draft') }}" class="action-btn btn-outline">
                        <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        Lihat Draft Laporan
                    </a>
                    <a href="#" class="action-btn btn-outline">
                        <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        Lihat Semua Laporan
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header-between">
                <div class="card-header-left">
                    <h3>Laporan Terbaru</h3>
                </div>
                <a href="#" class="link-all">Lihat Semua</a>
            </div>
            
            @if($laporan->isEmpty())
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="9" y1="3" x2="9" y2="21"/></svg>
                    <p>Belum ada data laporan tersedia saat ini.</p>
                </div>
            @else
                <div class="report-list">
                    @foreach($laporan as $lap)
                        <div class="report-card">
                            <div class="report-main">
                                <div class="report-top">
                                    <span class="badge-id">R{{ str_pad($lap->id, 3, '0', STR_PAD_LEFT) }}</span>
                                    <span class="badge-status 
                                        @if($lap->status == 'menunggu_validasi') status-menunggu
                                        @elseif($lap->status == 'proses') status-proses
                                        @elseif($lap->status == 'selesai') status-selesai
                                        @else status-menunggu @endif">
                                        {{ str_replace('_', ' ', ucfirst($lap->status == 'menunggu_validasi' ? 'Menunggu Validasi' : $lap->status)) }}
                                    </span>
                                </div>
                                <h4 class="report-title">Kelurahan {{ $lap->kelurahan }}</h4>
                                <p class="report-meta">
                                    {{ $lap->warga_terdampak }} warga terdampak - {{ $lap->durasi_kekeringan }} hari kekeringan
                                </p>
                            </div>
                            <div class="report-date">
                                {{ $lap->created_at->format('d M Y') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </main>

    <script>
        // Draw empty chart matching the style
        const barCtx = document.getElementById('barChart').getContext('2d');
        
        // Buat custom gradient batang animasi
        const gradient = barCtx.createLinearGradient(0, 200, 0, 0);
        gradient.addColorStop(0, '#528fc3');
        gradient.addColorStop(1, '#81bde8');

        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Validasi', 'Proses', 'Selesai'],
                datasets: [{
                    label: 'Status Laporan',
                    // Data Validasi bertambah setelah disetujui (proses + selesai)
                    data: [{{ $proses + $selesai }}, {{ $proses }}, {{ $selesai }}],
                    backgroundColor: gradient,
                    borderRadius: 6,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: 5, 
                        ticks: { stepSize: 1, color: '#94a3b8' },
                        grid: { color: '#f1f5f9' }
                    },
                    x: {
                        ticks: { color: '#64748b', font: { weight: '500' } },
                        grid: { display: false }
                    }
                }
            }
        });
    </script>
</body>
</html>