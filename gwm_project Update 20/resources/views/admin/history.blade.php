@php
    if (!function_exists('formatTanggalIndo')) {
        function formatTanggalIndo($date) {
            if (!$date) return '-';
            $carbon = \Carbon\Carbon::parse($date);
            
            $bulan = [
                1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
            
            $tgl = $carbon->format('j');
            $bln = $bulan[$carbon->format('n')];
            $thn = $carbon->format('Y');
            $jam = $carbon->format('H.i');
            
            return "{$tgl} {$bln} {$thn} pukul {$jam}";
        }
    }
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWM - Log Aktivitas</title>

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
            --card-radius: 16px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: var(--bg-color);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }

        /* ================= MAIN CONTENT ================= */
        .main-content {
            flex: 1;
            padding: 40px;
            margin-left: 260px; /* Adjust based on sidebar */
            min-width: 0; /* Prevents flex items from overflowing */
        }

        .page-header {
            margin-bottom: 24px;
        }

        .page-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .page-header p {
            margin: 6px 0 0 0;
            color: var(--text-gray);
            font-size: 14px;
        }

        /* ================= FILTERS ================= */
        .filter-card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: var(--card-radius);
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
        }

        .filter-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
            gap: 16px;
            align-items: end;
        }

        @media (max-width: 1200px) {
            .filter-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        @media (max-width: 640px) {
            .filter-grid {
                grid-template-columns: 1fr;
            }
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .filter-label {
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .filter-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .filter-icon-left {
            position: absolute;
            left: 12px;
            color: #94a3b8;
            pointer-events: none;
            display: flex;
            align-items: center;
        }

        .filter-input {
            width: 100%;
            padding: 10px 12px 10px 38px;
            font-size: 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background-color: #ffffff;
            color: #0f172a;
            transition: all 0.2s ease;
            outline: none;
            font-family: inherit;
            box-sizing: border-box;
        }

        .filter-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .filter-select {
            width: 100%;
            padding: 10px 12px 10px 38px;
            font-size: 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background-color: #ffffff;
            color: #0f172a;
            outline: none;
            cursor: pointer;
            font-family: inherit;
            box-sizing: border-box;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3E%3C/svg%3E");
            background-position: right 10px center;
            background-repeat: no-repeat;
            background-size: 18px;
            transition: all 0.2s ease;
        }

        .filter-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-filter {
            padding: 10px 18px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .btn-filter.primary {
            background-color: #2563eb;
            color: white;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
        }

        .btn-filter.primary:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
        }

        .btn-filter.secondary {
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
            text-decoration: none;
        }

        .btn-filter.secondary:hover {
            background-color: #e2e8f0;
            color: #0f172a;
        }

        /* ================= TIMELINE CONTAINER ================= */
        .timeline-container {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: var(--card-radius);
            padding: 30px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
        }

        .timeline-header {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .timeline-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
            position: relative;
        }

        /* Line that runs vertically in the background */
        .timeline-list::before {
            content: '';
            position: absolute;
            top: 24px;
            bottom: 24px;
            left: 36px;
            width: 2px;
            background: #e2e8f0;
            z-index: 0;
        }

        /* ================= TIMELINE CARD ================= */
        .timeline-card {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid transparent;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 1;
            background-color: #ffffff;
        }

        .timeline-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
        }

        /* Card color themes */
        .timeline-card.purple {
            background-color: #faf5ff;
            border-color: #f3e8ff;
        }
        .timeline-card.purple:hover {
            border-color: #e9d5ff;
        }

        .timeline-card.green {
            background-color: #f0fdf4;
            border-color: #dcfce7;
        }
        .timeline-card.green:hover {
            border-color: #bbf7d0;
        }

        .timeline-card.red {
            background-color: #fef2f2;
            border-color: #fee2e2;
        }
        .timeline-card.red:hover {
            border-color: #fecaca;
        }

        .timeline-card.blue {
            background-color: #eff6ff;
            border-color: #dbeafe;
        }
        .timeline-card.blue:hover {
            border-color: #bfdbfe;
        }

        .timeline-card.yellow {
            background-color: #fefce8;
            border-color: #fef9c3;
        }
        .timeline-card.yellow:hover {
            border-color: #fef08a;
        }

        /* Icon containers */
        .timeline-icon-box {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            flex-shrink: 0;
            transition: transform 0.2s ease;
            z-index: 2;
        }

        .timeline-card:hover .timeline-icon-box {
            transform: scale(1.05);
        }

        .timeline-card.purple .timeline-icon-box {
            background-color: #ffffff;
            color: #a855f7;
            border: 1px solid #e9d5ff;
        }

        .timeline-card.green .timeline-icon-box {
            background-color: #ffffff;
            color: #22c55e;
            border: 1px solid #bbf7d0;
        }

        .timeline-card.red .timeline-icon-box {
            background-color: #ffffff;
            color: #ef4444;
            border: 1px solid #fecaca;
        }

        .timeline-card.blue .timeline-icon-box {
            background-color: #ffffff;
            color: #3b82f6;
            border: 1px solid #bfdbfe;
        }

        .timeline-card.yellow .timeline-icon-box {
            background-color: #ffffff;
            color: #eab308;
            border: 1px solid #fef08a;
        }

        /* Timeline body elements */
        .timeline-body {
            flex: 1;
            min-width: 0; /* Prevents overflow */
        }

        .timeline-title-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 6px;
            flex-wrap: wrap;
        }

        .timeline-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .timeline-code-badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .timeline-desc {
            font-size: 14px;
            color: #334155;
            margin: 0 0 10px 0;
            line-height: 1.6;
        }

        .timeline-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #64748b;
            flex-wrap: wrap;
        }

        .timeline-meta-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .timeline-divider {
            color: #cbd5e1;
        }

        /* Action button style */
        .timeline-action {
            align-self: center;
        }

        .btn-detail-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            color: #64748b;
            background-color: #ffffff;
            transition: all 0.2s ease;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .timeline-card.purple .btn-detail-link:hover {
            background-color: #a855f7;
            color: #ffffff;
            border-color: #a855f7;
            transform: scale(1.05);
        }

        .timeline-card.green .btn-detail-link:hover {
            background-color: #22c55e;
            color: #ffffff;
            border-color: #22c55e;
            transform: scale(1.05);
        }

        .timeline-card.red .btn-detail-link:hover {
            background-color: #ef4444;
            color: #ffffff;
            border-color: #ef4444;
            transform: scale(1.05);
        }

        .timeline-card.blue .btn-detail-link:hover {
            background-color: #3b82f6;
            color: #ffffff;
            border-color: #3b82f6;
            transform: scale(1.05);
        }

        .timeline-card.yellow .btn-detail-link:hover {
            background-color: #eab308;
            color: #ffffff;
            border-color: #eab308;
            transform: scale(1.05);
        }

        /* ================= PAGINATION STYLING ================= */
        .pagination-wrapper {
            margin-top: 30px;
        }

        .pagination-wrapper nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pagination-wrapper nav svg {
            width: 20px;
            height: 20px;
        }

        .pagination-wrapper nav .hidden {
            display: flex !important;
            align-items: center;
            gap: 6px;
        }

        .pagination-wrapper nav .hidden > div {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .pagination-wrapper nav a, 
        .pagination-wrapper nav span {
            padding: 8px 14px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: white;
            color: var(--text-dark);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            transition: all 0.2s ease;
        }

        .pagination-wrapper nav a:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }

        .pagination-wrapper nav span[aria-current="page"] {
            background: #eff6ff;
            color: #2563eb;
            border-color: #bfdbfe;
            font-weight: 600;
        }

        .empty-data {
            text-align: center;
            padding: 60px 40px;
            color: #94a3b8;
            background: white;
            border-radius: 12px;
            border: 1px dashed var(--border);
            font-size: 15px;
        }

        .empty-icon {
            margin-bottom: 12px;
            color: #cbd5e1;
        }
    </style>
</head>

<body>

    @include('admin.sidebar')

    <main class="main-content">

        <div class="page-header">
            <h1>Log Aktivitas</h1>
            <p>Riwayat semua aktivitas sistem</p>
        </div>

        <!-- Filter Form -->
        <div class="filter-card">
            <form method="GET" action="{{ route('admin.history') }}">
                <div class="filter-grid">
                    
                    <!-- Search -->
                    <div class="filter-group">
                        <label class="filter-label">Pencarian</label>
                        <div class="filter-input-wrapper">
                            <span class="filter-icon-left">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            </span>
                            <input type="text" name="search" class="filter-input" placeholder="Cari aktivitas, user, atau ID..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <!-- Jenis Aksi -->
                    <div class="filter-group">
                        <label class="filter-label">Jenis Aksi</label>
                        <div class="filter-input-wrapper">
                            <span class="filter-icon-left">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                            </span>
                            <select name="type" class="filter-select">
                                <option value="">Semua Aksi</option>
                                <option value="Laporan Baru" {{ request('type') == 'Laporan Baru' ? 'selected' : '' }}>Laporan Baru</option>
                                <option value="Validasi Laporan" {{ request('type') == 'Validasi Laporan' ? 'selected' : '' }}>Validasi Laporan</option>
                                <option value="Tindak Lanjut" {{ request('type') == 'Tindak Lanjut' ? 'selected' : '' }}>Tindak Lanjut</option>
                                <option value="Status Update" {{ request('type') == 'Status Update' ? 'selected' : '' }}>Status Update</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="filter-group">
                        <label class="filter-label">Mulai Tanggal</label>
                        <div class="filter-input-wrapper">
                            <span class="filter-icon-left" style="left: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            </span>
                            <input type="date" name="start_date" class="filter-input" style="padding-left: 36px;" value="{{ request('start_date') }}">
                        </div>
                    </div>

                    <!-- Tanggal Selesai -->
                    <div class="filter-group">
                        <label class="filter-label">Sampai Tanggal</label>
                        <div class="filter-input-wrapper">
                            <span class="filter-icon-left" style="left: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            </span>
                            <input type="date" name="end_date" class="filter-input" style="padding-left: 36px;" value="{{ request('end_date') }}">
                        </div>
                    </div>

                    <!-- Urutan -->
                    <div class="filter-group">
                        <label class="filter-label">Urutan</label>
                        <div class="filter-input-wrapper">
                            <span class="filter-icon-left">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21 16-4 4-4-4"/><path d="M17 20V4"/><path d="m3 8 4-4 4 4"/><path d="M7 4v16"/></svg>
                            </span>
                            <select name="sort" class="filter-select">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="filter-buttons" style="margin-top: 16px; justify-content: flex-end;">
                    <button type="submit" class="btn-filter primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        Terapkan Filter
                    </button>
                    <a href="{{ route('admin.history') }}" class="btn-filter secondary">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Timeline Section -->
        <div class="timeline-container">
            <div class="timeline-header">
                <span>Timeline Aktivitas ({{ $activities->total() }})</span>
            </div>

            @if($activities->count())
                <div class="timeline-list">
                    @foreach($activities as $activity)
                        <div class="timeline-card {{ $activity['color'] }}">
                            <!-- Icon Box -->
                            <div class="timeline-icon-box">
                                @if($activity['icon'] === 'pencil')
                                    <!-- pencil / notebook icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                                    </svg>
                                @elseif($activity['icon'] === 'check')
                                    <!-- checkmark icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                @elseif($activity['icon'] === 'cross')
                                    <!-- cross / reject icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                @elseif($activity['icon'] === 'wrench')
                                    <!-- wrench icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                                    </svg>
                                @elseif($activity['icon'] === 'sync')
                                    <!-- sync icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                                        <path d="M3 3v5h5"></path>
                                        <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"></path>
                                        <path d="M16 16h5v5"></path>
                                    </svg>
                                @endif
                            </div>

                            <!-- Card Body -->
                            <div class="timeline-body">
                                <div class="timeline-title-row">
                                    <span class="timeline-title">{{ $activity['type'] }}</span>
                                    <span class="timeline-code-badge">{{ $activity['code'] }}</span>
                                </div>
                                <p class="timeline-desc">{{ $activity['description'] }}</p>
                                <div class="timeline-meta">
                                    <div class="timeline-meta-item">
                                        <!-- User icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        <span>{{ $activity['user_name'] }}</span>
                                    </div>
                                    <span class="timeline-divider">•</span>
                                    <div class="timeline-meta-item">
                                        <!-- Clock/Calendar Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                        <span>{{ formatTanggalIndo($activity['created_at']) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Detail Action Link -->
                            <div class="timeline-action">
                                <a href="{{ route('admin.history.detail', $activity['laporan_id']) }}" class="btn-detail-link" title="Lihat Detail Laporan">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    {{ $activities->links() }}
                </div>
            @else
                <div class="empty-data">
                    <svg class="empty-icon" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <div>Tidak ada data riwayat aktivitas yang sesuai dengan filter saat ini.</div>
                </div>
            @endif
        </div>

    </main>

</body>

</html>