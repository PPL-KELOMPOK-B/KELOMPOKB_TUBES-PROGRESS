<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWM - Riwayat Kondisi</title>
    <meta name="description" content="Daftar historis pencatatan data lapangan terkait kondisi kekeringan di setiap wilayah.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;1,14..32,400&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-color: #f8fafc;
            --text-dark: #0f172a;
            --text-gray: #64748b;
            --border: #e2e8f0;
            --card-radius: 16px;
            --primary: #2563eb;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: var(--bg-color);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            flex: 1;
            padding: 40px;
            margin-left: 260px;
            min-width: 0;
        }

        /* ========== PAGE HEADER ========== */
        .page-header {
            margin-bottom: 28px;
        }

        .page-header h1 {
            font-size: 26px;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: -0.3px;
            margin-bottom: 6px;
        }

        .page-header p {
            margin: 0;
            color: var(--text-gray);
            font-size: 14px;
            line-height: 1.6;
        }

        /* ========== FILTER BAR ========== */
        .filter-bar {
            display: flex;
            align-items: flex-end;
            gap: 16px;
            margin-bottom: 24px;
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex: 1;
        }

        .filter-group.kondisi-group {
            flex: 0 0 260px;
        }

        .filter-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-gray);
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            color: #94a3b8;
            pointer-events: none;
            display: flex;
            align-items: center;
        }

        .filter-input,
        .filter-select {
            width: 100%;
            padding: 10px 12px 10px 40px;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            background: #ffffff;
            color: var(--text-dark);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .filter-input::placeholder { color: #94a3b8; }

        .filter-input:focus,
        .filter-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
        }

        .filter-select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3E%3C/svg%3E");
            background-position: right 10px center;
            background-repeat: no-repeat;
            background-size: 18px;
            cursor: pointer;
        }

        .btn-filter {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 20px;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 2px 6px rgba(37,99,235,0.25);
        }

        .btn-primary:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37,99,235,0.3);
        }

        .btn-reset {
            background: #f1f5f9;
            color: #475569;
            border: 1.5px solid var(--border);
            text-decoration: none;
        }

        .btn-reset:hover {
            background: #e2e8f0;
            color: var(--text-dark);
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            align-self: flex-end;
        }

        /* ========== STATS SUMMARY ========== */
        .stats-row {
            display: flex;
            gap: 14px;
            margin-bottom: 20px;
        }

        .stat-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            border: 1.5px solid;
        }

        .stat-chip.total  { background: #eff6ff; color: #2563eb; border-color: #bfdbfe; }
        .stat-chip.aman   { background: #f0fdf4; color: #16a34a; border-color: #bbf7d0; }
        .stat-chip.waspada{ background: #fefce8; color: #ca8a04; border-color: #fde68a; }
        .stat-chip.siaga  { background: #fff7ed; color: #ea580c; border-color: #fed7aa; }
        .stat-chip.kritis { background: #fef2f2; color: #dc2626; border-color: #fecaca; }

        .stat-chip .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .dot-aman   { background: #22c55e; }
        .dot-waspada{ background: #eab308; }
        .dot-siaga  { background: #f97316; }
        .dot-kritis { background: #ef4444; }

        /* ========== TABLE CARD ========== */
        .table-card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: var(--card-radius);
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
            overflow: hidden;
        }

        .table-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px 16px;
            border-bottom: 1px solid var(--border);
        }

        .table-card-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-card-title svg {
            color: var(--primary);
        }

        .table-count {
            font-size: 13px;
            color: var(--text-gray);
            background: #f1f5f9;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 500;
        }

        /* ========== TABLE ========== */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead tr {
            background: #f8fafc;
        }

        .data-table th {
            padding: 13px 20px;
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .data-table td {
            padding: 15px 20px;
            font-size: 14px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .data-table tbody tr {
            transition: background 0.15s;
        }

        .data-table tbody tr:hover td {
            background: #fafbff;
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ========== TABLE CELLS ========== */

        /* Waktu Pencatatan */
        .time-primary {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            display: block;
        }

        .time-secondary {
            font-size: 12px;
            color: var(--text-gray);
            margin-top: 2px;
            display: block;
        }

        /* Wilayah */
        .wilayah-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            display: block;
        }

        .wilayah-sub {
            font-size: 12px;
            color: var(--text-gray);
            margin-top: 2px;
            display: block;
        }

        /* Petugas */
        .petugas-cell {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .petugas-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border: 1.5px solid #bfdbfe;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #3b82f6;
            flex-shrink: 0;
        }

        .petugas-name {
            font-size: 14px;
            font-weight: 500;
            color: #334155;
        }

        /* Kondisi Badge */
        .kondisi-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .kondisi-badge .badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .badge-aman    { background: #dcfce7; color: #15803d; }
        .badge-aman .badge-dot { background: #22c55e; }

        .badge-waspada { background: #fefce8; color: #a16207; }
        .badge-waspada .badge-dot { background: #eab308; }

        .badge-siaga   { background: #fff7ed; color: #c2410c; }
        .badge-siaga .badge-dot { background: #f97316; }

        .badge-kritis  { background: #fef2f2; color: #b91c1c; }
        .badge-kritis .badge-dot { background: #ef4444; }

        /* Dampak & Durasi */
        .dampak-primary {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            display: block;
        }

        .dampak-secondary {
            font-size: 12px;
            color: var(--text-gray);
            margin-top: 2px;
            display: block;
        }

        /* Keterangan */
        .keterangan-text {
            font-size: 13px;
            color: #64748b;
            max-width: 220px;
            line-height: 1.5;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        /* ========== EMPTY STATE ========== */
        .empty-state {
            text-align: center;
            padding: 70px 40px;
            color: #94a3b8;
        }

        .empty-state svg {
            margin-bottom: 16px;
            color: #cbd5e1;
        }

        .empty-state h3 {
            font-size: 17px;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 6px;
        }

        .empty-state p {
            font-size: 14px;
            color: #94a3b8;
        }

        /* ========== PAGINATION ========== */
        .pagination-wrapper {
            padding: 18px 24px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fafbfc;
        }

        .pagination-info {
            font-size: 13px;
            color: var(--text-gray);
        }

        .pagination-wrapper nav {
            display: flex;
        }

        .pagination-wrapper nav svg {
            width: 18px;
            height: 18px;
        }

        .pagination-wrapper nav .hidden {
            display: flex !important;
            align-items: center;
            gap: 5px;
        }

        .pagination-wrapper nav .hidden > div {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .pagination-wrapper nav a,
        .pagination-wrapper nav span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 500;
            border: 1.5px solid var(--border);
            border-radius: 7px;
            background: white;
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.2s;
        }

        .pagination-wrapper nav a:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }

        .pagination-wrapper nav span[aria-current="page"] {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            font-weight: 700;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1100px) {
            .filter-bar { flex-wrap: wrap; }
            .filter-group.kondisi-group { flex: 0 0 200px; }
            .stats-row { flex-wrap: wrap; }
        }

        @media (max-width: 768px) {
            .main-content { margin-left: 0; padding: 20px; }
            .filter-bar { flex-direction: column; }
            .filter-group.kondisi-group { flex: 1; }
        }
    </style>
</head>

<body>

    @include('admin.sidebar')

    <main class="main-content">

        {{-- Page Header --}}
        <div class="page-header">
            <h1>Log Riwayat Kondisi</h1>
            <p>Daftar historis pencatatan data lapangan terkait kondisi kekeringan di setiap wilayah.</p>
        </div>

        {{-- Filter Bar --}}
        <form method="GET" action="{{ route('admin.riwayat_kondisi') }}">
            <div class="filter-bar">
                {{-- Search Lokasi --}}
                <div class="filter-group">
                    <span class="filter-label">Lokasi</span>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        </span>
                        <input
                            type="text"
                            name="search"
                            class="filter-input"
                            placeholder="Cari Kelurahan atau Kecamatan..."
                            value="{{ request('search') }}"
                        >
                    </div>
                </div>

                {{-- Kondisi Air --}}
                <div class="filter-group kondisi-group">
                    <span class="filter-label">Kondisi Air</span>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                        </span>
                        <select name="kondisi" class="filter-select">
                            <option value="Semua Kondisi" {{ request('kondisi', 'Semua Kondisi') === 'Semua Kondisi' ? 'selected' : '' }}>Semua Kondisi</option>
                            <option value="Aman"    {{ request('kondisi') === 'Aman'    ? 'selected' : '' }}>Aman</option>
                            <option value="Waspada" {{ request('kondisi') === 'Waspada' ? 'selected' : '' }}>Waspada</option>
                            <option value="Siaga"   {{ request('kondisi') === 'Siaga'   ? 'selected' : '' }}>Siaga</option>
                            <option value="Kritis"  {{ request('kondisi') === 'Kritis'  ? 'selected' : '' }}>Kritis</option>
                        </select>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="filter-actions">
                    <button type="submit" class="btn-filter btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                        Filter Data
                    </button>
                    @if(request('search') || (request('kondisi') && request('kondisi') !== 'Semua Kondisi'))
                        <a href="{{ route('admin.riwayat_kondisi') }}" class="btn-filter btn-reset">Reset</a>
                    @endif
                </div>
            </div>
        </form>

        {{-- Stats Chips --}}
        @php
            $allForStats = \App\Models\Laporan::where('status', '!=', 'draft')->get();
            $countTotal  = $laporans->total();
            $countAman    = 0; $countWaspada = 0; $countSiaga = 0; $countKritis = 0;
            foreach ($allForStats as $lap) {
                if ($lap->kondisi_air === 'Ketersediaan air mulai berkurang') $countWaspada++;
                elseif ($lap->kondisi_air === 'Ketersediaan air tidak mencukupi') $countSiaga++;
                elseif ($lap->kondisi_air === 'Air tidak tersedia') $countKritis++;
                else $countAman++;
            }
        @endphp
        <div class="stats-row">
            <span class="stat-chip total">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Total: {{ $allForStats->count() }} Laporan
            </span>
            <span class="stat-chip aman">
                <span class="dot dot-aman"></span>
                Aman: {{ $countAman }}
            </span>
            <span class="stat-chip waspada">
                <span class="dot dot-waspada"></span>
                Waspada: {{ $countWaspada }}
            </span>
            <span class="stat-chip siaga">
                <span class="dot dot-siaga"></span>
                Siaga: {{ $countSiaga }}
            </span>
            <span class="stat-chip kritis">
                <span class="dot dot-kritis"></span>
                Kritis: {{ $countKritis }}
            </span>
        </div>

        {{-- Table Card --}}
        <div class="table-card">
            <div class="table-card-header">
                <div class="table-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Riwayat Pencatatan Kondisi Wilayah
                </div>
                <span class="table-count">{{ $laporans->total() }} data ditemukan</span>
            </div>

            @if($laporans->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>WAKTU PENCATATAN</th>
                                <th>WILAYAH</th>
                                <th>PETUGAS PELAPOR</th>
                                <th>KONDISI TERCATAT</th>
                                <th>DAMPAK &amp; DURASI</th>
                                <th>KETERANGAN TAMBAHAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporans as $laporan)
                                @php
                                    // Map kondisi_air to badge label + class
                                    $kondisiAir = $laporan->kondisi_air ?? '';
                                    if ($kondisiAir === 'Ketersediaan air mulai berkurang') {
                                        $kondisiLabel = 'Waspada';
                                        $kondisiClass = 'badge-waspada';
                                    } elseif ($kondisiAir === 'Ketersediaan air tidak mencukupi') {
                                        $kondisiLabel = 'Siaga';
                                        $kondisiClass = 'badge-siaga';
                                    } elseif ($kondisiAir === 'Air tidak tersedia') {
                                        $kondisiLabel = 'Kritis';
                                        $kondisiClass = 'badge-kritis';
                                    } else {
                                        $kondisiLabel = 'Aman';
                                        $kondisiClass = 'badge-aman';
                                    }

                                    // Format kecamatan
                                    $kecamatan = str_replace('Petugas ', '', $laporan->kecamatan ?? '');

                                    // Format petugas name
                                    $petugasName = $laporan->user->name ?? 'Petugas';
                                @endphp
                                <tr>
                                    {{-- Waktu Pencatatan --}}
                                    <td>
                                        <span class="time-primary">
                                            {{ $laporan->created_at->locale('id')->translatedFormat('d M Y') }}
                                        </span>
                                        <span class="time-secondary">
                                            {{ $laporan->created_at->timezone('Asia/Jakarta')->format('H:i') }} WIB
                                        </span>
                                    </td>

                                    {{-- Wilayah --}}
                                    <td>
                                        <span class="wilayah-name">Kel. {{ $laporan->kelurahan ?? '-' }}</span>
                                        <span class="wilayah-sub">Kec. {{ $kecamatan ?: '-' }}</span>
                                    </td>

                                    {{-- Petugas Pelapor --}}
                                    <td>
                                        <div class="petugas-cell">
                                            <div class="petugas-avatar">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                                    <circle cx="12" cy="7" r="4"/>
                                                </svg>
                                            </div>
                                            <span class="petugas-name">{{ $petugasName }}</span>
                                        </div>
                                    </td>

                                    {{-- Kondisi Tercatat --}}
                                    <td>
                                        <span class="kondisi-badge {{ $kondisiClass }}">
                                            <span class="badge-dot"></span>
                                            {{ $kondisiLabel }}
                                        </span>
                                    </td>

                                    {{-- Dampak & Durasi --}}
                                    <td>
                                        <span class="dampak-primary">
                                            {{ number_format($laporan->warga_terdampak ?? 0) }} warga terdampak
                                        </span>
                                        <span class="dampak-secondary">
                                            {{ $laporan->durasi_kekeringan ?? 0 }} hari kekeringan
                                        </span>
                                    </td>

                                    {{-- Keterangan Tambahan --}}
                                    <td>
                                        <div class="keterangan-text" title="{{ $laporan->keterangan }}">
                                            {{ $laporan->keterangan ?? '-' }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($laporans->hasPages())
                    <div class="pagination-wrapper">
                        <span class="pagination-info">
                            Menampilkan {{ $laporans->firstItem() }}–{{ $laporans->lastItem() }} dari {{ $laporans->total() }} data
                        </span>
                        <div>
                            {{ $laporans->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif

            @else
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <h3>Tidak Ada Data Ditemukan</h3>
                    <p>Tidak ada riwayat kondisi yang sesuai dengan filter yang diterapkan.</p>
                </div>
            @endif
        </div>

    </main>

</body>
</html>
