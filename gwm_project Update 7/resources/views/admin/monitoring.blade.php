<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWM - Dashboard Monitoring</title>
    <meta name="description" content="Dashboard Monitoring Kekeringan Gunungkidul Water Monitor - Laporan Prioritas Tinggi">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-color: #f8fafc;
            --sidebar-bg: #ffffff;
            --text-dark: #0f172a;
            --text-gray: #64748b;
            --primary: #2563eb;
            --primary-light: #eff6ff;
            --border: #e2e8f0;
            --card-radius: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            overflow-y: auto;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            padding: 0;
        }

        .brand img {
            width: 100%;
            max-height: 80px;
            object-fit: contain;
        }

        .profile-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: linear-gradient(135deg, #eff6ff 0%, #e0f2fe 100%);
            border-radius: 12px;
            margin-bottom: 32px;
            transition: var(--transition);
        }

        .profile-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
        }

        .profile-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .profile-info h4 {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .profile-info p {
            margin-top: 2px;
            font-size: 11px;
            color: var(--text-gray);
        }

        .nav-menu {
            list-style: none;
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
            border-radius: 10px;
            color: #475569;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: var(--transition);
        }

        .nav-link.active {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            color: #2563eb;
            font-weight: 600;
        }

        .nav-link:hover:not(.active) {
            background-color: #f1f5f9;
            transform: translateX(4px);
        }

        .nav-icon {
            width: 18px;
            height: 18px;
            stroke-width: 2;
            flex-shrink: 0;
        }

        .nav-bottom {
            margin-top: auto;
        }

        
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 40px;
            overflow-y: auto;
            min-height: 100vh;
        }

        .page-header {
            margin-bottom: 36px;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .page-header p {
            color: var(--text-gray);
            font-size: 15px;
        }

        
        .monitoring-section {
            background: white;
            border-radius: var(--card-radius);
            border: 1px solid var(--border);
            padding: 32px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 6px 24px rgba(0, 0, 0, 0.02);
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
        }

        .section-header-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ef4444;
        }

        .section-header h2 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .section-header .count-badge {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            font-size: 12px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            margin-left: 8px;
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
            padding: 24px;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            background: white;
            transition: var(--transition);
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
            border-radius: 4px 0 0 4px;
            transition: var(--transition);
        }

        .report-card.kritis::before {
            background: linear-gradient(180deg, #ef4444 0%, #dc2626 100%);
        }

        .report-card.tinggi::before {
            background: linear-gradient(180deg, #f97316 0%, #ea580c 100%);
        }

        .report-card.sedang::before {
            background: linear-gradient(180deg, #eab308 0%, #ca8a04 100%);
        }

        .report-card.rendah::before {
            background: linear-gradient(180deg, #10b981 0%, #059669 100%);
        }

        .report-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border-color: #cbd5e1;
        }

        .report-info {
            display: flex;
            flex-direction: column;
            gap: 8px;
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
            letter-spacing: 0.5px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .badge-kritis {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .badge-tinggi {
            background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
            color: #ea580c;
            border: 1px solid #fed7aa;
        }

        .badge-sedang {
            background: linear-gradient(135deg, #fefce8 0%, #fef9c3 100%);
            color: #a16207;
            border: 1px solid #fde68a;
        }

        .badge-rendah {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .report-location {
            font-size: 16px;
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

        .report-stats span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .report-stats svg {
            width: 14px;
            height: 14px;
            stroke-width: 2;
        }

        
        .report-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
        }

        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            border: 1px solid;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-kekeringan {
            background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
            color: #c2410c;
            border-color: #fed7aa;
        }

        .btn-kekeringan:hover {
            background: linear-gradient(135deg, #ffedd5 0%, #fed7aa 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.2);
        }

        .btn-kondisi {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            color: #1d4ed8;
            border-color: #bfdbfe;
        }

        .btn-kondisi:hover {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .btn-detail svg {
            width: 14px;
            height: 14px;
            stroke-width: 2.5;
        }

        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-gray);
        }

        .empty-state-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            color: #10b981;
        }

        .empty-state h3 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .empty-state p {
            font-size: 14px;
        }

        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .report-card {
            animation: slideUp 0.4s ease forwards;
        }

        .report-card:nth-child(1) { animation-delay: 0.05s; }
        .report-card:nth-child(2) { animation-delay: 0.1s; }
        .report-card:nth-child(3) { animation-delay: 0.15s; }
        .report-card:nth-child(4) { animation-delay: 0.2s; }
        .report-card:nth-child(5) { animation-delay: 0.25s; }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .monitoring-section {
            animation: fadeIn 0.5s ease;
        }

        
        @media (max-width: 1024px) {
            .report-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .report-actions {
                width: 100%;
            }

            .btn-detail {
                flex: 1;
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    
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
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
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
                <a href="{{ route('admin.monitoring') }}" class="nav-link active">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
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

    
    <main class="main-content">
        <div class="page-header">
            <h1>Dashboard Monitoring</h1>
            <p>Monitor kondisi kekeringan di seluruh wilayah Gunungkidul</p>
        </div>

        <div class="monitoring-section">
            <div class="section-header">
                <div class="section-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                        <line x1="12" y1="9" x2="12" y2="13" />
                        <line x1="12" y1="17" x2="12.01" y2="17" />
                    </svg>
                </div>
                <h2>Laporan Prioritas Tinggi</h2>
                @if($laporanPrioritas->count() > 0)
                    <span class="count-badge">{{ $laporanPrioritas->count() }} laporan</span>
                @endif
            </div>

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
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                            <circle cx="9" cy="7" r="4"/>
                                        </svg>
                                        {{ number_format($laporan->warga_terdampak) }} warga terdampak
                                    </span>
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"/>
                                            <polyline points="12 6 12 12 16 14"/>
                                        </svg>
                                        {{ $laporan->durasi_kekeringan }} hari
                                    </span>
                                </div>
                            </div>
                            <div class="report-actions">
                                <a href="{{ route('admin.monitoring.kekeringan', $laporan->id) }}" class="btn-detail btn-kekeringan" id="btn-kekeringan-{{ $laporan->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>
                                    </svg>
                                    Detail Tingkat Kekeringan
                                </a>
                                <a href="{{ route('admin.monitoring.kondisi', $laporan->id) }}" class="btn-detail btn-kondisi" id="btn-kondisi-{{ $laporan->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                                    </svg>
                                    Detail Level Kondisi
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                    </div>
                    <h3>Tidak Ada Laporan Prioritas Tinggi</h3>
                    <p>Semua wilayah dalam kondisi aman. Tidak ada laporan kekeringan kritis atau tinggi saat ini.</p>
                </div>
            @endif
        </div>
    </main>

</body>

</html>
