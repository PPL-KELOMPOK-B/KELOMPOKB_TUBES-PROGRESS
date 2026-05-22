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
            --card-radius: 12px;
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

        /* ================= SIDEBAR ================= */

        .sidebar {
            width: 260px;
            background: white;
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .profile-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: #eff6ff;
            border-radius: 10px;
            margin-bottom: 32px;
        }

        .profile-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #3b82f6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .profile-info h4 {
            margin: 0;
            font-size: 14px;
        }

        .profile-info p {
            margin: 0;
            color: #64748b;
            font-size: 12px;
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
            text-decoration: none;
            color: #475569;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
        }

        .nav-link:hover {
            background: #f1f5f9;
        }

        .nav-link.active {
            background: #eff6ff;
            color: #2563eb;
        }

        .nav-icon {
            width: 18px;
            height: 18px;
        }

        /* ================= MAIN ================= */

        .main-content {
            flex: 1;
            padding: 40px;
        }

        .page-header {
            margin-bottom: 24px;
        }

        .page-header h1 {
            margin: 0;
            font-size: 28px;
        }

        .page-header p {
            margin-top: 6px;
            color: var(--text-gray);
        }

        /* ================= FILTER ================= */

        .filter-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--card-radius);
            padding: 20px;
            margin-bottom: 24px;
        }

        .filter-form {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .filter-form input,
        .filter-form select {
            padding: 10px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            min-width: 220px;
        }

        .btn {
            border: none;
            cursor: pointer;
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #334155;
            text-decoration: none;
        }

        /* ================= TABLE ================= */

        .history-list {
            display: grid;
            gap: 18px;
        }

        .history-card {
            background: white;
            border-radius: 20px;
            border: 1px solid var(--border);
            padding: 26px;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.05);
        }

        .history-card-header {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 18px;
        }

        .history-title {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .history-subtitle {
            margin-top: 6px;
            color: #475569;
            font-size: 14px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge.sedang {
            background: #fefce8;
            color: #a16207;
        }

        .badge.tinggi {
            background: #fff7ed;
            color: #ea580c;
        }

        .badge.kritis {
            background: #fee2e2;
            color: #b91c1c;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            color: #334155;
            background: #eef2ff;
            text-transform: capitalize;
        }

        .history-meta {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 18px;
            color: #475569;
            font-size: 14px;
        }

        .history-card-body {
            background: #f8fbff;
            border-radius: 16px;
            padding: 20px;
            color: #0f172a;
        }

        .history-card-body h3 {
            margin: 0 0 10px 0;
            font-size: 15px;
        }

        .history-card-body p {
            margin: 0;
            line-height: 1.75;
        }

        .history-card-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn-detail {
            display: inline-flex;
            align-items: center;
            padding: 12px 20px;
            border-radius: 12px;
            text-decoration: none;
            color: white;
            background: #2563eb;
            font-weight: 600;
        }

        .pagination-wrapper {
            margin-top: 24px;
        }

        .empty-data {
            text-align: center;
            padding: 50px;
            color: #94a3b8;
            background: white;
            border-radius: 20px;
            border: 1px solid var(--border);
        }
    </style>
</head>

<body>

    @include('admin.sidebar')

    <main class="main-content">

        <div class="page-header">
            <h1>Log Aktivitas</h1>
            <p>Log Aktivitas</p>
        </div>

        <div class="filter-card">
            <form method="GET" action="{{ route('admin.history') }}" class="filter-form">
                <input type="text" name="search" placeholder="Cari kelurahan, kecamatan, status..."
                    value="{{ request('search') }}">

                <select name="tingkat">
                    <option value="">Semua Tingkat</option>
                    <option value="Sedang" {{ request('tingkat') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="Tinggi" {{ request('tingkat') == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                    <option value="Kritis" {{ request('tingkat') == 'Kritis' ? 'selected' : '' }}>Kritis</option>
                </select>

                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.history') }}" class="btn btn-secondary">Reset</a>
            </form>
        </div>

        <div class="history-list">
            @if($laporans->count())
                @foreach($laporans as $laporan)
                    @php
                        $latestTindak = $laporan->tindakLanjuts->sortByDesc('tanggal')->first();
                    @endphp
                    <article class="history-card">
                        <div class="history-card-header">
                            <div>
                                <p class="history-title">{{ $laporan->kode }} - Desa {{ $laporan->kelurahan }}</p>
                                <p class="history-subtitle">Kecamatan {{ $laporan->kecamatan }}</p>
                            </div>
                            <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:center;">
                                <span class="badge {{ strtolower($laporan->tingkat_kekeringan) }}">{{ $laporan->tingkat_kekeringan }}</span>
                                <span class="status-pill">{{ ucfirst(str_replace('_', ' ', $laporan->status)) }}</span>
                            </div>
                        </div>

                        <div class="history-meta">
                            <div><strong>Tanggal:</strong> {{ $laporan->created_at->format('d M Y') }}</div>
                            <div><strong>Skor:</strong> {{ number_format($laporan->skor_prioritas,2) }}</div>
                            <div><strong>Status Laporan:</strong> {{ ucfirst(str_replace('_', ' ', $laporan->status)) }}</div>
                        </div>

                        <div class="history-card-body">
                            <h3>Tindak Lanjut</h3>
                            @if($latestTindak)
                                <p>{{ $latestTindak->deskripsi_aksi }}</p>
                                <p style="margin-top:10px;font-size:13px;color:#475569;"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($latestTindak->tanggal)->format('d M Y') }}</p>
                                <p style="margin:0;font-size:13px;color:#475569;"><strong>Status:</strong> {{ $latestTindak->status }}</p>
                            @else
                                <p>Belum ada tindak lanjut.</p>
                            @endif
                        </div>

                        <div class="history-card-footer">
                            <a href="{{ route('admin.history.detail', $laporan->id) }}" class="btn-detail">Lihat Detail</a>
                        </div>
                    </article>
                @endforeach
            @else
                <div class="empty-data">
                    Tidak ada data riwayat laporan.
                </div>
            @endif
        </div>

        <div class="pagination-wrapper">
            {{ $laporans->links() }}
        </div>

    </main>

</body>
</html>