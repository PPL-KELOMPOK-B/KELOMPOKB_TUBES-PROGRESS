<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWM - Monitoring & Update Kondisi</title>
    <meta name="description" content="Halaman Monitoring & Update Kondisi Kekeringan Gunungkidul Water Monitor">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            
            /* Status Colors */
            --kritis-color: #ef4444;
            --kritis-bg: #fef2f2;
            --tinggi-color: #f97316;
            --tinggi-bg: #fff7ed;
            --sedang-color: #eab308;
            --sedang-bg: #fefce8;
            --rendah-color: #10b981;
            --rendah-bg: #f0fdf4;
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
            overflow-x: hidden;
        }

        /* Sidebar Styles */
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

        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 40px;
            overflow-y: auto;
            min-height: 100vh;
        }

        .page-header {
            margin-bottom: 32px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: -0.5px;
        }

        .page-header p {
            color: var(--text-gray);
            font-size: 15px;
        }

        /* Filter Section */
        .filter-section {
            background: white;
            border-radius: var(--card-radius);
            border: 1px solid var(--border);
            padding: 20px 24px;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            animation: fadeIn 0.5s ease;
        }

        .filter-label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-select {
            padding: 10px 16px;
            font-size: 14px;
            font-weight: 500;
            font-family: inherit;
            color: var(--text-dark);
            background-color: #f8fafc;
            border: 1px solid var(--border);
            border-radius: 8px;
            outline: none;
            cursor: pointer;
            transition: var(--transition);
            min-width: 220px;
        }

        .filter-select:hover, .filter-select:focus {
            border-color: var(--primary);
            background-color: white;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* Metrics Cards Grid */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }

        .metric-card {
            background: white;
            border-radius: var(--card-radius);
            border: 1px solid var(--border);
            padding: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            animation: slideUp 0.4s ease forwards;
        }

        .metric-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.04);
            border-color: #cbd5e1;
        }

        .metric-info {
            display: flex;
            flex-direction: column;
            gap: 6px;
            z-index: 2;
        }

        .metric-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .metric-value {
            font-size: 26px;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.1;
        }

        .metric-subtext {
            font-size: 12px;
            color: var(--text-gray);
            font-weight: 500;
        }

        .metric-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            z-index: 2;
        }

        .icon-blue { background: #eff6ff; color: #2563eb; }
        .icon-orange { background: #fff7ed; color: #f97316; }
        .icon-red { background: #fef2f2; color: #ef4444; }
        .icon-green { background: #f0fdf4; color: #10b981; }

        /* Charts Section Layout */
        .charts-container {
            display: grid;
            grid-template-columns: 1.8fr 1.2fr;
            gap: 24px;
            margin-bottom: 32px;
        }

        .chart-card {
            background: white;
            border-radius: var(--card-radius);
            border: 1px solid var(--border);
            padding: 28px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            display: flex;
            flex-direction: column;
            position: relative;
            animation: fadeIn 0.6s ease;
        }

        .chart-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .chart-card-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .chart-card-title svg {
            width: 20px;
            height: 20px;
            stroke-width: 2.2;
            color: var(--primary);
        }

        .chart-wrapper {
            position: relative;
            width: 100%;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Line Chart Specific Legend overlay */
        .line-legend {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 16px;
            margin-top: 16px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-gray);
        }

        .legend-marker {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 2px;
            margin-right: 4px;
        }

        /* Doughnut Chart Content Overlay */
        .doughnut-center-info {
            position: absolute;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .doughnut-center-number {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1;
        }

        .doughnut-center-label {
            font-size: 11px;
            color: var(--text-gray);
            font-weight: 600;
            text-transform: uppercase;
            margin-top: 4px;
        }

        /* Full Width Chart Section */
        .full-width-chart {
            background: white;
            border-radius: var(--card-radius);
            border: 1px solid var(--border);
            padding: 28px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            margin-bottom: 32px;
            animation: fadeIn 0.6s ease;
        }

        .bar-chart-wrapper {
            position: relative;
            width: 100%;
            height: 280px;
        }

        /* Table Section */
        .table-section {
            background: white;
            border-radius: var(--card-radius);
            border: 1px solid var(--border);
            padding: 28px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            animation: fadeIn 0.7s ease;
        }

        .table-header-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .table-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-title svg {
            width: 20px;
            height: 20px;
            stroke-width: 2;
            color: var(--primary);
        }

        .search-box {
            position: relative;
            min-width: 280px;
        }

        .search-input {
            width: 100%;
            padding: 10px 16px 10px 40px;
            font-size: 13px;
            font-family: inherit;
            border: 1px solid var(--border);
            border-radius: 8px;
            background-color: #f8fafc;
            outline: none;
            transition: var(--transition);
        }

        .search-input:focus {
            border-color: var(--primary);
            background-color: white;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            color: var(--text-gray);
            pointer-events: none;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid var(--border);
        }

        .monitoring-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
        }

        .monitoring-table th {
            background-color: #f8fafc;
            padding: 16px 20px;
            font-weight: 600;
            color: var(--text-gray);
            border-bottom: 1px solid var(--border);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .monitoring-table td {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            color: #334155;
            vertical-align: middle;
        }

        .monitoring-table tr:last-child td {
            border-bottom: none;
        }

        .monitoring-table tr:hover td {
            background-color: #f8fafc;
        }

        .code-cell {
            font-weight: 600;
            color: var(--text-gray);
            font-size: 13px;
        }

        .location-cell {
            font-weight: 600;
            color: var(--text-dark);
        }

        .location-sub {
            font-size: 11px;
            color: var(--text-gray);
            margin-top: 2px;
        }

        /* Custom Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-kritis {
            background-color: var(--kritis-bg);
            color: var(--kritis-color);
            border: 1px solid #fecaca;
        }

        .badge-tinggi {
            background-color: var(--tinggi-bg);
            color: var(--tinggi-color);
            border: 1px solid #fed7aa;
        }

        .badge-sedang {
            background-color: var(--sedang-bg);
            color: var(--sedang-color);
            border: 1px solid #fde68a;
        }

        .badge-rendah {
            background-color: var(--rendah-bg);
            color: var(--rendah-color);
            border: 1px solid #bbf7d0;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-table-action {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            border: 1px solid var(--border);
            background: white;
            color: #475569;
            cursor: pointer;
        }

        .btn-table-action:hover {
            background-color: #f1f5f9;
            border-color: #cbd5e1;
            transform: translateY(-1px);
        }

        .btn-action-blue {
            color: #2563eb;
            background-color: #eff6ff;
            border-color: #bfdbfe;
        }

        .btn-action-blue:hover {
            background-color: #dbeafe;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.15);
        }

        .btn-action-orange {
            color: #ea580c;
            background-color: #fff7ed;
            border-color: #fed7aa;
        }

        .btn-action-orange:hover {
            background-color: #ffedd5;
            box-shadow: 0 2px 6px rgba(249, 115, 22, 0.15);
        }

        .btn-table-action svg {
            width: 14px;
            height: 14px;
            stroke-width: 2.2;
        }

        /* Empty State inside table */
        .empty-table-state {
            text-align: center;
            padding: 40px;
            color: var(--text-gray);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .metric-card:nth-child(1) { animation-delay: 0.05s; }
        .metric-card:nth-child(2) { animation-delay: 0.1s; }
        .metric-card:nth-child(3) { animation-delay: 0.15s; }
        .metric-card:nth-child(4) { animation-delay: 0.2s; }
        .metric-card:nth-child(5) { animation-delay: 0.25s; }

        /* Responsive styling */
        @media (max-width: 1200px) {
            .metrics-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .charts-container {
                grid-template-columns: 1fr;
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
            .metrics-grid {
                grid-template-columns: 1fr;
            }
            .filter-section {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            .filter-select {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    @include('admin.sidebar')


    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header">
            <h1>Monitoring & Update Kondisi</h1>
            <p>Pantau perubahan kondisi kekeringan dari waktu ke waktu secara real-time</p>
        </div>

        <!-- Filter Lokasi Dropdown -->
        <div class="filter-section">
            <div class="filter-label">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>
                Filter Lokasi Pemantauan:
            </div>
            <form action="{{ route('admin.monitoring') }}" method="GET" id="filterForm">
                <select name="lokasi" class="filter-select" onchange="document.getElementById('filterForm').submit();">
                    <option value="Semua Lokasi" {{ $filterLokasi == 'Semua Lokasi' || empty($filterLokasi) ? 'selected' : '' }}>Semua Wilayah</option>
                    <optgroup label="Kecamatan">
                        @foreach($kecamatans as $kec)
                            <option value="{{ $kec }}" {{ $filterLokasi == $kec ? 'selected' : '' }}>Kecamatan {{ $kec }}</option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Kelurahan">
                        @foreach($kelurahans as $kel)
                            <option value="{{ $kel }}" {{ $filterLokasi == $kel ? 'selected' : '' }}>Kelurahan {{ $kel }}</option>
                        @endforeach
                    </optgroup>
                </select>
            </form>
        </div>

        <!-- 5 Metric Cards -->
        <div class="metrics-grid">
            <div class="metric-card">
                <div class="metric-info">
                    <span class="metric-title">Total Laporan</span>
                    <span class="metric-value">{{ number_format($totalLaporan) }}</span>
                    <span class="metric-subtext">Laporan dari semua kecamatan</span>
                </div>
                <div class="metric-icon icon-blue">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-info">
                    <span class="metric-title">Total Warga Terdampak</span>
                    <span class="metric-value">{{ number_format($totalWargaTerdampak) }}</span>
                    <span class="metric-subtext">Jiwa membutuhkan air bersih</span>
                </div>
                <div class="metric-icon icon-blue">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-info">
                    <span class="metric-title">Kelurahan Terdampak</span>
                    <span class="metric-value">{{ $totalWilayahTerdampak }}</span>
                    <span class="metric-subtext">Kelurahan aktif terdata</span>
                </div>
                <div class="metric-icon icon-orange">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-info">
                    <span class="metric-title">Rata-rata Durasi</span>
                    <span class="metric-value">{{ $rataRataDurasi }} Hari</span>
                    <span class="metric-subtext">Rata-rata masa kekeringan</span>
                </div>
                <div class="metric-icon icon-green">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-info">
                    <span class="metric-title">Titik Wilayah Terparah</span>
                    <span class="metric-value" style="font-size: 18px; margin-top: 6px;">{{ $wilayahTerparah }}</span>
                    <span class="metric-subtext">Warga terdampak terbanyak</span>
                </div>
                <div class="metric-icon icon-red">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </div>
            </div>
        </div>

        <!-- Line & Doughnut Charts Section -->
        <div class="charts-container">
            <!-- Line Chart: Tren Tingkat Kekeringan -->
            <div class="chart-card">
                <div class="chart-card-header">
                    <h3 class="chart-card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" /></svg>
                        @php
                            $chartTitle = "Seluruh Kecamatan";
                            if ($filterLokasi && $filterLokasi !== 'Semua Lokasi') {
                                if ($kecamatans->contains($filterLokasi)) {
                                    $chartTitle = "Kecamatan " . $filterLokasi;
                                } else {
                                    $chartTitle = "Kelurahan " . $filterLokasi;
                                }
                            }
                        @endphp
                        Tren Tingkat Kekeringan Bulanan {{ $chartTitle }}
                    </h3>
                </div>
                <div class="chart-wrapper">
                    <canvas id="monthlyTrendChart"></canvas>
                </div>
                <div class="line-legend">
                    <span><span class="legend-marker" style="background-color: #ef4444;"></span>Kritis</span>
                    <span><span class="legend-marker" style="background-color: #f97316;"></span>Tinggi</span>
                    <span><span class="legend-marker" style="background-color: #eab308;"></span>Sedang</span>
                </div>
                <!-- Keterangan Klasifikasi Tren - Visual Cards -->
                <div style="margin-top: 20px; padding: 0 4px;">
                    <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 12px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        <span style="font-size: 12px; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.5px;">Keterangan Klasifikasi Tren</span>
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
                        <!-- Kritis -->
                        <div style="background: linear-gradient(135deg, #fef2f2, #fff5f5); border: 1px solid #fecaca; border-left: 4px solid #ef4444; border-radius: 10px; padding: 14px 16px; transition: all 0.2s ease; cursor: default;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(239,68,68,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                <div style="width: 28px; height: 28px; background: #fee2e2; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                </div>
                                <span style="font-size: 13px; font-weight: 700; color: #dc2626;">Kritis</span>
                            </div>
                            <p style="font-size: 11.5px; color: #991b1b; line-height: 1.5; margin: 0;">Jumlah laporan kekeringan dengan level prioritas <b>Kritis</b> yang masuk dan divalidasi pada bulan tersebut.</p>
                        </div>
                        <!-- Tinggi -->
                        <div style="background: linear-gradient(135deg, #fff7ed, #fffbf5); border: 1px solid #fed7aa; border-left: 4px solid #f97316; border-radius: 10px; padding: 14px 16px; transition: all 0.2s ease; cursor: default;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(249,115,22,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                <div style="width: 28px; height: 28px; background: #ffedd5; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg>
                                </div>
                                <span style="font-size: 13px; font-weight: 700; color: #ea580c;">Tinggi</span>
                            </div>
                            <p style="font-size: 11.5px; color: #9a3412; line-height: 1.5; margin: 0;">Jumlah laporan kekeringan dengan level prioritas <b>Tinggi</b> yang memerlukan penanganan segera.</p>
                        </div>
                        <!-- Sedang -->
                        <div style="background: linear-gradient(135deg, #fefce8, #fffff5); border: 1px solid #fde68a; border-left: 4px solid #eab308; border-radius: 10px; padding: 14px 16px; transition: all 0.2s ease; cursor: default;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(234,179,8,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                <div style="width: 28px; height: 28px; background: #fef9c3; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#eab308" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                </div>
                                <span style="font-size: 13px; font-weight: 700; color: #ca8a04;">Sedang</span>
                            </div>
                            <p style="font-size: 11.5px; color: #854d0e; line-height: 1.5; margin: 0;">Jumlah laporan kekeringan dengan level prioritas <b>Sedang</b> yang sedang dipantau.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Doughnut Chart: Distribusi Keparahan -->
            <div class="chart-card">
                <div class="chart-card-header">
                    <h3 class="chart-card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" /><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" /></svg>
                        Distribusi Level Kondisi
                    </h3>
                </div>
                <div class="chart-wrapper">
                    <canvas id="severityDoughnutChart"></canvas>
                    <div class="doughnut-center-info" style="display: flex; flex-direction: column; align-items: center; justify-content: center; transform: translateY(-5%);">
                        <span style="font-size: 10px; margin-bottom: 4px; color: #64748b; font-weight: 700; letter-spacing: 0.5px;">TOTAL LAPORAN</span>
                        <span class="doughnut-center-number" style="font-size: 38px; font-weight: 800; color: #0f172a; line-height: 1;">{{ $wilayahKritisCount + $wilayahTinggiCount + $wilayahSedangCount }}</span>
                        <span style="font-size: 10px; margin-top: 6px; color: #475569; padding: 3px 10px; background: #f1f5f9; border-radius: 12px; font-weight: 600;">Tervalidasi</span>
                    </div>
                </div>
                <div class="line-legend">
                    <span><span class="legend-marker" style="background-color: #ef4444; border-radius: 50%;"></span>Kritis ({{ $wilayahKritisCount }})</span>
                    <span><span class="legend-marker" style="background-color: #f97316; border-radius: 50%;"></span>Tinggi ({{ $wilayahTinggiCount }})</span>
                    <span><span class="legend-marker" style="background-color: #eab308; border-radius: 50%;"></span>Sedang ({{ $wilayahSedangCount }})</span>
                </div>
            </div>
        </div>

        <!-- Full Width: Bar Chart - Sebaran Warga per Kelurahan -->
        <div class="full-width-chart">
            <div class="chart-card-header">
                <h3 class="chart-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" /></svg>
                    Dampak Kekeringan: Sebaran Jiwa Terdampak {{ $chartTitle }}
                </h3>
            </div>
            <div class="bar-chart-wrapper">
                <canvas id="impactBarChart"></canvas>
            </div>
        </div>

        <!-- Table Section: Detail Kondisi Laporan -->
        <div class="table-section">
            <div class="table-header-wrapper">
                <h3 class="table-title">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                    Daftar Kondisi Kekeringan Wilayah Terdata
                </h3>
                <div class="search-box">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    <input type="text" id="tableSearch" class="search-input" placeholder="Cari Kelurahan, Kecamatan, atau Status...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="monitoring-table" id="monitoringTable">
                    <thead>
                        <tr>
                            <th style="width: 100px;">KODE</th>
                            <th>WILAYAH</th>
                            <th>WARGA TERDAMPAK</th>
                            <th>DURASI</th>
                            <th>KONDISI AIR</th>
                            <th>STATUS</th>
                            <th style="width: 280px; text-align: center;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sortedLaporans as $lap)
                            <tr class="table-row-item">
                                <td class="code-cell">{{ $lap->kode }}</td>
                                <td>
                                    <div class="location-cell">Kelurahan {{ $lap->kelurahan }}</div>
                                    <div class="location-sub">Kecamatan {{ str_replace('Petugas ', '', $lap->kecamatan) }}</div>
                                </td>
                                <td style="font-weight: 600;">{{ number_format($lap->warga_terdampak) }} Jiwa</td>
                                <td style="font-weight: 600; color: #475569;">{{ $lap->durasi_kekeringan }} Hari</td>
                                <td>
                                    <span style="font-size: 13.5px; font-weight: 500;">{{ $lap->kondisi_air }}</span>
                                </td>
                                <td>
                                    <span class="status-badge badge-{{ strtolower($lap->tingkat) }}">
                                        {{ $lap->tingkat }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons" style="justify-content: center;">
                                        <a href="{{ route('admin.monitoring.kekeringan', $lap->id) }}" class="btn-table-action btn-action-orange" title="Detail Klasifikasi Kekeringan">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m9-9H3" /></svg>
                                            Kekeringan
                                        </a>
                                        <a href="{{ route('admin.monitoring.kondisi', $lap->id) }}" class="btn-table-action btn-action-blue" title="Detail Tingkat Kondisi">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                                            Level Kondisi
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-table-state">
                                        <p style="font-weight: 600; font-size: 15px; margin-bottom: 4px;">Tidak Ada Laporan Kekeringan Aktif</p>
                                        <p style="font-size: 13px;">Semua wilayah saat ini terdata aman atau filter Anda tidak mengembalikan hasil.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Chart Configuration Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Color Palettes
            const colors = {
                kritis: '#ef4444',
                tinggi: '#f97316',
                sedang: '#eab308',
                rendah: '#10b981',
                primary: '#2563eb',
                primaryLight: 'rgba(37, 99, 235, 0.15)',
                gridColor: '#f1f5f9'
            };

            // 1. Bar Chart: Monthly Composition
            const trendCtx = document.getElementById('monthlyTrendChart').getContext('2d');
            
            new Chart(trendCtx, {
                type: 'bar',
                data: {
                    labels: @json($monthsName),
                    datasets: [
                        {
                            label: 'Kritis',
                            data: @json($kritisData),
                            backgroundColor: colors.kritis,
                            borderRadius: 4
                        },
                        {
                            label: 'Tinggi',
                            data: @json($tinggiData),
                            backgroundColor: colors.tinggi,
                            borderRadius: 4
                        },
                        {
                            label: 'Sedang',
                            data: @json($sedangData),
                            backgroundColor: colors.sedang,
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true,
                            grid: { display: false }
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { family: 'Inter', size: 13, weight: '600' },
                            bodyFont: { family: 'Inter', size: 12 },
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return ` ${context.dataset.label}: ${context.parsed.y} Laporan`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            stacked: true,
                            grid: { display: false },
                            ticks: { font: { family: 'Inter', size: 11, weight: '500' }, color: '#64748b' }
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            grid: { color: colors.gridColor },
                            ticks: {
                                font: { family: 'Inter', size: 11, weight: '500' },
                                color: '#64748b',
                                stepSize: 1,
                                precision: 0
                            }
                        }
                    }
                }
            });

            // 2. Doughnut Chart: Severity Distribution
            const doughnutCtx = document.getElementById('severityDoughnutChart').getContext('2d');
            new Chart(doughnutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Sedang', 'Tinggi', 'Kritis'],
                    datasets: [{
                        data: @json($doughnutData),
                        backgroundColor: [colors.sedang, colors.tinggi, colors.kritis],
                        borderColor: '#ffffff',
                        borderWidth: 2,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { family: 'Inter', size: 13, weight: '600' },
                            bodyFont: { family: 'Inter', size: 12 },
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    const value = context.parsed;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return `${context.label}: ${value} Wilayah (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // 3. Bar Chart: Impacted Citizens per Kelurahan
            const barCtx = document.getElementById('impactBarChart').getContext('2d');
            
            // Create nice bar gradient fill
            const barGradient = barCtx.createLinearGradient(0, 0, 0, 250);
            barGradient.addColorStop(0, '#2563eb');
            barGradient.addColorStop(1, '#60a5fa');

            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: @json($barChartLabels),
                    datasets: [{
                        label: 'Jumlah Warga',
                        data: @json($barChartData),
                        backgroundColor: barGradient,
                        borderRadius: 6,
                        borderSkipped: false,
                        maxBarThickness: 45
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { family: 'Inter', size: 13, weight: '600' },
                            bodyFont: { family: 'Inter', size: 12 },
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return `Terdampak: ${context.parsed.y.toLocaleString('id-ID')} Jiwa`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: 'Inter', size: 12, weight: '600' }, color: '#334155' }
                        },
                        y: {
                            grid: { color: colors.gridColor },
                            ticks: {
                                font: { family: 'Inter', size: 11 },
                                color: '#64748b',
                                callback: function(value) {
                                    return value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });

            // 4. Real-time client-side search for the table
            const tableSearch = document.getElementById('tableSearch');
            const tableRows = document.querySelectorAll('.table-row-item');

            if (tableSearch) {
                tableSearch.addEventListener('input', function(e) {
                    const query = e.target.value.toLowerCase().trim();

                    tableRows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        if (text.includes(query)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>

</body>

</html>
