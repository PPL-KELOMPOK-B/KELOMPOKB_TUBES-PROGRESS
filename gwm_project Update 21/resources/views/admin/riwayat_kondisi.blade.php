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
    <title>GWM - Log Riwayat Kondisi</title>

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
            grid-template-columns: 2fr 1fr auto;
            gap: 16px;
            align-items: end;
        }

        @media (max-width: 768px) {
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
            height: 42px;
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

        /* ================= STATS PILLS ================= */
        .stats-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 24px;
        }

        .stat-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            border: 1px solid transparent;
        }

        .stat-pill .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .pill-blue {
            background-color: #eff6ff;
            color: #2563eb;
            border-color: #bfdbfe;
        }
        .pill-blue .dot { background-color: #3b82f6; }

        .pill-yellow {
            background-color: #fefce8;
            color: #ca8a04;
            border-color: #fef08a;
        }
        .pill-yellow .dot { background-color: #eab308; }

        .pill-orange {
            background-color: #fff7ed;
            color: #ea580c;
            border-color: #fed7aa;
        }
        .pill-orange .dot { background-color: #f97316; }

        .pill-red {
            background-color: #fef2f2;
            color: #dc2626;
            border-color: #fecaca;
        }
        .pill-red .dot { background-color: #ef4444; }

        /* ================= DATA CONTAINER ================= */
        .data-container {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: var(--card-radius);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
            overflow: hidden;
        }

        .data-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .data-header-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .data-count-badge {
            background: #f1f5f9;
            color: #475569;
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 12px;
            font-weight: 600;
        }

        /* ================= TABLE ================= */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background-color: #f8fafc;
            padding: 14px 24px;
            text-align: left;
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .data-table td {
            padding: 16px 24px;
            font-size: 14px;
            color: #334155;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .data-table tbody tr:hover {
            background-color: #f1f5f9;
        }

        .table-laporan-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        
        .table-laporan-id {
            font-weight: 600;
            color: #0f172a;
        }

        .table-laporan-date {
            font-size: 12px;
            color: #64748b;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-sedang {
            background-color: #fefce8;
            color: #ca8a04;
        }

        .status-tinggi {
            background-color: #fff7ed;
            color: #ea580c;
        }

        .status-kritis {
            background-color: #fef2f2;
            color: #dc2626;
        }

        .btn-view {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            background-color: #eff6ff;
            color: #3b82f6;
            transition: all 0.2s ease;
        }

        .btn-view:hover {
            background-color: #3b82f6;
            color: #ffffff;
        }

        .empty-data {
            text-align: center;
            padding: 80px 40px;
            color: #94a3b8;
            background: white;
            font-size: 15px;
        }

        .empty-icon {
            margin-bottom: 16px;
            color: #cbd5e1;
        }
    </style>
</head>

<body>

    @include('admin.sidebar')

    <main class="main-content">

        <div class="page-header">
            <h1>Log Riwayat Kondisi</h1>
            <p>Daftar historis pencatatan data lapangan terkait kondisi kekeringan di setiap wilayah.</p>
        </div>

        <!-- Filter Form -->
        <div class="filter-card">
            <form method="GET" action="{{ route('admin.riwayat_kondisi') }}">
                <div class="filter-grid">
                    
                    <!-- Search Lokasi -->
                    <div class="filter-group">
                        <label class="filter-label">Lokasi</label>
                        <div class="filter-input-wrapper">
                            <span class="filter-icon-left">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            </span>
                            <input type="text" name="search" class="filter-input" placeholder="Cari Kelurahan atau Kecamatan..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <!-- Filter Kondisi Air -->
                    <div class="filter-group">
                        <label class="filter-label">Kondisi Air</label>
                        <div class="filter-input-wrapper">
                            <span class="filter-icon-left">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path></svg>
                            </span>
                            <select name="kondisi" class="filter-select">
                                <option value="Semua Kondisi">Semua Kondisi</option>
                                <option value="Sedang" {{ request('kondisi') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="Tinggi" {{ request('kondisi') == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                                <option value="Kritis" {{ request('kondisi') == 'Kritis' ? 'selected' : '' }}>Kritis</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn-filter primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        Filter Data
                    </button>

                </div>
            </form>
        </div>

        <!-- Stats Pills -->
        <div class="stats-pills">
            <div class="stat-pill pill-blue">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                Total: {{ $totalLaporan }} Laporan
            </div>
            <div class="stat-pill pill-yellow">
                <span class="dot"></span>
                Sedang: {{ $sedangCount }}
            </div>
            <div class="stat-pill pill-orange">
                <span class="dot"></span>
                Tinggi: {{ $tinggiCount }}
            </div>
            <div class="stat-pill pill-red">
                <span class="dot"></span>
                Kritis: {{ $kritisCount }}
            </div>
        </div>

        <!-- Data Section -->
        <div class="data-container">
            <div class="data-header">
                <div class="data-header-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Riwayat Pencatatan Kondisi Wilayah
                </div>
                <div class="data-count-badge">
                    {{ $laporans->count() }} data ditemukan
                </div>
            </div>

            @if($laporans->count())
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Laporan</th>
                                <th>Lokasi</th>
                                <th>Warga Terdampak</th>
                                <th>Durasi</th>
                                <th>Kondisi Air</th>
                                <th>Tingkat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporans as $lap)
                                <tr>
                                    <td>
                                        <div class="table-laporan-info">
                                            <span class="table-laporan-id">{{ $lap->kode ?? 'R'.str_pad($lap->id, 3, '0', STR_PAD_LEFT) }}</span>
                                            <span class="table-laporan-date">{{ formatTanggalIndo($lap->created_at) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="table-laporan-info">
                                            <span class="table-laporan-id">{{ $lap->kelurahan }}</span>
                                            <span class="table-laporan-date">Kec. {{ $lap->kecamatan }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $lap->warga_terdampak }} Jiwa</td>
                                    <td>{{ $lap->durasi_kekeringan }} Hari</td>
                                    <td>{{ $lap->kondisi_air }}</td>
                                    <td>
                                        @if(strtolower($lap->tingkat) == 'kritis')
                                            <span class="status-badge status-kritis">Kritis</span>
                                        @elseif(strtolower($lap->tingkat) == 'tinggi')
                                            <span class="status-badge status-tinggi">Tinggi</span>
                                        @else
                                            <span class="status-badge status-sedang">Sedang</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.history.detail', $lap->id) }}" class="btn-view" title="Lihat Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-data">
                    <svg class="empty-icon" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path></svg>
                    <div style="font-weight: 600; font-size: 18px; color: #334155; margin-bottom: 8px;">Tidak Ada Data Ditemukan</div>
                    <div>Tidak ada riwayat kondisi yang sesuai dengan filter yang diterapkan.</div>
                </div>
            @endif
        </div>

    </main>

</body>

</html>
