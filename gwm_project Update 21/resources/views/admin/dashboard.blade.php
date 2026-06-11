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
            max-height: 500px;
            overflow-y: auto;
            padding-right: 8px; /* Give some space for scrollbar */
        }
        
        /* Custom Scrollbar for report-list */
        .report-list::-webkit-scrollbar {
            width: 6px;
        }
        .report-list::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }
        .report-list::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .report-list::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
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
            flex-shrink: 0;
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

        /* Filter Tabs */
        .filter-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-tab {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            border: 1px solid var(--border);
            background: white;
            color: #475569;
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
        }

        .filter-tab:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        .filter-tab.active {
            background: #eff6ff;
            color: #2563eb;
            border-color: #bfdbfe;
            font-weight: 600;
        }

        .filter-tab .tab-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 22px;
            height: 22px;
            padding: 0 6px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 700;
            background: #e2e8f0;
            color: #475569;
            line-height: 1;
        }

        .filter-tab.active .tab-count {
            background: #bfdbfe;
            color: #1d4ed8;
        }

        .filter-tab.tab-menunggu.active { background: #fff7ed; color: #ea580c; border-color: #fed7aa; }
        .filter-tab.tab-menunggu.active .tab-count { background: #fed7aa; color: #c2410c; }

        .filter-tab.tab-tervalidasi.active { background: #f0fdf4; color: #16a34a; border-color: #bbf7d0; }
        .filter-tab.tab-tervalidasi.active .tab-count { background: #bbf7d0; color: #15803d; }

        .filter-tab.tab-ditolak.active { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
        .filter-tab.tab-ditolak.active .tab-count { background: #fecaca; color: #b91c1c; }

        /* Filter Controls Container & Search/Dropdown Filters */
        .filter-controls-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .filter-search-group {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            flex: 1;
            justify-content: flex-end;
            min-width: 300px;
        }

        .search-input-wrapper {
            position: relative;
            flex: 1;
            max-width: 320px;
            min-width: 200px;
        }

        .search-input-wrapper input {
            width: 100%;
            padding: 10px 16px 10px 40px;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: white;
            color: var(--text-dark);
            outline: none;
            transition: all 0.2s ease;
            box-sizing: border-box;
        }

        .search-input-wrapper input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .search-input-wrapper .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-gray);
            pointer-events: none;
            width: 16px;
            height: 16px;
        }

        .select-wrapper {
            position: relative;
            min-width: 160px;
        }

        .select-wrapper select {
            width: 100%;
            padding: 10px 32px 10px 16px;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: white;
            color: #475569;
            outline: none;
            cursor: pointer;
            transition: all 0.2s ease;
            appearance: none;
            -webkit-appearance: none;
            box-sizing: border-box;
        }

        .select-wrapper select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .select-wrapper::after {
            content: '';
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            border: 5px solid transparent;
            border-top-color: var(--text-gray);
            pointer-events: none;
        }

        .report-card.hidden-card {
            display: none !important;
        }

        /* Validation status badge on report card */
        .badge-validasi {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-validasi-menunggu {
            background: #fff7ed;
            color: #ea580c;
            border: 1px solid #fed7aa;
        }

        .badge-validasi-tervalidasi {
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        .badge-validasi-ditolak {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .monitoring-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .monitoring-header h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }

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

    @include('admin.sidebar')

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
                                    <span class="keterangan-desa">Kelurahan {{ $item->kelurahan }}</span>
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

        <!-- Laporan Prioritas -->
        <div class="monitoring-section">
            <div class="monitoring-header">
                <h3>Laporan Prioritas</h3>
            </div>

            <!-- Filter Controls Container -->
            <div class="filter-controls-container">
                <!-- Filter Tabs -->
                <div class="filter-tabs" style="margin-bottom: 0;">
                    <button class="filter-tab active" data-filter="semua" onclick="setFilterStatus('semua', this)">
                        Semua
                        <span class="tab-count">{{ $laporanPrioritas->count() }}</span>
                    </button>
                    <button class="filter-tab tab-menunggu" data-filter="menunggu" onclick="setFilterStatus('menunggu', this)">
                        Belum Tervalidasi
                        <span class="tab-count">{{ $laporanPrioritas->where('validasi_status', 'menunggu')->count() }}</span>
                    </button>
                    <button class="filter-tab tab-tervalidasi" data-filter="tervalidasi" onclick="setFilterStatus('tervalidasi', this)">
                        Tervalidasi
                        <span class="tab-count">{{ $laporanPrioritas->where('validasi_status', 'tervalidasi')->count() }}</span>
                    </button>
                    <button class="filter-tab tab-ditolak" data-filter="ditolak" onclick="setFilterStatus('ditolak', this)">
                        Ditolak
                        <span class="tab-count">{{ $laporanPrioritas->where('validasi_status', 'ditolak')->count() }}</span>
                    </button>
                </div>

                <!-- Search and dropdowns -->
                <div class="filter-search-group">
                    <div class="search-input-wrapper">
                        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" id="laporanSearch" placeholder="Cari Kelurahan / Kecamatan..." oninput="applyFilters()">
                    </div>
                    
                    <div class="select-wrapper">
                        <select id="filterKelurahan" onchange="applyFilters()">
                            <option value="">Semua Kelurahan</option>
                        </select>
                    </div>

                    <div class="select-wrapper">
                        <select id="filterKecamatan" onchange="applyFilters()">
                            <option value="">Semua Kecamatan</option>
                        </select>
                    </div>
                </div>
            </div>

            @if($laporanPrioritas->count() > 0)
                <div class="report-list" id="reportList">
                    @foreach($laporanPrioritas as $laporan)
                        <div class="report-card {{ strtolower($laporan->tingkat_kekeringan) }}" 
                             data-validasi="{{ $laporan->validasi_status }}"
                             data-kelurahan="{{ strtolower($laporan->kelurahan) }}"
                             data-kecamatan="{{ strtolower(str_replace('Petugas ', '', $laporan->kecamatan)) }}">
                            <div class="report-info">
                                <div class="report-meta">
                                    <span class="report-code">{{ $laporan->kode }}</span>
                                    <span class="badge badge-{{ strtolower($laporan->tingkat_kekeringan) }}">
                                        {{ $laporan->tingkat_kekeringan }}
                                    </span>
                                    @if($laporan->validasi_status === 'menunggu')
                                        <span class="badge-validasi badge-validasi-menunggu">⏳ Menunggu</span>
                                    @elseif($laporan->validasi_status === 'tervalidasi')
                                        <span class="badge-validasi badge-validasi-tervalidasi">✓ Tervalidasi</span>
                                    @elseif($laporan->validasi_status === 'ditolak')
                                        <span class="badge-validasi badge-validasi-ditolak">✕ Ditolak</span>
                                    @endif
                                </div>
                                <div class="report-location">
                                    Kelurahan {{ $laporan->kelurahan }}, Kecamatan {{ str_replace('Petugas ', '', $laporan->kecamatan) }}
                                </div>
                                <div class="report-stats">
                                    {{ number_format($laporan->warga_terdampak) }} warga terdampak · {{ $laporan->durasi_kekeringan }} hari
                                </div>
                            </div>
                            <div class="report-actions">
                                <a href="{{ route('admin.klasifikasi_kekeringan', $laporan->id) }}" class="btn-detail" id="btn-kekeringan-{{ $laporan->id }}">
                                    <span>Detail</span>
                                    Tingkat Kekeringan
                                </a>
                                <a href="{{ route('admin.level_kondisi', $laporan->id) }}" class="btn-detail" id="btn-kondisi-{{ $laporan->id }}">
                                    <span>Detail</span>
                                    Level Kondisi
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Empty state for filtered results -->
                <div class="empty-monitoring" id="emptyFilterState" style="display: none;">
                    <p>Tidak ada laporan dengan status ini.</p>
                </div>
            @else
                <div class="empty-monitoring">
                    <p>Tidak ada laporan prioritas saat ini.</p>
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
                labels: ['Sedang', 'Tinggi', 'Kritis'],
                datasets: [{
                    data: [
                        {{ ($sedang ?? 0) == 0 && ($tinggi ?? 0) == 0 && ($kritis ?? 0) == 0 ? 1 : ($sedang ?? 0) }},
                        {{ ($sedang ?? 0) == 0 && ($tinggi ?? 0) == 0 && ($kritis ?? 0) == 0 ? 1 : ($tinggi ?? 0) }},
                        {{ ($sedang ?? 0) == 0 && ($tinggi ?? 0) == 0 && ($kritis ?? 0) == 0 ? 1 : ($kritis ?? 0) }}
                    ],
                    backgroundColor: ['#eab308', '#f97316', '#ef4444'],
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

    <script>
        // Global variables for filter state
        let activeStatusFilter = 'semua';

        document.addEventListener('DOMContentLoaded', function() {
            populateLocationFilters();
        });

        function populateLocationFilters() {
            const cards = document.querySelectorAll('.report-card');
            const kelurahans = new Set();
            const kecamatans = new Set();

            cards.forEach(card => {
                const kel = card.getAttribute('data-kelurahan');
                const kec = card.getAttribute('data-kecamatan');
                if (kel) kelurahans.add(kel);
                if (kec) kecamatans.add(kec);
            });

            const kelurahanSelect = document.getElementById('filterKelurahan');
            const kecamatanSelect = document.getElementById('filterKecamatan');

            // Helper to format proper case
            function toTitleCase(str) {
                return str.replace(/\w\S*/g, function(txt) {
                    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                });
            }

            // Populate Kelurahan Select
            Array.from(kelurahans).sort().forEach(kel => {
                const opt = document.createElement('option');
                opt.value = kel;
                opt.textContent = 'Kelurahan ' + toTitleCase(kel);
                kelurahanSelect.appendChild(opt);
            });

            // Populate Kecamatan Select
            Array.from(kecamatans).sort().forEach(kec => {
                const opt = document.createElement('option');
                opt.value = kec;
                opt.textContent = 'Kecamatan ' + toTitleCase(kec);
                kecamatanSelect.appendChild(opt);
            });
        }

        function setFilterStatus(status, clickedTab) {
            // Update active tab style
            document.querySelectorAll('.filter-tab').forEach(tab => tab.classList.remove('active'));
            clickedTab.classList.add('active');

            activeStatusFilter = status;
            applyFilters();
        }

        function applyFilters() {
            const searchQuery = document.getElementById('laporanSearch').value.toLowerCase().trim();
            const selectedKelurahan = document.getElementById('filterKelurahan').value;
            const selectedKecamatan = document.getElementById('filterKecamatan').value;

            const cards = document.querySelectorAll('.report-card');
            const emptyState = document.getElementById('emptyFilterState');
            let visibleCount = 0;

            cards.forEach(card => {
                const validasi = card.getAttribute('data-validasi');
                const kelurahan = card.getAttribute('data-kelurahan');
                const kecamatan = card.getAttribute('data-kecamatan');

                // Check tab filter
                const matchesStatus = (activeStatusFilter === 'semua') || (validasi === activeStatusFilter);
                
                // Check search filter (searches in kelurahan & kecamatan)
                const matchesSearch = !searchQuery || 
                                     kelurahan.includes(searchQuery) || 
                                     kecamatan.includes(searchQuery);

                // Check select filters
                const matchesKelurahan = !selectedKelurahan || (kelurahan === selectedKelurahan);
                const matchesKecamatan = !selectedKecamatan || (kecamatan === selectedKecamatan);

                const shouldShow = matchesStatus && matchesSearch && matchesKelurahan && matchesKecamatan;

                if (shouldShow) {
                    card.classList.remove('hidden-card');
                    card.style.animation = 'none';
                    card.offsetHeight; // trigger reflow
                    card.style.animation = `slideUp 0.3s ease forwards`;
                    card.style.animationDelay = `${visibleCount * 0.05}s`;
                    visibleCount++;
                } else {
                    card.classList.add('hidden-card');
                }
            });

            if (emptyState) {
                emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        }
    </script>

</body>

</html>